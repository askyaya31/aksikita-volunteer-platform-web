<?php
$pageTitle = 'Daftar Kegiatan — AksiKita';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$db = getDB();

// ── Handle DELETE ──────────────────────────────────────────────
if (isset($_GET['hapus']) && ctype_digit((string)$_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $stmt = $db->prepare("DELETE FROM kegiatan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    redirect('kegiatan.php?msg=hapus');
}

// ── Flash Message ──────────────────────────────────────────────
$flash = isset($_GET['msg']) ? flashMsg($_GET['msg']) : [];

// ── Filter & Search ────────────────────────────────────────────
$filterStatus = $db->real_escape_string($_GET['status']   ?? '');
$filterKat    = $db->real_escape_string($_GET['kategori'] ?? '');
$search       = $db->real_escape_string(trim($_GET['cari'] ?? ''));

$where = "1=1";
if ($filterStatus) $where .= " AND status = '$filterStatus'";
if ($filterKat)    $where .= " AND kategori = '$filterKat'";
if ($search)       $where .= " AND (judul LIKE '%$search%' OR lokasi LIKE '%$search%' OR deskripsi LIKE '%$search%')";

// ── Sorting ────────────────────────────────────────────────────
$sortMap = ['tanggal' => 'tanggal DESC', 'judul' => 'judul ASC', 'peserta' => 'peserta DESC', 'terbaru' => 'id DESC'];
$sort    = $_GET['sort'] ?? 'terbaru';
$orderBy = $sortMap[$sort] ?? 'id DESC';

$result = $db->query("SELECT * FROM kegiatan WHERE $where ORDER BY $orderBy");
$count  = $result->num_rows;

require_once '../includes/header.php';
?>

<div class="container">

    <div class="page-header">
        <div>
            <h1>📋 Daftar Kegiatan</h1>
            <p>Kelola semua kegiatan aksi sosial &mdash; <?= $count ?> data ditemukan</p>
        </div>
        <a href="tambah.php" class="btn btn-primary">➕ Tambah Kegiatan</a>
    </div>

    <?php if ($flash): ?>
    <div class="alert alert-<?= $flash[1] ?>"><?= $flash[0] ?></div>
    <?php endif; ?>

    <!-- FILTER BAR -->
    <form method="GET" class="filter-bar">
        <div class="fg" style="flex:1;min-width:180px;">
            <label>🔍 Cari</label>
            <input type="text" name="cari" placeholder="Judul, lokasi, atau deskripsi..."
                   value="<?= sanitize($_GET['cari'] ?? '') ?>" style="width:100%;">
        </div>
        <div class="fg">
            <label>Status</label>
            <select name="status">
                <option value="">Semua Status</option>
                <?php foreach (['Akan Datang','Berlangsung','Selesai'] as $s): ?>
                <option value="<?= $s ?>" <?= ($filterStatus === $s ? 'selected' : '') ?>><?= $s ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="fg">
            <label>Kategori</label>
            <select name="kategori">
                <option value="">Semua Kategori</option>
                <?php foreach (['Lingkungan','Sosial','Pendidikan','Kesehatan','Lainnya'] as $k): ?>
                <option value="<?= $k ?>" <?= ($filterKat === $k ? 'selected' : '') ?>><?= $k ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="fg">
            <label>Urutkan</label>
            <select name="sort">
                <option value="terbaru" <?= $sort==='terbaru'?'selected':'' ?>>Terbaru</option>
                <option value="tanggal" <?= $sort==='tanggal'?'selected':'' ?>>Tanggal Kegiatan</option>
                <option value="judul"   <?= $sort==='judul'  ?'selected':'' ?>>Nama A–Z</option>
                <option value="peserta" <?= $sort==='peserta'?'selected':'' ?>>Peserta Terbanyak</option>
            </select>
        </div>
        <div style="display:flex;gap:.5rem;align-items:flex-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="kegiatan.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- TABLE -->
    <div class="card">
        <?php if ($count === 0): ?>
            <div class="empty">
                <div class="empty-icon">🔍</div>
                <h3>Tidak Ada Hasil</h3>
                <p>Tidak ada kegiatan yang cocok dengan filter Anda.<br>Coba reset filter atau <a href="tambah.php" style="color:var(--forest);font-weight:600;">tambah kegiatan baru</a>.</p>
            </div>
        <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px">#</th>
                        <th>Judul Kegiatan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th style="text-align:center">Peserta</th>
                        <th style="text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="text-muted" style="font-size:.78rem;"><?= $no++ ?></td>
                        <td style="max-width:240px;">
                            <div class="fw-bold" style="line-height:1.4;"><?= sanitize($row['judul']) ?></div>
                            <?php if ($row['deskripsi']): ?>
                            <div class="text-sub" style="margin-top:.15rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:220px;">
                                <?= sanitize(substr($row['deskripsi'], 0, 80)) ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td><?= badgeKategori($row['kategori']) ?></td>
                        <td class="text-sub" style="white-space:nowrap;"><?= formatTanggal($row['tanggal']) ?></td>
                        <td class="text-sub" style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            📍 <?= sanitize($row['lokasi']) ?>
                        </td>
                        <td><?= badgeStatus($row['status']) ?></td>
                        <td style="text-align:center;font-weight:700;color:var(--forest);">
                            <?= number_format($row['peserta']) ?>
                        </td>
                        <td>
                            <div style="display:flex;gap:.35rem;justify-content:center;flex-wrap:wrap;">
                                <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-ghost btn-sm" title="Detail">👁</a>
                                <a href="edit.php?id=<?= $row['id'] ?>"   class="btn btn-warning btn-sm" title="Edit">✏️</a>
                                <a href="kegiatan.php?hapus=<?= $row['id'] ?>"
                                   class="btn btn-danger btn-sm" title="Hapus"
                                   onclick="return confirm('Yakin ingin menghapus kegiatan ini?\n\nAksi ini tidak dapat dibatalkan.')">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="table-meta">
            <?php if ($filterStatus || $filterKat || $search): ?>
                Menampilkan <strong><?= $count ?></strong> kegiatan sesuai filter
                &mdash; <a href="kegiatan.php" style="color:var(--forest);">Lihat semua</a>
            <?php else: ?>
                Total <strong><?= $count ?></strong> kegiatan tercatat
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

</div>

<?php require_once '../includes/footer.php'; ?>

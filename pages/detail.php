<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$db = getDB();
$id = (int)($_GET['id'] ?? 0);
if (!$id) redirect('kegiatan.php');

$row = $db->query("SELECT * FROM kegiatan WHERE id = $id")->fetch_assoc();
if (!$row) redirect('kegiatan.php');

$pageTitle = sanitize($row['judul']) . ' — AksiKita';
require_once '../includes/header.php';
?>

<div class="container-sm">

    <!-- Breadcrumb -->
    <div style="display:flex;align-items:center;gap:.5rem;font-size:.8rem;color:var(--ink-lt);margin-bottom:1.5rem;">
        <a href="../index.php" style="color:var(--ink-lt);text-decoration:none;hover:color:var(--ink)">Beranda</a>
        <span>/</span>
        <a href="kegiatan.php" style="color:var(--ink-lt);text-decoration:none;">Kegiatan</a>
        <span>/</span>
        <span style="color:var(--ink-mid);"><?= sanitize(substr($row['judul'], 0, 40)) ?>...</span>
    </div>

    <div class="page-header">
        <div>
            <h1>👁 Detail Kegiatan</h1>
            <p>Informasi lengkap tentang kegiatan ini</p>
        </div>
        <a href="kegiatan.php" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card">
        <!-- Top section: judul + badges + aksi -->
        <div style="padding:1.75rem 1.75rem 1.25rem;border-bottom:1px solid var(--border);">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
                <div style="flex:1;min-width:0;">
                    <h2 style="font-family:'Fraunces',serif;font-size:1.6rem;font-weight:700;line-height:1.25;letter-spacing:-.02em;margin-bottom:.75rem;color:var(--ink);">
                        <?= sanitize($row['judul']) ?>
                    </h2>
                    <div style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">
                        <?= badgeKategori($row['kategori']) ?>
                        <?= badgeStatus($row['status']) ?>
                        <span class="text-sub" style="font-size:.78rem;">ID #<?= $row['id'] ?></span>
                    </div>
                </div>
                <div style="display:flex;gap:.5rem;flex-shrink:0;flex-wrap:wrap;">
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning">✏️ Edit</a>
                    <a href="kegiatan.php?hapus=<?= $row['id'] ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Yakin ingin menghapus kegiatan ini?\n\nAksi ini tidak dapat dibatalkan.')">🗑️ Hapus</a>
                </div>
            </div>
        </div>

        <!-- Detail grid -->
        <div style="padding:1.5rem 1.75rem;">
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="label">📅 Tanggal Kegiatan</span>
                    <span class="value"><?= formatTanggal($row['tanggal']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">👥 Jumlah Peserta</span>
                    <span class="value" style="color:var(--forest);font-size:1.15rem;">
                        <?= number_format($row['peserta']) ?> orang
                    </span>
                </div>
                <div class="detail-item" style="grid-column:1/-1;">
                    <span class="label">📍 Lokasi</span>
                    <span class="value"><?= sanitize($row['lokasi']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">🏷️ Kategori</span>
                    <span class="value"><?= iconKategori($row['kategori']) ?> <?= sanitize($row['kategori']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">📊 Status</span>
                    <span class="value"><?= sanitize($row['status']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">🕐 Ditambahkan</span>
                    <span class="value"><?= date('d M Y, H:i', strtotime($row['created_at'])) ?> WIB</span>
                </div>
            </div>

            <?php if (trim($row['deskripsi'])): ?>
            <div class="detail-desc" style="margin-top:1.25rem;">
                <span class="label">📝 Deskripsi Kegiatan</span>
                <p style="color:var(--ink);line-height:1.8;font-size:.925rem;margin-top:.5rem;">
                    <?= nl2br(sanitize($row['deskripsi'])) ?>
                </p>
            </div>
            <?php else: ?>
            <div style="margin-top:1.25rem;padding:1rem;background:var(--cream);border-radius:var(--radius-sm);text-align:center;color:var(--ink-lt);font-size:.85rem;font-style:italic;">
                Tidak ada deskripsi untuk kegiatan ini
            </div>
            <?php endif; ?>

            <div class="divider"></div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary">✏️ Edit Kegiatan</a>
                <a href="tambah.php" class="btn btn-secondary">➕ Tambah Baru</a>
                <a href="kegiatan.php" class="btn btn-ghost">📋 Semua Kegiatan</a>
            </div>
        </div>
    </div>

    <!-- Nav prev / next -->
    <?php
    $prev = $db->query("SELECT id, judul FROM kegiatan WHERE id < $id ORDER BY id DESC LIMIT 1")->fetch_assoc();
    $next = $db->query("SELECT id, judul FROM kegiatan WHERE id > $id ORDER BY id ASC  LIMIT 1")->fetch_assoc();
    if ($prev || $next):
    ?>
    <div style="display:flex;justify-content:space-between;margin-top:1.25rem;gap:1rem;">
        <div>
            <?php if ($prev): ?>
            <a href="detail.php?id=<?= $prev['id'] ?>" class="btn btn-secondary btn-sm">
                ← <?= sanitize(mb_substr($prev['judul'], 0, 35)) ?>
            </a>
            <?php endif; ?>
        </div>
        <div>
            <?php if ($next): ?>
            <a href="detail.php?id=<?= $next['id'] ?>" class="btn btn-secondary btn-sm">
                <?= sanitize(mb_substr($next['judul'], 0, 35)) ?> →
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php require_once '../includes/footer.php'; ?>

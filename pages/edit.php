<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$db = getDB();
$id = (int)($_GET['id'] ?? 0);
if (!$id) redirect('kegiatan.php');

$row = $db->query("SELECT * FROM kegiatan WHERE id = $id")->fetch_assoc();
if (!$row) redirect('kegiatan.php');

$pageTitle = 'Edit: ' . htmlspecialchars($row['judul']) . ' — AksiKita';
$errors    = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul     = trim($_POST['judul']     ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $kategori  = $_POST['kategori']  ?? '';
    $lokasi    = trim($_POST['lokasi'] ?? '');
    $tanggal   = $_POST['tanggal']   ?? '';
    $status    = $_POST['status']    ?? '';
    $peserta   = max(0, (int)($_POST['peserta'] ?? 0));

    // Validasi
    if (!$judul)   $errors[] = 'Judul kegiatan wajib diisi.';
    if (!$tanggal || !strtotime($tanggal)) $errors[] = 'Tanggal kegiatan tidak valid.';
    if (!$lokasi)  $errors[] = 'Lokasi kegiatan wajib diisi.';
    if (!in_array($kategori, ['Lingkungan','Sosial','Pendidikan','Kesehatan','Lainnya']))
        $errors[] = 'Pilih kategori yang valid.';
    if (!in_array($status, ['Akan Datang','Berlangsung','Selesai']))
        $errors[] = 'Pilih status yang valid.';

    if (empty($errors)) {
        $stmt = $db->prepare(
            "UPDATE kegiatan SET judul=?, deskripsi=?, kategori=?, lokasi=?, tanggal=?, status=?, peserta=?
             WHERE id=?"
        );
        $stmt->bind_param("ssssssii", $judul, $deskripsi, $kategori, $lokasi, $tanggal, $status, $peserta, $id);
        $stmt->execute();
        redirect('kegiatan.php?msg=edit');
    }

    // Tampilkan data POST bila ada error
    $row = array_merge($row, $_POST);
}

require_once '../includes/header.php';
?>

<div class="container-sm">

    <div class="page-header">
        <div>
            <h1>✏️ Edit Kegiatan</h1>
            <p>Perbarui informasi kegiatan yang sudah ada</p>
        </div>
        <div class="page-header-actions">
            <a href="detail.php?id=<?= $id ?>" class="btn btn-secondary">👁 Lihat Detail</a>
            <a href="kegiatan.php" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>

    <?php if ($errors): ?>
    <div class="alert alert-error">
        <div>
            <strong>Terdapat <?= count($errors) ?> kesalahan:</strong>
            <ul style="margin:.35rem 0 0 1.1rem;">
                <?php foreach ($errors as $e): ?>
                <li><?= sanitize($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <!-- Info kegiatan saat ini -->
    <div style="background:var(--cream);border:1px solid var(--border);border-radius:var(--radius);padding:.85rem 1.1rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.75rem;font-size:.85rem;color:var(--ink-mid);">
        🔖 Mengedit: <strong style="color:var(--ink)"><?= sanitize($row['judul']) ?></strong>
        &mdash; <?= badgeKategori($row['kategori']) ?> <?= badgeStatus($row['status']) ?>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>📝 Informasi Kegiatan</h3>
            <span class="text-sub">ID: #<?= $id ?></span>
        </div>
        <div class="card-body">
            <form method="POST" novalidate>
                <div class="form-grid">

                    <div class="form-group full">
                        <label>Judul Kegiatan <span style="color:var(--coral)">*</span></label>
                        <input type="text" name="judul" maxlength="255"
                               value="<?= sanitize($row['judul']) ?>" required autofocus>
                    </div>

                    <div class="form-group">
                        <label>Kategori <span style="color:var(--coral)">*</span></label>
                        <select name="kategori" required>
                            <?php foreach (['Lingkungan','Sosial','Pendidikan','Kesehatan','Lainnya'] as $k): ?>
                            <option value="<?= $k ?>" <?= $row['kategori'] === $k ? 'selected' : '' ?>>
                                <?= iconKategori($k) ?> <?= $k ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status Kegiatan <span style="color:var(--coral)">*</span></label>
                        <select name="status" required>
                            <?php foreach (['Akan Datang','Berlangsung','Selesai'] as $s): ?>
                            <option value="<?= $s ?>" <?= $row['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Kegiatan <span style="color:var(--coral)">*</span></label>
                        <input type="date" name="tanggal"
                               value="<?= sanitize($row['tanggal']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Peserta</label>
                        <input type="number" name="peserta" min="0" max="100000"
                               value="<?= (int)$row['peserta'] ?>">
                    </div>

                    <div class="form-group full">
                        <label>Lokasi <span style="color:var(--coral)">*</span></label>
                        <input type="text" name="lokasi" maxlength="255"
                               value="<?= sanitize($row['lokasi']) ?>" required>
                    </div>

                    <div class="form-group full">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi"><?= sanitize($row['deskripsi']) ?></textarea>
                    </div>

                </div>

                <div class="divider"></div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">💾 Simpan Perubahan</button>
                    <a href="detail.php?id=<?= $id ?>" class="btn btn-secondary btn-lg">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>

<?php require_once '../includes/footer.php'; ?>

<?php
$pageTitle = 'Tambah Kegiatan — AksiKita';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$errors = [];
$old    = [
    'judul'     => '',
    'deskripsi' => '',
    'kategori'  => '',
    'lokasi'    => '',
    'tanggal'   => date('Y-m-d'),
    'status'    => 'Akan Datang',
    'peserta'   => 0,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = array_merge($old, $_POST);

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
    if (strlen($judul) > 255) $errors[] = 'Judul terlalu panjang (maks. 255 karakter).';

    if (empty($errors)) {
        $db = getDB();
        $stmt = $db->prepare(
            "INSERT INTO kegiatan (judul, deskripsi, kategori, lokasi, tanggal, status, peserta)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssssi", $judul, $deskripsi, $kategori, $lokasi, $tanggal, $status, $peserta);
        $stmt->execute();
        redirect('kegiatan.php?msg=tambah');
    }
}

require_once '../includes/header.php';
?>

<div class="container-sm">

    <div class="page-header">
        <div>
            <h1>➕ Tambah Kegiatan</h1>
            <p>Isi formulir berikut untuk menambahkan kegiatan baru</p>
        </div>
        <a href="kegiatan.php" class="btn btn-secondary">← Kembali</a>
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

    <div class="card">
        <div class="card-header">
            <h3>📝 Informasi Kegiatan</h3>
        </div>
        <div class="card-body">
            <form method="POST" novalidate>
                <div class="form-grid">

                    <div class="form-group full">
                        <label>Judul Kegiatan <span style="color:var(--coral)">*</span></label>
                        <input type="text" name="judul" maxlength="255"
                               placeholder="Contoh: Aksi Bersih Pantai Parangtritis"
                               value="<?= sanitize($old['judul']) ?>" required
                               autofocus>
                        <span class="form-hint">Maksimal 255 karakter</span>
                    </div>

                    <div class="form-group">
                        <label>Kategori <span style="color:var(--coral)">*</span></label>
                        <select name="kategori" required>
                            <option value="">— Pilih Kategori —</option>
                            <?php foreach (['Lingkungan','Sosial','Pendidikan','Kesehatan','Lainnya'] as $k): ?>
                            <option value="<?= $k ?>" <?= $old['kategori'] === $k ? 'selected' : '' ?>>
                                <?= iconKategori($k) ?> <?= $k ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status Kegiatan <span style="color:var(--coral)">*</span></label>
                        <select name="status" required>
                            <option value="">— Pilih Status —</option>
                            <?php foreach (['Akan Datang','Berlangsung','Selesai'] as $s): ?>
                            <option value="<?= $s ?>" <?= $old['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Kegiatan <span style="color:var(--coral)">*</span></label>
                        <input type="date" name="tanggal"
                               value="<?= sanitize($old['tanggal']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Peserta</label>
                        <input type="number" name="peserta" min="0" max="100000"
                               placeholder="0" value="<?= (int)$old['peserta'] ?>">
                        <span class="form-hint">Estimasi atau jumlah aktual peserta</span>
                    </div>

                    <div class="form-group full">
                        <label>Lokasi <span style="color:var(--coral)">*</span></label>
                        <input type="text" name="lokasi" maxlength="255"
                               placeholder="Contoh: Pantai Parangtritis, Yogyakarta"
                               value="<?= sanitize($old['lokasi']) ?>" required>
                    </div>

                    <div class="form-group full">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi"
                                  placeholder="Ceritakan tentang kegiatan ini — tujuan, aktivitas yang dilakukan, siapa yang bisa ikut, dll."><?= sanitize($old['deskripsi']) ?></textarea>
                    </div>

                </div>

                <div class="divider"></div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">✅ Simpan Kegiatan</button>
                    <a href="kegiatan.php" class="btn btn-secondary btn-lg">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>

<?php require_once '../includes/footer.php'; ?>

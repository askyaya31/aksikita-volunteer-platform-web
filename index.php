<?php
$pageTitle = 'AksiKita — Platform Kegiatan Sosial';
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

$db = getDB();

// Stats
$total      = (int)$db->query("SELECT COUNT(*) AS n FROM kegiatan")->fetch_assoc()['n'];
$berlangsung= (int)$db->query("SELECT COUNT(*) AS n FROM kegiatan WHERE status='Berlangsung'")->fetch_assoc()['n'];
$akandatang = (int)$db->query("SELECT COUNT(*) AS n FROM kegiatan WHERE status='Akan Datang'")->fetch_assoc()['n'];
$selesai    = (int)$db->query("SELECT COUNT(*) AS n FROM kegiatan WHERE status='Selesai'")->fetch_assoc()['n'];
$totalPeserta = (int)($db->query("SELECT SUM(peserta) AS n FROM kegiatan")->fetch_assoc()['n'] ?? 0);

// Recent 6
$recent = $db->query("SELECT * FROM kegiatan ORDER BY created_at DESC, id DESC LIMIT 6");
?>

<div class="container">

    <!-- HERO -->
    <div class="hero">
        <div class="hero-tag">🌏 Platform Aksi Sosial</div>
        <h1>Bersama Kita<br><em>Bergerak</em> &amp; Berbuat</h1>
        <p>
            Catat, kelola, dan pantau semua kegiatan aksi sosial komunitas dalam satu dashboard yang rapi dan mudah digunakan.
        </p>
        <div class="hero-actions">
            <a href="pages/kegiatan.php" class="hero-btn hero-btn-white">📋 Lihat Semua Kegiatan</a>
            <a href="pages/tambah.php"   class="hero-btn hero-btn-amber">➕ Tambah Kegiatan Baru</a>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon si-green">📋</div>
            <div>
                <div class="stat-num"><?= number_format($total) ?></div>
                <div class="stat-label">Total Kegiatan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-amber">🔥</div>
            <div>
                <div class="stat-num"><?= number_format($berlangsung) ?></div>
                <div class="stat-label">Sedang Berlangsung</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-sky">🗓️</div>
            <div>
                <div class="stat-num"><?= number_format($akandatang) ?></div>
                <div class="stat-label">Akan Datang</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-coral">👥</div>
            <div>
                <div class="stat-num"><?= number_format($totalPeserta) ?></div>
                <div class="stat-label">Total Peserta</div>
            </div>
        </div>
    </div>

    <!-- RECENT KEGIATAN -->
    <div class="page-header">
        <div>
            <h1>Kegiatan Terbaru</h1>
            <p>6 kegiatan yang baru ditambahkan ke sistem</p>
        </div>
        <a href="pages/kegiatan.php" class="btn btn-secondary">Lihat Semua →</a>
    </div>

    <?php if ($recent->num_rows === 0): ?>
        <div class="card">
            <div class="empty">
                <div class="empty-icon">🌱</div>
                <h3>Belum Ada Kegiatan</h3>
                <p>Mulai tambahkan kegiatan pertama Anda!</p>
                <br>
                <a href="pages/tambah.php" class="btn btn-primary">➕ Tambah Kegiatan</a>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Judul Kegiatan</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th style="text-align:center">Peserta</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $recent->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div class="fw-bold"><?= sanitize($row['judul']) ?></div>
                                <div class="text-sub">📍 <?= sanitize($row['lokasi']) ?></div>
                            </td>
                            <td><?= badgeKategori($row['kategori']) ?></td>
                            <td style="white-space:nowrap" class="text-sub"><?= formatTanggal($row['tanggal']) ?></td>
                            <td><?= badgeStatus($row['status']) ?></td>
                            <td style="text-align:center;font-weight:600;color:var(--forest)"><?= number_format($row['peserta']) ?></td>
                            <td>
                                <a href="pages/detail.php?id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm">👁 Detail</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-meta">Menampilkan 6 kegiatan terbaru dari total <strong><?= $total ?></strong> kegiatan</div>
        </div>

        <!-- Kategori ringkasan -->
        <div style="margin-top:2.5rem;">
            <div class="page-header" style="margin-bottom:1rem;">
                <div>
                    <h1>Statistik Kategori</h1>
                    <p>Distribusi kegiatan berdasarkan kategori</p>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:.85rem;">
                <?php
                $cats = ['Lingkungan','Sosial','Pendidikan','Kesehatan','Lainnya'];
                foreach ($cats as $cat):
                    $n = (int)$db->query("SELECT COUNT(*) AS n FROM kegiatan WHERE kategori='" . $db->real_escape_string($cat) . "'")->fetch_assoc()['n'];
                    $pct = $total > 0 ? round($n / $total * 100) : 0;
                ?>
                <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:1.1rem 1.2rem;box-shadow:var(--shadow-sm);">
                    <div style="font-size:1.6rem;margin-bottom:.4rem;"><?= iconKategori($cat) ?></div>
                    <div style="font-weight:700;color:var(--ink);font-size:.95rem;"><?= $cat ?></div>
                    <div style="font-family:'Fraunces',serif;font-size:1.5rem;font-weight:700;color:var(--forest);line-height:1.2;"><?= $n ?></div>
                    <div style="font-size:.75rem;color:var(--ink-lt);margin-top:.15rem;"><?= $pct ?>% dari total</div>
                    <div style="height:4px;background:var(--cream-dark);border-radius:2px;margin-top:.75rem;overflow:hidden;">
                        <div style="height:100%;background:var(--forest-lt);border-radius:2px;width:<?= $pct ?>%;transition:.3s;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require_once 'includes/footer.php'; ?>

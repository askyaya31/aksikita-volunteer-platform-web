-- ============================================================
-- AksiKita Simple — Setup Database
-- Jalankan file ini sekali di phpMyAdmin atau MySQL CLI:
--   mysql -u root -p < setup.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS aksikita_simple
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE aksikita_simple;

-- Tabel utama: kegiatan
CREATE TABLE IF NOT EXISTS kegiatan (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    judul       VARCHAR(255) NOT NULL,
    deskripsi   TEXT,
    kategori    ENUM('Lingkungan','Sosial','Pendidikan','Kesehatan','Lainnya') DEFAULT 'Lainnya',
    lokasi      VARCHAR(255),
    tanggal     DATE NOT NULL,
    status      ENUM('Akan Datang','Berlangsung','Selesai') DEFAULT 'Akan Datang',
    peserta     INT UNSIGNED DEFAULT 0,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- DATA SAMPEL (dari AksiKita — kegiatan volunteer Indonesia)
-- ============================================================
INSERT INTO kegiatan (judul, deskripsi, kategori, lokasi, tanggal, status, peserta) VALUES
('Aksi Bersih-Bersih Pantai & Sungai',
 'Kegiatan fisik ringan di alam terbuka untuk kamu yang ingin bergerak aktif di akhir pekan sekaligus menyegarkan pikiran. Bersama-sama kita bersihkan pantai dan sungai dari sampah plastik.',
 'Lingkungan', 'Pantai & Sungai Regional, Jakarta', '2026-07-05', 'Akan Datang', 50),

('Aktivisme Lingkungan & Kampanye Iklim',
 'Membantu riset polusi, kampanye digital dari rumah, atau ikut aksi kreatif lapangan bertema penyelamatan bumi. Program bulanan berkelanjutan mulai Juli 2026.',
 'Lingkungan', 'Kantor Greenpeace Jakarta & Online', '2026-07-01', 'Akan Datang', 30),

('Volunteer Tenaga Kesehatan Posko Mudik',
 'Membantu mengarahkan penumpang lansia/disabilitas di area stasiun, membagikan masker dan hand sanitizer gratis, serta membantu tim medis posko memeriksa tensi darah.',
 'Kesehatan', 'Stasiun Gambir & Pasar Senen, Jakarta', '2026-12-20', 'Akan Datang', 60),

('Kelas Mengajar & Kreativitas Anak Jalanan',
 'Menjadi mentor belajar non-formal. Membantu anak jalanan mengerjakan PR sekolah, membacakan dongeng cerita rakyat, mewarnai gambar bersama, atau mengajar kosakata bahasa Inggris dasar.',
 'Pendidikan', 'Bimbel Sahabat Anak — Manggarai, Tanah Abang, Pasar Minggu', '2026-07-05', 'Akan Datang', 40),

('Donor Darah — Pelaksana Teknis & Administrasi',
 'Membantu mengisi formulir pendaftaran calon pendonor, merapikan antrean warga, membagikan kartu donor, serta memberikan paket makanan suplemen setelah warga selesai mendonorkan darah.',
 'Kesehatan', 'Unit Donor Darah PMI, Kantor Cabang setempat', '2026-07-01', 'Akan Datang', 20),

('Pemilahan Sampah Daur Ulang — Tzu Chi',
 'Membantu memisahkan botol plastik, merobek label kemasan, memisahkan kertas karton, dan merapikan material layak daur ulang di Depo Pelestarian Lingkungan Tzu Chi.',
 'Lingkungan', 'Depo Pelestarian Lingkungan PIK Jakarta', '2026-07-01', 'Akan Datang', 25),

('Volunteer NYE 2026 to Karimun Jawa',
 'Berkontribusi dan melakukan eksplorasi dalam kegiatan pengabdian di Karimunjawa secara FULLY FUNDED, dokumentasi kegiatan, dan trip eksplorasi Karimunjawa.',
 'Sosial', 'Desa Karimunjawa, Kec. Karimunjawa, Kab. Jepara', '2026-07-30', 'Akan Datang', 20),

('Bandung Menyapa #15',
 'Belajar bahasa isyarat dan bermain clay bersama teman tuli di Yayasan Rumah Quran Isyaroh. Kegiatan sosial edukatif yang mempererat kebersamaan.',
 'Sosial', 'Yayasan Rumah Quran Isyaroh, Bandung', '2026-06-07', 'Selesai', 30),

('Jelajah Pesisir Komodo',
 'Eksplorasi Pesisir Pulau Komodo di Labuan Bajo bersama Sankara. Kegiatan pengabdian sekaligus eksplorasi alam laut Indonesia.',
 'Lingkungan', 'Pulau Komodo, Labuan Bajo, NTT', '2026-07-03', 'Akan Datang', 15),

('IYEN Chapter Goes to Yogyakarta',
 'Bergabung dalam kegiatan nasional di Yogyakarta memberikan pengalaman langsung tentang budaya baru. Interaksi dengan masyarakat lokal dan peserta dari berbagai negara.',
 'Sosial', 'Kota Yogyakarta, DI Yogyakarta', '2026-08-03', 'Akan Datang', 25),

('Voluntrip — Potluck Warga Vol. 17',
 'Trash Clean Up Kampung Nelayan dan Pesta Makan Kerang bersama Adik-adik Pesisir. Bersihkan lingkungan sekaligus mempererat hubungan dengan komunitas nelayan.',
 'Lingkungan', 'Kampung Nelayan, Jakarta Utara', '2026-06-28', 'Akan Datang', 30),

('Semesta Jelajah Nusantara 4 — Raja Ampat',
 'Program pemberdayaan masyarakat yang berfokus pada peningkatan kualitas hidup melalui empat divisi: Pendidikan, Kesehatan, Pariwisata, dan Lingkungan di Desa Wawiyai, Raja Ampat.',
 'Sosial', 'Desa Wawiyai, Raja Ampat, Papua Barat Daya', '2026-07-21', 'Akan Datang', 20),

('Aksi Penanaman Mangrove Teluk Jakarta',
 'Menanam bibit mangrove bersama untuk mencegah abrasi pantai dan memulihkan ekosistem pesisir Jakarta di kawasan Ekowisata Mangrove PIK.',
 'Lingkungan', 'Kawasan Ekowisata Mangrove PIK, Jakarta Utara', '2026-07-12', 'Akan Datang', 50),

('Penyelamatan & Edukasi Satwa Liar — JAAN',
 'Membantu edukasi satwa domestik, merawat satwa liar hasil sitaan, serta kampanye stop eksploitasi lumba-lumba dan monyet. Program bulanan di pusat rehabilitasi satwa.',
 'Lingkungan', 'Pusat Rehabilitasi Satwa JAAN, Jakarta', '2026-07-01', 'Berlangsung', 15),

('Relawan Digital Penulisan Artikel Sosial',
 'Menulis artikel inspiratif, kisah sukses relawan, dan liputan isu sosial global untuk meningkatkan kesadaran masyarakat di platform online. Remote / WFH.',
 'Sosial', 'Online (Remote, dari rumah masing-masing)', '2026-07-01', 'Berlangsung', 20),

('Jakarta Untuk Perempuan, Anak, dan Disabilitas',
 'Relawan akan dibagi kelompok: Tim Pengarah Peserta & Undangan, Tim Pendampingan Peserta Disabilitas, Tim Kampanye. Apresiasi: lunch dan air mineral.',
 'Sosial', 'Halte Transjakarta Tosari Lt. 2, Jakarta Pusat', '2026-06-28', 'Akan Datang', 40),

('Piknik Tanpa Kemasan Plastik Sekali Pakai',
 'Mulai jajan tanpa nyampah dan mengenal kembali makanan tradisional. Bawa wadah bekalmu sendiri saat beli camilan favorit dan bantu kurangi tumpukan sampah plastik.',
 'Lingkungan', 'Gunung Batu Roti Ciampea, Kabupaten Bogor', '2026-06-27', 'Selesai', 35),

('Sortir Tote Bag Hasil Donasi Netizen',
 'Membantu sortir atau pilah tote bag ke beberapa kategori berdasarkan jenis dan kelayakan guna, untuk kemudian dikelola menjadi produk guna ulang oleh teman-teman disabilitas dan lansia.',
 'Sosial', 'Volunteer Hub Jakarta, Jl. Panglima Polim V, Jakarta Selatan', '2026-06-01', 'Selesai', 20),

('Cultural Exchange Volunteer — Bukit Lawang',
 'Dukung akses pendidikan dan lingkungan berkelanjutan bersama Bukit Lawang Trust. Aksi kolaboratif bersama masyarakat lokal di sekitar Ekosistem Leuser, Sumatera Utara.',
 'Pendidikan', 'Yayasan Bukit Lawang Trust, Langkat, Sumatera Utara', '2026-08-07', 'Akan Datang', 10),

('Open Rekrutmen Volunteer Pengajar BN Goes To School Batch 4',
 'Program mengajar BN Goes To School batch 4. Kembangkan kemampuan, perluas kapasitas dan buat hidup bermanfaat melalui pendidikan. Syarat: domisili Surabaya.',
 'Pendidikan', 'Sekolah Mitra Bintang Nusantara, Surabaya', '2026-08-25', 'Akan Datang', 25),

('Posyandu Gratis Kelurahan Beji',
 'Pemeriksaan kesehatan gratis untuk balita dan lansia di kelurahan Beji. Termasuk pengukuran berat badan, tekanan darah, dan penyuluhan gizi.',
 'Kesehatan', 'Balai Desa Beji, Tawangmangu', '2026-05-30', 'Selesai', 80);

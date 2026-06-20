@extends('layouts.organizer')
@section('title', 'Panduan Organisasi')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap');

    :root {
        --color-navy: #0F2057;
        --color-ink-muted: #6B7280;
        --color-bg: #F9FAFB;
    }

    .guide-page, .guide-page h1, .guide-page h3, .guide-card-header span {
        font-family: 'Sora', sans-serif;
    }
    .guide-page p, .guide-page li, .guide-intro-box {
        font-family: 'Montserrat', sans-serif;
    }

    .guide-page { padding: 2.5rem 0 4rem; }
    .guide-page-title {
        display: inline-block;
        font-size: 30px;
        font-weight: 700;
        color: var(--color-navy);
        margin: 0 0 2rem;
        text-decoration: underline;
        text-decoration-color: var(--color-navy);
        text-decoration-thickness: 3px;
        text-underline-offset: 8px;
    }

    .guide-card {
        background: #fff;
        border: 1.5px solid #B9C8E0;
        border-radius: 28px;
        padding: 2.25rem 2rem 2.5rem;
        margin-bottom: 2rem;
    }

    .guide-card-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 1.75rem;
    }
    .guide-card-header span {
        font-size: 0.95rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        color: #4B5872;
        white-space: nowrap;
    }
    .guide-card-header-line {
        flex: 1;
        height: 1px;
        background: #E1E6EF;
    }

    .guide-intro-box {
        background: #F3F4F6;
        border-left: 3px solid #D1D5DB;
        border-radius: 10px;
        padding: 1.5rem 1.75rem;
        margin-bottom: 2.5rem;
    }
    .guide-intro-box p {
        font-size: 0.875rem;
        color: #374151;
        line-height: 1.6;
        margin: 0 0 0.75rem;
    }
    .guide-intro-box p:last-child { margin-bottom: 0; }
    .guide-intro-box ol {
        margin: 0 0 0.75rem;
        padding-left: 1.25rem;
        font-size: 0.875rem;
        color: #374151;
        line-height: 1.7;
    }
    .guide-intro-box li { margin-bottom: 2px; }

    .guide-steps-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
    .guide-step-head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.25rem;
    }
    .guide-step-num {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: var(--color-navy);
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .guide-step-head h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.4;
    }

    .guide-step-media {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .guide-step-media img {
        max-width: 200px;
        width: 100%;
        height: auto;
    }
    .guide-step-media--with-social {
        justify-content: flex-start;
        gap: 16px;
    }
    .guide-step-social {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-shrink: 0;
    }
    .guide-social-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        flex-shrink: 0;
    }
    .guide-social-icon--gmail { background: #fff; border: 1px solid #E5E7EB; }
    .guide-social-icon--whatsapp { background: #25D366; }

    .guide-step-desc {
        font-size: 0.825rem;
        color: var(--color-ink-muted);
        line-height: 1.6;
        margin-top: 1.25rem;
        text-align: left;
    }

    .guide-step-wide { margin-bottom: 2.5rem; }
    .guide-step-wide:last-child { margin-bottom: 0; }
    .guide-step-wide .guide-step-head h3 { max-width: 720px; }

    .guide-step-wide-body {
        display: flex;
        align-items: flex-start;
        gap: 2rem;
        margin-bottom: 1.75rem;
    }
    .guide-step-wide-body:last-child { margin-bottom: 0; }

    .guide-step-wide-media {
        flex-shrink: 0;
        width: 180px;
    }
    .guide-step-wide-media img {
        width: 100%;
        height: auto;
        display: block;
    }

    .guide-step-wide-body p {
        font-size: 0.875rem;
        color: #374151;
        line-height: 1.7;
        margin: 0;
        padding-top: 4px;
    }

    @media (max-width: 900px) {
        .guide-steps-row { grid-template-columns: 1fr; gap: 2.5rem; }
        .guide-step-wide-body { flex-direction: column; gap: 1rem; }
        .guide-step-wide-media { width: 140px; }
    }
</style>
@endpush

@section('content')
<div class="ak-container guide-page">

    <h1 class="guide-page-title">Panduan Organisasi</h1>
    <div class="guide-card">
        <div class="guide-card-header">
            <span>LANGKAH 1: MENDAFTAR ORGANISASI</span>
            <span class="guide-card-header-line"></span>
        </div>

        <div class="guide-intro-box">
            <p>Sebelum mendaftarkan organisasi Anda di AksiKita, pastikan bahwa organisasi Anda sudah memenuhi kriteria-kriteria berikut:</p>
            <ol>
                <li>Tidak mendiskriminasi SARA (suku, agama, ras dan antar golongan) tertentu.</li>
                <li>Tidak berafiliasi dengan tokoh, agenda, dan/atau partai politik tertentu.</li>
                <li>Memiliki program dan/atau aktivitas sosial yang bersifat universal dan inklusif, yang melibatkan individu dari semua golongan tanpa terkecuali.</li>
                <li>Tidak membuat aktivitas penggalangan dana secara khusus.</li>
                <li>Tidak berbentuk perusahaan (sektor swasta), kecuali merupakan yayasan dan/atau program CSR dari perusahaan tersebut.</li>
                <li>Wajib mengisi deskripsi (latar belakang organisasi maupun aktivitas) dan kontak organisasi secara lengkap dan benar.</li>
                <li>Bersedia menerima relawan dari berbagai latar belakang dan identitas, tidak hanya individu dari golongan tertentu saja.</li>
                <li>Bersedia mengelola relawan secara penuh, mulai dari tahap pendaftaran, seleksi, briefing, hingga apresiasi melalui pipeline di dashboard aktivitas.</li>
                <li>Jika ada salah satu atau lebih dari kriteria di atas yang tidak terpenuhi, maka AksiKita berhak menonaktifkan organisasi Anda.</li>
            </ol>
            <p>Penentuan kriteria-kriteria di atas didasari oleh nilai-nilai universal dan inklusivitas yang dimiliki Indorelawan dalam pelibatan relawan dan organisasi sosial, baik pada platform online atau kegiatan offline.</p>
        </div>

        <div class="guide-steps-row">
            <div class="guide-step">
                <div class="guide-step-head">
                    <span class="guide-step-num">1</span>
                    <h3>Siapkan berkas legalitas</h3>
                </div>
                <div class="guide-step-media guide-step-media--with-social">
                    <img src="{{ asset('images/langkah1-siapkan-berkas.png') }}" alt="Siapkan berkas legalitas">
                </div>
            </div>

            <div class="guide-step">
                <div class="guide-step-head">
                    <span class="guide-step-num">2</span>
                    <h3>Isi Formulir Pendaftaran</h3>
                </div>
                <div class="guide-step-media">
                    <img src="{{ asset('images/langkah1-isi-formulir.png') }}" alt="Isi Formulir Pendaftaran">
                </div>
                <p class="guide-step-desc">Daftarkan email organisasi dan aktivasi email kamu untuk membuat aktivitas di platform AksiKita</p>
            </div>
            <div class="guide-step">
                <div class="guide-step-head">
                    <span class="guide-step-num">3</span>
                    <h3>Verifikasi Akun</h3>
                </div>
                <div class="guide-step-media">
                    <img src="{{ asset('images/langkah1-verifikasi-akun.png') }}" alt="Verifikasi Akun">
                </div>
                <p class="guide-step-desc">Setelah melakukan pendaftaran, tunggu verifikasi dari admin untuk memulai membuat aktivitas!.</p>
            </div>
        </div>
    </div>

    <div class="guide-card">
        <div class="guide-card-header">
            <span>LANGKAH 2: MEMBUAT AKTIVITAS &amp; MENCARI RELAWAN</span>
            <span class="guide-card-header-line"></span>
        </div>

        <div class="guide-step-wide">
            <div class="guide-step-head">
                <span class="guide-step-num">1</span>
                <h3>Buat Aktivitas</h3>
            </div>
            <div class="guide-step-wide-body">
                <div class="guide-step-wide-media">
                    <img src="{{ asset('images/langkah2-buat-aktivitas.png') }}" alt="Buat Aktivitas">
                </div>
                <p>Setelah menerima email notifikasi verifikasi, dan melakukan login, sekarang organisasi sudah bisa membuat aktivitas di AksiKita.</p>
            </div>
        </div>

        <div class="guide-step-wide">
            <div class="guide-step-head">
                <span class="guide-step-num">2</span>
                <h3>Cari Relawan</h3>
            </div>
            <div class="guide-step-wide-body">
                <div class="guide-step-wide-media">
                    <img src="{{ asset('images/langkah2-cari-relawan.png') }}" alt="Cari Relawan">
                </div>
                <p>Menggungah kebutuhan relawan, sebarkan link detail aktivitas melalui kanal media untuk mencari relawan.</p>
            </div>
        </div>

        <div class="guide-step-wide">
            <div class="guide-step-head">
                <span class="guide-step-num">3</span>
                <h3>Kelola Relawan, Melihat Jawaban, dan Menghubungi Relawan Melalui Fitur Chat, Memindahkan Status Relawan</h3>
            </div>

            <div class="guide-step-wide-body">
                <div class="guide-step-wide-media">
                    <img src="{{ asset('images/langkah2-kelola-monitor.png') }}" alt="Kelola relawan di dashboard">
                </div>
                <p>Untuk melihat dan mengelola relawan yang mendaftar pada setiap aktivitas yang dibuat, login dengan akun Organisasi lalu pilih bagian Aktivitas dan klik judul aktivitas yang relawannya ingin kamu kelola atau hubungi.</p>
            </div>

            <div class="guide-step-wide-body">
                <div class="guide-step-wide-media">
                    <img src="{{ asset('images/langkah2-kelola-chat.png') }}" alt="Menghubungi relawan melalui chat">
                </div>
                <p>Klik Kelola Relawan lalu klik nama relawan. Di bagian ini, organisasi bisa melihat profil relawan, mengirim pesan, dan melihat jawaban dari pertanyaan yang diberikan ketika mendaftar.</p>
            </div>

            <div class="guide-step-wide-body">
                <div class="guide-step-wide-media">
                    <img src="{{ asset('images/langkah2-kelola-grafik.png') }}" alt="Memindahkan status relawan">
                </div>
                <p>Memindahkan Status Relawan dari pending, diterima, atau ditolak setelah meninjau dan menyeleksi data mereka</p>
            </div>
        </div>
    </div>

</div>
@endsection
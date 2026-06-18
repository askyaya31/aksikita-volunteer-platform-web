@extends('layouts.organizer')
@section('title', 'Dashboard Organizer')

@push('styles')
<style>
    /* Import Font Utama */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap');

    :root {
        --color-navy: #0F2057;
        --color-blue-primary: #0066FF;
        --color-ink-muted: #6B7280;
        --color-border-soft: #EEF0F6;
        --color-bg: #F9FAFB;
    }

    /* FONT UTAMA HEADER & SUBTITLE: SORA */
    body, h1, h2, h3, .font-sora,
    .org-hero-greeting, .org-hero-name, .org-section-title, .org-section-sub, .ak-empty-state-text {
        font-family: 'Sora', sans-serif !important;
    }

    /* FONT DI DALAM CARD: MONTSERRAT */
    .org-stat-card, .org-stat-card *, 
    .org-event-row, .org-event-row *,
    .org-section-link {
        font-family: 'Montserrat', sans-serif !important;
    }

    /* Area Hero Solid Biru Pekat */
    .org-hero {
        background: #0F2057;
        padding: 3.5rem 0 5.5rem;
        position: relative;
        overflow: hidden;
    }

    /* Pola Dot Transparan Sebelah Kanan */
    .org-hero::after {
        content: '';
        position: absolute;
        top: 20px;
        right: 40px;
        width: 320px;
        height: 260px;
        background-image: radial-gradient(rgba(255, 255, 255, 0.12) 1.5px, transparent 1.5px);
        background-size: 14px 14px;
        border-radius: 50%;
        pointer-events: none;
    }

    /* Struktur Vertikal Hero (Sapaan -> Nama Org -> Tombol) */
    .org-hero-inner-vertical {
        position: relative; 
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
    }
    .org-hero-greeting {
        font-size: 14px; font-weight: 400;
        color: rgba(255,255,255,0.7);
        margin: 0;
    }
    .org-hero-name {
        font-size: 32px; font-weight: 700;
        color: #fff; line-height: 1.2; 
        margin: 0 0 4px 0;
    }

    /* Tombol Tambah Event Putih Oval Lonjong */
    .org-hero-cta {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 24px;
        background: #FFFFFF; 
        color: var(--color-navy);
        border-radius: 999px;
        font-size: 13px; font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }
    .org-hero-cta:hover { 
        background: #F3F4F6; 
        transform: translateY(-1px);
        color: var(--color-navy);
    }

    /* Stat Cards Susunan Row */
    .org-stats-wrap {
        margin-top: -48px;
        position: relative; z-index: 10;
        margin-bottom: 2.5rem;
    }
    .org-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }
    .org-stat-card {
        background: #fff;
        border-radius: 24px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 8px 24px rgba(15,32,87,0.08);
        display: flex; align-items: center; gap: 14px;
        border: 1.5px solid #EEF0F6;
    }
    .org-stat-icon {
        width: 44px; height: 44px; flex-shrink: 0;
        border-radius: 50%;
        background: #F0F4FA; 
        color: var(--color-navy);
        display: flex; align-items: center; justify-content: center;
    }
    .org-stat-num {
        font-size: 1.8rem; font-weight: 700;
        color: var(--color-navy); line-height: 1.1;
    }
    .org-stat-label {
        font-size: 0.85rem; font-weight: 600; color: var(--color-navy); margin-top: 2px;
    }

    @media (max-width: 960px) {
        .org-stats { grid-template-columns: repeat(2, 1fr); }
    }

    /* Bingkai Luar Utama Event Terbaru */
    .ak-card-flat {
        background: #FFFFFF;
        border: 1.5px solid #B0C4DE;
        border-radius: 32px;
        padding: 2.5rem 2rem;
    }
    .org-section-header {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; margin-bottom: 2rem;
    }
    .org-section-title { font-size: 1.35rem; font-weight: 600; color: #1F2937; margin-bottom: 4px; }
    .org-section-sub   { font-size: 0.85rem; color: var(--color-ink-muted); }

    /* Tombol Lihat Semua Kapsul */
    .org-section-link {
        font-size: 0.85rem; font-weight: 500; color: #1F2937;
        text-decoration: none; display: flex; align-items: center; gap: 8px;
        border: 1.5px solid #B0C4DE;
        padding: 8px 22px; border-radius: 999px;
        transition: all 0.2s;
    }
    .org-section-link:hover { background: var(--color-bg); }

    /* Kotak Baris List Event Mandiri */
    .org-event-row {
        display: flex; align-items: center; gap: 16px;
        padding: 1.25rem 1.5rem;
        background: #FFFFFF;
        border: 1.5px solid #DCE4EC;
        border-radius: 20px;
        margin-bottom: 1.25rem;
        box-shadow: 0 8px 20px rgba(15, 32, 87, 0.06);
    }
    .org-event-row:last-child { margin-bottom: 0; }

    .org-event-thumb {
        width: 48px; height: 48px; flex-shrink: 0;
        border-radius: 12px; overflow: hidden;
        background: #F0F4FA;
        display: flex; align-items: center; justify-content: center;
    }
    .org-event-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .org-event-title { font-size: 1rem; font-weight: 700; color: #000000; margin-bottom: 4px; }
    .org-event-meta  { font-size: 0.85rem; color: var(--color-ink-muted); font-weight: 500; }

    /* Desain Status Warna Hijau Cerah */
    .status-badge {
        font-size: 0.75rem; font-weight: 600;
        padding: 6px 16px; border-radius: 999px;
        background-color: #38EF7D; 
        color: #FFFFFF;
        text-transform: uppercase;
        white-space: nowrap; flex-shrink: 0;
    }

    /* Warna Kustom Berdasarkan Kebutuhan UX */
    .status-badge.ux-danger { background-color: #EF4444; }   /* Merah untuk Ditolak/Batal */
    .status-badge.ux-warning { background-color: #F59E0B; }  /* Amber untuk Pending/Review */
    .status-badge.ux-neutral { background-color: #6B7280; }  /* Abu-abu untuk Draft */

    /* Tombol Detail Solid Navy */
    .org-event-detail {
        font-size: 0.8rem; font-weight: 600;
        padding: 6px 20px; border-radius: 999px;
        background-color: #0F2057;
        color: #FFFFFF !important;
        text-decoration: none;
        margin-left: 12px;
    }

    /* Tampilan Centered Kosong (image_d3a4dc.png) */
    .ak-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 24px;
        text-align: center;
    }
    .ak-empty-state-text {
        font-size: 1.25rem;
        color: #000000;
        font-weight: 400;
        margin-bottom: 1.5rem;
    }
    .btn-empty-add {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 24px; border: 1.5px solid #000000;
        color: #000000; font-weight: 500; font-size: 0.85rem;
        border-radius: 999px; text-decoration: none;
        font-family: 'Montserrat', sans-serif;
    }
</style>
@endpush

@section('content')

{{-- Bagian Atas / Hero --}}
<section class="org-hero">
    <div class="ak-container">
        {{-- LOGIKA FIXED: Tombol Tambah Event ditaruh pas di bawah Sapaan Nama Organisasi --}}
        <div class="org-hero-inner-vertical">
            <p class="org-hero-greeting">Selamat datang,</p>
            <h1 class="org-hero-name">{{ $org->organization_name }}</h1>
            
            <a href="{{ route('organizer.events.create') }}" class="org-hero-cta">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Event
            </a>
        </div>
    </div>
</section>

<div class="ak-container">
    {{-- Komponen Stat Cards --}}
    <div class="org-stats-wrap">
        <div class="org-stats">
            <div class="org-stat-card">
                <div class="org-stat-icon">X</div>
                <div>
                    <div class="org-stat-num">{{ $stats['total'] }}</div>
                    <div class="org-stat-label">Total Event</div>
                </div>
            </div>
            <div class="org-stat-card">
                <div class="org-stat-icon">X</div>
                <div>
                    <div class="org-stat-num">{{ $stats['pending'] }}</div>
                    <div class="org-stat-label">Menunggu Review</div>
                </div>
            </div>
            <div class="org-stat-card">
                <div class="org-stat-icon">X</div>
                <div>
                    <div class="org-stat-num">{{ $stats['published'] }}</div>
                    <div class="org-stat-label">Event Aktif</div>
                </div>
            </div>
            <div class="org-stat-card">
                <div class="org-stat-icon">X</div>
                <div>
                    <div class="org-stat-num">{{ $stats['volunteers'] }}</div>
                    <div class="org-stat-label">Total Kandidat</div>
                </div>
            </div>
        </div>
    </div>

    @php
        /* Penyelarasan Map Class untuk Dinamisasi UX Status */
        $statusClasses = [
            'published'      => '',                 /* Hijau Default (.status-badge) */
            'pending_review' => 'ux-warning',       /* Kuning */
            'rejected'       => 'ux-danger',        /* Merah */
            'cancelled'      => 'ux-danger',        /* Merah */
            'draft'          => 'ux-neutral',       /* Abu-abu */
            'completed'      => 'ux-neutral',       /* Abu-abu */
        ];

        $statusLabels = [
            'draft'          => 'Draft',
            'pending_review' => 'Review',
            'published'      => 'Status',
            'rejected'       => 'Ditolak',
            'completed'      => 'Selesai',
            'cancelled'      => 'Batal',
        ];
    @endphp

    {{-- Panel Utama Event --}}
    <div class="ak-card-flat" style="margin-bottom: 4rem;">
        
        {{-- LOGIKA UTAMA: Cek apakah ada data event atau tidak --}}
        @if(count($recentEvents) > 0)
            
            {{-- TAMPILAN JIKA ADA EVENT (image_d3a87d.png) --}}
            <div class="org-section-header">
                <div>
                    <p class="org-section-title">Event Terbaru</p>
                    <p class="org-section-sub">{{ count($recentEvents) }} Event terakhir yang kamu buat</p>
                </div>
                <a href="{{ route('organizer.events') }}" class="org-section-link">
                    Lihat Semua
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>

            {{-- Render Data Secara Dinamis --}}
            @foreach($recentEvents as $event)
                <div class="org-event-row">
                    <div class="org-event-thumb">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
                        @endif
                    </div>
                    <div style="flex:1; min-width:0;">
                        <p class="org-event-title">{{ $event->title }}</p>
                        <p class="org-event-meta">{{ $event->city }}, {{ $event->start_date ? $event->start_date->format('d M Y') : 'Tanggal' }}</p>
                    </div>
                    
                    {{-- Status Badge Dinamis --}}
                    <span class="status-badge {{ $statusClasses[$event->status] ?? 'ux-neutral' }}">
                        {{ $statusLabels[$event->status] ?? $event->status }}
                    </span>

                    {{-- Tombol Detail Dinamis --}}
                    <a href="{{ route('organizer.events.show', $event->id) }}" class="org-event-detail">Detail</a>
                </div>
            @endforeach

        @else
            
            {{-- TAMPILAN JIKA KOSONG (image_d3a4dc.png) --}}
            <div class="ak-empty-state">
                <p class="ak-empty-state-text">Belum ada event yang terdaftar.</p>
                <a href="{{ route('organizer.events.create') }}" class="btn-empty-add">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Event
                </a>
            </div>

        @endif

    </div>
</div>

@endsection
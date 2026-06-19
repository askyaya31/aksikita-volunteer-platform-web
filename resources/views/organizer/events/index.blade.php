@extends('layouts.organizer')
@section('title', 'Kelola Event')

@push('styles')
<style>
    /* Mengimpor Font Utama */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap');

    :root {
        --color-navy: #0F2057;
        --color-blue-primary: #0066FF;
        --color-ink-muted: #6B7280;
        --color-border-soft: #EEF0F6;
        --color-bg: #F9FAFB;
    }

    /* FONT UTAMA HEADER, TABS, & SUBTITLE: SORA */
    body, h1, h2, h3, .font-sora,
    .org-page-hero-title, .org-page-hero-sub, .org-tab, .ak-empty-state h3 {
        font-family: 'Sora', sans-serif !important;
    }

    /* FONT DI DALAM COMPONENT CARD & BADGES: MONTSERRAT */
    .org-event-card, .org-event-card *, .ak-badge, .ak-btn {
        font-family: 'Montserrat', sans-serif !important;
    }

    /* Area Hero Solid Biru Pekat (Menyamai Beranda) */
    .org-page-hero {
        background: #0F2057;
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }

    /* Pola Dot Transparan Sisi Kanan */
    .org-page-hero::after {
        content: '';
        position: absolute;
        top: 15px;
        right: 40px;
        width: 320px;
        height: 260px;
        background-image: radial-gradient(rgba(255, 255, 255, 0.12) 1.5px, transparent 1.5px);
        background-size: 14px 14px;
        border-radius: 50%;
        pointer-events: none;
    }

    /* Struktur Sejajar: Judul Kiri & Tombol Kanan */
    .org-page-hero-inner {
        position: relative; 
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .org-page-hero-title {
        font-size: 32px; 
        font-weight: 700;
        color: #fff; 
        line-height: 1.2; 
        margin: 0;
    }

    /* Tombol Buat Event Putih Oval Lonjong Berada DI SAMPING Judul */
    .org-hero-cta {
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
        padding: 10px 24px;
        background: #FFFFFF; 
        color: var(--color-navy);
        border-radius: 999px;
        font-size: 13px; 
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .org-hero-cta:hover { 
        background: #F3F4F6; 
        transform: translateY(-1px);
        color: var(--color-navy);
    }

    /* ===================================================================
       NAVIGASI TABS — MENGGUNAKAN .is-active AGAR TIDAK BENTROK
       =================================================================== */
    .org-tabs-wrap {
        background: #fff;
        border-bottom: 1.5px solid #EAEFF5;
        position: sticky; 
        top: 70px; 
        z-index: 30;
        margin-bottom: 2rem;
    }
    .org-tabs {
        display: flex; 
        gap: 28px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .org-tabs::-webkit-scrollbar { display: none; }

    /* Default semua tab: warna abu, weight normal (500), TIDAK underline */
    .org-tab {
        position: relative;       /* wajib: jadi acuan posisi underline (::after) */
        display: inline-block;    /* wajib: agar width:100% pada ::after akurat */
        padding: 18px 0;
        font-size: 0.875rem; 
        font-weight: 500;
        color: #6B7280;
        text-decoration: none;
        white-space: nowrap;
        transition: color 0.2s ease;
    }
    .org-tab:hover { color: var(--color-navy); }

    /* Garis underline disiapkan untuk SEMUA tab, tapi lebarnya 0 (tak terlihat) */
    .org-tab::after {
        content: '';
        position: absolute;
        bottom: -1.5px; /* pas menempel border-bottom pembungkus */
        left: 0;
        width: 0;
        height: 3px;
        background-color: var(--color-navy);
        transition: width 0.2s ease;
    }

    /* HANYA tab dengan class .is-active yang dapat warna gelap + bold */
    .org-tab.is-active { 
        color: var(--color-navy) !important; 
        font-weight: 600 !important; 
    }

    /* HANYA tab .is-active yang underline-nya dilebarkan jadi 100% */
    .org-tab.is-active::after {
        width: 100% !important;
    }

    /* Bingkai Luar Utama Area List Event */
    .ak-main-list-container {
        background: #FFFFFF;
        border: 1.5px solid #B0C4DE;
        border-radius: 32px;
        padding: 2.5rem 2rem;
        margin-bottom: 3rem;
    }

    /* Kartu Mandiri List Event */
    .org-event-card {
        background: #fff;
        border: 1.5px solid #DCE4EC;
        border-radius: 20px;
        padding: 1.25rem 1.5rem;
        display: flex; 
        align-items: center; 
        gap: 18px;
        box-shadow: 0 8px 20px rgba(15, 32, 87, 0.05);
        transition: all 0.2s ease;
    }
    .org-event-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(15, 32, 87, 0.09);
        border-color: #A0B0D0;
    }

    /* Kotak Thumbnail Poster */
    .org-event-poster {
        width: 58px; 
        height: 58px; 
        flex-shrink: 0;
        border-radius: 12px; 
        overflow: hidden;
        background: #F0F4FA;
        display: flex; 
        align-items: center; 
        justify-content: center;
    }
    .org-event-poster img { width: 100%; height: 100%; object-fit: cover; }
    
    .org-event-body { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 4px; }
    
    /* Header di dalam Card untuk Status & Kategori */
    .org-event-card-header {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 2px;
    }

    .org-event-title {
        font-size: 1rem; 
        font-weight: 700; 
        color: #000000;
        margin: 0;
        line-height: 1.3;
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis;
    }
    
    .org-event-metas { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 2px; }
    .org-event-meta-item {
        display: flex; 
        align-items: center; 
        gap: 5px;
        font-size: 0.85rem; 
        color: var(--color-ink-muted);
        font-weight: 500;
    }
    .org-event-meta-item svg { color: var(--color-ink-muted); }

    /* Desain Status Kapsul UX */
    .status-badge {
        font-size: 0.725rem; 
        font-weight: 600;
        padding: 4px 12px; 
        border-radius: 999px;
        background-color: #10B981; 
        color: #FFFFFF;
        text-transform: uppercase;
        white-space: nowrap; 
        flex-shrink: 0;
        letter-spacing: 0.03em;
    }
    .status-badge.ux-warning { background-color: #F59E0B; }  
    .status-badge.ux-danger  { background-color: #EF4444; }  
    .status-badge.ux-neutral { background-color: #6B7280; }  

    /* Desain Kapsul Kategori Biru */
    .category-badge {
        font-size: 0.725rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 999px;
        background-color: #E6F0FF;
        color: #0066FF;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* Grup Tombol Aksi di Samping Kanan */
    .org-event-actions { 
        display: flex; 
        gap: 8px; 
        flex-shrink: 0; 
        align-items: center; 
    }

    .btn-action-solid {
        font-size: 0.8rem; 
        font-weight: 600;
        padding: 8px 18px; 
        border-radius: 999px;
        background-color: var(--color-navy);
        color: #FFFFFF !important;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-action-solid:hover { background-color: #1A3575; }

    .btn-action-ghost {
        font-size: 0.8rem; 
        font-weight: 600;
        padding: 7px 18px; 
        border-radius: 999px;
        background-color: transparent;
        color: var(--color-navy) !important;
        text-decoration: none;
        border: 1.5px solid #B0C4DE;
        transition: all 0.2s;
    }
    .btn-action-ghost:hover { background-color: var(--color-bg); border-color: var(--color-navy); }

    .btn-action-submit {
        font-size: 0.8rem; 
        font-weight: 600;
        padding: 8px 18px; 
        border-radius: 999px;
        background-color: #10B981;
        color: #FFFFFF !important;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    .btn-action-submit:hover { background-color: #059669; }

    .org-event-rejection {
        margin-top: 8px;
        padding: 10px 14px;
        background: #FEF2F2; 
        border: 1px solid #FECACA;
        border-radius: 10px;
        font-size: 0.8rem; 
        color: #b91c1c;
    }

    @media (max-width: 768px) {
        .org-page-hero-inner { flex-direction: column; align-items: flex-start; gap: 14px; }
        .org-event-card { flex-direction: column; align-items: flex-start; gap: 14px; }
        .org-event-actions { width: 100%; justify-content: flex-start; margin-top: 4px; }
    }

    /* Centered Empty State */
    .ak-empty-state {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 60px 24px; text-align: center;
    }
    .ak-empty-state h3 { font-size: 1.25rem; color: #000000; font-weight: 500; margin-bottom: 8px; }
    .ak-empty-state p { font-size: 0.9rem; color: #6B7280; margin-bottom: 1.5rem; }
</style>
@endpush

@section('content')

{{-- Bagian Jumbotron Atas --}}
<section class="org-page-hero">
    <div class="ak-container">
        <div class="org-page-hero-inner">
            <h1 class="org-page-hero-title">Kelola Event</h1>
            
            @if($org->verification_status === 'verified')
                <a href="{{ route('organizer.events.create') }}" class="org-hero-cta">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Buat Event
                </a>
            @else
                <span class="status-badge ux-warning" style="text-transform: none; padding: 6px 14px;">
                    Menunggu verifikasi profil untuk membuat event
                </span>
            @endif
        </div>
    </div>
</section>

{{-- Navigasi Tabs Filter — Menggunakan class .is-active --}}
<div class="org-tabs-wrap">
    <div class="ak-container">
        <nav class="org-tabs" aria-label="Filter event">
            @foreach([
                'aktif'   => 'Aktif',
                'review'  => 'Ditinjau',
                'draft'   => 'Draft',
                'ditolak' => 'Ditolak',
                'selesai' => 'Selesai',
            ] as $key => $label)
                <a href="{{ route('organizer.events', ['tab' => $key]) }}"
                   class="org-tab {{ $tab === $key ? 'is-active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>
    </div>
</div>

<div class="ak-container">
    {{-- Container Box Utama Pembungkus Daftar Kegiatan --}}
    <div class="ak-main-list-container">
        <div style="display:flex; flex-direction:column; gap:16px;">
            
            @php
                $statusClasses = [
                    'draft'          => 'ux-neutral',
                    'pending_review' => 'ux-warning',
                    'published'      => '', 
                    'rejected'       => 'ux-danger',
                    'completed'      => 'ux-neutral',
                    'cancelled'      => 'ux-danger',
                ];
                $statusLabels = [
                    'draft'          => 'Draft',
                    'pending_review' => 'Ditinjau',
                    'published'      => 'Aktif',
                    'rejected'       => 'Ditolak',
                    'completed'      => 'Selesai',
                    'cancelled'      => 'Dibatalkan',
                ];
            @endphp

            @forelse($events as $event)
                {{-- Box Kartu Kegiatan Mandiri --}}
                <div class="org-event-card">
                    <div class="org-event-poster">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
                        @else
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-navy)" stroke-width="1.5">
                                <rect x="3" y="4" width="18" height="16" rx="2"/>
                            </svg>
                        @endif
                    </div>

                    <div class="org-event-body">
                        {{-- Status Dan Kategori Di Atas Judul Event --}}
                        <div class="org-event-card-header">
                            <span class="status-badge {{ $statusClasses[$event->status] ?? 'ux-neutral' }}">
                                {{ $statusLabels[$event->status] ?? $event->status }}
                            </span>
                            @if(isset($event->categories))
                                @foreach($event->categories->take(2) as $cat)
                                    <span class="category-badge">{{ $cat->name }}</span>
                                @endforeach
                            @endif
                        </div>

                        <p class="org-event-title">{{ $event->title }}</p>
                        
                        <div class="org-event-metas">
                            <span class="org-event-meta-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $event->city }}, {{ $event->province }}
                            </span>
                            <span class="org-event-meta-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ $event->start_date ? $event->start_date->format('d M Y') : 'Tanggal' }}
                            </span>
                            <span class="org-event-meta-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                </svg>
                                {{ $event->registered_count }}/{{ $event->quota }} Volunteer
                            </span>
                        </div>

                        @if($event->status === 'rejected' && $event->rejection_reason)
                            <div class="org-event-rejection">
                                <strong>Alasan ditolak:</strong> {{ Str::limit($event->rejection_reason, 120) }}
                            </div>
                        @endif
                    </div>

                    {{-- Kontrol Aksi Sisi Kanan --}}
                    <div class="org-event-actions">
                        @if($event->status === 'draft')
                            <form action="{{ route('organizer.events.submit', $event->id) }}" method="POST"
                                  onsubmit="return confirm('Ajukan event ini ke review admin?')" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-action-submit">Ajukan</button>
                            </form>
                        @endif
                        
                        @if(in_array($event->status, ['draft', 'rejected', 'published']))
                            <a href="{{ route('organizer.events.edit', $event->id) }}" class="btn-action-ghost">Edit</a>
                        @endif
                        
                        <a href="{{ route('organizer.events.show', $event->id) }}" class="btn-action-solid">Detail</a>
                    </div>
                </div>
            @empty
                {{-- State Kosong Terpusat --}}
                <div class="ak-empty-state">
                    <h3>Belum ada event di kategori ini</h3>
                    <p>
                        @if($tab === 'aktif') Belum ada event yang sedang aktif.
                        @elseif($tab === 'review') Tidak ada event yang sedang ditinjau.
                        @elseif($tab === 'draft') Kamu belum memiliki draft event.
                        @elseif($tab === 'ditolak') Tidak ada event yang ditolak.
                        @elseif($tab === 'selesai') Belum ada event yang selesai.
                        @endif
                    </p>
                    @if($org->verification_status === 'verified')
                        <a href="{{ route('organizer.events.create') }}" class="btn-action-ghost">Buat Event Baru</a>
                    @endif
                </div>
            @endforelse

        </div>
    </div>

    {{-- Navigasi Halaman Pagination --}}
    @if($events->hasPages())
        <div class="ak-pagination" style="margin-top: 1.5rem; display: flex; justify-content: center;">
            {{ $events->appends(['tab' => $tab])->links() }}
        </div>
    @endif
</div>

@endsection
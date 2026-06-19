@extends('layouts.organizer')
@section('title', $event->title)

@push('styles')
<style>
    /* ─── PAGE WRAPPER ──────────────────────────────────────────── */
    .ev-page {
        max-width: 980px;
        margin-inline: auto;
        padding: 32px 24px 64px;
    }

    /* ─── BACK LINK ─────────────────────────────────────────────── */
    .ev-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        color: #6B7280;
        text-decoration: none;
        margin-bottom: 20px;
        transition: color 0.15s;
    }
    .ev-back:hover { color: #0F2057; }

    /* ─── HEADER: title + badge ─────────────────────────────────── */
    .ev-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 10px;
    }
    .ev-title {
        font-family: 'Sora', sans-serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: #0F2057;
        letter-spacing: -0.02em;
        line-height: 1.25;
        flex: 1;
    }
    .ev-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 14px;
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        flex-shrink: 0;
        margin-top: 4px;
    }
    .ev-badge--draft          { background: #F1F5F9; color: #475569; }
    .ev-badge--pending_review { background: #FEF9C3; color: #854D0E; }
    .ev-badge--published      { background: #DCFCE7; color: #166534; }
    .ev-badge--rejected       { background: #FEE2E2; color: #991B1B; }
    .ev-badge--completed      { background: #DBEAFE; color: #1D4ED8; }
    .ev-badge--cancelled      { background: #F1F5F9; color: #94A3B8; }

    /* ─── CATEGORIES ─────────────────────────────────────────────── */
    .ev-cats {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 20px;
    }
    .ev-cat {
        padding: 3px 12px;
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 600;
        background: #EFF6FF;
        color: #1D4ED8;
        border: 1px solid #BFDBFE;
    }

    /* ─── REJECTION BANNER ───────────────────────────────────────── */
    .ev-rejection {
        background: #FFF5F5;
        border: 1px solid #FECACA;
        border-left: 3px solid #EF4444;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
    }
    .ev-rejection__icon {
        width: 30px; height: 30px;
        background: #FEE2E2;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ev-rejection__title { font-size: 0.8rem; font-weight: 700; color: #991B1B; margin-bottom: 3px; }
    .ev-rejection__body  { font-size: 0.8rem; color: #B91C1C; line-height: 1.5; }
    .ev-rejection__link  { font-size: 0.75rem; font-weight: 600; color: #DC2626; text-decoration: underline; text-underline-offset: 2px; display: inline-block; margin-top: 6px; }

    /* ─── MAIN GRID ──────────────────────────────────────────────── */
    .ev-layout {
        display: grid;
        grid-template-columns: 1fr 248px;
        gap: 16px;
        align-items: start;
    }
    @media (max-width: 700px) {
        .ev-layout { grid-template-columns: 1fr; }
    }

    /* ─── MAIN CARD ──────────────────────────────────────────────── */
    .ev-card {
        background: #FFFFFF;
        border: 1px solid #EAEFF5;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(15,32,87,0.05);
    }

    /* Poster */
    .ev-poster {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }
    .ev-poster-placeholder {
        width: 100%;
        height: 160px;
        background: linear-gradient(135deg, #0F2057 0%, #3B82F6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Meta rows inside card */
    .ev-meta-list {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .ev-meta-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .ev-meta-icon {
        width: 36px; height: 36px;
        background: #F1F5F9;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        color: #475569;
    }
    .ev-meta-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #9CA3AF;
        margin-bottom: 2px;
    }
    .ev-meta-val {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1F2937;
        line-height: 1.3;
    }
    .ev-meta-sub {
        font-size: 0.75rem;
        color: #6B7280;
        margin-top: 2px;
    }

    /* Quota bar */
    .ev-quota-wrap { display: flex; align-items: center; gap: 10px; margin-top: 4px; }
    .ev-quota-track {
        flex: 1;
        height: 5px;
        background: #E5E7EB;
        border-radius: 99px;
        overflow: hidden;
        max-width: 120px;
    }
    .ev-quota-bar {
        height: 100%;
        border-radius: 99px;
        transition: width 0.3s ease;
    }
    .ev-quota-label { font-size: 0.7rem; color: #6B7280; font-weight: 500; }

    /* Divider */
    .ev-divider { height: 1px; background: #F1F5F9; margin: 4px 20px; }

    /* Description / Requirements */
    .ev-text-section { padding: 16px 20px; }
    .ev-text-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #9CA3AF;
        margin-bottom: 6px;
    }
    .ev-text-body {
        font-size: 0.8375rem;
        color: #4B5563;
        line-height: 1.7;
        white-space: pre-line;
    }

    /* ─── SIDEBAR ────────────────────────────────────────────────── */
    .ev-sidebar { display: flex; flex-direction: column; gap: 12px; }

    .ev-side-card {
        background: #FFFFFF;
        border: 1px solid #EAEFF5;
        border-radius: 16px;
        padding: 16px;
        box-shadow: 0 1px 4px rgba(15,32,87,0.05);
    }
    .ev-side-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #9CA3AF;
        margin-bottom: 12px;
    }

    /* Action buttons */
    .ev-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        height: 38px;
        border-radius: 10px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8375rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        margin-bottom: 8px;
        border: 1.5px solid transparent;
    }
    .ev-btn:last-child { margin-bottom: 0; }
    .ev-btn--primary {
        background: #0F2057;
        color: #FFFFFF;
        border-color: #0F2057;
    }
    .ev-btn--primary:hover { background: #1a3070; color: #FFFFFF; }
    .ev-btn--outline {
        background: transparent;
        color: #374151;
        border-color: #E5E7EB;
    }
    .ev-btn--outline:hover { border-color: #9CA3AF; color: #1F2937; }
    .ev-btn--danger {
        background: transparent;
        color: #EF4444;
        border-color: #FECACA;
    }
    .ev-btn--danger:hover { background: #FFF5F5; }

    /* Pending / completed state */
    .ev-state-box {
        border-radius: 10px;
        padding: 14px;
        text-align: center;
    }
    .ev-state-box--pending { background: #FFFBEB; border: 1px solid #FDE68A; }
    .ev-state-box--completed { background: #EFF6FF; border: 1px solid #BFDBFE; }
    .ev-state-box--cancelled { background: #F8FAFC; border: 1px solid #E5E7EB; }

    .ev-state-icon {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 8px;
    }
    .ev-state-icon--pending   { background: #FEF3C7; }
    .ev-state-icon--completed { background: #DBEAFE; }

    .ev-state-title { font-size: 0.8rem; font-weight: 700; }
    .ev-state-sub   { font-size: 0.72rem; margin-top: 3px; line-height: 1.4; }
    .ev-state-box--pending .ev-state-title   { color: #92400E; }
    .ev-state-box--pending .ev-state-sub     { color: #B45309; }
    .ev-state-box--completed .ev-state-title { color: #1E40AF; }
    .ev-state-box--cancelled .ev-state-title { color: #6B7280; font-size: 0.8rem; }

    /* Volunteer stats */
    .ev-stat-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
    }
    .ev-stat-row + .ev-stat-row { border-top: 1px solid #F1F5F9; }
    .ev-stat-key {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        color: #4B5563;
    }
    .ev-stat-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .ev-stat-val { font-size: 0.8rem; font-weight: 700; }

    /* ─── VOLUNTEER TABLE ────────────────────────────────────────── */
    .ev-vol-section {
        background: #FFFFFF;
        border: 1px solid #EAEFF5;
        border-radius: 16px;
        margin-top: 16px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(15,32,87,0.05);
    }
    .ev-vol-header {
        padding: 14px 20px;
        border-bottom: 1px solid #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ev-vol-title { font-size: 0.9rem; font-weight: 700; color: #0F2057; }
    .ev-vol-count {
        font-size: 0.75rem;
        color: #6B7280;
        background: #F1F5F9;
        padding: 2px 10px;
        border-radius: 99px;
        font-weight: 600;
    }

    .ev-vol-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        border-bottom: 1px solid #F9FAFB;
        gap: 12px;
        transition: background 0.1s;
    }
    .ev-vol-row:last-child { border-bottom: none; }
    .ev-vol-row:hover { background: #FAFBFC; }

    .ev-avatar {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: #EFF6FF;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: #1D4ED8;
        flex-shrink: 0;
        overflow: hidden;
    }
    .ev-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .ev-vol-info { flex: 1; min-width: 0; }
    .ev-vol-name { font-size: 0.85rem; font-weight: 600; color: #1F2937; }
    .ev-vol-meta { font-size: 0.72rem; color: #6B7280; margin-top: 2px; }
    .ev-vol-notes { font-size: 0.7rem; color: #9CA3AF; margin-top: 2px; font-style: italic; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 240px; }

    .ev-vol-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-top: 4px;
    }
    .ev-skill-tag {
        font-size: 0.62rem;
        padding: 2px 8px;
        background: #EFF6FF;
        color: #1D4ED8;
        border-radius: 99px;
        font-weight: 500;
        border: 1px solid #BFDBFE;
    }

    .ev-vol-actions { display: flex; gap: 5px; align-items: center; flex-shrink: 0; }

    .ev-btn-xs {
        height: 28px;
        padding: 0 11px;
        border-radius: 8px;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.12s;
        text-decoration: none;
        border: 1.5px solid transparent;
    }
    .ev-btn-xs--detail  { background: transparent; color: #6B7280; border-color: #E5E7EB; }
    .ev-btn-xs--detail:hover { border-color: #9CA3AF; color: #374151; }
    .ev-btn-xs--accept  { background: #22C55E; color: #fff; border-color: #22C55E; }
    .ev-btn-xs--accept:hover { background: #16A34A; border-color: #16A34A; }
    .ev-btn-xs--reject  { background: transparent; color: #EF4444; border-color: #FECACA; }
    .ev-btn-xs--reject:hover { background: #FFF5F5; }
    .ev-btn-xs--attend  { background: #3B82F6; color: #fff; border-color: #3B82F6; }
    .ev-btn-xs--attend:hover { background: #2563EB; border-color: #2563EB; }
    .ev-btn-xs--chat    { background: #0F2057; color: #fff; border-color: #0F2057; }
    .ev-btn-xs--chat:hover { background: #3B82F6; border-color: #3B82F6; }

    .ev-pill {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .ev-pill--confirmed { background: #DCFCE7; color: #166534; }
    .ev-pill--attended  { background: #DBEAFE; color: #1D4ED8; }
    .ev-pill--cancelled { background: #F1F5F9; color: #94A3B8; }

    /* Empty state */
    .ev-empty {
        padding: 48px 20px;
        text-align: center;
    }
    .ev-empty__icon {
        width: 48px; height: 48px;
        background: #EFF6FF;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px;
    }
    .ev-empty__title { font-size: 0.85rem; font-weight: 600; color: #6B7280; }
    .ev-empty__sub   { font-size: 0.78rem; color: #9CA3AF; margin-top: 4px; line-height: 1.5; }
</style>
@endpush

@section('content')

@php
    $statusLabels = [
        'draft'          => 'Draft',
        'pending_review' => 'Menunggu Review',
        'published'      => 'Aktif',
        'rejected'       => 'Ditolak',
        'completed'      => 'Selesai',
        'cancelled'      => 'Dibatalkan',
    ];
    $pct = $event->quota > 0
        ? min(100, round($event->registered_count / $event->quota * 100))
        : 0;
    $barColor = $pct >= 90 ? '#ef4444' : ($pct >= 60 ? '#f59e0b' : '#3b82f6');

    $pending   = $event->registrations->where('status', 'pending')->count();
    $confirmed = $event->registrations->where('status', 'confirmed')->count();
    $attended  = $event->registrations->where('status', 'attended')->count();
    $cancelled = $event->registrations->where('status', 'cancelled')->count();
@endphp

<div class="ev-page">

    {{-- Back --}}
    <a href="{{ route('organizer.events') }}" class="ev-back">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali ke daftar event
    </a>

    {{-- Title + Badge --}}
    <div class="ev-header">
        <h1 class="ev-title">{{ $event->title }}</h1>
        <span class="ev-badge ev-badge--{{ $event->status }}">
            {{ $statusLabels[$event->status] ?? $event->status }}
        </span>
    </div>

    {{-- Categories --}}
    @if($event->categories->count())
        <div class="ev-cats">
            @foreach($event->categories as $cat)
                <span class="ev-cat">{{ $cat->name }}</span>
            @endforeach
        </div>
    @endif

    {{-- Rejection banner --}}
    @if($event->status === 'rejected' && $event->rejection_reason)
        <div class="ev-rejection">
            <div class="ev-rejection__icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2" stroke-linecap="round">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div>
                <p class="ev-rejection__title">Event ditolak oleh admin</p>
                <p class="ev-rejection__body">{{ $event->rejection_reason }}</p>
                <a href="{{ route('organizer.events.edit', $event->id) }}" class="ev-rejection__link">
                    Edit dan ajukan ulang
                </a>
            </div>
        </div>
    @endif

    {{-- MAIN GRID --}}
    <div class="ev-layout">

        {{-- LEFT: Main card --}}
        <div>
            <div class="ev-card">

                {{-- Poster --}}
                @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}"
                         alt="{{ $event->title }}"
                         class="ev-poster">
                @else
                    <div class="ev-poster-placeholder">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.4)" stroke-width="1.2" stroke-linecap="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                    </div>
                @endif

                {{-- Meta rows --}}
                <div class="ev-meta-list">

                    {{-- Tanggal --}}
                    <div class="ev-meta-row">
                        <div class="ev-meta-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <div>
                            <p class="ev-meta-label">Tanggal</p>
                            <p class="ev-meta-val">
                                {{ $event->start_date->format('d M Y') }}
                                @if($event->start_date->format('Y-m-d') !== $event->end_date->format('Y-m-d'))
                                    &ndash; {{ $event->end_date->format('d M Y') }}
                                @endif
                            </p>
                            @if($event->start_time)
                                <p class="ev-meta-sub">{{ $event->start_time }}{{ $event->end_time ? ' – ' . $event->end_time : '' }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="ev-divider"></div>

                    {{-- Lokasi --}}
                    <div class="ev-meta-row">
                        <div class="ev-meta-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <p class="ev-meta-label">Lokasi</p>
                            <p class="ev-meta-val">{{ $event->location_name }}</p>
                            <p class="ev-meta-sub">{{ $event->city }}, {{ $event->province }}</p>
                        </div>
                    </div>

                    <div class="ev-divider"></div>

                    {{-- Kuota --}}
                    <div class="ev-meta-row">
                        <div class="ev-meta-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                            </svg>
                        </div>
                        <div>
                            <p class="ev-meta-label">Kuota</p>
                            <p class="ev-meta-val">
                                <span style="color:#3B82F6;">{{ $event->registered_count }}</span>
                                <span style="color:#9CA3AF;font-weight:400;"> / {{ $event->quota }} spot</span>
                            </p>
                            <div class="ev-quota-wrap">
                                <div class="ev-quota-track">
                                    <div class="ev-quota-bar" style="width:{{ $pct }}%;background:{{ $barColor }};"></div>
                                </div>
                                <span class="ev-quota-label">{{ $pct }}% terisi</span>
                            </div>
                        </div>
                    </div>

                    @if($event->contact_person)
                        <div class="ev-divider"></div>
                        <div class="ev-meta-row">
                            <div class="ev-meta-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11 19.79 19.79 0 01.12 2.38 2 2 0 012.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 9.4a16 16 0 006.69 6.69l1.46-.95a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="ev-meta-label">Narahubung</p>
                                <p class="ev-meta-val">{{ $event->contact_person }}</p>
                                @if($event->contact_phone)
                                    <p class="ev-meta-sub">{{ $event->contact_phone }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Requirements --}}
                @if($event->requirements)
                    <div class="ev-divider" style="margin: 0 0;"></div>
                    <div class="ev-text-section">
                        <p class="ev-text-label">Syarat &amp; Ketentuan</p>
                        <p class="ev-text-body">{{ $event->requirements }}</p>
                    </div>
                @endif

                {{-- Description --}}
                @if($event->description)
                    <div class="ev-divider" style="margin: 0 0;"></div>
                    <div class="ev-text-section">
                        <p class="ev-text-label">Tentang Event</p>
                        <p class="ev-text-body">{{ $event->description }}</p>
                    </div>
                @endif

            </div>
        </div>

        {{-- RIGHT: Sidebar --}}
        <div class="ev-sidebar">

            {{-- Volunteer Stats --}}
            <div class="ev-side-card">
                <p class="ev-side-label">Volunteer</p>
                <div class="ev-stat-row">
                    <div class="ev-stat-key">
                        <div class="ev-stat-dot" style="background:#F59E0B;"></div>
                        Menunggu
                    </div>
                    <span class="ev-stat-val" style="color:#D97706;">{{ $pending }}</span>
                </div>
                <div class="ev-stat-row">
                    <div class="ev-stat-key">
                        <div class="ev-stat-dot" style="background:#22C55E;"></div>
                        Dikonfirmasi
                    </div>
                    <span class="ev-stat-val" style="color:#16A34A;">{{ $confirmed }}</span>
                </div>
                <div class="ev-stat-row">
                    <div class="ev-stat-key">
                        <div class="ev-stat-dot" style="background:#3B82F6;"></div>
                        Hadir
                    </div>
                    <span class="ev-stat-val" style="color:#2563EB;">{{ $attended }}</span>
                </div>
                <div class="ev-stat-row">
                    <div class="ev-stat-key">
                        <div class="ev-stat-dot" style="background:#D1D5DB;"></div>
                        Dibatalkan
                    </div>
                    <span class="ev-stat-val" style="color:#9CA3AF;">{{ $cancelled }}</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="ev-side-card">
                <p class="ev-side-label">Aksi</p>

                @if($event->status === 'draft')
                    <a href="{{ route('organizer.events.edit', $event->id) }}" class="ev-btn ev-btn--outline">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Event
                    </a>
                    <form action="{{ route('organizer.events.submit', $event->id) }}" method="POST"
                          onsubmit="return confirm('Ajukan event ini ke review admin?')">
                        @csrf
                        <button type="submit" class="ev-btn ev-btn--primary">Ajukan ke Review</button>
                    </form>
                    <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus event ini? Tindakan ini tidak dapat diurungkan.')">
                        @csrf
                        <button type="submit" class="ev-btn ev-btn--danger">Hapus Event</button>
                    </form>

                @elseif($event->status === 'rejected')
                    <a href="{{ route('organizer.events.edit', $event->id) }}" class="ev-btn ev-btn--primary">
                        Edit &amp; Ajukan Ulang
                    </a>
                    <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus event ini?')">
                        @csrf
                        <button type="submit" class="ev-btn ev-btn--danger">Hapus Event</button>
                    </form>

                @elseif($event->status === 'pending_review')
                    <div class="ev-state-box ev-state-box--pending">
                        <div class="ev-state-icon ev-state-icon--pending">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2" stroke-linecap="round">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <p class="ev-state-title">Sedang ditinjau admin</p>
                        <p class="ev-state-sub">Kamu akan mendapat notifikasi setelah ditinjau.</p>
                    </div>

                @elseif($event->status === 'published')
                    <a href="{{ route('organizer.events.edit', $event->id) }}" class="ev-btn ev-btn--outline">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Kegiatan
                    </a>
                    <form action="{{ route('organizer.events.complete', $event->id) }}" method="POST"
                          onsubmit="return confirm('Tandai event ini sebagai selesai? Tindakan ini tidak dapat diurungkan.')">
                        @csrf
                        <button type="submit" class="ev-btn ev-btn--primary">Tandai Selesai</button>
                    </form>

                @elseif($event->status === 'completed')
                    <div class="ev-state-box ev-state-box--completed">
                        <div class="ev-state-icon ev-state-icon--completed">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1D4ED8" stroke-width="2.5" stroke-linecap="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <p class="ev-state-title">Event telah selesai</p>
                    </div>

                @elseif($event->status === 'cancelled')
                    <div class="ev-state-box ev-state-box--cancelled">
                        <p class="ev-state-title" style="color:#6B7280;">Event dibatalkan</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- VOLUNTEER LIST --}}
    <div class="ev-vol-section">
        <div class="ev-vol-header">
            <p class="ev-vol-title">Daftar Volunteer</p>
            <span class="ev-vol-count">{{ $event->registrations->count() }} kandidat</span>
        </div>

        @forelse($event->registrations as $reg)
            <div class="ev-vol-row">

                <div class="ev-avatar">
                    @if($reg->user->volunteerProfile?->avatar)
                        <img src="{{ asset('storage/' . $reg->user->volunteerProfile->avatar) }}"
                             alt="{{ $reg->user->name }}">
                    @else
                        {{ strtoupper(substr($reg->user->name, 0, 1)) }}
                    @endif
                </div>

                <div class="ev-vol-info">
                    <p class="ev-vol-name">{{ $reg->user->name }}</p>
                    <p class="ev-vol-meta">
                        {{ $reg->user->email }}
                        @if($reg->user->volunteerProfile?->city)
                            · {{ $reg->user->volunteerProfile->city }}, {{ $reg->user->volunteerProfile->province }}
                        @endif
                    </p>
                    @if($reg->user->volunteerProfile?->skills)
                        <div class="ev-vol-skills">
                            @foreach(array_slice((array) $reg->user->volunteerProfile->skills, 0, 3) as $skill)
                                <span class="ev-skill-tag">{{ $skill }}</span>
                            @endforeach
                            @if(count((array) $reg->user->volunteerProfile->skills) > 3)
                                <span style="font-size:0.65rem;color:#9CA3AF;">+{{ count((array) $reg->user->volunteerProfile->skills) - 3 }}</span>
                            @endif
                        </div>
                    @endif
                    @if($reg->notes)
                        <p class="ev-vol-notes">"{{ $reg->notes }}"</p>
                    @endif
                </div>

                <div class="ev-vol-actions">
                    <a href="{{ route('organizer.volunteers.show', $reg->id) }}" class="ev-btn-xs ev-btn-xs--detail">
                        Detail
                    </a>

                    @if($reg->status === 'pending')
                        <form action="{{ route('organizer.confirm', $reg->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="ev-btn-xs ev-btn-xs--accept">Terima</button>
                        </form>
                        <form action="{{ route('organizer.reject', $reg->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="ev-btn-xs ev-btn-xs--reject">Tolak</button>
                        </form>

                    @elseif($reg->status === 'confirmed')
                        @if($event->status === 'completed' || $event->start_date->lte(now()))
                            <form action="{{ route('organizer.attend', $reg->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="ev-btn-xs ev-btn-xs--attend">Tandai Hadir</button>
                            </form>
                        @else
                            <span class="ev-pill ev-pill--confirmed">Diterima</span>
                        @endif
                        @if($reg->chatRoom)
                            <a href="{{ route('organizer.chat.show', $reg->chatRoom) }}" class="ev-btn-xs ev-btn-xs--chat">
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                Chat
                            </a>
                        @endif

                    @elseif($reg->status === 'attended')
                        <span class="ev-pill ev-pill--attended">Hadir</span>
                        @if($reg->chatRoom)
                            <a href="{{ route('organizer.chat.show', $reg->chatRoom) }}" class="ev-btn-xs ev-btn-xs--chat">
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                Chat
                            </a>
                        @endif

                    @elseif($reg->status === 'cancelled')
                        <span class="ev-pill ev-pill--cancelled">Dibatalkan</span>
                    @endif
                </div>

            </div>
        @empty
            <div class="ev-empty">
                <div class="ev-empty__icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                        <path d="M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <p class="ev-empty__title">Belum ada volunteer yang mendaftar</p>
                <p class="ev-empty__sub">Volunteer akan muncul di sini setelah event dipublikasikan.</p>
            </div>
        @endforelse
    </div>

</div>

@endsection
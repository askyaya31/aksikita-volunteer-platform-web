@extends('layouts.organizer')
@section('title', $event->title)

@push('styles')
<style>
    .es-page {
        max-width: 960px;
        margin-inline: auto;
        padding-block: 28px 56px;
    }

    .es-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: var(--color-ink-muted);
        text-decoration: none;
        margin-bottom: 16px;
        transition: color 0.15s;
    }
    .es-back:hover { color: var(--color-navy); }

    .es-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 10px;
    }
    .es-title {
        font-family: var(--font-display);
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--color-navy);
        letter-spacing: -0.02em;
        line-height: 1.3;
        flex: 1;
    }

    .es-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 11px;
        border-radius: 99px;
        font-size: 0.6875rem;
        font-weight: 600;
        flex-shrink: 0;
        margin-top: 3px;
        white-space: nowrap;
    }
    .es-badge--draft          { background: #f1f5f9; color: #475569; }
    .es-badge--pending_review { background: #fef9c3; color: #854d0e; }
    .es-badge--published      { background: #dcfce7; color: #166534; }
    .es-badge--rejected       { background: #fee2e2; color: #991b1b; }
    .es-badge--completed      { background: #dbeafe; color: #1d4ed8; }
    .es-badge--cancelled      { background: #f1f5f9; color: #94a3b8; }

    .es-cats {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 18px;
    }
    .es-cat {
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 0.6875rem;
        font-weight: 500;
        background: var(--color-blue-ghost);
        color: var(--color-navy);
        border: 1px solid var(--color-blue-pale);
    }

    .es-layout {
        display: grid;
        grid-template-columns: 1fr 210px;
        gap: 14px;
        align-items: start;
    }
    @media (max-width: 680px) {
        .es-layout { grid-template-columns: 1fr; }
    }

    .es-card {
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
    }
    .es-card-body { padding: 16px; }

    .es-poster {
        width: 100%;
        height: 150px;
        border-radius: var(--radius-md) var(--radius-md) 0 0;
        object-fit: cover;
        display: block;
    }
    .es-poster-placeholder {
        width: 100%;
        height: 100px;
        background: linear-gradient(135deg, var(--color-navy) 0%, var(--color-blue) 100%);
        border-radius: var(--radius-md) var(--radius-md) 0 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .es-divider {
        height: 1px;
        background: var(--color-border-soft);
        margin: 12px 0;
    }

    .es-meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 0;
    }
    .es-meta-label {
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--color-ink-muted);
        margin-bottom: 3px;
    }
    .es-meta-val {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--color-ink);
        line-height: 1.3;
    }
    .es-meta-sub {
        font-size: 0.6875rem;
        color: var(--color-ink-muted);
        margin-top: 2px;
    }

    .es-quota-bar-track {
        margin-top: 5px;
        height: 4px;
        background: var(--color-border-soft);
        border-radius: 99px;
        width: 72px;
        overflow: hidden;
    }
    .es-quota-bar {
        height: 100%;
        border-radius: 99px;
        transition: width 0.3s ease;
    }

    .es-text-label {
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--color-ink-muted);
        margin-bottom: 5px;
    }
    .es-text-body {
        font-size: 0.8125rem;
        color: var(--color-ink-soft);
        line-height: 1.65;
        white-space: pre-line;
    }

    .es-rejection {
        background: #fff5f5;
        border: 1px solid #fecaca;
        border-left: 3px solid var(--color-danger);
        border-radius: var(--radius-md);
        padding: 12px 14px;
        display: flex;
        gap: 10px;
        margin-bottom: 12px;
    }
    .es-rejection__icon {
        width: 28px; height: 28px;
        background: #fee2e2;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .es-rejection__title { font-size: 0.75rem; font-weight: 600; color: #991b1b; margin-bottom: 2px; }
    .es-rejection__body  { font-size: 0.75rem; color: #b91c1c; line-height: 1.5; }
    .es-rejection__link  { font-size: 0.6875rem; font-weight: 600; color: #dc2626; text-decoration: underline; text-underline-offset: 2px; display: inline-block; margin-top: 5px; }

    .es-sidebar { display: flex; flex-direction: column; gap: 10px; }

    .es-action-card {
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 14px;
    }
    .es-action-label {
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--color-ink-muted);
        margin-bottom: 10px;
    }

    .es-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 34px;
        border-radius: var(--radius-sm);
        font-family: var(--font-body);
        font-size: 0.8125rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        margin-bottom: 7px;
        border: 1.5px solid transparent;
    }
    .es-btn:last-child { margin-bottom: 0; }
    .es-btn--primary {
        background: var(--color-navy);
        color: #fff;
        border-color: var(--color-navy);
    }
    .es-btn--primary:hover { background: var(--color-navy-dark); color: #fff; }
    .es-btn--outline {
        background: transparent;
        color: var(--color-ink-soft);
        border-color: var(--color-border);
    }
    .es-btn--outline:hover { border-color: var(--color-ink-muted); color: var(--color-ink); }
    .es-btn--danger {
        background: transparent;
        color: var(--color-danger);
        border-color: #fecaca;
    }
    .es-btn--danger:hover { background: #fff5f5; }

    .es-pending-state {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: var(--radius-sm);
        padding: 12px;
        text-align: center;
    }
    .es-pending-state__icon {
        width: 32px; height: 32px;
        background: #fef3c7;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 7px;
    }
    .es-pending-state__title { font-size: 0.75rem; font-weight: 600; color: #92400e; }
    .es-pending-state__sub   { font-size: 0.6875rem; color: #b45309; margin-top: 3px; line-height: 1.4; }

    .es-completed-state {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: var(--radius-sm);
        padding: 12px;
        text-align: center;
    }
    .es-completed-state__icon {
        width: 32px; height: 32px;
        background: #dbeafe;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 7px;
    }
    .es-completed-state__title { font-size: 0.75rem; font-weight: 600; color: #1e40af; }

    .es-stat-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px 0;
    }
    .es-stat-row + .es-stat-row { border-top: 1px solid var(--color-border-soft); }
    .es-stat-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .es-stat-key {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.75rem;
        color: var(--color-ink-soft);
    }
    .es-stat-val { font-size: 0.75rem; font-weight: 700; }

    .es-vol-section {
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        margin-top: 14px;
        overflow: hidden;
    }
    .es-vol-header {
        padding: 12px 16px;
        border-bottom: 1px solid var(--color-border-soft);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .es-vol-title { font-size: 0.875rem; font-weight: 700; color: var(--color-ink); }
    .es-vol-count { font-size: 0.75rem; color: var(--color-ink-muted); }

    .es-vol-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        border-bottom: 1px solid var(--color-border-soft);
        gap: 10px;
        transition: background 0.1s;
    }
    .es-vol-row:last-child { border-bottom: none; }
    .es-vol-row:hover { background: var(--color-bg); }

    .es-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: var(--color-blue-ghost);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--color-navy);
        flex-shrink: 0;
        overflow: hidden;
    }
    .es-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .es-vol-info { flex: 1; min-width: 0; }
    .es-vol-name  { font-size: 0.8125rem; font-weight: 600; color: var(--color-ink); }
    .es-vol-meta  { font-size: 0.6875rem; color: var(--color-ink-muted); margin-top: 1px; }
    .es-vol-notes { font-size: 0.6875rem; color: var(--color-ink-muted); margin-top: 2px; font-style: italic; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 260px; }

    .es-vol-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-top: 4px;
    }
    .es-skill-tag {
        font-size: 0.625rem;
        padding: 2px 7px;
        background: var(--color-blue-ghost);
        color: var(--color-navy);
        border-radius: 99px;
        font-weight: 500;
        border: 1px solid var(--color-blue-pale);
    }

    .es-vol-actions { display: flex; gap: 5px; align-items: center; flex-shrink: 0; }

    .es-btn-xs {
        height: 27px;
        padding: 0 10px;
        border-radius: var(--radius-sm);
        font-family: var(--font-body);
        font-size: 0.6875rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: all 0.12s;
        text-decoration: none;
        border: 1.5px solid transparent;
    }
    .es-btn-xs--detail  { background: transparent; color: var(--color-ink-soft); border-color: var(--color-border); }
    .es-btn-xs--detail:hover { border-color: var(--color-ink-muted); color: var(--color-ink); }
    .es-btn-xs--accept  { background: #22c55e; color: #fff; border-color: #22c55e; }
    .es-btn-xs--accept:hover { background: #16a34a; border-color: #16a34a; }
    .es-btn-xs--reject  { background: transparent; color: var(--color-danger); border-color: #fecaca; }
    .es-btn-xs--reject:hover { background: #fff5f5; }
    .es-btn-xs--attend  { background: var(--color-blue); color: #fff; border-color: var(--color-blue); }
    .es-btn-xs--attend:hover { background: #2563eb; border-color: #2563eb; }

    .es-pill {
        display: inline-flex;
        align-items: center;
        padding: 2px 9px;
        border-radius: 99px;
        font-size: 0.6875rem;
        font-weight: 600;
    }
    .es-pill--confirmed { background: #dcfce7; color: #166534; }
    .es-pill--attended  { background: #dbeafe; color: #1d4ed8; }
    .es-pill--cancelled { background: #f1f5f9; color: #94a3b8; }

    .es-empty {
        padding: 36px 20px;
        text-align: center;
    }
    .es-empty__icon {
        width: 40px; height: 40px;
        background: var(--color-blue-ghost);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 10px;
    }
    .es-empty__title { font-size: 0.8125rem; font-weight: 600; color: var(--color-ink-soft); }
    .es-empty__sub   { font-size: 0.75rem; color: var(--color-ink-muted); margin-top: 3px; line-height: 1.5; }
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

<div class="es-page">

    <a href="{{ route('organizer.events') }}" class="es-back">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
        </svg>
        Kembali ke daftar event
    </a>

    <div class="es-header">
        <h1 class="es-title">{{ $event->title }}</h1>
        <span class="es-badge es-badge--{{ $event->status }}">
            {{ $statusLabels[$event->status] ?? $event->status }}
        </span>
    </div>

    @if($event->categories->count())
        <div class="es-cats">
            @foreach($event->categories as $cat)
                <span class="es-cat">{{ $cat->name }}</span>
            @endforeach
        </div>
    @endif

    <div class="es-layout">
        <div>
            @if($event->status === 'rejected' && $event->rejection_reason)
                <div class="es-rejection">
                    <div class="es-rejection__icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                    </div>
                    <div>
                        <p class="es-rejection__title">Event ditolak oleh admin</p>
                        <p class="es-rejection__body">{{ $event->rejection_reason }}</p>
                        <a href="{{ route('organizer.events.edit', $event->id) }}" class="es-rejection__link">
                            Edit dan ajukan ulang
                        </a>
                    </div>
                </div>
            @endif

            <div class="es-card">
                @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}"
                         alt="{{ $event->title }}"
                         class="es-poster">
                @else
                    <div class="es-poster-placeholder">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.5)" stroke-width="1.2" stroke-linecap="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                    </div>
                @endif

                <div class="es-card-body">
                    <div class="es-meta-grid">
                        <div>
                            <p class="es-meta-label">Tanggal</p>
                            <p class="es-meta-val">
                                {{ $event->start_date->format('d M Y') }}
                                @if($event->start_date->format('Y-m-d') !== $event->end_date->format('Y-m-d'))
                                    <span style="color:var(--color-ink-muted);font-weight:400"> – </span>{{ $event->end_date->format('d M Y') }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="es-meta-label">Waktu</p>
                            <p class="es-meta-val">
                                @if($event->start_time)
                                    {{ $event->start_time }}@if($event->end_time) – {{ $event->end_time }}@endif
                                @else
                                    <span style="color:var(--color-ink-muted);font-weight:400">Belum ditentukan</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="es-meta-label">Lokasi</p>
                            <p class="es-meta-val">{{ $event->location_name }}</p>
                            <p class="es-meta-sub">{{ $event->city }}, {{ $event->province }}</p>
                        </div>
                        <div>
                            <p class="es-meta-label">Kuota</p>
                            <p class="es-meta-val">
                                <span style="color:var(--color-blue)">{{ $event->registered_count }}</span>
                                <span style="color:var(--color-ink-muted);font-weight:400"> / {{ $event->quota }}</span>
                            </p>
                            <div class="es-quota-bar-track">
                                <div class="es-quota-bar" style="width:{{ $pct }}%;background:{{ $barColor }};"></div>
                            </div>
                        </div>
                        @if($event->contact_person)
                            <div>
                                <p class="es-meta-label">Narahubung</p>
                                <p class="es-meta-val">{{ $event->contact_person }}</p>
                                @if($event->contact_phone)
                                    <p class="es-meta-sub">{{ $event->contact_phone }}</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if($event->requirements || $event->description)
                        <div class="es-divider"></div>
                    @endif

                    @if($event->requirements)
                        <div style="margin-bottom:12px;">
                            <p class="es-text-label">Persyaratan</p>
                            <p class="es-text-body">{{ $event->requirements }}</p>
                        </div>
                    @endif

                    @if($event->description)
                        <div>
                            <p class="es-text-label">Deskripsi Event</p>
                            <p class="es-text-body">{{ $event->description }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="es-sidebar">
            <div class="es-action-card">
                <p class="es-action-label">Aksi</p>

                @if($event->status === 'draft')
                    <a href="{{ route('organizer.events.edit', $event->id) }}" class="es-btn es-btn--outline">
                        Edit Event
                    </a>
                    <form action="{{ route('organizer.events.submit', $event->id) }}" method="POST"
                          onsubmit="return confirm('Ajukan event ini ke review admin?')">
                        @csrf
                        <button type="submit" class="es-btn es-btn--primary">Ajukan ke Review</button>
                    </form>
                    <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus event ini? Tindakan ini tidak dapat diurungkan.')">
                        @csrf
                        <button type="submit" class="es-btn es-btn--danger">Hapus Event</button>
                    </form>

                @elseif($event->status === 'rejected')
                    <a href="{{ route('organizer.events.edit', $event->id) }}" class="es-btn es-btn--primary">
                        Edit &amp; Ajukan Ulang
                    </a>
                    <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus event ini?')">
                        @csrf
                        <button type="submit" class="es-btn es-btn--danger">Hapus Event</button>
                    </form>

                @elseif($event->status === 'pending_review')
                    <div class="es-pending-state">
                        <div class="es-pending-state__icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <p class="es-pending-state__title">Sedang ditinjau admin</p>
                        <p class="es-pending-state__sub">Kamu akan mendapat notifikasi setelah ditinjau.</p>
                    </div>

                @elseif($event->status === 'published')
                    <a href="{{ route('organizer.events.edit', $event->id) }}" class="es-btn es-btn--outline">
                        Edit Event
                    </a>
                    <form action="{{ route('organizer.events.complete', $event->id) }}" method="POST"
                          onsubmit="return confirm('Tandai event ini sebagai selesai? Tindakan ini tidak dapat diurungkan.')">
                        @csrf
                        <button type="submit" class="es-btn es-btn--primary">Tandai Selesai</button>
                    </form>

                @elseif($event->status === 'completed')
                    <div class="es-completed-state">
                        <div class="es-completed-state__icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5" stroke-linecap="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        <p class="es-completed-state__title">Event telah selesai</p>
                    </div>

                @elseif($event->status === 'cancelled')
                    <div style="background:#f8fafc;border:1px solid var(--color-border);border-radius:var(--radius-sm);padding:12px;text-align:center;">
                        <p style="font-size:0.75rem;color:var(--color-ink-muted);">Event dibatalkan</p>
                    </div>
                @endif
            </div>
            <div class="es-action-card">
                <p class="es-action-label">Volunteer</p>
                <div class="es-stat-row">
                    <div class="es-stat-key">
                        <div class="es-stat-dot" style="background:#f59e0b;"></div>
                        Menunggu
                    </div>
                    <span class="es-stat-val" style="color:#d97706;">{{ $pending }}</span>
                </div>
                <div class="es-stat-row">
                    <div class="es-stat-key">
                        <div class="es-stat-dot" style="background:#22c55e;"></div>
                        Dikonfirmasi
                    </div>
                    <span class="es-stat-val" style="color:#16a34a;">{{ $confirmed }}</span>
                </div>
                <div class="es-stat-row">
                    <div class="es-stat-key">
                        <div class="es-stat-dot" style="background:#3b82f6;"></div>
                        Hadir
                    </div>
                    <span class="es-stat-val" style="color:#2563eb;">{{ $attended }}</span>
                </div>
                <div class="es-stat-row">
                    <div class="es-stat-key">
                        <div class="es-stat-dot" style="background:#d1d5db;"></div>
                        Dibatalkan
                    </div>
                    <span class="es-stat-val" style="color:#9ca3af;">{{ $cancelled }}</span>
                </div>
            </div>

        </div>
    </div>

    <div class="es-vol-section">
        <div class="es-vol-header">
            <p class="es-vol-title">Daftar Volunteer</p>
            <p class="es-vol-count">{{ $event->registrations->count() }} pendaftar</p>
        </div>

        @forelse($event->registrations as $reg)
            <div class="es-vol-row">

                <div class="es-avatar">
                    @if($reg->user->volunteerProfile?->avatar)
                        <img src="{{ asset('storage/' . $reg->user->volunteerProfile->avatar) }}"
                             alt="{{ $reg->user->name }}">
                    @else
                        {{ strtoupper(substr($reg->user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="es-vol-info">
                    <p class="es-vol-name">{{ $reg->user->name }}</p>
                    <p class="es-vol-meta">
                        {{ $reg->user->email }}
                        @if($reg->user->volunteerProfile?->city)
                            · {{ $reg->user->volunteerProfile->city }}, {{ $reg->user->volunteerProfile->province }}
                        @endif
                    </p>
                    @if($reg->user->volunteerProfile?->skills)
                        <div class="es-vol-skills">
                            @foreach(array_slice((array) $reg->user->volunteerProfile->skills, 0, 3) as $skill)
                                <span class="es-skill-tag">{{ $skill }}</span>
                            @endforeach
                            @if(count((array) $reg->user->volunteerProfile->skills) > 3)
                                <span style="font-size:0.6875rem;color:var(--color-ink-muted);">
                                    +{{ count((array) $reg->user->volunteerProfile->skills) - 3 }}
                                </span>
                            @endif
                        </div>
                    @endif
                    @if($reg->notes)
                        <p class="es-vol-notes">"{{ $reg->notes }}"</p>
                    @endif
                </div>

                <div class="es-vol-actions">
                    <a href="{{ route('organizer.volunteers.show', $reg->id) }}" class="es-btn-xs es-btn-xs--detail">
                        Detail
                    </a>

                    @if($reg->status === 'pending')
                        <form action="{{ route('organizer.confirm', $reg->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="es-btn-xs es-btn-xs--accept">Terima</button>
                        </form>
                        <form action="{{ route('organizer.reject', $reg->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="es-btn-xs es-btn-xs--reject">Tolak</button>
                        </form>

                    @elseif($reg->status === 'confirmed')
                        @if($event->status === 'completed' || $event->start_date->lte(now()))
                            <form action="{{ route('organizer.attend', $reg->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="es-btn-xs es-btn-xs--attend">Tandai Hadir</button>
                            </form>
                        @else
                            <span class="es-pill es-pill--confirmed">Diterima</span>
                        @endif

                    @elseif($reg->status === 'attended')
                        <span class="es-pill es-pill--attended">Hadir</span>

                    @elseif($reg->status === 'cancelled')
                        <span class="es-pill es-pill--cancelled">Dibatalkan</span>
                    @endif
                </div>

            </div>
        @empty
            <div class="es-empty">
                <div class="es-empty__icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3B82F6" stroke-width="1.5" stroke-linecap="round">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                        <path d="M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <p class="es-empty__title">Belum ada volunteer yang mendaftar</p>
                <p class="es-empty__sub">Volunteer akan muncul di sini setelah event dipublikasikan.</p>
            </div>
        @endforelse
    </div>

</div>

@endsection
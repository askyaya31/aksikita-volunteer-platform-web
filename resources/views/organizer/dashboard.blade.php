@extends('layouts.organizer')
@section('title', 'Dashboard Organizer')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --navy:        #0F2057;
        --blue:        #0066FF;
        --blue-mid:    #4D8DFF;
        --blue-light:  #93C5FD;
        --blue-pale:   #DCE9FF;
        --sky-50:      #F6F9FF;
        --ink:         #1F2937;
        --ink-muted:   #6B7280;
        --border-soft: #EEF0F6;
        --font-display:'Plus Jakarta Sans', sans-serif;
        --font-body:   'Inter', sans-serif;
    }

    .ak-container, body { font-family: var(--font-body); }
    .org-hero-name, .org-section-title, .org-stat-num,
    .org-event-title, .org-hero-card-name { font-family: var(--font-display); }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: none; }
    }
    @keyframes pulseDot {
        0%,100% { box-shadow: 0 0 0 2px rgba(220,233,255,0.35); }
        50%      { box-shadow: 0 0 0 6px rgba(220,233,255,0.12); }
    }
    @media (prefers-reduced-motion: reduce) {
        * { animation: none !important; transition: none !important; }
    }
    .org-hero {
        background: linear-gradient(125deg, var(--navy) 0%, var(--blue) 65%, var(--blue-mid) 100%);
        padding: 3rem 0 5.5rem;
        position: relative;
        overflow: hidden;
        border-radius: 0 0 28px 28px;
    }
    .org-hero::after {
        content: '';
        position: absolute;
        width: 320px; height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(220,233,255,0.22) 0%, transparent 70%);
        top: -110px; right: -70px;
        pointer-events: none;
    }
    .org-hero-inner {
        position: relative; z-index: 1;
        display: flex; align-items: center; justify-content: space-between;
        gap: 2rem; flex-wrap: wrap;
    }
    .org-hero-left { flex: 1; min-width: 240px; }

    .org-hero-eyebrow {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 12px; font-weight: 600;
        color: rgba(255,255,255,0.62);
        letter-spacing: 0.08em; text-transform: uppercase;
        margin-bottom: 12px;
    }
    .org-hero-eyebrow-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--blue-pale);
        animation: pulseDot 2.2s ease-in-out infinite;
    }

    .org-hero-greeting { font-size: 14px; font-weight: 400; color: rgba(255,255,255,0.65); margin: 0 0 2px; }
    .org-hero-name {
        font-size: clamp(1.7rem, 3.2vw, 2.3rem); font-weight: 800;
        color: #fff; line-height: 1.2; margin: 0 0 18px;
        letter-spacing: -0.02em;
        max-width: 480px;
    }

    .org-hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .org-hero-cta {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 24px;
        background: #FFFFFF; color: var(--navy);
        border-radius: 999px;
        font-size: 13.5px; font-weight: 700;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        transition: all 0.2s ease;
    }
    .org-hero-cta:hover { background: var(--blue-pale); transform: translateY(-1px); color: var(--navy); }
    .org-hero-cta--ghost {
        background: rgba(255,255,255,0.1);
        border: 1.5px solid rgba(255,255,255,0.3);
        color: rgba(255,255,255,0.92);
        box-shadow: none;
    }
    .org-hero-cta--ghost:hover { background: rgba(255,255,255,0.2); border-color: rgba(255,255,255,0.5); color: #fff; }
    .org-hero-card {
        flex-shrink: 0;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.22);
        border-radius: 22px;
        padding: 22px 26px;
        display: flex; flex-direction: column; align-items: center; gap: 12px;
        min-width: 200px;
        box-shadow: 0 18px 40px rgba(8,16,45,0.22);
    }
    .org-hero-avatar {
        width: 72px; height: 72px; border-radius: 18px;
        background: linear-gradient(140deg, var(--blue-light), var(--blue-mid));
        border: 3px solid rgba(255,255,255,0.3);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.7rem; font-weight: 800; color: #fff;
        overflow: hidden; flex-shrink: 0;
    }
    .org-hero-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .org-hero-card-name {
        font-size: 13px; font-weight: 700; color: #fff;
        text-align: center; line-height: 1.3;
        max-width: 160px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .org-hero-card-stats { display: flex; gap: 12px; width: 100%; }
    .org-hero-card-stat {
        flex: 1; text-align: center; padding: 9px 6px;
        background: rgba(255,255,255,0.08);
        border-radius: 12px; border: 1px solid rgba(255,255,255,0.14);
    }
    .org-hero-card-stat-val { font-family: var(--font-display); font-size: 1.3rem; font-weight: 800; color: #fff; line-height: 1; }
    .org-hero-card-stat-lbl { font-size: 9.5px; color: rgba(255,255,255,0.55); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; margin-top: 3px; }
    .org-stats-wrap { margin-top: -56px; position: relative; z-index: 10; margin-bottom: 2.5rem; }
    .org-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
    .org-stat-card {
        background: #fff; border-radius: 18px;
        padding: 1.2rem 1.4rem;
        box-shadow: 0 10px 28px rgba(15,32,87,0.08);
        border: 1px solid var(--border-soft);
        border-left: 3px solid var(--stat-accent, var(--navy));
        opacity: 0; animation: fadeInUp 0.5s ease forwards;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .org-stat-card:hover { transform: translateY(-3px); box-shadow: 0 16px 34px rgba(15,32,87,0.13); }
    .org-stat-card:nth-child(1) { animation-delay: 0.05s; --stat-accent: var(--blue); }
    .org-stat-card:nth-child(2) { animation-delay: 0.12s; --stat-accent: #D97706; }
    .org-stat-card:nth-child(3) { animation-delay: 0.19s; --stat-accent: #059669; }
    .org-stat-card:nth-child(4) { animation-delay: 0.26s; --stat-accent: #7C3AED; }

    .org-stat-num { font-size: 1.8rem; font-weight: 800; color: var(--navy); line-height: 1.1; }
    .org-stat-label {
        font-size: 0.74rem; font-weight: 600; color: var(--ink-muted); margin-top: 4px;
        text-transform: uppercase; letter-spacing: 0.04em;
    }

    @media (max-width: 960px) { .org-stats { grid-template-columns: repeat(2, 1fr); } }
    .ak-card-flat {
        background: #FFFFFF; border: 1px solid var(--border-soft);
        border-radius: 28px; padding: 2.25rem 2rem;
        opacity: 0; animation: fadeInUp 0.5s ease forwards; animation-delay: 0.3s;
    }
    .org-section-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 1.75rem; }
    .org-section-title { font-size: 1.3rem; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
    .org-section-sub   { font-size: 0.85rem; color: var(--ink-muted); }

    .org-section-link {
        font-size: 0.85rem; font-weight: 600; color: var(--ink);
        text-decoration: none; display: flex; align-items: center; gap: 8px;
        border: 1.5px solid var(--blue-light);
        padding: 8px 20px; border-radius: 999px;
        transition: all 0.2s; flex-shrink: 0; white-space: nowrap;
    }
    .org-section-link:hover { background: var(--sky-50); border-color: var(--blue); color: var(--navy); }
    .org-recent-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 1.25rem;
    }

    .org-event-card {
        background: #FFFFFF;
        border: 1px solid var(--border-soft);
        border-radius: 20px;
        overflow: hidden;
        display: flex; flex-direction: column;
        text-decoration: none;
        box-shadow: 0 2px 10px rgba(15,32,87,0.05);
        transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
    }
    .org-event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 38px rgba(15,32,87,0.16);
        border-color: var(--blue-light);
    }

    .org-event-card__media {
        position: relative;
        height: 132px;
        overflow: hidden;
        display: flex; align-items: center; justify-content: center;
    }
    .org-event-card__media img {
        position: absolute; inset: 0;
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.5s ease;
    }
    .org-event-card:hover .org-event-card__media img { transform: scale(1.08); }
    .org-event-card__media-icon {
        position: relative; z-index: 1;
        font-family: var(--font-display);
        font-size: 2.6rem; font-weight: 800;
        color: rgba(255,255,255,0.32);
        letter-spacing: -0.02em;
    }

    .status-badge {
        font-size: 0.68rem; font-weight: 700;
        padding: 5px 13px; border-radius: 999px;
        background-color: #10B981; color: #FFFFFF;
        text-transform: uppercase; letter-spacing: 0.03em;
        white-space: nowrap;
        position: absolute; top: 10px; left: 10px; z-index: 2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.18);
    }
    .status-badge.ux-danger   { background-color: #EF4444; }
    .status-badge.ux-warning  { background-color: #F59E0B; }
    .status-badge.ux-neutral  { background-color: #6B7280; }
    .org-event-card__date {
        position: absolute; top: 10px; right: 10px; z-index: 2;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(4px);
        border-radius: 10px;
        padding: 5px 9px;
        text-align: center;
        min-width: 38px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.16);
    }
    .org-event-card__date-d { font-size: 0.95rem; font-weight: 800; color: var(--navy); line-height: 1; }
    .org-event-card__date-m { font-size: 8px; font-weight: 700; color: var(--ink-muted); text-transform: uppercase; letter-spacing: 0.04em; }

    .org-event-card__body {
        padding: 14px 16px 0;
        display: flex; flex-direction: column; gap: 8px; flex: 1;
    }

    .org-event-card__cats { display: flex; gap: 5px; flex-wrap: wrap; }
    .org-event-card__cat {
        font-size: 9.5px; font-weight: 700;
        padding: 3px 10px; border-radius: 999px;
        background: var(--sky-50); color: var(--navy);
        border: 1px solid var(--blue-pale);
        text-transform: uppercase; letter-spacing: 0.03em;
    }

    .org-event-title {
        font-size: 0.96rem; font-weight: 700; color: var(--ink); line-height: 1.35;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .org-event-meta-item {
        display: flex; align-items: center; gap: 5px;
        font-size: 0.78rem; color: var(--ink-muted); font-weight: 500;
    }

    .org-event-card__quota { margin-top: 2px; }
    .org-event-card__quota-row {
        display: flex; align-items: center; justify-content: space-between;
        font-size: 0.74rem; font-weight: 600; color: var(--ink-muted);
        margin-bottom: 4px;
    }
    .org-event-card__quota-row strong { color: var(--navy); font-weight: 700; }
    .org-event-card__quota-bar {
        height: 5px; background: var(--sky-50); border-radius: 999px; overflow: hidden;
    }
    .org-event-card__quota-fill {
        height: 100%; border-radius: 999px;
        background: linear-gradient(90deg, var(--navy), var(--blue));
    }
    .org-event-card__quota-fill.is-full { background: linear-gradient(90deg, #B45309, #F59E0B); }

    .org-event-card__footer {
        display: flex; align-items: center; justify-content: flex-end;
        padding: 12px 16px 16px; margin-top: auto;
    }
    .org-event-detail {
        font-size: 0.78rem; font-weight: 700;
        padding: 7px 18px; border-radius: 999px;
        background-color: var(--navy); color: #FFFFFF !important;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 5px;
        transition: background 0.18s, transform 0.18s, gap 0.18s;
    }
    .org-event-card:hover .org-event-detail { background: var(--blue); gap: 8px; }
    .ak-empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 64px 24px; text-align: center; }
    .ak-empty-state-icon {
        width: 64px; height: 64px; border-radius: 18px;
        background: var(--sky-50); border: 1px solid var(--border-soft);
        display: flex; align-items: center; justify-content: center;
        color: var(--blue); margin-bottom: 18px;
    }
    .ak-empty-state-text { font-size: 1.05rem; color: var(--ink); font-weight: 500; margin-bottom: 1.5rem; }
    .btn-empty-add {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 26px; background: var(--navy);
        color: #fff; font-weight: 700; font-size: 0.85rem;
        border-radius: 999px; text-decoration: none;
        transition: background 0.18s, transform 0.18s;
    }
    .btn-empty-add:hover { background: var(--blue); transform: translateY(-1px); color: #fff; }

    @media (max-width: 640px) {
        .org-hero-card { display: none; }
        .org-hero-inner { flex-direction: column; align-items: flex-start; }
        .org-recent-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

@php
    $orgInitial = strtoupper(substr($org->organization_name ?? 'O', 0, 1));
@endphp

<section class="org-hero">
    <div class="ak-container org-hero-inner">

        <div class="org-hero-left">
            <div class="org-hero-eyebrow">
                Dashboard Organisasi
            </div>
            <p class="org-hero-greeting">Selamat datang,</p>
            <h1 class="org-hero-name">{{ $org->organization_name }}</h1>

            <div class="org-hero-actions">
                <a href="{{ route('organizer.events.create') }}" class="org-hero-cta">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Buat Event
                </a>
                <a href="{{ route('organizer.events') }}" class="org-hero-cta org-hero-cta--ghost">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/>
                    </svg>
                    Kelola Event
                </a>
            </div>
        </div>

        <div class="org-hero-card">
            <div class="org-hero-avatar">
                @if($org->logo ?? false)
                    <img src="{{ asset('storage/' . $org->logo) }}" alt="{{ $org->organization_name }}">
                @else
                    {{ $orgInitial }}
                @endif
            </div>
            <div class="org-hero-card-name">{{ $org->organization_name }}</div>
            <div class="org-hero-card-stats">
                <div class="org-hero-card-stat">
                    <div class="org-hero-card-stat-val" data-count="{{ $stats['published'] }}">0</div>
                    <div class="org-hero-card-stat-lbl">Aktif</div>
                </div>
                <div class="org-hero-card-stat">
                    <div class="org-hero-card-stat-val" data-count="{{ $stats['volunteers'] }}">0</div>
                    <div class="org-hero-card-stat-lbl">Kandidat</div>
                </div>
            </div>
        </div>

    </div>
</section>

<div class="ak-container">
    <div class="org-stats-wrap">
        <div class="org-stats">
            <div class="org-stat-card">
                <div class="org-stat-num" data-count="{{ $stats['total'] }}">0</div>
                <div class="org-stat-label">Total Event</div>
            </div>
            <div class="org-stat-card">
                <div class="org-stat-num" data-count="{{ $stats['pending'] }}">0</div>
                <div class="org-stat-label">Menunggu Review</div>
            </div>
            <div class="org-stat-card">
                <div class="org-stat-num" data-count="{{ $stats['published'] }}">0</div>
                <div class="org-stat-label">Event Aktif</div>
            </div>
            <div class="org-stat-card">
                <div class="org-stat-num" data-count="{{ $stats['volunteers'] }}">0</div>
                <div class="org-stat-label">Total Kandidat</div>
            </div>
        </div>
    </div>

    @php
        $statusClasses = [
            'published'      => '',
            'pending_review' => 'ux-warning',
            'rejected'       => 'ux-danger',
            'cancelled'      => 'ux-danger',
            'draft'          => 'ux-neutral',
            'completed'      => 'ux-neutral',
        ];

        $statusLabels = [
            'draft'          => 'Draft',
            'pending_review' => 'Review',
            'published'      => 'Aktif',
            'rejected'       => 'Ditolak',
            'completed'      => 'Selesai',
            'cancelled'      => 'Batal',
        ];
        $mediaGradients = [
            'published'      => 'linear-gradient(135deg, #1D4ED8, #60A5FA)',
            'pending_review' => 'linear-gradient(135deg, #B45309, #FBBF24)',
            'rejected'       => 'linear-gradient(135deg, #991B1B, #F87171)',
            'cancelled'      => 'linear-gradient(135deg, #991B1B, #F87171)',
            'draft'          => 'linear-gradient(135deg, #4B5563, #9CA3AF)',
            'completed'      => 'linear-gradient(135deg, #0F2057, #4D8DFF)',
        ];
    @endphp

    <div class="ak-card-flat" style="margin-bottom: 4rem;">

        @if(count($recentEvents) > 0)

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

            <div class="org-recent-grid">
                @foreach($recentEvents as $event)
                    @php
                        $gradient = $mediaGradients[$event->status] ?? $mediaGradients['draft'];
                    @endphp
                    <a href="{{ route('organizer.events.show', $event->id) }}" class="org-event-card" style="animation: fadeInUp 0.5s ease forwards; animation-delay: {{ 0.35 + min($loop->index * 0.05, 0.3) }}s; opacity: 0;">

                        <div class="org-event-card__media" style="background: {{ $gradient }};">
                            <span class="status-badge {{ $statusClasses[$event->status] ?? 'ux-neutral' }}">
                                {{ $statusLabels[$event->status] ?? $event->status }}
                            </span>

                            @if($event->start_date)
                                <div class="org-event-card__date">
                                    <div class="org-event-card__date-d">{{ $event->start_date->format('d') }}</div>
                                    <div class="org-event-card__date-m">{{ $event->start_date->translatedFormat('M') }}</div>
                                </div>
                            @endif

                            @if($event->poster)
                                <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
                            @else
                                <svg class="org-event-card__media-icon" width="46" height="46" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>

                        <div class="org-event-card__body">
                            <p class="org-event-title">{{ $event->title }}</p>
                            <span class="org-event-meta-item">
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.3"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $event->city }}
                            </span>
                        </div>

                        <div class="org-event-card__footer">
                            <span class="org-event-detail">
                                Detail
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

        @else

            <div class="ak-empty-state">
                <div class="ak-empty-state-icon">
                    <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="ak-empty-state-text">Belum ada event yang terdaftar.</p>
                <a href="{{ route('organizer.events.create') }}" class="btn-empty-add">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Buat Event
                </a>
            </div>

        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const statEls = document.querySelectorAll('[data-count]');
    statEls.forEach(el => {
        const target = parseInt(el.dataset.count || '0', 10);
        if (!target) { el.textContent = '0'; return; }
        let current = 0;
        const duration = 900;
        const start = performance.now();
        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            current = Math.round(target * (1 - Math.pow(1 - progress, 3)));
            el.textContent = current;
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    });
});
</script>
@endpush
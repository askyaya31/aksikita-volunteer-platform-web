@extends('layouts.volunteer')
@section('title', 'Dashboard — AksiKita')

@push('styles')
<style>

/* ══════════════════════════════════════
   HERO
══════════════════════════════════════ */
.dash-hero {
    background: linear-gradient(135deg, #0F2057 0%, #1A3575 60%, #2A4A9C 100%);
    padding: 2.5rem 0 3rem;
    position: relative; overflow: hidden;
}
.dash-hero-greeting {
    font-size: 12.5px; font-weight: 500;
    color: rgba(255,255,255,0.6); margin-bottom: 4px;
}
.dash-hero-name {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 26px; font-weight: 700;
    color: #fff; line-height: 1.2; margin-bottom: 6px;
}
.dash-hero-sub {
    font-size: 13.5px; color: rgba(255,255,255,0.6); margin-bottom: 22px;
}
.dash-hero-cta {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 22px;
    background: rgba(255,255,255,0.12);
    border: 1.5px solid rgba(255,255,255,0.28);
    border-radius: 999px;
    color: rgba(255,255,255,0.9);
    font-size: 13px; font-weight: 500;
    text-decoration: none;
    transition: background 0.15s, border-color 0.15s;
}
.dash-hero-cta:hover {
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.45); color: #fff;
}

/* ══════════════════════════════════════
   PAGE BODY
══════════════════════════════════════ */
.dash-page {
    background: #F7F8FC;
    padding: 2rem 0 4rem;
}
.dash-sec-wrap { margin-bottom: 2.5rem; }
.dash-sec-head, .dash-section-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1rem;
}
.dash-sec-title, .dash-section-title {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 1.0625rem; font-weight: 700; color: #0F2057;
    margin-bottom: 2px;
}
.dash-sec-sub {
    font-size: 0.775rem; color: #9CA3AF;
}
.dash-see-all {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12.5px; font-weight: 600; color: #0F2057;
    text-decoration: none; white-space: nowrap;
    transition: gap 0.15s;
}
.dash-see-all:hover { gap: 8px; }

/* ══════════════════════════════════════
   AGENDA ROW (Agenda Terdekat)
══════════════════════════════════════ */
.agenda-list {
    display: flex; flex-direction: column; gap: 10px;
}
.agenda-row {
    display: flex; align-items: center; gap: 16px;
    padding: 14px 18px;
    background: #fff;
    border: 1px solid #EEF0F6;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(15,32,87,0.05);
    transition: box-shadow 0.15s;
    text-decoration: none;
}
.agenda-row:hover { box-shadow: 0 4px 16px rgba(15,32,87,0.10); }

/* date block */
.agenda-date {
    flex-shrink: 0; width: 36px; text-align: center;
}
.agenda-date-dd {
    font-family: 'Fraunces', serif;
    font-size: 18px; font-weight: 700; color: #0F2057;
    line-height: 1;
}
.agenda-date-mm {
    font-size: 11px; font-weight: 600; color: #9CA3AF;
    text-transform: uppercase; letter-spacing: 0.04em;
}

/* divider */
.agenda-divider {
    width: 1px; height: 36px; background: #EEF0F6; flex-shrink: 0;
}

/* info */
.agenda-info { flex: 1; min-width: 0; }
.agenda-title {
    font-size: 13.5px; font-weight: 700; color: #0F2057;
    margin-bottom: 2px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.agenda-meta {
    font-size: 11.5px; color: #9CA3AF;
}

/* right side */
.agenda-right {
    display: flex; align-items: center; gap: 8px; flex-shrink: 0;
}
.agenda-badge {
    padding: 4px 12px; border-radius: 999px;
    font-size: 11px; font-weight: 700;
    background: #10B981; color: #fff;
}
.agenda-badge.pending  { background: #F59E0B; }
.agenda-badge.rejected { background: #EF4444; }
.agenda-badge.done     { background: #6B7280; }
.agenda-detail-btn {
    padding: 6px 16px; border-radius: 999px;
    font-size: 12px; font-weight: 700;
    background: #0F2057; color: #fff;
    text-decoration: none; border: none; cursor: pointer;
    transition: background 0.15s;
    white-space: nowrap;
}

/* ══════════════════════════════════════
   EVENTS GRID & SHARED ECARD (Dari index)
══════════════════════════════════════ */
.events-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.ecard {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    display: flex; flex-direction: column;
    box-shadow: 0 2px 4px rgba(15,32,87,0.04);
    text-decoration: none;
    transition: box-shadow 0.2s, transform 0.2s;
}
.ecard:hover {
    box-shadow: 0 8px 32px rgba(15,32,87,0.12);
    transform: translateY(-3px);
}
.ecard-img {
    height: 160px;
    position: relative; 
    display: flex; align-items: flex-end; padding: 12px;
}
.ecard-cats { 
    display: flex; gap: 6px; flex-wrap: wrap; 
}
.ecard-cat {
    font-size: 10px; font-weight: 700;
    padding: 4px 12px; border-radius: 999px;
    background: #fff; color: #1A3575;
    border: 1px solid #1A3575;
    text-transform: uppercase; letter-spacing: 0.5px;
}
.ecard-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
.ecard-org {
    font-size: 11px; font-weight: 600; color: #5A6278;
    text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;
}
.ecard-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 16px; font-weight: 700; color: #1A3575;
    line-height: 1.4; margin-bottom: 12px; flex: 1;
}
.ecard-meta { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
.ecard-meta-row {
    display: flex; align-items: center; gap: 8px;
    font-size: 12px; color: #5A6278; font-weight: 500;
}
.ecard-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 14px; border-top: 1px solid #EEF0F6;
}
.ecard-slots { font-size: 13px; font-weight: 600; color: #5A6278; display: flex; align-items: center; gap: 6px; }
.ecard-btn {
    padding: 8px 24px; background: #1A3575; color: #fff;
    border-radius: 999px; font-size: 13px; font-weight: 600;
    text-decoration: none; transition: all 0.15s;
}
.ecard-btn:hover { background: #0F2057; }

/* ══════════════════════════════════════
   CATEGORY CHIPS
══════════════════════════════════════ */
.cat-chips {
    display: flex; gap: 7px; flex-wrap: wrap; margin-bottom: 0.85rem;
}
.cat-chip {
    display: inline-flex; align-items: center;
    padding: 5px 16px; border-radius: 999px;
    font-size: 12.5px; font-weight: 500;
    border: 1.5px solid #E5E7EB;
    background: #fff; color: #6B7280;
    text-decoration: none; transition: all .12s;
}
.cat-chip:hover { border-color: #0F2057; color: #0F2057; background: #EEF3FF; }
.cat-chip.active {
    background: #0F2057; border-color: #0F2057;
    color: #fff; font-weight: 600;
}

/* results count */
.dash-results {
    display: flex; align-items: center; gap: 5px;
    font-size: 12.5px; color: #6B7280; margin-bottom: 1rem;
}
.dash-results svg { color: #E8501A; }

/* ══════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════ */
@media (max-width: 900px) {
    .events-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 580px) {
    .events-grid { grid-template-columns: 1fr; }
    .dash-hero { padding: 2rem 0 2.25rem; }
    .dash-hero-name { font-size: 22px; }
    .agenda-title { font-size: 12.5px; }
}
</style>
@endpush

@section('content')

<div class="dash-hero">
    <div class="ak-container">
        <p class="dash-hero-greeting">Selamat datang,</p>
        <h1 class="dash-hero-name">{{ session('user_name', 'Relawan') }}</h1>
        <p class="dash-hero-sub">Temukan kegiatan yang bermakna untuk Indonesia</p>
        <a href="{{ route('volunteer.events') }}" class="dash-hero-cta">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Cari Kegiatan
        </a>
    </div>
</div>

<div class="dash-page">
    <div class="ak-container">
        <div class="dash-stats-wrap">
            <div class="dash-stats">

            {{-- ─────────────────────────────
                 SECTION 1 · Agenda Terdekat
            ───────────────────────────────── --}}
            @php
                $agendaEvents = \App\Models\Registration::with(['event'])
                    ->where('user_id', auth()->id())
                    ->whereIn('status', ['accepted', 'pending'])
                    ->whereHas('event', fn($q) => $q->where('start_date', '>=', now()))
                    ->orderBy('created_at')
                    ->take(5)
                    ->get();

                $statusLabel = [
                    'accepted' => 'Diterima',
                    'pending'  => 'Pending',
                    'rejected' => 'Ditolak',
                    'done'     => 'Selesai',
                ];
                $statusClass = [
                    'accepted' => '',
                    'pending'  => 'pending',
                    'rejected' => 'rejected',
                    'done'     => 'done',
                ];
            @endphp

            <div class="dash-sec-wrap">
                <div class="dash-sec-head">
                    <p class="dash-sec-title">Agenda Terdekat</p>
                    <a href="{{ route('volunteer.history') }}" class="dash-see-all">
                        Lihat Semua
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                @if($agendaEvents->count())
                    <div class="agenda-list">
                        @foreach($agendaEvents as $reg)
                            @php $ev = $reg->event; @endphp
                            <div class="agenda-row">
                                {{-- Date --}}
                                <div class="agenda-date">
                                    <div class="agenda-date-dd">{{ $ev->start_date->format('d') }}</div>
                                    <div class="agenda-date-mm">{{ $ev->start_date->format('M') }}</div>
                                </div>

                                <div class="agenda-divider"></div>

                                {{-- Info --}}
                                <div class="agenda-info">
                                    <p class="agenda-title">{{ $ev->title }}</p>
                                    <p class="agenda-meta">
                                        {{ $ev->start_date->format('H:i') }} &middot; {{ $ev->city }}
                                    </p>
                                </div>

                                {{-- Right: badge + button --}}
                                <div class="agenda-right">
                                    <span class="agenda-badge {{ $statusClass[$reg->status] ?? '' }}">
                                        {{ $statusLabel[$reg->status] ?? $reg->status }}
                                    </span>
                                    <a href="{{ route('volunteer.events.show', $ev->slug) }}"
                                       class="agenda-detail-btn">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="font-size:13px;color:#9CA3AF;padding:24px 0;">
                        Kamu belum punya agenda kegiatan mendatang.
                    </p>
                @endif
            </div>

            {{-- ─────────────────────────────
                 SECTION 2 · Rekomendasi (by kota)
            ───────────────────────────────── --}}
            @php
                $openEvents = \App\Models\Event::with(['categories', 'organization'])
                    ->where('status', 'published')
                    ->when(request('category'), function ($q) {
                        $q->whereHas('categories', fn($c) => $c->where('slug', request('category')));
                    })
                    ->latest()
                    ->get();
            @endphp

            <div class="dash-sec-wrap">
                <div class="dash-sec-head">
                    <div>
                        <p class="dash-sec-title">Rekomendasi untuk Anda</p>
                        <p class="dash-sec-sub">Kegiatan berdasarkan minat dan riwayat kegiatanmu</p>
                    </div>
                </div>

                {{-- Category chips --}}
                <div class="cat-chips">
                    <a href="{{ route('volunteer.dashboard') }}"
                       class="cat-chip {{ !request('category') ? 'active' : '' }}">All</a>
                    @foreach([
                        ['slug' => 'lingkungan', 'label' => 'Lingkungan'],
                        ['slug' => 'pendidikan', 'label' => 'Pendidikan'],
                        ['slug' => 'kesehatan',  'label' => 'Kesehatan'],
                        ['slug' => 'sosial',     'label' => 'Sosial'],
                    ] as $cat)
                        <a href="{{ route('volunteer.dashboard', ['category' => $cat['slug']]) }}"
                           class="cat-chip {{ request('category') === $cat['slug'] ? 'active' : '' }}">
                            {{ $cat['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- Results count --}}
                <div class="dash-results">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    {{ $openEvents->count() }} Kegiatan Ditemukan
                </div>

                <section>
                    <div class="dash-section-head">
                        <div class="dash-section-title">Kegiatan Tersedia</div>
                        <a href="{{ route('volunteer.events') }}" class="dash-see-all">
                            Jelajahi semua
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    @if($openEvents->count())
                        <div class="events-grid">
                            @foreach($openEvents as $event)
                                {{-- Memanggil komponen card yang sama dengan index.blade.php --}}
                                @include('components.event-card', ['event' => $event])
                            @endforeach
                        </div>
                    @else
                        <p style="font-size:13px;color:#9CA3AF;text-align:center;padding:40px 0;">
                            Tidak ada kegiatan yang tersedia saat ini.
                        </p>
                    @endif
                </section>
            </div>

            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.volunteer')
@section('title', 'Dashboard — AksiKita')

@push('styles')
<style>
.dash-hero {
    background: linear-gradient(135deg, #0F2057 0%, #1A3575 60%, #2A4A9C 100%);
    padding: 2.5rem 0 4.5rem;
    position: relative;
    overflow: hidden;
}
.dash-hero::before {
    content: '';
    position: absolute;
    right: -80px; top: -80px;
    width: 320px; height: 320px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
    pointer-events: none;
}
.dash-hero::after {
    content: '';
    position: absolute;
    right: 80px; bottom: -100px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.03);
    border-radius: 50%;
    pointer-events: none;
}
.dash-hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: flex-end; justify-content: space-between;
    gap: 16px;
}
.dash-hero-greeting {
    font-size: 12.5px; font-weight: 500;
    color: rgba(255,255,255,0.6);
    margin-bottom: 4px;
}
.dash-hero-name {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 26px; font-weight: 700;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 6px;
}
.dash-hero-sub {
    font-size: 13.5px;
    color: rgba(255,255,255,0.6);
    max-width: 440px;
}
.dash-hero-cta {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 18px;
    padding: 9px 20px;
    background: #E8501A;
    color: #fff;
    border-radius: 999px;
    font-size: 13px; font-weight: 600;
    text-decoration: none;
    transition: background 0.15s, transform 0.15s;
    border: none; cursor: pointer;
}
.dash-hero-cta:hover { background: #F5773D; transform: translateY(-1px); color: #fff; }

/* ── Stat cards — float over hero ─────────────── */
.dash-stats-wrap {
    margin-top: -40px;
    position: relative; z-index: 10;
    margin-bottom: 2rem;
}
.dash-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}
.dash-stat-card {
    background: #fff;
    border-radius: 18px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 4px 20px rgba(15,32,87,0.12);
    display: flex; align-items: flex-start; gap: 14px;
    border: 1px solid #EEF0F6;
    transition: box-shadow 0.2s, transform 0.2s;
}
.dash-stat-card:hover {
    box-shadow: 0 8px 32px rgba(15,32,87,0.16);
    transform: translateY(-2px);
}
.dash-stat-icon {
    width: 44px; height: 44px; flex-shrink: 0;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
}
.dash-stat-icon.blue  { background: #EEF3FF; }
.dash-stat-icon.green { background: #E3F5F2; }
.dash-stat-icon.gold  { background: #FDF5E1; }
.dash-stat-num {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 30px; font-weight: 700;
    color: #0F2057; line-height: 1;
}
.dash-stat-label {
    font-size: 13px; font-weight: 600;
    color: #2D3348; margin: 3px 0 2px;
}
.dash-stat-desc { font-size: 12px; color: #9099B0; }

/* ── Section header ─────────────────────────── */
.dash-section-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1rem;
}
.dash-section-title {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 17px; font-weight: 700; color: #0F2057;
}
.dash-see-all {
    font-size: 13px; font-weight: 600;
    color: #E8501A; text-decoration: none;
    display: flex; align-items: center; gap: 4px;
    transition: gap 0.15s;
}
.dash-see-all:hover { gap: 7px; color: #E8501A; }

/* ── Category pills ─────────────────────────── */
.cat-pills {
    display: flex; gap: 8px; flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.cat-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 16px;
    background: #fff;
    border: 1.5px solid #D8DCE8;
    border-radius: 999px;
    font-size: 13px; font-weight: 600;
    color: #5A6278; text-decoration: none;
    transition: all 0.15s;
    white-space: nowrap;
}
.cat-pill:hover,
.cat-pill.active {
    border-color: #0F2057;
    color: #0F2057;
    background: #EEF3FF;
}

/* ── Events grid ─────────────────────────────── */
.events-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}
.events-grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

/* ── Event card ──────────────────────────────── */
.ecard {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #EEF0F6;
    overflow: hidden;
    display: flex; flex-direction: column;
    box-shadow: 0 1px 3px rgba(15,32,87,0.06);
    transition: box-shadow 0.2s, transform 0.2s;
}
.ecard:hover {
    box-shadow: 0 8px 32px rgba(15,32,87,0.12);
    transform: translateY(-3px);
}
.ecard-img {
    height: 140px;
    position: relative; overflow: hidden;
    display: flex; align-items: flex-end; padding: 10px 12px;
    flex-shrink: 0;
}
.ecard-cats { display: flex; gap: 4px; flex-wrap: wrap; position: relative; z-index: 1; }
.ecard-cat {
    font-size: 10px; font-weight: 700;
    padding: 2px 9px;
    border-radius: 999px;
    background: rgba(255,255,255,0.2);
    color: #fff;
    backdrop-filter: blur(4px);
    text-transform: uppercase; letter-spacing: 0.5px;
}
.ecard-quota-badge {
    position: absolute; top: 10px; right: 10px;
    font-size: 10px; font-weight: 700;
    padding: 3px 9px; border-radius: 999px; color: #fff;
}
.ecard-quota-badge.full { background: #EF4444; }
.ecard-quota-badge.low  { background: #F59E0B; }
.ecard-body { padding: 14px 16px 16px; flex: 1; display: flex; flex-direction: column; }
.ecard-org {
    font-size: 11px; font-weight: 600;
    color: #E8501A; text-transform: uppercase;
    letter-spacing: 0.5px; margin-bottom: 4px;
}
.ecard-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14.5px; font-weight: 700;
    color: #0F2057; line-height: 1.35;
    margin-bottom: 10px; flex: 1;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.ecard-meta { display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px; }
.ecard-meta-row {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; color: #5A6278;
}
.ecard-meta-row svg { flex-shrink: 0; }
.ecard-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #EEF0F6;
}
.ecard-slots {
    font-size: 12px; font-weight: 600;
    color: #0E7B6C;
    display: flex; align-items: center; gap: 4px;
}
.ecard-slots.full { color: #EF4444; }
.ecard-btn {
    padding: 5px 16px;
    background: #EEF3FF;
    color: #0F2057;
    border-radius: 999px;
    font-size: 12px; font-weight: 700;
    text-decoration: none;
    transition: all 0.15s; border: none;
}
.ecard-btn:hover { background: #0F2057; color: #fff; }

/* ── List item (latest events) ──────────────── */
.elist-item {
    display: flex; gap: 14px; align-items: flex-start;
    padding: 14px 16px;
    background: #fff;
    border: 1px solid #EEF0F6;
    border-radius: 14px;
    transition: box-shadow 0.15s;
    text-decoration: none;
}
.elist-item:hover { box-shadow: 0 4px 16px rgba(15,32,87,0.09); }
.elist-thumb {
    width: 60px; height: 60px; flex-shrink: 0;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
}
.elist-body { flex: 1; min-width: 0; }
.elist-org {
    font-size: 11px; font-weight: 600; color: #E8501A;
    text-transform: uppercase; letter-spacing: 0.4px;
    margin-bottom: 2px;
}
.elist-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px; font-weight: 700; color: #0F2057;
    line-height: 1.3; margin-bottom: 6px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.elist-meta { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.elist-meta-item { display: flex; align-items: center; gap: 4px; font-size: 12px; color: #5A6278; }
.elist-badge {
    font-size: 10px; font-weight: 700; padding: 2px 8px;
    border-radius: 999px; text-transform: uppercase; letter-spacing: 0.4px;
}
.elist-badge.open { background: #E3F5F2; color: #0E7B6C; }
.elist-badge.full { background: #FEE2E2; color: #991B1B; }

/* ── Empty state ─────────────────────────────── */
.dash-empty {
    text-align: center; padding: 3rem 1.5rem;
    background: #F8F9FC;
    border: 1.5px dashed #D8DCE8;
    border-radius: 18px;
}
.dash-empty-icon {
    width: 52px; height: 52px;
    background: #EEF3FF; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
}
.dash-empty h3 { font-size: 15px; font-weight: 700; color: #0F2057; margin-bottom: 6px; }
.dash-empty p  { font-size: 13.5px; color: #5A6278; margin-bottom: 18px; }

/* ── Buttons ─────────────────────────────────── */
.btn-primary {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px;
    background: #0F2057; color: #fff;
    border-radius: 999px; font-size: 13px; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    transition: background 0.15s;
}
.btn-primary:hover { background: #1A3575; color: #fff; }
.btn-accent {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px;
    background: #E8501A; color: #fff;
    border-radius: 999px; font-size: 13px; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    transition: background 0.15s;
}
.btn-accent:hover { background: #F5773D; color: #fff; }

@media (max-width: 900px) {
    .events-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .dash-stats { grid-template-columns: 1fr 1fr; }
    .dash-stats .dash-stat-card:last-child { grid-column: span 2; }
    .events-grid, .events-grid-2 { grid-template-columns: 1fr; }
    .dash-hero-name { font-size: 22px; }
}
</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────── --}}
<div class="dash-hero">
    <div class="ak-container">
        <div class="dash-hero-inner">
            <div>
                <p class="dash-hero-greeting">Selamat datang kembali,</p>
                <h1 class="dash-hero-name">{{ session('user_name', 'Relawan') }}</h1>
                <p class="dash-hero-sub">Temukan kegiatan yang bermakna dan berkontribusi untuk Indonesia.</p>
                <a href="{{ route('volunteer.events') }}" class="dash-hero-cta">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari Kegiatan
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ──────────────────────────── --}}
<div class="ak-container">
    <div class="dash-stats-wrap">
        <div class="dash-stats">

            <div class="dash-stat-card">
                <div class="dash-stat-icon blue">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1A3575" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="dash-stat-num">{{ $activeCount ?? 0 }}</div>
                    <div class="dash-stat-label">Kegiatan Aktif</div>
                    <div class="dash-stat-desc">Dikonfirmasi / Pending</div>
                </div>
            </div>

            <div class="dash-stat-card">
                <div class="dash-stat-icon green">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#0E7B6C" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <div class="dash-stat-num">{{ $completedCount ?? 0 }}</div>
                    <div class="dash-stat-label">Selesai</div>
                    <div class="dash-stat-desc">Total kegiatan selesai</div>
                </div>
            </div>

            <div class="dash-stat-card">
                <div class="dash-stat-icon gold">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#D4900A" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                </div>
                <div>
                    <div class="dash-stat-num">{{ $nearbyEvents->count() }}</div>
                    <div class="dash-stat-label">Di Kotamu</div>
                    <div class="dash-stat-desc">Kegiatan terdekat</div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="ak-container" style="padding-bottom: 3rem;">

    {{-- ── KEGIATAN DI KOTAMU ──────────────────── --}}
    @if($nearbyEvents->count() > 0)
    <section style="margin-bottom: 2.5rem;">
        <div class="dash-section-head">
            <div class="dash-section-title">Kegiatan di Kotamu</div>
            <a href="{{ route('volunteer.events') }}" class="dash-see-all">
                Lihat semua
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="events-grid-2">
            @foreach($nearbyEvents->take(4) as $event)
                @include('components.event-card', ['event' => $event])
            @endforeach
        </div>
    </section>
    @endif

    {{-- ── FILTER KATEGORI ─────────────────────── --}}
    <div class="cat-pills">
        <a href="{{ route('volunteer.events') }}"
           class="cat-pill {{ !request('category') ? 'active' : '' }}">
            Semua
        </a>
        @foreach([
            ['slug'=>'lingkungan','label'=>'Lingkungan'],
            ['slug'=>'pendidikan','label'=>'Pendidikan'],
            ['slug'=>'kesehatan', 'label'=>'Kesehatan'],
            ['slug'=>'sosial',    'label'=>'Sosial'],
        ] as $cat)
            <a href="{{ route('volunteer.events', ['category' => $cat['slug']]) }}"
               class="cat-pill {{ request('category') === $cat['slug'] ? 'active' : '' }}">
                {{ $cat['label'] }}
            </a>
        @endforeach
    </div>

    {{-- ── KEGIATAN TERSEDIA ───────────────────── --}}
    <section>
        <div class="dash-section-head">
            <div class="dash-section-title">Kegiatan Tersedia</div>
            <a href="{{ route('volunteer.events') }}" class="dash-see-all">
                Jelajahi semua
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px;">
            @forelse($latestEvents as $event)
                @php
                    $catColors = [
                        'lingkungan' => '#0E7B6C',
                        'pendidikan' => '#1A3575',
                        'kesehatan'  => '#B02060',
                        'sosial'     => '#D4900A',
                    ];
                    $fc  = $event->categories->first();
                    $clr = $catColors[$fc?->slug ?? ''] ?? '#1A3575';
                @endphp
                <a href="{{ route('volunteer.events.show', $event->slug) }}" class="elist-item">
                    <div class="elist-thumb" style="background: {{ $clr }}22;">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="{{ $clr }}" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="elist-body">
                        <p class="elist-org">{{ $event->organization->organization_name }}</p>
                        <p class="elist-title">{{ $event->title }}</p>
                        <div class="elist-meta">
                            <span class="elist-meta-item">
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="#9099B0" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="3"/></svg>
                                {{ $event->city }}
                            </span>
                            <span class="elist-meta-item">
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="#9099B0" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $event->start_date->format('d M Y') }}
                            </span>
                            <span class="elist-badge {{ $event->isFull() ? 'full' : 'open' }}">
                                {{ $event->isFull() ? 'Penuh' : $event->remainingQuota().' kuota' }}
                            </span>
                        </div>
                    </div>
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#9099B0" stroke-width="2" style="flex-shrink:0; margin-top:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div class="dash-empty">
                    <div class="dash-empty-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#1A3575" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3>Belum ada kegiatan tersedia</h3>
                    <p>Cek kembali beberapa saat lagi untuk kegiatan baru.</p>
                </div>
            @endforelse
        </div>

        @if($latestEvents->count() > 0)
            <div style="text-align: center; margin-top: 1.5rem;">
                <a href="{{ route('volunteer.events') }}" class="btn-primary">
                    Lihat semua kegiatan
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        @endif
    </section>

</div>

@endsection
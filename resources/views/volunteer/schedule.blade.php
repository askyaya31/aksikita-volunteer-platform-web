@extends('layouts.volunteer')
@section('title', 'Jadwal Saya — AksiKita')

@push('styles')
<style>
:root {
    --navy:   #1E3A8A;
    --blue:   #3B82F6;
    --blue2:  #60A5FA;
    --blue3:  #93C5FD;
    --blue4:  #BFDBFE;
    --orange: #E8501A;
    --ink:    #0F1E4A;
    --muted:  #6B7A9F;
    --surface:#F4F7FF;
    --border: #E2E9F8;
    --white:  #ffffff;
}

.s-page { background: var(--surface); min-height: 100vh; }

.s-hero {
    background: linear-gradient(140deg, #0D1E5A 0%, var(--navy) 45%, #2554C7 100%);
    padding: 2.5rem 0 5rem;
    position: relative;
    overflow: hidden;
}
.s-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 60% 80% at 80% -10%, rgba(96,165,250,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 40% 60% at -10% 80%, rgba(59,130,246,0.12) 0%, transparent 60%);
    pointer-events: none;
}
.s-hero-inner {
    position: relative;
    display: flex; align-items: flex-end; justify-content: space-between; gap: 2rem;
    flex-wrap: wrap;
}
.s-hero-left {}
.s-hero-eyebrow {
    font-size: 11px; font-weight: 700; letter-spacing: 0.1em;
    color: var(--blue3); text-transform: uppercase;
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 10px;
}
.s-hero-eyebrow::before {
    content: '';
    display: inline-block; width: 18px; height: 2px;
    background: var(--orange); border-radius: 2px;
}
.s-hero-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 32px; font-weight: 800; color: #fff;
    line-height: 1.15; margin: 0 0 6px;
    letter-spacing: -0.5px;
}
.s-hero-sub { font-size: 13.5px; color: var(--blue3); font-weight: 400; }

.s-wrap {
    max-width: 840px;
    margin: -3rem auto 0;
    padding: 0 1.25rem 4rem;
    position: relative;
}

.s-cal-card {
    background: var(--white);
    border-radius: 20px;
    border: 1px solid var(--border);
    box-shadow: 0 4px 24px rgba(30,58,138,0.10);
    padding: 0.875rem 1rem;
    margin-bottom: 1.25rem;
}
.s-cal-nav {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem;
}
.s-cal-month {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 16px; font-weight: 700; color: var(--ink);
    letter-spacing: -0.2px;
}
.s-cal-btn {
    width: 34px; height: 34px; border-radius: 10px;
    background: var(--surface); border: 1px solid var(--border);
    color: var(--navy);
    display: flex; align-items: center; justify-content: center;
    text-decoration: none; font-size: 17px; font-weight: 600;
    transition: all 0.15s;
}
.s-cal-btn:hover { background: var(--blue4); border-color: var(--blue3); color: var(--navy); }

.s-cal-grid {
    display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px;
}
.s-cal-dow {
    text-align: center; font-size: 9px; font-weight: 700;
    color: var(--muted); text-transform: uppercase;
    letter-spacing: 0.05em; padding: 0 0 4px;
}
.s-cal-cell {
    height: 34px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    border-radius: 6px;
    font-size: 11px; font-weight: 500; color: var(--muted);
    position: relative; cursor: default; gap: 2px;
    transition: background 0.12s;
    user-select: none;
}
.s-cal-cell.has-event {
    cursor: pointer; color: var(--ink); font-weight: 700;
}
.s-cal-cell.has-event:hover { background: var(--surface); }
.s-cal-cell.is-today {
    background: var(--navy); color: #fff; font-weight: 700;
}
.s-cal-cell.is-today:hover { background: #162d6e; }

.s-cal-dot {
    width: 4px; height: 4px; border-radius: 50%;
    background: var(--orange); flex-shrink: 0;
}
.s-cal-cell.is-today .s-cal-dot { background: rgba(255,255,255,0.7); }

.s-cal-count {
    font-size: 8px; font-weight: 800;
    background: var(--orange); color: #fff;
    border-radius: 999px; padding: 0 3px; line-height: 12px;
    min-width: 12px; text-align: center;
    position: absolute; top: 2px; right: 3px;
}

.s-cal-popup {
    display: none;
    position: absolute; top: calc(100% + 8px);
    left: 50%; transform: translateX(-50%);
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 14px;
    box-shadow: 0 12px 32px rgba(30,58,138,0.15);
    padding: 12px 14px;
    min-width: 210px; max-width: 250px;
    z-index: 300; text-align: left; pointer-events: none;
}
.s-cal-cell.popup-left  .s-cal-popup { left: auto; right: 0; transform: none; }
.s-cal-cell.popup-right .s-cal-popup { left: 0; right: auto; transform: none; }
.s-cal-cell.has-event:hover .s-cal-popup { display: block; }

.s-popup-date {
    font-size: 10px; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px;
}
.s-popup-item {
    display: flex; align-items: flex-start; gap: 8px;
    padding: 7px 0; border-top: 1px solid var(--border);
}
.s-popup-item:first-of-type { border-top: none; padding-top: 0; }
.s-popup-line {
    width: 3px; border-radius: 3px; min-height: 36px; flex-shrink: 0;
    background: var(--blue); margin-top: 2px;
    align-self: stretch;
}
.s-popup-line.attended { background: #10B981; }
.s-popup-name { font-size: 12px; color: var(--ink); font-weight: 700; line-height: 1.35; }
.s-popup-time { font-size: 11px; color: var(--muted); margin-top: 2px; }
.s-tabs {
    display: flex; gap: 6px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px; padding: 5px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(30,58,138,0.06);
}
.s-tab {
    flex: 1; padding: 10px 12px;
    border: none; background: none; cursor: pointer;
    border-radius: 12px;
    font-size: 13px; font-weight: 600; color: var(--muted);
    transition: all 0.15s; font-family: 'Plus Jakarta Sans', sans-serif;
    display: flex; align-items: center; justify-content: center; gap: 7px;
}
.s-tab.active { background: var(--navy); color: #fff; }
.s-tab-badge {
    background: var(--orange); color: #fff;
    border-radius: 999px; font-size: 10px; font-weight: 800;
    padding: 1px 7px; line-height: 16px;
}
.s-tab.active .s-tab-badge { background: rgba(255,255,255,0.25); }
.s-timeline { position: relative; }

.s-timeline-track {
    position: absolute;
    left: 18px; top: 0; bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, var(--blue4) 0%, transparent 100%);
    border-radius: 2px;
    z-index: 0;
}

.s-day { margin-bottom: 2rem; position: relative; padding-left: 44px; }

.s-day-node {
    position: absolute;
    left: 9px; top: 3px;
    width: 20px; height: 20px;
    border-radius: 50%;
    background: var(--white);
    border: 2.5px solid var(--blue3);
    z-index: 1;
    display: flex; align-items: center; justify-content: center;
}
.s-day-node.today {
    background: var(--orange);
    border-color: var(--orange);
    box-shadow: 0 0 0 4px rgba(232,80,26,0.18);
}
.s-day-node.past {
    background: var(--surface);
    border-color: var(--border);
}
.s-day-node-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--blue3);
}
.s-day-node.today  .s-day-node-dot { background: #fff; }
.s-day-node.past   .s-day-node-dot { background: var(--border); }

.s-day-label {
    font-size: 11.5px; font-weight: 700;
    color: var(--navy); text-transform: uppercase;
    letter-spacing: 0.06em; margin-bottom: 10px;
    display: flex; align-items: center; gap: 8px;
}
.s-day-label.today { color: var(--orange); }
.s-day-label.past  { color: var(--muted); font-weight: 600; }
.s-day-label-today-pill {
    background: var(--orange); color: #fff;
    font-size: 9px; font-weight: 800;
    padding: 2px 8px; border-radius: 999px;
    text-transform: uppercase; letter-spacing: 0.06em;
}

.s-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 0;
    margin-bottom: 10px;
    display: flex; align-items: stretch;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(30,58,138,0.05);
    text-decoration: none;
    transition: box-shadow 0.18s, transform 0.18s, border-color 0.18s;
}
.s-card:hover {
    box-shadow: 0 8px 28px rgba(30,58,138,0.12);
    transform: translateY(-2px);
    border-color: var(--blue3);
}
.s-card.past { opacity: 0.65; }
.s-card.past:hover { opacity: 0.85; }

.s-card-stripe {
    width: 4px; flex-shrink: 0;
    background: linear-gradient(to bottom, var(--blue), var(--blue2));
}
.s-card.past .s-card-stripe { background: var(--border); }

.s-card-time {
    padding: 16px 16px 16px 14px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    min-width: 70px; text-align: center;
    border-right: 1px solid var(--border);
    background: var(--surface);
    flex-shrink: 0;
}
.s-card-time-start {
    font-size: 17px; font-weight: 800; color: var(--navy);
    line-height: 1; letter-spacing: -0.3px;
}
.s-card-time-sep {
    width: 16px; height: 1.5px; background: var(--blue3);
    border-radius: 2px; margin: 5px auto;
}
.s-card-time-end {
    font-size: 11px; font-weight: 500; color: var(--muted);
}

.s-card-body {
    padding: 14px 16px; flex: 1; min-width: 0;
    display: flex; flex-direction: column; justify-content: center; gap: 5px;
}
.s-card-cats { display: flex; gap: 5px; flex-wrap: wrap; }
.s-card-cat {
    font-size: 9.5px; font-weight: 700;
    padding: 2px 9px; border-radius: 999px;
    background: var(--blue4); color: var(--navy);
    text-transform: uppercase; letter-spacing: 0.05em;
    border: 1px solid var(--blue3);
}
.s-card-title {
    font-size: 14px; font-weight: 700; color: var(--ink);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    letter-spacing: -0.1px;
}
.s-card-meta {
    font-size: 11.5px; color: var(--muted);
    display: flex; align-items: center; gap: 4px; flex-wrap: wrap;
}
.s-card-meta-sep { color: var(--blue3); font-size: 10px; }

.s-card-right {
    padding: 14px 16px 14px 10px;
    display: flex; flex-direction: column;
    align-items: flex-end; justify-content: center;
    gap: 8px; flex-shrink: 0;
}
.s-badge {
    font-size: 10.5px; font-weight: 700;
    padding: 4px 12px; border-radius: 999px;
    white-space: nowrap;
}
.s-badge.confirmed { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
.s-badge.attended  { background: var(--blue4); color: var(--navy); border: 1px solid var(--blue3); }
.s-badge.done      { background: #F3F4F6; color: #6B7280; border: 1px solid #E5E7EB; }

.s-card-arrow {
    width: 28px; height: 28px;
    border-radius: 8px; background: var(--surface);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--blue); transition: background 0.15s;
}
.s-card:hover .s-card-arrow { background: var(--blue4); border-color: var(--blue3); }

.s-empty {
    text-align: center; padding: 3.5rem 1rem;
    display: flex; flex-direction: column;
    align-items: center; gap: 14px;
}
.s-empty-icon {
    width: 64px; height: 64px; border-radius: 18px;
    background: var(--white); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(30,58,138,0.08);
}
.s-empty p {
    font-size: 14px; color: var(--muted); font-weight: 500; margin: 0;
}
.s-empty-cta {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 11px 26px;
    background: var(--navy); color: #fff;
    border-radius: 12px; font-size: 13px; font-weight: 700;
    text-decoration: none; transition: background 0.15s, transform 0.15s;
}
.s-empty-cta:hover { background: #162d6e; transform: translateY(-1px); }
@media (max-width: 640px) {
    .s-hero { padding: 2rem 0 4rem; }
    .s-hero-inner { flex-direction: column; align-items: flex-start; }
    .s-hero-title { font-size: 24px; }
    .s-hero-stats { flex-wrap: wrap; }
    .s-stat { padding: 12px 16px; }
    .s-stat-val { font-size: 22px; }
    .s-card-time { min-width: 58px; padding: 12px 10px; }
    .s-card-time-start { font-size: 14px; }
    .s-card-title { font-size: 13px; }
}
</style>
@endpush

@section('content')

@php
    $totalUpcoming = $upcoming->flatten()->count();
@endphp

<div class="s-page">
    <div class="s-hero">
        <div class="ak-container">
            <div class="s-hero-inner">
                <div class="s-hero-left">
                    <h1 class="s-hero-title">Jadwal Saya</h1>
                    <p class="s-hero-sub">Pantau semua kegiatan yang kamu ikuti</p>
                </div>
            </div>
        </div>
    </div>

    <div class="s-wrap">
        <div class="s-cal-card">
            <div class="s-cal-nav">
                <a href="?month={{ $prevMonth->month }}&year={{ $prevMonth->year }}" class="s-cal-btn" title="Bulan sebelumnya">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <span class="s-cal-month">{{ $calendarMonth->translatedFormat('F Y') }}</span>
                <a href="?month={{ $nextMonth->month }}&year={{ $nextMonth->year }}" class="s-cal-btn" title="Bulan berikutnya">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @php
                $startOfMonth = $calendarMonth->copy()->startOfMonth();
                $endOfMonth   = $calendarMonth->copy()->endOfMonth();
                $startPad     = $startOfMonth->dayOfWeek;
                $todayStr     = now()->toDateString();
            @endphp

            <div class="s-cal-grid">
                @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $dayName)
                    <div class="s-cal-dow">{{ $dayName }}</div>
                @endforeach

                @for($i = 0; $i < $startPad; $i++)
                    <div class="s-cal-cell"></div>
                @endfor

                @for($d = 1; $d <= $endOfMonth->day; $d++)
                    @php
                        $dateStr   = $calendarMonth->format('Y-m-') . str_pad($d, 2, '0', STR_PAD_LEFT);
                        $dayEvents = $eventsByDate[$dateStr] ?? [];
                        $hasEvent  = count($dayEvents) > 0;
                        $isToday   = $dateStr === $todayStr;
                        $col       = ($startPad + $d - 1) % 7;
                        $popupDir  = $col >= 5 ? 'popup-left' : ($col <= 1 ? 'popup-right' : '');
                    @endphp

                    <div class="s-cal-cell {{ $isToday ? 'is-today' : '' }} {{ $hasEvent ? 'has-event ' . $popupDir : '' }}"
                         @if($hasEvent) onclick="scrollToDate('{{ $dateStr }}')" @endif>

                        {{ $d }}
                        @if($hasEvent)
                            <div class="s-cal-dot"></div>
                            @if(count($dayEvents) > 1)
                                <span class="s-cal-count">{{ count($dayEvents) }}</span>
                            @endif
                            <div class="s-cal-popup">
                                <div class="s-popup-date">
                                    {{ \Carbon\Carbon::parse($dateStr)->translatedFormat('l, d F') }}
                                </div>
                                @foreach($dayEvents as $ev)
                                    <div class="s-popup-item">
                                        <div class="s-popup-line {{ $ev['status'] === 'attended' ? 'attended' : '' }}"></div>
                                        <div>
                                            <div class="s-popup-name">{{ $ev['title'] }}</div>
                                            @if($ev['start_time'])
                                                <div class="s-popup-time">
                                                    {{ $ev['start_time'] }}{{ $ev['end_time'] ? ' – ' . $ev['end_time'] : '' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        <div class="s-tabs" role="tablist">
            <button class="s-tab active" id="tab-upcoming" onclick="switchTab('upcoming')" role="tab">
                Mendatang
                @if($upcoming->count())
                    <span class="s-tab-badge">{{ $upcoming->flatten()->count() }}</span>
                @endif
            </button>
            <button class="s-tab" id="tab-past" onclick="switchTab('past')" role="tab">
                Sudah Lewat
            </button>
        </div>

        <div id="panel-upcoming">
            @forelse($upcoming as $date => $regs)
                @php
                    $dt      = \Carbon\Carbon::parse($date);
                    $isToday = $dt->isToday();
                    $label   = $isToday
                        ? 'Hari ini, ' . $dt->translatedFormat('d F Y')
                        : $dt->translatedFormat('l, d F Y');
                @endphp

                <div class="s-day" id="date-{{ $date }}">
                    <div class="s-day-node {{ $isToday ? 'today' : '' }}">
                        <div class="s-day-node-dot"></div>
                    </div>
                    <div class="s-day-label {{ $isToday ? 'today' : '' }}">
                        {{ $label }}
                        @if($isToday)
                            <span class="s-day-label-today-pill">Hari ini</span>
                        @endif
                    </div>

                    @foreach($regs as $reg)
                        <a href="{{ route('volunteer.events.show', $reg->event->slug) }}" class="s-card">
                            <div class="s-card-stripe"></div>
                            <div class="s-card-time">
                                <div class="s-card-time-start">
                                    {{ $reg->event->start_time ? \Carbon\Carbon::parse($reg->event->start_time)->format('H:i') : '—' }}
                                </div>
                                @if($reg->event->end_time)
                                    <div class="s-card-time-sep"></div>
                                    <div class="s-card-time-end">
                                        {{ \Carbon\Carbon::parse($reg->event->end_time)->format('H:i') }}
                                    </div>
                                @endif
                            </div>
                            <div class="s-card-body">
                                <div class="s-card-cats">
                                    @foreach($reg->event->categories->take(2) as $cat)
                                        <span class="s-card-cat">{{ $cat->name }}</span>
                                    @endforeach
                                </div>
                                <div class="s-card-title">{{ $reg->event->title }}</div>
                                <div class="s-card-meta">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $reg->event->city }}
                                    <span class="s-card-meta-sep">·</span>
                                    {{ $reg->event->organization->organization_name }}
                                </div>
                            </div>
                            <div class="s-card-right">
                                <span class="s-badge confirmed">Diterima</span>
                                <div class="s-card-arrow">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

            @empty
                <div class="s-empty">
                    <div class="s-empty-icon">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#93C5FD" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p>Belum ada jadwal kegiatan mendatang.</p>
                    <a href="{{ route('volunteer.events') }}" class="s-empty-cta">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Cari Kegiatan
                    </a>
                </div>
            @endforelse
        </div>
        <div id="panel-past" style="display:none;">
            @forelse($past as $date => $regs)
                @php $dt = \Carbon\Carbon::parse($date); @endphp

                <div class="s-day" id="date-past-{{ $date }}">
                    <div class="s-day-node past">
                        <div class="s-day-node-dot"></div>
                    </div>
                    <div class="s-day-label past">
                        {{ $dt->translatedFormat('l, d F Y') }}
                    </div>

                    @foreach($regs as $reg)
                        <a href="{{ route('volunteer.events.show', $reg->event->slug) }}" class="s-card past">
                            <div class="s-card-stripe"></div>
                            <div class="s-card-time">
                                <div class="s-card-time-start">
                                    {{ $reg->event->start_time ? \Carbon\Carbon::parse($reg->event->start_time)->format('H:i') : '—' }}
                                </div>
                                @if($reg->event->end_time)
                                    <div class="s-card-time-sep"></div>
                                    <div class="s-card-time-end">
                                        {{ \Carbon\Carbon::parse($reg->event->end_time)->format('H:i') }}
                                    </div>
                                @endif
                            </div>
                            <div class="s-card-body">
                                <div class="s-card-cats">
                                    @foreach($reg->event->categories->take(2) as $cat)
                                        <span class="s-card-cat">{{ $cat->name }}</span>
                                    @endforeach
                                </div>
                                <div class="s-card-title">{{ $reg->event->title }}</div>
                                <div class="s-card-meta">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $reg->event->city }}
                                    <span class="s-card-meta-sep">·</span>
                                    {{ $reg->event->organization->organization_name }}
                                </div>
                            </div>
                            <div class="s-card-right">
                                <span class="s-badge {{ $reg->status === 'attended' ? 'attended' : 'done' }}">
                                    {{ $reg->status === 'attended' ? 'Hadir' : 'Selesai' }}
                                </span>
                                <div class="s-card-arrow">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

            @empty
                <div class="s-empty">
                    <div class="s-empty-icon">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#93C5FD" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p>Belum ada riwayat kegiatan yang selesai.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
function switchTab(tab) {
    document.getElementById('panel-upcoming').style.display = tab === 'upcoming' ? '' : 'none';
    document.getElementById('panel-past').style.display     = tab === 'past'     ? '' : 'none';
    document.getElementById('tab-upcoming').classList.toggle('active', tab === 'upcoming');
    document.getElementById('tab-past').classList.toggle('active', tab === 'past');
}

function scrollToDate(date) {
    var el = document.getElementById('date-' + date);
    if (el) { switchTab('upcoming'); highlightAndScroll(el); return; }
    var elPast = document.getElementById('date-past-' + date);
    if (elPast) { switchTab('past'); highlightAndScroll(elPast); }
}

function highlightAndScroll(el) {
    var top = el.getBoundingClientRect().top + window.scrollY - 90;
    window.scrollTo({ top: top, behavior: 'smooth' });
    el.style.transition = 'background 0.3s';
    el.style.background = 'rgba(59,130,246,0.07)';
    el.style.borderRadius = '12px';
    setTimeout(function() { el.style.background = ''; el.style.borderRadius = ''; }, 1400);
}
</script>
@endpush
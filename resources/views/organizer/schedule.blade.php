@extends('layouts.organizer')
@section('title', 'Jadwal — AksiKita')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap');

    :root {
        --color-navy: #0F2057;
        --color-blue-primary: #0066FF;
        --color-ink-muted: #6B7280;
        --color-border-soft: #EEF0F6;
        --color-bg: #F9FAFB;
    }

    body, h1, h2, h3, .font-sora,
    .sched-hero-title, .sched-hero-sub, .org-section-title, .org-section-sub {
        font-family: 'Sora', sans-serif !important;
    }
    .sched-card, .sched-card *, .cal-cell, .cal-day-header, .cal-month-label {
        font-family: 'Montserrat', sans-serif !important;
    }

    .sched-hero {
        background: #0F2057;
        padding: 3rem 0 4.5rem;
        position: relative;
        overflow: hidden;
    }
    .sched-hero::after {
        content: '';
        position: absolute;
        top: 20px; right: 40px;
        width: 280px; height: 220px;
        background-image: radial-gradient(rgba(255,255,255,0.12) 1.5px, transparent 1.5px);
        background-size: 14px 14px;
        border-radius: 50%;
        pointer-events: none;
    }
    .sched-hero-inner { position: relative; z-index: 1; }
    .sched-hero-title { font-size: 28px; font-weight: 700; color: #fff; margin: 0 0 4px 0; }
    .sched-hero-sub { font-size: 14px; color: rgba(255,255,255,0.7); margin: 0; }

    .sched-wrap {
        margin-top: -56px;
        position: relative;
        z-index: 10;
        margin-bottom: 4rem;
    }

    .sched-cal-wrap {
        background: #FFFFFF;
        border: 1.5px solid #EEF0F6;
        border-radius: 20px;
        padding: 0.875rem 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 24px rgba(15,32,87,0.08);
    }
    .sched-cal-nav {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 0.875rem;
    }
    .cal-month-label { font-size: 14px; font-weight: 700; color: var(--color-navy); }
    .cal-nav-btn {
        width: 30px; height: 30px; border-radius: 8px;
        background: #F0F4FA; color: var(--color-navy);
        display: flex; align-items: center; justify-content: center;
        text-decoration: none; transition: background 0.15s;
    }
    .cal-nav-btn:hover { background: #DCE4EC; }

    .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; }
    .cal-day-header {
        text-align: center; font-size: 9px; font-weight: 700;
        color: var(--color-ink-muted); padding: 0 0 4px;
        text-transform: uppercase; letter-spacing: 0.4px;
    }
    .cal-cell {
        height: 34px;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        border-radius: 6px; font-size: 11px; font-weight: 500;
        color: #9099B0; position: relative; gap: 2px; user-select: none;
        transition: background 0.15s;
    }
    .cal-cell.has-event { cursor: pointer; color: var(--color-navy); font-weight: 700; }
    .cal-cell.has-event:hover { background: #EEF3FF; }
    .cal-cell.is-today { background: var(--color-navy); color: #fff; font-weight: 700; }
    .cal-cell.is-today:hover { background: #1A3575; }
    .cal-ev-badge {
        font-size: 8px; font-weight: 700; background: var(--color-blue-primary);
        color: #fff; border-radius: 999px; padding: 0 3px; line-height: 12px;
        min-width: 12px; text-align: center;
        position: absolute; top: 2px; right: 3px;
    }
    .cal-cell.is-today .cal-ev-badge { background: rgba(255,255,255,0.3); }

    .sched-tabs {
        display: flex; gap: 6px;
        background: #fff; border: 1.5px solid #EEF0F6; border-radius: 16px;
        padding: 6px; margin-bottom: 1.5rem;
        box-shadow: 0 8px 24px rgba(15,32,87,0.06);
    }
    .sched-tab {
        flex: 1; padding: 10px; border: none; background: none; cursor: pointer;
        border-radius: 12px; font-size: 13px; font-weight: 600; color: #5A6278;
        transition: all 0.15s; font-family: 'Sora', sans-serif;
    }
    .sched-tab.active { background: var(--color-navy); color: #fff; }

    .sched-day { margin-bottom: 1.5rem; }
    .sched-day-header { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }
    .sched-day-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--color-blue-primary); flex-shrink: 0; }
    .sched-day-dot.today { background: var(--color-navy); box-shadow: 0 0 0 3px rgba(15,32,87,0.18); }
    .sched-day-dot.past { background: #C7CEDB; }
    .sched-day-label { font-size: 12px; font-weight: 700; color: var(--color-navy); text-transform: uppercase; letter-spacing: 0.5px; }
    .sched-day-label.past { color: var(--color-ink-muted); }
    .sched-day-line { flex: 1; height: 1px; background: var(--color-border-soft); }

    .sched-card {
        background: #FFFFFF; border: 1.5px solid #DCE4EC; border-radius: 18px;
        padding: 1.1rem 1.25rem; margin-bottom: 0.85rem;
        display: flex; gap: 16px; align-items: center;
        box-shadow: 0 8px 20px rgba(15,32,87,0.06);
        text-decoration: none; transition: box-shadow 0.15s, border-color 0.15s;
    }
    .sched-card:hover { box-shadow: 0 12px 28px rgba(15,32,87,0.10); border-color: #B0C4DE; }
    .sched-card.past { opacity: 0.7; }

    .sched-time-col {
        min-width: 76px; text-align: center; padding: 8px 10px;
        background: #F0F4FA; border-radius: 12px; flex-shrink: 0;
    }
    .sched-time-start { font-size: 15px; font-weight: 700; color: var(--color-navy); }
    .sched-time-end { font-size: 11px; color: var(--color-ink-muted); margin-top: 1px; }

    .sched-info { flex: 1; min-width: 0; }
    .sched-title {
        font-size: 15px; font-weight: 700; color: #1F2937;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 4px;
    }
    .sched-meta { font-size: 12.5px; color: var(--color-ink-muted); display: flex; gap: 10px; flex-wrap: wrap; }

    .sched-badge {
        font-size: 10.5px; font-weight: 700; padding: 4px 12px; border-radius: 999px;
        flex-shrink: 0; text-transform: uppercase; white-space: nowrap;
    }
    .sched-badge.published { background: #ECFDF5; color: #059669; }
    .sched-badge.completed { background: #F0F4FA; color: var(--color-navy); }

    .sched-empty {
        text-align: center; padding: 4rem 1rem;
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px;
        background: #FFFFFF; border: 1.5px solid #EEF0F6; border-radius: 24px;
    }
    .sched-empty p { color: #1F2937; font-size: 14.5px; font-weight: 500; margin: 0; }
    .sched-empty svg { stroke: var(--color-ink-muted); }
    .sched-empty a {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 24px; background: var(--color-navy); color: #fff;
        border-radius: 999px; font-size: 13px; font-weight: 600;
        text-decoration: none; transition: transform 0.2s ease;
    }
    .sched-empty a:hover { transform: translateY(-1px); }
</style>
@endpush

@section('content')

@php
    $totalUpcoming = $upcoming->flatten()->count();
@endphp

<section class="sched-hero">
    <div class="ak-container sched-hero-inner">
        <h1 class="sched-hero-title">Jadwal Event</h1>
        <p class="sched-hero-sub">{{ $totalUpcoming }} event mendatang yang sudah terjadwal</p>
    </div>
</section>

<div class="ak-container">
    <div class="sched-wrap" style="max-width: 800px; margin-left: auto; margin-right: auto;">
        <div class="sched-cal-wrap">
            <div class="sched-cal-nav">
                <a href="?month={{ $prevMonth->month }}&year={{ $prevMonth->year }}" class="cal-nav-btn" title="Bulan sebelumnya">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <span class="cal-month-label">{{ $calendarMonth->translatedFormat('F Y') }}</span>
                <a href="?month={{ $nextMonth->month }}&year={{ $nextMonth->year }}" class="cal-nav-btn" title="Bulan berikutnya">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @php
                $startOfMonth = $calendarMonth->copy()->startOfMonth();
                $endOfMonth   = $calendarMonth->copy()->endOfMonth();
                $startPad     = $startOfMonth->dayOfWeek;
                $todayStr     = now()->toDateString();
            @endphp

            <div class="cal-grid">
                @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $dayName)
                    <div class="cal-day-header">{{ $dayName }}</div>
                @endforeach

                @for($i = 0; $i < $startPad; $i++)
                    <div class="cal-cell"></div>
                @endfor

                @for($d = 1; $d <= $endOfMonth->day; $d++)
                    @php
                        $dateStr   = $calendarMonth->format('Y-m-') . str_pad($d, 2, '0', STR_PAD_LEFT);
                        $dayEvents = $eventsByDate[$dateStr] ?? [];
                        $hasEvent  = count($dayEvents) > 0;
                        $isToday   = $dateStr === $todayStr;
                    @endphp

                    <div class="cal-cell {{ $isToday ? 'is-today' : '' }} {{ $hasEvent ? 'has-event' : '' }}"
                         @if($hasEvent) onclick="scrollToDate('{{ $dateStr }}')" title="{{ $hasEvent ? collect($dayEvents)->pluck('title')->join(', ') : '' }}" @endif>
                        {{ $d }}
                        @if($hasEvent)
                            <span class="cal-ev-badge">{{ count($dayEvents) }}</span>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
        <div class="sched-tabs" role="tablist">
            <button class="sched-tab active" id="tab-upcoming" onclick="switchTab('upcoming')" role="tab">
                Mendatang
                @if($totalUpcoming)
                    <span style="background:var(--color-blue-primary);color:#fff;border-radius:999px;padding:1px 7px;font-size:10px;margin-left:4px;">{{ $totalUpcoming }}</span>
                @endif
            </button>
            <button class="sched-tab" id="tab-past" onclick="switchTab('past')" role="tab">
                Selesai
            </button>
        </div>
        <div id="panel-upcoming">
            @forelse($upcoming as $date => $dayEvents)
                @php
                    $dt      = \Carbon\Carbon::parse($date);
                    $isToday = $dt->isToday();
                    $label   = $isToday ? 'Hari ini, ' . $dt->translatedFormat('d F Y') : $dt->translatedFormat('l, d F Y');
                @endphp

                <div class="sched-day" id="date-{{ $date }}">
                    <div class="sched-day-header">
                        <div class="sched-day-dot {{ $isToday ? 'today' : '' }}"></div>
                        <span class="sched-day-label">{{ $label }}</span>
                        <div class="sched-day-line"></div>
                    </div>

                    @foreach($dayEvents as $event)
                        <a href="{{ route('organizer.events.show', $event->id) }}" class="sched-card">
                            <div class="sched-time-col">
                                <div class="sched-time-start">{{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '—' }}</div>
                                <div class="sched-time-end">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '' }}</div>
                            </div>
                            <div class="sched-info">
                                <div class="sched-title">{{ $event->title }}</div>
                                <div class="sched-meta">
                                    <span>{{ $event->city }}</span>
                                    <span>{{ $event->registrations_count }} pendaftar</span>
                                </div>
                            </div>
                            <span class="sched-badge {{ $event->status }}">
                                {{ $event->status === 'published' ? 'Aktif' : 'Selesai' }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @empty
                <div class="sched-empty">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p>Belum ada event mendatang yang terjadwal.</p>
                    <a href="{{ route('organizer.events.create') }}">Buat Event</a>
                </div>
            @endforelse
        </div>

        <div id="panel-past" style="display:none;">
            @forelse($past as $date => $dayEvents)
                @php $dt = \Carbon\Carbon::parse($date); @endphp

                <div class="sched-day" id="date-past-{{ $date }}">
                    <div class="sched-day-header">
                        <div class="sched-day-dot past"></div>
                        <span class="sched-day-label past">{{ $dt->translatedFormat('l, d F Y') }}</span>
                        <div class="sched-day-line"></div>
                    </div>

                    @foreach($dayEvents as $event)
                        <a href="{{ route('organizer.events.show', $event->id) }}" class="sched-card past">
                            <div class="sched-time-col">
                                <div class="sched-time-start">{{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '—' }}</div>
                                <div class="sched-time-end">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '' }}</div>
                            </div>
                            <div class="sched-info">
                                <div class="sched-title">{{ $event->title }}</div>
                                <div class="sched-meta">
                                    <span>{{ $event->city }}</span>
                                    <span>{{ $event->registrations_count }} pendaftar</span>
                                </div>
                            </div>
                            <span class="sched-badge completed">Selesai</span>
                        </a>
                    @endforeach
                </div>
            @empty
                <div class="sched-empty">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>Belum ada riwayat event yang selesai.</p>
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
    el.style.background = '#EEF3FF';
    el.style.borderRadius = '16px';
    el.style.padding = '8px';
    el.style.transition = 'background 0.3s';
    setTimeout(function() { el.style.background = ''; el.style.padding = ''; }, 1400);
}
</script>
@endpush
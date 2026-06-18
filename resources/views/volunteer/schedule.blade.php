@extends('layouts.volunteer')
@section('title', 'Jadwal Saya — AksiKita')

@push('styles')
<style>
.sched-hero {
    background: linear-gradient(135deg, #0F2057 0%, #1A3575 60%, #2A4A9C 100%);
    padding: 2rem 0 3.5rem;
}
.sched-hero-title {
    font-family: 'Fraunces', serif;
    font-size: 24px; font-weight: 700; color: #fff;
    margin-bottom: 4px;
}
.sched-hero-sub { font-size: 13.5px; color: rgba(255,255,255,0.6); }

.sched-wrap {
    max-width: 800px;
    margin: -2rem auto 3rem;
    padding: 0 1.25rem;
}

.sched-cal-wrap {
    background: #fff;
    border: 1px solid #EEF0F6;
    border-radius: 18px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(15,32,87,0.06);
}
.sched-cal-nav {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1rem;
}
.cal-month-label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px; font-weight: 700; color: #0F2057;
}
.cal-nav-btn {
    width: 32px; height: 32px; border-radius: 8px;
    background: #F0F3FA; color: #0F2057;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; line-height: 1; text-decoration: none;
    transition: background 0.15s;
}
.cal-nav-btn:hover { background: #D8E0F5; }

.cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 3px;
}
.cal-day-header {
    text-align: center; font-size: 11px; font-weight: 700;
    color: #9099B0; padding: 4px 0;
    text-transform: uppercase; letter-spacing: 0.4px;
}
.cal-cell {
    aspect-ratio: 1;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    border-radius: 8px; font-size: 12px;
    font-weight: 500; color: #9099B0;
    cursor: default; position: relative;
    transition: background 0.15s;
    gap: 2px;
    user-select: none;
}
.cal-cell.has-event {
    cursor: pointer;
    color: #0F2057; font-weight: 700;
}
.cal-cell.has-event:hover { background: #EEF3FF; }
.cal-cell.is-today {
    background: #0F2057; color: #fff; font-weight: 700;
}
.cal-cell.is-today:hover { background: #1A3575; }
.cal-cell.is-today .cal-ev-badge { background: rgba(255,255,255,0.25); color: #fff; }

.cal-ev-badge {
    font-size: 9px; font-weight: 700;
    background: #E8501A; color: #fff;
    border-radius: 999px;
    padding: 0 4px; line-height: 14px;
    min-width: 14px; text-align: center;
}

.cal-popup {
    display: none;
    position: absolute;
    top: calc(100% + 6px);
    left: 50%; transform: translateX(-50%);
    background: #fff;
    border: 1px solid #D8DCE8;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(15,32,87,0.12);
    padding: 10px 12px;
    min-width: 210px; max-width: 250px;
    z-index: 200;
    text-align: left;
    pointer-events: none;
}
.cal-cell.popup-left .cal-popup  { left: auto; right: 0; transform: none; }
.cal-cell.popup-right .cal-popup { left: 0; right: auto; transform: none; }
.cal-cell.has-event:hover .cal-popup { display: block; }

.cal-popup-date {
    font-size: 10px; font-weight: 700; color: #9099B0;
    text-transform: uppercase; letter-spacing: 0.5px;
    margin-bottom: 8px;
}
.cal-popup-item {
    display: flex; align-items: flex-start; gap: 8px;
    padding: 6px 0;
    border-top: 1px solid #EEF0F6;
}
.cal-popup-item:first-of-type { border-top: none; padding-top: 0; }
.cal-popup-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #E8501A; flex-shrink: 0; margin-top: 4px;
}
.cal-popup-dot.attended { background: #059669; }
.cal-popup-name {
    font-size: 12px; color: #0F2057;
    line-height: 1.4; font-weight: 600;
}
.cal-popup-time { font-size: 11px; color: #9099B0; margin-top: 1px; }

.sched-tabs {
    display: flex; gap: 6px;
    background: #fff;
    border: 1px solid #EEF0F6;
    border-radius: 14px;
    padding: 5px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(15,32,87,0.06);
}
.sched-tab {
    flex: 1; padding: 9px;
    border: none; background: none; cursor: pointer;
    border-radius: 10px;
    font-size: 13px; font-weight: 600;
    color: #5A6278;
    transition: all 0.15s;
}
.sched-tab.active { background: #0F2057; color: #fff; }

.sched-day { margin-bottom: 1.5rem; border-radius: 14px; padding: 2px; transition: background 0.3s; }
.sched-day.highlighted { background: #EEF3FF; padding: 10px 12px; }
.sched-day-header {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 10px;
}
.sched-day-dot {
    width: 10px; height: 10px;
    border-radius: 50%; background: #0F2057; flex-shrink: 0;
}
.sched-day-dot.today { background: #E8501A; box-shadow: 0 0 0 3px rgba(232,80,26,0.15); }
.sched-day-dot.past  { background: #9099B0; }
.sched-day-label {
    font-size: 12px; font-weight: 700;
    color: #0F2057; text-transform: uppercase; letter-spacing: 0.5px;
}
.sched-day-label.today { color: #E8501A; }
.sched-day-label.past  { color: #9099B0; }
.sched-day-line { flex: 1; height: 1px; background: #EEF0F6; }

.sched-card {
    background: #fff;
    border: 1px solid #EEF0F6;
    border-radius: 14px;
    padding: 14px 16px;
    margin-bottom: 8px;
    display: flex; gap: 14px; align-items: flex-start;
    box-shadow: 0 1px 4px rgba(15,32,87,0.05);
    text-decoration: none;
    transition: box-shadow 0.15s, border-color 0.15s;
}
.sched-card:hover { box-shadow: 0 4px 16px rgba(15,32,87,0.10); border-color: #C7D0EB; }
.sched-card.past { opacity: 0.65; }

.sched-time-col {
    min-width: 72px; text-align: center;
    padding: 6px 10px;
    background: #EEF3FF;
    border-radius: 10px; flex-shrink: 0;
}
.sched-time-start { font-size: 15px; font-weight: 700; color: #0F2057; }
.sched-time-end   { font-size: 11px; color: #9099B0; margin-top: 1px; }

.sched-info { flex: 1; min-width: 0; }
.sched-cats { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 5px; }
.sched-cat {
    font-size: 10px; font-weight: 700;
    padding: 2px 8px; border-radius: 999px;
    background: #EEF3FF; color: #1A3575;
    text-transform: uppercase; letter-spacing: 0.4px;
}
.sched-title {
    font-size: 14px; font-weight: 700; color: #0F2057;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 4px;
}
.sched-meta { font-size: 12px; color: #9099B0; display: flex; gap: 10px; flex-wrap: wrap; }

.sched-badge {
    font-size: 10.5px; font-weight: 700;
    padding: 3px 10px; border-radius: 999px;
    flex-shrink: 0; align-self: flex-start;
}
.sched-badge.confirmed { background: #ECFDF5; color: #059669; }
.sched-badge.attended  { background: #EEF3FF; color: #1A3575; }

.sched-empty {
    text-align: center; padding: 3rem 1rem; color: #9099B0;
}
.sched-empty svg { margin-bottom: 12px; opacity: 0.35; }
.sched-empty p { font-size: 14px; }
.sched-empty a {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 14px; padding: 9px 20px;
    background: #0F2057; color: #fff;
    border-radius: 999px; font-size: 13px; font-weight: 600;
    text-decoration: none;
}
</style>
@endpush

@section('content')

<div class="sched-hero">
    <div class="ak-container">
        <p class="sched-hero-sub">Halo, {{ session('user_name') }}</p>
        <h1 class="sched-hero-title">Jadwal Saya</h1>
        <p class="sched-hero-sub" style="margin-top:4px;">
            {{ $upcoming->flatten()->count() }} kegiatan mendatang
        </p>
    </div>
</div>

<div class="sched-wrap">

    <div class="sched-cal-wrap">

        <div class="sched-cal-nav">
            <a href="?month={{ $prevMonth->month }}&year={{ $prevMonth->year }}"
               class="cal-nav-btn" title="Bulan sebelumnya">‹</a>
            <span class="cal-month-label">{{ $calendarMonth->translatedFormat('F Y') }}</span>
            <a href="?month={{ $nextMonth->month }}&year={{ $nextMonth->year }}"
               class="cal-nav-btn" title="Bulan berikutnya">›</a>
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
                    $col       = ($startPad + $d - 1) % 7;
                    $popupDir  = $col >= 5 ? 'popup-left' : ($col <= 1 ? 'popup-right' : '');
                @endphp

                <div class="cal-cell {{ $isToday ? 'is-today' : '' }} {{ $hasEvent ? 'has-event ' . $popupDir : '' }}"
                     @if($hasEvent) onclick="scrollToDate('{{ $dateStr }}')" @endif>

                    {{ $d }}

                    @if($hasEvent)
                        <span class="cal-ev-badge">{{ count($dayEvents) }}</span>
                        <div class="cal-popup">
                            <div class="cal-popup-date">
                                {{ \Carbon\Carbon::parse($dateStr)->translatedFormat('l, d F Y') }}
                            </div>
                            @foreach($dayEvents as $ev)
                                <div class="cal-popup-item">
                                    <div class="cal-popup-dot {{ $ev['status'] === 'attended' ? 'attended' : '' }}"></div>
                                    <div>
                                        <div class="cal-popup-name">{{ $ev['title'] }}</div>
                                        @if($ev['start_time'])
                                            <div class="cal-popup-time">
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

    <div class="sched-tabs" role="tablist">
        <button class="sched-tab active" id="tab-upcoming" onclick="switchTab('upcoming')" role="tab">
            Mendatang
            @if($upcoming->count())
                <span style="background:#E8501A;color:#fff;border-radius:999px;padding:1px 7px;font-size:10px;margin-left:4px;">
                    {{ $upcoming->flatten()->count() }}
                </span>
            @endif
        </button>
        <button class="sched-tab" id="tab-past" onclick="switchTab('past')" role="tab">
            Sudah Lewat
        </button>
    </div>

    <div id="panel-upcoming">
        @forelse($upcoming as $date => $regs)
            @php
                $dt      = \Carbon\Carbon::parse($date);
                $isToday = $dt->isToday();
                $label   = $isToday
                    ? 'Hari ini — ' . $dt->translatedFormat('d F Y')
                    : $dt->translatedFormat('l, d F Y');
            @endphp

            <div class="sched-day" id="date-{{ $date }}">
                <div class="sched-day-header">
                    <div class="sched-day-dot {{ $isToday ? 'today' : '' }}"></div>
                    <span class="sched-day-label {{ $isToday ? 'today' : '' }}">{{ $label }}</span>
                    <div class="sched-day-line"></div>
                </div>

                @foreach($regs as $reg)
                    <a href="{{ route('volunteer.events.show', $reg->event->slug) }}" class="sched-card">
                        <div class="sched-time-col">
                            <div class="sched-time-start">
                                {{ $reg->event->start_time ? \Carbon\Carbon::parse($reg->event->start_time)->format('H:i') : '—' }}
                            </div>
                            <div class="sched-time-end">
                                {{ $reg->event->end_time ? \Carbon\Carbon::parse($reg->event->end_time)->format('H:i') : '' }}
                            </div>
                        </div>
                        <div class="sched-info">
                            <div class="sched-cats">
                                @foreach($reg->event->categories->take(2) as $cat)
                                    <span class="sched-cat">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                            <div class="sched-title">{{ $reg->event->title }}</div>
                            <div class="sched-meta">
                                <span>{{ $reg->event->city }}</span>
                                <span>{{ $reg->event->organization->organization_name }}</span>
                            </div>
                        </div>
                        <span class="sched-badge {{ $reg->status }}">
                            {{ $reg->status === 'confirmed' ? 'Diterima' : 'Hadir' }}
                        </span>
                    </a>
                @endforeach
            </div>

        @empty
            <div class="sched-empty">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#9099B0" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p>Belum ada jadwal kegiatan mendatang.</p>
                <a href="{{ route('volunteer.events') }}">Cari Kegiatan →</a>
            </div>
        @endforelse
    </div>

    <div id="panel-past" style="display:none;">
        @forelse($past as $date => $regs)
            @php $dt = \Carbon\Carbon::parse($date); @endphp

            <div class="sched-day" id="date-past-{{ $date }}">
                <div class="sched-day-header">
                    <div class="sched-day-dot past"></div>
                    <span class="sched-day-label past">{{ $dt->translatedFormat('l, d F Y') }}</span>
                    <div class="sched-day-line"></div>
                </div>

                @foreach($regs as $reg)
                    <a href="{{ route('volunteer.events.show', $reg->event->slug) }}" class="sched-card past">
                        <div class="sched-time-col">
                            <div class="sched-time-start">
                                {{ $reg->event->start_time ? \Carbon\Carbon::parse($reg->event->start_time)->format('H:i') : '—' }}
                            </div>
                            <div class="sched-time-end">
                                {{ $reg->event->end_time ? \Carbon\Carbon::parse($reg->event->end_time)->format('H:i') : '' }}
                            </div>
                        </div>
                        <div class="sched-info">
                            <div class="sched-cats">
                                @foreach($reg->event->categories->take(2) as $cat)
                                    <span class="sched-cat">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                            <div class="sched-title">{{ $reg->event->title }}</div>
                            <div class="sched-meta">
                                <span> {{ $reg->event->city }}</span>
                                <span> {{ $reg->event->organization->organization_name }}</span>
                            </div>
                        </div>
                        <span class="sched-badge {{ $reg->status }}">
                            {{ $reg->status === 'attended' ? 'Hadir' : 'Selesai' }}
                        </span>
                    </a>
                @endforeach
            </div>

        @empty
            <div class="sched-empty">
                <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#9099B0" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>Belum ada riwayat kegiatan yang selesai.</p>
            </div>
        @endforelse
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
    if (el) {
        switchTab('upcoming');
        highlightAndScroll(el);
        return;
    }
    var elPast = document.getElementById('date-past-' + date);
    if (elPast) {
        switchTab('past');
        highlightAndScroll(elPast);
    }
}

function highlightAndScroll(el) {
    var top = el.getBoundingClientRect().top + window.scrollY - 90;
    window.scrollTo({ top: top, behavior: 'smooth' });
    el.classList.add('highlighted');
    setTimeout(function() { el.classList.remove('highlighted'); }, 1400);
}
</script>
@endpush
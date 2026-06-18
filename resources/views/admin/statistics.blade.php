@extends('layouts.admin')

@section('title', 'Statistik - AksiKita Admin')

@push('styles')
<style>
.stats-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.stats-head__title {
    font-size: 1.125rem;
    font-weight: 800;
    letter-spacing: -0.025em;
    color: var(--color-ink);
    margin: 0 0 2px;
    font-family: var(--font-display);
}
.stats-head__sub {
    font-size: 0.8rem;
    color: var(--color-ink-muted);
    margin: 0;
}
.stats-head__ts {
    font-size: 0.72rem;
    color: var(--color-ink-muted);
    font-variant-numeric: tabular-nums;
    white-space: nowrap;
    padding: 4px 11px;
    border: 1px solid var(--color-border);
    border-radius: var(--radius-full);
}

.rcallout {
    display: flex;
    align-items: center;
    gap: 14px;
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-left: 3px solid var(--color-danger);
    border-radius: var(--radius-md);
    padding: 13px 18px;
    margin-bottom: 20px;
}
.rcallout__num {
    font-size: 1.75rem;
    font-weight: 800;
    letter-spacing: -0.04em;
    color: var(--color-danger);
    font-variant-numeric: tabular-nums;
    font-family: var(--font-display);
    line-height: 1;
    flex-shrink: 0;
}
.rcallout__text { flex: 1; }
.rcallout__text strong {
    display: block;
    font-size: 0.825rem;
    font-weight: 700;
    color: var(--color-ink);
    margin-bottom: 1px;
}
.rcallout__text span {
    font-size: 0.75rem;
    color: var(--color-ink-muted);
}
.rcallout__action {
    flex-shrink: 0;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--color-danger);
    text-decoration: none;
    border: 1.5px solid var(--color-danger);
    border-radius: var(--radius-full);
    padding: 4px 12px;
    transition: background 0.15s, color 0.15s;
}
.rcallout__action:hover { background: var(--color-danger); color: #fff; }

.stats-body {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 16px;
    align-items: start;
}

.stats-main { display: flex; flex-direction: column; gap: 16px; }

.stats-side { display: flex; flex-direction: column; gap: 16px; }

.sp {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.sp__head {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    padding: 14px 18px 12px;
    border-bottom: 1px solid var(--color-border-soft);
}
.sp__name {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: var(--color-ink-muted);
}
.sp__total {
    font-size: 1.375rem;
    font-weight: 800;
    letter-spacing: -0.04em;
    color: var(--color-ink);
    line-height: 1;
    font-variant-numeric: tabular-nums;
    font-family: var(--font-display);
}
.sp__link {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--color-navy);
    text-decoration: none;
    border-bottom: 1px solid transparent;
    transition: border-color 0.15s;
}
.sp__link:hover { border-color: var(--color-navy); color: var(--color-navy); }

.sp__chart {
    padding: 16px 18px 18px;
}
.chart-canvas-wrap {
    position: relative;
}
.chart-canvas-wrap--tall  { height: 200px; }
.chart-canvas-wrap--short { height: 140px; }

.chart-legend {
    display: flex;
    gap: 14px;
    margin-bottom: 14px;
}
.chart-legend__item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.7rem;
    color: var(--color-ink-muted);
}
.chart-legend__line {
    width: 12px;
    height: 2px;
    border-radius: 1px;
}

.brow {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 18px;
    border-bottom: 1px solid var(--color-border-soft);
    font-size: 0.8rem;
}
.brow:last-child { border-bottom: none; }

.brow__label {
    min-width: 110px;
    color: var(--color-ink-soft);
    flex-shrink: 0;
    font-size: 0.8rem;
}
.brow__track {
    flex: 1;
    height: 3px;
    background: var(--color-border-soft);
    border-radius: 99px;
    overflow: hidden;
}
.brow__fill {
    height: 100%;
    border-radius: 99px;
    transition: width 0.7s cubic-bezier(.22,.61,.36,1);
}
.brow__count {
    min-width: 32px;
    text-align: right;
    font-weight: 700;
    color: var(--color-ink);
    font-variant-numeric: tabular-nums;
    font-size: 0.78rem;
}

.fill-1 { background: #1E3A8A; }   
.fill-2 { background: #3B82F6; }   
.fill-3 { background: #60A5FA; }   
.fill-4 { background: #93C5FD; }   
.fill-5 { background: #BFDBFE; }   
.fill-x { background: var(--color-border); } 

.numstack { padding: 0; }
.numstack__row {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    padding: 11px 18px;
    border-bottom: 1px solid var(--color-border-soft);
    gap: 8px;
}
.numstack__row:last-child { border-bottom: none; }
.numstack__label {
    font-size: 0.78rem;
    color: var(--color-ink-soft);
    flex: 1;
}
.numstack__val {
    font-size: 1rem;
    font-weight: 800;
    color: var(--color-ink);
    font-variant-numeric: tabular-nums;
    font-family: var(--font-display);
    letter-spacing: -0.02em;
}
.numstack__val--muted {
    color: var(--color-ink-muted);
    font-weight: 600;
    font-size: 0.875rem;
}

.numstack__row--accent-1 { border-left: 2px solid #1E3A8A; }
.numstack__row--accent-2 { border-left: 2px solid #3B82F6; }
.numstack__row--accent-3 { border-left: 2px solid #60A5FA; }
.numstack__row--accent-x { border-left: 2px solid var(--color-border); }

@media (max-width: 960px) {
    .stats-body { grid-template-columns: 1fr; }
    .stats-side { flex-direction: row; flex-wrap: wrap; }
    .stats-side > * { flex: 1 1 240px; }
    .chart-canvas-wrap--short { height: 160px; }
}
@media (max-width: 600px) {
    .stats-side { flex-direction: column; }
    .stats-side > * { flex: none; }
}
</style>
@endpush

@section('content')

<div class="stats-head">
    <div>
        <h1 class="stats-head__title">Statistik Platform</h1>
        <p class="stats-head__sub">Data dan aktivitas platform AksiKita.</p>
    </div>
    <span class="stats-head__ts">{{ now()->isoFormat('D MMM YYYY, HH:mm') }} WIB</span>
</div>

@if($reports['open'] > 0)
<div class="rcallout">
    <div class="rcallout__num">{{ $reports['open'] }}</div>
    <div class="rcallout__text">
        <strong>Laporan menunggu tindakan</strong>
        <span>{{ $reports['total'] }} total masuk &middot; {{ $reports['resolved'] }} sudah diselesaikan</span>
    </div>
    <a href="{{ route('admin.reports') }}?tab=open" class="rcallout__action">Tinjau</a>
</div>
@endif

<div class="stats-body">

    <div class="stats-main">

        <div class="sp">
            <div class="sp__head">
                <span class="sp__name">Aktivitas 6 Bulan Terakhir</span>
            </div>
            <div class="sp__chart">
                <div class="chart-legend">
                    <span class="chart-legend__item">
                        <span class="chart-legend__line" style="background:#1E3A8A;"></span>
                        Pendaftaran
                    </span>
                    <span class="chart-legend__item">
                        <span class="chart-legend__line" style="background:#60A5FA;"></span>
                        Pengguna baru
                    </span>
                    <span class="chart-legend__item">
                        <span class="chart-legend__line" style="background:#93C5FD; border-top: 1px dashed #93C5FD; height:0;"></span>
                        Kegiatan baru
                    </span>
                </div>
                <div class="chart-canvas-wrap chart-canvas-wrap--tall">
                    <canvas id="chartActivity"></canvas>
                </div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

            <div class="sp">
                <div class="sp__head">
                    <div style="display:flex; align-items:baseline; gap:10px;">
                        <span class="sp__name">Pengguna</span>
                        <span class="sp__total">{{ number_format($users['total']) }}</span>
                    </div>
                    <a href="{{ route('admin.users') }}" class="sp__link">Lihat semua</a>
                </div>
                @php
                    $userRows = [
                        ['label' => 'Volunteer',   'value' => $users['volunteers'],    'fill' => 'fill-1'],
                        ['label' => 'Organisasi',  'value' => $users['organizations'], 'fill' => 'fill-2'],
                        ['label' => 'Admin',       'value' => $users['admins'],        'fill' => 'fill-3'],
                        ['label' => 'Tidak aktif', 'value' => $users['inactive'],      'fill' => 'fill-x'],
                    ];
                    $userMax = max(array_column($userRows, 'value')) ?: 1;
                @endphp
                @foreach($userRows as $row)
                    <div class="brow">
                        <span class="brow__label">{{ $row['label'] }}</span>
                        <div class="brow__track">
                            <div class="brow__fill {{ $row['fill'] }}" style="width:{{ round($row['value'] / $userMax * 100) }}%"></div>
                        </div>
                        <span class="brow__count">{{ number_format($row['value']) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="sp">
                <div class="sp__head">
                    <div style="display:flex; align-items:baseline; gap:10px;">
                        <span class="sp__name">Kegiatan</span>
                        <span class="sp__total">{{ number_format($events['total']) }}</span>
                    </div>
                    <a href="{{ route('admin.events') }}" class="sp__link">Lihat semua</a>
                </div>
                @php
                    $eventRows = [
                        ['label' => 'Aktif',         'value' => $events['published'],      'fill' => 'fill-1'],
                        ['label' => 'Selesai',        'value' => $events['completed'],      'fill' => 'fill-2'],
                        ['label' => 'Pending review', 'value' => $events['pending_review'], 'fill' => 'fill-3'],
                        ['label' => 'Draft',          'value' => $events['draft'],          'fill' => 'fill-4'],
                        ['label' => 'Ditolak',        'value' => $events['rejected'],       'fill' => 'fill-x'],
                        ['label' => 'Dibatalkan',     'value' => $events['cancelled'],      'fill' => 'fill-x'],
                    ];
                    $eventMax = max(array_column($eventRows, 'value')) ?: 1;
                @endphp
                @foreach($eventRows as $row)
                    <div class="brow">
                        <span class="brow__label">{{ $row['label'] }}</span>
                        <div class="brow__track">
                            <div class="brow__fill {{ $row['fill'] }}" style="width:{{ round($row['value'] / $eventMax * 100) }}%"></div>
                        </div>
                        <span class="brow__count">{{ number_format($row['value']) }}</span>
                    </div>
                @endforeach
            </div>

        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

            <div class="sp">
                <div class="sp__head">
                    <div style="display:flex; align-items:baseline; gap:10px;">
                        <span class="sp__name">Organisasi</span>
                        <span class="sp__total">{{ number_format($organizations['total']) }}</span>
                    </div>
                    <a href="{{ route('admin.users') }}?tab=organisasi" class="sp__link">Lihat semua</a>
                </div>
                @php
                    $orgRows = [
                        ['label' => 'Terverifikasi', 'value' => $organizations['verified'], 'fill' => 'fill-1'],
                        ['label' => 'Menunggu',      'value' => $organizations['pending'],  'fill' => 'fill-3'],
                        ['label' => 'Ditolak',       'value' => $organizations['rejected'], 'fill' => 'fill-x'],
                    ];
                    $orgMax = max(array_column($orgRows, 'value')) ?: 1;
                @endphp
                @foreach($orgRows as $row)
                    <div class="brow">
                        <span class="brow__label">{{ $row['label'] }}</span>
                        <div class="brow__track">
                            <div class="brow__fill {{ $row['fill'] }}" style="width:{{ round($row['value'] / $orgMax * 100) }}%"></div>
                        </div>
                        <span class="brow__count">{{ number_format($row['value']) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="sp">
                <div class="sp__head">
                    <div style="display:flex; align-items:baseline; gap:10px;">
                        <span class="sp__name">Pendaftaran</span>
                        <span class="sp__total">{{ number_format($registrations['total']) }}</span>
                    </div>
                </div>
                @php
                    $regRows = [
                        ['label' => 'Hadir',     'value' => $registrations['attended'],  'fill' => 'fill-1'],
                        ['label' => 'Confirmed', 'value' => $registrations['confirmed'], 'fill' => 'fill-2'],
                        ['label' => 'Pending',   'value' => $registrations['pending'],   'fill' => 'fill-3'],
                        ['label' => 'Dibatalkan','value' => $registrations['cancelled'], 'fill' => 'fill-x'],
                    ];
                    $regMax = max(array_column($regRows, 'value')) ?: 1;
                @endphp
                @foreach($regRows as $row)
                    <div class="brow">
                        <span class="brow__label">{{ $row['label'] }}</span>
                        <div class="brow__track">
                            <div class="brow__fill {{ $row['fill'] }}" style="width:{{ round($row['value'] / $regMax * 100) }}%"></div>
                        </div>
                        <span class="brow__count">{{ number_format($row['value']) }}</span>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    <div class="stats-side">

        <div class="sp">
            <div class="sp__head">
                <span class="sp__name">Ringkasan</span>
            </div>
            <div class="numstack">
                <div class="numstack__row numstack__row--accent-1">
                    <span class="numstack__label">Total pengguna</span>
                    <span class="numstack__val">{{ number_format($users['total']) }}</span>
                </div>
                <div class="numstack__row numstack__row--accent-2">
                    <span class="numstack__label">Total kegiatan</span>
                    <span class="numstack__val">{{ number_format($events['total']) }}</span>
                </div>
                <div class="numstack__row numstack__row--accent-3">
                    <span class="numstack__label">Total pendaftaran</span>
                    <span class="numstack__val">{{ number_format($registrations['total']) }}</span>
                </div>
                <div class="numstack__row numstack__row--accent-x">
                    <span class="numstack__label">Total laporan</span>
                    <span class="numstack__val {{ $reports['open'] > 0 ? '' : 'numstack__val--muted' }}">{{ number_format($reports['total']) }}</span>
                </div>
            </div>
        </div>

        <div class="sp">
            <div class="sp__head">
                <span class="sp__name">Kegiatan Baru</span>
            </div>
            <div class="sp__chart">
                <div class="chart-canvas-wrap chart-canvas-wrap--short">
                    <canvas id="chartEvents"></canvas>
                </div>
            </div>
        </div>
        <div class="sp">
            <div class="sp__head">
                <span class="sp__name">Status Organisasi</span>
            </div>
            <div class="numstack">
                <div class="numstack__row numstack__row--accent-1">
                    <span class="numstack__label">Terverifikasi</span>
                    <span class="numstack__val">{{ number_format($organizations['verified']) }}</span>
                </div>
                <div class="numstack__row numstack__row--accent-3">
                    <span class="numstack__label">Menunggu</span>
                    <span class="numstack__val">{{ number_format($organizations['pending']) }}</span>
                </div>
                <div class="numstack__row numstack__row--accent-x">
                    <span class="numstack__label">Ditolak</span>
                    <span class="numstack__val numstack__val--muted">{{ number_format($organizations['rejected']) }}</span>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {
    const labels = @json($trendLabels);

    const cs     = getComputedStyle(document.documentElement);
    const border = cs.getPropertyValue('--color-border').trim()    || '#E5E7EB';
    const muted  = cs.getPropertyValue('--color-ink-muted').trim() || '#6B7280';

    const navy    = '#1E3A8A';
    const blue    = '#3B82F6';
    const blueMid = '#60A5FA';

    const tickFont = { size: 11, family: "'DM Sans', sans-serif" };

    const baseScales = {
        x: {
            grid: { display: false },
            ticks: { color: muted, font: tickFont },
        },
        y: {
            beginAtZero: true,
            grid: { color: border, drawBorder: false },
            ticks: { color: muted, font: tickFont, precision: 0 },
        },
    };

    const tip = {
        backgroundColor: '#111827',
        titleColor: '#F9FAFB',
        bodyColor: '#9CA3AF',
        padding: 10,
        cornerRadius: 6,
        displayColors: true,
        boxWidth: 8,
        boxHeight: 8,
    };

    new Chart(document.getElementById('chartActivity'), {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Pendaftaran',
                    data: @json($trendData),
                    borderColor: navy,
                    backgroundColor: navy + '18',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: navy,
                    tension: 0.35,
                    fill: true,
                },
                {
                    label: 'Pengguna baru',
                    data: @json($userTrendData),
                    borderColor: blueMid,
                    backgroundColor: 'transparent',
                    borderWidth: 1.5,
                    pointRadius: 3,
                    pointBackgroundColor: blueMid,
                    tension: 0.35,
                    fill: false,
                },
                {
                    label: 'Kegiatan baru',
                    data: @json($eventTrendData),
                    borderColor: '#93C5FD',
                    backgroundColor: 'transparent',
                    borderWidth: 1.5,
                    borderDash: [4, 3],
                    pointRadius: 2,
                    pointBackgroundColor: '#93C5FD',
                    tension: 0.35,
                    fill: false,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: tip },
            scales: baseScales,
        },
    });

    new Chart(document.getElementById('chartEvents'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Kegiatan',
                data: @json($eventTrendData),
                backgroundColor: navy + '28',
                borderColor: navy,
                borderWidth: 1.5,
                borderRadius: 3,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: tip },
            scales: {
                x: { grid: { display: false }, ticks: { color: muted, font: { size: 10 } } },
                y: { beginAtZero: true, grid: { color: border, drawBorder: false }, ticks: { color: muted, font: { size: 10 }, precision: 0 } },
            },
        },
    });
})();
</script>
@endpush
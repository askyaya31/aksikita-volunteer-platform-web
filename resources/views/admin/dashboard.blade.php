@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>

/* ── Header ── */
.dh {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    gap: 16px;
}
.dh__title {
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--color-navy);
    letter-spacing: -0.02em;
    margin: 0 0 2px;
}
.dh__date {
    font-size: 0.75rem;
    color: var(--color-ink-muted);
}

/* Alert pill — pending org */
.dh__alert {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 8px 7px 12px;
    background: var(--color-navy);
    border-radius: var(--radius-sm);
    text-decoration: none;
    transition: opacity 0.15s;
    flex-shrink: 0;
}
.dh__alert:hover { opacity: 0.88; }
.dh__alert-body {
    display: flex;
    align-items: baseline;
    gap: 5px;
}
.dh__alert-num {
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.04em;
    line-height: 1;
}
.dh__alert-text {
    font-size: 0.73rem;
    color: rgba(255,255,255,0.75);
    line-height: 1.3;
}
.dh__alert-btn {
    font-size: 0.71rem;
    font-weight: 700;
    background: var(--color-blue);
    color: #fff;
    padding: 4px 11px;
    border-radius: var(--radius-full);
    white-space: nowrap;
}

/* ── Metrics — 4 col strip ── */
.dm {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    background: var(--color-border);
    gap: 1px;
    overflow: hidden;
    margin-bottom: 18px;
}
.dm__cell {
    background: var(--color-surface);
    padding: 15px 18px;
    transition: background 0.12s;
}
.dm__cell:hover { background: var(--color-bg); }

.dm__label {
    font-size: 0.69rem;
    color: var(--color-ink-muted);
    font-weight: 500;
    margin-bottom: 5px;
}
.dm__val {
    font-family: var(--font-display);
    font-size: 1.85rem;
    font-weight: 800;
    color: var(--color-navy);
    letter-spacing: -0.05em;
    line-height: 1;
    margin-bottom: 5px;
    font-variant-numeric: tabular-nums;
}
.dm__sub {
    font-size: 0.71rem;
    color: var(--color-ink-muted);
    line-height: 1.4;
}
.dm__sub b { color: var(--color-ink-soft); font-weight: 600; }
.dm__cta {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 0.71rem;
    font-weight: 600;
    color: var(--color-blue);
    text-decoration: none;
}
.dm__cta:hover { text-decoration: underline; }

/* ── Queue cards ── */
.dq {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.qc {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
}
.qc__head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 11px 14px;
    border-bottom: 1px solid var(--color-border);
}
.qc__title {
    font-size: 0.79rem;
    font-weight: 600;
    color: var(--color-ink);
    margin: 0;
}
.qc__right {
    display: flex;
    align-items: center;
    gap: 7px;
}
.qc__count {
    font-size: 0.65rem;
    font-weight: 700;
    background: var(--color-blue);
    color: #fff;
    padding: 1px 6px;
    border-radius: var(--radius-full);
    font-variant-numeric: tabular-nums;
}
.qc__link {
    font-size: 0.72rem;
    color: var(--color-ink-muted);
    text-decoration: none;
}
.qc__link:hover { color: var(--color-blue); }

/* Queue rows */
.qr {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 14px;
    border-bottom: 1px solid var(--color-border-soft);
    transition: background 0.1s;
}
.qr:last-child { border-bottom: none; }
.qr:hover { background: var(--color-bg); }

.qr__ava {
    width: 32px; height: 32px;
    border-radius: 6px;
    border: 1px solid var(--color-border);
    object-fit: cover;
    flex-shrink: 0;
}
.qr__mono {
    width: 32px; height: 32px;
    border-radius: 6px;
    border: 1px solid var(--color-border);
    background: var(--color-border-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-weight: 700;
    font-size: 12px;
    color: var(--color-ink-soft);
    flex-shrink: 0;
}
.qr__body { flex: 1; min-width: 0; }
.qr__name {
    font-size: 0.81rem;
    font-weight: 600;
    color: var(--color-ink);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.25;
}
.qr__meta {
    font-size: 0.7rem;
    color: var(--color-ink-muted);
    margin: 1px 0 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.qr__status {
    font-size: 0.7rem;
    color: var(--color-ink-muted);
    flex-shrink: 0;
}
.qr__btn {
    font-size: 0.71rem;
    font-weight: 600;
    color: var(--color-blue);
    text-decoration: none;
    flex-shrink: 0;
    padding: 4px 11px;
    border: 1px solid var(--color-blue-light);
    border-radius: var(--radius-full);
    transition: background 0.12s, color 0.12s, border-color 0.12s;
}
.qr__btn:hover {
    background: var(--color-blue);
    color: #fff;
    border-color: var(--color-blue);
}

.qc-empty {
    padding: 28px 14px;
    text-align: center;
}
.qc-empty p {
    font-size: 0.76rem;
    color: var(--color-ink-muted);
    margin: 0;
}

/* ── Responsive ── */
@media (max-width: 860px) {
    .dm  { grid-template-columns: repeat(2, 1fr); }
    .dq  { grid-template-columns: 1fr; }
}
@media (max-width: 520px) {
    .dm__val { font-size: 1.5rem; }
    .dh { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="dh">
    <div>
        <p class="dh__title">Dashboard Admin AksiKita</p>
        <span class="dh__date">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</span>
    </div>
</div>

{{-- Metrics --}}
<div class="dm">
    <div class="dm__cell">
        <div class="dm__label">Total Pengguna</div>
        <div class="dm__val">{{ number_format($stats['total_users']) }}</div>
        <div class="dm__sub">
            <b>{{ number_format($stats['total_volunteers']) }}</b> relawan &middot;
            <b>{{ number_format($stats['total_organizations']) }}</b> organisasi
        </div>
    </div>

    <div class="dm__cell">
        <div class="dm__label">Total Kegiatan</div>
        <div class="dm__val">{{ number_format($stats['total_events']) }}</div>
        <div class="dm__sub">
            <b>{{ number_format($stats['published_events']) }}</b> aktif &middot;
            <b>{{ number_format($stats['pending_events']) }}</b> menunggu review
        </div>
    </div>

    <div class="dm__cell">
        <div class="dm__label">Total Pendaftaran</div>
        <div class="dm__val">{{ number_format($stats['total_registrations']) }}</div>
        <div class="dm__sub">Semua waktu</div>
    </div>

    <div class="dm__cell">
        <div class="dm__label">Organisasi Pending</div>
        <div class="dm__val">{{ number_format($stats['pending_org']) }}</div>
        @if($stats['pending_org'] > 0)
            <a href="{{ route('admin.users') }}?tab=organisasi" class="dm__cta">
                Tinjau sekarang
                <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @else
            <div class="dm__sub">Tidak ada antrian</div>
        @endif
    </div>
</div>

{{-- Queue cards --}}
<div class="dq">

    <div class="qc">
        <div class="qc__head">
            <span class="qc__title">Verifikasi Organisasi</span>
            <div class="qc__right">
                @if(!$pendingOrgs->isEmpty())
                    <span class="qc__count">{{ $pendingOrgs->count() }}</span>
                @endif
                <a href="{{ route('admin.users') }}?tab=organisasi" class="qc__link">Lihat semua</a>
            </div>
        </div>
        @if($pendingOrgs->isEmpty())
            <div class="qc-empty"><p>Tidak ada organisasi yang menunggu.</p></div>
        @else
            @foreach($pendingOrgs as $org)
                @php
                    $logoSrc  = $org->logo ? asset('storage/' . $org->logo) : null;
                    $initials = strtoupper(substr($org->organization_name ?? $org->user->name, 0, 1));
                @endphp
                <div class="qr">
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="{{ $org->organization_name }}" class="qr__ava">
                    @else
                        <div class="qr__mono">{{ $initials }}</div>
                    @endif
                    <div class="qr__body">
                        <p class="qr__name">{{ $org->organization_name ?? $org->user->name }}</p>
                        <p class="qr__meta">{{ $org->user->email }}{{ $org->city ? ' · ' . $org->city : '' }}</p>
                    </div>
                    <span class="qr__status">Menunggu</span>
                </div>
            @endforeach
        @endif
    </div>

    <div class="qc">
        <div class="qc__head">
            <span class="qc__title">Review Kegiatan</span>
            <div class="qc__right">
                @if(!$pendingEvents->isEmpty())
                    <span class="qc__count">{{ $pendingEvents->count() }}</span>
                @endif
                <a href="{{ route('admin.events') }}?status=pending_review" class="qc__link">Lihat semua</a>
            </div>
        </div>
        @if($pendingEvents->isEmpty())
            <div class="qc-empty"><p>Tidak ada kegiatan yang menunggu review.</p></div>
        @else
            @foreach($pendingEvents as $event)
                @php
                    $posterSrc    = $event->poster ? asset('storage/' . $event->poster) : null;
                    $eventInitial = strtoupper(substr($event->title, 0, 1));
                @endphp
                <div class="qr">
                    @if($posterSrc)
                        <img src="{{ $posterSrc }}" alt="{{ $event->title }}" class="qr__ava">
                    @else
                        <div class="qr__mono">{{ $eventInitial }}</div>
                    @endif
                    <div class="qr__body">
                        <p class="qr__name">{{ $event->title }}</p>
                        <p class="qr__meta">{{ $event->organization->organization_name ?? '-' }}{{ $event->city ? ' · ' . $event->city : '' }}</p>
                    </div>
                    <a href="{{ route('admin.events.show', $event->id) }}" class="qr__btn">Tinjau</a>
                </div>
            @endforeach
        @endif
    </div>

</div>

@endsection
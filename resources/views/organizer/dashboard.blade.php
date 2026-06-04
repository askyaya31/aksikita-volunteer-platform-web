@extends('layouts.organizer')
@section('title', 'Dashboard Organizer')

@push('styles')
<style>

.org-hero {
    background: linear-gradient(135deg, #0F2057 0%, #1A3575 60%, #2A4A9C 100%);
    padding: 2.25rem 0 4rem;
    position: relative;
    overflow: hidden;
}
.org-hero::before {
    content: '';
    position: absolute;
    right: -80px; top: -80px;
    width: 300px; height: 300px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
    pointer-events: none;
}
.org-hero-inner {
    position: relative; z-index: 1;
    display: flex; align-items: flex-end; justify-content: space-between;
    gap: 16px; flex-wrap: wrap;
}
.org-hero-greeting {
    font-size: 12px; font-weight: 500;
    color: rgba(255,255,255,0.55);
    margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.08em;
}
.org-hero-name {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 24px; font-weight: 700;
    color: #fff; line-height: 1.2; margin-bottom: 8px;
}
.org-hero-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px; font-weight: 600;
}
.org-hero-badge.verified { background: rgba(16,185,129,0.18); color: #6ee7b7; }
.org-hero-badge.pending  { background: rgba(245,158,11,0.18); color: #fcd34d; }
.org-hero-badge.rejected { background: rgba(239,68,68,0.18);  color: #fca5a5; }
.org-hero-badge-dot { width: 6px; height: 6px; border-radius: 50%; }
.org-hero-badge.verified .org-hero-badge-dot { background: #34d399; }
.org-hero-badge.pending  .org-hero-badge-dot { background: #fbbf24; }
.org-hero-badge.rejected .org-hero-badge-dot { background: #f87171; }

.org-hero-cta {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 20px;
    background: #E8501A; color: #fff;
    border-radius: 999px;
    font-size: 13px; font-weight: 600;
    text-decoration: none;
    transition: background 0.15s, transform 0.15s;
    white-space: nowrap; flex-shrink: 0;
}
.org-hero-cta:hover { background: #F5773D; transform: translateY(-1px); color: #fff; }

.org-stats-wrap {
    margin-top: -44px;
    position: relative; z-index: 10;
    margin-bottom: 2rem;
}
.org-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}
.org-stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.1rem 1.25rem;
    box-shadow: 0 4px 20px rgba(15,32,87,0.12);
    display: flex; align-items: flex-start; gap: 12px;
    border: 1px solid #EEF0F6;
    transition: box-shadow 0.2s, transform 0.2s;
}
.org-stat-card:hover { box-shadow: 0 8px 28px rgba(15,32,87,0.16); transform: translateY(-2px); }
.org-stat-icon {
    width: 40px; height: 40px; flex-shrink: 0;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
}
.org-stat-icon.blue  { background: #EEF3FF; color: #3B82F6; }
.org-stat-icon.amber { background: #FFFBEB; color: #F59E0B; }
.org-stat-icon.green { background: #ECFDF5; color: #10B981; }
.org-stat-icon.navy  { background: #EEF0FF; color: #1E3A8A; }
.org-stat-num {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 1.6rem; font-weight: 700;
    color: var(--color-navy); line-height: 1.1;
    letter-spacing: -0.02em;
}
.org-stat-label {
    font-size: 0.75rem; color: var(--color-ink-muted); margin-top: 2px;
}

@media (max-width: 900px) {
    .org-stats { grid-template-columns: repeat(2, 1fr); }
    .org-hero-name { font-size: 20px; }
}
@media (max-width: 540px) {
    .org-stats { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .org-stat-num { font-size: 1.35rem; }
    .org-hero { padding: 1.75rem 0 3.5rem; }
}

.org-notice {
    border-radius: 14px;
    padding: 14px 18px;
    display: flex; gap: 14px; align-items: flex-start;
    margin-bottom: 1.25rem;
    font-size: 0.875rem;
}
.org-notice.pending { background: #FFFBEB; border: 1.5px solid #FDE68A; }
.org-notice.rejected { background: #FEF2F2; border: 1.5px solid #FECACA; }
.org-notice-icon {
    width: 34px; height: 34px; flex-shrink: 0; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
}
.org-notice.pending  .org-notice-icon { background: #FEF3C7; }
.org-notice.rejected .org-notice-icon { background: #FEE2E2; }
.org-notice-title { font-weight: 600; font-size: 0.875rem; margin-bottom: 3px; }
.org-notice.pending  .org-notice-title { color: #92400e; }
.org-notice.rejected .org-notice-title { color: #991b1b; }
.org-notice-desc { font-size: 0.8rem; line-height: 1.5; }
.org-notice.pending  .org-notice-desc { color: #a16207; }
.org-notice.rejected .org-notice-desc { color: #b91c1c; }
.org-notice-link { display: inline-block; margin-top: 6px; font-size: 0.8rem; font-weight: 600; text-decoration: underline; text-underline-offset: 2px; }
.org-notice.pending  .org-notice-link { color: #b45309; }
.org-notice.rejected .org-notice-link { color: #dc2626; }

.org-section-header {
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; margin-bottom: 1rem;
}
.org-section-title { font-size: 0.9375rem; font-weight: 700; color: var(--color-navy); }
.org-section-sub   { font-size: 0.78rem; color: var(--color-ink-muted); margin-top: 1px; }
.org-section-link  {
    font-size: 0.8rem; font-weight: 600; color: var(--color-blue);
    text-decoration: none; display: flex; align-items: center; gap: 4px;
    white-space: nowrap;
}
.org-section-link:hover { color: var(--color-navy); }

.org-event-row {
    display: flex; align-items: center; gap: 14px;
    padding: 12px 18px;
    border-bottom: 1px solid var(--color-border-soft);
    transition: background 0.12s;
}
.org-event-row:last-child { border-bottom: none; }
.org-event-row:hover { background: var(--color-bg); }

.org-event-thumb {
    width: 38px; height: 38px; flex-shrink: 0;
    border-radius: 9px; overflow: hidden;
    background: var(--color-blue-ghost);
    display: flex; align-items: center; justify-content: center;
}
.org-event-thumb img { width: 100%; height: 100%; object-fit: cover; }
.org-event-title { font-size: 0.875rem; font-weight: 600; color: var(--color-ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 320px; }
.org-event-meta  { font-size: 0.75rem; color: var(--color-ink-muted); margin-top: 1px; }
.org-event-detail { font-size: 0.78rem; font-weight: 600; color: var(--color-blue); text-decoration: none; margin-left: auto; flex-shrink: 0; white-space: nowrap; }
.org-event-detail:hover { color: var(--color-navy); }
</style>
@endpush

@section('content')

<section class="org-hero">
    <div class="ak-container">
        <div class="org-hero-inner">
            <div>
                <p class="org-hero-greeting">Selamat datang kembali</p>
                <h1 class="org-hero-name">{{ $org->organization_name }}</h1>
                @if($org->verification_status === 'verified')
                    <span class="org-hero-badge verified">
                        <span class="org-hero-badge-dot"></span>
                        Terverifikasi
                    </span>
                @elseif($org->verification_status === 'pending')
                    <span class="org-hero-badge pending">
                        <span class="org-hero-badge-dot"></span>
                        Menunggu verifikasi
                    </span>
                @elseif($org->verification_status === 'rejected')
                    <span class="org-hero-badge rejected">
                        <span class="org-hero-badge-dot"></span>
                        Verifikasi ditolak
                    </span>
                @endif
            </div>
            @if($org->verification_status === 'verified')
                <a href="{{ route('organizer.events.create') }}" class="org-hero-cta">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Buat Event Baru
                </a>
            @endif
        </div>
    </div>
</section>

<div class="ak-container">
    <div class="org-stats-wrap">
        <div class="org-stats">
            <div class="org-stat-card">
                <div class="org-stat-icon blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div>
                    <div class="org-stat-num">{{ $stats['total'] }}</div>
                    <div class="org-stat-label">Total Event</div>
                </div>
            </div>
            <div class="org-stat-card">
                <div class="org-stat-icon amber">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <div class="org-stat-num">{{ $stats['pending'] }}</div>
                    <div class="org-stat-label">Menunggu Review</div>
                </div>
            </div>
            <div class="org-stat-card">
                <div class="org-stat-icon green">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                </div>
                <div>
                    <div class="org-stat-num">{{ $stats['published'] }}</div>
                    <div class="org-stat-label">Event Aktif</div>
                </div>
            </div>
            <div class="org-stat-card">
                <div class="org-stat-icon navy">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <div>
                    <div class="org-stat-num">{{ $stats['volunteers'] }}</div>
                    <div class="org-stat-label">Total Volunteer</div>
                </div>
            </div>
        </div>
    </div>

    @if($org->verification_status === 'pending')
        <div class="org-notice pending">
            <div class="org-notice-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <p class="org-notice-title">Profil sedang dalam proses verifikasi</p>
                <p class="org-notice-desc">
                    Tim AksiKita akan meninjau data organisasi kamu. Setelah terverifikasi, kamu dapat membuat dan mempublikasikan event volunteer.
                </p>
                <a href="{{ route('organizer.profile') }}" class="org-notice-link">Lengkapi profil sekarang</a>
            </div>
        </div>
    @endif

    @if($org->verification_status === 'rejected')
        <div class="org-notice rejected">
            <div class="org-notice-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round">
                    <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div>
                <p class="org-notice-title">Verifikasi organisasi ditolak</p>
                @if($org->rejection_reason)
                    <p class="org-notice-desc">Alasan: {{ $org->rejection_reason }}</p>
                @endif
                <a href="{{ route('organizer.profile') }}" class="org-notice-link">Perbarui profil dan ajukan ulang</a>
            </div>
        </div>
    @endif

    @php
        $statusColors = [
            'draft'          => 'ak-badge ak-badge-gray',
            'pending_review' => 'ak-badge ak-badge-warning',
            'published'      => 'ak-badge ak-badge-success',
            'rejected'       => 'ak-badge ak-badge-danger',
            'completed'      => 'ak-badge ak-badge-navy',
            'cancelled'      => 'ak-badge ak-badge-gray',
        ];
        $statusLabels = [
            'draft'          => 'Draft',
            'pending_review' => 'Review',
            'published'      => 'Aktif',
            'rejected'       => 'Ditolak',
            'completed'      => 'Selesai',
            'cancelled'      => 'Dibatalkan',
        ];
    @endphp

    <div class="ak-card-flat" style="margin-bottom: 2.5rem;">
        <div class="org-section-header" style="padding: 0 0 12px; border-bottom: 1px solid var(--color-border-soft); margin-bottom: 0;">
            <div>
                <p class="org-section-title">Event Terbaru</p>
                <p class="org-section-sub">5 event terakhir yang kamu buat</p>
            </div>
            <a href="{{ route('organizer.events') }}" class="org-section-link">
                Lihat semua
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>

        @forelse($recentEvents as $event)
            <div class="org-event-row">
                <div class="org-event-thumb">
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
                    @else
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--color-blue)" stroke-width="1.5" stroke-linecap="round">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <line x1="7" y1="9" x2="17" y2="9"/><line x1="7" y1="13" x2="13" y2="13"/>
                        </svg>
                    @endif
                </div>
                <div style="flex:1; min-width:0;">
                    <p class="org-event-title">{{ $event->title }}</p>
                    <p class="org-event-meta">{{ $event->city }} &middot; {{ $event->start_date->format('d M Y') }}</p>
                </div>
                <span class="{{ $statusColors[$event->status] ?? 'ak-badge ak-badge-gray' }}" style="flex-shrink:0;">
                    {{ $statusLabels[$event->status] ?? $event->status }}
                </span>
                <a href="{{ route('organizer.events.show', $event->id) }}" class="org-event-detail">Detail</a>
            </div>
        @empty
            <div class="ak-empty-state" style="padding:48px 24px;">
                <div class="ak-empty-state__icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                        <rect x="3" y="4" width="18" height="16" rx="2"/><line x1="12" y1="9" x2="12" y2="15"/><line x1="9" y1="12" x2="15" y2="12"/>
                    </svg>
                </div>
                <h3>Belum ada event</h3>
                <p>Mulai buat event volunteer pertama kamu</p>
                @if($org->verification_status === 'verified')
                    <a href="{{ route('organizer.events.create') }}" class="ak-btn ak-btn-primary ak-btn-sm">Buat Event Pertama</a>
                @endif
            </div>
        @endforelse
    </div>
</div>

@endsection
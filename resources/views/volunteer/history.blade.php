@extends('layouts.volunteer')
@section('title', 'Riwayat Kegiatan — AksiKita')

@push('styles')
<style>
.history-wrap { max-width: 760px; margin: 0 auto; }

.history-head {
    margin-bottom: 24px;
}
.history-head__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-text-primary);
    letter-spacing: -0.025em;
    line-height: 1.2;
}
.history-head__sub {
    font-size: 0.875rem;
    color: var(--color-text-muted);
    margin-top: 4px;
}

.history-tabs {
    display: flex;
    gap: 4px;
    background: var(--color-surface);
    border-radius: 14px;
    padding: 4px;
    width: fit-content;
    margin-bottom: 24px;
    border: 1px solid var(--color-border);
}
.history-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 20px;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.18s;
    color: var(--color-text-muted);
}
.history-tab--active {
    background: var(--color-canvas);
    color: var(--color-brand-700);
    box-shadow: 0 1px 4px rgba(15,23,42,.08), 0 0 0 1px var(--color-border);
}
.history-tab:not(.history-tab--active):hover {
    color: var(--color-text-primary);
    background: rgba(255,255,255,0.6);
}
.history-tab__dot {
    width: 7px; height: 7px;
    border-radius: 50%;
}

/* ── Card: polos, full width, tanpa accent border kiri ── */
.history-card {
    background: var(--color-canvas);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-xl);
    padding: 18px 20px;
    margin-bottom: 12px;
    display: flex;
    gap: 16px;
    align-items: center;
    transition: box-shadow 0.18s, transform 0.18s;
    text-decoration: none;
}
.history-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-1px);
}

.history-card__thumb {
    width: 64px; height: 64px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--color-surface);
    display: flex;
    align-items: center;
    justify-content: center;
}
.history-card__thumb img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.history-card__thumb-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
}

.history-card__body { flex: 1; min-width: 0; }

.history-card__cats {
    display: flex; gap: 5px;
    flex-wrap: wrap;
    margin-bottom: 6px;
}

.history-card__title {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--color-text-primary);
    letter-spacing: -0.01em;
    line-height: 1.35;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.history-card__org {
    font-size: 0.8rem;
    color: var(--color-text-muted);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.history-card__meta {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 0.775rem;
    color: var(--color-text-muted);
    flex-wrap: wrap;
}

.history-card__meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
}

/* ── Right column: badge di atas (kanan-atas), tanggal di bawahnya ── */
.history-card__right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
    flex-shrink: 0;
    align-self: flex-start;
}

.history-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 16px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.01em;
    line-height: 1;
    color: #fff;
}
.history-badge--confirmed  { background: #10B981; } /* hijau */
.history-badge--pending    { background: #F59E0B; } /* kuning */
.history-badge--attended   { background: #10B981; } /* hijau juga, dianggap selesai/oke */
.history-badge--cancelled  { background: #EF4444; } /* merah */

.history-card__date {
    font-size: 0.75rem;
    color: var(--color-text-muted);
    font-weight: 500;
}

.history-empty {
    text-align: center;
    padding: 64px 24px;
    background: var(--color-canvas);
    border: 1px dashed var(--color-border);
    border-radius: var(--radius-xl);
}
.history-empty__icon {
    width: 60px; height: 60px;
    border-radius: var(--radius-xl);
    background: var(--color-brand-50);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
}
.history-empty h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-text-primary);
    margin-bottom: 6px;
}
.history-empty p {
    font-size: 0.875rem;
    color: var(--color-text-muted);
    margin-bottom: 20px;
}

.history-pagination {
    margin-top: 24px;
    display: flex;
    justify-content: center;
}

@media (max-width: 560px) {
    .history-card { flex-wrap: wrap; }
    .history-card__right { flex-direction: row; align-items: center; margin-left: auto; align-self: center; }
    .history-card__thumb { width: 56px; height: 56px; border-radius: 10px; }
}
</style>
@endpush

@section('content')
<div class="history-wrap">

    <div class="history-head">
        <h1 class="history-head__title">Riwayat Kegiatan</h1>
        <p class="history-head__sub">Semua kegiatan yang pernah kamu daftarkan.</p>
    </div>

    <div class="history-tabs">
        <a href="{{ route('volunteer.history', ['tab' => 'aktif']) }}"
           class="history-tab {{ $tab === 'aktif' ? 'history-tab--active' : '' }}">
            <span class="history-tab__dot" style="{{ $tab === 'aktif' ? 'background:#10B981' : 'background:var(--color-border)' }}"></span>
            Aktif
        </a>
        <a href="{{ route('volunteer.history', ['tab' => 'dibatalkan']) }}"
           class="history-tab {{ $tab === 'dibatalkan' ? 'history-tab--active' : '' }}">
            <span class="history-tab__dot" style="{{ $tab === 'dibatalkan' ? 'background:var(--color-brand-600)' : 'background:var(--color-border)' }}"></span>
            Dibatalkan
        </a>
    </div>

    @forelse($registrations as $reg)
    @php
        $catColor = $reg->event->categories->first()?->color ?? '#3B82F6';
        $badgeClass = match($reg->status) {
            'confirmed' => 'history-badge--confirmed',
            'pending'   => 'history-badge--pending',
            'attended'  => 'history-badge--attended',
            default     => 'history-badge--cancelled',
        };
        $badgeLabel = match($reg->status) {
            'confirmed' => 'Diterima',
            'pending'   => 'Menunggu',
            'attended'  => 'Hadir',
            default     => 'Dibatalkan',
        };
    @endphp

    <article class="history-card">
        <div class="history-card__thumb">
            @if($reg->event->poster)
                <img src="{{ asset('storage/' . $reg->event->poster) }}"
                     alt="{{ $reg->event->title }}"
                     loading="lazy">
            @else
                <div class="history-card__thumb-placeholder"
                     style="background: linear-gradient(135deg, {{ $catColor }}22 0%, {{ $catColor }}55 100%);">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24"
                         stroke="{{ $catColor }}" stroke-width="1.5" opacity="0.7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
            @endif
        </div>

        <div class="history-card__body">
            <div class="history-card__cats">
                @foreach($reg->event->categories->take(2) as $cat)
                    <span class="badge"
                          style="background:{{ $cat->color }}18; color:{{ $cat->color }}; border-color:{{ $cat->color }}30;">
                        {{ $cat->name }}
                    </span>
                @endforeach
            </div>

            <h3 class="history-card__title">{{ $reg->event->title }}</h3>

            <p class="history-card__org">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2" style="flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
                {{ $reg->event->organization->organization_name }}
            </p>

            <div class="history-card__meta">
                <span class="history-card__meta-item">
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $reg->event->city }}
                </span>
                <span class="history-card__meta-item">
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $reg->event->start_date->format('d M Y') }}
                </span>
            </div>
        </div>

        <div class="history-card__right">
            <span class="history-badge {{ $badgeClass }}">
                {{ $badgeLabel }}
            </span>
            <span class="history-card__date">
                {{ $reg->registered_at?->format('d M Y') ?? $reg->created_at->format('d M Y') }}
            </span>
        </div>
    </article>
    @empty

    <div class="history-empty">
        <div class="history-empty__icon">
            <svg width="26" height="26" fill="none" viewBox="0 0 24 24"
                 stroke="var(--color-brand-400)" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        @if($tab === 'aktif')
            <h3>Belum ada kegiatan aktif</h3>
            <p>Kamu belum mendaftar ke kegiatan apapun. Yuk mulai berkontribusi!</p>
            <a href="{{ route('volunteer.events') }}" class="btn btn-primary btn-sm">
                Cari Kegiatan
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @else
            <h3>Tidak ada riwayat dibatalkan</h3>
            <p>Bagus! Kamu tidak pernah membatalkan pendaftaran.</p>
        @endif
    </div>

    @endforelse

    <div class="history-pagination">
        {{ $registrations->appends(['tab' => $tab])->links() }}
    </div>

</div>
@endsection
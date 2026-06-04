@extends('layouts.organizer')
@section('title', 'Kelola Event')

@push('styles')
<style>
.org-page-hero {
    background: linear-gradient(135deg, #0F2057 0%, #1A3575 60%, #2A4A9C 100%);
    padding: 2rem 0 1.75rem;
    margin-bottom: 0;
}
.org-page-hero-title {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 22px; font-weight: 700;
    color: #fff; line-height: 1.2; margin-bottom: 4px;
}
.org-page-hero-sub { font-size: 12.5px; color: rgba(255,255,255,0.55); }

.org-tabs-wrap {
    background: #fff;
    border-bottom: 1px solid var(--color-border);
    position: sticky; top: 68px; z-index: 30;
}
.org-tabs {
    display: flex; gap: 0;
    overflow-x: auto;
    scrollbar-width: none;
}
.org-tabs::-webkit-scrollbar { display: none; }
.org-tab {
    padding: 13px 18px;
    font-size: 0.8125rem; font-weight: 500;
    color: var(--color-ink-muted);
    text-decoration: none;
    white-space: nowrap;
    border-bottom: 2px solid transparent;
    transition: color 0.15s, border-color 0.15s;
    display: flex; align-items: center; gap: 6px;
}
.org-tab:hover { color: var(--color-navy); }
.org-tab.active { color: var(--color-navy); border-bottom-color: var(--color-navy); font-weight: 600; }

.org-event-card {
    background: #fff;
    border: 1.5px solid var(--color-border);
    border-radius: 14px;
    padding: 16px 18px;
    display: flex; align-items: flex-start; gap: 14px;
    transition: border-color 0.15s, box-shadow 0.15s;
    box-shadow: var(--shadow-sm);
}
.org-event-card:hover {
    border-color: var(--color-blue-light);
    box-shadow: var(--shadow-md);
}
.org-event-poster {
    width: 58px; height: 58px; flex-shrink: 0;
    border-radius: 10px; overflow: hidden;
    background: var(--color-blue-ghost);
    display: flex; align-items: center; justify-content: center;
}
.org-event-poster img { width: 100%; height: 100%; object-fit: cover; }
.org-event-body { flex: 1; min-width: 0; }
.org-event-badges { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 6px; }
.org-event-title {
    font-size: 0.875rem; font-weight: 600; color: var(--color-ink);
    margin-bottom: 5px; line-height: 1.35;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.org-event-metas { display: flex; flex-wrap: wrap; gap: 12px; }
.org-event-meta-item {
    display: flex; align-items: center; gap: 4px;
    font-size: 0.75rem; color: var(--color-ink-muted);
}
.org-event-rejection {
    margin-top: 8px;
    padding: 8px 12px;
    background: #FEF2F2; border: 1px solid #FECACA;
    border-radius: 8px;
    font-size: 0.75rem; color: #b91c1c; line-height: 1.45;
}
.org-event-actions { display: flex; gap: 7px; flex-shrink: 0; align-items: center; flex-wrap: wrap; }
@media (max-width: 640px) {
    .org-event-card { flex-wrap: wrap; }
    .org-event-actions { flex-direction: row; justify-content: flex-start; }
    .org-event-poster { width: 48px; height: 48px; }
}
</style>
@endpush

@section('content')

<section class="org-page-hero">
    <div class="ak-container">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
            <div>
                <p style="font-size:11px; font-weight:600; color:rgba(255,255,255,0.45); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:4px;">Manajemen</p>
                <h1 class="org-page-hero-title">Kelola Event</h1>
            </div>
            @if($org->verification_status === 'verified')
                <a href="{{ route('organizer.events.create') }}" class="ak-btn ak-btn-sm"
                   style="background:#E8501A; color:#fff; border-color:#E8501A; border-radius:999px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Buat Event
                </a>
            @else
                <span class="ak-badge ak-badge-warning">Menunggu verifikasi untuk membuat event</span>
            @endif
        </div>
    </div>
</section>

<div class="org-tabs-wrap">
    <div class="ak-container">
        <nav class="org-tabs" aria-label="Filter event">
            @foreach([
                'aktif'   => 'Aktif',
                'review'  => 'Ditinjau',
                'draft'   => 'Draft',
                'ditolak' => 'Ditolak',
                'selesai' => 'Selesai',
            ] as $key => $label)
                <a href="{{ route('organizer.events', ['tab' => $key]) }}"
                   class="org-tab {{ $tab === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>
    </div>
</div>

<div class="ak-container" style="padding-top: 1.5rem; padding-bottom: 2.5rem;">

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
            'pending_review' => 'Ditinjau',
            'published'      => 'Aktif',
            'rejected'       => 'Ditolak',
            'completed'      => 'Selesai',
            'cancelled'      => 'Dibatalkan',
        ];
    @endphp
    <div style="display:flex; flex-direction:column; gap:10px;">
        @forelse($events as $event)
            <div class="org-event-card">
                <div class="org-event-poster">
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
                    @else
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-blue)" stroke-width="1.5" stroke-linecap="round">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <line x1="7" y1="9" x2="17" y2="9"/><line x1="7" y1="13" x2="13" y2="13"/>
                        </svg>
                    @endif
                </div>

                <div class="org-event-body">
                    <div class="org-event-badges">
                        <span class="{{ $statusColors[$event->status] ?? 'ak-badge ak-badge-gray' }}">
                            {{ $statusLabels[$event->status] ?? $event->status }}
                        </span>
                        @foreach($event->categories->take(2) as $cat)
                            <span class="ak-badge ak-badge-blue">{{ $cat->name }}</span>
                        @endforeach
                    </div>
                    <p class="org-event-title">{{ $event->title }}</p>
                    <div class="org-event-metas">
                        <span class="org-event-meta-item">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            {{ $event->city }}, {{ $event->province }}
                        </span>
                        <span class="org-event-meta-item">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            {{ $event->start_date->format('d M Y') }}
                        </span>
                        <span class="org-event-meta-item">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                            </svg>
                            {{ $event->registered_count }}/{{ $event->quota }} volunteer
                        </span>
                    </div>
                    @if($event->status === 'rejected' && $event->rejection_reason)
                        <div class="org-event-rejection">
                            <strong>Alasan ditolak:</strong> {{ Str::limit($event->rejection_reason, 120) }}
                        </div>
                    @endif
                </div>

                <div class="org-event-actions">
                    @if($event->status === 'draft')
                        <form action="{{ route('organizer.events.submit', $event->id) }}" method="POST"
                              onsubmit="return confirm('Ajukan event ini ke review admin?')">
                            @csrf
                            <button type="submit" class="ak-btn ak-btn-success ak-btn-sm">Ajukan</button>
                        </form>
                    @endif
                    @if(in_array($event->status, ['draft', 'rejected', 'published']))
                        <a href="{{ route('organizer.events.edit', $event->id) }}" class="ak-btn ak-btn-ghost ak-btn-sm">Edit</a>
                    @endif
                    <a href="{{ route('organizer.events.show', $event->id) }}" class="ak-btn ak-btn-primary ak-btn-sm">Detail</a>
                </div>
            </div>
        @empty
            <div class="ak-card-flat">
                <div class="ak-empty-state">
                    <div class="ak-empty-state__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <line x1="7" y1="9" x2="17" y2="9"/><line x1="7" y1="13" x2="13" y2="13"/>
                        </svg>
                    </div>
                    <h3>Belum ada event di kategori ini</h3>
                    <p>
                        @if($tab === 'aktif') Belum ada event yang sedang aktif.
                        @elseif($tab === 'review') Tidak ada event yang sedang ditinjau.
                        @elseif($tab === 'draft') Kamu belum memiliki draft event.
                        @elseif($tab === 'ditolak') Tidak ada event yang ditolak.
                        @elseif($tab === 'selesai') Belum ada event yang selesai.
                        @endif
                    </p>
                    @if($org->verification_status === 'verified')
                        <a href="{{ route('organizer.events.create') }}" class="ak-btn ak-btn-primary ak-btn-sm">Buat Event Baru</a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    @if($events->hasPages())
        <div class="ak-pagination" style="margin-top: 1.5rem; justify-content: center;">
            {{ $events->appends(['tab' => $tab])->links() }}
        </div>
    @endif

</div>

@endsection
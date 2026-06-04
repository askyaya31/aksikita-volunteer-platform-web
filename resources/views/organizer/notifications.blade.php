@extends('layouts.organizer')
@section('title', 'Notifikasi')

@push('styles')
<style>
.org-page-hero {
    background: linear-gradient(135deg, #0F2057 0%, #1A3575 60%, #2A4A9C 100%);
    padding: 2rem 0 1.75rem;
}
.org-page-hero-title {
    font-family: 'Fraunces', 'Plus Jakarta Sans', serif;
    font-size: 22px; font-weight: 700;
    color: #fff; line-height: 1.2;
}

.notif-item {
    background: #fff;
    border: 1.5px solid var(--color-border);
    border-radius: 14px;
    padding: 14px 16px;
    display: flex; align-items: flex-start; gap: 12px;
    transition: border-color 0.15s, box-shadow 0.15s;
    box-shadow: var(--shadow-sm);
}
.notif-item:not(.notif-read):hover {
    border-color: var(--color-blue-light);
    box-shadow: var(--shadow-md);
}
.notif-item.notif-read { opacity: 0.6; }
.notif-icon {
    width: 36px; height: 36px; flex-shrink: 0;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
}
.notif-title  { font-size: 0.875rem; font-weight: 600; color: var(--color-ink); margin-bottom: 2px; }
.notif-msg    { font-size: 0.8125rem; color: var(--color-ink-soft); line-height: 1.5; }
.notif-time   { font-size: 0.73rem; color: var(--color-ink-muted); margin-top: 4px; }
.notif-dot    {
    width: 7px; height: 7px; flex-shrink: 0;
    border-radius: 50%; background: var(--color-blue);
    margin-top: 6px;
    animation: notif-pulse 2s ease-in-out infinite;
}
@keyframes notif-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}
</style>
@endpush

@section('content')

<section class="org-page-hero">
    <div class="ak-container">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
            <div>
                <p style="font-size:11px; font-weight:600; color:rgba(255,255,255,0.45); text-transform:uppercase; letter-spacing:0.1em; margin-bottom:4px;">Kotak Masuk</p>
                <h1 class="org-page-hero-title">Notifikasi</h1>
            </div>
            @if($notifications->isNotEmpty() && $notifications->contains('is_read', false))
                <form action="{{ route('organizer.notifications') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="ak-btn ak-btn-ghost ak-btn-sm"
                            style="border-color:rgba(255,255,255,0.25); color:rgba(255,255,255,0.8); background:rgba(255,255,255,0.08);">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>
    </div>
</section>

<div class="ak-container" style="padding-top: 1.5rem; padding-bottom: 2.5rem;">

    @php
        $iconMap = [
            'event_approved'         => ['bg' => '#ECFDF5', 'stroke' => '#059669', 'icon' => 'check'],
            'event_rejected'         => ['bg' => '#FEF2F2', 'stroke' => '#dc2626', 'icon' => 'x'],
            'event_pending_review'   => ['bg' => '#FFFBEB', 'stroke' => '#d97706', 'icon' => 'clock'],
            'registration_confirmed' => ['bg' => '#EFF6FF', 'stroke' => '#2563EB', 'icon' => 'check'],
            'registration_rejected'  => ['bg' => '#FEF2F2', 'stroke' => '#dc2626', 'icon' => 'x'],
            'attendance_confirmed'   => ['bg' => '#EFF6FF', 'stroke' => '#2563EB', 'icon' => 'check'],
            'event_completed'        => ['bg' => '#EFF6FF', 'stroke' => '#1E3A8A', 'icon' => 'star'],
        ];
    @endphp

    <div style="display:flex; flex-direction:column; gap:8px;">
        @forelse($notifications as $notif)
            @php $meta = $iconMap[$notif->type] ?? ['bg' => '#F1F5F9', 'stroke' => '#64748b', 'icon' => 'bell']; @endphp
            <div class="notif-item {{ $notif->is_read ? 'notif-read' : '' }}">
                <div class="notif-icon" style="background: {{ $meta['bg'] }};">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                         stroke="{{ $meta['stroke'] }}" stroke-width="2.5" stroke-linecap="round">
                        @if($meta['icon'] === 'check')
                            <polyline points="20 6 9 17 4 12"/>
                        @elseif($meta['icon'] === 'x')
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        @elseif($meta['icon'] === 'clock')
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        @elseif($meta['icon'] === 'star')
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        @else
                            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
                        @endif
                    </svg>
                </div>
                <div style="flex:1; min-width:0;">
                    <p class="notif-title">{{ $notif->title }}</p>
                    <p class="notif-msg">{{ $notif->message }}</p>
                    <p class="notif-time">{{ $notif->created_at->diffForHumans() }}</p>
                </div>
                @if(!$notif->is_read)
                    <div class="notif-dot"></div>
                @endif
            </div>
        @empty
            <div class="ak-card-flat">
                <div class="ak-empty-state">
                    <div class="ak-empty-state__icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
                        </svg>
                    </div>
                    <h3>Belum ada notifikasi</h3>
                    <p>Notifikasi akan muncul di sini ketika ada aktivitas pada event kamu.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="ak-pagination" style="margin-top: 1.5rem; justify-content: center;">
            {{ $notifications->links() }}
        </div>
    @endif

</div>

@endsection
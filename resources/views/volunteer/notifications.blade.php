@extends('layouts.volunteer')
@section('title', 'Notifikasi — AksiKita')

@push('styles')
<style>
.notif-wrap { 
    max-width: 900px;
    margin: 0 auto; 
    padding: 2rem 1.5rem; 
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.notif-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 32px; 
    flex-wrap: wrap;
}
.notif-header__left h1 {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: -0.025em;
    color: var(--color-text-primary);
    line-height: 1.2;
}
.notif-header__left p {
    font-size: 0.875rem;
    color: var(--color-text-muted);
    margin-top: 4px;
}
.notif-read-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--color-brand-600);
    background: var(--color-brand-50);
    border: 1.5px solid var(--color-brand-100, #DBEAFE);
    padding: 8px 16px;
    border-radius: 9999px;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.15s, border-color 0.15s;
}
.notif-read-all-btn:hover {
    background: var(--color-brand-100, #DBEAFE);
    border-color: var(--color-brand-300);
}

.notif-item {
    background: var(--color-canvas);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-xl);
    padding: 16px 18px;
    margin-bottom: 8px;
    display: flex;
    gap: 14px;
    align-items: flex-start;
    transition: box-shadow 0.15s, background 0.15s;
    position: relative;
}
.notif-item--unread {
    background: var(--color-brand-50);
    border-color: var(--color-brand-100, #DBEAFE);
}
.notif-item--unread:hover {
    background: #EFF6FF;
    box-shadow: var(--shadow-sm);
}
.notif-item--read:hover {
    box-shadow: var(--shadow-sm);
}
.notif-item--read {
    opacity: 0.75;
}

.notif-item__icon {
    width: 40px; height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.notif-item__body { flex: 1; min-width: 0; }

.notif-item__title {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--color-text-primary);
    margin-bottom: 4px;
    line-height: 1.4;
}
.notif-item--read .notif-item__title {
    font-weight: 600;
    color: var(--color-text-secondary);
}

.notif-item__message {
    font-size: 0.8375rem;
    color: var(--color-text-secondary);
    line-height: 1.6;
    margin-bottom: 6px;
}

.notif-item__time {
    font-size: 0.75rem;
    color: var(--color-text-muted);
    display: flex;
    align-items: center;
    gap: 4px;
}

.notif-item__dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--color-brand-600);
    flex-shrink: 0;
    margin-top: 6px;
    animation: notif-pulse 2s ease-in-out infinite;
}
@keyframes notif-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

.notif-empty {
    text-align: center;
    padding: 110px 24px;
    background: var(--color-canvas);
    border: 1px solid var(--color-border);
    border-radius: 28px;
}
.notif-empty__icon {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px;
}
.notif-empty p {
    font-size: 0.875rem;
    color: var(--color-text-muted);
    line-height: 1.6;
}

@media (max-width: 480px) {
    .notif-header { flex-direction: column; align-items: flex-start; }
    .notif-item__icon { width: 34px; height: 34px; border-radius: 9px; }
    .notif-empty { padding: 72px 20px; }
}
</style>
@endpush

@section('content')
<div class="notif-wrap">
    <div class="notif-header">
        <div class="notif-header__left">
            <h1>Notifikasi</h1>
            <p>Update terbaru tentang pendaftaran dan kegiatanmu.</p>
        </div>
        @if($notifications->count() > 0)
            <form action="{{ route('volunteer.notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="notif-read-all-btn">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    Tandai semua dibaca
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-5" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @php
        // Same visual language as the organizer notification page:
        // a soft background color + a stroke-based SVG icon, no emoji.
        $iconMap = [
            'registration_confirmed' => ['bg' => '#ECFDF5', 'stroke' => '#059669', 'icon' => 'check'],
            'registration_rejected'  => ['bg' => '#FEF2F2', 'stroke' => '#dc2626', 'icon' => 'x'],
            'event_approved'         => ['bg' => '#ECFDF5', 'stroke' => '#059669', 'icon' => 'check'],
            'event_rejected'         => ['bg' => '#FEF2F2', 'stroke' => '#dc2626', 'icon' => 'x'],
            'event_completed'        => ['bg' => '#EFF6FF', 'stroke' => '#1E3A8A', 'icon' => 'flag'],
            'event_cancelled'        => ['bg' => '#FEF2F2', 'stroke' => '#dc2626', 'icon' => 'x'],
            'org_verified'           => ['bg' => '#F0FDF4', 'stroke' => '#16a34a', 'icon' => 'building'],
            'org_rejected'           => ['bg' => '#FEF2F2', 'stroke' => '#dc2626', 'icon' => 'building'],
            'attendance_recorded'    => ['bg' => '#EFF6FF', 'stroke' => '#2563EB', 'icon' => 'clipboard'],
        ];
    @endphp

    @forelse($notifications as $notif)
    @php
        $meta = $iconMap[$notif->type] ?? ['bg' => '#F1F5F9', 'stroke' => '#64748b', 'icon' => 'bell'];
        $isUnread = !$notif->is_read;
    @endphp

    <div class="notif-item {{ $isUnread ? 'notif-item--unread' : 'notif-item--read' }}">

        <div class="notif-item__icon" style="background: {{ $meta['bg'] }};">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                 stroke="{{ $meta['stroke'] }}" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round">
                @if($meta['icon'] === 'check')
                    <polyline points="20 6 9 17 4 12"/>
                @elseif($meta['icon'] === 'x')
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                @elseif($meta['icon'] === 'clock')
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                @elseif($meta['icon'] === 'flag')
                    <path d="M4 21V4"/><path d="M4 4h14l-2.5 4L18 12H4"/>
                @elseif($meta['icon'] === 'building')
                    <rect x="4" y="3" width="16" height="18" rx="1"/>
                    <path d="M9 21v-4h6v4"/>
                    <path d="M9 8h1M14 8h1M9 12h1M14 12h1"/>
                @elseif($meta['icon'] === 'clipboard')
                    <rect x="6" y="4" width="12" height="17" rx="2"/>
                    <path d="M9 4h6v2H9z"/>
                    <path d="M9 11h6M9 15h6"/>
                @else
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 01-3.46 0"/>
                @endif
            </svg>
        </div>

        <div class="notif-item__body">
            <p class="notif-item__title">{{ $notif->title }}</p>
            <p class="notif-item__message">{{ $notif->message }}</p>
            <p class="notif-item__time">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $notif->created_at->diffForHumans() }}
            </p>
        </div>
        @if($isUnread)
            <div class="notif-item__dot"></div>
        @endif

    </div>
    @empty

    <div class="notif-empty">
        <div class="notif-empty__icon">
            <svg width="40" height="40" fill="none" viewBox="0 0 24 24"
                 stroke="#1E293B" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8a6 6 0 10-12 0c0 3.5-1 5.5-1.5 6.5A1 1 0 005.5 16h13a1 1 0 00.9-1.5C18.9 13.5 18 11.5 18 8z"/>
                <path d="M9.5 19a2.5 2.5 0 005 0"/>
            </svg>
        </div>
        <p>Tidak ada notifikasi, notifikasi<br>terbaru akan ditampilkan di sini</p>
    </div>

    @endforelse
    @if($notifications->hasPages())
        <div style="margin-top:24px; display:flex; justify-content:center;">
            {{ $notifications->links() }}
        </div>
    @endif

</div>
@endsection
@extends('layouts.admin')

@section('title', 'Notifikasi — AksiKita Admin')

@push('styles')
<style>
.notif-wrap { max-width: 720px; margin: 0 auto; }

.notif-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.notif-header__left h1 {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: -0.025em;
    color: var(--color-ink);
    line-height: 1.2;
    margin: 0 0 4px;
}
.notif-header__left p {
    font-size: 0.875rem;
    color: var(--color-ink-muted);
    margin: 0;
}
.notif-read-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--color-blue);
    background: var(--color-blue-ghost);
    border: 1.5px solid var(--color-blue-pale);
    padding: 8px 16px;
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: background 0.15s, border-color 0.15s;
    font-family: var(--font-body);
}
.notif-read-all-btn:hover {
    background: #DBEAFE;
    border-color: var(--color-blue);
}

.notif-item {
    background: var(--color-surface);
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
    background: #EFF6FF;
    border-color: #BFDBFE;
}
.notif-item--unread:hover {
    background: #DBEAFE;
    box-shadow: var(--shadow-sm);
}
.notif-item--read:hover {
    box-shadow: var(--shadow-sm);
}

.notif-item__icon {
    width: 42px;
    height: 42px;
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
    color: var(--color-ink);
    margin: 0 0 4px;
    line-height: 1.4;
}
.notif-item--read .notif-item__title {
    font-weight: 600;
    color: var(--color-ink-soft);
}

.notif-item__message {
    font-size: 0.84rem;
    color: var(--color-ink-soft);
    line-height: 1.6;
    margin: 0 0 6px;
}

.notif-item__meta {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.notif-item__time {
    font-size: 0.75rem;
    color: var(--color-ink-muted);
    display: flex;
    align-items: center;
    gap: 4px;
}

.notif-item__dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--color-blue);
    flex-shrink: 0;
    margin-top: 5px;
}

.notif-mark-btn {
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--color-blue);
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    font-family: var(--font-body);
    text-decoration: underline;
    text-underline-offset: 2px;
}
.notif-mark-btn:hover { opacity: 0.75; }

.notif-empty {
    text-align: center;
    padding: 72px 24px;
    background: var(--color-surface);
    border: 1px dashed var(--color-border);
    border-radius: var(--radius-xl);
}
.notif-empty__icon {
    width: 64px;
    height: 64px;
    border-radius: var(--radius-xl);
    background: #EFF6FF;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px;
}
.notif-empty h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-ink);
    margin: 0 0 6px;
}
.notif-empty p {
    font-size: 0.875rem;
    color: var(--color-ink-muted);
    margin: 0;
}

.notif-unread-badge {
    display: inline-flex;
    align-items: center;
    padding: 2px 9px;
    background: var(--color-blue);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    border-radius: var(--radius-full);
    line-height: 1.6;
}

@media (max-width: 480px) {
    .notif-header { flex-direction: column; align-items: flex-start; }
    .notif-item__icon { width: 36px; height: 36px; font-size: 1rem; border-radius: 9px; }
}
</style>
@endpush

@section('content')

@php
    $totalUnread = $notifications->where('is_read', false)->count();
@endphp

<div class="notif-wrap">

    {{-- Header --}}
    <div class="notif-header">
        <div class="notif-header__left">
            <h1>
                Notifikasi
                @if($totalUnread > 0)
                    <span class="notif-unread-badge" style="font-size:0.75rem; vertical-align:middle; margin-left:6px;">
                        {{ $totalUnread }} baru
                    </span>
                @endif
            </h1>
            <p>Notifikasi sistem dan aktivitas platform AksiKita.</p>
        </div>
        @if($notifications->count() > 0 && $totalUnread > 0)
            <form action="{{ route('admin.notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="notif-read-all-btn">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tandai semua dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="ak-alert ak-alert-success" style="margin-bottom:16px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notification list --}}
    @forelse($notifications as $notif)
    @php
        $iconMap = [
            'event_reviewed'         => ['color' => '#3B82F6', 'bg' => '#EFF6FF',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>'],
            'organization_verified'  => ['color' => '#16A34A', 'bg' => '#ECFDF5',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            'event_approved'         => ['color' => '#16A34A', 'bg' => '#ECFDF5',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            'event_rejected'         => ['color' => '#DC2626', 'bg' => '#FEF2F2',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            'org_rejected'           => ['color' => '#DC2626', 'bg' => '#FEF2F2',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
            'registration_confirmed' => ['color' => '#16A34A', 'bg' => '#ECFDF5',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
            'registration_rejected'  => ['color' => '#DC2626', 'bg' => '#FEF2F2',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
            'system'                 => ['color' => '#7C3AED', 'bg' => '#F5F3FF',
                'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>'],
        ];
        $icon     = $iconMap[$notif->type] ?? ['color' => '#6B7280', 'bg' => '#F3F4F6',
            'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'];
        $isUnread = !$notif->is_read;
    @endphp

    <div class="notif-item {{ $isUnread ? 'notif-item--unread' : 'notif-item--read' }}">

        <div class="notif-item__icon" style="background:{{ $icon['bg'] }};">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                 stroke="{{ $icon['color'] }}" stroke-width="2">
                {!! $icon['svg'] !!}
            </svg>
        </div>

        <div class="notif-item__body">
            <p class="notif-item__title">{{ $notif->title }}</p>
            <p class="notif-item__message">{{ $notif->message }}</p>
            <div class="notif-item__meta">
                <span class="notif-item__time">
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $notif->created_at->diffForHumans() }}
                </span>
                @if($isUnread)
                    <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="notif-mark-btn">Tandai dibaca</button>
                    </form>
                @endif
            </div>
        </div>

        @if($isUnread)
            <div class="notif-item__dot"></div>
        @endif

    </div>
    @empty

    <div class="notif-empty">
        <div class="notif-empty__icon">
            <svg width="28" height="28" fill="none" viewBox="0 0 24 24"
                 stroke="#3B82F6" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <h3>Belum ada notifikasi</h3>
        <p>Notifikasi sistem akan muncul di sini.</p>
    </div>

    @endforelse

    {{-- Pagination --}}
    @if($notifications->hasPages())
        <div style="margin-top:24px; display:flex; justify-content:center;">
            {{ $notifications->links() }}
        </div>
    @endif

</div>
@endsection
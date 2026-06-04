@extends('layouts.volunteer')
@section('title', 'Notifikasi — AksiKita')

@push('styles')
<style>
.notif-wrap { max-width: 680px; margin: 0 auto; }

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

.notif-item__icon {
    width: 40px; height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.125rem;
    line-height: 1;
}

.notif-icon--confirmed    { background: #ECFDF5; }
.notif-icon--rejected     { background: #FEF2F2; }
.notif-icon--approved     { background: #ECFDF5; }
.notif-icon--event-done   { background: var(--color-brand-50); }
.notif-icon--org          { background: #F0FDF4; }
.notif-icon--default      { background: var(--color-surface); }

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
}

.notif-empty {
    text-align: center;
    padding: 72px 24px;
    background: var(--color-canvas);
    border: 1px dashed var(--color-border);
    border-radius: var(--radius-xl);
}
.notif-empty__icon {
    width: 64px; height: 64px;
    border-radius: var(--radius-xl);
    background: var(--color-brand-50);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
}
.notif-empty h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-text-primary);
    margin-bottom: 6px;
}
.notif-empty p {
    font-size: 0.875rem;
    color: var(--color-text-muted);
}

@media (max-width: 480px) {
    .notif-header { flex-direction: column; align-items: flex-start; }
    .notif-item__icon { width: 34px; height: 34px; font-size: 1rem; border-radius: 9px; }
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

    @forelse($notifications as $notif)
    @php
        $iconMap = [
            'registration_confirmed' => ['emoji' => '🎉', 'class' => 'notif-icon--confirmed'],
            'registration_rejected'  => ['emoji' => '😔', 'class' => 'notif-icon--rejected'],
            'event_approved'         => ['emoji' => '✅', 'class' => 'notif-icon--approved'],
            'event_rejected'         => ['emoji' => '❌', 'class' => 'notif-icon--rejected'],
            'event_completed'        => ['emoji' => '🏁', 'class' => 'notif-icon--event-done'],
            'event_cancelled'        => ['emoji' => '🚫', 'class' => 'notif-icon--rejected'],
            'org_verified'           => ['emoji' => '🏢', 'class' => 'notif-icon--org'],
            'org_rejected'           => ['emoji' => '🏢', 'class' => 'notif-icon--rejected'],
            'attendance_recorded'    => ['emoji' => '📋', 'class' => 'notif-icon--confirmed'],
        ];
        $icon = $iconMap[$notif->type] ?? ['emoji' => '🔔', 'class' => 'notif-icon--default'];
        $isUnread = !$notif->is_read;
    @endphp

    <div class="notif-item {{ $isUnread ? 'notif-item--unread' : 'notif-item--read' }}">

        <div class="notif-item__icon {{ $icon['class'] }}">
            {{ $icon['emoji'] }}
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
            <svg width="28" height="28" fill="none" viewBox="0 0 24 24"
                 stroke="var(--color-brand-400)" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <h3>Belum ada notifikasi</h3>
        <p>Notifikasi akan muncul di sini setelah kamu mendaftar ke suatu kegiatan.</p>
    </div>

    @endforelse
    @if($notifications->hasPages())
        <div style="margin-top:24px; display:flex; justify-content:center;">
            {{ $notifications->links() }}
        </div>
    @endif

</div>
@endsection

@extends('layouts.volunteer')
@section('title', 'Notifikasi — AksiKita')

@push('styles')
<style>
.notif-page {
    background: #F4F7FF;
    padding: 2rem 0 4rem;
    min-height: 100vh;
}
.notif-wrap {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 1.5rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.notif-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}
.notif-heading {
    font-size: 1.2rem;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 3px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.notif-unread-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #1E3A8A;
    color: #BFDBFE;
    font-size: 11px;
    font-weight: 700;
    border-radius: 999px;
    padding: 2px 8px;
}
.notif-subhead { font-size: 0.8rem; color: #64748B; margin: 0; }
.btn-mark-all {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    border-radius: 10px;
    border: 1.5px solid #BFDBFE;
    background: #fff;
    color: #1E3A8A;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s;
}
.btn-mark-all:hover { background: #EFF6FF; border-color: #93C5FD; }

.notif-group-label {
    font-size: 11px;
    font-weight: 700;
    color: #94A3B8;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin: 24px 0 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.notif-group-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #E2E8F0;
}
.notif-group-label:first-child { margin-top: 0; }

.notif-list { display: flex; flex-direction: column; gap: 8px; }

.notif-item {
    background: #fff;
    border: 1.5px solid #E2E8F0;
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    transition: border-color .15s, transform .15s;
}
.notif-item:hover { border-color: #93C5FD; transform: translateX(3px); }
.notif-item.is-unread {
    background: #F8FBFF;
    border-color: #BFDBFE;
    border-left: 3px solid #3B82F6;
}
.notif-item.is-unread:hover { border-left-color: #1E3A8A; }
.notif-item.is-read { opacity: 0.72; }

.notif-icon {
    width: 38px; height: 38px;
    flex-shrink: 0;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-top: 1px;
}
.notif-body { flex: 1; min-width: 0; }
.notif-title {
    font-size: 13.5px; font-weight: 700;
    color: #0F172A; margin: 0 0 3px; line-height: 1.3;
}
.notif-item.is-read .notif-title { color: #475569; font-weight: 600; }
.notif-msg { font-size: 12.5px; color: #475569; line-height: 1.5; margin: 0 0 5px; }
.notif-item.is-read .notif-msg { color: #94A3B8; }
.notif-time { font-size: 11px; color: #94A3B8; display: flex; align-items: center; gap: 5px; }
.notif-time svg { color: #CBD5E1; }

.notif-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #3B82F6;
    flex-shrink: 0;
    margin-top: 5px;
    animation: pulse-dot 2s ease-in-out infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(0.8); }
}

.notif-empty {
    text-align: center;
    padding: 72px 20px;
    background: #fff;
    border: 1.5px solid #E2E8F0;
    border-radius: 16px;
}
.notif-empty-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: #EFF6FF;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    color: #60A5FA;
}
.notif-empty h3 { font-size: 15px; font-weight: 700; color: #0F172A; margin-bottom: 6px; }
.notif-empty p  { font-size: 13px; color: #94A3B8; max-width: 300px; margin: 0 auto; line-height: 1.6; }

.notif-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 28px;
}
.pag-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 10px;
    border: 1.5px solid #E2E8F0;
    background: #fff;
    color: #1E3A8A;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all .15s;
    line-height: 1;
}
.pag-btn:hover { background: #EFF6FF; border-color: #93C5FD; color: #1E3A8A; }
.pag-btn.disabled { opacity: 0.35; pointer-events: none; cursor: default; }
.pag-numbers { display: flex; gap: 4px; }
.pag-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px; height: 36px;
    border-radius: 9px;
    border: 1.5px solid #E2E8F0;
    background: #fff;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all .15s;
}
.pag-num:hover { background: #EFF6FF; border-color: #93C5FD; color: #1E3A8A; }
.pag-num.active { background: #1E3A8A; border-color: #1E3A8A; color: #fff; }
.pag-num.dots { border-color: transparent; background: transparent; color: #94A3B8; pointer-events: none; }
.pag-info { font-size: 12px; color: #94A3B8; text-align: center; margin-top: 10px; }

@media (max-width: 480px) {
    .notif-topbar { flex-direction: column; align-items: flex-start; }
    .pag-numbers { display: none; }
}
</style>
@endpush

@section('content')
@php
use Carbon\Carbon;

$iconMap = [
    'registration_confirmed' => ['bg' => '#DBEAFE', 'color' => '#1E3A8A', 'icon' => 'check'],
    'registration_rejected'  => ['bg' => '#F1F5F9', 'color' => '#64748B', 'icon' => 'x'],
    'event_approved'         => ['bg' => '#EFF6FF', 'color' => '#1D4ED8', 'icon' => 'check'],
    'event_rejected'         => ['bg' => '#F1F5F9', 'color' => '#475569', 'icon' => 'x'],
    'event_completed'        => ['bg' => '#EFF6FF', 'color' => '#3B82F6', 'icon' => 'flag'],
    'event_cancelled'        => ['bg' => '#F1F5F9', 'color' => '#64748B', 'icon' => 'x'],
    'org_verified'           => ['bg' => '#DBEAFE', 'color' => '#1E3A8A', 'icon' => 'building'],
    'org_rejected'           => ['bg' => '#F1F5F9', 'color' => '#475569', 'icon' => 'building'],
    'attendance_recorded'    => ['bg' => '#EFF6FF', 'color' => '#3B82F6', 'icon' => 'clipboard'],
    'new_registration'       => ['bg' => '#EFF6FF', 'color' => '#3B82F6', 'icon' => 'user-plus'],
];

$grouped = $notifications->groupBy(function($n) {
    $date = Carbon::parse($n->created_at);
    if ($date->isToday())       return 'Hari ini';
    if ($date->isYesterday())   return 'Kemarin';
    if ($date->isCurrentWeek()) return 'Minggu ini';
    return $date->translatedFormat('F Y');
});

$unreadCount = $notifications->where('is_read', false)->count();
$lastPage    = $notifications->lastPage();
$currentPage = $notifications->currentPage();
$from        = $notifications->firstItem();
$to          = $notifications->lastItem();
$total       = $notifications->total();
@endphp

<div class="notif-page">
    <div class="notif-wrap">
        <div class="notif-topbar">
            <div>
                <h1 class="notif-heading">
                    Notifikasi
                    @if($unreadCount > 0)
                        <span class="notif-unread-count">{{ $unreadCount }} baru</span>
                    @endif
                </h1>
                <p class="notif-subhead">Update terbaru tentang pendaftaran dan kegiatanmu</p>
            </div>
            @if($notifications->isNotEmpty() && $unreadCount > 0)
                <form action="{{ route('volunteer.notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-mark-all">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div style="padding:12px 18px;border-radius:10px;font-size:13px;font-weight:500;margin-bottom:20px;background:#DBEAFE;color:#1E3A8A;border:1px solid #BFDBFE;">
                {{ session('success') }}
            </div>
        @endif

        @if($notifications->isEmpty())
            <div class="notif-empty">
                <div class="notif-empty-icon">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                </div>
                <h3>Belum ada notifikasi</h3>
                <p>Notifikasi terbaru tentang kegiatan dan pendaftaranmu akan muncul di sini.</p>
            </div>

        @else
            @foreach($grouped as $groupLabel => $items)
                <div class="notif-group-label">{{ $groupLabel }}</div>
                <div class="notif-list">
                    @foreach($items as $notif)
                        @php
                            $meta     = $iconMap[$notif->type] ?? ['bg' => '#F1F5F9', 'color' => '#64748B', 'icon' => 'bell'];
                            $isUnread = !$notif->is_read;
                        @endphp
                        <div class="notif-item {{ $isUnread ? 'is-unread' : 'is-read' }}">

                            <div class="notif-icon" style="background:{{ $meta['bg'] }};">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                                     stroke="{{ $meta['color'] }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    @if($meta['icon'] === 'check')
                                        <polyline points="20 6 9 17 4 12"/>
                                    @elseif($meta['icon'] === 'x')
                                        <line x1="18" y1="6" x2="6" y2="18"/>
                                        <line x1="6" y1="6" x2="18" y2="18"/>
                                    @elseif($meta['icon'] === 'clock')
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    @elseif($meta['icon'] === 'flag')
                                        <path d="M4 21V4"/>
                                        <path d="M4 4h14l-2.5 4L18 12H4"/>
                                    @elseif($meta['icon'] === 'building')
                                        <rect x="4" y="3" width="16" height="18" rx="1"/>
                                        <path d="M9 21v-4h6v4"/>
                                        <path d="M9 8h1M14 8h1M9 12h1M14 12h1"/>
                                    @elseif($meta['icon'] === 'clipboard')
                                        <rect x="6" y="4" width="12" height="17" rx="2"/>
                                        <path d="M9 4h6v2H9z"/>
                                        <path d="M9 11h6M9 15h6"/>
                                    @elseif($meta['icon'] === 'user-plus')
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="8.5" cy="7" r="4"/>
                                        <line x1="20" y1="8" x2="20" y2="14"/>
                                        <line x1="23" y1="11" x2="17" y2="11"/>
                                    @else
                                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                        <path d="M13.73 21a2 2 0 01-3.46 0"/>
                                    @endif
                                </svg>
                            </div>

                            <div class="notif-body">
                                <p class="notif-title">{{ $notif->title }}</p>
                                <p class="notif-msg">{{ $notif->message }}</p>
                                <p class="notif-time">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ $notif->created_at->diffForHumans() }}
                                </p>
                            </div>

                            @if($isUnread)
                                <div class="notif-dot"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
            @if($lastPage > 1)
                <div class="notif-pagination">

                    @if($notifications->onFirstPage())
                        <span class="pag-btn disabled">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <polyline points="15 18 9 12 15 6"/>
                            </svg>
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $notifications->previousPageUrl() }}" class="pag-btn">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <polyline points="15 18 9 12 15 6"/>
                            </svg>
                            Sebelumnya
                        </a>
                    @endif

                    <div class="pag-numbers">
                        @php
                            $window = 2;
                            $shown  = collect(range(1, $lastPage))->filter(fn($p) =>
                                $p === 1 || $p === $lastPage || abs($p - $currentPage) <= $window
                            );
                            $prev = null;
                        @endphp
                        @foreach($shown as $page)
                            @if($prev !== null && $page - $prev > 1)
                                <span class="pag-num dots">...</span>
                            @endif
                            @if($page === $currentPage)
                                <span class="pag-num active">{{ $page }}</span>
                            @else
                                <a href="{{ $notifications->url($page) }}" class="pag-num">{{ $page }}</a>
                            @endif
                            @php $prev = $page; @endphp
                        @endforeach
                    </div>

                    @if($notifications->hasMorePages())
                        <a href="{{ $notifications->nextPageUrl() }}" class="pag-btn">
                            Selanjutnya
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </a>
                    @else
                        <span class="pag-btn disabled">
                            Selanjutnya
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </span>
                    @endif

                </div>

                <p class="pag-info">
                    Menampilkan {{ $from }}–{{ $to }} dari {{ $total }} notifikasi
                </p>
            @endif

        @endif

    </div>
</div>
@endsection
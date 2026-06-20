@extends('layouts.organizer')
@section('title', 'Pesan Relawan')

@push('styles')
<style>
:root {
    --navy:       #1E3A8A;
    --blue:       #3B82F6;
    --blue-light: #93C5FD;
    --blue-ghost: #BFDBFE;
    --blue-bg:    #EFF6FF;
    --surface:    #ffffff;
    --page-bg:    #F0F4FF;
    --ink:        #1e293b;
    --ink-soft:   #475569;
    --ink-muted:  #94a3b8;
    --border:     #e2e8f0;
    --radius-lg:  14px;
    --radius-md:  10px;
    --teal-from:  #0E7B6C;
    --teal-to:    #1DB8A0;
}

.chat-layout {
    display: flex;
    height: calc(100vh - 72px);
    overflow: hidden;
    background: var(--page-bg);
}

.sidebar {
    width: 320px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    background: var(--surface);
    border-right: 1px solid var(--border);
}

.sidebar-header {
    padding: 20px 16px 12px;
    border-bottom: 1px solid var(--border);
}

.sidebar-title {
    font-size: 17px;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 10px;
}

.search-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--page-bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    padding: 8px 12px;
    transition: border-color 0.15s;
}

.search-bar:focus-within { border-color: var(--blue-light); }

.search-bar input {
    flex: 1;
    border: none;
    background: none;
    outline: none;
    font-family: inherit;
    font-size: 13.5px;
    color: var(--ink);
}

.search-bar input::placeholder { color: var(--ink-muted); }

.tab-bar {
    display: flex;
    gap: 4px;
    padding: 10px 16px 8px;
}

.tab {
    font-size: 12px;
    font-weight: 500;
    color: var(--ink-muted);
    padding: 5px 12px;
    border-radius: 8px;
    cursor: pointer;
    border: none;
    background: none;
    font-family: inherit;
}

.tab.active {
    background: var(--blue-bg);
    color: var(--blue);
    font-weight: 600;
}

.rooms {
    flex: 1;
    overflow-y: auto;
    padding: 4px 0 8px;
}

.rooms::-webkit-scrollbar { width: 4px; }
.rooms::-webkit-scrollbar-track { background: transparent; }
.rooms::-webkit-scrollbar-thumb { background: var(--blue-ghost); border-radius: 4px; }

.room-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 16px;
    cursor: pointer;
    transition: background 0.12s;
    text-decoration: none;
    position: relative;
}

.room-item:hover { background: var(--blue-bg); }

.room-item.active { background: var(--blue-bg); }

.room-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 8px;
    bottom: 8px;
    width: 3px;
    border-radius: 0 3px 3px 0;
    background: var(--blue);
}

.avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    color: #fff;
    flex-shrink: 0;
    position: relative;
    background: linear-gradient(135deg, var(--teal-from) 0%, var(--teal-to) 100%);
    overflow: hidden;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.unread-dot {
    position: absolute;
    bottom: 1px;
    right: 1px;
    width: 11px;
    height: 11px;
    border-radius: 50%;
    background: var(--blue);
    border: 2px solid var(--surface);
}

.room-info { flex: 1; min-width: 0; }

.room-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2px;
    gap: 8px;
}

.room-name {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--navy);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.room-name.bold { font-weight: 700; }

.room-time {
    font-size: 11px;
    color: var(--ink-muted);
    white-space: nowrap;
    flex-shrink: 0;
}

.room-time.blue { color: var(--blue); font-weight: 600; }

.room-event {
    font-size: 11.5px;
    color: var(--ink-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}

.room-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 6px;
}

.room-preview {
    font-size: 12px;
    color: var(--ink-soft);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.room-preview.unread { color: var(--ink); font-weight: 500; }
.room-preview.empty { color: var(--ink-muted); font-style: italic; }

.unread-badge {
    background: var(--blue);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    border-radius: 99px;
    padding: 2px 7px;
    flex-shrink: 0;
    min-width: 20px;
    text-align: center;
}

.chat-area {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--page-bg);
}

.empty-chat {
    text-align: center;
    color: var(--ink-muted);
}

.empty-chat-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--blue-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
}

.empty-chat p { font-size: 14px; line-height: 1.6; }

.empty-rooms {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1.5rem;
    text-align: center;
    color: var(--ink-muted);
}

.empty-rooms-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--blue-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
}

.empty-rooms p { font-size: 13.5px; line-height: 1.65; }
</style>
@endpush

@section('content')
<div class="chat-layout">

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">Pesan Relawan</div>
            <div class="search-bar">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" placeholder="Cari relawan...">
            </div>
        </div>

        <div class="tab-bar">
            <span class="tab active">Semua</span>
            <span class="tab">Belum dibaca</span>
        </div>

        @if($rooms->isEmpty())
            <div class="empty-rooms">
                <div class="empty-rooms-icon">
                    <svg width="26" height="26" fill="none" viewBox="0 0 24 24"
                         stroke="#3B82F6" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9
                                 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512
                                 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <p>Belum ada chat aktif.<br>Chat terbuka otomatis saat kamu<br>mengkonfirmasi pendaftaran relawan.</p>
            </div>
        @else
            <div class="rooms">
                @foreach($rooms as $room)
                    @php
                        $userId     = (int) session('user_id');
                        $latest     = $room->latestMessage;
                        $unread     = $room->unreadCountFor($userId);
                        $hasUnread  = $unread > 0;

                        $volProfile = $room->volunteer->volunteerProfile;
                        $volName    = $room->volunteer->name;
                        $volAvatar  = $volProfile->avatar ?? null;
                        $volInitial = strtoupper(substr($volName, 0, 1));

                        $timestamp = null;
                        if ($latest) {
                            $msgTime   = $latest->created_at;
                            $timestamp = $msgTime->isToday()
                                ? $msgTime->format('H:i')
                                : ($msgTime->isYesterday() ? 'Kemarin' : $msgTime->format('d M'));
                        }

                        if ($latest) {
                            $isMyMsg     = $latest->sender_id === $userId;
                            $previewText = ($isMyMsg ? 'Kamu: ' : '') . Str::limit($latest->message, 50);
                        } else {
                            $previewText = null;
                        }
                    @endphp

                    <a href="{{ route('organizer.chat.show', $room) }}" class="room-item">
                        <div class="avatar">
                            @if($volAvatar)
                                <img src="{{ Storage::url($volAvatar) }}" alt="{{ $volName }}">
                            @else
                                {{ $volInitial }}
                            @endif
                            @if($hasUnread)
                                <span class="unread-dot"></span>
                            @endif
                        </div>

                        <div class="room-info">
                            <div class="room-top">
                                <div class="room-name {{ $hasUnread ? 'bold' : '' }}">{{ $volName }}</div>
                                @if($timestamp)
                                    <div class="room-time {{ $hasUnread ? 'blue' : '' }}">{{ $timestamp }}</div>
                                @endif
                            </div>
                            <div class="room-event">{{ $room->event->title }}</div>
                            <div class="room-bottom">
                                @if($previewText)
                                    <div class="room-preview {{ $hasUnread ? 'unread' : '' }}">{{ $previewText }}</div>
                                @else
                                    <div class="room-preview empty">Belum ada pesan</div>
                                @endif
                                @if($hasUnread)
                                    <span class="unread-badge">{{ $unread > 99 ? '99+' : $unread }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="chat-area">
        <div class="empty-chat">
            <div class="empty-chat-icon">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24"
                     stroke="#3B82F6" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9
                             8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512
                             15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <p>Pilih percakapan untuk mulai chat</p>
        </div>
    </div>

</div>
@endsection
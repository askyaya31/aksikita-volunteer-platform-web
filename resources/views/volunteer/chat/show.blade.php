@extends('layouts.volunteer')
@section('title', 'Chat — ' . $room->event->title)

@push('styles')
<style>
:root {
    --navy:       #1E3A8A;
    --blue:       #3B82F6;
    --blue-mid:   #60A5FA;
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

.room-item.active {
    background: var(--blue-bg);
}

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
    background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);
    overflow: hidden;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
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

.chat-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
    background: var(--surface);
}

.chat-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 12px;
    background: var(--surface);
    flex-shrink: 0;
}

.chat-header-info { flex: 1; min-width: 0; }

.chat-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--navy);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chat-sub {
    font-size: 12px;
    color: var(--ink-muted);
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 1px;
}

.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #22c55e;
    flex-shrink: 0;
}

.header-btn {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
    background: var(--surface);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--ink-soft);
    transition: background 0.12s, color 0.12s, border-color 0.12s;
    text-decoration: none;
    flex-shrink: 0;
}

.header-btn:hover {
    background: var(--blue-bg);
    color: var(--blue);
    border-color: var(--blue-ghost);
}

.messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px 20px 12px;
    display: flex;
    flex-direction: column;
    gap: 2px;
    background: var(--page-bg);
}

.messages::-webkit-scrollbar { width: 4px; }
.messages::-webkit-scrollbar-track { background: transparent; }
.messages::-webkit-scrollbar-thumb { background: var(--blue-ghost); border-radius: 4px; }

.date-sep {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 10px 0 8px;
}

.date-sep::before,
.date-sep::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

.date-sep span {
    font-size: 11px;
    color: var(--ink-muted);
    white-space: nowrap;
    padding: 0 4px;
}

.msg-group {
    display: flex;
    flex-direction: column;
    gap: 3px;
    margin-bottom: 4px;
}

.msg-group.me { align-items: flex-end; }
.msg-group.them { align-items: flex-start; }

.bubble {
    max-width: 68%;
    padding: 10px 14px;
    border-radius: 16px;
    font-size: 13.5px;
    line-height: 1.55;
    word-break: break-word;
}

.bubble.me {
    background: var(--navy);
    color: #fff;
    border-bottom-right-radius: 4px;
}

.bubble.them {
    background: var(--surface);
    color: var(--ink);
    border-bottom-left-radius: 4px;
    border: 1px solid var(--border);
}

.bubble-meta {
    font-size: 10.5px;
    color: var(--ink-muted);
    padding: 0 2px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.bubble-meta.me { justify-content: flex-end; }

.check-icon {
    width: 14px;
    height: 14px;
    color: var(--blue-light);
}

.input-bar {
    padding: 12px 16px;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 10px;
    align-items: flex-end;
    background: var(--surface);
    flex-shrink: 0;
}

.input-wrap {
    flex: 1;
    background: var(--page-bg);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    display: flex;
    align-items: flex-end;
    gap: 8px;
    padding: 0 10px;
    transition: border-color 0.15s;
}

.input-wrap:focus-within { border-color: var(--blue); }

.input-wrap svg {
    flex-shrink: 0;
    color: var(--ink-muted);
    margin-bottom: 10px;
    cursor: pointer;
    transition: color 0.12s;
}

.input-wrap svg:hover { color: var(--blue); }

#msgInput {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    font-family: inherit;
    font-size: 13.5px;
    color: var(--ink);
    resize: none;
    height: 42px;
    padding: 12px 0;
    line-height: 1.45;
    max-height: 120px;
    overflow-y: auto;
}

#msgInput::placeholder { color: var(--ink-muted); }

.send-btn {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: var(--blue);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: background 0.15s, transform 0.1s;
}

.send-btn:hover { background: var(--navy); }
.send-btn:active { transform: scale(0.92); }

.send-btn svg { color: #fff; }
</style>
@endpush

@section('content')

@php
    $orgProfile  = $room->organizer->organizationProfile;
    $orgName     = $orgProfile->organization_name ?? $room->organizer->name;
    $orgLogo     = $orgProfile->logo ?? null;
    $orgInitial  = strtoupper(substr($orgName, 0, 1));
    $currentUser = (int) session('user_id');
@endphp

<div class="chat-layout">

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">Pesan Saya</div>
            <div class="search-bar">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" placeholder="Cari percakapan...">
            </div>
        </div>

        <div class="tab-bar">
            <span class="tab active">Semua</span>
            <span class="tab">Belum dibaca</span>
        </div>

        <div class="rooms">
            @php
                $allRooms = \App\Models\ChatRoom::where('volunteer_id', session('user_id'))
                    ->with(['organizer.organizationProfile', 'latestMessage', 'event'])
                    ->latest('updated_at')
                    ->get();
            @endphp
            @foreach($allRooms as $r)
                @php
                    $rOrgProfile = $r->organizer->organizationProfile;
                    $rOrgName    = $rOrgProfile->organization_name ?? $r->organizer->name;
                    $rOrgLogo    = $rOrgProfile->logo ?? null;
                    $rOrgInitial = strtoupper(substr($rOrgName, 0, 1));
                    $rLatest     = $r->latestMessage;
                    $rUnread     = $r->unreadCountFor($currentUser);
                    $rHasUnread  = $rUnread > 0;

                    $rTimestamp = null;
                    if ($rLatest) {
                        $rMsgTime   = $rLatest->created_at;
                        $rTimestamp = $rMsgTime->isToday()
                            ? $rMsgTime->format('H:i')
                            : ($rMsgTime->isYesterday() ? 'Kemarin' : $rMsgTime->format('d M'));
                    }

                    $rIsMyMsg     = $rLatest && $rLatest->sender_id === $currentUser;
                    $rPreviewText = $rLatest
                        ? (($rIsMyMsg ? 'Kamu: ' : '') . Str::limit($rLatest->message, 45))
                        : null;
                @endphp

                <a href="{{ route('volunteer.chat.show', $r) }}"
                   class="room-item {{ $r->id === $room->id ? 'active' : '' }}">
                    <div class="avatar">
                        @if($rOrgLogo)
                            <img src="{{ Storage::url($rOrgLogo) }}" alt="{{ $rOrgName }}">
                        @else
                            {{ $rOrgInitial }}
                        @endif
                        @if($rHasUnread)
                            <span class="unread-dot"></span>
                        @endif
                    </div>

                    <div class="room-info">
                        <div class="room-top">
                            <div class="room-name {{ $rHasUnread ? 'bold' : '' }}">{{ $rOrgName }}</div>
                            @if($rTimestamp)
                                <div class="room-time {{ $rHasUnread ? 'blue' : '' }}">{{ $rTimestamp }}</div>
                            @endif
                        </div>
                        <div class="room-event">{{ $r->event->title }}</div>
                        <div class="room-bottom">
                            @if($rPreviewText)
                                <div class="room-preview {{ $rHasUnread ? 'unread' : '' }}">{{ $rPreviewText }}</div>
                            @else
                                <div class="room-preview empty">Belum ada pesan</div>
                            @endif
                            @if($rHasUnread)
                                <span class="unread-badge">{{ $rUnread > 99 ? '99+' : $rUnread }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="chat-panel">
        <div class="chat-header">
            <div class="avatar avatar-sm">
                @if($orgLogo)
                    <img src="{{ Storage::url($orgLogo) }}" alt="{{ $orgName }}">
                @else
                    {{ $orgInitial }}
                @endif
            </div>
            <div class="chat-header-info">
                <div class="chat-title">{{ $room->event->title }}</div>
                <div class="chat-sub">
                    <span class="status-dot"></span>
                    {{ $orgName }}
                </div>
            </div>
            <a href="{{ route('volunteer.chat.index') }}" class="header-btn" title="Kembali">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="header-btn" title="Info kegiatan">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
            </div>
        </div>

        <div class="messages" id="chatMessages">
            @php
                $grouped = $messages->groupBy(fn($m) => $m->created_at->format('Y-m-d'));
            @endphp

            @foreach($grouped as $date => $dayMessages)
                @php
                    $dateLabel = \Carbon\Carbon::parse($date)->isToday()
                        ? 'Hari ini'
                        : (\Carbon\Carbon::parse($date)->isYesterday()
                            ? 'Kemarin'
                            : \Carbon\Carbon::parse($date)->translatedFormat('d F Y'));
                @endphp

                <div class="date-sep"><span>{{ $dateLabel }}</span></div>

                @foreach($dayMessages as $msg)
                    @php $isMe = $msg->sender_id === $currentUser; @endphp
                    <div class="msg-group {{ $isMe ? 'me' : 'them' }}">
                        <div class="bubble {{ $isMe ? 'me' : 'them' }}">{{ $msg->message }}</div>
                        <div class="bubble-meta {{ $isMe ? 'me' : 'them' }}">
                            @if($isMe)
                                <svg class="check-icon" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            @endif
                            <span>{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

        <div class="input-bar">
            <div class="input-wrap">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     style="margin-bottom:12px;">
                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66L9.41 17.41a2 2 0 01-2.83-2.83l8.49-8.48"/>
                </svg>
                <textarea id="msgInput" placeholder="Ketik pesan…" rows="1"></textarea>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     style="margin-bottom:12px;">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M8 13s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/>
                </svg>
            </div>
            <button class="send-btn" id="btnSend" aria-label="Kirim pesan">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
(function () {
    const SEND_URL = "{{ route('volunteer.chat.send', $room) }}";
    const POLL_URL = "{{ route('volunteer.chat.poll', $room) }}";
    const CSRF     = "{{ csrf_token() }}";
    let lastId     = {{ $messages->last()?->id ?? 0 }};

    function scrollBottom() {
        const el = document.getElementById('chatMessages');
        el.scrollTop = el.scrollHeight;
    }

    scrollBottom();

    function appendBubble(data) {
        const box = document.getElementById('chatMessages');
        const group = document.createElement('div');
        group.className = 'msg-group ' + (data.is_me ? 'me' : 'them');

        const bubble = document.createElement('div');
        bubble.className = 'bubble ' + (data.is_me ? 'me' : 'them');
        bubble.textContent = data.message;

        const meta = document.createElement('div');
        meta.className = 'bubble-meta ' + (data.is_me ? 'me' : 'them');

        if (data.is_me) {
            meta.innerHTML = `
                <svg class="check-icon" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>${data.created_at}</span>`;
        } else {
            meta.innerHTML = `<span>${data.created_at}</span>`;
        }

        group.appendChild(bubble);
        group.appendChild(meta);
        box.appendChild(group);
        scrollBottom();
    }

    async function sendMessage() {
        const input = document.getElementById('msgInput');
        const text  = input.value.trim();
        if (!text) return;
        input.value = '';
        input.style.height = '42px';

        try {
            const res  = await fetch(SEND_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: text }),
            });
            const data = await res.json();
            if (data.id) {
                lastId = data.id;
                appendBubble({ message: data.message, is_me: true, created_at: data.created_at });
            }
        } catch (e) {
            console.error('Send error:', e);
        }
    }

    document.getElementById('btnSend').addEventListener('click', sendMessage);

    document.getElementById('msgInput').addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    document.getElementById('msgInput').addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    setInterval(async function () {
        try {
            const res  = await fetch(POLL_URL + '?after=' + lastId, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
            });
            const data = await res.json();
            data.messages.forEach(function (m) {
                if (m.id > lastId) {
                    lastId = m.id;
                    appendBubble(m);
                }
            });
        } catch (e) {}
    }, 3000);
})();
</script>
@endpush
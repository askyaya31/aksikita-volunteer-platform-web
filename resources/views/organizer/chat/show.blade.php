@extends('layouts.organizer')
@section('title', 'Chat — ' . $room->volunteer->name)

@push('styles')
<style>
.chat-wrap    { max-width:720px; margin:0 auto; padding:1.5rem 1.5rem 2rem; }
.chat-header  { display:flex; align-items:center; gap:12px; margin-bottom:1rem;
                background:#fff; border:1px solid #EEF0F6; border-radius:14px;
                padding:14px 16px; }
.chat-box     { background:#fff; border:1px solid #EEF0F6; border-radius:14px;
                height:460px; display:flex; flex-direction:column; overflow:hidden; }
.chat-messages{ flex:1; overflow-y:auto; padding:1rem; display:flex;
                flex-direction:column; gap:10px; }
.bubble       { max-width:75%; padding:10px 14px; border-radius:16px;
                font-size:13.5px; line-height:1.55; }
.bubble.me    { background:#0F2057; color:#fff; align-self:flex-end;
                border-bottom-right-radius:4px; }
.bubble.them  { background:#F4F5F9; color:#1A1F2E; align-self:flex-start;
                border-bottom-left-radius:4px; }
.bubble-time  { font-size:10.5px; opacity:0.6; margin-top:4px; }
.chat-input   { display:flex; gap:10px; padding:12px 14px;
                border-top:1px solid #EEF0F6; }
.chat-input textarea {
    flex:1; border:1.5px solid #D8DCE8; border-radius:10px;
    padding:10px 12px; font-family:inherit; font-size:13.5px;
    resize:none; height:42px; outline:none;
    transition:border-color 0.15s;
}
.chat-input textarea:focus { border-color:#1A3575; }
.chat-send { background:#E8501A; color:#fff; border:none; border-radius:10px;
             padding:0 18px; font-weight:700; cursor:pointer;
             transition:background 0.15s; }
.chat-send:hover { background:#F5773D; }
</style>
@endpush

@section('content')
<div class="chat-wrap">

    <a href="{{ route('organizer.chat.index') }}"
       style="display:inline-flex; align-items:center; gap:6px;
              font-size:13px; font-weight:500; color:#5A6278;
              text-decoration:none; margin-bottom:1rem;">
        ← Kembali ke pesan
    </a>

    @php
        $volProfile = $room->volunteer->volunteerProfile;
        $volAvatar  = $volProfile->avatar ?? null;
        $volName    = $room->volunteer->name;
        $volInitial = strtoupper(substr($volName, 0, 1));
    @endphp

    <div class="chat-header">
        @if($volAvatar)
            <img src="{{ Storage::url($volAvatar) }}"
                 alt="{{ $volName }}"
                 style="width:44px; height:44px; border-radius:50%;
                        object-fit:cover; border:1.5px solid #EEF0F6; flex-shrink:0;">
        @else
            <div style="width:44px; height:44px; border-radius:50%;
                        background:linear-gradient(135deg, #0E7B6C 0%, #1DB8A0 100%);
                        display:flex; align-items:center; justify-content:center;
                        font-family:'Plus Jakarta Sans',sans-serif;
                        font-size:18px; font-weight:700; color:#fff; flex-shrink:0;">
                {{ $volInitial }}
            </div>
        @endif

        <div>
            <div style="font-weight:700; color:#0F2057; font-size:15px;">
                {{ $volName }}
            </div>
            <div style="font-size:12px; color:#5A6278;">
                {{ $room->event->title }}
            </div>
        </div>
    </div>

    <div class="chat-box">
        <div class="chat-messages" id="chatMessages">
            @foreach($messages as $msg)
                @php $isMe = $msg->sender_id === (int) session('user_id'); @endphp
                <div class="bubble {{ $isMe ? 'me' : 'them' }}">
                    <div>{{ $msg->message }}</div>
                    <div class="bubble-time" style="text-align:{{ $isMe ? 'right' : 'left' }};">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="chat-input">
            <textarea id="msgInput" placeholder="Ketik pesan…" rows="1"
                      onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendMessage();}"></textarea>
            <button class="chat-send" onclick="sendMessage()">Kirim</button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
const SEND_URL = '{{ route('organizer.chat.send', $room) }}';
const POLL_URL = '{{ route('organizer.chat.poll', $room) }}';
const CSRF     = '{{ csrf_token() }}';
let lastId     = {{ $messages->last()?->id ?? 0 }};

function scrollBottom() {
    const el = document.getElementById('chatMessages');
    el.scrollTop = el.scrollHeight;
}
scrollBottom();

function appendBubble({ message, is_me, created_at }) {
    const box  = document.getElementById('chatMessages');
    const div  = document.createElement('div');
    div.className = 'bubble ' + (is_me ? 'me' : 'them');
    div.innerHTML = `<div>${escHtml(message)}</div>
        <div class="bubble-time" style="text-align:${is_me?'right':'left'};">${created_at}</div>`;
    box.appendChild(div);
    scrollBottom();
}

function escHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;')
              .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

async function sendMessage() {
    const input = document.getElementById('msgInput');
    const text  = input.value.trim();
    if (!text) return;
    input.value = '';

    const res  = await fetch(SEND_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json',
                   'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: JSON.stringify({ message: text }),
    });
    const data = await res.json();
    if (data.id) {
        lastId = data.id;
        appendBubble({ ...data, is_me: true });
    }
}

setInterval(async () => {
    const res  = await fetch(`${POLL_URL}?after=${lastId}`, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
    });
    const data = await res.json();
    data.messages.forEach(m => {
        if (m.id > lastId) {
            lastId = m.id;
            appendBubble(m);
        }
    });
}, 3000);
</script>
@endpush
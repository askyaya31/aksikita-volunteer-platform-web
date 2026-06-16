@extends('layouts.volunteer')
@section('title', 'Chat — ' . $room->event->title)

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

    <a href="{{ route('volunteer.chat.index') }}"
       style="display:inline-flex; align-items:center; gap:6px;
              font-size:13px; font-weight:500; color:#5A6278;
              text-decoration:none; margin-bottom:1rem;">
        &larr; Kembali ke pesan
    </a>

    @php
        $orgProfile = $room->organizer->organizationProfile;
        $orgName    = $orgProfile->organization_name ?? $room->organizer->name;
        $orgLogo    = $orgProfile->logo ?? null;
        $orgInitial = strtoupper(substr($orgName, 0, 1));
    @endphp

    <div class="chat-header">
        @if($orgLogo)
            <img src="{{ Storage::url($orgLogo) }}"
                 alt="{{ $orgName }}"
                 style="width:44px; height:44px; border-radius:50%;
                        object-fit:cover; border:1.5px solid #EEF0F6; flex-shrink:0;">
        @else
            <div style="width:44px; height:44px; border-radius:50%;
                        background:linear-gradient(135deg, #0F2057 0%, #1A3575 100%);
                        display:flex; align-items:center; justify-content:center;
                        font-family:'Plus Jakarta Sans',sans-serif;
                        font-size:18px; font-weight:700; color:#fff; flex-shrink:0;">
                {{ $orgInitial }}
            </div>
        @endif

        <div>
            <div style="font-weight:700; color:#0F2057; font-size:15px;">
                {{ $room->event->title }}
            </div>
            <div style="font-size:12px; color:#5A6278;">
                {{ $orgName }}
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
            <textarea id="msgInput" placeholder="Ketik pesan&hellip;" rows="1"></textarea>
            <button class="chat-send" id="btnSend">Kirim</button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
(function() {
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
        const box  = document.getElementById('chatMessages');
        const div  = document.createElement('div');
        div.className = 'bubble ' + (data.is_me ? 'me' : 'them');

        const msg  = document.createElement('div');
        msg.textContent = data.message;

        const time = document.createElement('div');
        time.className = 'bubble-time';
        time.style.textAlign = data.is_me ? 'right' : 'left';
        time.textContent = data.created_at;

        div.appendChild(msg);
        div.appendChild(time);
        box.appendChild(div);
        scrollBottom();
    }

    async function sendMessage() {
        const input = document.getElementById('msgInput');
        const text  = input.value.trim();
        if (!text) return;
        input.value = '';

        try {
            const res  = await fetch(SEND_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
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

    document.getElementById('msgInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    setInterval(async function() {
        try {
            const res  = await fetch(POLL_URL + '?after=' + lastId, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
            });
            const data = await res.json();
            data.messages.forEach(function(m) {
                if (m.id > lastId) {
                    lastId = m.id;
                    appendBubble(m);
                }
            });
        } catch(e) {}
    }, 3000);
})();
</script>
@endpush
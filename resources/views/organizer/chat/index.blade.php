@extends('layouts.organizer')
@section('title', 'Pesan Relawan')

@section('content')
<div style="max-width:680px; margin:0 auto; padding:2rem 1.5rem;">

    <h1 style="font-family:var(--font-display); font-size:1.15rem;
               font-weight:700; color:var(--color-navy); margin-bottom:1.25rem;">
        Pesan Relawan
    </h1>

    @forelse($rooms as $room)
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
                    : ($msgTime->isYesterday()
                        ? 'Kemarin'
                        : $msgTime->format('d M'));
            }

            if ($latest) {
                $isMyMsg     = $latest->sender_id === $userId;
                $previewText = ($isMyMsg ? 'Kamu: ' : '') . Str::limit($latest->message, 55);
            } else {
                $previewText = null;
            }
        @endphp

        <a href="{{ route('organizer.chat.show', $room) }}"
           style="display:flex; align-items:center; gap:13px;
                  background:{{ $hasUnread ? 'var(--color-blue-ghost)' : 'var(--color-surface)' }};
                  border:1.5px solid {{ $hasUnread ? 'var(--color-blue-light)' : 'var(--color-border)' }};
                  border-radius:var(--radius-lg);
                  padding:13px 15px; margin-bottom:9px; text-decoration:none;
                  transition:box-shadow 0.15s, border-color 0.15s;"
           onmouseover="this.style.boxShadow='0 4px 14px rgba(15,32,87,0.09)'"
           onmouseout="this.style.boxShadow='none'">

            <div style="position:relative; flex-shrink:0;">
                @if($volAvatar)
                    <img src="{{ Storage::url($volAvatar) }}"
                         alt="{{ $volName }}"
                         style="width:46px; height:46px; border-radius:50%;
                                object-fit:cover; border:1.5px solid var(--color-border);">
                @else
                    <div style="width:46px; height:46px; border-radius:50%;
                                background:linear-gradient(135deg, #0E7B6C 0%, #1DB8A0 100%);
                                display:flex; align-items:center; justify-content:center;
                                font-family:var(--font-display); font-size:17px;
                                font-weight:700; color:#fff;">
                        {{ $volInitial }}
                    </div>
                @endif

                @if($hasUnread)
                    <span style="position:absolute; bottom:1px; right:1px;
                                 width:11px; height:11px; border-radius:50%;
                                 background:var(--color-blue);
                                 border:2px solid var(--color-surface);"></span>
                @endif
            </div>

            {{-- Konten --}}
            <div style="flex:1; min-width:0;">
                {{-- Baris 1: Nama volunteer + timestamp --}}
                <div style="display:flex; align-items:center;
                            justify-content:space-between; gap:8px; margin-bottom:2px;">
                    <div style="font-size:0.875rem;
                                font-weight:{{ $hasUnread ? '700' : '600' }};
                                color:var(--color-navy);
                                white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $volName }}
                    </div>
                    @if($timestamp)
                        <div style="font-size:0.72rem;
                                    color:{{ $hasUnread ? 'var(--color-blue)' : 'var(--color-ink-muted)' }};
                                    white-space:nowrap; flex-shrink:0;
                                    font-weight:{{ $hasUnread ? '600' : '400' }};">
                            {{ $timestamp }}
                        </div>
                    @endif
                </div>
                <div style="font-size:0.78rem; color:var(--color-ink-soft);
                            white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
                            margin-bottom:3px;">
                    {{ $room->event->title }}
                </div>

                <div style="display:flex; align-items:center;
                            justify-content:space-between; gap:8px;">
                    @if($previewText)
                        <div style="font-size:0.78rem;
                                    color:{{ $hasUnread ? 'var(--color-ink)' : 'var(--color-ink-muted)' }};
                                    font-weight:{{ $hasUnread ? '500' : '400' }};
                                    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $previewText }}
                        </div>
                    @else
                        <div style="font-size:0.78rem; color:var(--color-ink-muted);
                                    font-style:italic;">
                            Belum ada pesan
                        </div>
                    @endif

                    @if($hasUnread)
                        <span style="background:var(--color-blue); color:#fff;
                                     font-size:0.68rem; font-weight:700;
                                     border-radius:999px; padding:2px 7px;
                                     flex-shrink:0; min-width:20px; text-align:center;">
                            {{ $unread > 99 ? '99+' : $unread }}
                        </span>
                    @endif
                </div>
            </div>

        </a>
    @empty
        <div style="text-align:center; padding:4rem 1rem;">
            <div style="width:60px; height:60px; border-radius:50%;
                        background:var(--color-blue-ghost);
                        display:flex; align-items:center; justify-content:center;
                        margin:0 auto 14px;">
                <svg width="26" height="26" fill="none" viewBox="0 0 24 24"
                     stroke="var(--color-blue)" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9
                             8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512
                             15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <p style="font-size:0.875rem; color:var(--color-ink-muted); margin:0; line-height:1.6;">
                Belum ada chat aktif.<br>
                Chat terbuka otomatis saat kamu mengkonfirmasi pendaftaran relawan.
            </p>
        </div>
    @endforelse

</div>
@endsection
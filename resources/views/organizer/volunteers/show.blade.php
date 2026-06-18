@extends('layouts.organizer')

@section('title', $volunteer->name . ' — Detail Kandidat')

@section('content')

<nav style="display:flex; align-items:center; gap:6px; font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:20px; flex-wrap:wrap;">
    <a href="{{ route('organizer.events') }}" style="color:var(--color-ink-muted); text-decoration:none; transition:color 0.15s;">Kelola Event</a>
    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('organizer.events.show', $registration->event_id) }}" style="color:var(--color-ink-muted); text-decoration:none; transition:color 0.15s; max-width:240px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; display:inline-block;">{{ Str::limit($registration->event->title, 36) }}</a>
    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <span style="color:var(--color-ink); font-weight:500;">{{ $volunteer->name }}</span>
</nav>

<div style="display:grid; grid-template-columns:1fr 300px; gap:20px; align-items:start;">
    <div style="display:flex; flex-direction:column; gap:16px;">
        <div style="background:var(--color-surface); border:1.5px solid var(--color-border); border-radius:var(--radius-lg); padding:20px 24px; display:flex; align-items:flex-start; gap:16px;">
            <div style="flex-shrink:0;">
                @if($profile?->avatar)
                    <img src="{{ Storage::url($profile->avatar) }}"
                         alt="{{ $volunteer->name }}"
                         style="width:52px; height:52px; border-radius:50%; object-fit:cover; border:2px solid var(--color-border);">
                @else
                    <div style="width:52px; height:52px; border-radius:50%; background:linear-gradient(135deg, var(--color-navy) 0%, var(--color-blue) 100%); display:flex; align-items:center; justify-content:center; font-family:var(--font-display); font-weight:700; font-size:1.1rem; color:#fff; flex-shrink:0;">
                        {{ strtoupper(substr($volunteer->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div style="flex:1; min-width:0;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:5px;">
                    <h1 style="font-size:1.1rem; font-weight:700; color:var(--color-navy); margin:0; letter-spacing:-0.01em;">{{ $volunteer->name }}</h1>
                    @if($profile?->gender)
                        @php $gMap = ['male'=>'Laki-laki','female'=>'Perempuan','other'=>'Lainnya']; @endphp
                        <span class="ak-badge ak-badge-gray" style="font-size:11px;">{{ $gMap[$profile->gender] ?? $profile->gender }}</span>
                    @endif
                </div>

                <div style="display:flex; flex-wrap:wrap; gap:12px; font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:8px;">
                    <span>{{ $volunteer->email }}</span>
                    @if($volunteer->phone)
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $volunteer->phone }}
                        </span>
                    @endif
                    @if($profile?->city)
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $profile->city }}, {{ $profile->province }}
                        </span>
                    @endif
                    @if($profile?->date_of_birth)
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($profile->date_of_birth)->format('d M Y') }}
                        </span>
                    @endif
                </div>

                @if($profile?->bio)
                    <p style="font-size:0.85rem; color:var(--color-ink-soft); line-height:1.6; margin:0;">{{ $profile->bio }}</p>
                @endif
            </div>
        </div>

        @if($profile && ($profile->skills || $profile->interests))
            <div style="background:var(--color-surface); border:1.5px solid var(--color-border); border-radius:var(--radius-lg); padding:18px 24px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

                    @if($profile->skills)
                        @php
                            $skills = is_array($profile->skills)
                                ? $profile->skills
                                : (json_decode($profile->skills, true) ?? array_filter(array_map('trim', explode(',', $profile->skills))));
                        @endphp
                        <div>
                            <div style="font-size:0.72rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--color-ink-muted); margin-bottom:10px;">Keahlian</div>
                            <div style="display:flex; flex-wrap:wrap; gap:6px;">
                                @foreach($skills as $skill)
                                    <span style="display:inline-flex; align-items:center; padding:3px 10px; background:rgb(30 58 138 / 0.07); color:var(--color-navy); border-radius:var(--radius-full); font-size:0.78rem; font-weight:500;">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($profile->interests)
                        @php
                            $interests = is_array($profile->interests)
                                ? $profile->interests
                                : (json_decode($profile->interests, true) ?? array_filter(array_map('trim', explode(',', $profile->interests))));
                        @endphp
                        <div>
                            <div style="font-size:0.72rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--color-ink-muted); margin-bottom:10px;">Minat</div>
                            <div style="display:flex; flex-wrap:wrap; gap:6px;">
                                @foreach($interests as $interest)
                                    <span style="display:inline-flex; align-items:center; padding:3px 10px; background:var(--color-blue-ghost); color:var(--color-blue); border-radius:var(--radius-full); font-size:0.78rem; font-weight:500;">{{ trim($interest) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        @endif

        <div style="background:var(--color-surface); border:1.5px solid var(--color-border); border-radius:var(--radius-lg); padding:18px 24px;">

            <div style="font-size:0.72rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--color-ink-muted); margin-bottom:14px;">Rekam Jejak Volunteer</div>

            <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:10px; margin-bottom:0;">

                <div style="text-align:center; padding:12px 8px; background:var(--color-bg); border-radius:var(--radius-md);">
                    <div style="font-family:var(--font-display); font-size:1.4rem; font-weight:800; color:var(--color-navy); line-height:1;">{{ $stats['total_daftar'] }}</div>
                    <div style="font-size:0.72rem; color:var(--color-ink-muted); margin-top:4px; font-weight:500;">Total Daftar</div>
                </div>

                <div style="text-align:center; padding:12px 8px; background:var(--color-success-bg); border-radius:var(--radius-md);">
                    <div style="font-family:var(--font-display); font-size:1.4rem; font-weight:800; color:var(--color-success); line-height:1;">{{ $stats['total_confirmed'] }}</div>
                    <div style="font-size:0.72rem; color:var(--color-success); margin-top:4px; font-weight:500; opacity:0.8;">Diterima</div>
                </div>

                <div style="text-align:center; padding:12px 8px; background:var(--color-blue-ghost); border-radius:var(--radius-md);">
                    <div style="font-family:var(--font-display); font-size:1.4rem; font-weight:800; color:var(--color-blue); line-height:1;">{{ $stats['total_hadir'] }}</div>
                    <div style="font-size:0.72rem; color:var(--color-blue); margin-top:4px; font-weight:500; opacity:0.8;">Hadir</div>
                </div>

                <div style="text-align:center; padding:12px 8px; background:var(--color-danger-bg); border-radius:var(--radius-md);">
                    <div style="font-family:var(--font-display); font-size:1.4rem; font-weight:800; color:var(--color-danger); line-height:1;">{{ $stats['total_batal'] }}</div>
                    <div style="font-size:0.72rem; color:var(--color-danger); margin-top:4px; font-weight:500; opacity:0.8;">Dibatalkan</div>
                </div>

            </div>
        </div>

        <div style="background:var(--color-surface); border:1.5px solid var(--color-border); border-radius:var(--radius-lg); overflow:hidden;">

            <div style="padding:16px 24px; border-bottom:1px solid var(--color-border-soft); display:flex; align-items:center; justify-content:space-between;">
                <div style="font-size:0.72rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--color-ink-muted);">Riwayat Kegiatan</div>
                @if($history->count() > 0)
                    <span style="font-size:0.78rem; color:var(--color-ink-muted);">{{ $history->count() }} kegiatan</span>
                @endif
            </div>

            @if($history->isEmpty())
                <div style="padding:40px 24px; text-align:center;">
                    <div style="width:40px; height:40px; border-radius:var(--radius-md); background:var(--color-blue-ghost); display:flex; align-items:center; justify-content:center; margin:0 auto 12px; color:var(--color-blue);">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p style="font-size:0.85rem; color:var(--color-ink-muted); margin:0;">Belum ada riwayat kegiatan lain.</p>
                </div>
            @else
                <div>
                    @foreach($history as $reg)
                        @php
                            $rMap = [
                                'confirmed' => ['Diterima',    'color:var(--color-success); background:var(--color-success-bg);'],
                                'attended'  => ['Hadir',       'color:var(--color-blue); background:var(--color-blue-ghost);'],
                                'cancelled' => ['Dibatalkan',  'color:var(--color-danger); background:var(--color-danger-bg);'],
                                'pending'   => ['Pending',     'color:var(--color-warning); background:var(--color-warning-bg);'],
                            ];
                            [$rLabel, $rStyle] = $rMap[$reg->status] ?? [$reg->status, 'color:var(--color-ink-muted); background:var(--color-border-soft);'];
                        @endphp
                        <div style="display:flex; align-items:center; gap:12px; padding:11px 24px; border-bottom:1px solid var(--color-border-soft);">
                            <div style="flex:1; min-width:0;">
                                <div style="font-size:0.875rem; font-weight:500; color:var(--color-ink); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {{ $reg->event->title ?? '—' }}
                                </div>
                                <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-top:1px;">
                                    @if($reg->event?->start_date)
                                        {{ \Carbon\Carbon::parse($reg->event->start_date)->format('d M Y') }}
                                    @endif
                                    @if($reg->event?->city)
                                        · {{ $reg->event->city }}
                                    @endif
                                </div>
                            </div>
                            <span style="display:inline-flex; padding:2px 9px; border-radius:var(--radius-full); font-size:0.72rem; font-weight:600; white-space:nowrap; flex-shrink:0; {{ $rStyle }}">
                                {{ $rLabel }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>

    <div style="display:flex; flex-direction:column; gap:14px; position:sticky; top:calc(var(--spacing-navbar) + 16px);">

        <div style="background:var(--color-surface); border:1.5px solid var(--color-border); border-radius:var(--radius-lg); overflow:hidden;">

            <div style="padding:14px 18px; border-bottom:1px solid var(--color-border-soft);">
                <div style="font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--color-ink-muted); margin-bottom:6px;">Pendaftaran Saat Ini</div>
                @php
                    $sMap = [
                        'pending'   => ['Menunggu Review',  'color:var(--color-warning); background:var(--color-warning-bg); border:1px solid rgb(245 158 11 / 0.2);'],
                        'confirmed' => ['Diterima',         'color:var(--color-success); background:var(--color-success-bg); border:1px solid rgb(16 185 129 / 0.2);'],
                        'attended'  => ['Hadir',            'color:var(--color-blue); background:var(--color-blue-ghost); border:1px solid rgb(59 130 246 / 0.2);'],
                        'cancelled' => ['Tidak Diterima',   'color:var(--color-danger); background:var(--color-danger-bg); border:1px solid rgb(239 68 68 / 0.2);'],
                    ];
                    [$sLabel, $sStyle] = $sMap[$registration->status] ?? [$registration->status, 'color:var(--color-ink-muted); background:var(--color-border-soft);'];
                @endphp
                <span style="display:inline-flex; padding:3px 10px; border-radius:var(--radius-full); font-size:0.78rem; font-weight:600; {{ $sStyle }}">
                    {{ $sLabel }}
                </span>
            </div>

            <div style="padding:14px 18px; display:flex; flex-direction:column; gap:10px;">
                <div>
                    <div style="font-size:0.7rem; color:var(--color-ink-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Event</div>
                    <div style="font-size:0.82rem; font-weight:600; color:var(--color-ink); line-height:1.4;">{{ $registration->event->title }}</div>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div style="font-size:0.75rem; color:var(--color-ink-muted);">Tanggal Daftar</div>
                    <div style="font-size:0.8rem; font-weight:500; color:var(--color-ink);">{{ $registration->created_at->format('d M Y') }}</div>
                </div>
                @if($registration->cancellation_reason)
                    <div style="padding:10px; background:var(--color-danger-bg); border-radius:var(--radius-sm); border-left:3px solid var(--color-danger);">
                        <div style="font-size:0.7rem; font-weight:700; color:var(--color-danger); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Alasan Penolakan</div>
                        <div style="font-size:0.8rem; color:#991b1b; line-height:1.5;">{{ $registration->cancellation_reason }}</div>
                    </div>
                @endif
            </div>
        </div>
         @if($registration->chatRoom && in_array($registration->status, ['confirmed', 'attended']))
            <a href="{{ route('organizer.chat.show', $registration->chatRoom) }}"
               style="display:flex; align-items:center; justify-content:center; gap:8px;
                      padding:9px 16px; background:var(--color-navy); color:#fff;
                      border-radius:var(--radius-sm); font-size:0.85rem; font-weight:600;
                      text-decoration:none; transition:background 0.15s;"
               onmouseover="this.style.background='var(--color-blue)'"
               onmouseout="this.style.background='var(--color-navy)'">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Buka Chat
            </a>
        @endif
            
        @if($registration->status === 'pending')
            <div style="background:var(--color-surface); border:1.5px solid var(--color-border); border-radius:var(--radius-lg); padding:16px 18px; display:flex; flex-direction:column; gap:8px;">
                <div style="font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--color-ink-muted); margin-bottom:4px;">Tindakan</div>
                <form method="POST" action="{{ route('organizer.confirm', $registration->id) }}">
                    @csrf
                    <button type="submit" class="ak-btn ak-btn-success" style="width:100%; justify-content:center; font-size:0.85rem; padding:9px 16px;"
                            onclick="return confirm('Terima pendaftaran {{ addslashes($volunteer->name) }}?')">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Terima
                    </button>
                </form>

                <button type="button" onclick="document.getElementById('rejectPanel').classList.toggle('ak-hidden')"
                        class="ak-btn ak-btn-ghost" style="width:100%; justify-content:center; font-size:0.85rem; padding:9px 16px; color:var(--color-danger); border-color:var(--color-danger);">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    Tolak
                </button>

                <div id="rejectPanel" class="ak-hidden" style="border-top:1px solid var(--color-border); padding-top:12px; margin-top:4px;">
                    <form method="POST" action="{{ route('organizer.reject', $registration->id) }}">
                        @csrf
                        <div class="ak-form-group" style="margin-bottom:10px;">
                            <label class="ak-label" style="font-size:0.8rem;" for="reason">Alasan <span class="required">*</span></label>
                            <textarea name="reason" id="reason" class="ak-textarea" rows="3"
                                      placeholder="Berikan alasan penolakan yang jelas..."
                                      style="font-size:0.85rem;" required></textarea>
                        </div>
                        <button type="submit" class="ak-btn ak-btn-danger" style="width:100%; justify-content:center; font-size:0.85rem; padding:9px 16px;"
                                onclick="return confirm('Tolak pendaftaran ini?')">
                            Konfirmasi Penolakan
                        </button>
                    </form>
                </div>
            </div>

        @elseif($registration->status === 'confirmed')
            <div style="background:var(--color-surface); border:1.5px solid var(--color-border); border-radius:var(--radius-lg); padding:16px 18px; display:flex; flex-direction:column; gap:8px;">
                <div style="font-size:0.7rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:var(--color-ink-muted); margin-bottom:4px;">Tindakan</div>
                <form method="POST" action="{{ route('organizer.attend', $registration->id) }}">
                    @csrf
                    <button type="submit" class="ak-btn ak-btn-primary" style="width:100%; justify-content:center; font-size:0.85rem; padding:9px 16px;"
                            onclick="return confirm('Tandai {{ addslashes($volunteer->name) }} sebagai hadir?')">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tandai Hadir
                    </button>
                </form>
            </div>

        @elseif($registration->status === 'attended')
            <div class="ak-alert ak-alert-success" style="border-radius:var(--radius-lg);">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div style="font-size:0.82rem;">Volunteer sudah hadir di kegiatan ini.</div>
            </div>

        @elseif($registration->status === 'cancelled')
            <div class="ak-alert ak-alert-danger" style="border-radius:var(--radius-lg);">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div style="font-size:0.82rem;">Pendaftaran ini sudah ditolak.</div>
            </div>
        @endif
        
        <a href="{{ route('organizer.events.show', $registration->event_id) }}"
           style="display:flex; align-items:center; justify-content:center; gap:6px; padding:9px 16px; border:1.5px solid var(--color-border); border-radius:var(--radius-sm); font-size:0.82rem; font-weight:500; color:var(--color-ink-soft); text-decoration:none; transition:all 0.15s; background:var(--color-surface);"
           onmouseover="this.style.borderColor='var(--color-blue-light)'; this.style.color='var(--color-navy)'; this.style.background='var(--color-blue-ghost)';"
           onmouseout="this.style.borderColor='var(--color-border)'; this.style.color='var(--color-ink-soft)'; this.style.background='var(--color-surface)';">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Detail Event
        </a>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('rejectPanel')?.classList.add('ak-hidden');
</script>
<style>
.ak-hidden { display: none !important; }
</style>
@endpush
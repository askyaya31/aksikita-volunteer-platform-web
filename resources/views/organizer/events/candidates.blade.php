@extends('layouts.organizer')

@section('title', 'Daftar Kandidat')

@push('styles')
<style>
.cand-page {
    background: #F4F7FF;
    padding: 2rem 0 4rem;
    min-height: 100vh;
}

.cand-topbar {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}
.cand-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: #0F172A;
    margin: 0 0 3px;
}
.cand-subtitle {
    font-size: 0.8rem;
    color: #64748B;
    margin: 0;
}
.cand-event-picker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1.5px solid #BFDBFE;
    border-radius: 10px;
    padding: 9px 16px;
    font-size: 13px;
    font-weight: 500;
    color: #1E3A8A;
    min-width: 220px;
}
.cand-event-picker svg { flex-shrink: 0; color: #3B82F6; }
.cand-event-picker select {
    border: none;
    outline: none;
    background: transparent;
    font-size: 13px;
    font-weight: 500;
    color: #1E3A8A;
    cursor: pointer;
    flex: 1;
}

.cand-flash {
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 20px;
}
.cand-flash-ok  { background: #DBEAFE; color: #1E3A8A; border: 1px solid #BFDBFE; }
.cand-flash-err { background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }

.cand-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 24px;
}
.cand-stat {
    background: #fff;
    border: 1.5px solid #E2E8F0;
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.cand-stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.csi-total   { background: #EFF6FF; color: #1E3A8A; }
.csi-pending { background: #EFF6FF; color: #3B82F6; }
.csi-acc     { background: #DBEAFE; color: #1D4ED8; }
.csi-rej     { background: #F1F5F9; color: #475569; }
.cand-stat-lbl { font-size: 11px; color: #94A3B8; font-weight: 500; margin-bottom: 2px; }
.cand-stat-num { font-size: 22px; font-weight: 700; color: #0F172A; line-height: 1; }

.cand-filters {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.cand-chip {
    display: inline-flex;
    align-items: center;
    padding: 7px 18px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    border: 1.5px solid #E2E8F0;
    background: #fff;
    color: #64748B;
    transition: all .15s;
    white-space: nowrap;
}
.cand-chip:hover           { border-color: #93C5FD; color: #1E3A8A; background: #EFF6FF; }
.cand-chip.f-all           { background: #1E3A8A; border-color: #1E3A8A; color: #fff; }
.cand-chip.f-pending       { background: #3B82F6; border-color: #3B82F6; color: #fff; }
.cand-chip.f-acc           { background: #60A5FA; border-color: #60A5FA; color: #fff; }
.cand-chip.f-rej           { background: #94A3B8; border-color: #94A3B8; color: #fff; }
.cand-chip.f-attended      { background: #BFDBFE; border-color: #93C5FD; color: #1E3A8A; }

.cand-count {
    font-size: 12.5px;
    color: #94A3B8;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.cand-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}
.cand-card {
    background: #fff;
    border: 1.5px solid #E2E8F0;
    border-radius: 16px;
    overflow: hidden;
    transition: border-color .18s, transform .18s;
}
.cand-card:hover {
    border-color: #93C5FD;
    transform: translateY(-2px);
}

.cand-card .accent-bar { height: 3px; width: 100%; }
.accent-pending  { background: #93C5FD; }
.accent-acc      { background: #3B82F6; }
.accent-rej      { background: #CBD5E1; }
.accent-attended { background: #1E3A8A; }

.cc-inner { padding: 16px; }

.cc-head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}
.cc-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
    border: 2px solid #BFDBFE;
}
.cc-avatar-placeholder {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
    letter-spacing: .5px;
    border: 2px solid #BFDBFE;
}
.av-a { background: #DBEAFE; color: #1E40AF; }
.av-b { background: #EFF6FF; color: #1D4ED8; }
.av-c { background: #BFDBFE; color: #1E3A8A; }
.av-d { background: #F0F9FF; color: #0369A1; }

.cc-info { flex: 1; min-width: 0; }
.cc-name  { font-size: 14px; font-weight: 700; color: #0F172A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cc-email { font-size: 11.5px; color: #94A3B8; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.cc-badge {
    padding: 4px 11px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
}
.badge-pending  { background: #EFF6FF; color: #1D4ED8;  border: 1px solid #BFDBFE; }
.badge-acc      { background: #DBEAFE; color: #1E3A8A;  border: 1px solid #93C5FD; }
.badge-rej      { background: #F1F5F9; color: #475569;  border: 1px solid #CBD5E1; }
.badge-attended { background: #1E3A8A; color: #BFDBFE;  border: 1px solid #1E3A8A; }

.cc-divider { border: none; border-top: 1px solid #F1F5F9; margin-bottom: 12px; }

.cc-meta { display: flex; flex-direction: column; gap: 7px; margin-bottom: 15px; }
.cc-meta-row {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 12px;
}
.cc-meta-row svg { flex-shrink: 0; margin-top: 1px; color: #93C5FD; }
.cc-meta-row .meta-val       { color: #334155; line-height: 1.4; }
.cc-meta-row .meta-val.nil   { color: #CBD5E1; font-style: italic; }
.cc-meta-row .meta-val.notes { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

.cc-actions { display: flex; gap: 7px; }
.btn-detail {
    flex: 1;
    padding: 9px;
    border-radius: 8px;
    border: 1.5px solid #E2E8F0;
    background: #F8FAFC;
    color: #334155;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    transition: all .13s;
    display: inline-block;
}
.btn-detail:hover { background: #EFF6FF; border-color: #BFDBFE; color: #1E3A8A; }
.btn-accept {
    flex: 1;
    padding: 9px;
    border-radius: 8px;
    border: none;
    background: #1E3A8A;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    transition: background .13s;
}
.btn-accept:hover { background: #3B82F6; }
.btn-reject {
    padding: 9px 13px;
    border-radius: 8px;
    border: 1.5px solid #E2E8F0;
    background: #F8FAFC;
    color: #64748B;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all .13s;
}
.btn-reject:hover { border-color: #CBD5E1; color: #475569; background: #F1F5F9; }
.btn-attend {
    flex: 1;
    padding: 9px;
    border-radius: 8px;
    border: none;
    background: #3B82F6;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    transition: background .13s;
}
.btn-attend:hover { background: #1E3A8A; }

.cand-empty {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border: 1.5px solid #E2E8F0;
    border-radius: 16px;
}
.cand-empty-icon {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: #EFF6FF;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    color: #60A5FA;
}
.cand-empty h3 { font-size: 15px; font-weight: 700; color: #0F172A; margin-bottom: 6px; }
.cand-empty p  { font-size: 13px; color: #94A3B8; }
.cand-pagination { margin-top: 24px; }
@media (max-width: 1000px) {
    .cand-grid  { grid-template-columns: repeat(2, 1fr); }
    .cand-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
    .cand-grid  { grid-template-columns: 1fr; }
    .cand-topbar { flex-direction: column; }
    .cand-event-picker { width: 100%; }
}
</style>
@endpush

@section('content')
@php
    $totalPending = \App\Models\Registration::where('status', 'pending')
                    ->when($selectedEvent, fn($q) => $q->where('event_id', $selectedEvent->id))
                    ->count();
    $totalAcc     = \App\Models\Registration::where('status', 'confirmed')
                    ->when($selectedEvent, fn($q) => $q->where('event_id', $selectedEvent->id))
                    ->count();
    $totalRej     = \App\Models\Registration::where('status', 'cancelled')
                    ->when($selectedEvent, fn($q) => $q->where('event_id', $selectedEvent->id))
                    ->count();

    $avatarColors = ['av-a', 'av-b', 'av-c', 'av-d'];

    $statusChips = [
        null        => ['label' => 'Semua',   'class' => 'f-all'],
        'pending'   => ['label' => 'Pending',  'class' => 'f-pending'],
        'confirmed' => ['label' => 'Diterima', 'class' => 'f-acc'],
        'cancelled' => ['label' => 'Ditolak',  'class' => 'f-rej'],
        'attended'  => ['label' => 'Hadir',    'class' => 'f-attended'],
    ];

    $badgeMap = [
        'confirmed' => ['label' => 'Diterima', 'class' => 'badge-acc',      'bar' => 'accent-acc'],
        'cancelled' => ['label' => 'Ditolak',  'class' => 'badge-rej',      'bar' => 'accent-rej'],
        'attended'  => ['label' => 'Hadir',    'class' => 'badge-attended', 'bar' => 'accent-attended'],
        'pending'   => ['label' => 'Pending',  'class' => 'badge-pending',  'bar' => 'accent-pending'],
    ];

    function candidateInitials($name) {
        $parts = array_filter(explode(' ', trim($name)));
        if (count($parts) >= 2)
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        return strtoupper(substr($name, 0, 2));
    }
@endphp

<div class="cand-page">
    <div class="ak-container">
        <div class="cand-topbar">
            <div>
                <h1 class="cand-title">Daftar Kandidat</h1>
                <p class="cand-subtitle">{{ $selectedEvent->title ?? 'Semua kegiatan' }}</p>
            </div>
            <form method="GET" action="{{ route('organizer.candidates.index') }}">
                @if($statusFilter)
                    <input type="hidden" name="status" value="{{ $statusFilter }}">
                @endif
                <div class="cand-event-picker">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <select name="event" onchange="this.form.submit()">
                        <option value="">Semua Kegiatan</option>
                        @foreach($events as $ev)
                            <option value="{{ $ev->id }}" {{ ($selectedEvent?->id == $ev->id) ? 'selected' : '' }}>
                                {{ Str::limit($ev->title, 40) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="cand-flash cand-flash-ok">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="cand-flash cand-flash-err">{{ session('error') }}</div>
        @endif

        <div class="cand-stats">
            <div class="cand-stat">
                <div class="cand-stat-icon csi-total">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div>
                    <div class="cand-stat-lbl">Total</div>
                    <div class="cand-stat-num">{{ $candidates->total() }}</div>
                </div>
            </div>
            <div class="cand-stat">
                <div class="cand-stat-icon csi-pending">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <div class="cand-stat-lbl">Pending</div>
                    <div class="cand-stat-num">{{ $totalPending }}</div>
                </div>
            </div>
            <div class="cand-stat">
                <div class="cand-stat-icon csi-acc">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div>
                    <div class="cand-stat-lbl">Diterima</div>
                    <div class="cand-stat-num">{{ $totalAcc }}</div>
                </div>
            </div>
            <div class="cand-stat">
                <div class="cand-stat-icon csi-rej">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                </div>
                <div>
                    <div class="cand-stat-lbl">Ditolak</div>
                    <div class="cand-stat-num">{{ $totalRej }}</div>
                </div>
            </div>
        </div>

        <div class="cand-filters">
            @foreach($statusChips as $val => $cfg)
                @php $isActive = ($statusFilter == $val); @endphp
                <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}"
                   class="cand-chip {{ $isActive ? $cfg['class'] : '' }}">
                    {{ $cfg['label'] }}
                </a>
            @endforeach
        </div>

        <div class="cand-count">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            {{ $candidates->total() }} kandidat ditemukan
        </div>

        @if($candidates->isEmpty())
            <div class="cand-empty">
                <div class="cand-empty-icon">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h3>Belum ada kandidat</h3>
                <p>Tidak ada kandidat yang cocok dengan filter ini.</p>
            </div>

        @else
            <div class="cand-grid">
                @foreach($candidates as $i => $candidate)
                    @php
                        $user     = $candidate->user;
                        $name     = $user?->name ?? '-';
                        $initials = candidateInitials($name);
                        $avClass  = $avatarColors[$i % count($avatarColors)];
                        $badge    = $badgeMap[$candidate->status] ?? $badgeMap['pending'];
                        $ev       = $candidate->event;
                        $photoUrl = null;
                        if ($user?->volunteerProfile?->photo) {
                            $photoUrl = Storage::url($user->volunteerProfile->photo);
                        } elseif ($user?->avatar) {
                            $photoUrl = Storage::url($user->avatar);
                        } elseif ($user?->profile_photo_url) {
                            $photoUrl = $user->profile_photo_url;
                        }
                    @endphp

                    <div class="cand-card">
                        <div class="accent-bar {{ $badge['bar'] }}"></div>
                        <div class="cc-inner">
                            <div class="cc-head">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}"
                                         alt="{{ $name }}"
                                         class="cc-avatar"
                                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                    <div class="cc-avatar-placeholder {{ $avClass }}" style="display:none;">{{ $initials }}</div>
                                @else
                                    <div class="cc-avatar-placeholder {{ $avClass }}">{{ $initials }}</div>
                                @endif

                                <div class="cc-info">
                                    <div class="cc-name">{{ $name }}</div>
                                    <div class="cc-email">{{ $user?->email ?? '-' }}</div>
                                </div>
                                <span class="cc-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                            </div>

                            <hr class="cc-divider">
                            <div class="cc-meta">
                                @unless($selectedEvent)
                                <div class="cc-meta-row">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                    <span class="meta-val">{{ Str::limit($ev?->title ?? '-', 45) }}</span>
                                </div>
                                @endunless

                                <div class="cc-meta-row">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                    <span class="meta-val">{{ $user?->email ?? '-' }}</span>
                                </div>

                                <div class="cc-meta-row">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                    </svg>
                                    @if($candidate->notes)
                                        <span class="meta-val notes">{{ $candidate->notes }}</span>
                                    @else
                                        <span class="meta-val nil">Tidak ada catatan</span>
                                    @endif
                                </div>

                                <div class="cc-meta-row">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <span class="meta-val">Daftar {{ \Carbon\Carbon::parse($candidate->created_at)->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>

                            <div class="cc-actions">
                                <a href="{{ route('organizer.candidates.show', $candidate->id) }}" class="btn-detail">
                                    Lihat Detail
                                </a>

                                @if($candidate->status === 'pending')
                                    <form method="POST" action="{{ route('organizer.confirm', $candidate->id) }}" style="flex:1;display:flex;">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Terima kandidat ini?')"
                                                class="btn-accept"
                                                style="width:100%;">
                                            Terima
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('organizer.reject', $candidate->id) }}"
                                          style="display:flex;"
                                          onsubmit="return setRejectReason(this)">
                                        @csrf
                                        <input type="hidden" name="reason" value="">
                                        <button type="submit" class="btn-reject">Tolak</button>
                                    </form>

                                @elseif($candidate->status === 'confirmed')
                                    <form method="POST" action="{{ route('organizer.attend', $candidate->id) }}" style="flex:1;display:flex;">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Tandai kandidat ini hadir?')"
                                                class="btn-attend"
                                                style="width:100%;">
                                            Tandai Hadir
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cand-pagination">
                {{ $candidates->links() }}
            </div>
        @endif

    </div>
</div>

<script>
function setRejectReason(form) {
    const reason = prompt('Alasan penolakan (opsional):', '');
    if (reason === null) return false;
    form.querySelector('input[name="reason"]').value = reason;
    return confirm('Tolak kandidat ini?');
}
</script>
@endsection
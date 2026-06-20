@extends('layouts.volunteer')
@section('title', $event->title ?? 'Detail Kegiatan')

@push('styles')
<style>
    body { background-color: #ffffff !important; }

    .detail-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1.5rem 3rem;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        background: #ffffff;
    }

    .detail-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 600;
        color: #6B8CC7;
        text-decoration: none;
        padding: 14px 0 12px;
        transition: color 0.15s;
    }
    .detail-back:hover { color: #1E3A8A; }

.detail-hero {
    width: 100%;
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 1.75rem;
    position: relative;
    display: flex;
    justify-content: center;
    background: transparent;   
}
.detail-hero img {
    width: 100%;
    max-width: 700px;          
    height: 300px;
    object-fit: cover;
    display: block;
    border-radius: 18px;
}
.detail-hero-placeholder {
    width: 100%;
    max-width: 700px;
    height: 300px;
    background: #1E3A8A;
    border-radius: 18px;
    background-image:
        repeating-linear-gradient(
            45deg,
            rgba(59,130,246,0.12) 0px,
            rgba(59,130,246,0.12) 1px,
            transparent 1px,
            transparent 40px
        );
}

@media (max-width: 860px) {
    .detail-hero img,
    .detail-hero-placeholder { height: 200px; max-width: 100%; }
    .detail-title { font-size: 19px; }
}
    
    .detail-hero-badges {
        position: absolute;
        top: 16px;
        left: 16px;
        display: flex;
        gap: 6px;
        z-index: 2;
    }
    .detail-hero-badge {
        font-size: 10px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,0.93);
        color: #1E3A8A;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: 1px solid #93C5FD;
        backdrop-filter: blur(6px);
    }

    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
        align-items: start;
    }
    .left-col { display: flex; flex-direction: column; gap: 14px; }

    .detail-org-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 13px;
        border: 1px solid #BFDBFE;
        border-radius: 10px;
        background: #EFF6FF;
        margin-bottom: 10px;
    }
    .detail-org-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #BFDBFE;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        color: #1E3A8A;
        flex-shrink: 0;
        overflow: hidden;
    }
    .detail-org-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .detail-org-name { font-size: 13px; font-weight: 700; color: #1E3A8A; }
    .detail-cats { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 8px; }
    .detail-cat {
        font-size: 10px;
        font-weight: 700;
        padding: 4px 13px;
        border-radius: 999px;
        border: 1.5px solid #3B82F6;
        color: #3B82F6;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-title {
        font-size: 22px;
        font-weight: 700;
        color: #1E3A8A;
        line-height: 1.3;
        margin: 0 0 4px;
        letter-spacing: -0.3px;
    }

    .detail-info-card {
        border: 1px solid #BFDBFE;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
    }
    .detail-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    .detail-info-cell {
        padding: 14px 16px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border-bottom: 1px solid #BFDBFE;
        border-right: 1px solid #BFDBFE;
        transition: background 0.15s;
    }
    .detail-info-cell:hover { background: #EFF6FF; }
    .detail-info-cell:nth-child(2n) { border-right: none; }
    .detail-info-cell:nth-last-child(-n+2) { border-bottom: none; }
    .detail-info-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: #EFF6FF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #3B82F6;
        border: 1px solid #BFDBFE;
    }
    .detail-info-label {
        font-size: 10px;
        font-weight: 700;
        color: #6B8CC7;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }
    .detail-info-val {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e2d5a;
        line-height: 1.3;
    }
    .detail-info-sub {
        font-size: 11.5px;
        color: #6B8CC7;
        font-weight: 400;
    }

    .detail-section-card {
        border: 1px solid #BFDBFE;
        border-radius: 14px;
        padding: 18px;
        background: #fff;
    }
    .detail-section-label {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #6B8CC7;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .detail-section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #BFDBFE;
    }
    .detail-body-text {
        font-size: 13.5px;
        color: #374151;
        line-height: 1.75;
    }

    .requirement-item {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        border-radius: 9px;
        padding: 11px 14px;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #1e2d5a;
    }
    .requirement-item:last-child { margin-bottom: 0; }
    .requirement-icon {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: #BFDBFE;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1E3A8A;
        flex-shrink: 0;
    }

    .contact-box {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .contact-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #EFF6FF;
        border: 1.5px solid #BFDBFE;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .contact-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e2d5a;
    }
    .contact-phone {
        font-size: 13px;
        color: #3B82F6;
        font-weight: 600;
        margin-top: 2px;
    }
    .contact-phone a { color: #3B82F6; text-decoration: none; }
    .contact-phone a:hover { text-decoration: underline; }
    .right-col { display: flex; flex-direction: column; gap: 14px; }
    .sidebar-card {
        background: #fff;
        border: 1px solid #BFDBFE;
        border-radius: 14px;
        padding: 18px;
    }

    .action-buttons-row { display: flex; gap: 8px; margin-bottom: 14px; }
    .detail-action-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 600;
        border: 1px solid #BFDBFE;
        background: #fff;
        color: #6B8CC7;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }
    .detail-action-btn:hover { background: #EFF6FF; border-color: #93C5FD; color: #1E3A8A; }
    .detail-action-btn.is-active       { border-color: #3B82F6; background: #EFF6FF; color: #1E3A8A; }
    .detail-action-btn.is-active.save-active { border-color: #1E3A8A; color: #1E3A8A; }
    .action-divider { height: 1px; background: #BFDBFE; margin: 0 0 14px; }
    .sidebar-card-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e2d5a;
        margin: 0 0 3px;
    }
    .sidebar-card-sub {
        font-size: 12px;
        color: #6B8CC7;
        margin-bottom: 12px;
    }
    .detail-textarea {
        width: 100%;
        border: 1px solid #BFDBFE;
        border-radius: 9px;
        padding: 11px 13px;
        font-family: inherit;
        font-size: 13px;
        color: #1e2d5a;
        resize: vertical;
        min-height: 80px;
        background: #EFF6FF;
        outline: none;
        line-height: 1.5;
        transition: border-color 0.15s, background 0.15s;
        box-sizing: border-box;
    }
    .detail-textarea:focus { border-color: #60A5FA; background: #fff; }
    .detail-textarea::placeholder { color: #93C5FD; }

    .reg-btn {
        width: 100%;
        margin-top: 12px;
        padding: 13px;
        background: #1E3A8A;
        color: #fff;
        border: none;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: inherit;
        transition: background 0.15s;
    }
    .reg-btn:hover { background: #162d6e; }
    .reg-btn:disabled { background: #BFDBFE; color: #6B8CC7; cursor: not-allowed; }

    .reg-status {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 12px;
        font-size: 13.5px;
        line-height: 1.55;
        margin-bottom: 14px;
    }
    .reg-status svg { flex-shrink: 0; margin-top: 1px; }
    .reg-status.confirmed { background: #E3F5F2; border: 1px solid #A0D9D0; color: #065F46; }
    .reg-status.pending   { background: #FDF5E1; border: 1px solid #F5D98A; color: #7A5700; }
    .reg-status.rejected  { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }
    .reg-status.cancelled { background: #EFF6FF; border: 1px solid #BFDBFE; color: #6B8CC7; }

    .chat-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px;
        background: #1E3A8A;
        color: #fff;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        margin-bottom: 10px;
        transition: background 0.15s;
    }
    .chat-btn:hover { background: #162d6e; }
    .cancel-btn {
        width: 100%;
        padding: 11px;
        background: #FEF2F2;
        color: #991B1B;
        border: 1.5px solid #FECACA;
        border-radius: 9px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: inherit;
        transition: background 0.15s;
    }
    .cancel-btn:hover { background: #FEE2E2; }
    .detail-info-stripe {
        border: 1px solid #BFDBFE;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
    }
    .dis-header {
        background: #1E3A8A;
        padding: 13px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dis-header-txt { font-size: 13px; font-weight: 700; color: #fff; }
    .dis-header-sub { font-size: 11px; color: #93C5FD; margin-top: 1px; }
    .dis-body { padding: 4px 0; }
    .dis-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 16px;
        border-bottom: 1px solid #EFF6FF;
    }
    .dis-row:last-child { border-bottom: none; }
    .dis-ico { font-size: 15px; color: #60A5FA; width: 20px; text-align: center; flex-shrink: 0; }
    .dis-text { font-size: 12.5px; color: #6B8CC7; flex: 1; }
    .dis-val  { font-size: 12.5px; font-weight: 700; color: #1E3A8A; }
    .dis-pill {
        background: #EFF6FF;
        color: #3B82F6;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 999px;
        border: 1px solid #BFDBFE;
    }

    .detail-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        border-radius: 12px;
        font-size: 13.5px;
        margin-bottom: 1rem;
    }
    .detail-alert.success { background: #E3F5F2; border: 1px solid #A0D9D0; color: #065F46; }
    .detail-alert.warning { background: #FEF3C7; border: 1px solid #FCD34D; color: #92400E; }

</style>
@endpush

@section('content')
<div class="detail-wrap">
    @if(session('warning'))
        <div class="detail-alert warning" role="alert">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:2px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong>Jadwal Bertabrakan!</strong><br>
                <span>{{ session('warning') }}</span><br>
                <a href="{{ route('volunteer.schedule') }}" style="font-size:12px;color:#92400E;text-decoration:underline;font-weight:600;">
                    Lihat jadwal saya →
                </a>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="detail-alert success" role="alert">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
                <p style="margin:4px 0 0;font-size:12.5px;opacity:0.8;">Menunggu konfirmasi dari organisasi.</p>
            </div>
        </div>
    @endif
    <a href="{{ route('volunteer.events') }}" class="detail-back">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke daftar kegiatan
    </a>

    <div class="detail-hero">
        @if(isset($event->poster) && $event->poster)
            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
        @else
            <div class="detail-hero-placeholder"></div>
        @endif
    </div>

    @php
        $orgName    = $event->organization->organization_name ?? 'Organisasi';
        $orgInitial = strtoupper(substr($orgName, 0, 1));
    @endphp
    <div class="detail-layout">
        <div class="left-col">
            <div>
                <div class="detail-org-row">
                    <div class="detail-org-avatar">
                        @if(isset($event->organization->logo))
                            <img src="{{ asset('storage/' . $event->organization->logo) }}" alt="Logo">
                        @elseif(isset($event->organization->foto))
                            <img src="{{ asset('storage/' . $event->organization->foto) }}" alt="Foto">
                        @else
                            {{ $orgInitial }}
                        @endif
                    </div>
                    <span class="detail-org-name">{{ $orgName }}</span>
                </div>

                <div class="detail-cats">
                    @if(isset($event->categories) && count($event->categories) > 0)
                        @foreach($event->categories as $cat)
                            <span class="detail-cat">{{ $cat->name }}</span>
                        @endforeach
                    @else
                        <span class="detail-cat">Umum</span>
                    @endif
                </div>

                <h1 class="detail-title">{{ $event->title ?? 'Judul Kegiatan' }}</h1>
            </div>

            <div class="detail-info-card">
                <div class="detail-info-grid">
                    <div class="detail-info-cell">
                        <div class="detail-info-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="detail-info-label">Tanggal</div>
                            <div class="detail-info-val">
                                {{ isset($event->start_date) ? $event->start_date->format('d M Y') : '-' }}
                                @if(isset($event->start_date) && isset($event->end_date) && $event->start_date->format('Y-m-d') !== $event->end_date->format('Y-m-d'))
                                    <div class="detail-info-sub">s/d {{ $event->end_date->format('d M Y') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="detail-info-cell">
                        <div class="detail-info-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="detail-info-label">Waktu</div>
                            <div class="detail-info-val">
                                @if(isset($event->start_time))
                                    {{ $event->start_time }}@if(isset($event->end_time)) &mdash; {{ $event->end_time }}@endif
                                @else
                                    &mdash;
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="detail-info-cell">
                        <div class="detail-info-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="detail-info-label">Lokasi</div>
                            <div class="detail-info-val">{{ $event->location_name ?? 'Belum Ditentukan' }}</div>
                            @if(isset($event->city))
                                <div class="detail-info-sub">{{ $event->city }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="detail-info-cell">
                        <div class="detail-info-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="detail-info-label">Kuota</div>
                            <div class="detail-info-val" @if($event->isFull()) style="color:#EF4444" @else style="color:#166534" @endif>
                                @if($event->isFull())
                                    Penuh ({{ $event->quota }}/{{ $event->quota }})
                                @else
                                    {{ $event->remainingQuota() }} Spot Left
                                @endif
                            </div>
                            <div class="detail-info-sub">Total kuota {{ $event->quota }}</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="detail-section-card">
                <div class="detail-section-label">Tentang kegiatan</div>
                <div class="detail-body-text">
                    @if(isset($event->description))
                        {!! nl2br(e($event->description)) !!}
                    @else
                        Deskripsi kegiatan belum ditambahkan.
                    @endif
                </div>
            </div>
            <div class="detail-section-card">
                <div class="detail-section-label">Syarat ketentuan</div>
                @if(isset($event->requirements) && !empty($event->requirements))
                    @php
                        $requirementLines = collect(explode("\n", $event->requirements))
                            ->map(fn($line) => trim($line))
                            ->filter();
                    @endphp
                    @foreach($requirementLines as $line)
                        <div class="requirement-item">
                            <div class="requirement-icon">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span>{{ $line }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="requirement-item">
                        <div class="requirement-icon"></div>
                        <span>Syarat dan ketentuan belum ditambahkan.</span>
                    </div>
                @endif
            </div>
            @if(isset($event->contact_person))
                <div class="detail-section-card">
                    <div class="detail-section-label">Kontak</div>
                    <div class="contact-box">
                        <div class="contact-avatar">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="contact-name">{{ $event->contact_person }}</div>
                            @if(isset($event->contact_phone))
                                <div class="contact-phone">
                                    <a href="tel:{{ $event->contact_phone }}">{{ $event->contact_phone }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <div class="right-col">
            <div class="sidebar-card">
                <div class="action-buttons-row">
                    <button id="btn-like"
                            data-event-id="{{ $event->id }}"
                            data-liked="{{ $isLiked ? 'true' : 'false' }}"
                            class="detail-action-btn {{ $isLiked ? 'is-active' : '' }}">
                        <svg id="icon-like" width="15" height="15"
                             fill="{{ $isLiked ? 'currentColor' : 'none' }}"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span id="text-like">{{ $isLiked ? 'Disukai' : 'Suka' }}</span>
                    </button>

                    <button id="btn-save"
                            data-event-id="{{ $event->id }}"
                            data-saved="{{ $isSaved ? 'true' : 'false' }}"
                            class="detail-action-btn {{ $isSaved ? 'is-active save-active' : '' }}">
                        <svg id="icon-save" width="15" height="15"
                             fill="{{ $isSaved ? 'currentColor' : 'none' }}"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        <span id="text-save">{{ $isSaved ? 'Disimpan' : 'Simpan' }}</span>
                    </button>
                </div>

                <div class="action-divider"></div>
                @if(isset($registrasi) && $registrasi->status === 'confirmed')

                    <div class="reg-status confirmed">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <strong>Pendaftaran dikonfirmasi</strong>
                            <p style="margin:3px 0 0;font-size:12px;opacity:0.8;">
                                Terdaftar sejak {{ $registrasi->registered_at->format('d M Y') }}. Hadir tepat waktu.
                            </p>
                        </div>
                    </div>

                    @if(isset($registrasi->chatRoom))
                        <a href="{{ route('volunteer.chat.show', $registrasi->chatRoom) }}" class="chat-btn">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Buka Chat dengan Organisasi
                        </a>
                    @endif

                    <form action="{{ route('volunteer.cancel', $event->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin membatalkan pendaftaran?')">
                        @csrf
                        <button type="submit" class="cancel-btn">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Batalkan Pendaftaran
                        </button>
                    </form>

                @elseif(isset($registrasi) && $registrasi->status === 'pending')

                    <div class="reg-status pending">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <div>
                            <strong>Menunggu konfirmasi</strong>
                            <p style="margin:3px 0 0;font-size:12px;opacity:0.8;">Pendaftaranmu sudah diterima. Organisasi akan segera meninjau.</p>
                        </div>
                    </div>

                @elseif(isset($registrasi) && $registrasi->status === 'rejected')

                    <div class="reg-status rejected">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <strong>Pendaftaran tidak diterima</strong>
                            <p style="margin:3px 0 0;font-size:12px;opacity:0.8;">Coba kegiatan lain yang sesuai denganmu.</p>
                        </div>
                    </div>

                @elseif(isset($registrasi) && $registrasi->status === 'cancelled')

                    <div class="reg-status cancelled">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <span>Kamu pernah membatalkan pendaftaran di kegiatan ini.</span>
                    </div>

                @elseif(isset($event) && $event->isFull())

                    <button class="reg-btn" disabled>Kuota Penuh</button>

                @else

                    <div class="sidebar-card-title">Daftar Kegiatan Ini</div>
                    <div class="sidebar-card-sub">Catatan untuk organisasi (opsional)</div>

                    <form action="{{ route('volunteer.register', $event->id) }}" method="POST" id="regForm">
                        @csrf
                        <textarea id="reg-notes" name="notes"
                                  class="detail-textarea"
                                  placeholder="Ceritakan ketertarikanmu pada kegiatan ini…"></textarea>
                        <button type="submit" class="reg-btn" id="regSubmit">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span id="regBtnText">Daftar Kegiatan</span>
                        </button>
                    </form>

                @endif

            </div>
            <div class="detail-info-stripe">
                <div class="dis-header">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="2">
                        <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <div class="dis-header-txt">Info Kegiatan</div>
                        <div class="dis-header-sub">Detail tambahan program ini</div>
                    </div>
                </div>
                <div class="dis-body">
                    <div class="dis-row">
                        <svg class="dis-ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span class="dis-text">Dibuka sejak</span>
                        <span class="dis-val">{{ isset($event->created_at) ? $event->created_at->format('d M Y') : '-' }}</span>
                    </div>
                    <div class="dis-row">
                        <svg class="dis-ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span class="dis-text">Durasi program</span>
                        <span class="dis-val">
                            @if(isset($event->start_date) && isset($event->end_date))
                                {{ $event->start_date->diffInDays($event->end_date) + 1 }} hari
                            @else
                                &mdash;
                            @endif
                        </span>
                    </div>
                    <div class="dis-row">
                        <svg class="dis-ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        <span class="dis-text">Mode kegiatan</span>
                        <span class="dis-pill">{{ $event->mode ?? 'Offline' }}</span>
                    </div>
                    <div class="dis-row">
                        <svg class="dis-ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        <span class="dis-text">Sudah mendaftar</span>
                        <span class="dis-val">{{ $event->registrations_count ?? $event->registrations()->count() }} relawan</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var form    = document.getElementById('regForm');
    var btn     = document.getElementById('regSubmit');
    var btnText = document.getElementById('regBtnText');
    if (!form || !btn) return;
    form.addEventListener('submit', function () {
        btn.disabled = true;
        if (btnText) btnText.textContent = 'Mendaftarkan…';
    });
})();

document.getElementById('btn-like')?.addEventListener('click', async function () {
    const id  = this.dataset.eventId;
    const res = await fetch(`/volunteer/events/${id}/like`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    const data  = await res.json();
    const liked = data.liked;
    this.dataset.liked = liked;
    document.getElementById('icon-like').setAttribute('fill', liked ? 'currentColor' : 'none');
    document.getElementById('text-like').textContent = liked ? 'Disukai' : 'Suka';
    this.classList.toggle('is-active', liked);
});

document.getElementById('btn-save')?.addEventListener('click', async function () {
    const id  = this.dataset.eventId;
    const res = await fetch(`/volunteer/events/${id}/save`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    });
    const data  = await res.json();
    const saved = data.saved;
    this.dataset.saved = saved;
    document.getElementById('icon-save').setAttribute('fill', saved ? 'currentColor' : 'none');
    document.getElementById('text-save').textContent = saved ? 'Disimpan' : 'Simpan';
    this.classList.toggle('is-active', saved);
    this.classList.toggle('save-active', saved);
});
</script>
@endpush
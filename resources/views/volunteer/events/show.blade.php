@extends('layouts.volunteer')
@section('title', $event->title ?? 'Detail Kegiatan')

@push('styles')
<style>
    /* Mengubah background halaman menjadi putih penuh */
    body {
        background-color: #ffffff !important;
    }

    .detail-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem 1.5rem 3rem;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: #ffffff;
    }

    /* Back Button */
    .detail-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 600;
        color: #5A6278;
        text-decoration: none;
        margin-bottom: 1.5rem;
        padding: 4px 0;
        transition: color 0.15s;
    }
    .detail-back:hover {
        color: #0F2057;
    }

    /* Hero Banner */
    .detail-hero {
        width: 100%;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.75rem;
        border: 1px solid #EEF0F6;
    }
    .detail-hero img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        display: block;
    }
    .detail-hero-placeholder {
        height: 260px;
        background-color: #FCE7EE;
        background-image:
            linear-gradient(45deg, #FBD5E3 25%, transparent 25%),
            linear-gradient(-45deg, #FBD5E3 25%, transparent 25%),
            linear-gradient(45deg, transparent 75%, #FBD5E3 75%),
            linear-gradient(-45deg, transparent 75%, #FBD5E3 75%);
        background-size: 56px 56px;
        background-position: 0 0, 0 28px, 28px -28px, -28px 0;
    }

    /* Layout Grid */
    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 1.75rem;
        align-items: start;
    }

    /* Content Cards */
    .detail-content-card {
        background: #fff;
        border: 1px solid #D8DCE8;
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .detail-content-card:last-child {
        margin-bottom: 0;
    }

    .detail-section-title {
        font-size: 13px;
        font-weight: 800;
        color: #1A1F2E;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-top: 0;
        margin-bottom: 16px;
    }

    /* Info List */
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .info-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 0;
        border-bottom: 1px solid #EEF0F6;
    }
    .info-item:first-child { padding-top: 0; }
    .info-item:last-child { border-bottom: none; padding-bottom: 0; }
    
    .info-icon {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        background: #D8DCE8;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #5A6278;
    }
    .info-label {
        font-size: 11px;
        color: #9099B0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0 0 2px 0;
    }
    .info-val {
        font-weight: 700;
        color: #1A1F2E;
        font-size: 14px;
        margin: 0;
    }
    .info-sub {
        font-size: 12.5px;
        color: #5A6278;
        font-weight: 400;
    }

    /* Tentang */
    .detail-body-text {
        font-size: 14px;
        color: #374151;
        line-height: 1.7;
    }

    /* Syarat Ketentuan */
    .syarat-title-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }
    .syarat-title-wrapper .detail-section-title {
        margin-bottom: 0;
        flex-shrink: 0;
    }
    .syarat-divider {
        flex: 1;
        height: 1px;
        background: #D8DCE8;
    }
    .syarat-container {
        border: 1px solid #D8DCE8;
        border-radius: 14px;
        padding: 1.25rem;
        background: #fff;
    }
    .requirement-item {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #F2F3F5;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 12px;
        font-size: 13.5px;
        color: #1A1F2E;
        font-weight: 600;
    }
    .requirement-item:last-child { margin-bottom: 0; }
    .requirement-icon {
        width: 28px;
        height: 28px;
        flex-shrink: 0;
        background: #D8DCE0;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #71717A;
    }

    /* Contact Section */
    .contact-box {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 14px;
        font-weight: 600;
        color: #1A1F2E;
    }
    .contact-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #E9EAED;
        background-image:
            linear-gradient(45deg, #D5D7DC 25%, transparent 25%),
            linear-gradient(-45deg, #D5D7DC 25%, transparent 25%),
            linear-gradient(45deg, transparent 75%, #D5D7DC 75%),
            linear-gradient(-45deg, transparent 75%, #D5D7DC 75%);
        background-size: 10px 10px;
        background-position: 0 0, 0 5px, 5px -5px, -5px 0;
        flex-shrink: 0;
    }
    .contact-box a { color: #E8501A; text-decoration: none; }
    .contact-box a:hover { text-decoration: underline; }

    /* Sidebar Cards */
    .sidebar-card {
        background: #fff;
        border: 1px solid #D8DCE8;
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
    }
    .sidebar-card.bg-gray {
        background: #F3F4F6;
        border: 1px solid #D8DCE8;
    }
    .sidebar-card:last-child { margin-bottom: 0; }

    /* Title & Organization Info Block */
    .detail-title {
        font-size: 20px;
        font-weight: 700;
        color: #0F2057;
        line-height: 1.35;
        margin-top: 0;
        margin-bottom: 12px;
    }
    .detail-cats { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }
    .detail-cat {
        font-size: 10px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 999px;
        background: #fff;
        color: #0F2057;
        border: 1px solid #0F2057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .detail-org-row {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fff;
        border: 1px solid #9CA3AF;
        border-radius: 8px;
        padding: 10px 12px;
        margin-bottom: 16px;
    }
    .detail-org-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #D8DCE8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #5A6278;
        flex-shrink: 0;
        overflow: hidden;
    }
    .detail-org-name { font-size: 13px; font-weight: 700; color: #0F2057; }

    /* Action Buttons Row */
    .action-buttons-row {
        display: flex;
        gap: 10px;
    }
    .detail-action-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
        border: 1px solid #9CA3AF;
        background: #fff;
        color: #5A6278;
        cursor: pointer;
        transition: all 0.15s;
    }
    .detail-action-btn:hover { background: #F8F9FC; }
    .detail-action-btn.is-active { border-color: #E8501A; color: #E8501A; font-weight: 700; }
    .detail-action-btn.is-active.save-active { border-color: #0F2057; color: #0F2057; font-weight: 700; }

    /* Registration Section */
    .sidebar-card-title {
        font-size: 15px;
        font-weight: 700;
        color: #1A1F2E;
        margin-top: 0;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .sidebar-card-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #EEF0F6;
    }
    .sidebar-card-sub {
        font-size: 12.5px;
        color: #5A6278;
        margin-top: 4px;
        margin-bottom: 14px;
    }

    .detail-textarea {
        width: 100%; border: 1px solid #D8DCE8;
        border-radius: 8px; padding: 12px;
        font-family: inherit; font-size: 13.5px; color: #1A1F2E;
        resize: vertical; min-height: 84px;
        outline: none; transition: border-color 0.15s;
        margin-bottom: 14px;
        box-sizing: border-box;
    }
    .detail-textarea:focus { border-color: #1A3575; }
    .detail-textarea::placeholder { color: #9099B0; }

    .reg-btn {
        width: 100%; padding: 12px;
        background: #E8501A; color: #fff;
        border-radius: 8px; font-size: 14px; font-weight: 700;
        border: none; cursor: pointer;
        transition: background 0.15s, transform 0.15s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .reg-btn:hover { background: #F5773D; }
    .reg-btn:disabled { background: #D8DCE8; color: #9099B0; cursor: not-allowed; }

    /* Alerts and Status Cards */
    .reg-status {
        display: flex; align-items: flex-start; gap: 12px;
        padding: 14px 16px; border-radius: 12px;
        font-size: 13.5px; line-height: 1.55; margin-bottom: 14px;
    }
    .reg-status svg { flex-shrink: 0; margin-top: 1px; }
    .reg-status.confirmed { background: #E3F5F2; border: 1px solid #A0D9D0; color: #065F46; }
    .reg-status.pending   { background: #FDF5E1; border: 1px solid #F5D98A; color: #7A5700; }
    .reg-status.rejected  { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }
    .reg-status.cancelled { background: #F8F9FC; border: 1px solid #EEF0F6; color: #5A6278; }

    .cancel-btn {
        width: 100%; padding: 11px;
        background: #FEF2F2; color: #991B1B;
        border: 1.5px solid #FECACA;
        border-radius: 12px; font-size: 13.5px; font-weight: 600;
        cursor: pointer; transition: background 0.15s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .cancel-btn:hover { background: #FEE2E2; }

    .detail-alert {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 14px 16px; border-radius: 12px;
        font-size: 13.5px; margin-bottom: 1.5rem;
    }
    .detail-alert.success { background: #E3F5F2; border: 1px solid #A0D9D0; color: #065F46; }

    @media (max-width: 860px) {
        .detail-layout { grid-template-columns: 1fr; }
        .detail-hero img, .detail-hero-placeholder { height: 180px; }
    }
</style>
@endpush

@section('content')
<div class="detail-wrap">
    {{-- Alerts Notification --}}
    @if(session('warning'))
        <div class="ak-alert ak-alert-warning" role="alert" style="margin-bottom:1rem; display: flex; gap: 10px; background: #FEF3C7; border: 1px solid #FCD34D; padding: 14px; border-radius: 12px; color: #92400E; font-size: 13.5px;">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top: 2px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <strong>Jadwal Bertabrakan!</strong><br>
                <span>{{ session('warning') }}</span>
                <br>
                <a href="{{ route('volunteer.schedule') }}" style="font-size:12px;color:#92400E;text-decoration:underline; font-weight: 600;">
                    Lihat jadwal saya →
                </a>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="detail-alert success" role="alert">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
                <p style="margin:4px 0 0; font-size:12.5px; opacity:0.8;">Menunggu konfirmasi dari organisasi.</p>
            </div>
        </div>
    @endif

    {{-- Back Link --}}
    <a href="{{ route('volunteer.events') }}" class="detail-back">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke daftar kegiatan
    </a>

    {{-- Hero Poster Block --}}
    <div class="detail-hero">
        @if(isset($event->poster) && $event->poster)
            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
        @else
            <div class="detail-hero-placeholder"></div>
        @endif
    </div>

    @php
        $orgName = $event->organization->organization_name ?? 'Organisasi';
        $orgInitial = strtoupper(substr($orgName, 0, 1));
    @endphp

    {{-- Core Layout Grid --}}
    <div class="detail-layout">

        {{-- Left Column (Information Panels) --}}
        <div class="left-col">
            
            {{-- Box 1: Info Metrics --}}
            <div class="detail-content-card">
                <ul class="info-list">
                    <li class="info-item">
                        <div class="info-icon">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="info-label">Tanggal</p>
                            <p class="info-val">{{ isset($event->start_date) ? $event->start_date->format('d:m:Y') : '-' }}
                                @if(isset($event->start_date) && isset($event->end_date) && $event->start_date->format('Y-m-d') !== $event->end_date->format('Y-m-d'))
                                    <span class="info-sub"> — {{ $event->end_date->format('d:m:Y') }}</span>
                                @endif
                            </p>
                        </div>
                    </li>
                    <li class="info-item">
                        <div class="info-icon">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="info-label">Waktu</p>
                            <p class="info-val">
                                @if(isset($event->start_time))
                                    {{ $event->start_time }}@if(isset($event->end_time)) &mdash; {{ $event->end_time }}@endif
                                @else
                                    &mdash;
                                @endif
                            </p>
                        </div>
                    </li>
                    <li class="info-item">
                        <div class="info-icon">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="info-label">Lokasi</p>
                            <p class="info-val">{{ $event->location_name ?? 'Lokasi Belum Ditentukan' }}</p>
                        </div>
                    </li>
                    <li class="info-item">
                        <div class="info-icon">
                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <p class="info-label">Kuota</p>
                            <p class="info-val" style="{{ $event->isFull() ? 'color:#EF4444' : '' }}">
                                @if($event->isFull()) 
                                    Penuh ({{ $event->quota }}/{{ $event->quota }})
                                @else 
                                    {{ $event->remainingQuota() }} Spot Left
                                @endif
                            </p>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Box 2: Tentang Kegiatan --}}
            <div class="detail-content-card">
                <h2 class="detail-section-title">Tentang</h2>
                <div class="detail-body-text">
                    @if(isset($event->description))
                        {!! nl2br(e($event->description)) !!}
                    @else
                        Deskripsi kegiatan belum ditambahkan.
                    @endif
                </div>
            </div>

            {{-- Box 3: Syarat Ketentuan --}}
            <div style="margin-bottom: 1.5rem;">
                <div class="syarat-title-wrapper">
                    <h2 class="detail-section-title">Syarat Ketentuan</h2>
                    <div class="syarat-divider"></div>
                </div>
                <div class="syarat-container">
                    @if(isset($event->requirements) && !empty($event->requirements))
                        @php
                            $requirementLines = collect(explode("\n", $event->requirements))
                                ->map(fn($line) => trim($line))
                                ->filter();
                        @endphp
                        @foreach($requirementLines as $line)
                            <div class="requirement-item">
                                <div class="requirement-icon">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span>{{ $line }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="requirement-item"><div class="requirement-icon"></div><span>Syarat dan ketentuan belum ditambahkan</span></div>
                    @endif
                </div>
            </div>

            {{-- Box 4: Contact Box --}}
            @if(isset($event->contact_person))
                <div class="detail-content-card">
                    <h2 class="detail-section-title">Contact</h2>
                    <div class="contact-box">
                        <div class="contact-avatar"></div>
                        <span>
                            {{ $event->contact_person }}
                            @if(isset($event->contact_phone))
                                - <a href="tel:{{ $event->contact_phone }}">{{ $event->contact_phone }}</a>
                            @endif
                        </span>
                    </div>
                </div>
            @endif

        </div>

        {{-- Right Column (Sidebar Core Controls) --}}
        <div class="right-col">
            
            {{-- Box 1 (Gray Background Panel): Title, Org & Quick Actions --}}
            <div class="sidebar-card bg-gray">
                <h1 class="detail-title">{{ $event->title ?? 'Judul Kegiatan' }}</h1>

                <div class="detail-cats">
                    @if(isset($event->categories) && count($event->categories) > 0)
                        @foreach($event->categories as $cat)
                            <span class="detail-cat">{{ $cat->name }}</span>
                        @endforeach
                    @else
                        <span class="detail-cat">Umum</span>
                    @endif
                </div>

                <div class="detail-org-row">
                    <div class="detail-org-avatar">
                        @if(isset($event->organization->logo))
                            <img src="{{ asset('storage/' . $event->organization->logo) }}" alt="Logo Organisasi" style="width: 100%; height: 100%; object-fit: cover;">
                        @elseif(isset($event->organization->foto))
                            <img src="{{ asset('storage/' . $event->organization->foto) }}" alt="Foto Organisasi" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ $orgInitial }}
                        @endif
                    </div>
                    <span class="detail-org-name">{{ $orgName }}</span>
                </div>

                <div class="action-buttons-row">
                    <button id="btn-like"
                            data-event-id="{{ $event->id }}"
                            data-liked="{{ $isLiked ? 'true' : 'false' }}"
                            class="detail-action-btn {{ $isLiked ? 'is-active' : '' }}">
                        <svg id="icon-like" width="15" height="15" fill="{{ $isLiked ? 'currentColor' : 'none' }}"
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
                        <svg id="icon-save" width="15" height="15" fill="{{ $isSaved ? 'currentColor' : 'none' }}"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        <span id="text-save">{{ $isSaved ? 'Disimpan' : 'Simpan' }}</span>
                    </button>
                </div>
            </div>

            {{-- Box 2 (White Background Panel): Registration Status Forms --}}
            <div class="sidebar-card">

                {{-- Status Handling Logic Conditions --}}
                @if(isset($registrasi) && $registrasi->status === 'confirmed')
                    <div class="reg-status confirmed">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <strong>Pendaftaran dikonfirmasi</strong>
                            <p style="margin:3px 0 0; font-size:12px; opacity:0.8;">Terdaftar sejak {{ $registrasi->registered_at->format('d M Y') }}. Hadir tepat waktu sesuai jadwal.</p>
                        </div>
                    </div>

                    @if(isset($registrasi->chatRoom))
                        <a href="{{ route('volunteer.chat.show', $registrasi->chatRoom) }}"
                           style="display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:12px; background:#0F2057; color:#fff; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none; margin-bottom:10px; transition:background 0.15s;"
                           onmouseover="this.style.background='#1A3575'" onmouseout="this.style.background='#0F2057'">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Buka Chat dengan Organisasi
                        </a>
                    @endif

                    <form action="{{ route('volunteer.cancel', $event->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pendaftaran?')">
                        @csrf
                        <button type="submit" class="cancel-btn">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Batalkan Pendaftaran
                        </button>
                    </form>

                @elseif(isset($registrasi) && $registrasi->status === 'pending')
                    <div class="reg-status pending">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div>
                            <strong>Menunggu konfirmasi</strong>
                            <p style="margin:3px 0 0; font-size:12px; opacity:0.8;">Pendaftaranmu sudah diterima. Organisasi akan segera meninjau.</p>
                        </div>
                    </div>

                @elseif(isset($registrasi) && $registrasi->status === 'rejected')
                    <div class="reg-status rejected">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <strong>Pendaftaran tidak diterima</strong>
                            <p style="margin:3px 0 0; font-size:12px; opacity:0.8;">Coba kegiatan lain yang sesuai denganmu.</p>
                        </div>
                    </div>

                @elseif(isset($registrasi) && $registrasi->status === 'cancelled')
                    <div class="reg-status cancelled">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        <span>Kamu pernah membatalkan pendaftaran di kegiatan ini.</span>
                    </div>

                @elseif(isset($event) && $event->isFull())
                    <button class="reg-btn" disabled>Kuota Penuh</button>

                @else
                    {{-- Default Registration Active Form State --}}
                    <p class="sidebar-card-title">Daftar Kegiatan Ini</p>
                    <p class="sidebar-card-sub">Catatan untuk organisasi (opsional)</p>
                    <form action="{{ route('volunteer.register', $event->id) }}" method="POST" id="regForm">
                        @csrf
                        <textarea id="reg-notes" name="notes" class="detail-textarea" placeholder="Ceritakan ketertarikanmu pada kegiatan ini…"></textarea>
                        <button type="submit" class="reg-btn" id="regSubmit">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span id="regBtnText">Daftar Kegiatan</span>
                        </button>
                    </form>
                @endif

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
    const id   = this.dataset.eventId;
    const res  = await fetch(`/volunteer/events/${id}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    const data = await res.json();
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
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    const data = await res.json();
    const saved = data.saved;

    this.dataset.saved = saved;
    document.getElementById('icon-save').setAttribute('fill', saved ? 'currentColor' : 'none');
    document.getElementById('text-save').textContent = saved ? 'Disimpan' : 'Simpan';
    this.classList.toggle('is-active', saved);
    this.classList.toggle('save-active', saved);
});
</script>
@endpush
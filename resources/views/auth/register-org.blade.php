@extends('layouts.guest')
@section('title', 'Daftarkan Organisasi')

@push('styles')
<style>
/* ── Layout utama: dua kolom ── */
.auth-register-wrap {
    min-height: calc(100vh - var(--spacing-navbar));
    display: flex;
    align-items: stretch;
    background: var(--color-bg);
}

/* ── Panel kiri: branding ── */
.auth-brand-panel {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 420px;
    min-width: 380px;
    background: linear-gradient(160deg, #1E3A8A 0%, #1D4ED8 60%, #2563EB 100%);
    padding: 48px 40px;
    position: relative;
    overflow: hidden;
}

.auth-brand-panel::before {
    content: '';
    position: absolute;
    width: 340px;
    height: 340px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    top: -80px;
    right: -80px;
    pointer-events: none;
}

.auth-brand-panel::after {
    content: '';
    position: absolute;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    bottom: -60px;
    left: -60px;
    pointer-events: none;
}

.auth-brand-logo {
    width: 160px;
    height: 160px;
    object-fit: contain;
    position: relative;
    z-index: 1;
    margin-bottom: 28px;
}

.auth-brand-name {
    font-family: var(--font-display);
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.03em;
    margin-bottom: 12px;
    position: relative;
    z-index: 1;
}

.auth-brand-tagline {
    font-size: 0.9375rem;
    color: #BFDBFE;
    text-align: center;
    line-height: 1.6;
    position: relative;
    z-index: 1;
    max-width: 260px;
    margin-bottom: 0;
}

/* ── Panel kanan: form ── */
.auth-form-panel {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 24px;
    overflow-y: auto;
}

/* ── Box form ── */
.auth-register-box {
    width: 100%;
    max-width: 560px;
    background: var(--color-surface);
    border: 1.5px solid var(--color-border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.auth-register-header {
    background: linear-gradient(135deg, #1E3A8A 0%, #1D4ED8 60%, #2563EB 100%);
    padding: 32px 36px 28px;
    position: relative;
    overflow: hidden;
}

.auth-register-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,0.07) 1px, transparent 1px);
    background-size: 24px 24px;
    pointer-events: none;
}

.auth-register-header::after {
    content: '';
    position: absolute;
    top: -24px;
    right: -24px;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}

.auth-register-header__back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8125rem;
    color: rgba(191, 219, 254, 0.8);
    text-decoration: none;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
    transition: color 0.15s;
}

.auth-register-header__back:hover { color: #fff; }

.auth-register-header__badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 999px;
    padding: 4px 12px 4px 8px;
    font-size: 0.75rem;
    font-weight: 600;
    color: rgba(255,255,255,0.9);
    margin-bottom: 14px;
    position: relative;
    z-index: 1;
    width: fit-content;
}

.auth-register-header h1 {
    font-family: var(--font-display);
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.025em;
    margin-bottom: 6px;
    position: relative;
    z-index: 1;
}

.auth-register-header p {
    font-size: 0.875rem;
    color: #BFDBFE;
    position: relative;
    z-index: 1;
    margin: 0;
    line-height: 1.55;
}

.auth-verify-notice {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #FFF7ED;
    border: 1px solid #FED7AA;
    border-radius: var(--radius-md);
    padding: 12px 14px;
    margin-bottom: 24px;
    font-size: 0.8125rem;
    color: #92400E;
    line-height: 1.5;
}

.auth-verify-notice svg { flex-shrink: 0; margin-top: 1px; color: #D97706; }

.auth-register-body {
    padding: 32px 36px 36px;
}

.auth-section-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--color-ink-muted);
    margin-bottom: 16px;
    margin-top: 28px;
}

.auth-section-label:first-child { margin-top: 0; }

.auth-section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--color-border);
}

.ak-input-wrap { position: relative; }
.ak-input-wrap .ak-input { padding-right: 44px; }

.ak-input-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    color: var(--color-ink-muted);
    display: flex;
    align-items: center;
    border-radius: 4px;
    transition: color 0.15s;
}
.ak-input-toggle:hover { color: var(--color-navy); }

.ak-char-counter {
    font-size: 0.75rem;
    color: var(--color-ink-muted);
    text-align: right;
    margin-top: 4px;
    display: block;
}

.ak-char-counter.warn { color: #D97706; }
.ak-char-counter.over { color: var(--color-danger); }

/* ── Responsive ── */
@media (min-width: 900px) {
    .auth-brand-panel { display: flex; }
    .auth-register-header__back { display: none; }
}

@media (max-width: 899px) {
    .auth-register-wrap { align-items: flex-start; }
    .auth-form-panel    { padding: 32px 16px 48px; }
}

@media (max-width: 540px) {
    .auth-register-header { padding: 28px 24px 24px; }
    .auth-register-body   { padding: 24px 24px 28px; }
}
</style>
@endpush

@section('content')
<div class="auth-register-wrap">

    {{-- Panel kiri: branding (tampil di layar ≥900px) --}}
    <aside class="auth-brand-panel" aria-hidden="true">
        <img
            src="{{ asset('images/logo_aksikita.png') }}"
            alt="Logo AksiKita"
            class="auth-brand-logo"
        >
        <span class="auth-brand-name">AksiKita</span>
        <p class="auth-brand-tagline">
            Platform penghubung organisasi sosial dengan relawan terbaik di seluruh Indonesia.
        </p>
    </aside>

    {{-- Panel kanan: form registrasi organisasi --}}
    <div class="auth-form-panel">
        <div class="auth-register-box">

            <div class="auth-register-header">
                <a href="{{ route('home') }}" class="auth-register-header__back" aria-label="Kembali ke beranda">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>

                <div class="auth-register-header__badge">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Untuk Organisasi &amp; NGO
                </div>

                <h1>Daftarkan Organisasi Anda</h1>
                <p>Rekrut relawan, kelola kegiatan sosial, dan perluas dampak Anda bersama komunitas AksiKita.</p>
            </div>
        <div class="auth-register-body">

            <div class="auth-verify-notice" role="note">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>
                    <strong>Perlu verifikasi admin.</strong>
                    Akun Anda akan ditinjau sebelum dapat membuat dan mempublikasikan kegiatan.
                </span>
            </div>

            @if($errors->any())
                <div class="ak-alert ak-alert-danger" role="alert" style="margin-bottom:24px;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:1px;" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <strong style="display:block; margin-bottom:4px;">Mohon perbaiki kesalahan berikut:</strong>
                        <ul style="margin:0; padding-left:16px;">
                            @foreach($errors->all() as $error)
                                <li style="font-size:0.875rem;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('register.organizer.post') }}" method="POST" id="registerOrgForm" novalidate>
                @csrf
                <div class="auth-section-label">Data Akun (Person in Charge)</div>

                <div style="display:flex; flex-direction:column; gap:16px;">

                    <div class="ak-form-group">
                        <label for="name" class="ak-label">
                            Nama Lengkap (PIC)
                            <span class="required" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Nama penanggung jawab akun ini"
                            autocomplete="name"
                            required
                            class="ak-input @error('name') error @enderror"
                            aria-describedby="@error('name')name-error @enderror"
                        >
                        @error('name')
                            <span class="ak-input-error" id="name-error" role="alert">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="ak-form-group">
                        <label for="email" class="ak-label">
                            Alamat Email
                            <span class="required" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="email@organisasi.org"
                            autocomplete="email"
                            required
                            class="ak-input @error('email') error @enderror"
                            aria-describedby="@error('email')email-error @enderror"
                        >
                        @error('email')
                            <span class="ak-input-error" id="email-error" role="alert">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">

                        <div class="ak-form-group">
                            <label for="password" class="ak-label">
                                Password
                                <span class="required" aria-hidden="true">*</span>
                            </label>
                            <div class="ak-input-wrap">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Min. 8 karakter"
                                    autocomplete="new-password"
                                    required
                                    class="ak-input @error('password') error @enderror"
                                    aria-describedby="@error('password')pass-error @enderror"
                                >
                                <button type="button" class="ak-input-toggle" id="togglePass"
                                        aria-label="Tampilkan password" tabindex="-1">
                                    <svg id="eyeOff1" width="17" height="17" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                    <svg id="eyeOn1" width="17" height="17" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2" aria-hidden="true" style="display:none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="ak-input-error" id="pass-error" role="alert">
                                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="ak-form-group">
                            <label for="password_confirmation" class="ak-label">
                                Konfirmasi Password
                                <span class="required" aria-hidden="true">*</span>
                            </label>
                            <div class="ak-input-wrap">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    autocomplete="new-password"
                                    required
                                    class="ak-input"
                                >
                                <button type="button" class="ak-input-toggle" id="togglePassConf"
                                        aria-label="Tampilkan konfirmasi password" tabindex="-1">
                                    <svg id="eyeOff2" width="17" height="17" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                    <svg id="eyeOn2" width="17" height="17" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2" aria-hidden="true" style="display:none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="auth-section-label">Data Organisasi</div>

                <div style="display:flex; flex-direction:column; gap:16px;">

                    <div class="ak-form-group">
                        <label for="organization_name" class="ak-label">
                            Nama Organisasi
                            <span class="required" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="text"
                            id="organization_name"
                            name="organization_name"
                            value="{{ old('organization_name') }}"
                            placeholder="Contoh: Yayasan Peduli Anak Indonesia"
                            autocomplete="organization"
                            required
                            class="ak-input @error('organization_name') error @enderror"
                            aria-describedby="@error('organization_name')org-name-error @enderror"
                        >
                        @error('organization_name')
                            <span class="ak-input-error" id="org-name-error" role="alert">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="ak-form-group">
                        <label for="description" class="ak-label">
                            Deskripsi Singkat
                            <span style="font-weight:400; color:var(--color-ink-muted); font-size:0.8rem;">(opsional)</span>
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            maxlength="300"
                            placeholder="Ceritakan misi dan fokus kegiatan organisasi Anda…"
                            class="ak-input @error('description') error @enderror"
                            style="resize:vertical; min-height:88px;"
                            aria-describedby="desc-counter @error('description')desc-error @enderror"
                        >{{ old('description') }}</textarea>
                        <span class="ak-char-counter" id="desc-counter" aria-live="polite">
                            <span id="desc-count">0</span>/300
                        </span>
                        @error('description')
                            <span class="ak-input-error" id="desc-error" role="alert">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">

                        <div class="ak-form-group">
                            <label for="city" class="ak-label">
                                Kota
                                <span class="required" aria-hidden="true">*</span>
                            </label>
                            <input
                                type="text"
                                id="city"
                                name="city"
                                value="{{ old('city') }}"
                                placeholder="Jakarta"
                                autocomplete="address-level2"
                                required
                                class="ak-input @error('city') error @enderror"
                                aria-describedby="@error('city')city-error @enderror"
                            >
                            @error('city')
                                <span class="ak-input-error" id="city-error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="ak-form-group">
                            <label for="province" class="ak-label">
                                Provinsi
                                <span class="required" aria-hidden="true">*</span>
                            </label>
                            <input
                                type="text"
                                id="province"
                                name="province"
                                value="{{ old('province') }}"
                                placeholder="DKI Jakarta"
                                autocomplete="address-level1"
                                required
                                class="ak-input @error('province') error @enderror"
                                aria-describedby="@error('province')prov-error @enderror"
                            >
                            @error('province')
                                <span class="ak-input-error" id="prov-error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                </div>

                <button
                    type="submit"
                    id="registerSubmit"
                    class="ak-btn ak-btn-primary"
                    style="width:100%; margin-top:28px; justify-content:center; gap:8px;">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span id="registerBtnText">Daftarkan Organisasi</span>
                    <svg id="registerSpinner"
                         width="16" height="16"
                         style="display:none; animation: ak-spin 0.7s linear infinite;"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12a8 8 0 018-8"/>
                    </svg>
                </button>

            </form>

            <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--color-border); text-align:center;">
                <p style="font-size:0.875rem; color:var(--color-ink-muted); margin-bottom:8px;">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" style="color:var(--color-blue); font-weight:600;">Masuk di sini</a>
                </p>
                <p style="font-size:0.875rem; color:var(--color-ink-muted);">
                    Ingin mendaftar sebagai relawan?
                    <a href="{{ route('register.volunteer') }}" style="color:var(--color-blue); font-weight:600;">Klik di sini</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';
    function makeToggle(btnId, inputId, eyeOffId, eyeOnId) {
        var btn    = document.getElementById(btnId);
        var input  = document.getElementById(inputId);
        var eyeOff = document.getElementById(eyeOffId);
        var eyeOn  = document.getElementById(eyeOnId);
        if (!btn || !input) return;

        btn.addEventListener('click', function () {
            var show   = input.type === 'password';
            input.type = show ? 'text' : 'password';
            if (eyeOff) eyeOff.style.display = show ? 'none' : '';
            if (eyeOn)  eyeOn.style.display  = show ? ''     : 'none';
            btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        });
    }

    makeToggle('togglePass',     'password',              'eyeOff1', 'eyeOn1');
    makeToggle('togglePassConf', 'password_confirmation', 'eyeOff2', 'eyeOn2');

    var textarea    = document.getElementById('description');
    var countEl     = document.getElementById('desc-count');
    var counterWrap = document.getElementById('desc-counter');
    var MAX_CHARS   = 300;

    function updateCount() {
        if (!textarea || !countEl) return;
        var len = textarea.value.length;
        countEl.textContent = len;

        if (counterWrap) {
            counterWrap.classList.remove('warn', 'over');
            if (len >= MAX_CHARS)       counterWrap.classList.add('over');
            else if (len >= MAX_CHARS * 0.85) counterWrap.classList.add('warn');
        }
    }

    if (textarea) {
        textarea.addEventListener('input', updateCount);
        updateCount();
    }

    var form    = document.getElementById('registerOrgForm');
    var btn     = document.getElementById('registerSubmit');
    var btnText = document.getElementById('registerBtnText');
    var spinner = document.getElementById('registerSpinner');

    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.disabled = true;
            if (btnText) btnText.textContent  = 'Mendaftarkan…';
            if (spinner) spinner.style.display = '';
        });
    }

})();
</script>
@endpush

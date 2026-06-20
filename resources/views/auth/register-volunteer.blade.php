@extends('layouts.guest')
@section('title', 'Daftar sebagai Volunteer')

@push('styles')
<style>
.auth-register-wrap {
    min-height: calc(100vh - var(--spacing-navbar));
    display: flex;
    align-items: stretch;
    background: var(--color-bg);
}

.auth-brand-panel {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 420px;
    min-width: 380px;
    background: linear-gradient(160deg, #1E3A8A 0%, #2563EB 100%);
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
}


.auth-form-panel {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 24px;
    overflow-y: auto;
}

.auth-register-box {
    width: 100%;
    max-width: 520px;
    background: var(--color-surface);
    border: 1.5px solid var(--color-border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.auth-register-header {
    background: linear-gradient(135deg, #1E3A8A 0%, #2563EB 100%);
    padding: 32px 36px 28px;
    position: relative;
    overflow: hidden;
}

.auth-register-header::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40'%3E%3Ccircle cx='20' cy='20' r='1' fill='rgba(255,255,255,0.05)'/%3E%3C/svg%3E");
    background-size: 40px 40px;
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
}

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

.ak-input-wrap {
    position: relative;
}

.ak-input-wrap .ak-input {
    padding-right: 44px;
}

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

.oauth-separator {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}
.oauth-separator::before, .oauth-separator::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--color-border);
}
.oauth-separator span {
    font-size: 0.75rem;
    color: var(--color-ink-muted);
    font-weight: 500;
}

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

    <aside class="auth-brand-panel" aria-hidden="true">
        <img
            src="{{ asset('images/logo_aksikita.png') }}"
            alt="Logo AksiKita"
            class="auth-brand-logo"
        >
        <span class="auth-brand-name">AksiKita</span>
        <p class="auth-brand-tagline">
            Menghubungkan relawan dengan organisasi sosial di seluruh Indonesia untuk menciptakan dampak nyata.
        </p>
    </aside>

    <div class="auth-form-panel">
        <div class="auth-register-box">
            <div class="auth-register-header">
                <a href="{{ route('home') }}" class="auth-register-header__back" aria-label="Kembali ke beranda">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
                <h1>Daftar sebagai Volunteer</h1>
                <p>Bergabung gratis dan mulai berkontribusi untuk Indonesia.</p>
            </div>

        <div class="auth-register-body">
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

            <a href="{{ route('auth.google') }}"
               class="ak-btn" 
               style="width: 100%; justify-content: center; background: #fff; border: 1.5px solid var(--color-border); color: var(--color-ink); margin-bottom: 20px; gap: 10px; font-weight: 600;"
               role="button">
                <svg class="w-5 h-5 flex-shrink-0" style="width:18px; height:18px;" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Daftar dengan Google
            </a>

            <div class="oauth-separator">
                <span>atau daftar manual</span>
            </div>

            <form action="{{ route('register.volunteer.post') }}" method="POST" id="registerVolForm" novalidate>
                @csrf

                <div class="auth-section-label">Data Diri</div>

                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div class="ak-form-group">
                        <label for="name" class="ak-label">
                            Nama Lengkap <span class="required" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Nama sesuai identitas"
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
                            Alamat Email <span class="required" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
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

                    <div class="ak-form-group">
                        <label for="phone" class="ak-label">
                            Nomor Telepon
                            <span style="font-weight:400; color:var(--color-ink-muted); font-size:0.8rem;">(opsional)</span>
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx"
                            autocomplete="tel"
                            class="ak-input @error('phone') error @enderror"
                            aria-describedby="@error('phone')phone-error @enderror"
                        >
                        @error('phone')
                            <span class="ak-input-error" id="phone-error" role="alert">
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
                                Kota <span class="required" aria-hidden="true">*</span>
                            </label>
                            <input
                                type="text"
                                id="city"
                                name="city"
                                value="{{ old('city') }}"
                                placeholder="Yogyakarta"
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
                                Provinsi <span class="required" aria-hidden="true">*</span>
                            </label>
                            <input
                                type="text"
                                id="province"
                                name="province"
                                value="{{ old('province') }}"
                                placeholder="DI Yogyakarta"
                                autocomplete="address-level1"
                                required
                                class="ak-input @error('province') error @enderror"
                                aria-describedby="@error('province')province-error @enderror"
                            >
                            @error('province')
                                <span class="ak-input-error" id="province-error" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="auth-section-label">Keamanan Akun</div>

                <div style="display:flex; flex-direction:column; gap:16px;">

                    <div class="ak-form-group">
                        <label for="password" class="ak-label">
                            Password <span class="required" aria-hidden="true">*</span>
                        </label>
                        <div class="ak-input-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Minimal 8 karakter"
                                autocomplete="new-password"
                                required
                                class="ak-input @error('password') error @enderror"
                                aria-describedby="@error('password')pass-error @enderror password-hint"
                            >
                            <button type="button" class="ak-input-toggle" id="togglePass" aria-label="Tampilkan password" tabindex="-1">
                                <svg id="eyeOff1" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                                <svg id="eyeOn1" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <span class="ak-input-hint" id="password-hint">Gunakan kombinasi huruf, angka, dan simbol.</span>
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
                            Konfirmasi Password <span class="required" aria-hidden="true">*</span>
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
                            <button type="button" class="ak-input-toggle" id="togglePassConf" aria-label="Tampilkan konfirmasi password" tabindex="-1">
                                <svg id="eyeOff2" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                                <svg id="eyeOn2" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>

                <button type="submit"
                        class="ak-btn ak-btn-primary"
                        id="registerSubmit"
                        style="width:100%; margin-top:28px; justify-content:center; gap: 8px;">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span id="registerBtnText">Buat Akun Volunteer</span>
                    <svg id="registerSpinner" width="16" height="16" style="display:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12a8 8 0 018-8V0"/>
                    </svg>
                </button>

            </form>

            <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--color-border); text-align:center;">
                <p style="font-size:0.875rem; color:var(--color-ink-muted); margin-bottom:8px;">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" style="color:var(--color-blue); font-weight:600;">Masuk di sini</a>
                </p>
                <p style="font-size:0.875rem; color:var(--color-ink-muted);">
                    Ingin mendaftarkan organisasi?
                    <a href="{{ route('register.organizer') }}" style="color:var(--color-blue); font-weight:600;">Klik di sini</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    function makeToggle(btnId, inputId, eyeOffId, eyeOnId) {
        const btn    = document.getElementById(btnId);
        const input  = document.getElementById(inputId);
        const eyeOff = document.getElementById(eyeOffId);
        const eyeOn  = document.getElementById(eyeOnId);
        if (!btn || !input) return;
        btn.addEventListener('click', function () {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            if (eyeOff) eyeOff.style.display = show ? 'none' : '';
            if (eyeOn)  eyeOn.style.display  = show ? ''     : 'none';
            btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        });
    }

    makeToggle('togglePass',     'password',              'eyeOff1', 'eyeOn1');
    makeToggle('togglePassConf', 'password_confirmation', 'eyeOff2', 'eyeOn2');
    
    const form    = document.getElementById('registerVolForm');
    const btn     = document.getElementById('registerSubmit');
    const btnText = document.getElementById('registerBtnText');
    const spinner = document.getElementById('registerSpinner');

    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.disabled = true;
            if (btnText)  btnText.textContent   = 'Mendaftarkan…';
            if (spinner)  spinner.style.display  = '';
            if (spinner)  spinner.style.animation = 'ak-spin 0.7s linear infinite';
        });
    }
})();
</script>
@endpush
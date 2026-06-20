@extends('layouts.guest')
@section('title', 'Masuk ke AksiKita')

@push('styles')
<style>
.auth-wrap {
    min-height: calc(100vh - var(--spacing-navbar));
    display: flex;
    align-items: stretch;
}

.auth-panel {
    flex: 0 0 300px;
    background: linear-gradient(150deg, #1E3A8A 0%, #1a3580 40%, #2563EB 100%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 48px 36px;
    position: relative;
    overflow: hidden;
}

.auth-panel::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle at 15% 85%, rgba(96,165,250,0.15) 0%, transparent 45%),
        radial-gradient(circle at 85% 15%, rgba(30,58,138,0.4) 0%, transparent 45%);
    pointer-events: none;
}

.auth-panel__content {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.auth-panel__logo-circle {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 28px;
    overflow: hidden;
    flex-shrink: 0;
}

.auth-panel__logo-circle img {
    width: 110px;
    height: 110px;
    object-fit: contain;
}

.auth-panel__brand-name {
    font-family: var(--font-display);
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.025em;
    margin-bottom: 10px;
}

.auth-panel__brand-desc {
    font-size: 0.8rem;
    color: #BFDBFE;
    line-height: 1.6;
    margin-bottom: 36px;
}

.auth-panel__nav-group {
    margin-bottom: 24px;
}

.auth-panel__nav-title {
    font-size: 0.75rem;
    font-weight: 700;
    color: #93C5FD;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.auth-panel__nav-link {
    display: block;
    font-size: 0.8125rem;
    color: rgba(191,219,254,0.85);
    text-decoration: none;
    padding: 3px 0;
    transition: color 0.15s;
}

.auth-panel__nav-link:hover { color: #fff; }

.auth-panel__footer {
    position: relative;
    z-index: 1;
    font-size: 0.75rem;
    color: rgba(191,219,254,0.6);
}

.auth-form-area {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 40px;
    background: var(--color-bg);
}

.auth-form-box {
    width: 100%;
    max-width: 440px;
}

.auth-form-box__heading h1 {
    font-family: var(--font-display);
    font-size: 1.875rem;
    font-weight: 800;
    color: var(--color-navy);
    letter-spacing: -0.025em;
    margin-bottom: 6px;
}

.auth-form-box__sub {
    font-size: 0.875rem;
    color: var(--color-ink-muted);
    margin-bottom: 28px;
}

.ak-btn-google {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    width: 100%;
    border: 1.5px solid var(--color-border, #e2e8f0);
    border-radius: 10px;
    padding: 11px 16px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #334155;
    background-color: #fff;
    text-decoration: none;
    transition: background 0.15s, border-color 0.15s;
}

.ak-btn-google:hover {
    background-color: #f8fafc;
    border-color: #cbd5e1;
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

.auth-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 20px 0;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--color-ink-muted);
}
.auth-divider::before,
.auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--color-border);
}

@media (max-width: 900px) {
    .auth-panel { display: none; }
    .auth-form-area { padding: 40px 24px; min-height: calc(100vh - var(--spacing-navbar)); }
}
</style>
@endpush

@section('content')
<div class="auth-wrap">

    <aside class="auth-panel" role="complementary" aria-label="Informasi AksiKita">
        <div class="auth-panel__content">
            <div class="auth-panel__logo-circle" aria-hidden="true">
                <img src="{{ asset('images/logo_aksikita.png') }}" alt="Logo AksiKita">
            </div>

            <span class="auth-panel__brand-name">AksiKita</span>
            <p class="auth-panel__brand-desc">
                Menghubungkan relawan dengan organisasi sosial di seluruh Indonesia untuk menciptakan dampak nyata.
            </p>

            <div class="auth-panel__nav-group">
                <p class="auth-panel__nav-title">Platform</p>
                <a href="#" class="auth-panel__nav-link">Cara Kerja</a>
                <a href="#" class="auth-panel__nav-link">Tentang Kami</a>
            </div>

            <div class="auth-panel__nav-group">
                <p class="auth-panel__nav-title">Dukungan</p>
                <a href="#" class="auth-panel__nav-link">Pusat Bantuan</a>
                <a href="#" class="auth-panel__nav-link">Panduan Pengguna</a>
            </div>

        </div>

        <div class="auth-panel__footer">
            &copy; {{ date('Y') }} AksiKita
        </div>
    </aside>

    <div class="auth-form-area">
        <div class="auth-form-box">

            <div class="auth-form-box__heading">
                <h1>Selamat datang kembali,</h1>
            </div>
            <p class="auth-form-box__sub">Volunteer &amp; Organisasi login di sini</p>

            @if(session('error'))
                <div class="ak-alert ak-alert-danger" role="alert" style="margin-bottom:20px;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="ak-alert ak-alert-success" role="alert" style="margin-bottom:20px;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="ak-alert ak-alert-danger" role="alert" style="margin-bottom:20px;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <a href="{{ route('auth.google') }}" class="ak-btn-google">
                <svg viewBox="0 0 24 24" width="20" height="20" style="display:block;flex-shrink:0;">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                <span>Masuk dengan Google</span>
            </a>

            <div class="auth-divider">atau</div>

            <form action="{{ route('login.post') }}" method="POST" id="loginForm" novalidate>
                @csrf

                <div style="display:flex; flex-direction:column; gap:16px;">

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
                            autofocus
                            required
                            class="ak-input @error('email') error @enderror"
                        >
                        @error('email')
                            <span class="ak-input-error" role="alert">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="ak-form-group">
                        <label for="password" class="ak-label">
                            Password <span class="required" aria-hidden="true">*</span>
                        </label>
                        <div class="ak-input-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                                class="ak-input @error('password') error @enderror"
                            >
                            <button type="button" class="ak-input-toggle" id="togglePassword" aria-label="Tampilkan password" tabindex="-1">
                                <svg id="iconEyeOff" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                                <svg id="iconEyeOn" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true" style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="ak-input-error" role="alert">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="ak-btn ak-btn-primary" id="loginSubmit" style="width:100%; justify-content:center; gap:8px; margin-top:4px;">
                        <span id="loginBtnText">Masuk</span>
                        <svg id="loginBtnSpinner" width="16" height="16" style="display:none; animation:ak-spin 0.7s linear infinite;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                    </button>

                </div>
            </form>

            <div class="auth-divider" style="margin-top:24px;">Belum memiliki akun?</div>

            <div style="display:flex; gap:10px;">
                <a href="{{ route('register.volunteer') }}" class="ak-btn ak-btn-ghost" style="flex:1; justify-content:center; text-decoration:none;">
                    Daftar Volunteer
                </a>
                <a href="{{ route('register.organizer') }}" class="ak-btn ak-btn-outline" style="flex:1; justify-content:center; text-decoration:none;">
                    Daftar Organisasi
                </a>
            </div>

        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
(function () {
   
    const passwordInput  = document.getElementById('password');
    const toggleBtn      = document.getElementById('togglePassword');
    const iconEyeOff     = document.getElementById('iconEyeOff');
    const iconEyeOn      = document.getElementById('iconEyeOn');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            iconEyeOff.style.style.display = isHidden ? 'none'  : '';
            iconEyeOn.style.display  = isHidden ? ''      : 'none';
            toggleBtn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });
    }

    const loginForm    = document.getElementById('loginForm');
    const loginSubmit  = document.getElementById('loginSubmit');
    const loginBtnText = document.getElementById('loginBtnText');
    const loginSpinner = document.getElementById('loginBtnSpinner');

    if (loginForm && loginSubmit) {
        loginForm.addEventListener('submit', function () {
            loginSubmit.disabled = true;
            if (loginBtnText)  loginBtnText.textContent  = 'Memproses…';
            if (loginSpinner)  loginSpinner.style.display = '';
        });
    }
})();
</script>
<style>
@keyframes ak-spin { to { transform: rotate(360deg); } }
</style>
@endpush
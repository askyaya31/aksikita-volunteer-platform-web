<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AksiKita — Platform volunteer untuk Indonesia. Temukan kegiatan sosial dan bergabunglah bersama ribuan relawan.">
    <title>@yield('title', 'AksiKita') - Platform Volunteer Indonesia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="ak-fadein">
    <nav class="ak-navbar" id="guestNavbar">
        <div class="ak-container">
            <div class="ak-navbar__inner">

                <a href="{{ route('home') }}" class="ak-logo">
                    <img src="{{ asset('images/logo_aksikita.png') }}" alt="Logo AksiKita" style="height: 36px; width: auto;">
                    AksiKita
                </a>
                <div class="ak-nav-links-desktop" style="display: flex; align-items: center; justify-content: center; gap: 4px; margin-left: 8px; flex: 1;">
                    <ul class="ak-nav-links">
                        <li>
                            <a href="{{ route('home') }}"
                               class="ak-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}#tentang"
                               class="ak-nav-link">
                                Tentang
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="ak-nav-links-desktop" style="display:flex; align-items:center; gap:8px; margin-left:auto;">
                    <a href="{{ route('login') }}" class="ak-btn ak-btn-ghost ak-btn-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register.volunteer') }}" class="ak-btn ak-btn-primary ak-btn-sm">
                        Daftar sebagai Volunteer
                    </a>
                </div>

                <button class="ak-hamburger" id="guestHamburger" aria-label="Buka menu" style="margin-left:auto;">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

            </div>
        </div>
    </nav>

    <div class="ak-mobile-menu" id="guestMobileMenu" aria-hidden="true">
        <nav style="display:flex; flex-direction:column; gap:4px; margin-bottom:20px;">
            <a href="{{ route('home') }}" class="ak-mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <a href="{{ route('home') }}#tentang" class="ak-mobile-nav-link">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Tentang
            </a>
        </nav>
        <hr class="ak-divider">
        <div style="display:flex; flex-direction:column; gap:10px; padding-top:4px;">
            <a href="{{ route('login') }}" class="ak-btn ak-btn-ghost" style="justify-content:center;">
                Masuk
            </a>
            <a href="{{ route('register.volunteer') }}" class="ak-btn ak-btn-primary" style="justify-content:center;">
                Daftar sebagai Volunteer
            </a>
            <a href="{{ route('register.organizer') }}" class="ak-btn ak-btn-outline" style="justify-content:center; margin-top:4px;">
                Daftarkan Organisasi
            </a>
        </div>
    </div>

    <main>
        @if(session('success'))
            <div class="ak-container" style="padding-top:16px;">
                <div class="ak-alert ak-alert-success" role="alert">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:1px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="ak-container" style="padding-top:16px;">
                <div class="ak-alert ak-alert-danger" role="alert">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:1px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @unless(isset($hideFooter) && $hideFooter)
    <footer class="ak-footer">
        <div class="ak-container">
            <div style="display:grid; grid-template-columns: 2fr 1fr 1fr; gap:48px; padding-bottom:8px;">
                <div>
                    <div style="margin-bottom:12px;">
                        <a href="{{ route('home') }}" class="ak-logo" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px;">
                            <img src="{{ asset('images/logo_aksikita.png') }}" alt="Logo AksiKita" style="height: 36px; width: auto;">
                            <span class="ak-footer__brand" style="font-weight: 800; font-size: 1.25rem; color: var(--ak-navy); letter-spacing: -0.02em;">AksiKita</span>
                        </a>
                    </div>
                    
                    <p class="ak-footer__tagline" style="text-align:justify;">
                        Menghubungkan relawan dengan organisasi sosial di seluruh Indonesia untuk menciptakan dampak nyata.
                    </p>
                </div>

                <div>
                    <div class="ak-footer__heading">Platform</div>
                    <ul class="ak-footer__links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('register.volunteer') }}">Jadi Volunteer</a></li>
                        <li><a href="{{ route('register.organizer') }}">Daftarkan Organisasi</a></li>
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                    </ul>
                </div>

                <div>
                    <div class="ak-footer__heading">Informasi</div>
                    <ul class="ak-footer__links">
                        <li><a href="{{ route('home') }}#tentang">Tentang Kami</a></li>
                        <li><a href="mailto:aksikita.support@gmail.com">Hubungi Kami</a></li>
                    </ul>
                </div>

            </div>

            <div class="ak-footer__bottom">
                <p class="ak-footer__copyright">
                    &copy; {{ date('Y') }} AksiKita. Dibuat dengan tujuan sosial untuk Indonesia.
                </p>
            </div>
        </div>
    </footer>
    @endunless
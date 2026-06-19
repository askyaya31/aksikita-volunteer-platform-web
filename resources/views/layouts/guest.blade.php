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

    <style>
        .ak-footer {
            background: #0F2057 !important;
            color: #ffffff !important;
            padding: 48px 24px 32px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .ak-footer__brand {
            color: #ffffff !important;
            font-weight: 700;
            font-size: 1.4rem;
        }
        .ak-footer__tagline {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.875rem;
            line-height: 1.6;
        }
        .ak-footer__heading {
            color: #ffffff !important;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .ak-footer__links a {
            color: rgba(255, 255, 255, 0.7) !important;
            text-decoration: none;
            transition: color 0.2s;
        }
        .ak-footer__links a:hover {
            color: #ffffff !important;
            text-decoration: underline;
        }
        .ak-footer__bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: rgba(255, 255, 255, 0.5) !important;
        }
    </style>
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
            <div style="display:grid; grid-template-columns: 2fr 1fr 1fr; gap:48px; padding-bottom:32px;">
                <div>
                    <div style="display:flex; align-items:center; gap:9px; margin-bottom:12px;">
                        <img src="{{ asset('images/logo_aksikita.png') }}" alt="Logo AksiKita" style="height: 36px; width: auto;">
                        <span class="ak-footer__brand">AksiKita</span>
                    </div>
                    <p class="ak-footer__tagline" style="text-align:justify; margin-bottom: 16px;">
                        Menghubungkan relawan dengan organisasi sosial di seluruh Indonesia untuk menciptakan dampak nyata. Bersama AksiKita, mari perluas dampak positif dan gerakkan aksi kebaikan dengan lebih efektif.
                    </p>
                    <div class="ak-footer__socials" style="display: flex; gap: 10px;">
                        <a href="mailto:aksikita.support@gmail.com" aria-label="Email" style="width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #EA4335;">
                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: #fff;"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </a>
                        <a href="https://wa.me/6281225443229" aria-label="WhatsApp" target="_blank" rel="noopener" style="width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #25D366;">
                            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: #fff;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                        <a href="https://instagram.com/aksikita__id" target="_blank" rel="noopener" aria-label="Instagram" style="width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #E1306C;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; stroke: #fff;"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                    </div>
                </div>

                <div>
                    <div class="ak-footer__heading">Platform</div>
                    <ul class="ak-footer__links" style="list-style: none; display: flex; flex-direction: column; gap: 10px; padding: 0;">
                        <li><a href="{{ route('home') }}#tentang">Tentang Kami</a></li>
                        <li><a href="{{ route('home') }}#cara-kerja">Cara Kerja</a></li>
                        <li><a href="{{ route('register.volunteer') }}">Masuk sebagai Relawan</a></li>
                        <li><a href="{{ route('register.organizer') }}">Daftarkan Organisasi</a></li>
                    </ul>
                </div>

                <div>
                    <div class="ak-footer__heading">Dukungan</div>
                    <ul class="ak-footer__links" style="list-style: none; display: flex; flex-direction: column; gap: 10px; padding: 0;">
                        <li><a href="https://drive.google.com/drive/folders/1-HmfU9CaZ0Goym3lIZURkyjiPBmic0Vh" target="_blank" rel="noopener">Pusat Bantuan</a></li>
                        <li><a href="{{ route('panduan.organisasi') }}">Panduan Organisasi</a></li>
                        <li><a href="mailto:aksikita.support@gmail.com">Hubungi Kami</a></li>
                    </ul>
                </div>

            </div>

            <div class="ak-footer__bottom" style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 1.5rem;">
                <p class="ak-footer__copyright" style="margin: 0;">
                    &copy; 2026 AksiKita
                </p>
            </div>
        </div>
    </footer>
    @endunless

    @stack('scripts')
</body>
</html>
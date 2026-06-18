<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — AksiKita Volunteer</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        /* ─── RESET ────────────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* ─── NAVBAR ─────────────────────────────────────────────────── */
        /*
         * Matches screenshot exactly:
         * - white background, very subtle bottom border + shadow
         * - height ~60px
         * - left: logo icon (outlined leaf/lightning) + bold "AksiKita"
         * - center: Beranda  Kegiatan  Jadwal  (regular weight, gray)
         * - right: circle icon btn (chat) + circle icon btn (bell) + pill (avatar + "Nama Relawan.." + chevron)
         */
        .ak-navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #ffffff;
            border-bottom: 1px solid #e8e8e8;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            height: 60px;
        }
        .ak-navbar__inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            height: 100%;
            display: flex;
            align-items: center;
        }

        /* ── Logo ── */
        .ak-logo {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: #111827;
            flex-shrink: 0;
            letter-spacing: -0.2px;
        }
        .ak-logo__icon {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

        /* ── Nav links ── */
        .ak-nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            list-style: none;
            margin-left: 24px;
        }
        .ak-nav-link {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 400;
            color: #6b7280;
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 6px;
            white-space: nowrap;
            transition: color .15s, background .15s;
        }
        .ak-nav-link:hover { color: #111827; background: #f5f5f5; }
        .ak-nav-link.active { color: #111827; font-weight: 500; }

        /* ── Right side ── */
        .ak-nav-right {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
        }

        /* Circle icon buttons — chat & bell */
        .ak-icon-btn {
            position: relative;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #374151;
            text-decoration: none;
            flex-shrink: 0;
            transition: background .15s;
        }
        .ak-icon-btn:hover { background: #e9ebee; }
        .ak-icon-btn svg { width: 16px; height: 16px; stroke-width: 1.75; }

        /* Chat badge */
        #chatBadge {
            display: none;
            position: absolute;
            top: 1px; right: 1px;
            background: #E8501A;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            border-radius: 999px;
            padding: 1px 4px;
            line-height: 1.4;
            border: 1.5px solid #fff;
        }

        /* Notification dot */
        .ak-notif-dot {
            position: absolute;
            top: 7px; right: 7px;
            width: 7px; height: 7px;
            background: #ef4444;
            border-radius: 50%;
            border: 1.5px solid #fff;
        }

        /* User pill — avatar + name + chevron */
        .ak-user-menu { position: relative; }
        .ak-user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px 4px 4px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.83rem;
            font-weight: 400;
            color: #374151;
            white-space: nowrap;
            transition: background .15s;
        }
        .ak-user-pill:hover { background: #e9ebee; }
        .ak-user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 600;
            color: #6b7280;
            flex-shrink: 0;
        }
        .ak-user-pill__name {
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ak-user-pill__chevron {
            width: 13px; height: 13px;
            opacity: 0.45;
            flex-shrink: 0;
            stroke-width: 2.5;
        }

        /* Dropdown */
        .ak-user-menu__dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0,0,0,.10);
            min-width: 176px;
            padding: 6px;
            z-index: 200;
        }
        .ak-user-menu.open .ak-user-menu__dropdown { display: block; }
        .ak-dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.84rem;
            color: #374151;
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: background .12s;
            text-align: left;
        }
        .ak-dropdown-item:hover { background: #f9fafb; }
        .ak-dropdown-item.danger { color: #ef4444; }
        .ak-dropdown-item.danger:hover { background: #fef2f2; }
        .ak-dropdown-divider { height: 1px; background: #f3f4f6; margin: 4px 0; }

        /* ── Hamburger (mobile) ── */
        .ak-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            padding: 6px;
            background: none;
            border: none;
            cursor: pointer;
            margin-left: auto;
        }
        .ak-hamburger span {
            display: block;
            width: 22px; height: 2px;
            background: #374151;
            border-radius: 2px;
            transition: transform .25s, opacity .25s;
        }
        .ak-hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .ak-hamburger.open span:nth-child(2) { opacity: 0; }
        .ak-hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* ── Mobile menu ── */
        .ak-mobile-menu {
            position: fixed;
            inset: 60px 0 0 0;
            background: #fff;
            z-index: 90;
            overflow-y: auto;
            padding: 16px 20px 32px;
            transform: translateX(100%);
            transition: transform .25s ease;
        }
        .ak-mobile-menu.open { transform: translateX(0); }
        .ak-mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            transition: background .12s;
        }
        .ak-mobile-nav-link:hover,
        .ak-mobile-nav-link.active { background: #f3f4f6; color: #111827; }

        /* ── Alert banners ── */
        .ak-alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 8px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            margin-bottom: 12px;
        }
        .ak-alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .ak-alert-danger  { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .ak-alert-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .ak-alert-info    { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .ak-badge { display: inline-flex; align-items: center; border-radius: 999px; padding: 2px 7px; font-size: 0.75rem; font-weight: 600; }
        .ak-badge-danger { background: #fef2f2; color: #ef4444; }

        /* ─── FOOTER ─────────────────────────────────────────────────── */
        .ak-footer {
            background: #1a3a6b;
            color: #c8d8f0;
            padding: 48px 24px 32px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .ak-footer__inner {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
        }
        .ak-footer__logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            text-decoration: none;
        }
        .ak-footer__logo-mark {
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,.3);
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,.1);
            flex-shrink: 0;
        }
        .ak-footer__logo-mark svg { width: 20px; height: 20px; fill: #fff; }
        .ak-footer__logo-name { font-size: 1.1rem; font-weight: 700; color: #fff; }
        .ak-footer__desc { font-size: 0.82rem; line-height: 1.65; color: #a8bdd8; margin-bottom: 14px; max-width: 260px; }
        .ak-footer__copy { font-size: 0.79rem; color: #7a99be; margin-bottom: 16px; }
        .ak-footer__socials { display: flex; gap: 10px; }
        .ak-footer__social-btn {
            width: 34px; height: 34px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .ak-footer__social-btn svg { width: 18px; height: 18px; fill: #fff; }
        .ak-footer__social-btn.gmail    { background: #EA4335; }
        .ak-footer__social-btn.whatsapp { background: #25D366; }
        .ak-footer__social-btn.other    { background: #b0bec5; }
        .ak-footer__col-title { font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 16px; }
        .ak-footer__col-links { display: flex; flex-direction: column; gap: 10px; list-style: none; }
        .ak-footer__col-links a { font-size: 0.84rem; color: #a8bdd8; text-decoration: none; transition: color .15s; }
        .ak-footer__col-links a:hover { color: #fff; }

        /* ─── RESPONSIVE ─────────────────────────────────────────────── */
        @media (max-width: 768px) {
            .ak-nav-links, .ak-nav-right { display: none !important; }
            .ak-hamburger { display: flex; }
            .ak-footer__inner { grid-template-columns: 1fr; gap: 28px; }
        }
        @media (min-width: 769px) {
            .ak-hamburger { display: none !important; }
            .ak-mobile-menu { display: none !important; }
        }

        .ak-fadein { animation: fadein .3s ease; }
        @keyframes fadein { from { opacity: 0; } to { opacity: 1; } }
        .ak-container { max-width: 1280px; margin: 0 auto; padding: 0 20px; }
        .ak-divider { border: none; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body class="ak-fadein">

    {{-- ════════════════════════════════════════
         NAVBAR
    ════════════════════════════════════════ --}}
    <nav class="ak-navbar" id="volNavbar">
        <div class="ak-navbar__inner">

            {{-- Logo --}}
            <a href="{{ route('volunteer.dashboard') }}" class="ak-logo">
                {{-- Outlined leaf/lightning icon matching screenshot --}}
                <svg class="ak-logo__icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="32" rx="8" fill="none"/>
                    <g fill="none" stroke="#111827" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 6 C8 12 10 16 16 16 C12 16 10 20 12 26" />
                        <path d="M16 16 C20 16 24 12 22 6 C20 10 18 13 16 16Z" />
                    </g>
                </svg>
                AksiKita
            </a>

            {{-- Nav links (desktop) --}}
            <ul class="ak-nav-links">
                <li>
                    <a href="{{ route('volunteer.dashboard') }}"
                       class="ak-nav-link {{ request()->routeIs('volunteer.dashboard') ? 'active' : '' }}">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('volunteer.events') }}"
                       class="ak-nav-link {{ request()->routeIs('volunteer.events*') ? 'active' : '' }}">
                        Kegiatan
                    </a>
                </li>
                <li>
                    <a href="{{ route('volunteer.schedule') }}"
                       class="ak-nav-link {{ request()->routeIs('volunteer.schedule*') ? 'active' : '' }}">
                        Jadwal
                    </a>
                </li>
            </ul>

            {{-- Right actions (desktop) --}}
            <div class="ak-nav-right">

                {{-- Chat button --}}
                <a href="{{ route('volunteer.chat.index') }}"
                   class="ak-icon-btn"
                   aria-label="Pesan">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 4h16v12H4zM4 16l4 4M20 16l-4 4" />
                    </svg>
                    <span id="chatBadge">0</span>
                </a>

                {{-- Notification bell --}}
                <a href="{{ route('volunteer.notifications') }}"
                   class="ak-icon-btn"
                   aria-label="Notifikasi">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(session('unread_count', 0) > 0)
                        <span class="ak-notif-dot"></span>
                    @endif
                </a>

                {{-- User pill --}}
                <div class="ak-user-menu" id="volUserMenu">
                    <button class="ak-user-pill" id="volUserTrigger"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="ak-user-avatar">
                            {{ strtoupper(substr(session('user_name', 'N'), 0, 1)) }}
                        </span>
                        <span class="ak-user-pill__name">
                            {{ session('user_name', 'Nama Relawan') }}
                        </span>
                        <svg class="ak-user-pill__chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div class="ak-user-menu__dropdown" id="volUserDropdown" role="menu">
                        <a href="{{ route('volunteer.profile') }}" class="ak-dropdown-item" role="menuitem">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </a>
                        <a href="{{ route('volunteer.notifications') }}" class="ak-dropdown-item" role="menuitem">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            Notifikasi
                            @if(session('unread_count', 0) > 0)
                                <span class="ak-badge ak-badge-danger" style="margin-left:auto;font-size:10px;">
                                    {{ session('unread_count') }}
                                </span>
                            @endif
                        </a>
                        <div class="ak-dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="ak-dropdown-item danger" role="menuitem">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Hamburger (mobile) --}}
            <button class="ak-hamburger" id="volHamburger" aria-label="Buka menu">
                <span></span><span></span><span></span>
            </button>

        </div>
    </nav>

    {{-- ════════════════════════════════════════
         MOBILE MENU
    ════════════════════════════════════════ --}}
    <div class="ak-mobile-menu" id="volMobileMenu" aria-hidden="true">
        <div style="display:flex;align-items:center;gap:12px;padding:4px 4px 16px;border-bottom:1px solid #e5e7eb;margin-bottom:12px;">
            <span class="ak-user-avatar" style="width:40px;height:40px;font-size:15px;flex-shrink:0;">
                {{ strtoupper(substr(session('user_name', 'U'), 0, 1)) }}
            </span>
            <div>
                <div style="font-weight:600;font-size:.9rem;color:#111827;">{{ session('user_name', 'Volunteer') }}</div>
                <div style="font-size:.8rem;color:#6b7280;">{{ session('user_email', '') }}</div>
            </div>
        </div>
        <nav style="display:flex;flex-direction:column;gap:2px;">
            <a href="{{ route('volunteer.dashboard') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="{{ route('volunteer.events') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.events*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Kegiatan
            </a>
            <a href="{{ route('volunteer.schedule') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.schedule*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Jadwal
            </a>
            <a href="{{ route('volunteer.profile') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.registrations*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Pendaftaran Saya
            </a>
            <a href="{{ route('volunteer.history') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.history*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat
            </a>
            <a href="{{ route('volunteer.liked-events') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.liked-events*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Disukai
            </a>
            <a href="{{ route('volunteer.saved-events') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.saved-events*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                Tersimpan
            </a>
            <a href="{{ route('volunteer.notifications') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.notifications*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Notifikasi
                @if(session('unread_count', 0) > 0)
                    <span class="ak-badge ak-badge-danger" style="margin-left:auto;">{{ session('unread_count') }}</span>
                @endif
            </a>
            <a href="{{ route('volunteer.chat.index') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.chat.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.862 9.862 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Pesan
            </a>
            <a href="{{ route('volunteer.profile') }}" class="ak-mobile-nav-link {{ request()->routeIs('volunteer.profile*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil Saya
            </a>
        </nav>
        <hr class="ak-divider" style="margin-top:16px;">
        <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">
            @csrf
            <button type="submit" class="ak-mobile-nav-link"
                    style="width:100%;background:none;border:none;cursor:pointer;color:#ef4444;font-family:'Plus Jakarta Sans',sans-serif;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>

    {{-- ════════════════════════════════════════
         MAIN CONTENT
    ════════════════════════════════════════ --}}
    <main style="min-height: calc(100vh - 60px);">
        @if(session('success') || session('error') || session('warning') || session('info'))
            <div class="ak-container" style="padding-top:20px;">
                @if(session('success'))
                    <div class="ak-alert ak-alert-success" role="alert">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="ak-alert ak-alert-danger" role="alert">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="ak-alert ak-alert-warning" role="alert">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif
                @if(session('info'))
                    <div class="ak-alert ak-alert-info" role="alert">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('info') }}</span>
                    </div>
                @endif
            </div>
        @endif
        @yield('content')
    </main>

    {{-- ════════════════════════════════════════
         FOOTER
    ════════════════════════════════════════ --}}
    <footer class="ak-footer">
        <div class="ak-footer__inner">
            <div>
                <a href="{{ route('volunteer.dashboard') }}" class="ak-footer__logo">
                    <span class="ak-footer__logo-mark">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-4H7l5-8v4h4l-5 8z"/>
                        </svg>
                    </span>
                    <span class="ak-footer__logo-name">AksiKita</span>
                </a>
                <p class="ak-footer__desc">
                    Lorem Ipsum is a jumbled, standard paragraph that begins with "Lorem ipsum dolor sit amet, consectetur adipiscing elit
                </p>
                <p class="ak-footer__copy">© 2026 AksiKita</p>
                <div class="ak-footer__socials">
                    <a href="mailto:info@aksikita.id" class="ak-footer__social-btn gmail" aria-label="Email">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    </a>
                    <a href="https://wa.me/" class="ak-footer__social-btn whatsapp" aria-label="WhatsApp" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <a href="#" class="ak-footer__social-btn other" aria-label="Lainnya">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <h3 class="ak-footer__col-title">Platform</h3>
                <ul class="ak-footer__col-links">
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Cara Kerja</a></li>
                    <li><a href="#">Daftarkan Organisasi</a></li>
                </ul>
            </div>
            <div>
                <h3 class="ak-footer__col-title">Dukungan</h3>
                <ul class="ak-footer__col-links">
                    <li><a href="#">Pusat Bantuan</a></li>
                    <li><a href="#">Panduan Relawan</a></li>
                </ul>
            </div>
        </div>
    </footer>

    {{-- ════════════════════════════════════════
         SCRIPTS
    ════════════════════════════════════════ --}}
    <script>
        const volNavbar = document.getElementById('volNavbar');
        if (volNavbar) {
            window.addEventListener('scroll', () => {
                volNavbar.classList.toggle('scrolled', window.scrollY > 10);
            }, { passive: true });
        }

        async function refreshChatBadge() {
            try {
                const res  = await fetch('{{ route('volunteer.chat.unread') }}', {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();
                const badge = document.getElementById('chatBadge');
                if (badge) {
                    if (data.count > 0) {
                        badge.textContent = data.count > 99 ? '99+' : data.count;
                        badge.style.display = 'inline';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            } catch (e) {}
        }
        refreshChatBadge();
        setInterval(refreshChatBadge, 10000);

        const volHamburger  = document.getElementById('volHamburger');
        const volMobileMenu = document.getElementById('volMobileMenu');
        if (volHamburger && volMobileMenu) {
            volHamburger.addEventListener('click', () => {
                const isOpen = volHamburger.classList.toggle('open');
                volMobileMenu.classList.toggle('open', isOpen);
                volMobileMenu.setAttribute('aria-hidden', String(!isOpen));
                document.body.style.overflow = isOpen ? 'hidden' : '';
            });
            volMobileMenu.querySelectorAll('a, button').forEach(el => {
                el.addEventListener('click', () => {
                    volHamburger.classList.remove('open');
                    volMobileMenu.classList.remove('open');
                    volMobileMenu.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                });
            });
        }

        const volUserMenu    = document.getElementById('volUserMenu');
        const volUserTrigger = document.getElementById('volUserTrigger');
        if (volUserMenu && volUserTrigger) {
            volUserTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = volUserMenu.classList.toggle('open');
                volUserTrigger.setAttribute('aria-expanded', String(isOpen));
            });
            document.addEventListener('click', (e) => {
                if (!volUserMenu.contains(e.target)) {
                    volUserMenu.classList.remove('open');
                    volUserTrigger.setAttribute('aria-expanded', 'false');
                }
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    volUserMenu.classList.remove('open');
                    volUserTrigger.setAttribute('aria-expanded', 'false');
                    volUserTrigger.focus();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
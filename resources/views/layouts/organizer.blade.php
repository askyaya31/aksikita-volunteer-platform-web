<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AksiKita') — Organizer</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>
<body class="ak-fadein">

<nav class="ak-navbar" id="orgNavbar">
    <div class="ak-container">
        <div class="ak-navbar__inner">
            <a href="{{ route('organizer.dashboard') }}" class="ak-logo">
                <span class="ak-logo__mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-4H7l5-8v4h4l-5 8z"/>
                    </svg>
                </span>
                AksiKita
            </a>

            <ul class="ak-nav-links ak-nav-links-desktop" style="margin-left:16px; flex:1;">
                <li>
                    <a href="{{ route('organizer.dashboard') }}"
                       class="ak-nav-link {{ request()->routeIs('organizer.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('organizer.events') }}"
                       class="ak-nav-link {{ request()->routeIs('organizer.events*') ? 'active' : '' }}">
                        Kelola Event
                    </a>
                </li>
                <li>
                    <a href="{{ route('organizer.notifications') }}"
                       class="ak-nav-link ak-notif-badge {{ request()->routeIs('organizer.notifications') ? 'active' : '' }}">
                        Notifikasi
                        @php
                            $unreadCount = \App\Models\Notification::where('user_id', session('user_id'))
                                ->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="ak-notif-badge__count">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
            <div class="ak-nav-links-desktop" style="display:flex; align-items:center; gap:12px; margin-left:auto;">
                <div class="ak-user-menu" id="orgUserMenu">
                    <button class="ak-user-menu__trigger" id="orgUserTrigger" aria-haspopup="true" aria-expanded="false">
                        <span class="ak-avatar">{{ strtoupper(substr(session('user_name', 'O'), 0, 1)) }}</span>
                        <span style="max-width:120px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            {{ session('user_name') }}
                        </span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>
                    <div class="ak-user-menu__dropdown" id="orgUserDropdown" role="menu">
                        <div style="padding:10px 12px 8px; border-bottom:1px solid var(--color-border); margin-bottom:4px;">
                            <p style="font-size:0.8rem; font-weight:600; color:var(--color-navy); margin:0;">{{ session('user_name') }}</p>
                            <p style="font-size:0.75rem; color:var(--color-ink-muted); margin:2px 0 0;">Organizer</p>
                        </div>
                        <a href="{{ route('organizer.profile') }}" class="ak-dropdown-item" role="menuitem">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                            Profil Organisasi
                        </a>
                        <div class="ak-dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="ak-dropdown-item danger" role="menuitem">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <button class="ak-hamburger" id="orgHamburger" aria-label="Menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<div class="ak-mobile-menu" id="orgMobileMenu" aria-hidden="true">
    <a href="{{ route('organizer.dashboard') }}"
       class="ak-mobile-nav-link {{ request()->routeIs('organizer.dashboard') ? 'active' : '' }}">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
        </svg>
        Dashboard
    </a>
    <a href="{{ route('organizer.events') }}"
       class="ak-mobile-nav-link {{ request()->routeIs('organizer.events*') ? 'active' : '' }}">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Kelola Event
    </a>
    <a href="{{ route('organizer.notifications') }}"
       class="ak-mobile-nav-link {{ request()->routeIs('organizer.notifications') ? 'active' : '' }}">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
        </svg>
        Notifikasi
        @if(isset($unreadCount) && $unreadCount > 0)
            <span class="ak-notif-badge__count" style="position:static; margin-left:auto;">{{ $unreadCount }}</span>
        @endif
    </a>
    <a href="{{ route('organizer.profile') }}"
       class="ak-mobile-nav-link {{ request()->routeIs('organizer.profile') ? 'active' : '' }}">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
        </svg>
        Profil
    </a>
    <div style="margin-top:12px; padding-top:12px; border-top:1px solid var(--color-border);">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="ak-mobile-nav-link" style="width:100%; background:none; border:none; cursor:pointer; color:var(--color-danger);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</div>

@if(session('success') || session('error'))
    <div class="ak-container" style="padding-top:16px;">
        @if(session('success'))
            <div class="ak-alert ak-alert-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="flex-shrink:0; margin-top:1px;">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="ak-alert ak-alert-danger">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="flex-shrink:0; margin-top:1px;">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>
@endif

<main>
    @yield('content')
</main>

<footer class="ak-footer">
    <div class="ak-container">
        <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,0.1);">
            <div>
                <div class="ak-footer__brand">AksiKita</div>
                <p class="ak-footer__tagline">Platform kolaborasi untuk aksi sosial yang bermakna.</p>
            </div>
            <p class="ak-footer__copyright">&copy; {{ date('Y') }} AksiKita. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
const orgNav = document.getElementById('orgNavbar');
window.addEventListener('scroll', () => {
    orgNav.classList.toggle('scrolled', window.scrollY > 8);
});

const userMenu = document.getElementById('orgUserMenu');
const userTrigger = document.getElementById('orgUserTrigger');
if (userMenu && userTrigger) {
    userTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const open = userMenu.classList.toggle('open');
        userTrigger.setAttribute('aria-expanded', open);
    });
    document.addEventListener('click', (e) => {
        if (!userMenu.contains(e.target)) {
            userMenu.classList.remove('open');
            userTrigger.setAttribute('aria-expanded', 'false');
        }
    });
}

const hamburger = document.getElementById('orgHamburger');
const mobileMenu = document.getElementById('orgMobileMenu');
if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
        const open = hamburger.classList.toggle('open');
        mobileMenu.classList.toggle('open', open);
        hamburger.setAttribute('aria-expanded', open);
        mobileMenu.setAttribute('aria-hidden', !open);
    });
}
</script>

@stack('scripts')
</body>
</html>
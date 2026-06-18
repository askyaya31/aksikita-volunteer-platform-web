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
</head>
<body class="ak-fadein">
    <nav class="ak-navbar" id="volNavbar">
        <div class="ak-container">
            <div class="ak-navbar__inner">
                <a href="{{ route('volunteer.dashboard') }}" class="ak-logo">
                    <span class="ak-logo__mark" aria-hidden="true">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15v-4H7l5-8v4h4l-5 8z"/>
                        </svg>
                    </span>
                    AksiKita
                </a>
                <ul class="ak-nav-links ak-nav-links-desktop" style="margin-left:16px; flex:1;">
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
                        <a href="{{ route('volunteer.profile') }}"
                           class="ak-nav-link {{ request()->routeIs('volunteer.registrations*') ? 'active' : '' }}">
                            Pendaftaran Saya
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('volunteer.history') }}"
                           class="ak-nav-link {{ request()->routeIs('volunteer.history*') ? 'active' : '' }}">
                            Riwayat
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('volunteer.liked-events') }}"
                           class="ak-nav-link {{ request()->routeIs('volunteer.liked-events*') ? 'active' : '' }}">
                            Disukai
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('volunteer.saved-events') }}"
                           class="ak-nav-link {{ request()->routeIs('volunteer.saved-events*') ? 'active' : '' }}">
                            Tersimpan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('volunteer.schedule') }}"
                        class="ak-nav-link {{ request()->routeIs('volunteer.schedule*') ? 'active' : '' }}">
                            Jadwal
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('volunteer.chat.index') }}"
                        class="ak-nav-link {{ request()->routeIs('volunteer.chat.*') ? 'active' : '' }}"
                        style="position:relative;">
                            Pesan
                            <span id="chatBadge"
                                style="display:none; position:absolute; top:-4px; right:-10px;
                                        background:#E8501A; color:#fff; font-size:10px; font-weight:700;
                                        border-radius:999px; padding:1px 5px; line-height:1.4;">0</span>
                        </a>
                    </li>
                </ul>

                <div class="ak-nav-links-desktop" style="display:flex; align-items:center; gap:12px; margin-left:auto;">
                    <a href="{{ route('volunteer.notifications') }}"
                       class="ak-btn ak-btn-ghost ak-btn-icon ak-notif-badge"
                       aria-label="Notifikasi">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if(session('unread_count', 0) > 0)
                            <span class="ak-notif-badge__count">{{ session('unread_count') > 99 ? '99+' : session('unread_count') }}</span>
                        @endif
                    </a>

                    <div class="ak-user-menu" id="volUserMenu">
                        <button class="ak-user-menu__trigger" id="volUserTrigger" aria-haspopup="true" aria-expanded="false">
                            <span class="ak-avatar">{{ strtoupper(substr(session('user_name', 'U'), 0, 1)) }}</span>
                            <span style="max-width:120px; overflow:hidden; text-overflow:ellipsis;">{{ session('user_name', 'Volunteer') }}</span>
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="opacity:0.5; flex-shrink:0;">
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
                                    <span class="ak-badge ak-badge-danger" style="margin-left:auto; font-size:10px; padding:1px 6px;">{{ session('unread_count') }}</span>
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

                <button class="ak-hamburger" id="volHamburger" aria-label="Buka menu" style="margin-left:auto;">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

            </div>
        </div>
    </nav>

    <div class="ak-mobile-menu" id="volMobileMenu" aria-hidden="true">
        <div style="display:flex; align-items:center; gap:12px; padding:4px 4px 16px; border-bottom:1px solid var(--color-border); margin-bottom:12px;">
            <span class="ak-avatar" style="width:40px; height:40px; font-size:16px; flex-shrink:0;">{{ strtoupper(substr(session('user_name', 'U'), 0, 1)) }}</span>
            <div>
                <div style="font-weight:600; font-size:0.9rem; color:var(--color-ink);">{{ session('user_name', 'Volunteer') }}</div>
                <div style="font-size:0.8rem; color:var(--color-ink-muted);">{{ session('user_email', '') }}</div>
            </div>
        </div>

        <nav style="display:flex; flex-direction:column; gap:2px;">
            <a href="{{ route('volunteer.dashboard') }}"
               class="ak-mobile-nav-link {{ request()->routeIs('volunteer.dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="{{ route('volunteer.events') }}"
               class="ak-mobile-nav-link {{ request()->routeIs('volunteer.events*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Kegiatan
            </a>
            <a href="{{ route('volunteer.profile') }}"
               class="ak-mobile-nav-link {{ request()->routeIs('volunteer.registrations*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Pendaftaran Saya
            </a>
            <a href="{{ route('volunteer.history') }}"
               class="ak-mobile-nav-link {{ request()->routeIs('volunteer.history*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat
            </a>
            <a href="{{ route('volunteer.liked-events') }}"
               class="ak-mobile-nav-link {{ request()->routeIs('volunteer.liked-events*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Disukai
            </a>
            <a href="{{ route('volunteer.saved-events') }}"
               class="ak-mobile-nav-link {{ request()->routeIs('volunteer.saved-events*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                Tersimpan
            </a>
            <a href="{{ route('volunteer.notifications') }}"
               class="ak-mobile-nav-link {{ request()->routeIs('volunteer.notifications*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Notifikasi
                @if(session('unread_count', 0) > 0)
                    <span class="ak-badge ak-badge-danger" style="margin-left:auto;">{{ session('unread_count') }}</span>
                @endif
            </a>
            <a href="{{ route('volunteer.chat.index') }}"
                class="{{ request()->routeIs('volunteer.chat.*') ? 'nav-link active' : 'nav-link' }}">
                    Pesan
            </a>
            <a href="{{ route('volunteer.profile') }}"
               class="ak-mobile-nav-link {{ request()->routeIs('volunteer.profile*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil Saya
            </a>
            <a href="{{ route('volunteer.schedule') }}"
            class="ak-mobile-nav-link {{ request()->routeIs('volunteer.schedule*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                My Schedule
            </a>
            
        </nav>

        <hr class="ak-divider" style="margin-top:16px;">

        <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">
            @csrf
            <button type="submit" class="ak-mobile-nav-link" style="width:100%; background:none; border:none; cursor:pointer; color:var(--color-danger); font-family:var(--font-body);">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>

    <main style="min-height: calc(100vh - var(--spacing-navbar));">
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

   
    <script>
        const volNavbar = document.getElementById('volNavbar');
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
        if (volNavbar) {
            window.addEventListener('scroll', () => {
                volNavbar.classList.toggle('scrolled', window.scrollY > 10);
            }, { passive: true });
        }
        const volHamburger = document.getElementById('volHamburger');
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

        const volUserMenu = document.getElementById('volUserMenu');
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
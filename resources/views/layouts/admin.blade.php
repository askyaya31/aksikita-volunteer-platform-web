<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — AksiKita Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="ak-fadein">

    <nav class="ak-navbar" id="adminNavbar">
        <div style="width:100%; padding-inline:24px; display:flex; align-items:center; gap:12px;">

            <button class="ak-hamburger" id="adminSidebarToggle" aria-label="Toggle sidebar" style="display:flex;">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <a href="{{ route('admin.dashboard') }}" class="ak-logo">
                 <img src="{{ asset('images/logo_aksikita.png') }}" 
                    alt="AksiKita" 
                    style="height: 45px; width: auto;">
                AksiKita
            </a>
            

            <span class="ak-badge ak-badge-blue" style="font-size:11px;">Admin</span>

            <div style="margin-left:auto; display:flex; align-items:center; gap:12px;">

                @php
                    $adminUnread = \App\Models\Notification::where('user_id', session('user_id'))->where('is_read', false)->count();
                @endphp
                <a href="{{ route('admin.notifications') }}"
                   class="ak-btn ak-btn-ghost ak-btn-icon ak-notif-badge"
                   aria-label="Notifikasi">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($adminUnread > 0)
                        <span class="ak-notif-badge__count">{{ $adminUnread > 99 ? '99+' : $adminUnread }}</span>
                    @endif
                </a>

                <div class="ak-user-menu" id="adminUserMenu">
                    <button class="ak-user-menu__trigger" id="adminUserTrigger" aria-haspopup="true" aria-expanded="false">
                        <span class="ak-avatar" style="background: var(--color-blue))">
                            {{ strtoupper(substr(session('user_name', 'A'), 0, 1)) }}
                        </span>
                        <span class="ak-nav-links-desktop" style="max-width:140px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; display:inline-block;">{{ session('user_name', 'Admin') }}</span>
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="opacity:0.5; flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="ak-user-menu__dropdown" id="adminUserDropdown" role="menu">
                        <div style="padding:10px 12px 8px; border-bottom:1px solid var(--color-border); margin-bottom:4px;">
                            <div style="font-weight:600; font-size:0.875rem; color:var(--color-ink);">{{ session('user_name') }}</div>
                            <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-top:1px;">{{ session('user_email') }}</div>
                            <span class="ak-badge ak-badge-blue" style="font-size:10px; margin-top:4px; display:inline-flex;">Administrator</span>
                        </div>
                        <div class="ak-dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="ak-dropdown-item danger" role="menuitem">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <aside class="ak-sidebar" id="adminSidebar" aria-label="Navigasi admin">

        <div class="ak-sidebar-group-label">Ringkasan</div>

        <a href="{{ route('admin.dashboard') }}"
           data-label="Dashboard" class="ak-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <div class="ak-sidebar-group-label">Pengguna</div>

        <a href="{{ route('admin.users') }}"
           data-label="Semua Pengguna" class="ak-sidebar-link {{ request()->routeIs('admin.users') && !request()->get('role') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span>Semua Pengguna</span>
        </a>

        <a href="{{ route('admin.users') }}?role=volunteer"
           data-label="Volunteer" class="ak-sidebar-link {{ request()->routeIs('admin.users') && request()->get('role') === 'volunteer' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Volunteer</span>
        </a>

        <a href="{{ route('admin.users') }}?role=organization"
           data-label="Organisasi" class="ak-sidebar-link {{ request()->routeIs('admin.users') && request()->get('role') === 'organization' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span>Organisasi</span>
            @php
                $pendingOrgCount = \App\Models\OrganizationProfile::where('verification_status', 'pending')->count();
            @endphp
            @if($pendingOrgCount > 0)
                <span class="ak-sidebar-badge">{{ $pendingOrgCount }}</span>
            @endif
        </a>

        <div class="ak-sidebar-group-label">Kegiatan</div>

        <a href="{{ route('admin.events') }}"
           data-label="Semua Kegiatan" class="ak-sidebar-link {{ request()->routeIs('admin.events') && !request()->get('status') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Semua Kegiatan</span>
        </a>

        <a href="{{ route('admin.events') }}?status=pending_review"
           data-label="Pending Review" class="ak-sidebar-link {{ request()->routeIs('admin.events') && request()->get('status') === 'pending_review' ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span>Menunggu Review</span>
            @php
                $pendingEventCount = \App\Models\Event::where('status', 'pending_review')->count();
            @endphp
            @if($pendingEventCount > 0)
                <span class="ak-sidebar-badge">{{ $pendingEventCount }}</span>
            @endif
        </a>

        <div class="ak-sidebar-group-label">Laporan & Statistik</div>

        <a href="{{ route('admin.reports') }}"
           data-label="Laporan" class="ak-sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Laporan</span>
            @php $openReports = \App\Models\Report::where('status', 'open')->count(); @endphp
            @if($openReports > 0)
                <span class="ak-sidebar-badge">{{ $openReports }}</span>
            @endif
        </a>

        <a href="{{ route('admin.statistics') }}"
           data-label="Statistik" class="ak-sidebar-link {{ request()->routeIs('admin.statistics*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
            </svg>
            <span>Statistik</span>
        </a>

        <div class="ak-sidebar-group-label">Akun</div>

        <a href="{{ route('admin.notifications') }}"
           data-label="Notifikasi" class="ak-sidebar-link {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span>Notifikasi</span>
            @if(isset($adminUnread) && $adminUnread > 0)
                <span class="ak-sidebar-badge">{{ $adminUnread }}</span>
            @endif
        </a>

        <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--color-border);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="ak-sidebar-link" style="width:100%; border:none; background:none; cursor:pointer; font-family:var(--font-body); color:var(--color-danger);">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>

    </aside>
    <div id="adminSidebarOverlay" style="display:none; position:fixed; inset:0; background:rgb(0 0 0/0.4); z-index:44; top:var(--spacing-navbar);" aria-hidden="true"></div>

  
    <div class="ak-layout-with-sidebar">
        <main class="ak-main-content">
            @if(session('success') || session('error') || session('warning') || session('info'))
                <div style="margin-bottom:20px;">
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
    </div>

    <script>
        const adminNavbar = document.getElementById('adminNavbar');
        if (adminNavbar) {
            window.addEventListener('scroll', () => {
                adminNavbar.classList.toggle('scrolled', window.scrollY > 10);
            }, { passive: true });
        }

        const adminSidebar        = document.getElementById('adminSidebar');
        const adminSidebarToggle  = document.getElementById('adminSidebarToggle');
        const adminSidebarOverlay = document.getElementById('adminSidebarOverlay');
        const adminLayout         = document.querySelector('.ak-layout-with-sidebar');

        const COLLAPSE_KEY = 'ak_sidebar_collapsed';
        if (adminSidebar && localStorage.getItem(COLLAPSE_KEY) === '1' && window.innerWidth >= 1024) {
            adminSidebar.classList.add('collapsed');
            adminLayout && adminLayout.classList.add('collapsed');
        }

        function closeAdminSidebar() {
            adminSidebar.classList.remove('open');
            adminSidebarToggle.classList.remove('open');
            adminSidebarOverlay.style.display = 'none';
            document.body.style.overflow = '';
        }
        function openAdminSidebar() {
            adminSidebar.classList.add('open');
            adminSidebarToggle.classList.add('open');
            if (window.innerWidth < 1024) {
                adminSidebarOverlay.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        }

        function toggleCollapse() {
            const isCollapsed = adminSidebar.classList.toggle('collapsed');
            adminLayout && adminLayout.classList.toggle('collapsed', isCollapsed);
            localStorage.setItem(COLLAPSE_KEY, isCollapsed ? '1' : '0');
        }

        if (adminSidebarToggle && adminSidebar) {
            adminSidebarToggle.addEventListener('click', () => {
                if (window.innerWidth >= 1024) {
                    toggleCollapse();
                } else {
                    adminSidebar.classList.contains('open')
                        ? closeAdminSidebar()
                        : openAdminSidebar();
                }
            });
        }

        if (adminSidebarOverlay) {
            adminSidebarOverlay.addEventListener('click', closeAdminSidebar);
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                adminSidebarOverlay.style.display = 'none';
                document.body.style.overflow = '';
                adminSidebar.classList.remove('open');
                adminSidebarToggle.classList.remove('open');
            }
        }, { passive: true });

        const adminUserMenu = document.getElementById('adminUserMenu');
        const adminUserTrigger = document.getElementById('adminUserTrigger');
        if (adminUserMenu && adminUserTrigger) {
            adminUserTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = adminUserMenu.classList.toggle('open');
                adminUserTrigger.setAttribute('aria-expanded', String(isOpen));
            });
            document.addEventListener('click', (e) => {
                if (!adminUserMenu.contains(e.target)) {
                    adminUserMenu.classList.remove('open');
                    adminUserTrigger.setAttribute('aria-expanded', 'false');
                }
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    adminUserMenu.classList.remove('open');
                    adminUserTrigger.setAttribute('aria-expanded', 'false');
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
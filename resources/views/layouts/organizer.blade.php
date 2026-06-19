<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Organizer') — AksiKita</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #FFFFFF;
            color: #1F2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 70px; 
        }

        .ak-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .org-navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            background: #FFFFFF;
            border-bottom: 1px solid #EAEFF5;
            height: 70px;
            display: flex;
            align-items: center;
            font-family: 'Sora', sans-serif;
        }
        .org-nav-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        .org-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #0F2057;
            font-weight: 700;
            font-size: 1.25rem;
        }
        .org-brand img {
            height: 32px;
            width: auto;
        }

   
        .org-nav-menu {
            display: flex;
            align-items: center;
            gap: 28px;
            list-style: none;
        }
        .org-nav-link {
            text-decoration: none;
            color: #6B7280;
            font-size: 0.925rem;
            font-weight: 500;
            transition: color 0.2s;
            position: relative;
            padding: 8px 0;
        }
        .org-nav-link:hover, .org-nav-link.active {
            color: #0F2057;
            font-weight: 600;
        }

        .org-nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .org-icon-btn {
            background: none;
            border: 1.5px solid #EAEFF5;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1F2937;
            cursor: pointer;
            transition: all 0.2s;
        }
        .org-icon-btn:hover {
            background: #F3F4F6;
            border-color: #CBD5E1;
        }
        .org-profile-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 16px 6px 8px;
            border: 1.5px solid #EAEFF5;
            border-radius: 999px;
            background: #FFFFFF;
            cursor: pointer;
            text-decoration: none;
            color: #1F2937;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .org-profile-pill:hover {
            background: #F8FAFC;
            border-color: #0F2057;
        }
        .org-avatar-placeholder {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #DCE4EC;
        }

        .org-main {
            flex: 1;
            width: 100%;
        }
        .org-footer {
            background: #0F2057;
            color: #FFFFFF;
            padding: 4rem 0 2rem;
            margin-top: auto;
        }
        .org-footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 3rem;
        }
        .org-footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Sora', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .org-footer-logo {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
        .org-footer-desc {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            max-width: 340px;
        }
        .org-footer-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }
        .org-footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .org-footer-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s;
        }
        .org-footer-link:hover {
            color: #FFFFFF;
            text-decoration: underline;
        }
        .org-footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
            font-size: 0.825rem;
            color: rgba(255, 255, 255, 0.5);
        }
        .org-footer-socials {
            display: flex;
            gap: 12px;
        }
        .org-social-icon {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex; align-items: center; justify-content: center;
            color: #FFFFFF;
            text-decoration: none;
            transition: background 0.2s;
        }
        .org-social-icon:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        .org-social-icon--email {
            background: #FFFFFF;
        }
        .org-social-icon--email:hover {
            background: #F3F4F6;
        }

        @media (max-width: 768px) {
            .org-nav-menu { display: none; } 
            .org-footer-grid { grid-template-columns: 1fr; gap: 32px; }
        }
    </style>
</head>
<body>

    <nav class="org-navbar">
        <div class="ak-container org-nav-wrapper">
            <a href="{{ route('volunteer.dashboard') }}" class="ak-logo">
                <img src="{{ asset('images/logo_aksikita.png') }}" alt="Logo AksiKita" style="height: 36px; width: auto;">
                AksiKita
            </a>

            <ul class="org-nav-menu">
                <li>
                    <a href="{{ route('organizer.dashboard') }}" class="org-nav-link {{ request()->routeIs('organizer.dashboard') ? 'active' : '' }}">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('organizer.events') }}" class="org-nav-link {{ request()->routeIs('organizer.events*') ? 'active' : '' }}">
                        Kelola Event
                    </a>
                </li>
            </ul>

            <div class="org-nav-actions">
                <a href="{{ route('organizer.chat.index') }}" class="org-icon-btn" title="Pesan" style="text-decoration: none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </a>
                
                <a href="{{ url('organizer/notifications') }}" class="org-icon-btn" title="Notifikasi" style="text-decoration: none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </a>
                <div class="org-profile-dropdown" id="orgProfileDropdown">
                    <a href="{{ route('organizer.profile') }}" class="org-profile-pill" id="orgProfileTrigger">
                        <div class="org-avatar-placeholder">
                            @if(isset($org) && $org->logo)
                                <img src="{{ asset('storage/' . $org->logo) }}" alt="{{ $org->organization_name }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                            @else
                                {{-- Placeholder lingkaran abu-abu jika belum upload logo --}}
                                <div style="width:100%; height:100%; background:#DCE4EC; border-radius:50%;"></div>
                            @endif
                        </div>
                        <span>{{ $org->organization_name ?? 'Organisasi' }}</span>
                    </a>

                    <div class="org-profile-dropdown-menu" id="orgProfileMenu">
                        <a href="{{ route('organizer.profile') }}" class="org-profile-dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                            Lihat Profil
                        </a>
                        <div class="org-profile-dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST" class="org-profile-dropdown-logout-form">
                            @csrf
                            <button type="submit" class="org-profile-dropdown-item org-profile-dropdown-item--danger">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="org-main">
        @yield('content')
    </main>

    <footer class="org-footer">
        <div class="ak-container">
            <div class="org-footer-grid">
                <div>
                    <div class="org-footer-brand">
                        <img src="{{ asset('images/logo_aksikita.png') }}" alt="Logo AksiKita" class="org-footer-logo">
                        <span>AksiKita</span>
                    </div>
                    <p class="org-footer-desc">
                        Permudah pengelolaan program sosial dan jangkau ribuan relawan berdedikasi di Indonesia. Bersama AksiKita, mari perluas dampak positif dan gerakkan aksi kebaikan dengan lebih efektif.    
                    </p>
                </div>
                <div>
                    <h4 class="org-footer-title">Platform</h4>
                    <ul class="org-footer-links">
                        <li><a href="{{ route('home') }}#tentang" class="org-footer-link">Tentang Kami</a></li>
                        <li><a href="{{ route('home') }}#cara-kerja" class="org-footer-link">Cara Kerja</a></li>
                        <li><a href="{{ route('register.volunteer') }}" class="org-footer-link">Masuk sebagai Relawan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="org-footer-title">Dukungan</h4>
                    <ul class="org-footer-links">
                        <li><a href="#" class="org-footer-link">Pusat Bantuan</a></li>
                        <li><a href="{{ route('panduan.organisasi') }}" class="org-footer-link">Panduan Organisasi</a></li>
                    </ul>
                </div>
            </div>

            <div class="org-footer-bottom">
                <p>&copy; 2026 AksiKita. Hak Cipta Dilindungi.</p>
                <div class="org-footer-socials">
                    <a href="mailto:aksikita.support@gmail.com" class="org-social-icon" title="Email">M</a>
                    <a href="https://wa.me/6281225443229" target="_blank" rel="noopener" class="org-social-icon" title="WhatsApp">W</a>
                    <a href="https://instagram.com/aksikita__id" target="_blank" rel="noopener" class="org-social-icon" title="Instagram">I</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dropdown = document.getElementById('orgProfileDropdown');
            var trigger  = document.getElementById('orgProfileTrigger');

            if (dropdown && trigger) {
                trigger.addEventListener('click', function (e) {
                    e.preventDefault(); // cegah navigasi langsung, buka dropdown dulu
                    dropdown.classList.toggle('open');
                });

                document.addEventListener('click', function (e) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('open');
                    }
                });

                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        dropdown.classList.remove('open');
                    }
                });
            }
        });
    </script>
</body>
</html>
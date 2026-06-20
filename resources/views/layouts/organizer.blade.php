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

        .org-profile-dropdown {
            position: relative;
        }
        .org-profile-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 200px;
            background: #FFFFFF;
            border: 1.5px solid #EAEFF5;
            border-radius: 14px;
            box-shadow: 0 12px 28px rgba(15, 32, 87, 0.12);
            padding: 8px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: opacity 0.15s ease, transform 0.15s ease, visibility 0.15s ease;
            z-index: 200;
        }
        .org-profile-dropdown.open .org-profile-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .org-profile-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            color: #1F2937;
            text-decoration: none;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .org-profile-dropdown-item:hover {
            background: #F3F4F6;
        }
        .org-profile-dropdown-item--danger {
            color: #EF4444;
        }
        .org-profile-dropdown-item--danger:hover {
            background: #FEF2F2;
        }
        .org-profile-dropdown-divider {
            height: 1px;
            background: #EEF0F6;
            margin: 4px 4px;
        }
        .org-profile-dropdown-logout-form {
            width: 100%;
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
            <a href="{{ route('organizer.dashboard') }}" class="org-brand">
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
                <li>
                    <a href="{{ route('organizer.candidates.index') }}" class="org-nav-link {{ request()->routeIs('organizer.candidates*') ? 'active' : '' }}">
                        Kandidat
                    </a>
                </li>
                <li>
                    <a href="{{ route('organizer.schedule') }}"
                    class="org-nav-link {{ request()->routeIs('organizer.schedule') ? 'active' : '' }}">
                        Jadwal
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
                        Menghubungkan relawan dengan organisasi sosial di seluruh Indonesia untuk menciptakan dampak nyata. Bersama AksiKita, mari perluas dampak positif dan gerakkan aksi kebaikan dengan lebih efektif.
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
                        <li><a href="https://drive.google.com/drive/folders/1-HmfU9CaZ0Goym3lIZURkyjiPBmic0Vh" class="org-footer-link" target="_blank" rel="noopener">Pusat Bantuan</a></li>
                        <li><a href="{{ route('panduan.organisasi') }}" class="org-footer-link">Panduan Organisasi</a></li>
                    </ul>
                </div>
            </div>

            <div class="org-footer-bottom">
                <p>&copy; 2026 AksiKita. Hak Cipta Dilindungi.</p>
                <div class="org-footer-socials" style="display: flex; gap: 10px; margin-top: 4px;">
                    <a href="mailto:aksikita.support@gmail.com" class="org-social-icon gmail" title="Email Kami" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #EA4335;">
                        <svg viewBox="0 0 24 24" style="width: 16 height: 16px; fill: #fff;"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    </a>
                    <a href="https://wa.me/6281225443229" class="org-social-icon whatsapp" title="WhatsApp Kami" target="_blank" rel="noopener" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #25D366;">
                        <svg viewBox="0 0 24 24" style="width: 16px; height: 16px; fill: #fff;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <a href="https://instagram.com/aksikita__id" class="org-social-icon instagram" title="Instagram Kami" target="_blank" rel="noopener" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #E1306C;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; stroke: #fff;"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
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
                    e.preventDefault(); 
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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'AksiKita' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;0,9..144,800;1,9..144,500&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --forest:     #1c4a2e;
            --forest-mid: #2d6a44;
            --forest-lt:  #4a9462;
            --sage:       #7eb896;
            --sage-lt:    #c8e6d4;
            --cream:      #f7f3ee;
            --cream-dark: #ede8e1;
            --amber:      #d97706;
            --amber-lt:   #fef3c7;
            --coral:      #e05c5c;
            --coral-lt:   #fde8e8;
            --sky:        #2563eb;
            --sky-lt:     #dbeafe;
            --ink:        #1a1a1a;
            --ink-mid:    #4b5563;
            --ink-lt:     #9ca3af;
            --border:     #ddd8d0;
            --bg:         #f4f0eb;
            --white:      #ffffff;
            --radius-sm:  8px;
            --radius:     14px;
            --radius-lg:  20px;
            --shadow-sm:  0 1px 4px rgba(28,74,46,.08);
            --shadow:     0 4px 20px rgba(28,74,46,.1);
            --shadow-lg:  0 12px 48px rgba(28,74,46,.14);
            --trans:      all .22s cubic-bezier(.4,0,.2,1);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            font-size: 15px;
            line-height: 1.6;
        }

        /* ===================== NAV ===================== */
        .navbar {
            background: var(--forest);
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 200;
            box-shadow: 0 2px 20px rgba(28,74,46,.25);
        }
        .navbar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                90deg,
                transparent,
                transparent 40px,
                rgba(255,255,255,.015) 40px,
                rgba(255,255,255,.015) 41px
            );
            pointer-events: none;
        }
        .nav-brand {
            font-family: 'Fraunces', serif;
            font-size: 1.45rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-shrink: 0;
            letter-spacing: -.01em;
        }
        .nav-brand .leaf { font-size: 1.2rem; }
        .nav-brand em { color: var(--sage); font-style: normal; }
        .nav-links {
            display: flex;
            gap: .25rem;
            margin-left: auto;
        }
        .nav-links a {
            color: rgba(255,255,255,.72);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            padding: .4rem .9rem;
            border-radius: var(--radius-sm);
            transition: var(--trans);
            letter-spacing: .01em;
        }
        .nav-links a:hover { background: rgba(255,255,255,.12); color: #fff; }
        .nav-links a.active { background: rgba(255,255,255,.18); color: #fff; font-weight: 600; }
        .nav-links .btn-nav-add {
            background: var(--amber);
            color: white;
            border-radius: var(--radius-sm);
            font-weight: 600;
        }
        .nav-links .btn-nav-add:hover { background: #b45309; color: white; }

        /* ===================== LAYOUT ===================== */
        .container { max-width: 1120px; margin: 0 auto; padding: 2.5rem 1.5rem; }
        .container-sm { max-width: 760px; margin: 0 auto; padding: 2.5rem 1.5rem; }

        /* ===================== PAGE HEADER ===================== */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }
        .page-header h1 {
            font-family: 'Fraunces', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -.02em;
            line-height: 1.2;
        }
        .page-header p { color: var(--ink-mid); margin-top: .3rem; font-size: .9rem; }
        .page-header-actions { display: flex; gap: .6rem; flex-wrap: wrap; }

        /* ===================== BUTTONS ===================== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .55rem 1.2rem;
            border-radius: var(--radius-sm);
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: var(--trans);
            letter-spacing: .01em;
            white-space: nowrap;
        }
        .btn:active { transform: scale(.97); }

        .btn-primary   { background: var(--forest); color: #fff; }
        .btn-primary:hover  { background: var(--forest-mid); color: #fff; }
        .btn-secondary { background: var(--cream-dark); color: var(--ink); border: 1px solid var(--border); }
        .btn-secondary:hover { background: var(--border); color: var(--ink); }
        .btn-warning   { background: var(--amber-lt); color: var(--amber); border: 1px solid #fcd34d; }
        .btn-warning:hover { background: #fde68a; color: var(--amber); }
        .btn-danger    { background: var(--coral-lt); color: var(--coral); border: 1px solid #fca5a5; }
        .btn-danger:hover { background: #fecaca; color: var(--coral); }
        .btn-ghost     { background: transparent; color: var(--ink-mid); }
        .btn-ghost:hover { background: var(--cream-dark); color: var(--ink); }
        .btn-sm        { padding: .35rem .8rem; font-size: .8rem; }
        .btn-lg        { padding: .75rem 1.6rem; font-size: 1rem; border-radius: var(--radius); }

        /* ===================== CARDS ===================== */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .card-body { padding: 1.5rem; }
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .card-header h3 {
            font-family: 'Fraunces', serif;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--ink);
        }

        /* ===================== STATS ===================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 1.25rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow-sm);
            transition: var(--trans);
        }
        .stat-card:hover { box-shadow: var(--shadow); transform: translateY(-1px); }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .si-green  { background: #dcfce7; }
        .si-amber  { background: var(--amber-lt); }
        .si-sky    { background: var(--sky-lt); }
        .si-coral  { background: var(--coral-lt); }
        .stat-num {
            font-family: 'Fraunces', serif;
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1;
            color: var(--forest);
        }
        .stat-label { font-size: .8rem; color: var(--ink-mid); margin-top: .2rem; font-weight: 500; }

        /* ===================== TABLE ===================== */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: var(--cream); }
        th {
            text-align: left;
            padding: .85rem 1rem;
            font-size: .78rem;
            font-weight: 700;
            color: var(--ink-mid);
            text-transform: uppercase;
            letter-spacing: .08em;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        td {
            padding: .9rem 1rem;
            border-bottom: 1px solid var(--cream-dark);
            vertical-align: middle;
            font-size: .875rem;
        }
        tbody tr { transition: background .15s; }
        tbody tr:hover { background: var(--cream); }
        tbody tr:last-child td { border-bottom: none; }
        .table-meta { padding: .6rem 1rem; font-size: .78rem; color: var(--ink-lt); border-top: 1px solid var(--border); }

        /* ===================== BADGES ===================== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: .25rem;
            padding: .2rem .65rem;
            border-radius: 100px;
            font-size: .74rem;
            font-weight: 600;
            letter-spacing: .01em;
            white-space: nowrap;
        }
        .badge-akan-datang { background: var(--sky-lt);   color: var(--sky); }
        .badge-berlangsung  { background: var(--amber-lt); color: var(--amber); }
        .badge-selesai      { background: #dcfce7; color: #15803d; }
        .badge-lain         { background: #f3f4f6; color: var(--ink-mid); }
        .badge-kat-lingkungan { background: #dcfce7; color: #166534; }
        .badge-kat-sosial     { background: var(--sky-lt); color: #1d4ed8; }
        .badge-kat-pendidikan { background: var(--amber-lt); color: #92400e; }
        .badge-kat-kesehatan  { background: var(--coral-lt); color: #991b1b; }
        .badge-kat-lainnya    { background: #f3f4f6; color: var(--ink-mid); }

        /* ===================== FORMS ===================== */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        .form-group { display: flex; flex-direction: column; gap: .4rem; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label {
            font-size: .82rem;
            font-weight: 600;
            color: var(--ink-mid);
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: .65rem .9rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            color: var(--ink);
            background: var(--white);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            width: 100%;
        }
        .form-group textarea { min-height: 120px; resize: vertical; line-height: 1.6; }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--forest-mid);
            box-shadow: 0 0 0 3px rgba(45,106,68,.12);
        }
        .form-group input::placeholder { color: var(--ink-lt); }
        .form-hint { font-size: .78rem; color: var(--ink-lt); margin-top: -.15rem; }
        .form-actions { display: flex; gap: .75rem; align-items: center; flex-wrap: wrap; }

        /* ===================== ALERTS ===================== */
        .alert {
            padding: .9rem 1.2rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            font-size: .9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .5rem;
            border-left: 4px solid transparent;
        }
        .alert-success { background: #f0fdf4; color: #166534; border-left-color: #16a34a; }
        .alert-info    { background: var(--sky-lt); color: #1d4ed8; border-left-color: var(--sky); }
        .alert-error   { background: var(--coral-lt); color: #991b1b; border-left-color: var(--coral); }
        .alert ul { margin: .3rem 0 0 1.2rem; }

        /* ===================== EMPTY STATE ===================== */
        .empty {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--ink-mid);
        }
        .empty-icon { font-size: 3.5rem; margin-bottom: 1rem; opacity: .6; }
        .empty h3 {
            font-family: 'Fraunces', serif;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: .5rem;
            color: var(--ink);
        }
        .empty p { font-size: .875rem; }

        /* ===================== DETAIL ===================== */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .detail-item {
            background: var(--cream);
            border-radius: var(--radius-sm);
            padding: .9rem 1rem;
            display: flex;
            flex-direction: column;
            gap: .2rem;
        }
        .detail-item .label { font-size: .75rem; font-weight: 700; color: var(--ink-lt); text-transform: uppercase; letter-spacing: .07em; }
        .detail-item .value { font-size: .95rem; font-weight: 600; color: var(--ink); }
        .detail-desc {
            margin-top: 1.25rem;
            padding: 1.25rem;
            background: var(--cream);
            border-radius: var(--radius-sm);
        }
        .detail-desc .label { font-size: .75rem; font-weight: 700; color: var(--ink-lt); text-transform: uppercase; letter-spacing: .07em; margin-bottom: .5rem; display: block; }

        /* ===================== HERO ===================== */
        .hero {
            background: var(--forest);
            border-radius: var(--radius-lg);
            padding: 3rem 2.5rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(126,184,150,.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 30%;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(217,119,6,.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 100px;
            padding: .25rem .85rem;
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 1rem;
            backdrop-filter: blur(4px);
        }
        .hero h1 {
            font-family: 'Fraunces', serif;
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -.03em;
            margin-bottom: .9rem;
        }
        .hero h1 em { color: var(--sage); font-style: italic; }
        .hero p { opacity: .8; max-width: 500px; font-size: .95rem; line-height: 1.7; }
        .hero-actions { margin-top: 2rem; display: flex; gap: .75rem; flex-wrap: wrap; }
        .hero-btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .7rem 1.6rem;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: .9rem;
            text-decoration: none;
            transition: var(--trans);
        }
        .hero-btn-white { background: white; color: var(--forest); }
        .hero-btn-white:hover { background: var(--cream); color: var(--forest); }
        .hero-btn-amber { background: var(--amber); color: white; }
        .hero-btn-amber:hover { background: #b45309; color: white; }

        /* ===================== FILTER BAR ===================== */
        .filter-bar {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.1rem 1.25rem;
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            align-items: flex-end;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        .filter-bar .fg { display: flex; flex-direction: column; gap: .3rem; }
        .filter-bar label { font-size: .75rem; font-weight: 700; color: var(--ink-mid); text-transform: uppercase; letter-spacing: .06em; }
        .filter-bar input,
        .filter-bar select {
            padding: .5rem .85rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: .875rem;
            color: var(--ink);
            background: var(--white);
            outline: none;
            transition: border-color .2s;
        }
        .filter-bar input:focus, .filter-bar select:focus { border-color: var(--forest-mid); }
        .filter-bar input { width: 200px; }

        /* ===================== FOOTER ===================== */
        footer {
            background: var(--forest);
            color: rgba(255,255,255,.65);
            text-align: center;
            padding: 1.75rem;
            font-size: .82rem;
            margin-top: auto;
            letter-spacing: .01em;
        }
        footer strong { color: rgba(255,255,255,.9); }
        footer a { color: var(--sage); text-decoration: none; }

        /* ===================== UTILS ===================== */
        .text-muted { color: var(--ink-lt); }
        .text-sub { font-size: .82rem; color: var(--ink-mid); }
        .fw-bold { font-weight: 700; }
        .divider { height: 1px; background: var(--border); margin: 1.5rem 0; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-sm { gap: .5rem; }
        .gap-md { gap: 1rem; }
        .mt-1 { margin-top: .5rem; }
        .mt-2 { margin-top: 1rem; }
        .mb-2 { margin-bottom: 1rem; }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .navbar { padding: 0 1rem; }
            .nav-links a:not(.btn-nav-add) { display: none; }
            .container, .container-sm { padding: 1.5rem 1rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full { grid-column: 1; }
            .detail-grid { grid-template-columns: 1fr; }
            .hero { padding: 2rem 1.5rem; }
            .hero h1 { font-size: 1.8rem; }
            .page-header { flex-direction: column; }
            .filter-bar input { width: 100%; }
            th, td { padding: .7rem .75rem; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="<?= str_contains($_SERVER['PHP_SELF'], '/pages/') ? '../' : '' ?>index.php" class="nav-brand">
        <span class="leaf">🌿</span> Aksi<em>Kita</em>
    </a>
    <div class="nav-links">
        <?php
        $base = str_contains($_SERVER['PHP_SELF'], '/pages/') ? '../' : '';
        ?>
        <a href="<?= $base ?>index.php" class="<?= isPageActive('index.php') ?>">Beranda</a>
        <a href="<?= $base ?>pages/kegiatan.php" class="<?= isPageActive('kegiatan.php') ?>">Kegiatan</a>
        <a href="<?= $base ?>pages/tambah.php" class="btn-nav-add <?= isPageActive('tambah.php') ?>">➕ Tambah</a>
    </div>
</nav>

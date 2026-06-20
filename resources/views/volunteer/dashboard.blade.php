@extends('layouts.volunteer')
@section('title', 'Dashboard — AksiKita')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>

:root{
    --navy:        #0F2057;
    --blue:        #0066FF;
    --blue-mid:    #4D8DFF;
    --blue-light:  #93C5FD;
    --blue-pale:   #DCE9FF;
    --sky-50:      #F6F9FF;
    --ink:         #1F2937;
    --ink-soft:    #6B7280;
    --ember:       #E8501A;
    --font-display:'Plus Jakarta Sans', sans-serif;
    --font-body:   'Inter', sans-serif;
}

*, *::before, *::after { box-sizing: border-box; }
.ak-container, .vd-body, .vd-hero { font-family: var(--font-body); }

.reveal {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity .6s cubic-bezier(.4,0,.2,1), transform .6s cubic-bezier(.4,0,.2,1);
}
.reveal.visible { opacity: 1; transform: none; }

@media (prefers-reduced-motion: reduce) {
    .reveal { opacity: 1 !important; transform: none !important; transition: none !important; }
    *, *::before, *::after { animation-duration: .001ms !important; animation-iteration-count: 1 !important; transition-duration: .001ms !important; }
}

@keyframes pulseDot {
    0%,100% { box-shadow: 0 0 0 2px rgba(220,233,255,0.35); }
    50%      { box-shadow: 0 0 0 6px rgba(220,233,255,0.12); }
}

.vd-hero {
    position: relative;
    overflow: hidden;
    padding: 3rem 0 5.5rem;
    background: linear-gradient(125deg, var(--navy) 0%, var(--blue) 65%, var(--blue-mid) 100%);
    border-radius: 0 0 28px 28px;
}
.vd-hero::after{
    content:'';
    position:absolute;
    width: 320px; height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(220,233,255,0.22) 0%, transparent 70%);
    top: -110px; right: -70px;
    pointer-events: none;
}

.vd-hero__inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

.vd-hero__left { flex: 1; min-width: 240px; }

.vd-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    font-weight: 600;
    color: rgba(255,255,255,0.62);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 12px;
}
.vd-hero__eyebrow-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--blue-pale);
    animation: pulseDot 2.2s ease-in-out infinite;
}

.vd-hero__greeting {
    font-size: 14px;
    font-weight: 400;
    color: rgba(255,255,255,0.65);
    margin: 0 0 2px;
}

.vd-hero__name {
    font-family: var(--font-display);
    font-size: clamp(1.7rem, 3.2vw, 2.3rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
    letter-spacing: -0.02em;
    margin: 0 0 18px;
    max-width: 480px;
}

.vd-hero__actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.vd-hero__btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 24px;
    border-radius: 999px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
}
.vd-hero__btn--primary {
    background: #fff;
    color: var(--navy);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
.vd-hero__btn--primary:hover {
    background: var(--blue-pale);
    transform: translateY(-1px);
    color: var(--navy);
}
.vd-hero__btn--ghost {
    background: rgba(255,255,255,0.1);
    border: 1.5px solid rgba(255,255,255,0.3);
    color: rgba(255,255,255,0.92);
}
.vd-hero__btn--ghost:hover {
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.5);
    color: #fff;
}

.vd-hero__next {
    display: flex;
    align-items: center;
    gap: 14px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.22);
    border-radius: 16px;
    padding: 14px 20px;
    margin-top: 22px;
    max-width: 420px;
    text-decoration: none;
    transition: background 0.2s, border-color 0.2s;
}
.vd-hero__next:hover {
    background: rgba(255,255,255,0.16);
    border-color: rgba(255,255,255,0.34);
}
.vd-hero__next-date {
    flex-shrink: 0;
    width: 44px;
    text-align: center;
}
.vd-hero__next-date-d {
    font-family: var(--font-display);
    font-size: 1.15rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.vd-hero__next-date-m {
    font-size: 9.5px;
    font-weight: 700;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.vd-hero__next-divider {
    width: 1px;
    height: 28px;
    background: rgba(255,255,255,0.22);
    flex-shrink: 0;
}
.vd-hero__next-body { min-width: 0; }
.vd-hero__next-label {
    font-size: 10.5px;
    font-weight: 700;
    color: rgba(255,255,255,0.55);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 2px;
}
.vd-hero__next-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.vd-hero__card {
    flex-shrink: 0;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.22);
    border-radius: 22px;
    padding: 22px 26px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    min-width: 200px;
    box-shadow: 0 18px 40px rgba(8,16,45,0.22);
}
.vd-hero__avatar {
    width: 72px; height: 72px;
    border-radius: 18px;
    background: linear-gradient(140deg, var(--blue-light), var(--blue-mid));
    border: 3px solid rgba(255,255,255,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.7rem;
    font-weight: 800;
    color: #fff;
    overflow: hidden;
    flex-shrink: 0;
}
.vd-hero__avatar img { width: 100%; height: 100%; object-fit: cover; }
.vd-hero__card-name {
    font-family: var(--font-display);
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    text-align: center;
    line-height: 1.3;
    max-width: 160px;
}
.vd-hero__stats { display: flex; gap: 12px; width: 100%; }
.vd-hero__stat {
    flex: 1;
    text-align: center;
    padding: 9px 6px;
    background: rgba(255,255,255,0.08);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.14);
}
.vd-hero__stat-val {
    font-family: var(--font-display);
    font-size: 1.3rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.vd-hero__stat-lbl {
    font-size: 9.5px;
    color: rgba(255,255,255,0.55);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-top: 3px;
}
.vd-body {
    background: var(--sky-50);
    padding: 2.5rem 0 5rem;
}

.vd-sec { margin-bottom: 2.85rem; }
.vd-sec-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    gap: 12px;
}
.vd-sec-title {
    font-family: var(--font-display);
    font-size: 1.18rem;
    font-weight: 800;
    color: var(--navy);
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.vd-sec-sub {
    font-size: 12.5px;
    color: var(--ink-soft);
    margin-top: 2px;
    font-weight: 500;
}
.vd-see-all {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12.5px;
    font-weight: 700;
    color: var(--blue);
    text-decoration: none;
    white-space: nowrap;
    transition: gap 0.15s, color .15s;
    flex-shrink: 0;
}
.vd-see-all:hover { gap: 8px; color: var(--navy); }

.nearby-carousel-wrap { position: relative; }
.nearby-carousel {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    padding: 4px 4px 10px;
    scrollbar-width: none;
}
.nearby-carousel::-webkit-scrollbar { display: none; }

.nearby-card {
    scroll-snap-align: start;
    flex-shrink: 0;
    width: 340px;
    height: 220px;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: transform .3s cubic-bezier(.2,.7,.3,1), box-shadow .3s;
    text-decoration: none;
    display: block;
    box-shadow: 0 8px 20px rgba(15,32,87,0.10);
}
.nearby-card:hover {
    transform: translateY(-6px) scale(1.015);
    box-shadow: 0 22px 40px rgba(15,32,87,0.22);
}

.nearby-card__img {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
    background: linear-gradient(135deg, var(--navy) 0%, var(--blue-mid) 100%);
}
.nearby-card:hover .nearby-card__img { transform: scale(1.06); }
.nearby-card__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15,32,87,0.88) 0%, rgba(15,32,87,0.25) 55%, transparent 100%);
}
.nearby-card__badge {
    position: absolute;
    top: 14px; left: 14px;
    background: rgba(255,255,255,0.92);
    color: var(--navy);
    font-size: 10.5px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 999px;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}
.nearby-card__body {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 16px 18px;
}
.nearby-card__title {
    font-size: 15px;
    font-weight: 800;
    color: #fff;
    line-height: 1.3;
    margin-bottom: 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.nearby-card__loc {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    color: rgba(255,255,255,0.75);
}
.nearby-card__cta {
    position: absolute;
    bottom: 16px; right: 16px;
    display: flex;
    align-items: center;
    gap: 5px;
    background: rgba(255,255,255,0.18);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.28);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 6px 12px;
    border-radius: 999px;
    transition: background 0.15s;
}
.nearby-card:hover .nearby-card__cta { background: rgba(255,255,255,0.3); }

.carousel-dots {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-top: 14px;
}
.carousel-dot {
    width: 6px; height: 6px;
    border-radius: 999px;
    background: var(--blue-light);
    transition: all 0.25s;
    cursor: pointer;
    border: none;
    padding: 0;
}
.carousel-dot.active { width: 18px; background: var(--navy); }

.carousel-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #fff;
    border: none;
    box-shadow: 0 4px 16px rgba(15,32,87,0.18);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--navy);
    transition: all 0.15s;
    z-index: 5;
}
.carousel-arrow:hover { background: var(--blue); color: #fff; transform: translateY(-50%) scale(1.08); }
.carousel-arrow--prev { left: -16px; }
.carousel-arrow--next { right: -16px; }

.sched-list { display: flex; flex-direction: column; gap: 10px; }
.sched-card {
    display: flex;
    align-items: stretch;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(15,32,87,0.06);
    border: 1px solid #EEF0F6;
    text-decoration: none;
    transition: box-shadow 0.25s, transform 0.25s, border-color .25s;
}
.sched-card:hover {
    box-shadow: 0 14px 32px rgba(15,32,87,0.14);
    transform: translateY(-3px);
    border-color: var(--blue-light);
}

.sched-date {
    flex-shrink: 0;
    width: 68px;
    background: linear-gradient(165deg, var(--navy), var(--blue));
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 16px 8px;
    gap: 2px;
}
.sched-date__d {
    font-family: var(--font-display);
    font-size: 1.8rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.sched-date__m {
    font-size: 10.5px;
    font-weight: 700;
    color: rgba(255,255,255,0.65);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.sched-content { flex: 1; padding: 15px 18px; min-width: 0; }
.sched-org {
    font-size: 10.5px;
    font-weight: 700;
    color: var(--blue);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 4px;
}
.sched-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 7px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sched-meta { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
.sched-meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    color: var(--ink-soft);
    font-weight: 500;
}

.sched-right { flex-shrink: 0; display: flex; align-items: center; padding: 0 18px; }
.sched-badge {
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    background: #E7F6EF;
    color: #0E9B6B;
}
.sched-badge.pending { background: #FFF4E0; color: #C2790A; }

.reco-scroll {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    padding: 4px 4px 12px;
    scrollbar-width: none;
}
.reco-scroll::-webkit-scrollbar { display: none; }

.reco-card {
    scroll-snap-align: start;
    flex-shrink: 0;
    width: 240px;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid #EEF0F6;
    box-shadow: 0 2px 10px rgba(15,32,87,0.06);
    text-decoration: none;
    transition: transform 0.25s, box-shadow 0.25s, border-color .25s;
    display: flex;
    flex-direction: column;
}
.reco-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 34px rgba(15,32,87,0.16);
    border-color: var(--blue-light);
}
.reco-card__img {
    height: 140px;
    background: linear-gradient(135deg, var(--navy), var(--blue-mid));
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
}
.reco-card__img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.45s; }
.reco-card:hover .reco-card__img img { transform: scale(1.08); }
.reco-card__cat {
    position: absolute;
    bottom: 10px; left: 10px;
    font-size: 9.5px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
    background: rgba(255,255,255,0.94);
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.reco-card__body { padding: 14px 16px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
.reco-card__title {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--navy);
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.reco-card__meta { display: flex; align-items: center; gap: 4px; font-size: 11px; color: var(--ink-soft); }
.reco-card__footer {
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px solid var(--sky-50);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.reco-card__slots { font-size: 11.5px; font-weight: 700; color: var(--ember); }
.reco-card__btn {
    font-size: 11.5px;
    font-weight: 700;
    color: var(--navy);
    background: var(--sky-50);
    border-radius: 999px;
    padding: 5px 12px;
    transition: all 0.15s;
}
.reco-card:hover .reco-card__btn { background: var(--blue); color: #fff; }

.vd-events-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }

.evcard {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #EEF0F6;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 8px rgba(15,32,87,0.05);
    text-decoration: none;
    transition: box-shadow 0.25s, transform 0.25s, border-color .25s, opacity .5s, transform .5s;
}
.evcard.reveal { transform: translateY(14px); }
.evcard.reveal.visible { transform: none; }
.evcard:hover {
    box-shadow: 0 14px 36px rgba(15,32,87,0.14);
    transform: translateY(-4px);
    border-color: var(--blue-light);
}
.evcard__img { height: 156px; background: linear-gradient(135deg, var(--navy), var(--blue-mid)); position: relative; overflow: hidden; }
.evcard__img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.45s; }
.evcard:hover .evcard__img img { transform: scale(1.05); }
.evcard__cats { position: absolute; bottom: 10px; left: 10px; display: flex; gap: 5px; flex-wrap: wrap; }
.evcard__cat {
    font-size: 9.5px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 999px;
    background: rgba(255,255,255,0.94);
    color: var(--navy);
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.evcard__body { padding: 16px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
.evcard__org { font-size: 10.5px; font-weight: 700; color: var(--blue); text-transform: uppercase; letter-spacing: 0.05em; }
.evcard__title {
    font-family: var(--font-display);
    font-size: 15px;
    font-weight: 700;
    color: var(--navy);
    line-height: 1.35;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.evcard__meta { display: flex; flex-direction: column; gap: 5px; }
.evcard__meta-row { display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: var(--ink-soft); font-weight: 500; }

.evcard__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px 14px;
    border-top: 1px solid var(--sky-50);
    gap: 8px;
}
.evcard__slots { font-size: 12px; font-weight: 700; color: var(--ember); display: flex; align-items: center; gap: 5px; }
.evcard__btn {
    padding: 7px 18px;
    background: var(--navy);
    color: #fff;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.18s, transform 0.18s;
    white-space: nowrap;
}
.evcard__btn:hover { background: var(--blue); transform: scale(1.04); color: #fff; }

.vd-chips { display: flex; gap: 7px; flex-wrap: wrap; margin-bottom: 1rem; }
.vd-chip {
    display: inline-flex;
    align-items: center;
    padding: 6px 18px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 600;
    border: 1.5px solid var(--blue-pale);
    background: #fff;
    color: var(--ink-soft);
    text-decoration: none;
    transition: all 0.18s;
    cursor: pointer;
}
.vd-chip:hover { border-color: var(--blue); color: var(--blue); background: var(--sky-50); }
.vd-chip.active {
    background: var(--navy);
    border-color: transparent;
    color: #fff;
}

.vd-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--blue-light), transparent);
    margin: 2.5rem 0;
}

.vd-empty {
    text-align: center;
    padding: 48px 24px;
    color: var(--ink-soft);
    font-size: 13.5px;
    background: #fff;
    border: 1px dashed var(--blue-light);
    border-radius: 16px;
}

@media (max-width: 1024px) { .vd-events-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .vd-hero__card { display: none; }
    .vd-hero__inner { flex-direction: column; align-items: flex-start; }
    .vd-events-grid { grid-template-columns: 1fr; }
    .nearby-card { width: 280px; }
    .carousel-arrow { display: none; }
}
@media (max-width: 480px) {
    .vd-hero { padding: 2.25rem 0 4rem; }
    .reco-card { width: 210px; }
}
</style>
@endpush

@section('content')

<section class="vd-hero">
    <div class="ak-container">
        <div class="vd-hero__inner">

            <div class="vd-hero__left">
                <div class="vd-hero__eyebrow">
                    Dashboard Relawan
                </div>
                <p class="vd-hero__greeting">Selamat datang,</p>
                <h1 class="vd-hero__name">{{ session('user_name', 'Relawan') }}</h1>

                <div class="vd-hero__actions">
                    <a href="{{ route('volunteer.events') }}" class="vd-hero__btn vd-hero__btn--primary">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Cari Kegiatan
                    </a>
                    <a href="{{ route('volunteer.schedule') }}" class="vd-hero__btn vd-hero__btn--ghost">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Jadwal Saya
                    </a>
                </div>

                @if(isset($upcomingSchedule) && $upcomingSchedule->isNotEmpty())
                    @php $nextReg = $upcomingSchedule->first(); $nextEv = $nextReg->event; @endphp
                    <a href="{{ route('volunteer.events.show', $nextEv->slug) }}" class="vd-hero__next">
                        <div class="vd-hero__next-date">
                            <div class="vd-hero__next-date-d">{{ \Carbon\Carbon::parse($nextEv->start_date)->format('d') }}</div>
                            <div class="vd-hero__next-date-m">{{ \Carbon\Carbon::parse($nextEv->start_date)->translatedFormat('M') }}</div>
                        </div>
                        <div class="vd-hero__next-divider"></div>
                        <div class="vd-hero__next-body">
                            <div class="vd-hero__next-label">Kegiatan Terdekat</div>
                            <div class="vd-hero__next-title">{{ $nextEv->title }}</div>
                        </div>
                    </a>
                @endif
            </div>

            <div class="vd-hero__card">
                <div class="vd-hero__avatar">
                    @if(session('user_avatar'))
                        <img src="{{ Storage::url(session('user_avatar')) }}" alt="{{ session('user_name') }}">
                    @else
                        {{ strtoupper(substr(session('user_name', 'R'), 0, 1)) }}
                    @endif
                </div>
                <div class="vd-hero__card-name">{{ session('user_name', 'Relawan') }}</div>
                @php
                    $totalJoin  = isset($upcomingSchedule) ? $upcomingSchedule->count() : 0;
                    $totalHadir = \App\Models\Registration::where('user_id', session('user_id'))->where('status', 'attended')->count();
                @endphp
                <div class="vd-hero__stats">
                    <div class="vd-hero__stat">
                        <div class="vd-hero__stat-val" data-count="{{ $totalJoin }}">0</div>
                        <div class="vd-hero__stat-lbl">Aktif</div>
                    </div>
                    <div class="vd-hero__stat">
                        <div class="vd-hero__stat-val" data-count="{{ $totalHadir }}">0</div>
                        <div class="vd-hero__stat-lbl">Selesai</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<div class="vd-body">
<div class="ak-container">

    @if(isset($nearbyEvents) && $nearbyEvents->isNotEmpty())
    <div class="vd-sec reveal" id="sec-nearby">
        <div class="vd-sec-head">
            <div>
                <div class="vd-sec-title">
                    Kegiatan di {{ $user->volunteerProfile?->city ?? 'Sekitarmu' }}
                </div>
                <div class="vd-sec-sub">Jangan lewatkan kegiatan di sekitarmu</div>
            </div>
            <a href="{{ route('volunteer.events') }}" class="vd-see-all">
                Lihat semua
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="nearby-carousel-wrap">
            <button class="carousel-arrow carousel-arrow--prev" id="nearby-prev" aria-label="Sebelumnya">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <div class="nearby-carousel" id="nearby-carousel">
                @foreach($nearbyEvents as $idx => $event)
                <a href="{{ route('volunteer.events.show', $event->slug) }}" class="nearby-card" data-index="{{ $idx }}">
                    @if($event->poster)
                        <img src="{{ Storage::url($event->poster) }}"
                             alt="{{ $event->title }}"
                             class="nearby-card__img"
                             onerror="this.style.display='none'">
                    @else
                        <div class="nearby-card__img"></div>
                    @endif
                    <div class="nearby-card__overlay"></div>
                    <div class="nearby-card__badge">Kegiatan Terdekat</div>
                    <div class="nearby-card__body">
                        <div class="nearby-card__title">{{ $event->title }}</div>
                        <div class="nearby-card__loc">
                            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $event->location_name ? $event->location_name . ', ' : '' }}{{ $event->city }}
                        </div>
                    </div>
                    <div class="nearby-card__cta">
                        Lihat Detail
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                @endforeach
            </div>

            <button class="carousel-arrow carousel-arrow--next" id="nearby-next" aria-label="Berikutnya">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <div class="carousel-dots" id="nearby-dots">
            @foreach($nearbyEvents as $idx => $event)
                <button class="carousel-dot {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}"></button>
            @endforeach
        </div>
    </div>
    @endif

    @if(isset($upcomingSchedule) && $upcomingSchedule->isNotEmpty())
    <div class="vd-sec reveal" id="sec-schedule" style="transition-delay: 0.08s;">
        <div class="vd-sec-head">
            <div>
                <div class="vd-sec-title">Jadwal Mendatang</div>
                <div class="vd-sec-sub">Kegiatan yang akan kamu ikuti</div>
            </div>
            <a href="{{ route('volunteer.schedule') }}" class="vd-see-all">
                Lihat semua
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="sched-list">
            @foreach($upcomingSchedule as $reg)
                @php $ev = $reg->event; @endphp
                <a href="{{ route('volunteer.events.show', $ev->slug) }}" class="sched-card">
                    <div class="sched-date">
                        <div class="sched-date__d">{{ \Carbon\Carbon::parse($ev->start_date)->format('d') }}</div>
                        <div class="sched-date__m">{{ \Carbon\Carbon::parse($ev->start_date)->format('M') }}</div>
                    </div>
                    <div class="sched-content">
                        @if($ev->organization)
                            <div class="sched-org">
                                {{ $ev->organization->organization_name ?? $ev->organization->name ?? '' }}
                            </div>
                        @endif
                        <div class="sched-title">{{ $ev->title }}</div>
                        <div class="sched-meta">
                            @if($ev->start_time)
                            <span class="sched-meta-item">
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ substr($ev->start_time, 0, 5) }}{{ $ev->end_time ? ' – ' . substr($ev->end_time, 0, 5) : '' }}
                            </span>
                            @endif
                            @if($ev->city)
                            <span class="sched-meta-item">
                                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                {{ $ev->city }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="sched-right">
                        <span class="sched-badge {{ $reg->status === 'confirmed' ? '' : 'pending' }}">
                            {{ $reg->status === 'confirmed' ? 'Diterima' : 'Upcoming' }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    @if(isset($recommendations) && $recommendations->isNotEmpty())
    <div class="vd-sec reveal" id="sec-reco" style="transition-delay: 0.12s;">
        <div class="vd-sec-head">
            <div>
                <div class="vd-sec-title">Rekomendasi untuk Kamu</div>
                <div class="vd-sec-sub">Berdasarkan minat & riwayat kegiatanmu</div>
            </div>
            <a href="{{ route('volunteer.events') }}" class="vd-see-all">
                Lihat semua
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="reco-scroll">
            @foreach($recommendations as $event)
            <a href="{{ route('volunteer.events.show', $event->slug) }}" class="reco-card">
                <div class="reco-card__img">
                    @if($event->poster)
                        <img src="{{ Storage::url($event->poster) }}"
                             alt="{{ $event->title }}"
                             onerror="this.style.display='none'">
                    @endif
                    @if($event->categories->isNotEmpty())
                        <span class="reco-card__cat">{{ $event->categories->first()->name }}</span>
                    @endif
                </div>
                <div class="reco-card__body">
                    <div class="reco-card__title">{{ $event->title }}</div>
                    <div class="reco-card__meta">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        {{ $event->city }}
                    </div>
                    <div class="reco-card__meta">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                    </div>
                    <div class="reco-card__footer">
                        @if($event->remaining_quota !== null)
                            <span class="reco-card__slots">{{ $event->remaining_quota }} slot</span>
                        @else
                            <span></span>
                        @endif
                        <span class="reco-card__btn">Lihat →</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @elseif(isset($fallbackEvents) && $fallbackEvents->isNotEmpty())
    <div class="vd-sec reveal" id="sec-reco-fallback" style="transition-delay: 0.12s;">
        <div class="vd-sec-head">
            <div>
                <div class="vd-sec-title">Kegiatan Terbaru</div>
                <div class="vd-sec-sub">Mulai berkontribusi dari sini</div>
            </div>
            <a href="{{ route('volunteer.events') }}" class="vd-see-all">
                Lihat semua
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="reco-scroll">
            @foreach($fallbackEvents as $event)
            <a href="{{ route('volunteer.events.show', $event->slug) }}" class="reco-card">
                <div class="reco-card__img">
                    @if($event->poster)
                        <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" onerror="this.style.display='none'">
                    @endif
                    @if($event->categories->isNotEmpty())
                        <span class="reco-card__cat">{{ $event->categories->first()->name }}</span>
                    @endif
                </div>
                <div class="reco-card__body">
                    <div class="reco-card__title">{{ $event->title }}</div>
                    <div class="reco-card__meta">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        {{ $event->city }}
                    </div>
                    <div class="reco-card__footer">
                        @if($event->remaining_quota !== null)
                            <span class="reco-card__slots">{{ $event->remaining_quota }} slot</span>
                        @else <span></span>
                        @endif
                        <span class="reco-card__btn">Lihat →</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="vd-divider"></div>

    <div class="vd-sec reveal" id="sec-available" style="transition-delay: 0.16s;">
        <div class="vd-sec-head">
            <div>
                <div class="vd-sec-title">Kegiatan Tersedia</div>
                <div class="vd-sec-sub">Mari mulai berkontribusi!</div>
            </div>
            <a href="{{ route('volunteer.events') }}" class="vd-see-all">
                Jelajahi semua
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="vd-chips">
            <a href="{{ route('volunteer.dashboard') }}"
               class="vd-chip {{ !request('category') ? 'active' : '' }}">Semua</a>
            @foreach([
                ['slug' => 'lingkungan', 'label' => 'Lingkungan'],
                ['slug' => 'pendidikan', 'label' => 'Pendidikan'],
                ['slug' => 'kesehatan',  'label' => 'Kesehatan'],
                ['slug' => 'sosial',     'label' => 'Sosial'],
            ] as $cat)
                <a href="{{ route('volunteer.dashboard', ['category' => $cat['slug']]) }}"
                   class="vd-chip {{ request('category') === $cat['slug'] ? 'active' : '' }}">
                    {{ $cat['label'] }}
                </a>
            @endforeach
        </div>

        @php
            $openEvents = \App\Models\Event::with(['categories', 'organization'])
                ->where('status', 'published')
                ->when(request('category'), function ($q) {
                    $q->whereHas('categories', fn($c) => $c->where('slug', request('category')));
                })
                ->where('end_date', '>=', now()->toDateString())
                ->latest()
                ->limit(9)
                ->get();
        @endphp

        @if($openEvents->isNotEmpty())
        <div class="vd-events-grid">
            @foreach($openEvents as $event)
            <a href="{{ route('volunteer.events.show', $event->slug) }}" class="evcard reveal" style="transition-delay: {{ min($loop->index * 0.05, 0.3) }}s;">
                <div class="evcard__img">
                    @if($event->poster)
                        <img src="{{ Storage::url($event->poster) }}"
                             alt="{{ $event->title }}"
                             onerror="this.style.display='none'">
                    @endif
                    <div class="evcard__cats">
                        @foreach($event->categories->take(2) as $cat)
                            <span class="evcard__cat">{{ $cat->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="evcard__body">
                    @if($event->organization)
                        <div class="evcard__org">
                            {{ $event->organization->organization_name ?? $event->organization->name ?? '' }}
                        </div>
                    @endif
                    <div class="evcard__title">{{ $event->title }}</div>
                    <div class="evcard__meta">
                        <div class="evcard__meta-row">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $event->city }}{{ $event->province ? ', ' . $event->province : '' }}
                        </div>
                        <div class="evcard__meta-row">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                            @if($event->start_time)
                                · {{ substr($event->start_time, 0, 5) }}{{ $event->end_time ? ' – ' . substr($event->end_time, 0, 5) : '' }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="evcard__footer">
                    @if($event->remaining_quota !== null)
                        <span class="evcard__slots">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 00-3-3.87"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 010 7.75"/>
                            </svg>
                            {{ $event->remaining_quota }} spots
                        </span>
                    @else
                        <span></span>
                    @endif
                    <span class="evcard__btn">Lihat Detail</span>
                </div>
            </a>
            @endforeach
        </div>
        @else
            <div class="vd-empty">Tidak ada kegiatan yang tersedia saat ini.</div>
        @endif
    </div>

</div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08 });
    reveals.forEach(el => observer.observe(el));

    const statEls = document.querySelectorAll('.vd-hero__stat-val');
    statEls.forEach(el => {
        const target = parseInt(el.dataset.count || '0', 10);
        if (!target) { el.textContent = '0'; return; }
        let current = 0;
        const duration = 900;
        const start = performance.now();
        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            current = Math.round(target * (1 - Math.pow(1 - progress, 3)));
            el.textContent = current;
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    });

    const carousel = document.getElementById('nearby-carousel');
    const dots     = document.querySelectorAll('#nearby-dots .carousel-dot');
    const prevBtn  = document.getElementById('nearby-prev');
    const nextBtn  = document.getElementById('nearby-next');

    if (!carousel) return;

    const cardWidth = () => {
        const first = carousel.querySelector('.nearby-card');
        return first ? first.offsetWidth + 16 : 356;
    };

    const scrollTo = (idx) => {
        carousel.scrollTo({ left: idx * cardWidth(), behavior: 'smooth' });
    };

    dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => scrollTo(idx));
    });

    prevBtn?.addEventListener('click', () => {
        const current = Math.round(carousel.scrollLeft / cardWidth());
        scrollTo(Math.max(0, current - 1));
    });

    nextBtn?.addEventListener('click', () => {
        const cards   = carousel.querySelectorAll('.nearby-card').length;
        const current = Math.round(carousel.scrollLeft / cardWidth());
        scrollTo(Math.min(cards - 1, current + 1));
    });

    carousel.addEventListener('scroll', () => {
        const current = Math.round(carousel.scrollLeft / cardWidth());
        dots.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === current);
        });
    }, { passive: true });
});
</script>
@endpush
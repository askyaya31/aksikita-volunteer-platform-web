@extends('layouts.guest')

@section('title', 'Platform Volunteer Indonesia')

@push('styles')
<style>family=Plus+Jakarta+Sans:ital,
@import url('https://fonts.googleapis.com/css2?family=League+Spartan:wght@700;800&wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap');

*, *::before, *::after { box-sizing: border-box; }

body {
    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
    -webkit-font-smoothing: antialiased;
    color: #1E2A3B;
    overflow-x: hidden;
}
body > header { display: none !important; }
body > footer  { display: none !important; }

.lp-nav {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    padding: 0 1.5rem;
    transition: background 0.3s, box-shadow 0.3s;
}
.lp-nav.scrolled {
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    box-shadow: 0 1px 0 rgba(30,58,138,0.08);
}
.lp-nav__inner {
    max-width: 1200px;
    margin: 0 auto;
    height: 68px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.lp-nav__logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    flex-shrink: 0;
}
.lp-nav__logo-icon {
    width: 36px; height: 36px;
    background: #3B82F6;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 12px rgba(59,130,246,0.35);
    transition: transform 0.2s;
}
.lp-nav__logo:hover .lp-nav__logo-icon { transform: scale(1.08); }
.lp-nav__logo-text {
    font-size: 1.125rem;
    font-weight: 800;
    color: white;
    letter-spacing: -0.01em;
    transition: color 0.3s;
}
.lp-nav.scrolled .lp-nav__logo-text { color: #1E3A8A; }
.lp-nav__links {
    display: flex;
    align-items: center;
    gap: 4px;
}
.lp-nav__link {
    font-size: 0.875rem;
    font-weight: 500;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 8px;
    transition: color 0.2s, background 0.2s;
}
.lp-nav__link:hover { color: white; background: rgba(255,255,255,0.1); }
.lp-nav.scrolled .lp-nav__link { color: #5A7090; }
.lp-nav.scrolled .lp-nav__link:hover { color: #1E3A8A; background: #EFF6FF; }
.lp-nav__actions { display: flex; align-items: center; gap: 10px; }
.lp-nav__btn-ghost {
    font-size: 0.875rem; font-weight: 600;
    color: rgba(255,255,255,0.85);
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 8px;
    transition: color 0.2s, background 0.2s;
    white-space: nowrap;
}
.lp-nav__btn-ghost:hover { color: white; background: rgba(255,255,255,0.12); }
.lp-nav.scrolled .lp-nav__btn-ghost { color: #3B82F6; }
.lp-nav.scrolled .lp-nav__btn-ghost:hover { background: #EFF6FF; }
.lp-nav__btn-solid {
    font-size: 0.875rem; font-weight: 700;
    color: #1E3A8A;
    background: white;
    text-decoration: none;
    padding: 9px 20px;
    border-radius: 9999px;
    transition: all 0.2s;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
}
.lp-nav__btn-solid:hover { background: #EFF6FF; transform: translateY(-1px); box-shadow: 0 4px 16px rgba(0,0,0,0.15); }
.lp-nav.scrolled .lp-nav__btn-solid { background: #3B82F6; color: white; box-shadow: 0 2px 8px rgba(59,130,246,0.35); }
.lp-nav.scrolled .lp-nav__btn-solid:hover { background: #2563EB; }

@media (max-width: 768px) { .lp-nav__links { display: none; } }

.lp-hero {
    min-height: 100vh;
    background: linear-gradient(150deg, #1E3A8A 0%, #1a3375 30%, #1e47a8 65%, #2563EB 100%);
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.lp-hero::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
        radial-gradient(circle at 15% 85%, rgba(96,165,250,0.15) 0%, transparent 50%),
        radial-gradient(circle at 85% 15%, rgba(30,58,138,0.4) 0%, transparent 50%),
        radial-gradient(circle at 55% 55%, rgba(59,130,246,0.1) 0%, transparent 45%);
    pointer-events: none;
}

.lp-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='30' cy='30' r='1' fill='rgba(255,255,255,0.04)'/%3E%3C/svg%3E");
    background-size: 60px 60px;
    pointer-events: none;
}

.lp-hero__blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    animation: lp-blob 14s infinite ease-in-out;
}
.lp-hero__blob--1 {
    width: 500px; height: 500px;
    background: rgba(96,165,250,0.12);
    top: -100px; right: -100px;
    animation-delay: 0s;
}
.lp-hero__blob--2 {
    width: 400px; height: 400px;
    background: rgba(147,197,253,0.1);
    bottom: -50px; left: 5%;
    animation-delay: -5s;
}
@keyframes lp-blob {
    0%,100% { transform: translate(0,0) scale(1); }
    33%      { transform: translate(30px,-40px) scale(1.08); }
    66%      { transform: translate(-20px,25px) scale(0.94); }
}
.lp-hero__content {
    position: relative; z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    padding: 120px 1.5rem 100px;
    width: 100%;
}
.lp-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.18);
    color: #BFDBFE;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 9999px;
    margin-bottom: 28px;
    backdrop-filter: blur(4px);
}
.lp-hero__dot {
    width: 6px; height: 6px;
    background: #60A5FA;
    border-radius: 50%;
    animation: lp-dot-pulse 2s ease-in-out infinite;
}
@keyframes lp-dot-pulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:0.4; transform:scale(0.7); }
}
.lp-hero__heading {
    font-size: clamp(4rem, 5.5vw, 7rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
    letter-spacing: 0em;
    margin-bottom: 24px;
    max-width: 740px;
}
.lp-hero__heading em {
    font-style: normal;
    color: #a5cbf6;
}
.lp-hero__sub {
    font-size: clamp(1rem, 2vw, 1.125rem);
    color: #BFDBFE;
    line-height: 1.75;
    max-width: 540px;
    margin-bottom: 44px;
    font-weight: 400;
}
.lp-hero__actions {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 64px;
}
.lp-btn-white {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 28px;
    background: #fff; color: #1E3A8A;
    border: 2px solid #fff;
    border-radius: 9999px;
    font-weight: 700; font-size: 0.9375rem;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.lp-btn-white:hover { background: #EFF6FF; border-color: #EFF6FF; transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,0.2); }
.lp-btn-white svg { transition: transform 0.2s; }
.lp-btn-white:hover svg { transform: translateX(3px); }
.lp-btn-ghost-white {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 28px;
    background: transparent; color: #fff;
    border: 2px solid rgba(255,255,255,0.45);
    border-radius: 9999px;
    font-weight: 600; font-size: 0.9375rem;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.lp-btn-ghost-white:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.75); transform: translateY(-2px); }
.lp-hero__scroll-hint {
    display: flex; align-items: center; gap: 10px;
    color: rgba(255,255,255,0.4);
    font-size: 0.75rem; font-weight: 600;
    letter-spacing: 0.06em; text-transform: uppercase;
    animation: lp-float 2.2s ease-in-out infinite;
}
.lp-hero__scroll-line { width: 24px; height: 1px; background: rgba(255,255,255,0.25); }
@keyframes lp-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(5px)} }

.lp-hero__carousel {
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    border-radius: 450px 0 0 450px;
    width: 600px;
    overflow: hidden;
    z-index: 1;
    display: none;
}
@media (min-width: 1024px) {
    .lp-hero__carousel { display: block; }
}
.lp-hero__carousel-fade {
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 220px;
    background: linear-gradient(to right, #1E3A8A 0%, #1E3A8A 0%, transparent 95%);
    z-index: 20;
    overflow: hidden;
    pointer-events: none;
}
.lp-hero__carousel img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    z-index: 10;
}
.lp-hero__carousel img.is-active {
    opacity: 1;
}
@media (max-width: 1023px) {
    .lp-hero__carousel {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        border-radius: 0;
        z-index: 0;
    }

    .lp-hero__carousel-fade {
        display: block;
        width: 100%;
        background: linear-gradient(to bottom,
            rgba(30,58,138,0.85) 0%,
            rgba(30,58,138,0.7) 50%,
            rgba(30,58,138,0.85) 100%
        );
    }

    .lp-hero__content {
        position: relative;
        z-index: 2;
    }
}
.lp-stats {
    background: #F5F8FF;
    border-bottom: 1px solid #DBEAFE;
}
.lp-stats__inner {
    max-width: 1200px; margin: 0 auto;
    display: flex; align-items: stretch;
}
.lp-stats__item {
    flex: 1;
    padding: 28px 36px;
    border-right: 1px solid #DBEAFE;
    transition: background 0.2s;
}
.lp-stats__item:last-child { border-right: none; }
.lp-stats__item:hover { background: #EFF6FF; }
.lp-stats__num {
    font-size: 2rem; font-weight: 800;
    color: #1E3A8A;
    letter-spacing: -0.04em;
    line-height: 1;
    height: 40px;
    display: flex; align-items: center;
}
.lp-stats__num.is-loading {
    background: linear-gradient(90deg, #DBEAFE 25%, #BFDBFE 50%, #DBEAFE 75%);
    background-size: 200% 100%;
    animation: lp-shimmer 1.4s infinite;
    border-radius: 6px;
    width: 80px; height: 32px;
    color: transparent;
}
@keyframes lp-shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
.lp-stats__label {
    font-size: 0.8125rem; color: #5A7090;
    margin-top: 6px; font-weight: 500;
}
@media (max-width: 640px) {
    .lp-stats__inner { flex-direction: column; }
    .lp-stats__item { border-right: none; border-bottom: 1px solid #DBEAFE; }
    .lp-stats__item:last-child { border-bottom: none; }
}

.lp-section { padding: 88px 0; }
.lp-section--white { background: white; }
.lp-section--light { background: #F5F8FF; }
.lp-section--navy  {
    background: #1E3A8A;
    background-image: radial-gradient(circle at 70% 50%, rgba(59,130,246,0.18) 0%, transparent 60%);
}
.lp-container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
.lp-eyebrow {
    display: flex; align-items: center; gap: 10px;
    font-size: 0.75rem; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    color: #3B82F6; margin-bottom: 14px;
}
.lp-eyebrow::before {
    content: ''; width: 24px; height: 2px;
    background: #3B82F6; border-radius: 2px; flex-shrink: 0;
}
.lp-section-title {
    font-size: clamp(1.625rem, 3vw, 2.25rem);
    font-weight: 800; color: #1E3A8A;
    line-height: 1.2; letter-spacing: -0.02em;
    margin-bottom: 12px;
}
.lp-section-sub {
    font-size: 1.0625rem; color: #5A7090;
    line-height: 1.7; max-width: 500px;
    margin-bottom: 0;
    text-align; justify;
}

.lp-steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
    margin-top: 56px;
    position: relative;
}
.lp-steps::before {
    content: '';
    position: absolute;
    top: 27px;
    left: calc(16.66% + 28px);
    right: calc(16.66% + 28px);
    height: 2px;
    background: linear-gradient(90deg, #BFDBFE, #93C5FD, #BFDBFE);
    z-index: 0;
}
.lp-step {
    display: flex; flex-direction: column;
    align-items: center; text-align: center;
    padding: 0 32px;
    position: relative; z-index: 1;
}
.lp-step__num {
    width: 56px; height: 56px; border-radius: 50%;
    background: #1E3A8A; color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; font-weight: 800;
    margin-bottom: 20px;
    box-shadow: 0 4px 16px rgba(30,58,138,0.28);
    transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
    text-decoration: none;
    cursor: pointer;
    outline: none;
}
.lp-step:hover .lp-step__num { transform: scale(1.1); box-shadow: 0 8px 24px rgba(30,58,138,0.38); }
.lp-step__num:hover,
.lp-step__num:focus-visible {
    background: #2563EB;
    box-shadow: 0 0 0 5px rgba(59,130,246,0.16), 0 8px 24px rgba(30,58,138,0.38);
}
.lp-step__num:active { transform: scale(1.02); }
.lp-step__title {
    font-size: 1rem; font-weight: 700; color: #1E3A8A; margin-bottom: 8px;
    text-decoration-line: underline;
    text-decoration-color: transparent;
    text-underline-offset: 3px;
    transition: text-decoration-color 0.3s;
}
.lp-step:hover .lp-step__title { text-decoration-color: #3B82F6; }
.lp-step__desc  { font-size: 0.875rem; color: #5A7090; line-height: 1.65; }
@media (max-width: 768px) {
    .lp-steps { grid-template-columns: 1fr; gap: 36px; }
    .lp-steps::before { display: none; }
    .lp-step { flex-direction: row; align-items: flex-start; text-align: left; gap: 20px; padding: 0; }
    .lp-step__num { flex-shrink: 0; margin-bottom: 0; }
}

.lp-features {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px; margin-top: 52px;
}
.lp-feature-card {
    background: white;
    border: 1.5px solid #DBEAFE;
    border-radius: 20px;
    padding: 28px 22px;
    transition: transform 0.3s cubic-bezier(0.25,1,0.5,1), box-shadow 0.3s, border-color 0.3s;
}
.lp-feature-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px -8px rgba(30,58,138,0.13), 0 4px 12px -4px rgba(30,58,138,0.07);
    border-color: #93C5FD;
}
.lp-feature-card__icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: #EFF6FF; color: #3B82F6;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 18px;
    transition: background 0.3s, color 0.3s;
}
.lp-feature-card:hover .lp-feature-card__icon { background: #1E3A8A; color: white; }
.lp-feature-card__title { font-size: 1rem; font-weight: 700; color: #1E3A8A; margin-bottom: 8px; }
.lp-feature-card__desc  { font-size: 0.875rem; color: #5A7090; line-height: 1.65; }
@media (max-width: 1024px) { .lp-features { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px)  { .lp-features { grid-template-columns: 1fr; } }

.lp-mission-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px; align-items: center;
}
@media (max-width: 900px) {
    .lp-mission-grid { grid-template-columns: 1fr; gap: 40px; }
    .lp-mission-img-grid { display: none; }
}
.lp-mission-img-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.lp-mission-img-col { display: flex; flex-direction: column; gap: 14px; }
.lp-mission-img-col--offset { padding-top: 36px; }
.lp-mission-img {
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 8px 24px rgba(30,58,138,0.1);
    background: #DBEAFE;
    transition: transform 0.4s cubic-bezier(0.25,1,0.5,1), box-shadow 0.4s;
}
.lp-mission-img:hover { transform: translateY(-4px); box-shadow: 0 16px 36px rgba(30,58,138,0.15); }
.lp-mission-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.6s cubic-bezier(0.25,1,0.5,1); }
.lp-mission-img:hover img { transform: scale(1.05); }
.lp-mission-img--tall  { aspect-ratio: 3/4; }
.lp-mission-img--sq    { aspect-ratio: 1; }
.lp-mission-trust {
    display: flex; align-items: flex-start; gap: 16px;
    padding: 20px 22px;
    background: #F5F8FF;
    border: 1.5px solid #DBEAFE;
    border-radius: 16px;
    margin-top: 28px;
}
.lp-mission-trust__icon {
    width: 44px; height: 44px; flex-shrink: 0;
    background: #EFF6FF; color: #3B82F6; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
}

.lp-cats {
    display: flex; flex-wrap: wrap; gap: 10px;
    margin-top: 32px;
}
.lp-cat-pill {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 9px 18px;
    border: 1.5px solid #DBEAFE;
    border-radius: 9999px;
    font-size: 0.875rem; font-weight: 600;
    color: #5A7090; background: white;
    text-decoration: none; cursor: pointer;
    transition: all 0.2s;
}
.lp-cat-pill:hover {
    border-color: #3B82F6; color: #1E3A8A;
    background: #EFF6FF; transform: translateY(-2px);
}
.lp-cat-pill__dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #93C5FD; flex-shrink: 0;
    transition: background 0.2s;
}
.lp-cat-pill:hover .lp-cat-pill__dot { background: #3B82F6; }

.lp-cat-skeleton {
    height: 40px; border-radius: 9999px;
    background: linear-gradient(90deg, #DBEAFE 25%, #BFDBFE 50%, #DBEAFE 75%);
    background-size: 200% 100%;
    animation: lp-shimmer 1.4s infinite;
}

.lp-events-header {
    display: flex; align-items: flex-end;
    justify-content: space-between; gap: 16px; flex-wrap: wrap;
    margin-bottom: 44px;
}
.lp-events-viewall {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.875rem; font-weight: 600;
    color: #3B82F6; text-decoration: none;
    padding: 8px 0;
    border-bottom: 2px solid transparent;
    transition: border-color 0.2s, color 0.2s;
    white-space: nowrap;
}
.lp-events-viewall:hover { color: #1E3A8A; border-bottom-color: #1E3A8A; }
.lp-events-viewall svg { transition: transform 0.2s; }
.lp-events-viewall:hover svg { transform: translateX(3px); }
.lp-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
@media (max-width: 1024px) { .lp-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 640px)  { .lp-grid { grid-template-columns: 1fr; } }

.lp-sk-card { background: white; border: 1.5px solid #DBEAFE; border-radius: 20px; overflow: hidden; }
.lp-sk-img  { width: 100%; aspect-ratio: 16/9; background: linear-gradient(90deg,#DBEAFE 25%,#BFDBFE 50%,#DBEAFE 75%); background-size:200% 100%; animation:lp-shimmer 1.4s infinite; }
.lp-sk-body { padding: 18px 20px; display: flex; flex-direction: column; gap: 10px; }
.lp-sk-line { border-radius: 4px; background: linear-gradient(90deg,#DBEAFE 25%,#BFDBFE 50%,#DBEAFE 75%); background-size:200% 100%; animation:lp-shimmer 1.4s infinite; }

.lp-event-card {
    background: white;
    border: 1.5px solid #DBEAFE;
    border-radius: 20px;
    overflow: hidden;
    display: flex; flex-direction: column;
    text-decoration: none;
    transition: transform 0.4s cubic-bezier(0.25,1,0.5,1), box-shadow 0.4s, border-color 0.3s;
}
.lp-event-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 48px -12px rgba(30,58,138,0.14), 0 8px 16px -4px rgba(30,58,138,0.07);
    border-color: #93C5FD;
}
.lp-event-card__img-wrap {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: #DBEAFE;
}
.lp-event-card__img-wrap img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform 0.6s cubic-bezier(0.25,1,0.5,1);
}
.lp-event-card:hover .lp-event-card__img-wrap img { transform: scale(1.06); }
.lp-event-card__img-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, #3B82F6, #1E3A8A);
    display: flex; align-items: center; justify-content: center;
}
.lp-event-card__badge {
    position: absolute; top: 14px; left: 14px;
    display: flex; gap: 6px; flex-wrap: wrap;
}
.lp-badge {
    display: inline-flex; align-items: center;
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 0.7rem; font-weight: 700;
    letter-spacing: 0.02em;
    backdrop-filter: blur(4px);
}
.lp-badge--blue  { background: rgba(59,130,246,0.15); color: #1E3A8A; border: 1px solid rgba(59,130,246,0.25); }
.lp-badge--white { background: rgba(255,255,255,0.88); color: #1E3A8A; }
.lp-badge--full  { background: rgba(220,38,38,0.12); color: #DC2626; }
.lp-event-card__body {
    padding: 20px 22px 16px;
    flex: 1; display: flex; flex-direction: column; gap: 6px;
}
.lp-event-card__org {
    display: flex; align-items: center; gap: 6px;
    font-size: 0.8rem; color: #5A7090; font-weight: 500;
}
.lp-event-card__title {
    font-size: 1rem; font-weight: 700; color: #1E3A8A;
    line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    transition: color 0.2s;
}
.lp-event-card:hover .lp-event-card__title { color: #3B82F6; }
.lp-event-card__meta {
    display: flex; flex-direction: column; gap: 4px;
    margin-top: 4px;
}
.lp-event-card__meta-row {
    display: flex; align-items: center; gap: 6px;
    font-size: 0.8125rem; color: #5A7090;
}
.lp-event-card__footer {
    padding: 14px 22px 18px;
    border-top: 1px solid #EFF6FF;
}
.lp-event-card__cta {
    display: block; width: 100%; text-align: center;
    padding: 11px;
    background: #F5F8FF; color: #3B82F6;
    font-size: 0.875rem; font-weight: 700;
    border-radius: 10px;
    text-decoration: none;
    transition: background 0.25s, color 0.25s;
}
.lp-event-card:hover .lp-event-card__cta { background: #3B82F6; color: white; }

.lp-cta-inner {
    text-align: center; padding: 88px 1.5rem;
    position: relative;
}
.lp-cta-inner h2 {
    font-size: clamp(1.875rem, 3.5vw, 2.75rem);
    color: white; font-weight: 800;
    letter-spacing: -0.025em; margin-bottom: 16px;
}
.lp-cta-inner p {
    color: #BFDBFE; font-size: 1.0625rem;
    max-width: 480px; margin: 0 auto 36px; line-height: 1.7;
}
.lp-cta-btns { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; }

.lp-footer {
    background: #0F2057;
    padding: 60px 0 0;
}
.lp-footer__inner {
    max-width: 1200px; margin: 0 auto;
    padding: 0 1.5rem;
    display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 40px;
}
@media (max-width: 768px) {
    .lp-footer__inner { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 480px) {
    .lp-footer__inner { grid-template-columns: 1fr; }
}
.lp-footer__brand-desc { color: rgba(255,255,255,0.5); font-size: 0.875rem; line-height: 1.7; margin: 16px 0 24px; max-width: 280px; }
.lp-footer__social { display: flex; gap: 10px; }
.lp-footer__social-btn {
    width: 38px; height: 38px;
    background: rgba(255,255,255,0.08); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.5); text-decoration: none;
    transition: background 0.2s, color 0.2s;
}
.lp-footer__social-btn:hover { background: rgba(255,255,255,0.15); color: white; }
.lp-footer__col-title { color: white; font-size: 0.875rem; font-weight: 700; margin-bottom: 20px; letter-spacing: 0.02em; }
.lp-footer__col-link {
    display: block;
    color: rgba(255,255,255,0.5); font-size: 0.875rem;
    text-decoration: none; margin-bottom: 12px;
    transition: color 0.2s;
}
.lp-footer__col-link:hover { color: white; }
.lp-footer__bottom {
    max-width: 1200px; margin: 0 auto;
    padding: 20px 1.5rem;
    margin-top: 48px;
    border-top: 1px solid rgba(255,255,255,0.08);
    display: flex; justify-content: space-between;
    align-items: center; gap: 12px; flex-wrap: wrap;
}
.lp-footer__bottom p { color: rgba(255,255,255,0.3); font-size: 0.8125rem; }

.reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.65s cubic-bezier(0.25,1,0.5,1), transform 0.65s cubic-bezier(0.25,1,0.5,1);
}
.reveal.is-visible { opacity: 1; transform: translateY(0); }
.reveal-d1 { transition-delay: 80ms; }
.reveal-d2 { transition-delay: 160ms; }
.reveal-d3 { transition-delay: 240ms; }
.reveal-d4 { transition-delay: 320ms; }
.reveal-d5 { transition-delay: 400ms; }
.reveal-d6 { transition-delay: 480ms; }
</style>
@endpush

@section('content')
<section class="lp-hero" aria-label="Hero — AksiKita Platform Volunteer">
    <div class="lp-hero__blob lp-hero__blob--1" aria-hidden="true"></div>
    <div class="lp-hero__blob lp-hero__blob--2" aria-hidden="true"></div>

    <div class="lp-hero__carousel" aria-hidden="true">
        <div class="lp-hero__carousel-fade"></div>
        <img src="https://images.unsplash.com/photo-1616680214084-22670de1bc82?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Volunteer photo" class="is-active" />
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Happy Children photo" />
        <img src="https://images.unsplash.com/photo-1672084891746-29828996afd6?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Clean Up photo" />
        <img src="https://images.unsplash.com/photo-1616680214429-d79397e56688?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3DD" alt="Volunteer photo" />
    </div>

    <div class="lp-hero__content">
        <h1 class="lp-hero__heading">
            <em>Aksi</em> Nyata<br>
            Dimulai dari <em>Kita</em>
        </h1>

        <p class="lp-hero__sub">
            AksiKita menghubungkan relawan dengan organisasi sosial terverifikasi di seluruh Indonesia.
            Temukan kegiatan yang sesuai minatmu dan mulai berkontribusi hari ini.
        </p>

        <div class="lp-hero__actions">
            <a href="{{ route('register.volunteer') }}" class="lp-btn-white">
                Jadi Volunteer Sekarang
            </a>
            <a href="{{ route('register.organizer') }}" class="lp-btn-ghost-white">
                Daftarkan Organisasi
            </a>
        </div>
    </div>
</section>

<section class="lp-section lp-section--white" id="tentang" aria-labelledby="misi-heading">
    <div class="lp-container">
        <div class="lp-mission-grid">

            <div>
                <div class="lp-eyebrow reveal">Misi Kami</div>
                <h2 class="lp-section-title reveal reveal-d1" id="misi-heading">
                    Menghapus Jarak antara<br>
                    <span style="color:#3B82F6;">Niat Baik</span> dan <span style="color:#2563EB;">Kebutuhan</span>
                </h2>
                <p class="lp-section-sub reveal reveal-d2" style="margin-top:16px; margin-bottom:20px; text-align:justify;">
                    Di Indonesia, jutaan orang ingin membantu namun tidak tahu harus memulai dari mana.
                    Di sisi lain, banyak organisasi sosial berjuang sendirian mencari dukungan.
                    AksiKita hadir untuk menjembatani keduanya.
                </p>
                <p class="lp-section-sub reveal reveal-d3" style="text-align:justify;">
                    Kami percaya gotong royong adalah DNA bangsa ini. Dengan teknologi yang memanusiakan hubungan,
                    kita bisa menghidupkan kembali semangat tersebut dalam bentuk yang lebih terstruktur dan berdampak.
                </p>

                <div class="lp-mission-trust reveal reveal-d4">
                    <div class="lp-mission-trust__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>

                    </div>
                    <p style="font-size:0.875rem; color:#5A7090; line-height:1.65; margin:0;">
                        <strong style="color:#1E3A8A;">Data Aman & Terproteksi.</strong><br>
                        Setiap data relawan dan organisasi dikelola dengan standar keamanan yang ketat.
                    </p>
                </div>

                <div class="lp-mission-trust reveal reveal-d4">
                    <div class="lp-mission-trust__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>

                    </div>
                    <p style="font-size:0.875rem; color:#5A7090; line-height:1.65; margin:0;">
                        <strong style="color:#1E3A8A;">Contact Us.</strong><br>
                        Untuk pertanyaan, kemitraan, atau dukungan teknis, jangan ragu menghubungi kami di:
                        aksikita.support@gmail.com
                    </p>
                </div>
            </div>

            <div class="lp-mission-img-grid" aria-hidden="true">
                <div class="lp-mission-img-col">
                    <div class="lp-mission-img lp-mission-img--tall reveal reveal-d2">
                        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&q=80&w=600"
                             alt="Relawan gotong royong" loading="lazy">
                    </div>
                    <div class="lp-mission-img lp-mission-img--sq reveal reveal-d3">
                        <img src="https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&q=80&w=600"
                             alt="Berbagi kepada sesama" loading="lazy">
                    </div>
                </div>
                <div class="lp-mission-img-col lp-mission-img-col--offset">
                    <div class="lp-mission-img lp-mission-img--sq reveal reveal-d4">
                        <img src="https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&q=80&w=600"
                             alt="Kegiatan volunteer" loading="lazy">
                    </div>
                    <div class="lp-mission-img lp-mission-img--tall reveal reveal-d5">
                        <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&q=80&w=600"
                             alt="Dampak sosial nyata" loading="lazy">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="lp-section lp-section--light" id="cara-kerja" aria-labelledby="how-heading">
    <div class="lp-container">

        <div class="lp-eyebrow reveal">Cara Kerja</div>
        <h2 class="lp-section-title reveal reveal-d1" id="how-heading">
            Mulai Berkontribusi dalam 3 Langkah
        </h2>
        <p class="lp-section-sub reveal reveal-d2" style="margin-top:12px;">
            Proses yang sederhana agar kamu bisa segera terjun ke lapangan dan memberikan dampak nyata.
        </p>

        <div class="lp-steps">
            <div class="lp-step reveal reveal-d1">
                <a href="{{ route('register.volunteer') }}" class="lp-step__num" aria-label="Buat Akun Gratis — daftar sebagai volunteer">1</a>
                <div>
                    <div class="lp-step__title">Buat Akun Gratis</div>
                    <div class="lp-step__desc">
                        Daftar sebagai volunteer dalam hitungan menit. Tidak ada biaya, tidak ada syarat khusus.
                    </div>
                </div>
            </div>
            <div class="lp-step reveal reveal-d2">
                <a href="#kegiatan" class="lp-step__num" aria-label="Temukan Kegiatan — lihat daftar kegiatan">2</a>
                <div>
                    <div class="lp-step__title">Temukan Kegiatan</div>
                    <div class="lp-step__desc">
                        Jelajahi kegiatan sosial berdasarkan minat, kategori, atau kota terdekatmu.
                    </div>
                </div>
            </div>
            <div class="lp-step reveal reveal-d3">
                <a href="{{ route('login') }}" class="lp-step__num" aria-label="Daftar dan Hadir — masuk ke akun">3</a>
                <div>
                    <div class="lp-step__title">Daftar dan Hadir</div>
                    <div class="lp-step__desc">
                        Daftar satu klik, tunggu konfirmasi, dan hadir di hari kegiatan. Mulai membuat perbedaan.
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="lp-section lp-section--white" id="kegiatan" aria-labelledby="events-heading">
    <div class="lp-container">

        <div class="lp-events-header">
            <div>
                <div class="lp-eyebrow reveal">Kegiatan Terbaru</div>
                <h2 class="lp-section-title reveal reveal-d1" id="events-heading">Temukan Panggilanmu</h2>
                <p class="lp-section-sub reveal reveal-d2" style="margin-top:8px;">
                    Kegiatan sosial terbaru yang menunggu partisipasimu.
                </p>
            </div>
            <a href="{{ route('login') }}" class="lp-events-viewall reveal reveal-d2">
                Lihat Semua Kegiatan
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="lp-grid" id="events-container" aria-label="Daftar kegiatan terbaru">
            @for($i = 0; $i < 6; $i++)
            <div class="lp-sk-card" aria-hidden="true">
                <div class="lp-sk-img"></div>
                <div class="lp-sk-body">
                    <div class="lp-sk-line" style="height:10px; width:55%;"></div>
                    <div class="lp-sk-line" style="height:18px; width:88%;"></div>
                    <div class="lp-sk-line" style="height:13px; width:65%;"></div>
                    <div style="display:flex; gap:8px; margin-top:4px;">
                        <div class="lp-sk-line" style="height:13px; width:40%;"></div>
                        <div class="lp-sk-line" style="height:13px; width:28%;"></div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

    </div>
</section>

<section class="lp-section lp-section--navy" aria-labelledby="cta-heading">
    <div class="lp-container">
        <div class="lp-cta-inner">
            <h2 id="cta-heading" class="reveal">
                Kebaikan Tidak Boleh Menunggu.<br>Mulai Langkah Pertamamu Hari Ini.
            </h2>
            <p class="reveal reveal-d1">
                Entah sebagai volunteer yang memberikan waktu, atau organisasi yang membutuhkan bantuan.
                AksiKita adalah rumah bagi setiap niat baik.
            </p>
            <div class="lp-cta-btns reveal reveal-d2">
                <a href="{{ route('register.volunteer') }}" class="lp-btn-white">
                   Saya Ingin Jadi Volunteer
                </a>
                <a href="{{ route('register.organizer') }}" class="lp-btn-ghost-white">
                    Saya Mewakili Organisasi
                </a>
            </div>
        </div>
    </div>
</section>

<footer class="lp-footer">
    <div class="lp-footer__inner">
        <div>
            <div style="display:flex; align-items:center; gap:10px;">
                <img src="{{ asset('images/logo_aksikita.png') }}" alt="Logo AksiKita" style="height: 36px; width: auto;">
                <span style="color:white; font-size:1.125rem; font-weight:800;">AksiKita</span>
            </div>
            <p class="lp-footer__brand-desc">
                Platform kolaborasi sosial yang menghubungkan niat baik dengan kesempatan nyata untuk menciptakan dampak berkelanjutan di Indonesia.
            </p>
            <div class="lp-footer__social">
                <a href="#" class="lp-footer__social-btn" aria-label="Twitter AksiKita">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </a>
                <a href="#" class="lp-footer__social-btn" aria-label="Instagram AksiKita">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            </div>
        </div>
        <div>
            <div class="lp-footer__col-title">Platform</div>
            <a href="#tentang"    class="lp-footer__col-link">Tentang Kami</a>
            <a href="#cara-kerja" class="lp-footer__col-link">Cara Kerja</a>
            <a href="{{ route('register.organizer') }}" class="lp-footer__col-link">Daftarkan Organisasi</a>
        </div>
        <div>
            <div class="lp-footer__col-title">Volunteer</div>
            <a href="{{ route('register.volunteer') }}" class="lp-footer__col-link">Daftar Gratis</a>
            <a href="{{ route('login') }}" class="lp-footer__col-link">Masuk ke Akun</a>
            <a href="#kegiatan" class="lp-footer__col-link">Jelajahi Kegiatan</a>
        </div>
        <div>
            <div class="lp-footer__col-title">Dukungan</div>
            <a href="#" class="lp-footer__col-link">Pusat Bantuan</a>
            <a href="#" class="lp-footer__col-link">Hubungi Kami</a>
            <a href="#" class="lp-footer__col-link">Panduan Relawan</a>
        </div>
    </div>
    <div class="lp-footer__bottom">
        <p>&copy; {{ date('Y') }} AksiKita.</p>
        <p>Dibuat dengan penuh dedikasi untuk Indonesia yang lebih baik.</p>
    </div>
</footer>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var nav = document.getElementById('lp-nav');
    if (nav) {
        function updateNav() {
            if (window.scrollY > 40) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }
        window.addEventListener('scroll', updateNav, { passive: true });
        updateNav();
    }

    var revealEls = document.querySelectorAll('.reveal');
    var revealObserver = null;

    if (revealEls.length && 'IntersectionObserver' in window) {
        revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(function (el) { revealObserver.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('is-visible'); });
    }

    function animateCounter(el, target) {
        el.classList.remove('is-loading');
        var duration = 1200;
        var start = performance.now();
        function step(now) {
            var elapsed  = now - start;
            var progress = Math.min(elapsed / duration, 1);
            var eased    = 1 - Math.pow(1 - progress, 4);
            el.textContent = Math.round(eased * target).toLocaleString('id-ID') + '+';
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    function esc(str) {
        if (str == null) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function formatDate(dateStr) {
        return dateStr || '';
    }

    function observeNewCards(container) {
        if (!revealObserver) return;
        container.querySelectorAll('.reveal').forEach(function (el) {
            revealObserver.observe(el);
        });
    }

    var catColors = [
        { bg: '#EFF6FF', text: '#1D4ED8' },
        { bg: '#F0FDF4', text: '#15803D' },
        { bg: '#FFFBEB', text: '#B45309' },
        { bg: '#FFF1F2', text: '#BE123C' },
        { bg: '#F5F3FF', text: '#6D28D9' },
        { bg: '#ECFEFF', text: '#0E7490' }
    ];

    function renderEventCard(event, index) {
        var color    = catColors[index % catColors.length];
        var orgName  = event.organization && event.organization.organization_name
                        ? event.organization.organization_name
                        : '';
        var category = event.categories && event.categories.length > 0
                        ? event.categories[0].name
                        : 'Kegiatan Sosial';
        var date     = formatDate(event.start_date);
        var city     = event.city || '';
        var isFull   = event.is_full || false;
        var remaining = event.remaining_quota != null ? event.remaining_quota : null;

        var imgHtml = event.poster
            ? '<img src="' + esc(event.poster) + '" alt="' + esc(event.title) + '" loading="lazy">'
            : '<div class="lp-event-card__img-placeholder">' +
                '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5">' +
                '<path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>' +
                '</svg></div>';

        var quotaHtml = '';
        if (isFull) {
            quotaHtml = '<span style="font-size:0.8rem; font-weight:600; color:#DC2626;">Penuh</span>';
        } else if (remaining !== null) {
            var qColor = remaining <= 5 ? '#DC2626' : '#5A7090';
            quotaHtml = '<span style="font-size:0.8rem; font-weight:600; color:' + qColor + ';">' + remaining + ' slot tersisa</span>';
        }

        return '<a href="/login" class="lp-event-card reveal" style="transition-delay:' + (index * 80) + 'ms;" aria-label="Lihat kegiatan: ' + esc(event.title) + '">' +
            '<div class="lp-event-card__img-wrap">' +
                imgHtml +
                '<div class="lp-event-card__badge">' +
                    '<span class="lp-badge lp-badge--white" style="background-color:' + color.bg + '; color:' + color.text + ';">' + esc(category) + '</span>' +
                    (isFull ? '<span class="lp-badge lp-badge--full">Penuh</span>' : '') +
                '</div>' +
            '</div>' +
            '<div class="lp-event-card__body">' +
                (orgName ? '<div class="lp-event-card__org">' +
                    '<svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>' +
                    '<span>' + esc(orgName) + '</span>' +
                '</div>' : '') +
                '<h3 class="lp-event-card__title">' + esc(event.title) + '</h3>' +
                '<div class="lp-event-card__meta">' +
                    (city ? '<div class="lp-event-card__meta-row"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' + esc(city) + '</div>' : '') +
                    (date ? '<div class="lp-event-card__meta-row"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>' + date + '</div>' : '') +
                '</div>' +
            '</div>' +
            '<div class="lp-event-card__footer">' +
                '<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">' +
                    quotaHtml +
                '</div>' +
                '<span class="lp-event-card__cta">Lihat Detail &amp; Daftar</span>' +
            '</div>' +
        '</a>';
    }

    var eventsContainer = document.getElementById('events-container');

    fetch('/api/v1/events?page=1&per_page=6', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function (res) {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    })
    .then(function (json) {
        var statEl = document.getElementById('stat-events');
        if (statEl) {
            var total = (json.meta && json.meta.total)
                     || json.total
                     || (json.data ? json.data.length : 0);
            animateCounter(statEl, total);
        }

        if (!eventsContainer) return;
        var events = json.data;

        if (!events || events.length === 0) {
            eventsContainer.innerHTML =
                '<div style="grid-column:1/-1; text-align:center; padding:60px 24px; background:white; border-radius:20px; border:1.5px solid #DBEAFE;">' +
                '<div style="width:56px; height:56px; background:#EFF6FF; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">' +
                '<svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#3B82F6" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>' +
                '</div>' +
                '<h3 style="font-size:1.0625rem; font-weight:700; color:#1E3A8A; margin-bottom:8px;">Belum ada kegiatan tersedia</h3>' +
                '<p style="font-size:0.875rem; color:#5A7090;">Cek kembali nanti untuk pembaruan kegiatan sosial terbaru.</p>' +
                '</div>';
            return;
        }

        eventsContainer.innerHTML = events.slice(0, 6).map(function (event, i) {
            return renderEventCard(event, i);
        }).join('');

        observeNewCards(eventsContainer);
    })
    .catch(function (err) {
        console.warn('AksiKita: gagal memuat events —', err);
        var statEl = document.getElementById('stat-events');
        if (statEl) { statEl.classList.remove('is-loading'); statEl.textContent = '—'; }

        if (!eventsContainer) return;
        eventsContainer.innerHTML =
            '<div style="grid-column:1/-1; text-align:center; padding:60px 24px; background:white; border-radius:20px; border:1.5px solid #DBEAFE;">' +
            '<p style="font-size:0.875rem; color:#5A7090;">Gagal memuat kegiatan. Silakan muat ulang halaman.</p>' +
            '</div>';
    });

    var catsContainer = document.getElementById('categories-container');

    fetch('/api/v1/categories', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function (res) {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    })
    .then(function (json) {
        var cats = json.categories || json.data || json || [];
        var statCat = document.getElementById('stat-categories');
        if (statCat) {
            animateCounter(statCat, Array.isArray(cats) ? cats.length : 0);
        }

        if (!catsContainer || !Array.isArray(cats) || cats.length === 0) return;

        catsContainer.innerHTML = cats.map(function (cat) {
            return '<a href="/login" class="lp-cat-pill" role="listitem" aria-label="Kegiatan kategori ' + esc(cat.name) + '">' +
                '<span class="lp-cat-pill__dot" aria-hidden="true"></span>' +
                esc(cat.name) +
            '</a>';
        }).join('');
    })
    .catch(function (err) {
        console.warn('AksiKita: gagal memuat categories —', err);
        var statCat = document.getElementById('stat-categories');
        if (statCat) { statCat.classList.remove('is-loading'); statCat.textContent = '—'; }
        if (catsContainer) {
            catsContainer.innerHTML = '<p style="font-size:0.875rem; color:#5A7090;">Gagal memuat kategori.</p>';
        }
    });

    var carousel = document.querySelector('.lp-hero__carousel');
    if (carousel) {
        var images = carousel.querySelectorAll('img');
        var currentIndex = 0;
        images[0].classList.add('is-active');
        setInterval(function () {
            images[currentIndex].classList.remove('is-active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('is-active');
        }, 6000);
    }
});
</script>
@endpush
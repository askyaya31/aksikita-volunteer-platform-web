'use strict';

function ready(fn) {
    if (document.readyState !== 'loading') {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}


function initScrollReveal() {
    const REVEAL_SELECTORS = [
        '.reveal',
        '.reveal-up',
        '.reveal-fade',
        '.reveal-scale',
    ].join(', ');

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px',
        }
    );

    document.querySelectorAll(REVEAL_SELECTORS).forEach((el) => {
        observer.observe(el);
    });

    document.querySelectorAll('.stagger').forEach((container) => {
        Array.from(container.children).forEach((child, i) => {
            if (!child.classList.contains('reveal-up') &&
                !child.classList.contains('reveal') &&
                !child.classList.contains('reveal-fade')) {
                child.classList.add('reveal-up');
            }
            child.style.transitionDelay = `${i * 80}ms`;
            observer.observe(child);
        });
    });
}
document.addEventListener("click", async (e) => {

    const saveBtn = e.target.closest(".save-btn");
    const likeBtn = e.target.closest(".like-btn");

    if (saveBtn) {

        const id = saveBtn.dataset.event;

        await fetch(`/api/volunteer/events/${id}/save`, {
            method: "POST",
            headers: {
                "Authorization":
                    "Bearer " + localStorage.getItem("token"),
                "Accept": "application/json"
            }
        });
    }

    if (likeBtn) {

        const id = likeBtn.dataset.event;

        await fetch(`/api/volunteer/events/${id}/like`, {
            method: "POST",
            headers: {
                "Authorization":
                    "Bearer " + localStorage.getItem("token"),
                "Accept": "application/json"
            }
        });
    }

});
function initNavScroll() {
    const nav = document.querySelector('nav[data-nav], nav.sticky, nav');
    if (!nav) return;

    let lastY = 0;

    function onScroll() {
        const y = window.scrollY;

        if (y > 16) {
            nav.classList.add('nav-glass');
            nav.style.removeProperty('background');
        } else {
            nav.classList.remove('nav-glass');
        }
        lastY = y;
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); 
}

function initCardInteractions() {
    const selectors = [
        'div.bg-white.rounded-2xl.shadow-sm:not(.card)',
        'div.bg-white.rounded-2xl.overflow-hidden.shadow-sm:not(.card)',
    ];

    document.querySelectorAll(selectors.join(', ')).forEach((el) => {
        const skip = el.closest('nav, form, aside, table, thead, tbody, tr, td');
        if (skip) return;

        el.classList.add('card');
    });
}

function initFlashMessages() {
    const DISMISS_DELAY = 5000;

    document.querySelectorAll('[data-flash="success"], .flash-success').forEach((el) => {
        const btn = document.createElement('button');
        btn.setAttribute('aria-label', 'Tutup');
        btn.className = 'ml-auto text-current opacity-60 hover:opacity-100 transition-opacity text-lg leading-none';
        btn.innerHTML = '&times;';
        btn.onclick = () => dismiss(el);
        if (!el.style.display) el.style.display = 'flex';
        el.style.alignItems = 'center';
        el.style.gap = '0.75rem';
        el.appendChild(btn);

        setTimeout(() => dismiss(el), DISMISS_DELAY);
    });

    document.querySelectorAll('[data-flash="error"], .flash-error').forEach((el) => {
        const btn = document.createElement('button');
        btn.setAttribute('aria-label', 'Tutup');
        btn.className = 'ml-auto text-current opacity-60 hover:opacity-100 transition-opacity text-lg leading-none';
        btn.innerHTML = '&times;';
        btn.onclick = () => dismiss(el);

        el.style.display = 'flex';
        el.style.alignItems = 'center';
        el.style.gap = '0.75rem';
        el.appendChild(btn);
    });

    function dismiss(el) {
        el.style.transition = 'opacity 400ms ease, transform 400ms ease, max-height 400ms ease';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-8px)';
        el.style.maxHeight = '0';
        el.style.overflow = 'hidden';
        el.style.marginTop = '0';
        el.style.paddingTop = '0';
        el.style.paddingBottom = '0';
        setTimeout(() => el.remove(), 450);
    }
}

function initNavDropdown() {
    document.querySelectorAll('[data-dropdown]').forEach((wrapper) => {
        const trigger = wrapper.querySelector('[data-dropdown-trigger]');
        const menu    = wrapper.querySelector('[data-dropdown-menu]');
        if (!trigger || !menu) return;

        let open = false;

        function show() {
            open = true;
            menu.classList.remove('hidden');
            menu.style.animation = 'ak-fade-in-down 200ms cubic-bezier(0.16,1,0.3,1) both';
            trigger.setAttribute('aria-expanded', 'true');
        }

        function hide() {
            open = false;
            menu.classList.add('hidden');
            trigger.setAttribute('aria-expanded', 'false');
        }

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            open ? hide() : show();
        });

        trigger.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                open ? hide() : show();
            }
            if (e.key === 'Escape') hide();
        });

        document.addEventListener('click', (e) => {
            if (!wrapper.contains(e.target)) hide();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && open) hide();
        });
    });

    document.querySelectorAll('.group').forEach((group) => {
        const menu = group.querySelector('.group-hover\\:block');
        if (!menu) return;

        const trigger = group.querySelector('button');
        if (!trigger) return;

        let open = false;
        menu.classList.remove('group-hover:block');
        menu.classList.add('hidden');

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            open = !open;
            menu.classList.toggle('hidden', !open);
            if (open) {
                menu.style.animation = 'ak-fade-in-down 200ms cubic-bezier(0.16,1,0.3,1) both';
            }
        });

        document.addEventListener('click', () => {
            if (open) {
                open = false;
                menu.classList.add('hidden');
            }
        });
    });
}

function initStatCounters() {
    const DURATION = 1200; 

    function easeOutQuart(t) {
        return 1 - Math.pow(1 - t, 4);
    }

    function animateCount(el, target) {
        const start = performance.now();
        const isInt = Number.isInteger(target);

        function update(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / DURATION, 1);
            const eased = easeOutQuart(progress);
            const current = target * eased;

            el.textContent = isInt
                ? Math.floor(current).toLocaleString('id-ID')
                : current.toFixed(1);

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                el.textContent = isInt
                    ? target.toLocaleString('id-ID')
                    : target.toFixed(1);
            }
        }

        requestAnimationFrame(update);
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                const el = entry.target;
                const raw = el.getAttribute('data-count') || el.textContent.trim();
                const target = parseFloat(raw.replace(/[^\d.]/g, ''));

                if (!isNaN(target)) {
                    animateCount(el, target);
                }

                observer.unobserve(el);
            });
        },
        { threshold: 0.5 }
    );

    document.querySelectorAll('[data-count], .card-stat p:first-child').forEach((el) => {
        observer.observe(el);
    });

    document.querySelectorAll(
        '.bg-white.rounded-2xl.p-5.shadow-sm p:first-child, ' +
        '.bg-white.rounded-2xl.p-4.shadow-sm p:first-child'
    ).forEach((el) => {
        if (/^\d+$/.test(el.textContent.trim())) {
            const val = parseInt(el.textContent.trim(), 10);
            el.setAttribute('data-count', val);
            observer.observe(el);
        }
    });
}

function initActiveNavLinks() {
    const current = window.location.pathname;

    document.querySelectorAll('nav a, aside a').forEach((a) => {
        const href = a.getAttribute('href');
        if (!href || href === '#') return;

        try {
            const url = new URL(href, window.location.origin);
            if (url.pathname === current ||
                (url.pathname !== '/' && current.startsWith(url.pathname))) {
                a.classList.add('active');
            }
        } catch (_) {
        }
    });
}

function initImageFallback() {
    document.querySelectorAll('img[alt]').forEach((img) => {
        img.addEventListener('error', function () {
            const div = document.createElement('div');
            div.className = 'w-full flex items-center justify-center';
            div.style.cssText = `
                width: ${img.offsetWidth || '100%'};
                height: ${img.offsetHeight || '160px'};
                background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%);
                border-radius: inherit;
            `;
            div.innerHTML = '<span style="font-size:2.5rem;">🌱</span>';
            img.parentNode.replaceChild(div, img);
        }, { once: true });
    });
}

function initFormSubmitState() {
    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', function () {
            const btn = form.querySelector('button[type="submit"]');
            if (!btn) return;

            const originalHTML = btn.innerHTML;
            btn.disabled = true;
            btn.style.opacity = '0.75';
            btn.style.cursor = 'not-allowed';
            btn.innerHTML = `
                <svg class="animate-spin" style="width:1em;height:1em;display:inline-block;vertical-align:middle;"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:.25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path style="opacity:.75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 100 16v-4l-3 3 3 3v-4a8 8 0 01-8-8z"></path>
                </svg>
                <span style="margin-left:.375rem;">Memproses...</span>
            `;

            setTimeout(() => {
                btn.disabled = false;
                btn.style.opacity = '';
                btn.style.cursor = '';
                btn.innerHTML = originalHTML;
            }, 10000);
        });
    });
}

function initCategoryFilter() {
    const params = new URLSearchParams(window.location.search);
    const activeCat = params.get('category');

    document.querySelectorAll('[data-category-filter]').forEach((el) => {
        const cat = el.getAttribute('data-category-filter');
        if (cat === activeCat || (!activeCat && cat === '')) {
            el.classList.add('bg-primary', 'text-white');
            el.classList.remove('bg-white', 'text-gray-600');
        }
    });
}

function initScrollProgress() {
    const docH = document.documentElement.scrollHeight;
    const winH = window.innerHeight;
    if (docH <= winH * 2) return; 
    const bar = document.createElement('div');
    bar.setAttribute('aria-hidden', 'true');
    bar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        width: 0%;
        background: linear-gradient(90deg, #1E3A8A, #3B82F6, #60A5FA);
        z-index: 9999;
        transition: width 100ms linear;
        pointer-events: none;
    `;
    document.body.prepend(bar);

    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
        const pct = maxScroll > 0 ? (scrolled / maxScroll) * 100 : 0;
        bar.style.width = `${pct}%`;
    }, { passive: true });
}

function initCardImageZoom() {
    document.querySelectorAll('.card, [class*="rounded-2xl"]').forEach((card) => {
        const img = card.querySelector('img');
        if (!img) return;

        const wrapper = img.parentElement;
        if (wrapper && !wrapper.classList.contains('card-img-zoom')) {
            wrapper.classList.add('card-img-zoom');
        }
    });
}

function initSmoothAnchorScroll() {
    document.querySelectorAll('a[href^="#"]').forEach((a) => {
        a.addEventListener('click', (e) => {
            const id = a.getAttribute('href').slice(1);
            const target = document.getElementById(id);
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
}

function initToastSystem() {
    let container = document.getElementById('ak-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'ak-toast-container';
        container.setAttribute('aria-live', 'polite');
        container.style.cssText = `
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            pointer-events: none;
        `;
        document.body.appendChild(container);
    }

    window.akToast = function (message, type = 'info', duration = 4000) {
        const STYLES = {
            success: 'background:#dcfce7;color:#166534;border-left:4px solid #22c55e;',
            error:   'background:#fee2e2;color:#991b1b;border-left:4px solid #ef4444;',
            info:    'background:#eff6ff;color:#1e40af;border-left:4px solid #3b82f6;',
        };

        const toast = document.createElement('div');
        toast.style.cssText = `
            ${STYLES[type] || STYLES.info}
            padding: 0.75rem 1.125rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: 0 4px 16px rgba(0,0,0,.10);
            animation: ak-fade-in 300ms cubic-bezier(0.16,1,0.3,1) both;
            pointer-events: auto;
            max-width: 320px;
        `;
        toast.textContent = message;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.transition = 'opacity 300ms, transform 300ms';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(16px)';
            setTimeout(() => toast.remove(), 320);
        }, duration);
    };
}

ready(function () {
    initScrollReveal();
    initNavScroll();
    initCardInteractions();
    initFlashMessages();
    initNavDropdown();
    initStatCounters();
    initActiveNavLinks();
    initImageFallback();
    initFormSubmitState();
    initCategoryFilter();
    initScrollProgress();
    initCardImageZoom();
    initSmoothAnchorScroll();
    initToastSystem();
});
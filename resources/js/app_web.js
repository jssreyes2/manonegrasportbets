// resources/js/app_web.js

// 1. Importa jQuery y hazlo global inmediatamente
import $ from 'jquery';

window.$ = window.jQuery = $;

// Importa plugins desde npm
import 'jquery-ui';
import 'jquery-validation';

// Importa Toastr
import toastr from './toastr-wrapper.js';

// 2. Ejecución segura (Lucide ahora vendrá de forma global)
const iniciarTodo = () => {
    // Primero el revelado: si algo de lo demás falla, el contenido no queda oculto
    initReveal();

    [initAuthDropdown, initCounters, initFreePick, initMobileCta].forEach((init) => {
        try {
            init();
        } catch (e) {
            console.error(e);
        }
    });

    if (window.lucide) {
        window.lucide.createIcons();
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', iniciarTodo);
} else {
    iniciarTodo();
}

// 3. El menú móvil (hamburguesa) vive inline en layouts/frontend/heard.blade.php

// 4. Lógica del Dropdown "Mi Cuenta"
function initAuthDropdown() {
    const dropdownBtn = document.getElementById('auth-dropdown-btn');
    const dropdownMenu = document.getElementById('auth-dropdown');

    if (!dropdownBtn || !dropdownMenu) return;

    const hiddenClasses = ['opacity-0', 'invisible', '-translate-y-2', 'pointer-events-none'];

    const setOpen = (open) => {
        dropdownMenu.classList[open ? 'remove' : 'add'](...hiddenClasses);
        dropdownBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    dropdownBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        setOpen(dropdownMenu.classList.contains('invisible'));
    });

    document.addEventListener('click', () => setOpen(false));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && dropdownBtn.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
            dropdownBtn.focus();
        }
    });
}
// 5. Revelado de secciones al hacer scroll
function initReveal() {
    window.__revealReady = true;

    const items = document.querySelectorAll('[data-reveal]');
    if (!items.length) return;

    if (!('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    items.forEach((el) => observer.observe(el));
}

// 6. Contadores animados: <span data-count="10" data-prefix="+" data-suffix="M" data-decimals="0">
function initCounters() {
    const counters = document.querySelectorAll('[data-count]');
    if (!counters.length || !('IntersectionObserver' in window)) return;

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const render = (el, value) => {
        const decimals = parseInt(el.dataset.decimals || '0', 10);
        el.textContent = (el.dataset.prefix || '') + value.toFixed(decimals) + (el.dataset.suffix || '');
    };

    const animate = (el) => {
        const target = parseFloat(el.dataset.count);
        if (reduceMotion) return render(el, target);

        const duration = 1600;
        const start = performance.now();
        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            render(el, target * eased);
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            animate(entry.target);
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.5 });

    counters.forEach((el) => observer.observe(el));
}

// 7. Modal "Pick gratis": botones [data-open-freepick] y apertura automática
//    (por tiempo o intención de salida) en páginas con <body data-freepick-auto>
function initFreePick() {
    const modal = document.getElementById('modal');
    if (!modal) return;

    const open = () => {
        modal.classList.remove('hidden');
        const firstInput = modal.querySelector('input:not([type=hidden])');
        if (firstInput) setTimeout(() => firstInput.focus(), 50);
    };
    window.openFreePickModal = open;

    document.querySelectorAll('[data-open-freepick]').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            open();
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') modal.classList.add('hidden');
    });

    if (!document.body.hasAttribute('data-freepick-auto')) return;

    // No volver a mostrarlo automáticamente durante 7 días
    const STORAGE_KEY = 'lmn_freepick_seen';
    const WEEK = 7 * 24 * 60 * 60 * 1000;
    let lastSeen = 0;
    try {
        lastSeen = parseInt(localStorage.getItem(STORAGE_KEY) || '0', 10);
    } catch (e) { /* almacenamiento bloqueado */ }
    if (Date.now() - lastSeen < WEEK) return;

    let shown = false;
    const autoOpen = () => {
        if (shown || !modal.classList.contains('hidden')) return;
        shown = true;
        open();
        try {
            localStorage.setItem(STORAGE_KEY, String(Date.now()));
        } catch (e) { /* almacenamiento bloqueado */ }
    };

    setTimeout(autoOpen, 30000);
    document.addEventListener('mouseout', (e) => {
        if (!e.relatedTarget && e.clientY <= 0) autoOpen();
    });
}

// 8. Barra CTA fija en móvil: aparece tras pasar el hero y se oculta al llegar al footer
function initMobileCta() {
    const bar = document.getElementById('mobile-cta');
    if (!bar) return;

    const footer = document.querySelector('footer');
    const update = () => {
        const pastHero = window.scrollY > 500;
        const nearFooter = footer && footer.getBoundingClientRect().top < window.innerHeight;
        bar.classList.toggle('is-shown', pastHero && !nearFooter);
    };

    window.addEventListener('scroll', update, { passive: true });
    update();
}

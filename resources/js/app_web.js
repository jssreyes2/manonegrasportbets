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
    if (window.lucide) {
        window.lucide.createIcons();
    }
    initMobileMenu();
    initAuthDropdown();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', iniciarTodo);
} else {
    iniciarTodo();
}

// 3. Lógica del Menú Móvil (Hamburguesa)
function initMobileMenu() {
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (!menuBtn || !mobileMenu) return;

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');

        const menuIcon = document.getElementById('menu-icon');
        if (!menuIcon) return;

        const isMenuOpen = !mobileMenu.classList.contains('hidden');
        if (isMenuOpen) {
            menuIcon.setAttribute('data-lucide', 'x');
        } else {
            menuIcon.setAttribute('data-lucide', 'menu');
        }

        if (window.lucide) window.lucide.createIcons();
    });
}

// 4. Lógica del Dropdown "Mi Cuenta"
function initAuthDropdown() {
    const dropdownBtn = document.getElementById('auth-dropdown-btn');
    const dropdownMenu = document.getElementById('auth-dropdown');

    if (!dropdownBtn || !dropdownMenu) return;

    dropdownBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isHidden = dropdownMenu.classList.contains('invisible');

        if (isHidden) {
            dropdownMenu.classList.remove('opacity-0', 'invisible', '-translate-y-2', 'pointer-events-none');
        } else {
            dropdownMenu.classList.add('opacity-0', 'invisible', '-translate-y-2', 'pointer-events-none');
        }
    });

    document.addEventListener('click', () => {
        dropdownMenu.classList.add('opacity-0', 'invisible', '-translate-y-2', 'pointer-events-none');
    });
}
/**
 * Header - Mobile Menu Toggle
 * Acemar Theme
 */

(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('menu-toggle');
        const nav    = document.getElementById('site-navigation');

        if (!toggle || !nav) return;

        // Abrir / cerrar menú
        toggle.addEventListener('click', function () {
            const isOpen = nav.classList.contains('nav-open');

            toggle.classList.toggle('is-active', !isOpen);
            nav.classList.toggle('nav-open', !isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });

        // Cerrar al hacer click en un link del menú
        nav.querySelectorAll('#primary-menu a').forEach(function (link) {
            link.addEventListener('click', function () {
                toggle.classList.remove('is-active');
                nav.classList.remove('nav-open');
                toggle.setAttribute('aria-expanded', 'false');
            });
        });

        // Cerrar al hacer click fuera del header
        document.addEventListener('click', function (e) {
            const header = document.getElementById('masthead');
            if (header && !header.contains(e.target)) {
                toggle.classList.remove('is-active');
                nav.classList.remove('nav-open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Scroll: agregar clase 'scrolled' al header transparent
        const header = document.getElementById('masthead');
        if (header && header.classList.contains('header-transparent')) {
            window.addEventListener('scroll', function () {
                header.classList.toggle('scrolled', window.scrollY > 50);
            }, { passive: true });
        }
    });

})();
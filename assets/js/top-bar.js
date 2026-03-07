/**
 * Top Bar - Mobile Menu Toggle
 * Acemar Theme
 */

(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const trigger = document.getElementById('top-bar-trigger');
        const nav     = document.getElementById('top-bar-nav');

        if (!trigger || !nav) return;

        // Toggle abrir / cerrar
        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = nav.classList.contains('nav-open');

            trigger.classList.toggle('is-active', !isOpen);
            nav.classList.toggle('nav-open', !isOpen);
            trigger.setAttribute('aria-expanded', String(!isOpen));
        });

        // Cerrar al hacer click en un link
        nav.querySelectorAll('#top-bar-menu a').forEach(function (link) {
            link.addEventListener('click', function () {
                trigger.classList.remove('is-active');
                nav.classList.remove('nav-open');
                trigger.setAttribute('aria-expanded', 'false');
            });
        });

        // Cerrar al hacer click fuera
        document.addEventListener('click', function (e) {
            const topBar = document.getElementById('top-bar');
            if (topBar && !topBar.contains(e.target)) {
                trigger.classList.remove('is-active');
                nav.classList.remove('nav-open');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });
    });

})();
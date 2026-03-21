/**
 * Header - Mobile Menu Toggle + Sticky Scroll + Submenús
 * Acemar Theme
 */

(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        const toggle  = document.getElementById('menu-toggle');
        const nav     = document.getElementById('site-navigation');
        const header  = document.getElementById('masthead');
        const topBar  = document.getElementById('top-bar');

        // ----------------------------------------
        // Mobile menu toggle
        // ----------------------------------------
        if (toggle && nav) {
            toggle.addEventListener('click', function () {
                const isOpen = nav.classList.contains('nav-open');
                toggle.classList.toggle('is-active', !isOpen);
                nav.classList.toggle('nav-open', !isOpen);
                toggle.setAttribute('aria-expanded', String(!isOpen));
            });

            // Cerrar al hacer click en un link (solo si NO tiene hijos)
            nav.querySelectorAll('#primary-menu a').forEach(function (link) {
                link.addEventListener('click', function () {
                    const parentLi = link.closest('li');
                    if (parentLi && parentLi.classList.contains('menu-item-has-children')) {
                        return; // lo maneja el bloque de submenús
                    }
                    toggle.classList.remove('is-active');
                    nav.classList.remove('nav-open');
                    toggle.setAttribute('aria-expanded', 'false');
                });
            });

            document.addEventListener('click', function (e) {
                if (header && !header.contains(e.target)) {
                    toggle.classList.remove('is-active');
                    nav.classList.remove('nav-open');
                    toggle.setAttribute('aria-expanded', 'false');
                    // Cerrar submenús abiertos
                    closeAllSubmenus();
                }
            });
        }

        // ----------------------------------------
        // Submenús
        // ----------------------------------------
        var isMobile = function () {
            return window.innerWidth <= 810;
        };

        var closeAllSubmenus = function (except) {
            document.querySelectorAll('#primary-menu .menu-item-has-children.is-open').forEach(function (item) {
                if (item !== except) {
                    item.classList.remove('is-open');
                }
            });
        };

        document.querySelectorAll('#primary-menu .menu-item-has-children').forEach(function (item) {
            const link    = item.querySelector(':scope > a');
            const submenu = item.querySelector(':scope > .sub-menu');

            if (!link || !submenu) return;

            // Click en el link padre
            link.addEventListener('click', function (e) {
                // Desktop: solo interceptar en touch devices (hover ya lo maneja CSS)
                // Mobile: siempre interceptar
                if (!isMobile() && !('ontouchstart' in window)) return;

                e.preventDefault();
                const isOpen = item.classList.contains('is-open');
                closeAllSubmenus(item);
                item.classList.toggle('is-open', !isOpen);
            });

            // Desktop con teclado: abrir con Enter/Space
            link.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const isOpen = item.classList.contains('is-open');
                    closeAllSubmenus(item);
                    item.classList.toggle('is-open', !isOpen);
                }
                if (e.key === 'Escape') {
                    item.classList.remove('is-open');
                    link.focus();
                }
            });

            // Cerrar al salir del item (desktop, no touch)
            item.addEventListener('mouseleave', function () {
                if (!isMobile()) {
                    item.classList.remove('is-open');
                }
            });

            // Cerrar con Escape dentro del submenu
            submenu.querySelectorAll('a').forEach(function (subLink) {
                subLink.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        item.classList.remove('is-open');
                        link.focus();
                    }
                });

                // En mobile: cerrar el menú al navegar
                subLink.addEventListener('click', function () {
                    if (isMobile() && toggle && nav) {
                        toggle.classList.remove('is-active');
                        nav.classList.remove('nav-open');
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                });
            });
        });

        // ----------------------------------------
        // Sticky scroll (solo desktop)
        // ----------------------------------------
        if (header) {
            var isTransparent = header.classList.contains('header-transparent');

            var getTopBarHeight = function () {
                return topBar ? topBar.offsetHeight : 0;
            };

            var handleScroll = function () {
                if (isMobile()) {
                    header.classList.remove('header-sticky');
                    header.classList.remove('scrolled');
                    if (topBar) topBar.classList.remove('top-bar-sticky');
                    return;
                }

                var scrolled    = window.scrollY > 80;
                var topBarH     = getTopBarHeight();

                if (scrolled) {
                    header.classList.add('header-sticky');
                    header.style.top = topBarH + 'px';

                    if (topBar) {
                        topBar.classList.add('top-bar-sticky');
                        topBar.style.backgroundColor = '#ffffff';
                        topBar.style.borderBottom = '1px solid rgba(0,0,0,0.08)';
                    }
                } else {
                    header.classList.remove('header-sticky');
                    header.style.top = '';

                    if (topBar) {
                        topBar.classList.remove('top-bar-sticky');
                        topBar.style.backgroundColor = '';
                        topBar.style.borderBottom = '';
                    }
                }

                if (isTransparent) {
                    header.classList.toggle('scrolled', window.scrollY > 50);
                }
            };

            window.addEventListener('resize', handleScroll, { passive: true });
            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll();
        }
    });

})();
/**
 * Header - Mobile Menu Toggle + Sticky Scroll
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

            nav.querySelectorAll('#primary-menu a').forEach(function (link) {
                link.addEventListener('click', function () {
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
                }
            });
        }

        // ----------------------------------------
        // Sticky scroll (solo desktop)
        // ----------------------------------------
        if (header) {
            var topBarHeight = topBar ? topBar.offsetHeight : 0;

            var isMobile = function () {
                return window.innerWidth <= 810;
            };

            var handleScroll = function () {
                if (isMobile()) {
                    header.classList.remove('header-sticky');
                    if (topBar) topBar.classList.remove('top-bar-sticky');
                    return;
                }

                if (window.scrollY > 80) {
                    header.classList.add('header-sticky');
                    if (topBar) topBar.classList.add('top-bar-sticky');
                } else {
                    header.classList.remove('header-sticky');
                    if (topBar) topBar.classList.remove('top-bar-sticky');
                }
            };

            // Recalcular altura del top-bar en resize
            window.addEventListener('resize', function () {
                topBarHeight = topBar ? topBar.offsetHeight : 0;
                handleScroll();
            }, { passive: true });

            window.addEventListener('scroll', handleScroll, { passive: true });

            // Scroll: clase 'scrolled' para header transparent
            if (header.classList.contains('header-transparent')) {
                window.addEventListener('scroll', function () {
                    if (!isMobile()) {
                        header.classList.toggle('scrolled', window.scrollY > 50);
                    }
                }, { passive: true });
            }
        }
    });

})();
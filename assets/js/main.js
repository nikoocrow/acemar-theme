/**
 * Main JavaScript - Acemar Theme
 * @author GetReady
 */

(function($) {
    'use strict';
    
    // Document ready
    $(document).ready(function() {
        console.log('Acemar Theme loaded by GetReady');
        
        // Smooth scroll para anchors
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.hash);
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800);
            }
        });
        
        // Mobile menu toggle (si necesitas uno más adelante)
        $('.menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation').toggleClass('active');
        });
    });
    
    // Window load
    $(window).on('load', function() {
        // Aquí puedes agregar código que necesite esperar a que todo cargue
    });
    
})(jQuery);


// Header scroll effect para hero
if ($('body').hasClass('hero-template')) {
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 100) {
            $('.header-transparent').addClass('scrolled');
        } else {
            $('.header-transparent').removeClass('scrolled');
        }
    });
}
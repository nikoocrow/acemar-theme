/**
 * Blog JavaScript Functionality
 * Acemar Theme
 */

(function($) {
    'use strict';

    /**
     * Blog Card Hover Effects
     */
    function initCardHoverEffects() {
        $('.blog-card').on('mouseenter', function() {
            $(this).find('.card-image').addClass('zoomed');
        }).on('mouseleave', function() {
            $(this).find('.card-image').removeClass('zoomed');
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 800);
            }
        });
    }

    /**
     * Load More Posts (Ajax)
     * This would require additional WordPress Ajax setup
     */
    function initLoadMore() {
        $('.btn-ver-mas-ajax').on('click', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const categoryId = $button.closest('.blog-category-section').data('category-id');
            const currentPage = $button.data('page') || 1;
            const nextPage = currentPage + 1;
            
            // Show loading state
            $button.addClass('loading').text('Cargando...');
            
            // Ajax request (would need WordPress ajax handler)
            $.ajax({
                url: acemarBlog.ajaxUrl, // Would be localized from WordPress
                type: 'POST',
                data: {
                    action: 'load_more_blog_posts',
                    category_id: categoryId,
                    page: nextPage,
                    nonce: acemarBlog.nonce
                },
                success: function(response) {
                    if (response.success && response.data.html) {
                        // Append new posts
                        $button.closest('.blog-category-section')
                               .find('.blog-grid')
                               .append(response.data.html);
                        
                        // Update page number
                        $button.data('page', nextPage);
                        
                        // Hide button if no more posts
                        if (!response.data.has_more) {
                            $button.fadeOut();
                        }
                    }
                },
                error: function() {
                    alert('Error al cargar más posts. Por favor intenta de nuevo.');
                },
                complete: function() {
                    $button.removeClass('loading').text('Ver más');
                }
            });
        });
    }

    /**
     * Image Lazy Loading (if not using native lazy loading)
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const bgImage = img.getAttribute('data-bg');
                        
                        if (bgImage) {
                            img.style.backgroundImage = `url('${bgImage}')`;
                            img.removeAttribute('data-bg');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('[data-bg]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Reading Progress Bar (for single posts)
     */
    function initReadingProgress() {
        if ($('.single-blog').length) {
            const progressBar = $('<div class="reading-progress"></div>');
            $('body').prepend(progressBar);

            $(window).on('scroll', function() {
                const windowHeight = $(window).height();
                const documentHeight = $(document).height();
                const scrollTop = $(window).scrollTop();
                const progress = (scrollTop / (documentHeight - windowHeight)) * 100;

                progressBar.css('width', progress + '%');
            });
        }
    }

    /**
     * Share Buttons (for single posts)
     */
    function initShareButtons() {
        $('.share-button').on('click', function(e) {
            e.preventDefault();
            
            const platform = $(this).data('platform');
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            
            let shareUrl = '';
            
            switch(platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${url}&title=${title}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title}%20${url}`;
                    break;
            }
            
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        });
    }

    /**
     * Initialize all blog functions
     */
    function init() {
        initCardHoverEffects();
        initSmoothScroll();
        initLazyLoading();
        initReadingProgress();
        initShareButtons();
        
        // Uncomment when Ajax handler is ready
        // initLoadMore();
    }

    // Run on document ready
    $(document).ready(init);

})(jQuery);

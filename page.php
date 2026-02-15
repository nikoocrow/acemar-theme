<?php
/**
 * The template for displaying pages
 *
 * @package Acemar
 * @author GetReady
 */

get_header(); ?>

<main id="main-content" class="site-main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-page'); ?>>
                
                <header class="entry-header">
                  
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('acemar-featured'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="entry-content">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Páginas:', 'acemar'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>
                
            </article>
            
            <?php
            // Comments
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
            
        <?php endwhile; ?>
        
    </div>
</main>

<?php get_footer(); ?>

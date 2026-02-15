<?php
/**
 * Template for displaying single blog post
 *
 * @package Acemar
 * @author GetReady
 */

get_header();
?>

<main id="single-blog" class="single-blog">
    
    <?php
    while (have_posts()) : the_post();
        
        // Get hero image (custom or featured)
        $hero_image = get_field('blog_hero_image');
        if (empty($hero_image)) {
            $hero_image = get_post_thumbnail_id();
            $hero_image = $hero_image ? wp_get_attachment_image_url($hero_image, 'full') : '';
        } else {
            $hero_image = $hero_image['url'];
        }
        ?>
        
        <!-- Hero Section -->
        <section class="single-blog-hero" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
            <div class="hero-overlay"></div>
            <div class="container hero-content">
                
                <?php
                // Get categories
                $categories = get_the_terms(get_the_ID(), 'blog_category');
                if ($categories && !is_wp_error($categories)) :
                    ?>
                    <div class="post-categories">
                        <?php foreach ($categories as $category) : ?>
                            <a href="<?php echo esc_url(get_term_link($category)); ?>" class="post-category">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <h1 class="post-title"><?php the_title(); ?></h1>
                
                <div class="post-meta">
                    <span class="post-date">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M12.6667 2.66667H3.33333C2.59695 2.66667 2 3.26362 2 4V13.3333C2 14.0697 2.59695 14.6667 3.33333 14.6667H12.6667C13.403 14.6667 14 14.0697 14 13.3333V4C14 3.26362 13.403 2.66667 12.6667 2.66667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.6667 1.33334V4.00001" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5.33333 1.33334V4.00001" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 6.66666H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php echo get_the_date('d M, Y'); ?>
                    </span>
                    
                    <span class="post-author">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M13.3333 14V12.6667C13.3333 11.9594 13.0524 11.2811 12.5523 10.781C12.0522 10.281 11.3739 10 10.6667 10H5.33333C4.62609 10 3.94781 10.281 3.44772 10.781C2.94762 11.2811 2.66667 11.9594 2.66667 12.6667V14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 7.33333C9.47276 7.33333 10.6667 6.13943 10.6667 4.66667C10.6667 3.19391 9.47276 2 8 2C6.52724 2 5.33333 3.19391 5.33333 4.66667C5.33333 6.13943 6.52724 7.33333 8 7.33333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php the_author(); ?>
                    </span>
                </div>
                
            </div><!-- .hero-content -->
        </section><!-- .single-blog-hero -->
        
        <!-- Post Content -->
        <article class="single-blog-content">
            <div class="container">
                <div class="content-wrapper">
                    
                    <?php the_content(); ?>
                    
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Páginas:', 'acemar'),
                        'after'  => '</div>',
                    ));
                    ?>
                    
                </div><!-- .content-wrapper -->
            </div><!-- .container -->
        </article><!-- .single-blog-content -->
        
        <!-- Related Posts -->
        <?php
        $categories = get_the_terms(get_the_ID(), 'blog_category');
        
        if ($categories && !is_wp_error($categories)) :
            $category_ids = array();
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }
            
            $related_query = new WP_Query(array(
                'post_type' => 'acemar_blog',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'blog_category',
                        'field' => 'term_id',
                        'terms' => $category_ids,
                    ),
                ),
                'orderby' => 'rand',
            ));
            
            if ($related_query->have_posts()) :
                ?>
                
                <section class="related-posts">
                    <div class="container">
                        <h2 class="section-title"><?php _e('Posts Relacionados', 'acemar'); ?></h2>
                        
                        <div class="blog-grid blog-grid-related">
                            <?php
                            while ($related_query->have_posts()) :
                                $related_query->the_post();
                                get_template_part('template-parts/blog/card', 'medium');
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </section>
                
            <?php
            endif;
        endif;
        ?>
        
        <!-- Navigation -->
        <nav class="post-navigation">
            <div class="container">
                <?php
                $prev_post = get_previous_post(true, '', 'blog_category');
                $next_post = get_next_post(true, '', 'blog_category');
                
                if ($prev_post) :
                    ?>
                    <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="nav-link nav-prev">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span><?php _e('Anterior', 'acemar'); ?></span>
                    </a>
                <?php endif; ?>
                
                <a href="<?php echo esc_url(get_post_type_archive_link('acemar_blog')); ?>" class="nav-link nav-all">
                    <?php _e('Ver todos', 'acemar'); ?>
                </a>
                
                <?php if ($next_post) : ?>
                    <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="nav-link nav-next">
                        <span><?php _e('Siguiente', 'acemar'); ?></span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </nav>
        
    <?php endwhile; ?>
    
</main><!-- #single-blog -->

<?php
get_footer();

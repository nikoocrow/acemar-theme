<?php
/**
 * Template for displaying blog archive
 * 
 * @package Acemar
 * @author GetReady
 */

// Obtener estilo de header del Customizer (en lugar de forzarlo)
add_filter('acf/load_value/name=estilo_de_header', function($value) {
    if (is_post_type_archive('acemar_blog')) {
        // Leer del Customizer
        $header_style = get_theme_mod('blog_header_style', 'transparent');
        return $header_style;
    }
    return $value;
}, 10, 1);

get_header();
?>

<main id="blog-archive" class="blog-archive">
    
    <?php get_template_part('template-parts/blog/hero', 'blog'); ?>

    <div class="container blog-content">
        
        <?php
        /**
         * Obtener todas las categorías del blog
         */
        $categories = get_terms(array(
            'taxonomy' => 'blog_category',
            'hide_empty' => true,
            'orderby' => 'term_id',
            'order' => 'ASC',
        ));

        if (!empty($categories) && !is_wp_error($categories)) :
            
            foreach ($categories as $category) :
                
                $posts_per_category = 4;
                
                $category_query = new WP_Query(array(
                    'post_type' => 'acemar_blog',
                    'posts_per_page' => $posts_per_category,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'blog_category',
                            'field' => 'term_id',
                            'terms' => $category->term_id,
                        ),
                    ),
                    'orderby' => 'date',
                    'order' => 'DESC',
                ));

                if ($category_query->have_posts()) :
                    ?>
                    
                    <section class="blog-category-section">
                        
                        <div class="category-header">
                            <h2 class="category-title"><?php echo esc_html($category->name); ?></h2>
                            
                            <?php if ($category_query->found_posts > $posts_per_category) : ?>
                                <a href="<?php echo esc_url(get_term_link($category)); ?>" class="btn-ver-mas">
                                    Ver más
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>

                        <?php
                        $layout_class = 'blog-grid-default';
                        
                        switch ($category->slug) {
                            case 'inspirate':
                                $layout_class = 'blog-grid-inspirate';
                                break;
                            case 'productos':
                                $layout_class = 'blog-grid-productos';
                                break;
                            case 'publicaciones-destacadas':
                                $layout_class = 'blog-grid-destacadas';
                                break;
                        }
                        ?>

                        <div class="blog-grid <?php echo esc_attr($layout_class); ?>">
                            
                            <?php 
                            $post_index = 1;
                            
                            while ($category_query->have_posts()) : 
                                $category_query->the_post();
                                
                                $card_template = 'card-default';
                                
                                if ($category->slug === 'inspirate') {
                                    $card_template = ($post_index === 1) ? 'card-large' : 'card-medium';
                                } elseif ($category->slug === 'productos') {
                                    $card_template = 'card-product';
                                } elseif ($category->slug === 'publicaciones-destacadas') {
                                    $card_template = 'card-featured';
                                }
                                
                                get_template_part('template-parts/blog/' . $card_template);
                                
                                $post_index++;
                            endwhile; 
                            ?>
                            
                        </div>
                        
                    </section>
                    
                    <?php
                    wp_reset_postdata();
                endif;
                
            endforeach;
            
        else :
            ?>
            
            <div class="no-posts">
                <p>No hay posts disponibles en este momento.</p>
            </div>
            
        <?php endif; ?>
        
    </div>
    
</main>

<?php
get_footer();
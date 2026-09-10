<?php
/**
 * Página de entradas (posts nativos de WordPress)
 *
 * Se usa cuando Ajustes > Lectura tiene una "Página de entradas" asignada.
 * Sustituye al antiguo archive-acemar_blog.php: el CPT acemar_blog se
 * unificó con el post type nativo `post` y su taxonomía con `category`.
 *
 * @package Acemar
 * @author GetReady
 */

// El estilo de header sale del Customizer (Opciones del Tema > Blog) en vez
// de forzarse: esta plantilla no tiene un post con campo ACF propio.
add_filter('acf/load_value/name=estilo_de_header', function ($value) {
    if (is_home()) {
        return get_theme_mod('blog_header_style', 'transparent');
    }
    return $value;
}, 10, 1);

get_header();
?>

<main id="blog-archive" class="blog-archive">

    <?php get_template_part('template-parts/blog/hero', 'blog'); ?>

    <div class="container blog-content">

        <?php
        // Un bloque por categoría, en el orden en que se crearon.
        $categories = get_terms(array(
            'taxonomy'   => 'category',
            'hide_empty' => true,
            'orderby'    => 'term_id',
            'order'      => 'ASC',
        ));

        if (!empty($categories) && !is_wp_error($categories)) :

            foreach ($categories as $category) :

                $posts_per_category = (int) get_theme_mod('blog_posts_per_category', 4);

                $category_query = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => $posts_per_category,
                    'cat'            => $category->term_id,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ));

                if ($category_query->have_posts()) :
                    ?>

                    <section class="blog-category-section">

                        <div class="category-header">
                            <h2 class="category-title"><?php echo esc_html($category->name); ?></h2>

                            <?php if ($category_query->found_posts > $posts_per_category) : ?>
                                <a href="<?php echo esc_url(get_category_link($category)); ?>" class="btn-ver-mas">
                                    <?php echo esc_html( get_theme_mod('blog_load_more_text', 'Ver más') ); ?>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>

                        <?php
                        // El layout y la tarjeta dependen del slug de la categoría.
                        switch ($category->slug) {
                            case 'inspirate':
                            case 'productos':
                                $layout_class  = 'blog-grid-productos';
                                $card_template = 'card-product';
                                break;

                            case 'publicaciones-destacadas':
                                $layout_class  = 'blog-grid-destacadas';
                                $card_template = 'card-featured';
                                break;

                            default:
                                $layout_class  = 'blog-grid-default';
                                $card_template = 'card-default';
                        }
                        ?>

                        <div class="blog-grid <?php echo esc_attr($layout_class); ?>">

                            <?php
                            while ($category_query->have_posts()) :
                                $category_query->the_post();
                                get_template_part('template-parts/blog/' . $card_template);
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
                <p><?php esc_html_e('No hay posts disponibles en este momento.', 'acemar'); ?></p>
            </div>

        <?php endif; ?>

    </div>

</main>

<?php
get_footer();

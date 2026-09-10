<?php
/**
 * Archivo genérico: categorías, etiquetas, autor y fechas de los posts.
 *
 * Es el destino de los enlaces "Ver más" de home.php. Antes no existía y
 * esas URLs caían en index.php, sin hero ni grid.
 *
 * @package Acemar
 * @author GetReady
 */

add_filter('acf/load_value/name=estilo_de_header', function ($value) {
    if (is_archive()) {
        return get_theme_mod('blog_header_style', 'transparent');
    }
    return $value;
}, 10, 1);

get_header();
?>

<main id="blog-archive" class="blog-archive">

    <?php
    // El hero es el mismo del blog; el propio partial pone el título del
    // archivo actual (categoría, etiqueta, autor…) cuando is_archive().
    get_template_part('template-parts/blog/hero', 'blog');
    ?>

    <div class="container blog-content">

        <?php if (have_posts()) : ?>

            <?php if ($description = get_the_archive_description()) : ?>
                <div class="archive-description"><?php echo wp_kses_post($description); ?></div>
            <?php endif; ?>

            <div class="blog-grid blog-grid-productos">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/blog/card', 'product');
                endwhile;
                ?>
            </div>

            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => esc_html__('Anterior', 'acemar'),
                'next_text' => esc_html__('Siguiente', 'acemar'),
            ));
            ?>

        <?php else : ?>

            <div class="no-posts">
                <p><?php esc_html_e('No hay posts disponibles en este momento.', 'acemar'); ?></p>
            </div>

        <?php endif; ?>

    </div>

</main>

<?php
get_footer();

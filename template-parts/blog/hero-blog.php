<?php
/**
 * Hero del blog
 *
 * Lo usan home.php (página de entradas) y archive.php (categoría, etiqueta,
 * autor, fechas). En un archivo el título sale del propio archivo; en la
 * página de entradas, del Customizer.
 *
 * @package Acemar
 * @author GetReady
 */

$hero_image = get_theme_mod('blog_hero_image');

if (is_archive()) {
    // get_the_archive_title() devuelve "Categoría: Nombre"; el prefijo sobra
    // en un hero a pantalla completa.
    $hero_title = wp_strip_all_tags( get_the_archive_title() );
    $hero_title = preg_replace('/^[^:]+:\s*/u', '', $hero_title);
} else {
    $hero_title = get_theme_mod('blog_hero_title', 'BLOG');
}

// Fallback si no hay imagen configurada en Opciones del Tema > Blog.
if (!$hero_image) {
    $hero_image = get_template_directory_uri() . '/assets/imagenes/blog-hero.jpg';
}
?>

<div class="blog-hero" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
    <div class="hero-overlay"></div>

    <div class="hero-container">
        <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
    </div>
</div>

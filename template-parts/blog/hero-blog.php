<?php
/**
 * Template part for blog hero section
 *
 * @package Acemar
 * @author GetReady
 */

// Obtener imagen del Customizer
$hero_image = get_theme_mod('blog_hero_image');
$hero_title = get_theme_mod('blog_hero_title', 'BLOG');

// Fallback si no hay imagen configurada
if (!$hero_image) {
    $hero_image = get_template_directory_uri() . '/assets/imagenes/blog-hero.jpg';
}
?>

<div class="blog-hero" style="
    height: 70vh;
    min-height: 600px;
    background-image: url('<?php echo esc_url($hero_image); ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
">
    <!-- Overlay -->
    <div style="
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.3),
            rgba(0, 0, 0, 0.5)
        );
    "></div>
    
    <!-- Contenido -->
    <div style="
        position: relative;
        z-index: 2;
        text-align: center;
    ">
        <h1 style="
            color: white;
            font-size: 4rem;
            margin: 0;
            letter-spacing: 0.1em;
            font-weight: 700;
            text-transform: uppercase;
        "><?php echo esc_html($hero_title); ?></h1>
    </div>
</div>
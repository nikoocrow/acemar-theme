<?php
/**
 * Theme Options — Customizer
 *
 * Opciones GLOBALES del tema: aplican a todo el sitio, no por página.
 * Se usa el Customizer (y no una página de opciones de ACF) porque
 * acf_add_options_page() sólo existe en ACF PRO y aquí corre la versión free.
 *
 * @package Acemar
 * @author GetReady
 */

if (!defined('ABSPATH')) exit;

/**
 * Sanitiza un porcentaje 0–100.
 *
 * @param mixed $value Valor crudo del Customizer.
 * @return int Entero acotado entre 0 y 100.
 */
function acemar_sanitize_percent( $value ) {
    return max( 0, min( 100, absint( $value ) ) );
}

/**
 * Devuelve la opacidad de la top bar ya normalizada a 0–1 para CSS.
 *
 * @param string $mod     Nombre del theme_mod.
 * @param int    $default Porcentaje por defecto (0–100).
 * @return string Valor listo para una custom property (ej. "0.92").
 */
function acemar_topbar_overlay_value( $mod, $default ) {
    $percent = acemar_sanitize_percent( get_theme_mod( $mod, $default ) );
    return (string) round( $percent / 100, 2 );
}

/**
 * Sanitiza el número de posts por categoría del archivo del blog.
 *
 * @param mixed $value Valor crudo del Customizer.
 * @return int Entero acotado entre 1 y 12.
 */
function acemar_sanitize_posts_per_category( $value ) {
    return max( 1, min( 12, absint( $value ) ) );
}

/**
 * Sanitiza el estilo de header del blog contra la lista de opciones válidas.
 *
 * @param mixed $value Valor crudo del Customizer.
 * @return string Uno de: normal | transparent | minimal.
 */
function acemar_sanitize_header_style( $value ) {
    $allowed = array( 'normal', 'transparent', 'minimal' );
    return in_array( $value, $allowed, true ) ? $value : 'transparent';
}

// ============================================================
// PANEL "OPCIONES DEL TEMA"
// ============================================================
add_action('customize_register', function (WP_Customize_Manager $wp_customize) {

    $wp_customize->add_panel('acemar_theme_options', array(
        'title'       => __('Opciones del Tema', 'acemar'),
        'description' => __('Ajustes globales de Acemar. Aplican a todo el sitio, no por página.', 'acemar'),
        'priority'    => 30,
    ));

    // --------------------------------------------------------
    // Sección: Top Bar
    // --------------------------------------------------------
    $wp_customize->add_section('acemar_top_bar', array(
        'title'       => __('Top Bar', 'acemar'),
        'description' => __('Ajustes del menú auxiliar superior. Aplican a todas las páginas del sitio.', 'acemar'),
        'panel'       => 'acemar_theme_options',
        'priority'    => 10,
    ));

    // --- Overlay en reposo ---
    $wp_customize->add_setting('acemar_topbar_overlay', array(
        'default'           => 0,
        'sanitize_callback' => 'acemar_sanitize_percent',
        'transport'         => 'postMessage', // preview en vivo
    ));
    $wp_customize->add_control('acemar_topbar_overlay', array(
        'label'       => __('Opacidad del overlay', 'acemar'),
        'description' => __('Velo negro sobre la barra en reposo. 0 = transparente total, 100 = negro sólido.', 'acemar'),
        'type'        => 'range',
        'section'     => 'acemar_top_bar',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // --- Overlay al hacer scroll (barra fija) ---
    $wp_customize->add_setting('acemar_topbar_overlay_scroll', array(
        'default'           => 92,
        'sanitize_callback' => 'acemar_sanitize_percent',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('acemar_topbar_overlay_scroll', array(
        'label'       => __('Opacidad del overlay al hacer scroll', 'acemar'),
        'description' => __('Velo negro cuando la barra queda fija al hacer scroll. Suele querer ser más oscuro que el de reposo.', 'acemar'),
        'type'        => 'range',
        'section'     => 'acemar_top_bar',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // --------------------------------------------------------
    // Sección: Blog
    // Antes vivía suelta en functions.php (acemar_blog_customizer) y estaba
    // duplicada —sin usarse— en un grupo ACF sobre una options page que
    // requiere ACF PRO. Los IDs de setting no cambian, así que lo ya
    // guardado se conserva.
    // --------------------------------------------------------
    $wp_customize->add_section('acemar_blog_section', array(
        'title'       => __('Blog', 'acemar'),
        'description' => __('Archivo del blog: hero, header y listado por categorías.', 'acemar'),
        'panel'       => 'acemar_theme_options',
        'priority'    => 20,
    ));

    $wp_customize->add_setting('blog_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'blog_hero_image', array(
        'label'    => __('Imagen Hero del Blog', 'acemar'),
        'section'  => 'acemar_blog_section',
        'settings' => 'blog_hero_image',
    )));

    $wp_customize->add_setting('blog_hero_title', array(
        'default'           => 'BLOG',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blog_hero_title', array(
        'label'   => __('Título Hero', 'acemar'),
        'section' => 'acemar_blog_section',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('blog_header_style', array(
        'default'           => 'transparent',
        'sanitize_callback' => 'acemar_sanitize_header_style',
    ));
    $wp_customize->add_control('blog_header_style', array(
        'label'   => __('Estilo de Header', 'acemar'),
        'section' => 'acemar_blog_section',
        'type'    => 'select',
        'choices' => array(
            'normal'      => __('Header Normal', 'acemar'),
            'transparent' => __('Header Transparente', 'acemar'),
            'minimal'     => __('Header Minimalista', 'acemar'),
        ),
    ));

    $wp_customize->add_setting('blog_posts_per_category', array(
        'default'           => 4,
        'sanitize_callback' => 'acemar_sanitize_posts_per_category',
    ));
    $wp_customize->add_control('blog_posts_per_category', array(
        'label'       => __('Posts por categoría', 'acemar'),
        'description' => __('Cuántos posts se muestran en cada bloque de categoría del archivo.', 'acemar'),
        'section'     => 'acemar_blog_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 12,
            'step' => 1,
        ),
    ));

    $wp_customize->add_setting('blog_load_more_text', array(
        'default'           => 'Ver más',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blog_load_more_text', array(
        'label'       => __('Texto "Ver más"', 'acemar'),
        'description' => __('Texto del enlace de cada categoría y del botón de cargar más posts.', 'acemar'),
        'section'     => 'acemar_blog_section',
        'type'        => 'text',
    ));
});

// ============================================================
// PREVIEW EN VIVO (arrastrar el slider actualiza las CSS vars)
// ============================================================
add_action('customize_preview_init', function () {
    $rel = '/assets/js/customizer-preview.js';
    $abs = get_template_directory() . $rel;

    if ( ! file_exists( $abs ) ) {
        return;
    }

    wp_enqueue_script(
        'acemar-customizer-preview',
        get_template_directory_uri() . $rel,
        array('customize-preview'),
        filemtime( $abs ),
        true
    );
});

// ============================================================
// ACCESO DIRECTO EN EL MENÚ "APARIENCIA"
// ============================================================
/**
 * Añade "Apariencia → Opciones del Tema" como enlace que abre el Customizer
 * ya posicionado en el panel del tema. El panel vive dentro del Customizer,
 * así que sin este atajo hay que entrar por Apariencia → Personalizar y
 * buscarlo, que no es evidente.
 */
add_action('admin_menu', function () {
    $url = add_query_arg(
        array( 'autofocus[panel]' => 'acemar_theme_options' ),
        admin_url('customize.php')
    );

    add_submenu_page(
        'themes.php',
        __('Opciones del Tema', 'acemar'),
        __('Opciones del Tema', 'acemar'),
        'edit_theme_options',
        $url
    );
}, 20);

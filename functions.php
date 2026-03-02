<?php
/**
 * Acemar Theme Functions
 *
 * @package Acemar
 * @author GetReady
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================================
// AUTO-LOADER: carga todos los archivos PHP de /inc
// ============================================================
foreach (glob(get_template_directory() . '/inc/*.php') as $file) {
    require_once $file;
}

// ============================================================
// THEME SETUP
// ============================================================
function acemar_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'acemar'),
        'footer'  => __('Footer Menu', 'acemar'),
    ));
}
add_action('after_setup_theme', 'acemar_theme_setup');

// ============================================================
// ENQUEUE ASSETS
// ============================================================
function acemar_enqueue_assets() {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();

    // CSS principal
    wp_enqueue_style(
        'acemar-main-style',
        $uri . '/assets/css/style.css',
        array(),
        filemtime($dir . '/assets/css/style.css')
    );

    // JS principal
    wp_enqueue_script(
        'acemar-main-script',
        $uri . '/assets/js/main.js',
        array('jquery'),
        filemtime($dir . '/assets/js/main.js'),
        true
    );

    // JS del Blog (solo en páginas de blog)
    if (is_post_type_archive('acemar_blog') || is_singular('acemar_blog') || is_tax('blog_category')) {
        wp_enqueue_script(
            'acemar-blog-script',
            $uri . '/assets/js/blog.js',
            array('jquery'),
            filemtime($dir . '/assets/js/blog.js'),
            true
        );

        wp_localize_script('acemar-blog-script', 'acemarBlog', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('acemar_blog_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'acemar_enqueue_assets');

// ============================================================
// GOOGLE FONTS PRECONNECT
// ============================================================
function acemar_google_fonts_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'acemar_google_fonts_preconnect', 1);

// ============================================================
// CUSTOMIZER: Blog Settings
// ============================================================
function acemar_blog_customizer($wp_customize) {
    $wp_customize->add_section('acemar_blog_section', array(
        'title'    => __('Blog Settings', 'acemar'),
        'priority' => 30,
    ));

    // Imagen Hero
    $wp_customize->add_setting('blog_hero_image');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'blog_hero_image', array(
        'label'    => __('Imagen Hero del Blog', 'acemar'),
        'section'  => 'acemar_blog_section',
        'settings' => 'blog_hero_image',
    )));

    // Título Hero
    $wp_customize->add_setting('blog_hero_title', array(
        'default'           => 'BLOG',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('blog_hero_title', array(
        'label'   => __('Título Hero', 'acemar'),
        'section' => 'acemar_blog_section',
        'type'    => 'text',
    ));

    // Estilo de Header
    $wp_customize->add_setting('blog_header_style', array(
        'default'           => 'transparent',
        'sanitize_callback' => 'sanitize_text_field',
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
}
add_action('customize_register', 'acemar_blog_customizer');
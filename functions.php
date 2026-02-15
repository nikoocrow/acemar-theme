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

/**
 * Theme setup
 */
function acemar_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'acemar'),
        'footer' => __('Footer Menu', 'acemar'),
    ));
}
add_action('after_setup_theme', 'acemar_theme_setup');

/**
 * Enqueue styles and scripts
 */
function acemar_enqueue_assets() {
    // Main CSS - CAMBIO AQUÍ
    wp_enqueue_style(
        'acemar-main-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/style.css')
    );
    
    // Main JS
    wp_enqueue_script(
        'acemar-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
    
    // Blog JS (only on blog pages)
    if (is_post_type_archive('acemar_blog') || is_singular('acemar_blog') || is_tax('blog_category')) {
        wp_enqueue_script(
            'acemar-blog-script',
            get_template_directory_uri() . '/assets/js/blog.js',
            array('jquery'),
            filemtime(get_template_directory() . '/assets/js/blog.js'),
            true
        );
        
        // Localize script for Ajax (if needed later)
        wp_localize_script('acemar-blog-script', 'acemarBlog', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('acemar_blog_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'acemar_enqueue_assets');

/**
 * Add Google Fonts preconnect for better performance
 */
function acemar_google_fonts_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'acemar_google_fonts_preconnect', 1);

/**
 * Include custom post types
 */
require_once get_template_directory() . '/inc/custom-post-types.php';

/**
 * Include ACF fields configuration
 */
require_once get_template_directory() . '/inc/acf-fields.php';



/**
 * Customizer: Imagen Hero del Blog
 */
/**
 * Customizer: Imagen Hero del Blog
 */
function acemar_blog_customizer($wp_customize) {
    // Sección Blog
    $wp_customize->add_section('acemar_blog_section', array(
        'title' => 'Blog Settings',
        'priority' => 30,
    ));
    
    // Imagen Hero
    $wp_customize->add_setting('blog_hero_image');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'blog_hero_image', array(
        'label' => 'Imagen Hero del Blog',
        'section' => 'acemar_blog_section',
        'settings' => 'blog_hero_image',
    )));
    
    // Título Hero
    $wp_customize->add_setting('blog_hero_title', array(
        'default' => 'BLOG',
    ));
    $wp_customize->add_control('blog_hero_title', array(
        'label' => 'Título Hero',
        'section' => 'acemar_blog_section',
        'type' => 'text',
    ));
    
    // NUEVO: Estilo de Header
    $wp_customize->add_setting('blog_header_style', array(
        'default' => 'transparent',
    ));
    $wp_customize->add_control('blog_header_style', array(
        'label' => 'Estilo de Header',
        'section' => 'acemar_blog_section',
        'type' => 'select',
        'choices' => array(
            'normal' => 'Header Normal',
            'transparent' => 'Header Transparente',
            'minimal' => 'Header Minimalista',
        ),
    ));
}
add_action('customize_register', 'acemar_blog_customizer');

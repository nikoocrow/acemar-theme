<?php
/**
 * ACF Fields Configuration - Acemar Theme
 * 
 * @package Acemar
 * @author GetReady
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF Field Groups for Blog
 */
if (function_exists('acf_add_local_field_group')) {

    /**
     * Blog Post Settings
     */
    acf_add_local_field_group(array(
        'key' => 'group_blog_post_settings',
        'title' => 'Configuración del Post',
        'fields' => array(
            
            // Hero Image Override
            array(
                'key' => 'field_blog_hero_image',
                'label' => 'Imagen Hero (Opcional)',
                'name' => 'blog_hero_image',
                'type' => 'image',
                'instructions' => 'Si deseas una imagen diferente a la imagen destacada para el hero del blog. Si está vacía, usará la imagen destacada.',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            
            // Featured in Category
            array(
                'key' => 'field_blog_featured',
                'label' => 'Post Destacado',
                'name' => 'blog_featured',
                'type' => 'true_false',
                'instructions' => 'Marcar este post como destacado en su categoría.',
                'required' => 0,
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Sí',
                'ui_off_text' => 'No',
            ),
            
            // CTA Button Text
            array(
                'key' => 'field_blog_cta_text',
                'label' => 'Texto del Botón CTA',
                'name' => 'blog_cta_text',
                'type' => 'text',
                'instructions' => 'Texto personalizado para el botón "Leer más". Si está vacío, usará "Seguir leyendo" por defecto.',
                'required' => 0,
                'default_value' => 'Seguir leyendo',
                'placeholder' => 'Seguir leyendo',
            ),
            
            // Custom Excerpt
            array(
                'key' => 'field_blog_excerpt_custom',
                'label' => 'Resumen Personalizado',
                'name' => 'blog_excerpt_custom',
                'type' => 'textarea',
                'instructions' => 'Resumen personalizado para las tarjetas del blog. Si está vacío, usará el excerpt de WordPress.',
                'required' => 0,
                'rows' => 3,
                'new_lines' => 'br',
            ),
            
            // Display Order (for manual ordering)
            array(
                'key' => 'field_blog_display_order',
                'label' => 'Orden de Visualización',
                'name' => 'blog_display_order',
                'type' => 'number',
                'instructions' => 'Número para ordenar manualmente los posts. Menor número = aparece primero.',
                'required' => 0,
                'default_value' => 0,
                'min' => 0,
                'step' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'acemar_blog',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

    /**
     * Blog Archive Page Settings
     * Para configurar la página de archivo del blog
     */
    acf_add_local_field_group(array(
        'key' => 'group_blog_archive_settings',
        'title' => 'Configuración del Blog',
        'fields' => array(
            
            // Hero Section
            array(
                'key' => 'field_blog_archive_hero_tab',
                'label' => 'Hero Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            array(
                'key' => 'field_blog_archive_hero_image',
                'label' => 'Imagen de Fondo Hero',
                'name' => 'blog_archive_hero_image',
                'type' => 'image',
                'instructions' => 'Imagen de fondo para la sección hero del blog.',
                'required' => 0,
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),
            
            array(
                'key' => 'field_blog_archive_hero_title',
                'label' => 'Título Hero',
                'name' => 'blog_archive_hero_title',
                'type' => 'text',
                'instructions' => 'Título principal del hero. Por defecto: "BLOG"',
                'required' => 0,
                'default_value' => 'BLOG',
            ),
            
            // Category Display Settings
            array(
                'key' => 'field_blog_category_settings_tab',
                'label' => 'Configuración de Categorías',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            array(
                'key' => 'field_blog_posts_per_category',
                'label' => 'Posts por Categoría',
                'name' => 'blog_posts_per_category',
                'type' => 'number',
                'instructions' => 'Número de posts a mostrar por defecto en cada categoría.',
                'required' => 0,
                'default_value' => 4,
                'min' => 1,
                'max' => 12,
            ),
            
            array(
                'key' => 'field_blog_load_more_text',
                'label' => 'Texto "Ver más"',
                'name' => 'blog_load_more_text',
                'type' => 'text',
                'instructions' => 'Texto del botón "Ver más" en cada categoría.',
                'required' => 0,
                'default_value' => 'Ver más',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'blog-settings',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
}

/**
 * Create ACF Options Page for Blog Settings
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Configuración del Blog',
        'menu_title'    => 'Configuración Blog',
        'menu_slug'     => 'blog-settings',
        'capability'    => 'edit_posts',
        'parent_slug'   => 'edit.php?post_type=acemar_blog',
        'position'      => false,
        'icon_url'      => 'dashicons-admin-settings',
    ));
}

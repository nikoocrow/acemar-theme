<?php
/**
 * Custom Post Types - Acemar Theme
 * 
 * @package Acemar
 * @author GetReady
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Blog Custom Post Type
 */
function acemar_register_blog_post_type() {
    $labels = array(
        'name'                  => _x('Blog', 'Post Type General Name', 'acemar'),
        'singular_name'         => _x('Post de Blog', 'Post Type Singular Name', 'acemar'),
        'menu_name'             => __('Blog', 'acemar'),
        'name_admin_bar'        => __('Post de Blog', 'acemar'),
        'archives'              => __('Archivo de Blog', 'acemar'),
        'attributes'            => __('Atributos del Post', 'acemar'),
        'parent_item_colon'     => __('Post Padre:', 'acemar'),
        'all_items'             => __('Todos los Posts', 'acemar'),
        'add_new_item'          => __('Añadir Nuevo Post', 'acemar'),
        'add_new'               => __('Añadir Nuevo', 'acemar'),
        'new_item'              => __('Nuevo Post', 'acemar'),
        'edit_item'             => __('Editar Post', 'acemar'),
        'update_item'           => __('Actualizar Post', 'acemar'),
        'view_item'             => __('Ver Post', 'acemar'),
        'view_items'            => __('Ver Posts', 'acemar'),
        'search_items'          => __('Buscar Posts', 'acemar'),
        'not_found'             => __('No se encontraron posts', 'acemar'),
        'not_found_in_trash'    => __('No se encontraron posts en la papelera', 'acemar'),
        'featured_image'        => __('Imagen Destacada', 'acemar'),
        'set_featured_image'    => __('Establecer imagen destacada', 'acemar'),
        'remove_featured_image' => __('Remover imagen destacada', 'acemar'),
        'use_featured_image'    => __('Usar como imagen destacada', 'acemar'),
        'insert_into_item'      => __('Insertar en el post', 'acemar'),
        'uploaded_to_this_item' => __('Subido a este post', 'acemar'),
        'items_list'            => __('Lista de posts', 'acemar'),
        'items_list_navigation' => __('Navegación de lista de posts', 'acemar'),
        'filter_items_list'     => __('Filtrar lista de posts', 'acemar'),
    );

    $args = array(
        'label'                 => __('Post de Blog', 'acemar'),
        'description'           => __('Posts del blog de Acemar', 'acemar'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'revisions', 'custom-fields'),
        'taxonomies'            => array('blog_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-post',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Habilita Gutenberg
        'rewrite'               => array(
            'slug'              => 'blog',
            'with_front'        => false,
        ),
    );

    register_post_type('acemar_blog', $args);
}
add_action('init', 'acemar_register_blog_post_type', 0);

/**
 * Register Blog Categories Taxonomy
 */
function acemar_register_blog_taxonomy() {
    $labels = array(
        'name'                       => _x('Categorías', 'Taxonomy General Name', 'acemar'),
        'singular_name'              => _x('Categoría', 'Taxonomy Singular Name', 'acemar'),
        'menu_name'                  => __('Categorías', 'acemar'),
        'all_items'                  => __('Todas las Categorías', 'acemar'),
        'parent_item'                => __('Categoría Padre', 'acemar'),
        'parent_item_colon'          => __('Categoría Padre:', 'acemar'),
        'new_item_name'              => __('Nuevo Nombre de Categoría', 'acemar'),
        'add_new_item'               => __('Añadir Nueva Categoría', 'acemar'),
        'edit_item'                  => __('Editar Categoría', 'acemar'),
        'update_item'                => __('Actualizar Categoría', 'acemar'),
        'view_item'                  => __('Ver Categoría', 'acemar'),
        'separate_items_with_commas' => __('Separar categorías con comas', 'acemar'),
        'add_or_remove_items'        => __('Añadir o remover categorías', 'acemar'),
        'choose_from_most_used'      => __('Elegir de las más usadas', 'acemar'),
        'popular_items'              => __('Categorías Populares', 'acemar'),
        'search_items'               => __('Buscar Categorías', 'acemar'),
        'not_found'                  => __('No se encontraron categorías', 'acemar'),
        'no_terms'                   => __('Sin categorías', 'acemar'),
        'items_list'                 => __('Lista de categorías', 'acemar'),
        'items_list_navigation'      => __('Navegación de lista de categorías', 'acemar'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true, // Como categorías (no como tags)
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true, // Habilita en Gutenberg
        'rewrite'                    => array(
            'slug'                   => 'blog/categoria',
            'with_front'             => false,
            'hierarchical'           => true,
        ),
    );

    register_taxonomy('blog_category', array('acemar_blog'), $args);
}
add_action('init', 'acemar_register_blog_taxonomy', 0);

/**
 * Flush rewrite rules on theme activation
 */
function acemar_rewrite_flush() {
    acemar_register_blog_post_type();
    acemar_register_blog_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'acemar_rewrite_flush');

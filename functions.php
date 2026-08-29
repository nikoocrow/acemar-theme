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
// ACF DEPENDENCY CHECK
// ============================================================
function acemar_check_acf_dependency() {
    if ( ! class_exists('ACF') ) {
        // Aviso en el admin
        add_action( 'admin_notices', function() {
            $install_url = admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term');
            echo '<div class="notice notice-error">';
            echo '<p><strong>Acemar Theme requiere el plugin Advanced Custom Fields (ACF).</strong></p>';
            echo '<p>Sin ACF el tema no funcionará correctamente. Por favor, <a href="' . esc_url( $install_url ) . '">instala y activa ACF</a> desde los plugins.</p>';
            echo '</div>';
        });

        // Stubs para evitar errores fatales en el frontend
        if ( ! function_exists('get_field') ) {
            function get_field( $selector, $post_id = false ) { return null; }
        }
        if ( ! function_exists('the_field') ) {
            function the_field( $selector, $post_id = false ) { return; }
        }
        if ( ! function_exists('have_rows') ) {
            function have_rows( $selector, $post_id = false ) { return false; }
        }
        if ( ! function_exists('get_sub_field') ) {
            function get_sub_field( $selector ) { return null; }
        }

        return false;
    }
    return true;
}

// ============================================================
// AUTO-LOADER: orden explícito para garantizar dependencias
// ============================================================
require_once get_template_directory() . '/inc/footer-options.php';
require_once get_template_directory() . '/inc/theme-options.php';
if ( acemar_check_acf_dependency() ) {
    require_once get_template_directory() . '/inc/acf-fields.php';
}
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/block-alignment.php';

// ============================================================
// THEME SETUP
// ============================================================
function acemar_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('align-wide');
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
        'top_bar' => __('Top Bar Menu', 'acemar'),
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

    // JS del Header (menu toggle mobile) — se carga en todas las páginas
    wp_enqueue_script(
        'acemar-header-script',
        $uri . '/assets/js/header.js',
        array(),
        filemtime($dir . '/assets/js/header.js'),
        true
    );

    // JS del Top Bar
    wp_enqueue_script(
        'acemar-top-bar-script',
        $uri . '/assets/js/top-bar.js',
        array(),
        filemtime($dir . '/assets/js/top-bar.js'),
        true
    );

    // JS principal
    wp_enqueue_script(
        'acemar-main-script',
        $uri . '/assets/js/main.js',
        array('jquery'),
        filemtime($dir . '/assets/js/main.js'),
        true
    );

    // JS del Blog
    if (is_post_type_archive('acemar_blog') || is_singular('acemar_blog') || is_tax('blog_category')) {
        wp_enqueue_script(
            'acemar-blog-script',
            $uri . '/assets/js/blog.js',
            array('jquery'),
            filemtime($dir . '/assets/js/blog.js'),
            true
        );

        wp_localize_script('acemar-blog-script', 'acemarBlog', array(
            'ajaxUrl'      => admin_url('admin-ajax.php'),
            'nonce'        => wp_create_nonce('acemar_blog_nonce'),
            'loadMoreText' => get_theme_mod('blog_load_more_text', 'Ver más'),
        ));
    }

    // JS del Single Proyecto
    if ( is_singular('acemar_proyecto') ) {
        wp_enqueue_style(
            'splide-css',
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/css/splide.min.css',
            array(),
            '4.1.4'
        );
        wp_enqueue_script(
            'splide-js',
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js',
            array(),
            '4.1.4',
            true
        );
        wp_enqueue_script(
            'acemar-proyecto-script',
            $uri . '/assets/js/single-proyecto.js',
            array('splide-js'),
            filemtime($dir . '/assets/js/single-proyecto.js'),
            true
        );
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
// La sección "Blog" del Customizer vive ahora en inc/theme-options.php,
// dentro del panel "Opciones del Tema" junto al resto de ajustes globales.

// Forzar header transparente en single proyecto
add_filter('acf/load_value/name=estilo_de_header', function( $value, $post_id, $field ) {
    if ( is_singular('acemar_proyecto') ) {
        return 'transparent';
    }
    return $value;
}, 10, 3);

// ============================================================
// OPTIMIZACIÓN DE IMÁGENES AL SUBIR
// ============================================================
function acemar_optimize_uploaded_image( $file ) {
    if ( ! in_array( $file['type'], array( 'image/jpeg', 'image/png' ), true ) ) {
        return $file;
    }

    $max_width = 2000; // px — redimensiona si la imagen es más ancha
    $quality   = 82;   // 0-100, aplica a JPEG y PNG

    $editor = wp_get_image_editor( $file['file'] );

    if ( is_wp_error( $editor ) ) {
        return $file;
    }

    $size = $editor->get_size();

    if ( $size['width'] > $max_width ) {
        $editor->resize( $max_width, null, false );
    }

    $editor->set_quality( $quality );
    $editor->save( $file['file'] );

    return $file;
}
add_filter( 'wp_handle_upload', 'acemar_optimize_uploaded_image' );
// ============================================================
// MENÚ PRINCIPAL: partir las etiquetas en dos líneas
// ============================================================
// CSS no puede decidir dónde cortar un texto, así que el corte se resuelve
// acá insertando un <br>. Garantiza exactamente dos líneas (el CSS usa
// white-space: nowrap, así que no hay cortes adicionales) y permite que la
// caja del link mida exactamente la línea más larga, sin aire sobrante.
//
// Dos modos:
//   1. Manual  — un "|" en la etiqueta define el punto exacto de corte.
//                Ej: "PANELES ACUSTICOS | DOMUS®"
//   2. Automático — sin "|", corta en el punto que deja las dos líneas
//                más parejas en cantidad de caracteres.
//
// Sólo aplica al menú primario, primer nivel. Los items de una sola palabra
// quedan intactos.
function acemar_menu_split_title( $title, $item, $args, $depth ) {
    if ( 0 !== $depth ) {
        return $title;
    }

    if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
        return $title;
    }

    // El filtro 'the_title' ya corrió, así que la etiqueta puede traer
    // entidades (&amp;, &#174;). Se decodifican antes de partir y se vuelven
    // a escapar al final; sin esto, esc_html() escaparía dos veces.
    $clean = trim( html_entity_decode( wp_strip_all_tags( $title ), ENT_QUOTES, 'UTF-8' ) );

    if ( '' === $clean ) {
        return $title;
    }

    // Modo manual: el "|" manda
    if ( false !== strpos( $clean, '|' ) ) {
        $parts = array_map( 'trim', explode( '|', $clean, 2 ) );

        if ( '' === $parts[0] || '' === $parts[1] ) {
            return esc_html( str_replace( '|', '', $clean ) );
        }

        return esc_html( $parts[0] ) . '<br>' . esc_html( $parts[1] );
    }

    // Modo automático
    $words = preg_split( '/\s+/u', $clean, -1, PREG_SPLIT_NO_EMPTY );

    if ( ! is_array( $words ) || count( $words ) < 2 ) {
        return $title;
    }

    $total     = count( $words );
    $best      = 1;
    $best_diff = null;

    for ( $i = 1; $i < $total; $i++ ) {
        $first  = implode( ' ', array_slice( $words, 0, $i ) );
        $second = implode( ' ', array_slice( $words, $i ) );
        $diff   = abs( mb_strlen( $first ) - mb_strlen( $second ) );

        if ( null === $best_diff || $diff < $best_diff ) {
            $best_diff = $diff;
            $best      = $i;
        }
    }

    return esc_html( implode( ' ', array_slice( $words, 0, $best ) ) )
        . '<br>'
        . esc_html( implode( ' ', array_slice( $words, $best ) ) );
}
add_filter( 'nav_menu_item_title', 'acemar_menu_split_title', 10, 4 );

<?php
/**
 * Custom Post Types - Acemar Theme
 *
 * El blog ya no tiene CPT propio: `acemar_blog` se unificó con el post type
 * nativo `post` y la taxonomía `blog_category` con `category`. El archivo
 * lo sirve home.php sobre la "Página de entradas" (Ajustes > Lectura).
 *
 * Motivo del cambio: el CPT se registraba con rewrite slug 'blog' y
 * has_archive, lo que generaba la regla `blog/?$` como PRIMERA del array de
 * rewrites. Esa regla ganaba siempre sobre la página "Blog", así que borrar
 * la página no cambiaba nada en /blog/ — parecía un problema de caché.
 *
 * @package Acemar
 * @author GetReady
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Flush rewrite rules cuando se activa el plugin acemar-blocks
 * para que el CPT acemar_proyecto funcione correctamente
 */
add_action( 'init', function() {
    if ( function_exists( 'acemar_register_cpt_proyecto' ) ) {
        // El CPT ya está registrado por el plugin, solo flush si es necesario
        if ( ! get_option( 'acemar_proyecto_flushed' ) ) {
            flush_rewrite_rules();
            update_option( 'acemar_proyecto_flushed', true );
        }
    }
}, 99 );

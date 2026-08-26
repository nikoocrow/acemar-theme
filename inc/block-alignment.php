<?php
/**
 * Alineación de texto: las 4 opciones en la barra del bloque
 *
 * @package Acemar
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WordPress 7.1 resuelve la alineación de texto con el soporte de bloque
 * `typography.textAlign`: guarda el valor en `style.typography.textAlign` y
 * emite la clase `has-text-align-{valor}`.
 *
 * El problema es que la lista de valores está fijada a left|center|right dentro
 * del JS del editor, así que "justificar" no se puede añadir por configuración.
 *
 * La estrategia es:
 *   1. Ocultar el control nativo de 3 opciones (settings.typography.textAlign).
 *   2. Pintar uno propio con las 4, escribiendo en el MISMO atributo.
 *   3. Serializar únicamente `justify`, porque las otras tres las sigue
 *      escribiendo core (no se toca su soporte, solo se oculta su interfaz).
 *
 * Al no reimplementar la serialización de left/center/right, el contenido ya
 * publicado se sigue guardando exactamente igual y ningún bloque se invalida.
 */

// ============================================================
// 1. OCULTAR EL CONTROL NATIVO DE 3 OPCIONES
// ============================================================
/**
 * El filtro corre aunque el tema no tenga theme.json: en ese caso el resolver
 * parte de un array vacío y aplica el filtro igual.
 *
 * Esto solo apaga la interfaz. El soporte del bloque sigue activo, de modo que
 * core continúa aplicando la clase en el editor y al guardar.
 */
function acemar_disable_core_text_align_ui( $theme_json ) {
    return $theme_json->update_with(array(
        'version'  => WP_Theme_JSON::LATEST_SCHEMA,
        'settings' => array(
            'typography' => array(
                'textAlign' => false,
            ),
        ),
    ));
}
add_filter('wp_theme_json_data_theme', 'acemar_disable_core_text_align_ui');

// ============================================================
// 2. CONTROL PROPIO CON LAS 4 ALINEACIONES
// ============================================================
function acemar_enqueue_alignment_editor_assets() {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();
    $ruta = '/assets/js/editor-text-align.js';

    wp_enqueue_script(
        'acemar-editor-text-align',
        $uri . $ruta,
        array(
            'wp-blocks',
            'wp-block-editor',
            'wp-components',
            'wp-compose',
            'wp-element',
            'wp-hooks',
            'wp-i18n',
            'wp-primitives',
        ),
        filemtime($dir . $ruta),
        true
    );
}
add_action('enqueue_block_editor_assets', 'acemar_enqueue_alignment_editor_assets');

// ============================================================
// 3. CSS DE LA CLASE JUSTIFICADA
// ============================================================
/**
 * `enqueue_block_assets` corre tanto en el frontend como dentro del iframe del
 * editor, así que una sola regla cubre los dos lados.
 *
 * `hyphens` evita los "ríos" de espacio típicos del texto justificado; depende
 * del atributo lang del <html>, que WordPress ya imprime.
 */
function acemar_text_align_justify_css() {
    wp_add_inline_style(
        'wp-block-library',
        '.has-text-align-justify{'
        . 'text-align:justify;'
        . 'text-justify:inter-word;'
        . '-webkit-hyphens:auto;'
        . 'hyphens:auto;'
        . '}'
    );
}
add_action('enqueue_block_assets', 'acemar_text_align_justify_css');

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

if (function_exists('acf_add_local_field_group')) {

    /**
     * Proyecto Settings
     */
    acf_add_local_field_group(array(
        'key'   => 'group_proyecto_settings',
        'title' => 'Datos del Proyecto',
        'fields' => array(
            array(
                'key'         => 'field_proyecto_dato_1',
                'label'       => 'Dato Relevante 1',
                'name'        => 'proyecto_dato_1',
                'type'        => 'text',
                'placeholder' => 'Ej: Área: 2.400 m²',
                'required'    => 0,
            ),
            array(
                'key'         => 'field_proyecto_dato_2',
                'label'       => 'Dato Relevante 2',
                'name'        => 'proyecto_dato_2',
                'type'        => 'text',
                'placeholder' => 'Ej: Ciudad: Bogotá',
                'required'    => 0,
            ),
            array(
                'key'         => 'field_proyecto_dato_3',
                'label'       => 'Dato Relevante 3',
                'name'        => 'proyecto_dato_3',
                'type'        => 'text',
                'placeholder' => 'Ej: Año: 2024',
                'required'    => 0,
            ),
            array(
                'key'         => 'field_proyecto_dato_4',
                'label'       => 'Dato Relevante 4',
                'name'        => 'proyecto_dato_4',
                'type'        => 'text',
                'placeholder' => 'Ej: Cliente: Gimnasio Bogotá',
                'required'    => 0,
            ),
            array(
                'key'         => 'field_proyecto_caso_titulo',
                'label'       => 'Caso de Éxito — Título',
                'name'        => 'proyecto_caso_titulo',
                'type'        => 'text',
                'placeholder' => 'Ej: Caso de Éxito',
                'required'    => 0,
            ),
            array(
                'key'         => 'field_proyecto_caso_subtitulo',
                'label'       => 'Caso de Éxito — Subtítulo',
                'name'        => 'proyecto_caso_subtitulo',
                'type'        => 'text',
                'placeholder' => 'Ej: Tipo de proyecto',
                'required'    => 0,
            ),
            array(
                'key'      => 'field_proyecto_caso_texto',
                'label'    => 'Caso de Éxito — Texto',
                'name'     => 'proyecto_caso_texto',
                'type'     => 'textarea',
                'rows'     => 5,
                'required' => 0,
            ),
            array(
                'key'           => 'field_proyecto_caso_imagen',
                'label'         => 'Caso de Éxito — Imagen',
                'name'          => 'proyecto_caso_imagen',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'required'      => 0,
            ),
            array(
                'key'           => 'field_proyecto_imagen_1',
                'label'         => 'Imagen Galería 1',
                'name'          => 'proyecto_galeria_1',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_proyecto_imagen_2',
                'label'         => 'Imagen Galería 2',
                'name'          => 'proyecto_galeria_2',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_proyecto_imagen_3',
                'label'         => 'Imagen Galería 3',
                'name'          => 'proyecto_galeria_3',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_proyecto_imagen_4',
                'label'         => 'Imagen Galería 4',
                'name'          => 'proyecto_galeria_4',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_proyecto_imagen_5',
                'label'         => 'Imagen Galería 5',
                'name'          => 'proyecto_galeria_5',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_proyecto_imagen_6',
                'label'         => 'Imagen Galería 6',
                'name'          => 'proyecto_galeria_6',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_proyecto_imagen_7',
                'label'         => 'Imagen Galería 7',
                'name'          => 'proyecto_galeria_7',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_proyecto_imagen_8',
                'label'         => 'Imagen Galería 8',
                'name'          => 'proyecto_galeria_8',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_proyecto_imagen_9',
                'label'         => 'Imagen Galería 9',
                'name'          => 'proyecto_galeria_9',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_proyecto_imagen_10',
                'label'         => 'Imagen Galería 10',
                'name'          => 'proyecto_galeria_10',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
        ),
        'location' => array(array(array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'acemar_proyecto',
        ))),
        'position' => 'normal',
        'active'   => true,
    ));

    /**
     * Blog Post Settings
     */
    acf_add_local_field_group(array(
        'key'   => 'group_blog_post_settings',
        'title' => 'Configuración del Post',
        'fields' => array(
            array(
                'key'           => 'field_blog_hero_image',
                'label'         => 'Imagen Hero (Opcional)',
                'name'          => 'blog_hero_image',
                'type'          => 'image',
                'instructions'  => 'Si deseas una imagen diferente a la imagen destacada para el hero del blog.',
                'required'      => 0,
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'library'       => 'all',
            ),
            array(
                'key'           => 'field_blog_featured',
                'label'         => 'Post Destacado',
                'name'          => 'blog_featured',
                'type'          => 'true_false',
                'required'      => 0,
                'default_value' => 0,
                'ui'            => 1,
                'ui_on_text'    => 'Sí',
                'ui_off_text'   => 'No',
            ),
            array(
                'key'           => 'field_blog_cta_text',
                'label'         => 'Texto del Botón CTA',
                'name'          => 'blog_cta_text',
                'type'          => 'text',
                'required'      => 0,
                'default_value' => 'Seguir leyendo',
                'placeholder'   => 'Seguir leyendo',
            ),
            array(
                'key'       => 'field_blog_excerpt_custom',
                'label'     => 'Resumen Personalizado',
                'name'      => 'blog_excerpt_custom',
                'type'      => 'textarea',
                'required'  => 0,
                'rows'      => 3,
                'new_lines' => 'br',
            ),
            array(
                'key'           => 'field_blog_display_order',
                'label'         => 'Orden de Visualización',
                'name'          => 'blog_display_order',
                'type'          => 'number',
                'required'      => 0,
                'default_value' => 0,
                'min'           => 0,
                'step'          => 1,
            ),
        ),
        'location' => array(array(array(
            'param'    => 'post_type',
            'operator' => '==',
            'value'    => 'acemar_blog',
        ))),
        'menu_order' => 0,
        'position'   => 'side',
        'style'      => 'default',
        'active'     => true,
    ));
}

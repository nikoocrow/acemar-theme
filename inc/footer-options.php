<?php
/**
 * Footer Customizer Options & Helper Functions
 *
 * @package Acemar
 * @author GetReady
 */

if (!defined('ABSPATH')) exit;

// ============================================================
// 1. REGISTRAR MENÚS DE FOOTER
// ============================================================
add_action('after_setup_theme', function () {
    register_nav_menus(array(
        'footer-col-1' => __('Footer - Acemar', 'acemar'),
        'footer-col-2' => __('Footer - Información Legal', 'acemar'),
        'footer-col-3' => __('Footer - Centro de Descargas', 'acemar'),
    ));
});

// ============================================================
// 2. CUSTOMIZER
// ============================================================
add_action('customize_register', function (WP_Customize_Manager $wp_customize) {

    $wp_customize->add_section('acemar_footer', array(
        'title'    => __('Footer', 'acemar'),
        'priority' => 100,
    ));

    $wp_customize->add_setting('acemar_footer_logo_img', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'acemar_footer_logo_img', array(
        'label'       => __('Logo del footer', 'acemar'),
        'description' => __('Sube el logo en SVG o PNG.', 'acemar'),
        'section'     => 'acemar_footer',
    )));

    $wp_customize->add_setting('acemar_footer_siguenos_text', array(
        'default'           => 'Síguenos',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('acemar_footer_siguenos_text', array(
        'label'   => __('Texto "Síguenos"', 'acemar'),
        'type'    => 'text',
        'section' => 'acemar_footer',
    ));

    $wp_customize->add_setting('acemar_footer_copyright', array(
        'default'           => '© ' . date('Y') . ' Acemar. Todos los derechos reservados.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('acemar_footer_copyright', array(
        'label'   => __('Texto de copyright', 'acemar'),
        'type'    => 'text',
        'section' => 'acemar_footer',
    ));

    // Redes Sociales
    $wp_customize->add_section('acemar_footer_social', array(
        'title'    => __('Footer – Redes Sociales', 'acemar'),
        'priority' => 101,
    ));

    $social_networks = array(
        'facebook'  => 'Facebook',
        'instagram' => 'Instagram',
        'pinterest' => 'Pinterest',
        'tiktok'    => 'TikTok',
        'youtube'   => 'YouTube',
        'whatsapp'  => 'WhatsApp',
        'linkedin'  => 'LinkedIn',
    );

    foreach ($social_networks as $key => $label) {
        $wp_customize->add_setting('acemar_social_' . $key . '_url', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control('acemar_social_' . $key . '_url', array(
            'label'   => $label . ' – URL',
            'type'    => 'url',
            'section' => 'acemar_footer_social',
        ));

        $wp_customize->add_setting('acemar_social_' . $key . '_icon', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'acemar_social_' . $key . '_icon', array(
            'label'       => $label . ' – Ícono SVG',
            'description' => __('Sube un SVG. Se cargará inline para heredar el color amarillo del CSS.', 'acemar'),
            'section'     => 'acemar_footer_social',
        )));
    }

    // Títulos columnas
    $wp_customize->add_section('acemar_footer_menus', array(
        'title'    => __('Footer – Títulos de menús', 'acemar'),
        'priority' => 102,
    ));

    $col_defaults = array(
        'acemar_footer_col1_title' => 'Acemar',
        'acemar_footer_col2_title' => 'Información Legal',
        'acemar_footer_col3_title' => 'Centro de Descargas',
    );

    foreach ($col_defaults as $setting_id => $default) {
        $wp_customize->add_setting($setting_id, array(
            'default'           => $default,
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control($setting_id, array(
            'label'   => sprintf(__('Título: %s', 'acemar'), $default),
            'type'    => 'text',
            'section' => 'acemar_footer_menus',
        ));
    }
});

// ============================================================
// 3. HELPER: renderizar SVG inline desde URL
// ============================================================
function acemar_render_svg_or_img($url, $alt = '', $class = '') {
    if (empty($url)) return '';

    $class_attr = $class ? ' class="' . esc_attr($class) . '"' : '';
    $is_svg     = (strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION)) === 'svg');

    if ($is_svg) {
        $file_path = acemar_url_to_path($url);

        if ($file_path && file_exists($file_path)) {
            $svg_content = file_get_contents($file_path);

            // Usar DOMDocument — maneja cualquier formato de atributos
            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadXML($svg_content);
            libxml_clear_errors();

            $svg_el = $dom->getElementsByTagName('svg')->item(0);

            if ($svg_el) {
                // Forzar dimensiones según contexto (logo vs ícono)
                if ($class === 'footer-logo__img') {
                    $svg_el->setAttribute('width', 'auto');
                    $svg_el->setAttribute('height', '50');
                    $svg_el->setAttribute('style', 'height:50px;width:auto;max-width:200px;display:block;');
                } else {
                    $svg_el->setAttribute('width', '24');
                    $svg_el->setAttribute('height', '24');
                    $svg_el->setAttribute('style', 'width:24px;height:24px;display:block;');
                }

                $svg_el->setAttribute('aria-hidden', 'true');
                if ($class) {
                    $svg_el->setAttribute('class', esc_attr($class));
                }

                return $dom->saveXML($svg_el);
            }
        }
    }

    // Fallback: <img> normal
    return '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"' . $class_attr . '>';
}

// ============================================================
// 4. HELPER: convertir URL de uploads a path del servidor
// ============================================================
function acemar_url_to_path($url) {
    $upload_dir = wp_upload_dir();

    if (strpos($url, $upload_dir['baseurl']) === 0) {
        return str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $url);
    }

    $theme_url = get_template_directory_uri();
    $theme_dir = get_template_directory();

    if (strpos($url, $theme_url) === 0) {
        return str_replace($theme_url, $theme_dir, $url);
    }

    return false;
}

// ============================================================
// 5. SVGs POR DEFECTO (fallback si el admin no sube ícono)
// ============================================================
function acemar_get_social_svg($network) {
    $svgs = array(
        'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
        'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4" fill="#2F3131"/><circle cx="17.5" cy="6.5" r="1.2" fill="#2F3131"/></svg>',
        'pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12c0 4.24 2.65 7.86 6.39 9.29-.09-.78-.17-1.98.03-2.83.19-.77 1.26-5.33 1.26-5.33s-.32-.64-.32-1.59c0-1.49.87-2.6 1.94-2.6.92 0 1.36.69 1.36 1.51 0 .92-.59 2.3-.89 3.58-.25 1.07.53 1.94 1.58 1.94 1.9 0 3.17-2.44 3.17-5.33 0-2.19-1.47-3.84-4.13-3.84-3.01 0-4.89 2.25-4.89 4.77 0 .87.25 1.48.64 1.96.18.21.21.3.14.54-.05.17-.15.59-.2.76-.07.24-.27.33-.49.24-1.38-.56-2.02-2.08-2.02-3.78 0-2.8 2.36-6.17 7.04-6.17 3.77 0 6.26 2.74 6.26 5.68 0 3.9-2.16 6.82-5.33 6.82-1.07 0-2.07-.57-2.41-1.22l-.66 2.57c-.24.91-.88 2.06-1.31 2.75.99.3 2.03.47 3.12.47 5.52 0 10-4.48 10-10S17.52 2 12 2z"/></svg>',
        'tiktok'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.75a4.85 4.85 0 0 1-1.01-.06z"/></svg>',
        'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-1.95C18.88 4 12 4 12 4s-6.88 0-8.6.47A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.94 1.95C5.12 20 12 20 12 20s6.88 0 8.6-.47a2.78 2.78 0 0 0 1.94-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#2F3131"/></svg>',
        'whatsapp'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 2C6.48 2 2 6.48 2 12c0 1.85.5 3.58 1.37 5.07L2 22l5.1-1.34A9.93 9.93 0 0 0 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18a8 8 0 0 1-4.08-1.12l-.29-.17-3.02.79.81-2.95-.19-.3A8 8 0 1 1 12 20z"/></svg>',
        'linkedin'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
    );

    return isset($svgs[$network]) ? $svgs[$network] : '';
}
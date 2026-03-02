<?php
/**
 * The footer template file
 *
 * @package Acemar
 * @author GetReady
 */

$footer_logo    = get_theme_mod('acemar_footer_logo_img', '');
$siguenos_text  = get_theme_mod('acemar_footer_siguenos_text', __('Síguenos', 'acemar'));
$copyright_text = get_theme_mod('acemar_footer_copyright', '© ' . date('Y') . ' Acemar. Todos los derechos reservados.');

$social_networks = array(
    'facebook'  => 'Facebook',
    'instagram' => 'Instagram',
    'pinterest' => 'Pinterest',
    'tiktok'    => 'TikTok',
    'youtube'   => 'YouTube',
    'whatsapp'  => 'WhatsApp',
    'linkedin'  => 'LinkedIn',
);
?>

<footer id="colophon" class="site-footer">
    <div class="footer-container">

        <!-- TOP: Logo + Redes sociales -->
        <div class="footer-top">

            <div class="footer-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
                    <?php if ($footer_logo) : ?>
                        <?php echo acemar_render_svg_or_img($footer_logo, get_bloginfo('name'), 'footer-logo__img'); ?>
                    <?php else : ?>
                        <span class="footer-logo__text"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <div class="footer-social">
                <?php if ($siguenos_text) : ?>
                    <span class="footer-social__label"><?php echo esc_html($siguenos_text); ?></span>
                <?php endif; ?>

                <div class="footer-social__icons">
                    <?php foreach ($social_networks as $key => $label) :
                        $url       = get_theme_mod('acemar_social_' . $key . '_url', '');
                        $icon_url  = get_theme_mod('acemar_social_' . $key . '_icon', '');
                        if (!$url) continue;
                    ?>
                        <a href="<?php echo esc_url($url); ?>"
                           class="footer-social__link footer-social__link--<?php echo esc_attr($key); ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr($label); ?>">
                            <?php if ($icon_url) : ?>
                                <?php echo acemar_render_svg_or_img($icon_url, $label); ?>
                            <?php else : ?>
                                <?php echo acemar_get_social_svg($key); ?>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div><!-- .footer-top -->

        <!-- MENÚS -->
        <div class="footer-menus">
            <?php
            $footer_menus = array(
                'footer-col-1' => get_theme_mod('acemar_footer_col1_title', __('Acemar', 'acemar')),
                'footer-col-2' => get_theme_mod('acemar_footer_col2_title', __('Información Legal', 'acemar')),
                'footer-col-3' => get_theme_mod('acemar_footer_col3_title', __('Centro de Descargas', 'acemar')),
            );

            foreach ($footer_menus as $location => $title) :
                if (!has_nav_menu($location)) continue;
            ?>
                <div class="footer-menu-col">
                    <?php if ($title) : ?>
                        <h3 class="footer-menu-col__title"><?php echo esc_html($title); ?></h3>
                    <?php endif; ?>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => $location,
                        'container'      => false,
                        'menu_class'     => 'footer-menu-col__list',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>
            <?php endforeach; ?>
        </div><!-- .footer-menus -->

        <!-- COPYRIGHT -->
        <div class="footer-bottom">
            <p><?php echo wp_kses_post($copyright_text); ?></p>
        </div>

    </div><!-- .footer-container -->
</footer>

<?php wp_footer(); ?>
</body>
</html>



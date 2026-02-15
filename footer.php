<?php
/**
 * The footer template file
 *
 * @package Acemar
 * @author GetReady
 */
?>

<footer id="colophon" class="site-footer">
    <div class="container">
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Todos los derechos reservados.', 'acemar'); ?></p>
            <p><?php _e('Desarrollado por', 'acemar'); ?> <strong>GetReady</strong></p>
        </div>
        
        <?php if (has_nav_menu('footer')) : ?>
        <nav class="footer-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_id'        => 'footer-menu',
                'container'      => false,
            ));
            ?>
        </nav>
        <?php endif; ?>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
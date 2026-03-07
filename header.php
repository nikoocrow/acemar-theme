<?php
/**
 * The header template file
 *
 * @package Acemar
 * @author GetReady
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$header_style = get_field('estilo_de_header');
$header_class = 'site-header';

if ($header_style === 'transparent') {
    $header_class .= ' header-transparent';
} elseif ($header_style === 'minimal') {
    $header_class .= ' header-minimal';
}
?>

<header id="masthead" class="<?php echo esc_attr($header_class); ?>">
    <div class="header-inner">
        <div class="site-branding">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/imagenes/logo.svg" alt="<?php bloginfo('name'); ?>" class="logo-img">
            </a>
        </div>

        <!-- Botón hamburguesa (solo visible en mobile) -->
        <button class="menu-toggle" id="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Abrir menú', 'acemar'); ?>">
            <span class="menu-toggle__icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hamburger-icon" aria-hidden="true">
                    <path class="line line-1" stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5" />
                    <path class="line line-2" stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.75h16.5" />
                    <path class="line line-3" stroke-linecap="round" stroke-linejoin="round" d="M3.75 14.25h16.5" />
                    <path class="line line-4" stroke-linecap="round" stroke-linejoin="round" d="M3.75 18.75h16.5" />
                </svg>
            </span>
        </button>
        
        <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Menú principal', 'acemar'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'container'      => false,
            ));
            ?>
        </nav>
    </div>
</header>
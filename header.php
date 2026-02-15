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

// Solo usar el campo ACF
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
        
        <nav id="site-navigation" class="main-navigation">
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
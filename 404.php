<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Acemar
 */

get_header();
?>

<main id="primary" class="site-main">

  <section class="page-404">

    <div class="page-404__corners"></div>
    <div class="page-404__deco"></div>
    <span class="page-404__bg-number" aria-hidden="true">404</span>

    <div class="page-404__content">

      <span class="page-404__label"><?php esc_html_e( 'Error 404', 'acemar' ); ?></span>

      <h1 class="page-404__title">
        <?php esc_html_e( 'Página ', 'acemar' ); ?><em><?php esc_html_e( 'no encontrada', 'acemar' ); ?></em>
      </h1>

      <div class="page-404__divider"></div>

      <p class="page-404__text">
        <?php esc_html_e( 'La página que buscas no existe o ha sido movida. Regresa al inicio para continuar explorando nuestros productos y servicios.', 'acemar' ); ?>
      </p>

      <div class="page-404__actions">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
          <?php esc_html_e( 'Volver al inicio', 'acemar' ); ?>
        </a>
        <a href="<?php echo esc_url( home_url( '/proyectos/' ) ); ?>" class="btn btn-secondary">
          <?php esc_html_e( 'Ver proyectos', 'acemar' ); ?>
        </a>
      </div>

    </div>

  </section>

</main>

<?php
get_footer();
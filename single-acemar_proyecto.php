<?php
/**
 * Template: Single Proyecto
 * CPT: acemar_proyecto
 * @package Acemar
 */
get_header();

while ( have_posts() ) :
    the_post();

    $titulo      = get_the_title();
    $contenido   = get_the_content();
    $feature_img = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    $feature_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );

    $caso_titulo    = get_field( 'proyecto_caso_titulo' );
    $caso_subtitulo = get_field( 'proyecto_caso_subtitulo' );
    $caso_texto     = get_field( 'proyecto_caso_texto' );
    $caso_imagen    = get_field( 'proyecto_caso_imagen' );

    $dato_1  = get_field( 'proyecto_dato_1' );
    $dato_2  = get_field( 'proyecto_dato_2' );
    $dato_3  = get_field( 'proyecto_dato_3' );
    $dato_4  = get_field( 'proyecto_dato_4' );
   // Construir galería desde campos individuales
$galeria = [];
for ( $i = 1; $i <= 6; $i++ ) {
    $img = get_field( 'proyecto_galeria_' . $i );
    if ( $img ) {
        $galeria[] = $img;
    }
}

    $segmentos    = get_the_terms( get_the_ID(), 'acemar_segmento' );
    $usos         = get_the_terms( get_the_ID(), 'acemar_uso' );
    $tipos_madera = get_the_terms( get_the_ID(), 'acemar_tipo_madera' );

    $relacionados = [];
    if ( $segmentos && ! is_wp_error( $segmentos ) ) {
        $relacionados = get_posts( [
            'post_type'      => 'acemar_proyecto',
            'posts_per_page' => 2,
            'post__not_in'   => [ get_the_ID() ],
            'tax_query'      => [[
                'taxonomy' => 'acemar_segmento',
                'field'    => 'term_id',
                'terms'    => wp_list_pluck( $segmentos, 'term_id' ),
            ]],
        ] );
    }
?>

<!-- HERO -->
<section class="proyecto-hero" <?php if ( $feature_img ) : ?>style="background-image: url('<?php echo esc_url( $feature_img ); ?>')"<?php endif; ?>>
    <div class="proyecto-hero__overlay"></div>
    <div class="proyecto-hero__content">
        <h1 class="proyecto-hero__titulo"><?php echo esc_html( $titulo ); ?></h1>
    </div>
</section>

<!-- INFO -->
<section class="proyecto-info">
    <div class="proyecto-info__inner">

        <div class="proyecto-info__imagen">
            <?php if ( $feature_img ) : ?>
                <img src="<?php echo esc_url( $feature_img ); ?>" alt="<?php echo esc_attr( $feature_alt ?: $titulo ); ?>" loading="lazy" />
            <?php endif; ?>
        </div>

        <div class="proyecto-info__contenido">

            <?php if ( $dato_1 || $dato_2 || $dato_3 || $dato_4 ) : ?>
                <ul class="proyecto-info__datos">
                    <?php if ( $dato_1 ) : ?><li><?php echo esc_html( $dato_1 ); ?></li><?php endif; ?>
                    <?php if ( $dato_2 ) : ?><li><?php echo esc_html( $dato_2 ); ?></li><?php endif; ?>
                    <?php if ( $dato_3 ) : ?><li><?php echo esc_html( $dato_3 ); ?></li><?php endif; ?>
                    <?php if ( $dato_4 ) : ?><li><?php echo esc_html( $dato_4 ); ?></li><?php endif; ?>
                </ul>
            <?php endif; ?>

            <?php if ( $contenido ) : ?>
                <div class="proyecto-info__descripcion">
                    <?php echo wp_kses_post( $contenido ); ?>
                </div>
            <?php endif; ?>

            <div class="proyecto-info__tags">
                <?php if ( $segmentos && ! is_wp_error( $segmentos ) ) :
                    foreach ( $segmentos as $term ) : ?>
                        <span class="proyecto-tag"><?php echo esc_html( $term->name ); ?></span>
                <?php endforeach; endif; ?>
                <?php if ( $usos && ! is_wp_error( $usos ) ) :
                    foreach ( $usos as $term ) : ?>
                        <span class="proyecto-tag proyecto-tag--uso"><?php echo esc_html( $term->name ); ?></span>
                <?php endforeach; endif; ?>
                <?php if ( $tipos_madera && ! is_wp_error( $tipos_madera ) ) :
                    foreach ( $tipos_madera as $term ) : ?>
                        <span class="proyecto-tag proyecto-tag--madera"><?php echo esc_html( $term->name ); ?></span>
                <?php endforeach; endif; ?>
            </div>

        </div>
    </div>
</section>


<!-- CASO DE ÉXITO -->
<?php if ( $caso_titulo || $caso_texto ) : ?>
<section class="proyecto-caso">
    <div class="proyecto-caso__inner">

        <div class="proyecto-caso__contenido">
            <?php if ( $caso_titulo ) : ?>
                <h2 class="proyecto-caso__titulo"><?php echo esc_html( $caso_titulo ); ?></h2>
            <?php endif; ?>
            <?php if ( $caso_subtitulo ) : ?>
                <p class="proyecto-caso__subtitulo"><?php echo esc_html( $caso_subtitulo ); ?></p>
            <?php endif; ?>
            <?php if ( $caso_texto ) : ?>
                <div class="proyecto-caso__texto">
                    <?php echo wp_kses_post( nl2br( $caso_texto ) ); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( $caso_imagen ) : ?>
        <div class="proyecto-caso__imagen">
            <img
                src="<?php echo esc_url( $caso_imagen['sizes']['large'] ); ?>"
                alt="<?php echo esc_attr( $caso_imagen['alt'] ?: $titulo ); ?>"
                loading="lazy"
            />
        </div>
        <?php endif; ?>

    </div>
</section>
<?php endif; ?>



<!-- GALERÍA -->
<?php if ( $galeria ) : ?>
<section class="proyecto-galeria">
    <div class="proyecto-galeria__slider splide" id="proyecto-splide" aria-label="Galería del proyecto">
        <div class="splide__track">
            <ul class="splide__list">
                <?php foreach ( $galeria as $imagen ) : ?>
                    <li class="splide__slide">
                        <a href="<?php echo esc_url( $imagen['url'] ); ?>"
                           class="proyecto-galeria__lightbox-trigger"
                           data-src="<?php echo esc_url( $imagen['url'] ); ?>"
                           data-caption="<?php echo esc_attr( $imagen['caption'] ?: $titulo ); ?>">
                            <img src="<?php echo esc_url( $imagen['sizes']['large'] ); ?>"
                                 alt="<?php echo esc_attr( $imagen['alt'] ?: $titulo ); ?>"
                                 loading="lazy" />
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="splide__arrows proyecto-galeria__arrows">
            <button class="splide__arrow splide__arrow--prev proyecto-galeria__arrow" type="button" aria-label="Anterior">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <button class="splide__arrow splide__arrow--next proyecto-galeria__arrow" type="button" aria-label="Siguiente">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>
    </div>

    <!-- Lightbox -->
    <div class="proyecto-lightbox" id="proyecto-lightbox" role="dialog" aria-modal="true" hidden>
        <button class="proyecto-lightbox__close" id="lightbox-close" aria-label="Cerrar">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <button class="proyecto-lightbox__nav proyecto-lightbox__nav--prev" id="lightbox-prev" aria-label="Anterior">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <div class="proyecto-lightbox__content">
            <img src="" alt="" id="lightbox-img" />
            <p class="proyecto-lightbox__caption" id="lightbox-caption"></p>
        </div>
        <button class="proyecto-lightbox__nav proyecto-lightbox__nav--next" id="lightbox-next" aria-label="Siguiente">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <div class="proyecto-lightbox__backdrop" id="lightbox-backdrop"></div>
    </div>
</section>
<?php endif; ?>

<!-- RELACIONADOS -->
<?php if ( $relacionados ) : ?>
<section class="proyecto-relacionados">
    <div class="proyecto-relacionados__inner">
        <?php foreach ( $relacionados as $rel ) :
            $rel_img   = get_the_post_thumbnail_url( $rel->ID, 'large' );
            $rel_title = get_the_title( $rel );
            $rel_link  = get_permalink( $rel );
        ?>
            <article class="proyecto-relacionado-card">
                <a href="<?php echo esc_url( $rel_link ); ?>" class="proyecto-relacionado-card__link">
                    <?php if ( $rel_img ) : ?>
                        <img src="<?php echo esc_url( $rel_img ); ?>" alt="<?php echo esc_attr( $rel_title ); ?>" loading="lazy" class="proyecto-relacionado-card__img" />
                    <?php endif; ?>
                    <div class="proyecto-relacionado-card__overlay">
                        <span class="proyecto-relacionado-card__name"><?php echo esc_html( $rel_title ); ?></span>
                    </div>
                </a>
                <p class="proyecto-relacionado-card__label">Otro proyecto que podría interesarte</p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>
<?php get_footer(); ?>
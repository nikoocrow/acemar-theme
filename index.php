<?php
/**
 * The main template file
 *
 * @package Acemar
 * @author GetReady
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1><?php the_title(); ?></h1>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <p><?php _e('No se encontró contenido.', 'acemar'); ?></p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();

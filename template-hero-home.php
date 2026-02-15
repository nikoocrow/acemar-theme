template-hero-home.php<?php
/**
 * Template Name: Hero Home
 * Template Post Type: page
 * 
 * @package Acemar
 * @author GetReady
 */

get_header('hero');
?>

<main id="main-content" class="site-main hero-page">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php
get_footer();
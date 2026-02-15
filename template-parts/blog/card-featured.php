<?php
/**
 * Template part for featured blog card
 * Used in Publicaciones Destacadas section
 *
 * @package Acemar
 * @author GetReady
 */

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
$excerpt = get_field('blog_excerpt_custom') ?: get_the_excerpt();
?>

<article class="blog-card blog-card-featured">
    <a href="<?php the_permalink(); ?>" class="card-link">
        
        <div class="card-image-container">
            <div class="card-image" style="background-image: url('<?php echo esc_url($thumbnail); ?>');"></div>
        </div>
        
        <div class="card-content">
            <h3 class="card-title"><?php the_title(); ?></h3>
            
            <?php if ($excerpt) : ?>
                <p class="card-excerpt"><?php echo esc_html(wp_trim_words($excerpt, 25)); ?></p>
            <?php endif; ?>
        </div>
        
    </a>
</article>

<?php
/**
 * Template part for product blog card
 * Used in Productos section
 *
 * @package Acemar
 * @author GetReady
 */

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
$excerpt = get_field('blog_excerpt_custom') ?: get_the_excerpt();
?>

<article class="blog-card blog-card-product">
    <a href="<?php the_permalink(); ?>" class="card-link">
        
        <div class="card-image" style="background-image: url('<?php echo esc_url($thumbnail); ?>');">
            <!-- Sin overlay para productos -->
        </div>
        
        <div class="card-content">
            <h3 class="card-title"><?php echo esc_html(wp_trim_words(get_the_title(), 8)); ?></h3>
            
            <?php if ($excerpt) : ?>
                <p class="card-excerpt"><?php echo esc_html(wp_trim_words($excerpt, 15)); ?></p>
            <?php endif; ?>
        </div>
        
    </a>
</article>

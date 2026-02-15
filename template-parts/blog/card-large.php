<?php
/**
 * Template part for large blog card
 * Used in Inspirate section (left side)
 *
 * @package Acemar
 * @author GetReady
 */

$thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
$cta_text = get_field('blog_cta_text') ?: 'Seguir leyendo';
$excerpt = get_field('blog_excerpt_custom') ?: get_the_excerpt();
?>

<article class="blog-card blog-card-large">
    <a href="<?php the_permalink(); ?>" class="card-link">
        
        <div class="card-image" style="background-image: url('<?php echo esc_url($thumbnail); ?>');">
            <div class="card-overlay"></div>
        </div>
        
        <div class="card-content">
            <h3 class="card-title"><?php the_title(); ?></h3>
            
            <?php if ($excerpt) : ?>
                <p class="card-excerpt"><?php echo esc_html(wp_trim_words($excerpt, 20)); ?></p>
            <?php endif; ?>
            
            <span class="card-cta">
                <?php echo esc_html($cta_text); ?>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        </div>
        
    </a>
</article>

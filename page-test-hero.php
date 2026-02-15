<?php
/**
 * Template Name: Test Hero
 * 
 * @package Acemar
 * @author GetReady
 */

get_header();
?>

<div class="hero-test" style="
    height: 100vh;
    background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?w=1920');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
">
    <div style="text-align: center; background: rgba(0,0,0,0.5); padding: 3rem; border-radius: 10px; max-width: 800px;">
        <h1 style="color: white; font-size: 4rem; margin-bottom: 2rem;">PANELES ACÚSTICOS</h1>
        <h2 style="color: #F4C430; font-size: 2rem; margin-bottom: 2rem;">ORATORIO U. SABANA</h2>
        <a href="#" class="btn btn-primary btn-lg">Solicite su Muestra</a>
    </div>
</div>

<section style="padding: 4rem 2rem; max-width: 1200px; margin: 0 auto; background: white;">
    <h2>Nuestros Productos</h2>
    <p>Este es el contenido normal de la página después del hero.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    <?php the_content(); ?>
</section>

<?php
get_footer();
<?php
/**
 * Top Menu - Acemar Theme
 * Menú superior con ícono "i" y animación slide desde la derecha
 *
 * @package Acemar
 * @author GetReady
 */
?>

<div id="top-bar" class="top-bar">
    <!-- Ícono "i" — siempre visible, trigger del menú -->
<button class="top-bar__trigger" id="top-bar-trigger" aria-expanded="false" aria-controls="top-bar-nav" aria-label="<?php esc_attr_e('Abrir menú informativo', 'acemar'); ?>">
    <span class="top-bar__icon-wrap">
        <!-- Ícono "i" -->
        <svg class="icon-info" width="36" height="36" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="36" cy="26" r="22" fill="#FFCC00"/>
            <rect x="14" y="26" width="22" height="22" fill="#FFCC00"/>
            <text x="36" y="36" text-anchor="middle" font-family="Georgia, serif" font-style="italic" font-weight="bold" font-size="26" fill="#000000">i</text>
        </svg>
        <!-- Ícono X -->
        <svg class="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="26" height="26" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </span>
</button>

    <!-- Nav: se desliza desde la derecha en desktop, hacia abajo en mobile -->
    <nav id="top-bar-nav" class="top-bar__nav" aria-label="<?php esc_attr_e('Menú informativo', 'acemar'); ?>">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'top_bar',
            'menu_id'        => 'top-bar-menu',
            'container'      => false,
            'fallback_cb'    => false,
        ));
        ?>
    </nav>
</div>
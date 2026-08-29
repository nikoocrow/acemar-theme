/**
 * Customizer Preview - Acemar Theme
 * Actualiza en vivo las custom properties de la top bar mientras se
 * arrastran los sliders de opacidad, sin recargar el preview.
 */

(function (api) {
    'use strict';

    if (!api) return;

    function setOverlay(prop, percent) {
        const bar = document.getElementById('top-bar');
        if (!bar) return;

        const value = Math.max(0, Math.min(100, parseInt(percent, 10) || 0));
        bar.style.setProperty(prop, String(value / 100));
    }

    api('acemar_topbar_overlay', function (setting) {
        setting.bind(function (value) {
            setOverlay('--top-bar-overlay', value);
        });
    });

    api('acemar_topbar_overlay_scroll', function (setting) {
        setting.bind(function (value) {
            setOverlay('--top-bar-overlay-scroll', value);
        });
    });

})(window.wp && window.wp.customize);

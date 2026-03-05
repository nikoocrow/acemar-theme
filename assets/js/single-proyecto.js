document.addEventListener('DOMContentLoaded', () => {

    // SPLIDE
    const sliderEl = document.getElementById('proyecto-splide');
    if (sliderEl && typeof Splide !== 'undefined') {
        new Splide('#proyecto-splide', {
            type:        'loop',
            perPage:     3,
            perMove:     1,
            gap:         '14px',
            arrows:      true,
            pagination:  false,
            padding:     { left: '20px', right: '20px' },
            breakpoints: {
                900: { perPage: 2 },
                540: { perPage: 1, padding: { left: '16px', right: '16px' } },
            },
        }).mount();
    }

    // LIGHTBOX
    const lightbox   = document.getElementById('proyecto-lightbox');
    if (!lightbox) return;

    const lbImg      = document.getElementById('lightbox-img');
    const lbCaption  = document.getElementById('lightbox-caption');
    const lbClose    = document.getElementById('lightbox-close');
    const lbPrev     = document.getElementById('lightbox-prev');
    const lbNext     = document.getElementById('lightbox-next');
    const lbBackdrop = document.getElementById('lightbox-backdrop');
    const triggers   = Array.from(document.querySelectorAll('.proyecto-galeria__lightbox-trigger'));

    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        const t = triggers[index];
        lbImg.src             = t.dataset.src;
        lbImg.alt             = t.dataset.caption || '';
        lbCaption.textContent = t.dataset.caption || '';
        lightbox.hidden       = false;
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.hidden = true;
        lbImg.src = '';
        document.body.style.overflow = '';
    }

    function showPrev() { openLightbox((currentIndex - 1 + triggers.length) % triggers.length); }
    function showNext() { openLightbox((currentIndex + 1) % triggers.length); }

    triggers.forEach((t, i) => t.addEventListener('click', (e) => { e.preventDefault(); openLightbox(i); }));

    lbClose.addEventListener('click', closeLightbox);
    lbBackdrop.addEventListener('click', closeLightbox);
    lbPrev.addEventListener('click', showPrev);
    lbNext.addEventListener('click', showNext);

    document.addEventListener('keydown', (e) => {
        if (lightbox.hidden) return;
        if (e.key === 'Escape')     closeLightbox();
        if (e.key === 'ArrowLeft')  showPrev();
        if (e.key === 'ArrowRight') showNext();
    });

    // Swipe mobile
    let touchStartX = 0;
    lightbox.addEventListener('touchstart', (e) => { touchStartX = e.touches[0].clientX; }, { passive: true });
    lightbox.addEventListener('touchend',   (e) => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) diff > 0 ? showNext() : showPrev();
    });
});
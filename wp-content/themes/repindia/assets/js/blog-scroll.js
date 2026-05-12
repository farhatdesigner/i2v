(function() {
    'use strict';

    // Only run on newsroom detail pages
    if (!document.body.classList.contains('single-newsroom') && !document.querySelector('.post-type-newsroom')) {
        return;
    }

    const content = document.getElementById('blog-detail-content');
    const progressCircle = document.querySelector('.reading-progress .progress');
    const progressText = document.querySelector('.reading-progress .percentage');

    if (!content || !progressCircle || !progressText) {
        return;
    }

    let ticking = false;

    function updateProgress() {
        if (!content || !progressCircle || !progressText) {
            return;
        }

        const contentRect = content.getBoundingClientRect();
        const contentTop = contentRect.top + window.scrollY;
        const contentHeight = content.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollY = window.scrollY;

        // Calculate progress: 0% when content top reaches viewport, 100% when content bottom passes viewport top
        const scrollProgress = scrollY + windowHeight;
        const contentBottom = contentTop + contentHeight;
        
        let progress = 0;
        
        if (scrollProgress >= contentTop) {
            // Content has started
            const scrolled = scrollProgress - contentTop;
            const totalScrollable = contentHeight + windowHeight;
            progress = Math.min(100, Math.max(0, Math.round((scrolled / totalScrollable) * 100)));
        }

        progressCircle.style.strokeDasharray = `${progress},100`;
        progressText.textContent = progress + '%';
        
        ticking = false;
    }

    // Wait for DOM and Elementor to be ready
    function initScrollProgress() {
        // Wait a bit for Elementor content to render
        setTimeout(function() {
            updateProgress();
            
            // Use requestAnimationFrame for smooth updates
            function onScroll() {
                if (!ticking) {
                    window.requestAnimationFrame(updateProgress);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', updateProgress, { passive: true });
            
            // Initial calculation
            updateProgress();
        }, 100);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScrollProgress);
    } else {
        initScrollProgress();
    }

    // Also listen for Elementor frontend ready
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
            setTimeout(updateProgress, 50);
        });
    }
})();

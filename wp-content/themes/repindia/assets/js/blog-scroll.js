(function() {
    'use strict';

    // Only run on newsroom detail pages
    if (!document.body.classList.contains('single-newsroom') && !document.querySelector('.post-type-newsroom')) {
        return;
    }

    const progressCircle = document.querySelector('.reading-progress .progress');
    const progressText = document.querySelector('.reading-progress .percentage');

    if (!progressCircle || !progressText) {
        return;
    }

    /**
     * Article container candidates, ordered by specificity.
     * newsroom_detail_content is the Elementor section that wraps the article body
     * on single-newsroom templates (see single-newsroom.php sticky-social logic).
     */
    const ARTICLE_SELECTORS = [
        '.elementor-element.newsroom_detail_content',
        '#blog-detail-content',
        '.entry-content',
        '.newsroom-content',
    ];

    let articleContent = null;
    let useFullPageFallback = false;
    let ticking = false;

    // Cached layout metrics — refreshed on resize and before each progress update
    let metrics = {
        top: 0,
        height: 0,
    };

    /**
     * Find the article content container. Selectors are queried once per init/Elementor refresh.
     */
    function resolveArticleContainer() {
        for (let i = 0; i < ARTICLE_SELECTORS.length; i++) {
            const el = document.querySelector(ARTICLE_SELECTORS[i]);
            if (el) {
                return el;
            }
        }
        return null;
    }

    /**
     * Measure article bounds relative to the document.
     * Called outside the hot scroll path scheduling (inside rAF, max once per frame).
     */
    function refreshMetrics() {
        if (useFullPageFallback) {
            metrics.top = 0;
            metrics.height = document.documentElement.scrollHeight;
            return;
        }

        if (!articleContent) {
            return;
        }

        const rect = articleContent.getBoundingClientRect();
        metrics.top = rect.top + window.scrollY;
        metrics.height = articleContent.offsetHeight;
    }

    /**
     * Article-only progress (99designs-style):
     *   0%   — viewport bottom reaches the top of the article
     *   100% — viewport bottom reaches the bottom of the article
     */
    function calculateArticleProgress(scrollY, windowHeight) {
        const contentHeight = metrics.height;

        if (contentHeight <= 0) {
            return 0;
        }

        const contentTop = metrics.top;
        const contentBottom = contentTop + contentHeight;
        const viewportBottom = scrollY + windowHeight;

        if (viewportBottom <= contentTop) {
            return 0;
        }

        if (viewportBottom >= contentBottom) {
            return 100;
        }

        return Math.round(((viewportBottom - contentTop) / contentHeight) * 100);
    }

    /**
     * Legacy full-page fallback when no article container is found.
     */
    function calculateFullPageProgress(scrollY, windowHeight) {
        const scrollable = document.documentElement.scrollHeight - windowHeight;

        if (scrollable <= 0) {
            return 0;
        }

        return Math.min(100, Math.max(0, Math.round((scrollY / scrollable) * 100)));
    }

    function updateProgress() {
        refreshMetrics();

        const scrollY = window.scrollY;
        const windowHeight = window.innerHeight;
        const progress = useFullPageFallback
            ? calculateFullPageProgress(scrollY, windowHeight)
            : calculateArticleProgress(scrollY, windowHeight);

        progressCircle.style.strokeDasharray = progress + ',100';
        progressText.textContent = progress + '%';

        ticking = false;
    }

    function onScroll() {
        if (!ticking) {
            window.requestAnimationFrame(updateProgress);
            ticking = true;
        }
    }

    function onResize() {
        refreshMetrics();
        updateProgress();
    }

    function initScrollProgress() {
        articleContent = resolveArticleContainer();
        useFullPageFallback = !articleContent;

        refreshMetrics();

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onResize, { passive: true });

        updateProgress();
    }

    // Wait for DOM and Elementor to render article sections
    function delayedInit() {
        setTimeout(initScrollProgress, 100);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', delayedInit);
    } else {
        delayedInit();
    }

    // Re-resolve container after Elementor widgets finish rendering
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
            articleContent = resolveArticleContainer();
            useFullPageFallback = !articleContent;
            refreshMetrics();
            setTimeout(updateProgress, 50);
        });
    }
})();

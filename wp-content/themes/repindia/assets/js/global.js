
(function () {

    function getCookie(name) {
        const match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : null;
    }

    function setCookie(name, value, days) {
        let expires = '';
        if (typeof days === 'number') {
            const date = new Date();
            date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
            expires = '; expires=' + date.toUTCString();
        }
        document.cookie = name + '=' + encodeURIComponent(value) + expires + '; path=/';
    }

    // Apply saved theme immediately on parse (no flicker).
    // Note: `body` may not exist yet depending on script placement.
    (function applyInitialThemeFromCookie() {
        const saved = getCookie('site-theme');
        if (saved === 'dark') {
            document.documentElement.classList.add('js-dark');
        } else if (saved === 'light') {
            document.documentElement.classList.remove('js-dark');
        }
    })();

    function syncBodyThemeClass() {
        const isDark = document.documentElement.classList.contains('js-dark');
        if (!document.body) return;
        document.body.classList.toggle('js-dark', isDark);
    }

    function updateThemeImages() {
        const isDark = document.body.classList.contains('js-dark');

        document.querySelectorAll('.theme-img').forEach(wrapper => {
            const lightSrc = wrapper.getAttribute('data-light');
            const darkSrc  = wrapper.getAttribute('data-dark');

            if (!lightSrc || !darkSrc) return;

            wrapper.querySelectorAll('img').forEach(img => {
                const targetSrc = isDark ? darkSrc : lightSrc;

                if (img.src !== targetSrc) {
                    img.src = targetSrc;
                }
            });
        });
    }

    /* After DOM is stable */
    document.addEventListener('DOMContentLoaded', function () {
        syncBodyThemeClass();
        updateThemeImages();
    });

    /* Elementor dynamic support */
    document.addEventListener('elementor/frontend/init', updateThemeImages);

    /* Dark-mode toggle */
    document.querySelectorAll('.dark-mode-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const isDark = !document.documentElement.classList.contains('js-dark');
            document.documentElement.classList.toggle('js-dark', isDark);
            syncBodyThemeClass();

            setCookie('site-theme', isDark ? 'dark' : 'light', 365);
            updateThemeImages();
        });
    });

})();



// HERO SLIDER
jQuery(document).ready(function ($) {
    // Only initialize if the slider exists on the page
    if ($('.hero-swiper-container').length === 0) {
        return;
    }

    var slideCount = $('.hero-swiper-container .swiper-slide').length;
    var isSingleSlide = slideCount <= 1;

    var menu = [];
    $('.hero-swiper-container .swiper-slide').each(function (index) {
        menu.push($(this).find('.hero-slide-inner').attr("data-text"));
    });
    var interleaveOffset = 0.5;

    // Autoplay progress elements
    const progressCircle = document.querySelector(".hero-swiper-container .autoplay-progress svg .progress-circle");
    const progressContent = document.querySelector(".hero-swiper-container .autoplay-progress .progress-content");

    // Progress animation variables
    let progressInterval = null;

    // Function to start progress animation
    function startProgressAnimation() {
        // Clear any existing interval
        if (progressInterval) {
            clearInterval(progressInterval);
        }

        // Reset all pagination bullets - remove SVG and countdown from all
        const bullets = document.querySelectorAll('.hero-swiper-container .swiper-pagination-bullet');
        bullets.forEach(bullet => {
            // Remove SVG and countdown from inactive bullets
            const svg = bullet.querySelector('.bullet-progress-svg');
            const countdown = bullet.querySelector('.progress-countdown');
            if (svg) svg.remove();
            if (countdown) countdown.remove();
        });

        // Start progress for active bullet
        const activeBullet = document.querySelector('.hero-swiper-container .swiper-pagination-bullet-active');
        if (activeBullet) {
            // Add SVG progress circle to active bullet
            const svgElement = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svgElement.setAttribute('class', 'bullet-progress-svg');
            svgElement.setAttribute('viewBox', '0 0 36 36');

            const bgCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            bgCircle.setAttribute('cx', '18');
            bgCircle.setAttribute('cy', '18');
            bgCircle.setAttribute('r', '16');
            bgCircle.setAttribute('class', 'bullet-circle-bg');

            const progressCircle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            progressCircle.setAttribute('cx', '18');
            progressCircle.setAttribute('cy', '18');
            progressCircle.setAttribute('r', '16');
            progressCircle.setAttribute('class', 'bullet-circle-progress');

            svgElement.appendChild(bgCircle);
            svgElement.appendChild(progressCircle);
            activeBullet.appendChild(svgElement);

            // Add countdown number to active bullet
            const countdownElement = document.createElement('span');
            countdownElement.className = 'progress-countdown';
            activeBullet.appendChild(countdownElement);

            let timeLeft = 6.5;
            const progressCircleBullet = activeBullet.querySelector('.bullet-circle-progress');

            progressInterval = setInterval(() => {
                timeLeft -= 0.1;
                const progress = (6.5 - timeLeft) / 6.5;

                // Update countdown number - ensure it never shows 0, minimum is 1
                const displayNumber = Math.max(1, Math.ceil(timeLeft));
                countdownElement.textContent = `${displayNumber}`;

                // Update progress stroke
                if (progressCircleBullet) {
                    progressCircleBullet.style.setProperty('--progress', progress);
                }

                if (timeLeft <= 0) {
                    clearInterval(progressInterval);
                }
            }, 100);
        }

        // Also update circular progress if it exists
        if (progressCircle && progressContent) {
            let timeLeft = 6.5; // 6.5 seconds
            progressCircle.style.setProperty("--progress", 0);
            progressContent.textContent = `${Math.ceil(timeLeft)}`;

            const circularInterval = setInterval(() => {
                timeLeft -= 0.1;
                const progress = (6.5 - timeLeft) / 6.5;
                progressCircle.style.setProperty("--progress", progress);
                // Update countdown number - ensure it never shows 0, minimum is 1
                const displayNumber = Math.max(1, Math.ceil(timeLeft));
                progressContent.textContent = `${displayNumber}`;

                if (timeLeft <= 0) {
                    clearInterval(circularInterval);
                }
            }, 100);
        }
    }

    var swiperOptions = {
        loop: !isSingleSlide,
        speed: 1000,
        parallax: true,
        allowTouchMove: !isSingleSlide,
        autoplay: isSingleSlide ? false : {
            delay: 6500,
            disableOnInteraction: false,
        },
        watchSlidesProgress: true,
        pagination: isSingleSlide ? false : {
            el: '.hero-swiper-container .swiper-pagination',
            clickable: true,
        },
        navigation: isSingleSlide ? false : {
            nextEl: '.hero-swiper-container .swiper-button-next',
            prevEl: '.hero-swiper-container .swiper-button-prev',
        },
        on: {
            progress: function () {
                if (isSingleSlide) return;
                var swiper = this;
                for (var i = 0; i < swiper.slides.length; i++) {
                    var slideProgress = swiper.slides[i].progress;
                    var innerOffset = swiper.width * interleaveOffset;
                    var innerTranslate = slideProgress * innerOffset;
                    var inner = swiper.slides[i].querySelector(".hero-slide-inner");
                    if (inner) inner.style.transform = "translate3d(" + innerTranslate + "px, 0, 0)";
                }
            },

            touchStart: function () {
                if (isSingleSlide) return;
                var swiper = this;
                for (var i = 0; i < swiper.slides.length; i++) {
                    swiper.slides[i].style.transition = "";
                }
            },

            setTransition: function (speed) {
                if (isSingleSlide) return;
                var swiper = this;
                for (var i = 0; i < swiper.slides.length; i++) {
                    swiper.slides[i].style.transition = speed + "ms";
                    var inner = swiper.slides[i].querySelector(".hero-slide-inner");
                    if (inner) inner.style.transition = speed + "ms";
                }
            },

            autoplayStart: function () {
                if (!isSingleSlide) startProgressAnimation();
            },

            slideChange: function () {
                if (!isSingleSlide) startProgressAnimation();
            },

            init: function () {
                if (!isSingleSlide) startProgressAnimation();
            }
        }
    };

    // Hero video iframes: size from wrapper box (16:9 cover). Pure CSS vw/vh does not match .hero-slider height.
    var heroVideoEmbedResizeBound = false;

    function resizeHeroVideoEmbeds() {
        document.querySelectorAll('.hero-slider .slide-video-white, .hero-slider .slide-video-dark').forEach(function (wrap) {
            var iframe = wrap.querySelector('iframe');
            if (!iframe) return;
            var w = wrap.clientWidth;
            var h = wrap.clientHeight;
            if (!w || !h) return;
            var s = Math.max(w / 16, h / 9);
            iframe.style.width = (16 * s) + 'px';
            iframe.style.height = (9 * s) + 'px';
        });
    }

    function bindHeroVideoEmbedResize() {
        resizeHeroVideoEmbeds();
        if (heroVideoEmbedResizeBound) return;
        heroVideoEmbedResizeBound = true;
        var schedule = function () {
            resizeHeroVideoEmbeds();
        };
        window.addEventListener('resize', schedule);
        window.addEventListener('orientationchange', function () {
            setTimeout(schedule, 200);
            setTimeout(schedule, 500);
        });
        if (typeof ResizeObserver !== 'undefined') {
            var ro = new ResizeObserver(schedule);
            document.querySelectorAll('.hero-slider .slide-video-white, .hero-slider .slide-video-dark').forEach(function (el) {
                ro.observe(el);
            });
            var heroRoot = document.querySelector('.sectionshomebanner .hero-slider');
            if (heroRoot) ro.observe(heroRoot);
        }
    }

    // Use Swiper 4.5.1 reference to avoid Elementor's Swiper 8 conflict
    // window.SwiperV4 is saved before Elementor loads its Swiper 8
    // Wait for Swiper to be available before initializing
    function initHeroSwiper() {
        var container = document.querySelector('.hero-swiper-container');
        if (!container) return;
        
        // Check if already initialized
        if (container.swiper) return;
        
        var SwiperConstructor = (typeof window.SwiperV4 !== 'undefined') ? window.SwiperV4 : (typeof Swiper !== 'undefined' ? Swiper : null);
        if (SwiperConstructor) {
            var swiper = new SwiperConstructor(".hero-swiper-container", swiperOptions);
            bindHeroVideoEmbedResize();
            setTimeout(resizeHeroVideoEmbeds, 50);
            setTimeout(resizeHeroVideoEmbeds, 400);
        } else {
            // Retry after a short delay if Swiper not loaded yet
            setTimeout(initHeroSwiper, 100);
        }
    }
    
    // Initialize immediately or wait for Swiper
    if (typeof Swiper !== 'undefined' || typeof window.SwiperV4 !== 'undefined') {
        initHeroSwiper();
    } else {
        // Wait for Swiper to load
        setTimeout(initHeroSwiper, 100);
    }

    // DATA BACKGROUND IMAGE
    var sliderBgSetting = $(".hero-swiper-container .slide-bg-image");
    sliderBgSetting.each(function (indx) {
        if ($(this).attr("data-background")) {
            $(this).css("background-image", "url(" + $(this).data("background") + ")");
        }
    });
});

// side menu js

$(document).ready(function () {
    var scrollPosition = 0;
    var isMenuOpen = false;
    var modalScrollPosition = 0;
    var brochureModalScrollPosition = 0;

    // Single debounced run after any modal/menu close: re-create cards + gallery + hz-slider ScrollTriggers so layout is correct (fixes popup-close distortion for careers-list and industry details)
    window.scheduleCardsRefreshAfterModalClose = function () {
        if (window._cardsModalRefreshTimer) clearTimeout(window._cardsModalRefreshTimer);
        window._cardsModalRefreshTimer = setTimeout(function () {
            window._cardsModalRefreshTimer = null;
            if (typeof initCardsCustomBodyGSAP === "function") {
                initCardsCustomBodyGSAP();
            }
            if (typeof initGalleryGSAP === "function") {
                initGalleryGSAP();
            }
            // Re-init horizontal sliders (hz-slider-section, hz-slider-topcaption) so layout is correct after menu/modal close
            if (typeof window.reinitHzSliderSectionGSAP === "function") {
                window.reinitHzSliderSectionGSAP();
            }
            if (typeof window.reinitHzSliderTopcaptionGSAP === "function") {
                window.reinitHzSliderTopcaptionGSAP();
            }
            if (typeof window.reinitHzSliderEnergyGSAP === "function") {
                window.reinitHzSliderEnergyGSAP();
            }
            if (typeof ScrollTrigger !== "undefined") {
                requestAnimationFrame(function () {
                    ScrollTrigger.refresh();
                    var gallerySections = document.querySelectorAll(".makdmks .detailsWrapper .details");
                    var galleryPhotos = document.querySelectorAll(".makdmks .photo");
                    if (gallerySections.length && galleryPhotos.length && typeof gsap !== "undefined") {
                        var photoIndex = 0;
                        for (var i = 0; i < gallerySections.length; i++) {
                            var st = ScrollTrigger.getById("gallery-section-" + i);
                            if (st && st.progress >= 0 && st.progress <= 1) {
                                photoIndex = i;
                                break;
                            }
                        }
                        gsap.set(galleryPhotos, { opacity: 0 });
                        gsap.set(galleryPhotos[photoIndex], { opacity: 1 });
                    }
                    // Sync horizontal sliders to current scroll position after reinit
                    if (typeof window.syncHzSliderSectionToScroll === "function") {
                        window.syncHzSliderSectionToScroll();
                    }
                    if (typeof window.syncHzSliderTopcaptionToScroll === "function") {
                        window.syncHzSliderTopcaptionToScroll();
                    }
                    if (typeof window.syncHzSliderEnergyToScroll === "function") {
                        window.syncHzSliderEnergyToScroll();
                    }
                    // Re-apply scroll after GSAP refresh (next tick) so layout and scroll stay in sync when modal scroll came from body.style.top e.g. hamburger open
                    if (window._modalRestoreScrollPosition != null) {
                        var pos = Math.max(0, Math.round(window._modalRestoreScrollPosition));
                        window._modalRestoreScrollPosition = null;
                        setTimeout(function () {
                            window.scrollTo(0, pos);
                            document.documentElement.scrollTop = pos;
                            document.body.scrollTop = pos;
                        }, 0);
                    }
                });
            } else if (window._modalRestoreScrollPosition != null) {
                window._modalRestoreScrollPosition = null;
            }
        }, 350);
    };

    // Helper function to get scrollbar width
    function getScrollbarWidth() {
        // Create a temporary div to measure scrollbar width
        var outer = document.createElement('div');
        outer.style.visibility = 'hidden';
        outer.style.overflow = 'scroll';
        outer.style.msOverflowStyle = 'scrollbar'; // needed for IE
        document.body.appendChild(outer);
        
        var inner = document.createElement('div');
        outer.appendChild(inner);
        
        var scrollbarWidth = outer.offsetWidth - inner.offsetWidth;
        
        outer.parentNode.removeChild(outer);
        return scrollbarWidth;
    }

    // Prevent body scroll when menu is open
    function preventBodyScroll(e) {
        // Allow scrolling inside the menu container
        var $target = $(e.target);
        if ($target.closest(".toggle-menu-container").length) {
            return true;
        }
        // Prevent scrolling on body/overlay
        e.preventDefault();
        e.stopPropagation();
        return false;
    }

    // Prevent wheel events on body when menu is open
    function preventBodyWheel(e) {
        // Get mouse position
        var mouseX = e.clientX || (e.originalEvent && e.originalEvent.clientX) || 0;
        var mouseY = e.clientY || (e.originalEvent && e.originalEvent.clientY) || 0;
        
        // Get the element at mouse position (most reliable method)
        var elementAtPoint = null;
        if (document.elementFromPoint && mouseX > 0 && mouseY > 0) {
            try {
                elementAtPoint = document.elementFromPoint(mouseX, mouseY);
            } catch (err) {
                // Fallback if elementFromPoint fails
            }
        }
        
        // Check if element at mouse position is inside menu
        if (elementAtPoint) {
            var $elementAtPoint = $(elementAtPoint);
            if ($elementAtPoint.closest(".toggle-menu-container").length) {
                return; // Allow scrolling - don't prevent
            }
        }
        
        // Also check event target
        var $target = $(e.target);
        if ($target.closest(".toggle-menu-container").length) {
            return; // Allow scrolling - don't prevent
        }
        
        // Check mouse position relative to menu container (fallback)
        var $menuContainer = $(".toggle-menu-container");
        if ($menuContainer.length && $menuContainer.hasClass("open-menu") && mouseX > 0 && mouseY > 0) {
            var menuOffset = $menuContainer.offset();
            if (menuOffset) {
                var menuWidth = $menuContainer.outerWidth();
                var menuHeight = $menuContainer.outerHeight();
                
                if (mouseX >= menuOffset.left && 
                    mouseX <= menuOffset.left + menuWidth &&
                    mouseY >= menuOffset.top && 
                    mouseY <= menuOffset.top + menuHeight) {
                    return; // Allow scrolling - don't prevent
                }
            }
        }
        
        // Prevent wheel on body/overlay (outside menu)
        e.preventDefault();
        e.stopPropagation();
        return false;
    }

    // Prevent body scroll when formpopup_modal is open (similar to side menu)
    function preventModalBodyScroll(e) {
        // Allow scrolling inside the modal content
        var $target = $(e.target);
        if ($target.closest(".formpopup_modal .modal-content, .formpopup_modal .modal-body").length) {
            return true;
        }
        // Prevent scrolling on body/overlay
        e.preventDefault();
        e.stopPropagation();
        return false;
    }

    // Prevent wheel events on body when modal is open
    function preventModalBodyWheel(e) {
        // Get mouse position
        var mouseX = e.clientX || (e.originalEvent && e.originalEvent.clientX) || 0;
        var mouseY = e.clientY || (e.originalEvent && e.originalEvent.clientY) || 0;

        // Get the element at mouse position (most reliable method)
        var elementAtPoint = null;
        if (document.elementFromPoint && mouseX > 0 && mouseY > 0) {
            try {
                elementAtPoint = document.elementFromPoint(mouseX, mouseY);
            } catch (err) {
                // Fallback if elementFromPoint fails
            }
        }

        // Check if element at mouse position is inside modal content
        if (elementAtPoint) {
            var $elementAtPoint = $(elementAtPoint);
            if ($elementAtPoint.closest(".formpopup_modal .modal-content, .formpopup_modal .modal-body").length) {
                return; // Allow scrolling - don't prevent
            }
        }

        // Also check event target
        var $target = $(e.target);
        if ($target.closest(".formpopup_modal .modal-content, .formpopup_modal .modal-body").length) {
            return; // Allow scrolling - don't prevent
        }

        // Check mouse position relative to modal content (fallback)
        var $modalContent = $(".formpopup_modal .modal-content");
        if ($modalContent.length && $(".formpopup_modal").hasClass("show") && mouseX > 0 && mouseY > 0) {
            var contentOffset = $modalContent.offset();
            if (contentOffset) {
                var contentWidth = $modalContent.outerWidth();
                var contentHeight = $modalContent.outerHeight();

                if (mouseX >= contentOffset.left &&
                    mouseX <= contentOffset.left + contentWidth &&
                    mouseY >= contentOffset.top &&
                    mouseY <= contentOffset.top + contentHeight) {
                    return; // Allow scrolling - don't prevent
                }
            }
        }

        // Prevent wheel on body/overlay (outside modal content)
        e.preventDefault();
        e.stopPropagation();
        return false;
    }

    // Prevent body scroll when brochure modal is open (allow scroll inside #brochureModal only)
    function preventBrochureModalBodyScroll(e) {
        var $target = $(e.target);
        if ($target.closest("#brochureModal .modal-content, #brochureModal .modal-body").length) {
            return true;
        }
        e.preventDefault();
        e.stopPropagation();
        return false;
    }

    function preventBrochureModalBodyWheel(e) {
        var mouseX = e.clientX || (e.originalEvent && e.originalEvent.clientX) || 0;
        var mouseY = e.clientY || (e.originalEvent && e.originalEvent.clientY) || 0;
        var elementAtPoint = null;
        if (document.elementFromPoint && mouseX > 0 && mouseY > 0) {
            try {
                elementAtPoint = document.elementFromPoint(mouseX, mouseY);
            } catch (err) {}
        }
        if (elementAtPoint) {
            var $elementAtPoint = $(elementAtPoint);
            if ($elementAtPoint.closest("#brochureModal .modal-content, #brochureModal .modal-body").length) {
                return;
            }
        }
        var $target = $(e.target);
        if ($target.closest("#brochureModal .modal-content, #brochureModal .modal-body").length) {
            return;
        }
        var $modalContent = $("#brochureModal .modal-content");
        if ($modalContent.length && $("#brochureModal").hasClass("show") && mouseX > 0 && mouseY > 0) {
            var contentOffset = $modalContent.offset();
            if (contentOffset) {
                var contentWidth = $modalContent.outerWidth();
                var contentHeight = $modalContent.outerHeight();
                if (mouseX >= contentOffset.left &&
                    mouseX <= contentOffset.left + contentWidth &&
                    mouseY >= contentOffset.top &&
                    mouseY <= contentOffset.top + contentHeight) {
                    return;
                }
            }
        }
        e.preventDefault();
        e.stopPropagation();
        return false;
    }

    // Function to close the menu
    function closeMenu() {
        $(".burger-icon").removeClass("active-burger");
        $(".toggle-menu-container").removeClass("open-menu");
        $("nav").removeClass("overlaynav-active");
        $(".overlay").removeClass("overlay-active");
        
        // Remove event listeners
        $(window).off("scroll", preventBodyScroll);
        document.removeEventListener("wheel", preventBodyWheel, false);
        $("body, .overlay").off("touchmove", preventBodyScroll);
        $(".toggle-menu-container, .inside-menu-container-inner").off("wheel");
        
        // Store the exact scroll position we want to restore
        var restorePosition = scrollPosition;
        
        // Temporarily disable smooth scroll behavior for instant scroll restoration
        var originalHtmlScrollBehavior = $("html").css("scroll-behavior");
        var originalBodyScrollBehavior = $("body").css("scroll-behavior");
        $("html, body").css("scroll-behavior", "auto");
        
        // First, restore overflow and padding (but keep position fixed temporarily)
        $("body").css({
            "overflow": "",
            "padding-right": ""
        });
        
        // Use requestAnimationFrame to ensure smooth restoration
        requestAnimationFrame(function() {
            // Remove position fixed and restore scroll in the same frame
            $("body").css({
                "position": "",
                "top": "",
                "left": "",
                "right": "",
                "width": ""
            });
            
            // Immediately restore scroll position - do this synchronously
            // Set all possible scroll properties to ensure it works
            if (window.scrollTo) {
                window.scrollTo(0, restorePosition);
            }
            document.documentElement.scrollTop = restorePosition;
            document.body.scrollTop = restorePosition;
            $(window).scrollTop(restorePosition);
            
            // Double-check after a micro-delay to ensure position is maintained
            requestAnimationFrame(function() {
                var currentScroll = window.pageYOffset || document.documentElement.scrollTop || $(window).scrollTop() || 0;
                if (Math.abs(currentScroll - restorePosition) > 1) {
                    // If position drifted, restore it again
                    if (window.scrollTo) {
                        window.scrollTo(0, restorePosition);
                    }
                    document.documentElement.scrollTop = restorePosition;
                    document.body.scrollTop = restorePosition;
                    $(window).scrollTop(restorePosition);
                }
                
                // Restore original scroll-behavior after scroll position is restored
                if (originalHtmlScrollBehavior) {
                    $("html").css("scroll-behavior", originalHtmlScrollBehavior);
                }
                if (originalBodyScrollBehavior) {
                    $("body").css("scroll-behavior", originalBodyScrollBehavior);
                }
                // Re-run ScrollTrigger/slider refresh after menu close (fixes careers-list hz-slider distortion when menu popup is closed)
                window._modalRestoreScrollPosition = restorePosition;
                if (typeof window.scheduleCardsRefreshAfterModalClose === "function") {
                    window.scheduleCardsRefreshAfterModalClose();
                }
            });
        });
        
        isMenuOpen = false;
    }

    // Track last focused form field inside formpopup so we can restore it when modal is reopened
    $(document).on('focusin', '.formpopup_modal', function (e) {
        var el = e.target;
        if (el && (el.tagName === "INPUT" || el.tagName === "TEXTAREA" || el.tagName === "SELECT")) {
            formpopupLastFocusedElement = el;
        }
    });



    // Lock body scroll when formpopup_modal opens
    $(document).on('show.bs.modal', '.formpopup_modal', function () {
        // Save current scroll position using multiple methods for reliability
        modalScrollPosition = window.pageYOffset ||
                              document.documentElement.scrollTop ||
                              document.body.scrollTop ||
                              $(window).scrollTop() ||
                              0;

                // When body is already position:fixed (e.g. hamburger menu open), pageYOffset is often 0 - use body's top so we don't restore to 0 on modal close
                if (modalScrollPosition === 0 && document.body.style.position === "fixed" && document.body.style.top) {
                    var topVal = document.body.style.top;
                    if (topVal && topVal.indexOf("-") === 0) {
                        var fromTop = Math.abs(parseInt(topVal, 10));
                        if (!isNaN(fromTop)) {
                            modalScrollPosition = fromTop;
                        }
                    }
                }
        
                              

        // Ensure we have a valid number
        modalScrollPosition = Math.max(0, Math.round(modalScrollPosition));

        // Unpin card ScrollTriggers BEFORE locking body so reflow from unpin doesn't distort the modal layout
        if (typeof ScrollTrigger !== "undefined") {
            ScrollTrigger.getAll().forEach(function(st) {
                if (st.vars && st.vars.id && String(st.vars.id).indexOf("card-") === 0) {
                    st.disable(false, false);
                }
            });
        }

        // Then lock body scroll (order matters: unpin first, then fixed)
        var scrollbarWidth = getScrollbarWidth();
        $("body").css({
            "overflow": "hidden",
            "position": "fixed",
            "top": "-" + modalScrollPosition + "px",
            "left": "0",
            "right": "0",
            "width": "100%",
            "padding-right": scrollbarWidth + "px"
        });

        $(window).on("scroll", preventModalBodyScroll);
        document.addEventListener("wheel", preventModalBodyWheel, { passive: false, capture: false });
        $("body, .modal-backdrop").on("touchmove", preventModalBodyScroll);
        $(".formpopup_modal .modal-content, .formpopup_modal .modal-body").on("wheel", function(e) {
            e.stopPropagation();
        });
    });

    // Unlock body scroll when formpopup_modal closes
    $(document).on('hidden.bs.modal', '.formpopup_modal', function () {
    // Reset all forms inside the modal so it always opens in a clean state
    $(this).find('form').each(function () {
        if (typeof this.reset === "function") {
            this.reset();
        }
    });

        // Remove event listeners
        $(window).off("scroll", preventModalBodyScroll);
        document.removeEventListener("wheel", preventModalBodyWheel, false);
        $("body, .modal-backdrop").off("touchmove", preventModalBodyScroll);
        $(".formpopup_modal .modal-content, .formpopup_modal .modal-body").off("wheel");

        // Store the exact scroll position we want to restore
        var restorePosition = modalScrollPosition;

        // Temporarily disable smooth scroll behavior for instant scroll restoration
        var originalHtmlScrollBehavior = $("html").css("scroll-behavior");
        var originalBodyScrollBehavior = $("body").css("scroll-behavior");
        $("html, body").css("scroll-behavior", "auto");

        // First, restore overflow and padding (but keep position fixed temporarily)
        $("body").css({
            "overflow": "",
            "padding-right": ""
        });

        // Use requestAnimationFrame to ensure smooth restoration
        requestAnimationFrame(function() {
            // Remove position fixed and restore scroll in the same frame
            $("body").css({
                "position": "",
                "top": "",
                "left": "",
                "right": "",
                "width": ""
            });

            // Immediately restore scroll position - do this synchronously
            // Set all possible scroll properties to ensure it works
            if (window.scrollTo) {
                window.scrollTo(0, restorePosition);
            }
            document.documentElement.scrollTop = restorePosition;
            document.body.scrollTop = restorePosition;
            $(window).scrollTop(restorePosition);

            // Double-check after a micro-delay to ensure position is maintained
            requestAnimationFrame(function() {
                var currentScroll = window.pageYOffset || document.documentElement.scrollTop || $(window).scrollTop() || 0;
                if (Math.abs(currentScroll - restorePosition) > 1) {
                    // If position drifted, restore it again
                    if (window.scrollTo) {
                        window.scrollTo(0, restorePosition);
                    }
                    document.documentElement.scrollTop = restorePosition;
                    document.body.scrollTop = restorePosition;
                    $(window).scrollTop(restorePosition);
                }

                // Restore original scroll-behavior after scroll position is restored
                if (originalHtmlScrollBehavior) {
                    $("html").css("scroll-behavior", originalHtmlScrollBehavior);
                }
                if (originalBodyScrollBehavior) {
                    $("body").css("scroll-behavior", originalBodyScrollBehavior);
                }

                // Pass intended scroll position so it can be re-applied after GSAP refresh (avoids GSAP/scroll conflict when body was fixed e.g. hamburger)
                window._modalRestoreScrollPosition = restorePosition;
                if (typeof window.scheduleCardsRefreshAfterModalClose === "function") {
                    window.scheduleCardsRefreshAfterModalClose();
                }

                // Re-run sticky fixed-header logic after popup close (programmatic scroll doesn't fire scroll; resize resets sticky state and re-evaluates fixed-header)
                setTimeout(function () {
                    $(window).trigger("resize");
                }, 0);
            });
        });
    });

    // Lock body scroll when brochure modal opens
    $(document).on('show.bs.modal', '#brochureModal', function () {
        brochureModalScrollPosition = window.pageYOffset ||
            document.documentElement.scrollTop ||
            document.body.scrollTop ||
            $(window).scrollTop() ||
            0;
        brochureModalScrollPosition = Math.max(0, Math.round(brochureModalScrollPosition));

        if (typeof ScrollTrigger !== "undefined") {
            ScrollTrigger.getAll().forEach(function (st) {
                if (st.vars && st.vars.id && String(st.vars.id).indexOf("card-") === 0) {
                    st.disable(false, false);
                }
            });
        }

        var scrollbarWidth = getScrollbarWidth();
        $("body").css({
            "overflow": "hidden",
            "position": "fixed",
            "top": "-" + brochureModalScrollPosition + "px",
            "left": "0",
            "right": "0",
            "width": "100%",
            "padding-right": scrollbarWidth + "px"
        });

        $(window).on("scroll", preventBrochureModalBodyScroll);
        document.addEventListener("wheel", preventBrochureModalBodyWheel, { passive: false, capture: false });
        $("body, .modal-backdrop").on("touchmove", preventBrochureModalBodyScroll);
        $("#brochureModal .modal-content, #brochureModal .modal-body").on("wheel", function (e) {
            e.stopPropagation();
        });
    });

    // Unlock body scroll when brochure modal closes
    $(document).on('hidden.bs.modal', '#brochureModal', function () {
        $(window).off("scroll", preventBrochureModalBodyScroll);
        document.removeEventListener("wheel", preventBrochureModalBodyWheel, false);
        $("body, .modal-backdrop").off("touchmove", preventBrochureModalBodyScroll);
        $("#brochureModal .modal-content, #brochureModal .modal-body").off("wheel");

        var restorePosition = brochureModalScrollPosition;
        var originalHtmlScrollBehavior = $("html").css("scroll-behavior");
        var originalBodyScrollBehavior = $("body").css("scroll-behavior");
        $("html, body").css("scroll-behavior", "auto");

        $("body").css({
            "overflow": "",
            "padding-right": ""
        });

        requestAnimationFrame(function () {
            $("body").css({
                "position": "",
                "top": "",
                "left": "",
                "right": "",
                "width": ""
            });

            if (window.scrollTo) {
                window.scrollTo(0, restorePosition);
            }
            document.documentElement.scrollTop = restorePosition;
            document.body.scrollTop = restorePosition;
            $(window).scrollTop(restorePosition);

            requestAnimationFrame(function () {
                var currentScroll = window.pageYOffset || document.documentElement.scrollTop || $(window).scrollTop() || 0;
                if (Math.abs(currentScroll - restorePosition) > 1) {
                    if (window.scrollTo) {
                        window.scrollTo(0, restorePosition);
                    }
                    document.documentElement.scrollTop = restorePosition;
                    document.body.scrollTop = restorePosition;
                    $(window).scrollTop(restorePosition);
                }
                if (originalHtmlScrollBehavior) {
                    $("html").css("scroll-behavior", originalHtmlScrollBehavior);
                }
                if (originalBodyScrollBehavior) {
                    $("body").css("scroll-behavior", originalBodyScrollBehavior);
                }
                window._modalRestoreScrollPosition = restorePosition;
                if (typeof window.scheduleCardsRefreshAfterModalClose === "function") {
                    window.scheduleCardsRefreshAfterModalClose();
                }
                setTimeout(function () {
                    $(window).trigger("resize");
                }, 0);
            });
        });
    });

    // Modal closes only via close (X) button - no close on outside/backdrop click

    // Open menu when burger icon is clicked
    $(".burger-icon").click(function () {
        // Save current scroll position using multiple methods for reliability
        // Get the most accurate scroll position
        scrollPosition = window.pageYOffset || 
                        document.documentElement.scrollTop || 
                        document.body.scrollTop || 
                        $(window).scrollTop() || 
                        0;
        
        // Ensure we have a valid number
        scrollPosition = Math.max(0, Math.round(scrollPosition));
        
        $(this).addClass("active-burger");
        $(".toggle-menu-container").addClass("open-menu");
        $("nav").addClass("overlaynav-active");
        $(".overlay").addClass("overlay-active");
        
        // Calculate scrollbar width to prevent layout shift
        var scrollbarWidth = getScrollbarWidth();
        
        // Lock body scroll using position fixed
        // Add padding-right equal to scrollbar width to prevent horizontal shift
        // Use the exact scroll position to maintain visual position
        $("body").css({
            "overflow": "hidden",
            "position": "fixed",
            "top": "-" + scrollPosition + "px",
            "left": "0",
            "right": "0",
            "width": "100%",
            "padding-right": scrollbarWidth + "px"
        });
        
        // Prevent scroll events on body/overlay (but allow on menu)
        $(window).on("scroll", preventBodyScroll);
        // Prevent wheel events - check if in menu, if not prevent
        document.addEventListener("wheel", preventBodyWheel, { passive: false, capture: false });
        $("body, .overlay").on("touchmove", preventBodyScroll);
        
        // Ensure menu can scroll by allowing wheel events on menu container
        $(".toggle-menu-container, .inside-menu-container-inner").on("wheel", function(e) {
            // Allow natural scrolling - don't prevent
            e.stopPropagation(); // Stop from bubbling to document handler
        });
        
        isMenuOpen = true;
    });

    // Close menu when cross icon or overlay is clicked
    $(".cross_icon, .overlay").click(function () {
        closeMenu();
    });

    // Close menu when clicking outside toggle-menu-container
    $(document).click(function (e) {
        // Check if menu is open
        if ($(".toggle-menu-container").hasClass("open-menu")) {
            // Check if click is outside toggle-menu-container and not on burger-icon
            if (!$(e.target).closest(".toggle-menu-container").length && 
                !$(e.target).closest(".burger-icon").length) {
                closeMenu();
            }
        }
    });
});




var swiper2 = new Swiper(".brandslider", {
    spaceBetween: 30,
    slidesPerView: 7,
    centeredSlides: true,
    loop: true,
    freeMode: true,
    freeModeMomentum: false,
    autoplay: {
        delay: 0,
        disableOnInteraction: false,
        pauseOnMouseEnter: false,
    },
    speed: 5000,
    allowTouchMove: false,
    breakpoints: {
        360: {
            slidesPerView: 3,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 5,
            spaceBetween: 25,
        },
        1080: {
            slidesPerView: 7,
            spaceBetween: 30,
        },
    },
});


// Tabs functionality
jQuery(document).ready(function ($) {

    $(document).on('click', '.tabsautoscroll li', function (e) {
        // Prevent default anchor behavior if anchor exists
        var $link = $(this).find("a.custom-tab-link");
        if ($link.length) {
            e.preventDefault();
        }

        var $this = $(this);
        var t = $this.data("id"); // e.g., "content0", "content1", etc.
        var tabsContainer = $(".tabsautoscroll");

        // Handle scroll arrows
        $this.is(":last-child") ? $(".next").hide() : $(".next").show();
        $this.is(":first-child") ? $(".previous").hide() : $(".previous").show();

        // Scroll tabs horizontally to center the clicked tab (only on desktop)
        if ($(window).width() > 1024) {
            var tabPosition = $this.position().left;
            var tabWidth = $this.outerWidth();
            var containerWidth = tabsContainer.width();
            var currentScroll = tabsContainer.scrollLeft();

            // Calculate scroll position to center the tab
            var targetScroll = currentScroll + tabPosition - (containerWidth / 2) + (tabWidth / 2);

            // Use jQuery animate for smooth scrolling
            tabsContainer.stop().animate({ scrollLeft: targetScroll }, 300, 'swing');
        }

        // Toggle class only, no .show() or .hide()
        $(".tabContent .tabdiv").removeClass("active-tabcontent");
        $(".tabContent .tabdiv." + t).addClass("active-tabcontent");

        // Active tab styling
        $(".tabsautoscroll li").removeClass("active");
        $this.addClass("active");

        // Update select-brand text on mobile
        if ($(window).width() <= 1024) {
            var selectedText = $link.length ? $link.text() : $this.text();
            $(".filter-menu .select-brand").text(selectedText.trim());
        }
    });

    // Handle click on custom-tab-link to prevent default anchor behavior
    $(document).on('click', '.tabsautoscroll li .custom-tab-link', function (e) {
        e.preventDefault();
        // Event will bubble to parent li, which handles the tab switching
    });

    // $(".tabdiv a").click(function (e) {
    //   e.preventDefault(), $("li.active").next("li").trigger("click");
    // }),
    $(document).on('click', '.next', function (e) {
        e.preventDefault();
        $("li.active").next("li").trigger("click");
    });

    $(document).on('click', '.previous', function (e) {
        e.preventDefault();
        $("li.active").prev("li").trigger("click");
    });

    // Mobile dropdown functionality for tabs (similar to rep-portfolio)
    // Handle click on select-brand to toggle dropdown
    $(document).on('click', '.filter-menu .select-brand', function () {
        if ($(window).width() <= 1024) {
            $(this).toggleClass("angle-icon");
            $(this).next("ul.tabsautoscroll").slideToggle();
        }
    });

    // Handle click on custom tabs li to close dropdown on mobile
    $(document).on('click', '.filter-menu .tabsautoscroll li', function () {
        if ($(window).width() <= 1024) {
            $(".filter-menu .select-brand").removeClass("angle-icon");
            $(this).parents("ul.tabsautoscroll").slideUp();
        }
    });
});

// Smart Tabs functionality (for customtabsmart widget) - No auto scroll
jQuery(document).ready(function ($) {

    $(document).on('click', '.smart-tabsautoscroll li', function (e) {
        // Prevent default anchor behavior if anchor exists
        var $link = $(this).find("a.smart-tab-link");
        if ($link.length) {
            e.preventDefault();
        }

        var $this = $(this);
        var t = $this.data("id"); // e.g., "content0", "content1", etc.

        // Toggle class only, no .show() or .hide()
        $(".smart-tabContent .smart-tabdiv").removeClass("smart-active-tabcontent");
        $(".smart-tabContent .smart-tabdiv." + t).addClass("smart-active-tabcontent");

        // Active tab styling
        $(".smart-tabsautoscroll li").removeClass("active");
        $this.addClass("active");

        // Update select-brand text on mobile
        if ($(window).width() <= 1024) {
            var selectedText = $link.length ? $link.text() : $this.text();
            $(".smart-filter-menu .smart-select-brand").text(selectedText.trim());
        }
    });

    // Handle click on smart-tab-link to prevent default anchor behavior
    $(document).on('click', '.smart-tabsautoscroll li .smart-tab-link', function (e) {
        e.preventDefault();
        // Event will bubble to parent li, which handles the tab switching
    });

    // Mobile dropdown functionality for smart tabs
    // Handle click on select-brand to toggle dropdown
    $(document).on('click', '.smart-filter-menu .smart-select-brand', function () {
        if ($(window).width() <= 1024) {
            $(this).toggleClass("angle-icon");
            $(this).next("ul.smart-tabsautoscroll").slideToggle();
        }
    });

    // Handle click on smart tabs li to close dropdown on mobile
    $(document).on('click', '.smart-filter-menu .smart-tabsautoscroll li', function () {
        if ($(window).width() <= 1024) {
            $(".smart-filter-menu .smart-select-brand").removeClass("angle-icon");
            $(this).parents("ul.smart-tabsautoscroll").slideUp();
        }
    });
});


// Footer Accordion - Mobile Only (max-width: 767px)
jQuery(document).ready(function ($) {
    function handleFooterAccordion() {
        // Only enable accordion on mobile (767px and below)
        if ($(window).width() <= 767) {
            // Initialize all accordion items as active (opened) on mobile
            $('.footer-accordion-item').addClass('active');
            
            $('.footer-accordion-title').off('click').on('click', function () {
                var $accordionItem = $(this).closest('.footer-accordion-item');

                // Simply toggle the active class - CSS will handle the animation
                $accordionItem.toggleClass('active');
            });
        } else {
            // On desktop, remove click handler and ensure all content is visible
            $('.footer-accordion-title').off('click');
            $('.footer-accordion-content').css('display', '');
            $('.footer-accordion-item').removeClass('active');
        }
    }

    // Initialize on page load
    handleFooterAccordion();

    // Re-initialize on window resize
    var resizeTimer;
    $(window).on('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            handleFooterAccordion();
        }, 250);
    });
});

const swiper = new Swiper(".testimonialSwiper", {
    slidesPerView: 2,
    spaceBetween: 20,
    loop: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    breakpoints: {
        768: {
            slidesPerView:1 ,
        },
    },
});


// ============================================
// STICKY MENU WITH SCROLL SPY - CONFIGURABLE
// ============================================
// This function handles sticky menu functionality with different configurations per page
function initStickyMenu(config) {
    var $stickyCustom = $(".sticky-custom");
    var $enterpriseBanner = $("#enterprisebanner");
    
    // Only run this code if one of these elements exists
    if ($stickyCustom.length === 0 && $enterpriseBanner.length === 0) {
        return; // Exit early if neither element exists
    }

    var $items = $(".sticky-custom ul.elementor-icon-list-items.elementor-inline-items li");
    var $menu = $(".sticky-custom"); // menu container
    var $menuList = $(".sticky-custom ul.elementor-icon-list-items.elementor-inline-items"); // list container for scrolling

    // Use provided sections or auto-detect from menu items
    var sections = config.sections || [];
    
    // If sections not provided, try to auto-detect from menu items
    if (sections.length === 0) {
        $items.each(function() {
            var $link = $(this).find('a');
            if ($link.length) {
                var href = $link.attr('href');
                if (href && href.indexOf('#') !== -1) {
                    var sectionId = href.split('#')[1];
                    // Check if element exists as ID or class
                    var $byId = $('#' + sectionId);
                    var $byClass = $('.' + sectionId);
                    if ($byId.length > 0) {
                        sections.push('#' + sectionId); // Use ID selector
                    } else if ($byClass.length > 0) {
                        sections.push('.' + sectionId); // Use class selector
                    } else {
                        // Default to ID selector if element not found yet (might load later)
                        sections.push('#' + sectionId);
                    }
                } else {
                    // Try data attribute or class
                    var dataTarget = $link.data('target') || $(this).data('section');
                    if (dataTarget) {
                        // Check if it's an ID or class
                        if (dataTarget.indexOf('#') === 0) {
                            sections.push(dataTarget);
                        } else if (dataTarget.indexOf('.') === 0) {
                            sections.push(dataTarget);
                        } else {
                            // Try both ID and class
                            var $byId = $('#' + dataTarget);
                            var $byClass = $('.' + dataTarget);
                            if ($byId.length > 0) {
                                sections.push('#' + dataTarget);
                            } else {
                                sections.push('.' + dataTarget);
                            }
                        }
                    }
                }
            }
        });
    }

    // If still no sections found, exit
    if (sections.length === 0) {
        return;
    }

    var sectionData = [];
    var lastActive = -1;
    var triggerOffset = config.triggerOffset || 220; // Default 220, can be overridden
    var scrollThreshold = config.scrollThreshold || 120; // Default 120px, can be overridden
    var rafID = null;
    var isManualClick = false; // Flag to prevent scroll spy from overriding manual clicks
    var stickyElementInitialTop = null; // Store initial position of sticky element
    var previousFixedHeaderState = false; // Track previous fixed-header state
    var previousMenuHiddenState = false; // Track previous menu-hidden state
    var refreshTimeout = null; // Debounce ScrollTrigger refresh calls
    var menuSpacer = null; // Spacer element to maintain layout when menu becomes fixed
    var menuOriginalHeight = null; // Store original menu height
    
    // --------------------------------------------
    // FUNCTION: Scroll active item to left (mobile only)
    // --------------------------------------------
    function scrollActiveItemToLeft() {
        // Only on mobile view (below 768px)
        if ($(window).width() > 768) {
            return;
        }
        
        var $activeItem = $items.filter(".active-li");
        if (!$activeItem.length) {
            return;
        }
        
        // Find the scrollable container - try ul first, then parent
        var $scrollContainer = $menuList;
        
        // Check if ul is scrollable, if not find scrollable parent
        var hasScroll = $scrollContainer.length && (
            $scrollContainer.css('overflow-x') === 'scroll' || 
            $scrollContainer.css('overflow-x') === 'auto' ||
            $scrollContainer.css('overflow') === 'scroll' ||
            $scrollContainer.css('overflow') === 'auto'
        );
        
        if (!hasScroll && $scrollContainer.length) {
            // Find parent with horizontal scroll
            $scrollContainer = $activeItem.closest('.sticky-custom');
            // Check if parent is scrollable
            var parentOverflow = $scrollContainer.css('overflow-x');
            if (parentOverflow !== 'scroll' && parentOverflow !== 'auto') {
                // Try to find any scrollable ancestor
                $scrollContainer = $activeItem.parentsUntil('.sticky-custom').filter(function() {
                    var overflow = $(this).css('overflow-x');
                    return overflow === 'scroll' || overflow === 'auto';
                }).first();
                
                // Final fallback to menu container
                if (!$scrollContainer.length) {
                    $scrollContainer = $menu;
                }
            }
        }
        
        if ($scrollContainer.length) {
            // Get item position relative to scrollable container
            var itemOffset = $activeItem.offset().left;
            var containerOffset = $scrollContainer.offset().left;
            var currentScroll = $scrollContainer.scrollLeft();
            
            // Calculate position relative to container
            var relativePosition = itemOffset - containerOffset + currentScroll;
            
            // Calculate target scroll to position item at left (with padding)
            var targetScroll = relativePosition - 20; // 20px padding from left
            
            // Ensure target scroll is not negative
            targetScroll = Math.max(0, targetScroll);
            
            // Smooth scroll to position
            $scrollContainer.stop().animate({
                scrollLeft: targetScroll
            }, 300, 'swing');
        }
    }

    // --------------------------------------------
    // CLICK = Scroll to SAME trigger position + Set Active Class
    // --------------------------------------------
    $items.each(function (i) {
        $(this).on("click", function (e) {
            e.preventDefault(); // Prevent default anchor behavior if any
            
            var $target = $(sections[i]);
            if ($target.length) {
                // Set flag to prevent scroll spy from overriding
                isManualClick = true;
                
                // Remove active class from all items
                $items.removeClass("active-li");
                
                // Add active class to clicked item
                $(this).addClass("active-li");
                
                // Update lastActive to prevent scroll spy from overriding
                lastActive = i;
                
                // Scroll active item to left on mobile
                setTimeout(function() {
                    scrollActiveItemToLeft();
                }, 50);

                // Calculate exact scroll position based on actual sticky menu height
                // instead of using the generic triggerOffset. This avoids visual gaps
                // when the menu switches between normal and fixed states during scroll.
                var menuHeight = 0;
                if ($menu.length) {
                    menuHeight = $menu.outerHeight(true) || 0; // include margins
                }

                // Small extra padding so section title is not glued to the menu
                var extraPadding = 20;

                var exactPosition = $target.offset().top - menuHeight - extraPadding;
                if (exactPosition < 0) {
                    exactPosition = 0;
                }

                // Smooth scroll to target section
                // Prefer Lenis smooth scroll if available to avoid conflicts
                // with GSAP / ScrollTrigger and native/jQuery scrolling.
                if (typeof lenis !== "undefined" && lenis && typeof lenis.scrollTo === "function") {
                    // Duration in seconds (Lenis expects seconds)
                    var duration = 0.6;
                    lenis.scrollTo(exactPosition, {
                        duration: duration,
                    });

                    // Approximate callback after scroll finishes
                    setTimeout(function() {
                        updatePositions();
                        isManualClick = false;
                    }, duration * 1000 + 150);
                } else {
                    $("html, body").animate({
                        scrollTop: exactPosition
                    }, 300, function() {
                        // Update positions after scroll completes
                        updatePositions();
                        // Reset flag after scroll animation completes
                        setTimeout(function() {
                            isManualClick = false;
                        }, 100);
                    });
                }
            }
        });
    });

    // --------------------------------------------
    // CACHE SECTION POSITIONS
    // --------------------------------------------
    function updatePositions() {
        sectionData = [];

        sections.forEach(function (sel, i) {
            var $sec = $(sel);
            if ($sec.length) {
                sectionData.push({
                    index: i,
                    top: $sec.offset().top,
                    bottom: $sec.offset().top + $sec.outerHeight()
                });
            }
        });
    }

    // --------------------------------------------
    // SCROLL SPY + AUTO HIDE MENU AFTER 5TH SECTION
    // --------------------------------------------
    function detectActiveSection() {
        // Safety check: if no sections found, exit early
        if (sectionData.length === 0) {
            return;
        }
        
        // Don't update active class if user just clicked manually
        if (isManualClick) {
            return;
        }

        var scrollTop = $(window).scrollTop() + triggerOffset;
        var activeIndex = 0;

        // Find active section
        for (var i = 0; i < sectionData.length; i++) {
            if (scrollTop >= sectionData[i].top) {
                activeIndex = sectionData[i].index;
            }
        }

        // Update active li only if it changed and not during manual click
        if (activeIndex !== lastActive) {
            $items.removeClass("active-li");
            $items.eq(activeIndex).addClass("active-li");
            lastActive = activeIndex;
            
            // Scroll active item to left on mobile
            setTimeout(function() {
                scrollActiveItemToLeft();
            }, 50);
        }

        // ------------------------------------------
        // HIDE MENU when last section scrolls above
        // ------------------------------------------
        var lastSection = sectionData[sectionData.length - 1];

        // Safety check: ensure lastSection exists before accessing properties
        // IMPORTANT: Use actual scroll position (not scrollTop which includes triggerOffset)
        // to check if we've scrolled past the last section
        var actualScrollPosition = $(window).scrollTop();
        
        var currentMenuHiddenState = false;
        if (lastSection && actualScrollPosition > lastSection.bottom) {
            // User scrolled PAST the last section (section bottom is above viewport)
            $menu.addClass("menu-hidden");
            currentMenuHiddenState = true;
        } else {
            // User scrolls back up → show menu again
            $menu.removeClass("menu-hidden");
            currentMenuHiddenState = false;
        }
        
        // Refresh ScrollTrigger when menu-hidden state changes (affects layout)
        if (currentMenuHiddenState !== previousMenuHiddenState) {
            previousMenuHiddenState = currentMenuHiddenState;
            // Debounce ScrollTrigger refresh to avoid excessive calls
            if (refreshTimeout) {
                clearTimeout(refreshTimeout);
            }
            refreshTimeout = setTimeout(function() {
                if (typeof ScrollTrigger !== 'undefined') {
                    ScrollTrigger.refresh();
                }
            }, 50);
        }
    }

    function onScroll() {
        if (rafID) cancelAnimationFrame(rafID);
        rafID = requestAnimationFrame(function () {
            detectActiveSection();
            rafID = null;
        });
    }

    // Create spacer element to maintain layout when menu becomes fixed
    function createMenuSpacer() {
        if (!menuSpacer) {
            menuSpacer = $('<div class="sticky-menu-spacer"></div>');
            menuSpacer.css({
                'display': 'none',
                'width': '100%',
                'height': '0px',
                'margin': '0',
                'padding': '0',
                'visibility': 'hidden'
            });
            $menu.after(menuSpacer);
        }
    }

    // Handle fixed-header class when sticky element reaches top of viewport
    function handleFixedHeader() {
        // Store initial position on first call (before element becomes fixed)
        if (stickyElementInitialTop === null) {
            var elementOffset = $menu.offset();
            if (elementOffset) {
                stickyElementInitialTop = elementOffset.top;
                // Store original menu height before it becomes fixed
                menuOriginalHeight = $menu.outerHeight(true); // Include margins
            } else {
                return; // Element not found or not visible
            }
        }
        
        var scrollTop = $(window).scrollTop();
        var activationThreshold = stickyElementInitialTop - 120; // Activate 120px before element reaches top
        
        // Determine if fixed-header should be active
        var shouldBeFixed = scrollTop >= activationThreshold;
        var currentFixedHeaderState = $menu.hasClass('fixed-header');
        
        // Only proceed if state is actually changing
        if (shouldBeFixed === currentFixedHeaderState) {
            return; // No state change needed
        }
        
        // Create spacer if it doesn't exist
        createMenuSpacer();
        
        // Add or remove fixed-header class based on scroll position (same frame = no jerk)
        if (shouldBeFixed && !currentFixedHeaderState) {
            // Menu is about to become fixed - get current height BEFORE it becomes fixed
            var currentHeight = $menu.outerHeight(true); // Include margins
            
            // Set spacer height and show it in same frame, then add class (smooth normal scroll)
            menuSpacer.css({
                'display': 'block',
                'height': currentHeight + 'px'
            });
            $menu.addClass('fixed-header');
            
            requestAnimationFrame(function() {
                updatePositions();
            });
            
        } else if (!shouldBeFixed && currentFixedHeaderState) {
            // Menu is about to become unfixed - remove class and hide spacer in same frame to avoid jerk
            $menu.removeClass('fixed-header');
            menuSpacer.css({
                'display': 'none',
                'height': '0px'
            });
            
            requestAnimationFrame(function() {
                var elementOffset = $menu.offset();
                if (elementOffset) {
                    stickyElementInitialTop = elementOffset.top;
                }
                updatePositions();
            });
        }
        
        // Refresh ScrollTrigger when fixed-header state changes (affects layout)
        if (shouldBeFixed !== previousFixedHeaderState) {
            previousFixedHeaderState = shouldBeFixed;
            // Debounce ScrollTrigger refresh to avoid excessive calls
            if (refreshTimeout) {
                clearTimeout(refreshTimeout);
            }
            refreshTimeout = setTimeout(function() {
                if (typeof ScrollTrigger !== 'undefined') {
                    ScrollTrigger.refresh();
                }
            }, 50);
        }
    }

    // INIT
    updatePositions();
    detectActiveSection();
    handleFixedHeader(); // Initial check
    // Initialize previous states after first check
    previousFixedHeaderState = $menu.hasClass('fixed-header');
    previousMenuHiddenState = $menu.hasClass('menu-hidden');

    $(window).on("scroll", function() {
        onScroll();
        handleFixedHeader(); // Check on every scroll
    });
    $(window).on("resize", function () {
        // Temporarily remove fixed-header to get natural position, then recalculate
        var wasFixed = $menu.hasClass('fixed-header');
        if (wasFixed) {
            $menu.removeClass('fixed-header');
            // Hide spacer during recalculation
            if (menuSpacer) {
                menuSpacer.css('display', 'none');
            }
        }
        
        // Reset initial position and height on resize so it recalculates
        stickyElementInitialTop = null;
        menuOriginalHeight = null;
        
        // Recalculate everything
        updatePositions();
        detectActiveSection();
        handleFixedHeader(); // Check on resize (will recalculate and re-apply if needed)
        
        // Re-scroll active item to left on mobile after resize
        if ($(window).width() <= 768) {
            setTimeout(function() {
                scrollActiveItemToLeft();
            }, 100);
        }
    });
}

// ============================================
// PAGE CONFIGURATIONS
// ============================================
// Define configurations for different pages
var stickyMenuConfigs = {
    // Configuration for page with 5 sections (original)
    default: {
        sections: [
            ".live_monitoring",
            ".system_setup",
            // Support both legacy misspelled class and correct spelling
            ".intelligenc_alerts, .intelligence_alerts",
            ".recording_storage",
            ".security_integration"
        ],
        triggerOffset: 220,
        scrollThreshold: 120
    },
    // Configuration for page with 3 sections (enforcement page)
    enforcement: {
        sections: [
            ".enforcement_automation",
            ".rider_enforcement",
            ".centralised_control"
        ],
        triggerOffset: 220, // Adjust if needed
        scrollThreshold: 120 // Fixed at 120px from top of viewport
    },
    // Configuration for page with 4 sections (city systems page)
    citysystems: {
        sections: [
            ".security_systems",
            ".access_identity",
            ".infrastructure_sensors",
            ".citysystems_services"
        ],
        triggerOffset: 220, // Adjust if needed
        scrollThreshold: 120 // Fixed at 120px from top of viewport
    },
    // Configuration for partner page
    partnersystems: {
        sections: [
            ".channel_partner",
            ".technology_partner",
        ],
        triggerOffset: 220, // Adjust if needed
        scrollThreshold: 120 // Fixed at 120px from top of viewport
    },
    // Configuration for sitemap page
    sitemap: {
        sections: [
            "#product",
            "#industries",
            "#insight",
            "#company",
            "#quicklinks"
        ],
        triggerOffset: 220, // Adjust if needed
        scrollThreshold: 120 // Fixed at 120px from top of viewport
    }
};

// ============================================
// AUTO-DETECT AND INITIALIZE
// ============================================
jQuery(document).ready(function ($) {
    // Function to detect which configuration to use
    function detectConfiguration() {
        // Check for enforcement page sections
        var hasEnforcementSections = $(".enforcement_automation, .rider_enforcement, .centralised_control").length >= 2;
        
        if (hasEnforcementSections) {
            return stickyMenuConfigs.enforcement;
        }
        
        // Check for citysystems page sections
        var hasCitysystemsSections = $(".security_systems, .access_identity, .infrastructure_sensors, .citysystems_services").length >= 2;
        
        if (hasCitysystemsSections) {
            return stickyMenuConfigs.citysystems;
        }
        
        // Check for default page sections
        var hasDefaultSections = $(".live_monitoring, .system_setup, .intelligenc_alerts, .intelligence_alerts, .recording_storage, .security_integration").length >= 3;
        
        if (hasDefaultSections) {
            return stickyMenuConfigs.default;
        }

        // Check for partner page sections
        var hasPartnerSections = $(".channel_partner, .technology_partner").length >= 2;
        
        if (hasPartnerSections) {
            return stickyMenuConfigs.partnersystems;
        }
        
        // Check for sitemap page sections (using ID selectors)
        var hasSitemapSections = $("#product, #industries, #insight, #company, #quicklinks").length >= 3;
        
        if (hasSitemapSections) {
            return stickyMenuConfigs.sitemap;
        }
        
        // If no specific sections found, try to auto-detect from menu
        // Return a config with empty sections array to trigger auto-detection
        return {
            sections: [],
            triggerOffset: 220,
            scrollThreshold: 120
        };
    }
    
    // Initialize with detected configuration
    var config = detectConfiguration();
    initStickyMenu(config);
});



jQuery(document).ready(function() {
    // Check if accordion exists on the page
    if (jQuery('.accordion_wrap').length === 0) {
        return;
    }

    // Global registry to store accordion instances for pause/resume
    var accordionInstances = [];

    // Helper function to check if any modal is currently open
    function isModalOpen() {
        return jQuery('.modal.show, .modal.in').length > 0 || jQuery('body').hasClass('modal-open');
    }

    // Initialize each accordion wrapper independently
    jQuery('.accordion_wrap').each(function() {
        var $accordionWrap = jQuery(this);
        var $accordionSets = $accordionWrap.find('.accordion_set');
        var $videoPanel = $accordionWrap.find('.padd-accordion_video');
        var $accordionVideos = $videoPanel.find('.accordion_video');
        
        // Skip if no accordion sets found
        if ($accordionSets.length === 0) {
            return;
        }

        // Open first section by default
        var $first = $accordionSets.first();
        $first.addClass('acactive');
        $first.find('.select_div').attr("aria-expanded", "true");
        $first.find(".accontent").slideDown(200);
        
        // Initialize videos - show first video, hide others using opacity
        // Only target right-side panel videos (desktop view)
        $accordionVideos.each(function(index) {
            if (index === 0) {
                jQuery(this).addClass('active');
            } else {
                jQuery(this).removeClass('active');
            }
        });

        // Setup variables for this accordion instance
        var autoIndex = 0;
        var total = $accordionSets.length;
        var autoInterval = 9000; // 9 seconds
        var timer = null;
        var isPaused = false;
        var resumeTimeout = null;
        var progressInterval = null;

        // Function to switch video by index using opacity transitions
        // Only target right-side panel videos (desktop view) within this accordion
        function switchVideo(index) {
            $accordionVideos.each(function(videoIndex) {
                if (videoIndex === index) {
                    jQuery(this).addClass('active');
                } else {
                    jQuery(this).removeClass('active');
                }
            });
        }

        // Function to start progress fill animation
        function startProgressFill() {
            // Clear any existing progress interval
            if (progressInterval) {
                clearInterval(progressInterval);
                progressInterval = null;
            }

            // Reset progress on all accordion items in this accordion
            $accordionSets.each(function() {
                this.style.setProperty('--progress', '0%');
            });

            // Start progress for active accordion item
            const activeAccordion = $accordionSets.filter('.acactive')[0];
            if (activeAccordion) {
                var timeLeft = autoInterval / 1000; // Convert to seconds
                const updateInterval = 50; // Update every 50ms for smooth animation

                progressInterval = setInterval(function() {
                    if (isPaused || isModalOpen()) {
                        return;
                    }
                    
                    timeLeft -= (updateInterval / 1000);
                    const progress = ((autoInterval / 1000 - timeLeft) / (autoInterval / 1000)) * 100;
                    
                    // Update progress CSS variable
                    activeAccordion.style.setProperty('--progress', progress + '%');

                    if (timeLeft <= 0) {
                        clearInterval(progressInterval);
                        progressInterval = null;
                    }
                }, updateInterval);
            }
        }

        // Function to open accordion by index (scoped to this accordion)
        function openAccordion(index) {
            var $target = $accordionSets.eq(index);
            $accordionSets.removeClass("acactive");
            $accordionSets.find('.select_div').attr("aria-expanded", "false");
            $accordionSets.find(".accontent").slideUp(200);

            $target.addClass("acactive");
            $target.find(".select_div").attr("aria-expanded", "true");
            $target.find(".accontent").slideDown(200);

            // Switch to corresponding video
            switchVideo(index);
            
            // Start progress fill animation
            startProgressFill();
        }

        // Auto slide function
        function startAutoSlide() {
            if (isPaused || isModalOpen()) {
                return; // Don't start if paused or modal is open
            }
            if (timer) {
                clearInterval(timer);
            }
            timer = setInterval(function() {
                if (!isPaused && !isModalOpen()) {
                    autoIndex = (autoIndex + 1) % total;
                    openAccordion(autoIndex);
                }
            }, autoInterval);
        }

        // Pause auto slide function
        function pauseAutoSlide() {
            isPaused = true;
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
            // Pause progress animation
            if (progressInterval) {
                clearInterval(progressInterval);
                progressInterval = null;
            }
            // Cancel any pending resume timeout
            if (resumeTimeout) {
                clearTimeout(resumeTimeout);
                resumeTimeout = null;
            }
        }

        // Resume auto slide function
        function resumeAutoSlide() {
            // Don't resume if modal is open
            if (isModalOpen()) {
                return;
            }
            isPaused = false;
            if (!timer) {
                startAutoSlide();
            }
            // Restart progress fill animation
            startProgressFill();
        }

        // Initialize progress fill for first accordion
        setTimeout(function() {
            startProgressFill();
        }, 200);

        // Start auto slide initially
        startAutoSlide();

        // On click — manual control + reset timer (scoped to this accordion)
        $accordionSets.find('.select_div').click(function() {
            pauseAutoSlide(); // pause auto slide

            var $parent = jQuery(this).parents('.accordion_set');
            autoIndex = $accordionSets.index($parent); // update index (scoped to this accordion)

            if ($parent.hasClass("acactive")) {
                $parent.removeClass("acactive");
                jQuery(this).attr("aria-expanded", "false");
                $parent.find(".accontent").slideUp(200);
                // Stop progress animation when closing
                if (progressInterval) {
                    clearInterval(progressInterval);
                    progressInterval = null;
                }
                $parent[0].style.setProperty('--progress', '0%');
            } else {
                openAccordion(autoIndex);
            }

            // Cancel any existing resume timeout
            if (resumeTimeout) {
                clearTimeout(resumeTimeout);
            }

            // Restart auto slide after short delay, but only if modal is not open
            resumeTimeout = setTimeout(function() {
                resumeTimeout = null;
                if (!isModalOpen()) {
                    resumeAutoSlide();
                }
            }, 1000);
        });

        // Register this accordion instance for global pause/resume
        accordionInstances.push({
            pause: pauseAutoSlide,
            resume: resumeAutoSlide
        });
    });

    // Pause all accordions when modal opens
    jQuery(document).on('show.bs.modal', '.modal', function() {
        // Pause all accordion instances
        accordionInstances.forEach(function(instance) {
            instance.pause();
        });

        if (typeof window.destroyHzSliderSectionGSAP === "function") window.destroyHzSliderSectionGSAP();
        if (typeof window.destroyHzSliderTopcaptionGSAP === "function") window.destroyHzSliderTopcaptionGSAP();
        if (typeof window.destroyHzSliderEnergyGSAP === "function") window.destroyHzSliderEnergyGSAP();
        if (typeof window.destroySectionsscrollGSAP === "function") window.destroySectionsscrollGSAP();
        if (typeof ScrollTrigger !== "undefined") {
            ScrollTrigger.getAll().forEach(function(st) {
                var id = st.vars && st.vars.id ? String(st.vars.id) : "";
                if (id.indexOf("card-") === 0) st.disable(false, false);
            });
        }
        
        // Load video with autoplay when modal opens
        var modal = jQuery(this);
        var iframe = modal.find('iframe');
        if (iframe.length) {
            // Get the base URL from data-src attribute
            var baseSrc = iframe.attr('data-src') || iframe.data('original-src');
            if (baseSrc) {
                // Add autoplay parameter to the URL
                var separator = baseSrc.indexOf('?') !== -1 ? '&' : '?';
                var videoSrc = baseSrc + separator + 'autoplay=1';
                iframe.attr('src', videoSrc);
            }
        }
    });

    // Resume all accordions when modal closes and stop video
    jQuery(document).on('hidden.bs.modal', '.modal', function() {
        // Stop video by removing src attribute
        var modal = jQuery(this);
        var iframe = modal.find('iframe');
        if (iframe.length) {
            // Store the base URL (without autoplay) if not already stored
            if (!iframe.data('original-src')) {
                var currentSrc = iframe.attr('src');
                if (currentSrc) {
                    // Remove autoplay parameter from URL
                    var baseSrc = currentSrc.replace(/[?&]autoplay=1(&|$)/, '').replace(/[?&]$/, '');
                    iframe.data('original-src', baseSrc);
                }
            }
            // Remove src to stop video playback
            iframe.attr('src', '');
        }
        
        // Small delay to ensure modal is fully closed, then resume all accordions
        setTimeout(function() {
            if (!isModalOpen()) {
                accordionInstances.forEach(function(instance) {
                    instance.resume();
                });
            }
        }, 100);

        if (typeof window.forceBodyReset === "function") window.forceBodyReset();
        else {
            jQuery("body").removeClass("modal-open");
            jQuery("body").css({ "overflow": "auto", "padding-right": "0", "position": "", "top": "", "left": "", "right": "", "width": "" });
        }
        if (typeof window.scheduleCardsRefreshAfterModalClose === "function") {
            window.scheduleCardsRefreshAfterModalClose();
        }

        // Re-run sticky fixed-header logic so fixed-header class is correct after any modal close
        setTimeout(function () {
            jQuery(window).trigger("resize");
        }, 0);
    });
});


function initSectionsscrollGSAP() {
    if (window.innerWidth < 1180 || !document.querySelector(".sectionsscroll")) return;
    if (typeof ScrollTrigger === "undefined") return;
    gsap.registerPlugin(ScrollTrigger);
    ScrollTrigger.getAll().forEach(function (st) {
        if (st.vars && st.vars.id === "sectionsscroll-pin") st.kill();
    });
    var panels = gsap.utils.toArray(".sectionsscroll .animate-right");
    var content = gsap.utils.toArray(".sectionsscroll .animate-left");
    if (panels.length === 0) return;
    var tl = gsap.timeline({
        scrollTrigger: {
            trigger: ".sectionsscroll",
            start: "top 20%",
            endTrigger: ".sectionsscroll",
            end: function () { return "+=" + (200 * panels.length) + "%"; },
            pin: true,
            pinSpacing: true,
            markers: false,
            scrub: 1,
            invalidateOnRefresh: true,
            refreshPriority: 1,
            id: "sectionsscroll-pin"
        }
    });
    panels.forEach(function (panel, index) {
        tl.from(panel, { yPercent: 100, ease: "slow" }, "+=0.1");
        tl.from(content[index], { yPercent: 100, ease: "slow" }, "<");
    });
}
function destroySectionsscrollGSAP() {
    if (typeof ScrollTrigger === "undefined") return;
    var st = ScrollTrigger.getById("sectionsscroll-pin");
    if (st) st.kill();
}
window.destroySectionsscrollGSAP = destroySectionsscrollGSAP;
window.reinitSectionsscrollGSAP = initSectionsscrollGSAP;
if (window.innerWidth >= 1180 && document.querySelector(".sectionsscroll")) {
    ScrollTrigger.config({ autoRefreshEvents: "visibilitychange,DOMContentLoaded,load" });
    initSectionsscrollGSAP();
}




// Initialize Lenis smooth scroll
const lenis = new Lenis();
lenis.on("scroll", (e) => {
    console.log(e);
});
lenis.on("scroll", ScrollTrigger.update);
gsap.ticker.add((time) => {
    lenis.raf(time * 1000); // Convert seconds to milliseconds
});
gsap.ticker.lagSmoothing(0);



//Conver svg into svg code
// document.querySelectorAll('img[src$=".svg"]').forEach(function(img){
//     fetch(img.src)
//     .then(r => r.text())
//     .then(txt => {
//     const svg = new DOMParser().parseFromString(txt, "image/svg+xml").documentElement;
//     svg.classList = img.classList;
//     svg.style = img.style;
//     img.replaceWith(svg);
//     });
// });


// Gallery Animation - Only on min-width 1200px and when gallery exists
// Wrapped in DOMContentLoaded + refresh on load; re-callable on modal close (kill + re-create) so popup close doesn't distort (same as cards-custom-body)
function initGalleryGSAP() {
    if (window.innerWidth < 1200) return;
    const makdmks = document.querySelector(".makdmks");
    const gallery = makdmks ? makdmks.querySelector(".gallery") : null;
    if (!gallery) return;

    gsap.registerPlugin(ScrollTrigger);

    // Kill existing gallery ScrollTriggers so re-call (e.g. after modal close) doesn't duplicate and layout is correct
    if (typeof ScrollTrigger !== "undefined") {
        ScrollTrigger.getAll().forEach(function (st) {
            var id = st.vars && st.vars.id ? String(st.vars.id) : "";
            if (id.indexOf("gallery-section-") === 0 || id === "gallery-pin") {
                st.kill();
            }
        });
    }

    const sections = gsap.utils.toArray(".makdmks .detailsWrapper .details");
    const photos = gsap.utils.toArray(".makdmks .photo");
    if (sections.length === 0 || photos.length === 0) return;

    gsap.set(photos, { opacity: 0 });
    gsap.set(photos[0], { opacity: 1 });

    function showPhoto(index) {
        gsap.to(photos, { opacity: 0, duration: 0.4, overwrite: true });
        gsap.to(photos[index], { opacity: 1, duration: 0.4, overwrite: true });
    }

    sections.forEach((section, index) => {
        ScrollTrigger.create({
            trigger: section,
            start: "top 25%",
            end: "bottom 25%",
            scrub: true,
            onEnter: () => showPhoto(index),
            onEnterBack: () => showPhoto(index),
            invalidateOnRefresh: true,
            id: "gallery-section-" + index
        });
    });

    ScrollTrigger.create({
        trigger: ".makdmks .gallery",
        start: "top 20%",
        endTrigger: ".makdmks .detailsWrapper .details:last-child",
        end: "top 20%",
        pin: ".makdmks .right",
        pinSpacing: false,
        invalidateOnRefresh: true,
        refreshPriority: -1,
        id: "gallery-pin"
    });

    // Refresh on resize (only bind once)
    if (!window._galleryResizeBound) {
        window._galleryResizeBound = true;
        let resizeTimer;
        window.addEventListener("resize", function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (window.innerWidth >= 1200 && typeof ScrollTrigger !== "undefined") {
                    ScrollTrigger.refresh();
                }
            }, 250);
        });
    }

    // Refresh after load so midway-reload shows correct gallery state (same as cards-custom-body)
    if (!window._galleryLoadBound) {
        window._galleryLoadBound = true;
        function refreshGalleryScrollTrigger() {
            if (typeof ScrollTrigger === "undefined") return;
            requestAnimationFrame(function () {
                ScrollTrigger.refresh();
            });
            setTimeout(function () {
                ScrollTrigger.refresh();
            }, 100);
            setTimeout(function () {
                ScrollTrigger.refresh();
            }, 500);
        }
        if (document.readyState === "complete") {
            refreshGalleryScrollTrigger();
        } else {
            window.addEventListener("load", function galleryOnLoad() {
                window.removeEventListener("load", galleryOnLoad);
                refreshGalleryScrollTrigger();
            });
        }
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initGalleryGSAP);
} else {
    initGalleryGSAP();
}





// Card Stacking Animation - Only on min-width 1200px and when cards-custom-body exists
// Wrapped in DOMContentLoaded so DOM (and .card-wrapper) is ready; refreshed on load so midway-reload shows correct state
// Safe to call multiple times (e.g. after modal close): kills existing card triggers before creating new ones
function initCardsCustomBodyGSAP() {
    if (window.innerWidth < 1200) return;
    const cardsCustomBody = document.querySelector(".cards-custom-body");
    if (!cardsCustomBody) return;

    gsap.registerPlugin(ScrollTrigger);

    // Kill existing card ScrollTriggers so re-call (e.g. after modal close) doesn't duplicate
    if (typeof ScrollTrigger !== "undefined") {
        ScrollTrigger.getAll().forEach(function (st) {
            if (st.vars && st.vars.id && String(st.vars.id).indexOf("card-") === 0) {
                st.kill();
            }
        });
    }

    const cardsWrappers = gsap.utils.toArray(".card-wrapper");
    const cards = gsap.utils.toArray(".card_display");
    const totalCards = cards.length;
    if (!totalCards || cardsWrappers.length !== cards.length) return;

    cardsWrappers.forEach((wrapper, i) => {
        const card = cards[i];
        if (!card) return;

        // Calculate reverse index matching CSS reference demo exactly
        const reverseIndex = totalCards - i;
        const targetScale = 1.1 - (0.1 * reverseIndex);

        // Set initial scale (cards start at full size)
        gsap.set(card, {
            scale: 1.0,
            rotation: 0,
            transformOrigin: "top center",
            y: 0,
            x: 0,
            force3D: true,
            zIndex: i
        });

        // Create animation with scale effect
        gsap.to(card, {
            scale: targetScale,
            rotation: 0,
            transformOrigin: "top center",
            y: 0,
            ease: "none",
            immediateRender: true,
            force3D: true,
            scrollTrigger: {
                trigger: wrapper,
                start: "top " + (150 + 50 * i),
                end: "bottom 550",
                endTrigger: ".wrapper",
                scrub: true,
                pin: wrapper,
                pinSpacing: false,
                anticipatePin: 1,
                invalidateOnRefresh: true,
                refreshPriority: 1,
                onEnter: () => {
                    gsap.set(card, { y: 0, x: 0, rotation: 0, force3D: true });
                },
                onEnterBack: () => {
                    gsap.set(card, { y: 0, x: 0, rotation: 0, force3D: true });
                },
                id: "card-" + (i + 1)
            }
        });
    });

    // Refresh on resize (only bind once to avoid duplicate listeners on re-init)
    if (!window._cardsCustomBodyResizeBound) {
        window._cardsCustomBodyResizeBound = true;
        let resizeTimer;
        window.addEventListener("resize", function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (window.innerWidth >= 1200 && typeof ScrollTrigger !== "undefined") {
                    ScrollTrigger.refresh();
                }
            }, 250);
        });
    }

    // Critical: refresh after load so midway-reload (restored scroll) shows correct card state (only on first init)
    function refreshCardsScrollTrigger() {
        if (typeof ScrollTrigger === "undefined") return;
        requestAnimationFrame(function () {
            ScrollTrigger.refresh();
        });
        setTimeout(function () {
            ScrollTrigger.refresh();
        }, 100);
        setTimeout(function () {
            ScrollTrigger.refresh();
        }, 500);
    }
    if (!window._cardsCustomBodyLoadBound) {
        window._cardsCustomBodyLoadBound = true;
        if (document.readyState === "complete") {
            refreshCardsScrollTrigger();
        } else {
            window.addEventListener("load", function cardsOnLoad() {
                window.removeEventListener("load", cardsOnLoad);
                refreshCardsScrollTrigger();
            });
        }
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCardsCustomBodyGSAP);
} else {
    initCardsCustomBodyGSAP();
}




// if (document.querySelector(".hz-slider-section .swiper")) {
//   // Store reference to ScrollTrigger instance for cleanup
//   let hzScrollTrigger = null;
//   let hzTimeline = null;
//   let currentSlide = 0;
  
//   const hzSwiper = new Swiper(".hz-slider-section .swiper", {
//     // autoplay: {
//     //   delay: 5000,
//     //   disableOnInteraction: false
//     // },
//     speed: 2000,
//     loop: false,
//     slidesPerView: 1.1,
//     spaceBetween: 30,
//     loopAddBlankSlides: false,
//     slideToClickedSlide: true,
//     centeredSlides: false,
//     // Enable touch move on mobile, disable on desktop (will be controlled by GSAP)
//     allowTouchMove: window.innerWidth < 1024,
//     // Add smooth easing for transitions
//     effect: 'slide',
//     resistance: true,
//     resistanceRatio: 0.85,
//     breakpoints: {
//       580: {
//         slidesPerView: 1.1,
//         spaceBetween: 30
//       },
//       768: {
//         slidesPerView: 1.2,
//         spaceBetween: 30
//       },
//       1024: {
//         slidesPerView: 1.5,
//         spaceBetween: 30
//       },
//       1280: {
//         slidesPerView: 2.3,
//         spaceBetween: 30
//       }
//     }
//   });
  
//   hzSwiper.slideTo(0);
  
//   // Function to apply correct slidesPerView based on window width
//   function applyCorrectSlidesPerView() {
//     const width = window.innerWidth;
//     let slidesPerView = 1.1;
    
//     if (width >= 1280) {
//       slidesPerView = 2.3;
//     } else if (width >= 1024) {
//       slidesPerView = 1.5;
//     } else if (width >= 768) {
//       slidesPerView = 1.2;
//     } else {
//       slidesPerView = 1.1;
//     }
    
//     // Only update if the value has changed
//     if (hzSwiper.params.slidesPerView !== slidesPerView) {
//       hzSwiper.params.slidesPerView = slidesPerView;
//       hzSwiper.update();
//     }
//   }
  
//   // Apply correct slidesPerView immediately and after a short delay
//   applyCorrectSlidesPerView();
//   setTimeout(function() {
//     applyCorrectSlidesPerView();
//   }, 100);
  
//   // Function to initialize GSAP pin animation (desktop only)
//   function initHzSliderGSAP() {
//     // Only initialize if screen width is 1024px or above
//     if (window.innerWidth < 1024) {
//       return;
//     }
    
//     // Register GSAP plugin
//     gsap.registerPlugin(ScrollTrigger);
    
//     const totalSlides = hzSwiper.slides.length;
//     const maxIndex = Math.max(0, totalSlides - 1);
//     if (maxIndex === 0) return;
//     const snap = gsap.utils.snap(1 / maxIndex);
    
//     // Calculate scroll distance based on number of slides (150vh per slide for slower scroll)
//     const scrollDistance = totalSlides * 300;
    
//     // Disable Swiper touch on desktop (controlled by scroll)
//     hzSwiper.allowTouchMove = false;
//     // Apply correct slidesPerView based on screen size
//     applyCorrectSlidesPerView();
    
//     hzTimeline = gsap.timeline({
//       scrollTrigger: {
//         trigger: ".hz-slider-section .slider",
//         pin: ".hz-slider-section",
//         pinSpacing: true,
//         pinReparent: false, // Changed to false to prevent DOM reparenting issues
//         start: "top 15%",
//         end: "+=" + scrollDistance + "vh", // Dynamic based on slides
//         scrub: 2, // Increased from true to 2 for smoother, slower scroll response
//         markers: false,
//         invalidateOnRefresh: true,
//         refreshPriority: 2, // Higher priority than gallery
//         id: "hz-slider-pin",
//         onUpdate: (self) => {
//           let updatedIndex = Math.round(snap(self.progress) * maxIndex);
//           updatedIndex = Math.max(0, Math.min(updatedIndex, maxIndex));
//           if (updatedIndex !== currentSlide) {
//             currentSlide = updatedIndex;
//             hzSwiper.slideTo(currentSlide, 2000); // Use slower speed for programmatic slide changes
//           }
//         }
//       }
//     });
    
//     // Store reference for cleanup
//     hzScrollTrigger = hzTimeline.scrollTrigger;
//   }
  
//   // Function to destroy GSAP pin animation (for mobile)
//   function destroyHzSliderGSAP() {
//     if (hzScrollTrigger) {
//       hzScrollTrigger.kill();
//       hzScrollTrigger = null;
//     }
//     if (hzTimeline) {
//       hzTimeline.kill();
//       hzTimeline = null;
//     }
    
//     // Enable Swiper touch on mobile
//     hzSwiper.allowTouchMove = true;
//     hzSwiper.update();
    
//     // Reset slide position
//     currentSlide = 0;
//     hzSwiper.slideTo(0);
//   }
  
//   // Initialize on page load
//   initHzSliderGSAP();
  
//   // Destroy-only: call when modal opens so pin-spacers are removed before body is fixed (prevents layout distortion)
//   window.destroyHzSliderSectionGSAP = destroyHzSliderGSAP;
//   // Re-init GSAP pin after popup close (same as cards/gallery: destroy + create so layout is correct)
//   window.reinitHzSliderSectionGSAP = function () {
//     if (window.innerWidth >= 1024) {
//       destroyHzSliderGSAP();
//       initHzSliderGSAP();
//     }
//   };
//   // Sync hz-slider-section Swiper to current scroll position (call after reinit + refresh)
//   window.syncHzSliderSectionToScroll = function () {
//     if (typeof ScrollTrigger === "undefined" || window.innerWidth < 1024) return;
//     var st = ScrollTrigger.getById("hz-slider-pin");
//     if (!st || !hzSwiper.slides.length) return;
//     var totalSlides = hzSwiper.slides.length;
//     var maxIndex = Math.max(0, totalSlides - 1);
//     if (maxIndex === 0) return;
//     var snap = gsap.utils.snap(1 / maxIndex);
//     var idx = Math.round(snap(st.progress) * maxIndex);
//     idx = Math.max(0, Math.min(idx, maxIndex));
//     currentSlide = idx;
//     hzSwiper.slideTo(idx, 0);
//   };

//   // Handle resize - enable/disable GSAP pin based on screen width
//   let hzResizeTimer;
//   window.addEventListener("resize", function() {
//     clearTimeout(hzResizeTimer);
//     hzResizeTimer = setTimeout(function() {
//       // Update Swiper to apply breakpoint changes
//       applyCorrectSlidesPerView();
      
//       const isDesktop = window.innerWidth >= 1024;
//       const hasGSAP = hzScrollTrigger !== null;
      
//       if (isDesktop && !hasGSAP) {
//         // Switched to desktop - initialize GSAP pin
//         initHzSliderGSAP();
//       } else if (!isDesktop && hasGSAP) {
//         // Switched to mobile - destroy GSAP pin
//         destroyHzSliderGSAP();
//       } else if (isDesktop && hasGSAP) {
//         // Still on desktop - refresh ScrollTrigger
//         ScrollTrigger.refresh();
//       }
//     }, 250);
//   });

//   // Refresh after load so midway-reload shows correct hz-slider-section state (same as gallery / cards)
//   if (!window._hzSliderSectionLoadBound) {
//     window._hzSliderSectionLoadBound = true;
//     function refreshHzSliderSectionScrollTrigger() {
//       if (typeof ScrollTrigger === "undefined") return;
//       requestAnimationFrame(function () {
//         ScrollTrigger.refresh();
//       });
//       setTimeout(function () {
//         ScrollTrigger.refresh();
//       }, 100);
//       setTimeout(function () {
//         ScrollTrigger.refresh();
//       }, 500);
//     }
//     if (document.readyState === "complete") {
//       refreshHzSliderSectionScrollTrigger();
//     } else {
//       window.addEventListener("load", function hzSliderSectionOnLoad() {
//         window.removeEventListener("load", hzSliderSectionOnLoad);
//         refreshHzSliderSectionScrollTrigger();
//       });
//     }
//   }
// }

// Horizontal Slider Topcaption (unique instance - no conflict with hz-slider-section)
// Excludes energyswiper so energy widget gets its own config
// if (document.querySelector(".hz-slider-topcaption .swiper:not(.energyswiper)")) {
//   // Store reference to ScrollTrigger instance for cleanup
//   let hzTopcaptionScrollTrigger = null;
//   let hzTopcaptionTimeline = null;
//   let currentTopcaptionSlide = 0;
  
//   const hzTopcaptionSwiper = new Swiper(".hz-slider-topcaption .swiper:not(.energyswiper)", {
//     speed: 2000,
//     loop: false,
//     slidesPerView: 1.1,
//     spaceBetween: 30,
//     loopAddBlankSlides: false,
//     slideToClickedSlide: true,
//     centeredSlides: false,
//     // Enable touch move on mobile, disable on desktop (will be controlled by GSAP)
//     allowTouchMove: window.innerWidth < 1024,
//     // Add smooth easing for transitions
//     effect: 'slide',
//     resistance: true,
//     resistanceRatio: 0.85,
//     breakpoints: {
//       580: {
//         slidesPerView: 1.1,
//         spaceBetween: 30
//       },
//       768: {
//         slidesPerView: 1.2,
//         spaceBetween: 30
//       },
//       1024: {
//         slidesPerView: 1.5,
//         spaceBetween: 30
//       },
//       1280: {
//         slidesPerView: 4.1,
//         spaceBetween: 30
//       }
//     }
//   });
  
//   hzTopcaptionSwiper.slideTo(0);
  
//   // Function to apply correct slidesPerView based on window width
//   function applyCorrectTopcaptionSlidesPerView() {
//     const width = window.innerWidth;
//     let slidesPerView = 1.1;
    
//     if (width >= 1280) {
//       slidesPerView = 4.1;
//     } else if (width >= 1024) {
//       slidesPerView = 1.5;
//     } else if (width >= 768) {
//       slidesPerView = 1.2;
//     } else {
//       slidesPerView = 1.1;
//     }
    
//     // Only update if the value has changed
//     if (hzTopcaptionSwiper.params.slidesPerView !== slidesPerView) {
//       hzTopcaptionSwiper.params.slidesPerView = slidesPerView;
//       hzTopcaptionSwiper.update();
//     }
//   }
  
//   // Apply correct slidesPerView immediately and after a short delay
//   applyCorrectTopcaptionSlidesPerView();
//   setTimeout(function() {
//     applyCorrectTopcaptionSlidesPerView();
//   }, 100);
  
//   // Function to initialize GSAP pin animation (desktop only)
//   function initHzTopcaptionGSAP() {
//     // Only initialize if screen width is 1024px or above
//     if (window.innerWidth < 1024) {
//       return;
//     }
    
//     // Register GSAP plugin
//     gsap.registerPlugin(ScrollTrigger);
    
//     const totalSlides = hzTopcaptionSwiper.slides.length;
//     const maxIndex = Math.max(0, totalSlides - 1);
//     if (maxIndex === 0) return;
//     const snap = gsap.utils.snap(1 / maxIndex);
    
//     // Calculate scroll distance based on number of slides (150vh per slide for slower scroll)
//     const scrollDistance = totalSlides * 300;
    
//     // Disable Swiper touch on desktop (controlled by scroll)
//     hzTopcaptionSwiper.allowTouchMove = false;
//     // Apply correct slidesPerView based on screen size
//     applyCorrectTopcaptionSlidesPerView();
    
//     hzTopcaptionTimeline = gsap.timeline({
//       scrollTrigger: {
//         trigger: ".hz-slider-topcaption .slider",
//         pin: ".hz-slider-topcaption",
//         pinSpacing: true,
//         pinReparent: false, // Changed to false to prevent DOM reparenting issues
//         start: "top 20%",
//         end: "+=" + scrollDistance + "vh",
//         scrub: 2, // Increased from true to 2 for smoother, slower scroll response
//         markers: false,
//         invalidateOnRefresh: true,
//         refreshPriority: 1,
//         id: "hz-slider-topcaption-pin",
//         onUpdate: (self) => {
//           let updatedIndex = Math.round(snap(self.progress) * maxIndex);
//           updatedIndex = Math.max(0, Math.min(updatedIndex, maxIndex));
//           if (updatedIndex !== currentTopcaptionSlide) {
//             currentTopcaptionSlide = updatedIndex;
//             hzTopcaptionSwiper.slideTo(currentTopcaptionSlide, 2000); // Use slower speed for programmatic slide changes
//           }
//         }
//       }
//     });
    
//     // Store reference for cleanup
//     hzTopcaptionScrollTrigger = hzTopcaptionTimeline.scrollTrigger;
//   }
  
//   // Function to destroy GSAP pin animation (for mobile)
//   function destroyHzTopcaptionGSAP() {
//     if (hzTopcaptionScrollTrigger) {
//       hzTopcaptionScrollTrigger.kill();
//       hzTopcaptionScrollTrigger = null;
//     }
//     if (hzTopcaptionTimeline) {
//       hzTopcaptionTimeline.kill();
//       hzTopcaptionTimeline = null;
//     }
    
//     // Enable Swiper touch on mobile
//     hzTopcaptionSwiper.allowTouchMove = true;
//     hzTopcaptionSwiper.update();
    
//     // Reset slide position
//     currentTopcaptionSlide = 0;
//     hzTopcaptionSwiper.slideTo(0);
//   }
  
//   // Initialize on page load
//   initHzTopcaptionGSAP();
  
//   // Destroy-only: call when modal opens so pin-spacers are removed before body is fixed (prevents layout distortion)
//   window.destroyHzSliderTopcaptionGSAP = destroyHzTopcaptionGSAP;
//   // Re-init GSAP pin after popup close (same as cards/gallery: destroy + create so layout is correct)
//   window.reinitHzSliderTopcaptionGSAP = function () {
//     if (window.innerWidth >= 1024) {
//       destroyHzTopcaptionGSAP();
//       initHzTopcaptionGSAP();
//     }
//   };
//   // Sync hz-slider-topcaption Swiper to current scroll position (call after reinit + refresh)
//   window.syncHzSliderTopcaptionToScroll = function () {
//     if (typeof ScrollTrigger === "undefined" || window.innerWidth < 1024) return;
//     var st = ScrollTrigger.getById("hz-slider-topcaption-pin");
//     if (!st || !hzTopcaptionSwiper.slides.length) return;
//     var totalSlides = hzTopcaptionSwiper.slides.length;
//     var maxIndex = Math.max(0, totalSlides - 1);
//     if (maxIndex === 0) return;
//     var snap = gsap.utils.snap(1 / maxIndex);
//     var idx = Math.round(snap(st.progress) * maxIndex);
//     idx = Math.max(0, Math.min(idx, maxIndex));
//     currentTopcaptionSlide = idx;
//     hzTopcaptionSwiper.slideTo(idx, 0);
//   };

//   // Handle resize - enable/disable GSAP pin based on screen width
//   let hzTopcaptionResizeTimer;
//   window.addEventListener("resize", function() {
//     clearTimeout(hzTopcaptionResizeTimer);
//     hzTopcaptionResizeTimer = setTimeout(function() {
//       // Update Swiper to apply breakpoint changes
//       applyCorrectTopcaptionSlidesPerView();
      
//       const isDesktop = window.innerWidth >= 1024;
//       const hasGSAP = hzTopcaptionScrollTrigger !== null;
      
//       if (isDesktop && !hasGSAP) {
//         // Switched to desktop - initialize GSAP pin
//         initHzTopcaptionGSAP();
//       } else if (!isDesktop && hasGSAP) {
//         // Switched to mobile - destroy GSAP pin
//         destroyHzTopcaptionGSAP();
//       } else if (isDesktop && hasGSAP) {
//         // Still on desktop - refresh ScrollTrigger
//         ScrollTrigger.refresh();
//       }
//     }, 250);
//   });

//   // Refresh after load so midway-reload shows correct hz-slider-topcaption state (same as gallery / cards)
//   if (!window._hzSliderTopcaptionLoadBound) {
//     window._hzSliderTopcaptionLoadBound = true;
//     function refreshHzSliderTopcaptionScrollTrigger() {
//       if (typeof ScrollTrigger === "undefined") return;
//       requestAnimationFrame(function () {
//         ScrollTrigger.refresh();
//       });
//       setTimeout(function () {
//         ScrollTrigger.refresh();
//       }, 100);
//       setTimeout(function () {
//         ScrollTrigger.refresh();
//       }, 500);
//     }
//     if (document.readyState === "complete") {
//       refreshHzSliderTopcaptionScrollTrigger();
//     } else {
//       window.addEventListener("load", function hzSliderTopcaptionOnLoad() {
//         window.removeEventListener("load", hzSliderTopcaptionOnLoad);
//         refreshHzSliderTopcaptionScrollTrigger();
//       });
//     }
//   }
// }

// Horizontal Slider Energy (3.1 slides on desktop vs 4.1 for topcaption)
// if (document.querySelector(".hz-slider-energy .energyswiper")) {
//   let hzEnergyScrollTrigger = null;
//   let hzEnergyTimeline = null;
//   let currentEnergySlide = 0;

//   const hzEnergySwiper = new Swiper(".hz-slider-energy .energyswiper", {
//     speed: 2000,
//     loop: false,
//     slidesPerView: 1.1,
//     spaceBetween: 30,
//     loopAddBlankSlides: false,
//     slideToClickedSlide: true,
//     centeredSlides: false,
//     allowTouchMove: window.innerWidth < 1024,
//     effect: 'slide',
//     resistance: true,
//     resistanceRatio: 0.85,
//     breakpoints: {
//       580: { slidesPerView: 1.1, spaceBetween: 30 },
//       768: { slidesPerView: 1.2, spaceBetween: 30 },
//       1024: { slidesPerView: 1.5, spaceBetween: 30 },
//       1280: { slidesPerView: 3.1, spaceBetween: 30 }
//     }
//   });

//   hzEnergySwiper.slideTo(0);

//   function applyCorrectEnergySlidesPerView() {
//     const width = window.innerWidth;
//     let slidesPerView = 1.1;
//     if (width >= 1280) slidesPerView = 3.1;
//     else if (width >= 1024) slidesPerView = 1.5;
//     else if (width >= 768) slidesPerView = 1.2;
//     else slidesPerView = 1.1;
//     if (hzEnergySwiper.params.slidesPerView !== slidesPerView) {
//       hzEnergySwiper.params.slidesPerView = slidesPerView;
//       hzEnergySwiper.update();
//     }
//   }
//   applyCorrectEnergySlidesPerView();
//   setTimeout(applyCorrectEnergySlidesPerView, 100);

//   function initHzEnergyGSAP() {
//     if (window.innerWidth < 1024) return;
//     gsap.registerPlugin(ScrollTrigger);
//     const totalSlides = hzEnergySwiper.slides.length;
//     const maxIndex = Math.max(0, totalSlides - 1);
//     if (maxIndex === 0) return;
//     const snap = gsap.utils.snap(1 / maxIndex);
//     const scrollDistance = totalSlides * 300;
//     hzEnergySwiper.allowTouchMove = false;
//     applyCorrectEnergySlidesPerView();
//     hzEnergyTimeline = gsap.timeline({
//       scrollTrigger: {
//         trigger: ".hz-slider-energy .slider",
//         pin: ".hz-slider-energy",
//         pinSpacing: true,
//         pinReparent: false,
//         start: "top 15%",
//         end: "+=" + scrollDistance + "vh",
//         scrub: 2,
//         markers: false,
//         invalidateOnRefresh: true,
//         refreshPriority: 2,
//         id: "hz-slider-energy-pin",
//         onUpdate: (self) => {
//           let updatedIndex = Math.round(snap(self.progress) * maxIndex);
//           updatedIndex = Math.max(0, Math.min(updatedIndex, maxIndex));
//           if (updatedIndex !== currentEnergySlide) {
//             currentEnergySlide = updatedIndex;
//             hzEnergySwiper.slideTo(currentEnergySlide, 2000);
//           }
//         }
//       }
//     });
//     hzEnergyScrollTrigger = hzEnergyTimeline.scrollTrigger;
//   }

//   function destroyHzEnergyGSAP() {
//     if (hzEnergyScrollTrigger) { hzEnergyScrollTrigger.kill(); hzEnergyScrollTrigger = null; }
//     if (hzEnergyTimeline) { hzEnergyTimeline.kill(); hzEnergyTimeline = null; }
//     hzEnergySwiper.allowTouchMove = true;
//     hzEnergySwiper.update();
//     currentEnergySlide = 0;
//     hzEnergySwiper.slideTo(0);
//   }

//   initHzEnergyGSAP();
//   window.destroyHzSliderEnergyGSAP = destroyHzEnergyGSAP;
//   window.reinitHzSliderEnergyGSAP = function () {
//     if (window.innerWidth >= 1024) { destroyHzEnergyGSAP(); initHzEnergyGSAP(); }
//   };
//   window.syncHzSliderEnergyToScroll = function () {
//     if (typeof ScrollTrigger === "undefined" || window.innerWidth < 1024) return;
//     var st = ScrollTrigger.getById("hz-slider-energy-pin");
//     if (!st || !hzEnergySwiper.slides.length) return;
//     var totalSlides = hzEnergySwiper.slides.length;
//     var maxIndex = Math.max(0, totalSlides - 1);
//     if (maxIndex === 0) return;
//     var snap = gsap.utils.snap(1 / maxIndex);
//     var idx = Math.round(snap(st.progress) * maxIndex);
//     idx = Math.max(0, Math.min(idx, maxIndex));
//     currentEnergySlide = idx;
//     hzEnergySwiper.slideTo(idx, 0);
//   };

//   let hzEnergyResizeTimer;
//   window.addEventListener("resize", function () {
//     clearTimeout(hzEnergyResizeTimer);
//     hzEnergyResizeTimer = setTimeout(function () {
//       applyCorrectEnergySlidesPerView();
//       hzEnergySwiper.update();
//       const isDesktop = window.innerWidth >= 1024;
//       const hasGSAP = hzEnergyScrollTrigger !== null;
//       if (isDesktop && !hasGSAP) initHzEnergyGSAP();
//       else if (!isDesktop && hasGSAP) destroyHzEnergyGSAP();
//       else if (isDesktop && hasGSAP) ScrollTrigger.refresh();
//     }, 250);
//   });

//   if (!window._hzSliderEnergyLoadBound) {
//     window._hzSliderEnergyLoadBound = true;
//     function refreshHzEnergyScrollTrigger() {
//       if (typeof ScrollTrigger === "undefined") return;
//       requestAnimationFrame(function () { ScrollTrigger.refresh(); });
//       setTimeout(function () { ScrollTrigger.refresh(); }, 100);
//       setTimeout(function () { ScrollTrigger.refresh(); }, 500);
//     }
//     if (document.readyState === "complete") refreshHzEnergyScrollTrigger();
//     else window.addEventListener("load", function handler() { window.removeEventListener("load", handler); refreshHzEnergyScrollTrigger(); });
//   }
// }

// Global ScrollTrigger refresh after all triggers are initialized
// This ensures all ScrollTriggers are properly calculated relative to each other
// if (typeof ScrollTrigger !== 'undefined' && window.innerWidth >= 1024) {
//     // Wait for DOM to be fully ready and all triggers to be created
//     window.addEventListener('load', function() {
//         setTimeout(function() {
//             ScrollTrigger.refresh();
//         }, 500);
//     });
// }



const sliderWrapper = document.querySelector('.purpose-slider-wrapper');
const prevButton = document.querySelector('.swiper-horizontalmobile-prev');

if (sliderWrapper && prevButton) {
    const observer = new MutationObserver(() => {
        if (prevButton.classList.contains('swiper-button-disabled')) {
            sliderWrapper.classList.add('hide-after');
        } else {
            sliderWrapper.classList.remove('hide-after');
        }
    });

    // Observe class changes
    observer.observe(prevButton, { attributes: true, attributeFilter: ['class'] });
}
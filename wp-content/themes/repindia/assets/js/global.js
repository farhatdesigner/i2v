document.addEventListener("DOMContentLoaded", function () {

    // Function to update image sources based on theme
    function updateThemeImages(isDark) {
        const themeImageDivs = document.querySelectorAll('.theme-img');
        themeImageDivs.forEach(div => {
            const img = div.querySelector('img');
            const lightSrc = div.getAttribute('data-light');
            const darkSrc = div.getAttribute('data-dark');

            if (img && lightSrc && darkSrc) {
                img.src = isDark ? darkSrc : lightSrc;
            }
        });
    }

    // Check saved preference or system preference
    const storedPref = localStorage.getItem('dark-mode');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDarkMode = storedPref === 'dark' || (!storedPref && prefersDark);

    // Apply correct image on page load
    updateThemeImages(isDarkMode);

    // Watch for toggle button clicks (already exists)
    const toggleBtn = document.querySelector('.dark-mode-toggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isDark = document.body.classList.toggle('js-dark');
            localStorage.setItem('dark-mode', isDark ? 'dark' : 'light');
            updateThemeImages(isDark);
        });
    }
});


// HERO SLIDER
jQuery(document).ready(function ($) {
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

                // Update countdown number
                countdownElement.textContent = `${Math.ceil(timeLeft)}`;

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
                progressContent.textContent = `${Math.ceil(timeLeft)}`;

                if (timeLeft <= 0) {
                    clearInterval(circularInterval);
                }
            }, 100);
        }
    }

    var swiperOptions = {
        loop: true,
        speed: 1000,
        parallax: true,
        autoplay: {
            delay: 6500,
            disableOnInteraction: false,
        },
        watchSlidesProgress: true,
        pagination: {
            el: '.hero-swiper-container .swiper-pagination',
            clickable: true,
        },

        navigation: {
            nextEl: '.hero-swiper-container .swiper-button-next',
            prevEl: '.hero-swiper-container .swiper-button-prev',
        },


        on: {
            progress: function () {
                var swiper = this;
                for (var i = 0; i < swiper.slides.length; i++) {
                    var slideProgress = swiper.slides[i].progress;
                    var innerOffset = swiper.width * interleaveOffset;
                    var innerTranslate = slideProgress * innerOffset;
                    swiper.slides[i].querySelector(".hero-slide-inner").style.transform =
                        "translate3d(" + innerTranslate + "px, 0, 0)";
                }
            },

            touchStart: function () {
                var swiper = this;
                for (var i = 0; i < swiper.slides.length; i++) {
                    swiper.slides[i].style.transition = "";
                }
            },

            setTransition: function (speed) {
                var swiper = this;
                for (var i = 0; i < swiper.slides.length; i++) {
                    swiper.slides[i].style.transition = speed + "ms";
                    swiper.slides[i].querySelector(".hero-slide-inner").style.transition =
                        speed + "ms";
                }
            },

            autoplayStart: function () {
                // Start progress animation when autoplay starts
                startProgressAnimation();
            },

            slideChange: function () {
                // Restart progress animation on each slide change
                startProgressAnimation();
            },

            init: function () {
                // Start progress animation on initial load
                startProgressAnimation();
            }
        }
    };

    // Use Swiper 4.5.1 reference on homepage to avoid Elementor's Swiper 8 conflict
    // window.SwiperV4 is saved before Elementor loads its Swiper 8
    var SwiperConstructor = (typeof window.SwiperV4 !== 'undefined') ? window.SwiperV4 : Swiper;
    var swiper = new SwiperConstructor(".hero-swiper-container", swiperOptions);

    // DATA BACKGROUND IMAGE
    var sliderBgSetting = $(".hero-swiper-container .slide-bg-image");
    sliderBgSetting.each(function (indx) {
        if ($(this).attr("data-background")) {
            $(this).css("background-image", "url(" + $(this).data("background") + ")");
        }
    });
});

$(document).ready(function () {
    var scrollPosition = 0;
    var isMenuOpen = false;

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
        
        // Restore body styles
        $("body").css({
            "overflow": "",
            "position": "",
            "top": "",
            "width": ""
        });
        
        // Restore scroll position
        $(window).scrollTop(scrollPosition);
        
        isMenuOpen = false;
    }

    // Open menu when burger icon is clicked
    $(".burger-icon").click(function () {
        // Save current scroll position
        scrollPosition = $(window).scrollTop();
        
        $(this).addClass("active-burger");
        $(".toggle-menu-container").addClass("open-menu");
        $("nav").addClass("overlaynav-active");
        $(".overlay").addClass("overlay-active");
        
        // Lock body scroll using position fixed
        $("body").css({
            "overflow": "hidden",
            "position": "fixed",
            "top": "-" + scrollPosition + "px",
            "width": "100%"
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

    $(document).on('click', '.tabsautoscroll li', function () {
        var $this = $(this);
        var t = $this.data("id"); // e.g., "content0", "content1", etc.
        var tabsContainer = $(".tabsautoscroll");

        // Handle scroll arrows
        $this.is(":last-child") ? $(".next").hide() : $(".next").show();
        $this.is(":first-child") ? $(".previous").hide() : $(".previous").show();

        // Scroll tabs horizontally to center the clicked tab
        var tabPosition = $this.position().left;
        var tabWidth = $this.outerWidth();
        var containerWidth = tabsContainer.width();
        var currentScroll = tabsContainer.scrollLeft();

        // Calculate scroll position to center the tab
        var targetScroll = currentScroll + tabPosition - (containerWidth / 2) + (tabWidth / 2);

        // Use jQuery animate for smooth scrolling
        tabsContainer.stop().animate({ scrollLeft: targetScroll }, 300, 'swing');

        // Toggle class only, no .show() or .hide()
        $(".tabContent .tabdiv").removeClass("active-tabcontent");
        $(".tabContent .tabdiv." + t).addClass("active-tabcontent");

        // Active tab styling
        $(".tabsautoscroll li").removeClass("active");
        $this.addClass("active");
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
});


// Footer Accordion - Mobile Only (max-width: 767px)
jQuery(document).ready(function ($) {
    function handleFooterAccordion() {
        // Only enable accordion on mobile (767px and below)
        if ($(window).width() <= 767) {
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


$(window).scroll(function() {
    if ($(window).scrollTop() >= 1800) {
        $('.sticky-custom').addClass('fixed-header');
    } else {
        $('.sticky-custom').removeClass('fixed-header');
    }
});

$(".sticky-custom ul.elementor-icon-list-items.elementor-inline-items li.elementor-icon-list-item.elementor-inline-item:nth-child(1)").click(function () {
    $("html , body").animate({
        scrollTop: $(".live_monitoring").offset().top - 80
    }, 1300);
});
$(".sticky-custom ul.elementor-icon-list-items.elementor-inline-items li.elementor-icon-list-item.elementor-inline-item:nth-child(2)").click(function () {
    $("html , body").animate({
        scrollTop: $(".system_setup").offset().top - 50
    }, 1300);
});
$(".sticky-custom ul.elementor-icon-list-items.elementor-inline-items li.elementor-icon-list-item.elementor-inline-item:nth-child(3)").click(function () {
    $("html , body").animate({
        scrollTop: $(".intelligenc_alerts").offset().top - 80
    }, 1300);
});
$(".sticky-custom ul.elementor-icon-list-items.elementor-inline-items li.elementor-icon-list-item.elementor-inline-item:nth-child(4)").click(function () {
    $("html , body").animate({
        scrollTop: $(".recording_storage").offset().top - 80
    }, 1300);
});
$(".sticky-custom ul.elementor-icon-list-items.elementor-inline-items li.elementor-icon-list-item.elementor-inline-item:nth-child(5)").click(function () {
    $("html , body").animate({
        scrollTop: $(".security_integration").offset().top - 80
    }, 1300);
});

// Set first li as active by default and setup scroll spy
jQuery(document).ready(function($) {
    var $listItems = $(".sticky-custom ul.elementor-icon-list-items.elementor-inline-items li.elementor-icon-list-item.elementor-inline-item");
    
    // Check if elements exist
    if ($listItems.length === 0) {
        return;
    }
    
    // Set first li as active by default
    $listItems.first().addClass("active-li");
    
    var sections = [
        { selector: ".live_monitoring", index: 0 },
        { selector: ".system_setup", index: 1 },
        { selector: ".intelligenc_alerts", index: 2 },
        { selector: ".recording_storage", index: 3 },
        { selector: ".security_integration", index: 4 }
    ];

    function updateActiveSection() {
        var scrollTop = $(window).scrollTop();
        var offset = 150; // Offset from top to trigger active state
        var activeIndex = 0; // Default to first section

        // Find which section is currently in view or closest to viewport top
        var currentScrollPosition = scrollTop + offset;
        var closestSection = null;
        var closestDistance = Infinity;

        sections.forEach(function(section) {
            var $section = $(section.selector);
            if ($section.length) {
                var sectionTop = $section.offset().top;
                var sectionBottom = sectionTop + $section.outerHeight();
                
                // Check if section is in viewport
                if (currentScrollPosition >= sectionTop && currentScrollPosition < sectionBottom) {
                    var distance = Math.abs(currentScrollPosition - sectionTop);
                    if (distance < closestDistance) {
                        closestDistance = distance;
                        closestSection = section;
                    }
                }
            }
        });

        // If no section is directly in view, find the last section we've scrolled past
        if (!closestSection) {
            sections.forEach(function(section) {
                var $section = $(section.selector);
                if ($section.length) {
                    var sectionTop = $section.offset().top;
                    if (currentScrollPosition >= sectionTop) {
                        closestSection = section;
                    }
                }
            });
        }

        // Update active class
        if (closestSection !== null) {
            activeIndex = closestSection.index;
        } else if (scrollTop < 1800) {
            // If scrolled back to top, activate first item
            activeIndex = 0;
        }

        $listItems.removeClass("active-li");
        $listItems.eq(activeIndex).addClass("active-li");
    }

    // Throttle scroll event for better performance
    var scrollTimeout;
    $(window).on('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            updateActiveSection();
        }, 50);
    });

    // Initial check on page load
    updateActiveSection();
});

jQuery(document).ready(function() {
    // Check if accordion exists on the page
    if (jQuery('.accordion_set').length === 0) {
        return;
    }

    // open first section by default
    let first = jQuery('.accordion_set').first();
    first.addClass('acactive');
    first.find('.select_div').attr("aria-expanded", "true");
    jQuery(".accontent").first().slideDown(200);

    // Initialize videos - show first video, hide others using opacity
    jQuery('.accordion_video').each(function(index) {
        if (index === 0) {
            jQuery(this).addClass('active');
        } else {
            jQuery(this).removeClass('active');
        }
    });

    // setup variables
    let autoIndex = 0;
    let total = jQuery(".accordion_set").length;
    let autoInterval = 4000; // 4 seconds
    let timer;
    let isPaused = false; // Track if auto-slide is paused
    let resumeTimeout = null; // Store resume timeout so we can cancel it

    // Helper function to check if any modal is currently open
    function isModalOpen() {
        return jQuery('.modal.show, .modal.in').length > 0 || jQuery('body').hasClass('modal-open');
    }

    // function to switch video by index using opacity transitions
    function switchVideo(index) {
        jQuery('.accordion_video').each(function(videoIndex) {
            if (videoIndex === index) {
                jQuery(this).addClass('active');
            } else {
                jQuery(this).removeClass('active');
            }
        });
    }

    // function to open accordion by index
    function openAccordion(index) {
        let target = jQuery(".accordion_set").eq(index);
        jQuery(".accordion_set").removeClass("acactive");
        jQuery(".accordion_set > .select_div").attr("aria-expanded", "false");
        jQuery(".accontent").slideUp(200);

        target.addClass("acactive");
        target.find(".select_div").attr("aria-expanded", "true");
        target.find(".accontent").slideDown(200);

        // Switch to corresponding video
        switchVideo(index);
    }

    // auto slide function
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

    // pause auto slide function
    function pauseAutoSlide() {
        isPaused = true;
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
        // Cancel any pending resume timeout
        if (resumeTimeout) {
            clearTimeout(resumeTimeout);
            resumeTimeout = null;
        }
    }

    // resume auto slide function
    function resumeAutoSlide() {
        // Don't resume if modal is open
        if (isModalOpen()) {
            return;
        }
        isPaused = false;
        if (!timer) {
            startAutoSlide();
        }
    }

    // start auto slide initially
    startAutoSlide();

    // on click — manual control + reset timer
    jQuery(".accordion_set > .select_div").click(function() {
        pauseAutoSlide(); // pause auto slide

        let parent = jQuery(this).parents('.accordion_set');
        autoIndex = jQuery(".accordion_set").index(parent); // update index

        if (parent.hasClass("acactive")) {
            parent.removeClass("acactive");
            jQuery(this).attr("aria-expanded", "false");
            parent.find(".accontent").slideUp(200);
        } else {
            openAccordion(autoIndex);
        }

        // Cancel any existing resume timeout
        if (resumeTimeout) {
            clearTimeout(resumeTimeout);
        }

        // restart auto slide after short delay, but only if modal is not open
        resumeTimeout = setTimeout(function() {
            resumeTimeout = null;
            if (!isModalOpen()) {
                resumeAutoSlide();
            }
        }, 1000);
    });

    // Pause accordion when modal opens
    jQuery(document).on('show.bs.modal', '.modal', function() {
        pauseAutoSlide();
    });

    // Resume accordion when modal closes
    jQuery(document).on('hidden.bs.modal', '.modal', function() {
        // Small delay to ensure modal is fully closed
        setTimeout(function() {
            if (!isModalOpen()) {
                resumeAutoSlide();
            }
        }, 100);
    });
});


if (window.innerWidth >= 1180) {
    gsap.registerPlugin(ScrollTrigger);
    ScrollTrigger.config({
        autoRefreshEvents: 'visibilitychange,DOMContentLoaded,load',
    })
    const resize = () => {
        console.log('resize')
        ScrollTrigger.refresh()
    }
    const panels = gsap.utils.toArray(".animate-right");
    const content = gsap.utils.toArray(".animate-left");
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: ".sectionsscroll",
            start: "top top",
            endTrigger: 'html',
            end: () => "+=" + 200 * panels.length + "%",
            pin: true,
            pinSpacing: true,
            // markers: true,
            scrub: 1,
            autoRefreshEvents: "load",
        }
    });
    panels.forEach((panel, index) => {
        tl.from(
            panel,
            {
                yPercent: 100,
                ease: "slow",
            },
            "+=0.1"
        );
        tl.from(
            content[index],
            {
                yPercent: 100,
                ease: "slow",
            },
            "<"
        );
    });

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
document.querySelectorAll('img[src$=".svg"]').forEach(function(img){
    fetch(img.src)
    .then(r => r.text())
    .then(txt => {
    const svg = new DOMParser().parseFromString(txt, "image/svg+xml").documentElement;
    svg.classList = img.classList;
    svg.style = img.style;
    img.replaceWith(svg);
    });
});
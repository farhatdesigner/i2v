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
                    sections.push('.' + sectionId);
                } else {
                    // Try data attribute or class
                    var dataTarget = $link.data('target') || $(this).data('section');
                    if (dataTarget) {
                        sections.push('.' + dataTarget);
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

                // Calculate exact scroll position
                var exactPosition = $target.offset().top - (triggerOffset - 1);

                // Smooth scroll to target section
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
        // HIDE MENU when 5th section scrolls above
        // ------------------------------------------
        var lastSection = sectionData[sectionData.length - 1];

        // Safety check: ensure lastSection exists before accessing properties
        if (lastSection && scrollTop > lastSection.bottom) {
            // User scrolled PAST the last section
            $menu.addClass("menu-hidden");
        } else {
            // User scrolls back up → show menu again
            $menu.removeClass("menu-hidden");
        }
    }

    function onScroll() {
        if (rafID) cancelAnimationFrame(rafID);
        rafID = requestAnimationFrame(function () {
            detectActiveSection();
            rafID = null;
        });
    }

    // Handle fixed-header class when sticky element reaches top of viewport
    function handleFixedHeader() {
        // Store initial position on first call (before element becomes fixed)
        if (stickyElementInitialTop === null) {
            var elementOffset = $menu.offset();
            if (elementOffset) {
                stickyElementInitialTop = elementOffset.top;
            } else {
                return; // Element not found or not visible
            }
        }
        
        var scrollTop = $(window).scrollTop();
        var activationThreshold = stickyElementInitialTop - 120; // Activate 120px before element reaches top
        
        // Add fixed-header class 120px before the element reaches the top of the viewport
        if (scrollTop >= activationThreshold) {
            $menu.addClass('fixed-header');
        } else {
            $menu.removeClass('fixed-header');
        }
    }

    // INIT
    updatePositions();
    detectActiveSection();
    handleFixedHeader(); // Initial check

    $(window).on("scroll", function() {
        onScroll();
        handleFixedHeader(); // Check on every scroll
    });
    $(window).on("resize", function () {
        // Temporarily remove fixed-header to get natural position, then recalculate
        var wasFixed = $menu.hasClass('fixed-header');
        if (wasFixed) {
            $menu.removeClass('fixed-header');
        }
        
        // Reset initial position on resize so it recalculates
        stickyElementInitialTop = null;
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
            ".intelligenc_alerts",
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
        
        // Check for default page sections
        var hasDefaultSections = $(".live_monitoring, .system_setup, .intelligenc_alerts, .recording_storage, .security_integration").length >= 3;
        
        if (hasDefaultSections) {
            return stickyMenuConfigs.default;
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
            start: "top 20%",
            endTrigger: 'html',
            end: () => "+=" + 200 * panels.length + "%",
            pin: true,
            pinSpacing: true,
            markers: false,
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
if (window.innerWidth >= 1200) {
    const gallery = document.querySelector(".gallery");
    
    if (gallery) {
        gsap.registerPlugin(ScrollTrigger);
        
        // collect sections + photos
        // Only select details from the left sidebar (.detailsWrapper), not from inside photos
        const sections = gsap.utils.toArray(".detailsWrapper .details");
        const photos   = gsap.utils.toArray(".photo");
        
        // set initial states
        gsap.set(photos, { opacity: 0 });
        gsap.set(photos[0], { opacity: 1 });
        
        // helper — show selected photo
        function showPhoto(index) {
            gsap.to(photos, { opacity: 0, duration: 0.4, overwrite: true });
            gsap.to(photos[index], { opacity: 1, duration: 0.4, overwrite: true });
        }
        
        // change image based on section
        sections.forEach((section, index) => {
            ScrollTrigger.create({
                trigger: section,
                start: "top 25%",
                end: "bottom 25%",
                scrub: true,
                onEnter: () => showPhoto(index),
                onEnterBack: () => showPhoto(index),
                // markers: true,
            });
        });
        
        // pin the right panel until last section reaches mid
        ScrollTrigger.create({
            trigger: ".gallery",
            start: "top 20%",
            endTrigger: ".detailsWrapper .details:last-child",
            end: "top 20%",
            pin: ".right",
            pinSpacing: true,
            // markers: true,
        });
        
        // Refresh ScrollTrigger on resize
        let resizeTimer;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth >= 1200) {
                    ScrollTrigger.refresh();
                }
            }, 250);
        });
    }
}





// Card Stacking Animation - Only on min-width 1200px and when cards-custom-body exists
if (window.innerWidth >= 1200) {
    const cardsCustomBody = document.querySelector(".cards-custom-body");
    
    if (cardsCustomBody) {
        console.clear();
        
        gsap.registerPlugin(ScrollTrigger);
        
        const cardsWrappers = gsap.utils.toArray(".card-wrapper");
        const cards = gsap.utils.toArray(".card_display");
        
        // Set initial states for all cards immediately to prevent flicker
        // No transforms - cards stay in their natural state
        cards.forEach((card, i) => {
            // Set initial transform state immediately - prevents cards from appearing at wrong position
            // This ensures cards start in their correct position before ScrollTrigger activates
            // No scale, no rotation - cards stay in normal position
            gsap.set(card, {
                scale: 1, // No scaling - keep cards at natural size
                rotation: 0, // No rotation - keep cards straight
                transformOrigin: "top center",
                y: 0, // Ensure Y position is set from start
                x: 0, // Ensure X position is set from start
                force3D: true // Enable hardware acceleration
            });
        });
        
        cardsWrappers.forEach((wrapper, i) => {
            const card = cards[i];
            
            // Create animation with immediateRender to prevent initial jump
            // No scale, no rotation - cards remain in natural position
            gsap.to(card, {
                scale: 1, // No scaling - keep cards at natural size
                rotation: 0, // No rotation - keep cards straight
                transformOrigin: "top center",
                y: 0, // Explicitly set Y to prevent vertical jumping
                ease: "none",
                immediateRender: true, // Render immediately to prevent flicker
                force3D: true, // Hardware acceleration
                scrollTrigger: {
                    trigger: wrapper,
                    start: "top " + (200 + 70 * i),
                    end: "bottom 550",
                    endTrigger: ".wrapper",
                    scrub: true,
                    pin: wrapper,
                    pinSpacing: false,
                    anticipatePin: 1, // Smooth pinning transitions
                    invalidateOnRefresh: true, // Recalculate on refresh
                    onEnter: () => {
                        // Ensure card maintains correct position when entering
                        gsap.set(card, {
                            y: 0,
                            x: 0,
                            scale: 1, // Ensure no scaling
                            rotation: 0, // Ensure no rotation
                            force3D: true
                        });
                    },
                    onEnterBack: () => {
                        // Maintain position when scrolling back
                        gsap.set(card, {
                            y: 0,
                            x: 0,
                            scale: 1, // Ensure no scaling
                            rotation: 0, // Ensure no rotation
                            force3D: true
                        });
                    },
                    // markers: {
                    //     indent: 150 * i
                    // },
                    id: i + 1
                }
            });
        });
        
        // Refresh ScrollTrigger on resize
        let resizeTimer;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth >= 1200) {
                    ScrollTrigger.refresh();
                }
            }, 250);
        });
    }
}
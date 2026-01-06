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
    var previousFixedHeaderState = false; // Track previous fixed-header state
    var previousMenuHiddenState = false; // Track previous menu-hidden state
    var refreshTimeout = null; // Debounce ScrollTrigger refresh calls
    
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
        
        // Determine if fixed-header should be active
        var shouldBeFixed = scrollTop >= activationThreshold;
        var currentFixedHeaderState = $menu.hasClass('fixed-header');
        
        // Add or remove fixed-header class based on scroll position
        if (shouldBeFixed && !currentFixedHeaderState) {
            $menu.addClass('fixed-header');
        } else if (!shouldBeFixed && currentFixedHeaderState) {
            $menu.removeClass('fixed-header');
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
        var hasDefaultSections = $(".live_monitoring, .system_setup, .intelligenc_alerts, .recording_storage, .security_integration").length >= 3;
        
        if (hasDefaultSections) {
            return stickyMenuConfigs.default;
        }

        // Check for partner page sections
        var hasPartnerSections = $(".channel_partner, .technology_partner").length >= 2;
        
        if (hasPartnerSections) {
            return stickyMenuConfigs.partnersystems;
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


if (window.innerWidth >= 1180 && document.querySelector(".sectionsscroll")) {
    gsap.registerPlugin(ScrollTrigger);
    ScrollTrigger.config({
        autoRefreshEvents: 'visibilitychange,DOMContentLoaded,load',
    })
    const resize = () => {
        console.log('resize')
        ScrollTrigger.refresh()
    }
    
    // Only select panels within sectionsscroll to avoid conflicts
    const sectionsscrollEl = document.querySelector(".sectionsscroll");
    const panels = gsap.utils.toArray(".sectionsscroll .animate-right");
    const content = gsap.utils.toArray(".sectionsscroll .animate-left");
    
    // Skip if no panels found
    if (panels.length > 0) {
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: ".sectionsscroll",
                start: "top 20%",
                endTrigger: '.sectionsscroll',
                end: () => "+=" + 200 * panels.length + "%",
                pin: true,
                pinSpacing: true,
                markers: false,
                scrub: 1,
                invalidateOnRefresh: true,
                refreshPriority: 1, // Higher priority, refreshes first
                id: "sectionsscroll-pin"
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
    // Scope gallery animation to .makdmks container to avoid conflicts
    const makdmks = document.querySelector(".makdmks");
    const gallery = makdmks ? makdmks.querySelector(".gallery") : null;
    
    if (gallery) {
        gsap.registerPlugin(ScrollTrigger);
        
        // collect sections + photos - scoped to makdmks container
        // Only select details from the left sidebar (.detailsWrapper), not from inside photos
        const sections = gsap.utils.toArray(".makdmks .detailsWrapper .details");
        const photos   = gsap.utils.toArray(".makdmks .photo");
        
        // Skip if no sections found
        if (sections.length > 0 && photos.length > 0) {
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
                    invalidateOnRefresh: true,
                    // markers: true,
                    id: "gallery-section-" + index
                });
            });
            
            // pin the right panel until last section reaches mid
            ScrollTrigger.create({
                trigger: ".makdmks .gallery",
                start: "top 20%",
                endTrigger: ".makdmks .detailsWrapper .details:last-child",
                end: "top 20%",
                pin: ".makdmks .right",
                pinSpacing: false, // Changed to false to prevent spacing conflicts
                invalidateOnRefresh: true,
                refreshPriority: -1, // Lower priority, refreshes after others
                // markers: true,
                id: "gallery-pin"
            });
        }
        
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
        
        const totalCards = cards.length;
        
        cardsWrappers.forEach((wrapper, i) => {
            const card = cards[i];
            
            // Calculate reverse index matching CSS reference demo exactly
            // CSS: --index0 = calc(var(--index) - 1) [0-based index]
            // CSS: --reverse-index = calc(var(--numcards) - var(--index0))
            // In JS: i is already 0-based, so index0 = i
            // Reverse index = totalCards - i (matching CSS formula)
            const reverseIndex = totalCards - i;
            
            // Calculate scale values matching reference demo formula exactly
            // Reference: scale(calc(1.1 - calc(0.1 * var(--reverse-index))))
            // Cards scale down as they stack: from 1.1 to smaller values
            const targetScale = 1.1 - (0.1 * reverseIndex);
            
            // Set initial scale (cards start at full size, matching reference demo)
            // Cards start at scale 1.0 and animate to targetScale as they scroll
            gsap.set(card, {
                scale: 1.0, // Start at normal size (matches CSS initial state)
                rotation: 0,
                transformOrigin: "top center",
                y: 0,
                x: 0,
                force3D: true,
                zIndex: i // Higher z-index for cards that stack on top (last card has highest z-index)
            });
            
            // Create animation with scale effect (like reference demo)
            // Card scales down as it gets pinned/stuck
            gsap.to(card, {
                scale: targetScale, // Scale down to target scale when pinned
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
                    refreshPriority: 0,
                    onEnter: () => {
                        // Ensure card maintains correct position when entering
                        gsap.set(card, {
                            y: 0,
                            x: 0,
                            rotation: 0,
                            force3D: true
                        });
                    },
                    onEnterBack: () => {
                        // Maintain position when scrolling back
                        gsap.set(card, {
                            y: 0,
                            x: 0,
                            rotation: 0,
                            force3D: true
                        });
                    },
                    // markers: {
                    //     indent: 150 * i
                    // },
                    id: "card-" + (i + 1)
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




if (document.querySelector(".hz-slider-section .swiper")) {
  // Store reference to ScrollTrigger instance for cleanup
  let hzScrollTrigger = null;
  let hzTimeline = null;
  let currentSlide = 0;
  
  const hzSwiper = new Swiper(".hz-slider-section .swiper", {
    // autoplay: {
    //   delay: 5000,
    //   disableOnInteraction: false
    // },
    speed: 1200,
    loop: false,
    slidesPerView: 2.3,
    spaceBetween: 30,
    loopAddBlankSlides: false,
    slideToClickedSlide: true,
    centeredSlides: false,
    // Enable touch move on mobile, disable on desktop (will be controlled by GSAP)
    allowTouchMove: window.innerWidth < 1024,
    // Add smooth easing for transitions
    effect: 'slide',
    resistance: true,
    resistanceRatio: 0.85,
    breakpoints: {
      480: {
        slidesPerView: 1,
        spaceBetween: 30
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 30
      },
      1400: {
        slidesPerView: 3.6,
        spaceBetween: 30
      }
    }
  });
  
  hzSwiper.slideTo(0);
  
  // Function to initialize GSAP pin animation (desktop only)
  function initHzSliderGSAP() {
    // Only initialize if screen width is 1024px or above
    if (window.innerWidth < 1024) {
      return;
    }
    
    // Register GSAP plugin
    gsap.registerPlugin(ScrollTrigger);
    
    const totalSlides = hzSwiper.slides.length;
    const snap = gsap.utils.snap(1 / totalSlides);
    
    // Calculate scroll distance based on number of slides (150vh per slide for slower scroll)
    const scrollDistance = totalSlides * 150;
    
    // Disable Swiper touch on desktop (controlled by scroll)
    hzSwiper.allowTouchMove = false;
    hzSwiper.update();
    
    hzTimeline = gsap.timeline({
      scrollTrigger: {
        trigger: ".hz-slider-section .slider",
        pin: ".hz-slider-section",
        pinSpacing: true,
        pinReparent: false, // Changed to false to prevent DOM reparenting issues
        start: "top 10%",
        end: "+=" + scrollDistance + "vh", // Dynamic based on slides
        scrub: 2, // Increased from true to 2 for smoother, slower scroll response
        markers: false,
        invalidateOnRefresh: true,
        refreshPriority: 2, // Higher priority than gallery
        id: "hz-slider-pin",
        onUpdate: (self) => {
          const updatedIndex = Math.round(snap(self.progress) * totalSlides);
          if (updatedIndex !== currentSlide) {
            currentSlide = updatedIndex;
            hzSwiper.slideTo(currentSlide, 1200); // Use slower speed for programmatic slide changes
          }
        }
      }
    });
    
    // Store reference for cleanup
    hzScrollTrigger = hzTimeline.scrollTrigger;
  }
  
  // Function to destroy GSAP pin animation (for mobile)
  function destroyHzSliderGSAP() {
    if (hzScrollTrigger) {
      hzScrollTrigger.kill();
      hzScrollTrigger = null;
    }
    if (hzTimeline) {
      hzTimeline.kill();
      hzTimeline = null;
    }
    
    // Enable Swiper touch on mobile
    hzSwiper.allowTouchMove = true;
    hzSwiper.update();
    
    // Reset slide position
    currentSlide = 0;
    hzSwiper.slideTo(0);
  }
  
  // Initialize on page load
  initHzSliderGSAP();
  
  // Handle resize - enable/disable GSAP pin based on screen width
  let hzResizeTimer;
  window.addEventListener("resize", function() {
    clearTimeout(hzResizeTimer);
    hzResizeTimer = setTimeout(function() {
      const isDesktop = window.innerWidth >= 1024;
      const hasGSAP = hzScrollTrigger !== null;
      
      if (isDesktop && !hasGSAP) {
        // Switched to desktop - initialize GSAP pin
        initHzSliderGSAP();
      } else if (!isDesktop && hasGSAP) {
        // Switched to mobile - destroy GSAP pin
        destroyHzSliderGSAP();
      } else if (isDesktop && hasGSAP) {
        // Still on desktop - refresh ScrollTrigger
        ScrollTrigger.refresh();
      }
    }, 250);
  });
}

// Horizontal Slider Topcaption (unique instance - no conflict with hz-slider-section)
if (document.querySelector(".hz-slider-topcaption .swiper")) {
  // Store reference to ScrollTrigger instance for cleanup
  let hzTopcaptionScrollTrigger = null;
  let hzTopcaptionTimeline = null;
  let currentTopcaptionSlide = 0;
  
  const hzTopcaptionSwiper = new Swiper(".hz-slider-topcaption .swiper", {
    speed: 1200,
    loop: false,
    slidesPerView: 1,
    spaceBetween: 20,
    loopAddBlankSlides: false,
    slideToClickedSlide: true,
    centeredSlides: false,
    // Enable touch move on mobile, disable on desktop (will be controlled by GSAP)
    allowTouchMove: window.innerWidth < 1024,
    // Add smooth easing for transitions
    effect: 'slide',
    resistance: true,
    resistanceRatio: 0.85,
    breakpoints: {
      480: {
        slidesPerView: 1,
        spaceBetween: 20
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 20
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20
      },
      1230: {
        slidesPerView: 4,
        spaceBetween: 20
      }
    }
  });
  
  hzTopcaptionSwiper.slideTo(0);
  
  // Function to initialize GSAP pin animation (desktop only)
  function initHzTopcaptionGSAP() {
    // Only initialize if screen width is 1024px or above
    if (window.innerWidth < 1024) {
      return;
    }
    
    // Register GSAP plugin
    gsap.registerPlugin(ScrollTrigger);
    
    const totalSlides = hzTopcaptionSwiper.slides.length;
    const snap = gsap.utils.snap(1 / totalSlides);
    
    // Calculate scroll distance based on number of slides (150vh per slide for slower scroll)
    const scrollDistance = totalSlides * 150;
    
    // Disable Swiper touch on desktop (controlled by scroll)
    hzTopcaptionSwiper.allowTouchMove = false;
    hzTopcaptionSwiper.update();
    
    hzTopcaptionTimeline = gsap.timeline({
      scrollTrigger: {
        trigger: ".hz-slider-topcaption .slider",
        pin: ".hz-slider-topcaption",
        pinSpacing: true,
        pinReparent: false,
        start: "top 20%",
        end: "+=" + scrollDistance + "vh",
        scrub: 2, // Increased from true to 2 for smoother, slower scroll response
        markers: false,
        invalidateOnRefresh: true,
        refreshPriority: 1,
        id: "hz-slider-topcaption-pin",
        onUpdate: (self) => {
          const updatedIndex = Math.round(snap(self.progress) * totalSlides);
          if (updatedIndex !== currentTopcaptionSlide) {
            currentTopcaptionSlide = updatedIndex;
            hzTopcaptionSwiper.slideTo(currentTopcaptionSlide, 1200); // Use slower speed for programmatic slide changes
          }
        }
      }
    });
    
    // Store reference for cleanup
    hzTopcaptionScrollTrigger = hzTopcaptionTimeline.scrollTrigger;
  }
  
  // Function to destroy GSAP pin animation (for mobile)
  function destroyHzTopcaptionGSAP() {
    if (hzTopcaptionScrollTrigger) {
      hzTopcaptionScrollTrigger.kill();
      hzTopcaptionScrollTrigger = null;
    }
    if (hzTopcaptionTimeline) {
      hzTopcaptionTimeline.kill();
      hzTopcaptionTimeline = null;
    }
    
    // Enable Swiper touch on mobile
    hzTopcaptionSwiper.allowTouchMove = true;
    hzTopcaptionSwiper.update();
    
    // Reset slide position
    currentTopcaptionSlide = 0;
    hzTopcaptionSwiper.slideTo(0);
  }
  
  // Initialize on page load
  initHzTopcaptionGSAP();
  
  // Handle resize - enable/disable GSAP pin based on screen width
  let hzTopcaptionResizeTimer;
  window.addEventListener("resize", function() {
    clearTimeout(hzTopcaptionResizeTimer);
    hzTopcaptionResizeTimer = setTimeout(function() {
      const isDesktop = window.innerWidth >= 1024;
      const hasGSAP = hzTopcaptionScrollTrigger !== null;
      
      if (isDesktop && !hasGSAP) {
        // Switched to desktop - initialize GSAP pin
        initHzTopcaptionGSAP();
      } else if (!isDesktop && hasGSAP) {
        // Switched to mobile - destroy GSAP pin
        destroyHzTopcaptionGSAP();
      } else if (isDesktop && hasGSAP) {
        // Still on desktop - refresh ScrollTrigger
        ScrollTrigger.refresh();
      }
    }, 250);
  });
}

// Global ScrollTrigger refresh after all triggers are initialized
// This ensures all ScrollTriggers are properly calculated relative to each other
if (typeof ScrollTrigger !== 'undefined' && window.innerWidth >= 1024) {
    // Wait for DOM to be fully ready and all triggers to be created
    window.addEventListener('load', function() {
        setTimeout(function() {
            ScrollTrigger.refresh();
        }, 500);
    });
}
  
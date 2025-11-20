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
    // Function to close the menu
    function closeMenu() {
        $(".burger-icon").removeClass("active-burger");
        $(".toggle-menu-container").removeClass("open-menu");
        $("nav").removeClass("overlaynav-active");
        $(".overlay").removeClass("overlay-active");
        $("body").css("overflow", "");
    }

    // Open menu when burger icon is clicked
    $(".burger-icon").click(function () {
        $(this).addClass("active-burger");
        $(".toggle-menu-container").addClass("open-menu");
        $("nav").addClass("overlaynav-active");
        $(".overlay").addClass("overlay-active");
        $("body").css("overflow", "hidden");
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


// $(window).scroll(function() {
//     if ($(window).scrollTop() >= 120) {
//         $('.sticky-custom').addClass('fixed-header');
//     } else {
//         $('.sticky-custom').removeClass('fixed-header');
//     }
// });



jQuery(document).ready(function() {
    // open first section by default
    let first = jQuery('.accordion_set').first();
    first.addClass('acactive');
    first.find('.select_div').attr("aria-expanded", "true");
    jQuery(".accontent").first().slideDown(200);

    // setup variables
    let autoIndex = 0;
    let total = jQuery(".accordion_set").length;
    let autoInterval = 4000; // 4 seconds
    let timer;

    // function to open accordion by index
    function openAccordion(index) {
        let target = jQuery(".accordion_set").eq(index);
        jQuery(".accordion_set").removeClass("acactive");
        jQuery(".accordion_set > .select_div").attr("aria-expanded", "false");
        jQuery(".accontent").slideUp(200);

        target.addClass("acactive");
        target.find(".select_div").attr("aria-expanded", "true");
        target.find(".accontent").slideDown(200);
    }

    // auto slide function
    function startAutoSlide() {
        timer = setInterval(function() {
            autoIndex = (autoIndex + 1) % total;
            openAccordion(autoIndex);
        }, autoInterval);
    }

    // start auto slide initially
    startAutoSlide();

    // on click — manual control + reset timer
    jQuery(".accordion_set > .select_div").click(function() {
        clearInterval(timer); // stop auto slide

        let parent = jQuery(this).parents('.accordion_set');
        autoIndex = jQuery(".accordion_set").index(parent); // update index

        if (parent.hasClass("acactive")) {
            parent.removeClass("acactive");
            jQuery(this).attr("aria-expanded", "false");
            parent.find(".accontent").slideUp(200);
        } else {
            openAccordion(autoIndex);
        }

        // restart auto slide after short delay
        timer = setTimeout(() => startAutoSlide(), 1000);
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
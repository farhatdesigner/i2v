// Check system preference
const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

// Load saved preference
const storedPreference = localStorage.getItem('dark-mode');

// Function to update icons based on dark mode state
function updateDarkModeIcons(isDark) {
    const sunIcon = document.querySelector('.icon-sun');
    const moonIcon = document.querySelector('.icon-moon');

    if (sunIcon && moonIcon) {
        if (isDark) {
            // Dark mode: show sun icon (to switch back to light)
            sunIcon.style.display = 'block';
            moonIcon.style.display = 'none';
        } else {
            // Light mode: show moon icon (to switch to dark)
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'block';
        }
    }
}

// Apply stored or system preference
const initialDarkMode = storedPreference === 'dark' || (!storedPreference && prefersDark);
if (initialDarkMode) {
    document.body.classList.add('js-dark');
}

// Update icons on page load
document.addEventListener('DOMContentLoaded', function () {
    updateDarkModeIcons(document.body.classList.contains('js-dark'));
});

// Toggle with button
const toggleButton = document.querySelector('.dark-mode-toggle');
if (toggleButton) {
    toggleButton.addEventListener('click', function (e) {
        e.preventDefault();
        const isDark = document.body.classList.toggle('js-dark');
        localStorage.setItem('dark-mode', isDark ? 'dark' : 'light');
        updateDarkModeIcons(isDark);
    });
}

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

    var swiper = new Swiper(".hero-swiper-container", swiperOptions);

    // DATA BACKGROUND IMAGE
    var sliderBgSetting = $(".hero-swiper-container .slide-bg-image");
    sliderBgSetting.each(function (indx) {
        if ($(this).attr("data-background")) {
            $(this).css("background-image", "url(" + $(this).data("background") + ")");
        }
    });
});

$(document).ready(function () {
    $(".burger-icon").click(function () {
        $(this).addClass("active-burger");
        $(".toggle-menu-container").addClass("open-menu");
        $(".overlay").addClass("overlay-active");
    });

    $(".cross_icon").click(function () {
        $(".burger-icon").removeClass("active-burger");
        $(".toggle-menu-container").removeClass("open-menu");
        $(".overlay").removeClass("overlay-active");
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




$(".tabsautoscroll li").click(function () {
    var $this = $(this);
    var e = $this.position();
    var t = $this.data("id"); // e.g., "content0", "content1", etc.

    // Handle scroll arrows
    $this.is(":last-child") ? $(".next").hide() : $(".next").show();
    $this.is(":first-child") ? $(".previous").hide() : $(".previous").show();

    // Scroll tabs horizontally
    var scroll = $(".tabsautoscroll").scrollLeft();
    $(".tabsautoscroll").animate({ scrollLeft: scroll + e.left - 200 }, 200);

    // Toggle class only, no .show() or .hide()
    $(".tabContent .tabdiv").removeClass("active-tabcontent");
    $(".tabdiv." + t).addClass("active-tabcontent");

    // Active tab styling
    $(".tabsautoscroll li").removeClass("active");
    $this.addClass("active");
});



// $(".tabdiv a").click(function (e) {
//   e.preventDefault(), $("li.active").next("li").trigger("click");
// }),
$(".next").click(function (e) {
    e.preventDefault(), $("li.active").next("li").trigger("click");
});

$(".previous").click(function (e) {
    e.preventDefault(), $("li.active").prev("li").trigger("click");
});
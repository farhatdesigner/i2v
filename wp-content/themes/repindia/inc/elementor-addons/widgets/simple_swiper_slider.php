<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Simple_Swiper_Slider extends Widget_Base
{

    public function get_name()
    {
        return 'simple_swiper_slider';
    }

    public function get_title()
    {
        return 'Simple Swiper Slider';
    }

    public function get_icon()
    {
        return 'fa fa-sliders';
    }

    public function get_categories()
    {
        return ['general'];
    }

    public function get_script_depends()
    {
        return ['swiper'];
    }

    public function get_style_depends()
    {
        return ['swiper', 'e-swiper'];
    }

    protected function register_controls()
    {
        // No controls needed - pure static content
    }

    protected function render()
    {
        $uid = 'simple_slider_' . $this->get_id();
        
        // Static slides data
        $slides = [
            [
                'image' => get_template_directory_uri() . '/assets/images/placeholder1.jpg',
                'title' => 'Slide Title 1',
                'description' => 'This is the description for slide 1.'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/placeholder2.jpg',
                'title' => 'Slide Title 2',
                'description' => 'This is the description for slide 2.'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/placeholder3.jpg',
                'title' => 'Slide Title 3',
                'description' => 'This is the description for slide 3.'
            ],
            [
                'image' => get_template_directory_uri() . '/assets/images/placeholder4.jpg',
                'title' => 'Slide Title 4',
                'description' => 'This is the description for slide 4.'
            ],
        ];
?>

        <section class="simple-slider-wrapper" id="<?php echo esc_attr($uid); ?>">
            <div class="simple-slider-container">
                <div class="swiper simple-swiper">
                    <div class="swiper-wrapper">

                        <?php foreach ($slides as $slide): ?>
                            <div class="swiper-slide">
                                <figure class="simple-slide-card">
                                    <img src="<?php echo esc_url($slide['image']); ?>"
                                        alt="<?php echo esc_attr($slide['title']); ?>" loading="lazy">
                                    <figcaption>
                                        <h3><?php echo esc_html($slide['title']); ?></h3>
                                        <p><?php echo esc_html($slide['description']); ?></p>
                                    </figcaption>
                                </figure>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <!-- Navigation -->
                    <div class="swiper-button-next simple-swiper-next">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-white.svg" alt="Next">
                    </div>
                    <div class="swiper-button-prev simple-swiper-prev">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-white.svg" alt="Prev">
                    </div>
                </div>
            </div>
        </section>

        <style>
        #<?php echo esc_attr($uid); ?> {
            position: relative;
            width: 100%;
        }
        
        #<?php echo esc_attr($uid); ?> .simple-slider-container {
            position: relative;
            width: 100%;
        }
        
        #<?php echo esc_attr($uid); ?> .simple-swiper {
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        
        #<?php echo esc_attr($uid); ?> .simple-slide-card {
            margin: 0;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }
        
        #<?php echo esc_attr($uid); ?> .simple-slide-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        
        #<?php echo esc_attr($uid); ?> .simple-slide-card figcaption {
            padding: 15px;
        }
        
        #<?php echo esc_attr($uid); ?> .simple-slide-card h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: #333;
        }
        
        #<?php echo esc_attr($uid); ?> .simple-slide-card p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        /* Hide default Swiper arrow icons */
        #<?php echo esc_attr($uid); ?> .simple-swiper .swiper-button-prev:after,
        #<?php echo esc_attr($uid); ?> .simple-swiper .swiper-button-next:after {
            display: none !important;
            content: none !important;
        }
        
        /* Navigation buttons styling */
        #<?php echo esc_attr($uid); ?> .simple-swiper .simple-swiper-next,
        #<?php echo esc_attr($uid); ?> .simple-swiper .simple-swiper-prev {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(0,0,0,0.5);
            transition: all 0.3s ease;
        }
        
        #<?php echo esc_attr($uid); ?> .simple-swiper .simple-swiper-next:hover,
        #<?php echo esc_attr($uid); ?> .simple-swiper .simple-swiper-prev:hover {
            background: rgba(0,0,0,0.8);
        }
        
        #<?php echo esc_attr($uid); ?> .simple-swiper .simple-swiper-next {
            right: 10px;
        }
        
        #<?php echo esc_attr($uid); ?> .simple-swiper .simple-swiper-prev {
            left: 10px;
            transform: translateY(-50%) rotate(180deg);
        }
        
        #<?php echo esc_attr($uid); ?> .simple-swiper .simple-swiper-next img,
        #<?php echo esc_attr($uid); ?> .simple-swiper .simple-swiper-prev img {
            width: 20px;
            height: 20px;
        }
        
        @media (max-width: 767px) {
            #<?php echo esc_attr($uid); ?> .simple-swiper {
                overflow: hidden !important;
            }
        }
        </style>

        <script>
            (function() {
                var widgetId = '<?php echo esc_js($uid); ?>';
                var widgetEl = null;

                function initSwiper() {
                    if (!widgetEl) {
                        widgetEl = document.getElementById(widgetId);
                    }

                    if (!widgetEl) return;

                    var slider = widgetEl.querySelector(".simple-swiper");
                    if (!slider) return;

                    if (slider.swiper) return;

                    var nextBtn = widgetEl.querySelector(".simple-swiper-next");
                    var prevBtn = widgetEl.querySelector(".simple-swiper-prev");

                    if (!nextBtn || !prevBtn) return;

                    function readyForSwiper(cb) {
                        if (typeof Swiper !== 'undefined') {
                            cb();
                        } else if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                            cb();
                        } else {
                            setTimeout(function() {
                                readyForSwiper(cb);
                            }, 60);
                        }
                    }

                    readyForSwiper(function() {
                        var swiperConfig = {
                            navigation: {
                                nextEl: nextBtn,
                                prevEl: prevBtn,
                            },
                            spaceBetween: 20,
                            allowTouchMove: true,
                            grabCursor: true,
                            slidesPerView: 1,
                            breakpoints: {
                                0: {
                                    slidesPerView: 1,
                                    spaceBetween: 15,
                                },
                                768: {
                                    slidesPerView: 2,
                                    spaceBetween: 20,
                                },
                                1024: {
                                    slidesPerView: 3,
                                    spaceBetween: 20,
                                },
                                1200: {
                                    slidesPerView: 4,
                                    spaceBetween: 20,
                                }
                            }
                        };

                        try {
                            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                                elementorFrontend.utils.swiper(slider, swiperConfig);
                            } else if (typeof Swiper !== 'undefined') {
                                new Swiper(slider, swiperConfig);
                            }
                        } catch (e) {
                            console.error('Error initializing Swiper:', e);
                        }
                    });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initSwiper);
                } else {
                    initSwiper();
                }

                if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                    elementorFrontend.hooks.addAction('frontend/element_ready/simple_swiper_slider.default', function($scope) {
                        widgetEl = ($scope && $scope.length) ? $scope[0] : document.getElementById(widgetId);
                        setTimeout(initSwiper, 100);
                    });
                }

                if (typeof jQuery !== 'undefined') {
                    jQuery(window).on('elementor/frontend/init', function() {
                        setTimeout(initSwiper, 200);
                    });
                }

                setTimeout(initSwiper, 500);
            })();
        </script>

<?php
    }
}
?>


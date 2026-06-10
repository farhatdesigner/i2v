<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit;

class Custom_Purpose_Slider extends Widget_Base
{

    public function get_name()
    {
        return 'horizontal_slider';
    }

    public function get_title()
    {
        return 'horizontal_slider Slider';
    }

    public function get_icon()
    {
        return 'fa fa-th';
    }

    public function get_categories()
    {
        return ['general'];
    }

    // Load Elementor’s bundled Swiper (DO NOT load your own)
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

        $this->start_controls_section(
            'section_content',
            ['label' => __('Settings', 'repindia')]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'card_image',
            [
                'label' => __('Upload Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'card_image_alt',
            [
                'label' => __('Image Alt Text', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'card_title',
            [
                'label' => __('Card Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'card_description',
            [
                'label' => __('Card Description', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'cards_list',
            [
                'label' => __('Cards List', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ card_title }}}'
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $cards = $settings['cards_list'];

        if (empty($cards)) {
            echo '<div class="no-cards">No cards added.</div>';
            return;
        }

        $uid = 'purpose_slider_' . $this->get_id();
?>

        <section class="purpose-slider-wrapper" id="<?php echo esc_attr($uid); ?>">
            <div class="custom-container">
                <div class="swiper mySwiper purpose-swiper">
                    <div class="swiper-wrapper">

                        <?php foreach ($cards as $card): ?>

                            <?php
                            $img_url = '';

                            if (!empty($card['card_image']['url'])) {
                                $img_url = $card['card_image']['url'];
                            } elseif (!empty($card['card_image']['id'])) {
                                $img_url = wp_get_attachment_image_url($card['card_image']['id'], 'large');
                            }

                            $img_alt = $card['card_image_alt'] ?? $card['card_title'] ?? 'Image';
                            ?>

                            <div class="swiper-slide">
                                <figure class="caption-scroll leader-caption m-0">

                                    <?php if ($img_url): ?>
                                        <img src="<?php echo esc_url($img_url); ?>"
                                            alt="<?php echo esc_attr($img_alt); ?>" loading="lazy">
                                    <?php endif; ?>

                                    <figcaption>
                                        <?php if (!empty($card['card_title'])): ?>
                                            <h3><?php echo esc_html($card['card_title']); ?></h3>
                                        <?php endif; ?>

                                        <?php if (!empty($card['card_description'])): ?>
                                            <p><?php echo esc_html($card['card_description']); ?></p>
                                        <?php endif; ?>
                                    </figcaption>
                                </figure>
                            </div>

                        <?php endforeach; ?>

                    </div>

                    <!-- Navigation -->
                    <div class="swiper-button-next swiper-horizontalmobile-next">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-white.svg" alt="Next">
                    </div>
                    <div class="swiper-button-prev swiper-horizontalmobile-prev">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-white.svg" alt="Prev">
                    </div>
                </div>
            </div>
        </section>

        <style>
        #<?php echo esc_attr($uid); ?> .purpose-slider-wrapper {
            position: relative;
        }
        #<?php echo esc_attr($uid); ?> .custom-container {
            position: relative;
            width: 100%;
        }
        #<?php echo esc_attr($uid); ?> .purpose-swiper {
            width: 100%;
            overflow: hidden;
            position: relative;
            overflow: visible;
        }
        /* Hide default Swiper arrow icons - using custom arrow images instead */
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-button-prev:after,
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-button-next:after,
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-rtl .swiper-button-prev:after,
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-rtl .swiper-button-next:after {
            display: none !important;
            content: none !important;
        }
        
        /* Navigation buttons styling - matching homepage banner */
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-next,
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-prev {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            user-select: none;
            -webkit-user-select: none;
            border-radius: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            transition: all 0.3s ease;
        }
        


        
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-next {
            right: 10px;
        }
        
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-prev {
            left: 10px;
            transform: translateY(-20px) rotate(180deg);
        }
        
        /* Mobile: pan-y allows vertical page scroll while swiping slides sideways */
        @media (max-width: 767px) {
            #<?php echo esc_attr($uid); ?> .purpose-swiper,
            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-wrapper,
            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-slide,
            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-slide img {
                touch-action: pan-y pinch-zoom;
                -webkit-overflow-scrolling: touch;
            }

            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-slide {
                -webkit-user-select: none;
                user-select: none;
                -webkit-tap-highlight-color: transparent;
            }

            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-slide img {
                -webkit-user-drag: none;
                user-drag: none;
            }
        }

        </style>

        <script>
            (function() {
                var widgetId = '<?php echo esc_js($uid); ?>';
                var widgetEl = null;

                // Function to initialize Swiper
                function initSwiper() {
                    if (!widgetEl) {
                        widgetEl = document.getElementById(widgetId);
                    }

                    if (!widgetEl) return;

                    var slider = widgetEl.querySelector(".purpose-swiper");
                    if (!slider) return;

                    // Check if already initialized
                    if (slider.swiper) return;

                    var nextBtn = widgetEl.querySelector(".swiper-horizontalmobile-next");
                    var prevBtn = widgetEl.querySelector(".swiper-horizontalmobile-prev");

                    if (!nextBtn || !prevBtn) return;

                    // Function to check if Swiper is available
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
                            touchStartPreventDefault: false,
                            passiveListeners: true,
                            touchAngle: 40,
                            threshold: 8,
                            preventClicksPropagation: false,
                            // Enable touch/swipe by default (will be controlled by breakpoints)
                            allowTouchMove: true,
                            touchEventsTarget: 'container',
                            simulateTouch: true,
                            grabCursor: true,
                            // Default for mobile
                            slidesPerView: 1,
                            breakpoints: {
                                // Mobile first approach - breakpoints are min-width
                                // Below 768px: touch enabled, 1 slide
                                0: {
                                    slidesPerView: 1,
                                    spaceBetween: 20,
                                    allowTouchMove: true,
                                    touchEventsTarget: 'container',
                                    simulateTouch: true,
                                },
                                // 768px and above: touch disabled, multiple slides
                                768: {
                                    slidesPerView: 3,
                                    spaceBetween: 20,
                                    allowTouchMove: false,
                                },
                                1024: {
                                    slidesPerView: 4,
                                    spaceBetween: 20,
                                    allowTouchMove: false,
                                },
                                1200: {
                                    slidesPerView: "auto",
                                    spaceBetween: 20,
                                    allowTouchMove: false,
                                }
                            }
                        };

                        try {
                            // Use Elementor's Swiper wrapper if available, otherwise use global Swiper
                            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                                var swiperInstance = elementorFrontend.utils.swiper(slider, swiperConfig);
                                if (swiperInstance && swiperInstance.swiper) {
                                    swiperInstance.swiper.update();
                                }
                            } else if (typeof Swiper !== 'undefined') {
                                var swiperInstance = new Swiper(slider, swiperConfig);
                                if (swiperInstance && typeof swiperInstance.update === 'function') {
                                    setTimeout(function() {
                                        swiperInstance.update();
                                    }, 100);
                                }
                            } else {
                                console.warn('Swiper not found for purpose slider');
                            }
                        } catch (e) {
                            console.error('Error initializing Swiper:', e);
                        }
                    });
                }

                // Initialize on DOM ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initSwiper);
                } else {
                    initSwiper();
                }

                // Elementor hook for frontend/editor
                if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                    elementorFrontend.hooks.addAction('frontend/element_ready/cardscustom_purpose_slider.default', function($scope) {
                        // $scope is a jQuery object, get the DOM element
                        widgetEl = ($scope && $scope.length) ? $scope[0] : document.getElementById(widgetId);
                        setTimeout(initSwiper, 100);
                    });
                }

                // Also listen for Elementor init event (using jQuery if available)
                if (typeof jQuery !== 'undefined') {
                    jQuery(window).on('elementor/frontend/init', function() {
                        setTimeout(initSwiper, 200);
                    });
                }

                // Fallback: try again after a short delay
                setTimeout(initSwiper, 500);
            })();
        </script>

<?php
    }
}
?>
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
        return 'cardscustom_purpose_slider';
    }

    public function get_title()
    {
        return 'Custom Purpose Slider';
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
                    <div class="swiper-button-next swiper-horizontalmobile-next">Next</div>
                    <div class="swiper-button-prev swiper-horizontalmobile-prev">Prev</div>
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
        /* #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-wrapper {
            display: flex;
            align-items: stretch;
        }
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-slide {
            height: auto;
            display: flex;
            box-sizing: border-box;
        }
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-slide figure {
            width: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-slide img {
            width: 100%;
            height: auto;
            display: block;
        }
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-next,
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-prev {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            user-select: none;
            -webkit-user-select: none;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background 0.3s ease;
        }
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-next:hover,
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-prev:hover {
            background: rgba(0, 0, 0, 0.7);
        }
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-next {
            right: 10px;
        }
        #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-prev {
            left: 10px;
        }
        @media (max-width: 767px) {
            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-slide {
                width: auto !important;
                min-width: 280px;
            }
            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-next,
            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-prev {
                padding: 8px 12px;
                font-size: 14px;
            }
            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-next {
                right: 5px;
            }
            #<?php echo esc_attr($uid); ?> .purpose-swiper .swiper-horizontalmobile-prev {
                left: 5px;
            }
        } */
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
                            slidesPerView: 5,
                            spaceBetween: 20,
                            breakpoints: {
                                // Mobile first approach - breakpoints are min-width
                                360: {
                                    slidesPerView: "auto",
                                    spaceBetween: 24,
                                },
                                768: {
                                    slidesPerView: 3,
                                    spaceBetween: 20,
                                },
                                1024: {
                                    slidesPerView: 4,
                                    spaceBetween: 20,
                                },
                                1399: {
                                    slidesPerView: 5,
                                    spaceBetween: 20,
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
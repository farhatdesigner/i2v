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

?>

        <section class="purpose-slider-wrapper">
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
        .purpose-slider-wrapper {
            position: relative;
        }
        .purpose-slider-wrapper .custom-container {
            position: relative;
            width: 100%;
        }
        .purpose-slider-wrapper .purpose-swiper {
            width: 100%;
            overflow: hidden;
            position: relative;
            overflow: visible;
        }
        /* Hide default Swiper arrow icons - using custom arrow images instead */
        .purpose-slider-wrapper .purpose-swiper .swiper-button-prev:after,
        .purpose-slider-wrapper .purpose-swiper .swiper-button-next:after,
        .purpose-slider-wrapper .purpose-swiper .swiper-rtl .swiper-button-prev:after,
        .purpose-slider-wrapper .purpose-swiper .swiper-rtl .swiper-button-next:after {
            display: none !important;
            content: none !important;
        }
        
        /* Navigation buttons styling - matching homepage banner */
        .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-next,
        .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-prev {
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
        


        
        .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-next {
            right: 10px;
        }
        
        .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-prev {
            left: 10px;
            transform: translateY(-20px) rotate(180deg);
        }
        
        /* Mobile-specific styles for touch/swipe (below 767px) */
        @media (max-width: 767px) {
            .purpose-slider-wrapper .purpose-swiper {
                overflow: hidden !important;
                touch-action: pan-x;
                -webkit-overflow-scrolling: touch;
            }
            
            .purpose-slider-wrapper .purpose-swiper .swiper-wrapper {
                touch-action: pan-x;
                -webkit-transform: translate3d(0, 0, 0);
            }
            
            .purpose-slider-wrapper .purpose-swiper .swiper-slide {
                touch-action: pan-x;
                -webkit-user-select: none;
                user-select: none;
                -webkit-tap-highlight-color: transparent;
            }
        }

        </style>

        <script>
            (function() {
                function initSwiper() {
                    var widgetEl = document.querySelector('.purpose-slider-wrapper');
                    if (!widgetEl) return;

                    var slider = widgetEl.querySelector(".purpose-swiper");
                    if (!slider || slider.swiper) return;

                    var nextBtn = widgetEl.querySelector(".swiper-horizontalmobile-next");
                    var prevBtn = widgetEl.querySelector(".swiper-horizontalmobile-prev");
                    if (!nextBtn || !prevBtn) return;

                    if (typeof Swiper === 'undefined' && typeof elementorFrontend === 'undefined') {
                        setTimeout(initSwiper, 100);
                        return;
                    }

                    var swiperConfig = {
                        navigation: {
                            nextEl: nextBtn,
                            prevEl: prevBtn,
                        },
                        spaceBetween: 20,
                        breakpoints: {
                            0: {
                                slidesPerView: 1,
                                allowTouchMove: true,
                            },
                            768: {
                                slidesPerView: 3,
                                allowTouchMove: false,
                            },
                            1024: {
                                slidesPerView: 4,
                                allowTouchMove: false,
                            },
                            1200: {
                                slidesPerView: "auto",
                                allowTouchMove: false,
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
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initSwiper);
                } else {
                    initSwiper();
                }

                if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                    elementorFrontend.hooks.addAction('frontend/element_ready/cardscustom_purpose_slider.default', function($scope) {
                        setTimeout(initSwiper, 100);
                    });
                }
            })();
        </script>

<?php
    }
}
?>
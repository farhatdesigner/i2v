<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH'))
    exit;

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
                                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>"
                                            loading="lazy">
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
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20C0.5 9.23045 9.23045 0.5 20 0.5Z"
                                fill="white" />
                            <path
                                d="M20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20C0.5 9.23045 9.23045 0.5 20 0.5Z"
                                stroke="#E5E9EC" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M20.3254 13.6575C20.7593 13.2236 21.4628 13.2236 21.8967 13.6575L27.4523 19.213C27.6607 19.4214 27.7777 19.704 27.7777 19.9987C27.7777 20.2934 27.6607 20.576 27.4523 20.7844L21.8967 26.3399C21.4628 26.7738 20.7593 26.7738 20.3254 26.3399C19.8915 25.906 19.8915 25.2025 20.3254 24.7686L23.9842 21.1098L13.3333 21.1098C12.7196 21.1098 12.2222 20.6123 12.2222 19.9987C12.2222 19.385 12.7196 18.8876 13.3333 18.8876L23.9842 18.8876L20.3254 15.2288C19.8915 14.7949 19.8915 14.0914 20.3254 13.6575Z"
                                fill="#5F6F94" />
                        </svg>
                    </div>
                    <div class="swiper-button-prev swiper-horizontalmobile-prev">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20C0.5 9.23045 9.23045 0.5 20 0.5Z"
                                fill="white" />
                            <path
                                d="M20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20C0.5 9.23045 9.23045 0.5 20 0.5Z"
                                stroke="#E5E9EC" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M19.6746 13.6575C20.1085 14.0914 20.1085 14.7949 19.6746 15.2288L16.0158 18.8876L26.6667 18.8876C27.2803 18.8876 27.7778 19.385 27.7778 19.9987C27.7778 20.6123 27.2803 21.1098 26.6667 21.1098L16.0158 21.1098L19.6746 24.7686C20.1085 25.2025 20.1085 25.906 19.6746 26.3399C19.2406 26.7738 18.5371 26.7738 18.1032 26.3399L12.5477 20.7844C12.3393 20.576 12.2222 20.2934 12.2222 19.9987C12.2222 19.704 12.3393 19.4214 12.5477 19.213L18.1032 13.6575C18.5371 13.2236 19.2406 13.2236 19.6746 13.6575Z"
                                fill="#949494" />
                        </svg>


                    </div>
                </div>
            </div>
        </section>

        <style>
            .js-dark .default_liicon,
            .dark_liicon {
                display: none;
            }

            .js-dark .dark_liicon {
                display: block;
            }

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
                top: 55%;
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
                /* transform: translateY(-20px) rotate(180deg); */
            }


            .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-next:hover svg path,
            .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-prev:hover svg path {
                stroke: #c5c9cc;
                fill: #e6ebf2;
                opacity: 1;
            }

            .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-next:hover svg path:last-child,
            .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-prev:hover svg path:last-child {
                stroke: transparent;
                fill: #5F6F94;
            }


            .js-dark .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-next svg path,
            .js-dark .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-prev svg path {
                stroke: #c1c4c633;
                fill: #464a4f;
                opacity: 1;
            }

            .js-dark .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-next svg path:last-child,
            .js-dark .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-prev svg path:last-child {
                stroke: transparent;
                fill: #D7DBE4;
            }
            .js-dark .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-next:hover svg path,
            .js-dark .purpose-slider-wrapper .purpose-swiper .swiper-horizontalmobile-prev:hover svg path {
                stroke: rgba(193, 196, 198, 0.4);;
            }

            .swiper-button-next.swiper-button-disabled,
            .swiper-button-prev.swiper-button-disabled {
                opacity: 0;
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
            (function () {
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
                    elementorFrontend.hooks.addAction('frontend/element_ready/cardscustom_purpose_slider.default', function ($scope) {
                        setTimeout(initSwiper, 100);
                    });
                }
            })();
        </script>

        <?php
    }
}
?>
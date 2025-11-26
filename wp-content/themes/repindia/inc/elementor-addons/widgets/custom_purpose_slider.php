<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit;

class Custom_Purpose_Slider extends Widget_Base {

    public function get_name() {
        return 'cardscustom_purpose_slider';
    }

    public function get_title() {
        return 'Custom Purpose Slider';
    }

    public function get_icon() {
        return 'fa fa-th';
    }

    public function get_categories() {
        return ['general'];
    }

    // Load Elementor’s bundled Swiper (DO NOT load your own)
    public function get_script_depends() {
        return ['swiper'];
    }

    public function get_style_depends() {
        return ['swiper', 'e-swiper'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            [ 'label' => __('Settings', 'repindia') ]
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

    protected function render() {
        $settings = $this->get_settings_for_display();
        $cards = $settings['cards_list'];

        if (empty($cards)) {
            echo '<div class="no-cards">No cards added.</div>';
            return;
        }

        $uid = 'purpose_slider_' . $this->get_id();
        ?>

        <section class="purpose-slider-wrapper" id="<?php echo esc_attr($uid); ?>">
            <div class="swiper purpose-swiper">
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
                <div class="swiper-horizontalmobile-next">Next</div>
                <div class="swiper-horizontalmobile-prev">Prev</div>
            </div>
        </section>

        <script>
        jQuery(window).on("elementor/frontend/init", function () {
            elementorFrontend.hooks.addAction("frontend/element_ready/cardscustom_purpose_slider.default", function ($scope) {

                const slider = $scope.find(".purpose-swiper");

                if (slider.length && !slider[0].swiper) {

                    new Swiper(slider[0], {
                        navigation: {
                            nextEl: ".swiper-horizontalmobile-next",
                            prevEl: ".swiper-horizontalmobile-prev",
                        },
                        breakpoints: {
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
                    });
                }
            });
        });
        </script>

        <?php
    }
}
?>
<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH'))
    exit;

class Horizontal_Slider extends Widget_Base
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

        // Main repeater for slider items
        $repeater = new \Elementor\Repeater();

        // Title
        $repeater->add_control(
            'slider_title',
            [
                'label' => esc_html__('Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Default Theme Image
        $repeater->add_control(
            'slider_image_default',
            [
                'label' => esc_html__('Default Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Dark Theme Image
        $repeater->add_control(
            'slider_image_dark',
            [
                'label' => esc_html__('Dark Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
            ]
        );

        // Description
        $repeater->add_control(
            'slider_description',
            [
                'label' => esc_html__('Description', 'repindia'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Nested Repeater for List Items
        $list_repeater = new \Elementor\Repeater();
        $list_repeater->add_control(
            'list_item_text',
            [
                'label' => esc_html__('List Item Text', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_items',
            [
                'label' => esc_html__('List Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $list_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ list_item_text }}}',
            ]
        );

        $this->add_control(
            'slider_items',
            [
                'label' => esc_html__('Slider Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ slider_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $slider_items = !empty($settings['slider_items']) ? $settings['slider_items'] : [];

        // Static SVG checkmark icon for list items
        $checkmark_svg_default = '<svg class="default_liicon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.26701 1.45496C4.91008 1.40364 5.52057 1.15077 6.01158 0.732335C7.15738 -0.244112 8.84262 -0.244112 9.98842 0.732335C10.4794 1.15077 11.0899 1.40364 11.733 1.45496C13.2336 1.57471 14.4253 2.76636 14.545 4.26701C14.5964 4.91008 14.8492 5.52057 15.2677 6.01158C16.2441 7.15738 16.2441 8.84262 15.2677 9.98842C14.8492 10.4794 14.5964 11.0899 14.545 11.733C14.4253 13.2336 13.2336 14.4253 11.733 14.545C11.0899 14.5964 10.4794 14.8492 9.98842 15.2677C8.84262 16.2441 7.15738 16.2441 6.01158 15.2677C5.52057 14.8492 4.91008 14.5964 4.26701 14.545C2.76636 14.4253 1.57471 13.2336 1.45496 11.733C1.40364 11.0899 1.15077 10.4794 0.732335 9.98842C-0.244112 8.84262 -0.244112 7.15738 0.732335 6.01158C1.15077 5.52057 1.40364 4.91008 1.45496 4.26701C1.57471 2.76636 2.76636 1.57471 4.26701 1.45496ZM11.7071 6.70711C12.0976 6.31658 12.0976 5.68342 11.7071 5.29289C11.3166 4.90237 10.6834 4.90237 10.2929 5.29289L7 8.58579L5.70711 7.29289C5.31658 6.90237 4.68342 6.90237 4.29289 7.29289C3.90237 7.68342 3.90237 8.31658 4.29289 8.70711L6.29289 10.7071C6.68342 11.0976 7.31658 11.0976 7.70711 10.7071L11.7071 6.70711Z" fill="#5F6F94"/></svg>';
        $checkmark_svg_dark = '<svg class="dark_liicon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.26701 1.45496C4.91008 1.40364 5.52057 1.15077 6.01158 0.732335C7.15738 -0.244112 8.84262 -0.244112 9.98842 0.732335C10.4794 1.15077 11.0899 1.40364 11.733 1.45496C13.2336 1.57471 14.4253 2.76636 14.545 4.26701C14.5964 4.91008 14.8492 5.52057 15.2677 6.01158C16.2441 7.15738 16.2441 8.84262 15.2677 9.98842C14.8492 10.4794 14.5964 11.0899 14.545 11.733C14.4253 13.2336 13.2336 14.4253 11.733 14.545C11.0899 14.5964 10.4794 14.8492 9.98842 15.2677C8.84262 16.2441 7.15738 16.2441 6.01158 15.2677C5.52057 14.8492 4.91008 14.5964 4.26701 14.545C2.76636 14.4253 1.57471 13.2336 1.45496 11.733C1.40364 11.0899 1.15077 10.4794 0.732335 9.98842C-0.244112 8.84262 -0.244112 7.15738 0.732335 6.01158C1.15077 5.52057 1.40364 4.91008 1.45496 4.26701C1.57471 2.76636 2.76636 1.57471 4.26701 1.45496ZM11.7071 6.70711C12.0976 6.31658 12.0976 5.68342 11.7071 5.29289C11.3166 4.90237 10.6834 4.90237 10.2929 5.29289L7 8.58579L5.70711 7.29289C5.31658 6.90237 4.68342 6.90237 4.29289 7.29289C3.90237 7.68342 3.90237 8.31658 4.29289 8.70711L6.29289 10.7071C6.68342 11.0976 7.31658 11.0976 7.70711 10.7071L11.7071 6.70711Z" fill="#D7DBE4"/></svg>';

        ?>
        <style>
            .js-dark .default_liicon,
            .dark_liicon {
                display: none;
            }

            .js-dark .dark_liicon {
                display: block;
            }

            .hz-slider-section .swiper-slide ul li>span>svg {
                width: 14px;
                height: 14px;
            }
        </style>
        <section class="custom-container">
            <div class="hz-slider-section">
                <section class="slider">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <?php if (!empty($slider_items)): ?>
                                <?php foreach ($slider_items as $item): ?>
                                    <?php
                                    $title = !empty($item['slider_title']) ? $item['slider_title'] : '';
                                    $image_default = !empty($item['slider_image_default']['url']) ? $item['slider_image_default']['url'] : '';
                                    $image_default_alt = !empty($item['slider_image_default']['alt']) ? $item['slider_image_default']['alt'] : $title;
                                    $image_dark = !empty($item['slider_image_dark']['url']) ? $item['slider_image_dark']['url'] : $image_default;
                                    $image_dark_alt = !empty($item['slider_image_dark']['alt']) ? $item['slider_image_dark']['alt'] : $image_default_alt;
                                    $description = !empty($item['slider_description']) ? $item['slider_description'] : '';
                                    $list_items = !empty($item['list_items']) ? $item['list_items'] : [];
                                    ?>
                                    <div class="swiper-slide">
                                        <?php if (!empty($image_default)): ?>
                                            <div class="slider-image">
                                                <img class="radius-12 white_theme_img" src="<?php echo esc_url($image_default); ?>"
                                                    alt="<?php echo esc_attr($image_default_alt); ?>">
                                                <img class="radius-12 black_theme_img" src="<?php echo esc_url($image_dark); ?>"
                                                    alt="<?php echo esc_attr($image_dark_alt); ?>">
                                            </div>
                                        <?php endif; ?>
                                        <div class="slider-content">
                                            <?php if (!empty($title)): ?>
                                                <h3><?php echo esc_html($title); ?></h3>
                                            <?php endif; ?>
                                            <?php if (!empty($description)): ?>
                                                <p><?php echo wp_kses_post($description); ?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($list_items)): ?>
                                                <ul>
                                                    <?php foreach ($list_items as $list_item): ?>
                                                        <?php $list_text = !empty($list_item['list_item_text']) ? $list_item['list_item_text'] : ''; ?>
                                                        <?php if (!empty($list_text)): ?>
                                                            <li>
                                                                <span>
                                                                    <?php echo $checkmark_svg_default; ?>
                                                                    <?php echo $checkmark_svg_dark; ?>
                                                                </span>
                                                                <?php echo esc_html($list_text); ?>
                                                            </li>


                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                        
                                    </div>

                       


                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="swiper-slide">
                            <div class="slider-image_content">

                                <div class="slider-image">
                                    <img decoding="async" class="radius-12 white_theme_img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/12/Light-QR.svg"
                                        alt="Lear more about how surveillance and security come together in one dashboard">
                                    <img decoding="async" class="radius-12 black_theme_img"
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/12/Dark-QR.svg"
                                        alt="Lear more about how surveillance and security come together in one dashboard">
                                </div>
                                <div class="slider-content_txt">
                                    <h3>Lear more about how surveillance and security come together in one dashboard
                                    </h3>
                                    <div class="btn-sec_gap justify-content-center full_mobile"><a
                                            class="theme-btn-white xl-btn border-btn-grey" href="#">Request
                                            technical walkthrough</a></div>
                                </div>
                            </div>
                            </div>



                        </div>
                    </div>
                </section>
            </div>
        </section>

        <!-- <script>
            (function($) {
                $(document).ready(function() {
                    if (typeof Swiper !== 'undefined' && $('.hz-slider-section .swiper').length > 0) {
                        new Swiper('.hz-slider-section .swiper', {
                            slidesPerView: 'auto',
                            spaceBetween: 24,
                            freeMode: true,
                            grabCursor: true,
                        });
                    }
                });
            });
        </script> -->

        <?php
    }
}
?>
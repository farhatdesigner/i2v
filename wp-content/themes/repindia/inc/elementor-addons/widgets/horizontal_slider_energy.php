<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH'))
    exit;

class Horizontal_Slider_Energy extends Widget_Base
{

    public function get_name()
    {
        return 'horizontal_slider_energy';
    }

    public function get_title()
    {
        return 'Horizontal Slider Energy';
    }

    public function get_icon()
    {
        return 'fa fa-th';
    }

    public function get_categories()
    {
        return ['general'];
    }

    // Load Elementor's bundled Swiper (DO NOT load your own)
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
        // Default Theme Icon Image
        $repeater->add_control(
            'logo_icon_image',
            [
                'label' => esc_html__('Logo Icon Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );
        // Dark Theme Icon Dark Image
        $repeater->add_control(
            'logo_dark_icon_image',
            [
                'label' => esc_html__('Logo Dark Icon Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default logo icon for dark theme', 'repindia'),
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
        
        ?>
        
       <style>
        /* Ensure energy slider full width, starts from container, auto-adjust slides */
        .elementor-widget-horizontal_slider_energy,
        .elementor-widget-horizontal_slider_energy > .elementor-widget-container {
          padding: 0 !important;
          margin: 0 !important;
          max-width: 100% !important;
          width: 100% !important;
        }
        .hz-slider-energy .energyswiper {
          width: 100%;
          overflow: visible;
        }
        .hz-slider-energy .slider {
          width: 100%;
        }
        .hz-slider-energy .static_slide .slider-image.slider_static_img img{ width: auto;height: auto; }
        .hz-slider-energy .swiper-slide.static_slide{background: transparent;}
        .static_slide .slider-image_content{ 
          flex: 1;
          display: flex;
          flex-direction: column;
          min-height: 100%;
        }
        .hz-slider-topcaption.hz-slider-energy .swiper-slide .slider-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            justify-content: flex-end;
            padding: 32px;
            z-index: 333;
        }
        .hz-slider-topcaption.hz-slider-energy .swiper-slide .slider-content img {
            width: 45px;
            height: 45px;
            border-radius:0;
        }
        .hz-slider-topcaption.hz-slider-energy .swiper-slide .slider-image { position: relative; }
        .hz-slider-topcaption.hz-slider-energy .swiper-slide{ position: relative;padding: 0;border-radius: 12px; }
        .hz-slider-topcaption.hz-slider-energy .swiper-slide:before {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.00) 0%, #000 100%);
            padding: 0;
            width: 100%;
            height: 100%;
            content: '';
            position: absolute;
            z-index: 2;
            border-radius: 12px;
        }
        .hz-slider-topcaption.hz-slider-energy .swiper-slide h3 {
            font-size: 28px;
            font-style: normal;
            font-weight: 500!important;
            line-height: 34px;
            color: rgba(255, 255, 255, 0.90);
            margin-bottom: 8px;
            margin-top: 17px;
            max-width: 85%;
        }
        .hz-slider-topcaption.hz-slider-energy .swiper-slide p, .hz-slider-topcaption.hz-slider-energy .swiper-slide .collapsed_desc-inner {
            color: #AEB6C9;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px !important;
            margin: 0;
            max-width: 85%;
        }
        .hz-slider-topcaption.hz-slider-energy .slider-image img.bgslider_img {
            height: 475px;
            min-height: 475px;
            max-height: 100%;
        }
        /* Expand/collapse description - energy slider only */
        .hz-slider-energy .slider-content {
            position: relative;
        }
        .hz-slider-energy .collapsed_desc {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hz-slider-energy .collapsed_desc-inner {
            overflow: hidden;
        }
        .hz-slider-energy .slider-content.expanded .collapsed_desc {
            grid-template-rows: 1fr;
        }
        .hz-slider-energy .energy-toggle-btn {
            position: absolute;
            bottom: 32px;
            right: 32px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #464A4F;
            color: #fff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            line-height: 1;
            font-weight: 300;
            transition: background 0.25s ease, transform 0.2s ease;
            z-index: 5;
        }
        .hz-slider-energy .energy-toggle-btn:hover {
            background: #5a5f66;
        }
        .hz-slider-energy .energy-toggle-btn .icon-minus,
        .hz-slider-energy .energy-toggle-btn .icon-plus {
            transition: opacity 0.25s ease;
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hz-slider-energy .energy-toggle-btn .icon-minus { opacity: 0; }
        .hz-slider-energy .energy-toggle-btn .icon-plus { opacity: 1; }
        .hz-slider-energy .slider-content.expanded .energy-toggle-btn .icon-minus { opacity: 1; }
        .hz-slider-energy .slider-content.expanded .energy-toggle-btn .icon-plus { opacity: 0; }
        .hz-slider-energy .slider-content:has(.energy-toggle-btn) {
            padding-right: 52px;
            padding-bottom: 8px;
        }
        .hz-slider-energy .collapsed_desc-inner p {
            margin: 0 0 8px;
        }
        .hz-slider-energy .collapsed_desc-inner p:last-child {
            margin-bottom: 0;
        }
        @media(max-width: 768px){
            .static_slide .slider-image_content { 
              min-height: 100%;
              padding: 38px;
            }
            .hz-slider-topcaption.hz-slider-energy .slider-image img.bgslider_img {
                height: 100%;
                min-height: 370px;
            }
            .hz-slider-topcaption.hz-slider-energy .swiper-slide h3 {
                font-size: 20px;
                font-style: normal;
                line-height: 24px;
                margin-top: 15px;
                max-width: 90%;
                padding-right: 15px;
            }
            .hz-slider-energy .energy-toggle-btn{ bottom: 15px;
                right: 15px;
                width: 35px;
                height: 35px; 
            }
            .hz-slider-topcaption.hz-slider-energy .swiper-slide p,.hz-slider-topcaption.hz-slider-energy .swiper-slide .collapsed_desc-inner {
                font-size: 14px;
                line-height: 20px !important;
            }
            .hz-slider-topcaption.hz-slider-energy .swiper-slide .slider-content {
                padding: 15px;
            }
            .hz-slider-topcaption.hz-slider-energy .swiper-slide .slider-content img {
                width: 35px;
                height: 35px;
                border-radius:0;
            }
        }
       </style>
        <!-- <div class="custom-container"> -->
            <div class="hz-slider-topcaption hz-slider-energy">
                <section class="slider">
                <div class="swiper energyswiper">
                    <div class="swiper-wrapper">
                        <?php if (!empty($slider_items)) : ?>
                        <?php foreach ($slider_items as $item) : ?>
                                <?php
                                $title = !empty($item['slider_title']) ? $item['slider_title'] : '';
                                $image_default = !empty($item['slider_image_default']['url']) ? $item['slider_image_default']['url'] : '';
                                $image_default_alt = !empty($item['slider_image_default']['alt']) ? $item['slider_image_default']['alt'] : $title;
                                $image_dark = !empty($item['slider_image_dark']['url']) ? $item['slider_image_dark']['url'] : $image_default;
                                $image_dark_alt = !empty($item['slider_image_dark']['alt']) ? $item['slider_image_dark']['alt'] : $image_default_alt;
                                $default_logo_icon = !empty($item['logo_icon_image']['url']) ? $item['logo_icon_image']['url'] : '';
                                $default_logo_icon_alt = !empty($item['logo_icon_image']['alt']) ? $item['logo_icon_image']['alt'] : $title;
                                $dark_logo_image_ = !empty($item['logo_dark_icon_image']['url']) ? $item['logo_dark_icon_image']['url'] : $default_logo_icon;
                                $dark_logo_image__alt = !empty($item['logo_dark_icon_image']['alt']) ? $item['logo_dark_icon_image']['alt'] : $default_logo_icon_alt;
                                $description = !empty($item['slider_description']) ? $item['slider_description'] : '';
                                ?>
                                <div class="swiper-slide">
                                    <div class="slider-image">
                                        <?php if (!empty($image_default)) : ?>
                                            <img class="bgslider_img white_theme_img" src="<?php echo esc_url($image_default); ?>" alt="<?php echo esc_attr($image_default_alt); ?>">
                                            <img class="bgslider_img black_theme_img" src="<?php echo esc_url($image_dark); ?>" alt="<?php echo esc_attr($image_dark_alt); ?>">
                                        <?php endif; ?>
                                        <div class="slider-content">
                                            <?php if (!empty($default_logo_icon)) : ?>
                                                <img class="logo_iconimg white_theme_img" src="<?php echo esc_url($default_logo_icon); ?>" alt="<?php echo esc_attr($default_logo_icon_alt); ?>">
                                                <img class="logo_iconimg black_theme_img" src="<?php echo esc_url($dark_logo_image_); ?>" alt="<?php echo esc_attr($dark_logo_image__alt); ?>">
                                            <?php endif; ?>
                                            <?php if (!empty($title)) : ?>
                                                <h3><?php echo esc_html($title); ?></h3>
                                            <?php endif; ?>
                                            <?php if (!empty($description)) : ?>
                                                <div class="collapsed_desc">
                                                    <div class="collapsed_desc-inner">
                                                        <?php echo wp_kses_post($description); ?>
                                                    </div>
                                                </div>
                                                <button type="button" class="energy-toggle-btn" aria-label="<?php echo esc_attr__('Toggle description', 'repindia'); ?>">
                                                    <span class="icon-plus">+</span>
                                                    <span class="icon-minus">−</span>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                    </div>
                </div>
                </section>
            </div>
        <!-- </div> -->

        <script>
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.hz-slider-energy .energy-toggle-btn').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var content = this.closest('.slider-content');
                        if (content) content.classList.toggle('expanded');
                    });
                });
            });
        })();
        </script>

        <?php
    }
}
?>
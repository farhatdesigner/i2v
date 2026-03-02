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
        .hz-slider-topcaption .static_slide .slider-image.slider_static_img img{ width: auto;height: auto; }
        .hz-slider-topcaption .swiper-slide.static_slide{background: transparent;}
        .static_slide .slider-image_content{ 
          flex: 1;
          display: flex;
          flex-direction: column;
          min-height: 100%;
        }
        @media(max-width: 768px){
            .static_slide .slider-image_content { 
              min-height: 100%;
              padding: 38px;
            }
        }
       </style>
        <div class="hz-slider-topcaption">
            <section class="slider">
                <div class="swiper">
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
                                    <div class="slider-content">
                                        <?php if (!empty($default_logo_icon)) : ?>
                                            <img class="logo_iconimg white_theme_img" src="<?php echo esc_url($default_logo_icon); ?>" alt="<?php echo esc_attr($default_logo_icon_alt); ?>">
                                            <img class="logo_iconimg black_theme_img" src="<?php echo esc_url($dark_logo_image_); ?>" alt="<?php echo esc_attr($dark_logo_image__alt); ?>">
                                        <?php endif; ?>
                                        <?php if (!empty($title)) : ?>
                                            <h3><?php echo esc_html($title); ?></h3>
                                        <?php endif; ?>
                                        <?php if (!empty($description)) : ?>
                                            <p><?php echo wp_kses_post($description); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($image_default)) : ?>
                                        <div class="slider-image">
                                            <img class="white_theme_img" src="<?php echo esc_url($image_default); ?>" alt="<?php echo esc_attr($image_default_alt); ?>">
                                            <img class="black_theme_img" src="<?php echo esc_url($image_dark); ?>" alt="<?php echo esc_attr($image_dark_alt); ?>">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                    </div>
                </div>
            </section>
        </div>

        <?php
    }
}
?>
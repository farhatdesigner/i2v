<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH'))
    exit;

class Horizontal_Slider_Topcaption extends Widget_Base
{

    public function get_name()
    {
        return 'horizontal_slider_topcaption';
    }

    public function get_title()
    {
        return 'Horizontal Slider Topcaption';
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
         // Special Slide Section
         $this->start_controls_section(
            'section_special_slide',
            [
                'label' => esc_html__('Static Slide Item', 'repindia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Enable/Disable Special Slide
        $this->add_control(
            'show_special_slide',
            [
                'label' => esc_html__('Show Static Slide Item', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        // Default Theme Icon/Image
        $this->add_control(
            'special_slide_icon_default',
            [
                'label' => esc_html__('Default Theme Icon/Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_template_directory_uri() . '/assets/images/12/Light-QR.svg',
                ],
                'condition' => [
                    'show_special_slide' => 'yes',
                ],
            ]
        );

        // Dark Theme Icon/Image
        $this->add_control(
            'special_slide_icon_dark',
            [
                'label' => esc_html__('Dark Theme Icon/Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => get_template_directory_uri() . '/assets/images/12/Dark-QR.svg',
                ],
                'description' => esc_html__('Leave empty to use default icon for dark theme', 'repindia'),
                'condition' => [
                    'show_special_slide' => 'yes',
                ],
            ]
        );

        // Title
        $this->add_control(
            'special_slide_title',
            [
                'label' => esc_html__('Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Lear more about how surveillance and security come together in one dashboard',
                'label_block' => true,
                'condition' => [
                    'show_special_slide' => 'yes',
                ],
            ]
        );

        // Description
        $this->add_control(
            'special_slide_description',
            [
                'label' => esc_html__('Description', 'repindia'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'label_block' => true,
                'condition' => [
                    'show_special_slide' => 'yes',
                ],
            ]
        );

        // CTA Text
        $this->add_control(
            'special_slide_cta_text',
            [
                'label' => esc_html__('CTA Text', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Request technical walkthrough',
                'label_block' => true,
                'condition' => [
                    'show_special_slide' => 'yes',
                ],
            ]
        );

        // CTA URL
        $this->add_control(
            'special_slide_cta_url',
            [
                'label' => esc_html__('CTA URL', 'repindia'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
                'condition' => [
                    'show_special_slide' => 'yes',
                ],
            ]
        );

        // CTA Additional Classes
        $this->add_control(
            'special_slide_cta_classes',
            [
                'label' => esc_html__('CTA Additional Classes', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__('Add custom CSS classes for the CTA link (separate multiple classes with spaces)', 'repindia'),
                'label_block' => true,
                'condition' => [
                    'show_special_slide' => 'yes',
                ],
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
              text-align: left
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
                                $description = !empty($item['slider_description']) ? $item['slider_description'] : '';
                                ?>
                                <div class="swiper-slide">
                                    <div class="slider-content">
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

                            <?php
                            // Special Slide
                            $show_special_slide = !empty($settings['show_special_slide']) && $settings['show_special_slide'] === 'yes';
                            if ($show_special_slide):
                                $special_icon_default = !empty($settings['special_slide_icon_default']['url']) ? $settings['special_slide_icon_default']['url'] : get_template_directory_uri() . '/assets/images/12/Light-QR.svg';
                                $special_icon_default_alt = !empty($settings['special_slide_icon_default']['alt']) ? $settings['special_slide_icon_default']['alt'] : '';
                                $special_icon_dark = !empty($settings['special_slide_icon_dark']['url']) ? $settings['special_slide_icon_dark']['url'] : get_template_directory_uri() . '/assets/images/12/Dark-QR.svg';
                                $special_icon_dark_alt = !empty($settings['special_slide_icon_dark']['alt']) ? $settings['special_slide_icon_dark']['alt'] : $special_icon_default_alt;
                                $special_title = !empty($settings['special_slide_title']) ? $settings['special_slide_title'] : 'Lear more about how surveillance and security come together in one dashboard';
                                $special_description = !empty($settings['special_slide_description']) ? $settings['special_slide_description'] : '';
                                $special_cta_text = !empty($settings['special_slide_cta_text']) ? $settings['special_slide_cta_text'] : 'Request technical walkthrough';
                                $special_cta_url = !empty($settings['special_slide_cta_url']['url']) ? $settings['special_slide_cta_url']['url'] : '#';
                                $special_cta_target = !empty($settings['special_slide_cta_url']['is_external']) ? 'target="_blank"' : '';
                                $special_cta_nofollow = !empty($settings['special_slide_cta_url']['nofollow']) ? 'rel="nofollow"' : '';
                                $special_cta_classes = !empty($settings['special_slide_cta_classes']) ? ' ' . esc_attr($settings['special_slide_cta_classes']) : '';
                            ?>
                            <div class="swiper-slide static_slide">
                                <div class="slider-image_content">
                                    <!-- <div class="slider-image slider_static_img">
                                        <img decoding="async" class="radius-12 white_theme_img"
                                            src="<?php echo esc_url($special_icon_default); ?>" alt="<?php echo esc_attr($special_icon_default_alt ? $special_icon_default_alt : $special_title); ?>">
                                        <img decoding="async" class="radius-12 black_theme_img"
                                            src="<?php echo esc_url($special_icon_dark); ?>" alt="<?php echo esc_attr($special_icon_dark_alt ? $special_icon_dark_alt : $special_title); ?>">
                                    </div> -->
                                    <div class="slider-content_txt">
                                        <?php if (!empty($special_title)): ?>
                                            <h3><?php echo esc_html($special_title); ?></h3>
                                        <?php endif; ?>
                                        <?php if (!empty($special_description)): ?>
                                            <div class="special-slide-description">
                                                <?php echo wp_kses_post($special_description); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($special_cta_text)): ?>
                                            <div class="btn-sec_gap justify-content-center full_mobile">
                                                <a class="theme-btn-white  border-btn-grey<?php echo $special_cta_classes; ?>" href="<?php echo esc_url($special_cta_url); ?>" <?php echo esc_attr($special_cta_target); ?> <?php echo esc_attr($special_cta_nofollow); ?>><?php echo esc_html($special_cta_text); ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>

        <?php
    }
}
?>
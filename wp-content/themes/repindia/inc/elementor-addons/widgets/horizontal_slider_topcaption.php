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
        ?>

        <div class="hz-slider-topcaption">
            <section class="slider">
                <div class="swiper">
                    <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="slider-content">
                                    <h3>Highways & expressways</h3>
                                    <p>
                                        Enforce rules, detect accidents, and monitor traffic flow with precision ANPR.
                                    </p>
                                </div>
                                <div class="slider-image">
                                    <img class="white_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/oil-and-gas.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                    <img class="black_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/oil-and-gas.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slider-content">
                                    <h3>Tunnels & bridges</h3>
                                    <p>
                                        Spot incidents fast, monitor smoke/fire, and ensure safe emergency access.
                                    </p>
                                </div>
                                <div class="slider-image">
                                    <img class="white_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/transportation.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                    <img class="black_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/transportation.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slider-content">
                                    <h3>Ports & shipping yards</h3>
                                    <p>
                                        Secure perimeters, protect cargo, and safeguard workforce operations.
                                    </p>
                                </div>
                                <div class="slider-image">
                                    <img class="white_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Energy.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                    <img class="black_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Energy.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slider-content">
                                    <h3>Bus fleets & depots</h3>
                                    <p>
                                        Ensure passenger safety, monitor occupancy, and capture critical incidents.
                                    </p>
                                </div>
                                <div class="slider-image">
                                    <img class="white_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/government.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                    <img class="black_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/government.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive </p>
                                </div>
                                <div class="slider-image">
                                    <img class="white_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/transportation.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                    <img class="black_theme_img" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/transportation.webp"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                            </div>
                    </div>
                </div>
            </section>
        </div>

        <?php
    }
}
?>
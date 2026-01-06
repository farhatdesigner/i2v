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

        <section class="custom-container">
            <div class="hz-slider-section">
                <section class="slider">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div> <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div> <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div> <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div> <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div> <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div> <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div> <div class="swiper-slide">
                                <div class="slider-image">
                                    <img class="radius-12"  src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Frame-324.png"
                                        alt="Object Tagging and Metadata based search for faster investigations">
                                </div>
                                <div class="slider-content">
                                    <h3>Brand, Strategy & Reputation</h3>
                                    <p>
                                        Protect your reputation, unlok growth and gain a competitive
                                        advantage with resilient blue building
                                    </p>
                                    <ul>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                        <li>
                                            <span>
                                                <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/12/Icon.svg"
                                                    alt="Object Tagging and Metadata based search for faster investigations">
                                            </span>
                                            Recognize faces from live video, snapshots, and archives
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>

        <?php
    }
}
?>
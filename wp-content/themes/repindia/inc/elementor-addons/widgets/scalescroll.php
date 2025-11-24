<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (!defined('ABSPATH'))
    exit;

class Scalescroll extends Widget_Base
{
    public function get_name()
    {
        return 'scalescroll';
    }

    public function get_title()
    {
        return 'Scale Scroll';
    }

    public function get_icon()
    {
        return 'fa fa-arrows-alt';
    }

    public function get_category()
    {
        return ['general'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Content Settings',
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'repindia'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '<h2>Scale on Scroll</h2><p>This content will scale as you scroll.</p>',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'min_scale',
            [
                'label' => esc_html__('Minimum Scale', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0.8,
                ],
                'description' => esc_html__('Minimum scale when element is out of view', 'repindia'),
            ]
        );

        $this->add_control(
            'max_scale',
            [
                'label' => esc_html__('Maximum Scale', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'description' => esc_html__('Maximum scale when element is in view', 'repindia'),
            ]
        );

        $this->add_control(
            'scroll_offset',
            [
                'label' => esc_html__('Scroll Offset', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'description' => esc_html__('Offset from viewport center for scaling effect', 'repindia'),
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => 'Style',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label' => esc_html__('Text Alignment', 'repindia'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'repindia'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'repindia'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'repindia'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .scale-scroll-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .scale-scroll-content',
            ]
        );

        $this->end_controls_section();
    }

    // PHP Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes('custom_class', 'basic'); ?>



        <div class="sectionsscroll">
            <div class="custom-container">
                <div class="col-lg-6 col-12">
                    <h3 class="main_title quote mb-12">
                        Designed to fit. Ready to scale.
                    </h3>
                    <div class="text-left">
                        <p>i2V VA integrates smoothly into your existing infrastructure — no rip-and-replace needed. From ONVIF cameras to control room software, it just works.</p>
                    </div>
                </div>
                <div class="sections_box">
                    <div class="panels flex-center">
                        <section class="panel ">
                            <div class="logo_box">
                                <ul>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-17.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <li><img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-13.svg"></li>
                                    <!-- <li>
                                        <span>and more</span>
                                        <div class="text-center ">
                                            <a href="#" class="theme-btn bg-trans border_btnlight">View all supported devices</a>
                                        </div>
                                    </li> -->

                                </ul>
                            </div>
                        </section>
                        <section class="panel animate-right ">
                            <img class="radius-12" decoding="async" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp">
                        </section>
                        <section class="panel animate-right ">
                            <img class="radius-12" decoding="async" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp">
                        </section>
                        <section class="panel animate-right ">
                            <img class="radius-12" decoding="async" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp">
                        </section>
                        <section class="panel animate-right ">
                            <img class="radius-12" decoding="async" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp">
                        </section>
                    </div>
                    <div class="container-page flex-center">
                        <div class="contento  ">
                            <div class="txtflex">
                                <h2>100+ IP camera brands supported</h2>
                                <p class="para-text">Seamlessly integrates with major camera vendors — no hardware replacement needed.</p>
                            </div>
                        </div>
                        <div class="contento  animate-left">
                            <div class="txtflex">
                                <h2>ONVIF-compliant for plug-and-play compatibility</h2>
                                <p class="para-text">Works out-of-the-box with ONVIF-compliant devices for simplified system integration.</p>
                            </div>
                        </div>
                        <div class="contento  animate-left">
                            <div class="txtflex">
                                <h2>Works across LAN deployments — no internet needed</h2>
                                <p class="para-text">Secure, reliable performance in offline environments with zero cloud dependency.</p>
                            </div>
                        </div>
                        <div class="contento  animate-left">
                            <div class="txtflex">
                                <h2>Supports both Windows and Linux systems</h2>
                                <p class="para-text">Flexible installation across your existing OS infrastructure — no vendor lock-in.</p>
                                <div class="bolt">
                                    <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-1.svg">
                                    <p>Deployed across 11+ smart cities without replacing existing hardware.</p>
                                    <div class="btn-bolt">
                                        <a href="#">Request a demo to lean more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="contento  animate-left">
                            <div class="txtflex">
                                <h2>Available in web, desktop and mobile based client versions</h2>
                                <p class="para-text">Access analytics through browser or installed software, depending on operational preference.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php
    }
}
?>
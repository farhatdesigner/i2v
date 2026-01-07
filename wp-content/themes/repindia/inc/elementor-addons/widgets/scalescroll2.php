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

class Scalescroll2 extends Widget_Base
{
    public function get_name()
    {
        return 'scalescroll2';
    }

    public function get_title()
    {
        return 'Scale Scroll 2';
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
                'type' => Controls_Manager::WYSIWYG,
                'default' => '<h2>Scale on Scroll</h2><p>This content will scale as you scroll.</p>',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'min_scale',
            [
                'label' => esc_html__('Minimum Scale', 'repindia'),
                'type' => Controls_Manager::SLIDER,
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
                'type' => Controls_Manager::SLIDER,
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
                'type' => Controls_Manager::SLIDER,
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
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_align',
            [
                'label' => esc_html__('Text Alignment', 'repindia'),
                'type' => Controls_Manager::CHOOSE,
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
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .scale-scroll-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
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



        <div class="makdmks scalescroll2-widget">
            <div class="custom-container">
                <div class="title-box">
                    <div class="col-lg-5 col-xl-4 col-12">
                        <h3 class="main_title quote mb-12">
                        Real-world impact of i2V in oil & gas operations
                        </h3>
                        <div class="text-left">
                            <p>Our solutions are designed for real challenges on the ground. From remote pipelines to high-risk refineries, here’s how i2V delivers measurable value in critical scenarios.</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="sections_box">
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
                                        <a href="#">Request a demo to learn  more</a>
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
                </div> -->



                <div class="gallery">
                    <div class="left">
                        <div class="detailsWrapper">
                            <div class="details details-1">
                                <div class="txtflex">
                                <div class="bredstyle"><a href="#">Securing remote pipelines</a></div>
                                    <h2>Detect unauthorised access before damage occurs</h2>
                                    <p class="para-text">Pipelines stretch across isolated terrains, making them vulnerable to intrusion, theft, or sabotage. i2V provides instant detection of unauthorized activity, enabling security teams to act swiftly and avoid costly disruptions.</p>
                                </div>
                            </div>

                            <div class="details details-2">
                                <div class="txtflex">
                                    <h2>ONVIF-compliant for plug-and-play compatibility</h2>
                                    <p class="para-text">Works out-of-the-box with ONVIF-compliant devices for simplified system integration.</p>
                                </div>
                            </div>

                            <div class="details details-3">
                                <div class="headline blue"></div>
                                <div class="txtflex">
                                    <h2>Works across LAN deployments — no internet needed</h2>
                                    <p class="para-text">Secure, reliable performance in offline environments with zero cloud dependency.</p>
                                </div>
                            </div>

                            <div class="details details-4">
                                <div class="txtflex">
                                    <h2>Supports both Windows and Linux systems</h2>
                                    <p class="para-text">Flexible installation across your existing OS infrastructure — no vendor lock-in.</p>
                                    <div class="bolt">
                                        <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-1.svg">
                                        <p>Deployed across 11+ smart cities without replacing existing hardware.</p>
                                        <div class="btn-bolt">
                                            <a href="#">Request a demo to learn  more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="details details-5">
                                <div class="txtflex">
                                    <h2>Available in web, desktop and mobile based client versions</h2>
                                    <p class="para-text">Access analytics through browser or installed software, depending on operational preference.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="right">
                        <div class="photos">
                            <div class="photo photo_custom">
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


                                    </ul>
                                </div>

                                <div class="details details-1">
                                    <div class="txtflex">
                                        <h2>Detect unauthorised access before damage occurs</h2>
                                        <p class="para-text">Pipelines stretch across isolated terrains, making them vulnerable to intrusion, theft, or sabotage. i2V provides instant detection of unauthorized activity, enabling security teams to act swiftly and avoid costly disruptions.</p>
                                    </div>
                                </div>
                            </div>


                            <div class="photo photo_custom"> <img class="radius-12" decoding="async" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Frame-271.webp">
                                <div class="details details-2">
                                    <div class="txtflex">
                                        <h2>ONVIF-compliant for plug-and-play compatibility</h2>
                                        <p class="para-text">Works out-of-the-box with ONVIF-compliant devices for simplified system integration.</p>
                                    </div>
                                </div>
                            </div>


                            <div class="photo photo_custom"> <img class="radius-12" decoding="async" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Frame-270.webp">
                                <div class="details details-3">
                                    <div class="headline blue"></div>
                                    <div class="txtflex">
                                        <h2>Works across LAN deployments — no internet needed</h2>
                                        <p class="para-text">Secure, reliable performance in offline environments with zero cloud dependency.</p>
                                    </div>
                                </div>
                            </div>


                            <div class="photo photo_custom"><img class="radius-12" decoding="async" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Frame-273.webp">
                                <div class="details details-4">
                                    <div class="txtflex">
                                        <h2>Supports both Windows and Linux systems</h2>
                                        <p class="para-text">Flexible installation across your existing OS infrastructure — no vendor lock-in.</p>
                                        <div class="bolt">
                                            <img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/item-1.svg">
                                            <p>Deployed across 11+ smart cities without replacing existing hardware.</p>
                                            <div class="btn-bolt">
                                                <a href="#">Request a demo to learn  more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="photo photo_custom"> <img class="radius-12" decoding="async" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/Frame-272.webp">
                                <div class="details details-5">
                                    <div class="txtflex">
                                        <h2>Available in web, desktop and mobile based client versions</h2>
                                        <p class="para-text">Access analytics through browser or installed software, depending on operational preference.</p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- 
                <div class="spacer"></div>
                <div class="spacer"></div>
                <div class="spacer"></div> -->



            </div>
        </div>


<?php
    }
}
?>


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

class Video_accordion extends Widget_Base
{
    public function get_name()
    {
        return 'video_accordion';
    }

    public function get_title()
    {
        return 'Video Accordion';
    }

    public function get_icon()
    {
        return 'fa fa-video-camera';
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
            'section_title',
            [
                'label' => esc_html__('Section Title', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Video Accordion',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => esc_html__('Section Description', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Click on each accordion item to view the video content.',
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'accordion_title',
            [
                'label' => esc_html__('Accordion Title', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Video Title',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'accordion_description',
            [
                'label' => esc_html__('Accordion Description', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Video description text here.',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'video_type',
            [
                'label' => esc_html__('Video Type', 'repindia'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__('YouTube', 'repindia'),
                    'vimeo' => esc_html__('Vimeo', 'repindia'),
                    'self_hosted' => esc_html__('Self Hosted', 'repindia'),
                ],
            ]
        );

        $repeater->add_control(
            'youtube_url',
            [
                'label' => esc_html__('YouTube URL', 'repindia'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://www.youtube.com/watch?v=xxxxx', 'repindia'),
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'video_type' => 'youtube',
                ],
            ]
        );

        $repeater->add_control(
            'vimeo_url',
            [
                'label' => esc_html__('Vimeo URL', 'repindia'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://vimeo.com/xxxxx', 'repindia'),
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'video_type' => 'vimeo',
                ],
            ]
        );

        $repeater->add_control(
            'self_hosted_video',
            [
                'label' => esc_html__('Video File', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'condition' => [
                    'video_type' => 'self_hosted',
                ],
            ]
        );

        $repeater->add_control(
            'video_poster',
            [
                'label' => esc_html__('Video Poster Image', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'video_type' => 'self_hosted',
                ],
            ]
        );

        $repeater->add_control(
            'accordion_icon',
            [
                'label' => esc_html__('Accordion Icon', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'accordion_list',
            [
                'label' => esc_html__('Accordion Items', 'repindia'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'accordion_title' => 'Video Item 1',
                        'accordion_description' => 'Description for video item 1',
                    ],
                    [
                        'accordion_title' => 'Video Item 2',
                        'accordion_description' => 'Description for video item 2',
                    ],
                ],
                'title_field' => '{{{ accordion_title }}}',
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
            'title_color',
            [
                'label' => esc_html__('Title Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .video-accordion-title',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-accordion-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // Helper function to extract video ID from YouTube URL
    private function get_youtube_id($url)
    {
        if (empty($url)) {
            return '';
        }

        $parsed_url = parse_url($url);

        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $query);
            if (isset($query['v'])) {
                return $query['v'];
            }
        }

        // Handle short URLs like youtube.com/v/VIDEO_ID
        if (isset($parsed_url['path'])) {
            $path = trim($parsed_url['path'], '/');
            $path_parts = explode('/', $path);
            if (count($path_parts) > 0) {
                $last_part = end($path_parts);
                if (strlen($last_part) == 11) {
                    return $last_part;
                }
            }
        }

        return '';
    }

    // Helper function to extract video ID from Vimeo URL
    private function get_vimeo_id($url)
    {
        if (empty($url)) {
            return '';
        }

        $parsed_url = parse_url($url);

        if (isset($parsed_url['path'])) {
            $path = trim($parsed_url['path'], '/');
            $path_parts = explode('/', $path);
            if (count($path_parts) > 0) {
                return end($path_parts);
            }
        }

        return '';
    }

    // PHP Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes('custom_class', 'basic'); ?>


        <section class="accordion_wrap">
            <div class="custom-container radius-8 text-white">


                <div class="row g-0 align-items-center bg-blacktheme">
                    <div class="col-md-6 col-12 padd-accordion thene-bg">


                        <div class="main_title_box">
                            <h3 class="main_title quote text-white">
                                See how i2V Video Analytics makes surveillance smarter.
                            </h3>
                            <div class="text-left">
                                <p>A quick walkthrough of how our AI-powered system detects threats, triggers alerts, and enhances response — all without cloud dependency.</p>
                            </div>
                        </div>


                        <div class="accordion_sets">
                            <div class="accordion_set">
                                <div class="ac_icon_wrap lightback">
                                    <div class="ac_icon_border">
                                        <span><img class="ac_icon" alt="null" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon1.svg"></span>
                                    </div>
                                </div>
                                <button class="select_div" aria-label="expand accordion section for section" aria-expanded="false">
                                    <h2 class="ac_header ">
                                        Configure analytics per camera
                                    </h2>
                                </button>
                                <div class="accontent">
                                    <p class="">
                                        Set up detection zones (line, rectangle, polygon), object size filters, direction rules — all through the VMS-integrated interface.</p>
                                    <div class="btn-sec_gap">
                                        <a class="theme-btn bg-tran_lightcolor" href="#">Learn more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion_set">
                                <div class="ac_icon_wrap lightback">
                                    <div class="ac_icon_border">
                                        <span><img class="ac_icon" alt="null" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon2.svg"></span>
                                    </div>
                                </div>
                                <button class="select_div" aria-label="expand accordion section for section" aria-expanded="false">
                                    <h2 class="ac_header ">
                                        Real-time detection with FAST
                                    </h2>
                                </button>
                                <div class="accontent">
                                    <p class="">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Et eveniet aliquam, molestias tempora modi recusandae non natus alias minus quibusdam ipsa tenetur vitae nostrum culpa voluptatum at minima. Quae, voluptas.
                                    </p>
                                    <div class="btn-sec_gap">
                                        <a class="theme-btn bg-tran_lightcolor" href="#">Learn more</a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion_set">
                                <div class="ac_icon_wrap lightback">
                                    <div class="ac_icon_border">
                                        <span><img class="ac_icon" alt="null" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon3.svg"></span>
                                    </div>
                                </div>
                                <button class="select_div" aria-label="expand accordion section for' aria-expanded=" false">
                                    <h2 class="ac_header ">
                                        Instant alerts & playback
                                    </h2>
                                </button>
                                <div class="accontent">
                                    <p class="">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Et eveniet aliquam, molestias tempora modi recusandae non natus alias minus quibusdam ipsa tenetur vitae nostrum culpa voluptatum at minima. Quae, volupta.
                                    </p>
                                    <div class="btn-sec_gap">
                                        <a class="theme-btn bg-tran_lightcolor" href="#">Learn more</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn_demo_box">
                            <h3>Want to see it live?</h3>
                            <div class="btn_demo mt-2">
                                <a class="theme-btn bg-tran_lightcolor" href="#">Request a demo</a>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6 col-12 padd-accordion_video">
                        <div class="accordion_video">
                            <img data-bs-toggle="modal" data-bs-target="#staticBackdrop" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp" alt="null" width="100%" height="100%">
                            <!-- Vertically centered modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Configure analytics per camera</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <iframe width="100%" height="400"
                                                src="https://www.youtube.com/embed/9xwazD5SyVg?autoplay=1"
                                                frameborder="0"
                                                allow="autoplay; encrypted-media"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion_video">
                            <img data-bs-toggle="modal" data-bs-target="#staticBackdroptwo" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp" alt="null" width="100%" height="100%">
                            <!-- Vertically centered modal -->
                            <div class="modal fade" id="staticBackdroptwo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Configure analytics per camera</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <iframe width="100%" height="400"
                                                src="https://www.youtube.com/embed/9xwazD5SyVg?autoplay=1"
                                                frameborder="0"
                                                allow="autoplay; encrypted-media"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion_video">
                            <img data-bs-toggle="modal" data-bs-target="#staticBackdropthree" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp" alt="null" width="100%" height="100%">
                            <!-- Vertically centered modal -->
                            <div class="modal fade" id="staticBackdropthree" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Configure analytics per camera</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <iframe width="100%" height="400"
                                                src="https://www.youtube.com/embed/9xwazD5SyVg?autoplay=1"
                                                frameborder="0"
                                                allow="autoplay; encrypted-media"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
<?php
    }
}
?>
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

class Video_accordionwhite extends Widget_Base
{
    public function get_name()
    {
        return 'video_accordionwhite';
    }

    public function get_title()
    {
        return 'Video Accordion White';
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
                    '{{WRAPPER}} .vaw-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .vaw-title',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vaw-description' => 'color: {{VALUE}};',
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

        <!-- Video Accordion White - Inline CSS -->
        <style>
            /* Video Accordion White - Unique Styles */
            .vaw_accordion_wrap {
                background: #fff;
                padding: 60px 0;
            }

            .vaw_vertical_scroller {
                align-items: flex-start;
            }

            .vaw_padd-accordion {
                padding: 40px;
            }

            .vaw_padd-accordion_video {
                padding: 40px;
                position: sticky;
                top: 100px;
            }

            .vaw_main_title_box {
                margin-bottom: 40px;
            }

            .vaw_main_title {
                font-size: 36px;
                font-weight: 700;
                color: #1a2b4a;
                line-height: 1.3;
                margin: 0;
            }

            .vaw_accordion_sets {
                display: flex;
                flex-direction: column;
            }

            .vaw_accordion_set {
                position: relative;
                border-bottom: 1px solid #e5e7eb;
                padding: 0;
            }

            .vaw_accordion_set:first-child {
                border-top: 1px solid #e5e7eb;
            }

            .vaw_select_div {
                display: flex;
                align-items: center;
                width: 100%;
                padding: 20px 0;
                background: transparent;
                border: none;
                cursor: pointer;
                text-align: left;
                gap: 15px;
            }

            .vaw_ac_icon_wrap {
                position: absolute;
                left: 0;
                top: 20px;
            }

            .vaw_ac_icon_border {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: #e8f4fc;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .vaw_accordion_set.active .vaw_ac_icon_border {
                background: #0066cc;
            }

            .vaw_ac_icon {
                width: 24px;
                height: 24px;
                object-fit: contain;
                transition: filter 0.3s ease;
            }

            .vaw_accordion_set.active .vaw_ac_icon {
                filter: brightness(0) invert(1);
            }

            .vaw_ac_header {
                flex: 1;
                font-size: 18px;
                font-weight: 600;
                color: #1a2b4a;
                margin: 0 0 0 63px;
                line-height: 1.4;
            }

            .vaw_chevron {
                width: 24px;
                height: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform 0.3s ease;
                margin-left: auto;
            }

            .vaw_chevron svg {
                width: 20px;
                height: 20px;
                stroke: #6b7280;
                transition: stroke 0.3s ease;
            }

            .vaw_accordion_set.active .vaw_chevron {
                transform: rotate(180deg);
            }

            .vaw_accordion_set.active .vaw_chevron svg {
                stroke: #0066cc;
            }

            .vaw_accontent {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.4s ease, padding 0.4s ease;
                padding: 0 0 0 63px;
            }

            .vaw_accordion_set.active .vaw_accontent {
                max-height: 500px;
                padding: 0 0 20px 63px;
            }

            .vaw_accontent p {
                font-size: 15px;
                color: #4b5563;
                line-height: 1.6;
                margin: 0 0 15px 0;
            }

            .vaw_accontent .vaw_accordion_video {
                margin-top: 15px;
                border-radius: 8px;
                overflow: hidden;
                display: none;
            }

            .vaw_accordion_set.active .vaw_accontent .vaw_accordion_video {
                display: block;
            }

            .vaw_accontent .vaw_accordion_video img {
                width: 100%;
                height: auto;
                cursor: pointer;
                transition: transform 0.3s ease;
            }

            .vaw_accontent .vaw_accordion_video img:hover {
                transform: scale(1.02);
            }

            /* Progress Bar - Bottom Position with CSS Variable */
            .vaw_progress_bar {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background: linear-gradient(
                    to right,
                    #0066cc 0%,
                    #0066cc var(--vaw-progress, 0%),
                    #e5e7eb var(--vaw-progress, 0%),
                    #e5e7eb 100%
                );
                transition: none;
            }

            /* Right Side Image Container */
            .vaw_padd-accordion_video .vaw_accordion_video {
                display: none;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            }

            .vaw_padd-accordion_video .vaw_accordion_video:first-child {
                display: block;
            }

            .vaw_padd-accordion_video .vaw_accordion_video img {
                width: 100%;
                height: auto;
                cursor: pointer;
                transition: transform 0.3s ease;
            }

            .vaw_padd-accordion_video .vaw_accordion_video img:hover {
                transform: scale(1.02);
            }

            .vaw_padd-accordion_video .vaw_accordion_video.vaw_active {
                display: block;
            }

            /* Responsive Styles */
            @media (max-width: 991px) {
                .vaw_padd-accordion,
                .vaw_padd-accordion_video {
                    padding: 30px 15px;
                }

                .vaw_padd-accordion_video {
                    position: relative;
                    top: 0;
                }

                .vaw_main_title {
                    font-size: 28px;
                }
            }

            @media (max-width: 576px) {
                .vaw_accordion_wrap {
                    padding: 40px 0;
                }

                .vaw_main_title {
                    font-size: 24px;
                    margin-bottom: 30px;
                }

                .vaw_ac_icon_border {
                    width: 40px;
                    height: 40px;
                }

                .vaw_ac_icon {
                    width: 20px;
                    height: 20px;
                }

                .vaw_ac_header {
                    font-size: 16px;
                    margin-left: 55px;
                }

                .vaw_accontent,
                .vaw_accordion_set.active .vaw_accontent {
                    padding-left: 55px;
                }
            }
        </style>

        <section class="vaw_accordion_wrap">
            <div class="custom-container radius-8">


                <div class="row g-0 align-items-center vaw_vertical_scroller">
                    <div class="col-md-6 col-12 vaw_padd-accordion">


                        <div class="vaw_main_title_box">
                            <h3 class="vaw_main_title vaw-title">
                                Solving everyday challenges in smarter cities
                            </h3>
                        </div>


                        <div class="vaw_accordion_sets">
                            <div class="vaw_accordion_set active">
                                <div class="vaw_ac_icon_wrap">
                                    <div class="vaw_ac_icon_border">
                                        <span><img class="vaw_ac_icon" alt="Enhanced security icon" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon1.svg"></span>
                                    </div>
                                </div>
                                <button class="vaw_select_div" aria-label="expand accordion section for Enhanced security & safety" aria-expanded="true">
                                    <h2 class="vaw_ac_header">
                                        Enhanced security & safety
                                    </h2>
                                    <span class="vaw_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vaw_accontent">
                                    <p class="vaw-description">
                                        Comprehensive real-time city monitoring leads to a significant 15% reduction in crime rates within monitored areas, bolstering public safety.
                                    </p>
                                    <div class="vaw_accordion_video">
                                        <img data-bs-toggle="modal" data-bs-target="#vawBackdrop" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp" alt="Enhanced security video" width="100%" height="100%">
                                    </div>
                                </div>
                                <div class="vaw_progress_bar"></div>
                            </div>

                            <div class="vaw_accordion_set">
                                <div class="vaw_ac_icon_wrap">
                                    <div class="vaw_ac_icon_border">
                                        <span><img class="vaw_ac_icon" alt="Traffic flow icon" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon2.svg"></span>
                                    </div>
                                </div>
                                <button class="vaw_select_div" aria-label="expand accordion section for Optimized traffic flow" aria-expanded="false">
                                    <h2 class="vaw_ac_header">
                                        Optimized traffic flow
                                    </h2>
                                    <span class="vaw_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vaw_accontent">
                                    <p class="vaw-description">
                                        Comprehensive real-time city monitoring leads to a significant 15% reduction in crime rates within monitored areas, bolstering public safety.
                                    </p>
                                    <div class="vaw_accordion_video">
                                        <img data-bs-toggle="modal" data-bs-target="#vawBackdroptwo" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp" alt="Traffic flow video" width="100%" height="100%">
                                    </div>
                                </div>
                                <div class="vaw_progress_bar"></div>
                            </div>

                            <div class="vaw_accordion_set">
                                <div class="vaw_ac_icon_wrap">
                                    <div class="vaw_ac_icon_border">
                                        <span><img class="vaw_ac_icon" alt="Public safety icon" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon3.svg"></span>
                                    </div>
                                </div>
                                <button class="vaw_select_div" aria-label="expand accordion section for Proactive public safety" aria-expanded="false">
                                    <h2 class="vaw_ac_header">
                                        Proactive public safety
                                    </h2>
                                    <span class="vaw_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vaw_accontent">
                                    <p class="vaw-description">
                                        AI-powered analytics enable early threat detection and rapid response, making cities safer for all residents.
                                    </p>
                                    <div class="vaw_accordion_video">
                                        <img data-bs-toggle="modal" data-bs-target="#vawBackdropthree" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp" alt="Public safety video" width="100%" height="100%">
                                    </div>
                                </div>
                                <div class="vaw_progress_bar"></div>
                            </div>

                            <div class="vaw_accordion_set">
                                <div class="vaw_ac_icon_wrap">
                                    <div class="vaw_ac_icon_border">
                                        <span><img class="vaw_ac_icon" alt="Industrial zones icon" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon3.svg"></span>
                                    </div>
                                </div>
                                <button class="vaw_select_div" aria-label="expand accordion section for Secure industrial zones" aria-expanded="false">
                                    <h2 class="vaw_ac_header">
                                        Secure industrial zones
                                    </h2>
                                    <span class="vaw_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vaw_accontent">
                                    <p class="vaw-description">
                                        Advanced perimeter monitoring and access control keep industrial areas protected 24/7.
                                    </p>
                                    <div class="vaw_accordion_video">
                                        <img data-bs-toggle="modal" data-bs-target="#vawBackdropfour" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp" alt="Industrial zones video" width="100%" height="100%">
                                    </div>
                                </div>
                                <div class="vaw_progress_bar"></div>
                            </div>

                            <div class="vaw_accordion_set">
                                <div class="vaw_ac_icon_wrap">
                                    <div class="vaw_ac_icon_border">
                                        <span><img class="vaw_ac_icon" alt="Emergency response icon" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon3.svg"></span>
                                    </div>
                                </div>
                                <button class="vaw_select_div" aria-label="expand accordion section for Accelerated emergency response" aria-expanded="false">
                                    <h2 class="vaw_ac_header">
                                        Accelerated emergency response
                                    </h2>
                                    <span class="vaw_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vaw_accontent">
                                    <p class="vaw-description">
                                        Instant alerts and automated notifications reduce emergency response times significantly.
                                    </p>
                                    <div class="vaw_accordion_video">
                                        <img data-bs-toggle="modal" data-bs-target="#vawBackdropfive" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp" alt="Emergency response video" width="100%" height="100%">
                                    </div>
                                </div>
                                <div class="vaw_progress_bar"></div>
                            </div>

                            <div class="vaw_accordion_set">
                                <div class="vaw_ac_icon_wrap">
                                    <div class="vaw_ac_icon_border">
                                        <span><img class="vaw_ac_icon" alt="City operations icon" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/icon3.svg"></span>
                                    </div>
                                </div>
                                <button class="vaw_select_div" aria-label="expand accordion section for Unified city operations" aria-expanded="false">
                                    <h2 class="vaw_ac_header">
                                        Unified city operations
                                    </h2>
                                    <span class="vaw_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vaw_accontent">
                                    <p class="vaw-description">
                                        Centralized command centers integrate all city systems for seamless management and coordination.
                                    </p>
                                    <div class="vaw_accordion_video">
                                        <img data-bs-toggle="modal" data-bs-target="#vawBackdropsix" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp" alt="City operations video" width="100%" height="100%">
                                    </div>
                                </div>
                                <div class="vaw_progress_bar"></div>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6 col-12 vaw_padd-accordion_video">
                        <div class="vaw_accordion_video vaw_active">
                            <img data-bs-toggle="modal" data-bs-target="#vawBackdrop" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp" alt="Smart city surveillance" width="100%" height="100%">
                        </div>
                        <div class="vaw_accordion_video">
                            <img data-bs-toggle="modal" data-bs-target="#vawBackdroptwo" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp" alt="Traffic monitoring" width="100%" height="100%">
                        </div>
                        <div class="vaw_accordion_video">
                            <img data-bs-toggle="modal" data-bs-target="#vawBackdropthree" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp" alt="Public safety monitoring" width="100%" height="100%">
                        </div>
                        <div class="vaw_accordion_video">
                            <img data-bs-toggle="modal" data-bs-target="#vawBackdropfour" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp" alt="Industrial security" width="100%" height="100%">
                        </div>
                        <div class="vaw_accordion_video">
                            <img data-bs-toggle="modal" data-bs-target="#vawBackdropfive" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp" alt="Emergency response" width="100%" height="100%">
                        </div>
                        <div class="vaw_accordion_video">
                            <img data-bs-toggle="modal" data-bs-target="#vawBackdropsix" src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp" alt="City operations" width="100%" height="100%">
                        </div>
                    </div>

                    <!-- Modal 1 -->
                    <div class="modal fade" id="vawBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vawBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="vawBackdropLabel">Enhanced security & safety</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <iframe width="100%" height="450"
                                        data-src="https://www.youtube.com/embed/9xwazD5SyVg"
                                        frameborder="0"
                                        allow="autoplay; encrypted-media"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal 2 -->
                    <div class="modal fade" id="vawBackdroptwo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vawBackdropLabeltwo" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="vawBackdropLabeltwo">Optimized traffic flow</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <iframe width="100%" height="450"
                                        data-src="https://www.youtube.com/embed/9xwazD5SyVg"
                                        frameborder="0"
                                        allow="autoplay; encrypted-media"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal 3 -->
                    <div class="modal fade" id="vawBackdropthree" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vawBackdropLabelthree" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="vawBackdropLabelthree">Proactive public safety</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <iframe width="100%" height="450"
                                        data-src="https://www.youtube.com/embed/9xwazD5SyVg"
                                        frameborder="0"
                                        allow="autoplay; encrypted-media"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal 4 -->
                    <div class="modal fade" id="vawBackdropfour" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vawBackdropLabelfour" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="vawBackdropLabelfour">Secure industrial zones</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <iframe width="100%" height="450"
                                        data-src="https://www.youtube.com/embed/9xwazD5SyVg"
                                        frameborder="0"
                                        allow="autoplay; encrypted-media"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal 5 -->
                    <div class="modal fade" id="vawBackdropfive" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vawBackdropLabelfive" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="vawBackdropLabelfive">Accelerated emergency response</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <iframe width="100%" height="450"
                                        data-src="https://www.youtube.com/embed/9xwazD5SyVg"
                                        frameborder="0"
                                        allow="autoplay; encrypted-media"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal 6 -->
                    <div class="modal fade" id="vawBackdropsix" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vawBackdropLabelsix" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="vawBackdropLabelsix">Unified city operations</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <iframe width="100%" height="450"
                                        data-src="https://www.youtube.com/embed/9xwazD5SyVg"
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
        </section>

        <!-- Video Accordion White - Inline JavaScript -->
        <script>
        (function() {
            function initVAWAccordion() {
                if (typeof jQuery === 'undefined') {
                    setTimeout(initVAWAccordion, 100);
                    return;
                }
                var $ = jQuery;
            // Check if VAW accordion exists on the page
            if ($('.vaw_accordion_wrap').length === 0) {
                return;
            }

            // Helper function to check if any modal is currently open
            function isVAWModalOpen() {
                return $('.modal.show, .modal.in').length > 0 || $('body').hasClass('modal-open');
            }

            // Initialize each VAW accordion wrapper independently
            $('.vaw_accordion_wrap').each(function() {
                var $accordionWrap = $(this);
                var $accordionSets = $accordionWrap.find('.vaw_accordion_set');
                var $videoPanel = $accordionWrap.find('.vaw_padd-accordion_video');
                var $accordionVideos = $videoPanel.find('.vaw_accordion_video');

                // Skip if no accordion sets found
                if ($accordionSets.length === 0) {
                    return;
                }

                // Open first section by default
                var $first = $accordionSets.first();
                $first.addClass('active');
                $first.find('.vaw_select_div').attr("aria-expanded", "true");

                // Initialize videos - show first video, hide others
                $accordionVideos.each(function(index) {
                    if (index === 0) {
                        $(this).addClass('vaw_active').show();
                    } else {
                        $(this).removeClass('vaw_active').hide();
                    }
                });

                // Setup variables for this accordion instance
                var autoIndex = 0;
                var total = $accordionSets.length;
                var autoInterval = 9000; // 9 seconds
                var timer = null;
                var isPaused = false;
                var resumeTimeout = null;
                var progressInterval = null;

                // Function to switch video by index
                function switchVideo(index) {
                    $accordionVideos.each(function(videoIndex) {
                        if (videoIndex === index) {
                            $(this).addClass('vaw_active').show();
                        } else {
                            $(this).removeClass('vaw_active').hide();
                        }
                    });
                }

                // Function to start progress fill animation
                function startProgressFill() {
                    // Clear any existing progress interval
                    if (progressInterval) {
                        clearInterval(progressInterval);
                        progressInterval = null;
                    }

                    // Reset progress on all accordion items
                    $accordionSets.each(function() {
                        this.style.setProperty('--vaw-progress', '0%');
                    });

                    // Start progress for active accordion item
                    var activeAccordion = $accordionSets.filter('.active')[0];
                    if (activeAccordion) {
                        var timeLeft = autoInterval / 1000; // Convert to seconds
                        var updateInterval = 50; // Update every 50ms for smooth animation

                        progressInterval = setInterval(function() {
                            if (isPaused || isVAWModalOpen()) {
                                return;
                            }

                            timeLeft -= (updateInterval / 1000);
                            var progress = ((autoInterval / 1000 - timeLeft) / (autoInterval / 1000)) * 100;

                            // Update progress CSS variable
                            activeAccordion.style.setProperty('--vaw-progress', progress + '%');

                            if (timeLeft <= 0) {
                                clearInterval(progressInterval);
                                progressInterval = null;
                            }
                        }, updateInterval);
                    }
                }

                // Function to open accordion by index
                function openAccordion(index) {
                    var $target = $accordionSets.eq(index);
                    $accordionSets.removeClass("active");
                    $accordionSets.find('.vaw_select_div').attr("aria-expanded", "false");

                    $target.addClass("active");
                    $target.find(".vaw_select_div").attr("aria-expanded", "true");

                    // Switch to corresponding video
                    switchVideo(index);

                    // Start progress fill animation
                    startProgressFill();
                }

                // Auto slide function
                function startAutoSlide() {
                    if (isPaused || isVAWModalOpen()) {
                        return;
                    }
                    if (timer) {
                        clearInterval(timer);
                    }
                    timer = setInterval(function() {
                        if (!isPaused && !isVAWModalOpen()) {
                            autoIndex = (autoIndex + 1) % total;
                            openAccordion(autoIndex);
                        }
                    }, autoInterval);
                }

                // Pause auto slide function
                function pauseAutoSlide() {
                    isPaused = true;
                    if (timer) {
                        clearInterval(timer);
                        timer = null;
                    }
                    // Pause progress animation
                    if (progressInterval) {
                        clearInterval(progressInterval);
                        progressInterval = null;
                    }
                    // Cancel any pending resume timeout
                    if (resumeTimeout) {
                        clearTimeout(resumeTimeout);
                        resumeTimeout = null;
                    }
                }

                // Resume auto slide function
                function resumeAutoSlide() {
                    // Don't resume if modal is open
                    if (isVAWModalOpen()) {
                        return;
                    }
                    isPaused = false;
                    if (!timer) {
                        startAutoSlide();
                    }
                    // Restart progress fill animation
                    startProgressFill();
                }

                // Initialize progress fill for first accordion
                setTimeout(function() {
                    startProgressFill();
                }, 200);

                // Start auto slide initially
                startAutoSlide();

                // On click — manual control + reset timer
                $accordionSets.find('.vaw_select_div').click(function() {
                    pauseAutoSlide();

                    var $parent = $(this).parents('.vaw_accordion_set');
                    autoIndex = $accordionSets.index($parent);

                    if ($parent.hasClass("active")) {
                        // Already active, do nothing or toggle off
                    } else {
                        openAccordion(autoIndex);
                    }

                    // Cancel any existing resume timeout
                    if (resumeTimeout) {
                        clearTimeout(resumeTimeout);
                    }

                    // Restart auto slide after short delay
                    resumeTimeout = setTimeout(function() {
                        resumeTimeout = null;
                        if (!isVAWModalOpen()) {
                            resumeAutoSlide();
                        }
                    }, 1000);
                });

                // Pause when VAW modal opens
                $(document).on('show.bs.modal', '[id^="vawBackdrop"]', function() {
                    pauseAutoSlide();

                    // Load video with autoplay when modal opens
                    var modal = $(this);
                    var iframe = modal.find('iframe');
                    if (iframe.length) {
                        var baseSrc = iframe.attr('data-src') || iframe.data('original-src');
                        if (baseSrc) {
                            var separator = baseSrc.indexOf('?') !== -1 ? '&' : '?';
                            var videoSrc = baseSrc + separator + 'autoplay=1';
                            iframe.attr('src', videoSrc);
                        }
                    }
                });

                // Resume when VAW modal closes
                $(document).on('hidden.bs.modal', '[id^="vawBackdrop"]', function() {
                    var modal = $(this);
                    var iframe = modal.find('iframe');
                    if (iframe.length) {
                        iframe.attr('src', '');
                    }

                    setTimeout(function() {
                        if (!isVAWModalOpen()) {
                            resumeAutoSlide();
                        }
                    }, 100);
                });
            });
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initVAWAccordion);
        } else {
            initVAWAccordion();
        }
        })();
        </script>
<?php
    }
}
?>

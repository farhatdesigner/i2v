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

class Video_accordioncaption extends Widget_Base
{
    public function get_name()
    {
        return 'video_accordioncaption';
    }

    public function get_title()
    {
        return 'Video Accordion Caption';
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
                    '{{WRAPPER}} .vac-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .vac-title',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vac-description' => 'color: {{VALUE}};',
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

        <style>
            .vac_accordion_wrap {
                border-radius: 12px;
            }

            .vac_vertical_scroller {
                align-items: flex-start;
                gap: 80px;
                flex-wrap: nowrap;
            }


            .vac_padd-accordion_video {
                position: sticky;
                top: 100px;
            }

            .vac_main_title_box {
                /* margin-bottom: 48px; */
            }

            .vac_main_title {
                font-size: 40px;
                color: #06283D;
                line-height: 1.3;
                margin: 0;
            }

            .vac_accordion_sets {
                display: flex;
                flex-direction: column;
            }

            .vac_accordion_set {
                position: relative;
                border-bottom: 1px solid #E6EBF2;
                padding: 30px 20px;
                background: transparent;
                transition: background 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    padding 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    border-color 0.3s ease;
                will-change: background, padding;
            }

            .vac_accordion_set.active {
                position: relative;
                border-bottom: 1px solid #e5e7eb;
                padding: 12px;
                background: #F2F5FA;
            }


            .vac_select_div {
                display: flex;
                align-items: center;
                width: 100%;
                background: transparent;
                border: none;
                cursor: pointer;
                text-align: left;
                gap: 15px;
                padding-left: 20px;
            }

            .vac_ac_icon_wrap {
                position: absolute;
                left: 20px;
                top: 10px;
            }

            .vac_ac_icon_border {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                background: #F2F5FA;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .vac_accordion_set.active .vac_ac_icon_border {
                background: #FFF;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            }

            .vac_ac_icon {
                width: 24px;
                height: 24px;
                object-fit: contain;
                transition: filter 0.3s ease;
            }

            .vac_accordion_set.active .vac_ac_icon {
                filter: brightness(0) invert(1);
            }

            .vac_ac_header {
                flex: 1;
                font-size: 18px;
                font-weight: 500;
                color: #06283D;
                margin: 0 0 0 63px;
                line-height: 1.4;
            }

            .vac_chevron {
                width: 24px;
                height: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                margin-left: auto;
                will-change: transform;
            }

            .vac_chevron svg {
                width: 20px;
                height: 20px;
                stroke: #6b7280;
                transition: stroke 0.3s ease;
            }

            .vac_accordion_set.active .vac_chevron {
                transform: rotate(180deg);
            }

            .vac_accordion_set.active .vac_chevron svg {
                stroke: #0066cc;
            }

            .vac_accontent {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                padding: 0 0 0 63px;
                will-change: max-height;
                transform: translateZ(0);
            }

            .vac_accontent>* {
                opacity: 0;
                transform: translateY(-10px);
                transition: opacity 0.3s ease 0.1s, transform 0.3s ease 0.1s;
            }

            .vac_accordion_set.active .vac_accontent {
                max-height: 200px;
                padding: 0 0 0px 63px;
            }

            .vac_accordion_set.active .vac_accontent>* {
                opacity: 1;
                transform: translateY(0);
            }

            .vac_accontent p {
                font-size: 16px;
                color: #5C5C5C;
                line-height: 1.6;
                margin: 8px 40px 0px 20px;
                min-height: 50px;
            }

            .vac_accontent .vac_accordion_video {
                margin-top: 15px;
                border-radius: 8px;
                overflow: hidden;
                opacity: 0;
                max-height: 0;
                display: none;
                transition: opacity 0.3s ease, max-height 0.3s ease;
            }

            .vac_accordion_set.active .vac_accontent .vac_accordion_video {
                opacity: 0;
                max-height: 0;
                display: none;
            }

            .vac_accontent .vac_accordion_video img {
                width: 100%;
                height: auto;
                cursor: pointer;
                transition: transform 0.3s ease;
            }

            .vac_accontent .vac_accordion_video img:hover {
                transform: scale(1.02);
            }

            .vac_progress_bar {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 4px;
                overflow: hidden;
            }

            .vac_progress_bar::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: var(--vac-progress, 0%);
                background: linear-gradient(90deg, #74C2ED, #74C2ED);
                transition: width 0.05s linear;
            }

            .vac_accordion_set:not(.active) .vac_progress_bar::after {
                width: 0%;
            }

            .vac_padd-accordion_video .vac_accordion_video {
                display: none;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            }

            .vac_padd-accordion_video .vac_accordion_video:first-child {
                display: block;
            }

            .vac_padd-accordion_video .vac_accordion_video img {
                width: 100%;
                height: auto;
                cursor: pointer;
                transition: transform 0.3s ease;
            }

            .vac_padd-accordion_video .vac_accordion_video img:hover {
                transform: scale(1.02);
            }

            .vac_padd-accordion_video .vac_accordion_video.vac_active {
                display: block;
            }

            @media (max-width: 991px) {

                .vac_padd-accordion,
                .vac_padd-accordion_video {
                    padding: 30px 15px;
                }

                .vac_padd-accordion_video {
                    position: relative;
                    top: 0;
                }

                .vac_main_title {
                    font-size: 28px;
                }
            }

            @media (max-width: 576px) {
                .vac_accordion_wrap {
                    padding: 40px 0;
                }

                .vac_padd-accordion_video {
                    display: none;
                }

                .vac_main_title {
                    font-size: 24px;
                    margin-bottom: 30px;
                }

                .vac_ac_icon_border {
                    width: 40px;
                    height: 40px;
                }

                .vac_ac_icon {
                    width: 20px;
                    height: 20px;
                }

                .vac_ac_header {
                    font-size: 16px;
                    margin-left: 55px;
                }

                .vac_accontent,
                .vac_accordion_set.active .vac_accontent {
                    padding-left: 0;
                    padding-right: 0;
                    overflow: visible;
                }

                .vac_accordion_set.active .vac_accontent {
                    max-height: 700px;
                }

                .vac_accontent p {
                    margin: 8px 15px 0px 75px;
                }

                .vac_accontent .vac_accordion_video {
                    margin-top: 10px;
                    margin-left: 0;
                    margin-right: 0;
                    width: 100%;
                    overflow: visible;
                    display: block;
                }

                .vac_accordion_set.active .vac_accontent .vac_accordion_video {
                    max-height: 450px;
                    opacity: 1;
                    display: block;
                }

                .vac_accontent .vac_accordion_video img {
                    width: 100%;
                    height: auto;
                    max-height: 200px;
                    object-fit: cover;
                    border-radius: 8px;
                    display: block;
                }

                .vac_accontent .vac_accordion_video .card {
                    border-radius: 12px;
                    overflow: hidden;
                    background: #fff;
                }

                .vac_accontent .vac_accordion_video .card-image {
                    height: 150px;
                    overflow: hidden;
                }

                .vac_accontent .vac_accordion_video .card-image img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    max-height: none;
                }

                .vac_accontent .vac_accordion_video .card-body {
                    padding: 15px;
                }

                .vac_accontent .vac_accordion_video .card-title {
                    font-size: 14px;
                    font-weight: 600;
                    color: #06283D;
                    margin-bottom: 8px;
                }

                .vac_accontent .vac_accordion_video .card-text {
                    font-size: 12px;
                    line-height: 1.5;
                    margin-bottom: 10px;
                }

                .vac_accontent .vac_accordion_video .badge-custom {
                    font-size: 10px;
                    padding: 4px 8px;
                    background: #F2F5FA;
                    color: #5F6F94;
                    border-radius: 4px;
                    display: inline-block;
                }
            }
        </style>

        <section class="vac_accordion_wrap">
            <div class="custom-container radius-8">

                <div class="col-md-6 col-12">
                    <div class="vac_main_title_box">
                        <h3 class="vac_main_title vac-title">
                            Discover how i2V transforms retail challenges into competitive advantages
                        </h3>
                        <p>Take a guided journey through real retail problems and see how intelligent surveillance delivers
                            measurable solutions. Each challenge includes real-world outcomes and proven results.</p>
                    </div>
                </div>

                <div class="row g-0 align-items-center vac_vertical_scroller">
                    <div class="col-md-6 col-12 vac_padd-accordion">
                    <h3 style="margin-top: 40px;">Retail challenges:</h3>
                        <div class="vac_accordion_sets">
                            <div class="vac_accordion_set active">
                                <div class="vac_ac_icon_wrap">
                                    <div class="vac_ac_icon_border">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                                fill="none">
                                                <path
                                                    d="M13.6742 11.2697H16.0314V14.184C17.1223 14.215 18.1982 14.4456 19.206 14.8643V14.1798C19.206 13.9693 19.2897 13.7674 19.4385 13.6186C19.5873 13.4698 19.7892 13.3861 19.9997 13.3861C20.2102 13.3861 20.4121 13.4698 20.5609 13.6186C20.7097 13.7674 20.7933 13.9693 20.7933 14.1798V15.7192C22.1787 16.6559 23.2776 17.958 23.968 19.4812V11.2697H26.3489C26.5292 11.2697 26.7041 11.2083 26.8448 11.0957C26.9856 10.9831 27.0838 10.826 27.1234 10.6501C27.1515 10.5156 27.1452 10.3761 27.105 10.2447C27.0648 10.1133 26.9921 9.99411 26.8935 9.8983L20.5609 3.56569C20.412 3.41686 20.2102 3.33325 19.9997 3.33325C19.7892 3.33325 19.5874 3.41686 19.4385 3.56569L13.0893 9.9149C12.9618 10.0424 12.8814 10.2095 12.8616 10.3888C12.8417 10.568 12.8834 10.7487 12.98 10.901C13.0553 11.0159 13.1584 11.11 13.2798 11.1744C13.4011 11.2389 13.5368 11.2717 13.6742 11.2697ZM19.206 8.88878C19.206 8.67829 19.2897 8.47642 19.4385 8.32758C19.5873 8.17874 19.7892 8.09513 19.9997 8.09513C20.2102 8.09513 20.4121 8.17874 20.5609 8.32758C20.7097 8.47642 20.7933 8.67829 20.7933 8.88878V10.4761C20.7933 10.6866 20.7097 10.8884 20.5609 11.0373C20.4121 11.1861 20.2102 11.2697 19.9997 11.2697C19.7892 11.2697 19.5873 11.1861 19.4385 11.0373C19.2897 10.8884 19.206 10.6866 19.206 10.4761V8.88878Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M16.0314 27.3894C16.7492 25.8063 17.9077 24.4634 19.3684 23.5211C19.2571 23.4041 19.1843 23.2558 19.1599 23.0961C19.1108 22.7757 19.0223 22.4626 18.8965 22.1639C18.8148 21.9699 18.8135 21.7514 18.8928 21.5565C18.9722 21.3615 19.1258 21.2061 19.3198 21.1243C19.5137 21.0426 19.7323 21.0413 19.9272 21.1207C20.1222 21.2 20.2776 21.3536 20.3593 21.5476C20.5288 21.9507 20.65 22.3726 20.7202 22.8042C21.7268 22.3753 22.8037 22.135 23.8971 22.0952C23.6352 20.1244 22.6664 18.3158 21.1709 17.0058C19.6754 15.6958 17.755 14.9736 15.7669 14.9734H11.2695V12.6435C11.2715 12.5061 11.2386 12.3704 11.174 12.2491C11.1094 12.1278 11.0152 12.0249 10.9001 11.9498C10.7478 11.8535 10.5673 11.812 10.3882 11.832C10.2091 11.8519 10.0421 11.9322 9.91469 12.0595L3.56548 18.4088C3.49178 18.4825 3.43331 18.57 3.39342 18.6662C3.35354 18.7625 3.33301 18.8657 3.33301 18.97C3.33301 19.0742 3.35354 19.1774 3.39342 19.2737C3.43331 19.37 3.49178 19.4575 3.56548 19.5312L9.91469 25.8804C10.0423 26.0079 10.2094 26.0882 10.3887 26.108C10.5679 26.1279 10.7486 26.0861 10.901 25.9897C11.0159 25.9144 11.1099 25.8114 11.1743 25.6901C11.2387 25.5689 11.2715 25.4333 11.2695 25.296V22.934L15.7669 22.91C15.837 22.91 15.9043 22.9378 15.9539 22.9874C16.0036 23.0371 16.0314 23.1043 16.0314 23.1745V27.3894ZM9.15312 19.7353H8.35947C8.14898 19.7353 7.94711 19.6517 7.79827 19.5029C7.64943 19.3541 7.56581 19.1522 7.56581 18.9417C7.56581 18.7312 7.64943 18.5293 7.79827 18.3805C7.94711 18.2317 8.14898 18.148 8.35947 18.148H9.15312C9.36361 18.148 9.56547 18.2317 9.71431 18.3805C9.86315 18.5293 9.94677 18.7312 9.94677 18.9417C9.94677 19.1522 9.86315 19.3541 9.71431 19.5029C9.56547 19.6517 9.36361 19.7353 9.15312 19.7353ZM13.4319 19.7353H12.2651C12.0546 19.7353 11.8527 19.6517 11.7039 19.5029C11.5551 19.3541 11.4714 19.1522 11.4714 18.9417C11.4714 18.7312 11.5551 18.5293 11.7039 18.3805C11.8527 18.2317 12.0546 18.148 12.2651 18.148H13.4322C13.6427 18.148 13.8446 18.2317 13.9934 18.3805C14.1423 18.5293 14.2259 18.7312 14.2259 18.9417C14.2259 19.1522 14.1423 19.3541 13.9934 19.5029C13.8446 19.6517 13.6424 19.7353 13.4319 19.7353ZM15.7629 18.904C15.7911 18.8036 15.8387 18.7098 15.9031 18.6278C15.9676 18.5458 16.0475 18.4774 16.1384 18.4263C16.2293 18.3752 16.3294 18.3426 16.4329 18.3302C16.5364 18.3179 16.6414 18.326 16.7418 18.3542C17.1795 18.4771 17.6004 18.6535 17.995 18.8795C18.086 18.931 18.1658 18.9999 18.2301 19.0824C18.2943 19.1649 18.3416 19.2593 18.3693 19.3601C18.3969 19.4609 18.4044 19.5662 18.3913 19.6699C18.3781 19.7736 18.3446 19.8737 18.2927 19.9644C18.2407 20.0551 18.1714 20.1347 18.0886 20.1985C18.0058 20.2624 17.9113 20.3092 17.8103 20.3364C17.7094 20.3636 17.6041 20.3706 17.5004 20.3569C17.3968 20.3433 17.2968 20.3093 17.2064 20.257C16.9251 20.0959 16.6251 19.9701 16.3131 19.8825C16.2127 19.8544 16.1189 19.8068 16.0369 19.7424C15.9549 19.678 15.8864 19.5981 15.8353 19.5072C15.7842 19.4164 15.7515 19.3163 15.7391 19.2128C15.7267 19.1093 15.7348 19.0044 15.7629 18.904Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M36.4339 26.317L30.1013 19.9844C30.0055 19.8858 29.8863 19.8131 29.7549 19.7729C29.6235 19.7327 29.484 19.7264 29.3495 19.7545C29.1736 19.7941 29.0165 19.8923 28.9039 20.0331C28.7913 20.1738 28.7299 20.3487 28.7299 20.529V22.8816H24.2325C22.0574 22.8816 19.9715 23.7457 18.4335 25.2837C16.8955 26.8217 16.0314 28.9077 16.0314 31.0827V36.6666H23.968V31.0827C23.9678 31.0132 23.995 30.9465 24.0438 30.897C24.0925 30.8474 24.1588 30.8191 24.2283 30.8182L28.7299 30.8422V33.2043C28.7279 33.3416 28.7607 33.4772 28.8251 33.5984C28.8895 33.7196 28.9835 33.8226 29.0983 33.8979C29.2507 33.9943 29.4314 34.0361 29.6107 34.0162C29.7899 33.9964 29.9571 33.9161 30.0847 33.7886L36.4339 27.4394C36.5827 27.2906 36.6663 27.0887 36.6663 26.8782C36.6663 26.6677 36.5827 26.4659 36.4339 26.317ZM20.7933 35.3438C20.7933 35.5543 20.7097 35.7562 20.5609 35.905C20.4121 36.0539 20.2102 36.1375 19.9997 36.1375C19.7892 36.1375 19.5873 36.0539 19.4385 35.905C19.2897 35.7562 19.206 35.5543 19.206 35.3438V34.5502C19.206 34.3397 19.2897 34.1378 19.4385 33.989C19.5873 33.8401 19.7892 33.7565 19.9997 33.7565C20.2102 33.7565 20.4121 33.8401 20.5609 33.989C20.7097 34.1378 20.7933 34.3397 20.7933 34.5502V35.3438ZM20.99 30.4022C20.8858 30.7206 20.8223 31.0511 20.8013 31.3856C20.7887 31.5869 20.6999 31.7759 20.5529 31.9141C20.4059 32.0523 20.2118 32.1293 20.0101 32.1295C19.9932 32.1295 19.9763 32.129 19.9593 32.128C19.7492 32.1147 19.553 32.0185 19.4139 31.8606C19.2747 31.7027 19.204 31.496 19.2172 31.2859C19.2467 30.8172 19.3356 30.3541 19.4818 29.9078C19.5505 29.7119 19.6933 29.5506 19.8796 29.4588C20.0658 29.3669 20.2807 29.3517 20.478 29.4164C20.6754 29.4811 20.8395 29.6206 20.9351 29.805C21.0308 29.9893 21.0507 30.2035 20.99 30.4022ZM23.4918 27.8792C23.1744 27.9864 22.8719 28.1336 22.5916 28.3171C22.5044 28.3754 22.4066 28.4159 22.3037 28.4362C22.2008 28.4564 22.0949 28.4561 21.9921 28.4352C21.8893 28.4143 21.7917 28.3732 21.7049 28.3143C21.6181 28.2554 21.5438 28.18 21.4863 28.0922C21.4289 28.0045 21.3894 27.9062 21.3701 27.8031C21.3509 27.7 21.3523 27.5941 21.3742 27.4915C21.3961 27.3889 21.4382 27.2917 21.4979 27.2055C21.5576 27.1193 21.6339 27.0458 21.7222 26.9892C22.1151 26.7318 22.5392 26.5255 22.9842 26.3752C23.083 26.3417 23.1875 26.3279 23.2916 26.3348C23.3957 26.3417 23.4975 26.369 23.591 26.4152C23.6846 26.4615 23.7681 26.5257 23.8368 26.6042C23.9055 26.6828 23.9581 26.7741 23.9914 26.873C24.0248 26.9718 24.0383 27.0763 24.0313 27.1804C24.0242 27.2845 23.9967 27.3862 23.9503 27.4797C23.9039 27.5732 23.8395 27.6566 23.7608 27.7251C23.6821 27.7937 23.5907 27.846 23.4918 27.8792ZM27.6309 27.6719H26.4254C26.2149 27.6719 26.013 27.5882 25.8642 27.4394C25.7153 27.2906 25.6317 27.0887 25.6317 26.8782C25.6317 26.6677 25.7153 26.4659 25.8642 26.317C26.013 26.1682 26.2149 26.0846 26.4254 26.0846H27.6309C27.8413 26.0846 28.0432 26.1682 28.192 26.317C28.3409 26.4659 28.4245 26.6677 28.4245 26.8782C28.4245 27.0887 28.3409 27.2906 28.192 27.4394C28.0432 27.5882 27.8413 27.6719 27.6309 27.6719ZM31.6399 27.6719H30.8463C30.6358 27.6719 30.4339 27.5882 30.2851 27.4394C30.1362 27.2906 30.0526 27.0887 30.0526 26.8782C30.0526 26.6677 30.1362 26.4659 30.2851 26.317C30.4339 26.1682 30.6358 26.0846 30.8463 26.0846H31.6399C31.8504 26.0846 32.0523 26.1682 32.2011 26.317C32.35 26.4659 32.4336 26.6677 32.4336 26.8782C32.4336 27.0887 32.35 27.2906 32.2011 27.4394C32.0523 27.5882 31.8504 27.6719 31.6399 27.6719Z"
                                                    fill="#5F6F94" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <button class="vac_select_div"
                                    aria-label="expand accordion section for Enhanced security & safety" aria-expanded="true">
                                    <h2 class="vac_ac_header">
                                        Enhanced security & safety
                                    </h2>
                                    <span class="vac_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vac_accontent">
                                    <p class="vac-description">
                                        Comprehensive real-time city monitoring leads to a significant 15% reduction in crime
                                        rates within monitored areas, bolstering public safety.
                                    </p>
                                    <div class="vac_accordion_video">
                                        <h3>i2V solution and there results:</h3>
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-image">
                                                <img decoding="async"
                                                    src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp"
                                                    class="card-img-top h-100" alt="Enhanced security & safety">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Enhanced security & safety</h5>
                                                <p class="card-text text-muted">
                                                    Comprehensive real-time city monitoring leads to a significant 15% reduction
                                                    in crime rates within monitored areas.
                                                </p>
                                                <div class="d-flex flex-wrap gap-2 mt-4">
                                                    <span class="badge-custom">Real-time monitoring</span>
                                                    <span class="badge-custom">Crime prevention</span>
                                                    <span class="badge-custom">Public safety</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vac_progress_bar"></div>
                            </div>

                            <div class="vac_accordion_set">
                                <div class="vac_ac_icon_wrap">
                                    <div class="vac_ac_icon_border">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                                fill="none">
                                                <path
                                                    d="M17.3219 32.2444C17.2552 32.2777 17.1886 32.311 17.1108 32.3444C16.9663 32.411 16.8219 32.4333 16.6663 32.4333C16.5108 32.4333 16.3663 32.3999 16.2219 32.3444C13.5465 31.1752 11.2702 29.2512 9.67167 26.808C8.07313 24.3648 7.22179 21.5085 7.2219 18.5888V12.4999C7.2219 12.0666 7.47745 11.6666 7.87745 11.4888L16.2108 7.69992C16.4997 7.56659 16.833 7.56659 17.133 7.69992L25.4663 11.4888C25.8663 11.6666 26.1219 12.0666 26.1219 12.4999V14.4999C26.4886 14.4666 26.8552 14.4444 27.233 14.4444C28.1886 14.4444 29.1219 14.5777 30.0108 14.7888V9.99992C30.0108 9.56659 29.7552 9.16659 29.3552 8.98881L17.1219 3.43325C16.833 3.29992 16.4997 3.29992 16.1997 3.43325L3.98856 8.98881C3.58856 9.16659 3.33301 9.56659 3.33301 9.99992V18.5888C3.33301 26.1777 7.84412 33.011 14.833 35.9777L16.233 36.5777C16.3775 36.6333 16.5219 36.6666 16.6663 36.6666C16.8108 36.6666 16.9663 36.6333 17.0997 36.5777L18.4997 35.9777C19.0108 35.7555 19.5108 35.511 19.9997 35.2555C18.9441 34.411 18.033 33.3999 17.3219 32.2444Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M23.8886 14.9333V13.2221L16.6663 9.94436L9.44412 13.2221V18.5888C9.44412 23.3221 12.0552 27.6333 16.1775 29.8444C15.7775 28.6666 15.5552 27.411 15.5552 26.111C15.5552 20.8333 19.0775 16.3777 23.8886 14.9333Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M27.2219 16.6666C22.0108 16.6666 17.7775 20.8999 17.7775 26.111C17.7775 31.3221 22.0108 35.5555 27.2219 35.5555C32.433 35.5555 36.6663 31.3221 36.6663 26.111C36.6663 20.8999 32.433 16.6666 27.2219 16.6666ZM31.6997 24.5888L27.133 29.1999C27.0301 29.3049 26.9074 29.3884 26.772 29.4456C26.6366 29.5029 26.4911 29.5326 26.3441 29.5333C26.0552 29.5333 25.7663 29.411 25.5552 29.211L22.7441 26.3999C22.3108 25.9666 22.3108 25.2666 22.7441 24.8221C23.1775 24.3888 23.8775 24.3888 24.3219 24.8221L26.3441 26.8444L30.1219 23.0333C30.224 22.929 30.3459 22.8462 30.4804 22.7897C30.6149 22.7332 30.7593 22.7041 30.9052 22.7041C31.0511 22.7041 31.1956 22.7332 31.3301 22.7897C31.4646 22.8462 31.5865 22.929 31.6886 23.0333C32.1219 23.4666 32.133 24.1666 31.6886 24.5999L31.6997 24.5888Z"
                                                    fill="#5F6F94" />
                                            </svg></span>
                                    </div>
                                </div>
                                <button class="vac_select_div" aria-label="expand accordion section for Optimized traffic flow"
                                    aria-expanded="false">
                                    <h2 class="vac_ac_header">
                                        Optimized traffic flow
                                    </h2>
                                    <span class="vac_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vac_accontent">
                                    <p class="vac-description">
                                        Comprehensive real-time city monitoring leads to a significant 15% reduction in crime
                                        rates within monitored areas, bolstering public safety.
                                    </p>
                                    <div class="vac_accordion_video">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-image">
                                                <img decoding="async"
                                                    src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp"
                                                    class="card-img-top h-100" alt="Optimized traffic flow">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Optimized traffic flow</h5>
                                                <p class="card-text text-muted">
                                                    Smart traffic management reduces congestion and improves commute times
                                                    across the city.
                                                </p>
                                                <div class="d-flex flex-wrap gap-2 mt-4">
                                                    <span class="badge-custom">Traffic analysis</span>
                                                    <span class="badge-custom">Smart signals</span>
                                                    <span class="badge-custom">Flow optimization</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vac_progress_bar"></div>
                            </div>

                            <div class="vac_accordion_set">
                                <div class="vac_ac_icon_wrap">
                                    <div class="vac_ac_icon_border">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                                fill="none">
                                                <path
                                                    d="M17.3219 32.2444C17.2552 32.2777 17.1886 32.311 17.1108 32.3444C16.9663 32.411 16.8219 32.4333 16.6663 32.4333C16.5108 32.4333 16.3663 32.3999 16.2219 32.3444C13.5465 31.1752 11.2702 29.2512 9.67167 26.808C8.07313 24.3648 7.22179 21.5085 7.2219 18.5888V12.4999C7.2219 12.0666 7.47745 11.6666 7.87745 11.4888L16.2108 7.69992C16.4997 7.56659 16.833 7.56659 17.133 7.69992L25.4663 11.4888C25.8663 11.6666 26.1219 12.0666 26.1219 12.4999V14.4999C26.4886 14.4666 26.8552 14.4444 27.233 14.4444C28.1886 14.4444 29.1219 14.5777 30.0108 14.7888V9.99992C30.0108 9.56659 29.7552 9.16659 29.3552 8.98881L17.1219 3.43325C16.833 3.29992 16.4997 3.29992 16.1997 3.43325L3.98856 8.98881C3.58856 9.16659 3.33301 9.56659 3.33301 9.99992V18.5888C3.33301 26.1777 7.84412 33.011 14.833 35.9777L16.233 36.5777C16.3775 36.6333 16.5219 36.6666 16.6663 36.6666C16.8108 36.6666 16.9663 36.6333 17.0997 36.5777L18.4997 35.9777C19.0108 35.7555 19.5108 35.511 19.9997 35.2555C18.9441 34.411 18.033 33.3999 17.3219 32.2444Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M23.8886 14.9333V13.2221L16.6663 9.94436L9.44412 13.2221V18.5888C9.44412 23.3221 12.0552 27.6333 16.1775 29.8444C15.7775 28.6666 15.5552 27.411 15.5552 26.111C15.5552 20.8333 19.0775 16.3777 23.8886 14.9333Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M27.2219 16.6666C22.0108 16.6666 17.7775 20.8999 17.7775 26.111C17.7775 31.3221 22.0108 35.5555 27.2219 35.5555C32.433 35.5555 36.6663 31.3221 36.6663 26.111C36.6663 20.8999 32.433 16.6666 27.2219 16.6666ZM31.6997 24.5888L27.133 29.1999C27.0301 29.3049 26.9074 29.3884 26.772 29.4456C26.6366 29.5029 26.4911 29.5326 26.3441 29.5333C26.0552 29.5333 25.7663 29.411 25.5552 29.211L22.7441 26.3999C22.3108 25.9666 22.3108 25.2666 22.7441 24.8221C23.1775 24.3888 23.8775 24.3888 24.3219 24.8221L26.3441 26.8444L30.1219 23.0333C30.224 22.929 30.3459 22.8462 30.4804 22.7897C30.6149 22.7332 30.7593 22.7041 30.9052 22.7041C31.0511 22.7041 31.1956 22.7332 31.3301 22.7897C31.4646 22.8462 31.5865 22.929 31.6886 23.0333C32.1219 23.4666 32.133 24.1666 31.6886 24.5999L31.6997 24.5888Z"
                                                    fill="#5F6F94" />
                                            </svg></span>
                                    </div>
                                </div>
                                <button class="vac_select_div" aria-label="expand accordion section for Proactive public safety"
                                    aria-expanded="false">
                                    <h2 class="vac_ac_header">
                                        Proactive public safety
                                    </h2>
                                    <span class="vac_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vac_accontent">
                                    <p class="vac-description">
                                        AI-powered analytics enable early threat detection and rapid response, making cities
                                        safer for all residents.
                                    </p>
                                    <div class="vac_accordion_video">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-image">
                                                <img decoding="async"
                                                    src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp"
                                                    class="card-img-top h-100" alt="Proactive public safety">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Proactive public safety</h5>
                                                <p class="card-text text-muted">
                                                    AI-powered analytics enable early threat detection and rapid response for
                                                    safer cities.
                                                </p>
                                                <div class="d-flex flex-wrap gap-2 mt-4">
                                                    <span class="badge-custom">Threat detection</span>
                                                    <span class="badge-custom">Rapid response</span>
                                                    <span class="badge-custom">AI analytics</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vac_progress_bar"></div>
                            </div>

                            <div class="vac_accordion_set">
                                <div class="vac_ac_icon_wrap">
                                    <div class="vac_ac_icon_border">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                                fill="none">
                                                <path
                                                    d="M17.3219 32.2444C17.2552 32.2777 17.1886 32.311 17.1108 32.3444C16.9663 32.411 16.8219 32.4333 16.6663 32.4333C16.5108 32.4333 16.3663 32.3999 16.2219 32.3444C13.5465 31.1752 11.2702 29.2512 9.67167 26.808C8.07313 24.3648 7.22179 21.5085 7.2219 18.5888V12.4999C7.2219 12.0666 7.47745 11.6666 7.87745 11.4888L16.2108 7.69992C16.4997 7.56659 16.833 7.56659 17.133 7.69992L25.4663 11.4888C25.8663 11.6666 26.1219 12.0666 26.1219 12.4999V14.4999C26.4886 14.4666 26.8552 14.4444 27.233 14.4444C28.1886 14.4444 29.1219 14.5777 30.0108 14.7888V9.99992C30.0108 9.56659 29.7552 9.16659 29.3552 8.98881L17.1219 3.43325C16.833 3.29992 16.4997 3.29992 16.1997 3.43325L3.98856 8.98881C3.58856 9.16659 3.33301 9.56659 3.33301 9.99992V18.5888C3.33301 26.1777 7.84412 33.011 14.833 35.9777L16.233 36.5777C16.3775 36.6333 16.5219 36.6666 16.6663 36.6666C16.8108 36.6666 16.9663 36.6333 17.0997 36.5777L18.4997 35.9777C19.0108 35.7555 19.5108 35.511 19.9997 35.2555C18.9441 34.411 18.033 33.3999 17.3219 32.2444Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M23.8886 14.9333V13.2221L16.6663 9.94436L9.44412 13.2221V18.5888C9.44412 23.3221 12.0552 27.6333 16.1775 29.8444C15.7775 28.6666 15.5552 27.411 15.5552 26.111C15.5552 20.8333 19.0775 16.3777 23.8886 14.9333Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M27.2219 16.6666C22.0108 16.6666 17.7775 20.8999 17.7775 26.111C17.7775 31.3221 22.0108 35.5555 27.2219 35.5555C32.433 35.5555 36.6663 31.3221 36.6663 26.111C36.6663 20.8999 32.433 16.6666 27.2219 16.6666ZM31.6997 24.5888L27.133 29.1999C27.0301 29.3049 26.9074 29.3884 26.772 29.4456C26.6366 29.5029 26.4911 29.5326 26.3441 29.5333C26.0552 29.5333 25.7663 29.411 25.5552 29.211L22.7441 26.3999C22.3108 25.9666 22.3108 25.2666 22.7441 24.8221C23.1775 24.3888 23.8775 24.3888 24.3219 24.8221L26.3441 26.8444L30.1219 23.0333C30.224 22.929 30.3459 22.8462 30.4804 22.7897C30.6149 22.7332 30.7593 22.7041 30.9052 22.7041C31.0511 22.7041 31.1956 22.7332 31.3301 22.7897C31.4646 22.8462 31.5865 22.929 31.6886 23.0333C32.1219 23.4666 32.133 24.1666 31.6886 24.5999L31.6997 24.5888Z"
                                                    fill="#5F6F94" />
                                            </svg></span>
                                    </div>
                                </div>
                                <button class="vac_select_div" aria-label="expand accordion section for Secure industrial zones"
                                    aria-expanded="false">
                                    <h2 class="vac_ac_header">
                                        Secure industrial zones
                                    </h2>
                                    <span class="vac_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vac_accontent">
                                    <p class="vac-description">
                                        Advanced perimeter monitoring and access control keep industrial areas protected 24/7.
                                    </p>
                                    <div class="vac_accordion_video">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-image">
                                                <img decoding="async"
                                                    src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp"
                                                    class="card-img-top h-100" alt="Secure industrial zones">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Secure industrial zones</h5>
                                                <p class="card-text text-muted">
                                                    Advanced perimeter monitoring and access control keep industrial areas
                                                    protected 24/7.
                                                </p>
                                                <div class="d-flex flex-wrap gap-2 mt-4">
                                                    <span class="badge-custom">Perimeter security</span>
                                                    <span class="badge-custom">Access control</span>
                                                    <span class="badge-custom">24/7 monitoring</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vac_progress_bar"></div>
                            </div>

                            <div class="vac_accordion_set">
                                <div class="vac_ac_icon_wrap">
                                    <div class="vac_ac_icon_border">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                                fill="none">
                                                <path
                                                    d="M17.3219 32.2444C17.2552 32.2777 17.1886 32.311 17.1108 32.3444C16.9663 32.411 16.8219 32.4333 16.6663 32.4333C16.5108 32.4333 16.3663 32.3999 16.2219 32.3444C13.5465 31.1752 11.2702 29.2512 9.67167 26.808C8.07313 24.3648 7.22179 21.5085 7.2219 18.5888V12.4999C7.2219 12.0666 7.47745 11.6666 7.87745 11.4888L16.2108 7.69992C16.4997 7.56659 16.833 7.56659 17.133 7.69992L25.4663 11.4888C25.8663 11.6666 26.1219 12.0666 26.1219 12.4999V14.4999C26.4886 14.4666 26.8552 14.4444 27.233 14.4444C28.1886 14.4444 29.1219 14.5777 30.0108 14.7888V9.99992C30.0108 9.56659 29.7552 9.16659 29.3552 8.98881L17.1219 3.43325C16.833 3.29992 16.4997 3.29992 16.1997 3.43325L3.98856 8.98881C3.58856 9.16659 3.33301 9.56659 3.33301 9.99992V18.5888C3.33301 26.1777 7.84412 33.011 14.833 35.9777L16.233 36.5777C16.3775 36.6333 16.5219 36.6666 16.6663 36.6666C16.8108 36.6666 16.9663 36.6333 17.0997 36.5777L18.4997 35.9777C19.0108 35.7555 19.5108 35.511 19.9997 35.2555C18.9441 34.411 18.033 33.3999 17.3219 32.2444Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M23.8886 14.9333V13.2221L16.6663 9.94436L9.44412 13.2221V18.5888C9.44412 23.3221 12.0552 27.6333 16.1775 29.8444C15.7775 28.6666 15.5552 27.411 15.5552 26.111C15.5552 20.8333 19.0775 16.3777 23.8886 14.9333Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M27.2219 16.6666C22.0108 16.6666 17.7775 20.8999 17.7775 26.111C17.7775 31.3221 22.0108 35.5555 27.2219 35.5555C32.433 35.5555 36.6663 31.3221 36.6663 26.111C36.6663 20.8999 32.433 16.6666 27.2219 16.6666ZM31.6997 24.5888L27.133 29.1999C27.0301 29.3049 26.9074 29.3884 26.772 29.4456C26.6366 29.5029 26.4911 29.5326 26.3441 29.5333C26.0552 29.5333 25.7663 29.411 25.5552 29.211L22.7441 26.3999C22.3108 25.9666 22.3108 25.2666 22.7441 24.8221C23.1775 24.3888 23.8775 24.3888 24.3219 24.8221L26.3441 26.8444L30.1219 23.0333C30.224 22.929 30.3459 22.8462 30.4804 22.7897C30.6149 22.7332 30.7593 22.7041 30.9052 22.7041C31.0511 22.7041 31.1956 22.7332 31.3301 22.7897C31.4646 22.8462 31.5865 22.929 31.6886 23.0333C32.1219 23.4666 32.133 24.1666 31.6886 24.5999L31.6997 24.5888Z"
                                                    fill="#5F6F94" />
                                            </svg></span>
                                    </div>
                                </div>
                                <button class="vac_select_div"
                                    aria-label="expand accordion section for Accelerated emergency response"
                                    aria-expanded="false">
                                    <h2 class="vac_ac_header">
                                        Accelerated emergency response
                                    </h2>
                                    <span class="vac_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vac_accontent">
                                    <p class="vac-description">
                                        Instant alerts and automated notifications reduce emergency response times
                                        significantly.
                                    </p>
                                    <div class="vac_accordion_video">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-image">
                                                <img decoding="async"
                                                    src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp"
                                                    class="card-img-top h-100" alt="Accelerated emergency response">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Accelerated emergency response</h5>
                                                <p class="card-text text-muted">
                                                    Instant alerts and automated notifications reduce emergency response times
                                                    significantly.
                                                </p>
                                                <div class="d-flex flex-wrap gap-2 mt-4">
                                                    <span class="badge-custom">Instant alerts</span>
                                                    <span class="badge-custom">Auto notifications</span>
                                                    <span class="badge-custom">Fast response</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vac_progress_bar"></div>
                            </div>

                            <div class="vac_accordion_set">
                                <div class="vac_ac_icon_wrap">
                                    <div class="vac_ac_icon_border">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                                fill="none">
                                                <path
                                                    d="M17.3219 32.2444C17.2552 32.2777 17.1886 32.311 17.1108 32.3444C16.9663 32.411 16.8219 32.4333 16.6663 32.4333C16.5108 32.4333 16.3663 32.3999 16.2219 32.3444C13.5465 31.1752 11.2702 29.2512 9.67167 26.808C8.07313 24.3648 7.22179 21.5085 7.2219 18.5888V12.4999C7.2219 12.0666 7.47745 11.6666 7.87745 11.4888L16.2108 7.69992C16.4997 7.56659 16.833 7.56659 17.133 7.69992L25.4663 11.4888C25.8663 11.6666 26.1219 12.0666 26.1219 12.4999V14.4999C26.4886 14.4666 26.8552 14.4444 27.233 14.4444C28.1886 14.4444 29.1219 14.5777 30.0108 14.7888V9.99992C30.0108 9.56659 29.7552 9.16659 29.3552 8.98881L17.1219 3.43325C16.833 3.29992 16.4997 3.29992 16.1997 3.43325L3.98856 8.98881C3.58856 9.16659 3.33301 9.56659 3.33301 9.99992V18.5888C3.33301 26.1777 7.84412 33.011 14.833 35.9777L16.233 36.5777C16.3775 36.6333 16.5219 36.6666 16.6663 36.6666C16.8108 36.6666 16.9663 36.6333 17.0997 36.5777L18.4997 35.9777C19.0108 35.7555 19.5108 35.511 19.9997 35.2555C18.9441 34.411 18.033 33.3999 17.3219 32.2444Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M23.8886 14.9333V13.2221L16.6663 9.94436L9.44412 13.2221V18.5888C9.44412 23.3221 12.0552 27.6333 16.1775 29.8444C15.7775 28.6666 15.5552 27.411 15.5552 26.111C15.5552 20.8333 19.0775 16.3777 23.8886 14.9333Z"
                                                    fill="#5F6F94" />
                                                <path
                                                    d="M27.2219 16.6666C22.0108 16.6666 17.7775 20.8999 17.7775 26.111C17.7775 31.3221 22.0108 35.5555 27.2219 35.5555C32.433 35.5555 36.6663 31.3221 36.6663 26.111C36.6663 20.8999 32.433 16.6666 27.2219 16.6666ZM31.6997 24.5888L27.133 29.1999C27.0301 29.3049 26.9074 29.3884 26.772 29.4456C26.6366 29.5029 26.4911 29.5326 26.3441 29.5333C26.0552 29.5333 25.7663 29.411 25.5552 29.211L22.7441 26.3999C22.3108 25.9666 22.3108 25.2666 22.7441 24.8221C23.1775 24.3888 23.8775 24.3888 24.3219 24.8221L26.3441 26.8444L30.1219 23.0333C30.224 22.929 30.3459 22.8462 30.4804 22.7897C30.6149 22.7332 30.7593 22.7041 30.9052 22.7041C31.0511 22.7041 31.1956 22.7332 31.3301 22.7897C31.4646 22.8462 31.5865 22.929 31.6886 23.0333C32.1219 23.4666 32.133 24.1666 31.6886 24.5999L31.6997 24.5888Z"
                                                    fill="#5F6F94" />
                                            </svg></span>
                                    </div>
                                </div>
                                <button class="vac_select_div" aria-label="expand accordion section for Unified city operations"
                                    aria-expanded="false">
                                    <h2 class="vac_ac_header">
                                        Unified city operations
                                    </h2>
                                    <span class="vac_chevron">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="vac_accontent">
                                    <p class="vac-description">
                                        Centralized command centers integrate all city systems for seamless management and
                                        coordination.
                                    </p>
                                    <div class="vac_accordion_video">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-image">
                                                <img decoding="async"
                                                    src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp"
                                                    class="card-img-top h-100" alt="Unified city operations">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Unified city operations</h5>
                                                <p class="card-text text-muted">
                                                    Centralized command centers integrate all city systems for seamless
                                                    management.
                                                </p>
                                                <div class="d-flex flex-wrap gap-2 mt-4">
                                                    <span class="badge-custom">Command center</span>
                                                    <span class="badge-custom">System integration</span>
                                                    <span class="badge-custom">Seamless management</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vac_progress_bar"></div>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6 col-12 vac_padd-accordion_video">
                        <h3>i2V solution and there results:</h3>
                        <div class="vac_accordion_video vac_active">
                            <li>
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-image">
                                        <img decoding="async"
                                            src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp"
                                            class="card-img-top h-100" alt="AI-Based Video Analytics">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Neural behavior recognition</h5>
                                        <p class="card-text text-muted">
                                            Advanced AI analyzes body language, movement patterns, and interaction behaviors to
                                            identify suspicious activities in real-time.
                                        </p>
                                        <div class="d-flex flex-wrap gap-2 mt-4">
                                            <span class="badge-custom">Micro-expression detection</span>
                                            <span class="badge-custom">Gesture pattern analysis</span>
                                            <span class="badge-custom">Group behavior monitoring</span>
                                            <span class="badge-custom">Exit intent prediction</span>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                        <div class="vac_accordion_video">
                            <li>
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-image">
                                        <img decoding="async"
                                            src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/no-helmet-detection.webp"
                                            class="card-img-top h-100" alt="AI-Based Video Analytics">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Neural behavior recognition</h5>
                                        <p class="card-text text-muted">
                                            Advanced AI analyzes body language, movement patterns, and interaction behaviors to
                                            identify suspicious activities in real-time.
                                        </p>
                                        <div class="d-flex flex-wrap gap-2 mt-4">
                                            <span class="badge-custom">Micro-expression detection</span>
                                            <span class="badge-custom">Gesture pattern analysis</span>
                                            <span class="badge-custom">Group behavior monitoring</span>
                                            <span class="badge-custom">Exit intent prediction</span>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                        <div class="vac_accordion_video">
                            <li>
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-image">
                                        <img decoding="async"
                                            src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp"
                                            class="card-img-top h-100" alt="AI-Based Video Analytics">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Neural behavior recognition</h5>
                                        <p class="card-text text-muted">
                                            Advanced AI analyzes body language, movement patterns, and interaction behaviors to
                                            identify suspicious activities in real-time.
                                        </p>
                                        <div class="d-flex flex-wrap gap-2 mt-4">
                                            <span class="badge-custom">Micro-expression detection</span>
                                            <span class="badge-custom">Gesture pattern analysis</span>
                                            <span class="badge-custom">Group behavior monitoring</span>
                                            <span class="badge-custom">Exit intent prediction</span>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                        <div class="vac_accordion_video">
                            <li>
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-image">
                                        <img decoding="async"
                                            src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp"
                                            class="card-img-top h-100" alt="AI-Based Video Analytics">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Neural behavior recognition</h5>
                                        <p class="card-text text-muted">
                                            Advanced AI analyzes body language, movement patterns, and interaction behaviors to
                                            identify suspicious activities in real-time.
                                        </p>
                                        <div class="d-flex flex-wrap gap-2 mt-4">
                                            <span class="badge-custom">Micro-expression detection</span>
                                            <span class="badge-custom">Gesture pattern analysis</span>
                                            <span class="badge-custom">Group behavior monitoring</span>
                                            <span class="badge-custom">Exit intent prediction</span>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                        <div class="vac_accordion_video">
                            <li>
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-image">
                                        <img decoding="async"
                                            src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp"
                                            class="card-img-top h-100" alt="AI-Based Video Analytics">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Neural behavior recognition</h5>
                                        <p class="card-text text-muted">
                                            Advanced AI analyzes body language, movement patterns, and interaction behaviors to
                                            identify suspicious activities in real-time.
                                        </p>
                                        <div class="d-flex flex-wrap gap-2 mt-4">
                                            <span class="badge-custom">Micro-expression detection</span>
                                            <span class="badge-custom">Gesture pattern analysis</span>
                                            <span class="badge-custom">Group behavior monitoring</span>
                                            <span class="badge-custom">Exit intent prediction</span>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                        <div class="vac_accordion_video">
                            <li>
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-image">
                                        <img decoding="async"
                                            src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2025/11/video.webp"
                                            class="card-img-top h-100" alt="AI-Based Video Analytics">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Neural behavior recognition</h5>
                                        <p class="card-text text-muted">
                                            Advanced AI analyzes body language, movement patterns, and interaction behaviors to
                                            identify suspicious activities in real-time.
                                        </p>
                                        <div class="d-flex flex-wrap gap-2 mt-4">
                                            <span class="badge-custom">Micro-expression detection</span>
                                            <span class="badge-custom">Gesture pattern analysis</span>
                                            <span class="badge-custom">Group behavior monitoring</span>
                                            <span class="badge-custom">Exit intent prediction</span>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                    </div>



                </div>

            </div>
        </section>

        <!-- Video Accordion Caption - Inline JavaScript -->
        <script>
            (function () {
                function initVACAccordion() {
                    if (typeof jQuery === 'undefined') {
                        setTimeout(initVACAccordion, 100);
                        return;
                    }
                    var $ = jQuery;
                    // Check if VAW accordion exists on the page
                    if ($('.vac_accordion_wrap').length === 0) {
                        return;
                    }

                    // Helper function to check if any modal is currently open
                    function isVACModalOpen() {
                        return $('.modal.show, .modal.in').length > 0 || $('body').hasClass('modal-open');
                    }

                    // Initialize each VAW accordion wrapper independently
                    $('.vac_accordion_wrap').each(function () {
                        var $accordionWrap = $(this);
                        var $accordionSets = $accordionWrap.find('.vac_accordion_set');
                        var $videoPanel = $accordionWrap.find('.vac_padd-accordion_video');
                        var $accordionVideos = $videoPanel.find('.vac_accordion_video');

                        // Skip if no accordion sets found
                        if ($accordionSets.length === 0) {
                            return;
                        }

                        // Open first section by default
                        var $first = $accordionSets.first();
                        $first.addClass('active');
                        $first.find('.vac_select_div').attr("aria-expanded", "true");

                        // Initialize videos - show first video, hide others
                        $accordionVideos.each(function (index) {
                            if (index === 0) {
                                $(this).addClass('vac_active').show();
                            } else {
                                $(this).removeClass('vac_active').hide();
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
                            $accordionVideos.each(function (videoIndex) {
                                if (videoIndex === index) {
                                    $(this).addClass('vac_active').show();
                                } else {
                                    $(this).removeClass('vac_active').hide();
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
                            $accordionSets.each(function () {
                                this.style.setProperty('--vac-progress', '0%');
                            });

                            // Start progress for active accordion item
                            var activeAccordion = $accordionSets.filter('.active')[0];
                            if (activeAccordion) {
                                var timeLeft = autoInterval / 1000; // Convert to seconds
                                var updateInterval = 50; // Update every 50ms for smooth animation

                                progressInterval = setInterval(function () {
                                    if (isPaused || isVACModalOpen()) {
                                        return;
                                    }

                                    timeLeft -= (updateInterval / 1000);
                                    var progress = ((autoInterval / 1000 - timeLeft) / (autoInterval / 1000)) * 100;

                                    // Update progress CSS variable
                                    activeAccordion.style.setProperty('--vac-progress', progress + '%');

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
                            $accordionSets.find('.vac_select_div').attr("aria-expanded", "false");

                            $target.addClass("active");
                            $target.find(".vac_select_div").attr("aria-expanded", "true");

                            // Switch to corresponding video
                            switchVideo(index);

                            // Start progress fill animation
                            startProgressFill();
                        }

                        // Auto slide function
                        function startAutoSlide() {
                            if (isPaused || isVACModalOpen()) {
                                return;
                            }
                            if (timer) {
                                clearInterval(timer);
                            }
                            timer = setInterval(function () {
                                if (!isPaused && !isVACModalOpen()) {
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
                            if (isVACModalOpen()) {
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
                        setTimeout(function () {
                            startProgressFill();
                        }, 200);

                        // Start auto slide initially
                        startAutoSlide();

                        // On click — manual control + reset timer
                        $accordionSets.find('.vac_select_div').click(function () {
                            pauseAutoSlide();

                            var $parent = $(this).parents('.vac_accordion_set');
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
                            resumeTimeout = setTimeout(function () {
                                resumeTimeout = null;
                                if (!isVACModalOpen()) {
                                    resumeAutoSlide();
                                }
                            }, 1000);
                        });

                        // Pause when VAW modal opens
                        $(document).on('show.bs.modal', '[id^="vacBackdrop"]', function () {
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
                        $(document).on('hidden.bs.modal', '[id^="vacBackdrop"]', function () {
                            var modal = $(this);
                            var iframe = modal.find('iframe');
                            if (iframe.length) {
                                iframe.attr('src', '');
                            }

                            setTimeout(function () {
                                if (!isVACModalOpen()) {
                                    resumeAutoSlide();
                                }
                            }, 100);
                        });
                    });
                }

                // Initialize when DOM is ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initVACAccordion);
                } else {
                    initVACAccordion();
                }
            })();
        </script>
        <?php
    }
}
?>
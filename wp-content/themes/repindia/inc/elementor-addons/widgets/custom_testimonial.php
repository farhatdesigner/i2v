<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Embed;
use Elementor\Plugin;

if (!defined('ABSPATH'))
    exit;

class Custom_Testimonial extends Widget_Base
{
    public function get_name()
    {
        return 'custom_testimonial';
    }

    public function get_title()
    {
        return esc_html__('Custom Testimonial', 'repindia');
    }

    public function get_icon()
    {
        return 'eicon-testimonial';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Testimonials', 'repindia'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        // Logo Image
        $repeater->add_control(
            'logo_image',
            [
                'label' => esc_html__('Logo Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'required' => true,
            ]
        );

        // Title
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Description/Quote
        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Testimonial Quote', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
                'rows' => 5,
            ]
        );

        // Author Name
        $repeater->add_control(
            'author_name',
            [
                'label' => esc_html__('Author Name', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Author Role
        $repeater->add_control(
            'author_role',
            [
                'label' => esc_html__('Author Role / Company', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Author Photo
        $repeater->add_control(
            'author_photo',
            [
                'label' => esc_html__('Author Photo', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Media Type
        $repeater->add_control(
            'media_type',
            [
                'label' => esc_html__('Media Type', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__('Image', 'repindia'),
                    'video' => esc_html__('Video', 'repindia'),
                ],
            ]
        );

        // Media Image
        $repeater->add_control(
            'media_image',
            [
                'label' => esc_html__('Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'media_type' => 'image',
                ],
            ]
        );

        // Video Source
        $repeater->add_control(
            'video_source',
            [
                'label' => esc_html__('Video Source', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__('YouTube URL', 'repindia'),
                    'hosted' => esc_html__('Upload MP4', 'repindia'),
                ],
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        // YouTube URL
        $repeater->add_control(
            'youtube_url',
            [
                'label' => esc_html__('YouTube URL', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'condition' => [
                    'media_type' => 'video',
                    'video_source' => 'youtube',
                ],
            ]
        );

        // Hosted Video
        $repeater->add_control(
            'hosted_video',
            [
                'label' => esc_html__('Upload MP4', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'default' => [],
                'condition' => [
                    'media_type' => 'video',
                    'video_source' => 'hosted',
                ],
            ]
        );

        // Video Settings
        $repeater->add_control(
            'video_lightbox',
            [
                'label' => esc_html__('Lightbox', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'default' => 'yes',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_overlay_image',
            [
                'label' => esc_html__('Overlay Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_autoplay',
            [
                'label' => esc_html__('Autoplay', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'default' => 'no',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_controls',
            [
                'label' => esc_html__('Controls', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'repindia'),
                'label_off' => esc_html__('Hide', 'repindia'),
                'default' => 'yes',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_mute',
            [
                'label' => esc_html__('Mute', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'default' => 'yes',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_loop',
            [
                'label' => esc_html__('Loop', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'default' => 'no',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_aspect_ratio',
            [
                'label' => esc_html__('Aspect Ratio', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'default' => '169',
                'options' => [
                    '169' => '16:9',
                    '43' => '4:3',
                    '219' => '21:9',
                ],
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_lazyload',
            [
                'label' => esc_html__('Lazy Load', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'default' => 'no',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_play_icon',
            [
                'label' => esc_html__('Play Icon', 'repindia'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'eicon-play',
                    'library' => 'eicons',
                ],
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $this->add_control(
            'testimonials_list',
            [
                'label' => esc_html__('Testimonials', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Testimonial 1', 'repindia'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        // Slider Settings
        $this->start_controls_section(
            'section_slider_settings',
            [
                'label' => esc_html__('Slider Settings', 'repindia'),
            ]
        );

        $this->add_control(
            'slider_autoplay',
            [
                'label' => esc_html__('Autoplay', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'default' => 'no',
            ]
        );

        $this->add_control(
            'slider_autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed (ms)', 'repindia'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3000,
                'condition' => [
                    'slider_autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'slider_speed',
            [
                'label' => esc_html__('Transition Speed (ms)', 'repindia'),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
            ]
        );

        $this->add_control(
            'slider_loop',
            [
                'label' => esc_html__('Loop', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'slider_slides_to_show',
            [
                'label' => esc_html__('Slides To Show', 'repindia'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => 4,
                'tablet_default' => 3,
                'mobile_default' => 2,
            ]
        );

        $this->add_control(
            'slider_slides_to_scroll',
            [
                'label' => esc_html__('Slides To Scroll', 'repindia'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 10,
                'step' => 1,
            ]
        );

        $this->add_control(
            'slider_navigation',
            [
                'label' => esc_html__('Navigation Arrows', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'repindia'),
                'label_off' => esc_html__('Hide', 'repindia'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'slider_pagination',
            [
                'label' => esc_html__('Pagination Dots', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'repindia'),
                'label_off' => esc_html__('Hide', 'repindia'),
                'default' => 'no',
            ]
        );

        $this->end_controls_section();

        // Style: Tabs
        $this->start_controls_section(
            'section_style_tabs',
            [
                'label' => esc_html__('Tabs', 'repindia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tabs_padding',
            [
                'label' => esc_html__('Padding', 'repindia'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-tab-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_margin',
            [
                'label' => esc_html__('Margin', 'repindia'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-tab-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_logo_size',
            [
                'label' => esc_html__('Logo Size', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-tab-item img' => 'max-width: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_background',
            [
                'label' => esc_html__('Background Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-tab-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_border_radius',
            [
                'label' => esc_html__('Border Radius', 'repindia'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-tab-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: Active Tab
        $this->start_controls_section(
            'section_style_active_tab',
            [
                'label' => esc_html__('Active Tab', 'repindia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'active_tab_background',
            [
                'label' => esc_html__('Background Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-tab-item.swiper-slide-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'active_tab_border',
                'label' => esc_html__('Border', 'repindia'),
                'selector' => '{{WRAPPER}} .custom-testimonial-tab-item.swiper-slide-active',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'active_tab_shadow',
                'label' => esc_html__('Box Shadow', 'repindia'),
                'selector' => '{{WRAPPER}} .custom-testimonial-tab-item.swiper-slide-active',
            ]
        );

        $this->end_controls_section();

        // Style: Quote Text
        $this->start_controls_section(
            'section_style_quote',
            [
                'label' => esc_html__('Quote Text', 'repindia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'quote_typography',
                'label' => esc_html__('Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .custom-testimonial-quote',
            ]
        );

        $this->add_control(
            'quote_color',
            [
                'label' => esc_html__('Text Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-quote' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'quote_margin',
            [
                'label' => esc_html__('Margin', 'repindia'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: Author
        $this->start_controls_section(
            'section_style_author',
            [
                'label' => esc_html__('Author', 'repindia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'author_name_typography',
                'label' => esc_html__('Name Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .custom-testimonial-author-name',
            ]
        );

        $this->add_control(
            'author_name_color',
            [
                'label' => esc_html__('Name Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-author-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'author_role_typography',
                'label' => esc_html__('Role Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .custom-testimonial-author-role',
            ]
        );

        $this->add_control(
            'author_role_color',
            [
                'label' => esc_html__('Role Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-author-role' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'author_photo_size',
            [
                'label' => esc_html__('Photo Size', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-author-photo img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_photo_border_radius',
            [
                'label' => esc_html__('Photo Border Radius', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-author-photo img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: Navigation Arrows
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => esc_html__('Navigation Arrows', 'repindia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'arrow_size',
            [
                'label' => esc_html__('Size', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-nav-arrow' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label' => esc_html__('Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-nav-arrow' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_background',
            [
                'label' => esc_html__('Background Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-nav-arrow' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_border_radius',
            [
                'label' => esc_html__('Border Radius', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-nav-arrow' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: Pagination
        $this->start_controls_section(
            'section_style_pagination',
            [
                'label' => esc_html__('Pagination', 'repindia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'pagination_size',
            [
                'label' => esc_html__('Size', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label' => esc_html__('Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_active_color',
            [
                'label' => esc_html__('Active Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_spacing',
            [
                'label' => esc_html__('Spacing', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_margin',
            [
                'label' => esc_html__('Margin Top', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: Media Container
        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__('Media Container', 'repindia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'media_border_radius',
            [
                'label' => esc_html__('Border Radius', 'repindia'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .custom-testimonial-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .custom-testimonial-media video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_padding',
            [
                'label' => esc_html__('Padding', 'repindia'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style: Play Button
        $this->start_controls_section(
            'section_style_play_button',
            [
                'label' => esc_html__('Play Button', 'repindia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'play_button_size',
            [
                'label' => esc_html__('Size', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-play-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'play_button_color',
            [
                'label' => esc_html__('Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-play-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'play_button_background',
            [
                'label' => esc_html__('Background Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-testimonial-play-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function get_play_icon_html($icon_settings)
    {
        if (empty($icon_settings)) {
            return '<i class="eicon-play"></i>';
        }

        // Handle SVG icons
        if (isset($icon_settings['library']) && $icon_settings['library'] === 'svg' && !empty($icon_settings['value']['url'])) {
            return '<img src="' . esc_url($icon_settings['value']['url']) . '" alt="' . esc_attr__('Play', 'repindia') . '">';
        }

        // Handle inline SVG
        if (isset($icon_settings['library']) && $icon_settings['library'] === 'svg' && !empty($icon_settings['value']['id'])) {
            $svg_url = wp_get_attachment_url($icon_settings['value']['id']);
            if ($svg_url) {
                return '<img src="' . esc_url($svg_url) . '" alt="' . esc_attr__('Play', 'repindia') . '">';
            }
        }

        // Handle icon class
        $icon_class = '';
        if (is_string($icon_settings['value'] ?? '')) {
            $icon_class = $icon_settings['value'];
        } elseif (isset($icon_settings['value']['value'])) {
            $icon_class = $icon_settings['value']['value'];
        }

        if (empty($icon_class)) {
            return '<i class="eicon-play"></i>';
        }

        // Add library prefix if needed
        if (isset($icon_settings['library']) && $icon_settings['library'] !== '' && $icon_settings['library'] !== 'svg') {
            $icon_class = $icon_settings['library'] . ' ' . $icon_class;
        }

        return '<i class="' . esc_attr($icon_class) . '"></i>';
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $testimonials = $settings['testimonials_list'] ?? [];

        if (empty($testimonials)) {
            return;
        }

        $widget_id = 'custom-testimonial-' . $this->get_id();
        $first_testimonial = $testimonials[0] ?? [];
        $show_navigation = !empty($settings['slider_navigation']);
        $show_pagination = !empty($settings['slider_pagination']);
        ?>
        <div class="custom-testimonial-widget" id="<?php echo esc_attr($widget_id); ?>">
            <div class="custom-testimonial-content-wrapper">
                <!-- Left Side: Quote & Author -->
                <div class="custom-testimonial-left">
                    <?php foreach ($testimonials as $index => $testimonial) : ?>
                        <div class="custom-testimonial-item <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo esc_attr($index); ?>">
                            <?php if (!empty($testimonial['description'])) : ?>
                                <div class="custom-testimonial-quote">
                                    <?php echo wp_kses_post($testimonial['description']); ?>
                                </div>
                            <?php endif; ?>

                            <div class="custom-testimonial-author">
                                <?php if (!empty($testimonial['author_photo']['url'])) : ?>
                                    <div class="custom-testimonial-author-photo">
                                        <img src="<?php echo esc_url($testimonial['author_photo']['url']); ?>" 
                                             alt="<?php echo esc_attr($testimonial['author_name'] ?? ''); ?>">
                                    </div>
                                <?php endif; ?>

                                <div class="custom-testimonial-author-info">
                                    <?php if (!empty($testimonial['author_name'])) : ?>
                                        <div class="custom-testimonial-author-name">
                                            <?php echo esc_html($testimonial['author_name']); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($testimonial['author_role'])) : ?>
                                        <div class="custom-testimonial-author-role">
                                            <?php echo esc_html($testimonial['author_role']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Right Side: Media -->
                <div class="custom-testimonial-right">
                    <?php foreach ($testimonials as $index => $testimonial) : ?>
                        <div class="custom-testimonial-media-item <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo esc_attr($index); ?>">
                            <?php if ($testimonial['media_type'] === 'image' && !empty($testimonial['media_image']['url'])) : ?>
                                <div class="custom-testimonial-media">
                                    <img src="<?php echo esc_url($testimonial['media_image']['url']); ?>" 
                                         alt="<?php echo esc_attr($testimonial['title'] ?? ''); ?>">
                                </div>
                            <?php elseif ($testimonial['media_type'] === 'video') : ?>
<?php
                                $video_url = '';
                                $video_type = 'youtube';
                                
                                if ($testimonial['video_source'] === 'youtube' && !empty($testimonial['youtube_url'])) {
                                    $video_url = $testimonial['youtube_url'];
                                    $video_type = 'youtube';
                                } elseif ($testimonial['video_source'] === 'hosted' && !empty($testimonial['hosted_video']['url'])) {
                                    $video_url = $testimonial['hosted_video']['url'];
                                    $video_type = 'hosted';
                                }

                                if (!empty($video_url)) :
                                    $overlay_image = !empty($testimonial['video_overlay_image']['url']) ? $testimonial['video_overlay_image']['url'] : '';
                                    $lightbox = !empty($testimonial['video_lightbox']) ? 'yes' : 'no';
                                    $autoplay = !empty($testimonial['video_autoplay']) ? 'yes' : 'no';
                                    $controls = !empty($testimonial['video_controls']) ? 'yes' : 'no';
                                    $mute = !empty($testimonial['video_mute']) ? 'yes' : 'no';
                                    $loop = !empty($testimonial['video_loop']) ? 'yes' : 'no';
                                    $aspect_ratio = $testimonial['video_aspect_ratio'] ?? '169';
                                    $lazyload = !empty($testimonial['video_lazyload']) ? 'yes' : 'no';
                                    
                                    // Get embed URL for YouTube
                                    $embed_url = $video_url;
                                    if ($video_type === 'youtube' && class_exists('\Elementor\Embed')) {
                                        $embed_url = Embed::get_embed_url($video_url, [
                                            'autoplay' => $autoplay === 'yes' ? '1' : '0',
                                            'mute' => $mute === 'yes' ? '1' : '0',
                                            'controls' => $controls === 'yes' ? '1' : '0',
                                            'loop' => $loop === 'yes' ? '1' : '0',
                                        ]);
                                    }
                                    ?>
                                    <div class="custom-testimonial-media custom-testimonial-video-wrapper elementor-open-<?php echo $lightbox === 'yes' ? 'lightbox' : 'inline'; ?>" 
                                         data-video-type="<?php echo esc_attr($video_type); ?>"
                                         data-video-url="<?php echo esc_attr($video_url); ?>"
                                         data-embed-url="<?php echo esc_attr($embed_url); ?>"
                                         data-lightbox="<?php echo esc_attr($lightbox); ?>"
                                         data-autoplay="<?php echo esc_attr($autoplay); ?>"
                                         data-controls="<?php echo esc_attr($controls); ?>"
                                         data-mute="<?php echo esc_attr($mute); ?>"
                                         data-loop="<?php echo esc_attr($loop); ?>"
                                         data-aspect-ratio="<?php echo esc_attr($aspect_ratio); ?>"
                                         data-lazyload="<?php echo esc_attr($lazyload); ?>">
                                        
                                        <?php if ($lightbox === 'yes') : ?>
                                            <?php if (!empty($overlay_image)) : ?>
                                                <div class="custom-testimonial-video-overlay elementor-custom-embed-image-overlay">
                                                    <img src="<?php echo esc_url($overlay_image); ?>" 
                                                         alt="<?php echo esc_attr($testimonial['title'] ?? ''); ?>">
                                                    <?php
                                                    $play_icon = $this->get_play_icon_html($testimonial['video_play_icon'] ?? []);
                                                    ?>
                                                    <div class="custom-testimonial-play-button">
                                                        <?php echo $play_icon; ?>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <?php
                                                // Get thumbnail for YouTube
                                                $thumbnail_url = '';
                                                if ($video_type === 'youtube' && class_exists('\Elementor\Embed')) {
                                                    $post_id = get_queried_object_id();
                                                    $thumbnail_html = Embed::get_embed_thumbnail_html($video_url, $post_id);
                                                    if (!empty($thumbnail_html)) {
                                                        preg_match('/src="([^"]+)"/', $thumbnail_html, $matches);
                                                        if (!empty($matches[1])) {
                                                            $thumbnail_url = $matches[1];
                                                        }
                                                    }
                                                }
                                                $play_icon = $this->get_play_icon_html($testimonial['video_play_icon'] ?? []);
                                                ?>
                                                <div class="custom-testimonial-video-overlay elementor-custom-embed-image-overlay">
                                                    <?php if (!empty($thumbnail_url)) : ?>
                                                        <img src="<?php echo esc_url($thumbnail_url); ?>" 
                                                             alt="<?php echo esc_attr($testimonial['title'] ?? ''); ?>">
                                                    <?php endif; ?>
                                                    <div class="custom-testimonial-play-button">
                                                        <?php echo $play_icon; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif ($video_type === 'hosted') : ?>
                                            <video <?php echo $autoplay === 'yes' ? 'autoplay' : ''; ?> 
                                                   <?php echo $controls === 'yes' ? 'controls' : ''; ?> 
                                                   <?php echo $mute === 'yes' ? 'muted' : ''; ?> 
                                                   <?php echo $loop === 'yes' ? 'loop' : ''; ?>
                                                   <?php echo $lazyload === 'yes' ? 'preload="none"' : ''; ?>
                                                   playsinline>
                                                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                                            </video>
                                        <?php else : ?>
                                            <?php
                                            // Inline YouTube embed
                                            if ($video_type === 'youtube' && class_exists('\Elementor\Embed')) {
                                                $embed_params = [
                                                    'autoplay' => $autoplay === 'yes' ? '1' : '0',
                                                    'mute' => $mute === 'yes' ? '1' : '0',
                                                    'controls' => $controls === 'yes' ? '1' : '0',
                                                    'loop' => $loop === 'yes' ? '1' : '0',
                                                ];
                                                $embed_options = [];
                                                $embed_html = Embed::get_embed_html($video_url, $embed_params, $embed_options);
                                                if (!empty($embed_html)) {
                                                    echo $embed_html;
                                                } else {
                                                    $play_icon = $this->get_play_icon_html($testimonial['video_play_icon'] ?? []);
                                                    ?>
                                                    <div class="custom-testimonial-video-placeholder">
                                                        <div class="custom-testimonial-play-button">
                                                            <?php echo $play_icon; ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                $play_icon = $this->get_play_icon_html($testimonial['video_play_icon'] ?? []);
                                                ?>
                                                <div class="custom-testimonial-video-placeholder">
                                                    <div class="custom-testimonial-play-button">
                                                        <?php echo $play_icon; ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Bottom: Tabs Slider -->
            <div class="custom-testimonial-tabs-wrapper">
                <?php if ($show_navigation) : ?>
                    <div class="custom-testimonial-nav-arrow custom-testimonial-nav-prev">
                        <i class="eicon-chevron-left"></i>
                    </div>
                <?php endif; ?>
                <div class="custom-testimonial-tabs-swiper swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($testimonials as $index => $testimonial) : ?>
                            <?php if (!empty($testimonial['logo_image']['url'])) : ?>
                                <div class="swiper-slide custom-testimonial-tab-item <?php echo $index === 0 ? 'swiper-slide-active' : ''; ?>" 
                                     data-index="<?php echo esc_attr($index); ?>">
                                    <img src="<?php echo esc_url($testimonial['logo_image']['url']); ?>" 
                                         alt="<?php echo esc_attr($testimonial['title'] ?? ''); ?>">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($show_pagination) : ?>
                        <div class="swiper-pagination"></div>
                    <?php endif; ?>
                </div>
                <?php if ($show_navigation) : ?>
                    <div class="custom-testimonial-nav-arrow custom-testimonial-nav-next">
                        <i class="eicon-chevron-right"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <style>
            .custom-testimonial-widget {
                width: 100%;
            }

            .custom-testimonial-content-wrapper {
                display: flex;
                gap: 40px;
                margin-bottom: 40px;
                align-items: flex-start;
            }

            .custom-testimonial-left,
            .custom-testimonial-right {
                flex: 1;
                position: relative;
            }

            .custom-testimonial-item,
            .custom-testimonial-media-item {
                display: none;
                opacity: 0;
                transition: opacity 0.5s ease;
            }

            .custom-testimonial-item.active,
            .custom-testimonial-media-item.active {
                display: block;
                opacity: 1;
            }

            .custom-testimonial-quote {
                font-size: 24px;
                line-height: 1.6;
                margin-bottom: 30px;
                color: #333;
            }

            .custom-testimonial-author {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .custom-testimonial-author-photo img {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                object-fit: cover;
            }

            .custom-testimonial-author-name {
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 5px;
                color: #333;
            }

            .custom-testimonial-author-role {
                font-size: 14px;
                color: #666;
            }

            .custom-testimonial-media {
                width: 100%;
                position: relative;
                overflow: hidden;
            }

            .custom-testimonial-media img,
            .custom-testimonial-media video {
                width: 100%;
                height: auto;
                display: block;
            }

            .custom-testimonial-video-wrapper {
                position: relative;
            }

            .custom-testimonial-video-overlay {
                position: relative;
                cursor: pointer;
            }

            .custom-testimonial-video-overlay img {
                width: 100%;
                height: auto;
                display: block;
            }

            .custom-testimonial-play-button {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 80px;
                height: 80px;
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 30px;
                color: #333;
                cursor: pointer;
                transition: all 0.3s ease;
                z-index: 10;
            }

            .custom-testimonial-play-button:hover {
                background-color: rgba(255, 255, 255, 1);
                transform: translate(-50%, -50%) scale(1.1);
            }

            .custom-testimonial-tabs-wrapper {
                position: relative;
                display: flex;
                align-items: center;
                gap: 20px;
            }

            .custom-testimonial-nav-arrow {
                flex-shrink: 0;
            }

            .custom-testimonial-tabs-swiper {
                flex: 1;
                overflow: hidden;
                width: 100%;
                position: relative;
            }

            .custom-testimonial-tabs-swiper.swiper {
                width: 100%;
            }

            .custom-testimonial-tabs-swiper .swiper-wrapper {
                display: flex;
                width: 100%;
                box-sizing: border-box;
            }

            .custom-testimonial-tabs-swiper .swiper-slide {
                /* Swiper will calculate width based on slidesPerView */
                flex-shrink: 0;
                width: auto;
                height: auto;
                box-sizing: border-box;
            }

            .custom-testimonial-tab-item {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                cursor: pointer;
                transition: all 0.3s ease;
                background-color: #f5f5f5;
                border-radius: 8px;
                box-sizing: border-box;
                height: auto;
                width: 100%;
                min-width: 0;
            }

            .custom-testimonial-tab-item img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                filter: grayscale(100%);
                opacity: 0.6;
                transition: all 0.3s ease;
            }

            .custom-testimonial-tab-item.swiper-slide-active {
                background-color: #fff;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .custom-testimonial-tab-item.swiper-slide-active img {
                filter: grayscale(0%);
                opacity: 1;
            }

            .custom-testimonial-nav-arrow {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                background-color: #f5f5f5;
                border-radius: 50%;
                transition: all 0.3s ease;
                font-size: 20px;
                color: #333;
            }

            .custom-testimonial-nav-arrow:hover {
                background-color: #333;
                color: #fff;
            }

            .custom-testimonial-nav-arrow.swiper-button-disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .custom-testimonial-tabs-swiper .swiper-pagination {
                position: relative;
                margin-top: 20px;
                text-align: center;
            }

            .custom-testimonial-tabs-swiper .swiper-pagination-bullet {
                width: 10px;
                height: 10px;
                background-color: #ccc;
                opacity: 1;
                margin: 0 5px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .custom-testimonial-tabs-swiper .swiper-pagination-bullet-active {
                background-color: #333;
                transform: scale(1.2);
            }

            @media (max-width: 768px) {
                .custom-testimonial-content-wrapper {
                    flex-direction: column;
                    gap: 30px;
                }
            }
        </style>

        <script>
            (function() {
                'use strict';
                
                var widgetId = '<?php echo esc_js($widget_id); ?>';
                var widgetElement = document.getElementById(widgetId);
                
                if (!widgetElement) return;

                var slidesToShow = <?php 
                    $slides_to_show = $settings['slider_slides_to_show'] ?? [];
                    $desktop_val = 4;
                    $tablet_val = 3;
                    $mobile_val = 2;
                    
                    if (is_array($slides_to_show)) {
                        // Check if it's a responsive control structure
                        if (isset($slides_to_show['desktop'])) {
                            $desktop_val = intval($slides_to_show['desktop']);
                        } elseif (isset($slides_to_show['size'])) {
                            $desktop_val = intval($slides_to_show['size']);
                        } elseif (is_numeric($slides_to_show)) {
                            $desktop_val = intval($slides_to_show);
                        }
                        
                        if (isset($slides_to_show['tablet'])) {
                            $tablet_val = intval($slides_to_show['tablet']);
                        }
                        
                        if (isset($slides_to_show['mobile'])) {
                            $mobile_val = intval($slides_to_show['mobile']);
                        }
                    } elseif (is_numeric($slides_to_show)) {
                        $desktop_val = intval($slides_to_show);
                    }
                    
                    echo wp_json_encode([
                        'desktop' => $desktop_val,
                        'tablet' => $tablet_val,
                        'mobile' => $mobile_val
                    ]);
                ?>;
                
                var settings = {
                    autoplay: <?php echo ($settings['slider_autoplay'] === 'yes') ? 'true' : 'false'; ?>,
                    autoplaySpeed: <?php echo intval($settings['slider_autoplay_speed'] ?? 3000); ?>,
                    speed: <?php echo intval($settings['slider_speed'] ?? 500); ?>,
                    loop: <?php echo ($settings['slider_loop'] === 'yes') ? 'true' : 'false'; ?>,
                    slidesToShow: slidesToShow,
                    slidesToScroll: <?php echo intval($settings['slider_slides_to_scroll'] ?? 1); ?>,
                    navigation: <?php echo ($settings['slider_navigation'] === 'yes') ? 'true' : 'false'; ?>,
                    pagination: <?php echo ($settings['slider_pagination'] === 'yes') ? 'true' : 'false'; ?>
                };

                var swiperInstance = null;
                var testimonials = <?php echo wp_json_encode($testimonials); ?>;

                function initSwiper() {
                    var swiperElement = widgetElement.querySelector('.custom-testimonial-tabs-swiper');
                    if (!swiperElement) {
                        // Fallback if swiper element not found
                        initTabClickHandlers();
                        initNavigationHandlers();
                        return;
                    }

                    // Wait for Elementor Swiper utility
                    if (typeof elementorFrontend === 'undefined' || !elementorFrontend.utils || !elementorFrontend.utils.swiper) {
                        setTimeout(initSwiper, 100);
                        return;
                    }

                    // Ensure container has width before initializing
                    var containerWidth = swiperElement.offsetWidth || swiperElement.clientWidth;
                    if (!containerWidth || containerWidth === 0) {
                        setTimeout(initSwiper, 100);
                        return;
                    }

                    var nextButton = widgetElement.querySelector('.custom-testimonial-nav-next');
                    var prevButton = widgetElement.querySelector('.custom-testimonial-nav-prev');
                    var totalSlides = testimonials.length;

                    // Ensure slides to show is a valid number
                    var desktopSlides = parseInt(settings.slidesToShow.desktop) || 4;
                    var tabletSlides = parseInt(settings.slidesToShow.tablet) || 3;
                    var mobileSlides = parseInt(settings.slidesToShow.mobile) || 2;
                    var slidesToScroll = parseInt(settings.slidesToScroll) || 1;

                    // Don't enable loop if slides are less than or equal to slides per view
                    var canLoop = settings.loop === true && totalSlides > desktopSlides;

                    // Configure autoplay
                    var autoplayConfig = false;
                    if (settings.autoplay === true && totalSlides > 1) {
                        autoplayConfig = {
                            delay: parseInt(settings.autoplaySpeed) || 3000,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true,
                            stopOnLastSlide: false,
                        };
                    }

                    // Set default to desktop, then override for smaller screens
                    var swiperConfig = {
                        slidesPerView: desktopSlides,
                        slidesPerGroup: slidesToScroll,
                        spaceBetween: 20,
                        loop: canLoop,
                        speed: parseInt(settings.speed) || 500,
                        autoplay: autoplayConfig,
                        watchOverflow: true,
                        centeredSlides: false,
                        freeMode: false,
                        breakpoints: {
                            // For screens smaller than 1024px, use tablet settings
                            768: {
                                slidesPerView: tabletSlides,
                                slidesPerGroup: slidesToScroll,
                                spaceBetween: 15,
                                loop: canLoop && totalSlides > tabletSlides,
                            },
                            // For screens smaller than 768px, use mobile settings
                            320: {
                                slidesPerView: mobileSlides,
                                slidesPerGroup: slidesToScroll,
                                spaceBetween: 10,
                                loop: canLoop && totalSlides > mobileSlides,
                            },
                        },
                    };

                    if (settings.navigation && nextButton && prevButton) {
                        swiperConfig.navigation = {
                            nextEl: nextButton,
                            prevEl: prevButton,
                        };
                    }

                    if (settings.pagination) {
                        var paginationEl = swiperElement.querySelector('.swiper-pagination');
                        if (paginationEl) {
                            swiperConfig.pagination = {
                                el: paginationEl,
                                clickable: true,
                                type: 'bullets',
                            };
                        }
                    }

                    swiperConfig.on = {
                        init: function() {
                            var swiper = this;
                            var activeIndex = 0;
                            if (canLoop && swiper.realIndex !== undefined) {
                                activeIndex = swiper.realIndex;
                            } else if (swiper.activeIndex !== undefined) {
                                activeIndex = swiper.activeIndex;
                            }
                            switchTestimonial(activeIndex);
                        },
                        slideChange: function() {
                            var swiper = this;
                            var activeIndex = 0;
                            if (canLoop && swiper.realIndex !== undefined) {
                                activeIndex = swiper.realIndex;
                            } else if (swiper.activeIndex !== undefined) {
                                activeIndex = swiper.activeIndex;
                            }
                            switchTestimonial(activeIndex);
                        }
                    };

                    try {
                        var swiperResult = elementorFrontend.utils.swiper(swiperElement, swiperConfig);
                        
                        // Store swiper instance reference - Elementor returns an object with swiper property
                        if (swiperResult) {
                            if (swiperResult.swiper) {
                                swiperInstance = swiperResult.swiper;
                            } else if (swiperResult.slideTo) {
                                swiperInstance = swiperResult;
                            } else {
                                swiperInstance = swiperResult;
                            }
                            
                            // Force update to ensure slidesPerView is applied correctly
                            if (swiperInstance) {
                                setTimeout(function() {
                                    // Get current breakpoint
                                    var currentWidth = window.innerWidth || swiperElement.offsetWidth;
                                    var currentSlidesPerView = desktopSlides;
                                    
                                    if (currentWidth < 640) {
                                        currentSlidesPerView = mobileSlides;
                                    } else if (currentWidth < 1024) {
                                        currentSlidesPerView = tabletSlides;
                                    }
                                    
                                    // Update Swiper
                                    if (typeof swiperInstance.update === 'function') {
                                        swiperInstance.update();
                                    }
                                    if (typeof swiperInstance.updateSlides === 'function') {
                                        swiperInstance.updateSlides();
                                    }
                                    if (typeof swiperInstance.updateSize === 'function') {
                                        swiperInstance.updateSize();
                                    }
                                    
                                    // Ensure params match current breakpoint
                                    if (swiperInstance.params && swiperInstance.params.slidesPerView !== currentSlidesPerView) {
                                        // Don't force override - let breakpoints handle it
                                        // Just trigger update
                                        if (typeof swiperInstance.update === 'function') {
                                            swiperInstance.update();
                                        }
                                    }
                                }, 200);
                                
                                // Also update on window resize
                                var resizeHandler = function() {
                                    if (swiperInstance && typeof swiperInstance.update === 'function') {
                                        swiperInstance.update();
                                    }
                                };
                                window.addEventListener('resize', resizeHandler);
                                
                                // Store resize handler for cleanup if needed
                                if (!widgetElement.resizeHandler) {
                                    widgetElement.resizeHandler = resizeHandler;
                                }
                            }
                            
                            // Ensure autoplay starts if configured
                            if (autoplayConfig) {
                                setTimeout(function() {
                                    if (swiperInstance) {
                                        // Try to start autoplay if it exists
                                        if (swiperInstance.autoplay) {
                                            if (typeof swiperInstance.autoplay.start === 'function') {
                                                swiperInstance.autoplay.start();
                                            } else if (swiperInstance.autoplay.running === false) {
                                                swiperInstance.autoplay.start();
                                            }
                                        }
                                        // Alternative: update autoplay delay if needed
                                        if (swiperInstance.params && swiperInstance.params.autoplay) {
                                            if (swiperInstance.params.autoplay.delay !== autoplayConfig.delay) {
                                                swiperInstance.params.autoplay.delay = autoplayConfig.delay;
                                            }
                                        }
                                    }
                                }, 200);
                            }
                        }
                    } catch(e) {
                        console.warn('Swiper initialization failed:', e);
                        swiperInstance = null;
                        // Fallback: manual tab switching
                        initTabClickHandlers();
                        initNavigationHandlers();
                    }
                }

                function switchTestimonial(index) {
                    // Ensure index is within bounds
                    var totalItems = testimonials.length;
                    if (index < 0) index = 0;
                    if (index >= totalItems) index = totalItems - 1;
                    
                    var leftItems = widgetElement.querySelectorAll('.custom-testimonial-item');
                    var rightItems = widgetElement.querySelectorAll('.custom-testimonial-media-item');
                    var tabItems = widgetElement.querySelectorAll('.custom-testimonial-tab-item');

                    leftItems.forEach(function(item, i) {
                        if (i === index) {
                            item.classList.add('active');
                            item.style.display = 'block';
                        } else {
                            item.classList.remove('active');
                            item.style.display = 'none';
                        }
                    });

                    rightItems.forEach(function(item, i) {
                        if (i === index) {
                            item.classList.add('active');
                            item.style.display = 'block';
                        } else {
                            item.classList.remove('active');
                            item.style.display = 'none';
                        }
                    });

                    tabItems.forEach(function(item, i) {
                        if (i === index) {
                            item.classList.add('swiper-slide-active');
                        } else {
                            item.classList.remove('swiper-slide-active');
                        }
                    });
                }

                function initVideoHandlers() {
                    var videoWrappers = widgetElement.querySelectorAll('.custom-testimonial-video-wrapper');
                    
                    videoWrappers.forEach(function(wrapper) {
                        var lightbox = wrapper.getAttribute('data-lightbox') === 'yes';
                        var videoType = wrapper.getAttribute('data-video-type');
                        var videoUrl = wrapper.getAttribute('data-video-url');
                        var embedUrl = wrapper.getAttribute('data-embed-url') || videoUrl;
                        var overlay = wrapper.querySelector('.custom-testimonial-video-overlay');
                        var playButton = wrapper.querySelector('.custom-testimonial-play-button');

                        if (lightbox && overlay && typeof elementorFrontend !== 'undefined') {
                            var autoplay = wrapper.getAttribute('data-autoplay') === 'yes' ? 'yes' : 'no';
                            var controls = wrapper.getAttribute('data-controls') === 'yes' ? 'yes' : 'no';
                            var mute = wrapper.getAttribute('data-mute') === 'yes' ? 'yes' : 'no';
                            var loop = wrapper.getAttribute('data-loop') === 'yes' ? 'yes' : 'no';
                            var aspectRatio = wrapper.getAttribute('data-aspect-ratio') || '169';

                            var lightboxUrl = embedUrl;
                            if (videoType === 'youtube' && typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.youtube) {
                                // Use Elementor's YouTube utility if available
                                if (autoplay === 'yes' && elementorFrontend.utils.youtube.getAutoplayURL) {
                                    lightboxUrl = elementorFrontend.utils.youtube.getAutoplayURL(embedUrl);
                                }
                            }

                            var lightboxOptions = {
                                type: 'video',
                                videoType: videoType,
                                url: lightboxUrl,
                                autoplay: autoplay,
                                modalOptions: {
                                    id: 'custom-testimonial-lightbox-' + widgetId + '-' + Math.random().toString(36).substr(2, 9),
                                    entranceAnimation: 'fadeIn',
                                    videoAspectRatio: aspectRatio,
                                },
                            };

                            if (videoType === 'hosted') {
                                lightboxOptions.videoParams = {
                                    autoplay: autoplay === 'yes' ? '1' : '0',
                                    controls: controls === 'yes' ? '1' : '0',
                                    muted: mute === 'yes' ? '1' : '0',
                                    loop: loop === 'yes' ? '1' : '0',
                                };
                            }

                            overlay.setAttribute('data-elementor-open-lightbox', 'yes');
                            overlay.setAttribute('data-elementor-lightbox', JSON.stringify(lightboxOptions));
                            
                            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.createActionHash) {
                                try {
                                    var actionHash = elementorFrontend.createActionHash('lightbox', lightboxOptions);
                                    overlay.setAttribute('data-e-action-hash', actionHash);
                                } catch(e) {
                                    // Fallback if createActionHash fails
                                }
                            }

                            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.isEditMode && elementorFrontend.isEditMode()) {
                                overlay.classList.add('elementor-clickable');
                            }

                            // Add click handler for lightbox
                            overlay.addEventListener('click', function(e) {
                                if (typeof elementorFrontend !== 'undefined' && elementorFrontend.modules && elementorFrontend.modules.lightbox) {
                                    e.preventDefault();
                                    elementorFrontend.modules.lightbox.openModal(lightboxOptions);
                                }
                            });
                        }
                    });
                }

                function initTabClickHandlers() {
                    var tabItems = widgetElement.querySelectorAll('.custom-testimonial-tab-item');
                    
                    tabItems.forEach(function(tab, index) {
                        // Remove existing listener if any
                        var newTab = tab.cloneNode(true);
                        tab.parentNode.replaceChild(newTab, tab);
                        
                        newTab.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            var tabIndex = parseInt(this.getAttribute('data-index') || index, 10);
                            
                            if (swiperInstance) {
                                try {
                                    if (swiperInstance.slideTo) {
                                        swiperInstance.slideTo(tabIndex);
                                    } else if (swiperInstance.slideToLoop) {
                                        swiperInstance.slideToLoop(tabIndex);
                                    } else {
                                        switchTestimonial(tabIndex);
                                    }
                                } catch(err) {
                                    switchTestimonial(tabIndex);
                                }
                            } else {
                                switchTestimonial(tabIndex);
                            }
                        });
                    });
                }

                function initNavigationHandlers() {
                    var nextButton = widgetElement.querySelector('.custom-testimonial-nav-next');
                    var prevButton = widgetElement.querySelector('.custom-testimonial-nav-prev');
                    var currentIndex = 0;
                    var totalItems = testimonials.length;

                    function goToNext() {
                        currentIndex = (currentIndex + 1) % totalItems;
                        if (swiperInstance) {
                            try {
                                if (swiperInstance.slideNext) {
                                    swiperInstance.slideNext();
                                } else {
                                    switchTestimonial(currentIndex);
                                }
                            } catch(e) {
                                switchTestimonial(currentIndex);
                            }
                        } else {
                            switchTestimonial(currentIndex);
                        }
                    }

                    function goToPrev() {
                        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
                        if (swiperInstance) {
                            try {
                                if (swiperInstance.slidePrev) {
                                    swiperInstance.slidePrev();
                                } else {
                                    switchTestimonial(currentIndex);
                                }
                            } catch(e) {
                                switchTestimonial(currentIndex);
                            }
                        } else {
                            switchTestimonial(currentIndex);
                        }
                    }

                    if (nextButton) {
                        nextButton.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            goToNext();
                        });
                    }

                    if (prevButton) {
                        prevButton.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            goToPrev();
                        });
                    }
                }

                function init() {
                    // Initialize tab click handlers first (always needed)
                    initTabClickHandlers();
                    
                    // Initialize navigation handlers (always needed as fallback)
                    initNavigationHandlers();
                    
                    // Initialize Swiper
                    initSwiper();
                    
                    // Initialize video handlers
                    initVideoHandlers();
                }

                // Wait for DOM and Elementor to be ready
                function waitForElementor() {
                    // Always initialize basic handlers first
                    initTabClickHandlers();
                    initNavigationHandlers();
                    
                    // Then try to initialize Swiper
                    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                        initSwiper();
                        initVideoHandlers();
                    } else {
                        // Wait a bit more for Elementor
                        setTimeout(function() {
                            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                                initSwiper();
                                initVideoHandlers();
                            } else {
                                // Still initialize video handlers even without Swiper
                                initVideoHandlers();
                                setTimeout(waitForElementor, 100);
                            }
                        }, 100);
                    }
                }

                // Initialize immediately if DOM is ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(waitForElementor, 50);
                    });
                } else {
                    setTimeout(waitForElementor, 50);
                }

                // Elementor editor compatibility
                if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                    elementorFrontend.hooks.addAction('frontend/element_ready/custom_testimonial.default', function(scope) {
                        if (scope && scope.length > 0 && scope[0].id === widgetId) {
                            setTimeout(function() {
                                initTabClickHandlers();
                                initNavigationHandlers();
                                initSwiper();
                                initVideoHandlers();
                            }, 100);
                        }
                    });
                }
            })();
        </script>
<?php
    }
}

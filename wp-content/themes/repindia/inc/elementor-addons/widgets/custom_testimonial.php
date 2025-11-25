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
    ?>
    <div class="custom-testimonial-widget" id="<?php echo esc_attr($widget_id); ?>">
        <div class="custom-testimonial-content-wrapper">
            <!-- Left Side: Quote & Author -->
            <div class="custom-testimonial-left">
                <?php foreach ($testimonials as $index => $testimonial) : ?>
                    <div class="custom-testimonial-item <?php echo $index === 1 ? 'active' : ''; ?>" data-index="<?php echo esc_attr($index); ?>">
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
                    <div class="custom-testimonial-media-item <?php echo $index === 1 ? 'active' : ''; ?>" data-index="<?php echo esc_attr($index); ?>">
                        <?php if (($testimonial['media_type'] ?? '') === 'image' && !empty($testimonial['media_image']['url'])) : ?>
                            <div class="custom-testimonial-media">
                                <img src="<?php echo esc_url($testimonial['media_image']['url']); ?>" 
                                        alt="<?php echo esc_attr($testimonial['title'] ?? ''); ?>">
                            </div>
                        <?php elseif (($testimonial['media_type'] ?? '') === 'video') : ?>
                            <?php
                            $video_url = '';
                            $video_type = 'youtube';

                            if (($testimonial['video_source'] ?? '') === 'youtube' && !empty($testimonial['youtube_url'])) {
                                $video_url = $testimonial['youtube_url'];
                                $video_type = 'youtube';
                            } elseif (($testimonial['video_source'] ?? '') === 'hosted' && !empty($testimonial['hosted_video']['url'])) {
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

                                // Get embed URL for YouTube (Elementor helper)
                                $embed_url = $video_url;
                                if ($video_type === 'youtube' && class_exists('\Elementor\Embed')) {
                                    $embed_url = \Elementor\Embed::get_embed_url($video_url, [
                                        'autoplay' => $autoplay === 'yes' ? '1' : '0',
                                        'mute' => $mute === 'yes' ? '1' : '0',
                                        'controls' => $controls === 'yes' ? '1' : '0',
                                        'loop' => $loop === 'yes' ? '1' : '0',
                                    ]);
                                }
                                ?>
                                <div class="custom-testimonial-media custom-testimonial-video-wrapper"
                                    data-video-type="<?php echo esc_attr($video_type); ?>"
                                    data-video-url="<?php echo esc_attr($video_url); ?>"
                                    data-embed-url="<?php echo esc_attr($embed_url); ?>">

                                    <?php if ($lightbox === 'yes') : ?>
                                        <a href="<?php echo esc_url($video_url); ?>"
                                        class="elementor-open-lightbox"
                                        data-elementor-open-lightbox="yes"
                                        data-elementor-lightbox-slideshow="video-gallery-<?php echo esc_attr($widget_id); ?>"
                                        data-elementor-lightbox-title="<?php echo esc_attr($testimonial['title'] ?? ''); ?>">

                                            <?php if (!empty($overlay_image)) : ?>
                                                <div class="custom-testimonial-video-overlay elementor-custom-embed-image-overlay">
                                                    <img src="<?php echo esc_url($overlay_image); ?>"
                                                        alt="<?php echo esc_attr($testimonial['title'] ?? ''); ?>">

                                                    <div class="custom-testimonial-play-button">
                                                        <?php echo $this->get_play_icon_html($testimonial['video_play_icon'] ?? []); ?>
                                                    </div>
                                                </div>

                                            <?php else : ?>

                                                <?php
                                                // Thumbnail for YouTube
                                                $thumbnail_url = '';
                                                if ($video_type === 'youtube' && class_exists('\Elementor\Embed')) {
                                                    $post_id = get_queried_object_id();
                                                    $thumb_html = \Elementor\Embed::get_embed_thumbnail_html($video_url, $post_id);

                                                    if (!empty($thumb_html)) {
                                                        preg_match('/src="([^"]+)"/', $thumb_html, $m);
                                                        $thumbnail_url = $m[1] ?? '';
                                                    }
                                                }
                                                ?>

                                                <div class="custom-testimonial-video-overlay elementor-custom-embed-image-overlay">
                                                    <?php if (!empty($thumbnail_url)) : ?>
                                                        <img src="<?php echo esc_url($thumbnail_url); ?>"
                                                            alt="<?php echo esc_attr($testimonial['title'] ?? ''); ?>">
                                                    <?php endif; ?>

                                                    <div class="custom-testimonial-play-button">
                                                        <?php echo $this->get_play_icon_html($testimonial['video_play_icon'] ?? []); ?>
                                                    </div>
                                                </div>

                                            <?php endif; ?>
                                        </a>

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
                                                'mute'     => $mute === 'yes' ? '1' : '0',
                                                'controls' => $controls === 'yes' ? '1' : '0',
                                                'loop'     => $loop === 'yes' ? '1' : '0',
                                            ];
                                            $embed_html = \Elementor\Embed::get_embed_html($video_url, $embed_params, []);

                                            if (!empty($embed_html)) {
                                                echo $embed_html;
                                            } else {
                                                ?>
                                                <div class="custom-testimonial-video-placeholder">
                                                    <div class="custom-testimonial-play-button">
                                                        <?php echo $this->get_play_icon_html($testimonial['video_play_icon'] ?? []); ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
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

        <!-- Bottom: Swiper Tabs (4 visible, slide 1, 2nd visible = active) -->
        <div class="custom-testimonial-tabs-wrapper">
            <div class="custom-testimonial-tabs-swiper swiper" id="<?php echo esc_attr($widget_id); ?>-tabs-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($testimonials as $index => $testimonial) : ?>
                        <div class="swiper-slide custom-testimonial-tab-item <?php echo $index === 1 ? 'active' : ''; ?>" 
                                data-index="<?php echo esc_attr($index); ?>">
                            <?php if (!empty($testimonial['logo_image']['url'])) : ?>
                                <img src="<?php echo esc_url($testimonial['logo_image']['url']); ?>" 
                                        alt="<?php echo esc_attr($testimonial['title'] ?? ''); ?>">
                            <?php else : ?>
                                <span class="custom-testimonial-tab-placeholder"><?php echo esc_html($testimonial['title'] ?? 'Tab ' . ($index + 1)); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- navigation -->
                <div class="swiper-button-prev <?php echo esc_attr($widget_id); ?>-tabs-prev"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/left-arrow.svg" alt="Next"></div>
                <div class="swiper-button-next <?php echo esc_attr($widget_id); ?>-tabs-next">  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/right-arrow.svg" alt="Prev"></div>
            </div>
        </div>

        <!-- styles (scoped to widget) -->
        <style>
            /* Scoped by widget ID to avoid global override */
            #<?php echo esc_attr($widget_id); ?> { --ct-gap: 80px; }
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-widget,
            #<?php echo esc_attr($widget_id); ?> { width: 100%; }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-content-wrapper {
                display: flex;
                gap: var(--ct-gap);
                margin-bottom: 40px;
                align-items: center;
                padding: 0 60px;
            }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-left,
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-right {
                position: relative;
            }
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-left{width: 45%;}
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-right {width: 55%;}

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-item,
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-media-item {
                display: none;
                opacity: 0;
                transition: opacity .45s ease;
            }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-item.active,
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-media-item.active {
                display: block;
                opacity: 1;
            }

            /* Quote & author */
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-quote {
                font-size: 28px;
                line-height:  121.429%;
                margin-bottom: 40px;
                color: rgba(255, 255, 255, 0.90);
                font-weight: 400;
            }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-author {
                display: flex;
                align-items: center;
                gap: 20px;
            }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-author-photo img {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                object-fit: cover;
            }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-author-name {
                font-size: 18px;
                font-weight: 500;
                margin-bottom: 5px;
                color: #AEB6C9;
                line-height: 142.857%;
            }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-author-role {
                font-size: 14px;
                color: #AEB6C9;
                font-weight: 400;
                line-height: 144.444%;
            }

            /* media */
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-media img,
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-media video {
                width: 100%;
                height: auto;
                display: block;
            }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-video-wrapper { position: relative; }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-video-overlay { position: relative; cursor: pointer; }
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-video-overlay img { width:100%; height:auto; display:block;border-radius: 8px; }

            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-play-button {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                /* width: 80px;
                height: 80px; */
                /* background-color: rgba(255,255,255,.95); */
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 30px;
                color: #222;
                cursor: pointer;
                z-index: 10;
                transition: transform .25s ease, background .25s ease;
            }

            
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-play-button:hover { transform: translate(-50%,-50%) scale(1.06); }

            /* Tabs swiper */
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tabs-wrapper { position: relative; width: 100%; padding: 18px 40px; box-sizing: border-box; }
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tabs-swiper .swiper-wrapper {
                align-items: center;
                padding-left: 50px;
                padding-right: 50px;
                overflow: visible !important;
                display: flex !important;
            }
            #<?php echo esc_attr($widget_id); ?> .swiper-slide {
                width: auto !important;
                flex-shrink: 0 !important;
                padding: 0px;
                min-width: 132px!important;
                height: 75px;
                border-radius: 12px;
            }
            #<?php echo esc_attr($widget_id); ?> .swiper-slide img,#<?php echo esc_attr($widget_id); ?> .swiper-slide svg { border-radius: 12px;width: 132px;height: 75px;}
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tabs-swiper .swiper-slide { 
                display: flex !important; 
                flex-shrink: 0;
            }
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tab-item { display:flex; align-items:center; justify-content:center; padding:14px; border-radius:10px; background:#fff0; transition: all .25s ease; border:2px solid transparent; }
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tab-item img { transition: all .25s ease; display:block; }
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tab-placeholder { font-size: 12px; color: rgba(255,255,255,0.7); text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px; }
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tab-item.active { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.12); }
            #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tab-item.active img { opacity: 1; }

            /* arrows (scoped) */
            #<?php echo esc_attr($widget_id); ?> .swiper-button-prev,
            #<?php echo esc_attr($widget_id); ?> .swiper-button-next {
                width:44px; height:44px; border-radius:50%; background: rgba(255,255,255,0.06);
                display:flex; align-items:center; justify-content:center; color:#fff; opacity:1;
            }
            
            /* Hide default Swiper arrow icons - using local icons instead */
            #<?php echo esc_attr($widget_id); ?> .swiper-button-prev:after,
            #<?php echo esc_attr($widget_id); ?> .swiper-button-next:after,
            #<?php echo esc_attr($widget_id); ?> .swiper-rtl .swiper-button-prev:after,
            #<?php echo esc_attr($widget_id); ?> .swiper-rtl .swiper-button-next:after {
                display: none !important;
                content: none !important;
            }

            /* Responsiveness */
            @media (max-width: 1024px) {
                #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tabs-swiper .swiper-slide img { max-height:40px; }
                #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tabs-wrapper { padding: 14px 0px; }
            }
            @media (max-width: 768px) {
                #<?php echo esc_attr($widget_id); ?> .custom-testimonial-content-wrapper { flex-direction: column-reverse; gap: 20px;padding: 40px 0px 15px 0px; margin-bottom: 0;}
                #<?php echo esc_attr($widget_id); ?> .custom-testimonial-tabs-swiper .swiper-slide img { max-height:34px; }
                #<?php echo esc_attr($widget_id); ?> .custom-testimonial-left,    #<?php echo esc_attr($widget_id); ?> .custom-testimonial-right{width: 100%;}
                #<?php echo esc_attr($widget_id); ?> .custom-testimonial-quote {font-size: 18px;margin-bottom: 12px;margin-bottom: 20px;}
                #<?php echo esc_attr($widget_id); ?> .custom-testimonial-play-button {width:20%}
                .custom-testimonial-author-photo { max-width: 78px;max-height: 78px; }
                .custom-testimonial-author-photo svg,.custom-testimonial-author-photo img{ max-width: 78px;max-height: 78px; }
                #<?php echo esc_attr($widget_id); ?> .swiper-slide {
                    width: 112px !important;
                    min-width: unset!important;
                    height: 75px;
                }
            }
        </style>

        <script>
        (function(){
            'use strict';

            var widgetId = '<?php echo esc_js($widget_id); ?>';
            var selector = '#' + widgetId + '-tabs-swiper';
            var widgetEl = document.getElementById(widgetId);
            if (!widgetEl) return;

            var testimonials = <?php echo json_encode(array_values($testimonials), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
            // helper to switch content (keeps your existing switchTestimonial behavior)
            function switchTestimonial(index) {
                var totalItems = testimonials.length;
                if (index < 0) index = 0;
                if (index >= totalItems) index = totalItems - 1;

                var leftItems = widgetEl.querySelectorAll('.custom-testimonial-item');
                var rightItems = widgetEl.querySelectorAll('.custom-testimonial-media-item');
                var tabItems = widgetEl.querySelectorAll('.custom-testimonial-tab-item');

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
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
            }

            // init video overlay/lightbox handlers (keeps your existing behavior)
            // Replace existing initVideoHandlers with this robust version
            function buildLightboxOptionsFromWrapper(wrapper) {
                var videoType = wrapper.getAttribute('data-video-type') || 'youtube';
                var embedUrl = wrapper.getAttribute('data-embed-url') || wrapper.getAttribute('data-video-url') || '';
                var autoplay = wrapper.getAttribute('data-autoplay') === 'yes' ? 'yes' : 'no';
                var controls = wrapper.getAttribute('data-controls') === 'yes' ? 'yes' : 'no';
                var mute = wrapper.getAttribute('data-mute') === 'yes' ? 'yes' : 'no';
                var loop = wrapper.getAttribute('data-loop') === 'yes' ? 'yes' : 'no';
                var aspectRatio = wrapper.getAttribute('data-aspect-ratio') || '169';

                var lightboxUrl = embedUrl;
                // If elementor youtube helper available and autoplay requested, allow it
                if (videoType === 'youtube' && typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.youtube && autoplay === 'yes') {
                    if (elementorFrontend.utils.youtube.getAutoplayURL) {
                        lightboxUrl = elementorFrontend.utils.youtube.getAutoplayURL(embedUrl);
                    }
                }

                var opts = {
                    type: 'video',
                    videoType: videoType,
                    url: lightboxUrl,
                    autoplay: autoplay,
                    modalOptions: {
                        id: 'ct-lightbox-' + widgetId + '-' + Math.random().toString(36).substr(2,9),
                        entranceAnimation: 'fadeIn',
                        videoAspectRatio: aspectRatio
                    }
                };

                if (videoType === 'hosted') {
                    opts.videoParams = {
                        autoplay: autoplay === 'yes' ? '1' : '0',
                        controls: controls === 'yes' ? '1' : '0',
                        muted: mute === 'yes' ? '1' : '0',
                        loop: loop === 'yes' ? '1' : '0'
                    };
                }

                return opts;
            }

            function initVideoHandlers(scope) {
                scope = scope || widgetEl;

                // idempotent: avoid double-init for same wrapper
                var wrappers = scope.querySelectorAll('.custom-testimonial-video-wrapper');
                wrappers.forEach(function(wrapper) {
                    // ensure wrapper is marked to avoid repeated processing
                    if (!wrapper._ct_data_prepared) {
                        wrapper._ct_data_prepared = true;

                        // prepare overlay attributes (Elementor expects these attrs on the clickable element)
                        var overlay = wrapper.querySelector('.custom-testimonial-video-overlay');
                        if (overlay) {
                            var opts = buildLightboxOptionsFromWrapper(wrapper);
                            // set attributes to let Elementor recognize this as a lightbox link
                            overlay.setAttribute('data-elementor-open-lightbox', 'yes');
                            overlay.setAttribute('data-elementor-lightbox', JSON.stringify(opts));

                            // create action hash for editor compatibility if possible
                            try {
                                if (typeof elementorFrontend !== 'undefined' && elementorFrontend.createActionHash) {
                                    var ah = elementorFrontend.createActionHash('lightbox', opts);
                                    overlay.setAttribute('data-e-action-hash', ah);
                                }
                            } catch (err) {
                                // ignore if hash can't be created
                            }
                        }
                    }
                });

                // Event delegation: one click handler for the widget — works for clones too
                if (!widgetEl._ct_lightbox_delegated) {
                    widgetEl._ct_lightbox_delegated = true;

                    widgetEl.addEventListener('click', function(e) {
                        var overlay = e.target.closest('.custom-testimonial-video-overlay');
                        if (!overlay) return;

                        // find wrapper from the overlay (closest .custom-testimonial-video-wrapper)
                        var wrapper = overlay.closest('.custom-testimonial-video-wrapper');
                        if (!wrapper) return;

                        // If overlay was set to open inline (not lightbox), just ignore here
                        var isLight = overlay.getAttribute('data-elementor-open-lightbox') === 'yes' || wrapper.getAttribute('data-lightbox') === 'yes';
                        if (!isLight) return;

                        // Build options fresh (in case attributes changed)
                        var opts = buildLightboxOptionsFromWrapper(wrapper);

                        // Prevent default and open via Elementor modal where available
                        e.preventDefault();
                        e.stopPropagation();

                        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.modules && elementorFrontend.modules.lightbox) {
                            try {
                                elementorFrontend.modules.lightbox.openModal(opts);
                            } catch (err) {
                                // fallback: attempt to open as simple window
                                window.open(opts.url, '_blank');
                            }
                        } else {
                            // If Elementor's lightbox isn't available, open the url in a new tab as safe fallback
                            window.open(opts.url, '_blank');
                        }
                    }, true); // use capture true to get it early
                }
            }


            // Ensure Swiper available (Elementor loads Swiper on frontend / editor)
            function readyForSwiper(cb) {
                if (typeof Swiper !== 'undefined') {
                    cb();
                } else if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                    // Elementor provides a wrapper
                    cb();
                } else {
                    setTimeout(function(){ readyForSwiper(cb); }, 60);
                }
            }

            readyForSwiper(function(){
                // Use a unique selector for this widget to avoid collisions
                var swiperContainer = widgetEl.querySelector(selector);
                if (!swiperContainer) return;

                // Build Swiper config
                var swiperConfig = {
                    slidesPerView: 8,
                    spaceBetween: 20,
                    slidesPerGroup: 1, // Scroll 1 item at a time
                    loop: false,
                    speed: 600,
                    watchSlidesProgress: true,
                    watchSlidesVisibility: true,
                    watchOverflow: true,
                    navigation: {
                        nextEl: '#' + widgetId + '-tabs-swiper .swiper-button-next, .' + '<?php echo esc_js($widget_id); ?>' + '-tabs-next',
                        prevEl: '#' + widgetId + '-tabs-swiper .swiper-button-prev, .' + '<?php echo esc_js($widget_id); ?>' + '-tabs-prev'
                    },
                    breakpoints: {
                        // tablet
                        768: {
                            slidesPerView: 8,
                            slidesPerGroup: 1, // Scroll 1 item at a time
                            spaceBetween: 10,
                        },
                        // mobile
                        480: {
                            slidesPerView: 2,
                            slidesPerGroup: 1, // Scroll 1 item at a time
                            spaceBetween: 10,
                        }
                    },
                    on: {
                        init: function(){
                            // ensure correct active state on init (2nd visible)
                            setTimeout(function(){
                                setActiveByVisibleIndex(this.activeIndex || 0);
                            }.bind(this), 30);
                        },
                        slideChange: function(){
                            setActiveByVisibleIndex(this.activeIndex || 0);
                        },
                        resize: function(){
                            setActiveByVisibleIndex(this.activeIndex || 0);
                        }
                    }
                };

                // Instantiate Swiper (works with global Swiper)
                var swiperInstance;
                try {
                    // If elementorFrontend.utils.swiper exists, it will return proper instance
                    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                        swiperInstance = elementorFrontend.utils.swiper(swiperContainer, swiperConfig).swiper || elementorFrontend.utils.swiper(swiperContainer, swiperConfig);
                    } else {
                        swiperInstance = new Swiper(swiperContainer, swiperConfig);
                    }
                    
                    // Get all slides count before updates
                    var allTestimonialSlides = widgetEl.querySelectorAll('.custom-testimonial-tab-item');
                    var totalTestimonials = allTestimonialSlides.length;
                    
                    // Force Swiper to update and recognize all slides
                    if (swiperInstance && typeof swiperInstance.update === 'function') {
                        setTimeout(function() {
                            // Force update to recognize all slides
                            swiperInstance.update();
                            if (typeof swiperInstance.updateSlides === 'function') {
                                swiperInstance.updateSlides();
                            }
                            if (typeof swiperInstance.updateSlidesClasses === 'function') {
                                swiperInstance.updateSlidesClasses();
                            }
                            
                            // Verify slide count
                            var swiperSlidesCount = swiperInstance.slides ? swiperInstance.slides.length : swiperContainer.querySelectorAll('.swiper-slide').length;
                            if (swiperSlidesCount !== totalTestimonials) {
                                console.warn('Swiper initialized with ' + swiperSlidesCount + ' slides, but ' + totalTestimonials + ' testimonials exist. Forcing update...');
                                // Force another update
                                swiperInstance.update();
                                if (typeof swiperInstance.updateSlides === 'function') {
                                    swiperInstance.updateSlides();
                                }
                            }
                        }, 100);
                    }
                } catch (e) {
                    // fallback: do not break widget — keep tab click functionality
                    console.warn('Swiper init failed in custom testimonial:', e);
                    initVideoHandlers(widgetEl);
                    initTabClicks();
                    return;
                }

                // all slides - get all available testimonial tabs
                var slides = widgetEl.querySelectorAll('.custom-testimonial-tab-item');
                var swiperSlides = swiperContainer.querySelectorAll('.swiper-slide');
                
                // Verify all slides are in the DOM
                if (slides.length !== swiperSlides.length) {
                    console.warn('Slide count mismatch: testimonials=' + slides.length + ', swiper-slides=' + swiperSlides.length);
                }
                
                // Ensure all slides are properly recognized by Swiper
                if (swiperInstance && slides.length > 0) {
                    // Force Swiper to re-calculate and recognize all slides
                    setTimeout(function() {
                        // Get all swiper slides from the instance
                        var allSwiperSlides = swiperInstance.slides || swiperContainer.querySelectorAll('.swiper-slide');
                        
                        // Ensure Swiper recognizes all slides
                        if (typeof swiperInstance.update === 'function') {
                            swiperInstance.update();
                        }
                        if (typeof swiperInstance.updateSlides === 'function') {
                            swiperInstance.updateSlides();
                        }
                        if (typeof swiperInstance.updateSlidesClasses === 'function') {
                            swiperInstance.updateSlidesClasses();
                        }
                        if (typeof swiperInstance.updateSize === 'function') {
                            swiperInstance.updateSize();
                        }
                        
                        // Force Swiper to recalculate slide positions
                        if (swiperInstance.params) {
                            // Ensure Swiper can scroll to show all slides
                            var slidesPerView = swiperInstance.params.slidesPerView || 1;
                            var maxSlide = Math.max(0, allSwiperSlides.length - slidesPerView);
                            
                            // Verify Swiper has all slides
                            if (allSwiperSlides.length !== slides.length) {
                                console.warn('Swiper slide count (' + allSwiperSlides.length + ') does not match testimonial count (' + slides.length + ')');
                            }
                        }
                    }, 200);
                    
                    // Additional update after a longer delay to ensure all slides are recognized
                    setTimeout(function() {
                        if (swiperInstance) {
                            if (typeof swiperInstance.update === 'function') {
                                swiperInstance.update();
                            }
                            if (typeof swiperInstance.updateSlides === 'function') {
                                swiperInstance.updateSlides();
                            }
                        }
                    }, 500);
                }

                // Set active item directly by index
                function setActiveByIndex(activeIndex) {
                    // Clamp to valid range
                    if (activeIndex < 0) activeIndex = 0;
                    if (activeIndex >= slides.length) activeIndex = slides.length - 1;

                    // Remove all active classes
                    slides.forEach(function(s){ s.classList.remove('active'); });

                    // Add active to the selected item
                    var activeSlide = slides[activeIndex];
                    if (activeSlide) {
                        activeSlide.classList.add('active');
                    }

                    // Sync testimonial content to the active index
                    switchTestimonial(activeIndex);
                }

                // Set active based on visible index (for automatic updates during scroll)
                function setActiveByVisibleIndex(visibleStart) {
                    var firstVisible = parseInt(visibleStart, 10) || 0;
                    var slidesPerView = swiperInstance.params && swiperInstance.params.slidesPerView ? Math.floor(swiperInstance.params.slidesPerView) : 8;
                    
                    // Calculate which item should be active (prefer second visible)
                    var activeIndex = firstVisible + 1;
                    
                    // Clamp to valid range
                    if (activeIndex < 0) activeIndex = 0;
                    if (activeIndex >= slides.length) activeIndex = slides.length - 1;

                    setActiveByIndex(activeIndex);
                }

                // helper to init tab click handlers (in case Swiper fails or editor needs it)
                function initTabClicks() {
                    var tabItems = widgetEl.querySelectorAll('.custom-testimonial-tab-item');
                    tabItems.forEach(function(tab, index) {
                        // Check if already has event listener to avoid duplicates
                        if (tab._ct_click_handler) return;
                        tab._ct_click_handler = true;
                        
                        tab.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            var idx = parseInt(this.getAttribute('data-index') || index, 10);
                            
                            // Directly activate the clicked item
                            setActiveByIndex(idx);
                            
                            // Scroll to show the clicked item (center it if possible)
                            if (swiperInstance && typeof swiperInstance.slideTo === 'function') {
                                var slidesPerView = swiperInstance.params && swiperInstance.params.slidesPerView ? Math.floor(swiperInstance.params.slidesPerView) : 8;
                                
                                // Calculate target slide position to center the clicked item
                                var targetSlide = idx - Math.floor(slidesPerView / 2) + 1;
                                
                                // Clamp targetSlide
                                if (targetSlide < 0) targetSlide = 0;
                                var maxSlide = Math.max(0, slides.length - slidesPerView);
                                if (targetSlide > maxSlide) targetSlide = maxSlide;
                                
                                swiperInstance.slideTo(targetSlide);
                            } else {
                                // Fallback if Swiper not available
                                switchTestimonial(idx);
                            }
                        });
                    });
                }

                // When clicking a slide, make it active and scroll to show it
                slides.forEach(function(slide, idx){
                    slide.addEventListener('click', function(e){
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Get the real index
                        var realIndex = parseInt(slide.getAttribute('data-index') || idx, 10);
                        
                        // Directly activate the clicked item
                        setActiveByIndex(realIndex);
                        
                        // Scroll to show the clicked item (center it if possible)
                        if (typeof swiperInstance.slideTo === 'function') {
                            var slidesPerView = swiperInstance.params && swiperInstance.params.slidesPerView ? Math.floor(swiperInstance.params.slidesPerView) : 8;
                            
                            // Calculate target slide position to center the clicked item
                            var targetSlide = realIndex - Math.floor(slidesPerView / 2) + 1;
                            
                            // Clamp targetSlide
                            if (targetSlide < 0) targetSlide = 0;
                            var maxSlide = Math.max(0, slides.length - slidesPerView);
                            if (targetSlide > maxSlide) targetSlide = maxSlide;
                            
                            swiperInstance.slideTo(targetSlide);
                        }
                    });
                });

                // Initialize video handlers and tab click fallback
                initVideoHandlers(widgetEl);
                initTabClicks();

            }); // readyForSwiper
            // Elementor editor redraw hook — ensure it re-inits in editor
            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction('frontend/element_ready/<?php echo esc_js($this->get_name()); ?>.default', function(scope){
                    try {
                        var el = document.getElementById('<?php echo esc_js($widget_id); ?>');
                        if (el) {
                            // re-init video handlers and show correct 2nd item
                            initVideoHandlers(el);
                            // small timeout for editor rendering
                            setTimeout(function(){
                                var container = el.querySelector('#<?php echo esc_js($widget_id); ?>-tabs-swiper');
                                if (container && typeof elementorFrontend.utils !== 'undefined' && elementorFrontend.utils.swiper) {
                                    elementorFrontend.utils.swiper(container, {}).swiper && elementorFrontend.utils.swiper(container, {}).swiper.update && elementorFrontend.utils.swiper(container, {}).swiper.update();
                                }
                            }, 120);
                        }
                    } catch(err){}
                });
            }
        })();
        </script>
    </div>
<?php
    }

}

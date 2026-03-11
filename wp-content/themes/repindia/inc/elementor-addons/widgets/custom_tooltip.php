<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Custom_Tooltip extends Widget_Base
{
    /**
     * Custom sanitization function that allows class attributes
     */
    private function sanitize_wysiwyg_content($content)
    {
        if (empty($content)) {
            return '';
        }

        // Allow common HTML tags with class attributes
        $allowed_html = wp_kses_allowed_html('post');

        // Ensure span tags can have class attribute
        if (isset($allowed_html['span'])) {
            $allowed_html['span']['class'] = true;
        } else {
            $allowed_html['span'] = array('class' => true);
        }

        // Allow other common attributes on various tags
        $allowed_html['div']['class'] = true;
        $allowed_html['p']['class'] = true;
        $allowed_html['strong']['class'] = true;
        $allowed_html['em']['class'] = true;
        $allowed_html['b']['class'] = true;
        $allowed_html['i']['class'] = true;
        $allowed_html['a']['class'] = true;
        $allowed_html['h1']['class'] = true;
        $allowed_html['h2']['class'] = true;
        $allowed_html['h3']['class'] = true;
        $allowed_html['h4']['class'] = true;
        $allowed_html['h5']['class'] = true;
        $allowed_html['h6']['class'] = true;
        $allowed_html['ul']['class'] = true;
        $allowed_html['ol']['class'] = true;
        $allowed_html['li']['class'] = true;

        return wp_kses($content, $allowed_html);
    }
    public function get_name()
    {
        return 'custom_tooltip';
    }
    public function get_title()
    {
        return 'Custom Tooltip';
    }
    public function get_icon()
    {
        return 'fa fa-th';
    }
    public function get_category()
    {
        return ['general'];
    }

    protected function register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Content',
            ]
        );

        // Title + Icon
        $this->add_control(
            'title_text',
            [
                'label' => esc_html__('Title Text', 'repindia'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Hover me', 'repindia'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'pre_content',
            [
                'label' => esc_html__('Pre-content', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'description' => esc_html__('Content displayed before Title Text (inside same trigger)', 'repindia'),
            ]
        );

        $this->add_control(
            'after_content',
            [
                'label' => esc_html__('After-content', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'description' => esc_html__('Content displayed after Title Text (inside same trigger)', 'repindia'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'repindia'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-info-circle',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'icon_dark',
            [
                'label' => esc_html__('Icon (Dark Mode)', 'repindia'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-info-circle',
                    'library' => 'fa-solid',
                ],
                'description' => esc_html__('Icon to display when dark mode is active (body has js-dark class)', 'repindia'),
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' => esc_html__('Show Icon', 'repindia'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'repindia'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__('Left', 'repindia'),
                    'right' => esc_html__('Right', 'repindia'),
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_align',
            [
                'label' => esc_html__('Title Alignment', 'repindia'),
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
                'default' => 'left',
                'toggle' => true,
            ]
        );

        // Tooltip Description
        $this->add_control(
            'tooltip_description',
            [
                'label' => esc_html__('Tooltip Description', 'repindia'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('This is a tooltip description. You can add formatted text here.', 'repindia'),
                'placeholder' => esc_html__('Enter tooltip description', 'repindia'),
            ]
        );

        // Trigger Options
        $this->add_control(
            'trigger_type',
            [
                'label' => esc_html__('Trigger Type', 'repindia'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'hover',
                'options' => [
                    'hover' => esc_html__('Hover', 'repindia'),
                    'click' => esc_html__('Click', 'repindia'),
                ],
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => esc_html__('Position', 'repindia'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__('Top', 'repindia'),
                    'bottom' => esc_html__('Bottom', 'repindia'),
                    'left' => esc_html__('Left', 'repindia'),
                    'right' => esc_html__('Right', 'repindia'),
                ],
            ]
        );

        // Learn More Button
        $this->add_control(
            'show_learn_more',
            [
                'label' => esc_html__('Show Learn More Button', 'repindia'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'learn_more_text',
            [
                'label' => esc_html__('Learn More Button Text', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Learn more', 'repindia'),
                'condition' => [
                    'show_learn_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'popup_content',
            [
                'label' => esc_html__('Popup Content', 'repindia'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '',
                'condition' => [
                    'show_learn_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'popup_image',
            [
                'label' => esc_html__('Popup Image', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'show_learn_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'popup_image_dark',
            [
                'label' => esc_html__('Popup Image (Dark Theme)', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'show_learn_more' => 'yes',
                ],
                'description' => esc_html__('Image displayed in popup when dark mode is active (body has js-dark class). Falls back to Popup Image if empty.', 'repindia'),
            ]
        );

        $this->add_control(
            'show_popup_icon',
            [
                'label' => esc_html__('Show Popup Icon/Image', 'repindia'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_learn_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section: Tooltip Box
        $this->start_controls_section(
            'section_style_tooltip',
            [
                'label' => esc_html__('Tooltip Box', 'repindia'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tooltip_background_color',
            [
                'label' => esc_html__('Background Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ctw-tooltip-inner' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tooltip_text_color',
            [
                'label' => esc_html__('Text Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ctw-tooltip-inner' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ctw-tooltip-inner p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ctw-tooltip-inner *' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tooltip_padding',
            [
                'label' => esc_html__('Padding', 'repindia'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '12',
                    'right' => '16',
                    'bottom' => '12',
                    'left' => '16',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-tooltip-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tooltip_border_radius',
            [
                'label' => esc_html__('Border Radius', 'repindia'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '4',
                    'right' => '4',
                    'bottom' => '4',
                    'left' => '4',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-tooltip-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tooltip_box_shadow',
                'label' => esc_html__('Box Shadow', 'repindia'),
                'selector' => '{{WRAPPER}} .ctw-tooltip-inner',
            ]
        );

        $this->add_control(
            'tooltip_max_width',
            [
                'label' => esc_html__('Max Width', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 5,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-tooltip' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tooltip_description_typography',
                'label' => esc_html__('Description Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .ctw-tooltip-inner p, {{WRAPPER}} .ctw-tooltip-inner div, {{WRAPPER}} .ctw-tooltip-inner span, {{WRAPPER}} .ctw-tooltip-inner li, {{WRAPPER}} .ctw-tooltip-inner a, {{WRAPPER}} .ctw-tooltip-inner strong, {{WRAPPER}} .ctw-tooltip-inner em, {{WRAPPER}} .ctw-tooltip-inner h1, {{WRAPPER}} .ctw-tooltip-inner h2, {{WRAPPER}} .ctw-tooltip-inner h3, {{WRAPPER}} .ctw-tooltip-inner h4, {{WRAPPER}} .ctw-tooltip-inner h5, {{WRAPPER}} .ctw-tooltip-inner h6',
            ]
        );

        $this->end_controls_section();

        // Style Section: Title
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'repindia'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .ctw-title .ctw-text',
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Text Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ctw-title .ctw-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ctw-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ctw-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ctw-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ctw-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ctw-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-title.ctw-icon-left .ctw-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ctw-title.ctw-icon-right .ctw-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section: Wrapper / Trigger
        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => esc_html__('Wrapper / Trigger', 'repindia'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'cursor_type',
            [
                'label' => esc_html__('Cursor Type', 'repindia'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'pointer',
                'options' => [
                    'pointer' => esc_html__('Pointer', 'repindia'),
                    'default' => esc_html__('Default', 'repindia'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-trigger' => 'cursor: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'transition_duration',
            [
                'label' => esc_html__('Transition Duration (ms)', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 250,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-tooltip' => 'transition: opacity {{SIZE}}ms ease, visibility {{SIZE}}ms ease;',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section: Learn More Button
        $this->start_controls_section(
            'section_style_learn_more',
            [
                'label' => esc_html__('Learn More Button', 'repindia'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_learn_more' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'learn_more_typography',
                'label' => esc_html__('Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .ctw-learn-more-btn',
            ]
        );

        $this->add_control(
            'learn_more_text_color',
            [
                'label' => esc_html__('Text Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ctw-learn-more-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'learn_more_background_color',
            [
                'label' => esc_html__('Background Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0073aa',
                'selectors' => [
                    '{{WRAPPER}} .ctw-learn-more-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'learn_more_padding',
            [
                'label' => esc_html__('Padding', 'repindia'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '6',
                    'right' => '14',
                    'bottom' => '6',
                    'left' => '14',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-learn-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'learn_more_border_radius',
            [
                'label' => esc_html__('Border Radius', 'repindia'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '6',
                    'right' => '6',
                    'bottom' => '6',
                    'left' => '6',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-learn-more-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section: Popup Icon/Image
        $this->start_controls_section(
            'section_style_popup_icon',
            [
                'label' => esc_html__('Popup Icon/Image', 'repindia'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_learn_more' => 'yes',
                    'show_popup_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'popup_icon_size',
            [
                'label' => esc_html__('Icon Size', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-popup-icon-wrapper .ctw-popup-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ctw-popup-icon-wrapper .ctw-popup-icon img' => 'width: {{SIZE}}{{UNIT}}; height: auto; max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'popup_icon_color',
            [
                'label' => esc_html__('Icon Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0073aa',
                'selectors' => [
                    '{{WRAPPER}} .ctw-popup-icon-wrapper .ctw-popup-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ctw-popup-icon-wrapper .ctw-popup-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'popup_icon_spacing',
            [
                'label' => esc_html__('Spacing', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ctw-popup-content-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // Php Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $trigger_type = !empty($settings['trigger_type']) ? esc_attr($settings['trigger_type']) : 'hover';
        $position = !empty($settings['position']) ? esc_attr($settings['position']) : 'top';
        $title_text = !empty($settings['title_text']) ? $settings['title_text'] : '';
        $pre_content = !empty($settings['pre_content']) ? $settings['pre_content'] : '';
        $after_content = !empty($settings['after_content']) ? $settings['after_content'] : '';
        $show_icon = !empty($settings['show_icon']) && $settings['show_icon'] === 'yes';
        $icon_position = !empty($settings['icon_position']) ? esc_attr($settings['icon_position']) : 'left';
        $title_align = !empty($settings['title_align']) ? esc_attr($settings['title_align']) : 'left';
        $tooltip_description = !empty($settings['tooltip_description']) ? $settings['tooltip_description'] : '';
        $tooltip_bg_color = !empty($settings['tooltip_background_color']) ? esc_attr($settings['tooltip_background_color']) : '#333333';
        $show_learn_more = !empty($settings['show_learn_more']) && $settings['show_learn_more'] === 'yes';
        $icon_dark = !empty($settings['icon_dark']) ? $settings['icon_dark'] : (!empty($settings['icon']) ? $settings['icon'] : []);
        $learn_more_text = !empty($settings['learn_more_text']) ? esc_html($settings['learn_more_text']) : 'Learn more';
        $popup_content = !empty($settings['popup_content']) ? $settings['popup_content'] : '';
        $show_popup_icon = !empty($settings['show_popup_icon']) && $settings['show_popup_icon'] === 'yes';
        $popup_image = !empty($settings['popup_image']) && isset($settings['popup_image']['url']) && !empty($settings['popup_image']['url']) ? $settings['popup_image'] : null;
        $popup_image_dark = !empty($settings['popup_image_dark']) && isset($settings['popup_image_dark']['url']) && !empty($settings['popup_image_dark']['url']) ? $settings['popup_image_dark'] : null;

        // Add inline CSS only once per page
        static $css_added = false;
        if (!$css_added) {
            $css_added = true;
            echo '<style id="custom-tooltip-css">';
            echo '.ctw-wrapper { position: relative; display:flex;width: 100%;text-align: left;}';
            echo '.ctw-trigger { cursor: pointer; display: inline-flex; align-items: center; }';
            echo '.ctw-title { display: inline-flex; align-items: center;}';
            echo '.ctw-title .border-b {border-bottom: 2px solid #D7DBE4; }';
            echo '.default_darktool .ctw-title .border-b { border-bottom: 2px solid #D7DBE4; }';
            echo '.ctw-icon { display: inline-flex; align-items: center; justify-content: center; }';
            echo '.ctw-text { display: inline-block; }';
            echo '.ctw-tooltip { position: absolute; opacity: 0; visibility: hidden; transition: opacity 0.25s; z-index: 9999; pointer-events: none;min-width: 250px;width: 100%; }';
            echo '.ctw-tooltip.show { opacity: 1; visibility: visible; pointer-events: auto; }';
            echo '.ctw-tooltip-inner { position: relative; word-wrap: break-word;white-space: normal; }';
            echo '.ctw-tooltip-top { bottom: 100%; left: 50%; transform: translateX(-50%); margin-bottom: 8px; }';
            echo '.ctw-tooltip-top .ctw-tooltip-inner::after { content: ""; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); border: 6px solid transparent; border-top-color: var(--ctw-arrow-color, #333333); }';
            echo '.ctw-tooltip-bottom { top: 26px; left: 50%; transform: translateX(-50%); margin-top: 0px; }';
            // echo '.ctw-tooltip-bottom .ctw-tooltip-inner::after { content: ""; position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%); border: 6px solid transparent; border-bottom-color: var(--ctw-arrow-color, #333333); }';
            echo '.ctw-tooltip-left { right: 100%; top: 50%; transform: translateY(-50%); margin-right: 8px; }';
            echo '.ctw-tooltip-left .ctw-tooltip-inner::after { content: ""; position: absolute; left: 100%; top: 50%; transform: translateY(-50%); border: 6px solid transparent; border-left-color: var(--ctw-arrow-color, #333333); }';
            echo '.ctw-tooltip-right { left: 100%; top: 50%; transform: translateY(-50%); margin-left: 8px; }';
            echo '.ctw-tooltip-right .ctw-tooltip-inner::after { content: ""; position: absolute; right: 100%; top: 50%; transform: translateY(-50%); border: 6px solid transparent; border-right-color: var(--ctw-arrow-color, #333333); }';
            echo '.ctw-tooltip-inner p{ margin: 0;}';
            echo '.ctw-tooltip-inner b,.ctw-tooltip-inner strong{ font-weight: bold!important;}';
            echo '.ctw-popup-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.55); z-index: 99997; }';
            echo '.ctw-popup-box { position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); background: #ffffff; padding: 20px; max-width: 600px; width: 90%; border-radius: 12px; z-index: 99998;box-shadow: 0 0 15px 0 rgba(138, 149, 158, 0.40);white-space: normal; }';
            echo '.ctw-popup-close { position: absolute; top: 12px; right: 12px; cursor: pointer; 
    font-size: 28px;
    width: 28px;
    height: 28px;
    border-radius: 100%;
    text-align: center;}';
            echo '.ctw-learn-more-btn {padding: 0 !important;font-size: 16px !important;border-color: #E6EBF2; font-weight: 600 !important;border-radius: 0 !important;margin-top: 0.5rem;}';
            echo '.ctw-popup-content-wrapper { display: flex; align-items: flex-start; gap: 20px;padding-right: 20px; }';
            echo '.ctw-popup-icon-wrapper { flex-shrink: 0; display: flex; align-items: center; justify-content: center; }';
            echo '.ctw-popup-icon-wrapper .ctw-popup-icon { font-size: 24px; color: #0073aa;max-width: 40px;max-height: 40px; }';
            echo '.ctw-popup-icon-wrapper .ctw-popup-icon img,.ctw-popup-icon-wrapper .ctw-popup-icon svg { max-width: 40px; height: 40px; display: block; }';
            echo '.ctw-popup-content-text { flex: 1; }';
            echo '.ctw-wrapper:not(.ctw-has-learn-more) .ctw-tooltip-inner { background-color: #ffffff !important; color: #333333 !important; }';
            echo '.ctw-wrapper:not(.ctw-has-learn-more) .ctw-tooltip-inner p { color: #333333 !important; }';
            echo '.ctw-wrapper:not(.ctw-has-learn-more) .ctw-tooltip-inner * { color: #333333 !important; }';
            echo '.ctw-wrapper:not(.ctw-has-learn-more) .ctw-tooltip-top .ctw-tooltip-inner::after { border-top-color: #ffffff !important; }';
            // echo '.ctw-wrapper:not(.ctw-has-learn-more) .ctw-tooltip-bottom .ctw-tooltip-inner::after { border-bottom-color: #ffffff !important; }';
            echo '.ctw-wrapper:not(.ctw-has-learn-more) .ctw-tooltip-left .ctw-tooltip-inner::after { border-left-color: #ffffff !important; }';
            echo '.ctw-wrapper:not(.ctw-has-learn-more) .ctw-tooltip-right .ctw-tooltip-inner::after { border-right-color: #ffffff !important; }';
            echo '.ctw-icon-dark { display: none; }';
            echo 'body.js-dark .ctw-icon-light { display: none; }';
            echo 'body.js-dark .ctw-icon-dark { display: inline-flex; }';
            echo '.ctw-popup-icon-dark { display: none; }';
            echo 'body.js-dark .ctw-popup-icon-light { display: none; }';
            echo 'body.js-dark .ctw-popup-icon-dark { display: flex; align-items: center; justify-content: center; }';
            echo '</style>';
        }

        // Add inline JS only once per page
        static $js_added = false;
        if (!$js_added) {
            $js_added = true;
            echo '<script id="custom-tooltip-js">';
            echo '(function() {';
            echo 'function initCustomTooltips() {';
            echo 'if (typeof jQuery === "undefined") return;';
            echo 'var $ = jQuery;';
            echo 'function positionTooltipByTrigger($wrapper) {';
            echo 'var $tooltip = $wrapper.find(".ctw-tooltip");';
            echo 'var $textTrigger = $wrapper.find(".ctw-text .ctw-trigger");';
            echo 'if (!$textTrigger.length) $textTrigger = $wrapper.find(".ctw-trigger").first();';
            echo 'var wrapper = $wrapper[0], tooltip = $tooltip[0], trigger = $textTrigger[0];';
            echo 'if (!wrapper || !tooltip || !trigger) return;';
            echo 'var wr = wrapper.getBoundingClientRect(), tr = trigger.getBoundingClientRect();';
            echo 'var pos = $wrapper.data("position") || "bottom";';
            echo 'var centerX = tr.left - wr.left + (tr.width / 2);';
            echo 'var centerY = tr.top - wr.top + (tr.height / 2);';
            echo 'var css = { right: "auto", bottom: "auto" };';
            echo 'if (pos === "bottom") { css.left = centerX + "px"; css.top = (tr.bottom - wr.top + 8) + "px"; css.transform = "translateX(-50%)"; css.marginTop = "0"; }';
            echo 'else if (pos === "top") { css.left = centerX + "px"; css.bottom = (wr.bottom - tr.top + 8) + "px"; css.top = "auto"; css.transform = "translateX(-50%)"; css.marginBottom = "0"; }';
            echo 'else if (pos === "left") { css.right = (wr.right - tr.left + 8) + "px"; css.top = centerY + "px"; css.left = "auto"; css.transform = "translateY(-50%)"; }';
            echo 'else if (pos === "right") { css.left = (tr.right - wr.left + 8) + "px"; css.top = centerY + "px"; css.transform = "translateY(-50%)"; }';
            echo '$tooltip.css(css);';
            echo '}';
            echo '$(".ctw-wrapper").each(function() {';
            echo 'var $wrapper = $(this);';
            echo 'var triggerType = $wrapper.data("trigger") || "hover";';
            echo 'var $tooltip = $wrapper.find(".ctw-tooltip");';
            echo 'var $trigger = $wrapper.find(".ctw-trigger");';
            echo '$trigger.off("mouseenter mouseleave click");';
            echo '$(document).off("click.ctw-" + $wrapper.index());';
            echo 'if (triggerType === "hover") {';
            echo '$trigger.on("mouseenter", function() { positionTooltipByTrigger($wrapper); $tooltip.addClass("show"); });';
            echo '$trigger.on("mouseleave", function() { $tooltip.removeClass("show"); });';
            echo '$tooltip.on("mouseenter", function() { $(this).addClass("show"); });';
            echo '$tooltip.on("mouseleave", function() { $(this).removeClass("show"); });';
            echo '} else if (triggerType === "click") {';
            echo '$trigger.on("click", function(e) { e.stopPropagation(); positionTooltipByTrigger($wrapper); $tooltip.toggleClass("show"); });';
            echo '$(document).on("click.ctw-outside-" + $wrapper.index(), function(e) {';
            echo 'if ($tooltip.hasClass("show")) {';
            echo 'if (!$wrapper.is(e.target) && !$wrapper.has(e.target).length) {';
            echo '$tooltip.removeClass("show");';
            echo '}';
            echo '}';
            echo '});';
            echo '}';
            echo '});';
            echo '}';
            echo 'function hideTooltipsOnScroll() {';
            echo 'if (typeof jQuery === "undefined") return;';
            echo 'var $ = jQuery;';
            echo '$(window).on("scroll.ctw-hide-tooltips", function() {';
            echo '$(".ctw-tooltip.show, .ctw-tooltip-bottom.show, .moretooldiv.show").removeClass("show");';
            echo '});';
            echo '}';
            echo 'function runWhenJQueryReady() {';
            echo 'if (typeof jQuery !== "undefined") {';
            echo 'jQuery(document).ready(function() { initCustomTooltips(); hideTooltipsOnScroll(); });';
            echo 'jQuery(window).on("elementor/frontend/init", function() { initCustomTooltips(); hideTooltipsOnScroll(); });';
            echo '} else {';
            echo 'setTimeout(runWhenJQueryReady, 100);';
            echo '}';
            echo '}';
            echo 'runWhenJQueryReady();';
            echo '})();';
            echo '</script>';
        }

        // Add inline JS for popup only once per page
        static $popup_js_added = false;
        if (!$popup_js_added) {
            $popup_js_added = true;
            echo '<script id="custom-tooltip-popup-js">';
            echo '(function() {';
            echo 'function initCustomTooltipPopup() {';
            echo 'if (typeof jQuery === "undefined") return;';
            echo 'var $ = jQuery;';
            echo '$(".ctw-learn-more-btn").off("click.ctw-popup").on("click.ctw-popup", function(e) {';
            echo 'e.preventDefault();';
            echo 'e.stopPropagation();';
            echo 'var $btn = $(this);';
            echo 'var $wrapper = $btn.closest(".ctw-wrapper");';
            echo 'var $overlay = $wrapper.siblings(".ctw-popup-overlay").first();';
            echo 'var $popup = $wrapper.siblings(".ctw-popup-box").first();';
            echo 'if ($overlay.length && $popup.length) {';
            echo '$overlay.fadeIn(200);';
            echo '$popup.fadeIn(200);';
            echo '$wrapper.find(".ctw-tooltip").removeClass("show");';
            echo '}';
            echo '});';
            echo '$(".ctw-popup-overlay, .ctw-popup-close").off("click.ctw-popup").on("click.ctw-popup", function() {';
            echo '$(".ctw-popup-overlay").fadeOut(200);';
            echo '$(".ctw-popup-box").fadeOut(200);';
            echo '});';
            echo '}';
            echo 'function runPopupWhenJQueryReady() {';
            echo 'if (typeof jQuery !== "undefined") {';
            echo 'jQuery(document).ready(function() { initCustomTooltipPopup(); });';
            echo 'jQuery(window).on("elementor/frontend/init", function() { initCustomTooltipPopup(); });';
            echo '} else {';
            echo 'setTimeout(runPopupWhenJQueryReady, 100);';
            echo '}';
            echo '}';
            echo 'runPopupWhenJQueryReady();';
            echo '})();';
            echo '</script>';
        }
        ?>
        <style>
            span.ctw-text p {
                margin: 0;
            }

            .ctw-tooltip-inner {
                text-align: left;
            }

            .ctw-tooltip-inner p {
                font-size: 14px;
                font-weight: 400;
                line-height: 20px;
            }

            /* button.ctw-learn-more-btn{ box-shadow: none!important;border: none;border-bottom: 1px solid rgba(255, 255, 255, 0.20); } */
            .ctw-title .ctw-text p {
                font-size: 16px;
                line-height: 26px;
                color: #5C5C5C;
            }
            .ctw-popup-close:hover {
  background: #e6ebf2;
}
.ctw-popup-close:focus {
  background: #e6ebf2;
  border: 1px solid #d7dbe4;
  outline: 0;
}

.js-dark .ctw-popup-close:hover {
  background: #ffffff1a;
  color: #d7dbe4;
}
.js-dark .ctw-popup-box {
  background: #262A30;
}
            .tooltiptitlebox .ctw-title .ctw-text p {
                color: #06283D;
                font-size: 20px;
                font-weight: 500;
            }

            .toptooltitle .ctw-title .ctw-text p {
                font-size: 14px;
                color: #262A30;
                font-weight: 500;
            }

            .para_tooltip .ctw-title .ctw-text p {
                font-size: 16px;
            }

            .tooltip_leftpara .para_tooltip .ctw-title .ctw-text p {
                font-size: 18px;
            }

            .ctw-title:hover .border-b {
                border-bottom: 2px solid #9ea1a8 !important;
            }

            .group_tooltip .ctw-title .ctw-text p {
                font-weight: 500;
                font-size: 16px;
            }

            .js-dark .ctw-title:hover .border-b {
                border-bottom: 2px solid #7d8895 !important;
            }

            /* .js-dark .ctw-has-learn-more .ctw-title .border-b, .js-dark .ctw-title span.ctw-text,.js-dark .tooltiptitlebox .ctw-has-learn-more .ctw-title .border-b, .js-dark .tooltiptitlebox .ctw-title span.ctw-text {
                                                                border-bottom: 2px solid #464a4f !important;
                                                                color: #aeb6c9!important;
                                                            } */
            .js-dark .border-b {
                border-bottom: 2px solid #464a4f !important;
                color: #aeb6c9 !important;
            }

            .js-dark .ctw-title p .border-b {
                color: #aeb6c9 !important;
                border-bottom: 2px solid #464a4f !important;
            }

            .js-dark .ctw-tooltip-inner {
                background-color: #262a30 !important;
            }

            .js-dark .ctw-tooltip-inner p strong {
                color: rgb(255 255 255 / 90%) !important;
            }

            .js-dark #center_mobileviiew .ctw-wrapper.ctw-has-learn-more .border-b,
            .js-dark #center_mobileviiew .ctw-title p .border-b {
                color: #ffffff !important;
            }
            .js-dark .tooltiptitlebox .ctw-title .ctw-text p,
            .js-dark .tooltiptitlebox .ctw-title .ctw-text p .border-b {color: #ffff !important;}   
            .defaultdark_paratool span.ctw-title.ctw-icon-left .ctw-text, 
            .defaultdark_paratool span.ctw-title.ctw-icon-left .ctw-text p {color: #AEB6C9 !important;font-size: 16px;}
            @media(max-width: 1400px) and (min-width: 1025px){
                .ctw-tooltip-bottom { top: 100%; }
            }
            @media (max-width: 768px) {
                .ctw-tooltip-bottom {
                    top: 0% !important;
                    left: auto !important;
                    right: auto !important;
                    transform: translate(0%, 0%) !important;
                    margin-top: 30px !important;
                    z-index: 2 !important;
                    position: absolute !important;
                }
                .toptooltitle .ctw-tooltip-bottom {
                    left: 50% !important;
                    right: auto !important;
                    top: 28% !important;
                    transform: translate(-50%, -50%) !important;
                    max-width: 360px !important;
                    position: fixed !important;
                }
                #center_mobileviiew .ctw-wrapper.ctw-has-learn-more {
                    justify-content: center;
                }
                #center_mobileviiew .card_title_tooltip .ctw-title .ctw-text p {
                    font-size: 20px;
                }

            }
            @media(max-width: 600px){
                .ctw-title{ text-align: left!important; }
                .ctw-wrapper{ justify-content: start!important; }
                #center_mobileviiew .ctw-title{ text-align: center!important; }
                #center_mobileviiew .ctw-wrapper{ justify-content: center!important; }
            }

            @media (max-width: 380px) {
                .toptooltitle .ctw-tooltip-bottom {
                    top: 38% !important;
                }
            }



        </style>

        <div class="ctw-wrapper <?php echo $show_learn_more ? 'ctw-has-learn-more' : ''; ?>"
            data-trigger="<?php echo $trigger_type; ?>" data-position="<?php echo $position; ?>"
            style="--ctw-arrow-color: <?php echo $show_learn_more ? $tooltip_bg_color : '#ffffff'; ?>;">
            <div class="">
                <span class="ctw-title ctw-icon-<?php echo $icon_position; ?>" style="text-align: <?php echo $title_align; ?>;">
                    <?php if ($show_icon && $icon_position === 'left'): ?>
                        <?php if (!empty($settings['icon'])): ?>
                            <span class="ctw-trigger ctw-icon ctw-icon-light">
                                <?php
                                \Elementor\Icons_Manager::render_icon($settings['icon'], [
                                    'aria-hidden' => 'true',
                                ]);
                                ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($icon_dark)): ?>
                            <span class="ctw-trigger ctw-icon ctw-icon-dark">
                                <?php
                                \Elementor\Icons_Manager::render_icon($icon_dark, [
                                    'aria-hidden' => 'true',
                                ]);
                                ?>
                            </span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <span class="ctw-text"><?php echo $pre_content; ?> <span class="ctw-trigger"><?php echo $this->sanitize_wysiwyg_content($title_text); ?></span> <?php echo $after_content; ?></span>
                    <?php if ($show_icon && $icon_position === 'right'): ?>
                        <?php if (!empty($settings['icon'])): ?>
                            <span class="ctw-trigger ctw-icon ctw-icon-light">
                                <?php
                                \Elementor\Icons_Manager::render_icon($settings['icon'], [
                                    'aria-hidden' => 'true',
                                ]);
                                ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($icon_dark)): ?>
                            <span class="ctw-trigger ctw-icon ctw-icon-dark">
                                <?php
                                \Elementor\Icons_Manager::render_icon($icon_dark, [
                                    'aria-hidden' => 'true',
                                ]);
                                ?>
                            </span>
                        <?php endif; ?>
                    <?php endif; ?>
                </span>

            </div>
            <div class="ctw-tooltip ctw-tooltip-<?php echo $position; ?> <?php if ($show_learn_more == 'yes') {
                    echo $showclass = 'moretooldiv';
                } else {
                    echo $showclass = '';
                } ?>">
                <div class="ctw-tooltip-inner">
                    <?php echo $this->sanitize_wysiwyg_content($tooltip_description); ?>
                    <?php if ($show_learn_more): ?>
                        <?php if (!empty($learn_more_text)) { ?>
                            <a href="javascript:void(0);"
                                class="ctw-learn-more-btn theme-btn bg-trans border_btnlight"><?php echo $learn_more_text; ?></a>
                        <?php } ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <?php if ($show_learn_more): ?>
            <div class="ctw-popup-overlay" style="display:none;"></div>
            <div class="ctw-popup-box" style="display:none;">
                <div class="ctw-popup-close">&times;</div>
                <div class="ctw-popup-content-wrapper">
                    <?php if ($show_popup_icon): ?>
                        <?php
                        $popup_image_light = $popup_image;
                        $popup_image_dark_final = $popup_image_dark ? $popup_image_dark : $popup_image;
                        ?>
                        <?php if ($popup_image_light || $popup_image_dark_final): ?>
                            <div class="ctw-popup-icon-wrapper">
                                <?php if ($popup_image_light): ?>
                                    <span class="ctw-popup-icon ctw-popup-icon-light">
                                        <img src="<?php echo esc_url($popup_image_light['url']); ?>"
                                            alt="<?php echo esc_attr(!empty($popup_image_light['alt']) ? $popup_image_light['alt'] : ''); ?>"
                                            class="ctw-popup-icon" />
                                    </span>
                                <?php endif; ?>
                                <?php if ($popup_image_dark_final): ?>
                                    <span class="ctw-popup-icon ctw-popup-icon-dark">
                                        <img src="<?php echo esc_url($popup_image_dark_final['url']); ?>"
                                            alt="<?php echo esc_attr(!empty($popup_image_dark_final['alt']) ? $popup_image_dark_final['alt'] : ''); ?>"
                                            class="ctw-popup-icon" />
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="ctw-popup-content-text">
                        <?php echo $this->sanitize_wysiwyg_content($popup_content); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
    }
}



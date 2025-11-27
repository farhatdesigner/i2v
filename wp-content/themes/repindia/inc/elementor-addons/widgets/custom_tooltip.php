<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Custom_Tooltip extends Widget_Base
{
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
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Hover me', 'repindia'),
                'label_block' => true,
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
    }

    // Php Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        $trigger_type = !empty($settings['trigger_type']) ? esc_attr($settings['trigger_type']) : 'hover';
        $position = !empty($settings['position']) ? esc_attr($settings['position']) : 'top';
        $title_text = !empty($settings['title_text']) ? esc_html($settings['title_text']) : '';
        $show_icon = !empty($settings['show_icon']) && $settings['show_icon'] === 'yes';
        $icon_position = !empty($settings['icon_position']) ? esc_attr($settings['icon_position']) : 'left';
        $title_align = !empty($settings['title_align']) ? esc_attr($settings['title_align']) : 'left';
        $tooltip_description = !empty($settings['tooltip_description']) ? $settings['tooltip_description'] : '';
        $tooltip_bg_color = !empty($settings['tooltip_background_color']) ? esc_attr($settings['tooltip_background_color']) : '#333333';
        $show_learn_more = !empty($settings['show_learn_more']) && $settings['show_learn_more'] === 'yes';
        $learn_more_text = !empty($settings['learn_more_text']) ? esc_html($settings['learn_more_text']) : 'Learn more';
        $popup_content = !empty($settings['popup_content']) ? $settings['popup_content'] : '';

        // Add inline CSS only once per page
        static $css_added = false;
        if (!$css_added) {
            $css_added = true;
            echo '<style id="custom-tooltip-css">';
            echo '.ctw-wrapper { position: relative; display: inline-block;width: 100%;text-align: center;vertical-align: sub; }';
            echo '.ctw-trigger { cursor: pointer; display: inline-flex; align-items: center; }';
            echo '.ctw-title { display: inline-flex; align-items: center; }';
            echo '.ctw-icon { display: inline-flex; align-items: center; justify-content: center; }';
            echo '.ctw-text { display: inline-block; }';
            echo '.ctw-tooltip { position: absolute; opacity: 0; visibility: hidden; transition: opacity 0.25s; z-index: 9999; pointer-events: none;min-width: 400px; }';
            echo '.ctw-tooltip.show { opacity: 1; visibility: visible; pointer-events: auto; }';
            echo '.ctw-tooltip-inner { position: relative; word-wrap: break-word; }';
            echo '.ctw-tooltip-top { bottom: 100%; left: 50%; transform: translateX(-50%); margin-bottom: 8px; }';
            echo '.ctw-tooltip-top .ctw-tooltip-inner::after { content: ""; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); border: 6px solid transparent; border-top-color: var(--ctw-arrow-color, #333333); }';
            echo '.ctw-tooltip-bottom { top: 100%; left: 50%; transform: translateX(-50%); margin-top: 8px; }';
            echo '.ctw-tooltip-bottom .ctw-tooltip-inner::after { content: ""; position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%); border: 6px solid transparent; border-bottom-color: var(--ctw-arrow-color, #333333); }';
            echo '.ctw-tooltip-left { right: 100%; top: 50%; transform: translateY(-50%); margin-right: 8px; }';
            echo '.ctw-tooltip-left .ctw-tooltip-inner::after { content: ""; position: absolute; left: 100%; top: 50%; transform: translateY(-50%); border: 6px solid transparent; border-left-color: var(--ctw-arrow-color, #333333); }';
            echo '.ctw-tooltip-right { left: 100%; top: 50%; transform: translateY(-50%); margin-left: 8px; }';
            echo '.ctw-tooltip-right .ctw-tooltip-inner::after { content: ""; position: absolute; right: 100%; top: 50%; transform: translateY(-50%); border: 6px solid transparent; border-right-color: var(--ctw-arrow-color, #333333); }';
            echo '.ctw-tooltip-inner p{ margin: 0;}';
            echo '.ctw-tooltip-inner b,.ctw-tooltip-inner strong{ font-weight: bold!important;}';
            echo '.ctw-popup-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.55); z-index: 99997; }';
            echo '.ctw-popup-box { position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); background: #ffffff; padding: 30px; max-width: 600px; width: 90%; border-radius: 14px; z-index: 99998; }';
            echo '.ctw-popup-close { position: absolute; top: 12px; right: 12px; cursor: pointer; font-size: 22px; }';
            echo '.ctw-learn-more-btn { margin-top: 12px; cursor: pointer; display: inline-flex; padding: 6px 14px; border-radius: 6px; }';
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
            echo '$(".ctw-wrapper").each(function() {';
            echo 'var $wrapper = $(this);';
            echo 'var triggerType = $wrapper.data("trigger") || "hover";';
            echo 'var $tooltip = $wrapper.find(".ctw-tooltip");';
            echo 'var $trigger = $wrapper.find(".ctw-trigger");';
            echo '$trigger.off("mouseenter mouseleave click");';
            echo '$(document).off("click.ctw-" + $wrapper.index());';
            echo 'if (triggerType === "hover") {';
            echo '$trigger.on("mouseenter", function() { $tooltip.addClass("show"); });';
            echo '$trigger.on("mouseleave", function() { $tooltip.removeClass("show"); });';
            echo '$tooltip.on("mouseenter", function() { $(this).addClass("show"); });';
            echo '$tooltip.on("mouseleave", function() { $(this).removeClass("show"); });';
            echo '} else if (triggerType === "click") {';
            echo '$trigger.on("click", function(e) { e.stopPropagation(); $tooltip.toggleClass("show"); });';
            echo '$(document).on("click.ctw-" + $wrapper.index(), function(e) {';
            echo 'if (!$wrapper.is(e.target) && $wrapper.has(e.target).length === 0) {';
            echo '$tooltip.removeClass("show");';
            echo '}';
            echo '});';
            echo '}';
            echo '});';
            echo '}';
            echo 'function runWhenJQueryReady() {';
            echo 'if (typeof jQuery !== "undefined") {';
            echo 'jQuery(document).ready(function() { initCustomTooltips(); });';
            echo 'jQuery(window).on("elementor/frontend/init", function() { initCustomTooltips(); });';
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
    @media(max-width: 768px){
        .elementor-element.tooltip_container {
            position: relative;
            display: flex;
            flex-direction: column-reverse;
            gap: 10px;
        }
        .elementor-element.tooltip_container .elementor-widget-custom_tooltip {
            --align-self: start!important;
        }
        .ctw-tooltip-bottom {
            left: 0;
            transform: translateX(0%);
        }
        .ctw-tooltip{ min-width: 328px; }
    }
</style>
        <div class="ctw-wrapper" data-trigger="<?php echo $trigger_type; ?>" data-position="<?php echo $position; ?>" style="--ctw-arrow-color: <?php echo $tooltip_bg_color; ?>;">
            <div class="ctw-trigger">
                <span class="ctw-title ctw-icon-<?php echo $icon_position; ?>" style="text-align: <?php echo $title_align; ?>;">
                    <?php if ($show_icon && !empty($settings['icon']) && $icon_position === 'left') : ?>
                        <span class="ctw-icon">
                            <?php
                            \Elementor\Icons_Manager::render_icon($settings['icon'], [
                                'aria-hidden' => 'true',
                            ]);
                            ?>
                        </span>
                    <?php endif; ?>
                    <span class="ctw-text"><?php echo $title_text; ?></span>
                    <?php if ($show_icon && !empty($settings['icon']) && $icon_position === 'right') : ?>
                        <span class="ctw-icon">
                            <?php
                            \Elementor\Icons_Manager::render_icon($settings['icon'], [
                                'aria-hidden' => 'true',
                            ]);
                            ?>
                        </span>
                    <?php endif; ?>
                </span>
                <div class="ctw-tooltip ctw-tooltip-<?php echo $position; ?>">
                <div class="ctw-tooltip-inner">
                    <?php echo wp_kses_post($tooltip_description); ?>
                    <?php if ($show_learn_more) : ?>
                        <button class="ctw-learn-more-btn"><?php echo $learn_more_text; ?></button>
                    <?php endif; ?>
                </div>
            </div>
            </div>
            
        </div>
        <?php if ($show_learn_more) : ?>
            <div class="ctw-popup-overlay" style="display:none;"></div>
            <div class="ctw-popup-box" style="display:none;">
                <div class="ctw-popup-close">&times;</div>
                <div class="ctw-popup-content">
                    <?php echo wp_kses_post($popup_content); ?>
                </div>
            </div>
        <?php endif; ?>

<?php
    }
}



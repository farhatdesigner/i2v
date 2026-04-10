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

        // Section Title
        $this->add_control(
            'section_title',
            [
                'label' => esc_html__('Section Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Section Description
        $this->add_control(
            'section_description',
            [
                'label' => esc_html__('Section Description', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Main repeater for items
        $repeater = new \Elementor\Repeater();

        // Media Type Selector
        $repeater->add_control(
            'media_type',
            [
                'label' => esc_html__('Media Type', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__('Image', 'repindia'),
                    'youtube' => esc_html__('YouTube Video', 'repindia'),
                ],
            ]
        );

        // Default Theme Image
        $repeater->add_control(
            'item_image_default',
            [
                'label' => esc_html__('Default Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'media_type' => 'image',
                ],
            ]
        );

        // Dark Theme Image
        $repeater->add_control(
            'item_image_dark',
            [
                'label' => esc_html__('Dark Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
                'condition' => [
                    'media_type' => 'image',
                ],
            ]
        );

        // YouTube Video ID (Default)
        $repeater->add_control(
            'youtube_video_id_default',
            [
                'label' => esc_html__('Default Theme YouTube Video ID', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__('Enter YouTube video ID only (e.g., R3GfuzLMPkA)', 'repindia'),
                'condition' => [
                    'media_type' => 'youtube',
                ],
            ]
        );

        // YouTube Video ID (Dark)
        $repeater->add_control(
            'youtube_video_id_dark',
            [
                'label' => esc_html__('Dark Theme YouTube Video ID', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__('Enter YouTube video ID only. Leave empty to use default video for dark theme', 'repindia'),
                'condition' => [
                    'media_type' => 'youtube',
                ],
            ]
        );

        // YouTube Thumbnail Image (Default)
        $repeater->add_control(
            'youtube_thumbnail_default',
            [
                'label' => esc_html__('Default Theme Video Thumbnail', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'media_type' => 'youtube',
                ],
            ]
        );

        // YouTube Thumbnail Image (Dark)
        $repeater->add_control(
            'youtube_thumbnail_dark',
            [
                'label' => esc_html__('Dark Theme Video Thumbnail', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default thumbnail for dark theme', 'repindia'),
                'condition' => [
                    'media_type' => 'youtube',
                ],
            ]
        );

        // Item Title
        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Item Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'item_sub_title',
            [
                'label' => esc_html__('Item SubTitle', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Item Description
        $repeater->add_control(
            'item_description',
            [
                'label' => esc_html__('Item Description', 'repindia'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'label_block' => true,
            ]
        );

        // CTA Text
        $repeater->add_control(
            'cta_text',
            [
                'label' => esc_html__('CTA Text', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // CTA URL
        $repeater->add_control(
            'cta_url',
            [
                'label' => esc_html__('CTA URL', 'repindia'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        // CTA Classes
        $repeater->add_control(
            'cta_classes',
            [
                'label' => esc_html__('CTA Classes', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__('Add custom CSS classes for the CTA link (separate multiple classes with spaces)', 'repindia'),
                'label_block' => true,
            ]
        );

        // Bolt Box Title
        $repeater->add_control(
            'bolt_title',
            [
                'label' => esc_html__('Bolt Box Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Bolt Box Icon/Image
        $repeater->add_control(
            'bolt_icon',
            [
                'label' => esc_html__('Bolt Box Icon/Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );
        $repeater->add_control(
            'bolt_dark_icon',
            [
                'label' => esc_html__('Bolt Box Dark Icon/Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Bolt CTA Text
        $repeater->add_control(
            'bolt_cta_text',
            [
                'label' => esc_html__('Bolt CTA Text', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Bolt CTA URL
        $repeater->add_control(
            'bolt_cta_url',
            [
                'label' => esc_html__('Bolt CTA URL', 'repindia'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        // Bolt CTA Classes
        $repeater->add_control(
            'bolt_cta_classes',
            [
                'label' => esc_html__('Bolt CTA Classes', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__('Add custom CSS classes for the Bolt CTA link (separate multiple classes with spaces)', 'repindia'),
                'label_block' => true,
            ]
        );

        // First Nested Repeater
        $repeater->add_control(
            'feature_box_title',
            [
                'label' => esc_html__('Feature Box Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'list_box_title',
            [
                'label' => esc_html__('List Box Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );
        $nested_repeater_1 = new \Elementor\Repeater();

        // Image upload (default theme)
        $nested_repeater_1->add_control(
            'nested_image_default',
            [
                'label' => esc_html__('Default Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Image upload (dark theme)
        $nested_repeater_1->add_control(
            'nested_image_dark',
            [
                'label' => esc_html__('Dark Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
            ]
        );

        // Title
        $nested_repeater_1->add_control(
            'nested_title',
            [
                'label' => esc_html__('Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Description (text editor)
        $nested_repeater_1->add_control(
            'nested_description',
            [
                'label' => esc_html__('Description', 'repindia'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'nested_items_1',
            [
                'label' => esc_html__('Featured Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $nested_repeater_1->get_controls(),
                'default' => [],
                'title_field' => '{{{ nested_title }}}',
            ]
        );

        // Second Nested Repeater

        $nested_repeater_2 = new \Elementor\Repeater();

        // Image upload (default theme)
        $nested_repeater_2->add_control(
            'nested_image_default_2',
            [
                'label' => esc_html__('Default Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Image upload (dark theme)
        $nested_repeater_2->add_control(
            'nested_image_dark_2',
            [
                'label' => esc_html__('Dark Theme Image', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
            ]
        );

        // Title text
        $nested_repeater_2->add_control(
            'nested_title_2',
            [
                'label' => esc_html__('Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'nested_items_2',
            [
                'label' => esc_html__('List Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $nested_repeater_2->get_controls(),
                'default' => [],
                'title_field' => '{{{ nested_title_2 }}}',
            ]
        );

        // Special class indicator (for details-3 with blue headline)
        $repeater->add_control(
            'has_blue_headline',
            [
                'label' => esc_html__('Show Blue Headline', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'scroll_items',
            [
                'label' => esc_html__('Scroll Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();
    }

    // PHP Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $scroll_items = !empty($settings['scroll_items']) ? $settings['scroll_items'] : [];
        $section_title = !empty($settings['section_title']) ? $settings['section_title'] : '';
        $section_description = !empty($settings['section_description']) ? $settings['section_description'] : '';
        $this->add_inline_editing_attributes('custom_class', 'basic');

        // Static SVG checkmark icon for list items
        $checkmark_svg_default = '<svg class="default_liicon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.26701 1.45496C4.91008 1.40364 5.52057 1.15077 6.01158 0.732335C7.15738 -0.244112 8.84262 -0.244112 9.98842 0.732335C10.4794 1.15077 11.0899 1.40364 11.733 1.45496C13.2336 1.57471 14.4253 2.76636 14.545 4.26701C14.5964 4.91008 14.8492 5.52057 15.2677 6.01158C16.2441 7.15738 16.2441 8.84262 15.2677 9.98842C14.8492 10.4794 14.5964 11.0899 14.545 11.733C14.4253 13.2336 13.2336 14.4253 11.733 14.545C11.0899 14.5964 10.4794 14.8492 9.98842 15.2677C8.84262 16.2441 7.15738 16.2441 6.01158 15.2677C5.52057 14.8492 4.91008 14.5964 4.26701 14.545C2.76636 14.4253 1.57471 13.2336 1.45496 11.733C1.40364 11.0899 1.15077 10.4794 0.732335 9.98842C-0.244112 8.84262 -0.244112 7.15738 0.732335 6.01158C1.15077 5.52057 1.40364 4.91008 1.45496 4.26701C1.57471 2.76636 2.76636 1.57471 4.26701 1.45496ZM11.7071 6.70711C12.0976 6.31658 12.0976 5.68342 11.7071 5.29289C11.3166 4.90237 10.6834 4.90237 10.2929 5.29289L7 8.58579L5.70711 7.29289C5.31658 6.90237 4.68342 6.90237 4.29289 7.29289C3.90237 7.68342 3.90237 8.31658 4.29289 8.70711L6.29289 10.7071C6.68342 11.0976 7.31658 11.0976 7.70711 10.7071L11.7071 6.70711Z" fill="#5F6F94"/></svg>';
        $checkmark_svg_dark = '<svg class="dark_liicon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.26701 1.45496C4.91008 1.40364 5.52057 1.15077 6.01158 0.732335C7.15738 -0.244112 8.84262 -0.244112 9.98842 0.732335C10.4794 1.15077 11.0899 1.40364 11.733 1.45496C13.2336 1.57471 14.4253 2.76636 14.545 4.26701C14.5964 4.91008 14.8492 5.52057 15.2677 6.01158C16.2441 7.15738 16.2441 8.84262 15.2677 9.98842C14.8492 10.4794 14.5964 11.0899 14.545 11.733C14.4253 13.2336 13.2336 14.4253 11.733 14.545C11.0899 14.5964 10.4794 14.8492 9.98842 15.2677C8.84262 16.2441 7.15738 16.2441 6.01158 15.2677C5.52057 14.8492 4.91008 14.5964 4.26701 14.545C2.76636 14.4253 1.57471 13.2336 1.45496 11.733C1.40364 11.0899 1.15077 10.4794 0.732335 9.98842C-0.244112 8.84262 -0.244112 7.15738 0.732335 6.01158C1.15077 5.52057 1.40364 4.91008 1.45496 4.26701C1.57471 2.76636 2.76636 1.57471 4.26701 1.45496ZM11.7071 6.70711C12.0976 6.31658 12.0976 5.68342 11.7071 5.29289C11.3166 4.90237 10.6834 4.90237 10.2929 5.29289L7 8.58579L5.70711 7.29289C5.31658 6.90237 4.68342 6.90237 4.29289 7.29289C3.90237 7.68342 3.90237 8.31658 4.29289 8.70711L6.29289 10.7071C6.68342 11.0976 7.31658 11.0976 7.70711 10.7071L11.7071 6.70711Z" fill="#D7DBE4"/></svg>';
        ?>

        <style>
            .youtube-wrapper .white_theme_iframe,
            .youtube-wrapper .white_theme_thumb {
                display: block;
            }

            .youtube-wrapper .black_theme_iframe,
            .youtube-wrapper .black_theme_thumb {
                display: none;
            }

            .js-dark .youtube-wrapper .white_theme_iframe,
            .js-dark .youtube-wrapper .white_theme_thumb {
                display: none;
            }

            .js-dark .youtube-wrapper .black_theme_iframe,
            .js-dark .youtube-wrapper .black_theme_thumb {
                display: block;
            }

            h4.subtitlebox {
                background: #FFFFFF;
                border-radius: 28px;
                padding: 4px 12px;
                color: #4A5673;
                font-size: 14px;
                font-style: normal;
                font-weight: 500;
                line-height: 20px;
                width: auto;
                display: inline-block;
                text-align: left;
                border: 1px solid #E6EBF2;
            }


            /* Nested repeater image theme switching */
            .nested-image-wrapper .white_theme_img {
                display: block;
            }

            .nested-image-wrapper .black_theme_img {
                display: none;
            }

            .js-dark .nested-image-wrapper .white_theme_img {
                display: none;
            }

            .js-dark .nested-image-wrapper .black_theme_img {
                display: block;
            }

            .js-dark .default_liicon,
            .dark_liicon {
                display: none;
            }

            .js-dark .dark_liicon {
                display: block;
            }

            .hz-slider-section .swiper-slide ul li>span>svg {
                width: 14px;
                height: 14px;
            }

            .featuregroup_repeator .nested-image-wrapper img,
            .featuregroup_repeator .nested-image-wrapper {
                width: 26px;
                height: 26px;
                /* padding-bottom: 8px; */
            }


            .featuregroup_repeator .nested-image-wrapper img {
                margin-bottom: 4px;
            }

            .featuregroup_repeator .nested-item-1 {
                padding: 4px 16px;
    border-radius: 100px;
    background: #fff;
    max-width: max-content;
    border: 1px solid #E6EBF2;
    /* width: calc(50% - 2px); */
    display: flex;
    flex-direction: column;
    align-items: stretch;
            }

            .featuregroup_repeator h3.nested-title-1 {
                color: #4A5673;
    font-size: 16px;
    font-style: normal;
    font-weight: 500 !important;
    line-height: 24px;
    margin-bottom: 0;
    text-align: left;
            }
            #transportation_analytics .featuregroup_repeator .nested-item-1 {
                padding: 12px;
                border-radius: 8px;
                width: calc(50% - 2px);
            }

            .featuregroup_repeator .nested-description-1,
            .featuregroup_repeator .nested-description-1 p {
                color: #5C5C5C;
                font-size: 16px;
                font-style: normal;
                font-weight: 400;
                line-height: 24px;
                margin: 0;
                text-align: left;
            }

            .nested-repeater-1.featuregroup_repeator {
                display: flex;
                align-items: stretch;
                gap: 4px;
                flex-wrap: wrap;
                margin-bottom: 20px;
            }

            .bolt {
                max-width: 300px;
                margin-bottom: 0;
                margin-top: 20px;
            }

            .listedgroup_repeator ul {
                padding: 0;
                gap: 8px;
                display: flex;
                flex-direction: column;
            }

            .listedgroup_repeator li span {
                display: inline-block;
                width: auto;
            }
            
.js-dark .listedgroup_repeator li span svg path {
    fill: #669477;
}
.listedgroup_repeator li span svg path {
    fill: #418259;
}

            h4.boxtitle {
                color: #5C5C5C;
                font-size: 14px;
                font-style: normal;
                font-weight: 600;
                line-height: 20px;
                margin: 16px 0 8px;
            }

            .js-dark .featuregroup_repeator .nested-item-1 {
                background: #262A30;
                border: 1px solid rgb(193 196 198 / 10%) !important;
            }

            .js-dark .featuregroup_repeator h3.nested-title-1 {
                color: #D7DBE4 !important;
            }

            .js-dark h4.boxtitle {
                color: #AEB6C9 !important;
            }

            .js-dark h4.subtitlebox {
                background: #262A30;
                color: #D7DBE4 !important;
                border: 1px solid rgb(193 196 198 / 10%);
            }

            .bolt img {
                width: 40px;
            }

            @media(max-width: 768px) {
                .photo_custom .details * {
                    text-align: left;
                }
            }

            @media(max-width: 767px) {

                .featuregroup_repeator h3.nested-title-1 {
                    font-size: 14px;
                }

                .featuregroup_repeator .nested-description-1,
                .featuregroup_repeator .nested-description-1 p {
                    font-size: 14px;
                    line-height: 1.2 !important;
                }

                h4.boxtitle {
                    font-size: 11px;
                }
                
.featuregroup_repeator .nested-image-wrapper img, .featuregroup_repeator .nested-image-wrapper {
    width: 32px;
    height: 32px;
    padding-bottom: 0;
}

            }
        </style>

        <div class="makdmks scalescroll-widget">
            <div class="custom-container">
                <?php if (!empty($section_title) || !empty($section_description)): ?>
                    <div class="title-box">
                        <div class="col-lg-6 col-12">
                            <div class="width_define">
                                <?php if (!empty($section_title)): ?>
                                    <h2 class="main_title quote mb-12">
                                        <?php echo esc_html($section_title); ?>
                                    </h2>
                                <?php endif; ?>
                                <?php if (!empty($section_description)): ?>
                                    <div class="text-left">
                                        <p><?php echo wp_kses_post($section_description); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($scroll_items)): ?>
                    <div class="gallery">
                        <div class="left">
                            <div class="detailsWrapper">
                                <?php foreach ($scroll_items as $index => $item): ?>
                                    <?php
                                    $item_num = $index + 1;
                                    $item_title = !empty($item['item_title']) ? $item['item_title'] : '';
                                    $item_sub_title = !empty($item['item_sub_title']) ? $item['item_sub_title'] : '';
                                    $item_desc = !empty($item['item_description']) ? $item['item_description'] : '';
                                    $cta_text = !empty($item['cta_text']) ? $item['cta_text'] : '';
                                    $cta_url = !empty($item['cta_url']['url']) ? $item['cta_url']['url'] : '';
                                    $cta_target = !empty($item['cta_url']['is_external']) ? 'target="_blank"' : '';
                                    $cta_nofollow = !empty($item['cta_url']['nofollow']) ? 'rel="nofollow"' : '';
                                    $cta_classes = !empty($item['cta_classes']) ? ' ' . esc_attr($item['cta_classes']) : '';
                                    $bolt_title = !empty($item['bolt_title']) ? $item['bolt_title'] : '';
                                    $bolt_icon = !empty($item['bolt_icon']['url']) ? $item['bolt_icon']['url'] : '';
                                    $bolt_dark_icon = !empty($item['bolt_dark_icon']['url']) ? $item['bolt_dark_icon']['url'] : '';
                                    $bolt_cta_text = !empty($item['bolt_cta_text']) ? $item['bolt_cta_text'] : '';
                                    $bolt_cta_url = !empty($item['bolt_cta_url']['url']) ? $item['bolt_cta_url']['url'] : '';
                                    $bolt_cta_target = !empty($item['bolt_cta_url']['is_external']) ? 'target="_blank"' : '';
                                    $bolt_cta_nofollow = !empty($item['bolt_cta_url']['nofollow']) ? 'rel="nofollow"' : '';
                                    $bolt_cta_classes = !empty($item['bolt_cta_classes']) ? ' ' . esc_attr($item['bolt_cta_classes']) : '';
                                    $has_blue_headline = !empty($item['has_blue_headline']) && $item['has_blue_headline'] === 'yes';
                                    $feature_box_title = !empty($item['feature_box_title']) ? $item['feature_box_title'] : '';
                                    $list_box_title = !empty($item['list_box_title']) ? $item['list_box_title'] : '';
                                    ?>
                                    <div class="details details-<?php echo esc_attr($item_num); ?>">
                                        <?php if ($has_blue_headline): ?>
                                            <div class="headline blue"></div>
                                        <?php endif; ?>
                                        <div class="txtflex">
                                            <?php if (!empty($item_sub_title)): ?>
                                                <h4 class="subtitlebox"><?php echo esc_html($item_sub_title); ?></h4>
                                            <?php endif; ?>
                                            <?php if (!empty($item_title)): ?>
                                                <h2><?php echo esc_html($item_title); ?></h2>
                                            <?php endif; ?>
                                            <?php if (!empty($item_desc)): ?>
                                                <p class="para-text"><?php echo wp_kses_post($item_desc); ?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($cta_text) && !empty($cta_url)): ?>
                                                <div class="text-left">
                                                    <a class="theme-btn bg-trans border_btnlight<?php echo $cta_classes; ?>"
                                                        href="<?php echo esc_url($cta_url); ?>" <?php echo $cta_target; ?>                     <?php echo $cta_nofollow; ?>><?php echo esc_html($cta_text); ?></a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($bolt_title) || !empty($bolt_icon) || (!empty($bolt_cta_text) && !empty($bolt_cta_url))): ?>
                                                <div class="bolt">
                                                    <?php if (!empty($bolt_icon)): ?>
                                                        <img class="lightfile" src="<?php echo esc_url($bolt_icon); ?>"
                                                            alt="<?php echo esc_attr($bolt_title); ?>">
                                                    <?php endif; ?>
                                                    <?php if (!empty($bolt_dark_icon)): ?>
                                                        <img class="darkfile" src="<?php echo esc_url($bolt_dark_icon); ?>"
                                                            alt="<?php echo esc_attr($bolt_title); ?>">
                                                    <?php endif; ?>
                                                    <?php if (!empty($bolt_title)): ?>
                                                        <p><?php echo esc_html($bolt_title); ?></p>
                                                    <?php endif; ?>
                                                    <?php if (!empty($bolt_cta_text) && !empty($bolt_cta_url)): ?>
                                                        <div class="btn-bolt">
                                                            <a href="<?php echo esc_url($bolt_cta_url); ?>"
                                                                class="<?php echo $bolt_cta_classes; ?>" <?php echo $bolt_cta_target; ?>                         <?php echo $bolt_cta_nofollow; ?>><?php echo esc_html($bolt_cta_text); ?></a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php
                                            // First Nested Repeater
                                            $nested_items_1 = !empty($item['nested_items_1']) ? $item['nested_items_1'] : [];
                                            if (!empty($nested_items_1)): ?>
                                                <?php if (!empty($feature_box_title)): ?>
                                                    <h4 class="boxtitle"><?php echo esc_html($feature_box_title); ?></h4>
                                                <?php endif; ?>
                                                <div class="nested-repeater-1 featuregroup_repeator">
                                                    <?php foreach ($nested_items_1 as $nested_item_1): ?>
                                                        <?php
                                                        $nested_image_default_1 = !empty($nested_item_1['nested_image_default']['url']) ? $nested_item_1['nested_image_default']['url'] : '';
                                                        $nested_image_dark_1 = !empty($nested_item_1['nested_image_dark']['url']) ? $nested_item_1['nested_image_dark']['url'] : $nested_image_default_1;
                                                        $nested_title_1 = !empty($nested_item_1['nested_title']) ? $nested_item_1['nested_title'] : '';
                                                        $nested_description_1 = !empty($nested_item_1['nested_description']) ? $nested_item_1['nested_description'] : '';
                                                        ?>
                                                        <div class="nested-item-1">
                                                            <?php if (!empty($nested_image_default_1)): ?>
                                                                <div class="nested-image-wrapper">
                                                                    <img class="white_theme_img"
                                                                        src="<?php echo esc_url($nested_image_default_1); ?>"
                                                                        alt="<?php echo esc_attr($nested_title_1); ?>">
                                                                    <img class="black_theme_img" src="<?php echo esc_url($nested_image_dark_1); ?>"
                                                                        alt="<?php echo esc_attr($nested_title_1); ?>">
                                                                </div>
                                                            <?php endif; ?>
                                                            <?php if (!empty($nested_title_1)): ?>
                                                                <h3 class="nested-title-1"><?php echo esc_html($nested_title_1); ?></h3>
                                                            <?php endif; ?>
                                                            <?php if (!empty($nested_description_1)): ?>
                                                                <div class="nested-description-1"><?php echo wp_kses_post($nested_description_1); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php
                                            // Second Nested Repeater
                                            $nested_items_2 = !empty($item['nested_items_2']) ? $item['nested_items_2'] : [];
                                            if (!empty($nested_items_2)): ?>
                                                <?php if (!empty($list_box_title)): ?>
                                                    <h4 class="boxtitle"><?php echo esc_html($list_box_title); ?></h4>
                                                <?php endif; ?>
                                                <div class="nested-repeater-2 listedgroup_repeator">
                                                    <ul>
                                                        <?php foreach ($nested_items_2 as $nested_item_2): ?>
                                                            <?php
                                                            $nested_title_2 = !empty($nested_item_2['nested_title_2']) ? $nested_item_2['nested_title_2'] : '';
                                                            ?>
                                                            <?php if (!empty($nested_title_2)): ?>
                                                                <li>
                                                                    <span>
                                                                        <?php echo $checkmark_svg_default; ?>
                                                                        <?php echo $checkmark_svg_dark; ?>
                                                                    </span>
                                                                    <?php echo esc_html($nested_title_2); ?>
                                                                </li>


                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="right">
                            <div class="photos">
                                <?php foreach ($scroll_items as $index => $item): ?>
                                    <?php
                                    $item_num = $index + 1;
                                    $media_type = !empty($item['media_type']) ? $item['media_type'] : 'image';
                                    $item_title = !empty($item['item_title']) ? $item['item_title'] : '';
                                    $item_sub_title = !empty($item['item_sub_title']) ? $item['item_sub_title'] : '';
                                    $item_desc = !empty($item['item_description']) ? $item['item_description'] : '';
                                    $cta_text = !empty($item['cta_text']) ? $item['cta_text'] : '';
                                    $cta_url = !empty($item['cta_url']['url']) ? $item['cta_url']['url'] : '';
                                    $cta_target = !empty($item['cta_url']['is_external']) ? 'target="_blank"' : '';
                                    $cta_nofollow = !empty($item['cta_url']['nofollow']) ? 'rel="nofollow"' : '';
                                    $cta_classes = !empty($item['cta_classes']) ? ' ' . esc_attr($item['cta_classes']) : '';
                                    $bolt_title = !empty($item['bolt_title']) ? $item['bolt_title'] : '';
                                    $bolt_icon = !empty($item['bolt_icon']['url']) ? $item['bolt_icon']['url'] : '';
                                    $bolt_cta_text = !empty($item['bolt_cta_text']) ? $item['bolt_cta_text'] : '';
                                    $bolt_cta_url = !empty($item['bolt_cta_url']['url']) ? $item['bolt_cta_url']['url'] : '';
                                    $bolt_cta_target = !empty($item['bolt_cta_url']['is_external']) ? 'target="_blank"' : '';
                                    $bolt_cta_nofollow = !empty($item['bolt_cta_url']['nofollow']) ? 'rel="nofollow"' : '';
                                    $bolt_cta_classes = !empty($item['bolt_cta_classes']) ? ' ' . esc_attr($item['bolt_cta_classes']) : '';
                                    $has_blue_headline = !empty($item['has_blue_headline']) && $item['has_blue_headline'] === 'yes';
                                    $feature_box_title = !empty($item['feature_box_title']) ? $item['feature_box_title'] : '';
                                    $list_box_title = !empty($item['list_box_title']) ? $item['list_box_title'] : '';

                                    // Image handling
                                    $image_default = !empty($item['item_image_default']['url']) ? $item['item_image_default']['url'] : '';
                                    $image_default_alt = !empty($item['item_image_default']['alt']) ? $item['item_image_default']['alt'] : $item_title;
                                    $image_dark = !empty($item['item_image_dark']['url']) ? $item['item_image_dark']['url'] : $image_default;
                                    $image_dark_alt = !empty($item['item_image_dark']['alt']) ? $item['item_image_dark']['alt'] : $image_default_alt;

                                    // YouTube handling
                                    $youtube_id_default = !empty($item['youtube_video_id_default']) ? $item['youtube_video_id_default'] : '';
                                    $youtube_id_dark = !empty($item['youtube_video_id_dark']) ? $item['youtube_video_id_dark'] : $youtube_id_default;
                                    $youtube_thumb_default = !empty($item['youtube_thumbnail_default']['url']) ? $item['youtube_thumbnail_default']['url'] : '';
                                    $youtube_thumb_dark = !empty($item['youtube_thumbnail_dark']['url']) ? $item['youtube_thumbnail_dark']['url'] : $youtube_thumb_default;
                                    ?>
                                    <div class="photo photo_custom">
                                        <?php if ($media_type === 'image' && !empty($image_default)): ?>
                                            <img class="white_theme_img radius-12" decoding="async"
                                                src="<?php echo esc_url($image_default); ?>"
                                                alt="<?php echo esc_attr($image_default_alt); ?>">
                                            <img class="black_theme_img radius-12" decoding="async"
                                                src="<?php echo esc_url($image_dark); ?>" alt="<?php echo esc_attr($image_dark_alt); ?>">
                                        <?php elseif ($media_type === 'youtube' && !empty($youtube_id_default)): ?>
                                            <?php
                                            $youtube_thumb_default_final = !empty($youtube_thumb_default) ? $youtube_thumb_default : 'https://img.youtube.com/vi/' . $youtube_id_default . '/hqdefault.jpg';
                                            $youtube_thumb_dark_final = !empty($youtube_thumb_dark) ? $youtube_thumb_dark : 'https://img.youtube.com/vi/' . $youtube_id_dark . '/hqdefault.jpg';
                                            ?>
                                            <div class="youtube-wrapper radius-12"
                                                style="position: relative; width: 100%; height: 60vh; overflow: hidden; cursor: pointer;">
                                                <iframe class="radius-12 youtube-iframe white_theme_iframe"
                                                    data-video-id="<?php echo esc_attr($youtube_id_default); ?>" src="" width="100%"
                                                    height="60vh" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture"
                                                    allowfullscreen
                                                    style="width: 100%; height: 60vh; position: absolute; top: 0; left: 0; z-index: 1;"></iframe>
                                                <iframe class="radius-12 youtube-iframe black_theme_iframe"
                                                    data-video-id="<?php echo esc_attr($youtube_id_dark); ?>" src="" width="100%"
                                                    height="60vh" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture mute"
                                                    allowfullscreen
                                                    style="width: 100%; height: 60vh; position: absolute; top: 0; left: 0; z-index: 1; display: none;"></iframe>
                                                <img src="<?php echo esc_url($youtube_thumb_default_final); ?>" alt="Video thumbnail"
                                                    class="youtube-thumb white_theme_thumb"
                                                    style="width: 100%; height: 100%; object-fit: cover; display: block; position: absolute; top: 0; left: 0; z-index: 2; cursor: pointer;" />
                                                <img src="<?php echo esc_url($youtube_thumb_dark_final); ?>" alt="Video thumbnail"
                                                    class="youtube-thumb black_theme_thumb"
                                                    style="width: 100%; height: 100%; object-fit: cover; display: none; position: absolute; top: 0; left: 0; z-index: 2; cursor: pointer;" />
                                                <button class="play-btn" aria-label="Play video">
                                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="white" style="margin-left: 4px;">
                                                        <path d="M8 5v14l11-7z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        <?php endif; ?>

                                        <div class="details details-<?php echo esc_attr($item_num); ?>">
                                            <?php if ($has_blue_headline): ?>
                                                <div class="headline blue"></div>
                                            <?php endif; ?>
                                            <div class="txtflex">
                                                <?php if (!empty($item_sub_title)): ?>
                                                    <h4 class="subtitlebox"><?php echo esc_html($item_sub_title); ?></h4>
                                                <?php endif; ?>
                                                <?php if (!empty($item_title)): ?>
                                                    <h2><?php echo esc_html($item_title); ?></h2>
                                                <?php endif; ?>
                                                <?php if (!empty($item_desc)): ?>
                                                    <p class="para-text"><?php echo wp_kses_post($item_desc); ?></p>
                                                <?php endif; ?>
                                                <?php if (!empty($cta_text) && !empty($cta_url)): ?>
                                                    <div class="text-left">
                                                        <a class="theme-btn bg-trans border_btnlight<?php echo $cta_classes; ?>"
                                                            href="<?php echo esc_url($cta_url); ?>" <?php echo $cta_target; ?>                     <?php echo $cta_nofollow; ?>><?php echo esc_html($cta_text); ?></a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($bolt_title) || !empty($bolt_icon) || (!empty($bolt_cta_text) && !empty($bolt_cta_url))): ?>
                                                    <div class="bolt">
                                                        <?php if (!empty($bolt_icon)): ?>
                                                            <img src="<?php echo esc_url($bolt_icon); ?>"
                                                                alt="<?php echo esc_attr($bolt_title); ?>">
                                                        <?php endif; ?>
                                                        <?php if (!empty($bolt_title)): ?>
                                                            <p><?php echo esc_html($bolt_title); ?></p>
                                                        <?php endif; ?>
                                                        <?php if (!empty($bolt_cta_text) && !empty($bolt_cta_url)): ?>
                                                            <div class="btn-bolt">
                                                                <a href="<?php echo esc_url($bolt_cta_url); ?>"
                                                                    class="<?php echo $bolt_cta_classes; ?>" <?php echo $bolt_cta_target; ?>
                                                                    <?php echo $bolt_cta_nofollow; ?>><?php echo esc_html($bolt_cta_text); ?></a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php
                                                // First Nested Repeater
                                                $nested_items_1 = !empty($item['nested_items_1']) ? $item['nested_items_1'] : [];
                                                if (!empty($nested_items_1)): ?>
                                                    <?php if (!empty($feature_box_title)): ?>
                                                        <h4 class="boxtitle"><?php echo esc_html($feature_box_title); ?></h4>
                                                    <?php endif; ?>
                                                    <div class="nested-repeater-1 featuregroup_repeator">
                                                        <?php foreach ($nested_items_1 as $nested_item_1): ?>
                                                            <?php
                                                            $nested_image_default_1 = !empty($nested_item_1['nested_image_default']['url']) ? $nested_item_1['nested_image_default']['url'] : '';
                                                            $nested_image_dark_1 = !empty($nested_item_1['nested_image_dark']['url']) ? $nested_item_1['nested_image_dark']['url'] : $nested_image_default_1;
                                                            $nested_title_1 = !empty($nested_item_1['nested_title']) ? $nested_item_1['nested_title'] : '';
                                                            $nested_description_1 = !empty($nested_item_1['nested_description']) ? $nested_item_1['nested_description'] : '';
                                                            ?>
                                                            <div class="nested-item-1">
                                                                <?php if (!empty($nested_image_default_1)): ?>
                                                                    <div class="nested-image-wrapper">
                                                                        <img class="white_theme_img"
                                                                            src="<?php echo esc_url($nested_image_default_1); ?>"
                                                                            alt="<?php echo esc_attr($nested_title_1); ?>">
                                                                        <img class="black_theme_img"
                                                                            src="<?php echo esc_url($nested_image_dark_1); ?>"
                                                                            alt="<?php echo esc_attr($nested_title_1); ?>">
                                                                    </div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($nested_title_1)): ?>
                                                                    <h3 class="nested-title-1"><?php echo esc_html($nested_title_1); ?></h3>
                                                                <?php endif; ?>
                                                                <?php if (!empty($nested_description_1)): ?>
                                                                    <div class="nested-description-1">
                                                                        <?php echo wp_kses_post($nested_description_1); ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php
                                                // Second Nested Repeater
                                                $nested_items_2 = !empty($item['nested_items_2']) ? $item['nested_items_2'] : [];
                                                if (!empty($nested_items_2)): ?>
                                                    <?php if (!empty($list_box_title)): ?>
                                                        <h4 class="boxtitle"><?php echo esc_html($list_box_title); ?></h4>
                                                    <?php endif; ?>
                                                    <div class="nested-repeater-2 listedgroup_repeator">
                                                        <ul>
                                                            <?php foreach ($nested_items_2 as $nested_item_2): ?>
                                                                <?php
                                                                $nested_title_2 = !empty($nested_item_2['nested_title_2']) ? $nested_item_2['nested_title_2'] : '';
                                                                ?>
                                                                <?php if (!empty($nested_title_2)): ?>
                                                                    <li>
                                                                        <span>
                                                                            <?php echo $checkmark_svg_default; ?>
                                                                            <?php echo $checkmark_svg_dark; ?>
                                                                        </span>
                                                                        <?php echo esc_html($nested_title_2); ?>
                                                                    </li>


                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <script>
            (function () {
                function postYouTubeCommand(iframe, func) {
                    if (!iframe || !iframe.contentWindow) return;
                    iframe.contentWindow.postMessage(
                        JSON.stringify({ event: "command", func: func, args: [] }),
                        "*"
                    );
                }

                function ensureYouTubeSrc(iframe, opts) {
                    if (!iframe) return;
                    if (iframe.dataset.ytLoaded === "1") return;

                    var videoId = iframe.getAttribute("data-video-id");
                    if (!videoId) return;

                    var origin = (window.location && window.location.origin) ? window.location.origin : "";
                    var params = [
                        "autoplay=" + (opts.autoplay ? "1" : "0"),
                        "mute=" + (opts.muted ? "1" : "0"),
                        "loop=1",
                        "playlist=" + encodeURIComponent(videoId),
                        "rel=0",
                        "playsinline=1",
                        "controls=0",
                        "enablejsapi=1"
                    ];
                    if (origin) params.push("origin=" + encodeURIComponent(origin));

                    iframe.src = "https://www.youtube.com/embed/" + encodeURIComponent(videoId) + "?" + params.join("&");
                    iframe.dataset.ytLoaded = "1";
                }

                function getActiveIframe(wrapper) {
                    var isDark = document.body.classList.contains("js-dark") || document.documentElement.classList.contains("js-dark");
                    return isDark
                        ? (wrapper.querySelector(".black_theme_iframe") || wrapper.querySelector(".youtube-iframe"))
                        : (wrapper.querySelector(".white_theme_iframe") || wrapper.querySelector(".youtube-iframe"));
                }

                function hideThumbsAndButton(wrapper) {
                    var thumbs = wrapper.querySelectorAll(".youtube-thumb");
                    thumbs.forEach(function (t) { t.style.display = "none"; });
                    var playBtn = wrapper.querySelector(".play-btn");
                    if (playBtn) playBtn.style.display = "none";
                }

                document.addEventListener("DOMContentLoaded", function () {
                    var youtubeWrappers = document.querySelectorAll(".scalescroll-widget .youtube-wrapper");
                    youtubeWrappers.forEach(function (wrapper) {
                        var iframes = wrapper.querySelectorAll(".youtube-iframe");
                        if (!iframes.length) return;

                        // Never show both theme iframes at once (avoids double decode / extra work).
                        iframes.forEach(function (i) { i.style.display = "none"; });
                        var active = getActiveIframe(wrapper);
                        if (active) active.style.display = "block";

                        // Autoplay muted when visible, pause when hidden, resume without reloading.
                        var observer = new IntersectionObserver(function (entries) {
                            entries.forEach(function (entry) {
                                var iframe = getActiveIframe(wrapper);
                                if (!iframe) return;

                                if (entry.isIntersecting) {
                                    hideThumbsAndButton(wrapper);
                                    ensureYouTubeSrc(iframe, { autoplay: true, muted: true });
                                    postYouTubeCommand(iframe, "playVideo");
                                } else {
                                    postYouTubeCommand(iframe, "pauseVideo");
                                }
                            });
                        }, { threshold: 0.25, rootMargin: "0px" });
                        observer.observe(wrapper);

                        // If the user explicitly clicks, keep playing and unmute (still no reload).
                        wrapper.addEventListener("click", function () {
                            var iframe = getActiveIframe(wrapper);
                            if (!iframe) return;
                            hideThumbsAndButton(wrapper);
                            ensureYouTubeSrc(iframe, { autoplay: true, muted: false });
                            postYouTubeCommand(iframe, "playVideo");
                            postYouTubeCommand(iframe, "unMute");
                        });
                    });
                });
            })();
        </script>

        <?php
    }
}
?>
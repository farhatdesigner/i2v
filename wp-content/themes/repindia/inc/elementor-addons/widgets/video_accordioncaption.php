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

        // Left Block Title
        $this->add_control(
            'left_block_title',
            [
                'label' => esc_html__('Left Block Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Right Block Title
        $this->add_control(
            'right_block_title',
            [
                'label' => esc_html__('Right Block Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Main repeater for accordion items
        $repeater = new \Elementor\Repeater();

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

        // Item Short Description
        $repeater->add_control(
            'item_short_description',
            [
                'label' => esc_html__('Item Short Description', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Item Short Description Icon/Image (Default Theme)
        $repeater->add_control(
            'item_short_desc_icon_default',
            [
                'label' => esc_html__('Short Description Icon/Image (Default Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Item Short Description Icon/Image (Dark Theme)
        $repeater->add_control(
            'item_short_desc_icon_dark',
            [
                'label' => esc_html__('Short Description Icon/Image (Dark Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default icon for dark theme', 'repindia'),
            ]
        );

        // Item Details Image (Default Theme)
        $repeater->add_control(
            'item_details_image_default',
            [
                'label' => esc_html__('Item Details Image (Default Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Item Details Image (Dark Theme)
        $repeater->add_control(
            'item_details_image_dark',
            [
                'label' => esc_html__('Item Details Image (Dark Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
            ]
        );

        // Item Detail Title
        $repeater->add_control(
            'item_detail_title',
            [
                'label' => esc_html__('Item Detail Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Item Detail Description
        $repeater->add_control(
            'item_detail_description',
            [
                'label' => esc_html__('Item Detail Description', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Nested Repeater for Item Tags
        $tag_repeater = new \Elementor\Repeater();
        $tag_repeater->add_control(
            'tag_text',
            [
                'label' => esc_html__('Tag Text', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_tags',
            [
                'label' => esc_html__('Item Tags', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $tag_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ tag_text }}}',
            ]
        );

        $this->add_control(
            'accordion_items',
            [
                'label' => esc_html__('Accordion Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ item_title }}}',
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
        $accordion_items = !empty($settings['accordion_items']) ? $settings['accordion_items'] : [];
        $section_title = !empty($settings['section_title']) ? $settings['section_title'] : '';
        $section_description = !empty($settings['section_description']) ? $settings['section_description'] : '';
        $left_block_title = !empty($settings['left_block_title']) ? $settings['left_block_title'] : '';
        $right_block_title = !empty($settings['right_block_title']) ? $settings['right_block_title'] : '';
        $this->add_inline_editing_attributes('custom_class', 'basic'); ?>

        <style>
            .vac_accordion_wrap {
                border-radius: 12px;
            }

            .vac_accordion_wrap .custom-container {
                overflow-x: hidden;
                box-sizing: border-box;
            }

            .vac_vertical_scroller {
                align-items: flex-start;
                gap: 80px;
                flex-wrap: nowrap;
                margin-top: 48px;
                width: 100%;
                box-sizing: border-box;
                min-width: 0;
                position: relative;
            }

            .vac_vertical_scroller.g-0 {
                margin-left: 0;
                margin-right: 0;
            }

            .vac_vertical_scroller .col-md-6 {
                box-sizing: border-box;
                padding-left: 0 !important;
                padding-right: 0 !important;
                flex: 0 0 calc(50% - 40px);
                max-width: calc(50% - 40px);
                min-width: 0;
                width: calc(50% - 40px);
            }

            .vac_vertical_scroller .vac_padd-accordion_video {
                flex-shrink: 0;
            }

            @media (max-width: 991px) {
                .vac_vertical_scroller {
                    flex-wrap: wrap;
                }

                .vac_vertical_scroller .col-md-6 {
                    flex: 0 0 100%;
                    max-width: 100%;
                    width: 100%;
                }
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
                margin-bottom: 8px;
            }

            .vac_accordion_sets {
                display: flex;
                flex-direction: column;
            }

            .vac_accordion_set {
                position: relative;
                border-top: 1px solid #E6EBF2;
                padding: 30px 20px;
                background: transparent;
                transition: background 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    padding 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    border-color 0.3s ease;
                will-change: background, padding;
            }

            .vac_accordion_set.active+.vac_accordion_set {
                border-top: none !important;
            }

            .js-dark .vac_accordion_set {
                border-top: 1px solid #c1c4c626 !important;
            }

            .js-dark .vac_padd-accordion_video .card {
                background: #25292e;
            }

            .vac_accordion_set.active {
                position: relative;
                border-top: 0px solid #E6EBF2;
                padding: 12px;
                border-radius: 12px;
                background: #F2F5FA;
            }


            .vac_select_div {
                display: flex;
                align-items: center;
                width: 100%;
                background: transparent !important;
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
                background-color: #F2F5FA;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .vac_accordion_set.active .vac_ac_icon_border {
                background: #FFF;
            }

            .js-dark .vac_ac_icon_border {
                background-color: #ffffff1a !important;
            }

            .js-dark .vac_accordion_set.active .vac_ac_icon_border {
                background: #ffffff1a;
            }



            #white_bg-conatainer .custom-container {
                background: #ffffff;
                padding: 80px 60px;
            }

            .js-dark .vac_accordion_set.active {
                background: #464A4F;
            }

            .vac_ac_icon {
                width: 64px;
                height: 64px;
                object-fit: contain;
            }

            /* Icon Theme Switching */
            .vac_ac_icon_border .white-theme-img {
                display: block;
            }

            .vac_ac_icon_border .black-theme-img {
                display: none;
            }

            .js-dark .vac_ac_icon_border .white-theme-img {
                display: none;
            }

            .js-dark .vac_ac_icon_border .black-theme-img {
                display: block;
                transition: filter 0.3s ease;
            }

            /* .vac_accordion_set.active .vac_ac_icon {
                                                                                                                                                                filter: brightness(0) invert(1);
                                                                                                                                                            } */

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
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                margin-left: auto;
                will-change: transform;
                position: absolute;
                top: 35%;
                right: 12px;
            }

            .vac_chevron svg {
                width: 20px;
                height: 20px;
                stroke: rgb(95 111 148 / 50%);
                transition: stroke 0.3s ease;
            }

            .vac_accordion_set.active .vac_chevron {
                transform: rotate(180deg);
                right: 16px;
            }

            .vac_accordion_set.active .vac_chevron svg {
                stroke: #5F6F94;
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

            .vac_accordion_sets .vac_accordion_set:first-child {
                border-top: none;
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
                margin: 8px 40px 8px 20px;
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
                max-height: max-content !important;
                min-height: auto !important;
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
                background: linear-gradient(90deg, #0099ED, #0099ED);
                transition: width 0.05s linear;
            }

            .js-dark .vac_progress_bar::after {
                background: linear-gradient(90deg, #74C2ED, #74C2ED);
            }

            .vac_accordion_set:not(.active) .vac_progress_bar::after {
                width: 0%;
            }

            .vac_padd-accordion_video .vac_accordion_video {
                display: none;
                border-radius: 12px;
                overflow: hidden;
            }

            .vac_padd-accordion_video .vac_accordion_video:first-child {
                display: block;
            }

            .vac_padd-accordion_video .vac_accordion_video img {
                width: 100%;
                height: auto;
                cursor: pointer;
                transition: transform 0.3s ease;
                min-height: auto !important;
                max-height: max-content;
            }

            .vac_padd-accordion_video .vac_accordion_video.vac_active {
                display: block;
            }

            .video_topcaption_white .shadow-sm {
                box-shadow: none !important;
            }

            .video_topcaption_white .card-body,
            .video_topcaption_white .card-image {
                box-shadow: none !important;
                padding: 0;
            }

            .vac_ac_icon_border>span {
                padding: 10px;
            }

            /* retail accordion */

            #retail_grey-accrordion .vac_accordion_set.active {
                background: #FFFFFF;
            }

            #retail_grey-accrordion .vac_accordion_set.active .vac_chevron svg {
                stroke: #D7DBE4;
            }

            /* .js-dark #retail_grey-accrordion .vac_accordion_set.active {background: #FFFFFF;}
                        .js-dark #retail_grey-accrordion .vac_accordion_set.active .vac_chevron svg {stroke:#D7DBE4;} */

            #retail_grey-accrordion .vac_accordion_set.active .vac_ac_icon_border {
                background: #F2F5FA;
            }

            .js-dark #retail_grey-accrordion .vac_accordion_set.active {
                background: #262A30;
                border: none !important;
            }

            #retail_grey-accrordion .vac_padd-accordion_video .vac_accordion_video img {
                max-height: 300px;
            }

            #retail_grey-accrordion .vac_accordion_sets{margin-top: 30px;}

            /* retail accordion dark theme */



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

            /* White/Black Theme Images */
            .vac_accordion_wrap .white-theme-img {
                display: block;
                /* width: 44px; */
            }

            .vac_accordion_wrap .black-theme-img {
                display: none;
            }

            .js-dark .vac_accordion_wrap .white-theme-img {
                display: none;
            }

            .js-dark .vac_accordion_wrap .black-theme-img {
                display: block;
            }

            @media (max-width: 576px) {
                .vac_accordion_wrap {
                    padding: 40px 0;
                }

                .vac_padd-accordion_video {
                    display: none;
                }

                .vac_main_title {
                    margin-bottom: 0;
                }

                .vac_vertical_scroller {
                    margin: 0;
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
                    font-size: 14px;
                    margin-left: 38px;
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
                    margin: 8px 15px 8px 58px;
                    font-size: 12px;
                }

                .vac_accontent .vac_accordion_video p {
                    margin: 8px 0px 8px 0;
                }

                .vac_accordion_set {
                    ;
                    padding: 20px 20px;
                }

                .vac_ac_icon_wrap {
                    top: 10px;
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

                .js-dark .vac_accontent .vac_accordion_video .card {
                    background: #262a30;
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
                    padding: 10px;
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

                .js-dark .vac_accontent .vac_accordion_video .badge-custom {
                    background: rgba(255, 255, 255, 0.1);
                    color: #fff;
                }

                .vac_padd-accordion_video>h3,
                .vac_padd-accordion>h3 {
                    font-size: 16px !important;
                    position: static;
                }

                .vac_accordion_wrap .custom-container {
                    overflow-x: visible;
                }

                #white_bg-conatainer .custom-container {
                    padding: 20px;
                }

                .vac_chevron {
                    top: auto;
                }

            }
        </style>

        <section class="vac_accordion_wrap">
            <div class="custom-container radius-8">

                <?php if (!empty($section_title) || !empty($section_description)): ?>
                    <div class="col-md-6 col-12">
                        <div class="vac_main_title_box">
                            <?php if (!empty($section_title)): ?>
                                <h2 class="vac_main_title vac-title">
                                    <?php echo esc_html($section_title); ?>
                                </h2>
                            <?php endif; ?>
                            <?php if (!empty($section_description)): ?>
                                <p><?php echo wp_kses_post($section_description); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row g-0  vac_vertical_scroller">
                    <div class="col-md-6 col-12 vac_padd-accordion">
                        <?php if (!empty($left_block_title)): ?>
                            <h3><?php echo esc_html($left_block_title); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($accordion_items)): ?>
                            <div class="vac_accordion_sets">
                                <?php foreach ($accordion_items as $index => $item): ?>
                                    <?php
                                    $item_title = !empty($item['item_title']) ? $item['item_title'] : '';
                                    $item_short_desc = !empty($item['item_short_description']) ? $item['item_short_description'] : '';
                                    $item_short_desc_icon_default = !empty($item['item_short_desc_icon_default']['url']) ? $item['item_short_desc_icon_default']['url'] : '';
                                    $item_short_desc_icon_default_alt = !empty($item['item_short_desc_icon_default']['alt']) ? $item['item_short_desc_icon_default']['alt'] : $item_title;
                                    $item_short_desc_icon_dark = !empty($item['item_short_desc_icon_dark']['url']) ? $item['item_short_desc_icon_dark']['url'] : $item_short_desc_icon_default;
                                    $item_short_desc_icon_dark_alt = !empty($item['item_short_desc_icon_dark']['alt']) ? $item['item_short_desc_icon_dark']['alt'] : $item_short_desc_icon_default_alt;
                                    $item_details_image_default = !empty($item['item_details_image_default']['url']) ? $item['item_details_image_default']['url'] : '';
                                    $item_details_image_default_alt = !empty($item['item_details_image_default']['alt']) ? $item['item_details_image_default']['alt'] : $item_title;
                                    $item_details_image_dark = !empty($item['item_details_image_dark']['url']) ? $item['item_details_image_dark']['url'] : $item_details_image_default;
                                    $item_details_image_dark_alt = !empty($item['item_details_image_dark']['alt']) ? $item['item_details_image_dark']['alt'] : $item_details_image_default_alt;
                                    $item_detail_title = !empty($item['item_detail_title']) ? $item['item_detail_title'] : '';
                                    $item_detail_description = !empty($item['item_detail_description']) ? $item['item_detail_description'] : '';
                                    $item_tags = !empty($item['item_tags']) ? $item['item_tags'] : [];
                                    $is_first = $index === 0;
                                    ?>
                                    <div class="vac_accordion_set <?php echo $is_first ? 'active' : ''; ?>">
                                        <?php if (!empty($item_short_desc_icon_default)): ?>
                                            <div class="vac_ac_icon_wrap">
                                                <div class="vac_ac_icon_border">
                                                    <span>
                                                        <img class="vac_ac_icon white-theme-img"
                                                            src="<?php echo esc_url($item_short_desc_icon_default); ?>"
                                                            alt="<?php echo esc_attr($item_short_desc_icon_default_alt); ?>" width="40"
                                                            height="40">
                                                        <img class="vac_ac_icon black-theme-img"
                                                            src="<?php echo esc_url($item_short_desc_icon_dark); ?>"
                                                            alt="<?php echo esc_attr($item_short_desc_icon_dark_alt); ?>" width="40"
                                                            height="40">
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <button class="vac_select_div"
                                            aria-label="expand accordion section for <?php echo esc_attr($item_title); ?>"
                                            aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>">
                                            <?php if (!empty($item_title)): ?>
                                                <h2 class="vac_ac_header">
                                                    <?php echo esc_html($item_title); ?>
                                                </h2>
                                            <?php endif; ?>
                                            <span class="vac_chevron">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </span>
                                        </button>
                                        <div class="vac_accontent">
                                            <?php if (!empty($item_short_desc)): ?>
                                                <p class="vac-description">
                                                    <?php echo wp_kses_post($item_short_desc); ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if (!empty($item_details_image_default) || !empty($item_detail_title) || !empty($item_detail_description) || !empty($item_tags)): ?>
                                                <div class="vac_accordion_video">
                                                    <div class="card h-100 border-0 shadow-sm">
                                                        <?php if (!empty($item_details_image_default)): ?>
                                                            <div class="card-image">
                                                                <img decoding="async" src="<?php echo esc_url($item_details_image_default); ?>"
                                                                    class="card-img-top h-100 white-theme-img"
                                                                    alt="<?php echo esc_attr($item_details_image_default_alt); ?>">
                                                                <img decoding="async" src="<?php echo esc_url($item_details_image_dark); ?>"
                                                                    class="card-img-top h-100 black-theme-img"
                                                                    alt="<?php echo esc_attr($item_details_image_dark_alt); ?>">
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($item_detail_title) || !empty($item_detail_description) || !empty($item_tags)): ?>
                                                            <div class="card-body">
                                                                <?php if (!empty($item_detail_title)): ?>
                                                                    <h5 class="card-title"><?php echo esc_html($item_detail_title); ?></h5>
                                                                <?php endif; ?>
                                                                <?php if (!empty($item_detail_description)): ?>
                                                                    <p class="card-text text-muted">
                                                                        <?php echo wp_kses_post($item_detail_description); ?>
                                                                    </p>
                                                                <?php endif; ?>
                                                                <?php if (!empty($item_tags)): ?>
                                                                    <div class="d-flex flex-wrap gap-2 mt-4">
                                                                        <?php foreach ($item_tags as $tag): ?>
                                                                            <?php $tag_text = !empty($tag['tag_text']) ? $tag['tag_text'] : ''; ?>
                                                                            <?php if (!empty($tag_text)): ?>
                                                                                <span class="badge-custom"><?php echo esc_html($tag_text); ?></span>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="vac_progress_bar"></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                    <?php if (!empty($accordion_items)): ?>
                        <div class="col-md-6 col-12 vac_padd-accordion_video">
                            <?php if (!empty($right_block_title)): ?>
                                <h3><?php echo esc_html($right_block_title); ?></h3>
                            <?php endif; ?>
                            <?php foreach ($accordion_items as $index => $item): ?>
                                <?php
                                $item_details_image_default = !empty($item['item_details_image_default']['url']) ? $item['item_details_image_default']['url'] : '';
                                $item_details_image_default_alt = !empty($item['item_details_image_default']['alt']) ? $item['item_details_image_default']['alt'] : (!empty($item['item_title']) ? $item['item_title'] : '');
                                $item_details_image_dark = !empty($item['item_details_image_dark']['url']) ? $item['item_details_image_dark']['url'] : $item_details_image_default;
                                $item_details_image_dark_alt = !empty($item['item_details_image_dark']['alt']) ? $item['item_details_image_dark']['alt'] : $item_details_image_default_alt;
                                $item_detail_title = !empty($item['item_detail_title']) ? $item['item_detail_title'] : '';
                                $item_detail_description = !empty($item['item_detail_description']) ? $item['item_detail_description'] : '';
                                $item_tags = !empty($item['item_tags']) ? $item['item_tags'] : [];
                                $is_first = $index === 0;
                                ?>
                                <?php if (!empty($item_details_image_default) || !empty($item_detail_title) || !empty($item_detail_description) || !empty($item_tags)): ?>
                                    <div class="vac_accordion_video <?php echo $is_first ? 'vac_active' : ''; ?>">
                                        <li>
                                            <div class="card h-100 border-0 shadow-sm">
                                                <?php if (!empty($item_details_image_default)): ?>
                                                    <div class="card-image">
                                                        <img decoding="async" src="<?php echo esc_url($item_details_image_default); ?>"
                                                            class="card-img-top h-100 white-theme-img"
                                                            alt="<?php echo esc_attr($item_details_image_default_alt); ?>">
                                                        <img decoding="async" src="<?php echo esc_url($item_details_image_dark); ?>"
                                                            class="card-img-top h-100 black-theme-img"
                                                            alt="<?php echo esc_attr($item_details_image_dark_alt); ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($item_detail_title) || !empty($item_detail_description) || !empty($item_tags)): ?>
                                                    <div class="card-body">
                                                        <?php if (!empty($item_detail_title)): ?>
                                                            <h5 class="card-title"><?php echo esc_html($item_detail_title); ?></h5>
                                                        <?php endif; ?>
                                                        <?php if (!empty($item_detail_description)): ?>
                                                            <p class="card-text text-muted">
                                                                <?php echo wp_kses_post($item_detail_description); ?>
                                                            </p>
                                                        <?php endif; ?>
                                                        <?php if (!empty($item_tags)): ?>
                                                            <div class="d-flex flex-wrap gap-2 mt-4">
                                                                <?php foreach ($item_tags as $tag): ?>
                                                                    <?php $tag_text = !empty($tag['tag_text']) ? $tag['tag_text'] : ''; ?>
                                                                    <?php if (!empty($tag_text)): ?>
                                                                        <span class="badge-custom"><?php echo esc_html($tag_text); ?></span>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>



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
<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Custom_Tab_Section extends Widget_Base
{
    public function get_name()
    {
        return 'custom_tab_section';
    }
    public function get_title()
    {
        return 'Custom Tab Section';
    }
    public function get_icon()
    {
        return 'eicon-tabs';
    }
    public function get_categories()
    {
        return ['general'];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content Settings', 'repindia'),
            ]
        );

        // Main repeater for tabs
        $repeater = new \Elementor\Repeater();

        // Tab Icon/Image (Default Theme)
        $repeater->add_control(
            'tab_icon_default',
            [
                'label' => esc_html__('Tab Icon/Image (Default Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Tab Icon/Image (Dark Theme)
        $repeater->add_control(
            'tab_icon_dark',
            [
                'label' => esc_html__('Tab Icon/Image (Dark Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default icon for dark theme', 'repindia'),
            ]
        );

        // Tab Name
        $repeater->add_control(
            'tab_name',
            [
                'label' => esc_html__('Tab Name', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Content Title
        $repeater->add_control(
            'content_title',
            [
                'label' => esc_html__('Content Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Content Description
        $repeater->add_control(
            'content_description',
            [
                'label' => esc_html__('Content Description', 'repindia'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Content CTA Text
        $repeater->add_control(
            'content_cta_text',
            [
                'label' => esc_html__('Content CTA Text', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Content CTA URL
        $repeater->add_control(
            'content_cta_url',
            [
                'label' => esc_html__('Content CTA URL', 'repindia'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
            ]
        );

        // Content CTA Classes
        $repeater->add_control(
            'content_cta_classes',
            [
                'label' => esc_html__('Content CTA Classes', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__('Add custom CSS classes for the Content CTA link (separate multiple classes with spaces)', 'repindia'),
                'label_block' => true,
            ]
        );

        // Content Image (Default Theme)
        $repeater->add_control(
            'content_image_default',
            [
                'label' => esc_html__('Content Image (Default Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        // Content Image (Dark Theme)
        $repeater->add_control(
            'content_image_dark',
            [
                'label' => esc_html__('Content Image (Dark Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
            ]
        );

        $this->add_control(
            'tab_items',
            [
                'label' => esc_html__('Tab Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ tab_name }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $tab_items = !empty($settings['tab_items']) ? $settings['tab_items'] : [];

        // Get first tab name for dropdown label
        $first_tab_name = !empty($tab_items[0]['tab_name']) ? $tab_items[0]['tab_name'] : 'Security Features'; ?>
        <style>
            /* Tab Navigation */
            .sec-tabs-nav {
                margin-bottom: 0;
            }

            .sec-tabs-list {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                gap: 20px;
            }

            .sec-tab-item {
                display: flex;
                flex-direction: column;
                gap: 12px;
                padding: 20px;
                cursor: pointer;
                transition: all 0.3s ease;
                width: 20%;
                border-radius: var(--M, 12px);
                border: 1px solid var(--Golbal-others-border-3, #D7DBE4);
                background: var(--Golbal-backgrounds-global-bg-3, #F2F5FA);
                margin-bottom: 20px;
            }

            .sec-tab-item:hover {
                background: #e8ecf1;
            }

            .sec-tab-item.active {
                border-radius: var(--M, 12px) var(--M, 12px) var(--NA, 0) var(--NA, 0);
                background: #FFFFFF;
                border: 1px solid #fff;
                margin-bottom: 0 !important;
                position: relative;
            }
            .sec-tab-item.active:after {
    position: absolute;
    content: '';
    left: -20px;
    bottom: -1px;
  width: 20px;
  height: 20px;
  background-color: white;
  -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath d='M20 0C20 11.0457 11.0457 20 0 20H20V0Z' fill='black'/%3E%3C/svg%3E");
  -webkit-mask-size: contain;
  -webkit-mask-repeat: no-repeat;
  mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath d='M20 0C20 11.0457 11.0457 20 0 20H20V0Z' fill='black'/%3E%3C/svg%3E");
  mask-size: contain;
  mask-repeat: no-repeat;
}
            .sec-tab-item.active:before {
    position: absolute;
    content: '';
    width: 20px;
    height: 20px;
    right: -20px;
    bottom: -1px;
    background-color: #ffffff;
    -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath d='M0 0C0 11.0457 8.95431 20 20 20H0V0Z' fill='black'/%3E%3C/svg%3E");
  -webkit-mask-size: contain;
  -webkit-mask-repeat: no-repeat;
  mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3E%3Cpath d='M0 0C0 11.0457 8.95431 20 20 20H0V0Z' fill='black'/%3E%3C/svg%3E");
  mask-size: contain;
  mask-repeat: no-repeat;
}
.sec-tab-item.active:last-child:before, .sec-tab-item.active:first-child:after{
    visibility: hidden;
}
.sec-tab-panel.active#secPanel0 .sec-panel-inner, .sec-tab-panel.active#secPanel4 .sec-panel-inner {
    border-radius: 0;
}

.js-dark .sec-tab-item.active:before, .js-dark .sec-tab-item.active:after {
    background-color: #262a30;
}

.js-dark .sec-tab-item {
    background: transparent;
    border: 1px solid rgb(193 196 198 / 20%);
}
.js-dark .sec-tab-item.active {
    background: #262a30;
    border: none;
}
            .sec-tab-icon {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                flex-shrink: 0;
            }

            .sec-tab-icon svg {
                width: 40px;
                height: 40px;
                color: #06283D;

            }

            .sec-tab-item:not(.active) .sec-tab-icon svg {
                color: #5F6F94;
            }

            .sec-tab-item.active .sec-tab-icon {
                color: #fff;
            }

            .sec-tab-text {
                color: var(--Golbal-text-text-3, #5C5C5C);
                font-size: 16px;
                font-weight: 500;
                line-height: 150%;
            }

            .sec-tab-item.active .sec-tab-text {
                color: #06283D;
            }

            /* Tab Content Panels */
            .sec-tabs-content {
                position: relative;
            }

            .sec-tab-panel {
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .sec-tab-panel.active {
                display: block;
                opacity: 1;
            }

            .sec-panel-inner {
                display: flex;
                gap: 20px;
                border-radius:12px;
                background: #FFF;
                padding: 80px;
                align-items: center;
                flex-direction: row-reverse;
            }

            .sec-panel-image {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .sec-panel-image img {
                width: 100%;
                height: auto;
                border-radius: 12px;
            }

            .sec-panel-text {
                flex: 1;
            }

            .sec-panel-text h4 {
                color: var(--Golbal-text-text-1, #06283D);
                font-size: 28px;
                font-style: normal;
                font-weight: 600;
                line-height: 122%;
                margin-bottom: 0;
            }

            .sec-panel-text p {
                font-size: 18px;
                font-weight: 400;
                line-height: 144.444%;
                margin: 12px 0;
            }

            .sec-panel-btn {
                display: inline-block;
                padding: 12px 24px;
                background: transparent;
                border: 1px solid #0073aa;
                color: #0073aa;
                text-decoration: none;
                border-radius: 6px;
                font-weight: 500;
                transition: all 0.3s ease;
                margin-top: 10px;
            }

            .sec-panel-btn:hover {
                background: #0073aa;
                color: #fff;
            }

            /* Dropdown label and select-brand - hidden on desktop */
            .sec-dropdown-label,
            .sec-select-brand {
                display: none;
            }

            /* Mobile styles for dropdown (up to 1024px) */
            @media (max-width: 1024px) {
                .sec-tabs-nav {
                    margin-bottom: 30px;
                    position: relative;
                }

                .sec-dropdown-label {
                    display: inline-block;
                    font-size: 18px;
                    font-family: Geometria-Medium, sans-serif;
                    padding-right: 15px;
                    color: #000000;
                    display: none;
                }

                .sec-select-brand {
                    display: inline-block;
                    color: #06283d;
                    font-size: 18px;
                    cursor: pointer;
                    position: relative;
                    border: 1px solid #e5e9ec;
                    padding: 8px 12px;
                    width: 100%;
                    border-radius: 8px;
                    background: #ffffff;
                }

                .sec-select-brand:after {
                    content: "";
                    position: absolute;
                    right: 20px;
                    top: 15px;
                    width: 8px;
                    height: 8px;
                    display: inline-block;
                    border-right: 1.5px solid #06283D;
                    border-bottom: 1.5px solid #06283D;
                    transform: rotate(45deg);
                    -webkit-transition: transform 0.4s ease-in-out;
                    -moz-transition: transform 0.4s ease-in-out;
                    -ms-transition: transform 0.4s ease-in-out;
                    -o-transition: transform 0.4s ease-in-out;
                    transition: transform 0.4s ease-in-out;
                }

                .sec-select-brand.angle-icon:after {
                    transform: rotate(225deg);
                }

                .sec-tabs-list {
                    display: none;
                    position: absolute;
                    left: 0;
                    top: 100%;
                    bottom: auto;
                    z-index: 1000;
                    background: #fff;
                    width: 100%;
                    border-radius: 0;
                    -webkit-box-shadow: 0 1px 2px -2px #000000a1;
                    -moz-box-shadow: 0 1px 2px -2px #000000a1;
                    box-shadow: 0 1px 2px -2px #000000ed;
                    margin-top: 10px;
                    border: 1px solid #e6ebf2;
                    padding: 0;
                    white-space: normal;
                    overflow: visible;
                    /* max-height: 400px; */
                    overflow-y: auto;
                    flex-direction: column;
                    gap: 0;
                }

                .sec-tabs-list.show-dropdown {
                    display: flex;
                    border: rgba(193, 196, 198, 0.1) !important;
                }

                .sec-tab-item {
                    display: block;
                    width: 100%;
                    margin-right: 0;
                    margin-bottom: 0;
                    padding: 12px 15px;
                    border-bottom: 1px solid #e6ebf2;
                    border-radius: 0;
                    border-left: none;
                    border-right: none;
                    border-top: none;
                    flex-direction: row;
                    gap: 12px;
                }

                .sec-tab-item:last-child {
                    border-bottom: none;
                }

                .sec-tab-item.active {
                    border-radius: 0;
                    margin-bottom: 0;
                    border-bottom: 1px solid #e6ebf2;
                }

                .sec-panel-inner {
                    flex-direction: column;
                    border-radius: 8px !important;
                }

                .sec-panel-image {
                    flex: 0 0 100%;
                    max-width: 100%;
                }

                .js-dark .sec-select-brand {
                    border: 1px solid rgba(193, 196, 198, 0.1);
                    background: #262a30;
                }

                .js-dark .sec-select-brand:after {
                    border-right-color: #d7dbe4;
                    border-bottom-color: #d7dbe4;
                }

                .js-dark .sec-tabs-list {
                    background: #262a30;
                    border: 1px solid rgba(193, 196, 198, 0.1);
                }

            }

            /* Desktop styles - show tabs, hide dropdown */
            @media (min-width: 1025px) {
                .sec-tabs-list {
                    display: flex !important;
                }

                .sec-dropdown-label,
                .sec-select-brand {
                    display: none !important;
                }
            }

            /* White/Black Theme Images */
            .sec-tabs-wrapper .white_theme_img,
            .sec-tabs-wrapper .white-theme-img {
                display: block;
            }

            .sec-tabs-wrapper .black_theme_img,
            .sec-tabs-wrapper .black-theme-img {
                display: none;
            }

            .js-dark .sec-tabs-wrapper .white_theme_img,
            .js-dark .sec-tabs-wrapper .white-theme-img {
                display: none;
            }

            .js-dark .sec-tabs-wrapper .black_theme_img,
            .js-dark .sec-tabs-wrapper .black-theme-img {
                display: block;
            }

            /* Tab Icon Images */
            .sec-tab-icon img {
                width: 40px;
                height: 40px;
                object-fit: contain;
            }
            @media(max-width: 768px){
                .sec-panel-text h4{ font-size: 20px; }
                .sec-panel-text p{ font-size: 16px; }
                .sec-tabs-list .sec-tab-item{ display: flex;align-items: center; }
                .sec-tab-text { line-height: normal; }
                .sec-tabs-list.show-dropdown { box-shadow: 0 0 10px rgba(0, 82, 128, 0.1);border-bottom: 1px solid #000 !important;border-radius: 12px;margin: 0;padding-top: 0; }
                .sec-select-brand{ padding: 8px 30px 8px 15px; }
                .sec-select-brand:after{ right: 10px;top: 40%; }
            }
        </style>

        <div class="sec-tabs-wrapper">
            <!-- Tab Navigation -->
            <div class="sec-tabs-nav">
                <label class="sec-dropdown-label">Security Features</label>
                <span class="sec-select-brand"><?php echo esc_html($first_tab_name); ?></span>
                <ul class="sec-tabs-list">
                    <?php if (!empty($tab_items)): ?>
                        <?php foreach ($tab_items as $index => $item): ?>
                            <?php
                            $panel_id = 'secPanel' . $index;
                            $is_first = $index === 0;
                            $tab_class = $is_first ? 'sec-tab-item active' : 'sec-tab-item';

                            $tab_icon_default = !empty($item['tab_icon_default']['url']) ? $item['tab_icon_default']['url'] : '';
                            $tab_icon_dark = !empty($item['tab_icon_dark']['url']) ? $item['tab_icon_dark']['url'] : $tab_icon_default;
                            $tab_icon_alt = !empty($item['tab_icon_default']['alt']) ? $item['tab_icon_default']['alt'] : '';
                            $tab_name = !empty($item['tab_name']) ? $item['tab_name'] : '';
                            ?>
                            <li class="<?php echo esc_attr($tab_class); ?>" data-target="<?php echo esc_attr($panel_id); ?>">
                                <span class="sec-tab-icon">
                                    <?php if (!empty($tab_icon_default)): ?>
                                        <img class="white_theme_img" src="<?php echo esc_url($tab_icon_default); ?>"
                                            alt="<?php echo esc_attr($tab_icon_alt); ?>">
                                        <img class="black_theme_img" src="<?php echo esc_url($tab_icon_dark); ?>"
                                            alt="<?php echo esc_attr($tab_icon_alt); ?>">
                                    <?php endif; ?>
                                </span>
                                <span class="sec-tab-text"><?php echo esc_html($tab_name); ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Tab Content Panels -->
            <div class="sec-tabs-content">
                <?php if (!empty($tab_items)): ?>
                    <?php foreach ($tab_items as $index => $item): ?>
                        <?php
                        $panel_id = 'secPanel' . $index;
                        $is_first = $index === 0;
                        $panel_class = $is_first ? 'sec-tab-panel active' : 'sec-tab-panel';

                        $content_image_default = !empty($item['content_image_default']['url']) ? $item['content_image_default']['url'] : '';
                        $content_image_dark = !empty($item['content_image_dark']['url']) ? $item['content_image_dark']['url'] : $content_image_default;
                        $content_image_alt = !empty($item['content_image_default']['alt']) ? $item['content_image_default']['alt'] : '';

                        $content_title = !empty($item['content_title']) ? $item['content_title'] : '';
                        $content_description = !empty($item['content_description']) ? $item['content_description'] : '';

                        $content_cta_text = !empty($item['content_cta_text']) ? $item['content_cta_text'] : '';
                        $content_cta_url = !empty($item['content_cta_url']['url']) ? $item['content_cta_url']['url'] : '#';
                        $content_cta_target = !empty($item['content_cta_url']['is_external']) ? 'target="_blank"' : '';
                        $content_cta_nofollow = !empty($item['content_cta_url']['nofollow']) ? 'rel="nofollow"' : '';
                        $content_cta_classes = !empty($item['content_cta_classes']) ? ' ' . esc_attr($item['content_cta_classes']) : '';
                        ?>
                        <div class="<?php echo esc_attr($panel_class); ?>" id="<?php echo esc_attr($panel_id); ?>">
                            <div class="sec-panel-inner">
                                <?php if (!empty($content_image_default)): ?>
                                    <div class="sec-panel-image">
                                        <img class="white_theme_img" src="<?php echo esc_url($content_image_default); ?>"
                                            alt="<?php echo esc_attr($content_image_alt); ?>">
                                        <img class="black_theme_img" src="<?php echo esc_url($content_image_dark); ?>"
                                            alt="<?php echo esc_attr($content_image_alt); ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="sec-panel-text">
                                    <?php if (!empty($content_title)): ?>
                                        <h4><?php echo wp_kses_post($content_title); ?></h4>
                                    <?php endif; ?>
                                    <?php if (!empty($content_description)): ?>
                                        <p> <?php echo wp_kses_post($content_description); ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($content_cta_text)): ?>
                                        <div class="text-left">
                                            <a href="<?php echo esc_url($content_cta_url); ?>" class="theme-btn bg-trans border_btnlight<?php echo $content_cta_classes; ?>"
                                                <?php echo esc_attr($content_cta_target); ?>                     <?php echo esc_attr($content_cta_nofollow); ?>><?php echo esc_html($content_cta_text); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Simple Tab Switching for Security Tabs
                var secTabs = document.querySelectorAll('.sec-tab-item');
                var secPanels = document.querySelectorAll('.sec-tab-panel');
                var secSelectBrand = document.querySelector('.sec-select-brand');
                var secTabsList = document.querySelector('.sec-tabs-list');

                secTabs.forEach(function (tab) {
                    tab.addEventListener('click', function () {
                        var targetId = this.getAttribute('data-target');
                        var tabText = this.querySelector('.sec-tab-text') ? this.querySelector('.sec-tab-text').textContent.trim() : '';

                        // Remove active class from all tabs
                        secTabs.forEach(function (t) {
                            t.classList.remove('active');
                        });

                        // Remove active class from all panels
                        secPanels.forEach(function (p) {
                            p.classList.remove('active');
                        });

                        // Add active class to clicked tab
                        this.classList.add('active');

                        // Add active class to target panel
                        var targetPanel = document.getElementById(targetId);
                        if (targetPanel) {
                            targetPanel.classList.add('active');
                        }

                        // Update select-brand text on mobile
                        if (window.innerWidth <= 1024 && secSelectBrand && tabText) {
                            secSelectBrand.textContent = tabText;
                        }

                        // Close dropdown on mobile after selection
                        if (window.innerWidth <= 1024 && secSelectBrand && secTabsList) {
                            secSelectBrand.classList.remove('angle-icon');
                            secTabsList.classList.remove('show-dropdown');
                        }
                    });
                });

                // Mobile dropdown functionality
                if (secSelectBrand && secTabsList) {
                    secSelectBrand.addEventListener('click', function () {
                        if (window.innerWidth <= 1024) {
                            this.classList.toggle('angle-icon');
                            secTabsList.classList.toggle('show-dropdown');
                        }
                    });
                }
            });
        </script>
        <?php
    }
}

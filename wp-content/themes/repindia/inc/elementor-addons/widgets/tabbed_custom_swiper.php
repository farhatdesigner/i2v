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

class Tabbed_Custom_Swiper extends Widget_Base
{
    public function get_name()
    {
        return 'tabbed_custom_swiper';
    }

    public function get_title()
    {
        return 'Tabbed Custom Swiper';
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
        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Content Settings',
            ]
        );

        // Repeater for Tabs
        $tab_repeater = new Repeater();

        // Tab Title
        $tab_repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__('Tab Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Tab Title',
                'label_block' => true,
            ]
        );

        // Nested Repeater for Content Items
        $content_repeater = new Repeater();

        $content_repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Item Title',
                'label_block' => true,
            ]
        );

        $content_repeater->add_control(
            'item_description',
            [
                'label' => esc_html__('Description', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Item description text here.',
                'label_block' => true,
            ]
        );

        $content_repeater->add_control(
            'item_image_default',
            [
                'label' => esc_html__('Image (Default Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $content_repeater->add_control(
            'item_image_dark',
            [
                'label' => esc_html__('Image (Dark Theme)', 'repindia'),
                'type' => Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
            ]
        );

        $tab_repeater->add_control(
            'tab_content_items',
            [
                'label' => esc_html__('Content Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $content_repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => 'Item 1',
                        'item_description' => 'Description for item 1',
                    ],
                    [
                        'item_title' => 'Item 2',
                        'item_description' => 'Description for item 2',
                    ],
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->add_control(
            'tabs_list',
            [
                'label' => esc_html__('Tabs', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $tab_repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => 'Government & institutional bodies',
                        'tab_content_items' => [
                            [
                                'item_title' => 'Smart city mission teams',
                                'item_description' => 'Deploying city-wide surveillance and traffic automation.',
                            ],
                            [
                                'item_title' => 'Urban planners',
                                'item_description' => 'Designing safer, smarter infrastructure.',
                            ],
                        ],
                    ],
                    [
                        'tab_title' => 'Private sector innovators & integrators',
                        'tab_content_items' => [
                            [
                                'item_title' => 'Industrial safety',
                                'item_description' => 'Monitoring workplace compliance and safety.',
                            ],
                            [
                                'item_title' => 'Retail analytics',
                                'item_description' => 'Customer behavior and store optimization.',
                            ],
                        ],
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => 'Style',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'repindia'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
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
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-accordion-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // PHP Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $tabs_list = $settings['tabs_list'];

        if (empty($tabs_list)) {
            return;
        }

        // Generate unique ID for this widget instance
        $widget_id = 'tabbedSliderWrapper_' . $this->get_id();

        // Helper function to get image URL
        $get_image_url = function($image, $default_image = '') {
            if (!empty($image['url'])) {
                return esc_url($image['url']);
            }
            return $default_image;
        };

        // Check for dark theme (you can customize this based on your theme's dark mode detection)
        $is_dark_theme = false;
        // Check if body has dark mode class or data attribute
        if (isset($_GET['dark_mode']) || (function_exists('get_theme_mod') && get_theme_mod('dark_mode_enabled', false))) {
            $is_dark_theme = true;
        }
        ?>

        <style>
            #tabbedSliderWrapper .tabbed-slider-tabs {
                display: flex;
                margin-bottom: 20px;
            }

            #tabbedSliderWrapper .tab-btn {
                color: #4A5673;
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.3s ease;
                /*  border-radius: 0 100px 100px 0; */
                border: 1px solid #E6EBF2;
                background: #FFF;
                padding: 8px 20px;
            }

            #tabbedSliderWrapper .tab-btn:hover {
                background-color: #F2F5FA;
                color: #06283D;
            }

            #tabbedSliderWrapper .tab-btn.active {
                /* border-radius: var(--21XL, 100px) var(--NA, 0) var(--NA, 0) var(--21XL, 100px); */
                border: 1px solid #0099ED;
                background: #0099ED;
                color: #ffffff;
            }

            #tabbedSliderWrapper .tab-content {
                display: none;
            }

            #tabbedSliderWrapper .tab-content.active {
                display: block;
            }

            #tabbedSliderWrapper .swiper-slide {
                overflow: hidden;
                border-radius: 12px;
                width: 350px;
                display: flex;
                flex-direction: column;
                height: auto;
                                /* box-shadow: 0 10px 20px 0 rgba(0, 82, 128, 0.10); */
            }

            #tabbedSliderWrapper .swiper-slide img {
                width: 100%;
                height: 300px;
                object-fit: cover;
                border-radius: 12px 12px 0 0;
                flex-shrink: 0;
            }

            /* Dark theme image switching */
            #tabbedSliderWrapper .slide-image-dark {
                display: none !important;
            }

            body.dark-mode #tabbedSliderWrapper .slide-image-default,
            body[data-theme="dark"] #tabbedSliderWrapper .slide-image-default,
            html[data-theme="dark"] #tabbedSliderWrapper .slide-image-default {
                display: none !important;
            }

            body.dark-mode #tabbedSliderWrapper .slide-image-dark,
            body[data-theme="dark"] #tabbedSliderWrapper .slide-image-dark,
            html[data-theme="dark"] #tabbedSliderWrapper .slide-image-dark {
                display: block !important;
            }

            #tabbedSliderWrapper  .slide-content {
                padding: 24px;
                /* box-shadow: 0 10px 20px 0 rgba(0, 82, 128, 0.10); */
                background: #ffffff;
                margin-bottom: 10px;
                border-radius: 0 0 12px 12px;
                flex: 1;
                display: flex;
                flex-direction: column;
            }
            #tabbedSliderWrapper .slide-content{ min-height: 185px; }

            #tabbedSliderWrapper .slide-content h3 {
                font-size: 24px;
                margin: 0 0 8px 0;
                color: #06283D;
                line-height: 125%;

            }

      
#tabbedSliderWrapper .slide-content p {
    font-size: 18px;
    color: #666;
    margin: 0;
    min-height: 50px;
    line-height: 26px !important;
}


            #tabbedSliderWrapper .tabbed-slider-tabs .tab-btn:first-child {
                border-radius: 100px 0 0 100px;
            }

            .tabbed-slider-tabs .tab-btn:last-child {
                border-radius: 0 100px 100px 0;
            }

            #tabbedSliderWrapper .tabbed-slider-tabs .tab-btn:first-child.active {
                border-radius: var(--21XL, 100px) var(--NA, 0) var(--NA, 0) var(--21XL, 100px);
            }

            .tabbed-slider-tabs .tab-btn:last-child.active {
                border-radius: 0 100px 100px 0;
            }

            #tabbedSliderWrapper [aria-disabled="false"] .fill_disabled {
                fill: #5F6F94;
            }

            [aria-disabled="false"]:hover .stroke_enabled {
                stroke: #5F6F94;
            }

            
.js-dark #tabbedSliderWrapper [aria-disabled="false"] .fill_disabled {
    fill: #fff;
}

.js-dark #tabbedSliderWrapper .tab-btn.active {
                border: 1px solid #007ABE;
                background: #007ABE;
            }


@media (max-width: 767px) {

#tabbedSliderWrapper .tab-btn {font-size: 12px;line-height: 1.2;}    
#tabbedSliderWrapper .slide-content h3 {font-size: 18px;}
#tabbedSliderWrapper .slide-content p {font-size: 14px;}
#tabbedSliderWrapper .slide-content, #tabbedSliderWrapper .slide-content p{min-height: auto;}

/* Equal height cards on mobile - all cards match tallest card */
#tabbedSliderWrapper .swiper-wrapper {
    display: flex;
    align-items: stretch;
}
#tabbedSliderWrapper .swiper-slide {
    height: auto;
    display: flex;
    flex-direction: column;
    width: 100%;
}
#tabbedSliderWrapper .swiper-slide img {
    height: 200px;
    flex-shrink: 0;
}
#tabbedSliderWrapper .slide-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0;
}

}
        </style>

        <div class="tabbed-slider-wrapper" id="tabbedSliderWrapper">

            <!-- Tab Buttons -->
            <div class="tabbed-slider-tabs">
                <?php foreach ($tabs_list as $index => $tab): 
                    $tab_index = $index + 1;
                    $tab_id = 'tab' . $tab_index;
                    $is_first = ($index === 0);
                ?>
                    <button class="tab-btn <?php echo $is_first ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($tab_id); ?>">
                        <?php echo esc_html($tab['tab_title']); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Tab Content Areas -->
            <?php foreach ($tabs_list as $index => $tab): 
                $tab_index = $index + 1;
                $tab_id = 'tab' . $tab_index;
                $is_first = ($index === 0);
                
                // Get content items from nested repeater - try multiple access methods
                $content_items = [];
                
                // Method 1: Direct access
                if (isset($tab['tab_content_items']) && is_array($tab['tab_content_items'])) {
                    $content_items = $tab['tab_content_items'];
                }
                // Method 2: Check if stored as serialized string
                elseif (isset($tab['tab_content_items']) && is_string($tab['tab_content_items'])) {
                    $decoded = maybe_unserialize($tab['tab_content_items']);
                    if (is_array($decoded)) {
                        $content_items = $decoded;
                    }
                }
                // Method 3: Check alternative key names Elementor might use
                elseif (isset($tab['_tab_content_items']) && is_array($tab['_tab_content_items'])) {
                    $content_items = $tab['_tab_content_items'];
                }
            ?>
                <div class="tab-content <?php echo $is_first ? 'active' : ''; ?>" data-content="<?php echo esc_attr($tab_id); ?>">
                    <div class="swiper" id="tabbedSliderWrapper_slider<?php echo esc_attr($tab_index); ?>">
                        <div class="swiper-wrapper">
                            <?php foreach ($content_items as $item_index => $item): 
                                // Get both default and dark theme images
                                $default_image = isset($item['item_image_default']) ? $item['item_image_default'] : [];
                                $dark_image = isset($item['item_image_dark']) ? $item['item_image_dark'] : [];
                                
                                $default_image_url = $get_image_url($default_image);
                                $dark_image_url = $get_image_url($dark_image, $default_image_url);
                                
                                $item_title = isset($item['item_title']) ? $item['item_title'] : '';
                                $item_description = isset($item['item_description']) ? $item['item_description'] : '';
                            ?>
                                <div class="swiper-slide">
                                    <?php if (!empty($default_image_url)): ?>
                                        <img 
                                            src="<?php echo $default_image_url; ?>" 
                                            alt="<?php echo esc_attr($item_title); ?>"
                                            class="slide-image-default"
                                            <?php if (!empty($dark_image_url) && $dark_image_url !== $default_image_url): ?>
                                                data-dark-src="<?php echo esc_attr($dark_image_url); ?>"
                                            <?php endif; ?>
                                        >
                                        <?php if (!empty($dark_image_url) && $dark_image_url !== $default_image_url): ?>
                                            <img 
                                                src="<?php echo $dark_image_url; ?>" 
                                                alt="<?php echo esc_attr($item_title); ?>"
                                                class="slide-image-dark"
                                                style="display: none;"
                                            >
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="slide-content">
                                        <?php if (!empty($item_title)): ?>
                                            <h3><?php echo esc_html($item_title); ?></h3>
                                        <?php endif; ?>
                                        <?php if (!empty($item_description)): ?>
                                            <p><?php echo esc_html($item_description); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-next">
                            <?php //if ($tab_index == 1): ?>
                                <!-- <img src="<?php //echo esc_url(home_url('/')); ?>wp-content/themes/repindia/assets/images/icons/arrow-white.svg" alt="Next"> -->
                            <?php //else: ?>
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20C0.5 9.23045 9.23045 0.5 20 0.5Z"
                                        fill="white" />
                                    <path class="stroke_enabled"
                                        d="M20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20C0.5 9.23045 9.23045 0.5 20 0.5Z"
                                        stroke="#E5E9EC" />
                                    <path fill-rule="evenodd" class="fill_disabled" clip-rule="evenodd"
                                        d="M20.3259 13.6589C20.7598 13.225 21.4633 13.225 21.8972 13.6589L27.4528 19.2145C27.6611 19.4229 27.7782 19.7055 27.7782 20.0002C27.7782 20.2948 27.6611 20.5775 27.4528 20.7858L21.8972 26.3414C21.4633 26.7753 20.7598 26.7753 20.3259 26.3414C19.892 25.9075 19.892 25.204 20.3259 24.77L23.9846 21.1113L13.3338 21.1113C12.7201 21.1113 12.2227 20.6138 12.2227 20.0002C12.2227 19.3865 12.7201 18.8891 13.3338 18.8891L23.9846 18.8891L20.3259 15.2303C19.892 14.7964 19.892 14.0928 20.3259 13.6589Z"
                                        fill="#949494" />
                                </svg>
                            <?php //endif; ?>
                        </div>
                        <div class="swiper-button-prev">
                            <?php //if ($tab_index == 1): ?>
                                <!-- <img src="<?php //echo esc_url(home_url('/')); ?>wp-content/themes/repindia/assets/images/icons/arrow-white.svg" alt="Prev"> -->
                            <?php //else: ?>
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20C0.5 9.23045 9.23045 0.5 20 0.5Z"
                                        fill="white" />
                                    <path class="stroke_enabled"
                                        d="M20 0.5C30.7696 0.5 39.5 9.23045 39.5 20C39.5 30.7696 30.7696 39.5 20 39.5C9.23045 39.5 0.5 30.7696 0.5 20C0.5 9.23045 9.23045 0.5 20 0.5Z"
                                        stroke="#E5E9EC" />
                                    <path fill-rule="evenodd" class="fill_disabled" clip-rule="evenodd"
                                        d="M19.675 13.6589C20.1089 14.0928 20.1089 14.7964 19.675 15.2303L16.0162 18.8891L26.6671 18.8891C27.2808 18.8891 27.7782 19.3865 27.7782 20.0002C27.7782 20.6138 27.2807 21.1113 26.6671 21.1113L16.0162 21.1113L19.675 24.77C20.1089 25.204 20.1089 25.9075 19.675 26.3414C19.2411 26.7753 18.5376 26.7753 18.1036 26.3414L12.5481 20.7858C12.3397 20.5775 12.2227 20.2948 12.2227 20.0002C12.2227 19.7055 12.3397 19.4229 12.5481 19.2145L18.1036 13.6589C18.5376 13.225 19.2411 13.225 19.675 13.6589Z"
                                        fill="#949494" />
                                </svg>
                            <?php //endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <script>
            (function () {
                var swipers = {};

                function initTabbedSwiper() {
                    if (typeof Swiper === 'undefined') {
                        setTimeout(initTabbedSwiper, 100);
                        return;
                    }

                    var wrapper = document.getElementById('tabbedSliderWrapper');
                    if (!wrapper) return;

                    // Initialize all sliders
                    var tabContents = wrapper.querySelectorAll('.tab-content');
                    tabContents.forEach(function(tabContent) {
                        var swiperEl = tabContent.querySelector('.swiper');
                        if (swiperEl) {
                            var swiperId = swiperEl.getAttribute('id');
                            var tabIndex = swiperId.replace('tabbedSlider', '');
                            
                            swipers[swiperId] = new Swiper('#' + swiperId, {
                                slidesPerView: "auto",
                                spaceBetween: 20,
                                grabCursor: true,
                                navigation: {
                                    nextEl: '#' + swiperId + ' .swiper-button-next',
                                    prevEl: '#' + swiperId + ' .swiper-button-prev',
                                },
                                observer: true,
                                observeParents: true,
                                breakpoints: {
                                    640: {
                                        slidesPerView: "auto",
                                        spaceBetween: 20,
                                    },
                                    1024: {
                                        slidesPerView: "auto",
                                        spaceBetween: 20,
                                    },
                                },
                            });
                        }
                    });

                    // Tab click handler
                    var tabBtns = wrapper.querySelectorAll('.tab-btn');
                    var tabContents = wrapper.querySelectorAll('.tab-content');

                    tabBtns.forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            var tabId = this.getAttribute('data-tab');

                            // Remove active from all
                            tabBtns.forEach(function (b) { b.classList.remove('active'); });
                            tabContents.forEach(function (c) { c.classList.remove('active'); });

                            // Add active to clicked
                            this.classList.add('active');
                            var activeContent = wrapper.querySelector('[data-content="' + tabId + '"]');
                            if (activeContent) {
                                activeContent.classList.add('active');
                                
                                // Update swiper on tab change
                                setTimeout(function () {
                                    var swiperEl = activeContent.querySelector('.swiper');
                                    if (swiperEl) {
                                        var swiperId = swiperEl.getAttribute('id');
                                        if (swipers[swiperId]) {
                                            swipers[swiperId].update();
                                        }
                                    }
                                }, 100);
                            }
                        });
                    });
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initTabbedSwiper);
                } else {
                    initTabbedSwiper();
                }
            })();
        </script>

        <?php
    }
}
?>
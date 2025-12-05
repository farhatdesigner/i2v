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

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__('Section Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Video Accordion',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => esc_html__('Section Description', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Click on each accordion item to view the video content.',
                'label_block' => true,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'accordion_title',
            [
                'label' => esc_html__('Accordion Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Video Title',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'accordion_description',
            [
                'label' => esc_html__('Accordion Description', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Video description text here.',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'video_type',
            [
                'label' => esc_html__('Video Type', 'repindia'),
                'type' => Controls_Manager::SELECT,
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
                'type' => Controls_Manager::URL,
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
                'type' => Controls_Manager::URL,
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
                'type' => Controls_Manager::MEDIA,
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
                'type' => Controls_Manager::MEDIA,
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
                'type' => Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'accordion_list',
            [
                'label' => esc_html__('Accordion Items', 'repindia'),
                'type' => Controls_Manager::REPEATER,
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
                /* border-radius: var(--NA, 0) var(--21XL, 100px) var(--21XL, 100px) var(--NA, 0); */
                border: 1px solid #E6EBF2;
                background: #FFF;
                padding: 8px 20px;
            }

            #tabbedSliderWrapper .tab-btn.active {
                /* border-radius: var(--21XL, 100px) var(--NA, 0) var(--NA, 0) var(--21XL, 100px); */
                border: 1px solid #0099ED;
                background: #0099ED;
                color: #ffffff;
            }

            button.tab-btn.active[data-tab="tab1"] {
                border-radius: var(--21XL, 100px) var(--NA, 0) var(--NA, 0) var(--21XL, 100px);
            }

            button.tab-btn.active[data-tab="tab2"] {
                border-radius: var(--NA, 0) var(--21XL, 100px) var(--21XL, 100px) var(--NA, 0);
            }

            #tabbedSliderWrapper .tab-content {
                display: none;
            }

            #tabbedSliderWrapper .tab-content.active {
                display: block;
            }

            #tabbedSliderWrapper .swiper-slide {
                background: #fff;
                overflow: hidden;
                border-radius: 12px;
                width: 350px;
            }

            #tabbedSliderWrapper .swiper-slide img {
                width: 100%;
                height: 300px;
                object-fit: cover;
            }

            #tabbedSliderWrapper .slide-content {
                padding: 24px;
                box-shadow: 0 10px 20px 0 rgba(0, 82, 128, 0.10);
                margin-bottom: 10px;
                border-radius: 0 0 12px 12px;
            }

            #tabbedSliderWrapper .slide-content h3 {
                font-size: 24px;
                margin: 0 0 8px 0;
                color: #06283D;
                line-height: 125%;
            }

            #tabbedSliderWrapper .slide-content p {
                font-size: 14px;
                color: #666;
                margin: 0;
                min-height: 50px;
            }
        </style>

        <div class="tabbed-slider-wrapper" id="tabbedSliderWrapper">

            <!-- Tab Buttons -->
            <div class="tabbed-slider-tabs">
                <button class="tab-btn active" data-tab="tab1">Government & institutional bodies</button>
                <button class="tab-btn" data-tab="tab2">Private sector innovators & integrators</button>
            </div>

            <!-- Tab 1 Content - Slider 1 -->
            <div class="tab-content active" data-content="tab1">
                <div class="swiper" id="tabbedSlider1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="https://picsum.photos/400/200?random=1" alt="Slide 1">
                            <div class="slide-content">
                                <h3>Smart city mission teams</h3>
                                <p>Deploying city-wide surveillance and traffic automation.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://picsum.photos/400/200?random=2" alt="Slide 2">
                            <div class="slide-content">
                                <h3>Urban planners</h3>
                                <p>Designing safer, smarter infrastructure.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://picsum.photos/400/200?random=3" alt="Slide 3">
                            <div class="slide-content">
                                <h3>Traffic management</h3>
                                <p>Real-time traffic monitoring solutions.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://picsum.photos/400/200?random=4" alt="Slide 4">
                            <div class="slide-content">
                                <h3>Security teams</h3>
                                <p>Enhanced surveillance capabilities.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next"><img src="<?php echo esc_url(home_url('/')); ?>wp-content/themes/repindia/assets/images/icons/arrow-white.svg" alt="Next"></div>
                    <div class="swiper-button-prev"><img src="<?php echo esc_url(home_url('/')); ?>wp-content/themes/repindia/assets/images/icons/arrow-white.svg" alt="Prev"></div>
                </div>
            </div>

            <!-- Tab 2 Content - Slider 2 -->
            <div class="tab-content" data-content="tab2">
                <div class="swiper" id="tabbedSlider2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="https://picsum.photos/400/200?random=5" alt="Slide 1">
                            <div class="slide-content">
                                <h3>Industrial safety</h3>
                                <p>Monitoring workplace compliance and safety.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://picsum.photos/400/200?random=6" alt="Slide 2">
                            <div class="slide-content">
                                <h3>Retail analytics</h3>
                                <p>Customer behavior and store optimization.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://picsum.photos/400/200?random=7" alt="Slide 3">
                            <div class="slide-content">
                                <h3>Healthcare facilities</h3>
                                <p>Patient safety and access control.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://picsum.photos/400/200?random=8" alt="Slide 4">
                            <div class="slide-content">
                                <h3>Education sector</h3>
                                <p>Campus security and monitoring.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next"><img src="<?php echo esc_url(home_url('/')); ?>wp-content/themes/repindia/assets/images/icons/arrow-white.svg" alt="Next"></div>
                    <div class="swiper-button-prev"><img src="<?php echo esc_url(home_url('/')); ?>wp-content/themes/repindia/assets/images/icons/arrow-white.svg" alt="Prev"></div>
                </div>
            </div>

        </div>

        <script>
            (function () {
                var swiper1, swiper2;

                function initTabbedSwiper() {
                    if (typeof Swiper === 'undefined') {
                        setTimeout(initTabbedSwiper, 100);
                        return;
                    }

                    var wrapper = document.getElementById('tabbedSliderWrapper');
                    if (!wrapper) return;

                    // Initialize Slider 1
                    swiper1 = new Swiper('#tabbedSlider1', {
                        slidesPerView: "auto",
                        spaceBetween: 20,
                        grabCursor: true,
                        navigation: {
                            nextEl: '#tabbedSlider1 .swiper-button-next',
                            prevEl: '#tabbedSlider1 .swiper-button-prev',
                        },
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

                    // Initialize Slider 2
                    swiper2 = new Swiper('#tabbedSlider2', {
                        slidesPerView: "auto",
                        spaceBetween: 20,
                        grabCursor: true,
                        navigation: {
                            nextEl: '#tabbedSlider2 .swiper-button-next',
                            prevEl: '#tabbedSlider2 .swiper-button-prev',
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 20,
                            },
                        },
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
                            wrapper.querySelector('[data-content="' + tabId + '"]').classList.add('active');

                            // Update swiper on tab change
                            setTimeout(function () {
                                if (tabId === 'tab1' && swiper1) swiper1.update();
                                if (tabId === 'tab2' && swiper2) swiper2.update();
                            }, 100);
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
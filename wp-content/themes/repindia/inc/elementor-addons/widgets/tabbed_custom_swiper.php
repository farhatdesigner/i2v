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
        $settings = $this->get_settings_for_display();
        $uid = 'tabbedSwiper_' . $this->get_id();
        ?>

        <div class="swiper-container">
            <div class="swiper mySwiper right_slidertabbed" id="<?php echo esc_attr($uid); ?>">
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <img src="https://picsum.photos/400/200?random=1" alt="Slide 1">
                        <div class="slide-content">
                            <h3>Slide Title 1</h3>
                            <p>This is the description for slide 1. Add your content here.</p>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <img src="https://picsum.photos/400/200?random=2" alt="Slide 2">
                        <div class="slide-content">
                            <h3>Slide Title 2</h3>
                            <p>This is the description for slide 2. Add your content here.</p>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <img src="https://picsum.photos/400/200?random=3" alt="Slide 3">
                        <div class="slide-content">
                            <h3>Slide Title 3</h3>
                            <p>This is the description for slide 3. Add your content here.</p>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <img src="https://picsum.photos/400/200?random=4" alt="Slide 4">
                        <div class="slide-content">
                            <h3>Slide Title 4</h3>
                            <p>This is the description for slide 4. Add your content here.</p>
                        </div>
                    </div>

                    <!-- Slide 5 -->
                    <div class="swiper-slide">
                        <img src="https://picsum.photos/400/200?random=5" alt="Slide 5">
                        <div class="slide-content">
                            <h3>Slide Title 5</h3>
                            <p>This is the description for slide 5. Add your content here.</p>
                        </div>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>

                <!-- Navigation Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <script>
            (function() {
                var uid = '<?php echo esc_js($uid); ?>';
                
                function initTabbedSwiper() {
                    if (typeof Swiper === 'undefined') {
                        setTimeout(initTabbedSwiper, 100);
                        return;
                    }
                    
                    new Swiper("#" + uid, {
                        slidesPerView: 3,
                        spaceBetween: 20,
                        grabCursor: true,
                        pagination: {
                            el: "#" + uid + " .swiper-pagination",
                            clickable: true,
                        },
                        navigation: {
                            nextEl: "#" + uid + " .swiper-button-next",
                            prevEl: "#" + uid + " .swiper-button-prev",
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 30,
                            },
                        },
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
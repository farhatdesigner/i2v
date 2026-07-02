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

class Video_accordion extends Widget_Base
{
    public function get_name()
    {
        return 'video_accordion';
    }

    public function get_title()
    {
        return 'Video Accordion';
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

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__('Section Title', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_description',
            [
                'label' => esc_html__('Section Description', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_bottom_description',
            [
                'label' => esc_html__('Section Bottom Description', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_bottom_cta_text',
            [
                'label' => esc_html__('Section Bottom CTA Text', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_bottom_cta_url',
            [
                'label' => esc_html__('Section Bottom CTA URL', 'repindia'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'section_bottom_cta_classes',
            [
                'label' => esc_html__('Section Bottom CTA Classes', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__('Add custom CSS classes for the Section Bottom CTA link (separate multiple classes with spaces)', 'repindia'),
                'label_block' => true,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Item Title', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label' => esc_html__('Item Description', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_cta_text',
            [
                'label' => esc_html__('Item CTA Text', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_cta_url',
            [
                'label' => esc_html__('Item CTA URL', 'repindia'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $repeater->add_control(
            'item_cta_classes',
            [
                'label' => esc_html__('Item CTA Classes', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__('Add custom CSS classes for the Item CTA link (separate multiple classes with spaces)', 'repindia'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_video_thumbnail',
            [
                'label' => esc_html__('Video Thumbnail Image', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $repeater->add_control(
            'item_youtube_video_id',
            [
                'label' => esc_html__('YouTube Video ID', 'repindia'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'description' => esc_html__('Enter YouTube video ID only (e.g., 9xwazD5SyVg)', 'repindia'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_modal_video_url',
            [
                'label' => esc_html__('Modal Video URL', 'repindia'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'description' => esc_html__('Optional: if YouTube ID is empty, this URL will be used for the modal video (YouTube/Vimeo URL or direct .mp4/.webm).', 'repindia'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'accordion_icon',
            [
                'label' => esc_html__('Accordion Icon', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
            ]
        );

        $this->add_control(
            'accordion_list',
            [
                'label' => esc_html__('Accordion Items', 'repindia'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ item_title }}}',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => 'Style',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
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
                'type' => \Elementor\Controls_Manager::COLOR,
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
        $accordion_list = !empty($settings['accordion_list']) ? $settings['accordion_list'] : [];
        $section_title = !empty($settings['section_title']) ? $settings['section_title'] : '';
        $section_description = !empty($settings['section_description']) ? $settings['section_description'] : '';
        $section_bottom_description = !empty($settings['section_bottom_description']) ? $settings['section_bottom_description'] : '';
        $section_bottom_cta_text = !empty($settings['section_bottom_cta_text']) ? $settings['section_bottom_cta_text'] : '';
        $section_bottom_cta_url = !empty($settings['section_bottom_cta_url']['url']) ? $settings['section_bottom_cta_url']['url'] : '';
        $section_bottom_cta_target = !empty($settings['section_bottom_cta_url']['is_external']) ? 'target="_blank"' : '';
        $section_bottom_cta_nofollow = !empty($settings['section_bottom_cta_url']['nofollow']) ? 'rel="nofollow"' : '';
        $section_bottom_cta_classes = !empty($settings['section_bottom_cta_classes']) ? ' ' . esc_attr($settings['section_bottom_cta_classes']) : '';
        $this->add_inline_editing_attributes('custom_class', 'basic'); ?>


        <section class="accordion_wrap">
            <div class="custom-container radius-8 text-white">


                <div class="row g-0 align-items-center thene-bg vertical_scroller">
                    <div class="col-md-6 col-12 padd-accordion ">

                        <?php if (!empty($section_title) || !empty($section_description)): ?>
                            <div class="main_title_box">
                                <?php if (!empty($section_title)): ?>
                                    <h3 class="main_title quote text-white">
                                        <?php echo esc_html($section_title); ?>
                                    </h3>
                                <?php endif; ?>
                                <?php if (!empty($section_description)): ?>
                                    <div class="text-left">
                                        <p><?php echo wp_kses_post($section_description); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($accordion_list)): ?>
                            <div class="accordion_sets">
                                <?php foreach ($accordion_list as $index => $item): ?>
                                    <?php
                                    $item_title = !empty($item['item_title']) ? $item['item_title'] : '';
                                    $item_description = !empty($item['item_description']) ? $item['item_description'] : '';
                                    $item_cta_text = !empty($item['item_cta_text']) ? $item['item_cta_text'] : '';
                                    $item_cta_url = !empty($item['item_cta_url']['url']) ? $item['item_cta_url']['url'] : '';
                                    $item_cta_target = !empty($item['item_cta_url']['is_external']) ? 'target="_blank"' : '';
                                    $item_cta_nofollow = !empty($item['item_cta_url']['nofollow']) ? 'rel="nofollow"' : '';
                                    $item_cta_classes = !empty($item['item_cta_classes']) ? ' ' . esc_attr($item['item_cta_classes']) : '';
                                    $item_video_thumbnail = !empty($item['item_video_thumbnail']['url']) ? $item['item_video_thumbnail']['url'] : '';
                                    $item_video_thumbnail_alt = !empty($item['item_video_thumbnail']['alt']) ? $item['item_video_thumbnail']['alt'] : $item_title;
                                    $item_youtube_video_id = !empty($item['item_youtube_video_id']) ? $item['item_youtube_video_id'] : '';
                                    $item_modal_video_url = !empty($item['item_modal_video_url']['url']) ? $item['item_modal_video_url']['url'] : '';
                                    $should_enable_modal = (!empty($item_youtube_video_id) || !empty($item_modal_video_url));
                                    $accordion_icon = !empty($item['accordion_icon']['url']) ? $item['accordion_icon']['url'] : '';
                                    $modal_id = 'staticBackdrop' . ($index + 1);
                                    ?>
                                    <div class="accordion_set">
                                        <?php if (!empty($accordion_icon)): ?>
                                            <div class="ac_icon_wrap lightback">
                                                <div class="ac_icon_border">
                                                    <span><img class="ac_icon" alt="null"
                                                            src="<?php echo esc_url($accordion_icon); ?>"></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <button class="select_div" aria-label="expand accordion section for section"
                                            aria-expanded="false">
                                            <?php if (!empty($item_title)): ?>
                                                <h2 class="ac_header ">
                                                    <?php echo esc_html($item_title); ?>
                                                </h2>
                                            <?php endif; ?>
                                        </button>
                                        <div class="accontent">
                                            <?php if (!empty($item_description)): ?>
                                                <p class="">
                                                    <?php echo wp_kses_post($item_description); ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if (!empty($item_video_thumbnail)): ?>
                                                <div class="accordion_video">
                                                    <img
                                                        <?php if ($should_enable_modal): ?>
                                                            data-bs-toggle="modal" data-bs-target="#<?php echo esc_attr($modal_id); ?>"
                                                        <?php endif; ?>
                                                        class="<?php echo $should_enable_modal ? '' : 'is-disabled'; ?>"
                                                        src="<?php echo esc_url($item_video_thumbnail); ?>"
                                                        alt="<?php echo esc_attr($item_video_thumbnail_alt); ?>" width="100%" height="100%">
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($item_cta_text) && !empty($item_cta_url)): ?>
                                                <div class="btn-sec_gap">
                                                    <a class="theme-btn bg-tran_lightcolor<?php echo $item_cta_classes; ?>"
                                                        href="<?php echo esc_url($item_cta_url); ?>" <?php echo $item_cta_target; ?>                     <?php echo $item_cta_nofollow; ?>><?php echo esc_html($item_cta_text); ?></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($section_bottom_description) || (!empty($section_bottom_cta_text) && !empty($section_bottom_cta_url))): ?>
                            <div class="btn_demo_box">
                                <?php if (!empty($section_bottom_description)): ?>
                                    <h3><?php echo esc_html($section_bottom_description); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($section_bottom_cta_text) && !empty($section_bottom_cta_url)): ?>
                                    <div class="btn_demo mt-2">
                                        <a class="theme-btn bg-tran_lightcolor<?php echo $section_bottom_cta_classes; ?>"
                                            href="<?php echo esc_url($section_bottom_cta_url); ?>" <?php echo $section_bottom_cta_target; ?>                 <?php echo $section_bottom_cta_nofollow; ?>><?php echo esc_html($section_bottom_cta_text); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                    <?php if (!empty($accordion_list)): ?>
                        <div class="col-md-6 col-12 padd-accordion_video">
                            <div class="bg-blacktheme">
                                <?php foreach ($accordion_list as $index => $item): ?>
                                    <?php
                                    $item_video_thumbnail = !empty($item['item_video_thumbnail']['url']) ? $item['item_video_thumbnail']['url'] : '';
                                    $item_video_thumbnail_alt = !empty($item['item_video_thumbnail']['alt']) ? $item['item_video_thumbnail']['alt'] : (!empty($item['item_title']) ? $item['item_title'] : '');
                                    $item_youtube_video_id = !empty($item['item_youtube_video_id']) ? $item['item_youtube_video_id'] : '';
                                    $item_modal_video_url = !empty($item['item_modal_video_url']['url']) ? $item['item_modal_video_url']['url'] : '';
                                    $should_enable_modal = (!empty($item_youtube_video_id) || !empty($item_modal_video_url));
                                    $modal_id = 'staticBackdrop' . ($index + 1);
                                    ?>
                                    <?php if (!empty($item_video_thumbnail)): ?>
                                        <div class="accordion_video">
                                            <img
                                                <?php if ($should_enable_modal): ?>
                                                    data-bs-toggle="modal" data-bs-target="#<?php echo esc_attr($modal_id); ?>"
                                                <?php endif; ?>
                                                class="<?php echo $should_enable_modal ? '' : 'is-disabled'; ?>"
                                                src="<?php echo esc_url($item_video_thumbnail); ?>"
                                                alt="<?php echo esc_attr($item_video_thumbnail_alt); ?>" width="100%" height="100%">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($accordion_list)): ?>
                        <?php foreach ($accordion_list as $index => $item): ?>
                            <?php
                            $item_title = !empty($item['item_title']) ? $item['item_title'] : '';
                            $item_youtube_video_id = !empty($item['item_youtube_video_id']) ? $item['item_youtube_video_id'] : '';
                            $item_modal_video_url = !empty($item['item_modal_video_url']['url']) ? $item['item_modal_video_url']['url'] : '';
                            $should_enable_modal = (!empty($item_youtube_video_id) || !empty($item_modal_video_url));
                            $modal_id = 'staticBackdrop' . ($index + 1);
                            $modal_label_id = 'staticBackdropLabel' . ($index + 1);
                            ?>
                            <!-- Vertically centered modal -->
                            <?php if ($should_enable_modal): ?>
                                <div class="modal fade" id="<?php echo esc_attr($modal_id); ?>" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="<?php echo esc_attr($modal_label_id); ?>"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <?php if (!empty($item_title)): ?>
                                                    <h2 class="modal-title fs-5" id="<?php echo esc_attr($modal_label_id); ?>">
                                                        <?php echo esc_html($item_title); ?></h2>
                                                <?php endif; ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4 videoframe">
                                                <?php if (!empty($item_youtube_video_id)): ?>
                                                    <iframe
                                                        data-src="https://www.youtube.com/embed/<?php echo esc_attr($item_youtube_video_id); ?>"
                                                        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                                                    </iframe>
                                                <?php elseif (!empty($item_modal_video_url)): ?>
                                                    <?php
                                                    $youtube_from_url = $this->get_youtube_id($item_modal_video_url);
                                                    $vimeo_from_url = $this->get_vimeo_id($item_modal_video_url);
                                                    $path = wp_parse_url($item_modal_video_url, PHP_URL_PATH);
                                                    $ext = is_string($path) ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : '';
                                                    $is_direct_video = in_array($ext, ['mp4', 'webm', 'ogg'], true);
                                                    ?>
                                                    <?php if (!empty($youtube_from_url)): ?>
                                                        <iframe
                                                            data-src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_from_url); ?>"
                                                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                                                        </iframe>
                                                    <?php elseif (!empty($vimeo_from_url)): ?>
                                                        <iframe
                                                            data-src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo_from_url); ?>"
                                                            frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
                                                        </iframe>
                                                    <?php elseif ($is_direct_video): ?>
                                                        <video controls autoplay playsinline style="width:100%;height:auto;">
                                                            <source src="<?php echo esc_url($item_modal_video_url); ?>" type="<?php echo esc_attr('video/' . $ext); ?>">
                                                        </video>
                                                    <?php else: ?>
                                                        <a href="<?php echo esc_url($item_modal_video_url); ?>" target="_blank" rel="noopener noreferrer">
                                                            <?php echo esc_html($item_modal_video_url); ?>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>

            </div>
        </section>

        <script>
            (function () {
                // Lazy load YouTube iframes when modals are opened
                document.addEventListener('DOMContentLoaded', function () {
                    const modals = document.querySelectorAll('.modal');
                    modals.forEach(function (modal) {
                        modal.addEventListener('shown.bs.modal', function () {
                            const iframe = this.querySelector('iframe[data-src]');
                            if (iframe && !iframe.src) {
                                iframe.src = iframe.getAttribute('data-src') + '?autoplay=1';
                            }
                        });
                        // Pause video when modal is closed
                        modal.addEventListener('hidden.bs.modal', function () {
                            const iframe = this.querySelector('iframe');
                            if (iframe) {
                                iframe.src = '';
                            }
                        });
                    });
                });
            })();
        </script>
        <?php
    }
}
?>
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

class Scalescroll2 extends Widget_Base
{
    public function get_name()
    {
        return 'scalescroll2';
    }

    public function get_title()
    {
        return 'Scale Scroll 2';
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
        // Item Description
        $repeater->add_control(
            'item_tags',
            [
                'label' => esc_html__('Item Tags', 'repindia'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'Securing remote pipelines',
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
        $this->add_inline_editing_attributes('custom_class', 'basic'); ?>
        <style>
            .youtube-wrapper .white_theme_iframe,
            .youtube-wrapper .white_theme_thumb { display: block; }
            .youtube-wrapper .black_theme_iframe,
            .youtube-wrapper .black_theme_thumb { display: none; }
            .js-dark .youtube-wrapper .white_theme_iframe,
            .js-dark .youtube-wrapper .white_theme_thumb { display: none; }
            .js-dark .youtube-wrapper .black_theme_iframe,
            .js-dark .youtube-wrapper .black_theme_thumb { display: block; }
            @media(max-width: 768px){
                .photo_custom .details * { text-align: left;               }
            }
            
        </style>

        <div class="makdmks scalescroll-widget scalescroll2-widget">
            <div class="custom-container">
                <?php if (!empty($section_title) || !empty($section_description)) : ?>
                    <div class="title-box">
                        <div class="col-lg-5 col-xl-4 col-12">
                            <div class="width_define">
                                <?php if (!empty($section_title)) : ?>
                                    <h2 class="main_title quote mb-12">
                                        <?php echo esc_html($section_title); ?>
                                    </h2>
                                <?php endif; ?>
                                <?php if (!empty($section_description)) : ?>
                                    <div class="text-left">
                                        <p><?php echo wp_kses_post($section_description); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($scroll_items)) : ?>
                <div class="gallery">
                    <div class="left">
                        <div class="detailsWrapper">
                            <?php foreach ($scroll_items as $index => $item) : ?>
                                <?php
                                $item_num = $index + 1;
                                $item_title = !empty($item['item_title']) ? $item['item_title'] : '';
                                $item_tags = !empty($item['item_tags']) ? $item['item_tags'] : '';
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
                                ?>
                                <div class="details details-<?php echo esc_attr($item_num); ?>">
                                    <?php if ($has_blue_headline) : ?>
                                        <div class="headline blue"></div>
                                    <?php endif; ?>
                                    <div class="txtflex">
                                        <?php if (!empty($item_tags)) : ?>
                                        <div class="bredstyle"><?php echo $item_tags; ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($item_title)) : ?>
                                            <h2><?php echo esc_html($item_title); ?></h2>
                                        <?php endif; ?>
                                        <?php if (!empty($item_desc)) : ?>
                                            <p class="para-text"><?php echo wp_kses_post($item_desc); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($cta_text) && !empty($cta_url)) : ?>
                                            <div class="text-left">
                                                <a class="theme-btn bg-trans border_btnlight" href="<?php echo esc_url($cta_url); ?>" <?php echo $cta_target; ?> <?php echo $cta_nofollow; ?>><?php echo esc_html($cta_text); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($bolt_title) || !empty($bolt_icon) || (!empty($bolt_cta_text) && !empty($bolt_cta_url))) : ?>
                                            <div class="bolt">
                                                <?php if (!empty($bolt_icon)) : ?>
                                                    <img src="<?php echo esc_url($bolt_icon); ?>" alt="<?php echo esc_attr($bolt_title); ?>">
                                                <?php endif; ?>
                                                <?php if (!empty($bolt_title)) : ?>
                                                    <p><?php echo esc_html($bolt_title); ?></p>
                                                <?php endif; ?>
                                                <?php if (!empty($bolt_cta_text) && !empty($bolt_cta_url)) : ?>
                                                    <div class="btn-bolt">
                                                        <a href="<?php echo esc_url($bolt_cta_url); ?>" class="<?php echo $bolt_cta_classes; ?>" <?php echo $bolt_cta_target; ?> <?php echo $bolt_cta_nofollow; ?>><?php echo esc_html($bolt_cta_text); ?></a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>

                    <div class="right">
                        <div class="photos">
                            <?php foreach ($scroll_items as $index => $item) : ?>
                            <?php
                            $item_num = $index + 1;
                            $media_type = !empty($item['media_type']) ? $item['media_type'] : 'image';
                            $item_title = !empty($item['item_title']) ? $item['item_title'] : '';
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
                                <?php if ($media_type === 'image' && !empty($image_default)) : ?>
                                    <img class="white_theme_img radius-12" decoding="async" src="<?php echo esc_url($image_default); ?>" alt="<?php echo esc_attr($image_default_alt); ?>">
                                    <img class="black_theme_img radius-12" decoding="async" src="<?php echo esc_url($image_dark); ?>" alt="<?php echo esc_attr($image_dark_alt); ?>">
                                <?php elseif ($media_type === 'youtube' && !empty($youtube_id_default)) : ?>
                                    <?php
                                    $youtube_thumb_default_final = !empty($youtube_thumb_default) ? $youtube_thumb_default : 'https://img.youtube.com/vi/' . esc_attr($youtube_id_default) . '/hqdefault.jpg';
                                    $youtube_thumb_dark_final = !empty($youtube_thumb_dark) ? $youtube_thumb_dark : 'https://img.youtube.com/vi/' . esc_attr($youtube_id_dark) . '/hqdefault.jpg';
                                    ?>
                                    <div class="youtube-wrapper radius-12" style="position: relative; width: 100%; height: 60vh; overflow: hidden; cursor: pointer;">
                                        <iframe class="radius-12 youtube-iframe white_theme_iframe" data-video-id="<?php echo esc_attr($youtube_id_default); ?>" src="" width="100%" height="60vh" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture mute" allowfullscreen style="width: 100%; height: 60vh; position: absolute; top: 0; left: 0; z-index: 1;"></iframe>
                                        <iframe class="radius-12 youtube-iframe black_theme_iframe" data-video-id="<?php echo esc_attr($youtube_id_dark); ?>" src="" width="100%" height="60vh" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture mute" allowfullscreen style="width: 100%; height: 60vh; position: absolute; top: 0; left: 0; z-index: 1; display: none;"></iframe>
                                        <img src="<?php echo esc_url($youtube_thumb_default_final); ?>" alt="Video thumbnail" class="youtube-thumb white_theme_thumb" style="width: 100%; height: 100%; object-fit: cover; display: block; position: absolute; top: 0; left: 0; z-index: 2; cursor: pointer;" />
                                        <img src="<?php echo esc_url($youtube_thumb_dark_final); ?>" alt="Video thumbnail" class="youtube-thumb black_theme_thumb" style="width: 100%; height: 100%; object-fit: cover; display: none; position: absolute; top: 0; left: 0; z-index: 2; cursor: pointer;" />
                                        <button class="play-btn" aria-label="Play video">
                                            <svg width="32" height="32" viewBox="0 0 24 24" fill="white" style="margin-left: 4px;">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <div class="details details-<?php echo esc_attr($item_num); ?>">
                                    <?php if ($has_blue_headline) : ?>
                                        <div class="headline blue"></div>
                                    <?php endif; ?>
                                    <div class="txtflex">
                                        <?php if (!empty($item_title)) : ?>
                                            <h2><?php echo esc_html($item_title); ?></h2>
                                        <?php endif; ?>
                                        <?php if (!empty($item_desc)) : ?>
                                            <p class="para-text"><?php echo wp_kses_post($item_desc); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($cta_text) && !empty($cta_url)) : ?>
                                            <div class="text-left">
                                                <a class="theme-btn bg-trans border_btnlight<?php echo $cta_classes; ?>" href="<?php echo esc_url($cta_url); ?>" <?php echo $cta_target; ?> <?php echo $cta_nofollow; ?>><?php echo esc_html($cta_text); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($bolt_title) || !empty($bolt_icon) || (!empty($bolt_cta_text) && !empty($bolt_cta_url))) : ?>
                                            <div class="bolt">
                                                <?php if (!empty($bolt_icon)) : ?>
                                                    <img src="<?php echo esc_url($bolt_icon); ?>" alt="<?php echo esc_attr($bolt_title); ?>">
                                                <?php endif; ?>
                                                <?php if (!empty($bolt_title)) : ?>
                                                    <p><?php echo esc_html($bolt_title); ?></p>
                                                <?php endif; ?>
                                                <?php if (!empty($bolt_cta_text) && !empty($bolt_cta_url)) : ?>
                                                    <div class="btn-bolt">
                                                        <a href="<?php echo esc_url($bolt_cta_url); ?>" class="<?php echo $bolt_cta_classes; ?>" <?php echo $bolt_cta_target; ?> <?php echo $bolt_cta_nofollow; ?>><?php echo esc_html($bolt_cta_text); ?></a>
                                                    </div>
                                                <?php endif; ?>
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
                        "rel=0",
                        "playsinline=1",
                        "controls=0",
                        "enablejsapi=1"
                    ];
                    if (origin) params.push("origin=" + encodeURIComponent(origin));

                    iframe.src = "https://www.youtube.com/embed/" + encodeURIComponent(videoId) + "?" + params.join("&");
                    iframe.dataset.ytLoaded = "1";

                    // Register for player events so we can re-loop without the
                    // "playlist" param (that param is what draws YouTube's
                    // left/right navigation arrows over a single video).
                    // The player isn't ready the instant the iframe loads, so
                    // resend the handshake a few times until it starts emitting
                    // events.
                    iframe.addEventListener("load", function () {
                        var sendListening = function () {
                            if (!iframe.contentWindow) return;
                            iframe.contentWindow.postMessage(
                                JSON.stringify({ event: "listening", id: iframe.id || undefined }),
                                "*"
                            );
                        };
                        sendListening();
                        var tries = 0;
                        var handshake = setInterval(function () {
                            sendListening();
                            if (++tries >= 10) clearInterval(handshake);
                        }, 500);
                    });
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

                // Re-loop the video when it ends. This preserves the previous
                // looping behavior that "loop=1&playlist=<id>" provided, but
                // without the playlist param (which draws YouTube's left/right
                // navigation arrows over the video).
                window.addEventListener("message", function (event) {
                    if (typeof event.origin !== "string" || event.origin.indexOf("youtube.com") === -1) return;

                    var data;
                    try {
                        data = typeof event.data === "string" ? JSON.parse(event.data) : event.data;
                    } catch (e) {
                        return;
                    }
                    if (!data) return;

                    // YouTube reports the "ended" state (0) via two message
                    // shapes depending on the player build.
                    var ended =
                        (data.event === "onStateChange" && data.info === 0) ||
                        (data.event === "infoDelivery" && data.info && data.info.playerState === 0);
                    if (!ended) return;

                    var iframes = document.querySelectorAll(".scalescroll2-widget .youtube-iframe");
                    for (var i = 0; i < iframes.length; i++) {
                        if (iframes[i].contentWindow === event.source) {
                            iframes[i].contentWindow.postMessage(
                                JSON.stringify({ event: "command", func: "seekTo", args: [0, true] }),
                                "*"
                            );
                            iframes[i].contentWindow.postMessage(
                                JSON.stringify({ event: "command", func: "playVideo", args: [] }),
                                "*"
                            );
                            break;
                        }
                    }
                });

                document.addEventListener("DOMContentLoaded", function () {
                    var youtubeWrappers = document.querySelectorAll(".scalescroll2-widget .youtube-wrapper");
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

                        // If the user explicitly clicks, keep playing. On desktop we
                        // unmute; on mobile/touch we stay muted (no sound on tap).
                        wrapper.addEventListener("click", function () {
                            var iframe = getActiveIframe(wrapper);
                            if (!iframe) return;
                            hideThumbsAndButton(wrapper);

                            var isMobile = (typeof window.matchMedia === "function" && window.matchMedia("(max-width: 768px)").matches)
                                || ("ontouchstart" in window)
                                || (navigator.maxTouchPoints > 0);

                            ensureYouTubeSrc(iframe, { autoplay: true, muted: isMobile });
                            postYouTubeCommand(iframe, "playVideo");
                            if (!isMobile) {
                                postYouTubeCommand(iframe, "unMute");
                            } else {
                                postYouTubeCommand(iframe, "mute");
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


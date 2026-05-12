<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Custom_Marquee extends Widget_Base
{
    public function get_name()
    {
        return 'custom_marquee';
    }

    public function get_title()
    {
        return 'Custom Marquee';
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
        // Content Section: Marquee Items
        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Marquee Items',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_type',
            [
                'label' => esc_html__('Item Type', 'repindia'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'image' => esc_html__('Image', 'repindia'),
                    'text' => esc_html__('Text', 'repindia'),
                ],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'condition' => [
                    'item_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'image_dark',
            [
                'label' => esc_html__('Dark Theme Image', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [],
                'description' => esc_html__('Leave empty to use default image for dark theme', 'repindia'),
                'condition' => [
                    'item_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'image_width',
            [
                'label' => esc_html__('Image Width', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'condition' => [
                    'item_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'condition' => [
                    'item_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'repindia'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'contain',
                'options' => [
                    'contain' => esc_html__('Contain', 'repindia'),
                    'cover' => esc_html__('Cover', 'repindia'),
                    'fill' => esc_html__('Fill', 'repindia'),
                    'none' => esc_html__('None', 'repindia'),
                    'scale-down' => esc_html__('Scale Down', 'repindia'),
                ],
                'condition' => [
                    'item_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'text_content',
            [
                'label' => esc_html__('Text Content', 'repindia'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Marquee Text Item', 'repindia'),
                'condition' => [
                    'item_type' => 'text',
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'repindia'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'repindia'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $repeater->add_control(
            'item_spacing',
            [
                'label' => esc_html__('Item Spacing (px)', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
            ]
        );

        $this->add_control(
            'marquee_items',
            [
                'label' => esc_html__('Marquee Items', 'repindia'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_type' => 'text',
                        'text_content' => esc_html__('Marquee Item 1', 'repindia'),
                    ],
                    [
                        'item_type' => 'text',
                        'text_content' => esc_html__('Marquee Item 2', 'repindia'),
                    ],
                ],
                'title_field' => '{{{ item_type === "image" ? "Image" : "Text" }}}',
            ]
        );

        $this->end_controls_section();

        // General Marquee Settings
        $this->start_controls_section(
            'section_marquee_settings',
            [
                'label' => 'Marquee Settings',
            ]
        );

        $this->add_control(
            'marquee_speed',
            [
                'label' => esc_html__('Speed (seconds per loop)', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 5,
                        'max' => 120,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 40,
                ],
            ]
        );

        $this->add_control(
            'marquee_direction',
            [
                'label' => esc_html__('Direction', 'repindia'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__('Left → Right', 'repindia'),
                    'right' => esc_html__('Right → Left', 'repindia'),
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'repindia'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'repindia'),
                'label_off' => esc_html__('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'marquee_gap',
            [
                'label' => esc_html__('Marquee Gap (px)', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section: Text
        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Text', 'repindia'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Typography', 'repindia'),
                'selector' => '{{WRAPPER}} .cmarq-item .cmarq-content, {{WRAPPER}} .cmarq-item .cmarq-content p, {{WRAPPER}} .cmarq-item .cmarq-content div, {{WRAPPER}} .cmarq-item .cmarq-content span, {{WRAPPER}} .cmarq-item a .cmarq-content, {{WRAPPER}} .cmarq-item a .cmarq-content p',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .cmarq-item .cmarq-content' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cmarq-item .cmarq-content p' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cmarq-item .cmarq-content *' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => esc_html__('Link Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0066cc',
                'selectors' => [
                    '{{WRAPPER}} .cmarq-item a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cmarq-item a .cmarq-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label' => esc_html__('Link Hover Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#004499',
                'selectors' => [
                    '{{WRAPPER}} .cmarq-item a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .cmarq-item a:hover .cmarq-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section: Images
        $this->start_controls_section(
            'section_style_images',
            [
                'label' => esc_html__('Images', 'repindia'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_width_global',
            [
                'label' => esc_html__('Image Width', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cmarq-item img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_height_global',
            [
                'label' => esc_html__('Image Height', 'repindia'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .cmarq-item img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_object_fit_global',
            [
                'label' => esc_html__('Object Fit', 'repindia'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'contain',
                'options' => [
                    'contain' => esc_html__('Contain', 'repindia'),
                    'cover' => esc_html__('Cover', 'repindia'),
                    'fill' => esc_html__('Fill', 'repindia'),
                    'none' => esc_html__('None', 'repindia'),
                    'scale-down' => esc_html__('Scale Down', 'repindia'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .cmarq-item img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section: Wrapper
        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => esc_html__('Wrapper', 'repindia'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => esc_html__('Padding', 'repindia'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .cmarq-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_background',
            [
                'label' => esc_html__('Background Color', 'repindia'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cmarq-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_border_radius',
            [
                'label' => esc_html__('Border Radius', 'repindia'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .cmarq-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $marquee_items = $settings['marquee_items'];
        $speed = !empty($settings['marquee_speed']['size']) ? $settings['marquee_speed']['size'] : 40;
        $direction = !empty($settings['marquee_direction']) ? esc_attr($settings['marquee_direction']) : 'left';
        $pause_on_hover = !empty($settings['pause_on_hover']) && $settings['pause_on_hover'] === 'yes' ? 'yes' : 'no';
        $gap = !empty($settings['marquee_gap']['size']) ? $settings['marquee_gap']['size'] : 40;

        // Add inline CSS only once per page
        static $css_added = false;
        if (!$css_added) {
            $css_added = true;
            echo '<style id="custom-marquee-css">';
            echo '.cmarq-wrapper { width: 100%; overflow: hidden; position: relative; }';
            echo '.cmarq-track { display: flex; flex-wrap: nowrap; white-space: nowrap; width: max-content; will-change: transform; backface-visibility: hidden; }';
            echo '.cmarq-item { display: inline-flex; align-items: center; flex-shrink: 0; }';
            echo '.cmarq-item img { display: block; }';
            echo '.cmarq-item a { text-decoration: none; display: inline-flex; align-items: center; }';
            echo '.cmarq-content { display: inline-block; }';
            echo '</style>';
        }

        // Add inline JS only once per page
        static $js_added = false;
        if (!$js_added) {
            $js_added = true;
            echo '<script id="custom-marquee-js">';
            echo '(function() {';
            echo 'var marquees = [], rafId = null, lastTime = 0;';
            echo 'function tick(timestamp) {';
            echo 'marquees = marquees.filter(function(m) { return m.wrapper.isConnected; });';
            echo 'if (!marquees.length) { rafId = null; return; }';
            echo 'var dt = lastTime ? Math.min(timestamp - lastTime, 50) : 0;';
            echo 'lastTime = timestamp;';
            echo 'marquees.forEach(function(m) {';
            echo 'if (m.pauseOnHover && m.hovered) return;';
            echo 'm.pos += m.velocity * (dt / 1000);';
            echo 'if (m.pos >= m.loopWidth) m.pos -= m.loopWidth;';
            echo 'else if (m.pos < 0) m.pos += m.loopWidth;';
            echo 'm.track.style.transform = "translate3d(" + (m.direction === "right" ? m.pos : -m.pos) + "px, 0, 0)";';
            echo '});';
            echo 'rafId = requestAnimationFrame(tick);';
            echo '}';
            echo 'function initCustomMarquees() {';
            echo 'document.querySelectorAll(".cmarq-wrapper").forEach(function(wrapper) {';
            echo 'if (wrapper.dataset.initialized === "1") return;';
            echo 'wrapper.dataset.initialized = "1";';
            echo 'var track = wrapper.querySelector(".cmarq-track");';
            echo 'if (!track || !track.children.length) return;';
            echo 'var speed = parseFloat(wrapper.dataset.speed) || 40;';
            echo 'var direction = wrapper.dataset.direction || "left";';
            echo 'var pauseOnHover = wrapper.dataset.hover === "yes";';
            echo 'var loopWidth = track.offsetWidth / 2;';
            echo 'if (loopWidth <= 0) return;';
            echo 'var m = { wrapper: wrapper, track: track, loopWidth: loopWidth, velocity: loopWidth / speed, direction: direction, pauseOnHover: pauseOnHover, pos: 0, hovered: false };';
            echo 'if (pauseOnHover) { wrapper.addEventListener("mouseenter", function() { m.hovered = true; }); wrapper.addEventListener("mouseleave", function() { m.hovered = false; }); }';
            echo 'marquees.push(m);';
            echo '});';
            echo 'if (marquees.length && !rafId) { lastTime = 0; rafId = requestAnimationFrame(tick); }';
            echo '}';
            echo 'function run() {';
            echo 'if (document.readyState !== "loading") initCustomMarquees();';
            echo 'else document.addEventListener("DOMContentLoaded", initCustomMarquees);';
            echo 'if (typeof jQuery !== "undefined") jQuery(window).on("elementor/frontend/init", initCustomMarquees);';
            echo '}';
            echo 'run();';
            echo '})();';
            echo '</script>';
        }
?>

        <div class="cmarq-wrapper" data-speed="<?php echo esc_attr($speed); ?>" data-direction="<?php echo esc_attr($direction); ?>" data-hover="<?php echo esc_attr($pause_on_hover); ?>" data-gap="<?php echo esc_attr($gap); ?>" style="--gap: <?php echo esc_attr($gap); ?>px;">
            <div class="cmarq-track">
                <?php if (!empty($marquee_items)) : ?>
                    <?php for ($duplicate = 0; $duplicate < 2; $duplicate++) : ?>
                    <?php foreach ($marquee_items as $item) : ?>
                        <?php
                        $item_type = !empty($item['item_type']) ? $item['item_type'] : 'text';
                        $link = !empty($item['link']['url']) ? $item['link']['url'] : '';
                        $link_target = !empty($item['link']['is_external']) ? '_blank' : '_self';
                        $link_rel = !empty($item['link']['nofollow']) ? 'nofollow' : '';
                        $item_spacing = !empty($item['item_spacing']['size']) ? $item['item_spacing']['size'] : $gap;
                        ?>
                        <div class="cmarq-item" style="padding-right: <?php echo esc_attr($item_spacing); ?>px;">
                            <?php if (!empty($link)) : ?>
                                <a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($link_target); ?>" <?php echo !empty($link_rel) ? 'rel="' . esc_attr($link_rel) . '"' : ''; ?>>
                                    <?php if ($item_type === 'image' && !empty($item['image']['url'])) : ?>
                                        <?php
                                        $img_width = !empty($item['image_width']['size']) ? $item['image_width']['size'] . $item['image_width']['unit'] : '100px';
                                        $img_height = !empty($item['image_height']['size']) ? $item['image_height']['size'] . $item['image_height']['unit'] : '100px';
                                        $img_object_fit = !empty($item['image_object_fit']) ? $item['image_object_fit'] : 'contain';
                                        // Get dark theme image, fallback to default image if empty
                                        $dark_image_url = !empty($item['image_dark']['url']) ? $item['image_dark']['url'] : $item['image']['url'];
                                        $dark_image_alt = !empty($item['image_dark']['alt']) ? $item['image_dark']['alt'] : ($item['image']['alt'] ?? '');
                                        ?>
                                        <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['image']['alt'] ?? ''); ?>" class="white-theme-img" style="width: <?php echo esc_attr($img_width); ?>; height: <?php echo esc_attr($img_height); ?>; object-fit: <?php echo esc_attr($img_object_fit); ?>;">
                                        <img src="<?php echo esc_url($dark_image_url); ?>" alt="<?php echo esc_attr($dark_image_alt); ?>" class="black-theme-img" style="width: <?php echo esc_attr($img_width); ?>; height: <?php echo esc_attr($img_height); ?>; object-fit: <?php echo esc_attr($img_object_fit); ?>;">
                                    <?php elseif ($item_type === 'text' && !empty($item['text_content'])) : ?>
                                        <span class="cmarq-content"><?php echo wp_kses_post($item['text_content']); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php else : ?>
                                <?php if ($item_type === 'image' && !empty($item['image']['url'])) : ?>
                                    <?php
                                    $img_width = !empty($item['image_width']['size']) ? $item['image_width']['size'] . $item['image_width']['unit'] : '100px';
                                    $img_height = !empty($item['image_height']['size']) ? $item['image_height']['size'] . $item['image_height']['unit'] : '100px';
                                    $img_object_fit = !empty($item['image_object_fit']) ? $item['image_object_fit'] : 'contain';
                                    // Get dark theme image, fallback to default image if empty
                                    $dark_image_url = !empty($item['image_dark']['url']) ? $item['image_dark']['url'] : $item['image']['url'];
                                    $dark_image_alt = !empty($item['image_dark']['alt']) ? $item['image_dark']['alt'] : ($item['image']['alt'] ?? '');
                                    ?>
                                    <span class="cmarq-content">
                                        <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['image']['alt'] ?? ''); ?>" class="white-theme-img" style="width: <?php echo esc_attr($img_width); ?>; height: <?php echo esc_attr($img_height); ?>; object-fit: <?php echo esc_attr($img_object_fit); ?>;">
                                        <img src="<?php echo esc_url($dark_image_url); ?>" alt="<?php echo esc_attr($dark_image_alt); ?>" class="black-theme-img" style="width: <?php echo esc_attr($img_width); ?>; height: <?php echo esc_attr($img_height); ?>; object-fit: <?php echo esc_attr($img_object_fit); ?>;">
                                    </span>
                                <?php elseif ($item_type === 'text' && !empty($item['text_content'])) : ?>
                                    <span class="cmarq-content"><?php echo wp_kses_post($item['text_content']); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>

<?php
    }
}

<?php
namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Custom_Image_Circle extends Widget_Base {

    public function get_name() { return 'custom_image_circle'; }
    public function get_title() { return 'Animated Orbit Circles'; }
    public function get_icon() { return 'eicon-animation'; }
    public function get_categories() { return ['general']; }

    protected function register_controls() {

        // --- 1. RINGS SETUP ---
        $this->start_controls_section('section_rings_config', ['label' => __('1. Rings Configuration', 'elementor-custom-widget')]);

        $this->add_control(
            'rings_info',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div style="background: #d4edda; padding: 10px; color: #155724; border: 1px solid #c3e6cb; border-radius: 3px;"><strong>Tip:</strong> For concentric circles, ensure every ring has a LARGER radius than the previous one (e.g., 150, 300, 450).</div>',
            ]
        );

        $this->add_control(
            'rings_data',
            [
                'label' => __( 'Define Rings', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'ring_radius_desktop',
                        'label' => __( 'Radius - Desktop (px)', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'default' => 250,
                    ],
                    
                    [
                        'name' => 'ring_radius_tablet',
                        'label' => __( 'Radius - Tablet (px)', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'default' => 180,
                    ],
                    
                    [
                        'name' => 'ring_radius_mobile',
                        'label' => __( 'Radius - Mobile (px)', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'default' => 120,
                    ],
                    
                    [
                        'name' => 'anim_duration',
                        'label' => __( 'Speed (Seconds)', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'default' => 20,
                    ],
                    [
                        'name' => 'direction',
                        'label' => __( 'Direction', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [ 'normal' => 'Clockwise', 'reverse' => 'Counter-Clockwise' ],
                        'default' => 'normal',
                    ],
                    [
                        'name' => 'border_color',
                        'label' => __( 'Ring Color', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => 'rgba(255, 255, 255, 0.15)',
                    ],
                    [
                        'name' => 'border_style',
                        'label' => __( 'Border Style', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::SELECT,
                        'options' => [ 'solid' => 'Solid', 'dashed' => 'Dashed', 'dotted' => 'Dotted' ],
                        'default' => 'dashed',
                    ],
                ],
                'title_field' => 'Radius: {{{ ring_radius }}}px | {{{ direction }}}',
            ]
        );
        $this->end_controls_section();

        // --- 2. ITEMS SETUP ---
        $this->start_controls_section('section_items', ['label' => __('2. Orbit Items', 'elementor-custom-widget')]);

        $this->add_control(
            'items_list',
            [
                'label' => __( 'Items', 'elementor-custom-widget' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'ring_index',
                        'label' => __( 'Assign to Ring # (0, 1, 2...)', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::NUMBER,
                        'default' => 0,
                        'description' => '0 is the Inner Ring (First one in list above). 1 is the next one out.',
                    ],
                    [
                        'name' => 'image',
                        'label' => __( 'Icon/Image', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'dynamic' => [
                            'active' => true,
                        ],
                    ],
                    [
                        'name' => 'text',
                        'label' => __( 'Label Text', 'elementor-custom-widget' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => 'Feature Name',
                    ],
                ],
                'title_field' => '{{{ text }}} ( on Ring #{{{ ring_index }}} )',
            ]
        );
        $this->end_controls_section();
        
        // --- STYLE SECTION ---
        $this->start_controls_section('section_style', ['label' => __('Style', 'elementor-custom-widget'), 'tab' => \Elementor\Controls_Manager::TAB_STYLE]);
        
        $this->add_control('text_color', ['label' => 'Text Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => ['{{WRAPPER}} .orbit-text' => 'color: {{VALUE}}']]);
        $this->add_group_control(\Elementor\Group_Control_Typography::get_type(), ['name' => 'content_typography', 'selector' => '{{WRAPPER}} .orbit-text']);
        $this->add_control('icon_size', ['label' => 'Icon Size', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 10, 'max' => 100]], 'default' => ['unit' => 'px', 'size' => 40], 'selectors' => ['{{WRAPPER}} .orbit-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};']]);
        
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $rings = $settings['rings_data'];
        $items = $settings['items_list'];
    
        // Group items
        $grouped_items = [];
        if (!empty($items)) {
            foreach ($items as $item) {
                $index = $item['ring_index'];
                if (!isset($grouped_items[$index])) $grouped_items[$index] = [];
                $grouped_items[$index][] = $item;
            }
        }
        ?>
        
        <style>
            .orbit-system-wrapper {
                position: relative;
                width: 100%;
                min-height: 900px;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: hidden;
                background-color: transparent;
                /* transform: translateX(46%); */
            }
            .orbit-ring {
                position: absolute;
                border-radius: 50%;
                top: 50%;
                left: 100%;
                transform: translate(-50%, -50%);
                pointer-events: none;
                border-width: 1px;
                z-index: 1;
            }
            .orbit-item-wrapper {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0; height: 0;
                z-index: 5;
            }
            .orbit-content {
                display: flex;
                flex-direction: row;
                align-items: center;
                text-align: center;
                width: 221px;
                margin-left: -60px;
                margin-top: -20px;
                pointer-events: auto;
                cursor: pointer;
                gap: 10px;
            }
            .orbit-icon img { display: block; margin: 0 auto 5px auto; object-fit: contain; }
            .orbit-icon svg,.orbit-icon img { width: 80px;height: 80px; }
            .orbit-text{ text-align: left;}
    
            /* Animations */
            @keyframes orbit-cw { from { transform: translate(-50%, -50%) rotate(0deg);} to { transform: translate(-50%, -50%) rotate(360deg);} }
            @keyframes orbit-ccw { from { transform: translate(-50%, -50%) rotate(0deg);} to { transform: translate(-50%, -50%) rotate(-360deg);} }
            @keyframes content-cw { from { transform: rotate(0deg);} to { transform: rotate(-360deg);} }
            @keyframes content-ccw { from { transform: rotate(0deg);} to { transform: rotate(360deg);} }

            @media(max-width: 768px){
                .orbit-ring{ left: 45%;top: 100%; }
                .orbit-system-wrapper{ min-height: 420px; }
                .orbit-icon svg,.orbit-icon img { width: 40px;height: 40px; }
                .orbit-content{ max-width: 141px; }
                .elementor-element .orbit-text{ font-size: 14px!important;line-height: 21px!important; }
            }
    
        <?php foreach ($rings as $i => $ring): 
    
            // Make sure values are numeric
            $rad_desktop = is_array($ring['ring_radius_desktop']) ? $ring['ring_radius_desktop']['size'] : $ring['ring_radius_desktop'];
            $rad_tablet  = is_array($ring['ring_radius_tablet']) ? $ring['ring_radius_tablet']['size'] : $ring['ring_radius_tablet'];
            $rad_mobile  = is_array($ring['ring_radius_mobile']) ? $ring['ring_radius_mobile']['size'] : $ring['ring_radius_mobile'];
        ?>
    
            /* Desktop */
            .orbit-ring-<?php echo $i; ?> {
                --ring-radius: <?php echo $rad_desktop; ?>px;
                width: calc(var(--ring-radius) * 2);
                height: calc(var(--ring-radius) * 2);
            }

            /* Tablet */
            @media(max-width: 1024px) {
                .orbit-ring-<?php echo $i; ?> {
                    --ring-radius: <?php echo $rad_tablet; ?>px;
                    width: calc(var(--ring-radius) * 2);
                    height: calc(var(--ring-radius) * 2);
                }
            }

            /* Mobile */
            @media(max-width: 767px) {
                .orbit-ring-<?php echo $i; ?> {
                    --ring-radius: <?php echo $rad_mobile; ?>px;
                    width: calc(var(--ring-radius) * 2);
                    height: calc(var(--ring-radius) * 2);
                }
            }
    
        <?php endforeach; ?>
        </style>
    
        <div class="orbit-system-wrapper">
            <?php if (!empty($rings)) :
                foreach ($rings as $i => $ring) :
    
                    // Proper radius (desktop by default)
                    $r = is_array($ring['ring_radius_desktop']) ? $ring['ring_radius_desktop']['size'] : $ring['ring_radius_desktop'];
    
                    $dur = $ring['anim_duration'];
                    $dir = $ring['direction'];
                    $color = $ring['border_color'];
                    $style = $ring['border_style'];
    
                    $ring_anim = ($dir === 'reverse') ? 'orbit-ccw' : 'orbit-cw';
                    $item_anim = ($dir === 'reverse') ? 'content-ccw' : 'content-cw';
            ?>
                <div class="orbit-ring orbit-ring-<?php echo $i; ?>" 
                    style="
                        border-color: <?php echo $color; ?>;
                        border-style: <?php echo $style; ?>;
                        animation: <?php echo $ring_anim; ?> <?php echo $dur; ?>s linear infinite;
                    ">
    
                    <?php 
                    if (isset($grouped_items[$i])) :
                        $these_items = $grouped_items[$i];
                        $count = count($these_items);
                        $step = $count > 0 ? 360 / $count : 0;
                        foreach ($these_items as $k => $item) :
                            $angle = $k * $step;
                            $transform = "transform: rotate({$angle}deg) translate(var(--ring-radius)) rotate(-{$angle}deg);";
                    ?>
                    <div class="orbit-item-wrapper" style="<?php echo $transform; ?>">
                        <div class="orbit-content" style="animation: <?php echo $item_anim; ?> <?php echo $dur; ?>s linear infinite;">
                            <?php if (!empty($item['image']['url'])) : ?>
                                <div class="orbit-icon"><img src="<?php echo esc_url($item['image']['url']); ?>"></div>
                            <?php endif; ?>
                            <div class="orbit-text"><?php echo esc_html($item['text']); ?></div>
                        </div>
                    </div>
    
                    <?php endforeach; endif; ?>
                </div>
            <?php endforeach; endif; ?>
        </div>
    
        <?php
    }
    
}
?>
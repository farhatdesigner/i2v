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
        $rings = $settings['rings_data'] ?? [];
        $items = $settings['items_list'] ?? [];
    
        $grouped_items = [];
        if (!empty($items)) {
            foreach ($items as $item) {
                $index = isset($item['ring_index']) ? (int)$item['ring_index'] : 0;
                if (!isset($grouped_items[$index])) {
                    $grouped_items[$index] = [];
                }
                $grouped_items[$index][] = $item;
            }
        }
        ?>
        
        <style>
            {{WRAPPER}} .orbit-system-wrapper {
                position: relative;
                width: 100%;
                min-height: 80vh;
                height: auto;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: hidden;
                background-color: transparent;
            }
            
            {{WRAPPER}} .orbit-ring {
                position: absolute;
                top: 50%;
                left: 100%;
                transform: translate(-50%, -50%);
                transform-origin: center center;
                border-radius: 50%;
                pointer-events: none;
                border-width: 1px;
                z-index: 1;
                width: 0;
                height: 0;
            }
            
            {{WRAPPER}} .orbit-item-wrapper {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                transform-origin: center center;
                z-index: 5;
            }
            
            {{WRAPPER}} .orbit-content {
                position: absolute;
                display: flex;
                flex-direction: row;
                align-items: center;
                text-align: left;
                width: 204px;
                pointer-events: auto;
                cursor: pointer;
                gap: 10px;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            
            {{WRAPPER}} .orbit-icon {
                flex-shrink: 0;
            }
            
            {{WRAPPER}} .orbit-icon img,
            {{WRAPPER}} .orbit-icon svg {
                display: block;
                width: 80px;
                height: 80px;
                object-fit: contain;
                margin: 0;
            }
            
            {{WRAPPER}} .orbit-text {
                text-align: left;
                flex: 1;
            }
    
            @keyframes orbit-cw-<?php echo $this->get_id(); ?> {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(360deg); }
            }
            
            @keyframes orbit-ccw-<?php echo $this->get_id(); ?> {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(-360deg); }
            }
            
            @keyframes content-cw-<?php echo $this->get_id(); ?> {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(-360deg); }
            }
            
            @keyframes content-ccw-<?php echo $this->get_id(); ?> {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(360deg); }
            }

            @media (max-width: 768px) {
                {{WRAPPER}} .orbit-system-wrapper {
                    min-height: 420px;
                }
                
                {{WRAPPER}} .orbit-content {
                    max-width: 141px;
                    width: auto;
                }
                
                {{WRAPPER}} .orbit-icon img,
                {{WRAPPER}} .orbit-icon svg {
                    width: 40px;
                    height: 40px;
                }
                
                {{WRAPPER}} .elementor-element .orbit-text {
                    font-size: 14px !important;
                    line-height: 21px !important;
                }
            }
    
        <?php 
        foreach ($rings as $i => $ring): 
            $rad_desktop = isset($ring['ring_radius_desktop']) 
                ? (is_array($ring['ring_radius_desktop']) ? (float)$ring['ring_radius_desktop']['size'] : (float)$ring['ring_radius_desktop'])
                : 250;
            $rad_tablet = isset($ring['ring_radius_tablet']) 
                ? (is_array($ring['ring_radius_tablet']) ? (float)$ring['ring_radius_tablet']['size'] : (float)$ring['ring_radius_tablet'])
                : 180;
            $rad_mobile = isset($ring['ring_radius_mobile']) 
                ? (is_array($ring['ring_radius_mobile']) ? (float)$ring['ring_radius_mobile']['size'] : (float)$ring['ring_radius_mobile'])
                : 120;
        ?>
    
            {{WRAPPER}} .orbit-ring-<?php echo $i; ?> {
                --ring-radius: <?php echo $rad_desktop; ?>px;
                width: calc(var(--ring-radius) * 2);
                height: calc(var(--ring-radius) * 2);
            }
            
            {{WRAPPER}} .orbit-ring-<?php echo $i; ?> .orbit-item-wrapper {
                --ring-radius: <?php echo $rad_desktop; ?>px;
            }

            @media (max-width: 1024px) {
                {{WRAPPER}} .orbit-ring-<?php echo $i; ?> {
                    --ring-radius: <?php echo $rad_tablet; ?>px;
                    width: calc(var(--ring-radius) * 2);
                    height: calc(var(--ring-radius) * 2);
                }
                
                {{WRAPPER}} .orbit-ring-<?php echo $i; ?> .orbit-item-wrapper {
                    --ring-radius: <?php echo $rad_tablet; ?>px;
                }
            }

            @media (max-width: 767px) {
                {{WRAPPER}} .orbit-ring-<?php echo $i; ?> {
                    --ring-radius: <?php echo $rad_mobile; ?>px;
                    width: calc(var(--ring-radius) * 2);
                    height: calc(var(--ring-radius) * 2);
                }
                
                {{WRAPPER}} .orbit-ring-<?php echo $i; ?> .orbit-item-wrapper {
                    --ring-radius: <?php echo $rad_mobile; ?>px;
                }
            }
    
        <?php endforeach; ?>
        </style>
    
        <div class="orbit-system-wrapper">
            <?php if (!empty($rings)) :
                foreach ($rings as $i => $ring) :
                    $dur = isset($ring['anim_duration']) ? (float)$ring['anim_duration'] : 20;
                    $dir = isset($ring['direction']) && $ring['direction'] === 'reverse' ? 'reverse' : 'normal';
                    $color = isset($ring['border_color']) ? esc_attr($ring['border_color']) : 'rgba(255, 255, 255, 0.15)';
                    $style = isset($ring['border_style']) ? esc_attr($ring['border_style']) : 'dashed';
    
                    $ring_anim = ($dir === 'reverse') ? 'orbit-ccw-' . $this->get_id() : 'orbit-cw-' . $this->get_id();
                    $item_anim = ($dir === 'reverse') ? 'content-ccw-' . $this->get_id() : 'content-cw-' . $this->get_id();
            ?>
                <div class="orbit-ring orbit-ring-<?php echo esc_attr($i); ?>" 
                    style="border-color: <?php echo $color; ?>; border-style: <?php echo $style; ?>; animation: <?php echo esc_attr($ring_anim); ?> <?php echo $dur; ?>s linear infinite;">
    
                    <?php 
                    if (isset($grouped_items[$i]) && !empty($grouped_items[$i])) :
                        $these_items = $grouped_items[$i];
                        $count = count($these_items);
                        $step = $count > 0 ? 360 / $count : 0;
                        
                        foreach ($these_items as $k => $item) :
                            $angle = $k * $step;
                            $transform = "transform: translate(-50%, -50%) rotate({$angle}deg) translateX(var(--ring-radius)) rotate(-{$angle}deg);";
                    ?>
                    <div class="orbit-item-wrapper" 
                         data-ring-index="<?php echo esc_attr($i); ?>"
                         data-item-index="<?php echo esc_attr($k); ?>"
                         style="<?php echo esc_attr($transform); ?>">
                        <div class="orbit-content" 
                             style="animation: <?php echo esc_attr($item_anim); ?> <?php echo $dur; ?>s linear infinite;">
                            <?php if (!empty($item['image']['url'])) : ?>
                                <div class="orbit-icon">
                                    <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['text'] ?? ''); ?>" />
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($item['text'])) : ?>
                                <div class="orbit-text"><?php echo esc_html($item['text']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
    
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </div>
            <?php 
                endforeach;
            endif; 
            ?>
        </div>
    
        <?php
    }
    
}
?>
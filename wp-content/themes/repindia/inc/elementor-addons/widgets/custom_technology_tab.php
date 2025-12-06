<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH'))
    exit;

class Custom_Technology_Tab extends Widget_Base
{

    public function get_name()
    {
        return 'custom_technology_tab';
    }

    public function get_title()
    {
        return 'Custom Technology Tab';
    }

    public function get_icon()
    {
        return 'fa fa-th';
    }

    public function get_categories()
    {
        return ['general'];
    }

    // Load Elementor’s bundled Swiper (DO NOT load your own)
    public function get_script_depends()
    {
        return ['swiper'];
    }

    public function get_style_depends()
    {
        return ['swiper', 'e-swiper'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_content',
            ['label' => __('Settings', 'repindia')]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_name',
            [
                'label' => __('Tab Name', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('New Tab', 'repindia'),
                'placeholder' => __('Enter tab name', 'repindia'),
            ]
        );

        $repeater->add_control(
            'tab_images',
            [
                'label' => __('Upload Multiple Images', 'repindia'),
                'type' => Controls_Manager::GALLERY,
                'description' => __('Select multiple images for this tab', 'repindia'),
            ]
        );

        $this->add_control(
            'tabs_list',
            [
                'label' => __('Tabs', 'repindia'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_name' => __('Tab 1', 'repindia'),
                    ],
                ],
                'title_field' => '{{{ tab_name }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $tabs_list = $settings['tabs_list'] ?? [];
        
        if (empty($tabs_list)) {
            return;
        }

        // Generate unique ID for this widget instance
        $widget_id = 'tech-tab-' . $this->get_id();
        ?>

        <style>
            .<?php echo esc_attr($widget_id); ?> {
                display: flex;
                gap: 80px;
                max-width: 100%;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav {
                flex: 0 0 350px;
                background: #fff;
                border-radius: 8px;
                padding: 4px;
                height: fit-content;
                box-shadow: 0 0 15px 0 rgba(138, 149, 158, 0.40);
            }
            .js-dark .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav {
                background: #262A30;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav li {
                margin: 0;
                padding: 0;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav li:last-child {
                margin-bottom: 0;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button {
                width: 100%;
                text-align: left;
                padding: 10px 35px;
                background: transparent;
                border: none;
                cursor: pointer;
                font-size: 16px;
                color: #5F6F94;
                border-radius: 4px;
                transition: all 0.3s ease;
                font-family: inherit;
                position: relative;
                font-weight: 500;
                line-height: 24px;
            }
            .js-dark .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button{ color: #aeb6c9; }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button:hover {
                background: rgba(255, 255, 255, 0.5);
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button.active {
                background: #E6E6E6;
                font-weight: 500;
                color: #06283D;
            }
            .js-dark .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button:hover,.js-dark .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button.active{ background: #000;color: #fff; }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button .checkmark-svg {
                display: inline-block;
                width: 24px;
                height: 24px;
                margin-right: 6px;
                vertical-align: middle;
                fill: #06283D;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-images-grid {
                flex: 1;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 4px;
                background: transparent;
                border: none;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-image-item {
                background: #fff;
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 120px;
                transition: opacity 0.3s ease, transform 0.3s ease;
                border-radius: 8px;
            }
            .js-dark .<?php echo esc_attr($widget_id); ?> .tech-image-item{ background: #262A30; }
            .<?php echo esc_attr($widget_id); ?> .tech-image-item.hidden {
                display: none;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-image-item img {
                max-width: 100%;
                max-height: 80px;
                width: auto;
                height: auto;
                object-fit: contain;
            }
            .elementor .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button svg {
                position: absolute;
                left: 8px;
                top: 10px;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-dropdown {
                display: none;
                width: 100%;
                padding: 12px 16px;
                font-size: 16px;
                color: #5F6F94;
                background: #fff;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                cursor: pointer;
                font-family: inherit;
                font-weight: 500;
                line-height: 24px;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%235F6F94' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 16px center;
                padding-right: 40px;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-dropdown:focus {
                outline: none;
                border-color: #06283D;
            }
            @media (max-width: 1200px) {
                .<?php echo esc_attr($widget_id); ?> .tech-images-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }
            @media (max-width: 768px) {
                .<?php echo esc_attr($widget_id); ?> {
                    gap: 20px;
                }
                .<?php echo esc_attr($widget_id); ?> {
                    flex-direction: column;
                }
                .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav {
                    display: none;
                }
                .<?php echo esc_attr($widget_id); ?> .tech-tabs-dropdown {
                    display: block;
                }
                .<?php echo esc_attr($widget_id); ?> .tech-images-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            @media (min-width: 769px) {
                .<?php echo esc_attr($widget_id); ?> .tech-tabs-dropdown {
                    display: none;
                }
            }
        </style>

        <div class="<?php echo esc_attr($widget_id); ?> tech-tab-container">
            <div class="tech-tabs-nav">
                <ul>
                    <li>
                        <button class="tech-tab-btn active" data-tab="all" data-text="All">All</button>
                    </li>
                    <?php foreach ($tabs_list as $tab): 
                        $tab_name = !empty($tab['tab_name']) ? trim($tab['tab_name']) : '';
                        if (empty($tab_name)) continue;
                        $tab_slug = sanitize_title($tab_name);
                    ?>
                        <li>
                            <button class="tech-tab-btn" data-tab="<?php echo esc_attr($tab_slug); ?>" data-text="<?php echo esc_attr($tab_name); ?>">
                                <?php echo esc_html($tab_name); ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <select class="tech-tabs-dropdown" aria-label="<?php esc_attr_e('Select tab', 'repindia'); ?>">
                <option value="all">All</option>
                <?php foreach ($tabs_list as $tab): 
                    $tab_name = !empty($tab['tab_name']) ? trim($tab['tab_name']) : '';
                    if (empty($tab_name)) continue;
                    $tab_slug = sanitize_title($tab_name);
                ?>
                    <option value="<?php echo esc_attr($tab_slug); ?>"><?php echo esc_html($tab_name); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="tech-images-grid">
                <?php 
                // Render all images from all tabs
                foreach ($tabs_list as $tab): 
                    $tab_name = !empty($tab['tab_name']) ? trim($tab['tab_name']) : '';
                    $tab_slug = !empty($tab_name) ? sanitize_title($tab_name) : '';
                    $tab_images = !empty($tab['tab_images']) ? $tab['tab_images'] : [];
                    
                    if (empty($tab_images)) {
                        continue;
                    }
                    
                    foreach ($tab_images as $image):
                        $image_url = !empty($image['url']) ? $image['url'] : '';
                        $image_alt = !empty($image['alt']) ? $image['alt'] : $tab_name;
                        
                        if (empty($image_url)) {
                            continue;
                        }
                ?>
                    <div class="tech-image-item" data-tab="<?php echo esc_attr($tab_slug); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    </div>
                <?php 
                    endforeach;
                endforeach; 
                ?>
            </div>
        </div>

        <script>
            (function() {
                var container = document.querySelector('.<?php echo esc_js($widget_id); ?>');
                if (!container) return;
                
                var tabButtons = container.querySelectorAll('.tech-tab-btn');
                var imageItems = container.querySelectorAll('.tech-image-item');
                var dropdown = container.querySelector('.tech-tabs-dropdown');
                
                // Function to create SVG checkmark
                function createCheckmarkSVG() {
                    var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    svg.setAttribute('class', 'checkmark-svg');
                    svg.setAttribute('viewBox', '0 0 20 20');
                    svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
                    var path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path.setAttribute('d', 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z');
                    path.setAttribute('fill', 'currentColor');
                    svg.appendChild(path);
                    return svg;
                }
                
                function filterImages(activeTab) {
                    // Update button states and checkmarks
                    tabButtons.forEach(function(btn) {
                        var btnText = btn.getAttribute('data-text');
                        var isActive = btn.getAttribute('data-tab') === activeTab;
                        
                        // Always remove active class and checkmark first
                        btn.classList.remove('active');
                        
                        // Remove any existing checkmark SVG or emoji
                        var checkmark = btn.querySelector('.checkmark-svg');
                        if (checkmark) {
                            checkmark.remove();
                        }
                        // Remove emoji images if any
                        var emojiImg = btn.querySelector('img.emoji');
                        if (emojiImg) {
                            emojiImg.remove();
                        }
                        
                        // Set button text
                        btn.textContent = btnText;
                        
                        // Add checkmark SVG and active class only to selected button
                        if (isActive) {
                            btn.classList.add('active');
                            var checkmarkSVG = createCheckmarkSVG();
                            btn.insertBefore(checkmarkSVG, btn.firstChild);
                        }
                    });
                    
                    // Update dropdown value
                    if (dropdown) {
                        dropdown.value = activeTab;
                    }
                    
                    // Filter images
                    imageItems.forEach(function(item) {
                        var itemTab = item.getAttribute('data-tab');
                        if (activeTab === 'all' || itemTab === activeTab) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                }
                
                // Initialize: Add checkmark to default active tab (All)
                var activeBtn = container.querySelector('.tech-tab-btn.active');
                if (activeBtn) {
                    var checkmarkSVG = createCheckmarkSVG();
                    activeBtn.insertBefore(checkmarkSVG, activeBtn.firstChild);
                }
                
                // Add click handlers for tab buttons
                tabButtons.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var tab = this.getAttribute('data-tab');
                        filterImages(tab);
                    });
                });
                
                // Add change handler for dropdown
                if (dropdown) {
                    dropdown.addEventListener('change', function() {
                        var tab = this.value;
                        filterImages(tab);
                    });
                }
            })();
        </script>

        <?php
    }
}
?>
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
                gap: 30px;
                max-width: 100%;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav {
                flex: 0 0 280px;
                background: #E8F4F8;
                border-radius: 8px;
                padding: 20px;
                height: fit-content;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav li {
                margin: 0 0 12px 0;
                padding: 0;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav li:last-child {
                margin-bottom: 0;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button {
                width: 100%;
                text-align: left;
                padding: 12px 16px;
                background: transparent;
                border: none;
                cursor: pointer;
                font-size: 14px;
                color: #333;
                border-radius: 4px;
                transition: all 0.3s ease;
                font-family: inherit;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button:hover {
                background: rgba(255, 255, 255, 0.5);
            }
            .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav button.active {
                background: #fff;
                font-weight: 600;
                color: #0066cc;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-images-grid {
                flex: 1;
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1px;
                background: #e0e0e0;
                border: 1px solid #e0e0e0;
            }
            .<?php echo esc_attr($widget_id); ?> .tech-image-item {
                background: #fff;
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 120px;
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
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
            @media (max-width: 1200px) {
                .<?php echo esc_attr($widget_id); ?> .tech-images-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }
            @media (max-width: 768px) {
                .<?php echo esc_attr($widget_id); ?> {
                    flex-direction: column;
                }
                .<?php echo esc_attr($widget_id); ?> .tech-tabs-nav {
                    flex: 1;
                }
                .<?php echo esc_attr($widget_id); ?> .tech-images-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            @media (max-width: 480px) {
                .<?php echo esc_attr($widget_id); ?> .tech-images-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <div class="<?php echo esc_attr($widget_id); ?> tech-tab-container">
            <div class="tech-tabs-nav">
                <ul>
                    <li>
                        <button class="tech-tab-btn active" data-tab="all">✔ All</button>
                    </li>
                    <?php foreach ($tabs_list as $tab): 
                        $tab_name = !empty($tab['tab_name']) ? trim($tab['tab_name']) : '';
                        if (empty($tab_name)) continue;
                        $tab_slug = sanitize_title($tab_name);
                    ?>
                        <li>
                            <button class="tech-tab-btn" data-tab="<?php echo esc_attr($tab_slug); ?>">
                                <?php echo esc_html($tab_name); ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
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
                
                function filterImages(activeTab) {
                    // Update button states
                    tabButtons.forEach(function(btn) {
                        btn.classList.remove('active');
                        if (btn.getAttribute('data-tab') === activeTab) {
                            btn.classList.add('active');
                        }
                    });
                    
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
                
                // Add click handlers
                tabButtons.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var tab = this.getAttribute('data-tab');
                        filterImages(tab);
                    });
                });
            })();
        </script>

        <?php
    }
}
?>
<?php
/**
 * Analytic Sidebar Nav Widget
 * 
 * NOTE: Icon field changed from textarea (SVG code) to media uploader (icon_image)
 * for easier management. Backward compatibility maintained for existing icon_svg field.
 */

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Analytic_Sidebar_Nav extends Widget_Base
{
    public function get_name()
    {
        return 'analytic_sidebar_nav';
    }
    public function get_title()
    {
        return 'Analytic Sidebar Nav';
    }
    public function get_icon()
    {
        return 'eicon-menu';
    }
    public function get_category()
    {
        return ['general'];
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_sidebar',
            [
                'label' => __('Sidebar Navigation', 'wpc'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label'   => __('Title', 'wpc'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('List Item', 'wpc'),
            ]
        );

        $repeater->add_control(
            'target_id',
            [
                'label'   => __('Target Section ID', 'wpc'),
                'type'    => Controls_Manager::TEXT,
                'default' => '#section-id',
                'description' => 'Example: #sec-abandoned',
            ]
        );

        $repeater->add_control(
            'icon_image',
            [
                'label' => __('Icon / Image - Light Mode (optional)', 'wpc'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'description' => __('Upload an icon or image for light mode. Use SVG/PNG/JPG.', 'wpc'),
            ]
        );

        $repeater->add_control(
            'icon_image_dark',
            [
                'label' => __('Icon / Image - Dark Mode (optional)', 'wpc'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'description' => __('Upload an icon or image for dark mode. Use SVG/PNG/JPG.', 'wpc'),
            ]
        );

        $this->add_control(
            'nav_items',
            [
                'label' => __('Navigation Items', 'wpc'),
                'type'  => Controls_Manager::REPEATER,
                'fields'=> $repeater->get_controls(),
                'default' => [],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Styles', 'wpc'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __('Background', 'wpc'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .analytic-sidebar' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_color',
            [
                'label' => __('Active Color', 'wpc'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#0056FF',
                'selectors' => [
                    '{{WRAPPER}} .analytic-nav li.active' => 'background-color: {{VALUE}}33; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'nav_typo',
                'selector' => '{{WRAPPER}} .analytic-nav li',
            ]
        );

        $this->end_controls_section();
    }

    // Php Render
    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="analytic-sidebar">
            <input type="text" class="analytic-search" placeholder="Search analytics...">

            <ul class="analytic-nav">
                <?php foreach ($settings['nav_items'] as $item): ?>
                    <li data-target="<?php echo esc_attr($item['target_id']); ?>">
                        <?php
                        // Output light and dark mode icons
                        $has_light_icon = !empty($item['icon_image']['url']);
                        $has_dark_icon = !empty($item['icon_image_dark']['url']);
                        $item_title_attr = esc_attr($item['item_title']);
                        
                        if ($has_light_icon || $has_dark_icon || !empty($item['icon_svg'])) {
                            echo '<span class="icon">';
                            
                            if ($has_light_icon) {
                                $icon_url = esc_url($item['icon_image']['url']);
                                echo '<img class="icon-light" src="' . $icon_url . '" alt="' . $item_title_attr . '" />';
                            }
                            
                            if ($has_dark_icon) {
                                $icon_dark_url = esc_url($item['icon_image_dark']['url']);
                                echo '<img class="icon-dark" src="' . $icon_dark_url . '" alt="' . $item_title_attr . '" />';
                            }
                            
                            // Fallback: Support legacy icon_svg field for backward compatibility
                            if (!$has_light_icon && !$has_dark_icon && !empty($item['icon_svg'])) {
                                echo $item['icon_svg'];
                            }
                            
                            echo '</span>';
                        }
                        ?>
                        <span class="title"><?php echo esc_html($item['item_title']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <style>
        .analytic-sidebar {
            position: sticky;
            top: 80px;
            max-height: calc(100vh - 80px);
            overflow-y: auto;
            padding: 10px;
            border-radius: 8px;
        }
        .analytic-sidebar .analytic-search {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .analytic-nav { list-style: none;padding: 0;margin: 0; }
        .analytic-nav li {
            padding: 10px 12px;
            cursor: pointer;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }
        .analytic-nav li:hover { background: #f0f4ff; }
        .analytic-nav li.active { background: #e8f2ff;font-weight: 600; }
        .analytic-nav li .icon svg { width: 18px;height: 18px; }
        .analytic-nav li .icon img { width: 18px;height: 18px;object-fit: contain; }
        
        /* Light/Dark Mode Icon Switching */
        .icon img.icon-dark { display: none; }
        .icon img.icon-light { display: inline-block; }
        
        body.js-dark .icon img.icon-light { display: none; }
        body.js-dark .icon img.icon-dark { display: inline-block; }
        </style>

        <script>
        (function(){

            // Smooth Scroll on Click
            document.querySelectorAll(".analytic-nav li").forEach(item => {
                item.addEventListener("click", () => {
                    const target = document.querySelector(item.dataset.target);
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 80,
                            behavior: "smooth"
                        });
                    }
                });
            });

            // Search Filter
            const searchInput = document.querySelector(".analytic-search");
            searchInput.addEventListener("input", function(){
                const q = this.value.toLowerCase();
                document.querySelectorAll(".analytic-nav li").forEach(li => {
                    li.style.display = li.innerText.toLowerCase().includes(q) ? "flex" : "none";
                });
            });

            // Highlight Active Section on Scroll
            const navItems = document.querySelectorAll(".analytic-nav li");

            const sections = Array.from(navItems).map(item => {
                const id = item.dataset.target;
                return document.querySelector(id);
            });

            window.addEventListener("scroll", () => {
                let scrollPos = window.pageYOffset + 120;

                sections.forEach((sec, index) => {
                    if (!sec) return;
                    if (scrollPos >= sec.offsetTop && scrollPos < sec.offsetTop + sec.offsetHeight) {

                        navItems.forEach(n => n.classList.remove("active"));
                        navItems[index].classList.add("active");

                        navItems[index].scrollIntoView({
                            block: "nearest",
                            behavior: "smooth"
                        });
                    }
                });
            });

        })();
        </script>

        <?php
            }
}

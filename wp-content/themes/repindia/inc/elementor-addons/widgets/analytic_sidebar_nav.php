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
                'label' => __('Sidebar Navigation', 'repindia'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label'   => __('Title', 'repindia'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('List Item', 'repindia'),
            ]
        );

        $repeater->add_control(
            'target_id',
            [
                'label'   => __('Target Section ID', 'repindia'),
                'type'    => Controls_Manager::TEXT,
                'default' => '#section-id',
                'description' => 'Example: #sec-abandoned',
            ]
        );

        $repeater->add_control(
            'icon_image',
            [
                'label' => __('Icon / Image - Light Mode (optional)', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'description' => __('Upload an icon or image for light mode. Use SVG/PNG/JPG.', 'repindia'),
            ]
        );

        $repeater->add_control(
            'icon_image_dark',
            [
                'label' => __('Icon / Image - Dark Mode (optional)', 'repindia'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'description' => __('Upload an icon or image for dark mode. Use SVG/PNG/JPG.', 'repindia'),
            ]
        );

        $this->add_control(
            'nav_items',
            [
                'label' => __('Navigation Items', 'repindia'),
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
                'label' => __('Styles', 'repindia'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __('Background', 'repindia'),
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
                'label' => __('Active Color', 'repindia'),
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
        .elementor-element.video_analytic_sidebar { max-height: 766px;overflow-y: scroll; }
        .elementor-element.right_content_section{ max-height: 1914px;overflow-y: scroll; }
        </style>

        <script>
        (function(){
            'use strict';
            
            // Wait for DOM to be ready
            function init() {
                const rightContentSection = document.querySelector('.right_content_section');
                const navItems = document.querySelectorAll(".analytic-nav li");
                const searchInput = document.querySelector(".analytic-search");
                
                if (!rightContentSection || navItems.length === 0) {
                    // Retry if elements not found
                    setTimeout(init, 100);
                    return;
                }
                
                // Get all target sections
                const sections = Array.from(navItems).map(item => {
                    const id = item.dataset.target;
                    return id ? document.querySelector(id) : null;
                }).filter(sec => sec !== null);
                
                if (sections.length === 0) return;
                
                // Track currently active item
                let currentActiveIndex = -1;
                let isUserScrolling = false;
                let scrollTimeout;
                
                // Helper function to calculate offsetTop relative to container
                // Uses getBoundingClientRect for accurate calculation in all cases
                function getOffsetTop(element, container) {
                    // Get current scroll position
                    const currentScroll = container.scrollTop;
                    
                    // Get bounding rectangles
                    const containerRect = container.getBoundingClientRect();
                    const elementRect = element.getBoundingClientRect();
                    
                    // Calculate the visual offset (difference in viewport positions)
                    const visualOffset = elementRect.top - containerRect.top;
                    
                    // Absolute offset = current scroll + visual offset
                    // This gives us the exact scroll position needed to bring element to top
                    return currentScroll + visualOffset;
                }
                
                // Set first item as active by default
                if (navItems.length > 0) {
                    navItems[0].classList.add("active");
                    currentActiveIndex = 0;
                }
                
                // Smooth Scroll on Click - scroll within right_content_section
                navItems.forEach((item, index) => {
                    item.addEventListener("click", (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // If clicking the same item, do nothing
                        if (currentActiveIndex === index) {
                            return;
                        }
                        
                        const target = document.querySelector(item.dataset.target);
                        if (!target || !rightContentSection || !rightContentSection.contains(target)) return;
                        
                        // Set user scrolling flag
                        isUserScrolling = true;
                        
                        // Update active class immediately
                        navItems.forEach(n => n.classList.remove("active"));
                        item.classList.add("active");
                        currentActiveIndex = index;
                        
                        // Calculate exact offsetTop of target relative to right_content_section
                        // This ensures the section scrolls to the very top of the container
                        const targetOffsetTop = getOffsetTop(target, rightContentSection);
                        
                        // Get maximum scroll position
                        const maxScroll = rightContentSection.scrollHeight - rightContentSection.clientHeight;
                        
                        // Calculate the scroll position to bring target to top
                        // Clamp between 0 and maxScroll to prevent over-scrolling
                        const scrollPosition = Math.max(0, Math.min(targetOffsetTop, maxScroll));
                        
                        // Ensure target scrolls to the very top of the container
                        // Previous sections will be hidden above the viewport (scrolled up)
                        rightContentSection.scrollTo({
                            top: scrollPosition, // Bring to absolute top of container
                            behavior: "smooth"
                        });
                        
                        // Reset user scrolling flag after animation
                        clearTimeout(scrollTimeout);
                        scrollTimeout = setTimeout(() => {
                            isUserScrolling = false;
                        }, 1000);
                    });
                });
                
                // Search Filter
                if (searchInput) {
                    searchInput.addEventListener("input", function(){
                        const q = this.value.toLowerCase();
                        navItems.forEach(li => {
                            const text = li.textContent || li.innerText || '';
                            li.style.display = text.toLowerCase().includes(q) ? "flex" : "none";
                        });
                    });
                }
                
                // Highlight Active Section based on scroll position in right_content_section
                function updateActiveSection() {
                    if (isUserScrolling) return;
                    
                    const scrollTop = rightContentSection.scrollTop;
                    const containerHeight = rightContentSection.clientHeight;
                    const viewportTop = scrollTop;
                    const viewportBottom = scrollTop + containerHeight;
                    
                    let activeIndex = -1;
                    let minDistance = Infinity;
                    
                    // Find which section is most visible in the viewport
                    sections.forEach((sec, index) => {
                        if (!sec) return;
                        
                        const secOffsetTop = sec.offsetTop;
                        const secOffsetBottom = secOffsetTop + sec.offsetHeight;
                        
                        // Check if section is visible in viewport
                        if (secOffsetTop <= viewportBottom && secOffsetBottom >= viewportTop) {
                            // Section is visible, calculate how much is visible
                            const visibleTop = Math.max(secOffsetTop, viewportTop);
                            const visibleBottom = Math.min(secOffsetBottom, viewportBottom);
                            const visibleHeight = visibleBottom - visibleTop;
                            const distance = Math.abs(viewportTop - secOffsetTop);
                            
                            // Prefer section that starts closest to viewport top
                            if (visibleHeight > 0 && distance < minDistance) {
                                minDistance = distance;
                                activeIndex = index;
                            }
                        }
                    });
                    
                    // If no section is clearly visible, find the closest one
                    if (activeIndex === -1 && sections.length > 0) {
                        sections.forEach((sec, index) => {
                            if (!sec) return;
                            const secOffsetTop = sec.offsetTop;
                            const distance = Math.abs(scrollTop - secOffsetTop);
                            
                            if (distance < minDistance) {
                                minDistance = distance;
                                activeIndex = index;
                            }
                        });
                    }
                    
                    // Update active class
                    if (activeIndex !== -1 && activeIndex !== currentActiveIndex) {
                        navItems.forEach(n => n.classList.remove("active"));
                        if (navItems[activeIndex]) {
                            navItems[activeIndex].classList.add("active");
                            currentActiveIndex = activeIndex;
                            
                            // Scroll sidebar item into view if needed
                            const sidebar = document.querySelector('.analytic-sidebar');
                            if (sidebar) {
                                const itemRect = navItems[activeIndex].getBoundingClientRect();
                                const sidebarRect = sidebar.getBoundingClientRect();
                                if (itemRect.bottom > sidebarRect.bottom || itemRect.top < sidebarRect.top) {
                                    navItems[activeIndex].scrollIntoView({
                                        block: "nearest",
                                        behavior: "smooth"
                                    });
                                }
                            }
                        }
                    }
                }
                
                // Listen to scroll events on right_content_section container
                rightContentSection.addEventListener("scroll", () => {
                    updateActiveSection();
                }, { passive: true });
                
                // Initial call to set active section
                setTimeout(() => {
                    updateActiveSection();
                }, 200);
            }
            
            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
            
            // Also try on window load for Elementor
            window.addEventListener('load', () => {
                setTimeout(init, 300);
            });

        })();
        </script>

        <?php
            }
}

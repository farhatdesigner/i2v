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
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label' => __('Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => __('List Item', 'repindia'),
            ]
        );

        $repeater->add_control(
            'target_id',
            [
                'label' => __('Target Section ID', 'repindia'),
                'type' => Controls_Manager::TEXT,
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
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Styles', 'repindia'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => __('Background', 'repindia'),
                'type' => Controls_Manager::COLOR,
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
                'type' => Controls_Manager::COLOR,
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
            <button type="button" class="analytic-mobile-toggle" aria-label="Toggle menu">
                <span><?php echo esc_html(wpml_t('Select video analytic', 'Repindia-Widgets', 'Analytic Sidebar title')); ?></span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

            <div class="analytic-search-wrapper">

                <!-- <svg class="analytic-search-icon" width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.33333 12.6667C10.2789 12.6667 12.6667 10.2789 12.6667 7.33333C12.6667 4.38781 10.2789 2 7.33333 2C4.38781 2 2 4.38781 2 7.33333C2 10.2789 4.38781 12.6667 7.33333 12.6667Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M14 14L11.1 11.1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg> -->

                <svg class="analytic-search-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M21 22C20.74 22 20.49 21.9 20.29 21.71L14.9 16.32C13.54 17.37 11.84 18 10 18C5.59 18 2 14.41 2 10C2 5.59 5.59 2 10 2C14.41 2 18 5.59 18 10C18 11.85 17.37 13.55 16.32 14.9L21.71 20.29C22.1 20.68 22.1 21.31 21.71 21.7C21.51 21.9 21.26 21.99 21 21.99V22ZM10 4C6.69 4 4 6.69 4 10C4 13.31 6.69 16 10 16C13.31 16 16 13.31 16 10C16 6.69 13.31 4 10 4Z"
                        fill="#AEB6C9" />
                </svg>

                <input type="text" class="analytic-search" placeholder="Search analytics...">
            </div>
            <hr class="analytic-sidebar-hr">
            <ul class="analytic-nav">
                <?php foreach ($settings['nav_items'] as $item): ?>
                    <li data-target="<?php echo esc_attr($item['target_id']); ?>">
                        <?php
                        // Output light and dark mode icons
                        $has_light_icon = !empty($item['icon_image']['url']);
                        $has_dark_icon = !empty($item['icon_image_dark']['url']);
                        $item_title_attr = esc_attr($item['item_title']); ?>
                        <!-- <span class="check-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.3333 4L6 11.3333L2.66667 8" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg> -->

                        <!-- <svg class="check-icon" width="14" height="10" viewBox="0 0 14 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L5.70711 9.70711C5.31658 10.0976 4.68342 10.0976 4.29289 9.70711L0.292893 5.70711C-0.0976311 5.31658 -0.0976311 4.68342 0.292893 4.29289C0.683417 3.90237 1.31658 3.90237 1.70711 4.29289L5 7.58579L12.2929 0.292893C12.6834 -0.0976311 13.3166 -0.0976311 13.7071 0.292893Z"
                                fill="#D7DBE4" />
                        </svg> -->

                        
<svg  class="check-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<g opacity="0.5">
<path fill-rule="evenodd" clip-rule="evenodd" d="M16.7071 5.29289C17.0976 5.68342 17.0976 6.31658 16.7071 6.70711L8.70711 14.7071C8.31658 15.0976 7.68342 15.0976 7.29289 14.7071L3.29289 10.7071C2.90237 10.3166 2.90237 9.68342 3.29289 9.29289C3.68342 8.90237 4.31658 8.90237 4.70711 9.29289L8 12.5858L15.2929 5.29289C15.6834 4.90237 16.3166 4.90237 16.7071 5.29289Z" fill="#06283D"/>
</g>
</svg>


                        </span>
                        <?php
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
                /* position: sticky !important;
                                    top: 80px !important;
                                    max-height: calc(100vh - 80px) !important; */
                overflow-y: auto !important;
                overflow-x: hidden !important;
                /* padding: 10px; */
                border-radius: 8px;
                -webkit-overflow-scrolling: touch !important;
                /* Smooth scrolling on iOS */
                scroll-behavior: smooth;
                overscroll-behavior: contain;
                scrollbar-width: thin;
                scrollbar-color: #d5d5d5 transparent;
                /* Ensure mouse wheel scrolling works */
            }

            .analytic-sidebar::-webkit-scrollbar {
                width: 6px;
            }

            .analytic-sidebar::-webkit-scrollbar-track {
                background: transparent;
                border-radius: 10px;
            }

            .analytic-sidebar::-webkit-scrollbar-thumb {
                background: #d5d5d5;
                border-radius: 10px;
                transition: background 0.3s ease;
            }

            .analytic-sidebar::-webkit-scrollbar-thumb:hover {
                background: #d5d5d5;
            }

            .analytic-sidebar::-webkit-scrollbar-button {
                display: none;
                height: 0;
                width: 0;
            }

            .analytic-sidebar .analytic-search-wrapper {
                position: relative;
                margin-bottom: 0;
                padding: 8px;
            }

            .analytic-sidebar .analytic-search-wrapper .analytic-search-icon {
                position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    width: 24px;
    height: 24px;
    color: #999;
    pointer-events: none;
    z-index: 1;
            }

            .analytic-sidebar .analytic-search {
                width: 100%;
                padding: 12px 8px 12px 8px;
                border: 1px solid #ddd;
                border-radius: 8px;
                background: #F2F5FA;
            }

            .analytic-sidebar .analytic-search::placeholder {
                color: #999;
            }

            .analytic-sidebar .analytic-search:focus,
            .analytic-sidebar .analytic-search:focus-visible {
                outline: none !important;
                box-shadow: none !important;
            }

input[type="text" i] {
    padding-block: 0px;
    padding-inline: 0px;
}

.video_analytic_sidebar .elementor-heading-title {
    padding: 8px;
}
.js-dark .analytic-nav li .check-icon path {
    fill: #D7DBE4;
}
.js-dark .video_analytic_sidebar  .elementor-heading-title {
    color: rgb(255 255 255 / 60%) !important;
    padding: 8px 8px 0 8px;
}
            .analytic-nav {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .analytic-nav li {
                padding: 10px 12px 12px 30px;
                cursor: pointer;
                border-radius: 6px;
                display: flex;
                align-items: center;
                gap: 4px;
                transition: 0.2s;
                margin-bottom: 2px;
            }

            .analytic-nav li:hover {
                background: #f0f4ff;
            }

            .analytic-nav li.active {
                background: #E6E6E6 !important;
                font-weight: 600;
            }

            .analytic-nav li .icon svg {
                width: 18px;
                height: 18px;
            }

            .analytic-nav li .icon img {
                width: 24px;
                height: 24px;
                object-fit: contain;
            }

            /* Check icon for active items */
            .analytic-nav li .check-icon {
                display: none;
                margin-left: 0;
                width: 16px;
                height: 16px;
                color: #418259;
                flex-shrink: 0;
                position: absolute;
                left: 16px;
            }

            .analytic-nav li.active .check-icon {
                display: block;
            }

            .analytic-nav li .check-icon svg {
                width: 16px;
                height: 16px;
            }


            .js-dark .analytic-nav li:hover {
                background: rgba(255, 255, 255, 0.15);
            }

            .js-dark .analytic-nav li span.title {
                color: #D7DBE4 !important;
            }

            .js-dark .analytic-sidebar .analytic-search {
                background: #31353B;
            }

            .js-dark .analytic-sidebar .analytic-search::placeholder {
                color: rgb(255 255 255 / 60%);
                opacity: 1;
                background: 1px solid rgb(255 255 255 / 15%);
            }

            /* Light/Dark Mode Icon Switching */
            .icon img.icon-dark {
                display: none;
            }

            .icon img.icon-light {
                display: inline-block;
            }

            body.js-dark .icon img.icon-light {
                display: none;
            }

            body.js-dark .icon img.icon-dark {
                display: inline-block;
            }

            /* Enable manual scrolling for sidebar - let the sticky sidebar handle its own scroll */
            .video_analytic_sidebar,
            .elementor-element.video_analytic_sidebar {
                height: auto;
                max-height: max-content;
                position: sticky;
                top: 100px;
            }

            /* Enable manual scrolling for right content section */
            .right_content_section,
            .elementor-element.right_content_section {
                max-height: 1914px !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                -webkit-overflow-scrolling: touch !important;
                scroll-behavior: smooth;
                /* Ensure mouse wheel scrolling works */
                overscroll-behavior: contain;
                scrollbar-width: thin;
                scrollbar-color: #d5d5d5 transparent;
            }

            .right_content_section::-webkit-scrollbar,
            .elementor-element.right_content_section::-webkit-scrollbar {
                width: 6px;
            }

            .right_content_section::-webkit-scrollbar-track,
            .elementor-element.right_content_section::-webkit-scrollbar-track {
                background: transparent;
                border-radius: 10px;
            }

            .right_content_section::-webkit-scrollbar-thumb,
            .elementor-element.right_content_section::-webkit-scrollbar-thumb {
                background: #d5d5d5;
                border-radius: 10px;
                transition: background 0.3s ease;
            }

            .right_content_section::-webkit-scrollbar-thumb:hover,
            .elementor-element.right_content_section::-webkit-scrollbar-thumb:hover {
                background: #d5d5d5;
            }

            .right_content_section::-webkit-scrollbar-button,
            .elementor-element.right_content_section::-webkit-scrollbar-button {
                display: none;
                height: 0;
                width: 0;
            }

            html.lenis,
            body {
                overflow-x: visible;
            }
            
.js-dark .analytic-sidebar-hr {
    color: #C1C4C6;
}

.js-dark .analytic-sidebar {
    scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
}

.js-dark .analytic-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
}

.js-dark .analytic-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}

.js-dark .right_content_section,
.js-dark .elementor-element.right_content_section {
    scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
}

.js-dark .right_content_section::-webkit-scrollbar-thumb,
.js-dark .elementor-element.right_content_section::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
}

.js-dark .right_content_section::-webkit-scrollbar-thumb:hover,
.js-dark .elementor-element.right_content_section::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}

            /* Mobile Dropdown Styles */
            @media (max-width: 768px) {
                .analytic-sidebar {
                    position: relative !important;
                    top: auto !important;
                    max-height: none !important;
                    overflow: visible !important;
                    padding: 8px;
                }

                .analytic-sidebar .analytic-search-wrapper {
                    margin-bottom: 12px;
                    padding: 0;

                }

                /* Mobile dropdown button */
                .analytic-mobile-toggle {
                    display: block;
                    width: 100%;
                    padding: 12px;
                    margin-bottom: 12px;
                    background: #f5f5f5;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    cursor: pointer;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                .analytic-mobile-toggle svg {
                    width: 20px;
                    height: 20px;
                    transition: transform 0.3s ease;
                }

                .analytic-mobile-toggle.active svg {
                    transform: rotate(180deg);
                }

                /* Hide nav by default on mobile */
                .analytic-nav {
                    display: none !important;
                    max-height: 400px;
                    overflow-y: auto;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    /* background: #fff; */
                    margin-top: 12px;
                    position: relative;
                    z-index: 10;
                }

                .analytic-nav.mobile-open {
                    display: block !important;
                }

                /* Ensure toggle button is visible and clickable on mobile */
                .analytic-mobile-toggle {
                    display: flex !important;
                    z-index: 10;
                    position: relative;
                }

                .right_content_section,
                .elementor-element.right_content_section {
                    max-height: 600px !important;
                }
            }

            @media (max-width: 767px) {

                .video_analytic_sidebar,
                .elementor-element.video_analytic_sidebar {
                    position: static;
                }
            }

            @media (min-width: 769px) {
                .analytic-mobile-toggle {
                    display: none !important;
                }

                .analytic-nav {
                    display: block !important;
                    padding: 8px;
                }
            }

            /* Ensure search icon is visible on all screen sizes */
            .analytic-sidebar .analytic-search-wrapper .analytic-search-icon {
                display: block !important;
            }
        </style>

        <script>
            (function () {
                'use strict';

                // Initialize mobile dropdown separately - runs immediately
                let initAttempts = 0;
                const maxInitAttempts = 50; // Try for 5 seconds

                function initMobileDropdown() {
                    initAttempts++;
                    if (initAttempts > maxInitAttempts) {
                        console.warn('Analytic Sidebar: Mobile dropdown initialization timeout');
                        return;
                    }

                    const sidebar = document.querySelector('.analytic-sidebar');
                    if (!sidebar) {
                        setTimeout(initMobileDropdown, 100);
                        return;
                    }

                    const toggleBtn = sidebar.querySelector(".analytic-mobile-toggle");
                    const navList = sidebar.querySelector(".analytic-nav");

                    if (!toggleBtn || !navList) {
                        setTimeout(initMobileDropdown, 100);
                        return;
                    }

                    // Prevent multiple initializations by checking for data attribute
                    if (toggleBtn.dataset.initialized === 'true') {
                        return;
                    }
                    toggleBtn.dataset.initialized = 'true';

                    // Get the currently active item text for the toggle button
                    function updateToggleText() {
                        const activeItem = navList.querySelector('li.active');
                        const toggleSpan = toggleBtn.querySelector('span');
                        if (toggleSpan) {
                            if (activeItem) {
                                const titleElement = activeItem.querySelector('.title');
                                if (titleElement) {
                                    toggleSpan.textContent = titleElement.textContent.trim();
                                }
                            } else {
                                toggleSpan.textContent = 'Select video analytic';
                            }
                        }
                    }

                    // Toggle dropdown on button click - use multiple handlers for compatibility
                    function toggleDropdown(e) {
                        if (e) {
                            e.preventDefault();
                            e.stopPropagation();
                        }

                        const isActive = toggleBtn.classList.contains('active');

                        if (isActive) {
                            toggleBtn.classList.remove('active');
                            navList.classList.remove('mobile-open');
                        } else {
                            toggleBtn.classList.add('active');
                            navList.classList.add('mobile-open');
                        }
                    }

                    // Attach click handler
                    toggleBtn.addEventListener('click', toggleDropdown, false);

                    // Also handle touch events for mobile devices
                    toggleBtn.addEventListener('touchend', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        toggleDropdown(e);
                    }, false);

                    // Make sure button is clickable and not disabled
                    toggleBtn.disabled = false;
                    toggleBtn.style.pointerEvents = 'auto';
                    toggleBtn.style.cursor = 'pointer';

                    // Initial update
                    updateToggleText();

                    // Watch for active class changes to update toggle text
                    const observer = new MutationObserver(function (mutations) {
                        mutations.forEach(function (mutation) {
                            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                                updateToggleText();
                            }
                        });
                    });

                    // Observe all nav items for class changes
                    const navItems = navList.querySelectorAll('li');
                    navItems.forEach(function (item) {
                        observer.observe(item, { attributes: true, attributeFilter: ['class'] });
                    });
                }

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

                    // Check if already initialized to prevent duplicate event listeners
                    const sidebar = document.querySelector('.analytic-sidebar');
                    if (sidebar && sidebar.dataset.initialized === 'true') {
                        return;
                    }
                    if (sidebar) {
                        sidebar.dataset.initialized = 'true';
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
                            if (!target || !rightContentSection) return;

                            // Ensure target is visible (remove any display:none that might be hiding it)
                            if (target.style.display === 'none') {
                                target.style.display = '';
                            }

                            // Check if target is within rightContentSection or its children
                            let targetInContainer = rightContentSection.contains(target);
                            if (!targetInContainer) {
                                // Try to find the target's parent that is within rightContentSection
                                let parent = target.parentElement;
                                while (parent && parent !== document.body) {
                                    if (rightContentSection.contains(parent)) {
                                        targetInContainer = true;
                                        break;
                                    }
                                    parent = parent.parentElement;
                                }
                            }

                            // If target is not in container, try to scroll to it anyway (might be in a nested structure)
                            // We'll still attempt to scroll

                            // Set user scrolling flag
                            isUserScrolling = true;

                            // Update active class immediately
                            navItems.forEach(n => n.classList.remove("active"));
                            item.classList.add("active");
                            currentActiveIndex = index;

                            // Ensure all content sections are visible (find all sections that match nav item targets)
                            navItems.forEach(navItem => {
                                const sectionId = navItem.dataset.target;
                                if (sectionId) {
                                    const section = document.querySelector(sectionId);
                                    if (section) {
                                        // Make sure section is visible
                                        if (section.style.display === 'none') {
                                            section.style.display = '';
                                        }
                                        // Also check parent elements
                                        let parent = section.parentElement;
                                        while (parent && parent !== document.body) {
                                            if (parent.style.display === 'none') {
                                                parent.style.display = '';
                                            }
                                            parent = parent.parentElement;
                                        }
                                    }
                                }
                            });

                            // Calculate exact offsetTop of target relative to right_content_section
                            // This ensures the section scrolls to the very top of the container
                            let targetOffsetTop = 0;
                            let scrollPosition = 0;

                            if (targetInContainer || rightContentSection.contains(target)) {
                                targetOffsetTop = getOffsetTop(target, rightContentSection);
                                // Get maximum scroll position
                                const maxScroll = rightContentSection.scrollHeight - rightContentSection.clientHeight;
                                // Calculate the scroll position to bring target to top
                                // Clamp between 0 and maxScroll to prevent over-scrolling
                                scrollPosition = Math.max(0, Math.min(targetOffsetTop, maxScroll));
                            } else {
                                // If target is not in container, calculate relative to document
                                const targetRect = target.getBoundingClientRect();
                                const containerRect = rightContentSection.getBoundingClientRect();
                                const currentScroll = rightContentSection.scrollTop;
                                targetOffsetTop = currentScroll + (targetRect.top - containerRect.top);
                                const maxScroll = rightContentSection.scrollHeight - rightContentSection.clientHeight;
                                scrollPosition = Math.max(0, Math.min(targetOffsetTop, maxScroll));
                            }

                            // Function to perform the scroll - try multiple methods
                            const performScroll = () => {
                                // Always scroll the container first (this is the primary method)
                                try {
                                    if (rightContentSection) {
                                        if (rightContentSection.scrollTo) {
                                            rightContentSection.scrollTo({
                                                top: scrollPosition,
                                                behavior: "smooth"
                                            });
                                        } else {
                                            rightContentSection.scrollTop = scrollPosition;
                                        }
                                    }
                                } catch (e) {
                                    console.warn('Container scroll failed:', e);
                                }

                                // On mobile, also ensure the target is visible in viewport
                                if (window.innerWidth <= 768) {
                                    setTimeout(() => {
                                        try {
                                            // Check if target is visible in the container viewport
                                            const containerRect = rightContentSection.getBoundingClientRect();
                                            const targetRect = target.getBoundingClientRect();

                                            // If target is not visible in container, scroll again
                                            if (targetRect.top < containerRect.top || targetRect.bottom > containerRect.bottom) {
                                                // Recalculate and scroll
                                                const newTargetOffsetTop = getOffsetTop(target, rightContentSection);
                                                const newMaxScroll = rightContentSection.scrollHeight - rightContentSection.clientHeight;
                                                const newScrollPosition = Math.max(0, Math.min(newTargetOffsetTop, newMaxScroll));

                                                if (rightContentSection.scrollTo) {
                                                    rightContentSection.scrollTo({
                                                        top: newScrollPosition,
                                                        behavior: "smooth"
                                                    });
                                                } else {
                                                    rightContentSection.scrollTop = newScrollPosition;
                                                }
                                            }
                                        } catch (e) {
                                            console.warn('Mobile scroll verification failed:', e);
                                        }
                                    }, 200);
                                }
                            };

                            // On mobile, handle dropdown and scroll
                            if (window.innerWidth <= 768) {
                                const mobileToggleBtn = document.querySelector(".analytic-mobile-toggle");
                                const navList = document.querySelector(".analytic-nav");

                                // Update mobile toggle text
                                if (mobileToggleBtn) {
                                    const titleElement = item.querySelector('.title');
                                    if (titleElement) {
                                        const toggleSpan = mobileToggleBtn.querySelector('span');
                                        if (toggleSpan) {
                                            toggleSpan.textContent = titleElement.textContent.trim();
                                        }
                                    }

                                    // Close dropdown if open
                                    if (navList && navList.classList.contains('mobile-open')) {
                                        mobileToggleBtn.classList.remove('active');
                                        navList.classList.remove('mobile-open');

                                        // Scroll immediately (don't wait for dropdown animation)
                                        performScroll();
                                    } else {
                                        // Dropdown already closed, scroll immediately
                                        performScroll();
                                    }
                                } else {
                                    // No mobile toggle button, scroll immediately
                                    performScroll();
                                }
                            } else {
                                // Desktop: scroll immediately
                                performScroll();
                            }

                            // Reset user scrolling flag after animation
                            clearTimeout(scrollTimeout);
                            scrollTimeout = setTimeout(() => {
                                isUserScrolling = false;
                            }, 1000);
                        });
                    });

                    // Search Filter
                    if (searchInput) {
                        searchInput.addEventListener("input", function () {
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

                                // Update mobile toggle text
                                const mobileToggleBtn = document.querySelector(".analytic-mobile-toggle");
                                if (mobileToggleBtn) {
                                    const titleElement = navItems[activeIndex].querySelector('.title');
                                    if (titleElement) {
                                        const toggleSpan = mobileToggleBtn.querySelector('span');
                                        if (toggleSpan) {
                                            toggleSpan.textContent = titleElement.textContent.trim();
                                        }
                                    }
                                }

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
                function initAll() {
                    init();
                    initMobileDropdown();
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initAll);
                } else {
                    initAll();
                }

                // Also try on window load for Elementor
                window.addEventListener('load', () => {
                    setTimeout(initAll, 300);
                });

                // Support Elementor's frontend rendering
                if (typeof elementorFrontend !== 'undefined') {
                    elementorFrontend.hooks.addAction('frontend/element_ready/global', () => {
                        setTimeout(initAll, 200);
                    });
                }

                // Immediate initialization attempt
                setTimeout(initAll, 100);

            })();
        </script>

        <?php
    }
}

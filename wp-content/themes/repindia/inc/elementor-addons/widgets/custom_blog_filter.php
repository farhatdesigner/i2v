<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Custom_Blog_Filter extends Widget_Base
{
    public function get_name()
    {
        return 'custom_blog_filter';
    }
    
    public function get_title()
    {
        return 'Custom Blog Filter';
    }
    
    public function get_icon()
    {
        return 'fa fa-th';
    }
    
    public function get_category()
    {
        return ['general'];
    }
    
    /**
     * Get all registered post types
     */
    private function get_post_types()
    {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = ['post' => __('Post', 'repindia')];
        
        foreach ($post_types as $post_type) {
            if ($post_type->name !== 'post' && $post_type->name !== 'page' && $post_type->name !== 'attachment') {
                $options[$post_type->name] = $post_type->label;
            }
        }
        
        return $options;
    }
    
    /**
     * Get all registered taxonomies
     */
    private function get_all_taxonomies()
    {
        $taxonomies = get_taxonomies(['public' => true], 'objects');
        $result = [];
        
        foreach ($taxonomies as $taxonomy) {
            // Skip built-in taxonomies that are not commonly used
            if (in_array($taxonomy->name, ['post_format', 'nav_menu', 'link_category'])) {
                continue;
            }
            
            $result[$taxonomy->name] = [
                'label' => $taxonomy->label,
                'object_type' => $taxonomy->object_type,
            ];
        }
        
        return $result;
    }
    
    /**
     * Get terms for a taxonomy
     */
    private function get_taxonomy_terms($taxonomy)
    {
        if (!taxonomy_exists($taxonomy)) {
            return [];
        }
        
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ]);
        
        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }
        
        $options = [];
        foreach ($terms as $term) {
            $options[$term->term_id] = $term->name;
        }
        
        return $options;
    }
    
    /**
     * Get post count for a taxonomy term
     */
    private function get_term_post_count($term_id, $taxonomy, $base_query_args = [])
    {
        $args = array_merge($base_query_args, [
            'post_type' => 'newsroom',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term_id,
                ],
            ],
        ]);
        
        $query = new \WP_Query($args);
        return $query->found_posts;
    }
    
    protected function register_controls()
    {
        // Main Settings Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content Settings', 'repindia'),
            ]
        );

        // Columns
        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'default' => '4',
            ]
        );

        // Posts Per Page
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'repindia'),
                'type' => Controls_Manager::NUMBER,
                'default' => 12,
                'min' => 1,
                'max' => 100,
            ]
        );

        // Show Pagination
        $this->add_control(
            'show_pagination',
            [
                'label' => __('Show Pagination', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'repindia'),
                'label_off' => __('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->end_controls_section();

        // Add only newsroom_type taxonomy filter section
        $this->start_controls_section(
            'section_taxonomy_newsroom_type',
            [
                'label' => __('Filter by Newsroom Type', 'repindia'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add control to enable/disable newsroom_type filter
        $this->add_control(
            'taxonomy_newsroom_type_enable',
            [
                'label' => __('Filter by Newsroom Type', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'repindia'),
                'label_off' => __('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        // Get terms for newsroom_type taxonomy
        $terms = $this->get_taxonomy_terms('newsroom_type');
        
        if (!empty($terms)) {
            $this->add_control(
                'taxonomy_newsroom_type_terms',
                [
                    'label' => __('Select Newsroom Type', 'repindia'),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $terms,
                    'multiple' => true,
                    'label_block' => true,
                    'condition' => [
                        'taxonomy_newsroom_type_enable' => 'yes',
                    ],
                ]
            );
        } else {
            $this->add_control(
                'taxonomy_newsroom_type_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __('No terms found for Newsroom Type.', 'repindia'),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    'condition' => [
                        'taxonomy_newsroom_type_enable' => 'yes',
                    ],
                ]
            );
        }

        $this->end_controls_section();
    }

    /**
     * Build query arguments based on settings
     */
    private function build_query_args($settings, $get_all = false)
    {
        // Hardcode post type to 'newsroom'
        $post_type = 'newsroom';
        $posts_per_page = !empty($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 12;
        
        // For filter widget, get all posts initially for client-side filtering
        if ($get_all) {
            $posts_per_page = -1;
        }
        
        $args = [
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => true,
        ];
        
        // Build tax_query based on newsroom_type taxonomy filter only (for initial load)
        $tax_query = [];
        
        // Check for newsroom_type filter
        if (!empty($settings['taxonomy_newsroom_type_enable']) && $settings['taxonomy_newsroom_type_enable'] === 'yes') {
            $selected_terms = !empty($settings['taxonomy_newsroom_type_terms']) ? $settings['taxonomy_newsroom_type_terms'] : [];
            
            if (!empty($selected_terms) && is_array($selected_terms)) {
                $selected_terms = array_map('intval', $selected_terms);
                $tax_query[] = [
                    'taxonomy' => 'newsroom_type',
                    'field' => 'term_id',
                    'terms' => $selected_terms,
                ];
            }
        }
        
        // Add tax_query if we have taxonomy filters
        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }
        
        return $args;
    }

    /**
     * Get first taxonomy term for a post from newsroom_categories
     */
    private function get_post_taxonomy_term($post_id, $post_type)
    {
        // Get terms from newsroom_categories taxonomy only
        $terms = get_the_terms($post_id, 'newsroom_categories');
        
        if (!empty($terms) && !is_wp_error($terms) && !empty($terms[0]->name)) {
            return [
                'name' => $terms[0]->name,
                'taxonomy' => 'newsroom_categories',
            ];
        }
        
        return null;
    }

    /**
     * Render pagination
     */
    private function render_pagination($query)
    {
        if (!$query->max_num_pages || $query->max_num_pages <= 1) {
            return;
        }
        
        $pagination_args = [
            'total' => $query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'prev_text' => __('&laquo; Previous', 'repindia'),
            'next_text' => __('Next &raquo;', 'repindia'),
        ];
        
        if (is_front_page()) {
            $pagination_args['current'] = max(1, get_query_var('page'));
        }
        
        echo '<div class="custom-latest-resource-pagination">';
        echo paginate_links($pagination_args);
        echo '</div>';
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $columns = !empty($settings['columns']) ? intval($settings['columns']) : 4;
        // Hardcode post type to 'newsroom'
        $post_type = 'newsroom';
        
        // Don't run query in Elementor editor preview unnecessarily
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            echo '<div class="custom-blog-filter-wrapper">';
            echo '<p>' . esc_html__('Blog filter will appear here on the frontend.', 'repindia') . '</p>';
            echo '</div>';
            return;
        }
        
        // Get posts per page setting
        $posts_per_page = !empty($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 12;
        
        // First, get all posts for counting categories
        $all_query_args = $this->build_query_args($settings, true);
        $all_query = new \WP_Query($all_query_args);
        
        // Get all newsroom_categories terms with counts
        $categories = get_terms([
            'taxonomy' => 'newsroom_categories',
            'hide_empty' => false,
        ]);
        
        // Calculate counts for each category based on all posts
        $category_counts = [];
        $all_posts_data = [];
        
        if ($all_query->have_posts()) {
            while ($all_query->have_posts()) {
                $all_query->the_post();
                $post_id = get_the_ID();
                $post_categories = get_the_terms($post_id, 'newsroom_categories');
                $featured = get_field('featured_news', $post_id);
                
                $all_posts_data[] = [
                    'id' => $post_id,
                    'title' => get_the_title(),
                    'categories' => $post_categories && !is_wp_error($post_categories) ? array_map(function($t) { return $t->term_id; }, $post_categories) : [],
                    'featured' => !empty($featured),
                ];
                
                if ($post_categories && !is_wp_error($post_categories)) {
                    foreach ($post_categories as $cat) {
                        if (!isset($category_counts[$cat->term_id])) {
                            $category_counts[$cat->term_id] = 0;
                        }
                        $category_counts[$cat->term_id]++;
                    }
                }
            }
            wp_reset_postdata();
        }
        
        // Filter out categories with zero count
        $categories_with_counts = [];
        foreach ($categories as $cat) {
            if (!is_wp_error($cat) && isset($category_counts[$cat->term_id]) && $category_counts[$cat->term_id] > 0) {
                $categories_with_counts[] = [
                    'term' => $cat,
                    'count' => $category_counts[$cat->term_id],
                ];
            }
        }
        
        $total_posts = count($all_posts_data);
        
        // Calculate featured posts count
        $featured_count = 0;
        foreach ($all_posts_data as $post_data) {
            if (!empty($post_data['featured'])) {
                $featured_count++;
            }
        }
        
        // Now get initial posts with pagination limit
        $query_args = $this->build_query_args($settings, false);
        $query_args['posts_per_page'] = $posts_per_page;
        $query = new \WP_Query($query_args);
        ?>
        
        <style>
            .custom-blog-filter-wrapper {
                display: flex;
                gap: 49px;
                max-width: 100%;
                margin: 0 auto;
                padding: 0px;
                background: transparent;
            }
            .custom-blog-filter-sidebar {
                width: 345px;
                flex-shrink: 0;
                background: transparent;
                border-radius: 0;
                padding: 0;
            }
            .custom-blog-filter-search {
                margin-bottom: 24px;
                position: relative;
                border-bottom: 1px dashed #D7DBE4;
                padding-bottom: 24px;
            }
            .custom-blog-filter-search-wrapper {
                position: relative;
                display: flex;
                align-items: center;
            }
            .custom-blog-filter-search input {
                width: 100%;
                padding: 12px 40px;
                border: 1px solid #E5E9EC;
                height: 48px;
                border-radius: 12px;
                font-size: 16px;
                font-style: normal;
                font-weight: 400;
                line-height: 24px;
                overflow: hidden;
                color: #757575;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .custom-blog-filter-search-icon {
                position: absolute;
                left: 12px;
                width: 20px;
                height: 20px;
                pointer-events: none;
                color: #949494;
            }
            .custom-blog-filter-search-clear {
                position: absolute;
                right: 12px;
                width: 20px;
                height: 20px;
                cursor: pointer;
                display: none;
                align-items: center;
                justify-content: center;
                color: #949494;
                background: transparent;
                border: none;
                padding: 0;
            }
            .custom-blog-filter-search-clear.visible {
                display: flex;
            }
            .custom-blog-filter-search-clear:hover {
                color: #666;
            }
            .custom-blog-filter-accordion {
                margin-bottom: 24px;
                background: #fff;
                padding: 12px;
                border-radius: 12px;
                border: 1px solid #E6EBF2;
            }
            .custom-blog-filter-accordion-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 2px 0 14px;
                cursor: pointer;
                user-select: none;
                border-bottom: 1px dashed #E6EBF2;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .custom-blog-filter-accordion-header h3 {
                margin: 0;
                color: #06283D;
                text-transform: capitalize;
                flex: 1;
                font-size: 16px;
                font-style: normal;
                font-weight: 500;
                line-height: 24px;
            }
            .custom-blog-filter-accordion-toggle {
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform 0.3s ease;
                flex-shrink: 0;
            }
            .custom-blog-filter-accordion-toggle svg {
                width: 12px;
                height: 12px;
            }
            .custom-blog-filter-accordion.open .custom-blog-filter-accordion-toggle {
                transform: rotate(180deg);
            }
            .custom-blog-filter-accordion-content {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            .custom-blog-filter-accordion.open .custom-blog-filter-accordion-content {
                max-height: 2000px;
            }
            .custom-blog-filter-category-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 8px 0;
                cursor: pointer;
                gap: 8px;
            }
            .custom-blog-filter-category-item input[type="checkbox"] {
                margin-right: 8px;
                cursor: pointer;
                border: 1px solid #8793AF;
                border-radius: 4px;
                background: #fff;
            }
            .custom-blog-filter-category-item label {
                flex: 1;
                cursor: pointer;
                color: #5F6F94;
                font-size: 16px;
                font-style: normal;
                font-weight: 400;
                line-height: 24px;
            }
            .custom-blog-filter-category-count,.custom-blog-filter-featured-count {
                background: #F2F5FA;
                border-radius: 8px;
                padding: 4px;
                min-width: 28px;
                min-height: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #5F6F94;
                font-size: 14px;
                font-style: normal;
                font-weight: 500;
                line-height: 20px;
            }
            .custom-blog-filter-featured {
                margin-top: 0;
                padding-top: 16px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
            }
            .custom-blog-filter-featured-toggle {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 8px;
            }
            .custom-blog-filter-featured-toggle label:first-of-type {
                font-size: 16px;
                color: #5F6F94;
                cursor: pointer;
                flex: 1;
            }
            .custom-blog-filter-toggle-switch {
                position: relative;
                display: inline-block;
                width: 44px;
                height: 24px;
                margin-left: 0;
            }
            .custom-blog-filter-toggle-switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }
            .custom-blog-filter-toggle-slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: 0.3s;
                border-radius: 24px;
            }
            .custom-blog-filter-toggle-slider:before {
                position: absolute;
                content: "";
                height: 18px;
                width: 18px;
                left: 3px;
                bottom: 3px;
                background-color: white;
                transition: 0.3s;
                border-radius: 50%;
            }
            .custom-blog-filter-toggle-switch input:checked + .custom-blog-filter-toggle-slider {
                background-color: #0099ED;
            }
            .custom-blog-filter-toggle-switch input:checked + .custom-blog-filter-toggle-slider:before {
                transform: translateX(20px);
            }
            .custom-blog-filter-results {
                margin-top: 20px;
                padding-top: 20px;
                border-top: 1px solid #E5E9EC;
                font-size: 14px;
                color: #5C5C5C;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .custom-blog-filter-reset {
                margin-top: 0;
                border-bottom: 1px solid #E6EBF2;
            }
            .custom-blog-filter-reset a {
                color: #0099ED;
                font-size: 14px;
                font-style: normal;
                font-weight: 600;
                line-height: 20px;
            }
            .custom-blog-filter-content {
                flex: 1;
            }
            .custom-blog-filter-posts {
                display: grid;
                grid-template-columns: repeat(<?php echo esc_attr($columns); ?>, 1fr);
                gap: 28px;
            }
            .custom-blog-filter-posts.noblogdiv{ display: inline-block;width: 100%;height: 100%; }
            .custom-blog-filter-card {
                display: flex;
                flex-direction: column;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 100%;
                border-radius: 12px;
                background: #FFF;
                box-shadow: 0 0 10px 0 rgba(0, 82, 128, 0.10);
            }
            .custom-blog-filter-card a {
                border-radius: 12px;
                background: #FFF;
                box-shadow: 0 0 10px 0 rgba(0, 82, 128, 0.10);
                padding: 8px;
                display: flex;
                flex-direction: column;
                text-decoration: none;
                color: inherit;
                height: 100%;
                width: 100%;
            }
            .custom-blog-filter-image-wrapper {
                position: relative;
                width: 100%;
                height: 225px;
                border-radius: 12px;
            }
            .custom-blog-filter-image-wrapper img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 225px;
                object-fit: cover;
                border-radius: 12px;
            }
            .custom-blog-filter-date-overlay {
                position: absolute;
                top: 12px;
                right: 12px;
                background: #464A4F;
                color: #D7DBE4;
                padding: 4px 16px;
                border-radius: 100px;
                z-index: 3;
                pointer-events: none;
                border: 1px solid rgba(193, 196, 198, 0.10);
                font-size: 14px;
                font-style: normal;
                font-weight: 500;
                line-height: 20px;
            }
            .custom-blog-filter-card-content {
                padding: 8px;
                display: flex;
                flex-direction: column;
                gap: 12px;
                flex: 1;
            }
            .custom-blog-filter-taxonomy {
                display: inline-block;
                padding: 4px 16px;
                background: #E5F6FF;
                color: #0074B2;
                border-radius: 100px;
                width: fit-content;
                margin-bottom: 0;
                border: 1px solid #E6EBF2;
                font-size: 14px;
                font-style: normal;
                font-weight: 500;
                line-height: 20px;
            }
            .custom-blog-filter-title {
                margin: 0;
                font-size: 20px;
                font-style: normal;
                font-weight: 600;
                line-height: 26px;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                padding-bottom: 0;
                min-height: unset;
            }
            .custom-blog-filter-no-results {
                text-align: center;
                padding: 80px 40px;
                background: #fff;
                border-radius: 12px;
                margin: 20px 0;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
            }
            .custom-blog-filter-no-results-icon {
                width: 120px;
                height: 120px;
                margin: 0 auto 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: transparent;
            }
            .custom-blog-filter-no-results-icon svg {
                width: 80px;
                height: 80px;
                color: #0099ED;
            }
            .custom-blog-filter-no-results-icon svg circle {
                stroke: #0099ED;
                fill: none;
            }
            .custom-blog-filter-no-results-icon svg path {
                stroke: #0099ED;
            }
            .custom-blog-filter-no-results-icon svg circle:last-child {
                fill: #0099ED;
            }
            .custom-blog-filter-no-results h3 {
                font-size: 28px;
                font-weight: 600;
                color: #06283D;
                margin: 0 0 16px 0;
            }
            .custom-blog-filter-no-results p {
                font-size: 16px;
                color: #5C5C5C;
                margin: 0;
                line-height: 1.5;
            }
            .custom-blog-filter-card.hidden {
                display: none;
            }
            .custom-blog-filter-load-more {
                text-align: center;
                margin-top: 40px;
            }
            .custom-blog-filter-load-more-btn {
                padding: 12px 24px;
                border: 1px solid #E5E9EC;
                background: #fff;
                color: #0099ED;
                border-radius: 8px;
                font-size: 20px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .custom-blog-filter-load-more-btn:hover {
                background: #0099ED;
                color: #fff;
                border-color: #0099ED;
            }
            .custom-blog-filter-load-more-btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
            .custom-blog-filter-load-more-btn.hidden {
                display: none;
            }
            label.featuretitle {
                color: #5F6F94;
                font-size: 16px;
                font-style: normal;
                font-weight: 500;
                line-height: 24px;
            }
            .totalcount {
                color: #5F6F94;
                font-size: 14px;
                font-style: normal;
                font-weight: 500;
                line-height: 20px;
            }
            .js-dark .custom-blog-filter-card,.js-dark .custom-blog-filter-card a{ background: #262a30; }
            .js-dark .custom-blog-filter-taxonomy{ background: #464A4F;border: 1px solid #464A4F; }
            .js-dark .custom-blog-filter-accordion,.js-dark .custom-blog-filter-search input{ background: #262a30; }
            .js-dark .custom-blog-filter-search,.js-dark .custom-blog-filter-accordion-header,.js-dark .custom-blog-filter-accordion,.js-dark .custom-blog-filter-search input{ border-color: #464A4F; }
            .js-dark .custom-blog-filter-search input{
                color: rgba(255, 255, 255, 0.9);
            }
            @media (max-width: 1200px) {
                .custom-blog-filter-wrapper {
                    flex-direction: column;
                }
                .custom-blog-filter-sidebar {
                    width: 100%;
                }
                .custom-blog-filter-posts {
                    grid-template-columns: repeat(3, 1fr);
                }
                .custom-blog-filter-posts.noblogdiv{ display: inline-block;width: 100%;height: 100%; }
            }
            @media (max-width: 768px) {
                .custom-blog-filter-posts {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 5px;
                }
                .custom-blog-filter-posts.noblogdiv{ display: inline-block;width: 100%;height: 100%; }
                .custom-blog-filter-search {
                    margin-bottom: 15px;
                    padding-bottom: 15px;
                }
                .custom-blog-filter-category-item input[type="checkbox"]{
                    margin-bottom: 0;
                    padding-bottom: 15px;
                    width: 15px;
                    height: 15px;
                }
                .custom-blog-filter-search,.custom-blog-filter-accordion-toggle,{
                    margin-bottom: 0;
                    padding-bottom: 15px;
                }
                .custom-blog-filter-search input{
                    padding: 6px 32px;
                    height: 40px;
                    font-size: 14px;
                    line-height: 20px;
                }
                .custom-blog-filter-search-icon{ width: 15px;height: 15px; }
                .custom-blog-filter-accordion-header h3,.custom-blog-filter-accordion-header h3{ font-size: 16px !important; }
                .custom-blog-filter-accordion-header{ padding: 2px 0 10px; }
                .custom-blog-filter-category-item input[type="checkbox"]{ margin-right: 5px; }
                .custom-blog-filter-category-item{ gap: 5px; }
                .custom-blog-filter-category-item label{ font-size: 14px; }
                .custom-blog-filter-category-count, .custom-blog-filter-featured-count{ min-width: 25px;min-height: 25px; }
                label.featuretitle{ font-size: 14px;line-height: 20px; }
                .custom-blog-filter-category-item{ padding: 5px 0; }
                .custom-blog-filter-toggle-switch{ width: 40px; }
                .custom-blog-filter-wrapper{ gap: 35px; }
                .custom-blog-filter-image-wrapper img,.custom-blog-filter-image-wrapper{ height: 170px; }
                .custom-blog-filter-date-overlay{ padding: 3px 14px;font-size: 12px; }
                .custom-blog-filter-taxonomy{ padding: 4px 10px;font-size: 12px; }
                .custom-blog-filter-card-content{ padding: 8px 0;gap: 8px; }
                .custom-blog-filter-title{ font-size: 18px !important;line-height: 22px; }
                .custom-blog-filter-card-content{ padding: 8px 0 2px; }
                .custom-blog-filter-load-more{ margin-top: 30px; }
                .custom-blog-filter-load-more-btn{ padding: 6px 18px;font-size: 18px; }
            }
            /* @media (max-width: 480px) {
                .custom-blog-filter-posts {
                    grid-template-columns: 1fr;
                }
            } */
        </style>
        
        <div class="custom-blog-filter-wrapper" id="custom-blog-filter-<?php echo esc_attr($this->get_id()); ?>">
            <!-- Filter Sidebar -->
            <div class="custom-blog-filter-sidebar">
                <!-- Search -->
                <div class="custom-blog-filter-search">
                    <div class="custom-blog-filter-search-wrapper">
                        <svg class="custom-blog-filter-search-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                            <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <input type="text" id="blog-search-<?php echo esc_attr($this->get_id()); ?>" placeholder="Search" />
                        <button type="button" class="custom-blog-filter-search-clear" id="search-clear-<?php echo esc_attr($this->get_id()); ?>">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="16" height="16">
                                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Categories Accordion -->
                <div class="custom-blog-filter-accordion open" data-accordion="categories">
                    <div class="custom-blog-filter-accordion-header">
                        <div class="custom-blog-filter-accordion-toggle">
                            <svg viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L11 1" stroke="#5C5C5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3>Categories</h3>
                    </div>
                    <div class="custom-blog-filter-accordion-content">
                        <?php foreach ($categories_with_counts as $cat_data) : 
                            $cat = $cat_data['term'];
                            $count = $cat_data['count'];
                        ?>
                            <div class="custom-blog-filter-category-item">
                                <input type="checkbox" id="cat-<?php echo esc_attr($cat->term_id); ?>-<?php echo esc_attr($this->get_id()); ?>" 
                                       value="<?php echo esc_attr($cat->term_id); ?>" 
                                       class="blog-filter-category-checkbox" />
                                <label for="cat-<?php echo esc_attr($cat->term_id); ?>-<?php echo esc_attr($this->get_id()); ?>">
                                    <?php echo esc_html($cat->name); ?>
                                </label>
                                <div class="custom-blog-filter-category-count"><?php echo esc_html($count); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- More Accordion (Featured Toggle) -->
                <div class="custom-blog-filter-accordion open" data-accordion="more">
                    <div class="custom-blog-filter-accordion-header">
                        <div class="custom-blog-filter-accordion-toggle">
                            <svg viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L11 1" stroke="#5C5C5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3>More</h3>
                    </div>
                    <div class="custom-blog-filter-accordion-content">
                        <div class="custom-blog-filter-featured">
                            <div class="custom-blog-filter-featured-toggle">
                                <label class="custom-blog-filter-toggle-switch">
                                    <input type="checkbox" id="featured-toggle-<?php echo esc_attr($this->get_id()); ?>" class="blog-filter-featured-checkbox" />
                                    <span class="custom-blog-filter-toggle-slider"></span>
                                </label>
                                <label class="featuretitle" for="featured-toggle-<?php echo esc_attr($this->get_id()); ?>"> <?php echo esc_html('Featured blogs only', 'repindia'); ?></label>
                            </div>
                            <div class="custom-blog-filter-featured-count" id="featured-count-<?php echo esc_attr($this->get_id()); ?>"> <span><?php echo esc_html($featured_count); ?></span> </div>
                        </div>
                    </div>
                </div>
                
                <!-- Results Count -->
                <div class="custom-blog-filter-results">
                    <div class="totalcount" id="results-count-<?php echo esc_attr($this->get_id()); ?>">
                        <?php echo esc_html($total_posts); ?> out of <?php echo esc_html($total_posts); ?> results
                    </div>
                    <div class="custom-blog-filter-reset">
                        <a href="#" class="blog-filter-reset-link">Reset all filters</a>
                    </div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="custom-blog-filter-content">
                <?php 
                $render_query = new \WP_Query($query_args);
                if ($render_query->have_posts()) {
                   $validvar = '';
                }else{
                    $validvar = 'noblogdiv';
                }
                ?>
                <div class="custom-blog-filter-posts <?php echo esc_attr($validvar); ?>" id="blog-posts-<?php echo esc_attr($this->get_id()); ?>">
                    <?php 
                    // Fresh query to render posts
                    
                    if ($render_query->have_posts()) : 
                        while ($render_query->have_posts()) : $render_query->the_post(); 
                            $post_id = get_the_ID();
                            $taxonomy_term = $this->get_post_taxonomy_term($post_id, 'newsroom');
                            $post_categories = get_the_terms($post_id, 'newsroom_categories');
                            $category_ids = $post_categories && !is_wp_error($post_categories) ? array_map(function($t) { return $t->term_id; }, $post_categories) : [];
                            $featured = get_field('featured_news', $post_id);
                            
                            // Get date from ACF field if available
                            $custom_date = get_field('custom_created_date', $post_id);
                            if (!empty($custom_date)) {
                                if (is_numeric($custom_date)) {
                                    $post_date = date('d M, Y', $custom_date);
                                } else {
                                    $date_obj = \DateTime::createFromFormat('Ymd', $custom_date);
                                    if ($date_obj === false) {
                                        $date_obj = \DateTime::createFromFormat('Y-m-d', $custom_date);
                                    }
                                    if ($date_obj !== false) {
                                        $post_date = $date_obj->format('d M, Y');
                                    } else {
                                        $timestamp = strtotime($custom_date);
                                        if ($timestamp !== false) {
                                            $post_date = date('d M, Y', $timestamp);
                                        } else {
                                            $post_date = get_the_date('d M, Y', $post_id);
                                        }
                                    }
                                }
                            } else {
                                $post_date = get_the_date('d M, Y', $post_id);
                            }
                            
                            $post_title = get_the_title();
                            $post_title_lower = strtolower($post_title);
                    ?>
                        <article class="custom-blog-filter-card" 
                                 data-post-id="<?php echo esc_attr($post_id); ?>"
                                 data-categories="<?php echo esc_attr(json_encode($category_ids)); ?>"
                                 data-featured="<?php echo !empty($featured) ? '1' : '0'; ?>"
                                 data-title="<?php echo esc_attr($post_title_lower); ?>">
                            <a href="<?php the_permalink(); ?>">
                                <div class="custom-blog-filter-image-wrapper">
                                    <?php if (has_post_thumbnail($post_id)) : ?>
                                        <?php echo get_the_post_thumbnail($post_id, 'large', ['class' => 'custom-blog-filter-image']); ?>
                                    <?php else : ?>
                                        <div style="background: #f0f0f0; width: 100%; height: 100%;"></div>
                                    <?php endif; ?>
                                    <div class="custom-blog-filter-date-overlay">
                                        <?php echo esc_html($post_date); ?>
                                    </div>
                                </div>
                                
                                <div class="custom-blog-filter-card-content">
                                    <?php if ($taxonomy_term) : ?>
                                        <span class="custom-blog-filter-taxonomy">
                                            <?php echo esc_html($taxonomy_term['name']); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <h3 class="custom-blog-filter-title">
                                        <?php echo esc_html($post_title); ?>
                                    </h3>
                                </div>
                            </a>
                        </article>
                    <?php 
                        endwhile;
                    else : ?>
                        <div class="custom-blog-filter-no-results">
                            <div class="custom-blog-filter-no-results-icon">
                                <img src="<?php echo esc_url(home_url('/wp-content/uploads/2026/01/no-result.gif')); ?>" alt="No results" />
                            </div>
                            <h3><?php esc_html_e('No results found...', 'repindia'); ?></h3>
                            <p><?php esc_html_e('Please try to use different keyword or use different filter.', 'repindia'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Load More Button -->
                <?php if ($all_query->found_posts > $posts_per_page) : ?>
                    <div class="custom-blog-filter-load-more">
                        <button class="custom-blog-filter-load-more-btn" id="load-more-<?php echo esc_attr($this->get_id()); ?>">
                            Load more
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Store all posts data for JavaScript -->
        <script type="application/json" id="all-posts-data-<?php echo esc_attr($this->get_id()); ?>">
        <?php
        // Get all posts data for JavaScript
        $all_query->rewind_posts();
        $all_posts_json = [];
        if ($all_query->have_posts()) {
            while ($all_query->have_posts()) {
                $all_query->the_post();
                $post_id = get_the_ID();
                $taxonomy_term = $this->get_post_taxonomy_term($post_id, 'newsroom');
                $post_categories = get_the_terms($post_id, 'newsroom_categories');
                $category_ids = $post_categories && !is_wp_error($post_categories) ? array_map(function($t) { return $t->term_id; }, $post_categories) : [];
                $featured = get_field('featured_news', $post_id);
                
                // Get date
                $custom_date = get_field('custom_created_date', $post_id);
                if (!empty($custom_date)) {
                    if (is_numeric($custom_date)) {
                        $post_date = date('d M, Y', $custom_date);
                    } else {
                        $date_obj = \DateTime::createFromFormat('Ymd', $custom_date);
                        if ($date_obj === false) {
                            $date_obj = \DateTime::createFromFormat('Y-m-d', $custom_date);
                        }
                        if ($date_obj !== false) {
                            $post_date = $date_obj->format('d M, Y');
                        } else {
                            $timestamp = strtotime($custom_date);
                            if ($timestamp !== false) {
                                $post_date = date('d M, Y', $timestamp);
                            } else {
                                $post_date = get_the_date('d M, Y', $post_id);
                            }
                        }
                    }
                } else {
                    $post_date = get_the_date('d M, Y', $post_id);
                }
                
                $all_posts_json[] = [
                    'id' => $post_id,
                    'title' => get_the_title(),
                    'permalink' => get_permalink(),
                    'categories' => $category_ids,
                    'featured' => !empty($featured) ? 1 : 0,
                    'date' => $post_date,
                    'taxonomy' => $taxonomy_term ? $taxonomy_term['name'] : '',
                    'thumbnail' => has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'large') : '',
                ];
            }
            wp_reset_postdata();
        }
        echo json_encode($all_posts_json);
        ?>
        </script>
        
        <script>
        (function() {
            var widgetId = '<?php echo esc_js($this->get_id()); ?>';
            var baseUrl = '<?php echo esc_js(home_url()); ?>';
            var container = document.getElementById('custom-blog-filter-' + widgetId);
            if (!container) return;
            
            // Get all posts data
            var allPostsDataEl = document.getElementById('all-posts-data-' + widgetId);
            var allPostsData = allPostsDataEl ? JSON.parse(allPostsDataEl.textContent) : [];
            var postsPerPage = <?php echo esc_js($posts_per_page); ?>;
            var currentPage = 1;
            var filteredPosts = [];
            
            var searchInput = document.getElementById('blog-search-' + widgetId);
            var searchClearBtn = document.getElementById('search-clear-' + widgetId);
            var categoryCheckboxes = container.querySelectorAll('.blog-filter-category-checkbox');
            var featuredCheckbox = document.getElementById('featured-toggle-' + widgetId);
            var resetLink = container.querySelector('.blog-filter-reset-link');
            var resultsCount = document.getElementById('results-count-' + widgetId);
            var featuredCount = document.getElementById('featured-count-' + widgetId);
            var postsContainer = document.getElementById('blog-posts-' + widgetId);
            var loadMoreBtn = document.getElementById('load-more-' + widgetId);
            var accordions = container.querySelectorAll('.custom-blog-filter-accordion');
            
            // Handle search clear button visibility
            function updateSearchClearButton() {
                if (searchClearBtn && searchInput) {
                    if (searchInput.value.trim().length > 0) {
                        searchClearBtn.classList.add('visible');
                    } else {
                        searchClearBtn.classList.remove('visible');
                    }
                }
            }
            
            // Clear search
            if (searchClearBtn) {
                searchClearBtn.addEventListener('click', function() {
                    if (searchInput) {
                        searchInput.value = '';
                        updateSearchClearButton();
                        currentPage = 1;
                        filterPosts();
                    }
                });
            }
            
            // Accordion functionality
            accordions.forEach(function(accordion) {
                var header = accordion.querySelector('.custom-blog-filter-accordion-header');
                if (header) {
                    header.addEventListener('click', function() {
                        accordion.classList.toggle('open');
                    });
                }
            });
            
            // Create post card HTML
            function createPostCard(post) {
                var taxonomyHtml = post.taxonomy ? '<span class="custom-blog-filter-taxonomy">' + escapeHtml(post.taxonomy) + '</span>' : '';
                var imageHtml = post.thumbnail ? 
                    '<img src="' + escapeHtml(post.thumbnail) + '" class="custom-blog-filter-image" />' : 
                    '<div style="background: #f0f0f0; width: 100%; height: 100%;"></div>';
                
                return '<article class="custom-blog-filter-card" ' +
                    'data-post-id="' + post.id + '" ' +
                    'data-categories="' + escapeHtml(JSON.stringify(post.categories)) + '" ' +
                    'data-featured="' + post.featured + '" ' +
                    'data-title="' + escapeHtml(post.title.toLowerCase()) + '">' +
                    '<a href="' + escapeHtml(post.permalink) + '">' +
                    '<div class="custom-blog-filter-image-wrapper">' +
                    imageHtml +
                    '<div class="custom-blog-filter-date-overlay">' + escapeHtml(post.date) + '</div>' +
                    '</div>' +
                    '<div class="custom-blog-filter-card-content">' +
                    taxonomyHtml +
                    '<h3 class="custom-blog-filter-title">' + escapeHtml(post.title) + '</h3>' +
                    '</div>' +
                    '</a>' +
                    '</article>';
            }
            
            function escapeHtml(text) {
                var div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            // Filter posts based on current filters
            function getFilteredPosts() {
                var searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
                var selectedCategories = [];
                categoryCheckboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        selectedCategories.push(parseInt(checkbox.value));
                    }
                });
                var showFeaturedOnly = featuredCheckbox ? featuredCheckbox.checked : false;
                
                return allPostsData.filter(function(post) {
                    // Search filter
                    if (searchTerm && post.title.toLowerCase().indexOf(searchTerm) === -1) {
                        return false;
                    }
                    
                    // Category filter
                    if (selectedCategories.length > 0) {
                        var hasMatch = false;
                        selectedCategories.forEach(function(catId) {
                            if (post.categories.indexOf(catId) !== -1) {
                                hasMatch = true;
                            }
                        });
                        if (!hasMatch) return false;
                    }
                    
                    // Featured filter
                    if (showFeaturedOnly && post.featured !== 1) {
                        return false;
                    }
                    
                    return true;
                });
            }
            
            // Filter and show/hide existing posts
            function filterPosts() {
                filteredPosts = getFilteredPosts();
                var totalFiltered = filteredPosts.length;
                var postsToShow = Math.min(currentPage * postsPerPage, totalFiltered);
                var filteredPostIds = filteredPosts.slice(0, postsToShow).map(function(p) { return p.id; });
                
                // Get all existing cards
                var existingCards = postsContainer.querySelectorAll('.custom-blog-filter-card');
                var hasVisible = false;
                
                existingCards.forEach(function(card) {
                    var postId = parseInt(card.getAttribute('data-post-id'));
                    if (filteredPostIds.indexOf(postId) !== -1) {
                        card.classList.remove('hidden');
                        hasVisible = true;
                    } else {
                        card.classList.add('hidden');
                    }
                });
                
                // Add new posts if needed
                var existingIds = Array.from(existingCards).map(function(c) { return parseInt(c.getAttribute('data-post-id')); });
                var postsToAdd = filteredPosts.slice(0, postsToShow).filter(function(post) {
                    return existingIds.indexOf(post.id) === -1;
                });
                
                postsToAdd.forEach(function(post) {
                    postsContainer.insertAdjacentHTML('beforeend', createPostCard(post));
                });
                
                // Show/hide load more button
                if (loadMoreBtn) {
                    if (postsToShow < totalFiltered) {
                        loadMoreBtn.classList.remove('hidden');
                    } else {
                        loadMoreBtn.classList.add('hidden');
                    }
                }
                
                // Show no results message if needed
                var noResultsEl = postsContainer.querySelector('.custom-blog-filter-no-results');
                if (totalFiltered === 0) {
                    // Add noblogdiv class when no results found
                    postsContainer.classList.add('noblogdiv');
                    if (!noResultsEl) {
                        var noResultImageUrl = baseUrl + '/wp-content/uploads/2026/01/no-result.gif';
                        postsContainer.innerHTML = '<div class="custom-blog-filter-no-results">' +
                            '<div class="custom-blog-filter-no-results-icon">' + 
                            '<img src="' + escapeHtml(noResultImageUrl) + '" alt="No results" />' +
                            '</div>' +
                            '<h3>No results found...</h3>' +
                            '<p>Please try to use different keyword or use different filter.</p>' +
                            '</div>';
                    }
                    if (loadMoreBtn) loadMoreBtn.classList.add('hidden');
                } else {
                    // Remove noblogdiv class when results are found
                    postsContainer.classList.remove('noblogdiv');
                    if (noResultsEl) {
                        noResultsEl.remove();
                    }
                }
                
                updateCounts();
            }
            
            function updateCounts() {
                var totalFiltered = filteredPosts.length;
                var totalAll = allPostsData.length;
                
                if (resultsCount) {
                    resultsCount.textContent = totalFiltered + ' out of ' + totalAll + ' results';
                }
                
                // Update featured count
                if (featuredCheckbox && featuredCount) {
                    var featuredTotal = allPostsData.filter(function(p) { return p.featured === 1; }).length;
                    var featuredFiltered = filteredPosts.filter(function(p) { return p.featured === 1; }).length;
                    if (featuredCheckbox.checked) {
                        featuredCount.textContent =  featuredFiltered;
                    } else {
                        featuredCount.textContent = featuredTotal;
                    }
                }
            }
            
            function resetFilters() {
                if (searchInput) searchInput.value = '';
                updateSearchClearButton();
                categoryCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                if (featuredCheckbox) featuredCheckbox.checked = false;
                currentPage = 1;
                filterPosts();
            }
            
            // Event listeners
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    updateSearchClearButton();
                    currentPage = 1;
                    filterPosts();
                });
            }
            
            categoryCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    currentPage = 1;
                    filterPosts();
                });
            });
            
            if (featuredCheckbox) {
                featuredCheckbox.addEventListener('change', function() {
                    currentPage = 1;
                    filterPosts();
                });
            }
            
            if (resetLink) {
                resetLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    resetFilters();
                });
            }
            
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    currentPage++;
                    filterPosts();
                });
            }
            
            // Initial filter (show all initially loaded posts)
            updateSearchClearButton();
            filterPosts();
        })();
        </script>
        
<?php
        wp_reset_postdata();
    }
}

<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Custom_Latest_Resource extends Widget_Base
{
    public function get_name()
    {
        return 'custom_latest_resource';
    }
    
    public function get_title()
    {
        return 'Custom Latest Resource';
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
    private function build_query_args($settings)
    {
        // Hardcode post type to 'newsroom'
        $post_type = 'newsroom';
        $posts_per_page = !empty($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 12;
        $show_pagination = !empty($settings['show_pagination']) && $settings['show_pagination'] === 'yes';
        
        // Get current page for pagination
        $paged = 1;
        if ($show_pagination) {
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            if (is_front_page()) {
                $paged = get_query_var('page') ? get_query_var('page') : 1;
            }
        }
        
        $args = [
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => true,
        ];
        
        // Build tax_query based on newsroom_type taxonomy filter only
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
            echo '<div class="resource_card_section custom-latest-resource-wrapper">';
            echo '<p>' . esc_html__('Post list will appear here on the frontend.', 'repindia') . '</p>';
            echo '</div>';
            return;
        }
        
        // Build and execute query
        $query_args = $this->build_query_args($settings);
        $query = new \WP_Query($query_args);
        
        $show_pagination = !empty($settings['show_pagination']) && $settings['show_pagination'] === 'yes';
        
        // Calculate column width percentage
        $column_width = 100 / $columns;
        ?>
        
        <style>
            .custom-latest-resource-wrapper {
                width: 100%;
            }
            .custom-latest-resource-posts {
                display: grid;
                grid-template-columns: repeat(<?php echo esc_attr($columns); ?>, 1fr);
                gap: 28px;
            }
            .custom-latest-resource-card {
                display: flex;
                flex-direction: column;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 100%;
                border-radius: 12px;
                background: #FFF;
                box-shadow: 0 0 10px 0 rgba(0, 82, 128, 0.10);
            }
            .custom-latest-resource-card a{
                border-radius: 12px;
                background: #FFF;
                box-shadow: 0 0 10px 0 rgba(0, 82, 128, 0.10);
                padding: 8px;
            }
            /* .custom-latest-resource-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            } */
            .custom-latest-resource-card-link {
                display: flex;
                flex-direction: column;
                text-decoration: none;
                color: inherit;
                height: 100%;
                width: 100%;
            }
            .custom-latest-resource-image-wrapper {
                position: relative;
                width: 100%;
                height: 225px;
                border-radius: 12px;
            }
            .custom-latest-resource-image-wrapper img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 225px;
                object-fit: cover;
                border-radius: 12px;
            }
            .custom-latest-resource-date-overlay {
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
            .custom-latest-resource-card-content {
                padding: 8px;
                display: flex;
                flex-direction: column;
                gap: 12px;
                flex: 1;
            }
            .custom-latest-resource-taxonomy {
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
            .custom-latest-resource-title {
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
            .custom-latest-resource-pagination {
                margin-top: 40px;
                text-align: center;
            }
            .custom-latest-resource-pagination .page-numbers {
                display: inline-flex;
                gap: 8px;
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .custom-latest-resource-pagination .page-numbers li {
                display: inline-block;
            }
            .custom-latest-resource-pagination .page-numbers a,
            .custom-latest-resource-pagination .page-numbers span {
                display: inline-block;
                padding: 8px 16px;
                border: 1px solid #E5E9EC;
                border-radius: 8px;
                text-decoration: none;
                color: #06283D;
                transition: all 0.3s ease;
            }
            .custom-latest-resource-pagination .page-numbers a:hover,
            .custom-latest-resource-pagination .page-numbers .current {
                background: #0099ED;
                color: #fff;
                border-color: #0099ED;
            }
            .custom-latest-resource-no-results {
                text-align: center;
                padding: 40px;
                color: #666;
            }
            .js-dark .custom-latest-resource-card,.js-dark .custom-latest-resource-card a{ background: #262a30; }
            .js-dark .custom-latest-resource-taxonomy{ background: #464A4F;border: 1px solid #464A4F; }
            @media (max-width: 1200px) {
                .custom-latest-resource-posts {
                    grid-template-columns: repeat(3, 1fr);
                }
            }
            @media (max-width: 768px) {
                .custom-latest-resource-posts {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 5px;
                }
                .custom-latest-resource-image-wrapper img,.custom-latest-resource-image-wrapper{ height: 170px; }
                .custom-latest-resource-date-overlay{ padding: 3px 14px;font-size: 12px; }
                .custom-latest-resource-taxonomy{ padding: 4px 10px;font-size: 12px; }
                .custom-latest-resource-card-content{ padding: 8px 0;gap: 8px; }
                .custom-latest-resource-title{ font-size: 18px !important;line-height: 22px; }
                .custom-blog-filter-card-content{ padding: 8px 0 2px; }
                .custom-blog-filter-load-more{ margin-top: 30px; }
                .custom-blog-filter-load-more-btn{ padding: 6px 18px;font-size: 18px; }
            }
        </style>
        
        <div class="resource_card_section custom-latest-resource-wrapper">
            <?php if ($query->have_posts()) : ?>
                <div class="custom-latest-resource-posts">
                    <?php while ($query->have_posts()) : $query->the_post(); 
                        $post_id = get_the_ID();
                        // Get newsroom_categories taxonomy term for display
                        $taxonomy_term = $this->get_post_taxonomy_term($post_id, 'newsroom');
                        
                        // Get date from ACF field if available, otherwise use default post date
                        $custom_date = get_field('custom_created_date', $post_id);
                        if (!empty($custom_date)) {
                            // ACF date picker can return different formats, so we need to handle it
                            // If it's a timestamp, convert it; if it's a date string, format it
                            if (is_numeric($custom_date)) {
                                $post_date = date('d M, Y', $custom_date);
                            } else {
                                // Try to parse the date string
                                $date_obj = \DateTime::createFromFormat('Ymd', $custom_date);
                                if ($date_obj === false) {
                                    // Try other common formats
                                    $date_obj = \DateTime::createFromFormat('Y-m-d', $custom_date);
                                }
                                if ($date_obj !== false) {
                                    $post_date = $date_obj->format('d M, Y');
                                } else {
                                    // Fallback: try to use the string directly or convert with strtotime
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
                    ?>
                        <article class="custom-latest-resource-card">
                            <a href="<?php the_permalink(); ?>" class="custom-latest-resource-card-link">
                                <div class="custom-latest-resource-image-wrapper">
                                    <?php if (has_post_thumbnail($post_id)) : ?>
                                        <?php echo get_the_post_thumbnail($post_id, 'large', ['class' => 'custom-latest-resource-image']); ?>
                                    <?php else : ?>
                                        <div style="background: #f0f0f0; width: 100%; height: 100%;"></div>
                                    <?php endif; ?>
                                    <div class="custom-latest-resource-date-overlay">
                                        <?php echo esc_html($post_date); ?>
                                    </div>
                                </div>
                                
                                <div class="custom-latest-resource-card-content">
                                    <?php if ($taxonomy_term) : ?>
                                        <span class="custom-latest-resource-taxonomy">
                                            <?php echo esc_html($taxonomy_term['name']); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <h3 class="custom-latest-resource-title">
                                        <?php the_title(); ?>
                                    </h3>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <?php if ($show_pagination) : ?>
                    <?php $this->render_pagination($query); ?>
                <?php endif; ?>
                
            <?php else : ?>
                <div class="custom-latest-resource-no-results">
                    <p><?php esc_html_e('No posts found.', 'repindia'); ?></p>
                </div>
            <?php endif; ?>
        </div>
        
<?php
        wp_reset_postdata();
    }
}

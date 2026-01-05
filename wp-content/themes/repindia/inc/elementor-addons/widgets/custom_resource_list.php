<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

// AJAX handler function - in namespace but registered with fully qualified name
function custom_resource_list_ajax_handler() {
    // Get nonce from request
    $nonce_received = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
    
    // Verify nonce exists
    if (empty($nonce_received)) {
        status_header(400);
        wp_die('0');
    }
    
    if (
        ! isset($_POST['nonce']) ||
        ! wp_verify_nonce($_POST['nonce'], 'filter_resources')
    ) {
        status_header(400);
        wp_die('0');
    }
    
    
    // Sanitize inputs - accept slugs instead of IDs
    $resource_type_slug = isset($_POST['resource_type']) ? sanitize_text_field($_POST['resource_type']) : (isset($_REQUEST['resource_type']) ? sanitize_text_field($_REQUEST['resource_type']) : '');
    $resource_product_slug = isset($_POST['resource_product']) ? sanitize_text_field($_POST['resource_product']) : (isset($_REQUEST['resource_product']) ? sanitize_text_field($_REQUEST['resource_product']) : '');
    $sort_order = isset($_POST['sort_order']) ? sanitize_text_field($_POST['sort_order']) : (isset($_REQUEST['sort_order']) ? sanitize_text_field($_REQUEST['sort_order']) : 'newest');
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : (isset($_REQUEST['paged']) ? intval($_REQUEST['paged']) : 1);
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : (isset($_REQUEST['posts_per_page']) ? intval($_REQUEST['posts_per_page']) : 12);
    
    $tax_query = [];
    if (!empty($resource_type_slug)) {
        $tax_query[] = [
            'taxonomy' => 'resource_type',
            'field' => 'slug',
            'terms' => [$resource_type_slug]
        ];
    }
    if (!empty($resource_product_slug)) {
        $tax_query[] = [
            'taxonomy' => 'resource_product',
            'field' => 'slug',
            'terms' => [$resource_product_slug]
        ];
    }
    if (count($tax_query) > 1) {
        $tax_query = array_merge(['relation' => 'AND'], $tax_query);
    }
    
    $args = [
        'post_type' => 'resources',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => ($sort_order === 'oldest') ? 'ASC' : 'DESC',
    ];
    
    // Only add tax_query if we have filters
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
        error_log('Tax query: ' . print_r($tax_query, true));
    } else {
        error_log('No tax query - showing all resources');
    }
    
    $query = new \WP_Query($args);
    $found_posts = $query->found_posts;
    $posts_on_page = $query->post_count;
    
    echo '<div class="resource-ajax-response" data-count="' . esc_attr($posts_on_page) . '" data-total="' . esc_attr($found_posts) . '">';
    
    if ($query->have_posts()) {
        echo '<div class="resource-grid">';
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $file_size = get_field('resource_file_size', $post_id);
            $resource_types_terms = get_the_terms($post_id, 'resource_type');
            ?>
            <div class="resource-card">
                <div class="resource-content">
                    <?php if (!empty($resource_types_terms) && !is_wp_error($resource_types_terms)) : ?>
                        <div class="resource-type-badge"><?php echo esc_html($resource_types_terms[0]->name); ?></div>
                    <?php endif; ?>
                    <h3 class="resource-title">
                        <a href="<?php echo esc_url(get_permalink($post_id)); ?>"><?php echo esc_html(get_the_title($post_id)); ?></a>
                    </h3>
                    <?php if (!empty($file_size)) : ?>
                        <div class="resource-file-size"><?php echo esc_html($file_size); ?></div>
                    <?php endif; ?>
                </div>
                <div class="resource-image">
                    <?php if (has_post_thumbnail($post_id)) : ?>
                        <a href="<?php echo esc_url(get_permalink($post_id)); ?>"><?php echo get_the_post_thumbnail($post_id, 'medium'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
        echo '</div>';
        
        if ($query->max_num_pages > 1) {
            echo '<div class="resource-pagination">';
            $current_page = max(1, $paged);
            $total_pages = $query->max_num_pages;
            
            if ($current_page > 1) {
                echo '<button class="pagination-btn" data-page="' . ($current_page - 1) . '">Previous</button>';
            }
            
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == 1 || $i == $total_pages || ($i >= $current_page - 2 && $i <= $current_page + 2)) {
                    $active_class = ($i == $current_page) ? ' active' : '';
                    echo '<button class="pagination-btn' . $active_class . '" data-page="' . $i . '">' . $i . '</button>';
                } elseif ($i == $current_page - 3 || $i == $current_page + 3) {
                    echo '<span class="pagination-dots">...</span>';
                }
            }
            
            if ($current_page < $total_pages) {
                echo '<button class="pagination-btn" data-page="' . ($current_page + 1) . '">Next</button>';
            }
            echo '</div>';
        }
    } else {
        echo '<div class="resource-no-results"><p>No resources found.</p></div>';
    }
    
    echo '</div>';
    wp_reset_postdata();
    wp_die();
}

// Register AJAX handlers with fully qualified namespace name
add_action('wp_ajax_filter_resources', __NAMESPACE__ . '\\custom_resource_list_ajax_handler');
add_action('wp_ajax_nopriv_filter_resources', __NAMESPACE__ . '\\custom_resource_list_ajax_handler');

class Custom_Resource_List extends Widget_Base {

    public function get_name() {
        return 'custom_resource_list';
    }

    public function get_title() {
        return 'Custom Resource List';
    }

    public function get_icon() {
        return 'fa fa-list';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        $this->start_controls_section('section_content', ['label' => __('Content', 'repindia')]);

        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Filter resources',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => __('Section Subtitle', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Find exactly what you need by selecting a resource type or product.',
                'label_block' => true,
            ]
        );

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

        $this->end_controls_section();
    }

    private function get_taxonomy_terms($taxonomy) {
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ]);

        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }

        $result = [];
        foreach ($terms as $term) {
            $thumbnail_id = get_field('resource_taxonomy_thumbnail', 'term_' . $term->term_id);
            $dark_thumbnail_id = get_field('resource_taxonomy_dark_thumbnail', 'term_' . $term->term_id);
            
            $result[] = [
                'id' => $term->term_id,
                'name' => $term->name,
                'slug' => $term->slug,
                'thumbnail_id' => $thumbnail_id ? intval($thumbnail_id) : 0,
                'dark_thumbnail_id' => $dark_thumbnail_id ? intval($dark_thumbnail_id) : 0,
            ];
        }
        return $result;
    }


    protected function render() {
        $settings = $this->get_settings_for_display();
        $section_title = !empty($settings['section_title']) ? $settings['section_title'] : '';
        $section_subtitle = !empty($settings['section_subtitle']) ? $settings['section_subtitle'] : '';
        $posts_per_page = !empty($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 12;
        
        $resource_types = $this->get_taxonomy_terms('resource_type');
        $resource_products = $this->get_taxonomy_terms('resource_product');
        // Create nonce with action name matching AJAX handler
        $nonce = wp_create_nonce('filter_resources');
        
        // Get slugs from URL
        $url_type_slug = isset($_GET['resource_type']) ? sanitize_text_field($_GET['resource_type']) : '';
        $url_product_slug = isset($_GET['resource_product']) ? sanitize_text_field($_GET['resource_product']) : '';
        $url_sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';
        $url_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        
        $args = [
            'post_type' => 'resources',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $url_page,
            'orderby' => 'date',
            'order' => ($url_sort === 'oldest') ? 'ASC' : 'DESC',
        ];
        
        $tax_query = [];
        if (!empty($url_type_slug)) {
            $tax_query[] = ['taxonomy' => 'resource_type', 'field' => 'slug', 'terms' => [$url_type_slug]];
        }
        if (!empty($url_product_slug)) {
            $tax_query[] = ['taxonomy' => 'resource_product', 'field' => 'slug', 'terms' => [$url_product_slug]];
        }
        if (count($tax_query) > 1) {
            $tax_query = array_merge(['relation' => 'AND'], $tax_query);
        }
        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }
        
        $query = new \WP_Query($args);
        ?>
        <div class="resource-filter-section" data-posts-per-page="<?php echo esc_attr($posts_per_page); ?>" data-nonce="<?php echo esc_attr($nonce); ?>">
            <style>
                .resource-filter-section { display: flex; gap: 40px; max-width: 1400px; margin: 0 auto; padding: 40px 20px; }
                .resource-filter-sidebar { width: 300px; flex-shrink: 0; }
                .resource-filter-sidebar h2 { font-size: 32px; font-weight: 600; margin: 0 0 12px 0; color: #06283D; }
                .resource-filter-sidebar p { font-size: 16px; color: #666; margin: 0 0 32px 0; line-height: 1.5; }
                .resource-filter-group { margin-bottom: 32px; }
                .resource-filter-group h3 { font-size: 18px; font-weight: 500; margin: 0 0 16px 0; color: #06283D; text-transform: lowercase; }
                .resource-filter-group h3:first-letter { text-transform: uppercase; }
                .resource-filter-item { display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 8px; cursor: pointer; margin-bottom: 8px; transition: background 0.2s; }
                .resource-filter-item:hover { background: #f5f5f5; }
                .resource-filter-item.active { background: #E5F6FF; }
                .resource-filter-item img { width: 24px; height: 24px; object-fit: contain; flex-shrink: 0; }
                .resource-filter-item span { font-size: 16px; color: #06283D; }
                .resource-filter-item.active span { font-weight: 500; }
                .resource-filter-clear { color: #0074B2; text-decoration: none; font-size: 14px; margin-top: 16px; display: inline-block; }
                .resource-filter-clear:hover { text-decoration: underline; }
                .resource-main-content { flex: 1; }
                .resource-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
                .resource-header h2 { font-size: 32px; font-weight: 600; margin: 0; color: #06283D; }
                .resource-header-info { display: flex; align-items: center; gap: 24px; }
                .resource-count { font-size: 16px; color: #666; }
                .resource-sort { position: relative; }
                .resource-sort select { padding: 8px 32px 8px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; background: white; cursor: pointer; appearance: none; }
                .resource-sort::after { content: '▼'; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; font-size: 12px; color: #666; }
                .resource-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; margin-bottom: 40px; }
                .resource-card { border: 1px solid #e5e5e5; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; background: white; transition: box-shadow 0.2s; }
                .resource-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
                .resource-image { width: 100%; height: 200px; overflow: hidden; background: #f5f5f5; }
                .resource-image img { width: 100%; height: 100%; object-fit: cover; }
                .resource-content { padding: 20px; flex: 1; display: flex; flex-direction: column; }
                .resource-type-badge { display: inline-block; padding: 4px 12px; background: #E5F6FF; color: #0074B2; border-radius: 4px; font-size: 12px; font-weight: 500; margin-bottom: 12px; width: fit-content; }
                .resource-title { margin: 0 0 8px 0; font-size: 20px; font-weight: 500; line-height: 1.4; }
                .resource-title a { color: #06283D; text-decoration: none; }
                .resource-title a:hover { text-decoration: underline; }
                .resource-file-size { font-size: 14px; color: #666; margin-top: auto; }
                .resource-pagination { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 40px; }
                .pagination-btn { padding: 8px 16px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer; font-size: 14px; transition: all 0.2s; }
                .pagination-btn:hover { background: #f5f5f5; border-color: #0074B2; }
                .pagination-btn.active { background: #0074B2; color: white; border-color: #0074B2; }
                .pagination-dots { padding: 8px 4px; color: #666; }
                .resource-loading { text-align: center; padding: 40px; color: #666; display: none; }
                .resource-no-results { text-align: center; padding: 40px; color: #666; }
                .resource-results { min-height: 200px; }
                @media (max-width: 768px) {
                    .resource-filter-section { flex-direction: column; }
                    .resource-filter-sidebar { width: 100%; }
                    .resource-grid { grid-template-columns: 1fr; }
                }
            </style>
            
            <div class="resource-filter-sidebar">
                <h2><?php echo esc_html($section_title); ?></h2>
                <p><?php echo esc_html($section_subtitle); ?></p>
                
                <div class="resource-filter-group">
                    <h3>by resource type</h3>
                    <?php foreach ($resource_types as $term) : ?>
                        <div class="resource-filter-item" data-taxonomy="resource_type" data-term-id="<?php echo esc_attr($term['id']); ?>" data-term-slug="<?php echo esc_attr($term['slug']); ?>" <?php echo ($url_type_slug == $term['slug']) ? 'data-active="1"' : ''; ?>>
                            <?php if ($term['thumbnail_id']) : ?>
                                <img src="<?php echo esc_url(wp_get_attachment_image_url($term['thumbnail_id'], 'thumbnail')); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon">
                                <img src="<?php echo esc_url(wp_get_attachment_image_url($term['dark_thumbnail_id'] ?: $term['thumbnail_id'], 'thumbnail')); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon-dark" style="display: none;">
                            <?php endif; ?>
                            <span><?php echo esc_html($term['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="resource-filter-group">
                    <h3>by resource product</h3>
                    <?php foreach ($resource_products as $term) : ?>
                        <div class="resource-filter-item" data-taxonomy="resource_product" data-term-id="<?php echo esc_attr($term['id']); ?>" data-term-slug="<?php echo esc_attr($term['slug']); ?>" <?php echo ($url_product_slug == $term['slug']) ? 'data-active="1"' : ''; ?>>
                            <?php if ($term['thumbnail_id']) : ?>
                                <img src="<?php echo esc_url(wp_get_attachment_image_url($term['thumbnail_id'], 'thumbnail')); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon">
                                <img src="<?php echo esc_url(wp_get_attachment_image_url($term['dark_thumbnail_id'] ?: $term['thumbnail_id'], 'thumbnail')); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon-dark" style="display: none;">
                            <?php endif; ?>
                            <span><?php echo esc_html($term['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if (!empty($url_type_slug) || !empty($url_product_slug)) : ?>
                    <a href="#" class="resource-filter-clear">Clear filters</a>
                <?php endif; ?>
            </div>
            
            <div class="resource-main-content">
                <div class="resource-header">
                    <h2><?php echo esc_html($section_title); ?></h2>
                    <div class="resource-header-info">
                        <span class="resource-count">Showing <?php echo esc_html($query->post_count); ?> of <?php echo esc_html($query->found_posts); ?></span>
                        <div class="resource-sort">
                            <select id="resource-sort">
                                <option value="newest" <?php selected($url_sort, 'newest'); ?>>Sort by newest</option>
                                <option value="oldest" <?php selected($url_sort, 'oldest'); ?>>Sort by oldest</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="resource-loading">Loading...</div>
                <div class="resource-results">
                    <?php if ($query->have_posts()) : ?>
                        <div class="resource-grid">
                            <?php while ($query->have_posts()) : $query->the_post(); 
                                $post_id = get_the_ID();
                                $file_size = get_field('resource_file_size', $post_id);
                                $resource_types_terms = get_the_terms($post_id, 'resource_type');
                            ?>
                                <div class="resource-card">
                                    <div class="resource-content">
                                        <?php if (!empty($resource_types_terms) && !is_wp_error($resource_types_terms)) : ?>
                                            <div class="resource-type-badge"><?php echo esc_html($resource_types_terms[0]->name); ?></div>
                                        <?php endif; ?>
                                        <h3 class="resource-title">
                                            <a href="<?php echo esc_url(get_permalink($post_id)); ?>"><?php echo esc_html(get_the_title($post_id)); ?></a>
                                        </h3>
                                        <?php if (!empty($file_size)) : ?>
                                            <div class="resource-file-size"><?php echo esc_html($file_size); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="resource-image">
                                        <?php if (has_post_thumbnail($post_id)) : ?>
                                            <a href="<?php echo esc_url(get_permalink($post_id)); ?>"><?php echo get_the_post_thumbnail($post_id, 'medium'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        
                        <?php if ($query->max_num_pages > 1) : ?>
                            <div class="resource-pagination">
                                <?php if ($url_page > 1) : ?>
                                    <button class="pagination-btn" data-page="<?php echo ($url_page - 1); ?>">Previous</button>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $query->max_num_pages; $i++) : 
                                    if ($i == 1 || $i == $query->max_num_pages || ($i >= $url_page - 2 && $i <= $url_page + 2)) : ?>
                                        <button class="pagination-btn <?php echo ($i == $url_page) ? 'active' : ''; ?>" data-page="<?php echo $i; ?>"><?php echo $i; ?></button>
                                    <?php elseif ($i == $url_page - 3 || $i == $url_page + 3) : ?>
                                        <span class="pagination-dots">...</span>
                                    <?php endif;
                                endfor; ?>
                                
                                <?php if ($url_page < $query->max_num_pages) : ?>
                                    <button class="pagination-btn" data-page="<?php echo ($url_page + 1); ?>">Next</button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="resource-no-results"><p>No resources found.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <script>
        (function(){
            var section = document.querySelector('.resource-filter-section');
            if (!section) return;
            
            var resultsContainer = document.querySelector('.resource-results');
            var loading = document.querySelector('.resource-loading');
            var postsPerPage = parseInt(section.getAttribute('data-posts-per-page')) || 12;
            var selectedType = '';
            var selectedProduct = '';
            var sortOrder = 'newest';
            var currentPage = 1;
            var ajaxInProgress = false;
            var nonce = section.getAttribute('data-nonce');
            
            // Verify nonce is set
            if (!nonce || nonce.length === 0) {
                console.error('Nonce is empty!');
            }
            
            // Initialize from URL parameters (using slugs)
            var urlParams = new URLSearchParams(window.location.search);
            var urlType = urlParams.get('resource_type');
            var urlProduct = urlParams.get('resource_product');
            var urlSort = urlParams.get('sort');
            var urlPage = urlParams.get('page');
            
            if (urlType) selectedType = urlType;
            if (urlProduct) selectedProduct = urlProduct;
            if (urlSort) sortOrder = urlSort;
            if (urlPage) currentPage = parseInt(urlPage) || 1;
            
            // Set active states from URL (using slugs)
            if (selectedType) {
                var typeItem = section.querySelector('[data-taxonomy="resource_type"][data-term-slug="' + selectedType + '"]');
                if (typeItem) {
                    typeItem.classList.add('active');
                    typeItem.setAttribute('data-active', '1');
                    var darkIcon = typeItem.querySelector('.filter-icon-dark');
                    var lightIcon = typeItem.querySelector('.filter-icon');
                    if (darkIcon && lightIcon) {
                        lightIcon.style.display = 'none';
                        darkIcon.style.display = 'block';
                    }
                }
            }
            
            if (selectedProduct) {
                var productItem = section.querySelector('[data-taxonomy="resource_product"][data-term-slug="' + selectedProduct + '"]');
                if (productItem) {
                    productItem.classList.add('active');
                    productItem.setAttribute('data-active', '1');
                    var darkIcon = productItem.querySelector('.filter-icon-dark');
                    var lightIcon = productItem.querySelector('.filter-icon');
                    if (darkIcon && lightIcon) {
                        lightIcon.style.display = 'none';
                        darkIcon.style.display = 'block';
                    }
                }
            }
            
            // Filter item click handler
            var filterItems = section.querySelectorAll('.resource-filter-item');
            filterItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    var taxonomy = this.getAttribute('data-taxonomy');
                    var termSlug = this.getAttribute('data-term-slug');
                    var isActive = this.classList.contains('active');
                    
                    // Single select per group
                    var groupItems = section.querySelectorAll('[data-taxonomy="' + taxonomy + '"]');
                    groupItems.forEach(function(groupItem) {
                        groupItem.classList.remove('active');
                        groupItem.removeAttribute('data-active');
                        var darkIcon = groupItem.querySelector('.filter-icon-dark');
                        var lightIcon = groupItem.querySelector('.filter-icon');
                        if (darkIcon && lightIcon) {
                            darkIcon.style.display = 'none';
                            lightIcon.style.display = 'block';
                        }
                    });
                    
                    if (taxonomy === 'resource_type') {
                        selectedType = isActive ? '' : termSlug;
                    } else if (taxonomy === 'resource_product') {
                        selectedProduct = isActive ? '' : termSlug;
                    }
                    
                    if (!isActive) {
                        this.classList.add('active');
                        this.setAttribute('data-active', '1');
                        var darkIcon = this.querySelector('.filter-icon-dark');
                        var lightIcon = this.querySelector('.filter-icon');
                        if (darkIcon && lightIcon) {
                            lightIcon.style.display = 'none';
                            darkIcon.style.display = 'block';
                        }
                    }
                    
                    currentPage = 1;
                    updateUrl();
                    loadResources();
                });
            });
            
            // Clear filters
            var clearLink = section.querySelector('.resource-filter-clear');
            if (clearLink) {
                clearLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    selectedType = '';
                    selectedProduct = '';
                    currentPage = 1;
                    
                    filterItems.forEach(function(item) {
                        item.classList.remove('active');
                        item.removeAttribute('data-active');
                        var darkIcon = item.querySelector('.filter-icon-dark');
                        var lightIcon = item.querySelector('.filter-icon');
                        if (darkIcon && lightIcon) {
                            darkIcon.style.display = 'none';
                            lightIcon.style.display = 'block';
                        }
                    });
                    
                    updateUrl();
                    loadResources();
                });
            }
            
            // Sort dropdown
            var sortSelect = document.getElementById('resource-sort');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    sortOrder = this.value;
                    currentPage = 1;
                    updateUrl();
                    loadResources();
                });
            }
            
            // Pagination buttons
            var paginationBtns = section.querySelectorAll('.pagination-btn');
            paginationBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    currentPage = parseInt(this.getAttribute('data-page')) || 1;
                    updateUrl();
                    loadResources();
                });
            });
            
            function updateUrl() {
                var params = new URLSearchParams();
                if (selectedType) params.set('resource_type', selectedType);
                if (selectedProduct) params.set('resource_product', selectedProduct);
                if (sortOrder !== 'newest') params.set('sort', sortOrder);
                if (currentPage > 1) params.set('page', currentPage);
                
                var newUrl = window.location.pathname;
                if (params.toString()) {
                    newUrl += '?' + params.toString();
                }
                window.history.pushState({}, '', newUrl);
            }
            
            function loadResources() {
                if (ajaxInProgress) return;
                ajaxInProgress = true;
                
                if (loading) loading.style.display = '';
                if (resultsContainer) resultsContainer.style.display = 'none';
                
                // Use FormData for better WordPress compatibility
                var formData = new FormData();
                formData.append('action', 'filter_resources');
                formData.append('nonce', nonce);
                formData.append('resource_type', selectedType);
                formData.append('resource_product', selectedProduct);
                formData.append('sort_order', sortOrder);
                formData.append('paged', currentPage);
                formData.append('posts_per_page', postsPerPage);
                
                // Debug logging
                console.log('Sending AJAX request:', {
                    resource_type: selectedType,
                    resource_product: selectedProduct,
                    sort_order: sortOrder,
                    paged: currentPage
                });
                
                // Debug: Check nonce
                if (!nonce || nonce.length === 0) {
                    console.error('ERROR: Nonce is empty!');
                    ajaxInProgress = false;
                    if (loading) {
                        loading.innerHTML = '<p>Error: Nonce not found. Please refresh the page.</p>';
                        loading.style.display = '';
                    }
                    return;
                }
                
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('HTTP error! status: ' + response.status);
                    }
                    return response.text();
                })
                .then(function(html) {
                    // Check if response is "0" (nonce failure)
                    if (html.trim() === '0') {
                        throw new Error('Security check failed. Please refresh the page.');
                    }
                    
                    if (resultsContainer) {
                        resultsContainer.innerHTML = html;
                        resultsContainer.style.display = '';
                        
                        // Update count
                        var responseDiv = resultsContainer.querySelector('.resource-ajax-response');
                        if (responseDiv) {
                            var count = responseDiv.getAttribute('data-count');
                            var total = responseDiv.getAttribute('data-total');
                            var countEl = section.querySelector('.resource-count');
                            if (countEl && count && total) {
                                countEl.textContent = 'Showing ' + count + ' of ' + total;
                            }
                        }
                        
                        // Re-attach pagination handlers
                        var newPaginationBtns = resultsContainer.querySelectorAll('.pagination-btn');
                        newPaginationBtns.forEach(function(btn) {
                            btn.addEventListener('click', function() {
                                currentPage = parseInt(this.getAttribute('data-page')) || 1;
                                updateUrl();
                                loadResources();
                            });
                        });
                    }
                    
                    if (loading) loading.style.display = 'none';
                    ajaxInProgress = false;
                })
                .catch(function(error) {
                    console.error('AJAX Error:', error);
                    ajaxInProgress = false;
                    if (loading) {
                        loading.innerHTML = '<p>Error loading resources. Please try again.</p>';
                        loading.style.display = '';
                    }
                    if (resultsContainer) {
                        resultsContainer.style.display = '';
                    }
                });
            }
        })();
        </script>
    <?php 
        wp_reset_postdata();
    }
}

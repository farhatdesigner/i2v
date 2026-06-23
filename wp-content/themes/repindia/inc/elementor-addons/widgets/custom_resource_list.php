<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

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
            $thumbnail_field = get_field('resource_taxonomy_thumbnail', 'term_' . $term->term_id);
            $dark_thumbnail_field = get_field('resource_taxonomy_dark_thumbnail', 'term_' . $term->term_id);
            
            // Handle ACF image field - can be ID, array, or URL
            $thumbnail_id = 0;
            $thumbnail_url = '';
            if (!empty($thumbnail_field)) {
                if (is_array($thumbnail_field)) {
                    if (isset($thumbnail_field['ID'])) {
                        $thumbnail_id = intval($thumbnail_field['ID']);
                    } elseif (isset($thumbnail_field['url'])) {
                        $thumbnail_url = esc_url($thumbnail_field['url']);
                    }
                } elseif (is_numeric($thumbnail_field)) {
                    $thumbnail_id = intval($thumbnail_field);
                } elseif (is_string($thumbnail_field) && filter_var($thumbnail_field, FILTER_VALIDATE_URL)) {
                    $thumbnail_url = esc_url($thumbnail_field);
                }
            }
            
            $dark_thumbnail_id = 0;
            $dark_thumbnail_url = '';
            if (!empty($dark_thumbnail_field)) {
                if (is_array($dark_thumbnail_field)) {
                    if (isset($dark_thumbnail_field['ID'])) {
                        $dark_thumbnail_id = intval($dark_thumbnail_field['ID']);
                    } elseif (isset($dark_thumbnail_field['url'])) {
                        $dark_thumbnail_url = esc_url($dark_thumbnail_field['url']);
                    }
                } elseif (is_numeric($dark_thumbnail_field)) {
                    $dark_thumbnail_id = intval($dark_thumbnail_field);
                } elseif (is_string($dark_thumbnail_field) && filter_var($dark_thumbnail_field, FILTER_VALIDATE_URL)) {
                    $dark_thumbnail_url = esc_url($dark_thumbnail_field);
                }
            }
            
            $result[] = [
                'id' => $term->term_id,
                'name' => $term->name,
                'slug' => $term->slug,
                'thumbnail_id' => $thumbnail_id,
                'thumbnail_url' => $thumbnail_url,
                'dark_thumbnail_id' => $dark_thumbnail_id,
                'dark_thumbnail_url' => $dark_thumbnail_url,
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
        
        // Get filters from URL (using slugs)
        $url_type_slug = isset($_GET['resource_type']) ? sanitize_text_field($_GET['resource_type']) : '';
        $url_product_slug = isset($_GET['resource_product']) ? sanitize_text_field($_GET['resource_product']) : '';
        $url_sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';
        $url_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        
        $args = [
            'post_type' => 'resources',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
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
            $tax_query['relation'] = 'AND';
        }
        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }
        
        $query = new \WP_Query($args);
        ?>
        <div class="resource-filter-section" id="resource-filter-section">
            <style>
                .resource-filter-section { display: flex;align-items: flex-start; gap: 40px; max-width: 1400px; margin: 0 auto; padding: 40px 20px; }
                .resource-filter-sidebar { width: 385px;flex-shrink: 0;background: #fff;border-radius: 12px;padding: 8px; }
                .resource-filter-sidebar h2 { margin: 0 0 2px 0;color: #06283D;font-size: 18px;font-style: normal;font-weight: 500;line-height: 26px; }
                .resource-filter-sidebar p { color: #5C5C5C;font-size: 14px;font-style: normal;font-weight: 400;line-height: 20px;margin: 0; }
                .resource-filter-group h3 { color: #5C5C5C;font-size: 16px;font-style: normal;font-weight: 500 !important;line-height: 24px; }
                .resource-filter-group h3:first-letter { text-transform: uppercase; }
                .resource-filter-item { display: flex; align-items: center; gap: 4px; padding: 8px; border-radius: 4px; cursor: pointer; margin-bottom: 2px; transition: background 0.2s; }
                .resource-filter-item:hover { background: #F2F5FA; }
                .resource-filter-item.active { background: #F2F5FA; }
                .resource-filter-item img { width: 24px; height: 24px; object-fit: contain; flex-shrink: 0;padding: 3px; }
                .resource-filter-item span { color: #5F6F94;font-size: 16px;font-style: normal;font-weight: 500;line-height: 24px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 1;-webkit-box-orient: vertical;min-height: unset; }
                .resource-filter-item:hover span{ color: #4A5673; }
                .resource-filter-item.active span{ color: #06283D; }
                .resource-filter-clear-wrapper { margin-top: 0;padding: 8px; }
                a.resource-filter-clear { font-size: 16px;font-style: normal;font-weight: 600;line-height: 24px; }
                /* a.resource-filter-clear:hover { color: #7b7676; } */
                .reset-disabled {
                    pointer-events: none;
                    opacity: 0.5;
                    cursor: not-allowed;
                    color: #949494!important;
                    border-color: #E6E6E6!important;
                }
                .js-dark .reset-disabled {
                    color: #949494!important;
                    border-color: #FFFFFF1A!important;
                }
                .resource-main-content { flex: 1; }
                .resource-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
                .resource-header h2 { font-size: 32px; font-weight: 600; margin: 0; color: #06283D; }
                .resource-header-info { display: flex; align-items: center; gap: 24px; }
                .resource-count { color: #5C5C5C;font-size: 14px;font-style: normal;font-weight: 400;line-height: 20px; }
                .resource-sort { position: relative; }
                .resource-sort select { width:100%;min-width: 180px; padding:8px 12px; border-radius:8px; border:1px solid #E5E9EC; background:#fff; height:auto; color:#06283D; font-size:16px; font-weight:400; cursor:pointer; appearance:none; background-image:url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%234A5673' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center;text-overflow: ellipsis;white-space: nowrap; }
                .resource-sort select:focus { outline:none; border-color:#E5E9EC; }
                .resource-sort select option { border:1px solid #E5E9EC; padding:5px;font-size: 12px; background:#FFFFFF; color:#4A5673; }
                .resource-sort select option:checked, .resource-sort select option:hover{background: #f2f5fa;
                color: #5F6F94;}
                .resource-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(24%, 3fr)); gap: 20px; margin-bottom: 0; }
                .resource-card { border: 0;border-radius: 12px;display: flex;flex-direction: column;background: #fff;transition: box-shadow 0.2s;height: 100%;gap: 12px;padding: 8px; }
                .resource-image { width: 100%; height: 200px; overflow: hidden; background: #f5f5f5; flex-shrink: 0;border-radius: 12px; }
                .resource-image img { width: 100%; height: 100%; object-fit: cover;border-radius: 12px; }
                .resource-content { padding: 12px;flex: 1;display: flex;flex-direction: column;gap: 8px; }
                .resource-type-badge { display: inline-block;padding: 4px 12px;background: #F2F5FA;color: #5F6F94;margin-bottom: 0;width: fit-content;border: 1px solid #F2F5FA;border-radius: 28px;font-size: 14px;font-style: normal;font-weight: 500;line-height: 20px; }
                .resource-title { color: #06283D;font-size: 24px;font-style: normal;font-weight: 500;line-height: 32px;margin: 0; }
                .resource-file-size { color: #5C5C5C;font-size: 14px;font-style: normal;font-weight: 400;line-height: 20px; }
                .resource-load-more { text-align: center; margin-top: 20px; }
                .load-more-btn { padding: 8px 16px;border: 1px solid #E5E9EC;background: #fff;color: #0099ED;transition: all 0.2s;border-radius: 8px;font-size: 16px;font-style: normal;font-weight: 600;line-height: 24px; }
                .load-more-btn:hover { background: #0074B2; color: white; }
                .load-more-btn:disabled { opacity: 0.5; cursor: not-allowed; }
                
.js-dark .load-more-btn, .js-dark .load-more-btn:hover, .js-dark .load-more-btn:focus  {
    border: 1px solid #C1C4C633;
    background: #464A4F;
    color: #74C2ED;
}
                .resource-no-results { text-align: center; padding: 40px; color: #666; }
                .resource_filter_cont { padding: 8px; }
                .resource-filter-group { padding: 8px 0px; }
                .resource-filter-group h3{ padding: 0 8px; margin: 0; }
                .resource-card:hover .resource-type-badge{ border-color: #D7DBE4; }
                .js-dark .resource-filter-sidebar,.js-dark .resource-sort select,.js-dark .resource-card{ background: #262A30; }
                .js-dark .resource-sort select{ border-color: #464a4f;;color: rgba(255, 255, 255, 0.9);background: #262A30;appearance:none; background-image:url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%234A5673' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center;text-overflow: ellipsis;white-space: nowrap; }
                .js-dark .resource-sort select option{ border-color: #262A30; }
                .js-dark .resource-file-size{ color: rgba(255, 255, 255, 0.9); }
                .js-dark .resource-type-badge{background: rgba(255, 206, 147, 0.1);color: #D7DBE4;border: 1px solid rgb(255 255 255 / 10%);}
                .js-dark .resource-card:hover .resource-type-badge {border: 1px solid rgb(255 255 255 / 10%);}.js-dark .bg-resources span.btn-blue {background: #007ABE;}
                img.filter-icon-dark{ display: none; }
                .js-dark img.filter-icon{ display: none; }
                .js-dark img.filter-icon-dark{ display: block; }
                .js-dark .resource-filter-item:hover ,.js-dark .resource-filter-item.active{ background: rgb(147, 147, 147); }
                
                @media (max-width: 768px) {
                    .resource-filter-section { flex-direction: column; }
                    .resource-filter-sidebar { width: 100%; }
                    .resource-grid { grid-template-columns: 1fr; }
                    .resource-filter-section{ padding: 40px 0px; }
                }
            </style>
            
            <div class="resource-filter-sidebar">
                <div class="resource_filter_cont">
                    <h2><?php echo esc_html($section_title); ?></h2>
                    <p><?php echo esc_html($section_subtitle); ?></p>
                </div>
                
                <div class="resource-filter-group">
                    <h3>by resource type</h3>
                    <?php foreach ($resource_types as $term) : 
                        $is_active = ($url_type_slug == $term['slug']);
                    ?>
                        <div class="resource-filter-item <?php echo $is_active ? 'active' : ''; ?>" data-taxonomy="resource_type" data-term-slug="<?php echo esc_attr($term['slug']); ?>">
                            <?php 
                            $light_img_url = '';
                            $dark_img_url = '';
                            
                            // Get light image URL
                            if (!empty($term['thumbnail_url'])) {
                                $light_img_url = $term['thumbnail_url'];
                            } elseif (!empty($term['thumbnail_id'])) {
                                $light_img_url = wp_get_attachment_image_url($term['thumbnail_id'], 'thumbnail');
                            }
                            
                            // Get dark image URL
                            if (!empty($term['dark_thumbnail_url'])) {
                                $dark_img_url = $term['dark_thumbnail_url'];
                            } elseif (!empty($term['dark_thumbnail_id'])) {
                                $dark_img_url = wp_get_attachment_image_url($term['dark_thumbnail_id'], 'thumbnail');
                            } elseif (!empty($light_img_url)) {
                                $dark_img_url = $light_img_url; // Fallback to light image
                            }
                            
                            if (!empty($light_img_url)) : ?>
                                <img src="<?php echo esc_url($light_img_url); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon">
                                <?php if (!empty($dark_img_url)) : ?>
                                    <img src="<?php echo esc_url($dark_img_url); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon-dark">
                                <?php endif; ?>
                            <?php endif; ?>
                            <span><?php echo esc_html($term['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="resource-filter-group">
                    <!-- <h3>by resource product</h3> -->
                    <?php foreach ($resource_products as $term) : 
                        $is_active = ($url_product_slug == $term['slug']);
                    ?>
                        <div class="resource-filter-item <?php echo $is_active ? 'active' : ''; ?>" data-taxonomy="resource_product" data-term-slug="<?php echo esc_attr($term['slug']); ?>">
                            <?php 
                            $light_img_url = '';
                            $dark_img_url = '';
                            
                            // Get light image URL
                            if (!empty($term['thumbnail_url'])) {
                                $light_img_url = $term['thumbnail_url'];
                            } elseif (!empty($term['thumbnail_id'])) {
                                $light_img_url = wp_get_attachment_image_url($term['thumbnail_id'], 'thumbnail');
                            }
                            
                            // Get dark image URL
                            if (!empty($term['dark_thumbnail_url'])) {
                                $dark_img_url = $term['dark_thumbnail_url'];
                            } elseif (!empty($term['dark_thumbnail_id'])) {
                                $dark_img_url = wp_get_attachment_image_url($term['dark_thumbnail_id'], 'thumbnail');
                            } elseif (!empty($light_img_url)) {
                                $dark_img_url = $light_img_url; // Fallback to light image
                            }
                            
                            if (!empty($light_img_url)) : ?>
                                <img src="<?php echo esc_url($light_img_url); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon" >
                                <?php if (!empty($dark_img_url)) : ?>
                                    <img src="<?php echo esc_url($dark_img_url); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon-dark" >
                                <?php endif; ?>
                            <?php endif; ?>
                            <span><?php echo esc_html($term['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php
                $has_active_filters = !empty($url_type_slug) || !empty($url_product_slug) || $url_sort !== 'newest';
                $clear_filters_url = $has_active_filters ? remove_query_arg(['resource_type', 'resource_product', 'sort', 'page']) : '#';
                $clear_link_class = 'resource-filter-clear' . ($has_active_filters ? '' : ' reset-disabled');
                $clear_link_aria = $has_active_filters ? 'false' : 'true';
                ?>
                <div class="resource-filter-clear-wrapper">
                    <a href="<?php echo esc_url($clear_filters_url); ?>" class="<?php echo esc_attr($clear_link_class); ?> theme-btn bg-trans border_btnlight" aria-disabled="<?php echo esc_attr($clear_link_aria); ?>">Clear filter</a>
                </div>
            </div>
            
            <div class="resource-main-content">
                <div class="resource-header">
                    <div class="resource-sort">
                        <select id="resource-sort">
                            <option value="newest" <?php selected($url_sort, 'newest'); ?>>Sort by newest</option>
                            <option value="oldest" <?php selected($url_sort, 'oldest'); ?>>Sort by oldest</option>
                        </select>
                    </div>
                    <div class="resource-header-info">
                        <span class="resource-count">Showing <?php echo esc_html($query->post_count); ?> of <?php echo esc_html($query->found_posts); ?></span>
                        
                    </div>
                </div>
                
                <div class="resource-results">
                    <?php if ($query->have_posts()) : ?>
                        <div class="resource-grid">
                            <?php while ($query->have_posts()) : $query->the_post(); 
                                $post_id = get_the_ID();
                                $file_size = get_field('resource_file_size', $post_id);
                                $resource_types_terms = get_the_terms($post_id, 'resource_type');
                            ?>
                                <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="resource-card" >
                                    <div class="resource-content">
                                        <?php if (!empty($resource_types_terms) && !is_wp_error($resource_types_terms)) : ?>
                                            <div class="resource-type-badge"><?php echo esc_html($resource_types_terms[0]->name); ?></div>
                                        <?php endif; ?>
                                        <h3 class="resource-title"><?php echo esc_html(get_the_title($post_id)); ?></h3>
                                        <?php if (!empty($file_size)) : ?>
                                            <div class="resource-file-size"><?php echo esc_html($file_size); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="resource-image">
                                        <?php if (has_post_thumbnail($post_id)) : ?>
                                            <?php echo get_the_post_thumbnail($post_id, 'medium'); ?>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        </div>
                        
                        <?php if ($query->found_posts > $posts_per_page) : ?>
                            <div class="resource-load-more">
                                <button class="load-more-btn"
                                    data-offset="<?php echo esc_attr($posts_per_page); ?>"
                                    data-load-count="3"
                                    data-found-posts="<?php echo esc_attr($query->found_posts); ?>"
                                    data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"
                                    data-nonce="<?php echo esc_attr(wp_create_nonce('load_more_resources')); ?>"
                                >Show more</button>
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
            
            // Get current URL parameters
            var urlParams = new URLSearchParams(window.location.search);
            var currentType = urlParams.get('resource_type') || '';
            var currentProduct = urlParams.get('resource_product') || '';
            var currentSort = urlParams.get('sort') || 'newest';
            var currentPage = urlParams.get('page') || '1';
            
            // Function to build URL and reload with scroll preservation
            function buildUrlAndReload(type, product, sort, page) {
                // Store scroll position and section ID in sessionStorage
                var sectionElement = document.getElementById('resource-filter-section');
                if (sectionElement) {
                    var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                    sessionStorage.setItem('resource_filter_scroll', scrollPosition);
                    sessionStorage.setItem('resource_filter_reload', 'true');
                }
                
                var params = new URLSearchParams();
                if (type) params.set('resource_type', type);
                if (product) params.set('resource_product', product);
                if (sort !== 'newest') params.set('sort', sort);
                if (page > 1) params.set('page', page);
                
                var newUrl = window.location.pathname;
                if (params.toString()) {
                    newUrl += '?' + params.toString();
                }
                window.location.href = newUrl;
            }
            
            // Restore scroll position after page load
            if (sessionStorage.getItem('resource_filter_reload') === 'true') {
                sessionStorage.removeItem('resource_filter_reload');
                var savedScroll = parseInt(sessionStorage.getItem('resource_filter_scroll')) || 0;
                sessionStorage.removeItem('resource_filter_scroll');
                
                // Wait for page to fully load, then scroll smoothly
                setTimeout(function() {
                    var sectionElement = document.getElementById('resource-filter-section');
                    if (sectionElement) {
                        var sectionTop = sectionElement.getBoundingClientRect().top + window.pageYOffset;
                        // Scroll to section with offset for fixed headers if any
                        window.scrollTo({
                            top: Math.max(0, sectionTop - 100),
                            behavior: 'smooth'
                        });
                    } else if (savedScroll > 0) {
                        // Fallback to saved scroll position
                        window.scrollTo({
                            top: savedScroll,
                            behavior: 'smooth'
                        });
                    }
                }, 100);
            }
            
            // Filter item click handler
            var filterItems = section.querySelectorAll('.resource-filter-item');
            filterItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    var taxonomy = this.getAttribute('data-taxonomy');
                    var termSlug = this.getAttribute('data-term-slug');
                    var isActive = this.classList.contains('active');
                    
                    var newType = currentType;
                    var newProduct = currentProduct;
                    
                    if (taxonomy === 'resource_type') {
                        newType = isActive ? '' : termSlug;
                    } else if (taxonomy === 'resource_product') {
                        newProduct = isActive ? '' : termSlug;
                    }
                    
                    buildUrlAndReload(newType, newProduct, currentSort, 1);
                });
            });
            
            // Sort dropdown change
            var sortSelect = document.getElementById('resource-sort');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    buildUrlAndReload(currentType, currentProduct, this.value, 1);
                });
            }
            
            // Load more button (AJAX)
            var loadMoreBtn = section.querySelector('.load-more-btn');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    var btn = this;
                    if (btn.disabled) return;

                    var offset = parseInt(btn.getAttribute('data-offset')) || 0;
                    var loadCount = parseInt(btn.getAttribute('data-load-count')) || 3;
                    var foundPosts = parseInt(btn.getAttribute('data-found-posts')) || 0;
                    var ajaxUrl = btn.getAttribute('data-ajax-url');
                    var nonce = btn.getAttribute('data-nonce');

                    btn.disabled = true;
                    btn.textContent = 'Loading...';

                    var formData = new FormData();
                    formData.append('action', 'load_more_resources');
                    formData.append('nonce', nonce);
                    formData.append('offset', offset);
                    formData.append('load_count', loadCount);
                    formData.append('resource_type', currentType);
                    formData.append('resource_product', currentProduct);
                    formData.append('sort', currentSort);

                    fetch(ajaxUrl, { method: 'POST', body: formData })
                        .then(function(res) { return res.json(); })
                        .then(function(data) {
                            if (data.success && data.data.html) {
                                var grid = section.querySelector('.resource-grid');
                                if (grid) {
                                    grid.insertAdjacentHTML('beforeend', data.data.html);
                                }
                                var newOffset = offset + data.data.loaded;
                                var countEl = section.querySelector('.resource-count');
                                if (countEl) {
                                    countEl.textContent = 'Showing ' + newOffset + ' of ' + foundPosts;
                                }
                                if (newOffset < foundPosts) {
                                    btn.setAttribute('data-offset', newOffset);
                                    btn.disabled = false;
                                    btn.textContent = 'Show more';
                                } else {
                                    btn.parentElement.style.display = 'none';
                                }
                            } else {
                                btn.parentElement.style.display = 'none';
                            }
                        })
                        .catch(function() {
                            btn.disabled = false;
                            btn.textContent = 'Show more';
                        });
                });
            }

            // Clear filters link: do nothing when no filters applied (disabled state)
            var clearLink = section.querySelector('a.resource-filter-clear');
            if (clearLink) {
                clearLink.addEventListener('click', function(e) {
                    if (this.classList.contains('reset-disabled') || this.getAttribute('aria-disabled') === 'true') {
                        e.preventDefault();
                    }
                });
            }
        })();
        </script>
    <?php 
        wp_reset_postdata();
    }
}


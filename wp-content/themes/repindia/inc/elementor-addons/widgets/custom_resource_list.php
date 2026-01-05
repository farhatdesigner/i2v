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
        
        // Build query args - for load more, we need to calculate offset
        $posts_to_show = $posts_per_page * $url_page;
        $args = [
            'post_type' => 'resources',
            'post_status' => 'publish',
            'posts_per_page' => $posts_to_show,
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
            $tax_query['relation'] = 'AND';
        }
        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }
        
        $query = new \WP_Query($args);
        ?>
        <div class="resource-filter-section" id="resource-filter-section">
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
                .resource-filter-clear-wrapper { margin-top: 20px; }
                .resource-filter-clear { color: #0074B2; text-decoration: none; font-size: 14px; display: inline-block; }
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
                .resource-card { border: 1px solid #e5e5e5; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; background: white; transition: box-shadow 0.2s; height: 100%; }
                .resource-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
                .resource-image { width: 100%; height: 200px; overflow: hidden; background: #f5f5f5; flex-shrink: 0; }
                .resource-image img { width: 100%; height: 100%; object-fit: cover; }
                .resource-content { padding: 20px; flex: 1; display: flex; flex-direction: column; }
                .resource-type-badge { display: inline-block; padding: 4px 12px; background: #E5F6FF; color: #0074B2; border-radius: 4px; font-size: 12px; font-weight: 500; margin-bottom: 12px; width: fit-content; }
                .resource-title { margin: 0 0 8px 0; font-size: 20px; font-weight: 500; line-height: 1.4; }
                .resource-title a { color: #06283D; text-decoration: none; }
                .resource-title a:hover { text-decoration: underline; }
                .resource-file-size { font-size: 14px; color: #666; margin-top: auto; }
                .resource-load-more { text-align: center; margin-top: 40px; }
                .load-more-btn { padding: 12px 32px; border: 1px solid #0074B2; background: white; color: #0074B2; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 500; transition: all 0.2s; }
                .load-more-btn:hover { background: #0074B2; color: white; }
                .load-more-btn:disabled { opacity: 0.5; cursor: not-allowed; }
                .resource-no-results { text-align: center; padding: 40px; color: #666; }
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
                                <img src="<?php echo esc_url($light_img_url); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon" style="<?php echo $is_active ? 'display:none;' : ''; ?>">
                                <?php if (!empty($dark_img_url)) : ?>
                                    <img src="<?php echo esc_url($dark_img_url); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon-dark" style="<?php echo $is_active ? '' : 'display:none;'; ?>">
                                <?php endif; ?>
                            <?php endif; ?>
                            <span><?php echo esc_html($term['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="resource-filter-group">
                    <h3>by resource product</h3>
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
                                <img src="<?php echo esc_url($light_img_url); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon" style="<?php echo $is_active ? 'display:none;' : ''; ?>">
                                <?php if (!empty($dark_img_url)) : ?>
                                    <img src="<?php echo esc_url($dark_img_url); ?>" alt="<?php echo esc_attr($term['name']); ?>" class="filter-icon-dark" style="<?php echo $is_active ? '' : 'display:none;'; ?>">
                                <?php endif; ?>
                            <?php endif; ?>
                            <span><?php echo esc_html($term['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php
                $clear_filters_url = remove_query_arg(['resource_type', 'resource_product', 'page']);
                if (empty($url_type_slug) && empty($url_product_slug)) {
                    $clear_filters_url = '#';
                }
                ?>
                <div class="resource-filter-clear-wrapper">
                    <a href="<?php echo esc_url($clear_filters_url); ?>" class="resource-filter-clear"<?php echo (empty($url_type_slug) && empty($url_product_slug)) ? ' style="pointer-events: none; opacity: 0.5;"' : ''; ?>>Clear filters</a>
                </div>
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
                        
                        <?php 
                        // Calculate if there are more posts to load
                        $total_posts = $query->found_posts;
                        $currently_showing = $query->post_count;
                        $has_more = $currently_showing < $total_posts;
                        $next_page = $url_page + 1;
                        ?>
                        <?php if ($has_more) : ?>
                            <div class="resource-load-more">
                                <button class="load-more-btn" data-next-page="<?php echo esc_attr($next_page); ?>">Show more</button>
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
            
            // Load more button
            var loadMoreBtn = section.querySelector('.load-more-btn');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    var nextPage = parseInt(this.getAttribute('data-next-page')) || 2;
                    buildUrlAndReload(currentType, currentProduct, currentSort, nextPage);
                });
            }
        })();
        </script>
    <?php 
        wp_reset_postdata();
    }
}

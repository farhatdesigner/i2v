<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Custom_Store_Locator extends Widget_Base
{
    // Static flag to ensure scripts are only enqueued once per page
    private static $scripts_enqueued = false;

    public function get_name()
    {
        return 'custom_store_locator';
    }
    
    public function get_title()
    {
        return 'Custom Store Locator';
    }
    
    public function get_icon()
    {
        return 'fa fa-map-marker-alt';
    }
    
    public function get_category()
    {
        return ['general'];
    }

    protected function register_controls()
    {
        // Main Settings Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Map Settings', 'repindia'),
            ]
        );

        // Show Location Filter Toggle
        $this->add_control(
            'show_location_filter',
            [
                'label' => __('Show Location Filter', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'repindia'),
                'label_off' => __('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Show Project Type Filter Toggle
        $this->add_control(
            'show_project_type_filter',
            [
                'label' => __('Show Project Type Filter', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'repindia'),
                'label_off' => __('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Initial Map Zoom
        $this->add_control(
            'initial_zoom',
            [
                'label' => __('Initial Map Zoom', 'repindia'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 18,
                'step' => 1,
                'description' => __('Zoom level when map first loads (1-18)', 'repindia'),
            ]
        );

        // Map Height Control
        $this->add_control(
            'map_height',
            [
                'label' => __('Map Height (px)', 'repindia'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 1000,
                        'step' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'selectors' => [
                    '{{WRAPPER}} .custom-map-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Query map_projects CPT and fetch required data
     * Single query only - no repeated queries
     * 
     * IMPORTANT: Filtering is based ONLY on taxonomies:
     * - map_location (taxonomy slug: location_slug, name: location_name)
     * - map_project_type (taxonomy slug: project_type_slug, name: project_type_name)
     * No other fields are used for filtering
     */
    private function get_projects_data()
    {
        // Single WP_Query for map_projects
        $query_args = [
            'post_type' => 'map_projects',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'fields' => 'ids', // Optimize: fetch only IDs first
        ];

        $query = new \WP_Query($query_args);
        $projects_data = [];
        $total_posts = $query->found_posts;
        $posts_without_coords = 0;

        if ($query->have_posts()) {
            // Check if ACF is active
            if (!function_exists('get_field')) {
                error_log('Custom Store Locator: ACF (Advanced Custom Fields) plugin is not active. Please install and activate ACF plugin.');
                wp_reset_postdata();
                return [];
            }

            foreach ($query->posts as $post_id) {
                // Get ACF fields - try multiple field name variations
                // Method 1: Standard field names
                $latitude = get_field('latitude', $post_id);
                $longitude = get_field('longitude', $post_id);
                
                // Method 2: Try alternate field names (in case of typos)
                if (empty($latitude)) {
                    $latitude = get_field('lat', $post_id);
                }
                if (empty($longitude)) {
                    $longitude = get_field('longitude', $post_id);
                    // Check for typo: longitute (as user mentioned earlier)
                    if (empty($longitude)) {
                        $longitude = get_field('longitute', $post_id);
                    }
                    // Try 'lng' as alternative
                    if (empty($longitude)) {
                        $longitude = get_field('lng', $post_id);
                    }
                }
                
                // Method 3: Try get_post_meta directly (bypass ACF)
                if (empty($latitude)) {
                    $latitude = get_post_meta($post_id, 'latitude', true);
                }
                if (empty($longitude)) {
                    $longitude = get_post_meta($post_id, 'longitude', true);
                    if (empty($longitude)) {
                        $longitude = get_post_meta($post_id, 'longitute', true);
                    }
                    if (empty($longitude)) {
                        $longitude = get_post_meta($post_id, 'lng', true);
                    }
                }
                
                // Debug: Log ALL meta keys to see what's actually stored (only for first post to avoid log spam)
                if ($post_id == reset($query->posts)) {
                    $all_meta = get_post_meta($post_id);
                    $meta_keys = array_filter(array_keys($all_meta), function($key) {
                        return strpos($key, '_') !== 0 && in_array(strtolower($key), ['latitude', 'longitude', 'longitute', 'lat', 'lng', 'project_date', 'number_of_cameras', 'project_description']);
                    });
                    if (!empty($meta_keys)) {
                        error_log(sprintf('Custom Store Locator: Post ID %d - Relevant meta keys: %s', $post_id, implode(', ', $meta_keys)));
                    }
                    
                    // Also check all keys containing "lat" or "long"
                    $lat_lng_keys = array_filter(array_keys($all_meta), function($key) {
                        return stripos($key, 'lat') !== false || stripos($key, 'long') !== false || stripos($key, 'lng') !== false;
                    });
                    if (!empty($lat_lng_keys)) {
                        error_log(sprintf('Custom Store Locator: Post ID %d - Found lat/long related keys: %s', $post_id, implode(', ', $lat_lng_keys)));
                        foreach ($lat_lng_keys as $key) {
                            if (strpos($key, '_') !== 0) { // Skip private keys (ACF field references)
                                $value = get_post_meta($post_id, $key, true);
                                error_log(sprintf('Custom Store Locator: Post ID %d - Key "%s" = %s (type: %s)', $post_id, $key, var_export($value, true), gettype($value)));
                            }
                        }
                    } else {
                        error_log(sprintf('Custom Store Locator: Post ID %d - WARNING: No lat/long related meta keys found. All meta keys: %s', $post_id, implode(', ', array_slice(array_keys($all_meta), 0, 20))));
                    }
                }
                
                // Debug: Log what values we're getting
                error_log(sprintf(
                    'Custom Store Locator: Post ID %d - Post Title: %s | Latitude: %s (type: %s) | Longitude: %s (type: %s)',
                    $post_id,
                    get_the_title($post_id),
                    var_export($latitude, true),
                    gettype($latitude),
                    var_export($longitude, true),
                    gettype($longitude)
                ));
                
                // Validate coordinates (handle string/number types from ACF text fields)
                // Convert to string first, then trim
                $lat_value = $latitude !== null && $latitude !== '' ? trim((string) $latitude) : '';
                $lng_value = $longitude !== null && $longitude !== '' ? trim((string) $longitude) : '';
                
                // Convert to numeric values for validation
                $lat_float = is_numeric($lat_value) ? floatval($lat_value) : 0;
                $lng_float = is_numeric($lng_value) ? floatval($lng_value) : 0;
                
                // Skip if coordinates are missing or invalid
                // Valid latitude: -90 to 90, Valid longitude: -180 to 180
                // For India coordinates: latitude ~8-37, longitude ~68-97
                if ($lat_value === '' || $lng_value === '' || 
                    !is_numeric($lat_value) || !is_numeric($lng_value) ||
                    abs($lat_float) > 90 || abs($lng_float) > 180) {
                    $posts_without_coords++;
                    error_log(sprintf(
                        'Custom Store Locator: Post ID %d skipped - Invalid coordinates. Raw Lat: %s (%s), Raw Lng: %s (%s), Processed Lat: "%s" (float: %f), Processed Lng: "%s" (float: %f)',
                        $post_id,
                        var_export($latitude, true),
                        gettype($latitude),
                        var_export($longitude, true),
                        gettype($longitude),
                        $lat_value,
                        $lat_float,
                        $lng_value,
                        $lng_float
                    ));
                    continue;
                }
                
                error_log(sprintf(
                    'Custom Store Locator: Post ID %d VALID coordinates - Lat: %f, Lng: %f',
                    $post_id,
                    $lat_float,
                    $lng_float
                ));

                // Get taxonomies (map_location and map_project_type) - ONLY taxonomy-based
                $location_terms = wp_get_post_terms($post_id, 'map_location', ['fields' => 'all']);
                $project_type_terms = wp_get_post_terms($post_id, 'map_project_type', ['fields' => 'all']);

                // Debug: Log taxonomy data
                error_log(sprintf(
                    'Custom Store Locator: Post ID %d - Location terms: %d, Project type terms: %d',
                    $post_id,
                    is_array($location_terms) && !is_wp_error($location_terms) ? count($location_terms) : 0,
                    is_array($project_type_terms) && !is_wp_error($project_type_terms) ? count($project_type_terms) : 0
                ));

                // Extract taxonomy slugs and names (filtering is based ONLY on these)
                $location_slug = '';
                $location_name = '';
                if (!empty($location_terms) && !is_wp_error($location_terms) && isset($location_terms[0])) {
                    $location_slug = sanitize_key($location_terms[0]->slug);
                    $location_name = sanitize_text_field($location_terms[0]->name);
                    error_log(sprintf('Custom Store Locator: Post ID %d - Location: %s (%s)', $post_id, $location_name, $location_slug));
                }

                $project_type_slug = '';
                $project_type_name = '';
                if (!empty($project_type_terms) && !is_wp_error($project_type_terms) && isset($project_type_terms[0])) {
                    $project_type_slug = sanitize_key($project_type_terms[0]->slug);
                    $project_type_name = sanitize_text_field($project_type_terms[0]->name);
                    error_log(sprintf('Custom Store Locator: Post ID %d - Project Type: %s (%s)', $post_id, $project_type_name, $project_type_slug));
                } else {
                    error_log(sprintf('Custom Store Locator: Post ID %d - WARNING: No map_project_type taxonomy assigned. Please assign terms from map_project_type taxonomy.', $post_id));
                }

                // Normalize into flat array structure
                // ACF Fields: latitude, longitude, project_date, number_of_cameras, project_description
                $projects_data[] = [
                    'id' => $post_id,
                    'title' => get_the_title($post_id),
                    'latitude' => $lat_float,
                    'longitude' => $lng_float,
                    'location_slug' => $location_slug,
                    'location_name' => $location_name,
                    'project_type_slug' => $project_type_slug,
                    'project_type_name' => $project_type_name,
                    'project_date' => get_field('project_date', $post_id) ?: '',
                    'number_of_cameras' => get_field('number_of_cameras', $post_id) ?: '',
                    'project_description' => get_field('project_description', $post_id) ?: '',
                ];
            }
        }

        wp_reset_postdata();
        
        // Debug: Log if no projects found
        if (empty($projects_data)) {
            $error_msg = sprintf(
                'Custom Store Locator: No projects with valid coordinates found. Total posts: %d, Posts without coordinates: %d. Check if map_projects CPT has published posts with latitude/longitude ACF fields set.',
                $total_posts,
                $posts_without_coords
            );
            error_log($error_msg);
        } else {
            error_log(sprintf('Custom Store Locator: Found %d projects with valid coordinates.', count($projects_data)));
        }
        
        return $projects_data;
    }

    /**
     * Load map scripts and styles (only once per page)
     * Note: Cannot use enqueue_scripts() as it's a final method in Elementor\Element_Base
     */
    private function load_map_assets($projects_data)
    {
        // Always localize script (even if already enqueued) because each widget may have different data
        // Note: wp_localize_script can be called multiple times safely
        
        // Register and enqueue scripts only once
        if (!self::$scripts_enqueued) {
            // Register Leaflet CSS
            wp_register_style(
                'leaflet-css',
                'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
                [],
                '1.9.4'
            );

            // Register Leaflet JS
            wp_register_script(
                'leaflet-js',
                'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
                [],
                '1.9.4',
                true
            );

            // Register Custom Map CSS
            wp_register_style(
                'custom-store-locator-css',
                get_template_directory_uri() . '/assets/css/custom-map.css',
                ['leaflet-css'],
                '1.0.0'
            );

            // Register Custom Store Locator JS (depends on Leaflet)
            wp_register_script(
                'custom-store-locator-js',
                get_template_directory_uri() . '/assets/js/custom-store-locator.js',
                ['leaflet-js'],
                '1.0.0',
                true
            );

            // Enqueue registered scripts
            wp_enqueue_style('leaflet-css');
            wp_enqueue_script('leaflet-js');
            wp_enqueue_style('custom-store-locator-css');
            wp_enqueue_script('custom-store-locator-js');

            self::$scripts_enqueued = true;
        }

        // Always localize script with current widget's data
        // wp_localize_script must be called after wp_register_script/wp_enqueue_script
        // This ensures data is available even if script was enqueued by previous widget instance
        wp_localize_script(
            'custom-store-locator-js',
            'customStoreLocatorData',
            [
                'projects' => $projects_data,
            ]
        );
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        // Single query for map_projects CPT
        $projects_data = $this->get_projects_data();
        
        // Load map assets only when widget is rendered (pass data for localization)
        $this->load_map_assets($projects_data);

        // Generate unique map ID for this widget instance
        $map_id = 'custom-map-' . $this->get_id();
        
        // Get settings
        $show_location_filter = !empty($settings['show_location_filter']) && $settings['show_location_filter'] === 'yes';
        $show_project_type_filter = !empty($settings['show_project_type_filter']) && $settings['show_project_type_filter'] === 'yes';
        $initial_zoom = !empty($settings['initial_zoom']) ? intval($settings['initial_zoom']) : 5;
        
        // Encode widget-specific settings for JavaScript
        $widget_settings = [
            'mapId' => $map_id,
            'initialZoom' => $initial_zoom,
            'showLocationFilter' => $show_location_filter,
            'showProjectTypeFilter' => $show_project_type_filter,
        ];
        $widget_settings_json = wp_json_encode($widget_settings);
        $widget_settings_escaped = esc_attr($widget_settings_json);
        ?>

        <div class="custom-store-locator-wrapper" data-widget-settings="<?php echo $widget_settings_escaped; ?>">
            <!-- Filter Section - Chip Style -->
            <div class="custom-map-filters">
                <!-- Location Filter Chips -->
                <?php if ($show_location_filter) : ?>
                <div class="location-filter-chips" id="location-chips-<?php echo esc_attr($map_id); ?>">
                    <!-- Chips will be populated by JavaScript -->
                </div>
                <?php endif; ?>

                <!-- Project Type Dropdown -->
                <?php if ($show_project_type_filter) : ?>
                <div class="project-type-filter-wrapper">
                    <select id="type-filter-<?php echo esc_attr($map_id); ?>" class="project-type-filter">
                        <option value="all"><?php echo esc_html__('Select project type', 'repindia'); ?></option>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>
                <?php endif; ?>
            </div>

            <!-- Map Container -->
            <div class="custom-map-container">
                <div id="<?php echo esc_attr($map_id); ?>" style="width: 100%; height: 100%;"></div>

                <!-- Detail Panel - Right Side -->
                <div class="custom-map-detail-panel">
                    <div class="detail-header">
                        <h3 class="detail-title"></h3>
                        <button class="detail-close" type="button" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="detail-content">
                        <!-- Metrics with Icons -->
                        <div class="detail-metrics">
                            <div class="detail-metric-item">
                                <svg class="metric-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3V6a3 3 0 013-3h13.5a3 3 0 013 3v5.25a3 3 0 01-3 3m-16.5 0a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3m-16.5 0V9.75m16.5 0V12m0 0v2.25m0-2.25h-3m3 0h-3" />
                                </svg>
                                <span class="metric-value detail-itms"></span>
                            </div>
                            <div class="detail-metric-item">
                                <svg class="metric-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="metric-value detail-months"></span>
                            </div>
                            <div class="detail-metric-item">
                                <svg class="metric-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.94" />
                                </svg>
                                <span class="metric-value detail-cameras-count"></span>
                            </div>
                        </div>
                        
                        <!-- Description/Quote -->
                        <div class="detail-description">
                            <p class="detail-quote"></p>
                        </div>
                    </div>
                </div>

                <!-- Show List Button -->
                <button class="show-list-button" type="button">
                    <?php echo esc_html__('Show list', 'repindia'); ?>
                </button>
            </div>
        </div>

        <?php
    }
}

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
        
        // Check if we're in Elementor editor mode
        $is_editor_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
        
        // In editor mode, show placeholder text only
        if ($is_editor_mode) {
            // Get sample data for preview text
            $projects_data = $this->get_projects_data();
            $project_count = count($projects_data);
            ?>
            <div class="custom-store-locator-wrapper elementor-editor-placeholder">
                <div class="elementor-placeholder" style="padding: 40px; text-align: center; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 8px;">
                    <div class="elementor-placeholder-title" style="font-size: 18px; font-weight: 600; color: #495057; margin-bottom: 12px;">
                        <?php echo esc_html__('Custom Store Locator', 'repindia'); ?>
                    </div>
                    <div class="elementor-placeholder-content" style="font-size: 14px; color: #6c757d; line-height: 1.6;">
                        <?php 
                        if ($project_count > 0) {
                            echo sprintf(
                                esc_html__('This widget will display an interactive map with %d project%s on the frontend.', 'repindia'),
                                $project_count,
                                $project_count > 1 ? 's' : ''
                            );
                        } else {
                            echo esc_html__('This widget will display an interactive map with project locations on the frontend. Add projects with location data to see them on the map.', 'repindia');
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            return; // Exit early - don't render map in editor
        }
        
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

                <!-- No Results Fallback -->
                <div class="map-no-results-fallback" style="display: none;">
                    <div class="no-results-content">
                        <p class="no-results-message"><?php echo esc_html__('No projects found matching the selected filters.', 'repindia'); ?></p>
                        <button class="no-results-reset" type="button">
                            <?php echo esc_html__('Reset Filters', 'repindia'); ?>
                        </button>
                    </div>
                </div>

                <!-- Detail Card - Right Side (Shows on Hover) -->
                <div class="custom-map-detail-card">
                    <div class="detail-card-header">
                        <h3 class="detail-title"></h3>
                        <button class="detail-close" type="button" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="detail-card-body">
                        <!-- Project Type / System -->
                        <div class="detail-info-assets">
                            <div class="detail-info-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14" fill="none">
                                    <path d="M2.58364 3.80066H3.06467V5.27054H2.58364V3.80066ZM1.40061 4.05208L1.97192 5.16119L1.54428 5.3815L0.972974 4.27239L1.40061 4.05208ZM4.24642 4.0524L4.67406 4.27271L4.10275 5.38166L3.67511 5.16135L4.24642 4.0524ZM5.16856 7.53814L4.74669 6.1356C4.72113 6.05056 4.66889 5.97599 4.59768 5.92292C4.52648 5.86985 4.44009 5.84109 4.35128 5.84089H1.29719C1.20839 5.84109 1.122 5.86985 1.05079 5.92292C0.979589 5.97599 0.927345 6.05056 0.901781 6.1356L0.480073 7.53814H0.482478L0 7.71196V9.58334H0.565216V9.78377C0.565555 9.90997 0.615837 10.0309 0.705073 10.1201C0.794309 10.2094 0.915243 10.2597 1.04144 10.26C1.16761 10.2596 1.2885 10.2093 1.37771 10.1201C1.46691 10.0309 1.51717 9.90995 1.51751 9.78377V9.58334H4.13097V9.78377C4.13097 10.0458 4.34519 10.26 4.60719 10.26C4.8692 10.26 5.08342 10.0458 5.08342 9.78377V9.58334H5.64848V7.71212L5.16856 7.53814ZM1.04128 9.01203C0.956228 9.01203 0.87466 8.97825 0.814519 8.91811C0.754378 8.85796 0.720591 8.7764 0.720591 8.69134C0.720591 8.60629 0.754378 8.52472 0.814519 8.46458C0.87466 8.40444 0.956228 8.37065 1.04128 8.37065C1.12633 8.37065 1.2079 8.40444 1.26804 8.46458C1.32818 8.52472 1.36197 8.60629 1.36197 8.69134C1.36197 8.7764 1.32818 8.85796 1.26804 8.91811C1.2079 8.97825 1.12633 9.01203 1.04128 9.01203ZM1.20964 7.53814L1.4492 6.41316H4.19928L4.43867 7.53814H1.20964ZM4.60719 9.01203C4.52214 9.01203 4.44057 8.97825 4.38043 8.91811C4.32029 8.85796 4.2865 8.7764 4.2865 8.69134C4.2865 8.60629 4.32029 8.52472 4.38043 8.46458C4.44057 8.40444 4.52214 8.37065 4.60719 8.37065C4.69225 8.37065 4.77382 8.40444 4.83396 8.46458C4.8941 8.52472 4.92788 8.60629 4.92788 8.69134C4.92788 8.7764 4.8941 8.85796 4.83396 8.91811C4.77382 8.97825 4.69225 9.01203 4.60719 9.01203ZM8.81337 6.87399H9.2944V8.34387H8.81337V6.87399ZM7.63242 7.12605L8.20373 8.235L7.77609 8.45532L7.20478 7.34637L7.63242 7.12605ZM10.4747 7.12718L10.9023 7.34749L10.331 8.45644L9.90339 8.23612L10.4747 7.12718ZM11.3981 10.6115L10.9763 9.20894C10.9507 9.12389 10.8985 9.04932 10.8272 8.99625C10.756 8.94318 10.6697 8.91442 10.5809 8.91422H7.52676C7.43798 8.91445 7.35163 8.94323 7.28046 8.9963C7.20928 9.04937 7.15706 9.12392 7.13151 9.20894L6.70948 10.6115H6.71204L6.22973 10.7853V12.6565H6.79478V12.8571C6.79512 12.9833 6.8454 13.1042 6.93464 13.1935C7.02388 13.2827 7.14481 13.333 7.27101 13.3333C7.39721 13.333 7.51814 13.2827 7.60737 13.1935C7.69661 13.1042 7.74689 12.9833 7.74723 12.8571V12.6567H10.3605V12.8571C10.3605 13.1191 10.5749 13.3333 10.8368 13.3333C11.0986 13.3333 11.313 13.1191 11.313 12.8571V12.6567H11.878V10.7853L11.3981 10.6115ZM7.27085 12.0852C7.18579 12.0852 7.10423 12.0514 7.04408 11.9913C6.98394 11.9311 6.95016 11.8496 6.95016 11.7645C6.95016 11.6795 6.98394 11.5979 7.04408 11.5378C7.10423 11.4776 7.18579 11.4438 7.27085 11.4438C7.3559 11.4438 7.43747 11.4776 7.49761 11.5378C7.55775 11.5979 7.59154 11.6795 7.59154 11.7645C7.59154 11.8496 7.55775 11.9311 7.49761 11.9913C7.43747 12.0514 7.3559 12.0852 7.27085 12.0852ZM7.43921 10.6113L7.67876 9.48617H10.4288L10.6684 10.6113H7.43921ZM10.8369 12.0852C10.7519 12.0852 10.6703 12.0514 10.6102 11.9913C10.55 11.9311 10.5162 11.8496 10.5162 11.7645C10.5162 11.6795 10.55 11.5979 10.6102 11.5378C10.6703 11.4776 10.7519 11.4438 10.8369 11.4438C10.922 11.4438 11.0035 11.4776 11.0637 11.5378C11.1238 11.5979 11.1576 11.6795 11.1576 11.7645C11.1576 11.8496 11.1238 11.9311 11.0637 11.9913C11.0035 12.0514 10.922 12.0852 10.8369 12.0852ZM8.81337 0H9.2944V1.46988H8.81337V0ZM7.63178 0.250299L8.20309 1.35941L7.77545 1.57972L7.20414 0.470613L7.63178 0.250299ZM10.4765 0.253666L10.9041 0.47398L10.3328 1.58309L9.90516 1.36277L10.4765 0.253666ZM11.3981 3.73748L10.9763 2.33478C10.9507 2.24974 10.8985 2.17517 10.8272 2.1221C10.756 2.06903 10.6697 2.04027 10.5809 2.04007H7.52676C7.43798 2.0403 7.35163 2.06908 7.28046 2.12215C7.20928 2.17521 7.15706 2.24976 7.13151 2.33478L6.70948 3.73748H6.71204L6.22973 3.9113V5.78252H6.79478V5.98312C6.79512 6.10931 6.8454 6.23025 6.93464 6.31948C7.02388 6.40872 7.14481 6.459 7.27101 6.45934C7.39721 6.459 7.51814 6.40872 7.60737 6.31948C7.69661 6.23025 7.74689 6.10931 7.74723 5.98312V5.78268H10.3605V5.98312C10.3605 6.24512 10.5749 6.45934 10.8368 6.45934C11.0986 6.45934 11.313 6.24512 11.313 5.98312V5.78268H11.878V3.9113L11.3981 3.73748ZM7.27085 5.21121C7.18579 5.21121 7.10423 5.17743 7.04408 5.11729C6.98394 5.05714 6.95016 4.97558 6.95016 4.89052C6.95016 4.80547 6.98394 4.7239 7.04408 4.66376C7.10423 4.60362 7.18579 4.56983 7.27085 4.56983C7.3559 4.56983 7.43747 4.60362 7.49761 4.66376C7.55775 4.7239 7.59154 4.80547 7.59154 4.89052C7.59154 4.97558 7.55775 5.05714 7.49761 5.11729C7.43747 5.17743 7.3559 5.21121 7.27085 5.21121ZM7.43921 3.73748L7.67876 2.61234H10.4288L10.6684 3.73748H7.43921ZM10.8368 5.21121C10.7517 5.21121 10.6701 5.17743 10.61 5.11729C10.5499 5.05714 10.5161 4.97558 10.5161 4.89052C10.5161 4.80547 10.5499 4.7239 10.61 4.66376C10.6701 4.60362 10.7517 4.56983 10.8368 4.56983C10.9218 4.56983 11.0034 4.60362 11.0635 4.66376C11.1237 4.7239 11.1575 4.80547 11.1575 4.89052C11.1575 4.97558 11.1237 5.05714 11.0635 5.11729C11.0034 5.17743 10.9218 5.21121 10.8368 5.21121Z" fill="#5F6F94"/>
                                </svg>
                                <span class="info-value detail-itms"></span>
                            </div>
                            <div class="detail-info-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M6.66667 13.3333C2.99333 13.3333 0 10.34 0 6.66667C0 2.99333 2.99333 0 6.66667 0C10.34 0 13.3333 2.99333 13.3333 6.66667C13.3333 10.34 10.34 13.3333 6.66667 13.3333ZM6.66667 1.33333C3.72667 1.33333 1.33333 3.72667 1.33333 6.66667C1.33333 9.60667 3.72667 12 6.66667 12C9.60667 12 12 9.60667 12 6.66667C12 3.72667 9.60667 1.33333 6.66667 1.33333ZM8.66667 9.33333C8.49333 9.33333 8.32667 9.26667 8.19333 9.14L6.19333 7.14C6.06667 7.01333 6 6.84667 6 6.66667V4C6 3.63333 6.3 3.33333 6.66667 3.33333C7.03333 3.33333 7.33333 3.63333 7.33333 4V6.39333L9.14 8.2C9.4 8.46 9.4 8.88 9.14 9.14C9.00667 9.27333 8.84 9.33333 8.66667 9.33333Z" fill="#5F6F94"/>
                                </svg>
                                <span class="info-value detail-project-date"></span>
                            </div>
                            <div class="detail-info-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M1.67281 7.46062C1.93962 7.36056 2.22643 7.4873 2.3465 7.73409L3.23363 7.40058C3.20028 7.11377 3.23363 6.82028 3.36037 6.5468C3.54046 6.14659 3.8673 5.83976 4.27419 5.68634L11.4713 2.95156C11.8782 2.79814 12.3251 2.81148 12.7253 2.99158C13.1255 3.17168 13.4324 3.49185 13.5858 3.9054L14.5596 6.47343C14.8798 7.32054 14.4529 8.26771 13.6058 8.58788L11.5981 9.34828L12.5652 11.903L13.7059 11.4694C13.986 11.3627 14.2995 11.5028 14.4129 11.7829C14.5196 12.0631 14.3795 12.3832 14.0994 12.4899L12.4452 13.1169C12.3785 13.1436 12.3184 13.1503 12.2517 13.1503C12.1984 13.1503 12.145 13.1436 12.0917 13.1236C11.9382 13.0769 11.8048 12.9569 11.7448 12.7968L10.5842 9.72848L6.42199 11.3093C6.23523 11.3827 6.03512 11.416 5.84168 11.416C5.6149 11.416 5.38811 11.3694 5.16799 11.2693C4.89452 11.1492 4.6744 10.9558 4.50097 10.7157L3.61384 11.0559C3.68721 11.3227 3.5538 11.6095 3.287 11.7095C3.22029 11.7362 3.16026 11.7429 3.09356 11.7429C2.89345 11.7429 2.70669 11.6228 2.60664 11.4361H2.59997L1.3393 8.10763H1.35264C1.27927 7.83415 1.41267 7.554 1.67948 7.45395L1.67281 7.46062ZM3.08689 9.64844L3.23363 10.042L4.06074 9.72848L3.57382 8.44113L2.74671 8.75463L3.08689 9.64844Z" fill="#5F6F94"/>
                                </svg>
                                <span class="info-value detail-cameras-count"></span>
                            </div>
                        </div>
                        
                        <!-- Description/Quote -->
                        <div class="detail-quote-section">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 6.4C0 2.8722 2.8722 0 6.4 0C9.92781 0 12.8 2.8722 12.8 6.4C12.8 9.92781 9.92781 12.8 6.4 12.8C2.8722 12.8 0 9.92781 0 6.4ZM6.99316 6.98068C6.99316 7.30536 6.72467 7.57385 6.39999 7.57385C6.07531 7.57385 5.80682 7.30536 5.80682 6.98068V4.07727C5.80682 3.75258 6.07531 3.48409 6.39999 3.48409C6.72467 3.48409 6.99316 3.75258 6.99316 4.07727V6.98068ZM6.93072 8.192V8.20448C6.99316 8.27941 7.04311 8.35434 7.08057 8.44175C7.11179 8.52917 7.13677 8.62283 7.13677 8.72273C7.13677 8.82263 7.11804 8.91629 7.08057 9.0037C7.04311 9.09736 6.99316 9.17229 6.93072 9.24097V9.25346C6.85579 9.3159 6.78087 9.36585 6.69345 9.40332C6.60604 9.43453 6.51238 9.45951 6.41248 9.45951C6.31257 9.45951 6.21892 9.44078 6.1315 9.40332C6.04409 9.36585 5.96292 9.3159 5.89423 9.25346V9.24097C5.83179 9.17229 5.78184 9.10361 5.74438 9.0037C5.70692 8.91629 5.68818 8.82263 5.68818 8.72273C5.68818 8.62283 5.70692 8.52917 5.74438 8.44175C5.78184 8.35434 5.83179 8.27317 5.89423 8.20448V8.192C5.96916 8.12956 6.04409 8.07961 6.1315 8.04214C6.31257 7.96722 6.51238 7.96722 6.69345 8.04214C6.78087 8.07961 6.86204 8.12956 6.93072 8.192Z" fill="#5F6F94"/>
                            </svg>
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

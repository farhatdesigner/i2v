<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class Custom_Career_List extends Widget_Base {

    public function get_name() {
        return 'custom_career_list';
    }

    public function get_title() {
        return 'Career List with Filters';
    }

    public function get_icon() {
        return 'fa fa-list';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            ['label' => __('Content', 'repindia')]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'repindia'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Open roles',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'section_subtitle',
            [
                'label' => __('Section Subtitle', 'repindia'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Help us bring development superpowers to everyone.',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'enable_filter',
            [
                'label' => __('Enable Filter?', 'repindia'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'repindia'),
                'label_off' => __('No', 'repindia'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Optional: let user pick which taxonomy to use (keeps backward compatibility)
        $this->add_control(
            'filter_taxonomy',
            [
                'label' => __('Filter Taxonomy', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'careerteam' => __('Career Team', 'repindia'),
                    'careercity' => __('Career City', 'repindia'),
                    'careerstate' => __('Career State', 'repindia'),
                    'careercountry' => __('Career Country', 'repindia'),
                ],
                'default' => 'careerteam',
                'condition' => [
                    'enable_filter' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get all terms for a taxonomy (public helper)
     */
    private function get_terms_for_tax($taxonomy) {
        if (!taxonomy_exists($taxonomy)) {
            return [];
        }
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
        ]);
        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }
        return $terms;
    }

    /**
     * Query careers and group by careerteam (or uncategorized)
     * $filter_term_slug may be null
     * $filter_taxonomy is used to filter posts (can be careercity/careerteam/etc)
     */
    public static function get_careers_grouped($filter_term_slug = null, $filter_taxonomy = 'careerteam') {
        $args = [
            'post_type' => 'careers',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
        ];

        // Apply filter if present and taxonomy exists
        if (!empty($filter_term_slug) && $filter_term_slug !== 'all' && taxonomy_exists($filter_taxonomy)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => $filter_taxonomy,
                    'field' => 'slug', // use slug filtering (recommended)
                    'terms' => sanitize_text_field($filter_term_slug),
                ],
            ];
        }

        $query = new \WP_Query($args);
        $grouped = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();

                // team terms (grouping taxonomy)
                $team_terms = get_the_terms($post_id, 'careerteam');
                if (!empty($team_terms) && !is_wp_error($team_terms)) {
                    foreach ($team_terms as $team_term) {
                        $key = $team_term->slug;
                        if (!isset($grouped[$key])) {
                            $grouped[$key] = [
                                'term' => $team_term,
                                'posts' => [],
                            ];
                        }
                        $grouped[$key]['posts'][] = $post_id;
                    }
                } else {
                    // put in uncategorized
                    if (!isset($grouped['uncategorized'])) {
                        $grouped['uncategorized'] = [
                            'term' => (object)['name' => 'Uncategorized', 'slug' => 'uncategorized'],
                            'posts' => [],
                        ];
                    }
                    $grouped['uncategorized']['posts'][] = $post_id;
                }
            }
        }
        wp_reset_postdata();

        // sort groups by term name
        uksort($grouped, function($a, $b) use ($grouped) {
            $name_a = isset($grouped[$a]['term']->name) ? $grouped[$a]['term']->name : '';
            $name_b = isset($grouped[$b]['term']->name) ? $grouped[$b]['term']->name : '';
            return strcasecmp($name_a, $name_b);
        });

        return $grouped;
    }

    /**
     * Build location string for a post
     */
    public static function get_location_string($post_id) {
        $parts = [];

        $city_terms = get_the_terms($post_id, 'careercity');
        if (!empty($city_terms) && !is_wp_error($city_terms)) {
            $parts[] = $city_terms[0]->name;
        }

        $state_terms = get_the_terms($post_id, 'careerstate');
        if (!empty($state_terms) && !is_wp_error($state_terms)) {
            $parts[] = $state_terms[0]->name;
        }

        $country_terms = get_the_terms($post_id, 'careercountry');
        if (!empty($country_terms) && !is_wp_error($country_terms)) {
            $parts[] = $country_terms[0]->name;
        }

        return implode(', ', $parts);
    }

    /**
     * Render widget (HTML + CSS + JS)
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $section_title = !empty($settings['section_title']) ? $settings['section_title'] : 'Open roles';
        $section_subtitle = !empty($settings['section_subtitle']) ? $settings['section_subtitle'] : '';
        $enable_filter = !empty($settings['enable_filter']) && $settings['enable_filter'] === 'yes';
        $filter_taxonomy = !empty($settings['filter_taxonomy']) ? $settings['filter_taxonomy'] : 'careerteam';

        $widget_id = 'career_list_' . $this->get_id();
        $uid = esc_attr($widget_id);

        // team terms for filter (depending on selected filter taxonomy)
        $filter_terms = [];
        if ($enable_filter && taxonomy_exists($filter_taxonomy)) {
            $filter_terms = $this->get_terms_for_tax($filter_taxonomy);
        }

        // initial grouped list (no filter applied)
        $grouped_careers = self::get_careers_grouped(null, $filter_taxonomy);

        // create a nonce for ajax
        $ajax_nonce = wp_create_nonce('wpc_career_list_filter_nonce');
        ?>
        <div class="career-list-widget" id="<?php echo $uid; ?>" data-widget-id="<?php echo $uid; ?>" data-filter-taxonomy="<?php echo esc_attr($filter_taxonomy); ?>">

            <!-- Header -->
            <div class="career-header-section" style="display:flex;justify-content:space-between;align-items:flex-start;gap:20px;margin-bottom:28px;">
                <div class="career-header-content">
                    <h2 class="career-main-title" style="font-size:32px;margin:0 0 8px;"><?php echo esc_html($section_title); ?></h2>
                    <?php if (!empty($section_subtitle)): ?>
                        <p class="career-subtitle" style="color:#666;margin:0;"><?php echo esc_html($section_subtitle); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($enable_filter && !empty($filter_terms)): ?>
                <div class="career-filter-section" style="min-width:200px;">
                    <select class="career-team-filter" id="<?php echo $uid; ?>_filter" style="width:100%;padding:10px;border-radius:6px;border:1px solid #e6e6e6;background:#f8f8f8;">
                        <option value="all"><?php echo esc_html__('All teams', 'repindia'); ?></option>
                        <?php foreach ($filter_terms as $term): ?>
                            <option value="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
            </div>

            <!-- Table header -->
            <div class="career-table-header" style="display:grid;grid-template-columns: 1fr 2fr 1fr;gap:16px;padding:12px 0;border-bottom:1px solid #e6e6e6;color:#666;font-weight:600;font-size:13px;">
                <div class="career-header-col career-col-team">Team</div>
                <div class="career-header-col career-col-role">Role</div>
                <div class="career-header-col career-col-location">Location</div>
            </div>

            <!-- Content -->
            <div class="career-listing-content" id="<?php echo $uid; ?>_content" style="width:100%;">
                <?php $this->render_careers_list($grouped_careers); ?>
            </div>

        </div>

        <style>
        /* Scoped styles (only affect this widget by ID) */
        #<?php echo $uid; ?> .career-team-group { margin-top: 36px; }
        #<?php echo $uid; ?> .career-team-group:first-child { margin-top: 20px; }
        #<?php echo $uid; ?> .team-title { font-size:22px; font-weight:600; color:#0a3a5b; margin:0 0 12px; padding:0; }
        #<?php echo $uid; ?> .career-row { display:grid; grid-template-columns: 1fr 2fr 1fr; gap:16px; padding:14px 0; border-bottom:1px solid #eaeaea; align-items:center; }
        #<?php echo $uid; ?> .career-row .career-role a { color:#0a3a5b; text-decoration:none; font-size:14px; }
        #<?php echo $uid; ?> .career-row .career-role a:hover { text-decoration:underline; }
        #<?php echo $uid; ?> .career-location { color:#333; font-size:14px; text-align:right; }
        #<?php echo $uid; ?> .career-team-col { padding:0; }
        #<?php echo $uid; ?> .career-loading, #<?php echo $uid; ?> .career-empty { text-align:center; padding:36px 20px; color:#666; }

        @media (max-width: 768px) {
            #<?php echo $uid; ?> .career-table-header, #<?php echo $uid; ?> .career-row { grid-template-columns: 1fr; }
            #<?php echo $uid; ?> .career-location { text-align:left; margin-top:6px; }
        }
        </style>

        <script>
        (function(){
            var widgetId = '<?php echo esc_js($uid); ?>';
            var ajaxUrl = '<?php echo esc_js(admin_url('admin-ajax.php')); ?>';
            var nonce = '<?php echo esc_js($ajax_nonce); ?>';
            var widgetEl = document.getElementById(widgetId);
            if (!widgetEl) return;

            var filterSelect = widgetEl.querySelector('.career-team-filter');
            var contentEl = widgetEl.querySelector('#' + widgetId + '_content');

            function showLoading() {
                if (contentEl) contentEl.innerHTML = '<div class="career-loading">Loading...</div>';
            }

            function updateContent(html) {
                if (contentEl) contentEl.innerHTML = html;
            }

            function handleAjax(termSlug) {
                showLoading();
                var data = new FormData();
                data.append('action', 'wpc_career_list_filter');
                data.append('term_slug', termSlug);
                data.append('taxonomy', widgetEl.getAttribute('data-filter-taxonomy') || 'careerteam');
                data.append('nonce', nonce);

                fetch(ajaxUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: data
                }).then(function(response){
                    return response.json();
                }).then(function(json){
                    if (json && json.success && json.data) {
                        updateContent(json.data);
                    } else {
                        var msg = 'No careers found.';
                        if (json && json.data && json.data.message) msg = json.data.message;
                        updateContent('<div class="career-empty">' + msg + '</div>');
                    }
                }).catch(function(err){
                    console.error('Career filter AJAX error', err);
                    updateContent('<div class="career-empty">Error loading careers. Please try again later.</div>');
                });
            }

            if (filterSelect) {
                filterSelect.addEventListener('change', function(){
                    var val = this.value || 'all';
                    handleAjax(val);
                });
            }

            // Make sure widget works when Elementor loads it dynamically in editor/preview
            if (typeof elementorFrontend !== 'undefined') {
                elementorFrontend.hooks.addAction('frontend/element_ready/<?php echo $this->get_name(); ?>.default', function($scope, $){
                    // noop - filter already bound via DOM
                });
            }
        })();
        </script>
        <?php
    }

    /**
     * Render careers list HTML block (used both by initial render and AJAX)
     * $grouped_careers = array returned by get_careers_grouped()
     */
    private function render_careers_list($grouped_careers) {
        if (empty($grouped_careers)) {
            echo '<div class="career-empty">No careers found.</div>';
            return;
        }

        foreach ($grouped_careers as $team_slug => $group) {
            if (empty($group['posts'])) continue;

            $term = isset($group['term']) ? $group['term'] : (object)['name' => 'Uncategorized', 'slug' => 'uncategorized'];
            echo '<div class="career-team-group">';
            echo '<h3 class="team-title">' . esc_html($term->name) . '</h3>';

            foreach ($group['posts'] as $post_id) {
                $role = get_the_title($post_id);
                $location = self::get_location_string($post_id);
                $permalink = get_permalink($post_id);

                echo '<div class="career-row">';
                echo '<div class="career-team-col"></div>'; // left column (kept for alignment)
                echo '<div class="career-role">';
                if ($permalink) {
                    echo '<a href="' . esc_url($permalink) . '">' . esc_html($role) . '</a>';
                } else {
                    echo esc_html($role);
                }
                echo '</div>';
                echo '<div class="career-location">' . esc_html($location) . '</div>';
                echo '</div>';
            }

            echo '</div>';
        }
    }
}


/* --------------------------------------------------------------------------
   AJAX Handler (global scope) - single function for both logged in & nopriv
   -------------------------------------------------------------------------- */

if (!function_exists('wpc_career_list_filter_ajax')) {
    function wpc_career_list_filter_ajax() {
        // Check nonce (relaxed by default to avoid issues in editor preview)
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        // To enable strict nonce check, uncomment below:
        // if (empty($nonce) || !wp_verify_nonce($nonce, 'wpc_career_list_filter_nonce')) {
        //     wp_send_json_error(['message' => 'Invalid nonce']);
        //     wp_die();
        // }

        $term_slug = isset($_POST['term_slug']) ? sanitize_text_field($_POST['term_slug']) : null;
        $taxonomy = isset($_POST['taxonomy']) ? sanitize_text_field($_POST['taxonomy']) : 'careerteam';

        if ($term_slug === 'all' || $term_slug === '' || $term_slug === null) {
            $term_slug = null;
        }

        try {
            // Use the static method to fetch grouped careers (filter by slug)
            $grouped = \WPC\Widgets\Custom_Career_List::get_careers_grouped($term_slug, $taxonomy);

            ob_start();

            if (empty($grouped)) {
                echo '<div class="career-empty">No careers found.</div>';
            } else {
                // Render HTML same as render_careers_list()
                foreach ($grouped as $team_slug => $group) {
                    if (empty($group['posts'])) continue;

                    $term = isset($group['term']) ? $group['term'] : (object)['name' => 'Uncategorized', 'slug' => 'uncategorized'];
                    echo '<div class="career-team-group">';
                    echo '<h3 class="team-title">' . esc_html($term->name) . '</h3>';

                    foreach ($group['posts'] as $post_id) {
                        $role = get_the_title($post_id);
                        $location = \WPC\Widgets\Custom_Career_List::get_location_string($post_id);
                        $permalink = get_permalink($post_id);

                        echo '<div class="career-row">';
                        echo '<div class="career-team-col"></div>';
                        echo '<div class="career-role">';
                        if ($permalink) {
                            echo '<a href="' . esc_url($permalink) . '">' . esc_html($role) . '</a>';
                        } else {
                            echo esc_html($role);
                        }
                        echo '</div>';
                        echo '<div class="career-location">' . esc_html($location) . '</div>';
                        echo '</div>';
                    }

                    echo '</div>';
                }
            }

            $html = ob_get_clean();

            wp_send_json_success($html);
        } catch (\Exception $e) {
            wp_send_json_error(['message' => 'Error processing request', 'error' => $e->getMessage()]);
        } catch (\Error $e) {
            wp_send_json_error(['message' => 'Fatal error', 'error' => $e->getMessage()]);
        }

        wp_die();
    }

    add_action('wp_ajax_wpc_career_list_filter', 'wpc_career_list_filter_ajax');
    add_action('wp_ajax_nopriv_wpc_career_list_filter', 'wpc_career_list_filter_ajax');
}

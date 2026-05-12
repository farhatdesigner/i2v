<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;

class Custom_Career_Slider extends Widget_Base
{

    public function get_name()
    {
        return 'custom_career_slider';
    }

    public function get_title()
    {
        return 'Custom Career Slider';
    }

    public function get_icon()
    {
        return 'fa fa-sliders';
    }

    public function get_categories()
    {
        return ['general'];
    }

    public function get_script_depends()
    {
        return ['swiper']; // Elementor's default Swiper
    }

    public function get_style_depends()
    {
        return ['swiper', 'e-swiper'];
    }

    /**
     * Get taxonomies for a specific post type
     */
    private function get_taxonomies_for_post_type($post_type)
    {
        if (empty($post_type)) {
            return [];
        }

        $taxonomies = get_object_taxonomies($post_type, 'objects');
        $taxonomy_options = ['' => __('None', 'repindia')];

        foreach ($taxonomies as $taxonomy) {
            // Only include public taxonomies
            if ($taxonomy->public) {
                $taxonomy_options[$taxonomy->name] = $taxonomy->label;
            }
        }

        return $taxonomy_options;
    }

    /**
     * Get all taxonomies for all available post types
     * Used to populate initial options
     */
    private function get_all_taxonomies_for_cpts()
    {
        $cpt_list = get_post_types(
            [
                'public' => true,
                '_builtin' => false
            ],
            'objects'
        );

        $all_taxonomies = [];
        foreach ($cpt_list as $post_type) {
            $taxonomies = get_object_taxonomies($post_type->name, 'objects');
            foreach ($taxonomies as $taxonomy) {
                if ($taxonomy->public && !isset($all_taxonomies[$taxonomy->name])) {
                    $all_taxonomies[$taxonomy->name] = $taxonomy->label;
                }
            }
        }

        return $all_taxonomies;
    }

    protected function register_controls()
    {

        /* -------------------------------------------------------------
         * 1️⃣ SELECT CUSTOM POST TYPE (public, non-builtin)
         * ------------------------------------------------------------- */
        $cpt_list = get_post_types(
            [
                'public' => true,
                '_builtin' => false
            ],
            'objects'
        );

        $cpt_options = [];
        foreach ($cpt_list as $type) {
            $cpt_options[$type->name] = $type->label;
        }

        $this->start_controls_section(
            'section_query',
            ['label' => __('Content Source', 'repindia')]
        );

        $this->add_control(
            'selected_cpt',
            [
                'label' => __('Select Post Type', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'options' => $cpt_options,
                'default' => !empty($cpt_options) ? array_key_first($cpt_options) : '',
                'label_block' => true,
            ]
        );

        /* -------------------------------------------------------------
         * 2️⃣ SELECT TAXONOMY (dynamic: based on selected CPT)
         * Uses render_type = 'ui' to refresh when CPT changes
         * Shows all taxonomies from all available CPTs
         * ------------------------------------------------------------- */
        // Get all possible taxonomies for initial population
        $all_taxonomies = $this->get_all_taxonomies_for_cpts();
        $taxonomy_options = ['' => __('None', 'repindia')] + $all_taxonomies;

        $this->add_control(
            'selected_taxonomy',
            [
                'label' => __('Select Taxonomy (Optional)', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'options' => $taxonomy_options,
                'default' => '',
                'label_block' => true,
                'render_type' => 'ui',
                'condition' => [
                    'selected_cpt!' => '',
                ],
                'description' => __('Filter posts by taxonomy. Only taxonomies belonging to the selected post type will be applied.', 'repindia')
            ]
        );

        /* -------------------------------------------------------------
         * 3️⃣ SELECT TERM (optional - for specific term filtering)
         * Uses render_type = 'ui' to refresh when taxonomy changes
         * ------------------------------------------------------------- */
        $this->add_control(
            'selected_term',
            [
                'label' => __('Select Term (Optional)', 'repindia'),
                'type' => Controls_Manager::SELECT,
                'options' => ['' => __('All Terms', 'repindia')],
                'default' => '',
                'label_block' => true,
                'render_type' => 'ui',
                'condition' => [
                    'selected_taxonomy!' => '',
                ],
                'description' => __('Filter by specific term. Terms will update automatically when taxonomy changes.', 'repindia')
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get terms for a specific taxonomy
     */
    private function get_terms_for_taxonomy($taxonomy)
    {
        if (empty($taxonomy)) {
            return [];
        }

        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ]);

        if (is_wp_error($terms) || empty($terms)) {
            return [];
        }

        $term_options = ['' => __('All Terms', 'repindia')];
        foreach ($terms as $term) {
            $term_options[$term->slug] = $term->name;
        }

        return $term_options;
    }


    /* -------------------------------------------------------------
     * RENDER OUTPUT
     * ------------------------------------------------------------- */
    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $post_type = !empty($settings['selected_cpt']) ? $settings['selected_cpt'] : '';
        $taxonomy = !empty($settings['selected_taxonomy']) ? $settings['selected_taxonomy'] : '';
        $term = !empty($settings['selected_term']) ? $settings['selected_term'] : '';

        // Validate post type exists
        if (empty($post_type) || !post_type_exists($post_type)) {
            echo '<p>' . __('Please select a valid post type.', 'repindia') . '</p>';
            return;
        }

        /* -------------------------------------------------------------
         * Build WP Query
         * ------------------------------------------------------------- */
        $args = [
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ];

        // Apply tax_query only if both taxonomy AND term are selected
        // A tax_query without 'terms' will return no results
        if (!empty($taxonomy) && !empty($term) && taxonomy_exists($taxonomy)) {
            $post_type_taxonomies = get_object_taxonomies($post_type);

            // Only apply tax_query if taxonomy is associated with the selected post type
            if (in_array($taxonomy, $post_type_taxonomies)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $term,
                    ]
                ];
            }
        }

        $query = new \WP_Query($args);

        if (!$query->have_posts()) {
            echo '<p>' . __('No posts found.', 'repindia') . '</p>';
            wp_reset_postdata();
            return;
        }

        $uid = 'career_slider_' . $this->get_id();
        ?>

        <section class="career-slider-wrapper" id="<?php echo esc_attr($uid); ?>">
            <div class="custom-container">
                <div class="swiper mySwiper career-swiper">
                    <div class="swiper-wrapper">

                        <?php while ($query->have_posts()):
                            $query->the_post();
                            $post_id = get_the_ID();
                            $detail_url = get_permalink($post_id);

                            // Get the taxonomy term from the selected taxonomy for this post
                            $taxonomy_term = '';
                            if (!empty($taxonomy) && taxonomy_exists($taxonomy)) {
                                $terms = get_the_terms($post_id, $taxonomy);
                                if (!empty($terms) && !is_wp_error($terms)) {
                                    $taxonomy_term = $terms[0]->name; // Get first term
                                }
                            }

                            // Get location taxonomies: careercity, careerstate, careercountry
                            $career_city = '';
                            $career_state = '';
                            $career_country = '';

                            // Get careercity
                            if (taxonomy_exists('careercity')) {
                                $city_terms = get_the_terms($post_id, 'careercity');
                                if (!empty($city_terms) && !is_wp_error($city_terms)) {
                                    $career_city = $city_terms[0]->name;
                                }
                            }

                            // Get careerstate
                            if (taxonomy_exists('careerstate')) {
                                $state_terms = get_the_terms($post_id, 'careerstate');
                                if (!empty($state_terms) && !is_wp_error($state_terms)) {
                                    $career_state = $state_terms[0]->name;
                                }
                            }

                            // Get careercountry
                            if (taxonomy_exists('careercountry')) {
                                $country_terms = get_the_terms($post_id, 'careercountry');
                                if (!empty($country_terms) && !is_wp_error($country_terms)) {
                                    $career_country = $country_terms[0]->name;
                                }
                            }

                            // Build location string
                            $location_parts = array_filter([$career_city, $career_state, $career_country]);
                            $location_string = !empty($location_parts) ? '(' . implode(', ', $location_parts) . ')' : '';
                            ?>
                            <div class="swiper-slide">
                                <div class="career-card-item">
                                    <div class="career-card-header">
                                        <?php if (!empty($taxonomy_term)): ?>
                                            <span class="career-card-taxonomy"><?php echo esc_html($taxonomy_term); ?></span>
                                        <?php endif; ?>
                                        <?php if ($detail_url): ?>
                                            <a href="<?php echo esc_url($detail_url); ?>" class="career-card-link" target="_blank"
                                                rel="noopener noreferrer">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M8.55556 1.55556C8.126 1.55556 7.77778 1.20733 7.77778 0.777778C7.77778 0.348223 8.126 0 8.55556 0H13.2222C13.6518 0 14 0.348223 14 0.777778V5.44444C14 5.874 13.6518 6.22222 13.2222 6.22222C12.7927 6.22222 12.4444 5.874 12.4444 5.44444V2.6555L5.99442 9.10553C5.69068 9.40927 5.19821 9.40927 4.89447 9.10553C4.59073 8.80179 4.59073 8.30932 4.89447 8.00558L11.3445 1.55556H8.55556ZM2.33333 3.11111C1.90378 3.11111 1.55556 3.45933 1.55556 3.88889V11.6667C1.55556 12.0962 1.90378 12.4444 2.33333 12.4444H10.1111C10.5407 12.4444 10.8889 12.0962 10.8889 11.6667V8.55556C10.8889 8.126 11.2371 7.77778 11.6667 7.77778C12.0962 7.77778 12.4444 8.126 12.4444 8.55556V11.6667C12.4444 12.9553 11.3998 14 10.1111 14H2.33333C1.04467 14 0 12.9553 0 11.6667V3.88889C0 2.60022 1.04467 1.55556 2.33333 1.55556H5.44444C5.874 1.55556 6.22222 1.90378 6.22222 2.33333C6.22222 2.76289 5.874 3.11111 5.44444 3.11111H2.33333Z"
                                                        fill="#5F6F94" />
                                                </svg>

                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="career-card-content">
                                        <h3 class="career-card-title">
                                            <?php the_title(); ?>
                                            <?php if (!empty($location_string)): ?>
                                                <span class="career-card-location"><?php echo esc_html($location_string); ?></span>
                                            <?php endif; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>

                    </div>

                    <!-- Navigation -->
                    <div class="swiper-button-next swiper-horizontalmobile-next">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-white.svg" alt="Next">
                    </div>
                    <div class="swiper-button-prev swiper-horizontalmobile-prev">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-white.svg" alt="Prev">
                    </div>
                </div>
            </div>
        </section>

        <style>
            #<?php echo esc_attr($uid); ?> .career-slider-wrapper {
                position: relative;
            }

            #<?php echo esc_attr($uid); ?> .custom-container {
                position: relative;
                width: 100%;
            }

            #<?php echo esc_attr($uid); ?> .career-swiper {
                width: 100%;
                overflow: hidden;
                position: relative;
                overflow: visible;
            }

            /* Career Card Styling */
            #<?php echo esc_attr($uid); ?> .career-card-item {
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 4px 4px 0 rgba(138, 149, 158, 0.10);
                padding: 16px 20px;
                height: 100%;
                display: flex;
                gap: 8px;
                flex-direction: column;
                transition: box-shadow 0.3s ease;
            }

            #<?php echo esc_attr($uid); ?> .career-card-item:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            }

            .js-dark #<?php echo esc_attr($uid); ?> .career-card-item {
                background: #262A30;
            }

            #<?php echo esc_attr($uid); ?> .career-card-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 0;
            }

            #<?php echo esc_attr($uid); ?> .career-card-taxonomy {
                font-size: 18px;
                color: #5F6F94;
                font-weight: 500;
                line-height: 26px;
            }

            #<?php echo esc_attr($uid); ?> .career-card-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #666;
                text-decoration: none;
                transition: color 0.3s ease;
                flex-shrink: 0;
            }

            #<?php echo esc_attr($uid); ?> .career-card-link:hover {
                color: #000;
            }

            #<?php echo esc_attr($uid); ?> .career-card-link svg {
                width: 18px;
                height: 18px;
                fill: #5F6F94;
            }

            #<?php echo esc_attr($uid); ?> .career-card-content {
                flex: 1;
            }

            #<?php echo esc_attr($uid); ?> .career-card-title {
                font-size: 20px;
                font-weight: 600;
                line-height: 26px;
                margin: 0;
                color: #06283D;
            }

            #<?php echo esc_attr($uid); ?> .career-card-location {
                display: inline;
            }

            #<?php echo esc_attr($uid); ?> .swiper-slide {
                height: auto;
            }

            /* Ensure Swiper wrapper displays slides properly */
            #<?php echo esc_attr($uid); ?> .swiper-wrapper {
                display: flex;
                align-items: stretch;
            }

            /* Hide default Swiper arrow icons - using custom arrow images instead */
            #<?php echo esc_attr($uid); ?> .career-swiper .swiper-button-prev:after,
            #<?php echo esc_attr($uid); ?> .career-swiper .swiper-button-next:after,
            #<?php echo esc_attr($uid); ?> .career-swiper .swiper-rtl .swiper-button-prev:after,
            #<?php echo esc_attr($uid); ?> .career-swiper .swiper-rtl .swiper-button-next:after {
                display: none !important;
                content: none !important;
            }

            /* Hide navigation buttons */
            #<?php echo esc_attr($uid); ?> .career-swiper .swiper-horizontalmobile-next,
            #<?php echo esc_attr($uid); ?> .career-swiper .swiper-horizontalmobile-prev {
                display: none !important;
            }

            .career-swiper .swiper-slide {
                width: 375px;
                margin-right: 20px;
                border: 2px solid transparent;
            }

            .career-swiper .swiper-slide:hover {
                border: 2px solid #0099ed;
                border-radius: 12px;
            }

            /* Mobile-specific styles for touch/swipe (below 767px) */
            @media (max-width: 767px) {
                #<?php echo esc_attr($uid); ?> .career-swiper {
                    overflow: hidden !important;
                    touch-action: pan-x;
                    -webkit-overflow-scrolling: touch;
                }

                #<?php echo esc_attr($uid); ?> .career-swiper .swiper-wrapper {
                    touch-action: pan-x;
                    -webkit-transform: translate3d(0, 0, 0);
                }

                #<?php echo esc_attr($uid); ?> .career-swiper .swiper-slide {
                    touch-action: pan-x;
                    -webkit-user-select: none;
                    user-select: none;
                    -webkit-tap-highlight-color: transparent;
                }
            }
        </style>

        <script>
            (function () {
                var widgetId = '<?php echo esc_js($uid); ?>';
                var widgetEl = null;

                // Function to initialize Swiper
                function initSwiper() {
                    if (!widgetEl) {
                        widgetEl = document.getElementById(widgetId);
                    }

                    if (!widgetEl) return;

                    var slider = widgetEl.querySelector(".career-swiper");
                    if (!slider) return;

                    // Check if already initialized
                    if (slider.swiper) return;

                    var nextBtn = widgetEl.querySelector(".swiper-horizontalmobile-next");
                    var prevBtn = widgetEl.querySelector(".swiper-horizontalmobile-prev");

                    if (!nextBtn || !prevBtn) return;

                    // Function to check if Swiper is available
                    function readyForSwiper(cb) {
                        if (typeof Swiper !== 'undefined') {
                            cb();
                        } else if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                            cb();
                        } else {
                            setTimeout(function () {
                                readyForSwiper(cb);
                            }, 60);
                        }
                    }

                    readyForSwiper(function () {
                        var swiperConfig = {
                            navigation: {
                                nextEl: nextBtn,
                                prevEl: prevBtn,
                            },
                            autoplay: {
                                delay: 2000,
                                disableOnInteraction: false,
                                pauseOnMouseEnter: true,
                            },
                            loop: true, // Enable infinite loop
                            centeredSlides: false, // Disable center item feature
                            spaceBetween: 20,
                            // Default for mobile - 1 slide
                            slidesPerView: 1,
                            slidesPerGroup: 1,
                            // Enable touch/swipe by default (will be controlled by breakpoints)
                            allowTouchMove: true,
                            touchEventsTarget: 'container',
                            simulateTouch: true,
                            grabCursor: true,
                            breakpoints: {
                                // Mobile first approach - breakpoints are min-width
                                // Below 768px: touch enabled, 1 slide per view, 1 slide per group
                                0: {
                                    slidesPerView: 1,
                                    slidesPerGroup: 1,
                                    spaceBetween: 20,
                                    allowTouchMove: true,
                                    touchEventsTarget: 'container',
                                    simulateTouch: true,
                                },
                                // 768px and above: 3 slides
                                768: {
                                    slidesPerView: 3,
                                    slidesPerGroup: 1,
                                    spaceBetween: 20,
                                    allowTouchMove: true,
                                },
                                // 1024px and above: 4 slides (desktop)
                                1024: {
                                    slidesPerView: 4,
                                    slidesPerGroup: 1,
                                    spaceBetween: 20,
                                    allowTouchMove: true,
                                },
                                // 1200px and above: still 4 slides
                                1200: {
                                    slidesPerView: 3,
                                    slidesPerGroup: 1,
                                    spaceBetween: 20,
                                    allowTouchMove: true,
                                },
                                1400: {
                                    slidesPerView: "auto",
                                    slidesPerGroup: 1,
                                    spaceBetween: 20,
                                    allowTouchMove: true,
                                }
                            }
                        };

                        try {
                            // Use Elementor's Swiper wrapper if available, otherwise use global Swiper
                            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                                var swiperInstance = elementorFrontend.utils.swiper(slider, swiperConfig);
                                if (swiperInstance && swiperInstance.swiper) {
                                    swiperInstance.swiper.update();
                                }
                            } else if (typeof Swiper !== 'undefined') {
                                var swiperInstance = new Swiper(slider, swiperConfig);
                                if (swiperInstance && typeof swiperInstance.update === 'function') {
                                    setTimeout(function () {
                                        swiperInstance.update();
                                    }, 100);
                                }
                            } else {
                                console.warn('Swiper not found for purpose slider');
                            }
                        } catch (e) {
                            console.error('Error initializing Swiper:', e);
                        }
                    });
                }

                // Initialize on DOM ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initSwiper);
                } else {
                    initSwiper();
                }

                // Elementor hook for frontend/editor
                if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                    elementorFrontend.hooks.addAction('frontend/element_ready/cardscustom_purpose_slider.default', function ($scope) {
                        // $scope is a jQuery object, get the DOM element
                        widgetEl = ($scope && $scope.length) ? $scope[0] : document.getElementById(widgetId);
                        setTimeout(initSwiper, 100);
                    });
                }

                // Also listen for Elementor init event (using jQuery if available)
                if (typeof jQuery !== 'undefined') {
                    jQuery(window).on('elementor/frontend/init', function () {
                        setTimeout(initSwiper, 200);
                    });
                }

                // Fallback: try again after a short delay
                setTimeout(initSwiper, 500);
            })();
        </script>

        <?php
        wp_reset_postdata();
    }
}

<?php
$repindia_theme = wp_get_theme();
define('REPINDIA_THEME_VERSION', (WP_DEBUG) ? time() : $repindia_theme->get('Version'));
if (! isset($content_width)) {
	$content_width = 1200;
}
add_action('after_setup_theme', 'repindia_theme_setup');
if (! function_exists('repindia_theme_setup')) {
	function repindia_theme_setup()
	{
		if (! get_post_meta(get_the_ID(), 'disable_tags', true)) {
			the_tags('<div class="tags media-body">', ' ', '</div>');
		}
		add_theme_support('post-thumbnails');
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('repindia');
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		));

		/*
    	 * Make theme available for translation.
    	 * Translations can be filed in the /languages/ directory.
    	 * If you're building a theme based on repindia, use a find and replace
    	 * to change 'repindia' to the name of your theme in all the template files.
    	 */
		load_theme_textdomain('repindia', get_template_directory() . '/languages');
		/*
		  * Enable support for custome header and background for the images.
		  */
		add_theme_support('custom-header');
		add_theme_support('custom-background');
		// This theme styles the visual editor to resemble the theme style.


		add_editor_style('assets/css/editor-style.css');
		register_nav_menus(
			array(
				'repindia-primary'   	    => esc_html__('Primary', 'repindia'),
				'header-toggle-menu'   => esc_html__('Header Toggle Menu', 'repindia'),
				'footer-product-menu'   	=> esc_html__('Footer Product Menu', 'repindia'),
				'footer-industry-menu'   	=> esc_html__('Footer Industry Menu', 'repindia'),
				'footer-company-menu'   	=> esc_html__('Footer Company Menu', 'repindia'),
				'footer-resource-menu'   => esc_html__('Footer Resource Menu', 'repindia'),
				'footer-legal-menu'   => esc_html__('Footer Legal Menu', 'repindia'),
				'search-menu'   => esc_html__('Search Menu', 'repindia'),
			)
		);
	}
}
function repindia_read_more_link()
{
	return '<a href="' . get_permalink() . '" class="sim-button button6 yellowbtn"><span>' . esc_html__('Read more', 'repindia') . '</span></a>';
}
add_filter('the_content_more_link', 'repindia_read_more_link');
//Default Home on breadcumb 
add_filter('bcn_breadcrumb_title', function ($title, $type, $id) {
	if ($type[0] === 'home') {
		$title = get_the_title(get_option('page_on_front'));
	}
	return $title;
}, 42, 3);
/************************************************************************
 * Set Inner header background image/color.
 *************************************************************************/
function repindia_backgroundstyle($key)
{
	global $repindia_option;
	$inner_header_style = array();
	if (isset($repindia_option['' . esc_attr($key) . '']) && !empty($repindia_option['' . esc_attr($key) . '']['background-image'])) {
		$inner_header_style[] = 'background-image: url(' . $repindia_option['' . esc_attr($key) . '']['background-image'] . ');';
	}
	if (isset($repindia_option['' . esc_attr($key) . '']) && !empty($repindia_option['' . esc_attr($key) . '']['background-color'])) {
		$inner_header_style[] = 'background-color: ' . $repindia_option['' . esc_attr($key) . '']['background-color'] . ';';
	}
	if (isset($repindia_option['' . esc_attr($key) . '']) && !empty($repindia_option['' . esc_attr($key) . '']['background-repeat'])) {
		$inner_header_style[] = 'background-repeat: ' . $repindia_option['' . esc_attr($key) . '']['background-repeat'] . ';';
	}
	if (isset($repindia_option['' . esc_attr($key) . '']) && !empty($repindia_option['' . esc_attr($key) . '']['background-size'])) {
		$inner_header_style[] = 'background-size: ' . $repindia_option['' . esc_attr($key) . '']['background-size'] . ';';
	}
	if (isset($repindia_option['' . esc_attr($key) . '']) && !empty($repindia_option['' . esc_attr($key) . '']['background-position'])) {
		$inner_header_style[] = 'background-position: ' . $repindia_option['' . esc_attr($key) . '']['background-position'] . ';';
	}
	if (isset($repindia_option['' . esc_attr($key) . '']) && !empty($repindia_option['' . esc_attr($key) . '']['background-attachment'])) {
		$inner_header_style[] = 'background-attachment: ' . $repindia_option['' . esc_attr($key) . '']['background-attachment'] . ';';
	}
	return $inner_header_style;
}

add_action('wp_enqueue_scripts', 'repindia_load_theme_scripts_and_styles');
if (! function_exists('repindia_load_theme_scripts_and_styles')) {
	function repindia_load_theme_scripts_and_styles()
	{
		global $repindia_option;
		if (! is_admin()) {
			wp_enqueue_style('typekit', 'https://use.typekit.net/cri5gsd.css', null, REPINDIA_THEME_VERSION, 'all');
			wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', null, REPINDIA_THEME_VERSION, 'all');
			// Use Swiper 4.x local files
			wp_enqueue_style('swiper-min', get_template_directory_uri() . '/assets/css/swiper-4.5.1.min.css', null, '4.5.1', 'all');
			wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/custom_style.css', null, REPINDIA_THEME_VERSION, 'all');
			wp_enqueue_style('feedback-custom', get_template_directory_uri() . '/assets/css/feedback_custom.css', null, REPINDIA_THEME_VERSION, 'all');
			wp_enqueue_style('repindia-style', get_stylesheet_uri(), null, REPINDIA_THEME_VERSION, 'all');
			wp_enqueue_style('form-css', get_template_directory_uri() . '/assets/css/form_css.css', null, REPINDIA_THEME_VERSION, 'all');
			wp_enqueue_style('dark-theme', get_template_directory_uri() . '/assets/css/dark_theme.css', null, REPINDIA_THEME_VERSION, 'all');
			wp_enqueue_style('repindia-responsive', get_template_directory_uri() . '/assets/css/responsive.css', null, REPINDIA_THEME_VERSION, 'all');
			wp_enqueue_style('repindia-search', get_template_directory_uri() . '/assets/css/search.css', null, REPINDIA_THEME_VERSION, 'all');

		/* Register Scripts */
		// Deregister WordPress default jQuery
		wp_deregister_script('jquery');
		// Register custom jQuery
		wp_register_script('jquery', get_template_directory_uri() . '/assets/js/jquery-3.7.1.min.js', array(), '3.7.1', true);
		wp_enqueue_script('jquery');
		
		wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), REPINDIA_THEME_VERSION, true);
		// Use Swiper 4.x local files
		wp_enqueue_script('swiper-min', get_template_directory_uri() . '/assets/js/swiper-4.5.1.min.js', array('jquery'), '4.5.1', true);
		wp_enqueue_script('gsap-min', get_template_directory_uri() . '/assets/js/gsap.min.js', array('jquery'), REPINDIA_THEME_VERSION, true);
		wp_enqueue_script('scrolltrigger-min', get_template_directory_uri() . '/assets/js/scrolltrigger.js', array('gsap-min'), REPINDIA_THEME_VERSION, true);
		wp_enqueue_script('lenis-min', get_template_directory_uri() . '/assets/js/lenis.min.js', array(), REPINDIA_THEME_VERSION, true);
		wp_enqueue_script('repindia-global', get_template_directory_uri() . '/assets/js/global.js', array('jquery', 'swiper-min', 'gsap-min', 'scrolltrigger-min', 'lenis-min'), REPINDIA_THEME_VERSION, true);
		wp_enqueue_script('repindia-custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery', 'swiper-min', 'gsap-min', 'scrolltrigger-min', 'lenis-min'), REPINDIA_THEME_VERSION, true);
		
		// Enqueue form validation script
		wp_enqueue_script('repindia-form-validation', get_template_directory_uri() . '/assets/js/formvalidation.js', array('jquery'), REPINDIA_THEME_VERSION, true);
		
		// Enqueue search script
		wp_enqueue_script('repindia-search', get_template_directory_uri() . '/assets/js/search.js', array(), REPINDIA_THEME_VERSION, true);
		wp_localize_script('repindia-search', 'repindiaSearch', array(
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('repindia_search_nonce'),
			'homeUrl' => esc_url(home_url('/'))
		));
		
		// Save Swiper 4.5.1 reference before Elementor's Swiper 8 loads (only on homepage)
		if (is_front_page()) {
			wp_add_inline_script('swiper-min', '
				// Save Swiper 4.5.1 reference before Elementor loads Swiper 8
				window.SwiperV4 = window.Swiper;
			', 'after');
		}
		
			/* Enqueue Scripts */
			if (is_singular() && comments_open() && get_option('thread_comments')) {
				wp_enqueue_script('comment-reply');
			}
		}
	}
}
if (! function_exists('repindia_excerpt_more')) {
	function repindia_excerpt_more($more)
	{
		return '';
	}
}
add_filter('excerpt_more', 'repindia_excerpt_more');
define('REPINDIA_INC_PATH', get_template_directory() . '/inc');
require_once(REPINDIA_INC_PATH . '/theme-essential.php');
require_once(REPINDIA_INC_PATH . '/elementor-addons/custom-elementor.php');
function repindia_activate()
{
	global $pagenow;
	if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
		wp_redirect(admin_url('themes.php?page=repindia-theme-activate'));
		exit;
	}
}
add_action('after_setup_theme', 'repindia_activate', 11);

add_filter('nav_menu_css_class', 'repindia_add_active_class', 10, 4);
function repindia_add_active_class($classes, $item, $args, $depth)
{
	if ($item->menu_item_parent == 0 && in_array('current-menu-item', $classes)) {
		$classes[] = 'active parent';
	}
	return $classes;
}
function repindia_theme_style()
{
	wp_enqueue_style('repindia-activate', get_template_directory_uri() . '/assets/css/theme-style.css', null, REPINDIA_THEME_VERSION, 'all');
}
add_action('admin_enqueue_scripts', 'repindia_theme_style');
if (! function_exists('wp_body_open')) {
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
}
// Allow svg files upload
function allow_svg_upload($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

//Allow Webp Files
function webp_upload_mimes($existing_mimes)
{
	$existing_mimes['webp'] = 'image/webp+xml';
	return $existing_mimes;
}
add_filter('upload_mimes', 'webp_upload_mimes');

// Add shortcode to retrieve URL parameters
function get_url_parameter($atts)
{
	$atts = shortcode_atts(array(
		'formpdf' => '',
	), $atts, 'get_url_parameter');

	if (isset($_GET[$atts['formpdf']])) {
		return $_GET[$atts['formpdf']];
	}
	return '';
}
add_shortcode('get_url_parameter', 'get_url_parameter');

if (! function_exists('apl_get_categories')) {
	function apl_get_categories($taxonomy)
	{
		$terms = get_terms(array(
			'taxonomy' => $taxonomy,
			'hide_empty' => true,
		));
		$options = array();
		if (!empty($terms) && !is_wp_error($terms)) {
			foreach ($terms as $term) {
				$options[$term->slug] = $term->name;
			}
		}
		return $options;
	}
}

//breadcrumb for product pages
add_filter( 'wpseo_breadcrumb_links', 'add_products_cpt_breadcrumb' );
function add_products_cpt_breadcrumb( $links ) {
    if ( is_singular( 'products' ) ) {
        // Add "Products" after Home
        $breadcrumb = array(
            'url'  => home_url( '/i2vs-products/' ),
            'text' => 'i2VS products',
        );
        array_splice( $links, 1, 0, array( $breadcrumb ) );
    }

    return $links;
}

add_filter( 'wpseo_breadcrumb_separator', function() {
    return '<img class="yoast-sep-icon" src="' . esc_url( home_url( '/wp-content/uploads/2025/11/chevron-right.svg' ) ) . '" alt=">">';
});

/**
 * Safe Elementor Optimization – Only runs when Elementor is active
 */
add_action('plugins_loaded', function () {
    if ( ! did_action('elementor/loaded') ) {
        return; // Elementor not active → stop
    }
    /* --------------------------------------------------
     * 1. Disable Elementor Cloud Library (SAFE)
     * -------------------------------------------------- */
    add_filter( 'elementor_pro/utils/is_cloud_enabled', '__return_false' );
    add_filter( 'elementor/app/is_library_enabled', '__return_false' );
    /* --------------------------------------------------
     * 2. Disable external remote API calls
     *    (Does NOT affect templates / content)
     * -------------------------------------------------- */
    add_filter( 'elementor/api/is_allowed', '__return_false' );
    add_filter( 'elementor/templates/allow_remote_sources', '__return_false' );
    /* --------------------------------------------------
     * 3. Disable only unstable Elementor Experiments
     *    (Keeps all core features + stable experiments)
     * -------------------------------------------------- */
    add_filter( 'elementor_experiments_allowed', function() {
        return [
            'e_optimized_dom_output' => 'stable',
            'e_font_icon_svg'        => 'stable',
            'e_container'            => 'stable',
            // All other experiments disabled safely
        ];
    });
    /* --------------------------------------------------
     * 4. Auto-cleanup old revisions (ONLY revisions)
     *    (Never deletes posts/pages or Elementor content)
     * -------------------------------------------------- */
    add_action( 'init', function() {
        global $wpdb;

        // Clean revisions older than 30 days
        $wpdb->query(
            "DELETE FROM $wpdb->posts 
             WHERE post_type = 'revision'
             AND post_date < DATE_SUB(NOW(), INTERVAL 30 DAY)"
        );
    });

});

// Disable automatic updates for plugins and themes
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );

//Newsroom features for auto time calculator and page scroll percentage
/**
 * Calculate reading time from Elementor content
 */
function mytheme_get_blog_reading_time() {

    // Only Blog Detail Page
    if ( ! is_singular( 'newsroom' ) ) {
        return '';
    }

    $post_id = get_the_ID();

    // Elementor check
    if (
        ! class_exists( '\Elementor\Plugin' ) ||
        ! \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id )
    ) {
        return '';
    }

    $raw_data = get_post_meta( $post_id, '_elementor_data', true );
    if ( empty( $raw_data ) ) {
        return '';
    }

    $data = json_decode( $raw_data, true );
    if ( ! is_array( $data ) ) {
        return '';
    }

    $text = '';

    // Text fields that typically contain readable content
    $text_fields = array(
        'editor', 'text', 'title', 'description', 'content', 'html', 
        'heading', 'subheading', 'caption', 'label', 'placeholder',
        'button_text', 'link_text', 'tab_title', 'accordion_title',
        'accordion_content', 'icon_list_text', 'text_editor'
    );

    $walker = function ( $elements ) use ( &$walker, &$text, $text_fields ) {
        foreach ( $elements as $el ) {
            if ( ! empty( $el['settings'] ) && is_array( $el['settings'] ) ) {
                foreach ( $el['settings'] as $key => $value ) {
                    // Only process text-related settings
                    if ( ! is_string( $value ) || empty( trim( $value ) ) ) {
                        continue;
                    }

                    // Skip if key suggests it's not readable text (IDs, URLs, classes, etc.)
                    $key_lower = strtolower( $key );
                    if ( 
                        strpos( $key_lower, 'id' ) !== false ||
                        strpos( $key_lower, 'url' ) !== false ||
                        strpos( $key_lower, 'link' ) !== false ||
                        strpos( $key_lower, 'class' ) !== false ||
                        strpos( $key_lower, 'css' ) !== false ||
                        strpos( $key_lower, 'image' ) !== false ||
                        strpos( $key_lower, 'icon' ) !== false ||
                        strpos( $key_lower, 'color' ) !== false ||
                        strpos( $key_lower, 'size' ) !== false ||
                        strpos( $key_lower, 'margin' ) !== false ||
                        strpos( $key_lower, 'padding' ) !== false ||
                        strpos( $key_lower, 'border' ) !== false ||
                        preg_match( '/^#[0-9a-f]{3,6}$/i', trim( $value ) ) || // Hex colors
                        filter_var( trim( $value ), FILTER_VALIDATE_URL ) || // URLs
                        preg_match( '/^[a-z0-9_-]+$/i', trim( $value ) ) && strlen( trim( $value ) ) < 20 // Likely IDs/classes
                    ) {
                        continue;
                    }

                    // Prefer fields that are known to contain text content
                    $is_text_field = false;
                    foreach ( $text_fields as $field ) {
                        if ( strpos( $key_lower, $field ) !== false ) {
                            $is_text_field = true;
                            break;
                        }
                    }

                    // Extract text, strip HTML tags and decode entities
                    $clean_text = wp_strip_all_tags( html_entity_decode( $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
                    $clean_text = trim( $clean_text );

                    // Only add if it looks like readable text (has spaces or is reasonably long)
                    if ( ! empty( $clean_text ) && ( strpos( $clean_text, ' ' ) !== false || strlen( $clean_text ) > 10 ) ) {
                        $text .= ' ' . $clean_text;
                    }
                }
            }

            if ( ! empty( $el['elements'] ) && is_array( $el['elements'] ) ) {
                $walker( $el['elements'] );
            }
        }
    };

    $walker( $data );

    // Clean up text: remove extra spaces, normalize
    $text = preg_replace( '/\s+/', ' ', trim( $text ) );

    // Calculate word count (more accurate for multilingual)
    $word_count = str_word_count( $text, 0, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789àáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞŸ' );
    
    if ( $word_count < 1 ) {
        return '';
    }

    $minutes = max( 1, ceil( $word_count / 200 ) );

    return sprintf(
        esc_html__( '%d min read', 'repindia' ),
        $minutes
    );
}

/**
 * Shortcode for Elementor
 */
function mytheme_blog_reading_time_shortcode() {
    return mytheme_get_blog_reading_time();
}
add_shortcode( 'blog_reading_time', 'mytheme_blog_reading_time_shortcode' );

function mytheme_blog_scroll_assets() {

    if ( ! is_singular( 'newsroom' ) ) {
        return;
    }

    wp_enqueue_script(
        'blog-scroll-progress',
        get_template_directory_uri() . '/assets/js/blog-scroll.js',
        [],
        '1.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'mytheme_blog_scroll_assets' );

/**
 * Track popular searches
 * Increments search count when a search is performed
 */
function repindia_track_search() {
	if (!is_search()) {
		return;
	}
	
	$search_query = get_search_query();
	if (empty($search_query)) {
		return;
	}
	
	$search_term = sanitize_text_field($search_query);
	if (empty($search_term) || strlen($search_term) < 2) {
		return; // Skip very short search terms
	}
	
	// Get current popular searches
	$popular_searches = get_transient('repindia_popular_searches');
	if (!is_array($popular_searches)) {
		$popular_searches = array();
	}
	
	// Increment count for this search term (case-insensitive)
	$term_lower = strtolower(trim($search_term));
	if (empty($term_lower)) {
		return;
	}
	
	if (isset($popular_searches[$term_lower])) {
		$popular_searches[$term_lower]['count']++;
		$popular_searches[$term_lower]['term'] = $search_term; // Keep original casing
	} else {
		$popular_searches[$term_lower] = array(
			'term' => $search_term,
			'count' => 1
		);
	}
	
	// Store for 7 days
	set_transient('repindia_popular_searches', $popular_searches, 7 * DAY_IN_SECONDS);
}
add_action('template_redirect', 'repindia_track_search');

/**
 * Get popular searches (sorted by count)
 * Returns top N searches
 */
function repindia_get_popular_searches($limit = 5) {
	$popular_searches = get_transient('repindia_popular_searches');
	
	if (!is_array($popular_searches) || empty($popular_searches)) {
		return array();
	}
	
	// Sort by count (descending)
	usort($popular_searches, function($a, $b) {
		return $b['count'] - $a['count'];
	});
	
	// Return top N (limit to 5)
	$limit = min($limit, 5);
	$popular_searches = array_slice($popular_searches, 0, $limit);
	
	// Return just the terms
	return array_map(function($item) {
		return $item['term'];
	}, $popular_searches);
}

/**
 * AJAX handler for getting popular searches
 */
function repindia_ajax_get_popular_searches() {
	// Verify nonce
	if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'repindia_search_nonce')) {
		wp_send_json_error(array('message' => 'Invalid nonce'));
		return;
	}
	
	$searches = repindia_get_popular_searches(5);
	
	// Ensure we return an array (even if empty)
	if (!is_array($searches)) {
		$searches = array();
	}
	
	wp_send_json_success($searches);
}
add_action('wp_ajax_repindia_get_popular_searches', 'repindia_ajax_get_popular_searches');
add_action('wp_ajax_nopriv_repindia_get_popular_searches', 'repindia_ajax_get_popular_searches');

// Separate Slugs per CPT
add_filter('wp_unique_post_slug', function ($slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug) {
    global $wpdb;
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT ID 
         FROM {$wpdb->posts} 
         WHERE post_name = %s 
         AND post_type = %s 
         AND ID != %d 
         LIMIT 1",
        $slug,
        $post_type,
        $post_ID
    ));

    // If no conflict inside SAME CPT, allow original slug
    if (!$exists) {
        return $original_slug;
    }
    return $slug; // fallback to WordPress default behavior

}, 10, 6);


// Separate Slugs per Taxonomies
add_filter('wp_unique_term_slug', function ($slug, $term) {
    global $wpdb;
    $taxonomy = $term->taxonomy;
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT t.term_id 
         FROM {$wpdb->terms} t
         JOIN {$wpdb->term_taxonomy} tt 
            ON t.term_id = tt.term_id
         WHERE t.slug = %s
         AND tt.taxonomy = %s
         AND t.term_id != %d
         LIMIT 1",
        $slug,
        $taxonomy,
        $term->term_id
    ));

    if (!$exists) {
        return $term->slug;
    }

    return $slug;

}, 10, 2);

//Global translator helper function
if ( ! function_exists( 'wpml_t' ) ) {
    function wpml_t( $text, $context = 'Theme', $name = '' ) {
        if ( empty( $name ) ) {
            $name = md5( $text );
        }
        do_action(
            'wpml_register_single_string',
            $context,
            $name,
            $text
        );
        return apply_filters(
            'wpml_translate_single_string',
            $text,
            $context,
            $name
        );
    }
}

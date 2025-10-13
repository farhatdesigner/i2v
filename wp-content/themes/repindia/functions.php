<?php
$repindia_theme = wp_get_theme();
define( 'REPINDIA_THEME_VERSION', ( WP_DEBUG ) ? time() : $repindia_theme->get( 'Version' ) );
if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}
add_action( 'after_setup_theme', 'repindia_theme_setup' );
if ( ! function_exists( 'repindia_theme_setup' ) ) {
	function repindia_theme_setup() {
		if ( ! get_post_meta( get_the_ID(), 'disable_tags', true ) ) {
		the_tags( '<div class="tags media-body">', ' ', '</div>' );
		}
		// add_image_size('repindia-team-269X361',269, 361, array( 'left', 'top', 'right', 'bottom' ) );
		// add_filter( 'woocommerce_get_image_size_thumbnail', function( $size ) {
		// 	return array(
		// 		'width'  => 539,'height' => 450,'crop'   => 1,
		// 	);
		// } );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'repindia' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		
		/*
    	 * Make theme available for translation.
    	 * Translations can be filed in the /languages/ directory.
    	 * If you're building a theme based on repindia, use a find and replace
    	 * to change 'repindia' to the name of your theme in all the template files.
    	 */
    	load_theme_textdomain( 'repindia', get_template_directory() . '/languages' );
		/*
		  * Enable support for custome header and background for the images.
		  */
		 add_theme_support( 'custom-header' );
		 add_theme_support( 'custom-background' ) ;
		 // This theme styles the visual editor to resemble the theme style.
		 
		
		add_editor_style( 'assets/css/editor-style.css' );
		register_nav_menus(
			array(
				'repindia-primary'   	    => esc_html__( 'Primary','repindia' ),
				'header-sidebar-menu'   => esc_html__( 'Header Sidebar Menu','repindia' ),
				'footer-main-menu'   	=> esc_html__( 'Footer Main Menu','repindia' ),
				'footer-brand-menu'   	=> esc_html__( 'Footer Brand Menu','repindia' ),
				'footer-news-menu'   	=> esc_html__( 'Footer News Menu','repindia' ),
				'footer-service-menu'   => esc_html__( 'Footer Service Menu','repindia' ),
				'footer-gallery-menu'   => esc_html__( 'Footer Gallery Menu','repindia' ),
				'footer-resource-menu'  => esc_html__( 'Footer Resource Menu','repindia' ),
				'footer-sitemap-menu'   => esc_html__( 'Footer Sitemap Menu','repindia' )
			)
		);
		
	}
}
function repindia_read_more_link() {
    return '<a href="' . get_permalink() . '" class="sim-button button6 yellowbtn"><span>'.esc_html__('Read more','repindia').'</span></a>';
}
add_filter( 'the_content_more_link', 'repindia_read_more_link' );
//Default Home on breadcumb 
add_filter('bcn_breadcrumb_title', function($title, $type, $id) {
 if ($type[0] === 'home') {
  $title = get_the_title(get_option('page_on_front'));
 }
 return $title;
}, 42, 3);
/************************************************************************
* Set Inner header background image/color.
*************************************************************************/
function repindia_backgroundstyle( $key ){
	global $repindia_option;
	$inner_header_style = array();
	if ( isset($repindia_option[''.esc_attr($key).'']) && !empty($repindia_option[''.esc_attr($key).'']['background-image']))
	{
		$inner_header_style[] = 'background-image: url('.$repindia_option[''.esc_attr($key).'']['background-image'].');';
	}
	if ( isset($repindia_option[''.esc_attr($key).'']) && !empty($repindia_option[''.esc_attr($key).'']['background-color']))
	{
		$inner_header_style[] = 'background-color: '.$repindia_option[''.esc_attr($key).'']['background-color'].';';
	}
	if ( isset($repindia_option[''.esc_attr($key).'']) && !empty($repindia_option[''.esc_attr($key).'']['background-repeat']))
	{
		$inner_header_style[] = 'background-repeat: '.$repindia_option[''.esc_attr($key).'']['background-repeat'].';';
	}
	if ( isset($repindia_option[''.esc_attr($key).'']) && !empty($repindia_option[''.esc_attr($key).'']['background-size']) )
	{
		$inner_header_style[] = 'background-size: '.$repindia_option[''.esc_attr($key).'']['background-size'].';';
	}
	if ( isset($repindia_option[''.esc_attr($key).'']) && !empty($repindia_option[''.esc_attr($key).'']['background-position']))
	{
		$inner_header_style[] = 'background-position: '.$repindia_option[''.esc_attr($key).'']['background-position'].';';
	}
	if ( isset($repindia_option[''.esc_attr($key).'']) && !empty($repindia_option[''.esc_attr($key).'']['background-attachment']) )
	{
		$inner_header_style[] = 'background-attachment: '.$repindia_option[''.esc_attr($key).'']['background-attachment'].';';
	}
	return $inner_header_style;
}

add_action( 'wp_enqueue_scripts', 'repindia_load_theme_scripts_and_styles' );
if( ! function_exists( 'repindia_load_theme_scripts_and_styles' ) ){
	function repindia_load_theme_scripts_and_styles() {
		global $repindia_option;
		if ( ! is_admin() ) {
			wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', null, REPINDIA_THEME_VERSION, 'all' );
			wp_enqueue_style( 'fontawesome-min', get_template_directory_uri() . '/assets/css/fontawesome.min.css', null, REPINDIA_THEME_VERSION, 'all' );
			wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/css/animate.min.css', null, REPINDIA_THEME_VERSION, 'all' );
			wp_enqueue_style( 'swiper-min', get_template_directory_uri() . '/assets/css/swiper.bundle.min.css', null, REPINDIA_THEME_VERSION, 'all' );
			wp_enqueue_style( 'fancybox-min', get_template_directory_uri() . '/assets/css/fancybox.min.css', null, REPINDIA_THEME_VERSION, 'all' );
			wp_enqueue_style( 'repindia-googleapis','//fonts.googleapis.com/css2?family=Sen:wght@400;500;600;700;800&display=swap', array(), null );
			wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/assets/css/custom_style.css', null, REPINDIA_THEME_VERSION, 'all' );
			wp_enqueue_style( 'repindia-style', get_stylesheet_uri(), null, REPINDIA_THEME_VERSION, 'all' );
			wp_enqueue_style( 'repindia-responsive', get_template_directory_uri() . '/assets/css/responsive.css', null, REPINDIA_THEME_VERSION, 'all' );

			/* Register Scripts */
			wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array( 'jquery' ), REPINDIA_THEME_VERSION, true );
			wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array( 'jquery' ), REPINDIA_THEME_VERSION, true );
			wp_enqueue_script( 'fontawesome-min', get_template_directory_uri() . '/assets/js/fontawesome.min.js', array( 'jquery' ), REPINDIA_THEME_VERSION, true );
			wp_enqueue_script( 'swiper-min', get_template_directory_uri() . '/assets/js/swiper.bundle.min.js', array( 'jquery' ), REPINDIA_THEME_VERSION, true );
			wp_enqueue_script( 'jquery-fancybox-min', get_template_directory_uri() . '/assets/js/jquery.fancybox.min.js', array( 'jquery' ), REPINDIA_THEME_VERSION, true );
			wp_enqueue_script( 'repindia-global', get_template_directory_uri() . '/assets/js/global.js', array( 'jquery' ), REPINDIA_THEME_VERSION, true );
			/* Enqueue Scripts */
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}					
		}
	}
}
if( ! function_exists( 'repindia_excerpt_more' ) )
{
	function repindia_excerpt_more( $more ) 
	{
		return '';
	}
}
add_filter( 'excerpt_more', 'repindia_excerpt_more' );
define( 'REPINDIA_INC_PATH', get_template_directory() . '/inc' );
require_once( REPINDIA_INC_PATH . '/theme-essential.php' );
require_once( REPINDIA_INC_PATH . '/elementor-addons/custom-elementor.php' );
function repindia_activate() {
	global $pagenow;
	if(is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
		wp_redirect(admin_url('themes.php?page=repindia-theme-activate'));
		exit;
	}
}
add_action('after_setup_theme', 'repindia_activate', 11);
  
add_filter( 'nav_menu_css_class', 'repindia_add_active_class', 10, 4 );
function repindia_add_active_class( $classes, $item, $args, $depth )
{
	if($item->menu_item_parent == 0 && in_array('current-menu-item', $classes)){
		$classes[] = 'active parent';
	}
    return $classes;
}
function repindia_theme_style() {
    wp_enqueue_style( 'repindia-activate', get_template_directory_uri() . '/assets/css/theme-style.css', null, REPINDIA_THEME_VERSION, 'all' );
}
add_action( 'admin_enqueue_scripts', 'repindia_theme_style' );
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}
// Allow svg files upload
function allow_svg_upload( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'allow_svg_upload' );

//Allow Webp Files
function webp_upload_mimes( $existing_mimes ) {
	$existing_mimes['webp'] = 'image/webp+xml';
	return $existing_mimes;
}
add_filter( 'upload_mimes', 'webp_upload_mimes' );

// Add shortcode to retrieve URL parameters
function get_url_parameter($atts) {
    $atts = shortcode_atts( array(
        'formpdf' => '',
    ), $atts, 'get_url_parameter' );

    if ( isset( $_GET[$atts['formpdf']] ) ) {
        return $_GET[$atts['formpdf']];
    }
    return '';
}
add_shortcode('get_url_parameter', 'get_url_parameter');

if( ! function_exists( 'apl_get_categories' ) ){
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






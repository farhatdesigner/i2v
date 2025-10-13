<?php
/* ------------------------------------------------------------------------ */
/* Redux Configuration
/* ------------------------------------------------------------------------ */
    if ( ! class_exists( 'Redux' ) ) 
	{
        return;
    }
    function repindia_data_option(){
        //plugin function
    }
    // This is your option name where all the Redux data is stored.
    $opt_name = "repindia_option";
	global $logo_tmp_src;
    $theme = wp_get_theme(); // For use with some settings. Not necessary.
	$args = array(
		'opt_name'          => 'repindia_option', // This is where your data is stored in the database and also becomes your global variable name.
		'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
		'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
		'menu_type'         => 'submenu',               //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
		'allow_sub_menu'    => false,                   // Show the sections below the admin menu item or not
		'menu_title'        => __('Theme Options', 'repindia'),
		'page_title'        => __('Theme Options', 'repindia'),
		'save_defaults'     => true,
		'async_typography'  => true,                    // Use a asynchronous font on the front end or font string
		'admin_bar'         => false,                    // Show the panel pages on the admin bar
		'global_variable'   => 'repindia_option',        // Set a different name for your global variable other than the opt_name
		'dev_mode'          => false,                    // Show the time the page took to load, etc
		'customizer'        => false,                    // Enable basic customizer support
		'page_slug'         => 'repindia_option',
		'system_info'       => false,
		'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
	);
    Redux::setArgs( $opt_name, $args, $logo_tmp_src  );
    /* Set Extensions /-------------------------------------------------- */
    Redux::get_extensions( $opt_name, dirname( __FILE__ ) . '/extensions/' );
    /* General /--------------------------------------------------------- */
    
	/* Header /--------------------------------------------------------- */
	
    Redux::set_section( 
	$opt_name, 
	array(
        'title'     => esc_html__('Header', 'repindia'),
		'background-color' => '#ef9a9a',
		'desc'   => '',
		'class'     => 'main_background',
        'icon'   => 'el el-credit-card',
		'submenu' => true,
        'fields'    => array(
				           array(
								'id'       =>'header1_logo',
								'url'      => false,
								'type'     => 'media',
								'title'    => esc_attr__('Logo', 'repindia'),
								'default'  => '',
							),
							array(
								'id'       =>'hamburger_menu_logo',
								'url'      => false,
								'type'     => 'media',
								'title'    => esc_attr__('Hamburger menu Logo', 'repindia'),
								'default'  => '',
							),
							array(
								'id'       =>'header1_sticky_logo',
								'url'      => false,
								'type'     => 'media',
								'title'    => esc_attr__('Sticky Logo', 'repindia'),
								'default'  => '',
							),
							array(
								'id'       => 'header1_search_switch',
								'type'     => 'switch',
								'title'    => esc_attr__('Search Tab', 'repindia'),
								'subtitle' => __('Enable / Disable Search Tab', 'repindia'),
								'default'  => true,
						    ),
							array(
								'id'       => 'header_warrantycheck',
								'type'     => 'switch',
								'title'    => esc_attr__('Warranty Check Tab', 'repindia'),
								'subtitle' => __('Enable / Disable Warranty Check at Header', 'repindia'),
								'default'  => true,
							),
							array(
								'id'       => 'warranty_check_url',
								'type'     => 'text',
								'title'    => esc_attr__('Warranty Check Url', 'repindia'),
								'default'  => '',
								'required' => array('header_warrantycheck','=',true)
							),
						    array(
								'id'       => 'header1_store_switch',
								'type'     => 'switch',
								'title'    => esc_attr__('Store Locator Tab', 'repindia'),
								'subtitle' => __('Enable / Disable Store Locator Tab', 'repindia'),
								'default'  => true,
						    ),
							array(
								'id'       => 'store_locator_url',
								'type'     => 'text',
								'title'    => esc_attr__('Store Locator Url', 'repindia'),
								'default'  => '',
								'required' => array('header1_store_switch','=',true)
							),
						    array(
								'id'       => 'header1_humburgar_switch',
								'type'     => 'switch',
								'title'    => esc_attr__('Humburgar Tab', 'repindia'),
								'subtitle' => __('Enable / Disable Humburgar Tab', 'repindia'),
								'default'  => true,
						    ),
							array(
								'id'       => 'floating_quickaccess',
								'type'     => 'switch',
								'title'    => esc_attr__('Enable Quick Access', 'repindia'),
								'subtitle' => __('Enable / Disable Quick Access Tab', 'repindia'),
								'default'  => true,
						    ),
							array(
								'id'       =>'quick_enquiry_icon',
								'url'      => false,
								'type'     => 'media',
								'title'    => esc_html__('Enquiry Icon ', 'repindia'),
								'default'  => '',
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       => 'quick_enquiry_title',
								'type'     => 'text',
								'title'    => esc_attr__('Enquiry Title', 'repindia'),
								'default'  => "",
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       =>'download_catalog_icon',
								'url'      => false,
								'type'     => 'media',
								'title'    => esc_html__('Download Catalog Icon ', 'repindia'),
								'default'  => '',
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       => 'download_catalog_title',
								'type'     => 'text',
								'title'    => esc_attr__('Download Catalog Title', 'repindia'),
								'default'  => "",
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       => 'download_catalog_url',
								'type'     => 'text',
								'title'    => esc_attr__('Download Catalog URL', 'repindia'),
								'default'  => "",
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       =>'warranty_icon',
								'url'      => false,
								'type'     => 'media',
								'title'    => esc_html__('Warranty Icon ', 'repindia'),
								'default'  => '',
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       => 'warranty_title',
								'type'     => 'text',
								'title'    => esc_attr__('Warranty title', 'repindia'),
								'default'  => "",
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       => 'warranty_url',
								'type'     => 'text',
								'title'    => esc_attr__('Warranty URL', 'repindia'),
								'default'  => "",
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       =>'partner_icon',
								'url'      => false,
								'type'     => 'media',
								'title'    => esc_html__('Partner Icon ', 'repindia'),
								'default'  => '',
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       => 'partner_title',
								'type'     => 'text',
								'title'    => esc_attr__('Partner title', 'repindia'),
								'default'  => "",
								'required' => array('floating_quickaccess','=',true)
							),
							array(
								'id'       => 'partner_url',
								'type'     => 'text',
								'title'    => esc_attr__('Partner URL', 'repindia'),
								'default'  => "",
								'required' => array('floating_quickaccess','=',true)
							),
			)
		) 
	);
	
	/* Social Media /--------------------------------------------------------- */
    Redux::set_section( $opt_name, 
		array(
			'title'  => esc_html__( 'Social Media', 'repindia' ),
			'desc'   => 'Enter social url here. Please enter full URL include http://',
			'icon'   => 'el-icon-address-book',
			'submenu' => true,
			'fields'    => array(
								array(
									'id'       => 'enable_social',
									'type'     => 'switch',
									'title'    => esc_html__('Social Icon', 'repindia'),
									'subtitle' => esc_html__('Enable / Disable Social Icons.', 'repindia'),
									'default'  => true,
								),
								array(
									'id'       =>'facebook-value',
									'type'     => 'text',
									'title'    => esc_html__('Facebook', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Facebook URL.', 'repindia'),
									'default'  => esc_html__('#','repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								array(
									'id'       =>'twitter-value',
									'type'     => 'text',
									'title'    => esc_html__('Twitter', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Twitter URL.', 'repindia'),
									'default'  => esc_html__('#','repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								array(
									'id'       =>'linkedin-value',
									'type'     => 'text',
									'title'    => esc_html__('Linkedin', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Linkedin URL.', 'repindia'),
									'default'  => esc_html__('#','repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								array(
									'id'       =>'instagram-value',
									'type'     => 'text',
									'title'    => esc_html__('Instagram', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Instagram URL.', 'repindia'),
									'default'  => esc_html__('#','repindia'),
									'required' => array('enable_social','=',true)		   
								),
								array(
									'id'       =>'pinterest-value',
									'type'     => 'text',
									'title'    => esc_html__('Pinterest', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Pinterest URL.', 'repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								
								array(
									'id'       =>'yelp-value',
									'type'     => 'text',
									'title'    => esc_html__('Yelp', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Yelp URL.', 'repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								array(
									'id'       =>'foursquare-value',
									'type'     => 'text',
									'title'    => esc_html__('Foursquare', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Foursquare URL.', 'repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								array(
									'id'       =>'flickr-value',
									'type'     => 'text',
									'title'    => esc_html__('Flickr', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Flickr URL.', 'repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								array(
									'id'       =>'youtube-value',
									'type'     => 'text',
									'title'    => esc_html__('Youtube', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Youtube URL.', 'repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								array(
									'id'       =>'email-value',
									'type'     => 'text',
									'title'    => esc_html__('Email', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Email URL.', 'repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								array(
									'id'       =>'rss-value',
									'type'     => 'text',
									'title'    => esc_html__('Rss', 'repindia'),
									'subtitle' => '',
									'desc'     => esc_html__('Enter your Rss URL.', 'repindia'),
									'required' => array('enable_social','=',true)		   
								),
						),
			) 
	);

	/*--------------------------------------------------------------------*/
	/* Footer /--------------------------------------------------------- */
	Redux::set_section( $opt_name, 
		array(
			'title'     => __('Footer', 'repindia'),
			'header'    => '',
			'desc'      => '',
			'icon'      => 'el-icon-photo',
			'class'     => 'main_background',
			'submenu'   => true,
			'fields'    =>  array(
								array(
										'id'       => 'footer_bg',
										'type'    => 'background',				
										'title'   => esc_attr__( 'Footer Background Image & Color', 'repindia' ),
										'output'  => '',
										'default'  => array(
											'background-color' => '#F5F5F5',
											'background-image' => '',
										),
									),
								array(
									'id'       =>   'footer_seprater_footer_widget',
									'url'      =>   false,
									'type'     =>   'text',
									'class'    =>   'background_color',
									'title'    =>   esc_attr__('Footer Content', 'repindia'),
								),
								array(
									'id'       =>'footer_logo',
									'url'      => false,
									'type'     => 'media',
									'title'    => esc_html__('Footer Logo', 'repindia'),
									'default'  => '',
								),
								array(
									'id'       =>'footer_sort_desc',
									'type'     => 'editor',
									'title'    => esc_html__('Footer Sort Description', 'repindia'),
									'default'  => '',
									'args'   => array(
										'teeny'            => true,
										'textarea_rows'    => 5
									)
								),
								array(
									'id'       => 'footer_contact_title',
									'type'     => 'text',
									'title'    => esc_attr__('Contact Detail Title', 'repindia'),
									'default'  => "",
								),
								array(
									'id'       =>'footer_contact_addrr_icon',
									'url'      => false,
									'type'     => 'media',
									'title'    => esc_html__('Footer Contact Address Icon ', 'repindia'),
									'default'  => '',
								),
								array(
									'id'       => 'footer_contact_addrr',
									'type'     => 'text',
									'title'    => esc_attr__('Contact Detail Address', 'repindia'),
									'default'  => "",
								),
								array(
									'id'       =>'footer_contact_phn_con',
									'url'      => false,
									'type'     => 'media',
									'title'    => esc_html__('Footer Contact Phone Icon ', 'repindia'),
									'default'  => '',
								),
								array(
									'id'       => 'footer_contact_phn',
									'type'     => 'text',
									'title'    => esc_attr__('Contact Detail Phone Number', 'repindia'),
									'default'  => "",
								),
								array(
									'id'       => 'footer_main_menu_title',
									'type'     => 'text',
									'title'    => esc_attr__('Main Menu Title', 'repindia'),
									'default'  => esc_attr__( 'Main Menu', 'repindia'),
								),
								array(
									'id'       => 'footer_brand_menu_title',
									'type'     => 'text',
									'title'    => esc_attr__('Brand Menu Title', 'repindia'),
									'default'  => esc_attr__( 'Brand Menu', 'repindia'),
								),
								array(
									'id'       => 'footer_service_menu_title',
									'type'     => 'text',
									'title'    => esc_attr__('Service Menu Title', 'repindia'),
									'default'  => esc_attr__( 'Service Menu', 'repindia'),
								),
								array(
									'id'       => 'footer_news_menu_title',
									'type'     => 'text',
									'title'    => esc_attr__('News & Media Menu Title', 'repindia'),
									'default'  => esc_attr__( 'News & Media Menu', 'repindia'),
								),
								array(
									'id'       => 'footer_gallery_menu_title',
									'type'     => 'text',
									'title'    => esc_attr__('Gallery Menu Title', 'repindia'),
									'default'  => esc_attr__( 'Gallery Menu', 'repindia'),
								),
								array(
									'id'       => 'footer_resource_menu_title',
									'type'     => 'text',
									'title'    => esc_attr__('Resource Menu Title', 'repindia'),
									'default'  => esc_attr__( 'Resource Menu', 'repindia'),
								),
								
								array(
									'id'       =>   'copyright_seprater_footer_widget',
									'url'      =>   false,
									'type'     =>   'text',
									'class'    =>   'background_color',
									'title'    =>   esc_attr__('Footer Copyright', 'repindia'),
									'required' => array('footer_copyright_switch','=',true)
								),
								array(
									'id'       => 'footer_copyright_switch',
									'type'     => 'switch',
									'title'    => esc_attr__('Enable / Disable Copyright', 'repindia'),
									'default'  => true,
								),
								array(
									'id'       =>'footer_copyright',
									'type'     => 'editor',
									'title'    => esc_html__('Copyright Text', 'repindia'),
									'default'  => esc_attr__( ' © Copyright '.date('Y').' APL Repindia - All rights reserved', 'repindia'),
									'args'   => array(
										'teeny'            => true,
										'textarea_rows'    => 5
									),
									'required' => array('footer_copyright_switch','=',true)
								),
								
								array(
									'id'       => 'footer_social',
									'type'     => 'switch',
									'title'    => esc_attr__('Footer Social Media', 'repindia'),
									'subtitle' => __('Enable / Disable Social Media at Footer', 'repindia'),
									'default'  => true,
									'required' => array('footer_copyright_switch','=',true)
							    ),
								array(
									'id'       => 'footer_social_title',
									'type'     => 'text',
									'title'    => esc_attr__('Footer Social Title', 'repindia'),
									'default'  => esc_attr__( 'Follow us on:', 'repindia'),
									'required' => array('footer_social','=',true)
								),
								
					)
			) 
	);
/* ------------------------------------------------------------------------ */
/* Custom function for webcoretheme's own CSS
/* ------------------------------------------------------------------------ */
function repindia_option_styles() {
    $plugin_url =  plugins_url('', __FILE__);
    wp_enqueue_style( 'admin-styles', $plugin_url . '/style.css', null, null, 'all' );
}
add_action( 'admin_enqueue_scripts', 'repindia_option_styles' );
/* ------------------------------------------------------------------------ */
/* Post Type Meta Data and Custom Post Type
/* ------------------------------------------------------------------------ */
define( 'REPINDIA_POST_TYPE', 'repindia_post_type' );
function custom_post_type_init() {
global $repindia_option;
	$defaults = '';
	$defaults = array(
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => null,
		'supports'           => array( 'title', 'editor' )
	);
	
}
add_action( 'init', 'custom_post_type_init' );
function custom_post_type_tax_init() {
	// register_taxonomy(
	// 	'team-category',
	// 	'team',
	// 	array(
	// 		'label' => __( 'Team Category' ),
	// 		'rewrite' => array( 'slug' => 'team' ),
	// 		'hierarchical' => true,
	// 		'show_admin_column' => true,
	// 	)
	// );
}
add_action( 'init', 'custom_post_type_tax_init' );
// TO add Meta boxes Units
function wdm_add_meta_box_unit() {
	//add_meta_box('wdm_section_team_logo', 'Team Logo', 'wdm_meta_box_team_logo', 'team');
	// $types = array('page', 'team', 'post','blog');
}
add_action( 'add_meta_boxes', 'wdm_add_meta_box_unit' );


function wdm_meta_box_team_logo($post)
{
	//$teamLogo 	= get_post_meta( $post->ID, 'team-logo', true );
?>
<?php
}
function wdm_save_meta_box_data_unit( $post_id ) {
   
	// Update the meta field in the database.
	// if ( isset($_REQUEST['team_logo_setting']) && wp_verify_nonce( $_REQUEST['team_logo_setting'], 'team_logo_nonce_setting' ) )
	// {
	// 	$teamLogo = ( isset( $_POST['team-logo'] ) ?  $_POST['team-logo']  : '' );
	// 	update_post_meta( $post_id, 'team-logo', $teamLogo );
	// }
}
add_action( 'save_post', 'wdm_save_meta_box_data_unit' );

// Allow Upload SVG Files in media type
function my_mime_types( $mime_types = array() ){
    $mime_types['svg'] = 'image/svg+xml'; // Adding svg extension
    return $mime_types;
}
add_filter('upload_mimes', 'my_mime_types', 1, 1);
?>
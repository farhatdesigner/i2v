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
								'id'       =>'light_theme_logo',
								'url'      => false,
								'type'     => 'media',
								'title'    => esc_attr__('Light Theme Logo', 'repindia'),
								'default'  => '',
							),
							array(
								'id'       =>'dark_theme_logo',
								'url'      => false,
								'type'     => 'media',
								'title'    => esc_attr__('Dark Theme Logo', 'repindia'),
								'default'  => '',
							),
							array(
								'id'       => 'header_demo_btn',
								'type'     => 'switch',
								'title'    => esc_attr__('Demo Button Switch', 'repindia'),
								'subtitle' => __('Enable / Disable Button', 'repindia'),
								'default'  => true,
						    ),
							array(
								'id'       => 'demo_btn_url',
								'type'     => 'text',
								'title'    => esc_attr__('Demo Button Url', 'repindia'),
								'default'  => '',
								'required' => array('header_demo_btn','=',true)
							),
							array(
								'id'       => 'langauge_btn_switch',
								'type'     => 'switch',
								'title'    => esc_attr__('Language Button Switch', 'repindia'),
								'subtitle' => __('Enable / Disable Button', 'repindia'),
								'default'  => true,
						    ),
							array(
								'id'       => 'search_btn_switch',
								'type'     => 'switch',
								'title'    => esc_attr__('Search Button Switch', 'repindia'),
								'subtitle' => __('Enable / Disable Search Tab', 'repindia'),
								'default'  => true,
						    ),
							array(
								'id'       => 'theme_switch_btn',
								'type'     => 'switch',
								'title'    => esc_attr__('Theme Switch Button', 'repindia'),
								'subtitle' => __('Enable / Disable Button', 'repindia'),
								'default'  => true,
							),
			)
		)
	);
	
	/* Header Hamburger /--------------------------------------------------------- */
	Redux::set_section( 
		$opt_name, 
		array(
			'title'     => esc_html__('Header Hamburger', 'repindia'),
			'background-color' => '#ef9a9a',
			'desc'   => '',
			'class'     => 'main_background',
			'icon'   => 'el el-credit-card',
			'submenu' => true,
			'fields'    => array(
				array(
					'id'       => 'hamburger_demo_btn',
					'type'     => 'switch',
					'title'    => esc_attr__('Hamburger Button Switch', 'repindia'),
					'subtitle' => __('Enable / Disable Button', 'repindia'),
					'default'  => true,
				),
				array(
					'id'       => 'hamburger_btn_url',
					'type'     => 'text',
					'title'    => esc_attr__('Hamburger Button Url', 'repindia'),
					'default'  => '',
					'required' => array('hamburger_demo_btn','=',true)
				),
				array(
					'id'       => 'hamburger_editor',
					'type'     => 'editor',
					'title'    => esc_html__('Hamburger Content', 'repindia'),
					'subtitle' => __('Add content for hamburger menu', 'repindia'),
					'default'  => '',
					'args'     => array(
						'teeny'            => true,
						'textarea_rows'    => 10
					)
				),
				array(
					'id'       => 'hamburger_menu_item_1_icon',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__('Menu Item 1 - Icon/Image', 'repindia'),
					'subtitle' => __('Upload icon or image for menu item 1', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_1_title',
					'type'     => 'text',
					'title'    => esc_html__('Menu Item 1 - Title', 'repindia'),
					'subtitle' => __('Enter title for menu item 1', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_1_url',
					'type'     => 'text',
					'title'    => esc_html__('Menu Item 1 - URL', 'repindia'),
					'subtitle' => __('Enter URL for menu item 1', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_2_icon',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__('Menu Item 2 - Icon/Image', 'repindia'),
					'subtitle' => __('Upload icon or image for menu item 2', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_2_title',
					'type'     => 'text',
					'title'    => esc_html__('Menu Item 2 - Title', 'repindia'),
					'subtitle' => __('Enter title for menu item 2', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_2_url',
					'type'     => 'text',
					'title'    => esc_html__('Menu Item 2 - URL', 'repindia'),
					'subtitle' => __('Enter URL for menu item 2', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_3_icon',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__('Menu Item 3 - Icon/Image', 'repindia'),
					'subtitle' => __('Upload icon or image for menu item 3', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_3_title',
					'type'     => 'text',
					'title'    => esc_html__('Menu Item 3 - Title', 'repindia'),
					'subtitle' => __('Enter title for menu item 3', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_3_url',
					'type'     => 'text',
					'title'    => esc_html__('Menu Item 3 - URL', 'repindia'),
					'subtitle' => __('Enter URL for menu item 3', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_4_icon',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__('Menu Item 4 - Icon/Image', 'repindia'),
					'subtitle' => __('Upload icon or image for menu item 4', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_4_title',
					'type'     => 'text',
					'title'    => esc_html__('Menu Item 4 - Title', 'repindia'),
					'subtitle' => __('Enter title for menu item 4', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_menu_item_4_url',
					'type'     => 'text',
					'title'    => esc_html__('Menu Item 4 - URL', 'repindia'),
					'subtitle' => __('Enter URL for menu item 4', 'repindia'),
					'default'  => '',
				),
				array(
					'id'       => 'hamburger_social',
					'type'     => 'switch',
					'title'    => esc_attr__('Hamburger Social Media', 'repindia'),
					'subtitle' => __('Enable / Disable Social Media at haeder', 'repindia'),
					'default'  => true,
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
									'id'       =>'social_media_title',
									'type'     => 'text',
									'title'    => esc_html__('Social Media Section Title', 'repindia'),
									'default'  => esc_html__('Follow us on','repindia'),
									'required' => array('enable_social','=',true)
											   
								),
								array(
									'id'       => 'linkedin_icon',
									'type'     => 'media',
									'url'      => false,
									'title'    => esc_html__('LinkedIn - Icon/Image', 'repindia'),
									'subtitle' => __('Upload icon or image for Linkedin', 'repindia'),
									'default'  => '',
								),
								array(
									'id'       => 'linkedin_footer_icon',
									'type'     => 'media',
									'url'      => false,
									'title'    => esc_html__('LinkedIn Footer - Icon/Image', 'repindia'),
									'subtitle' => __('Upload icon or image for Footer Linkedin', 'repindia'),
									'default'  => '',
								),
								array(
									'id'       =>'linkedin_title',
									'type'     => 'text',
									'title'    => esc_html__('LinkedIn Title', 'repindia'),
									'default'  => esc_html__('LinkedIn','repindia'),
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
									'id'       => 'youtube_icon',
									'type'     => 'media',
									'url'      => false,
									'title'    => esc_html__('Youtube - Icon/Image', 'repindia'),
									'subtitle' => __('Upload icon or image for Youtube', 'repindia'),
									'default'  => '',
								),
								array(
									'id'       => 'youtube_footer_icon',
									'type'     => 'media',
									'url'      => false,
									'title'    => esc_html__('Youtube Footer - Icon/Image', 'repindia'),
									'subtitle' => __('Upload icon or image for FooterYoutube', 'repindia'),
									'default'  => '',
								),
								array(
									'id'       =>'youtube_title',
									'type'     => 'text',
									'title'    => esc_html__('Youtube Title', 'repindia'),
									'default'  => esc_html__('Youtube','repindia'),
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
									'id'       => 'footer_product_title',
									'type'     => 'text',
									'title'    => esc_attr__('Product Title', 'repindia'),
									'default'  => esc_attr__( 'Products', 'repindia'),
								),
								array(
									'id'       => 'footer_industry_title',
									'type'     => 'text',
									'title'    => esc_attr__('Industry Title', 'repindia'),
									'default'  => esc_attr__( 'Industries', 'repindia'),
								),
								array(
									'id'       => 'footer_company_title',
									'type'     => 'text',
									'title'    => esc_attr__('Company Title', 'repindia'),
									'default'  => esc_attr__( 'Company', 'repindia'),
								),
								array(
									'id'       => 'footer_resource_title',
									'type'     => 'text',
									'title'    => esc_attr__('Resource Title', 'repindia'),
									'default'  => esc_attr__( 'Resources', 'repindia'),
								),
								array(
									'id'       => 'footer_legal_title',
									'type'     => 'text',
									'title'    => esc_attr__('Legal Title', 'repindia'),
									'default'  => esc_attr__( 'Legal', 'repindia'),
								),
								array(
									'id'       =>   'copyright_seprater_footer_widget',
									'url'      =>   false,
									'type'     =>   'text',
									'class'    =>   'background_color',
									'title'    =>   esc_attr__('Footer Copyright', 'repindia'),
								),
								array(
									'id'       =>'footer_dscl_icon',
									'url'      => false,
									'type'     => 'media',
									'title'    => esc_html__('Footer Disclaimer Icon ', 'repindia'),
									'default'  => '',
								),
								array(
									'id'       =>'footer_disclaimer_desc',
									'type'     => 'editor',
									'title'    => esc_html__('Footer disclaimer contents', 'repindia'),
									'default'  => '',
									'args'   => array(
										'teeny'            => true,
										'textarea_rows'    => 5
									)
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
								),
								
								array(
									'id'       => 'footer_social',
									'type'     => 'switch',
									'title'    => esc_attr__('Footer Social Media', 'repindia'),
									'subtitle' => __('Enable / Disable Social Media at Footer', 'repindia'),
									'default'  => true,
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
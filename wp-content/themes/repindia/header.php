<?php
/**
 * The header for our theme.
 * Displays all of the <head> section and everything up till 
 *
 * @package repindia
 */
global $repindia_option;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>	
    <style>
        html.lenis,html.lenis body { height: auto; }
        .lenis.lenis-smooth { scroll-behavior: auto !important; }
        .lenis.lenis-smooth [data-lenis-prevent] { overscroll-behavior: contain; }
        .lenis.lenis-stopped { overflow: hidden; }
        .lenis.lenis-scrolling iframe { pointer-events: none; }
    </style>
</head>
<body <?php body_class(); ?>>
<div id="content-wrapper" class="main-container">
  <header class="main_header">
    <div class="container">
        <nav>
            <ul class="logo-wdth">
                <li>
                    <?php 
                    if ( isset($repindia_option['header1_logo']['url']) && !empty($repindia_option['header1_logo']['url']) ){ ?>  
                        <a class="main_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                            <img src="<?php echo esc_url( $repindia_option['header1_logo']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                        </a>
                    <?php }else{ ?>
                        <a class="main_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" ><?php bloginfo( 'name' ); ?></a>
                    <?php 
                        } ?>
                    <?php if( isset($repindia_option['header1_sticky_logo']['url']) && !empty($repindia_option['header1_sticky_logo']['url']) ){ ?>
                        <a class="sticky_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                            <img src="<?php echo esc_url( $repindia_option['header1_sticky_logo']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                        </a>
                    <?php }else{ ?>
                        <a class="sticky_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" ><?php bloginfo( 'name' ); ?></a>
                    <?php 
                        } 
                    ?>
                </li>
            </ul>
            <div class="main_nav_menu">
                <?php
                if ( has_nav_menu( 'repindia-primary' ) )
                {
                    wp_nav_menu( array(
                            'menu_id' => 'header-main-menu',
                            'theme_location' => 'repindia-primary',
                            'container'      => false,
                            'depth'          => 2,
                            'link_after'          => '<span class="caret"><i class="fa fa-arrow-down"></i></span>',
                            'menu_class'     => 'menu'
                        )
                    ); 
                }  
                ?>
                <ul class="header-right-box">
                    <?php
                    if( isset($repindia_option['header1_search_switch']) && $repindia_option['header1_search_switch'] == 1)
                    { ?>
                        <li>
                        <div class="header_icon">
                            <button name="button" type="button" class="search-btn search-popup__toggler" data-toggle="modal" data-target=".bs-example-modal-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21.73 20.44L18.1 16.81C21.27 12.93 20.69 7.20997 16.81 4.03997C12.93 0.879974 7.22 1.44997 4.05 5.32997C0.880004 9.20997 1.46 14.93 5.34 18.1C8.68 20.83 13.48 20.83 16.82 18.1L20.45 21.73C20.8 22.09 21.38 22.09 21.73 21.73C22.09 21.38 22.09 20.8 21.73 20.45V20.44ZM11.11 18.37C7.1 18.37 3.85 15.12 3.85 11.11C3.85 7.09997 7.1 3.84997 11.11 3.84997C15.12 3.84997 18.37 7.09997 18.37 11.11C18.37 15.12 15.12 18.37 11.11 18.37Z" fill="white"/></svg></button>
                        </div>
                        <div class="search-popup">
                            <div class="search-popup__overlay custom-cursor__overlay">
                                <div class="cursor"></div>
                                <div class="cursor-follower"></div>
                            </div>
                            <div class="search-popup__inner">
                                <form role="search" method="get" class="search-popup__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                    <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s"   placeholder="<?php echo esc_attr__('Search...','amtech'); ?>" required/>
                                    <button type="submit" class="sbtn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21.73 20.44L18.1 16.81C21.27 12.93 20.69 7.20997 16.81 4.03997C12.93 0.879974 7.22 1.44997 4.05 5.32997C0.880004 9.20997 1.46 14.93 5.34 18.1C8.68 20.83 13.48 20.83 16.82 18.1L20.45 21.73C20.8 22.09 21.38 22.09 21.73 21.73C22.09 21.38 22.09 20.8 21.73 20.45V20.44ZM11.11 18.37C7.1 18.37 3.85 15.12 3.85 11.11C3.85 7.09997 7.1 3.84997 11.11 3.84997C15.12 3.84997 18.37 7.09997 18.37 11.11C18.37 15.12 15.12 18.37 11.11 18.37Z" fill="white"/></svg></button>
                                </form>
                            </div>
                        </div>
                        </li>
                    <?php 
                    } ?>
                    <?php
                    if( isset($repindia_option['header1_humburgar_switch']) && $repindia_option['header1_humburgar_switch'] == 1)
                    { ?>
                        <li>
                            <div class="humburgar" id="nav-icon">
                                <ul>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                        </li>
                    <?php 
                    } ?>
                    <?php 
                    if( isset($repindia_option['header1_store_switch']) && $repindia_option['header1_store_switch'] == 1)
                    { ?>
                        <li class="header_location_box">
                        <div class="header_location"><a href="<?php echo esc_attr($repindia_option['store_locator_url']); ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.2002 13.0667C6.2002 7.63024 10.593 3.20001 16.0002 3.20001H16.0135C21.4207 3.20001 25.8135 7.63024 25.8135 13.0667C25.8135 16.8926 23.6355 20.6809 21.5287 23.472C19.4107 26.278 17.2512 28.2227 17.0398 28.41C16.4562 28.9345 15.5575 28.9345 14.9739 28.41C14.7626 28.2227 12.6031 26.278 10.485 23.472C8.37823 20.6809 6.2002 16.8926 6.2002 13.0667ZM16.0002 4.80001C11.4874 4.80001 7.8002 8.50312 7.8002 13.0667C7.8002 16.3474 9.70217 19.7791 11.762 22.508C13.7134 25.0932 15.7059 26.9174 16.0069 27.1873C16.3079 26.9174 18.3003 25.0932 20.2517 22.508C22.3116 19.7791 24.2135 16.3474 24.2135 13.0667C24.2135 8.50312 20.5263 4.80001 16.0135 4.80001H16.0002ZM16.0002 10.92C14.8554 10.92 13.9202 11.8552 13.9202 13C13.9202 14.1449 14.8554 15.08 16.0002 15.08C17.145 15.08 18.0802 14.1449 18.0802 13C18.0802 11.8552 17.145 10.92 16.0002 10.92ZM12.3202 13C12.3202 10.9715 13.9717 9.32001 16.0002 9.32001C18.0287 9.32001 19.6802 10.9715 19.6802 13C19.6802 15.0285 18.0287 16.68 16.0002 16.68C13.9717 16.68 12.3202 15.0285 12.3202 13Z" fill="white"/></svg></a></div>
                        </li>
                    <?php 
                    } ?>
                </ul>
            </div>
            <?php
            if( isset($repindia_option['header1_humburgar_switch']) && $repindia_option['header1_humburgar_switch'] == 1)
            { ?>
                <!-- Side menu -->
                <div class="nav_menu side_menu sidebar_nav_menu">
                    <div class="menu-main-menu-container">
                        <ul class="sidemenu-logo-section">
                            <li>
                            <?php 
                            if ( isset($repindia_option['hamburger_menu_logo']['url']) && !empty($repindia_option['hamburger_menu_logo']['url']) ){ ?>  
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                    <img src="<?php echo esc_url( $repindia_option['hamburger_menu_logo']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                                </a>
                            <?php }else{ ?>
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" ><?php bloginfo( 'name' ); ?></a>
                            <?php 
                                } 
                            ?>
                            </li>
                        </ul>
                        <div class="after_head_sidebox">
                            <div class="floating_header_nav">
                                <div class="header_search_mobile">
                                    <div class="search-popup">
                                        <div class="search-popup__inner">
                                            <form role="search" method="get" class="search-popup__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                                <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s"   placeholder="<?php echo esc_attr__('Search...','amtech'); ?>" required/>
                                                <button type="submit" class="sbtn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21.73 20.44L18.1 16.81C21.27 12.93 20.69 7.20997 16.81 4.03997C12.93 0.879974 7.22 1.44997 4.05 5.32997C0.880004 9.20997 1.46 14.93 5.34 18.1C8.68 20.83 13.48 20.83 16.82 18.1L20.45 21.73C20.8 22.09 21.38 22.09 21.73 21.73C22.09 21.38 22.09 20.8 21.73 20.45V20.44ZM11.11 18.37C7.1 18.37 3.85 15.12 3.85 11.11C3.85 7.09997 7.1 3.84997 11.11 3.84997C15.12 3.84997 18.37 7.09997 18.37 11.11C18.37 15.12 15.12 18.37 11.11 18.37Z" fill="white"/></svg></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ( has_nav_menu( 'header-sidebar-menu' ) )
                                { 
                                ?>
                                    <div class="floating_header_left">
                                        <?php
                                        wp_nav_menu( array(
                                                'menu_id' => 'menu-main-menu',
                                                'theme_location' => 'header-sidebar-menu',
                                                'container'      => false,
                                                'depth'          => 2,
                                                'after'          => '<span class="caret"><i class="fa fa-arrow-down"></i></span>',
                                                'menu_class'     => 'menu'
                                            )
                                        );  
                                        ?> 
                                    </div>
                                <?php } ?>
                                <div class="floating_header_center">
                                <?php
                                    if ( has_nav_menu( 'footer-brand-menu' ) )
                                    { 
                                    ?>
                                        <div class="floatingbrand_nav">
                                            <h4><?php echo esc_html__( 'Our Brands', 'repindia' ); ?></h4>
                                            <?php
                                            wp_nav_menu(
                                                array(
                                                    'theme_location' => 'footer-brand-menu',
                                                    'container'      => false,
                                                    'depth'          => 1,
                                                    'menu_class'     => 'links'
                                                )
                                            ); 
                                            ?> 
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="floating_header_right">
                                    
                                    <?php
                                    if ( has_nav_menu( 'footer-resource-menu' ) )
                                    { 
                                    ?>
                                        <div class="floating_resource_nav">
                                            <h4><a href="<?php echo esc_url( home_url( '/' ) ); ?>resource/"><?php echo esc_html__( 'Resource', 'repindia' ); ?></a></h4>
                                            <?php
                                            wp_nav_menu(
                                                array(
                                                    'theme_location' => 'footer-resource-menu',
                                                    'container'      => false,
                                                    'depth'          => 1,
                                                    'after'     	 => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12.8333 11.1825V9.23996C12.8333 8.97163 12.6175 8.7558 12.3492 8.7558C12.0808 8.7558 11.865 8.97163 11.865 9.23996V11.1825C11.865 11.4508 11.6492 11.6666 11.3808 11.6666H2.62499C2.35665 11.6666 2.14082 11.4508 2.14082 11.1825V9.23996C2.14082 8.97163 1.92499 8.7558 1.65665 8.7558C1.38832 8.7558 1.17249 8.97163 1.17249 9.23996V11.1825C1.17249 11.9875 1.82582 12.6408 2.63082 12.6408H11.3808C12.1858 12.6408 12.8392 11.9875 12.8392 11.1825H12.8333ZM9.72999 8.0558L7.29749 9.9983C7.12249 10.1383 6.87165 10.1383 6.69665 9.9983L4.26415 8.0558C4.07165 7.86913 4.05999 7.5658 4.24665 7.36746C4.40999 7.19246 4.67249 7.1633 4.87082 7.29746L6.51582 8.60996V1.8433C6.51582 1.57496 6.73165 1.35913 6.99999 1.35913C7.26832 1.35913 7.48415 1.57496 7.48415 1.8433V8.60996L9.12915 7.29746C9.32165 7.1108 9.63082 7.12246 9.81749 7.31496C10.0042 7.50746 9.99249 7.81663 9.79999 8.0033C9.78249 8.0208 9.75915 8.0383 9.73582 8.0558H9.72999Z" fill="#121212"/></svg>',
                                                    'menu_class'     => 'links'
                                                )
                                            );  
                                            ?> 
                                        </div>
                                    <?php } ?>
                                </div>
                            </div> 
                            <div class="floating_header_bottom">
                                <div class="floating_bottom_left">
                                    <?php
                                    if( !empty( $repindia_option['enable_social'] ) && isset($repindia_option['footer_social']) && $repindia_option['footer_social'] == 1)
                                    { 
                                        $footer_socials = repindia_get_socials( 'enable_social' ); 
                                        if ( $footer_socials)
                                        { ?>
                                        <div class="footer_social_section">
                                            <p><?php echo esc_attr($repindia_option['footer_social_title']); ?></p>
                                            <ul class="social-icons">
                                                <?php   
                                                foreach( $footer_socials as $class => $val )
                                                { ?>
                                                    <li>
                                                        <a href="<?php echo esc_url( $val ); ?>" target="_blank" class="social-<?php echo esc_attr( $class ); ?>">
                                                            <i class="fa fa-<?php echo esc_attr( $class ); ?> icon" ></i>
                                                        </a>
                                                    </li>
                                                <?php   
                                                }   ?>
                                            </ul>
                                        </div>
                                        <?php   
                                        }
                                    } ?>
                                </div>
                                <div class="floating_bottom_right">
                                <?php 
                                    if( isset($repindia_option['header_warrantycheck']) && $repindia_option['header_warrantycheck'] == 1)
                                    { ?>
                                        <a class="floating_btn floating_btn_one" href="<?php echo esc_attr($repindia_option['warranty_check_url']); ?>" target="_blank">
                                            <?php echo esc_html__( 'Warranty Check', 'repindia' ) ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M15.2996 5.36241C15.2846 4.96491 15.2846 4.58991 15.2846 4.21491C15.2846 3.90741 15.0521 3.67491 14.7446 3.67491C12.5021 3.67491 10.7996 3.02991 9.38206 1.64991C9.16456 1.45491 8.84206 1.45491 8.63206 1.64991C7.21456 3.02991 5.51206 3.67491 3.26956 3.67491C2.96206 3.67491 2.72956 3.90741 2.72956 4.21491C2.72956 4.58991 2.72955 4.96491 2.71455 5.36241C2.63955 9.12741 2.53455 14.2949 8.83455 16.4624L9.01456 16.4999L9.19456 16.4624C15.4721 14.2949 15.3821 9.14241 15.3146 5.36241H15.2996ZM8.57206 10.5824C8.46706 10.6724 8.33956 10.7249 8.19706 10.7249H8.18205C8.03955 10.7249 7.89705 10.6499 7.80705 10.5449L6.14205 8.69991L6.95206 7.97991L8.26456 9.43491L11.1671 6.67491L11.9021 7.46241L8.58705 10.5824H8.57206Z" fill="#121212"/></svg>

                                        </a>
                                    <?php 
                                    }
                                    if( isset($repindia_option['header1_store_switch']) && $repindia_option['header1_store_switch'] == 1)
                                    { ?>
                                        <a class="floating_btn floating_btn_two" href="<?php echo esc_attr($repindia_option['store_locator_url']); ?>">
                                        <?php echo esc_html__( 'Store Locator', 'repindia' ) ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9.00031 1.5C6.00781 1.5 3.57031 3.9375 3.57031 6.93C3.57031 10.65 8.43031 16.1025 8.64031 16.335C8.83531 16.5525 9.17281 16.5525 9.36781 16.335C9.57781 16.1025 14.4378 10.65 14.4378 6.93C14.4378 3.9375 12.0003 1.5 9.00781 1.5H9.00031ZM9.00031 9.6675C7.49281 9.6675 6.27031 8.445 6.27031 6.9375C6.27031 5.43 7.49281 4.2075 9.00031 4.2075C10.5078 4.2075 11.7303 5.43 11.7303 6.9375C11.7303 8.445 10.5078 9.6675 9.00031 9.6675Z" fill="#121212"/></svg>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            <?php } ?>

        </nav>
    </div>
</header>
<div class="floating_enquiry_btn desktop_view">
    <button><?php echo esc_html__( 'Enquire Now', 'repindia' ); ?><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M8.3127 6.02581C8.5052 6.31748 8.6102 6.65581 8.6102 6.99998C8.6102 7.34415 8.5052 7.68248 8.3127 7.97415L5.1277 12.7575C5.1277 12.7575 5.0927 12.81 5.0752 12.8333H10.296C10.8969 12.8333 11.3694 12.3491 11.3694 11.76V2.23998C11.3694 1.63915 10.8852 1.16665 10.296 1.16665H5.0752C5.0752 1.16665 5.1102 1.21915 5.1277 1.24248L8.3127 6.02581Z" fill="#121212"/><path d="M4.55586 12.3783L7.74086 7.59498C7.86336 7.41415 7.92169 7.20415 7.92169 6.99998C7.92169 6.79581 7.86336 6.58581 7.74086 6.40498L4.55586 1.62165C4.36336 1.33581 4.04836 1.16665 3.70419 1.16665C3.11503 1.16665 2.63086 1.65081 2.63086 2.23998L2.63086 11.76C2.63086 12.3491 3.11503 12.8333 3.70419 12.8333C4.04836 12.8333 4.36919 12.6641 4.55586 12.3783Z" fill="#121212"/></svg></button>
</div>
<?php if( isset($repindia_option['floating_quickaccess']) && $repindia_option['floating_quickaccess'] == 1)
{ ?>
    <div id="quickaccess_view" class="quickaccess_view">
    <?php 
        if ( isset($repindia_option['download_catalog_icon']['url']) && !empty($repindia_option['download_catalog_icon']['url']) ){ ?>  
            <div class="quick_catalog">
                <a href="<?php echo $repindia_option['download_catalog_url']; ?>" >
                    <span><img src="<?php echo esc_url( $repindia_option['download_catalog_icon']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>"></span>
                    <?php echo $repindia_option['download_catalog_title']; ?>
                </a>
            </div>
        <?php } 
        if ( isset($repindia_option['warranty_icon']['url']) && !empty($repindia_option['warranty_icon']['url']) ){ ?>  
            <div class="quick_catalog">
                <a href="<?php echo $repindia_option['warranty_url']; ?>" >
                    <span><img src="<?php echo esc_url( $repindia_option['warranty_icon']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>"></span>
                    <?php echo $repindia_option['warranty_title']; ?>
                </a>
            </div>
        <?php } 
        if ( isset($repindia_option['quick_enquiry_icon']['url']) && !empty($repindia_option['quick_enquiry_icon']['url']) ){ ?> 
            <div class="floating_enquiry_btn mobile_view">
                <button><span><img src="<?php echo esc_url( $repindia_option['quick_enquiry_icon']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>"></span>
                <?php echo $repindia_option['quick_enquiry_title']; ?></button>
            </div>
        <?php
        } 
        if ( isset($repindia_option['partner_icon']['url']) && !empty($repindia_option['partner_icon']['url']) ){ ?>  
            <div class="quick_catalog">
                <a href="tel:<?php echo $repindia_option['partner_url']; ?>" >
                    <span><img src="<?php echo esc_url( $repindia_option['partner_icon']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>"></span>
                    <?php echo $repindia_option['partner_title']; ?>
                </a>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<!-- <div id="viewportdiv" class="viewportdiv"> -->
<div id="mrg-head" class="mrg-head">
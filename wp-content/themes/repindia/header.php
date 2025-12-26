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

<head class="is-smooth-scroll-compatible is-loading" lang="en"">
	<meta charset=" <?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="overlay"></div>
    <div id="content-wrapper" class="main-container">
        <header class="main_header">
            <div class="custom-container">
                <nav>

                    <div class="left-sidemenu">
                        <li class="burger-icon">
                        <a href="javascript:void(0)"><img class="icon-sun" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/dark_menu.svg" alt="Hamburger Menu"> <img class="icon-moon" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/hamburger.svg" alt="Hamburger Menu"></a>
                        </li>
                        <div class="toggle-menu-container">
                            <div class="inside-menu-container-inner">
                                <div class="cross_icon">
                                    <a href="javascript:void(0)"><img class="" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/x.svg" alt="X Menu"></a>
                                </div>
                                <?php
                                if (has_nav_menu('header-toggle-menu')) {
                                    wp_nav_menu(
                                        array(
                                            'menu_id' => 'header-toggle-menu',
                                            'theme_location' => 'header-toggle-menu',
                                            'container'      => false,
                                            'depth'          => 2,
                                            // 'link_after'          => '<span class="caret"><i class="fa fa-arrow-down"></i></span>',
                                            'menu_class'     => 'toggle-menu'
                                        )
                                    );
                                }
                                ?>

                                <ul class="rightmenu_statictxt">
                                    <li>
                                        <h4>Not sure where to start?</h4>
                                        <p>Our experts can answer your questions and help you select the right products for your organization.</p>
                                        <div class="expert_btn">
                                            <a href="<?php echo esc_url(home_url('/')); ?>" class="theme-btn-white border-btn-grey">Talk to our expert</a>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="listing-inner">
                                            <h4>Learn more about</h4>
                                            <ul>
                                                <li>
                                                    <a href="<?php echo esc_url(home_url('/')); ?>">
                                                        <span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/customer.svg" alt="Customer Stories"></span> <span class="span-text">Our customer stories</span></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo esc_url(home_url('/')); ?>">
                                                        <span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/partner.svg" alt="Partner and Integration Hub"></span> <span class="span-text">Partner and integration hub</span></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo esc_url(home_url('/')); ?>">
                                                        <span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/device.svg" alt="supported Device"></span> <span class="span-text">Supported device</span></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo esc_url(home_url('/')); ?>">
                                                        <span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/hardware.svg" alt="Calculate Hardware Sizing"></span> <span class="span-text">Calculate hardware sizing</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>

                                <ul class="social_media_links">
                                    <li>
                                        <a class="cursor-auto" href="javascript:void(0)">
                                            Follow us on
                                        </a>
                                        <a href="<?php echo esc_url(home_url('/')); ?>">
                                            <span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/linkdin.svg" alt="LinkedIn"></span>
                                            <small>LinkedIn</small>
                                        </a>
                                        <a href="<?php echo esc_url(home_url('/')); ?>">
                                            <span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/youtube.svg" alt="YouTube"></span>
                                            <small>YouTube</small>
                                        </a>
                                    </li>
                                </ul>
                            </div>


                        </div>
                        <ul class="logo-wdth">
                            <li>
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <span><img class="lightlogo" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/logo.svg" alt="Logo"><img class="darklogo" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/darklogo.svg" alt="Logo"></span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="main_nav_menu">
                        <?php
                        if (has_nav_menu('repindia-primary')) {
                            wp_nav_menu(
                                array(
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
                            <li>
                                <a class="theme-btn " href="<?php echo esc_url(home_url('/')); ?>" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    Book a demo
                                </a>
                            </li>
                            <li class="lang_switch">
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/flag.svg" alt="flag"></span>
                                </a>
                            </li>
                            <li class="search_switch">
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/search.svg" alt="Search"></span>
                                </a>
                            </li>
                            <li class="theme_switch">
                                <a class="dark-mode-toggle">
                                    <!-- Sun icon - shown in dark mode -->
                                    <svg class="icon-sun" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" >
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9992 2.11121C11.4902 2.11121 11.8881 2.50918 11.8881 3.00009V3.88898C11.8881 4.3799 11.4902 4.77787 10.9992 4.77787C10.5083 4.77787 10.1104 4.3799 10.1104 3.88898V3.00009C10.1104 2.50918 10.5083 2.11121 10.9992 2.11121ZM4.71385 4.7147C5.06098 4.36757 5.62379 4.36757 5.97092 4.7147L6.59946 5.34324C6.9466 5.69037 6.9466 6.25319 6.59946 6.60032C6.25233 6.94745 5.68952 6.94745 5.34238 6.60032L4.71385 5.97178C4.36671 5.62465 4.36671 5.06183 4.71385 4.7147ZM17.2847 4.71475C17.6318 5.06188 17.6318 5.62469 17.2847 5.97183L16.6561 6.60037C16.309 6.9475 15.7462 6.9475 15.3991 6.60037C15.0519 6.25323 15.0519 5.69042 15.3991 5.34329L16.0276 4.71475C16.3747 4.36762 16.9375 4.36762 17.2847 4.71475ZM10.9992 8.33343C9.52648 8.33343 8.33257 9.52733 8.33257 11.0001C8.33257 12.4729 9.52648 13.6668 10.9992 13.6668C12.472 13.6668 13.6659 12.4729 13.6659 11.0001C13.6659 9.52733 12.472 8.33343 10.9992 8.33343ZM6.5548 11.0001C6.5548 8.54549 8.54464 6.55565 10.9992 6.55565C13.4538 6.55565 15.4437 8.54549 15.4437 11.0001C15.4437 13.4547 13.4538 15.4445 10.9992 15.4445C8.54464 15.4445 6.5548 13.4547 6.5548 11.0001ZM2.11035 11.0001C2.11035 10.5092 2.50832 10.1112 2.99924 10.1112H3.88813C4.37905 10.1112 4.77702 10.5092 4.77702 11.0001C4.77702 11.491 4.37905 11.889 3.88813 11.889H2.99924C2.50832 11.889 2.11035 11.491 2.11035 11.0001ZM17.2215 11.0001C17.2215 10.5092 17.6194 10.1112 18.1103 10.1112H18.9992C19.4902 10.1112 19.8881 10.5092 19.8881 11.0001C19.8881 11.491 19.4902 11.889 18.9992 11.889H18.1103C17.6194 11.889 17.2215 11.491 17.2215 11.0001ZM15.399 15.3999C15.7461 15.0527 16.309 15.0527 16.6561 15.3999L17.2846 16.0284C17.6318 16.3755 17.6318 16.9384 17.2846 17.2855C16.9375 17.6326 16.3747 17.6326 16.0276 17.2855L15.399 16.6569C15.0519 16.3098 15.0519 15.747 15.399 15.3999ZM5.34243 15.3999C5.68957 15.0528 6.25238 15.0528 6.59951 15.3999C6.94664 15.747 6.94664 16.3099 6.59951 16.657L5.97097 17.2855C5.62384 17.6327 5.06103 17.6327 4.71389 17.2855C4.36676 16.9384 4.36676 16.3756 4.71389 16.0285L5.34243 15.3999ZM10.9992 17.2223C11.4902 17.2223 11.8881 17.6203 11.8881 18.1112V19.0001C11.8881 19.491 11.4902 19.889 10.9992 19.889C10.5083 19.889 10.1104 19.491 10.1104 19.0001V18.1112C10.1104 17.6203 10.5083 17.2223 10.9992 17.2223Z" fill="#D7DBE4" />
                                    </svg>
                                    <!-- Moon icon - shown in light mode -->
                                    <svg class="icon-moon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.6463 7.94556C13.8981 8.19736 13.9753 8.57513 13.8425 8.90555C13.5139 9.72335 13.3326 10.6172 13.3326 11.5556C13.3326 15.483 16.5163 18.6667 20.4437 18.6667C21.3821 18.6667 22.2759 18.4854 23.0937 18.1568C23.4241 18.024 23.8019 18.1012 24.0537 18.353C24.3055 18.6048 24.3827 18.9826 24.25 19.313C22.9371 22.5799 19.7389 24.8889 15.9992 24.8889C11.09 24.8889 7.11035 20.9092 7.11035 16C7.11035 12.2604 9.41943 9.06217 12.6863 7.74932C13.0167 7.61653 13.3945 7.69375 13.6463 7.94556ZM11.6309 10.3882C9.96101 11.69 8.88813 13.7204 8.88813 16C8.88813 19.9274 12.0719 23.1111 15.9992 23.1111C18.2789 23.1111 20.3092 22.0383 21.611 20.3684C21.2288 20.4186 20.8392 20.4445 20.4437 20.4445C15.5345 20.4445 11.5548 16.4648 11.5548 11.5556C11.5548 11.1601 11.5807 10.7704 11.6309 10.3882Z" fill="#5F6F94" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <?php if (isset($repindia_option['floating_quickaccess']) && $repindia_option['floating_quickaccess'] == 1) { ?>
            <div id="quickaccess_view" class="quickaccess_view">
                <?php
                if (isset($repindia_option['download_catalog_icon']['url']) && !empty($repindia_option['download_catalog_icon']['url'])) { ?>
                    <div class="quick_catalog">
                        <a href="<?php echo $repindia_option['download_catalog_url']; ?>">
                            <span><img src="<?php echo esc_url($repindia_option['download_catalog_icon']['url']); ?>" alt="<?php bloginfo('name'); ?>"></span>
                            <?php echo $repindia_option['download_catalog_title']; ?>
                        </a>
                    </div>
                <?php }
                if (isset($repindia_option['warranty_icon']['url']) && !empty($repindia_option['warranty_icon']['url'])) { ?>
                    <div class="quick_catalog">
                        <a href="<?php echo $repindia_option['warranty_url']; ?>">
                            <span><img src="<?php echo esc_url($repindia_option['warranty_icon']['url']); ?>" alt="<?php bloginfo('name'); ?>"></span>
                            <?php echo $repindia_option['warranty_title']; ?>
                        </a>
                    </div>
                <?php }
                if (isset($repindia_option['quick_enquiry_icon']['url']) && !empty($repindia_option['quick_enquiry_icon']['url'])) { ?>
                    <div class="floating_enquiry_btn mobile_view">
                        <button><span><img src="<?php echo esc_url($repindia_option['quick_enquiry_icon']['url']); ?>" alt="<?php bloginfo('name'); ?>"></span>
                            <?php echo $repindia_option['quick_enquiry_title']; ?></button>
                    </div>
                <?php
                }
                if (isset($repindia_option['partner_icon']['url']) && !empty($repindia_option['partner_icon']['url'])) { ?>
                    <div class="quick_catalog">
                        <a href="tel:<?php echo $repindia_option['partner_url']; ?>">
                            <span><img src="<?php echo esc_url($repindia_option['partner_icon']['url']); ?>" alt="<?php bloginfo('name'); ?>"></span>
                            <?php echo $repindia_option['partner_title']; ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <!-- <div id="viewportdiv" class="viewportdiv"> -->
        <div id="mrg-head" class="mrg-head">
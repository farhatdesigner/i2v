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
                                    
                                        <?php
                                        // Display hamburger editor content
                                        if (!empty($repindia_option['hamburger_editor'])) {
                                            echo wp_kses_post($repindia_option['hamburger_editor']);
                                        } ?>
                                        <?php
                                        if( isset($repindia_option['hamburger_demo_btn']) && $repindia_option['hamburger_demo_btn'] == 1)
                                        { ?>
                                        <div class="expert_btn">
                                            <a href="<?php echo esc_attr($repindia_option['hamburger_btn_url']); ?>" class="theme-btn-white border-btn-grey"><?php echo esc_html__( 'Talk to our expert', 'repindia' ); ?></a>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </li>

                                    <li>
                                        <div class="listing-inner">
                                            <h4><?php echo esc_html__( 'Learn more about', 'repindia' ); ?></h4>
                                            <ul>
                                                <?php
                                                // Display 4 menu items
                                                for ($i = 1; $i <= 4; $i++) {
                                                    $icon = isset($repindia_option['hamburger_menu_item_' . $i . '_icon']) ? $repindia_option['hamburger_menu_item_' . $i . '_icon'] : '';
                                                    $title = isset($repindia_option['hamburger_menu_item_' . $i . '_title']) ? trim($repindia_option['hamburger_menu_item_' . $i . '_title']) : '';
                                                    $url = isset($repindia_option['hamburger_menu_item_' . $i . '_url']) ? trim($repindia_option['hamburger_menu_item_' . $i . '_url']) : '#';
                                                    
                                                    // Get icon URL
                                                    $icon_url = '';
                                                    if (!empty($icon)) {
                                                        if (is_array($icon) && !empty($icon['url'])) {
                                                            $icon_url = $icon['url'];
                                                        } elseif (is_array($icon) && !empty($icon['id'])) {
                                                            $icon_url = wp_get_attachment_image_url($icon['id'], 'full');
                                                        } elseif (is_numeric($icon)) {
                                                            $icon_url = wp_get_attachment_image_url($icon, 'full');
                                                        }
                                                    }
                                                    
                                                    // Only display if we have at least title or icon
                                                    if (!empty($title) || !empty($icon_url)) {
                                                ?>
                                                <li>
                                                    <a href="<?php echo esc_url($url); ?>">
                                                        <?php if (!empty($icon_url)) : ?>
                                                            <span><img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($title); ?>"></span>
                                                        <?php endif; ?>
                                                        <?php if (!empty($title)) : ?>
                                                            <span class="span-text"><?php echo esc_html($title); ?></span>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>

                                <?php
                                    // Check if social media is enabled
                                    $enable_social = isset($repindia_option['enable_social']) && $repindia_option['enable_social'] == 1;
                                    $hamburger_social = isset($repindia_option['hamburger_social']) && $repindia_option['hamburger_social'] == 1;
                                    
                                    
                                    // Get LinkedIn data
                                    $linkedin_icon = isset($repindia_option['linkedin_icon']) ? $repindia_option['linkedin_icon'] : '';
                                    $linkedin_url = isset($repindia_option['linkedin-value']) ? trim($repindia_option['linkedin-value']) : '';
                                    
                                    // Get YouTube data
                                    $youtube_icon = isset($repindia_option['youtube_icon']) ? $repindia_option['youtube_icon'] : '';
                                    $youtube_url = isset($repindia_option['youtube-value']) ? trim($repindia_option['youtube-value']) : '';
                                    
                                    // Get LinkedIn icon URL
                                    $linkedin_icon_url = '';
                                    if (!empty($linkedin_icon)) {
                                        if (is_array($linkedin_icon) && !empty($linkedin_icon['url'])) {
                                            $linkedin_icon_url = $linkedin_icon['url'];
                                        } elseif (is_array($linkedin_icon) && !empty($linkedin_icon['id'])) {
                                            $linkedin_icon_url = wp_get_attachment_image_url($linkedin_icon['id'], 'full');
                                        } elseif (is_numeric($linkedin_icon)) {
                                            $linkedin_icon_url = wp_get_attachment_image_url($linkedin_icon, 'full');
                                        }
                                    }
                                    // Fallback to default icon if no custom icon uploaded
                                    if (empty($linkedin_icon_url)) {
                                        $linkedin_icon_url = get_template_directory_uri() . '/assets/images/icons/linkdin.svg';
                                    }
                                    
                                    // Get YouTube icon URL
                                    $youtube_icon_url = '';
                                    if (!empty($youtube_icon)) {
                                        if (is_array($youtube_icon) && !empty($youtube_icon['url'])) {
                                            $youtube_icon_url = $youtube_icon['url'];
                                        } elseif (is_array($youtube_icon) && !empty($youtube_icon['id'])) {
                                            $youtube_icon_url = wp_get_attachment_image_url($youtube_icon['id'], 'full');
                                        } elseif (is_numeric($youtube_icon)) {
                                            $youtube_icon_url = wp_get_attachment_image_url($youtube_icon, 'full');
                                        }
                                    }
                                    // Fallback to default icon if no custom icon uploaded
                                    if (empty($youtube_icon_url)) {
                                        $youtube_icon_url = get_template_directory_uri() . '/assets/images/icons/youtube.svg';
                                    }
                                    
                                    // Only show if social media is enabled and at least one URL is provided
                                    if ($enable_social && $hamburger_social && (!empty($linkedin_url) || !empty($youtube_url))) {
                                ?>
                                <ul class="social_media_links">
                                    <li>
                                    <?php if (!empty($repindia_option['social_media_title'])){ ?>
                                        <a class="cursor-auto" href="javascript:void(0)">
                                            <?php echo esc_attr($repindia_option['social_media_title']); ?>
                                        </a>
                                        <?php } ?>
                                        <?php if (!empty($linkedin_url)) : ?>
                                        <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank">
                                            <span><img src="<?php echo esc_url($linkedin_icon_url); ?>" alt="LinkedIn"></span>
                                            <small><?php echo esc_attr($repindia_option['linkedin_title']); ?></small>
                                        </a>
                                        <?php endif; ?>
                                        <?php if (!empty($youtube_url)) : ?>
                                        <a href="<?php echo esc_url($youtube_url); ?>" target="_blank">
                                            <span><img src="<?php echo esc_url($youtube_icon_url); ?>" alt="YouTube"></span>
                                            <small><?php echo esc_attr($repindia_option['youtube_title']); ?></small>
                                        </a>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                                <?php
                                    }
                                
                                ?>
                            </div>


                        </div>
                        <ul class="logo-wdth">
                            <li>
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <span>
                                    <?php if ( isset($repindia_option['light_theme_logo']['url']) && !empty($repindia_option['light_theme_logo']['url']) ){ ?>
                                        <img class="lightlogo" src="<?php echo esc_url( $repindia_option['light_theme_logo']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" >
                                        <?php 
                                    } ?>
                                    <?php if ( isset($repindia_option['dark_theme_logo']['url']) && !empty($repindia_option['dark_theme_logo']['url']) ){ ?>
                                        <img class="darklogo" src="<?php echo esc_url( $repindia_option['dark_theme_logo']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                                        <?php 
                                    } ?>
                                    </span>
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
                            <?php
                            if( isset($repindia_option['header_demo_btn']) && $repindia_option['header_demo_btn'] == 1)
                            { ?>
                                <li>
                                    <a class="theme-btn " href="<?php echo esc_attr($repindia_option['demo_btn_url']); ?>" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <?php echo esc_html__( 'Request a demo', 'repindia' ); ?>
                                    </a>
                                </li>
                                <?php 
                            } ?>
                            <?php
                            if( isset($repindia_option['langauge_btn_switch']) && $repindia_option['langauge_btn_switch'] == 1)
                            { ?>
                                <li class="lang_switch">
                                    <a href="<?php echo esc_url(home_url('/')); ?>">
                                        <span><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/flag.svg" alt="flag"></span>
                                    </a>
                                </li>
                                <?php 
                            } ?>
                            <?php
                            if( isset($repindia_option['search_btn_switch']) && $repindia_option['search_btn_switch'] == 1)
                            { ?>
                                <li class="search_switch">
                                    <a href="javascript:void(0)" class="search-popup-trigger" aria-label="Search">
                                        <span>
                                            <img class="white-theme-img" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/search.svg" alt="Search">
                                            <img class="black-theme-img" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/search_black.svg" alt="Search">
                                        </span>
                                    </a>
                                </li>
                                <?php 
                            } ?>
                            <?php
                            if( isset($repindia_option['theme_switch_btn']) && $repindia_option['theme_switch_btn'] == 1)
                            { ?>
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
                            <?php 
                            } ?>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        
        <!-- Search Popup -->
        <div id="search-popup" class="search-popup-overlay">
            <div class="search-popup-container">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-popup-form" autocomplete="off">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.73 20.44L18.1 16.81C21.27 12.93 20.69 7.20997 16.81 4.03997C12.93 0.879974 7.22 1.44997 4.05 5.32997C0.880004 9.20997 1.46 14.93 5.34 18.1C8.68 20.83 13.48 20.83 16.82 18.1L20.45 21.73C20.8 22.09 21.38 22.09 21.73 21.73C22.09 21.38 22.09 20.8 21.73 20.45V20.44ZM11.11 18.37C7.1 18.37 3.85 15.12 3.85 11.11C3.85 7.09997 7.1 3.84997 11.11 3.84997C15.12 3.84997 18.37 7.09997 18.37 11.11C18.37 15.12 15.12 18.37 11.11 18.37Z" fill="currentColor"/>
                        </svg>
                        <input type="text" name="s" class="search-popup-input" placeholder="Search" autocomplete="off" required>
                        <button type="button" class="search-popup-close" aria-label="Close search">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <?php
                        if( isset($repindia_option['theme_switch_btn']) && $repindia_option['theme_switch_btn'] == 1)
                        { ?>
                            <a class="dark-mode-toggle search-popup-theme-toggle">
                                <!-- Sun icon - shown in dark mode -->
                                <svg class="icon-sun" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" >
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.9992 2.11121C11.4902 2.11121 11.8881 2.50918 11.8881 3.00009V3.88898C11.8881 4.3799 11.4902 4.77787 10.9992 4.77787C10.5083 4.77787 10.1104 4.3799 10.1104 3.88898V3.00009C10.1104 2.50918 10.5083 2.11121 10.9992 2.11121ZM4.71385 4.7147C5.06098 4.36757 5.62379 4.36757 5.97092 4.7147L6.59946 5.34324C6.9466 5.69037 6.9466 6.25319 6.59946 6.60032C6.25233 6.94745 5.68952 6.94745 5.34238 6.60032L4.71385 5.97178C4.36671 5.62465 4.36671 5.06183 4.71385 4.7147ZM17.2847 4.71475C17.6318 5.06188 17.6318 5.62469 17.2847 5.97183L16.6561 6.60037C16.309 6.9475 15.7462 6.9475 15.3991 6.60037C15.0519 6.25323 15.0519 5.69042 15.3991 5.34329L16.0276 4.71475C16.3747 4.36762 16.9375 4.36762 17.2847 4.71475ZM10.9992 8.33343C9.52648 8.33343 8.33257 9.52733 8.33257 11.0001C8.33257 12.4729 9.52648 13.6668 10.9992 13.6668C12.472 13.6668 13.6659 12.4729 13.6659 11.0001C13.6659 9.52733 12.472 8.33343 10.9992 8.33343ZM6.5548 11.0001C6.5548 8.54549 8.54464 6.55565 10.9992 6.55565C13.4538 6.55565 15.4437 8.54549 15.4437 11.0001C15.4437 13.4547 13.4538 15.4445 10.9992 15.4445C8.54464 15.4445 6.5548 13.4547 6.5548 11.0001ZM2.11035 11.0001C2.11035 10.5092 2.50832 10.1112 2.99924 10.1112H3.88813C4.37905 10.1112 4.77702 10.5092 4.77702 11.0001C4.77702 11.491 4.37905 11.889 3.88813 11.889H2.99924C2.50832 11.889 2.11035 11.491 2.11035 11.0001ZM17.2215 11.0001C17.2215 10.5092 17.6194 10.1112 18.1103 10.1112H18.9992C19.4902 10.1112 19.8881 10.5092 19.8881 11.0001C19.8881 11.491 19.4902 11.889 18.9992 11.889H18.1103C17.6194 11.889 17.2215 11.491 17.2215 11.0001ZM15.399 15.3999C15.7461 15.0527 16.309 15.0527 16.6561 15.3999L17.2846 16.0284C17.6318 16.3755 17.6318 16.9384 17.2846 17.2855C16.9375 17.6326 16.3747 17.6326 16.0276 17.2855L15.399 16.6569C15.0519 16.3098 15.0519 15.747 15.399 15.3999ZM5.34243 15.3999C5.68957 15.0528 6.25238 15.0528 6.59951 15.3999C6.94664 15.747 6.94664 16.3099 6.59951 16.657L5.97097 17.2855C5.62384 17.6327 5.06103 17.6327 4.71389 17.2855C4.36676 16.9384 4.36676 16.3756 4.71389 16.0285L5.34243 15.3999ZM10.9992 17.2223C11.4902 17.2223 11.8881 17.6203 11.8881 18.1112V19.0001C11.8881 19.491 11.4902 19.889 10.9992 19.889C10.5083 19.889 10.1104 19.491 10.1104 19.0001V18.1112C10.1104 17.6203 10.5083 17.2223 10.9992 17.2223Z" fill="#D7DBE4" />
                                </svg>
                                <!-- Moon icon - shown in light mode -->
                                <svg class="icon-moon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.6463 7.94556C13.8981 8.19736 13.9753 8.57513 13.8425 8.90555C13.5139 9.72335 13.3326 10.6172 13.3326 11.5556C13.3326 15.483 16.5163 18.6667 20.4437 18.6667C21.3821 18.6667 22.2759 18.4854 23.0937 18.1568C23.4241 18.024 23.8019 18.1012 24.0537 18.353C24.3055 18.6048 24.3827 18.9826 24.25 19.313C22.9371 22.5799 19.7389 24.8889 15.9992 24.8889C11.09 24.8889 7.11035 20.9092 7.11035 16C7.11035 12.2604 9.41943 9.06217 12.6863 7.74932C13.0167 7.61653 13.3945 7.69375 13.6463 7.94556ZM11.6309 10.3882C9.96101 11.69 8.88813 13.7204 8.88813 16C8.88813 19.9274 12.0719 23.1111 15.9992 23.1111C18.2789 23.1111 20.3092 22.0383 21.611 20.3684C21.2288 20.4186 20.8392 20.4445 20.4437 20.4445C15.5345 20.4445 11.5548 16.4648 11.5548 11.5556C11.5548 11.1601 11.5807 10.7704 11.6309 10.3882Z" fill="#5F6F94" />
                                </svg>
                            </a>
                        <?php 
                        } ?>
                    </div>
                </form>
                <div class="search-popup-content">
                    <div class="search-popup-columns">
                        <div class="search-popup-column">
                            <h4 class="search-popup-heading">Recent search</h4>
                            <ul class="search-popup-list" id="recent-searches-list">
                                <!-- Populated by JavaScript -->
                            </ul>
                        </div>
                        <div class="search-popup-column">
                            <h4 class="search-popup-heading">Popular search</h4>
                            <ul class="search-popup-list" id="popular-searches-list">
                                <!-- Populated by AJAX -->
                            </ul>
                        </div>
                    </div>
                    <div class="search-popup-footer">
                        <!-- <a href="<?php //echo esc_url($repindia_option['demo_btn_url'] ?? '#'); ?>" class="search-popup-link">Request a demo</a> -->
                        <?php
                        if( isset($repindia_option['header_demo_btn']) && $repindia_option['header_demo_btn'] == 1)
                        { ?>
                            <a class="theme-btn " href="<?php echo esc_attr($repindia_option['demo_btn_url']); ?>" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <?php echo esc_html__( 'Request a demo', 'repindia' ); ?>
                            </a>
                            <?php 
                        } ?>
                        <!-- <span class="search-popup-separator">•</span>
                        <a href="<?php //echo esc_url(home_url('/i2vs-products/')); ?>" class="search-popup-link">Explore our products</a>
                        <span class="search-popup-separator">•</span>
                        <a href="<?php //echo esc_url(home_url('/contact/')); ?>" class="search-popup-link">Contact us</a> -->
                        <?php
                        if (has_nav_menu('search-menu')) {
                            wp_nav_menu(
                                array(
                                    'menu_id' => 'header-main-menu',
                                    'theme_location' => 'search-menu',
                                    'container'      => false,
                                    'depth'          => 1,
                                    'menu_class'     => 'menu'
                                )
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <div id="viewportdiv" class="viewportdiv"> -->
        <div id="mrg-head" class="mrg-head">
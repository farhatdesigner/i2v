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
                                    <a href="javascript:void(0)">
                                        <img class="icon-moon" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/closemenu-light.svg" alt="X Menu">
                                        <img class="icon-sun" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icons/darkclose-menu.svg" alt="X Menu">
                                    </a>
                                </div>
                                <?php
                                if (has_nav_menu('header-toggle-menu')) {
                                    wp_nav_menu(
                                        array(
                                            'menu_id' => 'header-toggle-menu',
                                            'theme_location' => 'header-toggle-menu',
                                            'container' => false,
                                            'depth' => 2,
                                            'menu_class' => 'toggle-menu'
                                        )
                                    );
                                }
                                ?>

                                <ul class="rightmenu_statictxt">
                                    <li class="hamburger_right_desc_box">

                                        <?php
                                        // Display hamburger editor content
                                        if (!empty($repindia_option['hamburger_editor'])) {
                                            echo wp_kses_post($repindia_option['hamburger_editor']);
                                        } ?>
                                        <?php
                                        if (isset($repindia_option['hamburger_demo_btn']) && $repindia_option['hamburger_demo_btn'] == 1) { ?>
                                            <div class="expert_btn">
                                                <a href="javascript:void(0)"
                                                    class="theme-btn-white border-btn-grey" data-modal-target="contactBackdrop"><?php echo esc_html( wpml_t( 'Talk to our expert', 'Repindia-Template', 'Header expert button Text' ) ); ?></a>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </li>

                                    <li>
                                        <div class="listing-inner">
                                            <h4><?php echo esc_html( wpml_t( 'Learn more about', 'Repindia-Template', 'Header hamburger box title' ) ); ?></h4>
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
                                                                <?php if (!empty($icon_url)): ?>
                                                                    <span><img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($title); ?>"></span>
                                                                <?php endif; ?>
                                                                <?php if (!empty($title)): ?>
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
                                            <?php if (!empty($repindia_option['social_media_title'])) { ?>
                                                <a class="cursor-auto" href="javascript:void(0)">
                                                    <?php echo esc_attr($repindia_option['social_media_title']); ?>
                                                </a>
                                            <?php } ?>
                                            <?php if (!empty($linkedin_url)): ?>
                                                <a href="<?php echo esc_url($linkedin_url); ?>" target="_blank">
                                                    <span><img src="<?php echo esc_url($linkedin_icon_url); ?>"
                                                            alt="LinkedIn"></span>
                                                    <small><?php echo esc_attr($repindia_option['linkedin_title']); ?></small>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($youtube_url)): ?>
                                                <a href="<?php echo esc_url($youtube_url); ?>" target="_blank">
                                                    <span><img src="<?php echo esc_url($youtube_icon_url); ?>"
                                                            alt="YouTube"></span>
                                                    <small><?php echo esc_attr($repindia_option['youtube_title']); ?></small>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                        <li class="mobile_search_theme_switch">
                                        <?php
                                            if (isset($repindia_option['search_btn_switch']) && $repindia_option['search_btn_switch'] == 1) { ?>
                                                
                                                    <a href="javascript:void(0)" class="search-popup-trigger" aria-label="Search">
                                                        <!-- <span> -->
                                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg"><path d="M18.6662 19.5556C18.4351 19.5556 18.2129 19.4667 18.0351 19.2978L13.244 14.5067C12.0351 15.4401 10.524 16.0001 8.88845 16.0001C4.96846 16.0001 1.77734 12.8089 1.77734 8.88894C1.77734 4.96894 4.96846 1.77783 8.88845 1.77783C12.8085 1.77783 15.9996 4.96894 15.9996 8.88894C15.9996 10.5334 15.4396 12.0445 14.5062 13.2445L19.2973 18.0356C19.644 18.3823 19.644 18.9423 19.2973 19.2889C19.1196 19.4667 18.8973 19.5467 18.6662 19.5467V19.5556ZM8.88845 3.55561C5.94623 3.55561 3.55512 5.94672 3.55512 8.88894C3.55512 11.8312 5.94623 14.2223 8.88845 14.2223C11.8307 14.2223 14.2218 11.8312 14.2218 8.88894C14.2218 5.94672 11.8307 3.55561 8.88845 3.55561Z" fill="#5F6F94" /></svg>
                                                        <!-- </span> -->
                                                    </a>
                                                <?php
                                            } ?>
                                            <?php
                                            if (isset($repindia_option['theme_switch_btn']) && $repindia_option['theme_switch_btn'] == 1) { ?>
                                                    <a class="dark-mode-toggle">
                                                        <svg class="icon-sun" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.6662 1.77783C11.1572 1.77783 11.5551 2.1758 11.5551 2.66672V3.55561C11.5551 4.04653 11.1572 4.4445 10.6662 4.4445C10.1753 4.4445 9.77734 4.04653 9.77734 3.55561V2.66672C9.77734 2.1758 10.1753 1.77783 10.6662 1.77783ZM4.38084 4.38133C4.72797 4.03419 5.29078 4.03419 5.63792 4.38133L6.26646 5.00987C6.61359 5.357 6.61359 5.91981 6.26646 6.26694C5.91932 6.61408 5.35651 6.61408 5.00938 6.26694L4.38084 5.63841C4.03371 5.29127 4.03371 4.72846 4.38084 4.38133ZM16.9517 4.38137C17.2988 4.72851 17.2988 5.29132 16.9517 5.63845L16.3231 6.26699C15.976 6.61413 15.4132 6.61413 15.0661 6.26699C14.7189 5.91986 14.7189 5.35705 15.0661 5.00991L15.6946 4.38137C16.0417 4.03424 16.6045 4.03424 16.9517 4.38137ZM10.6662 8.00005C9.19347 8.00005 7.99957 9.19396 7.99957 10.6667C7.99957 12.1395 9.19347 13.3334 10.6662 13.3334C12.139 13.3334 13.3329 12.1395 13.3329 10.6667C13.3329 9.19396 12.139 8.00005 10.6662 8.00005ZM6.22179 10.6667C6.22179 8.21212 8.21163 6.22228 10.6662 6.22228C13.1208 6.22228 15.1107 8.21212 15.1107 10.6667C15.1107 13.1213 13.1208 15.1112 10.6662 15.1112C8.21163 15.1112 6.22179 13.1213 6.22179 10.6667ZM1.77734 10.6667C1.77734 10.1758 2.17531 9.77783 2.66623 9.77783H3.55512C4.04604 9.77783 4.44401 10.1758 4.44401 10.6667C4.44401 11.1576 4.04604 11.5556 3.55512 11.5556H2.66623C2.17531 11.5556 1.77734 11.1576 1.77734 10.6667ZM16.8885 10.6667C16.8885 10.1758 17.2864 9.77783 17.7773 9.77783H18.6662C19.1572 9.77783 19.5551 10.1758 19.5551 10.6667C19.5551 11.1576 19.1572 11.5556 18.6662 11.5556H17.7773C17.2864 11.5556 16.8885 11.1576 16.8885 10.6667ZM15.066 15.0665C15.4131 14.7194 15.976 14.7194 16.3231 15.0665L16.9516 15.695C17.2988 16.0422 17.2988 16.605 16.9516 16.9521C16.6045 17.2992 16.0417 17.2992 15.6945 16.9521L15.066 16.3236C14.7189 15.9764 14.7189 15.4136 15.066 15.0665ZM5.00943 15.0665C5.35656 14.7194 5.91937 14.7194 6.2665 15.0665C6.61364 15.4137 6.61364 15.9765 6.2665 16.3236L5.63796 16.9522C5.29083 17.2993 4.72802 17.2993 4.38089 16.9522C4.03375 16.605 4.03375 16.0422 4.38089 15.6951L5.00943 15.0665ZM10.6662 16.8889C11.1572 16.8889 11.5551 17.2869 11.5551 17.7778V18.6667C11.5551 19.1576 11.1572 19.5556 10.6662 19.5556C10.1753 19.5556 9.77734 19.1576 9.77734 18.6667V17.7778C9.77734 17.2869 10.1753 16.8889 10.6662 16.8889Z" fill="#D7DBE4" /></svg>
                                                        <svg class="icon-moon" width="22" height="22" viewBox="0 0 22 22" fill="none"  xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.31327 2.61218C8.56507 2.86398 8.6423 3.24176 8.50951 3.57218C8.18086 4.38998 7.99957 5.28384 7.99957 6.22222C7.99957 10.1496 11.1833 13.3333 15.1107 13.3333C16.0491 13.3333 16.9429 13.152 17.7607 12.8234C18.0911 12.6906 18.4689 12.7678 18.7207 13.0196C18.9725 13.2714 19.0497 13.6492 18.917 13.9796C17.6041 17.2465 14.4059 19.5556 10.6662 19.5556C5.75703 19.5556 1.77734 15.5759 1.77734 10.6667C1.77734 6.927 4.08642 3.7288 7.35328 2.41594C7.6837 2.28316 8.06147 2.36038 8.31327 2.61218ZM6.29786 5.05486C4.628 6.35666 3.55512 8.38699 3.55512 10.6667C3.55512 14.594 6.73887 17.7778 10.6662 17.7778C12.9459 17.7778 14.9762 16.7049 16.278 15.035C15.8958 15.0852 15.5061 15.1111 15.1107 15.1111C10.2015 15.1111 6.22179 11.1314 6.22179 6.22222C6.22179 5.82675 6.24767 5.43707 6.29786 5.05486Z" fill="#5F6F94" /></svg>
                                                    </a>
                                                
                                                <?php
                                            } ?>
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
                                        <?php if (isset($repindia_option['light_theme_logo']['url']) && !empty($repindia_option['light_theme_logo']['url'])) { ?>
                                            <img class="lightlogo"
                                                src="<?php echo esc_url($repindia_option['light_theme_logo']['url']); ?>"
                                                alt="<?php bloginfo('name'); ?>">
                                            <?php
                                        } ?>
                                        <?php if (isset($repindia_option['dark_theme_logo']['url']) && !empty($repindia_option['dark_theme_logo']['url'])) { ?>
                                            <img class="darklogo"
                                                src="<?php echo esc_url($repindia_option['dark_theme_logo']['url']); ?>"
                                                alt="<?php bloginfo('name'); ?>">
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
                                    'container' => false,
                                    'depth' => 2,
                                    'link_after' => '<span class="caret"><i class="fa fa-arrow-down"></i></span>',
                                    'menu_class' => 'menu'
                                )
                            );
                        }
                        ?>
                        <ul class="header-right-box">
                            <?php
                            if (isset($repindia_option['header_demo_btn']) && $repindia_option['header_demo_btn'] == 1) { ?>
                                <li>
                                    <a class="theme-btn " href="<?php echo esc_attr($repindia_option['demo_btn_url']); ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop"><?php echo esc_html( wpml_t( 'Request a demo', 'Repindia-Template', 'Header demo button Text' ) ); ?></a>
                                </li>
                                <?php
                            } ?>
                            <?php
                            if (isset($repindia_option['langauge_btn_switch']) && $repindia_option['langauge_btn_switch'] == 1) { ?>
                                <li class="lang_switch">
                                    <?php do_action('wpml_add_language_selector'); ?>
                                </li>
                                <?php
                            } ?>
                            <?php
                            if (isset($repindia_option['search_btn_switch']) && $repindia_option['search_btn_switch'] == 1) { ?>
                                <li class="search_switch">
                                    <a href="javascript:void(0)" class="search-popup-trigger" aria-label="Search">
                                        <span>
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                xmlns="http://www.w3.org/2000/svg"><path d="M18.6662 19.5556C18.4351 19.5556 18.2129 19.4667 18.0351 19.2978L13.244 14.5067C12.0351 15.4401 10.524 16.0001 8.88845 16.0001C4.96846 16.0001 1.77734 12.8089 1.77734 8.88894C1.77734 4.96894 4.96846 1.77783 8.88845 1.77783C12.8085 1.77783 15.9996 4.96894 15.9996 8.88894C15.9996 10.5334 15.4396 12.0445 14.5062 13.2445L19.2973 18.0356C19.644 18.3823 19.644 18.9423 19.2973 19.2889C19.1196 19.4667 18.8973 19.5467 18.6662 19.5467V19.5556ZM8.88845 3.55561C5.94623 3.55561 3.55512 5.94672 3.55512 8.88894C3.55512 11.8312 5.94623 14.2223 8.88845 14.2223C11.8307 14.2223 14.2218 11.8312 14.2218 8.88894C14.2218 5.94672 11.8307 3.55561 8.88845 3.55561Z" fill="#5F6F94" /></svg>
                                        </span>
                                    </a>
                                </li>
                                <?php
                            } ?>
                            <?php
                            if (isset($repindia_option['theme_switch_btn']) && $repindia_option['theme_switch_btn'] == 1) { ?>
                                <li class="theme_switch">
                                    <a class="dark-mode-toggle">
                                        <svg class="icon-sun" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.6662 1.77783C11.1572 1.77783 11.5551 2.1758 11.5551 2.66672V3.55561C11.5551 4.04653 11.1572 4.4445 10.6662 4.4445C10.1753 4.4445 9.77734 4.04653 9.77734 3.55561V2.66672C9.77734 2.1758 10.1753 1.77783 10.6662 1.77783ZM4.38084 4.38133C4.72797 4.03419 5.29078 4.03419 5.63792 4.38133L6.26646 5.00987C6.61359 5.357 6.61359 5.91981 6.26646 6.26694C5.91932 6.61408 5.35651 6.61408 5.00938 6.26694L4.38084 5.63841C4.03371 5.29127 4.03371 4.72846 4.38084 4.38133ZM16.9517 4.38137C17.2988 4.72851 17.2988 5.29132 16.9517 5.63845L16.3231 6.26699C15.976 6.61413 15.4132 6.61413 15.0661 6.26699C14.7189 5.91986 14.7189 5.35705 15.0661 5.00991L15.6946 4.38137C16.0417 4.03424 16.6045 4.03424 16.9517 4.38137ZM10.6662 8.00005C9.19347 8.00005 7.99957 9.19396 7.99957 10.6667C7.99957 12.1395 9.19347 13.3334 10.6662 13.3334C12.139 13.3334 13.3329 12.1395 13.3329 10.6667C13.3329 9.19396 12.139 8.00005 10.6662 8.00005ZM6.22179 10.6667C6.22179 8.21212 8.21163 6.22228 10.6662 6.22228C13.1208 6.22228 15.1107 8.21212 15.1107 10.6667C15.1107 13.1213 13.1208 15.1112 10.6662 15.1112C8.21163 15.1112 6.22179 13.1213 6.22179 10.6667ZM1.77734 10.6667C1.77734 10.1758 2.17531 9.77783 2.66623 9.77783H3.55512C4.04604 9.77783 4.44401 10.1758 4.44401 10.6667C4.44401 11.1576 4.04604 11.5556 3.55512 11.5556H2.66623C2.17531 11.5556 1.77734 11.1576 1.77734 10.6667ZM16.8885 10.6667C16.8885 10.1758 17.2864 9.77783 17.7773 9.77783H18.6662C19.1572 9.77783 19.5551 10.1758 19.5551 10.6667C19.5551 11.1576 19.1572 11.5556 18.6662 11.5556H17.7773C17.2864 11.5556 16.8885 11.1576 16.8885 10.6667ZM15.066 15.0665C15.4131 14.7194 15.976 14.7194 16.3231 15.0665L16.9516 15.695C17.2988 16.0422 17.2988 16.605 16.9516 16.9521C16.6045 17.2992 16.0417 17.2992 15.6945 16.9521L15.066 16.3236C14.7189 15.9764 14.7189 15.4136 15.066 15.0665ZM5.00943 15.0665C5.35656 14.7194 5.91937 14.7194 6.2665 15.0665C6.61364 15.4137 6.61364 15.9765 6.2665 16.3236L5.63796 16.9522C5.29083 17.2993 4.72802 17.2993 4.38089 16.9522C4.03375 16.605 4.03375 16.0422 4.38089 15.6951L5.00943 15.0665ZM10.6662 16.8889C11.1572 16.8889 11.5551 17.2869 11.5551 17.7778V18.6667C11.5551 19.1576 11.1572 19.5556 10.6662 19.5556C10.1753 19.5556 9.77734 19.1576 9.77734 18.6667V17.7778C9.77734 17.2869 10.1753 16.8889 10.6662 16.8889Z" fill="#D7DBE4" /></svg>
                                        <svg class="icon-moon" width="22" height="22" viewBox="0 0 22 22" fill="none"  xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.31327 2.61218C8.56507 2.86398 8.6423 3.24176 8.50951 3.57218C8.18086 4.38998 7.99957 5.28384 7.99957 6.22222C7.99957 10.1496 11.1833 13.3333 15.1107 13.3333C16.0491 13.3333 16.9429 13.152 17.7607 12.8234C18.0911 12.6906 18.4689 12.7678 18.7207 13.0196C18.9725 13.2714 19.0497 13.6492 18.917 13.9796C17.6041 17.2465 14.4059 19.5556 10.6662 19.5556C5.75703 19.5556 1.77734 15.5759 1.77734 10.6667C1.77734 6.927 4.08642 3.7288 7.35328 2.41594C7.6837 2.28316 8.06147 2.36038 8.31327 2.61218ZM6.29786 5.05486C4.628 6.35666 3.55512 8.38699 3.55512 10.6667C3.55512 14.594 6.73887 17.7778 10.6662 17.7778C12.9459 17.7778 14.9762 16.7049 16.278 15.035C15.8958 15.0852 15.5061 15.1111 15.1107 15.1111C10.2015 15.1111 6.22179 11.1314 6.22179 6.22222C6.22179 5.82675 6.24767 5.43707 6.29786 5.05486Z" fill="#5F6F94" /></svg>
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
        <div class="headersearch_section">
            <div id="search-popup" class="search-popup-overlay">
                <div class="custom-container">
                    <div class="search-popup-container">
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>"
                            class="search-popup-form" autocomplete="off">
                            <div class="search-input-wrapper">
                                <svg class="search-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.73 20.44L18.1 16.81C21.27 12.93 20.69 7.20997 16.81 4.03997C12.93 0.879974 7.22 1.44997 4.05 5.32997C0.880004 9.20997 1.46 14.93 5.34 18.1C8.68 20.83 13.48 20.83 16.82 18.1L20.45 21.73C20.8 22.09 21.38 22.09 21.73 21.73C22.09 21.38 22.09 20.8 21.73 20.45V20.44ZM11.11 18.37C7.1 18.37 3.85 15.12 3.85 11.11C3.85 7.09997 7.1 3.84997 11.11 3.84997C15.12 3.84997 18.37 7.09997 18.37 11.11C18.37 15.12 15.12 18.37 11.11 18.37Z" fill="currentColor" /></svg>
                                <input type="text" name="s" class="search-popup-input" placeholder="<?php echo esc_html( wpml_t( 'Search', 'Repindia-Template', 'Header search placeholder' ) ); ?>" autocomplete="off" required>
                                <button type="button" class="search-popup-close" aria-label="Close search">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.58 4.57909C4.99656 4.16253 5.67193 4.16253 6.08849 4.57909L10.6676 9.15817L15.2467 4.57909C15.6632 4.16253 16.3386 4.16253 16.7552 4.57909C17.1717 4.99565 17.1717 5.67102 16.7552 6.08758L12.1761 10.6667L16.7552 15.2458C17.1717 15.6623 17.1717 16.3377 16.7552 16.7542C16.3386 17.1708 15.6632 17.1708 15.2467 16.7542L10.6676 12.1752L6.08849 16.7542C5.67193 17.1708 4.99656 17.1708 4.58 16.7542C4.16344 16.3377 4.16344 15.6623 4.58 15.2458L9.15908 10.6667L4.58 6.08758C4.16344 5.67102 4.16344 4.99565 4.58 4.57909Z" fill="#5F6F94" /></svg>
                                </button>
                                <?php
                                if (isset($repindia_option['theme_switch_btn']) && $repindia_option['theme_switch_btn'] == 1) { ?>
                                    <a class="dark-mode-toggle search-popup-theme-toggle">
                                        <svg class="icon-sun" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.6662 1.77783C11.1572 1.77783 11.5551 2.1758 11.5551 2.66672V3.55561C11.5551 4.04653 11.1572 4.4445 10.6662 4.4445C10.1753 4.4445 9.77734 4.04653 9.77734 3.55561V2.66672C9.77734 2.1758 10.1753 1.77783 10.6662 1.77783ZM4.38084 4.38133C4.72797 4.03419 5.29078 4.03419 5.63792 4.38133L6.26646 5.00987C6.61359 5.357 6.61359 5.91981 6.26646 6.26694C5.91932 6.61408 5.35651 6.61408 5.00938 6.26694L4.38084 5.63841C4.03371 5.29127 4.03371 4.72846 4.38084 4.38133ZM16.9517 4.38137C17.2988 4.72851 17.2988 5.29132 16.9517 5.63845L16.3231 6.26699C15.976 6.61413 15.4132 6.61413 15.0661 6.26699C14.7189 5.91986 14.7189 5.35705 15.0661 5.00991L15.6946 4.38137C16.0417 4.03424 16.6045 4.03424 16.9517 4.38137ZM10.6662 8.00005C9.19347 8.00005 7.99957 9.19396 7.99957 10.6667C7.99957 12.1395 9.19347 13.3334 10.6662 13.3334C12.139 13.3334 13.3329 12.1395 13.3329 10.6667C13.3329 9.19396 12.139 8.00005 10.6662 8.00005ZM6.22179 10.6667C6.22179 8.21212 8.21163 6.22228 10.6662 6.22228C13.1208 6.22228 15.1107 8.21212 15.1107 10.6667C15.1107 13.1213 13.1208 15.1112 10.6662 15.1112C8.21163 15.1112 6.22179 13.1213 6.22179 10.6667ZM1.77734 10.6667C1.77734 10.1758 2.17531 9.77783 2.66623 9.77783H3.55512C4.04604 9.77783 4.44401 10.1758 4.44401 10.6667C4.44401 11.1576 4.04604 11.5556 3.55512 11.5556H2.66623C2.17531 11.5556 1.77734 11.1576 1.77734 10.6667ZM16.8885 10.6667C16.8885 10.1758 17.2864 9.77783 17.7773 9.77783H18.6662C19.1572 9.77783 19.5551 10.1758 19.5551 10.6667C19.5551 11.1576 19.1572 11.5556 18.6662 11.5556H17.7773C17.2864 11.5556 16.8885 11.1576 16.8885 10.6667ZM15.066 15.0665C15.4131 14.7194 15.976 14.7194 16.3231 15.0665L16.9516 15.695C17.2988 16.0422 17.2988 16.605 16.9516 16.9521C16.6045 17.2992 16.0417 17.2992 15.6945 16.9521L15.066 16.3236C14.7189 15.9764 14.7189 15.4136 15.066 15.0665ZM5.00943 15.0665C5.35656 14.7194 5.91937 14.7194 6.2665 15.0665C6.61364 15.4137 6.61364 15.9765 6.2665 16.3236L5.63796 16.9522C5.29083 17.2993 4.72802 17.2993 4.38089 16.9522C4.03375 16.605 4.03375 16.0422 4.38089 15.6951L5.00943 15.0665ZM10.6662 16.8889C11.1572 16.8889 11.5551 17.2869 11.5551 17.7778V18.6667C11.5551 19.1576 11.1572 19.5556 10.6662 19.5556C10.1753 19.5556 9.77734 19.1576 9.77734 18.6667V17.7778C9.77734 17.2869 10.1753 16.8889 10.6662 16.8889Z" fill="#D7DBE4" /></svg>
                                        <svg class="icon-moon" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.31327 2.61218C8.56507 2.86398 8.6423 3.24176 8.50951 3.57218C8.18086 4.38998 7.99957 5.28384 7.99957 6.22222C7.99957 10.1496 11.1833 13.3333 15.1107 13.3333C16.0491 13.3333 16.9429 13.152 17.7607 12.8234C18.0911 12.6906 18.4689 12.7678 18.7207 13.0196C18.9725 13.2714 19.0497 13.6492 18.917 13.9796C17.6041 17.2465 14.4059 19.5556 10.6662 19.5556C5.75703 19.5556 1.77734 15.5759 1.77734 10.6667C1.77734 6.927 4.08642 3.7288 7.35328 2.41594C7.6837 2.28316 8.06147 2.36038 8.31327 2.61218ZM6.29786 5.05486C4.628 6.35666 3.55512 8.38699 3.55512 10.6667C3.55512 14.594 6.73887 17.7778 10.6662 17.7778C12.9459 17.7778 14.9762 16.7049 16.278 15.035C15.8958 15.0852 15.5061 15.1111 15.1107 15.1111C10.2015 15.1111 6.22179 11.1314 6.22179 6.22222C6.22179 5.82675 6.24767 5.43707 6.29786 5.05486Z" fill="#5F6F94" /></svg>
                                    </a>
                                    <?php
                                } ?>
                            </div>
                        </form>
                        <div class="search-popup-content">
                            <div class="search-popup-columns">
                                <div class="search-popup-column">
                                    <h4 class="search-popup-heading"><?php echo esc_html( wpml_t( 'Recent search', 'Repindia-Template', 'Header recent search title' ) ); ?></h4>
                                    <ul class="search-popup-list" id="recent-searches-list">
                                        <!-- Populated by JavaScript -->
                                    </ul>
                                </div>
                                <div class="search-popup-column">
                                    <h4 class="search-popup-heading"><?php echo esc_html( wpml_t( 'Popular search', 'Repindia-Template', 'Header popular search title' ) ); ?></h4>
                                    <ul class="search-popup-list" id="popular-searches-list">
                                        <!-- Populated by AJAX -->
                                    </ul>
                                </div>
                            </div>
                            <div class="search-popup-footer">
                                <?php
                                if (isset($repindia_option['header_demo_btn']) && $repindia_option['header_demo_btn'] == 1) { ?>
                                    <a class="btn-demo open-demo-modal" href="<?php echo esc_attr($repindia_option['demo_btn_url']); ?>" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <?php echo esc_html( wpml_t( 'Request a demo', 'Repindia-Template', 'Header search demo Text' ) ); ?>
                                    </a>
                                    <?php
                                } 
                                if (has_nav_menu('search-menu')) {
                                    wp_nav_menu(
                                        array(
                                            'menu_id' => 'header-main-menu',
                                            'theme_location' => 'search-menu',
                                            'container' => false,
                                            'depth' => 1,
                                            'menu_class' => 'menu'
                                        )
                                    );
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div id="viewportdiv" class="viewportdiv"> -->
        <div id="mrg-head" class="mrg-head">
<?php
		global $repindia_option; 
		$backStyle = '';
		$backStyle = repindia_backgroundstyle('footer_bg');
		$backStyle = implode('', $backStyle);
		?>
		<div class="footer" style="<?php echo esc_attr($backStyle); ?>">
		    <div class="container">
		        <div class="row">
				    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 footer_menu_logo_box">
						<?php
						if(isset($repindia_option['footer_logo']['url'] ) && !empty($repindia_option['footer_logo']['url']))
						{   ?>  
							<a class="footer_logo_anc" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="footer_logo_img" src="<?php echo esc_url( $repindia_option['footer_logo']['url'] ); ?>" title="Logo of Phoenix repindia - Ultra luxury apartments in Bangalore" alt="<?php bloginfo( 'name' ); ?>"></a>
						<?php 
						}else{ ?>
							<a class="footer_logo_anc" href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo_name"><?php bloginfo( 'name' ); ?></a>
						<?php 
						}   ?>
						<?php
		            	if(!empty($repindia_option['footer_sort_desc']))
		            	{ ?>
		                   <p class="footer_short_desc"> <?php echo esc_attr($repindia_option['footer_sort_desc']); ?></p>
		                <?php
		                } ?>
						<?php
		            	if(!empty($repindia_option['footer_contact_title']))
		            	{ ?>
		                    <h5 class="footer_contact_title"><?php echo esc_attr($repindia_option['footer_contact_title']); ?></h5>
		                <?php
		                } ?>
						<?php
		            	if(!empty($repindia_option['footer_contact_addrr_icon']['url']))
		            	{ ?>
						    <div class="footer_contact_num">
							<img class="footer_logo_img" src="<?php echo esc_url( $repindia_option['footer_contact_addrr_icon']['url'] ); ?>" title="Address" alt="Address">
							<p><?php echo esc_attr($repindia_option['footer_contact_addrr']); ?></p>
							</div>
		                <?php
		                } ?>
						<?php
		            	if(!empty($repindia_option['footer_contact_phn_con']['url']))
		            	{ ?>
						    <div class="footer_contact_num">
							<img class="footer_logo_img" src="<?php echo esc_url( $repindia_option['footer_contact_phn_con']['url'] ); ?>" title="Address" alt="Address">
							<p><a href="tel:<?php echo esc_attr($repindia_option['footer_contact_phn']); ?>"><?php echo esc_attr($repindia_option['footer_contact_phn']); ?></a></p>
							</div>
		                <?php
		                } ?>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 footer_menu_box">
					    <ul class="footer_menu_ul_col">
							<div class="footer_menu_col">
								<?php
								if(!empty($repindia_option['footer_main_menu_title']))
								{ ?>
									<h4><?php echo esc_attr($repindia_option['footer_main_menu_title']); ?> <svg class="plusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12.3784 6.54508H7.45508V1.62175C7.45508 1.37091 7.25091 1.16675 7.00008 1.16675C6.74925 1.16675 6.54508 1.37091 6.54508 1.62175V6.54508H1.62175C1.37091 6.54508 1.16675 6.74925 1.16675 7.00008C1.16675 7.25091 1.37091 7.45508 1.62175 7.45508H6.54508V12.3784C6.54508 12.6292 6.74925 12.8334 7.00008 12.8334C7.25091 12.8334 7.45508 12.6292 7.45508 12.3784V7.45508H12.3784C12.6292 7.45508 12.8334 7.25091 12.8334 7.00008C12.8334 6.74925 12.6292 6.54508 12.3784 6.54508Z" fill="black"/></svg><svg class="minusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1.62175 6.54492C1.37091 6.54492 1.16675 6.74909 1.16675 6.99992C1.16675 7.25076 1.37091 7.45492 1.62175 7.45492H12.3784C12.6292 7.45492 12.8334 7.25076 12.8334 6.99992C12.8334 6.74909 12.6292 6.54492 12.3784 6.54492H1.62175Z" fill="black"/></svg></h4>
								<?php
								}
								if ( has_nav_menu( 'footer-main-menu' ) )
								{
									wp_nav_menu(
										array(
											'theme_location' => 'footer-main-menu',
											'container'      => false,
											'depth'          => 1,
											'after'          => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
											<path d="M8.16074 7.60663L3.96074 11.8008C3.72741 12.0341 3.72741 12.4191 3.96074 12.6525C4.07157 12.7633 4.22907 12.8275 4.38657 12.8275C4.53824 12.8275 4.69574 12.7691 4.81241 12.6525L10.0391 7.42579C10.2724 7.19246 10.2724 6.80746 10.0391 6.57413L4.81824 1.35329C4.58491 1.11413 4.20574 1.10829 3.96657 1.33579C3.72741 1.56329 3.72157 1.94829 3.94907 2.18746C3.94907 2.18746 3.96074 2.19913 3.96657 2.20496L8.16074 6.39913L8.74407 6.99996L8.16074 7.60663Z" fill="black"/>
											</svg>',
											'menu_class'     => 'links'
										)
									); 
								} ?>
							</div>
							<div class="footer_menu_col">
								<?php 
								if(!empty($repindia_option['footer_brand_menu_title']))
								{
								?>
									<h4><?php echo esc_attr($repindia_option['footer_brand_menu_title']); ?><svg class="plusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12.3784 6.54508H7.45508V1.62175C7.45508 1.37091 7.25091 1.16675 7.00008 1.16675C6.74925 1.16675 6.54508 1.37091 6.54508 1.62175V6.54508H1.62175C1.37091 6.54508 1.16675 6.74925 1.16675 7.00008C1.16675 7.25091 1.37091 7.45508 1.62175 7.45508H6.54508V12.3784C6.54508 12.6292 6.74925 12.8334 7.00008 12.8334C7.25091 12.8334 7.45508 12.6292 7.45508 12.3784V7.45508H12.3784C12.6292 7.45508 12.8334 7.25091 12.8334 7.00008C12.8334 6.74925 12.6292 6.54508 12.3784 6.54508Z" fill="black"/></svg><svg class="minusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1.62175 6.54492C1.37091 6.54492 1.16675 6.74909 1.16675 6.99992C1.16675 7.25076 1.37091 7.45492 1.62175 7.45492H12.3784C12.6292 7.45492 12.8334 7.25076 12.8334 6.99992C12.8334 6.74909 12.6292 6.54492 12.3784 6.54492H1.62175Z" fill="black"/></svg></h4>
								<?php
								}
								if ( has_nav_menu( 'footer-brand-menu' ) )
								{
									wp_nav_menu(
										array(
											'theme_location' => 'footer-brand-menu',
											'container'      => false,
											'depth'          => 1,
											'after'          => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
											<path d="M8.16074 7.60663L3.96074 11.8008C3.72741 12.0341 3.72741 12.4191 3.96074 12.6525C4.07157 12.7633 4.22907 12.8275 4.38657 12.8275C4.53824 12.8275 4.69574 12.7691 4.81241 12.6525L10.0391 7.42579C10.2724 7.19246 10.2724 6.80746 10.0391 6.57413L4.81824 1.35329C4.58491 1.11413 4.20574 1.10829 3.96657 1.33579C3.72741 1.56329 3.72157 1.94829 3.94907 2.18746C3.94907 2.18746 3.96074 2.19913 3.96657 2.20496L8.16074 6.39913L8.74407 6.99996L8.16074 7.60663Z" fill="black"/>
											</svg>',
											'menu_class'     => 'links'
										)
									); 
								} ?>
							</div>
							<div class="footer_menu_col" style="display: none;">
								<?php
								if(!empty($repindia_option['footer_news_menu_title']))
								{
								?>
								<h4><?php echo esc_attr($repindia_option['footer_news_menu_title']); ?><svg class="plusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12.3784 6.54508H7.45508V1.62175C7.45508 1.37091 7.25091 1.16675 7.00008 1.16675C6.74925 1.16675 6.54508 1.37091 6.54508 1.62175V6.54508H1.62175C1.37091 6.54508 1.16675 6.74925 1.16675 7.00008C1.16675 7.25091 1.37091 7.45508 1.62175 7.45508H6.54508V12.3784C6.54508 12.6292 6.74925 12.8334 7.00008 12.8334C7.25091 12.8334 7.45508 12.6292 7.45508 12.3784V7.45508H12.3784C12.6292 7.45508 12.8334 7.25091 12.8334 7.00008C12.8334 6.74925 12.6292 6.54508 12.3784 6.54508Z" fill="black"/></svg><svg class="minusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1.62175 6.54492C1.37091 6.54492 1.16675 6.74909 1.16675 6.99992C1.16675 7.25076 1.37091 7.45492 1.62175 7.45492H12.3784C12.6292 7.45492 12.8334 7.25076 12.8334 6.99992C12.8334 6.74909 12.6292 6.54492 12.3784 6.54492H1.62175Z" fill="black"/></svg></h4>
								<?php
								}
								if ( has_nav_menu( 'footer-news-menu' ) )
								{
									wp_nav_menu(
										array(
											'theme_location' => 'footer-news-menu',
											'container'      => false,
											'depth'          => 1,
											'after'          => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
											<path d="M8.16074 7.60663L3.96074 11.8008C3.72741 12.0341 3.72741 12.4191 3.96074 12.6525C4.07157 12.7633 4.22907 12.8275 4.38657 12.8275C4.53824 12.8275 4.69574 12.7691 4.81241 12.6525L10.0391 7.42579C10.2724 7.19246 10.2724 6.80746 10.0391 6.57413L4.81824 1.35329C4.58491 1.11413 4.20574 1.10829 3.96657 1.33579C3.72741 1.56329 3.72157 1.94829 3.94907 2.18746C3.94907 2.18746 3.96074 2.19913 3.96657 2.20496L8.16074 6.39913L8.74407 6.99996L8.16074 7.60663Z" fill="black"/>
											</svg>',
											'menu_class'     => 'links'
										)
									); 
								} ?>
							</div>
							<div class="footer_menu_col">
								<?php
								if(!empty($repindia_option['footer_service_menu_title']))
								{
								?>
								<h4><?php echo esc_attr($repindia_option['footer_service_menu_title']); ?><svg class="plusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12.3784 6.54508H7.45508V1.62175C7.45508 1.37091 7.25091 1.16675 7.00008 1.16675C6.74925 1.16675 6.54508 1.37091 6.54508 1.62175V6.54508H1.62175C1.37091 6.54508 1.16675 6.74925 1.16675 7.00008C1.16675 7.25091 1.37091 7.45508 1.62175 7.45508H6.54508V12.3784C6.54508 12.6292 6.74925 12.8334 7.00008 12.8334C7.25091 12.8334 7.45508 12.6292 7.45508 12.3784V7.45508H12.3784C12.6292 7.45508 12.8334 7.25091 12.8334 7.00008C12.8334 6.74925 12.6292 6.54508 12.3784 6.54508Z" fill="black"/></svg><svg class="minusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1.62175 6.54492C1.37091 6.54492 1.16675 6.74909 1.16675 6.99992C1.16675 7.25076 1.37091 7.45492 1.62175 7.45492H12.3784C12.6292 7.45492 12.8334 7.25076 12.8334 6.99992C12.8334 6.74909 12.6292 6.54492 12.3784 6.54492H1.62175Z" fill="black"/></svg></h4>
								<?php
								}
								if ( has_nav_menu( 'footer-service-menu' ) )
								{
									wp_nav_menu(
										array(
											'theme_location' => 'footer-service-menu',
											'container'      => false,
											'depth'          => 1,
											'after'          => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
											<path d="M8.16074 7.60663L3.96074 11.8008C3.72741 12.0341 3.72741 12.4191 3.96074 12.6525C4.07157 12.7633 4.22907 12.8275 4.38657 12.8275C4.53824 12.8275 4.69574 12.7691 4.81241 12.6525L10.0391 7.42579C10.2724 7.19246 10.2724 6.80746 10.0391 6.57413L4.81824 1.35329C4.58491 1.11413 4.20574 1.10829 3.96657 1.33579C3.72741 1.56329 3.72157 1.94829 3.94907 2.18746C3.94907 2.18746 3.96074 2.19913 3.96657 2.20496L8.16074 6.39913L8.74407 6.99996L8.16074 7.60663Z" fill="black"/>
											</svg>',
											'menu_class'     => 'links'
										)
									); 
								} ?>
							</div>
							<div class="footer_menu_col">
								<?php
								if(!empty($repindia_option['footer_gallery_menu_title']))
								{
								?>
								<h4><?php echo esc_attr($repindia_option['footer_gallery_menu_title']); ?><svg class="plusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12.3784 6.54508H7.45508V1.62175C7.45508 1.37091 7.25091 1.16675 7.00008 1.16675C6.74925 1.16675 6.54508 1.37091 6.54508 1.62175V6.54508H1.62175C1.37091 6.54508 1.16675 6.74925 1.16675 7.00008C1.16675 7.25091 1.37091 7.45508 1.62175 7.45508H6.54508V12.3784C6.54508 12.6292 6.74925 12.8334 7.00008 12.8334C7.25091 12.8334 7.45508 12.6292 7.45508 12.3784V7.45508H12.3784C12.6292 7.45508 12.8334 7.25091 12.8334 7.00008C12.8334 6.74925 12.6292 6.54508 12.3784 6.54508Z" fill="black"/></svg><svg class="minusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1.62175 6.54492C1.37091 6.54492 1.16675 6.74909 1.16675 6.99992C1.16675 7.25076 1.37091 7.45492 1.62175 7.45492H12.3784C12.6292 7.45492 12.8334 7.25076 12.8334 6.99992C12.8334 6.74909 12.6292 6.54492 12.3784 6.54492H1.62175Z" fill="black"/></svg></h4>
								<?php
								}
								if ( has_nav_menu( 'footer-gallery-menu' ) )
								{
									wp_nav_menu(
										array(
											'theme_location' => 'footer-gallery-menu',
											'container'      => false,
											'depth'          => 1,
											'after'          => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
											<path d="M8.16074 7.60663L3.96074 11.8008C3.72741 12.0341 3.72741 12.4191 3.96074 12.6525C4.07157 12.7633 4.22907 12.8275 4.38657 12.8275C4.53824 12.8275 4.69574 12.7691 4.81241 12.6525L10.0391 7.42579C10.2724 7.19246 10.2724 6.80746 10.0391 6.57413L4.81824 1.35329C4.58491 1.11413 4.20574 1.10829 3.96657 1.33579C3.72741 1.56329 3.72157 1.94829 3.94907 2.18746C3.94907 2.18746 3.96074 2.19913 3.96657 2.20496L8.16074 6.39913L8.74407 6.99996L8.16074 7.60663Z" fill="black"/>
											</svg>',
											'menu_class'     => 'links'
										)
									); 
								} ?>
							</div>
							<div class="footer_menu_col resource_nav_mob">
								<?php
								if(!empty($repindia_option['footer_resource_menu_title']))
								{
								?>
								<h4><?php echo esc_attr($repindia_option['footer_resource_menu_title']); ?><svg class="plusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12.3784 6.54508H7.45508V1.62175C7.45508 1.37091 7.25091 1.16675 7.00008 1.16675C6.74925 1.16675 6.54508 1.37091 6.54508 1.62175V6.54508H1.62175C1.37091 6.54508 1.16675 6.74925 1.16675 7.00008C1.16675 7.25091 1.37091 7.45508 1.62175 7.45508H6.54508V12.3784C6.54508 12.6292 6.74925 12.8334 7.00008 12.8334C7.25091 12.8334 7.45508 12.6292 7.45508 12.3784V7.45508H12.3784C12.6292 7.45508 12.8334 7.25091 12.8334 7.00008C12.8334 6.74925 12.6292 6.54508 12.3784 6.54508Z" fill="black"/></svg><svg class="minusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1.62175 6.54492C1.37091 6.54492 1.16675 6.74909 1.16675 6.99992C1.16675 7.25076 1.37091 7.45492 1.62175 7.45492H12.3784C12.6292 7.45492 12.8334 7.25076 12.8334 6.99992C12.8334 6.74909 12.6292 6.54492 12.3784 6.54492H1.62175Z" fill="black"/></svg></h4>
								<?php
								}
								if ( has_nav_menu( 'footer-resource-menu' ) )
								{
									wp_nav_menu(
										array(
											'theme_location' => 'footer-resource-menu',
											'container'      => false,
											'depth'          => 1,
											'after'          => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
											<path d="M8.16074 7.60663L3.96074 11.8008C3.72741 12.0341 3.72741 12.4191 3.96074 12.6525C4.07157 12.7633 4.22907 12.8275 4.38657 12.8275C4.53824 12.8275 4.69574 12.7691 4.81241 12.6525L10.0391 7.42579C10.2724 7.19246 10.2724 6.80746 10.0391 6.57413L4.81824 1.35329C4.58491 1.11413 4.20574 1.10829 3.96657 1.33579C3.72741 1.56329 3.72157 1.94829 3.94907 2.18746C3.94907 2.18746 3.96074 2.19913 3.96657 2.20496L8.16074 6.39913L8.74407 6.99996L8.16074 7.60663Z" fill="black"/>
											</svg>',
											'menu_class'     => 'links'
										)
									); 
								} ?>
							</div>
						</ul>
		            </div>
					<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 footer_menu_resource_box resource_nav_desk">
						<?php 
						if(!empty($repindia_option['footer_resource_menu_title']))
						{
						?>
						<h4><?php echo esc_attr($repindia_option['footer_resource_menu_title']); ?><svg class="plusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12.3784 6.54508H7.45508V1.62175C7.45508 1.37091 7.25091 1.16675 7.00008 1.16675C6.74925 1.16675 6.54508 1.37091 6.54508 1.62175V6.54508H1.62175C1.37091 6.54508 1.16675 6.74925 1.16675 7.00008C1.16675 7.25091 1.37091 7.45508 1.62175 7.45508H6.54508V12.3784C6.54508 12.6292 6.74925 12.8334 7.00008 12.8334C7.25091 12.8334 7.45508 12.6292 7.45508 12.3784V7.45508H12.3784C12.6292 7.45508 12.8334 7.25091 12.8334 7.00008C12.8334 6.74925 12.6292 6.54508 12.3784 6.54508Z" fill="black"/></svg><svg class="minusicon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1.62175 6.54492C1.37091 6.54492 1.16675 6.74909 1.16675 6.99992C1.16675 7.25076 1.37091 7.45492 1.62175 7.45492H12.3784C12.6292 7.45492 12.8334 7.25076 12.8334 6.99992C12.8334 6.74909 12.6292 6.54492 12.3784 6.54492H1.62175Z" fill="black"/></svg></h4>
						<?php
						}
						if ( has_nav_menu( 'footer-resource-menu' ) )
						{
							wp_nav_menu(
								array(
									'theme_location' => 'footer-resource-menu',
									'container'      => false,
									'depth'          => 1,
									'after'          => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
											<path d="M8.16074 7.60663L3.96074 11.8008C3.72741 12.0341 3.72741 12.4191 3.96074 12.6525C4.07157 12.7633 4.22907 12.8275 4.38657 12.8275C4.53824 12.8275 4.69574 12.7691 4.81241 12.6525L10.0391 7.42579C10.2724 7.19246 10.2724 6.80746 10.0391 6.57413L4.81824 1.35329C4.58491 1.11413 4.20574 1.10829 3.96657 1.33579C3.72741 1.56329 3.72157 1.94829 3.94907 2.18746C3.94907 2.18746 3.96074 2.19913 3.96657 2.20496L8.16074 6.39913L8.74407 6.99996L8.16074 7.60663Z" fill="black"/>
											</svg>',
									'menu_class'     => 'links'
								)
							); 
						} 
						?>
					</div>
		            
		        </div>
				<?php
				if( isset($repindia_option['footer_copyright_switch']) && $repindia_option['footer_copyright_switch'] == 1){ 
				?>
				<div class="footer_copyright">
					<div class="row">
						<div class="col-md-4 col-xs-12">
							<p><?php echo esc_attr($repindia_option['footer_copyright']); ?></p>
						</div>
						<div class="col-md-4 col-xs-12">
							<?php 
							if ( has_nav_menu( 'footer-sitemap-menu' ) )
							{
								wp_nav_menu(
									array(
										'theme_location' => 'footer-sitemap-menu',
										'container'      => false,
										'depth'          => 1,
										'menu_class'     => 'links'
									)
								); 
							} 
							?>
						</div>
						<div class="col-md-4 col-xs-12">
							<?php
							if( !empty( $repindia_option['enable_social'] ) && isset($repindia_option['footer_social']) && $repindia_option['footer_social'] == 1)
							{ 
								$footer_socials = repindia_get_socials( 'enable_social' ); 
								if ( $footer_socials)
								{ ?>
								<div class="footer_social_section">
								    <p class="footer_text"><?php echo esc_attr($repindia_option['footer_social_title']); ?></p>
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
					</div>
				</div>
			<?php } ?>
		        <!-- </div> -->

		    </div>
		</div> 
		</div>
		</div>
		<!-- </div> -->
		
		<!-- Floating Form -->
		<div class="floating_global_form">
			<div class="floating-form-close">
				<h4>
				<?php echo esc_html__( 'Close', 'repindia' ); ?><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M11.6668 11.2116C11.6668 11.4625 11.4627 11.6666 11.2118 11.6666C11.0893 11.6666 10.9727 11.62 10.891 11.5325L2.46766 3.10913C2.28682 2.92829 2.28682 2.64246 2.46766 2.46746C2.64849 2.28663 2.93432 2.28663 3.10932 2.46746L11.5327 10.8908C11.6202 10.9783 11.6668 11.095 11.6668 11.2116Z" fill="black"/><path d="M11.6668 2.7883C11.6668 2.9108 11.6202 3.02747 11.5327 3.10913L3.10932 11.5325C2.92849 11.7133 2.64266 11.7133 2.46766 11.5325C2.28682 11.3516 2.28682 11.0658 2.46766 10.8908L10.891 2.46747C11.0718 2.28663 11.3577 2.28663 11.5327 2.46747C11.6202 2.55497 11.6668 2.67163 11.6668 2.7883Z" fill="black"/></svg>
				</h4>
			</div>
			<div class="floating_right_box">
				<?php
				echo do_shortcode('[contact-form-7 id="951d8c5" title="Global Enquiry Form"]'); 
				?>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/assets/js/lenis.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/assets/js/gsap.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/assets/js/scrolltrigger.min.js'; ?>"></script>
		<script>
			if (window.innerWidth >= 1180) {
				gsap.registerPlugin(ScrollTrigger);
				ScrollTrigger.config({
					autoRefreshEvents: 'visibilitychange,DOMContentLoaded,load',
				})
				const resize = () => {
					console.log('resize')
					ScrollTrigger.refresh()
				}
				const panels = gsap.utils.toArray(".animate-right");
				const content = gsap.utils.toArray(".animate-left");
				const tl = gsap.timeline({
					scrollTrigger: {
						trigger: ".sectionsscroll",
						start: "top top",
						endTrigger: 'html',
						end: () => "+=" + 200 * panels.length + "%",
						pin: true,
						pinSpacing: true,
						scrub: 1,
						autoRefreshEvents: "load",
					}
				});
				panels.forEach((panel, index) => {
					tl.from(
						panel,
						{
							yPercent: 100,
							ease: "slow",
						},
						"+=0.1"
					);
					tl.from(
						content[index],
						{
							yPercent: 100,
							ease: "slow",
						},
						"<"
					);
				});

			}
			jQuery(document).ready(function ($) {
				if ($(window).width() < 768){
					$(".footer_menu_ul_col > .footer_menu_col > .links").hide();
					$(".footer_menu_ul_col > .footer_menu_col h4").click(function () {
						if ($(this).closest('.footer_menu_col').hasClass("active")) {
							$(this).closest('.footer_menu_col').removeClass("active");
							$(this).closest('.footer_menu_col').find(".links").slideUp();
						} else {
							$(".footer_menu_ul_col > .footer_menu_col.active .links").slideUp();
							$(".footer_menu_ul_col > .footer_menu_col.active").removeClass("active");
							$(this).closest('.footer_menu_col').addClass("active").find(".links").slideDown();
						}
					    return false;
					});
				}
				$(".floating_enquiry_btn button").click(function () {
					if ($(this).closest('.floating_global_form').hasClass("active")) {
						$(this).closest('.floating_global_form').removeClass("active");
						$(".floating_enquiry_btn").show();
					} else {
						$(".floating_enquiry_btn").hide();
						$('.floating_global_form').addClass("active");
					}
					return false;
				});
				$(".floating-form-close h4").click(function () {
					$(this).closest('.floating_global_form').removeClass("active");
					$(".floating_enquiry_btn").show();
					return false;
				});
			});

			if (document.getElementById("partner_img")){
				var windowHeight =  Math.max(document.documentElement.clientHeight, window.innerHeight || 0),
					lastTop;
				window.addEventListener('scroll', function(event) {
				var partner = document.getElementById('partner_img'),
					top = partner.getBoundingClientRect().top,
					offset = top - windowHeight;
					if (offset > 0) {
						partner.classList.remove('partnermove');
						return;
					}
					if (partner.className.indexOf('partnermove') === -1 && top < lastTop) {
						partner.classList.add('partnermove');
					}
					lastTop = top;
					
				});
			}

			const quickAccess = document.getElementById('quickaccess_view');
			quickAccess.style.bottom = '-100%';
			let lastScrollTop = 0;
				window.addEventListener('scroll', function() {
					let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
					if (scrollTop > lastScrollTop) {
						quickAccess.style.bottom = '-100%'; // Adjust the value based on your div's height
					} else {
						quickAccess.style.bottom = '0';
					}
					lastScrollTop = scrollTop;
				});

			const lenis = new Lenis();
			lenis.on("scroll", (e) => {
				console.log(e);
			});
			lenis.on("scroll", ScrollTrigger.update);
			gsap.ticker.add((time) => {
				lenis.raf(time * 500);
			});
			gsap.ticker.lagSmoothing(0);
		</script>
		<?php	
		wp_footer();
		?>
    </body>
</html>



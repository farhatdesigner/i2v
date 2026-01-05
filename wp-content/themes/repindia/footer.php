<?php
global $repindia_option;
?>
<div class="footer">
	<div class="custom-container">
		
			<div class="footer_copyright">
				<div class="row g-0">
					<div class="col-md-3 border-right grid-column4">
						<ul class="p-0 m-0 footer-accordion-menu">
							<li class="footer-accordion-item">
								<h3 class="footer-accordion-title"><?php echo esc_attr($repindia_option['footer_product_title']); ?> <span class="footer-accordion-icon">+</span>
								</h3>
							</li>
							<div class="footer-accordion-content">
								<!-- <li><a href="#">i2V's VMS</a></li>
								<li><a href="#">AI based video analytics / VCA</a></li>
								<li><a href="#">Command and control (ICCC / PSIM)</a></li>
								<li><a href="#">Central monitoring software (CMS)</a></li>
								<li><a href="#">FRS</a></li>
								<li><a href="#">ITMS / ITS</a></li>
								<li><a href="#">VIDS</a></li>
								<li><a href="#">ANPR / LPR</a></li> -->
								<?php
                                if (has_nav_menu('footer-product-menu')) {
                                    wp_nav_menu(
                                        array(
                                            'menu_id' => 'footermenu',
                                            'theme_location' => 'footer-product-menu',
                                            'container'      => false,
                                            'depth'          => 1,
                                            'menu_class'     => 'footer_product'
                                        )
                                    );
                                }
                                ?>
							</div>
						</ul>
					</div>

					<div class="col-md-9">
						<div class="d-flex justify-content-between right-footer-menu">
							<div class="column-4">
								<!-- 		<//?php
										if (has_nav_menu('footer-product-menu')) {
											wp_nav_menu(
												array(
													'menu_id' => '',
													'theme_location' => 'footer-product-menu',
													'container'      => false,
													'depth'          => 2,
													'link_after'          => '<span class="caret"><i class="fa fa-arrow-down"></i></span>',
													'menu_class'     => ''
												)
											);
										}
										?> -->

								<ul class="p-0 m-0 footer-accordion-menu">
									<li class="footer-accordion-item">
										<h3 class="footer-accordion-title"><?php echo esc_attr($repindia_option['footer_industry_title']); ?> <span class="footer-accordion-icon">+</span></h3>
									</li>
									<div class="footer-accordion-content">
										<!-- <li><a href="#">Oil and Gas</a></li>
										<li><a href="#">Energy</a> </li>
										<li><a href="#">Smart cities</a></li>
										<li><a href="#">Transportation</a></li>
										<li><a href="#">Government</a></li>
										<li><a href="#">Retail</a></li>
										<li><a href="#">Education</a></li>
										<li><a href="#">Healthcare</a></li>
										<li><a href="#">Hospitality</a></li>
										<li><a href="#">Financial institutions</a></li> -->
										<?php
										if (has_nav_menu('footer-industry-menu')) {
											wp_nav_menu(
												array(
													'menu_id' => 'footermenu',
													'theme_location' => 'footer-industry-menu',
													'container'      => false,
													'depth'          => 1,
													'menu_class'     => 'footer_industry'
												)
											);
										}
										?>
									</div>
								</ul>
							</div>
							<div class="column-4">
								<ul class="p-0 m-0 footer-accordion-menu">
									<li class="footer-accordion-item">
										<h3 class="footer-accordion-title"><?php echo esc_attr($repindia_option['footer_company_title']); ?> <span class="footer-accordion-icon">+</span></h3>
									</li>
									<div class="footer-accordion-content">
										<?php
										if (has_nav_menu('footer-company-menu')) {
											wp_nav_menu(
												array(
													'menu_id' => 'footermenu',
													'theme_location' => 'footer-company-menu',
													'container'      => false,
													'depth'          => 1,
													'menu_class'     => 'footer_company'
												)
											);
										}
										?>
									</div>
								</ul>
							</div>
							<div class="column-4">
								<ul class="p-0 m-0 footer-accordion-menu">
									<li class="footer-accordion-item">
										<h3 class="footer-accordion-title"><?php echo esc_attr($repindia_option['footer_resource_title']); ?> <span class="footer-accordion-icon">+</span></h3>
									</li>
									<div class="footer-accordion-content">
										<!-- <li><a href="#">Blogs</a></li>
										<li><a href="#">Data sheets</a></li>
										<li><a href="#">Download our free trail software</a></li>
										<li><a href="#">Calculate hardware sizing</a></li>
										<li><a href="#">Help</a></li>
										<li><a href="#">Sitemap</a></li> -->
										<?php
										if (has_nav_menu('footer-resource-menu')) {
											wp_nav_menu(
												array(
													'menu_id' => 'footermenu',
													'theme_location' => 'footer-resource-menu',
													'container'      => false,
													'depth'          => 1,
													'menu_class'     => 'footer_resource'
												)
											);
										}
										?>
									</div>
								</ul>
							</div>
							<div class="column-4">
								<ul class="p-0 m-0 footer-accordion-menu">
									<li class="footer-accordion-item">
										<h3 class="footer-accordion-title"><?php echo esc_attr($repindia_option['footer_legal_title']); ?> <span class="footer-accordion-icon">+</span></h3>
									</li>
									<div class="footer-accordion-content">
										<!-- <li><a href="#">Terms of Service</a></li>
										<li><a href="#">Privacy Policy</a></li>
										<li><a href="#">Cookie Policy</a></li> -->
										<?php
										if (has_nav_menu('footer-legal-menu')) {
											wp_nav_menu(
												array(
													'menu_id' => 'footermenu',
													'theme_location' => 'footer-legal-menu',
													'container'      => false,
													'depth'          => 1,
													'menu_class'     => 'footer_legal'
												)
											);
										}
										?>
									</div>
								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>
		<!-- </div> -->
			<!-- Mobile: logo left, social right | Desktop: left logo -->
				<div class="footer_bottom">
					<div class="row">
						<div class="col-md-12 col-xs-12">
							<p class="d-inline-flex">
								<?php if ( isset($repindia_option['footer_dscl_icon']['url']) && !empty($repindia_option['footer_dscl_icon']['url']) ){ ?>
									<span><img src="<?php echo esc_url( $repindia_option['footer_dscl_icon']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="img-fluid"></span>
								<?php 
								} ?>
								<span class="disclaimer-text">
								<?php 
								if (!empty($repindia_option['footer_disclaimer_desc'])) {
									echo wp_kses_post($repindia_option['footer_disclaimer_desc']);
								}
								?>
								</span>
							</p>
						</div>
					</div>
				</div>



		<div class="footer_bottom_copy">
			<div class="row align-items-center">
					<!-- Mobile: logo left, social right | Desktop: left logo -->
					<?php if ( isset($repindia_option['footer_logo']['url']) && !empty($repindia_option['footer_logo']['url']) ){ ?>
						<div class="col-6 col-md-4 d-flex align-items-center">
							<img src="<?php echo esc_url( $repindia_option['footer_logo']['url'] ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="img-fluid">
						</div>
						<?php 
					} ?>
					<!-- Desktop only: center text -->
					<div class="col-12 order-3 order-md-2 col-md-4 text-center mt-4 mt-md-0">
						<p class="mb-0">
						<?php 
						if (!empty($repindia_option['footer_copyright'])) {
							echo wp_kses_post($repindia_option['footer_copyright']);
						}
						?>
						</p>
					</div>

				<!-- Mobile: right icons | Desktop: right aligned -->
				<?php
				// Check if social media is enabled
				$enable_social = isset($repindia_option['enable_social']) && $repindia_option['enable_social'] == 1;
				$footer_social = isset($repindia_option['footer_social']) && $repindia_option['footer_social'] == 1;
				
				
				// Get LinkedIn data
				$linkedin_footer_icon = isset($repindia_option['linkedin_footer_icon']) ? $repindia_option['linkedin_footer_icon'] : '';
				$linkedin_url = isset($repindia_option['linkedin-value']) ? trim($repindia_option['linkedin-value']) : '';
				
				// Get YouTube data
				$youtube_footer_icon = isset($repindia_option['youtube_footer_icon']) ? $repindia_option['youtube_footer_icon'] : '';
				$youtube_url = isset($repindia_option['youtube-value']) ? trim($repindia_option['youtube-value']) : '';
				
				// Get LinkedIn icon URL
				$linkedin_footer_icon_url = '';
				if (!empty($linkedin_footer_icon)) {
					if (is_array($linkedin_footer_icon) && !empty($linkedin_footer_icon['url'])) {
						$linkedin_footer_icon_url = $linkedin_footer_icon['url'];
					} elseif (is_array($linkedin_footer_icon) && !empty($linkedin_footer_icon['id'])) {
						$linkedin_footer_icon_url = wp_get_attachment_image_url($linkedin_footer_icon['id'], 'full');
					} elseif (is_numeric($linkedin_footer_icon)) {
						$linkedin_footer_icon_url = wp_get_attachment_image_url($linkedin_footer_icon, 'full');
					}
				}
				// Fallback to default icon if no custom icon uploaded
				if (empty($linkedin_footer_icon_url)) {
					$linkedin_footer_icon_url = get_template_directory_uri() . '/assets/images/icons/linkdin.svg';
				}
				
				// Get YouTube icon URL
				$youtube_footer_icon_url = '';
				if (!empty($youtube_footer_icon)) {
					if (is_array($youtube_footer_icon) && !empty($youtube_footer_icon['url'])) {
						$youtube_footer_icon_url = $youtube_footer_icon['url'];
					} elseif (is_array($youtube_footer_icon) && !empty($youtube_footer_icon['id'])) {
						$youtube_footer_icon_url = wp_get_attachment_image_url($youtube_footer_icon['id'], 'full');
					} elseif (is_numeric($youtube_footer_icon)) {
						$youtube_footer_icon_url = wp_get_attachment_image_url($youtube_footer_icon, 'full');
					}
				}
				// Fallback to default icon if no custom icon uploaded
				if (empty($youtube_footer_icon_url)) {
					$youtube_footer_icon_url = get_template_directory_uri() . '/assets/images/icons/youtube.svg';
				}
				
				// Only show if social media is enabled and at least one URL is provided
				if ($enable_social && $footer_social && (!empty($linkedin_url) || !empty($youtube_url))) {
			?>
			<div class="col-6 col-md-4 d-flex justify-content-end order-2 order-md-3">
			    <?php if (!empty($linkedin_url)) : ?>
				<a href="<?php echo esc_url($linkedin_url); ?>" class="ms-2" target="_blank">
					<img src="<?php echo esc_url($linkedin_footer_icon_url); ?>" alt="link">
				</a>
				<?php endif; ?>
				<?php if (!empty($youtube_url)) : ?>
				<a href="<?php echo esc_url($youtube_url); ?>" class="ms-2" target="_blank">
					<img src="<?php echo esc_url($youtube_footer_icon_url); ?>" alt="youtube">
				</a>
				<?php endif; ?>
			</div>
			<?php
				}
			
			?>

			</div>
		</div>



	</div>
</div>
</div>
</div>
<!-- </div> -->


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered 	modal-demo-form">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Request a demo</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body-content">
					<h3>Let's help you get started</h3>
					<p>Connect with an i2V product expert to explore how our solution can fit your specific needs.</p>
				</div>
				<?php echo do_shortcode('[contact-form-7 id="6cb5dc6" title="Resource form"]'); ?>
			</div>
		</div>
	</div>
</div>

<!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered 	modal-demo-form">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Request a demo</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body-content demo-success-content">
					<h3 class="size-custom">You're all set!</h3>
					<p>Thank you for your interest in i2V. Our team has received your request and a product expert will get in touch with you ASAP to discuss your needs.</p>
					<div class="btn-sec_gap justify-content-center"><a class="theme-btn-white border-btn-grey" href="#">Explore our solutions</a><a class="theme-btn bg-trans border_btnlight" href="#">See customer success stories</a></div>
				</div>
			</div>
		</div>
	</div>
</div> -->

<!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered 	modal-demo-form">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Request a demo</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body-content demo-success-content">
					<h3 class="size-custom">Something went wrong</h3>
					<p>We couldn’t send your message due to a network issue or an unexpected error. Please check your internet connection and try again.</p>
					<div class="btn-sec_gap justify-content-center">
						<a class="theme-btn-white border-btn-grey" href="#">+91 981-005-6691</a>
						<a class="theme-btn-white border-btn-grey" href="#">i2v@i2vsys.com</a>
				</div>
				</div>
			</div>
		</div>
	</div>
</div> -->



<?php
wp_footer();
?>
</body>

</html>
<?php
global $repindia_option;
$backStyle = '';
$backStyle = repindia_backgroundstyle('footer_bg');
$backStyle = implode('', $backStyle);
?>
<div class="footer">
	<div class="custom-container">
		<!-- <div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 footer_menu_logo_box">
						<?php
						if (isset($repindia_option['footer_logo']['url']) && !empty($repindia_option['footer_logo']['url'])) {   ?>  
							<a class="footer_logo_anc" href="<?php echo esc_url(home_url('/')); ?>"><img class="footer_logo_img" src="<?php echo esc_url($repindia_option['footer_logo']['url']); ?>" title="Logo of Phoenix repindia - Ultra luxury apartments in Bangalore" alt="<?php bloginfo('name'); ?>"></a>
						<?php
						} else { ?>
							<a class="footer_logo_anc" href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo_name"><?php bloginfo('name'); ?></a>
						<?php
						}   ?>
						
					</div>



		</div> -->
		<?php
		if (isset($repindia_option['footer_copyright_switch']) && $repindia_option['footer_copyright_switch'] == 1) {
		?>
			<div class="footer_copyright">
				<div class="row g-0">
					<div class="col-md-3 border-right grid-column4">
						<ul class="p-0 m-0 footer-accordion-menu">
							<li class="footer-accordion-item">
								<h3 class="footer-accordion-title">Products <span class="footer-accordion-icon">+</span></h3>
							</li>
							<div class="footer-accordion-content">
								<li><a href="#">i2V's VMS</a></li>
								<li><a href="#">AI based video analytics / VCA</a></li>
								<li><a href="#">Command and control (ICCC / PSIM)</a></li>
								<li><a href="#">Central monitoring software (CMS)</a></li>
								<li><a href="#">FRS</a></li>
								<li><a href="#">ITMS / ITS</a></li>
								<li><a href="#">VIDS</a></li>
								<li><a href="#">ANPR / LPR</a></li>
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
										<h3 class="footer-accordion-title">Industries <span class="footer-accordion-icon">+</span></h3>
									</li>
									<div class="footer-accordion-content">
										<li><a href="#">Oil and Gas</a></li>
										<li><a href="#">Energy</a> </li>
										<li><a href="#">Smart cities</a></li>
										<li><a href="#">Transportation</a></li>
										<li><a href="#">Government</a></li>
										<li><a href="#">Retail</a></li>
										<li><a href="#">Education</a></li>
										<li><a href="#">Healthcare</a></li>
										<li><a href="#">Hospitality</a></li>
										<li><a href="#">Financial institutions</a></li>
									</div>
								</ul>
							</div>
							<div class="column-4">
								<ul class="p-0 m-0 footer-accordion-menu">
									<li class="footer-accordion-item">
										<h3 class="footer-accordion-title">Company <span class="footer-accordion-icon">+</span></h3>
									</li>
									<div class="footer-accordion-content">
										<li><a href="#">Who we are</a></li>
										<li><a href="#">Mission vision</a></li>
										<li><a href="#">Our partners</a></li>
										<li><a href="#">News and events</a></li>
										<li><a href="#">Careers</a></li>
										<li><a href="#">FAQs</a></li>
										<li><a href="#">Contact us</a></li>
									</div>
								</ul>
							</div>
							<div class="column-4">
								<ul class="p-0 m-0 footer-accordion-menu">
									<li class="footer-accordion-item">
										<h3 class="footer-accordion-title">Resources <span class="footer-accordion-icon">+</span></h3>
									</li>
									<div class="footer-accordion-content">
										<li><a href="#">Blogs</a></li>
										<li><a href="#">Data sheets</a></li>
										<li><a href="#">Download our free trail software</a></li>
										<li><a href="#">Calculate hardware sizing</a></li>
										<li><a href="#">Help</a></li>
										<li><a href="#">Sitemap</a></li>
									</div>
								</ul>
							</div>
							<div class="column-4">
								<ul class="p-0 m-0 footer-accordion-menu">
									<li class="footer-accordion-item">
										<h3 class="footer-accordion-title">Legal <span class="footer-accordion-icon">+</span></h3>
									</li>
									<div class="footer-accordion-content">
										<li><a href="#">Terms of Service</a></li>
										<li><a href="#">Privacy Policy</a></li>
										<li><a href="#">Cookie Policy</a></li>
									</div>
								</ul>
							</div>
						</div>
					</div>


					<!-- <div class="col-md-12 col-xs-12">
						<?php
						if (!empty($repindia_option['enable_social']) && isset($repindia_option['footer_social']) && $repindia_option['footer_social'] == 1) {
							$footer_socials = repindia_get_socials('enable_social');
							if ($footer_socials) { ?>
								<div class="footer_social_section">
									<p class="footer_text"><?php echo esc_attr($repindia_option['footer_social_title']); ?></p>
									<ul class="social-icons">
										<?php
										foreach ($footer_socials as $class => $val) { ?>
											<li>
												<a href="<?php echo esc_url($val); ?>" target="_blank" class="social-<?php echo esc_attr($class); ?>">
													<i class="fa fa-<?php echo esc_attr($class); ?> icon"></i>
												</a>
											</li>
										<?php
										}   ?>
									</ul>
								</div>
						<?php
							}
						} ?>
					</div> -->
				</div>
			</div>
		<?php } ?>
		<!-- </div> -->

		<div class="footer_bottom">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<p class="d-inline-flex"><span><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2025/11/disclaimericon.svg" alt="i2V">
						</span>
						Legal disclaimer:<br>
						Performance metrics, deployment figures, and results shown are based on specific implementation scenarios. Actual performance may vary depending on system configuration, environment, and operational conditions. i2V Systems accepts no responsibility and cannot be held liable for any errors, misuse, or misinterpretation of product outputs.</p>
				</div>
			</div>
		</div>



		<div class="footer_bottom_copy">
			<div class="row align-items-center">
				<!-- Mobile: logo left, social right | Desktop: left logo -->
				<div class="col-6 col-md-4 d-flex align-items-center">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg"
						alt="logo" class="img-fluid">
				</div>

				<!-- Desktop only: center text -->
				<div class="col-12 order-3 order-md-2 col-md-4 text-center mt-4 mt-md-0">
					<p class="mb-0">© 2025 All Rights Reserved. i2V Systems Pvt. Ltd.</p>
				</div>

				<!-- Mobile: right icons | Desktop: right aligned -->
				<div class="col-6 col-md-4 d-flex justify-content-end order-2 order-md-3">
					<a href="#" class="ms-2">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/link.png" alt="link">
					</a>
					<a href="#" class="ms-2">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/youtube.png" alt="youtube">
					</a>
				</div>
			</div>
		</div>



	</div>
</div>
</div>
</div>
<!-- </div> -->





<?php
wp_footer();
?>
</body>

</html>
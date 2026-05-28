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
							<h3 class="footer-accordion-title">
								<?php echo esc_attr($repindia_option['footer_product_title']); ?> <span
									class="footer-accordion-icon">+</span>
							</h3>
						</li>
						<div class="footer-accordion-content">
							<?php
							if (has_nav_menu('footer-product-menu')) {
								wp_nav_menu(
									array(
										'menu_id' => 'footermenu',
										'theme_location' => 'footer-product-menu',
										'container' => false,
										'depth' => 1,
										'menu_class' => 'footer_product'
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
							<ul class="p-0 m-0 footer-accordion-menu">
								<li class="footer-accordion-item">
									<h3 class="footer-accordion-title">
										<?php echo esc_attr($repindia_option['footer_industry_title']); ?> <span
											class="footer-accordion-icon">+</span>
									</h3>
								</li>
								<div class="footer-accordion-content">
									<?php
									if (has_nav_menu('footer-industry-menu')) {
										wp_nav_menu(
											array(
												'menu_id' => 'footermenu',
												'theme_location' => 'footer-industry-menu',
												'container' => false,
												'depth' => 1,
												'menu_class' => 'footer_industry'
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
									<h3 class="footer-accordion-title">
										<?php echo esc_attr($repindia_option['footer_company_title']); ?> <span
											class="footer-accordion-icon">+</span>
									</h3>
								</li>
								<div class="footer-accordion-content">
									<?php
									if (has_nav_menu('footer-company-menu')) {
										wp_nav_menu(
											array(
												'menu_id' => 'footermenu',
												'theme_location' => 'footer-company-menu',
												'container' => false,
												'depth' => 1,
												'menu_class' => 'footer_company'
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
									<h3 class="footer-accordion-title">
										<?php echo esc_attr($repindia_option['footer_resource_title']); ?> <span
											class="footer-accordion-icon">+</span>
									</h3>
								</li>
								<div class="footer-accordion-content">
									<?php
									if (has_nav_menu('footer-resource-menu')) {
										wp_nav_menu(
											array(
												'menu_id' => 'footermenu',
												'theme_location' => 'footer-resource-menu',
												'container' => false,
												'depth' => 1,
												'menu_class' => 'footer_resource'
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
									<h3 class="footer-accordion-title">
										<?php echo esc_attr($repindia_option['footer_legal_title']); ?> <span
											class="footer-accordion-icon">+</span>
									</h3>
								</li>
								<div class="footer-accordion-content">
									<?php
									if (has_nav_menu('footer-legal-menu')) {
										wp_nav_menu(
											array(
												'menu_id' => 'footermenu',
												'theme_location' => 'footer-legal-menu',
												'container' => false,
												'depth' => 1,
												'menu_class' => 'footer_legal'
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
						<?php if (isset($repindia_option['footer_dscl_icon']['url']) && !empty($repindia_option['footer_dscl_icon']['url'])) { ?>
							<span><img src="<?php echo esc_url($repindia_option['footer_dscl_icon']['url']); ?>"
									alt="<?php bloginfo('name'); ?>" class="img-fluid"></span>
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
				<?php if (isset($repindia_option['footer_logo']['url']) && !empty($repindia_option['footer_logo']['url'])) { ?>
					<div class="col-6 col-md-4 d-flex align-items-center">
						<img src="<?php echo esc_url($repindia_option['footer_logo']['url']); ?>"
							alt="<?php bloginfo('name'); ?>" class="img-fluid">
					</div>
					<?php
				} ?>
				<!-- Desktop only: center text -->
				<?php
				if (!empty($repindia_option['footer_copyright'])) { ?>
					<div class="col-12 order-3 order-md-2 col-md-4 text-center mt-4 mt-md-0">
						<p class="mb-0"><?php echo wp_kses_post($repindia_option['footer_copyright']); ?></p>
					</div>
					<?php
				}
				?>


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
						<?php if (!empty($linkedin_url)): ?>
							<a href="<?php echo esc_url($linkedin_url); ?>" class="ms-2" target="_blank">
								<img src="<?php echo esc_url($linkedin_footer_icon_url); ?>" alt="link">
							</a>
						<?php endif; ?>
						<?php if (!empty($youtube_url)): ?>
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

<!-- Global CF7 error overlay (same modal shell as formpopup_modal) -->
<div class="cf7-error-overlay formpopup_modal" aria-hidden="true" role="dialog" aria-modal="true"
	aria-labelledby="cf7ErrorBackdropLabel">
	<div class="modal-dialog modal-dialog-centered modal-demo-form">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<h5 class="modal-title" id="cf7ErrorBackdropLabel">
						<?php echo esc_html(wpml_t('Request a demo', 'Repindia-Template', 'Header Demo Popup Text')); ?>
					</h5>
					<span class="btn-closecustom" data-cf7-error-close role="button" tabindex="0"
						aria-label="<?php esc_attr_e('Close', 'repindia'); ?>">
						<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M8.67339 8.67351C9.03788 8.30902 9.62883 8.30902 9.99332 8.67351L14 12.6802L18.0067 8.67351C18.3712 8.30902 18.9622 8.30902 19.3267 8.67351C19.6911 9.038 19.6911 9.62896 19.3267 9.99345L15.32 14.0001L19.3267 18.0068C19.6911 18.3713 19.6911 18.9623 19.3267 19.3268C18.9622 19.6913 18.3712 19.6913 18.0067 19.3268L14 15.3201L9.99332 19.3268C9.62883 19.6913 9.03788 19.6913 8.67339 19.3268C8.3089 18.9623 8.3089 18.3713 8.67339 18.0068L12.6801 14.0001L8.67339 9.99345C8.3089 9.62896 8.3089 9.038 8.67339 8.67351Z"
								fill="#5F6F94" />
						</svg>
					</span>
				</div>
				<div class="modal-body-content cf7-error-body">
					<div class="cf7-error-icon">
						<img src="<?php echo esc_url(home_url('/')); ?>wp-content/uploads/2026/05/alert.gif"
							alt="<?php esc_attr_e('Error', 'repindia'); ?>">
					</div>
					<h2 class="cf7-error-title size-custom"><?php esc_html_e('Something went wrong', 'repindia'); ?></h2>
					<p class="cf7-error-text">
						<?php esc_html_e('We couldn’t send your message due to a network issue or an unexpected error. Please check your internet connection and try again.', 'repindia'); ?>
					</p>
					<p class="cf7-error-text">
						<?php esc_html_e('If the issue continues, feel free to reach us directly.', 'repindia'); ?>
					</p>
					<div class="cf7-error-actions">
						<div class="cf7-error-action-inner btn-sec_gap">
							<a href="tel:+919810056691"
								class="cf7-error-btn theme-btn-white border-btn-grey"><?php echo esc_html('+91 981-005-6691'); ?></a>
							<a href="mailto:i2v@i2vsys.com"
								class="cf7-error-btn theme-btn-white border-btn-grey"><?php echo esc_html('i2v@i2vsys.com'); ?></a>
						</div>
						<a href="<?php //echo esc_url(home_url('/')); ?>"
							class="cf7-error-btn theme-btn btn_transgreylight"><?php //esc_html_e('Back to home', 'repindia'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<?php
if (!empty($repindia_option['demo_popup_form'])) { ?>
	<div class="formpopup_modal modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="true"
		tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered modal-demo-form">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">
							<?php echo esc_html(wpml_t('Request a demo', 'Repindia-Template', 'Header Demo Popup Text')); ?>
						</h5>
						<span class="btn-closecustom" data-bs-dismiss="modal" aria-label="Close">
							<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd"
									d="M8.67339 8.67351C9.03788 8.30902 9.62883 8.30902 9.99332 8.67351L14 12.6802L18.0067 8.67351C18.3712 8.30902 18.9622 8.30902 19.3267 8.67351C19.6911 9.038 19.6911 9.62896 19.3267 9.99345L15.32 14.0001L19.3267 18.0068C19.6911 18.3713 19.6911 18.9623 19.3267 19.3268C18.9622 19.6913 18.3712 19.6913 18.0067 19.3268L14 15.3201L9.99332 19.3268C9.62883 19.6913 9.03788 19.6913 8.67339 19.3268C8.3089 18.9623 8.3089 18.3713 8.67339 18.0068L12.6801 14.0001L8.67339 9.99345C8.3089 9.62896 8.3089 9.038 8.67339 8.67351Z"
									fill="#5F6F94" />
							</svg>
						</span>
					</div>
					<!-- <div class="modal-body-content">
						<h3>Let's help you get started</h3>
						<p>Connect with an i2V product expert to explore how our solution can fit your specific needs.</p>
					</div> -->
					<?php echo do_shortcode(wp_kses_post($repindia_option['demo_popup_form'])); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<!-- Contact Modal -->
<?php
if (!empty($repindia_option['contact_popup_form'])) { ?>
	<div class="formpopup_modal modal fade" id="contactBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
		tabindex="-1" aria-labelledby="contactBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-demo-form">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<h5 class="modal-title" id="contactBackdropLabel">
							<?php echo esc_html(wpml_t('Talk to our partner team', 'Repindia-Template', 'Header partner popup text')); ?>
						</h5>
						<span class="btn-closecustom" data-bs-dismiss="modal" aria-label="Close">
							<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd"
									d="M8.67339 8.67351C9.03788 8.30902 9.62883 8.30902 9.99332 8.67351L14 12.6802L18.0067 8.67351C18.3712 8.30902 18.9622 8.30902 19.3267 8.67351C19.6911 9.038 19.6911 9.62896 19.3267 9.99345L15.32 14.0001L19.3267 18.0068C19.6911 18.3713 19.6911 18.9623 19.3267 19.3268C18.9622 19.6913 18.3712 19.6913 18.0067 19.3268L14 15.3201L9.99332 19.3268C9.62883 19.6913 9.03788 19.6913 8.67339 19.3268C8.3089 18.9623 8.3089 18.3713 8.67339 18.0068L12.6801 14.0001L8.67339 9.99345C8.3089 9.62896 8.3089 9.038 8.67339 8.67351Z"
									fill="#5F6F94" />
							</svg>
						</span>
					</div>
					<?php echo do_shortcode(wp_kses_post($repindia_option['contact_popup_form'])); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<!-- Channel Partner Modal -->
<?php
if (!empty($repindia_option['channel_partner_form'])) { ?>
	<div class="formpopup_modal modal fade" id="channelPartnerBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
		tabindex="-1" aria-labelledby="channelPartnerBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-demo-form">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<h5 class="modal-title" id="channelPartnerBackdropLabel">
							<?php echo esc_html(wpml_t('Channel Partner', 'Repindia-Template', 'Channel Partner popup text')); ?>
						</h5>
						<span class="btn-closecustom" data-bs-dismiss="modal" aria-label="Close">
							<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd"
									d="M8.67339 8.67351C9.03788 8.30902 9.62883 8.30902 9.99332 8.67351L14 12.6802L18.0067 8.67351C18.3712 8.30902 18.9622 8.30902 19.3267 8.67351C19.6911 9.038 19.6911 9.62896 19.3267 9.99345L15.32 14.0001L19.3267 18.0068C19.6911 18.3713 19.6911 18.9623 19.3267 19.3268C18.9622 19.6913 18.3712 19.6913 18.0067 19.3268L14 15.3201L9.99332 19.3268C9.62883 19.6913 9.03788 19.6913 8.67339 19.3268C8.3089 18.9623 8.3089 18.3713 8.67339 18.0068L12.6801 14.0001L8.67339 9.99345C8.3089 9.62896 8.3089 9.038 8.67339 8.67351Z"
									fill="#5F6F94" />
							</svg>
						</span>
					</div>
					<?php echo do_shortcode(wp_kses_post($repindia_option['channel_partner_form'])); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<!-- Technology Partner Modal -->
<?php
if (!empty($repindia_option['technology_partner_form'])) { ?>
	<div class="formpopup_modal modal fade" id="technologyPartnerBackdrop" data-bs-backdrop="static"
		data-bs-keyboard="false" tabindex="-1" aria-labelledby="technologyPartnerBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-demo-form">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<h5 class="modal-title" id="technologyPartnerBackdropLabel">
							<?php echo esc_html(wpml_t('Technology Partner', 'Repindia-Template', 'Technolgy Popup Header')); ?>
						</h5>
						<span class="btn-closecustom" data-bs-dismiss="modal" aria-label="Close">
							<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd"
									d="M8.67339 8.67351C9.03788 8.30902 9.62883 8.30902 9.99332 8.67351L14 12.6802L18.0067 8.67351C18.3712 8.30902 18.9622 8.30902 19.3267 8.67351C19.6911 9.038 19.6911 9.62896 19.3267 9.99345L15.32 14.0001L19.3267 18.0068C19.6911 18.3713 19.6911 18.9623 19.3267 19.3268C18.9622 19.6913 18.3712 19.6913 18.0067 19.3268L14 15.3201L9.99332 19.3268C9.62883 19.6913 9.03788 19.6913 8.67339 19.3268C8.3089 18.9623 8.3089 18.3713 8.67339 18.0068L12.6801 14.0001L8.67339 9.99345C8.3089 9.62896 8.3089 9.038 8.67339 8.67351Z"
									fill="#5F6F94" />
							</svg>
						</span>
					</div>
					<?php echo do_shortcode(wp_kses_post($repindia_option['technology_partner_form'])); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>


<!-- Brands Modal (global): Vertical tabs + ACF galleries from CPT "brands" -->
<div class="formpopup_modal modal fade" id="brandsPopup" data-bs-backdrop="static" data-bs-keyboard="true"
	tabindex="-1" aria-labelledby="brandsPopupLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-logopartner-form modal_brandlogo_popup">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<h5 class="modal-title" id="brandsPopupLabel">
						<?php esc_html_e("i2V's supported camera brands", "repindia"); ?>
					</h5>
					<span class="btn-closecustom" data-bs-dismiss="modal"
						aria-label="<?php esc_attr_e('Close', 'repindia'); ?>">
						<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M8.67339 8.67351C9.03788 8.30902 9.62883 8.30902 9.99332 8.67351L14 12.6802L18.0067 8.67351C18.3712 8.30902 18.9622 8.30902 19.3267 8.67351C19.6911 9.038 19.6911 9.62896 19.3267 9.99345L15.32 14.0001L19.3267 18.0068C19.6911 18.3713 19.6911 18.9623 19.3267 19.3268C18.9622 19.6913 18.3712 19.6913 18.0067 19.3268L14 15.3201L9.99332 19.3268C9.62883 19.6913 9.03788 19.6913 8.67339 19.3268C8.3089 18.9623 8.3089 18.3713 8.67339 18.0068L12.6801 14.0001L8.67339 9.99345C8.3089 9.62896 8.3089 9.038 8.67339 8.67351Z"
								fill="#5F6F94" />
						</svg>
					</span>
				</div>

				<style>
					/* Scoped styles: do not affect existing widgets/popups */
					#brandsPopup .brands-tech-tab-container { display: flex; gap: 80px; max-width: 100%; width: 100%; }
					#brandsPopup .brands-tech-tabs-nav { flex: 0 0 350px; align-self: flex-start; background: #fff; border-radius: 8px; padding: 4px; height: fit-content; box-shadow: 0 0 15px 0 rgba(138, 149, 158, 0.40); max-height: 60vh; overflow: auto; }
					.js-dark #brandsPopup .brands-tech-tabs-nav { background: #262A30; border-color: rgba(193, 196, 198, 0.1); }
					#brandsPopup .brands-tech-tabs-nav ul { list-style: none; margin: 0; padding: 0; }
					#brandsPopup .brands-tech-tabs-nav li { margin: 0; padding: 0; }
					#brandsPopup .brands-tech-tab-btn { width: 100%; text-align: left; padding: 10px 35px; background: transparent; border: none; cursor: pointer; font-size: 16px; color: #5F6F94; border-radius: 4px; transition: all 0.3s ease; font-family: inherit; position: relative; font-weight: 500; line-height: 24px; }
					.js-dark #brandsPopup .brands-tech-tab-btn { color: #aeb6c9; }
					#brandsPopup .brands-tech-tab-btn:hover { background: rgba(255, 255, 255, 0.5); }
					#brandsPopup .brands-tech-tab-btn.active { background: #E6E6E6; color: #06283D; }
					.js-dark #brandsPopup .brands-tech-tab-btn:hover,
					.js-dark #brandsPopup .brands-tech-tab-btn.active { background: rgba(255, 255, 255, 0.15); color: #fff; }
					#brandsPopup .brands-tech-tab-btn .checkmark-svg { display: inline-block; width: 24px; height: 24px; margin-right: 6px; vertical-align: middle; fill: #06283D; }
					#brandsPopup .brands-tech-tab-btn svg { position: absolute; left: 8px; top: 10px; opacity: 0.5; }

					#brandsPopup .brands-tech-tabs-dropdown { display: none; width: 100%; padding: 12px 16px; font-size: 16px; color: #5F6F94; background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer; font-family: inherit; font-weight: 500; line-height: 24px; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%235F6F94' d='M6 9L1 4h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; padding-right: 40px; }
					.js-dark #brandsPopup .brands-tech-tabs-dropdown { border: 1px solid rgba(193, 196, 198, 0.1) !important; background: #262a30; color: #ccc; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23fff'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px; }
					#brandsPopup .brands-tech-tabs-dropdown:focus { outline: none; border-color: #06283D; }

					#brandsPopup .brands-tech-images-grid { flex: 1; display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; background: transparent; border: none; }
					#brandsPopup .brands-tech-image-item { background: #fff; padding: 20px; display: flex; align-items: center; justify-content: center; height: 120px; transition: opacity 0.3s ease, transform 0.3s ease; border-radius: 8px; }
					.js-dark #brandsPopup .brands-tech-image-item { background: #262A30; }

					#brandsPopup .brands-tech-image-light { display: flex; }
					.js-dark #brandsPopup .brands-tech-image-light { display: none; }
					.js-dark #brandsPopup .brands-tech-image-light.brands-tech-image-fallback { display: flex; }
					#brandsPopup .brands-tech-image-dark { display: none; }
					.js-dark #brandsPopup .brands-tech-image-dark { display: flex; }
					#brandsPopup .brands-tech-image-item.hidden { display: none !important; }
					#brandsPopup .brands-tech-image-item img { max-width: 100%; max-height: 80px; width: auto; height: auto; object-fit: contain; }

					@media (max-width: 1200px) { #brandsPopup .brands-tech-images-grid { grid-template-columns: repeat(3, 1fr); } }
					@media (max-width: 768px) {
						#brandsPopup .brands-tech-tab-container { flex-direction: column; gap: 20px; }
						#brandsPopup .brands-tech-tabs-nav { display: none; }
						#brandsPopup .brands-tech-tabs-dropdown { display: block; }
						#brandsPopup .brands-tech-images-grid { grid-template-columns: repeat(2, 1fr); }
					}
					@media (min-width: 769px) { #brandsPopup .brands-tech-tabs-dropdown { display: none; } }
				</style>

				<div class="modal-body-content">
					<?php
					$brands_query = new WP_Query(array(
						'post_type' => 'brands',
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'no_found_rows' => true,
						'orderby' => 'title',
						'order' => 'ASC',
						'fields' => 'ids',
					));

					$brand_ids = !empty($brands_query->posts) ? $brands_query->posts : array();
					wp_reset_postdata();
					?>

					<?php if (!empty($brand_ids)) : ?>
						<div class="brands-tech-tab-container" data-brands-popup-tabs>
							<div class="brands-tech-tabs-nav">
								<ul>
									<li>
										<button class="brands-tech-tab-btn active" type="button" data-brand-tab="all" data-text="All">All</button>
									</li>
									<?php foreach ($brand_ids as $index => $brand_id) :
										$brand_title = get_the_title($brand_id);
										if (empty($brand_title)) {
											continue;
										}
										$tab_slug = sanitize_title($brand_title . '-' . $brand_id);
									?>
										<li>
											<button class="brands-tech-tab-btn"
												type="button"
												data-brand-tab="<?php echo esc_attr($tab_slug); ?>"
												data-text="<?php echo esc_attr($brand_title); ?>">
												<?php echo esc_html($brand_title); ?>
											</button>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>

							<select class="brands-tech-tabs-dropdown" aria-label="<?php esc_attr_e('Select brand', 'repindia'); ?>">
								<option value="all"><?php esc_html_e('All', 'repindia'); ?></option>
								<?php foreach ($brand_ids as $index => $brand_id) :
									$brand_title = get_the_title($brand_id);
									if (empty($brand_title)) {
										continue;
									}
									$tab_slug = sanitize_title($brand_title . '-' . $brand_id);
								?>
									<option value="<?php echo esc_attr($tab_slug); ?>">
										<?php echo esc_html($brand_title); ?>
									</option>
								<?php endforeach; ?>
							</select>

							<div class="brands-tech-images-grid">
								<?php
								foreach ($brand_ids as $brand_id) :
									$brand_title = get_the_title($brand_id);
									if (empty($brand_title)) {
										continue;
									}
									$tab_slug = sanitize_title($brand_title . '-' . $brand_id);

									$light_gallery = function_exists('get_field') ? get_field('brand_light_gallery', $brand_id) : array();
									$dark_gallery = function_exists('get_field') ? get_field('brand_dark_gallery', $brand_id) : array();

									$has_dark_images = !empty($dark_gallery);

									if (empty($light_gallery) && empty($dark_gallery)) {
										continue;
									}

									if (!empty($light_gallery)) :
										foreach ($light_gallery as $img) :
											$img_url = '';
											$img_alt = $brand_title;
											$attachment_id = 0;

											// ACF gallery return format can be: array (image array), int (attachment ID), or URL string.
											if (is_array($img)) {
												if (!empty($img['url'])) {
													$img_url = $img['url'];
												}
												if (!empty($img['alt'])) {
													$img_alt = $img['alt'];
												}
												if (!empty($img['ID'])) {
													$attachment_id = (int) $img['ID'];
												} elseif (!empty($img['id'])) {
													$attachment_id = (int) $img['id'];
												}
											} elseif (is_numeric($img)) {
												$attachment_id = (int) $img;
											} elseif (is_string($img) && !empty($img)) {
												$img_url = $img;
											}

											if (empty($img_url) && $attachment_id) {
												$img_url = wp_get_attachment_image_url($attachment_id, 'full');
											}
											if (($img_alt === $brand_title || $img_alt === '') && $attachment_id) {
												$stored_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
												if (!empty($stored_alt)) {
													$img_alt = $stored_alt;
												}
											}
											if (empty($img_url)) {
												continue;
											}
								?>
											<div class="brands-tech-image-item brands-tech-image-light<?php echo !$has_dark_images ? ' brands-tech-image-fallback' : ''; ?>"
												data-brand-tab="<?php echo esc_attr($tab_slug); ?>" data-has-dark="<?php echo $has_dark_images ? '1' : '0'; ?>">
												<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" loading="lazy" decoding="async">
											</div>
								<?php
										endforeach;
									endif;

									if (!empty($dark_gallery)) :
										foreach ($dark_gallery as $img) :
											$img_url = '';
											$img_alt = $brand_title;
											$attachment_id = 0;

											if (is_array($img)) {
												if (!empty($img['url'])) {
													$img_url = $img['url'];
												}
												if (!empty($img['alt'])) {
													$img_alt = $img['alt'];
												}
												if (!empty($img['ID'])) {
													$attachment_id = (int) $img['ID'];
												} elseif (!empty($img['id'])) {
													$attachment_id = (int) $img['id'];
												}
											} elseif (is_numeric($img)) {
												$attachment_id = (int) $img;
											} elseif (is_string($img) && !empty($img)) {
												$img_url = $img;
											}

											if (empty($img_url) && $attachment_id) {
												$img_url = wp_get_attachment_image_url($attachment_id, 'full');
											}
											if (($img_alt === $brand_title || $img_alt === '') && $attachment_id) {
												$stored_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
												if (!empty($stored_alt)) {
													$img_alt = $stored_alt;
												}
											}
											if (empty($img_url)) {
												continue;
											}
								?>
											<div class="brands-tech-image-item brands-tech-image-dark"
												data-brand-tab="<?php echo esc_attr($tab_slug); ?>">
												<img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" loading="lazy" decoding="async">
											</div>
								<?php
										endforeach;
									endif;
								endforeach;
								?>
							</div>
						</div>

						<script>
							(function () {
								function initBrandsPopupTabs(modalEl) {
									if (!modalEl || modalEl.dataset.brandsPopupTabsBound === '1') return;
									modalEl.dataset.brandsPopupTabsBound = '1';

									var container = modalEl.querySelector('[data-brands-popup-tabs]');
									if (!container) return;

									var tabButtons = container.querySelectorAll('.brands-tech-tab-btn');
									var imageItems = container.querySelectorAll('.brands-tech-image-item');
									var dropdown = container.querySelector('.brands-tech-tabs-dropdown');

									function setActiveTab(activeTab) {
										tabButtons.forEach(function (btn) {
											var btnText = btn.getAttribute('data-text') || btn.textContent || '';
											var isActive = btn.getAttribute('data-brand-tab') === activeTab;

											btn.classList.remove('active');
											var existingCheck = btn.querySelector('.checkmark-svg');
											if (existingCheck) existingCheck.remove();
											btn.textContent = btnText;

											if (isActive) {
												btn.classList.add('active');
												var checkmarkSVG = createCheckmarkSVG();
												btn.insertBefore(checkmarkSVG, btn.firstChild);
											}
										});

										if (dropdown) {
											dropdown.value = activeTab;
										}

										imageItems.forEach(function (item) {
											var itemTab = item.getAttribute('data-brand-tab');
											if (activeTab === 'all' || itemTab === activeTab) {
												item.classList.remove('hidden');
											} else {
												item.classList.add('hidden');
											}
										});
									}

									function createCheckmarkSVG() {
										var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
										svg.setAttribute('class', 'checkmark-svg');
										svg.setAttribute('viewBox', '0 0 20 20');
										svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
										var path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
										path.setAttribute('d', 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z');
										path.setAttribute('fill', 'currentColor');
										svg.appendChild(path);
										return svg;
									}

									var defaultTab = 'all';
									if (defaultTab) {
										setActiveTab(defaultTab);
									}

									tabButtons.forEach(function (btn) {
										btn.addEventListener('click', function () {
											var tab = this.getAttribute('data-brand-tab');
											if (tab) setActiveTab(tab);
										});
									});

									if (dropdown) {
										dropdown.addEventListener('change', function () {
											var tab = this.value;
											if (tab) setActiveTab(tab);
										});
									}
								}

								document.addEventListener('DOMContentLoaded', function () {
									var modalEl = document.getElementById('brandsPopup');
									if (!modalEl) return;

									if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
										modalEl.addEventListener('shown.bs.modal', function () {
											initBrandsPopupTabs(modalEl);
										});
									} else {
										initBrandsPopupTabs(modalEl);
									}
								});
							})();
						</script>
					<?php else : ?>
						<p class="mb-0"><?php esc_html_e('No brands found.', 'repindia'); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal: supportive devices / logo partners (same behavior as other form popups: scroll on .modal-content, static backdrop) -->
<div class="formpopup_modal modal fade" id="logomodal_custom" data-bs-backdrop="static" data-bs-keyboard="false"
	tabindex="-1" aria-labelledby="logomodal_customLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-logopartner-form">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<h5 class="modal-title" id="logomodal_customLabel">
						<?php echo esc_html(wpml_t('100+ IP camera brands supported', 'Repindia-Template', 'Supportive devices')); ?>
					</h5>
					<span class="btn-closecustom" data-bs-dismiss="modal"
						aria-label="<?php esc_attr_e('Close', 'repindia'); ?>">
						<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd"
								d="M8.67339 8.67351C9.03788 8.30902 9.62883 8.30902 9.99332 8.67351L14 12.6802L18.0067 8.67351C18.3712 8.30902 18.9622 8.30902 19.3267 8.67351C19.6911 9.038 19.6911 9.62896 19.3267 9.99345L15.32 14.0001L19.3267 18.0068C19.6911 18.3713 19.6911 18.9623 19.3267 19.3268C18.9622 19.6913 18.3712 19.6913 18.0067 19.3268L14 15.3201L9.99332 19.3268C9.62883 19.6913 9.03788 19.6913 8.67339 19.3268C8.3089 18.9623 8.3089 18.3713 8.67339 18.0068L12.6801 14.0001L8.67339 9.99345C8.3089 9.62896 8.3089 9.038 8.67339 8.67351Z"
								fill="#5F6F94" />
						</svg>
					</span>
				</div>
				<div class="modal-body-content">
					<div class="tech-images-grid">
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/x-vision.webp"
								alt="Item1"><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/x-vision.webp"
								alt="Item1">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/vivotek.webp"
								alt="Item2"><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/vivotek.webp"
								alt="Item2">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/vicon.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/vicon.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/verient.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/verient.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/unv.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/unv.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/tyco.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/tyco.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/tvt.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/tvt.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/trendnet.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/trendnet.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/tp-link.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2026/04/tp-link.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/tiandy.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/tiandy.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/stardot.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/stardot.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/sony.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/sony.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/siemens.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/siemens.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/securus.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/securus.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/securn.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/securn.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/plexonics.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/plexonics.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/pixord.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/pixord.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/pelco.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/pelco.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/panasonic.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/panasonic.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/mobotix.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/panasonic.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/mobotix.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/mobotix.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/milesight.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/milesight.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/matrix.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/matrix.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/logos-copy.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/logos-copy.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/lilin.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/lilin.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/LG.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/LG.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/level-one.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/level-one.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/jvc.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/jvc.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/infinova.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/infinova.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/indinatus.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/indinatus.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/indigovision.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/indigovision.webp"
								alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/idis.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/idis.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/honeywell.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/honeywell.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/hikvision.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/hikvision.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/hi-focus.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/hi-focus.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/hanwa.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/hanwa.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/grandstream.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/grandstream.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/geovision.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/geovision.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/foscam.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/foscam.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/flir.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/flir.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/everfocus.webp"
								alt=""><img class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/everfocus.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/dvtel.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/dvtel.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/dtech.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/dtech.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/dlink.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/dlink.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/cp-plus.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/cp-plus.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/compro.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/compro.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/cnb.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/cnb.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/cisco.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/cisco.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/camwell.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/camwell.webp" alt="">
						</div>
						<div class="tech-image-item tech-image-light tech-image-fallback" data-tab="" data-has-dark="1">
							<img class="white_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/brick.webp" alt=""><img
								class="black_theme_img" decoding="async"
								src="https://reputationindia.in/i2v/wp-content/uploads/2025/11/brick.webp" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- JavaScript to open modals for CTAs with data-modal-target attribute or class -->
<script>
	(function () {
		document.addEventListener('DOMContentLoaded', function () {
			// Function to open modal by ID
			function openModal(modalId) {
				var modal = document.getElementById(modalId);
				if (!modal) {
					return false; // Modal doesn't exist
				}

				// Check if Bootstrap modal is available
				if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
					// Bootstrap 5
					var modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
					modalInstance.show();
					return true;
				} else if (typeof jQuery !== 'undefined' && jQuery.fn.modal) {
					// Bootstrap 4 (jQuery)
					jQuery(modal).modal('show');
					return true;
				}
				return false;
			}

			// Function to handle click event
			function handleModalClick(e, modalId) {
				var trigger = e.currentTarget;

				// If element has modal trigger class or data attribute, always open modal
				// This ensures links with modal classes work properly
				var hasModalTrigger = trigger.hasAttribute('data-modal-target') ||
					trigger.classList.contains('open-demo-modal') ||
					trigger.classList.contains('open-contact-modal') ||
					trigger.classList.contains('open-channel-partner-modal') ||
					trigger.classList.contains('open-technology-partner-modal') ||
					trigger.classList.contains('open-logo-partner-modal') ||
					trigger.classList.contains('open-brands-popup');

				if (hasModalTrigger) {
					// Prevent default to avoid navigation when modal trigger is present
					e.preventDefault();
					// Open the modal
					openModal(modalId);
					return;
				}

				// Fallback: Check if it's a link with external URL (for backward compatibility)
				if (trigger.tagName === 'A' && trigger.getAttribute('href')) {
					var href = trigger.getAttribute('href');
					// If it's an external link (not # or starting with #), don't prevent default
					if (href !== '#' && !href.startsWith('#')) {
						return; // Allow normal link behavior
					}
				}

				// Prevent default to avoid navigation
				e.preventDefault();

				// Open the modal
				openModal(modalId);
			}

			// Handle elements with data-modal-target attribute (most flexible)
			var dataModalTriggers = document.querySelectorAll('[data-modal-target]');
			dataModalTriggers.forEach(function (trigger) {
				var modalId = trigger.getAttribute('data-modal-target');
				if (modalId) {
					trigger.addEventListener('click', function (e) {
						handleModalClick(e, modalId);
					});
				}
			});

			// Handle elements with class 'open-demo-modal' (backward compatibility)
			var demoModalTriggers = document.querySelectorAll('.open-demo-modal');
			if (demoModalTriggers.length > 0 && document.getElementById('staticBackdrop')) {
				demoModalTriggers.forEach(function (trigger) {
					// Skip if already has data-modal-target
					if (!trigger.hasAttribute('data-modal-target')) {
						trigger.addEventListener('click', function (e) {
							handleModalClick(e, 'staticBackdrop');
						});
					}
				});
			}

			// Handle elements with class 'open-contact-modal'
			var contactModalTriggers = document.querySelectorAll('.open-contact-modal');
			if (contactModalTriggers.length > 0 && document.getElementById('contactBackdrop')) {
				contactModalTriggers.forEach(function (trigger) {
					// Skip if already has data-modal-target
					if (!trigger.hasAttribute('data-modal-target')) {
						trigger.addEventListener('click', function (e) {
							handleModalClick(e, 'contactBackdrop');
						});
					}
				});
			}

			// Handle elements with class 'open-channel-partner-modal'
			var channelPartnerModalTriggers = document.querySelectorAll('.open-channel-partner-modal');
			if (channelPartnerModalTriggers.length > 0 && document.getElementById('channelPartnerBackdrop')) {
				channelPartnerModalTriggers.forEach(function (trigger) {
					// Skip if already has data-modal-target
					if (!trigger.hasAttribute('data-modal-target')) {
						trigger.addEventListener('click', function (e) {
							handleModalClick(e, 'channelPartnerBackdrop');
						});
					}
				});
			}

			// Handle elements with class 'open-technology-partner-modal'
			var technologyPartnerModalTriggers = document.querySelectorAll('.open-technology-partner-modal');
			if (technologyPartnerModalTriggers.length > 0 && document.getElementById('technologyPartnerBackdrop')) {
				technologyPartnerModalTriggers.forEach(function (trigger) {
					// Skip if already has data-modal-target
					if (!trigger.hasAttribute('data-modal-target')) {
						trigger.addEventListener('click', function (e) {
							handleModalClick(e, 'technologyPartnerBackdrop');
						});
					}
				});
			}

			// Supportive devices / logo grid modal (#logomodal_custom)
			var logoPartnerModalTriggers = document.querySelectorAll('.open-logo-partner-modal');
			if (logoPartnerModalTriggers.length > 0 && document.getElementById('logomodal_custom')) {
				logoPartnerModalTriggers.forEach(function (trigger) {
					if (!trigger.hasAttribute('data-modal-target')) {
						trigger.addEventListener('click', function (e) {
							handleModalClick(e, 'logomodal_custom');
						});
					}
				});
			}

			// Brands popup modal (#brandsPopup)
			var brandsPopupTriggers = document.querySelectorAll('.open-brands-popup');
			if (brandsPopupTriggers.length > 0 && document.getElementById('brandsPopup')) {
				brandsPopupTriggers.forEach(function (trigger) {
					if (!trigger.hasAttribute('data-modal-target')) {
						trigger.addEventListener('click', function (e) {
							handleModalClick(e, 'brandsPopup');
						});
					}
				});
			}
		});
	})();
</script>

<!-- Global YouTube Video Popup (single reusable container) - matches video_accordion layout -->
<div id="global-youtube-popup" class="global-youtube-popup" aria-hidden="true" role="dialog" aria-modal="true"
	aria-label="<?php esc_attr_e('YouTube video', 'repindia'); ?>">
	<div class="global-youtube-popup__backdrop"></div>
	<div class="global-youtube-popup__dialog">
		<div class="global-youtube-popup__content">
			<div class="global-youtube-popup__header">
				<h1 class="global-youtube-popup__title" id="global-youtube-popup-title">
					<?php esc_html_e('Video', 'repindia'); ?>
				</h1>
				<button type="button" class="global-youtube-popup__close"
					aria-label="<?php esc_attr_e('Close', 'repindia'); ?>">
					<svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd"
							d="M8.67339 8.67351C9.03788 8.30902 9.62883 8.30902 9.99332 8.67351L14 12.6802L18.0067 8.67351C18.3712 8.30902 18.9622 8.30902 19.3267 8.67351C19.6911 9.038 19.6911 9.62896 19.3267 9.99345L15.32 14.0001L19.3267 18.0068C19.6911 18.3713 19.6911 18.9623 19.3267 19.3268C18.9622 19.6913 18.3712 19.6913 18.0067 19.3268L14 15.3201L9.99332 19.3268C9.62883 19.6913 9.03788 19.6913 8.67339 19.3268C8.3089 18.9623 8.3089 18.3713 8.67339 18.0068L12.6801 14.0001L8.67339 9.99345C8.3089 9.62896 8.3089 9.038 8.67339 8.67351Z"
							fill="#5F6F94" />
					</svg>
				</button>
			</div>
			<div class="global-youtube-popup__body videoframe">
				<iframe id="global-youtube-popup-iframe" class="global-youtube-popup__iframe" src=""
					title="<?php esc_attr_e('YouTube video', 'repindia'); ?>"
					allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
					allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>

<!-- Smooth scroll effect script -->
<script>
	window.addEventListener("load", function () {
		if (window.location.hash) {
			const el = document.querySelector(window.location.hash);
			if (el) {
				setTimeout(function () {
					el.scrollIntoView({ behavior: "smooth" });
				}, 150);
			}
		}
	});
</script>
<?php
wp_footer();
?>
</body>

</html>
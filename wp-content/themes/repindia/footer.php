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

				<?php require get_template_directory() . '/inc/brands-popup/brands-popup-styles.php'; ?>

				<div class="modal-body-content">
					<?php require get_template_directory() . '/inc/brands-popup/brands-popup-content.php'; ?>
				</div>

				<?php require get_template_directory() . '/inc/brands-popup/brands-popup-script.php'; ?>
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
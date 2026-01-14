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
									<h3 class="footer-accordion-title">
										<?php echo esc_attr($repindia_option['footer_industry_title']); ?> <span
											class="footer-accordion-icon">+</span></h3>
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
											class="footer-accordion-icon">+</span></h3>
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
											class="footer-accordion-icon">+</span></h3>
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
											class="footer-accordion-icon">+</span></h3>
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


<!-- Modal -->
<?php
if (!empty($repindia_option['demo_popup_form'])) 
{ ?>
	<div class="formpopup_modal modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered 	modal-demo-form">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Request a demo</h5>
						<span class="btn-closecustom" data-bs-dismiss="modal" aria-label="Close">
							<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='#000'>
								<path
									d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414' />
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
if (!empty($repindia_option['contact_popup_form'])) 
{ ?>
	<div class="formpopup_modal modal fade" id="contactBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		aria-labelledby="contactBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-demo-form">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<h5 class="modal-title" id="contactBackdropLabel">Talk to our partner team</h5>
						<span class="btn-closecustom" data-bs-dismiss="modal" aria-label="Close">
							<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='#000'>
								<path
									d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414' />
							</svg>
						</span>
					</div>
					<!-- <div class="modal-body-content">
						<h3>Get in Touch</h3>
						<p>We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
					</div> -->
					<?php echo do_shortcode(wp_kses_post($repindia_option['contact_popup_form'])); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<!-- JavaScript to open modals for CTAs with data-modal-target attribute or class -->
<script>
(function() {
	document.addEventListener('DOMContentLoaded', function() {
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
			
			// Check if it's a link with external URL
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
		dataModalTriggers.forEach(function(trigger) {
			var modalId = trigger.getAttribute('data-modal-target');
			if (modalId) {
				trigger.addEventListener('click', function(e) {
					handleModalClick(e, modalId);
				});
			}
		});
		
		// Handle elements with class 'open-demo-modal' (backward compatibility)
		var demoModalTriggers = document.querySelectorAll('.open-demo-modal');
		if (demoModalTriggers.length > 0 && document.getElementById('staticBackdrop')) {
			demoModalTriggers.forEach(function(trigger) {
				// Skip if already has data-modal-target
				if (!trigger.hasAttribute('data-modal-target')) {
					trigger.addEventListener('click', function(e) {
						handleModalClick(e, 'staticBackdrop');
					});
				}
			});
		}
		
		// Handle elements with class 'open-contact-modal'
		var contactModalTriggers = document.querySelectorAll('.open-contact-modal');
		if (contactModalTriggers.length > 0 && document.getElementById('contactBackdrop')) {
			contactModalTriggers.forEach(function(trigger) {
				// Skip if already has data-modal-target
				if (!trigger.hasAttribute('data-modal-target')) {
					trigger.addEventListener('click', function(e) {
						handleModalClick(e, 'contactBackdrop');
					});
				}
			});
		}
	});
})();

//Form Validation
(function() {
  // Wait for jQuery to be available
  function initFormValidationScript() {
    if (typeof jQuery === 'undefined' || typeof jQuery === 'null') {
      // Retry after a short delay
      setTimeout(initFormValidationScript, 50);
      return;
    }

    jQuery(document).ready(function ($) {
      // Function to initialize validation for Contact Form 7 forms
      function initFormValidation() {
        // Company and Job fields validation - fixed trailing comma
        $(document).off('input propertychange', '.wpcf7 input[name="company"], .wpcf7 input[name="job"]');
        $(document).on(
          "input propertychange",
          ".wpcf7 input[name='company'], .wpcf7 input[name='job']",
          function () {
            try {
              var c = this.selectionStart,
                r = /[^a-zA-Z0-9 . , - @ ! \n ]/gi,
                v = $(this).val();
              if (r.test(v)) {
                $(this).val(v.replace(r, ""));
                c--;
              }
              if (this.setSelectionRange) {
                this.setSelectionRange(c, c);
              }
            } catch (e) {
              console.error('Error in company/job validation:', e);
            }
          }
        );

        // Name fields validation - replaced bind() with on() and added event delegation
        $(document).off('input', '.wpcf7 input[name="fname"], .wpcf7 input[name="lname"], .wpcf7 input[name="first_name"], .wpcf7 input[name="last_name"]');
        $(document).on("input", ".wpcf7 input[name='fname'], .wpcf7 input[name='lname'], .wpcf7 input[name='first_name'], .wpcf7 input[name='last_name']", function () {
          try {
            var c = this.selectionStart,
              r = /[^a-zA-Z ]/gi,
              v = $(this).val();
            if (r.test(v)) {
              $(this).val(v.replace(r, ""));
              c--;
            }
            if (this.setSelectionRange) {
              this.setSelectionRange(c, c);
            }
          } catch (e) {
            console.error('Error in name validation:', e);
          }
        });

        // Phone field validation - added event delegation for dynamically loaded forms
        $(document).off('input blur', '.wpcf7 input[name="phone"]');
        $(document).on("input", ".wpcf7 input[name='phone']", function () {
          try {
            var value = this.value.replace(/[^0-9]/g, "");
            if (value.length > 12) {
              value = value.slice(0, 12);
            }
            this.value = value;
            var $errorEl = $(this).closest('.wpcf7-form-control-wrap').find('#mobile-error');
            if ($errorEl.length === 0) {
              $errorEl = $(this).closest('.wpcf7').find('#mobile-error');
            }
            $errorEl.hide();
          } catch (e) {
            console.error('Error in phone input validation:', e);
          }
        });

        $(document).on("blur", ".wpcf7 input[name='phone']", function () {
          try {
            const value = this.value;
            var $errorEl = $(this).closest('.wpcf7-form-control-wrap').find('#mobile-error');
            if ($errorEl.length === 0) {
              $errorEl = $(this).closest('.wpcf7').find('#mobile-error');
            }
            if (value.length < 10) {
              if ($errorEl.length === 0) {
                // Create error element if it doesn't exist
                $errorEl = $('<span id="mobile-error" style="color: red; display: block; margin-top: 5px;">Mobile number must be at least 10 digits.</span>');
                $(this).closest('.wpcf7-form-control-wrap').append($errorEl);
              }
              $errorEl.text("Mobile number must be at least 10 digits.").show();
            } else {
              $errorEl.hide();
            }
          } catch (e) {
            console.error('Error in phone blur validation:', e);
          }
        });

        // Resume file input - added event delegation for dynamically loaded forms
        $(document).off('change', '.wpcf7 input#resume, .wpcf7 input[name="resume"]');
        $(document).on('change', '.wpcf7 input#resume, .wpcf7 input[name="resume"]', function (e) {
          try {
            var fileName = e.target.files.length > 0 ? e.target.files[0].name : "Resume (Max file size: 500 KB)";
            var $noFileEl = $(this).closest('.wpcf7').find('#noFile');
            if ($noFileEl.length === 0) {
              $noFileEl = $(this).closest('.wpcf7-form-control-wrap').find('#noFile');
            }
            if ($noFileEl.length > 0) {
              $noFileEl.text(fileName);
            }
          } catch (e) {
            console.error('Error in resume file input:', e);
          }
        });
      }

      // Initialize validation on page load
      initFormValidation();

      // Re-initialize when Contact Form 7 forms are loaded via AJAX
      $(document).on('wpcf7mailsent wpcf7invalid wpcf7spam wpcf7mailfailed', function () {
        initFormValidation();
      });

      // Also re-initialize when DOM changes (for dynamically loaded forms)
      if (typeof MutationObserver !== 'undefined') {
        var observer = new MutationObserver(function (mutations) {
          var hasNewForm = false;
          mutations.forEach(function (mutation) {
            if (mutation.addedNodes.length > 0) {
              $(mutation.addedNodes).each(function () {
                if ($(this).hasClass('wpcf7') || $(this).find('.wpcf7').length > 0) {
                  hasNewForm = true;
                  return false;
                }
              });
            }
          });
          if (hasNewForm) {
            setTimeout(initFormValidation, 100);
          }
        });

        observer.observe(document.body, {
          childList: true,
          subtree: true
        });
      }
    });
  }

  // Start initialization
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFormValidationScript);
  } else {
    initFormValidationScript();
  }
})();
</script>

<?php
wp_footer();
?>
</body>

</html>
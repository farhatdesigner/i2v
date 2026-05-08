<?php repindia_get_header(); 
$newscategories = get_the_category();

	while(have_posts()) 
	{
		the_post();
		global $repindia_option,$post; 
		// Get ACF download file URL for this Resource
		$resource_download_url = get_field('resource_file_url');
		// Get ACF form shortcode and extract form ID dynamically
		$resource_form_shortcode = get_field('resource_form_short_code');
		$resource_form_id = '';
		if (!empty($resource_form_shortcode)) {
			// Extract form ID from shortcode: [contact-form-7 id="123"] or [contact-form-7 id="6cb5dc6" title="Form"]
			preg_match('/id=["\']([^"\']+)["\']/', $resource_form_shortcode, $matches);
			if (!empty($matches[1])) {
				$resource_form_id = $matches[1];
			}
		}
		?>
    
    <!-- Resource Thank You Popup Styles -->
    <style>
        .resource-modal-overlay {
            display: none !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .resource-modal-overlay.active {
            display: flex !important;
        }

        .resource-modal-content {
            background: #fff;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            border-radius: 5px;
            position: relative;
            text-align: center;
        }

        .resource-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
            color: #333;
            line-height: 1;
        }

        .resource-modal-close:hover {
            color: #0099ed;
        }

        .resource-thankyou h3 {
            color: #0099ed;
            margin-bottom: 15px;
            font-size: 24px;
        }
        
        .resource-thankyou p {
            margin-bottom: 20px;
            color: #333;
        }

        @media (max-width: 768px) {
            .resource-modal-content {
                width: 95%;
                padding: 25px 20px;
            }
            .resource-thankyou h3 {
                font-size: 20px;
            }
        }
    </style>

    <div class="custom-container">
            <?php
            if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            } 
            ?>
        </div>
    <?php the_content();  ?>

    <!-- Resource Thank You Popup Modal - Only show if download_file_url exists -->
    <?php if($resource_download_url): ?>
    <div class="resource-modal-overlay" id="resourceThankYouModal" data-resource-post-id="<?php echo esc_attr(get_the_ID()); ?>" <?php if($resource_form_id): ?>data-resource-form-id="<?php echo esc_attr($resource_form_id); ?>"<?php endif; ?>>
        <div class="resource-modal-content">
            <span class="resource-modal-close">&times;</span>
            <div class="resource-thankyou">
                <h3>Thank You!</h3>
                <p>Your request has been submitted successfully.</p>
                <a href="<?php echo esc_url($resource_download_url); ?>" target="_blank" class="theme-btn xl-btn" id="resourceDownloadBtn" download>Download Resource</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

	<?php 
	}
	?>
<?php get_footer(); ?>

<!-- Resource Thank You Popup JavaScript - Only for single-resources.php -->
<script>
(function() {
    // Only run on single-resources.php page
    if (typeof jQuery === 'undefined') {
        return;
    }
    
    var $ = jQuery;
    
    // Function to close modal
    function closeResourceModal() {
        var $modal = $('#resourceThankYouModal');
        if ($modal.length) {
            $modal.removeClass('active');
            $('body').css('overflow', '');
        }
    }
    
    // Wait for DOM ready
    jQuery(document).ready(function($) {
        var $modal = $('#resourceThankYouModal');
        
        // Only proceed if modal exists (download_url field is set)
        if (!$modal.length) {
            return;
        }
        
        function openResourceModal() {
            $modal.addClass('active');
            $('body').css('overflow', 'hidden');
        }

        // Listen for Contact Form 7 success for this template only (Elementor-rendered forms included)
        $(document).on('wpcf7mailsent', function(event) {
            var $submittedForm = $(event.target);

            // Ignore events from modal forms (safety)
            if ($submittedForm.closest('#brochureModal, .formpopup_modal').length) {
                return;
            }

            // Open popup for visible non-modal CF7 forms on single-resources template.
            var isVisiblePageForm = $submittedForm.length && $submittedForm.is(':visible');

            if (isVisiblePageForm) {
                openResourceModal();
            }
        });
        
        // Close modal on X button click - Bind directly to modal using event delegation
        $modal.on('click', '.resource-modal-close', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeResourceModal();
            return false;
        });
        
        // Close modal on overlay click (when clicking outside content) - Bind directly to modal
        $modal.on('click', function(e) {
            // Close only if clicking directly on the overlay element itself
            if (e.target === this || $(e.target).hasClass('resource-modal-overlay')) {
                e.preventDefault();
                closeResourceModal();
                return false;
            }
        });
        
        // Close modal after download click without reloading page
        $modal.on('click', '#resourceDownloadBtn', function(e) {
            // Allow default link behavior (open download)
            e.stopPropagation(); // Prevent bubbling to overlay handler
            // Close modal after short delay to allow download to start
            setTimeout(function() {
                closeResourceModal();
            }, 500);
        });
        
        // Prevent modal content and children clicks from closing modal - Stop propagation
        // But don't stop if it's the download button (handled above)
        $modal.on('click', '.resource-modal-content', function(e) {
            // Don't stop propagation if clicking on download button
            if (!$(e.target).closest('#resourceDownloadBtn').length && e.target !== document.getElementById('resourceDownloadBtn')) {
                e.stopPropagation();
            }
        });
        
        // Also prevent clicks inside resource-thankyou from closing
        $modal.on('click', '.resource-thankyou', function(e) {
            // Don't stop propagation if clicking on download button
            if (!$(e.target).closest('#resourceDownloadBtn').length && e.target !== document.getElementById('resourceDownloadBtn')) {
                e.stopPropagation();
            }
        });
    });
})();
</script>

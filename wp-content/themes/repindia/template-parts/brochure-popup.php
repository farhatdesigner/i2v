<?php
/**
 * Brochure Popup Component
 * 
 * Reusable component for displaying brochure download popup with CF7 form.
 * Only displays if download_file_url ACF field exists.
 * 
 * Usage: include this file in any template where brochure popup is needed.
 */

// Check if download_file_url field exists
$download_file_url = get_field_object('download_file_url');
$download_b = get_field('download_file_url');

// Only render if download file URL exists
if ($download_b) { ?>
    <!-- /* Brochure Popup Styles */ -->
    <style>
        .brochure-modal-overlay {
            display: none;
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

        .brochure-modal-overlay.active {
            display: flex;
        }

        .brochure-modal-content {
            background: #fff;
            padding: 30px 0;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 5px;
            position: relative;
        }

        .brochure-modal-close {
            position: absolute;
            top: 25px;
            right: 15px;
            font-size: 28px;
            cursor: pointer;
            color: #333;
            line-height: 1;
        }

        .brochure-modal-close:hover {
            color: #0099ed;
        }

        .brochure-thankyou {
            text-align: center;
            display: none;
            padding: 30px 25px;
        }

        .brochure-thankyou.active {
            display: block;
        }

        .brochure-thankyou h3 {
            color: #0099ed;
            margin-bottom: 15px;
        }
        
        .brochure-thankyou p {
            margin-bottom: 20px;
        }

        .brochure_form h4 { margin: 0; font-size: 32px; font-weight: 700; color: #000; text-transform: uppercase; letter-spacing: unset; line-height: 28px; padding: 0px 0px 30px; text-align: center; }
        .brochure_form { width: 100%; }
        .brochure_form .form-control { width: 100%;padding: 11px 15px;border: 1px solid rgba(0, 0, 0, 1);border-radius: 0;font-size: 14px;margin-bottom: 13px;box-sizing: border-box;transition: border-color 0.3s ease;background: transparent;font-weight: 400;line-height: normal;text-transform: capitalize; }
        .brochure_form .form-control:focus { outline: none;border-color: #000;background: #fff; }
        .brochure_form .form-control::placeholder { color: #999;text-transform: capitalize;font-weight: 500;font-size: 14px;opacity: 0.8;letter-spacing: 0.5px; }
        .brochure_form .form-control::-webkit-input-placeholder { color: #999;text-transform: capitalize;font-weight: 500;font-size: 14px;opacity: 0.8;letter-spacing: 0.5px; }
        .brochure_form .form-control::-moz-placeholder { color: #999;text-transform: capitalize;font-weight: 500;font-size: 14px;opacity: 0.8;letter-spacing: 0.5px; }
        .brochure_form .form-control::-moz-placeholder { color: #999;text-transform: capitalize;font-weight: 500;font-size: 14px;opacity: 0.8;letter-spacing: 0.5px; }
        .brochure_form .form-control:-ms-input-placeholder { color: #999;text-transform: capitalize;font-weight: 500;font-size: 14px;opacity: 0.8;letter-spacing: 0.5px; }
        .brochure_form textarea.form-control { resize: vertical;min-height: 82px; }
        .brochure_form label { display: block;font-weight: bold;margin-bottom: 10px;color: #000; }
        .brochure_form .file-disclaimer { display: block;font-size: 13px;color: #333;margin-bottom: 20px;font-weight: 500; }
        .brochure_form .btn { width: 100%;background: #000;color: #fff;padding: 18px 15px;border: none;border-radius: 0;font-size: 16px;font-weight: bold;text-transform: uppercase;cursor: pointer;transition: background 0.3s ease; }
        .brochure_form .btn:hover { background: #333; }
        .brochure_form .wpcf7-form-control-wrap { position: relative; }
        .brochure_form .wpcf7-form-control-wrap .upload-btn { display: flex !important; }
        .brochure_submit{ position: relative; }
        .wpcf7-spinner{ margin: 0;background-color: #b1b1b1;position: absolute;right: 6px;top: 38px; }
        .brochure-modal-overlay .modal-header {
            display: flex;
            padding: 20px;
            align-items: center;
            width: 100%;
            justify-content: space-between;
            padding: 0 25px;
        }
        .brochure-modal-overlay .modal-title {
            margin-bottom: 0;
            color: #06283d;
            font-size: 18px;
            font-weight: 600;
            line-height: 130%;
        }
        @media (max-width: 768px) {
            .brochure-modal-content { width: 95%;margin: 10px;padding: 20px; }
            .brochure_form h4 { font-size: 24px;padding: 0 0 20px 0; }
            .brochure_form .form-control { padding: 12px;font-size: 14px;margin-bottom: 15px; }
            .brochure_form .btn { padding: 15px;font-size: 14px; }
        }
        @media (max-width: 480px) {
            .brochure-modal-content { width: 98%;margin: 5px;padding: 15px; }
            .brochure_form h4 { font-size: 20px; }
            .brochure_form .form-control { padding: 10px;font-size: 13px; }
        }
    </style>

    <div class="brochure-modal-overlay" id="brochureModal">
        <div class="brochure-modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactBackdropLabel">Download Brochure</h5>
                <span class="brochure-modal-close">&times;</span>
            </div>
            <div class="brochure-form-wrapper">
                <?php
                $selected_form_id = get_field('brochure_form'); 
                if ($selected_form_id) {
                    echo do_shortcode('[contact-form-7 id="' . $selected_form_id . '"]');
                } else {
                    echo do_shortcode('[contact-form-7 id="9a3625d" title="Download Brochure"]');
                } ?>
            </div>
            <div class="brochure-thankyou">
                <h3>Thank You!</h3>
                <p>Your request has been submitted successfully.</p>
                <a href="<?php echo esc_url($download_file_url['value']); ?>" target="_blank" class="theme-btn xl-btn">Download Brochure</a>
            </div>
        </div>
    </div>

    <script>
    (function() {
        function initBrochureModal() {
            if (typeof jQuery === 'undefined') {
                setTimeout(initBrochureModal, 100);
                return;
            }
            
            var $ = jQuery;
            
            function setupBrochureModal() {
                // Open modal on brochure link click - Use event delegation for dynamic content
                $(document).on('click', '.brochure-popup-trigger', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var $modal = $('#brochureModal');
                    if ($modal.length) {
                        $modal.addClass('active');
                        $('body').css('overflow', 'hidden');
                    } else {
                        console.warn('Brochure modal not found. Make sure download_file_url field is set.');
                    }
                });

                // Close modal - Use event delegation
                $(document).on('click', '.brochure-modal-close, .brochure-modal-overlay', function(e) {
                    if (e.target === this) {
                        var $modal = $('#brochureModal');
                        $modal.removeClass('active');
                        $('body').css('overflow', '');
                        // Reset modal state - show form, hide thank you (for next time)
                        $('.brochure-form-wrapper').show();
                        $('.brochure-thankyou').removeClass('active');
                    }
                });

                // Prevent modal content click from closing
                $(document).on('click', '.brochure-modal-content', function(e) {
                    e.stopPropagation();
                });
                
                // Handle download button click - close modal after opening download
                $(document).on('click', '.brochure-thankyou .theme-btn, .brochure-thankyou a', function(e) {
                    var $modal = $('#brochureModal');
                    // Small delay to ensure download starts, then close modal
                    setTimeout(function() {
                        $modal.removeClass('active');
                        $('body').css('overflow', '');
                        // Reset modal state - show form, hide thank you (for next time)
                        $('.brochure-form-wrapper').show();
                        $('.brochure-thankyou').removeClass('active');
                    }, 300);
                });
            }
            
            // Initialize on document ready
            jQuery(document).ready(function($) {
                setupBrochureModal();
            });
            
            // Re-initialize for Elementor dynamic content
            if (typeof elementorFrontend !== 'undefined') {
                jQuery(window).on('elementor/frontend/init', function() {
                    setupBrochureModal();
                });
            }

            // Handle Contact Form 7 submission success
            $(document).on('wpcf7mailsent', function(event) {
                var $form = $(event.target);
                if ($form.closest('#brochureModal').length) {
                    $('.brochure-form-wrapper').hide();
                    $('.brochure-thankyou').addClass('active');
                }
            });
        }
        
        initBrochureModal();
    })();
    </script>
<?php } ?>

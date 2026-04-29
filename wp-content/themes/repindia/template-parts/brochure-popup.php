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
    <!-- /* Brochure Popup Styles - Bootstrap modal structure, custom content styling */ -->
    <style>
        .brochure-modal-overlay .modal-dialog {
            max-width: 768px;
        }

        .brochure-modal-overlay .modal-content {
            border-radius: 5px;
        }

        .brochure-modal-content {
            background: #fff;
            max-height: 100vh;
            height: 95vh;
            /* height: calc(100vh - 160px); */
            overflow: auto;
            scroll-behavior: smooth;
            scrollbar-width: thin;
            scrollbar-color: #d5d5d5 transparent;
            position: relative;
        }


        /* Custom scrollbar for webkit browsers (Chrome, Safari, Edge) */
        .brochure-modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .brochure-modal-content::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 10px;
        }

        .brochure-modal-content::-webkit-scrollbar-thumb {
            background: #d5d5d5;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .brochure-modal-content::-webkit-scrollbar-thumb:hover {
            background: #d5d5d5;
        }

        /* Hide scrollbar arrows/buttons */
        .brochure-modal-content::-webkit-scrollbar-button {
            display: none;
            height: 0;
            width: 0;
        }

.js-dark  .brochure-modal-content {scrollbar-color: rgba(255, 255, 255, 0.3) transparent;}

        .brochure_download {
            padding: 20px 30px;
            padding-top: 85px;
        }

        .brochure_download p {
            margin: 0;
        }

        .brochure_download input.form-control,
        .brochure_download select.form-control {
            height: 40px;
        }

        .brochure-modal-overlay .brochure-modal-close:hover,
        .brochure-modal-overlay .btn-closecustom:hover {
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

        .brochure_form h4 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            letter-spacing: unset;
            line-height: 28px;
            padding: 0px 0px 30px;
            text-align: center;
        }

        .brochure_form {
            width: 100%;
        }

        .brochure_form .form-control {
            width: 100%;
            padding: 11px 15px;
            border: 1px solid rgba(0, 0, 0, 1);
            border-radius: 0;
            font-size: 14px;
            margin-bottom: 13px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
            background: transparent;
            font-weight: 400;
            line-height: normal;
            text-transform: capitalize;
        }

        .brochure_form .form-control:focus {
            outline: none;
            border-color: #000;
            background: #fff;
        }

        .brochure_form .form-control::placeholder {
            color: #999;
            text-transform: capitalize;
            font-weight: 500;
            font-size: 14px;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }

        .brochure_form .form-control::-webkit-input-placeholder {
            color: #999;
            text-transform: capitalize;
            font-weight: 500;
            font-size: 14px;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }

        .brochure_form .form-control::-moz-placeholder {
            color: #999;
            text-transform: capitalize;
            font-weight: 500;
            font-size: 14px;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }

        .brochure_form .form-control::-moz-placeholder {
            color: #999;
            text-transform: capitalize;
            font-weight: 500;
            font-size: 14px;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }

        .brochure_form .form-control:-ms-input-placeholder {
            color: #999;
            text-transform: capitalize;
            font-weight: 500;
            font-size: 14px;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }

        .brochure_form textarea.form-control {
            resize: vertical;
            min-height: 82px;
        }

        .brochure_form label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
        }

        .brochure_form .file-disclaimer {
            display: block;
            font-size: 13px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .brochure_form .btn {
            width: 100%;
            background: #000;
            color: #fff;
            padding: 18px 15px;
            border: none;
            border-radius: 0;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .brochure_form .btn:hover {
            background: #333;
        }

        .brochure_form .wpcf7-form-control-wrap {
            position: relative;
        }

        .brochure_form .wpcf7-form-control-wrap .upload-btn {
            display: flex !important;
        }

        .brochure_submit {
            position: relative;
        }

        .wpcf7-spinner {
            margin: 0;
            background-color: #b1b1b1;
            position: absolute;
            right: 6px;
            top: 38px;
        }

        .brochure-modal-overlay .modal-header {
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: space-between;
            padding: 15px 15px;
            position: fixed;
            max-width: 766px;
            background: #fff;
            z-index: 2;
        }

        .brochure-modal-overlay .modal-title {
            margin-bottom: 0;
            color: #06283d;
            font-size: 18px;
            font-weight: 600;
            line-height: 130%;
        }

        @media (max-width: 768px) {


            .brochure_form h4 {
                font-size: 24px;
                padding: 0 0 20px 0;
            }

            .brochure_form .form-control {
                padding: 12px;
                font-size: 14px;
                margin-bottom: 15px;
            }

            .brochure_form .btn {
                padding: 15px;
                font-size: 14px;
            }
        }

        @media (max-width: 767px) {

            .brochure_form h4 {
                font-size: 20px;
            }

            .brochure_form .form-control {
                padding: 10px;
                font-size: 13px;
            }

            .brochure-modal-overlay .modal-header {
                max-width: calc(100% - 18px);
            }
        }
    </style>

    <div class="brochure-modal-overlay modal fade" id="brochureModal" data-bs-backdrop="static" data-bs-keyboard="true"
        tabindex="-1" aria-labelledby="brochureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content brochure-modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title" id="brochureModalLabel">Download Brochure</h5>
                        <!-- <span class="brochure-modal-close btn-closecustom" data-bs-dismiss="modal"
                            aria-label="Close">&times;</span> -->
                        <span class="btn-closecustom" data-bs-dismiss="modal" aria-label="Close">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.67339 8.67351C9.03788 8.30902 9.62883 8.30902 9.99332 8.67351L14 12.6802L18.0067 8.67351C18.3712 8.30902 18.9622 8.30902 19.3267 8.67351C19.6911 9.038 19.6911 9.62896 19.3267 9.99345L15.32 14.0001L19.3267 18.0068C19.6911 18.3713 19.6911 18.9623 19.3267 19.3268C18.9622 19.6913 18.3712 19.6913 18.0067 19.3268L14 15.3201L9.99332 19.3268C9.62883 19.6913 9.03788 19.6913 8.67339 19.3268C8.3089 18.9623 8.3089 18.3713 8.67339 18.0068L12.6801 14.0001L8.67339 9.99345C8.3089 9.62896 8.3089 9.038 8.67339 8.67351Z"
                                    fill="#5F6F94" />
                            </svg>
                        </span>
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
                        <a href="<?php echo esc_url($download_file_url['value']); ?>" target="_blank"
                            class="theme-btn xl-btn" id="brochureDownloadBtn" download>Download Brochure</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            function initBrochureModal() {
                if (typeof jQuery === 'undefined') {
                    setTimeout(initBrochureModal, 100);
                    return;
                }

                var $ = jQuery;
                var brochureModalEl = document.getElementById('brochureModal');

                function openBrochureModal() {
                    if (!brochureModalEl) return;
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        var modalInstance = bootstrap.Modal.getOrCreateInstance(brochureModalEl);
                        modalInstance.show();
                    } else if ($.fn.modal) {
                        $(brochureModalEl).modal('show');
                    }
                }

                function resetBrochureModalState() {
                    var $modal = $('#brochureModal');
                    $modal.find('.brochure-form-wrapper').show();
                    $modal.find('.brochure-thankyou').removeClass('active');
                }

                function setupBrochureModal() {
                    // Open modal on brochure link click - Use event delegation for dynamic content
                    $(document).on('click', '.brochure-popup-trigger', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        openBrochureModal();
                    });

                    // Reset form/thank you when Bootstrap modal is hidden (close, backdrop, Escape)
                    if (brochureModalEl) {
                        $(brochureModalEl).on('hidden.bs.modal', function () {
                            resetBrochureModalState();
                        });
                    }

                    // Handle download button click - close modal after opening download (Bootstrap close)
                    $(document).on('click', '#brochureModal .brochure-thankyou .theme-btn, #brochureModal .brochure-thankyou a', function (e) {
                        var modal = document.getElementById('brochureModal');
                        if (!modal) return;
                        setTimeout(function () {
                            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                                var modalInstance = bootstrap.Modal.getInstance(modal);
                                if (modalInstance) modalInstance.hide();
                            } else if ($.fn.modal) {
                                $(modal).modal('hide');
                            }
                        }, 300);
                    });
                }

                jQuery(document).ready(function ($) {
                    setupBrochureModal();
                });

                if (typeof elementorFrontend !== 'undefined') {
                    jQuery(window).on('elementor/frontend/init', function () {
                        setupBrochureModal();
                    });
                }

                // Handle Contact Form 7 submission success (unchanged)
                $(document).on('wpcf7mailsent', function (event) {
                    var $form = $(event.target);
                    if ($form.closest('#brochureModal').length) {
                        var $modal = $('#brochureModal');
                        $modal.find('.brochure-form-wrapper').hide();
                        $modal.find('.brochure-thankyou').addClass('active');
                        // Keep modal open even if other listeners try to close it on submit.
                        setTimeout(function () {
                            openBrochureModal();
                        }, 50);
                    }
                });
            }

            initBrochureModal();
        })();
    </script>
<?php } ?>
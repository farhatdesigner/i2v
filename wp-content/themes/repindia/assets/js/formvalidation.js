/**
 * Contact Form 7 Validation Script
 * Handles form validation, input sanitization, and submit button control
 */
(function() {
  'use strict';
  
  // Wait for jQuery to be available
  function initFormValidationScript() {
    if (typeof jQuery === 'undefined' || typeof jQuery === 'null') {
      setTimeout(initFormValidationScript, 50);
      return;
    }

    jQuery(document).ready(function ($) {
      // Constants and regex patterns
      var EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      var PHONE_REGEX = /[^0-9]/g;
      var NAME_REGEX = /[^a-zA-Z ]/gi;
      var COMPANY_JOB_REGEX = /[^a-zA-Z0-9 . , - @ ! \n ]/gi;
      var MESSAGE_REGEX = /[^a-zA-Z0-9 . , - @ ! ? : ; ( ) [ ] { } \n \r \t ]/gi; // Allow common punctuation in messages
      var DEBOUNCE_DELAY = 300;
      
      // Cache for debouncing validation
      var validationTimers = {};
      
      // Helper: Check if field is required
      function isFieldRequired($field) {
        // Check multiple ways Contact Form 7 marks required fields
        // 1. Direct class on field
        if ($field.hasClass('wpcf7-validates-as-required')) return true;
        
        // 2. HTML5 required attribute
        if ($field.attr('aria-required') === 'true') return true;
        if ($field.attr('required') === 'required' || $field.prop('required')) return true;
        
        // 3. Required indicator in parent wrap
        var $wrap = $field.closest('.wpcf7-form-control-wrap');
        if ($wrap.find('span.wpcf7-validates-as-required').length > 0) return true;
        if ($wrap.find('.wpcf7-validates-as-required').length > 0) return true;
        
        // 4. Check if wrap has 'optional' class - if it does, field is NOT required
        if ($wrap.hasClass('optional')) return false;
        
        // 5. Check for required indicators in label (asterisk, required class)
        var $label = $wrap.find('label');
        if ($label.length) {
          var labelText = $label.text();
          var labelHtml = $label.html() || '';
          // Check for asterisk or required class in label
          if (labelText.indexOf('*') !== -1 || $label.find('.required, .wpcf7-validates-as-required').length > 0) {
            return true;
          }
          // Check if label contains required indicator
          if (labelHtml.indexOf('wpcf7-validates-as-required') !== -1) {
            return true;
          }
        }
        
        // 6. For Contact Form 7, fields without 'optional' class on wrap are typically required
        // But only if there's no explicit optional indicator
        // This is a fallback - be conservative
        return false;
      }
      
      // Helper: Get field value based on type
      function getFieldValue($field, $form) {
        if ($field.is('input[type="text"], input[type="email"], input[type="tel"], input[type="url"], textarea')) {
          return $field.val().trim();
        } else if ($field.is('select')) {
          return $field.val();
        } else if ($field.is('input[type="checkbox"], input[type="radio"]')) {
          var $group = $form.find('input[name="' + $field.attr('name') + '"]');
          return $group.filter(':checked').length > 0 ? 'checked' : '';
        }
        return '';
      }
      
      // Helper: Validate specific field types
      function validateField($field, $form) {
        if (!$field.is(':visible')) return true;
        
        var value = getFieldValue($field, $form);
        var fieldName = $field.attr('name') || '';
        var fieldType = $field.attr('type') || '';
        var isTextarea = $field.is('textarea');
        
        // Check if required and empty
        if (isFieldRequired($field) && (!value || value === '')) {
          return false;
        }
        
        // Type-specific validation
        if (value && value !== '') {
          // Email validation
          if (fieldType === 'email' || fieldName.indexOf('email') !== -1) {
            return EMAIL_REGEX.test(value);
          }
          // Phone validation
          if (fieldName === 'phone' || fieldType === 'tel') {
            var phoneDigits = value.replace(PHONE_REGEX, '');
            return phoneDigits.length >= 10 && phoneDigits.length <= 15;
          }
          // Message textarea validation - check minimum length if required
          if (isTextarea && (fieldName === 'message' || fieldName.indexOf('message') !== -1)) {
            // If required, ensure it has meaningful content (at least 10 characters)
            if (isFieldRequired($field) && value.length < 10) {
              return false;
            }
          }
        }
        
        return true;
      }
      
      // Optimized validation check
      function checkFormValidation($form) {
        try {
          // Early return if form has no fields
          var $allFields = $form.find('input, select, textarea').not('input[type="submit"], input[type="hidden"], input[type="button"]');
          if ($allFields.length === 0) return true;
          
          // Check all fields - find required fields using isFieldRequired helper
          var allFieldsValid = true;
          $allFields.each(function() {
            var $field = $(this);
            
            // Skip if field is not visible
            if (!$field.is(':visible')) return true;
            
            // Check if field is required
            if (isFieldRequired($field)) {
              // Validate required field
              if (!validateField($field, $form)) {
                allFieldsValid = false;
                return false; // break
              }
            } else {
              // For optional fields, still validate format if they have a value
              var value = getFieldValue($field, $form);
              if (value && value !== '') {
                if (!validateField($field, $form)) {
                  allFieldsValid = false;
                  return false; // break
                }
              }
            }
          });
          
          if (!allFieldsValid) return false;
          
          // Additional validation for specific field types with custom logic
          var fieldChecks = [
            { selector: 'input[name="phone"]', validate: function($f) {
              var $wrap = $f.closest('.wpcf7-form-control-wrap');
              var isIntlTelInput = $f.closest('.intl-tel-input').length > 0 || 
                                   $wrap.find('.intl-tel-input').length > 0 ||
                                   $f.hasClass('intl-tel-input') ||
                                   typeof window.intlTelInput !== 'undefined';
              
              if (isIntlTelInput) {
                // For intl-tel-input, get national number
                var iti = $f.data('intlTelInput') || (window.intlTelInputGlobals && window.intlTelInputGlobals.getInstance($f[0]));
                var phoneNumber = '';
                
                if (iti && typeof iti.getNumber === 'function') {
                  try {
                    phoneNumber = iti.getNumber(window.intlTelInputUtils.numberFormat.NATIONAL) || '';
                    phoneNumber = phoneNumber.replace(/[^0-9]/g, '');
                  } catch(e) {
                    var fullNumber = $f.val().replace(/[^0-9]/g, '');
                    // Remove country code if present
                    if (fullNumber.indexOf('91') === 0 && fullNumber.length > 2) {
                      phoneNumber = fullNumber.substring(2);
                    } else {
                      phoneNumber = fullNumber;
                    }
                  }
                } else {
                  var fullNumber = $f.val().replace(/[^0-9]/g, '');
                  // Remove country code if present
                  if (fullNumber.indexOf('91') === 0 && fullNumber.length > 2) {
                    phoneNumber = fullNumber.substring(2);
                  } else {
                    phoneNumber = fullNumber;
                  }
                }
                
                // If required, must be valid; if optional and has value, must be valid
                if (isFieldRequired($f)) {
                  return phoneNumber.length >= 10 && phoneNumber.length <= 15;
                } else {
                  return !phoneNumber || (phoneNumber.length >= 10 && phoneNumber.length <= 15);
                }
              } else {
                // Standard phone field validation
                var val = $f.val().replace(PHONE_REGEX, '');
                if (isFieldRequired($f)) {
                  return val.length >= 10 && val.length <= 15;
                } else {
                  return !val || (val.length >= 10 && val.length <= 15);
                }
              }
            }},
            { selector: 'input[type="email"], input[name="email"], input[name="your-email"]',
              validate: function($f) {
                var val = $f.val().trim();
                if (isFieldRequired($f)) {
                  return val.length > 0 && EMAIL_REGEX.test(val);
                } else {
                  return !val || EMAIL_REGEX.test(val);
                }
              }},
            { selector: 'textarea[name="message"]',
              validate: function($f) {
                var val = $f.val().trim();
                // If required, must have at least 10 characters
                if (isFieldRequired($f)) {
                  return val.length >= 10;
                }
                return true;
              }}
          ];
          
          for (var i = 0; i < fieldChecks.length; i++) {
            var $fields = $form.find(fieldChecks[i].selector);
            if ($fields.length > 0) {
              var valid = true;
              $fields.each(function() {
                var $f = $(this);
                if (!$f.is(':visible')) return true;
                if (!fieldChecks[i].validate($f)) {
                  valid = false;
                  return false; // break
                }
              });
              if (!valid) return false;
            }
          }
          
          return true;
        } catch (e) {
          console.error('Validation error:', e);
          return false;
        }
      }
      
      // Toggle submit button
      function toggleSubmitButton($form, enable) {
        var $submitBtn = $form.find('input[type="submit"], button[type="submit"], .wpcf7-submit');
        if ($submitBtn.length) {
          $submitBtn.prop('disabled', !enable).toggleClass('wpcf7-disabled', !enable);
        }
      }
      
      // Debounced validation update
      function validateAndUpdateSubmit($form) {
        var formId = $form.attr('id') || $form.index();
        clearTimeout(validationTimers[formId]);
        validationTimers[formId] = setTimeout(function() {
          try {
            toggleSubmitButton($form, checkFormValidation($form));
          } catch (e) {
            console.error('Validation update error:', e);
          }
        }, DEBOUNCE_DELAY);
      }

      // Sanitize input based on field type
      function sanitizeInput(field, regex, maxLength) {
        var c = field.selectionStart;
        var v = field.value;
        if (regex.test(v)) {
          field.value = v.replace(regex, '');
          c = Math.max(0, c - 1);
        }
        if (maxLength && field.value.length > maxLength) {
          field.value = field.value.slice(0, maxLength);
        }
        if (field.setSelectionRange) {
          field.setSelectionRange(c, c);
        }
      }
      
      // Handle phone error display
      function handlePhoneError($field, $form, value, isBlur) {
        var $errorEl = $field.closest('.wpcf7-form-control-wrap').find('#mobile-error');
        if (!$errorEl.length) {
          $errorEl = $form.find('#mobile-error');
        }
        
        // Validate: min 10 digits, max 12 digits
        if (value.length > 0) {
          if (value.length < 10) {
            if (!$errorEl.length) {
              $errorEl = $('<span id="mobile-error" style="color: red; display: block; margin-top: 5px;">Mobile number must be at least 10 digits.</span>');
              $field.closest('.wpcf7-form-control-wrap').append($errorEl);
            }
            if (isBlur || value.length > 0) {
              $errorEl.text('Mobile number must be at least 10 digits.').show();
            }
          } else if (value.length > 15) {
            if (!$errorEl.length) {
              $errorEl = $('<span id="mobile-error" style="color: red; display: block; margin-top: 5px;">Mobile number cannot exceed 15 digits.</span>');
              $field.closest('.wpcf7-form-control-wrap').append($errorEl);
            }
            $errorEl.text('Mobile number cannot exceed 15 digits.').show();
          } else {
            $errorEl.hide();
          }
        } else {
          $errorEl.hide();
        }
      }
      
      // Consolidated event handlers
      function setupEventHandlers() {
        var $doc = $(document);
        
        // Input sanitization and validation - consolidated handlers
        var handlers = [
          {
            events: 'input propertychange',
            selector: '.wpcf7 input[name="company"], .wpcf7 input[name="job"]',
            sanitize: function(field) { sanitizeInput(field, COMPANY_JOB_REGEX); }
          },
          {
            events: 'input blur',
            selector: '.wpcf7 input[name="fname"], .wpcf7 input[name="lname"], .wpcf7 input[name="first_name"], .wpcf7 input[name="last_name"]',
            sanitize: function(field) { sanitizeInput(field, NAME_REGEX); }
          },
          {
            events: 'input blur keydown paste',
            selector: '.wpcf7 input[name="phone"]',
            sanitize: function(field, event) {
              var $field = $(field);
              var $wrap = $field.closest('.wpcf7-form-control-wrap');
              
              // Check if using intl-tel-input plugin
              var isIntlTelInput = $field.closest('.intl-tel-input').length > 0 || 
                                   $wrap.find('.intl-tel-input').length > 0 ||
                                   $field.hasClass('intl-tel-input') ||
                                   typeof window.intlTelInput !== 'undefined';
              
              // If using intl-tel-input, work with the plugin instead of against it
              if (isIntlTelInput) {
                // Get the intl-tel-input instance
                var iti = $field.data('intlTelInput') || window.intlTelInputGlobals?.getInstance($field[0]);
                
                if (event && (event.type === 'input' || event.type === 'blur' || event.type === 'paste')) {
                  setTimeout(function() {
                    var phoneNumber = '';
                    
                    // Try to get the national number (without country code)
                    if (iti && typeof iti.getNumber === 'function') {
                      try {
                        var numberType = iti.getNumberType();
                        phoneNumber = iti.getNumber(window.intlTelInputUtils.numberFormat.NATIONAL) || '';
                        // Remove all non-numeric characters for validation
                        phoneNumber = phoneNumber.replace(/[^0-9]/g, '');
                      } catch(e) {
                        // Fallback to field value
                        phoneNumber = $field.val().replace(/[^0-9]/g, '');
                      }
                    } else {
                      // Fallback: get value and try to extract national number
                      var fullNumber = $field.val().replace(/[^0-9]/g, '');
                      // If starts with country code (91 for India), remove it
                      if (fullNumber.indexOf('91') === 0 && fullNumber.length > 2) {
                        phoneNumber = fullNumber.substring(2);
                      } else {
                        phoneNumber = fullNumber;
                      }
                    }
                    
                    // Validate national number (10-12 digits)
                    handlePhoneError($field, $field.closest('.wpcf7'), phoneNumber, event.type === 'blur');
                    validateAndUpdateSubmit($field.closest('.wpcf7'));
                  }, 100);
                }
                return; // Don't interfere with intl-tel-input's own handling
              }
              
              // Standard phone field (not using intl-tel-input) - apply strict validation
              // Prevent non-numeric keys on keydown
              if (event && event.type === 'keydown') {
                var key = event.keyCode || event.which;
                // Allow: backspace (8), delete (46), tab (9), escape (27), enter (13), arrow keys (37-40), home (36), end (35)
                var allowedKeys = [8, 9, 27, 13, 46, 37, 38, 39, 40, 36, 35];
                if (allowedKeys.indexOf(key) !== -1) {
                  return; // Allow these keys
                }
                // Allow Ctrl+A (65), Ctrl+C (67), Ctrl+V (86), Ctrl+X (88)
                if ((event.ctrlKey || event.metaKey) && [65, 67, 86, 88].indexOf(key) !== -1) {
                  return; // Allow these shortcuts
                }
                // Only allow number keys (0-9 on main keyboard and numpad)
                if (!((key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                  event.preventDefault();
                  return false;
                }
              }
              
              // For input and paste events, clean the value (only for non-intl-tel-input fields)
              if (event && (event.type === 'input' || event.type === 'paste')) {
                setTimeout(function() {
                  var currentValue = $field.val();
                  var numericOnly = currentValue.replace(/[^0-9]/g, '');
                  
                  // Limit to 12 digits max
                  if (numericOnly.length > 15) {
                    numericOnly = numericOnly.substring(0, 15);
                  }
                  
                  // Update field with clean value
                  var cursorPos = field.selectionStart;
                  $field.val(numericOnly);
                  $field.data('prev-phone-value', numericOnly);
                  
                  // Restore cursor position
                  if (field.setSelectionRange) {
                    var newPos = Math.min(cursorPos, numericOnly.length);
                    field.setSelectionRange(newPos, newPos);
                  }
                  
                  // Validate
                  handlePhoneError($field, $field.closest('.wpcf7'), numericOnly, field !== document.activeElement);
                  validateAndUpdateSubmit($field.closest('.wpcf7'));
                }, 0);
              } else if (event && event.type === 'blur') {
                // On blur, just validate
                var numericOnly = $field.val().replace(/[^0-9]/g, '');
                handlePhoneError($field, $field.closest('.wpcf7'), numericOnly, true);
                validateAndUpdateSubmit($field.closest('.wpcf7'));
              }
            }
          },
          {
            events: 'input propertychange',
            selector: '.wpcf7 textarea[name="message"]',
            sanitize: function(field) { 
              // Message field allows more characters, only sanitize dangerous ones
              sanitizeInput(field, MESSAGE_REGEX); 
            }
          }
        ];
        
        handlers.forEach(function(handler) {
          $doc.off(handler.events, handler.selector);
          $doc.on(handler.events, handler.selector, function(e) {
            try {
              if (handler.sanitize) {
                handler.sanitize(this, e);
              } else {
                validateAndUpdateSubmit($(this).closest('.wpcf7'));
              }
            } catch (err) {
              console.error('Handler error:', err);
            }
          });
        });
        
        // Special handler for phone field - only for non-intl-tel-input fields
        $doc.off('focus', '.wpcf7 input[name="phone"]');
        $doc.on('focus', '.wpcf7 input[name="phone"]', function() {
          var $field = $(this);
          var $wrap = $field.closest('.wpcf7-form-control-wrap');
          
          // Check if using intl-tel-input plugin
          var isIntlTelInput = $field.closest('.intl-tel-input').length > 0 || 
                               $wrap.find('.intl-tel-input').length > 0 ||
                               $field.hasClass('intl-tel-input') ||
                               typeof window.intlTelInput !== 'undefined';
          
          // Only apply our logic if NOT using intl-tel-input
          if (!isIntlTelInput) {
            // Store initial value
            var initialValue = this.value.replace(/[^0-9]/g, '');
            $field.data('prev-phone-value', initialValue);
            
            // Limit to 12 digits if exceeds
            if (initialValue.length > 15) {
              var cleanedValue = initialValue.substring(0, 15);
              $field.val(cleanedValue);
              $field.data('prev-phone-value', cleanedValue);
              validateAndUpdateSubmit($field.closest('.wpcf7'));
            }
          }
        });
        
        // Generic validation triggers for all fields including textarea
        $doc.off('input blur change', '.wpcf7 input, .wpcf7 select, .wpcf7 textarea');
        $doc.on('input blur change', '.wpcf7 input, .wpcf7 select, .wpcf7 textarea', function() {
          if (this.type !== 'submit' && this.type !== 'hidden') {
            // For phone fields using intl-tel-input, validate but don't modify
            if (this.name === 'phone') {
              var $field = $(this);
              var $wrap = $field.closest('.wpcf7-form-control-wrap');
              var isIntlTelInput = $field.closest('.intl-tel-input').length > 0 || 
                                   $wrap.find('.intl-tel-input').length > 0 ||
                                   $field.hasClass('intl-tel-input') ||
                                   typeof window.intlTelInput !== 'undefined';
              
              if (isIntlTelInput) {
                // Just validate, don't modify the field
                validateAndUpdateSubmit($field.closest('.wpcf7'));
                return;
              }
            }
            validateAndUpdateSubmit($(this).closest('.wpcf7'));
          }
        });
        
        // Resume file handler
        $doc.off('change', '.wpcf7 input#resume, .wpcf7 input[name="resume"]');
        $doc.on('change', '.wpcf7 input#resume, .wpcf7 input[name="resume"]', function() {
          var fileName = this.files.length > 0 ? this.files[0].name : "Resume (Max file size: 500 KB)";
          var $noFileEl = $(this).closest('.wpcf7').find('#noFile');
          if (!$noFileEl.length) {
            $noFileEl = $(this).closest('.wpcf7-form-control-wrap').find('#noFile');
          }
          if ($noFileEl.length) {
            $noFileEl.text(fileName);
          }
          validateAndUpdateSubmit($(this).closest('.wpcf7'));
        });
      }
      
      // Initialize forms
      function initFormValidation() {
        $('.wpcf7').each(function() {
          var $form = $(this);
          var hasFields = $form.find('input, select, textarea').not('input[type="submit"], input[type="hidden"], input[type="button"]').length > 0;
          toggleSubmitButton($form, hasFields ? checkFormValidation($form) : true);
          
          // Initialize phone fields - only for non-intl-tel-input fields
          $form.find('input[name="phone"]').each(function() {
            var $phoneField = $(this);
            var $wrap = $phoneField.closest('.wpcf7-form-control-wrap');
            
            // Check if using intl-tel-input plugin
            var isIntlTelInput = $phoneField.closest('.intl-tel-input').length > 0 || 
                                 $wrap.find('.intl-tel-input').length > 0 ||
                                 $phoneField.hasClass('intl-tel-input') ||
                                 typeof window.intlTelInput !== 'undefined';
            
            // Only apply our logic if NOT using intl-tel-input
            if (!isIntlTelInput) {
              var cleanValue = this.value.replace(/[^0-9]/g, '');
              // Limit to 12 digits if exceeds
              if (cleanValue.length > 15) {
                cleanValue = cleanValue.substring(0, 15);
                $phoneField.val(cleanValue);
              }
              $phoneField.data('prev-phone-value', cleanValue);
            }
          });
          
          // Re-validate after a short delay to catch autofilled fields or pre-filled values
          setTimeout(function() {
            validateAndUpdateSubmit($form);
          }, 500);
        });
        setupEventHandlers();
        
        // Additional delayed validation for autofill scenarios
        setTimeout(function() {
          $('.wpcf7').each(function() {
            validateAndUpdateSubmit($(this));
          });
        }, 1000);
      }

      // Initialize
      initFormValidation();
      
      // Form submission/reset handlers
      $(document).on('wpcf7mailsent wpcf7invalid wpcf7spam wpcf7mailfailed wpcf7submit reset', '.wpcf7, .wpcf7 form', function(e) {
        var $form = $(e.target).closest('.wpcf7');
        if ($form.length) {
          toggleSubmitButton($form, false);
          setTimeout(function() { validateAndUpdateSubmit($form); }, 100);
        } else {
          setTimeout(initFormValidation, 100);
        }
      });
      
      // Dynamic form detection
      if (typeof MutationObserver !== 'undefined') {
        var observer = new MutationObserver(function(mutations) {
          var needsInit = false;
          for (var i = 0; i < mutations.length && !needsInit; i++) {
            if (mutations[i].addedNodes.length) {
              $(mutations[i].addedNodes).each(function() {
                if ($(this).hasClass('wpcf7') || $(this).find('.wpcf7').length) {
                  needsInit = true;
                  return false;
                }
              });
            }
          }
          if (needsInit) setTimeout(initFormValidation, 100);
        });
        observer.observe(document.body, { childList: true, subtree: true });
      }
      
      // Handle Bootstrap modal forms - re-initialize validation when modal opens
      // Bootstrap 5
      $(document).on('shown.bs.modal', '.modal', function() {
        var $modal = $(this);
        var $forms = $modal.find('.wpcf7');
        if ($forms.length > 0) {
          // Small delay to ensure form is fully rendered
          setTimeout(function() {
            $forms.each(function() {
              var $form = $(this);
              // Re-initialize validation for this form
              var hasFields = $form.find('input, select, textarea').not('input[type="submit"], input[type="hidden"], input[type="button"]').length > 0;
              toggleSubmitButton($form, hasFields ? checkFormValidation($form) : true);
              
              // Initialize phone fields in modal
              $form.find('input[name="phone"]').each(function() {
                var $phoneField = $(this);
                var $wrap = $phoneField.closest('.wpcf7-form-control-wrap');
                var isIntlTelInput = $phoneField.closest('.intl-tel-input').length > 0 || 
                                     $wrap.find('.intl-tel-input').length > 0 ||
                                     $phoneField.hasClass('intl-tel-input') ||
                                     typeof window.intlTelInput !== 'undefined';
                
                if (!isIntlTelInput) {
                  var cleanValue = this.value.replace(/[^0-9]/g, '');
                  if (cleanValue.length > 15) {
                    cleanValue = cleanValue.substring(0, 15);
                    $phoneField.val(cleanValue);
                  }
                  $phoneField.data('prev-phone-value', cleanValue);
                }
              });
              
              // Validate after initialization
              validateAndUpdateSubmit($form);
            });
          }, 200);
        }
      });
      
      // Bootstrap 4 (jQuery) - for backward compatibility
      $(document).on('shown', '.modal', function() {
        var $modal = $(this);
        var $forms = $modal.find('.wpcf7');
        if ($forms.length > 0) {
          setTimeout(function() {
            $forms.each(function() {
              var $form = $(this);
              var hasFields = $form.find('input, select, textarea').not('input[type="submit"], input[type="hidden"], input[type="button"]').length > 0;
              toggleSubmitButton($form, hasFields ? checkFormValidation($form) : true);
              validateAndUpdateSubmit($form);
            });
          }, 200);
        }
      });
      
      // Handle custom popup modals - watch for .active class addition
      var customModalObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
            var $target = $(mutation.target);
            // Check if modal became active (has .active class)
            if ($target.hasClass('active')) {
              // Check if this is a modal container (brochure-modal-overlay, resource-modal-overlay, etc.)
              var isModalOverlay = $target.hasClass('brochure-modal-overlay') || 
                                   $target.hasClass('resource-modal-overlay') ||
                                   $target.closest('.modal-dialog, .modal-content').length > 0 ||
                                   $target.is('.formpopup_modal, .modal');
              
              if (isModalOverlay) {
                // Find all forms within this modal
                var $forms = $target.find('.wpcf7');
                if ($forms.length > 0) {
                  setTimeout(function() {
                    $forms.each(function() {
                      var $form = $(this);
                      var hasFields = $form.find('input, select, textarea').not('input[type="submit"], input[type="hidden"], input[type="button"]').length > 0;
                      toggleSubmitButton($form, hasFields ? checkFormValidation($form) : true);
                      
                      // Initialize phone fields in custom modal
                      $form.find('input[name="phone"]').each(function() {
                        var $phoneField = $(this);
                        var $wrap = $phoneField.closest('.wpcf7-form-control-wrap');
                        var isIntlTelInput = $phoneField.closest('.intl-tel-input').length > 0 || 
                                             $wrap.find('.intl-tel-input').length > 0 ||
                                             $phoneField.hasClass('intl-tel-input') ||
                                             typeof window.intlTelInput !== 'undefined';
                        
                        if (!isIntlTelInput) {
                          var cleanValue = this.value.replace(/[^0-9]/g, '');
                          if (cleanValue.length > 15) {
                            cleanValue = cleanValue.substring(0, 15);
                            $phoneField.val(cleanValue);
                          }
                          $phoneField.data('prev-phone-value', cleanValue);
                        }
                      });
                      
                      validateAndUpdateSubmit($form);
                    });
                  }, 200);
                }
              }
            }
          }
        });
      });
      
      // Observe all potential modal containers for class changes
      if (typeof MutationObserver !== 'undefined') {
        // Observe existing modals
        $('.brochure-modal-overlay, .resource-modal-overlay, .formpopup_modal, .modal').each(function() {
          customModalObserver.observe(this, { attributes: true, attributeFilter: ['class'] });
        });
        
        // Also watch for new modals being added
        var modalContainerObserver = new MutationObserver(function(mutations) {
          mutations.forEach(function(mutation) {
            $(mutation.addedNodes).each(function() {
              var $node = $(this);
              // Check if added node is a modal or contains modals
              var $modals = $node.is('.brochure-modal-overlay, .resource-modal-overlay, .formpopup_modal, .modal') 
                            ? $node 
                            : $node.find('.brochure-modal-overlay, .resource-modal-overlay, .formpopup_modal, .modal');
              
              $modals.each(function() {
                customModalObserver.observe(this, { attributes: true, attributeFilter: ['class'] });
              });
            });
          });
        });
        
        modalContainerObserver.observe(document.body, { childList: true, subtree: true });
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

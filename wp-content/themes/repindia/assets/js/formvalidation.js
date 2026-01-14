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
        return $field.hasClass('wpcf7-validates-as-required') || 
               $field.closest('.wpcf7-form-control-wrap').find('span.wpcf7-validates-as-required').length > 0 ||
               !$field.closest('.wpcf7-form-control-wrap').hasClass('optional');
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
            return phoneDigits.length >= 10 && phoneDigits.length <= 12;
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
          var $allFields = $form.find('input, select, textarea').not('input[type="submit"], input[type="hidden"]');
          if ($allFields.length === 0) return true;
          
          // Check all required fields (covers most cases)
          var $requiredFields = $form.find('.wpcf7-validates-as-required');
          if ($requiredFields.length > 0) {
            var allRequiredValid = true;
            $requiredFields.each(function() {
              if (!validateField($(this), $form)) {
                allRequiredValid = false;
                return false; // break
              }
            });
            if (!allRequiredValid) return false;
          }
          
          // Check specific custom fields if they exist
          var fieldChecks = [
            { selector: 'input[name="phone"]', validate: function($f) {
              var val = $f.val().replace(PHONE_REGEX, '');
              return !val || (val.length >= 10 && val.length <= 12);
            }},
            { selector: 'input[name="fname"], input[name="lname"], input[name="first_name"], input[name="last_name"]', 
              validate: function($f) { return !isFieldRequired($f) || $f.val().trim().length > 0; }},
            { selector: 'input[type="email"], input[name="email"], input[name="your-email"]',
              validate: function($f) {
                var val = $f.val().trim();
                return !val || EMAIL_REGEX.test(val);
              }},
            { selector: 'input[name="company"], input[name="job"]',
              validate: function($f) { return !isFieldRequired($f) || $f.val().trim().length > 0; }},
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
                if (!fieldChecks[i].validate($(this))) {
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
          } else if (value.length > 12) {
            if (!$errorEl.length) {
              $errorEl = $('<span id="mobile-error" style="color: red; display: block; margin-top: 5px;">Mobile number cannot exceed 12 digits.</span>');
              $field.closest('.wpcf7-form-control-wrap').append($errorEl);
            }
            $errorEl.text('Mobile number cannot exceed 12 digits.').show();
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
              
              // For input and paste events, clean the value
              if (event && (event.type === 'input' || event.type === 'paste')) {
                setTimeout(function() {
                  var currentValue = $field.val();
                  var numericOnly = currentValue.replace(/[^0-9]/g, '');
                  
                  // Remove +91 or 91 if it appears at the start (likely auto-added)
                  if (numericOnly.indexOf('91') === 0 && numericOnly.length > 2) {
                    // Check if this was just added (compare with previous value stored in data)
                    var prevValue = $field.data('prev-phone-value') || '';
                    var prevNumeric = prevValue.replace(/[^0-9]/g, '');
                    
                    // If previous didn't start with 91 and now it does, it was likely auto-added
                    if (prevNumeric.indexOf('91') !== 0 && numericOnly.length === prevNumeric.length + 2) {
                      numericOnly = numericOnly.substring(2);
                    }
                  }
                  
                  // Limit to 12 digits max
                  if (numericOnly.length > 12) {
                    numericOnly = numericOnly.substring(0, 12);
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
        
        // Special handler for phone field to prevent +91 auto-addition on focus
        $doc.off('focus', '.wpcf7 input[name="phone"]');
        $doc.on('focus', '.wpcf7 input[name="phone"]', function() {
          var $field = $(this);
          // Store initial value to detect auto-additions
          var initialValue = this.value.replace(/[^0-9]/g, '');
          $field.data('prev-phone-value', initialValue);
          
          // Remove +91 if present at start
          if (initialValue.indexOf('91') === 0 && initialValue.length > 2) {
            var cleanedValue = initialValue.substring(2);
            $field.val(cleanedValue);
            $field.data('prev-phone-value', cleanedValue);
            validateAndUpdateSubmit($field.closest('.wpcf7'));
          }
        });
        
        // Generic validation triggers for all fields including textarea
        $doc.off('input blur change', '.wpcf7 input, .wpcf7 select, .wpcf7 textarea');
        $doc.on('input blur change', '.wpcf7 input, .wpcf7 select, .wpcf7 textarea', function() {
          if (this.type !== 'submit' && this.type !== 'hidden' && this.name !== 'phone') {
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
          var hasFields = $form.find('input, select, textarea').not('input[type="submit"], input[type="hidden"]').length > 0;
          toggleSubmitButton($form, hasFields ? checkFormValidation($form) : true);
          
          // Initialize phone fields - remove any existing +91
          $form.find('input[name="phone"]').each(function() {
            var $phoneField = $(this);
            var cleanValue = this.value.replace(/[^0-9]/g, '');
            // Remove +91 if present at start
            if (cleanValue.indexOf('91') === 0 && cleanValue.length > 2) {
              cleanValue = cleanValue.substring(2);
              $phoneField.val(cleanValue);
            } else if (cleanValue.length > 12) {
              cleanValue = cleanValue.substring(0, 12);
              $phoneField.val(cleanValue);
            }
            $phoneField.data('prev-phone-value', cleanValue);
          });
        });
        setupEventHandlers();
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
    });
  }

  // Start initialization
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFormValidationScript);
  } else {
    initFormValidationScript();
  }
})();

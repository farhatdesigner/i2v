document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.wpcf7-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const recaptchaResponse = form.querySelector('.g-recaptcha-response');

            if (recaptchaResponse && recaptchaResponse.value.trim() === '') {
                e.preventDefault();
                e.stopImmediatePropagation();

                // Avoid duplicate error messages
                if (!form.querySelector('.recaptcha-error-msg')) {
                    const errorEl = document.createElement('p');
                    errorEl.className = 'recaptcha-error-msg';
                    errorEl.style.cssText = 'color:red; font-size:13px; margin-top:6px;';
                    errorEl.textContent = 'Please verify that you are not a robot.';

                    const recaptchaWidget = form.querySelector('.g-recaptcha');
                    if (recaptchaWidget) {
                        recaptchaWidget.insertAdjacentElement('afterend', errorEl);
                    }
                }
                return false;
            }

            // Remove error if captcha is now checked
            const existingError = form.querySelector('.recaptcha-error-msg');
            if (existingError) existingError.remove();

        }, true); // capture phase - fires before CF7
    });
});
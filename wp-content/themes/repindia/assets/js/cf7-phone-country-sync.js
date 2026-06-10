/**
 * Re-sync .country-input and .dial-code in CF7 popup modals when they become visible.
 *
 * Does not initialize intl-tel-input or bind events — only reads existing instances
 * created by formvalidation.js and updates linked fields (e.g. after form.reset on close).
 */
(function () {
	'use strict';

	var POPUP_MODAL_SELECTOR = '.formpopup_modal, #brochureModal';

	function isPublicFrontendContext() {
		if (typeof window !== 'undefined' && window.location && window.location.href.indexOf('elementor-preview') !== -1) {
			return false;
		}
		if (typeof elementorFrontend !== 'undefined' && elementorFrontend.isEditMode && elementorFrontend.isEditMode()) {
			return false;
		}
		return true;
	}

	if (!isPublicFrontendContext()) {
		return;
	}

	function getItiInstance(input) {
		if (!input) {
			return null;
		}
		if (window.intlTelInputGlobals && typeof window.intlTelInputGlobals.getInstance === 'function') {
			return window.intlTelInputGlobals.getInstance(input);
		}
		return null;
	}

	function syncLinkedFieldsForInput(input) {
		try {
			var iti = getItiInstance(input);
			if (!iti || typeof iti.getSelectedCountryData !== 'function') {
				return;
			}

			var form = input.closest('form');
			if (!form) {
				return;
			}

			var data = iti.getSelectedCountryData();
			if (!data) {
				return;
			}

			var countryInput = form.querySelector('.country-input');
			var dialCodeInput = form.querySelector('.dial-code');

			if (countryInput) {
				countryInput.value = data.name || '';

				if (countryInput._countryFlagEl && data.iso2) {
					var flagEl = countryInput._countryFlagEl;
					var prevIso = flagEl.dataset.iso2;
					if (prevIso) {
						flagEl.classList.remove('iti__' + prevIso.toLowerCase());
					}
					var iso = String(data.iso2 || '').toLowerCase();
					if (iso) {
						flagEl.classList.add('iti__' + iso);
						flagEl.dataset.iso2 = iso;
					}
				}
			}

			if (dialCodeInput) {
				dialCodeInput.value = data.dialCode ? '+' + data.dialCode : '';
			}
		} catch (err) {
			// Fail silently per input — never break the page.
		}
	}

	function syncPhoneCountryFieldsInModal(modal) {
		if (!modal || typeof modal.querySelectorAll !== 'function') {
			return;
		}

		var phoneInputs = modal.querySelectorAll('.phone-input');
		for (var i = 0; i < phoneInputs.length; i++) {
			syncLinkedFieldsForInput(phoneInputs[i]);
		}
	}

	function handlePopupShown(event) {
		var modal = event.target;
		if (!modal || typeof modal.matches !== 'function') {
			return;
		}
		if (!modal.matches(POPUP_MODAL_SELECTOR)) {
			return;
		}

		// Brief delay so modal layout is settled (matches formvalidation modal timing).
		setTimeout(function () {
			syncPhoneCountryFieldsInModal(modal);
		}, 50);
	}

	document.addEventListener('shown.bs.modal', handlePopupShown);
})();

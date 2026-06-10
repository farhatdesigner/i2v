/**
 * Defer reCAPTCHA v2 render for CF7 forms inside Bootstrap popups.
 *
 * Replaces the global recaptchaCallback (from wpcf7-recaptcha-controls.js) before
 * google api.js onload runs. Popup widgets render on shown.bs.modal only.
 * Does not modify plugin files; uses a theme-level widget registry.
 */
(function () {
	'use strict';

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

	var G_RECAPTCHA_CLASS_PATTERN = /(^|\s)g-recaptcha(\s|$)/;
	var POPUP_MODAL_SELECTOR = '.formpopup_modal, #brochureModal';
	var DEFER_ATTR = 'data-repindia-recaptcha-defer';
	var WIDGET_ID_ATTR = 'data-repindia-recaptcha-widget-id';

	window.repindiaRecaptchaWidgets = window.repindiaRecaptchaWidgets || [];

	function getCf7PopupModal(el) {
		return el.closest(POPUP_MODAL_SELECTOR);
	}

	function shouldDeferRecaptcha(el) {
		var modal = getCf7PopupModal(el);
		if (!modal) {
			return false;
		}
		return !modal.classList.contains('show');
	}

	function registerWidget(widgetId) {
		if (window.repindiaRecaptchaWidgets.indexOf(widgetId) === -1) {
			window.repindiaRecaptchaWidgets.push(widgetId);
		}
	}

	function buildRenderParams(el) {
		var sitekey = el.getAttribute('data-sitekey');
		if (!sitekey) {
			return null;
		}

		var params = { sitekey: sitekey };
		var attrs = ['type', 'size', 'theme', 'align', 'badge', 'tabindex'];

		for (var i = 0; i < attrs.length; i++) {
			var value = el.getAttribute('data-' + attrs[i]);
			if (value) {
				params[attrs[i]] = value;
			}
		}

		var callback = el.getAttribute('data-callback');
		if (callback && typeof window[callback] === 'function') {
			params.callback = window[callback];
		}

		var expiredCallback = el.getAttribute('data-expired-callback');
		if (expiredCallback && typeof window[expiredCallback] === 'function') {
			params['expired-callback'] = expiredCallback;
		}

		return params;
	}

	function isValidRecaptchaContainer(el) {
		return (
			el &&
			el.className &&
			el.className.match(G_RECAPTCHA_CLASS_PATTERN) &&
			el.getAttribute('data-sitekey')
		);
	}

	function getWidgetId(el) {
		var raw = el.getAttribute(WIDGET_ID_ATTR);
		if (raw === null || raw === '') {
			return null;
		}
		var id = parseInt(raw, 10);
		return isNaN(id) ? null : id;
	}

	function renderRecaptchaElement(el) {
		if (typeof grecaptcha === 'undefined' || typeof grecaptcha.render !== 'function') {
			return null;
		}

		if (!isValidRecaptchaContainer(el)) {
			return null;
		}

		var existingId = getWidgetId(el);
		if (existingId !== null) {
			return existingId;
		}

		// Avoid duplicate render if Google already injected an iframe (e.g. legacy load-order issue).
		if (el.querySelector('iframe')) {
			return null;
		}

		var params = buildRenderParams(el);
		if (!params) {
			return null;
		}

		try {
			var widgetId = grecaptcha.render(el, params);
			el.setAttribute(WIDGET_ID_ATTR, String(widgetId));
			el.removeAttribute(DEFER_ATTR);
			registerWidget(widgetId);
			return widgetId;
		} catch (err) {
			return null;
		}
	}

	function resetWidgetById(widgetId) {
		if (typeof grecaptcha === 'undefined' || typeof grecaptcha.reset !== 'function') {
			return;
		}
		try {
			grecaptcha.reset(widgetId);
		} catch (err) {
			// Widget may have been removed from DOM.
		}
	}

	function resetAllRegisteredWidgets() {
		var widgets = window.repindiaRecaptchaWidgets;
		for (var i = 0; i < widgets.length; i++) {
			resetWidgetById(widgets[i]);
		}
	}

	function findRecaptchaContainers(root) {
		var containers = [];
		var forms = root.getElementsByTagName('form');

		for (var i = 0; i < forms.length; i++) {
			var recaptchas = forms[i].getElementsByClassName('wpcf7-recaptcha');

			for (var j = 0; j < recaptchas.length; j++) {
				if (isValidRecaptchaContainer(recaptchas[j])) {
					containers.push(recaptchas[j]);
					break;
				}
			}
		}

		return containers;
	}

	function handlePopupShown(modal) {
		if (typeof grecaptcha === 'undefined') {
			return;
		}

		var containers = findRecaptchaContainers(modal);

		for (var i = 0; i < containers.length; i++) {
			var el = containers[i];
			var widgetId = getWidgetId(el);

			if (widgetId !== null) {
				resetWidgetById(widgetId);
				continue;
			}

			renderRecaptchaElement(el);
		}
	}

	/**
	 * Global callback consumed by google-recaptcha api.js onload.
	 * Mirrors wpcf7-recaptcha-controls.js but skips hidden popup containers.
	 */
	window.recaptchaCallback = function () {
		if (typeof grecaptcha === 'undefined' || typeof grecaptcha.render !== 'function') {
			return;
		}

		var forms = document.getElementsByTagName('form');

		for (var i = 0; i < forms.length; i++) {
			var recaptchas = forms[i].getElementsByClassName('wpcf7-recaptcha');

			for (var j = 0; j < recaptchas.length; j++) {
				var el = recaptchas[j];

				if (!isValidRecaptchaContainer(el)) {
					continue;
				}

				if (shouldDeferRecaptcha(el)) {
					el.setAttribute(DEFER_ATTR, '1');
					break;
				}

				renderRecaptchaElement(el);
				break;
			}
		}
	};

	document.addEventListener('shown.bs.modal', function (event) {
		var modal = event.target;
		if (!modal || typeof modal.matches !== 'function') {
			return;
		}
		if (!modal.matches(POPUP_MODAL_SELECTOR)) {
			return;
		}
		handlePopupShown(modal);
	});

	document.addEventListener('wpcf7submit', function (event) {
		if (!event.detail || !event.detail.status) {
			return;
		}

		switch (event.detail.status) {
			case 'spam':
			case 'mail_sent':
			case 'mail_failed':
				resetAllRegisteredWidgets();
				break;
		}
	});
})();

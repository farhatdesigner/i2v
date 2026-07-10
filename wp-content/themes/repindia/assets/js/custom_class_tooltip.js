/**
 * Standalone tooltips for .custom_tooltip (separate from Elementor Custom Tooltip widget).
 */
(function ($) {
	'use strict';

	var config = window.repindiaCct || {};
	var icons = config.icons || {};
	var INIT_FLAG = 'cctInit';
	var OUTSIDE_NS = 'cctOutsideClick';
	var POPUP_NS = 'cctPopup';
	var SCROLL_NS = 'cctHideOnScroll';
	var PORTAL_ID = 'cct-tooltip-portal';
	var OVERLAY_ID = 'cct-popup-overlay';
	var POPUP_ID = 'cct-popup-box';
	var DEFAULT_CONTENT_ID = 'cct-tooltip-content';
	var DEFAULT_POPUP_ID = 'cct-popup-content';
	var activeTrigger = null;

	var DEFAULT_TOOLTIP_HTML =
		'<p>Based on operational deployments in malls, airports, metro stations, and similar locations as of 2026.</p>' +
		'<a href="javascript:void(0);" class="cct-learn-more-btn ctw-learn-more-btn theme-btn bg-trans border_btnlight">Learn more</a>';

	var TRIGGER_SELECTOR = '.custom_tooltip, [class*="custom_tooltip_"]';

	function getTriggerSuffix($trigger) {
		var classes = ($trigger.attr('class') || '').split(/\s+/);
		var suffix = '';

		classes.forEach(function (className) {
			if (className.indexOf('custom_tooltip_') === 0) {
				suffix = className.replace('custom_tooltip_', '');
			}
		});

		return suffix;
	}

	function resolveContentTargetId($trigger) {
		var targetId = $trigger.attr('data-cct-target');
		if (targetId) {
			return targetId;
		}

		var suffix = getTriggerSuffix($trigger);
		if (suffix) {
			return 'cct-tooltip-content-' + suffix;
		}

		return DEFAULT_CONTENT_ID;
	}

	function resolvePopupTargetId($trigger) {
		var popupTargetId = $trigger.attr('data-cct-popup-target');
		if (popupTargetId) {
			return popupTargetId;
		}

		var suffix = getTriggerSuffix($trigger);
		if (suffix) {
			return 'cct-popup-content-' + suffix;
		}

		return DEFAULT_POPUP_ID;
	}

	function applyDynamicIconPaths() {
		var lightIcon = icons.light || '';
		var darkIcon = icons.dark || lightIcon;

		if (!lightIcon && !darkIcon) {
			return;
		}

		$('.cct-popup-source, .ctw-popup-source').each(function () {
			var $source = $(this);

			if (lightIcon) {
				$source
					.find('.ctw-popup-icon-light img, .cct-popup-icon-light img, img.cct-auto-icon-light')
					.attr('src', lightIcon);
			}

			if (darkIcon) {
				$source
					.find('.ctw-popup-icon-dark img, .cct-popup-icon-dark img, img.cct-auto-icon-dark')
					.attr('src', darkIcon);
			}
		});
	}

	function buildDefaultPopupHtml() {
		var lightIcon = icons.light || '';
		var darkIcon = icons.dark || lightIcon;

		return (
			'<div class="cct-popup-content-wrapper ctw-popup-content-wrapper">' +
			'<div class="cct-popup-icon-wrapper ctw-popup-icon-wrapper">' +
			(lightIcon
				? '<span class="cct-popup-icon ctw-popup-icon ctw-popup-icon-light"><img src="' +
				  lightIcon +
				  '" alt="" class="cct-popup-icon ctw-popup-icon" /></span>'
				: '') +
			(darkIcon
				? '<span class="cct-popup-icon ctw-popup-icon ctw-popup-icon-dark"><img src="' +
				  darkIcon +
				  '" alt="" class="cct-popup-icon ctw-popup-icon" /></span>'
				: '') +
			'</div>' +
			'<div class="cct-popup-content-text ctw-popup-content-text">' +
			'<p>Calculated from active installations across public spaces with high daily footfall. Includes locations such as airports, metro systems, bus terminals, stadiums, and shopping malls.</p>' +
			'</div>' +
			'</div>'
		);
	}

	function ensureConfiguredSources() {
		var tooltips = config.tooltips || {};

		Object.keys(tooltips).forEach(function (key) {
			var tooltip = tooltips[key] || {};
			var contentId = 'cct-tooltip-content-' + key;
			var popupId = 'cct-popup-content-' + key;

			if (tooltip.content && !$('#' + contentId).length) {
				$('body').append(
					'<div id="' + contentId + '" class="cct-tooltip-source">' + tooltip.content + '</div>'
				);
			}

			if (tooltip.popup && !$('#' + popupId).length) {
				$('body').append(
					'<div id="' + popupId + '" class="cct-popup-source">' + tooltip.popup + '</div>'
				);
			}
		});
	}

	function ensureDefaultContent() {
		if (!$('#' + DEFAULT_CONTENT_ID).length) {
			$('body').append(
				'<div id="' + DEFAULT_CONTENT_ID + '" class="cct-tooltip-source">' + DEFAULT_TOOLTIP_HTML + '</div>'
			);
		}

		if (!$('#' + DEFAULT_POPUP_ID).length) {
			$('body').append(
				'<div id="' + DEFAULT_POPUP_ID + '" class="cct-popup-source">' + buildDefaultPopupHtml() + '</div>'
			);
		}
	}

	function ensurePortal() {
		var $portal = $('#' + PORTAL_ID);

		if (!$portal.length) {
			$('body').append(
				'<div id="' + PORTAL_ID + '" aria-hidden="true">' +
				'<div class="cct-tooltip ctw-tooltip cct-tooltip-bottom ctw-tooltip-bottom moretooldiv cct-has-learn-more ctw-has-learn-more">' +
				'<div class="cct-tooltip-inner ctw-tooltip-inner"></div>' +
				'</div>' +
				'</div>'
			);
			$portal = $('#' + PORTAL_ID);
		}

		return $portal;
	}

	function ensurePopupModal() {
		if (!$('#' + OVERLAY_ID).length) {
			$('body').append(
				'<div id="' + OVERLAY_ID + '" class="cct-popup-overlay ctw-popup-overlay" style="display:none;"></div>'
			);
		}

		if (!$('#' + POPUP_ID).length) {
			$('body').append(
				'<div id="' + POPUP_ID + '" class="cct-popup-box ctw-popup-box" style="display:none;" role="dialog" aria-modal="true">' +
				'<div class="cct-popup-close ctw-popup-close">&times;</div>' +
				'<div class="cct-popup-body"></div>' +
				'</div>'
			);
		}
	}

	function getContentSource($trigger) {
		var targetId = resolveContentTargetId($trigger);

		if (targetId) {
			var $byId = $('#' + targetId);
			if ($byId.length) {
				return $byId.first();
			}
		}

		var $inline = $trigger.children('.cct-tooltip-source').first();
		if ($inline.length) {
			return $inline;
		}

		var $sibling = $trigger.siblings('.cct-tooltip-source').first();
		if ($sibling.length) {
			return $sibling;
		}

		var $parentSibling = $trigger.parent().siblings('.cct-tooltip-source').first();
		if ($parentSibling.length) {
			return $parentSibling;
		}

		return $('#' + DEFAULT_CONTENT_ID).first();
	}

	function getPopupSource($trigger) {
		var popupTargetId = resolvePopupTargetId($trigger);

		if (popupTargetId) {
			var $byId = $('#' + popupTargetId);
			if ($byId.length) {
				return $byId.first();
			}
		}

		var $inline = $trigger.children('.cct-popup-source').first();
		if ($inline.length) {
			return $inline;
		}

		var $sibling = $trigger.siblings('.cct-popup-source').first();
		if ($sibling.length) {
			return $sibling;
		}

		var $parentSibling = $trigger.parent().siblings('.cct-popup-source').first();
		if ($parentSibling.length) {
			return $parentSibling;
		}

		return $('#' + DEFAULT_POPUP_ID).first();
	}

	function positionPortal($trigger, position) {
		var $portal = ensurePortal();
		var $tooltip = $portal.find('.cct-tooltip');
		var rect = $trigger[0].getBoundingClientRect();
		var isMobile = window.innerWidth <= 768;
		var css = {
			left: 'auto',
			right: 'auto',
			top: 'auto',
			bottom: 'auto',
			transform: ''
		};

		$tooltip
			.removeClass(
				'cct-tooltip-top cct-tooltip-bottom cct-tooltip-left cct-tooltip-right ctw-tooltip-top ctw-tooltip-bottom ctw-tooltip-left ctw-tooltip-right'
			)
			.addClass('cct-tooltip-' + position + ' ctw-tooltip-' + position);

		if (isMobile) {
			$portal.addClass('cct-tooltip-portal-mobile');

			var gap = 8;
			var viewportPadding = 16;
			var centerX = rect.left + rect.width / 2;
			var tooltipWidth = Math.min(360, window.innerWidth - viewportPadding * 2);
			var tooltipHeight = $tooltip.outerHeight() || 120;
			var spaceBelow = window.innerHeight - rect.bottom - gap - viewportPadding;
			var spaceAbove = rect.top - gap - viewportPadding;
			var top;

			if (spaceBelow >= tooltipHeight || spaceBelow >= spaceAbove) {
				top = rect.bottom + gap;
			} else {
				top = rect.top - gap - tooltipHeight;
			}

			top = Math.max(viewportPadding, Math.min(top, window.innerHeight - tooltipHeight - viewportPadding));

			var left = Math.max(
				viewportPadding + tooltipWidth / 2,
				Math.min(window.innerWidth - viewportPadding - tooltipWidth / 2, centerX)
			);

			css.left = left + 'px';
			css.top = top + 'px';
			css.transform = 'translateX(-50%)';
		} else if (position === 'bottom') {
			$portal.removeClass('cct-tooltip-portal-mobile');
			css.left = rect.left + rect.width / 2 + 'px';
			css.top = rect.bottom + 8 + 'px';
			css.transform = 'translateX(-50%)';
		} else if (position === 'top') {
			$portal.removeClass('cct-tooltip-portal-mobile');
			css.left = rect.left + rect.width / 2 + 'px';
			css.top = rect.top - 8 + 'px';
			css.transform = 'translate(-50%, -100%)';
		} else if (position === 'left') {
			$portal.removeClass('cct-tooltip-portal-mobile');
			css.left = rect.left - 8 + 'px';
			css.top = rect.top + rect.height / 2 + 'px';
			css.transform = 'translate(-100%, -50%)';
		} else if (position === 'right') {
			$portal.removeClass('cct-tooltip-portal-mobile');
			css.left = rect.right + 8 + 'px';
			css.top = rect.top + rect.height / 2 + 'px';
			css.transform = 'translateY(-50%)';
		}

		$portal.css(css);
	}

	function closePortal() {
		$('#' + PORTAL_ID).removeClass('is-open').attr('aria-hidden', 'true');
		activeTrigger = null;
	}

	function closePopup() {
		$('#' + OVERLAY_ID).fadeOut(200);
		$('#' + POPUP_ID).fadeOut(200);
	}

	function closeOtherTooltips() {
		$('.ctw-wrapper .ctw-tooltip.show, .ctw-wrapper .ctw-tooltip-bottom.show, .ctw-wrapper .moretooldiv.show').removeClass(
			'show'
		);
	}

	function hasLearnMoreContent($source) {
		return $source.find('.cct-learn-more-btn, .ctw-learn-more-btn').length > 0;
	}

	function openPopup() {
		var $source = getPopupSource(activeTrigger || $(TRIGGER_SELECTOR).first());

		if (!$source.length) {
			return;
		}

		$('#' + POPUP_ID)
			.find('.cct-popup-body')
			.html($source.html());

		closePortal();
		$('#' + OVERLAY_ID).fadeIn(200);
		$('#' + POPUP_ID).fadeIn(200);
	}

	function openPortal($trigger) {
		var $source = getContentSource($trigger);

		if (!$source.length) {
			return;
		}

		var position = $trigger.attr('data-cct-position') || 'bottom';
		var $portal = ensurePortal();
		var $inner = $portal.find('.cct-tooltip-inner');
		var hasLearnMore = hasLearnMoreContent($source);

		closeOtherTooltips();
		$inner.html($source.html());
		$portal.find('.cct-tooltip').toggleClass('cct-has-learn-more ctw-has-learn-more moretooldiv', hasLearnMore);
		$portal.addClass('is-open').attr('aria-hidden', 'false');
		positionPortal($trigger, position);
		window.requestAnimationFrame(function () {
			if (activeTrigger && activeTrigger[0] === $trigger[0] && $portal.hasClass('is-open')) {
				positionPortal($trigger, position);
			}
		});
		activeTrigger = $trigger;
	}

	function bindGlobalHandlers() {
		$(document)
			.off('click.' + OUTSIDE_NS)
			.on('click.' + OUTSIDE_NS, function (e) {
				var $portal = $('#' + PORTAL_ID);

				if (!$portal.hasClass('is-open')) {
					return;
				}

				if (
					$(e.target).closest(
						'#' + PORTAL_ID + ' .cct-learn-more-btn, #' + PORTAL_ID + ' .ctw-learn-more-btn'
					).length
				) {
					return;
				}

				if (
					!$portal.is(e.target) &&
					!$portal.has(e.target).length &&
					(!activeTrigger || !$.contains(activeTrigger[0], e.target)) &&
					e.target !== activeTrigger[0]
				) {
					closePortal();
				}
			});

		$(document)
			.off('click.' + POPUP_NS, '#' + PORTAL_ID + ' .cct-learn-more-btn, #' + PORTAL_ID + ' .ctw-learn-more-btn')
			.on(
				'click.' + POPUP_NS,
				'#' + PORTAL_ID + ' .cct-learn-more-btn, #' + PORTAL_ID + ' .ctw-learn-more-btn',
				function (e) {
					e.preventDefault();
					e.stopPropagation();
					openPopup();
				}
			);

		$(document)
			.off('click.' + POPUP_NS, '#' + OVERLAY_ID + ', #' + POPUP_ID + ' .cct-popup-close, #' + POPUP_ID + ' .ctw-popup-close')
			.on('click.' + POPUP_NS, '#' + OVERLAY_ID + ', #' + POPUP_ID + ' .cct-popup-close, #' + POPUP_ID + ' .ctw-popup-close', function () {
				closePopup();
			});

		$(window)
			.off('scroll.' + SCROLL_NS + ' resize.' + SCROLL_NS)
			.on('scroll.' + SCROLL_NS + ' resize.' + SCROLL_NS, function () {
				if (activeTrigger && $('#' + PORTAL_ID).hasClass('is-open')) {
					positionPortal(activeTrigger, activeTrigger.attr('data-cct-position') || 'bottom');
					return;
				}

				closePortal();
			});
	}

	function initTrigger($trigger) {
		if ($trigger.data(INIT_FLAG)) {
			return;
		}

		if ($trigger.closest('.ctw-wrapper, .elementor-widget-custom_tooltip').length) {
			return;
		}

		if (!getContentSource($trigger).length) {
			return;
		}

		$trigger.off('click.cct').on('click.cct', function (e) {
			e.preventDefault();
			e.stopPropagation();

			var $portal = $('#' + PORTAL_ID);
			var isSameTrigger = activeTrigger && activeTrigger[0] === $trigger[0];
			var isOpen = $portal.hasClass('is-open');

			if (isOpen && isSameTrigger) {
				closePortal();
				return;
			}

			openPortal($trigger);
		});

		$trigger.data(INIT_FLAG, true);
	}

	function initCustomClassTooltips() {
		ensureDefaultContent();
		ensureConfiguredSources();
		ensurePortal();
		ensurePopupModal();
		applyDynamicIconPaths();

		$(TRIGGER_SELECTOR).each(function () {
			initTrigger($(this));
		});
	}

	function boot() {
		bindGlobalHandlers();
		initCustomClassTooltips();
	}

	$(document).ready(boot);

	$(window).on('elementor/frontend/init', function () {
		boot();

		if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
			elementorFrontend.hooks.addAction('frontend/element_ready/global', initCustomClassTooltips);
		}
	});

	if (typeof elementorFrontend !== 'undefined') {
		boot();
	}
})(jQuery);

/**
 * Global Image Loader.
 *
 * Shows a lightweight, pure-CSS spinner over any <img> WHILE it is loading, then
 * removes it the instant the image finishes. Works for images present at load,
 * lazy-loaded images (native, WP Rocket, lazysizes, Swiper), and images injected
 * later (Elementor popups, AJAX, sliders, tabs, accordions, dynamic widgets).
 *
 * Design goals:
 * - No jQuery, no polling, no timers (only a one-shot transition safety net).
 * - Exactly ONE MutationObserver (new <img> nodes + src/srcset swaps + removals)
 *   and ONE IntersectionObserver (defer work until the image nears the viewport,
 *   cooperating with lazy loading and hidden tabs/accordions/popups).
 * - Zero layout shift: a SINGLE overlay node, absolutely positioned & inert.
 * - Cached images (img.complete && img.naturalWidth > 0) get NO spinner.
 * - Per-image listeners/observers are removed on completion (no memory leaks).
 * - Fully additive & reversible: remove the enqueue and nothing else is affected.
 */
(function () {
	'use strict';

	if (typeof window === 'undefined' || typeof document === 'undefined') {
		return;
	}

	// Bail in Elementor's editor/preview so we never interfere with editing.
	if (
		document.body &&
		document.body.classList &&
		document.body.classList.contains('elementor-editor-active')
	) {
		return;
	}

	// Graceful no-op on very old browsers lacking the required primitives.
	if (
		typeof MutationObserver === 'undefined' ||
		typeof IntersectionObserver === 'undefined' ||
		typeof WeakSet === 'undefined' ||
		typeof WeakMap === 'undefined' ||
		typeof Set === 'undefined'
	) {
		return;
	}

	/* -------------------------------------------------------------------------
	 * Centralized configuration — the single place to tune behaviour.
	 * ---------------------------------------------------------------------- */
	var CONFIG = {
		// Start work a bit before the image scrolls in, matching lazy-load behaviour.
		rootMargin: '200px 0px',
		threshold: 0.01,
		// Skip tiny images (icons, logos, tracking pixels) where a spinner is noise.
		// Set to 0 to spinner literally every image.
		minSize: 48,
		// Must match the CSS `.i2v-il-overlay` opacity transition (ms).
		fadeDuration: 300,
		// Use HTMLImageElement.decode() (when available) so the spinner stays until
		// the frame is actually paintable — smoother hand-off, no flash.
		useDecode: true,
		// Re-show a spinner when an already-processed image starts loading a NEW
		// resource (programmatic src/srcset swap). Cached/responsive swaps that do
		// not trigger a network load are ignored, so this never causes flicker.
		watchSrcChanges: true,
		// Images matching this are ignored entirely (author opt-out).
		skipSelector: '[data-no-spinner], .no-spinner',
		// Presence of any of these means a lazy image has NOT been swapped in yet,
		// so it must not be treated as "cached" (covers WP Rocket, lazysizes,
		// Swiper `swiper-lazy`, Elementor, etc.).
		lazyAttributes: [
			'data-src',
			'data-lazy-src',
			'data-srcset',
			'data-lazy-srcset',
			'data-lazy-original',
			'data-lazyload'
		],
		classes: {
			host: 'i2v-il-host',
			overlay: 'i2v-il-overlay',
			hidden: 'is-hidden'
		}
	};

	/* -------------------------------------------------------------------------
	 * State
	 * ---------------------------------------------------------------------- */
	// Images already queued/processed, so we never double-handle one.
	var handled = new WeakSet();
	// Per-host counter so the positioning class is added/removed once per host,
	// even when a single host contains multiple images (e.g. galleries).
	var hostCounts = new WeakMap();
	// Image -> its cleanup routine (for teardown on removal or destroy()).
	var cleanups = new WeakMap();
	// Currently-active images (spinner showing). Iterable, used by destroy().
	var activeImgs = new Set();

	/* -------------------------------------------------------------------------
	 * Helpers
	 * ---------------------------------------------------------------------- */

	// True when the image is currently showing an empty/inline placeholder rather
	// than a real rasterized source.
	function isPlaceholderSrc(img) {
		var cur = img.currentSrc || img.getAttribute('src') || '';
		if (cur === '') {
			return true;
		}
		// Inline data-URI placeholders used by most lazy-load libraries.
		if (cur.lastIndexOf('data:', 0) === 0) {
			return true;
		}
		return false;
	}

	// True ONLY while a lazy image still points at a placeholder (not swapped in
	// yet). A lazy attribute alone is not enough: WP Rocket / lazysizes / Swiper /
	// Elementor frequently KEEP `data-src`/`data-srcset` after loading the real
	// image, so keying off attribute presence alone would keep the spinner forever
	// on images that are actually loaded.
	function isLazyPending(img) {
		var hasLazyAttr = false;
		for (var i = 0; i < CONFIG.lazyAttributes.length; i++) {
			if (img.hasAttribute(CONFIG.lazyAttributes[i])) {
				hasLazyAttr = true;
				break;
			}
		}
		if (!hasLazyAttr) {
			return false;
		}
		// Real image swapped in => not pending, even if the data-* attr lingers.
		return isPlaceholderSrc(img) || img.naturalWidth <= 1;
	}

	// A cached image is fully available synchronously — never show a spinner.
	// Lazy placeholders are explicitly NOT considered cached.
	function isCached(img) {
		return img.complete && img.naturalWidth > 0 && !isLazyPending(img);
	}

	// Opt-out + tiny-image filter (no `handled` check, so it's reusable).
	function isIgnorable(img) {
		if (CONFIG.skipSelector && img.matches && img.matches(CONFIG.skipSelector)) {
			return true;
		}
		var attrW = parseInt(img.getAttribute('width'), 10) || 0;
		var attrH = parseInt(img.getAttribute('height'), 10) || 0;
		var estW = Math.max(img.offsetWidth || 0, attrW);
		var estH = Math.max(img.offsetHeight || 0, attrH);
		if (estW && estW < CONFIG.minSize && estH && estH < CONFIG.minSize) {
			return true;
		}
		return false;
	}

	// Ensure the image has a positioned ancestor to anchor the overlay against.
	// Only touches the parent when it is `position: static` (least invasive), and
	// ref-counts so shared hosts (galleries) aren't stripped while still in use.
	function acquireHost(img) {
		var host = img.parentElement;
		if (!host) {
			return null;
		}
		var count = hostCounts.get(host) || 0;
		if (count === 0) {
			var position = window.getComputedStyle(host).position;
			if (position === 'static' || position === '') {
				host.classList.add(CONFIG.classes.host);
			}
		}
		hostCounts.set(host, count + 1);
		return host;
	}

	function releaseHost(host) {
		if (!host) {
			return;
		}
		var count = (hostCounts.get(host) || 1) - 1;
		if (count <= 0) {
			hostCounts.delete(host);
			host.classList.remove(CONFIG.classes.host);
		} else {
			hostCounts.set(host, count);
		}
	}

	// Size the overlay to the image box so the ring is centered over the image.
	// Falls back to covering the host when the image has no measurable box yet
	// (e.g. an unsized image inside a tab that was just revealed).
	function positionOverlay(img, overlay) {
		var w = img.offsetWidth;
		var h = img.offsetHeight;
		if (w > 0 && h > 0) {
			overlay.style.left = img.offsetLeft + 'px';
			overlay.style.top = img.offsetTop + 'px';
			overlay.style.width = w + 'px';
			overlay.style.height = h + 'px';
			overlay.style.right = '';
			overlay.style.bottom = '';
		} else {
			overlay.style.left = '0';
			overlay.style.top = '0';
			overlay.style.right = '0';
			overlay.style.bottom = '0';
			overlay.style.width = '';
			overlay.style.height = '';
		}
	}

	// Single overlay node; the ring is a CSS `::before` (no extra wrapper).
	function buildOverlay() {
		var overlay = document.createElement('span');
		overlay.className = CONFIG.classes.overlay;
		overlay.setAttribute('aria-hidden', 'true'); // decorative — hidden from AT
		overlay.setAttribute('role', 'presentation');
		return overlay;
	}

	/* -------------------------------------------------------------------------
	 * Core: attach a spinner to an image that is actually loading
	 * ---------------------------------------------------------------------- */
	function attachSpinner(img) {
		// Re-check right before attaching: it may have finished while queued.
		if (isCached(img)) {
			handled.add(img);
			return;
		}
		handled.add(img);

		var host = acquireHost(img);
		if (!host) {
			return;
		}

		var overlay = buildOverlay();
		positionOverlay(img, overlay);
		host.appendChild(overlay);
		activeImgs.add(img);

		var done = false;

		// `immediate` skips the fade (used by destroy() for instant teardown).
		function cleanup(immediate) {
			if (done) {
				return;
			}
			done = true;
			img.removeEventListener('load', onLoad);
			img.removeEventListener('error', onError);
			cleanups.delete(img);
			activeImgs.delete(img);

			var removeOverlay = function () {
				overlay.removeEventListener('transitionend', removeOverlay);
				if (overlay.parentNode) {
					overlay.parentNode.removeChild(overlay);
				}
				releaseHost(host);
			};

			if (immediate) {
				removeOverlay();
				return;
			}

			// Fade out, then remove from the DOM.
			overlay.classList.add(CONFIG.classes.hidden);
			overlay.addEventListener('transitionend', removeOverlay);
			// One-shot safety net if transitionend never fires (e.g. tab hidden).
			setTimeout(removeOverlay, CONFIG.fadeDuration + 100);
		}

		// Keep the spinner until the decoded frame is paintable for a smooth swap.
		function finish() {
			if (CONFIG.useDecode && typeof img.decode === 'function') {
				var settle = function () {
					cleanup();
				};
				try {
					img.decode().then(settle, settle);
				} catch (e) {
					cleanup();
				}
			} else {
				cleanup();
			}
		}

		function onLoad() {
			finish();
		}
		function onError() {
			// Never leave a stuck spinner on a broken image.
			cleanup();
		}

		img.addEventListener('load', onLoad, { once: true });
		img.addEventListener('error', onError, { once: true });

		// Store cleanup so removal-from-DOM / destroy() can tear this down.
		cleanups.set(img, cleanup);

		// The image may have completed between our checks and listener binding.
		if (isCached(img)) {
			finish();
		}
	}

	/* -------------------------------------------------------------------------
	 * IntersectionObserver: defer spinner work until the image nears the viewport.
	 * This also transparently handles images inside hidden tabs/accordions/popups
	 * — they only start intersecting once revealed.
	 * ---------------------------------------------------------------------- */
	var io = new IntersectionObserver(
		function (entries) {
			for (var i = 0; i < entries.length; i++) {
				var entry = entries[i];
				if (!entry.isIntersecting) {
					continue;
				}
				var img = entry.target;
				io.unobserve(img);
				if (isCached(img)) {
					handled.add(img);
					continue;
				}
				attachSpinner(img);
			}
		},
		{ rootMargin: CONFIG.rootMargin, threshold: CONFIG.threshold }
	);

	// Register a single image with the pipeline.
	function observeImage(img) {
		if (handled.has(img) || isIgnorable(img)) {
			return;
		}
		if (isCached(img)) {
			handled.add(img);
			return;
		}
		io.observe(img);
	}

	// React to a src/srcset swap on an already-processed image.
	function handleSrcChange(img) {
		if (!CONFIG.watchSrcChanges) {
			return;
		}
		if (activeImgs.has(img) || isIgnorable(img)) {
			return; // already showing, or opted out
		}
		if (isLazyPending(img)) {
			return; // lazy library will finish the swap; IO path handles it
		}
		if (isCached(img)) {
			return; // cached/responsive swap → no network load → no flicker
		}
		// A genuine new load has started; re-queue via the normal (deferred) path.
		handled.delete(img);
		io.observe(img);
	}

	// Register all images inside a subtree (or the node itself if it's an <img>).
	function observeWithin(node) {
		if (node.nodeType !== 1) {
			return;
		}
		if (node.tagName === 'IMG') {
			observeImage(node);
			return;
		}
		if (typeof node.querySelectorAll === 'function') {
			var imgs = node.querySelectorAll('img');
			for (var i = 0; i < imgs.length; i++) {
				observeImage(imgs[i]);
			}
		}
	}

	// Tear down any spinner for an image (or images in a subtree) leaving the DOM.
	function teardownWithin(node) {
		if (node.nodeType !== 1) {
			return;
		}
		if (node.tagName === 'IMG') {
			if (cleanups.has(node)) {
				cleanups.get(node)(true);
			}
			return;
		}
		if (typeof node.querySelectorAll === 'function') {
			var imgs = node.querySelectorAll('img');
			for (var i = 0; i < imgs.length; i++) {
				if (cleanups.has(imgs[i])) {
					cleanups.get(imgs[i])(true);
				}
			}
		}
	}

	/* -------------------------------------------------------------------------
	 * MutationObserver: one observer for the whole document, handling
	 * (a) newly injected images, (b) src/srcset swaps, (c) removed images.
	 * ---------------------------------------------------------------------- */
	var mo = new MutationObserver(function (mutations) {
		for (var i = 0; i < mutations.length; i++) {
			var m = mutations[i];

			if (m.type === 'attributes') {
				var target = m.target;
				if (target && target.nodeType === 1 && target.tagName === 'IMG') {
					handleSrcChange(target);
				}
				continue;
			}

			var added = m.addedNodes;
			for (var a = 0; a < added.length; a++) {
				observeWithin(added[a]);
			}
			var removed = m.removedNodes;
			for (var r = 0; r < removed.length; r++) {
				teardownWithin(removed[r]);
			}
		}
	});

	/* -------------------------------------------------------------------------
	 * Bootstrap
	 * ---------------------------------------------------------------------- */
	function init() {
		// One-time initial scan for images already in the DOM.
		observeWithin(document.body);
		// Then watch for everything that changes afterwards.
		var options = { childList: true, subtree: true };
		if (CONFIG.watchSrcChanges) {
			options.attributes = true;
			options.attributeFilter = ['src', 'srcset'];
		}
		mo.observe(document.documentElement, options);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init, { once: true });
	} else {
		init();
	}

	/* -------------------------------------------------------------------------
	 * Public API (reversibility / manual hooks).
	 * ---------------------------------------------------------------------- */
	window.I2VImageLoader = {
		config: CONFIG,
		// Re-scan a node/subtree (e.g. after a bespoke injection you control).
		refresh: function (node) {
			observeWithin(node || document.body);
		},
		// Fully tear down: stop observing AND remove every active spinner + the
		// runtime host classes, leaving the DOM exactly as it was found.
		destroy: function () {
			io.disconnect();
			mo.disconnect();
			var pending = [];
			activeImgs.forEach(function (img) {
				pending.push(img);
			});
			for (var i = 0; i < pending.length; i++) {
				var cleanup = cleanups.get(pending[i]);
				if (cleanup) {
					cleanup(true);
				}
			}
			activeImgs.clear();
		}
	};
})();

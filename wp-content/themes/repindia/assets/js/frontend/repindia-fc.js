/**
 * RepIndia Frontend Compatibility Layer (RIFC)
 * ------------------------------------------------------------------
 * A small, OPTIONAL helper library for future widgets.
 *
 * Rules that keep it safe:
 *   1. Opt-in: loading this file changes nothing on its own.
 *   2. Inert at load: it only defines `window.RIFC`. No listeners, no DOM
 *      queries, no timers, and it never touches Swiper/GSAP/Lenis globals.
 *   3. Existing widgets, global.js and inline scripts keep working whether
 *      or not they ever use this layer.
 *   4. Swiper/GSAP helpers are read-only: they never reassign globals,
 *      never kill existing animations, never re-init existing instances.
 *
 * Public API (see README.md for examples):
 *   RIFC.ready     – onDOM / onLoad / onElementor / onElementReady
 *   RIFC.util      – debounce / throttle / once / safe / whenReady / isEditor / isPreview
 *   RIFC.events    – on / off / emit  (simple namespaced bus)
 *   RIFC.observe   – onVisible / mutation
 *   RIFC.swiper    – ctor / isReady / whenReady / create   (read-only)
 *   RIFC.gsap      – isReady / registerScrollTrigger / getById / refresh / whenReady
 *   RIFC.registry  – register / run   (idempotent widget init)
 *
 * Dev logging: set `window.RIFC_DEBUG = true` to see swallowed errors.
 */
(function (window, document) {
    'use strict';

    if (window.RIFC) return; // never redefine

    /** Log a swallowed error only when debugging is enabled. */
    function warn(msg, err) {
        if (window.RIFC_DEBUG && window.console) window.console.warn('[RIFC] ' + msg, err || '');
    }

    var RIFC = { version: '1.1.0' };

    /* ==============================================================
     * util — small pure helpers
     * ============================================================== */
    var util = {
        /** Delay fn until `wait`ms after the last call. */
        debounce: function (fn, wait) {
            var t;
            return function () {
                var ctx = this, args = arguments;
                clearTimeout(t);
                t = setTimeout(function () { fn.apply(ctx, args); }, wait || 150);
            };
        },

        /** Run fn at most once per `wait`ms. */
        throttle: function (fn, wait) {
            var last = 0;
            wait = wait || 100;
            return function () {
                var now = Date.now();
                if (now - last >= wait) { last = now; fn.apply(this, arguments); }
            };
        },

        /** Wrap fn so it only ever runs once; returns the first result after. */
        once: function (fn) {
            var done = false, result;
            return function () {
                if (!done) { done = true; result = fn.apply(this, arguments); }
                return result;
            };
        },

        /** Wrap fn so it never throws (errors are logged when RIFC_DEBUG). */
        safe: function (fn) {
            return function () {
                try { return fn.apply(this, arguments); }
                catch (e) { warn('caught error', e); }
            };
        },

        /**
         * Poll `test()` until it returns true, then call `done()`.
         * Mirrors the theme's existing "wait until Swiper/GSAP is loaded" pattern.
         * @param {Function} test  returns true when ready
         * @param {Function} done  called once when ready
         * @param {{interval?:number, attempts?:number}} [opts]
         */
        whenReady: function (test, done, opts) {
            opts = opts || {};
            var interval = opts.interval || 60;
            var left = opts.attempts || 40;
            (function tick() {
                var ready = false;
                try { ready = !!test(); } catch (e) { warn('whenReady test error', e); }
                if (ready) { done(); return; }
                if (--left > 0) setTimeout(tick, interval);
            })();
        },

        /** True inside the Elementor editor. */
        isEditor: function () {
            return !!(window.elementorFrontend &&
                window.elementorFrontend.isEditMode &&
                window.elementorFrontend.isEditMode());
        },

        /** True inside an Elementor preview iframe. */
        isPreview: function () {
            return String(window.location.href).indexOf('elementor-preview') !== -1;
        }
    };
    RIFC.util = util;

    /* ==============================================================
     * ready — lifecycle helpers (safe, no timing changes to existing code)
     * ============================================================== */
    var ready = {
        /** Run after the DOM is parsed (or now, if it already is). */
        onDOM: function (fn) {
            fn = util.safe(fn);
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', fn, { once: true });
            } else { fn(); }
        },

        /** Run after window load (or now, if already loaded). */
        onLoad: function (fn) {
            fn = util.safe(fn);
            if (document.readyState === 'complete') { fn(); }
            else { window.addEventListener('load', fn, { once: true }); }
        },

        /**
         * Run after Elementor's frontend init.
         * Falls back to onDOM when Elementor/jQuery are absent.
         * For per-widget setup prefer onElementReady().
         */
        onElementor: function (fn) {
            fn = util.safe(fn);
            if (window.jQuery && window.elementorFrontend) {
                window.jQuery(window).on('elementor/frontend/init', fn);
            } else { ready.onDOM(fn); }
        },

        /**
         * Subscribe to Elementor's per-widget "element ready" hook — the
         * recommended way to init a widget (works in editor/preview/lazy/AJAX/loop).
         * The handler receives the widget's jQuery $scope, exactly like Elementor.
         * @param {string} widgetName  the widget get_name(), e.g. 'custom_marquee'
         * @returns {boolean} false if Elementor hooks are unavailable
         */
        onElementReady: function (widgetName, handler) {
            if (window.elementorFrontend && window.elementorFrontend.hooks) {
                window.elementorFrontend.hooks.addAction(
                    'frontend/element_ready/' + widgetName + '.default',
                    util.safe(handler)
                );
                return true;
            }
            return false;
        }
    };
    RIFC.ready = ready;

    /* ==============================================================
     * events — tiny namespaced pub/sub (independent of DOM events)
     * ============================================================== */
    var channels = {};
    RIFC.events = {
        /** Subscribe; returns an unsubscribe function. */
        on: function (name, cb) {
            (channels[name] || (channels[name] = [])).push(cb);
            return function () { RIFC.events.off(name, cb); };
        },
        /** Unsubscribe a specific callback. */
        off: function (name, cb) {
            var list = channels[name];
            if (list) channels[name] = list.filter(function (f) { return f !== cb; });
        },
        /** Emit an event to all subscribers. */
        emit: function (name, payload) {
            (channels[name] || []).slice().forEach(function (cb) {
                try { cb(payload); } catch (e) { warn('event "' + name + '" handler error', e); }
            });
        }
    };

    /* ==============================================================
     * observe — IntersectionObserver / MutationObserver helpers
     * ============================================================== */
    RIFC.observe = {
        /**
         * Call cb the first time `el` scrolls into view, then stop watching.
         * Returns a stop() function to cancel early.
         * If IntersectionObserver is unavailable, cb runs immediately.
         * @param {Element} el
         * @param {Function} cb
         * @param {IntersectionObserverInit} [opts]
         */
        onVisible: function (el, cb, opts) {
            if (!el || typeof cb !== 'function') return function () {};
            if (!window.IntersectionObserver) { cb(); return function () {}; }
            var io = new window.IntersectionObserver(function (entries) {
                if (entries[0] && entries[0].isIntersecting) { stop(); cb(entries[0]); }
            }, opts);
            io.observe(el);
            function stop() { io.disconnect(); }
            return stop;
        },

        /**
         * Watch `el` for DOM mutations. Returns a disconnect() function.
         * @param {Element} el
         * @param {Function} cb  MutationObserver callback
         * @param {MutationObserverInit} [config]  defaults to {childList,subtree}
         */
        mutation: function (el, cb, config) {
            if (!el || !window.MutationObserver) return function () {};
            var mo = new window.MutationObserver(util.safe(cb));
            mo.observe(el, config || { childList: true, subtree: true });
            return function () { mo.disconnect(); };
        }
    };

    /* ==============================================================
     * swiper — read-only helpers (respects the theme's SwiperV4 shim)
     * ============================================================== */
    var swiper = {
        /** The Swiper constructor to use (prefers the v4 shim), or null. */
        ctor: function () {
            if (typeof window.SwiperV4 !== 'undefined') return window.SwiperV4;
            if (typeof window.Swiper !== 'undefined') return window.Swiper;
            return null;
        },

        /** True when some Swiper implementation is available. */
        isReady: function () {
            return !!(swiper.ctor() ||
                (window.elementorFrontend && window.elementorFrontend.utils && window.elementorFrontend.utils.swiper));
        },

        /** Poll until Swiper is available, then call cb. */
        whenReady: function (cb, opts) { util.whenReady(swiper.isReady, cb, opts); },

        /**
         * Create a Swiper on `el` only if one isn't already attached
         * (idempotent, matching existing `if (el.swiper) return` guards).
         * Uses Elementor's swiper wrapper when present, else the constructor.
         * @returns the instance (or Elementor's promise), or null.
         */
        create: function (el, config) {
            if (!el || el.swiper) return el ? el.swiper : null;
            try {
                var ef = window.elementorFrontend;
                if (ef && ef.utils && ef.utils.swiper) return ef.utils.swiper(el, config || {});
                var Ctor = swiper.ctor();
                if (Ctor) return new Ctor(el, config || {});
            } catch (e) { warn('swiper.create error', e); }
            return null;
        }
    };
    RIFC.swiper = swiper;

    /* ==============================================================
     * gsap — read-only wrappers (never kills/alters existing animations)
     * ============================================================== */
    var gsap = {
        /** True when gsap is loaded. */
        isReady: function () { return typeof window.gsap !== 'undefined'; },

        /** True when ScrollTrigger is loaded. */
        hasScrollTrigger: function () { return typeof window.ScrollTrigger !== 'undefined'; },

        /** Register ScrollTrigger (safe to call repeatedly). Returns success. */
        registerScrollTrigger: function () {
            if (gsap.isReady() && gsap.hasScrollTrigger()) {
                try { window.gsap.registerPlugin(window.ScrollTrigger); return true; }
                catch (e) { warn('registerScrollTrigger error', e); }
            }
            return false;
        },

        /** Read a ScrollTrigger by id (does not modify it), or null. */
        getById: function (id) {
            try { return gsap.hasScrollTrigger() ? (window.ScrollTrigger.getById(id) || null) : null; }
            catch (e) { return null; }
        },

        /** Request a ScrollTrigger refresh (same call global.js already uses). */
        refresh: function (safe) {
            if (gsap.hasScrollTrigger()) {
                try { window.ScrollTrigger.refresh(safe === true); } catch (e) { warn('gsap refresh error', e); }
            }
        },

        /** Poll until gsap is available, then call cb. */
        whenReady: function (cb, opts) { util.whenReady(gsap.isReady, cb, opts); }
    };
    RIFC.gsap = gsap;

    /* ==============================================================
     * registry — opt-in, idempotent widget init (for future widgets)
     * ============================================================== */
    var defs = {};      // widgetName -> { init, selector, done:WeakSet }
    var booted = false;

    /** Run a widget's init over matching, not-yet-initialized elements. */
    function runWidget(name, scope) {
        var def = defs[name];
        if (!def) return;
        var nodes;
        if (scope && scope.matches && scope.matches(def.selector)) {
            nodes = [scope];
        } else {
            nodes = (scope || document).querySelectorAll(def.selector);
        }
        Array.prototype.forEach.call(nodes, function (el) {
            if (def.done.has(el)) return;
            def.done.add(el);
            try { def.init(el); } catch (e) { warn('registry init "' + name + '" error', e); }
        });
    }

    /** Wire all registered widgets to DOM ready + Elementor element_ready. */
    function boot() {
        if (booted) return;
        booted = true;
        ready.onDOM(function () {
            Object.keys(defs).forEach(function (name) { runWidget(name); });
        });
        Object.keys(defs).forEach(function (name) {
            ready.onElementReady(name, function ($scope) {
                runWidget(name, ($scope && $scope.length) ? $scope[0] : undefined);
            });
        });
    }

    RIFC.registry = {
        /**
         * Register a widget initializer. Runs once per element, on DOM ready
         * and on Elementor element_ready (editor/preview/lazy/AJAX safe).
         * @param {string} name  widget get_name()
         * @param {Function} init  init(element)
         * @param {{selector?:string}} [opts]  custom selector (defaults to the
         *        Elementor widget wrapper `[data-widget_type="name.default"]`)
         */
        register: function (name, init, opts) {
            if (!name || typeof init !== 'function') return;
            if (!defs[name]) {
                defs[name] = {
                    init: init,
                    done: new WeakSet(),
                    selector: (opts && opts.selector) || '[data-widget_type="' + name + '.default"]'
                };
            }
            setTimeout(boot, 0); // batch multiple registrations, then wire once
        },

        /** Manually (re)run a widget's init over a scope. Idempotent per element. */
        run: runWidget
    };

    window.RIFC = RIFC;

})(window, document);

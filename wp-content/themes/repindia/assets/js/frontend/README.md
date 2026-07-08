# RIFC — RepIndia Frontend Compatibility Layer

A small, **optional** helper library for the theme's frontend JavaScript.

Its only job is to make **future** widgets easier to write. It is **not** a
framework and **not** a widget manager.

- File: `assets/js/frontend/repindia-fc.js`
- Global: `window.RIFC`
- Enqueued by: `repindia_enqueue_frontend_compat_layer()` in `functions.php`
  (standalone script, no dependencies, footer).

---

## Ground rules

1. **Opt-in.** Loading the file changes nothing. It only defines `window.RIFC`.
2. **Inert at load.** No event listeners, DOM queries, or timers run until you
   call something. It never touches `Swiper` / `SwiperV4` / `gsap` /
   `ScrollTrigger` / `Lenis`.
3. **Existing code is untouched.** `global.js`, widget JS, and inline scripts
   keep working exactly as before. Nothing depends on RIFC.
4. **Swiper/GSAP helpers are read-only.** They never reassign globals, kill
   existing animations, or re-init existing instances.

Turn on debug logging (shows otherwise-swallowed errors):

```js
window.RIFC_DEBUG = true;
```

---

## Public API

### `RIFC.ready`
| Method | Description |
| --- | --- |
| `onDOM(fn)` | Run after DOM is parsed (or immediately if already parsed). |
| `onLoad(fn)` | Run after `window` load (or immediately if already loaded). |
| `onElementor(fn)` | Run after `elementor/frontend/init`; falls back to `onDOM`. Use for global setup. |
| `onElementReady(name, fn)` | **Preferred for widgets.** Subscribe to Elementor's per-widget hook. `fn` gets the widget `$scope`. Returns `false` if Elementor isn't present. |

### `RIFC.util`
| Method | Description |
| --- | --- |
| `debounce(fn, wait=150)` | Trailing debounce. |
| `throttle(fn, wait=100)` | Leading throttle. |
| `once(fn)` | Run at most once. |
| `safe(fn)` | Wrap so it never throws (logs when `RIFC_DEBUG`). |
| `whenReady(test, done, opts?)` | Poll `test()` until true, then call `done()`. `opts = {interval=60, attempts=40}`. |
| `isEditor()` | `true` in the Elementor editor. |
| `isPreview()` | `true` in an Elementor preview iframe. |

### `RIFC.events`
| Method | Description |
| --- | --- |
| `on(name, cb)` | Subscribe; returns an unsubscribe function. |
| `off(name, cb)` | Unsubscribe. |
| `emit(name, payload)` | Emit to subscribers. |

### `RIFC.observe`
| Method | Description |
| --- | --- |
| `onVisible(el, cb, opts?)` | Call `cb` the first time `el` enters the viewport, then stop. Returns `stop()`. Falls back to running `cb` immediately if `IntersectionObserver` is unavailable. |
| `mutation(el, cb, config?)` | Watch DOM mutations. Returns `disconnect()`. |

### `RIFC.swiper` (read-only)
| Method | Description |
| --- | --- |
| `ctor()` | The Swiper constructor to use (prefers the `SwiperV4` shim), or `null`. |
| `isReady()` | `true` when a Swiper implementation is available. |
| `whenReady(cb, opts?)` | Poll until Swiper is ready, then call `cb`. |
| `create(el, config)` | Create a Swiper **only if** `el.swiper` isn't set (idempotent). Uses Elementor's swiper wrapper when present. |

### `RIFC.gsap` (read-only)
| Method | Description |
| --- | --- |
| `isReady()` | `true` when `gsap` is loaded. |
| `hasScrollTrigger()` | `true` when `ScrollTrigger` is loaded. |
| `registerScrollTrigger()` | Register the plugin (safe to repeat). |
| `getById(id)` | Read a ScrollTrigger by id (never modifies it). |
| `refresh(safe?)` | Request a `ScrollTrigger.refresh()`. |
| `whenReady(cb, opts?)` | Poll until `gsap` is ready, then call `cb`. |

### `RIFC.registry`
| Method | Description |
| --- | --- |
| `register(name, init, opts?)` | Register `init(element)` for a widget. Runs **once per element** on DOM ready and Elementor `element_ready`. `opts.selector` overrides the default `[data-widget_type="name.default"]`. |
| `run(name, scope?)` | Manually (re)run a widget's init over a scope. Idempotent per element. |

---

## Usage examples

Initialize a future widget (recommended):

```js
RIFC.ready.onElementReady('my_widget', function ($scope) {
    var el = $scope[0];
    // ...set up this widget instance...
});
```

Or via the registry (auto-wires DOM ready + element_ready, idempotent):

```js
RIFC.registry.register('my_widget', function (el) {
    // runs once per <div data-widget_type="my_widget.default"> ...
});
```

Wait for Swiper, then create one safely:

```js
RIFC.swiper.whenReady(function () {
    var el = document.querySelector('.my-widget .swiper');
    RIFC.swiper.create(el, { slidesPerView: 3, spaceBetween: 20 });
});
```

Animate only when a section is visible:

```js
RIFC.observe.onVisible(document.querySelector('.counter'), function () {
    startCounter();
});
```

Debounced resize handler:

```js
window.addEventListener('resize', RIFC.util.debounce(onResize, 200));
```

---

## Best practices

- Prefer `RIFC.ready.onElementReady()` (or `RIFC.registry.register()`) for
  widgets — it handles editor, preview, lazy load, AJAX and loop rendering.
- Keep each widget's own JS in its own file/inline script. RIFC is a helper,
  not a place to move widget logic.
- Use `RIFC.swiper.whenReady` / `RIFC.gsap.whenReady` instead of hand-rolled
  polling loops.

## What NOT to do

- ❌ Don't make existing widgets depend on RIFC — they already work.
- ❌ Don't reassign `window.Swiper` / `window.SwiperV4` / `window.gsap`.
- ❌ Don't kill or re-init ScrollTriggers created by `global.js`.
- ❌ Don't move `global.js` or widget logic into this file.
- ❌ Don't grow the API "just in case" — add a helper only when a widget needs it.

## Rollback

Delete `assets/js/frontend/` and remove `repindia_enqueue_frontend_compat_layer`
(+ its `add_action`) from `functions.php`. Nothing else references RIFC.

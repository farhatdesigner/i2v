# Future Custom Elementor Widget Standard

The official standard for building **new** custom Elementor widgets in the
`repindia` theme.

> This document applies to **new widgets only**. Existing widgets are
> production-proven and must not be changed. RIFC is frozen — use its existing
> API, do not extend it.

The goal is a pattern that is small, predictable, and easy for a single
developer to maintain months from now. It intentionally mirrors the conventions
already used in `inc/elementor-addons/widgets/` so new widgets feel native.

---

## 1. Recommended folder structure

Existing widgets live flat as `widgets/<name>.php`. For **new** widgets, keep
the PHP, JS, and CSS for one widget together in a folder named after the widget:

```
inc/elementor-addons/
├── custom-elementor.php          # existing loader (add 2 lines per new widget)
├── FUTURE_WIDGET_STANDARD.md     # this guide
└── widgets/
    ├── ...existing flat widgets... (leave untouched)
    └── example_widget/           # NEW widgets: one folder each
        ├── example_widget.php    # widget class
        ├── example_widget.js     # frontend init (optional)
        └── example_widget.css    # widget-scoped styles (optional)
```

Rules:
- One folder per new widget. No deeper nesting.
- Folder name === widget `get_name()` === asset file names. Consistency makes
  everything greppable.
- Only add `.js` / `.css` files when the widget actually needs them.

---

## 2. PHP template

```php
<?php
namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (! defined('ABSPATH')) {
    exit;
}

class Example_Widget extends Widget_Base
{
    // Must match the folder + asset file names.
    public function get_name()
    {
        return 'example_widget';
    }

    public function get_title()
    {
        return esc_html__('Example Widget', 'repindia');
    }

    public function get_icon()
    {
        return 'eicon-code'; // any Elementor icon class
    }

    public function get_categories()
    {
        return ['general']; // same category all theme widgets use
    }

    /**
     * Load JS ONLY on pages where this widget is present.
     * Handles are registered once (see section 5).
     */
    public function get_script_depends()
    {
        return ['example-widget']; // omit if the widget has no JS
    }

    public function get_style_depends()
    {
        return ['example-widget']; // omit if the widget has no CSS
    }

    protected function register_controls()
    {
        // --- CONTENT ---
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Content', 'repindia'),
        ]);

        $this->add_control('title', [
            'label'       => esc_html__('Title', 'repindia'),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => '',
        ]);

        $repeater = new Repeater();
        $repeater->add_control('item_text', [
            'label' => esc_html__('Item Text', 'repindia'),
            'type'  => Controls_Manager::TEXT,
        ]);

        $this->add_control('items', [
            'label'       => esc_html__('Items', 'repindia'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [],
            'title_field' => '{{{ item_text }}}',
        ]);

        $this->end_controls_section();

        // --- STYLE (bind to {{WRAPPER}} so it never leaks) ---
        $this->start_controls_section('style_section', [
            'label' => esc_html__('Style', 'repindia'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label'     => esc_html__('Title Color', 'repindia'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .example-widget__title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $title = isset($settings['title']) ? $settings['title'] : '';
        $items = ! empty($settings['items']) ? $settings['items'] : [];
        ?>
        <div class="example-widget">
            <?php if ($title !== '') : ?>
                <h2 class="example-widget__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if (! empty($items)) : ?>
                <ul class="example-widget__list">
                    <?php foreach ($items as $item) : ?>
                        <li class="example-widget__item">
                            <?php echo esc_html($item['item_text'] ?? ''); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php
    }
}
```

PHP best practices:
- Always `if (! defined('ABSPATH')) exit;`.
- `get_name()` is the widget's identity — used by Elementor, WPML config, RIFC,
  and asset naming. Never change it after content is created with the widget.
- Escape **everything** on output: `esc_html`, `esc_url`, `esc_attr`,
  `wp_kses_post` (for rich text). Escape `esc_js` inside inline scripts.
- Use `get_settings_for_display()` (not `get_settings()`) in `render()`.
- Bail early on empty data. Never assume repeater/media keys exist — use `??`.
- Keep all styling in `{{WRAPPER}} .your-class` selectors so Elementor scopes it
  to the single widget instance.
- **Do not** print large inline `<style>`/`<script>` blocks for new widgets —
  use the colocated `.css`/`.js` files (sections 4–5) so assets are cacheable
  and load only when needed.

### Registering the widget (existing loader)

New widgets are registered exactly like the current ones — add two lines to
`inc/elementor-addons/custom-elementor.php`:

```php
// in include_widgets_files()
require_once(__DIR__ . '/widgets/example_widget/example_widget.php');

// in register_widgets()
\Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Example_Widget());
```

Do not build a new registration system — reuse the loader that already works.

---

## 3. JavaScript template (`example_widget.js`)

Use the frozen RIFC API. `onElementReady` is the recommended entry point: it
runs per widget instance and works in the editor, preview, lazy load, AJAX, and
loop rendering.

```js
(function () {
    'use strict';

    function initExampleWidget(scope) {
        // `scope` is the widget's root element (see wiring below).
        var root = scope.querySelector('.example-widget');
        if (!root) return;

        // ...widget behavior here...
    }

    // Preferred: run once per widget instance.
    if (window.RIFC && RIFC.ready.onElementReady('example_widget', function ($scope) {
        initExampleWidget($scope[0] || document);
    })) {
        // wired to Elementor — nothing else to do
    } else {
        // Fallback when RIFC/Elementor is unavailable (e.g. plain template).
        (window.RIFC ? RIFC.ready.onDOM : function (fn) {
            document.addEventListener('DOMContentLoaded', fn);
        })(function () {
            document.querySelectorAll('.example-widget').forEach(function (el) {
                initExampleWidget(el);
            });
        });
    }
})();
```

Even simpler, if you don't need the manual fallback, use the registry (it wires
DOM ready **and** element_ready for you, idempotently):

```js
(function () {
    'use strict';
    if (!window.RIFC) return;

    RIFC.registry.register('example_widget', function (el) {
        // runs once per <div data-widget_type="example_widget.default">
        // `el` is the Elementor widget wrapper element
    });
})();
```

JS best practices:
- Keep each widget's logic in its own file. RIFC is a helper, not a home for
  widget logic.
- Always guard: `if (!root) return;`. Never assume the element exists.
- Idempotency: check before initializing (e.g. a `data-` flag, or `el.swiper`
  for sliders) so re-runs in the editor don't double-init.
- Prefer `RIFC.util.debounce` / `throttle` for resize/scroll handlers.
- No classes/build step required — a plain IIFE is enough.

---

## 4. CSS template (`example_widget.css`)

```css
/* All rules prefixed with the widget's block class → no global leakage. */
.example-widget {
    /* layout */
}

.example-widget__title {
    /* element */
}

.example-widget__list {
    display: grid;
    gap: 16px;
}

.example-widget__item {
    /* element */
}

/* RTL: only when the widget needs direction-specific tweaks.
   The theme already ships rlt.css globally — mirror only what's necessary. */
[dir="rtl"] .example-widget__list {
    /* rtl overrides */
}
```

CSS best practices:
- Namespace every selector with a unique block class (`.example-widget`). Never
  style bare tags or generic classes.
- Use BEM-ish naming: `.block`, `.block__element`, `.block--modifier`. It reads
  well and avoids collisions.
- Prefer Elementor style controls (`{{WRAPPER}}`) for anything a content editor
  should control; keep the `.css` file for structural/layout styling.
- Don't rely on or override existing theme selectors — pick a new class name.

---

## 5. Asset loading standard

Load a new widget's assets through Elementor's dependency methods so they load
**only on pages where the widget is used** — without touching the theme's
existing global enqueues in `functions.php`.

Register the handles once (a self-contained hook near the widget class, or a
small shared bootstrap for new widgets):

```php
add_action('wp_enqueue_scripts', function () {
    $base = get_template_directory_uri() . '/inc/elementor-addons/widgets/example_widget/';
    $ver  = defined('REPINDIA_THEME_VERSION') ? REPINDIA_THEME_VERSION : false;

    wp_register_style('example-widget', $base . 'example_widget.css', [], $ver);
    wp_register_script('example-widget', $base . 'example_widget.js',
        ['repindia-frontend-compat'], $ver, true); // depends on RIFC only if used
});
```

Then the widget declares them:

```php
public function get_script_depends() { return ['example-widget']; }
public function get_style_depends()  { return ['example-widget']; }
```

Rules:
- Register, then declare via `get_*_depends()`. Elementor enqueues them only when
  the widget is on the page.
- If the JS uses RIFC, list `repindia-frontend-compat` as a dependency so RIFC is
  guaranteed to load first. If it doesn't use RIFC, don't add the dependency.
- Reuse existing global libraries (jQuery, Swiper 4.5.1, GSAP, ScrollTrigger,
  Lenis) — they're already enqueued theme-wide. Don't re-bundle them.
- Never modify the existing global enqueue function.

---

## 6. Initialization standard (summary)

| Situation | Use |
| --- | --- |
| Standard widget setup | `RIFC.ready.onElementReady('name', fn)` |
| Same, auto-wired + idempotent | `RIFC.registry.register('name', fn)` |
| Global (non per-widget) setup | `RIFC.ready.onElementor(fn)` / `RIFC.ready.onDOM(fn)` |
| Wait for Swiper before init | `RIFC.swiper.whenReady(fn)` |
| Wait for GSAP before init | `RIFC.gsap.whenReady(fn)` |
| Reveal on scroll | `RIFC.observe.onVisible(el, fn)` |

---

## 7. Naming conventions

| Thing | Convention | Example |
| --- | --- | --- |
| Widget `get_name()` | `snake_case` | `example_widget` |
| PHP class | `Studly_Snake` in `WPC\Widgets` | `Example_Widget` |
| Folder + asset files | match `get_name()` | `example_widget.php/.js/.css` |
| Asset handle | `kebab-case` | `example-widget` |
| CSS block class | `kebab-case`, BEM | `.example-widget__title` |
| WPML string context | `Repindia-Widgets` (or a widget-specific context) | — |

Keep the name identical across all of these so the widget is trivially
greppable.

---

## 8. Best practices

- **Additive only.** A new widget must never require changes to existing widgets,
  `global.js`, CSS, or RIFC.
- **Scope everything** — CSS via block classes, style controls via `{{WRAPPER}}`.
- **Escape on output**, sanitize on input.
- **Guard and bail** — check elements/data exist before use.
- **Load assets conditionally** via `get_*_depends()`.
- **Reuse, don't duplicate** — libraries and RIFC helpers already exist.
- **WPML-ready from day one** (section below).
- **Keep it small** — a widget = one folder, ≤3 files.

---

## 9. Common mistakes to avoid

- ❌ Reusing an existing widget's CSS classes or DOM contract (e.g.
  `.testimonialSwiper`, `.hero-swiper-container`, `.sectionsscroll`). These are
  wired to `global.js`; pick your own class.
- ❌ Reassigning `window.Swiper`, `window.SwiperV4`, or `window.gsap`.
- ❌ Killing or re-initializing ScrollTriggers created by `global.js`.
- ❌ Bundling your own copy of jQuery/Swiper/GSAP.
- ❌ Enqueuing widget assets globally in `functions.php`.
- ❌ Large inline `<script>`/`<style>` in `render()` for new widgets.
- ❌ Hardcoding absolute URLs (use `home_url()` / `get_template_directory_uri()`).
- ❌ Forgetting to add the widget to `wpml-config.xml` (untranslatable fields).
- ❌ Changing `get_name()` after the widget is in use (orphans saved content).
- ❌ Extending RIFC "just in case."

---

## 10. WPML, GSAP, Swiper for new widgets

### WPML (LTR / RTL / translation)
- Add the widget's translatable fields to `wpml-config.xml` under
  `<elementor-widgets>` (mirror the existing entries). This exposes fields to the
  WPML Translation Editor.
- For hardcoded template strings, wrap with the theme helper:
  `wpml_t('Text', 'Repindia-Widgets', 'unique-key')`, or standard
  `esc_html__('Text', 'repindia')`.
- RTL: the theme already loads `rlt.css` globally and sets document direction.
  Read direction (never hardcode) — in JS use `document.documentElement.dir`;
  in CSS use `[dir="rtl"] .example-widget ...`. Only add RTL rules where layout
  actually differs.

### GSAP (new widgets)
- Never touch existing GSAP/ScrollTrigger/Lenis code.
- Initialize through RIFC read-only wrappers:

```js
RIFC.gsap.whenReady(function () {
    RIFC.gsap.registerScrollTrigger();
    gsap.from('.example-widget__item', {
        scrollTrigger: { trigger: '.example-widget', id: 'example-widget' }, // unique id!
        y: 40, opacity: 0
    });
});
```

- Always give your ScrollTriggers a **unique `id`** so they never clash with the
  theme's (`sectionsscroll-pin`, `gallery-pin`, `card-*`, `gallery-section-*`).
- Kill only your own triggers by that id on teardown; never `ScrollTrigger.getAll().kill()`.

### Swiper (new widgets)
- Reuse the theme's Swiper. Initialize safely and idempotently:

```js
RIFC.swiper.whenReady(function () {
    var el = document.querySelector('.example-widget .swiper');
    RIFC.swiper.create(el, { slidesPerView: 3, spaceBetween: 20 });
    // RIFC.swiper.create() no-ops if el.swiper already exists (idempotent),
    // and prefers the SwiperV4 shim / Elementor's swiper wrapper automatically.
});
```

- Use your own container class; don't reuse existing slider selectors.
- Never reassign the Swiper globals or alter the `SwiperV4` shim.

---

## Example skeleton (copy to start a new widget)

```
inc/elementor-addons/widgets/example_widget/
├── example_widget.php   → class from section 2
├── example_widget.js    → IIFE from section 3
└── example_widget.css   → block styles from section 4
```

Then: register the assets (section 5) and add the two loader lines (section 2).
That's the whole process — no framework, no build step, no changes to existing
code.

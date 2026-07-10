---
title: Slider
slug: slider
api_layer: Component API
status: implemented-standard
system_maturity: implemented
category: inputs
priority: tier-b-common-reusable-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/slider.md
source_owner: not installed
blade_api:
  - x-ui.slider
javascript_api:
  - initSliders exported from resources/js/ui-controls/sliders.js
source_files:
  - resources/views/components/ui/slider/index.blade.php
  - resources/js/ui-controls/sliders.js
  - resources/css/components/slider.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
related_components:
  - number-input
  - text-input
  - form-field
related_patterns:
  - forms
  - filters
---

# Slider

## 1. API Summary

Slider adjusts a bounded numeric value when relative position is useful. The installed `x-ui.slider` component owns both single-handle and two-handle range behavior.

Canonical API owner: `not installed`.

Feature views must not add local range inputs, local number-input synchronization, or compatibility aliases for deleted slider APIs.

## 2. Installed Standard

- Use `x-ui.slider` for single numeric slider controls.
- Use `x-ui.slider` with `two-handles`, `name-upper`, and `value-upper` for lower/upper range selection.
- Use `label-text` for visible label copy.
- Use `value`, `min`, `max`, and `step` for the lower or single value.
- Use `hide-text-input` only when exact typed entry should be hidden.
- Use `invalid` plus `invalid-text`, and `warn` plus `warn-text`, for feedback.
- Use `read-only` when values should remain visible but not editable.
- Do not build a feature-local paired slider or introduce a separate public range component.

Carbon alignment note: Carbon defines single-handle and two-handle slider behavior as variants of bounded numeric selection. Login App maps both variants to the installed `x-ui.slider` component, app-owned `ui-*` classes, Foundation tokens, and rendered evidence proof.

## 3. Public API

### 3.1. Single Value

```blade
<x-ui.slider
    name="retention_days"
    label-text="Retention days"
    value="30"
    min="0"
    max="90"
    step="1"
/>
```

### 3.2. Two-Handle Range

```blade
<x-ui.slider
    name="min_score"
    name-upper="max_score"
    label-text="Score range"
    value="20"
    value-upper="80"
    min="0"
    max="100"
    step="1"
    two-handles
/>
```

### 3.3. Validation

```blade
<x-ui.slider
    name="quota_limit"
    label-text="Quota limit"
    value="95"
    min="0"
    max="100"
    warn
    warn-text="High quota limits require owner confirmation."
/>
```

## 4. Props

| Prop | Required | Rule |
| --- | --- | --- |
| `name` | when form-bound | Submitted lower or single value field name. |
| `name-upper` | for two handles | Submitted upper value field name. |
| `label-text` | yes unless hidden with an accessible substitute | Visible label copy. |
| `value` | yes | Lower or single value. |
| `value-upper` | for two handles unless defaulting to max | Upper value. |
| `min` / `max` | yes | Numeric bounds. |
| `step` | no | Increment size. Defaults to `1`. |
| `two-handles` | for explicit range mode | Enables paired lower and upper handles. |
| `hide-text-input` | no | Hides visible text inputs while preserving slider interaction. |
| `disabled` | no | Field is non-interactive and not editable. |
| `read-only` | no | Values remain visible and submitted but cannot be edited. |
| `invalid` / `invalid-text` | no | Error state and visible error message. |
| `warn` / `warn-text` | no | Warning state and visible warning message. |
| `min-label` / `max-label` | no | Boundary labels when needed. |
| `aria-label-input` / `aria-label-input-upper` | no | Accessible names for lower and upper handles when label text alone is insufficient. |

## 5. Component Hooks

Feature code may use these hooks for tests and installed JavaScript initialization only.

| Hook | Owner | Purpose |
| --- | --- | --- |
| `data-ui-component="slider"` | Component | Root diagnostic hook. |
| `data-ui-slider-container` | Component | Slider behavior container. |
| `data-ui-slider-two-handles="true"` | Component | Identifies paired lower/upper mode. |
| `data-ui-slider-input` | Component | Numeric text input. |
| `data-ui-slider` | Component | Range-track control. |
| `data-ui-slider-thumb` | Component | Draggable/focusable handle. |
| `data-ui-slider-filled-track` | Component | Filled track segment. |
| `data-ui-slider-value` | Component | Visible value output. |
| `data-ui-slider-state` | Component | Validation or warning state metadata. |

CSS selectors are owned by `resources/css/components/slider.css` and use the `ui-slider` family.

## 6. Accessibility

- The control must expose label, min, max, step, and current values programmatically.
- Keyboard interaction must support Arrow keys, Home, End, and larger step movement through installed JavaScript.
- In two-handle mode, handles must not cross invalidly; the lower and upper values remain ordered.
- Validation and warning states must have visible text and programmatic association.
- Disabled and read-only states must be distinguishable without relying on color alone.

## 7. rendered evidence proof

The rendered evidence page must prove:

- single-value `x-ui.slider`
- two-handle `x-ui.slider`
- visible value and text-input synchronization
- disabled and read-only states
- invalid and warning feedback
- keyboard behavior and ordered lower/upper values
- current source file, CSS, and JavaScript ownership

Suggested assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('x-ui.slider');
$response->assertSee('data-ui-component="slider"', false);
$response->assertSee('data-ui-slider-two-handles="true"', false);
$response->assertSee('data-ui-slider-input', false);
$response->assertSee('data-ui-slider-thumb', false);
```

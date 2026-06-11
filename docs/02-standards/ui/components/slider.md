---
title: Slider
slug: slider
api_layer: Component API
status: implemented-standard
system_maturity: partial
category: inputs
priority: tier-c-contextual
ui_reference_route: /platform/ui-reference/components/slider
canonical_doc: docs/02-standards/ui/components/slider.md
source_owner: /platform/ui-reference/components/slider
blade_api:
  - x-ui.slider
  - x-ui.range-slider
javascript_api: []
source_files:
  - resources/views/components/ui/slider.blade.php
  - resources/views/components/ui/range-slider.blade.php
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
  - 2x-grid
related_components:
  - number-input
  - text-input
  - select
  - toggle
  - checkbox
  - radio-button
  - form-field
related_patterns:
  - forms
  - navigation
  - settings
carbon_reference:
  - https://carbondesignsystem.com/components/slider/usage/
  - https://carbondesignsystem.com/components/slider/style/
  - https://carbondesignsystem.com/components/slider/accessibility/
---

# Slider Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical single-value slider](#41-canonical-single-value-slider)
  - [4.2. Canonical single-value slider with exact entry](#42-canonical-single-value-slider-with-exact-entry)
  - [4.3. Canonical range slider](#43-canonical-range-slider)
  - [4.4. Canonical invalid state](#44-canonical-invalid-state)
  - [4.5. API surfaces](#45-api-surfaces)
  - [4.6. Props and options](#46-props-and-options)
  - [4.7. Data attribute contract](#47-data-attribute-contract)
  - [4.8. Slot contract](#48-slot-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper ownership](#74-helper-ownership)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Current production choice guidance:](#93-current-production-choice-guidance)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
  - [11.1. Recommended labels:](#111-recommended-labels)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. UI Reference requirements](#14-ui-reference-requirements)
  - [14.1. Required Live examples internal sections:](#141-required-live-examples-internal-sections)
- [15. Testing and acceptance criteria](#15-testing-and-acceptance-criteria)
  - [15.1. Suggested automated assertions:](#151-suggested-automated-assertions)
- [16. Related APIs](#16-related-apis)
- [17. References](#17-references)

## 1. API summary

Slider selects a numeric value, or a numeric minimum/maximum range, from a bounded scale.

Canonical API owner: `/platform/ui-reference/components/slider`. Use this Component API instead of creating local markup, styling, JavaScript, ARIA behavior, range synchronization, value display, or validation behavior for the same UI role.

Slider is the installed Login App 2.0 bounded numeric adjustment API. It owns single-value slider behavior, range-slider behavior, track and thumb structure, visible value entry, minimum and maximum labels, step behavior, disabled and read-only presentation, error/validation handoff, focus styling, keyboard interaction, pointer interaction, responsive layout, reduced-motion behavior, and screen-reader value communication. It does not own product-specific filtering, query persistence, business validation, form submission orchestration, or page-level workflow state.

### 1.1. Canonical API responsibilities:

- Render single-value sliders through `x-ui.slider`.
- Render minimum/maximum range sliders through `x-ui.range-slider`.
- Use a visible label for every slider.
- Use a visible value input or value output whenever the selected value must be understood exactly.
- Use `min`, `max`, `step`, and current value props to define the allowed range.
- Keep visual slider state synchronized with submitted form values.
- Support keyboard and pointer operation without requiring feature-local JavaScript.
- Support disabled, read-only, invalid/error, helper text, endpoint labels, responsive layout, and reduced-motion behavior through the component API.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, icons where installed, and 2x Grid where layout is relevant.
- Prove single-value, range, value entry, keyboard, pointer, validation, disabled/read-only, responsive, reduced-motion, and developer implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Exact numeric entry where the slider track adds no value. Use Number input.
- Numeric-like formatted values that require masking or parsing. Use Text input and Forms Pattern validation.
- Short known option sets. Use Select or Radio button.
- Binary settings. Use Toggle or Checkbox.
- Filter query state, reset behavior, result updates, and persistence. Parent Patterns own filtering/search behavior.
- Form field layout, helper text grouping, validation summary, and submit/cancel orchestration. Use Forms Pattern.
- Progress display. Use Progress bar, Progress indicator, Loading, or Inline loading as appropriate.

Carbon alignment note: Carbon defines Slider for bounded numeric selection, with default and range variants, labels, minimum/maximum values, number input/value entry, handles, track, keyboard support, and range-slider tab order. Login App maps those completeness principles to its own `x-ui.slider`, `x-ui.range-slider`, app-owned `ui-*` classes, Foundation tokens, and UI Reference proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                                             |
| ---------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented standard                                                                                                              |
| System maturity              | Partial                                                                                                                           |
| API layer                    | Component API                                                                                                                     |
| Component slug               | `slider`                                                                                                                          |
| Category                     | Inputs                                                                                                                            |
| Priority                     | Tier C - Contextual                                                                                                               |
| UI Reference route           | `/platform/ui-reference/components/slider`                                                                                        |
| Canonical doc                | `docs/02-standards/ui/components/slider.md`                                                                                       |
| Source owner                 | `/platform/ui-reference/components/slider`                                                                                        |
| Blade API                    | `x-ui.slider`; `x-ui.range-slider`                                                                                                |
| JavaScript API               | No dedicated feature JavaScript controller required; component-owned behavior handles value synchronization where needed          |
| Source files                 | `resources/views/components/ui/slider.blade.php`; `resources/views/components/ui/range-slider.blade.php`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons where installed, 2x Grid                                                        |
| Carbon benchmark             | Carbon Slider usage, style, and accessibility guidance                                                                            |

`Implemented standard` means this document defines the expected public Component API and UI Reference proof. Feature teams must use the documented API rather than local slider markup, local range inputs, local JavaScript packages, or ad hoc track/thumb styling.

## 3. Installed standard

Slider has component-specific UI Reference examples that consume approved Foundation Elements and installed input/form APIs.

### 3.1. The installed standard is:

- Render single-value sliders through `<x-ui.slider>`.
- Render minimum/maximum sliders through `<x-ui.range-slider>`.
- Use Slider only for bounded numeric values where relative adjustment is useful.
- Use Number input instead when exact numeric typing is the primary interaction.
- Use Select or Radio button when the values are a short known set.
- Use Toggle or Checkbox when the value is binary.
- Provide a stable visible label.
- Provide visible `min`, `max`, and current value context.
- Provide a visible numeric value field when exact entry or correction matters.
- Use `step` to define the increment used by pointer and keyboard interaction.
- Use helper text for units, consequences, constraints, or range meaning.
- Use error text when submitted or synchronized values are invalid.
- Keep slider value and associated value input synchronized through component-owned behavior.
- Keep range slider minimum and maximum values ordered.
- Prevent range handles from crossing unless a future standard explicitly defines crossing behavior.
- Use token-backed focus, hover, active/dragging, disabled, read-only, invalid, and responsive behavior.
- Respect reduced-motion preferences for handle, value-bubble, tooltip, or track transitions.
- Do not use Slider for progress display, decoration, ratings, carousel scrubbing, timelines, or non-numeric values.
- Do not create local `<input type="range">`, local `ui-slider*` classes, or local slider JavaScript.

## 4. Public API

### 4.1. Canonical single-value slider

```blade
<x-ui.slider
    name="retention_days"
    label="Retention period"
    :min="1"
    :max="90"
    :step="1"
    :value="30"
    unit="days"
    helper="Choose how long activity records are retained."
/>
```

### 4.2. Canonical single-value slider with exact entry

```blade
<x-ui.slider
    name="threshold"
    label="Threshold"
    :min="0"
    :max="100"
    :step="1"
    :value="50"
    unit="%"
    show-input
    helper="Set the alert threshold for this workspace."
/>
```

### 4.3. Canonical range slider

```blade
<x-ui.range-slider
    name-min="amount_min"
    name-max="amount_max"
    label="Amount range"
    :min="0"
    :max="500"
    :step="5"
    :value-min="50"
    :value-max="250"
    unit="$"
    show-inputs
    helper="Filter results by minimum and maximum amount."
/>
```

### 4.4. Canonical invalid state

```blade
<x-ui.slider
    name="maximum_users"
    label="Maximum users"
    :min="1"
    :max="100"
    :step="1"
    :value="125"
    show-input
    invalid
    error="Enter a value from 1 to 100."
/>
```

Use these Blade APIs instead of hand-building range inputs, track/thumb markup, value bubbles, or local synchronization scripts in feature views.

### 4.5. API surfaces

| API surface            | Installed value                                                                                                       |
| ---------------------- | --------------------------------------------------------------------------------------------------------------------- |
| Single-value Blade API | `x-ui.slider`                                                                                                         |
| Range Blade API        | `x-ui.range-slider`                                                                                                   |
| JavaScript             | No feature-local JavaScript. Component-owned behavior synchronizes track, thumb, input, and form values where needed. |
| Root semantic element  | Component-owned slider field with native input/range semantics or equivalent accessible slider semantics              |
| Data attributes        | Component-emitted hooks only. Feature views must not invent `data-ui-slider*` behavior.                               |
| Props/options          | Only documented props/options are public.                                                                             |
| Slots                  | Optional helper/value slots only when installed by source owner.                                                      |
| CSS namespace          | App-owned `ui-slider*` classes documented by the component implementation                                             |
| Source owner           | `/platform/ui-reference/components/slider`                                                                            |

### 4.6. Props and options

| Prop/option      | Type      | Default | Allowed values        | Required                               | Notes                                                                                           |
| ---------------- | --------- | ------- | --------------------- | -------------------------------------- | ----------------------------------------------------------------------------------------------- |
| `name`           | `string`  | none    | Valid form field name | Yes for `x-ui.slider`                  | Submitted field name for single-value slider.                                                   |
| `name-min`       | `string`  | none    | Valid form field name | Yes for `x-ui.range-slider`            | Submitted minimum value field.                                                                  |
| `name-max`       | `string`  | none    | Valid form field name | Yes for `x-ui.range-slider`            | Submitted maximum value field.                                                                  |
| `label`          | `string`  | none    | Short visible label   | Yes                                    | Names the adjusted value.                                                                       |
| `min`            | `int / float` | none    | Numeric lower bound                    | Yes                                    | Minimum allowed value.                                                          |
| `max`            | `int / float` | none    | Numeric upper bound greater than `min` | Yes                                    | Maximum allowed value.                                                          |
| `step`           | `int / float` | `1`     | Positive numeric increment             | No                                     | Defines pointer and keyboard increments.                                        |
| `value`          | `int / float` | `min`   | Between `min` and `max`                | Yes for single-value slider            | Current value.                                                                  |
| `value-min`      | `int / float` | `min`   | Between `min` and `value-max`          | Yes for range slider                   | Current lower selected value.                                                   |
| `value-max`      | `int / float` | `max`   | Between `value-min` and `max`          | Yes for range slider                   | Current upper selected value.                                                   |
| `unit`           | `string`  | `null`  | `null`                | Short unit label                       | No                                                                                              | Examples: `%`, `days`, `users`, `$`.                                            |
| `helper`         | `string`  | `null`  | `null`                | Short helper text                      | No                                                                                              | Explains range, units, or consequence.                                          |
| `error`          | `string / null` | `null`  | Short error text                       | No                                     | Required when `invalid` is true.                                                |
| `invalid`        | `bool`    | `false` | `true`, `false`       | No                                     | Renders error state and associates error text.                                                  |
| `disabled`       | `bool`    | `false` | `true`, `false`       | No                                     | Prevents input.                                                                                 |
| `readonly`       | `bool`    | `false` | `true`, `false`       | No                                     | Shows the value without allowing change when read-only policy applies.                          |
| `show-input`     | `bool`    | `false` | `true`, `false`       | No                                     | Shows exact value entry for single-value slider. Required when precision matters.               |
| `show-inputs`    | `bool`    | `false` | `true`, `false`       | No                                     | Shows exact minimum and maximum value fields for range slider. Required when precision matters. |
| `show-endpoints` | `bool`    | `true`  | `true`, `false`       | No                                     | Shows minimum and maximum context.                                                              |
| `show-value`     | `bool`    | `true`  | `true`, `false`       | No                                     | Shows current value text when a full input is not displayed.                                    |
| `size`           | `string`  | `md`    | `sm`, `md`, `lg`      | No                                     | Use standard size unless the surrounding Pattern proves a denser or larger control.             |
| `class`          | `string / null` | `null`  | Layout passthrough if supported        | No                                     | Do not use for local color, track, thumb, state, width, or animation overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.7. Data attribute contract

Feature views should not set slider data attributes directly. The component may emit internal hooks for testing and behavior.

| Attribute                          | Status            | Where used          | Behavior                                           |
| ---------------------------------- | ----------------- | ------------------- | -------------------------------------------------- |
| `data-ui-component="slider"`       | Component-emitted | Slider root         | Test/implementation hook only.                     |
| `data-ui-component="range-slider"` | Component-emitted | Range slider root   | Test/implementation hook only.                     |
| `data-ui-slider-input`             | Component-emitted | Value input         | Synchronization hook. Do not set manually.         |
| `data-ui-slider-thumb`             | Component-emitted | Slider thumb/handle | Behavior hook. Do not set manually.                |
| `data-ui-slider-value`             | Component-emitted | Value output        | Display synchronization hook. Do not set manually. |
| `data-ui-slider-state`             | Component-emitted | Root or control     | State styling/testing hook only.                   |

### 4.8. Slot contract

| Slot                         | Status                 | Required | Rule                                                                            |
| ---------------------------- | ---------------------- | -------- | ------------------------------------------------------------------------------- |
| default                      | Not public             | No       | Use props for label/helper/value behavior unless source owner installs a slot.  |
| `helper`                     | Gated unless installed | No       | Must be associated to the slider with `aria-describedby`. Prefer `helper` prop. |
| `value`                      | Gated unless installed | No       | Must remain synchronized with real value. Prefer `show-value` or value input.   |
| `prefix` / `suffix`          | Gated unless installed | No       | Must preserve accessible value/unit behavior. Prefer `unit`.                    |
| arbitrary thumb/track markup | Not allowed            | No       | Slider owns track, thumb, and value synchronization.                            |

## 5. Allowed variants, options, and modifiers

| Name                       | Type           | Status               | API                         | Notes                                                                   |
| -------------------------- | -------------- | -------------------- | --------------------------- | ----------------------------------------------------------------------- |
| Single-value slider        | Variant        | Implemented standard | `x-ui.slider`               | Selects one value in a bounded numeric range.                           |
| Range slider               | Variant        | Implemented standard | `x-ui.range-slider`         | Selects minimum and maximum values in a bounded numeric range.          |
| Visible value output       | Content option | Implemented standard | `show-value`                | Shows current value as text.                                            |
| Exact value input          | Composition    | Implemented standard | `show-input`; `show-inputs` | Use when precision matters.                                             |
| Endpoint labels            | Content option | Implemented standard | `show-endpoints`            | Shows min/max range context.                                            |
| Helper text                | Content option | Implemented standard | `helper`                    | Explains range, unit, or consequence.                                   |
| Error text                 | State/content  | Implemented standard | `invalid`; `error`          | Required when invalid state is shown.                                   |
| Disabled                   | State          | Implemented standard | `disabled`                  | Prevents value changes.                                                 |
| Read-only                  | State          | Implemented standard | `readonly`                  | Shows selected value without allowing edits.                            |
| Small size                 | Size           | Implemented standard | `size="sm"`                 | Dense settings panels or compact filters.                               |
| Medium size                | Size           | Implemented standard | `size="md"`                 | Default.                                                                |
| Large size                 | Size           | Implemented standard | `size="lg"`                 | Wider focused forms where touch/pointer precision matters.              |
| Tick marks                 | Modifier       | Gated                | none                        | Requires label density, responsive, and accessibility proof before use. |
| Value tooltip/bubble       | Modifier       | Gated                | none                        | Requires pointer/focus/mobile behavior and non-hover access before use. |
| Vertical slider            | Variant        | Not approved         | none                        | No current Login App role.                                              |
| Custom track colors        | Modifier       | Not allowed          | none                        | Color roles are token/component-owned.                                  |
| Custom thumb icons         | Modifier       | Not allowed          | none                        | Requires Icons Element and component proof.                             |
| Third-party slider package | Implementation | Not allowed          | none                        | Requires architecture approval and wrapper API proof.                   |

## 6. States

| State                        | Status               | Implementation requirement                                                                                        |
| ---------------------------- | -------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Default                      | Implemented standard | Renders label, track, thumb, min/max, value display/input, helper text where provided, and submitted form value.  |
| Hover                        | Implemented standard | Token-backed hover behavior for pointer-capable devices.                                                          |
| Focus-visible                | Implemented standard | Visible focus on the active thumb and associated value input in supported themes.                                 |
| Active/dragging              | Implemented standard | Pointer dragging updates value without losing keyboard parity or accessible value output.                         |
| Keyboard increment/decrement | Implemented standard | Arrow keys change by `step`; Home/End move to min/max; optional larger step behavior must be component-owned.     |
| Disabled                     | Implemented standard | Disabled control cannot be edited and does not rely on color alone.                                               |
| Read-only                    | Implemented standard | Value is perceivable but not editable; styling is distinct from disabled.                                         |
| Required                     | Forms Pattern-owned  | Use when the owning Form standard requires submitted values.                                                      |
| Error/invalid                | Implemented standard | Error text is associated with the control and value remains visible.                                              |
| Warning                      | Pattern-owned        | Use helper text or Notification unless a form Pattern owns warning behavior.                                      |
| Success                      | Not applicable       | Slider is an input; success belongs to the form/workflow feedback.                                                |
| Loading                      | Not applicable       | Use Loading or Inline loading for pending regions.                                                                |
| Empty                        | Not applicable       | Slider always has a current value.                                                                                |
| Single-value                 | Implemented standard | One-thumb value behavior and value output/input.                                                                  |
| Range / dual-thumb           | Implemented standard | Two-thumb behavior, non-crossing values, clear focus order, and min/max value output/input.                       |
| Overflow/truncated           | Implemented standard | Labels, helper text, and value text wrap or truncate only through installed behavior with full meaning preserved. |
| Responsive                   | Implemented standard | Touch target, track width, label layout, and value input layout remain usable on narrow screens.                  |
| Reduced motion               | Implemented standard | Handle, track-fill, and value-output transitions respect reduced-motion preferences.                              |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Slider consumes Foundation Color, Spacing, Typography, Themes, Motion, Icons where installed, and 2x Grid where composed in layouts.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons only for component-owned status/mark affordances where installed.
- 2x Grid where slider fields align inside forms, filters, cards, dashboards, or settings layouts.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                  |
| ----------- | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Track, filled track, thumb, hover, focus, active/dragging, disabled, read-only, invalid, helper/error text, endpoint text, and theme contrast. |
| Spacing     | Track height, thumb size, label/value gap, endpoint labels, value input spacing, touch target, form-field stack, and responsive layout.        |
| Typography  | Label, helper text, error text, value text, endpoint labels, unit text, and validation messages.                                               |
| Themes      | Light/dark/inverse token resolution for track, thumb, value text, labels, focus, disabled, read-only, and invalid states.                      |
| Motion      | Thumb movement, filled-track transition, value output transition, and reduced-motion fallback.                                                 |
| Icons       | Only component-owned marks if installed; no local icons.                                                                                       |
| 2x Grid     | Parent placement, responsive form rows, filter panels, and settings layouts.                                                                   |

### 7.3. CSS namespace

Allowed component classes must use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-slider
.ui-slider__label
.ui-slider__field
.ui-slider__control
.ui-slider__track
.ui-slider__track-fill
.ui-slider__thumb
.ui-slider__value
.ui-slider__input
.ui-slider__range-label
.ui-slider__helper
.ui-slider__error
.ui-slider--disabled
.ui-slider--readonly
.ui-slider--invalid
.ui-slider--range
.ui-slider--sm
.ui-slider--md
.ui-slider--lg
```

Feature views must not create local `slider-*` classes, raw utility clusters, arbitrary track/thumb colors, local focus rings, third-party slider classes, or component-local JavaScript for the same UI role.

### 7.4. Helper ownership

| Helper/API          | Status               | Rule                                                                                             |
| ------------------- | -------------------- | ------------------------------------------------------------------------------------------------ |
| `x-ui.slider`       | Implemented standard | Use for one numeric value in a bounded range.                                                    |
| `x-ui.range-slider` | Implemented standard | Use for min/max values in a bounded range.                                                       |
| Number input        | Related Component    | Use instead of Slider when exact typed entry is primary. Use with Slider when precision matters. |
| Text input          | Related Component    | Use for formatted numeric-like values that require parsing/masking.                              |
| Select              | Related Component    | Use when values are a short known list.                                                          |
| Radio button        | Related Component    | Use when choices are few and should all remain visible.                                          |
| Checkbox/Toggle     | Related Component    | Use for binary settings.                                                                         |
| Forms Pattern       | Related Pattern      | Owns field grouping, validation summaries, submit behavior, and layout.                          |

## 8. Composition rules

- Use Slider only for bounded numeric ranges.
- Use single-value Slider when one value is adjusted.
- Use Range slider when minimum and maximum values are adjusted together.
- Use visible value output or value input so users do not rely only on thumb position.
- Use visible value inputs when precision matters.
- Keep min, max, step, value, and unit consistent between visual, programmatic, and submitted values.
- Keep range slider min and max values ordered.
- Keep labels, helper text, and error text close to the slider.
- Use helper text to explain units, range meaning, or consequences when they are not obvious.
- Do not use Slider for binary choices, progress, static metrics, ratings, decoration, carousel scrubbing, or timeline navigation.
- Do not use Slider when a short set of discrete choices is clearer as Radio button or Select.
- Do not use Slider when exact keyboard/text entry is the only practical interaction.
- Parent Patterns own form layout, query state, filtering, persistence, reset behavior, and workflow orchestration.
- Component owns track/thumb styling, value synchronization, state styling, accessibility semantics, keyboard behavior, pointer behavior, and internal spacing.

## 9. Selection guidance

### 9.1. Use when:

- Users need fast relative adjustment across a bounded numeric range.
- The selected value is numeric and has meaningful minimum and maximum bounds.
- The value can be adjusted in sensible increments.
- Exact entry is useful but not the only intended interaction.
- A range filter benefits from showing the relationship between lower and upper bounds.
- The UI benefits from showing the current value in context of the overall range.

### 9.2. Do not use when:

- The component is being added for visual variety.
- The value must be exact and typed entry is primary; use Number input.
- The value range is extremely small, such as 1–3; use Radio button or Select.
- The value range is extremely large without useful step grouping.
- Values are non-numeric or complex.
- Users need to compare many discrete options.
- The setting is binary; use Toggle or Checkbox.
- The workflow is a progress display; use Progress bar or Progress indicator.
- The interaction would require feature-local JavaScript, local ARIA, or local track/thumb CSS.

### 9.3. Current production choice guidance:

| Need                                     | Use                                                                                                       |
| ---------------------------------------- | --------------------------------------------------------------------------------------------------------- |
| Exact numeric value                      | Number input                                                                                              |
| Numeric value with formatting or masking | Text input with Forms Pattern validation                                                                  |
| Short known numeric choices              | Select or Radio button                                                                                    |
| On/off setting                           | Toggle or Checkbox                                                                                        |
| Minimum and maximum range                | `x-ui.range-slider` when visual adjustment is useful; two Number inputs when exact typed entry is primary |
| Query filter presets                     | Select, Checkbox group, Radio group, or Pattern-owned filter chips                                        |
| Progress display                         | Progress bar, Progress indicator, Loading, or Inline loading                                              |
| Visual scale only                        | Do not use Slider; use content or chart Pattern when installed                                            |

## 10. Accessibility contract

- Every slider must have an accessible name from a visible label.
- The current value, minimum value, maximum value, and step behavior must be programmatically available.
- Keyboard operation must work without pointer input.
- Arrow keys increment and decrement by `step`.
- Home and End move to minimum and maximum values.
- Any Page Up/Page Down or larger-step behavior must be component-owned and documented.
- Every thumb has a visible focus indicator in supported light and dark themes.
- Touch targets must remain usable on pointer and touch devices.
- Range sliders must preserve clear focus order between minimum thumb, maximum thumb, and any value inputs.
- Range thumbs must not cross unless a future API explicitly defines crossing behavior.
- Visible value text/input must stay synchronized with the actual form value.
- Helper text and error text must be programmatically associated with the control.
- Disabled behavior must not rely on color alone.
- Read-only behavior must be perceivable and distinct from disabled.
- Error state must expose associated error copy and not rely on color alone.
- Track, thumb, focus, label, and value contrast must remain usable in supported themes.
- Responsive layouts must not hide labels, values, endpoints, or focus indicators.
- Motion must not be the only indication of value change.
- Reduced-motion preferences must be respected.
- Slider use inside forms must pass Forms Pattern validation and error-placement rules.

## 11. Content contract

- Use sentence case.
- Use a short visible label, preferably three words or fewer.
- Use concrete nouns for the adjusted value, such as `Volume`, `Threshold`, `Opacity`, `Radius`, `Retention period`, or `Amount range`.
- Include units when the value is not obvious.
- Use endpoint labels or helper text to clarify minimum and maximum meaning.
- Use helper text when min, max, step, or consequence is not obvious.
- Use error text for out-of-range values or invalid range relationships.
- Keep value labels short and scannable.
- Do not use vague labels such as `Amount`, `Level`, or `Setting` when the adjusted value can be named.
- Do not use non-numeric labels on a numeric slider unless the Select/Radio pattern would be less clear and the Component API explicitly maps labels to values.
- Do not use hidden-only labels.
- Do not use endpoint labels that create ambiguity about the selected value.
- Do not use helper text to compensate for missing visible value or missing accessible behavior.

### 11.1. Recommended labels:

| Situation         | Label              | Helper/value  |
| ----------------- | ------------------ | ------------- |
| Retention setting | `Retention period` | `30 days`     |
| Alert threshold   | `Threshold`        | `50%`         |
| User limit        | `Maximum users`    | `25 users`    |
| Amount filter     | `Amount range`     | `$50 to $250` |
| Opacity setting   | `Opacity`          | `75%`         |

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not render local `<input type="range">` controls in production feature views.
- Do not install a third-party slider library for one feature.
- Do not create local track, thumb, value bubble, tick mark, or range-fill CSS.
- Do not create local ARIA slider behavior.
- Do not create local keyboard behavior for Arrow keys, Home, End, Page Up, or Page Down.
- Do not create local pointer-drag behavior.
- Do not create local dual-thumb range logic.
- Do not create local min/max validation behavior that belongs to Forms Pattern.
- Do not use Slider for binary settings, progress display, ratings, visual decoration, carousel scrubbing, or navigation.
- Do not copy Carbon, Bootstrap, browser-default, or third-party slider classes into app code.
- Do not use custom track colors, custom thumb icons, custom sizes, custom focus rings, or local animation timing.
- Do not present gated modifiers such as tick marks or value bubbles as approved until their proof exists.
- Do not render placeholder copy such as `Component-specific API pending correction`, `No production public API is approved`, or `Allowed variants: None` on the implemented UI Reference page.

## 13. Deferred or gated capabilities

No deferred capability blocks the installed Slider API. Future extensions still require an updated Component standard and UI Reference proof before production use.

| Capability                      | Status       | Gate                                                                                                                        |
| ------------------------------- | ------------ | --------------------------------------------------------------------------------------------------------------------------- |
| Tick marks and discrete labels  | Gated        | Requires label density rules, responsive behavior, contrast proof, keyboard behavior, and UI Reference proof.               |
| Value tooltip/bubble            | Gated        | Requires visible/focus behavior, mobile/touch behavior, collision handling, reduced-motion proof, and non-hover access.     |
| Vertical slider                 | Not approved | No current Login App need; requires a separate API and accessibility review.                                                |
| Non-numeric labelled scale      | Gated        | Requires explicit value mapping, content rules, screen-reader behavior, and selection guidance against Select/Radio button. |
| Custom step multiplier behavior | Gated        | Requires keyboard contract and accessibility proof.                                                                         |
| Client-side public event API    | Gated        | Requires documented initializer/events/cleanup/value-change policy and tests.                                               |
| Third-party slider package      | Not allowed  | Requires architecture approval and wrapper Component API proof before use.                                                  |
| Custom visual themes            | Not allowed  | Requires Color, Themes, Motion, and accessibility updates.                                                                  |

## 14. UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Slider page is a broad input component reference page. It should use matrices, comparison grids, state tables, grouped examples, responsive examples, accessibility examples, and developer implementation examples. It must render production Slider examples through the installed API.

### 14.1. Required Live examples internal sections:

| Required proof                | Rendered behavior                                                                                                          | Variants/options shown                                                       |
| ----------------------------- | -------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------- |
| Basic single-value slider     | A labeled slider renders one bounded numeric value with min/max, step, visible value, and helper text.                     | `x-ui.slider`, min, max, step, value, helper                                 |
| Range slider                  | A min/max slider renders two ordered values and synchronized lower/upper value display or inputs.                          | `x-ui.range-slider`, `value-min`, `value-max`, show inputs                   |
| Exact-entry pairing           | Slider renders with visible Number input/value entry where precision matters.                                              | `show-input`, `show-inputs`, unit                                            |
| Variant comparison            | Single-value and range variants render side by side with selection guidance.                                               | Single-value, Range                                                          |
| Size comparison               | Installed sizes render with representative content.                                                                        | `sm`, `md`, `lg`                                                             |
| State matrix                  | States render with token-backed classes and accessibility markers.                                                         | Default, Hover, Focus-visible, Active/dragging, Disabled, Read-only, Invalid |
| Keyboard and pointer behavior | Examples document keyboard increment/decrement, Home/End, pointer dragging, and value synchronization.                     | Keyboard, Pointer, Step                                                      |
| Error and helper behavior     | Invalid value/range examples show associated error text and helper text.                                                   | Error, Helper, `aria-describedby`                                            |
| Responsive behavior           | Narrow-container examples preserve label, endpoints, values, and usable thumb/track targets.                               | Responsive, Touch target, Wrapping                                           |
| Reduced-motion behavior       | Motion-bearing examples document reduced-motion handling.                                                                  | Motion, Reduced motion                                                       |
| Selection boundary            | The page compares Slider with Number input, Select, Radio button, Toggle, Checkbox, and Progress bar.                      | Related alternatives                                                         |
| Developer implementation      | Canonical calls and props render as token-backed code snippets.                                                            | `x-ui.slider`, `x-ui.range-slider`, props, classes                           |
| Gated capability proof        | Tick marks, value bubbles, and vertical sliders appear only as gated rows, not approved examples.                          | Gated tick marks, value bubble, vertical slider                              |
| Prohibited usage proof        | The page calls out local range inputs, third-party packages, local ARIA, and local CSS without rendering them as approved. | No local `<input type="range">`, no third-party classes                      |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered variants, states, options, prohibited usage, deferred/gated extensions, accessibility behavior, selection boundaries, and consumed Foundation Elements.

## 15. Testing and acceptance criteria

- `/platform/ui-reference/components/slider` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, gated capabilities, and Foundation Elements consumed.
- Implemented APIs render production examples.
- Gated APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The page renders `x-ui.slider` and `x-ui.range-slider` examples.
- The single-value slider example shows label, min, max, step, value, helper, and visible value behavior.
- The range slider example shows minimum and maximum values, ordered values, and value-input synchronization.
- The state matrix renders default, hover, focus-visible, active/dragging, disabled, read-only, and invalid examples.
- The accessibility examples document accessible name, value, min/max, keyboard, pointer, screen-reader, contrast, touch target, and reduced-motion behavior.
- The selection guidance distinguishes Slider from Number input, Text input, Select, Radio button, Toggle, Checkbox, and Progress bar.
- Developer examples use `x-ui.slider` and `x-ui.range-slider`, not placeholder comments or local range inputs.
- No generic placeholder content appears.
- No direct Carbon classes, Bootstrap classes, third-party slider classes, raw utility clusters, hard-coded colors, local focus rings, local ARIA, local drag logic, or custom JavaScript are presented as approved implementation.

### 15.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/slider');

$response->assertOk();
$response->assertSee('Slider');
$response->assertSee('x-ui.slider');
$response->assertSee('x-ui.range-slider');
$response->assertSee('Single-value slider');
$response->assertSee('Range slider');
$response->assertSee('show-input');
$response->assertSee('show-inputs');
$response->assertSee('value-min');
$response->assertSee('value-max');
$response->assertSee('Focus-visible');
$response->assertSee('Active/dragging');
$response->assertSee('Read-only');
$response->assertSee('Invalid');
$response->assertSee('keyboard');
$response->assertSee('pointer');
$response->assertSee('screen-reader');
$response->assertSee('reduced-motion');
$response->assertSee('Number input');
$response->assertSee('Select');
$response->assertSee('Radio button');
$response->assertSee('Toggle');
$response->assertDontSee('Slider remains deferred');
$response->assertDontSee('No production public API is approved');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Allowed variants: None');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('TODO');
$response->assertDontSee('Generic fallback');
$response->assertDontSee('class="form-range');
$response->assertDontSee('data-ui-slider="local"');
```

For implementation tests, add page-specific assertions that rendered examples use the installed Blade APIs and app-owned slider classes rather than only text labels or simulated local range controls.

## 16. Related APIs

| API                  | Route                                                            |
| -------------------- | ---------------------------------------------------------------- |
| Number input         | `/platform/ui-reference/components/number-input`                 |
| Text input           | `/platform/ui-reference/components/text-input`                   |
| Select               | `/platform/ui-reference/components/select`                       |
| Radio button         | `/platform/ui-reference/components/radio-button`                 |
| Checkbox             | `/platform/ui-reference/components/checkbox`                     |
| Toggle               | `/platform/ui-reference/components/toggle`                       |
| Form field planned gap | `components/form-field` is not routed; use `/platform/ui-reference/patterns/forms` until an owner is approved |
| Progress bar         | `/platform/ui-reference/components/progress-bar`                 |
| Progress indicator   | `/platform/ui-reference/components/progress-indicator`           |
| Forms pattern        | `/platform/ui-reference/patterns/forms`                          |
| Navigation Pattern   | `/platform/ui-reference/patterns/navigation`                     |
| Settings surface     | `/platform/ui-reference/patterns/forms`; layout-owned settings surfaces use `/platform/ui-reference/patterns/layout` |
| Color element        | `/platform/ui-reference/elements/color`                          |
| Spacing element      | `/platform/ui-reference/elements/spacing`                        |
| Typography element   | `/platform/ui-reference/elements/typography`                     |
| Themes element       | `/platform/ui-reference/elements/themes`                         |
| Motion element       | `/platform/ui-reference/elements/motion`                         |
| Icons element        | `/platform/ui-reference/elements/icons`                          |
| Components overview  | `/platform/ui-reference/components`                              |
| Canonical slider doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fslider.md` |
| Carbon slider usage  | `https://carbondesignsystem.com/components/slider/usage/`        |

## 17. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Slider usage, style, and accessibility guidance inform Slider scope, default/range variants, visible value display, number input pairing, min/max/step expectations, keyboard considerations, and label rules. Login App keeps its own Blade API, app-owned `ui-*` class namespace, Foundation Element token model, route ownership, and UI Reference proof requirements.
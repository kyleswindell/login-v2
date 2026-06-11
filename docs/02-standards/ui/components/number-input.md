---
title: Number input
slug: number-input
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: inputs
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/number-input
canonical_doc: docs/02-standards/ui/components/number-input.md
source_owner: /platform/ui-reference/components/number-input
blade_api: []
javascript_api: []
data_attributes: []
source_files:
  - resources/css/app.css
  - resources/views/platform/ui-reference/components/number-input.blade.php
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
related_components:
  - text-input
  - select
  - button
  - inline-loading
  - loading
  - notification
  - slider
related_patterns:
  - forms
  - tables
carbon_reference:
  - https://carbondesignsystem.com/components/number-input/usage/
  - https://carbondesignsystem.com/components/number-input/style/
  - https://carbondesignsystem.com/components/number-input/accessibility/
---

# Number input Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed production rules:](#31-installed-production-rules)
  - [3.2. Installed modes:](#32-installed-modes)
- [4. Public API](#4-public-api)
  - [4.1. API status](#41-api-status)
  - [4.2. Canonical default number input](#42-canonical-default-number-input)
  - [4.3. Decimal number input](#43-decimal-number-input)
  - [4.4. Error state](#44-error-state)
  - [4.5. Warning state](#45-warning-state)
  - [4.6. Disabled and read-only states](#46-disabled-and-read-only-states)
  - [4.7. Native attribute contract](#47-native-attribute-contract)
  - [4.8. Class contract](#48-class-contract)
  - [4.9. Reserved future Blade contract](#49-reserved-future-blade-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper usage](#74-helper-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use Number input when:](#91-use-number-input-when)
  - [9.2. Do not use Number input when:](#92-do-not-use-number-input-when)
  - [9.3. Field selection:](#93-field-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
  - [15.1. Required Live examples internal sections:](#151-required-live-examples-internal-sections)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Number input captures bounded numeric values with native numeric entry, validation states, helper text, and optional native step behavior.

Canonical API owner: `/platform/ui-reference/components/number-input`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Number input is the installed Login App 2.0 numeric field API for values such as counts, limits, quantities, ordering weights, percentages, and other small-range numeric settings. It owns numeric field semantics, min/max/step constraints, label/helper/error/warning structure, disabled and read-only states, validation icon treatment, field density, token-backed focus/hover/validation states, and native keyboard increment/decrement behavior. It does not own form layout, validation orchestration, server-side rules, sliders, currency formatting, unit conversion, range selection, table filtering composition, or custom JavaScript steppers.

### 1.1. Canonical API responsibilities:

- Render numeric fields with native `<input type="number">` semantics and app-owned `ui-number-input*` classes.
- Preserve labels, helper text, validation messages, and accessible descriptions.
- Express bounded values with native `min`, `max`, and `step` attributes when limits are known.
- Keep range and step constraints visible in helper text before the user submits.
- Preserve keyboard support for direct text entry, Tab focus, and native Up/Down arrow increment/decrement behavior.
- Preserve focus-visible, hover-capable, disabled, read-only, error, and warning states.
- Use app-owned validation icons where error or warning states are shown.
- Keep custom increment/decrement button controls gated until a documented JavaScript/controller contract exists.
- Consume Foundation Element APIs for color, spacing, typography, themes, and icons.
- Prove constraints, states, sizing/density, validation, accessibility, and implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Form grouping, field rows, action bars, validation-summary placement, and external spacing. Use the Forms Pattern.
- Server-side validation rules, authorization, persistence, and numeric normalization.
- Large-range numeric adjustment. Use Slider when that API is installed and the value is selected across a wide range.
- Free-form numeric text such as currency, distance, dimensions, phone numbers, postal codes, ID numbers, SKUs, or values requiring custom formatting. Use Text input or a dedicated formatted field API.
- Determinate progress or percent-complete display. Use Progress indicator when installed.
- Loading skeletons. Use Loading if the field value itself has not loaded.
- Inline submit/save pending behavior. Use Button or Inline loading.
- Custom visible plus/minus segmented controls. Gate through this Component standard before production use.

Carbon alignment note: Carbon treats number input as a numeric field with add/subtract controls for small adjustments, recommends helper text for min/max/step constraints, distinguishes default and fluid styles, documents small/medium/large sizes, and requires error/warning messages and icons to be conveyed programmatically. Login App maps those principles to native number input semantics, app-owned `ui-*` classes, server-validation handoff, and UI Reference proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                              |
| ---------------------------- | -------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                       |
| System maturity              | Partial                                                                                            |
| API layer                    | Component API                                                                                      |
| Component slug               | number-input                                                                                       |
| Category                     | Inputs                                                                                             |
| Priority                     | Tier B - Common reusable component                                                                 |
| UI Reference route           | `/platform/ui-reference/components/number-input`                                                   |
| Canonical doc                | `docs/02-standards/ui/components/number-input.md`                                                  |
| Source owner                 | `/platform/ui-reference/components/number-input`                                                   |
| Blade API                    | No dedicated public Blade wrapper is approved yet                                                  |
| JavaScript API               | None approved for baseline number input behavior                                                   |
| Data attributes              | None approved                                                                                      |
| Props/options                | No Blade props; options are represented by native attributes and documented classes                |
| Source files                 | `resources/css/app.css`; `resources/views/platform/ui-reference/components/number-input.blade.php` |
| CSS namespace                | App-owned `ui-number-input*` and shared `ui-field*` classes                                        |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons                                                          |
| Carbon benchmark             | Carbon Number input usage, style, and accessibility guidance                                       |

`Approved API` means the numeric field treatment and UI Reference route exist, but the canonical documentation, rendered examples, and regression tests must be corrected to replace placeholder guidance with the installed class-and-native-input API.

## 3. Installed standard

The installed standard is a native-input and class-based Component API.

Use Number input when the user needs to enter a numeric value and the value can be represented as a number, validated as a number, and optionally constrained with `min`, `max`, and `step`.

### 3.1. Installed production rules:

- Use a native `<input type="number">` for numeric values.
- Wrap the input in the app-owned field structure with `ui-field` and `ui-number-input` classes.
- Use an explicit visible `<label>` associated with the input by `for` and `id`.
- Use `name` for form submission.
- Use `value` or Laravel `old()` repopulation where the field has an existing value or safe default.
- Use `min`, `max`, and `step` when the accepted value is bounded or incremental.
- Describe non-obvious min/max/step limits in helper text before the user submits.
- Use `inputmode="numeric"` for whole numbers and `inputmode="decimal"` for decimal values when helpful on mobile keyboards.
- Use `aria-describedby` to associate helper, error, and warning text.
- Use `aria-invalid="true"` only for invalid/error states.
- Use `disabled` when the user cannot interact with or submit the field value.
- Use `readonly` when the user can review the value but cannot edit it.
- Use app-owned error and warning classes and icons for validation states.
- Use server-side validation as the source of truth.
- Use native browser/keyboard step behavior for increment/decrement. Do not create custom plus/minus controls without an approved JavaScript/data-attribute API.
- Parent Patterns own grouping, external spacing, responsive layout, and workflow orchestration.
- Do not use raw utility clusters, Bootstrap form classes, direct Carbon classes, hard-coded colors, arbitrary spacing, local icons, or feature-local JavaScript to create number inputs.

### 3.2. Installed modes:

| Mode                                 | Status                                    | Use                                                                                                             |
| ------------------------------------ | ----------------------------------------- | --------------------------------------------------------------------------------------------------------------- |
| Default number input                 | Implemented                               | Standard numeric field with label above field and helper/validation text below.                                 |
| Bounded number input                 | Implemented                               | Numeric field with `min`, `max`, and helper text that explains the accepted range.                              |
| Stepped number input                 | Implemented through native input behavior | Numeric field with `step` and native keyboard/browser increment behavior.                                       |
| Compact number input                 | Implemented / required proof              | Dense field for complex forms, tables, and constrained layouts.                                                 |
| Fluid number input                   | Approved API / required proof             | Larger contained field treatment when the UI Reference confirms the installed class behavior.                   |
| Error number input                   | Implemented                               | Invalid field with error icon, error text, and `aria-invalid="true"`.                                           |
| Warning number input                 | Implemented                               | Exception/attention state with warning icon and warning text; not necessarily invalid.                          |
| Disabled number input                | Implemented                               | Native disabled field unavailable to users and omitted from submission.                                         |
| Read-only number input               | Implemented                               | Native read-only field visible to users and still submitted with the form.                                      |
| Loading/skeleton number input        | Not owned by Number input                 | Use Loading when a numeric field value has not loaded.                                                          |
| Custom plus/minus segmented controls | Gated                                     | Requires documented source implementation, JavaScript behavior, accessibility proof, and UI Reference examples. |

## 4. Public API

### 4.1. API status

The current public API is native HTML plus app-owned CSS classes. A dedicated Blade component such as `x-ui.number-input` is reserved for a future correction pass and must not be used in production until installed, documented, rendered in UI Reference, and tested.

| API surface           | Installed value                                                                                    |
| --------------------- | -------------------------------------------------------------------------------------------------- |
| Blade                 | No dedicated public Blade wrapper approved yet                                                     |
| JavaScript            | No dedicated JavaScript controller required                                                        |
| Data attributes       | None approved                                                                                      |
| Props/options         | No Blade props; use native input attributes and documented classes                                 |
| Root semantic element | Native `<input type="number">` inside an app-owned field wrapper                                   |
| CSS namespace         | `ui-field*` and `ui-number-input*`                                                                 |
| Source files          | `resources/css/app.css`; `resources/views/platform/ui-reference/components/number-input.blade.php` |

Feature views may use canonical number-input markup directly when a Pattern has not wrapped it. Do not create local field partials, custom steppers, or helper classes. If the same numeric field composition is repeated across features, move it into the owning Pattern or install a public Blade wrapper through the gate in this standard.

### 4.2. Canonical default number input

```blade
<div class="ui-field ui-number-input ui-number-input--md">
    <label class="ui-field__label" for="seat-limit">Seat limit</label>

    <input
        class="ui-number-input__input"
        id="seat-limit"
        name="seat_limit"
        type="number"
        inputmode="numeric"
        min="1"
        max="250"
        step="1"
        value="{{ old('seat_limit', $tenant->seat_limit ?? 25) }}"
        aria-describedby="seat-limit-helper"
    >

    <p class="ui-field__helper" id="seat-limit-helper">
        Enter a whole number from 1 to 250.
    </p>
</div>
```

Use a specific label and helper text. The helper text should explain the accepted range and step when those constraints are not obvious.

### 4.3. Decimal number input

```blade
<div class="ui-field ui-number-input ui-number-input--md">
    <label class="ui-field__label" for="discount-rate">Discount rate</label>

    <input
        class="ui-number-input__input"
        id="discount-rate"
        name="discount_rate"
        type="number"
        inputmode="decimal"
        min="0"
        max="100"
        step="0.25"
        value="{{ old('discount_rate', '0') }}"
        aria-describedby="discount-rate-helper"
    >

    <p class="ui-field__helper" id="discount-rate-helper">
        Enter a percentage from 0 to 100 in 0.25 increments.
    </p>
</div>
```

Use `inputmode="decimal"` only when decimal entry is valid. Keep decimal precision rules aligned with server validation.

### 4.4. Error state

```blade
<div class="ui-field ui-field--error ui-number-input ui-number-input--md">
    <label class="ui-field__label" for="retry-count">Retry count</label>

    <div class="ui-number-input__control">
        <input
            class="ui-number-input__input"
            id="retry-count"
            name="retry_count"
            type="number"
            inputmode="numeric"
            min="0"
            max="10"
            step="1"
            value="{{ old('retry_count') }}"
            aria-invalid="true"
            aria-describedby="retry-count-error"
        >
        <span class="ui-number-input__status-icon ui-number-input__status-icon--error" aria-hidden="true"></span>
    </div>

    <p class="ui-field__message ui-field__message--error" id="retry-count-error">
        Enter a whole number from 0 to 10.
    </p>
</div>
```

Error text replaces helper text when the field is invalid. Include the recovery instruction in the message.

### 4.5. Warning state

```blade
<div class="ui-field ui-field--warning ui-number-input ui-number-input--md">
    <label class="ui-field__label" for="session-timeout">Session timeout</label>

    <div class="ui-number-input__control">
        <input
            class="ui-number-input__input"
            id="session-timeout"
            name="session_timeout"
            type="number"
            inputmode="numeric"
            min="5"
            max="240"
            step="5"
            value="{{ old('session_timeout', 15) }}"
            aria-describedby="session-timeout-warning"
        >
        <span class="ui-number-input__status-icon ui-number-input__status-icon--warning" aria-hidden="true"></span>
    </div>

    <p class="ui-field__message ui-field__message--warning" id="session-timeout-warning">
        Short timeouts may interrupt active users.
    </p>
</div>
```

Warning is not the same as invalid. Do not set `aria-invalid="true"` unless the value cannot be submitted.

### 4.6. Disabled and read-only states

```blade
<div class="ui-field ui-number-input ui-number-input--md">
    <label class="ui-field__label" for="archived-score">Archived score</label>

    <input
        class="ui-number-input__input"
        id="archived-score"
        name="archived_score"
        type="number"
        value="42"
        disabled
    >
</div>
```

```blade
<div class="ui-field ui-number-input ui-number-input--md ui-number-input--readonly">
    <label class="ui-field__label" for="account-count">Account count</label>

    <input
        class="ui-number-input__input"
        id="account-count"
        name="account_count"
        type="number"
        value="42"
        readonly
        aria-describedby="account-count-helper"
    >

    <p class="ui-field__helper" id="account-count-helper">
        This value is calculated automatically.
    </p>
</div>
```

Use disabled when the value should not be submitted or read as an available field. Use read-only when the value should remain visible, readable, and submitted but not editable.

### 4.7. Native attribute contract

| Attribute             | Type                | Status                           | Required                                       | Rule                                                         |
| --------------------- | ------------------- | -------------------------------- | ---------------------------------------------- | ------------------------------------------------------------ |
| `type="number"`       | Native HTML         | Implemented                      | Yes                                            | Required for this Component API.                             |
| `id`                  | Native HTML         | Implemented                      | Yes                                            | Required to connect the label.                               |
| `name`                | Native HTML         | Implemented                      | Yes for submitted forms                        | Required for Laravel form submission.                        |
| `value`               | Native HTML/Laravel | Implemented                      | Contextual                                     | Use existing value, safe default, or `old()` repopulation.   |
| `min`                 | Native HTML         | Implemented                      | When bounded                                   | Match server validation.                                     |
| `max`                 | Native HTML         | Implemented                      | When bounded                                   | Match server validation.                                     |
| `step`                | Native HTML         | Implemented                      | When incremental                               | Match server validation and helper text.                     |
| `required`            | Native HTML         | Implemented                      | When required                                  | Pair with visible required convention and server validation. |
| `disabled`            | Native HTML         | Implemented                      | No                                             | Field is unavailable, not focusable, and not submitted.      |
| `readonly`            | Native HTML         | Implemented                      | No                                             | Field is readable and submitted but not editable.            |
| `inputmode="numeric"` | Native HTML         | Implemented                      | Contextual                                     | Use for whole-number mobile keyboard hints.                  |
| `inputmode="decimal"` | Native HTML         | Implemented                      | Contextual                                     | Use for decimal mobile keyboard hints.                       |
| `aria-describedby`    | ARIA                | Implemented                      | Required when helper/error/warning text exists | Reference helper and validation message IDs.                 |
| `aria-invalid="true"` | ARIA                | Implemented                      | Required for invalid/error state               | Do not use for warnings that can be submitted.               |
| `placeholder`         | Native HTML         | Allowed with restrictions        | No                                             | Never use as the only label or only instruction.             |
| `pattern`             | Native HTML         | Not reliable for `type="number"` | No                                             | Use server validation and helper text instead.               |

### 4.8. Class contract

| Class                                   | Type                    | Status                                    | Purpose                                                                         |
| --------------------------------------- | ----------------------- | ----------------------------------------- | ------------------------------------------------------------------------------- |
| `ui-field`                              | Shared field root       | Implemented                               | Common field wrapper used by input components.                                  |
| `ui-field__label`                       | Shared field element    | Implemented                               | Visible label.                                                                  |
| `ui-field__helper`                      | Shared field element    | Implemented                               | Helper text below the field.                                                    |
| `ui-field__message`                     | Shared field element    | Implemented                               | Validation or status message below the field.                                   |
| `ui-field__message--error`              | Shared field state      | Implemented                               | Error message text.                                                             |
| `ui-field__message--warning`            | Shared field state      | Implemented                               | Warning message text.                                                           |
| `ui-field--error`                       | Shared field state      | Implemented                               | Error state wrapper.                                                            |
| `ui-field--warning`                     | Shared field state      | Implemented                               | Warning state wrapper.                                                          |
| `ui-number-input`                       | Component root          | Implemented                               | Number input component wrapper.                                                 |
| `ui-number-input__control`              | Component element       | Implemented                               | Optional control wrapper used when status icons or future controls are present. |
| `ui-number-input__input`                | Component element       | Implemented                               | Native number input field.                                                      |
| `ui-number-input__status-icon`          | Component element       | Implemented                               | App-owned validation icon position.                                             |
| `ui-number-input__status-icon--error`   | Component state element | Implemented                               | Error icon treatment.                                                           |
| `ui-number-input__status-icon--warning` | Component state element | Implemented                               | Warning icon treatment.                                                         |
| `ui-number-input--sm`                   | Size                    | Implemented / required proof              | Compact productive field.                                                       |
| `ui-number-input--md`                   | Size                    | Implemented / required proof              | Default field size.                                                             |
| `ui-number-input--lg`                   | Size                    | Implemented / required proof              | Larger field size for simple forms or standalone fields.                        |
| `ui-number-input--compact`              | Density modifier        | Implemented / required proof              | Dense layout alias if implemented by the CSS API.                               |
| `ui-number-input--fluid`                | Style modifier          | Approved API / required proof             | Fluid/contained style if rendered by the UI Reference page.                     |
| `ui-number-input--readonly`             | State modifier          | Implemented                               | Read-only visual state.                                                         |
| `ui-number-input--disabled`             | State modifier          | Optional class, native attribute required | Visual hook only when native `disabled` is present.                             |

Feature views must not create additional `ui-number-input-*`, `number-input-*`, `input-number-*`, or local field classes. New classes require source implementation, this standard update, UI Reference proof, and tests.

### 4.9. Reserved future Blade contract

The following names are reserved for a future correction pass. They are not production APIs today.

| Reserved API              | Current status | Gate                                                                                                                                                     |
| ------------------------- | -------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `x-ui.number-input`       | Deferred       | Requires source file, props, slots, native attribute passthrough, validation contract, UI Reference examples, and tests.                                 |
| `x-ui.number-stepper`     | Gated          | Requires custom increment/decrement controls, JavaScript or form-safe behavior, keyboard support, accessible names, min/max/step enforcement, and tests. |
| `x-ui.number-input-group` | Deferred       | Requires unit prefix/suffix or paired numeric fields, labeling rules, responsive behavior, and Forms Pattern approval.                                   |

Do not create feature-local Blade components with these names.

## 5. Allowed variants, options, and modifiers

| Name                                       | Type               | Status                       | API                                                          | Notes                                                                                      |
| ------------------------------------------ | ------------------ | ---------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------------------------------------ |
| Default                                    | Style              | Implemented                  | `ui-number-input`                                            | Label outside/above the numeric field.                                                     |
| Fluid                                      | Style              | Approved API                 | `ui-number-input--fluid`                                     | Larger contained treatment; use only where UI Reference proves installed behavior.         |
| Small                                      | Size               | Implemented / required proof | `ui-number-input--sm`                                        | Long, dense, or constrained forms.                                                         |
| Medium                                     | Size               | Implemented / required proof | `ui-number-input--md`                                        | Default productive size.                                                                   |
| Large                                      | Size               | Implemented / required proof | `ui-number-input--lg`                                        | Simple forms or standalone numeric fields.                                                 |
| Compact                                    | Density            | Implemented / required proof | `ui-number-input--compact`                                   | Dense table/filter/form contexts.                                                          |
| Min/max                                    | Constraint         | Implemented                  | `min`, `max`                                                 | Must match server validation and helper text.                                              |
| Step                                       | Constraint         | Implemented                  | `step`                                                       | Must match server validation and helper text.                                              |
| Native increment/decrement                 | Behavior           | Implemented                  | Native number input keyboard/browser controls                | Up/Down arrows and browser spinbutton where available.                                     |
| Custom visible increment/decrement buttons | Behavior           | Gated                        | None                                                         | Requires approved controller, data attributes, labels, disabled limit behavior, and tests. |
| Helper text                                | Content            | Implemented                  | `ui-field__helper` and `aria-describedby`                    | Explain range, step, format, or impact.                                                    |
| Error                                      | Validation state   | Implemented                  | `ui-field--error`, `aria-invalid="true"`, error message/icon | Invalid value blocks submission.                                                           |
| Warning                                    | Advisory state     | Implemented                  | `ui-field--warning`, warning message/icon                    | Value may submit but needs attention.                                                      |
| Disabled                                   | State              | Implemented                  | `disabled`                                                   | Not focusable and not submitted.                                                           |
| Read-only                                  | State              | Implemented                  | `readonly`                                                   | Focus/read behavior remains available depending on browser; value is submitted.            |
| Required                                   | Constraint         | Implemented                  | `required` plus visible convention                           | Must align with Forms Pattern required/optional convention.                                |
| Placeholder                                | Modifier           | Allowed with restrictions    | `placeholder`                                                | Support only; never replace label/helper text.                                             |
| Prefix/suffix unit                         | Composition        | Gated                        | None                                                         | Use helper/label text today; install a field adornment API before production.              |
| Currency formatting                        | Composition/format | Not owned                    | Text input or future formatted-number API                    | `type="number"` is not appropriate for currency strings.                                   |
| Loading/skeleton                           | State              | Not owned                    | Loading Component                                            | Use when field data is pending.                                                            |
| AI presence                                | Modifier           | Gated                        | None                                                         | Requires AI label/explainability contract before production use.                           |

## 6. States

| State               | Status                              | Implementation requirement                                                                                           |
| ------------------- | ----------------------------------- | -------------------------------------------------------------------------------------------------------------------- |
| Default             | Implemented                         | Renders visible label, native number input, optional helper text, and approved size/style classes.                   |
| Hover-capable       | Implemented                         | Token-backed hover treatment on the field/control when pointer hover is available.                                   |
| Focus-visible       | Implemented                         | Token-backed focus treatment visible in all supported themes.                                                        |
| Active/incrementing | Implemented through native behavior | Native typing, browser step controls, or Up/Down arrows change the value according to `step`.                        |
| Disabled            | Implemented                         | Uses native `disabled`; not focusable; not submitted; should not be used for values users must read or copy.         |
| Read-only           | Implemented                         | Uses native `readonly`; value remains visible and submitted but cannot be modified.                                  |
| Helper              | Implemented                         | Helper text is associated with the input using `aria-describedby`.                                                   |
| Error               | Implemented                         | Error state uses `aria-invalid="true"`, error text, error icon, and token-backed error styling.                      |
| Warning             | Implemented                         | Warning state uses warning text/icon without `aria-invalid` unless submission is blocked.                            |
| Required            | Implemented                         | Uses native `required`, visible required convention, and server validation.                                          |
| Optional            | Implemented through Forms Pattern   | Optional convention is owned by Forms Pattern; field must remain clearly labeled.                                    |
| Empty               | Implemented with restrictions       | Allowed for optional nullable values. Required bounded values should use a safe default when known.                  |
| Overflow/truncated  | Implemented through content rules   | Labels, values, helper text, and validation text must wrap or remain readable; do not truncate critical constraints. |
| Loading             | Not owned by Number input           | Use Loading skeleton or parent Pattern when the value is pending.                                                    |
| Success             | Not applicable                      | Successful save/submit belongs to Notification, Forms Pattern, or page status.                                       |
| Informational       | Not applicable as state             | Use helper text or Notification/Pattern-owned info messaging.                                                        |
| Selected/unselected | Not applicable                      | Number input is not a selection control.                                                                             |
| Expanded/collapsed  | Not applicable                      | Number input does not own disclosure.                                                                                |
| Open/closed         | Not applicable                      | Number input does not own popover/menu behavior.                                                                     |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Number input consumes Foundation Color, Spacing, Typography, Themes, and Icons.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Icons.

Motion and 2x Grid are not public Number input API dependencies. Parent Patterns may use 2x Grid to place fields. Any focus/hover transitions must come from the shared field implementation and Foundation tokens rather than feature-local animation.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                           |
| ----------- | ----------------------------------------------------------------------------------------------------------------------- |
| Color       | Field background, text, label, helper text, border, focus, hover, disabled, read-only, error, warning, and icon states. |
| Spacing     | Label gap, input padding, helper/message gap, status icon position, compact/default/fluid internal spacing.             |
| Typography  | Label, numeric value, helper text, error/warning text, and compact/fluid field text roles.                              |
| Themes      | Light, dark, and inverse token resolution for every field and validation state.                                         |
| Icons       | App-owned error and warning icons; no local icon sources.                                                               |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation.

```css
.ui-field
.ui-field__label
.ui-field__helper
.ui-field__message
.ui-field__message--error
.ui-field__message--warning
.ui-field--error
.ui-field--warning
.ui-number-input
.ui-number-input__control
.ui-number-input__input
.ui-number-input__status-icon
.ui-number-input__status-icon--error
.ui-number-input__status-icon--warning
.ui-number-input--sm
.ui-number-input--md
.ui-number-input--lg
.ui-number-input--compact
.ui-number-input--fluid
.ui-number-input--readonly
.ui-number-input--disabled
```

Feature views must not create `form-control`, `form-group`, `input-group`, `number-input-*`, `numeric-field-*`, raw utility clusters, arbitrary width/height values, hard-coded validation colors, local focus rings, local icons, direct Carbon classes, Bootstrap field classes, or custom stepper classes for the same UI role.

### 7.4. Helper usage

| Helper/mechanism               | Status                                  | Rule                                                                                      |
| ------------------------------ | --------------------------------------- | ----------------------------------------------------------------------------------------- |
| Laravel `old()`                | Approved                                | Use to repopulate submitted values after validation failure.                              |
| Laravel error bags             | Approved                                | Use as the source for error-state rendering and error copy.                               |
| Server-side validation         | Required                                | Must match native `min`, `max`, `step`, `required`, integer/decimal, and precision rules. |
| Native browser validation      | Supportive only                         | Do not rely on browser validation as the source of truth.                                 |
| `aria-describedby`             | Required with helper/error/warning text | Reference all active descriptive text IDs.                                                |
| `aria-invalid`                 | Required for invalid state              | Use only when the value is invalid.                                                       |
| Native arrow-key stepping      | Approved                                | Use with `step`; ensure helper text explains non-default increments.                      |
| Custom JavaScript stepper      | Not approved                            | Requires future documented JavaScript and data-attribute API.                             |
| Client-side numeric formatting | Not approved as Number input API        | Use a dedicated formatted input standard before production.                               |

## 8. Composition rules

- Use Number input only for values that are truly numeric and can be validated as numbers.
- Use Text input for numeric-looking strings that are not mathematical numbers, such as phone numbers, postal codes, account numbers, SKUs, and IDs.
- Use Text input or a future formatted-number API for currency, dimensions with units, thousands separators, or values that require localized formatting.
- Use Slider when users need to adjust across a wide range and precision is less important than relative position.
- Always provide a visible label.
- Use helper text when the value has a range, step, unit, business rule, or consequence that is not obvious from the label.
- Keep native constraints and server validation aligned.
- Explain `min`, `max`, and unusual `step` values before the user submits.
- Prefer safe defaults for required bounded values when a likely default exists.
- Allow blank values only when the server accepts nullable input and the field is clearly optional.
- Use `inputmode="numeric"` for whole numbers and `inputmode="decimal"` for decimals when mobile keyboard hints help.
- Use `readonly` instead of `disabled` when the user must still read, copy, or submit the value.
- Keep validation icons decorative with `aria-hidden="true"`; the helper/error/warning text must provide the meaning.
- Do not use separate local text, badges, or icons to communicate validation outside the installed field state.
- Do not build custom plus/minus controls without the gated stepper API.
- Parent Patterns own field grouping, responsive layout, external spacing, section headings, validation summaries, and submit actions.
- Components own internal field semantics, styling, status icons, helper/error/warning associations, and token-backed states.

## 9. Selection guidance

### 9.1. Use Number input when:

- A user needs to enter or adjust a numeric value.
- The accepted value can be bounded by `min`, `max`, or `step`.
- The range is small enough that native increment/decrement behavior is useful.
- The value is a count, limit, order, threshold, percentage, duration, quantity, or similar numeric setting.
- The server will store and validate the submitted value as a number.

### 9.2. Do not use Number input when:

- The value is a phone number, ZIP/postal code, account number, product code, ID, or any numeric-looking string.
- The value needs currency symbols, unit suffixes, thousands separators, masking, localization, or free-form formatting.
- The user needs to choose from a small fixed set of values; use Select, Radio button, Segmented control, or another appropriate Component when installed.
- The user needs to adjust over a broad range; use Slider when installed.
- The field is read-only calculated output and not part of a form; use Text, Description list, Stat, or another data-display Pattern.
- The input is only being used because it displays a numeric keyboard; use Text input with `inputmode` when the value is not a number.
- A custom plus/minus segmented stepper is required; gate the behavior before production.

### 9.3. Field selection:

| Need                                | Use                                                                              |
| ----------------------------------- | -------------------------------------------------------------------------------- |
| Small-range count or limit          | Number input with `min`, `max`, and `step="1"`                                   |
| Decimal percentage or threshold     | Number input with `inputmode="decimal"` and decimal `step`                       |
| Numeric-looking identifier          | Text input                                                                       |
| Currency amount                     | Text input or future currency/number-format API                                  |
| Wide-range relative adjustment      | Slider when installed                                                            |
| Fixed numeric option list           | Select or Radio button when installed                                            |
| Pending field value                 | Loading skeleton owned by Loading                                                |
| Calculated read-only numeric output | Read-only Number input only if submitted with a form; otherwise use data display |

## 10. Accessibility contract

- The input must be a native `<input type="number">` unless a future approved custom stepper API replaces it with equivalent semantics.
- Every number input must have a visible label associated through `for` and `id`.
- Placeholder text must not be the only label or instruction.
- Helper text must be programmatically associated with the input using `aria-describedby`.
- Error and warning messages must be programmatically associated with the input using `aria-describedby`.
- Error state must set `aria-invalid="true"`.
- Warning state must not set `aria-invalid="true"` unless the value is also invalid.
- Error and warning icons must be hidden from assistive technology when the message text already conveys the same meaning.
- Do not rely on color alone for error, warning, disabled, read-only, or focus states.
- Focus-visible treatment must be visible in every supported theme.
- Disabled fields must use native `disabled` and should not contain information the user needs to interpret or copy.
- Read-only fields must use native `readonly` when a value must remain readable and submitted.
- Range and step constraints must be communicated before validation failure, especially when a non-default step is used.
- Keyboard users must be able to Tab to the input, type a value, and use native Up/Down arrow behavior where the browser supports it.
- Custom increment/decrement controls are not approved until they support keyboard operation, accessible names, disabled-at-limit behavior, pointer operation, and server-validation parity.
- Validation recovery must identify the problem and the accepted value or range.
- Numeric values, labels, helper text, and validation messages must maintain readable contrast in every supported theme.

## 11. Content contract

- Use sentence case for labels, helper text, and validation messages.
- Use short, concrete labels such as `Seat limit`, `Retry count`, `Session timeout`, or `Discount rate`.
- Do not add a colon after the label.
- Use helper text to explain range, step, unit, precision, or downstream effect.
- Include the unit in the label or helper text when the unit is not obvious.
- Use validation text that tells the user how to fix the value.
- Prefer `Enter a whole number from 1 to 250.` over `Invalid number.`
- Prefer `Enter a percentage from 0 to 100 in 0.25 increments.` over `Bad step.`
- Keep labels, helper text, and messages short enough to scan.
- Do not rely on placeholder examples as instructions.
- Do not use vague labels such as `Number`, `Value`, or `Amount` when the business meaning is known.
- For nullable values, make the optional convention clear through the Forms Pattern.
- For required bounded values, use a clear default when a likely default exists and server behavior supports it.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, direct Carbon classes, Bootstrap form classes, or custom JavaScript.
- Do not render `Component-specific API pending correction` as the example call or installed guidance.
- Do not create feature-local `x-ui.number-input`, `x-number-input`, `x-stepper`, or equivalent wrappers.
- Do not create custom visible plus/minus controls without an approved JavaScript/data-attribute API and accessibility proof.
- Do not use `type="number"` for phone numbers, postal codes, account numbers, IDs, product codes, or other numeric-looking strings.
- Do not use Number input for currency or values requiring formatted text.
- Do not rely on placeholder text as the only label.
- Do not hide labels unless a documented accessibility exception and replacement accessible name are approved.
- Do not omit helper text when min/max/step constraints are not obvious.
- Do not set `aria-invalid="true"` for warning-only states.
- Do not use disabled fields for values users need to read, copy, or submit.
- Do not leave required bounded stepper-style values blank when a safe default is known.
- Do not add local margins, custom widths, custom focus rings, or state-only classes in feature views.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not create broad field-library corrections from this standard.

## 13. Deferred or gated capabilities

| Capability                               | Status                    | Gate                                                                                                                                                            |
| ---------------------------------------- | ------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public `x-ui.number-input` Blade wrapper | Deferred                  | Requires source file, props, slots, validation mapping, native attribute passthrough, examples, migration guidance, and tests.                                  |
| Custom increment/decrement buttons       | Gated                     | Requires JavaScript/controller or server-safe behavior, accessible button names, keyboard support, min/max disabled behavior, repeat behavior rules, and tests. |
| Prefix/suffix unit adornments            | Gated                     | Requires field adornment API, label/helper rules, screen-reader behavior, responsive proof, and UI Reference examples.                                          |
| Currency/number formatting               | Not owned by Number input | Requires dedicated formatted field API with locale, precision, parsing, masking, validation, and server-normalization rules.                                    |
| AI presence                              | Gated                     | Requires AI label, explainability popover, revert behavior, and accessibility proof before production use.                                                      |
| Loading/skeleton state                   | Not owned by Number input | Use Loading or parent Pattern; do not add a `loading` prop to Number input without a correction pass.                                                           |
| Client-side validation controller        | Deferred                  | Requires documented data attributes, server fallback, timing rules, assistive technology behavior, and tests.                                                   |
| Paired min/max range fields              | Pattern-owned / gated     | Requires Forms Pattern or Filter Pattern ownership, paired-label semantics, validation summary behavior, and responsive proof.                                  |
| Additional sizes                         | Not allowed               | Requires Spacing, Typography, UI Reference, and regression-test updates.                                                                                        |
| Custom validation colors/icons           | Not allowed               | Requires Color and Icons Element updates plus UI Reference proof.                                                                                               |

Future extensions require an updated Component standard and UI Reference proof before production use.

## 14. Implementation and UI Reference Checklist
### 14.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states are defined as relevant.   |
| Accessibility/content      | Keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements are defined.                                  |
| Element consumption        | Required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies are named.                                                    |
| Tests                      | Source/API assertions and UI Reference route assertions block generic fallback content.                                                            |

### 14.2. UI Reference proof checklist
| Requirement               | Visual proof expectation                                                                              |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Live examples             | The page renders production examples through the documented API or explicit native/class contract.    |
| Rendered variants/options | Every applicable supported variant, option, size, modifier, or deferred trigger condition is shown.   |
| Rendered states           | Required states are shown visually and with accessibility markers where relevant.                     |
| Developer implementation  | Real canonical calls and token-backed code snippets appear instead of placeholder comments.           |
| Related APIs              | Nearby Components, owning Patterns, consumed Elements, source files, and canonical docs are linked.   |
| Manual review             | The page provides enough rendered proof for visual review of behavior, layout, and state correctness. |
## 15. UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Number input page is a field reference page. The Live examples card should use grouped examples, state matrices, constraint demonstrations, and implementation examples rather than a single placeholder tab.

### 15.1. Required Live examples internal sections:

| Required proof                    | Rendered behavior                                                                                                                                               | Variants/options shown                                                           |
| --------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- |
| API status proof                  | Page states that Number input is Approved API and currently exposes native markup plus app-owned classes, not a public Blade wrapper.                           | Native `<input type="number">`, `ui-number-input`, deferred `x-ui.number-input`  |
| Basic number input                | Standard field renders with label, value, helper text, and default size.                                                                                        | Default, Helper text, Medium, Focus-visible                                      |
| Min/max/step                      | Bounded field renders with `min`, `max`, `step`, helper text, and matching validation copy.                                                                     | Min, Max, Step, Helper text, Validation                                          |
| Native increment/decrement        | Example documents and demonstrates native typing, Up/Down arrow behavior, and browser step controls where available.                                            | Native step behavior, Keyboard, Step, Bounds                                     |
| Size and density matrix           | Small, medium, large, compact, and fluid examples render only if implemented by the CSS API.                                                                    | Small, Medium, Large, Compact, Fluid                                             |
| Error state                       | Invalid field renders with error icon, error copy, `aria-invalid`, and associated description.                                                                  | Error icon, Error text, Validation, Focus-visible                                |
| Warning state                     | Warning field renders with warning icon/copy and no invalid ARIA unless blocking submission.                                                                    | Warning icon, Warning text, Advisory state                                       |
| Disabled/read-only                | Disabled and read-only examples show native attribute differences and visual treatment.                                                                         | Disabled, Read-only, Helper text                                                 |
| Decimal example                   | Decimal field renders with decimal input mode, decimal step, and precision helper text.                                                                         | Decimal, Step, Helper text                                                       |
| Selection guidance matrix         | Page distinguishes Number input from Text input, Select/Radio, Slider, Loading, and formatted/currency fields.                                                  | Number input, Text input, Slider, Select, Loading boundary                       |
| Accessibility proof               | Examples show visible label, `aria-describedby`, `aria-invalid`, hidden decorative icons, keyboard behavior, and constraints disclosed before validation.       | Label, Helper, Error, Warning, Keyboard, Bounds                                  |
| Content behavior proof            | Examples show sentence case, concrete labels, no label colons, range/step helper text, and recovery-oriented validation copy.                                   | Labels, Helper text, Error copy, Optional/required copy                          |
| Prohibited usage proof            | Page shows placeholders-only labels, local steppers, Bootstrap classes, direct Carbon classes, raw utility clusters, and numeric-looking strings as prohibited. | Placeholder-only, Custom steppers, Bootstrap, Carbon classes, Phone/ZIP examples |
| Deferred gate proof               | Page shows trigger conditions for Blade wrapper, custom stepper controls, units, formatting, AI presence, and client-side validation.                           | Deferred wrapper, Gated stepper, Units, Currency, AI, JS validation              |
| Foundation Elements proof         | Page shows consumed Foundation Elements and token responsibilities.                                                                                             | Color, Spacing, Typography, Themes, Icons                                        |
| Developer implementation examples | Canonical markup renders as real code examples and does not include placeholder text.                                                                           | Default, Error, Warning, Disabled, Read-only, Decimal                            |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show actual number-input markup, installed classes, native attributes, rendered states, prohibited usage, deferred gates, accessibility behavior, and consumed Foundation Elements.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/number-input` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The page identifies Number input as `Approved API`.
- The page states that no dedicated public Blade wrapper is approved yet.
- The page shows canonical native `<input type="number">` markup and `ui-number-input` classes.
- The page renders basic, min/max/step, decimal, error, warning, disabled, and read-only examples.
- The page documents native increment/decrement behavior without presenting custom plus/minus controls as installed.
- The page renders small, medium, large, compact, and fluid examples only when corresponding app classes are installed.
- The page documents that custom visible increment/decrement buttons are gated.
- The page documents `aria-describedby`, `aria-invalid`, hidden decorative status icons, visible labels, keyboard behavior, and helper text for constraints.
- The page distinguishes Number input from Text input, Slider, Select/Radio, Loading, and formatted/currency fields.
- The page documents prohibited usage for placeholder-only labels, local steppers, Bootstrap classes, direct Carbon classes, raw utility clusters, arbitrary spacing, hard-coded validation colors, and numeric-looking strings.
- Tests assert no generic placeholder content appears.
- Tests assert stale labels such as `Component-specific API pending correction`, `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` remain absent.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production class names, Bootstrap field classes, hard-coded colors, arbitrary local spacing, local icons, custom JavaScript, or feature-local number-input classes are presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/number-input');

$response->assertOk();
$response->assertSee('Number input');
$response->assertSee('Approved API');
$response->assertSee('ui-number-input');
$response->assertSee('type=&quot;number&quot;', false);
$response->assertSee('min');
$response->assertSee('max');
$response->assertSee('step');
$response->assertSee('aria-describedby');
$response->assertSee('aria-invalid');
$response->assertSee('Helper text');
$response->assertSee('Error');
$response->assertSee('Warning');
$response->assertSee('Disabled');
$response->assertSee('Read-only');
$response->assertSee('Compact');
$response->assertSee('Fluid');
$response->assertSee('No dedicated public Blade wrapper is approved yet');
$response->assertSee('Custom visible increment/decrement buttons');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Icons');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('form-control');
$response->assertDontSee('input-group');
```

## 17. Related APIs

| API                        | Route                                                                  |
| -------------------------- | ---------------------------------------------------------------------- |
| Components overview        | `/platform/ui-reference/components`                                    |
| Text input                 | `/platform/ui-reference/components/text-input`                         |
| Select                     | `/platform/ui-reference/components/select`                             |
| Radio button               | `/platform/ui-reference/components/radio-button`                       |
| Checkbox                   | `/platform/ui-reference/components/checkbox`                           |
| Button                     | `/platform/ui-reference/components/button`                             |
| Inline loading             | `/platform/ui-reference/components/inline-loading`                     |
| Loading                    | `/platform/ui-reference/components/loading`                            |
| Notification               | `/platform/ui-reference/components/notification`                       |
| Slider                     | `/platform/ui-reference/components/slider`                             |
| Forms pattern              | `/platform/ui-reference/patterns/forms`                                |
| Tables Pattern             | `/platform/ui-reference/patterns/tables`                               |
| Color element              | `/platform/ui-reference/elements/color`                                |
| Spacing element            | `/platform/ui-reference/elements/spacing`                              |
| Typography element         | `/platform/ui-reference/elements/typography`                           |
| Themes element             | `/platform/ui-reference/elements/themes`                               |
| Icons element              | `/platform/ui-reference/elements/icons`                                |
| Canonical number input doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fnumber-input.md` |
| Carbon number input usage  | `https://carbondesignsystem.com/components/number-input/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Number input usage, style, and accessibility guidance inform numeric use cases, default/fluid distinction, small/medium/large sizing, min/max/step helper text, keyboard behavior, error/warning icons, and validation accessibility. Login App keeps its own native-input API, `ui-*` namespace, server-validation handoff, Foundation Element tokens, and UI Reference proof.
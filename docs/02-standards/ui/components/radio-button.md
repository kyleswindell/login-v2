---
title: Radio button
slug: radio-button
api_layer: Component API
status: implemented
system_maturity: baseline
category: selection-controls
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/radio-button
canonical_doc: docs/02-standards/ui/components/radio-button.md
source_owner: /platform/ui-reference/components/radio-button
blade_api:
  - x-ui.radio-group
  - x-ui.radio-button
javascript_api: []
data_attributes:
  - data-ui-component="radio-group"
  - data-ui-component="radio-button"
  - data-ui-radio-group
  - data-ui-radio-group-layout
  - data-ui-radio
  - data-ui-radio-input
source_files:
  - resources/css/app.css
  - resources/views/components/ui/radio-group.blade.php
  - resources/views/components/ui/radio-button.blade.php
  - resources/views/platform/ui-reference/components/radio-button.blade.php
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - checkbox
  - toggle
  - select
  - text-input
  - button
  - notification
  - data-table
related_patterns:
  - forms
  - tables
  - navigation
carbon_reference:
  - https://carbondesignsystem.com/components/radio-button/usage/
  - https://carbondesignsystem.com/components/radio-button/style/
  - https://carbondesignsystem.com/components/radio-button/accessibility/
---

# Radio button Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed production rules:](#31-installed-production-rules)
  - [3.2. Installed modes:](#32-installed-modes)
- [4. Public API](#4-public-api)
  - [4.1. API status](#41-api-status)
  - [4.2. Canonical vertical radio group](#42-canonical-vertical-radio-group)
  - [4.3. Horizontal radio group](#43-horizontal-radio-group)
  - [4.4. Error state](#44-error-state)
  - [4.5. Warning state](#45-warning-state)
  - [4.6. Disabled option and disabled group](#46-disabled-option-and-disabled-group)
  - [4.7. Read-only group](#47-read-only-group)
  - [4.8. Native attribute contract](#48-native-attribute-contract)
  - [4.9. Class contract](#49-class-contract)
  - [4.10. Reserved future Blade contract](#410-reserved-future-blade-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper usage](#74-helper-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use Radio button when:](#91-use-radio-button-when)
  - [9.2. Do not use Radio button when:](#92-do-not-use-radio-button-when)
  - [9.3. Control selection:](#93-control-selection)
  - [9.4. Layout selection:](#94-layout-selection)
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

Radio buttons choose exactly one option from a visible set of mutually exclusive choices.

Canonical API owner: `/platform/ui-reference/components/radio-button`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Radio button is the installed Login App 2.0 single-choice selection API for visible option groups. It owns native radio semantics, group labeling, option labeling, selected/unselected states, group-level helper text, group-level validation, disabled and read-only group behavior, horizontal and vertical layout modes, token-backed focus/hover/validation states, and radio-specific content rules. It does not own multi-select choices, instant on/off settings, dropdown menus, custom segmented controls, table selection orchestration, form submission actions, validation summaries, or external spacing.

### 1.1. Canonical API responsibilities:

- Render single-choice option groups with native `<input type="radio">` controls.
- Group related radio options with `fieldset` and `legend` semantics unless an approved Pattern supplies an equivalent accessible group name.
- Keep every option visibly labeled and programmatically connected to its input.
- Preserve selected and unselected behavior through the shared native `name` attribute.
- Preserve click targets on both the radio control and its visible label.
- Preserve keyboard interaction for Tab entry, arrow-key movement within the group, and Space selection.
- Express group-level helper text, error text, warning text, disabled state, and read-only presentation through app-owned `ui-radio*` classes.
- Apply group-level validation to the group, not to a single option only.
- Use visible error or warning messages and app-owned status icons where applicable.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and icons.
- Prove vertical groups, horizontal groups, selected/unselected behavior, validation, disabled/read-only behavior, accessibility, content, and implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Independent true/false or multi-select choices. Use Checkbox.
- Instant on/off settings that apply immediately without a submit action. Use Toggle.
- Long option lists, compact hidden lists, or mobile-native selection. Use Select when a visible set would be too large.
- Single row selection in a data table. Use Data table and Table toolbar Patterns to own row selection, toolbar actions, and table semantics.
- Segmented controls, pills, tabs, or visual button groups. Use the owning Component or Pattern when installed.
- Form layout, validation-summary placement, submit/cancel action bars, and external spacing. Use the Forms Pattern.
- Success, error, warning, or informational outcome messaging outside the group. Use Notification or the parent Pattern.
- Custom JavaScript selection behavior, conditional reveal logic, or dynamic option loading. Gate through the owning Pattern or a scoped Component correction pass.

Carbon alignment note: Carbon defines radio buttons as mutually exclusive choices, recommends visible group labels when helpful, prefers vertical layout when possible for readability, supports horizontal layout for short peer choices, treats error and warning as group states, uses `fieldset`, `legend`, `label`, and `for` to preserve accessibility, and documents a single tab stop with arrow-key movement inside the group. Login App maps those principles to native inputs, app-owned `ui-*` classes, Foundation Element tokens, server-validation handoff, and UI Reference proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                              |
| ---------------------------- | -------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                       |
| System maturity              | Baseline                                                                                           |
| API layer                    | Component API                                                                                      |
| Component slug               | radio-button                                                                                       |
| Category                     | Selection controls                                                                                 |
| Priority                     | Tier A - Baseline app development                                                                  |
| UI Reference route           | `/platform/ui-reference/components/radio-button`                                                   |
| Canonical doc                | `docs/02-standards/ui/components/radio-button.md`                                                  |
| Source owner                 | `/platform/ui-reference/components/radio-button`                                                   |
| Blade API                    | `x-ui.radio-group`; `x-ui.radio-button`                                                            |
| JavaScript API               | None approved for baseline radio behavior                                                          |
| Data attributes              | `data-ui-radio-group`, `data-ui-radio-group-layout`, `data-ui-radio`, `data-ui-radio-input`       |
| Props/options                | Blade props map option arrays, scalar selected value, helper/error/warning text, and group layout |
| Source files                 | `resources/css/app.css`; `resources/views/components/ui/radio-group.blade.php`; `resources/views/components/ui/radio-button.blade.php`; UI Reference route |
| CSS namespace                | App-owned `ui-radio-group*` and `ui-radio*` classes                                                |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons                                                  |
| Carbon benchmark             | Carbon Radio button usage, style, and accessibility guidance                                       |

`Approved API` means the radio group and option wrappers are installed, rendered in UI Reference, and must be used instead of local radio markup or checkbox-derived styling.

## 3. Installed standard

The installed standard is a native-input and class-based Component API.

Use Radio button when the user must choose exactly one value from a visible set of mutually exclusive options and the available options are few enough to scan without opening another control.

### 3.1. Installed production rules:

- Use native `<input type="radio">` controls.
- Give every option in the group the same `name` attribute.
- Give every option a unique `id` and `value`.
- Use `checked` for the selected option and leave all other options unselected.
- Wrap the group in `fieldset` with a visible `legend` whenever the group needs its own accessible name.
- Use `aria-describedby` on the `fieldset` or inputs to associate helper, warning, or error text with the group.
- Use `required` and server-side validation when a selection is required.
- Use `disabled` on an individual option only when that option is unavailable.
- Use `disabled` on the `fieldset` only when the entire group is unavailable.
- Use the read-only presentation only when the selected value must be visible but cannot be changed; submit the preserved value through a hidden input when disabled radio controls would otherwise omit the value from form submission.
- Use vertical layout by default.
- Use horizontal layout only for short, parallel options with concise labels.
- Use group-level error and warning states. Do not mark one radio option as invalid while the group is the invalid field.
- Use visible helper text when the options need context or consequences.
- Use app-owned status icons only as decorative support for error or warning messages.
- Use server-side validation as the source of truth.
- Parent Patterns own grouping, external spacing, responsive layout, validation summaries, conditional reveal behavior, and workflow orchestration.
- Do not use raw utility clusters, Bootstrap form classes, direct Carbon classes, hard-coded colors, arbitrary spacing, local icons, or feature-local JavaScript to create radio button groups.

### 3.2. Installed modes:

| Mode                        | Status                       | Use                                                                                               |
| --------------------------- | ---------------------------- | ------------------------------------------------------------------------------------------------- |
| Vertical radio group        | Implemented                  | Default readable layout for most forms and settings.                                              |
| Horizontal radio group      | Implemented                  | Compact peer choices with short labels and no complex helper text per option.                     |
| Selected/unselected options | Implemented                  | Native radio behavior with exactly one selected option per named group.                           |
| Helper text                 | Implemented                  | Group-level guidance before the user makes a choice.                                              |
| Required group              | Implemented                  | Server-validated required selection with visible required/optional convention.                    |
| Error group                 | Implemented                  | Group-level invalid state with recovery copy and `aria-invalid` on relevant inputs when rendered. |
| Warning group               | Implemented                  | Group-level advisory state that does not necessarily block submission.                            |
| Disabled option             | Implemented                  | One unavailable option inside an otherwise available group.                                       |
| Disabled group              | Implemented                  | Entire unavailable group using native disabled behavior.                                          |
| Read-only group             | Approved API                 | Non-editable presentation of the selected value with hidden value preservation when submitted.    |
| Compact group               | Implemented / required proof | Dense layout for forms, filters, or toolbar-adjacent contexts where approved.                     |
| Tile/card radio             | Gated                        | Requires selectable tile/card API and accessibility proof before production use.                  |
| AI presence                 | Gated                        | Requires AI label/explainability contract before production use.                                  |

## 4. Public API

### 4.1. API status

The current public API is `x-ui.radio-group` plus `x-ui.radio-button`. The wrappers render native `fieldset`, `legend`, `label`, and `<input type="radio">` semantics with app-owned classes and token-backed visual states.

| API surface           | Installed value                                                                                                                                           |
| --------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade                 | `x-ui.radio-group`; `x-ui.radio-button`                                                                                                                    |
| JavaScript            | No dedicated JavaScript controller required                                                                                                               |
| Data attributes       | `data-ui-radio-group`, `data-ui-radio-group-layout`, `data-ui-radio`, `data-ui-radio-input`                                                              |
| Props/options         | `name`, `label`, `helper`, `error`, `warning`, `options`, scalar `value`, `orientation`/`layout`, `disabled`, `readonly`, `required`                    |
| Root semantic element | Native `fieldset` containing native `<input type="radio">` controls                                                                                       |
| CSS namespace         | `ui-radio-group`, `ui-radio-group-options`, `ui-radio-group-horizontal`, `ui-radio`, `ui-radio-control`, `ui-radio-input`, `ui-radio-box`, `ui-radio-*` |
| Source files          | `resources/views/components/ui/radio-group.blade.php`; `resources/views/components/ui/radio-button.blade.php`; `resources/css/app.css`                  |

Feature views should use the wrappers directly unless an owning Pattern composes them. Do not create local radio partials, local segmented controls, or helper classes for the same role.

### 4.2. Canonical vertical radio group

```blade
<x-ui.radio-group
    name="billing_cycle"
    label="Billing cycle"
    helper="Choose how often this account is billed."
    :options="[
        ['label' => 'Monthly', 'value' => 'monthly'],
        ['label' => 'Annual', 'value' => 'annual'],
    ]"
    :value="old('billing_cycle', $account->billing_cycle ?? 'monthly')"
/>
```

Use vertical layout as the default because it keeps option labels easier to scan and gives longer labels room to wrap.

### 4.3. Horizontal radio group

```blade
<x-ui.radio-group
    name="status"
    label="Status"
    helper="Choose one status filter."
    orientation="horizontal"
    :options="[
        ['label' => 'Active', 'value' => 'active'],
        ['label' => 'Paused', 'value' => 'paused'],
        ['label' => 'Archived', 'value' => 'archived'],
    ]"
    :value="old('status', 'active')"
/>
```

Use horizontal layout only for concise peer choices. Do not use horizontal layout when labels wrap, helper text differs by option, or the group contains more than a small visible set.

### 4.4. Error state

```blade
<x-ui.radio-group
    name="plan_type"
    label="Plan type"
    error="Select one plan type."
    required
    :options="[
        ['label' => 'Standard', 'value' => 'standard'],
        ['label' => 'Enterprise', 'value' => 'enterprise'],
    ]"
    :value="old('plan_type')"
/>
```

Error state belongs to the group. Every option is still a valid control; the error is that the group does not yet have an acceptable selected value.

### 4.5. Warning state

```blade
<x-ui.radio-group
    name="default_role"
    label="Default role"
    warning="Admin access grants broad account permissions."
    :options="[
        ['label' => 'User', 'value' => 'user'],
        ['label' => 'Admin', 'value' => 'admin'],
    ]"
    :value="old('default_role', 'user')"
/>
```

Warning is advisory. Do not set `aria-invalid="true"` unless the selection is also invalid and blocks submission.

### 4.6. Disabled option and disabled group

```blade
<x-ui.radio-group
    name="region"
    label="Region"
    helper="Unavailable regions cannot be selected for this tenant."
    :options="[
        ['label' => 'East', 'value' => 'east'],
        ['label' => 'West', 'value' => 'west', 'disabled' => true],
    ]"
    value="east"
/>
```

```blade
<x-ui.radio-group
    name="billing_mode"
    label="Billing mode"
    disabled
    :options="[
        ['label' => 'Manual', 'value' => 'manual'],
        ['label' => 'Automatic', 'value' => 'auto'],
    ]"
    value="manual"
/>
```

Use a disabled option when one choice is unavailable. Use a disabled group when the entire choice is unavailable. Do not use disabled state for information the user must submit or copy.

### 4.7. Read-only group

Native radio inputs do not support a reliable `readonly` attribute. When a selected value must be visible but cannot be changed, use the read-only presentation, disable the visible controls, and preserve the submitted value with a hidden input when the form still needs to submit it.

```blade
<input type="hidden" name="workspace_visibility" value="private">

<x-ui.radio-group
    name="workspace_visibility_display"
    label="Workspace visibility"
    helper="This value is managed by the account policy."
    readonly
    :options="[
        ['label' => 'Private', 'value' => 'private'],
        ['label' => 'Public', 'value' => 'public'],
    ]"
    value="private"
/>
```

Do not use a read-only radio group when a simple text display would be clearer. Use read-only radio only when preserving the original option context helps the user understand the selected value.

### 4.8. Native attribute contract

| Attribute             | Type                | Status                                                                 | Required                                                     | Rule                                                                                               |
| --------------------- | ------------------- | ---------------------------------------------------------------------- | ------------------------------------------------------------ | -------------------------------------------------------------------------------------------------- |
| `type="radio"`        | Native HTML         | Implemented                                                            | Yes                                                          | Required for every option in this Component API.                                                   |
| `name`                | Native HTML         | Implemented                                                            | Yes                                                          | All options in one group must share one name.                                                      |
| `id`                  | Native HTML         | Implemented                                                            | Yes                                                          | Required for label association when the input is not fully wrapped or when explicit `for` is used. |
| `value`               | Native HTML         | Implemented                                                            | Yes                                                          | Must be stable, server-validated, and not derived from visible label text alone.                   |
| `checked`             | Native HTML/Laravel | Implemented                                                            | Contextual                                                   | Exactly one option should be checked for required groups when a safe default exists.               |
| `required`            | Native HTML         | Implemented                                                            | When required                                                | Pair with visible required convention and server validation.                                       |
| `disabled`            | Native HTML         | Implemented                                                            | No                                                           | Use on unavailable options or on the whole `fieldset`; disabled values are not submitted.          |
| `readonly`            | Native HTML         | Not valid for radio                                                    | No                                                           | Use the documented read-only presentation instead.                                                 |
| `aria-describedby`    | ARIA                | Implemented                                                            | Required when helper/error/warning text exists               | Reference active helper, warning, or error message IDs.                                            |
| `aria-invalid="true"` | ARIA                | Implemented for error state                                            | Required for invalid/error groups when implemented on inputs | Do not use for warnings that can be submitted.                                                     |
| `aria-required`       | ARIA                | Optional when native required cannot express group requirement cleanly | Contextual                                                   | Use only when the installed markup requires an explicit group-level required announcement.         |
| `data-ui-radio-*`     | Data attributes     | Implemented                                                            | Yes for rendered wrappers                                    | Used for UI Reference proof and safe source assertions, not for custom behavior controllers.       |

### 4.9. Class contract

| Class                         | Type             | Status       | Purpose                                                            |
| ----------------------------- | ---------------- | ------------ | ------------------------------------------------------------------ |
| `ui-radio-group`              | Component root   | Implemented  | Radio group wrapper on the rendered `fieldset`.                    |
| `ui-radio-group-legend`       | Element          | Implemented  | Visible group label.                                               |
| `ui-radio-group-helper`       | Element          | Implemented  | Group-level helper text.                                           |
| `ui-radio-group-options`      | Element          | Implemented  | Option-list wrapper.                                               |
| `ui-radio-group-horizontal`   | Layout modifier  | Implemented  | Inline peer-choice layout.                                         |
| `ui-radio-group-disabled`     | State modifier   | Implemented  | Entire group disabled treatment paired with native `disabled`.     |
| `ui-radio-group-readonly`     | State modifier   | Implemented  | Read-only visual treatment.                                        |
| `ui-radio`                    | Option root      | Implemented  | One radio option root.                                             |
| `ui-radio-control`            | Option element   | Implemented  | Label grid that aligns the control and label.                      |
| `ui-radio-input`              | Option element   | Implemented  | Native radio input.                                                |
| `ui-radio-box`                | Option element   | Implemented  | Decorative custom radio circle and selected dot.                   |
| `ui-radio-label`              | Option element   | Implemented  | Visible option label.                                              |
| `ui-radio-option-description` | Option element   | Implemented  | Optional per-option descriptive line where the layout allows it.   |
| `ui-radio-helper`             | Option element   | Implemented  | Optional option-level helper text.                                 |
| `ui-radio-error`              | State element    | Implemented  | Group or option error message treatment.                           |
| `ui-radio-warning`            | State element    | Implemented  | Group or option warning message treatment.                         |
| `ui-radio-status-icon`        | State element    | Implemented  | Decorative status icon inside error or warning messages.           |
| `ui-radio-disabled`           | Option state     | Implemented  | Disabled option treatment paired with native `disabled`.           |
| `ui-radio-readonly`           | Option state     | Implemented  | Read-only option treatment.                                        |
| `ui-radio-invalid`            | Validation state | Implemented  | Invalid group or option treatment.                                 |
| `ui-radio-warning-state`      | Advisory state   | Implemented  | Warning group or option treatment.                                 |

Feature views must not create additional `ui-radio-*`, `radio-button-*`, `radio-group-*`, or local field classes. New classes require source implementation, this standard update, UI Reference proof, and tests.

### 4.10. Gated future API contract

The baseline wrapper contract is installed. The following adjacent APIs remain gated and are not production APIs today.

| Reserved API              | Current status            | Gate                                                                                                                                                 |
| ------------------------- | ------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------- |
| `x-ui.radio-card`         | Gated                     | Requires selectable tile/card semantics, keyboard behavior, focus treatment, content limits, and UI Reference proof.                                 |
| `x-ui.radio-table-select` | Not owned by Radio button | Use Data table and Table toolbar Patterns.                                                                                                           |

Do not create feature-local Blade components for gated radio variants.

## 5. Allowed variants, options, and modifiers

| Name                      | Type             | Status                       | API                                                                | Notes                                                             |
| ------------------------- | ---------------- | ---------------------------- | ------------------------------------------------------------------ | ----------------------------------------------------------------- |
| Vertical group            | Layout           | Implemented                  | Absence of horizontal modifier                                     | Default readable layout.                                          |
| Horizontal group          | Layout           | Implemented                  | `ui-radio-group-horizontal`                                        | Compact peer choices with short labels.                           |
| Compact group             | Density          | Gated                        | None                                                              | Dense forms or filter groups require a scoped spacing proof.      |
| Selected option           | State            | Implemented                  | Native `checked`                                                   | One selected value per named group.                               |
| Unselected option         | State            | Implemented                  | Absence of `checked`                                               | Available option that is not selected.                            |
| Required group            | Constraint       | Implemented                  | `required` plus server validation                                  | Requires a visible required convention.                           |
| Helper text               | Content          | Implemented                  | `ui-radio-group-helper` and `aria-describedby`                     | Explains group purpose or consequences.                           |
| Error group               | Validation state | Implemented                  | `ui-radio-invalid`, `ui-radio-error`, error message                | Group-level invalid state.                                        |
| Warning group             | Advisory state   | Implemented                  | `ui-radio-warning-state`, `ui-radio-warning`, warning message      | Advisory state that may still submit.                             |
| Disabled option           | State            | Implemented                  | Radio input `disabled`                                             | One unavailable option.                                           |
| Disabled group            | State            | Implemented                  | `fieldset disabled`                                                | Entire group unavailable.                                         |
| Read-only group           | State            | Approved API                 | `ui-radio-group-readonly` plus hidden submitted value when needed  | Native radio has no real `readonly`; use documented presentation. |
| Per-option description    | Content          | Implemented                  | `ui-radio-option-description`                                      | Must wrap under the label and remain top-aligned with the control. |
| Tile/card radio           | Variant          | Gated                        | None                                                               | Requires selectable tile/card standard.                           |
| Nested conditional fields | Pattern behavior | Pattern-owned / gated        | None                                                               | Requires Forms Pattern ownership and focus/announcement proof.    |
| AI presence               | Modifier         | Gated                        | None                                                               | Requires AI label/explainability contract.                        |
| Custom icons              | Modifier         | Not allowed                  | None                                                               | Radio control and status icons are component-owned.               |
| Loading state             | State            | Not applicable               | None                                                               | Use Loading or parent Pattern while options are pending.          |
| Multi-select              | Behavior         | Not allowed                  | None                                                               | Use Checkbox.                                                     |
| Instant apply toggle      | Behavior         | Not owned                    | Toggle                                                             | Use Toggle for immediate on/off settings.                         |

## 6. States

| State                   | Status                            | Implementation requirement                                                                                          |
| ----------------------- | --------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Default                 | Implemented                       | Renders visible group label, visible options, native radio inputs, and approved layout class.                       |
| Selected                | Implemented                       | Uses native `checked`; selected value is submitted for the group name.                                              |
| Unselected              | Implemented                       | Option remains available and deselects when another option with the same name is selected.                          |
| Hover-capable           | Implemented                       | Pointer hover may indicate the option/label target through token-backed treatment.                                  |
| Focus-visible           | Implemented                       | Native radio focus is visible in all supported themes.                                                              |
| Active/pressed          | Implemented                       | Token-backed pressed/active treatment during pointer or keyboard activation.                                        |
| Disabled option         | Implemented                       | Uses native `disabled` on one radio input; option cannot be selected.                                               |
| Disabled group          | Implemented                       | Uses native `fieldset disabled`; entire group cannot be changed and disabled values are not submitted.              |
| Read-only group         | Approved API                      | Uses read-only presentation; preserve submitted value through hidden input when needed.                             |
| Helper                  | Implemented                       | Helper text is associated with the group or inputs using `aria-describedby`.                                        |
| Error                   | Implemented                       | Group-level error uses message text, optional decorative icon, and invalid state on relevant inputs.                |
| Warning                 | Implemented                       | Group-level warning uses message text and optional decorative icon without invalid ARIA unless blocking submission. |
| Required                | Implemented                       | Required convention is visible and server validation enforces one selected value.                                   |
| Optional                | Implemented through Forms Pattern | Optional convention is owned by Forms Pattern; group remains clearly labeled.                                       |
| Empty/no selection      | Implemented with restrictions     | Allowed only when optional or when no safe default exists before user choice. Required groups must validate.        |
| Overflow/wrapped labels | Implemented through content rules | Labels must wrap under the label text, not truncate with ellipses.                                                  |
| Loading                 | Not applicable                    | Use Loading while options are pending; Radio button does not own loading state.                                     |
| Success                 | Not applicable                    | Successful save/submit belongs to Notification, Forms Pattern, or page status.                                      |
| Informational           | Not applicable as state           | Use helper text, Notification, or Pattern-owned info messaging.                                                     |
| Expanded/collapsed      | Not applicable                    | Disclosure belongs to the parent Pattern.                                                                           |
| Open/closed             | Not applicable                    | Radio button does not own menu/popup behavior.                                                                      |
| Current                 | Not applicable                    | Current navigation state belongs to navigation components.                                                          |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Radio button consumes Foundation Color, Spacing, Typography, Themes, Motion, and Icons.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.

2x Grid is not a public Radio button API dependency. Parent Patterns may use 2x Grid to place radio groups in pages, forms, modals, filters, cards, or table toolbars.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                |
| ----------- | ---------------------------------------------------------------------------------------------------------------------------- |
| Color       | Radio border, selected dot, label, helper text, error, warning, disabled, read-only, hover, focus, and status icon roles.    |
| Spacing     | Control-label gap, option stack gap, horizontal group gap, legend-helper gap, message gap, compact/default internal spacing. |
| Typography  | Group legend, option labels, helper text, error/warning text, and optional descriptions.                                     |
| Themes      | Light, dark, and inverse token resolution for every option and group state.                                                  |
| Motion      | Short productive transitions for selected, hover, focus, and validation state changes where implemented.                     |
| Icons       | App-owned error and warning icons; no local icon sources.                                                                    |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$icon-primary` | Radio control border and selected inner dot | `ui-radio-box`, selected state | App icon palette | Same role / app value | Radio visual state is component-owned but uses shared icon/color roles. |
| `$text-primary`, `$text-secondary`, `$text-disabled` | Option label, group label/helper, disabled label | `ui-radio-label`, group legend/helper roles | App text palette | Same role / app value | Text hierarchy stays Color/Typography-owned. |
| `$support-error`, `$text-error`, `$support-warning` | Error border/message and warning icon | Radio validation state classes | App status palette | Same role / app value | Validation must include message/icon semantics where applicable. |
| `$focus` | Focus border/ring | `ui-radio-input:focus-visible`, `--ui-focus` | App focus palette | Same role / app value | Focus must target the actual control. |
| `$text-disabled` and disabled icon/control roles | Disabled radio state | Disabled radio classes | App disabled palette | Same role / app value | Disabled styling must be token-backed. |
| AI mini label size/color row | Carbon AI presence note | No baseline radio role until AI variant is approved | None | Not adopted | AI label adoption is owned by AI Label/AI pattern gates. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation.

```css
.ui-radio-group
.ui-radio-group-legend
.ui-radio-group-helper
.ui-radio-group-options
.ui-radio-group-horizontal
.ui-radio-group-disabled
.ui-radio-group-readonly
.ui-radio
.ui-radio-control
.ui-radio-input
.ui-radio-box
.ui-radio-label
.ui-radio-option-description
.ui-radio-helper
.ui-radio-error
.ui-radio-warning
.ui-radio-status-icon
.ui-radio-disabled
.ui-radio-readonly
.ui-radio-invalid
.ui-radio-warning-state
```

Feature views must not create `form-check`, `form-check-input`, `radio-*`, `radio-button-*`, `custom-radio-*`, `choice-*`, raw utility clusters, arbitrary width/height values, hard-coded validation colors, local focus rings, local icons, direct Carbon classes, Bootstrap field classes, or custom JavaScript for the same UI role.

### 7.4. Helper usage

| Helper/mechanism                       | Status                                                                   | Rule                                                                                       |
| -------------------------------------- | ------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------ |
| Laravel `old()`                        | Approved                                                                 | Use to repopulate the selected value after validation failure.                             |
| Laravel error bags                     | Approved                                                                 | Use as the source for group-level error-state rendering and recovery copy.                 |
| Server-side validation                 | Required                                                                 | Must enforce required selection and allowed values.                                        |
| Native `fieldset` and `legend`         | Required by default                                                      | Use to group and label radio options.                                                      |
| Native `label` and `for`               | Required                                                                 | Use explicit association or wrapping labels so clicking label text selects the radio.      |
| Native radio `name` grouping           | Required                                                                 | All options in a group must share one name.                                                |
| Native arrow-key behavior              | Approved                                                                 | Browser handles group movement and selection. Do not override with local JS.               |
| `aria-describedby`                     | Required with helper/error/warning text                                  | Reference all active descriptive text IDs.                                                 |
| `aria-invalid`                         | Required for invalid state when implementation maps invalidity to inputs | Use only when the selection is invalid.                                                    |
| `aria-required`                        | Optional                                                                 | Use only when native required semantics do not communicate group requirement sufficiently. |
| Hidden input for read-only submission  | Approved with restrictions                                               | Use only to preserve a selected read-only value when visible radio controls are disabled.  |
| Custom JavaScript selection controller | Not approved                                                             | Requires future documented JavaScript and data-attribute API.                              |
| `data-ui-radio-*` attributes           | Approved for source and UI Reference proof                                | Use only for stable inspection and behavior-proof hooks; do not add custom controllers.    |

## 8. Composition rules

- Use Radio button only for mutually exclusive choices where exactly one option can be selected.
- Use vertical layout by default.
- Use horizontal layout only when labels are short, peer choices are easy to compare, and the group remains readable at small widths.
- Keep option labels visible at all times.
- Use one group label for the set unless a parent Pattern already supplies an equivalent group name.
- Use helper text when the decision needs context, consequences, or required/optional guidance.
- Use group-level validation for required, error, and warning states.
- Keep every radio option inside the same group visually close enough that the single-choice relationship is obvious.
- Keep every radio option in one group under the same `name` attribute.
- Do not mix unrelated choices inside one radio group.
- Do not use radio buttons when multiple selections are allowed.
- Do not use radio buttons as navigation tabs.
- Do not use radio buttons as decorative filters without form semantics unless a Filter Pattern owns the behavior.
- Do not hide a small set of critical choices behind a dropdown when a visible radio group is clearer.
- Do not use Toggle when a submit action is required to apply the setting.
- Use Toggle when a two-state setting applies immediately without form submission.
- Use Select when the option list is long, dynamic, or too large to scan visibly.
- Use Checkbox when each option is independent or more than one can be selected.
- Use read-only presentation only when preserving the option context helps. Otherwise use a data-display Pattern.
- Parent Patterns own field grouping, responsive layout, external spacing, conditional reveal behavior, validation summaries, and submit actions.
- Components own internal group semantics, option styling, helper/error/warning associations, and token-backed states.

## 9. Selection guidance

### 9.1. Use Radio button when:

- A user must choose exactly one option from a visible set.
- The choices are mutually exclusive.
- The number of options is small enough to scan without opening a menu.
- Seeing all options at once helps the user compare consequences.
- The choice is submitted with a form or filter state.
- The group has two or more meaningful choices where labels provide more clarity than an on/off toggle.

### 9.2. Do not use Radio button when:

- A user can select more than one option; use Checkbox.
- The setting applies immediately as an on/off state; use Toggle.
- The option list is long, dynamic, or space-constrained; use Select or another approved list component.
- The options switch visible page panels without submitting a value; use Tabs or Content switcher.
- The options are visual cards or tiles; gate a selectable-card radio standard first.
- The group is read-only calculated output and not part of a form; use a data-display Pattern.
- The choice is a single yes/no consent or acknowledgement; use Checkbox when the user is confirming one independent statement.

### 9.3. Control selection:

| Need                                | Use                                                                                 |
| ----------------------------------- | ----------------------------------------------------------------------------------- |
| One choice from a small visible set | Radio button                                                                        |
| One choice from a long list         | Select                                                                              |
| Multiple independent choices        | Checkbox                                                                            |
| Immediate on/off setting            | Toggle                                                                              |
| Switch between page panels          | Tabs or Content switcher when installed                                             |
| Select one table row                | Data table selection Pattern                                                        |
| Select one visual card/tile         | Gated selectable-card radio Pattern                                                 |
| Display a locked selected value     | Read-only radio presentation only if option context matters; otherwise data display |

### 9.4. Layout selection:

| Need                                                      | Use                                                                             |
| --------------------------------------------------------- | ------------------------------------------------------------------------------- |
| Most forms and settings                                   | Vertical group                                                                  |
| Short peer choices such as `Active`, `Paused`, `Archived` | Horizontal group                                                                |
| Dense filter group with short labels                      | Compact horizontal or compact vertical group when UI Reference proves the class |
| Labels that may wrap                                      | Vertical group                                                                  |
| Per-option descriptions                                   | Vertical group; gate description behavior if not already installed              |

## 10. Accessibility contract

- Radio options must use native `<input type="radio">` controls unless a future approved custom API provides equivalent semantics.
- Related radio options must be grouped with `fieldset` and `legend` by default.
- If a visible `legend` is omitted because a parent Pattern supplies an equivalent label, the group must still have an accessible name through an approved mechanism.
- Every radio option must have a visible label.
- Every visible label must be programmatically associated with its input.
- Clicking the visible label must select the corresponding radio option unless the option is disabled.
- A radio group should be one Tab stop in normal browser behavior; arrow keys move between options and update selection.
- Space selects the focused option when applicable.
- The selected state must be conveyed through native `checked` semantics, not visual styling alone.
- Required groups must be identified visually and programmatically where the implementation requires it.
- Group-level helper, warning, and error text must be associated through `aria-describedby`.
- Error state must identify the group problem and recovery path.
- Warning state must not use invalid semantics unless it blocks submission.
- Error and warning icons must be hidden from assistive technology when message text provides the meaning.
- Do not rely on color alone for selected, error, warning, disabled, read-only, or focus states.
- Focus-visible treatment must be visible in every supported theme.
- Disabled groups must use native disabled behavior and should not contain information the user needs to submit.
- Read-only groups must not pretend native radio supports `readonly`; preserve submitted value separately when needed.
- Long labels must wrap and remain associated with the correct radio control.
- Horizontal groups must preserve logical reading order and remain usable when wrapped at smaller widths.
- Conditional fields revealed by radio selection are Pattern-owned and must preserve focus order, announcement behavior, and validation associations.

## 11. Content contract

- Use sentence case for group labels, option labels, helper text, warning text, and error text.
- Use a concise group label that states the category or asks the user to choose.
- Use clear, concise option labels.
- Prefer short option labels, but never truncate labels with ellipses.
- Let long labels wrap under the label text while keeping the radio control top-aligned.
- Do not add a colon after the group label.
- Use helper text to explain consequences, required/optional context, or selection rules.
- Use error text that tells the user how to fix the group, such as `Select one billing cycle.`
- Use warning text only for meaningful consequences, not decorative emphasis.
- Avoid vague group labels such as `Options`, `Type`, or `Selection` when the business meaning is known.
- Do not encode important differences only in values or tooltips. The visible option labels must be understandable.
- Include `None`, `Other`, or equivalent options only when the product accepts that value and the server validates it.
- Use the same grammar pattern across options when possible.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, direct Carbon classes, Bootstrap form classes, or custom JavaScript.
- Do not render `Component-specific API pending correction` as the example call or installed guidance.
- Do not create feature-local `x-radio`, `x-radio-card`, alternate `x-ui.radio-*` wrappers, or equivalent wrappers.
- Do not create custom radio visuals that break native radio semantics.
- Do not use `div`, `button`, or `a` elements as radio options without an approved custom widget standard.
- Do not use radio buttons when multiple selections are allowed.
- Do not use radio buttons as a replacement for Toggle when the setting applies immediately.
- Do not hide critical small option sets behind a dropdown when a visible radio group is clearer.
- Do not use a dropdown for only two choices when a radio group would be clearer.
- Do not omit the group label unless a parent Pattern provides an equivalent accessible name.
- Do not rely on placeholder, tooltip, color, icon, or position as the only way to communicate meaning.
- Do not truncate option labels.
- Do not use horizontal layout for long labels or complex option descriptions.
- Do not mark one option as invalid when the group is invalid.
- Do not set `aria-invalid="true"` for warning-only groups.
- Do not use `readonly` as if it were a valid radio input attribute.
- Do not use disabled radios to preserve submitted values without a documented hidden input or server-side value preservation.
- Do not create local margins, custom widths, custom focus rings, or state-only classes in feature views.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not create broad field-library corrections from this standard.

## 13. Deferred or gated capabilities

| Capability                               | Status                           | Gate                                                                                                                                                 |
| ---------------------------------------- | -------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------- |
| Tile/card radio variant                  | Gated                            | Requires selectable tile/card semantics, full-card click behavior, keyboard behavior, focus treatment, content limits, and UI Reference proof.       |
| Per-option descriptions                  | Implemented baseline             | Use only for concise supporting copy that wraps under the label and remains top-aligned.                                                              |
| Conditional reveal fields                | Pattern-owned / gated            | Requires Forms Pattern ownership, focus order, announcement behavior, validation mapping, and tests.                                                 |
| AI presence                              | Gated                            | Requires AI label, explainability popover, provenance/revert behavior if applicable, and accessibility proof before production use.                  |
| Custom JavaScript radio controller       | Not approved                     | Native radio behavior is sufficient for baseline; any controller requires documented data attributes, lifecycle, keyboard behavior, and tests.       |
| Radio table row selection                | Not owned by Radio button        | Use Data table and Table toolbar Patterns.                                                                                                           |
| Segmented radio/button visual mode       | Not owned by Radio button        | Requires segmented control or content switcher standard.                                                                                             |
| Additional layouts or sizes              | Not allowed                      | Requires Spacing, Typography, UI Reference, and regression-test updates.                                                                             |
| Custom validation colors/icons           | Not allowed                      | Requires Color and Icons Element updates plus UI Reference proof.                                                                                    |

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

The Radio button page is a selection-control reference page. The Live examples card should use grouped examples, layout comparisons, state matrices, validation examples, selection guidance, and implementation examples rather than a single placeholder tab.

### 15.1. Required Live examples internal sections:

| Required proof                    | Rendered behavior                                                                                                                                                        | Variants/options shown                                                                                |
| --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------- |
| API status proof                  | Page states that Radio button is Approved API and exposes installed Blade wrappers that render native markup plus app-owned classes.                                      | `x-ui.radio-group`, `x-ui.radio-button`, native `<input type="radio">`, `fieldset`, `legend`, `ui-radio-group` |
| Vertical radio group              | Default stacked group renders with label, helper text, selected/unselected options, and native radio semantics.                                                          | Vertical, Selected, Unselected, Helper text, Focus-visible                                            |
| Horizontal radio group            | Compact peer choices render inline with short labels and responsive wrapping guidance.                                                                                   | Horizontal, Selected, Unselected, Compact, Focus-visible                                              |
| Selected/unselected matrix        | State examples show selected and unselected options in normal, hover-capable, focus-visible, and active states.                                                          | Selected, Unselected, Hover-capable, Focus-visible, Active                                            |
| Group validation                  | Error and warning examples apply state to the group with message text and status icon treatment.                                                                         | Error, Warning, Helper text, `aria-describedby`, `aria-invalid`                                       |
| Disabled/read-only matrix         | Disabled option, disabled group, and read-only group examples show semantic differences and submission behavior.                                                         | Disabled option, Disabled group, Read-only, Hidden submitted value                                    |
| Required/optional behavior        | Required group example shows visible convention, native/server validation, and recovery copy.                                                                            | Required, Optional, Error recovery                                                                    |
| Content behavior proof            | Examples show sentence case labels, concise group labels, no label colons, wrapping long labels, and no truncation.                                                      | Group labels, Option labels, Helper text, Wrapped label                                               |
| Selection guidance matrix         | Page distinguishes Radio button from Checkbox, Toggle, Select, Tabs/Content switcher, Data table selection, and read-only data display.                                  | Radio, Checkbox, Toggle, Select, Tabs, Data table                                                     |
| Accessibility proof               | Examples show `fieldset`, `legend`, label association, label click target, arrow-key behavior, selected semantics, helper/error association, and non-color-only state.   | Fieldset, Legend, Label, Keyboard, `checked`, `aria-describedby`                                      |
| Prohibited usage proof            | Page shows custom div radios, Bootstrap form checks, direct Carbon classes, missing group labels, dropdown misuse, multi-select misuse, and toggle misuse as prohibited. | Native-only rule, Bootstrap prohibition, Carbon class prohibition, Dropdown boundary, Toggle boundary |
| Deferred gate proof               | Page shows trigger conditions for radio cards, conditional reveals, AI presence, and custom JS.                                                                           | Gated radio card, Conditional reveal, AI, JS                                                         |
| Foundation Elements proof         | Page shows consumed Foundation Elements and token responsibilities.                                                                                                      | Color, Spacing, Typography, Themes, Motion, Icons                                                     |
| Developer implementation examples | Canonical markup renders as real code examples and does not include placeholder text.                                                                                    | Vertical, Horizontal, Error, Warning, Disabled, Read-only                                             |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show actual radio markup, installed classes, native attributes, rendered states, prohibited usage, deferred gates, accessibility behavior, and consumed Foundation Elements.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/radio-button` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The page identifies Radio button as `Approved API`.
- The page states that `x-ui.radio-group` and `x-ui.radio-button` are the installed Blade wrappers.
- The page shows canonical native `<input type="radio">` markup, `fieldset`, `legend`, shared `name`, unique `value`, and `ui-radio-group` classes.
- The page renders vertical group, horizontal group, selected/unselected, error, warning, disabled option, disabled group, and read-only examples.
- The page documents native keyboard behavior, including Tab entry, arrow-key movement, and Space selection.
- The page documents that group-level validation belongs to the group, not one option only.
- The page documents that read-only radio is a presentation pattern because native radio does not support `readonly`.
- The page distinguishes Radio button from Checkbox, Toggle, Select, Tabs/Content switcher, Data table selection, and read-only data display.
- The page documents prohibited usage for custom div radios, Bootstrap form checks, direct Carbon classes, raw utility clusters, arbitrary spacing, hard-coded validation colors, missing group labels, dropdown misuse, multi-select misuse, and toggle misuse.
- Tests assert no generic placeholder content appears.
- Tests assert stale labels such as `Component-specific API pending correction`, `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` remain absent.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production class names, Bootstrap field classes, hard-coded colors, arbitrary local spacing, local icons, custom JavaScript, or feature-local radio classes are presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/radio-button');

$response->assertOk();
$response->assertSee('Radio button');
$response->assertSee('Approved API');
$response->assertSee('ui-radio-group');
$response->assertSee('ui-radio');
$response->assertSee('type=&quot;radio&quot;', false);
$response->assertSee('fieldset');
$response->assertSee('legend');
$response->assertSee('Vertical radio group');
$response->assertSee('Horizontal radio group');
$response->assertSee('Selected');
$response->assertSee('Unselected');
$response->assertSee('Error');
$response->assertSee('Warning');
$response->assertSee('Disabled');
$response->assertSee('Read-only');
$response->assertSee('aria-describedby');
$response->assertSee('aria-invalid');
$response->assertSee('x-ui.radio-group');
$response->assertSee('x-ui.radio-button');
$response->assertSee('Native radio inputs do not support a reliable readonly attribute');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Motion');
$response->assertSee('Icons');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('form-check');
$response->assertDontSee('form-check-input');
```

## 17. Related APIs

| API                        | Route                                                                  |
| -------------------------- | ---------------------------------------------------------------------- |
| Components overview        | `/platform/ui-reference/components`                                    |
| Checkbox                   | `/platform/ui-reference/components/checkbox`                           |
| Toggle                     | `/platform/ui-reference/components/toggle`                             |
| Select                     | `/platform/ui-reference/components/select`                             |
| Text input                 | `/platform/ui-reference/components/text-input`                         |
| Button                     | `/platform/ui-reference/components/button`                             |
| Notification               | `/platform/ui-reference/components/notification`                       |
| Data table                 | `/platform/ui-reference/components/data-table`                         |
| Forms pattern              | `/platform/ui-reference/patterns/forms`                                |
| Tables Pattern             | `/platform/ui-reference/patterns/tables`                               |
| Navigation Pattern         | `/platform/ui-reference/patterns/navigation`                           |
| Color element              | `/platform/ui-reference/elements/color`                                |
| Spacing element            | `/platform/ui-reference/elements/spacing`                              |
| Typography element         | `/platform/ui-reference/elements/typography`                           |
| Themes element             | `/platform/ui-reference/elements/themes`                               |
| Motion element             | `/platform/ui-reference/elements/motion`                               |
| Icons element              | `/platform/ui-reference/elements/icons`                                |
| Canonical radio button doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fradio-button.md` |
| Carbon radio button usage  | `https://carbondesignsystem.com/components/radio-button/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Radio button usage, style, and accessibility guidance inform mutually exclusive selection behavior, vertical/horizontal layout, group labeling, helper text, group-level validation, keyboard behavior, label click targets, warning/error states, and content rules. Login App keeps its own native-input API, `ui-*` namespace, server-validation handoff, Foundation Element tokens, and UI Reference proof.

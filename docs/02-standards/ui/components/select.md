---
title: Select
slug: select
api_layer: Component API
status: implemented-pending-review
system_maturity: installed
category: inputs
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/select
canonical_doc: docs/02-standards/ui/components/select.md
source_owner: /platform/ui-reference/components/select
blade_api:
  - x-ui.select
javascript_api: []
data_attributes:
  - data-ui-component="select"
  - data-ui-select-field
  - data-ui-select
source_files:
  - resources/views/components/ui/select.blade.php
  - resources/css/components/select.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
related_components:
  - text-input
  - checkbox
  - radio-button
  - menu
  - button
related_patterns:
  - forms
  - tables
  - navigation
carbon_reference:
  - https://carbondesignsystem.com/components/select/usage/
  - https://carbondesignsystem.com/components/select/style/
  - https://carbondesignsystem.com/components/select/accessibility/
  - https://carbondesignsystem.com/components/dropdown/usage/
---

# Select Component API Standard

## 1. API summary
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Markup and option contract](#43-markup-and-option-contract)
  - [4.4. Installed class contract](#44-installed-class-contract)
  - [4.5. Option data contract](#45-option-data-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Selection matrix:](#93-selection-matrix)
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

Native select chooses one option from a short known list.

Canonical API owner: `/platform/ui-reference/components/select`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Select is the installed Login App 2.0 native single-selection field API. It owns native `<select>` composition, visible labels, helper copy, placeholder-like prompt options, validation messaging, disabled/read-only treatment, token-backed field states, option grouping where needed, and UI Reference proof for short known lists. It does not own searchable selection, remote option loading, multi-select chips, combobox behavior, custom dropdown panels, autocomplete, filtering, or menu actions.

### 1.1. Canonical API responsibilities:

- Render short known option lists through native `<select>` markup composed with app-owned `ui-*` field and select classes.
- Preserve native select semantics, keyboard behavior, mobile browser behavior, and form submission behavior.
- Require a visible label for every select.
- Associate helper, warning, error, and status copy through stable IDs and `aria-describedby`.
- Support optional prompt options, disabled placeholder options, grouped options, required selection, disabled state, read-only summary state, warning state, error state, and loading/pending state.
- Use app-owned field classes instead of raw utility clusters, Bootstrap form-select classes, or custom dropdown chrome.
- Keep option lists short enough to scan. Use a deferred/gated combobox or Pattern-owned picker for long or searchable lists.
- Prove installed states, validation, disabled/read-only behavior, option contracts, and native composition on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Search, autocomplete, typeahead, async option loading, remote lookup, or custom listbox behavior.
- Multi-select tag/chip UI. Use Checkbox groups or a future Multi-select/Combobox API when installed.
- Action menus. Use Menu when the options are commands instead of field values.
- Form layout, field grouping, submit/cancel placement, and page-level workflow orchestration.
- Server-side validation rules, authorization rules, option-source policy, or controller behavior.

## 2. Status and ownership

| Field                        | Value                                                                                                    |
| ---------------------------- | -------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                             |
| System maturity              | Installed                                                                                               |
| API layer                    | Component API                                                                                            |
| Component slug               | `select`                                                                                                 |
| Category                     | Inputs                                                                                                   |
| Priority                     | Tier A - Baseline app development                                                                        |
| UI Reference route           | `/platform/ui-reference/components/select`                                                               |
| Canonical doc                | `docs/02-standards/ui/components/select.md`                                                              |
| Source owner                 | `/platform/ui-reference/components/select`                                                               |
| Blade API                    | `x-ui.select`                                                                                            |
| Dedicated Blade component    | Installed public API backed by native `<select>` behavior                                                |
| JavaScript API               | None required for installed native select behavior                                                       |
| Data attributes              | `data-ui-component="select"`, `data-ui-select-field`, `data-ui-select`                                  |
| Source files                 | `resources/views/components/ui/select.blade.php`; `resources/css/components/select.css`; `/platform/ui-reference/components/select` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons                                                                |
| Carbon benchmark             | Carbon Select and Dropdown usage/style/accessibility guidance                                            |

`Approved API` means `x-ui.select` is the public native single-value form-select API. It preserves browser-controlled option-list behavior while the app owns labels, helper/validation copy, field states, sizes, inline/fluid treatments, and UI Reference proof.

## 3. Installed standard

Select is installed as a native field component. The approved production API is `<x-ui.select>`, which renders app-owned field markup around a native browser `<select>`.

Select is not a ListBox consumer. Native Select preserves browser and operating-system option behavior; custom listbox behavior belongs to Dropdown, Multiselect, or a future ComboBox standard.

### 3.1. The installed standard is:

- Use `<x-ui.select>` for one choice from a short known list.
- The component wraps the control in `.ui-field.ui-select-field`.
- Use `.ui-field-label` for the visible label.
- Use `.ui-select` on the native `<select>` element.
- Use `.ui-select-chevron-icon` with the approved outline chevron icon. Do not draw the select chevron with CSS triangles, text glyphs, or local SVG.
- Use `.ui-field-helper`, `.ui-field-error`, and `.ui-field-warning` for supporting copy.
- Use `aria-describedby` when helper, warning, error, or status copy exists.
- Use `aria-invalid="true"` only for blocking validation errors.
- Use a first disabled empty option only when the workflow needs a prompt such as `Choose a status`.
- Use `required` when a value must be selected before form submission.
- Use `disabled` when the user cannot currently change the field.
- Represent read-only as a non-interactive value summary plus a hidden submitted value. Do not use invalid `readonly` behavior on a native `<select>`.
- Represent loading with a disabled select, `aria-busy="true"` on the wrapper, and visible status copy when options are pending.
- Use `optgroup` only when grouping improves scanning and keeps the list short.
- Do not use `multiple` on this component. Multiple selection is not part of the installed Select API.
- Do not replace native select behavior with custom JavaScript, custom listbox markup, or menu markup.

Carbon alignment note: Carbon documents Select as a form control with enabled, hover, selected, focus, open, error, warning, disabled, skeleton, and read-only states, and Carbon Dropdown guidance distinguishes stylized dropdowns, multiselect, and combo box behavior. Login App maps the installed portion to native select markup and app-owned `ui-*` field classes, while deferring custom dropdown, multiselect, and combobox behavior.

## 4. Public API

### 4.1. Canonical calls

Use `x-ui.select`; it renders native Blade markup with the installed field and select class contract.

```blade
<x-ui.select
    id="tenant-status"
    name="status"
    label="Tenant status"
    helper="Choose the current account state."
    placeholder="Choose a status"
    :options="$statusOptions"
/>
```

```blade
<x-ui.select
    id="role"
    name="role"
    label="Role"
    placeholder="Choose a role"
    :options="$roleOptions"
    required
    invalid
    invalid-text="Choose a role before saving."
/>
```

```blade
<x-ui.select
    id="billing-cycle"
    name="billing_cycle"
    label="Billing cycle"
    :options="$cycleOptions"
    value="annual"
    readonly
/>
```

```blade
<x-ui.select
    id="workspace-owner"
    name="owner_id"
    label="Workspace owner"
    placeholder="Loading owners"
    :options="[]"
    skeleton
/>
```

Use this component API instead of hand-building select controls in feature views.

### 4.2. API surfaces

| API surface               | Installed value                                                                                              |
| ------------------------- | ------------------------------------------------------------------------------------------------------------ |
| Blade API                 | `x-ui.select`                                                                                                |
| Dedicated Blade component | Installed public API backed by native `<select>` behavior                                                    |
| JavaScript                | No dedicated JavaScript controller required for installed native select behavior                             |
| Root semantic element     | Native `<select>`                                                                                            |
| Data attributes           | `data-ui-component="select"`, `data-ui-select-field`, `data-ui-select`                                      |
| CSS namespace             | `ui-select*` plus shared `ui-field*` classes documented in this standard                                     |
| Source files              | `resources/views/components/ui/select.blade.php`; `resources/css/components/select.css`; `/platform/ui-reference/components/select` |

### 4.3. Prop and option contract

| Option/attribute       | Type                         | Default       | Allowed values             | Required                        | Notes                                                                                      |
| ---------------------- | ---------------------------- | ------------- | -------------------------- | ------------------------------- | ------------------------------------------------------------------------------------------ |
| `id`                   | `string / null`              | generated     | Unique DOM ID              | No                              | Generated from `name` when omitted.                                                        |
| `name`                 | `string`                     | none          | Laravel field name         | Yes                             | Submitted value key.                                                                       |
| `label`                | `string`                     | none          | Short concrete noun phrase | Yes                             | Visible label associated to the field.                                                     |
| `helper` / `helperText`| `string / null`              | null          | Short guidance copy        | No                              | Replaced by error or warning copy while active.                                            |
| `value` / `defaultValue` | `string / int / null`      | null          | One scalar value           | No                              | Select stores one scalar value, not an array.                                              |
| `size`                 | `string`                     | `md`          | `xs`, `sm`, `md`, `lg`     | No                              | Default and inline select field height.                                                   |
| `variant` / `inline`   | `string / bool`              | `default`     | `default`, `inline`        | No                              | Inline is a real compact variant with Select-owned value, spacing, and chevron behavior.  |
| `style`                | `string`                     | `default`     | `default`, `fluid`         | No                              | Fluid renders the 64px expressive field treatment with the full shell owning the field background and border. |
| `noLabel`              | `bool`                       | `false`       | true/false                 | No                              | Suppresses Select-owned visible label and supporting copy for compound contexts that own the visible label externally. Must preserve an accessible name through `aria-label` or `aria-labelledby`. |
| `hideLabel`            | `bool`                       | `false`       | true/false                 | No                              | Keeps the label in the DOM for screen readers while visually hiding it.                   |
| `required`             | `bool`                       | `false`       | true/false                 | No                              | Use when a non-empty value is required.                                                    |
| `disabled`             | `bool`                       | `false`       | true/false                 | No                              | Use when the field is unavailable.                                                         |
| `readonly` / `readOnly`| `bool`                       | `false`       | true/false                 | No                              | Renders a non-interactive value summary plus hidden value.                                |
| `invalid`              | `bool`                       | `false`       | true/false                 | No                              | Adds error state when paired with `invalidText`.                                          |
| `invalidText` / `error`| `string / null`              | null          | Actionable error message   | No                              | Emits `aria-invalid="true"` and associated message.                                       |
| `warn`                 | `bool`                       | `false`       | true/false                 | No                              | Adds warning state when paired with `warnText`.                                           |
| `warnText` / `warning` | `string / null`              | null          | Non-blocking warning       | No                              | Warning does not emit `aria-invalid`.                                                     |
| `skeleton`             | `bool`                       | `false`       | true/false                 | No                              | Disables the select, marks wrapper busy, and exposes loading status copy.                 |
| `placeholder`          | `string / null`              | null          | Empty prompt option        | No                              | Use when no default value should be selected.                                             |
| `options`              | `array`                      | `[]`          | option objects             | No                              | Renders native `option` elements. Supports `value`, `text` / `label`, `disabled`, `hidden`, and `className`. |
| `optionGroups`         | `array / null`               | null          | group objects              | No                              | Renders native `optgroup` elements. Supports `label`, `disabled`, `className`, and child `options`. |
| Option value           | `string / int`               | none          | Stable app value           | Yes for each option             | Values must map to server validation.                                                      |
| Option label           | text                         | none          | Short visible label        | Yes for each option             | Avoid long or repeated-leading labels.                                                     |
| `optgroup`             | HTML element                 | none          | Labeled option group       | Optional                        | Use sparingly for short grouped lists.                                                     |
| `multiple`             | boolean attribute            | not supported | none                       | Not applicable                  | Not part of this component API. Use Checkbox or future Multi-select/Combobox.              |
| `readonly`             | not valid                    | not supported | none                       | Not applicable                  | Render a read-only value summary instead.                                                  |

Any option not listed here is not public. If a feature needs another option, update the component implementation, this standard, and UI Reference proof before use.

### 4.4. Installed class contract

| Class                       | Status      | Purpose                                                 |
| --------------------------- | ----------- | ------------------------------------------------------- |
| `.ui-field`                 | Implemented | App field wrapper shared by input components.           |
| `.ui-select-field`          | Implemented | Root select field namespace.                            |
| `.ui-select-field-sm/md/lg` | Implemented | Default select size modifiers.                          |
| `.ui-select-field-xs`       | Implemented | Extra-small 24px select size modifier.                  |
| `.ui-select-field-inline`   | Implemented | Borderless inline select treatment with Select-owned value and chevron spacing. |
| `.ui-select-field-no-label` | Implemented | Compound-context mode where an external label/context owns the visible wording. |
| `.ui-select-field-hidden-label` | Implemented | Visually hidden label mode.                        |
| `.ui-select-field-fluid`    | Implemented | 64px fluid select treatment where the full shell owns the field surface. |
| `.ui-select-field-invalid`  | Implemented | Blocking validation wrapper state.                      |
| `.ui-select-field-warning`  | Implemented | Non-blocking warning wrapper state.                     |
| `.ui-select-field-disabled` | Implemented | Wrapper state paired with native `disabled`.            |
| `.ui-select-field-readonly` | Implemented | Non-interactive value summary state.                    |
| `.ui-select-field-skeleton` | Implemented | Pending options state paired with `aria-busy="true"`.   |
| `.ui-select-shell`          | Implemented | Native select, chevron, and status-icon positioning wrapper. |
| `.ui-field-label`           | Implemented | Visible label text.                                     |
| `.ui-field-helper`          | Implemented | Helper/instruction copy.                                |
| `.ui-select`                | Implemented | Native select styling hook.                             |
| `.ui-field-error`           | Implemented | Error copy referenced by `aria-describedby`.            |
| `.ui-field-warning`         | Implemented | Warning copy referenced by `aria-describedby`.          |
| `.ui-select-status-icon`    | Implemented | Error/warning status icon hook.                         |
| `.ui-select-chevron-icon`   | Implemented | Approved outline chevron icon hook.                     |
| `.ui-select-readonly-value` | Implemented | Read-only value summary.                                |

### 4.4.1. Inline select spacing

Inline select is not default select with `display: inline`. It keeps native select behavior while Select owns the compact value and chevron anatomy.

Required inline sequence:

```text
[16px left padding] value [8px gap] 16px chevron [16px right padding]
```

- The native select keeps `appearance: none`.
- The Select component renders exactly one `.ui-select-chevron-icon`.
- The chevron is 16px by 16px and non-interactive.
- Consumers must not append local SVG chevrons, text glyphs, CSS triangles, or pagination-specific select icons.
- `noLabel` removes Select-owned label layout and supporting copy for compound components; it still requires `aria-label` or `aria-labelledby`.
- `hideLabel` keeps the label accessible while visually hiding it.

### 4.5. Option data contract

When a view assembles options in PHP, pass a simple option array into `x-ui.select`. The component renders native options.

```blade
@php
    $statusOptions = [
        ['value' => 'active', 'label' => 'Active'],
        ['value' => 'suspended', 'label' => 'Suspended'],
        ['value' => 'archived', 'label' => 'Archived'],
    ];
@endphp

<x-ui.select
    id="status"
    name="status"
    label="Status"
    placeholder="Choose a status"
    :options="$statusOptions"
    :value="old('status')"
/>
```

| Field      | Type            | Required | Notes                                                                                |
| ---------- | --------------- | -------- | ------------------------------------------------------------------------------------ |
| `value`    | `string / int`  | Yes      | Stable submitted value validated by the server.                                      |
| `text` / `label` | `string`   | Yes      | Visible option text. Keep concise.                                                   |
| `disabled` | `bool`          | No       | Use only when an option may become available later. Hide impossible options.         |
| `hidden`   | `bool`          | No       | Hide the option from the option list while preserving the data shape.                |
| `className` | `string`       | No       | Optional option hook when required by a proof or migration.                          |
| `options`  | `array / null`  | No       | Child option array for native `optgroup` rendering when grouping improves scanning.  |
| `selected` | `bool`          | No       | Usually derive from model value or `old()` rather than storing in the option source. |

## 5. Allowed variants, options, and modifiers

| Name                    | Type         | Status                   | API                                                                                                        | Notes                                                               |
| ----------------------- | ------------ | ------------------------ | ---------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------- |
| Short native selection  | Variant      | Implemented              | `<x-ui.select>`                                                                                             | Installed default. Use for short known lists.                       |
| Small select            | Size         | Implemented              | `size="sm"`                                                                                                 | 32px default field height.                                         |
| Medium select           | Size         | Implemented              | `size="md"`                                                                                                 | Default 40px field height.                                         |
| Large select            | Size         | Implemented              | `size="lg"`                                                                                                 | 48px default field height.                                         |
| Extra-small select      | Size         | Implemented              | `size="xs"`                                                                                                 | 24px compact field height.                                        |
| Inline select           | Variant      | Implemented              | `variant="inline"` or `inline`                                                                              | Lower visual weight for compact form contexts with exact 16/8/16 chevron spacing. |
| Fluid select            | Style        | Implemented              | `style="fluid"`                                                                                             | 64px expressive field treatment.                                   |
| Required select         | Option/state | Implemented              | `required`                                                                                                 | Pair with helper/error copy when needed.                            |
| Prompt option           | Composition  | Implemented              | Empty first `<option>`                                                                                     | Use to avoid preselecting a meaningful value.                       |
| Disabled prompt option  | Composition  | Implemented with caution | `<option value="" disabled>`                                                                               | Use only when the form provides a valid way forward.                |
| Grouped options         | Composition  | Implemented              | `optgroup`                                                                                                 | Use sparingly for short grouped lists.                              |
| Hidden option           | Composition  | Implemented              | option `hidden: true`                                                                                       | Use when an option should not be listed.                            |
| Disabled option         | Composition  | Implemented              | option `disabled: true`                                                                                     | Use when an option is visible but not selectable.                   |
| Disabled group          | Composition  | Implemented              | option group `disabled: true`                                                                               | Disables every option in the group.                                 |
| Hidden label            | Label mode   | Implemented              | `hide-label`                                                                                                | Label remains screen-reader available.                              |
| No-label mode           | Label mode   | Implemented              | `no-label aria-label="..."`                                                                                 | For compound components that own visible label/context externally.  |
| Helper text             | Composition  | Implemented              | `.ui-field-helper` and `aria-describedby`                                                                  | Explain what the selection affects.                                 |
| Error validation        | State        | Implemented              | `invalid`, `invalid-text`, message ID, `aria-invalid="true"`                                               | Blocking invalid state.                                             |
| Warning validation      | State        | Implemented              | `warn`, `warn-text`, message ID                                                                             | Non-blocking guidance. Do not set `aria-invalid`.                   |
| Disabled                | State        | Implemented              | `disabled` and optional `.ui-field-disabled`                                                               | Prevents interaction and submission where browser behavior applies. |
| Read-only summary       | State/mode   | Implemented              | `readonly` / `readOnly`                                                                                    | Render value text plus hidden value without an interactive select.  |
| Loading/pending options | State        | Implemented              | `skeleton`, `aria-busy="true"`, disabled select, status copy                                               | Use only while options are unavailable.                             |
| Compact density         | Gated        | Pattern-owned            | none                                                                                                       | Requires Forms/Table toolbar proof if introduced.                   |
| Multi-select            | Deferred     | none                     | Use Checkbox group or future Multi-select/Combobox API. Do not use native `multiple` under this component. |                                                                     |
| Searchable select       | Deferred     | none                     | Requires Combobox/Listbox API, JavaScript owner, keyboard contract, and tests.                             |                                                                     |
| Async remote options    | Deferred     | none                     | Requires loading/error/retry and state-management contract.                                                |                                                                     |
| Custom dropdown chrome  | Not allowed  | none                     | Native select satisfies installed workflow.                                                                |                                                                     |
| Menu-as-select          | Not allowed  | none                     | Menu is for actions, not form values.                                                                      |                                                                     |

## 6. States

| State              | Status                         | Implementation requirement                                                                                  |
| ------------------ | ------------------------------ | ----------------------------------------------------------------------------------------------------------- |
| Default            | Implemented                    | Renders visible label, optional helper text, and native select.                                             |
| Hover-capable      | Implemented where supported    | Browser/native select hover and token-backed field chrome may expose hover.                                 |
| Focus-visible      | Implemented                    | Native select receives visible focus in all supported themes.                                               |
| Open               | Browser-owned                  | Native select popup/list behavior is browser and OS owned. Do not style as custom open state.               |
| Selected value     | Implemented                    | Current value is represented by native selected option.                                                     |
| Empty/prompt       | Implemented                    | Optional empty first option represents no chosen value.                                                     |
| Helper             | Implemented                    | Helper copy is visible and referenced by `aria-describedby`.                                                |
| Error              | Implemented                    | Blocking error uses `.ui-field-error`, `aria-invalid="true"`, and error message ID.                         |
| Warning            | Implemented                    | Non-blocking warning uses `.ui-field-warning` and warning message ID without `aria-invalid`.                |
| Disabled           | Implemented                    | Native `disabled` prevents selection changes.                                                               |
| Read-only          | Implemented as summary         | Render non-interactive value summary. Do not use invalid `readonly` attribute.                              |
| Loading            | Implemented                    | Wrapper uses `aria-busy="true"`, select is disabled, and visible status copy is provided.                   |
| Skeleton/loading   | Implemented                    | `skeleton` disables the select, marks the wrapper busy, and exposes loading status copy.                    |
| Success            | Not applicable                 | Successful form submission belongs to Notification/Inline feedback or the parent Pattern.                   |
| Active/pressed     | Browser-owned                  | Native select activation is handled by browser/OS. Do not create static pressed styling.                    |
| Overflow/truncated | Implemented with content rules | Avoid long labels. Rare truncation must preserve full value through approved title/help text.               |
| Validation pending | Pattern-owned                  | Server/client validation timing belongs to Forms Pattern. Select only renders final state.                  |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Select consumes Foundation Color, Spacing, Typography, Themes, and Icons.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Icons.

Motion and Grid are not directly owned by native Select. Parent Patterns may use Grid for field layout, and browser/OS select popups own their own motion. Do not add custom animated select panels.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                     |
| ----------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Field label, select text, placeholder/prompt text, border, background, focus, helper, warning, error, disabled, and status roles. |
| Spacing     | Label/helper/control/message gaps, select padding, and option-group surrounding field spacing.                                    |
| Typography  | Label, helper, select value, option text as browser permits, warning, error, status, and read-only value text.                    |
| Themes      | Light and dark token resolution for default, disabled, warning, error, focus, loading, and read-only states.                      |
| Icons       | Component-owned chevron indicator only where styling can safely enhance the native select without replacing semantics.            |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$field`, `$field-hover` | Select field background and hover state | `ui-select`, `ui-select-shell`, `ui-field`, `--ui-field`, `--ui-field-hover` | App field palette | Same role / app value | Default select uses the field surface on the native control; fluid select uses the full shell as the field surface. |
| `$border-strong`, `$border-subtle` | Default field border-bottom, fluid shell border, and read-only border | `ui-select` / `ui-select-shell` border role | App border palette | Same role / app value | Select must not define local border colors. Inline select is intentionally borderless. |
| `$text-primary`, `$text-secondary`, `$text-helper`, `$text-disabled` | Select value, label, helper, and disabled text | `ui-select`, `ui-field-*` text roles | App text palette | Same role / app value | Browser option rendering may be OS-owned; the visible control uses app roles. |
| `$icon-primary`, `$icon-disabled` | Select chevron/icon states | `ui-select-chevron-icon` / chevron role | App icon palette | Same role / app value | Icons must use approved Heroicons/app icon wrappers and inherit currentColor where possible. |
| `$support-error`, `$text-error`, `$support-warning` | Invalid/warning border, icon, and message roles | Field validation state classes | App status palette | Same role / app value | Validation mapping is shared across field components. |
| `$focus` | Focus field border/ring | `ui-select:focus-visible`, `ui-select-shell:focus-within`, `--ui-focus` | App focus palette | Same role / app value | Default focus is applied to the native control; fluid focus is applied to the full shell. Error focus uses the error support role. |
| `transparent` | Inline select field background and border | `variant="inline"` | Component variant rule | Adopted for installed inline select | Inline select is borderless and lower visual weight; do not implement inline select styling ad hoc in feature views. |
| `$ai-border-strong` | AI select presence | No baseline select role until AI variant is approved | None | Not adopted | AI tokens remain gated. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-field
.ui-field-label
.ui-field-helper
.ui-field-error
.ui-field-warning
.ui-select-field
.ui-select-field-sm
.ui-select-field-md
.ui-select-field-lg
.ui-select-field-inline
.ui-select-field-fluid
.ui-select-field-invalid
.ui-select-field-warning
.ui-select-field-disabled
.ui-select-field-readonly
.ui-select-field-skeleton
.ui-select-shell
.ui-select
.ui-select-status-icon
.ui-select-chevron-icon
.ui-select-readonly-value
```

Feature views must not create local `select-*`, `dropdown-*`, `combobox-*`, Bootstrap `.form-select` classes, raw utility clusters, arbitrary colors, arbitrary spacing, custom focus rings, local SVG icons, or feature-local JavaScript for the same UI role.

## 8. Composition rules

- Select must be composed as a field, not as an unlabeled standalone control.
- The input ID and visible label `for` value must match.
- Helper, warning, error, and status copy must use stable IDs referenced by `aria-describedby`.
- Use a prompt option when there is no safe default.
- Do not preselect a meaningful value unless it is a real saved value, a safe default, or a Pattern-approved workflow default.
- Use `required` when the current form cannot submit without a valid selection.
- Server validation must match rendered option values.
- Disabled select fields must not be used to hide required choices. Explain why a value cannot be changed when needed.
- Read-only selects must render value text instead of an interactive select.
- Loading selects must be disabled and paired with visible status copy.
- Use `optgroup` only for short lists where grouping improves scanning.
- Do not use native `multiple` under this component API.
- Do not put actions inside options. Options are values, not commands.
- Do not use Select as navigation unless a Pattern explicitly owns navigation-on-change behavior.
- Parent Forms and Pattern APIs own grouping, external spacing, submit/cancel controls, responsive layout, and workflow orchestration.
- Components own internal field semantics, labels, helper/error associations, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- The user must choose one value from a short, known list.
- The list is stable enough to render with the page.
- Native browser/mobile select behavior is acceptable and preferred.
- The choice is a form value that will be saved, submitted, filtered, or used to update app data.
- A placeholder-like prompt, helper text, validation message, disabled state, or read-only value summary is needed.

### 9.2. Do not use when:

- The user must choose more than one value. Use Checkbox group or a future Multi-select/Combobox API.
- The list is long enough to need search, autocomplete, paging, or grouping beyond simple `optgroup` sections.
- The options are actions. Use Menu.
- The options are mutually exclusive visible choices and should remain exposed. Use Radio button.
- The choice is binary. Use Checkbox or Toggle depending on workflow semantics.
- The user needs to type a custom value. Use Text input or a future Combobox API.
- The selection controls navigation rather than a form value, unless a Pattern explicitly owns that behavior.
- The workflow requires custom dropdown visuals. Native select is the installed API.

### 9.3. Selection matrix:

| Need                                                                | Use                                           |
| ------------------------------------------------------------------- | --------------------------------------------- |
| One value from a short known list                                   | Select                                        |
| One value from two to five visible options where comparison matters | Radio button                                  |
| Multiple independent choices                                        | Checkbox group                                |
| Binary on/off setting                                               | Toggle or Checkbox depending on semantics     |
| Long/searchable option set                                          | Deferred Combobox/Searchable select API       |
| Contextual actions                                                  | Menu                                          |
| Navigation list                                                     | Navigation, Tabs, or Pattern-owned navigation |
| Read-only selected value                                            | Read-only Select summary                      |

## 10. Accessibility contract

- Use native `<select>` for installed selection behavior.
- Provide a visible label for every select.
- Associate the label with the select using `for` and `id`.
- Do not rely on placeholder/prompt option text as the only label.
- Expose helper, warning, error, and loading/status copy through `aria-describedby`.
- Use `aria-invalid="true"` only when the current value is invalid and blocks submission.
- Warning states must not use `aria-invalid`.
- Required selects must communicate requiredness through the visible label/copy and native `required` attribute where applicable.
- Disabled selects must use the native `disabled` attribute.
- Read-only mode must not expose an enabled select.
- Loading mode must expose pending status and prevent interaction while options are unavailable.
- Focus-visible treatment must be visible in all supported themes.
- Meaning must not rely on color alone for error, warning, disabled, selected, or loading states.
- Native browser keyboard behavior must remain intact.
- Do not replace the native select with custom listbox markup unless a future component standard owns full keyboard and assistive-technology behavior.
- Avoid very long option names and repeated leading words that make option scanning difficult.
- Options must not contain headings, links, buttons, checkboxes, or other interactive content.

## 11. Content contract

- Use sentence case.
- Use concrete field labels: `Tenant status`, `Role`, `Billing cycle`, `Workspace owner`.
- Use prompt copy that starts with a verb when no value is selected: `Choose a status`, `Select a role`.
- Keep helper text short and focused on what the choice affects.
- Keep option labels concise.
- Avoid repeating the same leading word across most options. Move the shared term to the field label or group label.
- Use option labels that match user-facing domain language, not database constants.
- Error messages must be actionable: `Choose a role before saving.`
- Warning messages must explain risk or context without implying the value is invalid.
- Read-only values should show the user-facing selected label, not the raw stored value.
- Do not use vague labels such as `Type`, `Option`, `Dropdown`, or `Select` when a specific noun is available.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, custom focus rings, or custom JavaScript.
- Do not create feature-local select, dropdown, combobox, or listbox components for the same UI role.
- Do not use Bootstrap `.form-select` classes or direct Carbon production classes in app markup.
- Do not rely on prompt option text as the only label.
- Do not use custom field chrome when the native control satisfies the workflow.
- Do not use Menu as a replacement for Select.
- Do not use Select for contextual actions.
- Do not use native `multiple` under this component API.
- Do not put links, buttons, headings, checkboxes, icons with meaning, or rich markup inside options.
- Do not use disabled options for permission-impossible values; hide unavailable values unless temporary unavailability needs explanation.
- Do not use invalid `readonly` attributes on selects.
- Do not render enabled selects in read-only contexts.
- Do not create local loading spinners or skeletons inside select controls.
- Do not create navigation-on-change behavior without Pattern approval.
- Do not present custom dropdown, searchable select, async option loading, or multiselect examples as installed API.

## 13. Deferred or gated capabilities

| Capability                           | Status                                        | Gate                                                                                                                         |
| ------------------------------------ | --------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| Compact/table-toolbar select         | Gated                                         | Requires Table toolbar or Filters Pattern proof for density, label visibility, and responsive behavior.                      |
| Multi-select                         | Deferred                                      | Requires dedicated component/API, selected-item display, keyboard behavior, error states, and tests.                         |
| Searchable select / Combobox         | Deferred                                      | Requires JavaScript owner, text input/listbox semantics, keyboard behavior, async/no-results states, and UI Reference proof. |
| Async/remote options                 | Deferred                                      | Requires loading, error, retry, empty, stale-data, and focus behavior contracts.                                             |
| Custom dropdown chrome               | Not allowed until a separate API is installed | Native select remains the production API.                                                                                    |
| Select-as-navigation                 | Gated                                         | Requires Pattern ownership, change confirmation rules when destructive, and keyboard/screen-reader behavior proof.           |
| Arbitrary sizes                      | Not allowed                                   | Requires Spacing, Typography, and UI Reference updates.                                                                      |
| Direct Carbon implementation classes | Not allowed                                   | Login App keeps app-owned Blade/markup, CSS, and `ui-*` classes.                                                             |

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

The Select page is a baseline input component reference page. The Live examples card should use grouped field examples, state matrices, and implementation examples rather than fake custom dropdowns.

### 15.1. Required Live examples internal sections:

| Required proof           | Rendered behavior                                                                                                                                                                      | Variants/options shown                                                                 |
| ------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------- |
| Default option behavior  | Native select proves empty default option, first-option default, and custom default value behavior without custom JavaScript.                                                           | Empty default option, First option default, Custom default option                       |
| Variants                 | Default, inline, inline no-label, fluid, and skeleton examples show the installed field treatments. Inline owns compact value/chevron spacing and fluid owns the full field background. | Default, Inline with label/helper, Inline `noLabel`, Fluid, Skeleton                    |
| Sizes                    | Select renders all supported component sizes.                                                                                                                                          | Extra small, Small, Medium, Large                                                      |
| States                   | Required state examples render with native disabled/read-only output, message IDs, and accessibility attributes.                                                                        | Enabled, Disabled, Read-only, Invalid, Warning, Skeleton                                |
| Options and groups       | Option examples prove native option disabling, hidden options, and option groups without custom menu behavior.                                                                          | Disabled option, Hidden option, Enabled option group, Disabled option group             |
| Label behavior           | Label examples distinguish visible label, visually hidden label, and externally owned label modes.                                                                                     | Visible label, `hideLabel`, `noLabel` with `aria-label`                                 |
| Developer implementation | Canonical `x-ui.select` calls and option array rendering examples appear as real code.                                                                                                 | `x-ui.select`, native `select`, `ui-*` classes, `required`, `aria-describedby`, `aria-invalid` |
| Deferred alternatives    | Page shows searchable select, multiselect, async options, and custom dropdown chrome as deferred/gated, with approved alternatives.                                                    | Deferred gates, Combobox alternative, Checkbox/Radio/Menu alternatives                  |
| Prohibited usage         | Page shows forbidden placeholder-only labels, menu-as-select, native `multiple`, custom dropdown JavaScript, Bootstrap/Carbon classes, and invalid read-only select usage as not allowed. | Prohibited examples and approved corrections                                           |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered states, options/modifiers, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/select` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- Select examples use `x-ui.select` and render native `<select>` markup with `.ui-select-field` and `.ui-select` classes.
- Every rendered labeled select field has a label associated through `for` and `id`.
- `hideLabel` keeps the associated label in the DOM while visually hiding it.
- `noLabel` suppresses Select-owned label and supporting copy only when an accessible name is supplied through `aria-label` or `aria-labelledby`.
- Select chevrons use exactly one `.ui-select-chevron-icon` with the approved 16px outline chevron icon, not CSS triangle backgrounds or consumer-provided icons.
- Inline select is borderless and follows the required `[16px left padding] value [8px gap] 16px chevron [16px right padding]` sequence.
- Fluid select applies background, border, hover, and focus treatment to the full `.ui-select-shell` surface.
- Helper, warning, error, and status copy are associated through `aria-describedby`.
- Error examples include `aria-invalid="true"` and warning examples do not.
- Required examples include the native `required` attribute where applicable.
- Disabled examples include the native `disabled` attribute.
- Disabled and hidden option examples use native option attributes; grouped option examples use native `optgroup`, including disabled groups where appropriate.
- Read-only examples render a value summary and do not render an enabled select.
- Loading examples use `aria-busy="true"`, visible status copy, and disabled select behavior.
- Grouped option examples use native `optgroup` and remain short.
- Deferred examples render trigger conditions instead of fake custom dropdown, multiselect, searchable select, async option, or combobox controls.
- Developer examples call `<x-ui.select>` for the installed public API.
- The page contains no generic placeholder content.
- Tests assert stale labels and legacy scaffolding remain absent when they are not part of approved UI copy.
- Tests assert no raw Bootstrap `.form-select`, hard-coded color, arbitrary local spacing, feature-local select/dropdown class system, custom JavaScript select controller, native `multiple` example, or direct Carbon production class is presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/select');

$response->assertOk();
$response->assertSee('Select');
$response->assertSee('ui-select-field');
$response->assertSee('ui-select');
$response->assertSee('<select', false);
$response->assertSee('Short native selection');
$response->assertSee('Validation selection');
$response->assertSee('Disabled/read-only');
$response->assertSee('Loading/pending options');
$response->assertSee('Grouped options');
$response->assertSee('aria-describedby');
$response->assertSee('aria-invalid="true"', false);
$response->assertSee('aria-busy="true"', false);
$response->assertSee('required');
$response->assertSee('disabled');
$response->assertSee('optgroup');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('<li>None.</li>', false);
$response->assertDontSee('Use only documented props/options');
$response->assertDontSee('See UI Reference developer implementation section');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('form-select');
$response->assertDontSee('dropdown-menu');
$response->assertDontSee('multiple');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 17. Related APIs

| API                  | Route                                                            |
| -------------------- | ---------------------------------------------------------------- |
| Text input           | `/platform/ui-reference/components/text-input`                   |
| Checkbox             | `/platform/ui-reference/components/checkbox`                     |
| Radio button         | `/platform/ui-reference/components/radio-button`                 |
| Toggle               | `/platform/ui-reference/components/toggle`                       |
| Menu                 | `/platform/ui-reference/components/menu`                         |
| Button               | `/platform/ui-reference/components/button`                       |
| Forms pattern        | `/platform/ui-reference/patterns/forms`                          |
| Tables Pattern       | `/platform/ui-reference/patterns/tables`                         |
| Navigation Pattern   | `/platform/ui-reference/patterns/navigation`                     |
| Color element        | `/platform/ui-reference/elements/color`                          |
| Spacing element      | `/platform/ui-reference/elements/spacing`                        |
| Typography element   | `/platform/ui-reference/elements/typography`                     |
| Themes element       | `/platform/ui-reference/elements/themes`                         |
| Icons element        | `/platform/ui-reference/elements/icons`                          |
| Components overview  | `/platform/ui-reference/components`                              |
| Canonical select doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fselect.md` |
| Carbon select usage  | `https://carbondesignsystem.com/components/select/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Select and Dropdown usage/style/accessibility guidance inform native selection states, validation/read-only handling, option content guidance, and the boundary between native Select, Dropdown, Multiselect, and Combobox behavior. Login App keeps its own native Blade composition, server-validation expectations, app-owned `ui-*` class contract, and UI Reference proof.

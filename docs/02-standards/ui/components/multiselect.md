---
title: Multiselect
slug: multiselect
api_layer: Component API
status: implemented-standard
system_maturity: implemented
category: inputs
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/multiselect
canonical_doc: docs/02-standards/ui/components/multiselect.md
source_owner: /platform/ui-reference/components/multiselect
blade_api:
  - x-ui.multiselect
javascript_api: []
source_files:
  - resources/views/components/ui/multiselect.blade.php
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
  - dropdown
  - select
  - checkbox
  - tag
  - search
  - text-input
  - form-field
related_patterns:
  - forms
  - navigation
  - filters
carbon_reference:
  - https://carbondesignsystem.com/components/dropdown/usage/
  - https://carbondesignsystem.com/components/tag/usage/
---

# Multiselect Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
  - [4.4. Option data contract](#44-option-data-contract)
  - [4.5. Component-owned data attributes](#45-component-owned-data-attributes)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Allowed token roles](#71-allowed-token-roles)
  - [7.2. CSS namespace](#72-css-namespace)
  - [7.3. Helper and composition usage](#73-helper-and-composition-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Use approved alternatives:](#92-use-approved-alternatives)
  - [9.3. Do not use when:](#93-do-not-use-when)
- [10. Accessibility contract](#10-accessibility-contract)
  - [10.1. Minimum keyboard expectations:](#101-minimum-keyboard-expectations)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. UI Reference requirements](#14-ui-reference-requirements)
  - [14.1. Required Live examples internal sections:](#141-required-live-examples-internal-sections)
- [15. Testing and acceptance criteria](#15-testing-and-acceptance-criteria)
  - [15.1. Suggested automated assertions:](#151-suggested-automated-assertions)
- [16. Related APIs](#16-related-apis)
- [17. References](#17-references)

## 1. API summary

Multiselect lets users choose multiple values from a known option set through one canonical, accessible, token-backed input API.

Canonical API owner: `/platform/ui-reference/components/multiselect`. Use this Component API instead of creating local markup, styling, selected-value tags, filtering behavior, hidden-input serialization, or keyboard handling for the same UI role.

Multiselect is the installed Login App 2.0 multi-value known-option selection API. It owns field structure, visible label association, trigger behavior, open and closed states, option selection and deselection, selected-value display, selected-count summary, optional filtering, optional clear-all behavior, disabled and read-only states, validation handoff, keyboard behavior, focus management, hidden form serialization, and token-backed states. It does not own business rules, data permissions, remote option fetching policy, table-selection orchestration, filter-chip persistence, navigation state, or page-level workflow branching.

### 1.1. Canonical API responsibilities:

- Render multi-value known-option selection through `x-ui.multiselect`.
- Preserve a visible field label and accessible name.
- Render selected values as approved text, tag, or count summary treatment.
- Support known option data with values, labels, selected state, disabled state, and optional descriptions.
- Support open, closed, selected, unselected, disabled, read-only, invalid, warning, loading, empty, overflow, and responsive states.
- Support optional filtering when the option set is too large for simple scanning.
- Serialize selected values for form submission.
- Keep keyboard, pointer, focus, and screen-reader behavior owned by the component.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, icons, and 2x Grid where composed in layouts.
- Prove default, filterable, selected-value, validation, disabled/read-only, empty/loading, keyboard, and developer implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Small always-visible multi-selection. Use Checkbox groups when the option set is short enough to show directly.
- Single selection. Use Select, Dropdown, Radio button, or Combo box when only one value may be selected.
- Free-text custom value entry. Use a future Combo box or token/tagging Pattern when installed.
- Table row selection or bulk action selection. Use Data table and Table toolbar Patterns.
- Filter-chip persistence and query-state orchestration. Use Filters/Search results Patterns.
- Remote data loading policy, permissions, stale options, and business validation. Feature modules and parent Patterns own those concerns.
- External spacing, grouping, and page layout. Parent Patterns own placement.

## 2. Status and ownership

| Field                        | Value                                                                                                                            |
| ---------------------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented standard                                                                                                             |
| System maturity              | Implemented                                                                                                                      |
| API layer                    | Component API                                                                                                                    |
| Component slug               | multiselect                                                                                                                      |
| Category                     | Inputs                                                                                                                           |
| Priority                     | Tier B - Common reusable component                                                                                               |
| UI Reference route           | `/platform/ui-reference/components/multiselect`                                                                                  |
| Canonical doc                | `docs/02-standards/ui/components/multiselect.md`                                                                                 |
| Source owner                 | `/platform/ui-reference/components/multiselect`                                                                                  |
| Blade API                    | `x-ui.multiselect`                                                                                                               |
| JavaScript API               | No dedicated public JavaScript controller required for feature views                                                             |
| Source files                 | `resources/views/components/ui/multiselect.blade.php`; `resources/css/app.css`                                                   |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid where composed in layouts                                             |
| Carbon benchmark             | Carbon Dropdown/Multiselect and Tag guidance inform scope, option behavior, selected-value display, and accessibility boundaries |

`Implemented standard` means the canonical Component API is approved for production use. Feature teams must use `x-ui.multiselect` for multi-value known-option selection instead of creating feature-local dropdown/listbox/tag compositions.

## 3. Installed standard

Multiselect is installed for production workflows where users must select more than one value from a known option set and a visible Checkbox group would be too long, too dense, or too disruptive to the form layout.

The installed standard is:

- Render multiselect fields through `<x-ui.multiselect>`.
- Use Checkbox groups instead when all options are short enough to remain visible and scan-friendly.
- Use `name` and `options` for every form-bound multiselect.
- Provide a visible `label`; placeholder text must not replace the label.
- Use `value` to pass selected values.
- Use `filterable` when the option set needs in-field filtering.
- Use `clearable` only when clearing all selected values is safe and expected.
- Use `selectAll` only when batch selection is clear and does not create unexpected permissions or workflow consequences.
- Use Tag composition or count summary only through the component-owned selected-value display.
- Keep selected-value overflow summarized by the component.
- Use `disabled` when the field cannot be operated.
- Use `readonly` when selected values should remain visible but cannot be changed.
- Use `error`, `warning`, and `helper` through the field API, not local message markup.
- Use `loading` and `emptyMessage` only when the component or parent state owner has a documented loading/empty option state.
- Do not place buttons, links, nested menus, form fields, or complex controls inside options.
- Do not combine local Dropdown, Checkbox, Search, Tag, hidden inputs, and JavaScript to create a feature-owned multiselect.

Carbon alignment note: Carbon treats multiselect as part of the dropdown/listbox family and uses tag behavior for selected values in some contexts. Login App maps those ideas to its own `x-ui.multiselect` API, app-owned `ui-*` classes, Foundation tokens, and UI Reference proof instead of adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical calls

```blade
<x-ui.multiselect
    name="teams"
    label="Teams"
    :options="$teamOptions"
    :value="$selectedTeamIds"
    helper="Choose one or more teams that can access this workspace."
/>
```

```blade
<x-ui.multiselect
    name="roles"
    label="Roles"
    :options="$roleOptions"
    :value="old('roles', $selectedRoleIds)"
    placeholder="Choose roles"
    filterable
    clearable
/>
```

```blade
<x-ui.multiselect
    name="markets"
    label="Markets"
    :options="$marketOptions"
    :value="$selectedMarkets"
    selected-display="tags"
    :max-visible-tags="3"
/>
```

```blade
<x-ui.multiselect
    name="departments"
    label="Departments"
    :options="$departmentOptions"
    :value="$selectedDepartments"
    error="Choose at least one department."
    required
/>
```

Use the Blade API instead of hand-building multiselect trigger, listbox, selected tags, option filtering, hidden inputs, or removal controls in feature views.

### 4.2. API surfaces

| API surface           | Installed value                                                                                                                                                    |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Blade API             | `x-ui.multiselect`                                                                                                                                                 |
| JavaScript            | No dedicated public JavaScript controller required for feature views. Any open/close, filtering, keyboard, selection, and tag-removal behavior is component-owned. |
| Root semantic element | Component-owned field wrapper with labelled trigger and option list/listbox semantics                                                                              |
| Data attributes       | Component-owned attributes documented below. Feature views must not invent multiselect behavior attributes.                                                        |
| CSS namespace         | App-owned `ui-*` multiselect classes documented by the implementation                                                                                              |
| Source files          | `resources/views/components/ui/multiselect.blade.php`; `resources/css/app.css`                                                                                     |

### 4.3. Props and options

| Prop/option                            | Type     | Default                               | Allowed values                        | Required                        | Notes                                                                                                                             |
| -------------------------------------- | -------- | ------------------------------------- | ------------------------------------- | ------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| `name`                                 | `string` | none                                  | Valid form field name                 | Yes                             | Used for selected-value serialization. Multi-value fields should serialize as an array according to the component implementation. |
| `id`                                   | `string / null`                              | generated from `name`                 | Valid unique ID                 | No                              | Required when external labels, hints, or tests need stable references.                                                  |
| `label`                                | `string` | none                                  | Short visible label                   | Yes                             | Placeholder must not replace the label.                                                                                           |
| `options`                              | `array`  | `[]`                                  | Option data contract documented below | Yes                             | Known option set. Do not pass complex interactive content.                                                                        |
| `value`                                | `array`  | `[]`                                  | Selected option values                | No                              | Preselected/current values. Values must match option values unless stale-value handling is Pattern-owned.                         |
| `placeholder`                          | `string` | `Choose options` or installed default | Short prompt                          | No                              | Displayed only when no values are selected.                                                                                       |
| `helper`                               | `string / null`                              | `null`                                | Short helper text               | No                              | Use for persistent guidance.                                                                                            |
| `error`                                | `string / null`                              | `null`                                | Short validation error          | No                              | Marks invalid state and associates error copy with the field.                                                           |
| `warning`                              | `string / null`                              | `null`                                | Short warning text              | No                              | Use only when the Forms Pattern allows warning state without blocking submission.                                       |
| `required`                             | `bool`   | `false`                               | `true`, `false`                       | No                              | Communicates required state according to Forms Pattern.                                                                           |
| `disabled`                             | `bool`   | `false`                               | `true`, `false`                       | No                              | Field cannot open or change values.                                                                                               |
| `readonly`                             | `bool`   | `false`                               | `true`, `false`                       | No                              | Selected values remain visible but cannot be changed.                                                                             |
| `filterable`                           | `bool`   | `false`                               | `true`, `false`                       | No                              | Adds component-owned option filtering when option count requires it.                                                              |
| `clearable`                            | `bool`   | `false`                               | `true`, `false`                       | No                              | Adds clear-all control when safe. Must be keyboard reachable and labelled.                                                        |
| `selectAll` / `select-all`             | `bool`   | `false`                               | `true`, `false`                       | No                              | Adds batch selection when approved by the workflow.                                                                               |
| `selectedDisplay` / `selected-display` | `string` | `summary`                             | `summary`, `tags`, `inline`           | No                              | Controls component-owned selected-value display.                                                                                  |
| `maxVisibleTags` / `max-visible-tags`  | `int / null`                                 | `3` when tags are used                | Positive integer                | No                              | Summarizes overflow selected tags.                                                                                      |
| `loading`                              | `bool`   | `false`                               | `true`, `false`                       | No                              | Use when options are being loaded by the owning state.                                                                            |
| `emptyMessage` / `empty-message`       | `string` | `No options available`                | Short empty-state copy                | No                              | Used when no options exist or filtering returns no matches.                                                                       |
| `class`                                | `string / null`                              | `null`                                | Layout passthrough if supported | No                              | Parent Patterns may pass placement classes only. Do not use for local color, state, option, tag, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.4. Option data contract

```php
$options = [
    [
        'value' => 'admin',
        'label' => 'Administrator',
        'selected' => false,
        'disabled' => false,
        'description' => 'Can manage workspace settings.',
    ],
];
```

| Field         | Type     | Required | Rule                                                                                                      |
| ------------- | -------- | -------- | --------------------------------------------------------------------------------------------------------- |
| `value`       | `string / int`  | Yes                                                                                                       | Stable submitted value. Must be unique in the option set.                    |
| `label`       | `string` | Yes      | Visible option label. Keep short and scannable.                                                           |
| `selected`    | `bool`   | No       | May be used when `value` prop is not the only selected-state source. Prefer `value` for controlled usage. |
| `disabled`    | `bool`   | No       | Disabled option cannot be selected or deselected.                                                         |
| `description` | `string / null` | No                                                                                                        | Optional short supporting text. Do not use paragraphs or interactive markup. |
| `group`       | `string / null` | Gated                                                                                                     | Option grouping requires UI Reference proof before production use.           |

### 4.5. Component-owned data attributes

| Data attribute                    | Status                   | Owner     | Purpose                                                                                                |
| --------------------------------- | ------------------------ | --------- | ------------------------------------------------------------------------------------------------------ |
| `data-ui-component="multiselect"` | Implemented when emitted | Component | Identifies the root component for testing and diagnostics.                                             |
| `data-ui-multiselect-trigger`     | Implemented when emitted | Component | Identifies the trigger/control surface.                                                                |
| `data-ui-multiselect-menu`        | Implemented when emitted | Component | Identifies the option list surface.                                                                    |
| `data-ui-multiselect-option`      | Implemented when emitted | Component | Identifies selectable options.                                                                         |
| `data-ui-multiselect-value`       | Implemented when emitted | Component | Identifies selected-value display.                                                                     |
| `data-ui-multiselect-filter`      | Implemented when emitted | Component | Identifies component-owned filter input.                                                               |
| `data-ui-multiselect-clear`       | Implemented when emitted | Component | Identifies clear-all control.                                                                          |
| Feature-local data attributes     | Not allowed              | none      | Do not create local multiselect state, filtering, keyboard, loading, or selection behavior attributes. |

## 5. Allowed variants, options, and modifiers

| Name                      | Type             | Status                          | API                          | Notes                                                                      |
| ------------------------- | ---------------- | ------------------------------- | ---------------------------- | -------------------------------------------------------------------------- |
| Default multiselect       | Variant          | Implemented                     | `x-ui.multiselect`           | Multi-value known-option field.                                            |
| Filterable multiselect    | Variant/modifier | Implemented                     | `filterable`                 | Use for larger option sets where users need search within the field.       |
| Summary selected display  | Modifier         | Implemented                     | `selected-display="summary"` | Shows compact selected count/summary.                                      |
| Tag selected display      | Modifier         | Implemented                     | `selected-display="tags"`    | Shows selected values as component-owned tags with overflow summary.       |
| Inline selected display   | Modifier         | Implemented                     | `selected-display="inline"`  | Shows selected labels as inline text where space is controlled.            |
| Clear all                 | Modifier         | Implemented                     | `clearable`                  | Requires safe workflow and labelled control.                               |
| Select all                | Modifier         | Implemented / workflow-gated    | `selectAll`                  | Use only when batch selection is expected and safe.                        |
| Disabled field            | State            | Implemented                     | `disabled`                   | Field cannot open or change values.                                        |
| Disabled option           | State option     | Implemented                     | option `disabled: true`      | Option cannot be selected or deselected.                                   |
| Read-only selected values | State            | Implemented                     | `readonly`                   | Shows selected values without edit affordances.                            |
| Validation error          | State            | Implemented                     | `error="..."`                | Form invalid state.                                                        |
| Warning                   | State            | Implemented / Pattern-gated     | `warning="..."`              | Use only when Forms Pattern allows warning state.                          |
| Loading options           | State            | Implemented / state-owner-gated | `loading`                    | Use when options are loading.                                              |
| Empty/no options          | State            | Implemented                     | `emptyMessage`               | Shows no-options or no-results state.                                      |
| Option groups             | Capability       | Gated                           | option `group`               | Requires grouping semantics and UI Reference proof.                        |
| Async remote loading      | Capability       | Gated                           | parent state + `loading`     | Requires loading, stale-value, retry, and error policy.                    |
| Custom value entry        | Boundary         | Not owned                       | none                         | Use future Combo box/tagging Pattern.                                      |
| Rich option content       | Boundary         | Not allowed                     | none                         | Do not place headings, buttons, links, or complex controls inside options. |
| AI presence               | Boundary         | Not implemented                 | none                         | Requires approved AI label and feature standard.                           |

## 6. States

| State                          | Status                               | Implementation requirement                                                                                     |
| ------------------------------ | ------------------------------------ | -------------------------------------------------------------------------------------------------------------- |
| Closed                         | Implemented                          | Trigger displays selected-value summary and opens menu when activated.                                         |
| Open                           | Implemented                          | Menu/listbox displays options, filter if enabled, and selected states.                                         |
| Unselected option              | Implemented                          | Option is available and not selected.                                                                          |
| Selected option                | Implemented                          | Option is selected and clearly indicated by text, icon, checkbox semantics, or component-owned selected state. |
| Mixed/select-all indeterminate | Implemented when `selectAll` is used | Select-all control communicates partial selection.                                                             |
| Hover                          | Implemented                          | Token-backed pointer affordance for trigger, options, tags, clear, and removal controls where applicable.      |
| Focus-visible                  | Implemented                          | Trigger, filter input, options, selected tags, clear controls, and remove controls show visible focus.         |
| Active/pressed                 | Implemented                          | Trigger, option, clear, and remove controls expose active state.                                               |
| Disabled field                 | Implemented                          | Field cannot open or change selected values.                                                                   |
| Disabled option                | Implemented                          | Disabled option cannot be selected or deselected.                                                              |
| Read-only                      | Implemented                          | Selected values are visible but cannot be changed.                                                             |
| Error                          | Implemented                          | Field has validation error with visible and programmatic message.                                              |
| Warning                        | Implemented / Pattern-gated          | Field has warning message without blocking submission unless Pattern rules require it.                         |
| Loading                        | Implemented                          | Option surface communicates pending options and prevents incomplete selection behavior.                        |
| Empty/no options               | Implemented                          | Shows no-options or no-results copy without implying custom values are allowed.                                |
| Overflow selected values       | Implemented                          | Selected tags or labels collapse to a count/summary without losing accessible meaning.                         |
| Responsive                     | Implemented                          | Trigger, tags, filter, menu, and options remain usable at small widths.                                        |
| Reduced motion                 | Implemented                          | Menu open/close and selected-value removal motion respects reduced-motion preferences.                         |
| Success                        | Not applicable                       | Success belongs to form/workflow feedback.                                                                     |
| Validation summary             | Pattern-owned                        | Forms Pattern owns validation summary placement; Multiselect owns field-level state.                           |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Multiselect consumes approved Foundation Elements through documented Component API classes.

Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.
- 2x Grid where composed in Forms, Filters, and Navigation Patterns.

### 7.1. Allowed token roles

| Element API | Allowed usage                                                                                                                       |
| ----------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Field surface, menu surface, border, selected state, focus, validation, disabled, loading, empty, tag, text, and icon states.       |
| Spacing     | Field padding, trigger gap, tag gap, menu padding, option padding, filter spacing, helper/error spacing, and responsive wrapping.   |
| Typography  | Label, placeholder, selected-value summary, option label, option description, helper, error, warning, no-results, and loading copy. |
| Themes      | Light, dark, layered, and inverse token resolution for field, menu, tags, selected options, disabled state, and validation.         |
| Motion      | Menu open/close, tag removal, loading transitions, and reduced-motion fallback.                                                     |
| Icons       | Disclosure, check, clear, remove, selected, warning, and error icons through the Icons Element.                                     |
| 2x Grid     | Parent-owned form/filter/navigation layout placement.                                                                               |

### 7.2. CSS namespace

Allowed component classes must use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-multiselect
.ui-multiselect__field
.ui-multiselect__label
.ui-multiselect__trigger
.ui-multiselect__value
.ui-multiselect__tags
.ui-multiselect__tag
.ui-multiselect__clear
.ui-multiselect__menu
.ui-multiselect__filter
.ui-multiselect__list
.ui-multiselect__option
.ui-multiselect__option-description
.ui-multiselect__helper
.ui-multiselect__error
.ui-multiselect__warning
.ui-multiselect--open
.ui-multiselect--disabled
.ui-multiselect--readonly
.ui-multiselect--invalid
.ui-multiselect--warning
.ui-multiselect--loading
.ui-multiselect--empty
.ui-multiselect--filterable
```

Feature views must not create local multiselect classes, direct Carbon production classes, Bootstrap dropdown classes, raw utility clusters, arbitrary colors, custom focus rings, local selected-tag classes, local hidden-input serializers, or custom JavaScript for the same UI role.

### 7.3. Helper and composition usage

| Helper/API                 | Status                      | Allowed usage                                                                                                                    |
| -------------------------- | --------------------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| `x-ui.multiselect`         | Implemented                 | Canonical multi-value known-option field API.                                                                                    |
| Tag                        | Component-owned composition | Selected-value tags when `selected-display="tags"` is used. Feature views do not render the tags manually.                       |
| Checkbox semantics         | Component-owned composition | Option selected state where the component uses checkbox-like semantics. Feature views do not compose option checkboxes manually. |
| Search/Text input behavior | Component-owned composition | Filter input when `filterable` is used. Feature views do not add a separate local search field inside the menu.                  |
| Forms Pattern              | Pattern-owned               | Field layout, validation summary, submit lifecycle, and grouped form behavior.                                                   |
| Filters Pattern            | Pattern-owned               | Query-state persistence and selected filter display outside the field.                                                           |

## 8. Composition rules

- Use Multiselect when users must choose more than one known option and a Checkbox group would be too long or disruptive.
- Use Checkbox groups when the option set is short and should remain fully visible.
- Use Select, Dropdown, or Radio button when only one value may be selected.
- Use Combo box/tagging Pattern when users must create custom values.
- Use visible labels for every multiselect field.
- Keep placeholders as prompts only; never use placeholder as the only label.
- Keep option labels short and avoid complex option content.
- Use option descriptions only when the label alone does not distinguish choices.
- Keep selected-value tags/removal behavior component-owned.
- Keep filter behavior component-owned when `filterable` is enabled.
- Keep clear-all and select-all behavior explicit and safe for the workflow.
- Preserve selected values through validation failures.
- Do not nest buttons, links, forms, menus, tooltips, or popovers inside options.
- Do not combine Dropdown, Checkbox, Tag, Search, hidden inputs, and local JavaScript to recreate Multiselect in feature views.
- Components own internal semantics, selection behavior, selected-value display, filtering, validation state, focus, keyboard behavior, and token-backed states.
- Parent Patterns own grouping, external spacing, workflow orchestration, filter/query state, remote loading policy, and page-level layout.

## 9. Selection guidance

### 9.1. Use when:

- Users must choose multiple values from a known option set.
- A Checkbox group would be too large or would make the form difficult to scan.
- Users need to see selected values summarized in one field.
- Users need to filter the known option set before selecting values.
- A form must submit multiple selected values through one field.
- A settings, permissions, roles, teams, categories, or filter workflow needs reusable multi-value selection.

### 9.2. Use approved alternatives:

| Need                                           | Use                              |
| ---------------------------------------------- | -------------------------------- |
| Small visible set with multiple choices        | Checkbox group                   |
| Exactly one visible choice from a small set    | Radio button group               |
| Exactly one known option from a longer set     | Dropdown or Select               |
| Native single-selection form/mobile control    | Select                           |
| Query entry without persisted option selection | Search or Text input             |
| Selected filters outside a field               | Tag plus Filters Pattern         |
| Bulk table row selection                       | Data table/Table toolbar Pattern |

### 9.3. Do not use when:

- All options can be shown clearly as a Checkbox group.
- The user must enter a custom value.
- Only one value can be selected.
- The menu would need nested controls, links, buttons, or complex row layouts.
- Selection behavior affects bulk table actions.
- The implementation would be local to one feature and not reusable as the canonical Component API.

## 10. Accessibility contract

- Every Multiselect must have a visible label.
- Placeholder text must not be the only accessible name.
- The trigger must expose an accessible name and open/closed state.
- The menu/listbox must expose option semantics owned by the component.
- Selected state must be announced for each option.
- Filter input semantics must be clear when `filterable` is enabled.
- Keyboard users must be able to open, close, navigate, select, deselect, clear, and remove selected values without pointer input.
- Escape closes the menu and returns focus without losing existing selections.
- Tab order must be predictable for trigger, filter field, options, selected tags, clear controls, and remove controls.
- Selected-value count and tag removal must be clear to screen readers.
- Disabled options must not be selectable or deselectable.
- Read-only fields must not imply that values can be changed.
- Error and warning messages must be programmatically associated with the field.
- Selected, error, warning, disabled, loading, and empty states must not rely on color alone.
- Menu open/close and selected-value removal motion must respect reduced-motion preferences.
- Contrast must hold in supported light, dark, layered, and inverse contexts.
- Filtering must announce empty/no-results state where applicable.
- Async option loading requires a Pattern-owned announcement, stale-value, retry, and error policy before use.

### 10.1. Minimum keyboard expectations:

| Interaction        | Requirement                                                                                            |
| ------------------ | ------------------------------------------------------------------------------------------------------ |
| Tab                | Reaches the field/trigger and required internal controls in predictable order.                         |
| Enter / Space      | Opens the control and toggles focused options where appropriate.                                       |
| Arrow keys         | Navigate available options when the menu is open.                                                      |
| Escape             | Closes the menu and returns focus without losing existing selections.                                  |
| Backspace / Delete | Removes a selected tag only when a tag/removal model is active and the tag/removal control is focused. |

## 11. Content contract

- Use sentence case labels.
- Use concrete nouns for field labels, such as `Teams`, `Roles`, `Categories`, or `Allowed domains`.
- Do not use placeholder text as the only label.
- Keep option labels short and scannable.
- Use option descriptions only when needed to distinguish similar choices.
- Avoid repeating the same first word across many options when grouping or clearer labels would help.
- Do not place paragraphs, links, headings, buttons, or complex interactive content inside options.
- Selected-value summaries must be clear, such as `3 teams selected`, not vague copy like `Multiple selected`.
- Use clear empty messages, such as `No roles found` or `No options available`.
- Error and warning copy must be short and actionable.
- Empty/no-results copy must not imply that users can create custom values unless a Combo box/tagging API is approved.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, selected-value tags, or custom JavaScript.
- Do not combine Dropdown, Checkbox, Search, Tag, hidden inputs, and local JavaScript into an unowned multiselect.
- Do not use Multiselect for two-option choices.
- Do not use Multiselect when a visible Checkbox group is clearer.
- Do not use Multiselect for single-selection choices.
- Do not use Multiselect for free-text custom value entry unless a Combo box/tagging Pattern is approved.
- Do not put interactive controls, links, nested menus, or forms inside options.
- Do not fake async option loading without loading, empty, error, retry, and stale-value rules.
- Do not create local selected-value chips/tags outside the component.
- Do not create local keyboard behavior for Arrow keys, Escape, Enter, Space, Backspace, or Delete.
- Do not use direct Carbon production class names such as `cds--multi-select`, `cds--list-box`, `bx--multi-select`, or `bx--list-box`.
- Do not link to deprecated `docs/02-standards/ui/components/tier-1/multiselect.md` or `docs/02-standards/ui/components/tier-2/multiselect.md` canonical paths.

## 13. Deferred or gated capabilities

| Capability                   | Status          | Gate                                                                                                                      |
| ---------------------------- | --------------- | ------------------------------------------------------------------------------------------------------------------------- |
| Option groups                | Gated           | Requires group semantics, keyboard behavior, screen-reader proof, visual grouping rules, and UI Reference proof.          |
| Async remote option loading  | Gated           | Requires loading, empty, error, retry, stale-value, announcement, debounce, and cancellation policy.                      |
| Custom value entry           | Not owned       | Use future Combo box/tagging Pattern. Do not add custom entry to Multiselect by default.                                  |
| Rich option content          | Not allowed     | Requires a separate option/content Pattern; basic Multiselect options stay text-first.                                    |
| Virtualized options          | Deferred        | Requires keyboard, screen-reader, active-descendant, scroll, and performance proof.                                       |
| Inline Multiselect style     | Deferred        | Requires Form Field and layout proof before use.                                                                          |
| AI presence                  | Not implemented | Requires approved AI-assisted feature, AI label API, explainability copy, and accessibility review.                       |
| Local JavaScript initializer | Deferred        | Feature views do not call an initializer. A public initializer requires documented lifecycle, events, cleanup, and tests. |

Future extensions require an updated Component standard and UI Reference proof before production use.

## 14. UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Multiselect page is a broad input component reference. The Live examples card should use a grouped matrix/scenario layout that proves default selection, filtering, selected-value display, validation, disabled/read-only behavior, loading/empty states, and developer implementation.

### 14.1. Required Live examples internal sections:

| Required proof           | Rendered behavior                                                                                                                                                        | Variants/options shown                                                                     |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------ |
| Default multiselect      | Renders a labelled multiselect with known options, selected and unselected states, helper text, and form serialization note.                                             | Default, Closed, Open, Selected, Unselected, Helper                                        |
| Filterable multiselect   | Renders filter input inside the component-owned menu and proves no-results behavior.                                                                                     | `filterable`, Empty/no results, Keyboard focus                                             |
| Selected-value display   | Shows summary, tag, inline, and overflow selected-value behavior.                                                                                                        | `selected-display`, `maxVisibleTags`, Overflow summary                                     |
| Clear and select all     | Shows safe clear-all and select-all behavior with accessible labels and mixed state where applicable.                                                                    | `clearable`, `selectAll`, Mixed state                                                      |
| Validation states        | Shows required, error, warning, helper, and preserved selected values after validation.                                                                                  | Required, Error, Warning, Helper                                                           |
| Disabled and read-only   | Shows disabled field, disabled option, and read-only selected values.                                                                                                    | Disabled field, Disabled option, Read-only                                                 |
| Loading and empty        | Shows option loading, no options, and no filtered results without fake async behavior.                                                                                   | Loading, Empty, No results                                                                 |
| Accessibility matrix     | Proves visible label, accessible trigger, open/closed state, selected-state announcement, keyboard operation, Escape behavior, focus-visible states, and reduced motion. | Label, `aria-expanded`, Selected state, Focus-visible, Escape, Reduced motion              |
| Composition alternatives | Shows when Checkbox group, Select, Dropdown, Radio button, Search, Text input, Tag, or Filters Pattern is the better choice.                                             | Alternatives and boundaries                                                                |
| Developer implementation | Canonical calls and props render as real code examples.                                                                                                                  | `x-ui.multiselect`, `options`, `value`, `filterable`, `selected-display`, validation props |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered variants, rendered states, allowed options, prohibited usage, deferred/gated capabilities, and Foundation Elements consumed.

## 15. Testing and acceptance criteria

- `/platform/ui-reference/components/multiselect` returns 200 for authorized users.
- The page shows status `Implemented standard` and does not describe Multiselect as deferred.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and consumed Foundation Elements.
- Implemented APIs render production examples; deferred/gated APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The default example renders through `x-ui.multiselect`.
- The filterable example renders component-owned filtering behavior and no-results state.
- Selected-value examples show summary, tags, inline display, and overflow summary.
- Validation examples show required, error, warning, and helper text.
- Disabled/read-only examples show disabled field, disabled option, and read-only selected values.
- Loading/empty examples show loading, no options, and no filtered results.
- Accessibility examples prove label, open/closed state, selected state, keyboard behavior, Escape behavior, focus-visible states, and reduced motion.
- Developer examples use `x-ui.multiselect`, not placeholder comments or ad hoc markup.
- No generic placeholder content appears.

### 15.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/multiselect');

$response->assertOk();
$response->assertSee('Multiselect');
$response->assertSee('Implemented standard');
$response->assertSee('x-ui.multiselect');
$response->assertSee('filterable');
$response->assertSee('selected-display="tags"');
$response->assertSee('clearable');
$response->assertSee('selectAll');
$response->assertSee('disabled');
$response->assertSee('readonly');
$response->assertSee('No roles found');
$response->assertSee('3 teams selected');
$response->assertSee('aria-expanded');
$response->assertSee('Escape');
$response->assertSee('Checkbox group');
$response->assertDontSee('Component-specific API ' . 'pending correction');
$response->assertDontSee('No production public API is approved');
$response->assertDontSee('Future API candidate');
$response->assertDontSee('Deferred: no production API approved');
$response->assertDontSee('Live Examples ' . 'Card');
$response->assertDontSee('Reference ' . 'Examples');
$response->assertDontSee('Legacy Contract ' . 'Summary');
$response->assertDontSee('components/tier-1/multiselect.md');
$response->assertDontSee('components/tier-2/multiselect.md');
$response->assertDontSee('cds' . '--');
$response->assertDontSee('bx' . '--');
$response->assertDontSee('TODO');
$response->assertDontSee('Generic ' . 'fallback');
```

## 16. Related APIs

| API                       | Route                                                                 |
| ------------------------- | --------------------------------------------------------------------- |
| Checkbox                  | `/platform/ui-reference/components/checkbox`                          |
| Dropdown                  | `/platform/ui-reference/components/dropdown`                          |
| Select                    | `/platform/ui-reference/components/select`                            |
| Radio button              | `/platform/ui-reference/components/radio-button`                      |
| Tag                       | `/platform/ui-reference/components/tag`                               |
| Search                    | `/platform/ui-reference/components/search`                            |
| Text input                | `/platform/ui-reference/components/text-input`                        |
| Form field planned gap    | `components/form-field` is not routed; use `/platform/ui-reference/patterns/forms` until an owner is approved |
| Forms pattern             | `/platform/ui-reference/patterns/forms`                               |
| Navigation pattern        | `/platform/ui-reference/patterns/navigation`                          |
| Filters/search pattern    | `/platform/ui-reference/patterns/navigation`; table-owned filtering uses `/platform/ui-reference/patterns/tables` |
| Components overview       | `/platform/ui-reference/components`                                   |
| Canonical multiselect doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fmultiselect.md` |

## 17. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Dropdown usage identifies Dropdown, Multiselect, and Combo box as related selection variants. Login App implements Multiselect through its own Blade API, app-owned classes, and token-backed UI Reference proof.
- Carbon Dropdown accessibility guidance informs the trigger/listbox/focus/keyboarding requirements. Login App owns its own implementation and accessibility proof.
- Carbon Tag guidance informs the selected-value tag/overflow boundary. Feature views must not create selected-value chips locally outside the approved Multiselect API.
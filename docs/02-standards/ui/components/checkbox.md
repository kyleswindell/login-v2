---
title: Checkbox
slug: checkbox
api_layer: Component API
status: implemented-pending-review
system_maturity: implemented
category: selection-controls
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/checkbox
canonical_doc: docs/02-standards/ui/components/checkbox.md
source_owner: /platform/ui-reference/components/checkbox
blade_api:
  - x-ui.checkbox
  - x-ui.checkbox-group
javascript_api:
  - initCheckboxes
source_files:
  - resources/views/components/ui/checkbox.blade.php
  - resources/views/components/ui/checkbox-group.blade.php
  - resources/js/ui-controls/checkboxes.js
  - resources/js/ui-controls.js
  - resources/js/app.js
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - radio-button
  - toggle
  - select
  - dropdown
  - multiselect
  - data-table
  - inline-loading
  - notification
related_patterns:
  - forms
  - tables
  - filtering
carbon_reference:
  - https://carbondesignsystem.com/components/checkbox/usage/
  - https://carbondesignsystem.com/components/checkbox/style/
  - https://carbondesignsystem.com/components/checkbox/accessibility/
---

# Checkbox Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options: `x-ui.checkbox`](#43-props-and-options-x-uicheckbox)
  - [4.4. Props and options: `x-ui.checkbox-group`](#44-props-and-options-x-uicheckbox-group)
  - [4.5. Option data contract](#45-option-data-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Token usage](#72-token-usage)
  - [7.3. CSS namespace](#73-css-namespace)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
  - [15.1. Required component contract display](#151-required-component-contract-display)
  - [15.2. The UI Reference page must show:](#152-the-ui-reference-page-must-show)
  - [15.3. Required developer examples](#153-required-developer-examples)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Checkbox supports independent choices and multi-select groups.

Canonical API owner: `/platform/ui-reference/components/checkbox`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Checkbox is the installed Login App 2.0 selection-control API for zero-or-more choice sets. It owns native checkbox semantics, group semantics, labels, helper/error/warning text, selected/unselected state, indeterminate parent state, disabled/read-only treatment, focus styling, token-backed validation states, and checkbox-specific content rules. It does not own single-choice selection, immediate setting toggles, hidden option menus, table bulk-selection workflows, or form layout orchestration.

### 1.1. Canonical API responsibilities:

- Render independent choices through the installed checkbox API.
- Render visible zero-or-more choice groups through the installed checkbox-group API.
- Preserve native checkbox semantics and label click behavior.
- Support selected, unselected, and indeterminate state where the parent-child selection model requires it.
- Do not apply a visual hover treatment to the checkbox control; hover may only preserve the normal pointer affordance.
- Support component and group-level disabled, read-only, error, warning, and helper text treatments.
- Keep group labels, helper text, validation text, and item labels accessible.
- Use Foundation Element APIs for color, spacing, typography, themes, motion, and icons.
- Prove independent, grouped, settings, validation, and indeterminate usage on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Single-choice selection. Use Radio button.
- Immediate on/off settings that apply without submit. Use Toggle.
- Compact native option selection. Use Select.
- Known-option custom selection or handoff. Use Dropdown.
- Searchable multi-value selection with tag display. Use Multiselect only when that API is installed and approved.
- Data table row selection and bulk action orchestration. Use Data table and Table toolbar Patterns.
- Form layout, field grouping around unrelated controls, and submit/cancel placement. Use the Forms Pattern.
- External spacing. Parent Patterns own placement and surrounding layout rhythm.

## 2. Status and ownership

| Field                        | Value                                                                                                                                 |
| ---------------------------- | ------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                                          |
| System maturity              | Partial                                                                                                                               |
| API layer                    | Component API                                                                                                                         |
| Component slug               | checkbox                                                                                                                              |
| Category                     | Selection controls                                                                                                                    |
| Priority                     | Tier A - Baseline app development                                                                                                     |
| UI Reference route           | `/platform/ui-reference/components/checkbox`                                                                                          |
| Canonical doc                | `docs/02-standards/ui/components/checkbox.md`                                                                                         |
| Source owner                 | `/platform/ui-reference/components/checkbox`                                                                                          |
| Blade API                    | `x-ui.checkbox`; `x-ui.checkbox-group`                                                                                                |
| JavaScript API               | None required for baseline selected/unselected behavior                                                                               |
| Source files                 | `resources/views/components/ui/checkbox.blade.php`; `resources/views/components/ui/checkbox-group.blade.php`; `resources/js/ui-controls/checkboxes.js`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons where validation/status icons are rendered                                          |
| Carbon benchmark             | Carbon Checkbox usage, style, and accessibility guidance                                                                              |

`Implemented Pending Review` means the checkbox UI is installed as a real zero-or-more selection API and is awaiting manual UI Reference approval.

## 3. Installed standard

Checkbox now has component-specific UI Reference examples that consume approved Foundation Elements.

### The installed standard is:

- Use `<x-ui.checkbox>` for a single independent checkbox.
- Use `<x-ui.checkbox-group>` when two or more related choices share one group label, helper text, validation message, disabled state, read-only state, or warning state.
- Use native `<input type="checkbox">` semantics wherever possible.
- Use a visible text label for every checkbox.
- Use a group label for related checkbox sets unless a larger visible fieldset or Form Pattern already provides an equivalent group label.
- Use the checked state when the option is selected.
- Use the unchecked state when the option is not selected.
- Use the indeterminate state only for parent-child selection relationships or bulk-selection summaries where some, but not all, child choices are selected.
- Use vertical stacking by default for groups.
- Use horizontal groups only for short, predictable option sets where scan order remains clear.
- Place helper, warning, and error copy at the group level when the message applies to the whole set.
- Render group helper, warning, and error copy below the option list so the message reads as group support rather than an option label.
- Keep external spacing owned by the parent Pattern.
- Do not build custom checkbox visuals, raw utility clusters, local validation colors, or one-off JavaScript state handling in feature views.

Carbon alignment note: Carbon defines Checkbox for multiple selections, not mutually exclusive selection; supports unselected, selected, indeterminate, focus, disabled, read-only, error, warning, and group-level states; recommends vertical group alignment when possible; and distinguishes Checkbox from Radio button and Toggle. Login App maps those principles to its own `x-ui.checkbox` and `x-ui.checkbox-group` APIs rather than adopting Carbon implementation classes directly, and treats hover as non-visual for the checkbox control.

## 4. Public API

### 4.1. Canonical calls

```blade
<x-ui.checkbox
    name="notifications[]"
    value="security"
    label="Security alerts"
    checked
/>
```

```blade
<x-ui.checkbox-group
    name="notification_channels"
    legend="Notification channels"
    :options="$notificationChannels"
    :selected="$selectedChannels"
    helper="Choose every channel this workspace may use."
/>
```

```blade
<x-ui.checkbox
    name="terms"
    value="accepted"
    label="I accept the terms"
    required
    error="You must accept the terms before continuing."
/>
```

```blade
<x-ui.checkbox
    name="permissions_parent"
    value="all"
    label="All permissions"
    indeterminate
    aria-describedby="permissions-helper"
/>
```

Use the Blade APIs instead of hand-building checkbox markup in feature views.

### 4.2. API surfaces

| API surface                   | Installed value                                                                                                                                                                                                                                                                     |
| ----------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Individual checkbox Blade API | `x-ui.checkbox`                                                                                                                                                                                                                                                                     |
| Checkbox group Blade API      | `x-ui.checkbox-group`                                                                                                                                                                                                                                                               |
| JavaScript                    | No dedicated JavaScript controller is required for baseline selected/unselected behavior. Indeterminate rendering must be handled by the component implementation or an approved initializer because the native `indeterminate` property is not persisted by plain HTML attributes. |
| Root semantic element         | Native checkbox input with associated label                                                                                                                                                                                                                                         |
| Group semantic element        | `fieldset` with `legend` for related groups when the component owns the group label                                                                                                                                                                                                 |
| Data attributes               | Use only data attributes documented by the Component API. Feature views must not invent checkbox behavior attributes.                                                                                                                                                               |
| CSS namespace                 | App-owned `ui-*` checkbox classes documented by the component implementation                                                                                                                                                                                                        |
| Source files                  | `resources/views/components/ui/checkbox.blade.php`; `resources/views/components/ui/checkbox-group.blade.php`; `resources/css/app.css`                                                                                                                                               |

If either Blade alias is not currently installed, this correction must add it or explicitly mark it deferred before the UI Reference page can be accepted. Do not leave the page with `Component-specific API pending correction` as its developer example.

### 4.3. Props and options: `x-ui.checkbox`

| Prop/option     | Type                  | Default   | Allowed values                  | Required | Notes                                                                                                                       |
| --------------- | --------------------- | --------- | ------------------------------- | -------- | --------------------------------------------------------------------------------------------------------------------------- |
| `name`          | `string`              | required  | valid form field name           | Yes      | Use array names such as `features[]` for multi-select groups when needed.                                                   |
| `id`            | `string / null`       | generated | valid unique HTML id            | No       | Must be unique when provided.                                                                                               |
| `value`         | `string / int / bool` | `1`       | submitted field value           | No       | Use explicit values for groups.                                                                                             |
| `label`         | `string`              | required  | short visible label             | Yes      | Every checkbox needs a label in the UI and in code.                                                                         |
| `checked`       | `bool`                | `false`   | `true`, `false`                 | No       | Represents selected state.                                                                                                  |
| `indeterminate` | `bool`                | `false`   | `true`, `false`                 | No       | Only for parent/child or bulk-selection summary state. Must expose mixed state accessibly.                                  |
| `disabled`      | `bool`                | `false`   | `true`, `false`                 | No       | Disabled checkboxes are unavailable and should not submit changed values.                                                   |
| `readonly`      | `bool`                | `false`   | `true`, `false`                 | No       | Use for non-editable displayed value when the value should remain perceivable. Confirm implementation semantics before use. |
| `required`      | `bool`                | `false`   | `true`, `false`                 | No       | Most required logic should be validated by the owning form.                                                                 |
| `helper`        | `string / null`       | `null`    | short helper text               | No       | Use for item-specific helper text only. Prefer group-level helper text for groups.                                          |
| `error`         | `string / null`       | `null`    | validation copy                 | No       | Applies invalid treatment and error copy.                                                                                   |
| `warning`       | `string / null`       | `null`    | warning copy                    | No       | Applies warning treatment without blocking form submission.                                                                 |
| `description`   | `string / null`       | `null`    | short supporting copy           | No       | Use sparingly; long explanations belong in visible content or Toggletip.                                                    |
| `class`         | `string / null`       | `null`    | layout passthrough if supported | No       | Parent Patterns may pass layout classes. Do not use for local color, typography, state, or behavior overrides.              |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.4. Props and options: `x-ui.checkbox-group`

| Prop/option   | Type            | Default                             | Allowed values           | Required | Notes                                                                      |
| ------------- | --------------- | ----------------------------------- | ------------------------ | -------- | -------------------------------------------------------------------------- |
| `name`        | `string`        | required                            | valid form field name    | Yes      | Use a shared name for related options.                                     |
| `legend`      | `string`        | required unless externally labelled | short group label        | Usually  | Required when the group owns its label.                                    |
| `options`     | `array`         | required                            | option objects or arrays | Yes      | Each option must include label and value.                                  |
| `selected`    | `array`         | `[]`                                | selected values          | No       | Controls checked values.                                                   |
| `orientation` | `string`        | `vertical`                          | `vertical`, `horizontal` | No       | Vertical is default. Horizontal is only for short predictable sets.        |
| `helper`      | `string / null` | `null`                              | short group helper copy  | No       | Group-level helper text.                                                   |
| `error`       | `string / null` | `null`                              | group validation copy    | No       | Applies error state to the group.                                          |
| `warning`     | `string / null` | `null`                              | group warning copy       | No       | Applies warning state to the group.                                        |
| `disabled`    | `bool`          | `false`                             | `true`, `false`          | No       | Disables every option unless an option explicitly owns a stricter state.   |
| `readonly`    | `bool`          | `false`                             | `true`, `false`          | No       | Makes the group non-editable while preserving readable choices.            |
| `required`    | `bool`          | `false`                             | `true`, `false`          | No       | Use when at least one option is required and the owning form validates it. |
| `nested`      | `bool`          | `false`                             | `true`, `false`          | No       | Only for approved parent/child option structures.                          |

### 4.5. Option data contract

```php
$options = [
    [
        'label' => 'Security alerts',
        'value' => 'security',
        'helper' => 'Recommended for every administrator.',
        'disabled' => false,
    ],
    [
        'label' => 'Billing updates',
        'value' => 'billing',
    ],
];
```

| Option key | Required | Notes                                                                                   |
| ---------- | -------- | --------------------------------------------------------------------------------------- |
| `label`    | Yes      | Visible label. Keep concise and sentence case.                                          |
| `value`    | Yes      | Submitted value.                                                                        |
| `checked`  | No       | May be used by individual checkbox rendering, but group `selected` should be preferred. |
| `disabled` | No       | Option-level disabled state.                                                            |
| `readonly` | No       | Option-level read-only state when supported.                                            |
| `helper`   | No       | Short item-specific helper text. Avoid long descriptions.                               |
| `children` | No       | Only for approved nested parent/child groups.                                           |

## 5. Allowed variants, options, and modifiers

Checkbox does not have app-approved decorative visual variants. The installed API supports selection modes, group structures, validation treatments, and state modifiers.

| Name                       | Type           | Status                                                          | API                                 | Use when                                                                 |
| -------------------------- | -------------- | --------------------------------------------------------------- | ----------------------------------- | ------------------------------------------------------------------------ |
| Independent checkbox       | Usage mode     | Implemented / required proof                                    | `x-ui.checkbox`                     | One choice can be selected independently of nearby controls.             |
| Multi-select group         | Usage mode     | Implemented / required proof                                    | `x-ui.checkbox-group`               | Users can select zero, one, or many options from a visible set.          |
| Validation group           | Usage mode     | Implemented / required proof                                    | `error`, `warning`, `required`      | A form needs group-level validation or warning copy.                     |
| Group states               | Usage mode     | Implemented / required proof                                    | `helper`, `disabled`, `readonly`, `error`, `warning` | Group state applies to all relevant options with one group message. |
| Parent/child indeterminate | State/modifier | Implemented / required proof                                    | nested option `children`; `initCheckboxes` | Parent summary represents selected children and owns the mixed state. |
| Vertical group             | Layout option  | Implemented                                                     | `orientation="vertical"`            | Default group layout for readability.                                    |
| Horizontal group           | Layout option  | Implemented only when proven; otherwise Deferred                | `orientation="horizontal"`          | Short predictable sets where row order remains clear.                    |
| AI label presence          | Modifier       | Deferred / gated                                                | Not public                          | Do not render unless AI Label and an approved AI-assisted feature exist. |

Do not document Carbon-only variants or AI presence as implemented unless Login App has installed the API and the UI Reference route proves it with live rendered examples.

## 6. States

| State                  | Status                                                               | Implementation rule                                                                                                               |
| ---------------------- | -------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Unselected             | Implemented / required proof                                         | Native unchecked checkbox state.                                                                                                  |
| Selected               | Implemented / required proof                                         | Native checked checkbox state.                                                                                                    |
| Indeterminate          | Implemented / required proof when parent-child/bulk selection exists | Must set native mixed state and expose `aria-checked="mixed"` when custom semantics are used. Do not fake with icon-only styling. |
| Hover                  | Implemented                                                          | Pointer affordance may appear through label/input interaction; do not add decorative hover color.                                 |
| Persistent focus       | Implemented / required proof                                         | Token-backed visible focus treatment remains on the clicked control until another pointer or keyboard action moves focus.          |
| Disabled               | Implemented / required proof                                         | Unavailable and not editable. Use only when the user cannot change the option.                                                    |
| Read-only              | Implemented / required proof if the API exposes it                   | Non-editable but perceivable selected value. Confirm semantics and contrast.                                                      |
| Error                  | Implemented / required proof                                         | Error copy and invalid treatment must be visible; meaning cannot rely on color alone.                                             |
| Warning                | Implemented / required proof                                         | Warning copy and warning icon/treatment must be visible; warning does not block submission by itself.                             |
| Helper text            | Implemented / required proof                                         | Supporting copy is associated with the checkbox or group.                                                                         |
| Group-level validation | Implemented / required proof                                         | Error/warning/helper copy applies to the group, not just an item.                                                                 |
| Loading                | Not applicable                                                       | Checkbox does not own loading. Use disabled/read-only state plus Inline loading or Pattern-owned pending state when needed.       |
| Success                | Not applicable by default                                            | Use Notification, Tag, or status text when successful submission needs confirmation.                                              |
| Empty                  | Not applicable                                                       | Do not render an empty checkbox group.                                                                                            |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API. Indeterminate must not be presented as a standalone checkbox variant; it is a parent state for nested checkbox groups or another owner-approved bulk selection pattern.

## 7. Token, class, and helper usage

Uses Foundation Color, Spacing, Typography, Themes, Motion, and Icons where validation/status icons are rendered.

### 7.1. Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes
- Motion
- Icons

### 7.2. Token usage

| Foundation Element | Allowed usage                                                                                                                  |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------------ |
| Color              | Text, label, border, focus, disabled, error, warning, helper, and icon roles use documented color tokens.                      |
| Spacing            | Checkbox input-to-label spacing, item spacing, group spacing, helper/error spacing, and nested indentation use spacing tokens. |
| Typography         | Group labels, checkbox labels, helper copy, error copy, and warning copy use approved type roles.                              |
| Themes             | Checkbox states must remain readable in supported light and dark contexts.                                                     |
| Motion             | Checkbox state change should not depend on non-essential motion. Reduced-motion preference must not degrade state clarity.     |
| Icons              | Error and warning icons, if rendered, must use approved Heroicons or component-owned SVGs through the Icons Element API.       |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$icon-primary`, `$icon-inverse` | Unchecked border, checked background, and checkmark fill | `ui-checkbox-box`, checked state icon/fill roles | App icon palette | Same role / app value | Checkbox visual state is component-owned but value comes from Icon/Color roles. |
| `$text-primary`, `$text-secondary`, `$text-disabled` | Checkbox label, group label/helper, disabled label | `ui-checkbox-label`, group legend/helper roles | App text palette | Same role / app value | Labels and helper text follow Text role hierarchy. |
| `$support-error`, `$text-error`, `$support-warning` | Error border/icon/message and warning icon/fill | Checkbox validation state classes | App status palette | Same role / app value | Error/warning require non-color cues and accessible message text. |
| `$focus` | Checkbox focus border/ring | `ui-checkbox-input:focus-visible`, `data-ui-checkbox-focus`, `--ui-focus` | App focus palette | Same role / app value | Focus must be visible on the real input/control and persist after click until the next interaction. |
| `$icon-disabled` | Disabled and read-only control border/fill | Disabled/read-only checkbox state | App icon disabled role | Same role / app value | Disabled/read-only must use a visibly pale control border/fill and must not rely on opacity alone. |
| `$black` | Carbon warning inner fill anomaly/context | No direct Login App token | None | Needs verification | Do not hard-code black; map warning state through support/text/icon roles only after verification. |

### 7.3. CSS namespace

The checkbox implementation must use an app-owned namespace. Use these names as the canonical target unless the implementation documents an equivalent installed namespace:

```css
.ui-checkbox
.ui-checkbox-control
.ui-checkbox-input
.ui-checkbox-box
.ui-checkbox-label
.ui-checkbox-helper
.ui-checkbox-error
.ui-checkbox-warning
.ui-checkbox-group
.ui-checkbox-group-legend
.ui-checkbox-group-helper
.ui-checkbox-group-options
.ui-checkbox-group-vertical
.ui-checkbox-group-horizontal
.ui-checkbox-indeterminate
.ui-checkbox-disabled
.ui-checkbox-readonly
.ui-checkbox-invalid
.ui-checkbox-warning-state
```

Feature views may pass layout classes only where the public API allows them. Feature views must not pass local classes to change checkbox color, border, state, focus, typography, icon, or internal spacing.

The visual checkbox box must remain 16px by 16px, use a subtle rounded corner, and keep the input aligned to the top edge of wrapped or multiline labels.

## 8. Composition rules

- Use native semantics first and layer JavaScript only where behavior requires it.
- Click or tap on the input or its label toggles the checkbox unless disabled or read-only.
- Space toggles the focused checkbox.
- Tab and Shift+Tab move focus through checkbox inputs in document order.
- Group related options with `fieldset` and `legend` when the component owns the group label.
- If a group is split into multiple columns, the owning Pattern must preserve or document meaningful keyboard and reading order.
- Use vertical group layout by default for easier scanning.
- Use horizontal group layout only for very short, predictable sets.
- Parent-child checkbox groups must keep parent checked/unchecked/indeterminate state synchronized with child selections.
- Group-level helper, error, and warning text must be associated with the group and visible near the options.
- Checkbox labels wrap instead of truncating.
- Wrapped labels align from the top of the control instead of vertically centering the full text block against the checkbox.
- Components own internal semantics and styling. Parent Patterns own grouping with unrelated fields, external spacing, workflow orchestration, and page-level layout.

## 9. Selection guidance

### 9.1. Use when:

- Users may choose zero, one, or multiple options from a visible set.
- Choices are independent and selecting one option should not clear another option.
- A form requires an acknowledgement, optional feature selection, preference group, filter group, or terms acceptance.
- A parent option summarizes a nested set and can become indeterminate.
- Users benefit from seeing the available options without opening another control.

### 9.2. Do not use when:

- Users may select only one option from a visible set; use Radio button.
- The setting applies immediately without a submit or save action; use Toggle.
- The options are too many for a visible list and require search, async loading, or tag display; use Multiselect only when installed and approved.
- The control is choosing from a compact native single-select list; use Select.
- The control opens an action menu; use Menu buttons.
- The control selects data-table rows or manages bulk table actions; use Data table and Table toolbar Patterns.
- Critical choices would be hidden behind a collapsed or menu-like surface when a small visible set is clearer.

## 10. Accessibility contract

- Use a native `<input type="checkbox">` whenever possible.
- Associate every checkbox with a visible label.
- Use `fieldset` and `legend` for related checkbox groups when the group owns the label.
- Ensure the checkbox can be reached with Tab and toggled with Space.
- Ensure label click/tap toggles the associated checkbox.
- Keep focus styling visible in every supported theme, including persisted click focus.
- Associate helper, warning, and error copy with the control or group through the installed API.
- Expose indeterminate parent state accessibly. If a custom implementation is ever used, use `aria-checked="mixed"` for the partially checked state.
- Do not rely on color alone for error, warning, selected, disabled, or read-only meaning.
- Preserve contrast for labels, helper copy, validation copy, borders, checkmarks, and focus rings.
- Preserve a meaningful reading and focus order when checkbox groups are arranged in columns.
- Do not render an unlabeled checkbox unless the owning component provides an equivalent accessible name and visible context. Row-selection checkboxes are owned by Data table, not generic Checkbox.

## 11. Content contract

- Write group labels and checkbox labels in sentence case.
- Keep labels clear, concrete, and scannable.
- Prefer labels under three words when possible.
- Use nouns or short noun phrases for options, such as Security alerts or Billing updates.
- Use verb-led copy only when the checkbox represents an acknowledgement, such as Accept terms.
- Do not use vague labels such as Option 1, Enable, Yes, No, More, or Details without surrounding context.
- Labels may wrap to a second line when necessary. Do not truncate checkbox labels with ellipses.
- Helper text should explain the consequence or scope of the group, not repeat the label.
- Error copy should state the recovery action, such as Select at least one notification channel.
- Warning copy should describe the risk or constraint without implying a blocking error.
- Do not make helper text the only place that explains a required or destructive consequence.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not hide critical choices behind a dropdown when a small visible set is clearer.
- Do not use Checkbox for mutually exclusive single choice; use Radio button.
- Do not use Checkbox for immediate setting changes that apply without submit; use Toggle.
- Do not use Checkbox as a menu item unless the Menu/Menu buttons API explicitly owns that behavior.
- Do not use generic Checkbox to replace Data table selection behavior.
- Do not fake indeterminate state with a decorative icon while the input remains unchecked or checked incorrectly.
- Do not truncate checkbox labels.
- Do not vertically center wrapped multi-line labels against the checkbox control.
- Do not use support colors decoratively.
- Do not create local checkbox spacing or local validation colors in feature views.
- Do not render Carbon AI presence on Checkbox unless Login App has an approved AI feature, AI Label standard, and UI Reference proof.

## 13. Deferred or gated capabilities

| Capability                                | Status                                                                   | Gate                                                                                                              |
| ----------------------------------------- | ------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------------------- |
| Horizontal group layout                   | Implemented only when proven; otherwise Deferred                         | UI Reference must show readable scan order, wrapping, and keyboard order.                                         |
| Nested parent/child group helper          | Implemented only when the API exposes nested options; otherwise Deferred | Requires synchronized parent, child, and indeterminate state behavior.                                            |
| AI label presence                         | Deferred / gated                                                         | Requires approved AI-assisted feature, AI Label Component API, explainability behavior, and accessibility review. |
| Async checkbox option loading             | Deferred                                                                 | Requires Pattern-owned loading, error, retry, and persistence behavior.                                           |
| Virtualized large checkbox groups         | Deferred                                                                 | Requires searchable/multiselect review; may belong to Multiselect or Pattern API instead.                         |
| Custom non-native checkbox implementation | Not allowed by default                                                   | Requires explicit accessibility review and proof that native semantics cannot satisfy the requirement.            |

No additional capability is approved without updating this Component standard and UI Reference proof.

## 14. Implementation and UI Reference Checklist
### 14.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, non-visual hover, persistent focus, disabled, validation, selected, unselected, indeterminate, and not-applicable states are defined as relevant. |
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

The Checkbox page may use tabs, grouped examples, state matrices, or comparison grids inside Live examples. It must not use generic fallback sections or placeholder developer examples.

| Required proof                   | Rendered behavior                                                                                          | Variants/options shown                                                                                  |
| -------------------------------- | ---------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------- |
| Independent choice               | One setting can be toggled without affecting nearby choices.                                               | Unselected, selected, helper text.                                                                      |
| Multi-select group               | Several visible choices can be selected at the same time under one group label.                            | Vertical group, selected/unselected mix, group helper text.                                             |
| State matrix                     | Individual state treatments are visible without turning each state into a separate live variant.           | Persistent focus, disabled, read-only, error with icon/message, warning with icon/message, selected and unselected bases. |
| Group states                     | Helper, disabled, read-only, error, and warning states apply to the group without repeating messages.      | Group label, bottom helper text, one error/warning message below the group, option-level highlighting.  |
| Parent-child indeterminate group | Parent checkbox summarizes child selections and displays mixed state only when some children are selected. | Nested options, selected children, unselected children, parent checked/unchecked/mixed sync, parent toggles all mutable children. |
| Overflow and alignment           | Long labels wrap instead of truncating and align from the top of the checkbox control.                     | Multiline single label, long wrapping group label, vertical default, horizontal short-label group.       |

### 15.1. Required component contract display

### 15.2. The UI Reference page must show:

- Installed API and canonical Blade calls.
- Props/options for individual checkbox and checkbox group.
- Anatomy: group, group label, checkbox input/control, label, helper text, error/warning text, nested child items.
- States: unselected, selected, parent indeterminate, non-visual hover, persistent focus, disabled, read-only, error with icon/message, warning with icon/message, helper text, group-level validation.
- Behavior: pointer, keyboard, focus, group, validation, nested/indeterminate, wrapping, and responsive behavior.
- Accessibility requirements.
- Content guidance.
- Foundation Elements consumed.
- Prohibited usage and deferred/gated capabilities.

### 15.3. Required developer examples

The page must render production code examples, not placeholders:

```blade
<x-ui.checkbox
    name="security_alerts"
    label="Security alerts"
    checked
/>
```

```blade
<x-ui.checkbox-group
    name="channels"
    legend="Notification channels"
    :options="$channels"
    :selected="$selectedChannels"
    helper="Choose every channel this workspace may use."
/>
```

```blade
<x-ui.checkbox
    name="terms"
    label="Accept terms"
    required
    error="Accept the terms before continuing."
/>
```

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/checkbox` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The page does not show `Component-specific API pending correction` as the example call.
- The page renders independent, multi-select, state matrix, group state, parent-child indeterminate, overflow, and alignment examples.
- The page distinguishes Checkbox from Radio button and Toggle through the written use/do-not-use contract; live examples belong to the Checkbox API only.
- The page shows unselected, selected, indeterminate, persistent focus, disabled, read-only, error, warning, helper, and group-level validation states.
- The page includes accessible group semantics guidance for `fieldset` and `legend`.
- The page includes keyboard expectations: Tab/Shift+Tab for focus navigation and Space to toggle.
- The page includes label wrapping guidance and prohibits truncation.
- The page includes an AI label deferred/gated note and does not render speculative AI chrome.
- The page uses token-backed UI classes and does not rely on raw utility clusters for component state, color, focus, or validation.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/checkbox');

$response->assertOk();
$response->assertSee('Checkbox');
$response->assertSee('x-ui.checkbox');
$response->assertSee('x-ui.checkbox-group');
$response->assertSee('Independent choice');
$response->assertSee('Multi-select group');
$response->assertSee('States');
$response->assertSee('Group states');
$response->assertSee('Nested group');
$response->assertSee('Overflow and alignment');
$response->assertSee('unselected');
$response->assertSee('selected');
$response->assertSee('indeterminate');
$response->assertSee('persistent focus');
$response->assertSee('disabled');
$response->assertSee('read-only');
$response->assertSee('error');
$response->assertSee('warning');
$response->assertSee('fieldset');
$response->assertSee('legend');
$response->assertSee('Radio button');
$response->assertSee('Toggle');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('generic fallback');
```

## 17. Related APIs

| API                           | Route                                                                   |
| ----------------------------- | ----------------------------------------------------------------------- |
| Radio button                  | `/platform/ui-reference/components/radio-button`                        |
| Toggle                        | `/platform/ui-reference/components/toggle`                              |
| Select                        | `/platform/ui-reference/components/select`                              |
| Dropdown                      | `/platform/ui-reference/components/dropdown`                            |
| Multiselect                   | `/platform/ui-reference/components/multiselect`                         |
| Data table                    | `/platform/ui-reference/components/data-table`                          |
| Inline loading                | `/platform/ui-reference/components/inline-loading`                      |
| Notification                  | `/platform/ui-reference/components/notification`                        |
| Form patterns                 | `/platform/ui-reference/patterns/forms`                                 |
| Table toolbar planned API     | `docs/02-standards/ui/api-registry.md#planned-pattern-and-feature-apis` |
| Components overview           | `/platform/ui-reference/components`                                     |
| Canonical checkbox doc        | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fcheckbox.md`      |
| Carbon Checkbox usage         | `https://carbondesignsystem.com/components/checkbox/usage/`             |
| Carbon Checkbox style         | `https://carbondesignsystem.com/components/checkbox/style/`             |
| Carbon Checkbox accessibility | `https://carbondesignsystem.com/components/checkbox/accessibility/`     |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Checkbox informs zero-or-more selection, indeterminate state, grouping, content, style, and accessibility expectations. Login App uses its own `x-ui.checkbox` and `x-ui.checkbox-group` APIs and app-owned token/class model.

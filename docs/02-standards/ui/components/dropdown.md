---
title: Dropdown
slug: dropdown
status: implemented-pending-correction
api_layer: Component API
category: Inputs
priority: Tier B - Common reusable component
ui_reference_route: /platform/ui-reference/components/dropdown
canonical_doc: docs/02-standards/ui/components/dropdown.md
source_owner: /platform/ui-reference/components/dropdown
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - select
  - multiselect
  - menu-buttons
  - radio-button
  - text-input
related_patterns:
  - forms
  - navigation
  - tables
---

# Dropdown Component API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Props/options](#41-propsoptions)
  - [4.2. Option data contract](#42-option-data-contract)
  - [4.3. Data attributes](#43-data-attributes)
  - [4.4. CSS namespace](#44-css-namespace)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
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
  - [15.1. The UI Reference page must also show:](#151-the-ui-reference-page-must-also-show)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Dropdown chooses one value from a known list of options when a custom listbox handoff is more appropriate than free text, a native select, or an action menu.

Canonical API owner: `/platform/ui-reference/components/dropdown`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

This standard is intentionally scoped to **single known-option selection**. Do not use Dropdown for command menus, overflow actions, multiple selection, searchable free-text entry, or native form selection where Select is the correct installed API.

## 2. Status and ownership

| Field              | Value                                         |
| ------------------ | --------------------------------------------- |
| Status             | Approved API                                  |
| API layer          | Component API                                 |
| Component slug     | dropdown                                      |
| Category           | Inputs                                        |
| Priority           | Tier B - Common reusable component            |
| UI Reference route | `/platform/ui-reference/components/dropdown`  |
| Canonical doc      | `docs/02-standards/ui/components/dropdown.md` |
| Source owner       | `/platform/ui-reference/components/dropdown`  |

## 3. Installed standard

Dropdown now has component-specific UI Reference examples that consume approved Foundation Elements.

The installed Login App standard is:

- Use Dropdown for one value selected from a known option list.
- Use the app-owned `x-ui.dropdown` API for custom single-selection dropdowns.
- Treat Carbon's Dropdown, Multiselect, Filterable multiselect, and Combo box as family-level reference coverage; in Login App, base Dropdown owns only custom single-select behavior unless this standard explicitly expands.
- Use a visible label, optional helper text, visible validation copy, and token-backed field states.
- Use Dropdown only when native Select is not the better fit for the workflow.
- Use Menu buttons or Menu for action disclosure; Dropdown options are values, not commands.
- Use Multiselect when more than one option can be selected.
- Do not implement Combo box behavior inside Dropdown. If users can type to filter or enter a custom value, use Search/Text input today or add a dedicated Combo box standard before implementation.
- Keep options short, text-only, and easy to scan.
- Keep overflow and menu placement behavior inside the component API rather than feature-local JavaScript.

This component owns the single-select field, trigger, selected value display, option menu, option selection, validation state, and menu open/close behavior. Parent Patterns own form layout, filtering intent, table-toolbar composition, submission, persistence, and page-level spacing.

## 4. Public API

| API surface     | Installed value                                                                                                                                                                                                                                                  |
| --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade           | `x-ui.dropdown`                                                                                                                                                                                                                                                  |
| JavaScript      | `initDropdowns` exported from the app UI controls entry when custom listbox behavior is installed. Do not add feature-local dropdown scripts.                                                                                                                    |
| Data attributes | `data-ui-dropdown`, `data-ui-dropdown-trigger`, `data-ui-dropdown-menu`, `data-ui-dropdown-option`, `data-ui-dropdown-value`, `data-ui-dropdown-option-value`, `data-ui-dropdown-option-label`, `data-ui-dropdown-hidden-input`.                                  |
| Props/options   | `name`, `id`, `label`, `options`, `value`, `placeholder`, `helper`, `error`, `warning`, `size`, `variant`, `required`, `disabled`, `readonly`, `menuMaxHeight`, `placement`, `attributes`.                                                                       |
| CSS namespace   | Use the app-owned `ui-*` namespace documented by the component implementation. Recommended namespaces are `ui-dropdown`, `ui-dropdown-trigger`, `ui-dropdown-menu`, `ui-dropdown-option`, `ui-field`, `ui-field-label`, `ui-field-helper`, and `ui-field-error`. |
| Source files    | `resources/views/components/ui/dropdown.blade.php`, `resources/js/ui-controls/dropdowns.js`, `resources/css/app.css`, and UI Reference route `/platform/ui-reference/components/dropdown`.                                                                      |

Example call:

```blade
<x-ui.dropdown
    name="role"
    label="Access role"
    placeholder="Choose a role"
    :options="$roleOptions"
    :value="old('role', $user->role)"
    helper="Choose the access level this user should receive."
/>
```

Validation example:

```blade
<x-ui.dropdown
    name="workspace_type"
    label="Workspace type"
    placeholder="Choose a workspace type"
    :options="$workspaceTypeOptions"
    :error="$errors->first('workspace_type')"
    required
/>
```

Disabled example:

```blade
<x-ui.dropdown
    name="billing_plan"
    label="Billing plan"
    :options="$planOptions"
    value="enterprise"
    helper="Plan is managed by account ownership."
    disabled
/>
```

### 4.1. Props/options

| Prop/option     | Type                  |            Default | Allowed values             | Required | Notes                                                                                                      |
| --------------- | --------------------- | -----------------: | -------------------------- | -------: | ---------------------------------------------------------------------------------------------------------- |
| `name`          | `string`              |                  — | Valid form field name      |      Yes | Must map to the submitted field when the dropdown participates in a form.                                  |
| `id`            | `string / null`       |             `null` | derived from `name`        |       No | Use explicit ids when multiple dropdowns appear on the same page.                                          |
| `label`         | `string`              |                  — | Plain text or escaped text |      Yes | Visible label is required. Placeholder-only labeling is prohibited.                                        |
| `options`       | `array`               |               `[]` | Array of option records    |      Yes | Each option must follow the option contract below.                                                         |
| `value`         | `string / int / null` |             `null` | One option value           |       No | Must match one option value when selected.                                                                 |
| `placeholder`   | `string / null`       | `Choose an option` | Short instruction          |       No | Placeholder is optional and must not replace label or helper text.                                         |
| `helper`        | `string / null`       |             `null` | Short explanatory copy     |       No | Use for selection guidance that remains visible.                                                           |
| `error`         | `string / null`       |             `null` | Short recovery copy        |       No | Sets invalid/error treatment and links copy to the control.                                                |
| `warning`       | `string / null`       |             `null` | Short caution copy         |       No | Use for non-blocking caution copy.                                                                         |
| `size`          | `string`              |               `md` | `sm`, `md`, `lg`           |       No | Use one field size consistently within the same form or toolbar region.                                    |
| `variant`       | `string`              |          `default` | `default`, `fluid`         |       No | `fluid` is gated unless the page proves attached/contained input behavior.                                 |
| `required`      | `bool`                |            `false` | `true`, `false`            |       No | Must be paired with server validation.                                                                     |
| `disabled`      | `bool`                |            `false` | `true`, `false`            |       No | Disabled dropdowns cannot open and should not submit a changed value.                                      |
| `readonly`      | `bool`                |            `false` | `true`, `false`            |       No | Read-only shows a fixed value without opening the menu. Prefer plain text for purely informational values. |
| `menuMaxHeight` | `string / null`       |             `null` | Approved CSS length        |       No | Use only through the component API to cap long menus.                                                      |
| `placement`     | `string`              |             `auto` | `auto`, `down`, `up`       |       No | Prefer `auto`; manual placement needs a layout reason.                                                     |
| `attributes`    | `array`               |               `[]` | Extra safe HTML attributes |       No | Do not use this to inject local styles, raw colors, or custom behavior.                                    |

### 4.2. Option data contract

| Key        | Type            | Required | Notes                                                                                    |
| ---------- | --------------- | -------: | ---------------------------------------------------------------------------------------- |
| `value`    | `string / int`  |      Yes | Submitted value. Must be stable and unique in the option list.                           |
| `label`    | `string`        |      Yes | Visible option text. Keep brief, accurate, and text-only.                                |
| `disabled` | `bool`          |       No | Disabled options may be shown only when the reason is clear from context or helper copy. |
| `group`    | `string / null` |       No | Use only when grouping is approved and still remains easy to scan.                       |

Do not include decorative images, arbitrary icons, rich HTML, nested controls, action labels, or multi-line descriptions in Dropdown options.

### 4.3. Data attributes

| Attribute                       | Owner          | Purpose                                                                                |
| ------------------------------- | -------------- | -------------------------------------------------------------------------------------- |
| `data-ui-dropdown`              | Root           | Initializes and scopes dropdown behavior.                                              |
| `data-ui-dropdown-trigger`      | Trigger button | Opens/closes the option menu and owns `aria-expanded`.                                 |
| `data-ui-dropdown-menu`         | Menu/listbox   | Contains selectable options.                                                           |
| `data-ui-dropdown-option`       | Option         | Identifies one selectable option.                                                      |
| `data-ui-dropdown-value`        | Option/value   | Stores the visible selected text region or submitted option value, depending on owner. |
| `data-ui-dropdown-option-value` | Option         | Stores the submitted option value for JavaScript selection.                            |
| `data-ui-dropdown-option-label` | Option         | Stores the visible option label for JavaScript selection.                              |
| `data-ui-dropdown-hidden-input` | Hidden input   | Stores the selected value for form submission when the trigger is not a native select. |

### 4.4. CSS namespace

Recommended app-owned classes:

```text
ui-dropdown
ui-dropdown-trigger
ui-dropdown-value
ui-dropdown-placeholder
ui-dropdown-chevron
ui-dropdown-menu
ui-dropdown-option
ui-dropdown-option-selected
ui-dropdown-option-disabled
ui-dropdown-sm
ui-dropdown-md
ui-dropdown-lg
ui-dropdown-fluid
ui-field
ui-field-label
ui-field-helper
ui-field-error
ui-field-warning
```

Do not use direct Carbon production classes such as `cds--dropdown` or `bx--dropdown` in Login App feature views.

## 5. Allowed variants, options, and modifiers

Dropdown does not have decorative variants. It has installed single-select behavior, field styles, sizes, validation states, and explicit boundaries against nearby selection/action APIs.

| Name                           | Type               | Status               | API                                                                                        | Use when                                                                            |
| ------------------------------ | ------------------ | -------------------- | ------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------- |
| Default single-select dropdown | Variant            | Approved API         | `variant="default"`                                                                        | User chooses one known option from a custom listbox.                                |
| Small size                     | Size               | Approved API         | `size="sm"`                                                                                | Dense toolbars, filters, or long forms where the surrounding fields use small size. |
| Medium size                    | Size               | Approved API         | `size="md"`                                                                                | Default field size for most forms and admin UI.                                     |
| Large size                     | Size               | Approved API         | `size="lg"`                                                                                | Simple spacious forms or standalone selection moments.                              |
| Helper text                    | Field modifier     | Approved API         | `helper="..."`                                                                             | Selection guidance remains visible below the label.                                 |
| Error state                    | Field state        | Approved API         | `error="..."`                                                                              | Selection is invalid and blocking recovery copy is required.                        |
| Warning state                  | Field state        | Approved API         | `warning="..."`                                                                            | Selection is allowed but carries a non-blocking caution.                            |
| Disabled dropdown              | State              | Approved API         | `disabled`                                                                                 | User cannot change the value in this context.                                       |
| Read-only dropdown             | State              | Approved API         | `readonly`                                                                                 | A selected value is visible but the menu must not open.                             |
| Long menu with capped height   | Modifier           | Approved API         | `menuMaxHeight="..."`                                                                      | A known option list is long enough to need vertical scrolling.                      |
| Auto placement                 | Behavior           | Approved API         | `placement="auto"`                                                                         | Menu should open up or down to avoid clipping.                                      |
| Fluid dropdown                 | Variant            | Gated                | `variant="fluid"`                                                                          | Use only after the UI Reference proves attached/contained field behavior.           |
| Inline dropdown                | Variant            | Deferred             | None approved                                                                              | Use only after an inline selection API and keyboard contract are approved.          |
| Filterable dropdown            | Component boundary | Not implemented here | Search/Text input today; Combo box or filterable Multiselect only after dedicated approval | Filtering changes the component into a different API boundary.                      |
| Multiple selection             | Component boundary | Not implemented here | Use Multiselect                                                                            | More than one option may be selected.                                               |
| Action menu                    | Component boundary | Not implemented here | Use Menu buttons / Menu                                                                    | Options are commands rather than submitted values.                                  |
| Native select                  | Component boundary | Separate component   | Use Select                                                                                 | Native mobile/form behavior is preferred.                                           |
| AI presence                    | Gated              | Not implemented      | None approved                                                                              | Requires an approved AI-assisted feature and AI disclosure standard.                |

Do not render gated, deferred, or boundary entries as working production UI.

## 6. States

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

| State                     | Status         | Required implementation                                                                                           |
| ------------------------- | -------------- | ----------------------------------------------------------------------------------------------------------------- |
| Closed                    | Approved API   | Trigger is visible, menu hidden, selected value or placeholder shown.                                             |
| Open                      | Approved API   | Menu/listbox is visible, trigger has synchronized open state, and options are keyboard reachable.                 |
| Unselected                | Approved API   | Placeholder is shown when no value has been selected.                                                             |
| Selected                  | Approved API   | Selected option label replaces placeholder and selected option remains available in the menu.                     |
| Hover                     | Approved API   | Field and option hover treatment uses token-backed state styles.                                                  |
| Focus-visible             | Approved API   | Trigger and menu options have visible focus.                                                                      |
| Active/pressed            | Approved API   | Trigger press and option press states use token-backed state styles.                                              |
| Disabled                  | Approved API   | Trigger cannot open the menu and does not expose an interactive affordance.                                       |
| Read-only                 | Approved API   | Value is visible, but the menu cannot open.                                                                       |
| Helper text               | Approved API   | Helper copy remains visible and associated with the control.                                                      |
| Error                     | Approved API   | Error copy is visible, non-color-only, and associated with the control. Use invalid semantics where appropriate.  |
| Warning                   | Approved API   | Warning copy is visible and non-color-only. Do not mark valid fields invalid solely for warnings.                 |
| Overflow/truncated option | Approved API   | Long option text truncates safely and exposes full text through an approved Tooltip only when needed.             |
| Skeleton/loading          | Gated          | Use only when async options are installed; otherwise parent Patterns own loading.                                 |
| Empty options             | Gated          | Use only when async/conditional options are installed; otherwise do not render an empty dropdown.                 |
| Multi-selected            | Not applicable | Use Multiselect.                                                                                                  |
| Filtered                  | Not applicable | Use Search/Text input today; approve Combo box or filterable Multiselect before adding filtered listbox behavior. |
| Current action            | Not applicable | Use Menu/Menu buttons for commands.                                                                               |

## 7. Token, class, and helper usage

Dropdown consumes Foundation Color, Spacing, Typography, Themes, Motion, and Icons through app field, menu, and overlay classes.

### 7.1. Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes
- Motion
- Icons

Recommended app-owned classes and helpers:

| Class/helper              | Owner                     | Allowed usage                                           |
| ------------------------- | ------------------------- | ------------------------------------------------------- |
| `ui-field`                | Component / Form Pattern  | Wraps label, control, helper text, and validation copy. |
| `ui-field-label`          | Component                 | Visible field label.                                    |
| `ui-dropdown`             | Component                 | Root custom dropdown element.                           |
| `ui-dropdown-trigger`     | Component                 | Button-like field control.                              |
| `ui-dropdown-value`       | Component                 | Selected value text.                                    |
| `ui-dropdown-placeholder` | Component                 | Placeholder text when no value is selected.             |
| `ui-dropdown-chevron`     | Component / Icons Element | Decorative open/closed indicator.                       |
| `ui-dropdown-menu`        | Component                 | Overlaid option list.                                   |
| `ui-dropdown-option`      | Component                 | One selectable option row.                              |
| `ui-field-helper`         | Component                 | Helper and selection guidance copy.                     |
| `ui-field-error`          | Component                 | Blocking validation copy.                               |
| `ui-field-warning`        | Component                 | Non-blocking caution copy.                              |

Allowed token roles:

| Foundation Element | Allowed role                                                                                                        |
| ------------------ | ------------------------------------------------------------------------------------------------------------------- |
| Color              | Field, layer, text, helper, border, focus, support-error, support-warning, icon, disabled, selected, hover, active. |
| Spacing            | Label-to-field spacing, trigger padding, option padding, helper spacing, menu gap, capped menu height.              |
| Typography         | Label, field text, option text, helper, error, and warning roles.                                                   |
| Themes             | Light/dark/inverse contexts through token inheritance.                                                              |
| Motion             | Open/close, hover, and focus transitions that respect reduced motion.                                               |
| Icons              | Decorative chevron, warning/error icons where installed, no decorative option icons.                                |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$field`, `$field-hover` | Trigger field background and hover background | `ui-dropdown-trigger`, `ui-field`, `--ui-field`, `--ui-field-hover` | App field palette | Same role / app value | Shared field mapping with all form controls. |
| `$layer`, `$layer-hover`, `$layer-active`, `$layer-selected` | Menu option surface, hover, active, and selected states | `ui-dropdown-menu`, `ui-dropdown-option`, layer state aliases | App layer palette | Same role / app value | Dropdown menus share layer state roles with Menu, Select-like popups, Tree view, and Data table rows. |
| `$text-primary`, `$text-secondary`, `$text-helper`, `$text-disabled`, `$text-inverse` | Option, prompt/helper, disabled, and selected tag text | Dropdown value, prompt, helper, option, and multiselect tag roles | App text palette | Same role / app value | Text roles must not be restyled with local muted/gray utilities. |
| `$icon-primary`, `$icon-disabled` | Chevron and selected-option checkmark states | `ui-dropdown-chevron`, option checkmark icon roles | App icon palette | Same role / app value | Decorative chevrons are `aria-hidden` and inherit color. |
| `$support-error`, `$text-error`, `$support-warning` | Invalid/warning field border, icon, and message roles | Field validation state classes | App status palette | Same role / app value | Validation mapping is shared across field components. |
| `$border-subtle`, `$focus` | Read-only border and focus border/ring | Dropdown read-only and focus-visible states | App border/focus palette | Same role / app value | Read-only/focus roles are Color-owned. |
| `$background-inverse` | Multiselect selected tag background | Multiselect tag role if installed | App inverse palette | Same role / app value | Use Tag/Dropdown component ownership; do not create feature-local selected pills. |
| `$ai-border-strong`, `$ai-aura-start-sm`, `$ai-aura-stop` | AI dropdown presence | No baseline dropdown role until AI variant is approved | None | Not adopted | AI tokens remain gated. |

Do not hard-code raw color, spacing, font size, borders, focus rings, icon sources, shadow values, or motion timing in feature views.

## 8. Composition rules

- Use native semantics first where the native Select component satisfies the workflow.
- Use custom Dropdown only through the installed `x-ui.dropdown` API.
- The trigger opens/closes the menu by click, tap, Enter, Space, or Down Arrow.
- Arrow keys move through options once the menu is open.
- Enter or Space selects the focused option and closes the menu.
- Escape closes the menu without changing the selected value.
- Tab closes the menu and moves focus to the next focusable element.
- Outside click closes the menu without changing the selected value.
- Opening the menu should move focus to the selected option or first available option according to the installed keyboard contract.
- Selecting an option updates the visible value and the form-submitted value.
- Menu placement should avoid viewport clipping. Prefer automatic placement before local layout overrides.
- Capped menus should show enough of the next option to indicate scrollability when practical.
- Option rows should remain the same height as the field size for the selected dropdown size.
- Do not nest Dropdown inside Dropdown, Menu, Tooltip, or Toggletip content.
- Do not place interactive controls inside options.
- Components own internal semantics and styling. Parent Patterns own grouping, external spacing, workflow orchestration, filter/query behavior, and page-level layout.

## 9. Selection guidance

### 9.1. Use when:

- Users need to select one option from a predefined list.
- The option list is known before interaction and does not require typing to filter.
- A custom styled field is needed in a form, modal, side panel, filter region, or toolbar handoff.
- Space is limited but the options should stay directly available from the current context.
- The selected value should submit as a single form value or update a filter value.

### 9.2. Do not use when:

- There are only two mutually exclusive choices; use Radio button or Toggle depending on whether the change is submitted or immediate.
- The experience is primarily form-based or mobile and a native select is sufficient.
- Users can choose multiple values; use Multiselect or Checkbox group.
- Users need to type to filter, search, or enter a custom value; use Search/Text input today or add a dedicated Combo box standard before implementation.
- Options are actions such as Edit, Duplicate, Archive, or Delete; use Menu buttons/Menu.
- Options need rich descriptions, nested content, images, or complex formatting.
- Placeholder text would be the only label.
- A local feature only wants a custom field style while native Select already satisfies the workflow.

Use related APIs instead:

| Need                                               | Use                                                                   |
| -------------------------------------------------- | --------------------------------------------------------------------- |
| Native form selection or mobile-friendly selection | Select                                                                |
| One choice among two or several visible options    | Radio button                                                          |
| Immediate on/off setting                           | Toggle                                                                |
| Multiple known selections                          | Multiselect or Checkbox group                                         |
| Searchable known options or custom free-text value | Search/Text input today; add a Combo box standard only after approval |
| Action menu or overflow actions                    | Menu buttons / Menu                                                   |
| Table filtering with multiple controls             | Table toolbar or Filter Pattern                                       |

## 10. Accessibility contract

- Provide a visible label for every dropdown.
- The trigger must be keyboard reachable and expose an accessible name.
- The trigger must expose listbox intent with `aria-haspopup="listbox"` where a custom listbox is used.
- Keep `aria-expanded` synchronized with menu open/closed state.
- Use `aria-controls` only when it correctly references the menu/listbox id.
- Options must be keyboard reachable through the installed listbox behavior.
- Maintain visible focus on the trigger and focused option.
- Escape must close the menu without changing the selected value.
- Selection must not rely on color alone; selected state needs text, checkmark, or programmatic state as installed by the API.
- Error and warning states must include visible text and must not rely on color alone.
- Disabled dropdowns must not be focusable or openable.
- Read-only dropdowns must communicate that the value cannot be changed.
- Decorative chevrons and non-informative state icons must be hidden from assistive technology.
- Custom menu positioning must not trap focus, hide options off-screen, or create unreachable content.

## 11. Content contract

- Write labels in sentence case.
- Keep labels short and specific to the expected option set.
- Use helper text for persistent guidance such as “Choose the role this user should receive.”
- Do not move important instructions into placeholder text.
- Use placeholder text only as a short interaction prompt such as “Choose an option.”
- Keep option labels brief, accurate, text-only, and easy to scan.
- Prefer nouns or short noun phrases for options.
- Do not write option labels as commands.
- Do not use decorative images or icons inside options.
- Avoid multi-line option text. Truncate long option labels and expose the full label through an approved Tooltip only when needed.
- Sort options alphabetically unless product logic, frequency, severity, or hierarchy requires another documented order.
- Error copy must explain recovery, not only restate invalidity.
- Warning copy must explain the consequence without blocking valid selection.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, local shadows, or custom JavaScript.
- Do not use Dropdown for action menus, overflow menus, destructive commands, or contextual command lists.
- Do not call action examples “dropdowns”; use Menu buttons/Menu.
- Do not use Dropdown when a native Select satisfies the form/mobile workflow.
- Do not use Dropdown when users can select multiple options; use Multiselect or Checkbox group.
- Do not use Dropdown when users need to type to filter or create a value; use Search/Text input today or add a dedicated Combo box standard before implementation.
- Do not use Dropdown for two-option choices where Radio button or Toggle is clearer.
- Do not hide critical labels, constraints, or validation copy inside placeholder text.
- Do not place decorative images, arbitrary icons, links, buttons, checkboxes, or nested controls inside options.
- Do not nest dropdowns or use them to display overly complex information.
- Do not create local size, density, border, menu elevation, option hover, selected, or focus treatments outside the API.
- Do not render deferred fluid, inline, filterable, async, skeleton, or AI-presence behavior as production UI.

## 13. Deferred or gated capabilities

| Capability            | Status               | Gate                                                                                            |
| --------------------- | -------------------- | ----------------------------------------------------------------------------------------------- |
| Fluid dropdown        | Gated                | Requires a proven attached/contained field context, spacing rules, and UI Reference proof.      |
| Inline dropdown       | Deferred             | Requires a separate inline selection API, placement rules, and keyboard contract.               |
| Async options         | Deferred             | Requires loading, empty, error, retry, and stale-value behavior.                                |
| Skeleton dropdown     | Deferred             | Requires async option loading ownership and reduced-motion/loading guidance.                    |
| Filterable dropdown   | Not implemented here | Use Search/Text input today; approve Combo box or filterable Multiselect before implementation. |
| Multi-select dropdown | Not implemented here | Use Multiselect after canonical API is approved.                                                |
| Rich option templates | Deferred             | Requires accessible naming, truncation, layout, and keyboard review.                            |
| Option grouping       | Gated                | Requires clear grouping semantics and scan behavior.                                            |
| AI presence           | Gated                | Requires approved AI-assisted feature, AI explainability content, and AI label standard.        |
| Custom mobile picker  | Deferred             | Requires mobile accessibility, native-control comparison, and platform behavior review.         |

No additional capability is approved without updating this Component standard and UI Reference proof.

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

Dropdown is a field/control component. Its Live examples may use grouped examples, state tables, or tabs, but must not show action-menu examples as Dropdown examples.

| Required proof                  | Rendered behavior                                                                                                                                     | Variants/options shown                                                |
| ------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------- |
| Basic known-option dropdown     | Single-select dropdown with visible label, placeholder, selected value, and closed/open states.                                                       | Default, Medium, Open, Selected, Focus-visible                        |
| Long known-option handoff       | Longer option set demonstrates capped menu height, scroll behavior, truncation/overflow handling, and auto placement expectations.                    | Long menu, `menuMaxHeight`, Overflow/truncated option, Auto placement |
| Validation dropdown             | Required single-select field demonstrates helper text, error text, warning text, and non-color-only validation treatment.                             | Helper text, Error, Warning, Required, Focus-visible                  |
| Disabled and read-only dropdown | Disabled cannot open; read-only displays the value without allowing changes.                                                                          | Disabled, Read-only, Selected value                                   |
| Size comparison                 | Approved field sizes render with matching option row heights and consistent surrounding field scale.                                                  | Small, Medium, Large                                                  |
| Dropdown vs related APIs        | Visual comparison explains when to use Dropdown, Select, Menu buttons/Menu, Multiselect, Combo box, Radio button, and Toggle.                         | Boundary examples, Deferred/gated labels where applicable             |
| Deferred/gated capabilities     | Page shows trigger conditions instead of fake working controls for fluid, inline, async, skeleton, filterable, multiselect, and AI-presence behavior. | Gated, Deferred, Not implemented                                      |

### 15.1. The UI Reference page must also show:

- Installed API and canonical Blade call.
- Props/options table.
- Option data contract.
- Anatomy: label, helper text, trigger/field, selected value or placeholder, chevron, menu/listbox, option, validation copy.
- States: closed, open, hover, focus-visible, active/pressed, selected, disabled, read-only, helper, error, warning, overflow/truncated.
- Foundation Elements consumed.
- Prohibited usage.
- Related API boundaries.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/dropdown` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The page does not contain generic fallback content.
- The page does not contain `Component-specific API pending correction.`.
- The page does not contain stale labels such as `Live Examples Card`, `Reference Examples`, or `Legacy Contract Summary`.
- The page does not link to deprecated `tier-1` or `tier-2` canonical component paths.
- The page does not use direct Carbon production classes such as `cds--dropdown` or `bx--dropdown`.
- The page renders `x-ui.dropdown` as the canonical component API.
- The page shows `Select`, `Menu buttons`, `Multiselect`, Search/Text input, and Combo box disposition as boundary APIs.
- The page does not render action-menu examples as Dropdown examples.
- The page shows visible label, helper, error, warning, disabled, read-only, open, selected, and focus-visible examples.
- The page shows deferred/gated conditions for fluid, inline, async, filterable, multiselect, skeleton, and AI-presence capabilities instead of fake controls.

Suggested feature-test assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/dropdown');

$response->assertOk();
$response->assertSee('Dropdown');
$response->assertSee('x-ui.dropdown');
$response->assertSee('Basic known-option dropdown');
$response->assertSee('Long known-option handoff');
$response->assertSee('Validation dropdown');
$response->assertSee('Disabled and read-only dropdown');
$response->assertSee('Size comparison');
$response->assertSee('Dropdown vs related APIs');
$response->assertSee('Select');
$response->assertSee('Menu buttons');
$response->assertSee('Multiselect');
$response->assertSee('Combo box disposition');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('short action dropdown');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--dropdown');
$response->assertDontSee('bx--dropdown');
```

## 17. Related APIs

| API                 | Route                                            |
| ------------------- | ------------------------------------------------ |
| Select              | `/platform/ui-reference/components/select`       |
| Multiselect         | `/platform/ui-reference/components/multiselect`  |
| Menu buttons        | `/platform/ui-reference/components/menu-buttons` |
| Radio button        | `/platform/ui-reference/components/radio-button` |
| Toggle              | `/platform/ui-reference/components/toggle`       |
| Text input          | `/platform/ui-reference/components/text-input`   |
| Search              | `/platform/ui-reference/components/search`       |
| Form patterns       | `/platform/ui-reference/patterns/forms`          |
| Filter composition  | `/platform/ui-reference/patterns/navigation`     |
| Tables Patterns     | `/platform/ui-reference/patterns/tables`         |
| Components overview | `/platform/ui-reference/components`              |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Dropdown usage guidance defines Dropdown as one of three related selection variants alongside Multiselect and Combo box. Login App documents Multiselect as a separate API boundary and treats Combo box behavior as a deferred disposition unless a dedicated standard is approved.
- Carbon Dropdown accessibility guidance informs the keyboard, listbox, `aria-expanded`, and `aria-haspopup="listbox"` requirements. Login App must prove equivalent behavior through the installed Component API before marking the correction complete.

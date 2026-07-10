---
title: Multiselect
slug: multiselect
api_layer: Component API
status: implemented-standard
system_maturity: implemented
category: inputs
priority: tier-b-common-reusable-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/multiselect.md
source_owner: not installed
blade_api:
  - x-ui.multi-select
  - x-ui.filterable-multi-select
javascript_api:
  - initMultiselects exported from resources/js/ui-controls/multiselects.js
source_files:
  - resources/views/components/ui/multi-select/index.blade.php
  - resources/views/components/ui/filterable-multi-select/index.blade.php
  - resources/js/ui-controls/multiselects.js
  - resources/css/components/multi-select.css
  - resources/css/components/list-box.css
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
---

# Multiselect

## 1. API Summary

Multiselect lets users choose multiple values from a known option set through installed, accessible, token-backed component APIs.

Canonical API owner: `not installed`.

Installed APIs:

| API | Use |
| --- | --- |
| `x-ui.multi-select` | Multiple known-option selection without an in-field filter. |
| `x-ui.filterable-multi-select` | Multiple known-option selection with component-owned filtering. |

Feature views must not compose Dropdown, Checkbox, Search, Tag, hidden inputs, and local JavaScript to recreate this behavior.

## 2. Installed Standard

- Use `x-ui.multi-select` for default multi-value known-option fields.
- Use `x-ui.filterable-multi-select` when users need to filter a larger option set before choosing values.
- Use `items` for option data.
- Use `selected-items` for controlled selected values.
- Provide a visible label through `label` on `x-ui.multi-select`; also provide `title-text` when the field title should render inside the component.
- Provide `title-text` on `x-ui.filterable-multi-select`.
- Use `helper-text`, `invalid` plus `invalid-text`, and `warn` plus `warn-text` for field feedback.
- Use `select-all` only when batch selection is expected and safe.
- Use `read-only` when selected values should remain visible but cannot be changed.
- Keep loading, remote fetch, stale options, permissions, and page workflow rules outside the component.
- Do not add compatibility aliases for removed APIs unless a separate decision record approves that contract.

Carbon alignment note: Carbon treats multiselect as part of the dropdown/listbox family. Login App maps that behavior to app-owned Blade components, `ui-*` classes, Foundation tokens, and rendered evidence proof instead of adopting Carbon production classes.

## 3. Public API

### 3.1. Default Multiselect

```blade
<x-ui.multi-select
    name="teams"
    label="Teams"
    title-text="Teams"
    :items="$teamOptions"
    :selected-items="$selectedTeamIds"
    helper-text="Choose one or more teams that can access this workspace."
/>
```

### 3.2. Filterable Multiselect

```blade
<x-ui.filterable-multi-select
    name="roles"
    title-text="Roles"
    :items="$roleOptions"
    :selected-items="old('roles', $selectedRoleIds)"
    placeholder="Filter roles"
    select-all
/>
```

### 3.3. Validation

```blade
<x-ui.multi-select
    name="departments"
    label="Departments"
    title-text="Departments"
    :items="$departmentOptions"
    :selected-items="$selectedDepartments"
    invalid
    invalid-text="Choose at least one department."
/>
```

## 4. Props

| Prop | Applies to | Required | Rule |
| --- | --- | --- | --- |
| `name` | both | when form-bound | Submitted field name. Selected values serialize through hidden inputs. |
| `label` | `x-ui.multi-select` | yes | Visible accessible label. |
| `title-text` | both | recommended | Field title shown inside the component. Required for `x-ui.filterable-multi-select` title copy. |
| `items` | both | yes | Array of option items with `value`, `label`, and optional `disabled`. |
| `selected-items` | both | no | Array of selected values. |
| `helper-text` | both | no | Non-error supporting text. |
| `invalid` / `invalid-text` | both | no | Error state and visible error message. |
| `warn` / `warn-text` | both | no | Warning state and visible warning message. |
| `disabled` | both | no | Field is non-interactive. |
| `read-only` | both | no | Selected values remain visible and cannot be changed. |
| `open` | both | no | Demo and controlled proof state only; production should usually initialize closed. |
| `select-all` | both | workflow-gated | Adds a component-owned select-all option. |
| `size`, `type`, `direction`, `light`, `hide-label` | both | no | Current installed styling and layout controls. |

Option item shape:

```php
[
    'value' => 'owner',
    'label' => 'Owner',
    'disabled' => false,
]
```

## 5. Component Hooks

Feature code may use these hooks for tests and component-owned JavaScript initialization only. Feature code must not invent new local hooks for multiselect behavior.

| Hook | Owner | Purpose |
| --- | --- | --- |
| `data-ui-component="multi-select"` | Component | Root diagnostic hook for the base multiselect. |
| `data-ui-component="filterable-multi-select"` | Component | Root diagnostic hook for the filterable multiselect. |
| `data-ui-multi-select` | Component | Interactive multiselect root. |
| `data-ui-filterable-multi-select` | Component | Filterable interactive root. |
| `data-ui-multi-select-trigger` | Component | Trigger/control surface. |
| `data-ui-multi-select-menu` | Component | Option list surface. |
| `data-ui-multi-select-option` | Component | Selectable option. |
| `data-ui-filterable-multi-select-input` | Component | Filter text input. |
| `data-ui-multi-select-clear` | Component | Clear selected values. |
| `data-ui-multi-select-hidden-input` | Component | Submitted selected value. |

CSS selectors are owned by `resources/css/components/multi-select.css` and `resources/css/components/list-box.css`. Current component classes use the `ui-multi-select` and `ui-list-box` families.

## 6. Accessibility

- The option list uses listbox semantics and `aria-multiselectable="true"`.
- Options expose selected and disabled states programmatically.
- The component owns keyboard movement, selection, Escape handling, hidden input sync, selected-count updates, and filter behavior.
- Labels and feedback text must be programmatically associated with the field.
- Validation and warning states must not rely on color alone.

## 7. rendered evidence proof

The rendered evidence page must prove:

- default `x-ui.multi-select`
- filterable `x-ui.filterable-multi-select`
- selected values and selected-count feedback
- select-all behavior
- disabled and read-only states
- invalid and warning feedback
- option overflow and keyboard behavior
- component-owned hooks and current source files

Suggested assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('x-ui.multi-select');
$response->assertSee('x-ui.filterable-multi-select');
$response->assertSee('data-ui-component="multi-select"', false);
$response->assertSee('data-ui-component="filterable-multi-select"', false);
$response->assertSee('data-ui-multi-select-option', false);
$response->assertSee('data-ui-filterable-multi-select-input', false);
```

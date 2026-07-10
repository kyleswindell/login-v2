---
title: Menu
slug: menu
api_layer: Component API
status: implemented-pending-manual-review
system_maturity: partial
category: actions
priority: tier-b-common-reusable-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/menu.md
source_owner: not installed
blade_api:
  - x-ui.menu
  - x-ui.menu-item
javascript_api:
  - initMenus exported from resources/js/ui-controls/menus.js
data_attributes:
  - data-ui-menu
  - data-ui-menu-trigger
  - data-ui-menu-panel
  - data-ui-menu-item
  - data-ui-menu-submenu-trigger
  - data-ui-menu-submenu-panel
  - data-ui-menu-close
  - data-ui-menu-action
  - data-ui-menu-method
  - data-ui-menu-divider
  - data-ui-menu-placement
source_files:
  - resources/views/components/ui/menu/index.blade.php
  - resources/views/components/ui/menu-item/index.blade.php
  - resources/js/ui-controls/menus.js
  - resources/css/components/menu.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - button
  - icon-button
  - tooltip
  - data-table
  - notification
related_patterns:
  - layout
  - tables
  - forms
  - overlays-feedback
carbon_reference:
  - https://carbondesignsystem.com/components/menu/usage/
  - https://carbondesignsystem.com/components/menu/style/
  - https://carbondesignsystem.com/components/menu/accessibility/
  - https://carbondesignsystem.com/components/menu-buttons/usage/
  - https://carbondesignsystem.com/components/overflow-menu/usage/
---

# Menu Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. JavaScript initializer](#43-javascript-initializer)
  - [4.4. `x-ui.menu` props and options](#44-x-uimenu-props-and-options)
  - [4.5. `x-ui.menu-item` props and options](#45-x-uimenu-item-props-and-options)
  - [4.6. Item data contract](#46-item-data-contract)
  - [4.7. Data attribute contract](#47-data-attribute-contract)
  - [4.8. Semantic structure contract](#48-semantic-structure-contract)
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
- [14. Implementation and Rendered Evidence Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. rendered evidence proof checklist](#142-ui-reference-proof-checklist)
- [15. Rendered evidence requirements](#15-ui-reference-requirements)
  - [15.1. Required Live examples internal sections:](#151-required-live-examples-internal-sections)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Menus present contextual actions behind a trigger without crowding the page.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Menu is the installed Login App 2.0 contextual action disclosure API. It owns menu trigger semantics, open/closed state, keyboard navigation, focus return, row overflow action menus, divided action groups, destructive item treatment, selected/checkable item treatment, one-level submenu boundaries, alignment, RTL mirroring, token-backed item states, and the JavaScript initializer required to operate menu behavior. It does not own page-level action hierarchy, table row business logic, permissions, destructive confirmation flows, form validation, modal placement, or command execution.

### 1.1. Canonical API responsibilities:

- Render contextual action menus through `x-ui.menu` and `x-ui.menu-item`.
- Initialize behavior through `initMenus` from `resources/js/ui-controls/menus.js`.
- Expose an accessible trigger with `aria-haspopup="menu"`, synchronized `aria-expanded`, and `aria-controls`.
- Render menus with `role="menu"` and items with the correct menu item role.
- Move focus into the first enabled item when opened.
- Support keyboard navigation with arrow keys, Home/End, Enter, Space, and Escape.
- Return focus to the trigger when the menu closes by Escape or outside dismissal.
- Support contextual action, row overflow, grouped, selected/checkable, danger, disabled, shortcut, and one-level submenu examples.
- Reserve the selected/checkable indicator column across mixed selected, unselected, and non-select action rows when a menu includes selected/checkable items.
- Support approved sizes and placements through component props/classes.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and icons.
- Prove variants, states, keyboard behavior, alignment, RTL behavior, implementation details, prohibited usage, and deferred gates on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Primary action visibility. Use Button or a Pattern-owned page action when the action should be visible.
- Navigation collections. Use navigation, tabs, breadcrumbs, or links instead of Menu when the user is choosing where to go.
- Form field selection. Use Select, Checkbox, Radio button, or a Forms Pattern when the user is choosing values instead of invoking commands.
- Command authorization, policy checks, confirmation, persistence, import/export work, or controller behavior.
- Destructive confirmation modals and undo feedback. Use Modal, Notification, and Overlay/feedback Patterns.
- Table row data ownership. Data table and Table toolbar Patterns own row context, bulk action placement, and toolbar grouping.
- External spacing and page layout. Parent Patterns own grouping, placement, and workflow orchestration.

## 2. Status and ownership

| Field                        | Value                                                                                                                                                                         |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented - pending manual review                                                                                                                                           |
| System maturity              | Partial                                                                                                                                                                       |
| API layer                    | Component API                                                                                                                                                                 |
| Component slug               | `menu`                                                                                                                                                                        |
| Category                     | Actions                                                                                                                                                                       |
| Priority                     | Tier B - Common reusable component                                                                                                                                            |
| Rendered evidence route           | `not installed`                                                                                                                                      |
| Canonical doc                | `docs/02-standards/ui/components/menu.md`                                                                                                                                     |
| Source owner                 | `not installed`                                                                                                                                      |
| Blade API                    | `x-ui.menu`; `x-ui.menu-item`                                                                                                                                                 |
| JavaScript API               | `initMenus` exported from `resources/js/ui-controls/menus.js`                                                                                                                 |
| Data attributes              | Component-owned `data-ui-menu*` hooks documented in this standard                                                                                                             |
| Source files                 | `resources/views/components/ui/menu/index.blade.php`; `resources/views/components/ui/menu-item/index.blade.php`; `resources/js/ui-controls/menus.js`; `resources/css/components/menu.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons                                                                                                                             |
| Carbon benchmark             | Carbon Menu, Menu buttons, and Overflow menu usage, style, and accessibility guidance                                                                                         |

`Implemented - pending manual review` means the component API, behavior initializer, and rendered evidence page are installed, but the canonical standard must be reviewed against the rendered implementation before the status can move to fully implemented. Until that review is complete, new feature work must stay within this documented API and must not extend Menu locally.

## 3. Installed standard

Menu is installed as a Blade component plus JavaScript behavior initializer. The approved production API is `x-ui.menu` for the trigger/panel composition and `x-ui.menu-item` for individual action items when slot composition is needed. Array-driven menu item data is allowed where the component renders the same installed item contract.

### The installed standard is:

- Use `x-ui.menu` for action menus, contextual menus, and row overflow menus.
- Use `x-ui.menu-item` or the documented item data contract for each action item.
- Initialize menu behavior through `initMenus`; do not write feature-local toggle scripts.
- Use a visible text trigger when the menu represents a page, object, or region action set.
- Use an icon-only overflow trigger only for dense row, card, toolbar, or table actions and only with a specific accessible trigger label.
- Use menu items for commands or command-like links, not long-form content.
- Keep menu-button menus to five items or fewer.
- Keep overflow/context menus to twelve items or fewer.
- Group related items with dividers when grouping improves scanning or when destructive actions are present.
- Put destructive actions in the final group and use the danger item treatment.
- Use disabled items only when the action may become available in the current context.
- Hide permission-impossible actions instead of rendering them disabled.
- Support one submenu level only.
- Use keyboard shortcuts as metadata, not as the primary action label.
- Use selected/checkable item states only for compact command settings, not as a replacement for form selection controls.
- Keep selected, unselected, and non-select menu item labels aligned when they appear in the same menu.
- Use approved placements and RTL mirroring; do not create local positioning logic.
- Parent Patterns own external spacing, table row context, page header grouping, and workflow orchestration.

Carbon alignment note: Carbon documents Menu anatomy as a trigger, action items, dividers, submenu indicators, shortcuts, selected items, submenus, and a menu container; it documents dividers, shortcuts, single-select/multi-select visual treatment, danger hover, four item sizes, minimum/maximum menu width, and keyboard/ARIA behavior. Login App maps those principles to its own `x-ui.menu`, `x-ui.menu-item`, `initMenus`, internal icon components, and app-owned `ui-*` classes rather than adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical calls

Use the array-driven API when items can be expressed as simple action data.

```blade
@php
    $items = [
        [
            'label' => 'Edit tenant',
            'href' => route('admin.tenants.edit', $tenant),
        ],
        [
            'label' => 'Duplicate tenant',
            'href' => route('admin.tenants.duplicate', $tenant),
        ],
        ['type' => 'divider'],
        [
            'label' => 'Delete tenant',
            'href' => route('admin.tenants.destroy', $tenant),
            'danger' => true,
        ],
    ];
@endphp

<x-ui.menu
    :items="$items"
    trigger-label="Actions"
    placement="bottom-end"
    size="md"
/>
```

Use an icon-only overflow trigger for row actions when the table/card context already names the object.

```blade
<x-ui.menu
    :items="$rowActions"
    trigger-label="Open actions for {{ $tenant->name }}"
    trigger-icon="overflow-menu--vertical"
    trigger-variant="ghost"
    placement="bottom-end"
    size="sm"
/>
```

Use the slot API when an item needs custom Blade composition that still follows the installed menu item contract.

```blade
<x-ui.menu trigger-label="Export" placement="bottom-start" size="md">
    <x-ui.menu-item href="{{ route('reports.export', ['format' => 'csv']) }}">
        Export CSV
    </x-ui.menu-item>

    <x-ui.menu-item href="{{ route('reports.export', ['format' => 'xlsx']) }}">
        Export XLSX
    </x-ui.menu-item>

    <x-ui.menu-item type="divider" />

    <x-ui.menu-item danger href="{{ route('reports.delete') }}">
        Delete report
    </x-ui.menu-item>
</x-ui.menu>
```

Use selected/checkable item states only for compact command settings.

```blade
<x-ui.menu trigger-label="Sort" placement="bottom-start" size="md">
    <x-ui.menu-item selected selection-type="single" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">
        Newest first
    </x-ui.menu-item>

    <x-ui.menu-item selection-type="single" href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">
        Oldest first
    </x-ui.menu-item>
</x-ui.menu>
```

Do not hand-build menu buttons, dropdown panels, overflow menus, or row action menus in feature views.

### 4.2. API surfaces

| API surface            | Installed value                                                                                                                                                               |
| ---------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Menu Blade API         | `x-ui.menu`                                                                                                                                                                   |
| Menu item Blade API    | `x-ui.menu-item`                                                                                                                                                              |
| JavaScript initializer | `initMenus` from `resources/js/ui-controls/menus.js`                                                                                                                          |
| Root semantic element  | Component-owned wrapper containing a native trigger button and menu panel                                                                                                     |
| Trigger semantics      | Native `<button>` with `aria-haspopup="menu"`, `aria-expanded`, and `aria-controls`                                                                                           |
| Menu semantics         | Panel with `role="menu"`; items use `role="menuitem"`, `role="menuitemcheckbox"`, or `role="menuitemradio"` as applicable                                                     |
| Data attributes        | Component-owned `data-ui-menu*` hooks documented below                                                                                                                        |
| CSS namespace          | App-owned `ui-*` menu classes documented by the component implementation                                                                                                      |
| Source files           | `resources/views/components/ui/menu/index.blade.php`; `resources/views/components/ui/menu-item/index.blade.php`; `resources/js/ui-controls/menus.js`; `resources/css/components/menu.css` |

### 4.3. JavaScript initializer

Menu behavior must be initialized through the shared UI controls entry point.

```js
import { initMenus } from './ui-controls/menus';

initMenus();
```

When server-rendered HTML is injected after the initial page load, re-run the initializer against the smallest available container.

```js
import { initMenus } from './ui-controls/menus';

initMenus(containerElement);
```

Feature views must not add custom `onclick` handlers, Bootstrap dropdown behavior, Alpine-only local disclosure state, or one-off keyboard handlers for menus. If the installed initializer cannot support a needed behavior, update the component owner, this standard, rendered evidence proof, and tests before using the behavior in production.

### 4.4. `x-ui.menu` props and options

| Prop/option       | Type            | Default                                                      | Allowed values                                       | Required | Notes                                                                                                                     |
| ----------------- | --------------- | ------------------------------------------------------------ | ---------------------------------------------------- | -------- | ------------------------------------------------------------------------------------------------------------------------- |
| `items`           | `array / null`  | `null`                                                       | Array matching the item data contract                | No       | Use for simple menus. Slot items may be used instead.                                                                     |
| `trigger-label`   | `string`        | none                                                         | Short action/disclosure label                        | Yes      | Visible for standard triggers; accessible label for icon-only triggers.                                                   |
| `trigger-icon`    | `string / null` | `null`                                                       | Internal icon alias/component                    | No       | Use `overflow-menu--vertical` for row overflow menus unless the component owner approves another icon.               |
| `trigger-variant` | `string`        | `tertiary` for labeled menus; `ghost` for icon-only overflow | `primary`, `tertiary`, `ghost`                       | No       | Aligns trigger with Button hierarchy. Do not invent menu-only trigger colors.                                             |
| `size`            | `string`        | `md`                                                         | `xs`, `sm`, `md`, `lg`                               | No       | Item height and trigger density must match where the trigger is button-like.                                              |
| `placement`       | `string`        | `bottom-start`                                               | `bottom-start`, `bottom-end`, `top-start`, `top-end` | No       | Placement must mirror in RTL contexts.                                                                                    |
| `disabled`        | `bool`          | `false`                                                      | `true`, `false`                                      | No       | Disables the trigger and prevents opening.                                                                                |
| `id`              | `string / null` | generated                                                    | Unique DOM ID root                                   | No       | Required only when external tests or labels need stable IDs.                                                              |
| `menu-label`      | `string / null` | derived from `trigger-label`                                 | Short label for the menu panel                       | No       | Use when the trigger label alone is not enough for the panel context.                                                     |
| `class`           | `string / null` | `null`                                                       | Layout passthrough if supported                      | No       | Parent Patterns may pass layout classes. Do not use for local color, state, typography, placement, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the rendered evidence proof before production use.

### 4.5. `x-ui.menu-item` props and options

| Prop/option          | Type                  | Default  | Allowed values                               | Required                         | Notes                                                                                                           |
| -------------------- | --------------------- | -------- | -------------------------------------------- | -------------------------------- | --------------------------------------------------------------------------------------------------------------- |
| Slot/`label`         | `string / HtmlString` | none     | Short action label                           | Required for action items        | Use sentence case and concrete command labels.                                                                  |
| `type`               | `string`              | `item`   | `item`, `divider`                            | No                               | Divider items are not focusable and do not need labels.                                                         |
| `href`               | `string / null`       | `null`   | Valid URL generated by Laravel route helpers | No                               | Use for command-like navigation. External destinations must be clear in the label or context.                   |
| `button` / no `href` | boolean behavior      | inferred | Component renders a button item              | No                               | Use when JavaScript or form behavior is owned by the parent Pattern.                                            |
| `action`             | `string / null`       | `null`   | App-owned action identifier                  | No                               | Metadata hook only. The owning Pattern or controller owns execution.                                            |
| `method`             | `string / null`       | `null`   | `GET`, `POST`, `PATCH`, `DELETE`             | No                               | Metadata hook only. Non-GET form submission remains gated until a submission contract exists.                   |
| `tone`               | `string / null`       | `null`   | `danger`                                     | No                               | Preferred array/prop hook for destructive item treatment.                                                       |
| `danger`             | `bool`                | `false`  | `true`, `false`                              | No                               | Use only for destructive or high-impact actions.                                                                |
| `danger-description` | `string / null`       | `null`   | Short assistive warning                      | No                               | Adds hidden assistive text for destructive items that need additional context.                                  |
| `disabled`           | `bool`                | `false`  | `true`, `false`                              | No                               | Use only when the action may become available later.                                                            |
| `selected`           | `bool`                | `false`  | `true`, `false`                              | No                               | Use with `selection-type` for checkable command settings.                                                       |
| `selection-type`     | `string / null`       | `null`   | `single`, `multi`                            | Required when `selected` is used | Maps to `menuitemradio` or `menuitemcheckbox` semantics.                                                        |
| `shortcut`           | `string / null`       | `null`   | Short key chord text                         | No                               | Metadata only. Do not use as the action label.                                                                  |
| `submenu`            | `bool`                | `false`  | `true`, `false`                              | No                               | Marks a submenu trigger when slot composition owns the submenu panel. Prefer `children` for array-driven menus. |
| `children`           | `array / null`        | `null`   | One nested item array                        | No                               | One submenu level only. Deeper nesting is prohibited.                                                           |
| `title`              | `string / null`       | `null`   | Full label text                              | No                               | Use for rare truncated labels when the full label must be exposed.                                              |
| `class`              | `string / null`       | `null`   | Not for visual overrides                     | No                               | Do not use to create local item states.                                                                         |

### 4.6. Item data contract

Array-driven menus must use the same contract as the Blade item API.

| Field               | Type                          | Required                                            | Notes                                                                     |
| ------------------- | ----------------------------- | --------------------------------------------------- | ------------------------------------------------------------------------- |
| `type`              | `item / divider`              | No                                                  | Defaults to `item`. Divider entries are separators and are not focusable. |
| `label`             | `string`                      | Required for `item`                                 | Rendered as the menu item label.                                          |
| `href`              | `string / null`               | No                                                  | Use for command-like links. Prefer route helpers.                         |
| `action`            | `string / null`               | No                                                  | App-owned action identifier emitted as metadata.                          |
| `method`            | `GET / POST / PATCH / DELETE` | No                                                  | Metadata only; non-GET submission remains gated.                          |
| `tone`              | `danger / null`               | No                                                  | Preferred destructive item hook.                                          |
| `danger`            | `bool`                        | No                                                  | Applies destructive item treatment.                                       |
| `dangerDescription` | `string / null`               | No                                                  | Hidden assistive warning for destructive items that need context.         |
| `dividerBefore`     | `bool`                        | No                                                  | Inserts a separator before the item without creating an unlabeled row.    |
| `disabled`          | `bool`                        | No                                                  | Renders disabled state only when the action may become available.         |
| `hidden`            | `bool`                        | No                                                  | Use for permission-impossible actions. Hidden items are not rendered.     |
| `selected`          | `bool`                        | No                                                  | Shows selected/checkable state.                                           |
| `selectionType`     | `single / multi`              | Required when selected/checkable semantics are used | Selects `menuitemradio` or `menuitemcheckbox` semantics.                  |
| `shortcut`          | `string / null`               | No                                                  | Renders a keyboard shortcut or equivalent secondary metadata.             |
| `children`          | `array / null`                | No                                                  | One-level submenu items. Children must follow this same contract.         |
| `title`             | `string / null`               | No                                                  | Full text for rare truncated labels.                                      |
| `ariaLabel`         | `string / null`               | No                                                  | Use only when visible label needs additional accessible context.          |

### 4.7. Data attribute contract

Data attributes are component-owned implementation hooks. They may be emitted by `x-ui.menu` and `x-ui.menu-item`, and they may appear in rendered evidence examples to prove the implementation. Feature views must not invent new data attributes for menu behavior.

| Attribute                      | Owner            | Purpose                                                                                |
| ------------------------------ | ---------------- | -------------------------------------------------------------------------------------- |
| `data-ui-menu`                 | `x-ui.menu`      | Root initializer scope for one menu instance.                                          |
| `data-ui-menu-trigger`         | `x-ui.menu`      | Trigger button controlled by the initializer.                                          |
| `data-ui-menu-panel`           | `x-ui.menu`      | Menu panel controlled by the initializer.                                              |
| `data-ui-menu-item`            | `x-ui.menu-item` | Focusable menu action used by roving focus.                                            |
| `data-ui-menu-submenu-trigger` | `x-ui.menu-item` | One-level submenu trigger item.                                                        |
| `data-ui-menu-submenu-panel`   | `x-ui.menu-item` | One-level submenu panel.                                                               |
| `data-ui-menu-close`           | `x-ui.menu-item` | Item activation closes the active menu unless the component owner documents otherwise. |
| `data-ui-menu-action`          | `x-ui.menu-item` | Optional action metadata for the owning Pattern/controller.                            |
| `data-ui-menu-method`          | `x-ui.menu-item` | Optional method metadata; non-GET submission execution is not owned by Menu yet.       |
| `data-ui-menu-divider`         | `x-ui.menu-item` | Non-focusable separator emitted by divider items and `dividerBefore`.                  |
| `data-ui-menu-placement`       | `x-ui.menu`      | Placement hook for `bottom-start`, `bottom-end`, `top-start`, or `top-end`.            |

Runtime state attributes or classes set by `initMenus` are not public authoring API unless they are documented here.

### 4.8. Semantic structure contract

A rendered menu must follow this semantic structure or an equivalent component-owned structure:

```blade
<div class="ui-menu" data-ui-menu data-ui-menu-placement="bottom-end">
    <button
        type="button"
        class="ui-menu-trigger"
        data-ui-menu-trigger
        aria-haspopup="menu"
        aria-expanded="false"
        aria-controls="tenant-actions-menu"
    >
        Actions
    </button>

    <ul
        id="tenant-actions-menu"
        class="ui-menu-panel"
        data-ui-menu-panel
        role="menu"
        hidden
    >
        <li role="none">
            <a class="ui-menu-item" data-ui-menu-item role="menuitem" href="#">
                Edit tenant
            </a>
        </li>
    </ul>
</div>
```

The rendered implementation may differ in internal element names only when it preserves the same semantics, focus behavior, state synchronization, and class/data-hook ownership.

## 5. Allowed variants, options, and modifiers

| Name                       | Type               | Status                       | API                                                                         | Notes                                                                             |
| -------------------------- | ------------------ | ---------------------------- | --------------------------------------------------------------------------- | --------------------------------------------------------------------------------- |
| Contextual action menu     | Mode               | Implemented                  | `<x-ui.menu trigger-label="Actions" />`                                     | Use for object-level or region-level grouped actions.                             |
| Row action overflow menu   | Mode               | Implemented                  | `trigger-icon="overflow-menu--vertical"` with specific `trigger-label` | Use in table rows, cards, and compact surfaces.                                   |
| Labeled trigger            | Trigger variant    | Implemented                  | `trigger-label` visible                                                     | Preferred when menu is page-level or object-level.                                |
| Icon-only overflow trigger | Trigger variant    | Implemented                  | `trigger-icon` plus `trigger-label`                                         | Requires object-specific accessible label.                                        |
| Primary trigger            | Trigger semantic   | Implemented                  | `trigger-variant="primary"`                                                 | Use sparingly when the grouped actions collectively represent the primary action. |
| Tertiary trigger           | Trigger semantic   | Implemented                  | `trigger-variant="tertiary"`                                                | Standard visible menu button treatment.                                           |
| Ghost trigger              | Trigger semantic   | Implemented                  | `trigger-variant="ghost"`                                                   | Standard row/card overflow treatment.                                             |
| Extra small                | Size               | Implemented / required proof | `size="xs"`                                                                 | Dense row/item contexts only.                                                     |
| Small                      | Size               | Implemented / required proof | `size="sm"`                                                                 | Compact table, card, and toolbar contexts.                                        |
| Medium                     | Size               | Implemented / required proof | `size="md"`                                                                 | Default product UI menu size.                                                     |
| Large                      | Size               | Implemented / required proof | `size="lg"`                                                                 | Spacious page header or empty-state contexts.                                     |
| Bottom start               | Placement          | Implemented                  | `placement="bottom-start"`                                                  | Default left/start aligned dropdown.                                              |
| Bottom end                 | Placement          | Implemented                  | `placement="bottom-end"`                                                    | Common row overflow alignment.                                                    |
| Top start                  | Placement          | Implemented                  | `placement="top-start"`                                                     | Use near bottom viewport boundaries when proven.                                  |
| Top end                    | Placement          | Implemented                  | `placement="top-end"`                                                       | Use near bottom viewport boundaries for end-aligned triggers.                     |
| RTL mirrored placement     | Placement behavior | Implemented / required proof | Direction-aware placement                                                   | Start/end must mirror in RTL contexts.                                            |
| Dividers                   | Composition        | Implemented                  | `type="divider"` or `['type' => 'divider']`                                 | Group related actions and separate destructive actions.                           |
| Keyboard shortcut text     | Modifier           | Implemented                  | `shortcut`                                                                  | Secondary metadata only.                                                          |
| Selected item              | State/composition  | Implemented                  | `selected`                                                                  | Use for compact checkable command settings.                                       |
| Single-select menu item    | Selection mode     | Implemented                  | `selection-type="single"`                                                   | Maps to radio-style menu item semantics.                                          |
| Multi-select menu item     | Selection mode     | Implemented                  | `selection-type="multi"`                                                    | Maps to checkbox-style menu item semantics; not a form multiselect replacement.   |
| Danger item                | Item semantic      | Implemented                  | `danger`                                                                    | Use for destructive/high-impact actions.                                          |
| Disabled item              | Item state         | Implemented                  | `disabled`                                                                  | Use only when the action may become available later.                              |
| One-level submenu          | Composition        | Implemented with boundary    | `children` / `submenu`                                                      | One nested level only. Do not add deeper nesting.                                 |
| Combo/split menu button    | Gated              | Not public on `x-ui.menu`    | none                                                                        | Requires separate Menu buttons or Button API proof before production use.         |
| Context/right-click menu   | Deferred           | Not implemented              | none                                                                        | Requires pointer/keyboard parity, placement, focus, and dismissal proof.          |
| Typeahead/filterable menu  | Deferred           | Not implemented              | none                                                                        | Use Select/Combobox Pattern when selection/filtering is required.                 |
| Deep nested submenu        | Not allowed        | Prohibited                   | none                                                                        | One-level boundary only.                                                          |

## 6. States

| State                  | Status                      | Implementation requirement                                                                                           |
| ---------------------- | --------------------------- | -------------------------------------------------------------------------------------------------------------------- |
| Closed                 | Implemented                 | Trigger has `aria-expanded="false"`; panel is hidden and not reachable by arrow navigation.                          |
| Open                   | Implemented                 | Trigger has `aria-expanded="true"`; panel is visible; first enabled item receives focus.                             |
| Enabled item           | Implemented                 | Item can receive roving focus and activate through pointer, Enter, or Space.                                         |
| Hover                  | Implemented                 | Token-backed item hover treatment; must not be used as static styling.                                               |
| Focus-visible          | Implemented                 | Token-backed item and trigger focus treatment visible in all supported themes.                                       |
| Focus and hover        | Implemented                 | Combined state remains readable and preserves focus visibility.                                                      |
| Active/pressed         | Implemented                 | Activation state is transient and token-backed.                                                                      |
| Selected               | Implemented                 | Selected/checkable items expose `aria-checked` where the role requires it and show the approved selected indicator.  |
| Danger                 | Implemented                 | Destructive item treatment applies to item text/interactive states and must use explicit destructive copy.           |
| Danger hover           | Implemented                 | Hover treatment reinforces danger without relying on color alone.                                                    |
| Danger hover and focus | Implemented                 | Combined state keeps visible focus and danger treatment.                                                             |
| Disabled trigger       | Implemented                 | Native trigger `disabled` prevents opening.                                                                          |
| Disabled item          | Implemented                 | Disabled item remains visible only when it may become available; it is skipped by keyboard activation.               |
| Expanded submenu       | Implemented with boundary   | One-level submenu item has synchronized `aria-haspopup` and `aria-expanded`.                                         |
| Collapsed submenu      | Implemented with boundary   | One-level submenu is hidden and trigger item remains navigable.                                                      |
| Empty                  | Not allowed                 | Do not render a menu with no visible enabled or disabled items. Hide the trigger instead.                            |
| Loading                | Not applicable              | Menus do not own async loading. Use disabled items, Inline loading, or Pattern-owned pending state outside the menu. |
| Validation             | Not applicable              | Menus are command surfaces, not form validation controls.                                                            |
| Read-only              | Not applicable              | Menus expose commands. Read-only views should hide edit/action menus or show non-interactive summaries.              |
| Current page           | Not applicable by default   | Use navigation APIs for current-page state. Menu selected state is for command settings, not primary navigation.     |
| Overflow/truncated     | Implemented with constraint | Long labels may truncate only when the full label is exposed through title text or approved disclosure.              |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Menu consumes Foundation Color, Spacing, Typography, Themes, Motion, and Icons.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                        |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| Color       | Trigger, panel, border, item text, icon, divider, hover, focus, selected, disabled, danger, and high-contrast theme roles.           |
| Spacing     | Trigger gap, item padding, menu panel inset, divider spacing, submenu offset, shortcut alignment, and selected indicator spacing.    |
| Typography  | Trigger labels, item labels, shortcuts, metadata, and truncated-label behavior.                                                      |
| Themes      | Light/dark/inverse token resolution for trigger, panel, item, divider, selected, disabled, and danger states.                        |
| Motion      | Productive open/close or transform transitions where installed; must respect reduced-motion preferences.                             |
| Icons       | Trigger carets, overflow icon, selected/check indicators, submenu indicators, and optional item icons through the Icons Element API. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-menu
.ui-menu-open
.ui-menu-trigger
.ui-menu-trigger-icon
.ui-menu-panel
.ui-menu-list
.ui-menu-item
.ui-menu-item-label
.ui-menu-item-icon
.ui-menu-item-shortcut
.ui-menu-item-selected
.ui-menu-item-danger
.ui-menu-item-disabled
.ui-menu-divider
.ui-menu-submenu-trigger
.ui-menu-submenu-panel
.ui-menu-submenu-indicator
.ui-menu-xs
.ui-menu-sm
.ui-menu-md
.ui-menu-lg
.ui-menu-placement-bottom-start
.ui-menu-placement-bottom-end
.ui-menu-placement-top-start
.ui-menu-placement-top-end
```

Feature views must not create local `dropdown-*`, `menu-*`, `overflow-*`, `actions-menu-*`, Bootstrap `.dropdown-menu`, raw utility clusters, arbitrary colors, arbitrary spacing, custom focus rings, local SVG icons, or custom JavaScript for the same UI role.

## 8. Composition rules

- Clicking or pressing Enter/Space on the trigger opens the menu.
- Opening the menu synchronizes `aria-expanded="true"` and focuses the first enabled item.
- Escape closes the menu and returns focus to the trigger.
- Tab closes the menu and lets browser focus continue naturally.
- Clicking outside the menu closes it.
- Activating an item closes the menu unless the component owner documents a specific checkable non-closing behavior.
- Up and Down arrows move between enabled items.
- Home and End move to the first and last enabled items when implemented by `initMenus`.
- Enter and Space activate the focused item.
- Disabled items are skipped by activation and should be skipped by roving focus unless the implementation intentionally exposes them for screen-reader context.
- One-level submenus open only from an explicit submenu interaction such as pointer hover, click, or the direction-aware submenu arrow key. Opening the parent menu or moving focus onto a submenu row must not expand the submenu by itself.
- Right and Left arrows may open and close one-level submenus; direction must account for RTL contexts so RTL submenus open to the visual left of the parent menu and close from the mirrored arrow.
- Submenus are one-level boundaries only. Do not add second-level or deeper submenu trees.
- The trigger, panel, and item IDs/ARIA attributes must remain synchronized after server-rendered list changes.
- Dividers must not be focusable.
- Danger items should appear in the final group and be separated from regular actions when destructive risk is significant.
- Permission-impossible actions should be hidden instead of disabled.
- Menu items that open modals or destructive confirmations must hand off to Modal or Overlay/feedback Patterns after activation.
- Menu items may navigate when the target is a command-like destination, such as `View details`; use Link/navigation APIs for primary navigation lists.
- Parent Patterns own trigger placement, table row context, page header grouping, menu count, and external spacing.
- Components own internal semantics, styling, keyboard behavior, focus management, item states, and token-backed classes.

## 9. Selection guidance

### 9.1. Use when:

- Several contextual actions belong behind one trigger.
- Actions affect the same object, row, card, page section, or page-level workflow.
- A table row or dense card needs overflow actions.
- Actions are secondary enough that they should not crowd the page.
- Related actions benefit from dividers, selected state, shortcut metadata, or a one-level submenu.
- A destructive action belongs with other object actions but should be visually separated and marked danger.

### 9.2. Do not use when:

- The action is primary and should be visible as a Button.
- The user is choosing a form value from a list. Use Select, Checkbox, Radio button, or a Forms Pattern.
- The user is navigating across major app destinations. Use navigation, tabs, breadcrumbs, or links.
- The content requires rich text, paragraphs, forms, or media. Use Popover, Modal, or a Pattern-owned overlay.
- There are more than five items in a menu-button menu.
- There are more than twelve items in an overflow/context menu.
- The action set requires multiple nested submenu levels.
- The action set needs search, filtering, typeahead, or virtualized long-list behavior.
- The menu would hide a critical destructive action that needs explicit confirmation and visible context.

### 9.3. Selection matrix:

| Need                                             | Use                                                                            |
| ------------------------------------------------ | ------------------------------------------------------------------------------ |
| Page/object actions with similar importance      | Contextual action menu with visible trigger                                    |
| Dense table row or card actions                  | Icon-only overflow menu with object-specific accessible label                  |
| One primary action plus lesser alternatives      | Visible Button plus Menu for secondary actions; do not hide the primary action |
| Repeated shared action term across several items | Move the shared term to the trigger or submenu label                           |
| Destructive command mixed with safe actions      | Divider plus `danger` item in the final group                                  |
| Current compact setting such as sort mode        | Selected single-select menu item                                               |
| Several compact toggles                          | Selected multi-select menu items only when not a form replacement              |
| Many options or user value selection             | Select/Combobox/Checkbox/Radio APIs, not Menu                                  |
| Multi-step destructive flow                      | Menu item opens Modal/Overlay confirmation                                     |

## 10. Accessibility contract

- The trigger must be a native button.
- The trigger must expose `aria-haspopup="menu"`.
- The trigger must keep `aria-expanded` synchronized with the panel visibility.
- The trigger must reference the panel with `aria-controls` when the panel has a stable ID.
- Icon-only triggers must have a specific accessible label that names the object or action set.
- The menu panel must use `role="menu"` or an equivalent component-owned ARIA structure.
- Menu items must use `role="menuitem"`, `role="menuitemcheckbox"`, or `role="menuitemradio"` as appropriate.
- Items that contain submenus must expose `aria-haspopup` and synchronized `aria-expanded`.
- Selected/checkable items must expose selected or checked state with the correct ARIA attribute for their role.
- Disabled items must expose disabled state and must not activate.
- Divider rows must not be focusable.
- Keyboard users must be able to open, navigate, activate, and close the menu without pointer input.
- Opening the menu focuses the first enabled item.
- Escape closes the menu and returns focus to the trigger.
- Clicking outside closes the menu without trapping focus.
- Focus-visible treatment must remain visible in all supported themes and in combined hover/focus states.
- Meaning must not rely on color alone for selected, disabled, or danger states.
- Long truncated labels must expose the full label through browser title text or an approved disclosure.
- RTL menus must mirror the full menu surface, including item direction, shortcut placement, submenu panel side, and submenu caret direction.
- Permission-impossible actions should be hidden instead of disabled to avoid announcing actions the user can never take.
- Menus must not be hover-only. Pointer hover may preview item states, but opening and operation must be click and keyboard accessible.

## 11. Content contract

- Use sentence case.
- Use short, precise action labels.
- Prefer verb-led labels: `Edit tenant`, `Duplicate report`, `Archive workspace`, `Delete user`.
- Use `Actions` only when grouped actions are distinct and no shared verb describes them.
- Use a shared trigger label when the items share a verb or object. For example, use trigger `Create` with items `Tenant`, `Workspace`, and `Invite`, not repeated `Create tenant`, `Create workspace`, and `Create invite` when the repeated term makes scanning slower.
- Order actions by expected use.
- Group related actions with dividers.
- Put destructive actions last and use explicit destructive text.
- When selected/checkable rows appear with unselected or non-select rows, reserve the same indicator column so labels align consistently.
- Do not use vague labels such as `More`, `Options`, `Go`, or `Submit` when a specific object/action label is possible.
- Do not use icon-only triggers with generic labels such as `More options` in row contexts. Include the object context: `Open actions for Acme tenant`.
- Use shortcut text only for real shortcuts or established command metadata.
- Keep labels short enough to scan. Use browser title text only for rare truncation cases.
- When a term repeats across more than two actions, move the shared term to the trigger or submenu label.
- Submenu labels must describe the grouped child actions.
- Danger item labels must name the destructive outcome directly.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, custom focus rings, or custom JavaScript.
- Do not use Bootstrap `.dropdown`, `.dropdown-menu`, `data-bs-toggle="dropdown"`, or feature-local dropdown scripts for app menus.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*` in app markup.
- Do not hide primary actions that should be visible.
- Do not put more than five items in menu-button menus.
- Do not put more than twelve items in overflow/context menus.
- Do not add multiple nested submenu levels.
- Do not use hover-only menus.
- Do not render menus with no visible items.
- Do not use disabled items for actions blocked by permissions permanently; hide those actions.
- Do not put form fields, long descriptions, rich content, or media inside a menu.
- Do not use Menu as a replacement for Select, Dropdown, Checkbox, Radio button, Tabs, Breadcrumbs, or navigation.
- Do not create local danger colors, selected indicators, submenu carets, overflow icons, or shortcut layouts.
- Do not truncate labels unless the full label is still available through approved title/disclosure behavior.
- Do not create local placement or collision-detection logic outside `initMenus`.
- Do not call `x-ui.menu` for combo/split button behavior until that API is installed and documented.

## 13. Deferred or gated capabilities

| Capability                                      | Status      | Gate                                                                                                                                                                            |
| ----------------------------------------------- | ----------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Combo/split menu button                         | Gated       | Requires dedicated Menu buttons or Button API ownership, trigger/action split semantics, keyboard proof, and rendered evidence examples.                                             |
| Context/right-click menu                        | Deferred    | Requires pointer and keyboard trigger parity, focus management, collision handling, dismissal rules, and rendered evidence proof.                                                    |
| Deep nested submenu                             | Not allowed | One-level submenu boundary only. Requires new accessibility review before any deeper nesting.                                                                                   |
| Typeahead/search/filterable menu                | Deferred    | Requires search input semantics, results management, keyboard model, and proof. Use Select/Combobox Pattern when the user is choosing values.                                   |
| Async item loading                              | Deferred    | Requires loading semantics, disabled/pending item behavior, error recovery, and Pattern ownership.                                                                              |
| Virtualized or scroll-heavy action menu         | Deferred    | Requires long-list keyboard proof and content strategy. Prefer visible pages, tables, or selection components.                                                                  |
| Custom placement/collision strategies           | Gated       | Must be implemented in `initMenus`, documented in this standard, and proven in rendered evidence.                                                                                    |
| Arbitrary item icons                            | Gated       | Requires Icons Element alignment and item layout proof. Do not add local icons to menu items.                                                                                   |
| Form submission menu items with non-GET methods | Gated       | Menu may emit `data-ui-menu-method` metadata, but execution requires CSRF/method spoofing contract, confirmation rules, and tests. Prefer explicit forms or confirmation flows. |
| Non-closing multi-select menus                  | Gated       | Requires documented interaction model, checked-state announcements, Escape/outside dismissal behavior, and tests.                                                               |

Future extensions require an updated Component standard and rendered evidence proof before production use.

## 14. Implementation and Rendered Evidence Checklist
### 14.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states are defined as relevant.   |
| Accessibility/content      | Keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements are defined.                                  |
| Element consumption        | Required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies are named.                                                    |
| Tests                      | Source/API assertions and Rendered evidence route assertions block generic fallback content.                                                            |

### 14.2. rendered evidence proof checklist
| Requirement               | Visual proof expectation                                                                              |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Live examples             | The page renders production examples through the documented API or explicit native/class contract.    |
| Rendered variants/options | Every applicable supported variant, option, size, modifier, or deferred trigger condition is shown.   |
| Rendered states           | Required states are shown visually and with accessibility markers where relevant.                     |
| Developer implementation  | Real canonical calls and token-backed code snippets appear instead of placeholder comments.           |
| Related APIs              | Nearby Components, owning Patterns, consumed Elements, source files, and canonical docs are linked.   |
| Manual review             | The page provides enough rendered proof for visual review of behavior, layout, and state correctness. |
## 15. Rendered evidence requirements

The rendered evidence page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Menu page is a broad action component reference page. The Live examples card may use matrices, grouped examples, keyboard notes, alignment demos, and state tables. It must not use generic placeholder scaffolding or fake menu controls that bypass `x-ui.menu` and `initMenus`.

### 15.1. Required Live examples internal sections:

| Required proof              | Rendered behavior                                                                                                                                       | Variants/options shown                                                                                                                       |
| --------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------- |
| Contextual action menu      | A labeled menu button opens object-level actions in predictable order and returns focus on close.                                                       | Enabled item, Hover item, Focus item, Focus and hover, Danger item, Danger hover, Danger hover and focus, Disabled item                      |
| Row action menu             | Table/card rows use icon-only overflow triggers with object-specific accessible labels and short menus.                                                 | Divided groups, Extra small, Small, Medium, Large, Icon-only trigger, Disabled item                                                          |
| Grouped and selected menu   | Dividers, selected rows, shortcuts, title tooltips, multi-section groups, and submenu indicators keep larger menus scannable.                           | Dividers, Multi-section grouping, Keyboard shortcut, Submenu actions, Single-select, Multi-select, Selected item, Truncated label with title |
| Alignment and RTL           | Open menus align to available space and mirror start/end, item direction, shortcut direction, submenu side, and caret direction in RTL contexts.        | Bottom start, Bottom end, Top start, Top end, RTL mirrored                                                                                   |
| Size scale                  | Approved item sizes render with matching density and no mixed trigger/item height.                                                                      | Extra small, Small, Medium, Large                                                                                                            |
| State matrix                | Menu item states render with token-backed classes and no local CSS.                                                                                     | Default, Hover, Focus-visible, Focus and hover, Selected, Danger, Disabled, Open, Closed                                                     |
| Keyboard behavior           | A developer-facing example documents trigger activation, arrow navigation, Enter/Space activation, Escape close, outside click, and submenu arrows.     | `aria-haspopup`, `aria-expanded`, roving item focus, focus return, one-level submenu                                                         |
| JavaScript implementation   | The page shows the `initMenus` import and initialization contract.                                                                                      | `initMenus`, component-owned data attributes, no local scripts                                                                               |
| Data attribute proof        | Rendered examples expose the installed `data-ui-menu*` hooks through component output or code examples.                                                 | `data-ui-menu`, `data-ui-menu-trigger`, `data-ui-menu-panel`, `data-ui-menu-item`                                                            |
| Content behavior            | Labels demonstrate short action text, grouped destructive actions, object-specific icon-only labels, shortcut metadata, and rare truncation title text. | Sentence case, explicit danger label, title text for truncation, object-specific trigger label                                               |
| Prohibited usage            | The page shows forbidden local markup, Bootstrap dropdowns, direct Carbon classes, hover-only menus, overlong menus, and deep nesting as not allowed.   | Prohibited examples and deferred gates                                                                                                       |
| Related component selection | The page distinguishes Menu from Button, Select/Dropdown, navigation, Tooltip/Popover, Modal, and Table toolbar Patterns.                               | Selection matrix and related APIs                                                                                                            |

The page must show the actual installed API, rendered variants/options, rendered states, JavaScript initializer, data attributes, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- Developer examples use `x-ui.menu`, `x-ui.menu-item`, and `initMenus`.
- Rendered examples include `aria-haspopup="menu"`, synchronized `aria-expanded`, a menu panel, and menu items with appropriate roles.
- Contextual action menu examples include enabled, hover, focus, focus+hover, danger, danger hover, danger hover+focus, and disabled item states.
- Row action examples use icon-only overflow triggers with object-specific accessible labels.
- Row action menus stay short and show divided groups where appropriate.
- Grouped examples include dividers, multi-section grouping, shortcut metadata, selected/checkable items, title text for truncated labels, and working one-level submenu actions.
- Selected/checkable examples prove selected, unselected, and non-select action labels stay aligned through a reserved indicator column.
- Alignment examples include bottom start, bottom end, top start, top end, and RTL mirrored behavior across the trigger and menu panel.
- Size examples include extra small, small, medium, and large.
- Keyboard examples document trigger open, first-item focus, Up/Down navigation, Enter/Space activation, Escape close/focus return, outside click dismissal, and one-level submenu arrow behavior.
- Disabled items remain visible only when the action may become available later.
- Permission-impossible actions are documented as hidden, not disabled.
- Prohibited examples do not render as approved production menus.
- The page contains no generic placeholder content.
- Tests assert stale labels and legacy scaffolding remain absent when they are not part of approved UI copy.
- Tests assert no raw Bootstrap dropdown markup, hard-coded color, arbitrary local spacing, feature-local menu class system, local JavaScript menu controller, or direct Carbon production class is presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Menu');
$response->assertSee('x-ui.menu');
$response->assertSee('x-ui.menu-item');
$response->assertSee('initMenus');
$response->assertSee('data-ui-menu');
$response->assertSee('data-ui-menu-trigger');
$response->assertSee('data-ui-menu-panel');
$response->assertSee('data-ui-menu-item');
$response->assertSee('aria-haspopup="menu"', false);
$response->assertSee('aria-expanded');
$response->assertSee('role="menu"', false);
$response->assertSee('role="menuitem"', false);
$response->assertSee('Contextual action menu');
$response->assertSee('Row action menu');
$response->assertSee('Grouped and selected menu');
$response->assertSee('Alignment and RTL');
$response->assertSee('Extra small');
$response->assertSee('Small');
$response->assertSee('Medium');
$response->assertSee('Large');
$response->assertSee('Danger hover');
$response->assertSee('Danger hover and focus');
$response->assertSee('Single-select');
$response->assertSee('Multi-select');
$response->assertSee('Submenu actions');
$response->assertSee('Bottom start');
$response->assertSee('Bottom end');
$response->assertSee('Top start');
$response->assertSee('Top end');
$response->assertSee('RTL mirrored');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('dropdown-menu');
$response->assertDontSee('data-bs-toggle="dropdown"', false);
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 17. Related APIs

| API                      | Route                                                          |
| ------------------------ | -------------------------------------------------------------- |
| Button                   | `not installed`                     |
| Tooltip                  | `not installed`                    |
| Data table               | `not installed`                 |
| Notification             | `not installed`               |
| Layout Pattern           | `not installed`                       |
| Tables Pattern           | `not installed`                       |
| Forms pattern            | `not installed`                        |
| Overlay/feedback pattern | `not installed`            |
| Color element            | `not installed`                        |
| Spacing element          | `not installed`                      |
| Typography element       | `not installed`                   |
| Themes element           | `not installed`                       |
| Motion element           | `not installed`                       |
| Icons element            | `not installed`                        |
| Components overview      | `not installed`                            |
| Canonical menu doc       | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fmenu.md` |
| Carbon menu usage        | `https://carbondesignsystem.com/components/menu/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Menu usage, style, and accessibility guidance inform menu anatomy, dividers, shortcuts, selected/checkable items, danger treatment, sizing, width, keyboard navigation, ARIA roles, and submenu boundaries. Login App keeps its own Blade API, JavaScript initializer, internal icon standard, app-owned `ui-*` classes, and rendered evidence proof.
- Carbon Menu buttons and Overflow menu guidance inform trigger selection, row overflow use, size alignment, accessible icon-only triggers, and action-count limits. Login App documents only the installed `x-ui.menu` behavior here and gates combo/split/right-click behavior until app-owned proof exists.

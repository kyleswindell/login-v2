---
title: Menu buttons
slug: menu-buttons
status: implemented-pending-review
api_layer: component
category: actions
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/menu-buttons
canonical_doc: docs/02-standards/ui/components/menu-buttons.md
source_owner: /platform/ui-reference/components/menu-buttons
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - button
  - menu
  - dropdown
  - popover
  - tooltip
related_patterns:
  - tables
  - overlays-feedback
  - forms
---

# Menu buttons Component API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Menu button example](#41-menu-button-example)
  - [4.2. Overflow menu example](#42-overflow-menu-example)
  - [4.3. Combo button example](#43-combo-button-example)
  - [4.4. Props/options](#44-propsoptions)
  - [4.5. Menu item data contract](#45-menu-item-data-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed class/API surfaces:](#72-allowed-classapi-surfaces)
  - [7.3. Allowed data attributes:](#73-allowed-data-attributes)
  - [7.4. Token usage requirements:](#74-token-usage-requirements)
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
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Menu buttons expose grouped secondary actions from a button trigger.

Canonical API owner: `/platform/ui-reference/components/menu-buttons`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Menu buttons are an Action Component API. They compose the Button API, Menu behavior, Icons, Motion, and token-backed surfaces to reveal simple command choices. They do not own form selection, free-text entry, complex filtering, navigation hierarchy, or workflow orchestration.

## 2. Status and ownership

| Field              | Value                                                                    |
| ------------------ | ------------------------------------------------------------------------ |
| Status             | Approved API                                                             |
| API layer          | Component API                                                            |
| Component slug     | menu-buttons                                                             |
| Category           | Actions                                                                  |
| Priority           | Tier B - Common reusable component                                       |
| UI Reference route | /platform/ui-reference/components/menu-buttons                           |
| Canonical doc      | docs/02-standards/ui/components/menu-buttons.md                          |
| Source owner       | /platform/ui-reference/components/menu-buttons                           |
| Depends on         | Button, Menu behavior, Icons, Motion, Color, Spacing, Typography, Themes |

## 3. Installed standard

Menu buttons are the app-owned API for revealing grouped secondary actions from a trigger button.

The installed standard must distinguish three dispositions:

| Disposition   | Status                           | Standard                                                                                                                                                                        |
| ------------- | -------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Menu button   | Approved API                     | A labeled button opens a menu of actions with the same relative importance.                                                                                                     |
| Overflow menu | Approved API                     | An icon-only ghost trigger opens additional actions for a table row, card, compact toolbar, or constrained surface.                                                             |
| Combo button  | Approved API                     | A visible primary action is paired with a secondary menu trigger for related alternate actions. The primary action and menu trigger each keep distinct focus and activation behavior. |

This page is component-specific. Do not use this standard as a broad Action, Button, Dropdown, Popover, or Menu correction. If another component needs a similar rule, update that component’s own standard.

Menu buttons must use the flexible UI Reference layout model. The page may use matrices, size scales, state tables, grouped examples, and full-width demonstrations instead of forcing every example into an Accordion-style tabbed layout.

## 4. Public API

| API surface     | Installed value                                                                                                                                                                                                                                           |
| --------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade           | `x-ui.menu-button`, `x-ui.combo-button`, `x-ui.overflow-menu`.                                                                                                                                                                                            |
| JavaScript      | `initMenus` exported from `resources/js/ui-controls/menus.js` or the app-owned equivalent menu initializer.                                                                                                                                               |
| Data attributes | `data-ui-menu-button`, `data-ui-menu-trigger`, `data-ui-menu`, `data-ui-menu-item`, `data-ui-menu-placement`, `data-ui-combo-button`, `data-ui-overflow-menu`.                                                                                             |
| Props/options   | Use the props documented in this standard. Do not add feature-local props without updating this Component standard and UI Reference proof.                                                                                                                |
| CSS namespace   | `ui-menu-button`, `ui-overflow-menu`, `ui-combo-button`, `ui-menu`, `ui-menu-item`, and related app-owned `ui-*` classes.                                                                                                                                 |
| Source files    | Expected owners: `resources/views/components/ui/menu-button.blade.php`, `resources/views/components/ui/combo-button.blade.php`, `resources/views/components/ui/overflow-menu.blade.php`, `resources/js/ui-controls/menus.js`, `resources/css/app.css`.       |

### 4.1. Menu button example

```blade
<x-ui.menu-button
    label="Create"
    type="primary"
    size="md"
    :items="[
        ['label' => 'Workspace', 'action' => 'create-workspace'],
        ['label' => 'Tenant', 'action' => 'create-tenant'],
        ['label' => 'Invite', 'action' => 'create-invite'],
    ]"
/>
```

### 4.2. Overflow menu example

```blade
<x-ui.overflow-menu
    label="Workspace actions"
    size="sm"
    :items="[
        ['label' => 'View details', 'href' => route('workspaces.show', $workspace)],
        ['label' => 'Rename', 'action' => 'rename-workspace'],
        ['label' => 'Archive', 'action' => 'archive-workspace', 'tone' => 'danger'],
    ]"
/>
```

### 4.3. Combo button example

```blade
<x-ui.combo-button
    label="Save"
    action="save"
    :items="[
        ['label' => 'Save and close', 'action' => 'save-close'],
        ['label' => 'Save as draft', 'action' => 'save-draft'],
    ]"
/>
```

### 4.4. Props/options

| Prop        | Applies to   |            Type | Default   | Allowed values                                               | Notes                                                                                               |
| ----------- | ------------ | --------------: | --------- | ------------------------------------------------------------ | --------------------------------------------------------------------------------------------------- |
| `label`     | All triggers |        `string` | required  | non-empty string                                             | Visible for menu/combo. Accessible name for overflow.                                               |
| `items`     | All menus    |         `array` | required  | item data contract                                           | Menu items must be simple actions or links.                                                         |
| `type`      | Menu button  |        `string` | `primary` | `primary`, `tertiary`, `ghost`                               | Mirrors approved Button hierarchy. `tertiary` is the outline visual treatment in the UI Reference.   |
| `size`      | All triggers |        `string` | `md`      | `xs`, `sm`, `md`, `lg`                                       | Menu item height must match trigger size.                                                           |
| `placement` | All menus    |        `string` | `auto`    | `auto`, `bottom-start`, `bottom-end`, `top-start`, `top-end` | Use `auto` unless a bounded surface requires a specific edge.                                       |
| `align`     | All menus    |        `string` | `start`   | `start`, `end`                                               | Use `end` for right-aligned row/card overflow.                                                      |
| `disabled`  | Trigger      |          `bool` | `false`   | `true`, `false`                                              | Disabled trigger cannot open a menu.                                                                |
| `loading`   | Trigger      |          `bool` | `false`   | `true`, `false`                                              | Loading trigger is disabled and keeps a readable label.                                             |
| `icon`      | Menu button  | `string / null` | caret     | approved Heroicon alias                                      | Menu button trigger uses caret by default. Do not use decorative icons as meaning.                  |
| `ariaLabel` | Overflow     | `string / null` | `label`   | non-empty string                                             | Required when the visible trigger is icon-only.                                                     |
| `tooltip`   | Overflow     | `string / null` | `null`    | short text                                                   | Required when the overflow trigger needs visible explanation.                                       |
| `fluid`     | Menu/combo   |          `bool` | `false`   | gated                                                        | Do not use until fluid-width trigger and menu behavior is tested. Ghost triggers must not be fluid. |

### 4.5. Menu item data contract

| Key             |     Type | Required | Allowed values                   | Notes                                                                      |
| --------------- | -------: | -------: | -------------------------------- | -------------------------------------------------------------------------- |
| `label`         | `string` |      Yes | sentence-case command label      | Must describe the command or destination.                                  |
| `action`        | `string` |     null | Conditional                      | app action name                                                            | Use for state-changing commands.                                    |
| `href`          | `string` |     null | Conditional                      | trusted route/URL                                                          | Use for navigation items. Do not mix unclear action/link semantics. |
| `method`        | `string` |       No | `GET`, `POST`, `PATCH`, `DELETE` | Destructive commands require explicit labels and confirmation when needed. |
| `tone`          | `string` |       No | `default`, `danger`              | `danger` is only for destructive menu items, not decoration.               |
| `icon`          | `string` |     null | No                               | approved Heroicon alias                                                    | Icons are optional and must not be the only source of meaning.      |
| `disabled`      |   `bool` |       No | `true`, `false`                  | Disabled items must expose reason in nearby copy or tooltip when needed.   |
| `dividerBefore` |   `bool` |       No | `true`, `false`                  | Use sparingly to separate destructive or distinct groups.                  |

## 5. Allowed variants, options, and modifiers

| Name                         | Type           | Status          | API                         | Use when                                                                                     |
| ---------------------------- | -------------- | --------------- | --------------------------- | -------------------------------------------------------------------------------------------- |
| Menu button                  | Variant        | Approved API    | `x-ui.menu-button`          | All menu actions share the same relative importance.                                         |
| Overflow menu                | Variant        | Approved API    | `x-ui.overflow-menu`        | Row, card, compact toolbar, or constrained surface has secondary actions.                    |
| Combo button                 | Variant        | Approved API    | `x-ui.combo-button`         | One primary action must stay visible while related alternates remain available.              |
| Primary menu button          | Trigger type   | Approved API    | `type="primary"`            | Menu action group is the strongest action in the local region.                               |
| Tertiary menu button         | Trigger type   | Approved API    | `type="tertiary"`           | Menu action group is visible but not primary.                                                |
| Ghost menu button            | Trigger type   | Approved API    | `type="ghost"`              | Menu action group is low-emphasis in a toolbar or header.                                    |
| Primary combo button         | Trigger type   | Approved API    | `x-ui.combo-button`         | Combo buttons are primary-only until a different app decision is documented.                 |
| Ghost overflow trigger       | Trigger type   | Approved API    | `x-ui.overflow-menu`        | Overflow menus use icon-only ghost button treatment.                                         |
| Extra small                  | Size           | Approved API    | `size="xs"`                 | Dense toolbar or table-adjacent actions where installed.                                     |
| Small                        | Size           | Approved API    | `size="sm"`                 | Table rows, cards, and compact panels.                                                       |
| Medium                       | Size           | Approved API    | `size="md"`                 | Default page/header action groups.                                                           |
| Large                        | Size           | Approved API    | `size="lg"`                 | Spacious page-header action groups only.                                                     |
| Disabled trigger             | State/modifier | Approved API    | `disabled`                  | The whole menu is unavailable. Explain why nearby when unclear.                              |
| Loading trigger              | State/modifier | Approved API    | `loading`                   | The trigger command is pending. Keep label visible and disable interaction.                  |
| Destructive menu item        | Item tone      | Approved API    | `tone="danger"`             | A menu item performs a destructive action with explicit copy and confirmation when required. |
| Long menu with capped height | Modifier       | Approved API    | app menu max-height utility | Menu has many simple items; do not use for complex filtering or inputs.                      |
| Auto placement               | Placement      | Approved API    | `placement="auto"`          | Default; menu opens where it fits without clipping.                                          |
| Fluid menu/combo             | Modifier       | Gated           | `fluid`                     | Only after trigger/menu width matching is installed and tested.                              |
| Nested menus                 | Capability     | Not implemented | none                        | Do not nest menus. Use a page, modal, or Pattern-owned flow.                                 |
| Searchable menu              | Capability     | Not implemented | none                        | Use Search, Dropdown, Select, or a future Combo box API instead.                             |
| Complex menu content         | Capability     | Not implemented | none                        | Use Popover or Modal for checkboxes, radio groups, forms, or rich controls.                  |

## 6. States

| State            | Status                    | Implementation contract                                                                                                                          |
| ---------------- | ------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| Default          | Approved API              | Trigger uses approved Button/Icon/Button tokens and closed menu state.                                                                           |
| Hover            | Approved API              | Trigger and menu items use token-backed hover state.                                                                                             |
| Focus-visible    | Approved API              | Trigger and focused menu item show visible token-backed focus.                                                                                   |
| Open             | Approved API              | Trigger sets `aria-expanded="true"`; menu is visible and positioned.                                                                             |
| Closed           | Approved API              | Trigger sets `aria-expanded="false"`; menu is hidden and not reachable.                                                                          |
| Active/pressed   | Approved API              | Trigger and focused item use active state while activated.                                                                                       |
| Disabled trigger | Approved API              | Disabled trigger cannot open the menu and is not focusable if native disabled is used.                                                           |
| Loading trigger  | Approved API              | Trigger is disabled or inert, keeps readable label, and exposes pending state when relevant.                                                     |
| Focused item     | Approved API              | Keyboard focus moves through menu items using the installed menu behavior.                                                                       |
| Disabled item    | Approved API              | Disabled item cannot be activated and must not rely on color alone.                                                                              |
| Danger item      | Approved API              | Danger is reserved for destructive commands with explicit labels.                                                                                |
| Selected/current | Not applicable by default | Menu buttons expose commands, not persistent selected values. Use Dropdown, Select, or navigation APIs when selection/current state is required. |
| Read-only        | Not applicable            | Menu buttons are commands, not data fields.                                                                                                      |
| Validation       | Not applicable            | Validation belongs to fields and Forms Patterns.                                                                                                 |
| Empty            | Not allowed               | Do not render a menu trigger with zero items.                                                                                                    |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Menu buttons consume Foundation Color, Spacing, Typography, Themes, Motion, and Icons through app-owned `ui-*` classes. They also consume the Button Component API and Menu behavior.

### 7.1. Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes
- Motion
- Icons

### 7.2. Allowed class/API surfaces:

- `ui-menu-button`
- `ui-menu-button-trigger`
- `ui-overflow-menu`
- `ui-overflow-menu-trigger`
- `ui-combo-button`
- `ui-combo-button-primary`
- `ui-combo-button-trigger`
- `ui-menu`
- `ui-menu-item`
- `ui-menu-item-danger`
- `ui-menu-item-disabled`

### 7.3. Allowed data attributes:

- `data-ui-menu-button`
- `data-ui-menu-trigger`
- `data-ui-menu`
- `data-ui-menu-item`
- `data-ui-menu-placement`
- `data-ui-menu-open`

### 7.4. Token usage requirements:

- Trigger color, border, icon, and focus treatment must come from the Button, Color, Icons, and Themes APIs.
- Trigger hierarchy must follow Button style guidance exactly: primary menu triggers consume Button primary tokens, tertiary/outline triggers consume Button tertiary tokens, ghost/overflow triggers consume Button ghost tokens, and any approved secondary trigger must consume `--ui-action-secondary-*` rather than local neutral styling.
- Labeled menu buttons must use the Button trailing-icon structure with the approved caret icon. The caret must render to the right of the label and must not wrap to a new text line.
- Combo buttons must render as a joined split control: the primary action segment keeps the default rounded-start shape, the menu trigger segment keeps the rounded-end shape, and both segments remain separate focus targets.
- Overflow menu triggers must be icon-only ghost buttons using the approved vertical ellipsis icon unless a product-level Icons decision approves another overflow icon.
- Menu surface, border, shadow, item hover, focus, active, disabled, and danger treatment must use Color and Themes tokens.
- Menu spacing, item height, padding, and trigger/menu separation must use Spacing tokens.
- Menu item copy must use Typography tokens.
- Open/close motion must use Motion tokens and respect reduced-motion preferences.
- Overflow trigger icons must come from the approved Icons API and use `currentColor`.

## 8. Composition rules

- Menu buttons own trigger semantics, menu visibility, menu placement, menu item focus behavior, internal state styling, and reusable API shape.
- Parent Patterns own placement in headers, toolbars, rows, cards, forms, table patterns, and page-level action grouping.
- Use native `button` semantics for action triggers and action menu items.
- Use native links for menu items that navigate to a route or trusted resource.
- Do not mix action and navigation semantics when the resulting behavior would be unclear.
- Menu items must remain simple text commands or links. Use Popover, Modal, Dropdown, Select, or a Pattern-owned surface for complex controls.
- Open menus must not be clipped by parent overflow containers. Parent Patterns must provide a safe layering/portal strategy where needed.
- Menus should close after item activation unless the item opens a follow-up confirmation or Pattern-owned workflow.
- `Escape` closes the open menu and returns focus to the trigger.
- Outside click closes the menu and does not trigger nearby controls.
- The trigger/menu width relationship must remain readable. Do not compress the menu narrower than its trigger or shorter than readable item content.
- Menu button and Combo button menus use a minimum 160px width, may expand up to the app menu max width for longer item labels, and must match fluid trigger width only when the fluid capability is installed and tested.
- Ghost menu buttons and Overflow menu triggers do not stretch to match menu width; they keep Button ghost sizing so the caret or ellipsis remains visually attached to its trigger.
- Icon-only overflow triggers must maintain at least a 44px target even when the visible icon is smaller.

Components own internal semantics and styling. Parent Patterns own grouping, external spacing, workflow orchestration, and page-level layout.

## 9. Selection guidance

### 9.1. Use when:

- Users need access to multiple secondary actions but the interface should not display all actions at once.
- A page header has several actions with similar importance and limited space.
- A table row, card, compact panel, or toolbar needs additional actions without showing more than two or three visible controls.
- A single visible primary action needs related alternates, and the Combo button API is installed and tested.
- The actions are simple commands or links that can be expressed as short menu item labels.

### 9.2. Do not use when:

- The user is choosing a value from known options; use Dropdown or Select.
- The user can select multiple values; use Checkbox group or Multiselect if installed.
- The menu would contain search, filters, checkboxes, radio groups, forms, or rich interactive content; use Popover, Modal, or a Pattern-owned surface.
- There is only one action; use Button or Link.
- The action is primary and should stay visible; use Button.
- The UI is primary navigation; use UI shell, navigation, Tabs, or Breadcrumb as appropriate.
- The destructive command requires explanation or confirmation before execution; use Modal or a Pattern-owned confirmation flow.

## 10. Accessibility contract

- Every trigger must be a native `button` unless the control is explicitly a link to a destination.
- Every trigger must have an accessible name. Icon-only overflow triggers require `aria-label` or equivalent naming.
- Menu triggers must keep `aria-haspopup`, `aria-expanded`, and `aria-controls` synchronized with the menu state when the installed menu pattern uses these attributes.
- Opening a menu must move focus to the first actionable item or to the menu according to the installed menu behavior.
- Arrow keys must move focus through menu items when the custom menu pattern owns keyboard navigation.
- `Space` and `Enter` activate the focused trigger or item.
- `Escape` closes the menu and returns focus to the trigger.
- Disabled menu items must not be activated and must not rely on color alone.
- Danger items must include explicit text naming the destructive result.
- Menu item icons must be hidden from assistive technology when decorative.
- The visible focus indicator must meet contrast requirements in supported light and dark themes.
- Reduced-motion preferences must be respected for menu open/close motion.

## 11. Content contract

- Trigger labels must describe either the shared action or the fact that a list of actions is available.
- Use `Actions` only when grouped actions are distinct and no clearer shared label exists.
- Use a shared verb on the trigger when menu items are distinct objects for that verb. Example: `Create` with `Workspace`, `Tenant`, and `Invite`.
- Do not repeat the shared trigger verb in every menu item when doing so creates clutter.
- Combo button primary labels must represent the most common or highest-priority action.
- Overflow menu accessible labels must name the object or region. Example: `Workspace actions`, not just `Actions`.
- Menu item labels must be short, sentence case, and specific.
- Destructive menu items must name the destructive outcome directly. Example: `Archive workspace`, not `Remove`.
- Do not use icon-only menu items.
- Do not use support color or icons as the only way to distinguish item meaning.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not use Menu buttons as Dropdown, Select, Multiselect, or Combo box replacements for value selection.
- Do not use Menu buttons as primary navigation.
- Do not put forms, checkboxes, radio groups, sliders, search fields, or other rich controls inside a Menu button menu.
- Do not render a trigger with no menu items.
- Do not create multiple visible primary actions in the same local region when a Menu button or Combo button should group lower-emphasis commands.
- Do not hide the only safe escape path inside a menu.
- Do not rely on hover-only menu behavior.
- Do not use icon-only overflow controls without an accessible label and visible focus.
- Do not use custom icon libraries or feature-local SVGs for overflow/caret icons.
- Do not create fluid ghost menu buttons.
- Do not introduce `cds--*`, `bx--*`, or other Carbon production class names into Login App source.

## 13. Deferred or gated capabilities

| Capability                      | Status                     | Gate                                                                                                                                     |
| ------------------------------- | -------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| Custom combo variants           | Gated                      | Requires a product decision and UI Reference proof before combo buttons can use non-primary visual hierarchy.                            |
| Fluid menu/combo                | Gated                      | Requires trigger/menu width matching, responsive behavior, and tests. Ghost triggers remain non-fluid.                                   |
| Nested menus                    | Not implemented            | Requires separate accessibility and keyboard-navigation decision. Prefer a page, modal, or Pattern-owned flow.                           |
| Searchable menu                 | Not implemented            | Use Search, Dropdown, Select, or a future Combo box API.                                                                                 |
| Rich interactive menu content   | Not implemented            | Use Popover or Modal.                                                                                                                    |
| Async menu item loading         | Deferred                   | Requires loading, error, empty, focus, and announcement contract.                                                                        |
| Custom overflow icon            | Gated                      | Requires product-level decision and Icons Element update. Default overflow icon remains preferred.                                       |
| Persistent selected menu values | Not applicable             | Use Dropdown, Select, Tabs, Content switcher, or navigation APIs.                                                                        |

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

Because Menu buttons are broad and matrix-heavy, the Live examples section may use a full-width reference layout with variant matrices, trigger-style matrices, size scales, state tables, grouped examples, placement examples, and developer implementation examples. It must not be forced into the Accordion tab-only model.

| Required proof                    | Rendered behavior                                                                                                       | Variants/options shown                                                            |
| --------------------------------- | ----------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------- |
| Variant purpose matrix            | Compares Menu button, Overflow menu, and Combo button disposition with status and use case.                             | Menu button, Overflow menu, Combo button                                         |
| Trigger style matrix              | Shows allowed trigger treatments and disallowed combinations.                                                           | Menu primary, Menu outline/tertiary, Menu ghost, Combo primary-only, Overflow ghost-only |
| Size scale                        | Shows trigger and menu item height alignment across installed sizes.                                                    | Extra small, Small, Medium, Large                                                 |
| Text trigger menu button          | A labeled trigger opens simple actions with equal importance.                                                           | Primary, Outline/tertiary, Ghost, Open, Disabled, Loading                        |
| Icon-only overflow trigger        | Dense overflow trigger for table rows, cards, and compact toolbars.                                                     | Icon trigger, accessible label, tooltip if needed, hover, focus-visible, disabled |
| Row/card overflow actions         | Overflow menu is composed inside a table row or card without owning external spacing.                                   | View, Edit/Rename, Archive/Delete danger item                                     |
| Grouped secondary actions         | A visible primary Button remains separate while secondary actions are grouped in a Menu button or Overflow menu.        | Primary Button + Menu button, no multiple-primary group                           |
| Combo button disposition          | Shows actual split/combo behavior with separate primary action and menu trigger.                                        | Primary action, split trigger, menu alternates                                   |
| Placement and width behavior      | Menu opens without clipping and maintains readable width.                                                               | Auto placement, bottom-start, bottom-end, long labels, capped height              |
| Keyboard and focus behavior       | Demonstrates open, item focus, arrow navigation, activation, Escape close, and focus return.                            | `aria-expanded`, first item focus, Up/Down, Enter/Space, Escape                   |
| Content behavior                  | Demonstrates shared-label action grouping and distinct `Actions` fallback.                                              | Shared verb trigger, distinct item labels, danger item label                      |
| Related API boundary              | Demonstrates when to use Button, Dropdown, Select, Popover, Tooltip, or Modal instead.                                  | Navigation/value selection/complex content boundaries                             |
| Developer implementation examples | Shows canonical Blade calls and item data contracts.                                                                    | `x-ui.menu-button`, `x-ui.combo-button`, `x-ui.overflow-menu`, `initMenus`        |

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/menu-buttons` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred or gated capabilities render trigger conditions instead of fake controls.
- The page shows Menu button, Overflow menu, and Combo button disposition.
- The page shows a variant purpose matrix, trigger style matrix, size scale, state table, keyboard/focus behavior, and developer implementation examples.
- The page distinguishes Menu buttons from Button, Dropdown, Select, Popover, Tooltip, and Modal.
- The page includes explicit guidance that Menu buttons are for actions, not value selection.
- The page includes the icon-only overflow accessible-name requirement.
- The page proves overflow menus are ghost-only vertical ellipsis icon buttons.
- The page proves labeled menu triggers use the Button trailing-icon caret structure without wrapping the caret to a new line.
- The page includes Combo button proof with a primary action, split trigger, and menu alternates.
- The page proves Combo button segments share a joined split-control shape while preserving separate focus targets.
- Feature tests should assert the page does not contain `Component-specific API pending correction`.
- Feature tests should assert the page does not contain `Allowed variants, options, and modifiers - None`.
- Feature tests should assert the page does not contain `Live Examples Card`, `Reference Examples`, or `Legacy Contract Summary`.
- Feature tests should assert the page does not contain deprecated `tier-1` or `tier-2` canonical docs paths.
- Feature tests should assert the page does not contain direct Carbon production class names such as `cds--menu-button`, `cds--overflow-menu`, `bx--menu-button`, or `bx--overflow-menu`.

## 17. Related APIs

| API                            | Route                                             |
| ------------------------------ | ------------------------------------------------- |
| Button                         | /platform/ui-reference/components/button          |
| Menu                           | /platform/ui-reference/components/menu            |
| Dropdown                       | /platform/ui-reference/components/dropdown        |
| Select                         | /platform/ui-reference/components/select          |
| Tooltip                        | /platform/ui-reference/components/tooltip         |
| Popover                        | /platform/ui-reference/components/popover         |
| Modal                          | /platform/ui-reference/components/modal           |
| Data table                     | /platform/ui-reference/components/data-table      |
| Table patterns                 | /platform/ui-reference/patterns/tables            |
| Overlays and feedback patterns | /platform/ui-reference/patterns/overlays-feedback |
| Components overview            | /platform/ui-reference/components                 |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Menu buttons usage: https://carbondesignsystem.com/components/menu-buttons/usage/
- Carbon Menu buttons style: https://carbondesignsystem.com/components/menu-buttons/style/
- Carbon Menu buttons accessibility: https://carbondesignsystem.com/components/menu-buttons/accessibility/
- Carbon Menu buttons inform the Menu button, Combo button, and Overflow menu distinction. Login App keeps its own `x-ui.*`, `ui-*`, and `data-ui-*` API model.

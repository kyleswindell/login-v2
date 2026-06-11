---
title: Button
slug: button
api_layer: Component API
status: implemented-pending-review
system_maturity: partial
category: actions
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/button
canonical_doc: docs/02-standards/ui/components/button.md
source_owner: /platform/ui-reference/components/button
blade_api:
  - x-ui.button
  - x-ui.icon-button
javascript_api: []
source_files:
  - resources/views/components/ui/button.blade.php
  - resources/views/components/ui/icon-button.blade.php
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
  - link
  - menu-buttons
  - tooltip
  - inline-loading
  - modal
  - notification
related_patterns:
  - forms
  - overlays-feedback
  - tables
  - layout
planned_patterns:
  - tables
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/button/usage/
  - https://carbondesignsystem.com/components/button/style/
  - https://carbondesignsystem.com/components/button/accessibility/
---

# Button Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
  - [4.4. Semantic variant contract](#44-semantic-variant-contract)
  - [4.5. Size contract](#45-size-contract)
  - [4.6. Icon button API](#46-icon-button-api)
  - [4.7. Button group contract](#47-button-group-contract)
  - [4.8. Structure measurements](#48-structure-measurements)
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
  - [9.3. Variant selection:](#93-variant-selection)
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

Buttons choose, confirm, or reveal a user command with explicit action hierarchy.

Canonical API owner: `/platform/ui-reference/components/button`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Button is the installed Login App 2.0 command API. It owns button semantics, action hierarchy, visual emphasis, semantic danger treatment, disabled/loading behavior, icon-button behavior, focus styling, token-backed states, and button-specific content rules. It does not own page-level layout, form workflow orchestration, modal footer placement, table toolbar composition, navigation, menu disclosure, or task-progress behavior.

### 1.1. Canonical API responsibilities:

- Render command controls through `x-ui.button` and `x-ui.icon-button`.
- Preserve native button semantics for state-changing actions.
- Express action hierarchy through approved semantic variants.
- Express density and surface fit through approved size options.
- Preserve visible focus, hover, active, disabled, and loading states.
- Support labeled buttons with optional trailing icons.
- Support icon-only buttons only when an accessible label and tooltip behavior are provided.
- Prevent destructive icon-only buttons.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and icons.
- Prove variant, size, state, grouping, icon, content, and implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Navigation to unrelated content. Use Link unless the installed pattern explicitly calls for a button-styled call to action.
- Menus or split actions. Use Menu buttons.
- Form layout and submit/cancel placement. Use the Forms Pattern.
- Modal footer ordering and focus orchestration. Use Modal and Overlay/feedback Patterns.
- Table toolbar layout and row action grouping. Use Data table or Table toolbar Patterns.
- Page header layout and action placement. Use the Page header Pattern.
- External spacing. Parent Patterns own button placement, grouping, and spacing.

## 2. Status and ownership

| Field                        | Value                                                                                                                            |
| ---------------------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                                     |
| System maturity              | Partial                                                                                                                          |
| API layer                    | Component API                                                                                                                    |
| Component slug               | button                                                                                                                           |
| Category                     | Actions                                                                                                                          |
| Priority                     | Tier A - Baseline app development                                                                                                |
| UI Reference route           | `/platform/ui-reference/components/button`                                                                                       |
| Canonical doc                | `docs/02-standards/ui/components/button.md`                                                                                      |
| Source owner                 | `/platform/ui-reference/components/button`                                                                                       |
| Blade API                    | `x-ui.button`; `x-ui.icon-button`                                                                                                |
| JavaScript API               | None required for baseline button behavior                                                                                       |
| Source files                 | `resources/views/components/ui/button.blade.php`; `resources/views/components/ui/icon-button.blade.php`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid where composed in layouts                                             |
| Carbon benchmark             | Carbon Button usage, style, and accessibility guidance                                                                           |

`Approved API` means the installed component exists and the UI Reference page must prove Button as a broad matrix-heavy component rather than a simple tab-only example page.

## 3. Installed standard

Button requires an expanded matrix-style reference layout because variants, sizes, groups, icons, content behavior, and token/state roles are too broad for the simple tab-plus-variants scaffold.

### 3.1. The installed standard is:

- Render standard command controls through `<x-ui.button>`.
- Render icon-only command controls through `<x-ui.icon-button>`.
- Use the `semantic` prop to select action hierarchy and danger treatment.
- Use the `size` prop to select the approved size scale.
- Use native `<button>` behavior for state-changing commands.
- Use `type="submit"` only when the button submits the current form.
- Use `type="button"` for non-submit UI commands.
- Use `disabled` for unavailable commands.
- Use `loading` for commands already in progress.
- Keep loading buttons disabled while work is pending.
- Use trailing icons only for labeled buttons.
- Use icon-only buttons only in dense toolbars, table rows, or universally recognizable action clusters, and only with an accessible label.
- Do not use danger icon-only buttons for destructive actions.
- Use one primary button per region except temporary focused flows such as an open modal or side panel that owns its own primary action.
- Parent Patterns own placement, grouping, and external spacing.
- Do not use raw utility clusters, raw color values, or feature-local CSS to create button variants.

Carbon alignment note: Carbon defines Button as an action trigger, allows one primary button per screen with limited temporary-flow exceptions, documents Primary, Secondary, Tertiary, Ghost, and Danger variants, defines seven sizes, requires icon-only labels/tooltips, and prohibits danger icon-only buttons for destructive actions. Login App maps those principles to its own `x-ui.button` and `x-ui.icon-button` APIs rather than adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical calls

```blade
<x-ui.button semantic="primary">Save changes</x-ui.button>
```

```blade
<x-ui.button semantic="secondary" type="button">Cancel</x-ui.button>
```

```blade
<x-ui.button semantic="danger" type="submit" loading>
    Delete tenant
</x-ui.button>
```

```blade
<x-ui.button semantic="ghost" icon="heroicon-o-arrow-top-right-on-square">
    Open report
</x-ui.button>
```

```blade
<x-ui.icon-button
    icon="heroicon-o-cog-6-tooth"
    label="Open settings"
    semantic="ghost"
/>
```

Use the Blade APIs instead of hand-building button markup in feature views.

### 4.2. API surfaces

| API surface                | Installed value                                                                                                                  |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| Labeled button Blade API   | `x-ui.button`                                                                                                                    |
| Icon-only button Blade API | `x-ui.icon-button`                                                                                                               |
| JavaScript                 | No dedicated JavaScript controller required for baseline button behavior                                                         |
| Root semantic element      | Native `button` unless an approved component/pattern explicitly renders a link CTA                                               |
| Data attributes            | Use only data attributes documented by the Component API. Feature views must not invent button behavior attributes.              |
| CSS namespace              | App-owned `ui-*` button classes documented by the component implementation                                                       |
| Source files               | `resources/views/components/ui/button.blade.php`; `resources/views/components/ui/icon-button.blade.php`; `resources/css/app.css` |

### 4.3. Props and options

| Prop/option    | Type            | Default                    | Allowed values                                                                           | Required                                                                 | Notes                                                                                                          |
| -------------- | --------------- | -------------------------- | ---------------------------------------------------------------------------------------- | ------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------- |
| `semantic`     | `string`        | `primary`                  | `primary`, `secondary`, `tertiary`, `ghost`, `danger`, `danger-tertiary`, `danger-ghost` | No                                                                       | Use to select action hierarchy and destructive emphasis. `danger` means danger primary.                        |
| `size`         | `string`        | `lg` or installed default  | `xs`, `sm`, `md`, `lg`, `lg-expressive`, `xl`, `2xl`                                     | No                                                                       | Must map to the approved seven-size scale. Do not mix sizes inside one button group.                           |
| `type`         | `string`        | `button`                   | `button`, `submit`, `reset`                                                              | No                                                                       | Use `submit` only for the current form’s submit action. Avoid `reset` unless a Pattern explicitly approves it. |
| `disabled`     | `bool`          | `false`                    | `true`, `false`                                                                          | No                                                                       | Disabled buttons are not focusable and cannot trigger commands.                                                |
| `loading`      | `bool`          | `false`                    | `true`, `false`                                                                          | No                                                                       | Keeps the label visible, disables the command, and exposes pending state.                                      |
| `icon`         | `string / null` | `null`                     | Approved Heroicon alias/component                                                        | No                                                                       | Labeled buttons may use one trailing icon only.                                                                |
| `iconPosition` | `string`        | `trailing`                 | `trailing`                                                                               | No                                                                       | Leading icons are not approved for labeled buttons.                                                            |
| `ariaLabel`    | `label`         | `string / null`            | `null`                                                                                   | Short action label / Required for `x-ui.icon-button`                     | Must describe the action, not the icon shape.                                                                  |
| `tooltip`      | `string / null` | mirrors label if installed | Short visible tooltip copy                                                               | Required for icon-only usage when the component owns tooltip integration | Tooltip text should match or clarify the accessible label.                                                     |
| `class`        | `string / null` | `null`                     | layout class passthrough if supported                                                    | No                                                                       | Parent Patterns may pass layout classes. Do not use for local color, typography, state, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.4. Semantic variant contract

| Semantic value    | Status      | Purpose                                                 | Use when                                                                                   | Do not use when                                                                    |
| ----------------- | ----------- | ------------------------------------------------------- | ------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------- |
| `primary`         | Implemented | Highest-emphasis principal action                       | One main action should guide the current region or workflow                                | A second primary already exists in the same region, except temporary focused flows |
| `secondary`       | Implemented | Negative or backing action paired with a primary action | Pairing with a primary action, commonly Cancel or Back                                     | In isolation or for positive actions                                               |
| `tertiary`        | Implemented | Medium/low-emphasis action                              | Independent secondary tasks, page header actions, empty states, or grouped support actions | Fluid/full-width arrangements unless explicitly approved                           |
| `ghost`           | Implemented | Lowest-emphasis supplementary action                    | Inline support actions, card actions, table toolbar actions, cancel actions in some flows  | A primary or required next action                                                  |
| `danger`          | Implemented | High-emphasis destructive action                        | Destructive action is the required or primary step in the flow                             | Destructive action is one of several secondary options                             |
| `danger-tertiary` | Implemented | Lower-emphasis destructive action                       | Destructive action is available but not the primary next step                              | Mixed with incompatible tertiary groups                                            |
| `danger-ghost`    | Implemented | Lowest-emphasis destructive action                      | Rare secondary destructive commands in dense contexts                                      | Paired with primary or tertiary in combinations that obscure hierarchy             |

### 4.5. Size contract

| Size value      | Status                       | Carbon label     | Login App use                                                                 |
| --------------- | ---------------------------- | ---------------- | ----------------------------------------------------------------------------- |
| `xs`            | Implemented / required proof | Extra small      | 24px / 1.5rem height for confined dense layouts where vertical space is limited. |
| `sm`            | Implemented / required proof | Small            | 32px / 2rem height for compact controls or dense table/tool rows.             |
| `md`            | Implemented / required proof | Medium           | 40px / 2.5rem height for standard medium fields and dense forms.              |
| `lg`            | Implemented / required proof | Large productive | 48px / 3rem height; default productive app button size for common software UI. |
| `lg-expressive` | Implemented / required proof | Large expressive | 48px / 3rem height with expressive icon sizing for selected non-dense/editorial contexts only. |
| `xl`            | Implemented / required proof | Extra large      | 64px / 4rem height for full-bleed or larger component surfaces when approved. |
| `2xl`           | Implemented / required proof | 2XL              | 80px / 5rem height for full-screen or large overlay contexts only when Pattern-owned. |

Do not mix different button sizes in one button group. If a group needs different visual weight, use semantic variants instead of size changes.

### 4.6. Icon button API

`x-ui.icon-button` is a separate API because icon-only controls have stricter accessibility and content requirements.

```blade
<x-ui.icon-button
    icon="heroicon-o-pencil-square"
    label="Edit workspace"
    semantic="ghost"
    size="md"
/>
```

| Requirement      | Rule                                                                                          |
| ---------------- | --------------------------------------------------------------------------------------------- |
| Visible label    | Not displayed for icon-only button, but the accessible label is required.                     |
| Accessible name  | Required through `label` or `ariaLabel`.                                                      |
| Tooltip          | Always required for icon-only buttons; copy must explain the action if clicked.               |
| Target size      | Minimum 44px interactive target.                                                              |
| Icon library     | Heroicons only unless the Icons Element standard is updated.                                  |
| Danger treatment | Danger icon-only buttons are prohibited for destructive actions. Use a labeled danger button. |
| Menu disclosure  | Use Menu buttons, not Button, when the icon opens a menu.                                     |

### 4.7. Button group contract

There is no standalone public Button group Blade API unless `x-ui.button-group` is explicitly installed and documented. Button grouping is usually owned by the parent Pattern, but the Button standard defines allowed combinations, order, width, spacing, layout direction, and icon consistency. Use app-owned `ui-button-group`, `ui-button-group-equal`, `ui-button-group-fluid`, and `ui-button-group-vertical` classes when a parent Pattern needs the installed Button group treatment.

Button groups versus Menu buttons:

- Use Button groups only when users need to consider two or three visible actions together.
- Move more than three actions into Menu buttons, a Toolbar, or another Pattern-owned action surface.
- Do not keep adding visible buttons to avoid implementing a Menu button or Toolbar.
- Do not render Menu button live examples on the Button page; Menu button examples belong on the Menu buttons component page.

Button width and order:

- Related non-ghost buttons in a group must be equal width. The shared width is determined by the longest button label.
- Ghost buttons are excluded from the equal-width requirement.
- Primary buttons sit on the outside edge of the set; secondary/backing actions sit inside the set.
- Button group spacing is fixed at 16px / `$spacing-05`; inline margins stay `0`.
- Button groups use a 1px boundary only when a parent Pattern intentionally creates a fluid grouped control surface.

Button group layout and icon consistency:

- Button groups may be horizontal or vertical.
- Static groups size to their content while preserving equal width among related non-ghost buttons.
- Fluid groups fill the available parent width and keep each non-ghost button on the same width track.
- Icons are optional in Button groups, but usage must be consistent: either every button in the group has an icon or no button in the group has an icon.
- Do not add icons to only some buttons in a group.
- The Button UI Reference page should render compact proof examples for horizontal static, horizontal fluid, vertical static, vertical fluid, all-icons, and no-icons groups; it should not render every allowed combination as a live example.

Recommended groups with a primary action:

| Button count | Allowed combinations                                                                                                                           |
| ------------ | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| 2            | Primary + Secondary; Primary + Tertiary; Primary + Ghost; Primary + Danger tertiary; Danger primary + Secondary; Danger primary + Ghost        |
| 3            | Primary + Secondary + Tertiary; Primary + Secondary + Ghost; Primary + 2 Secondary; Primary + 2 Tertiary; Primary + Tertiary + Danger tertiary |

Recommended groups without a primary action:

| Button count | Allowed combinations                       |
| ------------ | ------------------------------------------ |
| 2            | 2 Tertiary; Tertiary + Ghost; 2 Ghost      |
| 3            | 3 Tertiary; 2 Tertiary + 1 Danger tertiary |

Avoid these groups:

- Two high-emphasis buttons in one group.
- Secondary button without a primary button.
- Secondary button paired only with non-primary actions.
- Tertiary and danger tertiary when hierarchy becomes unclear.
- Primary and danger ghost when destructive hierarchy becomes unclear.
- Tertiary and danger ghost when destructive hierarchy becomes unclear.
- Mixed button sizes in one group.
- Randomly adding icons to only some buttons in a group.

### 4.8. Structure measurements

Primary, secondary, tertiary, danger primary, and danger tertiary buttons share the same structure measurements.

| Button structure | Property | px / rem | Carbon spacing token | Login App implementation |
| ---------------- | -------- | -------- | -------------------- | ------------------------ |
| Button without icon | padding-left | 16px / 1rem | `$spacing-05` | `--ui-button-padding-start: 1rem` |
| Button without icon | padding-right | 64px / 4rem | `$spacing-10` | `--ui-button-padding-end: 4rem` |
| Button with trailing icon | padding-left/right | 16px / 1rem | `$spacing-05` | `ui-action-with-icon` sets both sides to 1rem |
| Button with trailing icon | label-icon spacing | Dynamic, minimum 32px / 2rem | `$spacing-07` | Non-ghost `ui-action-with-icon` pins the icon to the right padding and lets label-icon space expand |
| Icon-only button | padding-left/right | 16px / 1rem | `$spacing-05` | `x-ui.icon-button` size classes use 1rem inline padding |
| Icon | svg | 16px x 16px | n/a | `ui-button-icon`, `ui-icon-button-icon` |
| Expressive icon | svg | 20px x 20px | n/a | `lg-expressive` icon sizing only |
| Focus | inset shadow | 1px | n/a | Visible focus uses token-backed focus styling and must remain visible in both themes |

Ghost and danger ghost buttons follow the ghost structure:

| Ghost structure | Property | px / rem | Carbon spacing token | Login App implementation |
| --------------- | -------- | -------- | -------------------- | ------------------------ |
| Ghost without icon | padding-left/right | 16px / 1rem | `$spacing-05` | `ui-action-ghost` uses equal 1rem inline padding |
| Ghost with trailing icon | label-icon spacing | 8px / 0.5rem | `$spacing-03` | `ui-action-ghost` sets `--ui-button-gap: 0.5rem` |
| Ghost icon-only | padding-left/right | 16px / 1rem | `$spacing-05` | `x-ui.icon-button semantic="ghost"` keeps icon-button inline padding |

## 5. Allowed variants, options, and modifiers

| Name                 | Type             | Status                       | API                          | Notes                                                                            |
| -------------------- | ---------------- | ---------------------------- | ---------------------------- | -------------------------------------------------------------------------------- |
| Primary              | Semantic variant | Implemented                  | `semantic="primary"`         | Principal action.                                                                |
| Secondary            | Semantic variant | Implemented                  | `semantic="secondary"`       | Pair with primary as negative/backing action.                                    |
| Tertiary             | Semantic variant | Implemented                  | `semantic="tertiary"`        | Lower-emphasis action that may stand alone.                                      |
| Ghost                | Semantic variant | Implemented                  | `semantic="ghost"`           | Lowest-emphasis action.                                                          |
| Danger primary       | Semantic variant | Implemented                  | `semantic="danger"`          | Primary destructive action.                                                      |
| Danger tertiary      | Semantic variant | Implemented                  | `semantic="danger-tertiary"` | Lower-emphasis destructive action.                                               |
| Danger ghost         | Semantic variant | Implemented                  | `semantic="danger-ghost"`    | Lowest-emphasis destructive action.                                              |
| Extra small          | Size             | Implemented / required proof | `size="xs"`                  | Dense confined layouts.                                                          |
| Small                | Size             | Implemented / required proof | `size="sm"`                  | Compact control pairing.                                                         |
| Medium               | Size             | Implemented / required proof | `size="md"`                  | Medium control pairing.                                                          |
| Large productive     | Size             | Implemented / required proof | `size="lg"`                  | Default product UI size.                                                         |
| Large expressive     | Size             | Implemented / required proof | `size="lg-expressive"`       | Gated expressive moments.                                                        |
| Extra large          | Size             | Implemented / required proof | `size="xl"`                  | Larger component surfaces.                                                       |
| 2XL                  | Size             | Implemented / required proof | `size="2xl"`                 | Full-screen/large overlay contexts only.                                         |
| Loading              | Modifier/state   | Implemented                  | `loading`                    | Disable while pending and keep label visible.                                    |
| Disabled             | State            | Implemented                  | `disabled`                   | Native disabled behavior.                                                        |
| Trailing icon        | Modifier         | Implemented                  | `icon="..."`                 | Labeled buttons only; icon appears after label.                                  |
| Icon-only            | Separate API     | Implemented                  | `x-ui.icon-button`           | Requires accessible label and tooltip.                                           |
| Leading icon         | Modifier         | Not allowed                  | none                         | Do not place icons before labels in labeled buttons.                             |
| Danger icon-only     | Modifier         | Not allowed                  | none                         | Destructive actions require visible text.                                        |
| Fluid/hanging button | Modifier         | Deferred                     | none                         | Requires Pattern-specific approval and UI Reference proof before production use. |

## 6. States

| State          | Status         | Implementation requirement                                                               |
| -------------- | -------------- | ---------------------------------------------------------------------------------------- |
| Default        | Implemented    | Renders approved semantic, size, label, and optional trailing icon.                      |
| Hover          | Implemented    | Token-backed hover treatment; must not be used as static styling.                        |
| Focus-visible  | Implemented    | Token-backed focus ring visible in all supported themes.                                 |
| Active/pressed | Implemented    | Token-backed pressed state for mouse/touch activation.                                   |
| Disabled       | Implemented    | Uses native `disabled`; does not trigger command; not focusable.                         |
| Loading        | Implemented    | Disables command, keeps label visible, exposes pending status.                           |
| Danger         | Implemented    | Semantic destructive styling with explicit destructive copy.                             |
| Icon-only      | Implemented    | Requires accessible label, tooltip behavior, and minimum 44px target.                    |
| Read-only      | Not applicable | Buttons are commands, not read-only data.                                                |
| Validation     | Not applicable | Validation belongs to fields/forms; buttons may trigger validation but do not own it.    |
| Empty          | Not applicable | Do not render unlabeled buttons except approved icon-only buttons with accessible names. |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Button consumes Foundation Color, Spacing, Typography, Themes, Motion, Icons, and 2x Grid where composed in layouts.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.
- 2x Grid where button groups are placed in page, form, toolbar, modal, or shell layouts.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                            |
| ----------- | -------------------------------------------------------------------------------------------------------- |
| Color       | Semantic action backgrounds, text, icon, border, danger, disabled, hover, active, and focus roles.       |
| Spacing     | Internal padding, icon gap, group gap when the parent Pattern delegates local grouping to the component. |
| Typography  | Button label size, weight, line-height, wrapping behavior, and icon-label alignment.                     |
| Themes      | Light/dark/inverse token resolution for every semantic variant.                                          |
| Motion      | Short productive transition for hover, focus, active, and loading entry where applicable.                |
| Icons       | Heroicons for trailing icons and icon-only controls.                                                     |
| 2x Grid     | Page, form, toolbar, modal, or card placement through Pattern-owned layout.                              |

Carbon color role mapping:

Button color alignment must follow the Color Element’s Carbon coverage and value mapping contract. Carbon’s Button style rows are the coverage benchmark; Login App owns the production API and token names.

| Carbon token / role | Carbon responsibility | Login App token / API | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | -------------- | ---------- |
| `$button-primary`, `$button-primary-hover`, `$button-primary-active` | Primary button container and states | `<x-ui.button semantic="primary">`, `--ui-action-primary-*` | Same role / app value unless theme map records same value | Every primary action uses the same Button-owned primary action role. |
| `$button-secondary`, `$button-secondary-hover`, `$button-secondary-active` | Secondary button container and states | `<x-ui.button semantic="secondary">`, `<x-ui.icon-button semantic="secondary">`, `--ui-action-secondary-*` | Same role / same Carbon gray value family | Light theme maps to Gray 80 `#393939`, Gray 80 hover `#4c4c4c`, and Gray 60 active `#6f6f6f`; dark theme maps to the corresponding lighter gray secondary family. Secondary action treatment is consistent in forms, modals, page headers, table toolbars, and Menu button triggers when they consume Button hierarchy. |
| `$button-tertiary`, `$button-tertiary-hover`, `$button-tertiary-active` | Tertiary button text/border/container states | `<x-ui.button semantic="tertiary">`, `<x-ui.icon-button semantic="tertiary">`, `--ui-action-tertiary-*` | Same role / app value unless theme map records same value | Tertiary is a primary-color outline role, not neutral outline. Light/Gray 10 themes use primary border/text by default, then primary filled hover/active with inverse text. Gray 90/100 themes use white border/text by default, then white filled hover/active with primary-colored text. |
| `$background-hover`, `$link-primary`, `$link-primary-hover` for ghost buttons | Ghost button low-emphasis affordance | `<x-ui.button semantic="ghost">`, `<x-ui.icon-button semantic="ghost">`, `--ui-action-ghost-*` | Same role / app value unless theme map records same value | Ghost buttons and icon buttons share the same Button-owned ghost role. |
| `$button-danger-primary`, `$button-danger-hover`, `$button-danger-active`, `$button-danger-secondary` | Destructive button hierarchy and states | `semantic="danger"`, `semantic="danger-tertiary"`, `semantic="danger-ghost"`, `--ui-action-danger-*` | Same role / app value unless theme map records same value | Danger roles are destructive only and must not be reused for warning or negative emphasis. |
| `$button-disabled`, `$text-on-color-disabled`, `$icon-on-color-disabled` | Disabled button surface, text, and icon roles | Disabled Button state tokens/classes | Same role / app value unless theme map records same value | Disabled treatment is state-specific and must not be used for secondary/low-emphasis styling. |
| `$focus`, `$focus-inset` | Button focus ring and inset contrast | Button focus-visible token/classes using `--ui-focus*` | Same role / app value unless theme map records same value | Focus treatment must stay visible across every semantic variant. |

### 7.3. CSS namespace

Allowed component classes should use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-button
.ui-button-primary
.ui-button-secondary
.ui-action-secondary
.ui-button-tertiary
.ui-button-ghost
.ui-button-danger
.ui-button-danger-tertiary
.ui-button-danger-ghost
.ui-button-xs
.ui-button-sm
.ui-button-md
.ui-button-lg
.ui-button-lg-expressive
.ui-button-xl
.ui-button-2xl
.ui-button-loading
.ui-button-icon
.ui-icon-button
.ui-button-group
.ui-button-group-equal
.ui-button-group-fluid
.ui-button-group-vertical
```

Feature views must not create `btn-*`, Bootstrap `.btn`, local `button-*`, raw utility clusters, arbitrary hex colors, arbitrary spacing, custom focus rings, or component-local danger treatments for the same UI role.

## 8. Composition rules

- Click or tap activates the command once unless loading or disabled.
- Enter and Space activate native button controls while focused.
- Loading buttons keep the label visible, disable repeated activation, and expose pending state.
- Icon-only buttons keep at least a 44px target and require an accessible label.
- Labeled buttons may include one trailing icon only.
- Icons must directly reinforce the action label.
- Do not mix icon usage arbitrarily within one group. Either use icons consistently for clear universal actions or omit icons.
- One primary action should exist per region. Temporary focused flows such as an open modal or side panel may own their own primary action.
- Secondary buttons should be paired with a primary action and should not be used in isolation.
- Tertiary and ghost buttons may be used for lower-emphasis, supporting, or supplementary actions.
- Danger buttons are reserved for destructive actions and must be paired with explicit destructive copy.
- Parent Patterns own button order, alignment, grouping, external spacing, and workflow orchestration.
- Components own internal semantics, styling, icon alignment, disabled/loading behavior, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- A user needs to submit, confirm, cancel, reveal, or trigger a command.
- A command changes state, performs work, opens a controlled UI surface, or confirms a workflow step.
- A region needs a clear action hierarchy.
- A destructive command needs semantic danger treatment.
- A dense toolbar or row needs an icon-only action with an accessible name.

### 9.2. Do not use when:

- The control navigates to unrelated content; use Link.
- The control opens a menu; use Menu buttons.
- The control represents task progress; use Progress indicator.
- The control switches peer views; use Tabs or Content switcher when implemented.
- The action is purely decorative or informational.
- A support color is being used as visual decoration.
- A feature needs local margins or custom placement; parent Patterns own external spacing.

### 9.3. Variant selection:

| Need                                            | Use                                 |
| ----------------------------------------------- | ----------------------------------- |
| Main positive action in a region                | `semantic="primary"`                |
| Cancel/back action paired with a primary action | `semantic="secondary"`              |
| Independent lower-emphasis action               | `semantic="tertiary"`               |
| Supplementary or flush container action         | `semantic="ghost"`                  |
| Required destructive action                     | `semantic="danger"`                 |
| Secondary destructive action                    | `semantic="danger-tertiary"`        |
| Lowest-emphasis destructive action              | `semantic="danger-ghost"`           |
| Dense toolbar action with recognizable icon     | `x-ui.icon-button semantic="ghost"` |

## 10. Accessibility contract

- Buttons are native `<button>` elements unless an approved component/pattern explicitly renders a link CTA.
- Default `type` is `button`; submit buttons must intentionally set `type="submit"`.
- Disabled buttons use the native `disabled` attribute and are not focusable.
- Loading buttons remain disabled while pending and expose pending state through installed markup such as `aria-busy="true"` or an equivalent component-owned status contract.
- Icon-only controls require an accessible label that describes the action.
- Icon-only controls require tooltip behavior or equivalent visible label disclosure on hover and focus.
- Icon-only controls require a minimum 44px interactive target.
- Danger actions must not rely on color alone; destructive labels must name the outcome.
- Danger icon-only buttons are prohibited for destructive actions because the destructive consequence must be visible in text.
- Focus-visible treatment must be visible in all supported themes.
- Meaning must not rely on color alone.
- Button groups must preserve logical reading and tab order.
- Buttons that open menus are not plain Buttons; use Menu buttons so `aria-haspopup`, `aria-expanded`, keyboard navigation, and focus return are owned by the correct API.

## 11. Content contract

- Use sentence case.
- Prefer verb + noun labels: `Save changes`, `Create workspace`, `Delete tenant`.
- Common short actions are allowed when globally clear: `Done`, `Close`, `Cancel`, `Add`, `Delete`.
- Avoid vague labels such as `Go`, `Submit`, `More`, `OK`, or noun-only labels when a specific verb is possible.
- Danger labels name the destructive outcome directly.
- Button labels should be concise but must wrap instead of truncate when space is constrained.
- Labeled button text aligns to the start edge of the button.
- In RTL contexts, the button mirrors horizontally: the label aligns to the right and a trailing icon moves to the left.
- Icon-only labels describe the action, not the icon: use `Edit workspace`, not `Pencil`.
- If a button launches a new tab or external destination, the label and context must make that destination clear; use Link when the primary role is navigation.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not use Bootstrap `.btn` classes or feature-local `button-*` classes for app-owned buttons.
- Do not use buttons for navigation to unrelated content; use links instead.
- Do not use support colors for decoration or non-semantic emphasis.
- Do not create local button margins; parent layouts own external spacing.
- Do not render multiple primary buttons in the same region except temporary focused flows with explicit Pattern ownership.
- Do not use secondary buttons in isolation.
- Do not use danger for non-destructive actions.
- Do not use danger icon-only buttons for destructive actions.
- Do not place icons before labels in labeled buttons.
- Do not truncate button labels.
- Do not mix button sizes inside one button group.
- Do not introduce another icon set through Button.
- Do not use a Button when Menu buttons, Link, Tabs, Content switcher, Toggle, or Progress indicator owns the role.

## 13. Deferred or gated capabilities

| Capability                    | Status                            | Gate                                                                                         |
| ----------------------------- | --------------------------------- | -------------------------------------------------------------------------------------------- |
| Fluid/hanging button behavior | Deferred                          | Requires Pattern owner, source implementation, accessibility review, and UI Reference proof. |
| `x-ui.button-group` helper    | Deferred unless already installed | Requires documented public API, group alignment rules, responsive stacking rules, and tests. |
| Split/combo button behavior   | Not owned by Button               | Use Menu buttons. Do not add split behavior to Button.                                       |
| Button-as-link CTA            | Gated                             | Requires explicit Pattern approval showing why Link alone is not correct.                    |
| Custom semantic colors        | Not allowed                       | Requires Color Element standard update and UI Reference proof.                               |
| Additional sizes              | Not allowed                       | Requires Typography, Spacing, and UI Reference updates.                                      |

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

The Button page is a broad component reference page. It must not be forced into the Accordion-style live-example tab model. The Live examples card may use a full-width reference layout with matrices, comparison grids, state tables, size scales, grouped examples, and implementation examples.

### 15.1. Required Live examples internal sections:

| Required proof           | Rendered behavior                                                                                                   | Variants/options shown                                                                        |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------- |
| Variant purpose matrix   | Each semantic variant is rendered with a short purpose/use note.                                                    | Primary, Secondary, Tertiary, Ghost, Danger primary, Danger tertiary, Danger ghost            |
| Size scale               | All approved sizes render with consistent labels and visual scale.                                                  | Extra small, Small, Medium, Large productive, Large expressive, Extra large, 2XL              |
| State matrix             | State examples render using production component code and token-backed classes.                                     | Default, Hover, Focus-visible, Active/pressed, Disabled, Loading, Danger states               |
| Form submission action   | Primary submit, secondary save/back/cancel, and loading/disabled submit examples stay grouped at the end of a form. | Primary, Secondary, Loading submit, Disabled submit                                           |
| Page header actions      | A page header shows one clear primary or approved lower-emphasis page-level action.                                 | Tertiary, Ghost, Focus-visible, Pressed; Primary only when no competing region primary exists |
| Modal footer actions     | Confirmation flows keep confirmation and cancellation visible together with Pattern-owned alignment.                | Primary confirmation, Secondary/ghost cancel, Danger confirmation                             |
| Table row actions        | Dense rows use small lower-emphasis or icon-only actions with accessible labels.                                    | Small buttons, Icon-only default, Icon-only hover, Icon-only focus, Icon-only disabled        |
| Destructive confirmation | Destructive commands use visible danger labels and an escape path.                                                  | Danger primary, Danger tertiary, Danger ghost; no danger icon-only                            |
| Button groups            | Horizontal and vertical groups render in static and fluid layouts with equal-width non-ghost buttons.               | Horizontal static, horizontal fluid, vertical static, vertical fluid                          |
| Icon usage               | Labeled trailing icon, all-icons/no-icons Button group consistency, and icon-only tooltip requirements render.      | Trailing icon, all-icons group, no-icons group, icon-only tooltip, no danger icon-only rule   |
| Content behavior         | Labels prove verb+noun, sentence case, start alignment, RTL mirroring, and wrap-not-truncate behavior.              | Long label wraps, RTL mirror, no truncation                                                   |
| Developer implementation | Canonical calls and props render as real code examples.                                                             | `x-ui.button`, `x-ui.icon-button`, supported props, token-backed examples                     |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered variants, rendered sizes, rendered states, grouped examples, content rules, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/button` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- Live examples are allowed to use matrices, scales, comparison grids, grouped examples, full-width sections, and state tables.
- The page does not require every Button example to use tabbed scenarios.
- The variant purpose matrix renders Primary, Secondary, Tertiary, Ghost, Danger primary, Danger tertiary, and Danger ghost.
- The size scale renders extra small, small, medium, large productive, large expressive, extra large, and 2XL.
- The state matrix renders default, hover, focus-visible, active/pressed, disabled, loading, and danger states.
- Button group examples include horizontal static, horizontal fluid, vertical static, and vertical fluid layouts.
- Button group icon examples include all-icons and no-icons groups; mixed icon usage is not shown as valid.
- Avoided group combinations are documented and not presented as approved.
- Icon examples include a trailing-icon labeled button and icon-only controls.
- Icon-only controls include accessible label and tooltip text regardless of icon recognizability.
- Danger icon-only prohibition is visible.
- Content examples include verb+noun labels, sentence case, start alignment, RTL mirroring, and wrapping long labels instead of truncation.
- Developer examples use `x-ui.button` and `x-ui.icon-button`, not placeholder comments or ad hoc markup.
- Tests assert stale labels such as `Live Examples Card` remain absent if that label is not part of the approved UI copy.
- Tests assert no raw Bootstrap `.btn`, hard-coded hex button color, arbitrary local spacing, or feature-local `button-*` CSS examples are presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/button');

$response->assertOk();
$response->assertSee('Button');
$response->assertSee('x-ui.button');
$response->assertSee('x-ui.icon-button');
$response->assertSee('Primary');
$response->assertSee('Secondary');
$response->assertSee('Tertiary');
$response->assertSee('Ghost');
$response->assertSee('Danger primary');
$response->assertSee('Danger tertiary');
$response->assertSee('Danger ghost');
$response->assertSee('Extra small');
$response->assertSee('Large expressive');
$response->assertSee('2XL');
$response->assertSee('data-button-group-layout="horizontal-static"', false);
$response->assertSee('data-button-group-layout="vertical-fluid"', false);
$response->assertSee('data-button-group-icon-rule="all-or-none"', false);
$response->assertSee('Icon-only buttons use the same state tokens');
$response->assertSee('data-button-icon-only-tooltip-rule="always-required"', false);
$response->assertSee('Do not use danger icon-only buttons');
$response->assertDontSee('data-button-group-overflow-rule="menu-buttons"', false);
$response->assertDontSee('Generic fallback');
$response->assertDontSee('TODO');
$response->assertDontSee('btn btn-primary');
```

## 17. Related APIs

| API                       | Route                                                            |
| ------------------------- | ---------------------------------------------------------------- |
| Link                      | `/platform/ui-reference/components/link`                         |
| Menu buttons              | `/platform/ui-reference/components/menu-buttons`                 |
| Tooltip                   | `/platform/ui-reference/components/tooltip`                      |
| Inline loading            | `/platform/ui-reference/components/inline-loading`               |
| Modal                     | `/platform/ui-reference/components/modal`                        |
| Notification              | `/platform/ui-reference/components/notification`                 |
| Forms pattern             | `/platform/ui-reference/patterns/forms`                          |
| Tables pattern            | `/platform/ui-reference/patterns/tables`                         |
| Layout pattern            | `/platform/ui-reference/patterns/layout`                         |
| Planned table toolbar API | See [UI API Registry](../api-registry.md)                        |
| Planned page header API   | See [UI API Registry](../api-registry.md)                        |
| Components overview       | `/platform/ui-reference/components`                              |
| Canonical button doc      | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fbutton.md` |
| Carbon button usage       | `https://carbondesignsystem.com/components/button/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Button usage, style, and accessibility guidance inform action hierarchy, sizing, grouping, label, icon, loading, and accessibility rules. Login App keeps its own Blade API, Heroicons icon standard, semantic prop names, CSS variable model, and UI Reference proof.

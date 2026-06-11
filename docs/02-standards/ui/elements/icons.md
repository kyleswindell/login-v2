---
title: Icons
slug: icons
api_layer: Foundation Element API
guide_status: implemented
system_maturity: partial
ui_reference_route: /platform/ui-reference/elements/icons
canonical_doc: docs/02-standards/ui/elements/icons.md
carbon_reference:
  - https://carbondesignsystem.com/elements/icons/usage/
  - https://carbondesignsystem.com/elements/icons/library/
related_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - pictograms
related_components:
  - button
  - link
  - menu-buttons
  - notification
  - tag
  - text-input
  - search
  - data-table
  - tooltip
related_patterns:
  - navigation
  - forms
  - data-and-content
  - navigation
---

# Icons Element API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed icon size model](#31-installed-icon-size-model)
  - [3.2. Installed icon role model](#32-installed-icon-role-model)
- [4. Token API](#4-token-api)
  - [4.1. Approved icon inventory rules](#41-approved-icon-inventory-rules)
  - [4.2. Recommended app aliases](#42-recommended-app-aliases)
- [5. CSS variable API](#5-css-variable-api)
- [6. Utility class/helper API](#6-utility-classhelper-api)
  - [6.1. Allowed utility classes](#61-allowed-utility-classes)
  - [6.2. Allowed Blade APIs and wrappers](#62-allowed-blade-apis-and-wrappers)
  - [6.3. Canonical code examples](#63-canonical-code-examples)
- [7. Allowed usage](#7-allowed-usage)
  - [7.1. Selection guidance](#71-selection-guidance)
  - [7.2. Decorative versus meaningful usage](#72-decorative-versus-meaningful-usage)
- [8. Component and pattern consumers](#8-component-and-pattern-consumers)
  - [8.1. Component consumers](#81-component-consumers)
  - [8.2. Pattern consumers](#82-pattern-consumers)
- [9. Theme behavior](#9-theme-behavior)
- [10. State behavior](#10-state-behavior)
- [11. Accessibility contract](#11-accessibility-contract)
  - [11.1. Required rules](#111-required-rules)
  - [11.2. Accessible labeling patterns](#112-accessible-labeling-patterns)
- [12. Content contract](#12-content-contract)
- [13. Prohibited usage](#13-prohibited-usage)
- [14. Deferred or gated capabilities](#14-deferred-or-gated-capabilities)
- [15. Implementation and UI Reference Checklist](#15-implementation-and-ui-reference-checklist)
  - [15.1. Implementation checklist](#151-implementation-checklist)
  - [15.2. UI Reference proof checklist](#152-ui-reference-proof-checklist)
- [16. UI Reference requirements](#16-ui-reference-requirements)
- [17. Testing and acceptance criteria](#17-testing-and-acceptance-criteria)
  - [17.1. Suggested automated assertions](#171-suggested-automated-assertions)
- [18. Related APIs](#18-related-apis)
- [19. References](#19-references)

## 1. API summary

Icons communicate actions, status, navigation, and affordances at dense UI scale.

Icons is a Foundation Element API. Component and Pattern APIs must consume it instead of redefining local values.

Icons is the installed visual-symbol standard for Login App 2.0. It defines which icon library is allowed, how icons are sized, how they inherit color, how icon-only controls are labeled, and how icons are composed with Components and Patterns. It does not authorize alternate icon libraries, decorative one-off SVGs, pictograms, logos, emoji-based status marks, or feature-local icon sizing rules.

Canonical API responsibilities:

- Installed icon library selection.
- Icon size scale.
- Icon color inheritance through `currentColor`.
- Icon alignment with text.
- Status, action, navigation, affordance, and validation icon usage.
- Decorative versus meaningful icon treatment.
- Icon-only control labeling.
- Minimum interactive target rules.
- Theme-safe icon rendering.
- Component and Pattern composition boundaries.

Non-owned responsibilities:

- Semantic color choice. Use the Color Element API.
- Spacing between icons and text. Use the Spacing Element API or the owning Component API.
- Typography sizing and line height. Use the Typography Element API.
- Large illustrative visuals. Use the Pictograms Element API.
- Loading animation. Use Loading or Inline loading Component APIs and the Motion Element API.
- Logo marks and product identity. Use approved brand assets outside this Element API.

Use the Icons Element API whenever the implementation needs a compact symbol. Do not select or size icons by visual preference.

## 2. Status and ownership

| Field                  | Value                                                                                                  |
| ---------------------- | ------------------------------------------------------------------------------------------------------ |
| Guide status           | Implemented                                                                                            |
| System maturity        | Partial                                                                                                |
| API layer              | Foundation Element API                                                                                 |
| Element slug           | icons                                                                                                  |
| UI Reference route     | `/platform/ui-reference/elements/icons`                                                                |
| Canonical doc          | `docs/02-standards/ui/elements/icons.md`                                                               |
| Installed icon library | Heroicons                                                                                              |
| Primary consumers      | Buttons, links, menus, notifications, tags, fields, tables, app shell, navigation, documentation pages |
| Carbon benchmark       | Carbon Icons usage and library                                                                         |

`System maturity: Partial` means Login App 2.0 has an installed Heroicons direction and existing icon use, but the complete approved icon inventory, canonical wrappers, and UI Reference proof may still be expanding. Feature work must use the icon names, sizes, wrappers, and accessibility rules documented here and proven by the UI Reference route.

## 3. Installed standard

Heroicons-backed UI icon usage for actions, navigation, statuses, and affordances.

Login App 2.0 uses Carbon's icon guidance as a benchmark for sizing, alignment, color, target size, and accessibility, while using Heroicons as the installed app icon library. The installed standard is:

1. Use Heroicons as the default and only approved UI icon library.
2. Use icons only when they clarify action, status, navigation, affordance, or field meaning.
3. Use `currentColor` so icons inherit approved text, action, status, or icon color roles.
4. Keep UI icons monochrome.
5. Keep icon size consistent with the surrounding component and text size.
6. Keep interactive icon targets at least `44px` by `44px` unless a documented inline-text exception applies.
7. Give icon-only controls an accessible name.
8. Hide decorative icons from assistive technology.
9. Do not use icons as a substitute for required labels, visible validation, or primary content.
10. Do not import another icon set without a separate decision record and an update to this Element standard.

### 3.1. Installed icon size model

| App role             | Icon class                             |       Rendered size | Allowed usage                                                                                     | Notes                                                   |
| -------------------- | -------------------------------------- | ------------------: | ------------------------------------------------------------------------------------------------- | ------------------------------------------------------- |
| Dense UI icon        | `h-4 w-4`                              |                16px | Inline text, table rows, dense menu items, compact status, validation hints.                      | Default for dense admin UI.                             |
| Standard action icon | `h-5 w-5`                              |                20px | Buttons, icon buttons, toolbar actions, menu triggers, navigation affordances.                    | Default when paired with medium controls.               |
| Roomy UI icon        | `h-6 w-6`                              |                24px | Larger controls, prominent notices, empty-state support when a pictogram is not needed.           | Use sparingly.                                          |
| Large utility icon   | `h-8 w-8`                              |                32px | Rare high-emphasis UI moments, documentation examples, lightweight non-illustrative empty states. | Do not use as a pictogram replacement.                  |
| Icon-only target     | `h-11 w-11` wrapper with centered icon | 44px target minimum | Icon-only buttons, table action buttons, toolbar controls, shell controls.                        | Target size is the clickable area, not the SVG artwork. |

Do not create local sizes such as `h-[18px]`, `w-[22px]`, `size-7`, or arbitrary SVG dimensions unless this standard and the UI Reference route are updated.

### 3.2. Installed icon role model

| Role       | Installed meaning                                                                            | Allowed consumers                                                    | Example                                                           |
| ---------- | -------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- | ----------------------------------------------------------------- |
| Action     | The icon helps identify an action.                                                           | Button, icon button, menu button, row action, toolbar action.        | Cog icon in a settings action.                                    |
| Navigation | The icon helps identify destination or movement.                                             | App shell, breadcrumb-adjacent affordance, menu item, sidebar item.  | Arrow or home icon in navigation.                                 |
| Status     | The icon reinforces semantic state.                                                          | Notification, badge/status, validation, progress summary.            | Check circle for success, exclamation for warning.                |
| Affordance | The icon communicates expandable, dismissible, sortable, filterable, or selectable behavior. | Accordion, dropdown, select, menu, table, modal close, search clear. | Chevron, X mark, funnel, sort indicator.                          |
| Decoration | The icon adds no unique information.                                                         | Rare, component-owned visual support only.                           | Decorative chevron where text and ARIA already communicate state. |

When an icon is meaningful, it must have a programmatic name or be paired with visible text that names the meaning. When an icon is decorative, it must be hidden from assistive technology.

## 4. Token API

| Token/helper                        | Variable or value                                                 | Allowed API/consumer                                     | Example                                                                                                               |
| ----------------------------------- | ----------------------------------------------------------------- | -------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------- |
| Dense UI icon                       | `currentColor` from text/status/action token; `h-4 w-4`           | Heroicon inline, menu item, table row, validation hint   | `<x-heroicon-o-check-circle class="h-4 w-4" aria-hidden="true" />`                                                    |
| Action icon                         | `currentColor` from button/menu item; `h-5 w-5`                   | Button, icon button, menu button, toolbar action         | `<x-heroicon-o-cog-6-tooth class="h-5 w-5" aria-hidden="true" />`                                                     |
| Roomy icon                          | `currentColor`; `h-6 w-6`                                         | Larger action rows, notices, prominent utility controls  | `<x-heroicon-o-information-circle class="h-6 w-6" aria-hidden="true" />`                                              |
| Large utility icon                  | `currentColor`; `h-8 w-8`                                         | Documentation or rare high-emphasis utility states       | `<x-heroicon-o-shield-check class="h-8 w-8" aria-hidden="true" />`                                                    |
| Icon-only control                   | `h-11 w-11` target with centered `h-5 w-5` icon                   | `<x-ui.icon-button>`, toolbar controls, table actions    | `<button class="inline-flex h-11 w-11 items-center justify-center" aria-label="Open filters">...</button>`            |
| Text-paired icon                    | `inline-flex items-center gap-2`; icon inherits text color        | Links, buttons, menu items, status rows                  | `<span class="inline-flex items-center gap-2"><x-heroicon-o-check class="h-4 w-4" aria-hidden="true" /> Saved</span>` |
| Status success icon                 | `currentColor` from success token                                 | Notification, status badge, validation summary           | `<x-heroicon-o-check-circle class="h-4 w-4" aria-hidden="true" />`                                                    |
| Status warning icon                 | `currentColor` from warning token                                 | Warning message, warning badge, risk notice              | `<x-heroicon-o-exclamation-triangle class="h-4 w-4" aria-hidden="true" />`                                            |
| Status danger icon                  | `currentColor` from danger/error token                            | Error message, destructive notice, invalid field summary | `<x-heroicon-o-x-circle class="h-4 w-4" aria-hidden="true" />`                                                        |
| Status info icon                    | `currentColor` from info token                                    | Informational notification, helper notice                | `<x-heroicon-o-information-circle class="h-4 w-4" aria-hidden="true" />`                                              |
| Decorative icon                     | `aria-hidden="true" focusable="false"` where applicable           | Visual affordances already described by text/ARIA        | `<x-heroicon-o-chevron-down class="h-4 w-4" aria-hidden="true" />`                                                    |
| Meaningful standalone icon          | Accessible name through wrapper or component prop                 | Icon-only button, status summary, navigation control     | `<x-ui.icon-button icon="funnel" label="Open filters" />`                                                             |
| Tooltip-supported icon-only control | Accessible label plus visible tooltip where required by component | Icon-only button, overflow action, table row action      | `<x-ui.icon-button icon="trash" label="Delete user" tooltip="Delete user" />`                                         |

Only use Token API rows as installed standards where the helper, class, component, or icon name exists in the application. If a proposed icon helper is not yet present in the installed API, do not invent a local helper in feature code.

### 4.1. Approved icon inventory rules

The UI Reference route owns the approved icon table. Each approved icon entry should define:

| Field                | Required value                                                       |
| -------------------- | -------------------------------------------------------------------- |
| Icon name            | The canonical Heroicons name or app alias.                           |
| Style                | Outline or solid, when the app has a reason to expose both.          |
| Role                 | Action, navigation, status, affordance, or decorative.               |
| Default size         | `h-4 w-4`, `h-5 w-5`, `h-6 w-6`, or `h-8 w-8`.                       |
| Color source         | Adjacent text, action token, status token, or component-owned token. |
| Accessible treatment | Visible text, `aria-hidden`, `aria-label`, or component label prop.  |
| Owning API           | Element, Component, or Pattern API that may use it.                  |

Do not add an icon to feature code first and document it later. Add or confirm the icon in the approved inventory before feature use.

### 4.2. Recommended app aliases

Aliases should be used only when the app exposes them through a canonical helper, config map, or component prop. These examples describe the intended alias model and should not be treated as implemented helper names unless they exist in code.

| App alias   | Heroicons candidate                         | Role                         | Typical consumer                             |
| ----------- | ------------------------------------------- | ---------------------------- | -------------------------------------------- |
| `check`     | `check` / `check-circle`                    | Success, completion, confirm | Status, notification, button.                |
| `warning`   | `exclamation-triangle`                      | Warning                      | Notification, validation, risk notice.       |
| `error`     | `x-circle` / `exclamation-circle`           | Error/failure                | Validation, notification, failed job.        |
| `info`      | `information-circle`                        | Information                  | Helper notice, notification.                 |
| `settings`  | `cog-6-tooth`                               | Configuration                | Menu item, toolbar action.                   |
| `filter`    | `funnel`                                    | Filtering                    | Table toolbar, search/filter panel.          |
| `search`    | `magnifying-glass`                          | Search                       | Search component.                            |
| `close`     | `x-mark`                                    | Dismissal                    | Modal, tag, toast, panel close.              |
| `open-menu` | `ellipsis-horizontal` / `ellipsis-vertical` | Overflow menu                | Menu buttons, table actions.                 |
| `expand`    | `chevron-down` / `chevron-right`            | Disclosure                   | Accordion, select, dropdown, tree view.      |
| `external`  | `arrow-top-right-on-square`                 | External link                | Link component.                              |
| `delete`    | `trash`                                     | Destructive action           | Button/menu item with destructive treatment. |

Icon aliases should improve consistency. They should not obscure the actual installed Heroicons dependency or create a second icon library.

## 5. CSS variable API

Use only the CSS variables and token aliases listed in the Token API table or the linked token standards. Do not introduce feature-local CSS variables for this Element without updating this standard.

Icons should normally inherit color from the surrounding component or text through `currentColor`. The Icons Element API may consume these Color Element roles:

| Variable family | Status                  | Owner                     | Purpose                              | Allowed icon usage                                                     |
| --------------- | ----------------------- | ------------------------- | ------------------------------------ | ---------------------------------------------------------------------- |
| `--ui-text-*`   | Implemented / expanding | Color Element             | Text hierarchy and helper text.      | Icons paired with text, muted metadata icons, documentation icons.     |
| `--ui-icon-*`   | Implemented / expanding | Color + Icons Elements    | Icon-specific color aliases.         | Functional icons where a dedicated icon role exists.                   |
| `--ui-action-*` | Component-owned         | Button/Menu button APIs   | Action foreground/background states. | Icons inside action components only.                                   |
| `--ui-status-*` | Implemented / queued    | Color + status components | Semantic status color.               | Status icons in notifications, badges, validation, and summaries.      |
| `--ui-focus*`   | Implemented / queued    | Color Element             | Focus-visible treatment.             | Icon-only control wrappers, not the icon SVG itself.                   |
| `--ui-border-*` | Implemented / expanding | Color Element             | Boundaries around icon containers.   | Icon buttons, tags, and status containers when owned by the component. |

Rules:

- Do not set SVG `fill`, `stroke`, or inline color values with raw hex values.
- Do not define feature-local variables such as `--reports-icon-blue`, `--settings-warning-icon`, or `--dashboard-action-icon`.
- Do not add per-icon colors. Use semantic roles or adjacent text/action/status color.
- Do not create interaction-state colors on the icon SVG. Interactive state treatment belongs to the owning component container.

## 6. Utility class/helper API

Allowed utility classes, Blade helpers, and component wrappers are those listed in the Token API table and demonstrated by the UI Reference route.

### 6.1. Allowed utility classes

| Utility                     | Status                                 | Use                                                           |
| --------------------------- | -------------------------------------- | ------------------------------------------------------------- |
| `h-4 w-4`                   | Implemented                            | Dense 16px icon artwork.                                      |
| `h-5 w-5`                   | Implemented                            | Standard 20px action icon artwork.                            |
| `h-6 w-6`                   | Implemented                            | Roomy 24px icon artwork.                                      |
| `h-8 w-8`                   | Implemented                            | Large 32px utility icon artwork.                              |
| `h-11 w-11`                 | Implemented                            | Minimum 44px square icon-only control target.                 |
| `inline-flex items-center`  | Implemented                            | Align icon with text or center icon in control.               |
| `gap-1`, `gap-1.5`, `gap-2` | Implemented through Spacing Element    | Spacing between icon and label when not owned by a component. |
| `shrink-0`                  | Implemented                            | Prevent icon collapse next to wrapping text.                  |
| `aria-hidden="true"`        | Required for decorative icons          | Hide visual-only icons from assistive technology.             |
| `aria-label="..."`          | Required for icon-only native controls | Provide accessible name when no visible text exists.          |

### 6.2. Allowed Blade APIs and wrappers

| API                                   | Status                              | Use                                                                                  |
| ------------------------------------- | ----------------------------------- | ------------------------------------------------------------------------------------ |
| `<x-heroicon-o-{name}>`               | Implemented                         | Default outline Heroicons usage.                                                     |
| `<x-heroicon-s-{name}>`               | Allowed only where documented       | Solid Heroicons for status or high-emphasis use if approved by the owning Component. |
| `<x-ui.icon-button>`                  | Implemented or target Component API | Icon-only action control with label, tooltip, target, and focus behavior.            |
| `<x-ui.button icon="...">`            | Component-owned                     | Button with icon and visible text.                                                   |
| `<x-ui.badge tone="..." icon="...">`  | Component-owned                     | Compact status/metadata with semantic icon when supported.                           |
| `<x-ui.status tone="..." icon="...">` | Component-owned                     | Status row or status chip with semantic icon when supported.                         |

If a Blade wrapper is not installed, do not fake it with local partials. Either use the approved Heroicons component directly under this standard or add the wrapper through the owning Component API.

### 6.3. Canonical code examples

Dense status icon with visible text:

```blade
<span class="inline-flex items-center gap-1.5" style="color: var(--ui-text-success);">
    <x-heroicon-o-check-circle class="h-4 w-4 shrink-0" aria-hidden="true" />
    <span>Saved</span>
</span>
```

Icon-only native button with accessible name:

```blade
<button
    type="button"
    class="inline-flex h-11 w-11 items-center justify-center rounded-md"
    aria-label="Open filters"
>
    <x-heroicon-o-funnel class="h-5 w-5" aria-hidden="true" />
</button>
```

Icon paired with app button API:

```blade
<x-ui.button semantic="secondary" icon="arrow-right" icon-position="end">
    Continue
</x-ui.button>
```

Decorative affordance icon:

```blade
<x-heroicon-o-chevron-down class="h-4 w-4" aria-hidden="true" />
```

## 7. Allowed usage

- Use when: an icon helps identify action, status, navigation, or affordance.
- Avoid when: the icon is decoration with no meaning.
- Common app examples: menu items, icon buttons, statuses, inline validation, notifications, and table actions.

### 7.1. Selection guidance

| Need                                          | Use                                                            | Do not use                                                              |
| --------------------------------------------- | -------------------------------------------------------------- | ----------------------------------------------------------------------- |
| Trigger a visible action with text            | Button with optional icon.                                     | Icon-only button unless space is constrained and the action is obvious. |
| Trigger a compact action without visible text | Icon button with accessible label and tooltip where required.  | Raw SVG inside a button without a label.                                |
| Navigate to another page/resource             | Link with optional leading/trailing icon.                      | Button or icon-only control unless the Component API owns the behavior. |
| Show semantic status                          | Status/Notification/Badge component with optional status icon. | Colored icon alone.                                                     |
| Show validation meaning                       | Field component validation UI with icon and visible message.   | Icon without text.                                                      |
| Represent disclosure or expansion             | Owning Component affordance icon.                              | Feature-local chevron logic.                                            |
| Provide large explanatory artwork             | Pictogram.                                                     | Oversized UI icon.                                                      |
| Show loading                                  | Loading or Inline loading Component.                           | Spinning random icon.                                                   |

### 7.2. Decorative versus meaningful usage

| Icon treatment                    | Required implementation                                                                     | Example                                                                 |
| --------------------------------- | ------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------- |
| Decorative icon                   | Add `aria-hidden="true"`; do not add duplicate labels.                                      | Chevron in Accordion when trigger already has text and `aria-expanded`. |
| Meaningful icon with visible text | Use visible label text; icon may be `aria-hidden`.                                          | Check icon next to `Saved`.                                             |
| Meaningful standalone icon        | Provide accessible name through `aria-label`, `aria-labelledby`, or component `label` prop. | Icon-only filter button.                                                |
| Status icon                       | Pair with visible status text and semantic color.                                           | Error icon next to `Email is required`.                                 |
| Icon-only action                  | Use accessible name, focus-visible treatment, and minimum target size.                      | Table row overflow menu button.                                         |

## 8. Component and pattern consumers

Components and Patterns must consume this Element through documented tokens, utilities, or wrappers. They must not hard-code alternate local values for the same role.

### 8.1. Component consumers

| Consumer                          | Required icon behavior                                                                         |
| --------------------------------- | ---------------------------------------------------------------------------------------------- |
| Button                            | Owns icon placement, label spacing, disabled/loading behavior, and danger icon restrictions.   |
| Icon button                       | Owns accessible label, tooltip policy, 44px target, focus-visible state, and disabled state.   |
| Link                              | Owns inline, standalone, external, and icon-leading/trailing behavior.                         |
| Menu buttons/Menu                 | Own icon alignment in triggers and menu items. Overflow trigger must have an accessible name.  |
| Notification                      | Owns semantic icon selection and status color.                                                 |
| Tag/Badge/Status                  | Own compact semantic icon usage and removal icon behavior.                                     |
| Text input/Search/Select/Dropdown | Own field affordance icons, clear icons, error/warning icons, and disabled/read-only behavior. |
| Data table                        | Own row action icons, sort icons, selected/current row icons, and overflow action icons.       |
| Tooltip/Toggletip                 | Own help icons, accessible triggers, and interactive/non-interactive boundaries.               |

### 8.2. Pattern consumers

| Pattern                    | Required icon behavior                                                                                                                                           |
| -------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| App shell/navigation       | Use approved navigation icons only when they improve recognition. Visible nav labels remain required unless the collapsed-shell Pattern owns icon-only behavior. |
| Form layout                | Field icons must not replace labels, helper text, validation messages, or recovery guidance.                                                                     |
| Table toolbar/actions      | Filter, search, export, and row actions must use approved action icons and icon-button rules.                                                                    |
| Overlay/action composition | Close, back, more, and destructive action icons must be owned by the overlay/action Pattern or Component API.                                                    |

## 9. Theme behavior

This Element must remain valid in supported light, dark, inline, inverse, and high-contrast contexts when those contexts apply. Theme behavior is proven on the UI Reference page.

Icons must inherit from theme-safe roles. The icon SVG should not carry a local color that fails when the surrounding theme changes.

| Theme context | Required behavior                                                                                     |
| ------------- | ----------------------------------------------------------------------------------------------------- |
| Light/default | Icons inherit approved text, action, status, or icon tokens.                                          |
| Dark/inverse  | Icons use inverse or context-safe tokens through the owning Component/Pattern.                        |
| Inline theme  | Icon color must remain tied to adjacent text or component role.                                       |
| High contrast | Meaningful icons must remain visible and must not be the only indicator of meaning.                   |
| Disabled      | Disabled icon treatment must come from the owning Component state, not from a local opacity override. |

## 10. State behavior

Interactive states such as hover, active, selected, focus-visible, disabled, loading, and validation must use documented Element roles where applicable.

Icons themselves do not own interaction states. The owning Component or Pattern owns hover, active, selected, focus-visible, disabled, loading, and validation behavior.

| State            | Icon requirement                                                                       | Owner                              |
| ---------------- | -------------------------------------------------------------------------------------- | ---------------------------------- |
| Default          | Icon inherits current text/action/status color.                                        | Icon Element + owning API.         |
| Hover            | Container or text role changes according to owning Component.                          | Component/Pattern.                 |
| Active/pressed   | Container or text role changes according to owning Component.                          | Component/Pattern.                 |
| Selected/current | Semantic selected/current state must be visible beyond icon color alone.               | Component/Pattern.                 |
| Focus-visible    | Focus ring appears on the interactive wrapper, not the SVG alone.                      | Component/Pattern + Color Element. |
| Disabled         | Icon is disabled through owning control state.                                         | Component/Pattern.                 |
| Loading          | Use Loading/Inline loading APIs. Do not spin arbitrary Heroicons.                      | Loading Component.                 |
| Validation       | Pair validation icon with visible text and field state.                                | Field Component/Form Pattern.      |
| Empty            | Use approved empty-state component or Pictogram when illustrative support is required. | Pattern/Pictograms Element.        |

## 11. Accessibility contract

Icons must be implemented according to their meaning.

### 11.1. Required rules

- Icon-only controls must have an accessible name.
- Icon-only controls must have a visible focus state.
- Icon-only controls must meet the minimum interactive target requirement.
- Decorative icons must be hidden from assistive technology.
- Meaningful icons must be paired with visible text or a programmatic name.
- Semantic meaning must not rely on color or icon shape alone.
- Icons in disabled controls must not be the only clue that the control is unavailable.
- Icons used as affordances must not conflict with the accessible state exposed by the owning component.

### 11.2. Accessible labeling patterns

| Pattern                   | Allowed implementation                                                                                             |
| ------------------------- | ------------------------------------------------------------------------------------------------------------------ |
| Icon next to visible text | Icon may use `aria-hidden="true"`; visible text names the action/status.                                           |
| Icon-only button          | Use `aria-label` or component `label` prop. Add tooltip when the Component API requires visible discovery.         |
| Icon in field validation  | Icon is decorative; visible error/warning text carries the message.                                                |
| Status-only icon          | Not allowed. Add visible text or accessible status label.                                                          |
| Decorative chevron        | `aria-hidden="true"`; state must be exposed through `aria-expanded`, `aria-selected`, or the owning control state. |

## 12. Content contract

Icons support content; they do not replace required content.

| Context                | Content rule                                                                                      |
| ---------------------- | ------------------------------------------------------------------------------------------------- |
| Button with icon       | Visible label must still be clear, action-oriented, and sentence case.                            |
| Icon-only button       | Accessible label must name the action using verb + noun, such as `Open filters` or `Delete user`. |
| Navigation icon        | Visible label is required unless a collapsed-shell Pattern explicitly owns icon-only navigation.  |
| Status icon            | Visible status text is required.                                                                  |
| Validation icon        | Visible error/warning message is required.                                                        |
| Tooltip-supported icon | Tooltip text and accessible label must match or be semantically equivalent.                       |
| External link icon     | Link text must still communicate the destination or action.                                       |

Avoid vague accessible names such as `Icon`, `Settings icon`, `Click`, `More`, or `Open`. Prefer action labels such as `Open settings`, `Show row actions`, `Clear search`, or `Close dialog`.

## 13. Prohibited usage

- Do not bypass this Element API with one-off raw values, local utility clusters, or custom design tokens.
- Heroicons remain the default app icon library.
- Use 16px icons for dense UI; use larger sizes only when the layout requires it.
- Icons are monochrome and theme-aware through `currentColor`.
- Do not import another icon set without a separate decision record.
- Do not use raw inline SVG copied into feature views when an approved Heroicons component or app wrapper exists.
- Do not use icons as decoration when they add no meaning or hierarchy.
- Do not use icon color alone to communicate status, validation, selection, or danger.
- Do not create arbitrary icon sizes or local SVG dimensions.
- Do not put focus rings on SVGs instead of the interactive wrapper.
- Do not use icon-only controls without an accessible name.
- Do not use oversized icons as substitutes for Pictograms.
- Do not animate icons unless the owning Loading, Motion, or Component API documents the behavior.
- Do not add unsupported icon aliases or local icon maps inside feature code.
- Do not use danger/destructive icon-only controls unless the owning Button/Icon button standard explicitly approves that scenario.

## 14. Deferred or gated capabilities

| Capability                         | Status       | Gate                                                                                                  |
| ---------------------------------- | ------------ | ----------------------------------------------------------------------------------------------------- |
| Alternate icon library             | Not approved | Requires decision record, migration plan, token review, accessibility review, and UI Reference proof. |
| App-wide icon alias helper         | Gated        | Requires canonical icon map, API docs, tests, and UI Reference inventory.                             |
| Solid Heroicons as a general style | Gated        | Requires component-by-component approval; outline remains default unless documented.                  |
| Animated icons                     | Deferred     | Requires Motion standard, reduced-motion behavior, and owning Component API.                          |
| Custom SVG icons                   | Gated        | Requires inventory entry, accessible treatment, sizing rule, source ownership, and design review.     |
| Duotone/multi-color icons          | Not approved | Conflicts with monochrome/currentColor standard unless a new standard is approved.                    |
| Icon-only destructive actions      | Gated        | Requires Button/Icon button Component approval and explicit UI Reference proof.                       |

No additional capability is approved without updating this Element standard and UI Reference proof.

## 15. Implementation and UI Reference Checklist

### 15.1. Implementation checklist

| Requirement                 | Standard expectation                                                                                                              |
| --------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source           | The standard names the approved token families, CSS variables, utility classes, helpers, source files, or explicit deferred gate. |
| Token/class/helper coverage | The durable Element API surface is listed for Component and Pattern consumers.                                                    |
| Theme/state behavior        | Theme, state, reduced-motion, accessibility, or interaction rules owned by the Element are defined.                               |
| Consumers                   | Component and Pattern consumers are named where they rely on this Element.                                                        |
| Prohibited usage            | Feature code, Components, and Patterns are told what they must not redefine locally.                                              |
| Tests                       | Route/content/API assertions are defined to prove the Element contract.                                                           |

### 15.2. UI Reference proof checklist

| Requirement          | Visual proof expectation                                                                                            |
| -------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Live examples        | The page renders examples with app CSS/JS, not screenshots only.                                                    |
| Token/API references | Token, class, helper, or API names appear with example usage.                                                       |
| Theme/state examples | Relevant theme contexts, variants, states, or gated disposition surfaces are visible.                               |
| Accessibility proof  | Contrast, focus, semantics, hit targets, reduced motion, or equivalent Element constraints are shown or documented. |
| Related APIs         | Consuming Components, Patterns, source files, and the canonical standard are linked.                                |
| Manual review        | The page provides enough rendered proof for visual review without opening source code first.                        |
## 16. UI Reference requirements

The `/platform/ui-reference/elements/icons` route must prove this standard with rendered app code, not screenshots only.

Required sections and examples:

1. Approved Heroicons table.
   - Searchable or grouped approved icon inventory.
   - Icon name or app alias.
   - Heroicons source name.
   - Role: action, navigation, status, affordance, decorative.
   - Default size.
   - Accessible treatment.
   - Allowed consumers.
2. Icon sizes.
   - Render `h-4 w-4` / 16px dense icon.
   - Render `h-5 w-5` / 20px action icon.
   - Render `h-6 w-6` / 24px roomy icon.
   - Render `h-8 w-8` / 32px large utility icon.
   - State that arbitrary sizes are not allowed.
3. Icon with text.
   - Leading icon with label.
   - Trailing icon with label.
   - Inline status icon with text.
   - Link with trailing external icon.
   - Button with trailing icon.
4. Icon-only controls.
   - Standard icon button with accessible label.
   - Table row action icon button.
   - Toolbar icon button.
   - Disabled icon button.
   - Tooltip-supported icon button.
   - Show the 44px target boundary visually.
5. Status icons.
   - Success.
   - Warning.
   - Danger/error.
   - Information.
   - Neutral metadata, if supported.
   - Each must include visible text and semantic color.
6. Decorative versus meaningful icons.
   - Decorative chevron with `aria-hidden="true"`.
   - Meaningful standalone icon with accessible name.
   - Meaningful icon paired with visible text.
   - Invalid example note: icon-only status without text is not allowed.
7. Hit target demo.
   - Show icon artwork inside a minimum 44px wrapper.
   - Show artwork size separately from clickable target size.
   - Include note that padding expands the target; it should not arbitrarily scale the artwork.
8. Theme examples.
   - Light surface.
   - Dark/inverse surface where supported.
   - Status color surface.
   - Disabled state.
9. Developer API examples.
   - Direct Heroicons usage.
   - `<x-ui.icon-button>` usage when installed.
   - Button with icon usage.
   - Decorative icon usage.
   - Status icon with visible text.

The UI Reference page may use matrices, grouped examples, comparison grids, or tabbed examples. It must not require a tab-only layout.

## 17. Testing and acceptance criteria

- `/platform/ui-reference/elements/icons` returns 200 for authorized users.
- The page renders live examples with app CSS/JS rather than screenshots only.
- The page shows token/class/helper API references, allowed usage, prohibited usage, accessibility constraints, and implementation status.
- The page renders the approved Heroicons table or inventory group.
- The page renders 16px, 20px, 24px, and 32px icon artwork examples.
- The page distinguishes icon artwork size from the 44px minimum icon-only control target.
- The page renders at least one icon paired with visible text.
- The page renders at least one icon-only control with an accessible name.
- The page renders success, warning, danger/error, and information status icon examples with visible text.
- The page documents decorative versus meaningful icon treatment.
- The page states that Heroicons is the approved app library.
- The page states that alternate icon sets, arbitrary icon sizes, and raw copied SVGs are prohibited unless the standard is updated.

### 17.1. Suggested automated assertions

- Assert route status `200` for authorized users.
- Assert the page includes `data-ui-reference-element="icons"` or equivalent route-specific marker.
- Assert the page includes `Heroicons`.
- Assert the page includes `h-4 w-4`, `h-5 w-5`, `h-6 w-6`, and `h-8 w-8` examples or equivalent rendered labels.
- Assert the page includes `44px` and `h-11 w-11` or equivalent target-size proof.
- Assert the page includes `currentColor`.
- Assert the page includes `aria-hidden="true"` guidance.
- Assert the page includes accessible-label guidance for icon-only controls.
- Assert no generic fallback content appears.

## 18. Related APIs

| API                    | Route                                                         |
| ---------------------- | ------------------------------------------------------------- |
| Color element          | `/platform/ui-reference/elements/color`                       |
| Spacing element        | `/platform/ui-reference/elements/spacing`                     |
| Typography element     | `/platform/ui-reference/elements/typography`                  |
| Pictograms element     | `/platform/ui-reference/elements/pictograms`                  |
| Button component       | `/platform/ui-reference/components/button`                    |
| Link component         | `/platform/ui-reference/components/link`                      |
| Menu buttons component | `/platform/ui-reference/components/menu-buttons`              |
| Notification component | `/platform/ui-reference/components/notification`              |
| Tag component          | `/platform/ui-reference/components/tag`                       |
| Search component       | `/platform/ui-reference/components/search`                    |
| Tooltip component      | `/platform/ui-reference/components/tooltip`                   |
| Canonical icons doc    | `/platform/docs?path=02-standards%2Fui%2Felements%2Ficons.md` |
| Carbon icons usage     | `https://carbondesignsystem.com/elements/icons/usage/`        |
| Carbon icons library   | `https://carbondesignsystem.com/elements/icons/library/`      |

## 19. References

- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon icon guidance informs sizing, touch targets, color, contrast, and alignment. Login App uses Heroicons as its installed icon library.

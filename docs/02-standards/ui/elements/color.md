---
title: Color
slug: color
api_layer: Foundation Element API
guide_status: implemented
system_maturity: implemented
ui_reference_route: /platform/ui-reference/elements/color
canonical_doc: docs/02-standards/ui/elements/color.md
carbon_reference:
  - https://carbondesignsystem.com/elements/color/overview/
  - https://carbondesignsystem.com/elements/color/usage/
related_elements:
  - themes
  - typography
  - icons
  - motion
  - spacing
related_components:
  - button
  - link
  - notification
  - tag
  - text-input
  - data-table
related_patterns:
  - layout
  - forms
  - overlays-and-actions
---

# Color Element API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed role model](#31-installed-role-model)
  - [3.2. Layering model](#32-layering-model)
  - [3.3. Status color model](#33-status-color-model)
- [4. Token API](#4-token-api)
  - [4.1. Token status rules](#41-token-status-rules)
  - [4.2. Carbon coverage and value mapping contract](#42-carbon-coverage-and-value-mapping-contract)
  - [4.3. Required mapping table shape](#43-required-mapping-table-shape)
  - [4.4. Baseline Carbon-to-Login role mapping](#44-baseline-carbon-to-login-role-mapping)
- [5. CSS variable API](#5-css-variable-api)
  - [5.1. Installed and approved variable families](#51-installed-and-approved-variable-families)
  - [5.2. Required fallback behavior](#52-required-fallback-behavior)
- [6. Utility class/helper API](#6-utility-classhelper-api)
  - [6.1. Allowed classes and helpers](#61-allowed-classes-and-helpers)
  - [6.2. Allowed Tailwind usage](#62-allowed-tailwind-usage)
- [7. Allowed usage](#7-allowed-usage)
  - [7.1. Use when](#71-use-when)
  - [7.2. Avoid when](#72-avoid-when)
  - [7.3. App-specific selection guidance](#73-app-specific-selection-guidance)
- [8. Component and pattern consumers](#8-component-and-pattern-consumers)
  - [8.1. Component-owned color rule](#81-component-owned-color-rule)
- [9. Theme behavior](#9-theme-behavior)
  - [9.1. Supported theme contexts](#91-supported-theme-contexts)
  - [9.2. Theme-safe rules](#92-theme-safe-rules)
  - [9.3. Inline and inverse contexts](#93-inline-and-inverse-contexts)
- [10. State behavior](#10-state-behavior)
  - [10.1. State-token rules](#101-state-token-rules)
- [11. Accessibility contract](#11-accessibility-contract)
  - [11.1. Minimum app checks](#111-minimum-app-checks)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
  - [15.1. Required live examples](#151-required-live-examples)
  - [15.2. Required implementation status display](#152-required-implementation-status-display)
  - [15.3. Required developer-facing text on UI Reference page](#153-required-developer-facing-text-on-ui-reference-page)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Color controls visual roles for content hierarchy, surfaces, fields, borders, links, actions, statuses, focus, loading, and high-contrast moments.

Color is a Foundation Element API. Component and Pattern APIs must consume it instead of redefining local values.

Color is the installed role-token standard for Login App 2.0. It defines how UI color is selected, named, consumed, themed, and tested across Element, Component, and Pattern APIs. It does not authorize local raw color values, feature-specific palette additions, or decorative semantic colors.

### 1.1. Canonical API responsibilities:

- Text hierarchy and readability.
- Surface and layer relationships.
- Field backgrounds and input states.
- Borders, dividers, rules, and key lines.
- Links and primary action treatment.
- Icon color roles.
- Semantic statuses and validation feedback.
- Focus-visible treatment.
- Loading and skeleton color roles.
- Inline, inverse, dark, light, and high-contrast contexts.
- Theme-safe color selection.

### 1.2. Non-owned responsibilities:

- Font size and line height. Use the Typography Element API.
- Component spacing and layout rhythm. Use the Spacing and 2x Grid Element APIs.
- Motion timing and easing. Use the Motion Element API.
- Icon shape and sizing. Use the Icons Element API.
- Brand illustration or pictogram artwork. Use the Pictograms Element API.

Use the Color Element API whenever the implementation needs a visual role. Do not choose colors by visual preference or by copying values from another component.

## 2. Status and ownership

| Field              | Value                                                                                                 |
| ------------------ | ----------------------------------------------------------------------------------------------------- |
| Guide status       | Implemented                                                                                           |
| System maturity    | Implemented                                                                                           |
| API layer          | Foundation Element API                                                                                |
| Element slug       | color                                                                                                 |
| UI Reference route | `/platform/ui-reference/elements/color`                                                               |
| Canonical doc      | `docs/02-standards/ui/elements/color.md`                                                              |
| Primary consumers  | Components, Patterns, page shell, form fields, actions, alerts, tables, overlays, documentation pages |
| Carbon benchmark   | Carbon Color overview and usage                                                                       |

`System maturity: Implemented` means Login App 2.0 has an installed semantic color-token direction and visible component usage. New token roles, aliases, themes, or semantic tones still require this standard and the UI Reference proof to be updated before feature use.

## 3. Installed standard

Semantic color tokens for text, icons, borders, surfaces, actions, statuses, and shadows.

Login App 2.0 uses Carbon's role-driven color architecture as a benchmark, while maintaining its own app-owned CSS variables, class names, and component APIs. The installed standard is:

1. Use role-based CSS variables and component props instead of raw color values.
2. Keep token names tied to UI roles, not visual values.
3. Keep semantic colors reserved for meaning: error, warning, success, information, destructive intent, and required attention.
4. Keep blue/action treatment reserved for primary actions, links, and approved interactive affordances.
5. Use layer and surface tokens to show elevation, grouping, and nested context.
6. Use state-specific tokens for hover, active, selected, disabled, focus, loading, and validation states.
7. Keep component-specific tokens inside their owning component contract.
8. Match Carbon token coverage depth for adopted components and patterns, using app-owned token names and values.
9. Prove all supported themes and high-contrast moments on the UI Reference page.

### 3.1. Installed role model

| Role family      | Installed meaning                                                                                           | Use when                                                                           |
| ---------------- | ----------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| Text             | Readable hierarchy for headings, body, helper, muted, inverse, disabled, and destructive text.              | Any rendered copy, labels, captions, metadata, and validation messages.            |
| Icon             | Color roles for decorative, functional, semantic, inverse, and disabled icons.                              | Icons inside buttons, links, inputs, alerts, menus, and status indicators.         |
| Surface/layer    | Backgrounds for page, cards, panels, shell regions, overlays, nested layers, and elevated regions.          | App shell, cards, modals, dropdowns, tables, widgets, and docs surfaces.           |
| Field            | Background, border, placeholder, helper, validation, and disabled roles for inputs.                         | Form controls, filters, search, selects, date inputs, and textareas.               |
| Border           | Key lines, dividers, field boundaries, card borders, focus-adjacent borders, and subtle/strong separations. | Cards, tables, panels, forms, list rows, menus, and page sections.                 |
| Link             | Inline and standalone navigation affordances.                                                               | Navigation to another page, route, external resource, or documentation.            |
| Action           | Primary, secondary, tertiary, ghost, and destructive action roles exposed through Component APIs.           | Buttons, icon buttons, menu triggers, and action bars.                             |
| Status/support   | Semantic feedback roles for success, warning, danger/error, information, and neutral state.                 | Notifications, badges, validation, progress/status summaries, and system messages. |
| Focus            | Visible focus indication for keyboard and assistive-technology users.                                       | Every interactive element.                                                         |
| Skeleton/loading | Loading placeholders and pending state surfaces.                                                            | Skeleton rows/cards/text, inline loading, page-region loading, and spinners.       |
| Overlay/shadow   | Scrims, modal backdrops, elevation shadows, and high-contrast separators.                                   | Dialogs, drawers, popovers, menus, and elevated floating layers.                   |

### 3.2. Layering model

Login App surfaces must use the installed layer roles rather than arbitrary background colors.

The dedicated UI Reference proof route is `/platform/ui-reference/elements/color/layering`. Use that page as the baseline when reviewing cards, component examples, code snippets, headers, footers, nested panels, menus, popovers, and table/form containers.

| Layer role      | Installed token examples                    | Purpose                                         | Allowed usage                                                          |
| --------------- | ------------------------------------------- | ----------------------------------------------- | ---------------------------------------------------------------------- |
| Page background | `--ui-background`, `--ui-surface`           | Base page or app-region background.             | App shell content background and large empty regions.                  |
| Layer 01        | `--ui-layer-01`, `--ui-surface`             | First surface above the page background.        | Cards, panels, tables, and primary component containers.               |
| Layer 02        | `--ui-layer-02`, `--ui-surface-elevated`    | Nested surface above Layer 01.                  | Nested cards, reference blocks, live-example panels, dropdowns, menus. |
| Layer 03        | `--ui-layer-03` when installed              | Third nested surface.                           | Deeply nested overlays only when documented by the owning Pattern.     |
| Inverse layer   | `--ui-inverse-*` roles when installed       | Light-on-dark or dark-on-light contrast moment. | Tooltips, inverse shell, callouts, and high-contrast focus moments.    |
| Overlay         | `--ui-overlay`, shadow roles when installed | Blocks or dims background context.              | Modal backdrops, drawers, and full-screen overlays.                    |

Layer tokens must communicate hierarchy without producing decorative noise. If a nested surface cannot be distinguished without custom color, update this Element API or the owning Pattern API instead of adding a local color.

### 3.3. Status color model

| Semantic role | Installed meaning                                                     | Allowed usage                                                          | Not allowed                                                          |
| ------------- | --------------------------------------------------------------------- | ---------------------------------------------------------------------- | -------------------------------------------------------------------- |
| Success       | Completed, passed, active, saved, available.                          | Badges, notifications, form success, completion summaries.             | Decorative green highlights or positive emphasis unrelated to state. |
| Warning       | Needs attention but is not blocking.                                  | Warnings, risky settings, soft validation, expiring states.            | Generic emphasis or visual decoration.                               |
| Danger/error  | Blocking failure, validation error, destructive intent, failed state. | Error notifications, invalid fields, destructive buttons, failed jobs. | Styling ordinary negative copy without an error/destructive state.   |
| Information   | Neutral contextual information.                                       | Informational alerts, helper notices, system context.                  | Replacing normal body copy or links.                                 |
| Neutral       | Non-semantic metadata, category labels, inactive states.              | Metadata badges, default tags, secondary status.                       | Pretending unknown states are success/warning/error.                 |

Do not rely on color alone for semantic meaning. Use visible text, icons, labels, or structural cues whenever color communicates state.

## 4. Token API

| Token/helper      | Variable or value                                                                    | Allowed API/consumer                                                  | Example                                                                                 |
| ----------------- | ------------------------------------------------------------------------------------ | --------------------------------------------------------------------- | --------------------------------------------------------------------------------------- |
| Text primary      | `--ui-text-primary`                                                                  | Headings, labels, high-priority body copy, component titles           | `<h2 class="ui-card-title">Account settings</h2>`                                       |
| Text strong       | `--ui-text-strong` or alias to primary when installed                                | High-emphasis text where the app exposes this alias                   | `<strong class="font-semibold" style="color: var(--ui-text-strong);">Required</strong>` |
| Text secondary    | `--ui-text-secondary`                                                                | Body copy, supporting descriptions, secondary labels                  | `<p class="ui-card-copy">Muted supporting copy</p>`                                     |
| Text muted        | `--ui-text-muted`                                                                    | Low-priority metadata where the alias exists                          | `<p class="text-sm" style="color: var(--ui-text-muted);">Last updated today</p>`        |
| Text helper       | `--ui-text-helper`                                                                   | Kicker text, helper text, metadata labels, small utility descriptions | `<p class="ui-kicker">Component overview</p>`                                           |
| Text disabled     | `--ui-text-disabled`                                                                 | Disabled copy and unavailable controls                                | Disabled fields and disabled menu items.                                                |
| Text inverse      | `--ui-text-inverse`                                                                  | Text on inverse/dark surfaces                                         | Tooltip text, dark shell headers, inverse callouts.                                     |
| Text danger       | `--ui-text-danger`, `--ui-text-error`                                                | Destructive, invalid, or failed text                                  | `<p class="ui-field-error">Email is required.</p>`                                      |
| Text warning      | `--ui-text-warning`                                                                  | Warning text where non-color cues are also present                    | Risk notices and non-blocking validation.                                               |
| Text success      | `--ui-text-success`                                                                  | Success copy where non-color cues are also present                    | Saved/completed summaries.                                                              |
| Link              | `--ui-link`, `--ui-link-hover`, `--ui-link-visited` when installed                   | `ui-link`, navigation anchors, docs links                             | `<a class="ui-link" href="/platform/docs">Open docs</a>`                                |
| Icon default      | `--ui-icon-primary`, `--ui-icon-secondary`                                           | Inline icons, component icons, menu icons                             | Icon color follows adjacent text unless semantic meaning is required.                   |
| Icon inverse      | `--ui-icon-inverse`                                                                  | Icons on inverse surfaces                                             | Tooltip or dark shell icon treatment.                                                   |
| Icon semantic     | `--ui-icon-success`, `--ui-icon-warning`, `--ui-icon-danger`, `--ui-icon-info`       | Status icons in notifications, badges, validation, and summary cards  | Error icon beside validation message.                                                   |
| Surface base      | `--ui-background`, `--ui-surface`                                                    | Page background, primary content region                               | `<main style="background: var(--ui-surface);">...</main>`                               |
| Surface elevated  | `--ui-surface-elevated`                                                              | Elevated cards, panels, menus, popovers, overlays                     | `<article class="ui-card">...</article>`                                                |
| Layer 01          | `--ui-layer-01`                                                                      | Cards, panels, table shells, base component surfaces                  | `<article class="ui-card">...</article>`                                                |
| Layer 02          | `--ui-layer-02`                                                                      | Nested cards, live-example panels, contained component regions        | `<aside style="background-color: var(--ui-layer-02);">...</aside>`                      |
| Layer 03          | `--ui-layer-03` when installed                                                       | Deep nested floating layers                                           | Pattern-owned only.                                                                     |
| Field background  | `--ui-field`, `--ui-field-hover`, `--ui-field-disabled`                              | Text input, select, textarea, search, date picker                     | `<input class="ui-field" />`                                                            |
| Field border      | `--ui-border-subtle-01`, `--ui-border-strong-01`, `--ui-border-interactive`          | Inputs, cards, panels, tables, menus                                  | `<div style="border-color: var(--ui-border-subtle-01);">...</div>`                      |
| Border subtle     | `--ui-border-subtle-01`                                                              | Low-emphasis card, panel, row, and section boundaries                 | Used by `ui-card` and reference examples.                                               |
| Border strong     | `--ui-border-strong-01` when installed                                               | Stronger divisions and high-importance boundaries                     | Table headers, selected regions, or contrast-critical divisions.                        |
| Border inverse    | `--ui-border-inverse` when installed                                                 | Borders on inverse/dark surfaces                                      | Tooltip and inverse shell regions.                                                      |
| Focus ring        | `--ui-focus-ring`, `--ui-focus`                                                      | Focus-visible utilities and component focus rules                     | `focus-visible:ring-2 focus-visible:ring-sky-400` until fully tokenized.                |
| Action primary    | `--ui-action-primary-bg`, `--ui-action-primary-bg-hover`, `--ui-action-primary-text` | `<x-ui.button semantic="primary">`                                    | `<x-ui.button semantic="primary">Save</x-ui.button>`                                    |
| Action secondary  | `--ui-action-secondary-*`                                                            | Secondary buttons and approved action groups                          | `<x-ui.button semantic="secondary">Cancel</x-ui.button>`                                |
| Action tertiary   | `--ui-action-tertiary-*`                                                             | Tertiary or low-emphasis action APIs                                  | `<x-ui.button semantic="tertiary">View details</x-ui.button>`                           |
| Action ghost      | `--ui-action-ghost-*`                                                                | Ghost buttons, icon buttons, and shell/menu actions                   | `<x-ui.icon-button icon="settings" label="Settings" />`                                 |
| Action danger     | `--ui-action-danger-*`                                                               | Destructive button variants only                                      | `<x-ui.button semantic="danger-primary">Delete</x-ui.button>`                           |
| Status success    | `--ui-status-success-bg`, `--ui-status-success-border`, `--ui-status-success-text`   | `x-ui.badge`, `x-ui.status`, notifications                            | `<x-ui.badge tone="success">Active</x-ui.badge>`                                        |
| Status warning    | `--ui-status-warning-bg`, `--ui-status-warning-border`, `--ui-status-warning-text`   | Warning notifications, badges, validation                             | `<x-ui.badge tone="warning">Expiring</x-ui.badge>`                                      |
| Status danger     | `--ui-status-danger-bg`, `--ui-status-danger-border`, `--ui-status-danger-text`      | Error notifications, invalid fields, failed states                    | `<x-ui.badge tone="danger">Failed</x-ui.badge>`                                         |
| Status info       | `--ui-status-info-bg`, `--ui-status-info-border`, `--ui-status-info-text`            | Informational notices and badges                                      | `<x-ui.badge tone="info">Queued</x-ui.badge>`                                           |
| Inline alert      | `ui-inline-alert`                                                                    | Inline notification/validation-like messages                          | `<div class="ui-inline-alert">...</div>`                                                |
| Badge/status      | `x-ui.badge`, `x-ui.status`                                                          | Semantic and neutral compact labels                                   | `<x-ui.status tone="success">Synced</x-ui.status>`                                      |
| Card surface      | `ui-card`, `ui-shell-card`                                                           | Token-backed card/shell surfaces                                      | `<section class="ui-card">...</section>`                                                |
| Card text         | `ui-card-title`, `ui-card-copy`                                                      | Token-backed title/body copy roles                                    | `<p class="ui-card-copy">Supporting copy</p>`                                           |
| Code token colors | `--ui-code-token-*`                                                                  | Code snippet syntax roles                                             | `<pre class="ui-code-snippet"><code>...</code></pre>`                                   |
| Skeleton/loading  | `--ui-skeleton-*` queued alias / current loading utilities                           | `ui-spinner`, skeleton blocks, loading components                     | `<span class="ui-spinner"></span>`                                                      |
| Overlay           | `--ui-overlay`, shadow/elevation aliases when installed                              | Modal backdrop, drawer scrim, popover elevation                       | Pattern-owned overlays only.                                                            |

Action tertiary must stay mapped to the primary-color Button tertiary role, not neutral outline. In light and Gray 10 themes, tertiary uses primary border/text by default and primary filled hover/active states with inverse text. In Gray 90/100 themes, tertiary uses white border/text by default and white filled hover/active states with primary-colored text.

Only use Token API rows as installed standards where the variable, helper, class, or component exists in the application. If a token is listed as an alias or queued role and is not yet present in the compiled token map, do not use it in feature code until the token is added and proven on the UI Reference route.

### 4.1. Token status rules

| Status          | Meaning                                                 | Feature-use rule                                            |
| --------------- | ------------------------------------------------------- | ----------------------------------------------------------- |
| Implemented     | Variable/class/helper exists and is used by app UI.     | Approved for feature use.                                   |
| Alias           | Variable maps to another canonical role or legacy name. | Approved only if the alias is present in the app token map. |
| Queued          | Needed for standard completeness but not yet installed. | Do not use in feature code until implemented.               |
| Component-owned | Token belongs to a specific component API.              | Do not use outside that component.                          |
| Pattern-owned   | Token belongs to a pattern or layout API.               | Do not use outside that pattern.                            |

### 4.2. Carbon coverage and value mapping contract

Carbon is the completeness benchmark for Login App color role coverage. The app may use Carbon token names as source evidence, but production APIs must expose app-owned roles such as `--ui-text-primary`, `--ui-layer-01`, or `--ui-action-secondary-bg`.

For every Carbon color token or documented color role that Login App adopts, the owning Element, Component, or Pattern standard must record:

1. The Carbon token or documented role used as the coverage benchmark.
2. The Login App token, class, helper, or component prop that owns the same role.
3. Whether the Login App uses the same value family as Carbon or an intentional app value.
4. The reason for any value deviation.
5. The owner that must keep the mapping consistent everywhere the Carbon role would apply.

If Carbon role `A` maps to Login App value `B`, every adopted use of Carbon role `A` must map to the same app-owned role/value unless a different owner documents a separate semantic role. For example, if Carbon `$button-secondary` maps to `--ui-action-secondary-bg`, every secondary Button, combo-button secondary action, modal secondary action, and table-toolbar secondary action must consume that same app-owned secondary action role.

Do not create local equivalents such as `--ui-modal-secondary-bg`, `--ui-table-secondary-bg`, or `--ui-widget-secondary-bg` for the same Carbon role unless the owning Pattern standard records why the role is semantically different.

Mapping status values:

| Mapping status | Meaning | Implementation rule |
| -------------- | ------- | ------------------- |
| Same role / same value | Login App adopts the Carbon role and value family. | Use the app-owned token everywhere that role appears. |
| Same role / app value | Login App adopts the Carbon role but intentionally substitutes an app value. | Use one app-owned substitute consistently and record the reason. |
| App-specific role | Login App needs a role Carbon does not expose in the reviewed evidence. | Owner must define purpose, value source, and consumers. |
| Not adopted | Carbon role exists but Login App does not support the feature/state yet. | Do not implement locally; keep gated/deferred. |
| Needs verification | Carbon evidence is incomplete, anomalous, source-inferred, GitHub-only, or conflicting. | Do not hard-code as a standard until verified and promoted. |

### 4.3. Required mapping table shape

Every Color, Component, or Pattern standard that adopts Carbon color evidence must include or link to a mapping table with this shape:

| Carbon token / role | Carbon responsibility | Carbon value reference | Login App token / API | Login App value source | Mapping status | Deviation reason | Owner |
| ------------------- | --------------------- | ---------------------- | --------------------- | ---------------------- | -------------- | ---------------- | ----- |
| `$button-secondary`, `$button-secondary-hover`, `$button-secondary-active` | Secondary button container and states | Carbon Button style / theme token values: Gray 80 `#393939`, Gray 80 hover `#4c4c4c`, Gray 60 active `#6f6f6f` for light-theme secondary; lighter gray secondary family for dark-theme secondary | `--ui-action-secondary-bg`, `--ui-action-secondary-bg-hover`, `--ui-action-secondary-bg-active` via `<x-ui.button semantic="secondary">` and dependent Menu button triggers | Button action token map | Same role / same Carbon gray value family | Secondary is a filled gray action role, not a neutral outline/white button. Every adopted secondary Button/Menu button role must consume the same app-owned secondary action tokens. | Button Component |

The `Carbon value reference` column may cite a Carbon token name, style page, or the support inventory when the exact hex value is theme-dependent. The `Login App value source` column must name the app token family, theme token, or approved palette source. Raw hex values are allowed in the table only as documented values, not as feature-code instructions.

### 4.4. Baseline Carbon-to-Login role mapping

This baseline maps the core Carbon coverage model into Login App owner surfaces. It is not a complete component inventory; component standards must add their own row-level mappings for component-specific Carbon roles.

| Carbon family / role | Login App owner | Login App token/API family | Required alignment rule |
| -------------------- | --------------- | -------------------------- | ----------------------- |
| `$background`, `$background-hover`, `$background-active`, `$background-selected` | Color + Themes Elements | `--ui-background`, `--ui-surface`, selected/hover aliases where installed | Base backgrounds and state backgrounds must not be replaced by local page colors. |
| `$layer-01..03`, `$layer-hover-*`, `$layer-active-*`, `$layer-selected-*` | Color + Themes Elements | `--ui-layer-01..03`, layer state aliases | Cards, menus, tables, modals, popovers, and nested surfaces must consume layer roles consistently by depth/state. |
| `$field`, `$field-hover` | Color Element + field Components | `--ui-field`, `--ui-field-hover`, `--ui-field-disabled` | Text input, textarea, search, select, dropdown, date/time, and number controls must share field roles unless a component standard documents a variant. |
| `$text-primary`, `$text-secondary`, `$text-helper`, `$text-placeholder`, `$text-disabled`, `$text-inverse` | Color + Typography Elements | `--ui-text-*` | Text hierarchy must use app text roles, not component-local muted/gray classes. |
| `$icon-primary`, `$icon-secondary`, `$icon-disabled`, `$icon-inverse`, `$icon-on-color` | Color + Icons Elements | `--ui-icon-*` | Icons inherit role/state from the owning component and must not receive local raw colors. |
| `$border-subtle-*`, `$border-strong-*`, `$border-interactive`, `$border-disabled`, `$border-inverse` | Color Element | `--ui-border-*` | Borders, dividers, field bottoms, selected states, and inverse boundaries must use documented border roles. |
| `$link-primary`, `$link-primary-hover`, `$link-visited`, `$link-inverse` | Link Component + Color Element | `--ui-link*`, `ui-link` | Links must consume Link API roles; do not style anchors with arbitrary action colors. |
| `$focus`, `$focus-inset`, `$focus-inverse` | Color Element + all interactive Components | `--ui-focus*` | Focus must be visible and token-backed across surfaces; do not remove focus to match static visuals. |
| `$support-*`, `$support-*-inverse`, caution/support roles | Color Element + Notification/Status/Tag Components | `--ui-status-*`, validation/status APIs | Support colors are semantic only and require non-color cues. |
| `$button-*` | Button Component | `<x-ui.button semantic="...">`, `--ui-action-*` | Button variants must map to app action roles consistently across page headers, forms, modals, table toolbars, and empty states. |
| `$tag-*` component token families | Tag Component | Tag tone/variant API and app-owned tag tokens when installed | All-color tag rows remain verification-gated; do not infer local tag palettes. |
| `$content-switcher-*` | Content Switcher Component | Installed Content switcher component token aliases | Component-owned; do not express as generic tabs/buttons unless the Component standard maps it. |
| Data table toolbar and batch action roles | Data Table Component + Table Pattern | `x-ui.data-table-toolbar`, table/batch action tokens when installed | Toolbar rows stay component-owned; Table Pattern consumes them. |
| `$skeleton-element`, `$skeleton-background` | Color Element + Loading/Skeleton APIs | `--ui-skeleton-*` when installed; current loading utilities until then | Skeleton roles are global/loading-owned; do not fake skeletons with local gray blocks. |
| AI tokens such as `$ai-*` | AI-specific Component/Pattern gates | No general app-wide token until approved | AI token adoption remains gated and must not leak into non-AI components. |

Required role-family coverage:

| Role family | Carbon coverage benchmark | Login App role coverage required | Audit rule |
| ----------- | ------------------------- | -------------------------------- | ---------- |
| Text | `$text-primary`, `$text-secondary`, `$text-placeholder`, `$text-helper`, `$text-error`, `$text-on-color`, `$text-on-color-disabled`, `$text-disabled`, `$text-inverse` | `--ui-text-primary`, `--ui-text-secondary`, `--ui-text-placeholder`, `--ui-text-helper`, `--ui-text-error`, `--ui-text-on-color`, `--ui-text-disabled`, `--ui-text-inverse` or documented aliases | Every text role used in components must resolve to a Color-owned token or a documented Typography consumption role. |
| Icon | `$icon-primary`, `$icon-secondary`, `$icon-on-color`, `$icon-on-color-disabled`, `$icon-disabled`, `$icon-inverse`, `$icon-interactive` | `--ui-icon-primary`, `--ui-icon-secondary`, `--ui-icon-on-color`, `--ui-icon-disabled`, `--ui-icon-inverse`, `--ui-icon-interactive` or documented aliases | Icons must inherit `currentColor` from the owning role unless the Component standard owns a distinct icon state. |
| Link | `$link-primary`, `$link-primary-hover`, `$link-secondary`, `$link-visited`, `$link-inverse`, `$link-inverse-hover`, `$link-inverse-active`, `$link-inverse-visited` | `--ui-link`, `--ui-link-hover`, `--ui-link-secondary`, `--ui-link-visited`, `--ui-link-inverse` roles through Link Component classes | Link roles are consumed only by Link, Breadcrumb, Navigation, and Pattern-owned link composition. |
| Field | `$field`, `$field-hover` | `--ui-field`, `--ui-field-hover`, `--ui-field-disabled`, field validation aliases where installed | Form controls must share the field family across Text input, Select, Dropdown, Search, Date picker, Number input, and Textarea. |
| Border | `$border-subtle-*`, `$border-strong-*`, `$border-interactive`, `$border-inverse`, `$border-disabled`, `$border-tile` | `--ui-border-subtle`, `--ui-border-strong`, `--ui-border-interactive`, `--ui-border-inverse`, `--ui-border-disabled`, component-owned tile border aliases when installed | Component-local borders are prohibited unless the component standard documents a distinct Carbon benchmark. |
| Support/status | `$support-error`, `$support-success`, `$support-warning`, `$support-info`, `$support-caution-*`, inverse support roles, `$text-error` | `--ui-status-*`, `--ui-text-error`, validation/status component roles | Support roles are semantic and must pair with text, icons, or ARIA/state semantics; never use them as decoration. |
| Focus | `$focus`, `$focus-inset`, `$focus-inverse` | `--ui-focus`, `--ui-focus-inset`, `--ui-focus-inverse` or documented focus ring aliases | Every interactive Component standard must map focus and preserve reduced-motion-safe visible focus. |
| Skeleton | `$skeleton-background`, `$skeleton-element` | `--ui-skeleton-background`, `--ui-skeleton-element` when installed; Loading-owned fallback until installed | Skeleton roles are not generic gray surfaces; use only through Loading/Skeleton APIs. |
| Overlay | `$overlay` and AI-only `$ai-overlay` | `--ui-overlay` / overlay Pattern role; AI overlay remains gated | Modal, drawer, loading overlay, and popover backdrops must not create local scrim colors. |
| Layer state | `$layer-hover-*`, `$layer-active-*`, `$layer-selected-*`, `$layer-selected-hover-*`, `$layer-accent-*` | `--ui-layer-hover`, `--ui-layer-active`, `--ui-layer-selected`, `--ui-layer-selected-hover`, `--ui-layer-accent` or depth-specific aliases | Menus, dropdowns, tables, tabs, tree views, lists, and selectable surfaces must share layer state roles by depth. |

### 4.5. Implementation audit checklist

Use this checklist when comparing `resources/css/app.css`, component classes, and UI Reference examples against the canonical Carbon-to-Login mapping:

- Inventory every `--ui-*` color variable and classify it as global Color-owned, Component-owned, Pattern-owned, alias, queued, or obsolete.
- For each adopted Carbon token or role, verify exactly one app-owned token/API family owns the role unless a Component or Pattern standard documents a separate semantic reason.
- Confirm app value deviations are consistent. If Carbon role `A` maps to app value `B`, every adopted use of `A` must consume the same app role/value.
- Flag missing app roles for text, icon, link, field, border, support/status, focus, skeleton, overlay, and layer hover/active/selected states.
- Flag raw color utilities, raw hex/RGB/HSL values, Tailwind color clusters, and feature-local variables in Blade, CSS, and JS-rendered markup.
- Verify component-owned color variables are not consumed outside their owner component.
- Verify Pattern standards compose Component and Element roles instead of defining new color families for the same Carbon role.
- Verify UI Reference examples demonstrate default, hover/focus where practical, disabled, selected/current, validation/status, and inverse/high-contrast states for mapped roles.
- Record `Needs verification`, `Documented anomaly`, `Source-inferred`, and `Docs-source conflict` rows as blocked until promoted by the owning standard.

## 5. CSS variable API

Use only the CSS variables and token aliases listed in the Token API table or the linked token standards. Do not introduce feature-local CSS variables for this Element without updating this standard.

### 5.1. Installed and approved variable families

| Variable family     | Status                  | Owner                                  | Purpose                                                                  | Allowed usage                                                |
| ------------------- | ----------------------- | -------------------------------------- | ------------------------------------------------------------------------ | ------------------------------------------------------------ |
| `--ui-text-*`       | Implemented / expanding | Color Element                          | Text hierarchy, helper text, inverse text, disabled text, semantic text. | Any text role through approved classes or component APIs.    |
| `--ui-icon-*`       | Implemented / expanding | Color + Icons Elements                 | Icon color roles.                                                        | Icons through approved icon helpers/components.              |
| `--ui-surface*`     | Implemented / expanding | Color + Themes Elements                | Base and elevated surfaces.                                              | App shell, cards, panels, overlays, theme examples.          |
| `--ui-layer-*`      | Implemented             | Color + Themes Elements                | Layered UI surfaces.                                                     | Cards, nested examples, menus, panels, dialogs.              |
| `--ui-field-*`      | Implemented / queued    | Color + form components                | Field backgrounds and field states.                                      | Form components only.                                        |
| `--ui-border-*`     | Implemented / expanding | Color Element                          | Dividers, borders, rules, and key lines.                                 | Cards, fields, tables, panels, menus, overlays.              |
| `--ui-link*`        | Implemented / queued    | Color + Link Component                 | Link text and link states.                                               | `ui-link` and link-owned APIs only.                          |
| `--ui-action-*`     | Implemented / queued    | Button/Menu button Components          | Action colors and action states.                                         | Button, icon-button, menu-button APIs only.                  |
| `--ui-status-*`     | Implemented / queued    | Color + Notification/Tag/Badge APIs    | Semantic feedback colors.                                                | Notification, badge, status, validation, progress summaries. |
| `--ui-focus*`       | Implemented / queued    | Color Element                          | Keyboard focus indication.                                               | All interactive elements.                                    |
| `--ui-skeleton-*`   | Queued / loading-owned  | Loading/Skeleton Components            | Skeleton placeholders.                                                   | Loading and skeleton APIs only.                              |
| `--ui-code-token-*` | Implemented             | Code Snippet Component / Color Element | Syntax highlighting roles.                                               | Code snippet rendering only.                                 |
| `--ui-overlay*`     | Queued / Pattern-owned  | Overlay Pattern API                    | Scrim and backdrop behavior.                                             | Modal, drawer, and overlay patterns only.                    |

Rules:

- Do not create feature-local variables such as `--reports-danger`, `--settings-blue`, `--admin-card-bg`, or `--custom-focus-color`.
- Do not use raw hex, RGB, HSL, named colors, or Tailwind arbitrary color values in Blade views or feature-specific markup.
- Do not reference Carbon token names directly in app templates unless the app token map explicitly exposes them as aliases.
- Do not use component-owned variables outside their owning component.
- If two features need the same color role, promote the role into this Color standard or the owning Component/Pattern API.

### 5.2. Required fallback behavior

When a queued token is not yet installed, use the approved component API or existing class that owns the role. Do not substitute a visually similar raw value.

Example:

```blade
{{-- Correct: component API owns action colors --}}
<x-ui.button semantic="primary">Save</x-ui.button>

{{-- Incorrect: feature view bypasses the Color API --}}
<button class="bg-blue-600 text-white hover:bg-blue-700">Save</button>
```

## 6. Utility class/helper API

Allowed utility classes, Blade helpers, and component wrappers are those listed in the Token API table and demonstrated by the UI Reference route.

### 6.1. Allowed classes and helpers

| API                  | Status                    | Color role owned                       | Allowed use                                             |
| -------------------- | ------------------------- | -------------------------------------- | ------------------------------------------------------- |
| `ui-card`            | Implemented               | Surface, border, text context          | Standard card or page section surface.                  |
| `ui-shell-card`      | Implemented where present | Shell surface and border roles         | Shell-adjacent cards and app dashboard regions.         |
| `ui-card-title`      | Implemented               | Primary/strong title text              | Card and section titles.                                |
| `ui-card-copy`       | Implemented               | Secondary supporting copy              | Descriptions and supporting paragraphs.                 |
| `ui-kicker`          | Implemented               | Helper/metadata text                   | Small section labels and metadata.                      |
| `ui-link`            | Implemented               | Link color and link states             | Navigation and documentation links.                     |
| `ui-inline-alert`    | Implemented where present | Semantic message surface               | Inline feedback or page-local status.                   |
| `ui-spinner`         | Implemented               | Loading indicator color                | Local pending work through Loading/Inline Loading APIs. |
| `ui-code-snippet`    | Implemented               | Code surface and syntax tokens         | Code examples only.                                     |
| `<x-ui.button>`      | Implemented               | Action variants and states             | Button actions.                                         |
| `<x-ui.icon-button>` | Implemented where present | Icon-only action color and focus roles | Icon-only actions with accessible labels.               |
| `<x-ui.badge>`       | Implemented where present | Compact semantic/neutral status        | Badges and small statuses.                              |
| `<x-ui.status>`      | Implemented where present | Text/status indicator pair             | Status summaries and metadata.                          |

### 6.2. Allowed Tailwind usage

Tailwind classes may be used for layout, sizing, spacing, typography structure, and responsive behavior when they do not bypass the Color API.

Allowed:

```blade
<section class="grid gap-4 xl:grid-cols-2">
    <article class="ui-card">...</article>
</section>
```

Not allowed:

```blade
<section class="bg-slate-50 text-slate-900 border-slate-200">
    ...
</section>
```

Use Tailwind color utilities only when a component or pattern standard explicitly allows the utility as part of the installed API. Otherwise use CSS variables, component props, or approved app classes.

## 7. Allowed usage

- Use when: choosing a role-based color for content, surfaces, states, feedback, or interaction.
- Avoid when: selecting a raw hex value or using support color as decoration.
- Common app examples: buttons, links, alerts, fields, selected table rows, status tags, icon buttons, and inverse tooltips.

### 7.1. Use when

Use the Color Element API when any of the following is true:

- Text needs a hierarchy role such as primary, secondary, helper, muted, disabled, inverse, or semantic.
- A card, panel, table, menu, modal, popover, or shell region needs a surface or layer role.
- A form field needs a background, border, placeholder, helper, validation, or disabled treatment.
- A control needs hover, active, selected, pressed, disabled, loading, or focus-visible treatment.
- A status, notification, badge, or validation message needs semantic meaning.
- A page or component needs to work in light, dark, inline, inverse, or high-contrast contexts.
- A component must align with app-wide action, link, icon, status, or focus behavior.

### 7.2. Avoid when

Do not use the Color Element API to:

- Add decoration unrelated to a semantic or structural role.
- Create a new feature-local tone.
- Make arbitrary visual emphasis.
- Replace spacing, typography, border radius, icon shape, or motion decisions.
- Override component colors from the outside.
- Use support colors without explicit status meaning.
- Use hover/active colors as static colors.

### 7.3. App-specific selection guidance

| Need                   | Use                                                                        |
| ---------------------- | -------------------------------------------------------------------------- |
| Primary action         | `<x-ui.button semantic="primary">` or the Button API.                      |
| Destructive action     | Approved danger Button variant.                                            |
| Navigation text        | `ui-link` or Link Component API.                                           |
| Status badge           | `<x-ui.badge tone="success / warning / danger / info / neutral">`.         |
| Inline error           | Field/Notification API with danger/error tone.                             |
| Page surface           | `ui-card`, app shell wrapper, or Pattern-owned surface.                    |
| Nested content surface | `--ui-layer-02` through approved card/panel/reference classes.             |
| Keyboard focus         | Approved focus-visible class or component focus style using `--ui-focus*`. |
| Disabled control       | Owning Component API disabled state.                                       |
| Loading placeholder    | Loading/Skeleton API, not local gray blocks.                               |
| Inverse help surface   | Tooltip/Toggletip/Popover or Pattern-owned inverse surface.                |

## 8. Component and pattern consumers

Components and Patterns must consume this Element through documented tokens, utilities, or wrappers. They must not hard-code alternate local values for the same role.

| Consumer                          | Must consume Color by                                            | Must not do                                                             |
| --------------------------------- | ---------------------------------------------------------------- | ----------------------------------------------------------------------- |
| Button Component                  | Semantic action props and button-owned tokens.                   | Use raw blue, gray, red, or Tailwind color classes for button variants. |
| Link Component                    | `ui-link` or Link API states.                                    | Style ordinary anchors with arbitrary color values.                     |
| Notification Component            | Semantic status tones and non-color labels/icons.                | Use color-only alerts without status text.                              |
| Tag/Badge Component               | Neutral or semantic tone props.                                  | Use semantic colors as decorative category labels.                      |
| Form Pattern and field components | Field, border, helper, validation, and disabled roles.           | Put validation colors directly into feature views.                      |
| Data Table Component/Pattern      | Layer, border, selected, hover, focus, and status tokens.        | Use table-specific arbitrary row colors.                                |
| Modal/Overlay Pattern             | Overlay, surface, shadow, border, inverse/focus roles.           | Define custom backdrops or modal surfaces per feature.                  |
| App Shell Pattern                 | Shell background, inverse, link/action, border, and focus roles. | Locally tune header/nav colors in feature views.                        |
| Code Snippet Component            | Code token roles.                                                | Color syntax with arbitrary classes inside content pages.               |
| Loading/Skeleton Components       | Skeleton/loading token roles.                                    | Use local gray divs to fake loading skeletons.                          |

### 8.1. Component-owned color rule

Component APIs may expose semantic props such as:

```blade
<x-ui.button semantic="primary">Save</x-ui.button>
<x-ui.badge tone="success">Active</x-ui.badge>
<x-ui.notification tone="danger">Unable to save changes.</x-ui.notification>
```

Feature views must not directly map those props to raw values. The component owns that mapping.

## 9. Theme behavior

This Element must remain valid in supported light, dark, inline, inverse, and high-contrast contexts when those contexts apply. Theme behavior is proven on the UI Reference page.

### 9.1. Supported theme contexts

| Theme context | Status                                         | Requirement                                                                               |
| ------------- | ---------------------------------------------- | ----------------------------------------------------------------------------------------- |
| Light/default | Implemented                                    | All core UI must render readable text, borders, surfaces, actions, and states.            |
| Dark          | Implemented or app-gated by Theme API          | Token roles must preserve readability and state recognition.                              |
| Inline theme  | Pattern-owned                                  | Components inside a differently themed region must consume role tokens, not fixed values. |
| Inverse       | Implemented where components require it        | Tooltip, shell, and high-contrast moments use inverse roles.                              |
| High contrast | Supported by token contract / browser settings | UI must avoid color-only meaning and preserve visible focus.                              |

### 9.2. Theme-safe rules

- Token names describe roles; theme values may change.
- Components must not assume a token's visual value.
- Do not use light-only or dark-only raw values in component markup.
- Do not create a local dark-mode override for a feature unless the Theme API owns it.
- Inverse components must use inverse roles for text, border, icon, and focus.
- Semantic colors must remain semantic in every supported theme.

### 9.3. Inline and inverse contexts

Use inline/inverse treatment only when the owning Component or Pattern documents it.

Allowed examples:

- Dark shell header inside a light page.
- Inverse tooltip or toggletip surface.
- Modal or popover elevation above the current layer.
- High-contrast notice or action band documented by a Pattern API.

Not allowed:

- Feature-local dark cards.
- Arbitrary black/white text swaps.
- Creating a visually inverted region without documenting focus, contrast, and nested component behavior.

## 10. State behavior

Interactive states such as hover, active, selected, focus-visible, disabled, loading, and validation must use documented Element roles where applicable.

| State              | Color API requirement                                                             | Owner                                  |
| ------------------ | --------------------------------------------------------------------------------- | -------------------------------------- |
| Default            | Use the enabled role for the component or content type.                           | Component/Pattern API consuming Color. |
| Hover              | Use hover-specific roles only on hoverable interactive elements.                  | Component API.                         |
| Active/pressed     | Use active/pressed roles only during activation.                                  | Component API.                         |
| Selected/current   | Use selected/current roles and a non-color indicator when needed.                 | Component or Pattern API.              |
| Focus-visible      | Use a visible token-backed focus ring on every interactive element.               | Color Element + Component API.         |
| Disabled           | Use disabled text/icon/border/background roles; preserve readability.             | Component API.                         |
| Loading            | Use loading/skeleton roles and reduced-motion-safe treatment.                     | Loading/Inline Loading APIs.           |
| Validation error   | Use danger/error roles plus visible text and accessible association.              | Field/Notification APIs.               |
| Validation warning | Use warning roles plus visible text and accessible association.                   | Field/Notification APIs.               |
| Success            | Use success roles plus status text or icon.                                       | Notification/Badge/Status APIs.        |
| Information        | Use info roles plus status text.                                                  | Notification/Badge/Status APIs.        |
| Empty              | Use neutral surface/text/icon roles; do not imply error unless there is an error. | Component or Pattern API.              |

### 10.1. State-token rules

- Hover colors must not be used as static enabled colors.
- Active colors must not be used to fake selected state.
- Disabled colors must not be used for ordinary secondary text.
- Semantic colors must not be used without semantic state.
- Focus rings must not be removed to satisfy visual preference.
- Selected/current state should include label, icon, checkmark, border, or structure when color alone is not enough.

## 11. Accessibility contract

Color implementation must satisfy these requirements:

- Do not rely on color alone to communicate state, validation, selection, or status.
- Preserve readable contrast for text and meaningful icons in every supported theme.
- Preserve visible focus on every interactive element.
- Keep focus treatment visually distinct from hover, active, selected, and disabled states.
- Ensure disabled treatment is visually clear without making adjacent enabled content ambiguous.
- Ensure semantic status uses text, label, icon, or structure in addition to color.
- Ensure validation states are programmatically associated with the affected field where applicable.
- Ensure loading/skeleton states do not hide persistent labels, landmarks, or critical controls without status messaging.
- Respect forced-colors and high-contrast settings where browser and component support applies.

### 11.1. Minimum app checks

| Check                       | Requirement                                                                               |
| --------------------------- | ----------------------------------------------------------------------------------------- |
| Text contrast               | Body, label, helper, link, and validation text remain readable on all supported surfaces. |
| Icon contrast               | Meaningful icons remain distinguishable from their background.                            |
| Focus visibility            | Focus ring is visible against page, layer, field, inverse, and overlay surfaces.          |
| Semantic non-color cue      | Status is not communicated by color alone.                                                |
| Theme parity                | Light/dark/inverse examples show equivalent roles, not duplicated raw values.             |
| Reduced motion relationship | Loading color states do not require motion to understand status.                          |

## 12. Prohibited usage

- Do not bypass this Element API with one-off raw values, local utility clusters, or custom design tokens.
- Use role-based tokens, not raw hex values.
- Blue is reserved for primary actions and links.
- Support colors are reserved for semantic meaning: error, warning, success, info, and destructive intent.
- State tokens are not static decoration; hover, active, selected, focus, and disabled states must remain state-specific.

Additional prohibitions:

- Do not use Tailwind color utilities such as `bg-blue-*`, `text-red-*`, `border-slate-*`, or arbitrary color syntax in feature views unless the owning API explicitly allows it.
- Do not set inline styles with raw color values.
- Do not create feature-local CSS variables for color roles.
- Do not use semantic status tones for branding, category, or decorative emphasis.
- Do not override component colors from parent views to create unofficial variants.
- Do not use disabled color treatment to mean secondary or low priority.
- Do not use low-contrast muted text for required instructions, validation, or primary actions.
- Do not put component-specific tokens in shared feature markup.
- Do not mix layer tokens from different levels inside one component unless the owning Component API documents the composition.
- Do not treat Carbon token names as app APIs unless they are explicitly exposed by the Login App token map.

## 13. Deferred or gated capabilities

- No additional capability is approved without updating this Element standard and UI Reference proof.

| Capability                                   | Status                       | Gate                                                                       |
| -------------------------------------------- | ---------------------------- | -------------------------------------------------------------------------- |
| Full Carbon coverage/value alignment         | In progress                  | Requires component and pattern standards to add Carbon-to-Login mapping tables, app value sources, deviation reasons, and UI Reference proof. |
| Full theme switcher                          | Gated by Theme API           | Requires supported theme list, token coverage, and component test matrix.  |
| Forced-colors/high-contrast custom overrides | Gated                        | Requires accessibility audit and browser support expectations.             |
| Data visualization palette                   | Deferred                     | Requires chart/data-viz Pattern API and contrast/legend rules.             |
| Brand/accent palette expansion               | Deferred                     | Requires product/design approval and semantic role definition.             |
| Component-specific token export              | Component-owned              | Each component must document Carbon coverage, app token/API mapping, value source, and deviation reason before feature use. |
| Skeleton token family                        | Loading-owned / queued       | Requires Loading/Skeleton Component API and rendered examples.             |
| Shadow/elevation token family                | Overlay/Theme-owned / queued | Requires overlay, modal, popover, and shell behavior docs.                 |

Deferred or gated capabilities must not be approximated with raw colors or one-off variables.

## 14. Implementation and UI Reference Checklist

### 14.1. Implementation checklist

| Requirement                 | Standard expectation                                                                                                              |
| --------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source           | The standard names the approved token families, CSS variables, utility classes, helpers, source files, or explicit deferred gate. |
| Token/class/helper coverage | The durable Element API surface is listed for Component and Pattern consumers.                                                    |
| Theme/state behavior        | Theme, state, reduced-motion, accessibility, or interaction rules owned by the Element are defined.                               |
| Consumers                   | Component and Pattern consumers are named where they rely on this Element.                                                        |
| Prohibited usage            | Feature code, Components, and Patterns are told what they must not redefine locally.                                              |
| Tests                       | Route/content/API assertions are defined to prove the Element contract.                                                           |

### 14.2. UI Reference proof checklist

| Requirement          | Visual proof expectation                                                                                            |
| -------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Live examples        | The page renders examples with app CSS/JS, not screenshots only.                                                    |
| Token/API references | Token, class, helper, or API names appear with example usage.                                                       |
| Theme/state examples | Relevant theme contexts, variants, states, or gated disposition surfaces are visible.                               |
| Accessibility proof  | Contrast, focus, semantics, hit targets, reduced motion, or equivalent Element constraints are shown or documented. |
| Related APIs         | Consuming Components, Patterns, source files, and the canonical standard are linked.                                |
| Manual review        | The page provides enough rendered proof for visual review without opening source code first.                        |
## 15. UI Reference requirements

The Color UI Reference page must prove the installed Color API with live app-rendered examples. Screenshots are not sufficient.

Required sections and examples:

- theme-aware swatches
- token groups
- layering model
- background layering route
- interaction states
- semantic support colors
- contrast moments
- common app examples

### 15.1. Required live examples

| Requirement               | Must render                                                                                                                            | Must include                                                                        |
| ------------------------- | -------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------- |
| Theme-aware swatches      | Token swatches rendered from app CSS variables.                                                                                        | Light/default, dark if supported, inverse/high-contrast examples where implemented. |
| Token groups              | Visual rows for text, icon, surface/layer, field, border, link, action, status, focus, loading/skeleton roles.                         | Token name, value source, allowed consumer, and status.                             |
| Layering model            | Nested page/card/panel/example surfaces on `/platform/ui-reference/elements/color` and the dedicated `/platform/ui-reference/elements/color/layering` route. | `--ui-layer-01`, `--ui-layer-02`, elevated surface, border roles, readable text.    |
| Background layering route | Cards, cards with headers/footers, nested examples, code/documentation containers, and form/container examples.                         | `--ui-background`, `--ui-layer-01`, `--ui-layer-02`, `--ui-layer-accent-01`, and border roles. |
| Interaction states        | Component examples in default, hover preview, active/pressed, selected, focus-visible, disabled, loading, validation where applicable. | State-specific token labels and notes that state tokens are not static colors.      |
| Semantic support colors   | Success, warning, danger/error, info, neutral.                                                                                         | Badge/status/notification examples with text or icons, not color alone.             |
| Contrast moments          | Text, icon, focus, border, inverse, and disabled examples.                                                                             | Pass/fail notes or implementation warnings where applicable.                        |
| Common app examples       | Button, link, notification, field, table selected row, status tag, icon button, inverse tooltip/toggletip.                             | Production classes/components instead of screenshots.                               |
| Prohibited usage examples | Small side-by-side “do not” examples.                                                                                                  | Raw hex, decorative status colors, hover-as-static, color-only status.              |

### 15.2. Required implementation status display

The page must show:

- Guide status.
- System maturity.
- Element slug.
- Canonical doc route.
- Primary consumers.
- Deferred/gated capabilities.
- Token status legend: implemented, alias, queued, component-owned, pattern-owned.

### 15.3. Required developer-facing text on UI Reference page

The UI Reference page should include this text or equivalent:

> Use role-based Color tokens, classes, and component props instead of raw values. The token role stays stable even when theme values change.

> Semantic colors are reserved for semantic meaning. Do not use success, warning, danger, or information colors as decoration.

> Focus-visible states are required for interactive elements and must remain visible in every supported theme.

> Component APIs own their own color mappings. Feature views should call the component API instead of styling local variants.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/elements/color` returns 200 for authorized users.
- The page renders live examples with app CSS/JS rather than screenshots only.
- The page shows token/class/helper API references, allowed usage, prohibited usage, accessibility constraints, and implementation status.
- Theme-aware swatches render from actual CSS variables rather than hard-coded sample blocks.
- Token groups include text, icon, surface/layer, field, border, link, action, status, focus, and loading/skeleton roles.
- Layering examples show at least base/page, Layer 01, and Layer 02 surfaces.
- Interaction examples show default, hover, active/pressed, selected/current where applicable, focus-visible, disabled, loading, and validation states.
- Semantic examples show success, warning, danger/error, information, and neutral states with non-color cues.
- Common app examples include button, link, notification/alert, form field, selected table row or selected item, status tag/badge, icon button, and inverse tooltip/toggletip where implemented.
- Prohibited examples or notes explicitly warn against raw hex values, Tailwind color utilities in feature views, decorative support colors, hover tokens as static colors, and color-only status.
- The page links to related Component and Pattern APIs that consume Color.
- Tests assert that generic fallback content is absent and that all required sections render.

### 16.1. Suggested automated assertions

- Assert the authorized route returns `200`.
- Assert the page contains `data-ui-reference-element="color"` or equivalent element ownership marker.
- Assert the page contains token names from each required token family.
- Assert each required live-example group is present.
- Assert semantic labels `success`, `warning`, `danger`, `information`, and `neutral` are visible.
- Assert focus guidance is visible.
- Assert raw-color examples appear only inside prohibited-usage documentation, not in implementation examples.
- Assert developer examples use canonical classes/components such as `ui-card`, `ui-link`, `<x-ui.button>`, and `<x-ui.badge>` where available.

## 17. Related APIs

| API                     | Route                                                         |
| ----------------------- | ------------------------------------------------------------- |
| Themes element          | `/platform/ui-reference/elements/themes`                      |
| Typography element      | `/platform/ui-reference/elements/typography`                  |
| Icons element           | `/platform/ui-reference/elements/icons`                       |
| Motion element          | `/platform/ui-reference/elements/motion`                      |
| Spacing element         | `/platform/ui-reference/elements/spacing`                     |
| Button component        | `/platform/ui-reference/components/button`                    |
| Link component          | `/platform/ui-reference/components/link`                      |
| Notification component  | `/platform/ui-reference/components/notification`              |
| Tag/Badge component     | `/platform/ui-reference/components/tag`                       |
| Text input component    | `/platform/ui-reference/components/text-input`                |
| Data table component    | `/platform/ui-reference/components/data-table`                |
| Form patterns           | `/platform/ui-reference/patterns/forms`                       |
| Overlay/action patterns | `/platform/ui-reference/patterns/overlays-feedback`           |
| Canonical color doc     | `/platform/docs?path=02-standards%2Fui%2Felements%2Fcolor.md` |
| Carbon color overview   | `https://carbondesignsystem.com/elements/color/overview/`     |
| Carbon color usage      | `https://carbondesignsystem.com/elements/color/usage/`        |
| Carbon token inventory  | `docs/09-reference/ui/Carbon Color Token Master Inventory.md` |

## 18. References

- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon color tokens inform the role-driven architecture. Login App keeps its own semantic CSS variables and values.
- Carbon's default themes, core token groups, layering model, and interaction-state concepts are used as a completeness benchmark, not copied as a one-to-one token implementation.
- The Carbon token master inventory is support evidence. Canonical standards must promote only the adopted role, app-owned token/API, value source, mapping status, and deviation reason needed for implementation.

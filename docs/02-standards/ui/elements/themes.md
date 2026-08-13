---
title: Themes
slug: themes
api_layer: Foundation Element API
guide_status: implemented
system_maturity: partial
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/elements/themes.md
carbon_reference:
  - https://carbondesignsystem.com/elements/themes/overview/
related_elements:
  - color
  - spacing
  - typography
  - motion
  - icons
related_components:
  - button
  - notification
  - text-input
  - data-table
  - modal
  - ui-shell
related_patterns:
  - layout
  - navigation
  - overlays-and-actions
  - forms
  - data-and-content
---

# Themes Element API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Theme resolution model](#31-theme-resolution-model)
  - [3.2. Supported theme contexts](#32-supported-theme-contexts)
  - [3.3. Token role rule](#33-token-role-rule)
  - [3.4. Layer inheritance model](#34-layer-inheritance-model)
  - [3.5. Override model](#35-override-model)
- [4. Token API](#4-token-api)
  - [4.1. Token status rules](#41-token-status-rules)
- [5. CSS variable API](#5-css-variable-api)
  - [5.1. Approved variable locations](#51-approved-variable-locations)
  - [5.2. Variable family rules](#52-variable-family-rules)
- [6. Utility class/helper API](#6-utility-classhelper-api)
  - [6.1. Approved helpers and selectors](#61-approved-helpers-and-selectors)
  - [6.2. Utility class boundary](#62-utility-class-boundary)
- [7. Allowed usage](#7-allowed-usage)
  - [7.1. Selection guidance](#71-selection-guidance)
- [8. Component and pattern consumers](#8-component-and-pattern-consumers)
  - [8.1. Consumer contract](#81-consumer-contract)
  - [8.2. Component examples](#82-component-examples)
  - [8.3. Pattern examples](#83-pattern-examples)
- [9. Theme behavior](#9-theme-behavior)
  - [9.1. Required behavior by context](#91-required-behavior-by-context)
  - [9.2. Theme inheritance rules](#92-theme-inheritance-rules)
- [10. State behavior](#10-state-behavior)
- [11. Accessibility contract](#11-accessibility-contract)
- [12. Content contract](#12-content-contract)
- [13. Prohibited usage](#13-prohibited-usage)
- [14. Deferred or gated capabilities](#14-deferred-or-gated-capabilities)
- [15. Implementation and Rendered Evidence Checklist](#15-implementation-and-ui-reference-checklist)
  - [15.1. Implementation checklist](#151-implementation-checklist)
  - [15.2. rendered evidence proof checklist](#152-ui-reference-proof-checklist)
- [16. Rendered evidence requirements](#16-ui-reference-requirements)
  - [16.1. Required live examples](#161-required-live-examples)
  - [16.2. Required page text](#162-required-page-text)
  - [16.3. Current rendered evidence page responsibility model](#163-current-ui-reference-page-responsibility-model)
- [17. Testing and acceptance criteria](#17-testing-and-acceptance-criteria)
  - [17.1. Suggested automated assertions](#171-suggested-automated-assertions)
- [18. Related APIs](#18-related-apis)
- [19. References](#19-references)

## 1. API summary

Themes change token values while preserving token roles across light, dark, inline, inverse, and high-contrast contexts.

Themes is a Foundation Element API. Component and Pattern APIs must consume it instead of redefining local values.

Themes is the installed token-resolution standard for Login App 2.0. It defines how theme context is applied, where theme variables are allowed to live, how components inherit theme roles, and how supported theme states are proven by the Rendered evidence route. It does not authorize feature-local color overrides, component-specific theme systems, or raw color patches in Blade views.

### 1.1. Canonical API responsibilities:

- Theme root resolution.
- Light and dark token inheritance.
- Surface, layer, text, border, icon, action, field, focus, status, and shadow values by theme.
- Inline and inverse context boundaries.
- High-contrast compatibility checks where the app exposes high-contrast contexts.
- Approved theme override documentation.
- Component and Pattern theme-readiness requirements.
- rendered evidence proof for theme behavior.

### 1.2. Non-owned responsibilities:

- Token role naming. Use the Color Element API for color roles.
- Layout geometry. Use the 2x Grid Element API.
- Local spacing and density. Use the Spacing Element API.
- Type roles. Use the Typography Element API.
- Motion and reduced-motion behavior. Use the Motion Element API.
- Component-specific variants. Use the owning Component API.

Use the Themes Element API whenever a surface, component, page shell, overlay, or nested context must remain readable and consistent across supported theme contexts.

## 2. Status and ownership

| Field              | Value                                                                                                     |
| ------------------ | --------------------------------------------------------------------------------------------------------- |
| Guide status       | Implemented                                                                                               |
| System maturity    | Partial                                                                                                   |
| API layer          | Foundation Element API                                                                                    |
| Element slug       | themes                                                                                                    |
| Rendered evidence route | `not installed`                                                                  |
| Canonical doc      | `docs/02-standards/ui/elements/themes.md`                                                                 |
| Primary consumers  | App shell, cards, fields, buttons, tables, notifications, overlays, docs pages, component reference pages |
| Carbon benchmark   | Carbon Themes overview                                                                                    |

`System maturity: Partial` means Login App 2.0 has installed light/dark token inheritance and visible theme-aware component usage, but some inline, inverse, high-contrast, or component-specific theme contexts may still require explicit proof before feature use.

## 3. Installed standard

Light and dark token inheritance for surfaces, text, borders, actions, and statuses.

Login App 2.0 uses Carbon's theme model as a benchmark: theme tokens keep stable roles while their values change by theme. Login App keeps its own theme names, values, CSS variables, and component APIs.

The installed standard is:

1. Token roles are stable across themes.
2. Theme contexts change token values, not component semantics.
3. Components consume resolved roles through CSS variables, approved utility classes, or Component APIs.
4. Feature views do not hard-code alternate color values for theme-specific styling.
5. Light and dark contexts must be supported wherever the app exposes them.
6. Inline, inverse, and high-contrast contexts are allowed only through documented wrappers or Pattern APIs.
7. Any custom theme override must document the reason, owner, source file, token role, old value, new value, and rendered evidence proof.
8. Components cannot be marked complete until their supported variants and states remain readable in approved theme contexts.

### 3.1. Theme resolution model

| Resolution layer        | Installed role                                                                              | Allowed owner                           | Notes                                                                        |
| ----------------------- | ------------------------------------------------------------------------------------------- | --------------------------------------- | ---------------------------------------------------------------------------- |
| Root defaults           | Base CSS variable values on `:root`                                                         | Themes Element API                      | Defines default fallback values for the app.                                 |
| Resolved document theme | `html[data-theme-resolved="light"]` and `html[data-theme-resolved="dark"]`                  | Theme resolver / app shell              | The document-level theme state.                                              |
| Inline theme context    | Scoped wrapper such as `[data-ui-theme="workspace"]` or `[data-ui-theme="gray-100"]` when installed | Pattern API or documented theme wrapper | Use only when a nested region intentionally differs from the page theme.     |
| Inverse context         | Scoped wrapper or component-owned inverse surface                                           | Pattern API or component owner          | Use for shell, tooltip, overlay, or high-contrast moments only.              |
| High-contrast context   | App-approved high-contrast wrapper or OS/browser compatibility layer                        | Themes + Accessibility owner            | Must preserve text, border, icon, focus, and semantic meaning.               |
| Component-local value   | Component-specific variable inside a Component API                                          | Component owner                         | Allowed only when documented by that component and backed by Element tokens. |

Do not introduce a new theme resolution mechanism in a feature view. Add it to this Element standard and prove it on the Rendered evidence route first.

### 3.2. Supported theme contexts

| Context            | Status                        | Required behavior                                                                   | Feature-use rule                                              |
| ------------------ | ----------------------------- | ----------------------------------------------------------------------------------- | ------------------------------------------------------------- |
| Light              | Implemented                   | Default page and surface tokens resolve to readable light-context values.           | Approved.                                                     |
| Dark               | Implemented / expanding       | Page, shell, overlay, and component tokens resolve to readable dark-context values. | Approved where the owning page or Pattern supports it.        |
| Inline light/dark  | Partial                       | Nested region may intentionally switch theme context while preserving token roles.  | Use only through documented wrappers or Pattern APIs.         |
| Inverse            | Partial / pattern-owned       | Inverse surfaces use inverse text, icon, border, and focus roles.                   | Use only where the owning component or Pattern documents it.  |
| High contrast      | Partial / accessibility-gated | Contrast, focus, borders, and semantic cues remain visible.                         | Requires explicit rendered evidence proof before claiming support. |
| Custom brand theme | Deferred                      | App-owned token map with documented role values and tests.                          | Not approved unless this standard is updated.                 |

### 3.3. Token role rule

A theme may change this:

```css
html[data-theme-resolved="dark"] {
  --ui-surface: ...;
  --ui-text-primary: ...;
}
```

A theme must not change this:

```text
--ui-text-primary means primary readable text.
--ui-action-primary-bg means primary action background.
--ui-status-danger-bg means destructive/error/status-danger background.
```

If a role name no longer describes its usage, fix the token contract instead of overriding a value locally.

### 3.4. Layer inheritance model

Theme contexts must preserve a readable layer hierarchy.

| Layer           | Theme responsibility                            | Allowed examples                                                   |
| --------------- | ----------------------------------------------- | ------------------------------------------------------------------ |
| Page background | Base app region color.                          | Main content region, docs page, dashboard background.              |
| Layer 01        | Primary component/card surface above the page.  | `ui-card`, table shell, field group, settings panel.               |
| Layer 02        | Nested surface above Layer 01.                  | Live-example panel, nested card, menu, popover, contained note.    |
| Layer 03        | Third nested surface.                           | Deep contained component regions.                                  |
| Layer 04        | Fourth nested surface.                          | Rare complex examples, overlays, or composed nested panels.        |
| Layer 05        | Fifth nested surface before reset.              | Maximum preset stack depth before a new sibling context begins.    |
| Overlay/scrim   | Obscures inactive page regions.                 | Modal, drawer, blocking overlay.                                   |
| Inverse surface | Intentional contrast surface.                   | Tooltip, dark shell region, inverse callout, high-contrast moment. |

A nested surface must use the next approved layer or an owning Pattern API. Light contexts alternate background and layer values through Layer 05. Dark contexts step one neutral shade lighter with each layer through Layer 05. Do not simulate depth by choosing arbitrary gray values.

### 3.5. Override model

Theme overrides are allowed only when they are documented standards, not local fixes.

Every approved override must include:

| Field              | Required value                                                           |
| ------------------ | ------------------------------------------------------------------------ |
| Token role         | The token being changed.                                                 |
| Theme context      | Light, dark, inline, inverse, high-contrast, or app-specific.            |
| Previous value     | Current value or inherited value.                                        |
| New value          | Proposed value.                                                          |
| Owner              | Person, team, or API owner.                                              |
| Reason             | Accessibility, readability, brand alignment, or component compatibility. |
| Source file        | CSS/config file that owns the override.                                  |
| rendered evidence proof | Route and section where the override is rendered.                        |
| Test coverage      | Visual, feature, or accessibility assertion.                             |

Feature-local fixes such as `style="color: #fff"` or `.reports-dark-card { background: #111; }` are not theme overrides. They are prohibited usage.

## 4. Token API

| Token/helper           | Variable or value                                                                              | Allowed API/consumer                                             | Example                                                               |
| ---------------------- | ---------------------------------------------------------------------------------------------- | ---------------------------------------------------------------- | --------------------------------------------------------------------- |
| Resolved theme root    | `:root`, `html[data-theme-resolved="light"]`, `html[data-theme-resolved="dark"]`               | Theme resolver on document element                               | `html[data-theme-resolved="light"] { --ui-surface: ... }`             |
| Theme root fallback    | `:root`                                                                                        | Global app CSS only                                              | Base token values before resolved theme applies.                      |
| Light resolved context | `html[data-theme-resolved="light"]`                                                            | App shell and global theme resolver                              | Primary light experience.                                             |
| Dark resolved context  | `html[data-theme-resolved="dark"]`                                                             | App shell and global theme resolver                              | Primary dark experience where enabled.                                |
| Workspace theme wrapper | `[data-ui-theme="workspace"]`                                                                    | App layout / Navigation Pattern                                  | Resolves the workspace canvas to Gray 10 in light mode and Gray 90 in dark mode. |
| Gray 100 shell wrapper  | `[data-ui-theme="gray-100"]`                                                                     | App layout / Navigation Pattern                                  | Keeps the global header, sidebar, and owned shell panels on the approved high-contrast shell context. |
| Inverse wrapper        | `[data-ui-theme="inverse"]` or component-owned inverse class when installed                    | Tooltip, shell, overlay, or high-contrast moment                 | Inverse text/icon/border/focus roles.                                 |
| Theme surfaces         | `--ui-surface`, `--ui-surface-elevated`                                                        | `ui-card`, shell cards, layout surfaces                          | `<section class="ui-card">...</section>`                              |
| Theme layers           | `--ui-layer-01`, `--ui-layer-02`, `--ui-layer-03`, `--ui-layer-04`, `--ui-layer-05`             | Cards, nested panels, menus, overlays                            | `<aside style="background-color: var(--ui-layer-02);">...</aside>`    |
| Theme text             | `--ui-text-primary`, `--ui-text-secondary`, `--ui-text-helper`, `--ui-text-inverse`            | Typography roles and component text                              | `<p class="ui-card-copy">Supporting copy</p>`                         |
| Theme icons            | `--ui-icon-primary`, `--ui-icon-secondary`, `--ui-icon-inverse`, semantic icon roles           | Icons Element and Component APIs                                 | Internal icon components using `currentColor` from resolved text/status/action role. |
| Theme borders          | `--ui-border-subtle-01`, `--ui-border-strong-01`, `--ui-border-inverse` when installed         | Cards, fields, dividers, tables, overlays                        | `<div style="border-color: var(--ui-border-subtle-01);">...</div>`    |
| Theme fields           | `--ui-field`, `--ui-field-hover`, `--ui-field-disabled` when installed                         | Text input, select, textarea, search, date picker                | `<input class="ui-field" />`                                          |
| Theme actions          | `--ui-action-*`                                                                                | `<x-ui.button>` semantic variants and approved action components | `<x-ui.button semantic="danger">Delete</x-ui.button>`                 |
| Theme statuses         | `--ui-status-success-*`, `--ui-status-warning-*`, `--ui-status-danger-*`, `--ui-status-info-*` | Notification, tag, status, validation, progress summaries        | `<x-ui.tag label="Active" tone="success" />`                          |
| Theme focus            | `--ui-focus-ring`, `--ui-focus`                                                                | Every interactive component                                      | Focus-visible rings and outlines.                                     |
| Theme overlay          | `--ui-overlay`, shadow/elevation aliases when installed                                        | Modal, drawer, popover, floating layers                          | Pattern-owned overlay treatment.                                      |
| Theme loading          | `--ui-skeleton-*`, spinner aliases when installed                                              | Loading and skeleton APIs                                        | `<span class="ui-spinner"></span>`                                    |
| Theme code             | `--ui-code-token-*`                                                                            | Code snippets and syntax roles                                   | `<pre class="ui-code-snippet"><code>...</code></pre>`                 |

Only use Token API rows as installed standards where the variable, helper, wrapper, class, or component exists in the application. If a token or wrapper is listed as partial, queued, or pattern-owned, do not use it in feature code until the owning API marks it implemented and the Rendered evidence route proves it.

### 4.1. Token status rules

| Status          | Meaning                                                              | Feature-use rule                                               |
| --------------- | -------------------------------------------------------------------- | -------------------------------------------------------------- |
| Implemented     | Token, wrapper, class, or resolver exists and is used by app UI.     | Approved for feature use through the documented API.           |
| Partial         | Exists in some contexts but not proven across the full theme matrix. | Use only where the owning API has documented support.          |
| Alias           | Maps to another canonical token role.                                | Approved only if the alias is present in the compiled app CSS. |
| Queued          | Needed for completeness but not installed.                           | Do not use in feature code.                                    |
| Component-owned | Defined inside a Component API.                                      | Do not use outside that component.                             |
| Pattern-owned   | Defined inside a Pattern API.                                        | Do not use outside that pattern.                               |
| Deferred        | Not approved.                                                        | Requires a new standards update and rendered evidence proof.        |

## 5. CSS variable API

Use only the CSS variables and token aliases listed in the Token API table or the linked token standards. Do not introduce feature-local CSS variables for this Element without updating this standard.

### 5.1. Approved variable locations

| Location                            | Status                  | Allowed content                                                   | Not allowed                                                             |
| ----------------------------------- | ----------------------- | ----------------------------------------------------------------- | ----------------------------------------------------------------------- |
| Global token file                   | Implemented             | Root defaults and resolved theme values.                          | Component-specific hacks or page-local variables.                       |
| `:root`                             | Implemented             | Safe fallback values.                                             | Theme-specific values that should live under a resolved theme selector. |
| `html[data-theme-resolved="light"]` | Implemented             | Light theme values.                                               | Feature-specific overrides.                                             |
| `html[data-theme-resolved="dark"]`  | Implemented / expanding | Dark theme values.                                                | Component fixes that bypass the component API.                          |
| Scoped theme wrapper                | Implemented / Pattern-owned | `workspace` and `gray-100` contexts emitted by the app layout; other inline/inverse values require approval. | New wrappers created inside feature views.                              |
| Component CSS namespace             | Component-owned         | Component-local variables backed by Element roles.                | New theme systems or raw colors.                                        |
| Pattern CSS namespace               | Pattern-owned           | Pattern composition variables backed by Element roles.            | Local theme overrides hidden in feature pages.                          |

### 5.2. Variable family rules

| Variable family     | Owner                                  | Theme responsibility                                         |
| ------------------- | -------------------------------------- | ------------------------------------------------------------ |
| `--ui-surface*`     | Themes + Color                         | Resolve page and elevated surfaces in each theme.            |
| `--ui-layer-*`      | Themes + Color                         | Preserve visible layer hierarchy.                            |
| `--ui-text-*`       | Themes + Color + Typography            | Preserve text hierarchy and contrast.                        |
| `--ui-icon-*`       | Themes + Color + Icons                 | Preserve icon visibility and semantic meaning.               |
| `--ui-border-*`     | Themes + Color                         | Preserve boundaries, key lines, dividers, and field borders. |
| `--ui-field-*`      | Themes + Color + Field Components      | Preserve field readability and state differentiation.        |
| `--ui-action-*`     | Button/Menu button owners + Themes     | Preserve action hierarchy and interactive states.            |
| `--ui-status-*`     | Notification/Tag/Status owners + Themes | Preserve semantic status meaning and contrast.               |
| `--ui-focus*`       | Themes + Color + Accessibility         | Preserve visible focus in every theme.                       |
| `--ui-overlay*`     | Overlay Pattern + Themes               | Preserve modal/drawer/popover backdrops and depth.           |
| `--ui-skeleton-*`   | Loading Component + Themes             | Preserve loading placeholders without low-contrast shimmer.  |
| `--ui-code-token-*` | Code Snippet Component + Themes        | Preserve syntax readability in docs/reference code.          |

Rules:

- Do not create feature-local variables such as `--reports-dark-bg`, `--settings-card-theme`, `--admin-inverse-text`, or `--custom-theme-focus`.
- Do not place raw values in Blade markup to fix one theme.
- Do not set component color directly when a role token exists.
- If a theme value fails contrast or readability, update the token role value at the appropriate owner and prove it on the rendered evidence page.
- If a component requires a component-local variable, document it in that Component API and map it to Element roles.

## 6. Utility class/helper API

Allowed utility classes, Blade helpers, and component wrappers are those listed in the Token API table and demonstrated by the Rendered evidence route.

### 6.1. Approved helpers and selectors

| Helper/selector                     | Status                           | Allowed usage                                                    |
| ----------------------------------- | -------------------------------- | ---------------------------------------------------------------- |
| `html[data-theme-resolved="light"]` | Implemented                      | Document-level resolved light theme.                             |
| `html[data-theme-resolved="dark"]`  | Implemented / expanding          | Document-level resolved dark theme.                              |
| `[data-ui-theme="workspace"]`       | Implemented / Pattern-owned      | Theme-responsive workspace canvas emitted by the app layout.     |
| `[data-ui-theme="gray-100"]`        | Implemented / Pattern-owned      | Fixed high-contrast shell context emitted by the app layout.     |
| `[data-ui-theme="light"]`           | Partial / gated                  | Scoped inline light context only if the wrapper is installed.    |
| `[data-ui-theme="dark"]`            | Partial / gated                  | Scoped inline dark context only if the wrapper is installed.     |
| `[data-ui-theme="inverse"]`         | Partial / gated                  | Inverse surface only through approved Component or Pattern APIs. |
| `ui-card`                           | Implemented                      | Theme-aware card surface.                                        |
| `ui-shell-card`                     | Implemented / shell-owned        | Theme-aware shell/panel card where installed.                    |
| `ui-page-header-title`              | Implemented                      | Theme-aware page title text.                                     |
| `ui-page-header-copy`               | Implemented                      | Theme-aware page supporting copy.                                |
| `ui-card-title`                     | Implemented                      | Theme-aware card heading.                                        |
| `ui-card-copy`                      | Implemented                      | Theme-aware card supporting copy.                                |
| `ui-link`                           | Implemented                      | Theme-aware link treatment.                                      |
| `ui-inline-notification`            | Implemented / notification-owned | Theme-aware inline feedback.                                     |
| `<x-ui.button>`                     | Implemented                      | Theme-aware button semantics.                                    |
| `<x-ui.tag>` / `<x-ui.status>`      | Implemented where installed      | Theme-aware status labels.                                       |
| `<x-ui.icon-button>`                | Implemented where installed      | Theme-aware icon-only action with accessible name.               |

### 6.2. Utility class boundary

Tailwind utilities may be used for layout, sizing, spacing, display, and responsive behavior where they do not override a theme role.

Allowed:

```html
<section class="grid gap-4 xl:grid-cols-2">
```

Conditionally allowed when token-backed by the owning component:

```html
<button class="focus-visible:ring-2">
```

Not allowed for theme roles:

```html
<section class="bg-slate-900 text-white border-slate-700">
```

If a Tailwind color utility is needed for a theme role, replace it with a token-backed class or update the Element API.

## 7. Allowed usage

- Use when: a whole surface or theme context must resolve through the active app theme.
- Avoid when: changing one component color directly instead of using token roles.
- Common app examples: light page with dark shell, dark modal panel, nested card, notification, form controls, docs code snippets, and high-contrast action moments.

### 7.1. Selection guidance

Use the Themes Element API when the question is:

- Does this component work in light and dark mode?
- Does this nested surface need a different context from its parent?
- Does this inverse surface have readable text, icons, borders, and focus rings?
- Does this state use a theme-safe value?
- Is this override allowed globally or is it a one-off patch?

Use the Color Element API when the question is:

- Which color role should this text, border, icon, action, or status use?

Use the owning Component or Pattern API when the question is:

- Which variant, prop, state, or composition owns this theme behavior?

## 8. Component and pattern consumers

Components and Patterns must consume this Element through documented tokens, utilities, or wrappers. They must not hard-code alternate local values for the same role.

### 8.1. Consumer contract

Every theme-aware Component or Pattern must document:

- Which theme contexts it supports.
- Which Element tokens it consumes.
- Which component-local variables, if any, it owns.
- Which states are theme-tested.
- Which contexts are deferred or not supported.
- Which rendered evidence example proves the behavior.

### 8.2. Component examples

| Consumer     | Required theme behavior                                                                                    |
| ------------ | ---------------------------------------------------------------------------------------------------------- |
| Button       | Primary, secondary, tertiary, ghost, and danger treatments remain readable across supported themes.        |
| Icon button  | Icon-only controls preserve accessible names, focus, disabled, and hover states.                           |
| Text input   | Field background, border, helper text, placeholder, disabled, error, and warning states remain distinct.   |
| Notification | Semantic tones retain meaning and contrast without relying on color alone.                                 |
| Data table   | Header, rows, selected rows, hover, focus, zebra/line divisions, and empty/loading states remain readable. |
| Modal        | Overlay, panel, title, body, footer, focus trap, and destructive actions remain readable.                  |
| UI shell     | Header, sidebar, account menu, nav states, and nested page surfaces remain coordinated.                    |

### 8.3. Pattern examples

| Pattern               | Required theme behavior                                                                                      |
| --------------------- | ------------------------------------------------------------------------------------------------------------ |
| App shell             | Owns document-level theme context and the installed `gray-100` shell plus `workspace` content contexts.      |
| Forms                 | Ensures label, helper, validation, required, disabled, and read-only states work in each supported context.  |
| Overlays and feedback | Owns scrim, modal/drawer/popover depth, notification stack, focus return, and inverse/high-contrast moments. |
| Documentation pages   | Ensures code snippets, reference cards, tables, and live examples remain readable.                           |

If a Component or Pattern cannot meet this contract, mark the unsupported context as `Deferred`, `Not implemented`, or `App-approved exception` in that API doc.

## 9. Theme behavior

This Element must remain valid in supported light, dark, inline, inverse, and high-contrast contexts when those contexts apply. Theme behavior is proven on the rendered evidence page.

### 9.1. Required behavior by context

| Context           | Required proof                                                                                           |
| ----------------- | -------------------------------------------------------------------------------------------------------- |
| Light             | Page, cards, buttons, fields, text, links, statuses, focus, and code snippets use readable light values. |
| Dark              | Same examples remain readable with dark values and no local color patches.                               |
| Inline light/dark | Nested context shows inherited roles changing by wrapper, not by component rewrite.                      |
| Inverse           | Text, icons, borders, and focus rings remain readable on inverse surface.                                |
| High contrast     | Text, focus, borders, icons, and semantic states remain identifiable where support is claimed.           |

### 9.2. Theme inheritance rules

- Components inherit the nearest approved theme context.
- Components do not decide the document theme.
- App shell or Pattern APIs own broad theme context placement.
- Component APIs own only component-local state and variant styling.
- Element tokens remain the source of truth for role values.
- Nested contexts must use approved wrappers, not local utility clusters.

## 10. State behavior

Interactive states such as hover, active, selected, focus-visible, disabled, loading, and validation must use documented Element roles where applicable.

| State            | Theme requirement                                                                               |
| ---------------- | ----------------------------------------------------------------------------------------------- |
| Default          | Uses the normal role value for the active theme.                                                |
| Hover            | Uses a state-specific role or component-owned hover value.                                      |
| Active/pressed   | Uses a state-specific role that remains visible in the active theme.                            |
| Selected/current | Uses selected/current roles or component-owned selected styles with non-color cues when needed. |
| Focus-visible    | Uses a visible focus role with sufficient contrast against the current surface.                 |
| Disabled         | Uses disabled roles without reducing contrast below usability expectations for required text.   |
| Loading          | Skeleton/spinner values remain visible without creating decorative distraction.                 |
| Error            | Uses error/danger roles with text or icon cues.                                                 |
| Warning          | Uses warning roles with text or icon cues.                                                      |
| Success          | Uses success roles with text or icon cues.                                                      |
| Informational    | Uses information roles with text or icon cues.                                                  |

Do not reuse hover, selected, or disabled state values as static decorative colors.

## 11. Accessibility contract

Themes must preserve accessibility across supported contexts.

Requirements:

- Body text, labels, helper text, and headings must remain readable in every supported theme.
- Interactive focus must remain visibly distinguishable in every supported theme.
- Links must remain distinguishable from surrounding text by more than color where required by context.
- Error, warning, success, and informational states must not rely on color alone.
- Disabled and read-only states must remain understandable without becoming invisible.
- Inverse and high-contrast contexts must preserve text, icon, border, and focus visibility.
- Reduced-motion behavior remains owned by the Motion Element API, but theme changes must not introduce motion that bypasses reduced-motion rules.

## 12. Content contract

Theme documentation and rendered evidence copy must name the role, not only the visual value.

Use:

- `Primary text on Layer 01`.
- `Danger action in dark context`.
- `Focus-visible ring on inverse surface`.
- `Status warning tag in light and dark themes`.

Avoid:

- `White text`.
- `Gray card`.
- `Blue button`.
- `Dark box`.

Color names may appear only when documenting actual value differences, not when describing allowed API usage.

## 13. Prohibited usage

- Do not bypass this Element API with one-off raw values, local utility clusters, or custom design tokens.
- Themes change token values, not token roles.
- Do not hard-code component colors inside theme-specific markup.
- Any custom theme override must document reason, owner, and source file.
- Test components against all supported theme contexts before marking them complete.
- Do not create per-page theme systems.
- Do not create feature-local dark-mode classes.
- Do not use Tailwind color utilities to patch theme failures.
- Do not override semantic status colors for decoration.
- Do not use inverse styles outside an approved inverse surface.
- Do not claim high-contrast support without visible rendered evidence proof.
- Do not introduce a new theme name, wrapper, token family, or resolver without updating this Element standard.

## 14. Deferred or gated capabilities

| Capability                    | Status                    | Gate                                                                                             |
| ----------------------------- | ------------------------- | ------------------------------------------------------------------------------------------------ |
| Additional named app themes   | Deferred                  | Requires product/design approval, full token map, rendered evidence proof, and tests.                 |
| Per-user custom theme values  | Deferred                  | Requires personalization contract, persistence, accessibility guardrails, and rollback behavior. |
| High-contrast theme mode      | Partial / gated           | Requires complete text, focus, icon, border, and state proof across core components.             |
| Inline mixed-theme regions    | Partial / pattern-owned   | Requires approved wrapper and Pattern ownership.                                                 |
| Inverse component variants    | Partial / component-owned | Requires each component to document inverse behavior and tests.                                  |
| Runtime theme editor          | Not approved              | Requires separate product capability and security/accessibility review.                          |
| Feature-local theme overrides | Not allowed               | Use the Element API and owning Component/Pattern API instead.                                    |

No additional capability is approved without updating this Element standard and rendered evidence proof.

## 15. Implementation and Rendered Evidence Checklist

### 15.1. Implementation checklist

| Requirement                 | Standard expectation                                                                                                              |
| --------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source           | The standard names the approved token families, CSS variables, utility classes, helpers, source files, or explicit deferred gate. |
| Token/class/helper coverage | The durable Element API surface is listed for Component and Pattern consumers.                                                    |
| Theme/state behavior        | Theme, state, reduced-motion, accessibility, or interaction rules owned by the Element are defined.                               |
| Consumers                   | Component and Pattern consumers are named where they rely on this Element.                                                        |
| Prohibited usage            | Feature code, Components, and Patterns are told what they must not redefine locally.                                              |
| Tests                       | Route/content/API assertions are defined to prove the Element contract.                                                           |

### 15.2. rendered evidence proof checklist

| Requirement          | Visual proof expectation                                                                                            |
| -------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Live examples        | The page renders examples with app CSS/JS, not screenshots only.                                                    |
| Token/API references | Token, class, helper, or API names appear with example usage.                                                       |
| Theme/state examples | Relevant theme contexts, variants, states, or gated disposition surfaces are visible.                               |
| Accessibility proof  | Contrast, focus, semantics, hit targets, reduced motion, or equivalent Element constraints are shown or documented. |
| Related APIs         | Consuming Components, Patterns, source files, and the canonical standard are linked.                                |
| Manual review        | The page provides enough rendered proof for visual review without opening source code first.                        |
## 16. Rendered evidence requirements

The `not installed` route must render live examples with app CSS/JS rather than screenshots only.

Required sections:

- Theme anatomy.
- Usage rules.
- Theme value matrix.
- Theme context stack.
- Theme comparison examples.

### 16.1. Required live examples

| Example                    | Required rendered proof                                                                                                  |
| -------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| Sign-in comparison         | Shows the same authentication UI across `white`, `gray-10`, `gray-90`, and `gray-100`.                                  |
| Settings form comparison   | Shows field surfaces, helper text, warning text, and tags inheriting theme values.                                       |
| Data table comparison      | Shows table rows, borders, text, and status tags under installed theme contexts.                                         |
| Notification comparison    | Shows semantic feedback preserving meaning while theme values change.                                                    |
| Scoped context stack       | Shows inherited root, scoped, and nested theme contexts while child UI keeps the same token names.                       |
| Value matrix               | Shows the same role names resolving to installed values across the supported themes.                                     |
| Prohibited usage guidance  | Explains why local raw color, local dark-mode patching, and decorative semantic color are not allowed.                  |

### 16.2. Required page text

The rendered evidence page must communicate:

- Themes change token values, not token roles.
- Components must use theme-aware tokens for background, text, border, icon, focus, and support states.
- Custom theme overrides require documented ownership and rendered evidence proof.
- Unsupported contexts must be marked `Deferred`, `Not implemented`, or `App-approved exception`.
- Components must be tested in all supported contexts before being marked complete.

### 16.3. Current rendered evidence page responsibility model

The Themes reference implementation keeps durable API truth in `resources/views/elements/themes/contract.php` and rendered evidence presentation in `resources/views/elements/themes/reference.php` plus `resources/views/elements/themes/reference/**`.

Current page ownership:

| Page | Responsibility | Must not own |
| ---- | -------------- | ------------ |
| Overview | Theme anatomy, installed theme contexts, relationship to Color, source orientation, and navigation to focused detail pages. | Full token/value matrices or example galleries. |
| Usage | Rules for applying, scoping, and switching root or local theme contexts. | Color role definitions or component-specific color rules. |
| Values | Cross-theme value matrices for installed role names. | Color token role meaning or general usage guidance. |
| Contexts | Root, scoped, nested, and inherited theme behavior. | General component example galleries. |
| Examples | Same UI rendered across installed themes: sign-in, settings form, data table, and notification/status examples. | Token catalogs, context theory, or Color role definitions. |

Color defines the stable role name. Themes resolve that role name to installed values. For example, Color owns what `--ui-text-primary` means, while Themes owns how `--ui-text-primary` resolves in `white`, `gray-10`, `gray-90`, and `gray-100`.

Only examples declared by the Themes contract and selected by the Themes reference pages should render in the Examples page. Parked or future example files may exist under `resources/views/elements/themes/examples/**`, but they are not active rendered evidence examples until they are registered by `contract.php` and selected by `reference.php`.

## 17. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- Unauthorized users cannot access the route.
- The page renders live examples with app CSS/JS rather than screenshots only.
- The page shows token/class/helper API references, allowed usage, prohibited usage, accessibility constraints, and implementation status.
- The page includes theme anatomy with `white`, `gray-10`, `gray-90`, and `gray-100`.
- The page includes value matrices for text, surface, layer, border, icon, focus, and field roles.
- The page includes comparison examples that use actual app classes/components.
- The page documents inline, inverse, and high-contrast contexts as implemented, partial, deferred, or not implemented.
- The page clearly marks unsupported custom override work as gated or deferred.
- The page avoids raw hex examples except when documenting prohibited usage or source-token value tables.
- The page includes related links to Color, UI shell, overlays/feedback, and the canonical doc route.

### 17.1. Suggested automated assertions

- Assert route returns 200 for authorized users.
- Assert route contains `data-ui-reference-element="themes"` or equivalent page marker.
- Assert rendered output includes `html[data-theme-resolved="light"]` and `html[data-theme-resolved="dark"]` as documented selectors or examples.
- Assert rendered output includes `Theme anatomy`, `Theme values`, `Theme contexts`, `Theme comparison examples`, and `Scoped theme resolution`.
- Assert the active examples render `auth-comparison`, `form-comparison`, `table-comparison`, and `notification-comparison`.
- Assert examples reference `--ui-background`, `--ui-layer-01`, `--ui-text-primary`, `--ui-border-subtle-01`, and `--ui-focus` roles.
- Assert there is no generic fallback text such as `Coming soon`, `Example component`, or placeholder-only theme copy.

## 18. Related APIs

| API                           | Route                                                          |
| ----------------------------- | -------------------------------------------------------------- |
| Color element                 | `not installed`                        |
| Typography element            | `not installed`                   |
| Spacing element               | `not installed`                      |
| Motion element                | `not installed`                       |
| Icons element                 | `not installed`                        |
| UI shell                      | `not installed`                   |
| Button component              | `not installed`                     |
| Notification component        | `not installed`               |
| Overlays and feedback pattern | `not installed`            |
| Canonical themes doc          | `/platform/docs?path=02-standards%2Fui%2Felements%2Fthemes.md` |
| Carbon themes overview        | `https://carbondesignsystem.com/elements/themes/overview/`     |

## 19. References

- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon themes inform token inheritance and layer thinking. Login App keeps its own theme names, values, and CSS variable model.

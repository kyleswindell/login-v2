---
title: Loading
slug: loading
api_layer: Component API
status: implemented-pending-review
system_maturity: installed
category: feedback-and-loading
priority: tier-a-baseline-app-development
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/loading.md
source_owner: not installed
blade_api:
  - x-ui.loading
javascript_api: []
data_attributes:
  - data-ui-loading
  - data-ui-loading-active
  - data-ui-loading-size
  - data-ui-loading-placement
  - data-ui-loading-overlay
source_files:
  - resources/css/app.css
  - resources/views/components/ui/loading/index.blade.php
  - not installed
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
related_components:
  - button
  - inline-loading
  - notification
  - progress-indicator
  - modal
  - data-table
related_patterns:
  - forms
  - tables
  - overlays-feedback
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/loading/usage/
  - https://carbondesignsystem.com/components/loading/style/
  - https://carbondesignsystem.com/components/loading/accessibility/
  - https://carbondesignsystem.com/patterns/loading-pattern/
  - https://carbondesignsystem.com/components/inline-loading/accessibility/
---

# Loading Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed production rules:](#31-installed-production-rules)
  - [3.2. Installed modes:](#32-installed-modes)
- [4. Public API](#4-public-api)
  - [4.1. API status](#41-api-status)
  - [4.2. Canonical spinner](#42-canonical-spinner)
  - [4.3. Localized spinner](#43-localized-spinner)
  - [4.4. Overlay loading](#44-overlay-loading)
  - [4.5. Inactive state](#45-inactive-state)
  - [4.6. Class contract](#46-class-contract)
  - [4.7. Option contract](#47-option-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper usage](#74-helper-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use Loading when:](#91-use-loading-when)
  - [9.2. Do not use Loading when:](#92-do-not-use-loading-when)
  - [9.3. Mode selection:](#93-mode-selection)
  - [9.4. Status selection:](#94-status-selection)
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

Loading provides large blocking and small inline indicators for unknown-duration pending work while the system retrieves data, saves changes, or performs processing.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Loading is the installed Login App 2.0 pending-state API for non-interactive loading feedback. It owns the `x-ui.loading` Blade API, large and small spinner presentation, optional label text, loading overlay visuals, placement classes, reduced-motion behavior, token-backed loading colors, and loading-specific accessibility requirements. It does not own button-in-progress completion behavior, determinate progress, notification outcomes, modal focus trapping, inert background management, table data fetching, form validation, or external layout spacing.

### 1.1. Canonical API responsibilities:

- Render pending content through `x-ui.loading` and app-owned `ui-loading*` classes.
- Provide large and small loading indicator sizes.
- Provide optional overlay treatment for large page, component, section, modal, side-panel, and tile loading.
- Provide inline small loading without overlay.
- Keep every loading state tied to a pending region, pending action, or pending content target.
- Provide understandable visible or assistive status text.
- Mark loading indicators busy where appropriate.
- Respect reduced-motion preferences for animated spinner and skeleton states.
- Keep loading indicators non-interactive and out of the tab order.
- Consume Foundation Element APIs for color, spacing, typography, themes, and motion.
- Prove large loading, small loading, placement, overlay, inactive state, reduced-motion, accessibility, and implementation behavior on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Inline button/action replacement after a user action. Use Inline loading or Button loading behavior.
- Submit/cancel placement or disabled action orchestration. Use Button and the parent Pattern.
- Determinate progress, percent complete, steps, or long-running process tracking. Use Progress indicator when installed, or gate the capability.
- Success, error, warning, or informational outcome banners. Use Notification unless the page-region loading handoff is explicitly scoped to status text.
- Focus trapping, inert state, scroll locking, and focus return. Use Overlay/feedback or Modal Pattern ownership.
- Data table sorting, pagination, filter, or empty-state behavior. Use Data table or Table toolbar Patterns.
- External spacing around a loading component. Parent Patterns own placement, grouping, spacing, and workflow orchestration.

Carbon alignment note: Carbon treats loading indicators as visual feedback for pending work, uses two spinner sizes, recommends skeleton states for progressive/full-screen content loading, discourages multiple simultaneous loading indicators, and requires programmatic status updates for assistive technology. Login App maps those principles to app-owned `ui-*` classes, native semantics, and rendered evidence proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                  |
| ---------------------------- | ------------------------------------------------------------------------------------------------------ |
| Status                       | Approved API                                                                                           |
| System maturity              | Installed                                                                                              |
| API layer                    | Component API                                                                                          |
| Component slug               | loading                                                                                                |
| Category                     | Feedback and loading                                                                                   |
| Priority                     | Tier A - Baseline app development                                                                      |
| Rendered evidence route           | `not installed`                                                            |
| Canonical doc                | `docs/02-standards/ui/components/loading.md`                                                           |
| Source owner                 | `not installed`                                                            |
| Blade API                    | `x-ui.loading`                                                                                         |
| JavaScript API               | None required for baseline loading behavior                                                            |
| Data attributes              | `data-ui-loading`, `data-ui-loading-active`, `data-ui-loading-size`, `data-ui-loading-placement`, `data-ui-loading-overlay` |
| Props/options                | `id`, `active`, `size`, `placement`, `label`, `overlay`, `disableRelatedActions`, `ariaLabel`, `ariaLive`, `attributes` |
| Source files                 | `resources/views/components/ui/loading/index.blade.php`; `resources/css/app.css`; `not installed` |
| CSS namespace                | App-owned `ui-loading*` classes                                                                         |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion                                                             |
| Carbon benchmark             | Carbon Loading usage, style, accessibility, Loading Pattern, and Inline loading accessibility guidance |

`Approved API` means the loading Blade wrapper, visual treatment, route proof, and regression tests are installed. Skeleton-specific wrappers remain separate future work.

## 3. Installed standard

The installed standard is a Blade Component API.

Use the installed Loading API when a region, content block, table, card, or page section is pending and the user needs to understand that the system is still working. Loading indicators must be tied to a concrete pending target and must not be used as decorative emphasis.

### 3.1. Installed production rules:

- Use `<x-ui.loading>` as the canonical API for loading indicators.
- Use `size="lg"` for page, component, section, modal, side-panel, tile, or major-region loading. Large is the default and renders an 88px indicator.
- Use `size="sm"` for localized inline loading. Small renders a 16px indicator.
- Use `placement` to identify the loading boundary: `inline`, `component`, `section`, `modal`, `side-panel`, `tile`, or `page`.
- Use `overlay` only when large loading should block interaction with the region. Overlay defaults on for large non-inline placements.
- Use `label` or `aria-label` for every loading indicator.
- Add `role="status"` and an appropriate live-region strategy when loading status text needs to be announced.
- Render inactive loading with `:active="false"` when no indicator should be visible.
- Remove the loading indicator and clear or update parent busy state when content is ready.
- Communicate completion through focus movement, updated content, or a status message when the completion would otherwise only be visual.
- Use Foundation Motion and `prefers-reduced-motion` behavior for spinner and skeleton animation.
- Parent Patterns own placement, sizing context, overlays, disabled dependent controls, and external spacing.
- Do not create raw SVG/CSS spinners, Bootstrap spinners, local skeleton loaders, raw utility clusters, raw colors, or feature-local JavaScript for loading behavior.

### 3.2. Installed modes:

| Mode                       | Status                              | Use                                                                                                           |
| -------------------------- | ----------------------------------- | ------------------------------------------------------------------------------------------------------------- |
| Large loading              | Implemented                         | Use for indeterminate pending work in a page, component, section, modal, side-panel, tile, or major region. |
| Small loading              | Implemented                         | Use for localized pending work near a specific action or compact UI element.                                |
| Overlay loading            | Implemented visual treatment        | Use with large loading when interaction with the unavailable region should be blocked.                       |
| Inactive loading           | Implemented                         | Use `:active="false"` when no loading indicator should render.                                              |
| Skeleton text/card/table   | Pattern/component-consumed          | Use when a consuming component or Pattern owns the final content shape.                                      |
| Full focus/inert overlay   | Gated / Pattern-owned               | Requires overlay/focus/inert behavior approval before production use.                                       |

This page must not render `Component-specific API pending correction` as the example call. It must show real loading markup, real class names, state ownership, and deferred gates.

## 4. Public API

### 4.1. API status

The current public API is `x-ui.loading`.

| API surface           | Installed value                                                                               |
| --------------------- | --------------------------------------------------------------------------------------------- |
| Blade                 | `x-ui.loading`                                                                                |
| JavaScript            | No dedicated JavaScript controller required                                                   |
| Data attributes       | `data-ui-loading`, `data-ui-loading-active`, `data-ui-loading-size`, `data-ui-loading-placement`, `data-ui-loading-overlay` |
| Props/options         | `id`, `active`, `size`, `placement`, `label`, `overlay`, `disableRelatedActions`, `ariaLabel`, `ariaLive`, `attributes` |
| Slots                 | Not applicable until a Blade wrapper is installed                                             |
| Root semantic element | Native `div`, `section`, `tbody`, or context-appropriate container with status semantics      |
| CSS namespace         | `ui-loading*`                                                                                 |
| Source files          | `resources/views/components/ui/loading/index.blade.php`; `resources/css/app.css`; `not installed` |

Feature views must use `x-ui.loading` instead of creating local spinner markup.

### 4.2. Canonical spinner

Use a spinner when work is indeterminate and the shape of incoming content is not useful to preview.

```blade
<x-ui.loading
    active
    size="lg"
    placement="section"
    label="Loading account summary"
    overlay
/>
```

Use specific labels. `Loading account summary` is better than `Loading` because it names the pending target.

### 4.3. Localized spinner

Use the small spinner for localized pending work near a region or piece of content. Small loading does not use an overlay.

```blade
<x-ui.loading
    active
    size="sm"
    placement="inline"
    label="Checking invitation status"
    :overlay="false"
/>
```

### 4.4. Overlay loading

Use overlay loading when a large loading state temporarily blocks a page, component, section, modal, side-panel, or tile region.

```blade
<x-ui.loading
    active
    size="lg"
    placement="section"
    label="Loading account summary"
    overlay
/>
```

Parent Patterns own focus trapping, inert background behavior, scroll locking, and focus return. The Loading component owns the visual overlay and status indicator.

### 4.5. Inactive state

Inactive loading renders no indicator.

```blade
<x-ui.loading :active="false" size="sm" placement="inline" aria-label="Inactive loading" />
```

### 4.6. Class contract

| Class | Type | Status | Purpose |
| ----- | ---- | ------ | ------- |
| `ui-loading` | Root | Implemented | Loading indicator wrapper. |
| `ui-loading--lg` / `ui-loading--sm` | Size | Implemented | Large 88px indicator or small 16px indicator. |
| `ui-loading--placement-*` | Placement | Implemented | Records inline, component, section, modal, side-panel, tile, or page placement. |
| `ui-loading--overlay` | Modifier | Implemented | Visual overlay for large blocked regions. |
| `ui-loading__indicator` | Element | Implemented | Indicator box with fixed size. |
| `ui-loading__spinner` | Element | Implemented | Token-backed circular spinner. |
| `ui-loading__label` | Element | Implemented | Optional visible label text. |

Feature views must not create additional `ui-loading-*` classes. New classes require source implementation, this standard update, rendered evidence proof, and tests.

### 4.7. Option contract

| Option | Type | Default | Allowed values | Required | Notes |
| ------ | ---- | ------- | -------------- | -------- | ----- |
| `id` | string / null | `null` | Valid HTML id | No | Use when a region needs a stable target. |
| `active` | bool | `true` | `true`, `false` | No | False renders no indicator. |
| `size` | string | `lg` | `sm`, `lg` | No | Large is 88px; small is 16px. |
| `placement` | string | `component` | `inline`, `component`, `section`, `modal`, `side-panel`, `tile`, `page` | No | Identifies the loading boundary. |
| `label` | string / null | `null` | Brief process label | No | Visible label; also used for accessible name unless `ariaLabel` is provided. |
| `overlay` | bool / null | computed | `true`, `false`, `null` | No | Null follows the size/placement overlay rule. |
| `disableRelatedActions` | bool | `false` | `true`, `false` | No | Emits a review marker; parent Pattern must disable actual controls. |
| `ariaLabel` | string / null | label or `Loading` | Accessible name | No | Required when there is no visible label. |
| `ariaLive` | string | `polite` | `off`, `polite`, `assertive` | No | Use assertive only for urgent blocking changes. |

Any API not listed here is not public. If a feature needs a new loading shape, wrapper, status, data attribute, or JavaScript behavior, update the component implementation, this standard, rendered evidence proof, and tests before production use.

## 5. Allowed variants, options, and modifiers

| Name | Type | Status | API | Notes |
| ---- | ---- | ------ | --- | ----- |
| Large loading | Size | Implemented | `<x-ui.loading size="lg" />` | Default 88px indicator for page, section, modal, side-panel, tile, or component loading. |
| Small loading | Size | Implemented | `<x-ui.loading size="sm" placement="inline" />` | 16px inline indicator for localized pending work. |
| Overlay loading | Modifier | Implemented | `overlay` / computed overlay | Visual overlay for large blocked regions. |
| Inline placement | Placement | Implemented | `placement="inline"` | Localized indicator without overlay. |
| Page placement | Placement | Implemented | `placement="page"` | Centers large loading in the viewport. |
| Component/section/modal/side-panel/tile placement | Placement | Implemented | `placement="component"`, `section`, `modal`, `side-panel`, `tile` | Centers large loading in the owning region. |
| Active state | State | Implemented | `active` | Renders loading with status semantics. |
| Inactive state | State | Implemented | `:active="false"` | Renders no indicator. |
| Reduced-motion | State/user preference | Implemented | CSS `prefers-reduced-motion` behavior | Animation slows under reduced-motion preference. |
| Inline action loading | Boundary | Not owned by Loading | Use Inline loading or Button loading | Do not build action completion handoffs with this API. |
| Determinate progress | Component boundary | Not owned by Loading | Progress bar or progress indicator | Loading is indeterminate only. |
| Skeleton component wrappers | Extension | Gated | None | Requires a separate Skeleton API or consuming component proof. |
| Multiple simultaneous spinners | Usage | Not allowed | None | Use one loading message for the affected region unless every loader is clearly localized. |

## 6. States

| State                       | Status                            | Implementation requirement                                                                                                                  |
| --------------------------- | --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| Default / inactive          | Implemented as absence            | Do not render a loading indicator when no work is pending.                                                                                  |
| Loading / active            | Implemented                       | Render loading with status text or accessible name and token-backed motion.                                                                 |
| Overlay active              | Implemented                       | Overlay blocks pointer interaction with the unavailable visual region.                                                                      |
| Small inline active         | Implemented                       | Render inline without overlay and keep it near the related action or status text.                                                           |
| Reduced motion              | Implemented                       | Spinner and skeleton animation must respect user reduced-motion preferences.                                                                |
| Disabled dependent controls | Pattern/child-owned               | Disable affected controls through Button or field APIs while loading; Loading itself is not disabled.                                       |
| Hover                       | Not applicable                    | Loading is non-interactive. Do not add hover treatment.                                                                                     |
| Focus-visible               | Not applicable to loading root    | Loading is not focusable. Focus movement after completion is Pattern-owned when needed.                                                     |
| Active/pressed              | Not applicable                    | Loading is not an action.                                                                                                                   |
| Selected/unselected         | Not applicable                    | Loading is not selectable.                                                                                                                  |
| Expanded/collapsed          | Not applicable                    | Disclosure belongs to the parent Pattern.                                                                                                   |
| Read-only                   | Not applicable                    | Loading is feedback, not editable data.                                                                                                     |
| Validation                  | Not applicable                    | Validation belongs to field components, Forms Pattern, or Notification.                                                                     |
| Empty                       | Not applicable                    | If no data exists after loading, use the appropriate Empty state or Pattern.                                                                |
| Overflow/truncated          | Implemented through content rules | Status labels and recovery copy must wrap or remain readable; do not truncate critical loading text.                                        |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Loading consumes Foundation Color, Spacing, Typography, Themes, and Motion.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.

Icons and grid are not public Loading API dependencies. If a loading flow needs an outcome icon, use Notification, Inline loading, or another installed component that owns icon semantics. Parent Patterns may use 2x Grid to place loading regions, but Loading does not define grid layout.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                                                                 |
| ----------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Indicator stroke, small indicator background, loading text, disabled-region contrast, and overlay roles. |
| Spacing     | Indicator-label gap, indicator dimensions, and region centering when the component owns internal spacing. |
| Typography  | Optional loading label text sizing. |
| Themes      | Light, dark, and inverse token resolution for indicator, text, and overlay states. |
| Motion      | Spinner rotation and reduced-motion behavior. |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$interactive` | Large/small loading indicator stroke | `ui-loading__spinner`, spinner stroke role | App interactive/action palette | Same role / app value | Spinner stroke uses the global interactive role, not arbitrary brand colors. |
| `$layer-accent` | Small loading indicator background | Loading indicator background role | App layer accent palette | Same role / app value | Indicator background shares layer accent mapping. |
| `$overlay` | Page loading overlay | `--ui-overlay` | App overlay palette | Same role / app value | Loading uses the global overlay role and does not create local scrim colors. |
| `$text-secondary`, `$text-primary` | Loading label text | Loading text roles | App text palette | Same role / app value | Loading copy follows text hierarchy. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation.

```css
.ui-loading
.ui-loading--sm
.ui-loading--lg
.ui-loading--placement-inline
.ui-loading--placement-component
.ui-loading--placement-section
.ui-loading--placement-modal
.ui-loading--placement-side-panel
.ui-loading--placement-tile
.ui-loading--placement-page
.ui-loading--overlay
.ui-loading__indicator
.ui-loading__spinner
.ui-loading__label
```

Feature views must not create `spinner-*`, `loader-*`, `skeleton-*`, `placeholder-*`, Bootstrap `.spinner-border`, Bootstrap `.placeholder`, direct Carbon production classes, raw SVG loaders, local keyframes, arbitrary animation durations, raw hex colors, arbitrary spacing, custom focus rings, or feature-local loading classes for the same UI role.

### 7.4. Helper usage

| Helper/mechanism                      | Status                                             | Rule                                                                                                                                       |
| ------------------------------------- | -------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |
| Native `role="status"`                | Approved                                           | Use for loading status text that should be announced.                                                                                      |
| Native `aria-live`                    | Approved                                           | Use `polite` for most loading updates and `assertive` only for blocking or urgent conditions.                                              |
| Native `aria-busy`                    | Approved                                           | Loading emits busy state; parent Patterns may also apply it to the affected region and clear when complete.                                |
| Native `aria-hidden="true"`           | Approved for decorative spinner internals          | Hide purely visual spinner shapes when label/status text communicates meaning.                                                             |
| Component-owned hidden text           | Approved if implemented by the CSS API             | Use only the app-owned hidden-text class documented by implementation; do not create ad hoc screen-reader utility classes in features.     |
| JavaScript polling/loading controller | Not approved as Loading API                        | Feature or Pattern behavior may fetch data, but it must not create a new Loading Component JavaScript API without documentation and tests. |
| `data-ui-loading-*` attributes        | Approved                                           | Use only attributes emitted by `x-ui.loading` for tests, review, and future-safe behavior boundaries.                                      |

## 8. Composition rules

- Use a loading indicator only when a system action, retrieval, save, submit, calculation, upload, or content render is actually pending.
- Use a spinner when the incoming content shape is unknown or the pending state is tied to a bounded section.
- Use skeletons when the final content structure is predictable and showing the layout will help users understand what is loading.
- Use page-region loading when an existing region becomes temporarily unavailable or a page section is reserved for incoming content.
- Use Inline loading or Button loading for a single button/action in progress.
- Use Progress indicator for determinate progress, percentages, steps, or long-running processes when that API is installed.
- Keep loading components non-interactive and out of the tab order.
- Disable dependent controls through their installed Component APIs when user action should wait for loading to finish.
- Do not block the entire page without Pattern-owned overlay, inert-state, scroll, and focus-return behavior.
- Do not show more than one primary loading indicator for the same pending operation.
- Do not use skeleton states for action components such as buttons, form controls, toggles, checkboxes, radios, menus, modals, notifications, or loaders.
- Skeletons may represent content inside a modal, but the modal shell itself must not become a skeleton.
- Remove loading indicators promptly when content is ready.
- Provide a completion cue when the only visible change would be an indicator disappearing.
- Motion and state changes must use Foundation Motion and respect reduced-motion preferences.
- Components own internal semantics, loading styling, reduced-motion treatment, and status text structure.
- Parent Patterns own grouping, external spacing, workflow orchestration, data fetching, disabled dependent controls, overlays, and page-level layout.

## 9. Selection guidance

### 9.1. Use Loading when:

- A content region, table, card, dashboard panel, or page section is retrieving data.
- A save, submit, upload, or calculation temporarily makes a region unavailable.
- The user needs reassurance that the system is still working.
- The final content shape is predictable enough to represent with a skeleton.
- A pending page region needs `aria-busy` and status text.

### 9.2. Do not use Loading when:

- The action is inside a button or compact action row; use Button loading or Inline loading.
- The task has measurable progress; use Progress indicator when installed.
- User input is required to proceed; use validation, Tooltip/Toggletip, Notification, or the owning Pattern.
- The feedback is an outcome rather than a pending state; use Notification or status messaging owned by the Pattern.
- The indicator is decorative or intended to add visual motion.
- Content loads instantly enough that an indicator would flash.
- The page needs focus trapping, inert background behavior, scroll locking, or focus return; use an approved overlay Pattern before production use.
- The content is actually empty after loading; use the correct Empty state or Pattern.

### 9.3. Mode selection:

| Need                                                    | Use                                  |
| ------------------------------------------------------- | ------------------------------------ |
| Unknown or short indeterminate pending work in a region | Loading                              |
| Localized status near a small content area              | Small loading                        |
| Section or page-region pending state                    | Large loading                        |
| Text or metadata loading                                | Skeleton text                        |
| Card, tile, dashboard panel, or summary block loading   | Skeleton card                        |
| Tabular rows or list-like data loading                  | Skeleton table                       |
| Button submit/action pending                            | Button loading or Inline loading     |
| Long operation with known steps or percent              | Progress indicator                   |
| Persistent result or recovery message                   | Notification                         |

### 9.4. Status selection:

| Need                                               | Use                                                     |
| -------------------------------------------------- | ------------------------------------------------------- |
| Work is pending                                    | `x-ui.loading`                                          |
| Work completed and content update is not obvious   | Pattern-owned status or Notification                    |
| Work failed and immediate retry/recovery is needed | Notification or Pattern-owned recovery                  |
| Work completed with a non-blocking concern         | Notification or Pattern-owned helper text               |
| Work requires neutral context                      | Pattern-owned helper text                               |

## 10. Accessibility contract

- Loading components are not interactive and must not receive keyboard focus.
- Every loading state must provide an accessible status through visible text, component-owned assistive text, `role="status"`, `aria-live`, or equivalent Pattern-owned semantics.
- Status text must name the pending target or action.
- Use `aria-busy="true"` on the affected region when existing content is being updated.
- Clear `aria-busy` when loading completes.
- Purely visual spinner internals must be hidden from assistive technology when status text already conveys the loading state.
- Do not rely on animation alone to communicate loading.
- Do not rely on color alone for loading, success, error, warning, or info meaning.
- Reduced-motion preferences must be respected for spinner animation.
- If a loading indicator disappears after a long or blocking operation, completion must be conveyed through updated focus, updated content, or a status message.
- If loading disables dependent controls, those controls must use their own semantic disabled state.
- If a full-page blocker is approved by a Pattern, the Pattern must own focus order, inert/background behavior, scroll behavior, escape/cancel behavior where applicable, and completion focus return.
- Skeletons must not expose fake labels or fake data to screen readers.
- Status handoff messages must be announced politely unless an urgent failure or blocker requires assertive announcement.
- Loading copy must maintain readable contrast in every supported theme.

## 11. Content contract

- Use sentence case for loading labels and status handoff copy.
- Name the pending target: `Loading users`, `Saving profile`, `Generating report`.
- Avoid vague copy such as `Loading`, `Please wait`, `Working`, or `Processing` when a concrete noun is available.
- Keep spinner labels short enough to scan.
- Use one label per loading region.
- Do not expose fake data or placeholder words inside skeletons.
- Use status handoff copy only when it adds useful information after loading completes or fails.
- Error handoff copy must include a recovery path when the user can act: `Could not load users. Try again.`
- Warning handoff copy must identify the non-blocking concern without sounding like a failure.
- Success handoff copy must be brief and should not replace loaded content.
- Do not use loading copy to explain complex process details; use Notification, helper text, or the owning Pattern.
- Do not use humor, decorative motion language, or brand-only copy for pending states.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, raw SVG loaders, Bootstrap spinners, Bootstrap placeholders, or custom JavaScript.
- Do not render `Component-specific API pending correction` as the example call or installed guidance.
- Do not create feature-local loading wrappers such as `x-loading`, `x-spinner`, `x-ui.skeleton`, or equivalent local APIs.
- Do not create local `spinner-*`, `loader-*`, `skeleton-*`, `placeholder-*`, or animation keyframe classes.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not use loading indicators for decorative emphasis.
- Do not show loading indicators without an understandable pending region, pending action, or pending content target.
- Do not show multiple loading indicators for the same operation.
- Do not skeletonize buttons, menus, modals, notifications, loaders, form controls, toggles, checkboxes, or radios.
- Do not use skeletons with fake text, fake names, fake counts, or fake table values.
- Do not use spinner color alone to indicate success, error, warning, or info.
- Do not use a spinner when the operation has known progress that should be communicated as progress.
- Do not trap focus on a loading component.
- Do not leave `aria-busy="true"` after content has loaded.
- Do not create broad library-wide loading fixes from this standard.

## 13. Deferred or gated capabilities

| Capability                                     | Status                | Gate                                                                                                                                            |
| ---------------------------------------------- | --------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| Public `x-ui.skeleton` Blade wrapper           | Deferred              | Requires shape props, label behavior, reduced-motion proof, responsive behavior, and tests.                                                     |
| Custom skeleton shape API                      | Gated                 | Requires tokenized dimensions, layout constraints, no fake content, rendered evidence matrix, and accessibility proof.                               |
| Full focus/inert overlay orchestration         | Pattern-owned / gated | Requires Overlay/feedback Pattern approval, inert behavior, scroll locking, focus return, status announcement, reduced-motion proof, and tests. |
| Determinate progress or percentage             | Not owned by Loading  | Requires Progress indicator API. Do not add percentage behavior to Loading.                                                                     |
| Inline loading replacement for buttons/actions | Not owned by Loading  | Use Inline loading or Button loading behavior.                                                                                                  |
| Data-fetch JavaScript controller               | Deferred              | Requires documented data attributes, lifecycle events, cancellation/error handling, no feature-local controller forks, and tests.               |
| Loading timeout/escalation behavior            | Gated                 | Requires Pattern owner, Notification handoff, retry/cancel rules, and accessibility proof.                                                      |
| AI generation loading treatment                | Gated                 | Requires AI labeling/explainability standard, status copy rules, cancellation behavior, and rendered evidence proof.                                 |
| Additional spinner sizes                       | Not allowed           | Requires Spacing, Typography, Motion, and rendered evidence updates.                                                                                 |
| Custom status colors                           | Not allowed           | Requires Color Element standard update and rendered evidence proof.                                                                                  |

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

The Loading page is a broad feedback reference page. It should use matrices, grouped examples, state tables, placement examples, and implementation examples rather than a simple tab-only scaffold.

### 15.1. Required Live examples internal sections:

| Required proof                    | Rendered behavior                                                                                                                                      | Variants/options shown                                                                       |
| --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------- |
| API status proof                  | Page states that Loading is Approved API and exposes `x-ui.loading`.                                                                                   | `x-ui.loading`, `ui-loading`, `data-ui-loading`                                              |
| Size matrix                       | Small and large loading indicators render with labels and status semantics.                                                                            | Small, Large, 16px, 88px                                                                     |
| Placement examples                | Page, component, section, modal, side-panel, tile, and inline examples show the loading boundary.                                                      | Page, Component, Section, Modal, Side panel, Tile, Inline                                    |
| Overlay proof                     | Large region loading blocks the unavailable visual region with the overlay token.                                                                      | Overlay, `--ui-overlay`, Pointer blocking                                                    |
| Active/inactive state proof       | Active loading renders status markup; inactive loading renders no indicator.                                                                           | Active, Inactive                                                                             |
| Reduced-motion proof              | Spinner examples document and demonstrate reduced-motion behavior.                                                                                     | Motion, Reduced motion                                                                       |
| Accessibility proof               | Examples show status text, live regions, busy state, hidden decorative spinner, non-focusable loading roots, and completion announcement requirements. | `role="status"`, `aria-live`, `aria-busy`, `aria-hidden`, completion status                  |
| Content behavior proof            | Examples use specific labels and recovery copy instead of vague loading text.                                                                          | Loading users, Saving profile, Could not load users, Users loaded                            |
| Selection matrix                  | Page distinguishes Loading from skeleton states, Inline loading, Progress bar, Progress indicator, Notification, and Empty state use.                 | Loading, Skeleton, Inline loading boundary, Progress boundary, Notification boundary         |
| Prohibited usage proof            | Page shows local spinners, Bootstrap spinners/placeholders, direct Carbon classes, decorative loading, and multiple spinners as prohibited.            | Raw loaders, Bootstrap, Carbon classes, Multiple spinners                                    |
| Deferred gate proof               | Page shows trigger conditions for skeleton wrappers, full inert/focus overlay behavior, JavaScript controllers, timeouts, and progress.                | Skeleton API, Full focus/inert overlay, JS controller, Progress                              |
| Foundation Elements proof         | Page shows consumed Foundation Elements and token responsibilities.                                                                                    | Color, Spacing, Typography, Themes, Motion                                                   |
| Developer implementation examples | Canonical `x-ui.loading` examples render as real code examples and do not include placeholder text.                                                    | Large page loading, Component loading, Modal loading, Inline small loading                   |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed Blade API, rendered modes, rendered states, prohibited usage, deferred gates, accessibility behavior, reduced-motion behavior, and consumed Foundation Elements.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The page identifies Loading as `Approved API`.
- The page shows `x-ui.loading` as the canonical API.
- The page renders loading examples for small and large sizes.
- The page renders page, component, section, modal, side-panel, tile, and inline placement examples.
- The page renders overlay examples with `--ui-overlay`.
- The page renders active and inactive state examples.
- The page documents reduced-motion behavior for spinner animation.
- The page documents that Loading is non-interactive and must not receive focus.
- The page documents completion handoff requirements when loading disappears.
- The page distinguishes Loading from skeleton states, Inline loading, Button loading, Progress bar, Progress indicator, Notification, and Empty state behavior.
- The page documents prohibited usage for raw spinners, Bootstrap spinners/placeholders, direct Carbon classes, local skeleton classes, fake skeleton content, decorative loading, and multiple simultaneous indicators.
- Tests assert no generic placeholder content appears.
- Tests assert stale labels such as `Component-specific API pending correction`, `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` remain absent.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production class names, Bootstrap spinner classes, Bootstrap placeholder classes, raw hex colors, arbitrary local spacing, local keyframes, or feature-local loading classes are presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Loading');
$response->assertSee('Approved API');
$response->assertSee('x-ui.loading');
$response->assertSee('data-component-live-layout="loading-matrix"', false);
$response->assertSee('data-ui-loading', false);
$response->assertSee('data-ui-loading-size="lg"', false);
$response->assertSee('data-ui-loading-size="sm"', false);
$response->assertSee('data-ui-loading-placement="page"', false);
$response->assertSee('data-ui-loading-placement="inline"', false);
$response->assertSee('data-ui-loading-overlay="true"', false);
$response->assertSee('Large loading');
$response->assertSee('Small loading');
$response->assertSee('Placement examples');
$response->assertSee('role=&quot;status&quot;', false);
$response->assertSee('aria-live');
$response->assertSee('aria-busy');
$response->assertSee('Reduced motion');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Motion');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('spinner-border');
$response->assertDontSee('placeholder-glow');
$response->assertDontSee('btn btn-primary');
```

## 17. Related APIs

| API                           | Route                                                             |
| ----------------------------- | ----------------------------------------------------------------- |
| Components overview           | `not installed`                               |
| Inline loading                | `not installed`                |
| Button                        | `not installed`                        |
| Notification                  | `not installed`                  |
| Progress indicator            | `not installed`            |
| Modal                         | `not installed`                         |
| Data table                    | `not installed`                    |
| Forms pattern                 | `not installed`                           |
| Tables Pattern                | `not installed`                          |
| Overlay and feedback patterns | `not installed`               |
| Layout Pattern                | `not installed`                          |
| Color element                 | `not installed`                           |
| Spacing element               | `not installed`                         |
| Typography element            | `not installed`                      |
| Themes element                | `not installed`                          |
| Motion element                | `not installed`                          |
| Canonical loading doc         | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Floading.md` |
| Carbon loading usage          | `https://carbondesignsystem.com/components/loading/usage/`        |
| Carbon loading pattern        | `https://carbondesignsystem.com/patterns/loading-pattern/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Loading usage, style, accessibility, and Loading Pattern guidance inform spinner sizing, skeleton selection, multiple-indicator avoidance, status announcements, and reduced-motion requirements. Login App keeps its own `x-ui.loading` API, `ui-*` namespace, Foundation Element tokens, and rendered evidence proof.

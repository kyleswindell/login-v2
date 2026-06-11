---
title: Loading
slug: loading
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: feedback-and-loading
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/loading
canonical_doc: docs/02-standards/ui/components/loading.md
source_owner: /platform/ui-reference/components/loading
blade_api: []
javascript_api: []
data_attributes: []
source_files:
  - resources/css/app.css
  - resources/views/platform/ui-reference/components/loading.blade.php
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
  - [4.4. Skeleton text](#44-skeleton-text)
  - [4.5. Skeleton card](#45-skeleton-card)
  - [4.6. Skeleton table](#46-skeleton-table)
  - [4.7. Page-region loading](#47-page-region-loading)
  - [4.8. Status handoff](#48-status-handoff)
  - [4.9. Class contract](#49-class-contract)
  - [4.10. Option contract](#410-option-contract)
  - [4.11. Reserved future Blade contract](#411-reserved-future-blade-contract)
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

Loading uses spinners, skeletons, and page-region pending states to keep delayed content understandable while the system retrieves data, saves changes, or performs processing.

Canonical API owner: `/platform/ui-reference/components/loading`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Loading is the installed Login App 2.0 pending-state API for non-interactive loading feedback. It owns spinner presentation, skeleton placeholder presentation, loading-region semantics, reduced-motion behavior, status handoff copy, token-backed loading colors, and loading-specific accessibility requirements. It does not own button-in-progress behavior, determinate progress, notification outcomes, page-level overlay orchestration, modal focus behavior, table data fetching, form validation, or external layout spacing.

### 1.1. Canonical API responsibilities:

- Render pending content through app-owned `ui-loading*` and `ui-skeleton*` classes.
- Provide a canonical class-and-semantics API until a Blade wrapper is explicitly installed.
- Distinguish spinner, skeleton text, skeleton card, skeleton table, and page-region loading modes.
- Keep every loading state tied to a pending region, pending action, or pending content target.
- Provide understandable visible or assistive status text.
- Mark affected regions busy where appropriate.
- Respect reduced-motion preferences for animated spinner and skeleton states.
- Keep loading indicators non-interactive and out of the tab order.
- Consume Foundation Element APIs for color, spacing, typography, themes, and motion.
- Prove spinner, skeleton, page-region, status, reduced-motion, accessibility, and implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Inline button/action replacement after a user action. Use Inline loading or Button loading behavior.
- Submit/cancel placement or disabled action orchestration. Use Button and the parent Pattern.
- Determinate progress, percent complete, steps, or long-running process tracking. Use Progress indicator when installed, or gate the capability.
- Success, error, warning, or informational outcome banners. Use Notification unless the page-region loading handoff is explicitly scoped to status text.
- Full-page overlay, inert state, scroll locking, and focus return. Use Overlay/feedback or Modal Pattern ownership.
- Data table sorting, pagination, filter, or empty-state behavior. Use Data table or Table toolbar Patterns.
- External spacing around a loading component. Parent Patterns own placement, grouping, spacing, and workflow orchestration.

Carbon alignment note: Carbon treats loading indicators as visual feedback for pending work, uses two spinner sizes, recommends skeleton states for progressive/full-screen content loading, discourages multiple simultaneous loading indicators, and requires programmatic status updates for assistive technology. Login App maps those principles to app-owned `ui-*` classes, native semantics, and UI Reference proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                  |
| ---------------------------- | ------------------------------------------------------------------------------------------------------ |
| Status                       | Approved API                                                                                           |
| System maturity              | Partial                                                                                                |
| API layer                    | Component API                                                                                          |
| Component slug               | loading                                                                                                |
| Category                     | Feedback and loading                                                                                   |
| Priority                     | Tier A - Baseline app development                                                                      |
| UI Reference route           | `/platform/ui-reference/components/loading`                                                            |
| Canonical doc                | `docs/02-standards/ui/components/loading.md`                                                           |
| Source owner                 | `/platform/ui-reference/components/loading`                                                            |
| Blade API                    | No dedicated public Blade wrapper is approved yet                                                      |
| JavaScript API               | None required for baseline loading behavior                                                            |
| Data attributes              | None approved for behavior                                                                             |
| Props/options                | No Blade props; options are represented by documented class modes and semantic markup                  |
| Source files                 | `resources/css/app.css`; `resources/views/platform/ui-reference/components/loading.blade.php`          |
| CSS namespace                | App-owned `ui-loading*` and `ui-skeleton*` classes                                                     |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion                                                             |
| Carbon benchmark             | Carbon Loading usage, style, accessibility, Loading Pattern, and Inline loading accessibility guidance |

`Approved API` means the loading visual treatment and route exist, but the canonical documentation, UI Reference proof, and regression tests must be corrected to replace placeholder text with the installed class-and-semantics API. A public Blade wrapper may be added later only through the documented gate.

## 3. Installed standard

The installed standard is a class-and-semantics Component API.

Use the installed Loading API when a region, content block, table, card, or page section is pending and the user needs to understand that the system is still working. Loading indicators must be tied to a concrete pending target and must not be used as decorative emphasis.

### 3.1. Installed production rules:

- Use `ui-loading` as the root class for loading status blocks.
- Use `ui-loading--spinner` for an indeterminate spinner.
- Use `ui-loading--skeleton` plus a skeleton shape modifier for content placeholders.
- Use `ui-loading-region` on the affected content region when the region is busy.
- Use `ui-loading--sm` for localized loading and `ui-loading--lg` for section or page-region loading.
- Use `ui-skeleton--text`, `ui-skeleton--card`, and `ui-skeleton--table` for approved skeleton shapes.
- Provide visible status text or component-owned assistive text for every loading state.
- Add `role="status"` and an appropriate live-region strategy when loading status text needs to be announced.
- Add `aria-busy="true"` to the affected region when existing content is being updated.
- Remove the loading indicator and clear or update `aria-busy` when content is ready.
- Communicate completion through focus movement, updated content, or a status message when the completion would otherwise only be visual.
- Use Foundation Motion and `prefers-reduced-motion` behavior for spinner and skeleton animation.
- Parent Patterns own placement, sizing context, overlays, disabled dependent controls, and external spacing.
- Do not create raw SVG/CSS spinners, Bootstrap spinners, local skeleton loaders, raw utility clusters, raw colors, or feature-local JavaScript for loading behavior.

### 3.2. Installed modes:

| Mode                       | Status                              | Use                                                                                                           |
| -------------------------- | ----------------------------------- | ------------------------------------------------------------------------------------------------------------- |
| Spinner                    | Implemented                         | Use for indeterminate pending work when the content shape is unknown or the wait belongs to a bounded region. |
| Skeleton text              | Implemented                         | Use when text content is loading and the future text layout is known.                                         |
| Skeleton card              | Implemented                         | Use when a card or tile-like content block is loading.                                                        |
| Skeleton table             | Implemented                         | Use when table rows or tabular data are loading.                                                              |
| Page-region loading        | Implemented                         | Use when a page section is busy and existing or upcoming content must be marked as pending.                   |
| Status handoff             | Implemented as text/state treatment | Use after loading completes or fails when the user needs an immediate outcome cue.                            |
| Full-page blocking overlay | Gated / Pattern-owned               | Requires overlay/focus/inert behavior approval before production use.                                         |

This page must not render `Component-specific API pending correction` as the example call. It must show real loading markup, real class names, state ownership, and deferred gates.

## 4. Public API

### 4.1. API status

The current public API is markup plus app-owned CSS classes. A dedicated Blade component such as `x-ui.loading` or `x-ui.skeleton` is reserved for a future correction pass and must not be used in production until installed, documented, rendered in UI Reference, and tested.

| API surface           | Installed value                                                                               |
| --------------------- | --------------------------------------------------------------------------------------------- |
| Blade                 | No dedicated public Blade wrapper approved yet                                                |
| JavaScript            | No dedicated JavaScript controller required                                                   |
| Data attributes       | None approved for behavior                                                                    |
| Props/options         | No Blade props; use documented class modes and native semantics                               |
| Slots                 | Not applicable until a Blade wrapper is installed                                             |
| Root semantic element | Native `div`, `section`, `tbody`, or context-appropriate container with status semantics      |
| CSS namespace         | `ui-loading*` and `ui-skeleton*`                                                              |
| Source files          | `resources/css/app.css`; `resources/views/platform/ui-reference/components/loading.blade.php` |

Feature views may use canonical loading markup directly when a Pattern has not wrapped it. Do not create local loading partials or helper components. If the same loading composition is repeated across features, move it into the owning Pattern or install a public Blade wrapper through the gate in this standard.

### 4.2. Canonical spinner

Use a spinner when work is indeterminate and the shape of incoming content is not useful to preview.

```blade
<div class="ui-loading ui-loading--spinner ui-loading--lg" role="status" aria-live="polite">
    <span class="ui-loading__spinner" aria-hidden="true"></span>
    <span class="ui-loading__label">Loading account summary</span>
</div>
```

Use specific labels. `Loading account summary` is better than `Loading` because it names the pending target.

### 4.3. Localized spinner

Use the small spinner for localized pending work near a region or piece of content. Do not use it inside a submit button unless the Button or Inline loading API owns that behavior.

```blade
<div class="ui-loading ui-loading--spinner ui-loading--sm" role="status" aria-live="polite">
    <span class="ui-loading__spinner" aria-hidden="true"></span>
    <span class="ui-loading__label">Checking invitation status</span>
</div>
```

### 4.4. Skeleton text

Use skeleton text when the final content is text or data copy and the pending shape helps users understand layout continuity.

```blade
<div class="ui-loading ui-loading--skeleton ui-loading--text" role="status" aria-live="polite">
    <span class="ui-loading__label">Loading profile details</span>

    <div class="ui-skeleton ui-skeleton--text" aria-hidden="true">
        <span class="ui-skeleton__line ui-skeleton__line--long"></span>
        <span class="ui-skeleton__line ui-skeleton__line--medium"></span>
        <span class="ui-skeleton__line ui-skeleton__line--short"></span>
    </div>
</div>
```

Skeleton shapes are visual placeholders. They must not contain fake user data, fake table values, or placeholder words that could be mistaken for loaded content.

### 4.5. Skeleton card

Use skeleton card for card, tile, or dashboard panel content that is loading.

```blade
<div class="ui-loading ui-loading--skeleton ui-loading--card" role="status" aria-live="polite">
    <span class="ui-loading__label">Loading workspace card</span>

    <article class="ui-skeleton ui-skeleton--card" aria-hidden="true">
        <span class="ui-skeleton__block ui-skeleton__block--media"></span>
        <span class="ui-skeleton__line ui-skeleton__line--medium"></span>
        <span class="ui-skeleton__line ui-skeleton__line--short"></span>
    </article>
</div>
```

### 4.6. Skeleton table

Use skeleton table when table rows are loading and the column structure is already known.

```blade
<div class="ui-loading ui-loading--skeleton ui-loading--table" role="status" aria-live="polite">
    <span class="ui-loading__label">Loading users table</span>

    <div class="ui-skeleton ui-skeleton--table" aria-hidden="true">
        <span class="ui-skeleton__row"></span>
        <span class="ui-skeleton__row"></span>
        <span class="ui-skeleton__row"></span>
    </div>
</div>
```

Do not skeletonize table actions, menus, checkboxes, toggles, or other action controls. The pending data area can use a skeleton; interactive controls should be unavailable, hidden, or left as stable structure according to the Data table or parent Pattern.

### 4.7. Page-region loading

Use `ui-loading-region` when an existing region becomes busy or when a section of a page is reserved for content that has not loaded yet.

```blade
<section class="ui-loading-region" aria-busy="true" aria-describedby="users-loading-state">
    <div id="users-loading-state" class="ui-loading ui-loading--spinner ui-loading--lg" role="status" aria-live="polite">
        <span class="ui-loading__spinner" aria-hidden="true"></span>
        <span class="ui-loading__label">Loading users</span>
    </div>
</section>
```

When loading completes, remove the loading indicator, render the loaded content, set `aria-busy="false"` or remove `aria-busy`, and provide a completion cue when the update is not otherwise obvious.

### 4.8. Status handoff

Use status handoff text when loading completes, fails, or requires a next step. Use Notification when the message is persistent, dismissible, global, or visually prominent.

```blade
<div class="ui-loading ui-loading--success" role="status" aria-live="polite">
    <span class="ui-loading__label">Users loaded</span>
</div>
```

```blade
<div class="ui-loading ui-loading--error" role="status" aria-live="polite">
    <span class="ui-loading__label">Could not load users. Try again.</span>
</div>
```

Status handoff classes are not decorative color variants. They communicate the immediate result of a loading operation. Longer recovery or outcome content belongs to Notification or the parent Pattern.

### 4.9. Class contract

| Class                       | Type                    | Status      | Purpose                                          |
| --------------------------- | ----------------------- | ----------- | ------------------------------------------------ |
| `ui-loading`                | Root                    | Implemented | Base loading/status wrapper.                     |
| `ui-loading-region`         | Region                  | Implemented | Marks the affected page or content region.       |
| `ui-loading--spinner`       | Mode                    | Implemented | Indeterminate spinner mode.                      |
| `ui-loading--skeleton`      | Mode                    | Implemented | Skeleton placeholder mode.                       |
| `ui-loading--sm`            | Size                    | Implemented | Localized/small spinner or compact status.       |
| `ui-loading--lg`            | Size                    | Implemented | Section/page-region spinner or prominent status. |
| `ui-loading--text`          | Skeleton shape modifier | Implemented | Text skeleton composition.                       |
| `ui-loading--card`          | Skeleton shape modifier | Implemented | Card/tile skeleton composition.                  |
| `ui-loading--table`         | Skeleton shape modifier | Implemented | Table/list skeleton composition.                 |
| `ui-loading--loading`       | Status modifier         | Implemented | Explicit active loading state when needed.       |
| `ui-loading--success`       | Status handoff          | Implemented | Completed loading result.                        |
| `ui-loading--error`         | Status handoff          | Implemented | Loading failed and recovery is needed.           |
| `ui-loading--warning`       | Status handoff          | Implemented | Loading completed with a non-blocking concern.   |
| `ui-loading--info`          | Status handoff          | Implemented | Loading requires neutral follow-up information.  |
| `ui-loading__spinner`       | Element                 | Implemented | Token-backed spinner graphic.                    |
| `ui-loading__label`         | Element                 | Implemented | Visible or component-owned status text.          |
| `ui-skeleton`               | Root                    | Implemented | Base skeleton placeholder.                       |
| `ui-skeleton--text`         | Skeleton shape          | Implemented | Text skeleton shape.                             |
| `ui-skeleton--card`         | Skeleton shape          | Implemented | Card skeleton shape.                             |
| `ui-skeleton--table`        | Skeleton shape          | Implemented | Table skeleton shape.                            |
| `ui-skeleton__line`         | Element                 | Implemented | Text placeholder line.                           |
| `ui-skeleton__line--long`   | Element modifier        | Implemented | Long placeholder line.                           |
| `ui-skeleton__line--medium` | Element modifier        | Implemented | Medium placeholder line.                         |
| `ui-skeleton__line--short`  | Element modifier        | Implemented | Short placeholder line.                          |
| `ui-skeleton__block`        | Element                 | Implemented | Card/media placeholder block.                    |
| `ui-skeleton__row`          | Element                 | Implemented | Table/list placeholder row.                      |

Feature views must not create additional `ui-loading-*` or `ui-skeleton-*` classes. New classes require source implementation, this standard update, UI Reference proof, and tests.

### 4.10. Option contract

Because no public Blade wrapper is installed, these are class/markup options rather than Blade props.

| Option         | Type            | Default                                   | Allowed values                                         | Required                                        | Notes                                                       |
| -------------- | --------------- | ----------------------------------------- | ------------------------------------------------------ | ----------------------------------------------- | ----------------------------------------------------------- |
| Mode           | Class modifier  | `spinner` when a loading block is present | `spinner`, `skeleton`, `page-region`, `status handoff` | Yes                                             | Choose the smallest mode that explains the pending work.    |
| Spinner size   | Class modifier  | `lg` for section loading                  | `sm`, `lg`                                             | No                                              | `sm` is localized; `lg` is section/page-region.             |
| Skeleton shape | Class modifier  | None                                      | `text`, `card`, `table`                                | Required for skeleton mode                      | Shape must match the incoming content structure.            |
| Status         | Class modifier  | `loading`                                 | `loading`, `success`, `error`, `warning`, `info`       | No                                              | Status modifiers are for pending/result handoff only.       |
| Label          | Text content    | None                                      | Specific status text                                   | Yes                                             | Label names the pending target or result.                   |
| Live region    | Native ARIA     | `polite` for most loading updates         | `polite`, `assertive` by exception                     | Contextual                                      | Use `assertive` only for blocking or urgent status changes. |
| Busy region    | Native ARIA     | Not set                                   | `aria-busy="true"` on affected region                  | Required when existing content is being updated | Clear when loading completes.                               |
| Motion         | CSS media query | Animated                                  | Reduced when user prefers reduced motion               | Required                                        | Must respect `prefers-reduced-motion`.                      |

Any API not listed here is not public. If a feature needs a new loading shape, wrapper, status, data attribute, or JavaScript behavior, update the component implementation, this standard, UI Reference proof, and tests before production use.

### 4.11. Reserved future Blade contract

The following names are reserved for a future correction pass. They are not production APIs today.

| Reserved API          | Current status | Gate                                                                                                                |
| --------------------- | -------------- | ------------------------------------------------------------------------------------------------------------------- |
| `x-ui.loading`        | Deferred       | Requires source file, public props, slots, class mapping, accessibility behavior, UI Reference examples, and tests. |
| `x-ui.loading-region` | Deferred       | Requires region semantics, busy-state handling, completion behavior, overlay boundary rules, and tests.             |
| `x-ui.skeleton`       | Deferred       | Requires shape props, hidden/visible label behavior, reduced-motion behavior, and tests.                            |
| `x-ui.skeleton-table` | Deferred       | Requires Data table Pattern alignment, row/column options, responsive behavior, and tests.                          |

Do not create feature-local Blade components with these names.

## 5. Allowed variants, options, and modifiers

| Name                           | Type                  | Status                | API                                                            | Notes                                                                                    |
| ------------------------------ | --------------------- | --------------------- | -------------------------------------------------------------- | ---------------------------------------------------------------------------------------- |
| Spinner                        | Mode                  | Implemented           | `ui-loading ui-loading--spinner`                               | Indeterminate loading indicator.                                                         |
| Small spinner                  | Size                  | Implemented           | `ui-loading--sm`                                               | Localized loading near a content region.                                                 |
| Large spinner                  | Size                  | Implemented           | `ui-loading--lg`                                               | Section or page-region loading.                                                          |
| Skeleton text                  | Mode/shape            | Implemented           | `ui-loading--skeleton ui-loading--text`; `ui-skeleton--text`   | Text/data copy placeholders.                                                             |
| Skeleton card                  | Mode/shape            | Implemented           | `ui-loading--skeleton ui-loading--card`; `ui-skeleton--card`   | Card/tile placeholders.                                                                  |
| Skeleton table                 | Mode/shape            | Implemented           | `ui-loading--skeleton ui-loading--table`; `ui-skeleton--table` | Table/list row placeholders.                                                             |
| Page-region loading            | Composition           | Implemented           | `ui-loading-region` with `aria-busy`                           | Marks a busy page section.                                                               |
| Loading status                 | State                 | Implemented           | `ui-loading--loading` or spinner/skeleton mode                 | Pending work is active.                                                                  |
| Success handoff                | Status                | Implemented           | `ui-loading--success`                                          | Use only as immediate completion text; use Notification for persistent outcomes.         |
| Error handoff                  | Status                | Implemented           | `ui-loading--error`                                            | Use only for immediate failure text; use Notification for recovery flows.                |
| Warning handoff                | Status                | Implemented           | `ui-loading--warning`                                          | Use for non-blocking pending result concerns.                                            |
| Informational handoff          | Status                | Implemented           | `ui-loading--info`                                             | Use for neutral loading result/status details.                                           |
| Reduced-motion                 | State/user preference | Implemented           | CSS `prefers-reduced-motion` behavior                          | Animation reduces or changes to non-motion treatment automatically.                      |
| Inline action loading          | Boundary              | Not owned by Loading  | Use Inline loading or Button loading                           | Do not build inline button replacements with this API.                                   |
| Full-page blocking overlay     | Composition           | Gated / Pattern-owned | None                                                           | Requires overlay, inert, scroll, and focus behavior proof.                               |
| Determinate progress           | Component boundary    | Not owned by Loading  | Progress indicator when installed                              | Loading is indeterminate only.                                                           |
| Custom skeleton shape          | Extension             | Gated                 | None                                                           | Requires source implementation, tokens, responsive proof, and UI Reference examples.     |
| Skeleton form controls         | Usage                 | Not allowed           | None                                                           | Do not skeletonize buttons, inputs, menus, toggles, checkboxes, radios, or modal shells. |
| Multiple simultaneous spinners | Usage                 | Not allowed           | None                                                           | Use one loading message for the affected region.                                         |

## 6. States

| State                       | Status                            | Implementation requirement                                                                                                                  |
| --------------------------- | --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| Default / inactive          | Implemented as absence            | Do not render a loading indicator when no work is pending.                                                                                  |
| Loading / active            | Implemented                       | Render spinner, skeleton, or region loading with status text and token-backed motion.                                                       |
| Skeleton                    | Implemented                       | Render a shape that approximates the incoming content and is hidden from assistive tech when status text already conveys the loading state. |
| Success                     | Implemented as handoff            | Communicate completion briefly when the loaded content or focus change does not already make completion clear.                              |
| Error                       | Implemented as handoff            | Explain that loading failed and provide a recovery path or route to Notification/Pattern-owned recovery.                                    |
| Warning                     | Implemented as handoff            | Communicate non-blocking concerns after loading completes.                                                                                  |
| Informational               | Implemented as handoff            | Communicate neutral status or next-step context.                                                                                            |
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
| Color       | Spinner stroke, skeleton surface, skeleton pulse, loading text, status handoff text/border/background, disabled-region contrast, and theme-specific overlay roles when approved by a Pattern. |
| Spacing     | Spinner-label gap, skeleton line gaps, skeleton card internal spacing, table skeleton row spacing, and region padding when the component owns internal spacing.                               |
| Typography  | Loading label, status handoff text, concise recovery copy, and hidden/visible assistive text sizing where applicable.                                                                         |
| Themes      | Light, dark, and inverse token resolution for spinner, skeleton, text, and status handoff states.                                                                                             |
| Motion      | Spinner rotation, skeleton pulse/shimmer, state entry/exit timing, and reduced-motion behavior.                                                                                               |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$interactive` | Large/small loading indicator stroke | `ui-loading--spinner`, spinner stroke role | App interactive/action palette | Same role / app value | Spinner stroke uses the global interactive role, not arbitrary brand colors. |
| `$layer-accent` | Small loading indicator background | Loading indicator background role | App layer accent palette | Same role / app value | Indicator background shares layer accent mapping. |
| `$overlay` | Page loading overlay | Overlay Pattern role / `--ui-overlay` when installed | App overlay palette | Same role / app value | Overlay use is Pattern-gated; Loading does not create local scrims. |
| `$skeleton-background`, `$skeleton-element` | Skeleton container/element surfaces | `ui-loading--skeleton`, `--ui-skeleton-*` when installed | App skeleton palette | Same role / app value | Skeleton roles are Loading/Skeleton-owned, not generic gray blocks. |
| `$text-secondary`, `$text-primary` | Loading label and status handoff text | Loading text roles | App text palette | Same role / app value | Loading copy follows text hierarchy. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation.

```css
.ui-loading
.ui-loading-region
.ui-loading--spinner
.ui-loading--skeleton
.ui-loading--sm
.ui-loading--lg
.ui-loading--text
.ui-loading--card
.ui-loading--table
.ui-loading--loading
.ui-loading--success
.ui-loading--error
.ui-loading--warning
.ui-loading--info
.ui-loading__spinner
.ui-loading__label
.ui-skeleton
.ui-skeleton--text
.ui-skeleton--card
.ui-skeleton--table
.ui-skeleton__line
.ui-skeleton__line--long
.ui-skeleton__line--medium
.ui-skeleton__line--short
.ui-skeleton__block
.ui-skeleton__block--media
.ui-skeleton__row
```

Feature views must not create `spinner-*`, `loader-*`, `skeleton-*`, `placeholder-*`, Bootstrap `.spinner-border`, Bootstrap `.placeholder`, direct Carbon production classes, raw SVG loaders, local keyframes, arbitrary animation durations, raw hex colors, arbitrary spacing, custom focus rings, or feature-local loading classes for the same UI role.

### 7.4. Helper usage

| Helper/mechanism                      | Status                                             | Rule                                                                                                                                       |
| ------------------------------------- | -------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |
| Native `role="status"`                | Approved                                           | Use for loading status text that should be announced.                                                                                      |
| Native `aria-live`                    | Approved                                           | Use `polite` for most loading updates and `assertive` only for blocking or urgent conditions.                                              |
| Native `aria-busy`                    | Approved                                           | Apply to the affected region while content is loading; clear when complete.                                                                |
| Native `aria-hidden="true"`           | Approved for decorative skeleton/spinner internals | Hide purely visual spinner/skeleton shapes when label/status text communicates meaning.                                                    |
| Component-owned hidden text           | Approved if implemented by the CSS API             | Use only the app-owned hidden-text class documented by implementation; do not create ad hoc screen-reader utility classes in features.     |
| JavaScript polling/loading controller | Not approved as Loading API                        | Feature or Pattern behavior may fetch data, but it must not create a new Loading Component JavaScript API without documentation and tests. |
| `data-ui-loading-*` attributes        | Not approved                                       | Add only through a future documented JavaScript/data-attribute gate.                                                                       |

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
- The page needs a blocking overlay; use an approved overlay Pattern before production use.
- The content is actually empty after loading; use the correct Empty state or Pattern.

### 9.3. Mode selection:

| Need                                                    | Use                                  |
| ------------------------------------------------------- | ------------------------------------ |
| Unknown or short indeterminate pending work in a region | Spinner                              |
| Localized status near a small content area              | Small spinner                        |
| Section or page-region pending state                    | Large spinner or page-region loading |
| Text or metadata loading                                | Skeleton text                        |
| Card, tile, dashboard panel, or summary block loading   | Skeleton card                        |
| Tabular rows or list-like data loading                  | Skeleton table                       |
| Button submit/action pending                            | Button loading or Inline loading     |
| Long operation with known steps or percent              | Progress indicator                   |
| Persistent result or recovery message                   | Notification                         |

### 9.4. Status selection:

| Need                                               | Use                                                     |
| -------------------------------------------------- | ------------------------------------------------------- |
| Work is pending                                    | `ui-loading--loading`, spinner, or skeleton mode        |
| Work completed and content update is not obvious   | `ui-loading--success` handoff or Pattern-owned status   |
| Work failed and immediate retry/recovery is needed | `ui-loading--error` handoff or Notification             |
| Work completed with a non-blocking concern         | `ui-loading--warning` handoff or Notification           |
| Work requires neutral context                      | `ui-loading--info` handoff or Pattern-owned helper text |

## 10. Accessibility contract

- Loading components are not interactive and must not receive keyboard focus.
- Every loading state must provide an accessible status through visible text, component-owned assistive text, `role="status"`, `aria-live`, or equivalent Pattern-owned semantics.
- Status text must name the pending target or action.
- Use `aria-busy="true"` on the affected region when existing content is being updated.
- Clear `aria-busy` when loading completes.
- Purely visual spinner and skeleton internals must be hidden from assistive technology when status text already conveys the loading state.
- Do not rely on animation alone to communicate loading.
- Do not rely on color alone for loading, success, error, warning, or info meaning.
- Reduced-motion preferences must be respected for spinner and skeleton animation.
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
- Do not create feature-local `x-ui.loading`, `x-ui.skeleton`, `x-loading`, `x-spinner`, or equivalent wrappers.
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
| Public `x-ui.loading` Blade wrapper            | Deferred              | Requires source file, props, slots, status semantics, class mapping, examples, tests, and migration guidance from direct class markup.          |
| Public `x-ui.loading-region` Blade wrapper     | Deferred              | Requires busy-state semantics, completion behavior, region labeling, overlay boundaries, and tests.                                             |
| Public `x-ui.skeleton` Blade wrapper           | Deferred              | Requires shape props, label behavior, reduced-motion proof, responsive behavior, and tests.                                                     |
| Custom skeleton shape API                      | Gated                 | Requires tokenized dimensions, layout constraints, no fake content, UI Reference matrix, and accessibility proof.                               |
| Full-page blocking overlay                     | Pattern-owned / gated | Requires Overlay/feedback Pattern approval, inert behavior, scroll locking, focus return, status announcement, reduced-motion proof, and tests. |
| Determinate progress or percentage             | Not owned by Loading  | Requires Progress indicator API. Do not add percentage behavior to Loading.                                                                     |
| Inline loading replacement for buttons/actions | Not owned by Loading  | Use Inline loading or Button loading behavior.                                                                                                  |
| Data-fetch JavaScript controller               | Deferred              | Requires documented data attributes, lifecycle events, cancellation/error handling, no feature-local controller forks, and tests.               |
| Loading timeout/escalation behavior            | Gated                 | Requires Pattern owner, Notification handoff, retry/cancel rules, and accessibility proof.                                                      |
| AI generation loading treatment                | Gated                 | Requires AI labeling/explainability standard, status copy rules, cancellation behavior, and UI Reference proof.                                 |
| Additional spinner sizes                       | Not allowed           | Requires Spacing, Typography, Motion, and UI Reference updates.                                                                                 |
| Custom status colors                           | Not allowed           | Requires Color Element standard update and UI Reference proof.                                                                                  |

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

The Loading page is a broad feedback reference page. It should use matrices, grouped examples, state tables, skeleton shape examples, and implementation examples rather than a simple tab-only scaffold.

### 15.1. Required Live examples internal sections:

| Required proof                    | Rendered behavior                                                                                                                                      | Variants/options shown                                                                       |
| --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------- |
| API status proof                  | Page states that Loading is Approved API and currently exposes a class-and-semantics API, not a public Blade wrapper.                                  | `ui-loading`, `ui-skeleton`, deferred `x-ui.loading`                                         |
| Spinner size matrix               | Small and large spinners render with labels and status semantics.                                                                                      | Spinner, Small, Large, Loading                                                               |
| Skeleton shape matrix             | Text, card, and table skeletons render as visual placeholders with status text.                                                                        | Skeleton text, Skeleton card, Skeleton table, Reduced motion                                 |
| Page-region loading               | A busy page section renders with `aria-busy`, status text, and completion guidance.                                                                    | Page-region, Spinner large, Busy region, Completion cue                                      |
| Status handoff matrix             | Loading result states render as immediate text handoffs, with Notification boundary guidance.                                                          | Success, Error, Warning, Info, Loading                                                       |
| Reduced-motion proof              | Spinner and skeleton examples document and demonstrate reduced-motion behavior.                                                                        | Motion, Reduced motion, Skeleton pulse/shimmer replacement                                   |
| Accessibility proof               | Examples show status text, live regions, `aria-busy`, hidden decorative shapes, non-focusable loading roots, and completion announcement requirements. | `role="status"`, `aria-live`, `aria-busy`, `aria-hidden`, completion status                  |
| Content behavior proof            | Examples use specific labels and recovery copy instead of vague loading text.                                                                          | Loading users, Saving profile, Could not load users, Users loaded                            |
| Selection matrix                  | Page distinguishes spinner, skeleton, page-region loading, Inline loading, Progress indicator, Notification, and Empty state use.                      | Spinner, Skeleton, Region, Inline loading boundary, Progress boundary, Notification boundary |
| Prohibited usage proof            | Page shows local spinners, Bootstrap spinners/placeholders, direct Carbon classes, fake skeleton data, and decorative loading as prohibited.           | Raw loaders, Bootstrap, Carbon classes, Fake data, Multiple spinners                         |
| Deferred gate proof               | Page shows trigger conditions for Blade wrappers, overlay loading, custom skeletons, JavaScript, timeouts, and progress.                               | Deferred wrappers, Full-page overlay, Custom skeleton, JS controller, Progress               |
| Foundation Elements proof         | Page shows consumed Foundation Elements and token responsibilities.                                                                                    | Color, Spacing, Typography, Themes, Motion                                                   |
| Developer implementation examples | Canonical class/markup examples render as real code examples and do not include placeholder text.                                                      | Spinner, Skeleton text/card/table, Page-region, Status handoff                               |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed class API, rendered modes, rendered states, prohibited usage, deferred gates, accessibility behavior, reduced-motion behavior, and consumed Foundation Elements.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/loading` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The page identifies Loading as `Approved API`.
- The page states that no dedicated public Blade wrapper is approved yet.
- The page shows the class-and-semantics API with `ui-loading`, `ui-loading-region`, and `ui-skeleton` examples.
- The page renders spinner examples for small and large sizes.
- The page renders skeleton text, skeleton card, and skeleton table examples.
- The page renders page-region loading with `aria-busy` and status text.
- The page renders status handoff examples for success, error, warning, and info.
- The page documents reduced-motion behavior for spinner and skeleton animation.
- The page documents that Loading is non-interactive and must not receive focus.
- The page documents completion handoff requirements when loading disappears.
- The page distinguishes Loading from Inline loading, Button loading, Progress indicator, Notification, and Empty state behavior.
- The page documents prohibited usage for raw spinners, Bootstrap spinners/placeholders, direct Carbon classes, local skeleton classes, fake skeleton content, decorative loading, and multiple simultaneous indicators.
- Tests assert no generic placeholder content appears.
- Tests assert stale labels such as `Component-specific API pending correction`, `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` remain absent.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production class names, Bootstrap spinner classes, Bootstrap placeholder classes, raw hex colors, arbitrary local spacing, local keyframes, or feature-local loading classes are presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/loading');

$response->assertOk();
$response->assertSee('Loading');
$response->assertSee('Approved API');
$response->assertSee('ui-loading');
$response->assertSee('ui-loading-region');
$response->assertSee('ui-skeleton');
$response->assertSee('Spinner');
$response->assertSee('Small spinner');
$response->assertSee('Large spinner');
$response->assertSee('Skeleton text');
$response->assertSee('Skeleton card');
$response->assertSee('Skeleton table');
$response->assertSee('Page-region loading');
$response->assertSee('role=&quot;status&quot;', false);
$response->assertSee('aria-live');
$response->assertSee('aria-busy');
$response->assertSee('Reduced motion');
$response->assertSee('Success');
$response->assertSee('Error');
$response->assertSee('Warning');
$response->assertSee('Info');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Motion');
$response->assertSee('No dedicated public Blade wrapper is approved yet');
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
| Components overview           | `/platform/ui-reference/components`                               |
| Inline loading                | `/platform/ui-reference/components/inline-loading`                |
| Button                        | `/platform/ui-reference/components/button`                        |
| Notification                  | `/platform/ui-reference/components/notification`                  |
| Progress indicator            | `/platform/ui-reference/components/progress-indicator`            |
| Modal                         | `/platform/ui-reference/components/modal`                         |
| Data table                    | `/platform/ui-reference/components/data-table`                    |
| Forms pattern                 | `/platform/ui-reference/patterns/forms`                           |
| Tables Pattern                | `/platform/ui-reference/patterns/tables`                          |
| Overlay and feedback patterns | `/platform/ui-reference/patterns/overlays-feedback`               |
| Layout Pattern                | `/platform/ui-reference/patterns/layout`                          |
| Color element                 | `/platform/ui-reference/elements/color`                           |
| Spacing element               | `/platform/ui-reference/elements/spacing`                         |
| Typography element            | `/platform/ui-reference/elements/typography`                      |
| Themes element                | `/platform/ui-reference/elements/themes`                          |
| Motion element                | `/platform/ui-reference/elements/motion`                          |
| Canonical loading doc         | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Floading.md` |
| Carbon loading usage          | `https://carbondesignsystem.com/components/loading/usage/`        |
| Carbon loading pattern        | `https://carbondesignsystem.com/patterns/loading-pattern/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Loading usage, style, accessibility, and Loading Pattern guidance inform spinner sizing, skeleton selection, multiple-indicator avoidance, status announcements, and reduced-motion requirements. Login App keeps its own class-and-semantics API, `ui-*` namespace, Foundation Element tokens, and UI Reference proof.
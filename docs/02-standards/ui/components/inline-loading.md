---
title: Inline loading
slug: inline-loading
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: feedback-and-loading
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/inline-loading
canonical_doc: docs/02-standards/ui/components/inline-loading.md
source_owner: /platform/ui-reference/components/inline-loading
blade_api:
  - x-ui.inline-loading
javascript_api: []
source_files:
  - resources/views/components/ui/inline-loading.blade.php
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - button
  - notification
  - modal
  - progress-indicator
related_patterns:
  - forms
  - tables
  - overlays-feedback
  - loading
carbon_reference:
  - https://carbondesignsystem.com/components/inline-loading/usage/
  - https://carbondesignsystem.com/components/inline-loading/style/
  - https://carbondesignsystem.com/components/inline-loading/accessibility/
---

# Inline Loading Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. Action replacement example](#42-action-replacement-example)
  - [4.3. API surfaces](#43-api-surfaces)
  - [4.4. Props and options](#44-props-and-options)
  - [4.5. Status contract](#45-status-contract)
  - [4.6. Live-region contract](#46-live-region-contract)
  - [4.7. Label contract](#47-label-contract)
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
  - [9.3. Status selection:](#93-status-selection)
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

Inline loading shows short, local progress for a single pending action or nearby status update without blocking the page.

Canonical API owner: `/platform/ui-reference/components/inline-loading`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Inline loading is the installed Login App 2.0 local pending-status API. It owns compact status semantics, spinner/status-icon treatment, short status copy, live-region behavior, reduced-motion behavior, and token-backed success, error, warning, info, and loading states. It does not own full-page loading, page overlays, skeleton screens, determinate progress, form validation, notification persistence, button hierarchy, table row layout, modal footer layout, or page-level workflow orchestration.

### 1.1. Canonical API responsibilities:

- Render local pending status through `x-ui.inline-loading`.
- Place the status next to, or in place of, the exact action or region that is pending.
- Express the local status through approved semantic `status` values.
- Keep visible status text available for users except in gated compact contexts with an accessible text equivalent.
- Expose status updates through component-owned live-region semantics.
- Respect reduced-motion preferences for animated indicators.
- Disable or replace associated interactive controls while a pending action is active.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and component-owned status icons.
- Prove action-pending, local-save, polite-status, semantic-status, reduced-motion, and developer implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Full-page or blocking loading. Use the Loading Pattern or a page-level loading component when installed.
- Progressive page structure placeholders. Use Skeleton states when implemented and Pattern-approved.
- Persistent success or error messaging. Use Notification, form errors, or Pattern-owned feedback after the inline loading sequence ends.
- Button hierarchy and disabled button styling. Use Button.
- Form layout and validation placement. Use Forms Pattern.
- Modal submission flow, focus return, and footer action placement. Use Modal and Overlay/feedback Patterns.
- Table row action placement and bulk-loading orchestration. Use Data table or Table toolbar Patterns.
- External spacing, alignment, and responsive placement. Parent Patterns own those concerns.

## 2. Status and ownership

| Field                        | Value                                                                             |
| ---------------------------- | --------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                      |
| System maturity              | Partial                                                                           |
| API layer                    | Component API                                                                     |
| Component slug               | inline-loading                                                                    |
| Category                     | Feedback and loading                                                              |
| Priority                     | Tier A - Baseline app development                                                 |
| UI Reference route           | `/platform/ui-reference/components/inline-loading`                                |
| Canonical doc                | `docs/02-standards/ui/components/inline-loading.md`                               |
| Source owner                 | `/platform/ui-reference/components/inline-loading`                                |
| Blade API                    | `x-ui.inline-loading`                                                             |
| JavaScript API               | None required for baseline inline loading behavior                                |
| Source files                 | `resources/views/components/ui/inline-loading.blade.php`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons where status icons are rendered |
| Carbon benchmark             | Carbon Inline loading usage, style, and accessibility guidance                    |

`Approved API` means the installed UI Reference examples exist, but the canonical public API, state definitions, prohibited usage, deferred gates, and regression expectations must be corrected so feature teams do not create local loading markup.

## 3. Installed standard

Inline loading is a compact status component for local actions that finish quickly and do not require a blocking overlay.

### The installed standard is:

- Render inline loading through `<x-ui.inline-loading>`.
- Use the `status` prop to select the approved semantic state.
- Use `status="loading"` while the related action is pending.
- Use `status="success"` for a short local completion message.
- Use `status="error"` for a short local failure message, then move persistent remediation to Notification, form errors, or the owning Pattern.
- Use `status="warning"` for recoverable local delay, retry, or partial-completion messages.
- Use `status="info"` for neutral local progress or queued-status messages.
- Provide short visible text through `label` or the default slot.
- Use component-owned status icons or spinner treatment only; feature views must not inject local icons for the same status role.
- Use a polite live region by default so status changes are announced without moving focus.
- Respect `prefers-reduced-motion` for spinner and transition behavior.
- Disable or replace related interactive controls while the pending action is active.
- Keep the component in the same visual slot as the pending action or local region it describes.
- Do not use inline loading for full-page loads, long-running progress, decorative emphasis, or unrelated status banners.
- Do not use raw utility clusters, raw color values, arbitrary spacing, local icons, or custom JavaScript to create alternate inline loading behavior.

Carbon alignment note: Carbon defines inline loading as a local indicator for an action being processed, commonly used with create, update, delete, table, button, and modal interactions. Carbon states are inactive, active, finished, and error. Login App maps active to `loading`, finished to `success`, keeps `error`, and adds app-approved `warning` and `info` statuses to match the installed semantic feedback set. Login App keeps its own Blade API, `ui-*` class namespace, token names, and UI Reference proof instead of adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical calls

```blade
<x-ui.inline-loading status="loading" label="Saving changes" />
```

```blade
<x-ui.inline-loading status="success" label="Saved" />
```

```blade
<x-ui.inline-loading status="error" label="Save failed" />
```

```blade
<x-ui.inline-loading status="warning" label="Retrying sync" />
```

```blade
<x-ui.inline-loading status="info" label="Sync queued" live="polite" />
```

```blade
<x-ui.inline-loading status="loading">
    Sending invitation
</x-ui.inline-loading>
```

Use the Blade API instead of hand-building spinner markup, local status icons, or feature-specific live regions.

### 4.2. Action replacement example

When a button triggers short local work, replace or disable the associated action in the same visual slot while the work is pending.

```blade
@if ($isSaving)
    <x-ui.inline-loading status="loading" label="Saving changes" />
@else
    <x-ui.button type="submit" semantic="primary">
        Save changes
    </x-ui.button>
@endif
```

When the action completes, render a short completion state only if it helps users understand the local result.

```blade
@if ($saveStatus === 'success')
    <x-ui.inline-loading status="success" label="Saved" />
@elseif ($saveStatus === 'error')
    <x-ui.inline-loading status="error" label="Save failed" />
@endif
```

Persistent error handling belongs to the owning form, notification, or workflow Pattern.

### 4.3. API surfaces

| API surface        | Installed value                                                                                                                                                                                           |
| ------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade API          | `x-ui.inline-loading`                                                                                                                                                                                     |
| JavaScript         | No dedicated JavaScript controller required for baseline behavior                                                                                                                                         |
| Root semantic role | Component-owned status/live-region markup, normally `role="status"` with polite updates                                                                                                                   |
| Data attributes    | Component-owned test hooks only: `data-ui-component="inline-loading"` and `data-ui-status="{status}"` when emitted by the component. Feature views must not use data attributes to create local behavior. |
| CSS namespace      | App-owned `ui-*` inline loading classes documented by the component implementation                                                                                                                        |
| Source files       | `resources/views/components/ui/inline-loading.blade.php`; `resources/css/app.css`                                                                                                                         |

### 4.4. Props and options

| Prop/option  | Type            | Default   | Allowed values                                   | Required                                   | Notes                                                                                                                           |
| ------------ | --------------- | --------- | ------------------------------------------------ | ------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------- |
| `status`     | `string`        | `loading` | `loading`, `success`, `error`, `warning`, `info` | No                                         | Selects the semantic local status. Any status not listed here is not public.                                                    |
| `label`      | `string / null` | `null`    | Short sentence-case status text                  | Required unless default slot provides text | Preferred API for visible text. Keep copy concrete and local to the action.                                                     |
| Default slot | `string / null` | `null`    | Short sentence-case status text                  | Required unless `label` is provided        | Slot text is used as the visible status label when `label` is omitted. Do not pass both with different text.                    |
| `live`       | `string`        | `polite`  | `polite`, `off`                                  | No                                         | Use `polite` for user-visible status updates. Use `off` only when another nearby live region already announces the same status. |
| `id`         | `string / null` | `null`    | Valid document ID                                | No                                         | Use when another region needs `aria-describedby` or test targeting.                                                             |
| `class`      | `string / null` | `null`    | Layout passthrough if supported                  | No                                         | Parent Patterns may pass placement classes. Do not use for local color, typography, motion, icon, state, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.5. Status contract

| Status value | Status      | Purpose                                             | Use when                                                                               | Do not use when                                                                      | Content examples                                            |
| ------------ | ----------- | --------------------------------------------------- | -------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ | ----------------------------------------------------------- |
| `loading`    | Implemented | Active local pending state                          | A single local action or region is processing and expected to complete shortly         | Loading the full page, blocking all interaction, or performing long-running progress | `Saving changes`; `Sending invitation`; `Refreshing status` |
| `success`    | Implemented | Finished local success state                        | A short completion acknowledgement helps users confirm the local action finished       | The success message must persist, include detail, or interrupt the workflow          | `Saved`; `Invitation sent`; `Status refreshed`              |
| `error`      | Implemented | Short local failure state                           | The local action failed and the user needs immediate lightweight feedback              | The error requires remediation, field-level validation, or persistent detail         | `Save failed`; `Upload failed`; `Could not refresh`         |
| `warning`    | Implemented | Recoverable local delay or partial-completion state | A retry, delay, or partial result is happening without requiring immediate user action | A warning must persist or explain a broader system condition                         | `Retrying sync`; `Still connecting`; `Saved locally`        |
| `info`       | Implemented | Neutral local status state                          | The action is queued, scheduled, or waiting on another local condition                 | The message is page-level informational content                                      | `Sync queued`; `Waiting for approval`; `Refresh scheduled`  |

### 4.6. Live-region contract

| Live option             | Status      | Behavior                                             | Use when                                                                   |
| ----------------------- | ----------- | ---------------------------------------------------- | -------------------------------------------------------------------------- |
| `live="polite"`         | Implemented | Announces status text without stealing focus         | Default for visible status updates after a user action                     |
| `live="off"`            | Implemented | Renders visible status without live announcement     | A parent Pattern or adjacent component already announces the same change   |
| Assertive live behavior | Gated       | Requires accessibility review and UI Reference proof | Only for urgent state changes where delayed announcement would create risk |

### 4.7. Label contract

| Label mode               | Status      | Rule                                                                                                                                                                                                                                |
| ------------------------ | ----------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Visible `label` prop     | Implemented | Preferred mode. Use concise, concrete text for every visible status.                                                                                                                                                                |
| Default slot label       | Implemented | Allowed when slot content is the only label source. Keep it text-only or simple inline text.                                                                                                                                        |
| No visible label         | Gated       | Allowed only in compact Pattern-owned contexts where the surrounding field, row, or action already provides visible context and the component supplies an accessible equivalent. Requires UI Reference proof before production use. |
| Long descriptive content | Not allowed | Use Notification, helper text, or Pattern-owned content for detailed explanations.                                                                                                                                                  |

## 5. Allowed variants, options, and modifiers

| Name                          | Type              | Status                                 | API                                                                                | Notes                                                                               |
| ----------------------------- | ----------------- | -------------------------------------- | ---------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------- |
| Loading                       | State             | Implemented                            | `status="loading"`                                                                 | Active local pending state with spinner or equivalent token-backed indicator.       |
| Success                       | State             | Implemented                            | `status="success"`                                                                 | Short local completion state.                                                       |
| Error                         | State             | Implemented                            | `status="error"`                                                                   | Short local failure state; persistent errors move to Notification or Forms Pattern. |
| Warning                       | State             | Implemented                            | `status="warning"`                                                                 | App semantic extension for recoverable local delay/retry/partial completion.        |
| Info                          | State             | Implemented                            | `status="info"`                                                                    | App semantic extension for neutral local queued/waiting state.                      |
| Polite live region            | Modifier          | Implemented                            | `live="polite"`                                                                    | Default status announcement mode.                                                   |
| Live off                      | Modifier          | Implemented                            | `live="off"`                                                                       | Use only when another live region announces the same update.                        |
| Visible label                 | Content option    | Implemented                            | `label="..."` or default slot                                                      | Required for standard usage.                                                        |
| Component-owned status icon   | Internal modifier | Implemented                            | automatic by `status`                                                              | Feature views must not choose local icons.                                          |
| Reduced motion                | State             | Implemented                            | automatic through Foundation Motion                                                | Spinner/transition behavior must respect reduced-motion preferences.                |
| Button/action replacement     | Composition       | Implemented                            | parent conditional rendering                                                       | Replace or disable the triggering action in the same visual slot.                   |
| Disabled dependent controls   | Composition       | Implemented through parent controls    | Use Button or field APIs to disable related controls while loading.                |                                                                                     |
| Compact no-label indicator    | Gated             | no public prop until proof is complete | Requires accessible text equivalent and Pattern-owned context.                     |                                                                                     |
| Skeleton state                | Not owned         | none                                   | Use Skeleton states or Loading Pattern when implemented.                           |                                                                                     |
| Full-page overlay             | Not owned         | none                                   | Use page-level Loading Pattern when implemented.                                   |                                                                                     |
| Determinate progress          | Not owned         | none                                   | Use Progress indicator when progress value matters.                                |                                                                                     |
| Custom status colors          | Not allowed       | none                                   | Requires Color Element update and UI Reference proof.                              |                                                                                     |
| Custom status icons           | Not allowed       | none                                   | Requires Icons Element and component update.                                       |                                                                                     |
| Custom JavaScript transitions | Deferred          | none                                   | Parent framework may change props; component does not own a JavaScript controller. |                                                                                     |

## 6. States

| State              | Status                       | Implementation requirement                                                                                              |
| ------------------ | ---------------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| Loading            | Implemented                  | Renders active local pending indicator, short status text, and polite announcement by default.                          |
| Success            | Implemented                  | Renders token-backed success indicator and completion text. Parent owns how long the success state remains visible.     |
| Error              | Implemented                  | Renders token-backed error indicator and short failure text. Persistent remediation must render outside inline loading. |
| Warning            | Implemented                  | Renders token-backed warning indicator and concise delay/retry/partial-completion text.                                 |
| Info               | Implemented                  | Renders token-backed informational indicator and concise neutral status text.                                           |
| Inactive/idle      | Not rendered                 | Do not render the component when no local pending or status message exists.                                             |
| Reduced motion     | Implemented                  | Spinner and state transitions honor reduced-motion preferences without removing the visible status meaning.             |
| Disabled           | Composition state            | Inline loading is not disabled. Disable or replace associated controls through their own APIs while loading.            |
| Skeleton           | Not owned                    | Skeleton loading belongs to Skeleton states or the Loading Pattern, not Inline loading.                                 |
| Hover              | Not applicable               | Inline loading is not interactive.                                                                                      |
| Focus-visible      | Not applicable               | Inline loading must not receive focus. Associated controls keep their own focus behavior.                               |
| Active/pressed     | Not applicable               | Inline loading is not a command.                                                                                        |
| Read-only          | Not applicable               | Inline loading is status feedback, not editable data.                                                                   |
| Validation         | Not owned                    | Field and form validation belong to Forms Pattern. Inline loading may show short submit failure only.                   |
| Empty              | Not applicable               | Do not render empty inline loading. Provide a label or do not render the component.                                     |
| Overflow/truncated | Implemented by content rules | Keep labels short. Parent containers may wrap, but status text must not be the only hidden indicator.                   |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Inline loading consumes Foundation Color, Spacing, Typography, Themes, Motion, and Icons where the component renders state icons.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons for component-owned status icons or symbols.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                       |
| ----------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Spinner stroke, status icon, status text, success, error, warning, info, disabled-adjacent treatment, and supported theme contrast. |
| Spacing     | Internal icon/text gap, compact status alignment, and local inline rhythm. External spacing remains Pattern-owned.                  |
| Typography  | Compact status label size, line-height, weight, sentence-case rendering, and wrapping behavior.                                     |
| Themes      | Light, dark, and inverse token resolution for every status.                                                                         |
| Motion      | Spinner animation, state transition, and reduced-motion fallback.                                                                   |
| Icons       | Component-owned success, error, warning, and info symbols when rendered.                                                            |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$border-interactive` | Loading spinner stroke | `ui-inline-loading__spinner` stroke role | App border/interactive palette | Same role / app value | Inline spinner stroke must match progress/loading interactive roles. |
| `$border-subtle` | Loading spinner background stroke | `ui-inline-loading__spinner` background stroke | App border palette | Same role / app value | Background stroke uses subtle border role. |
| `$text-secondary` | Inline loading label text | `ui-inline-loading__label` | App text palette | Same role / app value | Loading labels stay secondary text unless status state overrides. |
| `$support-success`, `$support-error`, `$support-warning`, `$support-info` | Finished/status icons and text | Inline loading status classes | App status palette | Same role / app value | Status requires icon/text semantics, not color alone. |

### 7.3. CSS namespace

Allowed component classes must use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-inline-loading
.ui-inline-loading__indicator
.ui-inline-loading__spinner
.ui-inline-loading__icon
.ui-inline-loading__label
.ui-inline-loading--loading
.ui-inline-loading--success
.ui-inline-loading--error
.ui-inline-loading--warning
.ui-inline-loading--info
.ui-inline-loading--reduced-motion
```

Feature views must not create local spinner classes, raw utility clusters, arbitrary color values, arbitrary spacing, custom focus rings, local SVG icons, or feature-specific loading controllers for the same UI role.

## 8. Composition rules

- Inline loading describes one local pending action or nearby status region.
- Place inline loading in the same visual slot as the action, table row, field, modal footer item, or local status that is pending.
- When replacing a button action, preserve layout alignment so content does not jump unnecessarily.
- Disable or replace the related action while `status="loading"` is active to prevent duplicate submissions.
- Disable dependent controls only through their installed component APIs.
- Keep status changes state-driven by server, Livewire, Alpine, or existing app state. Do not attach component-specific JavaScript for baseline inline loading.
- Use `status="success"` only as a short completion acknowledgement. Move persistent success content to Notification or the owning Pattern.
- Use `status="error"` only as short local failure feedback. Move actionable error detail to Notification, form errors, or the owning Pattern.
- Use `status="warning"` only for recoverable delay, retry, or partial completion near the affected action.
- Use `status="info"` only for neutral local queued/waiting status near the affected action.
- Do not show multiple unrelated inline loading indicators at once. Use a parent Pattern, table loading state, skeleton state, or page-level loading treatment when many regions are pending.
- Do not use inline loading as decorative emphasis.
- Components own internal semantics, styling, icon mapping, live-region behavior, and token-backed states.
- Parent Patterns own placement, grouping, external spacing, disabled-control orchestration, success/error persistence, and workflow transitions.

## 9. Selection guidance

### 9.1. Use when:

- A single action is processing and expected to finish shortly.
- A button, table row action, modal action, autosave, or local refresh needs immediate pending feedback.
- A local create, update, delete, send, save, sync, or refresh action needs short status text.
- The pending region is small enough that a page overlay or skeleton would be too disruptive.
- Users need reassurance that the action started, completed, failed, is retrying, or is queued.

### 9.2. Do not use when:

- The entire page or route is loading; use a page-level Loading Pattern when installed.
- Page structure or data blocks are progressively loading; use Skeleton states when implemented.
- Progress is determinate or long-running; use Progress indicator when implemented.
- A message must persist after completion; use Notification, helper text, or Pattern-owned feedback.
- A form field has validation errors; use Forms Pattern validation APIs.
- The status is decorative or only creates visual emphasis.
- Multiple unrelated items are loading at the same time outside an initial refresh or parent-owned bulk loading state.
- The feature needs custom animation, icons, color, or behavior that the component does not expose.

### 9.3. Status selection:

| Need                                                  | Use                                                         |
| ----------------------------------------------------- | ----------------------------------------------------------- |
| Action is currently processing                        | `status="loading"`                                          |
| Action completed successfully                         | `status="success"`                                          |
| Action failed locally                                 | `status="error"` plus persistent error handling when needed |
| Action is retrying, delayed, or partially complete    | `status="warning"`                                          |
| Action is queued, waiting, or informationally pending | `status="info"`                                             |
| No pending or local status exists                     | Do not render Inline loading                                |
| Full-page or structural loading                       | Use Loading Pattern or Skeleton states                      |

## 10. Accessibility contract

- Inline loading is not interactive and must not receive keyboard focus.
- Use component-owned status semantics, normally `role="status"` with `aria-live="polite"`, for user-visible updates.
- Use `live="off"` only when another nearby status region announces the same update.
- Do not use assertive announcements unless an updated standard and accessibility proof explicitly approve them.
- Visible text is required for standard usage. The text must describe the status, not the icon.
- Compact no-label usage is gated and must include an accessible text equivalent plus visible surrounding context.
- When the status changes, the label must change to match the state.
- Do not rely on color alone; status meaning must be carried by text and, where rendered, component-owned icon/state treatment.
- Associated actions and dependent controls must be disabled or replaced during active loading to prevent repeated submission.
- The owning region should use `aria-busy="true"` when a larger local region is pending and the Pattern supports it.
- Focus must remain stable during status updates. Do not move focus to inline loading.
- On error, provide persistent actionable remediation outside inline loading when users need to fix or retry the problem.
- Reduced-motion preferences must be respected without hiding the status meaning.
- Status text must meet contrast requirements in supported light and dark themes.

## 11. Content contract

- Use sentence case.
- Keep labels short and concrete.
- Use present-participle copy for loading states: `Saving changes`, `Sending invitation`, `Refreshing status`.
- Use completed copy for success states: `Saved`, `Invitation sent`, `Status refreshed`.
- Use direct failure copy for error states: `Save failed`, `Could not refresh`, `Upload failed`.
- Use recoverable delay or retry copy for warning states: `Retrying sync`, `Still connecting`, `Saved locally`.
- Use neutral queued/waiting copy for info states: `Sync queued`, `Waiting for approval`, `Refresh scheduled`.
- Prefer specific nouns over vague copy.
- Avoid vague labels such as `Loading`, `Please wait`, `Working`, `Processing`, or `Done` when a more specific action is known.
- Do not expose implementation details such as queue names, job IDs, internal service names, or stack traces.
- Do not use decorative punctuation to create motion or urgency.
- Do not use long instructions inside inline loading. Move detail to helper text, Notification, or the owning Pattern.
- Keep the label synchronized with the status value.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not create feature-local spinner classes or status-icon mappings.
- Do not use inline loading for full-page loading, blocking overlays, or route transitions.
- Do not use inline loading for skeleton screens or progressive page structure placeholders.
- Do not use inline loading for determinate progress or long-running background jobs.
- Do not use inline loading as decorative emphasis.
- Do not render inline loading without understandable status text unless a gated compact Pattern owns the accessible context.
- Do not rely on color alone for success, error, warning, info, or loading meaning.
- Do not leave associated submit or action controls active while `status="loading"` is visible.
- Do not show several unrelated inline loading indicators at once unless a parent Pattern explicitly owns an initial refresh or bulk loading state.
- Do not use inline loading as the only error remediation for actionable failures.
- Do not use status copy that exposes backend implementation details.
- Do not add custom data attributes or JavaScript behavior for local status transitions outside the documented API.

## 13. Deferred or gated capabilities

| Capability                               | Status        | Gate                                                                                                        |
| ---------------------------------------- | ------------- | ----------------------------------------------------------------------------------------------------------- |
| Compact no-visible-label indicator       | Gated         | Requires accessible text equivalent, surrounding visible context, UI Reference proof, and regression tests. |
| Assertive live announcements             | Gated         | Requires accessibility review, documented trigger conditions, and UI Reference proof.                       |
| Automatic success timeout or callback    | Deferred      | Parent state may transition manually. Component-owned timers require source implementation and tests.       |
| Determinate progress value               | Not owned     | Use Progress indicator when implemented. Do not add `percent` or progress-bar behavior to Inline loading.   |
| Full-page loading overlay                | Not owned     | Use Loading Pattern or page-level loading component when implemented.                                       |
| Skeleton placeholder state               | Not owned     | Use Skeleton states when implemented and Pattern-approved.                                                  |
| Bulk list/table loading orchestration    | Pattern-owned | Data table or Table toolbar Pattern must own multi-row or bulk loading behavior.                            |
| Custom status icons                      | Not allowed   | Requires Icons Element update, component implementation update, and UI Reference proof.                     |
| Custom semantic colors                   | Not allowed   | Requires Color Element update and UI Reference proof.                                                       |
| Component-specific JavaScript controller | Deferred      | Requires documented public initializer, events, cleanup behavior, and tests.                                |

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

The Inline loading page is a compact feedback component reference. The Live examples card should use a status matrix plus scenario examples rather than a generic placeholder scaffold. It must show production component examples for implemented states and trigger conditions for deferred or gated capabilities.

### 15.1. Required Live examples internal sections:

| Required proof               | Rendered behavior                                                                                                                        | Variants/options shown                                                               |
| ---------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ |
| Status matrix                | All approved statuses render with short labels, component-owned indicator treatment, and token-backed color/icon semantics.              | Loading, Success, Info, Warning, Error                                               |
| Button/action pending        | A submit or command action is replaced or disabled by inline loading in the same visual slot while work is pending.                      | Loading, Success, Error, disabled associated Button, reduced-motion expectation      |
| Local save pending           | A small autosave or local update region shows pending, completion, retry, and failure text without blocking the page.                    | Loading, Success, Warning, Error, Info                                               |
| Polite status                | Status text updates through polite live-region semantics without moving focus.                                                           | `live="polite"`, `live="off"`, visible label, no focus target                        |
| Reduced-motion behavior      | Animated indicator has a reduced-motion-safe fallback while retaining visible status meaning.                                            | Loading, Success transition, Error transition, reduced-motion state                  |
| Compact/gated no-label proof | The page documents compact no-label trigger conditions instead of presenting it as default production usage unless the gate is complete. | Gated compact indicator, accessible text equivalent, surrounding context             |
| Error handoff                | Short inline failure is paired with Pattern-owned persistent remediation when action is required.                                        | Error state, Notification/Form error relationship                                    |
| Prohibited loading choices   | The page contrasts inline loading with full-page loading, skeleton states, determinate progress, and decorative indicators.              | Not owned: full-page loading, skeleton, determinate progress, decorative spinner     |
| Developer implementation     | Canonical calls and props render as real code examples.                                                                                  | `x-ui.inline-loading`, `status`, `label`, default slot, `live`, `class` restrictions |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered states, allowed options, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/inline-loading` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The status matrix renders loading, success, info, warning, and error examples.
- The button/action pending example disables or replaces the related action while loading is active.
- The local save pending example shows pending, success, warning, error, and info copy without blocking the page.
- The polite status example proves status changes do not move focus and use the component-owned live-region contract.
- Reduced-motion expectations are visible for animated states.
- Compact no-visible-label usage is shown only as gated unless implementation, accessibility proof, and tests are complete.
- Developer examples use `x-ui.inline-loading`, not placeholder comments or ad hoc markup.
- The page does not present skeleton states, full-page overlays, determinate progress, or decorative spinners as Inline loading capabilities.
- Tests assert stale scaffold labels, placeholder pending-correction copy, legacy reference sections, old tier paths, and direct Carbon implementation class prefixes remain absent from rendered approved examples.
- No generic placeholder content appears.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/inline-loading');

$response->assertOk();
$response->assertSee('Inline loading');
$response->assertSee('x-ui.inline-loading');
$response->assertSee('status="loading"');
$response->assertSee('status="success"');
$response->assertSee('status="info"');
$response->assertSee('status="warning"');
$response->assertSee('status="error"');
$response->assertSee('Saving changes');
$response->assertSee('Saved');
$response->assertSee('Save failed');
$response->assertSee('Retrying sync');
$response->assertSee('Sync queued');
$response->assertSee('live="polite"');
$response->assertSee('reduced-motion');
$response->assertSee('Do not use inline loading for full-page loading');
$response->assertDontSee('Component-specific API ' . 'pending correction');
$response->assertDontSee('Live Examples ' . 'Card');
$response->assertDontSee('Reference ' . 'Examples');
$response->assertDontSee('Legacy Contract ' . 'Summary');
$response->assertDontSee('tier' . '-1');
$response->assertDontSee('tier' . '-2');
$response->assertDontSee('cds' . '--');
$response->assertDontSee('bx' . '--');
$response->assertDontSee('TODO');
$response->assertDontSee('Generic fallback');
```

## 17. Related APIs

| API                          | Route                                                                    |
| ---------------------------- | ------------------------------------------------------------------------ |
| Button                       | `/platform/ui-reference/components/button`                               |
| Notification                 | `/platform/ui-reference/components/notification`                         |
| Modal                        | `/platform/ui-reference/components/modal`                                |
| Progress indicator           | `/platform/ui-reference/components/progress-indicator`                   |
| Forms pattern                | `/platform/ui-reference/patterns/forms`                                  |
| Tables Pattern               | `/platform/ui-reference/patterns/tables`                                 |
| Overlay/feedback pattern     | `/platform/ui-reference/patterns/overlays-feedback`                      |
| Loading pattern              | `/platform/ui-reference/patterns/loading`                                |
| Color element                | `/platform/ui-reference/elements/color`                                  |
| Motion element               | `/platform/ui-reference/elements/motion`                                 |
| Components overview          | `/platform/ui-reference/components`                                      |
| Canonical inline loading doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Finline-loading.md` |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Inline loading usage, style, and accessibility guidance inform local pending-state scope, placement, status copy, state mapping, live-region behavior, and reduced-motion expectations. Login App keeps its own Blade API, `ui-*` namespace, semantic status values, token model, and UI Reference proof.
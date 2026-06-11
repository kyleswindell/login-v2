---
title: Progress bar
slug: progress-bar
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: feedback-and-loading
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/progress-bar
canonical_doc: docs/02-standards/ui/components/progress-bar.md
source_owner: /platform/ui-reference/components/progress-bar
blade_api: []
native_api:
  - progress
javascript_api: []
source_files:
  - resources/css/app.css
  - route-owned UI Reference view for /platform/ui-reference/components/progress-bar
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - 2x-grid
related_components:
  - loading
  - inline-loading
  - progress-indicator
  - notification
  - tag
  - button
related_patterns:
  - forms
  - overlays-feedback
  - tables
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/progress-bar/usage/
  - https://carbondesignsystem.com/components/progress-bar/style/
  - https://carbondesignsystem.com/components/progress-bar/accessibility/
  - https://carbondesignsystem.com/components/progress-bar/code/
---

# Progress bar Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. Determinate progress:](#42-determinate-progress)
  - [4.3. Successful completion:](#43-successful-completion)
  - [4.4. Failed completion:](#44-failed-completion)
  - [4.5. API surfaces](#45-api-surfaces)
  - [4.6. Markup and attribute contract](#46-markup-and-attribute-contract)
  - [4.7. Value contract](#47-value-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper ownership](#74-helper-ownership)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Mode selection:](#93-mode-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
  - [11.1. Recommended label/helper patterns:](#111-recommended-labelhelper-patterns)
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

Progress bar shows measurable completion for a long-running task.

Canonical API owner: `/platform/ui-reference/components/progress-bar`. Use this Component API instead of creating local markup, styling, animation, ARIA attributes, value labels, or status behavior for the same UI role.

Progress bar is the installed Login App 2.0 measurable-progress API. It owns determinate progress semantics, track/fill styling, label/helper/value structure, success/error completion status, reduced-motion expectations for motion-bearing states, and token-backed color/spacing/typography behavior. It does not own unknown-duration loading, multi-step workflow progress, skeleton placeholders, toast/status messaging, disabled form controls, or page-level loading orchestration.

### 1.1. Canonical API responsibilities:

- Render measurable task completion with native `<progress>` semantics and app-owned `ui-progress-bar*` classes.
- Communicate progress against a known maximum value.
- Pair the visual bar with an accessible label.
- Show visible value/helper text when the user benefits from knowing percent, fraction, quantity, or completion detail.
- Use success state only when the task has completed successfully.
- Use error state only when a task failed and the helper text explains the issue.
- Keep progress values monotonic for the same task; progress must not jump backward unless the task scope restarts and the copy makes that reset clear.
- Keep indeterminate behavior gated unless the implementation proves animation, reduced-motion, helper text, and accessibility behavior.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and 2x Grid where placement is relevant.
- Prove determinate, completion, error, label, helper, value, reduced-motion, responsive, and implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Unknown-duration waiting where no measurable value exists. Use Loading or Inline loading unless indeterminate Progress bar is explicitly approved for the case.
- Multi-step process navigation or step completion. Use Progress indicator.
- Full-page or blocking loading overlays. Use Loading and Overlay/feedback Patterns.
- Skeleton placeholders for pending content shape. Use Loading or Pattern-owned skeleton states.
- Form-level or request-level error messaging. Use Notification and Forms Pattern.
- Compact status labels. Use Tag.
- Interactive controls, retry buttons, cancel actions, or workflow commands. Use Button or a Pattern-owned composition outside the Progress bar.
- External spacing, layout, placement, polling, upload/download implementation, and progress data ownership. Parent Patterns own those responsibilities.

Carbon alignment note: Carbon defines determinate progress bars for calculable progress from 0% to 100%, indeterminate progress bars for unknown progress, active/success/error statuses, label/helper anatomy, role `progressbar` accessibility behavior, and reduced reliance on visual color alone. Login App maps those completeness principles to native `<progress>` markup, app-owned `ui-*` classes, Foundation tokens, and route-owned UI Reference proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                       |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                |
| System maturity              | Partial                                                                                                     |
| API layer                    | Component API                                                                                               |
| Component slug               | `progress-bar`                                                                                              |
| Category                     | Feedback and loading                                                                                        |
| Priority                     | Tier B - Common reusable component                                                                          |
| UI Reference route           | `/platform/ui-reference/components/progress-bar`                                                            |
| Canonical doc                | `docs/02-standards/ui/components/progress-bar.md`                                                           |
| Source owner                 | `/platform/ui-reference/components/progress-bar`                                                            |
| Blade API                    | No dedicated `x-ui.progress-bar` Blade component is documented as installed                                 |
| Native API                   | `<progress>` wrapped by app-owned `ui-progress-bar*` classes                                                |
| JavaScript API               | No dedicated JavaScript controller required for baseline determinate rendering                              |
| Source files                 | `resources/css/app.css`; route-owned UI Reference view for `/platform/ui-reference/components/progress-bar` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, 2x Grid where composed in layouts                               |
| Carbon benchmark             | Carbon Progress bar usage, style, code, and accessibility guidance                                          |

`Approved API` means the installed route and examples exist, but the canonical standard, UI Reference page, and tests must be corrected so Progress bar is documented as a measurable progress component with explicit value semantics, completion states, accessibility behavior, and deferred indeterminate boundaries instead of placeholder API text.

## 3. Installed standard

Progress bar is represented by native `<progress>` markup and app-owned classes. Do not invent a Blade component call unless a later accepted queue item installs and documents one.

### 3.1. The installed standard is:

- Render determinate progress with a labeled native `<progress>` element.
- Use `.ui-progress-bar` as the required root class for app-owned spacing, layout, text, state, theme, and responsive behavior.
- Use `.ui-progress-bar-control` on the native `<progress>` element.
- Use `value` and `max` for determinate progress.
- Keep `value` between `0` and `max`.
- Use `max="100"` for percentage-based progress unless a real task quantity is clearer.
- Use visible label text for the task being measured.
- Use helper text for quantity, percent, remaining work, error explanation, or completion details where needed.
- Use native `<progress>` fallback text for basic legacy readability, such as `42%`.
- Use `aria-describedby` when helper text adds necessary detail.
- Use `aria-busy="true"` on the related content region when the progress bar describes a pending region.
- Use success styling when completion is confirmed.
- Use error styling when the task fails; error helper text is required.
- Keep the progress bar non-interactive.
- Do not put action buttons, cancel controls, retry controls, links, menus, or form fields inside the progress bar itself.
- Do not use a progress bar for decorative emphasis or static percentages unrelated to an active task.
- Parent Patterns own placement, polling, task state updates, disabled surrounding controls, and workflow orchestration.

## 4. Public API

### 4.1. Canonical calls

### 4.2. Determinate progress:

```blade
<div class="ui-progress-bar">
    <div class="ui-progress-bar-header">
        <span id="export-progress-label" class="ui-progress-bar-label">
            Exporting records
        </span>
        <span class="ui-progress-bar-value">42%</span>
    </div>

    <progress
        class="ui-progress-bar-control"
        value="42"
        max="100"
        aria-labelledby="export-progress-label"
        aria-describedby="export-progress-helper"
    >
        42%
    </progress>

    <p id="export-progress-helper" class="ui-progress-bar-helper">
        42 of 100 records processed.
    </p>
</div>
```

### 4.3. Successful completion:

```blade
<div class="ui-progress-bar ui-progress-bar-success">
    <div class="ui-progress-bar-header">
        <span id="upload-complete-label" class="ui-progress-bar-label">
            Upload complete
        </span>
        <span class="ui-progress-bar-value">100%</span>
    </div>

    <progress
        class="ui-progress-bar-control"
        value="100"
        max="100"
        aria-labelledby="upload-complete-label"
        aria-describedby="upload-complete-helper"
    >
        100%
    </progress>

    <p id="upload-complete-helper" class="ui-progress-bar-helper">
        24 files uploaded successfully.
    </p>
</div>
```

### 4.4. Failed completion:

```blade
<div class="ui-progress-bar ui-progress-bar-danger">
    <div class="ui-progress-bar-header">
        <span id="import-failed-label" class="ui-progress-bar-label">
            Import failed
        </span>
        <span class="ui-progress-bar-value">68%</span>
    </div>

    <progress
        class="ui-progress-bar-control"
        value="68"
        max="100"
        aria-labelledby="import-failed-label"
        aria-describedby="import-failed-helper"
    >
        68%
    </progress>

    <p id="import-failed-helper" class="ui-progress-bar-helper">
        The import stopped because 12 rows could not be validated.
    </p>
</div>
```

Use this native API and `ui-progress-bar*` classes instead of hand-building bar tracks, fills, animation, or ARIA behavior in feature views.

### 4.5. API surfaces

| API surface         | Installed value                                                                                   |
| ------------------- | ------------------------------------------------------------------------------------------------- |
| Blade component     | No dedicated `x-ui.progress-bar` helper is documented as installed                                |
| Root native element | Native `<progress>` inside `.ui-progress-bar`                                                     |
| JavaScript          | No dedicated JavaScript controller required for baseline determinate rendering                    |
| Data attributes     | No public data attributes for baseline Progress bar behavior                                      |
| CSS namespace       | App-owned `ui-progress-bar*` classes documented by this standard and the component implementation |
| Source owner        | `/platform/ui-reference/components/progress-bar`                                                  |
| Token ownership     | Foundation Color, Spacing, Typography, Themes, Motion, and 2x Grid where composed in layouts      |

### 4.6. Markup and attribute contract

| API                         | Type                 | Status                       | Required                                              | Notes                                                                               |
| --------------------------- | -------------------- | ---------------------------- | ----------------------------------------------------- | ----------------------------------------------------------------------------------- |
| `.ui-progress-bar`          | Root class           | Implemented                  | Required                                              | Base layout, spacing, typography, theme, and state contract.                        |
| `.ui-progress-bar-header`   | Structural class     | Implemented / required proof | Optional but preferred                                | Groups label and value where both are visible.                                      |
| `.ui-progress-bar-label`    | Label class          | Implemented                  | Required visible or visually hidden label             | Must identify the task being measured.                                              |
| `.ui-progress-bar-value`    | Value class          | Implemented / required proof | Optional                                              | Use for visible percent, fraction, or quantity.                                     |
| `<progress>`                | Native element       | Implemented                  | Required                                              | Provides accessible progressbar semantics.                                          |
| `.ui-progress-bar-control`  | Native control class | Implemented                  | Required                                              | Applies app-owned track/fill styling.                                               |
| `value`                     | Native attribute     | Implemented                  | Required for determinate                              | Must be numeric and between `0` and `max`. Omit only for gated indeterminate proof. |
| `max`                       | Native attribute     | Implemented                  | Required for determinate                              | Use `100` for percentage or the real total count.                                   |
| `aria-labelledby`           | ARIA relationship    | Implemented                  | Required when the label is outside the native element | Points to the visible/hidden task label.                                            |
| `aria-describedby`          | ARIA relationship    | Implemented                  | Required when helper text is needed                   | Points to helper, error, or completion details.                                     |
| `.ui-progress-bar-helper`   | Helper class         | Implemented / required proof | Optional; required for error and indeterminate states | Gives percent/fraction/detail, error explanation, or pending context.               |
| `.ui-progress-bar-success`  | State class          | Implemented / required proof | Optional                                              | Use only after successful completion is confirmed.                                  |
| `.ui-progress-bar-danger`   | State class          | Implemented / required proof | Optional                                              | Use only when the task fails. Error helper text is required.                        |
| `.ui-progress-bar-small`    | Size modifier        | Implemented / required proof | Optional                                              | Compact progress inside cards, rows, side panels, or dense regions.                 |
| `.ui-progress-bar-inline`   | Alignment modifier   | Gated                        | Optional                                              | Requires UI Reference proof before production use.                                  |
| `.ui-progress-bar-indented` | Alignment modifier   | Gated                        | Optional                                              | Requires UI Reference proof before production use.                                  |
| `aria-busy="true"`          | Region state         | Pattern-owned                | Optional                                              | Apply to the region being updated, not the progress bar itself, when useful.        |

Any class, attribute, prop, or behavior not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.7. Value contract

| Value model         | Status                           | API                                                                           | Use when                                                                 | Do not use when                                                                              |
| ------------------- | -------------------------------- | ----------------------------------------------------------------------------- | ------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------- |
| Percentage          | Implemented                      | `value="42" max="100"`                                                        | Users understand progress as percent complete.                           | Real counts are more concrete or percent is misleading.                                      |
| Count/fraction      | Implemented                      | `value="42" max="100"` plus helper text such as `42 of 100 records processed` | Work is based on known items, files, rows, or steps.                     | The total is unknown or changes during processing.                                           |
| Byte/file transfer  | Implemented / Pattern-owned data | Native value/max with helper text                                             | Upload/download progress can report total and completed work.            | The API cannot provide reliable progress. Use Loading/Inline loading or gated indeterminate. |
| Processing progress | Implemented / Pattern-owned data | Native value/max with helper text                                             | Processing has measurable units or stages.                               | The task is not actually measurable.                                                         |
| Indeterminate       | Gated                            | `<progress>` without `value` only when proved                                 | Unknown progress that still benefits from horizontal progress treatment. | A spinner/loading indicator or inline status message is clearer.                             |

Progress values should increase as work progresses. Do not animate fake percentages to create a sense of progress when the app does not have reliable progress data.

## 5. Allowed variants, options, and modifiers

| Name                            | Type           | Status                                | API                                              | Notes                                                                                                 |
| ------------------------------- | -------------- | ------------------------------------- | ------------------------------------------------ | ----------------------------------------------------------------------------------------------------- |
| Determinate progress            | Mode           | Implemented                           | `<progress value="..." max="...">`               | Primary installed mode for measurable completion.                                                     |
| Active/in progress              | State          | Implemented                           | Base `.ui-progress-bar` with value less than max | Shows work currently progressing.                                                                     |
| Success completion              | State          | Implemented / required proof          | `.ui-progress-bar-success` with completed value  | Use only after confirmed completion.                                                                  |
| Error completion                | State          | Implemented / required proof          | `.ui-progress-bar-danger` with helper text       | Use only when task fails; helper text is required.                                                    |
| Standard height                 | Size           | Implemented                           | Base `.ui-progress-bar-control`                  | Default app progress size.                                                                            |
| Small height                    | Size           | Implemented / required proof          | `.ui-progress-bar-small`                         | Dense cards, rows, side panels, or compact task summaries.                                            |
| Label                           | Content option | Implemented                           | `.ui-progress-bar-label`                         | Required, visible or visually hidden.                                                                 |
| Visible value                   | Content option | Implemented / required proof          | `.ui-progress-bar-value`                         | Percent, fraction, count, or completed quantity.                                                      |
| Helper text                     | Content option | Implemented / required proof          | `.ui-progress-bar-helper`                        | Detail, count, error, completion, or pending context.                                                 |
| Default text alignment          | Layout option  | Implemented                           | Base layout                                      | Label above, bar below, helper close to bar.                                                          |
| Inline text alignment           | Layout option  | Gated                                 | `.ui-progress-bar-inline` if installed           | Requires UI Reference proof before use.                                                               |
| Indented text alignment         | Layout option  | Gated                                 | `.ui-progress-bar-indented` if installed         | Requires UI Reference proof before use.                                                               |
| Indeterminate progress          | Mode           | Gated                                 | `<progress>` without `value` if installed        | Requires helper text, motion, reduced-motion, and accessibility proof.                                |
| Warning progress                | Semantic state | Not installed / use Notification      | none                                             | Use Notification for warning copy around a progress task unless a future progress status is approved. |
| Info progress                   | Semantic state | Not installed / use base active state | none                                             | Progress bar itself is not informational status. Use helper text or Notification.                     |
| Custom track/fill color         | Modifier       | Not allowed                           | none                                             | Color roles are owned by Foundation Color and component implementation.                               |
| Custom animation timing         | Modifier       | Not allowed                           | none                                             | Motion roles are owned by Foundation Motion and component implementation.                             |
| Interactive/cancelable progress | Mode           | Pattern-owned                         | none                                             | Put Button outside the Progress bar in a Pattern-owned layout.                                        |

## 6. States

| State              | Status                                                             | Implementation requirement                                                                                                        |
| ------------------ | ------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------- |
| Default            | Implemented                                                        | Renders label, native `<progress>`, app-owned track/fill styling, and theme-aware text.                                           |
| Active/in progress | Implemented                                                        | Uses determinate value less than max and helper text where useful.                                                                |
| Success            | Implemented / required proof                                       | Shows completed value, success styling, and completion helper text if the confirmation remains visible.                           |
| Error/danger       | Implemented / required proof                                       | Shows error styling and required helper text explaining the failure. Pair with Notification when the user needs correction steps. |
| Warning            | Not installed as a Progress bar state                              | Use Notification or helper text outside the bar for warnings unless a future Component update proves warning styling.             |
| Info               | Not installed as a Progress bar state                              | Use base active/default progress with informational helper text or Notification.                                                  |
| Loading            | Implemented as active determinate progress; indeterminate is gated | Use determinate progress when measurable. Use Loading/Inline loading when progress cannot be measured.                            |
| Skeleton           | Not owned by Progress bar                                          | Use Loading or Pattern-owned skeleton states for pending content shape.                                                           |
| Hover              | Not applicable                                                     | Progress bar is not interactive.                                                                                                  |
| Focus-visible      | Not applicable                                                     | Progress bar is not focusable. Related controls outside the bar own focus behavior.                                               |
| Active/pressed     | Not applicable                                                     | Progress bar is not a command.                                                                                                    |
| Disabled           | Not applicable                                                     | Progress bar is feedback, not a disabled control. Parent Patterns may disable affected controls separately.                       |
| Read-only          | Not applicable                                                     | Progress bar communicates system state; it is not editable.                                                                       |
| Validation         | Pattern-owned                                                      | Progress bar can show failed task state, but validation messages belong to fields/forms and Notification.                         |
| Empty              | Not applicable                                                     | Omit the component when no progress task exists.                                                                                  |
| Overflow/wrapping  | Implemented / required proof                                       | Labels/helper text wrap without clipping; values stay readable.                                                                   |
| Reduced motion     | Implemented / required proof where motion exists                   | Any animated fill or indeterminate state must respect reduced-motion preferences.                                                 |
| Responsive         | Implemented / required proof                                       | Width adapts to parent while preserving minimum readable width and nearby label/helper association.                               |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Progress bar consumes Foundation Color, Spacing, Typography, Themes, Motion, and 2x Grid where composed in layouts.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- 2x Grid where progress bars align inside forms, tables, cards, side panels, overlays, or page sections.

Progress bar does not expose an icon API. Success/error icons may be shown only if the installed implementation owns them; otherwise use helper text and Notification for status detail.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                     |
| ----------- | ----------------------------------------------------------------------------------------------------------------- |
| Color       | Track, fill, text, helper text, success state, error state, focus for adjacent controls, and theme contrast.      |
| Spacing     | Label-to-bar gap, bar-to-helper gap, internal layout, stack gap when delegated by a Pattern, and compact sizing.  |
| Typography  | Label, value, helper text, numeric value alignment, wrapping, and code-snippet examples on the UI Reference page. |
| Themes      | Light/dark token resolution for track, fill, text, helper, success, and error states.                             |
| Motion      | Fill transition, indeterminate animation when approved, completion transition, and reduced-motion behavior.       |
| 2x Grid     | Parent layout alignment, max width, responsive grouping, and placement within cards/tables/side panels.           |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$border-interactive` | Active progress bar fill | `ui-progress-bar-fill` active role | App border/interactive palette | Same role / app value | Active fill must match progress/inline-loading interactive mapping. |
| `$support-success` | Success progress bar fill | `ui-progress-bar-success` | App status palette | Same role / app value | Success is semantic and must pair with label/status text. |
| `$support-error` | Error progress bar fill | `ui-progress-bar-error` | App status palette | Same role / app value | Error is semantic and must pair with label/status text. |
| `$text-primary`, `$text-secondary` | Label, value, helper text | Progress text roles | App text palette | Same role / app value | Text hierarchy remains Color/Typography-owned. |
| `$focus` | Adjacent interactive controls when composed | Consumed through owning control | App focus palette | Same role / app value | Progress bar itself does not invent focus colors. |

### 7.3. CSS namespace

Allowed component classes should use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-progress-bar
.ui-progress-bar-header
.ui-progress-bar-label
.ui-progress-bar-value
.ui-progress-bar-control
.ui-progress-bar-helper
.ui-progress-bar-success
.ui-progress-bar-danger
.ui-progress-bar-small
.ui-progress-bar-inline
.ui-progress-bar-indented
```

Feature views must not create `progress-*`, Bootstrap `.progress` patterns, raw utility clusters, arbitrary track/fill colors, arbitrary widths, custom animation timing, local focus rings, or component-local status treatments for the same UI role.

### 7.4. Helper ownership

| Helper/API                                | Status                         | Rule                                                                                                |
| ----------------------------------------- | ------------------------------ | --------------------------------------------------------------------------------------------------- |
| `x-ui.progress-bar`                       | Not installed / deferred       | Do not call until a future Component standard installs it.                                          |
| Native `<progress>`                       | Implemented                    | Use as the baseline determinate progress element.                                                   |
| `x-ui.loading`                            | Related Component              | Use for full-page or section loading where measurable progress is not available.                    |
| `x-ui.inline-loading`                     | Related Component              | Use for compact local pending status or inline actions.                                             |
| `x-ui.progress-indicator`                 | Related Component if installed | Use for multi-step workflow progress, not measurable task completion.                               |
| `x-ui.notification` / `x-ui.inline-alert` | Related Component              | Use for failure explanation, warning copy, or success messages that need more than progress status. |
| `x-ui.button`                             | Related Component              | Place retry/cancel controls outside the Progress bar in a Pattern-owned composition.                |

## 8. Composition rules

- Use Progress bar only when the app has measurable progress data.
- Use native `<progress>` with `value` and `max` for determinate progress.
- Keep the label close to the progress bar and associate it programmatically.
- Keep helper text close to the progress bar when detail, count, error, or completion context is needed.
- Do not place text inside the track or fill.
- Do not place the label far from the bar.
- Do not use the component as a static metric visualization unrelated to an active or recently completed task.
- Do not use fake progress values when progress cannot be measured.
- Do not animate progress backward. If a task restarts, reset the task copy and progress value intentionally.
- Use success state only after confirmed completion.
- Use error state only after failure; explain the failure in helper text and use Notification where correction is needed.
- Use Loading or Inline loading when no determinate progress is available and indeterminate Progress bar has not been approved for the context.
- Use Progress indicator when the user is moving through steps, not when a system task is measuring completion.
- Keep controls such as Cancel, Retry, View task, or Open report outside the Progress bar component.
- Parent Patterns own external spacing, responsive columns, affected-region disabling, task polling, upload/download events, and workflow orchestration.
- Components own internal semantics, track/fill styling, label/value/helper structure, state styling, reduced-motion behavior, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- A task has a known total and current completion value.
- Users need to understand progress for upload, download, export, import, sync, migration, or batch processing work.
- Progress can be shown as a percentage, fraction, quantity, file count, record count, or known processing count.
- A task may take long enough that visible progress reduces uncertainty.
- The UI needs completion or failure status tied to the same measured task.

### 9.2. Do not use when:

- Progress cannot be measured; use Loading or Inline loading unless indeterminate Progress bar is approved.
- The UI is showing steps in a multi-step process; use Progress indicator.
- The UI needs a skeleton placeholder for content shape; use Loading or Pattern-owned skeleton states.
- The UI needs a notification message without measurable completion; use Notification.
- The UI needs a static metric or percentage visualization; use a data display or chart Pattern when installed.
- The bar is decorative or used only to add visual emphasis.
- The feature needs custom colors, local animation, arbitrary widths, or local track/fill CSS.

### 9.3. Mode selection:

| Need                   | Use                                                                                                  |
| ---------------------- | ---------------------------------------------------------------------------------------------------- |
| Known percent complete | Determinate Progress bar with `value` and `max="100"`                                                |
| Known item count       | Determinate Progress bar with real `value`/`max` and helper text                                     |
| Unknown wait time      | Loading or Inline loading; gated indeterminate Progress bar only when approved                       |
| Full workflow steps    | Progress indicator                                                                                   |
| Final success message  | Progress bar success state when tied to measured task, or Notification for message-only confirmation |
| Failed process         | Progress bar danger state plus helper text, and Notification when correction is needed               |
| Field validation error | Field component and Forms Pattern, not Progress bar                                                  |

## 10. Accessibility contract

- Use native `<progress>` for determinate progress.
- Every progress bar must have an accessible label that identifies the task being measured.
- If the visible label is outside the `<progress>` element, associate it with `aria-labelledby`.
- If helper text, error text, or completion detail is needed, associate it with `aria-describedby`.
- Determinate progress must expose `value` and `max` through the native element.
- Do not use fake text-only bars without progress semantics.
- Do not make the progress bar focusable.
- Do not put interactive controls inside the progress bar.
- Apply `aria-busy="true"` to the affected region when the progress bar describes a specific pending region and that relationship improves assistive technology feedback.
- Error progress requires helper text explaining the problem because color and bar state are not enough.
- Indeterminate progress is gated because it cannot communicate measurable completion. If approved later, it must include helper text that explains what is happening.
- Loading or motion states must expose useful text, not only animation.
- Meaning must not rely on color alone.
- Success/error state must be communicated through text and, where installed, component-owned icon/status treatment.
- Reduced-motion preferences must be respected for fill transitions and any indeterminate animation.
- Labels, values, and helper text must wrap or reflow without clipping in narrow layouts.

## 11. Content contract

- Use sentence case.
- Keep labels short and stable while the task runs.
- Label text should name the process, not the current percent.
- Do not change the label to show success or error; use helper text and state styling for completion outcome.
- Use visible value text when the number helps users understand progress.
- Use helper text for concrete quantities such as `42 of 100 records processed`.
- Use percent text only when the percentage is accurate.
- Avoid vague labels such as `Loading`, `Working`, or `Processing` when a specific task can be named.
- Do not place text inside the progress track or fill.
- Keep error helper text specific enough to explain what stopped.
- Avoid technical error codes unless they help support or troubleshooting.
- Keep toast/notification-style language out of the progress label. Use Notification for full messages.
- If the task restarts or scope changes, update the label/helper text so the progress reset is understandable.

### 11.1. Recommended label/helper patterns:

| Situation | Label                | Helper/value                                                 |
| --------- | -------------------- | ------------------------------------------------------------ |
| Export    | `Exporting records`  | `42 of 100 records processed.`                               |
| Upload    | `Uploading files`    | `8 of 12 files uploaded.`                                    |
| Import    | `Importing contacts` | `68% complete.`                                              |
| Sync      | `Syncing workspace`  | `3 of 5 services synced.`                                    |
| Success   | `Upload complete`    | `24 files uploaded successfully.`                            |
| Error     | `Import failed`      | `The import stopped because 12 rows could not be validated.` |

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local animation, or custom JavaScript.
- Do not create a fake `x-ui.progress-bar` API in feature code.
- Do not use Bootstrap `.progress` or `.progress-bar` classes for app-owned progress bars.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not use progress bars for decorative emphasis.
- Do not use progress bars without an understandable pending region, task, or action context.
- Do not use fake progress percentages for unknown-duration work.
- Do not put text inside the bar track or fill.
- Do not place labels, values, or helper text far from the bar.
- Do not create local track colors, fill colors, success/error colors, or custom warning/info progress states.
- Do not create local reduced-motion exceptions or animation timing.
- Do not make progress bars interactive.
- Do not place Cancel, Retry, View, or Open actions inside the component.
- Do not use Progress bar for multi-step workflow navigation; use Progress indicator.
- Do not use Progress bar for field-level validation or general status messages; use field APIs or Notification.
- Do not render placeholder copy such as `Component-specific API pending correction` or `Allowed variants: None` on the implemented UI Reference page.

## 13. Deferred or gated capabilities

No deferred capability blocks the installed determinate Progress bar API. Future extensions still require an updated Component standard and UI Reference proof before production use.

| Capability                                    | Status                          | Gate                                                                                                                                          |
| --------------------------------------------- | ------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------- |
| Dedicated `x-ui.progress-bar` Blade component | Deferred unless later installed | Requires documented props, slots, native `<progress>` output, accessibility proof, and tests.                                                 |
| Indeterminate Progress bar                    | Gated                           | Requires helper text, reduced-motion behavior, animation rules, accessibility proof, and a selection boundary against Loading/Inline loading. |
| Inline text alignment                         | Gated                           | Requires rendered UI Reference proof in table/dense contexts and responsive wrapping tests.                                                   |
| Indented text alignment                       | Gated                           | Requires rendered UI Reference proof in cards/side panels and responsive wrapping tests.                                                      |
| Warning progress state                        | Not installed / gated           | Requires semantic purpose, token role, content rule, and Notification boundary proof.                                                         |
| Info progress state                           | Not installed / use base state  | Use helper text or Notification instead. Requires future proof before adding semantic styling.                                                |
| Icon status inside Progress bar               | Gated                           | Requires Icons Element mapping, screen-reader behavior, theme proof, and success/error state tests.                                           |
| Cancelable/retryable progress                 | Pattern-owned                   | Requires Button composition outside the component, keyboard behavior, state management, and workflow tests.                                   |
| Programmatic polling/progress updates         | Pattern-owned                   | Requires server/client data owner, update cadence, error handling, and stale-progress behavior.                                               |
| Custom track/fill colors                      | Not allowed                     | Requires Color Element standard update and UI Reference proof.                                                                                |
| Custom animation timing                       | Not allowed                     | Requires Motion Element update and UI Reference proof.                                                                                        |

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

The Progress bar page is a feedback/loading component reference page. It should use determinate examples, state matrices, value/label/helper examples, alignment/size comparison where installed, accessibility proof, reduced-motion proof, and developer implementation examples. It does not need to force every example into the Accordion-style tab model.

### 15.1. Required Live examples internal sections:

| Required proof                   | Rendered behavior                                                                                                                                      | Variants/options shown                                                                                    |
| -------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------- |
| Basic determinate progress       | A labeled native progress bar renders measurable progress with value, max, visible label, and helper text.                                             | Determinate, Standard size, Active/default                                                                |
| Value model comparison           | Percentage and count/fraction examples show different accurate value copy.                                                                             | Percent, Count/fraction, Helper text                                                                      |
| Size comparison                  | Standard and small heights render where implemented.                                                                                                   | Standard, Small                                                                                           |
| State matrix                     | Progress states render with token-backed classes and text support.                                                                                     | Active, Success, Error/danger, Loading boundary                                                           |
| Success completion               | A completed task renders full progress and completion helper text.                                                                                     | Success, 100%, Completion copy                                                                            |
| Error completion                 | A failed task renders error styling and required helper text explaining the failure.                                                                   | Error/danger, Helper text, Notification relationship                                                      |
| Indeterminate boundary           | If indeterminate is not installed, the page shows gated trigger conditions and Loading/Inline loading alternatives instead of a fake complete control. | Gated indeterminate, Loading, Inline loading                                                              |
| Label and helper behavior        | Labels stay close to the bar, helper text stays close to the bar, and text is not embedded in the track.                                               | Label, Value, Helper, No in-track text                                                                    |
| Overflow and responsive behavior | Long labels/helper text wrap without clipping and the bar preserves readable minimum width.                                                            | Wrapping, Responsive, Narrow container                                                                    |
| Reduced-motion behavior          | Motion-bearing fill or indeterminate examples document reduced-motion handling.                                                                        | Fill transition, Reduced motion                                                                           |
| Affected region relationship     | A pending region example shows where `aria-busy` belongs when a section is being updated.                                                              | Related region, `aria-busy`, `aria-describedby`                                                           |
| Developer implementation         | Canonical native calls and class contracts render as token-backed code snippets.                                                                       | `<progress>`, `value`, `max`, label/helper IDs, `ui-progress-bar*` classes                                |
| Prohibited usage proof           | The page calls out non-approved local patterns without rendering them as approved examples.                                                            | No Bootstrap progress classes, no direct Carbon classes, no fake `x-ui.progress-bar`, no fake percentages |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered determinate behavior, rendered completion states, content rules, prohibited usage, deferred gates, related API links, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/progress-bar` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The Component contract card includes Anatomy and States first, followed by Behavior, Developer implementation, Content guidance, and Accessibility requirements.
- The Live examples card may use matrices, comparison grids, state tables, grouped examples, and full-width sections.
- Determinate examples render native `<progress>` with `value`, `max`, an accessible label, and app-owned `ui-progress-bar*` classes.
- Success and error examples render with completion/failure helper text.
- Error state requires helper text and does not rely on color alone.
- Indeterminate behavior is either rendered through an installed Component API or marked gated with Loading/Inline loading alternatives.
- Loading, Inline loading, Progress indicator, and Notification boundaries are visible.
- Content examples show short stable labels, nearby helper text, no in-track text, accurate percent/count values, and wrapping behavior.
- Accessibility examples show `aria-labelledby`, `aria-describedby`, and affected-region `aria-busy` guidance where applicable.
- Developer examples use native `<progress>` and app-owned classes, not placeholder comments or ad hoc local bars.
- No generic placeholder content appears.
- No direct Carbon classes, Bootstrap progress classes, raw utility clusters, hard-coded colors, local animation, fake percentages, or custom JavaScript are presented as approved implementation.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/progress-bar');

$response->assertOk();
$response->assertSee('Progress bar');
$response->assertSee('Determinate progress');
$response->assertSee('ui-progress-bar');
$response->assertSee('ui-progress-bar-control');
$response->assertSee('<progress', false);
$response->assertSee('value');
$response->assertSee('max');
$response->assertSee('Success completion');
$response->assertSee('Error completion');
$response->assertSee('Indeterminate boundary');
$response->assertSee('aria-labelledby');
$response->assertSee('aria-describedby');
$response->assertSee('aria-busy');
$response->assertSee('Reduced motion');
$response->assertSee('Loading');
$response->assertSee('Inline loading');
$response->assertSee('Progress indicator');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Allowed variants: None');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Generic fallback');
$response->assertDontSee('TODO');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('class="progress');
$response->assertDontSee('btn btn-primary');
```

For implementation tests, add page-specific assertions that rendered examples include real native `<progress>` elements rather than only text labels or simulated div-only bars.

## 17. Related APIs

| API                           | Route                                                                  |
| ----------------------------- | ---------------------------------------------------------------------- |
| Components overview           | `/platform/ui-reference/components`                                    |
| Loading                       | `/platform/ui-reference/components/loading`                            |
| Inline loading                | `/platform/ui-reference/components/inline-loading`                     |
| Progress indicator            | `/platform/ui-reference/components/progress-indicator`                 |
| Notification                  | `/platform/ui-reference/components/notification`                       |
| Tag                           | `/platform/ui-reference/components/tag`                                |
| Button                        | `/platform/ui-reference/components/button`                             |
| Forms pattern                 | `/platform/ui-reference/patterns/forms`                                |
| Overlay and feedback patterns | `/platform/ui-reference/patterns/overlays-feedback`                    |
| Tables Pattern                | `/platform/ui-reference/patterns/tables`                               |
| Layout Pattern                | `/platform/ui-reference/patterns/layout`                               |
| Color element                 | `/platform/ui-reference/elements/color`                                |
| Spacing element               | `/platform/ui-reference/elements/spacing`                              |
| Typography element            | `/platform/ui-reference/elements/typography`                           |
| Motion element                | `/platform/ui-reference/elements/motion`                               |
| Themes element                | `/platform/ui-reference/elements/themes`                               |
| 2x Grid element               | `/platform/ui-reference/elements/2x-grid`                              |
| Canonical progress bar doc    | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fprogress-bar.md` |
| Carbon progress bar usage     | `https://carbondesignsystem.com/components/progress-bar/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Progress bar usage, style, code, and accessibility guidance inform determinate/indeterminate boundaries, label/helper anatomy, success/error completion states, text placement, size/alignment considerations, ARIA progressbar behavior, affected-region busy state, and reduced-motion expectations. Login App keeps its own native markup contract, app-owned `ui-*` class namespace, Foundation Element token model, route ownership, and UI Reference proof requirements.
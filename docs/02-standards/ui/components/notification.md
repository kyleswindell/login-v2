---
title: Notification
slug: notification
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: feedback-and-loading
priority: tier-a-baseline-app-development
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/notification.md
source_owner: not installed
blade_api:
  - x-ui.notification.inline
  - x-ui.notification.toast
javascript_api: []
source_files:
  - resources/views/components/ui/notification/inline.blade.php
  - resources/views/components/ui/notification/toast.blade.php
  - resources/views/components/ui/notification/actionable.blade.php
  - resources/views/components/ui/notification/callout.blade.php
  - resources/css/components/notification.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
  - motion
  - 2x-grid
related_components:
  - button
  - link
  - tag
  - inline-loading
  - loading
  - modal
  - tooltip
related_patterns:
  - forms
  - overlays-feedback
  - tables
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/notification/usage/
  - https://carbondesignsystem.com/components/notification/style/
  - https://carbondesignsystem.com/components/notification/accessibility/
  - https://carbondesignsystem.com/components/notification/code/
  - https://carbondesignsystem.com/patterns/notification-pattern/
---

# Notification Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
    - [4.1.1. Inline error/status message:](#411-inline-errorstatus-message)
    - [4.1.2. Inline success message:](#412-inline-success-message)
    - [4.1.3. Inline warning message:](#413-inline-warning-message)
    - [4.1.4. Toast success message:](#414-toast-success-message)
    - [4.1.5. Toast informational message:](#415-toast-informational-message)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
  - [4.4. Semantic contract](#44-semantic-contract)
  - [4.5. Surface contract](#45-surface-contract)
  - [4.6. Slot and content contract](#46-slot-and-content-contract)
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
  - [9.3. Surface selection:](#93-surface-selection)
  - [9.4. Semantic selection:](#94-semantic-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
  - [11.1. Recommended title patterns:](#111-recommended-title-patterns)
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

Notifications communicate system status, task outcomes, validation summaries, errors, warnings, and short background-job messages.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, icons, ARIA behavior, dismiss behavior, motion, or status-color treatment for the same UI role.

Notification is the installed Login App 2.0 feedback API for inline alerts and toast messages. It owns semantic status styling, title/body structure, status icon treatment, role/live-region behavior, dismissibility boundaries, reduced-motion behavior, loading-style feedback where approved, and token-backed color/spacing/typography behavior. It does not own form field-level validation, page-level empty states, modal confirmation flows, progress steps, table row status tags, page header banners, or global notification queue orchestration.

### 1.1. Canonical API responsibilities:

- Render inline task/system feedback through `x-ui.notification.inline`.
- Render non-modal short-lived system feedback through `x-ui.notification.toast`.
- Express message intent through the approved `kind` values.
- Pair semantic text with icon/state treatment so meaning does not rely on color alone.
- Preserve readable title and body structure.
- Use status-appropriate ARIA roles and live-region behavior through the component implementation.
- Keep notification content concise and actionable.
- Keep inline notifications near the related task, form, or content region.
- Keep toast notifications for global, non-blocking messages that do not require immediate user correction.
- Consume Foundation Element APIs for color, spacing, typography, themes, icons, motion, and 2x Grid where placement is relevant.
- Prove inline, toast, semantic, content, accessibility, reduced-motion, loading, and implementation behavior on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Individual field validation messages. Use the installed field/input APIs and Forms Pattern.
- Blocking confirmation or destructive decision flows. Use Modal and Overlay/feedback Patterns.
- Step-by-step task progress. Use Progress indicator or Progress bar.
- Status chips or metadata labels. Use Tag.
- Pending regions without a message. Use Inline loading or Loading.
- Navigation or commands inside the message body. Use Link or Button only when a later actionable notification pattern is explicitly approved.
- Global toast queueing, timed dismissal, stacking, persistence, and delivery from background events. These are Pattern-owned or gated unless a later accepted queue item installs them.
- External page placement, grouping, and workflow orchestration. Parent Patterns own layout.

Carbon alignment note: Carbon separates inline notifications used in task flows from toasts used for short non-modal messages, treats inline/toast notifications as non-interactive by default, documents actionable notifications separately, and expects notification placement, dismissal, and timing to match the message urgency and context. Login App maps those completeness principles to `x-ui.notification.inline` and `x-ui.notification.toast` with app-owned `ui-*` classes, internal icon components, Foundation tokens, and route-owned rendered evidence proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                                            |
| ---------------------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                                     |
| System maturity              | Partial                                                                                                                          |
| API layer                    | Component API                                                                                                                    |
| Component slug               | `notification`                                                                                                                   |
| Category                     | Feedback and loading                                                                                                             |
| Priority                     | Tier A - Baseline app development                                                                                                |
| Rendered evidence route           | `not installed`                                                                                 |
| Canonical doc                | `docs/02-standards/ui/components/notification.md`                                                                                |
| Source owner                 | `not installed`                                                                                 |
| Blade API                    | `x-ui.notification.inline`; `x-ui.notification.toast`                                                                                                |
| JavaScript API               | No dedicated JavaScript controller required for baseline inline alert or toast rendering                                         |
| Source files                 | `resources/views/components/ui/notification/inline.blade.php`; `resources/views/components/ui/notification/toast.blade.php`; `resources/css/components/notification.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons, Motion, 2x Grid where composed in layouts                                             |
| Carbon benchmark             | Carbon Notification usage, style, code, accessibility, and notification pattern guidance                                         |

`Approved API` means the installed Blade components exist, but the canonical standard, rendered evidence page, and tests must be corrected to show Notification as a broad feedback component with inline/toast variants, semantic states, accessibility behavior, content structure, and deferred actionable/queue boundaries instead of placeholder API text.

## 3. Installed standard

Notification requires a matrix-style reference layout because the installed component has two delivery surfaces, multiple semantic intents, status-specific accessibility expectations, content rules, loading-adjacent behavior, and deferred/gated behavior boundaries.

### The installed standard is:

- Render persistent in-flow feedback through `<x-ui.notification.inline>`.
- Render short non-modal system feedback through `<x-ui.notification.toast>`.
- Use the `kind` prop to select message intent.
- Use inline `kind="success"` or toast `kind="success"` for completed work or positive confirmation.
- Use inline `kind="info"` or toast `kind="info"` for neutral system information or guidance.
- Use inline `kind="warning"` or toast `kind="warning"` for recoverable risk, partial completion, or attention-needed states.
- Use inline `kind="error"` or toast `kind="error"` for errors, failed actions, blocked workflows, or destructive consequences.
- Use Inline loading, Loading, Progress bar, or a Pattern-owned loading region for pending states. Notifications may use `kind="info"` only when explanatory pending copy is required.
- Use `title` for the short summary.
- Use the default slot for supporting details or next-step copy.
- Keep inline alerts close to the relevant form, section, table, or task region.
- Keep toast notifications reserved for global, non-blocking system messages that do not need field-level correction.
- Do not place buttons, links, form controls, menus, or rich interactive content inside baseline inline alerts or toasts unless a later actionable notification API explicitly installs that behavior.
- Use the installed status icon treatment. Do not import local icons or invent status icon colors.
- Use component-owned ARIA/live-region behavior. Feature views must not hand-roll roles on notification containers.
- Use Foundation Motion for toast entry/exit where motion exists and respect reduced-motion preferences.
- Parent Patterns own notification placement, stacking, page-region context, and workflow timing.
- Do not use raw utility clusters, raw color values, local icon sources, or feature-local CSS to create notification variants.

## 4. Public API

### 4.1. Canonical calls

#### 4.1.1. Inline error/status message:

```blade
<x-ui.notification.inline kind="error" title="API failure">
    Retry the request or contact support if the issue continues.
</x-ui.notification.inline>
```

#### 4.1.2. Inline success message:

```blade
<x-ui.notification.inline kind="success" title="Record saved">
    Your changes have been saved.
</x-ui.notification.inline>
```

#### 4.1.3. Inline warning message:

```blade
<x-ui.notification.inline kind="warning" title="Review required">
    This workspace is missing a billing contact.
</x-ui.notification.inline>
```

#### 4.1.4. Toast success message:

```blade
<x-ui.notification.toast kind="success" title="Background job completed">
    The export is ready to download.
</x-ui.notification.toast>
```

#### 4.1.5. Toast informational message:

```blade
<x-ui.notification.toast kind="info" title="Maintenance notice">
    Scheduled maintenance begins tonight at 11:00 PM.
</x-ui.notification.toast>
```

Use the Blade APIs instead of hand-building alert/toast markup in feature views.

### 4.2. API surfaces

| API surface                   | Installed value                                                                                                |
| ----------------------------- | -------------------------------------------------------------------------------------------------------------- |
| Inline notification Blade API | `x-ui.notification.inline`                                                                                            |
| Toast notification Blade API  | `x-ui.notification.toast`                                                                                                   |
| JavaScript                    | No dedicated JavaScript controller required for baseline rendering                                             |
| Data attributes               | No public data attributes for baseline Notification behavior unless documented by the component implementation |
| CSS namespace                 | App-owned `ui-*` notification classes documented by the component implementation                               |
| Source owner                  | `not installed`                                                               |
| Token ownership               | Foundation Color, Spacing, Typography, Themes, Icons, Motion, and 2x Grid where composed in layouts            |

### 4.3. Props and options

| Prop/option   | Type                          | Default           | Allowed values                                    | Required                                                             | Notes                                                                                                                            |
| ------------- | ----------------------------- | ----------------- | ------------------------------------------------- | -------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| `semantic`    | `string`                      | `info`            | `success`, `info`, `warning`, `danger`, `loading` | No                                                                   | Selects semantic status, icon, color role, and ARIA/live-region treatment.                                                       |
| `title`       | `string`                      | none              | Short status summary                              | Yes                                                                  | Keep concise. Title should identify the outcome or issue.                                                                        |
| default slot  | `string` / safe Blade content | none              | Short message body                                | No, but strongly recommended for anything beyond simple confirmation | Use for consequence, detail, or next step. Keep non-interactive unless actionable notifications are later installed.             |
| `dismissible` | `bool`                        | component default | `true`, `false`                                   | No if implemented; otherwise gated                                   | Only use when the component implementation provides close behavior and accessible labeling. Do not invent local dismiss buttons. |
| `id`          | `string                       | null`             | generated or omitted                              | Valid DOM id                                                         | No                                                                                                                               | Use only when a parent Pattern needs to associate the notification with a region.                                  |
| `class`       | `string                       | null`             | `null`                                            | Layout passthrough if supported                                      | No                                                                                                                               | Parent Patterns may pass layout classes. Do not use for local color, typography, state, motion, or icon overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the rendered evidence proof before use.

### 4.4. Semantic contract

| Semantic value | Status                       | Purpose                              | Use when                                                                                                          | Do not use when                                                                                                    |
| -------------- | ---------------------------- | ------------------------------------ | ----------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------ |
| `success`      | Implemented                  | Positive confirmation                | A task, save, sync, upload, or background job completed successfully.                                             | The message is neutral information or only indicates that a process started.                                       |
| `info`         | Implemented                  | Neutral information                  | Users need context, a system notice, or non-critical guidance.                                                    | The user must correct something or risk loss/failure.                                                              |
| `warning`      | Implemented                  | Attention-needed or recoverable risk | There is a possible issue, partial state, expiring condition, missing detail, or non-blocking risk.               | The workflow is blocked or failed.                                                                                 |
| `error`        | Implemented                  | Error, failure, or blocked action    | A request failed, form submission failed, access is denied, data may be lost, or the user must correct something. | The message is merely cautionary or informational.                                                                 |

### 4.5. Surface contract

| Surface                 | Status                   | API                 | Use when                                                                                  | Do not use when                                                                                           |
| ----------------------- | ------------------------ | ------------------- | ----------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------- |
| Inline alert            | Implemented              | `x-ui.notification.inline` | Feedback relates to a form, page section, table region, workflow step, or nearby content. | The message is global, short-lived, and unrelated to a specific content area.                             |
| Toast                   | Implemented              | `x-ui.notification.toast`        | A global, non-blocking, short message confirms system-level work or background events.    | The message is critical, long, requires correction, blocks a task, or must remain visible until resolved. |
| Actionable notification | Deferred / Pattern-owned | none                | A message needs buttons, links, or focus management.                                      | Use baseline inline alerts or toasts for non-interactive messages.                                        |
| Page banner             | Pattern-owned            | none                | A whole page or application area needs persistent status.                                 | Use inline alerts for local task feedback.                                                                |
| Field error             | Component/Pattern-owned  | none                | A specific input field has a validation issue.                                            | Use Notification only for validation summaries or form-level failure messages.                            |

### 4.6. Slot and content contract

| Slot/content area    | Status                            | Rule                                                                                                   |
| -------------------- | --------------------------------- | ------------------------------------------------------------------------------------------------------ |
| Status icon          | Implemented                       | Component-owned. Do not pass local icon markup for semantic status.                                    |
| Title                | Implemented                       | Required concise summary.                                                                              |
| Body/default slot    | Implemented                       | Optional supporting detail or next step. Keep short and non-interactive.                               |
| Close/dismiss button | Gated by component implementation | Only render through component-owned `dismissible` behavior where installed.                            |
| Action slot          | Deferred                          | Do not pass buttons, links, menus, or form controls until an actionable notification API is installed. |
| Timestamp/metadata   | Pattern-owned                     | Do not add to baseline notification markup. Use parent Pattern if required.                            |

## 5. Allowed variants, options, and modifiers

| Name                    | Type              | Status                       | API                                          | Notes                                                                           |
| ----------------------- | ----------------- | ---------------------------- | -------------------------------------------- | ------------------------------------------------------------------------------- |
| Inline alert            | Surface variant   | Implemented                  | `x-ui.notification.inline`                          | Persistent in-flow feedback near the related content.                           |
| Toast                   | Surface variant   | Implemented                  | `x-ui.notification.toast`                                 | Non-modal global feedback for short messages.                                   |
| Success                 | Status variant    | Implemented                  | inline `kind="success"`; toast `kind="success"` | Positive completion or confirmation.                                      |
| Info                    | Status variant    | Implemented                  | inline `kind="info"`; toast `kind="info"`       | Neutral context, notices, or guidance.                                    |
| Warning                 | Status variant    | Implemented                  | inline `kind="warning"`; toast `kind="warning"` | Recoverable risk or attention-needed message.                             |
| Error                   | Status variant    | Implemented                  | inline `kind="error"`; toast `kind="error"`   | Error, failed request, blocked flow, or critical issue.                   |
| Loading                 | Related state     | Related API                  | `x-ui.inline-loading`, `x-ui.loading`, Progress bar, or Pattern-owned loading region | Pending status message when message context is needed.                    |
| Title                   | Content option    | Implemented                  | `title="..."`                                | Required summary text.                                                          |
| Body slot               | Content option    | Implemented                  | default slot                                 | Optional detail/next-step text.                                                 |
| Dismissible             | Behavior modifier | Gated by implementation      | `dismissible` if installed                   | Do not invent local close buttons.                                              |
| Auto-dismiss toast      | Behavior modifier | Deferred / Pattern-owned     | none                                         | Requires timing, hover/focus pause rules, reduced-motion behavior, and tests.   |
| Toast queue/stack       | Pattern-owned     | none                         | Requires Overlay/feedback Pattern ownership. |                                                                                 |
| Actionable notification | Mode              | Deferred / Pattern-owned     | none                                         | Requires focus management, keyboard behavior, and separate accessibility proof. |
| Rich text body          | Content option    | Gated                        | none                                         | Only allowed if sanitization and accessibility behavior are documented.         |
| Custom status icon      | Modifier          | Not allowed                  | none                                         | Icons are component-owned and token-backed.                                     |
| Custom semantic color   | Modifier          | Not allowed                  | none                                         | Color roles are owned by the Color Element and component implementation.        |

## 6. States

| State             | Status                                                             | Implementation requirement                                                                                                                                |
| ----------------- | ------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Default           | Implemented                                                        | Renders the selected surface, semantic icon, title, body slot, token-backed spacing, and theme-aware color treatment.                                     |
| Success           | Implemented                                                        | Uses semantic success icon/color role and confirmation copy.                                                                                              |
| Info              | Implemented                                                        | Uses semantic informational icon/color role and neutral copy.                                                                                             |
| Warning           | Implemented                                                        | Uses semantic warning icon/color role and risk/review copy.                                                                                               |
| Error/danger      | Implemented                                                        | Uses semantic danger icon/color role, status behavior, and corrective copy.                                                                               |
| Loading           | Implemented / required proof                                       | Uses a loading semantic/message style only when pending context is needed. Use Loading/Inline loading for pure pending regions.                           |
| Hover             | Not applicable for non-interactive baseline notifications          | Static inline alerts/toasts do not hover. Child interactive elements are deferred/actionable behavior.                                                    |
| Focus-visible     | Implemented only for component-owned dismiss controls if installed | Baseline non-interactive inline/toast notifications do not receive focus. Dismiss controls must show token-backed focus-visible treatment when installed. |
| Active/pressed    | Implemented only for component-owned dismiss controls if installed | Static notifications do not have pressed state.                                                                                                           |
| Disabled          | Not applicable                                                     | Notifications communicate status. They are not disabled controls.                                                                                         |
| Read-only         | Not applicable                                                     | Notifications are message output, not editable data.                                                                                                      |
| Validation        | Implemented as form-level summary only                             | Use danger inline alert for validation summaries; field-level validation belongs to field components and Forms Pattern.                                   |
| Empty             | Not applicable                                                     | Do not render an empty notification. If no message exists, omit the component.                                                                            |
| Dismissed         | Gated by implementation                                            | Only supported when the component owns dismiss behavior. Dismissed content must be removed or hidden accessibly.                                          |
| Overflow/wrapping | Implemented / required proof                                       | Long content wraps; do not truncate essential status text. Toasts must stay short enough to read.                                                         |
| Reduced motion    | Implemented / required proof where motion exists                   | Toast entry/exit or loading animation must respect reduced-motion preferences.                                                                            |
| Responsive        | Implemented / required proof                                       | Inline alerts fill or align to their parent content region; toasts remain readable on narrow screens.                                                     |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Notification consumes Foundation Color, Spacing, Typography, Themes, Icons, Motion, and 2x Grid where composed in layouts.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Icons.
- Motion.
- 2x Grid where notification placement aligns to forms, page sections, overlays, or content columns.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                               |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Semantic success/info/warning/danger/loading surfaces, borders, icons, title/body text, dismiss affordance, focus ring, and theme contrast. |
| Spacing     | Internal padding, icon gap, title/body gap, close-button hit area, stack gap, and parent Pattern placement where delegated.                 |
| Typography  | Title weight, body size, line height, wrapping, and code-snippet examples on the rendered evidence page.                                         |
| Themes      | Light/dark token resolution for surfaces, borders, icons, text, focus, and disabled/dismissed behavior where applicable.                    |
| Icons       | Internal icon components or component-owned icon aliases for semantic status and dismiss controls.                                                |
| Motion      | Productive entry/exit, loading transition, and reduced-motion behavior where motion exists.                                                 |
| 2x Grid     | Alignment of inline notifications to form/page regions and toast placement within overlay/feedback regions.                                 |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$notification-success-background-color` | Low-contrast success notification background | `ui-notification-success`, `--ui-status-success-bg` or notification-owned alias | App status palette | Same role / app value | Notification owns semantic feedback surfaces; Tag/Status may consume separate compact aliases only if documented. |
| `$notification-info-background-color` | Low-contrast information notification background | `ui-notification-info`, `--ui-status-info-bg` or notification-owned alias | App status palette | Same role / app value | Info surfaces must not use arbitrary blue utility classes. |
| `$notification-warning-background-color` | Low-contrast warning notification background | `ui-notification-warning`, `--ui-status-warning-bg` or notification-owned alias | App status palette | Same role / app value | Warning must pair color with icon/text semantics. |
| `$notification-error-background-color` | Low-contrast error notification background | `ui-notification-danger`, `--ui-status-danger-bg` or notification-owned alias | App status palette | Same role / app value | Error/danger naming may differ, but the semantic role must stay consistent. |
| `$background-inverse` | High-contrast notification background | `ui-notification-high-contrast`, inverse notification role when installed | App inverse surface palette | Same role / app value | High-contrast variants are gated until inverse contrast is proven. |
| `$support-success-inverse`, `$support-info-inverse`, `$support-warning-inverse`, `$support-error-inverse` | High-contrast semantic border-left accents | Notification semantic border aliases | App inverse status palette | Same role / app value | Inverse support roles are notification/status-only and must not be decorative. |
| `$focus` | Dismiss/focus affordance | `ui-notification-close:focus-visible`, `--ui-focus` | App focus palette | Same role / app value | Dismiss controls use shared focus roles. |

### 7.3. CSS namespace

Allowed component classes should use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-notification
.ui-notification-inline
.ui-notification-toast
.ui-notification-success
.ui-notification-info
.ui-notification-warning
.ui-notification-danger
.ui-notification-loading
.ui-notification-icon
.ui-notification-title
.ui-notification-body
.ui-notification-close
.ui-notification-stack
```

Feature views must not create `alert-*`, `toast-*`, Bootstrap `.alert` classes, raw utility clusters, arbitrary color classes, local icon sources, local focus rings, or component-local animation timing for the same UI role.

### 7.4. Helper ownership

| Helper/API            | Status            | Rule                                                                                                                        |
| --------------------- | ----------------- | --------------------------------------------------------------------------------------------------------------------------- |
| `x-ui.notification.inline`   | Implemented       | Use for persistent in-flow feedback near related content.                                                                   |
| `x-ui.notification.toast`          | Implemented       | Use for short global non-blocking messages.                                                                                 |
| `x-ui.button`         | Related Component | Do not place inside baseline notifications. Use only if a later actionable notification API installs action support.        |
| `x-ui.link`           | Related Component | Do not place inside baseline notifications unless the component implementation explicitly supports rich/actionable content. |
| `x-ui.inline-loading` | Related Component | Use when pending state is local and does not need a notification message.                                                   |
| `x-ui.loading`        | Related Component | Use for larger pending regions.                                                                                             |
| `x-ui.tag`            | Related Component | Use for compact metadata status, not full message feedback.                                                                 |

## 8. Composition rules

- Use `x-ui.notification.inline` for feedback tied to a specific form, section, data table, card, task, or page region.
- Use `x-ui.notification.toast` for short global messages that confirm background work or non-blocking system state.
- Place inline form validation summaries near the form outcome area and keep field-level errors on the fields themselves.
- Use danger inline alerts for form-level or request-level errors, not for each individual input error.
- Use warning for recoverable risk or missing information that does not fully block the task.
- Use success for completed user actions only after the system confirms the result.
- Use loading notifications sparingly. Prefer Inline loading, Loading, Progress bar, or Progress indicator when pending state is the primary content.
- Keep notification messages non-interactive unless a later actionable notification API owns focus management and actions.
- Do not place a notification inside a button, link, menu item, tab, or field label.
- Do not nest notifications inside other notifications.
- Do not use notifications as decorative callouts or marketing emphasis.
- Do not use toast messages for critical, long, or required-to-read content.
- Parent Patterns own external spacing, placement, stacking, timed delivery, queue management, and workflow orchestration.
- Components own internal semantics, semantic styling, icon placement, title/body structure, close affordance when installed, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- Users need feedback about a completed, failed, pending, blocked, or risky system/task state.
- A form submission needs a summary message in addition to field-level validation.
- A background job completes, fails, or changes state.
- A global non-blocking event should be acknowledged without interrupting the current page.
- A user needs concise next-step copy after a request fails.
- A maintenance or system notice needs semantic status treatment.

### 9.2. Do not use when:

- The message is decorative emphasis; use content styling or a Pattern-owned callout instead.
- The message is only metadata status; use Tag.
- The UI needs a blocking decision, confirmation, or destructive warning; use Modal.
- The UI needs progress over time; use Progress bar or Progress indicator.
- The UI only needs a spinner or skeleton; use Inline loading or Loading.
- The content needs sorting, filtering, or tabular comparison; use Data table.
- The message is field-specific validation; use the field Component and Forms Pattern.
- The message requires actions, focus trapping, or multiple controls; use a future actionable notification API only after it is installed.

### 9.3. Surface selection:

| Need                              | Use                                                                                                                                      |
| --------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| Feedback close to a form or task  | `x-ui.notification.inline`                                                                                                                      |
| Form-level validation summary     | `x-ui.notification.inline kind="error"`                                                                                                    |
| Non-blocking save confirmation    | `x-ui.notification.toast kind="success"` or inline alert when the confirmation must remain near the changed region                                    |
| Recoverable warning in a section  | `x-ui.notification.inline kind="warning"`                                                                                                   |
| Global background job completion  | `x-ui.notification.toast kind="success"`                                                                                                              |
| Global maintenance notice         | `x-ui.notification.toast kind="info"` only for short notice; use page/banner Pattern for persistent critical notices                                  |
| Failed API request                | `x-ui.notification.inline kind="error"` when related to current work; `x-ui.notification.toast kind="error"` only for short global failure notices     |
| Pending process with text context | `x-ui.inline-loading`, `x-ui.loading`, Progress bar, or a Pattern-owned loading region. Use `x-ui.notification.inline kind="info"` only when explanatory message context is required. |

### 9.4. Semantic selection:

| Need                                                 | Use                  |
| ---------------------------------------------------- | -------------------- |
| Completed successfully                               | inline `kind="success"`; toast `kind="success"` |
| Neutral information                                  | inline `kind="info"`; toast `kind="info"`       |
| Attention needed but recoverable                     | inline `kind="warning"`; toast `kind="warning"` |
| Failed, blocked, invalid, or destructive consequence | inline `kind="error"`; toast `kind="error"`   |
| Pending message with necessary context               | Loading component or Pattern-owned loading region; `kind="info"` notification only when explanatory copy is required. |

## 10. Accessibility contract

- The Blade component owns notification semantics and ARIA/live-region behavior. Feature views must not hand-roll `role`, `aria-live`, or focus behavior on notification containers unless the component API documents the option.
- Inline and toast notifications are non-interactive by default and do not receive focus.
- Actionable notifications with links, buttons, or focus management are deferred/Pattern-owned until explicitly installed.
- Success and info notifications should avoid unnecessarily interruptive announcement behavior.
- Danger/error notifications for request failures and validation summaries must be announced according to the component-owned status contract.
- Toasts must not be the only place where critical, long, or required-to-read information appears.
- Toasts with timed behavior must respect reading time, pause/hover/focus expectations where applicable, and reduced-motion preferences before timed dismissal is approved.
- Dismiss controls, if installed, must have an accessible label such as `Dismiss notification`, visible focus, keyboard activation, and at least the app-approved target size.
- Status meaning must not rely on color alone; icon and text must communicate the message intent.
- Icons must be hidden from assistive technology when decorative and named only when the icon itself communicates required status beyond text.
- Title and body text must remain readable in supported light and dark themes.
- Long inline alert content must wrap without clipping.
- Loading notification states must expose pending status through accessible text, not only motion.
- Reduced-motion preferences must be respected for toast entry/exit and loading animation where motion exists.

## 11. Content contract

- Use sentence case.
- Use a concise title that names the state, outcome, or issue.
- Use body copy only when users need consequence, context, or the next step.
- Write success messages as confirmation of work completed, not as praise.
- Write warning messages as recoverable risk or attention-needed copy.
- Write danger/error messages with the failed action and a practical next step when available.
- Do not use vague titles such as `Error`, `Warning`, `Notice`, or `Success` unless no better state-specific title exists.
- Do not use notification text for marketing, decorative emphasis, or page headings.
- Keep toast content short enough to read quickly.
- Keep inline alerts brief enough to scan, but include enough detail to fix the issue.
- Avoid technical error codes in the title. Put codes in body copy only when they help support or troubleshooting.
- Do not put multiple unrelated messages in one notification. Split by task, region, or workflow.
- For form validation summaries, explain the form-level issue and let field-level messages explain individual corrections.
- For destructive consequences, name the object or action directly.

### 11.1. Recommended title patterns:

| Situation               | Preferred title pattern      |
| ----------------------- | ---------------------------- |
| Save completed          | `Record saved`               |
| Upload failed           | `Upload failed`              |
| Validation failure      | `Fix the highlighted fields` |
| Missing setup           | `Billing contact required`   |
| Background job complete | `Export ready`               |
| Maintenance notice      | `Maintenance scheduled`      |
| API failure             | `API request failed`         |

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not use Bootstrap `.alert`, `.toast`, or feature-local `alert-*` | `toast-*` classes for app-owned notifications.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not use feedback components for decorative emphasis.
- Do not use notification status colors as decorative callout colors.
- Do not rely on color alone for meaning.
- Do not use toast notifications for critical, long, blocking, or required-to-read content.
- Do not use loading indicators without an understandable pending region, status message, or action context.
- Do not add buttons, links, menus, form controls, or rich interactive content to baseline notifications.
- Do not invent local dismiss buttons, auto-dismiss timers, toast queues, or stacking behavior.
- Do not place field-specific validation only in a notification; field components must show field-level messages.
- Do not truncate essential notification content.
- Do not create custom semantic colors, custom icons, custom focus rings, or one-off motion timing.
- Do not render placeholder copy such as `Component-specific API pending correction` or `Allowed variants: None` on the implemented rendered evidence page.

## 13. Deferred or gated capabilities

No deferred capability blocks the installed `x-ui.notification.inline` and `x-ui.notification.toast` APIs. Future extensions still require an updated Component standard and rendered evidence proof before production use.

| Capability                  | Status                   | Gate                                                                                                                                    |
| --------------------------- | ------------------------ | --------------------------------------------------------------------------------------------------------------------------------------- |
| Actionable notification     | Deferred / Pattern-owned | Requires separate API, action slot contract, focus management, keyboard behavior, announcement behavior, dismissal behavior, and tests. |
| Toast queue/stack manager   | Pattern-owned            | Requires Overlay/feedback Pattern ownership, placement, z-index/shell rules, stacking, ordering, persistence, and tests.                |
| Auto-dismiss toast timing   | Gated                    | Requires duration rules, pause-on-hover/focus behavior, reduced-motion behavior, critical-content restrictions, and tests.              |
| Programmatic toast dispatch | Deferred                 | Requires server/client event API, queue manager, no duplicate-message strategy, and rendered evidence proof.                                 |
| Rich text body              | Gated                    | Requires sanitization, allowed inline Component list, screen-reader behavior, and wrapping proof.                                       |
| Close/dismiss API           | Gated by implementation  | Requires `dismissible` prop or equivalent, accessible label, focus behavior, and source/tests.                                          |
| Persistent page banner      | Pattern-owned            | Use a Pattern standard before treating page banners as Notification variants.                                                           |
| Custom semantic colors      | Not allowed              | Requires Color Element update and component proof.                                                                                      |
| Custom icons                | Not allowed              | Requires Icons Element update and component proof.                                                                                      |
| Skeleton notification       | Gated                    | Prefer Loading/Inline loading unless a skeleton notification surface is proved by the rendered evidence page.                                |

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

The Notification page is a broad feedback component reference page. It should use semantic matrices, surface comparison, state tables, scenario examples, accessibility examples, content examples, and implementation examples. It does not need to force every example into the Accordion-style tab model.

### 15.1. Required Live examples internal sections:

| Required proof           | Rendered behavior                                                                                                                                           | Variants/options shown                                                                                   |
| ------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------- |
| Surface comparison       | Inline alert and toast examples render side by side with placement notes.                                                                                   | `x-ui.notification.inline`, `x-ui.notification.toast`                                                                        |
| Semantic status matrix   | Every semantic value renders with title, body, status icon, and token-backed theme styling.                                                                 | Success, Info, Warning, Danger, Loading                                                                  |
| Form validation error    | An inline danger alert supports a form-level validation summary without replacing field-level errors.                                                       | Inline alert, Danger, Validation summary                                                                 |
| Record saved             | A success message confirms saved work without decorative copy.                                                                                              | Inline success and/or toast success                                                                      |
| API failure              | A danger message explains failed work and next step.                                                                                                        | Inline danger, Toast danger where global failure applies                                                 |
| Background job completed | A toast communicates non-blocking completion.                                                                                                               | Toast success, short body copy                                                                           |
| Maintenance notice       | A neutral/warning notice communicates short system information and shows when persistent banner behavior is Pattern-owned.                                  | Info, Warning, Toast vs inline selection                                                                 |
| Loading status           | A pending notification message renders only when text context is needed and compares with Inline loading/Loading alternatives.                              | Loading semantic, Inline loading relationship                                                            |
| Dismissible boundary     | If dismissible behavior is installed, a dismiss example shows accessible close labeling and focus. If not installed, the page shows gated boundary content. | Dismissible or Gated dismiss capability                                                                  |
| Reduced-motion behavior  | Motion-bearing examples document/reduce entry/exit or loading animation behavior.                                                                           | Toast motion, Loading motion, Reduced motion                                                             |
| Content behavior         | Titles and bodies show concise sentence-case status copy, wrapping, no truncation, and no vague titles.                                                     | Title, Body, Long copy wrapping, Error code placement                                                    |
| Accessibility behavior   | Examples document non-interactive inline/toast behavior, live-region ownership, color-plus-icon/text meaning, and critical-toast restrictions.              | Roles/live region, Non-interactive baseline, Color-independent meaning                                   |
| Developer implementation | Canonical calls and props render as token-backed code snippets.                                                                                             | `x-ui.notification.inline`, `x-ui.notification.toast`, `kind`, `title`, default slot, gated dismiss |
| Prohibited usage proof   | The page calls out non-approved local patterns without rendering them as approved examples.                                                                 | No Bootstrap alerts/toasts, no direct Carbon classes, no local icons, no custom JS, no fake action slots |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered surfaces, semantic variants, rendered states, content rules, prohibited usage, deferred gates, related API links, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The Component contract card includes Anatomy and States first, followed by Behavior, Developer implementation, Content guidance, and Accessibility requirements.
- The Live examples card may use matrices, comparison grids, state tables, grouped examples, and full-width sections.
- The page renders inline alert and toast examples using `x-ui.notification.inline` and `x-ui.notification.toast`.
- The semantic matrix renders Success, Info, Warning, Danger, and Loading examples.
- The form validation example shows a form-level error summary and does not replace field-level validation.
- The record saved example uses concise success copy.
- The API failure example uses danger semantics and corrective copy.
- The background job example uses a toast only for a short non-blocking message.
- The maintenance example distinguishes short notification behavior from Pattern-owned persistent page banners.
- Loading examples explain when Notification is appropriate versus Inline loading or Loading.
- Accessibility examples state that baseline inline/toast notifications are non-interactive and do not receive focus.
- Dismiss behavior is either rendered through the installed Component API or marked gated; no local dismiss button is presented as approved.
- Actionable notifications are marked deferred/Pattern-owned unless a later standard installs them.
- Developer examples use `x-ui.notification.inline` and `x-ui.notification.toast`, not placeholder comments or ad hoc markup.
- No generic placeholder content appears.
- No direct Carbon classes, Bootstrap alert/toast classes, raw utility clusters, hard-coded colors, local icons, or custom JavaScript are presented as approved implementation.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Notification');
$response->assertSee('x-ui.notification.inline');
$response->assertSee('x-ui.notification.toast');
$response->assertSee('Success');
$response->assertSee('Info');
$response->assertSee('Warning');
$response->assertSee('Danger');
$response->assertSee('Loading');
$response->assertSee('Form validation error');
$response->assertSee('Record saved');
$response->assertSee('API failure');
$response->assertSee('Background job completed');
$response->assertSee('Maintenance notice');
$response->assertSee('Actionable notification');
$response->assertSee('Deferred');
$response->assertSee('Reduced motion');
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
$response->assertDontSee('class="alert');
$response->assertDontSee('class="toast');
```

For implementation tests, add page-specific assertions that rendered examples use the installed Blade APIs and app-owned notification classes rather than only text labels.

## 17. Related APIs

| API                           | Route                                                                  |
| ----------------------------- | ---------------------------------------------------------------------- |
| Components overview           | `not installed`                                    |
| Button                        | `not installed`                             |
| Link                          | `not installed`                               |
| Tag                           | `not installed`                                |
| Inline loading                | `not installed`                     |
| Loading                       | `not installed`                            |
| Modal                         | `not installed`                              |
| Tooltip                       | `not installed`                            |
| Progress bar                  | `not installed`                       |
| Progress indicator            | `not installed`                 |
| Forms pattern                 | `not installed`                                |
| Overlay and feedback patterns | `not installed`                    |
| Tables Pattern                | `not installed`                               |
| Layout Pattern                | `not installed`                               |
| Color element                 | `not installed`                                |
| Spacing element               | `not installed`                              |
| Typography element            | `not installed`                           |
| Icons element                 | `not installed`                                |
| Motion element                | `not installed`                               |
| Themes element                | `not installed`                               |
| 2x Grid element               | `not installed`                              |
| Canonical notification doc    | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fnotification.md` |
| Carbon notification usage     | `https://carbondesignsystem.com/components/notification/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Notification usage, style, code, accessibility, and notification pattern guidance inform inline/toast surface separation, status treatment, placement, non-interactive baseline behavior, actionable notification boundaries, and timing/accessibility concerns. Login App keeps its own Blade API, internal icon standard, notification `kind` prop, app-owned `ui-*` classes, Foundation Element token model, route ownership, and rendered evidence proof requirements.

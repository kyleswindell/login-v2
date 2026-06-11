---
title: Notifications and toasts
slug: notifications-and-toasts
api_layer: Pattern API
status: implemented-standard
system_maturity: implemented
category: overlays-feedback
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/patterns/overlays-feedback
canonical_doc: docs/02-standards/ui/patterns/notifications-and-toasts.md
source_owner: /platform/ui-reference/patterns/overlays-feedback
pattern_api:
  - toast handoff pattern
  - inline notification stack
  - persisted notification reference
  - background job completion handoff
  - system notice banner
required_components:
  - notification
  - inline-loading
  - loading
  - tag
  - button
  - link
  - icon
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - notification
  - tag
  - inline-loading
  - loading
  - button
  - link
related_patterns:
  - feedback
  - overlays-feedback
  - forms
  - table-toolbar
  - page-header
carbon_reference:
  - https://carbondesignsystem.com/components/notification/usage/
  - https://carbondesignsystem.com/components/notification/style/
  - https://carbondesignsystem.com/components/notification/accessibility/
  - https://carbondesignsystem.com/patterns/notification-pattern/
---

# Notifications And Toasts Pattern API
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Pattern API](#4-pattern-api)
  - [4.1. Toast handoff pattern](#41-toast-handoff-pattern)
  - [4.2. Inline notification stack](#42-inline-notification-stack)
  - [4.3. Persisted notification reference](#43-persisted-notification-reference)
  - [4.4. Background job completion handoff](#44-background-job-completion-handoff)
  - [4.5. System notice banner](#45-system-notice-banner)
- [5. Required composition](#5-required-composition)
- [6. Optional composition](#6-optional-composition)
- [7. Consumed Element APIs](#7-consumed-element-apis)
- [8. Owned Component APIs](#8-owned-component-apis)
- [9. Allowed variants and layout options](#9-allowed-variants-and-layout-options)
- [10. State ownership](#10-state-ownership)
- [11. Responsive behavior](#11-responsive-behavior)
- [12. Composition rules](#12-composition-rules)
- [13. Selection guidance](#13-selection-guidance)
- [14. Accessibility contract](#14-accessibility-contract)
- [15. Content contract](#15-content-contract)
- [16. Prohibited usage](#16-prohibited-usage)
- [17. Deferred or gated capabilities](#17-deferred-or-gated-capabilities)
- [18. UI Reference requirements](#18-ui-reference-requirements)
- [19. Testing and acceptance criteria](#19-testing-and-acceptance-criteria)
- [20. Related APIs](#20-related-apis)
- [21. References](#21-references)

## 1. API summary

Notification and toast patterns define transient, inline, persistent, and handoff feedback behavior across workflows.

Canonical Pattern owner: `/platform/ui-reference/patterns/overlays-feedback`. Use this Pattern API when the workflow owns when feedback appears, how long it persists, whether it is dismissible, whether it survives navigation, and where the user should recover from it.

Notifications and toasts are workflow feedback patterns, not primitive visual variants. The Pattern composes approved Notification, Inline loading, Loading, Tag, Button, Link, Icon, and Foundation Element APIs. It does not redefine Notification component status colors, icons, internal spacing, dismissal affordances, or feature-specific business behavior.

Canonical Pattern responsibilities:

- Decide whether a message appears as toast, inline notification, persisted notification reference, job-completion handoff, or system notice banner.
- Define timing, persistence, deduplication, stacking, dismissal, and action handoff rules.
- Preserve workflow context when a message is local to a form, table, detail page, or background operation.
- Prevent duplicate or competing messages for the same event.
- Keep critical errors visible until the user can read and recover.
- Use approved Components and Element tokens rather than local alert/toast markup.
- Prove toast, inline, persisted, background job, and system notice compositions on the UI Reference page.

Non-owned responsibilities:

- Notification visual status variants, icon treatment, close button styling, and local semantics. Notification component owns those.
- Field-specific validation messages. Field Components and Forms Pattern own field validation.
- Exact loading indicators. Loading and Inline loading own local pending states.
- Feature-specific retry, undo, permissions, route generation, and job state. Feature modules own business rules.
- Notification center retention, read/unread state, and routing. Those remain gated until product requirements exist.

## 2. Status and ownership

| Field               | Value                                                                           |
| ------------------- | ------------------------------------------------------------------------------- |
| Status              | Implemented standard                                                            |
| API layer           | Pattern API                                                                     |
| Pattern slug        | notifications-and-toasts                                                        |
| Category            | Overlays and feedback                                                           |
| Priority            | Tier A - Baseline app development                                               |
| Owner route         | `/platform/ui-reference/patterns/overlays-feedback`                             |
| Canonical path      | `docs/02-standards/ui/patterns/notifications-and-toasts.md`                     |
| UI Reference proof  | `/platform/ui-reference/patterns/overlays-feedback`                             |
| Required Components | Notification, Inline loading, Loading, Tag, Button, Link, Icon where applicable |
| Required Elements   | Color, Spacing, Typography, Themes, Motion, Icons                               |
| Carbon benchmark    | Carbon Notification component and notification pattern guidance                 |

`Implemented standard` means the Pattern is approved for workflow-level feedback composition. Feature teams may use the documented Pattern decisions with approved child Components. Feature teams must not create local toast stacks, local alert bars, local persistence behavior, or local notification centers outside this Pattern.

## 3. Installed standard

Use notification patterns when feedback timing, persistence, or destination is owned by a workflow rather than one static alert.

The installed standard is:

- Use inline notifications for messages tied to a visible page region, form, table, or workflow section.
- Use toast handoff only for brief, non-blocking confirmation or neutral updates that do not require recovery.
- Use persisted notification references when a message must survive navigation or represent a background event.
- Use background job completion handoff when work starts locally and completes outside the current view.
- Use system notice banners for page- or app-wide conditions that users need to see before continuing.
- Use actionable notification composition only when the action is optional or recovery-focused and keyboard reachable.
- Use dismiss actions only when dismissal does not hide required recovery information.
- Use undo actions only for reversible operations and only while the undo can still succeed.
- Use view details links when details belong on a durable page or route.
- Deduplicate repeated messages for the same event.
- Keep notification stacks short and prioritized.
- Do not use toast for required validation, destructive confirmation, blocking errors, or critical recovery.
- Do not auto-dismiss critical errors.
- Do not stack multiple competing alerts for one problem.

Carbon alignment note: Carbon distinguishes inline, toast, actionable, and callout notification behaviors. Carbon also separates notification components from notification patterns, defines toast as transient non-modal feedback, and warns that actionable notifications can be disruptive because they contain interactive controls and may take focus. Login App maps those principles to its own Notification Component, Pattern lifecycle rules, `ui-*` namespace, and UI Reference proof instead of adopting Carbon implementation classes directly.

## 4. Pattern API

### 4.1. Toast handoff pattern

Use a toast handoff when a user action completed successfully, failed non-critically, or queued background work and the user can continue without immediate recovery.

```blade
<x-ui.notification
    variant="toast"
    status="success"
    title="Changes saved"
    message="Your profile settings were updated."
    dismissible
/>
```

Pattern requirements:

- Toasts are transient and non-blocking.
- Toasts do not contain required recovery actions.
- Toasts must not cover primary mobile actions.
- Toasts must not steal focus unless a future actionable toast gate is explicitly approved.
- Success toasts should be short and may auto-dismiss when non-critical.
- Error toasts may only be used for non-critical failures with a durable recovery path elsewhere.

### 4.2. Inline notification stack

Use an inline notification stack when multiple workflow-level messages belong to the same page region.

```blade
<div class="ui-feedback-stack" aria-label="Account feedback">
    <x-ui.notification
        variant="inline"
        status="error"
        title="Billing update failed"
        message="Review the highlighted fields and try again."
    />

    <x-ui.notification
        variant="inline"
        status="warning"
        title="Some invoices are still syncing"
        message="Recent invoices may take a few minutes to appear."
    />
</div>
```

Pattern requirements:

- Place inline stacks near the region they describe.
- Sort by priority: error, warning, info, success unless the workflow requires chronological ordering.
- Deduplicate repeated messages from the same cause.
- Keep stacks short; collapse or summarize repeated low-priority messages.
- Do not mix unrelated regions in one stack.

### 4.3. Persisted notification reference

Use a persisted notification reference when feedback must survive navigation, page refresh, or session flow.

```blade
<x-ui.notification
    variant="inline"
    status="info"
    title="Import is still running"
    message="You can leave this page. We will keep the import status available from the imports list."
>
    <x-slot:actions>
        <x-ui.link href="{{ route('imports.index') }}">
            View imports
        </x-ui.link>
    </x-slot:actions>
</x-ui.notification>
```

Pattern requirements:

- Link to a durable page, log, detail route, or persisted record.
- Do not imply a notification center exists unless that product feature is installed.
- Persist only messages that represent durable state or background work.
- Use timestamps or status tags only when the data source owns them.

### 4.4. Background job completion handoff

Use a background job completion handoff when the user starts work in one place and completion happens asynchronously.

```blade
<x-ui.notification
    variant="toast"
    status="info"
    title="Export started"
    message="We will show a completion message when the file is ready."
/>

<x-ui.notification
    variant="inline"
    status="success"
    title="Export ready"
    message="Your CSV export is ready to download."
>
    <x-slot:actions>
        <x-ui.button semantic="primary" type="button">
            Download CSV
        </x-ui.button>
    </x-slot:actions>
</x-ui.notification>
```

Pattern requirements:

- Announce start, progress, and completion through the least disruptive approved surface.
- Use Inline loading or Loading while the current region is pending.
- Use a persisted reference if the user can leave the page before completion.
- Use a durable route for downloads, logs, or failure details.
- Do not rely on a toast alone for completion if the user must take required action later.

### 4.5. System notice banner

Use a system notice banner when a page- or app-level condition affects the user’s ability to work.

```blade
<x-ui.notification
    variant="inline"
    status="warning"
    title="Scheduled maintenance tonight"
    message="The app may be unavailable from 11:00 PM to 11:30 PM."
>
    <x-slot:actions>
        <x-ui.link href="{{ route('status') }}">
            View status
        </x-ui.link>
    </x-slot:actions>
</x-ui.notification>
```

Pattern requirements:

- Place the banner in the page shell or region that owns the affected scope.
- Do not use a toast for system notices users may need to reference later.
- Dismissal is allowed only for non-critical notices.
- Critical notices remain visible until resolved or superseded.

## 5. Required composition

Use only approved child APIs:

| Composition need                         | Required API                                     |
| ---------------------------------------- | ------------------------------------------------ |
| Status message                           | Notification Component                           |
| Brief pending handoff                    | Inline loading Component                         |
| Region or page pending state             | Loading Component or Loading Pattern             |
| Status metadata                          | Tag Component                                    |
| Recovery, retry, undo, or dismiss action | Button Component                                 |
| Durable destination or details route     | Link Component                                   |
| Status icon                              | Notification/Icon Component-owned icon treatment |
| Color, spacing, type, theme, motion      | Foundation Element APIs                          |

Patterns own grouping, placement, lifecycle, and orchestration. Child Components own public props, internal states, accessibility semantics, icon treatment, and internal spacing.

## 6. Optional composition

| Optional piece               | Status                                               | Use when                                                         | Rule                                                                |
| ---------------------------- | ---------------------------------------------------- | ---------------------------------------------------------------- | ------------------------------------------------------------------- |
| Dismiss action               | Implemented through Notification                     | The message is non-critical or has another durable recovery path | Do not dismiss critical errors before recovery.                     |
| Undo action                  | Gated by feature                                     | The operation is reversible and time-limited                     | Label must name the reversal; feature owns undo success/failure.    |
| View details link            | Implemented through Link                             | Details belong on a durable route                                | Use for logs, imports, exports, failed jobs, or persistent records. |
| Retry action                 | Implemented through Button where workflow owns retry | The user can safely repeat the operation                         | Disable while retry is pending.                                     |
| Persisted notification entry | Gated                                                | A durable notification inbox or event log exists                 | Do not fake a notification center.                                  |
| Timestamp                    | Feature-owned                                        | The event time is useful and reliable                            | Use app date/time formatting helpers where installed.               |
| Status tag                   | Implemented through Tag                              | State metadata helps scan a list or row                          | Do not duplicate Notification status unnecessarily.                 |

## 7. Consumed Element APIs

- Color tokens for surfaces, text, status, focus, and state behavior.
- Spacing and grid APIs for layout relationships.
- Typography APIs for headings, labels, helper text, body copy, and code where applicable.
- Icon and motion APIs where status, disclosure, loading, or animated transitions appear.
- Theme APIs for light, dark, layered, and inverse contexts.

Element consumption rules:

- Do not hard-code status colors in Pattern examples.
- Do not create Pattern-local icon colors or icon sources.
- Do not create Pattern-local animation durations or easing values.
- Do not use arbitrary margin/padding utilities to create alert stacks.
- Use parent Pattern layout for external spacing and child Component APIs for internal spacing.

Carbon color composition mapping:

| Pattern need | Carbon benchmark role | Login App owner to compose | Mapping rule |
| ------------ | --------------------- | -------------------------- | ------------ |
| Inline, toast, callout, and persistent message surfaces | Notification low/high-contrast rows | Notification Component | Pattern owns lifecycle, persistence, stacking, and placement; Notification owns semantic colors. |
| Actionable notification controls | Button and Link rows | Button and Link Components | Actions use existing semantic action/link roles; no notification-local action colors. |
| Loading or background-job handoff | Inline loading, Loading, Progress rows | Loading/Inline Loading/Progress Components | Pattern owns transition between states; child APIs own spinner/progress/status colors. |
| Compact state metadata near notifications | Tag rows | Tag Component | Tags remain compact metadata; unresolved Tag all-color rows stay verification-gated. |
| Notification center or shell slot | Navigation/UI shell + Notification rows | Navigation Pattern, UI Shell, Notification | Shell placement is gated; do not add icon/action colors locally. |

## 8. Owned Component APIs

The Pattern owns:

- Toast vs inline decision.
- Persistence rule.
- Notification stacking and deduplication.
- Action handoff.
- Page-region placement.
- Cross-region priority.
- Mobile placement constraints.
- Message lifecycle and dismissal rules.

The Notification Component owns:

- Status variant.
- Dismiss affordance.
- Local icon treatment.
- Internal spacing.
- Local title/message structure.
- Component-level ARIA semantics.

Feature modules own:

- Business rule that caused the message.
- Retry, undo, and recovery execution.
- Job state and polling/subscription behavior.
- Permissions and routing.
- Persistence, retention, and read/unread data.

## 9. Allowed variants and layout options

| Variant/layout          | Status                               | Pattern API                                         | Use when                                                      | Do not use when                                         |
| ----------------------- | ------------------------------------ | --------------------------------------------------- | ------------------------------------------------------------- | ------------------------------------------------------- |
| Saved success           | Implemented                          | Toast handoff or inline success                     | A save completes and no recovery is required                  | The success must be referenced later.                   |
| Form validation error   | Implemented                          | Inline notification stack + Forms Pattern           | Several fields failed or a form-level issue occurred          | A single field has a field-specific error only.         |
| API failure             | Implemented                          | Inline recovery block or toast only if non-critical | An operation failed and recovery is possible                  | Failure blocks the workflow; keep it inline/persistent. |
| Background job complete | Implemented                          | Background job completion handoff                   | Async work completes after the initial action                 | The user must stay on the current page until complete.  |
| Maintenance notice      | Implemented                          | System notice banner                                | System-level availability or service condition matters        | The notice is decorative or not actionable.             |
| Inline stack            | Implemented                          | Inline notification stack                           | Multiple related messages belong to one region                | Messages are unrelated or should be deduplicated.       |
| Persistent reference    | Implemented / gated by durable route | Persisted notification reference                    | A durable destination exists                                  | No route or record exists for later recovery.           |
| Toast queue             | Implemented / required proof         | Toast handoff pattern                               | Multiple transient messages may occur                         | Critical messages need focus or persistence.            |
| Actionable toast        | Gated                                | none until proven                                   | Optional action is useful and non-blocking                    | Action is required to recover.                          |
| Notification center     | Gated                                | none                                                | Product defines retention, read state, routing, and ownership | Do not fake with local lists or dropdowns.              |

## 10. State ownership

The Pattern owns lifecycle and persistence. Notification Component owns status variant, dismissal affordance, and local icon treatment.

| State           | Pattern owner                    | Component owner              | Rule                                                        |
| --------------- | -------------------------------- | ---------------------------- | ----------------------------------------------------------- |
| Created         | Feature + Pattern                | Notification                 | Feature emits event; Pattern chooses surface.               |
| Visible         | Pattern                          | Notification                 | Pattern places message; Component renders status.           |
| Dismissed       | Pattern + Feature when persisted | Notification close control   | Dismissal must not hide required recovery.                  |
| Auto-dismissed  | Pattern                          | Notification where supported | Only non-critical transient messages may auto-dismiss.      |
| Persisted       | Feature + Pattern                | Notification reference       | Requires durable data owner.                                |
| Read/unread     | Gated feature owner              | none                         | Not installed until notification center requirements exist. |
| Stacked         | Pattern                          | Notification                 | Stack by region and priority; deduplicate duplicates.       |
| Duplicate       | Pattern                          | none                         | Replace, update, or count duplicates instead of stacking.   |
| Critical        | Pattern                          | Notification status          | Critical messages remain visible and reachable.             |
| Loading handoff | Pattern                          | Loading/Inline loading       | Use approved loading APIs, not toast spinners.              |
| Action pending  | Feature + Pattern                | Button/Inline loading        | Disable repeated recovery actions while pending.            |
| Undo available  | Feature + Pattern                | Button                       | Feature owns time limit and reversibility.                  |
| Expired undo    | Feature + Pattern                | Notification update/removal  | Do not leave dead undo actions visible.                     |

## 11. Responsive behavior

Toast and notification areas must not cover primary mobile actions or trap focus unexpectedly.

Responsive requirements:

- Inline notifications wrap text and actions without clipping.
- Toast regions avoid covering primary mobile bottom actions, sticky footers, or destructive confirmation controls.
- Action groups wrap below message text when width is constrained.
- Persistent banners remain readable at small widths and do not block the entire viewport.
- Toast stacks remain short and should collapse or replace duplicates before creating vertical overflow.
- Notification actions remain keyboard reachable and touch targets remain usable.
- Motion and entrance/exit behavior must respect Foundation Motion and reduced-motion preferences.

## 12. Composition rules

- Patterns own grouping, external spacing, orchestration, and responsive composition.
- Child Components own their public APIs, local states, accessibility semantics, and internal spacing.
- Feature modules own business rules, permissions, data loading, persistence, and workflow-specific branching.
- Place inline notifications near the content or workflow they describe.
- Place system notices at the top of the affected shell, page, or section.
- Place toast regions consistently in the app shell or owning Pattern, not inside arbitrary feature markup.
- Use one message for one cause.
- Merge or replace duplicate messages from repeated events.
- Do not show a toast and inline error for the same failure unless the toast points to the inline recovery location.
- Do not stack success messages for repeated saves; update or replace the existing message.
- Keep actionable messages visible until the action is taken, dismissed, or superseded.
- Keep critical messages visible until resolved or safely acknowledged.
- Use Button for retry, undo, and dismiss actions.
- Use Link for durable destinations and details routes.
- Use Tag only for scan metadata, not as a replacement for message status.
- Use Inline loading or Loading when recovery action is pending.

## 13. Selection guidance

Use inline notifications when:

- The message belongs to a specific page region, form, table, or workflow step.
- The user may need to read it while taking action.
- The message explains validation, recovery, unavailable content, or API failure.
- The message should remain visible until resolved or dismissed.

Use toast when:

- The feedback is brief, non-blocking, and not required for recovery.
- The user action completed successfully and no further action is required.
- A background task was queued and a durable status path exists elsewhere.
- The message can disappear without harming the workflow.

Use persisted handoff when:

- A message must survive navigation.
- A background job or durable event continues outside the current page.
- The user needs a later route for details, logs, downloads, or recovery.

Use system notice banner when:

- The message affects an entire page, app shell, account, tenant, or service.
- The message needs to be seen before or during normal work.
- The condition is not tied to one local component.

Do not use notification/toast patterns when:

- A field-specific validation message is enough.
- A confirmation modal is required before a destructive action.
- The message is decorative.
- The message is static explanatory content that belongs in page copy, helper text, or documentation.
- The workflow needs a notification center that has not been product-defined.

Decision matrix:

| Need                                  | Use                                                                   |
| ------------------------------------- | --------------------------------------------------------------------- |
| Save completed                        | Toast handoff or brief inline success if local confirmation is needed |
| Form failed validation                | Inline notification stack + field errors                              |
| API call failed and user can retry    | Inline recovery block with retry action                               |
| Background export started             | Toast handoff + persisted status path                                 |
| Background export completed           | Inline/persisted completion handoff with details/download link        |
| Scheduled maintenance                 | System notice banner                                                  |
| Required recovery after navigation    | Persisted notification reference                                      |
| Optional undo after reversible change | Toast or inline notification with undo if feature gate exists         |
| Critical security/session issue       | Persistent inline/system notice, not auto-dismissed toast             |

## 14. Accessibility contract

- Use live-region politeness based on urgency.
- Use polite announcements for non-critical success, info, and background handoff messages.
- Use assertive announcements only for urgent errors that require immediate attention.
- Do not auto-dismiss critical messages before they can be read.
- Ensure actions are keyboard reachable.
- Keep actionable notification controls in logical tab order.
- Do not move focus to non-actionable inline or toast notifications.
- If a notification contains required actions, ensure focus management is Pattern-approved and does not trap users unexpectedly.
- Toasts must not block keyboard access to the underlying page.
- Inline notifications must be programmatically associated with the affected form, region, or workflow when needed.
- Validation summaries must link to or identify affected fields through Forms Pattern rules.
- Dismiss buttons require accessible names that identify what will be dismissed.
- Undo, retry, and view details actions require visible text labels.
- Do not rely on color alone for success, error, warning, info, or progress meaning.
- Keep contrast valid in light, dark, layered, and inverse contexts.
- Respect reduced-motion preferences for toast entry, exit, and stack transitions.

## 15. Content contract

- Say what happened first.
- Add next action only when one exists.
- Keep toast messages brief.
- Use sentence case.
- Use specific nouns and verbs.
- Use a short title plus a supporting message when the component supports both.
- Success messages should usually be one sentence.
- Error messages should state what failed and how to recover.
- Warning messages should state the risk or limitation.
- Info messages should state the current condition or next expected step.
- Action labels must be specific: `Retry sync`, `View import`, `Download CSV`, `Undo archive`.
- Do not use vague titles such as `Error`, `Warning`, `Success`, or `Update` when a specific event is known.
- Do not expose backend implementation details, queue names, stack traces, exception classes, or raw API responses.
- Do not use decorative success language for routine state.

Approved examples:

| Scenario        | Title                           | Message                                                                    | Action                                    |
| --------------- | ------------------------------- | -------------------------------------------------------------------------- | ----------------------------------------- |
| Saved success   | `Changes saved`                 | `Your profile settings were updated.`                                      | none                                      |
| Form validation | `Review the highlighted fields` | `Three fields need attention before this account can be saved.`            | none or field links through Forms Pattern |
| API failure     | `Sync failed`                   | `The customer record could not be synced. Try again or view sync details.` | `Retry sync`; `View details`              |
| Background job  | `Export ready`                  | `Your CSV export is ready to download.`                                    | `Download CSV`                            |
| Maintenance     | `Scheduled maintenance tonight` | `The app may be unavailable from 11:00 PM to 11:30 PM.`                    | `View status`                             |

## 16. Prohibited usage

- Do not use toasts for required validation.
- Do not use warning colors for neutral updates.
- Do not stack duplicate messages.
- Do not auto-dismiss critical errors.
- Do not use a toast as the only place for required recovery.
- Do not show multiple competing alerts for one problem.
- Do not create local toast containers or notification stacks.
- Do not hard-code status colors, icons, spacing, shadows, or motion.
- Do not use Notification as a substitute for field-level validation.
- Do not use Notification as a substitute for confirmation before destructive actions.
- Do not use a system notice banner for decorative marketing or layout emphasis.
- Do not create a fake notification center, read/unread state, or retained message list before product requirements exist.
- Do not place toast regions where they cover sticky primary actions or mobile navigation.
- Do not use success, warning, error, or info treatment for non-semantic decoration.
- Do not create local JavaScript for toast queueing, timers, deduplication, or persistence outside the Pattern owner.

## 17. Deferred or gated capabilities

| Capability                               | Status           | Gate                                                                                                                              |
| ---------------------------------------- | ---------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Full notification center                 | Gated            | Requires product retention, read/unread state, routing, grouping, permissions, deletion/archive behavior, and UI Reference proof. |
| Cross-route persisted notification inbox | Gated            | Requires durable storage, lifecycle rules, ownership, routing, and privacy/security review.                                       |
| Actionable toast with focus management   | Gated            | Requires keyboard/focus model, live-region policy, dismissal rules, and UI Reference proof.                                       |
| Undo toast                               | Gated by feature | Requires reversible operation, undo timeout, failure handling, and message update rules.                                          |
| Toast queue manager public API           | Deferred         | Requires documented initializer/server bridge, deduplication, timers, reduced-motion behavior, cleanup, and tests.                |
| Priority-based toast stacking            | Deferred         | Requires max stack count, collision behavior, priority rules, and responsive proof.                                               |
| Background job notification subscription | Gated            | Requires job event source, persisted status route, retry/failure policy, and accessibility announcement rules.                    |
| Global maintenance banner controls       | Gated            | Requires app-shell ownership, scheduling, dismissal persistence, and role/tenant targeting.                                       |
| Rich notification content                | Not allowed      | Use details route or page content. Notifications must stay concise.                                                               |
| Custom status colors/icons               | Not allowed      | Requires Color/Icon Element updates and Notification Component proof.                                                             |

Future extensions require an updated Pattern standard and UI Reference proof before production use.

## 18. UI Reference requirements

The UI Reference page must show rendered examples of the approved Pattern compositions, not abstract notes only.

The page must link to this canonical standard and to consumed Element and Component standards.

Deferred capabilities must appear as explicit gated disposition rows with trigger conditions, not as fake complete examples.

Examples must use app-owned tokens, classes, helpers, and Blade components where available.

Required UI Reference proof:

| Required proof                    | Rendered behavior                                                                                                             | Variants/options shown                                                                             |
| --------------------------------- | ----------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| Toast handoff                     | Non-blocking success/info toast appears in a shell-owned toast region and may dismiss when non-critical.                      | Saved success, queued task, dismissible, polite live behavior, reduced motion                      |
| Inline notification stack         | Related regional messages appear in priority order and deduplicate repeated causes.                                           | Error, warning, info, success, stack spacing, dedupe note                                          |
| Persisted notification reference  | Message links to durable status/details route and survives the immediate workflow context.                                    | View details link, status tag if applicable, persistence boundary                                  |
| Background job completion handoff | Started, pending, complete, and failed states compose toast, loading/inline loading, notification, and recovery action.       | Export/import job, Inline loading, Loading, success, error, retry/download/view details            |
| System notice banner              | App/page-level condition appears in a stable region without covering primary actions.                                         | Maintenance notice, warning/info, optional dismiss, persistent critical notice                     |
| Toast vs inline decision matrix   | Page explains which surface owns each scenario.                                                                               | Success, validation error, API failure, background job, maintenance notice                         |
| Accessibility matrix              | Live-region politeness, focus behavior, keyboard actions, auto-dismiss boundary, and color-independent status are documented. | Polite, assertive gated, no focus for passive toast, keyboard actions, non-auto-dismiss critical   |
| Responsive behavior               | Toast and inline examples wrap and keep actions reachable at narrow widths.                                                   | Mobile toast placement, stacked actions, no covered primary action                                 |
| Gated capabilities                | Future notification center and advanced toast behavior render as gated disposition rows.                                      | Notification center, undo toast, actionable toast, queue manager                                   |
| Developer implementation          | Canonical composition snippets use approved Components.                                                                       | `x-ui.notification`, `x-ui.button`, `x-ui.link`, `x-ui.inline-loading`, `x-ui.loading`, `x-ui.tag` |

## 19. Testing and acceptance criteria

- `/platform/ui-reference/patterns/overlays-feedback` returns 200 for authorized users.
- The page links to `docs/02-standards/ui/patterns/notifications-and-toasts.md`.
- Rendered examples include the required composition markers and consumed Component links.
- Toast handoff examples render as non-blocking and do not include required recovery-only behavior.
- Inline notification stack examples show priority ordering and deduplication rules.
- Persisted notification reference examples include a durable link and do not imply an installed notification center.
- Background job handoff examples compose Notification, Inline loading or Loading, Button, and Link as applicable.
- System notice banner examples do not cover primary mobile actions.
- No Pattern example hard-codes Foundation Element decisions that already have approved APIs.
- Deferred capabilities are represented with trigger conditions and prohibited local workarounds.
- The page documents that toasts are not for required validation or critical recovery.
- No generic placeholder content appears.

Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/patterns/overlays-feedback');

$response->assertOk();
$response->assertSee('Notifications and toasts');
$response->assertSee('Toast handoff');
$response->assertSee('Inline notification stack');
$response->assertSee('Persisted notification reference');
$response->assertSee('Background job completion handoff');
$response->assertSee('System notice banner');
$response->assertSee('x-ui.notification');
$response->assertSee('x-ui.inline-loading');
$response->assertSee('x-ui.loading');
$response->assertSee('x-ui.button');
$response->assertSee('x-ui.link');
$response->assertSee('Do not use toasts for required validation');
$response->assertSee('notification center');
$response->assertSee('Gated');
$response->assertDontSee('Component-specific API ' . 'pending correction');
$response->assertDontSee('Live Examples ' . 'Card');
$response->assertDontSee('Reference ' . 'Examples');
$response->assertDontSee('Legacy Contract ' . 'Summary');
$response->assertDontSee('tier' . '-1');
$response->assertDontSee('tier' . '-2');
$response->assertDontSee('cds' . '--');
$response->assertDontSee('bx' . '--');
$response->assertDontSee('TODO');
$response->assertDontSee('Generic ' . 'fallback');
```

## 20. Related APIs

| API                                    | Route                                                                            |
| -------------------------------------- | -------------------------------------------------------------------------------- |
| Notification                           | `/platform/ui-reference/components/notification`                                 |
| Tag                                    | `/platform/ui-reference/components/tag`                                          |
| Inline loading                         | `/platform/ui-reference/components/inline-loading`                               |
| Loading                                | `/platform/ui-reference/components/loading`                                      |
| Button                                 | `/platform/ui-reference/components/button`                                       |
| Link                                   | `/platform/ui-reference/components/link`                                         |
| Feedback Pattern                       | `/platform/ui-reference/patterns/overlays-feedback`                              |
| Forms Pattern                          | `/platform/ui-reference/patterns/forms`                                          |
| Table toolbar planned gap              | `/platform/ui-reference/patterns/tables`                                         |
| Page header planned gap                | `/platform/ui-reference/patterns/layout`                                         |
| Color element                          | `/platform/ui-reference/elements/color`                                          |
| Motion element                         | `/platform/ui-reference/elements/motion`                                         |
| Icon element                           | `/platform/ui-reference/elements/icons`                                          |
| Pattern standards overview             | `/platform/ui-reference/patterns`                                                |
| Canonical notifications and toasts doc | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Fnotifications-and-toasts.md` |
| Carbon Notification usage              | `https://carbondesignsystem.com/components/notification/usage/`                  |
| Carbon notification pattern            | `https://carbondesignsystem.com/patterns/notification-pattern/`                  |

## 21. References

- [Pattern Library Checklist](checklist.md)
- [Component Standards](../components/index.md)
- [Foundation Elements Standards](../elements/index.md)
- Carbon Notification component and notification pattern guidance inform the toast/inline/actionable/callout distinction, lifecycle expectations, content brevity, accessibility boundaries, and persistence decisions. Login App keeps its own Pattern API, Notification Component API, app-owned `ui-*` namespace, Foundation tokens, and UI Reference proof.
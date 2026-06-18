---
title: Feedback
slug: feedback
api_layer: Pattern API
status: implemented-standard
system_maturity: implemented
category: overlays-feedback
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/patterns/overlays-feedback
canonical_doc: docs/02-standards/ui/patterns/feedback.md
source_owner: /platform/ui-reference/patterns/overlays-feedback
pattern_api:
  - page-level-feedback-region
  - inline-recovery-block
  - validation-summary-composition
  - loading-placeholder-composition
  - status-handoff-row
blade_api: []
javascript_api: []
source_files:
  - resources/views/platform/ui-reference/patterns/overlays-feedback.blade.php
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
  - 2x-grid
consumed_components:
  - notification
  - inline-loading
  - loading
  - progress-bar
  - button
  - link
  - tag
  - icon
related_patterns:
  - forms
  - table-toolbar
  - overlays-feedback
  - loading
  - page-header
carbon_reference:
  - https://carbondesignsystem.com/patterns/overview/
---

# Feedback Pattern API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Pattern API](#4-pattern-api)
  - [4.1. Page-level feedback region](#41-page-level-feedback-region)
  - [4.2. Inline recovery block](#42-inline-recovery-block)
  - [4.3. Validation summary composition](#43-validation-summary-composition)
  - [4.4. Loading placeholder composition](#44-loading-placeholder-composition)
  - [4.5. Status handoff row](#45-status-handoff-row)
  - [4.6. API surfaces](#46-api-surfaces)
  - [4.7. Pattern-owned data attributes](#47-pattern-owned-data-attributes)
- [5. Required composition](#5-required-composition)
- [6. Optional composition](#6-optional-composition)
- [7. Consumed Element APIs](#7-consumed-element-apis)
- [8. Owned Component APIs](#8-owned-component-apis)
- [9. Allowed variants and layout options](#9-allowed-variants-and-layout-options)
- [10. State ownership](#10-state-ownership)
  - [10.1. Priority and persistence matrix](#101-priority-and-persistence-matrix)
- [11. Responsive behavior](#11-responsive-behavior)
- [12. Composition rules](#12-composition-rules)
- [13. Selection guidance](#13-selection-guidance)
- [14. Accessibility contract](#14-accessibility-contract)
- [15. Content contract](#15-content-contract)
- [16. Prohibited usage](#16-prohibited-usage)
- [17. Deferred or gated capabilities](#17-deferred-or-gated-capabilities)
- [18. Implementation and UI Reference Checklist](#18-implementation-and-ui-reference-checklist)
  - [18.1. Implementation checklist](#181-implementation-checklist)
  - [18.2. UI Reference proof checklist](#182-ui-reference-proof-checklist)
- [19. UI Reference requirements](#19-ui-reference-requirements)
- [20. Testing and acceptance criteria](#20-testing-and-acceptance-criteria)
- [21. Related APIs](#21-related-apis)
- [22. References](#22-references)

## 1. API summary

Feedback patterns define how status, error, success, progress, unavailable, and recovery messages appear across composed UI surfaces.

Canonical API owner: `/platform/ui-reference/patterns/overlays-feedback`. Use this Pattern API when feedback belongs to a workflow, page region, data region, form, or recovery path instead of one standalone Component instance.

Feedback is an installed Login App 2.0 Pattern API. It owns feedback placement, priority, persistence boundaries, recovery-action grouping, loading composition, validation-summary composition, page-region unavailable states, and status handoff between local and persistent messages. It does not redefine Notification, Inline loading, Loading, Progress bar, Button, Link, Tag, Icon, Color, Spacing, Typography, Motion, or Theme primitives.

Canonical Pattern responsibilities:

- Place workflow-level and page-region feedback consistently.
- Choose the least disruptive feedback surface that still communicates the status and next step.
- Compose approved Component APIs instead of creating local alert, status, spinner, progress, or recovery markup.
- Define when feedback is inline, page-level, persistent, dismissible, blocking, or temporary.
- Group recovery actions consistently with Button and Link APIs.
- Provide validation-summary composition for form-level errors without replacing field-level validation.
- Provide loading-placeholder composition for page regions and data regions.
- Define status handoff from local pending feedback to persistent success/error/recovery feedback.
- Keep feedback accessible through appropriate live-region urgency, keyboard reachable recovery controls, and non-color-only status meaning.
- Prove all approved feedback compositions on `/platform/ui-reference/patterns/overlays-feedback`.

Non-owned responsibilities:

- Business rules, permissions, validation logic, data loading, persistence, retry logic, and workflow branching. Feature modules own those rules.
- Component internal status variants, dismissal controls, icon rendering, loading animation, button hierarchy, and local accessibility semantics. Child Components own those APIs.
- Foundation token definitions. Foundation Elements own primitive visual decisions.
- Field-specific validation messages. Field Components and Forms Pattern own field-level errors.
- Toast retention, read/unread notification centers, and notification history. Those remain gated until a feature owner defines behavior.

## 2. Status and ownership

| Field                        | Value                                                                                                                                  |
| ---------------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented standard                                                                                                                   |
| System maturity              | Implemented                                                                                                                            |
| API layer                    | Pattern API                                                                                                                            |
| Pattern slug                 | feedback                                                                                                                               |
| Owner route                  | `/platform/ui-reference/patterns/overlays-feedback`                                                                                    |
| UI Reference proof           | `/platform/ui-reference/patterns/overlays-feedback`                                                                                    |
| Canonical doc                | `docs/02-standards/ui/patterns/feedback.md`                                                                                            |
| Source owner                 | `/platform/ui-reference/patterns/overlays-feedback`                                                                                    |
| Pattern API                  | Page-level feedback region; inline recovery block; validation summary composition; loading placeholder composition; status handoff row |
| JavaScript API               | None public. Feature modules may own workflow state; Pattern examples must not require feature-local feedback scripts.                 |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid                                                                             |
| Consumed Component APIs      | Notification, Inline loading, Loading, Progress bar, Button, Link, Tag, Icon                                                           |
| Carbon benchmark             | Carbon Patterns overview and relevant component/pattern behavior only                                                                  |

`Implemented standard` means the pattern is approved for production composition, but only through approved Component and Element APIs. Pattern examples must render composed production UI, not abstract notes or local visual primitives.

## 3. Installed standard

Use Feedback Pattern compositions when a status message is part of a larger workflow or region.

The installed standard is:

- Use page-level feedback regions for page or workflow outcomes that affect the current page.
- Use inline recovery blocks for local failures or unavailable states that need an action near the affected content.
- Use validation summary composition for form-level error summaries while keeping field-level errors on the fields.
- Use loading placeholder composition for a region that is temporarily unavailable while data loads.
- Use status handoff rows when a local pending action transitions to success, error, retry, unavailable, or persisted feedback.
- Use Notification for standalone alert surfaces inside the pattern.
- Use Inline loading for local pending action feedback.
- Use Loading or Progress bar when a page region is pending or progress is meaningful.
- Use Button for primary recovery actions such as `Retry`, `Save again`, `Refresh`, or `Return to list`.
- Use Link for navigation or documentation recovery actions.
- Use Tag for compact status metadata only when a status label must persist near a record, row, or object.
- Use Icon only through approved Component or Element APIs.
- Use Element tokens for all color, spacing, typography, theme, icon, and motion behavior.
- Do not create local alert banners, local status rows, local skeletons, local spinners, local progress bars, local icons, local retry button groups, or local notification containers.
- Do not stack multiple competing messages for the same problem.
- Do not auto-dismiss critical errors, validation summaries, unavailable states, or recovery instructions.

Carbon alignment note: Carbon describes patterns as reusable best-practice combinations of components and templates that help users achieve goals through sequences and flows. Login App applies that model by treating Feedback as a composition standard: Components own primitive behavior, while this Pattern owns placement, priority, orchestration, persistence, and recovery relationships.

## 4. Pattern API

Feedback has no standalone Blade helper by default. It is a Pattern API composed from installed Components.

### 4.1. Page-level feedback region

Use when feedback applies to the current page or workflow state.

```blade
<section class="ui-feedback-region" aria-labelledby="page-feedback-heading">
    <h2 id="page-feedback-heading" class="ui-sr-only">Page status</h2>

    <x-ui.notification
        status="success"
        title="Workspace created"
        message="The workspace is ready to configure."
    >
        <x-slot:actions>
            <x-ui.link href="{{ route('workspaces.show', $workspace) }}">
                View workspace
            </x-ui.link>
        </x-slot:actions>
    </x-ui.notification>
</section>
```

### 4.2. Inline recovery block

Use when the problem belongs to one local region and users need a recovery action near that region.

```blade
<div class="ui-feedback-recovery" role="status" aria-live="polite">
    <x-ui.notification
        status="error"
        title="Could not load activity"
        message="Refresh the activity feed or return to the dashboard."
    >
        <x-slot:actions>
            <x-ui.button type="button" semantic="primary">
                Retry
            </x-ui.button>

            <x-ui.link href="{{ route('dashboard') }}">
                Return to dashboard
            </x-ui.link>
        </x-slot:actions>
    </x-ui.notification>
</div>
```

### 4.3. Validation summary composition

Use when a form has multiple validation errors or the user needs a form-level recovery target. Field errors must still render through field Component APIs.

```blade
@if ($errors->any())
    <x-ui.notification
        status="error"
        title="Fix the highlighted fields"
        message="There are {{ $errors->count() }} fields that need attention."
        role="alert"
    >
        <x-slot:actions>
            <x-ui.link href="#{{ $errors->keys()[0] }}">
                Go to first error
            </x-ui.link>
        </x-slot:actions>
    </x-ui.notification>
@endif
```

### 4.4. Loading placeholder composition

Use when a page region is loading and the final content shape is not yet available.

```blade
<section class="ui-feedback-loading-region" aria-busy="true" aria-labelledby="activity-heading">
    <h2 id="activity-heading">Activity</h2>

    <x-ui.loading label="Loading activity" />
</section>
```

Use Inline loading instead when a single local action is pending.

```blade
<x-ui.inline-loading status="loading" label="Saving changes" />
```

### 4.5. Status handoff row

Use when a local action changes state and the user needs to understand what happened next.

```blade
<div class="ui-feedback-handoff-row">
    <x-ui.inline-loading status="success" label="Saved" />

    <x-ui.tag type="blue" text="Pending review" />

    <x-ui.link href="{{ route('requests.show', $request) }}">
        View request
    </x-ui.link>
</div>
```

### 4.6. API surfaces

| API surface               | Installed value                                                                                                                                           |
| ------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Pattern helper            | None required by default. Compose approved Components in approved feedback regions.                                                                       |
| Blade Components consumed | `x-ui.notification`, `x-ui.inline-loading`, `x-ui.loading`, `x-ui.progress-bar`, `x-ui.button`, `x-ui.link`, `x-ui.tag` where installed                   |
| JavaScript                | No public Pattern-level JavaScript API. Feature modules own workflow state; Components own local behavior.                                                |
| Data attributes           | Pattern-owned test hooks only when emitted by the UI Reference or installed Pattern source. Feature modules must not invent feedback behavior attributes. |
| CSS namespace             | App-owned `ui-feedback*` pattern classes for grouping and layout only                                                                                     |
| Source owner              | `/platform/ui-reference/patterns/overlays-feedback`                                                                                                       |

### 4.7. Pattern-owned data attributes

| Data attribute                                                      | Status                   | Owner   | Purpose                                                                          |
| ------------------------------------------------------------------- | ------------------------ | ------- | -------------------------------------------------------------------------------- |
| `data-ui-pattern="feedback"`                                        | Implemented when emitted | Pattern | Identifies feedback composition root for tests and diagnostics.                  |
| `data-ui-feedback-region`                                           | Implemented when emitted | Pattern | Identifies page-level or region-level feedback.                                  |
| `data-ui-feedback-priority="critical\|important\|normal\|low"`      | Implemented when emitted | Pattern | Exposes priority for tests and documentation examples only.                      |
| `data-ui-feedback-persistence="persistent\|dismissible\|temporary"` | Implemented when emitted | Pattern | Exposes message persistence boundary for tests.                                  |
| `data-ui-feedback-handoff`                                          | Implemented when emitted | Pattern | Identifies local-to-persistent status handoff examples.                          |
| Feature-local behavior attributes                                   | Not allowed              | none    | Do not create local feedback placement, timeout, priority, or recovery behavior. |

## 5. Required composition

Feedback Pattern examples must compose only approved Component and Element APIs.

| Required composition | Role in the pattern                                                           | Ownership rule                                                                                           |
| -------------------- | ----------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------- |
| Notification         | Standalone status, alert, success, warning, error, and informational messages | Notification owns variants, icon, dismissal, title/body/action slots, and local accessibility semantics. |
| Inline loading       | Local pending action or short local status                                    | Inline loading owns loading/success/error/warning/info state display and reduced-motion behavior.        |
| Loading              | Page-region or panel-region pending state                                     | Loading owns spinner/placeholder semantics and animation behavior.                                       |
| Progress bar         | Progress where completion amount is meaningful                                | Progress bar owns value semantics, progress display, and accessible value text.                          |
| Button               | Primary and secondary recovery actions                                        | Button owns hierarchy, disabled/loading, focus, and danger treatment.                                    |
| Link                 | Navigational recovery action or documentation link                            | Link owns navigation semantics and external/new-window rules.                                            |
| Tag                  | Compact persistent object status                                              | Tag owns compact status styling and semantics.                                                           |
| Icon                 | Status reinforcement where Components render icons                            | Icons must come from approved Component/Icon APIs.                                                       |
| Color                | Status surfaces, text, borders, focus, and state roles                        | Color Element owns semantic token values.                                                                |
| Spacing and 2x Grid  | Region spacing, action grouping, and responsive layout                        | Pattern owns external spacing relationships only.                                                        |
| Typography           | Titles, message body, helper copy, and code where applicable                  | Typography Element owns scale and rhythm.                                                                |
| Motion               | Entry/exit/loading transitions                                                | Motion Element and child Components own animation details and reduced-motion behavior.                   |
| Themes               | Light, dark, layered, and inverse contexts                                    | Theme Element owns token resolution.                                                                     |

## 6. Optional composition

| Optional composition         | Status                                          | Use when                                                                           | Gate or boundary                                                                                    |
| ---------------------------- | ----------------------------------------------- | ---------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------- |
| Toast handoff                | Gated                                           | A non-critical background update can be acknowledged without interrupting the page | Requires Notification/Toast API, timeout policy, focus/announcement policy, and UI Reference proof. |
| Persistent notification link | Implemented through Link                        | The message needs a clear navigation or documentation path                         | Link text must describe destination or recovery outcome.                                            |
| Retry action                 | Implemented through Button                      | A failed load/save/sync can be retried safely                                      | Feature module owns retry business logic and duplicate-submit protection.                           |
| Dismiss action               | Implemented through Notification when available | Message is non-critical and does not block recovery                                | Critical errors, validation summaries, and unavailable states must not auto-dismiss.                |
| Details/disclosure handoff   | Gated                                           | A message needs optional diagnostic details                                        | Requires Disclosure/Accordion/Toggletip/Popover ownership; do not hide required recovery details.   |
| Status metadata tag          | Implemented through Tag                         | A persistent object or row needs compact status after feedback resolves            | Tag must not replace explanatory feedback when action is required.                                  |

## 7. Consumed Element APIs

| Element API | Consumed role                                                                                                   |
| ----------- | --------------------------------------------------------------------------------------------------------------- |
| Color       | Feedback surfaces, text, borders, semantic statuses, state behavior, focus, disabled, and contrast.             |
| Spacing     | Region separation, message/action gaps, responsive wrapping, stacked feedback rhythm, and recovery grouping.    |
| 2x Grid     | Page-level and region-level placement when feedback is composed into page shells, forms, tables, or dashboards. |
| Typography  | Headings, status titles, body copy, helper text, validation summary text, labels, and code where applicable.    |
| Icons       | Status reinforcement, action affordance, and loading/progress support only through approved APIs.               |
| Motion      | Entry/exit transitions, loading/progress motion, status handoff, and reduced-motion fallback.                   |
| Themes      | Light, dark, layered, and inverse context behavior.                                                             |

Carbon color composition mapping:

| Pattern need | Carbon benchmark role | Login App owner to compose | Mapping rule |
| ------------ | --------------------- | -------------------------- | ------------ |
| Inline, page-region, toast, success, warning, error, info feedback | Notification component token rows and support/status roles | Notification Component + Color Element | Feedback chooses placement/priority; Notification owns status colors. |
| Pending/local status handoff | Inline loading and Loading rows | Inline Loading / Loading Components | Feedback coordinates lifecycle; Loading APIs own spinner/skeleton/status colors. |
| Progress feedback | Progress bar and Progress indicator rows | Progress Components | Feedback selects progress form; Progress APIs own fill/marker colors. |
| Recovery actions and durable destinations | Button and Link rows | Button and Link Components | Feedback groups actions; components own hierarchy, link, disabled, and focus colors. |
| Compact status in rows/cards | Tag rows | Tag Component | Tag all-color component rows remain verification-gated; do not create local tag palettes. |
| Validation summary | Form field validation rows + Notification rows | Forms Pattern + field Components + Notification | Summary placement is Pattern-owned; field and notification colors are not. |

## 8. Owned Component APIs

Feedback Pattern owns composition boundaries around child Components. It does not own child Component internals.

| Owned by Feedback Pattern                                              | Owned by child Components                                                 |
| ---------------------------------------------------------------------- | ------------------------------------------------------------------------- |
| Feedback placement in page, form, panel, modal, table, or local region | Notification status variants, title/body/action slots, dismissal behavior |
| Recovery-action grouping and order                                     | Button hierarchy, disabled/loading, icon, and focus behavior              |
| Message priority and persistence boundary                              | Link navigation semantics and external destination treatment              |
| Page-region loading composition                                        | Loading animation, label, and reduced-motion behavior                     |
| Local-to-persistent status handoff                                     | Inline loading state display and live-region behavior                     |
| Validation summary placement                                           | Field component error association and field-level validation display      |
| Responsive wrapping and external spacing                               | Component internal spacing and token-backed states                        |

## 9. Allowed variants and layout options

| Name                              | Type                | Status                                        | Use when                                                                                          | Required composition                                                    |
| --------------------------------- | ------------------- | --------------------------------------------- | ------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------- |
| Inline feedback                   | Layout option       | Implemented                                   | Feedback belongs directly beside or below the affected control, field group, row, or local region | Notification, Inline loading, Link, Button as needed                    |
| Page-region feedback              | Layout option       | Implemented                                   | Feedback applies to a page, dashboard region, tab panel, modal body, or major section             | Notification or Loading plus optional actions                           |
| Validation summary                | Pattern composition | Implemented                                   | A form has multiple errors or needs a top-level recovery target                                   | Notification plus field Component errors                                |
| Unavailable state                 | Pattern composition | Implemented                                   | A region cannot load, user lacks permission, or a dependency is unavailable                       | Notification, Button/Link recovery, optional Icon                       |
| Loading region                    | Pattern composition | Implemented                                   | A page region is temporarily pending                                                              | Loading, Progress bar, Inline loading, or skeleton Pattern if installed |
| Status handoff row                | Pattern composition | Implemented                                   | Local status should transition into a persistent row, tag, or action path                         | Inline loading, Tag, Link, Button                                       |
| Dismissible non-critical feedback | Modifier            | Implemented through Notification if supported | Message is helpful but not required for recovery                                                  | Notification dismiss control                                            |
| Critical persistent feedback      | Modifier            | Implemented                                   | Users must recover before continuing                                                              | Notification with persistent recovery action; no auto-dismiss           |
| Toast handoff                     | Modifier            | Gated                                         | Non-critical background update should not shift layout                                            | Toast API and retention policy required                                 |
| Notification center handoff       | Capability          | Gated                                         | Feedback must persist across routes/sessions                                                      | Feature owner must define retention/read-unread rules                   |

## 10. State ownership

Patterns own message priority and placement. Components own semantic status variants and local dismissal controls.

| State or decision        | Owner                           | Rule                                                                                               |
| ------------------------ | ------------------------------- | -------------------------------------------------------------------------------------------------- |
| Message priority         | Pattern                         | Choose critical, important, normal, or low based on workflow impact.                               |
| Message placement        | Pattern                         | Place feedback near the affected region or at page level when it affects the full page.            |
| Persistence boundary     | Pattern                         | Decide whether feedback is persistent, dismissible, temporary, or handed off to another surface.   |
| Semantic status variant  | Component                       | Notification/Inline loading/Tag owns success, error, warning, info, loading, and disabled styling. |
| Live-region urgency      | Pattern + Component             | Pattern chooses urgency; Component implements live-region semantics where supported.               |
| Recovery action grouping | Pattern                         | Group Retry, Return, Learn more, Dismiss, and View details consistently.                           |
| Dismiss control          | Component                       | Notification owns local dismiss rendering and keyboard behavior.                                   |
| Loading animation        | Component                       | Loading/Inline loading/Progress owns animation and reduced-motion behavior.                        |
| Field validation state   | Field Component + Forms Pattern | Field-level errors remain on fields; summary is a Pattern composition.                             |
| Business retry result    | Feature module                  | Feature owns success/failure branching after retry.                                                |

### 10.1. Priority and persistence matrix

| Priority  | Use when                                                                  | Recommended surface                                                | Persistence                                               |
| --------- | ------------------------------------------------------------------------- | ------------------------------------------------------------------ | --------------------------------------------------------- |
| Critical  | User cannot continue without fixing or acknowledging the issue            | Page-level or region-level error Notification with recovery action | Persistent; no auto-dismiss                               |
| Important | Workflow completed with warnings, partial success, or a recoverable issue | Page-region or inline Notification with action if needed           | Persistent until resolved or manually dismissed when safe |
| Normal    | User needs confirmation or neutral status                                 | Inline status, status handoff row, or non-critical Notification    | Temporary or dismissible when safe                        |
| Low       | Background update or optional FYI                                         | Tag, inline status, or gated toast handoff                         | Temporary/dismissible only when not needed for recovery   |

## 11. Responsive behavior

- Feedback regions must wrap text and actions without covering primary content at small widths.
- Recovery actions must remain reachable by keyboard and touch after wrapping.
- Long status text must wrap before action controls become unusable.
- Page-level feedback must not obscure global navigation, modal controls, or form submit areas.
- Inline feedback must remain visually connected to the affected field, row, or region.
- Stacked feedback messages must preserve readable spacing and priority order.
- Dismiss controls must remain reachable and must not overlap text or recovery actions.
- Loading regions must reserve enough space to prevent disruptive layout shifts where practical.
- Reduced-motion preferences must be respected for feedback entry, exit, loading, and progress transitions.

## 12. Composition rules

- Patterns own grouping, external spacing, orchestration, responsive composition, priority, placement, persistence, and handoff behavior.
- Child Components own public APIs, local states, accessibility semantics, internal spacing, icons, status variants, and dismissal controls.
- Feature modules own business rules, permissions, data loading, persistence, retry behavior, workflow-specific branching, and API error mapping.
- Use the least disruptive feedback composition that satisfies the user need.
- Place feedback as close as possible to the affected region while keeping page-level issues visible enough to act on.
- Do not use page-level feedback for a field-specific issue that belongs on a field.
- Do not use field-level feedback for a page-level outage, permission issue, or workflow result.
- Keep one authoritative message for one problem. If multiple surfaces are needed, define a clear handoff from local to persistent feedback.
- Pair critical or recoverable errors with a next action where a next action exists.
- Use Button for action execution and Link for navigation.
- Use success feedback sparingly and keep it short.
- Do not auto-dismiss critical errors, validation summaries, unavailable states, or recovery instructions.
- Do not show loading, success, and error messages for the same action at the same time unless the UI Reference explicitly proves a handoff row.
- Do not use Tag as the only explanation for an error requiring recovery.
- Do not use status color as decoration.
- Do not create local feedback CSS or JavaScript when a Component API exists.

## 13. Selection guidance

Use Feedback Pattern when:

- Feedback belongs to a workflow, page, panel, modal, table, form, or data region.
- A message requires grouped recovery actions.
- A pending state needs to hand off to success, error, warning, unavailable, or persisted status.
- A form needs both a top-level validation summary and field-level errors.
- A region is unavailable due to permissions, missing data, dependency failure, or failed loading.
- Multiple Components must work together to communicate state and recovery.

Use a standalone Component instead when:

- One standalone alert or toast is enough. Use Notification.
- One local action is pending. Use Inline loading.
- A page region is loading without recovery actions. Use Loading.
- Progress amount is meaningful. Use Progress bar.
- A single object needs compact persistent status. Use Tag.
- A single field has an error. Use field Component validation.

Selection matrix:

| Need                           | Use                                                                                       |
| ------------------------------ | ----------------------------------------------------------------------------------------- |
| Page saved successfully        | Page-level success Notification or short status handoff, depending on workflow importance |
| Field is invalid               | Field Component error, optionally plus validation summary for multiple errors             |
| Multiple form errors           | Validation summary composition plus field-level errors                                    |
| Local row action is saving     | Inline loading near the row action                                                        |
| Region failed to load          | Inline recovery block or unavailable state with Retry/Return action                       |
| Whole page cannot load         | Page-level feedback region with persistent recovery action                                |
| Long-running import/export     | Progress bar or Loading Pattern with status handoff                                       |
| Non-critical background update | Gated toast handoff or low-priority inline status when approved                           |
| Object status after completion | Tag plus optional Link for details                                                        |

## 14. Accessibility contract

- Use polite announcements for non-urgent status changes and success confirmations.
- Use assertive announcements only for urgent errors that require immediate attention or block continuation.
- Do not use assertive live regions for routine success, loading, or decorative status.
- Ensure recovery controls are keyboard reachable and appear in logical reading order.
- Do not rely on color alone for status; include text and, where available, approved status icons.
- Field errors must remain programmatically associated with their fields.
- Validation summaries must identify the form-level problem and provide a path to the affected fields when practical.
- Loading regions should expose `aria-busy="true"` or the installed Loading component equivalent where applicable.
- Progress feedback must expose accessible value semantics through Progress bar when progress amount is known.
- Critical errors must remain visible until resolved, navigated away from, or intentionally dismissed when safe.
- Auto-dismissed non-critical feedback must not contain information required to complete the task.
- Focus must not be stolen for routine feedback. Move focus only when required for recovery, route transitions, modal workflows, or form validation policy.
- Dismiss controls must have accessible names.
- Links and buttons in feedback must clearly state their recovery outcome.
- Feedback must maintain contrast in supported light and dark themes.
- Reduced-motion preferences must be respected for entry, exit, loading, and progress transitions.

## 15. Content contract

- State what happened and what to do next.
- Keep success confirmations short.
- Use specific recovery labels.
- Write titles that identify the status or problem: `Workspace created`, `Could not load activity`, `Fix the highlighted fields`.
- Write body copy that explains impact and recovery in one or two concise sentences.
- Use action labels that describe the next step: `Retry`, `Refresh data`, `Return to dashboard`, `View workspace`, `Go to first error`.
- Use sentence case.
- Use concrete nouns from the workflow.
- Avoid vague labels such as `OK`, `Click here`, `Something went wrong`, `Error`, or `Try again later` when a specific issue or recovery action is known.
- Do not expose stack traces, exception names, API payloads, job IDs, queue names, or internal service details to users.
- Do not over-confirm routine actions that have obvious UI results.
- Do not use success copy to decorate a normal state.
- For partial success, state what completed, what did not, and what the user can do next.
- For unavailable states, state whether the issue is permissions, missing data, dependency failure, or temporary loading failure when known.

## 16. Prohibited usage

- Do not stack multiple competing alerts for one problem.
- Do not use success colors for decoration.
- Do not auto-dismiss critical errors.
- Do not auto-dismiss validation summaries or unavailable-state recovery instructions.
- Do not create local alert, toast, spinner, progress, skeleton, status-row, or recovery-action markup when approved Components exist.
- Do not hard-code Foundation Element decisions such as raw colors, arbitrary spacing, custom icons, local typography, or local motion.
- Do not use Notification as a substitute for field-level validation.
- Do not use field-level validation as the only message for page-level or workflow-level failures.
- Do not use Tag as the only explanation for a recoverable error.
- Do not use loading indicators without an understandable pending region or action.
- Do not present success, warning, and error states together without a clear priority or handoff.
- Do not hide required recovery instructions behind Tooltip or hover-only disclosure.
- Do not use disabled-only UI without explaining how users can recover or why the region is unavailable.
- Do not use custom JavaScript timers for dismissing messages outside approved Notification or Toast APIs.
- Do not build persistent notification center behavior without a feature owner and retention/read-unread rules.

## 17. Deferred or gated capabilities

| Capability                              | Status                   | Gate                                                                                                                                              |
| --------------------------------------- | ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| Persistent notification center behavior | Gated                    | Requires feature owner, retention rules, read/unread rules, storage model, routing, notification priority, accessibility, and UI Reference proof. |
| Toast handoff                           | Gated                    | Requires Toast/Notification API, timeout policy, pause-on-hover/focus behavior, announcement policy, and tests.                                   |
| Cross-route feedback persistence        | Gated                    | Requires session/flash/message bus policy, duplicate suppression, routing behavior, and tests.                                                    |
| Bulk action result summary              | Gated                    | Requires table/list Pattern ownership, partial-success copy, retry grouping, and row-level status handoff.                                        |
| Offline/connection recovery pattern     | Deferred                 | Requires app-wide network status owner, retry behavior, queueing policy, and persistent visibility rules.                                         |
| Background job progress handoff         | Deferred                 | Requires progress source, polling or push contract, completion/failure state mapping, and notification handoff.                                   |
| Diagnostic details disclosure           | Gated                    | Requires disclosure component ownership, support workflow approval, and safe content rules.                                                       |
| Skeleton-region orchestration           | Pattern-owned / Deferred | Requires Loading Pattern proof for region skeletons and state handoff.                                                                            |
| Custom status categories                | Not allowed              | Requires Color, Icons, Notification, Tag, and Pattern standard updates.                                                                           |

Future extensions require an updated Pattern standard and UI Reference proof before production use.

## 18. Implementation and UI Reference Checklist
### 18.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                      |
| -------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Pattern API/source         | The standard names the canonical Pattern helper, layout partial, route/view surface, source files, or explicit deferred gate.             |
| Required composition       | Components and Elements the Pattern must coordinate are listed.                                                                           |
| Optional composition       | Optional slots, regions, actions, filters, summaries, overlays, or deferred sub-APIs are listed.                                          |
| State/responsive ownership | Loading, empty, error, blocked, validation, persistence, focus order, responsive, and overflow behavior owned by the Pattern are defined. |
| Accessibility/content      | Page/workflow semantics, heading structure, focus flow, status messaging, action labels, and non-color meaning are defined.               |
| Tests                      | Route/content/API assertions prove the Pattern and coordinated Component usage.                                                           |

### 18.2. UI Reference proof checklist
| Requirement            | Visual proof expectation                                                                                                           |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| Live compositions      | The page renders production-like composed examples, not isolated primitive samples.                                                |
| Component coordination | Child Components show how they consume the Pattern layout and state ownership.                                                     |
| Element consumption    | Spacing, grid, typography, color, theme, icon, and motion use are shown at the Pattern level.                                      |
| Variants/states        | Required layout variants, responsive states, empty/loading/error/blocked states, or explicit gates are visible.                    |
| Related APIs           | Coordinated Components, consumed Elements, planned sub-APIs, source files, and canonical docs are linked.                          |
| Manual review          | The page provides enough rendered proof for visual review of composition, hierarchy, responsive behavior, and workflow boundaries. |
## 19. UI Reference requirements

The UI Reference page must show rendered examples of the approved pattern compositions, not abstract notes only. It must link to this canonical standard and to consumed Element and Component standards. Deferred capabilities must appear as explicit gated disposition rows with trigger conditions, not as fake complete examples. Examples must use app-owned tokens, classes, helpers, and Blade components where available.

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Pattern contract, Live examples, and Related components and patterns.

Required Live examples internal sections:

| Required proof                  | Rendered behavior                                                                                                             | Variants/options shown                                                                                |
| ------------------------------- | ----------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------- |
| Page-level feedback region      | Page or workflow outcome renders with Notification, title/body copy, optional action, and correct spacing.                    | Success, warning, error, info; persistent and dismissible boundaries                                  |
| Inline recovery block           | Local failed region renders recovery copy and Button/Link actions near affected content.                                      | Error, unavailable, retry action, return link                                                         |
| Validation summary composition  | Form-level summary renders above form content while field errors remain field-owned.                                          | Error summary, first-error link, field-level handoff                                                  |
| Loading placeholder composition | Page or region loading state renders with Loading or Progress bar and `aria-busy` behavior where applicable.                  | Loading region, progress known/unknown, reduced motion                                                |
| Status handoff row              | Local Inline loading state transitions to persistent Tag/Link/Notification feedback.                                          | Loading, success, warning, error, info, handoff row                                                   |
| Priority and persistence matrix | Examples document critical, important, normal, and low-priority behavior.                                                     | Persistent, dismissible, temporary, gated toast                                                       |
| Recovery action grouping        | Actions render with Button and Link hierarchy and responsive wrapping.                                                        | Retry, refresh, return, view details, dismiss                                                         |
| Unavailable state               | Permission/dependency/missing-data state renders explanatory copy and recovery path.                                          | Unavailable, disabled-adjacent explanation, recovery action                                           |
| Accessibility proof             | Examples document live-region urgency, keyboard reachable actions, non-color-only status, focus behavior, and reduced motion. | Polite, assertive, focus not stolen, contrast, reduced-motion                                         |
| Deferred capabilities           | Gated rows render trigger conditions instead of fake controls.                                                                | Notification center, toast handoff, cross-route persistence, offline recovery                         |
| Developer implementation        | Canonical composed examples render as real code examples.                                                                     | Notification, Inline loading, Loading, Progress bar, Button, Link, Tag, Icon, `ui-feedback*` grouping |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed Pattern API, rendered compositions, consumed Components, consumed Elements, prohibited usage, deferred gates, and acceptance criteria.

## 20. Testing and acceptance criteria

- `/platform/ui-reference/patterns/overlays-feedback` returns 200 for authorized users.
- The page links to `docs/02-standards/ui/patterns/feedback.md` or the canonical docs route for this standard.
- The page shows installed Pattern API, states, variants/options, prohibited usage, deferred gates, and consumed Foundation Elements.
- Rendered examples include the required composition markers and consumed Component links.
- Implemented Pattern examples render production compositions.
- Deferred capabilities render trigger conditions instead of fake controls.
- No Pattern example hard-codes Foundation Element decisions that already have approved APIs.
- Page-level feedback region examples include Notification composition and optional actions.
- Inline recovery examples include recovery copy and Button/Link actions.
- Validation summary examples preserve field-level validation ownership.
- Loading placeholder examples use Loading, Inline loading, or Progress bar APIs and do not create local spinner markup.
- Status handoff examples show local pending state and resulting feedback state without competing duplicate alerts.
- Accessibility examples document live-region urgency, keyboard reachable recovery controls, non-color-only status, and reduced motion.
- Responsive examples keep recovery actions reachable and feedback text readable at small widths.
- No generic placeholder content appears.

Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/patterns/overlays-feedback');

$response->assertOk();
$response->assertSee('Feedback');
$response->assertSee('Pattern API');
$response->assertSee('Page-level feedback region');
$response->assertSee('Inline recovery block');
$response->assertSee('Validation summary composition');
$response->assertSee('Loading placeholder composition');
$response->assertSee('Status handoff row');
$response->assertSee('Notification');
$response->assertSee('Inline loading');
$response->assertSee('Loading');
$response->assertSee('Progress');
$response->assertSee('Retry');
$response->assertSee('Go to first error');
$response->assertSee('polite');
$response->assertSee('assertive');
$response->assertSee('Persistent notification center behavior');
$response->assertDontSee('Generic fallback');
$response->assertDontSee('TODO');
$response->assertDontSee('Component-specific API ' . 'pending correction');
$response->assertDontSee('Live Examples ' . 'Card');
$response->assertDontSee('Reference ' . 'Examples');
$response->assertDontSee('Legacy Contract ' . 'Summary');
$response->assertDontSee('tier' . '-1');
$response->assertDontSee('tier' . '-2');
$response->assertDontSee('cds' . '--');
$response->assertDontSee('bx' . '--');
$response->assertDontSee('alert alert-danger');
$response->assertDontSee('btn btn-primary');
```

## 21. Related APIs

| API                      | Route                                                            |
| ------------------------ | ---------------------------------------------------------------- |
| Notification             | `/platform/ui-reference/components/notification`                 |
| Inline loading           | `/platform/ui-reference/components/inline-loading`               |
| Loading                  | `/platform/ui-reference/components/loading`                      |
| Progress bar             | `/platform/ui-reference/components/progress-bar`                 |
| Button                   | `/platform/ui-reference/components/button`                       |
| Link                     | `/platform/ui-reference/components/link`                         |
| Tag                      | `/platform/ui-reference/components/tag`                          |
| Icon element             | `/platform/ui-reference/elements/icons`                          |
| Color element            | `/platform/ui-reference/elements/color`                          |
| Spacing element          | `/platform/ui-reference/elements/spacing`                        |
| Typography element       | `/platform/ui-reference/elements/typography`                     |
| Motion element           | `/platform/ui-reference/elements/motion`                         |
| Themes element           | `/platform/ui-reference/elements/themes`                         |
| Forms pattern            | `/platform/ui-reference/patterns/forms`                          |
| Table toolbar planned gap | `/platform/ui-reference/patterns/tables`                         |
| Loading pattern          | `/platform/ui-reference/patterns/loading`                        |
| Pattern overview         | `/platform/ui-reference/patterns`                                |
| Canonical feedback doc   | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Ffeedback.md` |
| Carbon patterns overview | `https://carbondesignsystem.com/patterns/overview/`              |

## 22. References

- [Pattern Library Checklist](checklist.md)
- [Component Standards](../components/index.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](index.md)
- Carbon Patterns overview informs the distinction between Pattern APIs and Component APIs: patterns are reusable combinations that support common user objectives through sequences and flows. Login App keeps its own Pattern owner routes, Blade composition rules, app-owned `ui-*` namespace, Component APIs, and Foundation Element tokens.

---
title: Progress indicator
slug: progress-indicator
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: feedback-and-loading
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/progress-indicator
canonical_doc: docs/02-standards/ui/components/progress-indicator.md
source_owner: /platform/ui-reference/components/progress-indicator
blade_api:
  - x-ui.progress-indicator
  - x-ui.progress-step
javascript_api: []
data_attributes:
  - data-ui-progress-indicator
  - data-ui-progress-step
source_files:
  - resources/views/components/ui/progress-indicator.blade.php
  - resources/views/components/ui/progress-step.blade.php
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
  - 2x-grid
related_components:
  - button
  - inline-loading
  - notification
  - progress-bar
  - tabs
related_patterns:
  - forms
  - overlays-feedback
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/progress-indicator/usage/
  - https://carbondesignsystem.com/components/progress-indicator/style/
  - https://carbondesignsystem.com/components/progress-indicator/accessibility/
---

# Progress indicator Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. `x-ui.progress-indicator` props and options](#43-x-uiprogress-indicator-props-and-options)
  - [4.4. `x-ui.progress-step` props and options](#44-x-uiprogress-step-props-and-options)
  - [4.5. Step data contract](#45-step-data-contract)
  - [4.6. Semantic state mapping](#46-semantic-state-mapping)
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
  - [9.3. Selection matrix:](#93-selection-matrix)
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

Progress indicator shows a user position in a linear step flow.

Canonical API owner: `/platform/ui-reference/components/progress-indicator`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Progress indicator is the installed Login App 2.0 linear step-flow status API. It owns step order, completed/current/incomplete/error/warning step states, horizontal and vertical layouts, optional step descriptions, optional step metadata, responsive overflow treatment, semantic current-step exposure, token-backed connector styling, and UI Reference proof for step-flow navigation status. It does not own task loading, indeterminate progress, upload progress, form validation logic, wizard routing, step persistence, or page-level workflow orchestration.

### 1.1. Canonical API responsibilities:

- Render linear step progress through `x-ui.progress-indicator` and `x-ui.progress-step`.
- Represent a user's position in a known sequence of steps.
- Expose current, completed, incomplete, error, warning, and disabled step states through token-backed classes and semantic text.
- Support horizontal and vertical layouts.
- Support compact and default density modes when space requires shorter labels.
- Support non-interactive status-only indicators and gated interactive step links when parent workflow routing is installed.
- Preserve a readable label for each step.
- Provide non-color status cues through icons, text, and semantic attributes.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, icons, and 2x Grid where composed in layouts.
- Prove step flow, current/completed/error states, vertical/horizontal layouts, responsive behavior, and developer implementation examples on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Linear percent completion for a running process. Use Progress bar when that component is installed.
- Indeterminate loading. Use Inline loading, Loading, Skeleton, or a Pattern-owned pending state.
- Wizard routing, validation, save/continue behavior, back/next buttons, or step persistence.
- Server-side validation, authorization, or step availability decisions.
- Page layout, modal/side-panel placement, form sections, and workflow orchestration.
- Decorative timeline, activity feed, breadcrumb, tabs, navigation, or page status summary behavior.

## 2. Status and ownership

| Field                        | Value                                                                                                                                          |
| ---------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                                                   |
| System maturity              | Partial                                                                                                                                        |
| API layer                    | Component API                                                                                                                                  |
| Component slug               | `progress-indicator`                                                                                                                           |
| Category                     | Feedback and loading                                                                                                                           |
| Priority                     | Tier B - Common reusable component                                                                                                             |
| UI Reference route           | `/platform/ui-reference/components/progress-indicator`                                                                                         |
| Canonical doc                | `docs/02-standards/ui/components/progress-indicator.md`                                                                                        |
| Source owner                 | `/platform/ui-reference/components/progress-indicator`                                                                                         |
| Blade API                    | `x-ui.progress-indicator`; `x-ui.progress-step`                                                                                                |
| JavaScript API               | No dedicated JavaScript controller required for installed status-only behavior                                                                 |
| Data attributes              | App-owned `data-ui-progress-indicator`; `data-ui-progress-step` when emitted by the component implementation                                   |
| Source files                 | `resources/views/components/ui/progress-indicator.blade.php`; `resources/views/components/ui/progress-step.blade.php`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid where composed in layouts                                                           |
| Carbon benchmark             | Carbon Progress indicator usage, style, and accessibility guidance                                                                             |

`Approved API` means the UI Reference route and component-specific examples exist, but the canonical documentation must replace placeholder API language with the installed step-flow contract, explicit variants/options/states, deferred gates, and regression requirements.

## 3. Installed standard

Progress indicator is installed as a step-flow status component. The approved public API is a Blade component pair that renders an ordered set of steps using app-owned `ui-*` classes and Foundation-backed state tokens.

### 3.1. The installed standard is:

- Render the wrapper through `<x-ui.progress-indicator>`.
- Render explicit steps through `<x-ui.progress-step>` or pass a documented `steps` data array to the wrapper.
- Use an ordered list internally so step order is semantic.
- Mark exactly one step as current unless the flow is complete or intentionally disabled by the parent Pattern.
- Use `aria-current="step"` on the current step.
- Use visible labels for every step.
- Use optional helper/description text only when it helps users understand the step requirement.
- Use completed state only for steps the user has already finished.
- Use error state for a completed or current step that blocks continuing.
- Use warning state for a completed or current step that needs attention but does not block continuing.
- Use disabled state only for unavailable future steps when the workflow must preview them.
- Hide future steps only when the parent Pattern intentionally avoids disclosing the total flow.
- Use horizontal layout for short flows in full-width page or modal contexts.
- Use vertical layout for longer labels, narrow containers, side panels, mobile contexts, or flows with descriptions.
- Use compact density only when labels are short and space is constrained.
- Do not animate progress connectors in a way that violates reduced-motion preferences.
- Do not use this component for indeterminate loading, file uploads, background task progress, breadcrumbs, tabs, or decorative timelines.

Carbon alignment note: Carbon documents progress indicators as step-flow components that help users track progress through a task and places them in full pages, modals, and side panels. Carbon step states include complete, current, and not-started, with state-specific visual treatment. Login App maps those principles to its own Blade API, `ui-*` classes, Heroicons, semantic status text, and UI Reference proof rather than adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical calls

Use the array-driven API when the step list is assembled by a controller or view model.

```blade
@php
    $steps = [
        ['label' => 'Account', 'status' => 'complete'],
        ['label' => 'Profile', 'status' => 'current'],
        ['label' => 'Review', 'status' => 'incomplete'],
        ['label' => 'Finish', 'status' => 'incomplete'],
    ];
@endphp

<x-ui.progress-indicator
    :steps="$steps"
    current-step="profile"
    aria-label="Registration progress"
/>
```

Use explicit step children when the markup is clearer in the view.

```blade
<x-ui.progress-indicator aria-label="Tenant setup progress" orientation="horizontal">
    <x-ui.progress-step label="Details" status="complete" />
    <x-ui.progress-step label="Billing" status="current" />
    <x-ui.progress-step label="Users" status="incomplete" />
    <x-ui.progress-step label="Review" status="incomplete" />
</x-ui.progress-indicator>
```

Use vertical layout when labels or descriptions need more room.

```blade
<x-ui.progress-indicator aria-label="Import progress" orientation="vertical">
    <x-ui.progress-step
        label="Upload CSV"
        description="Choose the source file."
        status="complete"
    />

    <x-ui.progress-step
        label="Map columns"
        description="Match spreadsheet columns to user fields."
        status="current"
    />

    <x-ui.progress-step
        label="Resolve issues"
        description="Fix rows that cannot be imported."
        status="warning"
    />

    <x-ui.progress-step
        label="Import users"
        status="incomplete"
    />
</x-ui.progress-indicator>
```

Use error state only when the step needs corrective action before the flow can continue.

```blade
<x-ui.progress-indicator aria-label="Checkout progress" orientation="horizontal">
    <x-ui.progress-step label="Cart" status="complete" />
    <x-ui.progress-step label="Shipping" status="error" />
    <x-ui.progress-step label="Payment" status="current" />
    <x-ui.progress-step label="Review" status="incomplete" />
</x-ui.progress-indicator>
```

Use the Blade APIs instead of hand-building step lists, connectors, icons, or state classes in feature views.

### 4.2. API surfaces

| API surface           | Installed value                                                                                                                                |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| Wrapper Blade API     | `x-ui.progress-indicator`                                                                                                                      |
| Step Blade API        | `x-ui.progress-step`                                                                                                                           |
| JavaScript            | No dedicated JavaScript controller required for installed status-only behavior                                                                 |
| Root semantic element | Ordered list or component-owned equivalent with an accessible label                                                                            |
| Data attributes       | `data-ui-progress-indicator`; `data-ui-progress-step` only when emitted by the component implementation                                        |
| CSS namespace         | App-owned `ui-*` progress indicator classes documented by this standard                                                                        |
| Source files          | `resources/views/components/ui/progress-indicator.blade.php`; `resources/views/components/ui/progress-step.blade.php`; `resources/css/app.css` |

### 4.3. `x-ui.progress-indicator` props and options

| Prop/option         | Type            | Default      | Allowed values                  | Required                   | Notes                                                                                                          |
| ------------------- | --------------- | ------------ | ------------------------------- | -------------------------- | -------------------------------------------------------------------------------------------------------------- |
| `steps`             | `array          | null`        | `null`                          | Step data contract entries | No                                                                                                             | Use for controller/view-model assembled flows. Omit when using explicit `x-ui.progress-step` children. |
| Default slot        | Blade slot      | empty        | `x-ui.progress-step` children   | No                         | Use when explicit markup is clearer.                                                                           |
| `aria-label`        | `string`        | none         | Short flow label                | Yes                        | Names the progress indicator region, such as `Registration progress`.                                          |
| `orientation`       | `string`        | `horizontal` | `horizontal`, `vertical`        | No                         | Use vertical for narrow containers, long labels, or descriptions.                                              |
| `density`           | `string`        | `default`    | `default`, `compact`            | No                         | Compact is for dense contexts with short labels.                                                               |
| `current-step`      | `string         | int          | null`                           | derived from step status   | Step key/index                                                                                                 | No                                                                                                     | Optional convenience prop. Exactly one step should resolve as current. |
| `interactive`       | `bool`          | `false`      | `true`, `false`                 | No                         | Gated. Only use when parent workflow supports step navigation and validation-safe routing.                     |
| `show-descriptions` | `bool`          | `true`       | `true`, `false`                 | No                         | May be false in compact horizontal layouts.                                                                    |
| `class`             | `string / null` | `null`       | Layout passthrough if supported | No                         | Parent Patterns may pass layout classes. Do not use for local state, color, typography, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and UI Reference proof before use.

### 4.4. `x-ui.progress-step` props and options

| Prop/option               | Type            | Default        | Allowed values                                                      | Required | Notes                                                                       |
| ------------------------- | --------------- | -------------- | ------------------------------------------------------------------- | -------- | --------------------------------------------------------------------------- |
| `label`                   | `string`        | none           | Short step label                                                    | Yes      | Use a concrete noun phrase or verb+noun step name.                          |
| `status`                  | `string`        | `incomplete`   | `complete`, `current`, `incomplete`, `error`, `warning`, `disabled` | No       | Use exactly one current step per active flow.                               |
| `description`             | `string / null` | `null`         | Short helper text                                                   | No       | Recommended for vertical layouts and complex steps.                         |
| `key` / `value` / `string | int             | null` / `null` | Stable step identifier                                              | No       | Required when workflow routing or state persistence references the step.    |  |  |
| `href`                    | `string / null` | `null`         | Internal route URL                                                  | Gated    | Use only with `interactive=true` and validation-safe back navigation.       |
| `icon`                    | `string / null` | status-derived | Approved Heroicon alias/component                                   | No       | Custom icons are rarely needed; status icons should remain component-owned. |
| `disabled`                | `bool`          | `false`        | `true`, `false`                                                     | No       | Equivalent to `status="disabled"` when provided.                            |
| `meta`                    | `string / null` | `null`         | Short auxiliary text                                                | No       | Use sparingly for optional due dates or counts.                             |

### 4.5. Step data contract

When `steps` is passed to `x-ui.progress-indicator`, each step must use this contract.

| Field         | Type            | Required | Notes                                                                                             |
| ------------- | --------------- | -------- | ------------------------------------------------------------------------------------------------- |
| `label`       | `string`        | Yes      | Visible step label. Escape output.                                                                |
| `status`      | `string`        | No       | `complete`, `current`, `incomplete`, `error`, `warning`, or `disabled`. Defaults to `incomplete`. |
| `description` | `string / null` | No       | Short supporting copy.                                                                            |
| `key`         | `string         | int      | null`                                                                                             | No | Stable identifier for current-step matching or workflow state. |
| `href`        | `string / null` | Gated    | Only valid when interactive step navigation is approved for the workflow.                         |
| `meta`        | `string / null` | No       | Optional count, due date, or summary. Keep short.                                                 |
| `icon`        | `string / null` | No       | Approved icon override only when the component standard permits it.                               |
| `disabled`    | `bool`          | No       | Use only when a future step is visible but unavailable.                                           |

### 4.6. Semantic state mapping

| Step status  | Meaning                                                    | Required semantic behavior                                                              |
| ------------ | ---------------------------------------------------------- | --------------------------------------------------------------------------------------- |
| `complete`   | The user has finished this step.                           | Show completed indicator and non-color complete text/icon cue.                          |
| `current`    | The user is on this step.                                  | Use `aria-current="step"`; show current indicator.                                      |
| `incomplete` | The user has not reached this step.                        | Show future/not-started indicator.                                                      |
| `error`      | This step blocks continuation or needs correction.         | Show error icon/text cue and include corrective context near the owning form/section.   |
| `warning`    | This step needs attention but does not block continuation. | Show warning icon/text cue without implying a blocking error.                           |
| `disabled`   | This step is unavailable.                                  | Show disabled treatment and prevent interactive navigation if interactivity is enabled. |

## 5. Allowed variants, options, and modifiers

| Name                        | Type           | Status                               | API                                                                 | Notes                                                                |
| --------------------------- | -------------- | ------------------------------------ | ------------------------------------------------------------------- | -------------------------------------------------------------------- |
| Step flow                   | Variant        | Implemented                          | `x-ui.progress-indicator`                                           | Default linear task-progress sequence.                               |
| Horizontal layout           | Layout         | Implemented                          | `orientation="horizontal"`                                          | Use for short flows in full-width page or modal contexts.            |
| Vertical layout             | Layout         | Implemented                          | `orientation="vertical"`                                            | Use for long labels, descriptions, side panels, or narrow contexts.  |
| Default density             | Density        | Implemented                          | `density="default"`                                                 | Standard step spacing and label treatment.                           |
| Compact density             | Density        | Implemented / required proof         | `density="compact"`                                                 | Dense contexts only; labels must remain readable.                    |
| Complete step               | State          | Implemented                          | `status="complete"`                                                 | Finished step.                                                       |
| Current step                | State          | Implemented                          | `status="current"`                                                  | Current position in the flow.                                        |
| Incomplete step             | State          | Implemented                          | `status="incomplete"`                                               | Future/not-started step.                                             |
| Error step                  | State          | Implemented                          | `status="error"`                                                    | Blocking issue on a current or completed step.                       |
| Warning step                | State          | Implemented                          | `status="warning"`                                                  | Non-blocking issue on a current or completed step.                   |
| Disabled step               | State          | Implemented                          | `status="disabled"`                                                 | Future step is visible but unavailable.                              |
| Step descriptions           | Composition    | Implemented                          | `description="..."`                                                 | Prefer vertical layout when descriptions are visible.                |
| Step metadata               | Composition    | Implemented / gated by content rules | `meta="..."`                                                        | Optional short supporting text only.                                 |
| Array-driven steps          | Composition    | Implemented                          | `:steps="$steps"`                                                   | Use when the controller/view model owns the list.                    |
| Explicit child steps        | Composition    | Implemented                          | `<x-ui.progress-step>`                                              | Use when markup clarity matters.                                     |
| Interactive step links      | Mode           | Gated                                | `interactive`, step `href`                                          | Requires validation-safe step routing and parent Pattern ownership.  |
| Clickable future steps      | Mode           | Not allowed by default               | none                                                                | Future steps should not be clickable unless workflow rules allow it. |
| Animated progress change    | Modifier       | Gated                                | component-owned motion only                                         | Must respect reduced-motion preferences and remain non-essential.    |
| Percent progress            | Not applicable | none                                 | Use Progress bar when installed.                                    |                                                                      |
| Indeterminate loading       | Not applicable | none                                 | Use Inline loading, Loading, or Skeleton.                           |                                                                      |
| Skeleton progress indicator | Not applicable | none                                 | Use Skeleton for pending page structure, not a fake step indicator. |                                                                      |
| Multi-branch step flow      | Deferred       | none                                 | Requires Pattern-owned workflow and UI Reference proof.             |                                                                      |
| Nested steps                | Not allowed    | none                                 | Keep the indicator linear and one level deep.                       |                                                                      |

## 6. States

| State                  | Status                                 | Implementation requirement                                                                                |
| ---------------------- | -------------------------------------- | --------------------------------------------------------------------------------------------------------- |
| Default                | Implemented                            | Renders ordered steps with one current step and token-backed connectors.                                  |
| Complete/success       | Implemented                            | Completed steps use success/complete treatment and non-color icon/text cue.                               |
| Current/info           | Implemented                            | Current step uses `aria-current="step"` and current/info treatment.                                       |
| Incomplete/not started | Implemented                            | Future steps remain visible and visually distinct from completed/current steps.                           |
| Error                  | Implemented                            | Error step uses error treatment and must be paired with actionable correction in the owning form/section. |
| Warning                | Implemented                            | Warning step uses warning treatment without blocking semantics unless the parent flow blocks.             |
| Disabled               | Implemented                            | Disabled step is visible only when it may become available later and is not interactive.                  |
| Hover                  | Implemented only for interactive steps | Hover treatment applies only when a step is a valid link/control.                                         |
| Focus-visible          | Implemented only for interactive steps | Interactive steps must expose visible focus in all supported themes.                                      |
| Active/pressed         | Implemented only for interactive steps | Activation state applies only to links/controls.                                                          |
| Loading                | Not applicable                         | Use Inline loading, Loading, Skeleton, or Progress bar for pending work.                                  |
| Skeleton               | Not applicable                         | Do not show fake steps for loading page structure.                                                        |
| Read-only              | Not applicable                         | The default component is status-only. Use non-interactive steps instead of read-only terminology.         |
| Validation             | Pattern-owned                          | The indicator may show error/warning status, but field-level validation belongs to Forms.                 |
| Empty                  | Not allowed                            | Do not render a progress indicator with zero steps. Hide the component until steps exist.                 |
| Overflow/truncated     | Implemented with constraints           | Prefer vertical layout. Truncate only when the full label is available through approved title text.       |
| Reduced-motion         | Implemented / required proof           | Motion must be non-essential and respect reduced-motion preferences.                                      |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Progress indicator consumes Foundation Color, Spacing, Typography, Themes, Motion, Icons, and 2x Grid where composed in layouts.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.
- 2x Grid where progress indicators are placed in pages, modals, side panels, or form layouts.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                 |
| ----------- | ----------------------------------------------------------------------------------------------------------------------------- |
| Color       | Step connector, step marker, complete/current/incomplete/error/warning/disabled states, text, icon, focus, and surface roles. |
| Spacing     | Step gap, marker-label gap, connector spacing, vertical description spacing, compact density, and responsive stacking.        |
| Typography  | Step label, optional description, optional metadata, hidden status text, and truncated label behavior.                        |
| Themes      | Light/dark/inverse token resolution for markers, connectors, labels, icons, and states.                                       |
| Motion      | Productive state transitions where installed; must respect reduced-motion preferences.                                        |
| Icons       | Heroicons for complete, error, warning, and optional status indicators.                                                       |
| 2x Grid     | Parent-owned placement in page, modal, side-panel, form, or workflow layouts.                                                 |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$border-interactive` | Active step connector/line | `ui-progress-indicator` connector active role | App border-interactive palette | Same role / app value | Active connector color must match global interactive border usage. |
| `$interactive` | Complete step icon/fill | Complete step marker/icon role | App interactive palette | Same role / app value | Complete marker uses global interactive role unless semantic success is explicitly required. |
| `$icon-primary`, `$icon-disabled` | Not-started and disabled step icons | Step marker icon roles | App icon palette | Same role / app value | Icon states must not be locally colored. |
| `$support-error`, `$support-warning` | Error/warning step icons/states | Progress status state classes | App status palette | Same role / app value | Status states need text/icon semantics. |
| `$focus` | Focusable step affordance | Step link/button focus-visible | App focus palette | Same role / app value | Focus applies only where steps are interactive. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-progress-indicator
.ui-progress-indicator-horizontal
.ui-progress-indicator-vertical
.ui-progress-indicator-compact
.ui-progress-list
.ui-progress-step
.ui-progress-step-marker
.ui-progress-step-connector
.ui-progress-step-label
.ui-progress-step-description
.ui-progress-step-meta
.ui-progress-step-complete
.ui-progress-step-current
.ui-progress-step-incomplete
.ui-progress-step-error
.ui-progress-step-warning
.ui-progress-step-disabled
.ui-progress-step-interactive
```

Feature views must not create local `progress-*`, `stepper-*`, `wizard-*`, Bootstrap progress classes, raw utility clusters, arbitrary hex colors, arbitrary spacing, custom focus rings, local SVG icons, or component-local JavaScript for the same UI role.

## 8. Composition rules

- Progress indicator must represent a known linear step flow.
- Render steps in their actual workflow order.
- Use exactly one current step while the flow is active.
- Use no current step only when every step is complete and the parent workflow clearly communicates completion.
- Use completed state only after the step is finished.
- Use error or warning states only when a specific step needs attention.
- Pair error/warning step states with actionable detail near the content that needs correction.
- Do not rely on the progress indicator alone to explain validation errors.
- Use horizontal layout for short labels and enough inline space.
- Use vertical layout when steps have descriptions, long labels, or narrow containers.
- Parent Patterns own Back, Next, Save, Continue, Cancel, and Submit buttons.
- Parent Patterns own whether steps are clickable and how navigation validates incomplete work.
- Components own internal semantics, state markers, connectors, label/description structure, and token-backed states.
- Do not place unrelated controls inside a progress step.
- Do not use progress indicator as a breadcrumb, tab list, timeline, checklist, or navigation sidebar.
- Do not show progress indicator for a single-step task.
- Do not use motion as the only cue that progress changed.

## 9. Selection guidance

### 9.1. Use when:

- Users are completing a linear task with two or more known steps.
- Users need to know where they are, what is complete, and what remains.
- A full page, modal, side panel, import flow, setup flow, or review flow needs step-position feedback.
- A completed or current step needs visible warning/error status tied to workflow progress.

### 9.2. Do not use when:

- The app is waiting for an unknown-duration task. Use Inline loading, Loading, or Skeleton.
- The app can report percent completion for a running task. Use Progress bar when installed.
- The user needs peer view switching. Use Tabs or Content switcher when installed.
- The user needs location in site hierarchy. Use Breadcrumb.
- The flow is not linear or has many branches. Use a Pattern-owned workflow.
- There is only one step.
- The component would be decorative emphasis rather than workflow status.

### 9.3. Selection matrix:

| Need                                                     | Use                                      |
| -------------------------------------------------------- | ---------------------------------------- |
| Linear setup, wizard, onboarding, import, or review flow | Progress indicator                       |
| Known percent complete                                   | Progress bar                             |
| Unknown pending work                                     | Inline loading, Loading, or Skeleton     |
| Page hierarchy                                           | Breadcrumb                               |
| Switching between equal views                            | Tabs or Content switcher                 |
| Timeline/history                                         | Timeline Pattern when installed          |
| Checklist of independent tasks                           | Checklist Pattern or List when installed |
| Form field validation                                    | Forms Pattern and field components       |

## 10. Accessibility contract

- The progress indicator must have an accessible label, usually through `aria-label`.
- Step order must be semantic, preferably an ordered list.
- The current step must expose `aria-current="step"`.
- Status must not rely on color alone.
- Complete, error, warning, disabled, and current states must use a non-color cue such as icon, text, or hidden status text.
- Labels must remain visible and readable.
- Descriptions must be associated with their step when present.
- Interactive steps must be real links or buttons and must expose visible focus.
- Non-interactive steps must not be placed in the tab order.
- Disabled steps must not be interactive.
- Error/warning status in the indicator must not replace field-level error messaging.
- Motion must be non-essential and must respect reduced-motion preferences.
- Long labels must wrap or use an approved truncation pattern that preserves the full label.
- In RTL contexts, horizontal order, connectors, and alignment must mirror through the component implementation.

## 11. Content contract

- Use sentence case.
- Use short step labels.
- Prefer concrete nouns or verb-led labels: `Account`, `Profile`, `Upload CSV`, `Map columns`, `Review`.
- Avoid vague labels such as `Step 1`, `Next`, `More`, `Details` when the actual task can be named.
- Do not include the step number in the label unless the workflow requires it for user support.
- Use descriptions only when they add useful guidance.
- Keep descriptions to one short sentence.
- Use warning and error copy near the owning form/section; the indicator label should remain concise.
- Use metadata sparingly and keep it short.
- Do not overload step labels with counts, badges, due dates, and status text at the same time.
- Truncated labels must expose the full label through an approved title or tooltip mechanism.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not create feature-local steppers, wizard indicators, or progress timelines for the same UI role.
- Do not use Bootstrap `.progress` classes or direct Carbon production classes in app markup.
- Do not use progress indicator for indeterminate loading or percent progress.
- Do not use progress indicator as Breadcrumb, Tabs, Navigation, Timeline, Checklist, or decorative emphasis.
- Do not render a progress indicator with zero steps or one step.
- Do not render more than one current step in an active flow.
- Do not make future steps clickable unless the parent Pattern owns validation-safe navigation.
- Do not use disabled steps for permission-impossible content. Hide unavailable steps when they will never become available.
- Do not rely on color alone for status or meaning.
- Do not animate state changes in a way that violates reduced-motion preferences.
- Do not put form controls, buttons, dropdowns, uploads, or complex content inside a step marker or label.
- Do not use raw `li`, connector, and icon markup in feature views when the component API can render the flow.

## 13. Deferred or gated capabilities

| Capability                      | Status        | Gate                                                                                                                     |
| ------------------------------- | ------------- | ------------------------------------------------------------------------------------------------------------------------ |
| Interactive step navigation     | Gated         | Requires parent Pattern ownership, validation-safe routing, focus behavior, disabled-step rules, and UI Reference proof. |
| Clickable future steps          | Gated         | Requires workflow proof that users may safely jump ahead.                                                                |
| Multi-branch progress indicator | Deferred      | Requires Pattern-owned model, content rules, and UI Reference proof.                                                     |
| Nested substeps                 | Not allowed   | Use a Pattern-owned wizard or checklist. The installed indicator is one level deep.                                      |
| Percent progress                | Not owned     | Use Progress bar when installed.                                                                                         |
| Indeterminate loading           | Not owned     | Use Inline loading, Loading, or Skeleton.                                                                                |
| Async upload/import progress    | Pattern-owned | Requires progress bar/loading APIs and workflow-specific messaging.                                                      |
| Animated connector progress     | Gated         | Requires Motion Element approval, reduced-motion proof, and UI Reference proof.                                          |
| Custom status colors            | Not allowed   | Requires Color Element update and UI Reference proof.                                                                    |
| Arbitrary icons                 | Not allowed   | Requires Icons Element update and component proof.                                                                       |
| Arbitrary sizes                 | Not allowed   | Requires Typography, Spacing, and UI Reference updates.                                                                  |

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

The Progress indicator page is a workflow-status reference page. The Live examples card may use grouped examples, state matrices, layout comparisons, responsive examples, and developer implementation examples. It must not render fake loading, fake progress-bar, or fake wizard-routing behavior.

### 15.1. Required Live examples internal sections:

| Required proof                   | Rendered behavior                                                                                                                       | Variants/options shown                                                                       |
| -------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| Step flow                        | A linear multi-step flow shows completed, current, and incomplete steps in order.                                                       | Complete, Current, Incomplete, Horizontal, Default density                                   |
| Current/completed/error step     | A workflow shows current, completed, error, and warning states with non-color cues.                                                     | Complete, Current, Error, Warning, Disabled, Status text/icon cues                           |
| Vertical/horizontal              | Layout comparison renders the same flow horizontally and vertically.                                                                    | Horizontal, Vertical, Labels, Descriptions, Responsive behavior                              |
| Compact density                  | Dense example renders shorter labels without losing readability or semantics.                                                           | Compact, Short labels, Current step, Completed steps                                         |
| Descriptions and metadata        | Vertical example shows optional descriptions and short metadata without overloading labels.                                             | Description, Metadata, Vertical layout                                                       |
| Interactive navigation gate      | Page documents when interactive steps are allowed and shows non-interactive default behavior.                                           | Gated interactive steps, Disabled future steps, Validation-safe routing note                 |
| Accessibility proof              | Examples expose accessible labels, ordered steps, `aria-current="step"`, and non-color status cues.                                     | `aria-label`, `aria-current`, Hidden status text, Icon/text cue                              |
| Reduced-motion proof             | State change examples use approved Motion behavior and document reduced-motion requirements.                                            | Reduced-motion, Non-essential animation                                                      |
| Developer implementation         | Canonical Blade calls and step data contract render as real code examples.                                                              | `x-ui.progress-indicator`, `x-ui.progress-step`, `steps`, `orientation`, `density`, `status` |
| Prohibited and deferred examples | Page shows progress bar, loading, breadcrumb, tabs, timeline, nested steps, and fake wizard routing as not approved for this component. | Prohibited usage, Deferred gates, Approved alternatives                                      |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered states, rendered variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/progress-indicator` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- Developer examples use `x-ui.progress-indicator` and `x-ui.progress-step`, not placeholder comments or ad hoc markup.
- Step flow examples render completed, current, and incomplete states.
- Current step examples include `aria-current="step"`.
- Error and warning examples include non-color cues and concise status meaning.
- Horizontal and vertical examples render with the same data model.
- Compact density examples render only with short labels.
- Disabled step examples do not present disabled steps as permission-impossible actions.
- Interactive navigation examples are clearly gated and do not imply future steps are clickable by default.
- Loading, skeleton, progress bar, breadcrumb, tab, timeline, and checklist examples are shown only as alternatives or prohibited usage, not as Progress indicator variants.
- The page contains no generic placeholder content.
- Tests assert stale labels and legacy scaffolding remain absent when they are not part of approved UI copy.
- Tests assert no raw Bootstrap progress class, hard-coded color, arbitrary local spacing, feature-local stepper class system, local JavaScript stepper, or direct Carbon production class is presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/progress-indicator');

$response->assertOk();
$response->assertSee('Progress indicator');
$response->assertSee('x-ui.progress-indicator');
$response->assertSee('x-ui.progress-step');
$response->assertSee('ui-progress-indicator');
$response->assertSee('Step flow');
$response->assertSee('Current/completed/error step');
$response->assertSee('Vertical/horizontal');
$response->assertSee('Compact density');
$response->assertSee('aria-current="step"', false);
$response->assertSee('orientation="horizontal"', false);
$response->assertSee('orientation="vertical"', false);
$response->assertSee('status="complete"', false);
$response->assertSee('status="current"', false);
$response->assertSee('status="error"', false);
$response->assertSee('status="warning"', false);
$response->assertSee('status="disabled"', false);
$response->assertSee('Interactive step navigation');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('<li>None.</li>', false);
$response->assertDontSee('Use only documented props/options');
$response->assertDontSee('See UI Reference developer implementation section');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('progress-bar bg-');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 17. Related APIs

| API                              | Route                                                                        |
| -------------------------------- | ---------------------------------------------------------------------------- |
| Button                           | `/platform/ui-reference/components/button`                                   |
| Inline loading                   | `/platform/ui-reference/components/inline-loading`                           |
| Notification                     | `/platform/ui-reference/components/notification`                             |
| Progress bar                     | `/platform/ui-reference/components/progress-bar`                             |
| Tabs                             | `/platform/ui-reference/components/tabs`                                     |
| Forms pattern                    | `/platform/ui-reference/patterns/forms`                                      |
| Overlay/feedback pattern         | `/platform/ui-reference/patterns/overlays-feedback`                          |
| Layout Pattern                   | `/platform/ui-reference/patterns/layout`                                     |
| Color element                    | `/platform/ui-reference/elements/color`                                      |
| Spacing element                  | `/platform/ui-reference/elements/spacing`                                    |
| Typography element               | `/platform/ui-reference/elements/typography`                                 |
| Themes element                   | `/platform/ui-reference/elements/themes`                                     |
| Motion element                   | `/platform/ui-reference/elements/motion`                                     |
| Icons element                    | `/platform/ui-reference/elements/icons`                                      |
| Components overview              | `/platform/ui-reference/components`                                          |
| Canonical progress indicator doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fprogress-indicator.md` |
| Carbon progress indicator usage  | `https://carbondesignsystem.com/components/progress-indicator/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Progress indicator usage, style, and accessibility guidance inform step-flow placement, complete/current/not-started status treatment, linear task-progress usage, and accessibility review expectations. Login App keeps its own Blade API, Heroicons icon standard, app-owned `ui-*` classes, semantic status mapping, and UI Reference proof.
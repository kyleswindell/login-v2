---
title: Forms
slug: forms
api_layer: Pattern API
status: implemented
system_maturity: standard
category: data-entry
priority: tier-a-baseline-app-development
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/patterns/forms.md
source_owner: not installed
blade_api:
  - x-patterns.form-section
  - x-patterns.inline-form-row
  - x-patterns.form-actions
  - validation summary composition
  - field group spacing utilities
javascript_api: []
data_attributes: []
source_files:
  - resources/views/components/patterns/form-section.blade.php
  - resources/views/components/patterns/inline-form-row.blade.php
  - resources/views/components/patterns/form-actions.blade.php
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
  - text-input
  - textarea
  - select
  - checkbox
  - radio
  - toggle
  - button
  - notification
  - inline-loading
  - toggletip
related_patterns:
  - common-actions
  - overlays-feedback
  - page-header
  - table-toolbar
carbon_reference:
  - https://carbondesignsystem.com/patterns/forms-pattern/
  - https://carbondesignsystem.com/components/form/usage/
  - https://carbondesignsystem.com/components/form/style/
  - https://carbondesignsystem.com/components/form/accessibility/
---

# Forms Pattern API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Pattern API](#4-pattern-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. `x-patterns.form-section` props](#43-x-uipatternsform-section-props)
  - [4.4. `x-patterns.inline-form-row` props](#44-x-uipatternsinline-form-row-props)
  - [4.5. `x-patterns.form-actions` props](#45-x-uipatternsform-actions-props)
  - [4.6. Validation summary composition](#46-validation-summary-composition)
  - [4.7. Field group spacing utilities](#47-field-group-spacing-utilities)
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
- [18. Implementation and Rendered Evidence Checklist](#18-implementation-and-ui-reference-checklist)
  - [18.1. Implementation checklist](#181-implementation-checklist)
  - [18.2. rendered evidence proof checklist](#182-ui-reference-proof-checklist)
- [19. Rendered evidence requirements](#19-ui-reference-requirements)
- [20. Testing and acceptance criteria](#20-testing-and-acceptance-criteria)
- [21. Related APIs](#21-related-apis)
- [22. References](#22-references)

## 1. API summary

Form patterns define how field Components, validation feedback, helper text, section structure, and actions compose into reliable data-entry surfaces.

Canonical API owner: `not installed`. Use this Pattern API instead of creating local form layouts, validation placement, action rows, or field-group spacing for the same UI role.

Forms is the installed Login App 2.0 data-entry composition API. It owns form section structure, field grouping, validation-summary placement, submit/action placement, read-only/editable group composition, status placement, responsive field layout, and orchestration between approved field Components. It does not redefine field internals, primitive tokens, validation business rules, permissions, persistence, controller behavior, or feature-specific branching.

Canonical API responsibilities:

- Compose approved field Components into consistent settings, create/edit, profile/account, and setup form surfaces.
- Render field groups through app-owned Pattern components and spacing utilities.
- Place labels, helper text, validation feedback, validation summaries, and actions predictably.
- Preserve semantic reading and keyboard order across responsive breakpoints.
- Separate Pattern-owned grouping and external spacing from Component-owned field APIs.
- Support standard settings forms, inline rows, dense groups, read-only detail groups, and validation-summary forms.
- Own submitting, saved, validation-summary, and blocked form states.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, icons, and 2x grid where layout requires it.
- Prove rendered compositions on the rendered evidence page with canonical app examples, consumed Component links, deferred gates, and regression assertions.

Non-owned responsibilities:

- Field-specific markup and local states. Text input, textarea, select, checkbox, radio, toggle, file uploader, and similar Components own labels, helper text, error/warning rendering, focus, disabled, read-only, and internal spacing.
- Button variants, button loading internals, and icon-button behavior. Button owns command controls; Forms owns action-row placement and hierarchy.
- Shared action vocabulary such as save, cancel, reset, clear, destructive action, and command/navigation distinctions. Common Actions owns those semantics; Forms applies them to form submit areas.
- Notifications and validation message component internals. Notification owns message surface styling; Forms owns where summary/status feedback appears.
- Business validation rules, authorization, request classes, persistence, save endpoints, data loading, and workflow branching.
- Modal focus trapping, overlay placement, and blocking-dialog behavior. Overlay/feedback Patterns own those contexts.

## 2. Status and ownership

| Field                        | Value                                                                                                                                             |
| ---------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented standard                                                                                                                              |
| System maturity              | Standard                                                                                                                                          |
| API layer                    | Pattern API                                                                                                                                       |
| Pattern slug                 | `forms`                                                                                                                                           |
| Category                     | Data entry                                                                                                                                        |
| Priority                     | Tier A - Baseline app development                                                                                                                 |
| Rendered evidence route           | `not installed`                                                                                                           |
| Canonical doc                | `docs/02-standards/ui/patterns/forms.md`                                                                                                          |
| Source owner                 | `not installed`                                                                                                           |
| Blade API                    | `x-patterns.form-section`; `x-patterns.inline-form-row`; `x-patterns.form-actions`; validation summary composition; field group spacing utilities |
| JavaScript API               | None required for installed static form composition                                                                                               |
| Data attributes              | None required for installed pattern behavior                                                                                                      |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid                                                                                        |
| Carbon benchmark             | Carbon Forms pattern and Form component guidance                                                                                                  |

`Implemented standard` means the form composition pattern is approved for production use when it composes installed Element and Component APIs. Feature modules may implement business-specific forms, but they must use this Pattern API for grouping, spacing, validation placement, action placement, and responsive composition.

## 3. Installed standard

Use form patterns for settings, create/edit pages, account/profile editing, setup flows, and any surface where users submit or save structured input. Patterns compose approved Component and Element APIs; they do not redefine primitive visual decisions or feature-specific business behavior.

The installed standard is:

- Use `<x-patterns.form-section>` for a titled group of related fields.
- Use `<x-patterns.inline-form-row>` when a field label/description and control should sit on the same row at supported widths.
- Use `<x-patterns.form-actions>` for submit/cancel/secondary action placement.
- Use app-owned validation summary composition when multiple field errors must be summarized above the form or section.
- Use field group spacing utilities only where documented by this Pattern API.
- Use field Components for all actual inputs; do not hand-build text inputs, selects, textareas, toggles, checkboxes, radios, or uploaders inside a form.
- Use Button Component APIs for submit, cancel, delete, reset, or secondary commands.
- Use Notification or Inline loading Components for section-level save status, saved state, pending state, or blocking submission status where appropriate.
- Keep labels, helper text, and field-level validation next to the relevant field Component.
- Keep submit/save actions at the end of the form or section they submit.
- Keep destructive actions visually and semantically separated from primary submit actions.
- Collapse multi-column layouts to one column at narrow widths without changing semantic order.
- Do not hide required fields in collapsed content.
- Do not introduce arbitrary margins on child Components to make form spacing work.

Carbon alignment note: Carbon defines forms as groups of related controls for submitting information, emphasizes consistency across product form types, documents one-column and two-column form structures with mobile collapse to one column, and calls out accessible inline error/warning messages and keyboard-accessible help. Login App maps those principles to its own Pattern components, `ui-*` class contract, installed field Components, Button actions, Notification/Inline loading feedback, and rendered evidence proof rather than adopting Carbon implementation classes directly.

## 4. Pattern API

### 4.1. Canonical calls

Use form sections for standard page, settings, account, and create/edit forms.

```blade
<form method="POST" action="{{ route('settings.profile.update') }}">
    @csrf
    @method('PUT')

    <x-patterns.form-section
        title="Profile details"
        description="Update the account information shown to administrators."
    >
        <x-ui.text-input
            name="name"
            label="Display name"
            :value="old('name', $user->name)"
            autocomplete="name"
            required
        />

        <x-ui.text-input
            name="email"
            type="email"
            label="Email address"
            :value="old('email', $user->email)"
            autocomplete="email"
            required
        />
    </x-patterns.form-section>

    <x-patterns.form-actions>
        <x-ui.button type="submit" semantic="primary">
            Save changes
        </x-ui.button>

        <x-ui.button type="button" semantic="ghost">
            Cancel
        </x-ui.button>
    </x-patterns.form-actions>
</form>
```

Use inline rows when the setting name and explanatory copy belong beside a compact control.

```blade
<x-patterns.form-section
    title="Security"
    description="Manage sign-in and account protection settings."
>
    <x-patterns.inline-form-row
        label="Require two-factor authentication"
        description="Require users to verify their identity when signing in."
    >
        <x-ui.toggle
            name="requires_two_factor"
            :checked="old('requires_two_factor', $tenant->requires_two_factor)"
            label="Require two-factor authentication"
            label-visibility="sr-only"
        />
    </x-patterns.inline-form-row>
</x-patterns.form-section>
```

Use validation summaries when the form has multiple blocking errors or when a submit action can move focus to a summary before field-level repair.

```blade
@if ($errors->any())
    <x-ui.notification
        semantic="error"
        title="Review the highlighted fields"
        class="ui-form-validation-summary"
    >
        <ul class="ui-form-validation-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-ui.notification>
@endif
```

Use read-only detail groups when the user is inspecting structured data in the same layout family without edit permission.

```blade
<x-patterns.form-section
    title="Account details"
    description="Current account information."
    mode="readonly"
>
    <dl class="ui-form-readonly-grid">
        <div class="ui-form-readonly-item">
            <dt class="ui-form-readonly-label">Display name</dt>
            <dd class="ui-form-readonly-value">{{ $user->name }}</dd>
        </div>

        <div class="ui-form-readonly-item">
            <dt class="ui-form-readonly-label">Email address</dt>
            <dd class="ui-form-readonly-value">{{ $user->email }}</dd>
        </div>
    </dl>
</x-patterns.form-section>
```

### 4.2. API surfaces

| API surface           | Installed value                                                                    |
| --------------------- | ---------------------------------------------------------------------------------- |
| Section Blade API     | `x-patterns.form-section`                                                          |
| Inline row Blade API  | `x-patterns.inline-form-row`                                                       |
| Action row Blade API  | `x-patterns.form-actions`                                                          |
| Validation summary    | Notification-based composition using app-owned form summary classes                |
| Field group utilities | App-owned `ui-form-*` spacing and grouping classes documented here                 |
| JavaScript            | No dedicated JavaScript controller required for installed form layout composition  |
| Data attributes       | None required for installed pattern behavior                                       |
| CSS namespace         | App-owned `ui-form-*` and related `ui-*` classes                                   |
| Source ownership      | `not installed`; shared styling in `resources/css/app.css` |

### 4.3. `x-patterns.form-section` props

| Prop/option   | Type     | Default    | Allowed values         | Required                                  | Notes                                                                        |
| ------------- | -------- | ---------- | ---------------------- | ----------------------------------------- | ---------------------------------------------------------------------------- |
| `title`       | `string` | none       | Short section heading  | Yes                                       | Names the field group.                                                       |
| `description` | `string  | null`      | `null`                 | One or two short sentences                | No                                                                           | Explains the purpose of the group, not every field rule.                             |
| `mode`        | `string` | `editable` | `editable`, `readonly` | No                                        | Use `readonly` for detail groups that preserve form-like structure.          |
| `density`     | `string` | `default`  | `default`, `dense`     | No                                        | Dense is for admin/productive forms only. Do not use to solve page crowding. |
| `columns`     | `string` | `one`      | `one`, `two`           | No                                        | Two-column rows must collapse to one column at narrow widths.                |
| `status`      | `string  | null`      | `null`                 | `saved`, `submitting`, `blocked`, `error` | No                                                                           | Section-level status only; field errors remain field-owned.                          |
| `class`       | `string  | null`      | `null`                 | Layout passthrough if supported           | No                                                                           | Parent layouts may pass placement classes. Do not override tokens or states locally. |

### 4.4. `x-patterns.inline-form-row` props

| Prop/option   | Type       | Default   | Allowed values                             | Required               | Notes                                                                |
| ------------- | ---------- | --------- | ------------------------------------------ | ---------------------- | -------------------------------------------------------------------- |
| `label`       | `string`   | none      | Short setting label                        | Yes                    | Describes the row. Child field still needs its own accessible label. |
| `description` | `string    | null`     | `null`                                     | Short explanatory copy | No                                                                   | Use for consequence or context. |
| `align`       | `string`   | `start`   | `start`, `center`                          | No                     | Use `center` only for compact controls such as toggles.              |
| `density`     | `string`   | `default` | `default`, `dense`                         | No                     | Must match the parent form-section density.                          |
| Default slot  | Blade slot | none      | One field Component or compact field group | Yes                    | Do not put unrelated actions or complex layouts in an inline row.    |

### 4.5. `x-patterns.form-actions` props

| Prop/option  | Type       | Default | Allowed values                             | Required                                  | Notes                                                                                    |
| ------------ | ---------- | ------- | ------------------------------------------ | ----------------------------------------- | ---------------------------------------------------------------------------------------- |
| `align`      | `string`   | `end`   | `start`, `end`, `between`                  | No                                        | Use `end` for most page/settings forms.                                                  |
| `sticky`     | `bool`     | `false` | `true`, `false`                            | No                                        | Gated for long forms or side panels; requires Pattern proof for overlap/scroll behavior. |
| `status`     | `string    | null`   | `null`                                     | `saved`, `submitting`, `blocked`, `error` | No                                                                                       | Optional action-row status when feedback belongs near submit. |
| Default slot | Blade slot | none    | Button Components and optional status copy | Yes                                       | Use Button APIs only.                                                                    |

### 4.6. Validation summary composition

Validation summaries are Pattern-owned placement but Notification-owned visual treatment.

| Requirement        | Rule                                                                                                               |
| ------------------ | ------------------------------------------------------------------------------------------------------------------ |
| Summary placement  | Place before the first invalid field group or at the top of the submitted form region.                             |
| Summary component  | Use Notification or the installed app validation-summary composition.                                              |
| Field-level errors | Keep errors on fields in addition to the summary.                                                                  |
| Focus behavior     | On failed submit, feature code may move focus to the summary when a page reload or validation handler supports it. |
| Links to fields    | Gated until a field-anchor and focus contract is documented.                                                       |
| Error copy         | State what needs attention and keep item text short.                                                               |

### 4.7. Field group spacing utilities

Approved form grouping classes:

```css
.ui-form
.ui-form-section
.ui-form-section-header
.ui-form-section-title
.ui-form-section-description
.ui-form-section-body
.ui-form-field-group
.ui-form-field-grid
.ui-form-field-grid-two
.ui-form-inline-row
.ui-form-inline-row-content
.ui-form-inline-row-control
.ui-form-actions
.ui-form-actions-status
.ui-form-validation-summary
.ui-form-validation-list
.ui-form-readonly-grid
.ui-form-readonly-item
.ui-form-readonly-label
.ui-form-readonly-value
.ui-form-dense
.ui-form-submitting
.ui-form-saved
.ui-form-blocked
```

Feature views must not create local margin stacks, raw grid utilities, ad hoc validation-summary classes, Bootstrap form groups, or feature-specific spacing patches for form composition.

## 5. Required composition

Form patterns must compose approved Component and Element APIs.

Required Component APIs as applicable:

| Need                                                  | Use                                                        |
| ----------------------------------------------------- | ---------------------------------------------------------- |
| Single-line text entry                                | Text input                                                 |
| Long-form text entry                                  | Textarea                                                   |
| Short known single-choice list                        | Select                                                     |
| Multiple independent choices                          | Checkbox                                                   |
| One visible mutually exclusive choice set             | Radio                                                      |
| Immediate on/off setting                              | Toggle                                                     |
| File selection                                        | File uploader                                              |
| Submit/cancel/destructive commands                    | Button                                                     |
| Form-level validation, saved status, or blocked state | Notification                                               |
| Pending submit/status                                 | Inline loading or Button loading                           |
| Contextual accessible help                            | Toggletip                                                  |
| One or more step flows                                | Progress indicator only when a multi-step form is approved |

Required Element APIs:

| Element API | Use in Forms                                                                                                  |
| ----------- | ------------------------------------------------------------------------------------------------------------- |
| Color       | Surfaces, text, borders, validation, disabled, saved, blocked, focus, and state roles.                        |
| Spacing     | Field gaps, section gaps, row layout, action rows, validation summary spacing, and responsive collapse.       |
| Typography  | Section headings, descriptions, labels, helper text, validation copy, status copy, and read-only detail text. |
| Themes      | Light, dark, layered, and inverse contexts when a parent surface requires them.                               |
| Motion      | Disclosure, status transitions, loading entry, and reduced-motion behavior where installed.                   |
| Icons       | Status icons, help/disclosure icons, and approved Component icons only.                                       |
| 2x Grid     | Page-level and multi-column form layout through Pattern-owned composition.                                    |

## 6. Optional composition

| Composition                                    | Status         | Use when                                                                  | Rules                                                                  |
| ---------------------------------------------- | -------------- | ------------------------------------------------------------------------- | ---------------------------------------------------------------------- |
| Inline validation summary                      | Implemented    | Multiple field errors need a scannable summary.                           | Keep field-level errors in place.                                      |
| Read-only field group                          | Implemented    | Structured data should remain form-like but not editable.                 | Use semantic description list or read-only Component states.           |
| Progressive disclosure for optional assistance | Gated          | Optional help would otherwise distract from the core form.                | Use approved disclosure/toggletip APIs; do not hide required fields.   |
| Section-level save status                      | Implemented    | One section saves independently or needs local saved/submitting feedback. | Use Notification, Inline loading, or action-row status.                |
| Sticky actions                                 | Gated          | Long forms need persistent actions.                                       | Requires overlap/scroll proof and responsive behavior in rendered evidence. |
| Multi-step wizard forms                        | Deferred/gated | A feature has a real linear setup flow.                                   | Requires Progress indicator ownership review and Pattern proof.        |

## 7. Consumed Element APIs

- Color tokens for surfaces, text, status, focus, validation, disabled, read-only, saved, and blocked state behavior.
- Spacing and 2x grid APIs for section, field, row, action, summary, and responsive layout relationships.
- Typography APIs for section headings, descriptions, labels, helper text, validation copy, body copy, read-only values, and code where applicable.
- Icon and motion APIs where status, disclosure, loading, or animated transitions appear.
- Theme APIs for light, dark, layered, and inverse contexts.

Carbon color composition mapping:

| Pattern need                                                                  | Carbon benchmark role                                                   | Login App owner to compose                         | Mapping rule                                                                   |
| ----------------------------------------------------------------------------- | ----------------------------------------------------------------------- | -------------------------------------------------- | ------------------------------------------------------------------------------ |
| Field surfaces, borders, labels, helper text, validation, disabled, read-only | Text input, Select, Dropdown, Checkbox, Radio button, Search field rows | Field Components + Color Element                   | Forms must compose field Component mappings; no form-local field colors.       |
| Submit, cancel, secondary, destructive, and loading actions                   | Button token families                                                   | Button Component                                   | Action rows consume Button semantic roles only.                                |
| Validation summary, saved/blocked/submitting status                           | Notification, Inline loading, Loading support/status rows               | Notification / Inline Loading / Loading Components | Forms place feedback; Components own status surfaces, icons, text, and focus.  |
| Section and read-only detail surfaces                                         | `$layer`, `$background`, text/border roles                              | Layout/Data and Content Patterns + Color Element   | Forms may group surfaces but must not create route-specific card colors.       |
| Multi-step or wizard progress                                                 | Progress indicator rows                                                 | Progress Indicator Component                       | Forms compose progress state; Progress indicator owns marker/connector colors. |

## 8. Owned Component APIs

The Forms Pattern owns composition rules around installed Components. It does not own the internals of those Components.

| Area                           | Pattern owns                                                        | Component owns                                            |
| ------------------------------ | ------------------------------------------------------------------- | --------------------------------------------------------- |
| Form section layout            | Section header, body grouping, section spacing, responsive grouping | Field internals, field labels, control styling            |
| Field grouping                 | Row/column relationship, group spacing, semantic order              | Individual control markup and field states                |
| Validation placement           | Summary location and relationship to field groups                   | Field-level error/warning rendering                       |
| Action row placement           | Submit/cancel/destructive placement, grouping, responsive stacking  | Button semantics, variants, loading/disabled internals    |
| Read-only/editable composition | When a group renders as read-only inspection vs editable fields     | Read-only state styling for individual Components         |
| Save/status feedback           | Where section/form status appears                                   | Notification/Inline loading visual and semantic treatment |

## 9. Allowed variants and layout options

| Name                       | Type           | Status                                | API                                                      | Notes                                                    |
| -------------------------- | -------------- | ------------------------------------- | -------------------------------------------------------- | -------------------------------------------------------- |
| Standard settings form     | Variant        | Implemented                           | `x-patterns.form-section` + `x-patterns.form-actions`    | Default for account/profile/settings editing.            |
| Create/edit form           | Variant        | Implemented                           | `form-section`, field Components, `form-actions`         | Use for feature entities and structured data submission. |
| Inline form row            | Layout option  | Implemented                           | `x-patterns.inline-form-row`                             | Best for compact settings and toggles.                   |
| Dense field group          | Density option | Implemented                           | `density="dense"` or `.ui-form-dense`                    | Productive admin context only.                           |
| Two-column field grid      | Layout option  | Implemented/gated by responsive proof | `columns="two"` or `.ui-form-field-grid-two`             | Must collapse without changing semantic order.           |
| Read-only detail group     | Mode           | Implemented                           | `mode="readonly"` or read-only composition               | Use for inspection or no-edit permission contexts.       |
| Validation summary form    | Composition    | Implemented                           | Notification summary + field errors                      | Use for multiple blocking errors.                        |
| Section-level save status  | Composition    | Implemented                           | `status` prop or Notification/Inline loading composition | Use when sections save independently.                    |
| Progressive optional help  | Composition    | Gated                                 | Toggletip/disclosure composition                         | Do not hide required content.                            |
| Sticky form actions        | Composition    | Gated                                 | `sticky` if installed/proven                             | Requires scroll and overlap proof.                       |
| Multi-step wizard form     | Variant        | Deferred/gated                        | Progress indicator + Forms Pattern                       | Requires feature trigger and ownership review.           |
| Inline editable table form | Variant        | Pattern-owned elsewhere               | Data table pattern                                       | Do not use Forms Pattern alone for table editing.        |
| Custom local form layout   | Not allowed    | none                                  | Use this Pattern API instead.                            |

## 10. State ownership

The form pattern owns submitting, saved, validation-summary, and blocked states. Field Components own focused, disabled, readonly, error, warning, and helper states.

| State                 | Owner                                 | Status                    | Implementation requirement                                                                             |
| --------------------- | ------------------------------------- | ------------------------- | ------------------------------------------------------------------------------------------------------ |
| Default               | Forms Pattern                         | Implemented               | Form sections, field groups, and actions render with approved spacing and semantic order.              |
| Submitting            | Forms Pattern + Button/Inline loading | Implemented               | Submit controls prevent duplicate submission and pending status is visible near the action or section. |
| Saved                 | Forms Pattern + Notification/Status   | Implemented               | Saved feedback appears near the saved section/form and does not replace field labels or helper text.   |
| Validation summary    | Forms Pattern + Notification          | Implemented               | Summary appears before invalid region and field-level errors remain in place.                          |
| Blocked               | Forms Pattern + Notification/Button   | Implemented               | Blocking issue explains why the form cannot be submitted and keeps affected fields discoverable.       |
| Field focused         | Field Component                       | Implemented by field APIs | Do not add Pattern focus styling.                                                                      |
| Field disabled        | Field Component                       | Implemented by field APIs | Do not use disabled fields to hide permission-impossible actions without context.                      |
| Field read-only       | Field Component/Forms Pattern         | Implemented               | Individual fields own read-only visuals; Forms owns read-only group composition.                       |
| Field error/warning   | Field Component                       | Implemented by field APIs | Forms may summarize but must not replace field-level feedback.                                         |
| Loading field options | Field Component/Feature               | Gated by field API        | Select/search loaders remain field/component owned.                                                    |
| Dirty/unsaved         | Gated                                 | Future state              | Requires global saved/unsaved behavior and route-leave rules.                                          |

## 11. Responsive behavior

Fields stack at narrow widths. Multi-column form rows must collapse without changing semantic order or separating labels from controls.

Responsive requirements:

- One-column form sections remain one column at all breakpoints.
- Two-column field grids collapse to one column at narrow widths.
- Inline rows may place label/description and control side by side at wider widths, but must stack at narrow widths.
- Label, helper text, control, and field-level validation must remain visually and semantically grouped.
- Action rows may stack at narrow widths, but submit/cancel hierarchy must remain clear.
- Destructive actions must not move next to primary submit actions in a way that implies equal hierarchy.
- Sticky or persistent action rows are gated until rendered evidence proves safe behavior across scroll and viewport sizes.
- Multi-column visual order must match DOM order.
- Do not use CSS ordering to change semantic sequence.

## 12. Composition rules

- Patterns own grouping, external spacing, orchestration, and responsive composition.
- Child Components own their public APIs, local states, accessibility semantics, and internal spacing.
- Feature modules own business rules, permissions, data loading, persistence, and workflow-specific branching.
- Use a semantic `<form>` element when user input is submitted.
- Use one clear submit target per form section unless sections intentionally save independently.
- Use one primary submit action per form/action region.
- Pair cancel/back actions with the primary action when the user can safely leave the flow.
- Keep destructive actions visually separated from save/submit actions.
- Keep validation summary and field-level errors synchronized.
- Do not place unrelated controls in the same form section.
- Do not nest forms.
- Do not make an entire form section clickable.
- Do not use placeholder text as the only label.
- Do not use disabled fields as the only way to communicate missing permissions or blocked state.
- Required/optional treatment must be consistent across the product or at least across forms of the same type.
- Do not hide required fields, required acknowledgments, or blocking validation inside collapsed content.
- Keep progressive disclosure optional and reversible.
- Keep keyboard order aligned with visual order.
- Parent page Patterns own page title, header actions, breadcrumbs, and surrounding layout.

## 13. Selection guidance

Use Forms Pattern when:

- The user edits and submits structured information.
- The interface is a settings, profile, account, create, edit, setup, or structured request surface.
- Multiple field Components need consistent grouping and action placement.
- Validation feedback must be summarized or coordinated across fields.
- A read-only inspection state should preserve a form-like data relationship.

Use another API when:

| Need                                         | Use instead                                                        |
| -------------------------------------------- | ------------------------------------------------------------------ |
| Read-only inspection with no edit affordance | Data display patterns                                              |
| Brief blocking edit inside an overlay        | Modal/Overlay pattern plus Forms Pattern inside only when approved |
| Inline table editing                         | Data table or table-editing Pattern when installed                 |
| One-line quick action                        | Button or inline field Component composition                       |
| Filtering a data set                         | Filter/Table toolbar Pattern                                       |
| Choosing between peer views                  | Tabs, not Forms                                                    |
| Linear setup steps                           | Multi-step Pattern with Progress indicator review                  |
| Confirmation-only workflow                   | Modal or Notification/Overlay pattern                              |
| Search and result selection                  | Search/Combobox Pattern when installed                             |

Use modal patterns only when the form is brief, blocking, and context-preserving. Long or multi-section forms should use a page or side panel Pattern instead of a modal.

## 14. Accessibility contract

- Every editable field must have a visible label or an approved accessible-label exception documented by the child Component.
- Associate labels, helper text, warnings, and errors with fields through Component-owned IDs and `aria-describedby`.
- Keep keyboard order aligned with visual order.
- Do not rely on color alone for validation, status, required/optional meaning, saved state, or blocked state.
- Validation summaries must not replace field-level errors.
- Validation summary copy should identify the invalid fields and next step.
- If focus moves to a validation summary after failed submit, the summary must be focusable or announced according to the installed Notification/focus behavior.
- Required/optional labels must be textual, not color-only.
- Read-only groups must preserve semantic relationships between labels and values.
- Disabled fields must not be the only explanation for why the user cannot edit.
- Inline rows must keep the row label/description and control semantically associated where possible.
- Action rows must preserve logical tab order and avoid trapping focus.
- Loading/submitting states must prevent duplicate submission and expose pending status.
- Progressive disclosure must be keyboard accessible and must not hide required fields.
- Motion used for validation, disclosure, or saved/submitting transitions must respect reduced-motion preferences.

## 15. Content contract

- Use concise field labels.
- Use section titles that name the data group: `Profile details`, `Security`, `Billing address`.
- Use section descriptions for purpose or consequence, not policy-heavy instructions.
- Write helper text as guidance, not policy copy.
- Use validation messages that state what to fix and how.
- Use action labels that describe the submitted outcome: `Save changes`, `Create tenant`, `Send invite`.
- Avoid vague submit labels such as `Submit`, `Go`, `Apply`, or `OK` when a specific outcome is known.
- Use `Cancel`, `Back`, or `Discard changes` according to actual behavior.
- Destructive actions must name the destructive result: `Delete workspace`, `Remove user`.
- Saved/status copy should be short: `Changes saved.` or `Saving changes…`.
- Required/optional marking must be consistent across forms of the same type.
- Do not turn helper text into long policy or training content. Use Toggletip, section description, or supporting documentation for longer assistance.

## 16. Prohibited usage

- Do not bypass the installed Pattern API with one-off Blade layout, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not add arbitrary margins to field Components.
- Do not create local `.form-group`, `.settings-form`, `.profile-form`, `.edit-form`, Bootstrap form classes, or feature-specific spacing systems for app-owned form composition.
- Do not hard-code Foundation Element decisions already owned by Color, Spacing, Typography, Themes, Motion, Icons, or 2x Grid.
- Do not hand-build field Components inside forms.
- Do not use placeholder text as the only label.
- Do not hide required fields in collapsed content.
- Do not place destructive and primary submit actions without clear hierarchy.
- Do not nest `<form>` elements.
- Do not use tabs as a required stepper inside a form.
- Do not use Progress indicator for simple grouped settings forms.
- Do not use disabled fields as a permission explanation without supporting text.
- Do not put long, multi-section forms in modals.
- Do not split labels from controls at responsive breakpoints.
- Do not present deferred wizard, sticky-action, or async validation behavior as production-ready without Pattern proof.

## 17. Deferred or gated capabilities

| Capability                           | Status                  | Gate                                                                                                                                                            |
| ------------------------------------ | ----------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Multi-step wizard forms              | Deferred/gated          | Requires feature-backed trigger, Progress indicator ownership review, step validation rules, state persistence, back/continue behavior, and rendered evidence proof. |
| Sticky action bars                   | Gated                   | Requires scroll, overlap, keyboard, mobile, and reduced-motion proof.                                                                                           |
| Route-leave unsaved changes guard    | Deferred                | Requires app-wide dirty-state contract, modal/notification ownership, and tests.                                                                                |
| Async field validation orchestration | Deferred                | Requires field API ownership, debounce rules, pending/error states, and server parity.                                                                          |
| Cross-section save orchestration     | Gated                   | Requires save-status model and conflict/error behavior.                                                                                                         |
| Inline editable table forms          | Pattern-owned elsewhere | Requires Data table editing Pattern.                                                                                                                            |
| Dynamic repeating field arrays       | Deferred                | Requires add/remove semantics, label/indexing rules, keyboard behavior, and validation summary mapping.                                                         |
| Conditional required fields          | Gated                   | Requires disclosure/accessibility proof and validation rules that match visible state.                                                                          |
| Autosave forms                       | Deferred                | Requires saved/dirty/error/pending states and recovery behavior.                                                                                                |
| Local custom form components         | Not allowed             | Update the relevant Component or Pattern API instead.                                                                                                           |

Future extensions require an updated Pattern standard and rendered evidence proof before production use.

## 18. Implementation and Rendered Evidence Checklist
### 18.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                      |
| -------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Pattern API/source         | The standard names the canonical Pattern helper, layout partial, route/view surface, source files, or explicit deferred gate.             |
| Required composition       | Components and Elements the Pattern must coordinate are listed.                                                                           |
| Optional composition       | Optional slots, regions, actions, filters, summaries, overlays, or deferred sub-APIs are listed.                                          |
| State/responsive ownership | Loading, empty, error, blocked, validation, persistence, focus order, responsive, and overflow behavior owned by the Pattern are defined. |
| Accessibility/content      | Page/workflow semantics, heading structure, focus flow, status messaging, action labels, and non-color meaning are defined.               |
| Tests                      | Route/content/API assertions prove the Pattern and coordinated Component usage.                                                           |

### 18.2. rendered evidence proof checklist
| Requirement            | Visual proof expectation                                                                                                           |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| Live compositions      | The page renders production-like composed examples, not isolated primitive samples.                                                |
| Component coordination | Child Components show how they consume the Pattern layout and state ownership.                                                     |
| Element consumption    | Spacing, grid, typography, color, theme, icon, and motion use are shown at the Pattern level.                                      |
| Variants/states        | Required layout variants, responsive states, empty/loading/error/blocked states, or explicit gates are visible.                    |
| Related APIs           | Coordinated Components, consumed Elements, planned sub-APIs, source files, and canonical docs are linked.                          |
| Manual review          | The page provides enough rendered proof for visual review of composition, hierarchy, responsive behavior, and workflow boundaries. |
## 19. Rendered evidence requirements

The rendered evidence page must render rendered examples of approved pattern compositions, not abstract notes only. It must link to this canonical standard and to consumed Element and Component standards. Deferred capabilities must appear as explicit gated disposition rows with trigger conditions, not as fake complete examples. Examples must use app-owned tokens, classes, helpers, and Blade components where available.

The Forms page must render the approved five-card scaffold: Purpose, Use cases, Pattern contract, Live examples, and Related components and patterns.

Required Live examples internal sections:

| Required proof            | Rendered behavior                                                                                                  | Variants/options shown                                                                                             |
| ------------------------- | ------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------ |
| Standard settings form    | A page/settings form renders grouped sections, helper text, field Components, and a clear action row.              | Form section, Text input, Select, Toggle, Button actions, Section description                                      |
| Inline form row           | A compact settings row places label/description and a compact control together while preserving accessible labels. | Inline row, Toggle/checkbox/select control, Row description, Responsive stacking                                   |
| Dense field group         | A productive admin form shows tighter spacing without local margins or field API overrides.                        | Dense section, Field group spacing, Two-column collapse                                                            |
| Read-only detail group    | Structured data renders in form-like label/value grouping without editable controls.                               | Read-only mode, Description list, Permission/no-edit context                                                       |
| Validation summary form   | A form with multiple blocking errors renders a summary plus field-level validation.                                | Validation summary, Field errors, Error notification, Submit blocked                                               |
| Action row hierarchy      | Save/cancel/destructive actions render with clear hierarchy and responsive stacking.                               | Primary submit, Cancel/back, Destructive separation, Button loading                                                |
| Section-level save status | A section shows saved/submitting/blocked status near the relevant section or action row.                           | Saved, Submitting, Blocked, Notification/Inline loading                                                            |
| Responsive composition    | Multi-column and inline rows collapse without changing semantic order.                                             | One-column, Two-column, Inline-to-stacked, Action stacking                                                         |
| Deferred wizard gate      | Multi-step wizard form appears as a gated capability with trigger conditions and approved alternatives.            | Progress indicator review, No fake wizard                                                                          |
| Developer implementation  | Canonical Blade calls and field composition examples render as real code examples.                                 | `x-patterns.form-section`, `x-patterns.inline-form-row`, `x-patterns.form-actions`, validation summary composition |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show installed Pattern APIs, rendered variants/options, state ownership, prohibited usage, deferred gates, consumed Element APIs, consumed Component APIs, and source ownership expectations.

## 20. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed Pattern API, state ownership, variants/options, prohibited usage, deferred gates, consumed Foundation Elements, and consumed Components.
- Implemented Pattern APIs render production examples.
- Deferred capabilities render trigger conditions instead of fake controls.
- The Purpose, Use cases, Pattern contract, Live examples, and Related components and patterns cards render in that top-level order.
- Rendered examples include required composition markers and consumed Component links.
- No Pattern example hard-codes Foundation Element decisions that already have approved APIs.
- Deferred capabilities are represented with trigger conditions and prohibited local workarounds.
- Standard settings form examples render form sections, field Components, helper text, and action rows.
- Inline form row examples preserve label/control relationship and responsive stacking.
- Dense field examples use Pattern-owned density rules, not local margins.
- Read-only group examples render label/value semantics without editable controls.
- Validation summary examples include both summary feedback and field-level errors.
- Action row examples show primary, cancel/back, loading/submitting, and destructive hierarchy rules.
- Responsive examples prove two-column and inline layouts collapse without reordering content.
- Developer examples use `x-patterns.form-section`, `x-patterns.inline-form-row`, `x-patterns.form-actions`, and approved Component APIs.
- Tests assert stale labels and legacy scaffolding remain absent when they are not part of approved UI copy.
- Tests assert no raw Bootstrap form groups, hard-coded colors, arbitrary local spacing, feature-local form layout classes, or direct Carbon production classes are presented as approved.

Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Forms');
$response->assertSee('x-patterns.form-section');
$response->assertSee('x-patterns.inline-form-row');
$response->assertSee('x-patterns.form-actions');
$response->assertSee('validation summary');
$response->assertSee('Standard settings form');
$response->assertSee('Inline form row');
$response->assertSee('Dense field group');
$response->assertSee('Read-only detail group');
$response->assertSee('Validation summary form');
$response->assertSee('Action row hierarchy');
$response->assertSee('Section-level save status');
$response->assertSee('Responsive composition');
$response->assertSee('Deferred wizard gate');
$response->assertSee('Text input');
$response->assertSee('Select');
$response->assertSee('Button');
$response->assertSee('Notification');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('form-group');
$response->assertDontSee('btn btn-primary');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 21. Related APIs

| API                       | Route                                                         |
| ------------------------- | ------------------------------------------------------------- |
| Text input                | `not installed`                |
| Textarea                  | `not installed`                  |
| Select                    | `not installed`                    |
| Checkbox                  | `not installed`                  |
| Radio button              | `not installed`              |
| Toggle                    | `not installed`                    |
| File uploader             | `not installed`             |
| Button                    | `not installed`                    |
| Notification              | `not installed`              |
| Inline loading            | `not installed`            |
| Toggletip                 | `not installed`                 |
| Progress indicator        | `not installed`        |
| Color element             | `not installed`                       |
| Spacing element           | `not installed`                     |
| Typography element        | `not installed`                  |
| Themes element            | `not installed`                      |
| Motion element            | `not installed`                      |
| Icons element             | `not installed`                       |
| 2x Grid element           | `not installed`                     |
| Overlay/feedback patterns | `not installed`           |
| Common Actions patterns   | `docs/02-standards/ui/patterns/common-actions/index.md`       |
| Page header planned gap   | `not installed`                      |
| Patterns overview         | `not installed`                             |
| Canonical forms doc       | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Fforms.md` |
| Carbon forms pattern      | `https://carbondesignsystem.com/patterns/forms-pattern/`      |

## 22. References

- [Pattern Library Checklist](checklist.md)
- [Component Standards](../components/index.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](index.md)
- Carbon Forms pattern and Form component guidance inform form consistency, required/optional treatment, one-column/two-column structure, mobile collapse behavior, spacing, validation, inline warnings/errors, and keyboard-accessible help. Login App keeps its own Pattern APIs, Blade components, Component standards, Element token model, app-owned `ui-*` classes, and rendered evidence proof.

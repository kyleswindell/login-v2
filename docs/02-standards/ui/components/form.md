---
title: Form
slug: form
api_layer: Component API
status: app-specific-exception
system_maturity: catalog-only-pattern-owned
category: form-structure
priority: tier-a-baseline-app-development
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/form.md
source_owner: not installed
blade_api: []
javascript_api: []
data_attributes: []
source_files: []
foundation_elements:
  - color
  - spacing
  - typography
  - themes
related_components:
  - button
  - text-input
  - select
  - checkbox
  - radio-button
  - toggle
  - notification
  - inline-loading
related_patterns:
  - forms
carbon_reference:
  - https://carbondesignsystem.com/components/form/usage/
  - https://carbondesignsystem.com/components/form/style/
  - https://carbondesignsystem.com/components/form/accessibility/
  - https://carbondesignsystem.com/patterns/forms-pattern/
---

# Form Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Production API status](#41-production-api-status)
  - [4.2. Approved production composition today](#42-approved-production-composition-today)
  - [4.3. Reserved future contract](#43-reserved-future-contract)
  - [4.4. Native form attributes](#44-native-form-attributes)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper usage](#74-helper-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and Rendered Evidence Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. rendered evidence proof checklist](#142-ui-reference-proof-checklist)
- [15. Rendered evidence requirements](#15-ui-reference-requirements)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Form sections, inline field rows, validation summaries, and action bars provide structure around input components inside a form workflow.

Canonical API owner: `not installed`. Use this Component API entry as the disposition and discoverability standard for the form structure role. Do not create local markup, styling, or behavior that attempts to install a standalone Form Component API.

Form is an app-specific exception. The component catalog entry exists because form structure is a baseline UI role, but production composition ownership belongs to the Forms Pattern at `not installed`. Individual input primitives are owned by their field Component APIs. Submit, cancel, loading, and destructive actions are owned by Button and the parent Pattern.

### 1.1. Canonical API responsibilities:

- Preserve the `not installed` catalog route.
- Document that no standalone production Form Blade API is approved.
- Route production form composition to the Forms Pattern.
- Reserve `section`, `inline row`, `summary`, and `actions` as future gated composition roles.
- Prevent speculative local `form-*`, Bootstrap, raw utility, or custom JavaScript implementations.
- Define the accessibility, content, token, testing, and Rendered evidence requirements that must be satisfied before a future Form Component API can be installed.
- Prove the current exception state, approved alternatives, deferred gates, prohibited usage, and related APIs on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Field primitives such as text input, text area, select, checkbox, radio button, toggle, date picker, file upload, or custom field validation UI.
- Form layout, section sequencing, responsive columns, field grouping, multi-step flows, and workflow orchestration.
- Submit/cancel/destructive button hierarchy and loading behavior.
- Modal, side-panel, page, card, or table-toolbar placement.
- Client-side validation, autosave, AJAX submit, dirty-state warnings, and focus orchestration.
- External spacing around a form, section, or action group.

Carbon alignment note: Carbon treats Form as a configurable composition with optional header, body, and footer areas, distinguishes default and fluid styling, defines alignment and spacing expectations, and routes deeper workflow guidance to the Forms Pattern. Login App maps that guidance to a pattern-owned exception instead of installing Carbon classes or a standalone Form Blade API.

## 2. Status and ownership

| Field                        | Value                                                                |
| ---------------------------- | -------------------------------------------------------------------- |
| Status                       | App-specific exception                                               |
| System maturity              | Catalog-only, pattern-owned                                          |
| API layer                    | Component API                                                        |
| Component slug               | form                                                                 |
| Category                     | Form structure                                                       |
| Priority                     | Tier A - Baseline app development                                    |
| Rendered evidence route           | `not installed`                             |
| Canonical doc                | `docs/02-standards/ui/components/form.md`                            |
| Source owner                 | `not installed`                              |
| Blade API                    | No standalone production Form Blade API approved                     |
| JavaScript API               | None approved                                                        |
| Data attributes              | None approved                                                        |
| Props/options                | None approved for a standalone Form Component                        |
| Source files                 | No standalone production source files approved for Form Component    |
| CSS namespace                | App-owned `ui-*` namespace reserved for approved implementation only |
| Foundation Elements consumed | Color, Spacing, Typography, Themes                                   |
| Carbon benchmark             | Carbon Form usage, style, accessibility, and Forms Pattern guidance  |

`App-specific exception` means the component route is intentionally retained for discovery, governance, and future implementation gates, but feature work must not treat Form as an installed standalone Component API.

`Pattern-owned` means the Forms Pattern owns production composition behavior today. This Component API entry owns the catalog disposition and future-gate contract only.

## 3. Installed standard

The installed standard is a catalog and ownership standard, not a standalone production component.

Production form work must follow this rule:

- Use native `<form>` semantics for HTTP submission and browser form behavior.
- Use the Forms Pattern for layout, grouping, spacing, responsive behavior, validation-summary placement, and action-bar composition.
- Use installed field Component APIs for fields and field-level validation where those APIs exist.
- Use Button for submit, cancel, loading, disabled, and destructive actions.
- Use Notification or the approved Forms Pattern summary area for form-level status messaging when the pattern has installed that behavior.
- Use server-side validation as the source of truth unless a documented feature owner adds an approved client-side validation contract.
- Do not use a standalone `x-ui.form` API in production until it is explicitly implemented, documented, rendered in rendered evidence, and tested.
- Do not create feature-local form structure classes or JavaScript to fill the gap.

Current installed disposition:

| Role                  | Installed disposition                                   | Production rule                                                                                                          |
| --------------------- | ------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| Semantic form wrapper | Native HTML, feature-owned action/method                | Use `<form>` only for submission semantics, CSRF, method spoofing, and native behavior. Do not use it as a styling hook. |
| Form layout           | Pattern-owned                                           | Use `not installed` guidance and approved field components.                                      |
| Form section          | Deferred Component role; Pattern-owned today            | Do not create local section wrappers that pretend to be a Component API.                                                 |
| Inline row            | Deferred Component role; Pattern-owned today            | Use only Pattern-approved composition for horizontally related fields.                                                   |
| Validation summary    | Deferred Component role; Pattern-owned today            | Use approved pattern/status messaging; do not build custom local summaries.                                              |
| Actions               | Deferred Component role; Button and Pattern-owned today | Use Button API and Forms Pattern placement/order.                                                                        |

This entry prevents placeholder implementation text. It must not contain or render `Component-specific API pending correction` as production guidance.

## 4. Public API

### 4.1. Production API status

No standalone public Form Component API is installed.

| API surface     | Installed value | Rule                                                                                                                            |
| --------------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| Blade           | None approved   | Do not use `x-ui.form`, `x-ui.form.section`, `x-ui.form.inline-row`, `x-ui.form.summary`, or `x-ui.form.actions` in production. |
| JavaScript      | None approved   | Do not attach local form controllers, validation initializers, submit interceptors, or data attributes as a Form Component API. |
| Data attributes | None approved   | Do not invent `data-ui-form-*` behavior attributes.                                                                             |
| Props/options   | None approved   | A standalone component has no public props until implementation is approved.                                                    |
| Slots           | None approved   | No standalone Form slots are public.                                                                                            |
| CSS namespace   | Reserved only   | `ui-form*` classes must not be used in production unless implemented by the source owner and documented here.                   |
| Source owner    | Forms Pattern   | `not installed` owns production composition.                                                            |

### 4.2. Approved production composition today

Use native form semantics with Pattern-owned layout and installed Component APIs. The example below demonstrates the approved ownership boundary; it is not a standalone Form Component API.

```blade
<form method="POST" action="{{ route('settings.profile.update') }}">
    @csrf
    @method('PATCH')

    {{-- Compose fields through installed field Component APIs and Forms Pattern-owned layout. --}}

    <x-ui.button semantic="primary" type="submit">
        Save changes
    </x-ui.button>
</form>
```

Production views may use Laravel form mechanics such as `@csrf`, `@method`, old input values, validation error bags, and server-side validation messages. Styling and composition must still come from installed field components and Patterns, not local form wrappers.

### 4.3. Reserved future contract

The names below are reserved for a possible future implementation. They are not production APIs.

| Reserved role | Possible future public surface                     | Current status | Gate                                                                                                         |
| ------------- | -------------------------------------------------- | -------------- | ------------------------------------------------------------------------------------------------------------ |
| Form root     | `x-ui.form` or Pattern-owned equivalent            | Deferred       | Requires approved source file, props, slots, semantic contract, tests, and rendered evidence production examples. |
| Section       | `x-ui.form.section` or Pattern-owned equivalent    | Deferred       | Requires heading/description/fieldset rules, spacing tokens, validation behavior, and responsive proof.      |
| Inline row    | `x-ui.form.inline-row` or Pattern-owned equivalent | Deferred       | Requires field-width rules, stacking behavior, error-height behavior, and mobile proof.                      |
| Summary       | `x-ui.form.summary` or Pattern-owned equivalent    | Deferred       | Requires error/warning/success/info semantics, links, focus rules, and assistive technology proof.           |
| Actions       | `x-ui.form.actions` or Pattern-owned equivalent    | Deferred       | Requires Button API integration, order rules, loading/disabled behavior, and responsive proof.               |

Do not use reserved names as local Blade components. If a feature needs one of these roles, implement it through the Forms Pattern or open a scoped Form Component correction pass.

### 4.4. Native form attributes

Native attributes are allowed because they belong to HTML form semantics, not to a Login App Form Component API.

| Attribute/mechanism | Status                        | Rule                                                                                                                           |
| ------------------- | ----------------------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| `method`            | Native HTML                   | Use `POST` for state-changing Laravel forms and method spoofing for `PUT`, `PATCH`, or `DELETE`.                               |
| `action`            | Native HTML                   | Route to the server endpoint that owns validation and persistence.                                                             |
| `enctype`           | Native HTML                   | Use only when upload fields require it.                                                                                        |
| `autocomplete`      | Native HTML                   | Use intentionally; do not disable globally without a security or privacy requirement.                                          |
| `novalidate`        | Native HTML, feature decision | Use only when server-rendered validation owns the experience and browser validation would conflict with the installed pattern. |
| `@csrf`             | Laravel                       | Required for state-changing forms.                                                                                             |
| `@method`           | Laravel                       | Use only when the route requires method spoofing.                                                                              |

## 5. Allowed variants, options, and modifiers

The following entries are cataloged so developers can distinguish approved production ownership from deferred Component API work.

| Name                        | Type                           | Status                                                   | API                   | Notes                                                                                            |
| --------------------------- | ------------------------------ | -------------------------------------------------------- | --------------------- | ------------------------------------------------------------------------------------------------ |
| Native form wrapper         | Semantic wrapper               | Approved native HTML                                     | `<form>`              | Allowed for submission semantics only; not a styling API.                                        |
| Default form composition    | Pattern composition            | Pattern-owned                                            | Forms Pattern         | Use for standard single-column or pattern-approved form layouts.                                 |
| Section                     | Composition role               | Deferred Component role / Pattern-owned today            | None as Component API | Groups related fields under a heading or legend.                                                 |
| Inline row                  | Composition role               | Deferred Component role / Pattern-owned today            | None as Component API | Places tightly related fields in one row when responsive behavior is defined.                    |
| Summary                     | Composition role               | Deferred Component role / Pattern-owned today            | None as Component API | Form-level validation or status summary.                                                         |
| Actions                     | Composition role               | Deferred Component role / Button and Pattern-owned today | None as Component API | Submit, cancel, destructive, and loading actions.                                                |
| Required/optional indicator | Content/accessibility modifier | Pattern-owned                                            | None as Component API | Must be consistent within a product area and programmatically expressed at field level.          |
| Two-column layout           | Layout mode                    | Pattern-owned                                            | Forms Pattern         | Must collapse to one column on mobile and align to the grid.                                     |
| Fluid form style            | Mode                           | Gated / not implemented at Component layer               | None                  | Requires source implementation, spacing rules, field support, and rendered evidence proof before use. |
| AI presence                 | Modifier                       | Gated / not implemented                                  | None                  | Requires explicit AI component contract and explainability behavior before use.                  |
| Client-side validation      | Behavior                       | Deferred                                                 | None                  | Requires JS controller, data attributes, accessibility review, and server-validation fallback.   |
| Multi-step form             | Pattern                        | Pattern-owned / gated                                    | Forms Pattern         | Do not add to Form Component without Pattern approval.                                           |
| Sticky actions              | Pattern modifier               | Gated                                                    | None                  | Requires scroll, focus, keyboard, and responsive behavior proof.                                 |

Do not represent deferred roles as production controls. The rendered evidence page must show trigger conditions and approved alternatives instead of fake form components.

## 6. States

Form state is currently owned by field components, Button, Notification, and Forms Pattern composition. The Form Component catalog entry documents how those states must be classified until a standalone implementation exists.

| State              | Status                                            | Implementation requirement                                                                                                            |
| ------------------ | ------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------- |
| Default            | Pattern-owned                                     | Render fields and actions through installed APIs and Forms Pattern composition.                                                       |
| Focus-visible      | Field/Button-owned                                | Focus rings belong to interactive child components, not the form wrapper.                                                             |
| Hover              | Not applicable to form root                       | Hover may apply to child controls only.                                                                                               |
| Active/pressed     | Not applicable to form root                       | Active/pressed belongs to buttons, toggles, checkboxes, radios, and other controls.                                                   |
| Disabled           | Field/Button-owned                                | Disable individual controls or actions through their Component APIs; do not disable an entire form through local styling.             |
| Read-only          | Field-owned                                       | Use field-level read-only semantics where supported. A form root is not read-only.                                                    |
| Loading/submitting | Button and Pattern-owned                          | Use Button loading state and Pattern-owned pending messaging. No Form JS state is approved.                                           |
| Error              | Field and Pattern-owned                           | Field errors must be programmatically associated with inputs. Form-level summary is deferred at Component layer unless Pattern-owned. |
| Warning            | Field, Notification, or Pattern-owned             | Use installed status APIs. Do not create local warning banners inside the form.                                                       |
| Success            | Notification or Pattern-owned                     | Use installed feedback APIs after submit or save. Do not use local green form summaries.                                              |
| Informational      | Notification, Tooltip/Toggletip, or Pattern-owned | Use installed support components for additional guidance.                                                                             |
| Empty              | Not applicable                                    | Do not render an empty form shell. Use an empty-state Pattern when there are no configurable fields.                                  |
| Expanded/collapsed | Pattern-owned / gated                             | Disclosure, accordion, or multi-step behavior is not owned by Form Component.                                                         |
| Current step       | Pattern-owned / gated                             | Multi-step current state belongs to a stepper/progress Pattern when approved.                                                         |
| Overflow/truncated | Content-owned                                     | Labels, helper text, and errors must remain readable; do not truncate required form instructions.                                     |

States must be represented through installed Component APIs and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Form consumes Foundation Color, Spacing, Typography, and Themes through the Forms Pattern and child components.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                                 |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Validation summary emphasis, required/optional indicators, helper text, error text, borders, and disabled/read-only child states through approved components. |
| Spacing     | Section gaps, field stack gaps, inline row gaps, summary spacing, and action-bar separation through Pattern-owned composition.                                |
| Typography  | Section headings, descriptions, labels, helper text, error text, and action text through component and Pattern tokens.                                        |
| Themes      | Light/dark/inverse token resolution for fields, summaries, sections, and action areas through installed APIs.                                                 |

### 7.3. CSS namespace

The app-owned `ui-*` namespace is reserved for an approved implementation. These names are allowed only after source implementation and rendered evidence proof exist:

```css
.ui-form
.ui-form-section
.ui-form-section-header
.ui-form-section-title
.ui-form-section-description
.ui-form-row
.ui-form-summary
.ui-form-summary-error
.ui-form-summary-warning
.ui-form-summary-success
.ui-form-summary-info
.ui-form-actions
```

Until that gate is approved, feature views must not use these as production styling hooks.

Feature views must not create Bootstrap `.form-group`, `.form-control`, local `.form-*`, local `.field-*`, raw utility clusters, hard-coded colors, arbitrary spacing, custom focus rings, local icons, or Carbon production classes for the same UI role.

### 7.4. Helper usage

| Helper/mechanism                  | Status                  | Rule                                                                                             |
| --------------------------------- | ----------------------- | ------------------------------------------------------------------------------------------------ |
| Laravel validation error bags     | Approved                | Use as data source for field errors and Pattern-owned summaries.                                 |
| `@csrf`                           | Approved                | Required for state-changing forms.                                                               |
| `@method`                         | Approved                | Use for route method spoofing only.                                                              |
| `old()` values                    | Approved                | Use to repopulate user input after validation failure where safe.                                |
| Feature-local form helper classes | Not allowed             | Move repeated structure into the Forms Pattern or approved field components.                     |
| Feature-local JavaScript helpers  | Not allowed as Form API | Must be documented as feature behavior or installed through a scoped component/pattern standard. |

## 8. Composition rules

- Use a native `<form>` element when the user submits data to the server.
- Keep the form’s `action`, `method`, CSRF token, and method spoofing clear in the feature view or Pattern owner.
- Use field components for all supported field primitives.
- Use `fieldset` and `legend` semantics for grouped checkboxes, radios, or related controls when the field Component API does not already own the grouping.
- Keep labels visible and programmatically associated with their controls.
- Use helper text for persistent instructions and associate it with the field.
- Use a Pattern-owned validation summary when multiple field errors need a top-level recovery path.
- Place submit/cancel/destructive actions through the Button API and Forms Pattern action rules.
- Keep destructive actions visually and textually explicit.
- Preserve entered values after validation failure unless security or privacy requirements prevent it.
- Align form fields and labels through Pattern-owned spacing and grid rules.
- Collapse multi-column form layouts to one column on small screens.
- Do not require users to switch between keyboard and pointer to complete a normal form.
- Parent Patterns own grouping, external spacing, workflow orchestration, responsive layout, and page-level placement.
- Components own internal semantics, styling, labels, descriptions, validation state, disabled/read-only behavior, and focus treatment.

## 9. Selection guidance

Use this Component API standard when:

- A developer needs to know whether a standalone Form Component API exists.
- A feature is considering local form sections, inline rows, summaries, or action bars.
- A rendered evidence page needs to document the Form component disposition.
- A future correction pass needs the gates for installing Form as a real Component API.

Use the Forms Pattern when:

- A production page needs form layout, grouping, spacing, responsive behavior, validation-summary placement, or action placement.
- A form appears in a page, modal, side panel, card, settings view, or onboarding flow.
- A workflow needs multi-step, longer-form, or sectioned behavior.

Use field Component APIs when:

- The task is to render an input, select, checkbox, radio group, toggle, text area, date picker, file uploader, or field-level error.

Use Button when:

- The task is to render submit, cancel, reset, destructive, loading, or disabled actions.

Do not use this Component API as a production primitive when:

- You need a ready-made form wrapper component.
- You need client-side validation or autosave behavior.
- You need a filter toolbar, search form, or table query bar; use the appropriate Pattern.
- You need an empty state, notification, modal, or overlay behavior.
- You need custom layout spacing or utility clusters.

Role selection:

| Need                                                   | Current owner                | Future Form role            |
| ------------------------------------------------------ | ---------------------------- | --------------------------- |
| Group related fields under one heading                 | Forms Pattern                | Section                     |
| Place two or more related fields on one responsive row | Forms Pattern                | Inline row                  |
| Summarize validation or status above fields            | Forms Pattern / Notification | Summary                     |
| Place submit/cancel/destructive commands               | Forms Pattern + Button       | Actions                     |
| Render individual input and validation state           | Field Component API          | Not owned by Form           |
| Submit data to the server                              | Native `<form>` + Laravel    | Not a styled Component role |

## 10. Accessibility contract

- Data-submission workflows must use a native `<form>` element unless the workflow is explicitly not a form submission.
- Every form must have an accessible purpose through a page heading, section heading, `aria-labelledby`, or equivalent context.
- Every field must have a visible label unless an approved accessibility exception supplies an equivalent accessible name.
- Required or optional status must be communicated consistently and programmatically at the field level.
- A form-level instruction must explain required/optional conventions when the convention is not obvious.
- Helper text, error text, warning text, and summary text must be associated with the relevant field or region through installed accessible techniques.
- Validation errors must not rely on color alone.
- Error copy must identify the problem and provide a recovery path.
- When a Pattern-owned validation summary is present, it must be reachable by keyboard and must link or move focus to the affected fields where applicable.
- On validation failure, focus management must be predictable and must not trap the user.
- Keyboard order must follow the visual and logical reading order.
- Buttons inside forms must set the correct type. Submit buttons use `type="submit"`; non-submit controls use `type="button"`.
- Disabled and read-only behavior must use the child component’s semantic attributes, not visual-only styling.
- Help icons or toggletips inside forms must be keyboard accessible and dismissible.
- Mobile and narrow layouts must preserve labels, helper text, validation text, and action access without horizontal scrolling.

## 11. Content contract

- Use sentence case for form headings, labels, helper text, validation text, and action labels.
- Keep labels short and specific.
- Do not add colons after field labels.
- Use helper text for persistent format requirements, constraints, or examples.
- Do not use placeholder text as the only label or only instruction.
- Use one required/optional convention consistently within the product area.
- Prefer prefilled values when the system can safely determine the value.
- Keep section headings scannable and tied to the user’s task.
- Use validation messages that explain how to fix the field, not just what failed.
- Use form-level summaries to reduce recovery effort when multiple fields fail.
- Use Button content rules for submit, cancel, and destructive action labels.
- Avoid vague action labels such as `Submit` when a specific outcome such as `Save changes`, `Create user`, or `Send invitation` is available.
- Do not repeat optional markers on every field when a grouped optional section is clearer and Pattern-approved.

## 12. Prohibited usage

- Do not install or use a standalone Form Blade API without updating this standard, source files, rendered evidence proof, and tests.
- Do not create feature-local `x-form`, `x-ui.form`, `x-ui.form-section`, or equivalent wrappers.
- Do not create local form section, inline row, summary, or action-bar components for one feature.
- Do not use raw utility clusters to define form spacing, validation colors, grid columns, or focus states.
- Do not use raw colors, hard-coded spacing, local icons, custom focus rings, or custom JavaScript for form structure.
- Do not use Bootstrap `.form-group`, `.form-control`, `.row`, `.col-*`, or `.btn` classes as Login App form APIs.
- Do not use direct Carbon production classes in Login App markup.
- Do not render unsupported deferred roles as production UI in the rendered evidence page.
- Do not display fake inputs, fake validation controls, or placeholder developer comments as installed examples.
- Do not bypass field Component APIs for controls that already have an installed component.
- Do not place destructive form actions without visible destructive copy and an escape path.
- Do not hide labels, helper text, or validation recovery behind pointer-only interactions.
- Do not create broad library-wide corrections from this Form Component entry.

## 13. Deferred or gated capabilities

| Capability                          | Status                | Gate                                                                                                                         |
| ----------------------------------- | --------------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| Standalone Form Blade API           | Deferred              | Requires approved source file, root semantic contract, props, slots, tests, and rendered evidence production examples.            |
| Form section API                    | Deferred              | Requires heading/description rules, fieldset/legend guidance, spacing tokens, responsive behavior, and validation proof.     |
| Inline row API                      | Deferred              | Requires grid/width rules, mobile stacking, error-height behavior, label alignment, and RTL proof.                           |
| Validation summary API              | Deferred              | Requires error/warning/success/info variants, ARIA contract, summary-to-field navigation, focus behavior, and tests.         |
| Actions API                         | Deferred              | Requires Button integration, action order rules, loading/disabled behavior, destructive action rules, and responsive proof.  |
| Client-side validation controller   | Deferred              | Requires server fallback, data attribute API, validation timing rules, screen-reader behavior, and no custom per-feature JS. |
| Autosave or dirty-state behavior    | Gated                 | Requires explicit workflow Pattern, state persistence rules, unsaved-change warning contract, and tests.                     |
| Fluid form style                    | Gated                 | Requires field component support, spacing/alignment contract, responsive proof, and rendered evidence examples.                   |
| AI presence in forms                | Gated                 | Requires AI label/explainability contract, source owner approval, and accessibility review.                                  |
| Multi-step or accordion forms       | Pattern-owned / gated | Requires Forms Pattern approval and step/disclosure accessibility proof.                                                     |
| Sticky action bar                   | Pattern-owned / gated | Requires scroll behavior, focus order, keyboard access, mobile proof, and Button integration.                                |
| Form builder/schema-generated forms | Not implemented       | Requires separate architecture decision, validation model, security review, and rendered evidence proof.                          |

Future extensions require a scoped component correction pass. Do not implement them opportunistically inside feature work.

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

The Form page is an exception/disposition page. The Live examples card must show deferral proof, ownership boundaries, approved alternatives, and gate conditions. It must not render fake Form Component controls as if they are installed.

### Required Live examples internal sections:

| Required proof                  | Rendered behavior                                                                                                           | Variants/options shown                                                                                  |
| ------------------------------- | --------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------- |
| Exception status proof          | Page states that Form is an app-specific exception and pattern-owned.                                                       | App-specific exception, Pattern-owned, Catalog-only                                                     |
| Approved production alternative | Shows native form semantics composed with installed field/Button APIs and Pattern-owned layout guidance.                    | Native `<form>`, Laravel CSRF/method, Button submit                                                     |
| Deferred role matrix            | Shows each reserved Form role as deferred or Pattern-owned today.                                                           | Section, Inline row, Summary, Actions                                                                   |
| Ownership map                   | Shows which API owns fields, actions, layout, feedback, and submission semantics.                                           | Field components, Button, Notification, Forms Pattern, native HTML                                      |
| State classification table      | Shows which states are Pattern-owned, child-owned, deferred, or not applicable.                                             | Default, Focus-visible, Disabled, Read-only, Loading/submitting, Error, Warning, Success, Informational |
| Accessibility contract proof    | Shows label, required/optional, helper/error association, summary navigation, keyboard order, and button type requirements. | Labels, `aria-describedby`, required state, validation summary, keyboard/focus, submit button           |
| Content behavior proof          | Shows sentence case, no label colons, helper text guidance, validation copy, and action labels.                             | Labels, helper text, errors, required/optional instructions, submit/cancel labels                       |
| Prohibited usage proof          | Shows local wrappers, raw utility clusters, Bootstrap classes, direct Carbon classes, and custom JS as prohibited.          | Local form wrappers, raw utilities, Bootstrap, Carbon production classes, local JS                      |
| Deferred gate proof             | Shows trigger conditions required before each deferred capability can be implemented.                                       | Standalone Form API, section, inline row, summary, actions, fluid, client validation                    |
| Foundation Elements proof       | Shows consumed Foundation Elements and token responsibilities.                                                              | Color, Spacing, Typography, Themes                                                                      |
| Developer implementation proof  | Shows current approved composition and explicitly states no standalone Form Blade API is approved.                          | Native form semantics, Pattern owner, no public props, no JS/data attributes                            |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual exception status, approved alternatives, deferred gates, prohibited usage, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API disposition, states, variants/options, prohibited usage, deferred gates, and consumed Foundation Elements.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- Implemented/native semantics render as approved alternatives; deferred APIs render trigger conditions instead of fake controls.
- No generic placeholder content appears.
- The page states that no standalone Form Blade API is approved.
- The page identifies `not installed` as the production composition owner.
- The page shows `section`, `inline row`, `summary`, and `actions` as deferred or Pattern-owned roles, not installed Form Component variants.
- The page documents that JavaScript API, data attributes, props/options, and slots are not approved for a standalone Form Component.
- The page shows native form semantics, Laravel CSRF/method usage, installed field components, and Button actions as the approved production path.
- The page shows accessibility requirements for labels, required/optional status, helper/error association, keyboard order, validation recovery, and correct button types.
- The page shows content requirements for sentence case, concise labels, no colons after labels, helper text, validation copy, and action labels.
- Tests assert stale labels such as `Component-specific API pending correction`, `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` remain absent.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production class names, Bootstrap form examples, hard-coded colors, arbitrary local spacing, or feature-local form classes are presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Form');
$response->assertSee('App-specific exception');
$response->assertSee('Pattern-owned');
$response->assertSee('No standalone public Form Component API is installed');
$response->assertSee('not installed');
$response->assertSee('section');
$response->assertSee('inline row');
$response->assertSee('summary');
$response->assertSee('actions');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Deferred');
$response->assertSee('Native form semantics');
$response->assertSee('Laravel validation');
$response->assertSee('Button');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('btn btn-primary');
$response->assertDontSee('form-control');
```

## 17. Related APIs

| API                 | Route                                                          |
| ------------------- | -------------------------------------------------------------- |
| Components overview | `not installed`                            |
| Forms pattern       | `not installed`                        |
| Button              | `not installed`                     |
| Text input          | `not installed`                 |
| Select              | `not installed`                     |
| Checkbox            | `not installed`                   |
| Radio button        | `not installed`               |
| Toggle              | `not installed`                     |
| Notification        | `not installed`               |
| Inline loading      | `not installed`             |
| Modal               | `not installed`                      |
| Color element       | `not installed`                        |
| Spacing element     | `not installed`                      |
| Typography element  | `not installed`                   |
| Themes element      | `not installed`                       |
| Canonical form doc  | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fform.md` |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Form usage, style, accessibility, and Forms Pattern guidance inform the header/body/footer model, default/fluid distinction, alignment, label/helper/error behavior, and accessibility checkpoints. Login App keeps Form as a pattern-owned app-specific exception until a scoped implementation gate installs a real Component API.
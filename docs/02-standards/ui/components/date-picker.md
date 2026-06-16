---
title: Date picker
slug: date-picker
status: implemented-pending-review
api_layer: Component API
category: Inputs
priority: Tier C - Contextual or deferred
ui_reference_route: /platform/ui-reference/components/date-picker
canonical_doc: docs/02-standards/ui/components/date-picker.md
source_owner: /platform/ui-reference/components/date-picker
foundation_elements:
  - color
  - spacing
  - typography
  - themes
related_components:
  - text-input
  - select
  - number-input
related_patterns:
  - forms
  - tables
---

# Date picker Component API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Props/options](#41-propsoptions)
  - [4.2. Value contract](#42-value-contract)
  - [4.3. Data attributes](#43-data-attributes)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Date picker supports date, date-time, range calendar, and time picker entry.

Canonical API owner: `/platform/ui-reference/components/date-picker`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

This standard follows Carbon's date picker coverage for simple date input, date-time entry, range calendar selection, and time picker anatomy. Login App owns the field shell, validation treatment, range calendar proof, hover range preview, and time picker composition. Unavailable-date rules, relative date shortcuts, date masking/parsing, AI presence, and complex scheduling behavior remain gated until their owning standards install those capabilities.

## 2. Status and ownership

| Field              | Value                                            |
| ------------------ | ------------------------------------------------ |
| Status             | Approved API                                     |
| API layer          | Component API                                    |
| Component slug     | date-picker                                      |
| Category           | Inputs                                           |
| Priority           | Tier C - Contextual or deferred                  |
| UI Reference route | `/platform/ui-reference/components/date-picker`  |
| Canonical doc      | `docs/02-standards/ui/components/date-picker.md` |
| Source owner       | `/platform/ui-reference/components/date-picker`  |

## 3. Installed standard

Date picker has component-specific UI Reference examples that consume approved Foundation Elements.

The installed Login App standard is:

- Use native `input[type="date"]` for simple single-date entry.
- Use native `input[type="datetime-local"]` for simple date-time entry when the workflow does not require a separate time-zone selector.
- Use the installed date range picker proof when users need to choose start and end dates from a calendar and inspect a range preview.
- Use time picker composition for scheduling moments that need a time field, AM/PM select, and timezone select.
- Support small, medium, large, and fluid field presentations through the installed field API.
- Use labels, helper text, validation copy, disabled/read-only treatment, and token-backed field states consistently with the Form Pattern.
- Use a read-only value summary plus hidden submitted value when the field is fixed but still belongs to form submission.
- Use server-side validation as the source of truth for required, minimum, maximum, and business-rule validation.
- Treat browser-rendered native date picker popups as native browser behavior, not as app-owned visual surfaces.
- Defer unavailable-date rules, date masking/parsing, relative date shortcuts, AI presence, and complex scheduling behavior until a dedicated API and accessibility contract are approved.

This component owns the field-level date/date-time input API, range calendar interaction proof, and time picker composition. Parent Patterns own form layout, filtering behavior, submission, persistence, and server validation orchestration.

## 4. Public API

| API surface     | Installed value                                                                                                                                                                                               |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade           | `x-ui.date-picker`                                                                                                                                                                                            |
| JavaScript      | `initDateRangePickers` for range calendar selection and hover range preview. Native date/date-time fields do not require scripting.                                                                            |
| Data attributes | `data-ui-component="date-picker"`, `data-ui-date-picker`, `data-ui-date-picker-type`, `data-ui-date-picker-size`, `data-ui-date-picker-style`, `data-ui-date-picker-input`, `data-ui-date-picker-readonly`, `data-ui-component="date-range-picker"`, `data-ui-date-range-picker`, `data-ui-date-range-input`, `data-ui-date-range-calendar`, `data-ui-date-range-day`, `data-ui-component="time-picker"`, `data-ui-time-picker`. |
| Props/options   | `name`, `id`, `label`, `value`, `defaultValue`, `type`, `min`, `minDate`, `max`, `maxDate`, `step`, `required`, `disabled`, `readonly`, `readOnly`, `helper`, `helperText`, `error`, `invalid`, `invalidText`, `warning`, `warn`, `warnText`, `autocomplete`, `placeholder`, `dateFormat`, `size`, `style`, `skeleton`, `attributes`. |
| CSS namespace   | Use the app-owned `ui-*` namespace documented by the component implementation. Recommended namespaces are `ui-date-picker`, `ui-date-picker-control`, `ui-input-date`, `ui-date-picker-status-icon`, `ui-date-picker-readonly-value`, and shared `ui-field*` helpers. |
| Source files    | `resources/views/components/ui/date-picker.blade.php`; `resources/css/app.css`                                                                                                                                |

Example call:

```blade
<x-ui.date-picker
    name="start_date"
    label="Start date"
    helper="Use the first date this setting should apply."
    min="2026-01-01"
/>
```

Date-time example:

```blade
<x-ui.date-picker
    name="scheduled_at"
    label="Scheduled activation"
    type="datetime-local"
    helper="Times use the workspace time zone."
/>
```

Validation example:

```blade
<x-ui.date-picker
    name="expires_on"
    label="Expiration date"
    :value="old('expires_on')"
    :error="$errors->first('expires_on')"
    required
/>
```

### 4.1. Props/options

| Prop/option    | Type                  | Default | Allowed values                                          | Required | Notes                                                                 |
| -------------- | --------------------- | ------: | ------------------------------------------------------- | -------: | --------------------------------------------------------------------- |
| `name`         | `string`              |       — | Valid form field name                                   |      Yes | Must map to the submitted field.                                      |
| `id`           | `string / null`       |  `null` | derived from `name`                                     |       No | Use when multiple instances require explicit ids.                     |
| `label`        | `string`              |       — | Plain text or escaped text                              |      Yes | Visible label is required. Placeholder-only labeling is prohibited.   |
| `value`        | `string / null`       |  `null` | `YYYY-MM-DD` for date, `YYYY-MM-DDTHH:mm` for date-time |       No | Use normalized values that native inputs can parse.                   |
| `defaultValue` | `string / null`       |  `null` | same as `value`                                         |       No | Alias for APIs that distinguish initial/default values.               |
| `type`         | `string`              |  `date` | `date`, `datetime-local`                                |       No | Other native temporal types require a documented extension.           |
| `min`          | `string / null`       |  `null` | Valid date or date-time value matching `type`           |       No | Pair with helper copy when the constraint matters to users.           |
| `minDate`      | `string / null`       |  `null` | Valid date or date-time value matching `type`           |       No | Alias for `min`.                                                      |
| `max`          | `string / null`       |  `null` | Valid date or date-time value matching `type`           |       No | Pair with helper copy when the constraint matters to users.           |
| `maxDate`      | `string / null`       |  `null` | Valid date or date-time value matching `type`           |       No | Alias for `max`.                                                      |
| `step`         | `int / string / null` |  `null` | Native input step value                                 |       No | Use only when seconds/minute precision is product-approved.           |
| `required`     | `bool`                | `false` | `true`, `false`                                         |       No | Must be paired with server validation.                                |
| `disabled`     | `bool`                | `false` | `true`, `false`                                         |       No | Disabled fields are not submitted and are not focusable.              |
| `readonly`     | `bool`                | `false` | `true`, `false`                                         |       No | Prefer plain text summaries when the value is purely informational.   |
| `readOnly`     | `bool`                | `false` | `true`, `false`                                         |       No | Alias for `readonly`.                                                 |
| `helper`       | `string / null`       |  `null` | Short explanatory copy                                  |       No | Include format, time-zone, or constraint guidance when needed.        |
| `helperText`   | `string / null`       |  `null` | Short explanatory copy                                  |       No | Alias for `helper`.                                                   |
| `error`        | `string / null`       |  `null` | Short recovery copy                                     |       No | Sets invalid/error treatment and links copy to the control.           |
| `invalid`      | `bool`                | `false` | `true`, `false`                                         |       No | Alias state for Carbon-style invalid APIs.                            |
| `invalidText`  | `string / null`       |  `null` | Short recovery copy                                     |       No | Error copy used when `invalid` is true.                               |
| `warning`      | `string / null`       |  `null` | Short caution copy                                      |       No | Use for non-blocking business-rule cautions.                          |
| `warn`         | `bool`                | `false` | `true`, `false`                                         |       No | Alias state for Carbon-style warning APIs.                            |
| `warnText`     | `string / null`       |  `null` | Short caution copy                                      |       No | Warning copy used when `warn` is true.                                |
| `autocomplete` | `string / null`       |  `null` | Valid autocomplete token                                |       No | Use only valid browser tokens.                                        |
| `placeholder`  | `string / null`       |  `null` | Native placeholder                                      |       No | Never use as the label or only format guidance.                       |
| `dateFormat`   | `string / null`       |  `null` | Short date format label                                 |       No | Renders helper copy when helper text is not supplied.                 |
| `size`         | `string`              |    `md` | `sm`, `md`, `lg`                                        |       No | Controls native field height.                                         |
| `style`        | `string`              | `default` | `default`, `fluid`                                    |       No | Fluid uses the 64px expressive field treatment.                       |
| `skeleton`     | `bool`                | `false` | `true`, `false`                                         |       No | Loading placeholder; disables the native input and exposes status.    |
| `attributes`   | `array`               |    `[]` | Extra safe HTML attributes                              |       No | Do not use this to inject local style, raw color, or custom behavior. |

### 4.2. Value contract

| Type             | Submitted value shape | Example            | Notes                                                                                                         |
| ---------------- | --------------------- | ------------------ | ------------------------------------------------------------------------------------------------------------- |
| `date`           | `YYYY-MM-DD`          | `2026-06-08`       | Browser display may localize, but the value should remain normalized.                                         |
| `datetime-local` | `YYYY-MM-DDTHH:mm`    | `2026-06-08T09:30` | Does not include a time-zone offset. The surrounding Pattern must explain the relevant time zone when needed. |

### 4.3. Data attributes

The installed native-control API exposes data attributes for review, tests, and future-safe initialization boundaries:

| Attribute | Owner | Use |
| --------- | ----- | --- |
| `data-ui-component="date-picker"` | Component | Identifies the component root. |
| `data-ui-date-picker` | Component | Identifies the field wrapper. |
| `data-ui-date-picker-type` | Component | Records `date` or `datetime-local`. |
| `data-ui-date-picker-size` | Component | Records `sm`, `md`, or `lg`. |
| `data-ui-date-picker-style` | Component | Records `default` or `fluid`. |
| `data-ui-date-picker-input` | Component | Identifies the native input when editable. |
| `data-ui-date-picker-readonly` | Component | Identifies the read-only submitted value summary. |
| `data-ui-component="date-range-picker"` | Component | Identifies the range picker proof root. |
| `data-ui-date-range-picker` | Component | Initialization boundary for range picker behavior. |
| `data-ui-date-range-input` | Component | Identifies start and end range inputs. |
| `data-ui-date-range-calendar` | Component | Identifies the range calendar surface. |
| `data-ui-date-range-day` | Component | Identifies selectable calendar days and range preview state. |
| `data-ui-component="time-picker"` | Component | Identifies the time picker composition. |
| `data-ui-time-picker` | Component | Identifies the time picker wrapper. |

Future data attributes for unavailable-date rules, relative date shortcuts, AI presence, or masking behavior must be documented here before use.

## 5. Allowed variants, options, and modifiers

Date picker has no decorative visual variants. It has installed input types, field states, and composition boundaries.

| Name               | Type                  | Status                   | API                              | Use when                                                                                                         |
| ------------------ | --------------------- | ------------------------ | -------------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Native single date | Input type            | Approved API             | `type="date"`                    | User enters one date and a native control is sufficient.                                                         |
| Native date-time   | Input type            | Approved API             | `type="datetime-local"`          | User enters one local date-time and the workflow does not require a custom time-zone selector.                   |
| Minimum date       | Constraint            | Approved API             | `min="YYYY-MM-DD"`               | Dates before a known lower bound are invalid.                                                                    |
| Maximum date       | Constraint            | Approved API             | `max="YYYY-MM-DD"`               | Dates after a known upper bound are invalid.                                                                     |
| Required date      | Constraint            | Approved API             | `required`                       | Submission cannot proceed without a value.                                                                       |
| Small              | Size                  | Approved API             | `size="sm"`                      | Use in dense forms where the surrounding pattern supports compact fields.                                         |
| Medium             | Size                  | Approved API             | `size="md"`                      | Default field size.                                                                                              |
| Large              | Size                  | Approved API             | `size="lg"`                      | Use where taller form fields are required by the surrounding pattern.                                             |
| Fluid              | Style                 | Approved API             | `style="fluid"`                  | Use the 64px expressive field treatment for high-emphasis form contexts.                                         |
| Helper text        | Field modifier        | Approved API             | `helper="..."`                   | Format, time-zone, or constraint guidance helps prevent errors.                                                  |
| Error state        | Field state           | Approved API             | `error="..."`                    | Validation blocks submission and needs recovery copy.                                                            |
| Warning state      | Field state           | Approved API             | `warning="..."`                  | A non-blocking caution should be visible.                                                                        |
| Disabled           | State                 | Approved API             | `disabled`                       | The date cannot be changed and should not submit.                                                                |
| Read-only          | State                 | Approved API             | `readonly`                       | The value is visible but not editable. Prefer plain text when no field affordance is needed.                     |
| Skeleton/loading   | State                 | Approved API             | `skeleton`                       | Use only while date field data is loading and final shape is known.                                              |
| Range date picker  | Component variant     | Approved API             | `data-ui-date-range-picker`      | Use when users need calendar context and coordinated start/end selection.                                        |
| Calendar popover   | Component enhancement | Approved for range proof | `data-ui-date-range-calendar`    | Use with the installed range picker proof; simple single-date native popups remain browser-owned.                |
| Time picker        | Component composition | Approved API             | `data-ui-time-picker`            | Use for a time text field with AM/PM and timezone selects.                                                       |
| Time-zone selector | Component composition | Approved API             | Select component inside time picker | Use when a time value needs explicit timezone context.                                                        |
| Date masking       | Enhancement           | Deferred                 | None approved                    | Requires localization, parsing, validation, and accessibility review.                                            |

Do not render deferred variants as working production UI.

## 6. States

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

| State           | Status                       | Required implementation                                                                                   |
| --------------- | ---------------------------- | --------------------------------------------------------------------------------------------------------- |
| Default         | Approved API                 | Labeled native date input with token-backed field styling.                                                |
| Empty value     | Approved API                 | No selected/submitted value. Helper text remains available when present.                                  |
| Filled value    | Approved API                 | Normalized value is rendered by the native control.                                                       |
| Hover-capable   | Approved API                 | Browser and app field hover treatment must remain token-backed where implemented.                         |
| Focus-visible   | Approved API                 | Visible focus ring/treatment is required.                                                                 |
| Disabled        | Approved API                 | Native `disabled` attribute. Do not attach custom interactive behavior.                                   |
| Read-only       | Approved API                 | Native `readonly` attribute or read-only field treatment. Consider plain text for non-editable summaries. |
| Required        | Approved API                 | Native `required` plus server validation.                                                                 |
| Helper text     | Approved API                 | Helper text is associated through description semantics.                                                  |
| Error           | Approved API                 | Error copy is visible, non-color-only, and linked to the input. Use `aria-invalid` when invalid.          |
| Warning         | Approved API                 | Warning copy is visible and non-color-only. Do not mark valid fields invalid solely for warnings.         |
| Min/max invalid | Approved API                 | Constraint is enforced by validation and explained when users can act on it.                              |
| Skeleton/loading | Approved API               | Use `skeleton` when the field value or constraints are loading and the final field shape is known.        |
| Range selecting | Approved API                 | Range picker updates start/end values, selected range, and hover preview through `initDateRangePickers`. |
| Calendar open   | Approved for range proof     | Range calendar menu is visible in the UI Reference proof with date buttons and selected range state.     |
| Time picker     | Approved API                 | Time field, AM/PM select, and timezone select use text-input/select state behavior.                      |

## 7. Token, class, and helper usage

Date picker consumes Foundation Color, Spacing, Typography, and Themes through the app field classes.

### 7.1. Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes

Recommended app-owned classes and helpers:

| Class/helper       | Owner                    | Allowed usage                                           |
| ------------------ | ------------------------ | ------------------------------------------------------- |
| `ui-field`         | Component / Form Pattern | Wraps label, control, helper text, and validation copy. |
| `ui-field-label`   | Component                | Visible field label.                                    |
| `ui-input`         | Component                | Baseline field chrome.                                  |
| `ui-input-date`    | Component                | Date/date-time-specific input hook.                     |
| `ui-date-picker-sm` / `ui-date-picker-md` / `ui-date-picker-lg` | Component | Installed field heights. |
| `ui-date-picker-fluid` | Component | 64px expressive field treatment. |
| `ui-date-picker-readonly-value` | Component | Read-only submitted value summary. |
| `ui-date-range-picker` | Component | Range picker wrapper and calendar surface. |
| `ui-date-range-day` | Component | Calendar day button and range state hook. |
| `ui-time-picker` | Component | Time picker composition layout. |
| `ui-field-helper`  | Component                | Helper, format, and constraint copy.                    |
| `ui-field-error`   | Component                | Blocking validation message.                            |
| `ui-field-warning` | Component                | Non-blocking caution message.                           |
| `ui-field-meta`    | Component / Pattern      | Optional compact metadata such as time-zone context.    |

Do not hard-code raw color, spacing, font size, borders, focus rings, icons, or motion values in feature views.

## 8. Composition rules

- Use native semantics first. Do not add JavaScript unless an approved enhancement requires it.
- A visible label is required for every date picker.
- Helper text should explain constraints, format expectations, or time-zone context when those affect successful entry.
- Error and warning copy must be visible and associated with the field through the installed field API.
- `date` values use `YYYY-MM-DD` for the submitted value.
- `datetime-local` values use `YYYY-MM-DDTHH:mm` and do not include a time-zone offset.
- When a time zone matters, the parent Pattern must expose that context in helper text, adjacent content, or a separate approved control.
- `min`, `max`, and `step` must match the selected input type and server validation.
- Native browser date picker UI may vary by device and browser. Do not depend on custom visual styling of the browser picker popup.
- Range selection is installed for the date range picker proof. Parent Patterns still own submission, filter/query behavior, server validation, labels, and recovery copy.
- Components own internal semantics and styling. Parent Patterns own grouping, external spacing, workflow orchestration, filtering behavior, and page-level layout.

## 9. Selection guidance

### 9.1. Use when:

- Users need to enter or choose one date.
- Users need to enter one local date-time.
- Users need to select a start and end date with visible calendar context.
- Users need to enter a time with AM/PM and timezone context.
- Native browser date/date-time controls satisfy the workflow.
- The date is known, approximate, memorable, or simple enough to type.
- A filter, form, or settings workflow needs a standard date field with helper and validation states.

### 9.2. Do not use when:

- Users need unavailable-date rules or blocked-date semantics that are not installed.
- Users need recurring schedules, multiple dates, or relative date shortcuts.
- Users need month-only, year-only, fiscal period, or relative date shortcuts.
- Placeholder text would be the only label.
- A custom picker is being added for visual preference without a date, range, or time selection need.

Use related APIs instead:

| Need                                                | Use                                                                                   |
| --------------------------------------------------- | ------------------------------------------------------------------------------------- |
| Plain text entry                                    | Text input                                                                            |
| Select from a short known set such as month or year | Select                                                                                |
| Exact numeric value, duration, or interval          | Number input                                                                          |
| Start/end date relationship                         | Date range picker for calendar selection; Form or filtering Pattern owns submission and query behavior |
| Complex scheduling workflow                         | Forms Pattern                                                                         |
| Search/filter query by date                         | Table or Filter Pattern owns the query behavior                                       |

## 10. Accessibility contract

- Use a native input for the installed API: `input[type="date"]` or `input[type="datetime-local"]`.
- Provide a visible text label for every control.
- Associate helper, warning, and error copy with the input through the installed field description API.
- Use `aria-invalid="true"` only for invalid/error states.
- Maintain a visible focus state.
- Do not rely on placeholder text as the accessible name or sole format instruction.
- Do not rely on color alone for error, warning, required, unavailable, or disabled meaning.
- Keep server validation messages specific enough to tell users how to recover.
- Preserve keyboard access to the native field.
- Range picker day buttons must expose selected range state, focus-visible treatment, and status copy that updates when the range changes.

## 11. Content contract

- Use sentence case labels.
- Name the date being requested directly, such as `Start date`, `Expiration date`, `Scheduled activation`, or `Report end date`.
- Avoid vague labels such as `Date`, `When`, or `Select date` when a more specific label is available.
- Helper text should explain constraints users can act on: date format, earliest date, latest date, time-zone context, or business rule.
- Error text should explain the problem and the required recovery.
- Warning text should explain the caution without implying submission is blocked.
- Date-time fields must explain the relevant time zone when the submitted value is interpreted in a specific zone.
- Do not use placeholder text as the only format guidance.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not rely on placeholder text as the only label.
- Do not use custom field chrome when the native control satisfies the workflow.
- Do not import or initialize a third-party date picker library without an approved standard update.
- Do not copy Carbon DatePicker JavaScript, Carbon production classes, or Carbon visual markup into Login App feature views.
- Do not build local range picker, calendar popover, unavailable-date picker, or time-zone selector markup outside the Date picker component contract.
- Do not style the browser-native picker popup as if it were an app-owned surface.
- Do not store display-formatted date strings as the canonical submitted value.
- Do not hide required format, time-zone, or validation information in placeholder text.

## 13. Deferred or gated capabilities

| Capability              | Status                   | Gate                                                                                                                                                   |
| ----------------------- | ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Unavailable-date rules  | Deferred                 | Requires disabled-date semantics, non-color meaning, keyboard behavior, and server validation.                                                         |
| Relative date shortcuts | Deferred                 | Requires Filter/Forms Pattern ownership and visible result explanation.                                                                                |
| Date masking/parsing    | Deferred                 | Requires localization, validation, screen reader behavior, and manual input fallback review.                                                           |
| Month/year-only picker  | Deferred                 | Requires approved use case and component or Select/Number composition decision.                                                                        |

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

The `Live examples` card may use tabs, grouped examples, matrices, or full-width sections. Date picker should remain relatively simple and may use tabbed scenarios or grouped field examples.

| Required proof              | Rendered behavior                                                                                                      | Variants/options shown                                                                           |
| --------------------------- | ---------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ |
| Native single date          | Native `input[type="date"]` demonstrates visible label, helper text, normalized value, and token-backed field styling. | Default, Helper text, Focus-visible, Min/max when useful                                         |
| Native date-time            | Native `input[type="datetime-local"]` demonstrates date-time entry and time-zone helper copy.                          | Date-time, Helper text, Focus-visible                                                            |
| Validation date             | Required date field demonstrates blocking validation copy and non-color-only error treatment.                          | Required, Error, Warning, `aria-invalid`, Described-by text                                      |
| Disabled and read-only date | Disabled and read-only examples show how unavailable and non-editable values are represented.                          | Disabled, Read-only                                                                              |
| Bounded scheduling date     | Minimum and maximum dates demonstrate user-visible constraints and server-validation alignment.                        | `min`, `max`, Helper text                                                                        |
| Date range picker           | Calendar range picker lets users choose start and end dates from either input and previews the hovered end range.       | Start input, End input, Calendar open, Range selected, Hover preview |
| Time picker                 | Time text field is composed with AM/PM and timezone selects.                                                           | Time text input, AM/PM select, Timezone select |

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/date-picker` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The page does not contain `Component-specific API pending correction.`
- The page renders `x-ui.date-picker` as the canonical Blade API.
- The page renders at least one native `input[type="date"]` example.
- The page renders at least one native `input[type="datetime-local"]` example.
- The page shows helper, error, warning, disabled, read-only, required, min, and max behavior.
- The page states that placeholder text is not a label.
- The page renders an app-owned range calendar proof with start/end inputs, selected range, and hover preview state hooks.
- The page renders a time picker proof with time text input, AM/PM select, and timezone select.
- The page does not render unavailable-date rules, relative shortcuts, or date masking as production UI.
- The page does not use Carbon production classes such as `cds--date-picker` or `bx--date-picker`.
- The page does not link to deprecated `tier-1` or `tier-2` canonical docs paths.

Suggested feature assertions:

```php
$response->assertOk();
$response->assertSee('Date picker');
$response->assertSee('x-ui.date-picker');
$response->assertSee('type=&quot;date&quot;', false);
$response->assertSee('type=&quot;datetime-local&quot;', false);
$response->assertSee('Single date entry');
$response->assertSee('Date range picker');
$response->assertSee('Time picker anatomy');
$response->assertSee('Styles and fluid versions');
$response->assertSee('States');
$response->assertSee('data-ui-component="date-range-picker"', false);
$response->assertSee('data-ui-date-range-day', false);
$response->assertSee('data-ui-component="time-picker"', false);
$response->assertSee('placeholder text is not a label');
$response->assertSee('data-component-live-layout="date-picker-matrix"', false);
$response->assertSee('data-ui-date-picker-size="sm"', false);
$response->assertSee('data-ui-date-picker-style="fluid"', false);
$response->assertSee('data-ui-date-picker-readonly', false);
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('cds--date-picker');
$response->assertDontSee('bx--date-picker');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
```

## 17. Related APIs

| API                    | Route                                            |
| ---------------------- | ------------------------------------------------ |
| Text input             | `/platform/ui-reference/components/text-input`   |
| Select                 | `/platform/ui-reference/components/select`       |
| Number input           | `/platform/ui-reference/components/number-input` |
| Form patterns          | `/platform/ui-reference/patterns/forms`          |
| Table/filter patterns  | `/platform/ui-reference/patterns/tables`         |
| Scheduling composition | `/platform/ui-reference/patterns/forms`          |
| Components overview    | `/platform/ui-reference/components`              |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- [Carbon Date picker usage](https://carbondesignsystem.com/components/date-picker/usage/)
- [Carbon Date picker style](https://carbondesignsystem.com/components/date-picker/style/)
- [Carbon Date picker accessibility](https://carbondesignsystem.com/components/date-picker/accessibility/)

Carbon Date picker guidance informs the distinction between simple date input, calendar picker, range picker, and time picker. Login App standardizes native date/date-time input, app-owned range calendar selection, and time picker composition while gating unavailable-date rules, masking, relative shortcuts, and AI presence until those capabilities are installed.

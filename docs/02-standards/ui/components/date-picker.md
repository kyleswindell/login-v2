---
title: Date picker
slug: date-picker
status: implemented-pending-correction
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

Date picker uses native date controls for simple date and date-time entry.

Canonical API owner: `/platform/ui-reference/components/date-picker`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

This standard is intentionally narrower than Carbon's full Date picker component. Login App currently standardizes native browser date and date-time fields. Full calendar popovers, range calendars, unavailable-date calendars, and custom time-zone picker workflows are deferred unless a specific product workflow installs and proves those APIs.

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

Date picker now has component-specific UI Reference examples that consume approved Foundation Elements.

The installed Login App standard is:

- Use native `input[type="date"]` for simple single-date entry.
- Use native `input[type="datetime-local"]` for simple date-time entry when the workflow does not require a separate time-zone selector.
- Use labels, helper text, validation copy, disabled/read-only treatment, and token-backed field states consistently with the Form Pattern.
- Use server-side validation as the source of truth for required, minimum, maximum, and business-rule validation.
- Treat browser-rendered date picker popups as native browser behavior, not as app-owned visual surfaces.
- Defer full calendar picker, range picker, unavailable-date rules, custom time picker, and custom date masking until a dedicated API and accessibility contract are approved.

This component owns the field-level date/date-time input API. Parent Patterns own form layout, start/end date relationships, scheduling workflows, filtering behavior, submission, persistence, and server validation orchestration.

## 4. Public API

| API surface     | Installed value                                                                                                                                                                                               |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade           | `x-ui.date-picker`                                                                                                                                                                                            |
| JavaScript      | No dedicated JavaScript controller required for the installed native-control API.                                                                                                                             |
| Data attributes | None required for the installed API. Use only documented `data-ui-*` attributes if a future enhancement adds behavior.                                                                                        |
| Props/options   | `name`, `id`, `label`, `value`, `type`, `min`, `max`, `step`, `required`, `disabled`, `readonly`, `helper`, `error`, `warning`, `autocomplete`, `attributes`.                                                 |
| CSS namespace   | Use the app-owned `ui-*` namespace documented by the component implementation. Recommended namespaces are `ui-field`, `ui-field-label`, `ui-input`, `ui-input-date`, `ui-field-helper`, and `ui-field-error`. |
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
| `type`         | `string`              |  `date` | `date`, `datetime-local`                                |       No | Other native temporal types require a documented extension.           |
| `min`          | `string / null`       |  `null` | Valid date or date-time value matching `type`           |       No | Pair with helper copy when the constraint matters to users.           |
| `max`          | `string / null`       |  `null` | Valid date or date-time value matching `type`           |       No | Pair with helper copy when the constraint matters to users.           |
| `step`         | `int / string / null` |  `null` | Native input step value                                 |       No | Use only when seconds/minute precision is product-approved.           |
| `required`     | `bool`                | `false` | `true`, `false`                                         |       No | Must be paired with server validation.                                |
| `disabled`     | `bool`                | `false` | `true`, `false`                                         |       No | Disabled fields are not submitted and are not focusable.              |
| `readonly`     | `bool`                | `false` | `true`, `false`                                         |       No | Prefer plain text summaries when the value is purely informational.   |
| `helper`       | `string / null`       |  `null` | Short explanatory copy                                  |       No | Include format, time-zone, or constraint guidance when needed.        |
| `error`        | `string / null`       |  `null` | Short recovery copy                                     |       No | Sets invalid/error treatment and links copy to the control.           |
| `warning`      | `string / null`       |  `null` | Short caution copy                                      |       No | Use for non-blocking business-rule cautions.                          |
| `autocomplete` | `string / null`       |  `null` | Valid autocomplete token                                |       No | Use only valid browser tokens.                                        |
| `attributes`   | `array`               |    `[]` | Extra safe HTML attributes                              |       No | Do not use this to inject local style, raw color, or custom behavior. |

### 4.2. Value contract

| Type             | Submitted value shape | Example            | Notes                                                                                                         |
| ---------------- | --------------------- | ------------------ | ------------------------------------------------------------------------------------------------------------- |
| `date`           | `YYYY-MM-DD`          | `2026-06-08`       | Browser display may localize, but the value should remain normalized.                                         |
| `datetime-local` | `YYYY-MM-DDTHH:mm`    | `2026-06-08T09:30` | Does not include a time-zone offset. The surrounding Pattern must explain the relevant time zone when needed. |

### 4.3. Data attributes

No date-picker-specific data attributes are approved for the installed native-control API.

Future data attributes for custom calendar behavior, range selection, unavailable-date rules, or time-zone behavior must be documented here before use.

## 5. Allowed variants, options, and modifiers

Date picker has no decorative visual variants. It has installed input types, field states, and composition boundaries.

| Name               | Type                  | Status                   | API                              | Use when                                                                                                         |
| ------------------ | --------------------- | ------------------------ | -------------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Native single date | Input type            | Approved API             | `type="date"`                    | User enters one date and a native control is sufficient.                                                         |
| Native date-time   | Input type            | Approved API             | `type="datetime-local"`          | User enters one local date-time and the workflow does not require a custom time-zone selector.                   |
| Minimum date       | Constraint            | Approved API             | `min="YYYY-MM-DD"`               | Dates before a known lower bound are invalid.                                                                    |
| Maximum date       | Constraint            | Approved API             | `max="YYYY-MM-DD"`               | Dates after a known upper bound are invalid.                                                                     |
| Required date      | Constraint            | Approved API             | `required`                       | Submission cannot proceed without a value.                                                                       |
| Helper text        | Field modifier        | Approved API             | `helper="..."`                   | Format, time-zone, or constraint guidance helps prevent errors.                                                  |
| Error state        | Field state           | Approved API             | `error="..."`                    | Validation blocks submission and needs recovery copy.                                                            |
| Warning state      | Field state           | Approved API             | `warning="..."`                  | A non-blocking caution should be visible.                                                                        |
| Disabled           | State                 | Approved API             | `disabled`                       | The date cannot be changed and should not submit.                                                                |
| Read-only          | State                 | Approved API             | `readonly`                       | The value is visible but not editable. Prefer plain text when no field affordance is needed.                     |
| Range date picker  | Component variant     | Deferred                 | None approved                    | Use only after a dedicated range API, keyboard model, validation contract, and UI Reference proof are installed. |
| Calendar popover   | Component enhancement | Deferred                 | None approved                    | Use only when native controls are insufficient and the custom calendar behavior is approved.                     |
| Time-only picker   | Component variant     | Deferred                 | None approved                    | Use only after a dedicated time-picker standard is approved.                                                     |
| Time-zone selector | Pattern composition   | Deferred / Pattern-owned | None approved at component level | Forms Patterns own time-zone selection when required.                                                            |
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
| Loading         | Not applicable               | Date picker does not own loading. Parent Patterns may show loading around a form region.                  |
| Calendar open   | Not app-owned for native API | Browser-native picker behavior is not styled or scripted by Login App.                                    |
| Range selecting | Deferred                     | Do not fake range selection without a dedicated range API.                                                |

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
- Range selection is not installed as a component API. A Pattern may compose two single-date fields only when it owns the relationship, validation, labels, and error recovery.
- Components own internal semantics and styling. Parent Patterns own grouping, external spacing, workflow orchestration, filtering behavior, and page-level layout.

## 9. Selection guidance

### 9.1. Use when:

- Users need to enter or choose one date.
- Users need to enter one local date-time.
- Native browser date/date-time controls satisfy the workflow.
- The date is known, approximate, memorable, or simple enough to type.
- A filter, form, or settings workflow needs a standard date field with helper and validation states.

### 9.2. Do not use when:

- Users need a full visual calendar to compare dates, blocked dates, or date relationships.
- Users need to select a start/end range as one coordinated component.
- Users need recurring schedules, multiple dates, or unavailable-date rules.
- Users need time-zone selection as part of the same control.
- Users need month-only, year-only, fiscal period, or relative date shortcuts.
- Placeholder text would be the only label.
- Native controls satisfy the workflow but a custom field chrome is being added for visual preference only.

Use related APIs instead:

| Need                                                | Use                                                                                   |
| --------------------------------------------------- | ------------------------------------------------------------------------------------- |
| Plain text entry                                    | Text input                                                                            |
| Select from a short known set such as month or year | Select                                                                                |
| Exact numeric value, duration, or interval          | Number input                                                                          |
| Start/end date relationship                         | Form or filtering Pattern composed from two date pickers until range API is installed |
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
- Preserve keyboard access to the native field. Do not intercept keyboard behavior for custom calendar behavior unless a full accessibility contract is installed.
- When range behavior is deferred, do not simulate range selection with inaccessible dual controls.

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
- Do not build a fake range picker, fake calendar popover, fake unavailable-date picker, or fake time-zone selector from local markup.
- Do not style the browser-native picker popup as if it were an app-owned surface.
- Do not store display-formatted date strings as the canonical submitted value.
- Do not hide required format, time-zone, or validation information in placeholder text.

## 13. Deferred or gated capabilities

| Capability              | Status                   | Gate                                                                                                                                                   |
| ----------------------- | ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Range date picker       | Deferred                 | Requires product workflow, start/end validation contract, keyboard model, accessible labels, error recovery, and UI Reference proof.                   |
| Custom calendar popover | Deferred                 | Requires calendar keyboard behavior, focus management, dismissal, month/year navigation, unavailable-date rules if applicable, and UI Reference proof. |
| Time-only picker        | Deferred                 | Requires time format, localization, step behavior, validation, and UI Reference proof.                                                                 |
| Time-zone selector      | Pattern-owned / Deferred | Requires Forms Pattern ownership and approved Select/Dropdown composition.                                                                             |
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
| Range deferred              | Range picker is explicitly shown as deferred or Pattern-owned. Do not render fake custom range behavior.               | Deferred, Alternative composition with two single-date fields only when labeled as Pattern-owned |

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
- The page states that range picker and custom calendar picker behavior are deferred unless a future API is installed.
- The page does not render a fake calendar popover, fake range calendar, or fake unavailable-date calendar as production UI.
- The page does not use Carbon production classes such as `cds--date-picker` or `bx--date-picker`.
- The page does not link to deprecated `tier-1` or `tier-2` canonical docs paths.

Suggested feature assertions:

```php
$response->assertOk();
$response->assertSee('Date picker');
$response->assertSee('x-ui.date-picker');
$response->assertSee('type=&quot;date&quot;', false);
$response->assertSee('type=&quot;datetime-local&quot;', false);
$response->assertSee('Native single date');
$response->assertSee('Native date-time');
$response->assertSee('Validation date');
$response->assertSee('Range deferred');
$response->assertSee('placeholder text is not a label');
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

Carbon Date picker guidance informs the distinction between simple date input, calendar picker, range picker, and time picker. Login App standardizes native date/date-time input first and gates custom calendar/range behavior until it is installed and proven.
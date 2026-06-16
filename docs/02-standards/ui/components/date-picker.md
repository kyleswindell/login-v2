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
related_patterns:
  - forms
  - tables
---

# Date Picker Component Standard

- [1. Purpose](#1-purpose)
- [2. Approved variants](#2-approved-variants)
- [3. Public API](#3-public-api)
- [4. Styling](#4-styling)
- [5. States](#5-states)
- [6. Content](#6-content)
- [7. Accessibility](#7-accessibility)
- [8. Composition](#8-composition)
- [9. Prohibited usage](#9-prohibited-usage)
- [10. UI Reference requirements](#10-ui-reference-requirements)
- [11. Acceptance criteria](#11-acceptance-criteria)
- [12. References](#12-references)

## 1. Purpose

Date picker supports three approved component surfaces:

- Simple date input: one date text/native input with visible label and format guidance.
- Calendar picker: a date input with calendar affordance, including the app-owned date range proof when start/end selection is needed.
- Time picker: a composed control containing a time text input, AM/PM select, and timezone select.

Date + Time combo picker is not an approved component option. Do not use a single `datetime-local` live example as a substitute for time picker composition.

Canonical API owner: `/platform/ui-reference/components/date-picker`.

## 2. Approved Variants

| Variant | Status | Required parts | Use when |
| --- | --- | --- | --- |
| Simple date input | Approved | Label, date input, optional helper/status text | A workflow needs one date and browser/native date entry is sufficient. |
| Calendar picker | Approved | Label, date input, calendar affordance; range picker adds start/end labels and one calendar menu | A user benefits from choosing a date or range from a calendar surface. |
| Time picker | Approved | Label, hour/minute input, AM/PM select for 12-hour time, timezone select | A workflow needs a specific time and associated timezone. |

All three variants support default and fluid styling.

Default size support:

| Size | Height | Use case |
| --- | ---: | --- |
| Small `sm` | 32px / 2rem | Dense forms or constrained spaces. |
| Medium `md` | 40px / 2.5rem | Default and most common size. |
| Large `lg` | 48px / 3rem | Simple forms or isolated controls with more room. |

Fluid size support:

| Style | Height | Use case |
| --- | ---: | --- |
| Fluid | 64px / 4rem | Expressive forms, contained spaces, or controls attached to complex components. |

## 3. Public API

| Surface | Installed value |
| --- | --- |
| Blade | `x-ui.date-picker` for simple date input and calendar-field shell. |
| JavaScript | `initDateRangePickers` for range calendar selection and hover range preview. |
| Data attributes | `data-ui-component="date-picker"`, `data-ui-date-picker`, `data-ui-date-picker-type`, `data-ui-date-picker-size`, `data-ui-date-picker-style`, `data-ui-date-picker-input`, `data-ui-date-picker-readonly`, `data-ui-component="date-range-picker"`, `data-ui-date-range-picker`, `data-ui-date-range-input`, `data-ui-date-range-calendar`, `data-ui-date-range-day`, `data-ui-component="time-picker"`, `data-ui-time-picker`. |
| CSS namespace | `ui-date-picker`, `ui-date-range-picker`, `ui-time-picker`, shared `ui-field`, `ui-input`, and `ui-select` roles. |
| Source files | `resources/views/components/ui/date-picker.blade.php`, `resources/views/platform/ui-reference/components/live-examples/date-picker.blade.php`, `resources/js/ui-controls/date-range-pickers.js`, `resources/css/app.css`. |

Approved simple date call:

```blade
<x-ui.date-picker
    name="start_date"
    label="Start date"
    helper="Format: yyyy-mm-dd."
    min-date="2026-01-01"
    max-date="2026-12-31"
/>
```

Approved fluid date call:

```blade
<x-ui.date-picker
    name="renewal_date"
    label="Renewal date"
    style="fluid"
    value="2026-06-18"
/>
```

Time picker is composed from text input and Select component primitives. It is not represented by `x-ui.date-picker type="datetime-local"`.

## 4. Styling

Default style:

- Label sits above the field.
- The date/time entry field owns the field layer background.
- The surrounding example/card layer does not become part of the input background.
- Default fields support `sm`, `md`, and `lg`.

Fluid style:

- Label sits inside the field shell.
- The full component shell owns the field layer background and border.
- Fluid fields use a single 64px height except when warning or error text extends the component.
- Time picker fluid style applies the 64px treatment to the time input, AM/PM select, and timezone select as one composed row.

Hover:

- Date picker and time picker fields should not show a visible hover color shift.
- The only hover affordance for entry fields is the cursor changing to the text-entry cursor.
- Calendar day cells may still use calendar-specific hover/preview states.

Layering:

- Default inputs use `--ui-field-01` only on the entry field.
- Fluid inputs use `--ui-field-01` on the complete field shell.
- Example cards and parent containers use layer tokens independently and must not redefine component fields with local background utilities.

## 5. States

Universal states apply to simple date input, calendar picker fields, and time picker fields.

| State | Required behavior |
| --- | --- |
| Enabled | Field is live and editable. |
| Hover | No visible hover color shift on entry fields; cursor changes to text cursor. |
| Focus | Focus ring appears when the user tabs to or clicks into the control and remains until the next click or keyboard focus action. |
| Open | Calendar picker menu is visible and interactive. Only calendar picker owns this state. |
| Error | Invalid field uses `--ui-support-error` for border/outline and visible recovery copy. In multi-field pickers, mark only the invalid field. |
| Warning | Warning text is visible and non-blocking. |
| Disabled | Field is not focusable or submitted. Label, text, icon, and border use disabled tokens. Default disabled field keeps the field background and hides the default bottom border; fluid disabled field keeps subtle shell border. |
| Read-only | Value is reviewable, accessible, and non-editable. |
| Skeleton | Initial loading placeholder; interactive behavior is removed. |

Disabled token expectations:

- Label and field text use `--ui-text-disabled`.
- Calendar and select icons use `--ui-icon-disabled`.
- Disabled non-subtle borders use `--ui-border-disabled`.
- Disabled date/time field background remains `--ui-field-01`.

Error token expectations:

- Error border and focus-style outline use `--ui-support-error`.
- Error message text uses the app error text role.
- Error state must not rely on placeholder text or color alone.

## 6. Content

Labels:

- Every date and time picker field must have a visible label.
- Date range inputs must be labeled independently as start and end dates.
- Labels should be clear and descriptive.

Date format:

- Simple date input must include format guidance inline with the label or helper text.
- Do not rely only on placeholder text for format guidance because it disappears as the user types.
- Date format copy must match the configured value format.

Time format:

- 12-hour and 24-hour systems are allowed.
- 12-hour time must include AM/PM selection.
- Use uppercase `AM` and `PM` with no periods.
- Specific times should specify a timezone.

## 7. Accessibility

- Use visible labels, not placeholder-only labeling.
- Link helper, warning, and error copy with the field through `aria-describedby`.
- Use `aria-invalid="true"` only for invalid fields.
- Disabled fields must not be focusable.
- Read-only values must remain readable and accessible.
- Calendar range buttons must have meaningful date labels.
- Time picker select controls must expose their label and selected value.

## 8. Composition

Time picker composes existing primitives:

- Time field follows Text input behavior.
- AM/PM and timezone controls follow Select behavior, including the approved chevron icon.
- Time picker row must keep those controls on one composed line when there is enough width and wrap only when the container is genuinely constrained.

Calendar picker composes:

- Date field shell.
- Calendar trigger/affordance.
- Calendar menu or range menu when date selection from a calendar is required.

Parent patterns own form layout, persistence, filtering, submission, and server validation orchestration.

## 9. Prohibited Usage

- Do not display Date + Time combo picker as an approved live example.
- Do not use `datetime-local` as a UI Reference substitute for time picker composition.
- Do not create local date picker shells with raw Tailwind color utilities.
- Do not hard-code hover backgrounds for date/time entry fields.
- Do not use placeholder-only date format guidance.
- Do not mark all fields invalid when only one date/time field is invalid.
- Do not build production unavailable-date rules, date masking, relative shortcuts, or AI presence until those capabilities have approved standards.

## 10. UI Reference Requirements

The UI Reference page must organize the live examples into three tabs:

| Tab | Required live examples |
| --- | --- |
| Simple date input | Default simple date input, fluid simple date input, small/medium/large default sizes, universal states. |
| Calendar picker | Default calendar picker, fluid calendar picker, working date range proof with start/end inputs and selectable calendar days, calendar picker states. |
| Time picker | Default time picker row, fluid time picker row, small/medium/large default time picker sizing, focus/error/disabled states. |

The page must also show:

- `x-ui.date-picker` usage.
- `data-date-picker-tabs`.
- `data-ui-component="date-range-picker"`.
- `data-ui-date-range-input="start"` and `data-ui-date-range-input="end"`.
- `data-ui-date-range-calendar` and `data-ui-date-range-day`.
- `data-ui-component="time-picker"`.
- `data-ui-time-picker`.
- `data-ui-time-picker-period`.
- `data-ui-time-picker-timezone`.
- No approved live `datetime-local` combo example.

## 11. Acceptance Criteria

- Simple date input, calendar picker, and time picker are visually and structurally separate.
- Default and fluid styles are represented for all three approved surfaces.
- Default sizes `sm`, `md`, and `lg` are represented for date and time picker fields.
- Fluid examples use one 64px shell treatment.
- Date range calendar icons render at 16px by 16px and do not scale with the surrounding page.
- Date range picker is interactive through `initDateRangePickers`.
- Time picker displays time, AM/PM, and timezone controls as one composed row when width allows.
- AM/PM and timezone controls use the Select component chevron.
- Date/time entry fields do not show a visible hover background or border shift.
- Error examples use `--ui-support-error` for border/outline.
- Disabled examples are visibly muted with disabled text/icon/border tokens.
- Date and time format helper copy matches the rendered values.
- The focused state can be inspected after click or keyboard focus.
- Component source, CSS, UI Reference, and this standard remain synchronized.

## 12. References

- Carbon Date picker style guidance.
- Carbon Date picker usage guidance.
- Login App Text input standard.
- Login App Select standard.
- Login App Color standard.

---
status: implemented-pending-review
slug: date-picker
ui_reference_route: /platform/ui-reference/components/date-picker
canonical_doc: docs/02-standards/ui/components/date-picker.md
source_owner: /platform/ui-reference/components/date-picker
---

# Date Picker Component Standard

## Purpose

Date Picker collects calendar dates through three approved component variants:

- Simple date input: text entry only. It does not open a calendar.
- Single calendar picker: one input with Flatpickr calendar behavior.
- Range calendar picker: two inputs with Flatpickr range behavior.

Time Picker is not a Date Picker variant. Time entry is a separate composed text-input/select surface and must not be represented by `x-ui.date-picker`.

## Ownership

| Layer | Owner |
| --- | --- |
| Blade API | `x-ui.date-picker`, `x-ui.date-picker-input`, `x-ui.date-picker-skeleton` |
| Calendar engine | `flatpickr@4.6.13`, imported locally through `resources/js/ui-controls/date-picker.js` |
| Range bridge | Flatpickr `rangePlugin` for two-input range selection; documented by Flatpickr as beta |
| JavaScript lifecycle | `initDatePickers(root = document)`, safe for first load and `livewire:navigated` |
| CSS namespace | `ui-date-picker*`, app-owned token overrides for Flatpickr calendar markup |
| Reference support | `docs/09-reference/ui/flatpickr-date-picker-dependency-review.md` |

Flatpickr is a behavior dependency only. Login owns the Blade API, `ui-*` classes, data attributes, token mapping, UI Reference examples, and accessibility labels.

## Approved API

### Wrapper

```blade
<x-ui.date-picker
    date-picker-type="single"
    value="2019-03-15"
    date-format="m/d/Y"
    min-date="2019-03-13"
    max-date="2019-03-31"
>
    <x-ui.date-picker-input
        name="scheduled_date"
        label-text="Scheduled date"
        value="03/15/2019"
        calendar
    />
</x-ui.date-picker>
```

Wrapper props:

| Prop | Values / type | Notes |
| --- | --- | --- |
| `date-picker-type` | `simple`, `single`, `range` | Defaults to `single`. `simple` does not initialize Flatpickr. |
| `value` | string or array | `range` accepts two values. |
| `date-format` | Flatpickr format string | Defaults to `Y-m-d`. Must match displayed value configuration. |
| `locale` | Flatpickr locale key | Use only when imported/available through Flatpickr. |
| `min-date`, `max-date` | date string | Passed to Flatpickr for calendar variants. |
| `disable`, `enable` | array | Date allow/deny lists passed to Flatpickr. |
| `allow-input` | boolean | Defaults to true. |
| `close-on-select` | boolean | Defaults to true for `single`, false for `range`. |
| `inline` | boolean | Inline calendar mode; use sparingly in UI Reference proof only. |
| `append-to` | selector | Optional calendar portal target. |
| `prev-month-aria-label`, `next-month-aria-label` | string | Applied to calendar navigation controls. |

### Input

```blade
<x-ui.date-picker-input
    name="end_date"
    label-text="End date"
    role="end"
    calendar
    invalid
    invalid-text="Required field"
/>
```

Input props:

| Prop | Values / type | Notes |
| --- | --- | --- |
| `id`, `name` | string | `name` is required. |
| `label-text` | string | Required visible label unless `hide-label` is used for a pattern-owned accessible label. |
| `placeholder` | string | Date format may not rely only on placeholder text. |
| `helper-text` | string | Use for format guidance and non-blocking help. |
| `size` | `sm`, `md`, `lg` | Default input heights are 32px, 40px, and 48px. |
| `style` | `default`, `fluid` | Fluid input is 64px and keeps the label inside the field. |
| `disabled`, `read-only` | boolean | Disabled removes interaction; read-only remains readable. |
| `invalid`, `invalid-text` | boolean/string | Invalid state applies only to the field causing the error. |
| `warn`, `warn-text` | boolean/string | Warning state applies only to the relevant field. |
| `calendar` | boolean | Shows the calendar icon for `single` and `range` fields. |
| `role` | `start`, `end` | Required on range inputs. |

### Range

```blade
<x-ui.date-picker date-picker-type="range" :value="['2019-03-12', '2019-03-16']" date-format="m/d/Y">
    <div class="ui-date-picker-range-fields">
        <x-ui.date-picker-input name="start_date" label-text="Start date" role="start" calendar />
        <x-ui.date-picker-input name="end_date" label-text="End date" role="end" calendar />
    </div>
</x-ui.date-picker>
```

Range uses Flatpickr `mode: "range"` and `rangePlugin({ input: secondInput })` so both fields update a shared range selection. The second field is not a separate date picker instance.

### Skeleton

```blade
<x-ui.date-picker-skeleton />
<x-ui.date-picker-skeleton range />
```

Skeleton has no inputs and no Flatpickr initialization hook.

## Behavior

- Simple date input is first-party text input behavior only.
- Single and range variants initialize Flatpickr locally from `resources/js/ui-controls/date-picker.js`.
- Initializers must be idempotent and safe on `root = document` and `livewire:navigated`.
- Calendar state must synchronize `data-ui-date-picker-open` and `data-ui-date-picker-selected-value`.
- Range selection must show two labeled fields and keep start/end state clear.
- Escape and outside-click close behavior is owned by Flatpickr and verified through browser review.
- Do not use CDN Flatpickr or global `window.flatpickr`.
- Do not copy Carbon React code.

## States

Date Picker input states follow Text Input state rules:

- Enabled
- Focus
- Open, for calendar variants only
- Error
- Warning
- Disabled
- Read-only
- Skeleton

For range validation, apply invalid/warning state only to the field causing the issue. Do not mark the whole range invalid when only start or end needs correction.

## UI Reference Requirements

The Date Picker UI Reference page must show:

- Approved tabs: Simple, Single, Range, Skeleton.
- Simple examples with no Flatpickr initialization hooks.
- Single examples with calendar icon, min/max, date format, locale-ready data, disabled dates, focus/open/error/warning/disabled/read-only states.
- Range examples with two child `x-ui.date-picker-input` fields, start/end labels, one-field validation, range value sync, min/max, disabled dates, today and previous/next month navigation from Flatpickr.
- Skeleton examples for single and range.
- No Date + Time combo picker.
- No Time Picker tab on the Date Picker page.
- No legacy `variant="calendar"` or `calendar=true` wrapper API.
- No custom UI Reference-only range calendar proof path.

## Source References

- Flatpickr options: https://flatpickr.js.org/options/
- Flatpickr events and hooks: https://flatpickr.js.org/events/
- Flatpickr plugins, including `rangePlugin`: https://flatpickr.js.org/plugins/
- Flatpickr examples: https://flatpickr.js.org/examples/
- Flatpickr localization: https://flatpickr.js.org/localization/

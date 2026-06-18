# Flatpickr Date Picker Dependency Review

This is a support reference for the Login Date Picker component. Canonical component rules live in `docs/02-standards/ui/components/date-picker.md`.

## Dependency

- Package: `flatpickr`
- Version: `4.6.13`
- Import owner: `resources/js/ui-controls/date-picker.js`
- CSS import: `flatpickr/dist/flatpickr.css`, followed by app-owned `ui-*` token overrides
- CDN usage: prohibited

## App Usage Boundary

Flatpickr is used only for calendar behavior:

- `date-picker-type="single"` initializes Flatpickr with `mode: "single"`.
- `date-picker-type="range"` initializes Flatpickr with `mode: "range"` and `rangePlugin({ input: secondInput })`.
- `date-picker-type="simple"` does not initialize Flatpickr.
- Time Picker is out of scope for this dependency.

The app owns Blade component props, accessibility labels, UI Reference examples, and all visual treatment.

## Options Used

The bridge maps app props/data attributes to Flatpickr options:

- `allowInput`
- `appendTo`
- `ariaDateFormat`
- `closeOnSelect`
- `dateFormat`
- `defaultDate`
- `disable`
- `enable`
- `inline`
- `locale`
- `maxDate`
- `minDate`
- `mode`
- `plugins`

Official options reference: https://flatpickr.js.org/options/

## Hooks Used

The app uses Flatpickr hooks for lifecycle state only:

- `onReady`
- `onOpen`
- `onClose`
- `onChange`
- `onValueUpdate`

The hooks receive `selectedDates`, `dateStr`, and the Flatpickr instance. The app uses them to decorate the calendar surface and synchronize `data-ui-date-picker-open` / `data-ui-date-picker-selected-value`.

Official hooks reference: https://flatpickr.js.org/events/

## Range Plugin Boundary

Flatpickr documents `rangePlugin` as beta. The app accepts that boundary because it provides the closest supported two-input range behavior for the Carbon-style range picker anatomy.

Risk controls:

- Import the plugin only in `resources/js/ui-controls/date-picker.js`.
- Keep range proof covered in UI Reference.
- Keep the second input as a child input, not as a separate Flatpickr instance.
- Re-review if Flatpickr changes plugin stability or API shape.

Official plugins reference: https://flatpickr.js.org/plugins/

## Localization And Formatting

Date formats use Flatpickr format tokens. The rendered input value, helper text, and UI Reference copy must agree. Locale usage must be verified against Flatpickr localization support before a new locale is represented as approved.

Official examples: https://flatpickr.js.org/examples/
Official localization reference: https://flatpickr.js.org/localization/

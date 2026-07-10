<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/date-picker/contract.php
| Purpose: Date Picker Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Date Picker API that can be called from
| Blade, validated by tooling, and consumed by form layouts or Patterns.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::component([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'slug' => 'date-picker',
        'label' => 'Date Picker',
        'component' => 'x-ui.date-picker',
        'summary' => 'Date picker form control supporting simple, single, and range modes with labels, helper text, invalid/warning states, read-only/disabled states, short/light treatments, min/max metadata, locale metadata, and JavaScript calendar initialization hooks.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    'lifecycle' => [
        'status' => 'provisional',
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Blade API
    |--------------------------------------------------------------------------
    */

    'api' => [
        'usage_context' => 'Use x-ui.date-picker for date entry fields that need calendar behavior, date parsing, range selection, min/max metadata, or date-picker JavaScript integration. Use x-ui.text-input for plain free-form date text without calendar behavior.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Date picker root ID. A generated ID is used when omitted.'],
            ['name' => 'datePickerType', 'type' => 'string', 'required' => false, 'default' => 'single', 'values' => ['simple', 'single', 'range'], 'description' => 'Canonical date picker type.'],
            ['name' => 'type', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['simple', 'single', 'range'], 'description' => 'Shorter compatibility alias for datePickerType. When supplied, it takes precedence.', 'compatibility' => true],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native input name for simple/single mode or start input fallback in range mode.'],
            ['name' => 'startName', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native start date input name. Falls back to name.'],
            ['name' => 'endName', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native end date input name for range mode. Falls back to name_end when name exists.'],
            ['name' => 'labelText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Shared label text fallback for simple/single or start date input.'],
            ['name' => 'startLabelText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Start date label text. Falls back to labelText or Date.'],
            ['name' => 'endLabelText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'End date label text for range mode. Falls back to End date.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides labels while preserving them for assistive technology.'],
            ['name' => 'value', 'type' => 'string|array|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Date value. In range mode may be [start, end].'],
            ['name' => 'startValue', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Explicit start date value.'],
            ['name' => 'endValue', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Explicit end date value for range mode.'],
            ['name' => 'placeholder', 'type' => 'string', 'required' => false, 'default' => 'mm/dd/yyyy', 'values' => [], 'description' => 'Shared placeholder fallback for date inputs.'],
            ['name' => 'startPlaceholder', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Start date placeholder. Falls back to placeholder.'],
            ['name' => 'endPlaceholder', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'End date placeholder. Falls back to placeholder.'],
            ['name' => 'dateFormat', 'type' => 'string', 'required' => false, 'default' => 'm/d/Y', 'values' => [], 'description' => 'Date format metadata for installed date picker JavaScript.'],
            ['name' => 'allowInput', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Allows direct text input when true. When false, rendered input is readonly for static markup.'],
            ['name' => 'closeOnSelect', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Close-on-select behavior marker for installed date picker JavaScript.'],
            ['name' => 'inline', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Inline behavior metadata for installed date picker JavaScript.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native readonly state and date picker readonly metadata.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native disabled state.'],
            ['name' => 'short', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Short date picker visual treatment. Simple mode also applies short treatment.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light date picker treatment.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'minDate', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Minimum date metadata for installed date picker JavaScript.'],
            ['name' => 'maxDate', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Maximum date metadata for installed date picker JavaScript.'],
            ['name' => 'locale', 'type' => 'string', 'required' => false, 'default' => 'en', 'values' => [], 'description' => 'Locale metadata for installed date picker JavaScript.'],
            ['name' => 'nextMonthAriaLabel', 'type' => 'string', 'required' => false, 'default' => 'Next month', 'values' => [], 'description' => 'Next month accessible label metadata for calendar UI.'],
            ['name' => 'prevMonthAriaLabel', 'type' => 'string', 'required' => false, 'default' => 'Previous month', 'values' => [], 'description' => 'Previous month accessible label metadata for calendar UI.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'date-picker', 'description' => 'Generated form item component marker.'],
            ['name' => 'data-ui-date-picker-form-item', 'required' => true, 'description' => 'Generated form item marker.'],
            ['name' => 'data-ui-date-picker-state', 'required' => true, 'description' => 'Generated state marker: default, invalid, or warning.'],
            ['name' => 'data-ui-date-picker', 'required' => true, 'description' => 'Generated date picker control marker.'],
            ['name' => 'data-ui-date-picker-type', 'required' => true, 'description' => 'Generated date picker type marker.'],
            ['name' => 'data-ui-date-picker-date-format', 'required' => true, 'description' => 'Generated date format marker.'],
            ['name' => 'data-ui-date-picker-allow-input', 'required' => true, 'description' => 'Generated allow input marker.'],
            ['name' => 'data-ui-date-picker-close-on-select', 'required' => true, 'description' => 'Generated close-on-select marker.'],
            ['name' => 'data-ui-date-picker-inline', 'required' => true, 'description' => 'Generated inline marker.'],
            ['name' => 'data-ui-date-picker-readonly', 'required' => true, 'description' => 'Generated readonly marker.'],
            ['name' => 'data-ui-date-picker-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-date-picker-light', 'required' => true, 'description' => 'Generated light marker.'],
            ['name' => 'data-ui-date-picker-short', 'required' => true, 'description' => 'Generated short marker.'],
            ['name' => 'data-ui-date-picker-locale', 'required' => true, 'description' => 'Generated locale marker.'],
            ['name' => 'data-ui-date-picker-next-month-label', 'required' => true, 'description' => 'Generated next month label marker.'],
            ['name' => 'data-ui-date-picker-prev-month-label', 'required' => true, 'description' => 'Generated previous month label marker.'],
            ['name' => 'data-ui-date-picker-min-date', 'required' => false, 'description' => 'Generated min date marker.'],
            ['name' => 'data-ui-date-picker-max-date', 'required' => false, 'description' => 'Generated max date marker.'],
            ['name' => 'data-ui-date-picker-container', 'required' => true, 'description' => 'Generated start/end input container marker.'],
            ['name' => 'data-ui-date-picker-input', 'required' => true, 'description' => 'Generated native input marker.'],
            ['name' => 'data-ui-date-picker-input-role', 'required' => true, 'description' => 'Generated input role marker: start or end.'],
            ['name' => 'data-ui-date-picker-input-state', 'required' => true, 'description' => 'Generated input state marker.'],
            ['name' => 'data-ui-date-picker-validation', 'required' => false, 'description' => 'Generated invalid/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-date-picker',
        'required' => [
            'ui-form-item',
            'ui-date-picker',
            'ui-date-picker-container',
            'ui-date-picker__input-wrapper',
            'ui-date-picker__input',
        ],
        'optional' => [
            'ui-date-picker--short',
            'ui-date-picker--light',
            'ui-date-picker--simple',
            'ui-date-picker--single',
            'ui-date-picker--range',
            'ui-date-picker--nolabel',
            'ui-date-picker--invalid',
            'ui-date-picker--warning',
            'ui-label',
            'ui-visually-hidden',
            'ui-label--disabled',
            'ui-date-picker__input--invalid',
            'ui-date-picker__input--warning',
            'ui-date-picker__icon',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-form-requirement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local date picker wrappers',
            'ad hoc date range markup outside x-ui.date-picker',
            'raw calendar input markup without date picker hooks',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'simple' => ['label' => 'Simple', 'api' => ['datePickerType' => 'simple'], 'class' => 'ui-date-picker--simple', 'description' => 'Simple date input treatment without calendar icon.'],
        'single' => ['label' => 'Single', 'api' => ['datePickerType' => 'single'], 'class' => 'ui-date-picker--single', 'description' => 'Single date picker mode.'],
        'range' => ['label' => 'Range', 'api' => ['datePickerType' => 'range'], 'class' => 'ui-date-picker--range', 'description' => 'Range date picker mode with start and end inputs.'],
        'short' => ['label' => 'Short', 'api' => ['short' => true], 'class' => 'ui-date-picker--short', 'description' => 'Short date picker visual treatment.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-date-picker--light', 'description' => 'Light date picker treatment.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Date picker with visually hidden labels.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Helper text'], 'class' => 'ui-form__helper-text', 'description' => 'Date picker with helper text.'],
        'with-min-max' => ['label' => 'With min/max', 'api' => ['minDate' => '01/01/2026', 'maxDate' => '12/31/2026'], 'description' => 'Date picker with min/max metadata.'],
        'inline' => ['label' => 'Inline', 'api' => ['inline' => true], 'description' => 'Date picker with inline behavior metadata.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled date picker state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled date picker state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only date picker state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid date picker state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning date picker state.'],
        'with-calendar' => ['label' => 'With calendar', 'required' => false, 'description' => 'Calendar behavior is available for single/range modes through installed JavaScript.'],
        'range' => ['label' => 'Range', 'required' => false, 'description' => 'Start/end input state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for date inputs and calendar controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-date-picker',
            'ui-form',
            'ui-label',
        ],
        'component_tokens' => [
            'date-picker',
            'calendar',
            'form-field',
            'validation',
        ],
        'deprecated' => [
            'feature-local date picker wrappers',
            'ad hoc date range fields',
            'raw calendar input markup',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
            'icons',
            'forms',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'calendar',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'date picker behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'filters',
            'date-range-filters',
            'scheduling',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native text input keyboard behavior must remain intact.',
            'Calendar open/close, date grid navigation, range behavior, and parsing behavior are owned by installed Date Picker JavaScript.',
            'Disabled inputs must not be focusable.',
            'Read-only inputs may remain focusable for reading/copying values.',
        ],
        'aria' => [
            'Each date input should be labelled by visible or visually hidden label text.',
            'Helper, invalid, and warning text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Read-only state emits aria-readonly.',
            'Calendar icon is decorative and hidden from assistive technology.',
            'Calendar navigation labels are exposed through data hooks for installed calendar behavior.',
        ],
        'focus' => [
            'Date inputs and installed calendar controls must show visible focus.',
            'Focus placement inside the calendar is owned by installed Date Picker JavaScript.',
        ],
        'screen_reader' => [
            'Labels should identify whether an input is a start date, end date, or single date.',
            'Min/max constraints should be clear from label/helper text when they matter.',
            'Invalid and warning messages must describe the problem or caution clearly.',
            'Placeholder must not be the only accessible label.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'type', 'replacement' => 'datePickerType', 'description' => 'type remains accepted as a shorter compatibility alias.'],
        ],
        'classes' => [
            'feature-local date picker classes',
            'raw calendar input utility clusters',
        ],
        'components' => [
            'ad hoc date picker/date range fields outside x-ui.date-picker',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    'source' => [
        'blade' => [
            'resources/views/components/ui/date-picker/index.blade.php',
        ],
        'css' => [
            'resources/css/components/date-picker.css',
        ],
        'contract' => [
            'resources/views/components/ui/date-picker/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/date-picker.md',
        ],
    ],
]);

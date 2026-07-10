<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/date-picker-input/contract.php
| Purpose: Date Picker Input Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Date Picker Input API that can be called
| from Blade, validated by tooling, and consumed by custom date picker
| compositions or form layouts.
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
        'slug' => 'date-picker-input',
        'label' => 'Date Picker Input',
        'component' => 'x-ui.date-picker-input',
        'summary' => 'Date picker input primitive with label, helper text, invalid/warning states, read-only/disabled states, size support, pattern, placeholder, date picker type metadata, optional decorator, and calendar/status icon treatment.',
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
        'usage_context' => 'Use x-ui.date-picker-input as a companion primitive for custom date-picker compositions. Use x-ui.date-picker for the full simple/single/range date picker control.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Input ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native input name for form submission.'],
            ['name' => 'datePickerType', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['simple', 'single', 'range'], 'description' => 'Date picker type metadata. simple suppresses calendar icon unless invalid/warning icon is needed.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'text', 'values' => [], 'description' => 'Native input type.'],
            ['name' => 'labelText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Canonical label text.'],
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for labelText.', 'compatibility' => true],
            ['name' => 'value', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native input value.'],
            ['name' => 'placeholder', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native placeholder text.'],
            ['name' => 'pattern', 'type' => 'string', 'required' => false, 'default' => '\d{1,2}\/\d{1,2}\/\d{4}', 'values' => [], 'description' => 'Native pattern attribute.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'md', 'lg'], 'description' => 'Date picker input size.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native disabled state.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native readonly state and aria-readonly marker.'],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides the label while preserving it for assistive technology.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorator rendered inside the input wrapper.'],
            ['name' => 'slug', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Legacy alias for decorator.', 'compatibility' => true],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'date-picker-input', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-date-picker-input-container', 'required' => true, 'description' => 'Generated input container marker.'],
            ['name' => 'data-ui-date-picker-input-container-state', 'required' => true, 'description' => 'Generated container state marker.'],
            ['name' => 'data-ui-date-picker-input-container-size', 'required' => true, 'description' => 'Generated container size marker.'],
            ['name' => 'data-ui-date-picker-input-wrapper', 'required' => true, 'description' => 'Generated input wrapper marker.'],
            ['name' => 'data-ui-date-picker-input-wrapper-state', 'required' => true, 'description' => 'Generated wrapper state marker.'],
            ['name' => 'data-ui-date-picker-input', 'required' => true, 'description' => 'Generated native input marker.'],
            ['name' => 'data-ui-date-picker-input-state', 'required' => true, 'description' => 'Generated native input state marker.'],
            ['name' => 'data-ui-date-picker-input-size', 'required' => true, 'description' => 'Generated native input size marker.'],
            ['name' => 'data-ui-date-picker-input-type', 'required' => false, 'description' => 'Generated date picker type metadata marker.'],
            ['name' => 'data-ui-date-picker-input-validation', 'required' => false, 'description' => 'Generated invalid/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-date-picker-container',
        'required' => [
            'ui-date-picker-container',
            'ui-date-picker-input__wrapper',
            'ui-date-picker__input',
        ],
        'optional' => [
            'ui-date-picker--nolabel',
            'ui-label',
            'ui-visually-hidden',
            'ui-label--disabled',
            'ui-label--readonly',
            'ui-date-picker-input__wrapper--invalid',
            'ui-date-picker-input__wrapper--warn',
            'ui-date-picker-input__wrapper--decorator',
            'ui-date-picker__input--sm',
            'ui-date-picker__input--md',
            'ui-date-picker__input--lg',
            'ui-date-picker__input--invalid',
            'ui-date-picker__input--warn',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-date-picker__icon',
            'ui-date-picker__icon--invalid',
            'ui-date-picker__icon--warn',
            'ui-date-picker-input-inner-wrapper--decorator',
            'ui-form-requirement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local date input wrappers',
            'ad hoc date picker input markup',
            'raw calendar input markup without date picker input hooks',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-date-picker__input', 'description' => 'Default date picker input.'],
        'simple' => ['label' => 'Simple metadata', 'api' => ['datePickerType' => 'simple'], 'description' => 'Simple date picker metadata, suppressing calendar icon unless invalid/warning icon is needed.'],
        'single' => ['label' => 'Single metadata', 'api' => ['datePickerType' => 'single'], 'description' => 'Single date picker metadata.'],
        'range' => ['label' => 'Range metadata', 'api' => ['datePickerType' => 'range'], 'description' => 'Range date picker metadata.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Input with visually hidden label.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Helper text'], 'class' => 'ui-form__helper-text', 'description' => 'Input with helper text.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['decorator' => '#'], 'class' => 'ui-date-picker-input__wrapper--decorator', 'description' => 'Input with decorator content.'],
        'with-calendar-icon' => ['label' => 'With calendar icon', 'api' => ['datePickerType' => 'single'], 'class' => 'ui-date-picker__icon', 'description' => 'Input with calendar icon.'],
        'without-calendar-icon' => ['label' => 'Without calendar icon', 'api' => ['datePickerType' => 'simple'], 'description' => 'Simple input without calendar icon.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-date-picker__input--sm', 'description' => 'Small date picker input.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-date-picker__input--md', 'description' => 'Default date picker input size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-date-picker__input--lg', 'description' => 'Large date picker input.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled date picker input state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled input state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only input state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid input state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning input state.'],
        'with-icon' => ['label' => 'With icon', 'required' => false, 'description' => 'Calendar, invalid, or warning icon is rendered.'],
        'with-decorator' => ['label' => 'With decorator', 'required' => false, 'description' => 'Decorator content is rendered.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for the native input.'],
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
            'date-picker-input',
            'date-picker',
            'form-field',
            'validation',
        ],
        'deprecated' => [
            'feature-local date input wrappers',
            'ad hoc date picker input markup',
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
            'date-picker',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'calendar',
                'warning--filled',
                'warning--alt',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'date picker behavior if installed',
            ],
        ],
        'blocks' => [
            'date-picker',
            'custom-date-picker-compositions',
            'forms',
            'filters',
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
            'Calendar behavior and parsing are owned by installed Date Picker JavaScript.',
            'Disabled inputs must not be focusable.',
            'Read-only inputs may remain focusable for reading/copying values.',
        ],
        'aria' => [
            'Input should be labelled by visible or visually hidden label text, or caller-provided aria-label/aria-labelledby.',
            'Helper, invalid, and warning text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Read-only state emits aria-readonly.',
            'Calendar and validation icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Native input must show visible focus.',
        ],
        'screen_reader' => [
            'Label should identify the date value being entered.',
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
            ['name' => 'label', 'replacement' => 'labelText', 'description' => 'label remains accepted as a compatibility alias.'],
            ['name' => 'slug', 'replacement' => 'decorator', 'description' => 'slug remains accepted as a compatibility alias for decorator.'],
        ],
        'classes' => [
            'feature-local date input classes',
            'raw calendar input utility clusters',
        ],
        'components' => [
            'ad hoc date picker input fields outside x-ui.date-picker-input or x-ui.date-picker',
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
            'resources/views/components/ui/date-picker-input/index.blade.php',
        ],
        'css' => [
            'resources/css/components/date-picker.css',
        ],
        'contract' => [
            'resources/views/components/ui/date-picker-input/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/date-picker-input.md',
        ],
    ],
]);

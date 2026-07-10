<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/time-picker/contract.php
| Purpose: Time Picker Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Time Picker API that can be called from
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
        'slug' => 'time-picker',
        'label' => 'Time Picker',
        'component' => 'x-ui.time-picker',
        'summary' => 'Time input form control with label, native time text input, optional child picker controls, invalid/warning states, read-only/disabled states, light treatment, size support, pattern, maxlength, and status icon slots.',
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
        'usage_context' => 'Use x-ui.time-picker for time entry fields, optionally with child select controls for AM/PM, timezone, or related time metadata.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Input ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native input name for form submission.'],
            ['name' => 'labelText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Visible or visually hidden input label.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides the label while preserving it for assistive technology.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native disabled state.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native readonly state and aria-readonly marker.'],
            ['name' => 'required', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native required state.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string', 'required' => false, 'default' => 'Error message goes here', 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warning', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warningText', 'type' => 'string', 'required' => false, 'default' => 'Warning message goes here', 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light time picker treatment.'],
            ['name' => 'maxLength', 'type' => 'int|string', 'required' => false, 'default' => 5, 'values' => [], 'description' => 'Native maxlength attribute.'],
            ['name' => 'pattern', 'type' => 'string', 'required' => false, 'default' => '(1[012]|[1-9]):[0-5][0-9](\s)?', 'values' => [], 'description' => 'Native pattern attribute.'],
            ['name' => 'placeholder', 'type' => 'string', 'required' => false, 'default' => 'hh:mm', 'values' => [], 'description' => 'Native placeholder text.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'md', 'lg'], 'description' => 'Time picker size.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'text', 'values' => ['text', 'time'], 'description' => 'Native input type.'],
            ['name' => 'value', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native input value.'],
            ['name' => 'inputClassName', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional extra class string applied to the native input.'],
            ['name' => 'pickerClassName', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional extra class string applied to the time picker wrapper.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Child picker controls such as AM/PM, timezone, or related selects.'],
            ['name' => 'invalidIcon', 'required' => false, 'description' => 'Custom invalid status icon. Defaults to x-ui.icon warning--filled.'],
            ['name' => 'warningIcon', 'required' => false, 'description' => 'Custom warning status icon. Defaults to x-ui.icon warning--alt.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'time-picker', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-time-picker-form-item', 'required' => true, 'description' => 'Generated form item marker.'],
            ['name' => 'data-ui-time-picker-state', 'required' => true, 'description' => 'Generated root state marker.'],
            ['name' => 'data-ui-time-picker-size', 'required' => true, 'description' => 'Generated root size marker.'],
            ['name' => 'data-ui-time-picker', 'required' => true, 'description' => 'Generated time picker wrapper marker.'],
            ['name' => 'data-ui-time-picker-light', 'required' => true, 'description' => 'Generated light state marker.'],
            ['name' => 'data-ui-time-picker-readonly', 'required' => true, 'description' => 'Generated readonly state marker.'],
            ['name' => 'data-ui-time-picker-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-time-picker-input-wrapper', 'required' => true, 'description' => 'Generated input wrapper marker.'],
            ['name' => 'data-ui-time-picker-input', 'required' => true, 'description' => 'Generated native input marker.'],
            ['name' => 'data-ui-time-picker-input-state', 'required' => true, 'description' => 'Generated input state marker.'],
            ['name' => 'data-ui-time-picker-status-icon', 'required' => false, 'description' => 'Generated status icon marker.'],
            ['name' => 'data-ui-time-picker-validation', 'required' => false, 'description' => 'Generated invalid/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-time-picker',
        'required' => [
            'ui-form-item',
            'ui-time-picker',
            'ui-time-picker__input',
            'ui-time-picker__input-field',
            'ui-text-input',
        ],
        'optional' => [
            'ui-time-picker--light',
            'ui-time-picker--invalid',
            'ui-time-picker--warning',
            'ui-time-picker--readonly',
            'ui-time-picker--sm',
            'ui-time-picker--md',
            'ui-time-picker--lg',
            'ui-label',
            'ui-visually-hidden',
            'ui-label--disabled',
            'ui-text-input--light',
            'ui-time-picker__input-field-error',
            'ui-time-picker__error__icon',
            'ui-time-picker__error__icon--invalid',
            'ui-time-picker__error__icon--warning',
            'ui-form-requirement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local time picker wrappers',
            'ad hoc time input validation markup',
            'raw AM/PM picker groups without x-ui.time-picker',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-time-picker', 'description' => 'Default time picker.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-time-picker--light', 'description' => 'Light time picker treatment.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Time picker with visually hidden label.'],
        'native-time' => ['label' => 'Native time type', 'api' => ['type' => 'time'], 'description' => 'Time picker input rendered with native type=time.'],
        'with-child-selects' => ['label' => 'With child controls', 'api' => ['slot' => 'default'], 'description' => 'Time picker with child controls such as AM/PM or timezone selects.'],
        'custom-invalid-icon' => ['label' => 'Custom invalid icon', 'api' => ['slot' => 'invalidIcon'], 'description' => 'Time picker with custom invalid icon slot.'],
        'custom-warning-icon' => ['label' => 'Custom warning icon', 'api' => ['slot' => 'warningIcon'], 'description' => 'Time picker with custom warning icon slot.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-time-picker--sm', 'description' => 'Small time picker.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-time-picker--md', 'description' => 'Default time picker size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-time-picker--lg', 'description' => 'Large time picker.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled time picker state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled time picker state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only time picker state.'],
        'required' => ['label' => 'Required', 'required' => false, 'description' => 'Required time picker state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid time picker state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning time picker state.'],
        'with-status-icon' => ['label' => 'With status icon', 'required' => false, 'description' => 'Invalid or warning status icon is rendered.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for input and child controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-time-picker',
            'ui-text-input',
            'ui-form',
            'ui-label',
        ],
        'component_tokens' => [
            'time-picker',
            'form-field',
            'validation',
        ],
        'deprecated' => [
            'feature-local time picker wrappers',
            'ad hoc time validation markup',
            'raw time picker utility clusters',
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
            'text-input',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'warning--filled',
                'warning--alt',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'time picker behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'scheduling',
            'time-filters',
            'appointments',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native input keyboard behavior must remain intact.',
            'Child controls rendered in the default slot must remain keyboard reachable unless disabled.',
            'Disabled input must not be focusable.',
            'Read-only input may remain focusable for reading/copying values.',
        ],
        'aria' => [
            'Input should be labelled by visible or visually hidden label text, or caller-provided aria-label/aria-labelledby.',
            'Invalid and warning text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage.',
            'Read-only state emits aria-readonly.',
            'Status icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Input and child controls must show visible focus.',
        ],
        'screen_reader' => [
            'Label should identify the time value being entered.',
            'Invalid and warning messages must describe the problem or caution clearly.',
            'Placeholder must not be the only accessible label.',
            'Child picker controls must have meaningful labels.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [],
        'classes' => [
            'feature-local time picker classes',
            'raw time input utility clusters',
        ],
        'components' => [
            'ad hoc time picker fields outside x-ui.time-picker',
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
            'resources/views/components/ui/time-picker/index.blade.php',
        ],
        'css' => [
            'resources/css/components/time-picker.css',
            'resources/css/components/text-input.css',
        ],
        'contract' => [
            'resources/views/components/ui/time-picker/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/time-picker.md',
        ],
    ],
]);

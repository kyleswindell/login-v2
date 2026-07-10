<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/slider/contract.php
| Purpose: Slider Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Slider API that can be called from Blade,
| validated by tooling, and consumed by form layouts or Patterns.
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
        'slug' => 'slider',
        'label' => 'Slider',
        'component' => 'x-ui.slider',
        'summary' => 'Single-value and two-handle range slider form control with text input sync, min/max labels, invalid/warning states, read-only/disabled states, hidden text input support, RTL metadata, and JavaScript slider hooks.',
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
        'usage_context' => 'Use x-ui.slider for bounded numeric values or ranges when relative adjustment is more important than exact typed entry. Use x-ui.number-input when precise numeric entry is primary.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Slider root/control ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native lower/single input name for form submission.'],
            ['name' => 'nameUpper', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native upper input name for two-handle range mode.'],
            ['name' => 'unstableNameUpper', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for nameUpper.', 'compatibility' => true],
            ['name' => 'value', 'type' => 'int|float|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Lower/single slider value.'],
            ['name' => 'valueUpper', 'type' => 'int|float|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Upper slider value for two-handle range mode.'],
            ['name' => 'unstableValueUpper', 'type' => 'int|float|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for valueUpper.', 'compatibility' => true],
            ['name' => 'min', 'type' => 'int|float|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Minimum slider value.'],
            ['name' => 'max', 'type' => 'int|float|string', 'required' => false, 'default' => 100, 'values' => [], 'description' => 'Maximum slider value.'],
            ['name' => 'step', 'type' => 'int|float|string', 'required' => false, 'default' => 1, 'values' => [], 'description' => 'Native input step and slider increment value.'],
            ['name' => 'stepMultiplier', 'type' => 'int|float|string', 'required' => false, 'default' => 4, 'values' => [], 'description' => 'Keyboard step multiplier metadata for installed Slider JavaScript.'],
            ['name' => 'labelText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Slider label text.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides label while preserving accessible labelling.'],
            ['name' => 'minLabel', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Minimum range label. Falls back to min.'],
            ['name' => 'maxLabel', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Maximum range label. Falls back to max.'],
            ['name' => 'ariaLabelInput', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label for single/lower handle and input when labelText is not sufficient.'],
            ['name' => 'ariaLabelInputUpper', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label for upper handle/input in two-handle range mode.'],
            ['name' => 'unstableAriaLabelInputUpper', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for ariaLabelInputUpper.', 'compatibility' => true],
            ['name' => 'inputType', 'type' => 'string', 'required' => false, 'default' => 'number', 'values' => ['number', 'text'], 'description' => 'Visible native text input type. Hidden type is applied automatically when hideTextInput is true.'],
            ['name' => 'hideTextInput', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Uses hidden native inputs instead of visible text inputs.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled slider state.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Read-only slider state.'],
            ['name' => 'required', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native required state for slider inputs.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid slider state. Takes precedence over warn.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning slider state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light input treatment.'],
            ['name' => 'twoHandles', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Forces two-handle range mode when true. If null, range mode is inferred from upper value.'],
            ['name' => 'rtl', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'RTL slider metadata and container class.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'slider', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-slider-form-item', 'required' => true, 'description' => 'Generated form item marker.'],
            ['name' => 'data-ui-slider-state', 'required' => true, 'description' => 'Generated state marker: default, invalid, or warning.'],
            ['name' => 'data-ui-slider-container', 'required' => true, 'description' => 'Generated slider container marker.'],
            ['name' => 'data-ui-slider-two-handles', 'required' => true, 'description' => 'Generated range mode marker.'],
            ['name' => 'data-ui-slider-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-slider-readonly', 'required' => true, 'description' => 'Generated read-only state marker.'],
            ['name' => 'data-ui-slider-required', 'required' => true, 'description' => 'Generated required state marker.'],
            ['name' => 'data-ui-slider-light', 'required' => true, 'description' => 'Generated light treatment marker.'],
            ['name' => 'data-ui-slider-rtl', 'required' => true, 'description' => 'Generated RTL marker.'],
            ['name' => 'data-ui-slider-min', 'required' => true, 'description' => 'Generated min value marker.'],
            ['name' => 'data-ui-slider-max', 'required' => true, 'description' => 'Generated max value marker.'],
            ['name' => 'data-ui-slider-step', 'required' => true, 'description' => 'Generated step marker.'],
            ['name' => 'data-ui-slider-step-multiplier', 'required' => true, 'description' => 'Generated step multiplier marker.'],
            ['name' => 'data-ui-slider-input', 'required' => true, 'description' => 'Generated native input marker.'],
            ['name' => 'data-ui-slider-input-state', 'required' => true, 'description' => 'Generated native input state marker.'],
            ['name' => 'data-ui-slider', 'required' => true, 'description' => 'Generated slider track marker.'],
            ['name' => 'data-ui-slider-thumb-wrapper', 'required' => true, 'description' => 'Generated thumb wrapper marker.'],
            ['name' => 'data-ui-slider-thumb', 'required' => true, 'description' => 'Generated slider thumb marker.'],
            ['name' => 'data-ui-slider-thumb-state', 'required' => true, 'description' => 'Generated thumb state marker.'],
            ['name' => 'data-ui-slider-handle-position', 'required' => true, 'description' => 'Generated lower/upper handle marker.'],
            ['name' => 'data-ui-slider-filled-track', 'required' => true, 'description' => 'Generated filled track marker.'],
            ['name' => 'data-ui-slider-validation', 'required' => false, 'description' => 'Generated validation/warning message marker.'],
            ['name' => 'data-ui-slider-status-message', 'required' => true, 'description' => 'Generated dynamic status message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-slider-container',
        'required' => [
            'ui-form-item',
            'ui-slider-container',
            'ui-slider',
            'ui-slider__track',
            'ui-slider__filled-track',
            'ui-slider__thumb-wrapper',
            'ui-slider__thumb',
            'ui-slider__range-label',
            'ui-text-input-wrapper',
            'ui-slider-text-input-wrapper',
            'ui-text-input',
            'ui-slider-text-input',
        ],
        'optional' => [
            'ui-label',
            'ui-visually-hidden',
            'ui-label--disabled',
            'ui-slider-container--two-handles',
            'ui-slider-container--disabled',
            'ui-slider-container--readonly',
            'ui-slider-container--rtl',
            'ui-slider-container--light',
            'ui-slider-container--invalid',
            'ui-slider-container--warning',
            'ui-slider--disabled',
            'ui-slider--readonly',
            'ui-slider-text-input-wrapper--lower',
            'ui-slider-text-input-wrapper--upper',
            'ui-slider-text-input-wrapper--hidden',
            'ui-text-input-wrapper--readonly',
            'ui-slider-text-input--lower',
            'ui-slider-text-input--upper',
            'ui-text-input--light',
            'ui-text-input--invalid',
            'ui-slider-text-input--warn',
            'ui-icon-tooltip',
            'ui-slider__thumb-wrapper--lower',
            'ui-slider__thumb-wrapper--upper',
            'ui-slider__thumb--lower',
            'ui-slider__thumb--upper',
            'ui-slider__thumb-icon',
            'ui-slider__thumb-icon--lower',
            'ui-slider__thumb-icon--upper',
            'ui-slider__invalid-icon',
            'ui-slider__invalid-icon--warning',
            'ui-slider__validation-msg',
            'ui-slider__validation-msg--invalid',
            'ui-slider__status-msg',
            'ui-form-requirement',
        ],
        'internal' => [
            'slider handle SVG anatomy',
        ],
        'deprecated' => [
            'feature-local range input wrappers',
            'raw slider markup outside x-ui.slider',
            'ad hoc paired numeric range controls where slider behavior is required',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'single' => ['label' => 'Single handle', 'api' => ['twoHandles' => false], 'description' => 'Single-value slider.'],
        'range' => ['label' => 'Two handles', 'api' => ['twoHandles' => true, 'valueUpper' => 80], 'class' => 'ui-slider-container--two-handles', 'description' => 'Two-handle range slider.'],
        'hidden-input' => ['label' => 'Hidden text input', 'api' => ['hideTextInput' => true], 'class' => 'ui-slider-text-input-wrapper--hidden', 'description' => 'Slider with hidden native inputs.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-text-input--light', 'description' => 'Light input treatment.'],
        'rtl' => ['label' => 'RTL', 'api' => ['rtl' => true], 'class' => 'ui-slider-container--rtl', 'description' => 'RTL slider treatment.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-slider-container--disabled', 'description' => 'Disabled slider.'],
        'read-only' => ['label' => 'Read-only', 'api' => ['readOnly' => true], 'class' => 'ui-slider-container--readonly', 'description' => 'Read-only slider.'],
        'required' => ['label' => 'Required', 'api' => ['required' => true], 'description' => 'Required slider inputs.'],
        'invalid' => ['label' => 'Invalid', 'api' => ['invalid' => true, 'invalidText' => 'Value is outside the allowed range.'], 'class' => 'ui-slider-container--invalid', 'description' => 'Invalid slider state.'],
        'warning' => ['label' => 'Warning', 'api' => ['warn' => true, 'warnText' => 'High value requires confirmation.'], 'class' => 'ui-slider-container--warning', 'description' => 'Warning slider state.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled slider state.'],
        'single-handle' => ['label' => 'Single handle', 'required' => true, 'description' => 'Single-handle slider state.'],
        'two-handles' => ['label' => 'Two handles', 'required' => false, 'description' => 'Two-handle range slider state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled slider state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only slider state.'],
        'required' => ['label' => 'Required', 'required' => false, 'description' => 'Required slider state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid slider state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning slider state.'],
        'hidden-input' => ['label' => 'Hidden input', 'required' => false, 'description' => 'Text input is visually hidden through hidden input type/state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for slider thumbs and text inputs.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-slider',
            'ui-slider-container',
            'ui-slider-text-input',
            'ui-text-input',
        ],
        'component_tokens' => [
            'slider',
            'range-slider',
            'numeric-range',
            'form-field',
            'validation',
        ],
        'deprecated' => [
            'feature-local slider wrappers',
            'raw range input utility clusters',
            'ad hoc range controls without x-ui.slider hooks',
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
                'slider behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'filters',
            'numeric-range-controls',
            'settings-controls',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Slider thumbs must be keyboard reachable unless disabled or read-only.',
            'Installed Slider JavaScript owns arrow key, page key, home/end, correction, dragging, and input synchronization behavior.',
            'Text inputs retain native keyboard behavior when visible.',
            'Disabled thumbs and inputs must not be focusable.',
        ],
        'aria' => [
            'Thumbs render role="slider" with aria-valuemin, aria-valuemax, aria-valuenow, and aria-valuetext.',
            'Single-handle slider should be labelled by labelText or ariaLabelInput.',
            'Range handles require distinct lower and upper accessible labels.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid text exists.',
            'Warning and invalid messages are associated through aria-describedby.',
            'Read-only state emits aria-readonly.',
        ],
        'focus' => [
            'Slider thumbs and visible text inputs must show visible focus.',
        ],
        'screen_reader' => [
            'Label should describe the value being adjusted.',
            'Range sliders must clearly distinguish lower and upper handles.',
            'Min/max labels should be understandable without visual context when they are important.',
            'Invalid and warning messages must describe the problem or caution clearly.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'unstableNameUpper', 'replacement' => 'nameUpper', 'description' => 'unstableNameUpper remains accepted as a compatibility alias.'],
            ['name' => 'unstableValueUpper', 'replacement' => 'valueUpper', 'description' => 'unstableValueUpper remains accepted as a compatibility alias.'],
            ['name' => 'unstableAriaLabelInputUpper', 'replacement' => 'ariaLabelInputUpper', 'description' => 'unstableAriaLabelInputUpper remains accepted as a compatibility alias.'],
        ],
        'classes' => [
            'feature-local slider classes',
            'raw range input utility clusters',
        ],
        'components' => [
            'ad hoc slider controls outside x-ui.slider',
            'slider-skeleton as public API unless explicitly promoted',
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
            'resources/views/components/ui/slider/index.blade.php',
        ],
        'css' => [
            'resources/css/components/slider.css',
            'resources/css/components/text-input.css',
        ],
        'contract' => [
            'resources/views/components/ui/slider/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/slider.md',
        ],
    ],
]);

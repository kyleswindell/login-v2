<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/number-input/contract.php
| Purpose: Number Input Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Number Input API that can be called from
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
        'slug' => 'number-input',
        'label' => 'Number Input',
        'component' => 'x-ui.number-input',
        'summary' => 'Numeric form control with label, helper text, invalid/warning states, read-only/disabled states, min/max/step attributes, optional steppers, light treatment, size support, locale/format metadata, and decorator content.',
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
        'usage_context' => 'Use x-ui.number-input for numeric values that benefit from min/max/step metadata or steppers. Use x-ui.text-input for plain text and x-ui.select for constrained option lists.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Input ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native input name for form submission.'],
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Visible or visually hidden input label.'],
            ['name' => 'value', 'type' => 'int|float|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Controlled input value. Takes precedence over defaultValue.'],
            ['name' => 'defaultValue', 'type' => 'int|float|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Initial input value when value is not supplied.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'number', 'values' => ['number', 'text'], 'description' => 'Native input type. text supports custom formatted number behavior.'],
            ['name' => 'min', 'type' => 'int|float|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native min attribute and JS metadata.'],
            ['name' => 'max', 'type' => 'int|float|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native max attribute and JS metadata.'],
            ['name' => 'step', 'type' => 'int|float|string', 'required' => false, 'default' => 1, 'values' => [], 'description' => 'Native step attribute and JS metadata.'],
            ['name' => 'stepStartValue', 'type' => 'int|float|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Starting value metadata for stepper behavior.'],
            ['name' => 'allowEmpty', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Allows empty value. When false and type is number, null input initializes to 0.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native disabled state. Also disables steppers.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native readonly state. Also disables steppers.'],
            ['name' => 'required', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native required state.'],
            ['name' => 'disableWheel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Wheel-prevention behavior marker for installed JavaScript.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides the label while preserving it for assistive technology.'],
            ['name' => 'hideSteppers', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Suppresses increment/decrement stepper controls.'],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light number input treatment.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'md', 'lg'], 'description' => 'Number input size.'],
            ['name' => 'inputMode', 'type' => 'string', 'required' => false, 'default' => 'decimal', 'values' => ['none', 'text', 'tel', 'url', 'email', 'numeric', 'decimal', 'search'], 'description' => 'Native inputmode attribute.'],
            ['name' => 'pattern', 'type' => 'string', 'required' => false, 'default' => '[0-9]*', 'values' => [], 'description' => 'Native pattern attribute.'],
            ['name' => 'locale', 'type' => 'string', 'required' => false, 'default' => 'en-US', 'values' => [], 'description' => 'Locale metadata for optional formatting behavior.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorator rendered inside the input wrapper.'],
            ['name' => 'slug', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Legacy alias for decorator.', 'compatibility' => true],
            ['name' => 'iconDescription', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility fallback label for stepper buttons.', 'compatibility' => true],
            ['name' => 'formatOptions', 'type' => 'array|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional number formatting metadata serialized to a data attribute.'],
            ['name' => 'incrementLabel', 'type' => 'string', 'required' => false, 'default' => 'Increment number', 'values' => [], 'description' => 'Accessible label/title for increment stepper.'],
            ['name' => 'decrementLabel', 'type' => 'string', 'required' => false, 'default' => 'Decrement number', 'values' => [], 'description' => 'Accessible label/title for decrement stepper.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'number-input', 'description' => 'Generated form item component marker.'],
            ['name' => 'data-ui-number-input-form-item', 'required' => true, 'description' => 'Generated form item marker.'],
            ['name' => 'data-ui-number-input-wrapper', 'required' => true, 'description' => 'Generated number input wrapper marker.'],
            ['name' => 'data-ui-number-input-state', 'required' => true, 'description' => 'Generated resolved state marker: default, invalid, or warning.'],
            ['name' => 'data-ui-number-input-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-number-input-locale', 'required' => true, 'description' => 'Generated locale marker.'],
            ['name' => 'data-ui-number-input-allow-empty', 'required' => true, 'description' => 'Generated allow-empty marker.'],
            ['name' => 'data-ui-number-input-disable-wheel', 'required' => true, 'description' => 'Generated disable-wheel marker.'],
            ['name' => 'data-ui-number-input-field-wrapper', 'required' => true, 'description' => 'Generated field wrapper marker.'],
            ['name' => 'data-ui-number-input', 'required' => true, 'description' => 'Generated native input marker.'],
            ['name' => 'data-ui-number-input-control', 'required' => true, 'description' => 'Generated native input control marker.'],
            ['name' => 'data-ui-number-input-type', 'required' => true, 'description' => 'Generated resolved type marker.'],
            ['name' => 'data-ui-number-input-step', 'required' => true, 'description' => 'Generated step marker.'],
            ['name' => 'data-ui-number-input-step-start-value', 'required' => true, 'description' => 'Generated step start value marker.'],
            ['name' => 'data-ui-number-input-min', 'required' => false, 'description' => 'Generated min metadata.'],
            ['name' => 'data-ui-number-input-max', 'required' => false, 'description' => 'Generated max metadata.'],
            ['name' => 'data-ui-number-input-format-options', 'required' => false, 'description' => 'Generated format options metadata.'],
            ['name' => 'data-ui-number-input-controls', 'required' => false, 'description' => 'Generated stepper controls marker.'],
            ['name' => 'data-ui-number-input-stepper', 'required' => false, 'description' => 'Generated stepper button marker.'],
            ['name' => 'data-ui-number-input-direction', 'required' => false, 'description' => 'Generated stepper direction marker: up or down.'],
            ['name' => 'data-ui-number-input-validation', 'required' => false, 'description' => 'Generated invalid/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-number',
        'required' => [
            'ui-form-item',
            'ui-number',
            'ui-number__input-wrapper',
        ],
        'optional' => [
            'ui-number--helpertext',
            'ui-number--readonly',
            'ui-number--light',
            'ui-number--nolabel',
            'ui-number--nosteppers',
            'ui-number--sm',
            'ui-number--md',
            'ui-number--lg',
            'ui-label',
            'ui-label--disabled',
            'ui-visually-hidden',
            'ui-number__input-wrapper--warning',
            'ui-number__input-wrapper--decorator',
            'ui-number__invalid',
            'ui-number__invalid--warning',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-number__input-inner-wrapper--decorator',
            'ui-number__controls',
            'ui-number__control-btn',
            'down-icon',
            'up-icon',
            'ui-number__rule-divider',
            'ui-form-requirement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local number input wrappers',
            'ad hoc numeric steppers',
            'raw number validation markup outside x-ui.number-input',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-number', 'description' => 'Default number input.'],
        'text-type' => ['label' => 'Text type', 'api' => ['type' => 'text'], 'description' => 'Text input type for custom formatted numeric behavior.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-number--light', 'description' => 'Light number input treatment.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-number--nolabel', 'description' => 'Number input with visually hidden label.'],
        'without-steppers' => ['label' => 'Without steppers', 'api' => ['hideSteppers' => true], 'class' => 'ui-number--nosteppers', 'description' => 'Number input without visible stepper controls.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Helper text'], 'class' => 'ui-form__helper-text', 'description' => 'Number input with helper text.'],
        'with-min-max' => ['label' => 'With min/max', 'api' => ['min' => 0, 'max' => 10], 'description' => 'Number input with min and max constraints.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['decorator' => '%'], 'class' => 'ui-number__input-wrapper--decorator', 'description' => 'Number input with decorator content.'],
        'allow-empty' => ['label' => 'Allow empty', 'api' => ['allowEmpty' => true], 'description' => 'Number input that permits an empty value.'],
        'disable-wheel' => ['label' => 'Disable wheel', 'api' => ['disableWheel' => true], 'description' => 'Number input with wheel-prevention metadata.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-number--sm', 'description' => 'Small number input.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-number--md', 'description' => 'Default number input size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-number--lg', 'description' => 'Large number input.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled number input state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled input and stepper state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only input and disabled stepper state.'],
        'required' => ['label' => 'Required', 'required' => false, 'description' => 'Required input state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid number input state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning number input state.'],
        'with-steppers' => ['label' => 'With steppers', 'required' => false, 'description' => 'Stepper controls rendered.'],
        'without-steppers' => ['label' => 'Without steppers', 'required' => false, 'description' => 'Stepper controls suppressed.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for input.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-number',
            'ui-form',
            'ui-label',
        ],
        'component_tokens' => [
            'number-input',
            'form-field',
            'validation',
            'stepper',
        ],
        'deprecated' => [
            'feature-local number inputs',
            'ad hoc numeric steppers',
            'raw number validation markup',
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
                'warning--filled',
                'warning--alt',
                'subtract',
                'add',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'number input behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'settings',
            'quantity-inputs',
            'numeric-filters',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native number input keyboard behavior must remain intact.',
            'Stepper buttons are intentionally removed from tab order and are driven by pointer/JS behavior.',
            'Disabled and read-only states must disable stepper buttons.',
            'Wheel-prevention behavior is owned by installed number input JavaScript.',
        ],
        'aria' => [
            'Number input should be labelled by a visible or visually hidden label, or by caller-provided aria-label/aria-labelledby.',
            'Helper, invalid, and warning text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Read-only state emits aria-readonly.',
            'Stepper buttons expose aria-label and title text.',
            'Validation and stepper icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Input must show visible focus.',
            'Stepper buttons are not in tab order by default.',
        ],
        'screen_reader' => [
            'Invalid and warning messages must describe the problem or caution clearly.',
            'Min, max, and step constraints should be clear from label/helper text when they matter.',
            'Placeholder must not be the only label.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'slug', 'replacement' => 'decorator', 'description' => 'slug remains accepted as a compatibility alias for decorator.'],
            ['name' => 'iconDescription', 'replacement' => 'incrementLabel and decrementLabel', 'description' => 'iconDescription remains accepted as fallback label text for steppers.'],
        ],
        'classes' => [
            'feature-local number input classes',
            'raw number stepper utility clusters',
        ],
        'components' => [
            'ad hoc numeric fields outside x-ui.number-input',
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
            'resources/views/components/ui/number-input/index.blade.php',
        ],
        'css' => [
            'resources/css/components/number-input.css',
        ],
        'contract' => [
            'resources/views/components/ui/number-input/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/number-input.md',
        ],
    ],
]);

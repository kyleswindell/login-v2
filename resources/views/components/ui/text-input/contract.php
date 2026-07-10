<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/text-input/contract.php
| Purpose: Text Input Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Text Input API that can be called from
| Blade, validated by tooling, and consumed by app layouts or Patterns.
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
        'slug' => 'text-input',
        'label' => 'Text Input',
        'component' => 'x-ui.text-input',
        'summary' => 'Single-line native input control with label, helper, validation, warning, counter, decorator, icon, disabled, and read-only states.',
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
        'usage_context' => 'Use x-ui.text-input for single-line native input values. The native input remains the form submission source of truth.',

        'props' => [
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Input ID. A generated ID is used when omitted.',
            ],
            [
                'name' => 'name',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Native input name attribute.',
            ],
            [
                'name' => 'type',
                'type' => 'string',
                'required' => false,
                'default' => 'text',
                'values' => [],
                'description' => 'Native input type. The component does not restrict this value, but text-like input types should remain the intended usage.',
            ],
            [
                'name' => 'labelText',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Visible label text for the input.',
            ],
            [
                'name' => 'label',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Compatibility alias for labelText.',
                'compatibility' => true,
            ],
            [
                'name' => 'value',
                'type' => 'string|int|float|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Native input value.',
            ],
            [
                'name' => 'defaultValue',
                'type' => 'string|int|float|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Compatibility fallback value used when value is not provided.',
                'compatibility' => true,
            ],
            [
                'name' => 'placeholder',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Native input placeholder and title text.',
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Disables the input and disabled visual treatment.',
            ],
            [
                'name' => 'readOnly',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Makes the input read-only and applies read-only wrapper treatment.',
            ],
            [
                'name' => 'required',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Adds the native required attribute.',
            ],
            [
                'name' => 'helperText',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Helper text shown when invalid and warning text are not active.',
            ],
            [
                'name' => 'hideLabel',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Visually hides the label while preserving it for assistive technology.',
            ],
            [
                'name' => 'inline',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies inline layout treatment.',
            ],
            [
                'name' => 'invalid',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies invalid state when the input is not disabled.',
            ],
            [
                'name' => 'invalidText',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Validation text shown for invalid state.',
            ],
            [
                'name' => 'warn',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies warning state when the input is not disabled or invalid.',
            ],
            [
                'name' => 'warnText',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Warning text shown for warning state.',
            ],
            [
                'name' => 'light',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies light field treatment.',
            ],
            [
                'name' => 'size',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['xs', 'sm', 'md', 'lg'],
                'description' => 'Optional input size.',
            ],
            [
                'name' => 'enableCounter',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Enables character counter behavior when maxCount is also provided.',
            ],
            [
                'name' => 'maxCount',
                'type' => 'int|string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Maximum character count used for maxlength and counter output when enableCounter is true.',
            ],
            [
                'name' => 'decorator',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Inline field decorator rendered inside the field wrapper.',
            ],
            [
                'name' => 'slug',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Legacy alias for decorator.',
                'compatibility' => true,
            ],
            [
                'name' => 'icon',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional decorative icon shown when invalid and warning icons are not active.',
            ],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'text-input',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-text-input-wrapper',
                'required' => true,
                'description' => 'Generated wrapper marker.',
            ],
            [
                'name' => 'data-ui-text-input-state',
                'required' => true,
                'description' => 'Generated resolved state marker: default, invalid, or warning.',
            ],
            [
                'name' => 'data-ui-text-input',
                'required' => true,
                'description' => 'Generated native input marker.',
            ],
            [
                'name' => 'data-ui-text-input-counter',
                'required' => false,
                'description' => 'Generated counter output marker.',
            ],
            [
                'name' => 'data-ui-text-input-counter-input',
                'required' => false,
                'description' => 'Generated input marker when character counter is active.',
            ],
            [
                'name' => 'data-ui-text-input-max-count',
                'required' => false,
                'description' => 'Generated max-count value marker when character counter is active.',
            ],
            [
                'name' => 'data-ui-text-input-counter-alert',
                'required' => false,
                'description' => 'Generated live announcement marker for counter changes.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-text-input-wrapper',
        'required' => [
            'ui-form-item',
            'ui-text-input-wrapper',
            'ui-text-input',
        ],
        'optional' => [
            'ui-text-input-wrapper--readonly',
            'ui-text-input-wrapper--light',
            'ui-text-input-wrapper--inline',
            'ui-text-input-wrapper--inline--invalid',
            'ui-label',
            'ui-label--disabled',
            'ui-label--inline',
            'ui-label--inline--xs',
            'ui-label--inline--sm',
            'ui-label--inline--md',
            'ui-label--inline--lg',
            'ui-visually-hidden',
            'ui-text-input--light',
            'ui-text-input--invalid',
            'ui-text-input--warning',
            'ui-text-input--xs',
            'ui-text-input--sm',
            'ui-text-input--md',
            'ui-text-input--lg',
            'ui-layout--size-xs',
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-form__helper-text--inline',
            'ui-form-requirement',
        ],
        'internal' => [
            'ui-text-input__label-wrapper',
            'ui-text-input__label-counter',
            'ui-text-input__field-outer-wrapper',
            'ui-text-input__field-outer-wrapper--inline',
            'ui-text-input__field-wrapper',
            'ui-text-input__field-wrapper--warning',
            'ui-text-input__field-wrapper--decorator',
            'ui-text-input__invalid-icon',
            'ui-text-input__invalid-icon--warning',
            'ui-text-input__icon',
            'ui-text-input__field-inner-wrapper--decorator',
            'ui-text-input__counter-alert',
        ],
        'deprecated' => [
            'feature-local input wrapper classes',
            'feature-local validation classes',
            'ad hoc form field spacing classes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => [
            'label' => 'Default',
            'api' => [],
            'description' => 'Standard block text input layout.',
        ],
        'inline' => [
            'label' => 'Inline',
            'api' => ['inline' => true],
            'class' => 'ui-text-input-wrapper--inline',
            'description' => 'Inline label and field layout.',
        ],
        'light' => [
            'label' => 'Light',
            'api' => ['light' => true],
            'class' => 'ui-text-input--light',
            'description' => 'Light field treatment.',
        ],
        'decorator' => [
            'label' => 'Decorator',
            'api' => ['decorator' => '...'],
            'class' => 'ui-text-input__field-wrapper--decorator',
            'description' => 'Input with inline field decorator.',
        ],
        'counter' => [
            'label' => 'Counter',
            'api' => ['enableCounter' => true, 'maxCount' => 100],
            'description' => 'Input with character counter and maxlength.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => [
            'label' => 'Extra small',
            'api' => ['size' => 'xs'],
            'class' => 'ui-text-input--xs',
            'description' => 'Extra small input size.',
        ],
        'sm' => [
            'label' => 'Small',
            'api' => ['size' => 'sm'],
            'class' => 'ui-text-input--sm',
            'description' => 'Small input size.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'class' => 'ui-text-input--md',
            'description' => 'Medium input size.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => ['size' => 'lg'],
            'class' => 'ui-text-input--lg',
            'description' => 'Large input size.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => [
            'label' => 'Default',
            'required' => true,
            'description' => 'Default enabled input state.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Disabled input state using native disabled attribute.',
        ],
        'read-only' => [
            'label' => 'Read-only',
            'required' => false,
            'description' => 'Read-only input state using native readonly attribute.',
        ],
        'required' => [
            'label' => 'Required',
            'required' => false,
            'description' => 'Required input state using native required attribute.',
        ],
        'invalid' => [
            'label' => 'Invalid',
            'required' => false,
            'description' => 'Invalid validation state. Takes precedence over warning.',
        ],
        'warning' => [
            'label' => 'Warning',
            'required' => false,
            'description' => 'Warning validation state. Hidden when invalid is active.',
        ],
        'helper' => [
            'label' => 'Helper text',
            'required' => false,
            'description' => 'Helper text state shown when invalid and warning text are inactive.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible keyboard focus state handled by CSS.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-text-input',
            'ui-text-input-wrapper',
            'ui-form-item',
            'ui-form__helper-text',
            'ui-form-requirement',
        ],
        'component_tokens' => [
            'text-input',
            'field',
            'form',
        ],
        'deprecated' => [
            'feature-local input colors',
            'feature-local validation colors',
            'feature-local helper text spacing',
            'placeholder-only labels',
            'ad hoc field wrappers outside x-ui.text-input',
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
        ],
        'uses' => [
            'icons' => [
                'warning--filled',
                'warning--alt',
                'dynamic icon prop',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'search',
            'date-picker',
            'number-input',
            'select',
            'textarea',
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
        ],
        'aria' => [
            'Label uses for/id association when labelText or label is provided.',
            'Helper, invalid, warning, and counter messages are merged into aria-describedby.',
            'Invalid state emits aria-invalid.',
            'Counter alert uses role="alert", aria-live="assertive", and aria-atomic="true".',
            'Invalid, warning, and decorative custom icons are hidden from assistive technology.',
        ],
        'focus' => [
            'Inputs must show visible focus.',
            'Disabled inputs are not focusable.',
            'Read-only inputs remain focusable when the browser allows it.',
        ],
        'screen_reader' => [
            'hideLabel must only be used when the hidden label still provides a meaningful accessible name.',
            'Placeholder text is not a replacement for labelText or label.',
            'Invalid and warning text should describe recovery or consequence.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            [
                'name' => 'label',
                'replacement' => 'labelText',
                'description' => 'label remains accepted as a shorter compatibility alias.',
            ],
            [
                'name' => 'slug',
                'replacement' => 'decorator',
                'description' => 'slug remains accepted as a legacy alias for decorator.',
            ],
            [
                'name' => 'defaultValue',
                'replacement' => 'value',
                'description' => 'defaultValue remains accepted as a fallback when value is omitted.',
            ],
        ],
        'classes' => [
            'feature-local input wrapper classes',
            'feature-local validation classes',
            'feature-local helper text classes',
            'raw input color utility clusters',
        ],
        'components' => [
            'ad hoc text input markup outside x-ui.text-input',
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
            'resources/views/components/ui/text-input/index.blade.php',
        ],
        'css' => [
            'resources/css/components/text-input.css',
        ],
        'contract' => [
            'resources/views/components/ui/text-input/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/text-input.md',
        ],
    ],
]);

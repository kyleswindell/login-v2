<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/radio-button/contract.php
| Purpose: Radio Button Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Radio Button API that can be called from
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
        'slug' => 'radio-button',
        'label' => 'Radio Button',
        'component' => 'x-ui.radio-button',
        'summary' => 'Native radio form control with label, checked state, disabled, read-only, required, invalid, warning, hidden label, label position, and decorator support.',
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
        'usage_context' => 'Use x-ui.radio-button for one option inside a mutually exclusive radio group. The native input remains the form submission source of truth.',

        'props' => [
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Radio input ID. A generated ID is used when omitted.',
            ],
            [
                'name' => 'name',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Native radio name attribute. Radio buttons with the same name form one selection group.',
            ],
            [
                'name' => 'value',
                'type' => 'string|int|float|bool',
                'required' => false,
                'default' => '',
                'values' => [],
                'description' => 'Native radio value attribute.',
            ],
            [
                'name' => 'labelText',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Visible label text for the radio option.',
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
                'name' => 'checked',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Checked state for the native radio input.',
            ],
            [
                'name' => 'defaultChecked',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Initial checked state fallback.',
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Disables the native radio input.',
            ],
            [
                'name' => 'readOnly',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies read-only ARIA/data markers. Radio inputs do not support a native readonly attribute.',
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
                'name' => 'hideLabel',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Visually hides the option label while preserving it for assistive technology.',
            ],
            [
                'name' => 'labelPosition',
                'type' => 'string',
                'required' => false,
                'default' => 'right',
                'values' => ['left', 'right'],
                'description' => 'Controls visual label position relative to the radio appearance.',
            ],
            [
                'name' => 'invalid',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies invalid state when the radio input is not disabled.',
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
                'description' => 'Applies warning state when the radio input is not disabled or invalid.',
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
                'name' => 'decorator',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Decorator content rendered beside the label, outside the label element.',
            ],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'radio-button',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-radio-button-wrapper',
                'required' => true,
                'description' => 'Generated wrapper marker.',
            ],
            [
                'name' => 'data-ui-radio-button-state',
                'required' => true,
                'description' => 'Generated resolved state marker: default, invalid, or warning.',
            ],
            [
                'name' => 'data-ui-radio-button',
                'required' => true,
                'description' => 'Generated native input marker.',
            ],
            [
                'name' => 'data-ui-radio-button-readonly',
                'required' => false,
                'description' => 'Generated native input marker when readOnly is true.',
            ],
            [
                'name' => 'data-ui-radio-button-validation',
                'required' => false,
                'description' => 'Generated validation message marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-radio-button-wrapper',
        'required' => [
            'ui-radio-button-wrapper',
            'ui-radio-button',
            'ui-radio-button__label',
            'ui-radio-button__appearance',
        ],
        'optional' => [
            'ui-radio-button-wrapper--label-left',
            'ui-radio-button-wrapper--decorator',
            'ui-radio-button-wrapper--invalid',
            'ui-radio-button-wrapper--warning',
            'ui-radio-button__label-text',
            'ui-visually-hidden',
            'ui-form-requirement',
        ],
        'internal' => [
            'ui-radio-button-wrapper-inner--decorator',
            'ui-radio-button__validation',
            'ui-radio-button__validation--invalid',
            'ui-radio-button__validation--warning',
        ],
        'deprecated' => [
            'feature-local radio wrapper classes',
            'feature-local validation classes',
            'ad hoc radio spacing classes',
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
            'description' => 'Standard radio button layout with label on the right.',
        ],
        'label-left' => [
            'label' => 'Label left',
            'api' => ['labelPosition' => 'left'],
            'class' => 'ui-radio-button-wrapper--label-left',
            'description' => 'Radio button layout with label positioned on the left.',
        ],
        'hidden-label' => [
            'label' => 'Hidden label',
            'api' => ['hideLabel' => true],
            'class' => 'ui-visually-hidden',
            'description' => 'Visually hidden radio label with accessible label preserved.',
        ],
        'decorator' => [
            'label' => 'Decorator',
            'api' => ['decorator' => '...'],
            'class' => 'ui-radio-button-wrapper--decorator',
            'description' => 'Radio button with decorator content rendered beside the label.',
        ],
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
        'default' => [
            'label' => 'Default',
            'required' => true,
            'description' => 'Default unchecked radio state.',
        ],
        'checked' => [
            'label' => 'Checked',
            'required' => false,
            'description' => 'Checked radio state using native checked attribute.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Disabled radio state using native disabled attribute.',
        ],
        'read-only' => [
            'label' => 'Read-only',
            'required' => false,
            'description' => 'Read-only radio state using aria/data markers.',
        ],
        'required' => [
            'label' => 'Required',
            'required' => false,
            'description' => 'Required radio state using native required attribute.',
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
            'ui-radio-button',
            'ui-radio-button-wrapper',
            'ui-form-requirement',
        ],
        'component_tokens' => [
            'radio-button',
            'field',
            'form',
        ],
        'deprecated' => [
            'feature-local radio colors',
            'feature-local validation colors',
            'feature-local helper text spacing',
            'ad hoc radio markup outside x-ui.radio-button',
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
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'filters',
            'tables',
            'single-selection',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native radio keyboard behavior must remain intact.',
            'Arrow-key behavior is provided by the browser for radios with the same name.',
        ],
        'aria' => [
            'Label uses for/id association.',
            'Invalid and warning messages are merged into aria-describedby.',
            'Invalid state emits aria-invalid.',
            'Read-only state emits aria-readonly and read-only data markers.',
            'The visual radio appearance is hidden from assistive technology.',
        ],
        'focus' => [
            'Radio inputs must show visible focus.',
            'Disabled radio inputs are not focusable.',
        ],
        'screen_reader' => [
            'hideLabel must only be used when the hidden label still provides a meaningful accessible name.',
            'Invalid and warning text should describe recovery or consequence.',
            'Decorator content must not create nested interactive content inside the label.',
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
        ],
        'classes' => [
            'feature-local radio wrapper classes',
            'feature-local validation classes',
            'feature-local helper text classes',
            'raw radio color utility clusters',
        ],
        'components' => [
            'ad hoc radio markup outside x-ui.radio-button',
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
            'resources/views/components/ui/radio-button/index.blade.php',
        ],
        'css' => [
            'resources/css/components/radio-button.css',
        ],
        'contract' => [
            'resources/views/components/ui/radio-button/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/radio-button.md',
        ],
    ],
]);

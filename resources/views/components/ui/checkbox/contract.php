<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/checkbox/contract.php
| Purpose: Checkbox Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Checkbox API that can be called from Blade,
| validated by tooling, and consumed by app layouts or Patterns.
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
        'slug' => 'checkbox',
        'label' => 'Checkbox',
        'component' => 'x-ui.checkbox',
        'summary' => 'Native checkbox form control with label, helper text, invalid, warning, read-only, disabled, required, indeterminate, hidden label, and decorator support.',
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
        'usage_context' => 'Use x-ui.checkbox for independent yes/no values and checkbox options. The native input remains the form submission source of truth.',

        'props' => [
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Checkbox ID. A generated ID is used when omitted.',
            ],
            [
                'name' => 'name',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Native checkbox name attribute.',
            ],
            [
                'name' => 'value',
                'type' => 'string|int|float|bool',
                'required' => false,
                'default' => 'on',
                'values' => [],
                'description' => 'Native checkbox value attribute.',
            ],
            [
                'name' => 'labelText',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Visible label text for the checkbox.',
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
                'description' => 'Checked state for the native checkbox.',
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
                'description' => 'Disables the native checkbox and applies disabled treatment.',
            ],
            [
                'name' => 'readOnly',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies read-only ARIA/data markers. Installed checkbox JavaScript must enforce read-only interaction behavior.',
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
                'name' => 'indeterminate',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Exposes mixed state through aria-checked and data attributes. Installed checkbox JavaScript must apply native indeterminate state.',
            ],
            [
                'name' => 'invalid',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies invalid state when the checkbox is not disabled.',
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
                'description' => 'Applies warning state when the checkbox is not disabled or invalid.',
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
                'name' => 'title',
                'type' => 'string|null',
                'required' => false,
                'default' => '',
                'values' => [],
                'description' => 'Optional title attribute for the label.',
            ],
            [
                'name' => 'decorator',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Decorator content rendered beside the label, outside the label element.',
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
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'checkbox',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-checkbox-wrapper',
                'required' => true,
                'description' => 'Generated wrapper marker.',
            ],
            [
                'name' => 'data-ui-checkbox-state',
                'required' => true,
                'description' => 'Generated resolved state marker: default, invalid, or warning.',
            ],
            [
                'name' => 'data-ui-checkbox',
                'required' => true,
                'description' => 'Generated native input marker.',
            ],
            [
                'name' => 'data-ui-checkbox-readonly',
                'required' => false,
                'description' => 'Generated native input marker when readOnly is true.',
            ],
            [
                'name' => 'data-ui-checkbox-indeterminate',
                'required' => false,
                'description' => 'Generated native input marker when indeterminate is true.',
            ],
            [
                'name' => 'data-invalid',
                'required' => false,
                'description' => 'Generated native input marker when invalid is true.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-checkbox-wrapper',
        'required' => [
            'ui-form-item',
            'ui-checkbox-wrapper',
            'ui-checkbox',
            'ui-checkbox-label',
            'ui-checkbox-label-text',
        ],
        'optional' => [
            'ui-checkbox-wrapper--readonly',
            'ui-checkbox-wrapper--invalid',
            'ui-checkbox-wrapper--warning',
            'ui-checkbox-wrapper--decorator',
            'ui-visually-hidden',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-form-requirement',
        ],
        'internal' => [
            'ui-checkbox-wrapper-inner--decorator',
            'ui-checkbox__validation-msg',
            'ui-checkbox__invalid-icon',
            'ui-checkbox__invalid-icon--warning',
        ],
        'deprecated' => [
            'feature-local checkbox wrapper classes',
            'feature-local validation classes',
            'ad hoc checkbox spacing classes',
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
            'description' => 'Standard checkbox layout.',
        ],
        'hidden-label' => [
            'label' => 'Hidden label',
            'api' => ['hideLabel' => true],
            'class' => 'ui-visually-hidden',
            'description' => 'Visually hidden checkbox label with accessible label preserved.',
        ],
        'decorator' => [
            'label' => 'Decorator',
            'api' => ['decorator' => '...'],
            'class' => 'ui-checkbox-wrapper--decorator',
            'description' => 'Checkbox with decorator content rendered beside the label.',
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
            'description' => 'Default unchecked checkbox state.',
        ],
        'checked' => [
            'label' => 'Checked',
            'required' => false,
            'description' => 'Checked checkbox state using native checked attribute.',
        ],
        'indeterminate' => [
            'label' => 'Indeterminate',
            'required' => false,
            'description' => 'Mixed checkbox state using aria-checked and installed JavaScript behavior.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Disabled checkbox state using native disabled attribute.',
        ],
        'read-only' => [
            'label' => 'Read-only',
            'required' => false,
            'description' => 'Read-only checkbox state using aria/data markers and installed JavaScript behavior.',
        ],
        'required' => [
            'label' => 'Required',
            'required' => false,
            'description' => 'Required checkbox state using native required attribute.',
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
            'ui-checkbox',
            'ui-checkbox-wrapper',
            'ui-form-item',
            'ui-form__helper-text',
            'ui-form-requirement',
        ],
        'component_tokens' => [
            'checkbox',
            'field',
            'form',
        ],
        'deprecated' => [
            'feature-local checkbox colors',
            'feature-local validation colors',
            'feature-local helper text spacing',
            'placeholder-only labels',
            'ad hoc checkbox markup outside x-ui.checkbox',
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
                'initCheckboxes',
            ],
        ],
        'blocks' => [
            'forms',
            'filters',
            'tables',
            'bulk-selection',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native checkbox keyboard behavior must remain intact.',
            'Space toggles enabled checkbox inputs.',
            'Read-only and indeterminate behavior must be enforced by installed checkbox JavaScript when used.',
        ],
        'aria' => [
            'Label uses for/id association.',
            'Helper, invalid, and warning messages are merged into aria-describedby.',
            'Invalid state emits aria-invalid.',
            'Read-only state emits aria-readonly and read-only data markers.',
            'Indeterminate state emits aria-checked="mixed" and indeterminate data markers.',
            'Invalid and warning icons are hidden from assistive technology.',
        ],
        'focus' => [
            'Checkbox inputs must show visible focus.',
            'Disabled checkboxes are not focusable.',
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
            [
                'name' => 'slug',
                'replacement' => 'decorator',
                'description' => 'slug remains accepted as a legacy alias for decorator.',
            ],
        ],
        'classes' => [
            'feature-local checkbox wrapper classes',
            'feature-local validation classes',
            'feature-local helper text classes',
            'raw checkbox color utility clusters',
        ],
        'components' => [
            'ad hoc checkbox markup outside x-ui.checkbox',
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
            'resources/views/components/ui/checkbox/index.blade.php',
        ],
        'css' => [
            'resources/css/components/checkbox.css',
        ],
        'js' => [
            'resources/js/ui-controls/checkboxes.js',
        ],
        'contract' => [
            'resources/views/components/ui/checkbox/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/checkbox.md',
        ],
    ],
]);

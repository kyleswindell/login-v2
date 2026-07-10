<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/select/contract.php
| Purpose: Select Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Select API that can be called from Blade,
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
        'slug' => 'select',
        'label' => 'Select',
        'component' => 'x-ui.select',
        'summary' => 'Native select form control with label, helper text, validation, warning, read-only, disabled, inline, light, size, decorator, item-array options, and slot options.',
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
        'usage_context' => 'Use x-ui.select for native single-value option selection where browser select behavior is appropriate.',

        'props' => [
            [
                'name' => 'items',
                'type' => 'array',
                'required' => false,
                'default' => [],
                'values' => [],
                'description' => 'Option array. Supports flat options and optgroup-style groups with options. Hidden items are skipped.',
            ],
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Select ID. A generated ID is used when omitted.',
            ],
            [
                'name' => 'name',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Native select name attribute.',
            ],
            [
                'name' => 'labelText',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => 'Select',
                'values' => [],
                'description' => 'Visible label text for the select.',
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
                'description' => 'Selected value. Takes precedence over defaultValue and item selected flags.',
            ],
            [
                'name' => 'defaultValue',
                'type' => 'string|int|float|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Compatibility fallback selected value used when value is not provided.',
                'compatibility' => true,
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Disables the native select and applies disabled visual treatment.',
            ],
            [
                'name' => 'readOnly',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies read-only visual and ARIA/data markers. Native select does not support a real readonly attribute.',
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
                'name' => 'noLabel',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Suppresses label rendering when another component owns the visible label.',
            ],
            [
                'name' => 'inline',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies inline select layout treatment.',
            ],
            [
                'name' => 'invalid',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies invalid state when the select is not disabled.',
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
                'description' => 'Applies warning state when the select is not disabled or invalid.',
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
                'description' => 'Applies light select treatment.',
            ],
            [
                'name' => 'size',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['xs', 'sm', 'md', 'lg'],
                'description' => 'Optional select size.',
            ],
            [
                'name' => 'decorator',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Inline field decorator rendered inside the select wrapper.',
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

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Optional slot-based option or optgroup markup rendered after item-array options.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'select',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-select-form-item',
                'required' => true,
                'description' => 'Generated form-item marker.',
            ],
            [
                'name' => 'data-ui-select-wrapper',
                'required' => true,
                'description' => 'Generated select wrapper marker.',
            ],
            [
                'name' => 'data-ui-select-state',
                'required' => true,
                'description' => 'Generated resolved state marker: default, invalid, or warning.',
            ],
            [
                'name' => 'data-ui-select-readonly',
                'required' => false,
                'description' => 'Generated wrapper marker when readOnly is true.',
            ],
            [
                'name' => 'data-ui-select-input-wrapper',
                'required' => true,
                'description' => 'Generated native select wrapper marker.',
            ],
            [
                'name' => 'data-ui-select-readonly-control',
                'required' => false,
                'description' => 'Generated native select marker when readOnly is true.',
            ],
            [
                'name' => 'data-ui-select-input',
                'required' => true,
                'description' => 'Generated native select marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-select',
        'required' => [
            'ui-form-item',
            'ui-select',
            'ui-select-input',
        ],
        'optional' => [
            'ui-select--inline',
            'ui-select--light',
            'ui-select--invalid',
            'ui-select--disabled',
            'ui-select--readonly',
            'ui-select--warning',
            'ui-select--decorator',
            'ui-select--xs',
            'ui-select--sm',
            'ui-select--md',
            'ui-select--lg',
            'ui-layout--size-xs',
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-label',
            'ui-visually-hidden',
            'ui-label--disabled',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-form-requirement',
        ],
        'internal' => [
            'ui-select-input__wrapper',
            'ui-select-optgroup',
            'ui-select__arrow',
            'ui-select__invalid-icon',
            'ui-select__invalid-icon--warning',
            'ui-select__inner-wrapper--decorator',
        ],
        'deprecated' => [
            'feature-local select wrapper classes',
            'feature-local validation classes',
            'ad hoc select spacing classes',
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
            'description' => 'Standard block native select layout.',
        ],
        'item-array-options' => [
            'label' => 'Item-array options',
            'api' => ['items' => []],
            'description' => 'Options rendered from the items prop.',
        ],
        'slot-options' => [
            'label' => 'Slot options',
            'api' => [],
            'description' => 'Options rendered from the default slot.',
        ],
        'grouped-options' => [
            'label' => 'Grouped options',
            'api' => ['items' => [['label' => 'Group', 'options' => []]]],
            'description' => 'Optgroup rendering through nested item options.',
        ],
        'inline' => [
            'label' => 'Inline',
            'api' => ['inline' => true],
            'class' => 'ui-select--inline',
            'description' => 'Inline label and select layout.',
        ],
        'light' => [
            'label' => 'Light',
            'api' => ['light' => true],
            'class' => 'ui-select--light',
            'description' => 'Light select treatment.',
        ],
        'hidden-label' => [
            'label' => 'Hidden label',
            'api' => ['hideLabel' => true],
            'class' => 'ui-visually-hidden',
            'description' => 'Visually hidden label with accessible label preserved.',
        ],
        'no-label' => [
            'label' => 'No label',
            'api' => ['noLabel' => true],
            'description' => 'Suppresses label rendering when another component owns labeling.',
        ],
        'decorator' => [
            'label' => 'Decorator',
            'api' => ['decorator' => '...'],
            'class' => 'ui-select--decorator',
            'description' => 'Select with inline field decorator.',
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
            'class' => 'ui-select--xs',
            'description' => 'Extra small select size.',
        ],
        'sm' => [
            'label' => 'Small',
            'api' => ['size' => 'sm'],
            'class' => 'ui-select--sm',
            'description' => 'Small select size.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'class' => 'ui-select--md',
            'description' => 'Medium select size.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => ['size' => 'lg'],
            'class' => 'ui-select--lg',
            'description' => 'Large select size.',
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
            'description' => 'Default enabled select state.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Disabled select state using native disabled attribute.',
        ],
        'read-only' => [
            'label' => 'Read-only',
            'required' => false,
            'description' => 'Read-only select state using aria-readonly and data markers.',
        ],
        'required' => [
            'label' => 'Required',
            'required' => false,
            'description' => 'Required select state using native required attribute.',
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
            'ui-select',
            'ui-select-input',
            'ui-form-item',
            'ui-form__helper-text',
            'ui-form-requirement',
        ],
        'component_tokens' => [
            'select',
            'field',
            'form',
        ],
        'deprecated' => [
            'feature-local select colors',
            'feature-local validation colors',
            'feature-local helper text spacing',
            'placeholder-only labels',
            'ad hoc select markup outside x-ui.select',
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
                'chevron--down',
                'warning--filled',
                'warning--alt',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'filters',
            'tables',
            'search',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native select keyboard behavior must remain intact.',
        ],
        'aria' => [
            'Label uses for/id association unless noLabel is true.',
            'Helper, invalid, and warning messages are merged into aria-describedby.',
            'Invalid state emits aria-invalid.',
            'Read-only state emits aria-readonly and read-only data markers.',
            'Chevron, invalid, and warning icons are hidden from assistive technology.',
        ],
        'focus' => [
            'Select controls must show visible focus.',
            'Disabled selects are not focusable.',
        ],
        'screen_reader' => [
            'hideLabel must only be used when the hidden label still provides a meaningful accessible name.',
            'noLabel must only be used when another component or wrapper provides a programmatic label.',
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
            'feature-local select wrapper classes',
            'feature-local validation classes',
            'feature-local helper text classes',
            'raw select color utility clusters',
        ],
        'components' => [
            'ad hoc select markup outside x-ui.select',
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
            'resources/views/components/ui/select/index.blade.php',
        ],
        'css' => [
            'resources/css/components/select.css',
        ],
        'contract' => [
            'resources/views/components/ui/select/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/select.md',
        ],
    ],
]);

<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/select-item-group/contract.php
| Purpose: Select Item Group Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Select Item Group API that can be called
| from Blade, validated by tooling, and consumed by native select compositions.
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
        'slug' => 'select-item-group',
        'label' => 'Select Item Group',
        'component' => 'x-ui.select-item-group',
        'summary' => 'Native optgroup child component for x-ui.select with label and disabled state support.',
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
        'usage_context' => 'Use x-ui.select-item-group to group x-ui.select-item options inside x-ui.select. Do not use it outside native select semantics.',

        'props' => [
            ['name' => 'label', 'type' => 'string', 'required' => true, 'default' => null, 'values' => [], 'description' => 'Native optgroup label.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native disabled optgroup state.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'Grouped native options, typically x-ui.select-item children.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'select-item-group', 'description' => 'Generated optgroup component marker.'],
            ['name' => 'data-ui-select-item-group', 'required' => true, 'description' => 'Generated select item group marker.'],
            ['name' => 'data-ui-select-optgroup', 'required' => true, 'description' => 'Generated native optgroup marker.'],
            ['name' => 'data-ui-select-optgroup-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-select-optgroup',
        'required' => [
            'ui-select-optgroup',
        ],
        'optional' => [],
        'internal' => [],
        'deprecated' => [
            'raw optgroup markup where standardized UI select option-group hooks are required',
            'feature-local select optgroup classes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => ['label' => 'Group'], 'class' => 'ui-select-optgroup', 'description' => 'Default native option group.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['label' => 'Group', 'disabled' => true], 'description' => 'Disabled native option group.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default option group state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled option group state.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-select',
        ],
        'component_tokens' => [
            'select-item-group',
            'optgroup',
            'native-select',
        ],
        'deprecated' => [
            'feature-local optgroup classes',
            'raw optgroup elements where UI select hooks are required',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'forms',
            'select',
            'select-item',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'ui.select-item',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'select',
            'native-select-option-groups',
            'forms',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native optgroup keyboard behavior is owned by the browser and parent select element.',
        ],
        'aria' => [
            'Native option group semantics are provided by the optgroup element and label attribute.',
            'Do not add custom roles to native optgroup elements.',
        ],
        'focus' => [
            'Focus behavior is owned by the parent native select element.',
        ],
        'screen_reader' => [
            'Group label should describe the grouped choices clearly.',
            'Disabled groups should not contain choices required to complete the form.',
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
            'feature-local select optgroup classes',
            'raw optgroup utility clusters where x-ui.select-item-group should be used',
        ],
        'components' => [],
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
            'resources/views/components/ui/select-item-group/index.blade.php',
        ],
        'css' => [
            'resources/css/components/select.css',
        ],
        'contract' => [
            'resources/views/components/ui/select-item-group/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/select.md',
        ],
    ],
]);

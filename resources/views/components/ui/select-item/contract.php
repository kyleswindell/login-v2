<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/select-item/contract.php
| Purpose: Select Item Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Select Item API that can be called from
| Blade, validated by tooling, and consumed by native select compositions.
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
        'slug' => 'select-item',
        'label' => 'Select Item',
        'component' => 'x-ui.select-item',
        'summary' => 'Native option child component for x-ui.select with value, text, disabled, hidden, and selected state support.',
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
        'usage_context' => 'Use x-ui.select-item as a native option child inside x-ui.select or x-ui.select-item-group. Do not use it outside native select semantics.',

        'props' => [
            ['name' => 'value', 'type' => 'string|int|float|null', 'required' => false, 'default' => '', 'values' => [], 'description' => 'Native option value.'],
            ['name' => 'text', 'type' => 'string', 'required' => false, 'default' => '', 'values' => [], 'description' => 'Plain option label text. If omitted, plain text is derived from the default slot.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native disabled option state.'],
            ['name' => 'hidden', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native hidden option state.'],
            ['name' => 'selected', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native selected option state. Prefer controlling selection from x-ui.select value where possible.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Fallback plain text option label when text is omitted. Markup is stripped before rendering.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'select-item', 'description' => 'Generated option component marker.'],
            ['name' => 'data-ui-select-item', 'required' => true, 'description' => 'Generated select item marker.'],
            ['name' => 'data-ui-select-option', 'required' => true, 'description' => 'Generated native option marker.'],
            ['name' => 'data-ui-select-option-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-select-option-hidden', 'required' => true, 'description' => 'Generated hidden state marker.'],
            ['name' => 'data-ui-select-option-selected', 'required' => true, 'description' => 'Generated selected state marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-select-option',
        'required' => [
            'ui-select-option',
        ],
        'optional' => [],
        'internal' => [],
        'deprecated' => [
            'raw option markup where standardized UI select option hooks are required',
            'feature-local select option classes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-select-option', 'description' => 'Default native option.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'description' => 'Disabled native option.'],
        'hidden' => ['label' => 'Hidden', 'api' => ['hidden' => true], 'description' => 'Hidden native option.'],
        'selected' => ['label' => 'Selected', 'api' => ['selected' => true], 'description' => 'Selected native option.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default option state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled option state.'],
        'hidden' => ['label' => 'Hidden', 'required' => false, 'description' => 'Hidden option state.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selected option state.'],
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
            'select-item',
            'option',
            'native-select',
        ],
        'deprecated' => [
            'feature-local option classes',
            'raw option elements where UI select hooks are required',
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
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'select',
            'native-select-options',
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
            'Native option keyboard behavior is owned by the browser and parent select element.',
        ],
        'aria' => [
            'Native option semantics are provided by the option element.',
            'Do not add custom roles to native option elements.',
        ],
        'focus' => [
            'Focus behavior is owned by the parent native select element.',
        ],
        'screen_reader' => [
            'Option text should be concise and unique enough to distinguish choices.',
            'Hidden options should not be used for meaningful available choices.',
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
            'feature-local select option classes',
            'raw option utility clusters where x-ui.select-item should be used',
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
            'resources/views/components/ui/select-item/index.blade.php',
        ],
        'css' => [
            'resources/css/components/select.css',
        ],
        'contract' => [
            'resources/views/components/ui/select-item/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/select.md',
        ],
    ],
]);

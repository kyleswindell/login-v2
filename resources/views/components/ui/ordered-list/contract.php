<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/ordered-list/contract.php
| Purpose: Ordered List Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Ordered List API that can be called from
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
        'slug' => 'ordered-list',
        'label' => 'Ordered List',
        'component' => 'x-ui.ordered-list',
        'summary' => 'Ordered list primitive that renders an ol element with custom, native, nested, and expressive list styling options.',
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
        'usage_context' => 'Use x-ui.ordered-list for ordered semantic lists. Use x-ui.list-item for standardized child li elements.',

        'props' => [
            ['name' => 'nested', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies nested list styling.'],
            ['name' => 'native', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Uses native ordered list styling instead of custom ordered list styling.'],
            ['name' => 'isExpressive', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Carbon-compatible expressive styling prop.'],
            ['name' => 'expressive', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Preferred expressive styling prop. Takes precedence over isExpressive when supplied.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'Ordered list items, typically x-ui.list-item children.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'ordered-list', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-list', 'required' => true, 'value' => 'ordered', 'description' => 'Generated list type marker.'],
            ['name' => 'data-ui-list-ordered', 'required' => true, 'description' => 'Generated ordered list marker.'],
            ['name' => 'data-ui-list-native', 'required' => true, 'description' => 'Generated native state marker.'],
            ['name' => 'data-ui-list-nested', 'required' => true, 'description' => 'Generated nested state marker.'],
            ['name' => 'data-ui-list-expressive', 'required' => true, 'description' => 'Generated expressive state marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-list--ordered',
        'required' => [],
        'optional' => [
            'ui-list--ordered',
            'ui-list--ordered--native',
            'ui-list--nested',
            'ui-list--expressive',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local ordered list utility stacks',
            'raw ol markup where standardized UI list spacing is required',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-list--ordered', 'description' => 'Default custom ordered list.'],
        'native' => ['label' => 'Native', 'api' => ['native' => true], 'class' => 'ui-list--ordered--native', 'description' => 'Native browser ordered list styling.'],
        'nested' => ['label' => 'Nested', 'api' => ['nested' => true], 'class' => 'ui-list--nested', 'description' => 'Nested ordered list styling.'],
        'expressive' => ['label' => 'Expressive', 'api' => ['expressive' => true], 'class' => 'ui-list--expressive', 'description' => 'Expressive ordered list styling.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default ordered list state.'],
        'native' => ['label' => 'Native', 'required' => false, 'description' => 'Native list styling state.'],
        'nested' => ['label' => 'Nested', 'required' => false, 'description' => 'Nested list styling state.'],
        'expressive' => ['label' => 'Expressive', 'required' => false, 'description' => 'Expressive list styling state.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-list',
        ],
        'component_tokens' => [
            'ordered-list',
            'list',
            'typographic-list',
        ],
        'deprecated' => [
            'feature-local ordered list spacing',
            'raw ol class stacks',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'spacing',
            'typography',
            'list-item',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'ui.list-item',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'content-lists',
            'documentation',
            'instructions',
            'ordered-steps',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Ordered list itself is not keyboard interactive.',
        ],
        'aria' => [
            'Ordered list semantics come from the native ol element.',
            'Do not add list roles unless replacing native semantics outside this component.',
        ],
        'focus' => [
            'Ordered list does not receive focus unless its slot contains interactive content.',
        ],
        'screen_reader' => [
            'Use ordered lists only when item order matters.',
            'Use x-ui.list-item or semantic li children inside the ordered list.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'isExpressive', 'replacement' => 'expressive', 'description' => 'isExpressive remains accepted as a Carbon-compatible alias.'],
        ],
        'classes' => [
            'feature-local ordered list classes',
            'raw ol utility clusters where ui-list classes are required',
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
            'resources/views/components/ui/ordered-list/index.blade.php',
        ],
        'css' => [
            'resources/css/components/list.css',
        ],
        'contract' => [
            'resources/views/components/ui/ordered-list/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/list.md',
        ],
    ],
]);

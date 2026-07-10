<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/unordered-list/contract.php
| Purpose: Unordered List Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Unordered List API that can be called from
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
        'slug' => 'unordered-list',
        'label' => 'Unordered List',
        'component' => 'x-ui.unordered-list',
        'summary' => 'Unordered list primitive that renders a ul element with default, nested, and expressive list styling options.',
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
        'usage_context' => 'Use x-ui.unordered-list for unordered semantic lists. Use x-ui.list-item for standardized child li elements.',

        'props' => [
            ['name' => 'nested', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies nested list styling.'],
            ['name' => 'isExpressive', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Carbon-compatible expressive styling prop.'],
            ['name' => 'expressive', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Preferred expressive styling prop. Takes precedence over isExpressive when supplied.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'Unordered list items, typically x-ui.list-item children.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'unordered-list', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-list', 'required' => true, 'value' => 'unordered', 'description' => 'Generated list type marker.'],
            ['name' => 'data-ui-list-unordered', 'required' => true, 'description' => 'Generated unordered list marker.'],
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
        'root' => 'ui-list--unordered',
        'required' => [
            'ui-list--unordered',
        ],
        'optional' => [
            'ui-list--nested',
            'ui-list--expressive',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local unordered list utility stacks',
            'raw ul markup where standardized UI list spacing is required',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-list--unordered', 'description' => 'Default unordered list.'],
        'nested' => ['label' => 'Nested', 'api' => ['nested' => true], 'class' => 'ui-list--nested', 'description' => 'Nested unordered list styling.'],
        'expressive' => ['label' => 'Expressive', 'api' => ['expressive' => true], 'class' => 'ui-list--expressive', 'description' => 'Expressive unordered list styling.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default unordered list state.'],
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
            'unordered-list',
            'list',
            'typographic-list',
        ],
        'deprecated' => [
            'feature-local unordered list spacing',
            'raw ul class stacks',
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
            'settings-copy',
            'help-content',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Unordered list itself is not keyboard interactive.',
        ],
        'aria' => [
            'Unordered list semantics come from the native ul element.',
            'Do not add list roles unless replacing native semantics outside this component.',
        ],
        'focus' => [
            'Unordered list does not receive focus unless its slot contains interactive content.',
        ],
        'screen_reader' => [
            'Use unordered lists when item order does not change meaning.',
            'Use x-ui.list-item or semantic li children inside the unordered list.',
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
            'feature-local unordered list classes',
            'raw ul utility clusters where ui-list classes are required',
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
            'resources/views/components/ui/unordered-list/index.blade.php',
        ],
        'css' => [
            'resources/css/components/list.css',
        ],
        'contract' => [
            'resources/views/components/ui/unordered-list/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/list.md',
        ],
    ],
]);

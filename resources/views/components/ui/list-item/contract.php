<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/list-item/contract.php
| Purpose: List Item Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public List Item API that can be called from
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
        'slug' => 'list-item',
        'label' => 'List Item',
        'component' => 'x-ui.list-item',
        'summary' => 'Minimal list item primitive that renders an li element with the canonical UI list item class.',
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
        'usage_context' => 'Use x-ui.list-item for standardized list item markup inside caller-owned ordered or unordered lists. Do not use it as a standalone component outside ol or ul semantics.',

        'props' => [],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'List item content.'],
        ],

        'events' => [],

        'data_attributes' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-list__item',
        'required' => [
            'ui-list__item',
        ],
        'optional' => [],
        'internal' => [],
        'deprecated' => [
            'feature-local li utility class stacks',
            'raw list item markup where standardized UI list item spacing is required',
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
            'class' => 'ui-list__item',
            'description' => 'Default list item.',
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
            'description' => 'Default list item state.',
        ],
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
            'list-item',
            'list',
            'typographic-list',
        ],
        'deprecated' => [
            'feature-local list item spacing',
            'raw li class stacks',
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
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
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
            'List item itself is not keyboard interactive.',
        ],
        'aria' => [
            'List item semantics come from the native li element and its parent ol or ul.',
            'Do not add listitem role manually unless replacing native semantics outside this component.',
        ],
        'focus' => [
            'List item does not receive focus unless its slot contains interactive content.',
        ],
        'screen_reader' => [
            'Use inside a semantic ol or ul owned by the caller.',
            'Avoid placing orphan li elements outside list containers.',
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
            'feature-local list item classes',
            'raw li utility clusters where ui-list__item is required',
        ],
        'components' => [
            'invented x-ui.list wrapper without an installed Blade component',
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
            'resources/views/components/ui/list-item/index.blade.php',
        ],
        'css' => [
            'resources/css/components/list.css',
        ],
        'contract' => [
            'resources/views/components/ui/list-item/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/list-item.md',
        ],
    ],
]);

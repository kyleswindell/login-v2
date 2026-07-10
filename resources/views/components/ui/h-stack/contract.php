<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/h-stack/contract.php
| Purpose: Horizontal Stack Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Horizontal Stack API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
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
        'slug' => 'h-stack',
        'label' => 'Horizontal Stack',
        'component' => 'x-ui.h-stack',
        'summary' => 'Horizontal stack layout convenience wrapper around x-ui.stack with orientation fixed to horizontal.',
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
        'usage_context' => 'Use x-ui.h-stack as a convenience alias for x-ui.stack orientation="horizontal". Use x-ui.stack directly when orientation should be dynamic.',

        'props' => [
            ['name' => 'as', 'type' => 'string', 'required' => false, 'default' => 'div', 'values' => [], 'description' => 'HTML element rendered by the underlying stack component.'],
            ['name' => 'gap', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Gap token/value forwarded to x-ui.stack.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'Stacked child content.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'h-stack', 'description' => 'Generated component marker passed through to x-ui.stack.'],
            ['name' => 'data-ui-h-stack', 'required' => true, 'description' => 'Generated horizontal stack marker passed through to x-ui.stack.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-stack',
        'required' => [],
        'optional' => [
            'ui-stack',
            'ui-stack--horizontal',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local horizontal flex utility wrappers',
            'ad hoc horizontal stack class clusters',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'horizontal' => [
            'label' => 'Horizontal',
            'api' => [],
            'class' => 'ui-stack--horizontal',
            'description' => 'Horizontal stack orientation inherited from x-ui.stack.',
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
            'description' => 'Default horizontal stack state.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-stack',
        ],
        'component_tokens' => [
            'h-stack',
            'stack',
            'layout',
        ],
        'deprecated' => [
            'feature-local horizontal flex wrappers',
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
            'layout',
            'stack',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'ui.stack',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'layouts',
            'actions',
            'toolbar-content',
            'horizontal-groups',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Horizontal stack itself is not keyboard interactive.',
        ],
        'aria' => [
            'Semantic role and labelling are owned by caller or the selected as element.',
        ],
        'focus' => [
            'Stack does not receive focus unless caller attributes or slotted content introduce focus.',
        ],
        'screen_reader' => [
            'Choose an appropriate as element when the stack represents semantic structure.',
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
            'feature-local horizontal stack classes',
            'raw flex-row utility clusters where x-ui.h-stack should be used',
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
            'resources/views/components/ui/h-stack/index.blade.php',
        ],
        'css' => [
            'resources/css/components/stack.css',
        ],
        'contract' => [
            'resources/views/components/ui/h-stack/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/stack.md',
        ],
    ],
]);

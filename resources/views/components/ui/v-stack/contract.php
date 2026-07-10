<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/v-stack/contract.php
| Purpose: Vertical Stack Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Vertical Stack API that can be called from
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
        'slug' => 'v-stack',
        'label' => 'Vertical Stack',
        'component' => 'x-ui.v-stack',
        'summary' => 'Vertical stack layout convenience wrapper around x-ui.stack with orientation fixed to vertical.',
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
        'usage_context' => 'Use x-ui.v-stack as a convenience alias for x-ui.stack orientation="vertical". Use x-ui.stack directly when orientation should be dynamic.',

        'props' => [
            ['name' => 'as', 'type' => 'string', 'required' => false, 'default' => 'div', 'values' => [], 'description' => 'HTML element rendered by the underlying stack component.'],
            ['name' => 'gap', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Gap token/value forwarded to x-ui.stack.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'Stacked child content.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'v-stack', 'description' => 'Generated component marker passed through to x-ui.stack.'],
            ['name' => 'data-ui-v-stack', 'required' => true, 'description' => 'Generated vertical stack marker passed through to x-ui.stack.'],
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
            'ui-stack--vertical',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local vertical flex utility wrappers',
            'ad hoc vertical stack class clusters',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'vertical' => [
            'label' => 'Vertical',
            'api' => [],
            'class' => 'ui-stack--vertical',
            'description' => 'Vertical stack orientation inherited from x-ui.stack.',
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
            'description' => 'Default vertical stack state.',
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
            'v-stack',
            'stack',
            'layout',
        ],
        'deprecated' => [
            'feature-local vertical flex wrappers',
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
            'forms',
            'content-groups',
            'vertical-groups',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Vertical stack itself is not keyboard interactive.',
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
            'feature-local vertical stack classes',
            'raw flex-col utility clusters where x-ui.v-stack should be used',
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
            'resources/views/components/ui/v-stack/index.blade.php',
        ],
        'css' => [
            'resources/css/components/stack.css',
        ],
        'contract' => [
            'resources/views/components/ui/v-stack/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/stack.md',
        ],
    ],
]);

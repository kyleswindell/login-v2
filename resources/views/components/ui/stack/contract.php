<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/stack/contract.php
| Purpose: Stack Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Stack API that can be called from Blade,
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
        'slug' => 'stack',
        'label' => 'Stack',
        'component' => 'x-ui.stack',
        'summary' => 'Layout utility for vertical or horizontal stacking with configurable semantic element and scale or custom gap spacing.',
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
        'usage_context' => 'Use x-ui.stack for simple vertical or horizontal layout grouping. Use x-ui.v-stack and x-ui.h-stack when orientation should be fixed by the component name.',

        'props' => [
            [
                'name' => 'as',
                'type' => 'string',
                'required' => false,
                'default' => 'div',
                'values' => ['div', 'span', 'section', 'article', 'aside', 'header', 'footer', 'main', 'nav', 'form', 'fieldset', 'ul', 'ol', 'li', 'dl', 'dt', 'dd'],
                'description' => 'HTML element rendered as the stack container. Unsupported values fall back to div.',
            ],
            [
                'name' => 'gap',
                'type' => 'int|string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Gap spacing. Integer values render ui-stack-scale-* classes; string values render --ui-stack-gap custom style.',
            ],
            [
                'name' => 'orientation',
                'type' => 'string',
                'required' => false,
                'default' => 'vertical',
                'values' => ['horizontal', 'vertical'],
                'description' => 'Stack orientation.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => true,
                'description' => 'Stacked child content.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'stack', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-stack', 'required' => true, 'description' => 'Generated stack marker.'],
            ['name' => 'data-ui-stack-as', 'required' => true, 'description' => 'Generated resolved element marker.'],
            ['name' => 'data-ui-stack-orientation', 'required' => true, 'description' => 'Generated orientation marker.'],
            ['name' => 'data-ui-stack-gap-type', 'required' => true, 'description' => 'Generated gap type marker: none, scale, or custom.'],
            ['name' => 'data-ui-stack-gap', 'required' => false, 'description' => 'Generated original gap value marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-stack',
        'required' => [
            'ui-stack',
        ],
        'optional' => [
            'ui-stack--vertical',
            'ui-stack--horizontal',
            'ui-stack-vertical',
            'ui-stack-horizontal',
            'ui-stack-scale-0',
            'ui-stack-scale-1',
            'ui-stack-scale-2',
            'ui-stack-scale-3',
            'ui-stack-scale-4',
            'ui-stack-scale-5',
            'ui-stack-scale-6',
            'ui-stack-scale-7',
            'ui-stack-scale-8',
            'ui-stack-scale-9',
            'ui-stack-scale-10',
            'ui-stack-scale-11',
            'ui-stack-scale-12',
            'ui-stack-scale-13',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local flex stack wrappers',
            'raw flex-col utility clusters where x-ui.stack should be used',
            'raw flex-row utility clusters where x-ui.stack should be used',
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
            'api' => ['orientation' => 'vertical'],
            'class' => 'ui-stack--vertical',
            'description' => 'Vertical stack orientation.',
        ],
        'horizontal' => [
            'label' => 'Horizontal',
            'api' => ['orientation' => 'horizontal'],
            'class' => 'ui-stack--horizontal',
            'description' => 'Horizontal stack orientation.',
        ],
        'scale-gap' => [
            'label' => 'Scale gap',
            'api' => ['gap' => 4],
            'class' => 'ui-stack-scale-4',
            'description' => 'Stack using numeric spacing-scale gap class.',
        ],
        'custom-gap' => [
            'label' => 'Custom gap',
            'api' => ['gap' => '1.25rem'],
            'description' => 'Stack using custom CSS gap value through --ui-stack-gap.',
        ],
        'custom-element' => [
            'label' => 'Custom element',
            'api' => ['as' => 'section'],
            'description' => 'Stack rendered as a caller-selected semantic element.',
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
        'vertical' => [
            'label' => 'Vertical',
            'required' => true,
            'description' => 'Vertical orientation state.',
        ],
        'horizontal' => [
            'label' => 'Horizontal',
            'required' => false,
            'description' => 'Horizontal orientation state.',
        ],
        'scale-gap' => [
            'label' => 'Scale gap',
            'required' => false,
            'description' => 'Numeric scale gap state.',
        ],
        'custom-gap' => [
            'label' => 'Custom gap',
            'required' => false,
            'description' => 'Custom CSS gap state.',
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
            'stack',
            'layout',
            'spacing',
        ],
        'deprecated' => [
            'feature-local stack wrappers',
            'raw flex utility clusters for standard stack layouts',
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
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'layouts',
            'forms',
            'content-groups',
            'action-groups',
            'vertical-groups',
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
            'Stack itself is not keyboard interactive.',
        ],
        'aria' => [
            'Semantic role and labelling are owned by caller or the selected as element.',
            'Do not use stack to replace semantic list, nav, form, or region markup when those semantics are required.',
        ],
        'focus' => [
            'Stack does not receive focus unless caller attributes or slotted content introduce focus.',
        ],
        'screen_reader' => [
            'Choose an appropriate as element when the stack represents semantic structure.',
            'Visual grouping alone should not be the only way related content is communicated when semantics matter.',
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
            'feature-local stack classes',
            'raw flex-col utility clusters where x-ui.stack should be used',
            'raw flex-row utility clusters where x-ui.stack should be used',
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
            'resources/views/components/ui/stack/index.blade.php',
        ],
        'css' => [
            'resources/css/components/stack.css',
        ],
        'contract' => [
            'resources/views/components/ui/stack/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/stack.md',
        ],
    ],
]);

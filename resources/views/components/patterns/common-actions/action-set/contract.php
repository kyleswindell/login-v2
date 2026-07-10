<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/common-actions/action-set/contract.php
| Purpose: Action Set Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Action Set Pattern API that can be called
| from Blade, validated by tooling, and consumed by rendered evidence examples.
|
*/

return Surface::pattern([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'slug' => 'common-actions-action-set',
        'label' => 'Action Set',
        'component' => 'x-patterns.common-actions.action-set',
        'summary' => 'Semantic grouping pattern for related common action controls.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    'lifecycle' => [
        'status' => 'approved',
        'system_maturity' => 'standards-wireframe',
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Blade API
    |--------------------------------------------------------------------------
    */

    'api' => [
        'usage_context' => 'Use Action Set when two or more related actions appear in the same local decision area.',

        'props' => [
            [
                'name' => 'label',
                'type' => 'string',
                'required' => false,
                'default' => 'Actions',
                'values' => [],
                'description' => 'Accessible label for the grouped actions when labelledBy is not provided.',
            ],
            [
                'name' => 'labelledBy',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'ID of visible text that labels the action group. In Blade, pass as labelled-by.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => true,
                'description' => 'Approved interactive action primitives such as buttons, links, or existing accessible icon-action controls.',
            ],
        ],

        'data_attributes' => [
            [
                'name' => 'data-pattern',
                'required' => true,
                'value' => 'common-actions.action-set',
                'description' => 'Pattern marker for rendered evidence proof and tests.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies And Ownership Boundary
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'uses' => [
            'icons' => [],
            'components' => [
                'x-ui.button',
                'x-ui.link',
            ],
            'js_initializers' => [],
        ],
    ],

    'accessibility' => [
        'aria' => [
            'The root must render role="group".',
            'The group must be labelled by aria-labelledby when visible label text is supplied.',
            'The group must fall back to aria-label when no visible label reference is supplied.',
            'The pattern must not emit aria-orientation because it does not own layout or directional keyboard behavior.',
        ],
        'keyboard' => [
            'Keyboard behavior belongs to the child action primitives.',
            'Action Set must not add custom keyboard handling.',
        ],
        'focus' => [
            'Focus order is the document order of slotted action primitives.',
        ],
    ],

    'ownership' => [
        'owns' => [
            'semantic grouping of related actions',
            'accessible group labelling',
            'pattern identification for tests and rendered evidence proof',
        ],
        'does_not_own' => [
            'button styling',
            'button variants',
            'spacing',
            'layout',
            'icons as standalone actions',
            'authorization',
            'persistence',
            'loading behavior',
            'feedback rendering',
        ],
    ],

    'source' => [
        'blade' => [
            'resources/views/components/patterns/common-actions/action-set/index.blade.php',
        ],
        'contract' => [
            'resources/views/components/patterns/common-actions/action-set/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/patterns/common-actions/action-set.md',
        ],
    ],
]);

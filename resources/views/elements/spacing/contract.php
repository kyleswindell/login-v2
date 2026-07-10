<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/elements/spacing/contract.php
| Purpose: Spacing Foundation Element public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Spacing API: spacing scale, utility
| families, internal/external ownership boundaries, and prohibited local
| spacing behavior.
|
*/

return Surface::element([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'slug' => 'spacing',
        'label' => 'Spacing',
        'summary' => 'Component internal spacing and parent-owned layout spacing.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    'lifecycle' => [
        'status' => 'approved',
    ],

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */

    'api' => [
        'usage_context' => 'Use token-backed spacing utilities for layout gaps, margins, and component internals.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'optional' => [
            'ui-stack',
            'ui-h-stack',
            'ui-v-stack',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tokens
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'css_variables' => [
            '$spacing-01',
            '$spacing-02',
            '$spacing-03',
            '$spacing-04',
            '$spacing-05',
            '$spacing-06',
            '$spacing-07',
            '$spacing-08',
            '$spacing-09',
            '$spacing-10',
            '$spacing-11',
            '$spacing-12',
            '$spacing-13',
            '--ui-dashboard-grid-row-size',
            '--ui-dashboard-grid-gap',
        ],
        'utility_classes' => [
            'gap-*',
            'space-x-*',
            'space-y-*',
            'p-*',
            'px-*',
            'py-*',
            'pt-*',
            'pr-*',
            'pb-*',
            'pl-*',
            'm-*',
            'mx-*',
            'my-*',
            'mt-*',
            'mr-*',
            'mb-*',
            'ml-*',
            'responsive spacing variants using approved scale values',
        ],
        'class_families' => [
            'ui-stack',
            'ui-h-stack',
            'ui-v-stack',
        ],
        'deprecated' => [
            'arbitrary pixel spacing',
            'feature-local spacing variables',
            'component-owned external margins',
            'negative margins for normal alignment',
            'Bootstrap gutter substitutes for approved app spacing',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'blocks' => [
            '2x-grid',
            'button',
            'text-input',
            'tile',
            'forms',
            'layout',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Responsive spacing changes must not reorder relationships or separate labels from their controls.',
        ],
        'focus' => [
            'Spacing must leave room for focus indicators and validation text.',
            'Focus-visible rings, outlines, and inset focus treatments must not create layout shift.',
        ],
        'screen_reader' => [
            'Labels, helper text, warning text, and error text must stay visually associated with the related field or control.',
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
        'css' => [
            'resources/css/tokens/spacing.css',
        ],
        'tokens' => [
            'resources/css/tokens/spacing.css',
        ],
        'contract' => [
            'resources/views/elements/spacing/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/elements/spacing.md',
        ],
    ],
]);

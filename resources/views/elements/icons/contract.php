<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/elements/icons/contract.php
| Purpose: Icons Foundation Element public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public icon API: registry-backed icon names,
| currentColor behavior, sizing ownership, and deprecated icon surfaces.
|
*/

return Surface::element([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'slug' => 'icons',
        'label' => 'Icons',
        'component' => 'x-ui.icon',
        'summary' => 'Manifest-backed UI icon usage for actions, navigation, statuses, and affordances.',
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
        'usage_context' => 'Use x-ui.icon with exact internal manifest names and currentColor sizing/color rules.',
        'props' => [
            [
                'name' => 'name',
                'type' => 'string',
                'required' => true,
                'default' => null,
                'values' => [],
                'description' => 'Exact internal icon name from the approved icon registry/manifest.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tokens
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'css_variables' => [
            '--ui-icon-primary',
            '--ui-icon-secondary',
            '--ui-icon-disabled',
            '--ui-icon-inverse',
            '--ui-icon-interactive',
            '--ui-icon-on-color',
        ],
        'deprecated' => [
            'x-icons.* consumer usage',
            'icons.* aliases',
            'hyphen-to-double-hyphen translation shims',
            'inline SVG copies when an internal icon exists',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'color',
        ],
        'uses' => [
            'icons' => [
                'internal-icon-manifest',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'button',
            'menu',
            'notification',
            'tag',
            'status',
            'navigation',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'aria' => [
            'Decorative icons must be aria-hidden.',
            'Meaningful icon-only controls need an accessible label supplied by the owning component.',
        ],
        'focus' => [
            'Interactive icon controls need sufficient hit target and focus treatment from the owning component.',
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
            'resources/views/components/ui/icon/index.blade.php',
            'resources/views/components/icons/**',
        ],
        'contract' => [
            'resources/views/elements/icons/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/elements/icons.md',
        ],
    ],
]);

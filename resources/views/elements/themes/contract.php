<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/elements/themes/contract.php
| Purpose: Themes Foundation Element public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Themes API: supported theme contexts,
| role-key consistency, color-scheme behavior, and prevention of component-
| local theme patches.
|
*/

return Surface::element([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'slug' => 'themes',
        'label' => 'Themes',
        'summary' => 'Theme contexts that resolve shared role tokens across supported light, gray, dark, and forced-color surfaces.',
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
        'usage_context' => 'Use approved theme context attributes and role tokens; do not patch component theme values locally.',
        'data_attributes' => [
            [
                'name' => 'data-theme-resolved',
                'required' => false,
                'values' => [
                    'white',
                    'gray-10',
                    'gray-90',
                    'gray-100',
                ],
                'description' => 'Applies an approved theme context to a contained reference or app surface.',
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
            '--ui-color-scheme',
            'all Color-owned role tokens resolved by theme files',
        ],
        'deprecated' => [
            'component-local theme patches',
            'raw light-only values in consumers',
            'raw dark-only values in consumers',
            'theme overrides that redefine component semantics instead of token values',
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
        'blocks' => [
            'button',
            'text-input',
            'notification',
            'tag',
            'data-table',
            'forms',
            'ui-shell',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'focus' => [
            'Focus roles must remain visible in every supported theme context.',
        ],
        'screen_reader' => [
            'Theme changes must not remove non-color cues for status, validation, selection, or disabled states.',
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
            'resources/css/tokens/themes/index.css',
        ],
        'tokens' => [
            'resources/css/tokens/themes/index.css',
            'resources/css/tokens/themes/**',
        ],
        'contract' => [
            'resources/views/elements/themes/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/elements/themes.md',
        ],
    ],
]);

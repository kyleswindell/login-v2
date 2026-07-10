<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/elements/pictograms/contract.php
| Purpose: Pictograms Foundation Element public API contract.
|--------------------------------------------------------------------------
|
| This contract guards the deferred Pictograms API until an approved asset
| source, naming model, sizing model, and accessibility contract exist.
|
*/

return Surface::element([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'slug' => 'pictograms',
        'label' => 'Pictograms',
        'summary' => 'Deferred pictogram and illustrative asset treatment for empty states, onboarding, and help surfaces.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    'lifecycle' => [
        'status' => 'planned',
        'allowed_in_app_layouts' => false,
        'allowed_in_patterns' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */

    'api' => [
        'usage_level' => 'internal',
        'usage_context' => 'No public pictogram API is approved until an asset source and accessibility model are selected.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tokens
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'deprecated' => [
            'unapproved pictogram imports',
            'unapproved pictogram wrappers',
            'third-party pictogram assets without standards approval',
            'pictograms used as substitute icons',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'blocked_by' => [
            'approved pictogram asset source',
            'pictogram naming model',
            'pictogram sizing model',
            'pictogram accessibility contract',
        ],
        'blocks' => [
            'empty-state',
            'onboarding',
            'help',
            'illustrative-content',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'aria' => [
            'Future pictogram API must define decorative versus meaningful image semantics.',
        ],
        'screen_reader' => [
            'Future pictogram API must define when alternate text is required and when imagery is decorative.',
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
        'contract' => [
            'resources/views/elements/pictograms/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/elements/pictograms.md',
        ],
    ],
]);

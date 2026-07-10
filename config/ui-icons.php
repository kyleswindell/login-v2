<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: config/ui-icons.php
| Purpose: UI icon runtime configuration.
|--------------------------------------------------------------------------
|
| The icon manifest is generated from the trusted local Carbon SVG source
| folder. The component renders exact canonical icon names from the manifest.
|
*/

return [
    'default_set' => 'carbon',

    'fallback' => 'empty',

    'log_missing' => env('UI_ICONS_LOG_MISSING', true),

    'sets' => [
        'carbon' => [
            'path' => resource_path('views/components/icons/src/svg'),
            'manifest' => resource_path('views/components/icons/src/svg/manifest.php'),
        ],
    ],

    'sizes' => [
        'xs' => 12,
        'sm' => 16,
        'md' => 16,
        'lg' => 20,
        'xl' => 24,
        '2xl' => 32,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default source selection priority
    |--------------------------------------------------------------------------
    |
    | This is used only by the manifest generator. Runtime icon rendering does
    | not search through source folders.
    |
    */

    'default_source_priority' => [
        '16',
        '20',
        '24',
        '32',
        'root',
        '32/Q',
        '32/watson-health',
    ],
];

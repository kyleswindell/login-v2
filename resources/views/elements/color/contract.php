<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/elements/color/contract.php
| Purpose: Color Foundation Element public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Color API: semantic role tokens, approved
| utility/class families, component token ownership boundaries, and consumer
| constraints.
|
*/

return Surface::element([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'slug' => 'color',
        'label' => 'Color',
        'summary' => 'Semantic color tokens for text, icons, borders, surfaces, actions, statuses, and shadows.',
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
        'usage_context' => 'Use role-based color tokens, approved classes, and component props instead of raw values.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'optional' => [
            'ui-card',
            'ui-card-title',
            'ui-card-copy',
            'ui-kicker',
            'ui-link',
            'ui-platform-subtle-surface',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tokens
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'css_variables' => [
            '--ui-background',
            '--ui-surface',
            '--ui-layer-*',
            '--ui-field-*',
            '--ui-border-*',
            '--ui-text-*',
            '--ui-icon-*',
            '--ui-link*',
            '--ui-action-*',
            '--ui-status-*',
            '--ui-focus*',
            '--ui-overlay*',
            '--ui-skeleton-*',
            '--ui-code-token-*',
        ],
        'utility_classes' => [
            'ui-card',
            'ui-card-title',
            'ui-card-copy',
            'ui-kicker',
            'ui-link',
        ],
        'class_families' => [
            'ui-card',
            'ui-link',
            'ui-inline-notification',
            'ui-spinner',
            'ui-code-snippet',
        ],
        'component_tokens' => [
            'button',
            'content-switcher',
            'notification/status',
            'tag',
        ],
        'deprecated' => [
            'raw hex/RGB/HSL color values in consumers',
            'direct primitive palette usage in consumers',
            'feature-local color variables',
            'Tailwind color utility clusters for app UI roles',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'blocks' => [
            'themes',
            'spacing',
            'typography',
            'icons',
            'motion',
            'button',
            'notification',
            'tag',
            'text-input',
            'data-table',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'focus' => [
            'Focus color must remain visible in every supported theme.',
        ],
        'screen_reader' => [
            'Semantic color must not be the only cue for status, validation, selection, or action intent.',
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
            'resources/css/tokens/palette/index.css',
            'resources/css/tokens/semantic/index.css',
        ],
        'tokens' => [
            'resources/css/tokens/index.css',
            'resources/css/tokens/palette/**',
            'resources/css/tokens/semantic/**',
            'resources/css/tokens/themes/**',
            'resources/css/tokens/components/buttons.css',
            'resources/css/tokens/components/content-switcher.css',
            'resources/css/tokens/components/notifications.css',
            'resources/css/tokens/components/status.css',
            'resources/css/tokens/components/tags.css',
        ],
        'contract' => [
            'resources/views/elements/color/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/elements/color.md',
            'docs/02-standards/ui/elements/tokens.md',
        ],
    ],
]);

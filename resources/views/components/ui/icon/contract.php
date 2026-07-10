<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/icon/contract.php
| Purpose: Icon Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Icon API that can be called from Blade,
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
        'slug' => 'icon',
        'label' => 'Icon',
        'component' => 'x-ui.icon',
        'summary' => 'Canonical trusted local SVG icon renderer with manifest-backed icon lookup, fallback rendering, size support, decorative mode, accessible label support, and missing-icon diagnostics.',
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
        'usage_context' => 'Use x-ui.icon for all UI icon rendering. Do not use legacy direct icon Blade components or x-dynamic-component for icons.',

        'props' => [
            [
                'name' => 'name',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Canonical icon name from the configured generated icon manifest. Names are exact and intentionally do not use broad aliases.',
            ],
            [
                'name' => 'fallback',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional fallback icon name. Falls back to configured ui-icons.fallback when omitted.',
            ],
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'md',
                'values' => ['xs', 'sm', 'md', 'lg', 'xl', '2xl'],
                'description' => 'Icon size token resolved through configured ui-icons.sizes.',
            ],
            [
                'name' => 'decorative',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'When true and no accessible name is supplied, icon renders aria-hidden.',
            ],
            [
                'name' => 'label',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Accessible aria-label for informative icons.',
            ],
            [
                'name' => 'labelledby',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Accessible aria-labelledby target for informative icons.',
            ],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'icon', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-icon', 'required' => true, 'description' => 'Generated icon marker.'],
            ['name' => 'data-ui-icon-name', 'required' => true, 'description' => 'Generated resolved icon name marker.'],
            ['name' => 'data-ui-icon-requested', 'required' => true, 'description' => 'Generated requested icon name marker.'],
            ['name' => 'data-ui-icon-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-icon-missing', 'required' => true, 'description' => 'Generated missing/fallback state marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-icon',
        'required' => [
            'ui-icon',
        ],
        'optional' => [
            'ui-icon--xs',
            'ui-icon--sm',
            'ui-icon--md',
            'ui-icon--lg',
            'ui-icon--xl',
            'ui-icon--2xl',
            'ui-icon--missing',
        ],
        'internal' => [],
        'deprecated' => [
            'legacy direct x-icons.* Blade usage',
            'legacy direct resources/views/components/icons calls',
            'x-dynamic-component icon rendering',
            'feature-local inline SVG icon markup',
            'raw copied Carbon SVG markup outside x-ui.icon',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'decorative' => [
            'label' => 'Decorative',
            'api' => ['decorative' => true],
            'description' => 'Decorative icon hidden from assistive technology when no accessible name is supplied.',
        ],
        'informative-label' => [
            'label' => 'Informative with label',
            'api' => ['decorative' => false, 'label' => 'Settings'],
            'description' => 'Informative icon with aria-label and role img.',
        ],
        'informative-labelledby' => [
            'label' => 'Informative with labelledby',
            'api' => ['decorative' => false, 'labelledby' => 'icon-title'],
            'description' => 'Informative icon labelled by external text.',
        ],
        'fallback' => [
            'label' => 'Fallback',
            'api' => ['name' => 'missing-icon', 'fallback' => 'empty'],
            'description' => 'Fallback icon rendering when requested icon is unavailable.',
        ],
        'missing' => [
            'label' => 'Missing',
            'api' => ['name' => 'missing-icon'],
            'class' => 'ui-icon--missing',
            'description' => 'Missing icon state with configured fallback shell and diagnostic marker.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-icon--xs', 'description' => 'Extra small icon size.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-icon--sm', 'description' => 'Small icon size.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-icon--md', 'description' => 'Default icon size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-icon--lg', 'description' => 'Large icon size.'],
        'xl' => ['label' => 'Extra large', 'api' => ['size' => 'xl'], 'class' => 'ui-icon--xl', 'description' => 'Extra large icon size.'],
        '2xl' => ['label' => '2X large', 'api' => ['size' => '2xl'], 'class' => 'ui-icon--2xl', 'description' => '2X large icon size.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Resolved known icon state.'],
        'decorative' => ['label' => 'Decorative', 'required' => true, 'description' => 'Icon hidden from assistive technology.'],
        'informative' => ['label' => 'Informative', 'required' => false, 'description' => 'Icon exposed as role img with accessible label or labelledby.'],
        'missing' => ['label' => 'Missing', 'required' => false, 'description' => 'Requested icon was not found and fallback shell/icon rendered.'],
        'fallback' => ['label' => 'Fallback', 'required' => false, 'description' => 'Fallback icon resolved instead of requested icon.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-icon',
        ],
        'component_tokens' => [
            'icon',
            'svg',
            'icon-manifest',
            'accessibility',
        ],
        'deprecated' => [
            'legacy x-icons.* component calls',
            'direct SVG usage in feature Blade',
            'x-dynamic-component for icon rendering',
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
            'themes',
            'sizing',
            'ui-icons config',
            'generated icon manifest',
        ],
        'uses' => [
            'icons' => [
                'configured local SVG manifest',
            ],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'button',
            'icon-button',
            'link',
            'tag',
            'notification',
            'modal',
            'pagination',
            'search',
            'select',
            'text-input',
            'text-area',
            'password-input',
            'number-input',
            'combo-box',
            'dropdown',
            'multi-select',
            'date-picker',
            'file-uploader',
            'menus',
            'shell',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Icon itself must not create keyboard focus.',
            'Interactive behavior belongs to the parent control, not x-ui.icon.',
        ],
        'aria' => [
            'Decorative icons render aria-hidden when no accessible label or labelledby value is supplied.',
            'Informative icons render role="img" when label or labelledby is supplied.',
            'aria-label and aria-labelledby must not both be treated as decorative.',
            'SVG focusable is false.',
        ],
        'focus' => [
            'Icon must not receive focus independently.',
            'Parent controls must own visible focus treatment.',
        ],
        'screen_reader' => [
            'Use decorative icons when adjacent text already communicates the meaning.',
            'Use label or labelledby only when the icon itself conveys necessary information.',
            'Do not rely on icon artwork alone for critical status, action, or validation meaning.',
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
            'feature-local icon utility clusters',
            'raw SVG class stacks outside x-ui.icon',
        ],
        'components' => [
            'legacy x-icons.* direct component calls',
            'legacy generated icon Blade calls',
            'x-dynamic-component icon rendering',
            'inline copied SVG icon markup in feature components',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    'enforcement' => [
        'mode' => 'strict',
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
        ],
        'contract' => [
            'resources/views/components/ui/icon/contract.php',
        ],
    ],
]);

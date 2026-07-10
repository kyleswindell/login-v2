<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/breadcrumb/contract.php
| Purpose: Breadcrumb Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Breadcrumb API that can be called from
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
        'slug' => 'breadcrumb',
        'label' => 'Breadcrumb',
        'component' => 'x-ui.breadcrumb',
        'summary' => 'Breadcrumb navigation component with item-array API, current-page handling, small and medium sizes, optional overflow menu, and trailing-slash suppression.',
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
        'usage_context' => 'Use x-ui.breadcrumb to show the user location within a site or app hierarchy. Breadcrumb does not own the page title, route resolution, section heading, or app shell navigation.',

        'props' => [
            [
                'name' => 'items',
                'type' => 'array',
                'required' => false,
                'default' => [],
                'values' => [],
                'description' => 'Breadcrumb items. Each item accepts label, href, and current keys.',
            ],
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'md',
                'values' => ['sm', 'md'],
                'description' => 'Breadcrumb size.',
            ],
            [
                'name' => 'includeCurrent',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Controls whether current-page items are rendered.',
            ],
            [
                'name' => 'current',
                'type' => 'string|array|object|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Explicit current item. String values become the current label; array/object values may include label and href.',
            ],
            [
                'name' => 'ariaLabel',
                'type' => 'string',
                'required' => false,
                'default' => 'Breadcrumb',
                'values' => [],
                'description' => 'Accessible label for the breadcrumb nav landmark.',
            ],
            [
                'name' => 'maxVisible',
                'type' => 'int|string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional truncation threshold used when overflow is enabled.',
            ],
            [
                'name' => 'overflow',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Enables overflow menu rendering when item count exceeds the truncation threshold.',
            ],
            [
                'name' => 'menuOpen',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Static overflow menu open state for reference, testing, or controlled rendering.',
            ],
            [
                'name' => 'noTrailingSlash',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Suppresses trailing slash treatment when supported by installed breadcrumb CSS.',
            ],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'breadcrumb',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb',
                'required' => true,
                'description' => 'Generated root breadcrumb marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-size',
                'required' => true,
                'description' => 'Generated resolved size marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-current-included',
                'required' => true,
                'description' => 'Generated current-page inclusion marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-visible-items',
                'required' => true,
                'description' => 'Generated visible item count marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-truncate-after',
                'required' => true,
                'description' => 'Generated truncation threshold marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-overflow',
                'required' => false,
                'description' => 'Generated overflow-enabled marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-no-trailing-slash',
                'required' => false,
                'description' => 'Generated trailing-slash suppression marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-overflow-item',
                'required' => false,
                'description' => 'Generated overflow list item marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-overflow-trigger',
                'required' => false,
                'description' => 'Generated overflow trigger marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-overflow-menu',
                'required' => false,
                'description' => 'Generated overflow menu marker.',
            ],
            [
                'name' => 'data-ui-breadcrumb-overflow-menu-state',
                'required' => false,
                'description' => 'Generated overflow menu state marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-breadcrumb',
        'required' => [
            'ui-breadcrumb',
            'ui-breadcrumb-list',
            'ui-breadcrumb-item',
        ],
        'optional' => [
            'ui-breadcrumb-sm',
            'ui-breadcrumb-md',
            'ui-breadcrumb-no-trailing-slash',
            'ui-breadcrumb-current',
            'ui-breadcrumb-link',
            'ui-breadcrumb-overflow',
            'ui-breadcrumb-overflow-trigger',
            'ui-breadcrumb-overflow-icon',
            'ui-breadcrumb-overflow-menu',
            'ui-breadcrumb-overflow-desktop-item',
            'ui-breadcrumb-overflow-compact-item',
            'ui-menu',
            'ui-menu-sm',
            'ui-menu-align-bottom-start',
        ],
        'internal' => [],
        'deprecated' => [
            'Tailwind sizing classes on breadcrumb icons',
            'feature-local breadcrumb separator classes',
            'ad hoc breadcrumb navigation markup outside x-ui.breadcrumb',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => [
            'label' => 'Default',
            'api' => [],
            'description' => 'Default breadcrumb trail without current-page item.',
        ],
        'with-current' => [
            'label' => 'With current page',
            'api' => ['includeCurrent' => true],
            'description' => 'Breadcrumb trail with current-page item rendered.',
        ],
        'explicit-current' => [
            'label' => 'Explicit current',
            'api' => ['current' => 'Current page'],
            'description' => 'Breadcrumb trail with explicit current item appended.',
        ],
        'overflow' => [
            'label' => 'Overflow',
            'api' => ['overflow' => true],
            'description' => 'Breadcrumb trail with hidden middle items available from an overflow menu.',
        ],
        'no-trailing-slash' => [
            'label' => 'No trailing slash',
            'api' => ['noTrailingSlash' => true],
            'class' => 'ui-breadcrumb-no-trailing-slash',
            'description' => 'Breadcrumb trail with trailing slash treatment suppressed when supported by CSS.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => [
            'label' => 'Small',
            'api' => ['size' => 'sm'],
            'class' => 'ui-breadcrumb-sm',
            'description' => 'Small breadcrumb size.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'class' => 'ui-breadcrumb-md',
            'description' => 'Default breadcrumb size.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => [
            'label' => 'Default',
            'required' => true,
            'description' => 'Default breadcrumb navigation state.',
        ],
        'current-page' => [
            'label' => 'Current page',
            'required' => false,
            'description' => 'Current breadcrumb item renders aria-current="page".',
        ],
        'overflow-closed' => [
            'label' => 'Overflow closed',
            'required' => false,
            'description' => 'Overflow menu is hidden.',
        ],
        'overflow-open' => [
            'label' => 'Overflow open',
            'required' => false,
            'description' => 'Overflow menu is visible.',
        ],
        'empty' => [
            'label' => 'Empty',
            'required' => false,
            'description' => 'No breadcrumb items render after normalization.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for breadcrumb links, overflow trigger, and overflow menu items.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-breadcrumb',
            'ui-breadcrumb-overflow',
            'ui-menu',
        ],
        'component_tokens' => [
            'breadcrumb',
            'navigation',
            'menu',
        ],
        'deprecated' => [
            'Tailwind utility classes inside breadcrumb internals',
            'feature-local breadcrumb separators',
            'ad hoc breadcrumb markup outside x-ui.breadcrumb',
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
            'spacing',
            'typography',
            'icons',
            'menu',
        ],
        'uses' => [
            'icons' => [
                'overflow-menu--horizontal',
            ],
            'components' => [
                'ui.icon',
                'ui.menu-item',
            ],
            'js_initializers' => [
                'menu behavior for breadcrumb overflow if installed',
            ],
        ],
        'blocks' => [
            'app-shell',
            'page-header',
            'navigation-patterns',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Breadcrumb links must be keyboard reachable.',
            'Overflow trigger and menu items must be keyboard reachable when overflow is enabled.',
            'Overflow menu keyboard behavior is owned by installed menu JavaScript.',
        ],
        'aria' => [
            'Root renders a nav landmark with an accessible label.',
            'Current page item renders aria-current="page".',
            'Overflow trigger renders aria-haspopup="menu", aria-expanded, aria-controls, and an accessible label.',
            'Overflow menu renders role="menu".',
            'Overflow icon is decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Breadcrumb links, overflow trigger, and overflow menu items must show visible focus.',
            'Overflow menu focus placement and return focus are owned by installed menu JavaScript.',
        ],
        'screen_reader' => [
            'Breadcrumb labels must be concise and describe the page hierarchy.',
            'Breadcrumb should not replace the page heading.',
            'Current page inclusion should not duplicate nearby page title text unless the layout intentionally requires it.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'classes' => [
            'h-4',
            'w-4',
            'feature-local breadcrumb separator classes',
            'raw breadcrumb utility clusters',
        ],
        'components' => [
            'ad hoc breadcrumb navigation markup outside x-ui.breadcrumb',
            'breadcrumb used as primary app navigation',
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
            'resources/views/components/ui/breadcrumb/index.blade.php',
        ],
        'css' => [
            'resources/css/components/breadcrumb.css',
        ],
        'contract' => [
            'resources/views/components/ui/breadcrumb/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/breadcrumb.md',
        ],
    ],
]);

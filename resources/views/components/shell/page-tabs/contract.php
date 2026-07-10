<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/shell/page-tabs/contract.php
| Purpose: UI Shell Page Tabs Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public UI Shell Page Tabs API that can be called
| from Blade, validated by tooling, and consumed by shell layouts.
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
        'slug' => 'ui-shell-page-tabs',
        'label' => 'UI Shell Page Tabs',
        'component' => 'x-shell.page-tabs',
        'summary' => 'Page-level route navigation tabs for shell pages, separate from interactive tab panels.',
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
        'usage_context' => 'Use x-shell.page-tabs for page-level route navigation such as Usage, Examples, Accessibility, and Implementation. Use x-ui.tabs for interactive tab panels.',

        'props' => [
            [
                'name' => 'items',
                'type' => 'array',
                'required' => false,
                'default' => [],
                'values' => [],
                'description' => 'Page tab items. Each item accepts label, href, current or active, and wireNavigate keys.',
            ],
            [
                'name' => 'label',
                'type' => 'string',
                'required' => false,
                'default' => 'Page sections',
                'values' => [],
                'description' => 'Accessible label for the page tabs nav landmark.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Custom page tab markup. When provided, it replaces array-driven item rendering.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'shell-page-tabs',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-shell-page-tabs',
                'required' => true,
                'description' => 'Generated root shell page tabs marker.',
            ],
            [
                'name' => 'data-ui-shell-page-tabs-source',
                'required' => true,
                'description' => 'Generated rendering source marker: items or slot.',
            ],
            [
                'name' => 'data-ui-shell-page-tabs-count',
                'required' => true,
                'description' => 'Generated normalized item count marker.',
            ],
            [
                'name' => 'data-ui-shell-page-tabs-selected-count',
                'required' => true,
                'description' => 'Generated selected/current item count marker.',
            ],
            [
                'name' => 'data-ui-shell-page-tabs-item',
                'required' => false,
                'description' => 'Generated item marker for array-rendered items.',
            ],
            [
                'name' => 'data-ui-shell-page-tabs-selected',
                'required' => false,
                'description' => 'Generated selected/current item marker.',
            ],
            [
                'name' => 'data-ui-shell-page-tabs-link',
                'required' => false,
                'description' => 'Generated link marker for array-rendered links.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-shell-page-tabs',
        'required' => [
            'ui-shell-page-tabs',
        ],
        'optional' => [
            'ui-shell-page-tabs__list',
            'ui-shell-page-tabs__item',
            'ui-shell-page-tabs__item--selected',
            'ui-shell-page-tabs__link',
            'ui-shell-page-tabs__link--selected',
        ],
        'internal' => [],
        'deprecated' => [
            'interactive tab panel markup inside x-shell.page-tabs',
            'feature-local page tab navigation classes',
            'ad hoc shell page tabs outside x-shell.page-tabs',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'items' => [
            'label' => 'Array items',
            'api' => [
                'items' => [
                    ['label' => 'Usage', 'href' => '#'],
                ],
            ],
            'description' => 'Array-driven page tabs.',
        ],
        'slot' => [
            'label' => 'Custom slot',
            'api' => [
                'slot' => 'custom page tab markup',
            ],
            'description' => 'Caller-provided custom page tab markup.',
        ],
        'with-current' => [
            'label' => 'With current page',
            'api' => [
                'items' => [
                    ['label' => 'Usage', 'href' => '#', 'current' => true],
                ],
            ],
            'class' => 'ui-shell-page-tabs__link--selected',
            'description' => 'Page tabs with current route marker.',
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
            'description' => 'Default page tabs navigation state.',
        ],
        'current-page' => [
            'label' => 'Current page',
            'required' => false,
            'description' => 'Current page link exposes aria-current="page".',
        ],
        'not-rendered' => [
            'label' => 'Not rendered',
            'required' => false,
            'description' => 'Component emits no markup when there are no normalized items and no slot content.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for page tab links.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-shell-page-tabs',
        ],
        'component_tokens' => [
            'ui-shell',
            'page-tabs',
            'navigation',
        ],
        'deprecated' => [
            'feature-local page tab navigation classes',
            'ad hoc route tab markup outside x-shell.page-tabs',
            'x-shell.page-tabs used for interactive tab panels',
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
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'ui-shell',
            'page-header',
            'evidence-pages',
            'route-navigation',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Page tab links must use native anchor keyboard behavior.',
            'Page tabs must not implement interactive tab panel keyboard behavior.',
        ],
        'aria' => [
            'Root renders a nav landmark with an accessible label.',
            'Current page link renders aria-current="page".',
            'Do not use role="tablist", role="tab", or role="tabpanel" for this route navigation component.',
        ],
        'focus' => [
            'Page tab links must show visible focus.',
        ],
        'screen_reader' => [
            'Page tab labels must describe destination pages or sections clearly.',
            'Use x-ui.tabs when users are switching in-page panels instead of navigating routes/pages.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'classes' => [
            'feature-local page tab classes',
            'raw page tab utility clusters',
        ],
        'components' => [
            'ad hoc shell page tabs outside x-shell.page-tabs',
            'using x-shell.page-tabs for interactive tab panels instead of x-ui.tabs',
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
            'resources/views/components/shell/page-tabs/index.blade.php',
        ],
        'css' => [
            'resources/css/components/ui-shell/index.css',
        ],
        'contract' => [
            'resources/views/components/shell/page-tabs/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/ui-shell.md',
        ],
    ],
]);

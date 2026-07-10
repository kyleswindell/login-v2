<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/overflow-menu/contract.php
| Purpose: Overflow Menu Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Overflow Menu API that can be called from
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
        'slug' => 'overflow-menu',
        'label' => 'Overflow Menu',
        'component' => 'x-ui.overflow-menu',
        'summary' => 'Icon-triggered overflow action menu wrapper around x-ui.menu with overflow-specific wrapper classes and defaults.',
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
        'usage_context' => 'Use x-ui.overflow-menu for icon-only overflow action menus. Use x-ui.menu-button for visible text button-triggered action menus and x-ui.menu when direct menu composition or triggerless menu surfaces are needed.',

        'props' => [
            [
                'name' => 'items',
                'type' => 'array',
                'required' => false,
                'default' => [],
                'values' => [],
                'description' => 'Item-array menu content forwarded to x-ui.menu.',
            ],
            [
                'name' => 'label',
                'type' => 'string',
                'required' => false,
                'default' => 'More actions',
                'values' => [],
                'description' => 'Menu label and accessible label fallback.',
            ],
            [
                'name' => 'ariaLabel',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Explicit accessible label for the overflow trigger.',
            ],
            [
                'name' => 'tooltip',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional tooltip text for the icon trigger.',
            ],
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'md',
                'values' => ['xs', 'sm', 'md', 'lg'],
                'description' => 'Overflow menu trigger and menu size.',
            ],
            [
                'name' => 'align',
                'type' => 'string',
                'required' => false,
                'default' => 'bottom-end',
                'values' => ['start', 'end', 'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'],
                'description' => 'Compatibility placement alias. placement takes precedence when provided.',
                'compatibility' => true,
            ],
            [
                'name' => 'placement',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['start', 'end', 'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'],
                'description' => 'Canonical overflow menu placement.',
            ],
            [
                'name' => 'open',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Rendered open state. Disabled overflow menus force closed rendering.',
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Disables the overflow trigger and forces the menu closed.',
            ],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'overflow-menu',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-overflow-menu',
                'required' => true,
                'description' => 'Generated root overflow menu marker.',
            ],
            [
                'name' => 'data-ui-overflow-menu-size',
                'required' => true,
                'description' => 'Generated resolved size marker.',
            ],
            [
                'name' => 'data-ui-overflow-menu-placement',
                'required' => true,
                'description' => 'Generated resolved placement marker.',
            ],
            [
                'name' => 'data-ui-overflow-menu-open',
                'required' => true,
                'description' => 'Generated open state marker.',
            ],
            [
                'name' => 'data-ui-overflow-menu-disabled',
                'required' => true,
                'description' => 'Generated disabled state marker.',
            ],
            [
                'name' => 'data-ui-menu-button-kind',
                'required' => false,
                'value' => 'overflow',
                'description' => 'Generated marker passed to x-ui.menu for overflow-menu trigger context.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-overflow-menu',
        'required' => [
            'ui-overflow-menu',
        ],
        'optional' => [
            'ui-overflow-menu-xs',
            'ui-overflow-menu-sm',
            'ui-overflow-menu-md',
            'ui-overflow-menu-lg',
            'ui-overflow-menu-open',
            'ui-overflow-menu-trigger',
            'ui-menu',
            'ui-menu-composition',
            'ui-icon-button',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local overflow menu wrappers',
            'ad hoc icon-triggered menus outside x-ui.overflow-menu',
            'raw Carbon overflow menu item markup outside x-ui.menu-item',
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
            'class' => 'ui-overflow-menu',
            'description' => 'Default closed overflow menu.',
        ],
        'open' => [
            'label' => 'Open',
            'api' => ['open' => true],
            'class' => 'ui-overflow-menu-open',
            'description' => 'Overflow menu rendered open.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'api' => ['disabled' => true],
            'description' => 'Disabled overflow menu trigger and closed menu surface.',
        ],
        'with-tooltip' => [
            'label' => 'With tooltip',
            'api' => ['tooltip' => 'More actions'],
            'description' => 'Overflow menu trigger with tooltip text.',
        ],
        'with-items' => [
            'label' => 'With item array',
            'api' => ['items' => [['label' => 'Action']]],
            'description' => 'Overflow menu with item-array content forwarded to x-ui.menu.',
        ],
        'top' => [
            'label' => 'Top placement',
            'api' => ['placement' => 'top'],
            'description' => 'Overflow menu prefers top placement.',
        ],
        'bottom-end' => [
            'label' => 'Bottom end placement',
            'api' => ['placement' => 'bottom-end'],
            'description' => 'Default bottom-end overflow placement.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => [
            'label' => 'Extra small',
            'api' => ['size' => 'xs'],
            'class' => 'ui-overflow-menu-xs',
            'description' => 'Extra small overflow menu.',
        ],
        'sm' => [
            'label' => 'Small',
            'api' => ['size' => 'sm'],
            'class' => 'ui-overflow-menu-sm',
            'description' => 'Small overflow menu.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'class' => 'ui-overflow-menu-md',
            'description' => 'Default overflow menu size.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => ['size' => 'lg'],
            'class' => 'ui-overflow-menu-lg',
            'description' => 'Large overflow menu.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'closed' => [
            'label' => 'Closed',
            'required' => true,
            'description' => 'Default closed overflow menu state.',
        ],
        'open' => [
            'label' => 'Open',
            'required' => false,
            'description' => 'Open overflow menu state.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Disabled trigger and forced closed menu state.',
        ],
        'positioned' => [
            'label' => 'Positioned',
            'required' => false,
            'description' => 'Placement state owned by menu CSS/JavaScript.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for overflow trigger and menu items.',
        ],
        'tooltip-open' => [
            'label' => 'Tooltip open',
            'required' => false,
            'description' => 'Tooltip visible state for trigger tooltip when installed.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-overflow-menu',
            'ui-menu',
            'ui-icon-button',
        ],
        'component_tokens' => [
            'overflow-menu',
            'menu',
            'menu-item',
            'icon-button',
            'tooltip',
        ],
        'deprecated' => [
            'feature-local overflow menu wrappers',
            'ad hoc icon overflow actions',
            'raw Carbon overflow menu item markup outside x-ui.menu-item',
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
            'icon-button',
            'menu',
            'menu-item',
            'tooltip',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'overflow-menu--vertical',
            ],
            'components' => [
                'ui.menu',
                'ui.icon-button',
                'ui.menu-item',
            ],
            'js_initializers' => [
                'overflow menu behavior if installed',
                'menu behavior if installed',
                'tooltip behavior if installed',
            ],
        ],
        'blocks' => [
            'data-table-toolbar',
            'breadcrumb-overflow',
            'shell-header-actions',
            'card-actions',
            'row-actions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Overflow trigger must be keyboard reachable unless disabled.',
            'Menu keyboard behavior is owned by x-ui.menu and installed menu JavaScript.',
            'Escape, Tab, arrow navigation, outside-click dismissal, and focus return are owned by installed menu behavior.',
        ],
        'aria' => [
            'Overflow trigger accessible label comes from ariaLabel, caller aria-label, or label.',
            'Nested x-ui.menu trigger emits aria-haspopup, aria-expanded, and aria-controls.',
            'Nested menu surface renders role="menu".',
            'Menu items must provide meaningful action or destination text.',
        ],
        'focus' => [
            'Overflow trigger and menu items must show visible focus.',
            'Opening and closing focus behavior belongs to installed menu JavaScript.',
        ],
        'screen_reader' => [
            'Overflow trigger label should describe the available action group.',
            'Danger menu items should use x-ui.menu-item danger copy and optional dangerDescription.',
            'Tooltip text should not replace a specific accessible label when the action group needs a clearer name.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            [
                'name' => 'align',
                'replacement' => 'placement',
                'description' => 'align remains accepted as a compatibility alias.',
            ],
            [
                'name' => 'start',
                'replacement' => 'bottom-start',
                'description' => 'start remains accepted as a placement alias.',
            ],
            [
                'name' => 'end',
                'replacement' => 'bottom-end',
                'description' => 'end remains accepted as a placement alias.',
            ],
        ],
        'classes' => [
            'feature-local overflow menu classes',
            'raw Carbon overflow menu option classes outside x-ui.menu-item',
            'raw overflow menu utility clusters',
        ],
        'components' => [
            'ad hoc overflow action menus outside x-ui.overflow-menu',
            'using x-ui.menu-button for icon-only overflow actions',
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
            'resources/views/components/ui/overflow-menu/index.blade.php',
        ],
        'css' => [
            'resources/css/components/menu.css',
            'resources/css/components/button.css',
        ],
        'contract' => [
            'resources/views/components/ui/overflow-menu/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/overflow-menu.md',
        ],
    ],
]);

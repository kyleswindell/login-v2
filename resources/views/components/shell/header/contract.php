<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/shell/header/contract.php
| Purpose: UI Shell Header Component family public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public UI Shell Header API that can be called from
| Blade, validated by tooling, and consumed by shell layouts.
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
        'slug' => 'ui-shell-header',
        'label' => 'UI Shell Header',
        'component' => 'x-shell.header',
        'summary' => 'Persistent shell header family for brand name, primary navigation, header menus, global actions, menu button, expandable panels, and side-nav-collapsed header items.',
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
        'usage_context' => 'Use x-shell.header and its nested header subcomponents to compose the persistent application header. Header behavior such as panel disclosure, menu disclosure, outside click, Escape handling, focus return, and responsive collapse belongs to installed shell JavaScript or the consuming shell layout.',

        'props' => [
            [
                'name' => 'label',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional aria-label for the shell header landmark.',
            ],
            [
                'name' => 'labelledby',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional aria-labelledby target for the shell header landmark.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Header content, usually name, navigation, global bar, actions, menu button, panels, or side-nav responsive content.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-shell-header', 'required' => true, 'description' => 'Generated shell header root marker.'],
            ['name' => 'data-ui-shell-header-global-bar', 'required' => false, 'description' => 'Generated global actions container marker.'],
            ['name' => 'data-ui-shell-header-global-action', 'required' => false, 'description' => 'Generated global action button marker.'],
            ['name' => 'data-ui-shell-header-global-action-active', 'required' => false, 'description' => 'Generated global action active state marker.'],
            ['name' => 'data-ui-shell-header-submenu', 'required' => false, 'description' => 'Generated header submenu marker.'],
            ['name' => 'data-ui-shell-header-menu-trigger', 'required' => false, 'description' => 'Generated header submenu trigger marker.'],
            ['name' => 'data-ui-shell-header-menu', 'required' => false, 'description' => 'Generated header submenu list marker.'],
            ['name' => 'data-ui-shell-header-menu-item-wrapper', 'required' => false, 'description' => 'Generated header menu item wrapper marker.'],
            ['name' => 'data-ui-shell-header-menu-item', 'required' => false, 'description' => 'Generated header menu item control marker.'],
            ['name' => 'data-ui-shell-header-menu-button', 'required' => false, 'description' => 'Generated shell menu button marker.'],
            ['name' => 'data-ui-shell-header-menu-button-active', 'required' => false, 'description' => 'Generated shell menu button active marker.'],
            ['name' => 'data-ui-shell-header-name', 'required' => false, 'description' => 'Generated shell header name marker.'],
            ['name' => 'data-ui-shell-header-navigation', 'required' => false, 'description' => 'Generated shell header navigation marker.'],
            ['name' => 'data-ui-shell-header-menu-bar', 'required' => false, 'description' => 'Generated shell header menu bar marker.'],
            ['name' => 'data-ui-shell-header-panel', 'required' => false, 'description' => 'Generated shell header panel marker.'],
            ['name' => 'data-ui-shell-header-panel-expanded', 'required' => false, 'description' => 'Generated shell header panel expanded marker.'],
            ['name' => 'data-ui-shell-header-panel-focus-listeners', 'required' => false, 'description' => 'Generated shell header panel focus listener marker.'],
            ['name' => 'data-ui-shell-header-panel-collapse-href', 'required' => false, 'description' => 'Generated shell header panel collapse href marker.'],
            ['name' => 'data-ui-shell-header-side-nav-items', 'required' => false, 'description' => 'Generated side-nav header navigation items marker.'],
            ['name' => 'data-ui-shell-header-side-nav-items-divider', 'required' => false, 'description' => 'Generated side-nav header navigation divider marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Subcomponents
    |--------------------------------------------------------------------------
    */

    'subcomponents' => [
        'root' => [
            'component' => 'x-shell.header',
            'description' => 'Persistent shell header landmark.',
            'props' => ['label', 'labelledby'],
            'slots' => ['default'],
        ],
        'global-bar' => [
            'component' => 'x-shell.header.global-bar',
            'description' => 'Header global actions container.',
            'props' => [],
            'slots' => ['default'],
        ],
        'global-action' => [
            'component' => 'x-shell.header.global-action',
            'description' => 'Icon-only global header action button.',
            'props' => ['icon', 'label', 'labelledby', 'controls', 'active', 'expanded', 'isActive', 'tooltipAlignment', 'tooltipDropShadow', 'tooltipHighContrast', 'type'],
            'slots' => ['default'],
        ],
        'menu' => [
            'component' => 'x-shell.header.menu',
            'description' => 'Header navigation submenu item with adjacent submenu list.',
            'props' => ['label', 'href', 'expanded', 'active', 'isActive', 'isCurrentPage', 'current', 'ariaCurrent', 'role', 'tabIndex', 'wireNavigate'],
            'slots' => ['default'],
        ],
        'menu-item' => [
            'component' => 'x-shell.header.menu-item',
            'description' => 'Header menu item rendered as an anchor or button.',
            'props' => ['as', 'href', 'active', 'isActive', 'isCurrentPage', 'current', 'ariaCurrent', 'role', 'tabIndex', 'wireNavigate'],
            'slots' => ['default'],
        ],
        'menu-button' => [
            'component' => 'x-shell.header.menu-button',
            'description' => 'Shell header menu toggle button.',
            'props' => ['controls', 'label', 'closeLabel', 'expanded'],
            'slots' => ['default'],
        ],
        'name' => [
            'component' => 'x-shell.header.name',
            'description' => 'Shell header product/application name link.',
            'props' => ['href', 'prefix', 'wireNavigate'],
            'slots' => ['default'],
        ],
        'navigation' => [
            'component' => 'x-shell.header.navigation',
            'description' => 'Primary header navigation region.',
            'props' => ['label', 'labelledby'],
            'slots' => ['default'],
        ],
        'panel' => [
            'component' => 'x-shell.header.panel',
            'description' => 'Expandable header panel for account, notifications, switcher, settings, or app-specific panel content.',
            'props' => ['id', 'label', 'labelledby', 'expanded', 'addFocusListeners', 'href', 'role'],
            'slots' => ['default'],
        ],
        'side-nav-items' => [
            'component' => 'x-shell.header.side-nav-items',
            'description' => 'Header navigation items rendered inside side navigation for responsive collapse.',
            'props' => ['divider', 'hasDivider'],
            'slots' => ['default'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-shell-header',
        'required' => [
            'ui-shell-header',
        ],
        'optional' => [
            'ui-shell-header__global',
            'ui-shell-header__action',
            'ui-shell-header__global-action',
            'ui-shell-header__action--active',
            'ui-shell-header__action-icon',
            'ui-button',
            'ui-button--icon-only',
            'ui-shell-header__submenu',
            'ui-shell-header__menu-item',
            'ui-shell-header__menu-title',
            'ui-shell-header__menu-item--current',
            'ui-shell-header__menu-arrow',
            'ui-shell-header__menu',
            'ui-shell-header__menu-item-wrapper',
            'ui-shell-header__menu-trigger',
            'ui-shell-header__menu-toggle',
            'ui-shell-header__name',
            'ui-shell-header__name-prefix',
            'ui-shell-header__name-text',
            'ui-shell-header__nav',
            'ui-shell-header__menu-bar',
            'ui-shell-header-panel',
            'ui-shell-header-panel--expanded',
            'ui-shell-side-nav__header-navigation',
            'ui-shell-side-nav__header-divider',
            'ui-shell-text-truncate--end',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local shell header classes',
            'ad hoc header navigation markup outside x-shell.header.*',
            'ad hoc icon-only header action buttons outside x-shell.header.global-action',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => [
            'label' => 'Default header',
            'api' => ['component' => 'x-shell.header'],
            'class' => 'ui-shell-header',
            'description' => 'Persistent shell header landmark.',
        ],
        'with-name' => [
            'label' => 'With name',
            'api' => ['component' => 'x-shell.header.name'],
            'class' => 'ui-shell-header__name',
            'description' => 'Header with product/application name link.',
        ],
        'with-navigation' => [
            'label' => 'With navigation',
            'api' => ['component' => 'x-shell.header.navigation'],
            'class' => 'ui-shell-header__nav',
            'description' => 'Header with primary navigation region.',
        ],
        'with-global-actions' => [
            'label' => 'With global actions',
            'api' => ['component' => 'x-shell.header.global-bar'],
            'class' => 'ui-shell-header__global',
            'description' => 'Header with global action button region.',
        ],
        'global-action' => [
            'label' => 'Global action',
            'api' => ['component' => 'x-shell.header.global-action'],
            'class' => 'ui-shell-header__global-action',
            'description' => 'Icon-only global action button.',
        ],
        'active-global-action' => [
            'label' => 'Active global action',
            'api' => ['active' => true],
            'class' => 'ui-shell-header__action--active',
            'description' => 'Active global action or expanded controlled action.',
        ],
        'header-menu' => [
            'label' => 'Header menu',
            'api' => ['component' => 'x-shell.header.menu'],
            'class' => 'ui-shell-header__submenu',
            'description' => 'Header submenu item.',
        ],
        'header-menu-item' => [
            'label' => 'Header menu item',
            'api' => ['component' => 'x-shell.header.menu-item'],
            'class' => 'ui-shell-header__menu-item',
            'description' => 'Header menu item link or button.',
        ],
        'current-menu-item' => [
            'label' => 'Current menu item',
            'api' => ['active' => true],
            'class' => 'ui-shell-header__menu-item--current',
            'description' => 'Current header menu item treatment.',
        ],
        'menu-button' => [
            'label' => 'Menu button',
            'api' => ['component' => 'x-shell.header.menu-button'],
            'class' => 'ui-shell-header__menu-button',
            'description' => 'Shell header menu toggle button.',
        ],
        'header-panel' => [
            'label' => 'Header panel',
            'api' => ['component' => 'x-shell.header.panel'],
            'class' => 'ui-shell-header-panel',
            'description' => 'Expandable shell header panel.',
        ],
        'side-nav-items' => [
            'label' => 'Side nav items',
            'api' => ['component' => 'x-shell.header.side-nav-items'],
            'class' => 'ui-shell-side-nav__header-navigation',
            'description' => 'Header navigation items rendered inside side navigation.',
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
            'description' => 'Default shell header state.',
        ],
        'current-page' => [
            'label' => 'Current page',
            'required' => false,
            'description' => 'Current navigation item state.',
        ],
        'global-action-active' => [
            'label' => 'Global action active',
            'required' => false,
            'description' => 'Global action is active or expanded.',
        ],
        'global-action-inactive' => [
            'label' => 'Global action inactive',
            'required' => false,
            'description' => 'Global action is inactive.',
        ],
        'submenu-expanded' => [
            'label' => 'Submenu expanded',
            'required' => false,
            'description' => 'Header submenu trigger exposes expanded state.',
        ],
        'submenu-collapsed' => [
            'label' => 'Submenu collapsed',
            'required' => false,
            'description' => 'Header submenu trigger exposes collapsed state.',
        ],
        'panel-expanded' => [
            'label' => 'Panel expanded',
            'required' => false,
            'description' => 'Header panel is visible.',
        ],
        'panel-collapsed' => [
            'label' => 'Panel collapsed',
            'required' => false,
            'description' => 'Header panel is hidden.',
        ],
        'menu-button-expanded' => [
            'label' => 'Menu button expanded',
            'required' => false,
            'description' => 'Menu button controls an expanded menu/panel state.',
        ],
        'side-nav-items-divider' => [
            'label' => 'Side nav items divider',
            'required' => false,
            'description' => 'Header-derived side nav item group renders divider treatment.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for header name, navigation items, menu triggers, menu items, global actions, menu button, and panel controls.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-shell-header',
            'ui-shell-header__menu',
            'ui-shell-header__action',
            'ui-shell-header-panel',
            'ui-shell-side-nav__header-navigation',
        ],
        'component_tokens' => [
            'ui-shell',
            'header',
            'navigation',
            'global-actions',
            'panel',
            'menu',
        ],
        'deprecated' => [
            'feature-local shell header wrappers',
            'feature-local global action buttons',
            'ad hoc shell header markup outside x-shell.header.*',
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
            'motion',
            'tooltip',
        ],
        'uses' => [
            'icons' => [
                'dynamic global action icon prop',
                'caller-provided menu button icons',
                'inline submenu arrow svg',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'shell header menu behavior if installed',
                'shell header panel behavior if installed',
                'tooltip behavior for global actions if installed',
            ],
        ],
        'blocks' => [
            'ui-shell',
            'side-nav',
            'switcher',
            'skip-to-content',
            'page-layout',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Header name, navigation items, menu triggers, menu items, global actions, and menu buttons must be keyboard reachable unless intentionally hidden by responsive shell behavior.',
            'Header submenu and panel Escape behavior is owned by installed shell JavaScript.',
            'Outside-click dismissal and focus return for panels are owned by installed shell JavaScript.',
        ],
        'aria' => [
            'Header may expose aria-label or aria-labelledby when needed to distinguish landmarks.',
            'Header navigation renders a nav landmark and should have aria-label or aria-labelledby when multiple navigation regions exist.',
            'Current header navigation items may expose aria-current.',
            'Header menu triggers expose aria-haspopup and aria-expanded.',
            'Global actions with controlled panels expose aria-controls and aria-expanded.',
            'Global actions without controlled panels may expose aria-pressed when active.',
            'Menu button exposes aria-controls and aria-expanded.',
            'Header panels may expose role, aria-label, or aria-labelledby as provided by the caller.',
            'Decorative icons must be hidden from assistive technology.',
        ],
        'focus' => [
            'Header interactive controls must show visible focus.',
            'Header panel opening should move or preserve focus intentionally.',
            'Header panel close should return focus to the controlling action when behavior is JavaScript-driven.',
        ],
        'screen_reader' => [
            'Global action buttons must have accessible names.',
            'Header menu labels must describe destinations or categories clearly.',
            'Header name should identify the product or application.',
            'Panel labels should describe panel purpose when panel content is not self-explanatory.',
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
                'name' => 'isActive',
                'replacement' => 'active',
                'description' => 'isActive remains accepted as a compatibility alias for active state.',
            ],
            [
                'name' => 'isCurrentPage',
                'replacement' => 'current',
                'description' => 'isCurrentPage remains accepted as a compatibility alias for current page state.',
            ],
            [
                'name' => 'current',
                'replacement' => 'active',
                'description' => 'current remains accepted for route-current header items.',
            ],
            [
                'name' => 'hasDivider',
                'replacement' => 'divider',
                'description' => 'hasDivider remains accepted as a compatibility alias for divider.',
            ],
        ],
        'classes' => [
            'feature-local shell header classes',
            'feature-local header action classes',
            'raw shell header utility clusters',
        ],
        'components' => [
            'ad hoc shell header markup outside x-shell.header.*',
            'ad hoc icon-only global header actions outside x-shell.header.global-action',
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
            'resources/views/components/shell/header/index.blade.php',
            'resources/views/components/shell/header/global-bar.blade.php',
            'resources/views/components/shell/header/global-action.blade.php',
            'resources/views/components/shell/header/menu.blade.php',
            'resources/views/components/shell/header/menu-item.blade.php',
            'resources/views/components/shell/header/menu-button.blade.php',
            'resources/views/components/shell/header/name.blade.php',
            'resources/views/components/shell/header/navigation.blade.php',
            'resources/views/components/shell/header/panel.blade.php',
            'resources/views/components/shell/header/side-nav-items.blade.php',
        ],
        'css' => [
            'resources/css/components/ui-shell/index.css',
        ],
        'contract' => [
            'resources/views/components/shell/header/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/ui-shell.md',
        ],
    ],
]);

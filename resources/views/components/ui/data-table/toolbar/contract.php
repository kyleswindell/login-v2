<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/data-table/toolbar/contract.php
| Purpose: Data Table Toolbar Component family public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Data Table Toolbar API that can be called
| from Blade, validated by tooling, and consumed by Data Table compositions.
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
        'slug' => 'data-table-toolbar',
        'label' => 'Data Table Toolbar',
        'component' => 'x-ui.data-table.toolbar.*',
        'summary' => 'Data Table toolbar family for toolbar grouping, table search composition, trailing content, overflow menu, and menu actions.',
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
        'usage_context' => 'Use x-ui.data-table.toolbar.* inside data table compositions for search, content grouping, overflow actions, and toolbar action menus. Filtering, query state, selection state, sorting state, and action behavior remain owned by the consuming table controller or Pattern.',

        'props' => [
            [
                'name' => 'ariaLabel',
                'type' => 'string',
                'required' => false,
                'default' => 'data table toolbar',
                'values' => [],
                'description' => 'Accessible label for the toolbar group region.',
            ],
            [
                'name' => 'size',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['xs', 'sm', 'lg'],
                'description' => 'Toolbar root size. Child search and menu components may also consume md through explicit size override.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Toolbar content, typically search, content, menu, batch actions, or action controls.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'data-table-toolbar', 'description' => 'Generated toolbar root component marker.'],
            ['name' => 'data-ui-table-toolbar', 'required' => true, 'description' => 'Generated toolbar root marker.'],
            ['name' => 'data-ui-table-toolbar-size', 'required' => false, 'description' => 'Generated toolbar size marker.'],
            ['name' => 'data-ui-table-toolbar-search', 'required' => false, 'description' => 'Generated toolbar search container marker.'],
            ['name' => 'data-ui-table-toolbar-search-expanded', 'required' => false, 'description' => 'Generated toolbar search expanded state marker.'],
            ['name' => 'data-ui-table-toolbar-search-persistent', 'required' => false, 'description' => 'Generated toolbar search persistent state marker.'],
            ['name' => 'data-ui-table-toolbar-content', 'required' => false, 'description' => 'Generated toolbar trailing content marker.'],
            ['name' => 'data-ui-table-toolbar-menu', 'required' => false, 'description' => 'Generated toolbar overflow menu wrapper marker.'],
            ['name' => 'data-ui-table-toolbar-action', 'required' => false, 'description' => 'Generated toolbar menu action marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Subcomponents
    |--------------------------------------------------------------------------
    */

    'subcomponents' => [
        'root' => [
            'component' => 'x-ui.data-table.toolbar',
            'description' => 'Toolbar root group wrapper.',
            'props' => ['ariaLabel', 'size'],
            'slots' => ['default'],
        ],
        'search' => [
            'component' => 'x-ui.data-table.toolbar.search',
            'description' => 'Toolbar search composition wrapper around x-ui.search.',
            'props' => ['id', 'name', 'labelText', 'placeholder', 'defaultValue', 'disabled', 'expanded', 'defaultExpanded', 'persistent', 'tabIndex', 'searchContainerClass', 'size'],
            'slots' => [],
        ],
        'content' => [
            'component' => 'x-ui.data-table.toolbar.content',
            'description' => 'Toolbar trailing content region.',
            'props' => [],
            'slots' => ['default'],
        ],
        'menu' => [
            'component' => 'x-ui.data-table.toolbar.menu',
            'description' => 'Toolbar overflow menu composition around x-ui.icon-button and triggerless x-ui.menu.',
            'props' => ['id', 'label', 'size', 'flipped', 'open', 'disabled'],
            'slots' => ['default'],
        ],
        'action' => [
            'component' => 'x-ui.data-table.toolbar.action',
            'description' => 'Toolbar overflow menu action item rendered as an anchor or button.',
            'props' => ['href', 'disabled', 'danger'],
            'slots' => ['default'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-table-toolbar',
        'required' => [
            'ui-table-toolbar',
        ],
        'optional' => [
            'ui-table-toolbar--xs',
            'ui-table-toolbar--sm',
            'ui-table-toolbar--lg',
            'ui-layout--size-xs',
            'ui-layout--size-sm',
            'ui-layout--size-lg',
            'ui-toolbar-search-container',
            'ui-toolbar-search-container-active',
            'ui-toolbar-search-container-disabled',
            'ui-toolbar-search-container-expandable',
            'ui-toolbar-search-container-persistent',
            'ui-toolbar-content',
            'ui-toolbar-action',
            'ui-toolbar-action__menu',
            'ui-toolbar-action__item',
            'ui-toolbar-action__item--danger',
            'ui-overflow-menu',
            'ui-overflow-menu-trigger',
            'ui-overflow-menu-options__btn',
            'ui-overflow-menu-options__option-content',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local data table toolbar classes',
            'toolbar search data attributes forwarded to the nested search input',
            'ad hoc table toolbar markup outside x-ui.data-table.toolbar.*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => [
            'label' => 'Default toolbar',
            'api' => ['component' => 'x-ui.data-table.toolbar'],
            'description' => 'Toolbar root wrapper with grouped content.',
        ],
        'with-search' => [
            'label' => 'With search',
            'api' => ['component' => 'x-ui.data-table.toolbar.search'],
            'description' => 'Toolbar search composition.',
        ],
        'expandable-search' => [
            'label' => 'Expandable search',
            'api' => ['persistent' => false],
            'class' => 'ui-toolbar-search-container-expandable',
            'description' => 'Search that can expand/collapse through search JavaScript.',
        ],
        'persistent-search' => [
            'label' => 'Persistent search',
            'api' => ['persistent' => true],
            'class' => 'ui-toolbar-search-container-persistent',
            'description' => 'Always-expanded toolbar search.',
        ],
        'menu' => [
            'label' => 'Overflow menu',
            'api' => ['component' => 'x-ui.data-table.toolbar.menu'],
            'class' => 'ui-toolbar-action',
            'description' => 'Toolbar overflow menu composition.',
        ],
        'danger-action' => [
            'label' => 'Danger action',
            'api' => ['danger' => true],
            'class' => 'ui-toolbar-action__item--danger',
            'description' => 'Danger menu action treatment.',
        ],
        'disabled-action' => [
            'label' => 'Disabled action',
            'api' => ['disabled' => true],
            'description' => 'Disabled toolbar action state.',
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
            'class' => 'ui-table-toolbar--xs',
            'description' => 'Extra small toolbar size.',
        ],
        'sm' => [
            'label' => 'Small',
            'api' => ['size' => 'sm'],
            'class' => 'ui-table-toolbar--sm',
            'description' => 'Small toolbar size.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'description' => 'Medium child search/menu size. The toolbar root does not emit a md root modifier.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => ['size' => 'lg'],
            'class' => 'ui-table-toolbar--lg',
            'description' => 'Large toolbar size.',
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
            'description' => 'Default toolbar state.',
        ],
        'search-collapsed' => [
            'label' => 'Search collapsed',
            'required' => false,
            'description' => 'Expandable toolbar search collapsed state.',
        ],
        'search-expanded' => [
            'label' => 'Search expanded',
            'required' => false,
            'description' => 'Toolbar search expanded state.',
        ],
        'search-persistent' => [
            'label' => 'Search persistent',
            'required' => false,
            'description' => 'Toolbar search remains expanded.',
        ],
        'menu-closed' => [
            'label' => 'Menu closed',
            'required' => false,
            'description' => 'Toolbar overflow menu hidden state.',
        ],
        'menu-open' => [
            'label' => 'Menu open',
            'required' => false,
            'description' => 'Toolbar overflow menu visible state.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Disabled search, menu trigger, or action state.',
        ],
        'danger' => [
            'label' => 'Danger',
            'required' => false,
            'description' => 'Danger action state.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for toolbar search input, clear button, menu trigger, and actions.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-table-toolbar',
            'ui-toolbar-search-container',
            'ui-toolbar-content',
            'ui-toolbar-action',
            'ui-overflow-menu',
        ],
        'component_tokens' => [
            'data-table-toolbar',
            'search',
            'menu',
            'action',
        ],
        'deprecated' => [
            'feature-local table toolbar wrappers',
            'feature-local table action menus',
            'ad hoc table toolbar markup outside x-ui.data-table.toolbar.*',
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
            'search',
            'menu',
            'icon-button',
        ],
        'uses' => [
            'icons' => [
                'overflow-menu--vertical',
            ],
            'components' => [
                'ui.search',
                'ui.icon-button',
                'ui.menu',
            ],
            'js_initializers' => [
                'search controls if installed',
                'menu behavior if installed',
                'data table toolbar behavior if installed',
            ],
        ],
        'blocks' => [
            'data-table',
            'table-filtering',
            'batch-actions',
            'admin-indexes',
            'reporting-tables',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Toolbar search input, clear button, menu trigger, and menu actions must be keyboard reachable unless disabled.',
            'Overflow menu keyboard behavior is owned by installed menu JavaScript.',
            'Expandable search keyboard behavior is owned by installed search JavaScript.',
        ],
        'aria' => [
            'Toolbar root renders role="group" with an accessible label.',
            'Toolbar search must keep labelText meaningful for the table filtering scope.',
            'Toolbar menu trigger must expose aria-haspopup="menu", aria-expanded, and aria-controls.',
            'Toolbar action items render role="menuitem".',
        ],
        'focus' => [
            'Toolbar controls must show visible focus.',
            'Menu open/close behavior must preserve or return focus intentionally.',
            'Search clear behavior should return focus to the search input.',
        ],
        'screen_reader' => [
            'Toolbar label should describe the toolbar relationship to the table.',
            'Search label and placeholder should describe filtering scope.',
            'Danger action labels must clearly describe the destructive outcome.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'classes' => [
            'feature-local data table toolbar classes',
            'feature-local toolbar search wrappers',
            'raw toolbar utility clusters',
        ],
        'components' => [
            'ad hoc data table toolbar markup outside x-ui.data-table.toolbar.*',
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
            'resources/views/components/ui/data-table/toolbar/index.blade.php',
            'resources/views/components/ui/data-table/toolbar/search.blade.php',
            'resources/views/components/ui/data-table/toolbar/content.blade.php',
            'resources/views/components/ui/data-table/toolbar/menu.blade.php',
            'resources/views/components/ui/data-table/toolbar/action.blade.php',
        ],
        'css' => [
            'resources/css/components/data-table-toolbar.css',
        ],
        'contract' => [
            'resources/views/components/ui/data-table/toolbar/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/data-table.md',
        ],
    ],
]);

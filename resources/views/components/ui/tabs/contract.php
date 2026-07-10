<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/tabs/contract.php
| Purpose: Tabs Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Tabs API that can be called from Blade,
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
        'slug' => 'tabs',
        'label' => 'Tabs',
        'component' => 'x-ui.tabs',
        'summary' => 'Array-driven tablist and tab panel component with line/contained variants, horizontal/vertical orientation, selected index control, activation mode markers, scrollable treatment, grid-aware treatment, full-width treatment, icons, secondary labels, disabled tabs, and dismissible markers.',
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
        'usage_context' => 'Use x-ui.tabs for in-page tab panels. Use x-shell.page-tabs for route/page navigation links that look like tabs. This component is intentionally array-driven and does not expose the full Carbon composable Tabs/TabList/Tab/TabPanel family.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Root tabs ID. A generated ID is used when omitted.'],
            ['name' => 'label', 'type' => 'string', 'required' => false, 'default' => 'Tabs', 'values' => [], 'description' => 'Accessible label for the tablist.'],
            ['name' => 'tabs', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Array of tab definitions. Each tab may include id, panel_id/panelId, label, panel_title/panelTitle, panel/content, selected, disabled, icon, icon_only/iconOnly, secondary/secondaryLabel, dismissible/dismissable, and dismiss_label/dismissLabel.'],
            ['name' => 'variant', 'type' => 'string', 'required' => false, 'default' => 'line', 'values' => ['line', 'contained'], 'description' => 'Tabs visual variant.'],
            ['name' => 'contained', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Carbon-style alias for variant="contained". When provided, it takes precedence over variant.', 'compatibility' => true],
            ['name' => 'orientation', 'type' => 'string', 'required' => false, 'default' => 'horizontal', 'values' => ['horizontal', 'vertical'], 'description' => 'Tablist orientation.'],
            ['name' => 'activation', 'type' => 'string', 'required' => false, 'default' => 'automatic', 'values' => ['automatic', 'manual'], 'description' => 'Keyboard activation mode marker for installed tabs JavaScript.'],
            ['name' => 'scrollable', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies scrollable tabs treatment.'],
            ['name' => 'gridAware', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies grid-aware tabs treatment.'],
            ['name' => 'fullWidth', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies full-width tabs treatment for contained tabs where supported by CSS.'],
            ['name' => 'selectedIndex', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Controlled selected tab index. Takes precedence over item-level selected and defaultSelectedIndex.'],
            ['name' => 'defaultSelectedIndex', 'type' => 'int|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Initial selected tab index when selectedIndex and item-level selected are not provided.'],
            ['name' => 'dismissible', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Global dismissible tab marker. Item-level dismissible/dismissable can override this per tab.'],
            ['name' => 'dismissable', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Carbon spelling compatibility alias for dismissible.', 'compatibility' => true],
            ['name' => 'size', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['sm', 'md', 'lg', null], 'description' => 'Optional tabs size treatment.'],
            ['name' => 'height', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional vertical tabs height style. Supports simple CSS length values.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'tabs', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-tabs', 'required' => true, 'description' => 'Generated root tabs marker.'],
            ['name' => 'data-ui-tabs-variant', 'required' => true, 'description' => 'Generated resolved variant marker.'],
            ['name' => 'data-ui-tabs-orientation', 'required' => true, 'description' => 'Generated resolved orientation marker.'],
            ['name' => 'data-ui-tabs-activation', 'required' => true, 'description' => 'Generated resolved activation marker.'],
            ['name' => 'data-ui-tabs-selected-index', 'required' => true, 'description' => 'Generated selected index marker.'],
            ['name' => 'data-ui-tabs-scrollable', 'required' => true, 'description' => 'Generated scrollable state marker.'],
            ['name' => 'data-ui-tabs-grid-aware', 'required' => true, 'description' => 'Generated grid-aware state marker.'],
            ['name' => 'data-ui-tabs-full-width', 'required' => true, 'description' => 'Generated full-width state marker.'],
            ['name' => 'data-ui-tabs-dismissible', 'required' => true, 'description' => 'Generated dismissible state marker.'],
            ['name' => 'data-ui-tabs-size', 'required' => false, 'description' => 'Generated size marker.'],
            ['name' => 'data-ui-tabs-list', 'required' => true, 'description' => 'Generated tablist marker.'],
            ['name' => 'data-ui-tabs-tab', 'required' => true, 'description' => 'Generated tab button marker.'],
            ['name' => 'data-ui-tabs-tab-index', 'required' => true, 'description' => 'Generated tab index marker.'],
            ['name' => 'data-ui-tabs-tab-selected', 'required' => true, 'description' => 'Generated tab selected marker.'],
            ['name' => 'data-ui-tabs-tab-disabled', 'required' => true, 'description' => 'Generated tab disabled marker.'],
            ['name' => 'data-ui-tabs-dismissible', 'required' => false, 'description' => 'Generated item dismissible marker.'],
            ['name' => 'data-ui-tabs-dismiss', 'required' => false, 'description' => 'Generated dismiss affordance marker.'],
            ['name' => 'data-ui-tabs-dismiss-label', 'required' => false, 'description' => 'Generated dismiss label marker.'],
            ['name' => 'data-ui-tabs-panels', 'required' => true, 'description' => 'Generated panels wrapper marker.'],
            ['name' => 'data-ui-tabs-panel', 'required' => true, 'description' => 'Generated tab panel marker.'],
            ['name' => 'data-ui-tabs-panel-index', 'required' => true, 'description' => 'Generated panel index marker.'],
            ['name' => 'data-ui-tabs-panel-selected', 'required' => true, 'description' => 'Generated panel selected marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-tabs',
        'required' => [
            'ui-tabs',
            'ui-tabs-list',
            'ui-tabs-tab',
            'ui-tabs-panels',
            'ui-tabs-panel',
        ],
        'optional' => [
            'ui-tabs-contained',
            'ui-tabs-vertical',
            'ui-tabs-scrollable',
            'ui-tabs-grid-aware',
            'ui-tabs-full-width',
            'ui-tabs-dismissible',
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-tabs-tab-selected',
            'ui-tabs-tab-disabled',
            'ui-tabs-tab-icon-only',
            'ui-tabs-tab-dismissible',
            'ui-tabs-tab-icon',
            'ui-tabs-tab-label',
            'ui-tabs-tab-secondary',
            'ui-tabs-tab-dismiss',
            'ui-tabs-panel-title',
            'ui-visually-hidden',
            'sr-only',
        ],
        'internal' => [],
        'deprecated' => [
            'route/page navigation implemented with x-ui.tabs instead of x-shell.page-tabs',
            'feature-local tab panel markup',
            'ad hoc tablists outside x-ui.tabs',
            'invented x-ui.tab or x-ui.tab-panel contracts without Blade components',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'line' => ['label' => 'Line', 'api' => ['variant' => 'line'], 'description' => 'Default line tabs variant.'],
        'contained' => ['label' => 'Contained', 'api' => ['variant' => 'contained'], 'class' => 'ui-tabs-contained', 'description' => 'Contained tabs variant.'],
        'horizontal' => ['label' => 'Horizontal', 'api' => ['orientation' => 'horizontal'], 'description' => 'Horizontal tablist orientation.'],
        'vertical' => ['label' => 'Vertical', 'api' => ['orientation' => 'vertical'], 'class' => 'ui-tabs-vertical', 'description' => 'Vertical tablist orientation.'],
        'scrollable' => ['label' => 'Scrollable', 'api' => ['scrollable' => true], 'class' => 'ui-tabs-scrollable', 'description' => 'Scrollable tabs treatment.'],
        'grid-aware' => ['label' => 'Grid aware', 'api' => ['gridAware' => true], 'class' => 'ui-tabs-grid-aware', 'description' => 'Grid-aware tabs treatment.'],
        'full-width' => ['label' => 'Full width', 'api' => ['fullWidth' => true], 'class' => 'ui-tabs-full-width', 'description' => 'Full-width contained tabs treatment.'],
        'dismissible' => ['label' => 'Dismissible', 'api' => ['dismissible' => true], 'class' => 'ui-tabs-dismissible', 'description' => 'Tabs with dismissible markers. Dynamic close behavior belongs to tabs JavaScript/caller.'],
        'icon-tab' => ['label' => 'Icon tab', 'api' => ['tabs' => [['label' => 'Settings', 'icon' => 'settings']]], 'class' => 'ui-tabs-tab-icon', 'description' => 'Tab with leading icon.'],
        'icon-only-tab' => ['label' => 'Icon-only tab', 'api' => ['tabs' => [['label' => 'Settings', 'icon' => 'settings', 'icon_only' => true]]], 'class' => 'ui-tabs-tab-icon-only', 'description' => 'Icon-only tab with visually hidden label.'],
        'secondary-label' => ['label' => 'Secondary label', 'api' => ['tabs' => [['label' => 'Details', 'secondary' => 'Optional']]], 'class' => 'ui-tabs-tab-secondary', 'description' => 'Tab with secondary label text.'],
        'manual-activation' => ['label' => 'Manual activation', 'api' => ['activation' => 'manual'], 'description' => 'Manual keyboard activation mode marker.'],
        'automatic-activation' => ['label' => 'Automatic activation', 'api' => ['activation' => 'automatic'], 'description' => 'Automatic keyboard activation mode marker.'],
        'controlled-selected-index' => ['label' => 'Controlled selected index', 'api' => ['selectedIndex' => 1], 'description' => 'Selected tab controlled through selectedIndex.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-layout--size-sm', 'description' => 'Small tabs size.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-layout--size-md', 'description' => 'Medium tabs size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-layout--size-lg', 'description' => 'Large tabs size.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default tabs state.'],
        'selected' => ['label' => 'Selected', 'required' => true, 'description' => 'Selected tab and visible panel state.'],
        'unselected' => ['label' => 'Unselected', 'required' => true, 'description' => 'Unselected tabs have tabindex -1 and panels are hidden.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled tab state.'],
        'manual-activation' => ['label' => 'Manual activation', 'required' => false, 'description' => 'Manual keyboard activation mode marker.'],
        'automatic-activation' => ['label' => 'Automatic activation', 'required' => false, 'description' => 'Automatic keyboard activation mode marker.'],
        'scrollable' => ['label' => 'Scrollable', 'required' => false, 'description' => 'Scrollable tabs state.'],
        'dismissible' => ['label' => 'Dismissible', 'required' => false, 'description' => 'Dismissible tab marker state.'],
        'vertical' => ['label' => 'Vertical', 'required' => false, 'description' => 'Vertical tabs state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for tab buttons and active panels.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-tabs',
            'ui-layout',
        ],
        'component_tokens' => [
            'tabs',
            'tablist',
            'tabpanel',
        ],
        'deprecated' => [
            'route/page navigation tabs implemented with x-ui.tabs',
            'feature-local tab panel markup',
            'ad hoc tablist markup outside x-ui.tabs',
            'component contracts for tab/tab-list/tab-panel without Blade implementations',
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
            'tooltip',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'dynamic tab icon prop',
                'close',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'tabs behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'settings-pages',
            'detail-pages',
            'dashboard-panels',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Horizontal tabs should support ArrowLeft, ArrowRight, Home, and End through installed tabs JavaScript.',
            'Vertical tabs should support ArrowUp, ArrowDown, Home, and End through installed tabs JavaScript.',
            'Manual activation should move focus without selecting until activation when JavaScript is installed.',
            'Disabled tabs must not be selected when an enabled tab is available.',
            'Dismissible tab removal behavior belongs to installed JavaScript or the caller.',
        ],
        'aria' => [
            'Tab list renders role="tablist" and aria-orientation.',
            'Each tab renders role="tab", aria-selected, aria-controls, and roving tabindex.',
            'Each panel renders role="tabpanel" and aria-labelledby.',
            'Unselected panels are hidden.',
            'Icon-only tabs must preserve a text label through visually hidden text.',
        ],
        'focus' => [
            'Tab buttons and panels must show visible focus.',
            'Focus movement and scroll-into-view behavior are owned by installed tabs JavaScript.',
        ],
        'screen_reader' => [
            'Tab labels must describe their panels.',
            'Do not use x-ui.tabs for route navigation; use x-shell.page-tabs.',
            'Dismissible tab labels must identify what will be dismissed when dynamic close behavior is installed.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'contained', 'replacement' => 'variant', 'description' => 'contained remains accepted as a Carbon-style alias for variant="contained".'],
            ['name' => 'dismissable', 'replacement' => 'dismissible', 'description' => 'dismissable remains accepted as Carbon spelling compatibility for dismissible.'],
            ['name' => 'panel_id', 'replacement' => 'panelId', 'description' => 'panel_id and panelId are both accepted in tab item arrays.'],
            ['name' => 'icon_only', 'replacement' => 'iconOnly', 'description' => 'icon_only and iconOnly are both accepted in tab item arrays.'],
            ['name' => 'dismissable item key', 'replacement' => 'dismissible', 'description' => 'dismissable remains accepted as a compatibility item key.'],
        ],
        'classes' => [
            'feature-local tabs classes',
            'raw tablist utility clusters',
        ],
        'components' => [
            'ad hoc tab panel markup outside x-ui.tabs',
            'route/page navigation implemented with x-ui.tabs instead of x-shell.page-tabs',
            'x-ui.tab, x-ui.tab-list, x-ui.tab-panel, or x-ui.tab-content until concrete Blade components exist',
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
            'resources/views/components/ui/tabs/index.blade.php',
        ],
        'css' => [
            'resources/css/components/tabs.css',
        ],
        'contract' => [
            'resources/views/components/ui/tabs/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/tabs.md',
        ],
    ],
]);

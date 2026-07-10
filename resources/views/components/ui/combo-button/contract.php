<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/combo-button/contract.php
| Purpose: Combo Button Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Combo Button API that can be called from
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
        'slug' => 'combo-button',
        'label' => 'Combo Button',
        'component' => 'x-ui.combo-button',
        'summary' => 'Primary action button with attached menu trigger and triggerless menu surface for additional related actions.',
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
        'usage_context' => 'Use x-ui.combo-button when one primary action needs an attached menu of related secondary actions. Use x-ui.button-set when actions are equal peers, and x-ui.menu-button when there is no primary action.',

        'props' => [
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Menu items forwarded to x-ui.menu.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Combo Button root ID. A generated ID is used when omitted.'],
            ['name' => 'menuId', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Attached menu ID. Defaults to the resolved root ID plus -menu.'],
            ['name' => 'label', 'type' => 'string|HtmlString', 'required' => false, 'default' => 'Apply', 'values' => [], 'description' => 'Primary action button label.'],
            ['name' => 'menuLabel', 'type' => 'string', 'required' => false, 'default' => 'Additional actions', 'values' => [], 'description' => 'Accessible label for the attached menu trigger and menu surface.'],
            ['name' => 'action', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional primary action metadata exposed through data-ui-combo-button-action for installed JavaScript.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Size forwarded to the primary button, icon trigger, and menu.'],
            ['name' => 'align', 'type' => 'string', 'required' => false, 'default' => 'bottom-end', 'values' => ['start', 'end', 'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'], 'description' => 'Legacy alias for placement.'],
            ['name' => 'placement', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'], 'description' => 'Canonical attached menu placement.'],
            ['name' => 'menuAlignment', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'], 'description' => 'Carbon-style alias for placement.', 'compatibility' => true],
            ['name' => 'tooltipAlignment', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional tooltip alignment forwarded to x-ui.icon-button align.'],
            ['name' => 'open', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Initial menu open state. Installed JavaScript owns runtime open/close behavior.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables both primary action and menu trigger.'],
            ['name' => 'loading', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Shows loading state on the primary action and disables both controls.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Menu content forwarded to x-ui.menu when manual menu children are required.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'combo-button', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-combo-button', 'required' => true, 'description' => 'Generated Combo Button root marker.'],
            ['name' => 'data-ui-combo-button-id', 'required' => true, 'description' => 'Generated resolved root ID marker.'],
            ['name' => 'data-ui-combo-button-menu-id', 'required' => true, 'description' => 'Generated resolved menu ID marker.'],
            ['name' => 'data-ui-combo-button-size', 'required' => true, 'description' => 'Generated size marker.'],
            ['name' => 'data-ui-combo-button-placement', 'required' => true, 'description' => 'Generated menu placement marker.'],
            ['name' => 'data-ui-combo-button-open', 'required' => true, 'description' => 'Generated open state marker.'],
            ['name' => 'data-ui-combo-button-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-combo-button-loading', 'required' => true, 'description' => 'Generated loading state marker.'],
            ['name' => 'data-ui-combo-button-primary', 'required' => true, 'description' => 'Generated primary action wrapper marker.'],
            ['name' => 'data-ui-combo-button-primary-action', 'required' => true, 'description' => 'Generated primary action marker.'],
            ['name' => 'data-ui-combo-button-action', 'required' => false, 'description' => 'Generated optional action metadata marker.'],
            ['name' => 'data-ui-combo-button-trigger', 'required' => true, 'description' => 'Generated menu trigger marker.'],
            ['name' => 'data-ui-combo-button-menu', 'required' => true, 'description' => 'Generated attached menu marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-combo-button',
        'required' => [
            'ui-combo-button',
            'ui-combo-button-primary',
            'ui-combo-button-trigger',
            'ui-combo-button-menu',
        ],
        'optional' => [
            'ui-combo-button-xs',
            'ui-combo-button-sm',
            'ui-combo-button-md',
            'ui-combo-button-lg',
            'ui-combo-button-open',
            'ui-combo-button-primary-action',
            'ui-combo-button-trigger-open',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local split button wrappers',
            'raw paired button/menu markup where x-ui.combo-button should be used',
            'ad hoc primary action plus menu trigger compositions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-combo-button', 'description' => 'Default Combo Button.'],
        'open' => ['label' => 'Open', 'api' => ['open' => true], 'class' => 'ui-combo-button-open', 'description' => 'Combo Button with menu initially open.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'description' => 'Disabled primary action and menu trigger.'],
        'loading' => ['label' => 'Loading', 'api' => ['loading' => true], 'description' => 'Loading primary action with disabled controls.'],
        'with-items' => ['label' => 'With items', 'api' => ['items' => [['label' => 'Edit', 'value' => 'edit']]], 'description' => 'Combo Button with array-driven menu items.'],
        'slot-menu' => ['label' => 'Slot menu', 'api' => ['slot' => 'default'], 'description' => 'Combo Button with manual slotted menu content.'],
        'top' => ['label' => 'Top', 'api' => ['placement' => 'top'], 'description' => 'Menu placed above the Combo Button.'],
        'top-start' => ['label' => 'Top start', 'api' => ['placement' => 'top-start'], 'description' => 'Menu placed top-start.'],
        'top-end' => ['label' => 'Top end', 'api' => ['placement' => 'top-end'], 'description' => 'Menu placed top-end.'],
        'bottom' => ['label' => 'Bottom', 'api' => ['placement' => 'bottom'], 'description' => 'Menu placed below the Combo Button.'],
        'bottom-start' => ['label' => 'Bottom start', 'api' => ['placement' => 'bottom-start'], 'description' => 'Menu placed bottom-start.'],
        'bottom-end' => ['label' => 'Bottom end', 'api' => ['placement' => 'bottom-end'], 'description' => 'Menu placed bottom-end.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-combo-button-xs', 'description' => 'Extra small Combo Button.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-combo-button-sm', 'description' => 'Small Combo Button.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-combo-button-md', 'description' => 'Medium Combo Button.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-combo-button-lg', 'description' => 'Large Combo Button.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default closed Combo Button state.'],
        'closed' => ['label' => 'Closed', 'required' => true, 'description' => 'Attached menu is closed.'],
        'open' => ['label' => 'Open', 'required' => false, 'description' => 'Attached menu is open.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Primary action and menu trigger disabled.'],
        'loading' => ['label' => 'Loading', 'required' => false, 'description' => 'Primary action loading state.'],
        'menu-attached' => ['label' => 'Menu attached', 'required' => true, 'description' => 'Menu trigger controls the attached menu surface.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for primary action, trigger, and menu items.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-combo-button',
            'ui-btn',
            'ui-menu',
        ],
        'component_tokens' => [
            'combo-button',
            'button',
            'icon-button',
            'menu',
            'attached-menu',
            'split-action',
        ],
        'deprecated' => [
            'feature-local split button wrappers',
            'raw action button plus menu trigger clusters',
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
            'button',
            'icon-button',
            'menu',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'chevron--down',
            ],
            'components' => [
                'ui.button',
                'ui.icon-button',
                'ui.menu',
            ],
            'js_initializers' => [
                'combo button behavior if installed',
                'menu behavior if installed',
            ],
        ],
        'blocks' => [
            'actions',
            'action-sets',
            'toolbars',
            'page-actions',
            'table-actions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Primary action and menu trigger must be keyboard reachable unless disabled.',
            'Menu keyboard behavior is owned by x-ui.menu and installed Menu JavaScript.',
            'Loading state disables both controls to prevent duplicate actions.',
        ],
        'aria' => [
            'Menu trigger owns aria-haspopup="menu" and aria-expanded.',
            'Menu trigger emits aria-controls only when the menu is open.',
            'Root emits aria-owns only when the attached menu is open.',
            'menuLabel must describe the additional actions menu.',
        ],
        'focus' => [
            'Primary action, menu trigger, and menu items must show visible focus.',
            'Installed JavaScript should manage focus transfer between trigger and menu.',
        ],
        'screen_reader' => [
            'Primary action label should describe the default action clearly.',
            'Menu label should distinguish additional actions from the primary action.',
            'Do not use Combo Button when all actions have equal priority.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'align', 'replacement' => 'placement', 'description' => 'align remains accepted as a legacy alias for placement.'],
            ['name' => 'menuAlignment', 'replacement' => 'placement', 'description' => 'menuAlignment remains accepted as a Carbon-style alias for placement.'],
        ],
        'classes' => [
            'feature-local combo button classes',
            'raw split button utility clusters',
        ],
        'components' => [
            'ad hoc split action controls outside x-ui.combo-button',
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
            'resources/views/components/ui/combo-button/index.blade.php',
        ],
        'css' => [
            'resources/css/components/combo-button.css',
            'resources/css/components/button.css',
            'resources/css/components/menu.css',
        ],
        'contract' => [
            'resources/views/components/ui/combo-button/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/combo-button.md',
        ],
    ],
]);

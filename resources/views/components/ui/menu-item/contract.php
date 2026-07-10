<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/menu-item/contract.php
| Purpose: Menu Item Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Menu Item API that can be called from
| Blade, validated by tooling, and consumed by menu, overflow menu, toolbar,
| shell, and action-list compositions.
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
        'slug' => 'menu-item',
        'label' => 'Menu Item',
        'component' => 'x-ui.menu-item',
        'summary' => 'Menu item primitive for action items, link items, selectable items, submenu triggers, danger items, shortcuts, icons, and dividers.',
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
        'usage_context' => 'Use x-ui.menu-item inside x-ui.menu, x-ui.menu-button, x-ui.overflow-menu, and menu-like toolbar compositions. Menu behavior, keyboard traversal, open/close state, submenu positioning, and action execution are owned by the parent menu controller or caller.',

        'props' => [
            [
                'name' => 'href',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional URL. When present and the item is not disabled, the item renders as an anchor.',
            ],
            [
                'name' => 'type',
                'type' => 'string',
                'required' => false,
                'default' => 'button',
                'values' => ['button', 'submit', 'reset', 'divider'],
                'description' => 'Native button type for button-rendered items, or divider for separator output.',
            ],
            [
                'name' => 'kind',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['default', 'danger'],
                'description' => 'Canonical menu item kind.',
            ],
            [
                'name' => 'semantic',
                'type' => 'string',
                'required' => false,
                'default' => 'neutral',
                'values' => ['neutral', 'primary', 'success', 'warning', 'danger', 'notice', 'info'],
                'description' => 'Compatibility semantic value. danger maps to danger kind.',
                'compatibility' => true,
            ],
            [
                'name' => 'tone',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['danger'],
                'description' => 'Compatibility tone value. danger maps to danger kind.',
                'compatibility' => true,
            ],
            [
                'name' => 'danger',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Compatibility boolean for danger kind.',
                'compatibility' => true,
            ],
            [
                'name' => 'dangerDescription',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Additional visually hidden description for danger items.',
            ],
            [
                'name' => 'action',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional action identifier emitted as a data hook.',
            ],
            [
                'name' => 'method',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['GET', 'POST', 'PATCH', 'DELETE'],
                'description' => 'Optional HTTP/action method emitted as a data hook.',
            ],
            [
                'name' => 'current',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Current item state. Link-rendered items expose aria-current.',
            ],
            [
                'name' => 'selected',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Selected state for selectable menu items.',
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Disables button items and removes disabled items from normal menu tab order.',
            ],
            [
                'name' => 'shortcut',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional visible shortcut text.',
            ],
            [
                'name' => 'icon',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional leading icon name from the internal icon registry.',
            ],
            [
                'name' => 'submenu',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Marks item as a submenu trigger and emits submenu trigger ARIA/data hooks.',
            ],
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'md',
                'values' => ['xs', 'sm', 'md', 'lg'],
                'description' => 'Menu item size marker.',
            ],
            [
                'name' => 'state',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional additional state marker used by transitional CSS/JS.',
            ],
            [
                'name' => 'selectionType',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['single', 'multiple', 'multi'],
                'description' => 'Selectable menu role. multi is accepted as compatibility alias for multiple.',
            ],
            [
                'name' => 'title',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional title attribute for long or truncated item text.',
            ],
            [
                'name' => 'reserveIndicator',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Reserves selection indicator space even when the item is not selected.',
            ],
            [
                'name' => 'closeOnActivate',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Emits menu-close data hook for non-submenu items.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Visible item label/content.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'description' => 'Generated component marker: menu-item or menu-divider.'],
            ['name' => 'data-ui-menu-item', 'required' => false, 'description' => 'Generated menu item marker.'],
            ['name' => 'data-ui-menu-divider', 'required' => false, 'description' => 'Generated divider marker.'],
            ['name' => 'data-ui-menu-close', 'required' => false, 'description' => 'Generated close-on-activate marker.'],
            ['name' => 'data-ui-menu-action', 'required' => false, 'description' => 'Generated action identifier marker.'],
            ['name' => 'data-ui-menu-method', 'required' => false, 'description' => 'Generated action method marker.'],
            ['name' => 'data-ui-menu-item-size', 'required' => false, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-menu-item-state', 'required' => false, 'description' => 'Generated resolved state marker.'],
            ['name' => 'data-ui-menu-submenu-trigger', 'required' => false, 'description' => 'Generated submenu trigger marker.'],
            ['name' => 'data-ui-current', 'required' => false, 'description' => 'Generated current state marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-menu-item',
        'required' => [
            'ui-menu-item',
        ],
        'optional' => [
            'ui-menu-item-divider',
            'ui-menu-divider',
            'ui-menu-item--disabled',
            'ui-menu-item--danger',
            'ui-menu-item--selected',
            'ui-menu-item--current',
            'ui-menu-item-xs',
            'ui-menu-item-sm',
            'ui-menu-item-md',
            'ui-menu-item-lg',
            'ui-menu-item-neutral',
            'ui-menu-item-primary',
            'ui-menu-item-success',
            'ui-menu-item-warning',
            'ui-menu-item-danger',
            'ui-menu-item-notice',
            'ui-menu-item-info',
            'ui-menu-item-disabled',
            'ui-menu-item-current',
            'is-selected',
            'ui-menu-item__selection-icon',
            'ui-menu-item-check',
            'ui-menu-item__selection-icon-svg',
            'ui-menu-item-check-icon',
            'ui-menu-item__icon',
            'ui-menu-item__icon-svg',
            'ui-menu-item__label',
            'ui-menu-item-label',
            'ui-menu-item__shortcut',
            'ui-menu-item-shortcut',
            'ui-menu-item-submenu',
            'ui-menu-item__shortcut-icon',
            'ui-menu-item-submenu-icon',
            'ui-visually-hidden',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local menu item classes',
            'ad hoc menu action markup outside x-ui.menu-item',
            'raw overflow menu item classes outside x-ui.menu-item',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'button-item' => [
            'label' => 'Button item',
            'api' => ['type' => 'button'],
            'description' => 'Non-navigation action item rendered as a button.',
        ],
        'link-item' => [
            'label' => 'Link item',
            'api' => ['href' => '#'],
            'description' => 'Navigation item rendered as an anchor.',
        ],
        'divider' => [
            'label' => 'Divider',
            'api' => ['type' => 'divider'],
            'class' => 'ui-menu-item-divider',
            'description' => 'Separator between menu groups.',
        ],
        'danger' => [
            'label' => 'Danger',
            'api' => ['kind' => 'danger'],
            'class' => 'ui-menu-item--danger',
            'description' => 'Danger/destructive menu item.',
        ],
        'selected' => [
            'label' => 'Selected',
            'api' => ['selected' => true],
            'class' => 'ui-menu-item--selected',
            'description' => 'Selected menu item.',
        ],
        'current' => [
            'label' => 'Current',
            'api' => ['current' => true],
            'class' => 'ui-menu-item--current',
            'description' => 'Current menu item.',
        ],
        'selectable-single' => [
            'label' => 'Selectable single',
            'api' => ['selectionType' => 'single'],
            'description' => 'Single-selection menu item using menuitemradio.',
        ],
        'selectable-multiple' => [
            'label' => 'Selectable multiple',
            'api' => ['selectionType' => 'multiple'],
            'description' => 'Multi-selection menu item using menuitemcheckbox.',
        ],
        'submenu-trigger' => [
            'label' => 'Submenu trigger',
            'api' => ['submenu' => true],
            'description' => 'Menu item that opens a submenu.',
        ],
        'with-icon' => [
            'label' => 'With icon',
            'api' => ['icon' => 'settings'],
            'description' => 'Menu item with leading icon.',
        ],
        'with-shortcut' => [
            'label' => 'With shortcut',
            'api' => ['shortcut' => '⌘K'],
            'description' => 'Menu item with shortcut text.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-menu-item-xs', 'description' => 'Extra small menu item.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-menu-item-sm', 'description' => 'Small menu item.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-menu-item-md', 'description' => 'Default menu item size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-menu-item-lg', 'description' => 'Large menu item.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled menu item state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled menu item state.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selected menu item state.'],
        'current' => ['label' => 'Current', 'required' => false, 'description' => 'Current item state.'],
        'danger' => ['label' => 'Danger', 'required' => false, 'description' => 'Danger/destructive item state.'],
        'submenu' => ['label' => 'Submenu', 'required' => false, 'description' => 'Submenu trigger state.'],
        'divider' => ['label' => 'Divider', 'required' => false, 'description' => 'Separator state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for menu items.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-menu-item',
            'ui-menu-divider',
        ],
        'component_tokens' => [
            'menu',
            'menu-item',
            'selection',
            'submenu',
        ],
        'deprecated' => [
            'feature-local menu item classes',
            'ad hoc overflow menu item markup',
            'raw menu action utility clusters',
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
                'checkmark',
                'chevron--right',
                'dynamic icon prop',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'menu behavior if installed',
            ],
        ],
        'blocks' => [
            'menu',
            'menu-button',
            'overflow-menu',
            'data-table-toolbar',
            'breadcrumb-overflow',
            'shell-actions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Menu items must participate in parent menu keyboard behavior.',
            'Disabled menu items must be removed from normal tab order.',
            'Submenu triggers must expose keyboard behavior through parent menu JavaScript.',
        ],
        'aria' => [
            'Default action items render role="menuitem".',
            'Single selectable items render role="menuitemradio".',
            'Multiple selectable items render role="menuitemcheckbox".',
            'Selectable items expose aria-checked.',
            'Submenu triggers expose aria-haspopup="menu" and aria-expanded.',
            'Danger descriptions are referenced through aria-describedby when provided.',
            'Decorative icons are hidden from assistive technology.',
        ],
        'focus' => [
            'Menu items must show visible focus when focused.',
            'Focus movement is owned by the parent menu controller.',
        ],
        'screen_reader' => [
            'Menu item labels must describe the action or destination.',
            'Danger items should include clear destructive wording and optional dangerDescription.',
            'Shortcut text must not be the only cue for action meaning.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'semantic', 'replacement' => 'kind', 'description' => 'semantic remains accepted as a compatibility input.'],
            ['name' => 'tone', 'replacement' => 'kind', 'description' => 'tone remains accepted as a compatibility input.'],
            ['name' => 'danger', 'replacement' => 'kind="danger"', 'description' => 'danger remains accepted as a compatibility input.'],
            ['name' => 'selectionType:multi', 'replacement' => 'selectionType="multiple"', 'description' => 'multi remains accepted as a compatibility alias.'],
        ],
        'classes' => [
            'feature-local menu item classes',
            'raw overflow menu item classes',
            'raw menu action utility clusters',
        ],
        'components' => [
            'ad hoc menu action markup outside x-ui.menu-item',
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
            'resources/views/components/ui/menu-item/index.blade.php',
        ],
        'css' => [
            'resources/css/components/menu.css',
        ],
        'contract' => [
            'resources/views/components/ui/menu-item/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/menu-item.md',
        ],
    ],
]);

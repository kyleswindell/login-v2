<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/contained-list-item/contract.php
| Purpose: Contained List Item Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Contained List Item API that can be called
| from Blade, validated by tooling, and consumed by contained list compositions.
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
        'slug' => 'contained-list-item',
        'label' => 'Contained List Item',
        'component' => 'x-ui.contained-list-item',
        'summary' => 'Contained list row item with title, description, metadata, optional link behavior, icon/status visual, selected/current/disabled states, and row actions.',
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
        'usage_context' => 'Use x-ui.contained-list-item inside x-ui.contained-list for list rows with optional icon/status visual, link behavior, metadata, or actions.',

        'props' => [
            ['name' => 'title', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Primary row title. If omitted, the default slot may be used.'],
            ['name' => 'description', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Supporting row description.'],
            ['name' => 'meta', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Trailing metadata content.'],
            ['name' => 'href', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional full-row link. Rendered only when enabled and no row actions are present.'],
            ['name' => 'icon', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional leading icon name rendered through x-ui.icon. Overrides status icon when supplied.'],
            ['name' => 'status', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['info', 'success', 'warning', 'error'], 'description' => 'Optional status icon treatment.'],
            ['name' => 'actionItems', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Optional row actions. One action renders inline; multiple actions render through x-ui.overflow-menu unless the actions slot is supplied.'],
            ['name' => 'selected', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Selected row state.'],
            ['name' => 'current', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Current row state. Emits aria-current.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled row state.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Fallback title content when title is omitted.'],
            ['name' => 'actions', 'required' => false, 'description' => 'Custom row action content.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'contained-list-item', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-contained-list-item', 'required' => true, 'description' => 'Generated contained list item marker.'],
            ['name' => 'data-ui-contained-list-item-interactive', 'required' => true, 'description' => 'Generated interactive/actionable marker.'],
            ['name' => 'data-ui-contained-list-item-status', 'required' => false, 'description' => 'Generated status marker.'],
            ['name' => 'data-ui-contained-list-item-actions', 'required' => true, 'description' => 'Generated actions presence marker.'],
            ['name' => 'data-ui-selected', 'required' => true, 'description' => 'Generated selected state marker.'],
            ['name' => 'data-ui-current', 'required' => true, 'description' => 'Generated current state marker.'],
            ['name' => 'data-ui-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-contained-list-item',
        'required' => [
            'ui-contained-list-item',
            'ui-contained-list-item-content',
            'ui-contained-list-item-text',
        ],
        'optional' => [
            'ui-contained-list-item--clickable',
            'ui-contained-list-item-with-icon',
            'ui-contained-list-item-with-actions',
            'ui-contained-list-item-selected',
            'ui-contained-list-item-current',
            'ui-contained-list-item-disabled',
            'ui-contained-list-status-info',
            'ui-contained-list-status-success',
            'ui-contained-list-status-warning',
            'ui-contained-list-status-error',
            'ui-contained-list-item-icon',
            'ui-contained-list-item-icon-svg',
            'ui-contained-list-item-title',
            'ui-contained-list-item-description',
            'ui-contained-list-item-meta',
            'ui-contained-list-item-actions',
        ],
        'internal' => [],
        'deprecated' => [
            'ad hoc contained list row markup',
            'raw row action clusters inside contained list items',
            'x-ui.status-icon inside contained list items',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-contained-list-item', 'description' => 'Default contained list item.'],
        'link' => ['label' => 'Link', 'api' => ['href' => '#'], 'class' => 'ui-contained-list-item--clickable', 'description' => 'Full-row link item when no actions are present.'],
        'with-icon' => ['label' => 'With icon', 'api' => ['icon' => 'document'], 'class' => 'ui-contained-list-item-with-icon', 'description' => 'Item with leading icon.'],
        'status-info' => ['label' => 'Info status', 'api' => ['status' => 'info'], 'class' => 'ui-contained-list-status-info', 'description' => 'Item with info status icon.'],
        'status-success' => ['label' => 'Success status', 'api' => ['status' => 'success'], 'class' => 'ui-contained-list-status-success', 'description' => 'Item with success status icon.'],
        'status-warning' => ['label' => 'Warning status', 'api' => ['status' => 'warning'], 'class' => 'ui-contained-list-status-warning', 'description' => 'Item with warning status icon.'],
        'status-error' => ['label' => 'Error status', 'api' => ['status' => 'error'], 'class' => 'ui-contained-list-status-error', 'description' => 'Item with error status icon.'],
        'with-actions' => ['label' => 'With actions', 'api' => ['actionItems' => [['label' => 'Edit']]], 'class' => 'ui-contained-list-item-with-actions', 'description' => 'Item with inline row action.'],
        'overflow-actions' => ['label' => 'Overflow actions', 'api' => ['actionItems' => [['label' => 'Edit'], ['label' => 'Delete']]], 'description' => 'Item with multiple row actions rendered through overflow menu.'],
        'selected' => ['label' => 'Selected', 'api' => ['selected' => true], 'class' => 'ui-contained-list-item-selected', 'description' => 'Selected item state.'],
        'current' => ['label' => 'Current', 'api' => ['current' => true], 'class' => 'ui-contained-list-item-current', 'description' => 'Current item state.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-contained-list-item-disabled', 'description' => 'Disabled item state.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default item state.'],
        'interactive' => ['label' => 'Interactive', 'required' => false, 'description' => 'Item is link/actionable.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selected item state.'],
        'current' => ['label' => 'Current', 'required' => false, 'description' => 'Current item state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled item state.'],
        'with-actions' => ['label' => 'With actions', 'required' => false, 'description' => 'Row action state.'],
        'with-status' => ['label' => 'With status', 'required' => false, 'description' => 'Status icon state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for links/actions.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-contained-list',
        ],
        'component_tokens' => [
            'contained-list-item',
            'contained-list',
            'row-action',
            'status-icon',
        ],
        'deprecated' => [
            'ad hoc contained list rows',
            'raw contained list action markup',
            'x-ui.status-icon inside contained list item',
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
            'overflow-menu',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'dynamic icon prop',
                'information--filled',
                'checkmark--filled',
                'warning--alt--filled',
                'error--filled',
            ],
            'components' => [
                'ui.icon',
                'ui.button',
                'ui.icon-button',
                'ui.overflow-menu',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'contained-list',
            'activity-lists',
            'settings-lists',
            'resource-lists',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Full-row links and row actions must be keyboard reachable unless disabled.',
            'Items with row actions should not nest interactive controls inside another interactive element.',
        ],
        'aria' => [
            'Current items emit aria-current.',
            'Disabled items expose aria-disabled.',
            'Decorative icons are hidden from assistive technology through x-ui.icon defaults.',
        ],
        'focus' => [
            'Links and actions must show visible focus.',
        ],
        'screen_reader' => [
            'Item title should clearly identify the row.',
            'Status meaning should not rely on icon artwork alone when status affects workflow meaning.',
            'Action labels must clearly describe the action for the row.',
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
            'feature-local contained list item classes',
            'raw contained list action utility clusters',
        ],
        'components' => [
            'ad hoc contained list rows outside x-ui.contained-list-item',
            'x-ui.status-icon usage inside contained list item',
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
            'resources/views/components/ui/contained-list-item/index.blade.php',
        ],
        'css' => [
            'resources/css/components/contained-list.css',
        ],
        'contract' => [
            'resources/views/components/ui/contained-list-item/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/contained-list.md',
        ],
    ],
]);

<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/contained-list/contract.php
| Purpose: Contained List Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Contained List API that can be called from
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
        'slug' => 'contained-list',
        'label' => 'Contained List',
        'component' => 'x-ui.contained-list',
        'summary' => 'Contained list region with optional header, description, header action, inset dividers, sticky header, loading state, empty state, array-driven items, and custom item slot support.',
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
        'usage_context' => 'Use x-ui.contained-list for grouped resource, activity, settings, or action lists. Use x-ui.structured-list for row/column comparison and x-ui.data-table for sortable/filterable/paginated tabular data.',

        'props' => [
            ['name' => 'title', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional contained list heading.'],
            ['name' => 'ariaLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label when no title or labelledBy value is available.'],
            ['name' => 'labelledBy', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'External accessible labelledby target. Takes precedence over generated title labelling.'],
            ['name' => 'description', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional header description.'],
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Array-driven item list. Each item may include title, description, meta, href, icon, status, actions, selected, current, and disabled.'],
            ['name' => 'variant', 'type' => 'string', 'required' => false, 'default' => 'on-page', 'values' => ['on-page', 'disclosed', 'elevated'], 'description' => 'Contained list visual variant. elevated is app-owned extension beyond Carbon on-page/disclosed kinds.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'md', 'lg', 'xl'], 'description' => 'Contained list size.'],
            ['name' => 'titleIcon', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional title icon name rendered through x-ui.icon.'],
            ['name' => 'headerActionLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label for optional header icon action.'],
            ['name' => 'headerActionIcon', 'type' => 'string', 'required' => false, 'default' => 'search', 'values' => [], 'description' => 'Icon name for optional header action.'],
            ['name' => 'headerActionHref', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional href for header action.'],
            ['name' => 'headerActionTooltip', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional tooltip text for header action. Falls back to headerActionLabel.'],
            ['name' => 'insetDividers', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Inset divider treatment.'],
            ['name' => 'stickyHeader', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Sticky header treatment.'],
            ['name' => 'loading', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Loading state. Emits aria-busy and loading row.'],
            ['name' => 'emptyTitle', 'type' => 'string', 'required' => false, 'default' => 'No items', 'values' => [], 'description' => 'Empty state title.'],
            ['name' => 'emptyDescription', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional empty state description.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Custom contained-list item rows, typically x-ui.contained-list-item instances.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'contained-list', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-contained-list', 'required' => true, 'description' => 'Generated contained list marker.'],
            ['name' => 'data-ui-contained-list-variant', 'required' => true, 'description' => 'Generated resolved variant marker.'],
            ['name' => 'data-ui-contained-list-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-contained-list-inset-dividers', 'required' => true, 'description' => 'Generated inset divider marker.'],
            ['name' => 'data-ui-contained-list-sticky-header', 'required' => true, 'description' => 'Generated sticky header marker.'],
            ['name' => 'data-ui-contained-list-loading', 'required' => true, 'description' => 'Generated loading state marker.'],
            ['name' => 'data-ui-contained-list-item-count', 'required' => true, 'description' => 'Generated array item count marker.'],
            ['name' => 'data-ui-contained-list-body', 'required' => true, 'description' => 'Generated body/list marker.'],
            ['name' => 'data-ui-contained-list-loading', 'required' => false, 'description' => 'Generated loading row marker.'],
            ['name' => 'data-ui-contained-list-empty', 'required' => false, 'description' => 'Generated empty row marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-contained-list',
        'required' => [
            'ui-contained-list',
            'ui-contained-list-body',
        ],
        'optional' => [
            'ui-contained-list--on-page',
            'ui-contained-list--disclosed',
            'ui-contained-list--elevated',
            'ui-contained-list--sm',
            'ui-contained-list--md',
            'ui-contained-list--lg',
            'ui-contained-list--xl',
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-layout--size-xl',
            'ui-contained-list-inset-dividers',
            'ui-contained-list--loading',
            'ui-contained-list--empty',
            'ui-contained-list-header',
            'ui-contained-list-header-sticky',
            'ui-contained-list-header-content',
            'ui-contained-list-title',
            'ui-contained-list-title-icon',
            'ui-contained-list-description',
            'ui-contained-list-header-actions',
            'ui-contained-list-state',
            'ui-contained-list-state-title',
            'ui-contained-list-state-description',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local contained list wrappers',
            'ad hoc contained list headers',
            'raw list/listitem markup outside x-ui.contained-list',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'on-page' => ['label' => 'On page', 'api' => ['variant' => 'on-page'], 'class' => 'ui-contained-list--on-page', 'description' => 'Default on-page contained list.'],
        'disclosed' => ['label' => 'Disclosed', 'api' => ['variant' => 'disclosed'], 'class' => 'ui-contained-list--disclosed', 'description' => 'Disclosed contained list treatment.'],
        'elevated' => ['label' => 'Elevated', 'api' => ['variant' => 'elevated'], 'class' => 'ui-contained-list--elevated', 'description' => 'App-owned elevated contained list treatment.'],
        'inset-dividers' => ['label' => 'Inset dividers', 'api' => ['insetDividers' => true], 'class' => 'ui-contained-list-inset-dividers', 'description' => 'Contained list with inset dividers.'],
        'sticky-header' => ['label' => 'Sticky header', 'api' => ['stickyHeader' => true], 'class' => 'ui-contained-list-header-sticky', 'description' => 'Contained list with sticky header.'],
        'with-title-icon' => ['label' => 'With title icon', 'api' => ['titleIcon' => 'folder'], 'class' => 'ui-contained-list-title-icon', 'description' => 'Contained list with title icon.'],
        'with-header-action' => ['label' => 'With header action', 'api' => ['headerActionLabel' => 'Search'], 'class' => 'ui-contained-list-header-actions', 'description' => 'Contained list with header icon action.'],
        'with-items' => ['label' => 'With items', 'api' => ['items' => [['title' => 'Item']]], 'description' => 'Contained list rendering array-driven items.'],
        'loading' => ['label' => 'Loading', 'api' => ['loading' => true], 'class' => 'ui-contained-list--loading', 'description' => 'Contained list loading state.'],
        'empty' => ['label' => 'Empty', 'api' => ['items' => []], 'class' => 'ui-contained-list--empty', 'description' => 'Contained list empty state.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-layout--size-sm', 'description' => 'Small contained list.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-layout--size-md', 'description' => 'Default contained list size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-layout--size-lg', 'description' => 'Large contained list.'],
        'xl' => ['label' => 'Extra large', 'api' => ['size' => 'xl'], 'class' => 'ui-layout--size-xl', 'description' => 'Extra large contained list.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default contained list state.'],
        'loading' => ['label' => 'Loading', 'required' => false, 'description' => 'Loading state.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'Empty state.'],
        'has-items' => ['label' => 'Has items', 'required' => false, 'description' => 'One or more items are rendered.'],
        'with-header' => ['label' => 'With header', 'required' => false, 'description' => 'Header content is rendered.'],
        'with-header-action' => ['label' => 'With header action', 'required' => false, 'description' => 'Header action is rendered.'],
        'inset-dividers' => ['label' => 'Inset dividers', 'required' => false, 'description' => 'Inset divider state.'],
        'sticky-header' => ['label' => 'Sticky header', 'required' => false, 'description' => 'Sticky header state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for header action and nested item actions.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-contained-list',
            'ui-layout',
        ],
        'component_tokens' => [
            'contained-list',
            'contained-list-item',
            'resource-list',
            'activity-list',
        ],
        'deprecated' => [
            'feature-local contained list wrappers',
            'ad hoc resource lists',
            'raw ul/li list surfaces outside x-ui.contained-list',
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
            'contained-list-item',
            'icon-button',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'dynamic titleIcon prop',
                'dynamic headerActionIcon prop',
            ],
            'components' => [
                'ui.icon',
                'ui.icon-button',
                'ui.contained-list-item',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'resource-lists',
            'activity-lists',
            'settings-lists',
            'navigation-adjacent-lists',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Header action and nested item actions must be keyboard reachable.',
            'Contained list itself is not a composite keyboard widget.',
        ],
        'aria' => [
            'Contained list section should have title, labelledBy, or ariaLabel.',
            'Body renders explicit list semantics.',
            'Loading state emits aria-busy.',
            'Header title is used as generated aria-labelledby when present.',
        ],
        'focus' => [
            'Header action and nested item actions must show visible focus.',
        ],
        'screen_reader' => [
            'Title or ariaLabel should identify the purpose of the list.',
            'Empty state should describe that no items are available.',
            'Loading state text should describe that list items are loading.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'variant:elevated', 'replacement' => 'variant="on-page" or variant="disclosed"', 'description' => 'elevated is app-owned extension and should be used only where CSS explicitly supports it.'],
        ],
        'classes' => [
            'feature-local contained list classes',
            'raw list utility clusters',
        ],
        'components' => [
            'ad hoc contained list surfaces outside x-ui.contained-list',
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
            'resources/views/components/ui/contained-list/index.blade.php',
        ],
        'css' => [
            'resources/css/components/contained-list.css',
        ],
        'contract' => [
            'resources/views/components/ui/contained-list/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/contained-list.md',
        ],
    ],
]);

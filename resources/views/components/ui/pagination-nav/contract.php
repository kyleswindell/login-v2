<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/pagination-nav/contract.php
| Purpose: Pagination Nav Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Pagination Nav API that can be called from
| Blade, validated by tooling, and consumed by navigation layouts or Patterns.
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
        'slug' => 'pagination-nav',
        'label' => 'Pagination Nav',
        'component' => 'x-ui.pagination-nav',
        'summary' => 'Pagination navigation component with previous/next controls, visible page buttons, overflow page selectors, loop mode, overflow disabling, size treatment, and live page status text.',
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
        'usage_context' => 'Use x-ui.pagination-nav when navigation is page-index based and does not need page-size selection. Use x-ui.pagination when total items, page size, and item range controls are required.',

        'props' => [
            ['name' => 'totalItems', 'type' => 'int|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Total number of pages/items represented by the pagination navigation.'],
            ['name' => 'page', 'type' => 'int|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Zero-based current page index.'],
            ['name' => 'itemsShown', 'type' => 'int|string', 'required' => false, 'default' => 10, 'values' => [], 'description' => 'Preferred number of page controls shown before overflow is introduced.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'lg', 'values' => ['sm', 'md', 'lg'], 'description' => 'Pagination Nav size treatment.'],
            ['name' => 'loop', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Allows previous/next navigation to loop at boundaries when JavaScript behavior is installed.'],
            ['name' => 'disableOverflow', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Renders disabled overflow selects without page options for very large datasets.'],
            ['name' => 'previousLabel', 'type' => 'string', 'required' => false, 'default' => 'Previous', 'values' => [], 'description' => 'Accessible label for the previous direction button.'],
            ['name' => 'nextLabel', 'type' => 'string', 'required' => false, 'default' => 'Next', 'values' => [], 'description' => 'Accessible label for the next direction button.'],
            ['name' => 'itemLabel', 'type' => 'string', 'required' => false, 'default' => 'Page', 'values' => [], 'description' => 'Accessible page item label.'],
            ['name' => 'activeLabel', 'type' => 'string', 'required' => false, 'default' => 'Active', 'values' => [], 'description' => 'Accessible active page prefix.'],
            ['name' => 'ofLabel', 'type' => 'string', 'required' => false, 'default' => 'of', 'values' => [], 'description' => 'Localized connector used in the live page status text.'],
            ['name' => 'tooltipAlignment', 'type' => 'string', 'required' => false, 'default' => 'center', 'values' => ['start', 'center', 'end'], 'description' => 'Tooltip alignment metadata for previous/next direction buttons.'],
            ['name' => 'tooltipPosition', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['top', 'right', 'bottom', 'left'], 'description' => 'Tooltip position metadata for previous/next direction buttons.'],
        ],

        'slots' => [
            ['name' => 'previousIcon', 'required' => false, 'description' => 'Optional replacement icon for the previous direction button.'],
            ['name' => 'nextIcon', 'required' => false, 'description' => 'Optional replacement icon for the next direction button.'],
            ['name' => 'overflowIcon', 'required' => false, 'description' => 'Optional replacement icon for overflow selectors.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'pagination-nav', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-pagination-nav', 'required' => true, 'description' => 'Generated Pagination Nav marker.'],
            ['name' => 'data-ui-pagination-nav-page', 'required' => true, 'description' => 'Generated current zero-based page marker.'],
            ['name' => 'data-ui-pagination-nav-total-items', 'required' => true, 'description' => 'Generated total page count marker.'],
            ['name' => 'data-ui-pagination-nav-items-shown', 'required' => true, 'description' => 'Generated items shown marker.'],
            ['name' => 'data-ui-pagination-nav-size', 'required' => true, 'description' => 'Generated size marker.'],
            ['name' => 'data-ui-pagination-nav-loop', 'required' => true, 'description' => 'Generated loop marker.'],
            ['name' => 'data-ui-pagination-nav-disable-overflow', 'required' => true, 'description' => 'Generated overflow disabling marker.'],
            ['name' => 'data-ui-pagination-nav-list', 'required' => true, 'description' => 'Generated list marker.'],
            ['name' => 'data-ui-pagination-nav-page-active', 'required' => false, 'description' => 'Generated page item active marker.'],
            ['name' => 'data-ui-pagination-nav-overflow', 'required' => false, 'description' => 'Generated overflow select marker.'],
            ['name' => 'data-ui-pagination-nav-direction', 'required' => false, 'description' => 'Generated previous/next direction marker.'],
            ['name' => 'data-ui-pagination-nav-accessibility-label', 'required' => true, 'description' => 'Generated live status label marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subcomponents
    |--------------------------------------------------------------------------
    */

    'subcomponents' => [
        'direction-button' => [
            'label' => 'Pagination Nav Direction Button',
            'component' => 'x-ui.pagination-nav.direction-button',
            'description' => 'Previous or next icon-only direction button.',
            'props' => [
                ['name' => 'direction', 'type' => 'string', 'required' => false, 'default' => 'forward', 'values' => ['forward', 'backward'], 'description' => 'Direction represented by the button.'],
                ['name' => 'label', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label. Defaults from direction when omitted.'],
                ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled state.'],
                ['name' => 'tooltipAlignment', 'type' => 'string', 'required' => false, 'default' => 'center', 'values' => ['start', 'center', 'end'], 'description' => 'Tooltip alignment metadata.'],
                ['name' => 'tooltipPosition', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['top', 'right', 'bottom', 'left'], 'description' => 'Tooltip position metadata.'],
            ],
        ],
        'item' => [
            'label' => 'Pagination Nav Item',
            'component' => 'x-ui.pagination-nav.item',
            'description' => 'One visible page button.',
            'props' => [
                ['name' => 'page', 'type' => 'int|string', 'required' => true, 'default' => null, 'values' => [], 'description' => 'One-based visible page number.'],
                ['name' => 'pageIndex', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Zero-based page index. Defaults to page - 1.'],
                ['name' => 'active', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks the page as current.'],
                ['name' => 'itemLabel', 'type' => 'string', 'required' => false, 'default' => 'Page', 'values' => [], 'description' => 'Accessible page item label.'],
                ['name' => 'activeLabel', 'type' => 'string', 'required' => false, 'default' => 'Active', 'values' => [], 'description' => 'Accessible active page prefix.'],
            ],
        ],
        'overflow' => [
            'label' => 'Pagination Nav Overflow',
            'component' => 'x-ui.pagination-nav.overflow',
            'description' => 'Overflow page selector or single hidden page fallback item.',
            'props' => [
                ['name' => 'fromIndex', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Zero-based hidden page start index.'],
                ['name' => 'count', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Number of hidden pages represented by this overflow.'],
                ['name' => 'disableOverflow', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Renders disabled overflow select when true and count is greater than one.'],
                ['name' => 'itemLabel', 'type' => 'string', 'required' => false, 'default' => 'Page', 'values' => [], 'description' => 'Accessible page item label.'],
                ['name' => 'activeLabel', 'type' => 'string', 'required' => false, 'default' => 'Active', 'values' => [], 'description' => 'Accessible active page prefix.'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-pagination-nav',
        'required' => [
            'ui-pagination-nav',
            'ui-pagination-nav__list',
            'ui-pagination-nav__list-item',
            'ui-pagination-nav__page',
            'ui-pagination-nav__accessibility-label',
        ],
        'optional' => [
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-pagination-nav__page--active',
            'ui-pagination-nav__page--select',
            'ui-pagination-nav__select',
            'ui-pagination-nav__select-icon-wrapper',
            'ui-pagination-nav__select-icon',
            'ui-button',
            'ui-button--ghost',
            'ui-button--icon-only',
            'ui-btn',
            'ui-btn--ghost',
            'ui-btn--icon-only',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local pagination navigation controls',
            'raw page-number button clusters where x-ui.pagination-nav should be used',
            'x-ui.pagination-nav.root as canonical component; use x-ui.pagination-nav instead',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-pagination-nav', 'description' => 'Default Pagination Nav.'],
        'loop' => ['label' => 'Loop', 'api' => ['loop' => true], 'description' => 'Previous/next navigation loops at boundaries when JavaScript behavior is installed.'],
        'disable-overflow' => ['label' => 'Disable overflow', 'api' => ['disableOverflow' => true], 'description' => 'Overflow select controls are disabled and do not render page options.'],
        'with-overflow' => ['label' => 'With overflow', 'api' => ['totalItems' => 20, 'itemsShown' => 5], 'class' => 'ui-pagination-nav__page--select', 'description' => 'Pagination Nav with overflow selectors.'],
        'first-page' => ['label' => 'First page', 'api' => ['page' => 0], 'description' => 'Pagination Nav at first page.'],
        'middle-page' => ['label' => 'Middle page', 'api' => ['page' => 5, 'totalItems' => 12], 'description' => 'Pagination Nav at a middle page.'],
        'last-page' => ['label' => 'Last page', 'api' => ['page' => 9, 'totalItems' => 10], 'description' => 'Pagination Nav at last page.'],
        'custom-labels' => ['label' => 'Custom labels', 'api' => ['previousLabel' => 'Back', 'nextLabel' => 'Forward'], 'description' => 'Pagination Nav with customized accessible labels.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-layout--size-sm', 'description' => 'Small Pagination Nav.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-layout--size-md', 'description' => 'Medium Pagination Nav.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-layout--size-lg', 'description' => 'Large Pagination Nav.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default Pagination Nav state.'],
        'first-page' => ['label' => 'First page', 'required' => true, 'description' => 'Current page is first page.'],
        'middle-page' => ['label' => 'Middle page', 'required' => false, 'description' => 'Current page is between first and last page.'],
        'last-page' => ['label' => 'Last page', 'required' => false, 'description' => 'Current page is last page.'],
        'loop-enabled' => ['label' => 'Loop enabled', 'required' => false, 'description' => 'Loop mode enabled.'],
        'overflow-enabled' => ['label' => 'Overflow enabled', 'required' => false, 'description' => 'Overflow selectors are rendered with page options.'],
        'overflow-disabled' => ['label' => 'Overflow disabled', 'required' => false, 'description' => 'Overflow selectors are disabled.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for page, overflow, and direction controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-pagination-nav',
            'ui-layout',
        ],
        'component_tokens' => [
            'pagination-nav',
            'pagination',
            'page-navigation',
            'overflow-pages',
        ],
        'deprecated' => [
            'feature-local pagination navigation wrappers',
            'raw page number controls',
            'x-ui.pagination-nav.root as canonical entrypoint',
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
            'tooltip',
            'forms',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'caret--left',
                'caret--right',
                'overflow-menu--horizontal',
            ],
            'components' => [
                'ui.icon',
                'ui.pagination-nav.direction-button',
                'ui.pagination-nav.item',
                'ui.pagination-nav.overflow',
            ],
            'js_initializers' => [
                'pagination navigation behavior if installed',
            ],
        ],
        'blocks' => [
            'pagination',
            'search-results',
            'table-navigation',
            'collection-navigation',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Previous, next, page, and overflow select controls must be keyboard reachable unless disabled.',
            'Installed pagination JavaScript owns client-side page changes.',
            'Disabled direction buttons must not be interactive.',
        ],
        'aria' => [
            'Active page button must emit aria-current="page".',
            'Previous and next direction buttons must have accessible labels.',
            'Overflow select controls must have accessible labels.',
            'Live page status text must use aria-live="polite" and aria-atomic="true".',
            'Caller may add aria-label or aria-labelledby to the nav when multiple navigation landmarks exist.',
        ],
        'focus' => [
            'Page buttons, direction buttons, and overflow selects must show visible focus.',
        ],
        'screen_reader' => [
            'Active page text should announce both active state and page label.',
            'Live status should announce current page and total pages.',
            'Direction labels should be localized when the UI language changes.',
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
            'feature-local pagination nav classes',
            'raw pagination nav utility clusters',
        ],
        'components' => [
            'x-ui.pagination-nav.root as the canonical entrypoint; use x-ui.pagination-nav instead',
            'ad hoc page number navigation outside x-ui.pagination-nav',
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
            'resources/views/components/ui/pagination-nav/index.blade.php',
            'resources/views/components/ui/pagination-nav/direction-button.blade.php',
            'resources/views/components/ui/pagination-nav/item.blade.php',
            'resources/views/components/ui/pagination-nav/overflow.blade.php',
        ],
        'css' => [
            'resources/css/components/pagination.css',
        ],
        'contract' => [
            'resources/views/components/ui/pagination-nav/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/pagination-nav.md',
        ],
    ],
]);

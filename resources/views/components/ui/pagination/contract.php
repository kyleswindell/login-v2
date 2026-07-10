<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/pagination/contract.php
| Purpose: Pagination Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Pagination API that can be called from
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
        'slug' => 'pagination',
        'label' => 'Pagination',
        'component' => 'x-ui.pagination',
        'summary' => 'Page navigation component with pagination bar, pagination-nav, page size selection, item range text, previous/next controls, numeric pages, overflow menus, responsive flags, loop behavior, and interactive mode.',
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
        'usage_context' => 'Use x-ui.pagination when a table, list, search result, or content region is split into pages. The paginated content remains owned by the consuming component or Pattern.',

        'props' => [
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Navigation root ID. A generated pagination-* ID is used when omitted.',
            ],
            [
                'name' => 'label',
                'type' => 'string',
                'required' => false,
                'default' => 'Pagination',
                'values' => [],
                'description' => 'Accessible label for the pagination nav landmark.',
            ],
            [
                'name' => 'variant',
                'type' => 'string',
                'required' => false,
                'default' => 'pagination',
                'values' => ['pagination', 'bar', 'pagination-nav', 'nav', 'full', 'compact'],
                'description' => 'Pagination surface variant. pagination/bar resolves to pagination; pagination-nav/nav/full/compact resolves to pagination-nav.',
            ],
            [
                'name' => 'size',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['sm', 'md', 'lg'],
                'description' => 'Pagination size. Defaults to sm when density is compact, otherwise md.',
            ],
            [
                'name' => 'density',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['compact'],
                'description' => 'Compatibility density shortcut. compact resolves size to sm when size is not provided.',
                'compatibility' => true,
            ],
            [
                'name' => 'alignment',
                'type' => 'string',
                'required' => false,
                'default' => 'right',
                'values' => ['left', 'right'],
                'description' => 'Pagination alignment.',
            ],
            [
                'name' => 'currentPage',
                'type' => 'int|string',
                'required' => false,
                'default' => 1,
                'values' => [],
                'description' => 'Current page number.',
            ],
            [
                'name' => 'lastPage',
                'type' => 'int|string',
                'required' => false,
                'default' => 1,
                'values' => [],
                'description' => 'Fallback last page when totalPages and derived total/page size are unavailable.',
            ],
            [
                'name' => 'totalPages',
                'type' => 'int|string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Explicit total page count.',
            ],
            [
                'name' => 'totalItems',
                'type' => 'int|string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Total item count used to derive last page and item range.',
            ],
            [
                'name' => 'total',
                'type' => 'int|string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Compatibility alias for totalItems.',
                'compatibility' => true,
            ],
            [
                'name' => 'perPage',
                'type' => 'int|string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Compatibility alias for pageSize.',
                'compatibility' => true,
            ],
            [
                'name' => 'pageSize',
                'type' => 'int|string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Current items-per-page value.',
            ],
            [
                'name' => 'pageSizeOptions',
                'type' => 'array',
                'required' => false,
                'default' => [],
                'values' => [],
                'description' => 'Page size options as scalar values or value/label arrays.',
            ],
            [
                'name' => 'pageSizes',
                'type' => 'array|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Compatibility alias for pageSizeOptions.',
                'compatibility' => true,
            ],
            [
                'name' => 'itemsPerPageText',
                'type' => 'string',
                'required' => false,
                'default' => 'Items per page:',
                'values' => [],
                'description' => 'Visible page-size select label.',
            ],
            [
                'name' => 'backwardText',
                'type' => 'string',
                'required' => false,
                'default' => 'Previous page',
                'values' => [],
                'description' => 'Accessible label for previous page control.',
            ],
            [
                'name' => 'forwardText',
                'type' => 'string',
                'required' => false,
                'default' => 'Next page',
                'values' => [],
                'description' => 'Accessible label for next page control.',
            ],
            [
                'name' => 'pageNumberText',
                'type' => 'string',
                'required' => false,
                'default' => 'Page number',
                'values' => [],
                'description' => 'Accessible label for page number select.',
            ],
            [
                'name' => 'baseUrl',
                'type' => 'string',
                'required' => false,
                'default' => '#',
                'values' => [],
                'description' => 'Base URL used for link-mode page URLs.',
            ],
            [
                'name' => 'pageName',
                'type' => 'string',
                'required' => false,
                'default' => 'page',
                'values' => [],
                'description' => 'Query parameter name for page links.',
            ],
            [
                'name' => 'pageSizeName',
                'type' => 'string',
                'required' => false,
                'default' => 'per_page',
                'values' => [],
                'description' => 'Name attribute for page-size select.',
            ],
            [
                'name' => 'showItemsPerPage',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Controls page-size segment visibility.',
            ],
            [
                'name' => 'showItemRange',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Controls item range text visibility.',
            ],
            [
                'name' => 'showPageSelector',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Controls page selector visibility in pagination bar variant.',
            ],
            [
                'name' => 'loop',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Loops previous/next controls from first to last and last to first.',
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Disables pagination controls.',
            ],
            [
                'name' => 'responsive',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Applies responsive pagination treatment.',
            ],
            [
                'name' => 'interactive',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Renders buttons instead of anchors for JavaScript-controlled pagination behavior.',
            ],
            [
                'name' => 'smallBreakpoint',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies small-breakpoint pagination treatment.',
            ],
            [
                'name' => 'window',
                'type' => 'int|string',
                'required' => false,
                'default' => 1,
                'values' => [1, 2, 3],
                'description' => 'Numeric page window around current page for pagination-nav. Clamped from 1 to 3.',
            ],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'pagination', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-pagination', 'required' => true, 'description' => 'Generated root pagination marker.'],
            ['name' => 'data-ui-pagination-variant', 'required' => true, 'description' => 'Generated resolved variant marker.'],
            ['name' => 'data-ui-pagination-compat-variant', 'required' => false, 'description' => 'Generated compatibility variant marker for full/compact.'],
            ['name' => 'data-ui-pagination-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-pagination-alignment', 'required' => true, 'description' => 'Generated resolved alignment marker.'],
            ['name' => 'data-ui-pagination-current', 'required' => true, 'description' => 'Generated current page marker.'],
            ['name' => 'data-ui-pagination-total-pages', 'required' => true, 'description' => 'Generated total pages marker.'],
            ['name' => 'data-ui-pagination-total-items', 'required' => false, 'description' => 'Generated total items marker.'],
            ['name' => 'data-ui-pagination-page-size-value', 'required' => true, 'description' => 'Generated current page size marker.'],
            ['name' => 'data-ui-pagination-window', 'required' => true, 'description' => 'Generated page window marker.'],
            ['name' => 'data-ui-pagination-interactive', 'required' => false, 'description' => 'Generated interactive button-mode marker.'],
            ['name' => 'data-ui-pagination-loop', 'required' => false, 'description' => 'Generated loop marker.'],
            ['name' => 'data-ui-pagination-disabled', 'required' => false, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-pagination-responsive', 'required' => false, 'description' => 'Generated responsive marker.'],
            ['name' => 'data-ui-pagination-small-breakpoint', 'required' => false, 'description' => 'Generated small-breakpoint marker.'],
            ['name' => 'data-ui-pagination-bar', 'required' => false, 'description' => 'Generated pagination bar marker.'],
            ['name' => 'data-ui-pagination-nav', 'required' => false, 'description' => 'Generated pagination nav marker.'],
            ['name' => 'data-ui-pagination-prev', 'required' => true, 'description' => 'Generated previous control marker.'],
            ['name' => 'data-ui-pagination-next', 'required' => true, 'description' => 'Generated next control marker.'],
            ['name' => 'data-ui-pagination-page', 'required' => false, 'description' => 'Generated page control marker.'],
            ['name' => 'data-ui-pagination-overflow', 'required' => false, 'description' => 'Generated overflow wrapper marker.'],
            ['name' => 'data-ui-pagination-overflow-trigger', 'required' => false, 'description' => 'Generated overflow trigger marker.'],
            ['name' => 'data-ui-pagination-overflow-menu', 'required' => false, 'description' => 'Generated overflow menu marker.'],
            ['name' => 'data-ui-pagination-overflow-page', 'required' => false, 'description' => 'Generated overflow page item marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-pagination',
        'required' => [
            'ui-pagination',
        ],
        'optional' => [
            'ui-pagination-pagination',
            'ui-pagination-pagination-nav',
            'ui-pagination-sm',
            'ui-pagination-md',
            'ui-pagination-lg',
            'ui-pagination-align-left',
            'ui-pagination-align-right',
            'ui-pagination-disabled',
            'ui-pagination-responsive',
            'ui-pagination-small-breakpoint',
            'ui-pagination-bar',
            'ui-pagination-left',
            'ui-pagination-right',
            'ui-pagination-page-size-segment',
            'ui-pagination-page-select-segment',
            'ui-pagination-select-field',
            'ui-pagination-page-size-select-field',
            'ui-pagination-page-number-select-field',
            'ui-pagination-label',
            'ui-pagination-range-segment',
            'ui-pagination-total-pages-label',
            'ui-pagination-controls',
            'ui-pagination-control',
            'ui-pagination-control-icon',
            'ui-pagination-control-cell',
            'ui-pagination-icon',
            'ui-pagination-nav-shell',
            'ui-pagination-list',
            'ui-pagination-item',
            'ui-pagination-item-page',
            'ui-pagination-item-current',
            'ui-pagination-item-edge',
            'ui-pagination-item-neighbor',
            'ui-pagination-item-overflow',
            'ui-pagination-page',
            'ui-pagination-overflow',
            'ui-pagination-overflow-trigger',
            'ui-pagination-overflow-menu',
            'ui-pagination-overflow-item',
            'is-disabled',
            'is-current',
        ],
        'internal' => [],
        'deprecated' => [
            'full variant as public canonical name',
            'compact variant as public canonical name',
            'feature-local pagination controls',
            'ad hoc page navigation markup outside x-ui.pagination',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'pagination' => [
            'label' => 'Pagination bar',
            'api' => ['variant' => 'pagination'],
            'class' => 'ui-pagination-pagination',
            'description' => 'Pagination bar with page size, range, page selector, and previous/next controls.',
        ],
        'pagination-nav' => [
            'label' => 'Pagination nav',
            'api' => ['variant' => 'pagination-nav'],
            'class' => 'ui-pagination-pagination-nav',
            'description' => 'Numeric page navigation with previous/next controls and overflow menu.',
        ],
        'interactive' => [
            'label' => 'Interactive',
            'api' => ['interactive' => true],
            'description' => 'Button-mode pagination for JavaScript-controlled pagination behavior.',
        ],
        'link-mode' => [
            'label' => 'Link mode',
            'api' => ['interactive' => false],
            'description' => 'Anchor-mode pagination using generated URLs.',
        ],
        'loop' => [
            'label' => 'Looping',
            'api' => ['loop' => true],
            'description' => 'Previous/next controls loop between first and last page.',
        ],
        'responsive' => [
            'label' => 'Responsive',
            'api' => ['responsive' => true],
            'class' => 'ui-pagination-responsive',
            'description' => 'Responsive pagination treatment.',
        ],
        'small-breakpoint' => [
            'label' => 'Small breakpoint',
            'api' => ['smallBreakpoint' => true],
            'class' => 'ui-pagination-small-breakpoint',
            'description' => 'Small-breakpoint pagination treatment.',
        ],
        'overflow-menu' => [
            'label' => 'Overflow menu',
            'api' => ['window' => 1],
            'description' => 'Overflow menu for hidden page ranges in pagination-nav.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => [
            'label' => 'Small',
            'api' => ['size' => 'sm'],
            'class' => 'ui-pagination-sm',
            'description' => 'Small pagination size.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'class' => 'ui-pagination-md',
            'description' => 'Default pagination size.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => ['size' => 'lg'],
            'class' => 'ui-pagination-lg',
            'description' => 'Large pagination size.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled pagination state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'All controls are unavailable.'],
        'current-page' => ['label' => 'Current page', 'required' => true, 'description' => 'Current page uses aria-current in pagination-nav.'],
        'previous-disabled' => ['label' => 'Previous disabled', 'required' => false, 'description' => 'Previous control disabled at first page unless loop is enabled.'],
        'next-disabled' => ['label' => 'Next disabled', 'required' => false, 'description' => 'Next control disabled at last page unless loop is enabled.'],
        'overflow-closed' => ['label' => 'Overflow closed', 'required' => false, 'description' => 'Overflow menu hidden state.'],
        'overflow-open' => ['label' => 'Overflow open', 'required' => false, 'description' => 'Overflow menu open state owned by pagination JavaScript.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for controls, selects, page links/buttons, and overflow menu items.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-pagination',
            'ui-pagination-control',
            'ui-pagination-page',
            'ui-pagination-overflow',
        ],
        'component_tokens' => [
            'pagination',
            'select',
            'icon-button',
        ],
        'deprecated' => [
            'feature-local pagination control styles',
            'ad hoc pagination links outside x-ui.pagination',
            'pagination used for linear workflow progress',
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
            'select',
        ],
        'uses' => [
            'icons' => [
                'chevron--left',
                'chevron--right',
            ],
            'components' => [
                'ui.icon',
                'ui.select',
            ],
            'js_initializers' => [
                'pagination overflow and interactive behavior if installed',
            ],
        ],
        'blocks' => [
            'data-table',
            'search-results',
            'lists',
            'table-patterns',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Pagination controls must be keyboard reachable unless disabled.',
            'Disabled controls use aria-disabled and are removed from tab order.',
            'Overflow menu items must be keyboard reachable when the overflow menu is open.',
        ],
        'aria' => [
            'Root renders a nav landmark with aria-label.',
            'Current page uses aria-current="page".',
            'Previous and next controls require accessible labels.',
            'Overflow trigger uses aria-haspopup="menu", aria-expanded, and aria-controls.',
            'Overflow menu renders role="menu" and items render role="menuitem".',
            'Pagination icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Previous, next, page, select, overflow trigger, and overflow item controls must show visible focus.',
            'JavaScript interactive behavior should preserve or move focus intentionally when controls become disabled.',
        ],
        'screen_reader' => [
            'Item range text must communicate the current slice when total items are known.',
            'Unknown totals should communicate page position without implying exact item count.',
            'Pagination must not be used as a substitute for progress indicator or step navigation.',
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
                'name' => 'variant:bar',
                'replacement' => 'variant="pagination"',
                'description' => 'bar remains accepted as a compatibility alias for pagination.',
            ],
            [
                'name' => 'variant:nav',
                'replacement' => 'variant="pagination-nav"',
                'description' => 'nav remains accepted as a compatibility alias for pagination-nav.',
            ],
            [
                'name' => 'variant:full',
                'replacement' => 'variant="pagination-nav"',
                'description' => 'full remains accepted as a compatibility alias for pagination-nav.',
            ],
            [
                'name' => 'variant:compact',
                'replacement' => 'variant="pagination-nav"',
                'description' => 'compact remains accepted as a compatibility alias for pagination-nav.',
            ],
            [
                'name' => 'total',
                'replacement' => 'totalItems',
                'description' => 'total remains accepted as a compatibility alias for totalItems.',
            ],
            [
                'name' => 'perPage',
                'replacement' => 'pageSize',
                'description' => 'perPage remains accepted as a compatibility alias for pageSize.',
            ],
            [
                'name' => 'pageSizes',
                'replacement' => 'pageSizeOptions',
                'description' => 'pageSizes remains accepted as a compatibility alias for pageSizeOptions.',
            ],
        ],
        'classes' => [
            'feature-local pagination styles',
            'feature-local overflow menu styles',
            'raw pagination utility clusters',
        ],
        'components' => [
            'ad hoc pagination markup outside x-ui.pagination',
            'pagination used for linear progress or wizard steps',
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
            'resources/views/components/ui/pagination/index.blade.php',
        ],
        'css' => [
            'resources/css/components/pagination.css',
        ],
        'contract' => [
            'resources/views/components/ui/pagination/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/pagination.md',
        ],
    ],
]);

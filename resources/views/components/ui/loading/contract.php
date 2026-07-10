<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/loading/contract.php
| Purpose: Loading Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Loading API that can be called from Blade,
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
        'slug' => 'loading',
        'label' => 'Loading',
        'component' => 'x-ui.loading',
        'summary' => 'Status-only loading indicator with size, placement, overlay, label, aria-live, and related-action disabling hooks.',
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
        'usage_context' => 'Use x-ui.loading to indicate pending work for inline, component, section, modal, side-panel, tile, or page contexts. Parent components or Patterns own the pending operation, focus behavior, and related action disabling.',

        'props' => [
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional root loading indicator ID.',
            ],
            [
                'name' => 'active',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Controls whether the loading indicator renders. When false, no markup is emitted.',
            ],
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'lg',
                'values' => ['sm', 'lg'],
                'description' => 'Loading indicator size.',
            ],
            [
                'name' => 'placement',
                'type' => 'string',
                'required' => false,
                'default' => 'component',
                'values' => ['inline', 'component', 'section', 'modal', 'side-panel', 'tile', 'page'],
                'description' => 'Contextual placement marker used for layout and overlay behavior.',
            ],
            [
                'name' => 'label',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional visible loading label. Also used as accessible label fallback.',
            ],
            [
                'name' => 'overlay',
                'type' => 'bool|null',
                'required' => false,
                'default' => null,
                'values' => [true, false],
                'description' => 'Explicit overlay override. When null, large region-level placements default to overlay.',
            ],
            [
                'name' => 'disableRelatedActions',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Emits a data hook indicating related actions should be disabled by the parent behavior layer.',
            ],
            [
                'name' => 'ariaLabel',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Explicit accessible label. Takes precedence over caller aria-label, visible label, and fallback text.',
            ],
            [
                'name' => 'ariaLive',
                'type' => 'string',
                'required' => false,
                'default' => 'polite',
                'values' => ['off', 'polite', 'assertive'],
                'description' => 'aria-live value for the status region.',
            ],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'loading',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-loading',
                'required' => true,
                'description' => 'Generated loading marker.',
            ],
            [
                'name' => 'data-ui-loading-active',
                'required' => true,
                'description' => 'Generated active state marker when the component renders.',
            ],
            [
                'name' => 'data-ui-loading-size',
                'required' => true,
                'description' => 'Generated resolved size marker.',
            ],
            [
                'name' => 'data-ui-loading-placement',
                'required' => true,
                'description' => 'Generated resolved placement marker.',
            ],
            [
                'name' => 'data-ui-loading-overlay',
                'required' => true,
                'description' => 'Generated resolved overlay marker.',
            ],
            [
                'name' => 'data-ui-loading-disable-related-actions',
                'required' => false,
                'description' => 'Generated marker when related actions should be disabled by the parent behavior layer.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-loading',
        'required' => [
            'ui-loading',
            'ui-loading__indicator',
            'ui-loading__spinner',
        ],
        'optional' => [
            'ui-loading--sm',
            'ui-loading--lg',
            'ui-loading--placement-inline',
            'ui-loading--placement-component',
            'ui-loading--placement-section',
            'ui-loading--placement-modal',
            'ui-loading--placement-side-panel',
            'ui-loading--placement-tile',
            'ui-loading--placement-page',
            'ui-loading--overlay',
            'ui-loading__label',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local loading spinner classes',
            'ad hoc loading markup outside x-ui.loading',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'inline' => [
            'label' => 'Inline',
            'api' => [
                'placement' => 'inline',
                'size' => 'sm',
            ],
            'class' => 'ui-loading--placement-inline',
            'description' => 'Small inline loading indicator for local pending work.',
        ],
        'component' => [
            'label' => 'Component',
            'api' => [
                'placement' => 'component',
            ],
            'class' => 'ui-loading--placement-component',
            'description' => 'Loading indicator for a component-level pending region.',
        ],
        'section' => [
            'label' => 'Section',
            'api' => [
                'placement' => 'section',
            ],
            'class' => 'ui-loading--placement-section',
            'description' => 'Loading indicator for a section-level pending region.',
        ],
        'modal' => [
            'label' => 'Modal',
            'api' => [
                'placement' => 'modal',
            ],
            'class' => 'ui-loading--placement-modal',
            'description' => 'Loading indicator for a modal pending region.',
        ],
        'side-panel' => [
            'label' => 'Side panel',
            'api' => [
                'placement' => 'side-panel',
            ],
            'class' => 'ui-loading--placement-side-panel',
            'description' => 'Loading indicator for a side-panel pending region.',
        ],
        'tile' => [
            'label' => 'Tile',
            'api' => [
                'placement' => 'tile',
            ],
            'class' => 'ui-loading--placement-tile',
            'description' => 'Loading indicator for a tile pending region.',
        ],
        'page' => [
            'label' => 'Page',
            'api' => [
                'placement' => 'page',
            ],
            'class' => 'ui-loading--placement-page',
            'description' => 'Loading indicator for a page-level pending region.',
        ],
        'overlay' => [
            'label' => 'Overlay',
            'api' => [
                'overlay' => true,
            ],
            'class' => 'ui-loading--overlay',
            'description' => 'Overlay loading treatment.',
        ],
        'with-label' => [
            'label' => 'With label',
            'api' => [
                'label' => 'Loading data',
            ],
            'class' => 'ui-loading__label',
            'description' => 'Loading indicator with visible label text.',
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
            'api' => [
                'size' => 'sm',
            ],
            'class' => 'ui-loading--sm',
            'description' => 'Small loading indicator for inline/local pending work.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => [
                'size' => 'lg',
            ],
            'class' => 'ui-loading--lg',
            'description' => 'Large loading indicator for region-level pending work.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'active' => [
            'label' => 'Active',
            'required' => true,
            'description' => 'Loading indicator renders and exposes status semantics.',
        ],
        'inactive' => [
            'label' => 'Inactive',
            'required' => false,
            'description' => 'No loading markup is emitted when active is false.',
        ],
        'overlay' => [
            'label' => 'Overlay',
            'required' => false,
            'description' => 'Overlay state for large region-level loading placements.',
        ],
        'non-overlay' => [
            'label' => 'Non-overlay',
            'required' => false,
            'description' => 'Non-overlay state for inline or explicitly non-overlay loading.',
        ],
        'disable-related-actions' => [
            'label' => 'Disable related actions',
            'required' => false,
            'description' => 'Data hook state used by parent behavior to disable related actions.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-loading',
        ],
        'component_tokens' => [
            'loading',
            'motion',
        ],
        'deprecated' => [
            'feature-local loading spinner classes',
            'feature-local loading overlay classes',
            'ad hoc loading markup outside x-ui.loading',
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
            'motion',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'modals',
            'data-table',
            'tiles',
            'side-panels',
            'page-shell',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Loading is status-only and does not receive keyboard focus.',
            'Parent components or Patterns own disabling and focus behavior for unavailable related actions.',
        ],
        'aria' => [
            'Active loading renders role="status".',
            'Active loading emits aria-busy="true".',
            'Active loading emits aria-live using the ariaLive prop.',
            'Active loading emits an accessible label from ariaLabel, caller aria-label, visible label, or fallback text.',
            'Spinner artwork is hidden from assistive technology.',
        ],
        'focus' => [
            'Loading does not manage focus.',
            'Overlay loading must not be used as a substitute for Pattern-owned focus management in modal or blocking workflows.',
        ],
        'screen_reader' => [
            'Visible label and aria label should identify the pending region or task when the default Loading label is not specific enough.',
            'assertive live regions should be reserved for urgent pending states.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'classes' => [
            'feature-local loading spinner classes',
            'feature-local overlay classes',
            'raw animation utility clusters for loading behavior',
        ],
        'components' => [
            'ad hoc loading markup outside x-ui.loading',
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
            'resources/views/components/ui/loading/index.blade.php',
        ],
        'css' => [
            'resources/css/components/loading.css',
        ],
        'contract' => [
            'resources/views/components/ui/loading/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/loading.md',
        ],
    ],
]);

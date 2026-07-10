<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/search/contract.php
| Purpose: Search Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Search API that can be called from Blade,
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
        'slug' => 'search',
        'label' => 'Search',
        'component' => 'x-ui.search',
        'summary' => 'Native search input with default and expandable modes, clear button, disabled state, light state, size variants, custom icon, and controlled/uncontrolled values.',
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
        'usage_context' => 'Use x-ui.search for keyword search input. Search owns the input and clear/expand controls; result rendering, filtering, and no-results states belong to the consuming Pattern or data region.',

        'props' => [
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Search input ID. A generated ID is used when omitted.',
            ],
            [
                'name' => 'name',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Native search input name attribute.',
            ],
            [
                'name' => 'labelText',
                'type' => 'string|HtmlString',
                'required' => true,
                'default' => null,
                'values' => [],
                'description' => 'Accessible and visible/CSS-managed search label text.',
            ],
            [
                'name' => 'placeholder',
                'type' => 'string',
                'required' => false,
                'default' => 'Search',
                'values' => [],
                'description' => 'Native input placeholder text.',
            ],
            [
                'name' => 'value',
                'type' => 'string|int|float|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Controlled native input value.',
            ],
            [
                'name' => 'defaultValue',
                'type' => 'string|int|float|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Uncontrolled/default input value used when value is not provided.',
                'compatibility' => true,
            ],
            [
                'name' => 'autoComplete',
                'type' => 'string',
                'required' => false,
                'default' => 'off',
                'values' => [],
                'description' => 'Native autocomplete attribute.',
            ],
            [
                'name' => 'closeButtonLabelText',
                'type' => 'string',
                'required' => false,
                'default' => 'Clear search input',
                'values' => [],
                'description' => 'Accessible label and title for the clear button.',
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Disables the native search input and clear/expand controls.',
            ],
            [
                'name' => 'isExpanded',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Expanded state for expandable search.',
            ],
            [
                'name' => 'expandable',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Enables expandable search mode with magnifier button trigger.',
            ],
            [
                'name' => 'light',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies light search treatment.',
            ],
            [
                'name' => 'size',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['xs', 'sm', 'md', 'lg'],
                'description' => 'Optional search size.',
            ],
            [
                'name' => 'type',
                'type' => 'string',
                'required' => false,
                'default' => 'search',
                'values' => ['search', 'text'],
                'description' => 'Native input type.',
            ],
            [
                'name' => 'role',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional native input role override.',
            ],
            [
                'name' => 'icon',
                'type' => 'string',
                'required' => false,
                'default' => 'search',
                'values' => [],
                'description' => 'Magnifier icon name from the internal icon registry.',
            ],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'search',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-search',
                'required' => true,
                'description' => 'Generated root search marker.',
            ],
            [
                'name' => 'data-ui-search-expanded',
                'required' => true,
                'description' => 'Generated expanded state marker.',
            ],
            [
                'name' => 'data-ui-search-expandable',
                'required' => true,
                'description' => 'Generated expandable mode marker.',
            ],
            [
                'name' => 'data-ui-search-magnifier',
                'required' => true,
                'description' => 'Generated magnifier marker.',
            ],
            [
                'name' => 'data-ui-search-expandable-trigger',
                'required' => false,
                'description' => 'Generated expandable trigger marker.',
            ],
            [
                'name' => 'data-ui-search-input',
                'required' => true,
                'description' => 'Generated native input marker.',
            ],
            [
                'name' => 'data-ui-search-clear',
                'required' => true,
                'description' => 'Generated clear button marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-search',
        'required' => [
            'ui-search',
            'ui-search-magnifier',
            'ui-search-magnifier-icon',
            'ui-label',
            'ui-search-input',
            'ui-search-close',
        ],
        'optional' => [
            'ui-search--xs',
            'ui-search--sm',
            'ui-search--md',
            'ui-search--lg',
            'ui-layout--size-xs',
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-search--light',
            'ui-search--disabled',
            'ui-search--expandable',
            'ui-search-expandable',
            'ui-search--expanded',
            'ui-search-expanded',
            'ui-search-close--hidden',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local search wrapper classes',
            'feature-local clear button behavior',
            'ad hoc search input markup outside x-ui.search',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => [
            'label' => 'Default',
            'api' => [],
            'description' => 'Standard always-expanded search field.',
        ],
        'expandable' => [
            'label' => 'Expandable',
            'api' => ['expandable' => true],
            'class' => 'ui-search--expandable',
            'description' => 'Expandable search with magnifier button trigger.',
        ],
        'expanded' => [
            'label' => 'Expanded',
            'api' => ['expandable' => true, 'isExpanded' => true],
            'class' => 'ui-search--expanded',
            'description' => 'Expanded state for expandable search.',
        ],
        'collapsed' => [
            'label' => 'Collapsed',
            'api' => ['expandable' => true, 'isExpanded' => false],
            'description' => 'Collapsed state for expandable search.',
        ],
        'light' => [
            'label' => 'Light',
            'api' => ['light' => true],
            'class' => 'ui-search--light',
            'description' => 'Light search treatment.',
        ],
        'custom-icon' => [
            'label' => 'Custom icon',
            'api' => ['icon' => 'search'],
            'description' => 'Search using a caller-provided icon name.',
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
            'class' => 'ui-search--xs',
            'description' => 'Extra small search size.',
        ],
        'sm' => [
            'label' => 'Small',
            'api' => ['size' => 'sm'],
            'class' => 'ui-search--sm',
            'description' => 'Small search size.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'class' => 'ui-search--md',
            'description' => 'Medium search size.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => ['size' => 'lg'],
            'class' => 'ui-search--lg',
            'description' => 'Large search size.',
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
            'description' => 'Default enabled search state.',
        ],
        'filled' => [
            'label' => 'Filled',
            'required' => false,
            'description' => 'Search input with content and visible clear button.',
        ],
        'empty' => [
            'label' => 'Empty',
            'required' => false,
            'description' => 'Search input with no content and hidden clear button.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Disabled search state using native disabled attributes.',
        ],
        'expanded' => [
            'label' => 'Expanded',
            'required' => false,
            'description' => 'Expandable search expanded state.',
        ],
        'collapsed' => [
            'label' => 'Collapsed',
            'required' => false,
            'description' => 'Expandable search collapsed state.',
        ],
        'clear-available' => [
            'label' => 'Clear available',
            'required' => false,
            'description' => 'Clear button visible when content exists and search is expanded.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for input, expandable trigger, and clear button.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-search',
            'ui-search-input',
            'ui-search-close',
        ],
        'component_tokens' => [
            'search',
            'field',
            'icon',
        ],
        'deprecated' => [
            'feature-local search wrapper styles',
            'feature-local clear button scripts',
            'ad hoc search input markup outside x-ui.search',
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
        ],
        'uses' => [
            'icons' => [
                'search',
                'close',
                'dynamic icon prop',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'initSearchControls',
            ],
        ],
        'blocks' => [
            'data-table',
            'filters',
            'search-results',
            'toolbar',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native search input keyboard behavior must remain intact.',
            'Expandable trigger and clear button must be keyboard reachable when active.',
            'Collapsed expandable search must remove the input from tab order.',
        ],
        'aria' => [
            'Root renders role="search" and is labelled by the search label.',
            'Expandable magnifier button exposes aria-expanded and aria-controls.',
            'Search icon and close icon are decorative and hidden from assistive technology.',
            'Clear button requires an accessible label from closeButtonLabelText.',
        ],
        'focus' => [
            'Input, expandable trigger, and clear button must show visible focus.',
            'Disabled search controls are not focusable.',
            'JavaScript clear behavior should return focus to the search input.',
        ],
        'screen_reader' => [
            'labelText is required and must describe the search scope.',
            'Placeholder text is not a replacement for labelText.',
            'Result counts, no-results states, loading, and filtering announcements belong to the consuming Pattern or data region.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            [
                'name' => 'defaultValue',
                'replacement' => 'value',
                'description' => 'defaultValue remains accepted as uncontrolled/default input value.',
            ],
            [
                'name' => 'type:text',
                'replacement' => 'type="search"',
                'description' => 'text remains accepted for compatibility, but search is the canonical input type.',
            ],
        ],
        'classes' => [
            'feature-local search wrapper classes',
            'feature-local search icon classes',
            'feature-local clear button classes',
            'raw search utility clusters',
        ],
        'components' => [
            'ad hoc search input markup outside x-ui.search',
            'Search used to own result rendering or filtering orchestration',
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
            'resources/views/components/ui/search/index.blade.php',
        ],
        'css' => [
            'resources/css/components/search.css',
        ],
        'js' => [
            'resources/js/ui-controls/search.js',
        ],
        'contract' => [
            'resources/views/components/ui/search/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/search.md',
        ],
    ],
]);

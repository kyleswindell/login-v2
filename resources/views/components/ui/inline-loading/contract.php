<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/inline-loading/contract.php
| Purpose: Inline Loading Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Inline Loading API that can be called from
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
        'slug' => 'inline-loading',
        'label' => 'Inline Loading',
        'component' => 'x-ui.inline-loading',
        'summary' => 'Inline status component for active loading, inactive, finished, and error handoff near local actions.',
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
        'usage_context' => 'Use x-ui.inline-loading for short local pending states and immediate finished or error handoff near an action or inline region.',

        'props' => [
            [
                'name' => 'status',
                'type' => 'string',
                'required' => false,
                'default' => 'active',
                'values' => [
                    'inactive',
                    'active',
                    'finished',
                    'error',
                    'loading',
                    'success',
                ],
                'description' => 'Inline loading status. Canonical values are inactive, active, finished, and error. loading and success are compatibility aliases.',
            ],
            [
                'name' => 'description',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Visible inline loading description.',
            ],
            [
                'name' => 'label',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Compatibility alias for description.',
                'compatibility' => true,
            ],
            [
                'name' => 'iconDescription',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Visually hidden description for finished and error status icons. Active defaults to loading.',
            ],
            [
                'name' => 'ariaLive',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [
                    'off',
                    'polite',
                    'assertive',
                ],
                'description' => 'aria-live value. Defaults to off for inactive and assertive for active, finished, and error.',
            ],
            [
                'name' => 'live',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [
                    'off',
                    'polite',
                    'assertive',
                ],
                'description' => 'Compatibility alias for ariaLive.',
                'compatibility' => true,
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Visible status content used when description and label are not provided.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'inline-loading',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-inline-loading',
                'required' => true,
                'description' => 'Generated inline loading marker.',
            ],
            [
                'name' => 'data-ui-inline-loading-status',
                'required' => true,
                'description' => 'Generated resolved status marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-inline-loading',
        'required' => [
            'ui-inline-loading',
        ],
        'optional' => [
            'ui-inline-loading--inactive',
            'ui-inline-loading--active',
            'ui-inline-loading--finished',
            'ui-inline-loading--error',
            'ui-inline-loading__animation',
            'ui-inline-loading__spinner',
            'ui-inline-loading__icon',
            'ui-inline-loading__checkmark-container',
            'ui-inline-loading__text',
            'ui-spinner',
            'ui-visually-hidden',
        ],
        'internal' => [],
        'deprecated' => [
            'inline Tailwind utility cluster on inline-loading root',
            'inline style color on inline-loading root',
            'x-ui.status-icon usage for inline loading statuses',
            'warning status on inline-loading',
            'info status on inline-loading',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'inactive' => [
            'label' => 'Inactive',
            'api' => [
                'status' => 'inactive',
            ],
            'class' => 'ui-inline-loading--inactive',
            'description' => 'Inactive inline loading state with no animation or icon.',
        ],
        'active' => [
            'label' => 'Active',
            'api' => [
                'status' => 'active',
            ],
            'class' => 'ui-inline-loading--active',
            'description' => 'Active loading state with spinner.',
        ],
        'finished' => [
            'label' => 'Finished',
            'api' => [
                'status' => 'finished',
            ],
            'class' => 'ui-inline-loading--finished',
            'description' => 'Finished state with checkmark icon.',
        ],
        'error' => [
            'label' => 'Error',
            'api' => [
                'status' => 'error',
            ],
            'class' => 'ui-inline-loading--error',
            'description' => 'Error state with error icon.',
        ],
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
        'inactive' => [
            'label' => 'Inactive',
            'required' => false,
            'description' => 'Inactive state with aria-live off by default.',
        ],
        'active' => [
            'label' => 'Active',
            'required' => true,
            'description' => 'Active loading state.',
        ],
        'finished' => [
            'label' => 'Finished',
            'required' => false,
            'description' => 'Successful completion state.',
        ],
        'error' => [
            'label' => 'Error',
            'required' => false,
            'description' => 'Error completion state.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-inline-loading',
            'ui-spinner',
        ],
        'component_tokens' => [
            'inline-loading',
            'loading',
            'status',
        ],
        'deprecated' => [
            'inline root styles',
            'feature-local status colors',
            'raw Tailwind utility clusters for inline status layout',
            'ad hoc loading/status markup outside x-ui.inline-loading',
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
                'checkmark--filled',
                'error--filled',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'buttons',
            'save-flows',
            'status-handoffs',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Inline Loading is status-only and does not receive keyboard focus.',
        ],
        'aria' => [
            'Root emits aria-live from ariaLive/live or the resolved status default.',
            'Inactive defaults to aria-live="off".',
            'Active, finished, and error default to aria-live="assertive".',
            'Spinner is hidden from assistive technology.',
            'Finished and error icons are paired with visually hidden icon description text.',
        ],
        'focus' => [
            'Inline Loading does not manage focus.',
            'Parent components or Patterns own focus behavior after completion or failure.',
        ],
        'screen_reader' => [
            'Visible description text should communicate the pending or completed state.',
            'Status color and icon must not be the only cue.',
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
                'name' => 'status:loading',
                'replacement' => 'status="active"',
                'description' => 'loading remains accepted as a compatibility alias for active.',
            ],
            [
                'name' => 'status:success',
                'replacement' => 'status="finished"',
                'description' => 'success remains accepted as a compatibility alias for finished.',
            ],
            [
                'name' => 'status:warning',
                'replacement' => 'x-ui.notification.inline or x-ui.tag',
                'description' => 'Warning is not a canonical Inline Loading state.',
            ],
            [
                'name' => 'status:info',
                'replacement' => 'x-ui.notification.inline or x-ui.tag',
                'description' => 'Info is not a canonical Inline Loading state.',
            ],
            [
                'name' => 'label',
                'replacement' => 'description',
                'description' => 'label remains accepted as a compatibility alias for description.',
            ],
            [
                'name' => 'live',
                'replacement' => 'ariaLive',
                'description' => 'live remains accepted as a compatibility alias for ariaLive.',
            ],
        ],
        'classes' => [
            'inline-flex',
            'items-center',
            'gap-2',
            'text-sm',
            'feature-local inline-loading utility clusters',
        ],
        'components' => [
            'x-ui.status-icon usage in inline-loading',
            'ad hoc inline loading/status markup outside x-ui.inline-loading',
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
            'resources/views/components/ui/inline-loading/index.blade.php',
        ],
        'css' => [
            'resources/css/components/loading.css',
        ],
        'contract' => [
            'resources/views/components/ui/inline-loading/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/inline-loading.md',
        ],
    ],
]);

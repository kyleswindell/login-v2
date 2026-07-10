<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/content-switcher/contract.php
| Purpose: Content Switcher Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Content Switcher API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
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
        'slug' => 'content-switcher',
        'label' => 'Content Switcher',
        'component' => 'x-ui.content-switcher',
        'summary' => 'Segmented tablist-style content switcher container for x-ui.content-switcher-option children with size, low-contrast, and automatic/manual selection mode markers.',
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
        'usage_context' => 'Use x-ui.content-switcher for switching between related content views in the same context. Child options should be rendered with x-ui.content-switcher-option. Use x-ui.tabs when each option controls a full tab panel relationship.',

        'props' => [
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'md',
                'values' => ['sm', 'md', 'lg'],
                'description' => 'Content switcher size.',
            ],
            [
                'name' => 'lowContrast',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies low-contrast visual treatment.',
            ],
            [
                'name' => 'selectionMode',
                'type' => 'string',
                'required' => false,
                'default' => 'automatic',
                'values' => ['automatic', 'manual'],
                'description' => 'Selection behavior marker for installed content switcher JavaScript.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => true,
                'description' => 'Content switcher option children, normally x-ui.content-switcher-option.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'content-switcher',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-content-switcher',
                'required' => true,
                'description' => 'Generated root content switcher marker.',
            ],
            [
                'name' => 'data-ui-content-switcher-size',
                'required' => true,
                'description' => 'Generated resolved size marker.',
            ],
            [
                'name' => 'data-ui-content-switcher-selection-mode',
                'required' => true,
                'description' => 'Generated resolved selection mode marker.',
            ],
            [
                'name' => 'data-ui-content-switcher-low-contrast',
                'required' => true,
                'description' => 'Generated low-contrast state marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-content-switcher',
        'required' => [
            'ui-content-switcher',
        ],
        'optional' => [
            'ui-content-switcher--sm',
            'ui-content-switcher--md',
            'ui-content-switcher--lg',
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-content-switcher--low-contrast',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local segmented control wrappers',
            'ad hoc content switcher groups outside x-ui.content-switcher',
            'using x-ui.tabs for simple segmented content switching',
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
            'class' => 'ui-content-switcher',
            'description' => 'Default content switcher.',
        ],
        'low-contrast' => [
            'label' => 'Low contrast',
            'api' => ['lowContrast' => true],
            'class' => 'ui-content-switcher--low-contrast',
            'description' => 'Low-contrast content switcher treatment.',
        ],
        'automatic-selection' => [
            'label' => 'Automatic selection',
            'api' => ['selectionMode' => 'automatic'],
            'description' => 'Selection mode where arrow movement may also change selected option through installed JavaScript.',
        ],
        'manual-selection' => [
            'label' => 'Manual selection',
            'api' => ['selectionMode' => 'manual'],
            'description' => 'Selection mode where arrow movement focuses options and activation changes selection through installed JavaScript.',
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
            'class' => 'ui-content-switcher--sm',
            'description' => 'Small content switcher.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'class' => 'ui-content-switcher--md',
            'description' => 'Default content switcher size.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => ['size' => 'lg'],
            'class' => 'ui-content-switcher--lg',
            'description' => 'Large content switcher.',
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
            'description' => 'Default content switcher state.',
        ],
        'low-contrast' => [
            'label' => 'Low contrast',
            'required' => false,
            'description' => 'Low-contrast visual state.',
        ],
        'automatic-selection' => [
            'label' => 'Automatic selection',
            'required' => false,
            'description' => 'Automatic selection mode state.',
        ],
        'manual-selection' => [
            'label' => 'Manual selection',
            'required' => false,
            'description' => 'Manual selection mode state.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for child options.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-content-switcher',
            'ui-layout',
        ],
        'component_tokens' => [
            'content-switcher',
            'segmented-control',
            'layout-size',
        ],
        'deprecated' => [
            'feature-local segmented control wrappers',
            'ad hoc content switcher markup',
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
            'layout',
            'motion',
            'switch',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'ui.switch',
            ],
            'js_initializers' => [
                'initContentSwitchers',
            ],
        ],
        'blocks' => [
            'settings-switchers',
            'dashboard-view-switchers',
            'segmented-filters',
            'compact-view-controls',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Content switcher options should support arrow key movement through installed content switcher JavaScript.',
            'Automatic mode may change selection during arrow movement.',
            'Manual mode should require activation to change selection.',
            'Disabled options must not be selected by keyboard behavior.',
        ],
        'aria' => [
            'Root renders role="tablist".',
            'Child options should render tab-like roles and selected state through x-ui.content-switcher-option.',
            'The root should receive an accessible name from caller-provided aria-label or aria-labelledby when surrounding text does not label the control.',
        ],
        'focus' => [
            'Child options must show visible focus.',
            'Roving focus behavior is owned by installed content switcher JavaScript.',
        ],
        'screen_reader' => [
            'Each option label must clearly describe the content view or mode it selects.',
            'Use x-ui.tabs instead when panels require full tab/tabpanel semantics.',
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
            'feature-local segmented control classes',
            'raw content switcher utility clusters',
        ],
        'components' => [
            'ad hoc segmented controls outside x-ui.content-switcher',
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
            'resources/views/components/ui/content-switcher/index.blade.php',
        ],
        'css' => [
            'resources/css/components/content-switcher.css',
        ],
        'js' => [
            'resources/js/ui-controls/content-switcher.js',
        ],
        'contract' => [
            'resources/views/components/ui/content-switcher/contract.php',
        ],
    ],
]);

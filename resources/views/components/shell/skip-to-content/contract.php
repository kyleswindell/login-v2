<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/shell/skip-to-content/contract.php
| Purpose: UI Shell Skip-to-content Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public UI Shell Skip-to-content API that can be
| called from Blade, validated by tooling, and consumed by shell layouts.
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
        'slug' => 'ui-shell-skip-to-content',
        'label' => 'UI Shell Skip to Content',
        'component' => 'x-shell.skip-to-content',
        'summary' => 'Keyboard-accessible bypass link for jumping from the shell to the main content region.',
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
        'usage_context' => 'Use x-shell.skip-to-content as the first focusable element inside the UI shell so keyboard users can bypass repeated shell navigation and jump to the main content region.',

        'props' => [
            [
                'name' => 'href',
                'type' => 'string',
                'required' => false,
                'default' => '#main-content',
                'values' => [],
                'description' => 'Fragment target for the skip link. The target element must exist on the page.',
            ],
            [
                'name' => 'tabIndex',
                'type' => 'int|string',
                'required' => false,
                'default' => 0,
                'values' => [],
                'description' => 'Native tabindex for the skip link.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Visible skip link text. Defaults to "Skip to main content".',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'shell-skip-to-content',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-shell-skip-to-content',
                'required' => true,
                'description' => 'Generated shell skip link marker.',
            ],
            [
                'name' => 'data-ui-shell-skip-to-content-target',
                'required' => true,
                'description' => 'Generated resolved target marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-shell-skip-to-content',
        'required' => [
            'ui-shell-skip-to-content',
        ],
        'optional' => [],
        'internal' => [],
        'deprecated' => [
            'feature-local skip link classes',
            'ad hoc skip links outside x-shell.skip-to-content',
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
            'api' => [
                'href' => '#main-content',
            ],
            'class' => 'ui-shell-skip-to-content',
            'description' => 'Default skip link targeting #main-content.',
        ],
        'custom-target' => [
            'label' => 'Custom target',
            'api' => [
                'href' => '#content',
            ],
            'description' => 'Skip link targeting a caller-provided content region.',
        ],
        'custom-label' => [
            'label' => 'Custom label',
            'api' => [
                'slot' => 'Skip to dashboard content',
            ],
            'description' => 'Skip link with caller-provided visible text.',
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
        'default' => [
            'label' => 'Default',
            'required' => true,
            'description' => 'Default skip link state.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state when the skip link receives keyboard focus.',
        ],
        'activated' => [
            'label' => 'Activated',
            'required' => false,
            'description' => 'Browser navigates focus/scroll position to the target fragment.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-shell-skip-to-content',
        ],
        'component_tokens' => [
            'ui-shell',
            'skip-link',
            'accessibility',
        ],
        'deprecated' => [
            'feature-local skip link classes',
            'ad hoc shell skip links outside x-shell.skip-to-content',
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
            'ui-shell',
            'app-shell',
            'main-content',
            'page-layout',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Skip link must be keyboard reachable as the first focusable element inside the shell.',
            'Skip link must activate with native anchor keyboard behavior.',
        ],
        'aria' => [
            'Skip link does not require ARIA when visible text clearly describes the target.',
            'The href target must resolve to an existing element on the page.',
        ],
        'focus' => [
            'Skip link must show visible focus.',
            'The target region should be focusable or browser-focusable after fragment navigation when needed.',
        ],
        'screen_reader' => [
            'Skip link text must describe the bypass target clearly.',
            'The target region should usually be the main content landmark.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'classes' => [
            'feature-local skip link classes',
            'raw skip link utility clusters',
        ],
        'components' => [
            'ad hoc skip links outside x-shell.skip-to-content',
            'shell layouts without a keyboard bypass link',
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
            'resources/views/components/shell/skip-to-content/index.blade.php',
        ],
        'css' => [
            'resources/css/components/ui-shell/index.css',
        ],
        'contract' => [
            'resources/views/components/shell/skip-to-content/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/ui-shell.md',
        ],
    ],
]);

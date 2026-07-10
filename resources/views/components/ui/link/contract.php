<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/link/contract.php
| Purpose: Link Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Link API that can be called from Blade,
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
        'slug' => 'link',
        'label' => 'Link',
        'component' => 'x-ui.link',
        'summary' => 'Navigation link treatment for inline prose, standalone references, external destinations, downloads, and unavailable links.',
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
        'usage_context' => 'Use x-ui.link for navigation, references, same-page anchors, external destinations, downloads, and unavailable link text. Use buttons for commands.',

        'props' => [
            [
                'name' => 'href',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Link destination. Blank destinations render as unavailable text.',
            ],
            [
                'name' => 'text',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Visible link text used instead of the default slot when provided.',
            ],
            [
                'name' => 'variant',
                'type' => 'string',
                'required' => false,
                'default' => 'standalone',
                'values' => [
                    'inline',
                    'standalone',
                ],
                'description' => 'Inline is for prose links. Standalone is for links outside sentence flow.',
            ],
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'md',
                'values' => [
                    'sm',
                    'md',
                    'lg',
                ],
                'description' => 'Standalone link size. Inline links inherit surrounding text context.',
            ],
            [
                'name' => 'external',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Marks the destination as external and opens it in a secure new tab.',
            ],
            [
                'name' => 'newTab',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Opens the destination in a secure new tab.',
            ],
            [
                'name' => 'icon',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional decorative icon name from the internal icon registry. Icons are suppressed for inline links.',
            ],
            [
                'name' => 'iconPosition',
                'type' => 'string',
                'required' => false,
                'default' => 'end',
                'values' => [
                    'start',
                    'leading',
                    'end',
                ],
                'description' => 'Icon position for standalone links. leading resolves to start.',
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Renders the link as unavailable non-interactive text.',
            ],
            [
                'name' => 'unavailable',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Renders the link as unavailable non-interactive text.',
            ],
            [
                'name' => 'current',
                'type' => 'bool|string',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                    'page',
                    'step',
                    'location',
                    'date',
                    'time',
                ],
                'description' => 'Current-location marker. true resolves to aria-current="page"; strings pass through as aria-current values.',
            ],
            [
                'name' => 'visited',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Reference/demo visited-policy marker. Does not force browser visited state.',
            ],
            [
                'name' => 'download',
                'type' => 'bool|string',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Adds a download attribute. A string value is used as the suggested filename.',
            ],
            [
                'name' => 'navigate',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Adds wire:navigate for Livewire navigation.',
            ],
            [
                'name' => 'ariaLabel',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional accessible label.',
            ],
            [
                'name' => 'describedBy',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional aria-describedby ID reference.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Visible link content used when the text prop is not provided.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'link',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-link-variant',
                'required' => true,
                'description' => 'Generated resolved variant marker.',
            ],
            [
                'name' => 'data-ui-link-size',
                'required' => true,
                'description' => 'Generated resolved size marker.',
            ],
            [
                'name' => 'data-ui-link-disabled',
                'required' => false,
                'description' => 'Generated unavailable link marker.',
            ],
            [
                'name' => 'data-ui-link-external',
                'required' => false,
                'description' => 'Generated external destination marker.',
            ],
            [
                'name' => 'data-ui-link-current',
                'required' => false,
                'description' => 'Generated current destination marker.',
            ],
            [
                'name' => 'data-ui-link-visited-policy',
                'required' => false,
                'description' => 'Generated visited-policy marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-link',
        'required' => [
            'ui-link',
        ],
        'optional' => [
            'ui-link-inline',
            'ui-link-standalone',
            'ui-link-sm',
            'ui-link-md',
            'ui-link-lg',
            'ui-link-with-icon',
            'ui-link-unavailable',
            'ui-link-external',
        ],
        'internal' => [
            'ui-link-icon',
        ],
        'deprecated' => [
            'href="#" command links',
            'local link color classes',
            'button-like local link styling',
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
                'variant' => 'inline',
            ],
            'class' => 'ui-link-inline',
            'description' => 'Inline prose link. Icons are suppressed.',
        ],
        'standalone' => [
            'label' => 'Standalone',
            'api' => [
                'variant' => 'standalone',
            ],
            'class' => 'ui-link-standalone',
            'description' => 'Standalone link outside sentence flow.',
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
            'class' => 'ui-link-sm',
            'description' => 'Small standalone link size.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => [
                'size' => 'md',
            ],
            'class' => 'ui-link-md',
            'description' => 'Default standalone link size.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => [
                'size' => 'lg',
            ],
            'class' => 'ui-link-lg',
            'description' => 'Large standalone link size.',
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
            'description' => 'Default interactive link state.',
        ],
        'hover' => [
            'label' => 'Hover',
            'required' => false,
            'description' => 'Pointer hover state handled by CSS.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible keyboard focus state.',
        ],
        'active' => [
            'label' => 'Active',
            'required' => false,
            'description' => 'Active interaction state.',
        ],
        'current' => [
            'label' => 'Current',
            'required' => false,
            'description' => 'Current-location state through aria-current.',
        ],
        'unavailable' => [
            'label' => 'Unavailable',
            'required' => false,
            'description' => 'Non-interactive text state for disabled, unavailable, or missing destinations.',
        ],
        'visited-policy' => [
            'label' => 'Visited policy',
            'required' => false,
            'description' => 'Reference/demo visited-policy marker.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-link',
        ],
        'component_tokens' => [
            'link',
        ],
        'deprecated' => [
            'local link colors',
            'local underline behavior outside the Link component',
            'href="#" command links',
            'links used for commands that should be buttons',
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
        ],
        'uses' => [
            'icons' => [
                'dynamic icon prop',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'breadcrumb',
            'button',
            'typography',
            'navigation',
            'docs',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Interactive links render as native anchors and must support normal link keyboard behavior.',
            'Unavailable links render as non-interactive text and are not keyboard focusable.',
        ],
        'aria' => [
            'Current links expose aria-current when current is provided.',
            'Unavailable links expose aria-disabled.',
            'Decorative link icons are hidden from assistive technology.',
            'ariaLabel and describedBy pass through to both interactive and unavailable rendering branches.',
        ],
        'focus' => [
            'Interactive links must show visible focus.',
            'Unavailable links are not focusable.',
        ],
        'screen_reader' => [
            'Link text must identify the destination or purpose.',
            'External, download, unavailable, and current link meaning should be clear from text, icon context, or surrounding copy.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            [
                'name' => 'iconPosition:leading',
                'replacement' => 'iconPosition:start',
                'description' => 'leading remains accepted as a compatibility alias for start.',
            ],
        ],
        'classes' => [
            'feature-local link color classes',
            'feature-local link underline classes',
            'button-like link utility clusters',
        ],
        'components' => [
            'ad hoc anchor markup for app-owned links',
            'links used for commands that should be x-ui.button',
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
            'resources/views/components/ui/link/index.blade.php',
        ],
        'css' => [
            'resources/css/components/link.css',
        ],
        'contract' => [
            'resources/views/components/ui/link/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/link.md',
        ],
    ],
]);

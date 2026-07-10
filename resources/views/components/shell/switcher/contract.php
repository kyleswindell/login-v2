<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/shell/switcher/contract.php
| Purpose: UI Shell Switcher Component family public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public UI Shell Switcher item and divider APIs
| that can be called from Blade, validated by tooling, and consumed by shell
| layouts.
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
        'slug' => 'ui-shell-switcher',
        'label' => 'UI Shell Switcher',
        'component' => 'x-shell.switcher-*',
        'summary' => 'UI shell switcher item family with selectable switcher links and divider items.',
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
        'usage_context' => 'Use x-shell.switcher-item and x-shell.switcher-divider inside UI shell switcher lists. The switcher panel, disclosure state, keyboard roving behavior, and shell navigation ownership belong to the surrounding shell component or JavaScript controller.',

        'props' => [],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'description' => 'Generated low-level shell switcher component marker.',
            ],
            [
                'name' => 'data-ui-shell-switcher-item',
                'required' => false,
                'description' => 'Generated switcher item marker.',
            ],
            [
                'name' => 'data-ui-shell-switcher-index',
                'required' => false,
                'description' => 'Generated optional item index marker.',
            ],
            [
                'name' => 'data-ui-shell-switcher-divider',
                'required' => false,
                'description' => 'Generated switcher divider marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Subcomponents
    |--------------------------------------------------------------------------
    */

    'subcomponents' => [
        'item' => [
            'component' => 'x-shell.switcher-item',
            'description' => 'UI shell switcher navigation item.',
            'props' => [
                [
                    'name' => 'href',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Anchor href. Falls back to # when omitted.',
                ],
                [
                    'name' => 'target',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Optional anchor target.',
                ],
                [
                    'name' => 'rel',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Optional anchor rel.',
                ],
                [
                    'name' => 'label',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Optional aria-label for the anchor when aria-labelledby is not provided.',
                ],
                [
                    'name' => 'labelledby',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Optional aria-labelledby target for the anchor.',
                ],
                [
                    'name' => 'selected',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Selected/current item state.',
                ],
                [
                    'name' => 'isSelected',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Compatibility alias for selected.',
                    'compatibility' => true,
                ],
                [
                    'name' => 'expanded',
                    'type' => 'bool|null',
                    'required' => false,
                    'default' => null,
                    'values' => [true, false],
                    'description' => 'Optional switcher expanded state used to derive tabindex when tabIndex is omitted.',
                ],
                [
                    'name' => 'tabIndex',
                    'type' => 'int|string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Explicit anchor tabindex.',
                ],
                [
                    'name' => 'index',
                    'type' => 'int|string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Optional item index marker for shell switcher behavior.',
                ],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => true,
                    'description' => 'Visible switcher item label/content.',
                ],
            ],
        ],

        'divider' => [
            'component' => 'x-shell.switcher-divider',
            'description' => 'UI shell switcher divider item.',
            'props' => [],
            'slots' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => null,
        'required' => [],
        'optional' => [
            'ui-shell-switcher__item',
            'ui-shell-switcher__item-link',
            'ui-shell-switcher__item-link--selected',
            'ui-shell-switcher__item--divider',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local shell switcher item classes',
            'ad hoc shell switcher links outside x-shell.switcher-item',
            'ad hoc shell switcher dividers outside x-shell.switcher-divider',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'item' => [
            'label' => 'Item',
            'api' => [
                'component' => 'x-shell.switcher-item',
            ],
            'class' => 'ui-shell-switcher__item',
            'description' => 'Default shell switcher item.',
        ],
        'selected-item' => [
            'label' => 'Selected item',
            'api' => [
                'selected' => true,
            ],
            'class' => 'ui-shell-switcher__item-link--selected',
            'description' => 'Selected/current shell switcher item.',
        ],
        'expanded-tabstop' => [
            'label' => 'Expanded tab stop',
            'api' => [
                'expanded' => true,
            ],
            'description' => 'Item receives tabindex 0 when expanded is true and tabIndex is omitted.',
        ],
        'collapsed-tabstop' => [
            'label' => 'Collapsed tab stop',
            'api' => [
                'expanded' => false,
            ],
            'description' => 'Item receives tabindex -1 when expanded is false and tabIndex is omitted.',
        ],
        'divider' => [
            'label' => 'Divider',
            'api' => [
                'component' => 'x-shell.switcher-divider',
            ],
            'class' => 'ui-shell-switcher__item--divider',
            'description' => 'Visual separator item inside the switcher list.',
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
            'description' => 'Default switcher item state.',
        ],
        'selected' => [
            'label' => 'Selected',
            'required' => false,
            'description' => 'Selected/current item state with aria-current page.',
        ],
        'expanded-tabbable' => [
            'label' => 'Expanded tabbable',
            'required' => false,
            'description' => 'Expanded switcher item participates in tab order.',
        ],
        'collapsed-untabbable' => [
            'label' => 'Collapsed untabbable',
            'required' => false,
            'description' => 'Collapsed switcher item is removed from tab order.',
        ],
        'divider' => [
            'label' => 'Divider',
            'required' => false,
            'description' => 'Separator item state.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for switcher item links.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-shell-switcher',
        ],
        'component_tokens' => [
            'ui-shell',
            'switcher',
            'navigation',
        ],
        'deprecated' => [
            'feature-local shell switcher item classes',
            'ad hoc shell switcher navigation markup',
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
            'js_initializers' => [
                'shell switcher behavior if installed',
            ],
        ],
        'blocks' => [
            'ui-shell',
            'header',
            'side-navigation',
            'switcher-panel',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Switcher item links must be keyboard reachable when the switcher is expanded.',
            'Collapsed switcher items should be removed from tab order when expanded=false drives tabindex.',
            'Keyboard disclosure, roving focus, and Escape behavior are owned by the surrounding shell switcher controller.',
        ],
        'aria' => [
            'Selected switcher item links expose aria-current="page".',
            'Switcher item links may use aria-label or aria-labelledby.',
            'aria-labelledby takes precedence over aria-label when both are supplied.',
            'Divider renders role="separator" on the hr element.',
        ],
        'focus' => [
            'Switcher item links must show visible focus.',
            'Focus placement and return focus are owned by the surrounding shell switcher controller.',
        ],
        'screen_reader' => [
            'Switcher item text or accessible name must identify the destination.',
            'Dividers must not be used as headings or grouping labels.',
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
                'name' => 'isSelected',
                'replacement' => 'selected',
                'description' => 'isSelected remains accepted as a compatibility alias for selected.',
            ],
        ],
        'classes' => [
            'feature-local switcher item classes',
            'feature-local selected switcher classes',
            'raw shell switcher utility clusters',
        ],
        'components' => [
            'ad hoc shell switcher links outside x-shell.switcher-item',
            'ad hoc shell switcher dividers outside x-shell.switcher-divider',
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
            'resources/views/components/shell/switcher/item.blade.php',
            'resources/views/components/shell/switcher/divider.blade.php',
        ],
        'css' => [
            'resources/css/components/ui-shell/index.css',
        ],
        'contract' => [
            'resources/views/components/shell/switcher/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/ui-shell.md',
        ],
    ],
]);

<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/toggletip/contract.php
| Purpose: Toggletip Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Toggletip API that can be called from
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
        'slug' => 'toggletip',
        'label' => 'Toggletip',
        'component' => 'x-ui.toggletip',
        'summary' => 'Click-triggered contextual help disclosure composed from popover classes with trigger button, dialog panel, optional actions, close button, and caret.',
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
        'usage_context' => 'Use x-ui.toggletip for short contextual help that opens on click and may include simple action content. Use x-ui.tooltip for hover/focus-only labels and x-ui.popover for fully custom floating content composition.',

        'props' => [
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Toggletip root ID. A generated ID is used when omitted.',
            ],
            [
                'name' => 'align',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => ['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end', 'left', 'left-start', 'left-end', 'right', 'right-start', 'right-end'],
                'description' => 'Canonical popover alignment. Takes precedence over placement.',
            ],
            [
                'name' => 'placement',
                'type' => 'string',
                'required' => false,
                'default' => 'right',
                'values' => ['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end', 'left', 'left-start', 'left-end', 'right', 'right-start', 'right-end'],
                'description' => 'Placement alias used when align is not supplied.',
                'compatibility' => true,
            ],
            [
                'name' => 'label',
                'type' => 'string',
                'required' => false,
                'default' => 'Show information',
                'values' => [],
                'description' => 'Accessible label for the toggletip trigger button.',
            ],
            [
                'name' => 'buttonClass',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional extra class string appended to the trigger button.',
            ],
            [
                'name' => 'defaultOpen',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Initial rendered open state preserved by toggletip JavaScript initialization.',
            ],
            [
                'name' => 'autoAlign',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies auto-align class treatment.',
            ],
            [
                'name' => 'closeButton',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Controls whether the default close action renders.',
            ],
            [
                'name' => 'closeLabel',
                'type' => 'string',
                'required' => false,
                'default' => 'Close',
                'values' => [],
                'description' => 'Visible label for the default close button.',
            ],
            [
                'name' => 'contentClass',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional extra class string appended to the popover content panel.',
            ],
            [
                'name' => 'highContrast',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Applies high-contrast toggletip treatment.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => true,
                'description' => 'Main toggletip message content.',
            ],
            [
                'name' => 'trigger',
                'required' => false,
                'description' => 'Custom trigger icon/content rendered inside the trigger button.',
            ],
            [
                'name' => 'actions',
                'required' => false,
                'description' => 'Optional action row content rendered before the default close button.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'toggletip', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-toggletip', 'required' => true, 'description' => 'Generated root toggletip marker.'],
            ['name' => 'data-ui-toggletip-placement', 'required' => true, 'description' => 'Generated resolved placement/alignment marker.'],
            ['name' => 'data-ui-toggletip-state', 'required' => true, 'description' => 'Generated open or closed state marker.'],
            ['name' => 'data-ui-toggletip-trigger', 'required' => true, 'description' => 'Generated trigger button marker.'],
            ['name' => 'data-ui-toggletip-popover', 'required' => true, 'description' => 'Generated popover wrapper marker.'],
            ['name' => 'data-ui-toggletip-panel', 'required' => true, 'description' => 'Generated dialog panel marker.'],
            ['name' => 'data-ui-toggletip-close', 'required' => false, 'description' => 'Generated close button marker.'],
            ['name' => 'data-ui-popover-caret', 'required' => true, 'description' => 'Generated decorative caret marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-toggletip',
        'required' => [
            'ui-popover-container',
            'ui-toggletip',
            'ui-toggletip-button',
            'ui-popover',
            'ui-popover-content',
            'ui-toggletip-popover-content',
            'ui-toggletip-content',
            'ui-popover-caret',
        ],
        'optional' => [
            'ui-toggletip--open',
            'ui-autoalign',
            'ui-popover--top',
            'ui-popover--top-start',
            'ui-popover--top-end',
            'ui-popover--bottom',
            'ui-popover--bottom-start',
            'ui-popover--bottom-end',
            'ui-popover--left',
            'ui-popover--left-start',
            'ui-popover--left-end',
            'ui-popover--right',
            'ui-popover--right-start',
            'ui-popover--right-end',
            'ui-toggletip--high-contrast',
            'ui-icon',
            'ui-toggletip-button__icon',
            'ui-toggletip-actions',
            'ui-link',
            'ui-toggletip-close',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local toggletip wrappers',
            'ad hoc contextual help disclosures outside x-ui.toggletip',
            'hover-only toggletip behavior where x-ui.tooltip should be used',
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
            'class' => 'ui-toggletip',
            'description' => 'Default closed toggletip.',
        ],
        'open' => [
            'label' => 'Open',
            'api' => ['defaultOpen' => true],
            'class' => 'ui-toggletip--open',
            'description' => 'Initially open toggletip.',
        ],
        'auto-align' => [
            'label' => 'Auto align',
            'api' => ['autoAlign' => true],
            'class' => 'ui-autoalign',
            'description' => 'Toggletip with auto-align class treatment.',
        ],
        'high-contrast' => [
            'label' => 'High contrast',
            'api' => ['highContrast' => true],
            'class' => 'ui-toggletip--high-contrast',
            'description' => 'High-contrast toggletip treatment.',
        ],
        'custom-trigger' => [
            'label' => 'Custom trigger',
            'api' => ['slot' => 'trigger'],
            'description' => 'Toggletip with caller-provided trigger icon/content.',
        ],
        'with-actions' => [
            'label' => 'With actions',
            'api' => ['slot' => 'actions'],
            'class' => 'ui-toggletip-actions',
            'description' => 'Toggletip with custom actions row.',
        ],
        'without-close-button' => [
            'label' => 'Without close button',
            'api' => ['closeButton' => false],
            'description' => 'Toggletip with default close button suppressed.',
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
        'closed' => [
            'label' => 'Closed',
            'required' => true,
            'description' => 'Default hidden panel state.',
        ],
        'open' => [
            'label' => 'Open',
            'required' => false,
            'description' => 'Visible panel state.',
        ],
        'auto-aligned' => [
            'label' => 'Auto aligned',
            'required' => false,
            'description' => 'Auto-align visual/positioning state.',
        ],
        'high-contrast' => [
            'label' => 'High contrast',
            'required' => false,
            'description' => 'High-contrast visual state.',
        ],
        'with-actions' => [
            'label' => 'With actions',
            'required' => false,
            'description' => 'Action row is rendered.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for trigger, actions, and close button.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-toggletip',
            'ui-popover',
            'ui-link',
        ],
        'component_tokens' => [
            'toggletip',
            'popover',
            'contextual-help',
            'disclosure',
        ],
        'deprecated' => [
            'feature-local toggletip wrappers',
            'ad hoc contextual help disclosures',
            'using toggletip for hover-only tooltips',
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
            'popover',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'inline information icon svg',
            ],
            'components' => [],
            'js_initializers' => [
                'initToggletips',
            ],
        ],
        'blocks' => [
            'form-help',
            'table-header-help',
            'contextual-help',
            'settings-help',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Toggletip trigger must be keyboard reachable.',
            'Trigger opens the panel through click/activation behavior, not hover-only behavior.',
            'Close button and custom actions must be keyboard reachable when rendered.',
            'Escape, outside click, and focus behavior are owned by installed toggletip JavaScript.',
        ],
        'aria' => [
            'Trigger renders aria-label, aria-expanded, aria-controls, and aria-haspopup="dialog".',
            'When open, trigger references the panel with aria-describedby.',
            'Panel renders role="dialog".',
            'Panel uses aria-hidden and hidden according to open state.',
            'Default trigger icon and caret are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Trigger, action controls, and close button must show visible focus.',
            'Focus placement and return focus are owned by toggletip JavaScript or the consuming pattern.',
        ],
        'screen_reader' => [
            'Trigger label should describe that contextual information will be shown.',
            'Toggletip content should be short and related to nearby UI copy.',
            'Do not use toggletip as the only location for required instructions or validation recovery.',
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
                'name' => 'placement',
                'replacement' => 'align',
                'description' => 'placement remains accepted as a friendlier alias when align is not supplied.',
            ],
        ],
        'classes' => [
            'feature-local toggletip classes',
            'raw contextual help utility clusters',
        ],
        'components' => [
            'ad hoc contextual help disclosure outside x-ui.toggletip',
            'hover-only labels implemented as toggletip instead of tooltip',
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
            'resources/views/components/ui/toggletip/index.blade.php',
        ],
        'css' => [
            'resources/css/components/toggletip.css',
            'resources/css/components/popover.css',
        ],
        'js' => [
            'resources/js/ui-controls/toggletip.js',
        ],
        'contract' => [
            'resources/views/components/ui/toggletip/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/toggletip.md',
        ],
    ],
]);

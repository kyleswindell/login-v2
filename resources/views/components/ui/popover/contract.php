<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/popover/contract.php
| Purpose: Popover Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Popover API that can be called from Blade,
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
        'slug' => 'popover',
        'label' => 'Popover',
        'component' => 'x-ui.popover',
        'summary' => 'Popover container and content surface for positioned floating content with alignment, caret, border, shadow, contrast, auto-align, tab-tip, and background-token treatments.',
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
        'usage_context' => 'Use x-ui.popover when a trigger and popover content need to be composed explicitly. The container owns positioning state classes and data hooks; the caller provides trigger markup and x-ui.popover.content markup through the slot.',

        'props' => [
            ['name' => 'align', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['top', 'bottom', 'left', 'right', 'top-start', 'top-end', 'bottom-start', 'bottom-end', 'left-start', 'left-end', 'right-start', 'right-end', 'top-left', 'top-right', 'bottom-left', 'bottom-right', 'left-top', 'left-bottom', 'right-top', 'right-bottom'], 'description' => 'Preferred popover alignment. Deprecated Carbon alignment values are accepted and mapped to start/end equivalents.'],
            ['name' => 'alignmentAxisOffset', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Alignment axis offset data hook for installed popover positioning behavior.'],
            ['name' => 'as', 'type' => 'string', 'required' => false, 'default' => 'span', 'values' => ['span', 'div', 'section', 'aside'], 'description' => 'Root HTML element for the popover container.'],
            ['name' => 'autoAlign', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Enables auto-align treatment and data hooks.'],
            ['name' => 'autoAlignBoundary', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Auto-align boundary data hook when scalar.'],
            ['name' => 'backgroundToken', 'type' => 'string', 'required' => false, 'default' => 'layer', 'values' => ['layer', 'background'], 'description' => 'Popover background token treatment. background is ignored visually when highContrast is active.'],
            ['name' => 'caret', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false], 'description' => 'Controls caret treatment. Defaults to true except tab-tip popovers.'],
            ['name' => 'border', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies border treatment.'],
            ['name' => 'dropShadow', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Applies drop-shadow treatment.'],
            ['name' => 'highContrast', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies high-contrast treatment.'],
            ['name' => 'isTabTip', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies tab-tip treatment and constrains alignment to bottom-start or bottom-end.'],
            ['name' => 'open', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Rendered open state.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Popover container ID. A generated ID is used when omitted.'],
            ['name' => 'interaction', 'type' => 'string', 'required' => false, 'default' => 'click', 'values' => ['click', 'hover', 'focus'], 'description' => 'Interaction mode data hook for installed popover behavior.'],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => true,
                'description' => 'Popover trigger and content markup. In Blade, the caller must provide the trigger and x-ui.popover.content explicitly.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'popover', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-popover', 'required' => true, 'description' => 'Generated root popover marker.'],
            ['name' => 'data-ui-popover-align', 'required' => true, 'description' => 'Generated resolved alignment marker.'],
            ['name' => 'data-ui-popover-open', 'required' => true, 'description' => 'Generated open state marker.'],
            ['name' => 'data-ui-popover-caret', 'required' => true, 'description' => 'Generated caret state marker.'],
            ['name' => 'data-ui-popover-border', 'required' => true, 'description' => 'Generated border state marker.'],
            ['name' => 'data-ui-popover-drop-shadow', 'required' => true, 'description' => 'Generated drop-shadow state marker.'],
            ['name' => 'data-ui-popover-high-contrast', 'required' => true, 'description' => 'Generated high-contrast state marker.'],
            ['name' => 'data-ui-popover-auto-align', 'required' => true, 'description' => 'Generated auto-align state marker.'],
            ['name' => 'data-ui-popover-tab-tip', 'required' => true, 'description' => 'Generated tab-tip state marker.'],
            ['name' => 'data-ui-popover-background-token', 'required' => true, 'description' => 'Generated background token marker.'],
            ['name' => 'data-ui-popover-interaction', 'required' => true, 'description' => 'Generated interaction mode marker.'],
            ['name' => 'data-ui-popover-alignment-axis-offset', 'required' => false, 'description' => 'Generated alignment axis offset marker.'],
            ['name' => 'data-ui-popover-auto-align-boundary', 'required' => false, 'description' => 'Generated auto-align boundary marker.'],
            ['name' => 'data-ui-popover-content', 'required' => false, 'description' => 'Generated popover content marker.'],
            ['name' => 'data-ui-popover-panel', 'required' => false, 'description' => 'Generated popover panel marker.'],
            ['name' => 'data-ui-popover-caret', 'required' => false, 'description' => 'Generated caret marker inside popover content.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Subcomponents
    |--------------------------------------------------------------------------
    */

    'subcomponents' => [
        'content' => [
            'component' => 'x-ui.popover.content',
            'description' => 'Popover content surface rendered inside x-ui.popover.',
            'props' => [
                ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Popover content ID. A generated ID is used when omitted.'],
                ['name' => 'label', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional aria-label for the content surface.'],
                ['name' => 'labelledby', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional aria-labelledby target for the content surface.'],
                ['name' => 'role', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional role for the content surface.'],
                ['name' => 'caret', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Controls content caret rendering.'],
                ['name' => 'autoAlign', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Controls whether caret renders inside content for auto-align mode.'],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => true,
                    'description' => 'Popover body content.',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-popover-container',
        'required' => [
            'ui-popover-container',
            'ui-popover',
            'ui-popover-content',
        ],
        'optional' => [
            'ui-popover--caret',
            'ui-popover--drop-shadow',
            'ui-popover--border',
            'ui-popover--high-contrast',
            'ui-popover--open',
            'ui-popover--auto-align',
            'ui-autoalign',
            'ui-popover--top',
            'ui-popover--bottom',
            'ui-popover--left',
            'ui-popover--right',
            'ui-popover--top-start',
            'ui-popover--top-end',
            'ui-popover--bottom-start',
            'ui-popover--bottom-end',
            'ui-popover--left-start',
            'ui-popover--left-end',
            'ui-popover--right-start',
            'ui-popover--right-end',
            'ui-popover--tab-tip',
            'ui-popover--background-token__background',
            'ui-popover-caret',
            'ui-popover-drop-shadow',
            'ui-popover-border',
            'ui-popover-high-contrast',
            'ui-popover-open',
            'ui-popover-auto-align',
            'ui-popover-tab-tip',
            'ui-popover-background-token-background',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local popover wrappers',
            'ad hoc floating content wrappers outside x-ui.popover',
            'deprecated Carbon left/right alignment names without start/end mapping',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-popover-container', 'description' => 'Default popover container.'],
        'open' => ['label' => 'Open', 'api' => ['open' => true], 'class' => 'ui-popover--open', 'description' => 'Open popover state.'],
        'with-caret' => ['label' => 'With caret', 'api' => ['caret' => true], 'class' => 'ui-popover--caret', 'description' => 'Popover with caret.'],
        'without-caret' => ['label' => 'Without caret', 'api' => ['caret' => false], 'description' => 'Popover without caret.'],
        'bordered' => ['label' => 'Bordered', 'api' => ['border' => true], 'class' => 'ui-popover--border', 'description' => 'Popover with border treatment.'],
        'drop-shadow' => ['label' => 'Drop shadow', 'api' => ['dropShadow' => true], 'class' => 'ui-popover--drop-shadow', 'description' => 'Popover with drop-shadow treatment.'],
        'high-contrast' => ['label' => 'High contrast', 'api' => ['highContrast' => true], 'class' => 'ui-popover--high-contrast', 'description' => 'High-contrast popover.'],
        'auto-align' => ['label' => 'Auto align', 'api' => ['autoAlign' => true], 'class' => 'ui-popover--auto-align', 'description' => 'Popover with auto-align positioning treatment.'],
        'tab-tip' => ['label' => 'Tab tip', 'api' => ['isTabTip' => true], 'class' => 'ui-popover--tab-tip', 'description' => 'Tab-tip popover constrained to bottom-start or bottom-end alignment.'],
        'background-token' => ['label' => 'Background token', 'api' => ['backgroundToken' => 'background'], 'class' => 'ui-popover--background-token__background', 'description' => 'Popover using background token treatment.'],
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
        'closed' => ['label' => 'Closed', 'required' => true, 'description' => 'Default closed popover state.'],
        'open' => ['label' => 'Open', 'required' => false, 'description' => 'Open popover state.'],
        'positioned' => ['label' => 'Positioned', 'required' => false, 'description' => 'Alignment/placement state.'],
        'auto-aligned' => ['label' => 'Auto aligned', 'required' => false, 'description' => 'Auto-aligned positioning state.'],
        'high-contrast' => ['label' => 'High contrast', 'required' => false, 'description' => 'High-contrast state.'],
        'tab-tip' => ['label' => 'Tab tip', 'required' => false, 'description' => 'Tab-tip state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for caller-provided trigger and any focusable popover content.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-popover',
            'ui-popover-container',
            'ui-autoalign',
        ],
        'component_tokens' => [
            'popover',
            'floating-content',
            'layer',
            'motion',
        ],
        'deprecated' => [
            'feature-local popover wrappers',
            'ad hoc floating content surfaces outside x-ui.popover',
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
                'popover behavior if installed',
            ],
        ],
        'blocks' => [
            'toggletip',
            'tooltip',
            'menus',
            'shell-panels',
            'contextual-help',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Popover trigger keyboard behavior is caller-owned in Blade because trigger markup is supplied through the slot.',
            'Dismissal, Escape handling, outside click, and focus behavior are owned by installed popover JavaScript or the consuming pattern.',
        ],
        'aria' => [
            'Caller-provided trigger should reference the popover content with aria-controls, aria-expanded, aria-describedby, or aria-labelledby as appropriate.',
            'Popover content may expose role, aria-label, or aria-labelledby when supplied.',
            'Caret is decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Caller-provided trigger and focusable popover content must show visible focus.',
            'Focus containment is not owned by popover unless installed JavaScript or the consuming pattern explicitly provides it.',
        ],
        'screen_reader' => [
            'Popover content must have an accessible relationship to its trigger when it communicates essential information.',
            'Use tooltip for short non-interactive descriptions and toggletip/popover for richer contextual content.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'top-left', 'replacement' => 'top-start', 'description' => 'Deprecated Carbon alignment alias is mapped to top-start.'],
            ['name' => 'top-right', 'replacement' => 'top-end', 'description' => 'Deprecated Carbon alignment alias is mapped to top-end.'],
            ['name' => 'bottom-left', 'replacement' => 'bottom-start', 'description' => 'Deprecated Carbon alignment alias is mapped to bottom-start.'],
            ['name' => 'bottom-right', 'replacement' => 'bottom-end', 'description' => 'Deprecated Carbon alignment alias is mapped to bottom-end.'],
            ['name' => 'left-top', 'replacement' => 'left-start', 'description' => 'Deprecated Carbon alignment alias is mapped to left-start.'],
            ['name' => 'left-bottom', 'replacement' => 'left-end', 'description' => 'Deprecated Carbon alignment alias is mapped to left-end.'],
            ['name' => 'right-top', 'replacement' => 'right-start', 'description' => 'Deprecated Carbon alignment alias is mapped to right-start.'],
            ['name' => 'right-bottom', 'replacement' => 'right-end', 'description' => 'Deprecated Carbon alignment alias is mapped to right-end.'],
        ],
        'classes' => [
            'feature-local popover classes',
            'raw floating content utility clusters',
        ],
        'components' => [
            'ad hoc popover wrappers outside x-ui.popover',
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
            'resources/views/components/ui/popover/index.blade.php',
            'resources/views/components/ui/popover/content.blade.php',
        ],
        'css' => [
            'resources/css/components/popover.css',
        ],
        'contract' => [
            'resources/views/components/ui/popover/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/popover.md',
        ],
    ],
]);

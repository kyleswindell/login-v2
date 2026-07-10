<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/tooltip/contract.php
| Purpose: Tooltip Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Tooltip API that can be called from Blade,
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
        'slug' => 'tooltip',
        'label' => 'Tooltip',
        'component' => 'x-ui.tooltip',
        'summary' => 'Non-interactive contextual help disclosure for hover and focus triggers.',
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
        'usage_context' => 'Use x-ui.tooltip for short non-interactive contextual help. Use Toggletip or Popover when content must contain links, buttons, controls, or dismissible rich help.',

        'props' => [
            [
                'name' => 'text',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Legacy description-style tooltip text. Use description for new usage.',
                'compatibility' => true,
            ],
            [
                'name' => 'label',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Tooltip content that fully labels the trigger through aria-labelledby. Takes precedence over description and text.',
            ],
            [
                'name' => 'description',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Tooltip content that describes the trigger through aria-describedby.',
            ],
            [
                'name' => 'placement',
                'type' => 'string',
                'required' => false,
                'default' => 'auto',
                'values' => ['auto', 'top', 'right', 'bottom', 'left'],
                'description' => 'Preferred tooltip placement. Static auto resolves to top until JavaScript updates placement.',
            ],
            [
                'name' => 'align',
                'type' => 'string',
                'required' => false,
                'default' => 'center',
                'values' => ['start', 'center', 'end'],
                'description' => 'Tooltip alignment relative to the trigger. This is the app-owned split alignment API, not Carbon composite align.',
            ],
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'auto',
                'values' => ['auto', 'single', 'multi', 'definition'],
                'description' => 'Tooltip size. auto resolves to single or multi based on content; definition kind forces definition size.',
            ],
            [
                'name' => 'kind',
                'type' => 'string',
                'required' => false,
                'default' => 'default',
                'values' => ['default', 'definition'],
                'description' => 'Tooltip kind. Definition kind applies definition tooltip sizing and behavior expectations.',
            ],
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Tooltip content ID. A generated ID is used when omitted.',
            ],
            [
                'name' => 'open',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Static open state for reference, testing, or controlled rendering.',
            ],
            [
                'name' => 'defaultOpen',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Initial open state compatibility with Carbon Tooltip.',
            ],
            [
                'name' => 'closeOnActivation',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Data hook for JavaScript to close the tooltip when the trigger is activated.',
            ],
            [
                'name' => 'dropShadow',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Applies drop-shadow class and data hook.',
            ],
            [
                'name' => 'highContrast',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Applies high-contrast class and data hook. Kept to align with Carbon v11 behavior.',
            ],
            [
                'name' => 'enterDelayMs',
                'type' => 'int',
                'required' => false,
                'default' => 100,
                'values' => [],
                'description' => 'Data hook for JavaScript display delay in milliseconds.',
            ],
            [
                'name' => 'leaveDelayMs',
                'type' => 'int',
                'required' => false,
                'default' => 300,
                'values' => [],
                'description' => 'Data hook for JavaScript hide delay in milliseconds.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => true,
                'description' => 'Visible trigger content.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'tooltip',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-tooltip',
                'required' => true,
                'description' => 'Generated root tooltip marker.',
            ],
            [
                'name' => 'data-ui-tooltip-kind',
                'required' => true,
                'description' => 'Generated resolved kind marker.',
            ],
            [
                'name' => 'data-ui-tooltip-placement',
                'required' => true,
                'description' => 'Generated requested placement marker.',
            ],
            [
                'name' => 'data-ui-tooltip-resolved-placement',
                'required' => true,
                'description' => 'Generated static resolved placement marker.',
            ],
            [
                'name' => 'data-ui-tooltip-align',
                'required' => true,
                'description' => 'Generated resolved alignment marker.',
            ],
            [
                'name' => 'data-ui-tooltip-size',
                'required' => true,
                'description' => 'Generated resolved size marker.',
            ],
            [
                'name' => 'data-ui-tooltip-state',
                'required' => true,
                'description' => 'Generated open or closed state marker on root and content.',
            ],
            [
                'name' => 'data-ui-tooltip-relationship',
                'required' => true,
                'description' => 'Generated relationship marker: label or description.',
            ],
            [
                'name' => 'data-ui-tooltip-close-on-activation',
                'required' => true,
                'description' => 'Generated close-on-activation behavior hook.',
            ],
            [
                'name' => 'data-ui-tooltip-drop-shadow',
                'required' => true,
                'description' => 'Generated drop-shadow marker.',
            ],
            [
                'name' => 'data-ui-tooltip-high-contrast',
                'required' => true,
                'description' => 'Generated high-contrast marker.',
            ],
            [
                'name' => 'data-ui-tooltip-enter-delay-ms',
                'required' => true,
                'description' => 'Generated enter delay marker.',
            ],
            [
                'name' => 'data-ui-tooltip-leave-delay-ms',
                'required' => true,
                'description' => 'Generated leave delay marker.',
            ],
            [
                'name' => 'data-ui-tooltip-trigger',
                'required' => true,
                'description' => 'Generated trigger marker.',
            ],
            [
                'name' => 'data-ui-tooltip-content',
                'required' => true,
                'description' => 'Generated tooltip content marker.',
            ],
            [
                'name' => 'data-ui-tooltip-id',
                'required' => true,
                'description' => 'Generated tooltip content ID marker.',
            ],
            [
                'name' => 'data-ui-tooltip-caret',
                'required' => true,
                'description' => 'Generated tooltip caret marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-tooltip',
        'required' => [
            'ui-tooltip',
            'ui-tooltip-trigger',
            'ui-tooltip-trigger__wrapper',
            'ui-tooltip-content',
            'ui-tooltip-caret',
        ],
        'optional' => [
            'ui-tooltip--drop-shadow',
            'ui-tooltip--high-contrast',
        ],
        'internal' => [],
        'deprecated' => [
            'interactive controls inside tooltip content',
            'feature-local tooltip positioning classes',
            'ad hoc title-only tooltip markup where x-ui.tooltip is required',
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
            'api' => ['kind' => 'default'],
            'description' => 'Default non-interactive tooltip.',
        ],
        'definition' => [
            'label' => 'Definition',
            'api' => ['kind' => 'definition'],
            'description' => 'Definition tooltip treatment for glossary-like explanatory terms.',
        ],
        'top' => [
            'label' => 'Top placement',
            'api' => ['placement' => 'top'],
            'description' => 'Tooltip prefers top placement.',
        ],
        'right' => [
            'label' => 'Right placement',
            'api' => ['placement' => 'right'],
            'description' => 'Tooltip prefers right placement.',
        ],
        'bottom' => [
            'label' => 'Bottom placement',
            'api' => ['placement' => 'bottom'],
            'description' => 'Tooltip prefers bottom placement.',
        ],
        'left' => [
            'label' => 'Left placement',
            'api' => ['placement' => 'left'],
            'description' => 'Tooltip prefers left placement.',
        ],
        'drop-shadow' => [
            'label' => 'Drop shadow',
            'api' => ['dropShadow' => true],
            'class' => 'ui-tooltip--drop-shadow',
            'description' => 'Tooltip with drop-shadow treatment.',
        ],
        'high-contrast' => [
            'label' => 'High contrast',
            'api' => ['highContrast' => true],
            'class' => 'ui-tooltip--high-contrast',
            'description' => 'Tooltip with high-contrast treatment.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'auto' => [
            'label' => 'Auto',
            'api' => ['size' => 'auto'],
            'description' => 'Auto resolves to single-line or multi-line based on content length.',
        ],
        'single' => [
            'label' => 'Single',
            'api' => ['size' => 'single'],
            'description' => 'Single-line tooltip sizing.',
        ],
        'multi' => [
            'label' => 'Multi',
            'api' => ['size' => 'multi'],
            'description' => 'Multi-line tooltip sizing.',
        ],
        'definition' => [
            'label' => 'Definition',
            'api' => ['size' => 'definition'],
            'description' => 'Definition tooltip sizing.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'closed' => [
            'label' => 'Closed',
            'required' => true,
            'description' => 'Default hidden tooltip state.',
        ],
        'open' => [
            'label' => 'Open',
            'required' => false,
            'description' => 'Visible tooltip state.',
        ],
        'hover' => [
            'label' => 'Hover',
            'required' => false,
            'description' => 'Pointer hover trigger state owned by tooltip JavaScript/CSS.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Keyboard focus trigger state owned by the trigger element and tooltip behavior.',
        ],
        'escape-dismissed' => [
            'label' => 'Escape dismissed',
            'required' => false,
            'description' => 'Escape dismissal behavior owned by installed tooltip JavaScript.',
        ],
        'activation-dismissed' => [
            'label' => 'Activation dismissed',
            'required' => false,
            'description' => 'Optional close-on-activation behavior owned by installed tooltip JavaScript.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-tooltip',
        ],
        'component_tokens' => [
            'tooltip',
            'popover-positioning',
        ],
        'deprecated' => [
            'interactive tooltip content',
            'feature-local tooltip positioning',
            'feature-local tooltip colors',
            'raw title attributes as the only tooltip implementation where x-ui.tooltip is required',
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
                'tooltip behavior if installed',
            ],
        ],
        'blocks' => [
            'icon-button',
            'form-help',
            'definition-help',
            'toolbar-help',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Tooltip must be available from keyboard focus, not hover only.',
            'Escape dismissal should be supported by installed tooltip JavaScript.',
            'closeOnActivation should close the tooltip on click, Enter, or Space when enabled.',
        ],
        'aria' => [
            'Trigger references tooltip content through aria-labelledby when label is provided.',
            'Trigger references tooltip content through aria-describedby when description or text is provided.',
            'Tooltip content renders role="tooltip".',
            'Closed tooltip content is hidden and aria-hidden.',
            'Caret is hidden from assistive technology.',
        ],
        'focus' => [
            'Tooltip trigger must expose visible focus when focusable.',
            'Tooltip content must not contain focusable or interactive controls.',
        ],
        'screen_reader' => [
            'Tooltip label fully labels the trigger.',
            'Tooltip description supplements the trigger text.',
            'Tooltip text must be short, non-interactive, and supplemental.',
            'Required task instructions should not live only in a tooltip.',
            'Use Toggletip or Popover for interactive or dismissible rich content.',
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
                'name' => 'text',
                'replacement' => 'description',
                'description' => 'text remains accepted as a compatibility alias for description-style tooltip content.',
            ],
            [
                'name' => 'interactive tooltip content',
                'replacement' => 'x-ui.toggletip or x-ui.popover',
                'description' => 'Tooltip content is non-interactive. Use Toggletip or Popover for interactive content.',
            ],
            [
                'name' => 'Carbon composite align values',
                'replacement' => 'placement + align',
                'description' => 'The app Tooltip uses split placement and alignment props instead of Carbon composite align values.',
            ],
        ],
        'classes' => [
            'feature-local tooltip positioning classes',
            'feature-local tooltip color classes',
            'raw tooltip utility clusters',
        ],
        'components' => [
            'ad hoc tooltip markup outside x-ui.tooltip',
            'interactive help implemented as x-ui.tooltip instead of x-ui.toggletip or x-ui.popover',
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
            'resources/views/components/ui/tooltip/index.blade.php',
        ],
        'css' => [
            'resources/css/components/tooltip.css',
        ],
        'contract' => [
            'resources/views/components/ui/tooltip/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/tooltip.md',
        ],
    ],
]);

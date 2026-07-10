<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/copy-button/contract.php
| Purpose: Copy Button Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Copy Button API that can be called from
| Blade, validated by tooling, and consumed by code snippets, token tables,
| reference pages, or app layouts.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::component([
    'identity' => [
        'slug' => 'copy-button',
        'label' => 'Copy Button',
        'component' => 'x-ui.copy-button',
        'summary' => 'Icon-only clipboard action button with tooltip feedback, direct value or target-based copy source, loading/disabled states, and Button/Icon Button styling.',
    ],

    'lifecycle' => [
        'status' => 'provisional',
    ],

    'api' => [
        'usage_context' => 'Use x-ui.copy-button for icon-only clipboard actions. Use x-ui.code-snippet when displaying reusable code with built-in copy behavior.',

        'props' => [
            ['name' => 'copy', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Direct string copied by JavaScript. Equivalent to value.'],
            ['name' => 'value', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for copy.'],
            ['name' => 'target', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Selector or target reference used by JavaScript to copy content from another element.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'button', 'values' => ['button', 'submit', 'reset'], 'description' => 'Native button type.'],
            ['name' => 'label', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Visible tooltip/action label.'],
            ['name' => 'ariaLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible button label. Falls back to label or iconDescription.'],
            ['name' => 'icon', 'type' => 'string', 'required' => false, 'default' => 'copy--to-clipboard', 'values' => [], 'description' => 'Icon name rendered through x-ui.icon.'],
            ['name' => 'kind', 'type' => 'string', 'required' => false, 'default' => 'ghost', 'values' => ['primary', 'secondary', 'tertiary', 'ghost'], 'description' => 'Button kind.'],
            ['name' => 'semantic', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['primary', 'secondary', 'tertiary', 'ghost'], 'description' => 'Compatibility alias for kind.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Icon button size.'],
            ['name' => 'align', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => [], 'description' => 'Compatibility alias for tooltipPlacement.'],
            ['name' => 'tooltipPlacement', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['auto', 'top', 'top-start', 'top-end', 'right', 'right-start', 'right-end', 'bottom', 'bottom-start', 'bottom-end', 'left', 'left-start', 'left-end'], 'description' => 'Tooltip placement. Takes precedence over align.'],
            ['name' => 'tooltipAlign', 'type' => 'string', 'required' => false, 'default' => 'center', 'values' => ['start', 'center', 'end'], 'description' => 'Tooltip alignment.'],
            ['name' => 'tooltipSize', 'type' => 'string', 'required' => false, 'default' => 'single', 'values' => ['auto', 'single', 'multi', 'definition'], 'description' => 'Tooltip size treatment.'],
            ['name' => 'feedback', 'type' => 'string', 'required' => false, 'default' => 'Copied!', 'values' => [], 'description' => 'Feedback text shown after successful copy.'],
            ['name' => 'feedbackTimeout', 'type' => 'int|string', 'required' => false, 'default' => 2000, 'values' => [], 'description' => 'Feedback timeout metadata for JavaScript.'],
            ['name' => 'copyState', 'type' => 'string', 'required' => false, 'default' => 'idle', 'values' => ['idle', 'copied'], 'description' => 'Initial copy feedback state.'],
            ['name' => 'iconDescription', 'type' => 'string', 'required' => false, 'default' => 'Copy to clipboard', 'values' => [], 'description' => 'Accessible fallback label and default tooltip text.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled button state.'],
            ['name' => 'loading', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Loading state. Disables the button and renders spinner treatment.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'copy-button', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-copy-button-wrapper', 'required' => true, 'description' => 'Generated tooltip wrapper marker.'],
            ['name' => 'data-ui-copy-button', 'required' => true, 'description' => 'Generated copy button marker.'],
            ['name' => 'data-ui-copy-button-trigger', 'required' => true, 'description' => 'Generated copy trigger marker.'],
            ['name' => 'data-ui-copy-state', 'required' => true, 'description' => 'Generated copy state marker.'],
            ['name' => 'data-ui-copy-feedback', 'required' => true, 'description' => 'Generated feedback text marker.'],
            ['name' => 'data-ui-copy-feedback-timeout', 'required' => true, 'description' => 'Generated feedback timeout marker.'],
            ['name' => 'data-ui-copy-value', 'required' => false, 'description' => 'Generated direct copy value marker.'],
            ['name' => 'data-ui-copy-target', 'required' => false, 'description' => 'Generated target copy marker.'],
            ['name' => 'data-ui-copy-feedback-content', 'required' => true, 'description' => 'Generated tooltip feedback content marker.'],
        ],
    ],

    'class_contract' => [
        'root' => 'ui-copy-btn',
        'required' => [
            'ui-copy-btn',
            'ui-copy-btn__wrapper',
            'ui-copy-btn__icon',
            'ui-btn',
            'ui-btn--icon-only',
            'ui-icon-button',
            'ui-tooltip',
            'ui-icon-tooltip',
            'ui-tooltip-trigger',
            'ui-tooltip-content',
        ],
        'optional' => [
            'ui-btn--primary',
            'ui-btn--secondary',
            'ui-btn--tertiary',
            'ui-btn--ghost',
            'ui-btn--xs',
            'ui-btn--sm',
            'ui-btn--md',
            'ui-btn--lg',
            'ui-layout--size-xs',
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-btn--disabled',
            'ui-btn--loading',
            'ui-spinner',
            'ui-tooltip-trigger__wrapper',
            'ui-tooltip-caret',
            'ui-icon-tooltip--disabled',
        ],
        'internal' => [],
        'deprecated' => [
            'ad hoc clipboard buttons',
            'feature-local copy SVG buttons',
            'legacy direct icon components inside copy buttons',
        ],
    ],

    'variants' => [
        'ghost' => ['label' => 'Ghost', 'api' => ['kind' => 'ghost'], 'class' => 'ui-btn--ghost', 'description' => 'Default ghost copy button.'],
        'primary' => ['label' => 'Primary', 'api' => ['kind' => 'primary'], 'class' => 'ui-btn--primary', 'description' => 'Primary copy button.'],
        'secondary' => ['label' => 'Secondary', 'api' => ['kind' => 'secondary'], 'class' => 'ui-btn--secondary', 'description' => 'Secondary copy button.'],
        'tertiary' => ['label' => 'Tertiary', 'api' => ['kind' => 'tertiary'], 'class' => 'ui-btn--tertiary', 'description' => 'Tertiary copy button.'],
        'direct-copy' => ['label' => 'Direct copy', 'api' => ['copy' => 'Text'], 'description' => 'Copies direct string value.'],
        'target-copy' => ['label' => 'Target copy', 'api' => ['target' => '#target'], 'description' => 'Copies from target element.'],
        'copied' => ['label' => 'Copied', 'api' => ['copyState' => 'copied'], 'description' => 'Initial copied feedback state.'],
        'loading' => ['label' => 'Loading', 'api' => ['loading' => true], 'class' => 'ui-btn--loading', 'description' => 'Loading copy button state.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-btn--disabled', 'description' => 'Disabled copy button state.'],
        'auto-placement' => ['label' => 'Auto placement', 'api' => ['tooltipPlacement' => 'auto'], 'description' => 'Tooltip auto placement metadata.'],
    ],

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-btn--xs', 'description' => 'Extra small copy button.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-btn--sm', 'description' => 'Small copy button.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-btn--md', 'description' => 'Default copy button size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-btn--lg', 'description' => 'Large copy button.'],
    ],

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default idle copy button state.'],
        'idle' => ['label' => 'Idle', 'required' => true, 'description' => 'Idle copy state.'],
        'copied' => ['label' => 'Copied', 'required' => false, 'description' => 'Copied feedback state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled state.'],
        'loading' => ['label' => 'Loading', 'required' => false, 'description' => 'Loading state.'],
        'with-value' => ['label' => 'With value', 'required' => false, 'description' => 'Direct copy value exists.'],
        'with-target' => ['label' => 'With target', 'required' => false, 'description' => 'Target copy selector exists.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for the copy trigger.'],
    ],

    'tokens' => [
        'class_families' => [
            'ui-copy-btn',
            'ui-btn',
            'ui-tooltip',
        ],
        'component_tokens' => [
            'copy-button',
            'clipboard',
            'tooltip-feedback',
        ],
        'deprecated' => [
            'ad hoc clipboard buttons',
            'direct icon Blade components',
        ],
    ],

    'dependencies' => [
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
            'icons',
            'button',
            'icon-button',
            'tooltip',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'copy--to-clipboard',
                'dynamic icon prop',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'copy button clipboard behavior if installed',
                'tooltip behavior if installed',
            ],
        ],
        'blocks' => [
            'code-snippet',
            'token-tables',
            'reference-pages',
            'clipboard-actions',
        ],
    ],

    'accessibility' => [
        'keyboard' => [
            'Copy trigger must be keyboard reachable unless disabled.',
            'Activation behavior is owned by installed clipboard JavaScript.',
        ],
        'aria' => [
            'Copy trigger must have an accessible label.',
            'Tooltip feedback is associated through aria-describedby.',
            'Loading state emits aria-busy.',
            'Icon is decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Copy trigger must show visible focus.',
        ],
        'screen_reader' => [
            'Accessible label should identify the copy action.',
            'Feedback text should announce or be made available after successful copy behavior.',
        ],
    ],

    'deprecations' => [
        'props' => [
            ['name' => 'value', 'replacement' => 'copy', 'description' => 'value remains accepted as a compatibility alias for copy.'],
            ['name' => 'semantic', 'replacement' => 'kind', 'description' => 'semantic remains accepted as a compatibility alias for kind.'],
            ['name' => 'align', 'replacement' => 'tooltipPlacement', 'description' => 'align remains accepted as a compatibility alias for tooltip placement.'],
        ],
        'classes' => [
            'feature-local copy button classes',
            'raw clipboard utility clusters',
        ],
        'components' => [
            'ad hoc copy controls outside x-ui.copy-button',
        ],
    ],

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    'source' => [
        'blade' => [
            'resources/views/components/ui/copy-button/index.blade.php',
        ],
        'css' => [
            'resources/css/components/button.css',
            'resources/css/components/copy-button.css',
            'resources/css/components/tooltip.css',
        ],
        'js' => [
            'resources/js/ui-controls/copy-button.js',
        ],
        'contract' => [
            'resources/views/components/ui/copy-button/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/copy-button.md',
        ],
    ],
]);

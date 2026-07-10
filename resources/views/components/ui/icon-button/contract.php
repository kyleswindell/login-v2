<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/icon-button/contract.php
| Purpose: Icon Button Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Icon Button API that can be called from
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
        'slug' => 'icon-button',
        'label' => 'Icon Button',
        'component' => 'x-ui.icon-button',
        'summary' => 'Icon-only button or link control with optional tooltip, selected state, loading state, and badge indicator.',
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
        'usage_context' => 'Use x-ui.icon-button for icon-only actions that require an accessible name. Use x-ui.button for visible text buttons.',

        'props' => [
            ['name' => 'href', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional href. When present and interactive, the control renders as an anchor with role button.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'button', 'values' => ['button', 'submit', 'reset'], 'description' => 'Native button type when rendered as a button.'],
            ['name' => 'label', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Visible/tooltip label fallback and accessible label fallback.'],
            ['name' => 'ariaLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Explicit accessible label for the icon-only control.'],
            ['name' => 'icon', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Icon name from the internal icon registry. If omitted, slot content renders.'],
            ['name' => 'kind', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['primary', 'secondary', 'tertiary', 'ghost'], 'description' => 'Canonical icon-button visual kind.'],
            ['name' => 'semantic', 'type' => 'string', 'required' => false, 'default' => 'ghost', 'values' => ['primary', 'secondary', 'tertiary', 'ghost'], 'description' => 'Compatibility alias for kind when kind is omitted.', 'compatibility' => true],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Icon-button size.'],
            ['name' => 'tooltip', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional tooltip text. Also participates in accessible label fallback.'],
            ['name' => 'tooltipPlacement', 'type' => 'string', 'required' => false, 'default' => 'top', 'values' => ['auto', 'top', 'right', 'bottom', 'left', 'top-start', 'top-end', 'right-start', 'right-end', 'bottom-start', 'bottom-end', 'left-start', 'left-end'], 'description' => 'Tooltip placement. Composite placement aliases are accepted and normalized to placement plus alignment.'],
            ['name' => 'tooltipAlign', 'type' => 'string', 'required' => false, 'default' => 'center', 'values' => ['start', 'center', 'end'], 'description' => 'Tooltip alignment.'],
            ['name' => 'tooltipSize', 'type' => 'string', 'required' => false, 'default' => 'single', 'values' => ['auto', 'single', 'multi', 'definition'], 'description' => 'Tooltip size marker.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables button rendering. Disabled href icon buttons render as buttons because anchors do not support disabled.'],
            ['name' => 'loading', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Replaces icon with spinner and treats the control as disabled.'],
            ['name' => 'selected', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Selected state for ghost icon buttons.'],
            ['name' => 'isSelected', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false], 'description' => 'Compatibility alias for selected.', 'compatibility' => true],
            ['name' => 'badgeCount', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional badge indicator. 0 renders a dot; positive numeric values render visible count text.'],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Custom icon content used when icon prop is omitted.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'icon-button', 'description' => 'Generated control component marker.'],
            ['name' => 'data-ui-icon-button', 'required' => true, 'description' => 'Generated icon-button control marker.'],
            ['name' => 'data-ui-icon-button-kind', 'required' => true, 'description' => 'Generated resolved kind marker.'],
            ['name' => 'data-ui-icon-button-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-icon-button-loading', 'required' => true, 'description' => 'Generated loading state marker.'],
            ['name' => 'data-ui-icon-button-selected', 'required' => true, 'description' => 'Generated selected state marker.'],
            ['name' => 'data-ui-icon-button-badge', 'required' => true, 'description' => 'Generated badge presence marker.'],
            ['name' => 'data-ui-tooltip', 'required' => false, 'description' => 'Generated tooltip wrapper marker when tooltip renders.'],
            ['name' => 'data-ui-tooltip-trigger', 'required' => false, 'description' => 'Generated tooltip trigger wrapper marker.'],
            ['name' => 'data-ui-tooltip-content', 'required' => false, 'description' => 'Generated tooltip content marker.'],
            ['name' => 'data-ui-count', 'required' => false, 'description' => 'Generated badge count marker for positive numeric badge values.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-btn',
        'required' => [
            'ui-btn',
            'ui-btn--icon-only',
            'ui-icon-button',
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
            'ui-btn--selected',
            'ui-btn__icon',
            'ui-icon-button__icon',
            'ui-spinner',
            'ui-badge-indicator',
            'ui-tooltip',
            'ui-icon-tooltip',
            'ui-icon-tooltip--disabled',
            'ui-tooltip-trigger',
            'ui-tooltip-trigger__wrapper',
            'ui-tooltip-content',
            'ui-tooltip-caret',
        ],
        'internal' => [],
        'deprecated' => [
            'icon-only x-ui.button usage without x-ui.icon-button',
            'feature-local icon action classes',
            'ad hoc icon button tooltip wrappers',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'primary' => ['label' => 'Primary', 'api' => ['kind' => 'primary'], 'class' => 'ui-btn--primary', 'description' => 'Primary icon button.'],
        'secondary' => ['label' => 'Secondary', 'api' => ['kind' => 'secondary'], 'class' => 'ui-btn--secondary', 'description' => 'Secondary icon button.'],
        'tertiary' => ['label' => 'Tertiary', 'api' => ['kind' => 'tertiary'], 'class' => 'ui-btn--tertiary', 'description' => 'Tertiary icon button.'],
        'ghost' => ['label' => 'Ghost', 'api' => ['kind' => 'ghost'], 'class' => 'ui-btn--ghost', 'description' => 'Ghost icon button.'],
        'link' => ['label' => 'Link rendering', 'api' => ['href' => '#'], 'description' => 'Interactive href icon button rendered as an anchor.'],
        'with-tooltip' => ['label' => 'With tooltip', 'api' => ['tooltip' => 'Settings'], 'class' => 'ui-icon-tooltip', 'description' => 'Icon button with tooltip wrapper.'],
        'with-badge' => ['label' => 'With badge', 'api' => ['badgeCount' => 3], 'class' => 'ui-badge-indicator', 'description' => 'Icon button with badge indicator.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-btn--xs', 'description' => 'Extra small icon button.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-btn--sm', 'description' => 'Small icon button.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-btn--md', 'description' => 'Default icon button size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-btn--lg', 'description' => 'Large icon button.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled icon button state.'],
        'hover' => ['label' => 'Hover', 'required' => true, 'description' => 'Pointer hover state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for keyboard users.'],
        'active' => ['label' => 'Active', 'required' => true, 'description' => 'Pressed active state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled button state.'],
        'loading' => ['label' => 'Loading', 'required' => false, 'description' => 'Loading state with spinner and disabled behavior.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selected state for ghost icon buttons.'],
        'badge' => ['label' => 'Badge', 'required' => false, 'description' => 'Badge indicator state.'],
        'tooltip-open' => ['label' => 'Tooltip open', 'required' => false, 'description' => 'Tooltip visible state owned by tooltip JavaScript.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-btn',
            'ui-icon-button',
            'ui-badge-indicator',
            'ui-tooltip',
        ],
        'component_tokens' => [
            'button',
            'icon-button',
            'tooltip',
            'badge-indicator',
        ],
        'deprecated' => [
            'ad hoc icon-only button classes',
            'icon-only x-ui.button use where x-ui.icon-button is available',
            'feature-local notification badge dots',
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
            'button',
            'tooltip',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'dynamic icon prop',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'tooltip behavior if installed',
            ],
        ],
        'blocks' => [
            'ui-shell-header',
            'data-table-toolbar',
            'menus',
            'toolbars',
            'inline-actions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Icon button must be keyboard reachable unless disabled.',
            'Anchor-rendered icon buttons use native anchor behavior with role="button".',
            'Tooltip behavior must be keyboard accessible when tooltip is rendered.',
        ],
        'aria' => [
            'Icon-only controls require an accessible name from ariaLabel, label, tooltip, or fallback text.',
            'Loading state emits aria-busy on native button rendering.',
            'Selected ghost icon buttons emit aria-pressed.',
            'Positive badge counts are referenced through aria-describedby.',
            'Decorative icons, spinner, and tooltip caret are hidden from assistive technology.',
        ],
        'focus' => [
            'Icon button must show visible focus.',
            'Tooltip opening and closing must not trap focus.',
        ],
        'screen_reader' => [
            'Accessible label must describe the action, not the icon artwork.',
            'Badge count text must be meaningful when exposed through aria-describedby.',
            'Tooltip text must not be the only source of an accessible name if a more specific ariaLabel is needed.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'semantic', 'replacement' => 'kind', 'description' => 'semantic remains accepted as a compatibility alias for kind.'],
            ['name' => 'isSelected', 'replacement' => 'selected', 'description' => 'isSelected remains accepted as a compatibility alias for selected.'],
            ['name' => 'composite tooltipPlacement values', 'replacement' => 'tooltipPlacement + tooltipAlign', 'description' => 'Composite values such as top-start are accepted and normalized.'],
        ],
        'classes' => [
            'feature-local icon action classes',
            'feature-local badge indicator classes',
            'raw icon button utility clusters',
        ],
        'components' => [
            'icon-only x-ui.button usage where x-ui.icon-button should be used',
            'ad hoc icon button tooltip markup outside x-ui.icon-button',
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
            'resources/views/components/ui/icon-button/index.blade.php',
        ],
        'css' => [
            'resources/css/components/button.css',
            'resources/css/components/badge-indicator.css',
        ],
        'contract' => [
            'resources/views/components/ui/icon-button/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/icon-button.md',
        ],
    ],
]);

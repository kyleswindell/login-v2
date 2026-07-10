<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/button/contract.php
| Purpose: Button Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Button API that can be called from Blade,
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
        'slug' => 'button',
        'label' => 'Button',
        'component' => 'x-ui.button',
        'summary' => 'Standard action control for submit, reset, command, and link-style button usage.',
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
        'usage_context' => 'Use x-ui.button for labeled actions. Use x-ui.icon-button for icon-only actions.',

        'props' => [
            [
                'name' => 'href',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional link destination. When present and the control is interactive, the component renders an anchor.',
            ],
            [
                'name' => 'type',
                'type' => 'string',
                'required' => false,
                'default' => 'button',
                'values' => [
                    'button',
                    'submit',
                    'reset',
                ],
                'description' => 'Native button type used when rendering the button branch.',
            ],
            [
                'name' => 'kind',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [
                    'primary',
                    'secondary',
                    'tertiary',
                    'ghost',
                    'danger',
                    'danger--primary',
                    'danger--tertiary',
                    'danger--ghost',
                ],
                'description' => 'Canonical visual and semantic button kind.',
            ],
            [
                'name' => 'semantic',
                'type' => 'string',
                'required' => false,
                'default' => 'primary',
                'values' => [
                    'primary',
                    'secondary',
                    'tertiary',
                    'ghost',
                    'danger',
                    'danger--primary',
                    'danger--tertiary',
                    'danger--ghost',
                    'danger-primary',
                    'danger-tertiary',
                    'danger-ghost',
                    'neutral',
                    'warning',
                    'notice',
                    'info',
                    'success',
                ],
                'description' => 'Compatibility alias used when kind is not provided.',
                'compatibility' => true,
            ],
            [
                'name' => 'variant',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [
                    'outline',
                    'soft',
                    'ghost',
                ],
                'description' => 'Compatibility visual alias. outline and soft resolve to tertiary; ghost resolves to ghost or danger--ghost.',
                'compatibility' => true,
            ],
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'lg',
                'values' => [
                    'xs',
                    'sm',
                    'md',
                    'lg',
                    'xl',
                    '2xl',
                    'lg-expressive',
                ],
                'description' => 'Button size. lg-expressive is a compatibility value that resolves to lg plus expressive mode.',
            ],
            [
                'name' => 'expressive',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Adds expressive button treatment for approved high-presence contexts.',
            ],
            [
                'name' => 'loading',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Displays a decorative spinner, disables interaction, and emits aria-busy on the native button branch.',
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
                'description' => 'Disables interaction. Disabled or loading href buttons render as native buttons instead of anchors.',
            ],
            [
                'name' => 'icon',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Optional trailing decorative icon name from the internal icon registry.',
            ],
            [
                'name' => 'iconPosition',
                'type' => 'string',
                'required' => false,
                'default' => 'trailing',
                'values' => [
                    'trailing',
                ],
                'description' => 'Standard Button anatomy only emits trailing icons. Use x-ui.icon-button for icon-only controls.',
            ],
            [
                'name' => 'dangerDescription',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Additional hidden assistive description for danger buttons, merged into aria-describedby.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => true,
                'description' => 'Visible button label.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'button',
                'description' => 'Generated root component marker.',
            ],
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
        ],
        'optional' => [
            'ui-btn--primary',
            'ui-btn--secondary',
            'ui-btn--tertiary',
            'ui-btn--ghost',
            'ui-btn--danger',
            'ui-btn--danger--primary',
            'ui-btn--danger--tertiary',
            'ui-btn--danger--ghost',
            'ui-btn--xs',
            'ui-btn--sm',
            'ui-btn--md',
            'ui-btn--lg',
            'ui-btn--xl',
            'ui-btn--2xl',
            'ui-layout--size-xs',
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-layout--size-xl',
            'ui-layout--size-2xl',
            'ui-btn--expressive',
            'ui-btn--loading',
            'ui-btn--disabled',
        ],
        'internal' => [
            'ui-btn__label',
            'ui-btn__icon',
            'ui-spinner',
            'ui-spinner-inverse',
            'ui-visually-hidden',
        ],
        'deprecated' => [
            'local button color classes',
            'local button spacing classes',
            'icon-only usage through x-ui.button',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Kinds
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'primary' => [
            'label' => 'Primary',
            'api' => [
                'kind' => 'primary',
            ],
            'class' => 'ui-btn--primary',
            'description' => 'Primary action treatment.',
        ],
        'secondary' => [
            'label' => 'Secondary',
            'api' => [
                'kind' => 'secondary',
            ],
            'class' => 'ui-btn--secondary',
            'description' => 'Secondary action treatment.',
        ],
        'tertiary' => [
            'label' => 'Tertiary',
            'api' => [
                'kind' => 'tertiary',
            ],
            'class' => 'ui-btn--tertiary',
            'description' => 'Low-emphasis action treatment.',
        ],
        'ghost' => [
            'label' => 'Ghost',
            'api' => [
                'kind' => 'ghost',
            ],
            'class' => 'ui-btn--ghost',
            'description' => 'Minimal action treatment.',
        ],
        'danger' => [
            'label' => 'Danger',
            'api' => [
                'kind' => 'danger',
            ],
            'class' => 'ui-btn--danger',
            'description' => 'Destructive action treatment.',
        ],
        'danger--primary' => [
            'label' => 'Danger primary',
            'api' => [
                'kind' => 'danger--primary',
            ],
            'class' => 'ui-btn--danger--primary',
            'description' => 'High-emphasis destructive action treatment.',
        ],
        'danger--tertiary' => [
            'label' => 'Danger tertiary',
            'api' => [
                'kind' => 'danger--tertiary',
            ],
            'class' => 'ui-btn--danger--tertiary',
            'description' => 'Lower-emphasis destructive action treatment.',
        ],
        'danger--ghost' => [
            'label' => 'Danger ghost',
            'api' => [
                'kind' => 'danger--ghost',
            ],
            'class' => 'ui-btn--danger--ghost',
            'description' => 'Minimal destructive action treatment.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => [
            'label' => 'Extra small',
            'api' => [
                'size' => 'xs',
            ],
            'class' => 'ui-btn--xs',
            'description' => 'Extra small button size.',
        ],
        'sm' => [
            'label' => 'Small',
            'api' => [
                'size' => 'sm',
            ],
            'class' => 'ui-btn--sm',
            'description' => 'Small button size.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => [
                'size' => 'md',
            ],
            'class' => 'ui-btn--md',
            'description' => 'Medium button size.',
        ],
        'lg' => [
            'label' => 'Large',
            'api' => [
                'size' => 'lg',
            ],
            'class' => 'ui-btn--lg',
            'description' => 'Default button size.',
        ],
        'xl' => [
            'label' => 'Extra large',
            'api' => [
                'size' => 'xl',
            ],
            'class' => 'ui-btn--xl',
            'description' => 'Extra large button size.',
        ],
        '2xl' => [
            'label' => '2XL',
            'api' => [
                'size' => '2xl',
            ],
            'class' => 'ui-btn--2xl',
            'description' => 'Largest installed button size.',
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
            'description' => 'Default enabled button state.',
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
            'description' => 'Pressed interaction state.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Unavailable interaction state.',
        ],
        'loading' => [
            'label' => 'Loading',
            'required' => false,
            'description' => 'Pending interaction state that disables the control and renders a decorative spinner.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-btn',
            'ui-btn--*',
            'ui-layout--size-*',
        ],
        'component_tokens' => [
            'button',
        ],
        'deprecated' => [
            'feature-local button colors',
            'feature-local button margins',
            'raw utility clusters replacing button kinds',
            'icon-only buttons rendered through x-ui.button',
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
                'dynamic icon prop',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'menus',
            'modals',
            'notifications',
            'tables',
            'toolbars',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native button rendering must support Enter and Space activation.',
            'Anchor rendering must support normal link keyboard behavior.',
        ],
        'aria' => [
            'Loading native buttons emit aria-busy.',
            'Danger descriptions are merged with existing aria-describedby values.',
            'Decorative trailing icons are hidden from assistive technology.',
            'Disabled or loading href buttons render as native buttons instead of disabled anchors.',
        ],
        'focus' => [
            'Interactive buttons and anchors must show visible focus.',
            'Disabled buttons are not focusable through native disabled behavior.',
        ],
        'screen_reader' => [
            'The default slot must provide a meaningful visible label.',
            'Danger actions should use dangerDescription when the visible label alone does not fully communicate consequence.',
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
                'name' => 'semantic',
                'replacement' => 'kind',
                'description' => 'semantic remains accepted as a compatibility alias. New usage should prefer kind.',
            ],
            [
                'name' => 'variant',
                'replacement' => 'kind',
                'description' => 'variant remains accepted for outline, soft, and ghost compatibility. New usage should prefer kind.',
            ],
            [
                'name' => 'size:lg-expressive',
                'replacement' => 'size="lg" expressive',
                'description' => 'lg-expressive resolves to size lg plus expressive mode.',
            ],
            [
                'name' => 'iconPosition',
                'replacement' => 'trailing icon only',
                'description' => 'Standard Button only emits trailing icons. Leading icon requests are ignored by the current implementation.',
            ],
        ],
        'classes' => [
            'feature-local button color classes',
            'feature-local button spacing classes',
            'non-token button background classes',
            'non-token button text color classes',
        ],
        'components' => [
            'ad hoc button markup outside x-ui.button',
            'icon-only action controls rendered with x-ui.button instead of x-ui.icon-button',
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
            'resources/views/components/ui/button/index.blade.php',
        ],
        'css' => [
            'resources/css/components/button.css',
        ],
        'tokens' => [
            'resources/css/tokens/components/buttons.css',
        ],
        'contract' => [
            'resources/views/components/ui/button/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/button.md',
        ],
    ],
]);

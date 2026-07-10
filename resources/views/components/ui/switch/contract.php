<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/switch/contract.php
| Purpose: Switch Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Switch API that can be called from Blade,
| validated by tooling, and consumed by content switcher compositions.
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
        'slug' => 'switch',
        'label' => 'Switch',
        'component' => 'x-ui.switch',
        'summary' => 'Content switcher tab button for text and icon switch options with selected, disabled, index, name, and text metadata hooks.',
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
        'usage_context' => 'Use x-ui.switch as the child option inside x-ui.content-switcher. This is not the same surface as x-ui.toggle, which is a form-style on/off control.',

        'props' => [
            ['name' => 'index', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Option index used by content switcher JavaScript.'],
            ['name' => 'name', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Option name emitted as content switcher metadata.'],
            ['name' => 'text', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Canonical visible label and content switcher metadata text.'],
            ['name' => 'selected', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Selected tab state.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled switch option state.'],
            ['name' => 'variant', 'type' => 'string', 'required' => false, 'default' => 'text', 'values' => ['text', 'icon'], 'description' => 'Switch variant. icon represents Carbon IconSwitch through the same Blade surface.'],
            ['name' => 'icon', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional icon name for icon switch rendering.'],
            ['name' => 'iconOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Hides visible label while preserving an accessible label.'],
            ['name' => 'align', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end', 'left', 'left-start', 'left-end', 'right', 'right-start', 'right-end'], 'description' => 'Alignment metadata for icon switch tooltip/popover behavior if installed.'],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Fallback visible label for text switches, or custom icon content when variant is icon and icon prop is omitted.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'switch', 'description' => 'Generated component marker.'],
            ['name' => 'data-ui-switch', 'required' => true, 'description' => 'Generated switch marker.'],
            ['name' => 'data-ui-switch-variant', 'required' => true, 'description' => 'Generated resolved variant marker.'],
            ['name' => 'data-ui-switch-icon', 'required' => true, 'description' => 'Generated icon presence marker.'],
            ['name' => 'data-ui-switch-icon-only', 'required' => true, 'description' => 'Generated icon-only marker.'],
            ['name' => 'data-ui-switch-align', 'required' => true, 'description' => 'Generated alignment marker.'],
            ['name' => 'data-ui-content-switcher-switch', 'required' => true, 'description' => 'Generated content switcher child marker.'],
            ['name' => 'data-ui-content-switcher-index', 'required' => false, 'description' => 'Generated option index metadata.'],
            ['name' => 'data-ui-content-switcher-name', 'required' => false, 'description' => 'Generated option name metadata.'],
            ['name' => 'data-ui-content-switcher-text', 'required' => false, 'description' => 'Generated option text metadata.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-content-switcher-btn',
        'required' => [
            'ui-content-switcher-btn',
            'ui-content-switcher__label',
        ],
        'optional' => [
            'ui-content-switcher--selected',
            'ui-content-switcher-btn--icon',
            'ui-content-switcher-btn--icon-only',
            'ui-content-switcher__icon',
            'ui-visually-hidden',
            'sr-only',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local content switcher option buttons',
            'ad hoc segmented switch buttons outside x-ui.switch',
            'separate icon-switch Blade surface',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'text' => [
            'label' => 'Text',
            'api' => ['variant' => 'text'],
            'class' => 'ui-content-switcher-btn',
            'description' => 'Text switch option.',
        ],
        'icon' => [
            'label' => 'Icon',
            'api' => ['variant' => 'icon', 'icon' => 'settings'],
            'class' => 'ui-content-switcher-btn--icon',
            'description' => 'Icon switch option represented as a switch variant.',
        ],
        'icon-only' => [
            'label' => 'Icon only',
            'api' => ['variant' => 'icon', 'iconOnly' => true],
            'class' => 'ui-content-switcher-btn--icon-only',
            'description' => 'Icon-only switch with visually hidden label.',
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
            'description' => 'Default unselected switch option state.',
        ],
        'selected' => [
            'label' => 'Selected',
            'required' => true,
            'description' => 'Selected switch option state.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Disabled switch option state.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state.',
        ],
        'icon' => [
            'label' => 'Icon',
            'required' => false,
            'description' => 'Icon switch state.',
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
            'ui-content-switcher-btn',
        ],
        'component_tokens' => [
            'switch',
            'content-switcher',
            'segmented-control',
        ],
        'deprecated' => [
            'feature-local content switcher option buttons',
            'separate icon-switch component',
            'ad hoc segmented switch buttons',
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
            'content-switcher',
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
                'initContentSwitchers',
            ],
        ],
        'blocks' => [
            'content-switcher',
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
            'Switch options participate in parent content switcher keyboard behavior.',
            'Selected switch receives tabindex 0; unselected switches receive tabindex -1.',
            'Arrow key movement and automatic/manual selection behavior are owned by initContentSwitchers().',
        ],
        'aria' => [
            'Switch renders role="tab".',
            'Switch renders aria-selected based on selected state.',
            'Icon-only switches must expose an accessible label.',
            'Disabled switches render disabled attribute.',
        ],
        'focus' => [
            'Switch options must show visible focus.',
            'Roving focus behavior is owned by parent content switcher JavaScript.',
        ],
        'screen_reader' => [
            'Text or slot content must describe the switched content view.',
            'Icon-only switches must provide text or a clear slot-derived accessible label.',
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
            'feature-local content switcher option classes',
            'raw segmented switch button classes',
        ],
        'components' => [
            'separate icon-switch Blade component',
            'ad hoc switch buttons outside x-ui.switch',
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
            'resources/views/components/ui/switch/index.blade.php',
        ],
        'css' => [
            'resources/css/components/content-switcher.css',
        ],
        'contract' => [
            'resources/views/components/ui/switch/contract.php',
        ],
    ],
]);

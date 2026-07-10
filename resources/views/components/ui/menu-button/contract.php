<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/menu-button/contract.php
| Purpose: Menu Button Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Menu Button API that can be called from
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
        'slug' => 'menu-button',
        'label' => 'Menu Button',
        'component' => 'x-ui.menu-button',
        'summary' => 'Button-triggered action menu component with canonical button trigger, trigger-owned ARIA wiring, and triggerless menu surface composition.',
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
        'usage_context' => 'Use x-ui.menu-button when a visible text button should open an action menu. Use x-ui.overflow-menu for icon-only overflow action menus.',

        'props' => [
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Item-array menu content forwarded to x-ui.menu.'],
            ['name' => 'label', 'type' => 'string', 'required' => false, 'default' => 'Actions', 'values' => [], 'description' => 'Visible trigger label and menu label fallback.'],
            ['name' => 'kind', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['primary', 'tertiary', 'ghost'], 'description' => 'Canonical trigger button kind.'],
            ['name' => 'type', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['primary', 'tertiary', 'ghost', 'outline'], 'description' => 'Compatibility alias for trigger kind. This is not the native button type.', 'compatibility' => true],
            ['name' => 'variant', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['primary', 'tertiary', 'ghost', 'outline'], 'description' => 'Compatibility alias for trigger kind. outline maps to tertiary.', 'compatibility' => true],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'lg', 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Trigger and menu size.'],
            ['name' => 'menuAlignment', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'], 'description' => 'Canonical menu placement/alignment.'],
            ['name' => 'align', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['start', 'end', 'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'], 'description' => 'Compatibility alias for menuAlignment.', 'compatibility' => true],
            ['name' => 'placement', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['start', 'end', 'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'], 'description' => 'Compatibility alias for menuAlignment.', 'compatibility' => true],
            ['name' => 'open', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Rendered open state for the menu surface.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables the trigger.'],
            ['name' => 'loading', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Puts the trigger button in loading state and disables interaction.'],
            ['name' => 'tabIndex', 'type' => 'int|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Tab index forwarded to the trigger button.'],
            ['name' => 'menuBackgroundToken', 'type' => 'string', 'required' => false, 'default' => 'layer', 'values' => ['layer', 'background'], 'description' => 'Background token forwarded to the menu surface.'],
            ['name' => 'menuBorder', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Border treatment forwarded to the menu surface.'],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Explicit menu content forwarded to the triggerless x-ui.menu surface after item-array content.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'menu-button', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-menu-button', 'required' => true, 'description' => 'Generated menu button root marker.'],
            ['name' => 'data-ui-menu-button-kind', 'required' => true, 'description' => 'Generated resolved trigger kind marker.'],
            ['name' => 'data-ui-menu-button-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-menu-button-alignment', 'required' => true, 'description' => 'Generated resolved menu alignment marker.'],
            ['name' => 'data-ui-menu-button-open', 'required' => true, 'description' => 'Generated open state marker.'],
            ['name' => 'data-ui-menu-button-trigger', 'required' => true, 'description' => 'Generated trigger marker.'],
            ['name' => 'data-ui-menu-button-menu', 'required' => true, 'description' => 'Generated menu surface marker passed to x-ui.menu.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-menu-button__container',
        'required' => [
            'ui-menu-button__container',
            'ui-menu-button__trigger',
        ],
        'optional' => [
            'ui-menu-button__trigger--open',
            'ui-menu-button__top',
            'ui-menu-button__top-start',
            'ui-menu-button__top-end',
            'ui-menu-button__bottom',
            'ui-menu-button__bottom-start',
            'ui-menu-button__bottom-end',
            'ui-btn',
            'ui-btn--primary',
            'ui-btn--tertiary',
            'ui-btn--ghost',
            'ui-menu',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local menu button wrappers',
            'ad hoc button-triggered menus outside x-ui.menu-button',
            'using type prop as a native button type on x-ui.menu-button',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'primary' => [
            'label' => 'Primary',
            'api' => ['kind' => 'primary'],
            'class' => 'ui-btn--primary',
            'description' => 'Primary trigger menu button.',
        ],
        'tertiary' => [
            'label' => 'Tertiary',
            'api' => ['kind' => 'tertiary'],
            'class' => 'ui-btn--tertiary',
            'description' => 'Tertiary trigger menu button.',
        ],
        'ghost' => [
            'label' => 'Ghost',
            'api' => ['kind' => 'ghost'],
            'class' => 'ui-btn--ghost',
            'description' => 'Ghost trigger menu button.',
        ],
        'open' => [
            'label' => 'Open',
            'api' => ['open' => true],
            'class' => 'ui-menu-button__trigger--open',
            'description' => 'Menu button with open menu surface.',
        ],
        'with-items' => [
            'label' => 'With item array',
            'api' => ['items' => [['label' => 'Action']]],
            'description' => 'Menu button with item-array menu content.',
        ],
        'with-slot' => [
            'label' => 'With slot content',
            'api' => ['slot' => 'default'],
            'description' => 'Menu button with explicit slotted menu content.',
        ],
        'bordered-menu' => [
            'label' => 'Bordered menu',
            'api' => ['menuBorder' => true],
            'description' => 'Menu button with bordered menu surface.',
        ],
        'background-token-menu' => [
            'label' => 'Background token menu',
            'api' => ['menuBackgroundToken' => 'background'],
            'description' => 'Menu button with background-token menu surface.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'description' => 'Extra small menu button.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'description' => 'Small menu button.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'description' => 'Medium menu button.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'description' => 'Default menu button size.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'closed' => ['label' => 'Closed', 'required' => true, 'description' => 'Default closed menu button state.'],
        'open' => ['label' => 'Open', 'required' => false, 'description' => 'Open menu button state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled trigger state.'],
        'loading' => ['label' => 'Loading', 'required' => false, 'description' => 'Loading trigger state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for trigger and menu items.'],
        'menu-positioned' => ['label' => 'Menu positioned', 'required' => false, 'description' => 'Resolved placement state owned by menu CSS/JavaScript.'],
        'menu-triggerless' => ['label' => 'Triggerless menu surface', 'required' => true, 'description' => 'Nested x-ui.menu is rendered in triggerless mode because menu-button owns the trigger.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-menu-button',
            'ui-btn',
            'ui-menu',
        ],
        'component_tokens' => [
            'menu-button',
            'button',
            'menu',
            'menu-item',
        ],
        'deprecated' => [
            'feature-local button-triggered menu wrappers',
            'ad hoc menu button triggers',
            'using type prop as native button type on menu button',
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
            'menu',
            'menu-item',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'chevron--down',
            ],
            'components' => [
                'ui.button',
                'ui.menu',
            ],
            'js_initializers' => [
                'menu button behavior if installed',
                'menu behavior if installed',
            ],
        ],
        'blocks' => [
            'toolbars',
            'data-table-toolbar',
            'forms',
            'action-groups',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Trigger must be keyboard reachable unless disabled.',
            'Menu keyboard behavior is owned by installed menu/menu-button JavaScript.',
            'Escape, outside click, arrow navigation, and focus return are owned by installed menu behavior.',
        ],
        'aria' => [
            'Trigger owns aria-haspopup="menu", aria-expanded, and aria-controls when open.',
            'Container may emit aria-owns only while open.',
            'Menu surface renders through x-ui.menu triggerless mode.',
        ],
        'focus' => [
            'Trigger and menu items must show visible focus.',
            'Opening the menu should move focus according to installed menu behavior.',
            'Closing the menu should return focus to the trigger when appropriate.',
        ],
        'screen_reader' => [
            'Trigger label must describe the available action group.',
            'Menu item labels must describe individual actions or destinations.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'type', 'replacement' => 'kind', 'description' => 'type remains accepted as a compatibility alias for trigger kind, not native button type.'],
            ['name' => 'variant', 'replacement' => 'kind', 'description' => 'variant remains accepted as a compatibility alias for trigger kind.'],
            ['name' => 'variant:outline', 'replacement' => 'kind="tertiary"', 'description' => 'outline remains accepted as a compatibility alias for tertiary.'],
            ['name' => 'placement', 'replacement' => 'menuAlignment', 'description' => 'placement remains accepted as a compatibility alias for menuAlignment.'],
            ['name' => 'align', 'replacement' => 'menuAlignment', 'description' => 'align remains accepted as a compatibility alias for menuAlignment.'],
            ['name' => 'start', 'replacement' => 'bottom-start', 'description' => 'start remains accepted as an alignment alias.'],
            ['name' => 'end', 'replacement' => 'bottom-end', 'description' => 'end remains accepted as an alignment alias.'],
        ],
        'classes' => [
            'feature-local menu button classes',
            'raw button-triggered menu utility clusters',
        ],
        'components' => [
            'ad hoc button-triggered menus outside x-ui.menu-button',
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
            'resources/views/components/ui/menu-button/index.blade.php',
        ],
        'css' => [
            'resources/css/components/menu-button.css',
            'resources/css/components/button.css',
            'resources/css/components/menu.css',
        ],
        'contract' => [
            'resources/views/components/ui/menu-button/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/menu-button.md',
        ],
    ],
]);

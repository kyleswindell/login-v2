<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/menu/contract.php
| Purpose: Menu Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Menu API that can be called from Blade,
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
        'slug' => 'menu',
        'label' => 'Menu',
        'component' => 'x-ui.menu',
        'summary' => 'Menu composition and triggerless menu surface with item-array rendering, slot content, text/icon triggers, placement, sizing, selectable-item spacing, submenu surfaces, RTL, background token, and border treatment.',
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
        'usage_context' => 'Use x-ui.menu for action menus, triggerless menu surfaces, overflow surfaces, and composed menu content. Menu open/close state, keyboard behavior, focus movement, positioning, and submenu behavior are owned by installed menu JavaScript or the caller.',

        'props' => [
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Item-array menu content. Supports hidden, divider, dividerBefore, children, label, href, danger, selected, current, shortcut, icon, action, method, state, and selection type keys.'],
            ['name' => 'trigger', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Controls whether the menu renders its own trigger. false renders triggerless menu surface only.'],
            ['name' => 'triggerLabel', 'type' => 'string', 'required' => false, 'default' => 'Actions', 'values' => [], 'description' => 'Visible/accessibility label for the generated trigger.'],
            ['name' => 'triggerKind', 'type' => 'string', 'required' => false, 'default' => 'text', 'values' => ['text', 'icon'], 'description' => 'Generated trigger style. icon mode uses x-ui.icon-button.'],
            ['name' => 'triggerIcon', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional trigger icon name. Presence also resolves the trigger as icon mode.'],
            ['name' => 'triggerVariant', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['primary', 'secondary', 'tertiary', 'ghost'], 'description' => 'Button or icon-button trigger visual kind. Defaults to ghost for icon triggers and tertiary for text triggers.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Menu and menu item size.'],
            ['name' => 'align', 'type' => 'string', 'required' => false, 'default' => 'bottom-start', 'values' => ['start', 'end', 'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end', 'left', 'left-start', 'left-end', 'right', 'right-start', 'right-end'], 'description' => 'Compatibility alignment input. menuAlignment and placement take precedence.'],
            ['name' => 'placement', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['start', 'end', 'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end', 'left', 'left-start', 'left-end', 'right', 'right-start', 'right-end'], 'description' => 'Compatibility placement alias for menuAlignment.', 'compatibility' => true],
            ['name' => 'menuAlignment', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['start', 'end', 'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end', 'left', 'left-start', 'left-end', 'right', 'right-start', 'right-end'], 'description' => 'Canonical menu placement/alignment input.'],
            ['name' => 'open', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Rendered open state. Disabled menus force closed rendering.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables generated trigger and prevents open state.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Root/menu ID. A generated ID is used when omitted.'],
            ['name' => 'label', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Menu accessible label fallback.'],
            ['name' => 'menuLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Canonical accessible label for the menu surface.'],
            ['name' => 'triggerClass', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional extra class applied to generated trigger component.'],
            ['name' => 'triggerTooltip', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional tooltip text for icon trigger.'],
            ['name' => 'rtl', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies RTL composition state and dir attribute in triggered mode.'],
            ['name' => 'backgroundToken', 'type' => 'string', 'required' => false, 'default' => 'layer', 'values' => ['layer', 'background'], 'description' => 'Menu background token treatment.'],
            ['name' => 'border', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies bordered menu treatment.'],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Explicit menu content rendered after item-array content.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => false, 'description' => 'Generated component marker in triggered mode: menu-composition.'],
            ['name' => 'data-ui-menu-open', 'required' => false, 'description' => 'Generated open state marker on triggered root.'],
            ['name' => 'data-ui-menu-trigger', 'required' => false, 'description' => 'Generated menu trigger marker on generated trigger.'],
            ['name' => 'data-ui-menu', 'required' => true, 'description' => 'Generated menu surface marker.'],
            ['name' => 'data-ui-menu-panel', 'required' => true, 'description' => 'Generated menu panel marker.'],
            ['name' => 'data-ui-menu-placement', 'required' => true, 'description' => 'Generated resolved placement marker.'],
            ['name' => 'data-ui-menu-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-menu-background-token', 'required' => true, 'description' => 'Generated resolved background token marker.'],
            ['name' => 'data-ui-menu-submenu-panel', 'required' => false, 'description' => 'Generated submenu panel marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-menu',
        'required' => [
            'ui-menu',
        ],
        'optional' => [
            'ui-menu-composition',
            'ui-menu-composition--rtl',
            'ui-menu-composition-rtl',
            'ui-menu--xs',
            'ui-menu--sm',
            'ui-menu--md',
            'ui-menu--lg',
            'ui-menu-xs',
            'ui-menu-sm',
            'ui-menu-md',
            'ui-menu-lg',
            'ui-menu--open',
            'ui-menu--shown',
            'ui-menu--box-shadow-top',
            'ui-menu--with-selectable-items',
            'ui-menu--border',
            'ui-menu--background-token__background',
            'ui-menu-align-top',
            'ui-menu-align-top-start',
            'ui-menu-align-top-end',
            'ui-menu-align-bottom',
            'ui-menu-align-bottom-start',
            'ui-menu-align-bottom-end',
            'ui-menu-align-left',
            'ui-menu-align-left-start',
            'ui-menu-align-left-end',
            'ui-menu-align-right',
            'ui-menu-align-right-start',
            'ui-menu-align-right-end',
            'ui-menu-submenu-panel',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local menu composition classes',
            'ad hoc menu panel markup outside x-ui.menu',
            'raw overflow menu panel classes where x-ui.menu is available',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'triggered' => ['label' => 'Triggered', 'api' => ['trigger' => true], 'class' => 'ui-menu-composition', 'description' => 'Menu composition that owns trigger and menu surface.'],
        'triggerless' => ['label' => 'Triggerless', 'api' => ['trigger' => false], 'description' => 'Menu surface only. Used when another component owns trigger and ARIA wiring.'],
        'text-trigger' => ['label' => 'Text trigger', 'api' => ['triggerKind' => 'text'], 'description' => 'Generated text button trigger.'],
        'icon-trigger' => ['label' => 'Icon trigger', 'api' => ['triggerKind' => 'icon'], 'description' => 'Generated icon-button trigger.'],
        'with-items' => ['label' => 'With item array', 'api' => ['items' => [['label' => 'Action']]], 'description' => 'Menu rendered from item-array API.'],
        'with-slot' => ['label' => 'With slot content', 'api' => ['slot' => 'default'], 'description' => 'Menu rendered with explicit slot content.'],
        'with-submenu' => ['label' => 'With submenu', 'api' => ['items' => [['label' => 'More', 'children' => [['label' => 'Child']]]]], 'class' => 'ui-menu-submenu-panel', 'description' => 'Menu with submenu trigger item and submenu panel.'],
        'rtl' => ['label' => 'RTL', 'api' => ['rtl' => true], 'class' => 'ui-menu-composition--rtl', 'description' => 'Right-to-left menu composition.'],
        'bordered' => ['label' => 'Bordered', 'api' => ['border' => true], 'class' => 'ui-menu--border', 'description' => 'Menu with border treatment.'],
        'background-token' => ['label' => 'Background token', 'api' => ['backgroundToken' => 'background'], 'class' => 'ui-menu--background-token__background', 'description' => 'Menu using background token treatment.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-menu--xs', 'description' => 'Extra small menu.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-menu--sm', 'description' => 'Small menu.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-menu--md', 'description' => 'Default menu size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-menu--lg', 'description' => 'Large menu.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'closed' => ['label' => 'Closed', 'required' => true, 'description' => 'Default hidden menu state.'],
        'open' => ['label' => 'Open', 'required' => false, 'description' => 'Visible menu state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled generated trigger and forced closed menu state.'],
        'submenu-closed' => ['label' => 'Submenu closed', 'required' => false, 'description' => 'Submenu panel hidden state.'],
        'submenu-open' => ['label' => 'Submenu open', 'required' => false, 'description' => 'Submenu panel visible state owned by menu JavaScript.'],
        'with-selectable-items' => ['label' => 'With selectable items', 'required' => false, 'description' => 'Menu reserves selection indicator space.'],
        'positioned' => ['label' => 'Positioned', 'required' => false, 'description' => 'Placement/alignment state owned by menu JavaScript/CSS.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus for trigger and menu items.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-menu',
            'ui-menu-composition',
            'ui-menu-submenu-panel',
        ],
        'component_tokens' => [
            'menu',
            'menu-item',
            'button',
            'icon-button',
            'popover-positioning',
        ],
        'deprecated' => [
            'feature-local menu surfaces',
            'ad hoc menu panel markup outside x-ui.menu',
            'raw overflow menu panel classes outside menu primitives',
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
            'icon-button',
            'menu-item',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'overflow-menu--vertical',
                'chevron--down',
            ],
            'components' => [
                'ui.button',
                'ui.icon-button',
                'ui.menu-item',
            ],
            'js_initializers' => [
                'menu behavior if installed',
            ],
        ],
        'blocks' => [
            'menu-button',
            'overflow-menu',
            'data-table-toolbar',
            'breadcrumb-overflow',
            'shell-actions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Generated triggers must be keyboard reachable unless disabled.',
            'Menu panels and menu items must participate in parent menu keyboard behavior.',
            'Arrow key, Escape, Tab, submenu, and focus movement behavior are owned by menu JavaScript.',
        ],
        'aria' => [
            'Generated triggers expose aria-haspopup="menu", aria-expanded, and aria-controls.',
            'Menu surface renders role="menu" and tabindex="-1".',
            'Menu surface should have aria-label when label text is not otherwise provided.',
            'Submenu panels render role="menu" and are hidden until opened.',
        ],
        'focus' => [
            'Trigger and menu items must show visible focus.',
            'Open/close focus placement and return focus are owned by menu JavaScript.',
        ],
        'screen_reader' => [
            'Trigger label and menu label must describe the available actions.',
            'Menu items must describe action or destination clearly.',
            'Submenu trigger labels must describe the child action group.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'placement', 'replacement' => 'menuAlignment', 'description' => 'placement remains accepted as a compatibility alias.'],
            ['name' => 'align', 'replacement' => 'menuAlignment', 'description' => 'align remains accepted as a compatibility alias.'],
            ['name' => 'start', 'replacement' => 'bottom-start', 'description' => 'start remains accepted as an alignment alias.'],
            ['name' => 'end', 'replacement' => 'bottom-end', 'description' => 'end remains accepted as an alignment alias.'],
        ],
        'classes' => [
            'feature-local menu classes',
            'raw overflow menu surface classes',
            'raw menu positioning utility clusters',
        ],
        'components' => [
            'ad hoc menu surface markup outside x-ui.menu',
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
            'resources/views/components/ui/menu/index.blade.php',
        ],
        'css' => [
            'resources/css/components/menu.css',
        ],
        'contract' => [
            'resources/views/components/ui/menu/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/menu.md',
        ],
    ],
]);

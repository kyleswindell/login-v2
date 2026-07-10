<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/shell/side-nav/contract.php
| Purpose: UI Shell Side Nav Component family public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public UI Shell Side Nav API that can be called
| from Blade, validated by tooling, and consumed by shell layouts.
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
        'slug' => 'ui-shell-side-nav',
        'label' => 'UI Shell Side Nav',
        'component' => 'x-shell.side-nav',
        'summary' => 'UI shell side navigation family with persistent, rail, fixed, overlay, expandable menu, link, item, icon, header, footer, divider, and details surfaces.',
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
        'usage_context' => 'Use x-shell.side-nav and its nested side-nav subcomponents inside UI shell layouts. Shell JavaScript owns expansion behavior, overlay dismissal, focus management, Escape behavior, rail hover/focus behavior, and responsive inert behavior.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Side nav root ID. A generated ID is used when omitted.'],
            ['name' => 'label', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional aria-label for the side nav.'],
            ['name' => 'labelledby', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional aria-labelledby target for the side nav.'],
            ['name' => 'expanded', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false], 'description' => 'Controlled expanded state.'],
            ['name' => 'defaultExpanded', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Uncontrolled initial expanded state.'],
            ['name' => 'childOfHeader', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Applies child-of-header side nav treatment.'],
            ['name' => 'isChildOfHeader', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false], 'description' => 'Compatibility alias for childOfHeader.', 'compatibility' => true],
            ['name' => 'fixed', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies fixed side nav treatment.'],
            ['name' => 'isFixedNav', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false], 'description' => 'Compatibility alias for fixed.', 'compatibility' => true],
            ['name' => 'rail', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies rail side nav treatment.'],
            ['name' => 'isRail', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false], 'description' => 'Compatibility alias for rail.', 'compatibility' => true],
            ['name' => 'persistent', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Controls persistent/hidden side nav treatment.'],
            ['name' => 'isPersistent', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false], 'description' => 'Compatibility alias for persistent.', 'compatibility' => true],
            ['name' => 'addFocusListeners', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Data hook for shell JavaScript focus listeners.'],
            ['name' => 'addMouseListeners', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Data hook for shell JavaScript mouse listeners.'],
            ['name' => 'href', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional collapse/navigation href data hook.'],
            ['name' => 'enterDelayMs', 'type' => 'int|string', 'required' => false, 'default' => 100, 'values' => [], 'description' => 'Rail hover/focus enter delay data hook for shell JavaScript.'],
            ['name' => 'overlay', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Controls overlay rendering for non-fixed side nav.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Side nav content, usually side-nav header, items, links, menus, details, dividers, and footer.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-shell-side-nav', 'required' => true, 'description' => 'Generated side nav root marker.'],
            ['name' => 'data-ui-shell-side-nav-controlled', 'required' => true, 'description' => 'Generated controlled/uncontrolled marker.'],
            ['name' => 'data-ui-shell-side-nav-expanded', 'required' => true, 'description' => 'Generated expanded state marker.'],
            ['name' => 'data-ui-shell-side-nav-default-expanded', 'required' => true, 'description' => 'Generated default expanded marker.'],
            ['name' => 'data-ui-shell-side-nav-child-of-header', 'required' => true, 'description' => 'Generated child-of-header marker.'],
            ['name' => 'data-ui-shell-side-nav-fixed', 'required' => true, 'description' => 'Generated fixed marker.'],
            ['name' => 'data-ui-shell-side-nav-rail', 'required' => true, 'description' => 'Generated rail marker.'],
            ['name' => 'data-ui-shell-side-nav-persistent', 'required' => true, 'description' => 'Generated persistent marker.'],
            ['name' => 'data-ui-shell-side-nav-overlay', 'required' => false, 'description' => 'Generated overlay element marker.'],
            ['name' => 'data-ui-shell-side-nav-overlay-active', 'required' => false, 'description' => 'Generated overlay active marker.'],
            ['name' => 'data-ui-shell-side-nav-items', 'required' => false, 'description' => 'Generated side nav items list marker.'],
            ['name' => 'data-ui-shell-side-nav-item', 'required' => false, 'description' => 'Generated side nav item marker.'],
            ['name' => 'data-ui-shell-side-nav-link', 'required' => false, 'description' => 'Generated side nav link marker.'],
            ['name' => 'data-ui-shell-side-nav-link-active', 'required' => false, 'description' => 'Generated link active marker.'],
            ['name' => 'data-ui-shell-side-nav-menu', 'required' => false, 'description' => 'Generated expandable menu marker.'],
            ['name' => 'data-ui-shell-side-nav-menu-trigger', 'required' => false, 'description' => 'Generated expandable menu trigger marker.'],
            ['name' => 'data-ui-shell-side-nav-menu-panel', 'required' => false, 'description' => 'Generated expandable menu panel marker.'],
            ['name' => 'data-ui-shell-side-nav-footer-toggle', 'required' => false, 'description' => 'Generated footer toggle marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Subcomponents
    |--------------------------------------------------------------------------
    */

    'subcomponents' => [
        'items' => [
            'component' => 'x-shell.side-nav.items',
            'description' => 'Structural ul wrapper for side nav items.',
            'props' => ['expanded', 'isSideNavExpanded'],
            'slots' => ['default'],
        ],
        'item' => [
            'component' => 'x-shell.side-nav.item',
            'description' => 'Structural li wrapper for custom side nav content.',
            'props' => ['large'],
            'slots' => ['default'],
        ],
        'link' => [
            'component' => 'x-shell.side-nav.link',
            'description' => 'Side nav link or button item with optional icon and current state.',
            'props' => ['as', 'href', 'icon', 'active', 'isActive', 'current', 'large', 'expanded', 'isSideNavExpanded', 'rail', 'isRail', 'tabIndex', 'label', 'labelledby', 'wireNavigate'],
            'slots' => ['default'],
        ],
        'link-text' => [
            'component' => 'x-shell.side-nav.link-text',
            'description' => 'Side nav link text span primitive.',
            'props' => [],
            'slots' => ['default'],
        ],
        'icon' => [
            'component' => 'x-shell.side-nav.icon',
            'description' => 'Side nav icon wrapper with optional icon name or slotted icon content.',
            'props' => ['icon', 'small'],
            'slots' => ['default'],
        ],
        'header' => [
            'component' => 'x-shell.side-nav.header',
            'description' => 'Optional header region inside side nav.',
            'props' => ['icon', 'expanded', 'isSideNavExpanded'],
            'slots' => ['default'],
        ],
        'footer' => [
            'component' => 'x-shell.side-nav.footer',
            'description' => 'Footer expand/collapse toggle control.',
            'props' => ['assistiveText', 'expanded', 'controls', 'closeIcon', 'openIcon'],
            'slots' => [],
        ],
        'divider' => [
            'component' => 'x-shell.side-nav.divider',
            'description' => 'Structural separator inside side nav lists.',
            'props' => [],
            'slots' => [],
        ],
        'details' => [
            'component' => 'x-shell.side-nav.details',
            'description' => 'Side nav title/detail block.',
            'props' => ['title'],
            'slots' => ['default'],
        ],
        'menu' => [
            'component' => 'x-shell.side-nav.menu',
            'description' => 'Expandable side nav menu with trigger and nested menu list.',
            'props' => ['id', 'title', 'icon', 'active', 'isActive', 'large', 'expanded', 'defaultExpanded', 'sideNavExpanded', 'isSideNavExpanded', 'rail', 'isRail', 'tabIndex', 'chevronIcon'],
            'slots' => ['default'],
        ],
        'menu-item' => [
            'component' => 'x-shell.side-nav.menu-item',
            'description' => 'Side nav submenu item rendered as anchor or button.',
            'props' => ['as', 'href', 'active', 'isActive', 'current', 'ariaCurrent', 'wireNavigate'],
            'slots' => ['default'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-shell-side-nav',
        'required' => [
            'ui-shell-side-nav',
            'ui-shell-side-nav__navigation',
        ],
        'optional' => [
            'ui-shell-side-nav--expanded',
            'ui-shell-side-nav--collapsed',
            'ui-shell-side-nav--rail',
            'ui-shell-side-nav--ux',
            'ui-shell-side-nav--hidden',
            'ui-shell-side-nav--fixed',
            'ui-shell-side-nav--persistent',
            'ui-shell-side-nav__overlay',
            'ui-shell-side-nav__overlay--active',
            'ui-shell-side-nav__items',
            'ui-shell-side-nav__item',
            'ui-shell-side-nav__item--active',
            'ui-shell-side-nav__item--icon',
            'ui-shell-side-nav__item--large',
            'ui-shell-side-nav__item--expanded',
            'ui-shell-side-nav__link',
            'ui-shell-side-nav__link--current',
            'ui-shell-side-nav__link-text',
            'ui-shell-side-nav__icon',
            'ui-shell-side-nav__icon--small',
            'ui-shell-side-nav__icon-svg',
            'ui-shell-side-nav__submenu',
            'ui-shell-side-nav__submenu--active',
            'ui-shell-side-nav__submenu-title',
            'ui-shell-side-nav__submenu-chevron',
            'ui-shell-side-nav__submenu-chevron-icon',
            'ui-shell-side-nav__menu',
            'ui-shell-side-nav__menu-item',
            'ui-shell-side-nav__header',
            'ui-shell-side-nav__header-content',
            'ui-shell-side-nav__footer',
            'ui-shell-side-nav__toggle',
            'ui-shell-side-nav__toggle--expanded',
            'ui-shell-side-nav__divider',
            'ui-shell-side-nav__details',
            'ui-shell-side-nav__title',
            'ui-shell-side-nav__details-content',
            'ui-assistive-text',
        ],
        'internal' => [],
        'deprecated' => [
            'hyphenated side nav child component files where nested x-shell.side-nav.* API is expected',
            'feature-local side nav classes',
            'ad hoc shell side navigation markup outside x-shell.side-nav.*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'persistent' => ['label' => 'Persistent', 'api' => ['persistent' => true], 'class' => 'ui-shell-side-nav--persistent', 'description' => 'Persistent side nav treatment.'],
        'hidden' => ['label' => 'Hidden', 'api' => ['persistent' => false], 'class' => 'ui-shell-side-nav--hidden', 'description' => 'Hidden/non-persistent side nav treatment.'],
        'expanded' => ['label' => 'Expanded', 'api' => ['expanded' => true], 'class' => 'ui-shell-side-nav--expanded', 'description' => 'Expanded side nav state.'],
        'collapsed' => ['label' => 'Collapsed', 'api' => ['expanded' => false], 'class' => 'ui-shell-side-nav--collapsed', 'description' => 'Collapsed side nav state for fixed nav.'],
        'fixed' => ['label' => 'Fixed', 'api' => ['fixed' => true], 'class' => 'ui-shell-side-nav--fixed', 'description' => 'Fixed side nav treatment.'],
        'rail' => ['label' => 'Rail', 'api' => ['rail' => true], 'class' => 'ui-shell-side-nav--rail', 'description' => 'Rail side nav treatment.'],
        'child-of-header' => ['label' => 'Child of header', 'api' => ['childOfHeader' => true], 'class' => 'ui-shell-side-nav--ux', 'description' => 'Side nav is positioned as child of header.'],
        'with-overlay' => ['label' => 'With overlay', 'api' => ['overlay' => true], 'class' => 'ui-shell-side-nav__overlay', 'description' => 'Non-fixed side nav overlay rendering.'],
        'with-menu' => ['label' => 'With expandable menu', 'api' => ['component' => 'x-shell.side-nav.menu'], 'description' => 'Side nav includes expandable menu items.'],
        'with-footer' => ['label' => 'With footer toggle', 'api' => ['component' => 'x-shell.side-nav.footer'], 'description' => 'Side nav includes footer expand/collapse toggle.'],
        'with-details' => ['label' => 'With details', 'api' => ['component' => 'x-shell.side-nav.details'], 'description' => 'Side nav includes details/title block.'],
        'button-link' => ['label' => 'Button link', 'api' => ['as' => 'button'], 'description' => 'Side nav link rendered as a button.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default side nav state.'],
        'expanded' => ['label' => 'Expanded', 'required' => false, 'description' => 'Side nav or menu expanded state.'],
        'collapsed' => ['label' => 'Collapsed', 'required' => false, 'description' => 'Side nav or menu collapsed state.'],
        'overlay-active' => ['label' => 'Overlay active', 'required' => false, 'description' => 'Overlay visible for open non-fixed side nav.'],
        'overlay-hidden' => ['label' => 'Overlay hidden', 'required' => false, 'description' => 'Overlay hidden for closed non-fixed side nav.'],
        'active-link' => ['label' => 'Active link', 'required' => false, 'description' => 'Current side nav link state.'],
        'active-menu' => ['label' => 'Active menu', 'required' => false, 'description' => 'Current side nav menu state.'],
        'disabled-menu-item' => ['label' => 'Disabled menu item', 'required' => false, 'description' => 'Disabled menu/action state when caller renders disabled controls.'],
        'footer-expanded' => ['label' => 'Footer expanded', 'required' => false, 'description' => 'Footer toggle expanded state.'],
        'rail' => ['label' => 'Rail', 'required' => false, 'description' => 'Rail navigation state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for side nav links, menu triggers, menu items, and footer toggle.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-shell-side-nav',
            'ui-shell-side-nav__item',
            'ui-shell-side-nav__link',
            'ui-shell-side-nav__menu',
            'ui-shell-side-nav__icon',
        ],
        'component_tokens' => [
            'ui-shell',
            'side-nav',
            'navigation',
            'menu',
            'overlay',
        ],
        'deprecated' => [
            'hyphenated side nav child components after nested x-shell.side-nav.* normalization',
            'feature-local side nav navigation classes',
            'ad hoc shell side nav markup',
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
                'close',
                'chevron--right',
                'chevron--down',
                'dynamic side nav icon props',
            ],
            'components' => [
                'ui.icon',
                'shell.side-nav.link-text',
            ],
            'js_initializers' => [
                'shell side nav behavior if installed',
            ],
        ],
        'blocks' => [
            'ui-shell',
            'app-shell',
            'header',
            'main-content',
            'switcher',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Side nav links and buttons must be keyboard reachable when the side nav is expanded or rail behavior allows access.',
            'Collapsed non-rail side nav items should be removed from tab order.',
            'Menu triggers must activate with native button keyboard behavior.',
            'Escape, overlay click, rail hover/focus expansion, and responsive inert behavior are owned by shell JavaScript.',
        ],
        'aria' => [
            'Side nav should have aria-label or aria-labelledby when needed to distinguish navigation regions.',
            'Current links expose aria-current="page".',
            'Menu triggers expose aria-expanded and aria-controls.',
            'Menu panels reference their trigger through aria-labelledby.',
            'Footer toggle exposes aria-expanded and may expose aria-controls.',
            'Decorative icons are hidden from assistive technology.',
        ],
        'focus' => [
            'Side nav links, menu triggers, menu items, and footer toggle must show visible focus.',
            'Focus placement, focus return, overlay focus behavior, and rail focus behavior are owned by shell JavaScript.',
        ],
        'screen_reader' => [
            'Side nav link text or accessible labels must identify destinations clearly.',
            'Icon-only or rail presentations must preserve accessible names.',
            'Divider components must not be used as headings or labels.',
            'Details title should not replace the page heading.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'isChildOfHeader', 'replacement' => 'childOfHeader', 'description' => 'isChildOfHeader remains accepted as a compatibility alias.'],
            ['name' => 'isFixedNav', 'replacement' => 'fixed', 'description' => 'isFixedNav remains accepted as a compatibility alias.'],
            ['name' => 'isRail', 'replacement' => 'rail', 'description' => 'isRail remains accepted as a compatibility alias.'],
            ['name' => 'isPersistent', 'replacement' => 'persistent', 'description' => 'isPersistent remains accepted as a compatibility alias.'],
            ['name' => 'isActive', 'replacement' => 'active', 'description' => 'isActive remains accepted as a compatibility alias on links and menus.'],
            ['name' => 'current', 'replacement' => 'active', 'description' => 'current remains accepted as a current-page alias on links and menu items.'],
            ['name' => 'isSideNavExpanded', 'replacement' => 'expanded', 'description' => 'isSideNavExpanded remains accepted as a compatibility alias on child items.'],
            ['name' => 'enableExpando-style behavior', 'replacement' => 'x-shell.side-nav.menu', 'description' => 'Expandable behavior belongs to side nav menu triggers and shell JavaScript.'],
        ],
        'classes' => [
            'feature-local side nav classes',
            'raw shell side nav utility clusters',
        ],
        'components' => [
            'ad hoc shell side nav markup outside x-shell.side-nav.*',
            'hyphenated side nav child component tags after nested side-nav normalization',
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
            'resources/views/components/shell/side-nav/index.blade.php',
            'resources/views/components/shell/side-nav/items.blade.php',
            'resources/views/components/shell/side-nav/item.blade.php',
            'resources/views/components/shell/side-nav/link.blade.php',
            'resources/views/components/shell/side-nav/link-text.blade.php',
            'resources/views/components/shell/side-nav/icon.blade.php',
            'resources/views/components/shell/side-nav/header.blade.php',
            'resources/views/components/shell/side-nav/footer.blade.php',
            'resources/views/components/shell/side-nav/divider.blade.php',
            'resources/views/components/shell/side-nav/details.blade.php',
            'resources/views/components/shell/side-nav/menu.blade.php',
            'resources/views/components/shell/side-nav/menu-item.blade.php',
        ],
        'css' => [
            'resources/css/components/ui-shell/index.css',
        ],
        'contract' => [
            'resources/views/components/shell/side-nav/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/ui-shell.md',
        ],
    ],
]);

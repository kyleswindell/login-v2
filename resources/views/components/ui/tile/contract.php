<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/tile/contract.php
| Purpose: Tile Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Tile API that can be called from Blade,
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
        'slug' => 'tile',
        'label' => 'Tile',
        'component' => 'x-ui.tile',
        'summary' => 'Tile surface for static, clickable, selectable, and expandable content cards with density, selected/current, loading, disabled, metadata, icon, actions, and details support.',
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
        'usage_context' => 'Use x-ui.tile for grouped card-like surfaces, clickable cards, selectable cards, and expandable detail cards. Use x-ui.button or x-ui.link for simple inline actions.',

        'props' => [
            ['name' => 'title', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Tile title content. If omitted, the default slot may be used as title content.'],
            ['name' => 'description', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional tile description content.'],
            ['name' => 'href', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional href for clickable link tiles. Disabled clickable tiles render as buttons instead.'],
            ['name' => 'variant', 'type' => 'string', 'required' => false, 'default' => 'static', 'values' => ['static', 'clickable', 'selectable', 'expandable', 'base'], 'description' => 'Tile variant. base is accepted as an alias for static.'],
            ['name' => 'selected', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Selected state for selectable tiles and visual selected treatment.'],
            ['name' => 'current', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Current tile state. Also resolves selected state. Clickable link tiles emit aria-current.'],
            ['name' => 'expanded', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Initial expanded state for expandable tiles.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled tile state for interactive variants.'],
            ['name' => 'density', 'type' => 'string', 'required' => false, 'default' => 'standard', 'values' => ['standard', 'compact'], 'description' => 'Tile density treatment.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'button', 'values' => ['button', 'submit', 'reset'], 'description' => 'Native button type for clickable button tiles.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native input name for selectable tiles.'],
            ['name' => 'value', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native input value for selectable tiles.'],
            ['name' => 'selectionMode', 'type' => 'string', 'required' => false, 'default' => 'single', 'values' => ['single', 'multiple'], 'description' => 'Selectable tile mode. single renders radio semantics; multiple renders checkbox semantics.'],
            ['name' => 'icon', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional icon name forwarded to the tile content partial.'],
            ['name' => 'meta', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional metadata content forwarded to the tile content partial.'],
            ['name' => 'loading', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Loading/busy state marker.'],
            ['name' => 'interactive', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'For expandable tiles, separates main content/actions from the expand button.'],
            ['name' => 'expandButtonLabel', 'type' => 'string', 'required' => false, 'default' => 'Toggle tile details', 'values' => [], 'description' => 'Accessible label for the dedicated expandable interactive button.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Main tile content. Used as title content when title is omitted, or body content when title is supplied.'],
            ['name' => 'details', 'required' => false, 'description' => 'Expandable tile details panel content.'],
            ['name' => 'actions', 'required' => false, 'description' => 'Optional action content rendered in static tiles and interactive expandable tiles.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'tile', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-tile', 'required' => true, 'description' => 'Generated tile marker.'],
            ['name' => 'data-ui-tile-variant', 'required' => true, 'description' => 'Generated resolved variant marker.'],
            ['name' => 'data-ui-tile-density', 'required' => true, 'description' => 'Generated resolved density marker.'],
            ['name' => 'data-ui-tile-selection-mode', 'required' => false, 'description' => 'Generated selectable tile selection mode marker.'],
            ['name' => 'data-ui-selected', 'required' => true, 'description' => 'Generated selected state marker.'],
            ['name' => 'data-ui-current', 'required' => true, 'description' => 'Generated current state marker.'],
            ['name' => 'data-ui-expanded', 'required' => false, 'description' => 'Generated expandable state marker.'],
            ['name' => 'data-ui-tile-expanded', 'required' => false, 'description' => 'Generated expandable tile state marker.'],
            ['name' => 'data-ui-tile-interactive', 'required' => true, 'description' => 'Generated expandable interactive marker.'],
            ['name' => 'data-ui-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-loading', 'required' => true, 'description' => 'Generated loading state marker.'],
            ['name' => 'data-ui-tile-input', 'required' => false, 'description' => 'Generated selectable tile input marker.'],
            ['name' => 'data-ui-tile-expandable', 'required' => false, 'description' => 'Generated expandable tile marker.'],
            ['name' => 'data-ui-tile-expand-trigger', 'required' => false, 'description' => 'Generated expand/collapse trigger marker.'],
            ['name' => 'data-ui-tile-expanded-panel', 'required' => false, 'description' => 'Generated expandable details panel marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-tile',
        'required' => [
            'ui-tile',
        ],
        'optional' => [
            'ui-tile--static',
            'ui-tile--clickable',
            'ui-tile--selectable',
            'ui-tile--expandable',
            'ui-tile--density-standard',
            'ui-tile--density-compact',
            'ui-tile--expandable-interactive',
            'ui-tile--selected',
            'ui-tile--current',
            'ui-tile--expanded',
            'ui-tile--collapsed',
            'ui-tile--disabled',
            'ui-tile--loading',
            'ui-tile--empty',
            'ui-tile__action-icon',
            'ui-tile__input',
            'ui-tile__selection-icon',
            'ui-tile__interactive-content',
            'ui-tile__actions',
            'ui-tile__expand-button',
            'ui-tile__expand-trigger',
            'ui-tile__expanded',
        ],
        'internal' => [
            'components.ui.partials.tile-content',
        ],
        'deprecated' => [
            'feature-local card/tile wrappers',
            'ad hoc selectable card markup',
            'ad hoc expandable card markup outside x-ui.tile',
            'base variant name; use static',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'static' => ['label' => 'Static', 'api' => ['variant' => 'static'], 'class' => 'ui-tile--static', 'description' => 'Static non-interactive tile.'],
        'clickable' => ['label' => 'Clickable', 'api' => ['variant' => 'clickable'], 'class' => 'ui-tile--clickable', 'description' => 'Clickable tile rendered as an anchor when href is present and enabled, otherwise as a button.'],
        'selectable' => ['label' => 'Selectable', 'api' => ['variant' => 'selectable'], 'class' => 'ui-tile--selectable', 'description' => 'Selectable tile with radio or checkbox semantics.'],
        'expandable' => ['label' => 'Expandable', 'api' => ['variant' => 'expandable'], 'class' => 'ui-tile--expandable', 'description' => 'Expandable tile with details panel.'],
        'expandable-interactive' => ['label' => 'Expandable interactive', 'api' => ['variant' => 'expandable', 'interactive' => true], 'class' => 'ui-tile--expandable-interactive', 'description' => 'Expandable tile with separate content/actions and expand button.'],
        'compact' => ['label' => 'Compact density', 'api' => ['density' => 'compact'], 'class' => 'ui-tile--density-compact', 'description' => 'Compact density tile.'],
        'selected' => ['label' => 'Selected', 'api' => ['selected' => true], 'class' => 'ui-tile--selected', 'description' => 'Selected tile treatment.'],
        'current' => ['label' => 'Current', 'api' => ['current' => true], 'class' => 'ui-tile--current', 'description' => 'Current tile treatment.'],
        'loading' => ['label' => 'Loading', 'api' => ['loading' => true], 'class' => 'ui-tile--loading', 'description' => 'Loading/busy tile treatment.'],
        'with-actions' => ['label' => 'With actions', 'api' => ['slot' => 'actions'], 'class' => 'ui-tile__actions', 'description' => 'Tile with action slot content.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default tile state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled interactive tile state.'],
        'loading' => ['label' => 'Loading', 'required' => false, 'description' => 'Loading/busy tile state.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selected tile state.'],
        'current' => ['label' => 'Current', 'required' => false, 'description' => 'Current tile state.'],
        'expanded' => ['label' => 'Expanded', 'required' => false, 'description' => 'Expandable tile open state.'],
        'collapsed' => ['label' => 'Collapsed', 'required' => false, 'description' => 'Expandable tile collapsed state.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'Tile has no title, description, meta, icon, or body content.'],
        'interactive' => ['label' => 'Interactive', 'required' => false, 'description' => 'Clickable, selectable, or expandable interactive behavior.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for clickable, selectable, and expandable controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-tile',
        ],
        'component_tokens' => [
            'tile',
            'card',
            'selectable-card',
            'expandable-card',
        ],
        'deprecated' => [
            'feature-local card/tile wrappers',
            'ad hoc selectable/expandable card controls',
            'base tile variant name',
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
                'arrow--right',
                'chevron--down',
                'dynamic icon prop',
            ],
            'components' => [
                'ui.icon',
            ],
            'partials' => [
                'components.ui.partials.tile-content',
            ],
            'js_initializers' => [
                'tile behavior if installed',
            ],
        ],
        'blocks' => [
            'dashboard-cards',
            'selection-grids',
            'expandable-panels',
            'settings-cards',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Clickable button tiles must be keyboard reachable unless disabled.',
            'Clickable link tiles use native anchor keyboard behavior.',
            'Selectable tiles must be keyboard reachable unless disabled.',
            'Expandable triggers must be keyboard reachable unless disabled.',
            'Expand/collapse and selection behavior are owned by installed tile JavaScript or the consuming pattern.',
        ],
        'aria' => [
            'Clickable current link tiles emit aria-current.',
            'Selectable tiles expose radio or checkbox roles and aria-checked.',
            'Expandable triggers expose aria-expanded and aria-controls when a details panel is rendered.',
            'Loading tiles emit aria-busy.',
            'Disabled selectable/expandable tiles expose disabled or aria-disabled as appropriate.',
            'Decorative action icons are hidden from assistive technology.',
        ],
        'focus' => [
            'Clickable, selectable, and expandable controls must show visible focus.',
            'Nested actions inside static or expandable interactive tiles must preserve their own focus behavior.',
        ],
        'screen_reader' => [
            'Tile title/content must describe the destination, selection, or expandable content.',
            'Selectable tile groups should be wrapped by an appropriate labelled group/radiogroup when multiple related tiles are present.',
            'Expandable button labels must describe the expand/collapse action.',
            'Do not rely on visual icon treatment alone for current, selected, or disabled meaning.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'variant:base', 'replacement' => 'variant="static"', 'description' => 'base remains accepted as a compatibility alias for static.'],
        ],
        'classes' => [
            'feature-local tile/card classes',
            'raw selectable card utility clusters',
            'raw expandable card utility clusters',
        ],
        'components' => [
            'ad hoc tile/card controls outside x-ui.tile',
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
            'resources/views/components/ui/tile/index.blade.php',
            'resources/views/components/ui/partials/tile-content.blade.php',
        ],
        'css' => [
            'resources/css/components/tile.css',
        ],
        'contract' => [
            'resources/views/components/ui/tile/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/tile.md',
        ],
    ],
]);

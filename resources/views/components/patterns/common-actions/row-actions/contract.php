<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/common-actions/row-actions/contract.php
| Purpose: Row Actions Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Row Actions Pattern API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Row Actions is a Pattern API contract. It composes Action Set, Button,
| Icon Button, and Overflow Menu components to define approved compact actions
| scoped to one table row, list row, tile row, or structured row.
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
        'slug' => 'common-actions-row-actions',
        'label' => 'Row Actions',
        'component' => 'x-patterns.common-actions.row-actions',
        'api_layer' => 'Pattern API',
        'summary' => 'Common Actions pattern for compact actions scoped to a single row, with approved inline action limits, overflow behavior, destructive action placement, row context labelling, and click-propagation hooks.',
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
        'usage_context' => 'Use x-patterns.common-actions.row-actions for actions scoped to one row in a data table, contained list, structured list, tile list, or comparable repeated record layout. Use Bulk Actions for actions that apply to multiple selected rows.',

        'props' => [
            [
                'name' => 'actions',
                'type' => 'array',
                'required' => false,
                'default' => [],
                'values' => [],
                'description' => 'Optional array-driven row actions. Items may be strings or arrays with label/text, role/action, ariaLabel, href/url, target, rel, type, kind, size, name, value, icon, class, disabled, loading, danger, inline, overflow, visible, allowDuringBusy, and rowId/row_id.',
            ],
            [
                'name' => 'label',
                'type' => 'string',
                'required' => false,
                'default' => 'Row actions',
                'values' => [],
                'description' => 'Accessible label forwarded to the composed Action Set pattern. If rowLabel is supplied and label remains default, the label resolves to Actions for {rowLabel}.',
            ],
            [
                'name' => 'labelledBy',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'ID of an external element that labels the action set.',
            ],
            [
                'name' => 'rowId',
                'type' => 'string|int|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Stable row identifier emitted as row action metadata.',
            ],
            [
                'name' => 'rowLabel',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Human-readable row label used to improve action group and icon-only action labels.',
            ],
            [
                'name' => 'alignment',
                'type' => 'string',
                'required' => false,
                'default' => 'end',
                'values' => ['start', 'end', 'between'],
                'description' => 'Visual alignment treatment for the row action cluster.',
            ],
            [
                'name' => 'size',
                'type' => 'string',
                'required' => false,
                'default' => 'sm',
                'values' => ['xs', 'sm', 'md'],
                'description' => 'Default size for array-driven inline buttons and overflow trigger.',
            ],
            [
                'name' => 'density',
                'type' => 'string',
                'required' => false,
                'default' => 'compact',
                'values' => ['compact', 'comfortable'],
                'description' => 'Spacing density for the row action cluster.',
            ],
            [
                'name' => 'overflow',
                'type' => 'string',
                'required' => false,
                'default' => 'auto',
                'values' => ['auto', 'always', 'never'],
                'description' => 'Overflow placement mode. auto partitions actions based on maxInlineActions and destructive-role defaults.',
            ],
            [
                'name' => 'maxInlineActions',
                'type' => 'int|string',
                'required' => false,
                'default' => 2,
                'values' => [],
                'description' => 'Maximum inline actions rendered before remaining actions move to overflow in auto mode. Clamped from 0 to 4.',
            ],
            [
                'name' => 'overflowLabel',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Accessible label for the overflow action menu. Defaults to More actions for {rowLabel} when rowLabel is present.',
            ],
            [
                'name' => 'overflowPlacement',
                'type' => 'string',
                'required' => false,
                'default' => 'bottom-end',
                'values' => ['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'],
                'description' => 'Placement forwarded to the composed overflow menu.',
            ],
            [
                'name' => 'showLabels',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Renders inline actions with visible button labels instead of icon-only buttons when possible.',
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Disables all array-driven row actions.',
            ],
            [
                'name' => 'busy',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Marks row actions as busy and disables actions unless allowDuringBusy is true.',
            ],
            [
                'name' => 'preventRowClick',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [true, false],
                'description' => 'Emits metadata used by row/table JavaScript to prevent row click handlers from firing when an action is activated.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Manual row action controls. Slot mode is preferred when actions require exact framework bindings, confirmation dialogs, custom events, or nonstandard markup.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-pattern', 'required' => true, 'value' => 'common-actions-row-actions', 'description' => 'Generated pattern identity marker.'],
            ['name' => 'data-ui-row-actions', 'required' => true, 'description' => 'Generated row actions marker.'],
            ['name' => 'data-ui-row-actions-row-id', 'required' => false, 'description' => 'Generated row ID marker.'],
            ['name' => 'data-ui-row-actions-row-label', 'required' => false, 'description' => 'Generated row label marker.'],
            ['name' => 'data-ui-row-actions-alignment', 'required' => true, 'description' => 'Generated alignment marker.'],
            ['name' => 'data-ui-row-actions-size', 'required' => true, 'description' => 'Generated size marker.'],
            ['name' => 'data-ui-row-actions-density', 'required' => true, 'description' => 'Generated density marker.'],
            ['name' => 'data-ui-row-actions-overflow', 'required' => true, 'description' => 'Generated overflow mode marker.'],
            ['name' => 'data-ui-row-actions-inline-count', 'required' => true, 'description' => 'Generated inline action count marker.'],
            ['name' => 'data-ui-row-actions-overflow-count', 'required' => true, 'description' => 'Generated overflow action count marker.'],
            ['name' => 'data-ui-row-actions-busy', 'required' => true, 'description' => 'Generated busy marker.'],
            ['name' => 'data-ui-row-actions-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-row-actions-prevent-row-click', 'required' => true, 'description' => 'Generated row-click prevention marker.'],
            ['name' => 'data-ui-row-action', 'required' => false, 'description' => 'Generated inline row action marker.'],
            ['name' => 'data-ui-row-action-role', 'required' => false, 'description' => 'Generated row action role marker.'],
            ['name' => 'data-ui-row-action-row-id', 'required' => false, 'description' => 'Generated action row ID marker.'],
            ['name' => 'data-ui-row-action-inline', 'required' => false, 'description' => 'Generated inline action marker.'],
            ['name' => 'data-ui-row-action-danger', 'required' => false, 'description' => 'Generated danger/destructive marker.'],
            ['name' => 'data-ui-row-actions-overflow-menu', 'required' => false, 'description' => 'Generated overflow menu marker.'],
            ['name' => 'data-ui-row-action-prevent-row-click', 'required' => false, 'description' => 'Generated row-click prevention marker on individual controls.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-row-actions',
        'required' => [
            'ui-row-actions',
        ],
        'optional' => [
            'ui-row-actions--align-start',
            'ui-row-actions--align-end',
            'ui-row-actions--align-between',
            'ui-row-actions--compact',
            'ui-row-actions--comfortable',
            'ui-row-actions--with-overflow',
            'ui-row-actions--inline-only',
            'ui-row-actions--overflow-only',
            'ui-row-actions--busy',
            'ui-row-actions--disabled',
            'ui-row-actions__action',
            'ui-row-actions__action--view',
            'ui-row-actions__action--open',
            'ui-row-actions__action--edit',
            'ui-row-actions__action--duplicate',
            'ui-row-actions__action--archive',
            'ui-row-actions__action--delete',
            'ui-row-actions__action--remove',
            'ui-row-actions__action--secondary',
            'ui-row-actions__action--danger',
            'ui-row-actions__action-icon',
            'ui-row-actions__overflow',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local row action clusters',
            'raw row action button/icon wrappers outside x-patterns.common-actions.row-actions',
            'destructive row actions placed inline by default',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => [
            'label' => 'Default',
            'api' => [],
            'class' => 'ui-row-actions',
            'description' => 'Default compact row actions with auto overflow.',
        ],
        'inline-only' => [
            'label' => 'Inline only',
            'api' => ['overflow' => 'never'],
            'class' => 'ui-row-actions--inline-only',
            'description' => 'All actions render inline.',
        ],
        'overflow-only' => [
            'label' => 'Overflow only',
            'api' => ['overflow' => 'always'],
            'class' => 'ui-row-actions--overflow-only',
            'description' => 'All actions render in overflow.',
        ],
        'mixed' => [
            'label' => 'Mixed',
            'api' => ['overflow' => 'auto', 'maxInlineActions' => 2],
            'class' => 'ui-row-actions--with-overflow',
            'description' => 'High-frequency actions render inline and remaining actions render in overflow.',
        ],
        'compact' => [
            'label' => 'Compact',
            'api' => ['density' => 'compact'],
            'class' => 'ui-row-actions--compact',
            'description' => 'Compact row action spacing.',
        ],
        'comfortable' => [
            'label' => 'Comfortable',
            'api' => ['density' => 'comfortable'],
            'class' => 'ui-row-actions--comfortable',
            'description' => 'Comfortable row action spacing.',
        ],
        'show-labels' => [
            'label' => 'Show labels',
            'api' => ['showLabels' => true],
            'description' => 'Inline actions render visible button labels when possible.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'api' => ['disabled' => true],
            'class' => 'ui-row-actions--disabled',
            'description' => 'All array-driven row actions disabled.',
        ],
        'busy' => [
            'label' => 'Busy',
            'api' => ['busy' => true],
            'class' => 'ui-row-actions--busy',
            'description' => 'Busy row state disables actions unless explicitly allowed.',
        ],
        'destructive-overflow' => [
            'label' => 'Destructive overflow',
            'api' => ['actions' => [['label' => 'Delete', 'role' => 'delete']]],
            'class' => 'ui-row-actions--with-overflow',
            'description' => 'Destructive actions move to overflow by default in auto mode.',
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
            'api' => ['size' => 'xs'],
            'description' => 'Extra-small row actions.',
        ],
        'sm' => [
            'label' => 'Small',
            'api' => ['size' => 'sm'],
            'description' => 'Default small row actions.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'description' => 'Medium row actions for less dense row layouts.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => [
            'label' => 'Default',
            'required' => true,
            'description' => 'Default compact auto-overflow row action state.',
        ],
        'inline-actions' => [
            'label' => 'Inline actions',
            'required' => false,
            'description' => 'One or more actions render inline.',
        ],
        'overflow-actions' => [
            'label' => 'Overflow actions',
            'required' => false,
            'description' => 'One or more actions render in overflow.',
        ],
        'destructive-action' => [
            'label' => 'Destructive action',
            'required' => false,
            'description' => 'A danger/destructive action is present.',
        ],
        'busy' => [
            'label' => 'Busy',
            'required' => false,
            'description' => 'Row action area is busy.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Row action area is disabled.',
        ],
        'row-context-labelled' => [
            'label' => 'Row context labelled',
            'required' => false,
            'description' => 'rowLabel is used to improve accessible labels.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state belongs to composed action controls.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    'rules' => [
        'scope' => [
            'Row Actions apply to exactly one row or repeated record.',
            'Do not use Row Actions for selected-row bulk operations.',
            'Do not use Row Actions as page-level or form-level actions.',
            'Each action must be understandable as applying to the row context.',
        ],
        'inline_actions' => [
            'Inline actions should be limited to one or two high-frequency safe actions.',
            'Use icon-only inline actions only when the action has a clear accessible label.',
            'Use visible labels when icon meaning is ambiguous or row density allows.',
            'Do not place low-frequency actions inline by default.',
        ],
        'overflow' => [
            'Use overflow for lower-frequency row actions.',
            'Use overflow for destructive row actions by default.',
            'Do not hide the only important row action in overflow if users must discover it quickly.',
            'Overflow menu labels should include row context when the row label is not otherwise clear.',
        ],
        'destructive' => [
            'Destructive row actions should require confirmation or undo support where data loss is possible.',
            'Destructive row actions should not be the first inline action by default.',
            'Destructive labels must identify the destructive outcome clearly.',
        ],
        'interaction' => [
            'Row action activation should not also trigger row click or row selection behavior.',
            'Use data-ui-row-action-prevent-row-click for installed row/table JavaScript to stop propagation.',
            'Do not rely on visual placement alone to communicate row scope.',
        ],
        'composition' => [
            'Compose Action Set for semantic grouping.',
            'Compose Icon Button for compact inline icon actions.',
            'Compose Button for visible-label inline actions.',
            'Compose Overflow Menu for overflow actions.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-row-actions',
            'ui-btn',
            'ui-menu',
        ],
        'component_tokens' => [
            'row-actions',
            'action-set',
            'icon-button',
            'button',
            'overflow-menu',
            'row-scope',
        ],
        'deprecated' => [
            'feature-local row action classes',
            'raw row action utility clusters',
            'duplicated row overflow action markup',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'button',
            'icon-button',
            'overflow-menu',
            'menu',
            'data-table',
            'contained-list',
            'structured-list',
            'spacing',
            'layout',
        ],
        'uses' => [
            'icons' => [
                'dynamic action icon prop',
                'overflow menu icon through x-ui.overflow-menu',
            ],
            'components' => [
                'ui.button',
                'ui.icon-button',
                'ui.overflow-menu',
            ],
            'patterns' => [
                'common-actions.action-set',
            ],
            'js_initializers' => [
                'row action click protection if installed',
                'overflow menu behavior if installed',
            ],
        ],
        'blocks' => [
            'data-table-rows',
            'contained-list-items',
            'structured-list-rows',
            'tile-lists',
            'record-lists',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'All row action controls must be keyboard reachable unless disabled.',
            'Overflow menu keyboard behavior is owned by x-ui.overflow-menu and installed Menu JavaScript.',
            'Row actions must not require hover-only discovery for required workflows.',
        ],
        'aria' => [
            'The composed Action Set owns action group labelling.',
            'rowLabel should be used to improve icon-only action labels when row context is not otherwise announced.',
            'Overflow trigger must have an accessible label.',
            'Destructive actions must be clearly labelled.',
        ],
        'focus' => [
            'Inline actions and overflow trigger must show visible focus.',
            'Focus should not be stolen by the row container when a row action is activated.',
            'Closing overflow should return focus to the overflow trigger when JavaScript supports it.',
        ],
        'screen_reader' => [
            'Action labels should identify the row action outcome clearly.',
            'When many rows have identical icon-only actions, labels should include enough row context to distinguish them.',
            'Do not rely on row position alone to describe the target record.',
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
            'feature-local row action classes',
            'raw row action utility clusters',
        ],
        'components' => [
            'ad hoc row action wrappers outside x-patterns.common-actions.row-actions',
            'row actions implemented as bulk actions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    'enforcement' => [
        'mode' => 'pattern-guidance',
        'invalid_usage' => 'warn',
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    'source' => [
        'blade' => [
            'resources/views/components/patterns/common-actions/row-actions/index.blade.php',
        ],
        'css' => [
            'resources/css/components/button.css',
            'resources/css/components/menu.css',
            'resources/css/components/data-table.css',
        ],
        'contract' => [
            'resources/views/components/patterns/common-actions/row-actions/contract.php',
        ],
        'docs' => [],
    ],
]);

<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/common-actions/bulk-actions/contract.php
| Purpose: Bulk Actions Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Bulk Actions Pattern API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Bulk Actions is a Pattern API contract. It composes Action Set, Button Set,
| Button, Icon Button, and Overflow Menu components to define approved actions
| scoped to selected records across a table, list, collection, or search result.
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
        'slug' => 'common-actions-bulk-actions',
        'label' => 'Bulk Actions',
        'component' => 'x-patterns.common-actions.bulk-actions',
        'api_layer' => 'Pattern API',
        'summary' => 'Common Actions pattern for selected-record action groups with selection count messaging, clear-selection control, approved inline and overflow action behavior, destructive bulk action handling, busy state, and disabled empty-selection behavior.',
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
        'usage_context' => 'Use x-patterns.common-actions.bulk-actions for actions that apply to a selected set of records in a table, list, collection, or search results view. Use Row Actions for actions scoped to one record, Page Actions for page-level actions, and Form Actions for submit/cancel workflows.',

        'props' => [
            ['name' => 'actions', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Optional array-driven bulk actions. Items may be strings or arrays with label/text, role/action, ariaLabel, href/url, target, rel, type, kind, size, name, value, form, icon, class, disabled, loading, primary, danger, destructive, inline, overflow, visible, allowDuringBusy, and selectionId/selection_id.'],
            ['name' => 'label', 'type' => 'string', 'required' => false, 'default' => 'Bulk actions', 'values' => [], 'description' => 'Accessible label forwarded to the composed Action Set pattern.'],
            ['name' => 'labelledBy', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'ID of an external element that labels the action set.'],
            ['name' => 'selectionId', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Stable selection identifier emitted as bulk action metadata.'],
            ['name' => 'selectedCount', 'type' => 'int|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Number of currently selected records.'],
            ['name' => 'totalCount', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional total record count for metadata.'],
            ['name' => 'itemLabel', 'type' => 'string', 'required' => false, 'default' => 'item', 'values' => [], 'description' => 'Singular item label used in selected count text.'],
            ['name' => 'itemLabelPlural', 'type' => 'string', 'required' => false, 'default' => 'items', 'values' => [], 'description' => 'Plural item label used in selected count text.'],
            ['name' => 'selectionText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional selected count text override.'],
            ['name' => 'showSelectionCount', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Renders the selected count summary with polite live-region semantics.'],
            ['name' => 'clearSelection', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Renders a clear-selection control.'],
            ['name' => 'clearLabel', 'type' => 'string', 'required' => false, 'default' => 'Clear selection', 'values' => [], 'description' => 'Visible label for the clear-selection control.'],
            ['name' => 'clearHref', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional href for clear-selection behavior when implemented as navigation.'],
            ['name' => 'scope', 'type' => 'string', 'required' => false, 'default' => 'table', 'values' => ['table', 'list', 'collection', 'search-results', 'custom'], 'description' => 'Selected-record context scope.'],
            ['name' => 'placement', 'type' => 'string', 'required' => false, 'default' => 'batch-bar', 'values' => ['batch-bar', 'table-toolbar', 'sticky-toolbar', 'inline'], 'description' => 'Bulk action placement context.'],
            ['name' => 'alignment', 'type' => 'string', 'required' => false, 'default' => 'between', 'values' => ['start', 'end', 'between', 'stretch'], 'description' => 'Visual alignment treatment for the bulk action area.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'sm', 'values' => ['xs', 'sm', 'md'], 'description' => 'Default size for array-driven inline buttons and overflow trigger.'],
            ['name' => 'density', 'type' => 'string', 'required' => false, 'default' => 'compact', 'values' => ['compact', 'comfortable'], 'description' => 'Spacing density for the bulk action area.'],
            ['name' => 'overflow', 'type' => 'string', 'required' => false, 'default' => 'auto', 'values' => ['auto', 'always', 'never'], 'description' => 'Overflow placement mode. auto partitions actions based on maxInlineActions, primary action visibility, and destructive-role defaults.'],
            ['name' => 'maxInlineActions', 'type' => 'int|string', 'required' => false, 'default' => 2, 'values' => [], 'description' => 'Maximum non-primary inline actions rendered before remaining actions move to overflow in auto mode. Clamped from 0 to 5.'],
            ['name' => 'overflowLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label for the overflow action menu. Defaults to More bulk actions.'],
            ['name' => 'overflowPlacement', 'type' => 'string', 'required' => false, 'default' => 'bottom-end', 'values' => ['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'], 'description' => 'Placement forwarded to the composed overflow menu.'],
            ['name' => 'showLabels', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Renders inline actions with visible button labels. Non-primary icon-only actions may be rendered when false and an icon is supplied.'],
            ['name' => 'hiddenWhenEmpty', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Hides the bulk action area when selectedCount is zero.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables all array-driven bulk actions and selection controls.'],
            ['name' => 'busy', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks bulk actions as busy and disables actions unless allowDuringBusy is true. Primary actions expose loading state while busy.'],
            ['name' => 'form', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional form attribute forwarded to array-driven actions for out-of-form controls.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Manual bulk action controls. Slot mode is preferred when actions require exact selection-state bindings, framework events, confirmation flows, or custom markup.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-pattern', 'required' => true, 'value' => 'common-actions-bulk-actions', 'description' => 'Generated pattern identity marker.'],
            ['name' => 'data-ui-bulk-actions', 'required' => true, 'description' => 'Generated bulk actions root marker.'],
            ['name' => 'data-ui-bulk-actions-selection-id', 'required' => false, 'description' => 'Generated selection ID marker.'],
            ['name' => 'data-ui-bulk-actions-selected-count', 'required' => true, 'description' => 'Generated selected count marker.'],
            ['name' => 'data-ui-bulk-actions-total-count', 'required' => false, 'description' => 'Generated total count marker.'],
            ['name' => 'data-ui-bulk-actions-scope', 'required' => true, 'description' => 'Generated scope marker.'],
            ['name' => 'data-ui-bulk-actions-placement', 'required' => true, 'description' => 'Generated placement marker.'],
            ['name' => 'data-ui-bulk-actions-alignment', 'required' => true, 'description' => 'Generated alignment marker.'],
            ['name' => 'data-ui-bulk-actions-size', 'required' => true, 'description' => 'Generated size marker.'],
            ['name' => 'data-ui-bulk-actions-density', 'required' => true, 'description' => 'Generated density marker.'],
            ['name' => 'data-ui-bulk-actions-overflow', 'required' => true, 'description' => 'Generated overflow mode marker.'],
            ['name' => 'data-ui-bulk-actions-inline-count', 'required' => true, 'description' => 'Generated inline action count marker.'],
            ['name' => 'data-ui-bulk-actions-overflow-count', 'required' => true, 'description' => 'Generated overflow action count marker.'],
            ['name' => 'data-ui-bulk-actions-empty', 'required' => true, 'description' => 'Generated empty selection marker.'],
            ['name' => 'data-ui-bulk-actions-busy', 'required' => true, 'description' => 'Generated busy marker.'],
            ['name' => 'data-ui-bulk-actions-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-bulk-actions-selection', 'required' => false, 'description' => 'Generated selection summary wrapper marker.'],
            ['name' => 'data-ui-bulk-actions-selection-count', 'required' => false, 'description' => 'Generated selection count marker.'],
            ['name' => 'data-ui-bulk-actions-clear', 'required' => false, 'description' => 'Generated clear-selection control marker.'],
            ['name' => 'data-ui-bulk-actions-clear-selection-id', 'required' => false, 'description' => 'Generated clear-selection ID marker.'],
            ['name' => 'data-ui-bulk-actions-set', 'required' => true, 'description' => 'Generated composed Action Set marker.'],
            ['name' => 'data-ui-bulk-actions-button-set', 'required' => true, 'description' => 'Generated composed Button Set marker.'],
            ['name' => 'data-ui-bulk-action', 'required' => false, 'description' => 'Generated inline bulk action marker.'],
            ['name' => 'data-ui-bulk-action-role', 'required' => false, 'description' => 'Generated bulk action role marker.'],
            ['name' => 'data-ui-bulk-action-selection-id', 'required' => false, 'description' => 'Generated action selection ID marker.'],
            ['name' => 'data-ui-bulk-action-inline', 'required' => false, 'description' => 'Generated inline action marker.'],
            ['name' => 'data-ui-bulk-action-primary', 'required' => false, 'description' => 'Generated primary action marker.'],
            ['name' => 'data-ui-bulk-action-danger', 'required' => false, 'description' => 'Generated danger/destructive action marker.'],
            ['name' => 'data-ui-bulk-actions-overflow-menu', 'required' => false, 'description' => 'Generated overflow menu marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-bulk-actions',
        'required' => [
            'ui-bulk-actions',
        ],
        'optional' => [
            'ui-bulk-actions--batch-bar',
            'ui-bulk-actions--table-toolbar',
            'ui-bulk-actions--sticky-toolbar',
            'ui-bulk-actions--inline',
            'ui-bulk-actions--scope-table',
            'ui-bulk-actions--scope-list',
            'ui-bulk-actions--scope-collection',
            'ui-bulk-actions--scope-search-results',
            'ui-bulk-actions--scope-custom',
            'ui-bulk-actions--align-start',
            'ui-bulk-actions--align-end',
            'ui-bulk-actions--align-between',
            'ui-bulk-actions--align-stretch',
            'ui-bulk-actions--compact',
            'ui-bulk-actions--comfortable',
            'ui-bulk-actions--with-overflow',
            'ui-bulk-actions--inline-only',
            'ui-bulk-actions--overflow-only',
            'ui-bulk-actions--empty',
            'ui-bulk-actions--busy',
            'ui-bulk-actions--disabled',
            'ui-bulk-actions__selection',
            'ui-bulk-actions__selection-count',
            'ui-bulk-actions__clear',
            'ui-bulk-actions__actions',
            'ui-bulk-actions__action',
            'ui-bulk-actions__action--primary',
            'ui-bulk-actions__action--assign',
            'ui-bulk-actions__action--export',
            'ui-bulk-actions__action--move',
            'ui-bulk-actions__action--archive',
            'ui-bulk-actions__action--delete',
            'ui-bulk-actions__action--remove',
            'ui-bulk-actions__action--danger',
            'ui-bulk-actions__action-icon',
            'ui-bulk-actions__overflow',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local bulk action clusters',
            'raw selected-row action bars outside x-patterns.common-actions.bulk-actions',
            'bulk actions implemented as Row Actions',
            'destructive bulk actions placed inline by default',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'batch-bar' => ['label' => 'Batch bar', 'api' => ['placement' => 'batch-bar'], 'class' => 'ui-bulk-actions--batch-bar', 'description' => 'Bulk actions rendered as a selected-item batch bar.'],
        'table-toolbar' => ['label' => 'Table toolbar', 'api' => ['placement' => 'table-toolbar'], 'class' => 'ui-bulk-actions--table-toolbar', 'description' => 'Bulk actions rendered in a table toolbar.'],
        'sticky-toolbar' => ['label' => 'Sticky toolbar', 'api' => ['placement' => 'sticky-toolbar'], 'class' => 'ui-bulk-actions--sticky-toolbar', 'description' => 'Bulk actions rendered in a sticky toolbar.'],
        'inline-only' => ['label' => 'Inline only', 'api' => ['overflow' => 'never'], 'class' => 'ui-bulk-actions--inline-only', 'description' => 'All actions render inline.'],
        'overflow-only' => ['label' => 'Overflow only', 'api' => ['overflow' => 'always'], 'class' => 'ui-bulk-actions--overflow-only', 'description' => 'All actions render in overflow.'],
        'mixed' => ['label' => 'Mixed', 'api' => ['overflow' => 'auto', 'maxInlineActions' => 2], 'class' => 'ui-bulk-actions--with-overflow', 'description' => 'Primary and high-frequency actions render inline; remaining actions render in overflow.'],
        'empty' => ['label' => 'Empty selection', 'api' => ['selectedCount' => 0, 'hiddenWhenEmpty' => false], 'class' => 'ui-bulk-actions--empty', 'description' => 'Bulk action area rendered with no selected records.'],
        'busy' => ['label' => 'Busy', 'api' => ['busy' => true], 'class' => 'ui-bulk-actions--busy', 'description' => 'Busy bulk action state.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-bulk-actions--disabled', 'description' => 'Disabled bulk action area.'],
        'destructive-overflow' => ['label' => 'Destructive overflow', 'api' => ['actions' => [['label' => 'Delete selected', 'role' => 'delete']]], 'class' => 'ui-bulk-actions--with-overflow', 'description' => 'Destructive bulk actions move to overflow by default in auto mode.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'description' => 'Extra-small bulk actions.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'description' => 'Default small bulk actions.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'description' => 'Medium bulk actions.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default selected-record bulk action state.'],
        'empty-selection' => ['label' => 'Empty selection', 'required' => false, 'description' => 'No selected records.'],
        'selected-records' => ['label' => 'Selected records', 'required' => true, 'description' => 'One or more records are selected.'],
        'inline-actions' => ['label' => 'Inline actions', 'required' => false, 'description' => 'One or more actions render inline.'],
        'overflow-actions' => ['label' => 'Overflow actions', 'required' => false, 'description' => 'One or more actions render in overflow.'],
        'destructive-action' => ['label' => 'Destructive action', 'required' => false, 'description' => 'A danger/destructive bulk action is present.'],
        'busy' => ['label' => 'Busy', 'required' => false, 'description' => 'Bulk action area is busy.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Bulk action area is disabled.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state belongs to composed action controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    'rules' => [
        'scope' => [
            'Bulk Actions apply to a selected set of records.',
            'Do not use Bulk Actions for actions scoped to one row.',
            'Do not use Bulk Actions for page-level actions that do not depend on selected records.',
            'Bulk action labels should make it clear that the action applies to selected items.',
        ],
        'visibility' => [
            'Bulk Actions should normally be hidden when no records are selected.',
            'If shown while empty, controls must be disabled or clearly unavailable.',
            'Selected count should be visible or announced when bulk actions appear.',
            'Clear selection should be available when selected records can be cleared safely.',
        ],
        'hierarchy' => [
            'Primary bulk action may remain visible when it is the expected next action.',
            'Use one primary action per bulk action group.',
            'Secondary bulk actions may render inline when they are high-frequency and safe.',
            'Lower-frequency actions should move to overflow.',
        ],
        'overflow' => [
            'Use overflow for lower-frequency bulk actions.',
            'Use overflow for destructive bulk actions by default.',
            'Do not hide required next-step bulk actions in overflow.',
            'Overflow labels should identify that actions apply to the selected set.',
        ],
        'destructive' => [
            'Destructive bulk actions should require confirmation or undo support when data loss is possible.',
            'Destructive bulk labels should include selected context, such as Delete selected.',
            'Do not make destructive bulk actions the default inline action unless the selected workflow is explicitly destructive.',
        ],
        'loading' => [
            'Busy bulk state should prevent duplicate bulk submissions.',
            'Busy state should not clear the selection unless the action has completed successfully.',
            'Loading state should not move the action area or change the action order.',
        ],
        'composition' => [
            'Compose Action Set for semantic grouping.',
            'Compose Button Set for inline layout.',
            'Compose Button for visible-label bulk actions.',
            'Compose Icon Button only for secondary icon-only actions with clear accessible labels.',
            'Compose Overflow Menu for lower-frequency and destructive bulk actions.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-bulk-actions',
            'ui-btn-set',
            'ui-btn',
            'ui-menu',
        ],
        'component_tokens' => [
            'bulk-actions',
            'batch-actions',
            'selected-record-actions',
            'action-set',
            'button-set',
            'overflow-menu',
        ],
        'deprecated' => [
            'feature-local bulk action classes',
            'raw selected-row action bars',
            'duplicated bulk overflow action markup',
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
            'button-set',
            'icon-button',
            'overflow-menu',
            'menu',
            'data-table',
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
                'ui.button-set',
                'ui.icon-button',
                'ui.overflow-menu',
            ],
            'patterns' => [
                'common-actions.action-set',
            ],
            'js_initializers' => [
                'bulk action behavior if installed',
                'clear selection behavior if installed',
                'overflow menu behavior if installed',
            ],
        ],
        'blocks' => [
            'data-table-toolbars',
            'batch-action-bars',
            'collection-toolbars',
            'search-results-toolbars',
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
            'All bulk action controls must be keyboard reachable unless disabled or hidden.',
            'Clear selection must be keyboard reachable when rendered.',
            'Overflow menu keyboard behavior is owned by x-ui.overflow-menu and installed Menu JavaScript.',
            'Bulk actions must not require hover-only discovery for required workflows.',
        ],
        'aria' => [
            'The selected count should be announced with polite live-region semantics when it changes.',
            'The composed Action Set owns action group labelling.',
            'Bulk action labels should identify selected-item scope.',
            'Overflow trigger must have an accessible label.',
            'Destructive actions must be clearly labelled.',
        ],
        'focus' => [
            'Bulk actions, clear selection, and overflow trigger must show visible focus.',
            'When selected count changes to zero and the bar hides, focus should move to a safe control or remain in the table/list according to installed behavior.',
            'Closing overflow should return focus to the overflow trigger when JavaScript supports it.',
        ],
        'screen_reader' => [
            'Selected count text should clearly identify how many records are selected.',
            'Bulk action labels should identify the selected-set outcome clearly.',
            'Destructive bulk action copy should identify what will happen to selected items.',
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
            'feature-local bulk action classes',
            'raw bulk action utility clusters',
        ],
        'components' => [
            'ad hoc bulk action wrappers outside x-patterns.common-actions.bulk-actions',
            'bulk actions implemented as row actions',
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
            'resources/views/components/patterns/common-actions/bulk-actions/index.blade.php',
        ],
        'css' => [
            'resources/css/components/button.css',
            'resources/css/components/menu.css',
            'resources/css/components/data-table.css',
        ],
        'contract' => [
            'resources/views/components/patterns/common-actions/bulk-actions/contract.php',
        ],
        'docs' => [],
    ],
]);

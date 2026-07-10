<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/common-actions/empty-state-actions/contract.php
| Purpose: Empty State Actions Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Empty State Actions Pattern API that can be
| called from Blade, validated by tooling, and consumed by app layouts or
| Patterns.
|
| Empty State Actions is a Pattern API contract. It composes Action Set,
| Button Set, Button, and Icon components to define approved actions for empty,
| zero, no-results, error, offline, permission, and first-run recovery states.
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
        'slug' => 'common-actions-empty-state-actions',
        'label' => 'Empty State Actions',
        'component' => 'x-patterns.common-actions.empty-state-actions',
        'api_layer' => 'Pattern API',
        'summary' => 'Common Actions pattern for empty-state recovery actions, setup actions, retry actions, clear-filter actions, support links, and first-run next steps with approved hierarchy, placement, and accessibility rules.',
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
        'usage_context' => 'Use x-patterns.common-actions.empty-state-actions inside empty states, zero states, no-results states, error states, offline states, permission states, and first-run setup states. Use Page Actions, Row Actions, Form Actions, or Bulk Actions when actions are scoped to an existing page, row, form, or selected-record set instead of the empty-state recovery path.',

        'props' => [
            ['name' => 'actions', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Optional array-driven empty-state actions. Items may be strings or arrays with label/text, role/action, ariaLabel, href/url, target, rel, type, kind, size, name, value, form, icon, class, visible, disabled, loading, primary, allowDuringBusy, and emptyStateId/empty_state_id. Destructive roles are filtered out.'],
            ['name' => 'label', 'type' => 'string', 'required' => false, 'default' => 'Empty state actions', 'values' => [], 'description' => 'Accessible label forwarded to the composed Action Set pattern. If emptyStateLabel is supplied and label remains default, the label resolves to Actions for {emptyStateLabel}.'],
            ['name' => 'labelledBy', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'ID of an external element that labels the action set.'],
            ['name' => 'emptyStateId', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Stable empty-state identifier emitted as action metadata.'],
            ['name' => 'emptyStateLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Human-readable empty-state label used to improve action group and action labels.'],
            ['name' => 'context', 'type' => 'string', 'required' => false, 'default' => 'empty', 'values' => ['empty', 'zero', 'no-results', 'error', 'offline', 'first-run', 'permission', 'filtered'], 'description' => 'Empty-state context type.'],
            ['name' => 'placement', 'type' => 'string', 'required' => false, 'default' => 'body', 'values' => ['body', 'card', 'table', 'section', 'modal'], 'description' => 'Empty-state placement context.'],
            ['name' => 'alignment', 'type' => 'string', 'required' => false, 'default' => 'center', 'values' => ['start', 'center', 'end', 'stretch'], 'description' => 'Visual alignment treatment for the action group.'],
            ['name' => 'orientation', 'type' => 'string', 'required' => false, 'default' => 'horizontal', 'values' => ['horizontal', 'vertical'], 'description' => 'Action orientation forwarded to Action Set and Button Set.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'md', 'lg'], 'description' => 'Default button size for array-driven actions.'],
            ['name' => 'density', 'type' => 'string', 'required' => false, 'default' => 'comfortable', 'values' => ['compact', 'comfortable'], 'description' => 'Spacing density for the empty-state action group.'],
            ['name' => 'fluid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Enables fluid Button Set layout.'],
            ['name' => 'autoStack', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Enables Button Set auto-stack treatment when fluid is active.'],
            ['name' => 'maxPrimaryActions', 'type' => 'int|string', 'required' => false, 'default' => 1, 'values' => [], 'description' => 'Maximum primary actions allowed in array-driven rendering. Clamped from 1 to 2. Additional primary-like actions are demoted to secondary treatment.'],
            ['name' => 'busy', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks empty-state actions as busy and disables actions unless allowDuringBusy is true. Primary actions expose loading state while busy.'],
            ['name' => 'loading', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Alias-style busy state for retry or recovery loading flows.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables all array-driven empty-state actions.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Manual empty-state action controls. Slot mode is preferred when actions require exact links, route bindings, support/contact flows, framework handlers, or nonstandard markup.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-pattern', 'required' => true, 'value' => 'common-actions-empty-state-actions', 'description' => 'Generated pattern identity marker.'],
            ['name' => 'data-ui-empty-state-actions', 'required' => true, 'description' => 'Generated empty-state actions marker.'],
            ['name' => 'data-ui-empty-state-actions-empty-state-id', 'required' => false, 'description' => 'Generated empty-state ID marker.'],
            ['name' => 'data-ui-empty-state-actions-empty-state-label', 'required' => false, 'description' => 'Generated empty-state label marker.'],
            ['name' => 'data-ui-empty-state-actions-context', 'required' => true, 'description' => 'Generated context marker.'],
            ['name' => 'data-ui-empty-state-actions-placement', 'required' => true, 'description' => 'Generated placement marker.'],
            ['name' => 'data-ui-empty-state-actions-alignment', 'required' => true, 'description' => 'Generated alignment marker.'],
            ['name' => 'data-ui-empty-state-actions-orientation', 'required' => true, 'description' => 'Generated orientation marker.'],
            ['name' => 'data-ui-empty-state-actions-size', 'required' => true, 'description' => 'Generated size marker.'],
            ['name' => 'data-ui-empty-state-actions-density', 'required' => true, 'description' => 'Generated density marker.'],
            ['name' => 'data-ui-empty-state-actions-fluid', 'required' => true, 'description' => 'Generated fluid marker.'],
            ['name' => 'data-ui-empty-state-actions-busy', 'required' => true, 'description' => 'Generated busy marker.'],
            ['name' => 'data-ui-empty-state-actions-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-empty-state-actions-button-set', 'required' => true, 'description' => 'Generated composed Button Set marker.'],
            ['name' => 'data-ui-empty-state-action', 'required' => false, 'description' => 'Generated action marker.'],
            ['name' => 'data-ui-empty-state-action-role', 'required' => false, 'description' => 'Generated action role marker.'],
            ['name' => 'data-ui-empty-state-action-index', 'required' => false, 'description' => 'Generated action index marker.'],
            ['name' => 'data-ui-empty-state-action-empty-state-id', 'required' => false, 'description' => 'Generated action empty-state ID marker.'],
            ['name' => 'data-ui-empty-state-action-primary', 'required' => false, 'description' => 'Generated primary action marker.'],
            ['name' => 'data-ui-empty-state-action-disabled', 'required' => false, 'description' => 'Generated action disabled marker.'],
            ['name' => 'data-ui-empty-state-action-loading', 'required' => false, 'description' => 'Generated action loading marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-empty-state-actions',
        'required' => [
            'ui-empty-state-actions',
        ],
        'optional' => [
            'ui-empty-state-actions--context-empty',
            'ui-empty-state-actions--context-zero',
            'ui-empty-state-actions--context-no-results',
            'ui-empty-state-actions--context-error',
            'ui-empty-state-actions--context-offline',
            'ui-empty-state-actions--context-first-run',
            'ui-empty-state-actions--context-permission',
            'ui-empty-state-actions--context-filtered',
            'ui-empty-state-actions--body',
            'ui-empty-state-actions--card',
            'ui-empty-state-actions--table',
            'ui-empty-state-actions--section',
            'ui-empty-state-actions--modal',
            'ui-empty-state-actions--horizontal',
            'ui-empty-state-actions--vertical',
            'ui-empty-state-actions--align-start',
            'ui-empty-state-actions--align-center',
            'ui-empty-state-actions--align-end',
            'ui-empty-state-actions--align-stretch',
            'ui-empty-state-actions--compact',
            'ui-empty-state-actions--comfortable',
            'ui-empty-state-actions--fluid',
            'ui-empty-state-actions--busy',
            'ui-empty-state-actions--disabled',
            'ui-empty-state-actions__action',
            'ui-empty-state-actions__action--primary',
            'ui-empty-state-actions__action--create',
            'ui-empty-state-actions__action--add',
            'ui-empty-state-actions__action--retry',
            'ui-empty-state-actions__action--refresh',
            'ui-empty-state-actions__action--clear-filters',
            'ui-empty-state-actions__action--reset-search',
            'ui-empty-state-actions__action--setup',
            'ui-empty-state-actions__action--import',
            'ui-empty-state-actions__action--connect',
            'ui-empty-state-actions__action--request-access',
            'ui-empty-state-actions__action--learn-more',
            'ui-empty-state-actions__action--view-docs',
            'ui-empty-state-actions__action--contact-support',
            'ui-empty-state-actions__action--secondary',
            'ui-empty-state-actions__action-icon',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local empty-state action wrappers',
            'raw empty-state button clusters outside x-patterns.common-actions.empty-state-actions',
            'destructive actions in empty states',
            'empty-state actions used for row, page, form, or bulk scope',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'empty' => ['label' => 'Empty', 'api' => ['context' => 'empty'], 'class' => 'ui-empty-state-actions--context-empty', 'description' => 'Generic empty-state actions.'],
        'zero' => ['label' => 'Zero state', 'api' => ['context' => 'zero'], 'class' => 'ui-empty-state-actions--context-zero', 'description' => 'First-use or no-content-yet actions.'],
        'no-results' => ['label' => 'No results', 'api' => ['context' => 'no-results'], 'class' => 'ui-empty-state-actions--context-no-results', 'description' => 'No-results recovery actions.'],
        'error' => ['label' => 'Error recovery', 'api' => ['context' => 'error'], 'class' => 'ui-empty-state-actions--context-error', 'description' => 'Error recovery actions such as retry or contact support.'],
        'offline' => ['label' => 'Offline', 'api' => ['context' => 'offline'], 'class' => 'ui-empty-state-actions--context-offline', 'description' => 'Offline-state recovery actions.'],
        'permission' => ['label' => 'Permission', 'api' => ['context' => 'permission'], 'class' => 'ui-empty-state-actions--context-permission', 'description' => 'Permission or access recovery actions.'],
        'filtered' => ['label' => 'Filtered', 'api' => ['context' => 'filtered'], 'class' => 'ui-empty-state-actions--context-filtered', 'description' => 'Filtered-empty-state actions, usually clear filters or reset search.'],
        'horizontal' => ['label' => 'Horizontal', 'api' => ['orientation' => 'horizontal'], 'class' => 'ui-empty-state-actions--horizontal', 'description' => 'Horizontal action layout.'],
        'vertical' => ['label' => 'Vertical', 'api' => ['orientation' => 'vertical'], 'class' => 'ui-empty-state-actions--vertical', 'description' => 'Vertical action layout.'],
        'busy' => ['label' => 'Busy', 'api' => ['busy' => true], 'class' => 'ui-empty-state-actions--busy', 'description' => 'Busy recovery action state.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-empty-state-actions--disabled', 'description' => 'Disabled empty-state action state.'],
        'slot-mode' => ['label' => 'Slot mode', 'api' => ['slot' => 'default'], 'description' => 'Caller provides exact action controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [],

    /*
    |--------------------------------------------------------------------------
    | Pattern States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default centered empty-state action state.'],
        'primary-recovery' => ['label' => 'Primary recovery', 'required' => true, 'description' => 'Primary action represents the best next step or recovery path.'],
        'secondary-support' => ['label' => 'Secondary support', 'required' => false, 'description' => 'Secondary action provides documentation, support, browsing, or alternate recovery.'],
        'busy' => ['label' => 'Busy', 'required' => false, 'description' => 'Primary recovery action is loading or processing.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Actions are disabled.'],
        'no-results' => ['label' => 'No results', 'required' => false, 'description' => 'No-results context is active.'],
        'error-recovery' => ['label' => 'Error recovery', 'required' => false, 'description' => 'Error recovery context is active.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state belongs to composed action controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    'rules' => [
        'scope' => [
            'Empty State Actions apply to the empty-state recovery path only.',
            'Do not use Empty State Actions for existing row, page, form, or selected-record actions.',
            'The action group should reinforce the empty-state message rather than introduce unrelated workflows.',
            'Destructive actions do not belong in empty states.',
        ],
        'hierarchy' => [
            'Use one primary action for the best next step or recovery path.',
            'Use secondary actions for lower-commitment help, documentation, browsing, or support paths.',
            'Do not present multiple competing primary actions.',
            'Avoid long action clusters in empty states; consider a different layout if more than two or three actions are needed.',
        ],
        'context' => [
            'Zero states should help users create, import, connect, or set up the first item.',
            'No-results states should prefer clear filters, reset search, or broaden search actions.',
            'Error states should prefer retry, refresh, or contact support actions.',
            'Permission states should prefer request access, switch account, or contact administrator actions.',
            'Offline states should prefer retry or view cached/offline-safe content actions.',
        ],
        'loading' => [
            'Busy recovery state should prevent duplicate recovery submissions.',
            'Loading state should not move the action area or change action order.',
            'Support or documentation links may remain enabled during retry/loading if they are safe.',
        ],
        'copy' => [
            'Action labels should be specific: Create project, Clear filters, Retry loading, Request access.',
            'Avoid vague labels like OK, Continue, or Submit unless the empty-state text makes the outcome clear.',
            'Secondary action labels should not compete with the primary recovery action.',
        ],
        'composition' => [
            'Compose Action Set for semantic grouping.',
            'Compose Button Set for action layout.',
            'Compose Button for visible action controls.',
            'Use links only when the action navigates away rather than changing the current empty state.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-empty-state-actions',
            'ui-btn-set',
            'ui-btn',
        ],
        'component_tokens' => [
            'empty-state-actions',
            'recovery-actions',
            'zero-state-actions',
            'no-results-actions',
            'error-recovery-actions',
        ],
        'deprecated' => [
            'feature-local empty state button rows',
            'raw empty state action utility clusters',
            'destructive empty state actions',
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
            'icon',
            'spacing',
            'layout',
        ],
        'uses' => [
            'icons' => [
                'dynamic action icon prop',
            ],
            'components' => [
                'ui.button',
                'ui.button-set',
                'ui.icon',
            ],
            'patterns' => [
                'common-actions.action-set',
            ],
            'js_initializers' => [
                'empty-state recovery behavior if installed',
            ],
        ],
        'blocks' => [
            'empty-states',
            'zero-states',
            'no-results-states',
            'error-states',
            'permission-states',
            'offline-states',
            'data-table-empty-states',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'All empty-state action controls must be keyboard reachable unless disabled.',
            'Busy state should not unexpectedly remove focus.',
            'Do not require hover-only discovery for recovery actions.',
        ],
        'aria' => [
            'The composed Action Set owns action group labelling.',
            'The action group label should identify the empty-state action scope when multiple empty states exist on a page.',
            'Busy/loading state should be communicated by the relevant button or nearby status messaging.',
            'Do not rely on visual placement alone to explain the recovery path.',
        ],
        'focus' => [
            'Action controls must show visible focus.',
            'Retry or recovery failures should return focus to the error message or keep focus on the triggering action according to the surrounding pattern.',
            'Navigation actions should follow normal link/button focus behavior.',
        ],
        'screen_reader' => [
            'Action labels should clearly describe the next step.',
            'No-results actions should identify whether filters, search, or both will change.',
            'Error recovery actions should identify retry, refresh, or support outcomes clearly.',
            'Empty-state actions should be associated with nearby empty-state heading/copy through layout and accessible naming where needed.',
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
            'feature-local empty-state action classes',
            'raw empty-state action utility clusters',
        ],
        'components' => [
            'ad hoc empty-state action wrappers outside x-patterns.common-actions.empty-state-actions',
            'destructive action controls inside empty states',
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
            'resources/views/components/patterns/common-actions/empty-state-actions/index.blade.php',
        ],
        'css' => [
            'resources/css/components/button.css',
        ],
        'contract' => [
            'resources/views/components/patterns/common-actions/empty-state-actions/contract.php',
        ],
        'docs' => [],
    ],
]);

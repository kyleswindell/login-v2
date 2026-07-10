<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/common-actions/page-actions/contract.php
| Purpose: Page Actions Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Page Actions Pattern API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Page Actions is a Pattern API contract. It composes Action Set, Button Set,
| Button, Icon Button, and Overflow Menu components to define approved actions
| scoped to a page, page header, section header, or page-level toolbar.
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
        'slug' => 'common-actions-page-actions',
        'label' => 'Page Actions',
        'component' => 'x-patterns.common-actions.page-actions',
        'api_layer' => 'Pattern API',
        'summary' => 'Common Actions pattern for page-level and section-level actions with approved primary action visibility, overflow behavior, destructive action placement, toolbar placement, and page context labelling.',
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
        'usage_context' => 'Use x-patterns.common-actions.page-actions for actions scoped to the current page, page header, section header, or page toolbar. Use Form Actions for submit/cancel form workflows. Use Row Actions for actions scoped to a single repeated row.',

        'props' => [
            ['name' => 'actions', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Optional array-driven page actions. Items may be strings or arrays with label/text, role/action, ariaLabel, href/url, target, rel, type, kind, size, name, value, form, icon, class, disabled, loading, primary, danger, inline, overflow, visible, allowDuringBusy, and pageId/page_id.'],
            ['name' => 'label', 'type' => 'string', 'required' => false, 'default' => 'Page actions', 'values' => [], 'description' => 'Accessible label forwarded to the composed Action Set pattern. If pageTitle is supplied and label remains default, the label resolves to Actions for {pageTitle}.'],
            ['name' => 'labelledBy', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'ID of an external element that labels the action set.'],
            ['name' => 'pageId', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Stable page or section identifier emitted as page action metadata.'],
            ['name' => 'pageTitle', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Human-readable page or section title used to improve accessible labels.'],
            ['name' => 'placement', 'type' => 'string', 'required' => false, 'default' => 'header', 'values' => ['header', 'section-header', 'toolbar', 'sticky-header'], 'description' => 'Page action placement context.'],
            ['name' => 'alignment', 'type' => 'string', 'required' => false, 'default' => 'end', 'values' => ['start', 'end', 'between', 'stretch'], 'description' => 'Visual alignment treatment for the page action cluster.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'md', 'lg'], 'description' => 'Default size for array-driven inline buttons and overflow trigger.'],
            ['name' => 'density', 'type' => 'string', 'required' => false, 'default' => 'comfortable', 'values' => ['compact', 'comfortable'], 'description' => 'Spacing density for the page action cluster.'],
            ['name' => 'overflow', 'type' => 'string', 'required' => false, 'default' => 'auto', 'values' => ['auto', 'always', 'never'], 'description' => 'Overflow placement mode. auto partitions actions based on maxInlineActions, primary action visibility, and destructive-role defaults.'],
            ['name' => 'maxInlineActions', 'type' => 'int|string', 'required' => false, 'default' => 3, 'values' => [], 'description' => 'Maximum non-primary inline actions rendered before remaining actions move to overflow in auto mode. Clamped from 0 to 5.'],
            ['name' => 'overflowLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label for the overflow action menu. Defaults to More actions for {pageTitle} when pageTitle is present.'],
            ['name' => 'overflowPlacement', 'type' => 'string', 'required' => false, 'default' => 'bottom-end', 'values' => ['top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end'], 'description' => 'Placement forwarded to the composed overflow menu.'],
            ['name' => 'showLabels', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Renders inline actions with visible button labels. Non-primary icon-only actions may be rendered when false and an icon is supplied.'],
            ['name' => 'fluid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Enables fluid Button Set layout.'],
            ['name' => 'autoStack', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Enables Button Set auto-stack treatment when fluid is active.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables all array-driven page actions.'],
            ['name' => 'busy', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks page actions as busy and disables actions unless allowDuringBusy is true. Primary actions expose loading state while busy.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Manual page action controls. Slot mode is preferred when actions require exact framework bindings, route transitions, confirmation dialogs, custom events, or nonstandard markup.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-pattern', 'required' => true, 'value' => 'common-actions-page-actions', 'description' => 'Generated pattern identity marker.'],
            ['name' => 'data-ui-page-actions', 'required' => true, 'description' => 'Generated page actions marker.'],
            ['name' => 'data-ui-page-actions-page-id', 'required' => false, 'description' => 'Generated page ID marker.'],
            ['name' => 'data-ui-page-actions-page-title', 'required' => false, 'description' => 'Generated page title marker.'],
            ['name' => 'data-ui-page-actions-placement', 'required' => true, 'description' => 'Generated placement marker.'],
            ['name' => 'data-ui-page-actions-alignment', 'required' => true, 'description' => 'Generated alignment marker.'],
            ['name' => 'data-ui-page-actions-size', 'required' => true, 'description' => 'Generated size marker.'],
            ['name' => 'data-ui-page-actions-density', 'required' => true, 'description' => 'Generated density marker.'],
            ['name' => 'data-ui-page-actions-overflow', 'required' => true, 'description' => 'Generated overflow mode marker.'],
            ['name' => 'data-ui-page-actions-inline-count', 'required' => true, 'description' => 'Generated inline action count marker.'],
            ['name' => 'data-ui-page-actions-overflow-count', 'required' => true, 'description' => 'Generated overflow action count marker.'],
            ['name' => 'data-ui-page-actions-fluid', 'required' => true, 'description' => 'Generated fluid marker.'],
            ['name' => 'data-ui-page-actions-busy', 'required' => true, 'description' => 'Generated busy marker.'],
            ['name' => 'data-ui-page-actions-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-page-actions-button-set', 'required' => true, 'description' => 'Generated composed Button Set marker.'],
            ['name' => 'data-ui-page-action', 'required' => false, 'description' => 'Generated inline page action marker.'],
            ['name' => 'data-ui-page-action-role', 'required' => false, 'description' => 'Generated page action role marker.'],
            ['name' => 'data-ui-page-action-page-id', 'required' => false, 'description' => 'Generated action page ID marker.'],
            ['name' => 'data-ui-page-action-inline', 'required' => false, 'description' => 'Generated inline action marker.'],
            ['name' => 'data-ui-page-action-primary', 'required' => false, 'description' => 'Generated primary action marker.'],
            ['name' => 'data-ui-page-action-danger', 'required' => false, 'description' => 'Generated danger/destructive marker.'],
            ['name' => 'data-ui-page-actions-overflow-menu', 'required' => false, 'description' => 'Generated overflow menu marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-page-actions',
        'required' => [
            'ui-page-actions',
        ],
        'optional' => [
            'ui-page-actions--header',
            'ui-page-actions--section-header',
            'ui-page-actions--toolbar',
            'ui-page-actions--sticky-header',
            'ui-page-actions--align-start',
            'ui-page-actions--align-end',
            'ui-page-actions--align-between',
            'ui-page-actions--align-stretch',
            'ui-page-actions--compact',
            'ui-page-actions--comfortable',
            'ui-page-actions--with-overflow',
            'ui-page-actions--inline-only',
            'ui-page-actions--overflow-only',
            'ui-page-actions--fluid',
            'ui-page-actions--busy',
            'ui-page-actions--disabled',
            'ui-page-actions__action',
            'ui-page-actions__action--primary',
            'ui-page-actions__action--secondary',
            'ui-page-actions__action--create',
            'ui-page-actions__action--add',
            'ui-page-actions__action--new',
            'ui-page-actions__action--edit',
            'ui-page-actions__action--export',
            'ui-page-actions__action--import',
            'ui-page-actions__action--refresh',
            'ui-page-actions__action--print',
            'ui-page-actions__action--share',
            'ui-page-actions__action--delete',
            'ui-page-actions__action--danger',
            'ui-page-actions__action-icon',
            'ui-page-actions__overflow',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local page action clusters',
            'raw page header button wrappers outside x-patterns.common-actions.page-actions',
            'destructive page actions placed inline by default',
            'form submit/cancel controls implemented as Page Actions',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'header' => ['label' => 'Header', 'api' => ['placement' => 'header'], 'class' => 'ui-page-actions--header', 'description' => 'Actions placed in a page header.'],
        'section-header' => ['label' => 'Section header', 'api' => ['placement' => 'section-header'], 'class' => 'ui-page-actions--section-header', 'description' => 'Actions placed in a section header.'],
        'toolbar' => ['label' => 'Toolbar', 'api' => ['placement' => 'toolbar'], 'class' => 'ui-page-actions--toolbar', 'description' => 'Actions placed in a page-level toolbar.'],
        'sticky-header' => ['label' => 'Sticky header', 'api' => ['placement' => 'sticky-header'], 'class' => 'ui-page-actions--sticky-header', 'description' => 'Actions placed in a sticky page header.'],
        'inline-only' => ['label' => 'Inline only', 'api' => ['overflow' => 'never'], 'class' => 'ui-page-actions--inline-only', 'description' => 'All actions render inline.'],
        'overflow-only' => ['label' => 'Overflow only', 'api' => ['overflow' => 'always'], 'class' => 'ui-page-actions--overflow-only', 'description' => 'All actions render in overflow.'],
        'mixed' => ['label' => 'Mixed', 'api' => ['overflow' => 'auto', 'maxInlineActions' => 3], 'class' => 'ui-page-actions--with-overflow', 'description' => 'Primary and high-frequency actions render inline; remaining actions render in overflow.'],
        'compact' => ['label' => 'Compact', 'api' => ['density' => 'compact'], 'class' => 'ui-page-actions--compact', 'description' => 'Compact page action spacing.'],
        'comfortable' => ['label' => 'Comfortable', 'api' => ['density' => 'comfortable'], 'class' => 'ui-page-actions--comfortable', 'description' => 'Comfortable page action spacing.'],
        'fluid' => ['label' => 'Fluid', 'api' => ['fluid' => true], 'class' => 'ui-page-actions--fluid', 'description' => 'Fluid Button Set layout.'],
        'busy' => ['label' => 'Busy', 'api' => ['busy' => true], 'class' => 'ui-page-actions--busy', 'description' => 'Busy page action state.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-page-actions--disabled', 'description' => 'All array-driven page actions disabled.'],
        'destructive-overflow' => ['label' => 'Destructive overflow', 'api' => ['actions' => [['label' => 'Delete page', 'role' => 'delete']]], 'class' => 'ui-page-actions--with-overflow', 'description' => 'Destructive actions move to overflow by default in auto mode.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'description' => 'Small page actions.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'description' => 'Default medium page actions.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'description' => 'Large page actions for prominent headers.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default page header actions state.'],
        'primary-action' => ['label' => 'Primary action', 'required' => true, 'description' => 'Primary page action is present and visible when practical.'],
        'inline-actions' => ['label' => 'Inline actions', 'required' => false, 'description' => 'One or more actions render inline.'],
        'overflow-actions' => ['label' => 'Overflow actions', 'required' => false, 'description' => 'One or more actions render in overflow.'],
        'destructive-action' => ['label' => 'Destructive action', 'required' => false, 'description' => 'A danger/destructive action is present.'],
        'busy' => ['label' => 'Busy', 'required' => false, 'description' => 'Page action area is busy.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Page action area is disabled.'],
        'page-context-labelled' => ['label' => 'Page context labelled', 'required' => false, 'description' => 'pageTitle is used to improve accessible labels.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state belongs to composed action controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    'rules' => [
        'scope' => [
            'Page Actions apply to the current page, page header, section header, or page-level toolbar.',
            'Do not use Page Actions for form submit/cancel workflows.',
            'Do not use Page Actions for actions scoped to one repeated row.',
            'Each action must be understandable as applying to the page or section context.',
        ],
        'hierarchy' => [
            'Primary page action should remain visible when practical.',
            'Use one primary action per page action group.',
            'Secondary actions may render inline when they are high-frequency and safe.',
            'Lower-frequency actions should move to overflow.',
            'Do not give multiple unrelated actions equal primary weight.',
        ],
        'overflow' => [
            'Use overflow for lower-frequency page actions.',
            'Use overflow for destructive page actions by default.',
            'Do not hide a critical primary action in overflow unless there is no available space.',
            'Overflow menu labels should include page context when the page title is not otherwise clear.',
        ],
        'destructive' => [
            'Destructive page actions should require confirmation or undo support when data loss is possible.',
            'Destructive page actions should not be the default primary action unless the page workflow is explicitly destructive.',
            'Destructive labels must identify the destructive outcome clearly.',
        ],
        'placement' => [
            'Header actions should align with the page title area.',
            'Section-header actions should align with the section they affect.',
            'Toolbar actions should be visually associated with the content region they control.',
            'Sticky-header actions must preserve enough context so users understand what page or section they affect.',
        ],
        'composition' => [
            'Compose Action Set for semantic grouping.',
            'Compose Button Set for inline button layout.',
            'Compose Button for visible-label actions.',
            'Compose Icon Button only for secondary icon-only actions with clear accessible labels.',
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
            'ui-page-actions',
            'ui-btn-set',
            'ui-btn',
            'ui-menu',
        ],
        'component_tokens' => [
            'page-actions',
            'action-set',
            'button-set',
            'button',
            'icon-button',
            'overflow-menu',
            'page-scope',
        ],
        'deprecated' => [
            'feature-local page action classes',
            'raw page header action utility clusters',
            'duplicated page overflow action markup',
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
            'ui-shell-page-header',
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
                'overflow menu behavior if installed',
            ],
        ],
        'blocks' => [
            'page-headers',
            'section-headers',
            'toolbars',
            'dashboard-pages',
            'settings-pages',
            'detail-pages',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'All page action controls must be keyboard reachable unless disabled.',
            'Overflow menu keyboard behavior is owned by x-ui.overflow-menu and installed Menu JavaScript.',
            'Page actions must not require hover-only discovery for required workflows.',
        ],
        'aria' => [
            'The composed Action Set owns action group labelling.',
            'pageTitle should be used to improve icon-only and overflow action labels when page context is not otherwise announced.',
            'Overflow trigger must have an accessible label.',
            'Destructive actions must be clearly labelled.',
        ],
        'focus' => [
            'Inline actions and overflow trigger must show visible focus.',
            'Opening overflow should move focus according to installed Menu JavaScript behavior.',
            'Closing overflow should return focus to the overflow trigger when JavaScript supports it.',
        ],
        'screen_reader' => [
            'Action labels should identify the page action outcome clearly.',
            'When multiple page or section action groups exist, labels should identify the affected page or section.',
            'Do not rely on page position alone to describe action scope.',
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
            'feature-local page action classes',
            'raw page action utility clusters',
        ],
        'components' => [
            'ad hoc page action wrappers outside x-patterns.common-actions.page-actions',
            'form submit/cancel controls implemented as page actions',
            'row-scoped actions implemented as page actions',
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
            'resources/views/components/patterns/common-actions/page-actions/index.blade.php',
        ],
        'css' => [
            'resources/css/components/button.css',
            'resources/css/components/menu.css',
            'resources/css/components/ui-shell/index.css',
        ],
        'contract' => [
            'resources/views/components/patterns/common-actions/page-actions/contract.php',
        ],
        'docs' => [],
    ],
]);

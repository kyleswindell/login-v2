<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/common-actions/destructive-actions/contract.php
| Purpose: Destructive Actions Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Destructive Actions Pattern API that can be
| called from Blade, validated by tooling, and consumed by app layouts or
| Patterns.
|
| Destructive Actions is a Pattern API contract. It composes Action Set,
| Button Set, Button, and Icon components to define approved delete, remove,
| discard, reset, revoke, and irreversible action flows.
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
        'slug' => 'common-actions-destructive-actions',
        'label' => 'Destructive Actions',
        'component' => 'x-patterns.common-actions.destructive-actions',
        'api_layer' => 'Pattern API',
        'summary' => 'Common Actions pattern for destructive triggers and confirmation action sets with approved danger hierarchy, confirmation requirements, consequence messaging, typed-confirmation metadata, busy state, and safe cancellation behavior.',
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
        'usage_context' => 'Use x-patterns.common-actions.destructive-actions for delete, remove, discard, revoke, reset, deactivate, or otherwise destructive action flows. Use this pattern inside page, row, form, bulk, or modal contexts when the action can cause data loss, access loss, irreversible workflow changes, or user surprise.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Pattern root ID. A generated ID is used when omitted.'],
            ['name' => 'actions', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Optional array-driven destructive actions. Items may be strings or arrays with label/text, role/action, type, kind, size, href/url, target, rel, name, value, form, icon, class, visible, disabled, loading, danger, destructive, allowDuringBusy, and subjectId/subject_id.'],
            ['name' => 'label', 'type' => 'string', 'required' => false, 'default' => 'Destructive actions', 'values' => [], 'description' => 'Accessible label forwarded to the composed Action Set pattern. If subject is supplied and label remains default, the label resolves to Destructive actions for {subject}.'],
            ['name' => 'labelledBy', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'ID of an external element that labels the action set.'],
            ['name' => 'mode', 'type' => 'string', 'required' => false, 'default' => 'confirmation', 'values' => ['trigger', 'confirmation'], 'description' => 'Trigger mode renders one destructive trigger. Confirmation mode renders cancel and destructive confirmation actions by default.'],
            ['name' => 'scope', 'type' => 'string', 'required' => false, 'default' => 'local', 'values' => ['local', 'form', 'page', 'row', 'bulk', 'global'], 'description' => 'Context scope for the destructive action.'],
            ['name' => 'placement', 'type' => 'string', 'required' => false, 'default' => 'inline', 'values' => ['inline', 'footer', 'dialog-footer', 'overflow'], 'description' => 'Placement context for destructive actions.'],
            ['name' => 'severity', 'type' => 'string', 'required' => false, 'default' => 'danger', 'values' => ['danger', 'critical'], 'description' => 'Severity marker. Use critical for irreversible or high-impact destructive workflows.'],
            ['name' => 'alignment', 'type' => 'string', 'required' => false, 'default' => 'end', 'values' => ['start', 'end', 'between'], 'description' => 'Visual alignment treatment for the destructive action set.'],
            ['name' => 'orientation', 'type' => 'string', 'required' => false, 'default' => 'horizontal', 'values' => ['horizontal', 'vertical'], 'description' => 'Action orientation forwarded to Action Set and Button Set.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'md', 'lg'], 'description' => 'Default size for array-driven actions.'],
            ['name' => 'subject', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Human-readable subject affected by the destructive action. Used to improve accessible labels and messaging.'],
            ['name' => 'subjectId', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Stable subject identifier emitted as destructive action metadata.'],
            ['name' => 'actionRole', 'type' => 'string', 'required' => false, 'default' => 'delete', 'values' => [], 'description' => 'Default destructive role for generated actions. Common values include delete, remove, discard, revoke, archive, deactivate, reset, and destructive.'],
            ['name' => 'actionLabel', 'type' => 'string|HtmlString', 'required' => false, 'default' => 'Delete', 'values' => [], 'description' => 'Default destructive trigger label.'],
            ['name' => 'confirmLabel', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Destructive confirmation label. Defaults to actionLabel.'],
            ['name' => 'cancelLabel', 'type' => 'string|HtmlString', 'required' => false, 'default' => 'Cancel', 'values' => [], 'description' => 'Cancel action label for generated confirmation mode.'],
            ['name' => 'description', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional confirmation description rendered before actions.'],
            ['name' => 'consequence', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional consequence text rendered before actions. Use for data loss, access loss, or irreversible outcomes.'],
            ['name' => 'icon', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional x-ui.icon name for generated destructive action.'],
            ['name' => 'dangerKind', 'type' => 'string', 'required' => false, 'default' => 'danger', 'values' => ['danger', 'danger-ghost', 'danger-tertiary'], 'description' => 'Button kind for generated destructive actions.'],
            ['name' => 'cancelKind', 'type' => 'string', 'required' => false, 'default' => 'secondary', 'values' => ['secondary', 'ghost', 'tertiary'], 'description' => 'Button kind for generated cancel action.'],
            ['name' => 'requireConfirmation', 'type' => 'bool', 'required' => false, 'default' => true, 'values' => [true, false], 'description' => 'Marks the action as requiring confirmation. Behavior is owned by caller or installed JavaScript.'],
            ['name' => 'requireTypedConfirmation', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks the action as requiring typed confirmation. This pattern emits metadata and helper text but does not render the input.'],
            ['name' => 'typedConfirmationValue', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Expected typed confirmation value, emitted as metadata and message text when typed confirmation is required.'],
            ['name' => 'busy', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks destructive action area as busy and disables unsafe duplicate actions.'],
            ['name' => 'loading', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Alias-style busy state for destructive loading flows.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables all array-driven actions.'],
            ['name' => 'form', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional form attribute forwarded to array-driven actions for out-of-form controls.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Manual destructive action controls. Slot mode is preferred when confirmation behavior, route bindings, modal controls, or framework handlers must be exact.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-pattern', 'required' => true, 'value' => 'common-actions-destructive-actions', 'description' => 'Generated pattern identity marker.'],
            ['name' => 'data-ui-destructive-actions', 'required' => true, 'description' => 'Generated destructive actions root marker.'],
            ['name' => 'data-ui-destructive-actions-id', 'required' => true, 'description' => 'Generated resolved root ID marker.'],
            ['name' => 'data-ui-destructive-actions-mode', 'required' => true, 'description' => 'Generated mode marker.'],
            ['name' => 'data-ui-destructive-actions-scope', 'required' => true, 'description' => 'Generated scope marker.'],
            ['name' => 'data-ui-destructive-actions-placement', 'required' => true, 'description' => 'Generated placement marker.'],
            ['name' => 'data-ui-destructive-actions-severity', 'required' => true, 'description' => 'Generated severity marker.'],
            ['name' => 'data-ui-destructive-actions-alignment', 'required' => true, 'description' => 'Generated alignment marker.'],
            ['name' => 'data-ui-destructive-actions-orientation', 'required' => true, 'description' => 'Generated orientation marker.'],
            ['name' => 'data-ui-destructive-actions-subject', 'required' => false, 'description' => 'Generated subject marker.'],
            ['name' => 'data-ui-destructive-actions-subject-id', 'required' => false, 'description' => 'Generated subject ID marker.'],
            ['name' => 'data-ui-destructive-actions-requires-confirmation', 'required' => true, 'description' => 'Generated confirmation requirement marker.'],
            ['name' => 'data-ui-destructive-actions-requires-typed-confirmation', 'required' => true, 'description' => 'Generated typed confirmation requirement marker.'],
            ['name' => 'data-ui-destructive-actions-typed-confirmation-value', 'required' => false, 'description' => 'Generated typed confirmation value marker.'],
            ['name' => 'data-ui-destructive-actions-busy', 'required' => true, 'description' => 'Generated busy marker.'],
            ['name' => 'data-ui-destructive-actions-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-destructive-actions-message', 'required' => false, 'description' => 'Generated confirmation message marker.'],
            ['name' => 'data-ui-destructive-actions-set', 'required' => true, 'description' => 'Generated composed Action Set marker.'],
            ['name' => 'data-ui-destructive-actions-button-set', 'required' => true, 'description' => 'Generated composed Button Set marker.'],
            ['name' => 'data-ui-destructive-action', 'required' => false, 'description' => 'Generated action marker.'],
            ['name' => 'data-ui-destructive-action-role', 'required' => false, 'description' => 'Generated action role marker.'],
            ['name' => 'data-ui-destructive-action-kind', 'required' => false, 'description' => 'Generated button kind marker.'],
            ['name' => 'data-ui-destructive-action-type', 'required' => false, 'description' => 'Generated native type marker.'],
            ['name' => 'data-ui-destructive-action-index', 'required' => false, 'description' => 'Generated action index marker.'],
            ['name' => 'data-ui-destructive-action-subject-id', 'required' => false, 'description' => 'Generated action subject ID marker.'],
            ['name' => 'data-ui-destructive-action-destructive', 'required' => false, 'description' => 'Generated destructive action marker.'],
            ['name' => 'data-ui-destructive-action-disabled', 'required' => false, 'description' => 'Generated action disabled marker.'],
            ['name' => 'data-ui-destructive-action-loading', 'required' => false, 'description' => 'Generated action loading marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-destructive-actions',
        'required' => [
            'ui-destructive-actions',
        ],
        'optional' => [
            'ui-destructive-actions--trigger',
            'ui-destructive-actions--confirmation',
            'ui-destructive-actions--scope-local',
            'ui-destructive-actions--scope-form',
            'ui-destructive-actions--scope-page',
            'ui-destructive-actions--scope-row',
            'ui-destructive-actions--scope-bulk',
            'ui-destructive-actions--scope-global',
            'ui-destructive-actions--inline',
            'ui-destructive-actions--footer',
            'ui-destructive-actions--dialog-footer',
            'ui-destructive-actions--overflow',
            'ui-destructive-actions--danger',
            'ui-destructive-actions--critical',
            'ui-destructive-actions--horizontal',
            'ui-destructive-actions--vertical',
            'ui-destructive-actions--align-start',
            'ui-destructive-actions--align-end',
            'ui-destructive-actions--align-between',
            'ui-destructive-actions--requires-confirmation',
            'ui-destructive-actions--requires-typed-confirmation',
            'ui-destructive-actions--busy',
            'ui-destructive-actions--disabled',
            'ui-destructive-actions__message',
            'ui-destructive-actions__message--critical',
            'ui-destructive-actions__description',
            'ui-destructive-actions__consequence',
            'ui-destructive-actions__typed-confirmation',
            'ui-destructive-actions__set',
            'ui-destructive-actions__action',
            'ui-destructive-actions__action--delete',
            'ui-destructive-actions__action--remove',
            'ui-destructive-actions__action--discard',
            'ui-destructive-actions__action--revoke',
            'ui-destructive-actions__action--archive',
            'ui-destructive-actions__action--deactivate',
            'ui-destructive-actions__action--reset',
            'ui-destructive-actions__action--cancel',
            'ui-destructive-actions__action--destructive',
            'ui-destructive-actions__action-icon',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local destructive action wrappers',
            'raw danger button clusters outside x-patterns.common-actions.destructive-actions',
            'unconfirmed irreversible destructive actions',
            'destructive controls styled only by color without semantic labels',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'trigger' => ['label' => 'Trigger', 'api' => ['mode' => 'trigger'], 'class' => 'ui-destructive-actions--trigger', 'description' => 'Single destructive trigger.'],
        'confirmation' => ['label' => 'Confirmation', 'api' => ['mode' => 'confirmation'], 'class' => 'ui-destructive-actions--confirmation', 'description' => 'Cancel plus destructive confirmation actions.'],
        'danger' => ['label' => 'Danger', 'api' => ['severity' => 'danger'], 'class' => 'ui-destructive-actions--danger', 'description' => 'Standard destructive action severity.'],
        'critical' => ['label' => 'Critical', 'api' => ['severity' => 'critical'], 'class' => 'ui-destructive-actions--critical', 'description' => 'Critical destructive action severity for irreversible or high-impact outcomes.'],
        'typed-confirmation' => ['label' => 'Typed confirmation', 'api' => ['requireTypedConfirmation' => true, 'typedConfirmationValue' => 'DELETE'], 'class' => 'ui-destructive-actions--requires-typed-confirmation', 'description' => 'Typed confirmation metadata and helper text.'],
        'dialog-footer' => ['label' => 'Dialog footer', 'api' => ['placement' => 'dialog-footer'], 'class' => 'ui-destructive-actions--dialog-footer', 'description' => 'Destructive action set placed in a dialog footer.'],
        'busy' => ['label' => 'Busy', 'api' => ['busy' => true], 'class' => 'ui-destructive-actions--busy', 'description' => 'Busy destructive action state.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-destructive-actions--disabled', 'description' => 'Disabled destructive action set.'],
        'slot-mode' => ['label' => 'Slot mode', 'api' => ['slot' => 'default'], 'description' => 'Caller provides exact destructive action controls.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default confirmation mode destructive actions state.'],
        'trigger' => ['label' => 'Trigger', 'required' => false, 'description' => 'Single destructive trigger state.'],
        'confirmation' => ['label' => 'Confirmation', 'required' => true, 'description' => 'Cancel plus destructive confirmation state.'],
        'critical' => ['label' => 'Critical', 'required' => false, 'description' => 'Critical destructive severity state.'],
        'typed-confirmation' => ['label' => 'Typed confirmation', 'required' => false, 'description' => 'Typed confirmation required metadata state.'],
        'busy' => ['label' => 'Busy', 'required' => false, 'description' => 'Destructive action is loading or processing.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Destructive actions are disabled.'],
        'subject-labelled' => ['label' => 'Subject labelled', 'required' => false, 'description' => 'subject is used to improve accessible labels and copy.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state belongs to composed action controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    'rules' => [
        'scope' => [
            'Use Destructive Actions only for actions that delete, remove, discard, revoke, reset, deactivate, or otherwise cause potentially harmful change.',
            'Use the parent Page Actions, Row Actions, Form Actions, or Bulk Actions pattern to determine placement and scope.',
            'Do not use destructive styling for ordinary primary actions.',
        ],
        'confirmation' => [
            'Destructive actions that cause data loss, access loss, irreversible workflow changes, or user surprise should require confirmation.',
            'Critical destructive actions should include consequence text.',
            'Typed confirmation should be reserved for irreversible or high-impact destructive actions.',
            'This pattern emits typed-confirmation metadata but does not render the input control.',
        ],
        'hierarchy' => [
            'The destructive confirmation action should be visually distinct from cancel.',
            'Cancel should remain available during destructive confirmation whenever safe.',
            'Do not make destructive action the default primary page action unless the whole workflow is explicitly destructive.',
            'Do not rely on red color alone; labels must describe the destructive outcome.',
        ],
        'loading' => [
            'Busy destructive state should prevent duplicate destructive submissions.',
            'Busy state should not unexpectedly remove focus.',
            'Cancel may remain enabled during busy state only when it can safely abort or dismiss the flow.',
        ],
        'copy' => [
            'Use explicit action labels such as Delete project, Remove user, Revoke access, or Discard draft.',
            'Avoid vague labels such as Yes, OK, or Confirm for destructive buttons.',
            'Consequence text should explain what will be lost or changed.',
        ],
        'composition' => [
            'Compose Action Set for semantic grouping.',
            'Compose Button Set for button layout.',
            'Compose Button for cancel and destructive controls.',
            'Confirmation dialog, undo notification, and typed-confirmation input are owned by caller or surrounding patterns.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-destructive-actions',
            'ui-btn-set',
            'ui-btn',
        ],
        'component_tokens' => [
            'destructive-actions',
            'danger-action',
            'confirmation-actions',
            'delete-action',
            'remove-action',
            'discard-action',
            'revoke-action',
        ],
        'deprecated' => [
            'feature-local destructive action classes',
            'raw danger button groups',
            'unlabelled destructive icon buttons',
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
                'dynamic destructive action icon prop',
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
                'destructive confirmation behavior if installed',
                'typed confirmation validation if installed',
            ],
        ],
        'blocks' => [
            'modal-footers',
            'form-footers',
            'page-actions',
            'row-actions',
            'bulk-actions',
            'danger-zones',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'All destructive action controls must be keyboard reachable unless disabled.',
            'Cancel must be keyboard reachable when confirmation mode is used.',
            'Typed confirmation input behavior is owned by the caller when required.',
        ],
        'aria' => [
            'The composed Action Set owns action group labelling.',
            'Destructive action buttons should be associated with consequence text when rendered.',
            'Busy/loading state should be communicated by the destructive button or nearby status messaging.',
            'Do not rely on danger color alone to communicate destructive behavior.',
        ],
        'focus' => [
            'Destructive and cancel buttons must show visible focus.',
            'Confirmation flows should move focus to the confirmation heading, first meaningful field, or safest action depending on the surrounding dialog pattern.',
            'Busy state should not unexpectedly remove focus.',
        ],
        'screen_reader' => [
            'Button labels should describe the destructive outcome clearly.',
            'Consequence text should explain what will be lost, changed, revoked, or reset.',
            'Subject text should identify the item affected by the destructive action.',
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
            'feature-local destructive action classes',
            'raw danger button utility clusters',
        ],
        'components' => [
            'ad hoc destructive action wrappers outside x-patterns.common-actions.destructive-actions',
            'unconfirmed irreversible destructive controls',
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
            'resources/views/components/patterns/common-actions/destructive-actions/index.blade.php',
        ],
        'css' => [
            'resources/css/components/button.css',
        ],
        'contract' => [
            'resources/views/components/patterns/common-actions/destructive-actions/contract.php',
        ],
        'docs' => [],
    ],
]);

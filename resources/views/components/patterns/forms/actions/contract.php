<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/forms/actions/contract.php
| Purpose: Form Actions Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Form Actions Pattern API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Form Actions is a Pattern API contract. It composes Action Set, Button Set,
| Button, Icon, and Inline Loading components to define approved submit, cancel,
| reset, form-flow, local loading, local success, and local error action
| behavior.
|
| Detailed form-level success, warning, or error messaging belongs to the
| Notification component or a consuming Pattern, not to this local action group.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::pattern([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    "identity" => [
        "slug" => "forms-actions",
        "label" => "Form Actions",
        "component" => "x-patterns.forms.actions",
        "api_layer" => "Pattern API",
        "summary" =>
            "Common Actions pattern for form submit, cancel, reset, form-flow controls, local loading status, success handoff, error handoff, ordering, hierarchy, placement, and duplicate-submission behavior.",
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    "lifecycle" => [
        "status" => "provisional",
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Blade API
    |--------------------------------------------------------------------------
    */

    "api" => [
        "usage_context" =>
            "Use x-patterns.forms.actions for action controls that submit, cancel, reset, save, continue, send, or move through a form workflow. Use x-patterns.common-actions.action-set for generic related actions outside form workflows.",

        "props" => [
            [
                "name" => "actions",
                "type" => "array",
                "required" => false,
                "default" => [],
                "values" => [],
                "description" =>
                    "Optional array-driven form actions. Items may be strings or arrays with label/text, role/action, type, kind, size, href, target, rel, name, value, form, icon, disabled, loading, allowDuringBusy, and class.",
            ],
            [
                "name" => "label",
                "type" => "string",
                "required" => false,
                "default" => "Form actions",
                "values" => [],
                "description" =>
                    "Accessible label forwarded to the composed Action Set pattern.",
            ],
            [
                "name" => "labelledBy",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "ID of an external element that labels the action set. In Blade, pass as labelled-by.",
            ],
            [
                "name" => "alignment",
                "type" => "string",
                "required" => false,
                "default" => "start",
                "values" => ["start", "end", "between", "stretch"],
                "description" =>
                    "Visual alignment treatment for the form action group.",
            ],
            [
                "name" => "placement",
                "type" => "string",
                "required" => false,
                "default" => "inline",
                "values" => ["inline", "footer", "sticky-footer"],
                "description" => "Form action placement context.",
            ],
            [
                "name" => "orientation",
                "type" => "string",
                "required" => false,
                "default" => "horizontal",
                "values" => ["horizontal", "vertical"],
                "description" =>
                    "Action orientation forwarded to the composed Button Set.",
            ],
            [
                "name" => "size",
                "type" => "string",
                "required" => false,
                "default" => "md",
                "values" => ["sm", "md", "lg"],
                "description" =>
                    "Default button size for array-driven actions.",
            ],
            [
                "name" => "fluid",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" => "Enables fluid Button Set layout.",
            ],
            [
                "name" => "autoStack",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "values" => [true, false],
                "description" =>
                    "Enables Button Set auto-stack treatment when fluid is active. In Blade, pass as auto-stack.",
            ],
            [
                "name" => "width",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => ["half", "full"],
                "description" =>
                    "Optional fluid Button Set width treatment forwarded to x-ui.button-set.",
            ],
            [
                "name" => "state",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "idle",
                    "loading",
                    "success",
                    "error",
                    "active",
                    "busy",
                    "finished",
                    "complete",
                    "completed",
                    "failed",
                    "failure",
                ],
                "description" =>
                    "Local action state. Canonical values are idle, loading, success, and error. Other values are compatibility aliases.",
            ],
            [
                "name" => "busy",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Compatibility busy flag. When true and state is not supplied, resolves the pattern state to loading.",
            ],
            [
                "name" => "loading",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Compatibility loading flag. When true and state is not supplied, resolves the pattern state to loading.",
            ],
            [
                "name" => "disabled",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Disables all array-driven actions unless caller supplies custom slotted controls.",
            ],
            [
                "name" => "form",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional native form attribute forwarded to array-driven actions for out-of-form submit controls.",
            ],
            [
                "name" => "loadingText",
                "type" => "string|HtmlString|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Inline Loading text rendered for the loading state. Defaults to Processing.... In Blade, pass as loading-text.",
            ],
            [
                "name" => "successText",
                "type" => "string|HtmlString|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Inline Loading text rendered for the success state. Defaults to Success!. In Blade, pass as success-text.",
            ],
            [
                "name" => "errorText",
                "type" => "string|HtmlString|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Inline Loading text rendered for the error state. Defaults to Action failed. In Blade, pass as error-text.",
            ],
            [
                "name" => "statusAriaLive",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => ["off", "polite", "assertive"],
                "description" =>
                    "aria-live value forwarded to x-ui.inline-loading. In Blade, pass as status-aria-live.",
            ],
            [
                "name" => "disableDuringBusy",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "values" => [true, false],
                "description" =>
                    "When true, loading state disables related array-driven actions unless an action opts into allowDuringBusy. In Blade, pass as disable-during-busy.",
            ],
            [
                "name" => "replaceSlotWithStatus",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "values" => [true, false],
                "description" =>
                    "When true and slot mode is used without array actions, loading/success/error replaces the whole slotted action area with Inline Loading. In Blade, pass as replace-slot-with-status.",
            ],
        ],

        "slots" => [
            [
                "name" => "default",
                "required" => false,
                "description" =>
                    "Manual action controls, typically x-ui.button children. Slot mode is preferred when actions require framework handlers, confirmation flows, or custom attributes.",
            ],
        ],

        "events" => [],

        "data_attributes" => [
            [
                "name" => "data-ui-pattern",
                "required" => true,
                "value" => "common-actions-form-actions",
                "description" => "Generated pattern identity marker.",
            ],
            [
                "name" => "data-ui-form-actions",
                "required" => true,
                "description" => "Generated form actions marker.",
            ],
            [
                "name" => "data-ui-form-actions-placement",
                "required" => true,
                "description" => "Generated placement marker.",
            ],
            [
                "name" => "data-ui-form-actions-orientation",
                "required" => true,
                "description" => "Generated orientation marker.",
            ],
            [
                "name" => "data-ui-form-actions-alignment",
                "required" => true,
                "description" => "Generated alignment marker.",
            ],
            [
                "name" => "data-ui-form-actions-size",
                "required" => true,
                "description" => "Generated size marker.",
            ],
            [
                "name" => "data-ui-form-actions-fluid",
                "required" => true,
                "description" => "Generated fluid marker.",
            ],
            [
                "name" => "data-ui-form-actions-width",
                "required" => true,
                "description" =>
                    "Generated width marker. Emits half, full, or auto.",
            ],
            [
                "name" => "data-ui-form-actions-state",
                "required" => true,
                "description" =>
                    "Generated canonical state marker: idle, loading, success, or error.",
            ],
            [
                "name" => "data-ui-form-actions-busy",
                "required" => true,
                "description" =>
                    "Generated busy marker. True only for loading state.",
            ],
            [
                "name" => "data-ui-form-actions-disabled",
                "required" => true,
                "description" => "Generated disabled marker.",
            ],
            [
                "name" => "data-ui-form-actions-has-status",
                "required" => true,
                "description" =>
                    "Generated marker showing whether Inline Loading status is rendered or available for the current state.",
            ],
            [
                "name" => "data-ui-form-actions-loading-text",
                "required" => false,
                "description" =>
                    "Generated loading status text marker for JavaScript initializers or UI proof.",
            ],
            [
                "name" => "data-ui-form-actions-success-text",
                "required" => false,
                "description" =>
                    "Generated success status text marker for JavaScript initializers or UI proof.",
            ],
            [
                "name" => "data-ui-form-actions-error-text",
                "required" => false,
                "description" =>
                    "Generated error status text marker for JavaScript initializers or UI proof.",
            ],
            [
                "name" => "data-ui-form-actions-disable-during-busy",
                "required" => true,
                "description" =>
                    "Generated disable-during-busy behavior marker.",
            ],
            [
                "name" => "data-ui-form-actions-button-set",
                "required" => true,
                "description" => "Generated composed Button Set marker.",
            ],
            [
                "name" => "data-ui-form-actions-status",
                "required" => false,
                "description" =>
                    "Generated Inline Loading status wrapper marker.",
            ],
            [
                "name" => "data-ui-form-actions-status-role",
                "required" => false,
                "description" =>
                    "Generated replaced action role marker when a submit-like action is replaced by Inline Loading.",
            ],
            [
                "name" => "data-ui-form-actions-status-state",
                "required" => false,
                "description" => "Generated Inline Loading state marker.",
            ],
            [
                "name" => "data-ui-form-actions-status-text",
                "required" => false,
                "description" =>
                    "Generated visible Inline Loading text marker.",
            ],
            [
                "name" => "data-ui-form-action",
                "required" => false,
                "description" => "Generated array-driven action marker.",
            ],
            [
                "name" => "data-ui-form-action-role",
                "required" => false,
                "description" => "Generated semantic action role marker.",
            ],
            [
                "name" => "data-ui-form-action-kind",
                "required" => false,
                "description" => "Generated button kind marker.",
            ],
            [
                "name" => "data-ui-form-action-type",
                "required" => false,
                "description" => "Generated native button type marker.",
            ],
            [
                "name" => "data-ui-form-action-index",
                "required" => false,
                "description" => "Generated array action index marker.",
            ],
            [
                "name" => "data-ui-form-action-disabled",
                "required" => false,
                "description" => "Generated per-action disabled marker.",
            ],
            [
                "name" => "data-ui-form-action-loading",
                "required" => false,
                "description" => "Generated per-action loading marker.",
            ],
            [
                "name" => "data-ui-form-action-allow-during-busy",
                "required" => false,
                "description" =>
                    "Generated per-action allow-during-busy marker.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "root" => "ui-form-actions",
        "required" => ["ui-form-actions"],
        "optional" => [
            "ui-form-actions--inline",
            "ui-form-actions--footer",
            "ui-form-actions--sticky-footer",
            "ui-form-actions--horizontal",
            "ui-form-actions--vertical",
            "ui-form-actions--align-start",
            "ui-form-actions--align-end",
            "ui-form-actions--align-between",
            "ui-form-actions--align-stretch",
            "ui-form-actions--fluid",
            "ui-form-actions--busy",
            "ui-form-actions--disabled",
            "ui-form-actions--has-status",
            "ui-form-actions--state-idle",
            "ui-form-actions--state-loading",
            "ui-form-actions--state-success",
            "ui-form-actions--state-error",
            "ui-form-actions__status",
            "ui-form-actions__status--loading",
            "ui-form-actions__status--success",
            "ui-form-actions__status--error",
            "ui-form-actions__action",
            "ui-form-actions__action--submit",
            "ui-form-actions__action--save",
            "ui-form-actions__action--create",
            "ui-form-actions__action--update",
            "ui-form-actions__action--continue",
            "ui-form-actions__action--send",
            "ui-form-actions__action--cancel",
            "ui-form-actions__action--back",
            "ui-form-actions__action--reset",
            "ui-form-actions__action--draft",
            "ui-form-actions__action--destructive",
            "ui-form-actions__action--delete",
            "ui-form-actions__action--remove",
            "ui-form-actions__action--secondary",
            "ui-form-actions__action--tertiary",
            "ui-form-actions__action-icon",
        ],
        "internal" => [],
        "deprecated" => [
            "feature-local form button rows",
            "raw submit/cancel flex wrappers outside x-patterns.forms.actions",
            "duplicated form footer action markup",
            "ad hoc inline loading markup in form action areas",
            "notification markup used as a replacement for local Inline Loading status",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Variants
    |--------------------------------------------------------------------------
    */

    "variants" => [
        "inline" => [
            "label" => "Inline",
            "api" => [
                "placement" => "inline",
            ],
            "class" => "ui-form-actions--inline",
            "description" => "Actions placed directly after a form section.",
        ],
        "footer" => [
            "label" => "Footer",
            "api" => [
                "placement" => "footer",
            ],
            "class" => "ui-form-actions--footer",
            "description" => "Actions placed in a form footer region.",
        ],
        "sticky-footer" => [
            "label" => "Sticky footer",
            "api" => [
                "placement" => "sticky-footer",
            ],
            "class" => "ui-form-actions--sticky-footer",
            "description" => "Actions placed in a sticky form footer region.",
        ],
        "horizontal" => [
            "label" => "Horizontal",
            "api" => [
                "orientation" => "horizontal",
            ],
            "class" => "ui-form-actions--horizontal",
            "description" => "Horizontal form action layout.",
        ],
        "vertical" => [
            "label" => "Vertical",
            "api" => [
                "orientation" => "vertical",
            ],
            "class" => "ui-form-actions--vertical",
            "description" => "Vertical form action layout.",
        ],
        "align-start" => [
            "label" => "Align start",
            "api" => [
                "alignment" => "start",
            ],
            "class" => "ui-form-actions--align-start",
            "description" => "Actions align to the start edge.",
        ],
        "align-end" => [
            "label" => "Align end",
            "api" => [
                "alignment" => "end",
            ],
            "class" => "ui-form-actions--align-end",
            "description" => "Actions align to the end edge.",
        ],
        "align-between" => [
            "label" => "Align between",
            "api" => [
                "alignment" => "between",
            ],
            "class" => "ui-form-actions--align-between",
            "description" => "Actions distribute space between controls.",
        ],
        "align-stretch" => [
            "label" => "Align stretch",
            "api" => [
                "alignment" => "stretch",
            ],
            "class" => "ui-form-actions--align-stretch",
            "description" =>
                "Actions stretch across the available action region.",
        ],
        "fluid" => [
            "label" => "Fluid",
            "api" => [
                "fluid" => true,
            ],
            "class" => "ui-form-actions--fluid",
            "description" => "Fluid Button Set treatment.",
        ],
        "fluid-half" => [
            "label" => "Fluid half width",
            "api" => [
                "fluid" => true,
                "width" => "half",
                "alignment" => "end",
            ],
            "class" => "ui-form-actions--fluid",
            "description" =>
                "Fluid half-width Button Set action area, commonly used for Carbon-style page form primary actions.",
        ],
        "fluid-full" => [
            "label" => "Fluid full width",
            "api" => [
                "fluid" => true,
                "width" => "full",
            ],
            "class" => "ui-form-actions--fluid",
            "description" => "Fluid full-width Button Set action area.",
        ],
        "array-driven" => [
            "label" => "Array-driven",
            "api" => [
                "actions" => [
                    ["label" => "Save", "role" => "submit"],
                    ["label" => "Cancel", "role" => "cancel"],
                ],
            ],
            "description" => "Pattern renders form actions from an array.",
        ],
        "slot-mode" => [
            "label" => "Slot mode",
            "api" => [
                "slot" => "default",
            ],
            "description" => "Caller provides explicit action controls.",
        ],
        "loading" => [
            "label" => "Loading",
            "api" => [
                "state" => "loading",
                "loadingText" => "Saving changes...",
            ],
            "class" => "ui-form-actions--state-loading",
            "description" =>
                "Local loading state that replaces the primary submit-like action with x-ui.inline-loading.",
        ],
        "success" => [
            "label" => "Success",
            "api" => [
                "state" => "success",
                "successText" => "Success!",
            ],
            "class" => "ui-form-actions--state-success",
            "description" =>
                "Local success handoff state rendered with x-ui.inline-loading finished status.",
        ],
        "error" => [
            "label" => "Error",
            "api" => [
                "state" => "error",
                "errorText" => "Action failed.",
            ],
            "class" => "ui-form-actions--state-error",
            "description" =>
                "Local error handoff state rendered with x-ui.inline-loading error status.",
        ],
        "slot-status-replacement" => [
            "label" => "Slot status replacement",
            "api" => [
                "state" => "loading",
                "replaceSlotWithStatus" => true,
            ],
            "description" =>
                "Slot action area is replaced by Inline Loading during loading, success, or error state.",
        ],
        "slot-status-preserved" => [
            "label" => "Slot status preserved",
            "api" => [
                "state" => "loading",
                "replaceSlotWithStatus" => false,
            ],
            "description" =>
                "Slotted controls remain visible while caller owns disabled state and local status behavior.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    "sizes" => [],

    /*
    |--------------------------------------------------------------------------
    | Pattern States
    |--------------------------------------------------------------------------
    */

    "states" => [
        "idle" => [
            "label" => "Idle",
            "required" => true,
            "description" =>
                "Default state where actions are available according to their own disabled configuration.",
        ],
        "loading" => [
            "label" => "Loading",
            "required" => false,
            "description" =>
                "Local loading state. A submit-like action is replaced by Inline Loading and related actions are disabled by default.",
        ],
        "success" => [
            "label" => "Success",
            "required" => false,
            "description" =>
                "Local success handoff state. A submit-like action is replaced by Inline Loading finished status.",
        ],
        "error" => [
            "label" => "Error",
            "required" => false,
            "description" =>
                "Local error handoff state. A submit-like action is replaced by Inline Loading error status.",
        ],
        "busy" => [
            "label" => "Busy compatibility",
            "required" => false,
            "description" =>
                "Compatibility state produced by busy or loading props when state is not supplied.",
        ],
        "disabled" => [
            "label" => "Disabled",
            "required" => false,
            "description" => "Array-driven actions are disabled.",
        ],
        "with-status" => [
            "label" => "With status",
            "required" => false,
            "description" =>
                "Inline Loading status is rendered or available for the current local action state.",
        ],
        "submit-replaced" => [
            "label" => "Submit replaced",
            "required" => false,
            "description" =>
                "A submit-like array action is replaced by the Inline Loading status region.",
        ],
        "slot-replaced" => [
            "label" => "Slot replaced",
            "required" => false,
            "description" =>
                "The slotted action area is replaced by the Inline Loading status region.",
        ],
        "cancel-available" => [
            "label" => "Cancel available",
            "required" => false,
            "description" =>
                "Cancel/back actions may remain enabled during loading state only when explicitly allowed.",
        ],
        "footer-placement" => [
            "label" => "Footer placement",
            "required" => false,
            "description" => "Actions are placed in a footer region.",
        ],
        "sticky-footer-placement" => [
            "label" => "Sticky footer placement",
            "required" => false,
            "description" => "Actions are placed in a sticky footer region.",
        ],
        "focus-visible" => [
            "label" => "Focus-visible",
            "required" => true,
            "description" =>
                "Visible focus state belongs to the composed button controls.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    "rules" => [
        "ordering" => [
            "Primary submit-like action should be visually strongest in idle state.",
            "Cancel or back action should remain visually secondary to the submit action.",
            "Reset should not be placed where users expect cancel unless the reset behavior is clearly labelled.",
            "Destructive form actions should not be the default primary submit action unless the entire workflow is explicitly destructive and confirmed.",
            "Do not reorder slotted controls. Caller owns slot ordering.",
            "State changes must not create a different action order that changes the meaning of the controls.",
        ],
        "hierarchy" => [
            "Use primary button treatment for the main submit-like action in idle state.",
            "Use secondary or ghost treatment for cancel/back depending on context.",
            "Use danger treatment only for destructive actions.",
            "Avoid multiple primary actions in the same form action group.",
            "Do not mutate a primary submit button into a ghost button for loading; replace the submit action region with Inline Loading instead.",
        ],
        "placement" => [
            "Inline actions should align with the form content column.",
            "Footer actions should align with the form footer region, not arbitrary viewport edges.",
            "Sticky footer actions should preserve enough context so users know what will be submitted.",
            "Do not separate submit and cancel controls into unrelated layout regions.",
            "Inline Loading status should occupy the local action position it is replacing.",
        ],
        "loading" => [
            "Loading state should use x-ui.inline-loading for short local action processing.",
            "Loading state should replace the first submit-like array action with Inline Loading.",
            "Slot mode may replace the whole slotted action area with Inline Loading when replaceSlotWithStatus is true.",
            "Loading state should disable duplicate submit-like actions.",
            "Related actions should be disabled during loading by default unless allowDuringBusy is explicitly true.",
            "Cancel/back may remain enabled during loading only when safe and explicitly allowed.",
            "Loading state should not move the action area or change the action order.",
            "Native form submits usually show loading until browser navigation or page replacement occurs.",
        ],
        "success_and_error" => [
            "Success state should use x-ui.inline-loading with finished status for short local handoff.",
            "Error state should use x-ui.inline-loading with error status only for short local handoff.",
            "Detailed success, warning, or error messaging should use Notification outside the local action group.",
            "Do not use Form Actions as a replacement for validation summaries, inline notifications, toast notifications, or modal notifications.",
        ],
        "validation" => [
            "Validation errors should keep action placement stable.",
            "Validation summaries, field errors, and error focus recovery belong to the consuming form Pattern or controller flow.",
            "A failed validation response should not be represented only by a local Inline Loading error state when field-level recovery is needed.",
        ],
        "composition" => [
            "Compose Action Set for semantic grouping.",
            "Compose Button Set for button layout.",
            "Compose x-ui.button for idle action controls.",
            "Compose x-ui.icon for optional action icons.",
            "Compose x-ui.inline-loading for loading, success, and error local action states.",
            "Use Notification components or Patterns for detailed result messaging outside the action area.",
        ],
        "slot_mode" => [
            "Slot mode is preferred when caller needs exact button markup, submit handlers, framework attributes, or custom action ordering.",
            "Slot mode cannot safely inspect and replace one specific submit button.",
            "When replaceSlotWithStatus is true and no array actions are supplied, loading/success/error replaces the whole slot action area.",
            "When replaceSlotWithStatus is false, caller owns disabled state and status rendering for slotted controls.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => [
            "ui-form-actions",
            "ui-btn-set",
            "ui-btn",
            "ui-inline-loading",
        ],
        "component_tokens" => [
            "form-actions",
            "action-set",
            "button-set",
            "submit-action",
            "cancel-action",
            "reset-action",
            "loading-action",
            "success-action",
            "error-action",
            "inline-loading",
        ],
        "deprecated" => [
            "feature-local form action rows",
            "raw submit/cancel utility clusters",
            "duplicated form footer button markup",
            "ad hoc inline loading markup in form actions",
            "notification-only local action loading states",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "depends_on" => [
            "button",
            "button-set",
            "inline-loading",
            "form",
            "spacing",
            "layout",
            "motion",
        ],
        "uses" => [
            "icons" => ["dynamic action icon prop"],
            "components" => [
                "x-ui.button",
                "x-ui.button-set",
                "x-ui.icon",
                "x-ui.inline-loading",
            ],
            "patterns" => ["x-patterns.common-actions.action-set"],
            "js_initializers" => [
                "form submit protection if installed",
                "form submit state if installed",
            ],
        ],
        "blocks" => [
            "forms",
            "form-footers",
            "wizard-flows",
            "create-edit-flows",
            "settings-forms",
            "auth-forms",
            "async-action-flows",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "All action controls must remain keyboard reachable unless disabled.",
            "Submit-like actions must use native submit behavior when they submit a form.",
            "Cancel/back actions should be reachable without requiring pointer input when available.",
            "Loading state must not trap focus.",
            "Disabled controls during loading must not create an unreachable required action.",
        ],
        "aria" => [
            "The composed Action Set owns action group labelling.",
            "Inline Loading owns its aria-live behavior for local loading, success, and error state text.",
            "Loading or busy state should be communicated by Inline Loading, the relevant button, or nearby status messaging.",
            "Detailed result messages should use Notification semantics outside this local action group.",
            "Do not rely on visual position alone to explain destructive action behavior.",
        ],
        "focus" => [
            "Action controls must show visible focus.",
            "Validation errors should move focus to the invalid field or error summary, not to the action group unless the action itself failed.",
            "Loading state should not remove focus unexpectedly.",
            "Replacing a focused submit action with Inline Loading must be limited to submit/navigation states where the next page, async completion, or focus recovery is managed by the consuming flow.",
            "After async error, focus recovery belongs to the consuming flow.",
        ],
        "screen_reader" => [
            "Action labels must describe the action outcome clearly.",
            "Cancel, reset, and destructive actions must be labelled distinctly.",
            "Inline Loading text should identify the in-progress, successful, or failed action.",
            "Status color and icon must not be the only cue.",
            "Use Notification for detailed result copy that needs to remain available after the local action state changes.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    "deprecations" => [
        "props" => [
            [
                "name" => "busy",
                "replacement" => 'state="loading"',
                "description" =>
                    "busy remains accepted as a compatibility input when state is not supplied.",
            ],
            [
                "name" => "loading",
                "replacement" => 'state="loading"',
                "description" =>
                    "loading remains accepted as a compatibility input when state is not supplied.",
            ],
        ],
        "classes" => [
            "feature-local form action classes",
            "raw form action utility clusters",
            "feature-local inline loading wrappers inside form actions",
        ],
        "components" => [
            "ad hoc submit/cancel wrappers outside x-patterns.forms.actions",
            "ad hoc inline loading markup outside x-ui.inline-loading",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    "enforcement" => [
        "mode" => "pattern-guidance",
        "invalid_usage" => "warn",
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    "source" => [
        "blade" => [
            "resources/views/components/patterns/forms/actions/index.blade.php",
        ],
        "css" => [
            "resources/css/components/button.css",
            "resources/css/components/button-group.css",
            "resources/css/components/form.css",
            "resources/css/components/loading.css",
        ],
        "contract" => [
            "resources/views/components/patterns/forms/actions/contract.php",
        ],
        "docs" => [],
    ],
]);

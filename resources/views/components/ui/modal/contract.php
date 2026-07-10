<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/modal/contract.php
| Purpose: Modal Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Modal API that can be called from Blade,
| validated by tooling, and consumed by app layouts or Patterns.
|
| Modal is a higher-level component API composed from the native
| x-ui.dialog.* primitive family. Dialog JavaScript owns runtime behavior.
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

    "identity" => [
        "slug" => "modal",
        "label" => "Modal",
        "component" => "x-ui.modal",
        "summary" =>
            "Higher-level native dialog modal API for passive and transactional workflows, composed from x-ui.dialog.* primitives with modal sizing, header, body, footer, generated actions, danger/alert treatment, and dialog-owned JavaScript behavior.",
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
            'Use x-ui.modal for blocking modal dialog surfaces. Use external triggers with data-ui-dialog-trigger, data-ui-dialog-open-trigger, aria-controls, or href="#id". Use x-ui.dialog.* directly only when a lower-level native dialog composition is required.',

        "props" => [
            [
                "name" => "id",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Modal dialog ID. A generated modal-* UUID ID is used when omitted.",
            ],
            [
                "name" => "titleId",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" => "Optional ID for the rendered modal heading.",
            ],
            [
                "name" => "title",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" => "Modal heading text.",
            ],
            [
                "name" => "modalHeading",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Carbon compatibility heading alias. Takes precedence over title.",
                "compatibility" => true,
            ],
            [
                "name" => "label",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Modal label/kicker text rendered above the heading.",
            ],
            [
                "name" => "modalLabel",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Carbon compatibility label alias. Takes precedence over label and kicker.",
                "compatibility" => true,
            ],
            [
                "name" => "kicker",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" => "App compatibility label/kicker alias.",
                "compatibility" => true,
            ],
            [
                "name" => "description",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional description rendered before body content and referenced by aria-describedby.",
            ],
            [
                "name" => "modalAriaLabel",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Explicit aria-label fallback when no heading or label is available.",
            ],
            [
                "name" => "closeButtonLabel",
                "type" => "string",
                "required" => false,
                "default" => "Close",
                "values" => [],
                "description" =>
                    "Accessible label and title for the close button.",
            ],
            [
                "name" => "open",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Initial rendered open state. Dynamic behavior is owned by dialog JavaScript.",
            ],
            [
                "name" => "variant",
                "type" => "string",
                "required" => false,
                "default" => "transactional",
                "values" => ["passive", "transactional"],
                "description" =>
                    "Modal behavior variant. Passive modals omit footer actions and default to backdrop dismissal.",
            ],
            [
                "name" => "passiveModal",
                "type" => "bool|null",
                "required" => false,
                "default" => null,
                "values" => [true, false],
                "description" =>
                    "Carbon compatibility passive modal override. Takes precedence over variant when provided.",
                "compatibility" => true,
            ],
            [
                "name" => "closeOnBackdrop",
                "type" => "bool|null",
                "required" => false,
                "default" => null,
                "values" => [true, false],
                "description" =>
                    "Controls whether clicking the backdrop closes the modal.",
            ],
            [
                "name" => "preventCloseOnClickOutside",
                "type" => "bool|null",
                "required" => false,
                "default" => null,
                "values" => [true, false],
                "description" =>
                    "Carbon compatibility inverse of closeOnBackdrop. Takes precedence when provided.",
                "compatibility" => true,
            ],
            [
                "name" => "shouldSubmitOnEnter",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Enables dialog JavaScript submit-on-enter behavior for eligible focus targets.",
            ],
            [
                "name" => "selectorPrimaryFocus",
                "type" => "string",
                "required" => false,
                "default" => "[data-ui-dialog-primary-focus]",
                "values" => [],
                "description" =>
                    "Selector used by dialog JavaScript to find the preferred initial focus target.",
            ],
            [
                "name" => "size",
                "type" => "string",
                "required" => false,
                "default" => "md",
                "values" => ["xs", "sm", "md", "lg"],
                "description" => "Modal container size.",
            ],
            [
                "name" => "danger",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Applies danger modal and danger primary action treatment.",
            ],
            [
                "name" => "alert",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" => "Uses alertdialog role.",
            ],
            [
                "name" => "hasScrollingContent",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Applies scrolling content treatment and region semantics to modal body.",
            ],
            [
                "name" => "isFullWidth",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Applies full-width modal container treatment.",
            ],
            [
                "name" => "primaryButtonText",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Built-in primary footer action label for transactional modals.",
            ],
            [
                "name" => "primaryButtonKind",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "primary",
                    "secondary",
                    "tertiary",
                    "ghost",
                    "danger",
                    "danger-ghost",
                    "danger-tertiary",
                ],
                "description" =>
                    "Built-in primary action button kind. Defaults to danger when danger is true, otherwise primary.",
            ],
            [
                "name" => "primaryButtonType",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => ["button", "submit", "reset"],
                "description" =>
                    "Built-in primary action button type. Defaults to submit when primaryButtonForm is provided, otherwise button.",
            ],
            [
                "name" => "primaryButtonHref",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional href for the built-in primary action.",
            ],
            [
                "name" => "primaryButtonForm",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional form ID associated with the built-in primary action.",
            ],
            [
                "name" => "primaryButtonName",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional name for the built-in primary action.",
            ],
            [
                "name" => "primaryButtonValue",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional value for the built-in primary action.",
            ],
            [
                "name" => "primaryButtonDisabled",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" => "Disables the built-in primary action.",
            ],
            [
                "name" => "primaryButtonLoading",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Sets the built-in primary action loading state and disables it.",
            ],
            [
                "name" => "secondaryButtonText",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Built-in secondary footer action label for transactional modals.",
            ],
            [
                "name" => "secondaryButtonKind",
                "type" => "string",
                "required" => false,
                "default" => "secondary",
                "values" => [
                    "primary",
                    "secondary",
                    "tertiary",
                    "ghost",
                    "danger",
                    "danger-ghost",
                    "danger-tertiary",
                ],
                "description" => "Built-in secondary action button kind.",
            ],
            [
                "name" => "secondaryButtonType",
                "type" => "string",
                "required" => false,
                "default" => "button",
                "values" => ["button", "submit", "reset"],
                "description" => "Built-in secondary action button type.",
            ],
            [
                "name" => "secondaryButtonHref",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional href for the single built-in secondary action.",
            ],
            [
                "name" => "secondaryButtonForm",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional form ID for the single built-in secondary action.",
            ],
            [
                "name" => "secondaryButtonName",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional name for the single built-in secondary action.",
            ],
            [
                "name" => "secondaryButtonValue",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional value for the single built-in secondary action.",
            ],
            [
                "name" => "secondaryButtonDisabled",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Disables generated secondary actions unless overridden per secondaryButtons item.",
            ],
            [
                "name" => "secondaryButtons",
                "type" => "array<int,array|string>",
                "required" => false,
                "default" => [],
                "values" => [],
                "description" =>
                    "Up to two generated secondary action definitions. Each item may define label/buttonText/text, kind, type, href/url, form, name, value, disabled, visible, and close.",
            ],
            [
                "name" => "shouldCloseAfterSubmit",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Enables dialog JavaScript close-after-submit behavior after primary submit events.",
            ],
        ],

        "slots" => [
            [
                "name" => "default",
                "required" => false,
                "description" => "Modal body content.",
            ],
            [
                "name" => "footer",
                "required" => false,
                "description" =>
                    "Custom footer content. Takes precedence over actions and built-in footer buttons.",
            ],
            [
                "name" => "actions",
                "required" => false,
                "description" =>
                    "Custom action content. Used when footer slot is not provided.",
            ],
        ],

        "events" => [
            [
                "name" => "ui-dialog:open",
                "bubbles" => true,
                "cancelable" => false,
                "description" =>
                    "Dispatched by dialog JavaScript after a modal opens.",
            ],
            [
                "name" => "ui-dialog:close",
                "bubbles" => true,
                "cancelable" => false,
                "description" =>
                    "Dispatched by dialog JavaScript after a modal closes.",
            ],
            [
                "name" => "ui-dialog:cancel",
                "bubbles" => true,
                "cancelable" => true,
                "description" =>
                    "Dispatched by dialog JavaScript for native cancel behavior.",
            ],
            [
                "name" => "ui-dialog:secondary",
                "bubbles" => true,
                "cancelable" => true,
                "description" =>
                    "Dispatched by dialog JavaScript when a generated or slotted secondary dialog action is activated.",
            ],
            [
                "name" => "ui-dialog:submit",
                "bubbles" => true,
                "cancelable" => true,
                "description" =>
                    "Dispatched by dialog JavaScript when a generated or slotted primary dialog action is activated.",
            ],
        ],

        "data_attributes" => [
            [
                "name" => "data-ui-component",
                "required" => true,
                "value" => "modal",
                "description" =>
                    "Generated component marker for x-ui.modal on the native dialog root.",
            ],
            [
                "name" => "data-ui-dialog",
                "required" => true,
                "description" =>
                    "Generated native dialog behavior marker inherited from x-ui.dialog.root.",
            ],
            [
                "name" => "data-ui-dialog-kind",
                "required" => true,
                "value" => "modal",
                "description" =>
                    "Generated marker identifying this dialog as the higher-level modal component.",
            ],
            [
                "name" => "data-ui-dialog-open",
                "required" => true,
                "description" =>
                    "Generated open state marker on the native dialog root.",
            ],
            [
                "name" => "data-ui-dialog-modal",
                "required" => true,
                "description" =>
                    "Generated marker indicating native showModal behavior.",
            ],
            [
                "name" => "data-ui-dialog-variant",
                "required" => true,
                "description" =>
                    "Generated passive or transactional variant marker.",
            ],
            [
                "name" => "data-ui-dialog-passive",
                "required" => true,
                "description" => "Generated passive state marker.",
            ],
            [
                "name" => "data-ui-dialog-danger",
                "required" => true,
                "description" => "Generated danger state marker.",
            ],
            [
                "name" => "data-ui-dialog-alert",
                "required" => true,
                "description" => "Generated alert state marker.",
            ],
            [
                "name" => "data-ui-dialog-size",
                "required" => true,
                "description" => "Generated size marker.",
            ],
            [
                "name" => "data-ui-dialog-full-width",
                "required" => true,
                "description" => "Generated full-width state marker.",
            ],
            [
                "name" => "data-ui-dialog-has-scrolling-content",
                "required" => true,
                "description" => "Generated scroll-content state marker.",
            ],
            [
                "name" => "data-ui-dialog-close-on-backdrop",
                "required" => true,
                "description" =>
                    "Generated backdrop dismissal behavior marker.",
            ],
            [
                "name" => "data-ui-dialog-submit-on-enter",
                "required" => true,
                "description" => "Generated submit-on-enter behavior marker.",
            ],
            [
                "name" => "data-ui-dialog-close-after-submit",
                "required" => true,
                "description" =>
                    "Generated close-after-submit behavior marker.",
            ],
            [
                "name" => "data-ui-dialog-selector-primary-focus",
                "required" => true,
                "description" => "Generated primary focus selector marker.",
            ],
            [
                "name" => "data-ui-dialog-panel",
                "required" => true,
                "description" => "Generated modal panel/container marker.",
            ],
            [
                "name" => "data-ui-modal-container",
                "required" => false,
                "description" =>
                    "Generated legacy-compatible modal container marker retained during CSS/test migration.",
            ],
            [
                "name" => "data-ui-dialog-modal-header",
                "required" => true,
                "description" => "Generated modal header marker.",
            ],
            [
                "name" => "data-ui-dialog-close",
                "required" => true,
                "description" =>
                    "Generated close behavior hook on the close button and close secondary actions.",
            ],
            [
                "name" => "data-ui-dialog-body",
                "required" => true,
                "description" =>
                    "Generated body marker inherited from x-ui.dialog.body.",
            ],
            [
                "name" => "data-ui-dialog-footer",
                "required" => false,
                "description" => "Generated footer marker when footer renders.",
            ],
            [
                "name" => "data-ui-dialog-secondary",
                "required" => false,
                "description" =>
                    "Generated secondary action marker on built-in secondary buttons.",
            ],
            [
                "name" => "data-ui-dialog-primary",
                "required" => false,
                "description" =>
                    "Generated primary action marker on the built-in primary button.",
            ],
            [
                "name" => "data-ui-dialog-primary-focus",
                "required" => false,
                "description" => "Generated preferred initial focus marker.",
            ],
            [
                "name" => "data-ui-form-action",
                "required" => false,
                "description" =>
                    "Generated form-submit-state action marker on built-in footer actions.",
            ],
            [
                "name" => "data-ui-form-action-role",
                "required" => false,
                "description" =>
                    "Generated form action role marker on built-in footer actions.",
            ],
            [
                "name" => "data-ui-form-action-allow-during-busy",
                "required" => false,
                "description" =>
                    "Generated form busy-state behavior marker on built-in footer actions.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "root" => "ui-modal",
        "required" => [
            "ui-dialog",
            "ui-dialog-container",
            "ui-modal",
            "ui-modal-container",
            "ui-modal-header",
            "ui-modal-content",
            "ui-modal-close",
        ],
        "optional" => [
            "ui-dialog--modal",
            "ui-dialog--open",
            "ui-dialog__header",
            "ui-dialog__header-controls",
            "ui-dialog__close",
            "ui-dialog-header__label",
            "ui-dialog-header__heading",
            "ui-dialog-content",
            "ui-dialog-scroll-content",
            "ui-dialog-scroll-content--no-fade",
            "ui-dialog-footer",
            "ui-button-set",
            "is-visible",
            "ui-modal-open",
            "ui-modal--open",
            "ui-modal-tall",
            "ui-modal--danger",
            "ui-modal--passive",
            "ui-modal-container--xs",
            "ui-modal-container--sm",
            "ui-modal-container--md",
            "ui-modal-container--lg",
            "ui-modal-container--full-width",
            "ui-modal-scroll-content",
            "ui-modal-header__label",
            "ui-modal-header__heading",
            "ui-modal-close-button",
            "ui-modal-close__icon",
            "ui-modal-description",
            "ui-modal-footer",
            "ui-modal-footer--three-button",
            "ui-btn",
            "ui-btn--secondary",
            "ui-btn--primary",
            "ui-btn--danger",
        ],
        "internal" => [],
        "deprecated" => [
            "div-based data-ui-modal root behavior",
            "ModalWrapper-style trigger ownership inside modal",
            "feature-local modal wrapper classes outside x-ui.modal",
            "ad hoc dialog markup outside x-ui.modal or x-ui.dialog.*",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    "variants" => [
        "transactional" => [
            "label" => "Transactional",
            "api" => ["variant" => "transactional"],
            "description" =>
                "Default modal behavior with optional generated footer/actions.",
        ],
        "passive" => [
            "label" => "Passive",
            "api" => ["variant" => "passive"],
            "class" => "ui-modal--passive",
            "description" => "Passive modal behavior without footer/actions.",
        ],
        "danger" => [
            "label" => "Danger",
            "api" => ["danger" => true],
            "class" => "ui-modal--danger",
            "description" =>
                "Danger modal treatment and danger primary action treatment.",
        ],
        "alert" => [
            "label" => "Alert",
            "api" => ["alert" => true],
            "description" => "Modal using alertdialog role.",
        ],
        "scrolling-content" => [
            "label" => "Scrolling content",
            "api" => ["hasScrollingContent" => true],
            "class" => "ui-modal-scroll-content",
            "description" => "Scrollable modal body content region.",
        ],
        "full-width" => [
            "label" => "Full width",
            "api" => ["isFullWidth" => true],
            "class" => "ui-modal-container--full-width",
            "description" => "Full-width modal container treatment.",
        ],
        "built-in-actions" => [
            "label" => "Built-in actions",
            "api" => [
                "primaryButtonText" => "Save",
                "secondaryButtonText" => "Cancel",
            ],
            "description" => "Built-in primary and secondary footer buttons.",
        ],
        "custom-footer" => [
            "label" => "Custom footer",
            "api" => ["slot" => "footer"],
            "description" => "Custom footer slot replaces built-in actions.",
        ],
        "custom-actions" => [
            "label" => "Custom actions",
            "api" => ["slot" => "actions"],
            "description" =>
                "Custom actions slot replaces built-in actions when footer slot is not provided.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    "sizes" => [
        "xs" => [
            "label" => "Extra small",
            "api" => ["size" => "xs"],
            "class" => "ui-modal-container--xs",
            "description" => "Extra small modal container.",
        ],
        "sm" => [
            "label" => "Small",
            "api" => ["size" => "sm"],
            "class" => "ui-modal-container--sm",
            "description" => "Small modal container.",
        ],
        "md" => [
            "label" => "Medium",
            "api" => ["size" => "md"],
            "class" => "ui-modal-container--md",
            "description" => "Default modal container.",
        ],
        "lg" => [
            "label" => "Large",
            "api" => ["size" => "lg"],
            "class" => "ui-modal-container--lg",
            "description" => "Large modal container.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    "states" => [
        "closed" => [
            "label" => "Closed",
            "required" => true,
            "description" => "Default closed native dialog state.",
        ],
        "open" => [
            "label" => "Open",
            "required" => false,
            "description" => "Visible native modal dialog state.",
        ],
        "backdrop-dismissible" => [
            "label" => "Backdrop dismissible",
            "required" => false,
            "description" =>
                "Clicking the backdrop may close the modal when enabled by dialog JavaScript.",
        ],
        "submit-on-enter" => [
            "label" => "Submit on Enter",
            "required" => false,
            "description" =>
                "Enter key may trigger primary submit behavior when enabled by dialog JavaScript.",
        ],
        "close-after-submit" => [
            "label" => "Close after submit",
            "required" => false,
            "description" =>
                "Modal may close after submit behavior when enabled by dialog JavaScript.",
        ],
        "primary-disabled" => [
            "label" => "Primary disabled",
            "required" => false,
            "description" => "Built-in primary footer action disabled state.",
        ],
        "primary-loading" => [
            "label" => "Primary loading",
            "required" => false,
            "description" => "Built-in primary footer action loading state.",
        ],
        "focus-contained" => [
            "label" => "Focus contained",
            "required" => true,
            "description" =>
                "Open modal behavior uses native dialog modality and dialog JavaScript focus return behavior.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => [
            "ui-dialog",
            "ui-modal",
            "ui-modal-container",
            "ui-modal-header",
            "ui-modal-content",
            "ui-modal-footer",
        ],
        "component_tokens" => [
            "modal",
            "dialog",
            "native-dialog",
            "overlay",
            "button",
        ],
        "deprecated" => [
            "data-ui-modal root controller",
            "modal.js overlay controller",
            "feature-local modal overlay classes",
            "feature-local modal sizing classes",
            "ad hoc dialog markup outside x-ui.modal",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "depends_on" => [
            "color",
            "themes",
            "spacing",
            "typography",
            "icons",
            "motion",
            "button",
            "dialog",
            "form-submit-state",
        ],
        "uses" => [
            "icons" => ["close"],
            "components" => [
                "x-ui.dialog.root",
                "x-ui.dialog.header",
                "x-ui.dialog.subtitle",
                "x-ui.dialog.title",
                "x-ui.dialog.controls",
                "x-ui.dialog.close-button",
                "x-ui.dialog.body",
                "x-ui.dialog.footer",
                "x-ui.icon",
                "x-ui.button",
            ],
            "js_initializers" => ["initDialogs"],
        ],
        "blocks" => [
            "forms",
            "confirmation-flows",
            "danger-flows",
            "overlays",
            "notification-flows",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rules
    |--------------------------------------------------------------------------
    */

    "rules" => [
        "composition" => [
            "x-ui.modal must compose x-ui.dialog.root as its native dialog root.",
            "x-ui.modal must compose x-ui.dialog.header, body, and footer primitives rather than duplicating dialog structure.",
            "Component-to-component attribute forwarding must use named props such as extraAttributes, not raw attribute-bag echoes inside x-* opening tags.",
            "Generated footer actions are allowed only for transactional modals.",
            "Footer slot takes precedence over actions slot and generated actions.",
            "Actions slot takes precedence over generated actions when footer slot is not provided.",
        ],
        "behavior" => [
            "Dialog JavaScript owns open, close, showModal, backdrop close, native cancel, native close, submit action events, secondary action events, focus return, and scroll-region synchronization.",
            "Do not import or initialize resources/js/ui-controls/modal.js for x-ui.modal.",
            'External triggers must use data-ui-dialog-trigger, data-ui-dialog-open-trigger, aria-controls, or href="#id".',
            "Do not use data-ui-modal-trigger for new modal triggers.",
            "Use data-ui-dialog-primary-focus to mark preferred initial focus targets.",
        ],
        "accessibility" => [
            "Modal must have aria-labelledby or aria-label.",
            "Title or label should provide the preferred accessible name.",
            "Description should be referenced with aria-describedby when provided.",
            "Alert modals use alertdialog role.",
            "Close button must have an accessible label.",
            "Danger modals must clearly describe destructive consequence through title, description, or body content.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "Open modal uses native dialog modality through showModal.",
            "Escape/native cancel behavior is synchronized by dialog JavaScript.",
            "Generated close controls must be keyboard reachable.",
            "Generated primary and secondary footer actions must be keyboard reachable.",
            "Scrollable content must be keyboard reachable when hasScrollingContent is true.",
        ],
        "aria" => [
            'Native dialog root renders aria-modal="true".',
            'Native dialog root renders role="dialog" or role="alertdialog".',
            "Native dialog root must have aria-labelledby or aria-label.",
            "aria-label takes precedence over aria-labelledby when supplied.",
            "Description and alert dialog states use aria-describedby to reference modal body content.",
            "Close icon is hidden from assistive technology.",
            'Scrolling content can render role="region" with tabindex="0".',
        ],
        "focus" => [
            "Dialog JavaScript owns initial focus and focus return.",
            "Native showModal provides outside-content inertness for modal dialogs.",
            "selectorPrimaryFocus identifies the preferred initial focus target.",
            "Danger modals should prefer the first secondary action as initial focus when generated actions are used.",
        ],
        "screen_reader" => [
            "Modal title, label, description, and button copy must communicate purpose and outcome.",
            "Danger modals must clearly describe destructive consequence.",
            "Passive modals must not hide required transactional decisions.",
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
                "name" => "modalHeading",
                "replacement" => "title",
                "description" =>
                    "modalHeading remains accepted as a Carbon compatibility alias.",
            ],
            [
                "name" => "modalLabel",
                "replacement" => "label",
                "description" =>
                    "modalLabel remains accepted as a Carbon compatibility alias.",
            ],
            [
                "name" => "kicker",
                "replacement" => "label",
                "description" =>
                    "kicker remains accepted as an app alias for label.",
            ],
            [
                "name" => "passiveModal",
                "replacement" => 'variant="passive"',
                "description" =>
                    "passiveModal remains accepted as a Carbon compatibility alias.",
            ],
            [
                "name" => "preventCloseOnClickOutside",
                "replacement" => "closeOnBackdrop",
                "description" =>
                    "preventCloseOnClickOutside remains accepted as an inverse compatibility alias.",
            ],
        ],
        "data_attributes" => [
            [
                "name" => "data-ui-modal-trigger",
                "replacement" => "data-ui-dialog-trigger",
                "description" =>
                    "The modal-specific trigger hook is replaced by the shared dialog trigger hook.",
            ],
            [
                "name" => "data-ui-modal-open",
                "replacement" => "data-ui-dialog-open",
                "description" =>
                    "The modal-specific open marker is replaced by the shared dialog open marker.",
            ],
            [
                "name" => "data-ui-modal-primary",
                "replacement" => "data-ui-dialog-primary",
                "description" =>
                    "The modal-specific primary action hook is replaced by the shared dialog primary action hook.",
            ],
            [
                "name" => "data-ui-modal-secondary",
                "replacement" => "data-ui-dialog-secondary",
                "description" =>
                    "The modal-specific secondary action hook is replaced by the shared dialog secondary action hook.",
            ],
            [
                "name" => "data-modal-primary-focus",
                "replacement" => "data-ui-dialog-primary-focus",
                "description" =>
                    "The old modal primary focus hook is replaced by the shared dialog primary focus hook.",
            ],
        ],
        "classes" => [
            "feature-local modal wrapper classes",
            "feature-local dialog sizing classes",
            "raw overlay utility clusters",
        ],
        "components" => [
            "ModalWrapper-style trigger ownership inside the modal component",
            "ad hoc dialog markup outside x-ui.modal or x-ui.dialog.*",
        ],
        "js" => [
            [
                "name" => "resources/js/ui-controls/modal.js",
                "replacement" => "resources/js/ui-controls/dialog.js",
                "description" =>
                    "Modal behavior is now handled by the shared native dialog controller.",
            ],
            [
                "name" => "initModals",
                "replacement" => "initDialogs",
                "description" =>
                    "Modal initialization is replaced by shared dialog initialization.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    "enforcement" => [
        "mode" => "legacy-compatible",
        "invalid_usage" => "warn",
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    "source" => [
        "blade" => ["resources/views/components/ui/modal/index.blade.php"],
        "php" => [
            "resources/views/components/ui/modal/props.php",
            "resources/views/components/ui/modal/options.php",
            "resources/views/components/ui/modal/view-model.php",
        ],
        "css" => [
            "resources/css/components/modal.css",
            "resources/css/components/dialog.css",
        ],
        "js" => [
            "resources/js/ui-controls/dialog.js",
            "resources/js/ui-controls/dialog/controller.js",
            "resources/js/ui-controls/dialog/actions.js",
            "resources/js/ui-controls/dialog/constants.js",
            "resources/js/ui-controls/dialog/focus.js",
            "resources/js/ui-controls/dialog/scroll.js",
            "resources/js/ui-controls/dialog/state.js",
            "resources/js/ui-controls/dialog/triggers.js",
        ],
        "contract" => ["resources/views/components/ui/modal/contract.php"],
        "docs" => ["docs/02-standards/ui/components/modal.md"],
    ],
]);

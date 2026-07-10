<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/dialog/contract.php
| Purpose: Dialog Component Family public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Dialog family API that can be called from
| Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Dialog is a low-level native dialog primitive family. Higher-level modal,
| confirmation, and form-dialog compositions should be owned by x-ui.modal or
| Patterns that compose these primitives.
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
        "slug" => "dialog",
        "label" => "Dialog",
        "component" => "x-ui.dialog.*",
        "summary" =>
            "Native dialog component family with root, header, controls, title, subtitle, body, footer, and close-button primitives.",
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
            "Use x-ui.dialog.* primitives for low-level native dialog compositions. Use x-ui.modal when the higher-level modal API, modal sizing, generated footer actions, focus sentinels, or transactional modal behavior is preferred.",

        "props" => [],

        "slots" => [],

        "events" => [],

        "data_attributes" => [
            [
                "name" => "data-ui-component",
                "required" => true,
                "description" =>
                    "Generated component marker on each dialog primitive.",
            ],
            [
                "name" => "data-ui-dialog",
                "required" => false,
                "description" => "Generated root dialog marker.",
            ],
            [
                "name" => "data-ui-dialog-container",
                "required" => false,
                "description" => "Generated root dialog container marker.",
            ],
            [
                "name" => "data-ui-dialog-modal",
                "required" => false,
                "description" =>
                    "Generated modal/modeless state marker on the root dialog.",
            ],
            [
                "name" => "data-ui-dialog-open",
                "required" => false,
                "description" =>
                    "Generated open state marker on the root dialog.",
            ],
            [
                "name" => "data-ui-dialog-header",
                "required" => false,
                "description" => "Generated header marker.",
            ],
            [
                "name" => "data-ui-dialog-controls",
                "required" => false,
                "description" => "Generated header controls marker.",
            ],
            [
                "name" => "data-ui-dialog-title",
                "required" => false,
                "description" => "Generated title marker.",
            ],
            [
                "name" => "data-ui-dialog-subtitle",
                "required" => false,
                "description" => "Generated subtitle marker.",
            ],
            [
                "name" => "data-ui-dialog-body",
                "required" => false,
                "description" => "Generated body marker.",
            ],
            [
                "name" => "data-ui-dialog-body-scroll-content",
                "required" => false,
                "description" => "Generated body scroll-region state marker.",
            ],
            [
                "name" => "data-ui-dialog-body-no-fade",
                "required" => false,
                "description" => "Generated body no-fade state marker.",
            ],
            [
                "name" => "data-ui-dialog-footer",
                "required" => false,
                "description" => "Generated footer marker.",
            ],
            [
                "name" => "data-ui-dialog-footer-three-button",
                "required" => false,
                "description" => "Generated three-button footer state marker.",
            ],
            [
                "name" => "data-ui-dialog-footer-busy",
                "required" => false,
                "description" => "Generated footer busy state marker.",
            ],
            [
                "name" => "data-ui-dialog-close-button",
                "required" => false,
                "description" => "Generated close button marker.",
            ],
            [
                "name" => "data-ui-dialog-close",
                "required" => false,
                "description" =>
                    "Generated or caller-provided close behavior hook consumed by dialog JavaScript.",
            ],
            [
                "name" => "data-ui-dialog-trigger",
                "required" => false,
                "description" =>
                    "Caller-provided trigger target hook. May contain a dialog id or be paired with aria-controls or href.",
            ],
            [
                "name" => "data-ui-dialog-open",
                "required" => false,
                "description" =>
                    "Caller-provided open trigger hook or generated root open state marker depending on element context.",
            ],
            [
                "name" => "data-ui-dialog-trigger-open",
                "required" => false,
                "description" =>
                    "Generated trigger open state marker applied by dialog JavaScript.",
            ],
            [
                "name" => "data-ui-dialog-close-on-backdrop",
                "required" => false,
                "description" =>
                    "Optional caller-provided backdrop close control. Set to false to prevent modal backdrop dismissal.",
            ],
            [
                "name" => "data-ui-dialog-prevent-close-on-backdrop",
                "required" => false,
                "description" =>
                    "Optional caller-provided backdrop close control. Set to true to prevent modal backdrop dismissal.",
            ],
            [
                "name" => "data-ui-dialog-primary-focus",
                "required" => false,
                "description" =>
                    "Optional caller-provided focus target hook used by dialog JavaScript when the dialog opens.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subcomponents
    |--------------------------------------------------------------------------
    */

    "subcomponents" => [
        "root" => [
            "label" => "Dialog Root",
            "component" => "x-ui.dialog.root",
            "description" =>
                "Native dialog element and dialog container. JavaScript owns dynamic show, showModal, close, trigger state, backdrop close, and focus return behavior.",
            "props" => [
                [
                    "name" => "modal",
                    "type" => "bool",
                    "required" => false,
                    "default" => false,
                    "description" =>
                        "Modal dialog state. Dialog JavaScript uses showModal when true and show when false.",
                ],
                [
                    "name" => "open",
                    "type" => "bool",
                    "required" => false,
                    "default" => false,
                    "description" =>
                        "Initial open state. Dialog JavaScript normalizes rendered open state and owns dynamic transitions.",
                ],
                [
                    "name" => "role",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "values" => ["dialog", "alertdialog"],
                    "description" => "Optional explicit dialog role.",
                ],
                [
                    "name" => "label",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "description" => "App alias for aria-label.",
                ],
                [
                    "name" => "labelledby",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "description" => "App alias for aria-labelledby.",
                ],
                [
                    "name" => "describedby",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "description" => "App alias for aria-describedby.",
                ],
                [
                    "name" => "ariaLabel",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "description" => "Compatibility alias for aria-label.",
                ],
                [
                    "name" => "ariaLabelledBy",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "description" => "Compatibility alias for aria-labelledby.",
                ],
                [
                    "name" => "ariaDescribedBy",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "description" =>
                        "Compatibility alias for aria-describedby.",
                ],
            ],
        ],

        "header" => [
            "label" => "Dialog Header",
            "component" => "x-ui.dialog.header",
            "description" =>
                "Dialog header region. Usually contains subtitle, title, and controls.",
            "props" => [],
        ],

        "controls" => [
            "label" => "Dialog Controls",
            "component" => "x-ui.dialog.controls",
            "description" =>
                "Dialog header controls region. Usually contains x-ui.dialog.close-button.",
            "props" => [],
        ],

        "close-button" => [
            "label" => "Dialog Close Button",
            "component" => "x-ui.dialog.close-button",
            "description" =>
                "Dialog close button with default close icon and dialog JavaScript close hook.",
            "props" => [
                [
                    "name" => "label",
                    "type" => "string",
                    "required" => false,
                    "default" => "Close",
                    "description" => "Accessible close button label and title.",
                ],
                [
                    "name" => "type",
                    "type" => "string",
                    "required" => false,
                    "default" => "button",
                    "values" => ["button", "submit", "reset"],
                    "description" => "Native button type.",
                ],
            ],
        ],

        "title" => [
            "label" => "Dialog Title",
            "component" => "x-ui.dialog.title",
            "description" =>
                "Dialog heading title. Callers should provide an id when the dialog root or body needs to reference this heading.",
            "props" => [
                [
                    "name" => "tag",
                    "type" => "string",
                    "required" => false,
                    "default" => "h2",
                    "values" => ["h1", "h2", "h3", "h4", "h5", "h6"],
                    "description" => "Heading tag.",
                ],
            ],
        ],

        "subtitle" => [
            "label" => "Dialog Subtitle",
            "component" => "x-ui.dialog.subtitle",
            "description" =>
                "Dialog subtitle or label text. Carbon renders this as h2 by default.",
            "props" => [
                [
                    "name" => "tag",
                    "type" => "string",
                    "required" => false,
                    "default" => "h2",
                    "values" => ["h2", "h3", "h4", "p", "div"],
                    "description" => "Subtitle tag.",
                ],
            ],
        ],

        "body" => [
            "label" => "Dialog Body",
            "component" => "x-ui.dialog.body",
            "description" =>
                "Dialog content region with optional scroll-region treatment.",
            "props" => [
                [
                    "name" => "hasScrollingContent",
                    "type" => "bool",
                    "required" => false,
                    "default" => false,
                    "description" =>
                        "Enables scroll-content classes and keyboard-reachable region behavior.",
                ],
                [
                    "name" => "noFade",
                    "type" => "bool",
                    "required" => false,
                    "default" => false,
                    "description" =>
                        "Suppresses scroll fade treatment when scroll content is active.",
                ],
                [
                    "name" => "labelledby",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "description" =>
                        "Accessible region labelledby target for scroll content.",
                ],
                [
                    "name" => "ariaLabelledBy",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "description" =>
                        "Compatibility alias for labelledby / aria-labelledby.",
                ],
                [
                    "name" => "ariaLabel",
                    "type" => "string|null",
                    "required" => false,
                    "default" => null,
                    "description" =>
                        "Accessible region label fallback for scroll content.",
                ],
            ],
        ],

        "footer" => [
            "label" => "Dialog Footer",
            "component" => "x-ui.dialog.footer",
            "description" =>
                "Dialog footer rendered as an x-ui.button-set wrapper.",
            "props" => [
                [
                    "name" => "threeButton",
                    "type" => "bool",
                    "required" => false,
                    "default" => false,
                    "description" => "Three-button footer treatment.",
                ],
                [
                    "name" => "busy",
                    "type" => "bool",
                    "required" => false,
                    "default" => false,
                    "description" => "Busy footer state.",
                ],
                [
                    "name" => "stacked",
                    "type" => "bool",
                    "required" => false,
                    "default" => false,
                    "description" =>
                        "Forwards stacked layout to the composed x-ui.button-set.",
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "root" => "ui-dialog",
        "required" => ["ui-dialog", "ui-dialog-container"],
        "optional" => [
            "ui-dialog--modal",
            "ui-dialog--open",
            "ui-dialog__header",
            "ui-dialog__header-controls",
            "ui-dialog__close",
            "ui-icon__close",
            "ui-dialog-header__heading",
            "ui-dialog-header__label",
            "ui-dialog-content",
            "ui-dialog-scroll-content",
            "ui-dialog-scroll-content--no-fade",
            "ui-dialog-footer",
            "ui-dialog-footer--three-button",
            "ui-button-set",
        ],
        "internal" => [],
        "deprecated" => [
            "feature-local native dialog wrappers",
            "raw dialog markup outside x-ui.dialog.*",
            "duplicated modal-style dialog wrappers outside x-ui.modal or x-ui.dialog.*",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    "variants" => [
        "non-modal" => [
            "label" => "Non-modal",
            "api" => ["root" => ["modal" => false]],
            "class" => "ui-dialog",
            "description" =>
                "Non-modal native dialog displayed with show(). Page content remains interactive.",
        ],
        "modal" => [
            "label" => "Modal",
            "api" => ["root" => ["modal" => true]],
            "class" => "ui-dialog--modal",
            "description" =>
                "Modal native dialog displayed with showModal(). Page content outside the dialog is made inert by the browser.",
        ],
        "open" => [
            "label" => "Open",
            "api" => ["root" => ["open" => true]],
            "class" => "ui-dialog--open",
            "description" => "Dialog initially rendered open.",
        ],
        "alertdialog" => [
            "label" => "Alert dialog",
            "api" => ["root" => ["role" => "alertdialog"]],
            "description" => "Dialog with alertdialog role.",
        ],
        "with-controls" => [
            "label" => "With controls",
            "api" => ["controls" => []],
            "class" => "ui-dialog__header-controls",
            "description" =>
                "Dialog header includes a controls region, usually for the close button.",
        ],
        "scrolling-body" => [
            "label" => "Scrolling body",
            "api" => ["body" => ["hasScrollingContent" => true]],
            "class" => "ui-dialog-scroll-content",
            "description" => "Dialog body with scroll-region treatment.",
        ],
        "no-fade-body" => [
            "label" => "No fade body",
            "api" => [
                "body" => [
                    "hasScrollingContent" => true,
                    "noFade" => true,
                ],
            ],
            "class" => "ui-dialog-scroll-content--no-fade",
            "description" => "Scrollable dialog body without fade treatment.",
        ],
        "three-button-footer" => [
            "label" => "Three-button footer",
            "api" => ["footer" => ["threeButton" => true]],
            "class" => "ui-dialog-footer--three-button",
            "description" => "Dialog footer with three-button treatment.",
        ],
        "busy-footer" => [
            "label" => "Busy footer",
            "api" => ["footer" => ["busy" => true]],
            "description" => "Dialog footer with aria-busy state.",
        ],
        "stacked-footer" => [
            "label" => "Stacked footer",
            "api" => ["footer" => ["stacked" => true]],
            "description" =>
                "Dialog footer forwards stacked layout to x-ui.button-set.",
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
    | States
    |--------------------------------------------------------------------------
    */

    "states" => [
        "closed" => [
            "label" => "Closed",
            "required" => true,
            "description" => "Dialog not open.",
        ],
        "open" => [
            "label" => "Open",
            "required" => false,
            "description" => "Dialog open state.",
        ],
        "modal" => [
            "label" => "Modal",
            "required" => false,
            "description" =>
                "Dialog rendered as modal by installed Dialog JavaScript.",
        ],
        "non-modal" => [
            "label" => "Non-modal",
            "required" => false,
            "description" =>
                "Dialog rendered as non-modal by installed Dialog JavaScript.",
        ],
        "scrolling-content" => [
            "label" => "Scrolling content",
            "required" => false,
            "description" => "Body is treated as a scrollable region.",
        ],
        "busy-footer" => [
            "label" => "Busy footer",
            "required" => false,
            "description" => "Footer indicates busy state.",
        ],
        "focus-visible" => [
            "label" => "Focus-visible",
            "required" => true,
            "description" =>
                "Visible focus state for close button, body scroll region, and slotted controls.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => ["ui-dialog", "ui-dialog-header", "ui-button-set"],
        "component_tokens" => [
            "dialog",
            "native-dialog",
            "modal-dialog",
            "non-modal-dialog",
            "alertdialog",
        ],
        "deprecated" => [
            "feature-local native dialog wrappers",
            "raw dialog markup",
            "dialog controls contract without Blade implementation",
            "modal-specific composition duplicated in low-level dialog primitives",
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
            "button",
            "button-set",
            "icon-button",
            "motion",
        ],
        "uses" => [
            "icons" => ["close"],
            "components" => ["x-ui.icon", "x-ui.button-set"],
            "js_initializers" => ["initDialogs"],
        ],
        "blocks" => [
            "modal",
            "dialogs",
            "confirmation-flows",
            "task-flows",
            "form-dialog-pattern",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rules
    |--------------------------------------------------------------------------
    */

    "rules" => [
        "composition" => [
            "Use x-ui.dialog.root as the native dialog root.",
            "Use x-ui.dialog.header for the header region.",
            "Use x-ui.dialog.subtitle and x-ui.dialog.title for dialog header text.",
            "Use x-ui.dialog.controls for header controls such as close actions.",
            "Use x-ui.dialog.close-button for the standard close control.",
            "Use x-ui.dialog.body for dialog content.",
            "Use x-ui.dialog.footer for footer actions.",
            "Use x-ui.modal instead of manually composing these primitives when the higher-level transactional modal API is preferred.",
        ],
        "behavior" => [
            "Dialog JavaScript owns trigger wiring, open and close state, modal versus modeless display, backdrop dismissal, native close/cancel synchronization, and focus return.",
            "Use data-ui-dialog-trigger, data-ui-dialog-open, aria-controls, or href to connect triggers to dialogs.",
            "Use data-ui-dialog-close on slotted controls that should close the dialog.",
            "Use data-ui-dialog-close-on-backdrop=\"false\" or data-ui-dialog-prevent-close-on-backdrop=\"true\" to prevent modal backdrop dismissal.",
            "Use data-ui-dialog-primary-focus on the preferred focus target when the dialog opens.",
        ],
        "accessibility" => [
            "Dialog root must have aria-label or aria-labelledby.",
            "aria-label takes precedence over aria-labelledby when both are supplied.",
            "Dialog body scroll regions should have aria-labelledby or aria-label.",
            "Close buttons must have accessible labels.",
            "Footer busy state must emit aria-busy.",
            "Do not rely on visual layout alone to communicate critical or destructive dialog intent.",
        ],
        "boundaries" => [
            "x-ui.dialog.* is a primitive family, not a full product modal API.",
            "x-ui.modal owns the higher-level modal component API.",
            "Patterns own workflow-specific dialog compositions such as form dialogs or destructive confirmation flows.",
            "Low-level dialog primitives should not own generated business actions, persistence, authorization, or form submission semantics.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "Close button and slotted controls must be keyboard reachable.",
            "Native dialog Esc/cancel and close behavior is synchronized by installed Dialog JavaScript.",
            "Modal display behavior uses native showModal when modal is true.",
            "Non-modal display behavior uses native show when modal is false.",
            "Scrollable body region must be keyboard reachable when hasScrollingContent is true.",
        ],
        "aria" => [
            "Dialog must have aria-label or aria-labelledby.",
            "aria-label takes precedence over aria-labelledby when both are supplied.",
            "Dialog body scroll region should have aria-labelledby or aria-label.",
            "Close button must have an accessible label.",
            "Footer busy state emits aria-busy.",
        ],
        "focus" => [
            "Open dialog should place focus according to installed Dialog JavaScript behavior.",
            "Slotted data-ui-dialog-primary-focus targets should receive initial focus when supplied.",
            "Close button, scrollable body, and slotted controls must show visible focus.",
            "Focus should return to the invoker after close when Dialog JavaScript supports it.",
        ],
        "screen_reader" => [
            "Dialog title should clearly describe the task.",
            "Subtitle/body copy should provide context without duplicating the title.",
            "Alert dialogs should be reserved for important messages requiring user attention.",
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
                "name" => "root.label",
                "replacement" => "aria-label",
                "description" =>
                    "label remains accepted as an app alias for aria-label.",
            ],
            [
                "name" => "root.labelledby",
                "replacement" => "aria-labelledby",
                "description" =>
                    "labelledby remains accepted as an app alias for aria-labelledby.",
            ],
            [
                "name" => "root.describedby",
                "replacement" => "aria-describedby",
                "description" =>
                    "describedby remains accepted as an app alias for aria-describedby.",
            ],
            [
                "name" => "root.ariaLabel",
                "replacement" => "aria-label",
                "description" =>
                    "ariaLabel remains accepted as a compatibility alias.",
            ],
            [
                "name" => "root.ariaLabelledBy",
                "replacement" => "aria-labelledby",
                "description" =>
                    "ariaLabelledBy remains accepted as a compatibility alias.",
            ],
            [
                "name" => "root.ariaDescribedBy",
                "replacement" => "aria-describedby",
                "description" =>
                    "ariaDescribedBy remains accepted as a compatibility alias.",
            ],
            [
                "name" => "body.ariaLabelledBy",
                "replacement" => "body.labelledby",
                "description" =>
                    "ariaLabelledBy remains accepted as a compatibility alias for body scroll-region labelling.",
            ],
        ],
        "classes" => [
            "feature-local dialog classes",
            "raw native dialog utility clusters",
        ],
        "components" => [
            "ad hoc native dialogs outside x-ui.dialog.*",
            "workflow-specific dialog markup that should be a Pattern or x-ui.modal usage",
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
        "blade" => [
            "resources/views/components/ui/dialog/root.blade.php",
            "resources/views/components/ui/dialog/header.blade.php",
            "resources/views/components/ui/dialog/controls.blade.php",
            "resources/views/components/ui/dialog/close-button.blade.php",
            "resources/views/components/ui/dialog/title.blade.php",
            "resources/views/components/ui/dialog/subtitle.blade.php",
            "resources/views/components/ui/dialog/body.blade.php",
            "resources/views/components/ui/dialog/footer.blade.php",
        ],
        "css" => ["resources/css/components/dialog.css"],
        "js" => ["resources/js/ui-controls/dialog.js"],
        "contract" => ["resources/views/components/ui/dialog/contract.php"],
        "docs" => ["docs/02-standards/ui/components/dialog.md"],
    ],
]);

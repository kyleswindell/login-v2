<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/accordion/contract.php
| Purpose: Accordion Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Accordion API that can be called from
| Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Accordion follows Carbon-aligned disclosure anatomy:
|
| - root list
| - item
| - native button heading
| - chevron arrow
| - wrapper
| - content
|
| App data hooks and compatibility classes are emitted alongside the
| Carbon-compatible anatomy so installed JavaScript and legacy selectors can
| remain stable during migration.
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
        "slug" => "accordion",
        "label" => "Accordion",
        "component" => "x-ui.accordion",
        "summary" =>
            "Carbon-aligned expandable disclosure list with array-driven items, optional slot rendering, single or multiple open mode, contained/flush/compact/scrollable treatments, icon alignment, disabled state, ordered list support, and animated open/close behavior.",
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
            "Use x-ui.accordion for vertically grouped disclosure content where users can expand and collapse sections. Use items for standard generated panels. Use the default slot only when custom item markup is required and the caller preserves the required accordion item, heading, trigger, wrapper, and content anatomy.",

        "props" => [
            [
                "name" => "items",
                "type" => "array",
                "required" => false,
                "default" => [],
                "values" => [],
                "description" =>
                    "Accordion items. Items may be strings or arrays with id, panelId/panel_id, triggerId/trigger_id, title, meta, body/content, open, disabled, and ariaLabel/aria-label. Titles and metadata must not contain interactive controls.",
            ],
            [
                "name" => "id",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Accordion root ID. A generated ID is used when omitted.",
            ],
            [
                "name" => "variant",
                "type" => "string",
                "required" => false,
                "default" => "default",
                "values" => ["default", "contained"],
                "description" => "Accordion visual variant.",
            ],
            [
                "name" => "alignment",
                "type" => "string",
                "required" => false,
                "default" => "default",
                "values" => ["default", "flush"],
                "description" =>
                    "Accordion alignment treatment. Flush mirrors Carbon flush behavior and is ignored when the chevron is start-aligned.",
            ],
            [
                "name" => "isFlush",
                "type" => "bool|null",
                "required" => false,
                "default" => null,
                "values" => [true, false, null],
                "description" =>
                    'Carbon-style compatibility alias for alignment="flush".',
                "compatibility" => true,
            ],
            [
                "name" => "iconAlignment",
                "type" => "string",
                "required" => false,
                "default" => "end",
                "values" => ["end", "start"],
                "description" =>
                    "Chevron icon alignment. Maps to Carbon-style end or start heading alignment.",
            ],
            [
                "name" => "align",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => ["end", "start", null],
                "description" =>
                    "Carbon-style compatibility alias for iconAlignment.",
                "compatibility" => true,
            ],
            [
                "name" => "size",
                "type" => "string",
                "required" => false,
                "default" => "default",
                "values" => ["default", "compact"],
                "description" =>
                    "Accordion size treatment. Current app surface supports default and compact.",
            ],
            [
                "name" => "mode",
                "type" => "string",
                "required" => false,
                "default" => "multiple",
                "values" => ["multiple", "single"],
                "description" =>
                    "Open behavior mode. In single mode, only the first item marked open renders expanded initially and installed JavaScript closes sibling items at runtime.",
            ],
            [
                "name" => "scrollable",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Enables scrollable panel treatment and panel max-height CSS custom property.",
            ],
            [
                "name" => "panelMaxHeight",
                "type" => "string",
                "required" => false,
                "default" => "16rem",
                "values" => [],
                "description" =>
                    "Scrollable panel max height. Supports simple CSS length values such as px, rem, em, vh, vw, or %.",
            ],
            [
                "name" => "disabled",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Disables all generated accordion item triggers unless an item explicitly controls its disabled state in custom slot markup.",
            ],
            [
                "name" => "ordered",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Renders the accordion root as ol instead of ul.",
            ],
        ],

        "slots" => [
            [
                "name" => "default",
                "required" => false,
                "description" =>
                    "Manual accordion item markup. Caller should provide valid list item children preserving required item, heading button, wrapper, content, ARIA, and data hooks.",
            ],
        ],

        "events" => [],

        "data_attributes" => [
            [
                "name" => "data-ui-component",
                "required" => true,
                "value" => "accordion",
                "description" => "Generated root component marker.",
            ],
            [
                "name" => "data-ui-accordion",
                "required" => true,
                "description" => "Generated accordion root marker.",
            ],
            [
                "name" => "data-ui-accordion-mode",
                "required" => true,
                "description" => "Generated open mode marker.",
            ],
            [
                "name" => "data-ui-accordion-variant",
                "required" => true,
                "description" => "Generated variant marker.",
            ],
            [
                "name" => "data-ui-accordion-alignment",
                "required" => true,
                "description" => "Generated resolved alignment marker.",
            ],
            [
                "name" => "data-ui-accordion-icon-alignment",
                "required" => true,
                "description" => "Generated icon alignment marker.",
            ],
            [
                "name" => "data-ui-accordion-size",
                "required" => true,
                "description" => "Generated size marker.",
            ],
            [
                "name" => "data-ui-accordion-disabled",
                "required" => true,
                "description" => "Generated disabled marker.",
            ],
            [
                "name" => "data-ui-accordion-ordered",
                "required" => true,
                "description" => "Generated ordered-list marker.",
            ],
            [
                "name" => "data-ui-accordion-scrollable",
                "required" => true,
                "description" => "Generated scrollable marker.",
            ],
            [
                "name" => "data-ui-accordion-init",
                "required" => false,
                "description" => "Generated JavaScript initialization marker.",
            ],
            [
                "name" => "data-ui-accordion-item",
                "required" => false,
                "description" => "Generated accordion item marker.",
            ],
            [
                "name" => "data-ui-accordion-item-index",
                "required" => false,
                "description" => "Generated item index marker.",
            ],
            [
                "name" => "data-ui-accordion-item-open",
                "required" => false,
                "description" =>
                    "Generated and JavaScript-maintained item open state marker.",
            ],
            [
                "name" => "data-ui-accordion-item-disabled",
                "required" => false,
                "description" =>
                    "Generated and JavaScript-maintained item disabled state marker.",
            ],
            [
                "name" => "data-ui-accordion-trigger",
                "required" => false,
                "description" =>
                    "Generated trigger marker on the native heading button.",
            ],
            [
                "name" => "data-ui-accordion-trigger-init",
                "required" => false,
                "description" =>
                    "Generated JavaScript trigger initialization marker.",
            ],
            [
                "name" => "data-ui-accordion-trigger-disabled",
                "required" => false,
                "description" => "Generated trigger disabled marker.",
            ],
            [
                "name" => "data-ui-accordion-focus",
                "required" => false,
                "description" =>
                    "JavaScript-maintained marker for persisted accordion trigger focus state.",
            ],
            [
                "name" => "data-ui-accordion-panel",
                "required" => false,
                "description" => "Generated panel wrapper marker.",
            ],
            [
                "name" => "data-ui-accordion-panel-open",
                "required" => false,
                "description" =>
                    "Generated and JavaScript-maintained panel open state marker.",
            ],
            [
                "name" => "data-ui-accordion-animating",
                "required" => false,
                "description" =>
                    "JavaScript-maintained panel animation state marker.",
            ],
            [
                "name" => "data-ui-accordion-animation-id",
                "required" => false,
                "description" =>
                    "JavaScript-maintained animation guard marker.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "root" => "ui-accordion",
        "required" => [
            "ui-accordion",

            "ui-accordion-item",
            "ui-accordion__item",

            "ui-accordion-heading",
            "ui-accordion__heading",
            "ui-accordion-trigger",

            "ui-accordion-arrow",
            "ui-accordion__arrow",
            "ui-accordion-icon",

            "ui-accordion-label",
            "ui-accordion-title",

            "ui-accordion-wrapper",
            "ui-accordion__wrapper",
            "ui-accordion-panel",

            "ui-accordion-content",
            "ui-accordion__content",
            "ui-accordion-body",
        ],
        "optional" => [
            "ui-accordion-contained",

            "ui-accordion-flush",
            "ui-accordion--flush",

            "ui-accordion-icon-start",
            "ui-accordion--start",
            "ui-accordion--end",

            "ui-accordion-compact",
            "ui-accordion-scrollable",

            "ui-accordion-meta",

            "ui-accordion-item-active",
            "ui-accordion__item--active",

            "ui-accordion-item-disabled",
            "ui-accordion-item--disabled",
            "ui-accordion__item--disabled",

            "ui-accordion-item-expanding",
            "ui-accordion__item--expanding",

            "ui-accordion-item-collapsing",
            "ui-accordion__item--collapsing",
        ],
        "internal" => [],
        "deprecated" => [
            "feature-local accordion wrappers",
            "raw disclosure groups where x-ui.accordion should be used",
            "invented x-ui.accordion-item contract until a concrete Blade component exists",
            "accordion markup that styles a heading wrapper instead of the native trigger button",
            "accordion panel/body-only anatomy without Carbon-compatible wrapper/content classes",
            "interactive content inside accordion titles",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    "variants" => [
        "default" => [
            "label" => "Default",
            "api" => [],
            "class" => "ui-accordion",
            "description" => "Default Carbon-aligned accordion.",
        ],
        "contained" => [
            "label" => "Contained",
            "api" => ["variant" => "contained"],
            "class" => "ui-accordion-contained",
            "description" => "Contained accordion treatment.",
        ],
        "flush" => [
            "label" => "Flush",
            "api" => ["alignment" => "flush"],
            "class" => "ui-accordion-flush",
            "description" =>
                "Flush accordion treatment. Ignored when iconAlignment is start.",
        ],
        "icon-start" => [
            "label" => "Icon start",
            "api" => ["iconAlignment" => "start"],
            "class" => "ui-accordion--start",
            "description" =>
                "Chevron rendered before the label using Carbon-style start alignment.",
        ],
        "icon-end" => [
            "label" => "Icon end",
            "api" => ["iconAlignment" => "end"],
            "class" => "ui-accordion--end",
            "description" =>
                "Chevron rendered after the label using Carbon-style end alignment.",
        ],
        "compact" => [
            "label" => "Compact",
            "api" => ["size" => "compact"],
            "class" => "ui-accordion-compact",
            "description" => "Compact accordion treatment.",
        ],
        "scrollable" => [
            "label" => "Scrollable",
            "api" => ["scrollable" => true],
            "class" => "ui-accordion-scrollable",
            "description" => "Scrollable panel treatment.",
        ],
        "single-mode" => [
            "label" => "Single mode",
            "api" => ["mode" => "single"],
            "description" =>
                "Only one generated item should be open at a time.",
        ],
        "multiple-mode" => [
            "label" => "Multiple mode",
            "api" => ["mode" => "multiple"],
            "description" => "Multiple generated items may be open.",
        ],
        "disabled" => [
            "label" => "Disabled",
            "api" => ["disabled" => true],
            "description" => "All generated item triggers are disabled.",
        ],
        "ordered" => [
            "label" => "Ordered",
            "api" => ["ordered" => true],
            "description" => "Accordion root rendered as an ordered list.",
        ],
        "slot-mode" => [
            "label" => "Slot mode",
            "api" => ["slot" => "default"],
            "description" => "Manual slotted accordion item markup.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    "sizes" => [
        "default" => [
            "label" => "Default",
            "api" => ["size" => "default"],
            "description" => "Default accordion size.",
        ],
        "compact" => [
            "label" => "Compact",
            "api" => ["size" => "compact"],
            "class" => "ui-accordion-compact",
            "description" => "Compact accordion size.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    "states" => [
        "default" => [
            "label" => "Default",
            "required" => true,
            "description" => "Default accordion state.",
        ],
        "open-item" => [
            "label" => "Open item",
            "required" => false,
            "description" =>
                "One or more accordion items are open. Active classes, aria-expanded, and panel visibility are synchronized.",
        ],
        "closed-item" => [
            "label" => "Closed item",
            "required" => true,
            "description" => "Accordion item panel is closed and hidden.",
        ],
        "expanding" => [
            "label" => "Expanding",
            "required" => false,
            "description" =>
                "JavaScript applies expanding classes while opening a panel.",
        ],
        "collapsing" => [
            "label" => "Collapsing",
            "required" => false,
            "description" =>
                "JavaScript applies collapsing classes while closing a panel.",
        ],
        "disabled" => [
            "label" => "Disabled",
            "required" => false,
            "description" => "Generated item triggers are disabled.",
        ],
        "single-mode" => [
            "label" => "Single mode",
            "required" => false,
            "description" => "Single open item mode.",
        ],
        "multiple-mode" => [
            "label" => "Multiple mode",
            "required" => true,
            "description" => "Multiple open item mode.",
        ],
        "scrollable" => [
            "label" => "Scrollable",
            "required" => false,
            "description" => "Scrollable panel state.",
        ],
        "focus-visible" => [
            "label" => "Focus-visible",
            "required" => true,
            "description" =>
                "Visible focus state for accordion heading buttons.",
        ],
        "reduced-motion" => [
            "label" => "Reduced motion",
            "required" => true,
            "description" =>
                "Open and close behavior must respect prefers-reduced-motion.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => ["ui-accordion"],
        "component_tokens" => [
            "accordion",
            "disclosure",
            "expand-collapse",
            "layout-size",
            "layout-density",
        ],
        "deprecated" => [
            "feature-local disclosure wrappers",
            "raw accordion utility clusters",
            "standalone accordion-item API without a Blade component",
            "interactive content inside accordion title markup",
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
            "layout",
        ],
        "uses" => [
            "icons" => ["chevron--right"],
            "components" => ["x-ui.icon"],
            "js_initializers" => ["initAccordions"],
        ],
        "blocks" => [
            "content-disclosure",
            "faq-sections",
            "settings-sections",
            "navigation-disclosure",
            "permission-catalogs",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "Accordion heading triggers must be native buttons and keyboard reachable unless disabled.",
            "Enter and Space use native button activation behavior.",
            "Escape closes an open generated item when focus is on its heading trigger.",
            "Escape closes an open generated item and returns focus to its trigger when focus is inside its panel.",
            "Installed Accordion JavaScript owns open/close behavior and single-mode sibling closing.",
            "Disabled item triggers must not be interactive.",
        ],
        "aria" => [
            "Each trigger must expose aria-expanded and aria-controls.",
            "Each panel wrapper must be labelled by its trigger through aria-labelledby.",
            'Panels render role="region" for generated item-array content.',
            "Single mode must not render more than one initially open generated panel.",
            "Disabled triggers must expose native disabled state.",
        ],
        "focus" => [
            "Accordion heading buttons must show visible focus.",
            "Runtime focus markers must not replace native focus indication.",
        ],
        "screen_reader" => [
            "Accordion item titles should clearly describe the hidden panel content.",
            "Accordion titles must not contain nested interactive content.",
            "Do not use accordion panels to hide required form fields unless their state and requirements remain clear.",
            "Use ordered mode only when the disclosure order has semantic meaning.",
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
                "name" => "align",
                "replacement" => "iconAlignment",
                "description" =>
                    "align remains accepted as a Carbon-style alias for iconAlignment.",
            ],
            [
                "name" => "isFlush",
                "replacement" => "alignment",
                "description" =>
                    'isFlush remains accepted as a Carbon-style alias for alignment="flush".',
            ],
        ],
        "classes" => [
            "feature-local accordion classes",
            "raw disclosure utility clusters",
            "panel/body-only accordion anatomy without wrapper/content compatibility classes",
        ],
        "components" => [
            "x-ui.accordion-item until a concrete Blade component exists",
            "ad hoc accordions outside x-ui.accordion",
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
        "blade" => ["resources/views/components/ui/accordion/index.blade.php"],
        "css" => ["resources/css/components/accordion.css"],
        "js" => ["resources/js/ui-controls/accordions.js"],
        "contract" => ["resources/views/components/ui/accordion/contract.php"],
        "docs" => ["docs/02-standards/ui/components/accordion.md"],
    ],
]);

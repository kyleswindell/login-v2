<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/button-set/contract.php
| Purpose: Button Set Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Button Set API that can be called from
| Blade, validated by tooling, and consumed by app layouts or Patterns.
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
        "slug" => "button-set",
        "label" => "Button Set",
        "component" => "x-ui.button-set",
        "summary" =>
            "Layout wrapper for grouping related buttons with horizontal, stacked, fluid, half-width, full-width, and auto-stacking treatments.",
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
            "Use x-ui.button-set to group related x-ui.button children in a local action area. Use fluid width and alignment options for Carbon-style action placement, including right-aligned half-width actions. Use Action Set pattern rules for semantic ordering and hierarchy where decisions require primary, secondary, or destructive ordering.",

        "props" => [
            [
                "name" => "fluid",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Enables fluid button-set layout and wraps children in the fluid inner container.",
            ],
            [
                "name" => "stacked",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Applies stacked layout when fluid mode is not active. Ignored when fluid is true.",
            ],
            [
                "name" => "autoStack",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "values" => [true, false],
                "description" =>
                    "Enables fluid auto-stack treatment on the inner wrapper when fluid is true.",
            ],
            [
                "name" => "width",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => ["half", "full"],
                "description" =>
                    "Optional fluid width treatment. Only applies when fluid is true. Use half for a 50% fluid action area or full for a 100% fluid action area.",
            ],
            [
                "name" => "align",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => ["start", "end", "stretch"],
                "description" =>
                    "Optional alignment treatment for the fluid inner container. Half-width fluid sets default to end alignment when align is not provided.",
            ],
        ],

        "slots" => [
            [
                "name" => "default",
                "required" => true,
                "description" =>
                    "Button content, typically x-ui.button children. A single x-ui.button is valid when the set owns fluid width or alignment behavior.",
            ],
        ],

        "events" => [],

        "data_attributes" => [
            [
                "name" => "data-ui-component",
                "required" => true,
                "value" => "button-set",
                "description" => "Generated root component marker.",
            ],
            [
                "name" => "data-ui-button-set",
                "required" => true,
                "description" => "Generated button set marker.",
            ],
            [
                "name" => "data-ui-button-set-fluid",
                "required" => true,
                "description" => "Generated fluid state marker.",
            ],
            [
                "name" => "data-ui-button-set-stacked",
                "required" => true,
                "description" => "Generated stacked state marker.",
            ],
            [
                "name" => "data-ui-button-set-auto-stack",
                "required" => true,
                "description" => "Generated auto-stack state marker.",
            ],
            [
                "name" => "data-ui-button-set-width",
                "required" => true,
                "description" =>
                    "Generated width marker. Emits half, full, or auto.",
            ],
            [
                "name" => "data-ui-button-set-align",
                "required" => true,
                "description" =>
                    "Generated alignment marker. Emits start, end, stretch, or auto.",
            ],
            [
                "name" => "data-ui-button-set-fluid-inner",
                "required" => false,
                "description" =>
                    "Generated fluid inner wrapper marker. Only emitted when fluid is true.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "root" => "ui-btn-set",
        "required" => ["ui-btn-set"],
        "optional" => [
            "ui-btn-set--stacked",
            "ui-btn-set--fluid",
            "ui-btn-set--width-half",
            "ui-btn-set--width-full",
            "ui-btn-set--align-start",
            "ui-btn-set--align-end",
            "ui-btn-set--align-stretch",
            "ui-btn-set__fluid-inner",
            "ui-btn-set__fluid-inner--auto-stack",
        ],
        "internal" => [],
        "deprecated" => [
            "feature-local button row wrappers",
            "ad hoc button group flex utility clusters",
            "raw action button wrapper markup where x-ui.button-set should be used",
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
            "class" => "ui-btn-set",
            "description" => "Default horizontal button set.",
        ],
        "stacked" => [
            "label" => "Stacked",
            "api" => ["stacked" => true],
            "class" => "ui-btn-set--stacked",
            "description" => "Stacked button set. Ignored when fluid is true.",
        ],
        "fluid" => [
            "label" => "Fluid",
            "api" => ["fluid" => true],
            "class" => "ui-btn-set--fluid",
            "description" => "Fluid button set with inner wrapper.",
        ],
        "fluid-auto-stack" => [
            "label" => "Fluid auto stack",
            "api" => ["fluid" => true, "autoStack" => true],
            "class" => "ui-btn-set__fluid-inner--auto-stack",
            "description" =>
                "Fluid button set with auto-stack inner treatment.",
        ],
        "fluid-half" => [
            "label" => "Fluid half width",
            "api" => ["fluid" => true, "width" => "half"],
            "class" => "ui-btn-set--width-half",
            "description" =>
                "Fluid button set constrained to 50% of the available container width. Defaults to end alignment when align is not provided.",
        ],
        "fluid-full" => [
            "label" => "Fluid full width",
            "api" => ["fluid" => true, "width" => "full"],
            "class" => "ui-btn-set--width-full",
            "description" =>
                "Fluid button set that spans the full available container width.",
        ],
        "fluid-align-start" => [
            "label" => "Fluid align start",
            "api" => ["fluid" => true, "align" => "start"],
            "class" => "ui-btn-set--align-start",
            "description" =>
                "Fluid button set aligned to the start edge of the container.",
        ],
        "fluid-align-end" => [
            "label" => "Fluid align end",
            "api" => ["fluid" => true, "align" => "end"],
            "class" => "ui-btn-set--align-end",
            "description" =>
                "Fluid button set aligned to the end edge of the container.",
        ],
        "fluid-align-stretch" => [
            "label" => "Fluid align stretch",
            "api" => ["fluid" => true, "align" => "stretch"],
            "class" => "ui-btn-set--align-stretch",
            "description" =>
                "Fluid button set stretched to the full available container width.",
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
        "default" => [
            "label" => "Default",
            "required" => true,
            "description" => "Default button set state.",
        ],
        "stacked" => [
            "label" => "Stacked",
            "required" => false,
            "description" =>
                "Stacked layout state when fluid mode is not active.",
        ],
        "fluid" => [
            "label" => "Fluid",
            "required" => false,
            "description" => "Fluid layout state with a fluid inner wrapper.",
        ],
        "auto-stack" => [
            "label" => "Auto stack",
            "required" => false,
            "description" => "Fluid inner wrapper uses auto-stack treatment.",
        ],
        "half-width" => [
            "label" => "Half width",
            "required" => false,
            "description" =>
                "Fluid inner wrapper is constrained to 50% of the container width.",
        ],
        "full-width" => [
            "label" => "Full width",
            "required" => false,
            "description" =>
                "Fluid inner wrapper spans the full container width.",
        ],
        "align-start" => [
            "label" => "Align start",
            "required" => false,
            "description" => "Fluid inner wrapper aligns to the start edge.",
        ],
        "align-end" => [
            "label" => "Align end",
            "required" => false,
            "description" => "Fluid inner wrapper aligns to the end edge.",
        ],
        "align-stretch" => [
            "label" => "Align stretch",
            "required" => false,
            "description" =>
                "Fluid inner wrapper stretches to the full available width.",
        ],
        "focus-visible" => [
            "label" => "Focus-visible",
            "required" => true,
            "description" =>
                "Visible focus state belongs to slotted button children.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => ["ui-btn-set", "ui-btn"],
        "component_tokens" => [
            "button-set",
            "button",
            "action-group",
            "layout",
        ],
        "deprecated" => [
            "feature-local action button rows",
            "raw button group flex wrappers",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "depends_on" => ["spacing", "layout", "button", "motion"],
        "uses" => [
            "icons" => [],
            "components" => ["x-ui.button"],
            "js_initializers" => [],
        ],
        "blocks" => [
            "forms",
            "dialogs",
            "modals",
            "action-sets",
            "page-actions",
            "login-actions",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "Button set itself is not keyboard interactive.",
            "Slotted button children must remain keyboard reachable unless disabled.",
        ],
        "aria" => [
            "Button set does not add group semantics by default.",
            "Caller should add aria-label, aria-labelledby, or role only when the button group requires explicit assistive grouping.",
            "Width and alignment props must not change the accessible name, role, or state of slotted button children.",
        ],
        "focus" => [
            "Visible focus belongs to slotted button children.",
            "Fluid width and alignment must not alter the document focus order.",
        ],
        "screen_reader" => [
            "Button labels must clearly describe each action.",
            "Do not rely on visual order alone when action relationship or hierarchy is ambiguous.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    "deprecations" => [
        "props" => [],
        "classes" => [
            "feature-local button set classes",
            "raw button group utility clusters",
        ],
        "components" => [
            "ad hoc action button wrappers outside x-ui.button-set or the Action Set pattern",
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
        "blade" => ["resources/views/components/ui/button-set/index.blade.php"],
        "css" => ["resources/css/components/button.css"],
        "contract" => ["resources/views/components/ui/button-set/contract.php"],
        "docs" => ["docs/02-standards/ui/components/button-set.md"],
    ],
]);

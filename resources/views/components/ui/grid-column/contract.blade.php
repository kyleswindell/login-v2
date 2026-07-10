<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/grid-column/contract.php
| Purpose: Grid Column Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Grid Column Blade adapter API that can be
| called from Blade, validated by tooling, and consumed by page, layout, module,
| and Pattern surfaces.
|
| x-ui.grid-column is a Blade adapter for direct children of the Grid
| Foundation Element. It consumes the approved ui-css-grid-column, column span,
| column start, column end, and hanging alignment utility surfaces.
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
        "slug" => "ui-grid-column",
        "label" => "Grid Column",
        "component" => "x-ui.grid-column",
        "summary" =>
            "Blade adapter for Grid column span, responsive span, placement, and hanging alignment.",
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
            "Use x-ui.grid-column as a direct child of x-ui.grid, app layout grid wrappers, or approved subgrid regions. Page, module, and Pattern surfaces should own their responsive span decisions through this component.",

        "props" => [
            [
                "name" => "tag",
                "type" => "string",
                "required" => false,
                "default" => "div",
                "values" => [
                    "div",
                    "section",
                    "article",
                    "aside",
                    "header",
                    "footer",
                    "main",
                    "li",
                    "form",
                ],
                "description" => "HTML tag used for the rendered grid column.",
            ],
            [
                "name" => "span",
                "type" => "string|int",
                "required" => false,
                "default" => "100",
                "values" => [
                    "0",
                    "1",
                    "2",
                    "3",
                    "4",
                    "5",
                    "6",
                    "7",
                    "8",
                    "9",
                    "10",
                    "11",
                    "12",
                    "13",
                    "14",
                    "15",
                    "16",
                    "auto",
                    "100",
                    "75",
                    "50",
                    "25",
                    "full",
                    "half",
                    "quarter",
                ],
                "description" =>
                    "Default column span before breakpoint-specific overrides.",
            ],
            [
                "name" => "sm",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "0",
                    "1",
                    "2",
                    "3",
                    "4",
                    "auto",
                    "100",
                    "75",
                    "50",
                    "25",
                    null,
                ],
                "description" => "Small breakpoint column span override.",
            ],
            [
                "name" => "md",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "0",
                    "1",
                    "2",
                    "3",
                    "4",
                    "5",
                    "6",
                    "7",
                    "8",
                    "auto",
                    "100",
                    "75",
                    "50",
                    "25",
                    null,
                ],
                "description" => "Medium breakpoint column span override.",
            ],
            [
                "name" => "lg",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "0",
                    "1",
                    "2",
                    "3",
                    "4",
                    "5",
                    "6",
                    "7",
                    "8",
                    "9",
                    "10",
                    "11",
                    "12",
                    "13",
                    "14",
                    "15",
                    "16",
                    "auto",
                    "100",
                    "75",
                    "50",
                    "25",
                    null,
                ],
                "description" => "Large breakpoint column span override.",
            ],
            [
                "name" => "xlg",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "0",
                    "1",
                    "2",
                    "3",
                    "4",
                    "5",
                    "6",
                    "7",
                    "8",
                    "9",
                    "10",
                    "11",
                    "12",
                    "13",
                    "14",
                    "15",
                    "16",
                    "auto",
                    "100",
                    "75",
                    "50",
                    "25",
                    null,
                ],
                "description" => "Extra large breakpoint column span override.",
            ],
            [
                "name" => "max",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "0",
                    "1",
                    "2",
                    "3",
                    "4",
                    "5",
                    "6",
                    "7",
                    "8",
                    "9",
                    "10",
                    "11",
                    "12",
                    "13",
                    "14",
                    "15",
                    "16",
                    "auto",
                    "100",
                    "75",
                    "50",
                    "25",
                    null,
                ],
                "description" => "Max breakpoint column span override.",
            ],
            [
                "name" => "start",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "auto",
                    "1",
                    "2",
                    "3",
                    "4",
                    "5",
                    "6",
                    "7",
                    "8",
                    "9",
                    "10",
                    "11",
                    "12",
                    "13",
                    "14",
                    "15",
                    "16",
                    null,
                ],
                "description" => "Default grid-column-start placement.",
            ],
            [
                "name" => "end",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "auto",
                    "2",
                    "3",
                    "4",
                    "5",
                    "6",
                    "7",
                    "8",
                    "9",
                    "10",
                    "11",
                    "12",
                    "13",
                    "14",
                    "15",
                    "16",
                    "17",
                    null,
                ],
                "description" => "Default grid-column-end placement.",
            ],
            [
                "name" => "smStart",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "1-16", null],
                "description" =>
                    "Small breakpoint grid-column-start placement.",
            ],
            [
                "name" => "smEnd",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "2-17", null],
                "description" => "Small breakpoint grid-column-end placement.",
            ],
            [
                "name" => "mdStart",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "1-16", null],
                "description" =>
                    "Medium breakpoint grid-column-start placement.",
            ],
            [
                "name" => "mdEnd",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "2-17", null],
                "description" => "Medium breakpoint grid-column-end placement.",
            ],
            [
                "name" => "lgStart",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "1-16", null],
                "description" =>
                    "Large breakpoint grid-column-start placement.",
            ],
            [
                "name" => "lgEnd",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "2-17", null],
                "description" => "Large breakpoint grid-column-end placement.",
            ],
            [
                "name" => "xlgStart",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "1-16", null],
                "description" =>
                    "Extra large breakpoint grid-column-start placement.",
            ],
            [
                "name" => "xlgEnd",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "2-17", null],
                "description" =>
                    "Extra large breakpoint grid-column-end placement.",
            ],
            [
                "name" => "maxStart",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "1-16", null],
                "description" => "Max breakpoint grid-column-start placement.",
            ],
            [
                "name" => "maxEnd",
                "type" => "string|int|null",
                "required" => false,
                "default" => null,
                "values" => ["auto", "2-17", null],
                "description" => "Max breakpoint grid-column-end placement.",
            ],
            [
                "name" => "hang",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Applies approved hanging alignment treatment.",
            ],
        ],

        "slots" => [
            [
                "name" => "default",
                "required" => true,
                "description" => "Column content.",
            ],
        ],

        "events" => [],

        "data_attributes" => [
            [
                "name" => "data-ui-component",
                "required" => true,
                "value" => "grid-column",
                "description" => "Generated root component marker.",
            ],
            [
                "name" => "data-ui-grid-column",
                "required" => true,
                "description" => "Generated grid column adapter marker.",
            ],
            [
                "name" => "data-ui-grid-column-span",
                "required" => true,
                "description" => "Generated default span marker.",
            ],
            [
                "name" => "data-ui-grid-column-hang",
                "required" => true,
                "description" => "Generated hanging alignment marker.",
            ],
            [
                "name" => "data-ui-grid-column-sm",
                "required" => false,
                "description" => "Generated sm span marker when supplied.",
            ],
            [
                "name" => "data-ui-grid-column-md",
                "required" => false,
                "description" => "Generated md span marker when supplied.",
            ],
            [
                "name" => "data-ui-grid-column-lg",
                "required" => false,
                "description" => "Generated lg span marker when supplied.",
            ],
            [
                "name" => "data-ui-grid-column-xlg",
                "required" => false,
                "description" => "Generated xlg span marker when supplied.",
            ],
            [
                "name" => "data-ui-grid-column-max",
                "required" => false,
                "description" => "Generated max span marker when supplied.",
            ],
            [
                "name" => "data-ui-grid-column-start",
                "required" => false,
                "description" =>
                    "Generated default column start marker when supplied.",
            ],
            [
                "name" => "data-ui-grid-column-end",
                "required" => false,
                "description" =>
                    "Generated default column end marker when supplied.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "root" => "ui-css-grid-column",
        "required" => ["ui-css-grid-column"],
        "optional" => [
            "ui-col-span-0",
            "ui-col-span-1",
            "ui-col-span-2",
            "ui-col-span-3",
            "ui-col-span-4",
            "ui-col-span-5",
            "ui-col-span-6",
            "ui-col-span-7",
            "ui-col-span-8",
            "ui-col-span-9",
            "ui-col-span-10",
            "ui-col-span-11",
            "ui-col-span-12",
            "ui-col-span-13",
            "ui-col-span-14",
            "ui-col-span-15",
            "ui-col-span-16",
            "ui-col-span-auto",
            "ui-col-span-100",
            "ui-col-span-75",
            "ui-col-span-50",
            "ui-col-span-25",

            "ui-sm:col-span-*",
            "ui-md:col-span-*",
            "ui-lg:col-span-*",
            "ui-xlg:col-span-*",
            "ui-max:col-span-*",

            "ui-col-start-*",
            "ui-sm:col-start-*",
            "ui-md:col-start-*",
            "ui-lg:col-start-*",
            "ui-xlg:col-start-*",
            "ui-max:col-start-*",

            "ui-col-end-*",
            "ui-sm:col-end-*",
            "ui-md:col-end-*",
            "ui-lg:col-end-*",
            "ui-xlg:col-end-*",
            "ui-max:col-end-*",

            "ui-grid-column-hang",
        ],
        "internal" => [],
        "deprecated" => [
            "raw ui-css-grid-column class clusters in contractable page and Pattern surfaces",
            "feature-local grid column wrappers where x-ui.grid-column should be used",
            "grid placement that visually reorders focusable content against source order",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    "variants" => [
        "full-span" => [
            "label" => "Full span",
            "api" => [
                "component" =>
                    '<x-ui.grid-column span="100">...</x-ui.grid-column>',
            ],
            "class" => "ui-col-span-100",
            "description" => "Column spans the full active grid.",
        ],
        "numeric-span" => [
            "label" => "Numeric span",
            "api" => [
                "component" =>
                    '<x-ui.grid-column span="8">...</x-ui.grid-column>',
            ],
            "class" => "ui-col-span-*",
            "description" =>
                "Column spans a fixed number of active grid columns.",
        ],
        "percentage-span" => [
            "label" => "Percentage span",
            "api" => [
                "component" =>
                    '<x-ui.grid-column span="50">...</x-ui.grid-column>',
            ],
            "class" => "ui-col-span-50",
            "description" => "Column uses approved percentage span shorthand.",
        ],
        "responsive-span" => [
            "label" => "Responsive span",
            "api" => [
                "component" =>
                    '<x-ui.grid-column span="100" lg="8">...</x-ui.grid-column>',
            ],
            "class" => "ui-lg:col-span-*",
            "description" => "Column span changes by breakpoint.",
        ],
        "placed-column" => [
            "label" => "Placed column",
            "api" => [
                "component" =>
                    '<x-ui.grid-column span="8" start="3" end="11">...</x-ui.grid-column>',
            ],
            "class" => "ui-col-start-* ui-col-end-*",
            "description" => "Column uses explicit start and end placement.",
        ],
        "responsive-placement" => [
            "label" => "Responsive placement",
            "api" => [
                "component" =>
                    '<x-ui.grid-column span="100" lg="8" lg-start="3" lg-end="11">...</x-ui.grid-column>',
            ],
            "class" => "ui-lg:col-start-* ui-lg:col-end-*",
            "description" => "Column placement changes by breakpoint.",
        ],
        "hanging-column" => [
            "label" => "Hanging column",
            "api" => [
                "component" => "<x-ui.grid-column hang>...</x-ui.grid-column>",
            ],
            "class" => "ui-grid-column-hang",
            "description" =>
                "Column content aligns to approved hanging gutter treatment.",
        ],
        "semantic-tag" => [
            "label" => "Semantic tag",
            "api" => [
                "component" =>
                    '<x-ui.grid-column tag="section">...</x-ui.grid-column>',
            ],
            "description" =>
                "Column renders with a caller-selected semantic tag.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    "sizes" => [
        "sm" => [
            "label" => "Small breakpoint",
            "description" =>
                "Supports sm responsive span, start, and end classes.",
        ],
        "md" => [
            "label" => "Medium breakpoint",
            "description" =>
                "Supports md responsive span, start, and end classes.",
        ],
        "lg" => [
            "label" => "Large breakpoint",
            "description" =>
                "Supports lg responsive span, start, and end classes.",
        ],
        "xlg" => [
            "label" => "Extra large breakpoint",
            "description" =>
                "Supports xlg responsive span, start, and end classes.",
        ],
        "max" => [
            "label" => "Max breakpoint",
            "description" =>
                "Supports max responsive span, start, and end classes.",
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
            "description" => "Default full-span grid column.",
        ],
        "responsive-reflow" => [
            "label" => "Responsive reflow",
            "required" => true,
            "description" =>
                "Column span and placement may change at configured breakpoints.",
        ],
        "hidden-span" => [
            "label" => "Hidden span",
            "required" => false,
            "description" =>
                "Span 0 maps to the approved hidden column utility.",
        ],
        "placed" => [
            "label" => "Placed",
            "required" => false,
            "description" => "Column start or end placement is applied.",
        ],
        "hanging" => [
            "label" => "Hanging",
            "required" => false,
            "description" => "Column hanging alignment is applied.",
        ],
        "focus-order-preserved" => [
            "label" => "Focus order preserved",
            "required" => true,
            "description" =>
                "Responsive placement must preserve meaningful source and keyboard focus order.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => [
            "ui-css-grid-column",
            "ui-col-span",
            "ui-col-start",
            "ui-col-end",
            "ui-grid-column-hang",
        ],
        "component_tokens" => [
            "grid-column",
            "span",
            "responsive-span",
            "column-start",
            "column-end",
            "column-hang",
        ],
        "deprecated" => [
            "feature-local grid column wrappers",
            "raw grid utility clusters where x-ui.grid-column is required by contract",
            "2x-grid as a public Blade-facing name",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "depends_on" => ["grid", "spacing", "layout"],
        "uses" => [
            "icons" => [],
            "components" => ["x-ui.grid"],
            "js_initializers" => [],
        ],
        "blocks" => [
            "page-layout",
            "dashboard-layout",
            "forms-page",
            "settings-forms",
            "data-and-content",
            "cards",
            "tiles",
            "widgets",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "Responsive span and placement must preserve meaningful source and keyboard focus order.",
            "Focusable children must remain reachable at every breakpoint.",
        ],
        "aria" => [
            "x-ui.grid-column does not add ARIA semantics by default.",
            "Semantic grouping is owned by the rendered tag and consuming layout context.",
            "Do not use column position, span, start, or end as a substitute for semantic relationships.",
        ],
        "focus" => [
            "Grid Column must not manage focus.",
            "Responsive layout changes must not move focus unexpectedly.",
        ],
        "screen_reader" => [
            "Reading order must remain understandable without visual grid placement.",
            "Do not rely on column position to communicate meaning.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations
    |--------------------------------------------------------------------------
    */

    "deprecations" => [
        "classes" => [
            "feature-local grid column wrappers",
            "raw ui-css-grid-column class clusters in contractable page and Pattern surfaces",
            "layout classes that visually reorder focusable content against source order",
        ],
        "components" => [
            "x-2x-grid-column",
            "x-layout.grid-column if the project standard is x-ui.grid-column",
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
            "resources/views/components/ui/grid-column/index.blade.php",
        ],
        "css" => [
            "resources/css/tokens/layout.css",
            "resources/css/base/grid.css",
        ],
        "contract" => [
            "resources/views/components/ui/grid-column/contract.php",
        ],
        "docs" => ["docs/02-standards/ui/elements/grid.md"],
    ],
]);

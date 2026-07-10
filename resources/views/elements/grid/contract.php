<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/elements/grid/contract.php
| Purpose: Grid Foundation Element public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public API boundaries for app-owned responsive
| CSS Grid layout geometry.
|
| Grid is a Foundation Element. It does not render a Blade component directly.
| Blade usage is provided through approved layout adapter components such as
| x-layout.grid and x-layout.grid-column.
|
| The implementation is Carbon-aligned CSS Grid using app-owned ui-* selectors
| and --ui-* custom properties. It intentionally does not implement Carbon
| Flexbox Grid unless that separate foundation is added.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::element([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    "identity" => [
        "slug" => "grid",
        "label" => "Grid",
        "component" => null,
        "summary" =>
            "Carbon-aligned responsive CSS Grid foundation for page, section, dashboard, form, data, and widget layout geometry.",
        "group" => "Foundation Elements",
        "type" => "element",
        "legacy_slugs" => ["2x-grid"],
    ],

    /*
    |--------------------------------------------------------------------------
    | Catalog
    |--------------------------------------------------------------------------
    */

    "catalog" => [
        "visibility" => "visible",
        "parent_component" => null,
        "nav_label" => "Grid",
        "nav_group" => "Foundation Elements",
        "sort_order" => null,
        "route" => null,
        "detail_pages" => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    "lifecycle" => [
        "status" => "approved",
        "system_maturity" => "standards-wireframe",
        "api_approved" => true,
        "visual_approved" => true,
        "a11y_approved" => true,
        "allowed_in_app_layouts" => true,
        "allowed_in_patterns" => true,
        "replacement" => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    "enforcement" => [
        "mode" => "legacy-compatible",
        "strict_props" => false,
        "strict_variants" => false,
        "strict_sizes" => false,
        "strict_states" => false,
        "strict_context" => false,
        "invalid_usage" => "warn",
        "allow_unknown_attributes" => [
            "class",
            "id",
            "style",
            "aria-*",
            "data-*",
            "wire:*",
            "x-*",
            "@*",
            ":*",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */

    "api" => [
        "usage_level" => "public",
        "usage_context" =>
            "Use Grid for page-level, section-level, dashboard, settings, form, and data layout geometry. Prefer the approved Blade adapters for contractable layout surfaces. Use raw utility classes only inside adapter components, legacy pages, or approved low-level examples.",

        "props" => [],

        "slots" => [],

        "events" => [],

        "blade_adapters" => [
            [
                "component" => "x-layout.grid",
                "purpose" =>
                    "Contractable Blade adapter for the ui-css-grid container.",
                "status" => "approved-adapter",
                "preferred" => true,
            ],
            [
                "component" => "x-layout.grid-column",
                "purpose" =>
                    "Contractable Blade adapter for direct children of ui-css-grid or ui-subgrid.",
                "status" => "approved-adapter",
                "preferred" => true,
            ],
        ],

        "data_attributes" => [
            [
                "name" => "data-ui-app-grid",
                "required" => false,
                "description" =>
                    "Optional app-layout marker for an opt-in page grid wrapper.",
            ],
            [
                "name" => "data-ui-grid-region",
                "required" => false,
                "description" =>
                    "Optional marker for named grid regions when a consuming Pattern needs proof or test hooks.",
            ],
            [
                "name" => "data-ui-layout-grid",
                "required" => false,
                "description" =>
                    "Generated marker from the x-layout.grid Blade adapter.",
            ],
            [
                "name" => "data-ui-layout-grid-column",
                "required" => false,
                "description" =>
                    "Generated marker from the x-layout.grid-column Blade adapter.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subcomponents / Adapters
    |--------------------------------------------------------------------------
    */

    "subcomponents" => [
        "layout-grid" => [
            "component" => "x-layout.grid",
            "type" => "blade-adapter",
            "description" =>
                "Blade adapter for the Grid container utility surface.",
        ],
        "layout-grid-column" => [
            "component" => "x-layout.grid-column",
            "type" => "blade-adapter",
            "description" =>
                "Blade adapter for Grid column span and placement utilities.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "root" => "ui-css-grid",
        "required" => [],
        "optional" => [
            "ui-css-grid",
            "ui-css-grid--full-width",
            "ui-css-grid--start",
            "ui-css-grid--end",
            "ui-css-grid--narrow",
            "ui-css-grid--condensed",
            "ui-css-grid--with-row-gap",

            "ui-css-grid-column",

            "ui-subgrid",
            "ui-subgrid--wide",
            "ui-subgrid--narrow",
            "ui-subgrid--condensed",
            "ui-subgrid--with-row-gap",

            "ui-grid-column-hang",

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

            "ui-layout-size-xs",
            "ui-layout-size-sm",
            "ui-layout-size-md",
            "ui-layout-size-lg",
            "ui-layout-size-xl",
            "ui-layout-size-2xl",

            "ui-layout-density-condensed",
            "ui-layout-density-normal",

            "ui-layout-constraint-size-default-*",
            "ui-layout-constraint-size-min-*",
            "ui-layout-constraint-size-max-*",
            "ui-layout-constraint-density-default-*",
            "ui-layout-constraint-density-min-*",
            "ui-layout-constraint-density-max-*",

            "ui-aspect-ratio",
            "ui-aspect-ratio--16x9",
            "ui-aspect-ratio--9x16",
            "ui-aspect-ratio--2x1",
            "ui-aspect-ratio--1x2",
            "ui-aspect-ratio--4x3",
            "ui-aspect-ratio--3x4",
            "ui-aspect-ratio--3x2",
            "ui-aspect-ratio--2x3",
            "ui-aspect-ratio--1x1",
            "ui-aspect-ratio--fill",
            "ui-aspect-ratio--contain",

            "ui-dashboard-grid",
        ],
        "internal" => [
            "ui-grid-gutter-start",
            "ui-grid-gutter-end",
            "ui-grid-mode-start",
            "ui-grid-mode-end",
            "ui-grid-column-hang",
        ],
        "deprecated" => [
            "2x-grid foundation slug as a public name",
            "2x Grid as a Blade-facing component name",
            "feature-local page grid wrappers",
            "feature-local dashboard grid wrappers outside approved Pattern or layout contracts",
            "raw CSS grid utility clusters where x-layout.grid and x-layout.grid-column should be used",
            "Carbon cds--grid, cds--row, or cds--col classes unless a separate Flexbox Grid foundation is intentionally added",
            "layout classes that visually reorder focusable content against source order",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    "variants" => [
        "css-grid" => [
            "label" => "CSS Grid",
            "api" => [
                "preferred" => "<x-layout.grid>...</x-layout.grid>",
                "implementation_class" => "ui-css-grid",
            ],
            "class" => "ui-css-grid",
            "description" =>
                "Base responsive CSS Grid container using app-owned Carbon-aligned grid tokens.",
            "use_when" => [
                "A page or section needs responsive grid columns.",
                "Direct children can be rendered through x-layout.grid-column or wrapped with ui-css-grid-column.",
            ],
            "do_not_use_when" => [
                "A small inline control group only needs flex or stack layout.",
            ],
        ],
        "full-width" => [
            "label" => "Full width grid",
            "api" => [
                "preferred" => "<x-layout.grid full-width>...</x-layout.grid>",
                "implementation_class" => "ui-css-grid ui-css-grid--full-width",
            ],
            "class" => "ui-css-grid--full-width",
            "description" =>
                "Grid container spans the full available inline size instead of the max grid width.",
        ],
        "start-aligned" => [
            "label" => "Start aligned grid",
            "api" => [
                "preferred" =>
                    '<x-layout.grid align="start">...</x-layout.grid>',
                "implementation_class" => "ui-css-grid ui-css-grid--start",
            ],
            "class" => "ui-css-grid--start",
            "description" => "Grid container aligns to the start edge.",
        ],
        "end-aligned" => [
            "label" => "End aligned grid",
            "api" => [
                "preferred" => '<x-layout.grid align="end">...</x-layout.grid>',
                "implementation_class" => "ui-css-grid ui-css-grid--end",
            ],
            "class" => "ui-css-grid--end",
            "description" => "Grid container aligns to the end edge.",
        ],
        "narrow" => [
            "label" => "Narrow gutter grid",
            "api" => [
                "preferred" =>
                    '<x-layout.grid mode="narrow">...</x-layout.grid>',
                "implementation_class" => "ui-css-grid ui-css-grid--narrow",
            ],
            "class" => "ui-css-grid--narrow",
            "description" =>
                "Grid gutter mode with the start gutter removed for hanging content alignment.",
        ],
        "condensed" => [
            "label" => "Condensed gutter grid",
            "api" => [
                "preferred" =>
                    '<x-layout.grid mode="condensed">...</x-layout.grid>',
                "implementation_class" => "ui-css-grid ui-css-grid--condensed",
            ],
            "class" => "ui-css-grid--condensed",
            "description" =>
                "Grid gutter mode using condensed gutter treatment.",
        ],
        "with-row-gap" => [
            "label" => "With row gap",
            "api" => [
                "preferred" => "<x-layout.grid row-gap>...</x-layout.grid>",
                "implementation_class" =>
                    "ui-css-grid ui-css-grid--with-row-gap",
            ],
            "class" => "ui-css-grid--with-row-gap",
            "description" =>
                "Adds responsive vertical rhythm between grid rows.",
        ],
        "column" => [
            "label" => "Grid column",
            "api" => [
                "preferred" =>
                    '<x-layout.grid-column span="100">...</x-layout.grid-column>',
                "implementation_class" => "ui-css-grid-column",
            ],
            "class" => "ui-css-grid-column",
            "description" =>
                "Direct child wrapper for a CSS Grid or subgrid cell.",
        ],
        "subgrid" => [
            "label" => "Subgrid",
            "api" => [
                "class" => "ui-subgrid",
            ],
            "class" => "ui-subgrid",
            "description" =>
                "Nested grid alignment utility that inherits the active column count and removes parent column gutter margins.",
        ],
        "subgrid-wide" => [
            "label" => "Wide subgrid",
            "api" => [
                "class" => "ui-subgrid ui-subgrid--wide",
            ],
            "class" => "ui-subgrid--wide",
            "description" =>
                "Subgrid gutter mode with full gutter start and end.",
        ],
        "subgrid-narrow" => [
            "label" => "Narrow subgrid",
            "api" => [
                "class" => "ui-subgrid ui-subgrid--narrow",
            ],
            "class" => "ui-subgrid--narrow",
            "description" =>
                "Subgrid gutter mode that supports hanging content alignment.",
        ],
        "subgrid-condensed" => [
            "label" => "Condensed subgrid",
            "api" => [
                "class" => "ui-subgrid ui-subgrid--condensed",
            ],
            "class" => "ui-subgrid--condensed",
            "description" =>
                "Subgrid gutter mode using condensed gutter treatment.",
        ],
        "subgrid-with-row-gap" => [
            "label" => "Subgrid with row gap",
            "api" => [
                "class" => "ui-subgrid ui-subgrid--with-row-gap",
            ],
            "class" => "ui-subgrid--with-row-gap",
            "description" => "Adds vertical rhythm between subgrid rows.",
        ],
        "column-hang" => [
            "label" => "Column hang",
            "api" => [
                "preferred" =>
                    "<x-layout.grid-column hang>...</x-layout.grid-column>",
                "implementation_class" => "ui-grid-column-hang",
            ],
            "class" => "ui-grid-column-hang",
            "description" =>
                "Aligns content where the leading gutter is removed or reduced.",
        ],
        "span" => [
            "label" => "Column span",
            "api" => [
                "preferred" =>
                    '<x-layout.grid-column span="8">...</x-layout.grid-column>',
                "implementation_class" => "ui-col-span-*",
            ],
            "description" =>
                "Unconditional column span utilities from 0 through 16, plus auto and percentage spans.",
        ],
        "responsive-span" => [
            "label" => "Responsive column span",
            "api" => [
                "preferred" =>
                    '<x-layout.grid-column span="100" lg="8">...</x-layout.grid-column>',
                "implementation_class" => "ui-{breakpoint}:col-span-*",
            ],
            "description" =>
                "Breakpoint-specific column span utilities for sm, md, lg, xlg, and max breakpoints.",
        ],
        "column-start" => [
            "label" => "Column start",
            "api" => [
                "preferred" =>
                    '<x-layout.grid-column start="3">...</x-layout.grid-column>',
                "implementation_class" => "ui-col-start-*",
            ],
            "description" => "Unconditional grid-column-start utilities.",
        ],
        "responsive-column-start" => [
            "label" => "Responsive column start",
            "api" => [
                "preferred" =>
                    '<x-layout.grid-column lg-start="3">...</x-layout.grid-column>',
                "implementation_class" => "ui-{breakpoint}:col-start-*",
            ],
            "description" =>
                "Breakpoint-specific grid-column-start utilities for sm, md, lg, xlg, and max breakpoints.",
        ],
        "column-end" => [
            "label" => "Column end",
            "api" => [
                "preferred" =>
                    '<x-layout.grid-column end="11">...</x-layout.grid-column>',
                "implementation_class" => "ui-col-end-*",
            ],
            "description" => "Unconditional grid-column-end utilities.",
        ],
        "responsive-column-end" => [
            "label" => "Responsive column end",
            "api" => [
                "preferred" =>
                    '<x-layout.grid-column lg-end="11">...</x-layout.grid-column>',
                "implementation_class" => "ui-{breakpoint}:col-end-*",
            ],
            "description" =>
                "Breakpoint-specific grid-column-end utilities for sm, md, lg, xlg, and max breakpoints.",
        ],
        "layout-size-context" => [
            "label" => "Layout size context",
            "api" => [
                "class" => "ui-layout-size-*",
            ],
            "description" =>
                "Contextual height sizing utility surface consumed by components and patterns.",
        ],
        "layout-density-context" => [
            "label" => "Layout density context",
            "api" => [
                "class" => "ui-layout-density-*",
            ],
            "description" =>
                "Contextual padding density utility surface consumed by components and patterns.",
        ],
        "aspect-ratio" => [
            "label" => "Aspect ratio",
            "api" => [
                "class" => "ui-aspect-ratio ui-aspect-ratio--16x9",
            ],
            "description" =>
                "Fixed-ratio layout utility for media wrappers, cards, preview frames, and similar geometry.",
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
            "api" => [
                "breakpoint" => "sm",
                "width" => "20rem",
                "columns" => 4,
                "margin" => "0",
            ],
            "description" => "Small breakpoint grid configuration.",
        ],
        "md" => [
            "label" => "Medium breakpoint",
            "api" => [
                "breakpoint" => "md",
                "width" => "42rem",
                "columns" => 8,
                "margin" => "1rem",
            ],
            "description" => "Medium breakpoint grid configuration.",
        ],
        "lg" => [
            "label" => "Large breakpoint",
            "api" => [
                "breakpoint" => "lg",
                "width" => "66rem",
                "columns" => 16,
                "margin" => "1rem",
            ],
            "description" => "Large breakpoint grid configuration.",
        ],
        "xlg" => [
            "label" => "Extra large breakpoint",
            "api" => [
                "breakpoint" => "xlg",
                "width" => "82rem",
                "columns" => 16,
                "margin" => "1rem",
            ],
            "description" => "Extra large breakpoint grid configuration.",
        ],
        "max" => [
            "label" => "Max breakpoint",
            "api" => [
                "breakpoint" => "max",
                "width" => "99rem",
                "columns" => 16,
                "margin" => "1.5rem",
            ],
            "description" => "Max breakpoint grid configuration.",
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
            "description" =>
                "Default CSS Grid layout uses the active breakpoint column count and margin tokens.",
        ],
        "full-width" => [
            "label" => "Full width",
            "required" => false,
            "description" => "Grid max inline size is removed.",
        ],
        "narrow" => [
            "label" => "Narrow",
            "required" => false,
            "description" => "Narrow gutter mode is active.",
        ],
        "condensed" => [
            "label" => "Condensed",
            "required" => false,
            "description" => "Condensed gutter mode is active.",
        ],
        "with-row-gap" => [
            "label" => "With row gap",
            "required" => false,
            "description" => "Grid or subgrid row gap is active.",
        ],
        "subgrid" => [
            "label" => "Subgrid",
            "required" => false,
            "description" => "Nested grid alignment utility is active.",
        ],
        "responsive-reflow" => [
            "label" => "Responsive reflow",
            "required" => true,
            "description" =>
                "Grid column count, margins, and responsive placement utilities change at configured breakpoints.",
        ],
        "rtl" => [
            "label" => "Right-to-left",
            "required" => false,
            "description" =>
                "Grid column gutter margins and hanging alignment must respect logical inline direction.",
        ],
        "focus-order-preserved" => [
            "label" => "Focus order preserved",
            "required" => true,
            "description" =>
                "Responsive grid placement must preserve meaningful source and keyboard focus order.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rules
    |--------------------------------------------------------------------------
    */

    "rules" => [
        "grid_usage" => [
            "Use x-layout.grid for contractable page-level and section-level CSS Grid layout.",
            "Use x-layout.grid-column for contractable direct children of x-layout.grid, app-layout grid wrappers, or approved subgrid regions.",
            "Use ui-css-grid and ui-css-grid-column only inside layout adapters, legacy migration views, or low-level implementation examples.",
            "Use ui-subgrid when nested content must align to the parent grid.",
            "Use responsive span, start, and end utilities to change placement by breakpoint.",
            "Use row-gap mode when vertical rhythm should match the grid gutter system.",
            "Use narrow or condensed gutter modes only where the consuming layout or Pattern contract explicitly owns that geometry.",
        ],
        "blade_adapters" => [
            "x-layout.grid is the preferred Blade API for grid containers.",
            "x-layout.grid-column is the preferred Blade API for grid column span, responsive span, start, end, and hang behavior.",
            "Contracts for pages, Patterns, and modules should depend on the Blade adapters rather than requiring raw class clusters.",
            "Raw class usage remains valid as the implementation layer and for legacy-compatible migration only.",
        ],
        "app_layout" => [
            "x-app-layout or x-layouts.app may provide an opt-in grid wrapper for page content.",
            "App layout should not force every legacy page into Grid until direct children are ready to be grid columns or x-layout.grid-column adapters.",
            "Page and Pattern surfaces should own their grid-column span decisions.",
        ],
        "composition" => [
            "Page-level Patterns may compose Grid through the approved Blade adapters.",
            "Components should not create page-level grids unless their contract explicitly owns page, shell, dashboard, or table layout.",
            "Form Page should use grid columns when rendered inside a grid-enabled app layout rather than creating a parallel max-width system.",
        ],
        "source_order" => [
            "Do not use grid placement to create a reading order that differs meaningfully from source order.",
            "Do not visually move destructive or submit actions away from their semantic form/action region.",
            "Responsive reflow must keep focus order understandable at every breakpoint.",
        ],
        "carbon_alignment" => [
            "This app implements Carbon-aligned CSS Grid utilities with ui-* class names.",
            "This app intentionally does not implement Carbon Flexbox Grid unless a separate flex-grid foundation is added.",
            "lg, xlg, and max responsive utility classes should be emitted in their own breakpoint media blocks.",
            "Responsive col-start and col-end utilities are part of the approved CSS Grid surface.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tokens
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "css_variables" => [
            "--ui-breakpoint-sm",
            "--ui-breakpoint-md",
            "--ui-breakpoint-lg",
            "--ui-breakpoint-xlg",
            "--ui-breakpoint-max",

            "--ui-grid-columns-sm",
            "--ui-grid-columns-md",
            "--ui-grid-columns-lg",
            "--ui-grid-columns-xlg",
            "--ui-grid-columns-max",

            "--ui-grid-margin-sm",
            "--ui-grid-margin-md",
            "--ui-grid-margin-lg",
            "--ui-grid-margin-xlg",
            "--ui-grid-margin-max",

            "--ui-grid-gutter-base",
            "--ui-grid-gutter-condensed",
            "--ui-grid-gutter",
            "--ui-grid-columns",
            "--ui-grid-margin",
            "--ui-grid-max-inline-size",
            "--ui-grid-gutter-start",
            "--ui-grid-gutter-end",
            "--ui-grid-column-hang",
            "--ui-grid-mode-start",
            "--ui-grid-mode-end",

            "--container-01",
            "--container-02",
            "--container-03",
            "--container-04",
            "--container-05",
            "--ui-container-01",
            "--ui-container-02",
            "--ui-container-03",
            "--ui-container-04",
            "--ui-container-05",

            "--ui-layout-size-height-xs",
            "--ui-layout-size-height-sm",
            "--ui-layout-size-height-md",
            "--ui-layout-size-height-lg",
            "--ui-layout-size-height-xl",
            "--ui-layout-size-height-2xl",
            "--ui-layout-size-height-min",
            "--ui-layout-size-height-max",
            "--ui-layout-size-height-default",
            "--ui-layout-size-height-context",
            "--ui-layout-size-height",
            "--ui-layout-size-height-local",

            "--ui-layout-density-padding-inline-condensed",
            "--ui-layout-density-padding-inline-normal",
            "--ui-layout-density-padding-inline-min",
            "--ui-layout-density-padding-inline-max",
            "--ui-layout-density-padding-inline-default",
            "--ui-layout-density-padding-inline-context",
            "--ui-layout-density-padding-inline",
            "--ui-layout-density-padding-inline-local",

            "--ui-dashboard-grid-row-size",
            "--ui-dashboard-grid-gap",
        ],
        "utility_classes" => [
            "ui-css-grid",
            "ui-css-grid-column",
            "ui-css-grid--full-width",
            "ui-css-grid--start",
            "ui-css-grid--end",
            "ui-css-grid--narrow",
            "ui-css-grid--condensed",
            "ui-css-grid--with-row-gap",

            "ui-subgrid",
            "ui-subgrid--wide",
            "ui-subgrid--narrow",
            "ui-subgrid--condensed",
            "ui-subgrid--with-row-gap",

            "ui-grid-column-hang",

            "ui-col-span-*",
            "ui-{breakpoint}:col-span-*",
            "ui-col-start-*",
            "ui-{breakpoint}:col-start-*",
            "ui-col-end-*",
            "ui-{breakpoint}:col-end-*",

            "ui-layout-size-*",
            "ui-layout-density-*",
            "ui-layout-constraint-size-*",
            "ui-layout-constraint-density-*",

            "ui-aspect-ratio",
            "ui-aspect-ratio--*",
            "ui-aspect-ratio--fill",
            "ui-aspect-ratio--contain",

            "ui-dashboard-grid",
        ],
        "blade_adapters" => ["x-layout.grid", "x-layout.grid-column"],
        "class_families" => [
            "ui-css-grid",
            "ui-css-grid-column",
            "ui-subgrid",
            "ui-col-span",
            "ui-col-start",
            "ui-col-end",
            "ui-layout-size",
            "ui-layout-density",
            "ui-layout-constraint",
            "ui-aspect-ratio",
            "ui-dashboard-grid",
        ],
        "component_tokens" => [
            "grid",
            "css-grid",
            "subgrid",
            "breakpoint",
            "container",
            "layout-context",
            "density",
            "aspect-ratio",
            "dashboard-grid",
        ],
        "deprecated" => [
            "2x-grid foundation slug",
            "2x Grid as a public component or Blade-facing name",
            "feature-local page grid systems",
            "feature-local breakpoint tokens",
            "raw max-width systems that should be Pattern-owned or grid-owned",
            "raw grid utility clusters where x-layout.grid and x-layout.grid-column should be used",
            "Carbon cds-- grid classes without app-owned ui-* mapping",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "build_tier" => 0,
        "depends_on" => ["spacing"],
        "uses" => [
            "icons" => [],
            "components" => ["x-layout.grid", "x-layout.grid-column"],
            "patterns" => [],
            "js_initializers" => [],
        ],
        "blocked_by" => [],
        "blocks" => [
            "layout",
            "app-layout",
            "page-layout",
            "dashboard-layout",
            "settings-forms",
            "forms-page",
            "data-and-content",
            "data-table",
            "cards",
            "tiles",
            "widgets",
            "shells",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    "source" => [
        "blade" => [],
        "blade_adapters" => [
            "resources/views/components/layout/grid/index.blade.php",
            "resources/views/components/layout/grid-column/index.blade.php",
        ],
        "css" => [
            "resources/css/tokens/layout.css",
            "resources/css/base/grid.css",
            "resources/css/base/layout-context.css",
            "resources/css/base/aspect-ratio.css",
        ],
        "js" => [],
        "tokens" => ["resources/css/tokens/layout.css"],
        "contract" => ["resources/views/elements/grid/contract.php"],
        "docs" => ["docs/02-standards/ui/elements/grid.md"],
        "examples" => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Examples
    |--------------------------------------------------------------------------
    */

    "examples" => [
        "required_live_examples" => [
            "basic-css-grid",
            "responsive-two-column-grid",
            "subgrid-alignment",
            "condensed-grid",
            "responsive-column-placement",
            "app-layout-grid-wrapper",
        ],

        "items" => [
            "basic-css-grid" => [
                "label" => "Basic CSS Grid",
                "description" =>
                    "Base responsive CSS Grid container with a full-width column.",
                "view" => null,
                "code" => <<<'BLADE'
                <x-layout.grid>
                    <x-layout.grid-column span="100">
                        ...
                    </x-layout.grid-column>
                </x-layout.grid>
                BLADE
                ,
                "review_state" => "needs-review",
            ],
            "responsive-two-column-grid" => [
                "label" => "Responsive two column grid",
                "description" =>
                    "Two columns that stack on smaller breakpoints and split at lg.",
                "view" => null,
                "code" => <<<'BLADE'
                <x-layout.grid row-gap>
                    <x-layout.grid-column span="100" lg="8">
                        ...
                    </x-layout.grid-column>

                    <x-layout.grid-column span="100" lg="8">
                        ...
                    </x-layout.grid-column>
                </x-layout.grid>
                BLADE
                ,
                "review_state" => "needs-review",
            ],
            "subgrid-alignment" => [
                "label" => "Subgrid alignment",
                "description" =>
                    "Nested content aligned back to the parent grid.",
                "view" => null,
                "code" => <<<'HTML'
                <div class="ui-css-grid-column ui-col-span-100">
                    <div class="ui-subgrid">
                        ...
                    </div>
                </div>
                HTML
                ,
                "review_state" => "needs-review",
            ],
            "condensed-grid" => [
                "label" => "Condensed grid",
                "description" =>
                    "Dense grid layout using condensed gutter mode.",
                "view" => null,
                "code" => <<<'BLADE'
                <x-layout.grid mode="condensed">
                    ...
                </x-layout.grid>
                BLADE
                ,
                "review_state" => "needs-review",
            ],
            "responsive-column-placement" => [
                "label" => "Responsive column placement",
                "description" =>
                    "Column span, start, and end utilities applied by breakpoint.",
                "view" => null,
                "code" => <<<'BLADE'
                <x-layout.grid-column span="100" lg="8" lg-start="3" lg-end="11">
                    ...
                </x-layout.grid-column>
                BLADE
                ,
                "review_state" => "needs-review",
            ],
            "app-layout-grid-wrapper" => [
                "label" => "App layout grid wrapper",
                "description" =>
                    "Opt-in app layout grid with page content as grid columns.",
                "view" => null,
                "code" => <<<'BLADE'
                <x-app-layout grid>
                    <x-layout.grid-column span="100" lg="10" xlg="8">
                        ...
                    </x-layout.grid-column>
                </x-app-layout>
                BLADE
                ,
                "review_state" => "needs-review",
            ],
        ],

        "install_snippets" => [
            "app-layout-grid" => <<<'BLADE'
            <x-app-layout grid>
                <x-layout.grid-column span="100" lg="10" xlg="8">
                    ...
                </x-layout.grid-column>
            </x-app-layout>
            BLADE
            ,
            "two-column-grid" => <<<'BLADE'
            <x-layout.grid row-gap>
                <x-layout.grid-column span="100" lg="8">
                    ...
                </x-layout.grid-column>

                <x-layout.grid-column span="100" lg="8">
                    ...
                </x-layout.grid-column>
            </x-layout.grid>
            BLADE
            ,
            "raw-utility-grid" => <<<'HTML'
            <div class="ui-css-grid ui-css-grid--with-row-gap">
                <div class="ui-css-grid-column ui-col-span-100 ui-lg:col-span-8">
                    ...
                </div>

                <div class="ui-css-grid-column ui-col-span-100 ui-lg:col-span-8">
                    ...
                </div>
            </div>
            HTML
        ,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Usage
    |--------------------------------------------------------------------------
    */

    "usage" => [
        "purpose" =>
            "Standardize Carbon-aligned responsive layout geometry through app-owned Grid tokens, Blade adapters, and ui-* CSS Grid utilities.",
        "use_when" => [
            "A page, page section, dashboard, data view, settings area, form page, or widget layout needs responsive columns.",
            "A parent app layout owns the grid container and page content owns its grid-column span.",
            "A contract needs a durable Blade API for layout geometry through x-layout.grid or x-layout.grid-column.",
            "Nested content needs to align back to the parent grid through subgrid utilities.",
            "Responsive span, start, or end placement is needed at sm, md, lg, xlg, or max breakpoints.",
            "A Pattern needs durable layout geometry that should not be recreated with feature-local utility clusters.",
        ],
        "do_not_use_when" => [
            "Only inline component layout is needed.",
            "A stack, flex row, button set, or component-specific layout primitive already owns the geometry.",
            "Grid placement would visually reorder content against source or keyboard focus order.",
            "A component is trying to own page-level layout without a contract requirement.",
            "The implementation depends on Carbon Flexbox Grid classes, which are intentionally not implemented by this element.",
        ],
        "related_components" => [
            "x-layout.grid",
            "x-layout.grid-column",
            "x-app-layout",
            "x-layouts.app",
            "x-patterns.forms.page",
            "x-ui.data-table",
            "x-ui.tile",
            "x-ui.card",
            "x-ui.button-set",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "Responsive reflow must preserve meaningful source and keyboard focus order.",
            "Grid placement utilities must not make focus order appear illogical.",
            "Focusable controls must remain reachable at every breakpoint.",
        ],
        "aria" => [
            "Grid utilities and adapters do not add ARIA semantics.",
            "Semantic landmarks, headings, labels, and relationships are owned by the consuming layout, Pattern, or Component.",
            "Do not use grid placement as a substitute for semantic grouping.",
        ],
        "focus" => [
            "Grid utilities must not manage focus.",
            "Responsive layout changes must not move focus unexpectedly.",
            "Source order should remain the authoritative focus order.",
        ],
        "screen_reader" => [
            "Reading order must remain understandable without visual grid placement.",
            "Do not rely on column position, span, start, or end to communicate meaning.",
            "Layouts that visually separate related controls must preserve semantic grouping through headings, fieldsets, landmarks, or Pattern-owned labels.",
        ],
        "review_state" => "approved",
    ],

    /*
    |--------------------------------------------------------------------------
    | Testing
    |--------------------------------------------------------------------------
    */

    "testing" => [
        "build_checks" => [
            "blade_exists" => false,
            "blade_adapters_exist" => true,
            "css_imported" => true,
            "js_initializer_required" => false,
            "js_initializer_registered" => false,
            "tokens_imported" => true,
            "contract_registered" => true,
            "examples_registered" => false,
        ],

        "manual_checks" => [
            "layout_tokens_imported_before_grid_css",
            "basic_css_grid_renders",
            "layout_grid_adapter_renders",
            "layout_grid_column_adapter_renders",
            "grid_columns_respect_breakpoints",
            "xlg_and_max_spans_activate_at_correct_breakpoints",
            "responsive_col_start_and_col_end_utilities_render",
            "subgrid_alignment_matches_parent_grid",
            "narrow_and_condensed_gutter_modes_render",
            "rtl_gutter_behavior_reviewed",
            "responsive_reflow_preserves_focus_order",
            "renders_in_light_theme",
            "renders_in_dark_theme",
        ],

        "automated_checks" => [
            "tokens_layout_css_imported",
            "base_grid_css_imported",
            "ui_css_grid_selector_exists",
            "ui_css_grid_column_selector_exists",
            "ui_subgrid_selector_exists",
            "ui_xlg_col_span_rules_exist",
            "ui_max_col_span_rules_exist",
            "responsive_col_start_rules_exist",
            "responsive_col_end_rules_exist",
            "no_cyclic_grid_gutter_custom_property",
        ],

        "visual_review" => [
            "required" => true,
            "states" => [
                "default",
                "full-width",
                "narrow",
                "condensed",
                "with-row-gap",
                "subgrid",
                "responsive-reflow",
            ],
            "themes" => ["light", "dark"],
            "breakpoints" => ["sm", "md", "lg", "xlg", "max"],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Review
    |--------------------------------------------------------------------------
    */

    "review" => [
        "overall_state" => "implemented",
        "blocked_by" => [],
        "last_reviewed_at" => null,
        "reviewed_by" => null,

        "scopes" => [
            "blade_api" => "adapter-owned",
            "css_contract" => "implemented",
            "js_behavior" => "not-applicable",
            "examples" => "not-started",
            "accessibility" => "approved",
            "visual_parity" => "manual-review",
            "docs_copy" => "needs-review",
            "tokens" => "implemented",
        ],

        "notes" => [
            "Grid is a Foundation Element and does not render a Blade component directly.",
            "The approved implementation is Carbon-aligned CSS Grid with app-owned ui-* selectors and --ui-* custom properties.",
            "x-layout.grid and x-layout.grid-column are the preferred contractable Blade adapters for consuming Grid in views, pages, and Patterns.",
            "Raw utility classes remain valid as the implementation layer and for legacy-compatible migration only.",
            "Carbon Flexbox Grid is intentionally omitted unless a separate Flexbox Grid foundation is added.",
            "The contract expects separate lg, xlg, and max responsive utility behavior in resources/css/base/grid.css.",
            "The contract expects responsive col-start and col-end utilities in resources/css/base/grid.css.",
            "x-app-layout and x-layouts.app may enable Grid as an opt-in wrapper before grid is made global by default.",
            "Page and Pattern surfaces should own grid-column span choices instead of creating parallel max-width systems.",
            "The legacy 2x-grid slug should be treated as a deprecated alias during migration.",
        ],
    ],
]);

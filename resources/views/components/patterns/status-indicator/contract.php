<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/status-indicator/contract.php
| Purpose: Status Indicator Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Status Indicator Pattern API that can be
| called from Blade, validated by tooling, and consumed by rendered evidence
| examples.
|
| Status Indicator is a Pattern API contract. It provides one public entry
| point for Carbon-aligned icon, shape, badge, and differential indicator
| variants while consuming existing status indicator CSS selectors and status
| component tokens.
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
        "slug" => "status-indicator",
        "label" => "Status Indicator",
        "component" => "x-patterns.status-indicator",
        "api_layer" => "Pattern API",
        "summary" =>
            "Carbon-aligned status indicator pattern with icon, shape, badge, and differential variants for communicating state, severity, counts, and change direction with semantic color and accessible labels.",
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    "lifecycle" => [
        "status" => "provisional",
        "system_maturity" => "standards-wireframe",
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Blade API
    |--------------------------------------------------------------------------
    */

    "api" => [
        "usage_context" =>
            "Use x-patterns.status-indicator when a small visual indicator is needed to communicate state, severity, count, or directional change. Use icon indicators for state, shape indicators for severity/status shape language, badge indicators for count/dot overlays, and differential indicators for additions, removals, increases, decreases, or unchanged deltas.",

        "props" => [
            [
                "name" => "id",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Pattern root ID. A generated status-indicator-* UUID ID is used when omitted.",
            ],
            [
                "name" => "variant",
                "type" => "string",
                "required" => false,
                "default" => "icon",
                "values" => ["icon", "shape", "badge", "differential"],
                "description" =>
                    "Indicator variant. icon communicates state, shape communicates severity/status shape language, badge communicates count/dot overlays, and differential communicates changes or deltas.",
            ],
            [
                "name" => "kind",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "failed",
                    "caution-major",
                    "caution-minor",
                    "undefined",
                    "succeeded",
                    "normal",
                    "in-progress",
                    "incomplete",
                    "not-started",
                    "pending",
                    "unknown",
                    "informative",
                    "critical",
                    "high",
                    "medium",
                    "low",
                    "cautious",
                    "stable",
                    "draft",
                    "error",
                    "danger",
                    "warning",
                    "success",
                    "info",
                    "notice",
                    "neutral",
                ],
                "description" =>
                    "Indicator kind. Supported values depend on variant. Common aliases such as error, danger, warning, success, info, notice, and neutral are normalized to the closest Carbon-aligned kind.",
            ],
            [
                "name" => "label",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Visible or hidden label for the indicator. Required for meaningful non-decorative usage unless the consuming component provides an equivalent accessible label.",
            ],
            [
                "name" => "count",
                "type" => "int|string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Badge count. Values greater than 999 render as 999+. When omitted, badge variant renders a dot badge.",
            ],
            [
                "name" => "value",
                "type" => "string|int|float|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional displayed value for differential indicators, such as +3, -1, or 12%.",
            ],
            [
                "name" => "direction",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [
                    "increase",
                    "up",
                    "positive",
                    "enabled",
                    "added",
                    "decrease",
                    "down",
                    "negative",
                    "disabled",
                    "removed",
                    "unchanged",
                    "neutral",
                ],
                "description" =>
                    "Differential direction. Used only by the differential variant to select icon, semantic kind, and default label.",
            ],
            [
                "name" => "icon",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional x-ui.icon name override. Use only when the default variant/kind icon is not appropriate.",
            ],
            [
                "name" => "size",
                "type" => "int|string",
                "required" => false,
                "default" => 16,
                "values" => [16, 20],
                "description" =>
                    "Icon size for icon and differential variants.",
            ],
            [
                "name" => "textSize",
                "type" => "int|string",
                "required" => false,
                "default" => 12,
                "values" => [12, 14],
                "description" => "Text size for shape variant.",
            ],
            [
                "name" => "hideLabel",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Visually hides the label while preserving it for assistive technology.",
            ],
            [
                "name" => "hidden",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Hides the badge indicator. Intended for badge variant.",
            ],
            [
                "name" => "hideWhenZero",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Hides the badge indicator when count is zero. Intended for badge variant.",
            ],
        ],

        "slots" => [],

        "events" => [],

        "data_attributes" => [
            [
                "name" => "data-pattern",
                "required" => true,
                "value" => "status-indicator",
                "description" => "Generated pattern marker.",
            ],
            [
                "name" => "data-ui-pattern",
                "required" => true,
                "value" => "status-indicator",
                "description" => "Generated UI pattern marker.",
            ],
            [
                "name" => "data-ui-status-indicator",
                "required" => true,
                "description" => "Generated status indicator root marker.",
            ],
            [
                "name" => "data-ui-status-indicator-variant",
                "required" => true,
                "description" => "Generated resolved variant marker.",
            ],
            [
                "name" => "data-ui-status-indicator-kind",
                "required" => true,
                "description" => "Generated resolved kind marker.",
            ],
            [
                "name" => "data-ui-status-indicator-direction",
                "required" => false,
                "description" => "Generated differential direction marker.",
            ],
            [
                "name" => "data-ui-badge-indicator",
                "required" => false,
                "description" =>
                    "Generated badge indicator marker for badge variant.",
            ],
            [
                "name" => "data-ui-badge-indicator-variant",
                "required" => false,
                "description" =>
                    "Generated badge variant marker: count or dot.",
            ],
            [
                "name" => "data-ui-badge-indicator-count",
                "required" => false,
                "description" =>
                    "Generated raw badge count marker when count is provided.",
            ],
            [
                "name" => "data-ui-badge-indicator-hidden",
                "required" => false,
                "description" => "Generated badge hidden marker.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "root" => "variant-dependent",
        "required" => [
            "ui-icon-indicator for icon and differential variants",
            "ui-shape-indicator for shape variant",
            "ui-badge-indicator for badge variant",
        ],
        "optional" => [
            "ui-icon-indicator-20",
            "ui-icon-indicator--20",
            "ui-icon-indicator-failed",
            "ui-icon-indicator--failed",
            "ui-icon-indicator-caution-major",
            "ui-icon-indicator--caution-major",
            "ui-icon-indicator-caution-minor",
            "ui-icon-indicator--caution-minor",
            "ui-icon-indicator-undefined",
            "ui-icon-indicator--undefined",
            "ui-icon-indicator-succeeded",
            "ui-icon-indicator--succeeded",
            "ui-icon-indicator-normal",
            "ui-icon-indicator--normal",
            "ui-icon-indicator-in-progress",
            "ui-icon-indicator--in-progress",
            "ui-icon-indicator-incomplete",
            "ui-icon-indicator--incomplete",
            "ui-icon-indicator-not-started",
            "ui-icon-indicator--not-started",
            "ui-icon-indicator-pending",
            "ui-icon-indicator--pending",
            "ui-icon-indicator-unknown",
            "ui-icon-indicator--unknown",
            "ui-icon-indicator-informative",
            "ui-icon-indicator--informative",

            "ui-shape-indicator-14",
            "ui-shape-indicator--14",
            "ui-shape-indicator-failed",
            "ui-shape-indicator--failed",
            "ui-shape-indicator-critical",
            "ui-shape-indicator--critical",
            "ui-shape-indicator-high",
            "ui-shape-indicator--high",
            "ui-shape-indicator-medium",
            "ui-shape-indicator--medium",
            "ui-shape-indicator-low",
            "ui-shape-indicator--low",
            "ui-shape-indicator-cautious",
            "ui-shape-indicator--cautious",
            "ui-shape-indicator-undefined",
            "ui-shape-indicator--undefined",
            "ui-shape-indicator-stable",
            "ui-shape-indicator--stable",
            "ui-shape-indicator-informative",
            "ui-shape-indicator--informative",
            "ui-shape-indicator-incomplete",
            "ui-shape-indicator--incomplete",
            "ui-shape-indicator-draft",
            "ui-shape-indicator--draft",

            "ui-badge-indicator-count",
            "ui-badge-indicator--count",
            "ui-badge-indicator-dot",
            "ui-badge-indicator--dot",
            "ui-badge-indicator-hidden",

            "ui-visually-hidden",
            "sr-only",
        ],
        "internal" => [],
        "deprecated" => [
            "feature-local status icon wrappers",
            "feature-local badge count wrappers",
            "raw support-color icon spans",
            "standalone severity icons without semantic label text",
            "using x-ui.icon directly for status/severity rows when x-patterns.status-indicator should be used",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Variants
    |--------------------------------------------------------------------------
    */

    "variants" => [
        "icon" => [
            "label" => "Icon indicator",
            "api" => [
                "variant" => "icon",
                "kind" => "succeeded",
                "label" => "Succeeded",
            ],
            "class" => "ui-icon-indicator",
            "description" => "State indicator using a status icon and label.",
        ],
        "shape" => [
            "label" => "Shape indicator",
            "api" => [
                "variant" => "shape",
                "kind" => "high",
                "label" => "High",
            ],
            "class" => "ui-shape-indicator",
            "description" =>
                "Severity/status indicator using a Carbon shape and label.",
        ],
        "badge" => [
            "label" => "Badge indicator",
            "api" => [
                "variant" => "badge",
                "count" => 3,
                "label" => "3 unread",
            ],
            "class" => "ui-badge-indicator",
            "description" =>
                "Badge count or dot indicator, usually positioned by the consuming component.",
        ],
        "differential" => [
            "label" => "Differential indicator",
            "api" => [
                "variant" => "differential",
                "direction" => "enabled",
                "label" => "Enabled",
            ],
            "class" => "ui-icon-indicator",
            "description" =>
                "Constrained icon indicator for additions, removals, increases, decreases, or unchanged deltas.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Indicator Kinds
    |--------------------------------------------------------------------------
    */

    "kinds" => [
        "icon" => [
            "failed",
            "caution-major",
            "caution-minor",
            "undefined",
            "succeeded",
            "normal",
            "in-progress",
            "incomplete",
            "not-started",
            "pending",
            "unknown",
            "informative",
        ],
        "shape" => [
            "failed",
            "critical",
            "high",
            "medium",
            "low",
            "cautious",
            "undefined",
            "stable",
            "informative",
            "incomplete",
            "draft",
        ],
        "differential" => [
            "increase",
            "up",
            "positive",
            "enabled",
            "added",
            "decrease",
            "down",
            "negative",
            "disabled",
            "removed",
            "unchanged",
            "neutral",
        ],
        "aliases" => [
            "error" => "failed",
            "danger" => "failed",
            "warning" => "caution-minor or cautious",
            "success" => "succeeded or stable",
            "info" => "informative",
            "notice" => "informative or undefined",
            "neutral" => "unknown or unchanged",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    "sizes" => [
        "icon-16" => [
            "label" => "Icon 16",
            "api" => ["variant" => "icon", "size" => 16],
            "description" => "Default icon indicator size.",
        ],
        "icon-20" => [
            "label" => "Icon 20",
            "api" => ["variant" => "icon", "size" => 20],
            "class" => "ui-icon-indicator--20",
            "description" => "Larger icon indicator size.",
        ],
        "shape-12" => [
            "label" => "Shape text 12",
            "api" => ["variant" => "shape", "textSize" => 12],
            "description" => "Default shape indicator helper-text size.",
        ],
        "shape-14" => [
            "label" => "Shape text 14",
            "api" => ["variant" => "shape", "textSize" => 14],
            "class" => "ui-shape-indicator--14",
            "description" => "Larger shape indicator text size.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern States
    |--------------------------------------------------------------------------
    */

    "states" => [
        "default" => [
            "label" => "Default",
            "required" => true,
            "description" => "Default visible indicator state.",
        ],
        "hidden-label" => [
            "label" => "Hidden label",
            "required" => false,
            "description" =>
                "Label is visually hidden while remaining available to assistive technology.",
        ],
        "badge-count" => [
            "label" => "Badge count",
            "required" => false,
            "description" => "Badge variant displays a count.",
        ],
        "badge-dot" => [
            "label" => "Badge dot",
            "required" => false,
            "description" =>
                "Badge variant displays a dot when no count is supplied.",
        ],
        "badge-hidden" => [
            "label" => "Badge hidden",
            "required" => false,
            "description" => "Badge variant is hidden.",
        ],
        "forced-colors" => [
            "label" => "Forced colors",
            "required" => true,
            "description" =>
                "Indicator colors must preserve meaning in forced-colors mode through existing component CSS.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    "rules" => [
        "scope" => [
            "Use status indicators only to communicate state, severity, count, or directional change.",
            "Use a label whenever the indicator is not purely decorative.",
            "Do not use a status indicator as a button, link, or interactive control.",
            "Do not use color alone to communicate meaning.",
        ],
        "icon_indicator" => [
            "Use icon variant for operational state such as succeeded, failed, in progress, pending, incomplete, unknown, or informative.",
            "Use icon variant when the icon shape is the main cue and the indicator appears inline with text, rows, lists, or status summaries.",
        ],
        "shape_indicator" => [
            "Use shape variant for severity/status scanning such as critical, high, medium, low, stable, draft, or undefined.",
            "Use shape variant when distinct geometric shapes help users scan status/severity across a list.",
        ],
        "badge_indicator" => [
            "Use badge variant for count or dot overlays.",
            "The consuming component owns badge positioning.",
            "Use hideWhenZero when zero count should not render a visible badge.",
            "Badge indicators require an accessible label because the visual shape/count alone is not enough.",
        ],
        "differential_indicator" => [
            "Use differential variant for additions, removals, increases, decreases, enabled, disabled, or unchanged deltas.",
            "Use differential indicators in change summaries, metrics, and review dialogs where a full status indicator would be too heavy.",
            "Use enabled/added for granted or added access and disabled/removed for revoked or removed access.",
        ],
        "rbac_usage" => [
            "Use differential indicators for role permission changes: enabled, disabled, added, removed, or unchanged.",
            "Use shape indicators for elevated permission severity.",
            "Use icon indicators for role or permission state such as available, pending, failed, or unknown.",
            "Do not render raw status icons in RBAC change rows when this pattern should provide semantic color and labels.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Ownership Boundary
    |--------------------------------------------------------------------------
    */

    "ownership" => [
        "owns" => [
            "public status indicator variant selection",
            "kind alias normalization",
            "icon name mapping for icon, shape, and differential indicators",
            "badge count display formatting",
            "status indicator data attributes",
            "accessible hidden-label behavior",
            "consistent use of status indicator CSS selectors",
        ],
        "does_not_own" => [
            "surrounding list, table, modal, notification, or form layout",
            "interactive behavior",
            "authorization",
            "persistence",
            "routing",
            "status token primitive values",
            "component CSS implementation for icon/shape/badge indicators",
            "business decision for which status/kind applies",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "depends_on" => [
            "icons",
            "status tokens",
            "color",
            "themes",
            "spacing",
            "typography",
        ],
        "uses" => [
            "icons" => [
                "error--filled",
                "warning--alt-inverted--filled",
                "warning--alt--filled",
                "undefined--filled",
                "checkmark--filled",
                "checkmark--outline",
                "in-progress",
                "incomplete",
                "circle-dash",
                "pending--filled",
                "unknown--filled",
                "warning-square--filled",
                "critical",
                "critical-severity",
                "caution",
                "diamond--filled",
                "low-severity",
                "circle--filled",
                "circle-stroke",
                "arrow--up",
                "arrow--down",
                "add",
                "subtract",
            ],
            "components" => ["x-ui.icon"],
            "patterns" => [],
            "js_initializers" => [],
        ],
        "blocks" => [
            "status-summaries",
            "change-summaries",
            "notification-badges",
            "role-permission-review",
            "metric-deltas",
            "contained-list rows",
            "data-table cells",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "Status indicators are not interactive and must not introduce keyboard behavior.",
            "Do not place a status indicator inside an interactive control unless it is decorative or its text is included in the control accessible name.",
        ],
        "aria" => [
            "Non-decorative indicators must provide meaningful label text.",
            "hideLabel must visually hide the label without removing it from assistive technology.",
            "Badge indicators must provide aria-label when the visual count or dot needs to be announced.",
            "Decorative SVG icons must be aria-hidden.",
        ],
        "focus" => [
            "Status indicators do not receive focus unless a caller incorrectly adds focusable attributes.",
        ],
        "screen_reader" => [
            "Label text must describe the status or change, not just the color or icon shape.",
            "Do not rely on color alone for failed, caution, success, enabled, disabled, or severity meaning.",
            "Differential labels should include the direction or outcome such as Enabled, Disabled, Added, Removed, Increased, or Decreased.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => [
            "ui-icon-indicator",
            "ui-shape-indicator",
            "ui-badge-indicator",
        ],
        "component_tokens" => [
            "status-indicator",
            "icon-indicator",
            "shape-indicator",
            "badge-indicator",
            "differential-indicator",
            "status-red",
            "status-orange",
            "status-yellow",
            "status-green",
            "status-blue",
            "status-purple",
            "status-gray",
        ],
        "deprecated" => [
            "feature-local status icon classes",
            "raw x-ui.icon status/severity rows",
            "raw badge dots outside x-patterns.status-indicator when badge semantics are required",
            "color-only status labels",
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
            "feature-local status indicator classes",
            "feature-local indicator color classes",
            "raw support-color icon wrappers",
        ],
        "components" => [
            "ad hoc status indicator markup outside x-patterns.status-indicator",
            "raw x-ui.icon usage for semantic status rows where the status-indicator pattern should be used",
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
            "resources/views/components/patterns/status-indicator/index.blade.php",
            "resources/views/components/patterns/status-indicator/partials/icon.blade.php",
            "resources/views/components/patterns/status-indicator/partials/shape.blade.php",
            "resources/views/components/patterns/status-indicator/partials/badge.blade.php",
            "resources/views/components/patterns/status-indicator/partials/differential.blade.php",
        ],
        "css" => [
            "resources/css/tokens/components/status.css",
            "resources/css/components/icon-indicator.css",
            "resources/css/components/shape-indicator.css",
            "resources/css/components/badge-indicator.css",
        ],
        "js" => [],
        "contract" => [
            "resources/views/components/patterns/status-indicator/contract.php",
        ],
        "docs" => ["docs/02-standards/ui/patterns/status-indicator.md"],
    ],
]);

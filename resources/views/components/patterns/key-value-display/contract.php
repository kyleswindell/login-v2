<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/key-value-display/contract.php
| Purpose: Key/value Display Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Key/value Display Pattern API that can be
| called from Blade, validated by tooling, and consumed by app layouts,
| modules, and other Patterns.
|
| Key/value Display owns compact read-only fact presentation using semantic
| description list markup. It is an app-owned pattern inspired by Carbon
| structured information guidance, but it is not a direct Carbon base component.
|
| Use x-ui.structured-list when row/column comparison is needed. Use
| x-ui.contained-list when the content is a repeated list of resources,
| settings, activity rows, or action rows.
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
        "slug" => "key-value-display",
        "label" => "Key/value Display",
        "component" => "x-patterns.key-value-display",
        "api_layer" => "Pattern API",
        "summary" =>
            "Compact semantic description-list pattern for read-only facts, profile metadata, settings summaries, and status details.",
        "group" => "Content Patterns",
        "type" => "pattern",
    ],

    /*
    |--------------------------------------------------------------------------
    | Catalog
    |--------------------------------------------------------------------------
    */

    "catalog" => [
        "visibility" => "visible",
        "parent_component" => null,
        "nav_label" => "Key/value Display",
        "nav_group" => "Content",
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
        "status" => "provisional",
        "system_maturity" => "standards-wireframe",
        "api_approved" => false,
        "visual_approved" => false,
        "a11y_approved" => false,
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
        "mode" => "pattern-guidance",
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
    | Public Blade API
    |--------------------------------------------------------------------------
    */

    "api" => [
        "usage_level" => "public",
        "usage_context" =>
            "Use x-patterns.key-value-display for compact read-only facts such as account details, settings summaries, security states, metadata groups, and review facts. Use x-ui.structured-list for row/column comparison and x-ui.contained-list for repeated resource/settings rows with actions.",

        "props" => [
            [
                "name" => "items",
                "type" => "array|iterable",
                "required" => false,
                "default" => [],
                "values" => [],
                "description" =>
                    "List of key/value items. Each item may include label, title, value, description, helperText, meta, status, statusType/status_type, span, and visible.",
            ],
            [
                "name" => "columns",
                "type" => "int|string",
                "required" => false,
                "default" => 2,
                "values" => [1, 2, 3, 4],
                "description" =>
                    "Responsive column count for the value display. Values outside 1-4 fall back to 2.",
            ],
            [
                "name" => "emptyText",
                "type" => "string",
                "required" => false,
                "default" => "No details available.",
                "values" => [],
                "description" =>
                    "Empty state copy rendered when no visible items are supplied. In Blade, pass as empty-text.",
            ],
            [
                "name" => "emptyValue",
                "type" => "string|HtmlString",
                "required" => false,
                "default" => "—",
                "values" => [],
                "description" =>
                    "Fallback value rendered when an item value is empty. In Blade, pass as empty-value.",
            ],
            [
                "name" => "compact",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Reduces grid gap for denser metadata displays.",
            ],
        ],

        "item_shape" => [
            [
                "name" => "label",
                "type" => "string|HtmlString",
                "required" => true,
                "description" =>
                    "The key or term for the displayed value. title is accepted as a fallback.",
            ],
            [
                "name" => "value",
                "type" => "string|HtmlString|scalar|array|null",
                "required" => false,
                "description" =>
                    "The displayed value. Empty values fall back to emptyValue.",
            ],
            [
                "name" => "description",
                "type" => "string|HtmlString|null",
                "required" => false,
                "description" =>
                    "Optional supporting text below the value. helperText is accepted as a fallback.",
            ],
            [
                "name" => "meta",
                "type" => "string|HtmlString|null",
                "required" => false,
                "description" => "Optional compact metadata below the value.",
            ],
            [
                "name" => "status",
                "type" => "string|null",
                "required" => false,
                "description" =>
                    "Optional status tag rendered next to the value.",
            ],
            [
                "name" => "statusType",
                "type" => "string|null",
                "required" => false,
                "description" =>
                    "Tag type used when status is present. status_type is accepted as a fallback.",
            ],
            [
                "name" => "span",
                "type" => "int|string|null",
                "required" => false,
                "values" => [1, 2, 3, 4, "full"],
                "description" =>
                    "Optional item column span. full spans all resolved columns.",
            ],
            [
                "name" => "visible",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "description" => "Controls whether the item is rendered.",
            ],
        ],

        "slots" => [],

        "events" => [],

        "data_attributes" => [
            [
                "name" => "data-ui-pattern",
                "required" => true,
                "value" => "key-value-display",
                "description" => "Generated pattern identity marker.",
            ],
            [
                "name" => "data-ui-key-value-display",
                "required" => true,
                "description" => "Generated root key/value display marker.",
            ],
            [
                "name" => "data-ui-key-value-display-columns",
                "required" => true,
                "description" => "Generated resolved columns marker.",
            ],
            [
                "name" => "data-ui-key-value-display-compact",
                "required" => true,
                "description" => "Generated compact state marker.",
            ],
            [
                "name" => "data-ui-key-value-display-item-count",
                "required" => false,
                "description" =>
                    "Generated item count marker when items render.",
            ],
            [
                "name" => "data-ui-key-value-display-empty",
                "required" => false,
                "description" =>
                    "Generated empty-state marker when no items render.",
            ],
            [
                "name" => "data-ui-key-value-display-item",
                "required" => false,
                "description" =>
                    "Generated item marker for each rendered key/value item.",
            ],
            [
                "name" => "data-ui-key-value-display-item-span",
                "required" => false,
                "description" => "Generated resolved item span marker.",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subcomponents
    |--------------------------------------------------------------------------
    */

    "subcomponents" => [],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    "class_contract" => [
        "root" => "ui-pattern-key-value-display",
        "required" => [
            "ui-pattern-key-value-display",
            "ui-pattern-key-value-item",
            "ui-pattern-key-value-label",
            "ui-pattern-key-value-value",
        ],
        "optional" => [
            "ui-pattern-key-value-display--compact",
            "ui-pattern-key-value-display-empty",
            "ui-pattern-key-value-value-text",
            "ui-pattern-key-value-status",
            "ui-pattern-key-value-meta",
            "ui-pattern-key-value-description",
        ],
        "internal" => [],
        "deprecated" => [
            "feature-local key/value grids",
            "ad hoc dl/dt/dd utility clusters for settings facts",
            "x-ui.structured-list used for simple profile facts without row/column comparison",
            "x-ui.contained-list used for non-repeated key/value facts",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Variants
    |--------------------------------------------------------------------------
    */

    "variants" => [
        "default" => [
            "label" => "Default",
            "api" => [],
            "class" => "ui-pattern-key-value-display",
            "description" => "Default compact key/value fact display.",
        ],
        "compact" => [
            "label" => "Compact",
            "api" => ["compact" => true],
            "class" => "ui-pattern-key-value-display--compact",
            "description" =>
                "Denser key/value display for metadata-heavy contexts.",
        ],
        "with-status" => [
            "label" => "With status",
            "api" => [
                "items" => [
                    [
                        "label" => "MFA",
                        "value" => "Enabled",
                        "status" => "Protected",
                        "statusType" => "green",
                    ],
                ],
            ],
            "class" => "ui-pattern-key-value-status",
            "description" =>
                "Key/value item with an inline read-only tag status.",
        ],
        "empty" => [
            "label" => "Empty",
            "api" => ["items" => []],
            "class" => "ui-pattern-key-value-display-empty",
            "description" =>
                "Empty state when no visible key/value items are supplied.",
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
        "default" => [
            "label" => "Default",
            "required" => true,
            "description" => "One or more key/value items are rendered.",
        ],
        "empty" => [
            "label" => "Empty",
            "required" => false,
            "description" => "No visible key/value items are available.",
        ],
        "compact" => [
            "label" => "Compact",
            "required" => false,
            "description" => "Compact density is active.",
        ],
        "with-description" => [
            "label" => "With description",
            "required" => false,
            "description" =>
                "At least one item has supporting description text.",
        ],
        "with-meta" => [
            "label" => "With meta",
            "required" => false,
            "description" => "At least one item has metadata text.",
        ],
        "with-status" => [
            "label" => "With status",
            "required" => false,
            "description" =>
                "At least one item has an inline read-only status tag.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    "rules" => [
        "selection" => [
            "Use Key/value Display for compact read-only facts.",
            "Use Structured List when the content needs row and column headers.",
            "Use Contained List when the content is a repeated list of resources, methods, devices, emails, activity rows, or settings rows with actions.",
            "Use Data Table when sorting, filtering, pagination, row expansion, or complex tabular review is required.",
        ],
        "content" => [
            "Labels should be short nouns or noun phrases.",
            "Values should be concise and scannable.",
            "Do not use long paragraphs as values; move long support copy to description.",
            "Use status only when the state affects understanding or workflow.",
        ],
        "accessibility" => [
            "The pattern must preserve semantic dl/dt/dd relationships.",
            "Do not rely on column position to communicate meaning.",
            "Status tags must have clear text labels and must not rely on color alone.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => ["ui-pattern-key-value"],
        "component_tokens" => [
            "key-value-display",
            "description-list",
            "metadata",
            "settings-summary",
            "profile-summary",
        ],
        "deprecated" => [
            "feature-local key/value displays",
            "raw profile details grids",
            "raw settings summary utility clusters",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "build_tier" => 6,
        "depends_on" => ["color", "themes", "spacing", "typography", "tag"],
        "uses" => [
            "icons" => [],
            "components" => ["x-ui.tag"],
            "patterns" => [],
            "js_initializers" => [],
        ],
        "blocked_by" => [],
        "blocks" => [
            "account-panels",
            "settings-panels",
            "profile-summaries",
            "security-summaries",
            "review-summaries",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    "source" => [
        "blade" => [
            "resources/views/components/patterns/key-value-display/index.blade.php",
        ],
        "css" => [],
        "js" => [],
        "tokens" => [],
        "contract" => [
            "resources/views/components/patterns/key-value-display/contract.php",
        ],
        "docs" => [],
        "examples" => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Examples
    |--------------------------------------------------------------------------
    */

    "examples" => [
        "required_live_examples" => [
            "account-facts",
            "security-status",
            "with-status",
            "empty",
        ],

        "items" => [
            "account-facts" => [
                "label" => "Account facts",
                "description" => "Profile-style read-only account facts.",
                "view" => null,
                "code" =>
                    '<x-patterns.key-value-display :items="[[\'label\' => \'Display name\', \'value\' => \'Local Review User\']]" />',
                "review_state" => "needs-review",
            ],
            "security-status" => [
                "label" => "Security status",
                "description" =>
                    "Security settings summary with compact values.",
                "view" => null,
                "code" => null,
                "review_state" => "needs-review",
            ],
            "with-status" => [
                "label" => "With status",
                "description" => "Key/value item with inline status tag.",
                "view" => null,
                "code" => null,
                "review_state" => "needs-review",
            ],
            "empty" => [
                "label" => "Empty",
                "description" => "Empty-state display.",
                "view" => null,
                "code" => null,
                "review_state" => "needs-review",
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Usage
    |--------------------------------------------------------------------------
    */

    "usage" => [
        "purpose" =>
            "Standardize compact read-only fact presentation for profile, settings, security, and review surfaces.",
        "use_when" => [
            "A panel needs a small group of facts such as labels and values.",
            "Content is read-only and does not need row actions.",
            "A table-backed structured list would be too heavy.",
            "A repeated row list would overstate simple metadata.",
        ],
        "do_not_use_when" => [
            "The content needs row and column headers; use x-ui.structured-list.",
            "The content is a repeated resource or settings row list with actions; use x-ui.contained-list.",
            "The content needs sorting, filtering, pagination, selection, or row expansion; use x-ui.data-table.",
            "The content is editable; use form components instead.",
        ],
        "related_components" => [
            "x-ui.structured-list",
            "x-ui.contained-list",
            "x-ui.data-table",
            "x-ui.tag",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => ["Key/value Display is not keyboard interactive."],
        "aria" => [
            "The pattern uses semantic dl/dt/dd markup.",
            "ARIA labelling is owned by the surrounding section or panel.",
            "Status tags must expose text, not color alone.",
        ],
        "focus" => [
            "The pattern does not receive focus unless caller content introduces focusable elements, which should be avoided for this read-only pattern.",
        ],
        "screen_reader" => [
            "Terms and values must remain meaningful when read in source order.",
            "Labels should be concise and descriptive.",
            "Values should not rely on visual placement alone.",
        ],
        "review_state" => "needs-review",
    ],

    /*
    |--------------------------------------------------------------------------
    | Testing
    |--------------------------------------------------------------------------
    */

    "testing" => [
        "build_checks" => [
            "blade_exists" => true,
            "css_imported" => false,
            "js_initializer_required" => false,
            "js_initializer_registered" => false,
            "tokens_imported" => false,
            "contract_registered" => true,
            "examples_registered" => false,
        ],

        "manual_checks" => [
            "renders_in_light_theme",
            "renders_in_dark_theme",
            "renders_one_column",
            "renders_two_columns",
            "renders_three_columns",
            "renders_four_columns",
            "renders_empty_state",
            "renders_status_tag",
            "semantic_description_list_reviewed",
        ],

        "automated_checks" => [
            "component_renders",
            "emits_data_markers",
            "uses_dl_dt_dd_markup",
            "filters_hidden_items",
            "escapes_string_values",
            "renders_html_string_values",
        ],

        "visual_review" => [
            "required" => true,
            "states" => ["default", "compact", "with-status", "empty"],
            "themes" => ["light", "dark"],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Review
    |--------------------------------------------------------------------------
    */

    "review" => [
        "overall_state" => "scaffolded",
        "blocked_by" => [],
        "last_reviewed_at" => null,
        "reviewed_by" => null,

        "scopes" => [
            "blade_api" => "implemented",
            "css_contract" => "utility-backed",
            "js_behavior" => "not-applicable",
            "examples" => "not-started",
            "accessibility" => "needs-review",
            "visual_parity" => "needs-review",
            "docs_copy" => "not-started",
            "tokens" => "not-applicable",
        ],

        "notes" => [
            "Key/value Display is an app-owned pattern, not a direct Carbon base component.",
            "The closest Carbon base reference is Structured List, but this pattern intentionally avoids native table markup for compact fact groups.",
            "Contained List remains the better fit for repeated settings/resource rows with actions.",
            "Add dedicated CSS later only if the utility-backed first pass is insufficient.",
        ],
    ],
]);

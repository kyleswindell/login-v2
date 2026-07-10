<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/forms/page/contract.php
| Purpose: Form Page Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Form Page Pattern API that can be called
| from Blade, validated by tooling, and consumed by app layouts or other
| Patterns.
|
| Form Page owns dedicated page form anatomy. It composes x-ui.form for native
| form mechanics and leaves fields, validation, persistence, authorization,
| and action semantics to child components, controllers, and Common Actions.
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
        "slug" => "forms-page",
        "label" => "Form Page",
        "component" => "x-patterns.forms.page",
        "api_layer" => "Pattern API",
        "summary" =>
            "Dedicated page form pattern for complex, lengthier, or settings-style form workflows.",
        "group" => "Form Patterns",
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
        "nav_label" => "Form Page",
        "nav_group" => "Forms",
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
            "Use x-patterns.forms.page for dedicated page forms such as settings pages, create/edit pages, setup flows, and longer form workflows that need standardized page title, description, body, status, actions, and footer anatomy.",

        "props" => [
            [
                "name" => "title",
                "type" => "string|HtmlString",
                "required" => true,
                "default" => null,
                "values" => [],
                "description" =>
                    "Visible page title. Rendered as the page form heading and used by the root aria-labelledby relationship.",
            ],
            [
                "name" => "description",
                "type" => "string|HtmlString|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional page-level description rendered below the title.",
            ],
            [
                "name" => "action",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" => "Native form action forwarded to x-ui.form.",
            ],
            [
                "name" => "method",
                "type" => "string",
                "required" => false,
                "default" => "POST",
                "values" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
                "description" =>
                    "Requested form method forwarded to x-ui.form. PUT, PATCH, and DELETE are handled by the Form component using Laravel method spoofing.",
            ],
            [
                "name" => "csrf",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "values" => [true, false],
                "description" =>
                    "Controls whether x-ui.form emits a CSRF token for non-GET forms.",
            ],
            [
                "name" => "titleId",
                "type" => "string",
                "required" => false,
                "default" => "form-page-title",
                "values" => [],
                "description" =>
                    "ID applied to the visible title and referenced by the root section aria-labelledby. In Blade, pass as title-id.",
            ],
            [
                "name" => "width",
                "type" => "string",
                "required" => false,
                "default" => "lg",
                "values" => ["sm", "md", "lg", "xl", "full"],
                "description" => "Dedicated page content width treatment.",
            ],
            [
                "name" => "fluid",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "values" => [true, false],
                "description" =>
                    "Applies the fluid form treatment to the composed x-ui.form wrapper.",
            ],
            [
                "name" => "novalidate",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "values" => [true, false],
                "description" =>
                    "Controls the native novalidate attribute on the composed form. Server-side validation and child field validation remain owned outside this pattern.",
            ],
            [
                "name" => "showHeader",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "values" => [true, false],
                "description" =>
                    "Controls whether the pattern renders its internal form-page heading. Set false when the routed app page uses the layout-owned page header.",
            ],
        ],

        "slots" => [
            [
                "name" => "default",
                "required" => true,
                "description" =>
                    "Form body content such as field components, field groups, explanatory copy, settings sections, or form-specific composition.",
            ],
            [
                "name" => "actions",
                "required" => false,
                "description" =>
                    "Optional form action region. Prefer x-patterns.forms.actions with x-ui.button-set and x-ui.button children.",
            ],
            [
                "name" => "status",
                "required" => false,
                "description" =>
                    "Optional page-level status or feedback region rendered below the heading area.",
            ],
            [
                "name" => "footer",
                "required" => false,
                "description" =>
                    "Optional footer/help region rendered after the form.",
            ],
        ],

        "events" => [],

        "data_attributes" => [
            [
                "name" => "data-ui-pattern",
                "required" => true,
                "value" => "forms.page",
                "description" => "Generated pattern identity marker.",
            ],
            [
                "name" => "data-ui-form-page",
                "required" => true,
                "description" => "Generated root form page marker.",
            ],
            [
                "name" => "data-ui-form-page-width",
                "required" => true,
                "description" =>
                    "Generated width marker. Emits sm, md, lg, xl, or full.",
            ],
            [
                "name" => "data-ui-form-page-fluid",
                "required" => true,
                "description" => "Generated fluid state marker.",
            ],
            [
                "name" => "data-ui-form-page-header",
                "required" => true,
                "description" => "Generated page header marker.",
            ],
            [
                "name" => "data-ui-form-page-status",
                "required" => false,
                "description" =>
                    "Generated status region marker when the status slot is supplied.",
            ],
            [
                "name" => "data-ui-form-page-form",
                "required" => true,
                "description" => "Generated composed form marker.",
            ],
            [
                "name" => "data-ui-form-page-body",
                "required" => true,
                "description" => "Generated form body marker.",
            ],
            [
                "name" => "data-ui-form-page-actions",
                "required" => false,
                "description" =>
                    "Generated actions region marker when the actions slot is supplied.",
            ],
            [
                "name" => "data-ui-form-page-footer",
                "required" => false,
                "description" =>
                    "Generated footer region marker when the footer slot is supplied.",
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
        "root" => "ui-form-page",
        "required" => [
            "ui-form-page",
            "ui-form-page__header",
            "ui-form-page__heading",
            "ui-form-page__title",
            "ui-form-page__form",
            "ui-form-page__body",
        ],
        "optional" => [
            "ui-form-page--width-sm",
            "ui-form-page--width-md",
            "ui-form-page--width-lg",
            "ui-form-page--width-xl",
            "ui-form-page--width-full",
            "ui-form-page__description",
            "ui-form-page__status",
            "ui-form-page__actions",
            "ui-form-page__footer",
            "ui-form--fluid",
        ],
        "internal" => [],
        "deprecated" => [
            "feature-local dedicated form page wrappers",
            "settings-specific form page shells that duplicate x-patterns.forms.page",
            "raw form page utility clusters where x-patterns.forms.page should own page anatomy",
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
            "class" => "ui-form-page",
            "description" =>
                "Default dedicated form page with title, body, and fluid form treatment.",
            "use_when" => [
                "A page owns a complete form workflow.",
                "The form is too important or lengthy to render as an inline card, dialog, or drawer.",
            ],
            "do_not_use_when" => [
                "The form is a small local input group that does not need page-level anatomy.",
            ],
        ],
        "width-sm" => [
            "label" => "Small width",
            "api" => [
                "width" => "sm",
            ],
            "class" => "ui-form-page--width-sm",
            "description" => "Narrow dedicated page form layout.",
        ],
        "width-md" => [
            "label" => "Medium width",
            "api" => [
                "width" => "md",
            ],
            "class" => "ui-form-page--width-md",
            "description" => "Medium dedicated page form layout.",
        ],
        "width-lg" => [
            "label" => "Large width",
            "api" => [
                "width" => "lg",
            ],
            "class" => "ui-form-page--width-lg",
            "description" => "Default large dedicated page form layout.",
        ],
        "width-xl" => [
            "label" => "Extra large width",
            "api" => [
                "width" => "xl",
            ],
            "class" => "ui-form-page--width-xl",
            "description" =>
                "Wider dedicated page form layout for longer or sectioned forms.",
        ],
        "width-full" => [
            "label" => "Full width",
            "api" => [
                "width" => "full",
            ],
            "class" => "ui-form-page--width-full",
            "description" => "Full-width dedicated page form layout.",
        ],
        "fluid" => [
            "label" => "Fluid",
            "api" => [
                "fluid" => true,
            ],
            "class" => "ui-form--fluid",
            "description" =>
                "Composed x-ui.form receives fluid form treatment.",
        ],
        "non-fluid" => [
            "label" => "Non-fluid",
            "api" => [
                "fluid" => false,
            ],
            "description" =>
                "Composed x-ui.form does not receive fluid form treatment.",
        ],
        "with-status" => [
            "label" => "With status",
            "api" => [
                "slot" => "status",
            ],
            "class" => "ui-form-page__status",
            "description" =>
                "Dedicated page form with a page-level status or feedback region.",
        ],
        "with-actions" => [
            "label" => "With actions",
            "api" => [
                "slot" => "actions",
            ],
            "class" => "ui-form-page__actions",
            "description" =>
                "Dedicated page form with an explicit action region.",
        ],
        "with-footer" => [
            "label" => "With footer",
            "api" => [
                "slot" => "footer",
            ],
            "class" => "ui-form-page__footer",
            "description" =>
                "Dedicated page form with a post-form help or footer region.",
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
            "description" =>
                "Dedicated page form renders title, form body, and native form wrapper.",
        ],
        "with-description" => [
            "label" => "With description",
            "required" => false,
            "description" => "Page description is present below the title.",
        ],
        "with-status" => [
            "label" => "With status",
            "required" => false,
            "description" => "Status slot is present.",
        ],
        "with-actions" => [
            "label" => "With actions",
            "required" => false,
            "description" => "Actions slot is present.",
        ],
        "with-footer" => [
            "label" => "With footer",
            "required" => false,
            "description" => "Footer slot is present.",
        ],
        "non-fluid" => [
            "label" => "Non-fluid",
            "required" => false,
            "description" => "Fluid form treatment is disabled.",
        ],
        "focus-visible" => [
            "label" => "Focus-visible",
            "required" => true,
            "description" =>
                "Visible focus belongs to slotted child controls and actions.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pattern Rules
    |--------------------------------------------------------------------------
    */

    "rules" => [
        "variant_selection" => [
            "Use Form Page for dedicated page forms, especially complex, lengthier, multistep, create/edit, setup, or settings workflows.",
            "Use a future Form Dialog pattern for critical, infrequent, focused forms with fewer than five inputs.",
            "Use a future Form Side Panel pattern for repeated editing where users need to reference the affected page or table context.",
            "Do not use Form Page for small inline filters, search forms, newsletter forms, or local control clusters that do not need page-level anatomy.",
        ],
        "anatomy" => [
            "The root section must contain a visible page title.",
            "The page title must label the root section through aria-labelledby.",
            "The form body must remain inside the composed x-ui.form wrapper.",
            "The actions region must remain visually and structurally connected to the submitted form body.",
            "The footer region must be supplemental and must not contain the primary submit action.",
        ],
        "composition" => [
            "Compose x-ui.form for native form method, action, CSRF, and method spoofing behavior.",
            "Compose field components for labels, helper text, validation text, and field-level ARIA.",
            "Compose x-ui.form-group for native fieldset and legend grouping when controls are related.",
            "Prefer x-patterns.forms.actions in the actions slot for submit, save, cancel, reset, continue, and form-flow actions.",
            "Use x-ui.button-set inside form actions when layout width, alignment, or fluid treatment is needed.",
        ],
        "actions" => [
            "Primary submit-like actions should be supplied through the actions slot.",
            "Do not create multiple unrelated action regions for one form.",
            "Cancel, reset, destructive, and secondary actions must remain semantically distinct from submit actions.",
            "Loading, duplicate-submission protection, and action hierarchy belong to Common Actions or the consuming flow.",
        ],
        "validation" => [
            "Field-level validation rendering belongs to field components.",
            "Validation summary, error focus, and recovery flow belong to the consuming page/controller flow until a validation summary pattern exists.",
            "The novalidate default supports server-driven validation, but callers may opt into native validation by setting novalidate to false.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => ["ui-form-page", "ui-form"],
        "component_tokens" => [
            "forms-page",
            "dedicated-form-page",
            "form-pattern",
            "form-layout",
            "settings-form",
            "create-edit-form",
        ],
        "deprecated" => [
            "feature-local settings form shells",
            "feature-local create/edit form page wrappers",
            "duplicated dedicated form page anatomy",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "build_tier" => 6,
        "depends_on" => ["form", "spacing", "layout", "typography"],
        "uses" => [
            "icons" => [],
            "components" => ["x-ui.form"],
            "patterns" => [],
            "js_initializers" => [],
        ],
        "blocked_by" => [],
        "blocks" => [
            "settings-forms",
            "create-edit-flows",
            "setup-flows",
            "admin-forms",
            "form-actions",
            "form-dialog-pattern",
            "form-side-panel-pattern",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    "source" => [
        "blade" => [
            "resources/views/components/patterns/forms/page/index.blade.php",
        ],
        "css" => [],
        "js" => [],
        "tokens" => [],
        "contract" => [
            "resources/views/components/patterns/forms/page/contract.php",
        ],
        "docs" => ["docs/02-standards/ui/patterns/forms/page.md"],
        "examples" => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Examples
    |--------------------------------------------------------------------------
    */

    "examples" => [
        "required_live_examples" => [
            "basic-form-page",
            "settings-form-page",
            "with-status",
            "with-actions",
            "with-footer",
        ],

        "items" => [
            "basic-form-page" => [
                "label" => "Basic form page",
                "description" =>
                    "Dedicated form page with title, description, fields, and actions.",
                "view" => null,
                "code" =>
                    '<x-patterns.forms.page title="Profile settings" :action="route(\'settings.profile.update\')" method="PATCH">...</x-patterns.forms.page>',
                "review_state" => "needs-review",
            ],
            "settings-form-page" => [
                "label" => "Settings form page",
                "description" =>
                    "Dedicated form page used for a settings workflow.",
                "view" => null,
                "code" => null,
                "review_state" => "needs-review",
            ],
            "with-status" => [
                "label" => "With status",
                "description" =>
                    "Dedicated form page with a page-level status slot.",
                "view" => null,
                "code" => null,
                "review_state" => "needs-review",
            ],
            "with-actions" => [
                "label" => "With actions",
                "description" =>
                    "Dedicated form page with Common Actions supplied through the actions slot.",
                "view" => null,
                "code" => null,
                "review_state" => "needs-review",
            ],
            "with-footer" => [
                "label" => "With footer",
                "description" =>
                    "Dedicated form page with supplemental footer/help content.",
                "view" => null,
                "code" => null,
                "review_state" => "needs-review",
            ],
        ],

        "install_snippets" => [
            "settings-form-page" => <<<'BLADE'
            <x-patterns.forms.page
                title="Security settings"
                description="Manage sign-in and account protection."
                :action="route('settings.security.update')"
                method="PATCH"
            >
                {{-- Fields --}}

                <x-slot:actions>
                    <x-patterns.forms.actions label="Security settings actions">
                        <x-ui.button-set fluid width="half" align="end">
                            <x-ui.button type="submit" kind="primary">
                                Save changes
                            </x-ui.button>
                        </x-ui.button-set>
                    </x-patterns.forms.actions>
                </x-slot:actions>
            </x-patterns.forms.page>
            BLADE
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
            "Standardize dedicated page form anatomy for settings, create/edit, setup, and other longer form workflows.",
        "use_when" => [
            "A full page is dedicated to collecting or updating user input.",
            "The form is complex, lengthy, multistep, or benefits from page-level title and description context.",
            "A settings module needs consistent page-level form structure.",
            "A create/edit workflow needs consistent body, status, action, and footer placement.",
        ],
        "do_not_use_when" => [
            "Only the native form wrapper is needed; use x-ui.form directly.",
            "The form belongs in a dialog because it is critical, infrequent, focused, and has fewer than five inputs.",
            "The form belongs in a side panel because repeated editing requires nearby page or table context.",
            "The UI is a small inline filter/search form or local control group.",
            "The workflow does not submit user input.",
        ],
        "related_components" => [
            "x-ui.form",
            "x-ui.form-item",
            "x-ui.form-group",
            "x-ui.form-label",
            "x-ui.button",
            "x-ui.button-set",
            "x-patterns.forms.actions",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "The composed form must preserve native form submission behavior.",
            "Keyboard behavior belongs to slotted child fields and actions.",
            "The pattern must not add custom keyboard handling.",
        ],
        "aria" => [
            "The root section must be labelled by the visible title through aria-labelledby.",
            "The titleId prop must resolve to a unique ID when more than one Form Page appears on a document.",
            "The composed x-ui.form owns native form semantics.",
            "Field components must own field-level labels, descriptions, invalid states, and error messaging.",
            "Status slot content must provide appropriate live-region behavior when used for asynchronous or post-submit feedback.",
        ],
        "focus" => [
            "The pattern does not manage focus by default.",
            "Validation recovery should move focus to an error summary or first invalid field when the consuming flow implements that behavior.",
            "Submit, cancel, and reset controls must preserve visible focus through their child button/link components.",
        ],
        "screen_reader" => [
            "The title and description should describe the form purpose before users encounter fields.",
            "Action labels must clearly describe form outcomes.",
            "Do not rely on visual layout alone to communicate required fields, validation state, destructive behavior, or post-submit feedback.",
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
            "renders_with_title_and_description",
            "renders_with_status_slot",
            "renders_with_actions_slot",
            "renders_with_footer_slot",
            "renders_with_patch_method_spoofing",
            "accessibility_expectations_reviewed",
        ],

        "automated_checks" => [
            "component_renders",
            "root_section_has_aria_labelledby",
            "title_id_matches_root_aria_labelledby",
            "composes_x_ui_form",
            "passes_unknown_attributes_to_form",
            "emits_data_markers",
            "does_not_require_js_initializer",
        ],

        "visual_review" => [
            "required" => true,
            "states" => [
                "default",
                "with-description",
                "with-status",
                "with-actions",
                "with-footer",
                "non-fluid",
            ],
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
            "css_contract" => "not-applicable",
            "js_behavior" => "not-applicable",
            "examples" => "not-started",
            "accessibility" => "needs-review",
            "visual_parity" => "needs-review",
            "docs_copy" => "not-started",
            "tokens" => "not-applicable",
        ],

        "notes" => [
            "No dedicated pattern CSS is required for the first pass because the Blade composes existing layout utilities and x-ui.form.",
            "Add resources/css/patterns/forms.css only after ui-form-page selectors need durable styling beyond utility composition.",
            "Form Page is the first dedicated Forms pattern variant. Form Dialog and Form Side Panel should be separate sibling patterns when needed.",
            "Settings pages should start as Form Page usages unless settings-specific navigation, contribution metadata, or mixed table/form layout behavior proves a separate Settings Page pattern is needed.",
        ],
    ],
]);

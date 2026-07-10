<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/patterns/auth/challenge-form/contract.php
| Purpose: Auth Challenge Form Pattern public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Auth Challenge Form Pattern API that can
| be called from Blade, validated by tooling, and consumed by auth views.
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
        "slug" => "auth-challenge-form",
        "label" => "Auth Challenge Form",
        "component" => "x-patterns.auth.challenge-form",
        "summary" =>
            "Shared auth challenge layout pattern for login identifier, password, MFA, and step-up verification forms.",
        "group" => "Auth Patterns",
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
        "nav_label" => "Auth Challenge Form",
        "nav_group" => "Auth Patterns",
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
    | Public Blade API
    |--------------------------------------------------------------------------
    */

    "api" => [
        "usage_level" => "public",
        "usage_context" =>
            "Use x-patterns.auth.challenge-form for Login 2.0 auth challenge screens that share the centered auth shell, panel, header, alerts, form wrapper, action area, and help footer.",

        "props" => [
            [
                "name" => "title",
                "type" => "string",
                "required" => true,
                "default" => null,
                "values" => [],
                "description" => "Visible page heading for the auth challenge.",
            ],
            [
                "name" => "description",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional explanatory text rendered below the challenge title.",
            ],
            [
                "name" => "action",
                "type" => "string",
                "required" => true,
                "default" => null,
                "values" => [],
                "description" => "Form action URL for the auth challenge POST.",
            ],
            [
                "name" => "method",
                "type" => "string",
                "required" => false,
                "default" => "POST",
                "values" => ["POST"],
                "description" =>
                    "HTTP form method. Auth challenge forms currently use POST.",
            ],
            [
                "name" => "marker",
                "type" => "string|null",
                "required" => false,
                "default" => "Login App 2.0",
                "values" => [],
                "description" =>
                    "Optional eyebrow text rendered above the challenge title.",
            ],
            [
                "name" => "titleId",
                "type" => "string",
                "required" => false,
                "default" => "auth-title",
                "values" => [],
                "description" =>
                    "ID used by the title and shell aria-labelledby relationship. In Blade, pass as title-id.",
            ],
            [
                "name" => "context",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional account or user context displayed in the auth header.",
            ],
            [
                "name" => "contextLabel",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional label for the context value. In Blade, pass as context-label.",
            ],
            [
                "name" => "changeHref",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional link target for changing the displayed context. In Blade, pass as change-href.",
            ],
            [
                "name" => "changeLabel",
                "type" => "string",
                "required" => false,
                "default" => "Change",
                "values" => [],
                "description" =>
                    "Visible label for the context change link. In Blade, pass as change-label.",
            ],
            [
                "name" => "includeTimezone",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "When true, emits the hidden browser timezone field and temporary timezone initializer. In Blade, pass as include-timezone.",
            ],
            [
                "name" => "showAlerts",
                "type" => "bool",
                "required" => false,
                "default" => true,
                "values" => [true, false],
                "description" =>
                    "When true, renders auth::partials.alerts unless the alerts slot is provided. In Blade, pass as show-alerts.",
            ],
            [
                "name" => "helpText",
                "type" => "string|null",
                "required" => false,
                "default" => "Need help?",
                "values" => [],
                "description" =>
                    "Text rendered before the help link below the auth panel. In Blade, pass as help-text.",
            ],
            [
                "name" => "helpLinkText",
                "type" => "string|null",
                "required" => false,
                "default" => "Contact Support",
                "values" => [],
                "description" =>
                    "Visible text for the help link. In Blade, pass as help-link-text.",
            ],
            [
                "name" => "helpHref",
                "type" => "string|null",
                "required" => false,
                "default" => null,
                "values" => [],
                "description" =>
                    "Optional help link target. When omitted, the help link renders as unavailable. In Blade, pass as help-href.",
            ],
            [
                "name" => "helpCentered",
                "type" => "bool",
                "required" => false,
                "default" => false,
                "values" => [true, false],
                "description" =>
                    "Centers the help footer text when true. In Blade, pass as help-centered.",
            ],
        ],

        "slots" => [
            [
                "name" => "default",
                "required" => true,
                "description" =>
                    "Auth challenge body content, usually hidden inputs, field controls, helper text, and challenge-specific context.",
            ],
            [
                "name" => "actions",
                "required" => false,
                "description" =>
                    "Optional action area, usually an x-ui.button-set containing primary and secondary auth actions.",
            ],
            [
                "name" => "alerts",
                "required" => false,
                "description" =>
                    "Optional replacement for the default auth::partials.alerts output.",
            ],
        ],

        "events" => [],

        "data_attributes" => [
            [
                "name" => "data-ui-pattern",
                "required" => true,
                "value" => "auth.challenge-form",
                "description" =>
                    "Generated pattern marker on the root auth shell.",
            ],
            [
                "name" => "data-auth-shell",
                "required" => true,
                "description" => "Generated root auth shell marker.",
            ],
            [
                "name" => "data-auth-panel",
                "required" => true,
                "description" => "Generated auth panel marker.",
            ],
            [
                "name" => "data-auth-shell-header",
                "required" => true,
                "description" => "Generated auth header marker.",
            ],
            [
                "name" => "data-auth-timezone-field",
                "required" => false,
                "description" =>
                    "Generated hidden timezone field marker when includeTimezone is true.",
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
        "root" => null,
        "required" => [],
        "optional" => [
            "mx-auto",
            "max-w-md",
            "ui-form--fluid",
            "ui-platform-text-muted",
            "ui-platform-text-strong",
            "ui-platform-border",
        ],
        "internal" => ["temporary auth layout utility classes"],
        "deprecated" => [
            "duplicated auth shell partial markup",
            "inline custom remember identifier toggletip partial markup",
            "feature-local duplicated auth shell markup",
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
            "class" => null,
            "description" =>
                "Centered auth challenge shell with header, default alerts, body slot, optional actions slot, and help footer.",
        ],
        "with-context" => [
            "label" => "With context",
            "api" => [
                "context" => "user@example.com",
                "contextLabel" => "User ID",
            ],
            "class" => null,
            "description" =>
                "Auth challenge shell with an account or user context region in the header.",
        ],
        "with-change-link" => [
            "label" => "With change link",
            "api" => [
                "context" => "user@example.com",
                "changeHref" => "/login",
            ],
            "class" => null,
            "description" =>
                "Auth context region with a link for changing the current identifier or account context.",
        ],
        "with-timezone" => [
            "label" => "With timezone",
            "api" => ["includeTimezone" => true],
            "class" => null,
            "description" =>
                "Auth challenge form that includes the browser timezone hidden field.",
        ],
        "custom-alerts" => [
            "label" => "Custom alerts",
            "api" => [],
            "class" => null,
            "description" =>
                "Auth challenge form with the alerts slot replacing the default auth::partials.alerts output.",
        ],
        "centered-help" => [
            "label" => "Centered help",
            "api" => ["helpCentered" => true],
            "class" => null,
            "description" =>
                "Auth challenge form with centered help footer copy.",
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
            "description" => "Default auth challenge form state.",
        ],
        "success-alert" => [
            "label" => "Success alert",
            "required" => false,
            "description" =>
                "Default alerts region renders a success notification when session status is present.",
        ],
        "warning-alert" => [
            "label" => "Warning alert",
            "required" => false,
            "description" =>
                "Default alerts region renders a warning notification when an auth notice is present.",
        ],
        "error-alert" => [
            "label" => "Error alert",
            "required" => true,
            "description" =>
                "Default alerts region renders an error notification when an auth error is present.",
        ],
        "session-expired" => [
            "label" => "Session expired",
            "required" => false,
            "description" =>
                "Default alerts region may render the auth session expired modal.",
        ],
        "with-context" => [
            "label" => "With context",
            "required" => false,
            "description" =>
                "Auth header renders account or identifier context.",
        ],
        "with-actions" => [
            "label" => "With actions",
            "required" => true,
            "description" =>
                "Actions slot renders the primary auth action area.",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    "tokens" => [
        "class_families" => [
            "ui-form",
            "ui-platform-text",
            "ui-platform-border",
        ],
        "component_tokens" => [
            "auth",
            "form",
            "layout",
            "spacing",
            "typography",
            "action-area",
        ],
        "deprecated" => [
            "duplicated auth shell utility clusters",
            "inline custom toggletip markup in auth partials",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    "dependencies" => [
        "build_tier" => 6,
        "depends_on" => [
            "button",
            "button-set",
            "checkbox",
            "link",
            "modal",
            "notification",
            "password-input",
            "text-input",
            "toggletip",
        ],
        "uses" => [
            "icons" => [],
            "components" => [
                "x-ui.button",
                "x-ui.button-set",
                "x-ui.checkbox",
                "x-ui.link",
                "x-ui.modal",
                "x-ui.notification.inline",
                "x-ui.password-input",
                "x-ui.text-input",
                "x-ui.toggletip",
            ],
            "partials" => ["auth::partials.alerts"],
            "js_initializers" => [],
        ],
        "blocked_by" => [
            "Shared auth timezone initializer is not yet extracted from inline script.",
        ],
        "blocks" => [
            "auth login identifier view cleanup",
            "auth password challenge view cleanup",
            "auth MFA challenge view cleanup",
            "auth MFA step-up view cleanup",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    "source" => [
        "blade" => [
            "resources/views/components/patterns/auth/challenge-form/index.blade.php",
        ],
        "css" => [],
        "js" => [],
        "tokens" => [],
        "contract" => [
            "resources/views/components/patterns/auth/challenge-form/contract.php",
        ],
        "docs" => ["docs/02-standards/ui/patterns/auth/challenge-form.md"],
        "examples" => [
            "resources/views/components/patterns/auth/challenge-form/examples",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Examples
    |--------------------------------------------------------------------------
    */

    "examples" => [
        "required_live_examples" => [
            "identifier-step",
            "password-step",
            "mfa-challenge",
            "mfa-step-up",
            "custom-alerts",
            "with-context",
        ],

        "items" => [
            "identifier-step" => [
                "label" => "Identifier step",
                "description" =>
                    "Login identifier challenge with remembered user ID option and half-width primary action.",
                "view" => null,
                "code" =>
                    '<x-patterns.auth.challenge-form title="Log in" description="Enter your user ID to continue." :action="route(\'login.identify\')" include-timezone>...</x-patterns.auth.challenge-form>',
                "review_state" => "needs-review",
            ],
            "password-step" => [
                "label" => "Password step",
                "description" =>
                    "Password challenge with current identifier context and primary action.",
                "view" => null,
                "code" =>
                    '<x-patterns.auth.challenge-form title="Log in" description="Enter your password to finish signing in." :action="route(\'login.password.store\')" include-timezone>...</x-patterns.auth.challenge-form>',
                "review_state" => "needs-review",
            ],
            "mfa-challenge" => [
                "label" => "MFA challenge",
                "description" =>
                    "Authenticator code challenge with account context and full-width fluid action row.",
                "view" => null,
                "code" =>
                    '<x-patterns.auth.challenge-form title="Authentication" description="Enter the 6-digit code generated by your authenticator app." :action="route(\'mfa.challenge.verify\')">...</x-patterns.auth.challenge-form>',
                "review_state" => "needs-review",
            ],
            "mfa-step-up" => [
                "label" => "MFA step-up",
                "description" =>
                    "Security-sensitive MFA verification challenge with context and full-width fluid action row.",
                "view" => null,
                "code" =>
                    '<x-patterns.auth.challenge-form title="Verify MFA" description="Confirm MFA before continuing with this security-sensitive action." :action="route(\'mfa.step-up.verify\')">...</x-patterns.auth.challenge-form>',
                "review_state" => "needs-review",
            ],
            "custom-alerts" => [
                "label" => "Custom alerts",
                "description" =>
                    "Challenge form with alerts supplied through the alerts slot.",
                "view" => null,
                "code" => "<x-slot:alerts>...</x-slot:alerts>",
                "review_state" => "needs-review",
            ],
            "with-context" => [
                "label" => "With context",
                "description" =>
                    "Challenge form displaying current account context in the header.",
                "view" => null,
                "code" =>
                    '<x-patterns.auth.challenge-form context="user@example.com" context-label="Signing in as" ... />',
                "review_state" => "needs-review",
            ],
        ],

        "install_snippets" => [
            "basic" =>
                '<x-patterns.auth.challenge-form title="Log in" description="Enter your user ID to continue." :action="route(\'login.identify\')">...</x-patterns.auth.challenge-form>',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Usage
    |--------------------------------------------------------------------------
    */

    "usage" => [
        "purpose" =>
            "Provide a single shared structure for Login 2.0 authentication challenge screens while keeping each challenge field and action explicit in the owning auth view.",
        "use_when" => [
            "A view is part of the Login 2.0 authentication flow.",
            "The screen presents one focused authentication challenge.",
            "The screen needs the shared auth panel, heading, alerts, action region, and help footer.",
            "The view should preserve explicit field ownership while removing repeated shell markup.",
        ],
        "do_not_use_when" => [
            "The page is not part of an authentication or security challenge flow.",
            "The screen is a dashboard, settings page, or general form composition.",
            "The flow requires a multi-panel wizard or shell layout outside the auth challenge surface.",
            "The form action, fields, or validation are unknown.",
        ],
        "related_components" => [
            "x-ui.button",
            "x-ui.button-set",
            "x-ui.checkbox",
            "x-ui.link",
            "x-ui.modal",
            "x-ui.notification.inline",
            "x-ui.password-input",
            "x-ui.text-input",
            "x-ui.toggletip",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    "accessibility" => [
        "keyboard" => [
            "Pattern shell is not keyboard interactive by itself.",
            "Keyboard behavior belongs to slotted form controls and action controls.",
            "Help link, context change link, toggletips, modals, and actions must remain keyboard reachable when rendered.",
        ],
        "aria" => [
            "Root shell must be labelled by the visible challenge title through aria-labelledby.",
            "The generated title ID must remain unique within the page.",
            "Alerts rendered by auth::partials.alerts must use the approved Notification and Modal accessibility contracts.",
            "The pattern must not add ARIA roles that conflict with native form semantics.",
        ],
        "focus" => [
            "The first challenge field may receive autofocus when provided by the owning view.",
            "The pattern must not reorder focus from the document order of slotted controls.",
            "Session-expired modal focus behavior belongs to x-ui.modal.",
        ],
        "screen_reader" => [
            "Title and description must clearly identify the current challenge.",
            "Context labels must identify account or user context when context is displayed.",
            "Help footer copy must not be the only recovery path for auth failures.",
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
            "identifier_step_visual_review",
            "password_step_visual_review",
            "mfa_challenge_visual_review",
            "mfa_step_up_visual_review",
            "session_expired_modal_review",
            "keyboard_navigation_review",
            "screen_reader_copy_review",
        ],

        "automated_checks" => [
            "pattern_renders_required_shell_markers",
            "pattern_renders_form_with_csrf",
            "pattern_renders_default_alerts_when_enabled",
            "pattern_allows_custom_alert_slot",
            "pattern_renders_timezone_field_when_enabled",
            "pattern_renders_context_when_supplied",
            "pattern_renders_actions_slot",
        ],

        "visual_review" => [
            "required" => true,
            "states" => [
                "default",
                "with-context",
                "with-alerts",
                "with-actions",
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
        "blocked_by" => [
            "Pattern Blade source must be installed.",
            "Auth views must be migrated to prove real usage.",
            "Shared auth timezone initializer should replace inline script before final approval.",
        ],
        "last_reviewed_at" => null,
        "reviewed_by" => null,

        "scopes" => [
            "blade_api" => "scaffolded",
            "css_contract" => "not-applicable",
            "js_behavior" => "blocked",
            "examples" => "not-started",
            "accessibility" => "needs-review",
            "visual_parity" => "needs-review",
            "docs_copy" => "not-started",
            "tokens" => "not-applicable",
        ],

        "notes" => [
            "This pattern replaces duplicated auth shell markup.",
            "auth::partials.alerts may remain as a shared auth feedback partial during the first migration pass.",
            "The legacy remember identifier toggletip partial has been removed after usage moved to x-ui.toggletip.",
        ],
    ],
]);

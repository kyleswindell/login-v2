<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: docs/09-reference/ui/ui-contract-template.php
| Purpose: Copyable baseline for Login App UI contract.php files.
|--------------------------------------------------------------------------
|
| Copy this shape into an owning UI surface folder, then replace placeholder
| values with source-proven Element, Component, or Pattern data. Runtime
| contracts declare durable API/config/review requirements. Owner-local
| reference.php files own rendered evidence visibility, navigation, tabs,
| rendered examples, and display relationships.
|
| Canonical standard: docs/02-standards/ui/contract-file.md
| Reference standard: docs/02-standards/ui/reference-file.md
| Reference template: docs/09-reference/ui/ui-reference-template.php
| Migration control: docs/02-standards/ui/element-contract-migration.md
|
*/

return [
    /*
    |--------------------------------------------------------------------------
    | Schema
    |--------------------------------------------------------------------------
    */

    'schema_version' => 1,

    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    |
    | Stable UI surface identity. These values define what the contract covers.
    |
    | This template uses Elements-first defaults because Foundation Elements are
    | the first stabilized contract category. Component and Pattern contracts
    | must replace group, type, component, and build tier values.
    |
    */

    'identity' => [
        'slug' => '',
        'label' => '',
        /*
        | Foundation Elements normally use null here unless the Element has a
        | real component API. Components use an installed x-ui.* tag.
        */
        'component' => null,
        'summary' => '',
        'group' => 'Foundation Elements',
        'type' => 'element',
    ],

    /*
    |--------------------------------------------------------------------------
    | Catalog
    |--------------------------------------------------------------------------
    |
    | Contract-side API disposition and owner relationship only. rendered evidence
    | visibility, overview cards, side navigation, tabs, sections, page copy,
    | and example grouping belong in owner-local reference.php files beside
    | this contract.
    |
    | visibility:
    | visible, hidden, subcomponent, variant, skeleton, internal, alias,
    | deprecated, planned
    |
    */

    'catalog' => [
        'visibility' => 'planned',
        'parent_component' => null,
        'nav_label' => '',
        'nav_group' => 'Foundation Elements',
        'sort_order' => null,
        'route' => null,
        /*
        | Simple Element contracts may declare legacy generic detail-page
        | metadata here while the Elements-first migration is in progress.
        | Migrated rendered evidence presentation belongs in owner-local
        | reference.php files.
        |
        | Do not duplicate owner-local reference.php tabs, page copy, section
        | order, or example grouping here when reference.php exists.
        */
        'detail_pages' => [
            /*
            'usage' => [
                'label' => 'Usage',
                'route_name' => null,
            ],
            */
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    |
    | Tracks maturity and where the UI surface may be used. A contract can
    | exist before the API is approved or strict enforcement is enabled.
    |
    | status:
    | legacy, legacy-compatible, provisional, approved, deprecated, internal,
    | planned
    |
    */

    'lifecycle' => [
        'status' => 'legacy-compatible',
        'api_approved' => false,
        'visual_approved' => false,
        'a11y_approved' => false,
        'allowed_in_app_layouts' => true,
        'allowed_in_patterns' => true,
        'replacement' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    |
    | Graduated enforcement. Use legacy-compatible defaults until the surface
    | has been reviewed and approved for strict public API enforcement.
    |
    | mode:
    | legacy, legacy-compatible, provisional, strict, deprecated, internal
    |
    | invalid_usage:
    | throw, warn, log, ignore
    |
    */

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'strict_props' => false,
        'strict_variants' => false,
        'strict_sizes' => false,
        'strict_states' => false,
        'strict_context' => false,
        'invalid_usage' => 'warn',
        'allow_unknown_attributes' => [
            'class',
            'id',
            'style',
            'aria-*',
            'data-*',
            'wire:*',
            'x-*',
            '@*',
            ':*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    |
    | Approved UI API. For Elements this may be token/source/utility guidance
    | rather than Blade props. App layouts should use approved APIs instead of
    | hand-writing implementation classes or raw values.
    |
    | Leave props, slots, events, and data attributes empty for token/source
    | Elements. Component contracts should add only source-proven values; do not
    | copy Button-specific or other component-specific values into this baseline.
    |
    | usage_level:
    | public, advanced, internal, deprecated, pattern-only
    |
    */

    'api' => [
        'usage_level' => 'public',
        'usage_context' => '',

        'props' => [
            /*
            [
                'name' => 'source-proven-prop',
                'type' => 'Needs confirmation',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Needs confirmation',
                'review_state' => 'needs-review',
            ],
            */
        ],

        'slots' => [
            /*
            [
                'name' => 'default',
                'required' => false,
                'description' => 'Needs confirmation',
                'review_state' => 'needs-review',
            ],
            */
        ],

        'events' => [],

        'data_attributes' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Subcomponents
    |--------------------------------------------------------------------------
    |
    | For component families, define child Blade APIs here instead of creating
    | separate visible rendered evidence pages for implementation-only surfaces.
    | Element contracts usually leave this empty.
    |
    */

    'subcomponents' => [
        /*
        'source-proven-child' => [
            'component' => 'Needs confirmation',
            'public_api' => false,
            'visibility' => 'internal',
            'usage_context' => 'Needs confirmation',
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | Required/optional classes emitted by Blade and expected by CSS/JS.
    |
    */

    'class_contract' => [
        'root' => null,
        'required' => [],
        'optional' => [],
        'internal' => [],
        'deprecated' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    |
    | Approved UI variants. Element contracts may leave this empty.
    |
    */

    'variants' => [
        /*
        'source-proven-variant' => [
            'label' => 'Needs confirmation',
            'api' => [],
            'class' => null,
            'description' => 'Needs confirmation',
            'use_when' => [],
            'do_not_use_when' => [],
            'review_state' => 'needs-review',
            'live_example' => null,
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    |
    | Approved sizes/densities. Element contracts may leave this empty.
    |
    */

    'sizes' => [
        /*
        'source-proven-size' => [
            'label' => 'Needs confirmation',
            'api' => [],
            'class' => null,
            'description' => 'Needs confirmation',
            'review_state' => 'needs-review',
            'live_example' => null,
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    |
    | Required and optional visual/interaction states.
    |
    */

    'states' => [
        /*
        'source-proven-state' => [
            'label' => 'Needs confirmation',
            'required' => true,
            'review_state' => 'needs-review',
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    |
    | build_tier:
    | 0 = foundation element
    | 1 = standalone primitive
    | 2 = simple composite
    | 3 = interactive composite
    | 4 = complex family
    | 5 = shell/app layout composition
    | 6 = pattern
    |
    */

    'dependencies' => [
        'build_tier' => 0,
        'depends_on' => [],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocked_by' => [],
        'blocks' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    |
    | Expected source files. Build/audit tooling can compare these paths against
    | the actual filesystem. source.examples declares an expected source root; it
    | does not prove example folders or Blade views exist.
    |
    */

    'source' => [
        'blade' => [],
        'css' => [],
        'js' => [],
        'tokens' => [],
        'contract' => [],
        'docs' => [],
        'examples' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Examples
    |--------------------------------------------------------------------------
    |
    | Required live examples and copyable install snippets. Declaring examples
    | here does not prove the folder, Blade view, or rendered evidence route exists;
    | scanners and tests must verify those separately.
    |
    | Element-style example requirements can be represented without Blade props.
    | Component-style example requirements should stay source-neutral until the
    | owning component contract provides confirmed props, slots, and views.
    |
    */

    'examples' => [
        'required_live_examples' => [],

        'items' => [
            /*
            'element-overview' => [
                'label' => 'Needs confirmation',
                'description' => 'Element example requirement; set view only after verifying the folder and Blade view.',
                'view' => null,
                'code' => null,
                'review_state' => 'needs-review',
            ],
            'component-basic' => [
                'label' => 'Needs confirmation',
                'description' => 'Component example requirement; keep source-neutral until the component contract is confirmed.',
                'view' => null,
                'code' => null,
                'review_state' => 'needs-review',
            ],
            */
        ],

        'install_snippets' => [
            /*
            'basic' => '',
            */
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Usage
    |--------------------------------------------------------------------------
    */

    'usage' => [
        'purpose' => '',
        'use_when' => [],
        'do_not_use_when' => [],
        'related_components' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [],
        'aria' => [],
        'focus' => [],
        'screen_reader' => [],
        'review_state' => 'not-started',
    ],

    /*
    |--------------------------------------------------------------------------
    | Testing
    |--------------------------------------------------------------------------
    |
    | Expected checks only. Actual pass/fail should be generated by tooling,
    | test output, active worklogs, or generated reports.
    |
    */

    'testing' => [
        'build_checks' => [
            'blade_exists' => false,
            'css_imported' => false,
            'js_initializer_required' => false,
            'js_initializer_registered' => false,
            'tokens_imported' => false,
            'contract_registered' => true,
            'examples_registered' => false,
        ],

        'manual_checks' => [
            'renders_in_light_theme',
            'renders_in_dark_theme',
            'manual_examples_reviewed',
            'accessibility_expectations_reviewed',
        ],

        'automated_checks' => [
            'element_route_renders',
            'required_examples_present',
            'no_console_errors',
        ],

        'visual_review' => [
            'required' => true,
            'states' => [
                'default',
            ],
            'themes' => [
                'light',
                'dark',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Review
    |--------------------------------------------------------------------------
    |
    | review_state values:
    | not-started, scaffolded, in-progress, implemented, manual-review,
    | needs-review, approved, blocked, deprecated, not-applicable
    |
    */

    'review' => [
        'overall_state' => 'not-started',
        'blocked_by' => [],
        'last_reviewed_at' => null,
        'reviewed_by' => null,

        'scopes' => [
            'blade_api' => 'not-applicable',
            'css_contract' => 'not-started',
            'js_behavior' => 'not-applicable',
            'examples' => 'not-started',
            'accessibility' => 'not-started',
            'visual_parity' => 'not-started',
            'docs_copy' => 'not-started',
            'tokens' => 'not-started',
        ],

        'notes' => [],
    ],
];

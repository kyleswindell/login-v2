---
title: UI contract.php File
slug: ui-contract-file
status: current-standard
system_maturity: current-standard
api_layer: UI API governance
canonical_doc: docs/02-standards/ui/contract-file.md
related_component_index: docs/02-standards/ui/components/index.md
template: docs/09-reference/ui/ui-contract-template.php
related_reference_standard: docs/02-standards/ui/reference-file.md
---

# UI contract.php File
- [1. Purpose](#1-purpose)
- [2. Final Convention](#2-final-convention)
- [3. Required Shape](#3-required-shape)
- [4. Observed Element Baseline](#4-observed-element-baseline)
- [5. Section Responsibilities](#5-section-responsibilities)
- [6. Lifecycle](#6-lifecycle)
- [7. Enforcement](#7-enforcement)
- [8. Enums](#8-enums)
- [9. Example Requirements](#9-example-requirements)
- [10. Class Contract Requirements](#10-class-contract-requirements)
- [11. Testing Metadata](#11-testing-metadata)
- [12. Review Metadata](#12-review-metadata)
- [13. Rollout Rule](#13-rollout-rule)
- [14. Related](#14-related)

## 1. Purpose

UI `contract.php` files are structured usage contracts consumed as source data by rendered evidence, review tooling, source audits, examples, runtime validation, and future build tooling.

`contract.php` does not own rendered evidence page visibility, navigation, tabs, section order, example grouping, rendered page copy, or catalog placement. Those display decisions belong in an owner-local [`reference.php`](reference-file.md) file beside the contract.

The Elements-first migration sequence is controlled by [Element Contract Migration Control](element-contract-migration.md). This standard defines the durable contract-file shape that sequence must use; it does not itself decide Element runtime maturity.

Every approved UI standard must eventually have a `contract.php`. This includes Foundation Elements, public Components, hidden subcomponents, skeletons, aliases, shell pieces, and Patterns. The rollout is in progress; missing component contracts are migration backlog, not by themselves evidence that an installed Blade component is stale. A contract may exist for a surface that is hidden from rendered evidence navigation, embedded in an owner page, or inventory-only.

Each `contract.php` must be able to answer:

1. Whether the UI surface API is public, advanced, internal, hidden, deprecated, planned, pattern-owned, or otherwise contract-tracked.
2. Which build-tier dependencies must be stable before approval.
3. Which source files are expected.
4. Which Blade API props, slots, events, data attributes, classes, variants, sizes, and states are approved.
5. Which live examples are required.
6. Which accessibility, testing, and review scopes are complete, blocked, missing, deprecated, or not applicable.
7. Which usage rules are enforced now and which remain legacy-compatible during migration.

## 2. Final Convention

Final file convention:

```text
contract.php
```

In the final convention, no contract means the surface is not an approved UI standard. During the current rollout, legacy `docs.php` files may remain as transitional inventory files and installed Blade source remains authoritative for components that have not yet received a `contract.php`. New or migrated UI standards must use the structured `contract.php` shape.

Examples:

```text
resources/views/components/ui/button/contract.php
resources/views/components/ui/data-table/contract.php
resources/views/elements/color/contract.php
resources/views/components/patterns/login/contract.php
```

Owner-local rendered evidence presentation files use this companion convention:

```text
resources/views/elements/color/reference.php
resources/views/components/ui/tag/reference.php
resources/views/components/patterns/login/reference.php
```

`reference.php` is optional and consumer-specific. It may define rendered evidence tabs, route names, page titles, sections, example grouping, canvas/layout hints, and related links. It must not be required for runtime component usage or strict API enforcement.

Missing `reference.php`, or a `reference.php` without an explicit page mode, must be treated by rendered evidence as `inventory-only`. Contract registration alone must not create a visible rendered evidence page, overview card, or side-nav entry.

For component families, the parent family `contract.php` owns subcomponent contracts:

```php
'subcomponents' => [
    'table' => [
        'component' => 'x-ui.data-table.table',
        'public_api' => true,
        'usage_context' => 'Only inside x-ui.data-table.container or x-ui.data-table.',
    ],
    'cell' => [
        'component' => 'x-ui.data-table.cell',
        'public_api' => true,
        'usage_context' => 'Only inside x-ui.data-table.row.',
    ],
    'decorator-row' => [
        'component' => 'x-ui.data-table.decorator-row',
        'public_api' => false,
        'visibility' => 'internal',
    ],
],
```

## 3. Required Shape

Migrated `contract.php` files must use this top-level shape:

```php
return [
    'schema_version' => 1,
    'identity' => [],
    'catalog' => [],
    'lifecycle' => [],
    'enforcement' => [],
    'api' => [],
    'subcomponents' => [],
    'class_contract' => [],
    'variants' => [],
    'sizes' => [],
    'states' => [],
    'dependencies' => [],
    'source' => [],
    'examples' => [],
    'usage' => [],
    'accessibility' => [],
    'testing' => [],
    'review' => [],
];
```

Do not add new flat top-level fields such as `api_layer`, `build_tier`, `depends_on`, `review_state`, or `required_live_examples`. Put those values under the correct contract section.

`api_layer`-style information belongs under `identity.type`, `identity.group`, `api.usage_level`, or other documented metadata only if this standard and the copyable template adopt that field. Do not add one-off top-level metadata when an existing section already owns the concept.

## 4. Observed Element Baseline

The first confirmed stable contract category is Foundation Elements. The observed Element contracts under `resources/views/elements/{element}/contract.php` use the required top-level shape above and these conventions:

- `identity.type` is `element`.
- `identity.component` is `null` unless the Element has an actual component API.
- `dependencies.build_tier` is `0`.
- `api.props`, `api.slots`, `api.events`, and `api.data_attributes` may be empty when the Element exposes token/source rules instead of Blade props.
- `class_contract.root` may be `null` when the Element does not emit a single root class.
- `variants`, `sizes`, and `states` may be empty for Elements.
- `source.tokens` lists token source files only when the Element contract owns or directly consumes a token file.
- `source.examples` and `examples.items` declare required example identity, but they do not prove that example folders, Blade views, Rendered evidence routes, or rendered reference tabs currently exist.
- `catalog.detail_pages` appears in some simple Element contracts as transitional generic Element metadata. Owner-local `reference.php` files own migrated rendered evidence page structure.
- `testing.build_checks` declares expected scanner or test checks only. A value in this section is not actual scanner output and does not prove that the related file, route, example, or registration exists.

Current registered Element contracts are:

| Element | Contract | Contract posture |
| --- | --- | --- |
| 2x Grid | `resources/views/elements/2x-grid/contract.php` | lifecycle `approved`; review `approved` |
| Color | `resources/views/elements/color/contract.php` | lifecycle `approved`; review `needs-review` |
| Icons | `resources/views/elements/icons/contract.php` | lifecycle `approved`; review `approved` |
| Motion | `resources/views/elements/motion/contract.php` | lifecycle `provisional`; review `needs-review` |
| Pictograms | `resources/views/elements/pictograms/contract.php` | lifecycle `planned`; review `blocked` |
| Spacing | `resources/views/elements/spacing/contract.php` | lifecycle `approved`; review `approved` |
| Themes | `resources/views/elements/themes/contract.php` | lifecycle `approved`; review `needs-review` |
| Typography | `resources/views/elements/typography/contract.php` | lifecycle `provisional`; review `needs-review` |

## 5. Section Responsibilities

| Section | Owns |
| ------- | ---- |
| `schema_version` | Contract version for future migration checks. |
| `identity` | Stable identity: slug, label, optional Blade component tag, summary, group, type. |
| `catalog` | Contract-side API disposition, parent/owner relationship, inventory grouping, and transitional simple detail-page metadata when present. rendered evidence display decisions belong in `reference.php`. |
| `lifecycle` | Approval status, review gates, allowed usage surfaces, replacement target. |
| `enforcement` | Runtime and audit behavior for invalid props, variants, sizes, states, and contexts. |
| `api` | Approved props, slots, events, data attributes, defaults, allowed values, usage level. |
| `subcomponents` | Family-owned child components, visibility, usage context, public/internal status. |
| `class_contract` | Required, optional, internal, and deprecated classes emitted by Blade and expected by CSS/JS. |
| `variants` | Approved visual/API variants with classes, guidance, review state, and live example mapping. |
| `sizes` | Approved sizes/densities with API values, classes, descriptions, review state, and example mapping. |
| `states` | Required and optional visual, interaction, validation, loading, readonly, and skeleton states; may be empty for Elements. |
| `dependencies` | Build tier, required lower-tier dependencies, used icons/components/JS initializers, blockers, downstream blocked components. |
| `source` | Expected Blade, CSS, JS, token, contract, docs, and example files. |
| `examples` | Required live example identities, registered example view names when known, copyable install snippets. |
| `usage` | Purpose, use cases, do-not-use guidance, related components. |
| `accessibility` | Keyboard behavior, ARIA requirements, focus rules, screen reader notes, review state. |
| `testing` | Expected build/manual/automated/visual checks only. |
| `review` | Aggregate and scoped review state, blockers, reviewer/date metadata, notes. |

If a concept is already owned by a section above, keep it in that section. Do not add temporary top-level fields for scanner convenience, rendered evidence layout, active work status, or migration notes.

Element contracts may leave Blade-specific API fields empty when the Element is token/source based. Component contracts may fill `api`, `variants`, `sizes`, `states`, and `subcomponents` only from installed source evidence. Missing Component contracts are migration backlog; they are not proof that installed Blade components are stale.

## 6. Lifecycle

The lifecycle section controls whether a contracted UI surface is approved and where it may be used:

```php
'lifecycle' => [
    'status' => 'legacy-compatible',
    'api_approved' => false,
    'visual_approved' => false,
    'a11y_approved' => false,
    'allowed_in_app_layouts' => true,
    'allowed_in_patterns' => true,
    'replacement' => null,
],
```

For a legacy component:

```php
'lifecycle' => [
    'status' => 'legacy',
    'api_approved' => false,
    'visual_approved' => false,
    'a11y_approved' => false,
    'allowed_in_app_layouts' => true,
    'allowed_in_patterns' => true,
    'replacement' => null,
],
```

For an approved component:

```php
'lifecycle' => [
    'status' => 'approved',
    'api_approved' => true,
    'visual_approved' => true,
    'a11y_approved' => true,
    'allowed_in_app_layouts' => true,
    'allowed_in_patterns' => true,
    'replacement' => null,
],
```

Registry disposition and runtime contract lifecycle can disagree during migration. Document the source-of-truth decision before patching runtime contracts; do not decide maturity and edit runtime contracts in the same pass.

## 7. Enforcement

Use graduated enforcement. Having a contract does not mean the surface is strict. Approved lifecycle status plus approved review posture is what allows strict API enforcement.

```php
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
```

Approved strict contracts may opt into hard failures:

```php
'enforcement' => [
    'mode' => 'strict',
    'strict_props' => true,
    'strict_variants' => true,
    'strict_sizes' => true,
    'strict_states' => true,
    'strict_context' => true,
    'invalid_usage' => 'throw',
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
```

Central configuration should be introduced before runtime enforcement:

```php
// config/ui.php

return [
    'contracts' => [
        'enabled' => true,
        'default_mode' => env('UI_CONTRACT_MODE', 'legacy-compatible'),
        'throw_in_local' => true,
        'throw_in_testing' => true,
        'throw_in_production' => false,
        'log_legacy_usage' => true,
        'log_deprecated_usage' => true,
    ],
];
```

Recommended transition environment:

```env
UI_CONTRACT_MODE=legacy-compatible
```

Later rollout may raise this to `provisional`, then `strict`.

## 8. Enums

### `catalog.visibility` Contract Disposition

Use one of:

```php
'visible'
'hidden'
'subcomponent'
'variant'
'skeleton'
'internal'
'alias'
'deprecated'
'planned'
```

Meanings:

| Value | Meaning |
| ----- | ------- |
| `visible` | Primary API surface in the contract inventory. Does not create a rendered evidence page by itself. |
| `hidden` | Contract-tracked surface that is not intended as a standalone public API. |
| `subcomponent` | Public or semi-public source surface documented through a parent owner. |
| `variant` | Contract-tracked implementation variant documented through an owner surface. |
| `skeleton` | Loading/source surface documented through an owner component state. |
| `internal` | Not public API; allowed only inside an approved owner context. |
| `alias` | Compatibility wrapper for an approved owner component. |
| `deprecated` | Kept only for migration guidance or compatibility. |
| `planned` | Known gap, not implemented or not ready for public API use. |

`catalog.visibility` is a contract-side API disposition. rendered evidence page visibility must be decided by `reference.php` using `catalog.page.mode`, `catalog.page.overview`, and `catalog.page.side_nav` as defined in [rendered evidence.php File](reference-file.md).

### Owner-local `reference.php`

Do not place rendered rendered evidence sections in `contract.php`. Use an owner-local `reference.php` when a surface needs rendered evidence display control.

The migrated `reference.php` schema owns:

- whether the surface has a top-level page, owner tab, inventory-only record, queued gap, or hidden record
- whether the surface appears in overview cards or side navigation
- which tabs render, in what order, and from which data source
- which examples render and which remain inventory-only
- how children, companions, variants, skeletons, aliases, and Patterns are displayed through owner pages

See [rendered evidence.php File](reference-file.md) for the required schema. Existing Color and Themes files that return `schema_version`, `identity`, and `detail_pages` are legacy v1-compatible until migrated. New Element, Component, and Pattern reference files must use `schema => ui-reference.surface.v1`.

### `api.usage_level`

Use one of:

```php
'public'
'advanced'
'internal'
'deprecated'
'pattern-only'
```

Meanings:

| Value | Meaning |
| ----- | ------- |
| `public` | Safe for normal app layout authors. |
| `advanced` | Allowed for custom composition when a higher-level API is insufficient. |
| `internal` | Used only by a parent component or approved owner. |
| `deprecated` | Exists for migration only. |
| `pattern-only` | Used inside approved Patterns, not directly in normal pages. |

### `lifecycle.status`

Use one of:

```php
'legacy'
'legacy-compatible'
'provisional'
'approved'
'deprecated'
'internal'
'planned'
```

Meanings:

| Value | Meaning |
| ----- | ------- |
| `legacy` | Existing surface, not contract-audited, never blocks rendering. |
| `legacy-compatible` | Contract exists, but invalid usage warns/logs instead of throwing. |
| `provisional` | Public API is mostly defined; selected high-confidence violations may warn or throw by environment. |
| `approved` | API, visual, and accessibility review gates passed. Strict enforcement may be enabled. |
| `deprecated` | Still renders for migration, but should log or warn and point to a replacement. |
| `internal` | Only approved for parent components or explicit usage contexts. |
| `planned` | Known future surface, not approved for app layout use. |

### `enforcement.mode`

Use one of:

```php
'legacy'
'legacy-compatible'
'provisional'
'strict'
'deprecated'
'internal'
```

Runtime behavior:

| Mode | Local/testing | Production |
| ---- | ------------- | ---------- |
| `legacy` | Render normally. | Render normally. |
| `legacy-compatible` | Render and warn/log invalid usage. | Render and optionally log invalid usage. |
| `provisional` | Warn or throw for high-confidence violations. | Render and log. |
| `strict` | Throw on invalid usage. | Configurable; prefer throw for internal/admin apps. |
| `deprecated` | Render and warn/log. | Render and log. |
| `internal` | Throw when used outside approved context. | Log or throw based on risk/config. |

### `enforcement.invalid_usage`

Use one of:

```php
'throw'
'warn'
'log'
'ignore'
```

### `review_state`

Use one of:

```php
'not-started'
'scaffolded'
'in-progress'
'implemented'
'manual-review'
'needs-review'
'approved'
'blocked'
'deprecated'
'not-applicable'
```

Avoid vague states such as `partial`. Scoped states must explain what is missing or blocked.

### `dependencies.build_tier`

Build tiers must match the component index:

| Tier | Meaning |
| ---- | ------- |
| `0` | Foundation Element, not a Component page. |
| `1` | Standalone primitive. |
| `2` | Simple composite using Tier 1. |
| `3` | Interactive/composed control using Tier 1-2. |
| `4` | Complex component family. |
| `5` | Shell/app layout composition. |
| `6` | Pattern. |

## 9. Example Requirements

Do not list examples only as arbitrary cards. Every migrated contract must declare required example coverage. A declared example is an API/review requirement, not proof that the folder, Blade view, or Rendered evidence route already exists.

Observed Element contracts currently declare Element example roots under:

```text
resources/views/elements/{slug}/examples
```

Element example item view names use the `elements.{slug}.examples...` namespace when a view is known. Component and Pattern examples live beside their owner folders using the same grouped convention when those owners are migrated.

```php
'examples' => [
    'required_live_examples' => [
        'anatomy',
        'themes',
        'interaction_states',
    ],
    'items' => [
        'anatomy' => [
            'label' => 'Color anatomy',
            'view' => 'elements.color.examples.anatomy.swatches',
            'code' => null,
            'review_state' => 'needs-review',
        ],
    ],
    'install_snippets' => [],
],
```

rendered evidence overview tooling must be able to report required, present, missing, blocked, and approved examples from this structure.

## 10. Class Contract Requirements

Every migrated contract must define the classes that Blade is expected to emit and CSS/JS is expected to consume:

```php
'class_contract' => [
    'root' => 'ui-data-table',
    'required' => [
        'ui-data-table-container',
        'ui-data-table-header',
        'ui-data-table-content',
        'ui-data-table',
    ],
    'optional' => [
        'ui-data-table--sm',
        'ui-data-table--zebra',
    ],
    'internal' => [
        'ui-table-header-label',
        'ui-table-sort',
    ],
    'deprecated' => [
        'ui-data-table-wrapper',
        'ui-data-table-table',
    ],
],
```

The class contract exists to catch mismatches where Blade renders one selector family while CSS or JavaScript expects another. Normal app layout authors should use the Blade API instead of hand-writing `ui-*` class structures.

## 11. Testing Metadata

`contract.php` must declare expected checks only. Do not manually maintain actual pass/fail results in every component file. UI test policy lives in [UI Testing Standards](testing.md).

Allowed:

```php
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
],
```

Set source-specific checks to `true` only when the owning contract requires that file, token import, initializer, or example registration and the expected source path is known. Do not use this section as proof that the scanner has already passed.

Not allowed:

```php
'actual' => [
    'blade_exists' => true,
    'css_imported' => false,
],
```

Actual results belong to scanners, test output, active worklogs, or generated reports.

Do not create executable test folders, `__tests__` directories, or test files from contract metadata alone. A contract may require checks before the executable test implementation exists.

## 12. Review Metadata

Use aggregate and scoped review state:

```php
'review' => [
    'overall_state' => 'needs-review',
    'blocked_by' => [],
    'scopes' => [
        'blade_api' => 'approved',
        'css_contract' => 'needs-review',
        'js_behavior' => 'blocked',
        'examples' => 'implemented',
    ],
],
```

Standards docs define valid review-state vocabulary. Active implementation progress remains in `docs/08-active/`; `contract.php` declares durable UI-surface readiness requirements and review posture for rendered evidence tracking.

## 13. Rollout Rule

Use an additive rollout first and restrictive enforcement later:

1. Inventory only: add missing `contract.php` files from actual source evidence; enforcement remains off or legacy-compatible.
2. Warnings: contracts start warning or logging invalid API values without blocking work.
3. Strict approved components: only approved contracts throw on invalid usage; legacy components keep rendering.
4. App-wide strict mode: after core contracts are approved, raise global enforcement.

Do not make "has contract" equal "strict" or "visible rendered evidence page." A contract means the surface is tracked by the system. Approved lifecycle and review status mean strict enforcement is allowed. A migrated `reference.php` page mode is what allows rendered evidence visibility. During rollout, do not make "missing contract" equal "not installed" when a current Blade component exists.

Do not bulk-convert legacy `docs.php` files with guessed data. The contract must reflect actual source files, examples, classes, dependencies, and review requirements.

## 14. Related

- [Component API Standards](components/index.md)
- [Component Implementation Checklist](components/checklist.md)
- [Element Contract Migration Control](element-contract-migration.md)
- [rendered evidence.php File](reference-file.md)
- [UI Standards Index](index.md)
- [UI API Registry](api-registry.md)
- [UI Testing Standards](testing.md)
- [UI contract.php Template](../../09-reference/ui/ui-contract-template.php)
- [rendered evidence.php Template](../../09-reference/ui/ui-reference-template.php)

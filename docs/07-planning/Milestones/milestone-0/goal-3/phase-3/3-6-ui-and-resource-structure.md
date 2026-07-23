<!--
DOC-META
title: Phase 3.6 UI And Resource Structure
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/3-6-ui-and-resource-structure.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the artifact-owned presentation-bundle model for UI, Core, and Module resources and the transitional status of parallel CSS and JavaScript trees.
-->

# Phase 3.6 UI And Resource Structure

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This document records the ownership-aware resource structure and the accepted colocation of presentation source by UI or application artifact.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 3 review
- Implementation state: target direction only
- Owning GitHub issue: #50
- Depends on: Decisions 3.2, 3.4, and 3.5

## 3. Evidence And Problem

The current repository already colocates Blade implementations, `contract.php`, partials, and some component-specific tests.

Component CSS and JavaScript are instead spread across large parallel trees under:

```text
resources/css/components/
resources/css/patterns/
resources/js/ui-controls/
```

One component change therefore requires navigation across multiple distant locations.

## 4. Artifact-Owned Bundle Model

Reusable UI artifacts colocate owned source beneath one visible bundle.

Working target pattern:

```text
resources/
├── css/
│   ├── app.css
│   └── base/
├── js/
│   ├── app.js
│   └── bootstrap.js
└── views/
    ├── components/
    │   ├── ui/
    │   │   ├── components.css
    │   │   ├── components.js
    │   │   ├── _internal/
    │   │   └── <component>/
    │   ├── patterns/
    │   │   ├── patterns.css
    │   │   ├── patterns.js
    │   │   └── <pattern>/
    │   └── layouts/
    │       ├── layouts.css
    │       ├── layouts.js
    │       └── <layout>/
    ├── elements/
    │   ├── elements.css
    │   ├── elements.js
    │   └── <element>/
    ├── core/
    │   └── <Capability>/
    ├── errors/
    └── vendor/
```

Exact folder and file naming remains Phase 5 authority.

## 5. Component Bundle

A simple component may contain:

```text
button/
├── index.blade.php
├── button.css
├── button.js
├── contract.php
└── __tests__/
```

`contract.php` remains adjacent to the artifact whose callable API it defines.

Canonical prose standards remain under `docs/02-standards/ui/`.

## 6. Sparse Bundle Rule

Not every artifact requires every file.

Valid examples include:

```text
tag/
├── index.blade.php
├── tag.css
└── contract.php
```

```text
spacing/
├── spacing.css
├── contract.php
├── reference.php
└── __tests__/
```

Empty CSS, JavaScript, test, partial, or internal folders are prohibited.

## 7. Complex Bundles

A complex artifact may use bounded internal subdivisions:

```text
dialog/
├── index.blade.php
├── dialog.css
├── dialog.js
├── contract.php
├── partials/
├── internal/
└── __tests__/
```

Internal subdivisions remain owned by the artifact and do not create new application owners.

## 8. Category Aggregators

Category-level CSS and JavaScript entrypoints explicitly compose artifact bundles:

```text
resources/views/components/ui/components.css
resources/views/components/ui/components.js
resources/views/components/patterns/patterns.css
resources/views/components/patterns/patterns.js
resources/views/components/layouts/layouts.css
resources/views/components/layouts/layouts.js
resources/views/elements/elements.css
resources/views/elements/elements.js
```

Imports must be explicit, deterministic, and reviewable.

Hidden discovery must not obscure CSS cascade or JavaScript initialization order.

## 9. Root Vite Entrypoints

The primary Vite entrypoints remain:

```text
resources/css/app.css
resources/js/app.js
```

They act as composition roots rather than feature implementation locations.

`resources/js/bootstrap.js` may remain application-wide JavaScript bootstrap integration.

## 10. Reusable UI Internals

Utilities genuinely used by multiple UI artifacts may live in one bounded UI-internal area adjacent to the bundles.

A working example is:

```text
resources/views/components/ui/_internal/
```

Final internal folder naming remains Phase 5 authority.

Shared internals must not become a generic application utility owner.

## 11. Element Bundles

Element-owned CSS, contracts, examples, references, and tests should be colocated.

Examples:

```text
resources/views/elements/typography/
├── typography.css
├── contract.php
├── reference.php
├── examples/
├── internal/
└── __tests__/
```

```text
resources/views/elements/color/
├── color.css
├── contract.php
├── reference.php
├── examples/
├── palette/
├── semantic/
├── themes/
└── __tests__/
```

The Element category aggregator controls cross-Element import order.

## 12. Application-Wide Base Resources

Only genuinely application-wide baseline integration remains beneath root resource integration areas.

Possible examples include:

- document and browser normalization;
- accessibility baseline;
- compatibility rules;
- global forced-colors integration;
- application-wide layer declarations;
- root JavaScript bootstrap.

Current `base/`, `tokens/`, and `type/` contents require Phase 4 classification.

## 13. Core-Owned Presentation

Core presentation follows the same colocation principle within an owner-visible resource bundle.

Examples:

```text
resources/views/core/Dashboard/
├── index.blade.php
├── dashboard.css
├── dashboard.js
├── partials/
└── __tests__/
```

or, when multiple Surfaces exist:

```text
resources/views/core/Dashboard/Surface/main/
```

Exact intermediate roles and filenames remain Phase 4 and Phase 5 authority.

## 14. Module-Owned Presentation

Module-owned presentation remains package-local and uses the same bundle principle:

```text
Modules/<Module>/resources/views/<Surface>/
├── index.blade.php
├── <surface>.css
├── <surface>.js
├── partials/
└── __tests__/
```

Module CSS and JavaScript must not be copied into root parallel component trees.

The build and registration mechanism remains Phase 4 authority.

## 15. Shell And Layout Ownership

Current shell and layout paths may mix:

- reusable UI infrastructure;
- Core Shell-owned application composition;
- route- or owner-specific layouts.

They must be divided according to actual ownership.

A generic shell folder must not combine UI primitives and Core application-shell behavior.

## 16. Transitional Resource Branches

The following are transitional under the bundle model:

```text
resources/css/components/
resources/css/patterns/
resources/css/tokens/
resources/css/type/
resources/css/ui/
resources/js/ui-controls/
resources/js/internal/
```

Their contents must later be classified into artifact bundles, category internals, Core presentation, Module presentation, base integration, or retirement.

## 17. Accepted Decision

> Login 2.0 uses artifact-owned presentation bundles. A reusable UI Component, Element, Pattern, or Layout colocates its Blade or presentation implementation, CSS, JavaScript, machine-readable contract, targeted tests, partials, and internal support beneath one owner-visible source folder. Category-level CSS and JavaScript aggregators explicitly compose those bundles, while `resources/css/app.css` and `resources/js/app.js` remain the primary Vite entrypoints. Core-owned and Module-owned presentation follows the same colocation principle within its owner boundary. Truly application-wide base CSS, JavaScript bootstrap, framework overrides, error views, and vendor overrides may remain in bounded root integration locations. Separate parallel component trees beneath `resources/css` and `resources/js` are transitional and are not the target model. Final filenames, aliases, import conventions, and detailed artifact placement remain Phase 4 and Phase 5 authority.

## 18. Related

- [Phase 3 Index](index.md)
- [Core Physical Structure](3-4-core-physical-structure.md)
- [Module Physical Structure](3-5-module-physical-structure.md)
- [Test Folder Locations](3-9-test-folder-locations.md)
- Related GitHub issue: #50
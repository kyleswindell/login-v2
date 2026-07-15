<!--
DOC-META
title: Phase 3.9 Test Folder Locations
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/3-9-test-folder-locations.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the hybrid test topology using owner-local test colocation and a narrowed repository-root tests branch.
-->

# Phase 3.9 Test Folder Locations

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This document records the hybrid test-location model added during Phase 3 review.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 3 review
- Implementation state: target direction only
- Owning GitHub issue: #50
- Detailed placement consumer: Phase 4, Issue #51

## 3. Governing Principle

> Tests should live as close as practical to the smallest cohesive owner or artifact they verify. The root `tests/` branch remains for verification whose scope is repository-wide, cross-owner, application-wide, or framework-wide.

## 4. Core Capability Tests

Each Core capability may contain one capability-root test package:

```text
app/Core/<Capability>/
├── <TechnicalRole>/
└── __tests__/
    ├── Unit/
    ├── Feature/
    ├── Contracts/
    ├── Architecture/
    ├── Fixtures/
    └── Support/
```

Tests may mirror source roles inside the capability test package.

Avoid arbitrary `__tests__/` directories beside every class or Technical Role.

## 5. UI-Owned PHP Tests

UI-owned PHP and runtime responsibilities may contain:

```text
app/UI/<Responsibility>/__tests__/
```

Restricted global Laravel integration may contain:

```text
app/Http/__tests__/
app/Console/__tests__/
app/Providers/__tests__/
```

Those tests verify only bounded global integration.

## 6. UI Artifact And Category Tests

Reusable presentation bundles may contain artifact-local tests:

```text
resources/views/components/ui/button/
├── index.blade.php
├── button.css
├── button.js
├── contract.php
└── __tests__/
```

Category-level tests may live at:

```text
resources/views/components/ui/__tests__/
resources/views/elements/__tests__/
```

The distinction is:

- artifact test → inside the artifact bundle;
- category or schema test → at the category root.

## 7. Module Tests

Independently distributable Modules use a package-root test package:

```text
Modules/<Module>/
├── src/
├── resources/
└── tests/
    ├── Unit/
    ├── Feature/
    ├── Contracts/
    ├── Architecture/
    ├── Fixtures/
    └── Support/
```

Modules do not use `src/__tests__/` as their formal test package.

## 8. Repository-Root Tests

Root `tests/` remains permanent for concerns with no single owner:

```text
tests/
├── Architecture/
├── Integration/
├── System/
├── Browser/
├── Compatibility/
├── Repository/
├── Support/
└── TestCase.php
```

Examples include:

- Core-to-Module integration;
- multi-capability workflows;
- full application journeys;
- repository topology and dependency checks;
- Laravel application boot;
- browser and Playwright suites;
- compatibility behavior;
- shared test bases and infrastructure;
- full database migration smoke tests;
- documentation and repository guardrails.

## 9. Tests That Should Move Owner-Local

Root `tests/Feature/<Capability>/` is not the default target for:

- one capability’s Policy test;
- one Action test;
- one Registry contract test;
- one UI artifact rendering test;
- one Module’s internal behavior test.

Those tests follow their owner.

## 10. Avoid Excessive Fragmentation

The default is:

- one `__tests__/` package per Core capability;
- one `__tests__/` package per application-owned UI or bounded integration responsibility;
- one `__tests__/` package inside a UI artifact bundle;
- optional category-level UI tests;
- one `tests/` package per Module;
- root `tests/` for repository-wide scope.

## 11. Deterministic Discovery Requirement

The target runner must eventually discover:

```text
app/Core/**/__tests__/
app/UI/**/__tests__/
app/Http/__tests__/
app/Console/__tests__/
app/Providers/__tests__/
resources/views/**/__tests__/
Modules/*/tests/
tests/
```

This may require later changes to:

- `phpunit.xml`;
- Composer autoload-dev;
- Pest configuration;
- repository test collectors;
- CI commands;
- targeted-test documentation.

No test may silently disappear because it moved beside its owner.

## 12. Deployment Consideration

Colocated tests may exist in a deployed checkout only when:

- test classes are not loaded during normal runtime;
- fixtures contain no real secrets or sensitive data;
- deployment safely retains or excludes tests;
- exclusion does not affect local or CI discovery.

Detailed deployment packaging remains later operational and placement work.

## 13. Phase 3 Amendments

Decision 3.9 amends the interpretation of:

- Decision 3.4 by adding optional capability-root `__tests__/`;
- Decision 3.5 by retaining package-root Module `tests/`;
- Decision 3.6 by retaining artifact- and category-local UI `__tests__/`;
- Decision 3.7 by narrowing root `tests/`.

## 14. Accepted Decision

> Login 2.0 uses owner-local test colocation where one capability, Module, UI artifact, or bounded Laravel integration area clearly owns the behavior under test. Core capabilities and application-owned PHP areas may use a root-local `__tests__/` package; reusable UI bundles may use artifact-local or category-local `__tests__/`; independently distributable Modules use package-root `tests/`. The repository-root `tests/` branch remains permanent for cross-owner integration, system, browser, architecture, compatibility, repository, and shared test-infrastructure concerns. Tests must not be centralized merely by technical type, and test-runner configuration must eventually prove deterministic discovery across every accepted location.

## 15. Related

- [Phase 3 Index](index.md)
- [Core Physical Structure](3-4-core-physical-structure.md)
- [Module Physical Structure](3-5-module-physical-structure.md)
- [UI And Resource Structure](3-6-ui-and-resource-structure.md)
- [Supporting Repository Branches](3-7-supporting-repository-branches.md)
- Related GitHub issue: #50
<!--
DOC-META
title: Test Implementation Standards Index
doc_type: index
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/test-implementation/index.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes repository-specific standards for test-source placement, Laravel and database test code, fixtures and doubles, browser test source, and test-source lifecycle.
-->

# Test Implementation Standards Index

Parent: [Coding Standards Index](../index.md)

Use this index for repository-specific rules about how test source is placed, written, organized, and maintained.

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Standards](#3-standards)
- [4. Reading And Routing](#4-reading-and-routing)
- [5. Shared Implementation Boundaries](#5-shared-implementation-boundaries)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose And Authority

This family defines how accepted verification requirements are implemented as repository test source using the installed PHP, Laravel, PHPUnit, JavaScript, and Playwright tooling.

It is a coding-standard family. It does not determine what must be proven or whether evidence is sufficient.

Use this authority split:

```text
accepted requirement and canonical behavior owner
        ↓
docs/02-standards/testing/
        defines proof design, validity, environments, evidence, and testing gates
        ↓
docs/02-standards/coding/test-implementation/
        defines how required test source is implemented and maintained
```

When a rule here conflicts with the Testing Standards suite on proof meaning, test level, environment validity, protected evidence, result classification, or delivery gates, the Testing Standards suite controls.

When a rule here conflicts with Repository Architecture on ownership or target placement, Repository Architecture controls.

When a rule here conflicts with Repository Naming Standards on names or paths, Repository Naming Standards controls.

## 2. Scope

### 2.1. Belongs Here

This family owns repository-specific implementation rules for:

- test-source ownership and target placement;
- PHPUnit and Laravel test-file construction;
- test base classes, traits, and support code;
- setup and teardown implementation;
- Laravel HTTP, container, configuration, and persistence test code;
- factories, scenario builders, seeders, and fixtures as source artifacts;
- framework fakes and test doubles as implemented test code;
- authentication and authorization test setup;
- Event, Job, scheduler, and asynchronous test-source mechanics;
- Playwright test source and selectors;
- time, randomness, identifiers, and external-state handling in test code;
- datasets and custom assertion helpers;
- generated test source and incomplete scaffolds;
- runner discovery, suites, groups, and source selection;
- protected test-source handling;
- test-source review.

### 2.2. Does Not Belong Here

This family does not define:

- application behavior;
- architecture or dependency direction;
- public Contracts;
- exact schema behavior;
- security-control requirements;
- UI public APIs or accessibility requirements;
- operational procedures;
- `AC-*` acceptance criteria;
- `PF-*` proof declarations;
- proof purpose, method, level, or applicability;
- `PASS`, `EXPECTED_NONPASS`, or `FAIL`;
- initial-proof requirements;
- protected-baseline acceptance or revision authority;
- environment equivalence;
- evidence retention or testing gates;
- supported compatibility targets;
- exact test and fixture naming.

Route those responsibilities to their canonical owners rather than duplicating them here.

## 3. Standards

| Standard                                                                                                                  | Owns                                                                                                                                                                                   |
| ------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Test Source And Placement Standards](test-source-and-placement-standards.md)                                             | Approved runners, test ownership and target placement, PHP test-file construction, base classes, shared support, and test-method construction.                                         |
| [Laravel And Database Test Implementation Standards](laravel-and-database-test-implementation-standards.md)               | Setup and teardown, Laravel HTTP and container test code, application assertions, PostgreSQL-aware test implementation, transactions, migrations, locking, and direct database access. |
| [Fixtures, Doubles, And Async Test Implementation Standards](fixtures-doubles-and-async-test-implementation-standards.md) | Factories, scenario builders, seeders, fixtures, framework fakes, mocks, security-sensitive setup, Events, Jobs, schedulers, and asynchronous test code.                               |
| [Browser Test Implementation Standards](browser-test-implementation-standards.md)                                         | Playwright source, user-observable interaction, selectors, synchronization, browser actors and data, test hooks, and browser-evidence safety.                                          |
| [Test Source Lifecycle Standards](test-source-lifecycle-standards.md)                                                     | Time and randomness controls, datasets, assertion helpers, generated tests, discovery, protected test source, source review, and prohibited maintenance patterns.                      |

## 4. Reading And Routing

Read only the standards needed for the current task.

| Task                                                                                            | Read                                                                                             |
| ----------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ |
| Create or relocate a PHP test                                                                   | Test Source And Placement Standards; Repository Naming Standards; applicable owner architecture. |
| Test a Laravel route, Action, provider, configuration, or persistence behavior                  | Test Source And Placement Standards; Laravel And Database Test Implementation Standards.         |
| Create or change factories, fixtures, fakes, mocks, Jobs, or asynchronous test support          | Fixtures, Doubles, And Async Test Implementation Standards.                                      |
| Create or change Playwright source                                                              | Browser Test Implementation Standards; applicable UI or feature Contract.                        |
| Change datasets, generated tests, suite discovery, protected tests, or shared assertion helpers | Test Source Lifecycle Standards.                                                                 |
| Decide which proof is required or whether a run is valid                                        | [Testing Standards Index](../../testing/index.md), not this family.                              |

A task may require more than one child standard. Do not load every child by default.

## 5. Shared Implementation Boundaries

All child standards follow these boundaries:

- Test source must have the smallest clear owner.
- Test placement must remain compatible with deterministic local and CI discovery.
- Cross-owner test code must use accepted public Contracts and must not reach into provider-private implementation.
- Test code must exercise the public entry point appropriate to the declared proof.
- Test implementation must not invent requirements, permissions, schema, public APIs, compatibility behavior, or expected results.
- Framework fakes and doubles may replace only boundaries excluded from the proof.
- Test source must not contain production secrets or unrestricted production data.
- Test code must not silently disable the behavior that the proof claims to verify.
- Generated tests are scaffolding until placeholders and incomplete assertions are resolved.
- A source artifact that becomes part of a protected verification baseline may not be weakened or redirected without the authority defined by the verification contract.

## 6. Maintenance

When adding, moving, splitting, superseding, or removing a test-implementation standard:

- update this index in the same change;
- preserve one clear canonical owner for each rule;
- update the Coding Standards Index when the family-level route changes;
- keep proof-policy rules in `docs/02-standards/testing/`;
- keep architecture and ownership rules in their canonical architecture owner;
- keep exact naming rules in Repository Naming Standards;
- preserve a heavily linked superseded path as a concise compatibility route when practical;
- update active inbound references when the migration is in scope;
- run documentation guardrails and link validation when available.

Do not allow a child standard to become a second testing-policy authority.

## 7. Related

- [Coding Standards Index](../index.md)
- [Coding Standards](../Coding%20Standards.md)
- [File Building Standards](../File%20Building%20Standards.md)
- [Repository Naming Standards](../repository-naming-standards.md)
- [PHP And Laravel Style Standards](../PHP%20And%20Laravel%20Style%20Standards.md)
- [Agent Implementation Checklist](../Agent%20Implementation%20Checklist.md)
- [Testing Standards Index](../../testing/index.md)
- [Repository Architecture](../../../03-architecture/repository-architecture.md)
- [Stub Templates](../../../../stubs/README.md)

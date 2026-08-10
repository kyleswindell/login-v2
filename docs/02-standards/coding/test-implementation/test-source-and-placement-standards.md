<!--
DOC-META
title: Test Source And Placement Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/test-implementation/test-source-and-placement-standards.md
parent: docs/02-standards/coding/test-implementation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines approved test runners, test ownership and target placement, PHP test-file construction, base test classes, shared support, and test-method construction.
-->

# Test Source And Placement Standards

Parent: [Test Implementation Standards Index](index.md)

- [1. Purpose And Scope](#1-purpose-and-scope)
- [2. Approved Runners And Configuration](#2-approved-runners-and-configuration)
- [3. Test Placement And Ownership](#3-test-placement-and-ownership)
  - [3.1. Smallest clear owner](#31-smallest-clear-owner)
  - [3.2. Root tests](#32-root-tests)
  - [3.3. Core capability tests](#33-core-capability-tests)
  - [3.4. Module tests](#34-module-tests)
  - [3.5. UI tests](#35-ui-tests)
  - [3.6. Browser tests](#36-browser-tests)
  - [3.7. Tooling tests](#37-tooling-tests)
- [4. PHP Test File Construction](#4-php-test-file-construction)
- [5. Base Test Classes, Traits, And Shared Support](#5-base-test-classes-traits-and-shared-support)
- [6. Test Method Construction](#6-test-method-construction)
- [7. Prohibited Patterns](#7-prohibited-patterns)
- [8. Review](#8-review)
- [9. Related](#9-related)

## 1. Purpose And Scope

Define the repository-specific source and placement rules common to PHPUnit and Laravel tests.

This standard owns:

- runner use and test-discovery configuration as source infrastructure;
- test ownership and target placement;
- PHP test-file shape;
- base test classes and reusable support;
- test-method construction.

It does not select the proof, test level, environment, or expected result. Those are governed by the [Testing Standards Index](../../testing/index.md).

Exact test and fixture naming is governed by [Repository Naming Standards](../repository-naming-standards.md).

## 2. Approved Runners And Configuration

Use the repository-installed runner and committed configuration.

Current runner families are:

| Test source                                     | Runner and configuration                                                                 |
| ----------------------------------------------- | ---------------------------------------------------------------------------------------- |
| Isolated PHP tests                              | PHPUnit through installed Composer and Laravel test tooling.                             |
| Laravel application tests                       | PHPUnit through `php artisan test` and `phpunit.xml`.                                    |
| UI PHP tests                                    | PHPUnit through the configured UI testsuite.                                             |
| Browser and JavaScript interaction specs        | Playwright through `npm run test:browser` and `playwright.config.js`.                    |
| Node validators, generators, or inventory tools | Owner-local Node test scripts registered through repository package scripts when stable. |

Do not introduce Pest, Jest, Vitest, Cypress, another browser runner, another assertion library, or another test-discovery system without the accepted dependency and architecture authority required by the repository.

Runner configuration is verification infrastructure. Changes to applicable:

- `phpunit.xml`;
- `playwright.config.js`;
- Composer test scripts;
- npm test scripts;
- test bootstrap;
- suite discovery;
- coverage configuration;
- global test environment;

require explicit scope and applicable verification.

Do not modify runner configuration solely to hide a failing or inconvenient test.

## 3. Test Placement And Ownership

### 3.1. Smallest clear owner

Place each test with the smallest clear owner of the behavior being verified.

Test placement communicates ownership.

The accepted target topology includes applicable:

```text
app/Core/<Capability>/__tests__/
app/UI/<Responsibility>/__tests__/
app/Http/__tests__/
app/Console/__tests__/
app/Providers/__tests__/
resources/views/**/__tests__/
Modules/<Module>/tests/
tests/
```

Do not place tests in a generic shared folder merely because multiple source files participate in the behavior.

A cross-owner test belongs to the owner of the accepted workflow, consumer integration, system boundary, or acceptance proof defined by the verification contract.

Root `tests/` is a repository-wide verification boundary. It must not become the default destination for behavior with a clear Core capability, Module, UI, or Laravel-integration owner.

Test placement must remain compatible with configured deterministic local and CI discovery.

Do not physically move an existing test to an owner-local target path until that location is discovered correctly in the required execution environments.

### 3.2. Root tests

Root `tests/` is reserved for verification that is genuinely cross-owner, application-wide, system-level, compatibility-oriented, architecture-oriented, browser-oriented, repository-oriented, or dependent on shared test infrastructure.

Current discovered root families include:

```text
tests/Unit/
tests/Feature/
tests/Browser/
```

These current directories do not establish target ownership by test type.

Existing tests may remain in `tests/Unit/` or `tests/Feature/` while migration and owner-local discovery are incomplete.

Do not place a new owner-specific test in a root directory merely because it is conventionally described as a PHPUnit unit or feature test.

Prefer the accepted owner-local topology when the behavior has a clear owner and the location is supported by deterministic discovery.

Use root `tests/` for applicable:

- cross-owner integration tests;
- system tests;
- end-to-end application workflows;
- application-level browser tests;
- architecture and dependency tests;
- compatibility tests;
- repository and tooling verification;
- shared test infrastructure that does not belong to one application owner.

`tests/Browser/` may own application-level Playwright workflows when behavior spans owners, represents an assembled application workflow, or has no narrower accepted owner-local browser location.

Do not treat `Unit`, `Feature`, or `Browser` as application owners. Test level and test ownership are separate classifications.

### 3.3. Core capability tests

Place Core capability tests beneath:

```text
app/Core/<Capability>/__tests__/
```

when the path is supported by accepted Repository Architecture and deterministic runner discovery.

Core capability tests may exercise owner-local:

- Actions;
- Queries;
- policies;
- persistence;
- Events;
- Jobs;
- Notifications;
- Delivery Adapters;
- registration;
- configuration;
- Product or Page presentation owned by that capability.

Cross-owner behavior must use the provider's public Contract and follow the applicable integration-test ownership rule.

Do not create new canonical tests beneath transitional `Platform` paths merely because older tests use them.

Do not move an existing root test into an owner-local `__tests__/` path until local and CI discovery of that path is established.

When the owner or target test topology is unresolved, stop rather than inventing a tree.

### 3.4. Module tests

Module-owned tests belong beneath:

```text
Modules/<Module>/tests/
```

A Module test verifies behavior owned by that package and should remain locally understandable and executable with the Module where practical.

A Module test must not require direct access to another owner's private:

- Model;
- repository;
- table;
- Action;
- Query implementation;
- Service implementation;
- Registry internals.

Cross-owner behavior must use public Contracts.

Provider Contract proof remains with the provider. Consumer use of another owner's public Contract remains with the consuming Module when consumer behavior is being verified.

Do not duplicate Core tests inside every Module.

Do not place Module business tests in root `tests/` merely for convenience when the accepted package topology provides Module-local tests.

### 3.5. UI tests

Reusable UI test source follows the UI owner and configured discovery.

Applicable target locations include:

```text
app/UI/<Responsibility>/__tests__/
resources/views/**/__tests__/
```

Use `app/UI/<Responsibility>/__tests__/` for reusable UI PHP or runtime responsibilities owned beneath `app/UI/`.

Use artifact-local `resources/views/**/__tests__/` for applicable Element, Component, Pattern, or Layout tests colocated with the reusable presentation artifact.

A file under `resources/` is not automatically UI-owned.

Core-owned Product or Page presentation remains owned by the applicable Core capability. Module-owned Product or Page presentation remains owned by the applicable Module.

Do not move route-owned presentation tests into reusable UI merely because the rendered output consumes UI Components.

### 3.6. Browser tests

Browser source follows the ownership rules above and the configured Playwright discovery.

Use root `tests/Browser/` for application-level browser verification that is appropriately root-owned, including applicable cross-owner, system, end-to-end, compatibility, or application-level acceptance workflows.

Owner-local browser specs may remain with a Core capability, Module, or reusable UI artifact when:

- the behavior has one clear owner;
- the location is accepted by Repository Architecture;
- Playwright discovers the location deterministically in local and CI execution.

Browser-test placement does not transfer ownership of the behavior being verified.

Detailed browser-source construction belongs to [Browser Test Implementation Standards](browser-test-implementation-standards.md).

### 3.7. Tooling tests

Tests for repository tooling belong with the tooling owner.

Use deterministic fixtures near the tool's test source or in its accepted fixture tree.

A validator, generator, inventory collector, renderer, migration tool, or similar executable repository tool should have a bounded self-test that exercises its delivered entry point.

Repository-wide tooling verification may use root `tests/` or another accepted tooling-owned location when no narrower source owner applies.

Application tests must not become responsible for proving unrelated repository tooling.

## 4. PHP Test File Construction

PHP test files follow [PHP And Laravel Style Standards](../PHP%20And%20Laravel%20Style%20Standards.md).

Use:

```php
<?php

declare(strict_types=1);
```

New PHP test files must:

- declare strict types;
- use one test class per file;
- use explicit imports and remove unused imports;
- use the namespace required by autoload and placement;
- use a final class unless intentional test-class inheritance is required;
- use explicit `void` return types for test methods;
- use trailing commas in multiline arrays and argument lists;
- avoid broad file headers;
- avoid unresolved placeholders;
- avoid commented-out tests and disabled alternate implementations.

Generic PHP test files identify themselves through namespace, class name, method names, placement, and proof mapping outside source when required.

Do not add large comment blocks that repeat the issue or verification contract.

Use comments only when they explain a non-obvious harness constraint, unusual fixture, framework workaround, excluded real boundary, or subtle concurrency or timing coordination point.

Comments must not conceal missing assertions.

## 5. Base Test Classes, Traits, And Shared Support

Use `PHPUnit\Framework\TestCase` for isolated PHP tests that do not require Laravel boot, the container, configuration, facades, database access, or Laravel framework services.

A unit test must not extend the Laravel application base merely to obtain convenience helpers.

Use `Tests\TestCase` for tests requiring Laravel application behavior such as routes, middleware, Form Requests, policies, container bindings, configuration, Eloquent, framework Events, Jobs, Notifications, mail, cache, storage, or owner services wired through the application.

Extending `Tests\TestCase` does not define the proof level. The verification contract defines the claimed level.

Create a specialized test base or trait only when one repeated technical concern justifies it, such as an authenticated browser harness, migration harness, queue-worker harness, protocol sandbox, or one owner's repeated actor setup.

A specialized base or trait must:

- have one clear concern and owner;
- expose meaningful setup;
- avoid hidden broad state;
- preserve parent setup and teardown;
- remain compatible with runner discovery;
- not bypass the boundary the test claims to prove.

Do not create deep test inheritance hierarchies. Prefer composition, factories, scenario builders, and explicit helpers.

Do not place owner-specific behavior in global `Tests\TestCase`.

A global helper is justified only when it is cross-owner, mechanical, stable, broadly required, and independent from one feature's policy.

Owner-specific actor, permission, fixture, route, or workflow helpers belong with that owner's tests.

Do not move a helper into production source solely to make tests convenient. A production seam must have a real application responsibility.

## 6. Test Method Construction

Each test method should prove one coherent accepted behavior. One behavior may require multiple assertions.

Examples include:

- response plus durable state;
- rejection plus unchanged state;
- mutation plus Event and Audit evidence;
- Job completion plus idempotent side effects;
- browser interaction plus accessible state.

Split a test when failures would be ambiguous, setup states materially differ, different owners or environments are being proved, or one branch could pass while another never executes.

Make meaningful setup, public action, and observable assertions visible. Blank lines or focused private helpers are sufficient; do not add Arrange/Act/Assert comments mechanically when structure is clear.

Do not hide actor, target, scope, state, or expected outcome inside a generic helper.

Call the public entry point appropriate to the proof, such as an HTTP route, public Action or Query Contract, command, Event or Job dispatch boundary, Registry Extension Point, browser interaction, or application operation.

Do not invoke private or protected methods, provider-private repositories, or concrete Handlers merely to avoid setup.

Direct object construction is appropriate for true unit tests of public behavior.

Direct controller invocation does not prove routing, middleware, Form Request validation, authorization integration, or response behavior.

Use runner-native exception expectations only when the exception itself is the public observable Contract. When the application translates a failure into a response, redirect, validation error, result object, failed Job, Audit event, or user-visible error, assert that public result.

Do not catch an exception merely to keep a test running unless the test asserts the accepted translation or cleanup.

## 7. Prohibited Patterns

Do not:

- use test type as a substitute for ownership;
- place owner-specific tests in root `tests/` by default;
- create new target tests under transitional `Platform` ownership;
- hide owner-specific helpers in global `Tests\TestCase`;
- create deep test-class inheritance;
- use Laravel boot for a pure unit test only for convenience;
- invoke private implementation instead of the public entry point;
- change runner discovery to hide a failing protected test;
- introduce a second test framework without accepted authority;
- duplicate exact naming rules already owned by Repository Naming Standards.

## 8. Review

Before accepting source or placement changes, confirm:

- the smallest clear owner is identified;
- target placement agrees with Repository Architecture;
- the configured runner discovers the test in required environments;
- current transitional paths are not presented as target ownership;
- PHP source follows current style and naming standards;
- base classes and shared support do not hide owner state;
- the test calls the public boundary appropriate to its declared proof;
- no unrelated test framework or discovery change was introduced.

Proof adequacy is reviewed under the Testing Standards suite, not this standard.

## 9. Related

- [Test Implementation Standards Index](index.md)
- [Laravel And Database Test Implementation Standards](laravel-and-database-test-implementation-standards.md)
- [Browser Test Implementation Standards](browser-test-implementation-standards.md)
- [Test Source Lifecycle Standards](test-source-lifecycle-standards.md)
- [Testing Standards Index](../../testing/index.md)
- [Repository Naming Standards](../repository-naming-standards.md)
- [PHP And Laravel Style Standards](../PHP%20And%20Laravel%20Style%20Standards.md)
- [Repository Architecture](../../../03-architecture/repository-architecture.md)

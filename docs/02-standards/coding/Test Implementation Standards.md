<!--
DOC-META
title: Test Implementation Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Test Implementation Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines repository-specific coding and placement rules for PHPUnit, Laravel, Playwright, test support code, setup, teardown, framework fakes, datasets, discovery, and generated test source.
-->

# Test Implementation Standards

Parent: [Coding Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Scope And Routing](#2-scope-and-routing)
  - [2.1. This standard owns](#21-this-standard-owns)
  - [2.2. This standard does not own](#22-this-standard-does-not-own)
- [3. Approved Test Runners And Configuration](#3-approved-test-runners-and-configuration)
- [4. Test Placement And Ownership](#4-test-placement-and-ownership)
  - [4.1. Smallest clear owner](#41-smallest-clear-owner)
  - [4.2. Root application tests](#42-root-application-tests)
  - [4.3. Core capability tests](#43-core-capability-tests)
  - [4.4. Module tests](#44-module-tests)
  - [4.5. UI tests](#45-ui-tests)
  - [4.6. Browser tests](#46-browser-tests)
  - [4.7. Tooling and script tests](#47-tooling-and-script-tests)
- [5. PHP Test File Construction](#5-php-test-file-construction)
- [6. Base Test Classes, Traits, And Shared Support](#6-base-test-classes-traits-and-shared-support)
  - [6.1. PHPUnit base](#61-phpunit-base)
  - [6.2. Laravel application base](#62-laravel-application-base)
  - [6.3. Specialized bases and traits](#63-specialized-bases-and-traits)
  - [6.4. Shared helper boundaries](#64-shared-helper-boundaries)
- [7. Test Method Construction](#7-test-method-construction)
  - [7.1. One coherent behavior](#71-one-coherent-behavior)
  - [7.2. Arrange, act, and assert](#72-arrange-act-and-assert)
  - [7.3. Public entry points](#73-public-entry-points)
  - [7.4. Expected failure and rejection](#74-expected-failure-and-rejection)
- [8. Setup, Teardown, And State Isolation](#8-setup-teardown-and-state-isolation)
  - [8.1. Setup](#81-setup)
  - [8.2. Teardown](#82-teardown)
  - [8.3. Global state](#83-global-state)
  - [8.4. Middleware and framework adaptations](#84-middleware-and-framework-adaptations)
- [9. Laravel Application-Test Implementation](#9-laravel-application-test-implementation)
  - [9.1. HTTP and route tests](#91-http-and-route-tests)
  - [9.2. Actions, Queries, policies, and services](#92-actions-queries-policies-and-services)
  - [9.3. Container, configuration, and providers](#93-container-configuration-and-providers)
  - [9.4. Responses, redirects, sessions, and validation](#94-responses-redirects-sessions-and-validation)
- [10. Database-Aware Test Implementation](#10-database-aware-test-implementation)
  - [10.1. Ordinary persistence tests](#101-ordinary-persistence-tests)
  - [10.2. Commit, concurrency, migration, and locking tests](#102-commit-concurrency-migration-and-locking-tests)
  - [10.3. Direct database access](#103-direct-database-access)
- [11. Factories, Scenario Builders, Seeders, And Fixtures](#11-factories-scenario-builders-seeders-and-fixtures)
  - [11.1. Factories](#111-factories)
  - [11.2. Scenario builders](#112-scenario-builders)
  - [11.3. Seeders](#113-seeders)
  - [11.4. Fixtures](#114-fixtures)
- [12. Test Doubles And Laravel Fakes](#12-test-doubles-and-laravel-fakes)
  - [12.1. General rule](#121-general-rule)
  - [12.2. Events](#122-events)
  - [12.3. Jobs and queues](#123-jobs-and-queues)
  - [12.4. Notifications and mail](#124-notifications-and-mail)
  - [12.5. Filesystems, cache, and HTTP](#125-filesystems-cache-and-http)
  - [12.6. Mocking](#126-mocking)
- [13. Authentication, Authorization, And Security-Test Code](#13-authentication-authorization-and-security-test-code)
- [14. Events, Jobs, Schedulers, And Asynchronous Test Code](#14-events-jobs-schedulers-and-asynchronous-test-code)
- [15. Browser And UI Test Implementation](#15-browser-and-ui-test-implementation)
  - [15.1. Playwright source](#151-playwright-source)
  - [15.2. User-observable interaction](#152-user-observable-interaction)
  - [15.3. Selectors](#153-selectors)
  - [15.4. Waiting and timing](#154-waiting-and-timing)
  - [15.5. Browser data and authentication](#155-browser-data-and-authentication)
  - [15.6. Browser evidence safety](#156-browser-evidence-safety)
- [16. Time, Randomness, Identifiers, And External State](#16-time-randomness-identifiers-and-external-state)
- [17. Datasets And Parameterized Cases](#17-datasets-and-parameterized-cases)
- [18. Assertions And Custom Assertion Helpers](#18-assertions-and-custom-assertion-helpers)
- [19. Templates, Generated Tests, And Incomplete Scaffolds](#19-templates-generated-tests-and-incomplete-scaffolds)
- [20. Discovery, Suites, Groups, And Selection](#20-discovery-suites-groups-and-selection)
- [21. Protected Test Source](#21-protected-test-source)
- [22. Test-Code Review Checklist](#22-test-code-review-checklist)
  - [Ownership and placement](#ownership-and-placement)
  - [PHP or JavaScript source](#php-or-javascript-source)
  - [Setup and isolation](#setup-and-isolation)
  - [Test boundary](#test-boundary)
  - [Assertions](#assertions)
  - [Discovery and maintenance](#discovery-and-maintenance)
- [23. Prohibited Patterns](#23-prohibited-patterns)
- [24. Related](#24-related)

## 1. Purpose And Authority

Define how test source code is placed, constructed, organized, and maintained in Login 2.0.

This is a coding and implementation standard.

It translates accepted verification requirements into repository-specific test source using the installed PHP, Laravel, PHPUnit, JavaScript, and Playwright tooling.

This standard does not determine which proof is required or whether evidence is sufficient.

Use:

```text
docs/02-standards/testing/
    defines what must be proven and whether the proof is valid

docs/02-standards/coding/Test Implementation Standards.md
    defines how the test source is implemented
```

When this standard conflicts with the Testing Standards suite on proof meaning, environment validity, protected evidence, or delivery gates, the Testing Standards suite controls.

When this standard conflicts with Repository Naming Standards on names or paths, Repository Naming Standards controls.

## 2. Scope And Routing

### 2.1. This standard owns

This standard owns repository-specific coding rules for:

- PHP test-file construction;
- PHPUnit and Laravel test-class selection;
- test placement beneath the smallest clear owner;
- test setup and teardown code;
- owner-local test support code;
- framework fakes and doubles in test source;
- factories, scenario builders, seeders, and fixtures as test implementation;
- browser-test source;
- stable browser selectors as test implementation hooks;
- datasets and parameterized test source;
- test discovery and suite registration;
- generated test completion;
- custom assertion-helper construction;
- test-source review.

### 2.2. This standard does not own

This standard does not define:

- `AC-*` acceptance criteria;
- `PF-*` proof declarations;
- proof purpose, method, level, or applicability;
- `PASS`, `EXPECTED_NONPASS`, or `FAIL`;
- initial-proof requirements;
- protected-baseline acceptance;
- permitted proof revisions;
- material evidence and retention;
- delivery gates;
- which environment proves a criterion;
- PostgreSQL equivalence rules;
- test-double selection policy;
- general assertion-quality policy;
- exact test and fixture naming;
- UI accessibility requirements;
- security-control requirements;
- application behavior;
- schema behavior;
- operational procedures.

Route those topics to:

| Topic                                                                       | Canonical owner                                                                                                                                                     |
| --------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Proof design, identifiers, results, and protected baselines                 | [Verification Contract And Evidence Standards](../testing/verification-contract-and-evidence-standards.md)                                                          |
| Shared testing taxonomy and levels                                          | [Testing And Verification Standards](../testing/testing-and-verification-standards.md)                                                                              |
| Automated test design, doubles, assertions, and coverage                    | [Automated And Static Testing Standards](../testing/automated-and-static-testing-standards.md)                                                                      |
| Environments, PostgreSQL, data, fixtures, isolation, and cleanup            | [Test Environments, Data, And Fixtures Standards](../testing/test-environments-data-and-fixtures-standards.md)                                                      |
| Cross-owner, system, end-to-end, and acceptance proof                       | [Integration, System, And Acceptance Testing Standards](../testing/integration-system-and-acceptance-testing-standards.md)                                          |
| Reliability, concurrency, performance, compatibility, and operational proof | [Reliability, Performance, Compatibility, And Operational Testing Standards](../testing/reliability-performance-compatibility-and-operational-testing-standards.md) |
| Browser, UI, accessibility, and visual proof                                | [UI, Accessibility, And Interaction Testing Standards](../testing/ui-accessibility-and-interaction-testing-standards.md)                                            |
| Evidence reporting and gates                                                | [Test Reporting And Delivery Gates Standards](../testing/test-reporting-and-delivery-gates-standards.md)                                                            |
| Exact names and path conventions                                            | [Repository Naming Standards](repository-naming-standards.md)                                                                                                       |
| PHP and Laravel source style                                                | [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)                                                                                       |
| File construction and ownership                                             | [File Building Standards](File%20Building%20Standards.md)                                                                                                           |
| Implementation readiness                                                    | [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md)                                                                                             |

## 3. Approved Test Runners And Configuration

Use the repository-installed runner and its committed configuration.

Current runner families are:

| Test source                                            | Runner and configuration                                                                |
| ------------------------------------------------------ | --------------------------------------------------------------------------------------- |
| Isolated PHP unit tests                                | PHPUnit through the installed Composer and Laravel test tooling                         |
| Laravel application tests                              | PHPUnit through `php artisan test` and `phpunit.xml`                                    |
| UI PHP tests                                           | PHPUnit through the configured UI testsuite                                             |
| Browser and JavaScript interaction specs               | Playwright through `npm run test:browser` and `playwright.config.js`                    |
| Node-based validators, generators, and inventory tools | Owner-local Node test scripts registered through repository package scripts when stable |

Do not introduce:

- Pest;
- Jest;
- Vitest;
- Cypress;
- another browser runner;
- another assertion library;
- another test-discovery system;

without an accepted dependency and architecture decision.

A local developer preference does not justify a second test framework.

Runner configuration is production-adjacent verification infrastructure.

Changes to:

- `phpunit.xml`;
- `playwright.config.js`;
- Composer test scripts;
- npm test scripts;
- test bootstrap;
- suite discovery;
- coverage configuration;
- global test environment;

require explicit scope and applicable verification.

## 4. Test Placement And Ownership

### 4.1. Smallest clear owner

Place each test with the smallest clear owner of the behavior being verified.

Test placement communicates ownership.

Do not place tests in a generic shared folder merely because multiple files participate in the behavior.

A cross-owner test belongs to the owner of the accepted workflow, consumer integration, system boundary, or acceptance proof defined by the verification contract.

Test placement must remain compatible with configured discovery.

### 4.2. Root application tests

Use the root application test tree for application-owned tests discovered through the root PHPUnit configuration.

Current root test types include:

```text
tests/Unit/
tests/Feature/
tests/Browser/
```

Use:

- `tests/Unit/` for isolated PHP behavior that does not require Laravel application boot;
- `tests/Feature/` for Laravel application, route, middleware, authorization, persistence, registration, and owner integration behavior;
- `tests/Browser/` for application-level Playwright workflows when no more specific accepted owner-local browser location applies.

Do not treat `Feature` as a product-owner name.

A feature test is still placed beneath a meaningful owner or responsibility directory.

### 4.3. Core capability tests

Place Core capability tests beneath the accepted Core owner structure supported by repository architecture and runner discovery.

The path should make the capability owner and test level clear without repeating every owner word in every class name.

Do not place new canonical tests under transitional `Platform` paths merely because older tests use them.

When the target test topology for a capability is not accepted or not discoverable, stop rather than inventing a new tree.

### 4.4. Module tests

Module-owned behavior belongs with the Module package.

A Module test must not require direct access to another owner’s private:

- Model;
- repository;
- table;
- Action;
- Query implementation;
- service;
- Registry internals.

Cross-owner behavior must use public Contracts.

Do not duplicate a Core test inside every Module.

Do not place Module business tests in the root application test tree merely for convenience when the accepted package topology provides Module-local tests.

### 4.5. UI tests

UI test source follows the UI owner and configured discovery.

Applicable UI tests may remain:

- owner-local with the Element, Component, Pattern, or Layout;
- in a configured UI testsuite;
- in an accepted UI browser-spec location;
- in an application feature test when the behavior belongs to a Core capability or Module presentation surface rather than reusable UI.

A file under `resources/` is not automatically UI-owned.

Route-owned presentation tests remain with the Core capability or Module that owns the page behavior.

### 4.6. Browser tests

Browser specs use the repository’s configured Playwright discovery.

Place application workflow specs under the accepted browser test root.

Owner-local UI interaction specs may remain beside their UI owner when the Playwright configuration discovers that location.

Do not place browser specs under:

- reference-only paths;
- generated evidence paths;
- vendor paths;
- arbitrary documentation folders;
- production JavaScript directories without an accepted owner-local test convention.

### 4.7. Tooling and script tests

Tests for repository tooling belong with the tooling owner.

Use deterministic fixtures near the tool’s test source or in the tool’s accepted fixture tree.

A validator, generator, inventory collector, renderer, or migration tool should have a bounded self-test that exercises its delivered entry point.

Do not make application tests responsible for proving unrelated repository tooling.

## 5. PHP Test File Construction

PHP test files must follow PHP and Laravel style standards.

Use:

```php
<?php

declare(strict_types=1);
```

New PHP test files must:

- declare strict types;
- use one test class per file;
- use explicit imports;
- remove unused imports;
- use the exact namespace matching autoload and placement;
- use a final class unless intentional test-class inheritance is required;
- use explicit `void` return types for test methods;
- use trailing commas in multiline arrays and argument lists;
- avoid broad file headers;
- avoid unresolved placeholders;
- avoid commented-out tests;
- avoid disabled alternate implementations.

Generic PHP test files identify themselves through:

- namespace;
- class name;
- test method names;
- placement;
- proof mapping outside the source when required.

Do not add a large comment block repeating the issue or verification contract.

Use comments only when they explain:

- a non-obvious test harness constraint;
- a deliberately unusual fixture;
- a required framework workaround;
- why a real boundary cannot be used in this specific test;
- a subtle concurrency or timing coordination point.

Comments must not conceal missing assertions.

## 6. Base Test Classes, Traits, And Shared Support

### 6.1. PHPUnit base

Use `PHPUnit\Framework\TestCase` for isolated PHP tests that do not require:

- Laravel boot;
- the service container;
- configuration;
- facades;
- database access;
- framework Events, Jobs, Notifications, mail, cache, storage, or HTTP.

A unit test should not extend the Laravel application base merely to obtain convenience helpers.

### 6.2. Laravel application base

Use `Tests\TestCase` for tests requiring Laravel application behavior.

Examples include:

- routes;
- middleware;
- Form Requests;
- policies and gates;
- service-container bindings;
- configuration;
- Eloquent;
- database transactions;
- framework Events;
- Jobs;
- Notifications;
- mail;
- cache;
- storage;
- application services wired through the container.

Extending `Tests\TestCase` does not by itself make a test a capability, integration, or system proof.

The verification contract defines the claimed level.

### 6.3. Specialized bases and traits

Create a specialized test base or trait only when one repeated technical concern justifies it.

Examples may include:

- authenticated browser harness;
- PostgreSQL migration harness;
- deterministic queue-worker harness;
- reusable external-protocol sandbox;
- one owner’s repeated actor setup.

A specialized base or trait must:

- have one clear concern;
- have one clear owner;
- expose meaningful setup;
- avoid hidden broad state;
- preserve parent setup and teardown;
- remain compatible with runner discovery;
- not bypass the boundary the test claims to prove.

Do not create a deep test inheritance hierarchy.

Prefer composition, factories, scenario builders, and explicit helper methods over multi-level inheritance.

### 6.4. Shared helper boundaries

Do not place owner-specific behavior in the global `Tests\TestCase`.

A global helper is justified only when it is:

- cross-owner;
- mechanical;
- stable;
- broadly required;
- independent from one feature’s policy.

Owner-specific actor, permission, fixture, route, or workflow helpers belong with that owner’s tests.

Do not move a helper into production `app/` solely to make tests convenient.

Production seams must have a real application responsibility.

## 7. Test Method Construction

### 7.1. One coherent behavior

Each test method should prove one coherent accepted behavior.

One coherent behavior may require multiple assertions.

Examples include:

- response plus durable state;
- rejection plus unchanged state;
- mutation plus Event and audit evidence;
- Job completion plus idempotent side effects;
- browser interaction plus accessible state.

Do not combine unrelated criteria merely to reduce test count.

Split a test when:

- failures would be ambiguous;
- setup states materially differ;
- different owners are being proven;
- different environments are required;
- one branch could pass while another branch is never reached.

### 7.2. Arrange, act, and assert

Make meaningful setup, action, and expectation visible.

Use blank lines or small private helpers to separate:

1. actor and fixture setup;
2. public action;
3. observable assertions.

Do not add `// Arrange`, `// Act`, and `// Assert` comments mechanically when the structure is already clear.

Do not hide the actor, target, state, or expected outcome inside a generic helper.

### 7.3. Public entry points

Call the public entry point appropriate to the proof.

Examples:

- HTTP route;
- public Action or Query Contract;
- public service interface;
- command;
- Event or Job dispatch boundary;
- Registry Extension Point;
- browser interaction;
- application operation.

Do not invoke a private method, protected method, provider-private repository, or concrete Handler merely to avoid setup.

Direct construction is appropriate for true unit tests of public object behavior.

Direct controller-method invocation does not prove routing, middleware, request validation, or response integration.

### 7.4. Expected failure and rejection

Use runner-native exception expectations only when the exception itself is the public observable Contract.

When application behavior translates a failure into:

- a response;
- redirect;
- validation error;
- domain result;
- failed Job;
- audit event;
- user-visible error;

assert that public result instead of only asserting the internal exception.

A test must not catch an exception merely to keep running unless it asserts the accepted translation or cleanup.

## 8. Setup, Teardown, And State Isolation

### 8.1. Setup

Use `setUp()` only for prerequisites shared by every test in the class.

Always call:

```php
parent::setUp();
```

before using framework state.

Keep criterion-specific setup in the test or a clearly named helper.

Avoid setup that silently:

- authenticates an actor;
- grants broad permissions;
- seeds unrelated data;
- fakes framework services;
- disables middleware;
- freezes time;
- changes global configuration.

When shared setup performs one of those actions, the class name, helper name, or explicit test code must make it visible.

### 8.2. Teardown

Clean up state owned by the test.

Applicable cleanup includes:

- frozen time;
- temporary files and directories;
- environment overrides;
- process handles;
- workers;
- mock servers;
- open transactions;
- cached static state;
- global registries;
- configuration overrides;
- external sandbox records when required.

Always call:

```php
parent::tearDown();
```

after owned cleanup unless a framework-specific requirement defines another safe order.

Cleanup failure is a test failure when it compromises isolation or evidence.

### 8.3. Global state

Avoid mutable global or static test state.

A test must not depend on:

- prior execution order;
- another test’s database rows;
- another test’s cache;
- another test’s files;
- previously seeded permissions;
- a developer’s local environment;
- a previous browser session;
- random test ordering.

Reset static caches and singletons when the production design requires them and the test mutates them.

Do not use process-global state as a shortcut for explicit fixtures.

### 8.4. Middleware and framework adaptations

A shared base test may apply a repository-wide test-only adaptation only when that adaptation is accepted and documented.

Examples may include disabling a middleware that ordinary feature tests are not intended to prove.

A proof claiming the adapted behavior must:

- re-enable the middleware;
- use a dedicated test base;
- use a dedicated application configuration; or
- execute through another valid environment.

Do not claim CSRF, authentication, authorization, rate limiting, session, or security-header behavior from a harness that disables that behavior.

## 9. Laravel Application-Test Implementation

### 9.1. HTTP and route tests

Use Laravel’s HTTP test APIs for application routes.

Assert applicable:

- response status;
- redirect destination;
- validation errors;
- session state;
- rendered content or view data;
- database state;
- Events, Jobs, Notifications, or audit effects;
- unchanged state on rejection.

Prefer named routes over hard-coded URLs when route-name stability is part of the accepted Contract.

Use hard-coded URLs when URL shape itself is being verified.

Do not call controller methods directly when the criterion includes:

- routing;
- middleware;
- Form Request validation;
- authorization integration;
- route model binding;
- sessions;
- redirects;
- response serialization.

### 9.2. Actions, Queries, policies, and services

Construct or resolve the public subject appropriate to the test level.

For an isolated unit test:

- construct dependencies explicitly;
- use small real collaborators when practical;
- avoid Laravel boot.

For a Laravel application test:

- resolve the public Contract through the container when binding and registration are part of the behavior;
- call the public Action, Query, policy, or service boundary;
- avoid provider-private Models or repositories from another owner.

Do not assert private collaborator calls when the observable result is sufficient.

### 9.3. Container, configuration, and providers

When testing bindings or provider registration:

- boot the application;
- resolve the public Contract;
- assert the expected implementation or observable behavior;
- verify missing or conflicting registration when applicable.

Do not bind a replacement implementation in the test and then claim the production provider is registered correctly.

Use `config()->set()` for bounded test configuration.

Do not call `env()` in test methods.

Restore configuration when the framework harness does not isolate it automatically.

### 9.4. Responses, redirects, sessions, and validation

Use focused Laravel assertions.

Do not rely on a status code alone when the criterion includes state or side effects.

For validation rejection, assert applicable:

- exact field;
- accepted rule outcome;
- unchanged durable state;
- no prohibited side effect.

For redirects, assert the accepted route or URL and any required session message.

Avoid asserting full rendered HTML when focused semantic or content assertions are sufficient.

## 10. Database-Aware Test Implementation

### 10.1. Ordinary persistence tests

Use the repository’s accepted PostgreSQL test environment for application-persistence behavior.

`RefreshDatabase` is appropriate for ordinary Laravel persistence tests when:

- committed cross-process visibility is not part of the proof;
- migration behavior is not the target;
- locking is not the target;
- concurrency is not the target;
- after-commit timing is not the target.

Use factories and application entry points to create state.

Assert the smallest durable state that proves the criterion.

Do not make tests dependent on row ordering unless ordering is part of the Contract.

### 10.2. Commit, concurrency, migration, and locking tests

Do not rely on a wrapping test transaction when the proof concerns:

- commit visibility;
- after-commit behavior;
- separate connections;
- worker processes;
- migration execution;
- DDL;
- locks;
- deadlocks;
- concurrent operations;
- process failure;
- rollback after interruption.

Use the isolation strategy declared by the environment and verification standards.

Test code should make:

- connection identity;
- transaction boundaries;
- synchronization points;
- cleanup;
- final durable state;

explicit.

Do not coordinate concurrency only through arbitrary sleep durations.

### 10.3. Direct database access

Prefer application operations and Eloquent or accepted repository boundaries for behavior tests.

Direct database access is appropriate for:

- schema assertions;
- migration proof;
- fixture setup that accepted production APIs cannot represent;
- cleanup;
- targeted database integration behavior;
- verification of a database Contract.

Do not use direct table writes to bypass:

- validation;
- authorization;
- owner invariants;
- Events;
- Jobs;
- audit behavior;
- public Contracts;

when those behaviors are part of the criterion.

A direct invalid-state fixture must be clearly named and bounded.

## 11. Factories, Scenario Builders, Seeders, And Fixtures

### 11.1. Factories

Use factories to create valid owner-local records.

Factories should:

- honor accepted defaults;
- expose named states;
- keep important lifecycle and permission state visible;
- avoid unrelated record creation;
- avoid broad hidden seeding;
- remain deterministic.

Prefer:

```php
User::factory()->inactive()->create();
```

over creating a default record and mutating several unrelated fields in the test.

Do not add a factory state that represents behavior the canonical feature or schema does not accept.

### 11.2. Scenario builders

Use a scenario builder when repeated tests need the same meaningful multi-record or multi-owner arrangement.

A scenario builder should return a typed object or explicit named records rather than one unstructured array.

The builder must make visible:

- actor;
- target;
- scope;
- permissions;
- lifecycle state;
- relevant owner boundaries.

Do not create a universal application scenario builder.

Keep scenario builders with the smallest owner that uses them.

### 11.3. Seeders

Use seeders in tests only when the seeded baseline is itself an accepted shared application baseline.

Examples may include:

- stable role and permission registry;
- application-required definitions;
- accepted system defaults.

Do not run a broad application seeder to avoid creating focused fixtures.

A test relying on a seeder should identify which seeded contract it needs.

Seeders must not hide the action being tested.

### 11.4. Fixtures

Use fixtures for stable:

- payloads;
- files;
- schemas;
- protocol messages;
- expected reports;
- snapshots;
- invalid-state examples.

Keep fixtures:

- deterministic;
- minimal;
- versioned when their provider Contract is versioned;
- free of secrets and production data;
- close to their owner;
- clearly named by condition or expected outcome.

Do not update an expected-output fixture automatically without reviewing the difference.

A fixture used by a protected baseline is protected test source when changing it can alter proof meaning.

## 12. Test Doubles And Laravel Fakes

### 12.1. General rule

Double selection is governed by Automated And Static Testing Standards.

In test code:

- replace only the boundary intentionally excluded from the proof;
- type the replacement to the same public Contract;
- keep behavior explicit;
- avoid broad default success responses;
- model accepted rejection and failure when required;
- do not make the double a competing API authority.

A passing fake-backed test proves only the behavior inside the fake-backed boundary.

### 12.2. Events

Use an Event fake when proving:

- dispatch decision;
- Event identity;
- payload;
- absence of a prohibited Event.

Do not fake Events when the proof claims:

- Listener execution;
- transaction timing;
- downstream state;
- external side effects;
- real event integration.

Use scoped faking when unrelated Events should continue executing.

### 12.3. Jobs and queues

Use a queue or Bus fake when proving:

- dispatch decision;
- Job identity;
- payload;
- queue selection;
- absence of prohibited dispatch.

Do not fake the queue when proving:

- worker execution;
- serialization across a process;
- retry;
- timeout;
- backoff;
- duplicate delivery;
- failed-job behavior;
- committed-state visibility.

Do not call a Job Handler directly and claim queue integration.

### 12.4. Notifications and mail

Use Notification or Mail fakes when proving:

- dispatch decision;
- recipient;
- channel;
- payload;
- absence of prohibited delivery intent.

Do not claim:

- provider delivery;
- rendered email compatibility;
- queue transport;
- retry;
- bounce handling;
- external account configuration;

from a framework fake.

### 12.5. Filesystems, cache, and HTTP

Use a fake filesystem when real filesystem semantics are not material.

Use a real temporary filesystem or native environment when proving:

- permissions;
- locks;
- paths;
- atomic moves;
- process visibility;
- platform behavior.

Use a cache fake or array store only when real cache behavior is not material.

Use HTTP fakes for client request construction and response handling.

Do not use HTTP fakes as the only proof of provider compatibility, authentication, signing, timeout, or production configuration.

### 12.6. Mocking

Mock only public interactions that are themselves part of the accepted Contract.

Do not:

- mock the subject under test;
- mock private methods;
- use partial mocks to bypass real behavior;
- set broad permissive expectations;
- verify incidental call order unless order is required;
- mock framework behavior claimed by the proof;
- mock a database transaction claimed by the proof;
- mock browser behavior claimed by the proof.

Prefer a small fake or real deterministic collaborator over a complex mock graph.

## 13. Authentication, Authorization, And Security-Test Code

Security-sensitive test code must keep actor and target state explicit.

Create the narrowest actor required by the criterion.

Do not use a Super Administrator merely to simplify setup when the criterion concerns a narrower permission.

Use clearly named helpers such as:

```text
actingAsUserWithPermission
actingAsUserWithoutPermission
inactiveUser
wrongTenantUser
expiredCredential
```

only when the helper’s granted state is visible and bounded.

Test applicable:

- unauthenticated actor;
- authenticated actor without access;
- correctly authorized actor;
- wrong target;
- wrong accepted scope;
- inactive or suspended identity;
- stale or insufficient assurance;
- revoked or expired credential.

For denied behavior, assert applicable:

- public denial;
- unchanged durable state;
- no prohibited Event;
- no prohibited Job;
- no prohibited Notification;
- no sensitive output;
- required audit or monitoring evidence.

Do not test authorization by calling a protected Action after manually bypassing its authorization boundary unless another proof owns the route or policy integration.

Do not expose real secrets, tokens, recovery codes, cookies, authorization headers, or personal data in test output or browser artifacts.

Security-control requirements remain with Security Testing Standards.

## 14. Events, Jobs, Schedulers, And Asynchronous Test Code

Separate test source by the asynchronous layer being proven.

Applicable layers include:

1. declaration and registration;
2. dispatch decision;
3. serialization;
4. worker or Listener execution;
5. retry and terminal failure;
6. transaction and after-commit visibility;
7. monitoring and operator evidence.

Do not combine every layer into one opaque test.

For Job or Listener execution tests:

- invoke the public execution boundary appropriate to the claimed level;
- use real dependencies when their behavior is part of the criterion;
- assert durable effects;
- assert prohibited duplicate effects;
- clean up worker and process state.

For scheduler tests:

- assert registration separately from command or Job behavior;
- do not treat scheduler registration as proof that the scheduled operation succeeds.

For idempotency tests:

- execute the operation more than once;
- assert one accepted durable outcome;
- assert side-effect behavior;
- distinguish sequential from concurrent duplicates.

## 15. Browser And UI Test Implementation

### 15.1. Playwright source

Use the installed Playwright runner and current repository configuration.

Browser specs use the configured `.spec.js` discovery convention.

Do not add another browser or JavaScript test runner without approval.

A browser spec should declare or make discoverable:

- target route or surface;
- actor state;
- content or fixture state;
- viewport when material;
- browser project when material;
- expected interaction;
- expected final state.

### 15.2. User-observable interaction

Perform user-observable interaction.

Use:

- navigation;
- accessible control activation;
- keyboard input;
- pointer input;
- form completion;
- visible state;
- browser history;
- download behavior;
- public DOM state.

Do not:

- call private JavaScript functions;
- invoke internal controllers directly;
- mutate component internals from the page context;
- set final DOM state manually;
- bypass the UI action solely to make the spec pass.

### 15.3. Selectors

Prefer selectors based on accepted semantics:

1. role and accessible name;
2. label;
3. placeholder when contractually stable;
4. visible text when uniquely meaningful;
5. accepted public `data-ui-*` or test hook;
6. stable CSS selector only when the UI Contract owns it.

Avoid selectors based on:

- DOM position;
- `nth-child`;
- generated framework wrappers;
- incidental class order;
- private implementation IDs;
- broad text that appears in multiple locations;
- transient animation classes.

Do not add a production test hook without a clear stable owner.

A test hook must not expose sensitive state or become a hidden business API.

### 15.4. Waiting and timing

Use Playwright’s assertions and auto-waiting.

Wait for an observable condition such as:

- URL;
- role;
- text;
- state attribute;
- response;
- download;
- stable final UI state.

Do not use arbitrary fixed sleeps as the primary synchronization mechanism.

A bounded delay is acceptable only when the timing itself is part of the accepted behavior and the proof documents why.

### 15.5. Browser data and authentication

Use isolated browser actors and data.

Do not depend on:

- a developer’s existing session;
- manually created shared records;
- production accounts;
- persistent browser storage from another spec;
- execution order.

Create or provision the actor through an accepted test setup boundary.

Do not bypass the authentication flow when authentication is part of the criterion.

A storage-state shortcut may be used when authentication is not the target and the shortcut is isolated, safe, and declared.

### 15.6. Browser evidence safety

Browser traces, screenshots, videos, DOM snapshots, and network logs may contain sensitive information.

Test source and configuration must prevent retention of:

- passwords;
- MFA material;
- recovery codes;
- tokens;
- cookies;
- authorization headers;
- private personal data;
- unrestricted server logs.

Use synthetic data.

Redact or omit sensitive evidence at the source rather than relying only on later cleanup.

## 16. Time, Randomness, Identifiers, And External State

Control time when behavior depends on:

- expiry;
- scheduling;
- retention;
- token lifetime;
- MFA;
- recent authentication;
- retry;
- backoff;
- lifecycle transitions.

Use Laravel or Carbon-supported time controls.

Always restore frozen time.

Do not use the local machine clock as an implicit expectation.

Control randomness when reproducibility matters.

Record or fix seeds for generated cases when applicable.

Do not assert an exact random identifier unless:

- the identifier is injected;
- the identifier is part of the Contract;
- the test uses a deterministic generator.

Prefer asserting:

- valid shape;
- uniqueness;
- stable relationship;
- persistence;
- public result;

over incidental exact random values.

External state must be isolated through:

- accepted sandbox;
- protocol fixture;
- mock server;
- service virtualization;
- temporary resource;
- owner-controlled test account.

Do not mutate a shared external environment without explicit authorization and cleanup.

## 17. Datasets And Parameterized Cases

Use datasets when multiple cases share:

- the same setup shape;
- the same public action;
- the same assertion structure;
- one meaningful varying condition.

Keep materially different workflows in separate tests.

Dataset cases should identify:

- condition;
- rejection reason;
- boundary;
- expected outcome.

Avoid opaque numeric case names.

The failing output must make the case understandable without opening the provider method.

Do not use a dataset to hide:

- different actors;
- different owners;
- different environments;
- different side effects;
- materially different assertions.

Follow the installed PHPUnit API.

Do not introduce deprecated metadata annotations when the current runner provides supported attributes or method conventions.

A dataset used by a protected proof is protected when changing its cases changes coverage or proof meaning.

## 18. Assertions And Custom Assertion Helpers

General assertion-quality rules belong to Automated And Static Testing Standards.

Test-source rules:

- keep expected values visible;
- prefer focused assertions;
- assert public outcomes;
- assert unchanged state on rejection;
- assert prohibited side effects when material;
- use framework-native assertions when they express the behavior clearly.

Create a custom assertion helper only when it:

- repeats across multiple tests;
- represents one stable accepted concept;
- produces a more actionable failure;
- does not hide expected values;
- has one owner.

A custom assertion should accept the expected state explicitly when practical.

Avoid helpers such as:

```text
assertEverythingIsCorrect
assertValidResponse
assertUserState
```

when the helper conceals which conditions are required.

Custom assertion helpers should themselves be tested when their logic is non-trivial.

## 19. Templates, Generated Tests, And Incomplete Scaffolds

Use approved test stubs under `stubs/tests/` when their archetype matches the required file.

A generated test is scaffolding until:

- every placeholder is replaced;
- applicable `markTestIncomplete()` calls are replaced with meaningful assertions;
- inapplicable scaffold methods are removed;
- imports and namespace are correct;
- actor and fixture state are explicit;
- the target path executes;
- the test is discoverable;
- formatting and syntax checks pass.

Do not commit required behavior with:

- unresolved placeholders;
- `markTestIncomplete()`;
- unconditional assertions;
- empty test bodies;
- placeholder fixtures;
- commented-out expectations;
- `test_expected_behavior` as the final method name.

A test generator must not invent:

- requirements;
- permissions;
- schema;
- public APIs;
- expected values;
- browser selectors;
- fixture meaning.

Generated output remains subject to protected-baseline rules once accepted as proof.

## 20. Discovery, Suites, Groups, And Selection

Every test must be discovered by the authoritative runner without a manual aggregator.

Use:

- named PHPUnit suites for stable test types;
- filesystem paths for owner selection;
- groups for orthogonal execution characteristics;
- Playwright discovery for `.spec.js` browser and interaction tests.

Do not create:

- manual `index.php` test aggregators;
- duplicate suite entries that execute one test twice;
- owner-by-type suite explosion;
- a group that duplicates an owner path;
- a hidden test root not registered with the runner;
- a filename that bypasses configured discovery.

When adding a new accepted test root:

1. identify its owner and reason;
2. update the authoritative runner configuration;
3. prove discovery;
4. prove no duplicate execution;
5. update applicable documentation and templates.

Do not narrow a command or suite merely to exclude a failing protected test.

## 21. Protected Test Source

A test, fixture, factory state, scenario builder, dataset, helper, mock server, snapshot, or review procedure may become protected verification evidence.

Once accepted as part of a protected baseline:

- do not weaken it;
- do not skip it;
- do not delete it;
- do not move it out of discovery;
- do not narrow its data cases;
- do not change its actor or scope;
- do not replace a real boundary with a fake;
- do not change expected behavior to match implementation.

The verification contract determines:

- baseline identity;
- protected semantics;
- permitted mechanical edits;
- required hashes;
- material revision authority.

This coding standard does not authorize a protected-proof edit.

Before changing protected test source, read the applicable verification contract.

## 22. Test-Code Review Checklist

Before accepting test source, confirm:

### Ownership and placement

- the smallest clear owner is identified;
- the file is in an accepted discovered path;
- no transitional or generic owner was invented;
- cross-owner access uses public Contracts.

### PHP or JavaScript source

- strict types are present for PHP;
- imports are explicit and used;
- the class or spec name follows Repository Naming Standards;
- methods or cases describe behavior;
- no unresolved placeholders remain;
- no required test remains incomplete or focused-only.

### Setup and isolation

- actor and fixture state are visible;
- setup does not grant hidden broad access;
- cleanup restores owned state;
- time and randomness are controlled when material;
- the test does not depend on execution order.

### Test boundary

- the public entry point executes;
- doubles replace only excluded boundaries;
- framework fakes do not support a broader claim than they prove;
- middleware relevant to the criterion is active;
- direct database writes do not bypass behavior being claimed.

### Assertions

- observable success is asserted;
- applicable rejection is asserted;
- unchanged state is asserted on denial or failure;
- material side effects and prohibited side effects are asserted;
- failure messages remain actionable.

### Discovery and maintenance

- the authoritative runner discovers the test;
- the test is not executed twice;
- no broad base-class or shared-helper coupling was introduced;
- protected baseline rules were followed;
- applicable formatting and syntax checks pass.

## 23. Prohibited Patterns

Do not:

- create a second testing authority under `coding/`;
- define `PASS`, `EXPECTED_NONPASS`, or `FAIL` here;
- define proof applicability or delivery gates here;
- introduce a new test framework without approval;
- place tests in a generic ownerless dumping ground;
- create new tests under transitional `Platform` ownership as a target convention;
- use Laravel boot for a pure unit test only for convenience;
- place owner-specific helpers in global `Tests\TestCase`;
- create deep test-class inheritance;
- hide actor, target, scope, or permission state in generic helpers;
- disable middleware relevant to the proof;
- invoke private implementation instead of the public entry point;
- directly mutate final browser DOM state;
- use arbitrary sleeps for synchronization;
- mock the subject under test;
- mock a boundary the proof claims to verify;
- use a fake to claim real worker, provider, filesystem, browser, or database behavior;
- use broad seeders instead of focused fixtures;
- use production data or secrets;
- depend on test execution order;
- automatically regenerate expected outputs or visual baselines;
- leave required tests incomplete, skipped, focused-only, or undiscovered;
- narrow test selection to hide a failure;
- modify protected test source without the required verification-contract authority;
- add production-only test hooks without a real owned application purpose;
- duplicate exact naming rules already owned by Repository Naming Standards.

## 24. Related

- [Testing Standards Index](../testing/index.md)
- [Testing And Verification Standards](../testing/testing-and-verification-standards.md)
- [Verification Contract And Evidence Standards](../testing/verification-contract-and-evidence-standards.md)
- [Automated And Static Testing Standards](../testing/automated-and-static-testing-standards.md)
- [Test Environments, Data, And Fixtures Standards](../testing/test-environments-data-and-fixtures-standards.md)
- [Integration, System, And Acceptance Testing Standards](../testing/integration-system-and-acceptance-testing-standards.md)
- [Reliability, Performance, Compatibility, And Operational Testing Standards](../testing/reliability-performance-compatibility-and-operational-testing-standards.md)
- [UI, Accessibility, And Interaction Testing Standards](../testing/ui-accessibility-and-interaction-testing-standards.md)
- [Test Reporting And Delivery Gates Standards](../testing/test-reporting-and-delivery-gates-standards.md)
- [Security Testing Standards](../security/Security%20Testing%20Standards.md)
- [Repository Naming Standards](repository-naming-standards.md)
- [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [Code Template And Generator Standards](Code%20Template%20And%20Generator%20Standards.md)
- [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Stub Templates](../../../stubs/README.md)
- [PHPUnit Configuration](../../../phpunit.xml)
- [Playwright Configuration](../../../playwright.config.js)
- [Composer Configuration](../../../composer.json)
- [npm Configuration](../../../package.json)

<!--
DOC-META
title: Laravel And Database Test Implementation Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/test-implementation/laravel-and-database-test-implementation-standards.md
parent: docs/02-standards/coding/test-implementation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines setup, teardown, Laravel application-test source, HTTP and container testing, PostgreSQL-aware persistence tests, transaction-sensitive test code, and direct database access rules.
-->

# Laravel And Database Test Implementation Standards

Parent: [Test Implementation Standards Index](index.md)

- [1. Purpose And Scope](#1-purpose-and-scope)
- [2. Setup, Teardown, And State Isolation](#2-setup-teardown-and-state-isolation)
- [3. Laravel Application-Test Implementation](#3-laravel-application-test-implementation)
  - [3.1. HTTP and route tests](#31-http-and-route-tests)
  - [3.2. Actions, Queries, policies, and services](#32-actions-queries-policies-and-services)
  - [3.3. Container, configuration, and providers](#33-container-configuration-and-providers)
  - [3.4. Responses, redirects, sessions, and validation](#34-responses-redirects-sessions-and-validation)
- [4. Database-Aware Test Implementation](#4-database-aware-test-implementation)
  - [4.1. Ordinary persistence tests](#41-ordinary-persistence-tests)
  - [4.2. Commit, concurrency, migration, and locking tests](#42-commit-concurrency-migration-and-locking-tests)
  - [4.3. Direct database access](#43-direct-database-access)
- [5. Prohibited Patterns](#5-prohibited-patterns)
- [6. Review](#6-review)
- [7. Related](#7-related)

## 1. Purpose And Scope

Define how Laravel and PostgreSQL-aware test source is implemented after the verification contract has selected the required proof and environment.

This standard owns source mechanics for:

- shared Laravel test setup and teardown;
- middleware and framework adaptations;
- HTTP and route test code;
- public Actions, Queries, policies, and Services under Laravel boot;
- container bindings, configuration, and providers;
- response, redirect, session, and validation assertions;
- ordinary PostgreSQL-backed persistence tests;
- commit, concurrency, migration, DDL, locking, and separate-connection test code;
- bounded direct database access in tests.

It does not define which database or Laravel proof is required. Use the [Testing Standards Index](../../testing/index.md) and applicable database Contracts for proof selection and expected behavior.

## 2. Setup, Teardown, And State Isolation

Use `setUp()` only for prerequisites shared by every test in the class.

Call:

```php
parent::setUp();
```

before using framework state.

Keep criterion-specific actor, fixture, permission, fake, or configuration setup in the test or a clearly named helper.

Avoid setup that silently:

- authenticates an actor;
- grants broad permissions;
- seeds unrelated data;
- fakes framework services;
- disables middleware;
- freezes time;
- changes global configuration.

When shared setup performs one of those actions, the base class, helper name, or explicit test source must make the behavior visible.

Clean up state owned by the test. Applicable cleanup includes:

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

Call:

```php
parent::tearDown();
```

after owned cleanup unless a framework-specific requirement defines another safe order.

Cleanup failure is a test failure when it compromises isolation or evidence.

Do not depend on prior execution order, another test's database rows or cache, a developer's local environment, a previous browser session, or random ordering.

Reset mutable static caches and singletons when production design requires them and the test mutates them.

A shared base test may apply a repository-wide test-only adaptation only when that adaptation is accepted and documented.

A proof claiming behavior that an adaptation disables must re-enable that behavior, use a dedicated base or configuration, or execute through another valid environment.

Do not claim CSRF, authentication, authorization, rate limiting, session, security-header, queue, or persistence behavior from a harness that disables or replaces the material boundary.

## 3. Laravel Application-Test Implementation

### 3.1. HTTP and route tests

Use Laravel's HTTP testing APIs for application routes.

Assert applicable observable outcomes, including:

- response status;
- redirect destination;
- validation errors;
- session state;
- rendered content or view data;
- durable state;
- Events, Jobs, Notifications, Audit, or Monitoring effects;
- unchanged state on rejection.

Prefer named routes when route-name stability is part of the accepted Contract.

Use the literal URL when URL shape itself is the behavior under test.

Do not call controller methods directly when the criterion includes routing, middleware, Form Request validation, authorization integration, route model binding, sessions, redirects, or response serialization.

Do not rely on a response status alone when the accepted behavior includes durable state, side effects, or denial invariants.

### 3.2. Actions, Queries, policies, and services

Construct or resolve the public subject appropriate to the declared proof.

For isolated unit source, construct dependencies explicitly and avoid Laravel boot unless framework integration is material.

For Laravel application tests:

- resolve the public Contract through the container when binding or registration is part of the behavior;
- call the public Action, Query, policy, Service, or other owner-controlled boundary;
- use the owning capability's accepted entry point;
- avoid provider-private Models, repositories, Actions, Queries, or Services from another owner.

Do not assert private collaborator calls when the public result is sufficient.

A consumer integration test must use the provider-owned public Contract rather than concrete provider implementation.

### 3.3. Container, configuration, and providers

When testing bindings or provider registration:

- boot the application;
- resolve the public Contract;
- assert the accepted binding or observable behavior;
- verify missing, duplicate, or conflicting registration when the contract requires rejection.

Do not bind a replacement implementation in the test and then claim the production provider is registered correctly.

Use `config()->set()` for bounded test configuration.

Do not call `env()` in test methods.

Restore configuration when the harness does not isolate it automatically.

Do not change repository configuration merely to make one test convenient when the behavior can be represented through owner-local fixtures or test setup.

### 3.4. Responses, redirects, sessions, and validation

Use focused Laravel assertions.

For validation rejection, assert applicable:

- the exact field or public error;
- the accepted rule outcome;
- unchanged durable state;
- absence of prohibited Events, Jobs, Notifications, or other side effects.

For redirects, assert the accepted route or URL and required session state when material.

For authenticated or authorized behavior, keep actor identity and target state explicit.

Avoid asserting full rendered HTML when focused semantic, view-data, or content assertions prove the accepted behavior more clearly.

Do not inspect framework-private response internals when public Laravel assertions express the Contract.

## 4. Database-Aware Test Implementation

### 4.1. Ordinary persistence tests

Use the repository's accepted PostgreSQL test environment for application-persistence behavior when PostgreSQL semantics are material.

`RefreshDatabase` is appropriate for ordinary Laravel persistence tests when the proof does not depend on:

- committed cross-process visibility;
- migration execution;
- DDL;
- locking;
- concurrency;
- separate connections;
- after-commit timing.

Use factories and owner-controlled application entry points to create valid state.

Assert the smallest durable state that proves the criterion.

Do not make tests depend on row ordering unless ordering is part of the public or database Contract.

Do not substitute SQLite for PostgreSQL-sensitive behavior merely for speed or convenience.

### 4.2. Commit, concurrency, migration, and locking tests

Do not rely on a wrapping test transaction when the proof concerns:

- commit visibility;
- after-commit behavior;
- separate connections;
- worker processes;
- migration execution;
- DDL;
- locks or deadlocks;
- concurrent operations;
- process failure;
- rollback after interruption.

Use the isolation strategy declared by the Testing Standards suite and applicable database standards.

Test source should make material:

- connection identity;
- transaction boundaries;
- synchronization points;
- process or worker ownership;
- cleanup;
- final durable state;

explicit.

Do not coordinate concurrency only through arbitrary sleep durations. Use a deterministic synchronization mechanism when possible.

Migration tests must execute the migration behavior that the proof claims to verify. Schema inspection alone does not prove an upgrade or rollback path when migration execution is material.

Do not run destructive or shared-environment migration tests without the environment and cleanup authority required by the verification contract.

### 4.3. Direct database access

Prefer application operations and Eloquent or accepted repository boundaries for behavior tests.

Direct database access is appropriate for bounded:

- schema assertions;
- migration proof;
- fixture setup that accepted production APIs cannot represent;
- cleanup;
- targeted database integration behavior;
- verification of a database Contract.

Do not use direct table writes to bypass validation, authorization, owner invariants, Events, Jobs, Audit behavior, public Contracts, or other behavior that the proof claims to verify.

A direct invalid-state fixture must be clearly named, minimal, and confined to the proof that requires it.

Cross-owner tests must not use direct provider-table access as a substitute for the provider's public Contract.

## 5. Prohibited Patterns

Do not:

- disable middleware that the proof claims to verify;
- replace production bindings and claim the production provider was tested;
- use `env()` inside test methods;
- rely on hidden global configuration or execution order;
- use a wrapping transaction for commit, migration, locking, or separate-process semantics;
- coordinate concurrency primarily through fixed sleeps;
- use direct database writes to bypass behavior being claimed;
- use SQLite-only proof for PostgreSQL-sensitive behavior;
- infer schema requirements from test code instead of the canonical database owner;
- reach into another owner's private persistence implementation.

## 6. Review

Before accepting Laravel or database test source, confirm:

- the declared environment can actually prove the claimed behavior;
- setup and teardown make material state visible and restore owned state;
- middleware and framework adaptations do not invalidate the proof;
- public Laravel entry points are exercised where applicable;
- container and provider tests use production registration when claiming production binding;
- persistence tests use PostgreSQL when required;
- transaction and concurrency tests expose the material boundaries explicitly;
- direct database access is bounded and does not bypass the behavior under test;
- cleanup is sufficient for repeatable local and CI execution.

Proof result and evidence sufficiency remain governed by the Testing Standards suite.

## 7. Related

- [Test Implementation Standards Index](index.md)
- [Test Source And Placement Standards](test-source-and-placement-standards.md)
- [Fixtures, Doubles, And Async Test Implementation Standards](fixtures-doubles-and-async-test-implementation-standards.md)
- [Test Source Lifecycle Standards](test-source-lifecycle-standards.md)
- [Testing Standards Index](../../testing/index.md)
- [Database Standards Index](../../database/index.md)
- [Repository Architecture](../../../03-architecture/repository-architecture.md)

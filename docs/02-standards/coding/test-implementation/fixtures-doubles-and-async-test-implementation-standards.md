<!--
DOC-META
title: Fixtures, Doubles, And Async Test Implementation Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/test-implementation/fixtures-doubles-and-async-test-implementation-standards.md
parent: docs/02-standards/coding/test-implementation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines source rules for factories, scenario builders, seeders, fixtures, Laravel fakes, mocks, security-sensitive setup, Events, Jobs, schedulers, and asynchronous test implementation.
-->

# Fixtures, Doubles, And Async Test Implementation Standards

Parent: [Test Implementation Standards Index](index.md)

- [1. Purpose And Scope](#1-purpose-and-scope)
- [2. Factories, Scenario Builders, Seeders, And Fixtures](#2-factories-scenario-builders-seeders-and-fixtures)
  - [2.1. Factories](#21-factories)
  - [2.2. Scenario builders](#22-scenario-builders)
  - [2.3. Seeders](#23-seeders)
  - [2.4. Fixtures](#24-fixtures)
- [3. Test Doubles And Laravel Fakes](#3-test-doubles-and-laravel-fakes)
  - [3.1. General rule](#31-general-rule)
  - [3.2. Events](#32-events)
  - [3.3. Jobs and queues](#33-jobs-and-queues)
  - [3.4. Notifications and mail](#34-notifications-and-mail)
  - [3.5. Filesystems, cache, and HTTP](#35-filesystems-cache-and-http)
  - [3.6. Mocking](#36-mocking)
- [4. Authentication, Authorization, And Security-Test Setup](#4-authentication-authorization-and-security-test-setup)
- [5. Events, Jobs, Schedulers, And Asynchronous Test Code](#5-events-jobs-schedulers-and-asynchronous-test-code)
- [6. Prohibited Patterns](#6-prohibited-patterns)
- [7. Review](#7-review)
- [8. Related](#8-related)

## 1. Purpose And Scope

Define how reusable test setup, test doubles, security-sensitive actor setup, and asynchronous test source are implemented after proof requirements have been selected.

This standard owns source mechanics for:

- factories;
- scenario builders;
- seeders used by tests;
- fixtures and expected-output artifacts;
- Laravel fakes;
- mocks and small explicit doubles;
- security-sensitive actor and target setup;
- Event and Job test code;
- queue, scheduler, retry, duplicate-delivery, and asynchronous test-source structure.

It does not decide which fixture, double, asynchronous level, or security proof is valid. Use the applicable [Testing Standards](../../testing/index.md), Security standards, feature Contracts, and flow owners for those decisions.

## 2. Factories, Scenario Builders, Seeders, And Fixtures

### 2.1. Factories

Use factories to create valid owner-local records.

Factories should:

- honor accepted defaults;
- expose meaningful named states;
- keep material lifecycle, permission, and scope state visible;
- avoid unrelated record creation;
- avoid broad hidden seeding;
- remain deterministic where the proof requires reproducibility.

Prefer a named state such as:

```php
User::factory()->inactive()->create();
```

over creating a generic record and mutating several unrelated fields in the test.

Do not add a factory state that represents behavior the canonical feature or schema does not accept.

Keep factory behavior with the owner of the record it constructs.

### 2.2. Scenario builders

Use a scenario builder when repeated tests require the same meaningful multi-record or multi-owner arrangement and inline setup would obscure the test.

A scenario builder should return a typed object or explicit named records rather than an unstructured array.

The builder must make material:

- actor;
- target;
- accepted scope;
- permissions;
- lifecycle state;
- relevant owner boundaries;

visible to the consuming test.

Do not create one universal application scenario builder.

Keep scenario builders with the smallest owner that uses them.

A cross-owner scenario builder must not bypass the public Contract that the proof claims to verify.

### 2.3. Seeders

Use seeders in tests only when the seeded baseline is itself an accepted shared application baseline.

Examples may include accepted:

- role or permission registries;
- required system definitions;
- system defaults;
- stable Registry-backed data.

Do not run a broad application seeder merely to avoid focused test setup.

A test relying on a seeder should make clear which seeded Contract it needs.

Seeders must not hide the action, lifecycle transition, or permission setup being tested.

### 2.4. Fixtures

Use fixtures for stable source artifacts such as:

- payloads;
- files;
- schemas;
- protocol messages;
- expected reports;
- snapshots when the applicable testing standard permits them;
- invalid-state examples;
- external-service responses.

Keep fixtures:

- deterministic;
- minimal;
- versioned when their provider Contract is versioned;
- free of secrets and production data;
- close to their owner;
- named by condition or expected outcome.

Do not automatically regenerate an expected-output fixture without reviewing the difference.

Do not use a fixture to silently define a missing application, schema, protocol, or UI Contract.

A fixture that participates in a protected verification baseline is protected test source when changing it can alter proof meaning.

## 3. Test Doubles And Laravel Fakes

### 3.1. General rule

Double-selection policy is governed by [Automated And Static Testing Standards](../../testing/automated-and-static-testing-standards.md).

When implementing the selected double:

- replace only the boundary intentionally excluded from the proof;
- type the replacement to the same public Contract;
- keep success and failure behavior explicit;
- avoid broad default-success responses;
- do not make the double a competing API or behavior authority.

A passing fake-backed test proves only the behavior inside the boundary that remains real.

### 3.2. Events

Use an Event fake when the declared proof concerns applicable:

- dispatch decision;
- Event identity;
- payload;
- absence of prohibited dispatch.

Do not fake Events when the proof claims Listener execution, transaction timing, downstream state, external side effects, or real Event integration.

Use scoped faking when unrelated Events should continue executing.

Do not use a global Event fake in shared setup when it would silently suppress owner behavior required by other tests.

### 3.3. Jobs and queues

Use a queue or Bus fake when the declared proof concerns applicable:

- dispatch decision;
- Job identity;
- payload;
- logical queue selection;
- absence of prohibited dispatch.

Do not fake the queue when the proof claims:

- worker execution;
- serialization across a process;
- retry or backoff;
- timeout;
- duplicate delivery;
- failed-job behavior;
- committed-state visibility.

Do not call a Job Handler directly and claim queue or process integration.

A direct Handler test may still be valid for Handler-owned behavior when the verification contract declares that narrower boundary.

### 3.4. Notifications and mail

Use Notification or Mail fakes when proving applicable:

- dispatch decision;
- recipient;
- channel;
- payload;
- absence of prohibited delivery intent.

Do not claim provider delivery, rendered-client compatibility, queue transport, retry, bounce handling, or external account configuration from a framework fake.

Test fixtures must not contain real email credentials, tokens, or customer data.

### 3.5. Filesystems, cache, and HTTP

Use a fake filesystem when real filesystem semantics are not material.

Use a real temporary filesystem or required native environment when the proof concerns permissions, locks, path behavior, atomic moves, cross-process visibility, or platform semantics.

Use a cache fake or array store only when real cache behavior is outside the proof.

Use HTTP fakes for client request construction and response handling when provider execution is outside the declared boundary.

Do not use HTTP fakes as the only proof of provider compatibility, real authentication or signing, timeout behavior, transport configuration, or external account configuration.

### 3.6. Mocking

Mock only public interactions that are intentionally replaced by the declared proof.

Do not:

- mock the subject under test;
- mock private methods;
- use partial mocks to bypass real behavior;
- set broad permissive expectations;
- verify incidental call order unless order is a Contract requirement;
- mock framework behavior claimed by the proof;
- mock a database transaction claimed by the proof;
- mock browser behavior claimed by the proof.

Prefer a small explicit fake or real deterministic collaborator over a complex mock graph when either expresses the boundary more clearly.

## 4. Authentication, Authorization, And Security-Test Setup

Security-sensitive test source must keep actor, target, and material state explicit.

Create the narrowest actor required by the criterion. Do not use a Super Administrator merely to simplify setup when the behavior concerns a narrower permission.

Clearly named helpers may represent repeated actor states, for example:

```text
actingAsUserWithPermission
actingAsUserWithoutPermission
inactiveUser
wrongTenantUser
expiredCredential
```

only when the helper's granted state remains visible and bounded.

Avoid generic helpers that silently grant broad permissions, elevation, tenant access, or assurance state.

For denied behavior, implement assertions required by the verification contract for applicable:

- public denial;
- unchanged durable state;
- absence of prohibited Event, Job, Notification, or remote side effect;
- absence of sensitive output;
- required Audit or Monitoring evidence.

Do not test authorization by manually bypassing the authorization boundary and then claiming the protected behavior is authorized correctly.

Do not expose real passwords, secrets, tokens, recovery codes, cookies, authorization headers, or personal data in test output or browser artifacts.

Security-control requirements remain with [Security Testing Standards](../../security/Security%20Testing%20Standards.md) and the canonical security owner.

## 5. Events, Jobs, Schedulers, And Asynchronous Test Code

Separate test source by the asynchronous layer declared by the proof.

Common implementation layers include:

1. declaration and registration;
2. dispatch decision;
3. serialization;
4. Listener, Handler, or worker execution;
5. retry and terminal failure;
6. transaction and after-commit visibility;
7. Monitoring and operator evidence.

Do not combine every layer into one opaque test unless the verification contract intentionally selects an end-to-end or system boundary.

For Job or Listener execution tests:

- invoke the public execution boundary appropriate to the declared level;
- use real dependencies when their behavior is part of the proof;
- assert durable effects;
- assert prohibited duplicate effects where material;
- clean up worker, process, and external state owned by the test.

For scheduler tests:

- assert scheduler registration separately from command or Job behavior when those are distinct requirements;
- do not treat scheduler registration as proof that the scheduled operation succeeds.

For idempotency source:

- execute the operation more than once when the proof requires duplicate handling;
- assert the accepted durable outcome;
- assert material side-effect behavior;
- distinguish sequential duplicates from concurrent duplicates when that distinction matters.

Do not coordinate worker or concurrency tests primarily through arbitrary sleeps. Use deterministic synchronization where the environment permits it.

Reliability and operational proof requirements remain with the Testing Standards suite and applicable runbook or feature owner.

## 6. Prohibited Patterns

Do not:

- create factory states that invent unsupported product behavior;
- use broad seeders instead of focused fixtures;
- hide actor, permission, lifecycle, or scope state inside generic helpers;
- let fixtures become undeclared behavior Contracts;
- use production secrets or customer data;
- mock the subject under test;
- use a fake to claim real worker, provider, filesystem, browser, database, or transport behavior;
- fake a boundary that the proof claims to verify;
- call a Handler directly and claim queue integration;
- collapse dispatch, worker execution, retry, and operational evidence into one vague test;
- automatically update protected expected-output fixtures or snapshots;
- bypass authorization merely to simplify test setup.

## 7. Review

Before accepting fixture, double, security-setup, or asynchronous test source, confirm:

- the setup artifact has one clear owner;
- fixture meaning comes from a canonical Contract rather than the fixture itself;
- factories and scenario builders keep material state visible;
- seeders represent accepted shared baselines only;
- the selected fake or double replaces only an excluded boundary;
- assertions do not claim behavior hidden behind a fake;
- security-sensitive actors are narrowly scoped and synthetic;
- asynchronous tests identify the layer they actually execute;
- worker and process state is cleaned up;
- protected fixtures and helpers were not changed without required authority.

## 8. Related

- [Test Implementation Standards Index](index.md)
- [Test Source And Placement Standards](test-source-and-placement-standards.md)
- [Laravel And Database Test Implementation Standards](laravel-and-database-test-implementation-standards.md)
- [Browser Test Implementation Standards](browser-test-implementation-standards.md)
- [Test Source Lifecycle Standards](test-source-lifecycle-standards.md)
- [Testing Standards Index](../../testing/index.md)
- [Automated And Static Testing Standards](../../testing/automated-and-static-testing-standards.md)
- [Security Testing Standards](../../security/Security%20Testing%20Standards.md)
- [Events Jobs And Queue Standards](../Events%20Jobs%20And%20Queue%20Standards.md)
- [Transaction Concurrency And Idempotency Standards](../Transaction%20Concurrency%20And%20Idempotency%20Standards.md)

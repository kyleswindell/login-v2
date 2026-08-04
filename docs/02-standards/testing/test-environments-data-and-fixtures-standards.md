<!--
DOC-META
title: Test Environments, Data, And Fixtures Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/test-environments-data-and-fixtures-standards.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines test-environment declarations and evidence, capability preflight, environment equivalence, PostgreSQL and isolation requirements, test data, factories, scenario builders, fixtures, provenance, external systems, time, randomness, parallel execution, cleanup, and sensitive-data protection.
-->

# Test Environments, Data, And Fixtures Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Required And Actual Environment Records](#2-required-and-actual-environment-records)
  - [2.1. Required environment declaration](#21-required-environment-declaration)
  - [2.2. Actual execution environment](#22-actual-execution-environment)
  - [2.3. Environment deviations](#23-environment-deviations)
- [3. Environment Capability Preflight](#3-environment-capability-preflight)
  - [`BLOCKED`](#blocked)
  - [`EXECUTED + FAIL`](#executed--fail)
- [4. Environment Classes](#4-environment-classes)
  - [4.1. Isolated process](#41-isolated-process)
  - [4.2. Application test environment](#42-application-test-environment)
  - [4.3. Browser environment](#43-browser-environment)
  - [4.4. Native-platform environment](#44-native-platform-environment)
  - [4.5. Staging environment](#45-staging-environment)
  - [4.6. Production-safe verification](#46-production-safe-verification)
- [5. Environment Equivalence](#5-environment-equivalence)
- [6. Database Environment](#6-database-environment)
  - [6.1. PostgreSQL requirement](#61-postgresql-requirement)
  - [6.2. SQLite boundary](#62-sqlite-boundary)
  - [6.3. Database isolation strategies](#63-database-isolation-strategies)
  - [6.4. Transaction-isolation limitations](#64-transaction-isolation-limitations)
  - [6.5. Database state declaration](#65-database-state-declaration)
- [7. Test Data Principles](#7-test-data-principles)
- [8. Factories, Scenario Builders, Seeders, And Fixtures](#8-factories-scenario-builders-seeders-and-fixtures)
  - [8.1. Factories](#81-factories)
  - [8.2. Scenario builders](#82-scenario-builders)
  - [8.3. Seeders](#83-seeders)
  - [8.4. Fixtures](#84-fixtures)
  - [8.5. Invalid-state fixtures](#85-invalid-state-fixtures)
- [9. Fixture Ownership And Provenance](#9-fixture-ownership-and-provenance)
- [10. External Services And Environments](#10-external-services-and-environments)
- [11. Time, Time Zones, Randomness, And Identifiers](#11-time-time-zones-randomness-and-identifiers)
- [12. Filesystem, Queues, Cache, Mail, Scheduler, And Realtime](#12-filesystem-queues-cache-mail-scheduler-and-realtime)
- [13. Parallel Execution And Resource Ownership](#13-parallel-execution-and-resource-ownership)
- [14. Cleanup And Teardown](#14-cleanup-and-teardown)
- [15. Synthetic, Production-Derived, And Sensitive Data](#15-synthetic-production-derived-and-sensitive-data)
- [16. Environment And Evidence Failures](#16-environment-and-evidence-failures)
- [17. Prohibited Patterns](#17-prohibited-patterns)
- [18. Related](#18-related)

## 1. Purpose And Authority

Ensure test results are reproducible, environment-valid, isolated, and safe.

This standard defines:

- what environment a declared proof requires;
- what environment actually executed the proof;
- how environment capability is classified;
- when environments are materially equivalent;
- how test data and fixtures are owned and reproduced;
- how shared resources are isolated and cleaned up;
- how sensitive data is protected.

This standard does not:

- authorize repository writes;
- determine implementation readiness;
- own package-application workflow;
- define application schema or persistence behavior;
- select a test double instead of a real collaborator;
- define operational procedures;
- authorize shared or production environment changes.

Those responsibilities remain with the applicable work packet, Agent Implementation Checklist, execution workflow, database standards, automated-testing standards, canonical data owners, and runbooks.

## 2. Required And Actual Environment Records

A verification contract declares the environment required for a `PF-*` proof before execution.

An execution record or material evidence manifest records the environment that actually ran the proof.

Do not combine required and actual environment values into one ambiguous record.

### 2.1. Required environment declaration

Declare applicable:

- environment class;
- operating-system requirement;
- runtime and tool constraints;
- application environment;
- database engine and required capabilities;
- required service set;
- browser engine or version;
- native-platform requirement;
- external-service mode;
- filesystem, queue, cache, mail, scheduler, and realtime mode;
- fixture or scenario source;
- isolation strategy;
- parallel-execution requirements;
- evidence-capture capability;
- responsible executor.

The declaration should identify which properties are material to the proof and which may vary.

Do not use “local,” “CI,” “Docker,” or “staging” as the entire environment declaration when behavior depends on more detail.

### 2.2. Actual execution environment

After execution, record applicable:

- operating system and version;
- PHP, Node, framework, test runner, and material tool versions;
- application revision;
- working directory;
- container images or service versions;
- database engine and version;
- migration or schema state;
- browser and driver versions;
- external-service environment;
- queue, cache, filesystem, mail, scheduler, and realtime implementation;
- time zone;
- random seed;
- worker or parallel-run identity;
- evidence location.

The actual environment record must be sufficient to determine whether the declared proof ran in a valid environment.

### 2.3. Environment deviations

Record every material difference between the required and actual environment.

A deviation is acceptable only when:

- it does not affect the behavior being proven;
- the verification contract permits the variation; or
- the proper authority accepts a contract revision.

Do not silently accept an environment deviation because the runner returned a passing result.

## 3. Environment Capability Preflight

Before executing a declared proof, confirm that the required environment can:

- start the applicable runner or preflight;
- boot the application when required;
- discover the target tests or checks;
- connect to required services;
- create isolated test data;
- perform required setup safely;
- collect required evidence;
- retain required artifacts;
- preserve unrelated developer, issue, staging, or production state.

Classify preflight state using the accepted verification model.

### `BLOCKED`

Use `BLOCKED` when a known prerequisite prevents execution from beginning.

Examples:

- required native operating system is not available;
- browser environment has not been provisioned;
- required sandbox credentials have not been supplied;
- accepted schema dependency is incomplete;
- required specialist environment is unavailable.

A blocked record identifies:

- blocking prerequisite;
- prerequisite owner;
- affected `PF-*` proof;
- affected stage;
- condition required to resume.

### `EXECUTED + FAIL`

Use `EXECUTED + FAIL` when the preflight or proof begins and then fails.

Examples:

- application boot was attempted and failed;
- database connection was attempted and failed;
- test discovery ran and did not find the declared proof;
- browser driver started and crashed;
- fixture loading began and failed;
- evidence capture failed after execution began.

A preflight or environment failure cannot be converted to `EXPECTED_NONPASS`.

Recovery must follow the applicable work packet and execution workflow. This standard does not independently authorize production-code, dependency, fixture, package-owned-code, or infrastructure changes.

## 4. Environment Classes

### 4.1. Isolated process

Use for:

- pure logic;
- parsing;
- serialization;
- deterministic transformation;
- static analysis;
- architecture checks;
- documentation checks.

The proof must not claim application, framework, database, browser, worker, or network behavior.

### 4.2. Application test environment

Use when proof depends on:

- Laravel boot;
- configuration;
- container bindings;
- routes;
- middleware;
- policies;
- owner-local persistence;
- Events;
- Jobs;
- Notifications;
- filesystem abstraction;
- cache;
- mail;
- queue dispatch.

The declared application environment must identify material service substitutions and fakes.

### 4.3. Browser environment

Use when proof depends on:

- real DOM behavior;
- JavaScript execution;
- focus;
- keyboard interaction;
- navigation;
- animation;
- responsive layout;
- browser storage;
- downloads;
- browser security behavior.

A DOM renderer or server-rendered HTML assertion does not prove browser behavior.

### 4.4. Native-platform environment

Use when behavior depends on:

- operating-system services;
- PowerShell or shell semantics;
- filesystem permissions or locking;
- path conventions;
- process control;
- network stack;
- system certificates;
- platform packaging;
- native tooling.

Simulation does not satisfy a mandatory native-platform proof.

### 4.5. Staging environment

Use when proof requires:

- real external integration;
- realistic deployment topology;
- migration rehearsal;
- service coordination;
- operational smoke;
- infrastructure controls;
- specialist acceptance that local execution cannot provide.

Staging proof must identify relevant differences from production.

### 4.6. Production-safe verification

Use only for explicitly approved:

- non-destructive health checks;
- bounded smoke tests;
- monitoring validation;
- release verification;
- safe post-deployment proof.

Production-safe proof must follow the applicable runbook and external-state authorization.

## 5. Environment Equivalence

Environment equivalence is proof-specific.

Two environments are equivalent only when their differences cannot materially change the behavior claimed by the proof.

The verification contract should identify:

- material environment properties;
- permitted variation;
- prohibited substitution;
- known limitations.

Examples:

```text
Linux CI does not prove Windows-specific PowerShell behavior.

SQLite does not prove PostgreSQL constraints, locking, or transaction behavior.

A fake queue does not prove worker execution, retry, timeout, or duplicate-delivery behavior.

A server-side DOM renderer does not prove browser focus or JavaScript behavior.

A local application boot does not prove staging deployment.

Staging does not automatically prove production configuration or infrastructure posture.
```

Do not describe an environment as “close enough,” “production-like,” or “equivalent” without identifying the exact properties relevant to the proof.

## 6. Database Environment

### 6.1. PostgreSQL requirement

Any proof claiming Login 2.0 application-persistence behavior must use PostgreSQL when it verifies applicable:

- migrations;
- schema;
- column types;
- defaults;
- generated columns;
- indexes;
- constraints;
- foreign keys;
- uniqueness;
- JSON or `jsonb`;
- transactions;
- rollback;
- locking;
- concurrency;
- query planning;
- SQL behavior;
- schema qualification;
- migration order;
- cross-process visibility;
- data-preservation behavior.

Use the PostgreSQL version or accepted version range declared by the applicable environment or deployment owner.

A passing proof on another database does not establish PostgreSQL behavior.

### 6.2. SQLite boundary

SQLite may be used when:

- the accepted artifact is itself SQLite-based;
- the database is an explicitly disposable projection;
- the proof concerns tooling that owns SQLite as its Contract;
- the proof does not claim Login 2.0 application-persistence equivalence.

Examples may include a disposable inventory or reporting projection whose canonical Contract explicitly selects SQLite.

Do not substitute SQLite for PostgreSQL merely for speed or convenience when persistence semantics could differ.

### 6.3. Database isolation strategies

Select the isolation strategy appropriate to the proof.

| Strategy                    | Appropriate use                                                                                             |
| --------------------------- | ----------------------------------------------------------------------------------------------------------- |
| Transaction rollback        | Ordinary owner-local persistence tests where commit visibility is not part of the proof                     |
| Database refresh            | Tests requiring a clean committed application state across sequential operations                            |
| Isolated database or schema | Migrations, DDL, locking, concurrency, cross-process, worker, parallel, or connection-sensitive proof       |
| Dedicated staged database   | Deployment rehearsal, representative data volume, migration-duration, backup, restore, or operational proof |

The proof declaration must identify the selected strategy when database behavior is material.

### 6.4. Transaction-isolation limitations

Do not rely on a test transaction when the proof claims to verify:

- commit behavior;
- after-commit Events or Jobs;
- cross-process visibility;
- independent database connections;
- locking;
- deadlocks;
- concurrent transactions;
- process termination;
- rollback after process failure;
- worker behavior;
- migration or DDL semantics.

A test transaction can hide the behavior being tested.

### 6.5. Database state declaration

Record applicable:

- database engine and version;
- database or schema identity;
- migration state;
- seed or baseline state;
- isolation strategy;
- transaction behavior;
- connection count;
- parallel-worker allocation;
- cleanup strategy.

Database tests must not affect shared developer, unrelated worktree, staging, or production data.

## 7. Test Data Principles

Test data must be:

- explicit;
- minimal for the proof;
- deterministic;
- representative of the criterion;
- isolated from production;
- classified for sensitivity;
- reproducible;
- disposable unless intentionally retained as evidence;
- owned by the applicable test, owner, fixture, or scenario.

Include applicable:

- valid data;
- invalid data;
- boundary values;
- denied actors;
- inactive state;
- expired state;
- revoked state;
- duplicate state;
- stale state;
- conflicting state;
- cross-owner or accepted scope-denial state.

Do not rely on large opaque fixture sets when a small named scenario can prove the behavior.

Realistic data does not mean copied production data.

## 8. Factories, Scenario Builders, Seeders, And Fixtures

### 8.1. Factories

A factory constructs valid owner-local records and meaningful states.

Factories should:

- respect accepted defaults and invariants;
- expose explicit state methods;
- avoid hidden cross-owner setup;
- avoid creating unrelated records;
- remain deterministic;
- make important actor, lifecycle, or permission state visible.

A factory does not independently define schema or feature behavior.

### 8.2. Scenario builders

A scenario builder composes factories and test infrastructure into a named workflow state.

Use scenario builders for repeated multi-record or multi-owner arrangements such as:

- active administrator with an active target User Account;
- expired credential with an active User Account;
- installed Module with declared Contributions;
- failed Job with retry state;
- authorized exporter with restricted data.

Scenario builders should:

- reveal the scenario’s meaningful state;
- keep owner boundaries explicit;
- avoid broad hidden setup;
- provide deterministic cleanup;
- remain scoped to repeated accepted scenarios.

Do not use a scenario builder to conceal the actor, target, permission, or state relevant to the proof.

### 8.3. Seeders

A seeder establishes a broad deterministic environment baseline.

Use seeders only when:

- many tests or environments share the accepted baseline;
- baseline data is part of application or environment setup;
- the data is safe to rerun;
- per-test factory setup would duplicate a real shared baseline.

Do not use broad seeders for ordinary isolated test setup.

A seeder must not hide application behavior or bypass required setup Contracts.

### 8.4. Fixtures

A fixture is a stable:

- input;
- output;
- payload;
- file;
- snapshot;
- external Contract example;
- generated case;
- schema sample;
- expected report.

Fixtures must:

- have one clear owner;
- have documented provenance;
- be deterministic;
- avoid secrets and restricted data;
- identify applicable provider or Contract version;
- fail clearly when invalid;
- be protected when part of an accepted baseline.

### 8.5. Invalid-state fixtures

An invalid-state fixture intentionally represents a state that accepted production APIs would reject.

Use only when the proof requires it.

Rules:

- make the invalid condition explicit;
- bypass only the minimum invariant necessary;
- keep the fixture local to the proof or clearly named test utility;
- prevent accidental use as ordinary valid setup;
- do not redefine valid production state;
- document why ordinary public setup cannot create the condition.

## 9. Fixture Ownership And Provenance

Every material fixture should identify applicable:

- owner;
- source;
- purpose;
- format;
- Contract or provider version;
- creation method;
- generator and version;
- random seed;
- sensitivity classification;
- expected update authority.

External Contract fixtures should record:

- provider;
- environment;
- protocol or API version;
- collection date when material;
- sanitization performed;
- license or redistribution limitation;
- secret and privacy review.

Generated fixtures should record enough information to reproduce them.

A failing generated case should retain:

- random seed;
- minimized failing case where supported;
- generator version;
- configuration;
- exact proof ID.

Protected fixtures require verification-contract revision before material change.

## 10. External Services And Environments

Classify external-service execution as:

- local fake;
- protocol stub;
- mock server;
- service virtualization;
- provider sandbox;
- staged live integration;
- production-safe smoke.

This standard owns the declared and actual external environment, including:

- provider environment;
- endpoint class;
- authentication mode;
- secret source;
- rate-limit constraints;
- cleanup requirements;
- fixture provenance;
- allowed test data;
- evidence redaction;
- execution timing restrictions.

[Automated And Static Testing Standards](automated-and-static-testing-standards.md) owns whether a fake, stub, spy, mock, or real collaborator is appropriate for the proof.

Use provider sandboxes or staged integration when verifying applicable:

- authentication;
- signatures;
- protocol compatibility;
- pagination;
- retries;
- rate limits;
- webhooks;
- error translation;
- real payload shape;
- provider configuration;
- provider-side state transitions.

Never embed real secrets in tests or fixtures.

Do not run destructive or high-volume external tests without explicit approval and provider-safe cleanup.

## 11. Time, Time Zones, Randomness, And Identifiers

Control applicable:

- current time;
- time zone;
- daylight-saving transition;
- expiration;
- retry schedule;
- scheduler time;
- random seed;
- UUID or identifier generation;
- ordering source.

Use a controlled clock for:

- expiration;
- recent-auth windows;
- retry and backoff;
- scheduling;
- retention;
- token validity;
- time-based state transitions.

Declare the time zone when date or time behavior matters.

Test daylight-saving boundaries only when the behavior is materially affected.

Generated or randomized proof must:

- record the seed;
- reproduce a failure from the seed;
- retain a minimized failing case where supported;
- avoid unbounded nondeterministic execution.

Real-time waiting requires explicit justification and should not be used when time can be controlled.

## 12. Filesystem, Queues, Cache, Mail, Scheduler, And Realtime

Use isolated applicable resources:

- temporary filesystem root;
- fake or dedicated test storage disk;
- queue backend or namespace;
- cache namespace;
- mail transport;
- scheduler state;
- websocket or realtime channel;
- process or worker pool.

Declare whether each resource is:

- fake;
- in-memory;
- local service;
- container service;
- staged service;
- production-safe service.

A fake queue proves dispatch intent, not worker execution.

A fake filesystem proves application interaction, not native permissions, locking, remote storage, or production storage behavior.

A fake mail transport proves composition and dispatch intent, not provider delivery.

Add integration, native-platform, staged, or operational proof when those boundaries matter.

## 13. Parallel Execution And Resource Ownership

Every parallel run or worker must own unique applicable:

- database or schema;
- cache prefix;
- queue namespace;
- filesystem root;
- browser context;
- port;
- mail namespace;
- realtime channel;
- external sandbox identifier;
- temporary directory;
- evidence directory.

Resource identity should include a run or worker identifier when practical.

Parallel-safe tests must not depend on:

- fixed shared identifiers;
- shared mutable global state;
- fixed files;
- fixed ports;
- shared external records;
- execution order;
- another worker’s cleanup.

A test that only passes serially must:

- declare the constraint;
- explain why isolation cannot currently be achieved;
- avoid being silently included in a parallel suite;
- identify any follow-up needed.

Parallel execution must not weaken evidence attribution. Material artifacts must identify the run and worker that produced them.

## 14. Cleanup And Teardown

Cleanup must remove only resources owned by the current proof execution.

Cleanup should be:

- deterministic;
- idempotent where practical;
- scoped by run identity;
- safe after partial setup;
- safe after failure;
- observable when it cannot complete.

Do not use broad cleanup commands against:

- shared developer data;
- another worktree’s resources;
- staging resources not owned by the proof;
- production resources;
- provider sandboxes containing unrelated records.

A cleanup failure is an evidence failure when it can:

- affect later tests;
- leak sensitive data;
- leave external state;
- interfere with parallel workers;
- alter shared environments;
- make reproduction unreliable.

Preserve sufficient evidence before destructive cleanup when a mandatory proof fails.

## 15. Synthetic, Production-Derived, And Sensitive Data

Synthetic data is the default.

Do not include:

- production customer data;
- real credentials;
- access tokens;
- MFA secrets;
- recovery codes;
- private keys;
- authorization headers;
- session cookies;
- private documents;
- restricted logs;
- unapproved production payloads.

Production-derived data requires separate explicit authority from the applicable data, privacy, security, and repository owners.

Do not assume that:

- masking is anonymization;
- replacing names makes a dataset safe;
- hashed identifiers are non-sensitive;
- copied logs are safe;
- staging data is unrestricted.

When production-derived data is authorized, record:

- source;
- purpose;
- approval;
- transformation;
- residual risk;
- retention;
- deletion procedure;
- evidence restrictions.

Synthetic data must not accidentally reproduce real secrets or sensitive values.

Review retained artifacts for sensitive data before upload or publication.

## 16. Environment And Evidence Failures

Use `BLOCKED` when a known prerequisite prevents execution from beginning.

Use `EXECUTED + FAIL` when setup, preflight, or proof execution begins and encounters:

- application boot error;
- missing service dependency;
- invalid database connection;
- broken test discovery;
- invalid fixture loading;
- unavailable browser driver after launch was attempted;
- incorrect permissions;
- exhausted disk or memory;
- unrelated timeout;
- toolchain mismatch;
- evidence-capture failure;
- cleanup failure that affects evidence integrity;
- environment deviation that invalidates the proof.

Do not classify environment, fixture, dependency, tooling, or evidence failures as `EXPECTED_NONPASS`.

A passing runner result in a materially invalid environment is `FAIL`.

## 17. Prohibited Patterns

Do not:

- use one shared test database for unrelated parallel workers;
- point automated tests at a shared developer, staging, or production database without explicit authority;
- substitute SQLite for PostgreSQL when application-persistence semantics matter;
- use a transaction wrapper that hides commit, lock, concurrency, or worker behavior claimed by the proof;
- use production data by default;
- embed secrets in fixtures, source, logs, screenshots, or artifacts;
- describe an environment as equivalent without proof-specific justification;
- use broad seeders when a focused factory or scenario builder is sufficient;
- let factories bypass ordinary invariants without explicit invalid-state purpose;
- use opaque fixtures without provenance;
- depend on execution order or leaked state;
- use fixed ports, paths, identifiers, or external records in parallel execution;
- clean resources not owned by the current run;
- wait for real time when a controlled clock is available;
- discard a failing random case without retaining the seed or reproducible example;
- treat a fake resource as proof of native, worker, provider, or production behavior;
- convert an attempted environment failure into `BLOCKED`;
- convert an environment failure into `EXPECTED_NONPASS`.

## 18. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Automated And Static Testing Standards](automated-and-static-testing-standards.md)
- [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md)
- [Reliability, Performance, Compatibility, And Operational Testing Standards](reliability-performance-compatibility-and-operational-testing-standards.md)
- [Database Migration Standards](../database/Database%20Migration%20Standards.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)
- [Local Development Runbook](../../10-runbooks/local-dev.md)

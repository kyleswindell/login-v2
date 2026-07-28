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
summary: Defines required test-environment capability, PostgreSQL use, fixtures, factories, doubles, time, randomness, cleanup, parallelism, and sensitive-data protection.
-->

# Test Environments, Data, And Fixtures Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Environment Declaration](#2-environment-declaration)
- [3. Capability Preflight](#3-capability-preflight)
- [4. Environment Classes](#4-environment-classes)
  - [Isolated process](#isolated-process)
  - [Application test environment](#application-test-environment)
  - [Browser environment](#browser-environment)
  - [Native-platform environment](#native-platform-environment)
  - [Staging environment](#staging-environment)
  - [Production-safe verification](#production-safe-verification)
- [5. Database Environment](#5-database-environment)
- [6. Test Data](#6-test-data)
- [7. Factories, Seeders, And Fixtures](#7-factories-seeders-and-fixtures)
- [8. External Services And Doubles](#8-external-services-and-doubles)
- [9. Time, Randomness, And Identifiers](#9-time-randomness-and-identifiers)
- [10. Filesystem, Queues, Cache, And Realtime](#10-filesystem-queues-cache-and-realtime)
- [11. Cleanup, Isolation, And Parallelism](#11-cleanup-isolation-and-parallelism)
- [12. Sensitive Data](#12-sensitive-data)
- [13. Environment Failures](#13-environment-failures)
- [14. Related](#14-related)

## 1. Purpose

Ensure test results are reproducible, environment-valid, isolated, and safe.

This standard defines whether an environment can execute a declared proof validly. It does not authorize repository writes, determine implementation readiness, or own package-application workflow. Those responsibilities remain with the applicable work packet, Agent Implementation Checklist, and execution workflow.

## 2. Environment Declaration

Every material verification contract identifies:

- operating system when relevant;
- runtime and tool versions;
- working directory;
- application environment;
- database engine;
- required services;
- browser and version when applicable;
- external-service mode;
- fixture source;
- queue, cache, scheduler, mail, filesystem, and realtime mode;
- environment owner or executor.

Do not use “local” or “CI” as the entire environment specification when behavior depends on more detail.

## 3. Capability Preflight

Before executing a declared proof, confirm that the required environment can:

- boot the application when the proof requires it;
- discover the target tests or checks;
- connect to required services;
- create isolated test data;
- execute the target runner;
- collect required evidence;
- preserve unrelated developer or issue state.

A proof-environment preflight failure is `FAIL`.

Recovery from an environment-capability failure must follow the applicable work packet and execution workflow. This standard does not independently authorize production-code, package-owned-code, dependency, fixture, or infrastructure changes.

## 4. Environment Classes

### Isolated process

Use for pure logic and static checks.

### Application test environment

Use when Laravel boot, configuration, container bindings, routes, middleware, policies, Events, Jobs, or persistence matter.

### Browser environment

Use when real DOM, JavaScript, focus, navigation, animation, responsive, storage, or browser security behavior matters.

### Native-platform environment

Use when the behavior depends on operating-system services, filesystem semantics, shell behavior, network stack, or platform tooling.

### Staging environment

Use for external integrations, deployment, realistic infrastructure, migration rehearsal, operational smoke, and specialist acceptance when local proof is insufficient.

### Production-safe verification

Use only for explicitly approved non-destructive health, smoke, monitoring, or release checks.

## 5. Database Environment

Use PostgreSQL when verifying:

- migrations;
- constraints;
- indexes;
- generated columns;
- JSON behavior;
- locking;
- transactions;
- concurrency;
- query planning;
- PostgreSQL-specific SQL;
- schema qualification;
- data types;
- owner-local migration order.

Do not substitute SQLite when doing so could change semantics.

Database tests must use an isolated database or transaction strategy that cannot affect shared developer, staging, or production data.

Record schema prerequisites and migration state.

## 6. Test Data

Test data must be:

- explicit;
- minimal;
- deterministic;
- representative of the criterion;
- isolated from production;
- classified for sensitivity;
- disposable unless intentionally preserved as evidence.

Include boundary, invalid, denied, inactive, expired, revoked, duplicate, and cross-scope data where applicable.

Do not rely on large opaque fixture sets when a small targeted fixture can prove the behavior.

## 7. Factories, Seeders, And Fixtures

Factories create valid owner-local records and meaningful states.

Seeders establish broader deterministic scenarios only when many tests or environments share the same accepted baseline.

Fixtures represent stable inputs, outputs, files, payloads, or snapshots.

Rules:

- fixtures have one clear owner;
- factories do not bypass required invariants unless an invalid-state fixture is explicitly needed;
- fixture names describe behavior or state;
- generated fixture data must be reproducible;
- protected fixtures require verification-contract revision before material change;
- invalid fixtures must fail clearly rather than causing unrelated boot or parsing errors.

## 8. External Services And Doubles

Classify external-service testing as:

- local fake;
- protocol stub;
- mock server;
- sandbox;
- staged live integration;
- production-safe smoke.

Use local doubles for routine deterministic tests.

Use provider sandboxes or staged integration tests when verifying:

- authentication;
- signatures;
- protocol compatibility;
- pagination;
- retries and rate limits;
- webhooks;
- error translation;
- real payload shape;
- provider configuration.

Never embed real secrets in tests or fixtures.

Contract fixtures derived from external systems must be reviewed for licensing, privacy, and secret exposure.

## 9. Time, Randomness, And Identifiers

Control:

- current time;
- time zones;
- daylight-saving transitions;
- expiration;
- retry schedules;
- random seeds;
- UUID or identifier generation when exact identity matters.

Record random seeds for reproducibility.

Test date, time, and expiration boundaries rather than only ordinary values.

Do not make ordinary tests wait for real time when the clock can be controlled.

## 10. Filesystem, Queues, Cache, And Realtime

Use isolated:

- temporary storage;
- fake or test filesystem disks;
- queue backends;
- cache namespaces;
- mail transports;
- websocket or realtime channels;
- scheduler state.

A fake queue proves dispatch intent, not worker execution.

A fake filesystem proves application interaction, not operating-system permissions or production storage behavior.

Add integration or operational proof when those boundaries matter.

## 11. Cleanup, Isolation, And Parallelism

Tests must not depend on order or leaked state.

Use applicable:

- transaction rollback;
- database reset;
- isolated schemas or databases;
- temporary directories;
- unique cache prefixes;
- isolated queues;
- controlled ports;
- browser-context reset;
- service teardown.

Parallel-safe tests must avoid shared fixed identifiers, files, ports, or mutable global state.

A test that only passes serially must declare that constraint and justify it.

## 12. Sensitive Data

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
- restricted logs.

Synthetic data must not accidentally reproduce real sensitive values.

Evidence output must redact secrets and restricted personal data.

## 13. Environment Failures

Classify as `FAIL`:

- application boot errors;
- missing service dependencies;
- invalid database connection;
- broken test discovery;
- invalid fixture loading;
- unavailable browser driver;
- incorrect permissions;
- exhausted disk or memory;
- unrelated timeout;
- toolchain mismatch.

An environment failure cannot be converted to `EXPECTED_NONPASS`.

## 14. Related

- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Automated And Static Testing Standards](automated-and-static-testing-standards.md)
- [Database Migration Standards](../database/Database%20Migration%20Standards.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)
- [Local Development Runbook](../../10-runbooks/local-dev.md)

<!--
DOC-META
title: Test Environment And Equivalence Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/test-environments/test-environment-and-equivalence-standards.md
parent: docs/02-standards/testing/test-environments/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines required and actual proof environments, capability preflight, environment classes, equivalence, PostgreSQL requirements, and database-test isolation policy.
-->

# Test Environment And Equivalence Standards

Parent: [Test Environment Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Required And Actual Environment](#2-required-and-actual-environment)
- [3. Environment Capability Preflight](#3-environment-capability-preflight)
- [4. Environment Classes](#4-environment-classes)
  - [Isolated process](#isolated-process)
  - [Application test environment](#application-test-environment)
  - [Browser environment](#browser-environment)
  - [Native-platform environment](#native-platform-environment)
  - [Staging environment](#staging-environment)
  - [Production-safe verification](#production-safe-verification)
- [5. Environment Equivalence](#5-environment-equivalence)
- [6. Database Environment](#6-database-environment)
  - [PostgreSQL requirement](#postgresql-requirement)
  - [SQLite boundary](#sqlite-boundary)
  - [Isolation strategies](#isolation-strategies)
- [7. Environment Deviations And Invalid Proof](#7-environment-deviations-and-invalid-proof)
- [8. Prohibited Patterns](#8-prohibited-patterns)
- [9. Related](#9-related)

## 1. Purpose And Authority

Ensure a proof runs in an environment capable of establishing the behavior it claims.

This standard owns required environment declarations, actual execution-environment requirements, environment capability preflight, proof-specific equivalence, and database-engine/isolation requirements for verification.

It does not define application behavior, production infrastructure, schema requirements, operational procedures, or proof-state semantics.

## 2. Required And Actual Environment

A `PF-*` proof declares its required environment before execution. The execution record identifies the environment that actually ran. Keep these records separate.

A required environment declaration identifies applicable:

- environment class;
- operating-system or native-platform requirement;
- runtime and material tool constraints;
- application boot requirements;
- database engine and capabilities;
- required service set;
- browser engine/version;
- external-service mode;
- filesystem, queue, cache, mail, scheduler, or realtime mode;
- isolation strategy;
- parallel-execution constraints;
- evidence-capture capability;
- responsible executor.

Identify which properties are material and which may vary. Do not use labels such as `local`, `CI`, `Docker`, or `staging` as the complete declaration when behavior depends on more detail.

The actual execution environment records enough applicable information to judge validity, including OS, runtime/tool versions, revision, working directory, service/container versions, database/version/migration state, browser/driver, external-service mode, resource implementations, time zone/seed when material, and parallel-run or worker identity.

Detailed evidence-record format belongs to [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 3. Environment Capability Preflight

Before proof starts, confirm the environment can perform it safely. Applicable checks include:

- runner/procedure availability;
- application boot capability;
- proof discovery;
- required service connectivity;
- isolated data/resource creation;
- safe setup and cleanup;
- required browser/native-platform capability;
- evidence capture/retention;
- protection of unrelated developer, worktree, staging, or production state.

Use [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md) for state meanings.

A known missing prerequisite before execution is `BLOCKED`. When runner, boot, discovery, connection, fixture loading, browser startup, or evidence capture is attempted and fails, execution began and the result is `FAIL`.

Do not convert environment failure to `EXPECTED_NONPASS`.

## 4. Environment Classes

Use the narrowest environment capable of proving the criterion.

### Isolated process

Appropriate for pure logic, parsing, serialization, deterministic transforms, static analysis, architecture checks, and documentation checks. It does not prove framework, database, browser, worker, network, or native-platform behavior.

### Application test environment

Appropriate when proof depends on Laravel boot, configuration, container bindings, routes, middleware, policies, owner-local persistence, or framework services. Declare material substitutions and fakes.

### Browser environment

Required when proof depends on actual DOM behavior, JavaScript, focus, keyboard/pointer interaction, browser navigation/storage, downloads, viewport behavior, animation, or browser security behavior. Server-rendered HTML or a DOM string parser does not prove those behaviors.

### Native-platform environment

Required when behavior depends on OS services, PowerShell/shell behavior, native path rules, filesystem permissions/locking, process control, system certificates, networking, packaging, or platform tooling. Simulation does not satisfy an explicitly native proof.

### Staging environment

Use when proof requires realistic deployment topology, real external integration, migration rehearsal, service coordination, infrastructure controls, or specialist acceptance unavailable locally. Record material differences from production.

### Production-safe verification

Production execution requires separate authority and must follow applicable operational testing and runbook rules. An environment being production-capable does not itself authorize execution there.

## 5. Environment Equivalence

Equivalence is proof-specific. Two environments are equivalent only when their differences cannot materially alter the behavior claimed by the proof.

Declare material properties, permitted variation, prohibited substitutions, and known limitations.

```text
Linux CI does not prove Windows-specific PowerShell behavior.
SQLite does not prove PostgreSQL constraints, locking, or transaction semantics.
A fake queue does not prove worker execution, retry, or broker redelivery.
Server-rendered output does not prove browser focus or JavaScript behavior.
A local application boot does not prove staging deployment.
Staging does not automatically prove production configuration or infrastructure posture.
```

Do not use `close enough`, `production-like`, or `equivalent` without naming the material properties behind the claim.

## 6. Database Environment

### PostgreSQL requirement

Use PostgreSQL for Login 2.0 application-persistence claims when proof depends on migrations/DDL, data types/defaults, indexes/constraints, foreign keys/uniqueness, JSON/`jsonb`, transactions/rollback, locking/concurrency, query planning, SQL behavior, schema qualification, cross-process visibility, or data preservation.

Use the accepted version/range owned by the applicable environment/deployment authority. A passing result on another database does not establish PostgreSQL behavior.

### SQLite boundary

SQLite is valid when SQLite is itself the accepted Contract, such as a disposable tooling projection, or when the proof makes no Login 2.0 application-persistence equivalence claim. Do not substitute SQLite merely for speed or convenience when persistence semantics may differ.

### Isolation strategies

| Strategy                  | Appropriate use                                                                                       |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Transaction rollback      | Ordinary owner-local persistence where commit visibility is not part of the proof                     |
| Database refresh          | Clean committed state across sequential operations                                                    |
| Isolated database/schema  | Migration, DDL, locking, concurrency, cross-process, worker, parallel, or connection-sensitive proof  |
| Dedicated staged database | Deployment rehearsal, representative volume, migration-duration, backup/restore, or operational proof |

Do not use a wrapping test transaction when the proof claims commit, after-commit, independent connections, locking, deadlocks, concurrent transactions, worker visibility, process failure, or migration semantics.

When database behavior is material, record engine/version, database/schema identity, migration/baseline state, isolation strategy, transaction behavior, connection/worker allocation, and cleanup strategy.

## 7. Environment Deviations And Invalid Proof

Record every material difference between required and actual environment.

A deviation is acceptable only when it cannot affect the claimed behavior, the verification contract expressly permits it, or the proper authority accepts a verification-contract revision.

A passing runner result in a materially invalid environment is `FAIL`.

Do not silently downgrade the proof claim to fit the environment that happened to be available.

## 8. Prohibited Patterns

Do not:

- substitute a materially different environment without authority;
- point ordinary automated tests at shared developer, staging, or production databases;
- use SQLite as PostgreSQL proof;
- use transaction wrapping that hides claimed behavior;
- claim native-platform proof from simulation;
- claim browser behavior from server-rendered output;
- claim worker behavior from dispatch-only fakes;
- classify attempted environment failure as `BLOCKED`;
- classify environment, dependency, discovery, boot, fixture, or tool failure as `EXPECTED_NONPASS`.

## 9. Related

- [Test Environment Standards Index](index.md)
- [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Automated And Static Testing Standards](../automated-and-static-testing-standards.md)
- [Database Standards Index](../../database/index.md)
- [Persistent Data Architecture](../../../03-architecture/persistent-data-architecture.md)

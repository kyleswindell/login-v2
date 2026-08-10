<!--
DOC-META
title: Reliability Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/quality-and-operational-testing/reliability-testing-standards.md
parent: docs/02-standards/testing/quality-and-operational-testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines verification rules for failure-state safety, transactions, concurrency, idempotency, retries, recovery, resilience, and fault injection.
-->

# Reliability Testing Standards

Parent: [Quality And Operational Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Reliability Proof Declaration](#2-reliability-proof-declaration)
- [3. Failure-State And Safe-State Testing](#3-failure-state-and-safe-state-testing)
- [4. Transactions, Rollback, And Side-Effect Ordering](#4-transactions-rollback-and-side-effect-ordering)
- [5. Concurrency Testing](#5-concurrency-testing)
- [6. Idempotency And Duplicate Execution](#6-idempotency-and-duplicate-execution)
- [7. Retry, Timeout, Backoff, And Exhaustion](#7-retry-timeout-backoff-and-exhaustion)
- [8. Recovery, Restart, Replay, And Fault Injection](#8-recovery-restart-replay-and-fault-injection)
- [9. Evidence And Reporting](#9-evidence-and-reporting)
- [10. Prohibited Patterns](#10-prohibited-patterns)
- [11. Related](#11-related)

## 1. Purpose And Authority

Define how accepted reliability requirements are proven when operations fail, overlap, retry, duplicate, roll back, or recover.

This standard owns verification methods for:

- expected failure and degraded states;
- safe-state assertions;
- transaction and rollback behavior;
- concurrency;
- idempotency and duplicate execution;
- retry, timeout, backoff, and exhaustion;
- restart, resume, replay, and recovery;
- bounded fault injection.

It does not define the application's transaction owner, retry policy, timeout values, idempotency Contract, recovery objectives, compensation model, or operational procedure. Those requirements remain with their canonical feature, flow, coding, database, integration, or runbook owners.

Reliability proof must cite the accepted requirement it verifies. Testing must not invent a fallback, retry, compensation, or recovery rule merely to make failure behavior pass.

## 2. Reliability Proof Declaration

In addition to the shared verification-contract fields, declare applicable:

- failure or concurrency condition;
- starting durable state;
- actor, process, worker, or connection identities;
- transaction owner and boundary;
- synchronization or fault-injection point;
- accepted public result or rejection;
- required safe state;
- required and prohibited side effects;
- retry, idempotency, or recovery requirement source;
- environment and resource isolation;
- cleanup;
- limitations.

Use the shared state/result meanings from [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md).

## 3. Failure-State And Safe-State Testing

Reliability proof must establish more than an error response or thrown exception. For each accepted failure class, verify applicable:

- public rejection or failure result;
- unchanged or correctly rolled-back durable state;
- no unauthorized disclosure;
- no prohibited Event, Job, Notification, or external effect;
- no duplicate durable record;
- released locks, leases, reservations, or temporary resources;
- required Audit or Monitoring evidence;
- accurate user/operator-visible status;
- ability to retry or recover when the canonical requirement permits it.

Applicable failure classes may include validation or authorization rejection, dependency outage, malformed remote response, timeout, process interruption, worker failure, stale/conflicting state, duplicate request/message, resource exhaustion, or an accepted degraded mode.

When degraded operation is defined, verify which behavior remains available, which behavior is rejected, whether stale/fallback data is allowed, how freshness is disclosed, and how normal operation resumes. Do not invent degraded behavior from implementation convenience.

Environment, fixture, dependency, syntax, boot, tooling, discovery, or evidence-capture failures are proof failures, not accepted application failure behavior.

## 4. Transactions, Rollback, And Side-Effect Ordering

Transaction proof must identify the real production transaction boundary when that boundary is material.

Verify applicable:

- all accepted durable mutations commit together;
- injected failure leaves no prohibited partial state;
- rollback suppresses prohibited Events, Jobs, Notifications, or remote effects;
- locks and temporary resources are released;
- after-commit behavior occurs only after commit;
- workers or independent connections see committed state when required;
- retry after rollback does not create duplicate durable effects;
- compensation or pending-state behavior matches the accepted flow when external effects cannot be atomic.

Do not wrap the proof in a test transaction when doing so hides commit visibility, locking, independent connections, after-commit behavior, process failure, or rollback semantics.

When local mutation and external effects are combined, cite the accepted ordering or compensation Contract. Testing must not infer an outbox, saga, distributed transaction, or reconciliation pattern that the system owner has not accepted.

## 5. Concurrency Testing

Concurrency proof requires actual overlapping operations.

Declare:

- competing operations;
- shared resource;
- starting state;
- synchronization point;
- accepted winner/loser, merge, queue, retry, or rejection behavior;
- expected durable state;
- lock or version strategy defined by the canonical owner.

Use deterministic coordination when practical, such as barriers, latches, explicit transaction holds, independent connections/processes, worker synchronization, or another bounded test hook. Arbitrary sleeps alone are not reliable concurrency coordination.

Verify applicable:

- lost-update prevention;
- uniqueness races;
- duplicate creation prevention;
- optimistic or pessimistic locking;
- deadlock/lock-timeout handling;
- stale-update rejection;
- one-time token or invitation use;
- quota, counter, stock, balance, reservation, or last-administrator invariants;
- concurrent idempotency-key use.

Assert both final durable state and each participant's public result or rejection. A run that never demonstrates overlap is not valid concurrency proof.

## 6. Idempotency And Duplicate Execution

Testing must cite the owner-defined idempotency Contract, including applicable operation identity, key scope, request equivalence, retention, repeated result, conflict behavior, concurrency, and retry relationship.

Execute accepted duplicate scenarios and verify applicable:

- stable public result;
- one accepted durable effect;
- no duplicate prohibited Event, Job, Notification, Audit record, or remote mutation;
- changed payload under the same key receives the accepted result;
- behavior after prior success and prior failure;
- concurrent duplicate behavior;
- expiry/cleanup behavior when required.

Sequential duplicate proof does not establish concurrent duplicate behavior. Local idempotency does not prove provider-side idempotency. A fake queue does not prove broker redelivery semantics.

## 7. Retry, Timeout, Backoff, And Exhaustion

Verify the accepted classification of retryable and non-retryable failures.

Where applicable, prove:

- timeout boundary;
- retry count and maximum attempts;
- backoff or scheduling behavior;
- successful retry after transient failure;
- immediate terminal handling for non-retryable failure;
- exhaustion behavior;
- final status and operator visibility;
- no duplicate durable or external side effect across attempts.

Use controlled time when timing itself is not the behavior under test. When real timing is material, declare the clock source, tolerance, environment, scheduling jitter, and measurement method.

Do not make a flaky proof pass by adding automatic retry. Proof flakiness is an evidence-reliability problem governed by the testing-gate rules.

## 8. Recovery, Restart, Replay, And Fault Injection

Recovery proof must cite an accepted recovery objective or runbook when one exists.

Verify applicable:

- application, worker, or scheduler restart;
- interrupted workflow resume or safe failure;
- pending work recovery;
- cache or dependency loss recovery;
- stale lock or lease handling;
- backup restoration into an isolated environment;
- rollback or replay behavior;
- duplicate prevention during recovery;
- health and Monitoring recovery.

A successful backup command alone does not prove restore capability when restore is required.

Fault injection may be used for accepted resilience behavior when it declares the injected fault, injection point, scope, duration, safety boundary, expected result, cleanup, and stop condition. Do not perform uncontrolled or destructive fault injection against shared staging or production environments.

## 9. Evidence And Reporting

Material reliability evidence should make the failure condition and safe-state result reproducible. Retain applicable process/connection identities, synchronization steps, transaction outcomes, retry attempts, final durable state, cleanup result, and limitations.

Detailed artifact structure and retention belong to [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).

## 10. Prohibited Patterns

Do not:

- let tests choose transaction, retry, timeout, idempotency, fallback, or recovery policy;
- assert only the error while ignoring safe state;
- call sequential repetition concurrency testing;
- rely on arbitrary sleeps to create races;
- use a wrapping transaction or single connection to prove independent visibility;
- mock the boundary whose real reliability behavior is claimed;
- use a fake queue to prove worker or broker behavior;
- infer idempotency from one successful run;
- hide duplicate effects;
- retry a flaky proof until it passes;
- perform destructive recovery or fault injection without required authority;
- classify invalid environment or tooling behavior as accepted reliability failure.

## 11. Related

- [Quality And Operational Testing Standards Index](index.md)
- [Verification Contract Standards](../verification-contract/verification-contract-standards.md)
- [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md)
- [Test Environment Standards Index](../test-environments/index.md)
- [Integration Testing Standards](../integration-and-system/integration-testing-standards.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Transaction Concurrency And Idempotency Standards](../../coding/Transaction%20Concurrency%20And%20Idempotency%20Standards.md)
- [Events Jobs And Queue Standards](../../coding/Events%20Jobs%20And%20Queue%20Standards.md)
- [Runbook Index](../../../10-runbooks/index.md)

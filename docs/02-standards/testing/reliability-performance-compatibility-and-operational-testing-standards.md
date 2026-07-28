<!--
DOC-META
title: Reliability, Performance, Compatibility, And Operational Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/reliability-performance-compatibility-and-operational-testing-standards.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines reliability, concurrency, retry, idempotency, recovery, performance, compatibility, deployment, health, and operational verification.
-->

# Reliability, Performance, Compatibility, And Operational Testing Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Reliability And Failure Behavior](#2-reliability-and-failure-behavior)
- [3. Transactions And Rollback](#3-transactions-and-rollback)
- [4. Concurrency And Idempotency](#4-concurrency-and-idempotency)
- [5. Retry And Duplicate Delivery](#5-retry-and-duplicate-delivery)
- [6. Recovery And Resilience](#6-recovery-and-resilience)
- [7. Performance Testing](#7-performance-testing)
- [8. Load, Stress, Endurance, And Capacity](#8-load-stress-endurance-and-capacity)
  - [Load testing](#load-testing)
  - [Stress testing](#stress-testing)
  - [Endurance testing](#endurance-testing)
  - [Capacity testing](#capacity-testing)
- [9. Database Performance](#9-database-performance)
- [10. Compatibility And Interoperability](#10-compatibility-and-interoperability)
- [11. Build, Deployment, And Migration Verification](#11-build-deployment-and-migration-verification)
- [12. Health, Monitoring, And Operational Smoke](#12-health-monitoring-and-operational-smoke)
- [13. Production-Safe Verification](#13-production-safe-verification)
- [14. Related](#14-related)

## 1. Purpose

Define proof required for software that must remain correct under failure, concurrency, load, environment variation, deployment, and operation.

## 2. Reliability And Failure Behavior

Verify applicable:

- expected exceptions;
- public rejection;
- partial dependency failure;
- timeout;
- unavailable service;
- malformed remote response;
- interrupted process;
- failed Job;
- retry exhaustion;
- stale state;
- duplicate request;
- degraded but safe behavior;
- monitoring and operator visibility.

Failure tests must assert safe state, not only an error response.

## 3. Transactions And Rollback

For mutations, verify:

- transaction owner;
- commit boundary;
- rollback on failure;
- no partial durable state;
- side effects occur at the intended time;
- Events and Jobs respect after-commit requirements;
- remote effects are ordered safely;
- retry does not duplicate committed state.

Do not use broad transactions in tests to hide production transaction defects.

## 4. Concurrency And Idempotency

Concurrency-sensitive work must test applicable:

- simultaneous updates;
- lost-update prevention;
- uniqueness races;
- locking;
- optimistic or pessimistic concurrency;
- duplicate command submission;
- repeated webhook delivery;
- repeated Job execution;
- stale version rejection;
- last-admin or equivalent invariant;
- stock, balance, quota, or counter integrity.

Idempotency tests must execute the operation more than once and prove the accepted stable result.

## 5. Retry And Duplicate Delivery

Verify:

- retryable versus non-retryable failures;
- maximum attempts;
- backoff;
- timeout;
- duplicate suppression;
- idempotency key behavior;
- failed-job recording;
- operator recovery;
- safe Notification and audit behavior.

A retry test must not depend on real waiting when time can be controlled.

## 6. Recovery And Resilience

Use recovery tests for:

- restart after failure;
- queue worker recovery;
- scheduler restart;
- cache loss;
- temporary database unavailability;
- external integration recovery;
- backup restore;
- rollback;
- disaster-recovery procedures;
- corrupted or partial artifact handling.

Operational recovery proof must follow the applicable runbook.

## 7. Performance Testing

Performance verification should declare:

- workload;
- data volume;
- concurrency;
- environment;
- warm-up;
- measurement interval;
- latency metric;
- throughput metric;
- resource metric;
- acceptable threshold;
- repeat count;
- variance;
- result interpretation.

Do not compare performance results from materially different environments without qualification.

## 8. Load, Stress, Endurance, And Capacity

### Load testing

Verify expected workload and service-level targets.

### Stress testing

Increase pressure beyond expected limits to identify failure mode and recovery behavior.

### Endurance testing

Run sustained workload to identify leaks, buildup, degradation, or queue growth.

### Capacity testing

Determine the practical limit for a declared environment and workload.

Performance tests must not run against shared production systems without explicit approval and safeguards.

## 9. Database Performance

Verify applicable:

- query count;
- query plan;
- index use;
- N+1 behavior;
- pagination;
- batch size;
- lock duration;
- transaction duration;
- large-data behavior;
- migration duration;
- cleanup and retention Jobs.

Use representative data volume. Tiny fixtures do not prove scalability.

## 10. Compatibility And Interoperability

Test only compatibility the project actually supports or the issue explicitly requires.

Applicable dimensions include:

- browser engines;
- viewport and input method;
- operating system;
- PHP, Node, Laravel, and package versions;
- PostgreSQL versions;
- external API versions;
- email clients;
- files and encodings;
- network conditions;
- locale, time zone, and language;
- route, key, Contract, or schema compatibility.

Compatibility tests must identify the supported matrix and source of authority.

## 11. Build, Deployment, And Migration Verification

Verify applicable:

- dependency installation;
- production asset build;
- configuration validation;
- environment preflight;
- migration ordering;
- forward migration;
- rollback where required and safe;
- seeding or registration;
- cache compilation;
- queue restart;
- scheduler registration;
- health checks;
- deployment smoke;
- rollback or recovery readiness.

A successful local build does not prove staging or production deployment behavior.

## 12. Health, Monitoring, And Operational Smoke

Operational verification should confirm:

- application health;
- database connectivity;
- cache and queue availability;
- scheduler activity;
- realtime service health;
- external integration status where appropriate;
- log and monitoring pipeline;
- alert routing;
- failed-job visibility;
- backup status;
- required security posture.

Health checks must not expose secrets or sensitive internal details.

## 13. Production-Safe Verification

Production verification requires explicit approval and must be:

- non-destructive;
- low risk;
- bounded;
- reversible where applicable;
- observable;
- rate limited;
- secret safe;
- Tenant and data safe;
- documented in a runbook.

Do not run load, destructive migration, penetration, or broad exploratory tests in production without separately accepted authority.

## 14. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md)
- [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md)
- [Deployment Environment And Infrastructure Security Standards](../security/Deployment%20Environment%20And%20Infrastructure%20Security%20Standards.md)
- [Runbook Index](../../10-runbooks/index.md)

<!--
DOC-META
title: Operational Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/quality-and-operational-testing/operational-testing-standards.md
parent: docs/02-standards/testing/quality-and-operational-testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines testing rules for builds, deployment, migration, rollback readiness, health, Monitoring, alerting, operational smoke, and production-safe verification.
-->

# Operational Testing Standards

Parent: [Quality And Operational Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Build Verification](#2-build-verification)
- [3. Deployment Verification](#3-deployment-verification)
- [4. Migration Verification](#4-migration-verification)
- [5. Rollback And Recovery Readiness](#5-rollback-and-recovery-readiness)
- [6. Health, Monitoring, Logging, And Alerting](#6-health-monitoring-logging-and-alerting)
- [7. Operational Smoke](#7-operational-smoke)
- [8. Production-Safe Verification](#8-production-safe-verification)
- [9. Evidence And Reporting](#9-evidence-and-reporting)
- [10. Prohibited Patterns](#10-prohibited-patterns)
- [11. Related](#11-related)

## 1. Purpose And Authority

Define testing policy for build, deployment, migration, health, Monitoring, alerting, operational smoke, recovery readiness, and explicitly authorized production-safe verification.

This standard does not define deployment steps, migration procedures, rollback procedures, production-change authority, Monitoring policy, alert routes, recovery objectives, or operator decisions. Those remain with deployment owners, database standards, security standards, runbooks, and repository/operations authority.

A testing proof must cite the procedure or operational requirement it verifies.

## 2. Build Verification

Build verification confirms that accepted source can produce the required artifact.

Verify applicable:

- dependency installation and lockfile consistency;
- PHP autoload generation;
- frontend production build and asset manifest;
- generated registration/manifest output;
- configuration compilation;
- package discovery;
- container image or deployable artifact build;
- documentation build;
- artifact identity/reproducibility requirement;
- secret exclusion.

A mutating preparation step must be followed by applicable non-mutating verification.

Build success does not prove deployment, runtime health, production configuration, migration safety, external integration, or operational readiness.

Release-relevant artifacts should be traceable to source revision and an applicable immutable identity or hash.

## 3. Deployment Verification

Deployment proof verifies the accepted deployment procedure in the declared target environment.

Verify applicable:

- environment preflight;
- artifact identity;
- configuration presence/validity;
- secret availability without disclosure;
- dependency readiness;
- traffic or maintenance state;
- service startup;
- cache/configuration compilation;
- queue/scheduler restart;
- health checks;
- Monitoring/alert readiness;
- deployed revision;
- bounded operational smoke;
- cleanup.

Declare target environment, exact procedure/runbook, responsible executor, stop conditions, rollback/recovery trigger, and retained evidence.

A successful build does not prove deployment.

## 4. Migration Verification

Migration proof verifies the accepted database migration Contract and procedure.

Verify applicable:

- ordering and prerequisites;
- forward migration;
- schema result;
- data preservation;
- defaults/backfill;
- constraints;
- application compatibility during transition;
- lock/duration requirements;
- restart/resume behavior;
- rollback where required and safe;
- post-migration validation.

Use PostgreSQL and representative data when PostgreSQL semantics, locking, duration, or data-preservation behavior are material.

A migration that succeeds only against an empty database does not prove production-data safety.

Exact migration and rollback requirements remain with database standards and the applicable migration plan/runbook.

## 5. Rollback And Recovery Readiness

When required by an accepted deployment or recovery plan, verify applicable:

- rollback artifact/revision exists;
- procedure is executable;
- data compatibility is understood;
- migration rollback is safe or explicitly unavailable;
- backup/restore prerequisites exist;
- operator decision point is clear;
- post-rollback health can be checked.

Documentation alone does not establish executable rollback readiness when rehearsal is required.

Detailed recovery behavior belongs to [Reliability Testing Standards](reliability-testing-standards.md); exact operator steps belong to runbooks.

## 6. Health, Monitoring, Logging, And Alerting

Verify only accepted signals and policies.

Health proof may cover application, database, cache, queue, scheduler, realtime, object storage, external integration, migration, worker, or backup state. Where required, verify both healthy and accepted unhealthy/degraded responses.

Monitoring/logging proof may verify expected metric, structured log, trace, correlation, dashboard/query availability, failed-job visibility, error classification, redaction, and owner-defined retention/sampling behavior.

Alert proof may verify triggering condition, content, severity, routing, deduplication, recovery notification, secret-safe payload, and delivery evidence.

Do not expose secrets, credentials, internal stack traces, raw SQL, or restricted personal data in operational evidence. Do not send disruptive test alerts to production responders without explicit approval.

## 7. Operational Smoke

Operational smoke is a small, non-destructive proof that a deployed environment is stable enough for operation or deeper verification.

Verify applicable:

- deployed revision;
- application boot;
- critical entry point;
- database connectivity/migration state;
- asset availability;
- queue/scheduler reachability;
- health endpoint;
- Monitoring pipeline;
- one bounded representative workflow.

Operational smoke does not prove complete feature behavior, full security, full performance, recovery, or release acceptance by itself.

The smoke procedure belongs to the applicable runbook or deployment plan.

## 8. Production-Safe Verification

Production verification requires explicit authorization before execution.

It must be bounded, non-destructive, low risk, data/secret safe, rate limited, observable, attributable to a named executor/revision, and governed by an applicable runbook.

Declare:

- exact production surface;
- actor/synthetic identity;
- permitted reads/writes;
- expected created data;
- cleanup;
- rate/duration;
- Monitoring;
- stop conditions;
- rollback/recovery action;
- reviewer/authority.

Do not run in production without separate explicit authority:

- load, stress, spike, endurance, or broad capacity testing;
- destructive migration or recovery testing;
- uncontrolled fault injection;
- penetration testing;
- broad exploratory testing;
- tests using real customer data outside accepted procedures.

A proof safe in staging is not automatically safe in production.

## 9. Evidence And Reporting

Operational evidence should identify target environment, deployed/build artifact identity, procedure, executor, revision, command/procedure result, relevant health/migration state, cleanup, limitations, and required review.

Detailed artifact format and retention are governed by [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md). Stage completeness is governed by [Testing Gate Standards](../reporting-and-gates/testing-gate-standards.md).

## 10. Prohibited Patterns

Do not:

- treat build success as deployment proof;
- treat empty-database migration success as representative data safety;
- claim rollback readiness without required executable rehearsal;
- invent Monitoring or alert policy through tests;
- expose sensitive operational data in health/evidence output;
- send disruptive alerts without approval;
- run uncontrolled load, fault, recovery, migration, security, or exploratory testing in production;
- treat staging safety as production authorization;
- claim operational readiness without required runbook or review authority.

## 11. Related

- [Quality And Operational Testing Standards Index](index.md)
- [Reliability Testing Standards](reliability-testing-standards.md)
- [Test Environment Standards Index](../test-environments/index.md)
- [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md)
- [Testing Gate Standards](../reporting-and-gates/testing-gate-standards.md)
- [Database Standards Index](../../database/index.md)
- [Security Standards Index](../../security/index.md)
- [Runbook Index](../../../10-runbooks/index.md)

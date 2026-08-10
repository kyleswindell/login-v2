<!--
DOC-META
title: Quality And Operational Testing Standards Index
doc_type: index
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/quality-and-operational-testing/index.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes reliability, performance, compatibility, build, deployment, migration, health, and operational verification standards.
-->

# Quality And Operational Testing Standards Index

Parent: [Testing Standards Index](../index.md)

## 1. Purpose

Route quality-specific proof beyond ordinary functional correctness and the verification required to build, deploy, migrate, observe, and safely verify running environments.

## 2. Scope

This family owns failure-state reliability; transactions, concurrency, idempotency, retry and recovery; performance/scalability; compatibility/interoperability; build/deployment/migration verification; and health, Monitoring, alert, operational-smoke, and production-safe proof.

It does not define the application's reliability policy, numeric performance thresholds, supported compatibility matrix, deployment procedures, or operational authority.

## 3. Standards

| Standard                                                              | Owns                                                                                                                                                            |
| --------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Reliability Testing Standards](reliability-testing-standards.md)     | Failure-state/safe-state proof, transaction rollback, concurrency, idempotency, retry/exhaustion, recovery, and fault injection                                 |
| [Performance Testing Standards](performance-testing-standards.md)     | Performance thresholds/references, workload/environment declarations, metrics, load/stress/spike/endurance/capacity/scalability, and database performance proof |
| [Compatibility Testing Standards](compatibility-testing-standards.md) | Supported-matrix proof, matrix selection, backward/forward compatibility, and protocol/interchange compatibility                                                |
| [Operational Testing Standards](operational-testing-standards.md)     | Build, deployment, migration, rollback/recovery readiness, health/Monitoring/alerts, operational smoke, and production-safe verification                        |

## 4. Authority Boundaries

- Application behavior and thresholds remain with canonical owners.
- Environment validity: [Test Environment Standards](../test-environments/index.md).
- Integration boundaries: [Integration Testing Standards](../integration-and-system/integration-testing-standards.md).
- Proof-state semantics: [Verification State And Result Standards](../verification-contract/verification-state-and-result-standards.md).
- Evidence artifacts: [Verification Reporting And Artifact Standards](../reporting-and-gates/verification-reporting-and-artifact-standards.md).
- Exact operator procedures belong to runbooks.

## 5. Related

- [Testing Standards Index](../index.md)
- [Testing And Verification Standards](../testing-and-verification-standards.md)
- [Test Environment Standards Index](../test-environments/index.md)
- [Integration And System Testing Standards Index](../integration-and-system/index.md)
- [Database Standards Index](../../database/index.md)
- [Security Standards Index](../../security/index.md)
- [Runbook Index](../../../10-runbooks/index.md)

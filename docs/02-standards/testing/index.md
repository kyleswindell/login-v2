<!--
DOC-META
title: Testing Standards Index
doc_type: index
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/index.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the canonical Login 2.0 testing and verification standards suite.
-->

# Testing Standards Index

Parent: [Standards Index](../index.md)

- [1. Purpose](#1-purpose)
- [2. Authority](#2-authority)
- [3. Reading Order](#3-reading-order)
- [4. Core And Specialist Standards](#4-core-and-specialist-standards)
- [5. Classification Model](#5-classification-model)
- [6. Compatibility Routes](#6-compatibility-routes)
- [7. Specialist Routing](#7-specialist-routing)
- [8. Related](#8-related)

## 1. Purpose

Provide one navigable standards suite for planning, executing, evaluating, reporting, and accepting software verification across Login 2.0.

Use this index to select the smallest set of testing standards required for the current proof.

## 2. Authority

This suite owns shared testing and verification policy. It does not replace the canonical source that defines what the system must do.

Use this authority chain:

```text
accepted requirement
        ↓
canonical behavior / Contract / constraint owner
        ↓
verification contract
        ↓
specialist proof
        ↓
execution evidence
        ↓
testing-gate evaluation
        ↓
repository workflow or human acceptance authority
```

The [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md) owns implementation readiness and repository-facing execution workflow.

This suite owns proof design, proof-state semantics, environment validity, quality-specific verification policy, execution evidence, and testing-evidence gates.

Repository-specific test-source coding belongs to the [Test Implementation Standards Index](../coding/test-implementation/index.md).

## 3. Reading Order

For ordinary implementation or review work:

1. read [Testing And Verification Standards](testing-and-verification-standards.md);
2. read the [Verification Contract Standards Index](verification-contract/index.md);
3. read the canonical requirement owner that defines expected behavior;
4. read only the narrowest specialist testing standard or family applicable to the proof;
5. read Security, Database, UI, Documentation, or Runbook standards when those owners define additional requirements;
6. read the [Test Implementation Standards Index](../coding/test-implementation/index.md) only when constructing or modifying test source;
7. use the [Reporting And Testing Gates Standards Index](reporting-and-gates/index.md) when recording material evidence or evaluating stage completeness.

Do not load the entire suite for a narrow change.

## 4. Core And Specialist Standards

| Standard or family                                                                    | Owns                                                                                                                                                |
| ------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Testing And Verification Standards](testing-and-verification-standards.md)           | Shared principles, taxonomy, methods, levels, quality concerns, risk selection, and minimum lifecycle                                               |
| [Verification Contract Standards](verification-contract/index.md)                     | `AC-*`, `PF-*`, proof state/results, initial proof, protected baselines, and contract revision                                                      |
| [Automated And Static Testing Standards](automated-and-static-testing-standards.md)   | Static proof, automated levels, Contract/architecture proof, design techniques, double/assertion policy, coverage, and mutation analysis            |
| [Test Environment Standards](test-environments/index.md)                              | Required and actual environments, equivalence, PostgreSQL, test data, fixtures, external services, resource isolation, parallelism, and cleanup     |
| [Integration And System Testing Standards](integration-and-system/index.md)           | Integration categories and ownership, cross-owner and protocol proof, system/E2E, smoke, acceptance, and exploratory proof                          |
| [Quality And Operational Testing Standards](quality-and-operational-testing/index.md) | Reliability, concurrency, idempotency, retry, recovery, performance, compatibility, build, deployment, migration, health, and production-safe proof |
| [UI And Accessibility Testing Standards](ui-and-accessibility/index.md)               | UI Contract/semantic proof, browser interaction, accessibility, responsive behavior, visual regression, and specialist review                       |
| [Reporting And Testing Gates Standards](reporting-and-gates/index.md)                 | Execution evidence, artifacts, reporting, retention, and testing-stage completeness                                                                 |

## 5. Classification Model

Every material proof should be understandable across independent dimensions:

| Dimension           | Examples                                                                                                                               |
| ------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| Requirement source  | Feature, flow, schema, security control, UI Contract, runbook, issue criterion                                                         |
| Verification method | Static, automated dynamic, browser, manual, native-platform, specialist                                                                |
| Test level          | Unit, component, capability, integration, system, end-to-end, acceptance, operational                                                  |
| Quality concern     | Functional, security, data integrity, reliability, performance, compatibility, usability, accessibility, maintainability, operations   |
| Design technique    | Requirements-based, boundary value, decision table, state transition, pairwise, property-based, fuzz, exploratory                      |
| Environment         | Isolated process, Laravel application, PostgreSQL, browser, Docker service set, staging, native platform, production-safe verification |
| Execution stage     | Preimplementation, final targeted, pull request, merge candidacy, release, deployment, post-deployment                                 |

A label from one dimension must not substitute for another.

Applicability, execution status, and verification result are separate axes defined by [Verification State And Result Standards](verification-contract/verification-state-and-result-standards.md).

## 6. Compatibility Routes

These paths are retained as superseded compatibility routes:

- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md) → [Verification Contract Standards Index](verification-contract/index.md) and [Reporting And Testing Gates Standards Index](reporting-and-gates/index.md);
- [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md) → [Reporting And Testing Gates Standards Index](reporting-and-gates/index.md);
- [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md) → [Test Environment Standards Index](test-environments/index.md);
- [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md) → [Integration And System Testing Standards Index](integration-and-system/index.md);
- [Reliability, Performance, Compatibility, And Operational Testing Standards](reliability-performance-compatibility-and-operational-testing-standards.md) → [Quality And Operational Testing Standards Index](quality-and-operational-testing/index.md);
- [UI, Accessibility, And Interaction Testing Standards](ui-accessibility-and-interaction-testing-standards.md) → [UI And Accessibility Testing Standards Index](ui-and-accessibility/index.md).

Do not add new policy to compatibility routes.

## 7. Specialist Routing

Use the applicable specialist owner in addition to this suite:

- test-source implementation: `docs/02-standards/coding/test-implementation/`;
- security controls and abuse resistance: `docs/02-standards/security/`;
- exact schema and migration requirements: `docs/02-standards/database/` and `docs/06-database/`;
- UI public APIs and design-system requirements: `docs/02-standards/ui/`;
- documentation checks: `docs/02-standards/documentation/`;
- operational procedures: `docs/10-runbooks/`;
- user/system behavior: `docs/04-features/`;
- cross-capability execution: `docs/05-flows/`.

## 8. Related

- [Standards Index](../index.md)
- [Test Implementation Standards Index](../coding/test-implementation/index.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Feature Development Standards](../coding/Feature%20Development%20Standards.md)
- [Security Testing Standards](../security/Security%20Testing%20Standards.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)

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
- [4. Standards](#4-standards)
- [5. Classification Model](#5-classification-model)
- [6. Specialist Routing](#6-specialist-routing)
- [7. Related](#7-related)

## 1. Purpose

Provide one navigable standards suite for planning, constructing, executing, reviewing, and accepting software verification across Login 2.0.

## 2. Authority

This suite owns shared testing rules. It does not replace the canonical source that defines what the system must do.

Use this authority chain:

```text
accepted requirement or behavior
        ↓
applicable architecture, feature, flow, schema, security, UI, or runbook owner
        ↓
verification contract
        ↓
test or review evidence
        ↓
issue, pull request, release, or operational acceptance
```

The [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md) owns implementation readiness and execution workflow. This suite owns proof design, execution, evidence integrity, and testing gates.

## 3. Reading Order

For any implementation or review task:

1. read [Testing And Verification Standards](testing-and-verification-standards.md);
2. read [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md);
3. read the narrowest specialist testing standard applicable to the work;
4. read the requirement owner that defines expected behavior;
5. read security, database, UI, documentation, or runbook standards only when applicable.

Do not load the entire suite for a narrow change.

## 4. Standards

| Standard                                                                                                                                                 | Owns                                                                                                                                |
| -------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| [Testing And Verification Standards](testing-and-verification-standards.md)                                                                              | Shared principles, taxonomy, risk model, test levels, verification methods, and quality coverage                                    |
| [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)                                                          | Acceptance-to-proof mapping, result states, protected evidence, baseline rules, and revision authority                              |
| [Automated And Static Testing Standards](automated-and-static-testing-standards.md)                                                                      | Automated test construction, unit and capability tests, static analysis, architecture tests, contract tests, and design techniques  |
| [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)                                                      | Environment capability, PostgreSQL use, fixtures, factories, doubles, time, randomness, cleanup, parallelism, and sensitive data    |
| [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md)                                          | Cross-owner integration, APIs, queues, system tests, end-to-end workflows, smoke, regression, characterization, and acceptance      |
| [Reliability, Performance, Compatibility, And Operational Testing Standards](reliability-performance-compatibility-and-operational-testing-standards.md) | Failure behavior, concurrency, retry, idempotency, recovery, load, stress, compatibility, deployment, health, and operational proof |
| [UI, Accessibility, And Interaction Testing Standards](ui-accessibility-and-interaction-testing-standards.md)                                            | UI contracts, implementation and usage conformance, accessibility, browser behavior, responsive behavior, motion, and visual review |
| [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md)                                                            | Lifecycle gates, CI selection, failure handling, flaky tests, evidence reporting, merge, release, and post-deployment gates         |

## 5. Classification Model

Every material proof should be understandable across these independent dimensions:

| Dimension           | Examples                                                                                                                             |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| Requirement source  | Feature, flow, schema, security control, UI Contract, runbook, issue acceptance criterion                                            |
| Verification method | Static analysis, automated dynamic test, browser test, manual review, specialist assessment                                          |
| Test level          | Unit, component, capability, integration, system, end-to-end, acceptance, operational                                                |
| Quality concern     | Functional, security, data integrity, reliability, performance, compatibility, usability, accessibility, maintainability, operations |
| Design technique    | Requirements-based, boundary value, decision table, state transition, property-based, fuzz, exploratory, characterization            |
| Environment         | Isolated process, Laravel application, PostgreSQL, browser, Docker service set, staging, native platform, production-safe smoke      |
| Delivery gate       | Preimplementation, targeted development, pull request, merge, release, deployment, post-deployment                                   |

A label from one dimension must not substitute for another. For example, “browser test” does not state whether the proof is component, system, accessibility, compatibility, or acceptance testing.

## 6. Specialist Routing

Use the applicable specialist owner in addition to this suite:

- security controls and abuse resistance: `docs/02-standards/security/`;
- exact schema, migration, transaction, and persistence constraints: `docs/02-standards/database/` and `docs/06-database/`;
- UI public APIs and design-system rules: `docs/02-standards/ui/`;
- documentation checks: `docs/02-standards/documentation/`;
- operational procedures and recovery: `docs/10-runbooks/`;
- user and system behavior: `docs/04-features/`;
- cross-capability execution: `docs/05-flows/`.

## 7. Related

- [Standards Index](../index.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Feature Development Standards](../coding/Feature%20Development%20Standards.md)
- [Security Testing Standards](../security/Security%20Testing%20Standards.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)

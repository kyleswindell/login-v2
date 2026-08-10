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

This suite owns shared testing and verification rules. It does not replace the canonical source that defines what the system must do.

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
testing gate evaluation
        ↓
issue, pull request, release, deployment, or operational acceptance
```

The [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md) owns implementation readiness and execution workflow. This suite owns proof design, execution, evidence integrity, and testing-evidence gates.

Repository-specific coding rules for test source belong to [Test Implementation Standards](../coding/Test%20Implementation%20Standards.md).

## 3. Reading Order

For any implementation or review task:

1. read [Testing And Verification Standards](testing-and-verification-standards.md);
2. read [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md);
3. read the canonical requirement owner that defines the expected behavior;
4. read the narrowest specialist testing standard applicable to the work;
5. read security, database, UI, documentation, or runbook standards only when applicable;
6. read [Test Implementation Standards](../coding/Test%20Implementation%20Standards.md) when constructing or modifying test source.

Do not load the entire suite for a narrow change.

## 4. Standards

| Standard                                                                                                                                                 | Owns                                                                                                                                                                                                                                                    |
| -------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Testing And Verification Standards](testing-and-verification-standards.md)                                                                              | Shared principles, taxonomy, risk-based selection, test levels, verification methods, quality concerns, and minimum verification lifecycle                                                                                                              |
| [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)                                                          | `AC-*` and `PF-*` mapping, applicability, execution status, verification results, initial proof, production-implementation boundaries, protected baselines, contract revision, and execution evidence                                                   |
| [Automated And Static Testing Standards](automated-and-static-testing-standards.md)                                                                      | Static verification, automated dynamic tests, unit, technical-component, capability, Contract, and architecture proof; test-design techniques; doubles; assertions; helpers; datasets; coverage; mutation analysis                                      |
| [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)                                                      | Required and actual environments, capability preflight, environment equivalence, PostgreSQL and isolation, test data, factories, scenario builders, fixtures, provenance, external services, time, randomness, parallelism, cleanup, and sensitive data |
| [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md)                                          | Integration categories and ownership, cross-owner Contract proof, APIs and protocols, asynchronous and database integration, system and end-to-end proof, regression, smoke, exploratory testing, and acceptance                                        |
| [Reliability, Performance, Compatibility, And Operational Testing Standards](reliability-performance-compatibility-and-operational-testing-standards.md) | Failure-state and safe-state proof, transactions, concurrency, idempotency, retry, recovery, performance, compatibility, build, deployment, migration, health, operational smoke, and production-safe verification                                      |
| [UI, Accessibility, And Interaction Testing Standards](ui-accessibility-and-interaction-testing-standards.md)                                            | UI Contract validation, rendered semantics, real-browser interaction, repository usage conformance, accessibility, keyboard and focus, responsive behavior, motion, visual regression, and manual specialist review                                     |
| [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md)                                                            | Preimplementation, development, pull-request, merge-candidacy, release, deployment, and post-deployment testing evidence; failure and flaky-test handling; result artifacts; retention; reporting; testing completeness                                 |

## 5. Classification Model

Every material proof should be understandable across independent dimensions:

| Dimension           | Examples                                                                                                                                    |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| Requirement source  | Feature, flow, schema, security control, UI Contract, runbook, issue acceptance criterion                                                   |
| Verification method | Static analysis, automated dynamic test, browser test, manual review, native-platform procedure, specialist assessment                      |
| Test level          | Unit, component, capability, integration, system, end-to-end, acceptance, operational                                                       |
| Quality concern     | Functional, security, data integrity, reliability, performance, compatibility, usability, accessibility, maintainability, operations        |
| Design technique    | Requirements-based, equivalence partitioning, boundary value, decision table, state transition, pairwise, property-based, fuzz, exploratory |
| Environment         | Isolated process, Laravel application, PostgreSQL, browser, Docker service set, staging, native platform, production-safe verification      |
| Execution stage     | Preimplementation, final targeted, pull request, release, deployment, post-deployment                                                       |

A label from one dimension must not substitute for another. For example, “browser test” does not state whether the proof is component, system, accessibility, compatibility, or acceptance testing.

Characterization is a proof purpose for preservation work, not a design technique.

Applicability, execution status, and verification result are separate state axes defined by [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md).

## 6. Specialist Routing

Use the applicable specialist owner in addition to this suite:

- test-source coding and repository-specific PHPUnit, Laravel, or Playwright implementation: `docs/02-standards/coding/Test Implementation Standards.md`;
- security controls and abuse resistance: `docs/02-standards/security/`;
- exact schema, migration, transaction, and persistence constraints: `docs/02-standards/database/` and `docs/06-database/`;
- UI public APIs and design-system rules: `docs/02-standards/ui/`;
- documentation checks: `docs/02-standards/documentation/`;
- operational procedures and recovery: `docs/10-runbooks/`;
- user and system behavior: `docs/04-features/`;
- cross-capability execution: `docs/05-flows/`.

## 7. Related

- [Standards Index](../index.md)
- [Test Implementation Standards](../coding/Test%20Implementation%20Standards.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Feature Development Standards](../coding/Feature%20Development%20Standards.md)
- [Security Testing Standards](../security/Security%20Testing%20Standards.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)

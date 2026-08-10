<!--
DOC-META
title: Testing And Verification Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/testing-and-verification-standards.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines the shared Login 2.0 testing and verification model, classification vocabulary, proof-selection principles, test levels, quality concerns, and minimum verification lifecycle.
-->

# Testing And Verification Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Core Principles](#2-core-principles)
- [3. Verification Model](#3-verification-model)
- [4. Classification Dimensions](#4-classification-dimensions)
- [5. Verification Methods](#5-verification-methods)
  - [5.1. Static verification](#51-static-verification)
  - [5.2. Automated dynamic verification](#52-automated-dynamic-verification)
  - [5.3. Manual verification](#53-manual-verification)
  - [5.4. Specialist verification](#54-specialist-verification)
- [6. Test Levels](#6-test-levels)
- [7. Quality And Risk Coverage](#7-quality-and-risk-coverage)
  - [Functional correctness](#functional-correctness)
  - [Security and privacy](#security-and-privacy)
  - [Data and persistence integrity](#data-and-persistence-integrity)
  - [Reliability and resilience](#reliability-and-resilience)
  - [Performance and scalability](#performance-and-scalability)
  - [Compatibility and interoperability](#compatibility-and-interoperability)
  - [Usability, accessibility, and UI conformance](#usability-accessibility-and-ui-conformance)
  - [Maintainability and architecture](#maintainability-and-architecture)
  - [Operational quality](#operational-quality)
- [8. Risk-Based Proof Selection](#8-risk-based-proof-selection)
- [9. Minimum Verification Lifecycle](#9-minimum-verification-lifecycle)
- [10. Manual And Specialist Review](#10-manual-and-specialist-review)
- [11. Universal Prohibited Shortcuts](#11-universal-prohibited-shortcuts)
- [12. Related](#12-related)

## 1. Purpose And Authority

Define the shared model used to select, classify, execute, and review proof that Login 2.0 software, documentation, data, interfaces, and operational behavior satisfy accepted requirements.

Testing begins while requirements and acceptance criteria are being designed. It continues through implementation, integration, review, release, deployment, and operation.

This standard owns shared testing vocabulary and the cross-suite verification model.

It does not define:

- application behavior;
- public Contracts;
- architecture;
- exact schema behavior;
- security controls;
- UI public APIs;
- operational procedures;
- repository implementation authorization;
- GitHub Project state;
- test-source coding conventions.

Those responsibilities remain with their canonical owners.

Repository-specific PHPUnit, Laravel, Playwright, fixture, double, and test-support implementation belongs to the [Test Implementation Standards Index](../coding/test-implementation/index.md).

## 2. Core Principles

1. Every accepted behavior change requires applicable proof.
2. Every acceptance criterion maps to at least one declared proof.
3. Acceptance criteria and verification proofs use separate stable identifiers.
4. Use the narrowest reliable proof that demonstrates the requirement and applicable rejection behavior.
5. Test level, verification method, quality concern, design technique, environment, execution stage, and testing gate are separate classifications.
6. Applicability, execution status, and verification result are separate state axes.
7. Automation is preferred for repeatable objective assertions, but it does not replace required human or specialist judgment.
8. A passing proof establishes only what it actually exercises and asserts in the declared environment.
9. Coverage metrics are diagnostic signals, not acceptance evidence by themselves.
10. Accepted tests, fixtures, Contracts, review procedures, and other proof artifacts are protected when they form part of a verification baseline.
11. A broken environment, invalid fixture, missing dependency, discovery failure, or tooling failure is not evidence that target behavior is missing.
12. Preimplementation applicability must be decided before execution.
13. Production implementation begins only after every required initial proof and protected baseline requirement is satisfied.
14. Accepted proof must not be weakened to fit incorrect implementation.
15. Testing evidence does not independently authorize implementation, merge, release, deployment, closure, or repository-owner acceptance.

## 3. Verification Model

Use this model:

```text
accepted requirement
        ↓
acceptance criterion (AC-*)
        ↓
declared verification proof (PF-*)
        ↓
stage-specific applicability
        ↓
proof execution
        ↓
execution evidence
        ↓
testing-gate evaluation
```

Keep these concepts separate:

| Concept             | Meaning                                                            |
| ------------------- | ------------------------------------------------------------------ |
| Requirement         | Canonical behavior, Contract, constraint, or acceptance source     |
| `AC-*`              | What must be true                                                  |
| `PF-*`              | How one or more criteria will be demonstrated                      |
| Applicability       | Whether the proof is required at a declared stage                  |
| Execution status    | Whether execution has occurred or can begin                        |
| Verification result | What the executed proof established                                |
| Evidence            | Reproducible record of execution and material artifacts            |
| Testing gate        | Whether required testing evidence is complete for a workflow stage |

Detailed declaration rules are owned by the [Verification Contract Standards](verification-contract/verification-contract-standards.md).

Applicability, execution status, and result meanings are owned by [Verification State And Result Standards](verification-contract/verification-state-and-result-standards.md).

Initial proof and protected-baseline rules are owned by [Initial Proof And Baseline Standards](verification-contract/initial-proof-and-baseline-standards.md).

## 4. Classification Dimensions

A material proof should be understandable across the dimensions that affect its meaning.

| Dimension           | Examples                                                                                                                               |
| ------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| Requirement source  | Feature, flow, schema, security control, UI Contract, architecture rule, runbook, issue criterion                                      |
| Verification method | Static, automated dynamic, browser, manual, native-platform, specialist                                                                |
| Test level          | Unit, component, capability, integration, system, end-to-end, acceptance, operational                                                  |
| Quality concern     | Functional, security, data integrity, reliability, performance, compatibility, usability, accessibility, maintainability, operations   |
| Design technique    | Requirements-based, boundary value, decision table, state transition, pairwise, property-based, fuzz, exploratory                      |
| Environment         | Isolated process, Laravel application, PostgreSQL, browser, Docker service set, staging, native platform, production-safe verification |
| Execution stage     | Preimplementation, final targeted, pull request, merge candidacy, release, deployment, post-deployment                                 |

A label from one dimension must not substitute for another.

Examples:

- “browser test” states a method or environment, not whether the proof is component, system, accessibility, compatibility, or acceptance testing;
- “security test” states a quality concern, not the test level;
- “feature test” is not a complete proof declaration.

Characterization is a proof mode for preservation work, not a design technique.

## 5. Verification Methods

### 5.1. Static verification

Static verification evaluates artifacts without executing the target runtime behavior.

Examples include:

- syntax and compilation;
- type checking;
- linting and formatting;
- architecture and dependency checks;
- Contract and schema validation;
- generated-manifest validation;
- secret scanning;
- dependency analysis;
- documentation metadata, links, and guardrails;
- code, design, or threat review.

A validation gate must not silently mutate the artifacts it evaluates.

Detailed static and automated proof rules are owned by [Automated And Static Testing Standards](automated-and-static-testing-standards.md).

### 5.2. Automated dynamic verification

Automated dynamic verification executes software or tooling and evaluates observable results.

Examples include:

- unit tests;
- component and capability tests;
- integration tests;
- API and database tests;
- Event, Job, queue, and worker tests;
- browser tests;
- performance tests;
- deployment smoke tests.

### 5.3. Manual verification

Manual verification is appropriate when a human must assess an observable condition that cannot be established adequately through automation alone.

Examples include:

- visual hierarchy;
- interaction clarity;
- accessibility behavior;
- real external systems;
- native-platform behavior;
- operational recovery;
- usability;
- business acceptance.

A required manual proof must have a declared procedure, reviewer authority, environment, expected conditions, and recorded result.

### 5.4. Specialist verification

Specialist verification is required when acceptance depends on expertise not safely delegated to ordinary implementation review.

Examples include:

- authentication and authorization;
- security-control validation;
- destructive or high-volume database changes;
- retention or erasure;
- concurrency-sensitive mutation;
- offensive security findings;
- accessibility assessment;
- production operations;
- design-sensitive UI.

Specialist review does not replace applicable automated proof.

## 6. Test Levels

| Level       | Primary purpose                                                                                  |
| ----------- | ------------------------------------------------------------------------------------------------ |
| Unit        | Verify isolated pure or narrowly constructed behavior                                            |
| Component   | Verify one independently usable technical component through its public API                       |
| Capability  | Verify one Core capability or Module-owned behavior with owner-local integration                 |
| Integration | Verify behavior across components, owners, processes, infrastructure, or services                |
| System      | Verify the assembled application or a major subsystem                                            |
| End-to-end  | Verify a representative workflow through its material layers and channels                        |
| Acceptance  | Verify delivered behavior against accepted user, administrator, business, or system requirements |
| Operational | Verify build, deployment, migration, health, recovery, observability, or safe ongoing operation  |

Select the lowest level that reliably establishes the criterion.

Add higher-level proof when lower levels cannot establish material integration, configuration, transport, browser, deployment, or acceptance behavior.

Test placement is a separate concern governed by Repository Architecture and the [Test Implementation Standards Index](../coding/test-implementation/index.md).

## 7. Quality And Risk Coverage

A work packet should consider the quality concerns materially affected by the change.

### Functional correctness

Applicable concerns include success, validation, rejection, state transitions, calculations, side effects, Events, Jobs, Notifications, and audit behavior.

### Security and privacy

Applicable concerns include authentication, authorization, object access, scope, abuse resistance, secret handling, data exposure, audit, monitoring, retention, erasure, and supply-chain controls.

Security standards remain authoritative for required controls.

### Data and persistence integrity

Applicable concerns include schemas, migrations, constraints, uniqueness, transactions, rollback, concurrency, classification, protection, retention, and restore behavior.

Database standards and database Contracts remain authoritative for required data behavior.

### Reliability and resilience

Applicable concerns include expected failure, timeout, retry, duplicate execution, degraded dependencies, recovery, restart, queue, and scheduler behavior.

### Performance and scalability

Applicable concerns include latency, throughput, query behavior, resource use, load, stress, endurance, capacity, and concurrency under representative conditions.

### Compatibility and interoperability

Applicable concerns include supported browsers, operating systems, runtime versions, PostgreSQL behavior, APIs, protocols, external integrations, and accepted backward compatibility.

### Usability, accessibility, and UI conformance

Applicable concerns include public UI Contracts, semantic rendering, keyboard and assistive-technology behavior, responsive behavior, motion, visual hierarchy, and interaction feedback.

### Maintainability and architecture

Applicable concerns include owner boundaries, dependency direction, prohibited access, naming, placement, public Contract stability, documentation synchronization, and testability.

### Operational quality

Applicable concerns include configuration, startup, builds, deployment, migrations, queues, scheduler, health, logging, monitoring, alerting, rollback, and recovery.

## 8. Risk-Based Proof Selection

Select proof proportional to:

- impact of incorrect behavior;
- likelihood of defect;
- security and privacy sensitivity;
- data-loss or corruption risk;
- transaction and concurrency risk;
- dependency and integration complexity;
- reversibility;
- operational blast radius;
- user visibility;
- accessibility impact;
- compatibility requirements;
- novelty of the implementation pattern.

High-risk work normally requires more than one proof and may require specialist review.

Low-risk documentation or mechanical work does not require unrelated application suites.

Broad suite execution does not replace a missing targeted proof.

Regression selection should follow the changed owner, public Contracts, dependencies, schemas, security boundaries, UI primitives, operational behavior, and prior defects materially affected by the change.

## 9. Minimum Verification Lifecycle

For each changed acceptance criterion:

1. assign a stable `AC-*` identifier;
2. identify its canonical requirement source and owner;
3. define observable success and applicable rejection behavior;
4. declare one or more `PF-*` proofs;
5. map each proof to the criteria it establishes;
6. declare method, level, environment, executor, execution stages, applicability, and expected results;
7. resolve preimplementation applicability before execution;
8. declare the production implementation boundary and permitted proof-only work;
9. execute the required initial proof when applicable;
10. classify the execution using the canonical state and result model;
11. establish and protect the accepted baseline when required;
12. implement without weakening protected proof;
13. rerun the accepted targeted proof with unchanged semantics;
14. execute broader affected proof proportionate to risk;
15. retain material execution evidence;
16. complete required manual or specialist review;
17. evaluate testing completeness for the applicable workflow stage.

Detailed mechanics are intentionally delegated:

- declaration: [Verification Contract Standards](verification-contract/verification-contract-standards.md);
- state and results: [Verification State And Result Standards](verification-contract/verification-state-and-result-standards.md);
- initial proof and baseline: [Initial Proof And Baseline Standards](verification-contract/initial-proof-and-baseline-standards.md);
- evidence: [Verification Reporting And Artifact Standards](reporting-and-gates/verification-reporting-and-artifact-standards.md);
- testing stages and gates: [Testing Gate Standards](reporting-and-gates/testing-gate-standards.md).

Do not force an initial proof that would silently choose unresolved architecture, schema, UI, security, compatibility, or operational behavior.

When no separate preimplementation execution is required, record the reason and still execute every declared final proof.

## 10. Manual And Specialist Review

A passing automated suite is not final approval for applicable:

- design-sensitive UI;
- usability;
- screen-reader interpretation;
- production-environment posture;
- destructive recovery;
- risk acceptance;
- legal or privacy interpretation;
- complex authorization models;
- operational readiness.

Required review authority must be named before testing acceptance is complete.

An implementing agent may prepare evidence and propose findings. It must not represent itself as the human or specialist acceptance authority.

## 11. Universal Prohibited Shortcuts

Do not:

- use a passing assertion that does not exercise the intended target behavior;
- mark required behavior incomplete and call implementation complete;
- delete, skip, narrow, or weaken accepted proof solely to make a gate pass;
- substitute SQLite when PostgreSQL semantics are material;
- mock the behavior or boundary the proof claims to verify;
- treat visual snapshots as the only accessibility proof;
- treat code coverage as requirement coverage;
- fix unrelated failures without scope authority;
- infer acceptance from a successful build alone;
- claim success when the required command or procedure was not executed;
- use `EXPECTED_NONPASS` as a general failure waiver;
- begin production implementation before a required initial proof and protected baseline;
- treat `NOT_APPLICABLE` at one stage as permission to omit required final proof;
- make an unrecorded material change to protected proof;
- collapse applicability, execution status, and result into one ambiguous state;
- append material verification history to a shared source-controlled flat log;
- treat generated observations as reviewed target-state authority.

## 12. Related

- [Testing Standards Index](index.md)
- [Verification Contract Standards Index](verification-contract/index.md)
- [Automated And Static Testing Standards](automated-and-static-testing-standards.md)
- [Reporting And Testing Gates Standards Index](reporting-and-gates/index.md)
- [Test Implementation Standards Index](../coding/test-implementation/index.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Security Testing Standards](../security/Security%20Testing%20Standards.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)

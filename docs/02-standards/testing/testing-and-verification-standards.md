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
summary: Defines the shared Login 2.0 testing taxonomy, principles, verification model, risk selection, test levels, methods, initial-proof applicability, and minimum proof lifecycle.
-->

# Testing And Verification Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Core Principles](#2-core-principles)
- [3. Scope](#3-scope)
- [4. Verification Model And Identifiers](#4-verification-model-and-identifiers)
  - [Acceptance criterion](#acceptance-criterion)
  - [Verification proof](#verification-proof)
  - [Proof execution](#proof-execution)
  - [Testing gate](#testing-gate)
- [5. Testing Classification](#5-testing-classification)
- [6. Verification Methods](#6-verification-methods)
  - [6.1. Static verification](#61-static-verification)
  - [6.2. Dynamic automated verification](#62-dynamic-automated-verification)
  - [6.3. Manual verification](#63-manual-verification)
  - [6.4. Specialist verification](#64-specialist-verification)
- [7. Test Levels](#7-test-levels)
- [8. Quality And Risk Coverage](#8-quality-and-risk-coverage)
  - [8.1. Functional correctness](#81-functional-correctness)
  - [8.2. Security and privacy](#82-security-and-privacy)
  - [8.3. Data and persistence integrity](#83-data-and-persistence-integrity)
  - [8.4. Reliability and resilience](#84-reliability-and-resilience)
  - [8.5. Performance and scalability](#85-performance-and-scalability)
  - [8.6. Compatibility and interoperability](#86-compatibility-and-interoperability)
  - [8.7. Usability, accessibility, and UI conformance](#87-usability-accessibility-and-ui-conformance)
  - [8.8. Maintainability and architecture](#88-maintainability-and-architecture)
  - [8.9. Operational quality](#89-operational-quality)
- [9. Risk-Based Selection](#9-risk-based-selection)
- [10. Minimum Verification Lifecycle](#10-minimum-verification-lifecycle)
- [11. Manual And Specialist Review](#11-manual-and-specialist-review)
- [12. Prohibited Shortcuts](#12-prohibited-shortcuts)
- [13. Related](#13-related)

## 1. Purpose

Define how Login 2.0 selects and organizes reliable proof that software, documentation, data, interfaces, and operational behavior satisfy accepted requirements.

Testing begins while requirements and acceptance criteria are being designed. It continues through implementation, integration, release, deployment, and operation.

## 2. Core Principles

1. **Every accepted behavior change requires proof.**
2. **Every acceptance criterion maps to at least one declared proof.**
3. **Acceptance criteria and proofs have separate stable identifiers.**
4. **Use the narrowest reliable proof that demonstrates the requirement and its applicable rejection behavior.**
5. **Test level, quality concern, verification method, design technique, environment, execution stage, and delivery gate are separate classifications.**
6. **Applicability, execution status, and verification result are separate states.**
7. **Automation is preferred for repeatable objective assertions, but automation does not replace required human or specialist judgment.**
8. **A passing test proves only what it actually asserts in the declared environment.**
9. **Coverage percentages are diagnostic signals, not acceptance evidence by themselves.**
10. **Tests, fixtures, UI Contracts, schemas, and review evidence are protected when accepted as part of a verification contract.**
11. **A broken test environment is a failure of evidence production, not evidence that target behavior is missing.**
12. **Classify preimplementation applicability before execution; do not force speculative proof where requirements or environments are unresolved.**
13. **Production implementation begins only after every required initial proof and protected baseline are complete.**
14. **Do not weaken accepted proof to match incorrect implementation.**

## 3. Scope

This standard defines:

- the shared verification model;
- testing terminology and identifiers;
- verification methods;
- test levels;
- quality and risk coverage;
- risk-based proof selection;
- the minimum verification lifecycle;
- manual and specialist review boundaries;
- prohibited testing shortcuts.

This standard does not define:

- the application requirement being tested;
- exact schema behavior;
- exact security-control requirements;
- exact UI public APIs;
- exact operational procedures;
- implementation issue readiness;
- GitHub Project status;
- repository workflow authorization.

Those remain with their canonical owners.

## 4. Verification Model And Identifiers

Use this model:

```text
accepted requirement
        ↓
acceptance criterion (AC-*)
        ↓
declared proof (PF-*)
        ↓
proof execution
        ↓
evidence record and retained artifact
        ↓
testing gate evaluation
```

### Acceptance criterion

An acceptance criterion states what must be true.

Use stable identifiers:

```text
AC-01
AC-02
AC-03
```

An acceptance criterion may require multiple proofs.

### Verification proof

A proof states how one or more criteria will be demonstrated.

Use stable identifiers:

```text
PF-01
PF-02
PF-03
```

A proof may support multiple criteria only when the mapping is explicit.

### Proof execution

A proof execution records:

- applicability at the declared stage;
- whether execution occurred;
- the observed result;
- environment and revision;
- evidence and limitations.

### Testing gate

A testing gate evaluates whether required proof evidence is complete for a declared workflow stage. Testing evidence does not independently authorize implementation, merge, release, deployment, or closure.

Keep these concepts separate:

```text
acceptance criterion = what must be true
proof = how it is demonstrated
execution = what occurred when the proof ran
evidence = the reproducible record
gate = whether testing requirements for a stage are satisfied
```

Detailed contract, state, baseline, and evidence rules are defined in [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md).

## 5. Testing Classification

A complete proof declaration may include:

```text
requirement source
+ verification method
+ test level
+ quality concern
+ design technique
+ environment
+ execution stage
```

Example:

```text
Criterion:
AC-03 — An unauthorized User Account cannot suspend another User Account.

Proof:
PF-05

Method:
Automated dynamic test

Level:
Core Users and Access integration

Quality:
Functional correctness, authorization, audit

Technique:
Requirements-based negative path

Environment:
Laravel application with PostgreSQL

Stages:
Preimplementation and final targeted proof
```

Do not use vague labels such as “feature test,” “UI test,” or “security test” as the entire verification specification.

## 6. Verification Methods

### 6.1. Static verification

Static verification evaluates artifacts without executing the target runtime behavior.

Examples:

- syntax and compilation;
- type checking;
- linting and formatting;
- architecture and dependency rules;
- contract and schema validation;
- generated-manifest validation;
- secret scanning;
- dependency and supply-chain analysis;
- documentation metadata, links, and guardrails;
- code review;
- design and threat review.

Static verification may block implementation or delivery even when dynamic tests pass.

### 6.2. Dynamic automated verification

Dynamic automated verification executes software or tooling and evaluates observable results.

Examples:

- unit tests;
- capability and component tests;
- integration tests;
- API tests;
- database and migration tests;
- queue, Event, and Job tests;
- browser tests;
- performance tests;
- deployment smoke tests.

### 6.3. Manual verification

Manual verification is appropriate when a human must assess:

- visual hierarchy;
- interaction clarity;
- accessibility behavior not fully machine-verifiable;
- real external systems;
- native-platform behavior;
- operational recovery;
- usability;
- business acceptance;
- risk-sensitive evidence.

Manual verification must use a declared procedure and recorded result.

### 6.4. Specialist verification

Specialist review is required when acceptance depends on expertise not safely delegated to ordinary implementation review.

Examples:

- authentication and authorization;
- security-control validation;
- destructive or high-volume database changes;
- retention or erasure;
- concurrency-sensitive mutations;
- offensive security findings;
- accessibility assessment;
- production operations;
- design-sensitive UI.

## 7. Test Levels

| Level       | Primary purpose                                                                                         |
| ----------- | ------------------------------------------------------------------------------------------------------- |
| Unit        | Verify one isolated function, method, value object, rule, or pure behavior                              |
| Component   | Verify one independently usable technical component and its public API                                  |
| Capability  | Verify one Core capability or Module-owned behavior with owner-local dependencies                       |
| Integration | Verify Contracts and behavior across components, owners, processes, or services                         |
| System      | Verify the assembled application or a major subsystem against system requirements                       |
| End-to-end  | Verify a complete representative workflow through applicable layers and channels                        |
| Acceptance  | Verify that delivered behavior satisfies accepted user, administrator, business, or system requirements |
| Operational | Verify deployment, startup, migration, health, recovery, observability, and safe ongoing operation      |

The lowest level that provides reliable proof is preferred. Higher-level tests are added when lower levels cannot prove integration, configuration, transport, browser, deployment, or acceptance behavior.

## 8. Quality And Risk Coverage

Testing may need to cover:

### 8.1. Functional correctness

- success behavior;
- validation;
- rejection behavior;
- business rules;
- state transitions;
- calculations;
- side effects;
- Events, Jobs, Notifications, and audit evidence.

### 8.2. Security and privacy

- authentication;
- authorization;
- object and scope checks;
- abuse resistance;
- secret handling;
- safe input and output;
- audit and monitoring;
- retention and erasure;
- security headers;
- dependency and supply-chain controls.

Detailed security requirements remain under Security standards.

### 8.3. Data and persistence integrity

- schemas and migrations;
- keys, constraints, and uniqueness;
- transactions and rollback;
- concurrency and idempotency;
- classification and protection;
- retention and legal holds;
- backup and restore.

### 8.4. Reliability and resilience

- expected failures;
- timeouts;
- retries;
- duplicate delivery;
- degraded dependencies;
- recovery;
- restart behavior;
- queue and scheduler behavior.

### 8.5. Performance and scalability

- latency;
- throughput;
- query behavior;
- resource usage;
- load;
- stress;
- endurance;
- capacity;
- concurrency under representative conditions.

### 8.6. Compatibility and interoperability

- supported browsers;
- operating systems;
- runtime and framework versions;
- PostgreSQL behavior;
- API and integration compatibility;
- accepted backward compatibility.

### 8.7. Usability, accessibility, and UI conformance

- public Component Contracts;
- semantic usage;
- keyboard and screen-reader behavior;
- responsive behavior;
- visual hierarchy;
- motion and reduced motion;
- interaction feedback.

### 8.8. Maintainability and architecture

- owner boundaries;
- dependency direction;
- prohibited access;
- naming and placement;
- public Contract stability;
- documentation synchronization;
- testability.

### 8.9. Operational quality

- configuration;
- startup;
- builds;
- deployment;
- migrations;
- queues and scheduler;
- health checks;
- logging and monitoring;
- rollback and recovery.

## 9. Risk-Based Selection

The work packet must select proof proportional to:

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

## 10. Minimum Verification Lifecycle

Before preimplementation execution, classify each material `PF-*` proof for that stage:

```text
REQUIRED
Initial proof is mandatory.

CONDITIONAL
A declared prerequisite determines whether initial proof becomes required.

NOT_APPLICABLE
No separate preimplementation execution is required.
```

Detailed work-type, production-boundary, baseline, permitted-edit, and revision rules are defined in [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md).

For each changed acceptance criterion:

1. assign a stable `AC-*` identifier;
2. identify its canonical requirement source and owner;
3. define observable success and applicable rejection behavior;
4. declare one or more `PF-*` proofs;
5. map each proof to its criterion IDs;
6. declare method, level, environment, executor, stage, applicability, and expected result;
7. classify preimplementation applicability as `REQUIRED`, `CONDITIONAL`, or `NOT_APPLICABLE`;
8. declare the production implementation boundary and proof-only work allowed before initial execution;
9. execute the smallest valid initial proof when required;
10. classify the exact observed result;
11. record and protect the accepted baseline, preferably through a dedicated initial-proof commit;
12. implement without weakening protected proof;
13. rerun the accepted targeted proof with identical semantics and command, except for a preauthorized nonsemantic path-only update recorded by the contract;
14. run broader affected checks proportionate to risk;
15. retain structured evidence for material runs;
16. record remaining manual or specialist review;
17. evaluate testing completeness for the applicable workflow stage.

Do not force an executable initial proof that would silently choose unresolved architecture, schema, UI, security, compatibility, or operational behavior.

When no separate preimplementation execution is required, record the reason and still execute every declared final proof.

Access-sensitive behavior must test applicable allow and deny paths.

Mutation behavior must test applicable validation, rollback, retry, duplicate execution, idempotency, and after-commit effects.

## 11. Manual And Specialist Review

A passing automated suite is not final approval for:

- design-sensitive UI;
- usability;
- screen-reader interpretation;
- production environment posture;
- destructive recovery;
- risk acceptance;
- legal or privacy interpretation;
- complex authorization models;
- operational readiness.

Required review authority must be named before the work is considered complete.

## 12. Prohibited Shortcuts

Do not:

- use a passing assertion that does not exercise observable behavior;
- mark required behavior incomplete and call the implementation complete;
- delete or skip a failing accepted test solely to make a gate pass;
- substitute SQLite when PostgreSQL behavior is material;
- mock the behavior under test;
- treat visual snapshots as the only accessibility proof;
- treat code coverage as proof of requirement coverage;
- fix unrelated failures without scope authority;
- infer acceptance from a successful build alone;
- claim success when the required command or procedure was not run;
- treat `EXPECTED_NONPASS` as a general failure waiver;
- begin production implementation before a required initial proof and protected baseline;
- treat preimplementation `NOT_APPLICABLE` as permission to omit final proof;
- make an unrecorded change to protected proof;
- collapse applicability, execution status, and verification result into one ambiguous state;
- append material verification history to a shared source-controlled flat log.

## 13. Related

- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Feature Development Standards](../coding/Feature%20Development%20Standards.md)
- [Security Testing Standards](../security/Security%20Testing%20Standards.md)
- [ISO/IEC/IEEE 29119 Series](https://committee.iso.org/sites/jtc1sc7/home/projects/flagship-standards/isoiecieee-29119-series.html)
- [IBM: Software Testing](https://www.ibm.com/think/topics/software-testing)
- [NIST SP 800-218 Secure Software Development Framework](https://csrc.nist.gov/pubs/sp/800/218/final)

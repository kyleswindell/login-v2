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
summary: Defines the shared Login 2.0 testing taxonomy, principles, risk model, test levels, methods, and minimum verification baseline.
-->

# Testing And Verification Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Core Principles](#2-core-principles)
- [3. Scope](#3-scope)
- [4. Testing Classification](#4-testing-classification)
- [5. Verification Methods](#5-verification-methods)
  - [5.1. Static verification](#51-static-verification)
  - [5.2. Dynamic automated verification](#52-dynamic-automated-verification)
  - [5.3. Manual verification](#53-manual-verification)
  - [5.4. Specialist verification](#54-specialist-verification)
- [6. Test Levels](#6-test-levels)
- [7. Quality And Risk Coverage](#7-quality-and-risk-coverage)
  - [7.1. Functional correctness](#71-functional-correctness)
  - [7.2. Security and privacy](#72-security-and-privacy)
  - [7.3. Data and persistence integrity](#73-data-and-persistence-integrity)
  - [7.4. Reliability and resilience](#74-reliability-and-resilience)
  - [7.5. Performance and scalability](#75-performance-and-scalability)
  - [7.6. Compatibility and interoperability](#76-compatibility-and-interoperability)
  - [7.7. Usability, accessibility, and UI conformance](#77-usability-accessibility-and-ui-conformance)
  - [7.8. Maintainability and architecture](#78-maintainability-and-architecture)
  - [7.9. Operational quality](#79-operational-quality)
- [8. Risk-Based Selection](#8-risk-based-selection)
- [9. Minimum Verification Baseline](#9-minimum-verification-baseline)
- [10. Manual And Specialist Review](#10-manual-and-specialist-review)
- [11. Prohibited Shortcuts](#11-prohibited-shortcuts)
- [12. Related](#12-related)

## 1. Purpose

Define how Login 2.0 selects and organizes reliable proof that software, documentation, data, interfaces, and operational behavior satisfy accepted requirements.

Testing begins while requirements and acceptance criteria are being designed. It continues through implementation, integration, release, deployment, and operation.

## 2. Core Principles

1. **Every accepted behavior change requires proof.**
2. **Every acceptance criterion maps to at least one declared proof.**
3. **Use the narrowest reliable proof that demonstrates the requirement and its rejection behavior.**
4. **Test level, quality concern, verification method, design technique, environment, and delivery gate are separate classifications.**
5. **Automation is preferred for repeatable objective assertions, but automation does not replace required human or specialist judgment.**
6. **A passing test proves only what it actually asserts in the declared environment.**
7. **Coverage percentages are diagnostic signals, not acceptance evidence by themselves.**
8. **Tests, fixtures, UI Contracts, schemas, and review evidence are protected when accepted as part of a verification contract.**
9. **A broken test environment is a failure of evidence production, not evidence that target behavior is missing.**
10. **Do not weaken accepted proof to match incorrect implementation.**

## 3. Scope

This standard defines:

- the shared testing taxonomy;
- verification methods;
- test levels;
- quality and risk coverage;
- risk-based test selection;
- the minimum proof baseline;
- manual and specialist review boundaries;
- prohibited testing shortcuts.

This standard does not define:

- the application requirement being tested;
- exact schema behavior;
- exact security-control requirements;
- exact UI public APIs;
- exact operational procedures;
- implementation issue readiness;
- GitHub Project status.

Those remain with their canonical owners.

## 4. Testing Classification

A complete proof description may include:

```text
requirement source
+ verification method
+ test level
+ quality concern
+ design technique
+ environment
+ delivery gate
```

Example:

```text
Requirement:
An unauthorized User Account cannot suspend another User Account.

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

Gate:
Preimplementation targeted proof and unchanged final proof
```

Do not use vague labels such as “feature test,” “UI test,” or “security test” as the entire verification specification.

## 5. Verification Methods

### 5.1. Static verification

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

### 5.2. Dynamic automated verification

Dynamic automated verification executes software or tooling and evaluates observable results.

Examples:

- unit tests;
- capability and component tests;
- integration tests;
- API tests;
- database and migration tests;
- queue, event, and job tests;
- browser tests;
- performance tests;
- deployment smoke tests.

### 5.3. Manual verification

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

### 5.4. Specialist verification

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

## 6. Test Levels

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

## 7. Quality And Risk Coverage

Testing may need to cover:

### 7.1. Functional correctness

- success behavior;
- validation;
- rejection behavior;
- business rules;
- state transitions;
- calculations;
- side effects;
- Events, Jobs, Notifications, and audit evidence.

### 7.2. Security and privacy

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

### 7.3. Data and persistence integrity

- schemas and migrations;
- keys, constraints, and uniqueness;
- transactions and rollback;
- concurrency and idempotency;
- classification and protection;
- retention and legal holds;
- backup and restore.

### 7.4. Reliability and resilience

- expected failures;
- timeouts;
- retries;
- duplicate delivery;
- degraded dependencies;
- recovery;
- restart behavior;
- queue and scheduler behavior.

### 7.5. Performance and scalability

- latency;
- throughput;
- query behavior;
- resource usage;
- load;
- stress;
- endurance;
- capacity;
- concurrency under representative conditions.

### 7.6. Compatibility and interoperability

- supported browsers;
- operating systems;
- runtime and framework versions;
- PostgreSQL behavior;
- API and integration compatibility;
- accepted backward compatibility.

### 7.7. Usability, accessibility, and UI conformance

- public component Contracts;
- semantic usage;
- keyboard and screen-reader behavior;
- responsive behavior;
- visual hierarchy;
- motion and reduced motion;
- interaction feedback.

### 7.8. Maintainability and architecture

- owner boundaries;
- dependency direction;
- prohibited access;
- naming and placement;
- public Contract stability;
- documentation synchronization;
- testability.

### 7.9. Operational quality

- configuration;
- startup;
- builds;
- deployment;
- migrations;
- queues and scheduler;
- health checks;
- logging and monitoring;
- rollback and recovery.

## 8. Risk-Based Selection

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

High-risk work normally requires more than one proof type and may require specialist review.

Low-risk documentation or mechanical work does not require unrelated application suites.

## 9. Minimum Verification Baseline

For each changed acceptance criterion:

1. identify the requirement owner;
2. define observable success;
3. define applicable rejection behavior;
4. select the narrowest reliable proof;
5. declare environment, fixtures, actors, and command or procedure;
6. execute the smallest valid preimplementation proof when required;
7. implement without weakening protected proof;
8. rerun the same targeted proof unchanged;
9. run broader affected checks proportionate to risk;
10. record results and remaining manual or specialist review.

Access-sensitive behavior must test applicable allow and deny paths.

Mutation behavior must test applicable validation, rollback, retry, duplicate execution, idempotency, and after-commit effects.

## 10. Manual And Specialist Review

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

## 11. Prohibited Shortcuts

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
- treat `EXPECTED_NONPASS` as a general failure waiver.

## 12. Related

- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Feature Development Standards](../coding/Feature%20Development%20Standards.md)
- [Security Testing Standards](../security/Security%20Testing%20Standards.md)
- [ISO/IEC/IEEE 29119 Series](https://committee.iso.org/sites/jtc1sc7/home/projects/flagship-standards/isoiecieee-29119-series.html)
- [IBM: Software Testing](https://www.ibm.com/think/topics/software-testing)
- [NIST SP 800-218 Secure Software Development Framework](https://csrc.nist.gov/pubs/sp/800/218/final)

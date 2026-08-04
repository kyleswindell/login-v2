<!--
DOC-META
title: Automated And Static Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/automated-and-static-testing-standards.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines construction and evaluation rules for static verification, automated tests, unit, technical-component, capability, Contract, and architecture proofs, test-design techniques, doubles, assertions, coverage, and mutation analysis.
-->

# Automated And Static Testing Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Static Verification](#2-static-verification)
- [3. Automated Dynamic Tests](#3-automated-dynamic-tests)
- [4. Unit Testing](#4-unit-testing)
- [5. Technical-Component Testing](#5-technical-component-testing)
- [6. Capability Testing](#6-capability-testing)
- [7. Contract Testing](#7-contract-testing)
  - [7.1. Static Contract validation](#71-static-contract-validation)
  - [7.2. Dynamic provider Contract testing](#72-dynamic-provider-contract-testing)
  - [7.3. Consumer integration testing](#73-consumer-integration-testing)
- [8. Architecture And Placement Testing](#8-architecture-and-placement-testing)
- [9. Test-Design Techniques](#9-test-design-techniques)
  - [9.1. Specification-based techniques](#91-specification-based-techniques)
  - [9.2. Generative techniques](#92-generative-techniques)
  - [9.3. Structural techniques](#93-structural-techniques)
  - [9.4. Experience-based techniques](#94-experience-based-techniques)
  - [9.5. Change-focused techniques and proof modes](#95-change-focused-techniques-and-proof-modes)
- [10. Doubles And Isolation](#10-doubles-and-isolation)
- [11. Assertions And Test Quality](#11-assertions-and-test-quality)
- [12. Helpers, Datasets, And Shared Test Infrastructure](#12-helpers-datasets-and-shared-test-infrastructure)
- [13. Naming And Organization](#13-naming-and-organization)
- [14. Requirement Coverage, Code Coverage, And Mutation Analysis](#14-requirement-coverage-code-coverage-and-mutation-analysis)
  - [Requirement coverage](#requirement-coverage)
  - [Code coverage](#code-coverage)
  - [Mutation analysis](#mutation-analysis)
- [15. Prohibited Patterns](#15-prohibited-patterns)
- [16. Related](#16-related)

## 1. Purpose And Authority

Define construction and evaluation rules for repeatable automated and static verification.

This standard defines how automated and static proofs are built, executed, and reviewed. It does not define:

- application behavior;
- public Contracts;
- architecture rules;
- schema requirements;
- UI APIs;
- security controls;
- naming conventions;
- file placement;
- supported compatibility targets.

Those requirements remain with their canonical owners. Automated and static proofs enforce accepted requirements; they do not independently invent, broaden, or replace them.

## 2. Static Verification

Use applicable static verification for:

- PHP syntax and type constraints;
- JavaScript and CSS linting;
- formatting conformance;
- dependency direction;
- forbidden imports and paths;
- owner placement;
- architecture rules;
- duplicate identifiers;
- schema and Contract shape;
- unresolved placeholders;
- documentation metadata and links;
- dependency vulnerabilities;
- secret exposure;
- generated-manifest determinism;
- public API compatibility.

Static verification must:

- be deterministic for the same inputs and environment;
- produce actionable failure messages;
- identify the governing canonical rule when practical;
- distinguish source defects from tool or environment failures;
- avoid treating generated observations as reviewed target-state truth.

A verification gate must be non-mutating.

Use separate commands or modes for preparation and verification:

```text
formatter --write
Preparation action

formatter --check
Verification action
```

After a formatter, generator, fixer, or migration command rewrites files, rerun the applicable non-mutating verification against the resulting source.

A gate must not silently change the files it evaluates.

## 3. Automated Dynamic Tests

Automated dynamic tests must:

- execute observable behavior;
- map to declared `AC-*` criteria through `PF-*` proofs;
- be deterministic under the declared environment;
- isolate or control external state;
- assert meaningful outcomes;
- fail for one coherent behavioral reason;
- reach the intended target path;
- clean up owned test state;
- avoid production secrets and data;
- remain discoverable by the authoritative runner;
- declare special environment requirements;
- use PostgreSQL when PostgreSQL behavior is material;
- produce structured evidence when the run is material.

“One coherent behavioral reason” does not require one assertion. A test may need multiple assertions to prove one accepted outcome and its relevant side effects.

Select the narrowest test level that reliably proves the criterion.

## 4. Unit Testing

Use unit tests for isolated:

- value objects;
- pure calculations;
- normalization;
- parsing and serialization;
- deterministic mapping and classification;
- validation rules independent from framework integration;
- state-transition logic;
- policy decisions that can be evaluated without infrastructure;
- retry or backoff calculations;
- invariant enforcement in pure logic.

A unit test should not require:

- complete Laravel application boot;
- database access;
- HTTP;
- queues;
- filesystem;
- network services;
- multiple application owners.

Do not call a test “unit” when its proof depends on infrastructure or owner integration.

Use a real value object or collaborator when it is small, deterministic, and part of the behavior being proven. Do not mock ordinary pure collaborators merely to preserve a unit label.

## 5. Technical-Component Testing

A technical-component test verifies one independently usable implementation unit through its public API.

Examples include:

- parser;
- serializer;
- validator;
- registry implementation;
- repository adapter;
- transport adapter;
- cache adapter;
- filesystem adapter;
- reusable PHP service;
- reusable UI Component, when governed by the UI testing standard.

Technical-component tests may include limited infrastructure when that infrastructure is part of the component’s accepted Contract.

Verify applicable:

- accepted inputs;
- rejected inputs;
- public output;
- stable identifiers;
- state transitions;
- observable failure behavior;
- resource cleanup;
- configuration;
- compatibility behavior.

Technical-component tests must not silently become cross-owner capability or system tests.

UI Component testing also follows [UI, Accessibility, And Interaction Testing Standards](ui-accessibility-and-interaction-testing-standards.md).

## 6. Capability Testing

A capability test verifies one Core capability or Module-owned behavior with its accepted owner-local integration.

Capability tests may include:

- Laravel application boot;
- owner-local Actions and Queries;
- validation;
- authorization integration;
- owner-local persistence;
- Events;
- Jobs;
- Notifications;
- monitoring and audit behavior;
- Delivery Adapters;
- owner-local registration and configuration.

Verify applicable:

- success path;
- validation failure;
- unauthenticated denial;
- unauthorized denial;
- object-level denial;
- accepted scope denial;
- state-transition guards;
- unchanged durable state on rejection;
- transaction result;
- emitted Events;
- queued Jobs;
- Notifications;
- audit evidence;
- monitoring signals;
- public failure behavior.

A capability test remains within one primary owner. Cross-owner behavior belongs to integration testing.

Workspace-aware presentation may be tested as presentation context. Workspace must not be treated as a general persistence or authorization scope.

## 7. Contract Testing

Use Contract tests to verify accepted promises at owner or system boundaries.

Contracts may include:

- PHP interfaces;
- immutable Data Objects;
- public Operations and Queries;
- Events;
- Job request and result shapes;
- APIs and webhooks;
- Registry Extension Points;
- Contributions;
- UI Component APIs;
- configuration schemas;
- database Contracts;
- generated manifests;
- external integration adapters.

A Contract test must cite or route to the canonical Contract owner.

A Contract test must not:

- invent a missing Contract;
- expand accepted inputs or outputs;
- select unresolved compatibility behavior;
- make private implementation structure public by asserting it unnecessarily.

### 7.1. Static Contract validation

Use static validation for applicable:

- signatures;
- types;
- required fields;
- optional fields;
- allowed values;
- stable identifiers;
- schema shape;
- metadata;
- registration;
- dependency declarations;
- version declarations;
- prohibited fields or dependencies.

Static Contract validation proves shape and declaration. It does not prove runtime provider behavior.

### 7.2. Dynamic provider Contract testing

Use dynamic provider tests for applicable:

- accepted inputs;
- rejected inputs;
- serialization and deserialization;
- observable outputs;
- provider state changes;
- public errors;
- Event or Job semantics;
- compatibility behavior;
- deterministic output where required.

A provider Contract test does not replace owner-local capability tests when internal state, authorization, transactions, or side effects also matter.

### 7.3. Consumer integration testing

Consumer integration tests prove that a consumer correctly uses an accepted provider Contract.

Verify applicable:

- request construction;
- response handling;
- failure translation;
- compatibility expectations;
- unavailable-provider behavior;
- no dependency on provider-private implementation.

Consumer integration tests belong with the consumer or the accepted cross-owner integration proof.

A Contract test does not replace provider behavior tests or consumer integration tests.

## 8. Architecture And Placement Testing

Architecture tests may enforce accepted rules such as:

- owner-first placement;
- allowed dependency direction;
- prohibited Core-to-Module dependencies;
- UI independence from domain implementation;
- public Contract use across owners;
- prohibited generic ownerless paths;
- accepted namespaces;
- test placement;
- documentation ownership;
- no direct cross-owner Model or table access.

Every architecture assertion must cite the canonical architecture, decision, or standard that owns the rule.

Architecture tests must:

- enforce accepted target or compatibility rules explicitly;
- distinguish current transitional exceptions from target rules;
- avoid encoding inferred architecture;
- produce a clear path and rule violation;
- avoid rewriting source during verification.

Generated inventories or observations may support architecture tests but do not independently become architecture authority.

## 9. Test-Design Techniques

Select techniques based on accepted behavior and risk.

A `PF-*` declaration should name a technique only when the technique materially affects proof coverage or review.

### 9.1. Specification-based techniques

Use applicable:

- requirements-based testing;
- scenario or use-case testing;
- equivalence partitioning;
- boundary-value analysis;
- decision tables;
- state-transition testing;
- pairwise or combinatorial testing.

These techniques derive cases from accepted requirements and observable behavior.

### 9.2. Generative techniques

Use applicable:

- property-based testing;
- fuzz testing;
- model-based testing.

Generated cases must:

- preserve reproducibility;
- record seeds when applicable;
- use accepted invariants or models;
- minimize or retain failing examples where practical;
- avoid generating sensitive or unsafe data.

### 9.3. Structural techniques

Use structural analysis when code structure materially affects confidence.

Examples:

- statement execution;
- branch execution;
- condition coverage;
- path analysis for bounded critical logic.

Structural techniques supplement requirement-based proof. They do not establish requirement completeness.

### 9.4. Experience-based techniques

Use applicable:

- error guessing;
- exploratory testing.

Exploratory testing is normally manual or system-level proof and also follows [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md).

Experience-based findings do not silently redefine accepted requirements.

### 9.5. Change-focused techniques and proof modes

Regression selection and characterization support change-focused verification.

Characterization is a proof mode governed by [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md), not an independent source of accepted behavior.

Use characterization only for behavior explicitly accepted for preservation.

Regression selection should follow changed owners, Contracts, dependencies, schemas, security boundaries, UI primitives, and operational behavior.

Mutation analysis evaluates test strength and is governed separately in Section 14.

## 10. Doubles And Isolation

Use:

- fakes for controlled local implementations;
- stubs for fixed responses;
- spies for observing a public interaction;
- mocks only when the interaction itself is the accepted Contract;
- protocol or Contract doubles for unavailable external systems;
- service virtualization when protocol behavior matters.

A double must conform to the same public Contract as the real provider for the behavior it represents.

Use the real collaborator when:

- the boundary itself is material to the proof;
- the collaborator is deterministic and inexpensive;
- replacing it would hide the behavior claimed by the proof;
- integration semantics, transactions, serialization, queueing, or protocol behavior matter.

Do not:

- mock the behavior under test;
- mock every collaborator by default;
- use partial mocks to bypass real behavior;
- assert private-method calls;
- mock framework, database, queue, filesystem, browser, or provider behavior that the proof claims to verify;
- use a double that violates the provider Contract;
- let test doubles become a competing source of external API truth.

Critical external integrations require at least one authoritative Contract, sandbox, staged integration, or provider-compatible proof beyond local doubles.

## 11. Assertions And Test Quality

Assertions must prove applicable:

- return value or response;
- state change;
- unchanged state on rejection;
- database effects;
- emitted Events;
- queued Jobs;
- Notifications;
- audit evidence;
- monitoring signals;
- exception or public rejection;
- rendered semantic output;
- accessibility attributes;
- integration payloads;
- resource cleanup;
- compatibility behavior.

A test may contain multiple assertions when they establish one coherent accepted behavior.

For denied or failed paths, assert applicable:

- expected public rejection;
- unchanged durable state;
- no prohibited Event, Job, Notification, or external effect;
- required audit or monitoring evidence;
- no sensitive-data exposure.

Avoid:

- unconditional passing assertions;
- assertions that merely repeat fixture input;
- assertions against unstable irrelevant details;
- excessive private implementation assertions;
- tests that pass when the target path never executes;
- status-code-only proof when state or side effects matter;
- broad snapshots where focused semantic assertions are more reliable;
- assertion helpers that hide the expected behavior.

## 12. Helpers, Datasets, And Shared Test Infrastructure

Test helpers should improve clarity without hiding:

- actors;
- fixtures;
- state;
- inputs;
- expected outcomes;
- environment requirements.

Shared helpers must:

- have one clear owner;
- remain deterministic;
- preserve public test meaning;
- avoid creating broad hidden state;
- fail with actionable messages;
- not bypass accepted application invariants.

Datasets should:

- identify the condition, rejection reason, or expected outcome;
- keep materially distinct cases visible;
- avoid compressing unrelated behaviors into one opaque table;
- preserve stable case identity where evidence depends on a case.

A helper, factory, or dataset used by a protected baseline is itself protected when changing it could alter proof meaning.

## 13. Naming And Organization

Test names should describe:

- context;
- condition;
- expected outcome.

Dataset cases should describe the condition, rejection reason, or expected outcome.

Tests remain with the smallest clear owner according to Repository Architecture.

Named suites, filesystem paths, and groups remain separate execution dimensions:

- named suites represent stable test types;
- filesystem paths select owners;
- groups represent orthogonal execution characteristics.

Exact class, method, dataset, fixture, filename, casing, and directory patterns are owned by [Repository Naming Standards](../coding/repository-naming-standards.md).

Do not duplicate or redefine those naming rules here.

## 14. Requirement Coverage, Code Coverage, And Mutation Analysis

### Requirement coverage

Requirement coverage is represented by explicit:

```text
AC-* → PF-*
```

mapping.

A criterion is not covered merely because related code executed.

### Code coverage

Code coverage may identify unexecuted implementation paths.

It does not prove:

- requirements are complete;
- assertions are meaningful;
- rejection paths are covered;
- security controls are correct;
- integrations work;
- UI is usable or accessible;
- operational behavior is safe.

Do not set arbitrary repository-wide percentage targets.

A bounded work packet may declare risk-specific coverage expectations for:

- one owner;
- one critical algorithm;
- one security boundary;
- one migration;
- one proof.

Coverage configuration and exclusions must not hide executable production behavior without accepted justification.

### Mutation analysis

Mutation analysis may evaluate assertion strength for critical:

- pure logic;
- validation;
- access decisions;
- financial calculations;
- state transitions;
- security-sensitive behavior.

Mutation testing is optional unless a work packet makes it mandatory.

Record:

- mutation scope;
- tool and version;
- configuration;
- surviving mutations;
- excluded mutations and reason;
- limitations.

A surviving mutation requires review. It does not automatically require blanket test expansion.

Mutation results are test-quality evidence, not independent product requirements.

## 15. Prohibited Patterns

Do not:

- hide nondeterminism with automatic runner retries;
- depend on test execution order;
- depend on real wall-clock time when a controlled clock is possible;
- use random data without recording or controlling the seed;
- share mutable state across tests;
- depend on production services in ordinary local suites;
- suppress warnings that indicate invalid test behavior;
- leave required `markTestIncomplete()` or equivalent incomplete markers;
- use obsolete compatibility tests as authority after their behavior is intentionally removed;
- narrow the target command after the protected baseline merely to avoid failure;
- exclude failing cases from discovery;
- replace PostgreSQL with SQLite when semantics may differ;
- mock the boundary the proof claims to verify;
- use generated code or snapshots as a substitute for focused behavioral assertions;
- let a mutating formatter, generator, or fixer serve as the final verification gate;
- treat code coverage or mutation score as acceptance by itself.

## 16. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)
- [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md)
- [UI, Accessibility, And Interaction Testing Standards](ui-accessibility-and-interaction-testing-standards.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Repository Naming Standards](../coding/repository-naming-standards.md)

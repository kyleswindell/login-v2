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
summary: Defines proof-policy rules for static verification, automated dynamic tests, unit, technical-component, capability, Contract, and architecture proof, test-design techniques, doubles, assertions, coverage, and mutation analysis.
-->

# Automated And Static Testing Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Static Verification](#2-static-verification)
- [3. Automated Dynamic Proof](#3-automated-dynamic-proof)
- [4. Unit Testing](#4-unit-testing)
- [5. Technical-Component Testing](#5-technical-component-testing)
- [6. Capability Testing](#6-capability-testing)
- [7. Contract Testing](#7-contract-testing)
  - [Static Contract validation](#static-contract-validation)
  - [Dynamic provider Contract proof](#dynamic-provider-contract-proof)
- [8. Architecture And Placement Testing](#8-architecture-and-placement-testing)
- [9. Test-Design Techniques](#9-test-design-techniques)
  - [Specification-based](#specification-based)
  - [Generative](#generative)
  - [Structural](#structural)
  - [Experience-based and change-focused](#experience-based-and-change-focused)
- [10. Double-Selection Policy](#10-double-selection-policy)
- [11. Assertion-Quality Policy](#11-assertion-quality-policy)
- [12. Requirement Coverage, Code Coverage, And Mutation Analysis](#12-requirement-coverage-code-coverage-and-mutation-analysis)
  - [Requirement coverage](#requirement-coverage)
  - [Code coverage](#code-coverage)
  - [Mutation analysis](#mutation-analysis)
- [13. Prohibited Patterns](#13-prohibited-patterns)
- [14. Related](#14-related)

## 1. Purpose And Authority

Define proof-policy rules for repeatable static and automated verification.

This standard determines what automated or static proof means and what it must establish.

It does not define:

- application behavior;
- public Contracts;
- architecture;
- schema requirements;
- security controls;
- UI public APIs;
- exact naming or test placement;
- supported compatibility targets;
- PHPUnit, Laravel, Playwright, fixture, fake, dataset, or test-helper source construction.

Repository-specific test-source implementation belongs to the [Test Implementation Standards Index](../coding/test-implementation/index.md).

Automated and static proof enforce accepted requirements; they do not invent, broaden, or replace them.

## 2. Static Verification

Use applicable static verification for:

- syntax and compilation;
- type constraints;
- linting and formatting conformance;
- dependency direction;
- forbidden imports or paths;
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

A verification gate must not mutate the artifacts it evaluates.

Use separate preparation and verification modes where tooling supports both.

Example:

```text
formatter --write
Preparation

formatter --check
Verification
```

After a formatter, generator, fixer, migration, or other mutating preparation command, rerun the applicable non-mutating verification against the resulting source.

## 3. Automated Dynamic Proof

Automated dynamic proof must:

- execute observable behavior;
- map to declared `AC-*` criteria through `PF-*` proofs;
- run in a declared valid environment;
- isolate or control external state;
- assert meaningful outcomes;
- reach the intended target path;
- fail for a coherent reason;
- clean up owned state;
- avoid production secrets and unrestricted production data;
- remain discoverable by the authoritative runner;
- use PostgreSQL when PostgreSQL semantics are material;
- produce material evidence when the run is relied upon for formal testing acceptance.

One coherent behavior may require multiple assertions.

Select the narrowest test level that reliably establishes the criterion.

Do not infer test level from the runner, directory, or framework base class alone.

## 4. Unit Testing

Use unit proof for isolated behavior such as:

- value objects;
- pure calculations;
- normalization;
- parsing and serialization;
- deterministic mapping;
- validation rules independent from framework integration;
- state-transition logic;
- policy decisions that require no infrastructure;
- retry or backoff calculations;
- pure invariant enforcement.

Unit proof should not require:

- full Laravel application boot;
- database access;
- HTTP;
- queues;
- filesystem;
- network services;
- multiple application owners.

Do not call a proof “unit” merely because it is fast or lives in a `Unit` directory.

Use real small deterministic collaborators when they are part of the behavior being proven.

## 5. Technical-Component Testing

A technical-component test verifies one independently usable implementation unit through its public API.

Examples include:

- parser;
- serializer;
- validator;
- Registry implementation;
- repository adapter;
- transport adapter;
- cache adapter;
- filesystem adapter;
- reusable PHP service;
- reusable UI Component where governed by UI testing standards.

Technical-component proof may include limited infrastructure when that infrastructure is part of the accepted component Contract.

Verify applicable:

- accepted and rejected inputs;
- public output;
- stable identifiers;
- state transitions;
- observable failure behavior;
- cleanup;
- configuration;
- compatibility behavior.

Do not let a component test silently become a cross-owner or system proof.

## 6. Capability Testing

A capability test verifies one Core capability or Module-owned behavior with its accepted owner-local integration.

Capability proof may include Laravel boot, owner-local Actions and Queries, validation, authorization integration, persistence, Events, Jobs, Notifications, Audit, Monitoring, Delivery Adapters, registration, and configuration.

Verify the applicable success, rejection, denial, state-transition, durable-state, transaction, side-effect, Audit, Monitoring, and public-failure outcomes.

A capability proof remains within one primary application owner.

Cross-owner behavior belongs to integration testing.

Workspace may be presentation context. It must not be treated as a general persistence or authorization scope.

## 7. Contract Testing

Contract proof verifies accepted promises at owner or system boundaries.

Contracts may include PHP interfaces, immutable Data Objects, public Operations and Queries, Events, Job payloads, APIs/webhooks, Registry Extension Points, Contributions, UI Component APIs, configuration schemas, database Contracts, generated manifests, and external adapter Contracts.

Every Contract proof must cite the canonical Contract owner.

It must not:

- invent a missing Contract;
- broaden accepted inputs or outputs;
- select unresolved compatibility behavior;
- expose private implementation unnecessarily.

### Static Contract validation

Use static validation for applicable:

- signatures;
- types;
- required and optional fields;
- allowed values;
- stable identifiers;
- schema shape;
- metadata;
- registration;
- dependency or version declarations;
- prohibited fields or dependencies.

Static Contract validation proves shape and declaration, not runtime behavior.

### Dynamic provider Contract proof

Use dynamic provider proof for applicable:

- accepted and rejected inputs;
- serialization/deserialization;
- observable outputs;
- provider state changes;
- public errors;
- Event or Job semantics;
- deterministic output;
- compatibility behavior.

Provider Contract proof does not replace owner-local capability proof when internal authorization, transactions, or side effects also matter.

Consumer use of provider Contracts is integration proof and follows the applicable integration-testing standard.

## 8. Architecture And Placement Testing

Architecture proof may enforce accepted rules such as:

- owner-first placement;
- dependency direction;
- prohibited Core-to-Module dependency;
- UI independence from domain implementation;
- public Contract use across owners;
- prohibited generic ownerless paths;
- accepted namespaces;
- test placement;
- documentation ownership;
- no direct cross-owner Model or table access.

Every assertion must cite the canonical architecture, decision, or standard that owns the rule.

Architecture proof must:

- distinguish target rules from transitional exceptions;
- avoid encoding inferred architecture;
- produce actionable path/rule failures;
- remain non-mutating.

Generated inventories may support architecture proof. They do not become architecture authority.

## 9. Test-Design Techniques

Select techniques based on accepted behavior and risk.

A proof declaration should name a technique only when it materially affects coverage or review.

### Specification-based

Applicable techniques include requirements-based testing, scenario/use-case testing, equivalence partitioning, boundary-value analysis, decision tables, state-transition testing, and pairwise/combinatorial testing.

### Generative

Applicable techniques include property-based, fuzz, and model-based testing.

Generated cases must preserve reproducibility and use accepted invariants or models.

Record seeds when applicable and avoid generating sensitive or unsafe data.

### Structural

Applicable techniques include statement execution, branch execution, condition coverage, and bounded path analysis.

Structural coverage supplements requirement proof. It does not establish requirement completeness.

### Experience-based and change-focused

Error guessing and exploratory testing may supplement accepted proof.

Exploratory proof is normally manual or system-level and follows the applicable specialist standard.

Characterization is a proof mode for accepted preservation behavior, not a design technique.

Regression selection follows materially changed owners, Contracts, dependencies, schemas, security boundaries, UI primitives, and operational behavior.

## 10. Double-Selection Policy

Use a double only for a boundary intentionally excluded from the proof.

Applicable forms include fakes, stubs, spies, mocks when the public interaction is material, protocol/Contract doubles, and service virtualization.

A double must conform to the same accepted public Contract for the behavior it represents.

Use the real collaborator when:

- the boundary itself is material;
- the collaborator is deterministic and inexpensive;
- replacing it would hide the behavior claimed by the proof;
- integration, transactions, serialization, queueing, protocol, filesystem, browser, or provider semantics matter.

Do not:

- mock the subject under test;
- mock every collaborator by default;
- use partial mocks to bypass real behavior;
- assert private-method calls;
- replace a boundary the proof claims to verify;
- let a double become a competing external API authority.

Critical external integrations require authoritative Contract, sandbox, staged, or provider-compatible proof beyond local doubles.

How Laravel fakes, mocks, and test doubles are implemented in source is owned by [Fixtures, Doubles, And Async Test Implementation Standards](../coding/test-implementation/fixtures-doubles-and-async-test-implementation-standards.md).

## 11. Assertion-Quality Policy

Assertions must establish the applicable observable result: return/response, state change, unchanged rejection state, persistence, Events, Jobs, Notifications, Audit, Monitoring, public rejection, rendered semantics, accessibility attributes, integration payloads, cleanup, or compatibility behavior.

For denied or failed behavior, assert applicable:

- expected public rejection;
- unchanged durable state;
- absence of prohibited side effects;
- required Audit or Monitoring;
- no sensitive-data exposure.

Avoid:

- unconditional passing assertions;
- assertions that merely repeat fixture input;
- unstable irrelevant details;
- excessive private implementation assertions;
- proofs that pass when the target path never executes;
- status-only assertions when state or side effects matter;
- broad snapshots when focused semantic assertions are more reliable.

Assertion-helper source construction belongs to the [Test Source Lifecycle Standards](../coding/test-implementation/test-source-lifecycle-standards.md).

## 12. Requirement Coverage, Code Coverage, And Mutation Analysis

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

- requirement completeness;
- assertion quality;
- rejection-path coverage;
- security correctness;
- integration correctness;
- UI usability or accessibility;
- operational safety.

Do not set arbitrary repository-wide percentage targets.

A bounded work packet may define risk-specific coverage expectations for a named owner, algorithm, security boundary, migration, or proof.

Coverage exclusions must not hide executable production behavior without accepted justification.

### Mutation analysis

Mutation analysis may evaluate test strength for critical:

- pure logic;
- validation;
- access decisions;
- financial calculations;
- state transitions;
- security-sensitive behavior.

Mutation testing is optional unless the accepted work packet requires it.

Record applicable scope, tool/version, configuration, surviving mutations, exclusions, and limitations.

A surviving mutation requires review. It does not automatically require blanket test expansion.

Mutation results are test-quality evidence, not independent product requirements.

## 13. Prohibited Patterns

Do not:

- hide nondeterminism with automatic retries alone;
- depend on test execution order;
- depend on uncontrolled wall-clock time when a controlled clock is available;
- use uncontrolled randomness;
- share mutable state across tests without accepted isolation;
- depend on production services in ordinary local suites;
- suppress warnings that indicate invalid proof behavior;
- leave required proof incomplete;
- narrow the protected target command to avoid failure;
- exclude failing protected cases from discovery;
- substitute SQLite when PostgreSQL semantics are material;
- mock a boundary the proof claims to verify;
- redefine file placement, naming, fixtures, datasets, or test-source mechanics already owned by coding standards.

## 14. Related

- [Testing Standards Index](index.md)
- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Verification Contract Standards Index](verification-contract/index.md)
- [Reporting And Testing Gates Standards Index](reporting-and-gates/index.md)
- [Test Implementation Standards Index](../coding/test-implementation/index.md)
- [Repository Naming Standards](../coding/repository-naming-standards.md)

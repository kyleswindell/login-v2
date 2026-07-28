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
summary: Defines automated test construction, static verification, unit and capability tests, architecture and contract tests, design techniques, and test-quality rules.
-->

# Automated And Static Testing Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Static Verification](#2-static-verification)
- [3. Automated Dynamic Tests](#3-automated-dynamic-tests)
- [4. Unit Testing](#4-unit-testing)
- [5. Component And Capability Testing](#5-component-and-capability-testing)
- [6. Contract Testing](#6-contract-testing)
- [7. Architecture And Placement Testing](#7-architecture-and-placement-testing)
- [8. Test Design Techniques](#8-test-design-techniques)
  - [Requirements-based](#requirements-based)
  - [Equivalence partitioning](#equivalence-partitioning)
  - [Boundary-value analysis](#boundary-value-analysis)
  - [Decision tables](#decision-tables)
  - [State-transition testing](#state-transition-testing)
  - [Pairwise or combinatorial testing](#pairwise-or-combinatorial-testing)
  - [Property-based testing](#property-based-testing)
  - [Fuzz testing](#fuzz-testing)
  - [Characterization testing](#characterization-testing)
  - [Exploratory testing](#exploratory-testing)
- [9. Doubles And Isolation](#9-doubles-and-isolation)
- [10. Assertions And Test Quality](#10-assertions-and-test-quality)
- [11. Naming And Organization](#11-naming-and-organization)
- [12. Coverage And Mutation Analysis](#12-coverage-and-mutation-analysis)
- [13. Prohibited Patterns](#13-prohibited-patterns)
- [14. Related](#14-related)

## 1. Purpose

Define construction and review rules for repeatable automated and static verification.

## 2. Static Verification

Use applicable static checks for:

- PHP syntax and type constraints;
- JavaScript and CSS linting;
- formatting;
- dependency direction;
- forbidden imports and paths;
- owner placement;
- architecture rules;
- duplicate identifiers;
- schema and contract shape;
- unresolved placeholders;
- documentation metadata and links;
- dependency vulnerabilities;
- secret exposure;
- generated-manifest determinism;
- public API compatibility.

Static checks should produce deterministic output and actionable failure messages.

A static checker must not silently rewrite canonical source during validation unless the command is explicitly a formatter or generator step.

## 3. Automated Dynamic Tests

Automated tests must:

- execute observable behavior;
- be deterministic under their declared environment;
- isolate or control external state;
- assert meaningful outcomes;
- fail for the intended reason;
- clean up owned test state;
- avoid production secrets and data;
- remain discoverable by the authoritative runner;
- declare special environment requirements;
- use PostgreSQL when PostgreSQL behavior is material.

Select the narrowest level that proves the criterion.

## 4. Unit Testing

Use unit tests for isolated:

- value objects;
- pure calculations;
- validation rules;
- state-transition logic;
- policy decisions that can be evaluated without infrastructure;
- normalization;
- parsing and serialization;
- deterministic resolvers;
- retry or backoff calculations;
- mapping and classification logic.

A unit test should not require the complete Laravel application unless the behavior depends on framework integration.

Do not call a test “unit” when it requires database, HTTP, queues, filesystem, or multiple owners.

## 5. Component And Capability Testing

Use component or capability tests for:

- public component APIs;
- owner-local Actions and Queries;
- capability behavior with owner-local persistence;
- validation and authorization integration;
- domain Events and Notifications;
- error and rejection behavior;
- configuration and registration;
- owner-local Delivery Adapters;
- Module-owned workflows.

Core and Module tests must cover applicable:

- success paths;
- validation failures;
- unauthenticated denial;
- unauthorized denial;
- object and scope denial;
- state-transition guards;
- audit behavior;
- monitoring signals;
- Notifications;
- transaction outcomes.

Workspace-aware presentation may be tested as presentation context. Workspace must not be treated as a general persistence or authorization scope.

## 6. Contract Testing

Use contract tests to verify promises at owner boundaries.

Contracts may include:

- PHP interfaces;
- immutable Data Objects;
- public Operations and Queries;
- Events;
- Job request and result shapes;
- APIs and webhooks;
- Registry Extension Points;
- Contributions;
- UI component APIs;
- configuration schemas;
- database contracts;
- generated manifests;
- external integration adapters.

Contract tests should verify:

- accepted inputs;
- rejected inputs;
- required fields;
- optional fields;
- type and semantic constraints;
- version or compatibility expectations;
- stable identifiers;
- public failure behavior;
- deterministic serialization where applicable.

A contract test does not replace provider behavior tests or consumer integration tests.

## 7. Architecture And Placement Testing

Architecture tests should enforce accepted repository rules such as:

- owner-first placement;
- allowed direct dependencies;
- prohibited Core-to-Module dependencies;
- UI independence from domain implementation;
- public Contract use across owners;
- prohibited generic ownerless paths;
- accepted namespaces and naming;
- test placement;
- documentation ownership;
- no direct cross-owner Model or table access.

Architecture tests must cite the canonical architecture or standard that defines the rule.

## 8. Test Design Techniques

Select techniques based on behavior and risk.

### Requirements-based

Derive tests directly from accepted criteria and rejection behavior.

### Equivalence partitioning

Group inputs expected to behave the same and test representative members.

### Boundary-value analysis

Test values at and around accepted limits.

### Decision tables

Use when outcomes depend on combinations of permissions, states, flags, or conditions.

### State-transition testing

Use for lifecycle, workflow, session, installation, queue, and status transitions.

### Pairwise or combinatorial testing

Use when many independent options can combine and exhaustive testing is impractical.

### Property-based testing

Use for invariants across a large generated input space.

### Fuzz testing

Use for parsers, inputs, protocols, serialization, and security-sensitive boundaries where malformed data is a risk.

### Characterization testing

Use to preserve accepted current behavior before refactoring or moving implementation.

### Exploratory testing

Use structured human exploration for unknown interaction, workflow, compatibility, or usability risks.

The issue should name the technique when it materially affects proof coverage.

## 9. Doubles And Isolation

Use:

- fakes for controlled in-memory or local implementations;
- stubs for fixed responses;
- spies for interaction observation;
- mocks only when interaction is the actual contract;
- contract test doubles for unavailable external systems;
- service virtualization when protocol behavior matters.

Do not:

- mock the behavior under test;
- mock every collaborator by default;
- assert private implementation calls when observable behavior is sufficient;
- use a double that violates the provider’s public Contract;
- let test doubles become a competing source of external API truth.

Critical external integrations require at least one contract or staged integration proof beyond local doubles.

## 10. Assertions And Test Quality

Assertions must verify applicable:

- return value or response;
- state change;
- unchanged state on rejection;
- database effects;
- emitted Events;
- queued Jobs;
- Notifications;
- audit evidence;
- monitoring signal;
- exception or public rejection;
- rendered semantic output;
- accessibility attributes;
- integration payloads.

Avoid:

- unconditional passing assertions;
- assertions that merely repeat fixture input;
- assertions against unstable irrelevant details;
- excessive private-method testing;
- tests that pass when the target path is never executed;
- broad snapshots where focused semantic assertions are more reliable.

## 11. Naming And Organization

Use behavior-focused test names.

Recommended patterns:

- `<SubjectOrBehavior>Test`;
- `test_<context>_<expected_outcome>`;
- `<Flow>BrowserTest`;
- `<BoundaryOrRule>ArchitectureTest`;
- `<Subject>ContractTest`;
- `<Subject>Fixture`.

Dataset identifiers use descriptive snake case. Non-PHP fixture filenames use lowercase kebab-case by default.

Tests remain with the smallest clear owner according to Repository Architecture.

## 12. Coverage And Mutation Analysis

Code coverage may identify unexecuted code. It does not prove:

- requirements are complete;
- assertions are meaningful;
- rejection paths are covered;
- security controls are correct;
- integrations work;
- UI is usable or accessible.

Do not set arbitrary repository-wide percentage targets without a risk-based purpose.

Mutation testing may be used to evaluate assertion strength for critical pure logic, validation, access, financial, or security-sensitive code. Surviving mutations require review; they do not automatically require blanket test expansion.

## 13. Prohibited Patterns

Do not:

- hide nondeterminism with retries in the test runner;
- depend on execution order;
- depend on real wall-clock time when a controlled clock is possible;
- use random data without recording or controlling the seed;
- share mutable state across tests;
- depend on production services in ordinary local suites;
- suppress warnings that indicate invalid test behavior;
- leave required `markTestIncomplete()` calls;
- use obsolete compatibility tests as authority after their behavior is intentionally removed.

## 14. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)
- [Integration, System, And Acceptance Testing Standards](integration-system-and-acceptance-testing-standards.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Repository Naming Standards](../coding/repository-naming-standards.md)

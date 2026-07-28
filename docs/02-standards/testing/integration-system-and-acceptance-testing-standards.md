<!--
DOC-META
title: Integration, System, And Acceptance Testing Standards
doc_type: standard
status: draft
owner: docs
canonical: true
canonical_path: docs/02-standards/testing/integration-system-and-acceptance-testing-standards.md
parent: docs/02-standards/testing/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines cross-owner integration, API, event, queue, system, end-to-end, regression, characterization, smoke, and acceptance testing.
-->

# Integration, System, And Acceptance Testing Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Integration Boundaries](#2-integration-boundaries)
- [3. Cross-Owner Integration](#3-cross-owner-integration)
- [4. API And Protocol Integration](#4-api-and-protocol-integration)
- [5. Events, Jobs, Queues, And Schedulers](#5-events-jobs-queues-and-schedulers)
- [6. Database Integration](#6-database-integration)
- [7. System Testing](#7-system-testing)
- [8. End-To-End Testing](#8-end-to-end-testing)
- [9. Regression And Characterization](#9-regression-and-characterization)
  - [Regression testing](#regression-testing)
  - [Characterization testing](#characterization-testing)
- [10. Smoke And Sanity Testing](#10-smoke-and-sanity-testing)
- [11. Acceptance Testing](#11-acceptance-testing)
- [12. Manual And Exploratory Testing](#12-manual-and-exploratory-testing)
- [13. Scope Control](#13-scope-control)
- [14. Related](#14-related)

## 1. Purpose

Verify that independently tested components, capabilities, owners, services, and user workflows operate correctly when assembled.

## 2. Integration Boundaries

Integration tests are required when behavior crosses:

- Core capability owners;
- Core and Module;
- Module dependencies;
- application and database;
- HTTP and application behavior;
- application and external service;
- producer and consumer;
- Event and Listener;
- Job and worker;
- Registry Host and Contribution;
- backend and browser;
- deployment and infrastructure.

An integration test should identify both sides of the boundary and the public Contract being exercised.

## 3. Cross-Owner Integration

Cross-owner tests must use public Contracts.

Verify:

- provider success behavior;
- provider rejection behavior;
- consumer handling;
- boundary Data Object shape;
- authorization ownership;
- transaction ownership;
- Event or Job semantics;
- failure translation;
- unavailable dependency behavior;
- no direct Model, table, or implementation access.

Core must not require optional Module implementation for integration proof.

Module-to-Module tests require an accepted declared dependency.

## 4. API And Protocol Integration

API and protocol tests should verify applicable:

- authentication;
- authorization;
- content type;
- request and response schema;
- validation;
- status codes;
- pagination;
- filtering and sorting;
- idempotency;
- rate limits;
- error shape;
- version compatibility;
- signatures;
- replay protection;
- timeouts and retries;
- safe logging;
- external sandbox compatibility.

Consumer-driven contracts may supplement, but must not replace, provider-owned public Contract tests.

## 5. Events, Jobs, Queues, And Schedulers

Verify applicable:

- Event fact and payload;
- Listener registration;
- Job dispatch;
- queue selection;
- serialization;
- retry policy;
- timeout;
- backoff;
- duplicate delivery;
- idempotency;
- transaction and after-commit timing;
- failure recording;
- monitoring;
- failed-job behavior;
- scheduler registration and overlap protection.

A dispatch assertion alone does not prove worker execution.

Use a real queue or worker integration environment when execution semantics matter.

## 6. Database Integration

Database integration tests should verify:

- application and PostgreSQL behavior;
- owner-local migrations;
- foreign keys and constraints;
- transactions and rollback;
- unique and scoped uniqueness rules;
- cross-owner reference boundaries;
- projections;
- query behavior;
- retention or deletion guards;
- Module install, disable, uninstall, and reactivation behavior where applicable.

Exact schema requirements come from `docs/06-database/`.

## 7. System Testing

System testing verifies an assembled application or subsystem.

System proof may include:

- authentication and authorization;
- complete persistence behavior;
- external-service adapters;
- queues and scheduler;
- browser interaction;
- configuration;
- error handling;
- monitoring;
- nonfunctional concerns;
- recovery behavior.

System tests must be selective and risk-driven. Do not duplicate every lower-level case at system level.

## 8. End-To-End Testing

Use end-to-end tests for a small set of high-value representative workflows such as:

- sign-in and authentication assurance;
- User Account lifecycle;
- access assignment and denial;
- critical Setup or Settings changes;
- sensitive export;
- Module installation or activation;
- public/customer enrollment;
- operational recovery.

End-to-end tests should verify the user- or system-observable result rather than every internal step.

Keep the end-to-end suite small, reliable, and independent from one another.

## 9. Regression And Characterization

### Regression testing

Regression testing proves that accepted behavior remains correct after change.

Select regression scope based on:

- changed owner;
- public Contracts;
- dependent consumers;
- shared infrastructure;
- schema;
- security boundary;
- UI primitives;
- operational behavior.

### Characterization testing

Use characterization tests when accepted current behavior must be preserved during refactoring, movement, or replacement.

Characterization tests must not preserve behavior already classified as incorrect, deprecated, or disposable.

Record what behavior is being preserved and why.

## 10. Smoke And Sanity Testing

Smoke tests verify that a build or deployed system is stable enough for deeper testing.

Examples:

- application boots;
- critical routes respond;
- authentication entry is available;
- database connection works;
- migrations are at expected state;
- queue and scheduler services are reachable;
- production assets load;
- health checks are healthy.

Sanity tests verify a narrow changed area after a small update.

Neither replaces targeted behavioral proof.

## 11. Acceptance Testing

Acceptance testing verifies the delivered result against accepted requirements.

Acceptance may be:

- automated;
- repository-owner review;
- user acceptance;
- security acceptance;
- database acceptance;
- accessibility acceptance;
- operational acceptance.

Acceptance evidence must trace to criteria and required reviewers.

A stakeholder’s general approval does not replace failed mandatory proof.

## 12. Manual And Exploratory Testing

Use exploratory testing to investigate:

- unexpected workflows;
- unusual state combinations;
- usability;
- browser differences;
- integration timing;
- degraded dependencies;
- ambiguous failure feedback.

Exploratory testing requires a charter, environment, notes, findings, and result.

Findings outside scope are reported separately and do not silently expand implementation.

## 13. Scope Control

Do not:

- create an end-to-end test for every unit behavior;
- use system tests to bypass missing unit or integration coverage;
- run external live integrations in ordinary local suites without control;
- make tests depend on execution order;
- share state across end-to-end scenarios;
- classify a broad test failure as proof of one narrow missing behavior without isolation;
- use acceptance testing to redefine requirements after implementation.

## 14. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Automated And Static Testing Standards](automated-and-static-testing-standards.md)
- [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)
- [Public Contract And Interaction Model](../../03-architecture/public-contract-and-interaction-model.md)
- [IBM: Integration Testing](https://www.ibm.com/think/topics/integration-testing)
- [IBM: System Testing](https://www.ibm.com/think/topics/system-testing)

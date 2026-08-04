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
summary: Defines integration categories and ownership, cross-owner Contract verification, protocol, asynchronous, database, system, end-to-end, regression, smoke, exploratory, and acceptance proof standards.
-->

# Integration, System, And Acceptance Testing Standards

Parent: [Testing Standards Index](index.md)

- [1. Purpose And Authority](#1-purpose-and-authority)
- [2. Integration Categories](#2-integration-categories)
  - [2.1. In-process integration](#21-in-process-integration)
  - [2.2. Cross-owner integration](#22-cross-owner-integration)
  - [2.3. Process integration](#23-process-integration)
  - [2.4. Service integration](#24-service-integration)
  - [2.5. Infrastructure integration](#25-infrastructure-integration)
  - [2.6. Protocol integration](#26-protocol-integration)
- [3. Integration Proof Declaration](#3-integration-proof-declaration)
- [4. Integration-Test Ownership](#4-integration-test-ownership)
- [5. Cross-Owner Contract Integration](#5-cross-owner-contract-integration)
  - [5.1. Provider proof](#51-provider-proof)
  - [5.2. Consumer proof](#52-consumer-proof)
  - [5.3. Cross-owner workflow proof](#53-cross-owner-workflow-proof)
  - [5.4. Prohibited cross-owner proof](#54-prohibited-cross-owner-proof)
- [6. API And Protocol Integration](#6-api-and-protocol-integration)
- [7. Events, Listeners, Jobs, Queues, And Schedulers](#7-events-listeners-jobs-queues-and-schedulers)
  - [7.1. Declaration and dispatch proof](#71-declaration-and-dispatch-proof)
  - [7.2. Worker and consumer integration proof](#72-worker-and-consumer-integration-proof)
  - [7.3. Reliability proof](#73-reliability-proof)
  - [7.4. Transaction and visibility proof](#74-transaction-and-visibility-proof)
- [8. Registry, Contribution, And Application Registration Integration](#8-registry-contribution-and-application-registration-integration)
- [9. Database Integration](#9-database-integration)
- [10. System Testing](#10-system-testing)
  - [10.1. System-boundary declaration](#101-system-boundary-declaration)
  - [10.2. System-proof construction](#102-system-proof-construction)
  - [10.3. Replaced services and limitations](#103-replaced-services-and-limitations)
- [11. End-To-End Testing](#11-end-to-end-testing)
  - [11.1. Selection](#111-selection)
  - [11.2. Construction](#112-construction)
  - [11.3. Evidence and failure capture](#113-evidence-and-failure-capture)
  - [11.4. Scope limits](#114-scope-limits)
- [12. Regression Selection](#12-regression-selection)
- [13. Smoke Testing](#13-smoke-testing)
- [14. Acceptance Proof And Acceptance Authority](#14-acceptance-proof-and-acceptance-authority)
  - [14.1. Acceptance proof](#141-acceptance-proof)
  - [14.2. Acceptance authority](#142-acceptance-authority)
  - [14.3. Acceptance evidence](#143-acceptance-evidence)
- [15. Exploratory Testing](#15-exploratory-testing)
- [16. Integration And System Evidence](#16-integration-and-system-evidence)
- [17. Failure Classification](#17-failure-classification)
- [18. Scope Control And Prohibited Patterns](#18-scope-control-and-prohibited-patterns)
- [19. Related](#19-related)

## 1. Purpose And Authority

Define how independently tested components, capabilities, owners, processes, services, infrastructure, and representative workflows are verified when assembled.

This standard defines:

- integration categories;
- integration-proof declarations;
- test ownership;
- cross-owner Contract verification;
- API and protocol integration;
- asynchronous and worker integration;
- database integration;
- system boundaries;
- end-to-end proof;
- regression selection;
- smoke testing;
- exploratory testing;
- acceptance proof.

This standard does not define:

- public Contracts;
- cross-owner dependency rules;
- provider or consumer ownership;
- transport protocols;
- feature workflows;
- schema requirements;
- security controls;
- reliability policy;
- supported compatibility targets;
- operational procedures;
- acceptance authority;
- repository workflow.

Those requirements remain with their canonical architecture, feature, flow, database, security, UI, coding, integration, runbook, issue, and repository-workflow owners.

Tests enforce accepted boundaries. They do not independently invent, broaden, or replace them.

## 2. Integration Categories

An integration proof must identify its category or categories.

Do not use “integration test” as the entire proof description.

### 2.1. In-process integration

In-process integration verifies multiple application responsibilities within one runtime process.

Examples:

- Laravel boot and container binding;
- route, middleware, Form Request, policy, and Action;
- owner-local Action and PostgreSQL persistence;
- provider Contract and provider implementation;
- Event dispatch and in-process Listener execution;
- Registry and owner-local Contribution validation.

The proof must identify which real framework and application layers execute.

### 2.2. Cross-owner integration

Cross-owner integration verifies one application owner consuming another owner’s public Contract.

Examples:

- Module consuming a Core Query Contract;
- Core capability consuming another Core capability’s Operation Contract;
- Host Registry accepting a Module-owned Contribution;
- Navigation consuming normalized provider-owned navigation data;
- Product presentation consuming owner-controlled Query results.

Cross-owner proof must not use provider-private implementation, Models, repositories, tables, or internal projections.

### 2.3. Process integration

Process integration verifies behavior across separate runtime processes.

Examples:

- web process and queue worker;
- scheduler and Job worker;
- application and browser;
- command process and database;
- application and realtime worker;
- application and background export process.

A same-process fake or direct Handler invocation does not prove process integration.

### 2.4. Service integration

Service integration verifies communication with another service or separately deployed system.

Examples:

- provider API;
- email provider;
- object storage;
- identity provider;
- webhook provider;
- payment or accounting integration;
- monitoring service.

The proof must identify whether the external side is:

- local fake;
- protocol stub;
- mock server;
- service virtualization;
- provider sandbox;
- staged live service;
- production-safe service.

### 2.5. Infrastructure integration

Infrastructure integration verifies application behavior dependent on infrastructure.

Examples:

- PostgreSQL;
- Redis or accepted cache;
- queue backend;
- object storage;
- filesystem permissions;
- scheduler;
- reverse proxy;
- network policy;
- container service set;
- health and monitoring pipeline.

A framework fake does not prove the real infrastructure boundary.

### 2.6. Protocol integration

Protocol integration verifies one accepted transport or interchange Contract.

Examples:

- HTTP;
- JSON API;
- webhook;
- Event payload;
- Job payload;
- file format;
- command invocation;
- email;
- message envelope;
- signed URL.

The proof verifies the accepted protocol Contract. It does not define that Contract.

## 3. Integration Proof Declaration

Every material integration `PF-*` proof declares:

- proof ID;
- mapped `AC-*` criteria;
- integration category;
- provider or producing side;
- consumer or receiving side;
- public Contract or protocol;
- real participants;
- replaced participants;
- entry point;
- environment;
- actor or system identity;
- fixture or scenario;
- expected provider success;
- expected provider rejection;
- expected consumer handling;
- transaction or consistency owner;
- expected final observable result;
- cleanup;
- known limitations;
- required execution stages;
- evidence destination.

When one proof spans multiple categories, identify each category and the material boundary it proves.

A proof must not claim a real integration for a boundary replaced by a mock, fake, or direct private invocation.

## 4. Integration-Test Ownership

There is no generic shared “integration” application owner.

Use these ownership rules:

| Proof | Primary test owner |
| --- | --- |
| Provider public Contract | Provider |
| Provider implementation of public Contract | Provider |
| Consumer use of provider Contract | Consumer |
| Cross-owner workflow | Owner of the accepted workflow or flow Contract |
| Host Registry acceptance | Host |
| Contributor declaration and implementation | Contributor |
| Delivery Adapter transport translation | Delivery Adapter owner |
| System proof | Tested Product, subsystem, application, or accepted verification owner |
| End-to-end workflow | Owner of the accepted user or system workflow |
| Acceptance proof | The declared `PF-*` proof and named requirement owner |
| External service adapter | Adapter owner |
| Operational smoke | Applicable runbook or operational proof owner |

Test placement follows the smallest clear owner.

A cross-owner test must not become a shared behavior owner.

## 5. Cross-Owner Contract Integration

Cross-owner behavior must use provider-owned public Contracts.

The accepted architecture remains:

```text
Consumer
    ↓ provider-owned public Contract
Provider
    ↓ provider-owned result or rejection
Consumer handles the public result
```

### 5.1. Provider proof

Provider proof verifies applicable:

- public binding or availability;
- accepted input;
- validation;
- provider-owned authorization;
- provider invariants;
- transaction or consistency boundary;
- provider success result;
- provider rejection;
- Boundary Data Contract;
- Events and Jobs owned by the provider;
- public failure behavior;
- sensitivity and redaction;
- compatibility behavior.

Provider proof belongs to the provider.

### 5.2. Consumer proof

Consumer proof verifies applicable:

- construction of the accepted request or input;
- use of the provider Contract rather than concrete implementation;
- interpretation of provider results;
- handling of provider rejection;
- handling of provider unavailability;
- compatibility expectations;
- consumer-owned follow-up behavior;
- no access to provider-private state;
- no takeover of provider policy.

Consumer proof belongs to the consumer.

### 5.3. Cross-owner workflow proof

A cross-owner workflow proof verifies the accepted sequence across provider and consumer boundaries.

It should identify:

- workflow owner;
- participating owners;
- public Contracts;
- invocation order;
- authoritative success point;
- authoritative rejection point;
- transaction ownership;
- Events or Jobs;
- user- or system-observable result;
- rollback or compensation behavior when accepted;
- evidence and review authority.

Cross-owner workflow proof does not create a new shared coordinator unless canonical architecture or flow documentation already defines one.

### 5.4. Prohibited cross-owner proof

Do not prove cross-owner behavior through:

- direct provider Model access;
- direct provider repository access;
- direct provider table access;
- private provider Action import;
- provider-internal Query Builder;
- consumer dispatch of provider concrete Job;
- direct Registry mutation outside its Extension Point;
- service locator or arbitrary container lookup;
- fixtures that bypass the public boundary being tested.

A proof that bypasses the accepted boundary cannot establish Contract integration.

## 6. API And Protocol Integration

API and protocol integration tests verify accepted requirements defined by:

- Delivery Adapter owner;
- provider Contract;
- API or protocol Contract;
- Security standards;
- feature or flow owner;
- external provider Contract.

Verify applicable:

- request or message translation;
- content type and negotiation;
- input validation;
- authentication integration;
- authorization integration;
- provider Contract delegation;
- accepted status mapping;
- accepted error mapping;
- response or payload serialization;
- required headers;
- pagination;
- filtering and sorting;
- version compatibility;
- timeout handling;
- unavailable-provider handling;
- correlation and causation propagation;
- safe logging and evidence;
- protocol-specific security requirements.

Exact values and rules such as:

- signature algorithms;
- replay windows;
- rate limits;
- payload limits;
- error schemas;
- versioning policy;
- retry policy;
- redirect policy;

remain with their canonical owners.

A passing controller or route test does not prove an external provider integration.

A provider sandbox proof does not automatically prove production provider configuration.

Consumer-driven Contract tests may supplement provider-owned Contract tests. They must not replace provider authority or allow consumers to redefine the provider Contract.

## 7. Events, Listeners, Jobs, Queues, And Schedulers

Asynchronous testing is layered.

Do not treat one dispatch assertion as complete asynchronous proof.

### 7.1. Declaration and dispatch proof

Verify applicable:

- Event or Job identity;
- payload or Boundary Data Contract;
- registration;
- Listener or Handler registration;
- dispatch decision;
- queue selection;
- scheduler registration;
- serialization;
- correlation and causation fields;
- after-commit declaration;
- no prohibited sensitive data.

A fake queue or Event dispatcher may prove declaration and dispatch intent only.

### 7.2. Worker and consumer integration proof

Verify applicable:

- real worker or process consumes the message;
- Listener or Handler executes;
- committed state is visible;
- owner-controlled behavior runs;
- durable result is correct;
- expected follow-up Event, Job, Notification, audit, or monitoring signal occurs;
- failure is recorded;
- worker cleanup is correct.

Use a real queue or worker environment when worker execution semantics matter.

Direct Handler invocation does not prove queue or process integration.

### 7.3. Reliability proof

Verify accepted:

- retryable and non-retryable failure;
- timeout;
- backoff;
- maximum attempts;
- duplicate delivery;
- idempotency;
- overlap prevention;
- failed-job handling;
- recovery or replay;
- monitoring and operator visibility.

Exact reliability behavior remains with the applicable feature, coding, queue, or reliability owner.

Reliability proof also follows [Reliability, Performance, Compatibility, And Operational Testing Standards](reliability-performance-compatibility-and-operational-testing-standards.md).

### 7.4. Transaction and visibility proof

When transaction timing matters, verify applicable:

- Event or Job is dispatched at the accepted transaction stage;
- worker sees committed state;
- rollback suppresses prohibited effects;
- after-commit behavior occurs only after commit;
- independent connection sees the correct state;
- retry does not duplicate durable state.

Do not use a wrapping test transaction that hides the transaction behavior being proven.

## 8. Registry, Contribution, And Application Registration Integration

Registry and Contribution integration must preserve the accepted authority split.

Verify applicable:

### Contributor

- declaration shape;
- owner identity;
- Host identity;
- Registry key;
- Contribution key;
- artifact or implementation reference;
- declared dependencies;
- permitted metadata;
- source trace;
- Contributor-owned authorization and lifecycle.

### Application Registration

- structural validation;
- identity validation;
- path and class existence;
- owner and dependency validation;
- cycle detection;
- deterministic compilation;
- routing to the Host;
- source traceability;
- structural rejection.

### Host Registry

- Extension Point Contract compliance;
- semantic validation;
- Host compatibility;
- semantic duplicates;
- conflicts;
- ordering;
- availability;
- filtering;
- acceptance and rejection;
- resolved output.

The proof must not allow:

- Application Registration to decide Host policy;
- Contributor to mutate Registry internals;
- Host to take ownership of Contributor behavior;
- Core to import optional Module implementation;
- generated registration output to become reviewed truth.

## 9. Database Integration

Database integration verifies application behavior against accepted database requirements.

Use PostgreSQL for Login 2.0 application-persistence claims.

Verify applicable:

- application boot with PostgreSQL;
- migration and schema prerequisites;
- owner-local persistence;
- constraints through actual application operations;
- foreign-key behavior;
- uniqueness behavior defined by the canonical schema owner;
- transactions and rollback;
- cross-connection visibility;
- locking and concurrency;
- Query behavior;
- projection behavior;
- bounded cross-owner references;
- retention or deletion guards defined by canonical owners;
- Module install, disable, uninstall, and reactivation persistence behavior when accepted.

Exact:

- schemas;
- tables;
- columns;
- keys;
- indexes;
- constraints;
- uniqueness scope;
- projections;
- retention;
- migration behavior;

remain with database standards and `docs/06-database/`.

Do not use generic scope language unless the exact scope owner and rule are cited.

A database integration proof must identify its isolation strategy and must not affect shared data.

## 10. System Testing

System testing verifies an explicitly declared assembled application or subsystem boundary.

### 10.1. System-boundary declaration

Declare:

- system or subsystem name;
- owning Product, capability, Module, or application boundary;
- included owners;
- excluded owners;
- public entry points;
- real services;
- replaced services;
- infrastructure;
- actor or system identity;
- data baseline;
- environment;
- expected final result;
- cleanup;
- known limitations.

Examples:

- one Core subsystem;
- one Module and required Core dependencies;
- authenticated application surface;
- Module installation subsystem;
- Setup contribution subsystem;
- deployed application service set.

Do not call a proof “system testing” without defining the system boundary.

### 10.2. System-proof construction

System proof should:

- enter through a public Delivery Adapter, command, browser, worker, or other accepted entry point;
- exercise assembled public behavior;
- use accepted provider Contracts;
- use real PostgreSQL when persistence matters;
- include required infrastructure;
- assert user- or system-observable results;
- assert applicable rejection behavior;
- assert applicable audit, monitoring, Events, Jobs, or Notifications;
- avoid private implementation assertions;
- retain material evidence.

System tests should be selective and risk-driven.

Do not duplicate every unit, technical-component, capability, or integration case at system level.

### 10.3. Replaced services and limitations

When a service is replaced, record:

- replaced boundary;
- replacement type;
- behavior still proven;
- behavior not proven;
- separate proof that covers the real boundary;
- reason replacement is acceptable.

A system test with a fake external provider does not prove the external integration.

A system test with a fake queue does not prove worker execution.

## 11. End-To-End Testing

End-to-end testing verifies a small set of representative, high-value workflows through their material accepted layers and channels.

### 11.1. Selection

Use end-to-end proof for applicable critical workflows such as:

- sign-in and authentication assurance;
- User Account lifecycle;
- access assignment and denial;
- critical Setup or Settings workflow;
- sensitive export;
- Module installation or activation;
- customer or public enrollment;
- security-sensitive administrator operation.

Select workflows based on:

- business or operational criticality;
- security sensitivity;
- data-loss risk;
- integration complexity;
- user visibility;
- regression history;
- inability of lower-level proofs to establish the whole workflow.

Do not create an end-to-end test for every acceptance criterion.

### 11.2. Construction

An end-to-end proof should:

- use the real accepted entry point;
- cross the material layers of the workflow;
- use real browser behavior when the workflow is browser-owned;
- use real PostgreSQL behavior when persistence is material;
- use real workers when asynchronous execution is material;
- assert user- or system-observable outcomes;
- assert applicable denial or failure behavior;
- avoid private implementation assertions;
- use isolated scenario data;
- clean up only owned resources;
- declare external services that are real or replaced.

An end-to-end proof may replace an external service only when the proof explicitly does not claim that service integration and another accepted proof covers the real boundary when required.

### 11.3. Evidence and failure capture

Material end-to-end executions should retain applicable:

- structured runner report;
- per-run evidence manifest;
- screenshots;
- browser trace;
- console output;
- network trace;
- server logs;
- database or queue identifiers;
- failure video when supported;
- cleanup result.

Evidence must be secret-safe and tied to the exact revision and `PF-*` proof.

### 11.4. Scope limits

Keep the end-to-end suite:

- small;
- representative;
- independent;
- deterministic;
- isolated;
- evidence-capable;
- maintainable.

Do not use end-to-end tests as:

- the first or only proof for every criterion;
- a substitute for unit or capability tests;
- a substitute for Contract tests;
- a substitute for security review;
- a substitute for manual visual review;
- a place to assert every internal step.

Operational recovery belongs primarily to operational testing and runbooks, not ordinary end-to-end testing.

## 12. Regression Selection

Regression testing proves that accepted behavior remains correct after change.

Select regression proof based on:

- changed owner;
- changed public Contract;
- direct consumers;
- provider implementation;
- shared infrastructure;
- schema;
- security boundary;
- UI Element, Component, or Pattern;
- compatibility boundary;
- Event or Job consumers;
- deployment or operational behavior;
- prior defect history.

Use this sequence:

1. rerun the protected targeted `PF-*` proof;
2. run owner-local regression;
3. run direct provider or consumer integration proof;
4. run affected shared-infrastructure proof;
5. run selected system, browser, security, performance, or operational proof.

Do not run every suite as a substitute for selecting affected regression proof.

Characterization is a proof mode governed by [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md).

This document does not redefine characterization or baseline protection.

## 13. Smoke Testing

Smoke testing is a small, non-destructive proof that an assembled build or environment is stable enough for deeper testing or safe operation.

Smoke proof may establish applicable:

- application boots;
- critical entry points respond;
- authentication entry is available;
- database connection works;
- expected migration state exists;
- queue, cache, scheduler, or realtime service is reachable;
- production assets load;
- health endpoint is healthy;
- required configuration is present;
- deployed revision is correct.

Smoke testing does not prove:

- complete feature behavior;
- full security;
- full integration;
- acceptance;
- release readiness by itself;
- operational recovery.

A narrow behavioral confirmation after a change is a targeted regression proof, not “sanity testing.”

Do not use “sanity testing” as an official proof category.

## 14. Acceptance Proof And Acceptance Authority

Acceptance proof and acceptance authority are separate.

```text
Acceptance proof
    demonstrates AC-* criteria

Acceptance authority
    reviews evidence and decides whether to accept
```

### 14.1. Acceptance proof

Acceptance proof verifies delivered behavior against accepted requirements.

It may be:

- automated;
- manual;
- browser-based;
- repository-owner review;
- user acceptance;
- security review;
- database review;
- accessibility review;
- operational review.

Every mandatory acceptance proof receives a `PF-*` identifier.

Acceptance proof must identify:

- criteria;
- requirement owner;
- proof method;
- environment;
- procedure or command;
- expected result;
- evidence;
- reviewer when applicable.

### 14.2. Acceptance authority

Acceptance authority is the person, role, or accepted workflow owner permitted to accept the result.

Examples:

- repository owner;
- issue acceptance authority;
- security reviewer;
- database reviewer;
- accessibility reviewer;
- operational reviewer;
- user or business owner.

A proof cannot grant itself acceptance authority.

The implementing Codex session cannot approve its own specialist or repository-owner review.

### 14.3. Acceptance evidence

Acceptance evidence must trace:

```text
AC-* criterion
    ↓
PF-* proof
    ↓
execution record
    ↓
artifact or review evidence
    ↓
named acceptance authority
```

A general stakeholder statement does not replace:

- missing proof;
- failed proof;
- blocked proof;
- mandatory specialist review;
- protected-baseline violation.

Testing acceptance completeness does not independently authorize merge, release, deployment, or issue closure.

## 15. Exploratory Testing

Exploratory testing is a structured experience-based technique.

A material exploratory `PF-*` proof declares:

- charter;
- target system boundary;
- purpose;
- environment;
- actor;
- starting state;
- areas to explore;
- excluded areas;
- time box when useful;
- evidence to retain;
- expected result or review question;
- reviewer or executor.

Record:

- paths explored;
- state combinations;
- observations;
- findings;
- screenshots or traces when useful;
- limitations;
- result;
- follow-up classification.

Exploratory testing may investigate:

- unusual workflow sequences;
- unexpected state combinations;
- usability;
- browser differences;
- integration timing;
- degraded dependencies;
- ambiguous feedback;
- recovery behavior;
- accessibility behavior not fully machine-verifiable.

A finding may:

- demonstrate failure of an existing criterion;
- identify a possible new requirement;
- identify separate future work;
- reveal a proof or environment defect.

Exploratory findings do not:

- silently expand the current issue;
- redefine accepted behavior;
- authorize remediation outside scope;
- become accepted target state without owner review.

## 16. Integration And System Evidence

Material integration, system, end-to-end, smoke, exploratory, and acceptance runs should record applicable:

- proof ID;
- criterion IDs;
- integration category;
- provider and consumer;
- Contract or protocol;
- system boundary;
- entry point;
- actor;
- real participants;
- replaced participants;
- environment;
- fixture or scenario;
- command or procedure;
- revision;
- applicability;
- execution status;
- result;
- exit code;
- runner report;
- screenshots or trace;
- limitations;
- cleanup result;
- reviewer;
- artifact reference.

Evidence must make clear what was and was not proven.

Do not report a mocked or replaced boundary as a successful real integration.

## 17. Failure Classification

Use the accepted proof-state model.

### `BLOCKED`

Use when a known prerequisite prevents execution from beginning.

Examples:

- provider sandbox is unavailable;
- worker environment is not provisioned;
- required system dependency is incomplete;
- required reviewer is unavailable.

### `EXECUTED + FAIL`

Use when execution begins and:

- provider Contract binding fails;
- consumer uses the wrong boundary;
- application boot fails;
- protocol validation fails;
- worker does not consume the Job;
- fixture fails;
- browser fails;
- environment is invalid;
- expected result is not observed;
- replaced boundary invalidates the claimed proof;
- cleanup failure compromises evidence.

Do not use `EXPECTED_NONPASS` for environment, dependency, fixture, protocol, discovery, or tooling failure.

An unexpected pass where `EXPECTED_NONPASS` was required is `FAIL`.

## 18. Scope Control And Prohibited Patterns

Do not:

- use “integration test” without identifying the boundary;
- create a generic shared integration owner;
- bypass provider public Contracts;
- access another owner’s Model, repository, Query Builder, table, or private implementation;
- dispatch another owner’s concrete Job;
- use direct Handler invocation as proof of worker execution;
- use a fake queue as proof of retry or duplicate-delivery behavior;
- use a mocked provider as proof of real provider integration;
- use SQLite as proof of PostgreSQL application behavior;
- create an end-to-end test for every unit behavior;
- use system tests to bypass missing unit, capability, Contract, or integration proof;
- assert private implementation details in system or end-to-end proof;
- share state across end-to-end scenarios;
- depend on test execution order;
- run uncontrolled external live integration in ordinary local suites;
- classify a broad system failure as exact proof of one missing behavior without isolation;
- use smoke testing as acceptance;
- use “sanity testing” as an official proof category;
- use acceptance testing to redefine requirements after implementation;
- let a stakeholder statement override failed mandatory proof;
- let exploratory findings silently expand scope;
- claim an integration for a replaced boundary without declaring the limitation.

## 19. Related

- [Testing And Verification Standards](testing-and-verification-standards.md)
- [Verification Contract And Evidence Standards](verification-contract-and-evidence-standards.md)
- [Automated And Static Testing Standards](automated-and-static-testing-standards.md)
- [Test Environments, Data, And Fixtures Standards](test-environments-data-and-fixtures-standards.md)
- [Reliability, Performance, Compatibility, And Operational Testing Standards](reliability-performance-compatibility-and-operational-testing-standards.md)
- [UI, Accessibility, And Interaction Testing Standards](ui-accessibility-and-interaction-testing-standards.md)
- [Test Reporting And Delivery Gates Standards](test-reporting-and-delivery-gates-standards.md)
- [Public Contract And Interaction Model](../../03-architecture/public-contract-and-interaction-model.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)
- [Flow Documentation Index](../../05-flows/index.md)
- [Database Standards Index](../database/index.md)
- [Security Standards Index](../security/index.md)
- [Runbook Index](../../10-runbooks/index.md)

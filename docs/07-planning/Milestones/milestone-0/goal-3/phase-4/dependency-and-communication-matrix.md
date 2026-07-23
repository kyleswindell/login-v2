<!--
DOC-META
title: Phase 4 Dependency And Communication Matrix
doc_type: matrix
status: draft
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/dependency-and-communication-matrix.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_matrix.md
summary: Consolidates accepted dependency direction, cross-owner communication selection, prohibited coupling, declaration requirements, and future enforcement targets.
-->

# Phase 4 Dependency And Communication Matrix

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Use This Matrix For](#3-use-this-matrix-for)
- [4. Do Not Use This Matrix For](#4-do-not-use-this-matrix-for)
- [5. Authoritative Source Inputs](#5-authoritative-source-inputs)
- [6. Controlled Values](#6-controlled-values)
  - [6.1. Result](#61-result)
  - [6.2. Timing](#62-timing)
  - [6.3. Declaration](#63-declaration)
- [7. Dependency Direction Matrix](#7-dependency-direction-matrix)
- [8. Communication Selection Matrix](#8-communication-selection-matrix)
- [9. Prohibited Coupling Matrix](#9-prohibited-coupling-matrix)
- [10. Registration And Registry Distinctions](#10-registration-and-registry-distinctions)
- [11. Consolidation Review Result](#11-consolidation-review-result)
- [12. Phase 5 And Later Handoffs](#12-phase-5-and-later-handoffs)
- [13. Update Triggers And Maintenance](#13-update-triggers-and-maintenance)
- [14. Related](#14-related)

## 1. Purpose

This matrix answers two separate questions:

1. may one owner or role depend on another, and through which boundary;
2. which communication mechanism is required for a specific interaction need.

The dependency matrix owns structured edge classification. The communication matrix owns mechanism selection. Neither replaces the source decisions, Definitions, or later durable standards.

## 2. Status

- Document status: draft
- Review state: agent-proposed consolidation; repository-owner acceptance pending
- Source-decision state: Decisions 4.1 through 4.12 accepted
- Implementation state: target direction only
- Owning GitHub issue: #51
- Consolidation blocker: none found
- Phase 6 correction: broad owner-specific Surface dependency language is superseded by ADR-0008 and the Phase 6 correction below

### Phase 6 correction

Where this matrix uses Surface for ordinary Product presentation, interpret the edge as owner-specific Product presentation depending inward on its owner behavior and approved UI APIs. Frame rendering is a separate boundary: Core Navigation consumes public Workspace, Access, Module lifecycle, route-availability, and validated Contribution inputs; UI consumes normalized render data only. Navigation visibility does not replace authorization. No other dependency, communication, package declaration, registration, persistence, or failure rule in this matrix is changed.

## 3. Use This Matrix For

Use this matrix to:

- review a proposed dependency before implementation;
- choose synchronous, event-driven, deferred, delivery, extension, or registration communication;
- confirm required package or descriptor declarations;
- identify prohibited concrete, persistence, Surface, UI, optional-Module, or registration coupling;
- seed later architecture tests and registration validation;
- route final identifier and API naming to Phase 5.

## 4. Do Not Use This Matrix For

Do not use this matrix to:

- infer a dependency merely because one currently exists;
- authorize a dependency exception;
- replace owner-specific behavior, failure, security, or compatibility contracts;
- define exact event, job, route, alias, queue, Registry, descriptor, or manifest names;
- treat all events as dependency-free;
- treat all service-container bindings as public architecture Contracts;
- treat framework discovery as owner registration;
- replace the artifact-placement matrix.

## 5. Authoritative Source Inputs

| Key             | Source                                                                                                       |
| --------------- | ------------------------------------------------------------------------------------------------------------ |
| P3              | [Accepted Phase 3 target repository architecture](../target-repository-architecture.md)                      |
| P4.1            | [Decision 4.1 — Contract Placement](4-1-contract-placement.md)                                               |
| P4.2            | [Decision 4.2 — Implementation Placement](4-2-implementation-placement.md)                                   |
| P4.3            | [Decision 4.3 — Delivery Adapter Placement](4-3-delivery-adapter-placement.md)                               |
| P4.4            | [Decision 4.4 — Route Placement And Registration](4-4-route-placement-and-registration.md)                   |
| P4.5            | [Decision 4.5 — Configuration Placement](4-5-configuration-placement.md)                                     |
| P4.6            | [Decision 4.6 — Database And Migration Placement](4-6-database-and-migration-placement.md)                   |
| P4.7            | [Decision 4.7 — View And Asset Placement](4-7-view-and-asset-placement.md)                                   |
| P4.8            | [Decision 4.8 — Test Placement](4-8-test-placement.md)                                                       |
| P4.9            | [Decision 4.9 — Documentation Placement](4-9-documentation-placement.md)                                     |
| P4.10           | [Decision 4.10 — Dependency Direction](4-10-dependency-direction.md)                                         |
| P4.11           | [Decision 4.11 — Cross-Owner Communication](4-11-cross-owner-communication.md)                               |
| P4.12           | [Decision 4.12 — Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md)               |
| MATRIX-P        | [Artifact Placement Matrix](artifact-placement-matrix.md)                                                    |
| DEF-ACT         | [Action Definition](../../../../Definitions/Actions/Definition.md)                                           |
| DEF-QUERY       | [Query Definition](../../../../Definitions/Queries/Definition.md)                                            |
| DEF-CONTRACT    | [Contract Definition](../../../../Definitions/Contracts/Definition.md)                                       |
| DEF-DATA        | [Data Object Definition](../../../../Definitions/Data-Objects/Definition.md)                                 |
| DEF-EVENT       | [Event Definition](../../../../Definitions/Events/Definition.md)                                             |
| DEF-LISTENER    | [Listener Definition](../../../../Definitions/Listeners/Definition.md)                                       |
| DEF-JOB         | [Job Definition](../../../../Definitions/Jobs/Definition.md)                                                 |
| DEF-PROVIDER    | [Provider Definition](../../../../Definitions/Providers/Definition.md)                                       |
| DEF-DELIVERY    | [Delivery Adapter Definition](../../../../Definitions/Delivery-Adapters/Definition.md)                       |
| DEF-HOST        | [Host Definition](../../../../Definitions/Hosts/Definition.md)                                               |
| DEF-REGISTRY    | [Registry Definition](../../../../Definitions/Registries/Definition.md)                                      |
| DEF-EXT         | [Extension Point Definition](../../../../Definitions/Extension-Points/Definition.md)                         |
| DEF-CONTRIB     | [Contribution Definition](../../../../Definitions/Contributions/Definition.md)                               |
| DEF-CONTRIBUTOR | [Contributor Definition](../../../../Definitions/Contributors/Definition.md)                                 |
| DEF-REGISTER    | [Application Registration System Definition](../../../../Definitions/Application-Registration/Definition.md) |

## 6. Controlled Values

### 6.1. Result

| Value       | Meaning                                                                                                  |
| ----------- | -------------------------------------------------------------------------------------------------------- |
| Allowed     | The edge is permitted through the stated target and declaration                                          |
| Conditional | The edge is permitted only under all stated contract, declaration, optionality, and lifecycle conditions |
| Prohibited  | The edge must not exist in the target architecture                                                       |

### 6.2. Timing

| Value            | Meaning                                                                                         |
| ---------------- | ----------------------------------------------------------------------------------------------- |
| Synchronous      | The initiating call receives the required result or failure                                     |
| After the fact   | Consumers react after the provider has established the occurrence                               |
| Asynchronous     | Work is intentionally deferred from the initiating call                                         |
| Registration     | Composition occurs during build, cache preparation, bootstrap, or bounded deployment processing |
| Request/response | A Delivery Adapter translates an invocation channel and returns channel-specific output         |

### 6.3. Declaration

A declaration may be:

- a normal same-owner code dependency;
- a public Contract dependency;
- an explicit Composer or package dependency;
- an Owner Registration Descriptor dependency;
- an accepted Event or Listener registration;
- a Host Contribution declaration;
- a generated manifest instruction.

A declaration does not make a prohibited edge permissible.

## 7. Dependency Direction Matrix

| ID   | Consumer                         | Provider                                                                     | Allowed dependency target                                                                                           | Declaration                                                                      | Optionality                                                               | Result      | Prohibited access                                                                                                         | Future enforcement                                                  | Source                                               |
| ---- | -------------------------------- | ---------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- | ------------------------------------------------------------------------- | ----------- | ------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------- | ---------------------------------------------------- |
| D-01 | An owner-local role              | Another role under the same explicit owner and cohesive capability or Module | Owner-local Contract or concrete implementation when the dependency remains internal                                | Normal code dependency                                                           | Same lifecycle                                                            | Allowed     | No circular dependency; no generic owner bypass                                                                           | Owner-local architecture tests where material                       | P4.1; P4.2; P4.10                                    |
| D-02 | Core capability                  | Another Core capability                                                      | Provider-owned public Contract and provider-owned boundary Data Object                                              | Explicit code dependency; registration binding where required                    | Required Core provider                                                    | Allowed     | Provider internals, Models, repositories, tables, Delivery Adapters, or Surfaces                                          | Cross-Core import boundary test                                     | P4.1; P4.10; P4.11; DEF-CONTRACT; DEF-DATA           |
| D-03 | Core capability                  | Optional Module                                                              | None for required Core behavior                                                                                     | Not applicable                                                                   | Optional provider                                                         | Prohibited  | Module Contract, implementation, events, configuration, Models, tables, or registration output used as a Core requirement | Core-to-Module import and package dependency check                  | P4.10; P4.12                                         |
| D-04 | Core capability behavior         | Reusable UI                                                                  | None                                                                                                                | Not applicable                                                                   | UI may be installed with the application but is not a behavior dependency | Prohibited  | UI classes, Blade artifacts, CSS, JavaScript, presentation Contracts, or Surfaces                                         | Core behavior namespace import rule                                 | P4.10                                                |
| D-05 | Core-owned Surface               | Its owning Core capability                                                   | Owner-local Actions, Queries, Policies, Contracts, Data Objects, and workflows                                      | Normal owner-local dependency                                                    | Same owner                                                                | Allowed     | Another capability’s internals or persistence                                                                             | Surface-to-owner boundary tests                                     | P4.3; P4.7; P4.10; P4.11                             |
| D-06 | Core-owned Surface               | Reusable UI                                                                  | Published UI artifact and runtime APIs                                                                              | Blade component, UI Contract, or declared asset dependency                       | Reusable provider                                                         | Allowed     | UI internals outside the published API; Core or Module behavior moved into UI                                             | UI dependency and asset declaration checks                          | P4.7; P4.10                                          |
| D-07 | Module                           | Core capability                                                              | Provider-owned public Contract and provider-owned boundary Data Object                                              | Code dependency plus descriptor or Composer declaration where required           | Core provider is required                                                 | Allowed     | Core internals, Models, repositories, tables, Delivery Adapters, or Surfaces                                              | Module-to-Core import boundary test                                 | P4.1; P4.10; P4.11; DEF-CONTRACT; DEF-DATA           |
| D-08 | Module                           | Reusable UI                                                                  | Published UI artifact and runtime APIs                                                                              | Declared package or asset dependency where required                              | Reusable provider                                                         | Allowed     | UI implementation outside the public API; domain behavior placed in UI                                                    | Module-to-UI dependency check                                       | P4.7; P4.10                                          |
| D-09 | Module                           | Another Module                                                               | Provider Module’s public Contract and boundary Data Objects                                                         | Explicit Composer/package dependency and owner descriptor dependency             | Provider may be required only when declared                               | Conditional | Provider internals, Models, repositories, tables, Surfaces, or undeclared packages                                        | Composer dependency, descriptor dependency, and cycle checks        | P4.10; P4.11; DEF-CONTRACT                           |
| D-10 | Module                           | Another optional Module through a decoupled event                            | Approved public Event Contract designed for independent consumption                                                 | Accepted event registration; no concrete provider implementation import          | Publisher or consumer may be optional according to the event contract     | Conditional | Provider internals; Event used to hide a required synchronous result                                                      | Event registration and package-coupling review                      | P4.10; P4.11; DEF-EVENT; DEF-LISTENER                |
| D-11 | Module Contributor               | Host owned by Core, UI, or another permitted owner                           | Host-owned Extension Point Contract                                                                                 | Declared Contribution and accepted dependency on the public Host Contract        | Contributor may be optional                                               | Allowed     | Host internals, Registry implementation, or direct Registry mutation                                                      | Contribution target and Host Contract validation                    | P4.1; P4.10; P4.11; DEF-HOST; DEF-EXT; DEF-CONTRIB   |
| D-12 | Host                             | Contributor                                                                  | Accepted Contribution value or public callback Contract only                                                        | Host Registry resolves accepted Contributions                                    | Contributor is optional                                                   | Conditional | Contributor concrete implementation, package internals, or lifecycle assumptions                                          | Host-to-Contributor import prohibition                              | P4.10; P4.11; DEF-REGISTRY; DEF-CONTRIBUTOR          |
| D-13 | Host Registry                    | Contributor declaration                                                      | Contribution value satisfying the Host Contract                                                                     | Application Registration System may route the declaration; Registry validates it | Contributor is optional                                                   | Allowed     | Contributor implementation, arbitrary service lookup, or unvalidated filesystem discovery                                 | Registry validation and declaration-origin checks                   | P4.4; P4.11; DEF-REGISTRY; DEF-CONTRIB; DEF-REGISTER |
| D-14 | Reusable UI infrastructure       | Core capability                                                              | None                                                                                                                | Not applicable                                                                   | Domain provider                                                           | Prohibited  | Core Contracts, Models, Actions, Queries, Policies, configuration, or persistence                                         | UI-to-Core namespace import rule                                    | P4.10                                                |
| D-15 | Reusable UI infrastructure       | Module                                                                       | None                                                                                                                | Not applicable                                                                   | Optional domain provider                                                  | Prohibited  | Module Contracts, implementation, configuration, Models, routes, or assets as behavior dependencies                       | UI-to-Module namespace and package check                            | P4.10                                                |
| D-16 | Module-owned Surface             | Its owning Module                                                            | Owner-local Actions, Queries, Policies, Contracts, Data Objects, and workflows                                      | Normal package-local dependency                                                  | Same owner                                                                | Allowed     | Another owner’s internals or persistence                                                                                  | Surface-to-owner boundary tests                                     | P4.3; P4.7; P4.10; P4.11                             |
| D-17 | Module-owned Surface             | Reusable UI                                                                  | Published UI artifact and runtime APIs                                                                              | Declared package, Blade, or asset dependency                                     | Reusable provider                                                         | Allowed     | UI implementation outside the published API                                                                               | UI API and asset declaration checks                                 | P4.7; P4.10                                          |
| D-18 | Any owner-specific Surface       | Another owner’s Surface                                                      | None unless a separate provider-owned public Contract exists outside the Surface                                    | Not applicable                                                                   | Independent owner                                                         | Prohibited  | Surface classes, views, ViewModels, PageData, or interaction state                                                        | Cross-Surface import rule                                           | P4.10                                                |
| D-19 | Delivery Adapter                 | Its owning behavior                                                          | Owner-local Actions, Queries, Policies, Contracts, Data Objects, and workflows                                      | Normal owner-local dependency                                                    | Same owner                                                                | Allowed     | Another owner’s internals or business behavior implemented in the adapter                                                 | Adapter inward-dependency architecture test                         | P4.3; P4.10; P4.11; DEF-DELIVERY                     |
| D-20 | Owner behavior                   | Delivery Adapter                                                             | None                                                                                                                | Not applicable                                                                   | Delivery is replaceable                                                   | Prohibited  | Controllers, requests, commands, response objects, views, route definitions, or protocol resources                        | Behavior-to-delivery import rule                                    | P4.3; P4.10; DEF-DELIVERY                            |
| D-21 | Owner behavior                   | Laravel framework                                                            | Narrow framework abstractions accepted by the owner’s implementation contract                                       | Normal framework dependency                                                      | Framework is required                                                     | Conditional | Root Providers, route files, HTTP requests, console I/O, or service location used as hidden application ownership         | Framework-coupling review and architecture tests                    | P4.2; P4.10                                          |
| D-22 | Root Laravel integration         | Core, Module, or UI owner                                                    | Owner Registration Descriptor, public registration Contract, compiled manifest instruction, or owner-local Provider | Application registration dependency declaration                                  | Optional owners remain optional                                           | Allowed     | Owner internals or owner-specific behavior                                                                                | Root integration import allowlist                                   | P4.2; P4.4; P4.10; DEF-PROVIDER; DEF-REGISTER        |
| D-23 | Core, Module, or UI behavior     | Root Application Registrar, Registration Compiler, or compiled manifest      | None                                                                                                                | Not applicable                                                                   | Composition infrastructure                                                | Prohibited  | Registrar classes, compiler implementation, generated manifest, or typed registrars                                       | Owner-to-registration-infrastructure import rule                    | P4.4; P4.10; DEF-REGISTER                            |
| D-24 | Registration Compiler            | Owner Registration Descriptor                                                | Declared registration metadata and explicit owner dependencies                                                      | Descriptor schema                                                                | Owner may be optional according to installation state                     | Allowed     | Owner implementation behavior, request-time execution, or undeclared filesystem contents                                  | Schema validation, missing-resource, cycle, and stale-output checks | P4.4; P4.12; DEF-REGISTER                            |
| D-25 | Root Application Registrar       | Compiled Registration Manifest                                               | Validated typed registration instructions                                                                           | Generated manifest contract                                                      | Optional owners represented by accepted installation state                | Allowed     | Raw recursive filesystem discovery or owner behavior                                                                      | Manifest schema and stale-output validation                         | P4.4; P4.12; DEF-REGISTER                            |
| D-26 | Typed Registrar                  | Laravel, Livewire, Blade, Vite, Composer, or test tooling                    | Applicable native framework or build API                                                                            | Typed manifest instruction                                                       | Tool-specific                                                             | Allowed     | Feature behavior or ownership transfer                                                                                    | Typed registrar contract tests                                      | P4.4; P4.7; P4.8; DEF-REGISTER                       |
| D-27 | Cross-owner Listener             | Event provider                                                               | Public Event Contract and safe payload                                                                              | Accepted listener registration                                                   | Independent consumer                                                      | Conditional | Publisher internals, synchronous success dependency, Models, repositories, or tables                                      | Event Contract and listener independence tests                      | P4.10; P4.11; DEF-EVENT; DEF-LISTENER                |
| D-28 | Job                              | Another owner                                                                | Provider-owned public Contract when the deferred work requires that owner                                           | Declared package or owner dependency                                             | Provider availability defined by the Job contract                         | Conditional | Provider internals or a Job used to hide required immediate failure                                                       | Queued cross-owner dependency review                                | P4.10; P4.11; DEF-JOB; DEF-CONTRACT                  |
| D-29 | Owner-local test                 | Its production owner                                                         | Public and owner-internal implementation needed to prove the accepted contract                                      | Test-suite discovery                                                             | Test-only                                                                 | Allowed     | Unrelated owner internals or production dependency on test support                                                        | Production autoload and test-boundary checks                        | P4.8                                                 |
| D-30 | Cross-owner or architecture test | Multiple owners                                                              | Public Contracts, registration metadata, repository paths, or static dependency graph                               | Root test and CI configuration                                                   | Test-only                                                                 | Allowed     | Behavior mutation, hidden implementation coupling, or replacing owner-local proof                                         | Deterministic root test discovery                                   | P4.8; P4.12                                          |

## 8. Communication Selection Matrix

| ID   | Interaction need                                                                                                         | Required mechanism                                                                                         | Timing                                                                                        | Result expectation                                                   | Provider owner                                                                                 | Consumer dependency                                          | Failure behavior                                                                                                     | Prohibited substitute                                                                                                    | Source                                                                 |
| ---- | ------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------- | ------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------- |
| C-01 | Immediate state-changing operation requiring success, rejection, or returned data                                        | Provider-owned public Contract exposing an owner-controlled Action or another explicitly defined operation | Synchronous                                                                                   | Explicit result or exception/rejection contract                      | Owner of the state and behavior                                                                | Public Contract and provider-owned boundary Data Objects     | Returned or raised within the initiating operation; transaction behavior remains provider-owned                      | Event, Listener, Job, direct concrete Action import, shared service, or table mutation                                   | P4.1; P4.10; P4.11; DEF-ACT; DEF-CONTRACT; DEF-DATA                    |
| C-02 | Immediate read requiring authoritative data or visibility policy                                                         | Provider-owned public Query Contract                                                                       | Synchronous                                                                                   | Explicit query result, page, collection, or absence/rejection result | Owner of the data meaning and read policy                                                      | Public Query Contract and provider-owned result Data Objects | Returned or raised within the query boundary                                                                         | Direct Model, repository, table, internal Query import, or copied SQL                                                    | P4.10; P4.11; DEF-QUERY; DEF-CONTRACT; DEF-DATA                        |
| C-03 | Stable structured values crossing an owner boundary                                                                      | Provider-owned Data Object used by a public Contract                                                       | Matches the enclosing operation                                                               | Stable typed value contract                                          | Provider of the enclosing public operation                                                     | Data Object type and compatibility contract                  | Validation, serialization, privacy, and compatibility failures are provider-defined                                  | Provider Model, associative array with undocumented keys, neutral Shared DTO, or request object                          | P4.1; P4.10; P4.11; DEF-DATA; DEF-CONTRACT                             |
| C-04 | Announce that a meaningful occurrence completed                                                                          | Provider-owned Event                                                                                       | After the fact; synchronous dispatch or queued delivery according to the Event contract       | No required consumer result for publisher success                    | Owner of the occurrence and its meaning                                                        | Public Event Contract only                                   | Consumers fail independently according to listener and queue contracts                                               | Command disguised as Event, required synchronous mutation, or hidden dependency                                          | P4.10; P4.11; DEF-EVENT                                                |
| C-05 | React independently to a completed fact                                                                                  | Consumer-owned Listener                                                                                    | Synchronous or queued according to the Listener contract, but independent of publisher result | Reaction-specific outcome                                            | Owner of the reaction behavior                                                                 | Public Event Contract; consumer’s own behavior               | Listener owns idempotency, retry, ordering, and failure reporting                                                    | Publisher-owned Listener, Event-provider internals, or essential primary mutation hidden in a Listener                   | P4.10; P4.11; DEF-LISTENER; DEF-EVENT                                  |
| C-06 | Perform deliberately deferred, retryable, scheduled, or isolated work                                                    | Owner-controlled Job                                                                                       | Asynchronous or scheduled                                                                     | Acknowledged dispatch plus later Job outcome                         | Owner of the deferred behavior                                                                 | Owner behavior and permitted public Contracts                | Job owns retryability, timeout, idempotency, permanent failure, and observability                                    | Job used to avoid a required immediate result or to conceal ownership                                                    | P4.3; P4.10; P4.11; DEF-JOB                                            |
| C-07 | Translate an inbound HTTP, API, or browser request                                                                       | Owner-controlled HTTP Delivery Adapter                                                                     | Request/response                                                                              | Protocol response, redirect, view, resource, or error                | Owner of the exposed behavior                                                                  | Owning behavior and permitted public Contracts               | Transport validation and response mapping; application failure remains owner-defined                                 | Business workflow in controller, direct cross-owner persistence, or root feature controller                              | P4.3; P4.10; P4.11; DEF-DELIVERY                                       |
| C-08 | Translate an inbound console or operator invocation                                                                      | Owner-controlled Console Delivery Adapter                                                                  | Command invocation                                                                            | Exit code, console output, acknowledgement, or explicit failure      | Owner of the invoked behavior                                                                  | Owning behavior and permitted public Contracts               | Transport parsing and output mapping; behavior failure remains owner-defined                                         | Business workflow in command, hidden service location, or root feature command                                           | P4.3; P4.10; P4.11; DEF-DELIVERY                                       |
| C-09 | Translate an inbound webhook or external protocol callback                                                               | Owner-controlled Delivery Adapter or owner-specific integration implementation                             | Request/acknowledgement; deferred work where accepted                                         | Protocol acknowledgement and explicit validation/rejection           | Owner of the invoked integration behavior                                                      | Owning behavior and approved external integration Contract   | Signature, replay, parsing, and acknowledgement failures are adapter-specific; deferred processing follows Job rules | Generic Adapter owner, direct domain mutation without owner behavior, or hidden cross-owner table access                 | P4.3; P4.10; P4.11; DEF-DELIVERY                                       |
| C-10 | Extend a Host-owned feature                                                                                              | Host Extension Point Contract plus Contributor-owned Contribution                                          | Registration and later Host resolution                                                        | Accepted/rejected Contribution and Host-resolved output              | Host owns Contract, Registry, ordering, and resolution; Contributor owns Contribution behavior | Host public Extension Point Contract                         | Registration validation rejects invalid or unknown targets; Host defines runtime rejection and availability behavior | Host internal import, direct Registry mutation, arbitrary boot side effect, or generic `Contrib/` registration           | P4.1; P4.4; P4.10; P4.11; DEF-HOST; DEF-REGISTRY; DEF-EXT; DEF-CONTRIB |
| C-11 | Declare owner routes, Providers, commands, views, Livewire aliases, migrations, config, assets, Events, or Contributions | Owner Registration Descriptor                                                                              | Build, cache-preparation, bootstrap, or deployment composition                                | Validated declaration                                                | Owner of each declared artifact                                                                | Descriptor schema and explicit owner dependencies            | Missing, duplicate, conflicting, cyclic, unknown, or stale declarations fail validation                              | Filesystem presence, uncontrolled glob, request-time scanning, or Provider side effects as hidden canonical registration | P4.4; P4.12; DEF-REGISTER                                              |
| C-12 | Compose validated owner declarations into the Laravel and build runtime                                                  | Registration Compiler, Compiled Registration Manifest, Root Application Registrar, and Typed Registrars    | Compile before or during bounded bootstrap; not arbitrary request-time discovery              | Deterministic ordered registration                                   | Application-wide composition infrastructure; registered behavior retains its original owner    | Validated descriptors and native framework/build APIs        | Compilation or bootstrap fails on invalid required registration; native Laravel/Vite errors remain visible           | Host Registry, service container, Module Definition, or filesystem scan treated as the complete system                   | P4.4; P4.12; DEF-PROVIDER; DEF-REGISTER                                |

## 9. Prohibited Coupling Matrix

| ID   | Prohibited pattern                                                                   | Reason                                                                            | Required replacement                                                              | Future enforcement                                | Source                                  |
| ---- | ------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------- | --------------------------------------------------------------------------------- | ------------------------------------------------- | --------------------------------------- |
| X-01 | Direct import of another owner’s concrete implementation                             | Bypasses the provider’s compatibility and ownership boundary                      | Provider-owned public Contract                                                    | Namespace/import architecture test                | P4.1; P4.10; P4.11                      |
| X-02 | Cross-owner Model, repository, table, or raw query access                            | Transfers persistence assumptions and policy outside the owner                    | Public Query or operation Contract                                                | Static import and database-access review          | P4.10; P4.11                            |
| X-03 | Core dependency on an optional Module                                                | Makes required base behavior depend on optional installation state                | Core-owned Contract or inversion through a Host Extension Point                   | Composer and import dependency check              | P4.10; P4.12                            |
| X-04 | Undeclared or cyclic Module dependency                                               | Breaks package independence and deterministic installation                        | Explicit public Contract plus declared acyclic dependency                         | Composer/descriptor graph validation              | P4.10; P4.12                            |
| X-05 | Reusable UI depending on Core or Module domain implementation                        | Turns presentation infrastructure into a domain owner                             | Owner-specific Surface depends on reusable UI instead                             | UI namespace import rule                          | P4.10                                   |
| X-06 | Owner behavior depending on Delivery Adapters or Surfaces                            | Reverses the inward dependency direction                                          | Adapters and Surfaces depend on owner behavior                                    | Architecture dependency rule                      | P4.3; P4.10                             |
| X-07 | Event used as a command requiring an immediate result                                | Hides a required synchronous dependency and failure path                          | Public synchronous Contract                                                       | Event-contract review                             | P4.11; DEF-EVENT                        |
| X-08 | Job used to hide a required immediate dependency                                     | Defers required success or rejection semantics                                    | Public synchronous Contract; Job only after accepted acknowledgement              | Job-contract review                               | P4.11; DEF-JOB                          |
| X-09 | Generic shared service, helper, facade, static state, or concrete service location   | Creates unowned communication and hidden coupling                                 | Narrow owner-controlled operation or public Contract                              | Generic-path, naming, and service-location checks | P4.2; P4.10; P4.11                      |
| X-10 | Contributor importing Host internals or mutating Registry state directly             | Breaks Host authority and extension compatibility                                 | Host Extension Point Contract and Registry submission                             | Contribution dependency test                      | P4.10; P4.11                            |
| X-11 | Host importing Contributor implementation                                            | Makes Host behavior require optional Contributor code                             | Registry consumes accepted Contribution values                                    | Host-to-Contributor import prohibition            | P4.10; P4.11                            |
| X-12 | Boot-time side effects or recursive filesystem scans as hidden registration          | Makes registration nondeterministic and unvalidated                               | Owner descriptor plus deterministic compiler and manifest                         | Registration compiler and stale-manifest checks   | P4.4; P4.12                             |
| X-13 | `Contrib/<Host>/` used for general routes, views, commands, assets, or configuration | Confuses Host extension with ordinary application registration                    | Owner descriptor and the applicable owner-local role                              | Contribution target validation                    | P4.4; P4.11                             |
| X-14 | Application Registration System treated as a Host Registry                           | Composition metadata and Host entry authority have different owners and contracts | Compiler routes declared Contributions; Host Registry validates and resolves them | Typed registrar and Registry contract tests       | P4.4; P4.11; DEF-REGISTRY; DEF-REGISTER |

## 10. Registration And Registry Distinctions

| Mechanism                       | Canonical input                                               | Primary responsibility                                                                      | Canonical output                                                    | Does not own                                                                 |
| ------------------------------- | ------------------------------------------------------------- | ------------------------------------------------------------------------------------------- | ------------------------------------------------------------------- | ---------------------------------------------------------------------------- |
| Application Registration System | Owner Registration Descriptors                                | Validate, dependency-order, compile, and compose framework/build registration               | Compiled Registration Manifest and typed registration execution     | Feature behavior, Host entry semantics, native Laravel/Vite caches or builds |
| Host Registry                   | Contributions satisfying Host-owned Extension Point Contracts | Validate, accept/reject, order, filter, and resolve entries for one extensible Host feature | Host-resolved Registry output                                       | General route, view, command, migration, config, or asset registration       |
| Laravel service container       | Bindings registered through accepted Laravel integration      | Resolve runtime dependencies according to Laravel container behavior                        | Resolved objects and bindings                                       | Architecture ownership, descriptor compilation, Host Registry semantics      |
| Module Definition               | Module-owned package metadata and declarations                | Describe one Module and supply its owner registration metadata                              | Module descriptor data consumed by package/application registration | Application-wide dependency compilation or other owners’ metadata            |
| Filesystem discovery            | Files present beneath scanned paths                           | Observation or bounded tooling input only when explicitly authorized                        | Observed candidate files                                            | Canonical registration, ownership, acceptance, or deterministic composition  |

The normal Contribution path is:

```text
Contributor-owned declaration
→ Application Registration System validation and routing
→ Host Registry validation and resolution
→ Host-owned resolved output
```

Registration does not transfer ownership. The Registration Compiler does not decide Host entry semantics, and the Host Registry does not become the application-wide registrar.

## 11. Consolidation Review Result

No new dependency or communication decision is required before owner review.

The consolidation confirms:

- Core remains independent of optional Modules;
- cross-owner synchronous behavior uses provider-owned public Contracts;
- cross-owner reads use public Query Contracts;
- boundary Data Objects remain provider-owned;
- Events announce completed facts and do not replace required synchronous results;
- Jobs represent deliberately deferred work and do not hide immediate dependencies;
- Surfaces and Delivery Adapters depend inward on owner behavior;
- reusable UI does not depend on Core or Module domain implementation;
- Module-to-Module dependencies are explicit, public-Contract based, and acyclic unless an accepted decoupled Event or Host Extension Point intentionally preserves optional ownership;
- the Application Registration System, Host Registry, Laravel service container, Module Definition, and filesystem observation remain distinct mechanisms.

Repository-owner review should confirm edge completeness and conditional wording rather than repeat Decisions 4.10 and 4.11.

## 12. Phase 5 And Later Handoffs

Phase 5 owns final:

- Contract, Query, Action, Event, Listener, Job, and Data Object names;
- package dependency and descriptor dependency keys;
- Event keys and Listener keys;
- queue, Job, schedule, and command keys;
- Extension Point, Registry, Contribution, and Contributor identifiers;
- descriptor, compiler, manifest, registrar, and generated-output names;
- Livewire aliases, view namespaces, route names, and middleware aliases.

Later implementation and verification work owns:

- static cross-owner import checks;
- Core-to-Module dependency checks;
- Composer and descriptor cycle validation;
- Registry and Contribution validation;
- Event and Listener independence tests;
- registration compiler, manifest, and stale-output checks;
- test-discovery and production-autoload checks.

## 13. Update Triggers And Maintenance

Update this matrix when:

- a Phase 4 decision or reusable Definition is amended;
- Phase 5 accepts final names that replace conceptual labels;
- an accepted exception permits one bounded edge;
- Phase 6 representative validation discovers a missing or contradictory edge;
- durable architecture or coding standards replace planning links as the primary source.

Maintenance rules:

- keep every edge directional;
- separate legal dependency from communication timing;
- identify the provider owner for every public boundary;
- do not classify a dependency as allowed only because Laravel can resolve it;
- do not treat Event or Job indirection as automatic decoupling;
- preserve explicit optionality and failure behavior;
- keep future enforcement targets aligned with the accepted edge.

## 14. Related

- [Phase 4 Index](index.md)
- [Artifact Placement Matrix](artifact-placement-matrix.md)
- [Durable Promotion Register](durable-promotion-register.md)
- [Definitions Index](../../../../Definitions/Index.md)
- [Application Registration System Definition](../../../../Definitions/Application-Registration/Definition.md)
- Related GitHub issue: #51

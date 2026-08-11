<!--
DOC-META
title: Public Contract And Interaction Model
doc_type: architecture
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/public-contract-and-interaction-model.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_architecture-note.md
summary: Defines provider-owned public Contracts, cross-owner interaction selection, registration and Host handoff, rejection ownership, and the narrow Core Runtime boundary.
-->
# Public Contract And Interaction Model
Parent: [Architecture Index](index.md)

## 1. Purpose And Status
Define how Core capabilities, optional Modules, UI responsibilities, Laravel integration, and Host extension systems interact through explicit public boundaries.

This document answers:

- who owns each public promise;
- which interaction mechanism applies;
- how declarations reach their accepted destination;
- which owner validates and rejects invalid interaction;
- what Core Runtime owns and must not absorb.

Status:

- Target design: accepted through GitHub issue #23 and pull request #56
- Current implementation: pre-alpha and not target authority
- Goal 3 ownership, topology, placement, dependency, and naming: accepted and fixed
- Physical migration or production implementation authorized: no

In scope:

- public Contract families and ownership;
- synchronous Actions, Queries, and technical capability calls;
- provider-owned boundary data;
- Events, Listeners, and Jobs;
- Host Registry and Contribution handoff;
- Application Registration validation and routing;
- rejection ownership;
- Core Runtime responsibility.

Out of scope:

- persistence design;
- transport serialization;
- compatibility or migration planning;
- concrete container bindings or registrar implementation;
- Event transport, outbox, queue, cache, or verification tooling.
## 2. Core Rules
1. The provider whose promise, policy, data meaning, or extensible feature is exposed owns the public Contract.
2. Consumers depend on provider-owned Contracts, never provider implementation.
3. Immediate work requiring a result or confirmed rejection remains synchronous.
4. Events announce completed facts; Jobs represent owner-controlled deferred execution.
5. Consumers do not dispatch another owner’s concrete Job.
6. Host Registries own Contribution acceptance and resolution.
7. Application Registration validates and routes declarations; it does not own Host policy or behavior.
8. Registration, discovery, availability, visibility, and authorization remain separate.
9. Core does not depend on optional Module implementation.
10. Broad reuse does not create shared ownership, a generic service layer, or a service locator.
## 3. Contract Ownership And Families
An abstraction used only inside one implementation role remains adjacent to that implementation. It does not move into `Contracts/` merely because it has an interface, multiple consumers, or a Laravel binding.

A Contract is public when the provider intentionally exposes a stable promise outside the concrete implementation that fulfills it. It defines applicable inputs, outputs, success, rejection, sensitivity, lifecycle, and permitted consumers.

Default placement:
```text
app/Core/<Capability>/Contracts/
Modules/<Module>/src/Contracts/
app/UI/<Responsibility>/Contracts/
```
A separate `Public/` or `Internal/` subdivision is not required. Internal abstractions remain outside `Contracts/`.

Repository-owned interfaces use the `Interface` suffix. Names describe the promise and must not use generic forms such as `ServiceInterface`, `ActionInterface`, `QueryInterface`, or `ManagerInterface`.

| Contract family                   | Purpose                                                                | Owner                                                |
| --------------------------------- | ---------------------------------------------------------------------- | ---------------------------------------------------- |
| Operation Contract                | Immediate state-changing operation with explicit result or rejection   | Owner of the operation and policy                    |
| Query Contract                    | Immediate read or resolution                                           | Owner of the data meaning and read policy            |
| Technical Capability Contract     | Narrow technical promise not accurately modeled as one Action or Query | Owner of the technical capability                    |
| Event Contract                    | Completed fact published to independent consumers                      | Owner of the occurrence                              |
| Extension Point Contract          | Accepted Contribution shape and rules                                  | Host                                                 |
| Registration Declaration Contract | Structural declaration consumed by Application Registration            | Declaring owner within the registration architecture |
| Boundary Data Contract            | Input, criteria, result, snapshot, or other stable data shape          | Provider of the containing public operation          |

A special family is permitted only when these categories do not fit and the provider, consumers, success, rejection, and ownership remain explicit.
## 4. Interaction Selection
| Need                           | Required boundary                                          | Execution owner                                   | Prohibited substitute                      |
| ------------------------------ | ---------------------------------------------------------- | ------------------------------------------------- | ------------------------------------------ |
| Immediate state change         | Provider Operation Contract                                | Provider Action or precise provider behavior      | Event, Job, concrete Action import         |
| Immediate read                 | Provider Query Contract                                    | Provider Query or precise resolver                | Direct Model, repository, or table access  |
| Narrow technical capability    | Provider Technical Capability Contract                     | Provider implementation                           | Generic service locator or shared utility  |
| Completed fact                 | Provider Event                                             | Consumer-owned Listeners                          | Command disguised as Event                 |
| Deferred work                  | Provider Contract, followed by provider Job                | Provider                                          | Consumer dispatching provider Job          |
| Host extensibility             | Host Extension Point Contract and Contributor Contribution | Host Registry resolves; Contributor owns behavior | Direct Host mutation or Contributor import |
| Build or bootstrap composition | Owner Registration Descriptor                              | Application Registration and native integration   | Runtime service discovery                  |
| UI rendering                   | Normalized provider-owned data through accepted UI APIs    | Product or Frame owner supplies data; UI renders  | UI authorization or policy evaluation      |
## 5. Synchronous Operations And Boundary Data
### 5.1. Default invocation
Direct dependency injection on the provider-owned Contract is the default:
```text
Consumer
    ↓ provider-owned Contract
Provider Action, Query, or technical implementation
    ↓
Explicit provider-owned result or rejection
```
A global command bus, Query bus, mediator, dispatcher, or service locator is not required and is not the default. A later accepted design may introduce one only for a specific proven capability that direct Contract invocation cannot reasonably provide.
### 5.2. Operation Contracts
An Operation Contract:

- expresses one immediate application intent;
- belongs to the owner executing the policy and behavior;
- uses explicit provider-owned input and result data;
- defines expected rejection;
- may be fulfilled by a provider Action;
- never exposes the concrete Action.

The provider remains authoritative for authorization, invariants, transaction or consistency boundaries, persistence mutation, lifecycle effects, Events, and Jobs.
### 5.3. Query Contracts
A Query Contract:

- expresses one immediate read intent;
- belongs to the owner of the data meaning and read policy;
- applies provider-controlled visibility and authorization;
- returns provider-owned Data Objects or approved read results;
- does not expose Models, repositories, query builders, tables, or internal projections.

Incidental logging, metrics, or cache behavior does not make a Query state changing.
### 5.4. Boundary data
Public boundary data remains provider-owned and uses explicit forms such as `<Operation>Data`, `<Subject>Criteria`, `<Subject>Result`, `<Subject>Snapshot`, or a more precise semantic name.

Public boundary Data Objects must be typed, immutable after construction, limited to required fields, sensitivity-aware, and independent of persistence implementation. Arbitrary arrays and payload bags are not public data Contracts.

An Eloquent Model, repository, query builder, database row, or internal projection does not cross an ownership boundary. An approved read model is a provider-owned Query result, not a shared owner.
### 5.5. Binding
The provider declares public Contract bindings through its Owner Registration Descriptor or another accepted owner-controlled mechanism.

Application Registration rejects a missing Contract or implementation, multiple unqualified defaults, an implementation outside the permitted owner, a prohibited dependency, or a stale generated binding. Native Laravel integration may execute the binding without becoming the owner.
## 6. Events, Listeners, And Jobs
An Event represents a completed or accepted fact, belongs to the owner of the occurrence, and is its own public Event Contract when intentionally published. Its data is explicit and provider-owned.

An Event does not require a Listener to complete the publisher’s operation. Publication must not claim completion before the provider accepts the authoritative state change. Exact transactional delivery remains implementation design.

A Listener belongs to the owner performing the reaction. It consumes only the public Event Contract, owns its follow-up behavior, and does not gain access to publisher internals.

When another owner must provide confirmed completion or rejection, the caller uses a synchronous Contract rather than an Event.

A Job belongs to the owner responsible for deferred work. The default cross-owner flow is:
```text
Consumer
    ↓ provider public Contract
Provider accepts or rejects
    ↓
Provider dispatches provider-owned Job
```
Consumers do not dispatch another owner’s concrete Job. A Job may call another owner’s public Contract when normal dependency rules permit.
## 7. Hosts, Registries, Contributions, And Registration
A Host owns the extensible feature, Registry, Extension Point Contracts, acceptance, ordering, conflict policy, availability filtering, and resolved output.

A Contributor owns its declaration, Contract implementation or metadata, referenced behavior, and Contributor-specific authorization and lifecycle.

A Contribution declaration communicates at least:

| Meaning                              | Purpose                                                          |
| ------------------------------------ | ---------------------------------------------------------------- |
| Contributor owner identity           | Identifies the Contribution owner                                |
| Host owner identity                  | Identifies the accepting owner                                   |
| `registry_key`                       | Identifies the Host Registry or Extension Point under ADR-0007   |
| `contribution_key`                   | Provides stable Contribution identity                            |
| Artifact or implementation reference | Identifies the declared Contribution                             |
| Declared dependencies                | Supports structural dependency validation                        |
| Source trace                         | Links compiled output to its declaration                         |
| Host-defined metadata                | Supplies only metadata permitted by the Extension Point Contract |

The canonical Contribution identity remains the pair `registry_key` and `contribution_key`.

These are semantic requirements, not a mandated serialization format.

A Contribution must not access Host internals, mutate Registry state outside the public boundary, transfer behavior ownership, create a Core dependency on an optional Module, or use `Contrib/<Host>/` for unrelated framework registration.

The accepted handoff is:
```text
Owner or Contributor declaration
        ↓
Application Registration structural validation and routing
        ↓
Host Registry semantic validation and acceptance
        ↓
Host-owned resolved output
```
Application Registration owns declaration shape, identities, path and class existence, structural duplicates, owner and dependency validation, cycle detection, deterministic compilation, routing, and source traceability.

The Host Registry owns Contribution Contract compliance, Host compatibility, semantic duplicates and conflicts, ordering, availability, filtering, acceptance, rejection, and resolved output.

Application Registration does not decide Workspace eligibility, authorization, Module availability, Navigation state, Product behavior, or Host fallback.
## 8. Failure And Rejection Ownership
| Failure or rejection                                    | Authoritative owner                                    |
| ------------------------------------------------------- | ------------------------------------------------------ |
| Malformed declaration; missing class, path, or artifact | Application Registration                               |
| Duplicate registration identity or unqualified binding  | Application Registration                               |
| Unknown owner, dependency, or dependency cycle          | Application Registration                               |
| Unknown Host, Registry, or Extension Point              | Application Registration using Host-published identity |
| Invalid or incompatible Contribution                    | Host Registry                                          |
| Host ordering or conflict failure                       | Host Registry                                          |
| Current Module unavailable                              | Module lifecycle owner                                 |
| Current Workspace ineligible                            | Workspace owner                                        |
| Operation or Query authorization denial                 | Provider policy or Access owner                        |
| Navigation item not visible                             | Navigation owner                                       |
| Transport or protocol rejection                         | Delivery Adapter owner                                 |
| Missing or invalid invocation envelope                  | Core Runtime integration                               |
| Native Laravel or build registration failure            | Typed Registrar or native integration                  |

Expected public rejection is part of the provider Contract. Internal exceptions, stack details, persistence errors, and framework failures do not become public automatically.
## 9. Core Runtime
Core Runtime owns only the fixed technical invocation envelope and its lifecycle.

| Envelope field         | Meaning                                                |
| ---------------------- | ------------------------------------------------------ |
| Invocation identifier  | Unique identifier for one execution                    |
| Correlation identifier | Identifier shared across related executions            |
| Causation identifier   | Prior invocation or message, when known                |
| Invocation channel     | Canonical Invocation Channel value defined by ADR-0006 |
| Start time             | Technical execution start timestamp                    |

Runtime owns creation or restoration at accepted invocation boundaries, propagation of correlation and causation, immutable access through one narrow public Contract, required initialization and teardown, and rejection of a missing or malformed envelope.

Consumers read the current Invocation through the Runtime public Contract; they must not rely on HTTP request globals, queue internals, or another transport-specific execution object as the cross-owner Runtime boundary.

Delivery Adapters and native execution integrations create or restore the envelope. Owners consume it only when the technical identifiers are required.

Runtime does not own:

- service lookup or arbitrary context;
- application configuration;
- Tenant, Instance, account, identity, Principal, or Actor resolution;
- Workspace resolution;
- authorization or permission evaluation;
- Module installation, enablement, assignment, or availability;
- Navigation, Product, or Frame state;
- Monitoring, Audit, or security policy;
- feature coordination, persistence, or current-user helpers.

Semantic context remains owned by the applicable capability and crosses boundaries through its own Contract or provider-owned Data Object. Runtime carries correlation; it does not interpret semantic context.

The envelope is fixed and typed. A new field requires proof that it is technical, needed across multiple invocation channels, not owned elsewhere, and safe for the entire invocation lifecycle. Arbitrary associative data, container lookup, static mutation, and owner-specific keys are prohibited.

### 9.1. Invocation Lifecycle

A root Invocation begins when application work enters through an accepted execution boundary without a trusted parent Invocation.

For a root Invocation:

```text
invocation_id  = new unique identifier
correlation_id = invocation_id
causation_id   = null
```

Synchronous work continues within the current Invocation. Ordinary owner-to-owner Contract calls, Queries, Services, and synchronous Event Listeners do not create child Invocations.

Independent asynchronous execution creates a new child Invocation.

For a child Invocation:

```text
invocation_id  = new unique identifier
correlation_id = parent correlation_id
causation_id   = parent invocation_id
```

Each actual queued execution attempt is a distinct Invocation. Retry attempts receive new Invocation identifiers while remaining in the same correlation family.

Queued Jobs use `queued_job`. Queued or asynchronous Event consumers use `event_consumer`.

A manually invoked command uses `console_command`.

Each scheduled task execution is its own `scheduled_task` root Invocation. Unrelated tasks executed by one scheduler process do not share a correlation family.

`internal_system` is reserved for explicit top-level application-owned execution that has no more accurate canonical Invocation Channel. It does not create nested Invocations for ordinary synchronous application calls.

### 9.2. Trust And Isolation

Login 2.0 owns its internal Invocation identity.

Untrusted external request, trace, or correlation identifiers must not directly control the internal `invocation_id` or silently join unrelated internal correlation families. External correlation protocols may be supported by the applicable Delivery Adapter under explicit validation and trust rules.

Runtime state is execution-local and immutable after initialization.

Long-running processes must initialize and tear down Runtime state at each accepted execution boundary so independent requests, Jobs, Event consumers, commands, or scheduled tasks cannot inherit stale Runtime state.

Invocation and correlation identifiers are technical correlation values. They are not authentication evidence, authorization grants, idempotency keys, database transaction identifiers, Job identifiers, or Event identifiers.

## 10. Dependency, Security, And Authorization Rules
Permitted:

- Core consumes another Core capability’s public Contract.
- Module consumes Core public Contracts and approved UI APIs.
- Module consumes another Module’s Contract only with explicit, versioned, acyclic package dependency.
- Delivery Adapter invokes its owner’s Action or Query.
- Listener consumes a public Event.
- Core Host accepts optional Module Contributions without importing Module implementation.
- Application Registration binds provider Contracts through owner declarations.

Prohibited:

- Core imports optional Module implementation.
- Consumer imports another owner’s concrete Action, Query, Job, Listener, Model, repository, Registry, or table.
- Consumer dispatches another owner’s concrete Job.
- Event or Job hides a required immediate result or rejection.
- Application Registration decides Host ordering, authorization, Workspace eligibility, or Navigation visibility.
- Global service locator, command bus, or Query bus becomes the default interaction layer.
- Core Runtime becomes an application context bag.

The provider is authoritative for authorization and policy on every Operation and Query. Consumer or UI prechecks may improve usability but do not authorize the operation.

Registration, discovery, Module availability, Workspace selection, Navigation visibility, and authorization remain separate. Public Contracts minimize exposed data, preserve Tenant and Instance isolation, preserve Principal and Actor distinctions, and expose stable rejection without internal failure details.
## 11. Decisions And Deferred Detail
This document decides:

- direct provider Contract injection is the default synchronous model;
- no global command bus, Query bus, mediator, dispatcher, or service locator is required;
- boundary Data Objects are provider-owned and immutable after construction;
- Events cannot replace required synchronous interaction;
- cross-owner direct Job dispatch is prohibited;
- Application Registration owns structural validation and routing;
- Host Registries own semantic Contribution acceptance and resolution;
- Core Runtime owns only the technical invocation envelope and lifecycle.

Deferred to bounded system planning or implementation::

- exact owner-specific interface names;
- descriptor and manifest serialization;
- container binding implementation;
- Event transactional delivery and versioning;
- Registry cache and invalidation;
- static architecture checks;
- exact verification commands and fixtures.
- exact Core Runtime Contract and Data Object type names;
- exact Invocation identifier representation;
- Laravel Context keys and bindings;
- exact HTTP, queue, Event, console, and scheduler integration classes;
- external correlation and trace propagation protocols.

## 12. Related
- [Architecture Index](index.md)
- [Repository Architecture](repository-architecture.md)
- [Application Registration](application-registration.md)
- [Workspace Navigation And Frame Composition](workspace-navigation-and-frame-composition.md)
- [Repository Naming Standards](../02-standards/coding/repository-naming-standards.md)
- [Definitions Index](../07-planning/Definitions/Index.md)
- Related GitHub issue: [#23](https://github.com/kyleswindell/login-v2/issues/23)

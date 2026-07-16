<!--
DOC-META
title: Phase 5 Role Terminology Matrix
doc_type: matrix
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/role-terminology-matrix.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_matrix.md
summary: Distinguishes accepted PHP, application-operation, delivery, event, background-work, and abstraction roles that are commonly confused during implementation.
-->

# Phase 5 Role Terminology Matrix

Parent: [Phase 5 Naming Conventions Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Use This Matrix For](#3-use-this-matrix-for)
- [4. Do Not Use This Matrix For](#4-do-not-use-this-matrix-for)
- [5. Source Documents](#5-source-documents)
- [6. Matrix](#6-matrix)
  - [6.1. Foundation, Boundary, And Data Roles](#61-foundation-boundary-and-data-roles)
  - [6.2. Application-Operation Roles](#62-application-operation-roles)
  - [6.3. Delivery Roles](#63-delivery-roles)
  - [6.4. Event, Background-Work, And Messaging Roles](#64-event-background-work-and-messaging-roles)
  - [6.5. Application Registration Roles](#65-application-registration-roles)
- [7. Cross-Cutting Abstraction Rule](#7-cross-cutting-abstraction-rule)
- [8. Unresolved Or Externally Governed Terms](#8-unresolved-or-externally-governed-terms)
- [9. Maintenance Notes](#9-maintenance-notes)
- [10. Related](#10-related)

## 1. Purpose

Provide one implementation-facing terminology lookup for selecting an accurate PHP class role or suffix without creating generic application layers or repository-wide inheritance hierarchies.

## 2. Status

- Matrix lifecycle: planned
- Terminology source: Decisions 5.4, 5.5, 5.6, 5.9, and 5.14 accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)

## 3. Use This Matrix For

Use this matrix to:

- distinguish roles with overlapping historical usage;
- select the narrowest accurate Technical Role;
- identify when a generic abstraction may be valid;
- reject broad `Service`, `Manager`, `Handler`, `Base`, or `Helper` naming;
- route implementation questions to the detailed Phase 5 decision.

## 4. Do Not Use This Matrix For

Do not use this matrix to:

- require a class for every behavior;
- require every class to implement a role-specific interface;
- create one shared parent for every Controller, Action, Query, Model, Event, or Job;
- move responsibilities across owners;
- replace framework-native terminology or provider-owned Contracts;
- define permission semantics, authorization policy behavior, or database design.

## 5. Source Documents

- [Class And Interface Naming](5-4-class-and-interface-naming.md)
- [Action, Service, Query, And Coordination Naming](5-5-action-service-query-and-coordination-naming.md)
- [Delivery Artifact Naming](5-6-delivery-artifact-naming.md)
- [Event, Listener, Job, Queue, Notification, And Audit Naming](5-9-event-listener-job-queue-notification-and-audit-naming.md)
- [Application Registration Terminology And Naming Boundaries](5-14-application-registration-terminology-and-naming-boundaries.md)
- [Phase 4 Contract Placement](../phase-4/4-1-contract-placement.md)
- [Phase 4 Cross-Owner Communication](../phase-4/4-11-cross-owner-communication.md)

## 6. Matrix

### 6.1. Foundation, Boundary, And Data Roles

| Role           | Naming pattern                                                                         | Accepted meaning                                                              | Use when                                                                                 | Do not use for                                                              | Generic abstraction guidance                                                          | Source                                                     |
| -------------- | -------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------- | --------------------------------------------------------------------------- | ------------------------------------------------------------------------------------- | ---------------------------------------------------------- |
| Interface      | `<Purpose>Interface`                                                                   | Repository-owned behavioral contract                                          | Imports must express a stable capability or behavior boundary                            | Merely marking every class as interchangeable                               | A generic interface is valid only for one exact reusable contract                     | [5.4](5-4-class-and-interface-naming.md)                   |
| Contract       | Specific provider-owned public boundary, usually an interface plus stable Data Objects | Promise exposed across an owner boundary                                      | Another owner must depend on stable public behavior or data                              | Generic shared ownership, direct concrete imports, or a folder-only label   | Use specific names such as `UserRepositoryInterface`; avoid bare `Contract` classes   | [5.4](5-4-class-and-interface-naming.md)                   |
| Abstract class | `Abstract<SubjectOrRole>`                                                              | Intentional partial implementation with enforced shared behavior or lifecycle | Subclasses genuinely share state, lifecycle, template methods, or invariants             | Creating a common parent merely for naming symmetry                         | Valid narrowly; avoid `Base...` and empty marker parents                              | [5.4](5-4-class-and-interface-naming.md)                   |
| Trait          | Precise behavioral phrase                                                              | Small reusable implementation behavior without owner identity                 | Behavior composes safely across concrete types                                           | Broad helper collection, hidden service location, or unrelated conveniences | Valid when bounded; no required `Trait` suffix                                        | [5.4](5-4-class-and-interface-naming.md)                   |
| Enum           | Singular semantic noun                                                                 | Closed controlled value set                                                   | Values are stable enough for an application enum                                         | User-configurable or rapidly evolving lifecycle data without review         | Generic `Enum` is not a useful concrete type                                          | [5.4](5-4-class-and-interface-naming.md)                   |
| Value Object   | Semantic domain name                                                                   | Immutable semantic value with validation and equality behavior                | A value has meaning beyond a primitive                                                   | Eloquent persistence identity or unstructured transport arrays              | No `ValueObject` suffix; specific semantic name required                              | [5.4](5-4-class-and-interface-naming.md)                   |
| Data Object    | `<Operation>Data`, `<Subject>Criteria`, `<Subject>Result`, or another precise shape    | Stable typed data crossing internal or public boundaries                      | Inputs, criteria, snapshots, or results need explicit shape                              | Domain behavior, persistence identity, HTTP validation, or generic DTO bags | Generic `DataObject` base is normally unnecessary                                     | [5.4](5-4-class-and-interface-naming.md)                   |
| Model          | Singular semantic noun                                                                 | Eloquent representation of owner-controlled persistence                       | A class represents persisted state and relationships                                     | Domain service container, transport object, or application use case         | Avoid broad `BaseModel` unless exact persistence invariants justify it                | [5.10](5-10-database-naming-boundary.md)                   |
| Exception      | `<ExactFailure>Exception`                                                              | Typed failure, conflict, rejection, or invalid state                          | Callers need to distinguish a specific failure contract                                  | Generic control flow or a catch-all application error                       | A shared abstract exception requires a real catch boundary                            | [5.4](5-4-class-and-interface-naming.md)                   |
| Provider       | `<OwnerOrConcern>ServiceProvider`                                                      | Laravel registration and composition adapter                                  | Owner-controlled services, bindings, commands, routes, or integration must be registered | Owning application behavior or acting as a generic Service                  | Framework base Provider is valid; concrete Providers remain specific                  | [5.4](5-4-class-and-interface-naming.md)                   |
| Registry       | `<ArtifactFamily>Registry`                                                             | Host-owned collection and resolution mechanism for one extension family       | A Host owns keyed Contributions, validation, ordering, and resolution                    | Global service location, ownership transfer, or generic discovery           | `RegistryInterface` or abstract registry may define exact registration rules          | [5.4](5-4-class-and-interface-naming.md)                   |
| Definition     | `<Subject>Definition`; Modules use `<Module>ModuleDefinition`                          | Declarative description of one subject                                        | Registration or packaging needs stable declarative metadata                              | A vague configuration bag or a generic bare `Definition`                    | Shared definition contracts may be abstract only when fields and invariants are exact | [5.4](5-4-class-and-interface-naming.md)                   |
| Factory        | `<Subject>Factory`                                                                     | Constructs an object or aggregate                                             | Construction logic is reusable or complex                                                | Performing a state-changing application use case                            | A Factory contract is valid only when multiple construction strategies are real       | [5.5](5-5-action-service-query-and-coordination-naming.md) |
| Builder        | `<Subject>Builder`                                                                     | Incrementally assembles a complex object or representation                    | Stepwise construction materially improves clarity                                        | Creating persisted state as an application intent                           | Avoid generic `Builder` or using it as a catch-all mutator                            | [5.5](5-5-action-service-query-and-coordination-naming.md) |

### 6.2. Application-Operation Roles

| Role        | Naming pattern                                                       | Accepted meaning                                                                                 | Use when                                                                                        | Do not use for                                                                           | Generic abstraction guidance                                                                      | Source                                                     |
| ----------- | -------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------- | ---------------------------------------------------------- |
| Action      | `<Verb><Subject>Action`                                              | One explicit state-changing application intent or outcome                                        | A caller requests a mutation, transition, assignment, creation, archival, or other state change | Broad capability grouping, transport parsing, or passive data access                     | Normally concrete and final; abstract base requires exact lifecycle or invocation contract        | [5.5](5-5-action-service-query-and-coordination-naming.md) |
| Query       | `<ReadVerb><Subject>Query`                                           | One read-only retrieval, search, count, summary, or calculation                                  | A caller needs authoritative information without intentional state change                       | Mutations, background work, generic repository access, or service location               | Normally concrete and final; shared execution abstraction is exceptional                          | [5.5](5-5-action-service-query-and-coordination-naming.md) |
| Resolver    | `<ResolvedSubject>Resolver`                                          | Selects, derives, normalizes, or determines one authoritative result                             | A result must be chosen from inputs, context, priorities, or strategies                         | General querying, workflow orchestration, dependency lookup, or registry ownership       | Interface may be useful for real interchangeable resolution strategies                            | [5.5](5-5-action-service-query-and-coordination-naming.md) |
| Coordinator | `<Workflow>Coordinator`                                              | Reusable orchestration of multiple bounded operations                                            | The orchestration itself is stable, reusable, and independently meaningful                      | One-off Action internals, cross-owner behavior absorption, or generic process management | Normally concrete; a generic coordinator hierarchy is prohibited                                  | [5.5](5-5-action-service-query-and-coordination-naming.md) |
| Handler     | `<MessageOrProtocol>Handler`                                         | Handles one exact message, protocol, callback, or external invocation not better named elsewhere | Protocol semantics are the primary responsibility                                               | Controllers, Listeners, Jobs, Actions, Queries, or vague data processing                 | A handler interface may be valid for one explicit message or protocol contract                    | [5.5](5-5-action-service-query-and-coordination-naming.md) |
| Service     | `<SpecificCapability>Service` only when no narrower role is accurate | Cohesive stable multi-operation capability                                                       | Several related operations form one enduring responsibility such as credential validation       | Default application layer, resource bucket, workflow dumping ground, or generic helper   | Interface may be valid for a real capability contract; generic `ApplicationService` is prohibited | [5.5](5-5-action-service-query-and-coordination-naming.md) |
| Manager     | Prohibited by default                                                | No accepted general application role                                                             | Only an external framework contract or separate accepted definition requires the exact term     | Owning a resource, coordinating workflow, resolving dependencies, or collecting helpers  | Do not create a Manager abstraction to avoid selecting a precise role                             | [5.5](5-5-action-service-query-and-coordination-naming.md) |
| Creator     | Prohibited as a general role suffix                                  | Creation must be classified as a use case or construction mechanism                              | Use `Create<Subject>Action`, `<Subject>Factory`, or `<Subject>Builder` instead                  | Generic construction or creation ownership                                               | No generic Creator hierarchy                                                                      | [5.5](5-5-action-service-query-and-coordination-naming.md) |

### 6.3. Delivery Roles

| Role            | Naming pattern                                       | Accepted meaning                                                                                           | Use when                                                                            | Do not use for                                                                  | Generic abstraction guidance                                                         | Source                                 |
| --------------- | ---------------------------------------------------- | ---------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------- | ------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ | -------------------------------------- |
| Controller      | `<Subject>Controller` or `<Verb><Subject>Controller` | HTTP Delivery Adapter that parses invocation, delegates behavior, and shapes response                      | A route needs an HTTP entry point                                                   | Owning workflows, policies, persistence, or reusable domain logic               | Framework root `Controller` may remain generic; concrete Controllers remain specific | [5.6](5-6-delivery-artifact-naming.md) |
| Form Request    | `<Verb><Subject>Request`                             | Validation and normalization for one HTTP operation                                                        | HTTP input must be authorized, validated, and normalized                            | Application Data Object, reusable domain validator, or generic request bag      | Shared Request base only for exact transport mechanics                               | [5.6](5-6-delivery-artifact-naming.md) |
| Middleware      | `<Purpose>Middleware`                                | Enforces one delivery condition, establishes context, or applies a transport concern                       | Behavior must wrap an invocation before or after delegation                         | Application use cases, domain authorization policy, or generic helpers          | Shared middleware contract may be valid for one exact concern                        | [5.6](5-6-delivery-artifact-naming.md) |
| API Resource    | `<Subject>Resource`                                  | Represents prepared application results for API delivery                                                   | One resource representation is needed                                               | Querying data, owning application behavior, or acting as a domain Model         | Framework API Resource base remains valid                                            | [5.6](5-6-delivery-artifact-naming.md) |
| API Collection  | `<Subject>Collection`                                | Collection representation for API delivery                                                                 | A collection needs dedicated representation behavior                                | Repository collection abstraction or Query result ownership                     | Framework collection base remains valid                                              | [5.6](5-6-delivery-artifact-naming.md) |
| Presenter       | `<SubjectOrSurface>Presenter`                        | Transforms prepared application results into presentation-ready structures                                 | Delivery or Surface data needs presentation mapping                                 | Rendering files, owning policy, querying persistence, or application workflow   | Presenter interface is valid only for a real interchangeable presentation contract   | [5.6](5-6-delivery-artifact-naming.md) |
| Renderer        | `<SubjectOrFormat>Renderer`                          | Produces one concrete representation from prepared data                                                    | CSV, JSON, PDF, document, or another output format must be emitted                  | Querying source data, applying business policy, or generic presentation mapping | Renderer contract may be valid for real format strategies                            | [5.6](5-6-delivery-artifact-naming.md) |
| PageData        | `<PageOrSurface>PageData`                            | Immutable data carrier for one page or Surface                                                             | A page needs a stable typed data shape                                              | Derived presentation behavior or general application data                       | No generic PageData base is normally needed                                          | [5.6](5-6-delivery-artifact-naming.md) |
| ViewModel       | `<SubjectOrSurface>ViewModel`                        | Presentation-specific derived state or behavior beyond PageData                                            | The presentation layer needs computed state, labels, or behavior                    | Basic immutable page data, domain behavior, or generic UI ownership             | Shared ViewModel base is exceptional and must enforce real presentation invariants   | [5.6](5-6-delivery-artifact-naming.md) |
| Console Command | `<Verb><Subject>Command`                             | Console Delivery Adapter that parses input, delegates behavior, formats output, and returns an exit result | Artisan or console invocation is required                                           | Owning the workflow or embedding unrelated operations                           | Framework command base remains valid; concrete Commands remain specific              | [5.6](5-6-delivery-artifact-naming.md) |
| Webhook Handler | `<Provider><Event>WebhookHandler`                    | Incoming provider-event Delivery Adapter                                                                   | One provider event or payload type must be authenticated, translated, and delegated | Generic integration behavior, outgoing calls, or multiple unrelated payloads    | Shared protocol base only when exact provider invariants are enforced                | [5.6](5-6-delivery-artifact-naming.md) |

### 6.4. Event, Background-Work, And Messaging Roles

| Role          | Naming pattern                                          | Accepted meaning                                           | Use when                                                    | Do not use for                                                                        | Generic abstraction guidance                                                                        | Source                                                               |
| ------------- | ------------------------------------------------------- | ---------------------------------------------------------- | ----------------------------------------------------------- | ------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| Domain Event  | `<CompletedFact>Event`                                  | Provider-owned fact that has already occurred              | Independent consumers may react after a completed fact      | Commands, requested actions, hidden synchronous dependencies, or generic messages     | Abstract Event base may be valid only for exact shared event invariants                             | [5.9](5-9-event-listener-job-queue-notification-and-audit-naming.md) |
| Listener      | `<ImperativePurpose>Listener`                           | Consumer-owned reaction to one Event                       | An independent reaction follows a completed fact            | Owning the original behavior, generic event handling, or synchronous required results | Listener interface is useful only for one exact registration or invocation contract                 | [5.9](5-9-event-listener-job-queue-notification-and-audit-naming.md) |
| Job           | `<ImperativeOperation>Job`                              | Deferred, retryable, scheduled, or isolated work           | Work must execute asynchronously or through queue semantics | Hiding a required synchronous dependency or naming by queue provider                  | Abstract Job may enforce tenancy, tracing, retry, or serialization invariants                       | [5.9](5-9-event-listener-job-queue-notification-and-audit-naming.md) |
| Notification  | `<ConditionOrFact>Notification`                         | Message meaning independent of delivery channel            | Users or systems must be informed of a condition or fact    | Naming by email, database, SMS, broadcast, or another channel                         | Sender or channel interfaces may be generic when their delivery contract is exact                   | [5.9](5-9-event-listener-job-queue-notification-and-audit-naming.md) |
| Audit Event   | `<CompletedFact>AuditEvent` when represented by a class | Structured audit or evidence fact                          | Audit contract requires a dedicated typed event             | Generic concrete `AuditEvent` or operational logging                                  | Abstract `AuditEvent` may enforce actor, subject, timestamp, metadata, and serialization invariants | [5.9](5-9-event-listener-job-queue-notification-and-audit-naming.md) |
| Logical Queue | Broad operational lane key, not normally a class        | Stable application lane mapped to provider-specific queues | Operations need isolation or scheduling by broad workload   | One queue per Job, owner, host, or environment without operational reason             | An enum such as `LogicalQueue` may define the controlled set                                        | [5.9](5-9-event-listener-job-queue-notification-and-audit-naming.md) |

### 6.5. Application Registration Roles

| Role                            | Naming pattern                                                                    | Accepted meaning                                                                                         | Use when                                                                                     | Do not use for                                                                                                                                        | Generic abstraction guidance                                                                            | Source                                                                     |
| ------------------------------- | --------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------- |
| Application Registration System | Architecture category; no required concrete class                                 | Deterministic declaration, validation, dependency ordering, and application composition                  | Referring to the complete accepted registration pipeline                                     | Creating an umbrella owner, service locator, folder, or class merely to mirror the architecture term                                                  | Preserve the responsibility; choose the narrowest native or custom artifacts that actually implement it | [5.14](5-14-application-registration-terminology-and-naming-boundaries.md) |
| Owner Registration Descriptor   | Architecture responsibility; dedicated class uses `<Owner>RegistrationDescriptor` | One explicit owner-controlled declaration of registrable artifacts and dependencies                      | An owner must expose deterministic registration intent                                       | Requiring a separate descriptor class when a Module Definition, Provider, Data Object, or other accepted artifact already fulfills the responsibility | `RegistrationDescriptorInterface` is valid only for one stable reusable contract                        | [5.14](5-14-application-registration-terminology-and-naming-boundaries.md) |
| Registration Compiler           | `RegistrationCompiler` when represented by a dedicated class                      | Validates declarations, resolves dependency order, and produces the compiled registration representation | Compilation has independent logic, lifecycle, testing, or execution value                    | Generic registration management, request-time filesystem discovery, or wrapping direct framework calls without value                                  | May remain a responsibility within bounded tooling until a dedicated class is justified                 | [5.14](5-14-application-registration-terminology-and-naming-boundaries.md) |
| Compiled Registration Manifest  | `CompiledRegistrationManifest` when represented by a dedicated type               | Deterministic derived registration representation                                                        | Compiled output needs an explicit in-memory or serialized contract                           | Canonical owner declarations, hand-maintained configuration, or feature ownership                                                                     | A dedicated type or materialized file is conditional; derived output must remain reproducible           | [5.14](5-14-application-registration-terminology-and-naming-boundaries.md) |
| Root Application Registrar      | `RootApplicationRegistrar` when represented by a dedicated class                  | Restricted root application composition into native framework and build integrations                     | Root composition requires independent custom behavior or a dedicated integration contract    | Owning registered behavior or introducing a mandatory wrapper around sufficient native Laravel composition                                            | A native Provider or bootstrap integration may fulfill the role                                         | [5.14](5-14-application-registration-terminology-and-naming-boundaries.md) |
| Typed Registrar                 | `<ArtifactFamily>Registrar`                                                       | Bounded custom integration for one registration family                                                   | A family requires meaningful validation, ordering, normalization, adaptation, or integration | A mandatory class per framework call or a concrete `TypedRegistrar` category class                                                                    | Registrar families remain sparse; avoid `GenericRegistrar` and `DefaultRegistrar`                       | [5.14](5-14-application-registration-terminology-and-naming-boundaries.md) |
| Registration compile command    | `CompileRegistrationManifestCommand`                                              | Console entry point for compiling the accepted registration representation                               | Operators, CI, build, deployment, or cache preparation need explicit compilation             | Owning compiler behavior inside the delivery class                                                                                                    | Remains a normal Console Command and delegates to the compiler responsibility                           | [5.14](5-14-application-registration-terminology-and-naming-boundaries.md) |
| Registration validation command | `ValidateRegistrationDescriptorsCommand`                                          | Optional console entry point for validation without materialized output                                  | A distinct validation workflow is useful                                                     | Requiring a second command when compile already provides sufficient validation                                                                        | Optional; no separate abstraction hierarchy is required                                                 | [5.14](5-14-application-registration-terminology-and-naming-boundaries.md) |

## 7. Cross-Cutting Abstraction Rule

A generic role name may be used for an interface, abstract base class, trait, enum, value object, test base, or bounded framework integration type only when it defines one exact reusable contract, invariant, lifecycle, or mechanism.

Concrete owner-controlled behavior remains specifically named.

Prefer composition or interfaces over inheritance unless a base class genuinely enforces shared state, lifecycle, serialization, invocation, or behavior. A common parent must not exist solely to produce a tidy role hierarchy.

Examples:

| Potentially valid                             | Why                                                                                            |
| --------------------------------------------- | ---------------------------------------------------------------------------------------------- |
| `RegistryInterface`                           | Defines exact registration and duplicate-handling behavior                                     |
| `AbstractAuditEvent` or abstract `AuditEvent` | Enforces shared actor, subject, timestamp, metadata, and serialization rules                   |
| `TenantAwareJob`                              | Enforces tenant-context restoration around queued work                                         |
| `ModuleTestCase`                              | Provides one exact reusable Module test harness                                                |
| `RegistrationDescriptorInterface`             | Defines one exact reusable owner-declaration contract when multiple implementations require it |

| Prohibited or suspect | Why                                                                                                |
| --------------------- | -------------------------------------------------------------------------------------------------- |
| `BaseAction`          | No shared role invariant has been established                                                      |
| `ApplicationModel`    | Encourages unrelated persistence helpers and hidden coupling                                       |
| `GenericService`      | Communicates no bounded capability                                                                 |
| `CommonController`    | Creates a generic delivery dumping ground                                                          |
| `ProcessEvent`        | Does not identify a completed fact or exact mechanism                                              |
| `TypedRegistrar`      | Converts an architecture category into a vague concrete class                                      |
| `RegistrationManager` | Hides declaration, compilation, validation, and composition responsibilities behind a generic role |

## 8. Unresolved Or Externally Governed Terms

| Term                                                                                                                    | Governing owner                                         | Phase 5 treatment                                                                                                             |
| ----------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------- |
| Permission key                                                                                                          | ADR-0007 and Access/security standards                  | Remains a machine identifier, not a generic class abstraction                                                                 |
| Authorization Policy                                                                                                    | Laravel and Access/security standards                   | Phase 5 does not create a new policy suffix or hierarchy beyond existing framework usage                                      |
| Repository                                                                                                              | Provider-owned Contract and persistence implementation  | Use specific interfaces and implementations; no generic repository ownership layer is created here                            |
| Scheduler, pipeline, bus, dispatcher, or processor                                                                      | Applicable future role decision or framework contract   | Do not introduce as generic synonyms for Action, Coordinator, Handler, Event, or Job without an exact accepted responsibility |
| Application Registration descriptor format, generated output, cache, bootstrap integration, and compiler implementation | Phase 6, Phase 7, and later bounded implementation work | Role terminology and conditional names are accepted; concrete architecture and runtime implementation remain deferred         |

## 9. Maintenance Notes

- Add a role only when its meaning, naming pattern, and boundaries are accepted.
- Do not weaken a precise role because a legacy class currently uses a broader suffix.
- Keep role meaning independent from folder count and owner identity.
- Link to the detailed decision rather than expanding this matrix into a second standards document.
- Reconcile any future role correction across this matrix, the naming matrix, detailed decisions, Definitions, and promoted standards.

## 10. Related

- [Phase 5 Naming Conventions Index](index.md)
- [Naming Convention Matrix](naming-convention-matrix.md)
- [Module Identity Matrix](module-identity-matrix.md)
- [Compatibility And Rename Register](compatibility-and-rename-register.md)
- [Durable Promotion Register](durable-promotion-register.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)

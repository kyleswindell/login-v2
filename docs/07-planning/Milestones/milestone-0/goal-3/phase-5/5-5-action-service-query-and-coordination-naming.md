<!--
DOC-META
title: Phase 5.5 Action, Service, Query, And Coordination Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-5-action-service-query-and-coordination-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records distinct naming and responsibility boundaries for Actions, Queries, Resolvers, Coordinators, Handlers, Services, Managers, and Creators.
-->

# Phase 5.5 Action, Service, Query, And Coordination Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Give overlapping application-operation suffixes distinct meanings so classes communicate one bounded responsibility and generic Services or Managers do not become default architecture layers.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: Decisions 5.1 and 5.4 plus accepted Action and Query definitions

## 3. Role Matrix

| Role        | Naming pattern                 | Accepted use                                                             |
| ----------- | ------------------------------ | ------------------------------------------------------------------------ |
| Action      | `<Verb><Subject>Action`        | One explicit state-changing operation or outcome                         |
| Query       | `<ReadVerb><Subject>Query`     | One read-only retrieval, search, count, summary, or calculation          |
| Resolver    | `<ResolvedSubject>Resolver`    | Selects, derives, normalizes, or determines one authoritative result     |
| Coordinator | `<Workflow>Coordinator`        | Reusable orchestration of multiple bounded operations                    |
| Handler     | `<MessageOrProtocol>Handler`   | Handles one explicit message, protocol, callback, or external invocation |
| Service     | `<SpecificCapability>Service`  | Exceptional stable multi-operation capability with no more precise role  |
| Manager     | Prohibited by default          | Too broad and ownership-obscuring                                        |
| Creator     | Prohibited as a general suffix | Use an Action, Factory, or Builder                                       |

## 4. Actions And Queries

Actions are the normal role for state-changing application intents:

```text
SuspendUserAction
AssignRoleAction
ArchiveProjectAction
```

Queries are the normal role for read-oriented operations that do not intentionally change authoritative state:

```text
FindUserByEmailQuery
ListAssignableRolesQuery
CalculateAuditSummaryQuery
```

Appropriate Query verbs include `Find`, `Get`, `List`, `Search`, `Count`, `Calculate`, and `Summarize` when they describe the actual result accurately.

Actions and Queries each represent one explicit application intent and may coordinate owner-local collaborators. Neither term authorizes broad unrelated responsibilities.

## 5. Resolvers, Coordinators, And Handlers

Resolvers derive or select one result:

```text
EffectiveTimezoneResolver
NotificationChannelResolver
ModuleDependencyResolver
```

A Resolver is not a generic Query, service locator, workflow engine, or unrestricted dependency lookup.

Coordinators are justified only when orchestration is itself a stable reusable responsibility:

```text
ModuleActivationCoordinator
AccountRecoveryCoordinator
```

One-off orchestration remains inside the applicable Action.

Handlers must identify exactly what they handle:

```text
QuickBooksWebhookHandler
SamlResponseHandler
```

Use `Handler` only when the class is not more accurately named as a Controller, Listener, Job, Action, or another accepted role.

## 6. Service, Manager, And Creator

`Service` is an exception rather than a default layer. Prefer a precise capability name when possible:

```text
PasswordHasher
RiskScorer
TokenIssuer
PermissionEvaluator
```

A `<SpecificCapability>Service` is permitted only when the class exposes a cohesive stable set of related operations and no narrower accepted role describes it accurately.

Prohibited generic examples:

```text
UserService
ProjectManager
DataHandler
UserCreator
CommonResolver
ProcessAction
GetDataQuery
```

Laravel `ServiceProvider` is a framework-specific Provider role and does not justify generic application Service classes.

Creation use cases use `Create<Subject>Action`. Object construction uses `<Subject>Factory`, `<Subject>Builder`, or another precise construction role.

## 7. Abstraction Boundary

Actions and Queries are normally concrete and final. An interface or abstract base is justified only by an exact reusable invocation contract, lifecycle, or invariant—not by a desire for every role to share a parent type.

Avoid generic abstractions such as:

```text
BaseAction
AbstractQuery
GenericCoordinator
ApplicationService
```

unless a separately accepted contract proves one bounded reusable mechanism.

## 8. Accepted Decision

> Actions use `<Verb><Subject>Action` and represent one explicit state-changing application intent or outcome.
> Queries use `<ReadVerb><Subject>Query` and represent one explicit read-oriented operation that does not intentionally change authoritative state. Appropriate read verbs include `Find`, `Get`, `List`, `Search`, `Count`, `Calculate`, and `Summarize` when they accurately describe the result.
> Resolvers use `<ResolvedSubject>Resolver` when a class selects, derives, normalizes, or determines one authoritative result from available inputs or context. A Resolver must not become generic workflow orchestration or unrestricted dependency lookup.
> Coordinators use `<Workflow>Coordinator` only when coordination across multiple bounded operations is itself a stable, reusable responsibility. One-off orchestration remains inside the applicable Action. Coordinators must not absorb another owner’s behavior or become generic process managers.
> Handlers use `<MessageOrProtocol>Handler` only when a class handles one explicit message, protocol, callback, or external invocation that is not more accurately named as a Controller, Listener, Job, Action, or other accepted role. The handled subject must appear in the class name.
> Service is not a default application layer. A `<SpecificCapability>Service` name is permitted only when the class exposes a cohesive, stable set of related operations and no accepted narrower role describes it accurately. Generic classes such as `UserService`, `DataService`, `CommonService`, and `ApplicationService` are prohibited.
> Manager is prohibited for new canonical application classes unless an external framework contract requires the term or a separately accepted definition establishes one exact bounded meaning.
> Creator is prohibited as a general technical suffix. State-changing creation operations use `Create<Subject>Action`; object construction uses `<Subject>Factory`, `<Subject>Builder`, or another precise construction role.
> Names must communicate both the subject and the technical role. Generic names such as `ProcessAction`, `GetDataQuery`, `CommonResolver`, `WorkflowCoordinator`, and `DataHandler` are prohibited.

## 9. Boundaries And Handoff

- Decision 5.6 owns delivery-specific Handlers, Controllers, Commands, and Webhooks.
- Decision 5.9 owns Listeners and Jobs.
- Cross-owner use must follow Phase 4 public Contract and dependency rules.
- This decision does not require every operation to have a dedicated class when no accepted implementation need exists.

## 10. Related

- [Class And Interface Naming](5-4-class-and-interface-naming.md)
- [Delivery Artifact Naming](5-6-delivery-artifact-naming.md)
- [Event, Listener, Job, Queue, Notification, And Audit Naming](5-9-event-listener-job-queue-notification-and-audit-naming.md)
- [Phase 4 Cross-Owner Communication](../phase-4/4-11-cross-owner-communication.md)
- [Definitions Index](../../../../Definitions/Index.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)

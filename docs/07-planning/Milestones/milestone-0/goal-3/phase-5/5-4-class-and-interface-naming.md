<!--
DOC-META
title: Phase 5.4 Class And Interface Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-4-class-and-interface-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records naming rules for declared PHP types, implementations, abstractions, Data Objects, Providers, Registries, and Definitions.
-->

# Phase 5.4 Class And Interface Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define names for repository-owned PHP types so imports and declarations communicate purpose without depending entirely on folder context.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: Decision 5.1 and existing PHP style standards

## 3. Naming Matrix

| Artifact                | Rule                                                     | Example                          |
| ----------------------- | -------------------------------------------------------- | -------------------------------- |
| Declared type and file  | PascalCase; filename exactly matches type                | `EmailAddress.php`               |
| Interface               | Purpose name ending in `Interface`; no `I` prefix        | `UserRepositoryInterface`        |
| Concrete implementation | Name the meaningful strategy, mechanism, or technology   | `EloquentUserRepository`         |
| Abstract class          | `Abstract` prefix for intentional partial implementation | `AbstractNotificationChannel`    |
| Trait                   | Behavioral phrase; no required `Trait` suffix            | `HasActorContext`                |
| Enum                    | Singular semantic noun; no `Enum` suffix                 | `AccountStatus`                  |
| Value Object            | Semantic domain name; no `ValueObject` suffix            | `TenantId`                       |
| Operation input         | `<Operation>Data`                                        | `CreateUserData`                 |
| Query criteria          | `<Subject>Criteria`                                      | `UserSearchCriteria`             |
| Result object           | `<Subject>Result` or a more precise data-shape name      | `PermissionEvaluationResult`     |
| Exception               | Exact failure or rejection ending in `Exception`         | `ModuleDependencyCycleException` |
| Laravel Provider        | `<OwnerOrConcern>ServiceProvider`                        | `IdentityServiceProvider`        |
| Registry                | `<ArtifactFamily>Registry`                               | `DashboardWidgetRegistry`        |
| Definition              | `<Subject>Definition`                                    | `DashboardWidgetDefinition`      |
| Module definition       | `<Module>ModuleDefinition`                               | `ProjectsModuleDefinition`       |

Each PHP file contains one declared type.

## 4. Interfaces And Implementations

Repository-owned interfaces use the `Interface` suffix:

```text
UserRepositoryInterface
NotificationSenderInterface
ModuleContributionInterface
```

Placement beneath `Contracts/` does not replace the suffix. Imports and type declarations remain understandable outside folder context.

External, PSR, Laravel, and vendor interfaces retain their native names. The `IUserRepository` form is prohibited.

Concrete implementations name their meaningful mechanism or strategy:

```text
EloquentUserRepository
CachedPermissionResolver
DatabaseNotificationStore
```

Avoid:

```text
UserRepositoryImpl
ConcreteUserRepository
UserRepositoryImplementation
UserRepositoryService
```

`Default` is permitted only when it represents an explicitly documented fallback selection rather than an unnamed primary implementation.

## 5. Data Objects And Semantic Types

The canonical project term is **Data Object**. Do not use `DTO` or `Dto` suffixes for new canonical types.

```text
CreateUserData
UserSearchCriteria
PermissionEvaluationResult
UserAccountSnapshot
```

Data Objects remain distinct from Eloquent Models, Actions, Queries, Form Requests, and untyped arrays.

Enums and Value Objects use the semantic domain name rather than artifact suffixes:

```text
AccountStatus
EmailAddress
TenantId
```

## 6. Providers, Registries, And Definitions

Providers use Laravel’s `ServiceProvider` suffix and name the owner or bounded registration concern:

```text
IdentityServiceProvider
ProjectsServiceProvider
ApplicationRegistrationServiceProvider
```

Providers register and compose owner-controlled artifacts; they do not own application behavior.

Registries name the artifact family they register:

```text
DashboardWidgetRegistry
SettingsPageRegistry
NavigationContributionRegistry
```

Definitions name the subject defined. A bare `Definition` class is prohibited when its subject would be ambiguous outside the namespace.

## 7. Foundational Abstractions

A generic role name may be used for an interface, abstract base class, trait, enum, value object, or bounded framework type only when it defines one exact reusable contract, invariant, lifecycle, or mechanism.

Concrete application classes remain specifically named.

Potentially valid:

```php
interface RegistryInterface
{
    public function register(string $key, object $entry): void;
}
```

```php
abstract class AuditEvent
{
    // Enforces shared audit-event state and serialization rules.
}
```

Potentially harmful:

```php
abstract class BaseAction
{
}
```

```php
class GenericService
{
}
```

An abstraction must not be introduced solely to create a common parent type or naming hierarchy. Prefer composition or interfaces unless inheritance genuinely enforces shared state, lifecycle, or behavior.

## 8. Accepted Decision

> Repository-owned PHP classes, interfaces, traits, enums, and other declared types use PascalCase. Each file contains one declared type and its filename exactly matches that type’s case-sensitive name.
> Repository-owned PHP interfaces end in `Interface`. The `I` prefix is prohibited. Contract placement and interface naming remain separate: an interface beneath `Contracts/` retains the `Interface` suffix so imports and type declarations communicate its role without relying solely on folder context. External and framework interfaces retain their native names.
> Concrete implementations name their meaningful mechanism, strategy, provider, or responsibility. Generic suffixes and prefixes such as `Impl`, `Implementation`, `Concrete`, `Base`, and undocumented `Default` are prohibited.
> Intentional abstract partial implementations use the `Abstract` prefix. Traits use behavioral names that read naturally when imported; a `Trait` suffix is not required.
> Enums use a singular semantic noun without an `Enum` suffix. Value Objects use their semantic domain name without `ValueObject`. Repository terminology uses Data Object rather than DTO. Operation inputs normally use `<Operation>Data`; query inputs may use `<Subject>Criteria`; returned structures may use `<Subject>Result` or another precise accepted data-shape suffix.
> Exceptions name the exact failure, conflict, rejection, or invalid state and end in `Exception`.
> Laravel Providers name their owner or bounded registration concern and end in `ServiceProvider`. Registries name the artifact family they register and end in `Registry`. Definitions name the subject they define and end in `Definition`; formal Module definitions use `<Module>ModuleDefinition`.
> Names such as `Manager`, `Helper`, `Utility`, `Common`, `Generic`, `Base`, `Handler`, or `Service` must not substitute for an exact responsibility. Their use requires the applicable role decision to define one precise meaning.
> Generic role names may be used for interfaces, abstract base classes, traits, enums, value objects, or bounded framework types only when they define an exact reusable contract, invariant, lifecycle, or mechanism. Concrete application classes must use specific responsibility names. An abstraction must not be introduced solely to create a common parent type or naming hierarchy.

## 9. Boundaries And Handoff

- Decision 5.5 refines Action, Query, Resolver, Coordinator, Handler, Service, Manager, and Creator roles.
- Decision 5.6 refines delivery classes.
- Decision 5.9 refines Event, Listener, Job, Notification, Audit, and queue-related types.
- This decision does not require a new project-wide abstraction hierarchy.
- Phase 5 does not authorize class or namespace migration.

## 10. Related

- [Action, Service, Query, And Coordination Naming](5-5-action-service-query-and-coordination-naming.md)
- [Delivery Artifact Naming](5-6-delivery-artifact-naming.md)
- [Event, Listener, Job, Queue, Notification, And Audit Naming](5-9-event-listener-job-queue-notification-and-audit-naming.md)
- [PHP And Laravel Style Standards](../../../../../02-standards/coding/PHP%20And%20Laravel%20Style%20Standards.md)
- [Phase 4 Contract Placement](../phase-4/4-1-contract-placement.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)

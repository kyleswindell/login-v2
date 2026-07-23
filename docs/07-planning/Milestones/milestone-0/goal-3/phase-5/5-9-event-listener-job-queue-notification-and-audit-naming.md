<!--
DOC-META
title: Phase 5.9 Event, Listener, Job, Queue, Notification, And Audit Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-9-event-listener-job-queue-notification-and-audit-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records class and machine-identifier naming for asynchronous, event-driven, notification, queue, and audit artifacts plus bounded abstraction rules.
-->

# Phase 5.9 Event, Listener, Job, Queue, Notification, And Audit Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define predictable relationships between PHP class names and stable machine identifiers while preserving them as separate naming families.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: Decisions 5.4 and 5.5 plus ADR-0007

## 3. Naming Matrix

| Artifact      | PHP class pattern                                    | Machine-key pattern                  | Example                                                                           |
| ------------- | ---------------------------------------------------- | ------------------------------------ | --------------------------------------------------------------------------------- |
| Domain Event  | `<CompletedFact>Event`                               | `<capability>.<completed_fact>`      | `UserAccountSuspendedEvent` / `identity.user_account_suspended`                   |
| Listener      | `<ImperativePurpose>Listener`                        | `<consumer_owner>.<handler_purpose>` | `SendUserSuspensionNoticeListener` / `notifications.send_user_suspension_notice`  |
| Job           | `<ImperativeOperation>Job`                           | `<capability>.<operation>`           | `GenerateReportJob` / `reports.generate`                                          |
| Notification  | `<ConditionOrFact>Notification`                      | Domain-first notification key        | `CredentialExpiringNotification` / `security.service_account.credential_expiring` |
| Audit event   | `<CompletedFact>AuditEvent` when a class is required | Domain-first completed-event key     | `RoleUpdatedAuditEvent` / `access.role_updated`                                   |
| Logical queue | No required PHP class                                | Broad operational lane               | `notifications`, `exports`, `integrations`                                        |

## 4. Events, Listeners, And Jobs

Events describe completed facts:

```text
UserAccountSuspendedEvent
ProjectCreatedEvent
OrderSubmittedEvent
```

Avoid imperative event names:

```text
SuspendUserEvent
CreateProjectEvent
HandleOrderEvent
```

Listeners name the reaction performed:

```text
SendUserSuspensionNoticeListener
RecordProjectArchivalListener
IndexCustomerCreatedListener
```

A stable listener key is required only when registration, configuration, observability, ordering, retry, compatibility, or lifecycle management requires one.

Jobs name the deferred work performed:

```text
GenerateReportJob
DeliverNotificationJob
ImportQuickBooksCustomersJob
```

A Job name must not encode the Actor, Invocation Channel, queue provider, host, or retry strategy.

## 5. Notifications, Audit Events, And Queues

Notification classes name the message meaning rather than the delivery channel:

```text
UserAccountSuspendedNotification
CredentialExpiringNotification
ProjectAssignedNotification
```

Avoid:

```text
EmailUserNotification
DatabaseNotification
SendNotificationJobNotification
```

Audit keys use completed-event wording. An audit key may exist without a dedicated PHP class when the accepted audit contract does not require one.

Logical queue keys identify broad operational lanes:

```text
default
notifications
exports
integrations
```

Do not create one logical queue per Job or owner without a documented operational requirement. Provider-specific and environment-specific queue names map separately to logical queue keys.

## 6. Foundational Abstractions

Generic names are prohibited for concrete owner-controlled behavior. They may be valid for exact foundational contracts or mechanisms.

Potentially valid:

```php
abstract class AuditEvent
{
    // Shared actor, timestamp, subject, metadata, and serialization invariants.
}

final class UserAccountSuspendedAuditEvent extends AuditEvent
{
}
```

```php
interface NotificationSenderInterface
{
    public function send(NotificationMessage $message): void;
}
```

```php
enum LogicalQueue: string
{
    case Default = 'default';
    case Notifications = 'notifications';
}
```

Treatment examples:

| Name                    | Treatment                                                                       |
| ----------------------- | ------------------------------------------------------------------------------- |
| `AuditEvent`            | Valid as an exact abstract base or contract; not as ambiguous concrete behavior |
| `EventHandlerInterface` | Potentially valid for one exact handler contract                                |
| `AbstractBackgroundJob` | Potentially valid only when meaningful runtime invariants are enforced          |
| `ProcessEvent`          | Too vague even as a base                                                        |
| `GenericListener`       | Prohibited                                                                      |
| `SendNotification`      | Prefer `NotificationSenderInterface` or a specific Action or Job                |
| `DefaultQueue`          | Usually an enum case or key rather than a class                                 |

Prefer composition or interfaces over inheritance unless a base class genuinely enforces shared state, lifecycle, or behavior. A base class must not exist solely to provide a common name.

## 7. Accepted Decision

> Domain Event classes use `<CompletedFact>Event`. Their machine identifiers use `<capability>.<completed_fact>` with ADR-0007 lowercase snake-case segments. Event names describe facts that have already occurred and must not use imperative command wording.
> Listener classes use `<ImperativePurpose>Listener`. Stable listener identifiers use `<consumer_owner>.<handler_purpose>`. A stable listener key is required only when registration, configuration, observability, ordering, retry, compatibility, or lifecycle management requires one.
> Job classes use `<ImperativeOperation>Job`. Job identifiers use `<capability>.<operation>`. Job names describe the deferred work performed and must not identify the Actor, Invocation Channel, queue provider, or retry strategy.
> Notification classes use `<ConditionOrFact>Notification`. Notification type keys use domain-first dotted identifiers. The class name describes the message meaning rather than its email, database, broadcast, SMS, or other delivery channel.
> Audit event identifiers use domain-first completed-event wording. When audit event types are represented by dedicated PHP classes, those classes use `<CompletedFact>AuditEvent`. An audit key may exist without a dedicated PHP class when the accepted audit contract does not require one.
> Logical queue keys identify broad operational lanes such as `default`, `notifications`, `exports`, and `integrations`. Queue keys are not derived from Job classes, owners, providers, hosts, or environment-specific queue names.
> PHP classes, machine identifiers, queue keys, provider queue names, and display labels remain separate naming families. Relationships among them must be explicit. Renaming a PHP class does not automatically rename its stable machine identifier.
> Generic names such as `ProcessEvent`, `EventHandler`, `GenericListener`, `BackgroundJob`, `SendNotification`, `AuditEvent`, and `DefaultQueue` are prohibited for concrete owner-controlled application behavior. A generic role name may be used for an interface, abstract base class, trait, enum, value object, or framework integration type only when it defines one exact, bounded, reusable contract or mechanism. Concrete subclasses and implementations must use specific responsibility names.
> Composition or interfaces are preferred over inheritance unless the base class genuinely enforces shared state, lifecycle, or behavior. A base class must not exist solely to provide a common name.

## 8. Boundaries And Handoff

- This decision does not define payload schemas, retry policy, queue topology, delivery channels, audit storage, or notification preferences.
- Machine-key grammar remains owned by ADR-0007.
- Runtime queue mapping, monitoring, and operational configuration remain later implementation authority.
- Decision 5.13 governs legacy keys and class-name compatibility.

## 9. Related

- [Class And Interface Naming](5-4-class-and-interface-naming.md)
- [Action, Service, Query, And Coordination Naming](5-5-action-service-query-and-coordination-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [ADR-0007](../../../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Phase 4 Cross-Owner Communication](../phase-4/4-11-cross-owner-communication.md)
- [Events, Jobs, And Queue Standards](../../../../../02-standards/coding/Events%20Jobs%20And%20Queue%20Standards.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)

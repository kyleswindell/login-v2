<!--
DOC-META
title: Core Runtime Software Design
doc_type: design
status: draft
owner: architecture
canonical: false
canonical_path: docs/08-design/foundation/core-runtime/software-design.md
parent: docs/08-design/index.md
template: docs/09-reference/templates/docs/_design.md
summary: Defines the implementation-ready technical design for Core Runtime and the Invocation lifecycle across supported Laravel execution boundaries.
-->

# Core Runtime Software Design

Parent: [Software Design Index](../../index.md)

## 1. System Definition

### Purpose

Core Runtime provides one transport-independent **Invocation** representing a technical application execution and its relationship to related executions.

Target owner:

```text
app/Core/Runtime/
App\Core\Runtime\
```

Runtime owns only:

* Invocation creation and derivation;
* correlation and causation;
* Invocation Channel;
* immutable current-Invocation access;
* initialization and teardown at supported execution boundaries.

### Invocation

Every Invocation contains exactly:

| Field                | Type                   |
| -------------------- | ---------------------- |
| `invocation_id`      | UUID string            |
| `correlation_id`     | UUID string            |
| `causation_id`       | nullable UUID string   |
| `invocation_channel` | `InvocationChannel`    |
| `started_at`         | immutable UTC datetime |

Canonical channels:

```text
interactive_web
api_request
webhook_request
console_command
queued_job
event_consumer
scheduled_task
internal_system
```

Runtime owns no database, UI, Principal, Actor, authorization, Workspace, Settings, feature state, or generic application context.

---

## 2. Governing Requirements

Primary authority:

* `docs/07-planning/01-architecture-boundaries/core-runtime-development-planning.md`
* `docs/03-architecture/public-contract-and-interaction-model.md`
* `docs/03-architecture/repository-architecture.md`
* `docs/01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md`
* `docs/02-standards/coding/repository-naming-standards.md`
* `docs/02-standards/coding/File Archetypes.md`

Laravel `Context` is the underlying execution-local storage and queue-propagation mechanism. It remains an internal implementation dependency and is never exposed as the Runtime public API.

Current `app/Core/Runtime/Context.php` and `Resolver.php` are transitional implementation and are replaced by this design.

---

## 3. Component Design

| Component                           | Responsibility                                                          | Target Path                                                           |
| ----------------------------------- | ----------------------------------------------------------------------- | --------------------------------------------------------------------- |
| `Invocation`                        | Immutable five-field public Data Object                                 | `app/Core/Runtime/Data/Invocation.php`                                |
| `InvocationChannel`                 | Canonical eight-value channel enum                                      | `app/Core/Runtime/Enums/InvocationChannel.php`                        |
| `InvocationContextKey`              | Internal Laravel Context keys for the five fields                       | `app/Core/Runtime/Enums/InvocationContextKey.php`                     |
| `InvocationContextInterface`        | Public read Contract exposing `current()`                               | `app/Core/Runtime/Contracts/InvocationContextInterface.php`           |
| `CurrentInvocationResolver`         | Reads and validates the current Invocation from Laravel Context         | `app/Core/Runtime/Resolvers/CurrentInvocationResolver.php`            |
| `InvocationLifecycleCoordinator`    | Creates root/child Invocations and clears Runtime state                 | `app/Core/Runtime/Coordinators/InvocationLifecycleCoordinator.php`    |
| `InitializeInvocationMiddleware`    | Initializes and tears down HTTP root Invocations                        | `app/Core/Runtime/Http/Middleware/InitializeInvocationMiddleware.php` |
| `QueueInvocationSubscriber`         | Initializes queue/Event-consumer children and guarantees worker cleanup | `app/Core/Runtime/Listeners/QueueInvocationSubscriber.php`            |
| `ConsoleInvocationSubscriber`       | Owns manual command root lifecycle                                      | `app/Core/Runtime/Listeners/ConsoleInvocationSubscriber.php`          |
| `ScheduledInvocationSubscriber`     | Owns per-scheduled-task root lifecycle                                  | `app/Core/Runtime/Listeners/ScheduledInvocationSubscriber.php`        |
| `InvalidInvocationContextException` | Missing or malformed Runtime-state integration failure                  | `app/Core/Runtime/Exceptions/InvalidInvocationContextException.php`   |
| `RuntimeServiceProvider`            | Contract binding and framework lifecycle registration                   | `app/Core/Runtime/Providers/RuntimeServiceProvider.php`               |

No generic Runtime Service, Registry, persistence layer, or context bag is required.

---

## 4. Contracts And Invocation Lifecycle

### Public Contract

Runtime exposes one public Contract:

```php
interface InvocationContextInterface
{
    public function current(): Invocation;
}
```

Consumers receive the immutable `Invocation`.

They cannot mutate Runtime or access arbitrary Laravel Context values.

### Root Invocation

A root Invocation generates:

```text
invocation_id  = new UUID
correlation_id = invocation_id
causation_id   = null
started_at     = current UTC time
channel        = boundary channel
```

UUIDs use Laravel's UUID generator and are exposed as strings.

### Synchronous Continuation

Normal synchronous work retains the same Invocation.

Do not create children for:

* Controller → Action;
* public Contract calls;
* Queries;
* synchronous Listeners;
* nested application services;
* synchronous framework calls.

### Asynchronous Child

Queue-backed execution derives:

```text
invocation_id  = new UUID
correlation_id = parent.correlation_id
causation_id   = parent.invocation_id
started_at     = current UTC time
```

Each actual queue attempt receives a new `invocation_id`.

The original dispatching Invocation remains the causation source for retries.

---

## 5. Laravel Context Integration

Runtime stores only the five Invocation fields in Laravel Context:

```text
runtime.invocation_id
runtime.correlation_id
runtime.causation_id
runtime.invocation_channel
runtime.started_at
```

These values may participate in Laravel logging and queue propagation.

`CurrentInvocationResolver` must reject:

* missing required keys;
* invalid UUID values;
* unknown Invocation Channels;
* malformed timestamps;
* inconsistent child state.

It must never fabricate partial Runtime state.

`InvocationLifecycleCoordinator` is the only Runtime implementation allowed to create, replace, or clear these keys.

Cleanup removes only Runtime-owned keys. It must not flush unrelated Laravel Context data.

---

## 6. Execution Boundary Integration

### HTTP

`InitializeInvocationMiddleware` accepts the explicitly configured HTTP channel:

```text
interactive_web
api_request
webhook_request
```

It:

1. creates a root Invocation before owner behavior;
2. executes the request;
3. clears Runtime state in `finally`.

External request headers never control internal `invocation_id` or `correlation_id`.

Runtime does not expose an Invocation response header by default.

### Queues

Laravel Context propagates the dispatching Invocation with queued work.

On `JobProcessing`, `QueueInvocationSubscriber`:

1. validates the inherited parent Invocation;
2. determines the child channel;
3. replaces the parent Runtime state with a new child Invocation.

Channel selection:

```text
Illuminate\Events\CallQueuedListener
    → event_consumer

other queued execution
    → queued_job
```

Missing or malformed inherited Runtime state is an integration failure and must fail before owner behavior executes.

Runtime state is cleared after successful, failed, exceptional, or timed-out execution and at worker-loop boundaries as a leakage safeguard.

### Console

A manually invoked application command creates a `console_command` root Invocation when no Invocation already exists.

Nested synchronous Artisan calls retain the current Invocation.

`ConsoleInvocationSubscriber` tracks nested command depth so only the outer Runtime-owned command lifecycle creates and clears the root Invocation.

Framework worker/scheduler host commands are orchestration processes and do not become parents of every Job or scheduled task.

### Scheduler

Each application scheduled task receives its own:

```text
scheduled_task
```

root Invocation.

A synchronous Artisan command executed by that scheduled task retains the scheduled Invocation.

A scheduled queued Job is dispatched from the scheduled root and later executes as a correlated `queued_job` child.

Background scheduled processes are not supported until explicit Invocation propagation across the spawned-process boundary is designed.

---

## 7. Security And Reliability

Runtime guarantees:

* exactly five public Invocation fields;
* immutable public Invocation state;
* internally generated Invocation identity;
* deterministic root/child correlation;
* no state leakage between independent executions;
* strict inherited-context validation;
* teardown in long-running processes.

Runtime Context must never contain:

```text
credentials
secrets
PII
User Account data
permissions
Workspace state
request payloads
arbitrary owner metadata
service/container references
```

Invocation identifiers are not:

* authentication evidence;
* authorization grants;
* idempotency keys;
* transaction IDs;
* Job IDs;
* Event IDs.

Runtime has no database transaction behavior and no persistence.

---

## 8. Operational Integration

### Audit

Audit may consume `InvocationContextInterface` to attach Invocation identifiers to accountable evidence.

Runtime does not decide what is Audit-worthy.

### Monitoring

Monitoring may consume the same Contract for correlation of failures and operational evidence.

Runtime does not own severity, alerting, health state, or anomaly policy.

### Security

Security may include Invocation identifiers in evidence.

Invocation identity never establishes Actor identity or authorization.

### External Propagation

No outbound trace-header or vendor-specific propagation protocol is defined in the initial Runtime implementation.

Add one only when a concrete integration requires it.

---

## 9. Implementation Manifest

| Change | Path                                                                  | Responsibility                                                                 |
| ------ | --------------------------------------------------------------------- | ------------------------------------------------------------------------------ |
| DELETE | `app/Core/Runtime/Context.php`                                        | Remove obsolete app-identity context                                           |
| DELETE | `app/Core/Runtime/Resolver.php`                                       | Remove obsolete URL/context resolver                                           |
| CREATE | `app/Core/Runtime/Data/Invocation.php`                                | Immutable Invocation                                                           |
| CREATE | `app/Core/Runtime/Enums/InvocationChannel.php`                        | Canonical channels                                                             |
| CREATE | `app/Core/Runtime/Enums/InvocationContextKey.php`                     | Internal Context keys                                                          |
| CREATE | `app/Core/Runtime/Contracts/InvocationContextInterface.php`           | Public Runtime Contract                                                        |
| CREATE | `app/Core/Runtime/Resolvers/CurrentInvocationResolver.php`            | Current Invocation read                                                        |
| CREATE | `app/Core/Runtime/Coordinators/InvocationLifecycleCoordinator.php`    | Runtime lifecycle                                                              |
| CREATE | `app/Core/Runtime/Exceptions/InvalidInvocationContextException.php`   | Runtime integration failure                                                    |
| CREATE | `app/Core/Runtime/Http/Middleware/InitializeInvocationMiddleware.php` | HTTP boundary                                                                  |
| CREATE | `app/Core/Runtime/Listeners/QueueInvocationSubscriber.php`            | Queue boundary                                                                 |
| CREATE | `app/Core/Runtime/Listeners/ConsoleInvocationSubscriber.php`          | Console boundary                                                               |
| CREATE | `app/Core/Runtime/Listeners/ScheduledInvocationSubscriber.php`        | Scheduler boundary                                                             |
| CREATE | `app/Core/Runtime/Providers/RuntimeServiceProvider.php`               | Binding and registration                                                       |
| MODIFY | `bootstrap/providers.php`                                             | Register Runtime Provider until application registration owns root composition |
| CREATE | `app/Core/Runtime/__tests__/InvocationTest.php`                       | Data/enum Contract                                                             |
| CREATE | `app/Core/Runtime/__tests__/InvocationContextTest.php`                | Context validation                                                             |
| CREATE | `app/Core/Runtime/__tests__/HttpInvocationTest.php`                   | HTTP lifecycle                                                                 |
| CREATE | `app/Core/Runtime/__tests__/QueueInvocationTest.php`                  | propagation, children, retries, isolation                                      |
| CREATE | `app/Core/Runtime/__tests__/ConsoleInvocationTest.php`                | command lifecycle                                                              |
| CREATE | `app/Core/Runtime/__tests__/ScheduledInvocationTest.php`              | scheduler lifecycle                                                            |

No migration, Model, Blade, CSS, JavaScript, route behavior, or configuration file is required.

---

## 10. Verification And Completion

Required implementation proof must establish:

* root Invocation creation;
* exactly five public fields;
* immutable typed access;
* all eight canonical channel values;
* synchronous continuation;
* queue correlation and causation;
* new Invocation ID for each queue attempt;
* `queued_job` versus `event_consumer`;
* command isolation;
* scheduled-task isolation;
* nested synchronous command preservation;
* no Context leakage between requests, Jobs, commands, or scheduled tasks;
* malformed inherited Runtime state fails closed;
* consumers cannot access a generic Runtime key/value API;
* Runtime owns no database or UI;
* external headers cannot control internal Invocation identity.

### Remaining Blockers

None for the initial Core Runtime implementation.

Audit and Monitoring integration are later consumer work and do not block the Runtime public Contract.

External trace propagation and background-scheduled-process propagation remain explicit non-goals until a concrete requirement exists.

### Implementation Ready

* [x] Runtime ownership and scope are complete.
* [x] Invocation schema is complete.
* [x] Invocation Channel vocabulary is complete.
* [x] Public Contract is complete.
* [x] Laravel Context realization is defined.
* [x] HTTP lifecycle is defined.
* [x] Queue/Event-consumer lifecycle is defined.
* [x] Console lifecycle is defined.
* [x] Scheduler lifecycle is defined.
* [x] Failure and isolation behavior are defined.
* [x] Implementation manifest is complete.
* [x] Verification surfaces are defined.
* [x] No material implementation-design blocker remains.

**Design state: ready for repository-owner review and acceptance.**

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
* `docs/08-design/foundation/application-registration/software-design.md`

Laravel `Context` is the underlying execution-local storage and queue-propagation mechanism. It remains an internal implementation dependency and is never exposed as the Runtime public API.

Current implementation may be reviewed for useful behavioral evidence, but it imposes no compatibility, preservation, migration, or target-placement requirement on this design.

Obsolete proof-of-concept artifacts may be explicitly deleted during implementation where the Implementation Manifest identifies them.

---

## 3. Component Design

| Component                           | Responsibility                                          | Target Path                                                           |
| ----------------------------------- | ------------------------------------------------------- | --------------------------------------------------------------------- |
| `Invocation`                        | Immutable five-field public Data Object                 | `app/Core/Runtime/Data/Invocation.php`                                |
| `InvocationChannel`                 | Canonical eight-value channel enum                      | `app/Core/Runtime/Enums/InvocationChannel.php`                        |
| `InvocationContextKey`              | Internal Laravel Context key definitions                | `app/Core/Runtime/Enums/InvocationContextKey.php`                     |
| `InvocationContextInterface`        | Public read Contract exposing `current()`               | `app/Core/Runtime/Contracts/InvocationContextInterface.php`           |
| `CurrentInvocationResolver`         | Read and validate current Invocation state              | `app/Core/Runtime/Resolvers/CurrentInvocationResolver.php`            |
| `InvocationLifecycleCoordinator`    | Create root/child Invocations and clear Runtime state   | `app/Core/Runtime/Coordinators/InvocationLifecycleCoordinator.php`    |
| `InitializeInvocationMiddleware`    | HTTP root initialization and terminable post-observation cleanup | `app/Core/Runtime/Http/Middleware/InitializeInvocationMiddleware.php` |
| `QueueInvocationSubscriber`         | Queue/Event-consumer child initialization and post-attempt cleanup after framework observers | `app/Core/Runtime/Listeners/QueueInvocationSubscriber.php` |
| `ConsoleInvocationSubscriber`       | Manual command root lifecycle                           | `app/Core/Runtime/Listeners/ConsoleInvocationSubscriber.php`          |
| `ScheduledInvocationSubscriber`     | Scheduled-task root initialization and failure-safe cleanup after framework observers | `app/Core/Runtime/Listeners/ScheduledInvocationSubscriber.php` |
| `InvalidInvocationContextException` | Missing or malformed Runtime-state integration failure  | `app/Core/Runtime/Exceptions/InvalidInvocationContextException.php`   |
| `RuntimeServiceProvider`            | Runtime registration declaration, bindings, and Laravel lifecycle integration | `app/Core/Runtime/Providers/RuntimeServiceProvider.php` |

No generic Runtime Service, Registry, persistence layer, or context bag is required.

---

## 4. Contracts And Invocation Lifecycle

### Public Contract

Runtime exposes one provider-owned public Contract:

```php
interface InvocationContextInterface
{
    public function current(): Invocation;
}
```

Consumers receive the immutable `Invocation`.

They cannot:

* mutate Runtime state;
* set arbitrary Context keys;
* access generic Laravel Context through Runtime;
* create Invocations directly.

### Invocation Data

`Invocation` is `final readonly` and contains:

```text
string invocationId
string correlationId
?string causationId
InvocationChannel invocationChannel
DateTimeImmutable startedAt
```

Runtime-generated UUIDs use Laravel's UUID generator and are exposed through the public Contract as canonical string values.

`startedAt` is UTC.

### Root Invocation

A root Invocation is created when work enters through a supported boundary without a trusted parent Invocation.

```text
invocation_id  = new UUID
correlation_id = invocation_id
causation_id   = null
started_at     = current UTC time
channel        = boundary channel
```

Applicable roots:

```text
interactive_web
api_request
webhook_request
console_command
scheduled_task
internal_system
```

### Synchronous Continuation

Normal synchronous application behavior retains the current Invocation.

Do not create child Invocations for:

* Controller → Action calls;
* public Contract calls;
* Queries;
* synchronous Listeners;
* nested application services;
* synchronous internal framework calls;
* synchronous Artisan execution from an already initialized Invocation.

### Asynchronous Child Invocation

Independent asynchronous execution receives a new Invocation.

```text
child invocation_id  = new UUID
child correlation_id = parent correlation_id
child causation_id   = parent invocation_id
child started_at     = current UTC time
```

Channels:

```text
queued Job
    → queued_job

queued/asynchronous Event consumer
    → event_consumer
```

### Retry Attempts

Each actual queue execution attempt is a separate Invocation.

Every retry:

* receives a new `invocation_id`;
* retains the original correlation family;
* retains the original dispatching Invocation as causation.

Job UUID, queue name, connection, attempt count, and retry timing are not Runtime fields.

---

## 5. Laravel Context Integration

Runtime stores only its five canonical fields in Laravel Context:

```text
runtime.invocation_id
runtime.correlation_id
runtime.causation_id
runtime.invocation_channel
runtime.started_at
```

`InvocationContextKey` owns these internal identifiers.

The public `Invocation` object is reconstructed from those values by `CurrentInvocationResolver`.

### Validation

`CurrentInvocationResolver` rejects:

* missing required keys;
* malformed UUID values;
* unknown Invocation Channels;
* malformed timestamps;
* incomplete Runtime state;
* invalid root/child state relationships.

It must never:

* fabricate partial Runtime state;
* infer values from HTTP globals;
* fall back to request attributes;
* silently repair malformed state.

Calling `current()` without valid initialization is an internal integration defect.

### Mutation Ownership

`InvocationLifecycleCoordinator` is the only Runtime component permitted to initialize, replace, or clear Runtime-owned Context state.

It provides internal lifecycle operations for:

```text
create root Invocation
create asynchronous child Invocation
read inherited parent state
clear Runtime-owned Context
execute bounded root lifecycle
```

Cleanup removes only Runtime-owned Context values and must not flush unrelated Laravel Context state.

---

## 6. Execution Boundary Integration

### Failure Observation And Cleanup Ordering

Runtime owns the lifetime of the current Invocation but does not own Audit, Monitoring, exception reporting, failed-job handling, or scheduled-task failure handling.

For every supported execution boundary:

```text
Invocation initialized
    ↓
owner execution
    ↓
success or failure
    ↓
applicable synchronous framework observers execute
    while the current Invocation remains valid
    ↓
Runtime cleanup
    ↓
next independent execution may begin
```

`InvocationContextInterface::current()` must remain valid for synchronous failure observers associated with the current execution.

Runtime cleanup must occur:

* after those observers;
* before the next independent Invocation;
* on every success, failure, retry, or worker/task termination path.

This is a Runtime lifecycle guarantee, not a Runtime dependency on Audit or Monitoring.

Consumers do not control Runtime cleanup ordering.

### HTTP

`InitializeInvocationMiddleware` receives the channel assigned to the delivery boundary:

```text
interactive_web
api_request
webhook_request
```

Lifecycle:

```text
request enters
    ↓
InitializeInvocationMiddleware creates root Invocation
    ↓
owner behavior executes
    ↓
successful response
    OR
exception enters Laravel reporting/rendering
    ↓
all synchronous request failure/reporting observers complete
while InvocationContextInterface remains valid
    ↓
terminable Runtime middleware cleanup
```

`InitializeInvocationMiddleware` is a terminable middleware.

Its `handle()` path:

1. establishes the root Invocation;
2. delegates the request;
3. does not clear Runtime state in a `finally` block that would execute before Laravel exception reporting.

Its `terminate()` path clears Runtime-owned Context after Laravel has produced the request response and completed synchronous exception reporting/rendering for that request.

Runtime cleanup must not depend on state stored only on the middleware object instance. Cleanup resolves `InvocationLifecycleCoordinator` and clears Runtime-owned Context directly.

If execution fails before Runtime initialization, there is no Runtime state to clear and downstream Monitoring follows its pre-Runtime fallback behavior.

External request headers never control Login 2.0 internal:

```text
invocation_id
correlation_id
causation_id
```

No Runtime response header is required by the initial design.

### Queues

Laravel Context carries the trusted dispatching Invocation across the queue boundary.

At `JobProcessing`:

1. verify no stale Runtime child state remains;
2. validate the inherited dispatching Invocation;
3. derive the new queue/Event-consumer child Invocation;
4. make that child current.

Channel selection:

```text
Illuminate\Events\CallQueuedListener
    → event_consumer

other queued execution
    → queued_job
```

Missing or malformed inherited Runtime state is an integration failure.

The child Invocation remains current throughout the complete attempt, including applicable:

```text
JobProcessed
JobExceptionOccurred
JobFailed
```

observation.

Runtime MUST NOT clear the child Invocation from a `JobExceptionOccurred` or `JobFailed` listener before other failure observers execute.

Post-attempt cleanup occurs at the queue worker lifecycle boundary after the attempt's processing/failure events have completed and before another job begins.

The initial Laravel integration uses the worker loop boundary for this cleanup:

```text
current attempt observers finish
    ↓
queue Looping boundary
    ↓
clear any Runtime state from prior attempt
    ↓
next job may be popped / JobProcessing may begin
```

`WorkerStopping` also clears any residual Runtime state so a worker terminating after one attempt cannot retain Invocation state.

`JobProcessing` defensively rejects or clears stale prior-attempt Runtime child state before deriving the new child according to the coordinator's bounded cleanup contract; it must never silently treat stale state as the new job's parent.

This guarantees:

* final failed-job Monitoring observers can still resolve the current Invocation;
* retryable exception observers see the attempt Invocation;
* successful post-job observers see the attempt Invocation;
* the next independent job never inherits stale child state.

Runtime does not depend on Monitoring.

### Console

A manually invoked application command creates a:

```text
console_command
```

root Invocation when no Invocation already exists.

Nested synchronous Artisan execution retains the existing Invocation.

`ConsoleInvocationSubscriber` tracks outer-versus-nested command lifecycle so nested commands do not create artificial Invocation chains.

Queue-worker and scheduler host commands are orchestration processes and do not become the parent Invocation for all work executed by those processes.

### Scheduler

At `ScheduledTaskStarting`:

1. clear any residual Runtime state belonging to a previously failed scheduled task;
2. create the new `scheduled_task` root Invocation.

The scheduled Invocation remains current through task execution and applicable failure observation.

For a successful foreground task:

* Runtime may clear after successful task completion.

For a task whose scheduler event reports a non-zero exit code:

* do NOT clear Runtime merely because the framework emitted its task-finished event;
* retain the current Invocation through the later task-failure event and framework exception reporting.

For a task that throws:

* retain the current Invocation through the task-failure event and framework exception reporting.

Runtime MUST NOT clear the scheduled Invocation from the failure listener before other failure observers execute.

Residual failed-task state is cleared:

1. before the next `ScheduledTaskStarting`; or
2. when the outer scheduler host command terminates if no later task begins.

The scheduler host command itself does not become the parent Invocation for scheduled tasks.

Background scheduled processes remain outside the initial Runtime propagation design as already stated.

```text
ScheduledTaskStarting
    ↓
scheduled_task Invocation
    ↓
task execution
    ├── success
    │     ↓
    │   cleanup after successful completion observation
    │
    └── failure
          ↓
        ScheduledTaskFailed / framework reporting
          ↓
        Invocation still valid
          ↓
        cleanup before next task or scheduler-host termination
```

Unrelated scheduled tasks must never share one correlation family.

If a scheduled task runs a synchronous Artisan command, the command retains the scheduled-task Invocation.

If it dispatches queued work, that work becomes a correlated asynchronous child.

### Internal System Execution

Application-owned execution that is neither HTTP, queue, command, Event consumer, nor scheduler may be initialized explicitly by Runtime infrastructure as:

```text
internal_system
```

This is not a generic consumer-accessible mechanism for replacing normal delivery boundaries.

---

## 7. Security And Reliability

Runtime guarantees:

* exactly five public Invocation fields;
* immutable public Invocation state;
* internally generated Invocation identity;
* deterministic root/child correlation;
* strict inherited-state validation;
* no Runtime leakage between independent executions;
* cleanup in long-running worker processes.

Runtime Context must never contain:

```text
credentials
secrets
PII
User Account data
permissions
Workspace state
request bodies
arbitrary owner metadata
service/container references
```

Invocation identifiers are not:

* authentication evidence;
* authorization grants;
* idempotency keys;
* database transaction IDs;
* Job IDs;
* Event IDs;
* Actor identities.

Runtime owns no persistence and no transaction behavior.

---

## 8. Operational Integration

### Audit

Core Audit consumes `InvocationContextInterface` to attach technical correlation evidence to Audit Events.

Runtime does not decide which actions are Audit-worthy.

### Monitoring

Core Monitoring may consume the same Contract for operational correlation.

Runtime does not own:

* failure severity;
* health state;
* anomaly detection;
* alerts;
* telemetry policy.

### Security

Security evidence may contain Runtime identifiers.

Invocation identity never establishes Principal identity, Actor identity, or authorization.

### External Propagation

Outbound trace/correlation protocol is not defined by the initial Runtime design.

External propagation is added only when a concrete integration defines:

* protocol;
* trust boundary;
* accepted headers/fields;
* validation;
* inbound/outbound mapping.

---

## 9. Application Registration

Runtime declares its Laravel integration through Application Registration.

```text
RuntimeServiceProvider
    ├── RegistrationDescriptorInterface declaration
    ↓
Application Registration Compiler
    ↓
Compiled Registration Manifest
    ↓
Root Application Registrar
    ↓
RuntimeServiceProvider registered into Laravel
```

`RuntimeServiceProvider` implements `RegistrationDescriptorInterface`. Its static, declarative `registration()` method returns `RegistrationDescriptorData` with:

```text
owner_key: runtime
ownership_area: core
dependencies: none
registrations:
  - RuntimeServiceProvider
  - applicable Runtime middleware, subscribers, and framework lifecycle integration
```

This one static declaration is Runtime's only owner registration declaration. It must not execute Runtime behavior, query persistence, or perform Laravel bindings while the compiler evaluates it.

`bootstrap/registration.php` names:

```text
App\Core\Runtime\Providers\RuntimeServiceProvider
```

as Runtime's explicit base-application descriptor source. Runtime does not modify `bootstrap/registration.php`; Application Registration owns root composition.

Runtime does not directly add `RuntimeServiceProvider` to `bootstrap/providers.php`.

After Laravel registers it through the compiled manifest, `RuntimeServiceProvider` owns Runtime-specific bindings and lifecycle integration, including:

* `InvocationContextInterface` binding;
* Runtime lifecycle subscriber registration;
* registration of the Runtime middleware as the application-wide HTTP Invocation boundary.

Application Registration owns composition only and does not absorb Runtime behavior.

---

## 10. Implementation Manifest

| Change | Path | Archetype | Responsibility | Dependencies | Requirement Source | Verification | Compatibility |
| --- | --- | --- | --- | --- | --- | --- | --- |
| DELETE | `app/Core/Runtime/Context.php` | Obsolete proof-of-concept artifact | Remove generic application context | None | `docs/03-architecture/public-contract-and-interaction-model.md` | Runtime architecture static validation | Delete obsolete proof-of-concept artifact; no preservation requirement |
| DELETE | `app/Core/Runtime/Resolver.php` | Obsolete proof-of-concept artifact | Remove obsolete generic context resolver | None | `docs/03-architecture/public-contract-and-interaction-model.md` | Runtime architecture static validation | Delete obsolete proof-of-concept artifact; no preservation requirement |
| CREATE | `app/Core/Runtime/Data/Invocation.php` | Data Object | Expose immutable five-field Invocation | `InvocationChannel` | `docs/03-architecture/public-contract-and-interaction-model.md` | Invocation Contract test | None |
| CREATE | `app/Core/Runtime/Enums/InvocationChannel.php` | Enum | Define canonical Invocation channels | None | `docs/03-architecture/public-contract-and-interaction-model.md` | Invocation Contract test | None |
| CREATE | `app/Core/Runtime/Enums/InvocationContextKey.php` | Enum | Define internal Laravel Context keys | Laravel Context | `docs/03-architecture/public-contract-and-interaction-model.md` | Invocation Context test | None |
| CREATE | `app/Core/Runtime/Contracts/InvocationContextInterface.php` | Contract | Expose current Invocation read boundary | `Invocation` | `docs/03-architecture/public-contract-and-interaction-model.md` | Invocation Context test | None |
| CREATE | `app/Core/Runtime/Resolvers/CurrentInvocationResolver.php` | Resolver | Validate and reconstruct current Invocation | `InvocationContextInterface`, Laravel Context | `docs/03-architecture/public-contract-and-interaction-model.md` | Invocation Context test | None |
| CREATE | `app/Core/Runtime/Coordinators/InvocationLifecycleCoordinator.php` | Coordinator | Create, derive, and clear Invocation state | `Invocation`, Laravel Context | `docs/03-architecture/public-contract-and-interaction-model.md` | Runtime lifecycle tests | None |
| CREATE | `app/Core/Runtime/Exceptions/InvalidInvocationContextException.php` | Exception | Signal invalid Runtime state | None | `docs/03-architecture/public-contract-and-interaction-model.md` | Invocation Context test | None |
| CREATE | `app/Core/Runtime/Http/Middleware/InitializeInvocationMiddleware.php` | Middleware | Establish HTTP root Invocation and perform terminable post-observation cleanup | `InvocationLifecycleCoordinator` | `docs/03-architecture/public-contract-and-interaction-model.md` | HTTP Invocation test | None |
| CREATE | `app/Core/Runtime/Listeners/QueueInvocationSubscriber.php` | Listener | Establish queue/Event-consumer child Invocation and clear state at post-attempt worker boundaries | `InvocationLifecycleCoordinator` | `docs/03-architecture/public-contract-and-interaction-model.md` | Queue Invocation test | None |
| CREATE | `app/Core/Runtime/Listeners/ConsoleInvocationSubscriber.php` | Listener | Establish manual command lifecycle | `InvocationLifecycleCoordinator` | `docs/03-architecture/public-contract-and-interaction-model.md` | Console Invocation test | None |
| CREATE | `app/Core/Runtime/Listeners/ScheduledInvocationSubscriber.php` | Listener | Establish scheduled-task roots and preserve Invocation through failure observation | `InvocationLifecycleCoordinator` | `docs/03-architecture/public-contract-and-interaction-model.md` | Scheduled Invocation test | None |
| CREATE | `app/Core/Runtime/Providers/RuntimeServiceProvider.php` | Provider and Registration Descriptor | Declare Runtime registration and bind Runtime lifecycle services | `RegistrationDescriptorInterface`, `RegistrationDescriptorData`, Laravel Provider API | `docs/03-architecture/application-registration.md` | Runtime Service Provider registration proof | None |
| CREATE | `app/Core/Runtime/__tests__/InvocationTest.php` | Test | Prove Invocation and channel Contract | Runtime public types | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/InvocationContextTest.php` | Test | Prove Context reconstruction and validation | `InvocationContextInterface` | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/HttpInvocationTest.php` | Test | Prove HTTP lifecycle, exception reporting before cleanup, and later-request isolation | Runtime middleware | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/QueueInvocationTest.php` | Test | Prove queue propagation, derivation, retry, `JobFailed`/`JobExceptionOccurred` visibility, and next-attempt cleanup | Queue subscriber | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/ConsoleInvocationTest.php` | Test | Prove console lifecycle | Console subscriber | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/ScheduledInvocationTest.php` | Test | Prove failure-observer visibility, non-zero exit behavior, and next-task/host cleanup | Scheduled subscriber | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/RuntimeServiceProviderRegistrationTest.php` | Test | Prove Runtime's single declarative registration source | `RuntimeServiceProvider`, Application Registration Contract | `docs/03-architecture/application-registration.md` | Provider registration architecture proof | None |

No migration, Model, Blade, CSS, JavaScript, route behavior, or Runtime configuration file is required.

---

## 11. Verification And Completion

Required implementation proof must establish:

* root Invocation creation;
* exactly five public fields;
* immutable typed access;
* all eight canonical Invocation Channels;
* synchronous continuation without child creation;
* asynchronous correlation and causation;
* new Invocation ID for every queue attempt;
* `queued_job` versus `event_consumer`;
* manual command isolation;
* scheduled-task isolation;
* nested synchronous command preservation;
* `internal_system` root behavior;
* no Context leakage between requests, Jobs, commands, or scheduled tasks;
* malformed or missing Runtime state fails explicitly;
* external request data cannot control internal Invocation identity;
* consumers cannot access a generic Runtime key/value API;
* Runtime owns no database or UI;
* Runtime Provider is composed through Application Registration rather than direct root bootstrap registration;
* `RuntimeServiceProvider` fulfills `RegistrationDescriptorInterface`;
* Runtime exposes exactly one registration declaration;
* no separate Runtime registration-descriptor class exists;
* `RuntimeServiceProvider` is not directly registered in `bootstrap/providers.php`;
* HTTP exception reporting can resolve the current Invocation before terminable cleanup;
* HTTP cleanup occurs after response/reporting and before a later independent request;
* `JobFailed` observers can resolve the current queue Invocation;
* `JobExceptionOccurred` observers can resolve the current queue Invocation;
* queue Runtime state is cleared before the next `JobProcessing`;
* worker termination clears residual Runtime state;
* scheduled-task failure observers can resolve the current `scheduled_task` Invocation;
* a non-zero scheduled command exit cannot cause Runtime cleanup before later failure observation;
* failed scheduled-task state is cleared before the next scheduled task;
* scheduler host termination clears residual scheduled-task state;
* none of these guarantees introduces a Runtime dependency on Monitoring;
* obsolete proof-of-concept Runtime context artifacts are removed.

### Non-Goals

The initial implementation does not define:

* external trace-header protocols;
* cross-process scheduled-task propagation;
* Actor or Principal context;
* generic application Context;
* persistence;
* distributed tracing infrastructure.

### Remaining Blockers

None for the initial Core Runtime implementation.

Audit, Monitoring, and Security consume Runtime later and do not block the Runtime public Contract.

### Implementation Ready

* [x] Runtime ownership and scope are complete.
* [x] Invocation schema is complete.
* [x] Invocation Channel vocabulary is complete.
* [x] public Contract is complete.
* [x] Laravel Context realization is defined.
* [x] root and child lifecycle are defined.
* [x] HTTP lifecycle is defined.
* [x] queue/Event-consumer lifecycle is defined.
* [x] console lifecycle is defined.
* [x] scheduler lifecycle is defined.
* [x] internal-system lifecycle is defined.
* [x] failure and isolation behavior are defined.
* [x] Application Registration integration is defined.
* [x] proof-of-concept cleanup is identified.
* [x] implementation manifest is complete.
* [x] verification surfaces are defined.
* [x] no material implementation-design blocker remains.

**Design state: ready for repository-owner review and acceptance.**

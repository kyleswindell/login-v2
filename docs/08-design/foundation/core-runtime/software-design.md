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
| `InitializeInvocationMiddleware`    | HTTP root Invocation lifecycle                          | `app/Core/Runtime/Http/Middleware/InitializeInvocationMiddleware.php` |
| `QueueInvocationSubscriber`         | Queue/Event-consumer child lifecycle and worker cleanup | `app/Core/Runtime/Listeners/QueueInvocationSubscriber.php`            |
| `ConsoleInvocationSubscriber`       | Manual command root lifecycle                           | `app/Core/Runtime/Listeners/ConsoleInvocationSubscriber.php`          |
| `ScheduledInvocationSubscriber`     | Per-scheduled-task root lifecycle                       | `app/Core/Runtime/Listeners/ScheduledInvocationSubscriber.php`        |
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
create root Invocation
    ↓
owner behavior executes
    ↓
response / exception
    ↓
Runtime cleanup in finally
```

External request headers never control Login 2.0 internal:

```text
invocation_id
correlation_id
causation_id
```

No Runtime response header is required by the initial design.

### Queues

Laravel Context carries the trusted dispatching Invocation across the queue boundary.

Before queued owner behavior executes, `QueueInvocationSubscriber`:

1. validates inherited parent Runtime state;
2. determines the child Invocation Channel;
3. derives a new child Invocation;
4. replaces the inherited parent state with child state.

Channel selection:

```text
Illuminate\Events\CallQueuedListener
    → event_consumer

other queued execution
    → queued_job
```

Missing or malformed inherited Runtime state is an integration failure.

Runtime state is cleared after:

* successful execution;
* failed execution;
* thrown exception;
* retry attempt completion;
* worker lifecycle boundaries required to prevent leakage.

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

Each scheduled task receives its own:

```text
scheduled_task
```

root Invocation.

Unrelated scheduled tasks must never share one correlation family.

If a scheduled task:

```text
runs synchronous Artisan command
```

the command retains the scheduled-task Invocation.

If it:

```text
dispatches queued work
```

that work becomes a correlated asynchronous child.

Background scheduled processes are outside the initial design until explicit cross-process Runtime propagation is accepted.

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
* Runtime HTTP middleware integration.

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
| CREATE | `app/Core/Runtime/Http/Middleware/InitializeInvocationMiddleware.php` | Middleware | Establish HTTP root lifecycle | `InvocationLifecycleCoordinator` | `docs/03-architecture/public-contract-and-interaction-model.md` | HTTP Invocation test | None |
| CREATE | `app/Core/Runtime/Listeners/QueueInvocationSubscriber.php` | Listener | Establish queue and Event-consumer child lifecycle | `InvocationLifecycleCoordinator` | `docs/03-architecture/public-contract-and-interaction-model.md` | Queue Invocation test | None |
| CREATE | `app/Core/Runtime/Listeners/ConsoleInvocationSubscriber.php` | Listener | Establish manual command lifecycle | `InvocationLifecycleCoordinator` | `docs/03-architecture/public-contract-and-interaction-model.md` | Console Invocation test | None |
| CREATE | `app/Core/Runtime/Listeners/ScheduledInvocationSubscriber.php` | Listener | Establish scheduled-task lifecycle | `InvocationLifecycleCoordinator` | `docs/03-architecture/public-contract-and-interaction-model.md` | Scheduled Invocation test | None |
| CREATE | `app/Core/Runtime/Providers/RuntimeServiceProvider.php` | Provider and Registration Descriptor | Declare Runtime registration and bind Runtime lifecycle services | `RegistrationDescriptorInterface`, `RegistrationDescriptorData`, Laravel Provider API | `docs/03-architecture/application-registration.md` | Runtime Service Provider registration proof | None |
| CREATE | `app/Core/Runtime/__tests__/InvocationTest.php` | Test | Prove Invocation and channel Contract | Runtime public types | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/InvocationContextTest.php` | Test | Prove Context reconstruction and validation | `InvocationContextInterface` | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/HttpInvocationTest.php` | Test | Prove HTTP lifecycle | Runtime middleware | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/QueueInvocationTest.php` | Test | Prove queue propagation, derivation, retry, and isolation | Queue subscriber | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/ConsoleInvocationTest.php` | Test | Prove console lifecycle | Console subscriber | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
| CREATE | `app/Core/Runtime/__tests__/ScheduledInvocationTest.php` | Test | Prove scheduler lifecycle | Scheduled subscriber | `docs/02-standards/testing/index.md` | Targeted Runtime test | None |
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

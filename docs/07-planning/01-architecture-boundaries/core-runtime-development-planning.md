<!--
DOC-META
title: Core Runtime Development Planning
doc_type: planning
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/01-architecture-boundaries/core-runtime-development-planning.md
parent: docs/07-planning/00-overview/m1-core-system-development-register.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines the M1 target design for Core Runtime as the narrow transport-independent Invocation context and lifecycle used to correlate application executions.
-->

# Core Runtime Development Planning

Parent: [M1 Core System Development Register](../00-overview/m1-core-system-development-register.md)

## 1. Purpose

Define the minimum Core Runtime needed by Login 2.0.

Core Runtime is foundation infrastructure, not a product capability. Its only responsibility is to identify one technical application execution and preserve its relationship to related executions across HTTP, queues, Events, commands, schedules, Audit, Monitoring, and future integrations.

The current implementation is reference evidence only. This plan defines target behavior from accepted M0 architecture and Laravel 13 capabilities.

## 2. Accepted Boundary

The canonical [Public Contract And Interaction Model](../../03-architecture/public-contract-and-interaction-model.md) already establishes that Runtime owns only a fixed technical Invocation envelope:

| Field                | Meaning                                                                  |
| -------------------- | ------------------------------------------------------------------------ |
| `invocation_id`      | Unique identifier for one execution                                      |
| `correlation_id`     | Identifier shared across related executions                              |
| `causation_id`       | Immediate prior Invocation that caused the current execution, when known |
| `invocation_channel` | Canonical ADR-0006 execution channel                                     |
| `started_at`         | UTC execution start time                                                 |

Runtime owns creation/restoration, propagation, immutable access, initialization, teardown, and rejection of missing or malformed required Runtime state.

Runtime does **not** own User, Principal, Actor, Tenant, Instance, Workspace, authorization, Settings, Module availability, Navigation, Audit policy, Monitoring policy, persistence, feature coordination, or arbitrary application context.

No additional Runtime fields are planned.

## 3. Laravel Implementation Direction

Laravel 13 already provides the low-level mechanisms Runtime needs:

- Laravel Context for execution-local context storage and retrieval;
- automatic Context propagation into queued Jobs;
- Context hydration/dehydration hooks;
- logging integration;
- HTTP middleware;
- queue lifecycle hooks/middleware;
- command lifecycle events;
- scheduler lifecycle events.

Login 2.0 should therefore **not build a general Runtime/context framework**.

Target implementation direction:

```text
Login 2.0
    defines Invocation semantics and typed public Contract
        ↓
Laravel Context
    stores and propagates Runtime values
        ↓
Laravel execution hooks
    initialize and tear down Runtime at each supported boundary
```

Laravel Context remains an internal mechanism. Core/Module consumers must not receive a generic key/value Context API through Runtime.

## 4. Invocation Lifecycle

### 4.1 Root Invocation

A root Invocation begins when work enters through a supported boundary without a trusted parent Invocation.

```text
invocation_id  = new unique identifier
correlation_id = invocation_id
causation_id   = null
started_at     = current UTC time
channel        = boundary-defined channel
```

Typical root channels:

- browser request → `interactive_web`
- API request → `api_request`
- webhook → `webhook_request`
- manual command → `console_command`
- scheduled task → `scheduled_task`
- explicit non-transport application execution → `internal_system`

External callers do not control Login 2.0's internal `invocation_id`.

### 4.2 Synchronous Continuation

Synchronous work remains inside the current Invocation.

Do not create a new Invocation for ordinary:

- Controller → Action calls;
- owner → provider public Contract calls;
- Queries;
- Services/Resolvers;
- synchronous Event listeners;
- synchronous internal framework calls.

The Invocation identifies the technical execution, not each method or domain operation.

### 4.3 Asynchronous Child Invocation

Independent asynchronous execution creates a new Invocation.

```text
child invocation_id  = new unique identifier
child correlation_id = parent correlation_id
child causation_id   = parent invocation_id
child started_at     = current UTC time
```

Channel:

- queued Job → `queued_job`
- queued/asynchronous Event consumer → `event_consumer`

Laravel Context should carry the trusted parent correlation information across the queue boundary.

### 4.4 Retries

Each actual queue execution attempt is a separate Invocation.

Retry attempts:

- receive a new `invocation_id`;
- retain the original correlation family;
- retain the original dispatching Invocation as causation unless later queue design establishes a stronger reason otherwise.

Job UUID, queue name, connection, attempt count, and retry timing are queue/Monitoring metadata, not Runtime fields.

### 4.5 Commands And Schedules

A manually invoked command is a `console_command` root Invocation.

Each scheduled task is its own `scheduled_task` root Invocation. Unrelated tasks executed by one scheduler process must not share one correlation family.

If a scheduled task internally runs an Artisan command synchronously, it remains part of the scheduled-task Invocation rather than creating an artificial nested command Invocation.

## 5. Public Contract

Runtime should expose one narrow, provider-owned read boundary.

Conceptually:

```text
InvocationContext
    current(): Invocation
```

`Invocation` is an immutable Data Object containing only the five canonical fields.

Exact PHP names remain implementation-level decisions subject to repository naming review.

The public Contract must not expose:

```text
get(string $key)
set(string $key, mixed $value)
currentUser()
workspace()
permissions()
settings()
service()
```

or any comparable generic application-context API.

Calling `current()` where supported Runtime initialization has failed should be treated as an internal integration defect. Runtime should not silently fabricate partial state or fall back to HTTP globals.

## 6. System Interactions

### Audit

Audit may record Runtime identifiers with accountable evidence so related actions can be correlated across executions.

Runtime does not decide which actions are Audit-worthy or interpret Actor, Action, Target, or Result.

### Monitoring

Monitoring may use Runtime identifiers to connect failures, queue attempts, and operational evidence across a related execution chain.

Runtime does not own failure severity, health state, anomaly detection, or alerting.

### Security

Security evidence may include Runtime identifiers where useful.

Invocation or correlation identifiers never prove identity or grant authorization.

### Future Integrations

Outbound Delivery Adapters may read Runtime correlation information and explicitly propagate it through a supported external protocol.

Runtime does not own transport headers or vendor-specific tracing behavior.

## 7. Reliability And Security Requirements

Runtime implementation must guarantee:

- immutable Runtime state after initialization;
- no context leakage between independent requests, Jobs, Event consumers, commands, or scheduled tasks;
- trusted internal generation of Invocation identity;
- validation of inherited child Runtime metadata;
- deterministic root/child correlation behavior;
- teardown in long-running worker processes;
- no credentials, secrets, PII, arbitrary request data, or owner-specific metadata in the Runtime envelope.

Runtime identifiers are not:

- authentication evidence;
- authorization grants;
- idempotency keys;
- database transaction identifiers;
- Job/Event identifiers.

Runtime owns no database table and no UI.

## 8. Reference Implementation Review

Relevant existing evidence includes:

- `app/Http/Middleware/EnsureRequestId.php`
- `app/Platform/Logging/PlatformLogger.php`
- `tests/Feature/Logging/RequestIdTest.php`

Useful behavior to retain as requirements or test scenarios:

- HTTP work receives a technical execution identifier;
- independent HTTP requests receive independent identifiers;
- response-level request correlation may be useful for diagnostics;
- invalid/untrusted external identifiers must not corrupt internal identity;
- Audit and Monitoring evidence benefit from correlation identifiers.

Do not retain as target architecture:

- HTTP request attributes as the universal Runtime store;
- `trace_id` merely duplicating `request_id`;
- dependence on an HTTP Request for Runtime access;
- direct Audit/Monitoring reads from HTTP request state.

## 9. Verification Direction

Future implementation proof should establish:

- root Invocation derivation;
- child correlation and causation;
- exactly five immutable public fields;
- synchronous continuation without unnecessary child Invocations;
- separate Invocation IDs for queue attempts;
- correct `queued_job` and `event_consumer` channels;
- command and scheduled-task isolation;
- no worker Context leakage;
- Runtime availability before owner behavior executes;
- typed Runtime consumption without HTTP globals;
- no generic Runtime context API;
- no Runtime database or UI.

Exact acceptance criteria, proof commands, fixtures, and environment details belong to later implementation issues.

## 10. Development Decomposition

Likely implementation slices:

1. **Invocation Contract** — immutable Invocation model and narrow read Contract.
2. **Laravel Context integration** — internal storage, initialization, teardown, and isolation.
3. **HTTP integration** — browser/API/webhook channels.
4. **Queue/Event integration** — parent propagation, child derivation, retries, queued Event consumers.
5. **Console/Scheduler integration** — command and per-task lifecycle.
6. **Audit/Monitoring integration** — after those M1 systems define their own evidence Contracts.
7. **External propagation** — deferred until a concrete integration requires it.

This decomposition does not establish final implementation order.

## 11. Remaining Implementation-Level Decisions

The following do not require further M1 architecture work:

- exact unique-ID representation/generator;
- final PHP type names;
- Laravel Context key names;
- exact Provider/binding implementation;
- exact middleware/hook classes;
- exact queue integration combination;
- whether HTTP responses expose a request/invocation identifier by default;
- exact internal exception type;
- external trace/correlation protocol for the first integration that needs one.

## 12. Documentation Promotion

After this plan is accepted:

- promote the durable Invocation lifecycle rules into [Public Contract And Interaction Model](../../03-architecture/public-contract-and-interaction-model.md);
- create a `docs/05-flows/` Invocation flow only if the lifecycle cannot remain concise in architecture;
- do not create Runtime database or feature documentation without a later concrete need;
- set this plan to `status: planned` and `canonical: true`.

## 13. Completion Criteria

Core Runtime M1 planning is complete when:

- the five-field Invocation model is accepted;
- root, synchronous, asynchronous, retry, command, and scheduler semantics are accepted;
- the narrow public Contract and prohibitions are accepted;
- Laravel Context is accepted as the preferred underlying mechanism;
- worker isolation and failure behavior are explicit;
- Audit/Monitoring interaction boundaries are sufficient for later system planning;
- remaining choices are implementation-level only.

After acceptance, M1 proceeds to **System 2 — Users** without implementing Runtime.

## 14. Related

- [M1 Core System Development Register](../00-overview/m1-core-system-development-register.md)
- [Public Contract And Interaction Model](../../03-architecture/public-contract-and-interaction-model.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [ADR-0006](../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [Planning Documentation Standards](../../02-standards/documentation/Planning%20Documentation%20Standards.md)

<!--
DOC-META
title: Core Monitoring Software Design
doc_type: design
status: draft
owner: core
canonical: false
canonical_path: docs/08-design/core/monitoring/software-design.md
parent: docs/08-design/index.md
template: docs/09-reference/templates/docs/_design.md
summary: Defines the target implementation design for Core Monitoring operational occurrences, grouped signals, health checks, failure capture, correlation, triage, redaction, and alert-routing boundaries.
-->

# Core Monitoring Software Design

Parent: [Software Design Index](../../index.md)

## 1. System Definition

### Purpose

Core Monitoring owns operational evidence answering:

> What failed, degraded, timed out, retried, became unhealthy, or otherwise requires operational attention?

Target owner:

```text
app/Core/Monitoring/
App\Core\Monitoring\
owner_key: monitoring
```

Monitoring owns:

* operational occurrences;
* application and integration failures;
* exception evidence;
* failed-job evidence;
* scheduled-task failures;
* health-check execution and results;
* stable failure fingerprinting;
* grouped operational Signals;
* deduplication;
* Signal triage state;
* operational alert-routing decisions;
* operational history and administration.

Monitoring does not own:

* accountable Audit history;
* domain state;
* authentication or authorization;
* security containment;
* secret remediation;
* Notification delivery;
* business workflows;
* arbitrary application logging.

### Audit Boundary

Use:

```text
Audit
    → who or what performed a meaningful Action?

Monitoring
    → what failed, degraded, retried, or requires operational attention?
```

One operation may legitimately produce both.

Current implementation may be reviewed for useful behavioral evidence, but it imposes no compatibility, preservation, migration, schema, or target-placement requirement on this design.

Obsolete proof-of-concept Monitoring/error-log artifacts may be explicitly deleted during implementation.

---

## 2. Governing Requirements

Primary authority:

* `docs/02-standards/logging/Monitoring And Alerting Standards.md`
* `docs/02-standards/logging/Logging Standards.md`
* `docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md`
* `docs/03-architecture/persistent-data-architecture.md`
* `docs/03-architecture/public-contract-and-interaction-model.md`
* `docs/08-design/foundation/core-runtime/software-design.md`
* `docs/08-design/foundation/application-registration/software-design.md`
* `docs/08-design/core/audit/software-design.md`
* `docs/08-design/core/security/software-design.md`
* applicable security, database, transaction, identifier, and testing standards.

Detailed Threat Detection remains a later Monitoring subcapability.

Monitoring provides the operational Signal foundation that Threat Detection may later consume or extend. It does not implement a SIEM/SOAR system or security containment workflow.

---

## 3. Component Design

| Component                             | Responsibility                                   | Target Path                                                             |
| ------------------------------------- | ------------------------------------------------ | ----------------------------------------------------------------------- |
| `RecordMonitoringOccurrenceInterface` | Public cross-owner operational evidence Contract | `app/Core/Monitoring/Contracts/RecordMonitoringOccurrenceInterface.php` |
| `HealthCheckInterface`                | Public Monitoring health-check Extension Point   | `app/Core/Monitoring/Contracts/HealthCheckInterface.php`                |
| `RecordMonitoringOccurrenceAction`    | Persist occurrence and evaluate Signal grouping  | `app/Core/Monitoring/Actions/RecordMonitoringOccurrenceAction.php`      |
| `RunHealthCheckAction`                | Execute one registered health check              | `app/Core/Monitoring/Actions/RunHealthCheckAction.php`                  |
| `TriageMonitoringSignalAction`        | Move Signal into triage/investigation            | `app/Core/Monitoring/Actions/TriageMonitoringSignalAction.php`          |
| `ResolveMonitoringSignalAction`       | Resolve an operational Signal                    | `app/Core/Monitoring/Actions/ResolveMonitoringSignalAction.php`         |
| `RecordMonitoringOccurrenceData`      | Typed producer evidence                          | `app/Core/Monitoring/Data/RecordMonitoringOccurrenceData.php`           |
| `MonitoringContextData`               | Safe execution/request context                   | `app/Core/Monitoring/Data/MonitoringContextData.php`                    |
| `MonitoringEvidenceData`              | Safe source-specific evidence                    | `app/Core/Monitoring/Data/MonitoringEvidenceData.php`                   |
| `MonitoringWriteResult`               | Occurrence/Signal recording result               | `app/Core/Monitoring/Data/MonitoringWriteResult.php`                    |
| `MonitoringSignalSnapshot`            | Public/read-side Signal shape                    | `app/Core/Monitoring/Data/MonitoringSignalSnapshot.php`                 |
| `MonitoringOccurrenceSnapshot`        | Public/read-side occurrence shape                | `app/Core/Monitoring/Data/MonitoringOccurrenceSnapshot.php`             |
| `MonitoringSearchCriteria`            | Typed Signal search criteria                     | `app/Core/Monitoring/Data/MonitoringSearchCriteria.php`                 |
| `HealthCheckDefinitionData`           | Registered health-check definition               | `app/Core/Monitoring/Data/HealthCheckDefinitionData.php`                |
| `HealthCheckResultData`               | One health-check result                          | `app/Core/Monitoring/Data/HealthCheckResultData.php`                    |
| `MonitoringSeverity`                  | Operational severity                             | `app/Core/Monitoring/Enums/MonitoringSeverity.php`                      |
| `MonitoringSignalStatus`              | Signal triage lifecycle                          | `app/Core/Monitoring/Enums/MonitoringSignalStatus.php`                  |
| `MonitoringSourceType`                | Controlled occurrence-source categories          | `app/Core/Monitoring/Enums/MonitoringSourceType.php`                    |
| `HealthCheckStatus`                   | Health result vocabulary                         | `app/Core/Monitoring/Enums/HealthCheckStatus.php`                       |
| `MonitoringSignal`                    | Grouped mutable operational Signal               | `app/Core/Monitoring/Models/MonitoringSignal.php`                       |
| `MonitoringOccurrence`                | Append-oriented operational observation          | `app/Core/Monitoring/Models/MonitoringOccurrence.php`                   |
| `MonitoringFingerprintResolver`       | Stable grouping fingerprint                      | `app/Core/Monitoring/Resolvers/MonitoringFingerprintResolver.php`       |
| `MonitoringContextRedactor`           | Apply Monitoring evidence minimization after Security redaction | `app/Core/Monitoring/Redaction/MonitoringContextRedactor.php` |
| `HealthCheckRegistry`                 | Monitoring-owned health-check Host Registry      | `app/Core/Monitoring/Registry/HealthCheckRegistry.php`                  |
| `SearchMonitoringSignalsQuery`        | Filter/paginate Signals                          | `app/Core/Monitoring/Queries/SearchMonitoringSignalsQuery.php`          |
| `GetMonitoringSignalQuery`            | Retrieve one Signal                              | `app/Core/Monitoring/Queries/GetMonitoringSignalQuery.php`              |
| `ListMonitoringOccurrencesQuery`      | Retrieve Signal/source occurrence history        | `app/Core/Monitoring/Queries/ListMonitoringOccurrencesQuery.php`        |
| `MonitoringServiceProvider`           | Framework lifecycle integration                  | `app/Core/Monitoring/Providers/MonitoringServiceProvider.php`           |
| `MonitoringRegistrationDescriptor`    | One Monitoring registration declaration with Runtime, Security, and Audit dependencies | `app/Core/Monitoring/Registration/MonitoringRegistrationDescriptor.php` |

No generic `LoggingService` or combined Audit/Monitoring persistence abstraction is introduced.

---

## 4. Contracts And Interactions

### Recording Contract

Cross-owner producers record operational evidence through:

```php
interface RecordMonitoringOccurrenceInterface
{
    public function record(
        RecordMonitoringOccurrenceData $data,
    ): MonitoringWriteResult;
}
```

Producers must not:

* insert Monitoring tables directly;
* create or update Signals directly;
* choose Signal IDs;
* bypass Monitoring redaction;
* invoke Notification delivery directly for Monitoring-owned attention.

### RecordMonitoringOccurrenceData

Contains:

```text
ownerKey
sourceType
sourceReference
severity
summary
groupingKey
context
evidence
runbookReference
```

`groupingKey` is a stable, safe, non-secret grouping input.

It must not contain:

* raw exception messages containing dynamic/private data;
* request bodies;
* credentials;
* customer payloads;
* generated random values.

### Source Types

`MonitoringSourceType` initially supports:

```text
exception
failed_job
health_check
queue
scheduled_task
integration
resource
operational
```

Additional source types require an actual Monitoring-owned use case.

### Severity

`MonitoringSeverity`:

```text
informational
low
medium
high
critical
```

`MonitoringSeverity` is Monitoring's provider-local typed representation of the shared canonical severity vocabulary defined by Logging Standards.

It serializes exactly:

```text
informational
low
medium
high
critical
```

Monitoring does not depend on an Audit-owned or generic shared PHP severity enum.

Severity reflects actual availability, security, data, recurrence, and recoverability impact.

It must not be used merely to increase alert visibility.

### Signal Lifecycle

`MonitoringSignalStatus`:

```text
new
triaged
investigating
resolved
```

Allowed transitions:

```text
new
 ├─→ triaged
 ├─→ investigating
 └─→ resolved

triaged
 ├─→ investigating
 └─→ resolved

investigating
 └─→ resolved

resolved
 └─→ new
      only when a new matching abnormal occurrence reopens the Signal
```

A resolved Signal cannot be silently mutated back to another state except through a new qualifying occurrence.

### Fingerprinting

`MonitoringFingerprintResolver` produces:

```text
SHA-256(
    owner_key
    + source_type
    + source_reference
    + normalized grouping_key
)
```

The fingerprint must remain stable across repeated manifestations of the same operational condition.

Dynamic timestamps, request IDs, Job UUIDs, exception messages, and random identifiers must not alter the fingerprint unless they materially define a different condition.

### Runtime Correlation

Monitoring consumes:

```text
InvocationContextInterface
```

and automatically captures applicable:

```text
invocation_id
correlation_id
causation_id
invocation_channel
```

Producers do not manually provide Runtime correlation fields.

`RecordMonitoringOccurrenceInterface` assumes a valid current Invocation. `RecordMonitoringOccurrenceAction` consumes `InvocationContextInterface` and requires `current()` to succeed; Monitoring never fabricates or initializes Runtime state.

For a framework failure that occurs before Runtime initialization, the framework integration adapter must not invoke the normal durable Monitoring recording path. It emits a minimal Security-redacted fallback through Laravel's framework logging channel, preserves the original exception/failure behavior, and does not fabricate `invocation_id`, `correlation_id`, `causation_id`, or `invocation_channel`.

### Runtime Failure-Observation Ordering

Monitoring's durable recording path requires a valid current Invocation.

Runtime guarantees that the current Invocation remains valid through synchronous framework failure observers associated with that execution.

The ordering is:

```text
Runtime initializes Invocation
    ↓
execution fails
    ↓
Monitoring/framework failure observer records evidence
    while InvocationContextInterface::current() is valid
    ↓
Runtime performs boundary cleanup
```

Monitoring never delays, owns, or invokes Runtime cleanup.

Runtime never depends on Monitoring.

For failures that occur before Runtime initialization, Monitoring continues to use only the Security-redacted framework fallback already defined.

### Health Check Contract

Monitoring owns Registry:

```text
monitoring.health_checks
```

Contributors register health checks through Application Registration.

Contribution identity uses the existing registry/contribution-key model.

Example:

```text
registry_key: monitoring.health_checks
contribution_key: notifications.mail_delivery
```

Each accepted Contribution resolves to `HealthCheckDefinitionData` containing:

```text
ownerKey
contributionKey
target
expectedCondition
intervalMinutes
failureThreshold
recoveryThreshold
failureSeverity
runbookReference
implementation
```

The implementation satisfies:

```php
interface HealthCheckInterface
{
    public function check(): HealthCheckResultData;
}
```

`HealthCheckStatus`:

```text
healthy
degraded
unhealthy
```

Health-check Contributors own the meaning of the expected condition.

Monitoring owns execution, threshold evaluation, occurrence recording, Signal state, and operational attention.

`intervalMinutes` is a positive integer with a minimum of `1`. The health command runs once per minute and executes a check only when it is due according to this whole-minute cadence. Initial implementation does not provide sub-minute health checks; `deduplication_window_seconds` remains a separate concern.

---

## 5. Data And Persistence

Core Monitoring initially owns:

```text
monitoring_signals
monitoring_occurrences
```

No separate table is created for:

* exceptions;
* failed Jobs;
* scheduler failures;
* integrations;
* each health-check type;
* dashboard projections.

### monitoring_signals

One row represents one grouped operational condition identified by its stable fingerprint.

Required data:

```text
id

fingerprint
owner_key
source_type
source_reference

severity
status
summary

first_seen_at
last_seen_at
opened_at
last_alerted_at

occurrence_count
deduplication_window_seconds

runbook_reference

triaged_at
investigating_at
resolved_at

created_at
updated_at
```

Required invariants:

* `fingerprint` is unique;
* occurrence count is never negative;
* `last_seen_at >= first_seen_at`;
* resolved status requires `resolved_at`;
* non-resolved status requires `resolved_at = null`;
* Signal severity uses the controlled enum;
* status uses the controlled enum.

Signal state is mutable because it represents current operational triage state.

### monitoring_occurrences

One row represents one actual operational observation.

Required data:

```text
id

monitoring_signal_id nullable

occurred_at

owner_key
source_type
source_reference
fingerprint

severity
summary

invocation_id
correlation_id
causation_id
invocation_channel

environment
release_reference

exception_class nullable
safe_location nullable
stack_trace nullable

context jsonb
evidence jsonb

created_at
```

`monitoring_signal_id` is nullable because a health or operational observation may be retained without yet crossing the threshold required to open a Signal.

Occurrences are append-oriented and are not edited through normal application behavior.

### Deduplication

Default:

```text
monitoring.deduplication.default_window_seconds = 300
```

A source-specific accepted policy may override that value.

Repeated abnormal occurrences with the same fingerprint:

1. append a new `monitoring_occurrences` row;
2. update the existing Signal's:

   * `last_seen_at`;
   * `occurrence_count`;
   * severity when escalation is required;
3. do not create duplicate Signals.

A new occurrence for a resolved Signal reopens that same fingerprinted Signal as `new`.

This preserves one stable triage identity while occurrence history records individual manifestations.

### Health-Check Persistence

Every executed health check records an occurrence.

Healthy results do not require an open Signal.

Failure/degraded occurrences open or update a Signal only when their configured threshold is reached.

A previously open health Signal is resolved only after its configured recovery threshold is satisfied.

### Instance Scope

The initial deployment uses one isolated Tenant Instance database.

Monitoring tables therefore do not add `tenant_id` or `instance_id` merely to restate the database isolation boundary.

### Database Documentation

Before implementation readiness, promote exact persistence Contracts to:

```text
docs/06-database/feature-contracts/monitoring.md
docs/06-database/tables/monitoring_signals.md
docs/06-database/tables/monitoring_occurrences.md
```

---

## 6. Delivery And Presentation

### Administration

Monitoring owns an operational administration surface.

Target:

```text
app/Core/Monitoring/Http/Controllers/MonitoringController.php
app/Core/Monitoring/Http/Requests/MonitoringSearchRequest.php
app/Core/Monitoring/routes/web.php

resources/views/core/monitoring/
```

Route names:

```text
monitoring.index
monitoring.show
monitoring.triage
monitoring.investigate
monitoring.resolve
```

### Route Security Classification

All initial Monitoring administration routes use the canonical:

```text
administrative
```

Security profile.

| Route                    | Security Profile |
| ------------------------ | ---------------- |
| `monitoring.index`       | `administrative` |
| `monitoring.show`        | `administrative` |
| `monitoring.triage`      | `administrative` |
| `monitoring.investigate` | `administrative` |
| `monitoring.resolve`     | `administrative` |

The route declarations use:

```text
RouteSecurityProfile::Administrative
```

The profile establishes the minimum:

* authenticated human posture;
* action/target/scope authorization;
* administrative authority;
* MFA-level assurance.

Core Access later owns the exact Monitoring permissions and target/state authorization.

Triage/investigate/resolve do not require `sensitive` merely because they mutate Monitoring state unless a later accepted requirement requires recent authentication.

The list view supports applicable filters for:

```text
status
severity
owner
source type
source reference
date/time
correlation ID
```

Signal detail presents:

* current severity/status;
* first/last seen;
* occurrence count;
* owner;
* runbook;
* safe summary;
* occurrence history;
* correlation evidence;
* safe source-specific evidence.

### Authorization

Exact Monitoring administration permissions and Access Contracts are reconciled when Core Access is designed.

UI visibility never replaces server-side authorization.

### Health Check Execution

Monitoring owns:

```text
monitoring:run-health-checks
```

through:

```text
app/Core/Monitoring/Console/RunHealthChecksCommand.php
```

Application Registration schedules the command once per minute.

The command evaluates registered definitions and runs only checks whose `intervalMinutes` make them due on the whole-minute cadence.

Overlapping executions of the same health check must be prevented.

---

## 7. Security And Reliability

### Redaction

Monitoring must never persist:

```text
passwords
temporary passwords
MFA values
recovery codes
raw tokens
authorization headers
cookies
private keys
secret-manager values
unrestricted request bodies
unnecessary personal data
sensitive Job payloads
```

Before `MonitoringContextRedactor` applies Monitoring-specific evidence minimization, it consumes Core Security's public `RedactSensitiveContextInterface` using `RedactionScope::log_context`.

```text
Monitoring source evidence
    ↓
Core Security RedactSensitiveContextInterface
    scope = log_context
    ↓
credential/request secret redaction
    ↓
MonitoringContextRedactor
    ↓
Monitoring-specific evidence minimization
    ↓
persistence/fingerprinting
```

Core Security and Security/Secrets own credential redaction. Monitoring owns operational evidence minimization, fingerprint safety, stack-trace/location safety, and cardinality control. Monitoring does not maintain a canonical credential-key catalog, while categorically prohibiting raw secret persistence.

Redaction applies to:

* exception messages where required;
* stack traces;
* request evidence;
* integration evidence;
* Job evidence;
* health-check evidence.

### Exception Evidence

Exception storage may include:

```text
exception class
redacted summary
safe application location
redacted stack trace
environment
release reference
Runtime correlation
```

It must not serialize the exception object or unrestricted local variables.

### Failed Jobs

Failed-job evidence may include:

```text
job class / stable job key
Job UUID
queue
connection
attempt count
final disposition
safe exception evidence
Runtime correlation
```

Job payload contents are not persisted.

### Monitoring Failure

Monitoring persistence failure must not cause a second application outage.

If durable recording fails:

1. pass fallback context through `RedactSensitiveContextInterface` and emit the resulting minimal record through Laravel's normal logging channel;
2. do not recursively attempt the same Monitoring write;
3. preserve the original application failure behavior;
4. return a failed/fallback `MonitoringWriteResult` where a caller receives one.

### Cardinality Protection

Unbounded grouping values are prohibited.

Fingerprint inputs must be stable.

Do not group on:

* complete URLs containing IDs;
* arbitrary exception messages;
* timestamps;
* request IDs;
* Job UUIDs;
* generated tokens;
* user-entered text.

### Notification Storm Protection

Repeated occurrences with an existing fingerprint do not independently generate attention routing inside the configured deduplication window.

Severity escalation may bypass the ordinary deduplication interval.

---

## 8. Events And Operational Effects

### Laravel Exception Integration

After Runtime initialization, the application exception-reporting boundary delegates reported exceptions into Monitoring.

```text
HTTP Invocation established
    ↓
application exception
    ↓
Laravel exception reporting hook
    ↓
RecordMonitoringOccurrenceInterface
    ↓
Monitoring reads current Invocation
    ↓
Laravel reporting/rendering completes
    ↓
Runtime terminable HTTP cleanup
```

The Monitoring reporting hook must execute before Runtime's terminable HTTP cleanup.

Monitoring does not clear Runtime.

Target integration remains Laravel's exception reporting hook in `bootstrap/app.php`. Laravel's existing rendering behavior remains separate.

Monitoring does not become the HTTP exception renderer.

If exception reporting is reached before Runtime initialization, the adapter emits only the minimal Security-redacted framework-log fallback defined in the Runtime precondition. It neither calls durable Monitoring recording nor changes Laravel's rendering or exception behavior.

### Queue Integration

`RecordFailedJob` consumes Laravel's final failed-job observation while the current queue Invocation is still valid.

Required ordering:

```text
JobProcessing
    ↓
queue child Invocation
    ↓
Job execution
    ↓
JobExceptionOccurred / JobFailed as applicable
    ↓
RecordFailedJob resolves InvocationContextInterface
    ↓
all attempt observers finish
    ↓
Runtime post-attempt cleanup before next job
```

The listener records:

```text
source_type = failed_job
```

Runtime does not clear from `JobFailed` before Monitoring's listener can execute.

Monitoring does not rely on provider-listener registration order to race against Runtime cleanup; Runtime cleanup belongs to the later post-attempt worker boundary.

Retryable exceptions that are not final failures are not automatically recorded as final failed-job Signals.

### Scheduler Integration

`RecordScheduledTaskFailure` consumes the scheduled-task failure observation while the current `scheduled_task` Invocation remains valid.

Required ordering:

```text
ScheduledTaskStarting
    ↓
scheduled_task Invocation
    ↓
task execution
    ↓
failure observation / exception reporting
    ↓
RecordScheduledTaskFailure resolves current Invocation
    ↓
Runtime later clears failed-task state
```

The listener records:

```text
source_type = scheduled_task
```

Monitoring must not assume that an earlier task-finished framework event proves the scheduled task will not subsequently be classified as failed.

Monitoring owns only failure evidence; Runtime owns the lifecycle guarantee.

### Signal Events

Monitoring owns completed-fact Events:

```text
MonitoringSignalOpened
MonitoringSignalEscalated
MonitoringSignalResolved
```

Events dispatch after the applicable Monitoring transaction commits.

Payloads contain only safe provider-owned Signal snapshot data.

### Notifications

Monitoring owns the decision that a Signal requires operational attention.

Core Notifications later owns durable delivery.

The exact Notifications Operation/Event interaction remains a later cross-system reconciliation item.

Personal notification Preferences must not be assumed to disable mandatory operational/security attention.

### Audit

Operator-driven Monitoring state changes are accountable.

After successful triage/investigation/resolution, Monitoring records applicable Audit Events such as:

```text
monitoring.signal_triaged
monitoring.signal_investigated
monitoring.signal_resolved
```

through Core Audit's public recording Contract.

Automatic occurrence ingestion itself is Monitoring evidence and does not create an Audit Event merely because a Signal count changed.

### Security / Threat Detection

Threat Detection may later consume:

* Monitoring occurrences;
* Monitoring Signals;
* Audit evidence;
* health evidence.

Monitoring does not execute containment actions such as:

* suspending Users;
* revoking Access;
* rotating secrets;
* disabling Modules.

Those actions remain with their owning capabilities.

### Application Registration

`MonitoringRegistrationDescriptor` declares:

* `MonitoringServiceProvider`;
* routes;
* console command;
* scheduler registration;
* database migrations;
* health-check Host Registry;
* applicable Event integration.

Its owner registration dependencies explicitly include `runtime`, `security`, and `audit` where these defined interactions require their public Contracts.

Monitoring does not directly add its Provider to root Laravel bootstrap composition.

---

## 9. Implementation Manifest

| Change | Path | Archetype | Responsibility | Dependencies | Requirement Source | Verification | Compatibility |
| --- | --- | --- | --- | --- | --- | --- | --- |
| CREATE | `app/Core/Monitoring/Actions/RecordMonitoringOccurrenceAction.php` | Action | Record an occurrence using a current Invocation | Monitoring Contract, Runtime, Security redaction | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring Runtime fallback test | None |
| CREATE | `app/Core/Monitoring/Actions/RunHealthCheckAction.php` | Action | Execute one due health check | Health Check Contract, Registry | `docs/02-standards/logging/Monitoring And Alerting Standards.md` | Health-check execution test | None |
| CREATE | `app/Core/Monitoring/Actions/TriageMonitoringSignalAction.php` | Action | Triage one Signal | Monitoring Signal model | `docs/03-architecture/public-contract-and-interaction-model.md` | Signal lifecycle test | None |
| CREATE | `app/Core/Monitoring/Actions/ResolveMonitoringSignalAction.php` | Action | Resolve one Signal | Monitoring Signal model | `docs/03-architecture/public-contract-and-interaction-model.md` | Signal lifecycle test | None |
| CREATE | `app/Core/Monitoring/Contracts/RecordMonitoringOccurrenceInterface.php` | Contract | Expose public occurrence recording | Monitoring Data and result | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring occurrence test | None |
| CREATE | `app/Core/Monitoring/Contracts/HealthCheckInterface.php` | Contract | Define health-check Extension Point | Health Check result data | `docs/03-architecture/public-contract-and-interaction-model.md` | Health-check registry test | None |
| CREATE | `app/Core/Monitoring/Data/RecordMonitoringOccurrenceData.php` | Data Object | Receive typed source evidence | Monitoring data types | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring occurrence test | None |
| CREATE | `app/Core/Monitoring/Data/MonitoringContextData.php` | Data Object | Hold safe execution context | Security redaction Contract | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring redaction test | None |
| CREATE | `app/Core/Monitoring/Data/MonitoringEvidenceData.php` | Data Object | Hold safe source evidence | Security redaction Contract | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring redaction test | None |
| CREATE | `app/Core/Monitoring/Data/MonitoringWriteResult.php` | Data Object | Report occurrence and Signal result | None | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring fallback test | None |
| CREATE | `app/Core/Monitoring/Data/MonitoringSignalSnapshot.php` | Data Object | Expose read-side Signal data | Monitoring Signal model | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring administration test | None |
| CREATE | `app/Core/Monitoring/Data/MonitoringOccurrenceSnapshot.php` | Data Object | Expose read-side occurrence data | Monitoring Occurrence model | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring administration test | None |
| CREATE | `app/Core/Monitoring/Data/MonitoringSearchCriteria.php` | Data Object | Carry typed Signal filters | None | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring administration test | None |
| CREATE | `app/Core/Monitoring/Data/HealthCheckDefinitionData.php` | Data Object | Define one health check and whole-minute cadence | `HealthCheckInterface` | `docs/02-standards/logging/Monitoring And Alerting Standards.md` | Health-check execution test | None |
| CREATE | `app/Core/Monitoring/Data/HealthCheckResultData.php` | Data Object | Report one health result | None | `docs/02-standards/logging/Monitoring And Alerting Standards.md` | Health-check execution test | None |
| CREATE | `app/Core/Monitoring/Enums/MonitoringSeverity.php` | Enum | Define operational severity | None | `docs/02-standards/logging/Monitoring And Alerting Standards.md` | Monitoring occurrence test | None |
| CREATE | `app/Core/Monitoring/Enums/MonitoringSignalStatus.php` | Enum | Define Signal lifecycle status | None | `docs/02-standards/logging/Monitoring And Alerting Standards.md` | Signal lifecycle test | None |
| CREATE | `app/Core/Monitoring/Enums/MonitoringSourceType.php` | Enum | Define occurrence source types | None | `docs/02-standards/logging/Monitoring And Alerting Standards.md` | Monitoring occurrence test | None |
| CREATE | `app/Core/Monitoring/Enums/HealthCheckStatus.php` | Enum | Define health result status | None | `docs/02-standards/logging/Monitoring And Alerting Standards.md` | Health-check execution test | None |
| CREATE | `app/Core/Monitoring/Models/MonitoringSignal.php` | Model | Represent grouped triage state | `monitoring_signals` Contract | `docs/03-architecture/persistent-data-architecture.md` | Signal grouping test | None |
| CREATE | `app/Core/Monitoring/Models/MonitoringOccurrence.php` | Model | Represent append-oriented observation | `monitoring_occurrences` Contract | `docs/03-architecture/persistent-data-architecture.md` | Monitoring occurrence test | None |
| CREATE | `app/Core/Monitoring/Queries/SearchMonitoringSignalsQuery.php` | Query | Search Signals | Monitoring Signal model | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring administration test | None |
| CREATE | `app/Core/Monitoring/Queries/GetMonitoringSignalQuery.php` | Query | Retrieve one Signal | Monitoring Signal model | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring administration test | None |
| CREATE | `app/Core/Monitoring/Queries/ListMonitoringOccurrencesQuery.php` | Query | List occurrence history | Monitoring Occurrence model | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring administration test | None |
| CREATE | `app/Core/Monitoring/Resolvers/MonitoringFingerprintResolver.php` | Resolver | Generate safe stable fingerprint | Monitoring source data | `docs/02-standards/logging/Monitoring And Alerting Standards.md` | Signal grouping test | None |
| CREATE | `app/Core/Monitoring/Redaction/MonitoringContextRedactor.php` | Redactor | Apply Monitoring minimization after Security redaction | `RedactSensitiveContextInterface` | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring redaction test | None |
| CREATE | `app/Core/Monitoring/Registry/HealthCheckRegistry.php` | Registry | Accept Monitoring health-check Contributions | Health Check Contract | `docs/03-architecture/public-contract-and-interaction-model.md` | Health-check registry test | None |
| CREATE | `app/Core/Monitoring/Events/MonitoringSignalOpened.php` | Event | Publish opened Signal fact | Monitoring Signal snapshot | `docs/03-architecture/public-contract-and-interaction-model.md` | Signal Event after-commit test | None |
| CREATE | `app/Core/Monitoring/Events/MonitoringSignalEscalated.php` | Event | Publish escalated Signal fact | Monitoring Signal snapshot | `docs/03-architecture/public-contract-and-interaction-model.md` | Signal Event after-commit test | None |
| CREATE | `app/Core/Monitoring/Events/MonitoringSignalResolved.php` | Event | Publish resolved Signal fact | Monitoring Signal snapshot | `docs/03-architecture/public-contract-and-interaction-model.md` | Signal Event after-commit test | None |
| CREATE | `app/Core/Monitoring/Listeners/RecordFailedJob.php` | Listener | Record final Job failure | Monitoring Contract | `docs/03-architecture/public-contract-and-interaction-model.md` | Failed-job Monitoring test | None |
| CREATE | `app/Core/Monitoring/Listeners/RecordScheduledTaskFailure.php` | Listener | Record scheduled-task failure | Monitoring Contract | `docs/03-architecture/public-contract-and-interaction-model.md` | Scheduled-task Monitoring test | None |
| CREATE | `app/Core/Monitoring/Console/RunHealthChecksCommand.php` | Command | Run due checks once per minute | Health Check Registry | `docs/02-standards/logging/Monitoring And Alerting Standards.md` | Health-check execution test | None |
| CREATE | `app/Core/Monitoring/Http/Controllers/MonitoringController.php` | Controller | Deliver Monitoring administration | Monitoring queries | `docs/03-architecture/repository-architecture.md` | Monitoring administration test | None |
| CREATE | `app/Core/Monitoring/Http/Requests/MonitoringSearchRequest.php` | Form Request | Validate Monitoring search input | None | `docs/03-architecture/repository-architecture.md` | Monitoring administration test | None |
| CREATE | `app/Core/Monitoring/Providers/MonitoringServiceProvider.php` | Provider | Bind Monitoring and framework integration | Monitoring Contracts | `docs/03-architecture/application-registration.md` | Monitoring registration test | None |
| CREATE | `app/Core/Monitoring/Registration/MonitoringRegistrationDescriptor.php` | Registration Descriptor | Declare Monitoring artifacts and owner dependencies | `runtime`, `security`, `audit` | `docs/03-architecture/application-registration.md` | Monitoring registration test | None |
| CREATE | `app/Core/Monitoring/routes/web.php` | Route | Declare Monitoring administration routes using the canonical `administrative` Security profile | Monitoring Controller, `RouteSecurityProfile::Administrative` | `docs/02-standards/security/Zero Trust Security Standards.md` | Monitoring administration Security-profile test | None |
| CREATE | `app/Core/Monitoring/config/monitoring.php` | Configuration | Define structural Monitoring configuration | Laravel configuration | `docs/03-architecture/repository-architecture.md` | Monitoring configuration test | None |
| MODIFY | `bootstrap/app.php` | Laravel integration | Route post-Runtime exceptions to Monitoring or pre-Runtime fallback | Laravel exception hook, Runtime | `docs/03-architecture/public-contract-and-interaction-model.md` | Monitoring Runtime fallback test | None |
| CREATE | `resources/views/core/monitoring/` | View family | Render Monitoring administration | Monitoring Controller | `docs/03-architecture/repository-architecture.md` | Manual visual review and Monitoring administration test | None |
| CREATE | `database/core/Monitoring/migrations/` | Migration family | Materialize Monitoring persistence | Canonical Monitoring table Contracts | `docs/03-architecture/persistent-data-architecture.md` | Database migration proof | None |
| CREATE | `database/core/Monitoring/factories/` | Factory family | Supply Monitoring test data | Monitoring Models | `docs/03-architecture/persistent-data-architecture.md` | Targeted Monitoring proof | None |
| CREATE | `docs/06-database/feature-contracts/monitoring.md` | Database Contract | Define Monitoring persistence behavior | Monitoring persistence requirements | `docs/03-architecture/persistent-data-architecture.md` | Documentation static validation | None |
| CREATE | `docs/06-database/tables/monitoring_signals.md` | Database Contract | Define `monitoring_signals` table | Monitoring persistence requirements | `docs/03-architecture/persistent-data-architecture.md` | Documentation static validation | None |
| CREATE | `docs/06-database/tables/monitoring_occurrences.md` | Database Contract | Define `monitoring_occurrences` table | Monitoring persistence requirements | `docs/03-architecture/persistent-data-architecture.md` | Documentation static validation | None |
| CREATE | `app/Core/Monitoring/__tests__/MonitoringOccurrenceTest.php` | Test | Prove occurrence recording | Monitoring owner artifacts | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `app/Core/Monitoring/__tests__/MonitoringSignalGroupingTest.php` | Test | Prove fingerprint grouping | Monitoring owner artifacts | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `app/Core/Monitoring/__tests__/MonitoringSignalLifecycleTest.php` | Test | Prove Signal transitions | Monitoring owner artifacts | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `app/Core/Monitoring/__tests__/MonitoringRedactionTest.php` | Test | Prove Security-first context redaction | Security redaction Contract | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `app/Core/Monitoring/__tests__/MonitoringFallbackTest.php` | Test | Prove pre-Runtime fallback and no fabricated Invocation | Runtime and Security redaction | `docs/02-standards/testing/index.md` | Monitoring Runtime fallback test | None |
| CREATE | `app/Core/Monitoring/__tests__/HealthCheckRegistryTest.php` | Test | Prove health-check Contributions | Health Check Registry | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `app/Core/Monitoring/__tests__/HealthCheckExecutionTest.php` | Test | Prove whole-minute due execution | Health Check command | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `app/Core/Monitoring/__tests__/FailedJobMonitoringTest.php` | Test | Prove `JobFailed` capture occurs while the queue Invocation remains valid | Failed Job Listener | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `app/Core/Monitoring/__tests__/ScheduledTaskMonitoringTest.php` | Test | Prove scheduled failure capture occurs while the scheduled Invocation remains valid | Scheduled Listener | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `app/Core/Monitoring/__tests__/MonitoringRegistrationTest.php` | Test | Prove Monitoring's single descriptor | Monitoring Registration Descriptor | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `tests/Feature/Monitoring/ExceptionMonitoringTest.php` | Test | Prove HTTP Monitoring capture occurs before Runtime terminable cleanup | Laravel exception hook | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |
| CREATE | `tests/Feature/Monitoring/MonitoringAdministrationTest.php` | Test | Prove Monitoring administration behavior and all route profiles use `administrative` | Monitoring routes and queries | `docs/02-standards/testing/index.md` | Targeted Monitoring proof | None |

Obsolete proof-of-concept error-log or Monitoring artifacts are deleted only when a bounded implementation issue identifies each target. They have no preservation requirement.

---

## 10. Verification And Completion

Required proof must establish:

* exception capture;
* failed-job capture;
* scheduled-task failure capture;
* Runtime correlation;
* Monitoring can resolve Runtime correlation from HTTP exception reporting before cleanup;
* final Job failure capture occurs before queue Runtime cleanup;
* scheduled-task failure capture occurs before scheduled Runtime cleanup;
* Monitoring never initializes or clears Runtime;
* `RecordMonitoringOccurrenceAction` requires `InvocationContextInterface::current()` and never initializes Runtime;
* pre-Runtime framework failures use only Security-redacted Laravel fallback logging;
* stable fingerprint generation;
* duplicate occurrence grouping;
* no duplicate Signal creation for one fingerprint;
* configured deduplication window behavior;
* severity escalation;
* Signal reopen after recurrence;
* legal Signal state transitions;
* health-check registration;
* health-check scheduling;
* positive `intervalMinutes` with whole-minute due execution and no sub-minute promise;
* health failure threshold;
* health recovery threshold;
* healthy occurrences without unnecessary open Signals;
* occurrence history;
* first/last-seen and occurrence counts;
* redacted exception context;
* no sensitive Job payload storage;
* Monitoring persistence fallback;
* Security redaction occurs before Monitoring evidence minimization and fallback logging;
* no fallback recursion;
* operator triage Audit evidence;
* Signal events after commit;
* no Audit/Monitoring ownership collapse;
* no security containment performed by Monitoring;
* all five Monitoring administration routes use `administrative`;
* route profiles do not replace Core Access authorization;
* Application Registration composition;
* the one Monitoring descriptor declares applicable `runtime`, `security`, and `audit` dependencies;
* obsolete conflicting proof-of-concept Monitoring/error-log mechanisms are removed.

### Remaining Blockers

1. **Monitoring database Contracts** — exact `monitoring_signals` and `monitoring_occurrences` table Contracts must be accepted in `/06-database/`.
2. **Monitoring standard acceptance** — `Monitoring And Alerting Standards.md` currently remains `status: draft`.
3. **Notifications design** — exact durable operational alert-delivery interaction.
4. **Access design** — exact Monitoring administration authorization.
5. **DataProtection design** — broader classification/redaction integration.
6. **DataGovernance design** — retention and legal-hold requirements.
7. **Threat Detection design** — later security-signal semantics and lifecycle remain outside this initial Monitoring implementation.

These dependencies do not require redesigning Monitoring occurrence storage, fingerprinting, Signal grouping, Runtime correlation, or health-check ownership.

### Implementation Ready

* [x] Monitoring ownership is defined.
* [x] Audit/Monitoring separation is defined.
* [x] public occurrence Contract is defined.
* [x] operational severity is defined.
* [x] Signal lifecycle is defined.
* [x] fingerprinting is defined.
* [x] deduplication behavior is defined.
* [x] Runtime correlation is defined.
* [x] greenfield persistence model is defined.
* [x] health-check Extension Point is defined.
* [x] exception integration is defined.
* [x] queue failure integration is defined.
* [x] scheduler failure integration is defined.
* [x] baseline redaction is defined.
* [x] fallback behavior is defined.
* [x] Application Registration integration is defined.
* [x] implementation manifest is defined.
* [x] verification surfaces are defined.
* [ ] canonical Monitoring database Contracts are accepted.
* [ ] applicable Monitoring standard is accepted.
* [ ] Notifications alert delivery is reconciled.
* [ ] Access administration is reconciled.
* [ ] DataProtection/DataGovernance dependencies are reconciled.
* [ ] no material design blocker remains.

**Design state: draft; the target Monitoring foundation is defined and ready for later foundation reconciliation, but the complete system is not yet implementation-ready.**

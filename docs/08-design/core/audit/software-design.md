<!--
DOC-META
title: Core Audit Software Design
doc_type: design
status: draft
owner: core
canonical: false
canonical_path: docs/08-design/core/audit/software-design.md
parent: docs/08-design/index.md
template: docs/09-reference/templates/docs/_design.md
summary: Defines the target implementation design for Core Audit accountable evidence, recording Contracts, persistence, correlation, redaction, querying, and administration.
-->

# Core Audit Software Design

Parent: [Software Design Index](../../index.md)

## 1. System Definition

### Purpose

Core Audit owns durable accountable evidence answering:

> Who or what performed or initiated a meaningful Action, what was affected, what was the result, and what evidence is required to reconstruct it?

Target owner:

```text
app/Core/Audit/
App\Core\Audit\
owner_key: audit
```

Audit owns:

* the common Audit evidence envelope;
* append-only Audit persistence;
* public Audit recording;
* event-time Actor attribution;
* subject and target attribution;
* Runtime correlation;
* safe metadata and change sets;
* Audit queries and administrative history.

Audit does not own:

* domain event meaning;
* authentication or authorization;
* operational failures or telemetry;
* mutable source records;
* DataProtection policy;
* domain Notifications.

Domain owners define which facts are Audit-worthy and their canonical event keys. Audit defines how those facts are safely recorded.

---

## 2. Governing Requirements

Primary authority:

* `docs/02-standards/logging/Audit Logging Standards.md`
* `docs/02-standards/logging/Logging Standards.md`
* `docs/03-architecture/persistent-data-architecture.md`
* `docs/03-architecture/public-contract-and-interaction-model.md`
* `docs/01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md`
* `docs/08-design/foundation/core-runtime/software-design.md`
* `docs/08-design/foundation/application-registration/software-design.md`
* applicable database, security, and identifier standards.

Current Audit implementation is reference evidence only and imposes no preservation or migration requirement.

---

## 3. Component Design

| Component                   | Responsibility                                | Target Path                                              |
| --------------------------- | --------------------------------------------- | -------------------------------------------------------- |
| `RecordAuditEventInterface` | Public cross-owner Audit write Contract       | `app/Core/Audit/Contracts/RecordAuditEventInterface.php` |
| `RecordAuditEventAction`    | Validate, redact, and persist one Audit Event | `app/Core/Audit/Actions/RecordAuditEventAction.php`      |
| `RecordAuditEventData`      | Typed producer input                          | `app/Core/Audit/Data/RecordAuditEventData.php`           |
| `AuditActorData`            | Event-time Principal/Actor snapshot           | `app/Core/Audit/Data/AuditActorData.php`                 |
| `AuditResourceData`         | Subject or target reference                   | `app/Core/Audit/Data/AuditResourceData.php`              |
| `AuditContextData`          | Safe request/network/execution evidence       | `app/Core/Audit/Data/AuditContextData.php`               |
| `AuditMetadataData`         | Safe typed supplemental evidence              | `app/Core/Audit/Data/AuditMetadataData.php`              |
| `AuditChangeData`           | One redacted field change                     | `app/Core/Audit/Data/AuditChangeData.php`                |
| `AuditWriteResult`          | Durable/fallback write result                 | `app/Core/Audit/Data/AuditWriteResult.php`               |
| `AuditEventSnapshot`        | Read-side Audit representation                | `app/Core/Audit/Data/AuditEventSnapshot.php`             |
| `AuditSearchCriteria`       | Audit query criteria                          | `app/Core/Audit/Data/AuditSearchCriteria.php`            |
| `AuditResult`               | Stable outcome values                         | `app/Core/Audit/Enums/AuditResult.php`                   |
| `AuditPrincipalType`        | Canonical Principal categories                | `app/Core/Audit/Enums/AuditPrincipalType.php`            |
| `AuditEvent`                | Append-only persistence Model                 | `app/Core/Audit/Models/AuditEvent.php`                   |
| `SearchAuditEventsQuery`    | Filtered Audit history                        | `app/Core/Audit/Queries/SearchAuditEventsQuery.php`      |
| `GetAuditEventQuery`        | Retrieve one Audit Event                      | `app/Core/Audit/Queries/GetAuditEventQuery.php`          |
| `AuditEvidenceRedactor`     | Enforce Audit-specific safe-evidence rules    | `app/Core/Audit/Redaction/AuditEvidenceRedactor.php`     |
| `AuditServiceProvider`      | Binding and owner registration                | `app/Core/Audit/Providers/AuditServiceProvider.php`      |

Do not create a generic Logging abstraction shared with Monitoring.

---

## 4. Public Contract And Evidence Model

### Recording Contract

```php
interface RecordAuditEventInterface
{
    public function record(RecordAuditEventData $data): AuditWriteResult;
}
```

Producers depend only on this provider-owned Contract.

### Event Key

`RecordAuditEventData` requires the producer's canonical domain-first Audit event key.

Examples:

```text
auth.login_succeeded
users.user_account_suspended
access.role_updated
data_protection.export_requested
```

Audit does not create a competing `audit.*` key.

### Result

`AuditResult`:

```text
succeeded
failed
denied
skipped
partial
```

### Principal Type

`AuditPrincipalType`:

```text
user_account
service_account
workload
application
system
```

Jobs, commands, webhooks, scheduled tasks, Events, routes, and IP addresses are execution/context information—not Principal types.

### Actor Snapshot

`AuditActorData` contains applicable:

```text
principal_type
principal_id
system_actor_key
display_label
initiating_user_account_id
machine_identity_reference
network_identity_reference
```

Historical evidence must remain interpretable without depending solely on mutable current profile data.

### Subject And Target

`AuditResourceData` contains:

```text
type
id
display_label
```

An Event may have:

* a subject;
* a target;
* both;
* neither when the Action has no resource target.

### Runtime Correlation

Audit consumes Core Runtime's:

```text
InvocationContextInterface
```

and automatically records:

```text
invocation_id
correlation_id
causation_id
invocation_channel
```

Producers do not manually populate these fields.

---

## 5. Data And Persistence

### Target Table

Core Audit owns one initial table:

```text
audit_events
```

No legacy Audit table is retained and no separate change table is required initially.

### Required Persistent Data

The canonical `/06-database/` table Contract must define at least:

```text
id
occurred_at

event_key
result
severity
is_security_event

principal_type
principal_id
system_actor_key
actor_display_label
initiating_user_account_id

machine_identity_reference
network_identity_reference

invocation_id
correlation_id
causation_id
invocation_channel

subject_type
subject_id
subject_display_label

target_type
target_id
target_display_label

reason
summary

context
metadata
changes

created_at
```

Structured supplemental fields use PostgreSQL `jsonb`.

### Instance Scope

The initial deployment uses one isolated Tenant Instance database, so `audit_events` does not add `tenant_id` or `instance_id` merely to restate that isolation boundary.

### Keys And Indexes

Required:

* primary key on `id`;
* unique immutable Event ID;
* chronological index on `occurred_at`;
* index on `event_key`;
* index on `principal_type`, `principal_id`;
* index on `correlation_id`;
* index on subject type/id;
* index on target type/id;
* index supporting security-event filtering.

Add further indexes only for accepted query paths.

### Immutability

Normal application behavior may:

```text
INSERT audit event
READ audit event
SEARCH audit events
```

It may not:

```text
UPDATE audit event
DELETE audit event
```

Corrections append explanatory evidence rather than modifying history.

Exact table/column/constraint definitions must be promoted to:

```text
docs/06-database/feature-contracts/audit.md
docs/06-database/tables/audit_events.md
```

before implementation readiness.

---

## 6. Recording And Transaction Behavior

### Successful Mutation

For successful state-changing behavior:

```text
owner mutation transaction
        ↓
commit succeeds
        ↓
RecordAuditEventInterface
```

Successful Audit evidence must never remain for a mutation that rolled back.

The domain Action owns its transaction and Audit call timing.

### Denied Or Failed Action

A denied or failed action that produces no domain mutation may be recorded immediately when its owning behavior defines the attempt as Audit-worthy.

A denied action is not automatically a Monitoring failure.

### Persistence Failure

Audit persistence failure must not create a second application outage.

On database write failure:

1. emit a minimal redacted fallback record through the framework logging channel;
2. return an `AuditWriteResult` indicating fallback rather than durable persistence;
3. never expose unrestricted metadata or changes in the fallback;
4. allow Monitoring to observe the failure once Monitoring is available.

A failed Audit write occurring after a committed domain mutation does not roll back the completed domain mutation.

---

## 7. Security And Redaction

Audit stores only evidence required for accountability.

Never persist:

```text
passwords
temporary passwords
MFA codes
recovery codes
raw tokens
authorization headers
cookies
private keys
secret values
full credential payloads
unrestricted request bodies
```

`AuditEvidenceRedactor` enforces Audit's baseline prohibited-data boundary.

`AuditMetadataData` and `AuditChangeData` accept only explicit safe values rather than arbitrary request/application payloads.

DataProtection later supplies broader classification and semantic redaction policy without replacing Audit ownership.

### Change Sets

Each `AuditChangeData` contains:

```text
field
before
after
redacted
```

Only accountability-relevant changes are recorded.

Sensitive values must be replaced by safe labels, classifications, fingerprints, or redacted markers.

---

## 8. Delivery And Operational Effects

### Audit Administration

Audit owns a read-only administration surface.

Target source:

```text
app/Core/Audit/Http/Controllers/AuditController.php
app/Core/Audit/Http/Requests/AuditSearchRequest.php
app/Core/Audit/routes/web.php

resources/views/core/audit/
```

Route names:

```text
audit.index
audit.show
```

Supported filters include applicable:

```text
event key
result
severity
Principal
subject
target
date/time
correlation ID
Invocation Channel
security-event status
```

Exact Access authorization is reconciled when Core Access is designed.

### Monitoring

Audit does not persist:

* stack traces;
* application exceptions;
* failed-job diagnostics;
* health observations;
* performance telemetry;
* detection state.

Monitoring owns those concerns.

### Events / Jobs / Notifications

The initial Audit implementation does not publish a second Event for every Audit write and does not require a background Job for ordinary recording.

Audit owns no user Notification behavior.

### Registration

`AuditServiceProvider` is declared through Application Registration.

Audit does not register itself directly in root Laravel bootstrap files.

---

## 9. Implementation Manifest

```text
CREATE app/Core/Audit/
    Actions/RecordAuditEventAction.php

    Contracts/RecordAuditEventInterface.php

    Data/RecordAuditEventData.php
    Data/AuditActorData.php
    Data/AuditResourceData.php
    Data/AuditContextData.php
    Data/AuditMetadataData.php
    Data/AuditChangeData.php
    Data/AuditWriteResult.php
    Data/AuditEventSnapshot.php
    Data/AuditSearchCriteria.php

    Enums/AuditResult.php
    Enums/AuditPrincipalType.php

    Models/AuditEvent.php

    Queries/SearchAuditEventsQuery.php
    Queries/GetAuditEventQuery.php

    Redaction/AuditEvidenceRedactor.php

    Providers/AuditServiceProvider.php

    Http/Controllers/AuditController.php
    Http/Requests/AuditSearchRequest.php

    routes/web.php

    __tests__/
```

Presentation:

```text
CREATE resources/views/core/audit/
```

Database:

```text
CREATE database/core/Audit/migrations/
CREATE database/core/Audit/factories/

CREATE docs/06-database/feature-contracts/audit.md
CREATE docs/06-database/tables/audit_events.md
```

No migration, adapter, compatibility alias, or preservation of current Audit implementation is required.

---

## 10. Verification And Completion

Required proof must cover:

* User Account Actor evidence;
* System Actor evidence;
* non-human Principal representation;
* domain-owned Audit event keys;
* supported Audit results;
* Runtime Invocation/correlation capture;
* event-time Actor snapshots;
* subject/target evidence;
* successful Audit only after committed mutation;
* no successful Audit after rollback;
* denial recording;
* prohibited secret handling;
* redacted change sets;
* Audit write failure fallback;
* record immutability;
* chronological/filter/search Queries;
* no direct cross-owner Audit table access;
* no Monitoring/error evidence stored as Audit by default.

### Remaining Blockers

1. **Audit database Contract** — create and accept the canonical `audit_events` table/feature Contracts in `/06-database/`.
2. **Audit severity vocabulary** — the current Audit standard requires severity but does not yet define a controlled Audit severity set.
3. **Audit Logging Standard acceptance** — the current canonical file remains `status: draft`.
4. **Access design** — exact administration authorization Contract.
5. **DataProtection design** — semantic classification/redaction integration.
6. **DataGovernance design** — retention and legal-hold policy.

These dependencies do not require redesigning the Audit recording Contract or persistence ownership.

### Implementation Ready

* [x] Audit ownership is defined.
* [x] Audit/Monitoring separation is defined.
* [x] public recording Contract is defined.
* [x] Actor/resource evidence model is defined.
* [x] Runtime integration is defined.
* [x] greenfield persistence direction is defined.
* [x] transaction timing is defined.
* [x] persistence-failure behavior is defined.
* [x] baseline redaction behavior is defined.
* [x] implementation manifest is defined.
* [x] verification surfaces are defined.
* [ ] canonical Audit database Contracts are accepted.
* [ ] Audit severity vocabulary is accepted.
* [ ] applicable Audit standard is accepted.
* [ ] later Access/DataProtection/DataGovernance dependencies are reconciled.
* [ ] no material design blocker remains.

**Design state: draft; target Audit implementation is defined without legacy compatibility or migration requirements.**

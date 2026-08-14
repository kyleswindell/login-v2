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

Domain owners define which facts are Audit-worthy, their canonical event keys, their Result, and their severity. Audit defines how those facts are safely validated, recorded, and queried.

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
* `docs/08-design/core/security/software-design.md`
* applicable database, security, and identifier standards.

Current Audit implementation is reference evidence only and imposes no preservation or migration requirement.

---

## 3. Component Design

| Component                   | Responsibility                                                      | Target Path                                              |
| --------------------------- | ------------------------------------------------------------------- | -------------------------------------------------------- |
| `RecordAuditEventInterface` | Public cross-owner Audit write Contract                             | `app/Core/Audit/Contracts/RecordAuditEventInterface.php` |
| `RecordAuditEventAction`    | Validate, redact, and persist one Audit Event                       | `app/Core/Audit/Actions/RecordAuditEventAction.php`      |
| `RecordAuditEventData`      | Typed producer input                                                | `app/Core/Audit/Data/RecordAuditEventData.php`           |
| `AuditActorData`            | Event-time Principal/Actor snapshot                                 | `app/Core/Audit/Data/AuditActorData.php`                 |
| `AuditResourceData`         | Subject or target reference                                         | `app/Core/Audit/Data/AuditResourceData.php`              |
| `AuditContextData`          | Safe request/network/execution evidence                             | `app/Core/Audit/Data/AuditContextData.php`               |
| `AuditMetadataData`         | Safe typed supplemental evidence                                    | `app/Core/Audit/Data/AuditMetadataData.php`              |
| `AuditChangeData`           | One redacted field change                                           | `app/Core/Audit/Data/AuditChangeData.php`                |
| `AuditWriteResult`          | Durable/fallback write result                                       | `app/Core/Audit/Data/AuditWriteResult.php`               |
| `AuditEventSnapshot`        | Read-side Audit representation                                      | `app/Core/Audit/Data/AuditEventSnapshot.php`             |
| `AuditSearchCriteria`       | Audit query criteria                                                | `app/Core/Audit/Data/AuditSearchCriteria.php`            |
| `AuditResult`               | Stable outcome values                                               | `app/Core/Audit/Enums/AuditResult.php`                   |
| `AuditSeverity`             | Canonical Audit significance values                                 | `app/Core/Audit/Enums/AuditSeverity.php`                 |
| `AuditPrincipalType`        | Canonical Principal categories                                      | `app/Core/Audit/Enums/AuditPrincipalType.php`            |
| `AuditEvent`                | Append-only persistence Model                                       | `app/Core/Audit/Models/AuditEvent.php`                   |
| `SearchAuditEventsQuery`    | Filtered Audit history                                              | `app/Core/Audit/Queries/SearchAuditEventsQuery.php`      |
| `GetAuditEventQuery`        | Retrieve one Audit Event                                            | `app/Core/Audit/Queries/GetAuditEventQuery.php`          |
| `AuditEvidenceRedactor`     | Apply Audit-specific evidence minimization after Security redaction | `app/Core/Audit/Redaction/AuditEvidenceRedactor.php`     |
| `AuditServiceProvider`      | Audit registration declaration, bindings, and framework integration | `app/Core/Audit/Providers/AuditServiceProvider.php`      |

Do not create a generic Logging abstraction shared with Monitoring.

Audit owns `AuditSeverity` as its provider-local typed representation. It serializes exactly to the shared severity vocabulary but does not require a cross-capability shared PHP enum.

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

Result answers:

> What happened?

Result does not determine event significance.

### Severity

`AuditSeverity`:

```text
informational
low
medium
high
critical
```

Severity answers:

> How significant is this evidence?

Significance increases:

```text
informational
    ↓
low
    ↓
medium
    ↓
high
    ↓
critical
```

Meaning:

* `informational` — routine or expected evidence with ordinary accountability or operational significance;
* `low` — limited security, data, privilege, availability, or operational significance;
* `medium` — material significance with bounded potential or actual impact;
* `high` — serious security, data, privilege, availability, or operational significance with substantial potential or actual impact;
* `critical` — exceptional significance involving or enabling severe compromise, catastrophic data impact, system-wide loss of control, prolonged critical unavailability, or an equivalent emergency condition.

The domain owner that defines the Audit event semantics supplies `AuditSeverity`.

Audit:

* validates the value;
* persists the value;
* exposes it through Audit evidence/query Contracts.

Audit must not infer severity solely from:

* Result;
* event key;
* `is_security_event`;
* HTTP status;
* Monitoring severity;
* framework logging level.

Valid combinations include:

```text
secrets.secret_revealed
result: succeeded
severity: high

auth.login_failed
result: failed
severity: low

security.control_disabled
result: succeeded
severity: critical
```

A successful event may be `high` or `critical`.

A failed or denied event may be `informational` or `low`.

These concerns remain independent:

```text
result
    = outcome

severity
    = significance

is_security_event
    = security classification

alerting
    = operational/security attention decision
```

Audit severity never routes alerts by itself.

Monitoring and Threat Detection own attention and alert-triggering behavior.

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

### Application Registration Declaration

`AuditServiceProvider` implements `RegistrationDescriptorInterface`.

Its static declaration returns `RegistrationDescriptorData` with:

```text
owner_key: audit
ownership_area: core
dependencies:
  - runtime
  - security
registrations:
  - AuditServiceProvider
  - Audit owner routes
  - Audit migration path
  - other explicit Audit-owned framework artifacts defined by this SDD
```

The declaration is static and declarative. It does not execute Audit behavior or query persistence.

The Audit owner route declaration carries canonical Security profile metadata and therefore consumes Core Security's public `RouteSecurityProfile` type. The existing `security` owner dependency covers this route-profile Contract; no additional owner dependency is required.

`bootstrap/registration.php` names:

```text
App\Core\Audit\Providers\AuditServiceProvider
```

as Audit's explicit base-application descriptor source.

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

`severity` persists one `AuditSeverity` serialized value.

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

1. pass fallback context through `RedactSensitiveContextInterface` before emitting a minimal framework-log record;
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

Before `AuditEvidenceRedactor` applies Audit-specific evidence minimization, it consumes Core Security's public `RedactSensitiveContextInterface` using `RedactionScope::log_context`.

```text
typed Audit producer data
    ↓
Core Security RedactSensitiveContextInterface
    scope = log_context
    ↓
credential/request secret values removed
    ↓
AuditEvidenceRedactor
    ↓
Audit-specific allow-listing and safe change handling
    ↓
persistence
```

Core Security owns the request/header/credential-redaction mechanism.

Security/Secrets owns credential-specific redaction-rule definitions.

Audit owns accountable evidence minimization, safe Event shape, and safe metadata/change semantics.

DataProtection later owns semantic personal/business-data classification and masking.

Audit does not maintain a canonical password, token, cookie, or private-key catalog.

It categorically prohibits raw secret persistence and retains `AuditEvidenceRedactor` for its own semantic rules.

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

### Route Security Classification

Audit's administration routes use the canonical Core Security profile:

| Route | Security Profile |
| --- | --- |
| `audit.index` | `administrative` |
| `audit.show` | `administrative` |

The route declarations use:

```text
RouteSecurityProfile::Administrative
```

which serializes to:

```text
administrative
```

The `administrative` baseline requires:

* authenticated human posture;
* action/target/scope authorization;
* explicit administrative authority;
* MFA-level assurance.

The profile does not define Audit's exact permission keys or resource-authorization logic.

Core Access later supplies the exact Audit administration permission and authorization Contracts.

Audit does not add recent-authentication merely because the route is administrative. A later accepted requirement may impose a stronger `sensitive` control on a particular Audit operation when justified.

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

`AuditServiceProvider` is Audit's one owner registration declaration and is declared through Application Registration.

Its explicit owner dependencies are `runtime` and `security` because Audit consumes `InvocationContextInterface`, `RedactSensitiveContextInterface`, and the canonical `RouteSecurityProfile` metadata type used by its route declaration.

Audit does not register itself directly in root Laravel bootstrap files.

---

## 9. Implementation Manifest

| Change | Path                                                     | Archetype                            | Responsibility                                                                  | Dependencies                                | Requirement Source                                              | Verification                                       | Compatibility |
| ------ | -------------------------------------------------------- | ------------------------------------ | ------------------------------------------------------------------------------- | ------------------------------------------- | --------------------------------------------------------------- | -------------------------------------------------- | ------------- |
| CREATE | `app/Core/Audit/Actions/RecordAuditEventAction.php`      | Action                               | Validate, Security-redact, and persist one Audit Event                          | Audit Contract, Runtime, Security redaction | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit redaction integration test                   | None          |
| CREATE | `app/Core/Audit/Contracts/RecordAuditEventInterface.php` | Contract                             | Expose public Audit recording                                                   | Audit Data and result                       | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit recording Contract test                      | None          |
| CREATE | `app/Core/Audit/Data/RecordAuditEventData.php`           | Data Object                          | Receive typed producer evidence including Result and Severity                   | Audit data types                            | `docs/02-standards/logging/Audit Logging Standards.md`          | Audit recording Contract test                      | None          |
| CREATE | `app/Core/Audit/Data/AuditActorData.php`                 | Data Object                          | Snapshot event-time Actor evidence                                              | None                                        | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit evidence test                                | None          |
| CREATE | `app/Core/Audit/Data/AuditResourceData.php`              | Data Object                          | Represent an Audit subject or target                                            | None                                        | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit evidence test                                | None          |
| CREATE | `app/Core/Audit/Data/AuditContextData.php`               | Data Object                          | Hold safe execution evidence                                                    | Security redaction Contract                 | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit redaction integration test                   | None          |
| CREATE | `app/Core/Audit/Data/AuditMetadataData.php`              | Data Object                          | Hold safe typed supplemental evidence                                           | Security redaction Contract                 | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit redaction integration test                   | None          |
| CREATE | `app/Core/Audit/Data/AuditChangeData.php`                | Data Object                          | Hold one safe field change                                                      | Security redaction Contract                 | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit redaction integration test                   | None          |
| CREATE | `app/Core/Audit/Data/AuditWriteResult.php`               | Data Object                          | Report durable or fallback result                                               | None                                        | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit fallback test                                | None          |
| CREATE | `app/Core/Audit/Data/AuditEventSnapshot.php`             | Data Object                          | Expose read-side Audit representation                                           | Audit Event model                           | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit query test                                   | None          |
| CREATE | `app/Core/Audit/Data/AuditSearchCriteria.php`            | Data Object                          | Carry typed Audit query criteria                                                | None                                        | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit query test                                   | None          |
| CREATE | `app/Core/Audit/Enums/AuditResult.php`                   | Enum                                 | Define stable Audit outcomes                                                    | None                                        | `docs/02-standards/logging/Audit Logging Standards.md`          | Audit recording Contract test                      | None          |
| CREATE | `app/Core/Audit/Enums/AuditSeverity.php`                 | Enum                                 | Define provider-local typed representation of the shared severity vocabulary    | None                                        | `docs/02-standards/logging/Logging Standards.md`                | Audit severity Contract test                       | None          |
| CREATE | `app/Core/Audit/Enums/AuditPrincipalType.php`            | Enum                                 | Define canonical Principal categories                                           | None                                        | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit evidence test                                | None          |
| CREATE | `app/Core/Audit/Models/AuditEvent.php`                   | Model                                | Represent append-only Audit persistence                                         | `audit_events` Contract                     | `docs/03-architecture/persistent-data-architecture.md`          | Audit immutability test                            | None          |
| CREATE | `app/Core/Audit/Queries/SearchAuditEventsQuery.php`      | Query                                | Search Audit history                                                            | Audit Event model                           | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit query test                                   | None          |
| CREATE | `app/Core/Audit/Queries/GetAuditEventQuery.php`          | Query                                | Retrieve one Audit Event                                                        | Audit Event model                           | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit query test                                   | None          |
| CREATE | `app/Core/Audit/Redaction/AuditEvidenceRedactor.php`     | Redactor                             | Apply Audit semantic evidence minimization                                      | `RedactSensitiveContextInterface`           | `docs/03-architecture/public-contract-and-interaction-model.md` | Audit redaction integration test                   | None          |
| CREATE | `app/Core/Audit/Providers/AuditServiceProvider.php`      | Provider and Registration Descriptor | Declare Audit registration and bind Audit integration                           | Runtime and Security public Contracts       | `docs/03-architecture/application-registration.md`              | Audit provider registration proof                  | None          |
| CREATE | `app/Core/Audit/Http/Controllers/AuditController.php`    | Controller                           | Deliver read-only Audit administration                                          | Audit queries                               | `docs/03-architecture/repository-architecture.md`               | Audit administration test                          | None          |
| CREATE | `app/Core/Audit/Http/Requests/AuditSearchRequest.php`    | Form Request                         | Validate Audit search input                                                     | None                                        | `docs/03-architecture/repository-architecture.md`               | Audit administration test                          | None          |
| CREATE | `app/Core/Audit/routes/web.php`                          | Route                                | Declare Audit administration routes with the canonical `administrative` Security profile | Audit Controller, `RouteSecurityProfile::Administrative` | `docs/02-standards/security/Zero Trust Security Standards.md` | Audit administration Security-profile test | None          |
| CREATE | `app/Core/Audit/__tests__/`                              | Test family                          | Prove Audit Contracts, severity, redaction, fallback, provider registration, and administration route profiles | Audit owner artifacts | `docs/02-standards/testing/index.md` | Targeted Audit proof | None          |
| CREATE | `resources/views/core/audit/`                            | View family                          | Render Audit administration                                                     | Audit Controller                            | `docs/03-architecture/repository-architecture.md`               | Manual visual review and Audit administration test | None          |
| CREATE | `database/core/Audit/migrations/`                        | Migration family                     | Materialize Audit persistence                                                   | Canonical Audit table Contract              | `docs/03-architecture/persistent-data-architecture.md`          | Database migration proof                           | None          |
| CREATE | `database/core/Audit/factories/`                         | Factory family                       | Supply Audit test data                                                          | Audit Event model                           | `docs/03-architecture/persistent-data-architecture.md`          | Targeted Audit proof                               | None          |
| CREATE | `docs/06-database/feature-contracts/audit.md`            | Database Contract                    | Define Audit persistence behavior                                               | Audit persistence requirements              | `docs/03-architecture/persistent-data-architecture.md`          | Documentation static validation                    | None          |
| CREATE | `docs/06-database/tables/audit_events.md`                | Database Contract                    | Define `audit_events` table                                                     | Audit persistence requirements              | `docs/03-architecture/persistent-data-architecture.md`          | Documentation static validation                    | None          |

---

## 10. Verification And Completion

Required proof must cover:

* User Account Actor evidence;
* System Actor evidence;
* non-human Principal representation;
* domain-owned Audit event keys;
* all supported Audit Results;
* all five `AuditSeverity` values;
* exact serialized severity vocabulary:

  * `informational`
  * `low`
  * `medium`
  * `high`
  * `critical`
* Result and Severity remain independent;
* `is_security_event` and Severity remain independent;
* Audit Severity does not directly route alerts;
* domain producers supply Severity rather than Audit inferring it;
* Runtime Invocation/correlation capture;
* `AuditServiceProvider` fulfills `RegistrationDescriptorInterface` with the `runtime` and `security` owner dependencies;
* event-time Actor snapshots;
* subject/target evidence;
* successful Audit only after committed mutation;
* no successful Audit after rollback;
* denial recording;
* prohibited secret handling;
* Security redaction occurs before Audit evidence minimization and fallback logging;
* redacted change sets;
* Audit write failure fallback;
* record immutability;
* chronological/filter/search Queries;
* no direct cross-owner Audit table access;
* no Monitoring/error evidence stored as Audit by default;
* `audit.index` is classified `administrative`;
* `audit.show` is classified `administrative`;
* Audit routes do not rely on URL location or UI visibility for administrative authority;
* route classification does not replace later Core Access authorization;
* no Audit route creates a noncanonical Security profile.

### Remaining Blockers

1. **Audit database Contract** — create and accept the canonical `audit_events` table/feature Contracts in `/06-database/`.
2. **Audit Logging Standard acceptance** — the current canonical file remains `status: draft`.
3. **Access design** — exact administration authorization Contract.
4. **DataProtection design** — semantic classification/redaction integration.
5. **DataGovernance design** — retention and legal-hold policy.

The Audit severity vocabulary is no longer a blocker. It is defined canonically by Logging Standards and Audit Logging Standards and realized here as `AuditSeverity`.

These remaining dependencies do not require redesigning the Audit recording Contract, severity model, or persistence ownership.

### Implementation Ready

* [x] Audit ownership is defined.
* [x] Audit/Monitoring separation is defined.
* [x] public recording Contract is defined.
* [x] Actor/resource evidence model is defined.
* [x] Audit severity vocabulary and provider-local enum are defined.
* [x] Result, Severity, security classification, and alerting are separated.
* [x] Runtime integration is defined.
* [x] greenfield persistence direction is defined.
* [x] transaction timing is defined.
* [x] persistence-failure behavior is defined.
* [x] baseline redaction behavior is defined.
* [x] implementation manifest is defined.
* [x] verification surfaces are defined.
* [ ] canonical Audit database Contracts are accepted.
* [ ] applicable Audit standard is accepted.
* [ ] later Access/DataProtection/DataGovernance dependencies are reconciled.
* [ ] no material design blocker remains.

**Design state: draft; target Audit implementation, including the accepted severity model, is defined without legacy compatibility or migration requirements.**

<!--
DOC-META
title: Audit And Monitoring Core Planning
doc_type: planning
status: planning
owner: audit-monitoring
canonical: true
canonical_path: docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Plans Core/Audit and Core/Monitoring ownership, preserves the accepted compatibility-first Audit foundation, and defers successor schema choices to bounded M1 work.
-->

# Audit And Monitoring Core Planning

Parent: [Planning Index](../../index.md)

## 1. Purpose

Plan the split between `app/Core/Audit` and `app/Core/Monitoring` before audit logs, service activity, error logs, health checks, and operational telemetry are promoted out of transitional logging/platform placement.

This document owns sequencing and intent only. Final behavior, schema, public Contracts, and runbook operations must be promoted to their owning canonical documents before implementation.

## 2. Accepted Direction

Use four related but separate concepts:

```text
Audit log
  Who or what changed something important?
  Security, compliance, accountability, and history.

Service audit log
  What service, job, integration, command, or background process performed a meaningful action?
  Still Audit evidence; the Actor may be non-human.

Error log
  What broke?
  Exceptions, stack traces, failed rendering, failed jobs, failed API calls.

Operational telemetry
  How did the system perform?
  Duration, retry count, queue latency, sync counts, health checks.
```

Target ownership:

```text
app/Core/Audit
  human and non-human audit evidence
  query/timeline support
  formal forensic-evidence support where required

app/Core/Monitoring
  errors
  failed jobs
  health checks
  operational telemetry
  detection signals and operational/security observations
```

Do not create separate audit-log stores inside each Core capability or business Module.

## 3. Current Baseline

Current implementation includes:

- `platform_audit_logs` for current audit evidence;
- `central_error_logs` for current error evidence;
- `/platform/audit-logs` and `/platform/error-logs` operational surfaces;
- transitional `/console/platform-audit-logs` and `/console/central-error-logs` proof paths.

Current implementation placement does not establish target ownership.

## 4. Ownership Boundaries

### 4.1 Core/Audit Owns

- audit storage boundary;
- Audit logger public Contract;
- user and non-human Actor attribution;
- subject and target attribution;
- change-set representation;
- event category, action, result, severity, reason, and summary structure;
- correlation identifiers;
- audit query/timeline behavior;
- retention/pruning integration requirements;
- audit payload redaction enforcement using applicable DataProtection rules;
- formal evidence-package metadata and chain-of-custody semantics when a future incident workflow requires them.

### 4.2 Core/Monitoring Owns

- exception and error records;
- stack traces and operational failure details;
- failed-job reporting;
- health-check result records;
- operational telemetry;
- error fingerprinting/grouping;
- detection use cases and signal rules;
- detection severity/status/window vocabulary;
- query/correlation support for operational and security observations.

### 4.3 Core/DataProtection Owns

- data classifications;
- sensitive-field metadata;
- masking/redaction policy;
- secure export/download handling rules;
- retention and erasure policy inputs consumed by Audit and Monitoring.

Audit stores evidence that sensitive data was accessed, changed, exported, retained, erased, or masked. DataProtection owns the rule that says why the data/action is sensitive.

### 4.4 Domain Owners Own Event Semantics

Core/Auth, Core/Identity, Core/Access, Core/DataProtection, Core/Settings, Core/Notifications, and business Modules own:

- which domain facts are audit-worthy;
- their event action keys;
- domain-specific subject/resource context;
- reason/metadata only the domain can know;
- when their mutation or operation emits Audit evidence.

They must write through the accepted Audit boundary rather than inventing independent audit infrastructure.

### 4.5 Core/Security And Secrets

Core/Security owns cross-cutting request/security guardrails and release/security-control rules.

Core/Security/Secrets owns secret-specific handling, rotation, reveal/copy/revoke guardrails, redaction inputs, and future vault integration.

Audit records lifecycle/access facts without raw secret values. Monitoring detects applicable expiry, rotation, access, or leak signals without owning secret remediation.

## 5. Audit Actor Model

Audit must support human and non-human Principals and applicable assurance context.

Actor attribution should ultimately preserve canonical Principal/Actor vocabulary rather than treating jobs, commands, webhooks, or schedules as identity types.

Existing transitional labels such as `service`, `system`, `integration`, `job`, or `console` may remain as compatibility evidence until a bounded M1 slice aligns storage/event shape to the canonical Principal, Actor, and Invocation Channel model.

## 6. Audit Event Semantics

Domain event keys remain domain-owned. Examples include:

```text
auth.login_succeeded
auth.login_failed
auth.logout
identity.user_suspended
access.denied
data_protection.export_requested
security.release_blocked
settings.system_updated
notifications.created
customers.updated
inventory.adjusted
```

Do not create a second generic event namespace that hides the owner responsible for the fact.

## 7. Write Pattern

For normal mutations:

```text
Delivery Adapter
  validates input
  invokes authorization
  calls owner-controlled Action/Service

Action/Service
  owns the mutation/transaction
  emits required Audit evidence after successful commit
```

Successful Audit evidence must not be recorded for a mutation that rolls back.

For background work:

```text
Job / Service / Command
  performs work
  records accountable business/security history through Core/Audit
  records unexpected failure/telemetry through Core/Monitoring when applicable
```

An operation may legitimately create both Audit and Monitoring evidence.

## 8. Accepted Initial Audit Storage Direction

M0 decision #6 resolved the first Audit foundation as **compatibility-first**.

Initial Core/Audit work must preserve compatibility with existing `platform_audit_logs` writes rather than introducing a new Audit schema merely to establish the Core/Audit owner boundary.

Candidate future successor surfaces remain:

```text
audit_events
audit_event_changes
```

but they are not accepted current schema Contracts.

Do not rename or replace `platform_audit_logs` until a bounded M1 database-contract/migration slice defines:

- the exact successor schema, if any;
- field and relationship Contracts;
- retention and classification requirements;
- compatibility behavior;
- migration/backfill behavior;
- rollback/stop conditions;
- verification-first proof.

`central_error_logs` likewise remains current compatibility evidence until a bounded Monitoring schema change is accepted.

## 9. Future Audit Data Shape

Any future successor Audit Contract should be able to represent applicable:

- occurrence time;
- category and action;
- result and severity;
- Principal/Actor attribution;
- subject and target;
- service/integration context when applicable;
- Invocation Channel;
- request/trace/session correlation;
- network/request context where permitted;
- reason and summary;
- safe metadata;
- change fields with sensitive-value handling.

This is planning direction, not authorization to create the tables or fields.

## 10. Admin UI Direction

Keep Audit and Monitoring as separate user-facing responsibilities.

```text
Admin
  Audit
    accountability/history/security evidence

  Monitoring
    errors
    failed jobs
    health checks
    operational/security signals
```

Service/non-human activity is a filtered Audit concern, not a separate audit store.

## 11. Implementation Sequence

### 11.1 Architecture Alignment

- preserve Core/Audit and Core/Monitoring as separate accepted owners;
- stop creating new combined generic Logging ownership;
- preserve current compatibility storage until a bounded migration is accepted.

### 11.2 Audit Foundation

- establish `app/Core/Audit` boundary;
- introduce the minimum public Contract/data objects needed by the first bounded producer slice;
- preserve `platform_audit_logs` compatibility;
- protect existing observable behavior with characterization proof.

### 11.3 Monitoring Foundation

- establish `app/Core/Monitoring` boundary;
- move or replace current error/health responsibilities only in bounded slices;
- preserve `central_error_logs` compatibility where required.

### 11.4 Producer Migration

Migrate producers capability by capability only through accepted M1 issues. Planning sequence may consider Auth, Identity, Access, Settings, Notifications, and business Modules, but GitHub Project sequencing owns actual implementation order.

## 12. Verification Direction

Future bounded M1 issues should prove only the behavior materially affected by their slice.

Applicable proof may include:

- user and non-human Actor evidence;
- after-commit Audit behavior;
- no successful Audit row for rolled-back mutations;
- sensitive-value redaction;
- domain-owned event keys;
- Monitoring errors not becoming Audit events by default;
- operations that require both Audit and Monitoring evidence;
- current audit/error route compatibility where in scope.

Exact `AC-*` and `PF-*` mappings belong to the accepted M1 work packet.

## 13. Transition Rules

- do not create `Modules/*/Audit` storage or query systems;
- do not let every feature invent its own audit schema;
- do not write Audit rows directly from delivery adapters when an Action/Service owns the transaction;
- do not record successful Audit evidence before a mutation commits;
- do not store passwords, MFA codes, recovery codes, raw tokens, authorization headers, cookies, private keys, or generated credentials in Audit or Monitoring metadata;
- do not treat every exception as an Audit event;
- do not treat every denied action as an operational error;
- do not merge Audit history and error logs into one owner merely because the current implementation uses Logging terminology;
- do not infer a successor schema from the candidate `audit_events` names.

## 14. Deferred M1 Decisions

The M0 first-foundation decision is resolved: use existing `platform_audit_logs` compatibility first.

The following remain for bounded M1 Audit/Monitoring and database-contract work:

- eventual successor Audit schema and migration/backfill plan, if any;
- whether `platform_audit_logs` is ultimately renamed, replaced, or retained long-term;
- exact future Monitoring schema and field mapping;
- request/trace correlation Contract;
- exact retention Contracts for Audit versus Monitoring;
- exact detection-signal persistence threshold;
- first mandatory producer/event set for each capability;
- exact admin UI implementation sequence.

## 15. Out Of Scope

This planning document does not itself authorize:

- implementing Audit or Monitoring;
- renaming database tables;
- changing existing audit/error routes;
- adding a telemetry pipeline;
- selecting M1 implementation order.

## 16. Related

- [Core Service Build Plan Matrix](../../core-service-build-plan-matrix.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [API, Webhook, And Service Account Security Planning](../auth-identity-access/api-webhook-service-account-security-planning.md)
- [Auth Core Implementation Planning](../auth-identity-access/auth-core-implementation-planning.md)
- [Data Protection Core Planning](../data-governance-protection/data-protection-core-planning.md)

# Audit And Monitoring Core Planning

Status: Planning draft

## Purpose

Plan the split between `app/Core/Audit` and `app/Core/Monitoring` before audit logs, service activity, error logs, health checks, and operational telemetry are promoted out of transitional platform/logging surfaces.

This document owns sequencing and intent only. Final behavior, schema, API contracts, and runbook operations must be promoted to their owning docs before implementation.

## Direction

Use four related but separate concepts:

```text
Audit log
  Who or what changed something important?
  Used for security, compliance, accountability, and history.

Service audit log
  What service, job, integration, console command, or background process performed a meaningful action?
  Still an audit log. Actor may be non-human.

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
  human and service audit events
  forensic evidence and timeline support

app/Core/Monitoring
  errors, exceptions, failed jobs, health checks, and operational telemetry
```

Do not create separate audit-log stores inside each core capability or business module.

## Current Baseline

Current implementation already separates the concepts at least partially:

- `platform_audit_logs` stores app/platform audit events.
- `central_error_logs` stores app error events.
- `/platform/audit-logs` and `/platform/error-logs` exist as app-owned operational surfaces.
- `/console/platform-audit-logs` and `/console/central-error-logs` remain transitional proof paths.
- Feature docs already describe auth/security audit events and central error reporting.

Current gaps:

- Audit and error logging are still described together as "Logging" in several planning/ownership contexts.
- Service audit events are not yet modeled as first-class audit events with service/system/job/integration actors.
- The audit event shape is not yet promoted into `app/Core/Audit`.
- Error logs, failed jobs, health checks, and operational telemetry are not yet planned under `app/Core/Monitoring`.
- Feature/service-specific audit event semantics are not yet declared consistently.

## Ownership Split

### Core/Audit Owns

- audit storage
- audit logger API
- service/security audit logger wrappers
- actor, subject, target, and change-set structure
- retention and pruning intent
- audit payload redaction enforcement, backed by DataProtection classification and redaction rules
- request, trace, session, IP, and user-agent correlation fields
- audit query services
- audit/admin UI data contracts
- consistency rules for audit records
- forensic timeline query support
- evidence package metadata and manifest contracts when formal incident workflow requires them
- chain-of-custody metadata for formal evidence packages and sensitive evidence exports

### Core/DataProtection Owns

- data classifications
- sensitive-field metadata
- masking and redaction standards
- secure export handling rules
- retention and erasure expectations
- sensitivity metadata consumed by Audit and Monitoring

Audit stores evidence that sensitive data was accessed, changed, exported, retained, erased, or masked. DataProtection owns the rule that says the data or action is sensitive.

### Core/Auth, Core/Identity, Core/Access, Core/DataProtection, Core/Settings, Core/Notifications, And Business Modules Own

- which domain events are audit-worthy
- event action keys and labels
- before/after values
- subject/resource context
- reason and metadata that only the domain can know
- when to call the audit logger or dispatch auditable events

### Core/Monitoring Owns

- exception and error records
- stack trace and failure details
- failed job reporting
- health check result records
- operational telemetry such as duration, retry count, queue latency, and sync counts
- error fingerprinting and grouping
- error/health query services
- detection use cases and security signal rules
- detection severity/status/window vocabulary
- detection signal query and correlation support
- response playbook registry metadata when a detection needs a runbook link
- operational monitoring admin UI data contracts

Monitoring may consume DataProtection metadata to decide which audit or operational events should be analyzed as sensitive activity, export spikes, unusual deletes, backup failures, or access-denied spikes. Monitoring should detect the pattern; DataProtection defines why the data/action is sensitive.

Monitoring also supplies operational evidence for forensic reconstruction: central error logs, failed jobs, health checks, backup check failures, release/check failures, detection signals, and anomaly findings. Monitoring should not own chain-of-custody records or formal evidence package semantics.

### Core/Security Owns

- request payload redaction guardrails
- security header and route posture checks
- safe redirect and signed URL helper rules
- security release-check conventions
- security control and detection coverage checks
- vulnerability finding lifecycle, accepted-risk, and release-gate policy helpers

Audit and Monitoring consume redacted/safe request context. Security owns the cross-cutting app guardrail rules; Audit and Monitoring own evidence and operational records.

### Core/Security/Secrets Owns

- secret inventory metadata
- credential-specific redaction patterns
- reveal/copy/rotate/revoke guardrail requirements
- secret expiry and rotation policy inputs
- secret health-check and leak-detection signals
- future vault integration boundary

Audit records secret lifecycle and access events without raw values. Monitoring detects secret expiry, rotation failures, failed vault reads, unexpected reveal patterns, and suspected leaked-secret findings.

### Cybersecurity Review Backlog

Threat Detection and Response direction is tracked in [Threat Detection And Response Planning](threat-detection-response-planning.md) and the [Detection Use Case Matrix](detection-use-case-matrix.md). Audit supplies normalized evidence; Monitoring evaluates detection use cases and signals; Notifications alerts required owners; Auth, Identity, Access, DataProtection, Secrets, and Vulnerability Management execute containment and remediation actions.

Cloud and deployment hardening direction is tracked in [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md). Audit should record deployment approvals, emergency deploys, config changes, and rollback events when app-visible; Monitoring should track deployment readiness failures, backup freshness, TLS expiry, queue/scheduler health, storage exposure, and configuration drift signals when checks exist.

API, webhook, and service-account security direction is tracked in [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md). Audit should support service account, webhook provider, integration, and system actors; Monitoring should detect invalid token spikes, scope violations, webhook signature failures, replay attempts, stale service accounts, and token rotation failures when those surfaces exist.

DLP and exfiltration detection direction is tracked in [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md). Audit should record sensitive data movement evidence; Monitoring should consume DataProtection classifications, DLP decisions, export/download events, and view/access patterns to detect exfiltration-style signals.

Digital forensics readiness is tracked in [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md) and the [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md). Audit should support request/correlation IDs, forensic timeline queries, evidence package metadata, evidence access/export audit events, and chain-of-custody metadata when formal evidence packages exist.

Broader SIEM/SOAR forwarding remains tracked in [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md).

Audit and Monitoring should be designed so future external detection and response tools can consume safe event summaries after event shape, retention, redaction, and access rules are stable.

Threat-modeling and security-control direction is tracked in [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md) and the [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md). Audit and Monitoring should consume those mappings to determine which high-risk controls need audit events, monitoring signals, notifications, and runbook evidence.

Zero Trust direction is tracked in [Zero Trust Security Planning](zero-trust-security-planning.md). Audit should capture sensitive allow/deny/step-up/elevated decisions without raw secrets, while Monitoring should detect repeated denials, failed step-up attempts, export spikes, secret reveal spikes, and abnormal elevated access.

## Audit Actor Model

Audit must support human and non-human actors.

Initial actor types:

```text
user
service
system
integration
job
console
unknown
```

Examples:

```text
Actor: user:42
Action: identity.user_suspended
Subject: user:91

Actor: service:nightly-inventory-reconciler
Action: inventory.totals_recalculated
Subject: part:ABC-123

Actor: system:scheduler
Action: notifications.digest_sent
Subject: user:42

Actor: integration:quickbooks
Action: customers.synced
Subject: customer:3004
```

## Audit Categories And Results

Initial categories:

```text
identity
auth
access
security
settings
notification
service
integration
module
data
```

Initial results:

```text
succeeded
failed
denied
skipped
partial
```

Severity should be reviewed alongside notification severity but does not have to match notification severity exactly. Audit severity represents evidence importance; notification severity represents user attention.

## Event Semantics Ownership

Core capabilities and business modules own their event semantics while writing through Core/Audit.

Examples:

### Core/Auth

```text
auth.login_succeeded
auth.login_failed
auth.logout
auth.password_changed
auth.password_reset_requested
auth.password_reset_completed
auth.mfa_challenge_passed
auth.mfa_challenge_failed
auth.mfa_enabled
auth.mfa_disabled
auth.recovery_codes_regenerated
```

### Core/Identity

```text
identity.user_invited
identity.user_activated
identity.user_profile_updated
identity.user_email_changed
identity.user_suspended
identity.user_deactivated
identity.user_reactivated
identity.sessions_revoked
```

### Core/Access

```text
access.group_created
access.group_updated
access.group_member_added
access.group_member_removed
access.role_created
access.role_updated
access.permission_added_to_role
access.permission_removed_from_role
access.policy_created
access.policy_revoked
access.elevated_session_activated
access.elevated_session_revoked
access.review_completed
access.denied
```

### Core/DataProtection

```text
data_protection.asset_registered
data_protection.classification_changed
data_protection.sensitive_fields_viewed
data_protection.export_requested
data_protection.export_approved
data_protection.export_downloaded
data_protection.export_expired
data_protection.retention_policy_applied
data_protection.erasure_requested
data_protection.erasure_completed
```

### Core/Security

```text
security.vulnerability_found
security.vulnerability_triaged
security.vulnerability_mitigated
security.vulnerability_remediated
security.vulnerability_risk_accepted
security.vulnerability_false_positive_marked
security.release_blocked
security.release_approved
```

### Core/Settings

```text
settings.system_updated
settings.security_policy_updated
settings.access_policy_defaults_updated
settings.notification_defaults_updated
```

### Core/Notifications

```text
notifications.created
notifications.bulk_created
notifications.security_notification_dismissed
notifications.preference_updated
notifications.digest_sent
```

### Business Modules

```text
customers.created
customers.updated
customers.archived

inventory.received
inventory.adjusted
inventory.transferred
inventory.reserved
inventory.totals_recalculated

orders.created
orders.approved
orders.cancelled
orders.closed

shipments.created
shipments.scheduled
shipments.confirmed
shipments.voided
```

## Write Pattern

For normal domain actions:

```text
Controller
  validates request
  authorizes request
  calls Action/Service

Action/Service
  performs transaction
  records audit event after successful commit
```

Use after-commit recording for database mutations so rolled-back changes do not produce successful audit records.

For background services, jobs, scheduled commands, and integrations:

```text
Job/Service/Command
  performs work
  records service audit event through Core/Audit
  records monitoring/error event through Core/Monitoring when the system broke or an exception occurred
```

## Service Audit Vs Error Log Rule

Use this decision rule:

```text
Did the attempt matter for accountability, security, or business history?
  Audit event

Did the system throw, break, timeout, or fail unexpectedly?
  Monitoring/error log

Both can happen for the same operation.
```

Examples:

```text
Login failed due to wrong password
  Audit: auth.login_failed
  Monitoring: no

Access denied to admin users page
  Audit: access.denied
  Monitoring: no

QuickBooks sync timed out
  Audit: integration.quickbooks_sync_failed
  Monitoring: exception/timeout details

Inventory recalculation job crashed
  Audit: service.inventory_recalculation_failed if business-impacting
  Monitoring: stack trace/failure details

Blade view missing
  Audit: usually no
  Monitoring: error log
```

## Data Direction

Canonical schema belongs in future `docs/06-database/` contracts.

Expected Audit data surfaces:

- `audit_events`
- `audit_event_changes`

Expected Audit fields should support:

```text
occurred_at
category
action
result
severity
actor_type
actor_id
actor_name
actor_display
subject_type
subject_id
subject_display
target_type
target_id
target_display
service_name
job_id
queue
command
integration
request_id
trace_id
session_id
ip_address
user_agent
reason
summary
metadata
```

Expected change fields:

```text
audit_event_id
field
old_value
new_value
old_display
new_display
is_sensitive
```

Expected Monitoring data surfaces:

- `central_error_logs` or successor error log table
- `failed_jobs` integration/read model
- `health_check_results`
- future operational telemetry records if needed

Do not rename `platform_audit_logs` or `central_error_logs` until a schema compatibility plan exists.

## Admin UI Direction

Keep Audit and Monitoring as separate admin views:

```text
Admin
  Audit log
    All events
    Security
    Access
    Identity
    Service activity
    Module activity

  Monitoring
    Error logs
    Failed jobs
    Health checks
    System events
```

Service activity is a filtered Audit view:

```text
category = service
OR actor_type IN (service, system, integration, job, console)
```

Error logs remain Monitoring:

```text
central_error_logs
failed_jobs
health_check_results
```

## Implementation Sequence

### 1. Architecture Alignment

- Update architecture docs to split Core/Audit and Core/Monitoring.
- Stop treating "Logging" as a combined owner for audit and error behavior.
- Preserve `platform_audit_logs` and `central_error_logs` compatibility during transition.

### 2. Audit Foundation

- Introduce `app/Core/Audit` namespace and service boundary.
- Add `AuditLogger`, `ServiceAuditLogger`, and `SecurityAuditLogger` wrappers.
- Define actor, subject, target, change-set, category, result, and severity data objects/enums.
- Keep existing audit table writes compatible.

### 3. Monitoring Foundation

- Introduce `app/Core/Monitoring` namespace and service boundary.
- Move error logging, exception capture, failed job reporting, and health check planning under Monitoring.
- Prepare audit/monitoring query shapes needed by the first detection rules.
- Keep existing `central_error_logs` compatibility.

### 4. Threat Detection Readiness

- Add detection key, severity, status, and window vocabulary.
- Add lightweight detection rule registry planning behind Monitoring.
- Keep first detection signals derived from Audit/Monitoring queries unless a triage/reporting need justifies persistence.
- Map first detections to notification type keys and response runbooks.

### 5. Producer Migration

- Migrate Auth audit events first.
- Migrate Identity/Users lifecycle audit events.
- Migrate Access/Roles audit events.
- Migrate Settings and Notifications audit events.
- Migrate business module events as modules are built.

### 6. UI Migration

- Keep current operational routes stable.
- Split admin UI language into Audit and Monitoring.
- Treat `/console/*` proof paths as transitional until explicitly retired.

## Test Planning

Expected tests:

- audit logger records user actor events
- service audit logger records service/system/job/integration actor events
- audit events written after commit do not persist when a transaction rolls back
- sensitive change values are redacted
- DataProtection classification/redaction metadata can mark audit payload fields as sensitive without storing raw values
- domain events keep their domain-owned action keys
- monitoring records exceptions without creating audit records by default
- operations that are both accountable and broken can create both audit and monitoring records
- first detection rules can query audit/monitoring evidence without raw sensitive values
- high/critical detection signals can create required persistent notifications
- detection use cases map to runbooks
- sensitive export, erasure, retention, and masking events can be filtered without mixing them into operational error logs
- service activity filters use audit rows, not a separate service-audit table
- error log views read Monitoring-owned data, not Audit-owned data
- existing audit and error routes remain compatible during migration

## Transition Rules

- Do not create `Modules/*/Audit` storage or query systems.
- Do not let every feature invent its own audit schema.
- Do not write audit rows directly from controllers when an action/service owns the transaction.
- Do not record successful audit events before a mutation transaction commits.
- Do not store secrets, submitted MFA codes, raw passwords, recovery codes, full token values, or provider secret payloads in audit metadata.
- Do not store raw secret values, full authorization headers, full cookies, full private keys, or generated credentials in monitoring/error context.
- Do not treat every exception as an audit event.
- Do not treat every audit failure as an error log.
- Do not merge audit history and error logs into one UI or table.
- Do not treat every failed login or denied action as a security incident.
- Do not make Monitoring execute Auth, Identity, Access, DataProtection, Secrets, or Vulnerability remediation directly.

## Open Decisions

- Should the first compatibility implementation write to existing `platform_audit_logs` or introduce `audit_events` with a migration/backfill plan?
- Should `platform_audit_logs` be renamed, replaced, or retained as a compatibility table?
- Which existing error log fields should move into a future Monitoring schema?
- Which audit categories are mandatory before Access Control implementation begins?
- Which security/access notification dismissal events require audit?
- Should `request_id` and `trace_id` be unified before Audit/Monitoring promotion?
- What retention rules apply to audit events versus error logs?
- Which DataProtection classifications should force audit redaction, long retention, or sensitive activity monitoring?
- Which vulnerability-management findings and release-gate decisions are audit-worthy on day one?
- Which secret lifecycle events must be audited first: reveal, copy, rotate, revoke, access denied, expiry, or risk accepted?
- Should first detection signals be derived from Audit/Monitoring queries or persisted in `detection_signals`?
- Which detection rules are mandatory before a security operations UI exists?

## Out Of Scope

- implementing Audit or Monitoring in this pass
- renaming database tables in this pass
- changing existing audit/error routes in this pass
- adding a full telemetry pipeline in this pass
- editing `/docs/08-active/`

## Related

- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md)
- [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Backup And Recovery Planning](backup-recovery-planning.md)
- [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md)
- [Event And Error Logging](../04-features/logging/event-and-error-logging.md)
- [platform_audit_logs](../06-database/tables/platform_audit_logs.md)
- [central_error_logs](../06-database/tables/central_error_logs.md)

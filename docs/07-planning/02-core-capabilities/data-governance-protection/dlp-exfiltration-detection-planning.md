# DLP And Exfiltration Detection Planning

Status: Planning

## Purpose

Plan data loss prevention and exfiltration detection as a data lifecycle control layer across DataProtection, Access, Security, Audit, Monitoring, Notifications, Incident Response, and business modules.

This document owns implementation sequencing and intent only. Final standards, feature behavior, schema contracts, runbooks, route contracts, and release commands must be promoted into their owning docs before implementation.

## Direction

DLP is not a business module and should not be implemented as `Modules/Dlp`, `Modules/DataLossPrevention`, or `Modules/Exfiltration`.

DLP should answer this control question:

```text
Every movement of confidential or restricted data must be classified, authorized, minimized, protected, audited, monitored, and revocable.
```

Use the existing Core ownership model:

| Owner | Responsibility |
| --- | --- |
| `app/Core/DataProtection` | Data classification, sensitive fields, redaction/masking, secure exports, retention, erasure, DLP policy, data movement decisions, and export/download data-risk rules. |
| `app/Core/DataProtection/Dlp` | Optional later DLP subcapability for data movement evaluation, DLP policy decisions, export risk evaluation, sensitive volume estimates, and DLP violation metadata. |
| `app/Core/Access` | Who may view, export, download, approve, or administer sensitive data by scope. |
| `app/Core/Security` | Private storage, signed URLs, upload/download guardrails, request redaction, safe response handling, and release checks. |
| `app/Core/Audit` | Evidence of sensitive access, export, download, approval, denial, revocation, and policy violation. |
| `app/Core/Monitoring` | Exfiltration signals, volume thresholds, anomaly windows, and DLP detection findings. |
| `app/Core/Monitoring/ThreatDetection/DataExfiltration` | Optional later detection subcapability for export spikes, download spikes, sensitive view spikes, response thresholds, session thresholds, and cross-scope attempts. |
| `app/Core/Notifications` | Security/data-owner alerts for restricted movement, export spikes, exfiltration thresholds, and public exposure. |
| Incident Response planning and `docs/10-runbooks` | Suspected data exposure and suspected data exfiltration response procedures. |
| `Modules/*` | Sensitive fields, exports, downloadable/generated files, outbound payloads, and module-specific DLP tests. |

Monitoring must not own DLP policy. It should consume DataProtection classification, Audit events, Access denials, and Security download/export events.

## DLP Lifecycle

Use this lifecycle:

```text
Identify and classify data
  -> Monitor handling
  -> Apply protections
  -> Document and report
```

For Login 2.0:

| DLP Step | App Implementation |
| --- | --- |
| Identify/classify data | DataProtection data asset registry and sensitive field metadata. |
| Monitor handling | Audit events plus Monitoring DLP/exfiltration signals. |
| Apply protections | Access permissions, Auth recent/MFA, Security signed URLs/private storage, and DataProtection DLP policy. |
| Document/report | DataProtection admin later, Audit evidence, Monitoring signals, and runbooks. |

## Data States

### Data In Use

Examples:

- user views customer/contact records
- user views order/shipment/inventory records
- user opens audit details
- user views generated report preview
- user accesses notification payload/action
- admin views user/security/access details

Controls:

- object-level authorization
- field-level redaction
- recent authentication for restricted data
- selective sensitive-view audit
- high-volume view monitoring

### Data In Motion

Examples:

- CSV, PDF, or other export download
- API response
- webhook delivery
- email notification
- realtime notification
- signed temporary download URL

Controls:

- separate view/export permissions
- private storage
- signed expiring links
- API/service account scopes
- outbound payload classification
- download/access audit
- rate limits and volume thresholds

### Data At Rest

Examples:

- database tables
- private generated exports
- uploaded files
- backups
- logs
- audit rows
- notification payloads

Controls:

- data classification
- encryption/hashing where appropriate
- private storage
- retention/expiration
- audit/log redaction
- backup protection

## Target Structure

Optional later DataProtection DLP structure:

```text
app/Core/DataProtection/Dlp/
  Actions/
  Data/
  Enums/
  Models/
  Queries/
  Services/
  Support/
```

MVP classes when implementation begins:

- `DataMovementContext`
- `DataMovementDecision`
- `DlpPolicyEngine`
- `ExportRiskEvaluator`
- `SensitiveDataVolumeEstimator`

Likely later classes:

- `EvaluateDataMovement`
- `ApproveRestrictedDataExport`
- `BlockDataMovement`
- `RecordDlpPolicyViolation`
- `ExpireSensitiveExport`
- `DlpPolicyDefinition`
- `DlpThreshold`
- `DlpViolationData`
- `DataMovementType`
- `DlpDecision`
- `DlpPolicySeverity`
- `ExfiltrationSignalType`

Optional later Monitoring structure:

```text
app/Core/Monitoring/ThreatDetection/DataExfiltration/
  Data/
  Enums/
  Queries/
  Services/
  Support/
```

Likely later detection classes:

- `ExfiltrationDetectionService`
- `SensitiveExportSpikeRule`
- `SensitiveDownloadSpikeRule`
- `SensitiveRecordViewSpikeRule`
- `CrossScopeAccessAttemptRule`
- `RestrictedDataMovementRule`

## Data Movement Types

Use a common movement vocabulary:

```text
view
export
download
api_response
webhook_payload
email_notification
realtime_notification
file_upload
file_share
backup
```

This should become an enum when implementation begins.

## Data Movement Decision Model

Every confidential or restricted movement should be evaluated with a context that includes:

- movement type
- actor type
- actor ID
- resource type
- resource ID
- classification
- scope key
- record count
- sensitive field count
- whether restricted data is included
- reason when required

Example decisions:

- `allow`
- `allow_and_audit`
- `require_reason`
- `require_recent_auth`
- `require_approval`
- `block`
- `block_and_alert`

Decision output should include:

- allowed
- decision key
- severity
- required controls
- audit events
- monitoring signals
- user-safe message when needed

## Policy Examples

### View Vs Export Separation

Threat:

```text
User with customer.view exports all customer data.
```

Control:

```text
customers.view does not imply customers.export.
```

Policy:

```text
Any export of Confidential or Restricted data requires explicit export permission.
```

Detection:

- `data.export_denied`
- `data.export_requested`

### Restricted Export Approval

Threat:

```text
Privileged user exports restricted user/access/security data.
```

Control:

```text
Restricted exports require recent auth, reason, approval, private storage, signed URL, and audit.
```

Detection:

- `restricted_export_requested`
- `restricted_export_downloaded`

### Session Data Exfiltration

Threat:

```text
User views/downloads abnormal sensitive data volume in one session.
```

Control:

```text
Thresholds by classification and movement type.
```

Detection:

- `session_sensitive_data_threshold_exceeded`

### Response Data Exfiltration

Threat:

```text
Single response contains too many sensitive records or fields.
```

Control:

```text
Limit API/export response size by classification.
```

Detection:

- `response_sensitive_data_threshold_exceeded`

## Suggested Thresholds

Start simple and configurable. Do not hard-code these permanently.

Confidential data:

- more than 100 records viewed in 15 minutes creates a medium signal
- more than 500 records viewed in 60 minutes creates a high signal
- more than 1 export in 30 minutes creates a medium signal
- more than 3 exports in 24 hours creates a high signal

Restricted data:

- any export creates a high signal
- any failed export attempt creates a medium signal
- any download outside expected scope creates a high signal
- any bulk access creates a critical signal

Cross-scope attempts:

- one denied cross-scope export creates a high signal
- five denied sensitive access attempts in ten minutes creates a high signal

Defaults can live in Core/Settings or DLP policy definitions later.

## Audit Events

Audit event candidates:

- `data.viewed_sensitive`
- `data.export_requested`
- `data.export_approved`
- `data.export_denied`
- `data.export_created`
- `data.export_downloaded`
- `data.export_expired`
- `data.export_revoked`
- `data.download_denied`
- `data.api_response_blocked`
- `data.webhook_payload_blocked`
- `data.notification_redacted`
- `data.dlp_policy_violation`
- `data.exfiltration_signal_created`

Audit event metadata should include:

- actor
- session ID
- route
- resource type
- resource ID
- classification
- record count
- sensitive field count
- movement type
- scope key
- decision
- reason
- export/download ID where applicable

Do not store raw sensitive data in audit metadata.

## Monitoring Signals

Detection IDs:

- `DET-DLP-001` confidential export created
- `DET-DLP-002` restricted export requested
- `DET-DLP-003` sensitive export spike
- `DET-DLP-004` sensitive download spike
- `DET-DLP-005` sensitive record view spike
- `DET-DLP-006` response exfiltration threshold exceeded
- `DET-DLP-007` session exfiltration threshold exceeded
- `DET-DLP-008` cross-scope sensitive access attempt
- `DET-DLP-009` expired export link attempted
- `DET-DLP-010` public/private storage exposure detected
- `DET-DLP-011` notification payload redacted due to sensitivity
- `DET-DLP-012` API response blocked due to data volume

Severity guide:

| Severity | Examples |
| --- | --- |
| Info | Normal confidential export with approval. |
| Medium | Denied sensitive export, expired signed link attempt. |
| High | Restricted export requested, export spike, cross-scope data access attempt. |
| Critical | Public exposure of private export, confirmed restricted data exfiltration, suspicious restricted export plus unusual auth/session pattern. |

## Notifications

Durable notification type candidates:

- `security.dlp.restricted_export_requested`
- `security.dlp.export_spike_detected`
- `security.dlp.exfiltration_threshold_exceeded`
- `security.dlp.public_storage_exposure`
- `security.dlp.cross_scope_access_attempt`
- `security.dlp.expired_export_link_attempt`
- `security.dlp.response_blocked`

Recipients:

- security owners
- data owner
- access owner
- system admin
- requesting user for selected self-service warnings

DLP notifications are security/system notifications and should not be fully user-disableable.

## Export And Download Hardening

Export creation flow:

```text
User requests export
  -> FormRequest validates filters/scope/reason
  -> Access checks export permission
  -> DataProtection classifies requested fields/data
  -> DLP policy evaluates movement risk
  -> recent auth required if restricted/high-risk
  -> approval required if configured
  -> export generated to private storage
  -> audit data.export_created
  -> monitoring evaluates export volume/frequency
  -> notification sent if high-risk
```

Export download flow:

```text
User opens signed link
  -> signature/expiry check
  -> user still authenticated
  -> Access re-checks download permission
  -> DLP re-checks export status
  -> block if revoked/expired
  -> audit download
  -> update monitoring window
```

Never allow:

- public export URLs
- permanent export links
- downloads without reauthorization
- export IDs guessable by URL
- view permission automatically enabling export

## API And Webhook DLP

API response flow:

```text
API response
  -> classify response data
  -> enforce service-account scope
  -> cap max records
  -> audit restricted responses
  -> detect unusual response volume
```

Outbound webhook flow:

```text
Webhook outbound payload
  -> classify payload
  -> send minimum required fields
  -> redact restricted fields
  -> sign payload
  -> audit delivery
  -> retain safely
```

Rules:

- no restricted fields in webhook payloads unless explicitly allowed
- service account export permissions are separate from read permissions
- response size thresholds are classification-aware
- API pagination is required for list endpoints
- bulk endpoints require explicit permission and rate limits

## Notification DLP

Notification rules:

- notification title/body should avoid restricted data
- action links reauthorize on click
- notification payload should store IDs and safe summaries, not sensitive full records
- realtime notification payloads should be minimal
- email notifications should be stricter than in-app notifications

Prefer:

```text
A customer record requires review.
```

Do not embed full restricted facts in notification bodies.

## Storage DLP

Storage rules:

- generated exports go to private disk
- export files expire automatically
- export files can be revoked
- sensitive uploads are never directly web-served
- backups are outside public web root
- logs are not web-accessible
- DLP evidence/reports are stored privately

Detection candidates:

- `storage.private_file_publicly_accessible`
- `export_file_on_public_disk`
- `backup_file_publicly_accessible`
- `sensitive_upload_public`

## Admin UI Later

Do not build DLP UI first. Later, under Admin > Data protection:

```text
Data protection
  DLP overview
  Sensitive data movements
  Exfiltration signals
  Export approvals
  Export history
  DLP policy settings
```

Only add UI after audit, enforcement, and monitoring signals exist.

## Implementation Sequence

### 1. Planning And Standards

- Add this planning source.
- Promote DLP rules into standards/runbook targets.
- Keep DLP under DataProtection, not a module.
- Keep exfiltration detection under Monitoring, not DataProtection policy.

### 2. DataProtection Baseline

- Define data classifications.
- Define sensitive fields.
- Define view/export separation.
- Define private signed export expectations.
- Define restricted export reason/approval requirements.

### 3. DLP Data Movement Baseline

- Add data movement vocabulary.
- Add `DataMovementContext`.
- Add `DataMovementDecision`.
- Add `DlpPolicyEngine`.
- Add export risk evaluator.
- Add sensitive volume estimator.

### 4. Audit And Monitoring Baseline

- Add export/download audit event semantics.
- Add DLP policy violation audit events.
- Add export/download/view threshold detection targets.
- Add exfiltration signal notification targets.

### 5. Exfiltration Detection Baseline

- Add export spike rule.
- Add sensitive download spike rule.
- Add sensitive record view spike rule.
- Add session threshold rule.
- Add response threshold rule.
- Add cross-scope attempt rule.

### 6. Business Module Template

- Add sensitive fields declaration.
- Add data movement declaration.
- Add export/download abuse tests.
- Add DLP-specific security tests.

## Standards And Runbooks To Add Later

Standards candidates:

- `docs/02-standards/security/data-loss-prevention.md`
- `docs/02-standards/security/data-protection.md`
- `docs/02-standards/security/monitoring-and-alerting.md`
- `docs/02-standards/security/incident-response.md`

Runbook candidates:

- `docs/10-runbooks/suspected-data-exfiltration.md`
- `docs/10-runbooks/suspected-data-exposure.md`
- `docs/10-runbooks/security-release-checklist.md`

## Test Planning

Expected first tests:

- view does not imply export
- restricted export requires recent auth
- restricted export requires reason
- restricted export requires approval when configured
- export writes private signed download
- download reauthorizes access
- expired/revoked export cannot be downloaded
- export request/download writes audit events
- session threshold creates monitoring signal
- response threshold creates monitoring signal
- export spike creates monitoring signal
- cross-scope sensitive access creates monitoring signal
- notification payload redacts restricted data
- API response blocked when restricted data volume exceeds policy

## Transition Rules

- Do not create `Modules/Dlp`, `Modules/DataLossPrevention`, or `Modules/Exfiltration`.
- Do not build a full enterprise DLP product.
- Do not build network packet inspection in Laravel.
- Do not build endpoint DLP.
- Do not build AI/ML exfiltration scoring for MVP.
- Do not build dashboards before enforcement and signals exist.
- Do not create DLP policies that only document risk without block/audit/alert behavior.
- Do not let ordinary view permissions imply export permission.
- Do not store generated exports in public storage.
- Do not store raw sensitive data in audit, monitoring, notification, or DLP evidence metadata.

## Open Decisions

- Which DLP baseline comes first: export/download enforcement, data movement vocabulary, audit events, or monitoring signals?
- Which classifications require restricted export approval?
- Which data movement thresholds become configurable settings first?
- Should DLP policies remain code/config definitions first or project to `dlp_policies` later?
- Should sensitive data movements be persisted immediately or derived from Audit queries first?
- What is the first business module that needs DLP export rules?
- Which DLP notification types become persistent first?

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md)
- [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)

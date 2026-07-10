# Digital Forensics Readiness Planning

Status: Planning

## Purpose

Plan digital forensics readiness as the application-level evidence and reconstruction capability across Audit, Monitoring, Security, DataProtection, Access, Notifications, Incident Response, deployment evidence, and business modules.

This document owns implementation sequencing and intent only. Final standards, feature behavior, schema contracts, runbooks, route contracts, and operational procedures must be promoted into their owning docs before implementation.

## Direction

Digital forensics readiness is not a business module and should not be implemented as `Modules/Forensics`, `Modules/DigitalForensics`, or a forensic analysis product inside Laravel.

For Login 2.0, forensic readiness means:

```text
Every security-sensitive action should leave enough tamper-resistant, redacted, correlated evidence to reconstruct what happened without destroying or altering the evidence during response.
```

The practical scope is application-level evidence readiness:

- reconstruct actor, session, request, target, and change timelines
- preserve audit, monitoring, error, data movement, deployment, and security evidence
- record evidence access and export
- support chain-of-custody metadata for formal evidence packages
- keep raw secrets and unnecessary sensitive values out of evidence
- guide incident responders so containment does not destroy the record

Do not attempt to build packet capture, endpoint acquisition, memory forensics, mobile forensics, legal case management, or a raw server log collector in the Laravel app.

## Ownership

| Owner | Responsibility |
| --- | --- |
| `app/Core/Audit` | Audit event evidence, forensic timeline queries, evidence package metadata, chain-of-custody records, evidence export contracts, audit/evidence UI data contracts. |
| `app/Core/Audit/Forensics` | Optional later subcapability for timeline builders, evidence package DTOs, evidence hashing, evidence manifests, chain-of-custody services, and formal evidence exports. |
| `app/Core/Monitoring` | Operational evidence sources: central error logs, failed jobs, health checks, anomaly findings, detection signals, and incident candidate records. |
| `app/Core/Security` | Request correlation, safe evidence access rules, redaction guardrails, private evidence storage checks, and signed evidence download guardrails. |
| `app/Core/DataProtection` | Evidence classification, redaction/masking rules, retention, legal-hold policy inputs, and sensitive evidence handling. |
| `app/Core/Access` | `forensics.*` permissions, evidence access controls, recent-auth/elevated access requirements, and object/scope checks. |
| `app/Core/Notifications` | Persistent alerts when high-risk evidence packages are created, sealed, exported, downloaded, or accessed. |
| Incident Response planning and `docs/10-runbooks` | Evidence collection, preservation, chain of custody, containment without evidence destruction, timeline reconstruction, and post-incident reporting procedures. |
| Business modules | Domain-specific audit events, generated files, export/download records, background jobs, notification IDs, and reconstruction context. |

Core/Audit is the primary owner because forensic readiness is mostly about evidence integrity, timeline reconstruction, chain-of-custody metadata, and investigation exports. Monitoring supplies operational evidence. Incident Response owns the human procedure.

## Core Questions

Forensic readiness should answer:

```text
Who did it?
What did they do?
What object/data was affected?
When did it happen?
Where did the request come from?
How was access granted or denied?
What changed?
What evidence supports that conclusion?
Was the evidence preserved without alteration?
Who accessed or exported the evidence?
```

## Target Structure

Do not start with UI or database tables unless a real investigation workflow requires them.

Optional later Audit forensics structure:

```text
app/Core/Audit/Forensics/
  Actions/
    CreateEvidencePackage.php
    AddEvidenceItem.php
    SealEvidencePackage.php
    ExportEvidencePackage.php
    RecordEvidenceAccess.php
    PlaceEvidenceLegalHold.php
    ReleaseEvidenceLegalHold.php
  Data/
    EvidencePackageData.php
    EvidenceItemData.php
    EvidenceHash.php
    EvidenceTimelineItem.php
    ChainOfCustodyEntryData.php
    InvestigationScope.php
  Enums/
    EvidencePackageStatus.php
    EvidenceItemType.php
    EvidenceClassification.php
    EvidenceAccessReason.php
    InvestigationType.php
  Events/
    EvidencePackageCreated.php
    EvidenceItemAdded.php
    EvidencePackageSealed.php
    EvidencePackageExported.php
    EvidenceAccessed.php
    EvidenceLegalHoldPlaced.php
  Models/
    EvidencePackage.php
    EvidenceItem.php
    EvidenceChainOfCustodyEntry.php
    EvidenceExport.php
  Policies/
    EvidencePackagePolicy.php
    EvidenceItemPolicy.php
  Queries/
    SecurityTimelineQuery.php
    ActorActivityTimelineQuery.php
    SubjectEvidenceQuery.php
    DataExportEvidenceQuery.php
    AccessPolicyHistoryEvidenceQuery.php
  Services/
    EvidencePackageService.php
    EvidenceHashingService.php
    ChainOfCustodyService.php
    ForensicTimelineBuilder.php
    EvidenceRedactionService.php
    EvidenceRetentionService.php
  Support/
    EvidencePackageKey.php
    EvidenceFileName.php
    EvidenceManifestBuilder.php
  Routes/
    admin-forensics.php
```

MVP support classes:

- `EvidenceHashingService`
- `ForensicTimelineBuilder`
- `EvidencePackageData`
- `EvidenceItemData`
- `ChainOfCustodyEntryData`
- `EvidenceManifestBuilder`

## Evidence Source Matrix

Detailed evidence source planning is tracked in [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md).

The source matrix should document:

- app evidence sources
- external/server evidence sources
- required correlation fields
- retention expectations
- export method
- redaction expectations
- owning capability
- first test coverage

## Normalized Forensic Event Shape

Audit and monitoring events should support forensic reconstruction.

Minimum fields:

```text
id
occurred_at_utc
event_key
category
result
severity

actor_type
actor_id
actor_display
actor_session_id
actor_ip
actor_user_agent

subject_type
subject_id
subject_display

target_type
target_id
target_display

route_name
http_method
url_path
request_id
correlation_id

source_component
environment
service_name
job_id

authorization_result
permission_key
access_policy_id
role_id
scope_key

data_classification
data_movement_type
record_count

change_set
metadata_redacted
created_at
```

Principles:

- use UTC timestamps
- use immutable event IDs
- include request and correlation IDs
- include actor, session, IP, and user agent where available
- include subject, target, and resource context
- store safe before/after changes when needed
- redact secrets and sensitive values
- record denied events, not only successful events

## Request Correlation

Add request correlation early, before evidence reconstruction depends on it.

Candidate middleware:

```text
app/Core/Security/Http/Middleware/AttachRequestCorrelationId.php
```

Every request should have:

```text
request_id
correlation_id
session_id
actor_id when authenticated
```

Use correlation IDs in:

- audit events
- monitoring errors
- central error logs
- notifications
- export/download events
- failed jobs triggered from a request

This makes timeline reconstruction possible without guessing.

## Chain Of Custody

Chain-of-custody tracking should be added only for formal evidence packages and sensitive evidence exports.

Candidate tables:

### `evidence_packages`

```text
id
case_key
title
description
investigation_type
status
classification
created_by
sealed_by
sealed_at
legal_hold_at
legal_hold_by
created_at
updated_at
```

### `evidence_items`

```text
id
evidence_package_id
item_type
source_type
source_id
source_table
source_event_id
file_disk
file_path
hash_sha256
size_bytes
captured_at
captured_by
classification
redaction_applied
created_at
updated_at
```

### `evidence_chain_of_custody_entries`

```text
id
evidence_package_id
evidence_item_id nullable
actor_id
action
reason
from_location
to_location
hash_before
hash_after
occurred_at
metadata
created_at
```

Chain-of-custody actions:

```text
created
item_added
viewed
exported
downloaded
sealed
legal_hold_placed
legal_hold_released
redacted_copy_created
transferred
destroyed_after_retention
```

Do not make chain-of-custody entries editable.

## Evidence Package Manifest

When exporting an evidence package, include a manifest:

```text
manifest.json
README.md
audit-events.jsonl
monitoring-events.jsonl
error-logs.jsonl
timeline.csv
evidence-items/
hashes.sha256
chain-of-custody.jsonl
redaction-report.json
```

Manifest fields:

```text
package_id
case_key
created_at
created_by
sealed_at
classification
scope
time_range
included_sources
item_count
hash_algorithm
hashes
redaction_rules_applied
chain_of_custody_entries
```

Generated evidence packages must use private storage only.

## Evidence Classification And Redaction

Evidence classifications:

```text
internal
confidential
restricted
legal_hold
```

Rules:

- evidence packages are private by default
- exports require `forensics.export_package`
- restricted evidence requires recent authentication
- raw secrets are never included
- tokens and session IDs are redacted, hashed, or fingerprinted
- PII is redacted unless required for the investigation scope
- redacted copies should preserve the hash of the original item separately

Always exclude or redact:

- passwords
- MFA codes
- TOTP secrets
- recovery codes
- password reset tokens
- invitation tokens
- session cookie values
- remember tokens
- API tokens
- Authorization headers
- webhook secrets
- private keys
- full export contents unless explicitly in scope

## Forensic Timeline Builder

Candidate service:

```text
app/Core/Audit/Forensics/Services/ForensicTimelineBuilder.php
```

Inputs:

```text
actor_id
subject_id
target_id
session_id
request_id
correlation_id
time range
event categories
data classification
```

Timeline row:

```text
timestamp
source
event_key
actor
subject
target
result
route/job
ip
session/request
summary
evidence_link
```

Use timeline reconstruction for:

- account compromise
- privileged access incident
- suspected data exposure
- suspected data exfiltration
- secret leak
- service account token compromise
- deployment or supply-chain incident

## Incident Evidence Preservation Flow

Use this app-level flow:

```text
Detection signal or incident report
  -> Create investigation/evidence package
  -> Freeze relevant logs/time window
  -> Add actor/session/resource timeline
  -> Preserve key audit/monitoring/error records
  -> Preserve related files/export metadata
  -> Apply legal hold if needed
  -> Continue containment actions
  -> Record every evidence access/export
  -> Generate post-incident report
```

Containment actions should not erase evidence prematurely.

Examples:

- Before deleting an export file, record metadata, hash, requester/downloader, optional legal-hold copy, then revoke public or signed access.
- Before revoking a token, record token prefix/fingerprint, owner/service account, last-used metadata, revocation reason, then revoke it.
- Before suspending a user, record session IDs, recent auth/access events, current group/policy state, then revoke sessions and suspend.

## Legal Hold And Retention

Retention categories:

```text
normal audit retention
security incident evidence retention
legal hold retention
expired package destruction
```

Rules:

- legal hold overrides normal pruning
- evidence package exports are audited
- evidence deletion/destruction requires permission and audit
- expired evidence deletion records a chain-of-custody entry

Potential settings:

```text
forensics.default_retention_days
forensics.security_incident_retention_days
forensics.legal_hold_enabled
forensics.evidence_export_expiry_hours
```

## Permissions

Candidate canonical permissions:

```text
forensics.view
forensics.create_package
forensics.add_evidence
forensics.seal_package
forensics.export_package
forensics.download_export
forensics.place_legal_hold
forensics.release_legal_hold
forensics.delete_expired
forensics.audit
```

High-risk permissions:

```text
forensics.export_package
forensics.place_legal_hold
forensics.release_legal_hold
```

High-risk actions should require:

```text
auth
identity.active
auth.mfa
auth.recent
forensics.* permission
audit event
```

## Notifications

Future notification type examples:

```text
security.forensics.evidence_package_created
security.forensics.evidence_package_sealed
security.forensics.evidence_package_exported
security.forensics.evidence_accessed
security.forensics.legal_hold_placed
security.forensics.legal_hold_released
```

Do not notify for every ordinary audit query. Notify when high-risk evidence packages are created, exported, downloaded, accessed unexpectedly, sealed, or placed under legal hold.

## Admin UI Later

Do not build this first.

Potential later surface:

```text
Admin
  Security / Audit
    Forensic timelines
    Evidence packages
    Chain of custody
    Evidence exports
    Legal holds
```

Timeline filters:

- actor
- subject
- target
- session
- request ID
- event category
- time range
- classification
- result

Evidence package tabs:

- Overview
- Timeline
- Evidence items
- Chain of custody
- Exports
- Access log

Only build these after audit/monitoring evidence, retention rules, private exports, and access controls exist.

## Implementation Sequence

### 1. Docs And Standards Promotion

- Create `docs/02-standards/security/digital-forensics-readiness.md`.
- Create `docs/02-standards/security/evidence-handling.md`.
- Create `docs/02-standards/security/audit-evidence-model.md`.
- Create `docs/10-runbooks/forensic-evidence-collection.md`.
- Create `docs/10-runbooks/incident-evidence-preservation.md`.
- Create `docs/10-runbooks/security-timeline-reconstruction.md`.
- Create `docs/10-runbooks/chain-of-custody.md`.
- Create `docs/10-runbooks/log-export-for-investigation.md`.

### 2. Evidence Field Baseline

Ensure Audit/Monitoring events can carry:

- request ID
- correlation ID
- session ID
- actor IP
- user agent
- route/job/source
- UTC timestamp
- actor/subject/target
- result
- redacted metadata

### 3. Timeline Query Baseline

Build:

- `ForensicTimelineBuilder`
- `ActorActivityTimelineQuery`
- `SubjectEvidenceQuery`
- data export evidence query support
- access policy history evidence query support

### 4. Evidence Package MVP

Build:

- `EvidencePackageData`
- `EvidenceItemData`
- `EvidenceHashingService`
- `EvidenceManifestBuilder`
- private evidence export

### 5. Formal Chain Of Custody

Only after actual incident workflow requires it, add:

- `evidence_packages`
- `evidence_items`
- `evidence_chain_of_custody_entries`
- `evidence_exports`

## Business Module Template Direction

Every business module should eventually declare forensic evidence sources.

Potential template doc:

```text
Modules/_Template/docs/forensics.md
```

Template sections:

```text
Audit events
Sensitive data movement events
Export/download records
Files generated or uploaded
Notifications emitted
Service/background jobs
Evidence needed for incident reconstruction
```

Example future Orders evidence:

- `order.created`
- `order.updated`
- `order.approved`
- `order.cancelled`
- `order.exported`
- order approval actor/session/IP
- before/after status changes
- notification IDs for approval requests
- related access decisions

## Test Planning

Future implementation tests should prove:

- request correlation IDs flow into audit, monitoring, notifications, and jobs
- timeline reconstruction can filter by actor, subject, target, session, request, and time range
- evidence packages produce stable manifests and hashes
- evidence exports use private storage
- chain-of-custody entries are append-only
- evidence access and export are audited
- legal hold prevents pruning/destruction
- raw secrets are excluded from evidence exports
- redacted evidence copies record the redaction rules applied
- high-risk forensics actions require permissions, MFA, and recent auth where configured

## Transition Rules

- Do not create `Modules/Forensics`, `Modules/DigitalForensics`, or `Modules/DFIR`.
- Do not build forensic dashboards before audit/monitoring evidence, retention, access controls, and runbooks exist.
- Do not collect packet captures, memory images, endpoint images, or raw server logs inside Laravel.
- Do not make forensic evidence storage the owner of domain records, audit logs, monitoring logs, or incident response workflows.
- Do not store raw secrets, full tokens, raw cookies, MFA codes, recovery codes, exploit payloads, or unnecessary PII in evidence packages.
- Do not let containment actions delete or overwrite evidence before preserving required metadata.

## Open Decisions

- Should the first forensics baseline be request correlation only, timeline query support, evidence package DTOs, or private evidence export?
- Should formal `evidence_packages` tables wait until incident workflow requires them?
- Which role/group initially receives `forensics.*` permissions?
- Which evidence package actions require `auth.recent`, MFA, elevated access, or two-person approval?
- Should legal hold be implemented as a setting-backed feature or deferred to runbooks until evidence packages exist?
- Should the first evidence export include only Audit/Monitoring rows, or also private file metadata and deployment evidence?

## Related

- [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md)
- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Software Supply Chain Security Planning](software-supply-chain-security-planning.md)

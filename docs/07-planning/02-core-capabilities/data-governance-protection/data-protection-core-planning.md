# Data Protection Core Planning

Status: Planning draft

## Purpose

Plan `app/Core/DataProtection` as the cross-cutting data-security capability before sensitive data classification, masking, exports, retention, erasure, backup expectations, and sensitive activity monitoring are expanded across core capabilities and business modules.

This document owns implementation sequencing and intent only. Final architecture contracts, feature behavior contracts, schema contracts, and runbooks must be promoted to their owning docs before implementation.

## Direction

Data protection is not a business module and is not a replacement for Auth, Access, Audit, Monitoring, Notifications, Identity, or business modules.

Target boundary:

```text
Core/DataProtection
  classifies sensitive data
  declares handling rules
  coordinates masking and redaction standards
  controls secure export rules
  executes retention and erasure/anonymization controls
  tracks backup and recovery expectations
  informs sensitive activity monitoring

Core/DataGovernance
  defines data domains, owners, stewards, purposes, privacy request behavior, data quality expectations, and retention policy intent

Core/Auth
  proves identity and protects authentication secrets

Core/Identity
  owns user/profile/lifecycle records and user PII workflows

Core/Access
  decides who can view, mutate, export, or approve access to protected data

Core/Audit
  records sensitive data access, change, export, deletion, and approval evidence

Core/Monitoring
  detects abnormal access, export, deletion, backup, or sensitive-data use patterns

Core/Notifications
  alerts users, administrators, or security owners about inbox-worthy sensitive events

Business modules
  own domain records and register their data assets with DataProtection
```

Decision rule:

```text
Does this classify, mask, redact, export, retain, erase, back up, or monitor data handling?
-> Core/DataProtection

Does this define why the data exists, who owns/stewards it, what privacy rights apply, or what retention policy intent applies?
-> Core/DataGovernance

Does this decide who may perform the action?
-> Core/Access

Does this prove identity before the action?
-> Core/Auth

Does this own the user or business record itself?
-> Core/Identity or Modules/{BusinessModule}

Does this record evidence?
-> Core/Audit

Does this detect unusual behavior or operational failure?
-> Core/Monitoring

Does this notify someone?
-> Core/Notifications
```

## Current Baseline

Current implementation has useful pieces but no dedicated data-protection boundary:

- authentication secrets and recovery data exist in Auth-oriented tables
- account/profile and contact-only emails exist around Account/Identity surfaces
- role and permission guardrails exist around Roles and Access planning
- audit logging is deferred and not yet promoted to `app/Core/Audit`
- central error logging exists but is not yet promoted to `app/Core/Monitoring`
- generated files and profile images use Laravel storage, but sensitive export policy is not centralized
- package manifests can declare permissions, UI entries, settings, preferences, and notification types, but not data assets
- no durable data-asset inventory, sensitive-field registry, export approval flow, retention policy registry, or erasure request workflow exists
- DataGovernance is now planned as the source for ownership, stewardship, processing purpose, privacy request behavior, data quality, and retention policy intent

The first planning target is therefore a core boundary and registry contract, not an admin page.

## Target Structure

Candidate physical structure once the capability is implemented:

```text
app/Core/DataProtection/
  Actions/
    RegisterDataAsset.php
    ClassifyDataAsset.php
    CreateDataExport.php
    ApproveSensitiveExport.php
    ApplyRetentionPolicy.php
    RequestDataErasure.php
    CompleteDataErasure.php
  Contracts/
    ClassifiesData.php
    MasksSensitiveData.php
    SupportsDataRetention.php
    SupportsSecureExport.php
  Data/
    DataAssetDefinition.php
    DataFieldDefinition.php
    DataClassificationRule.php
    DataMovementContext.php
    DataMovementDecision.php
    ExportRequestData.php
    RetentionRuleData.php
  Dlp/
    Policies/
    Services/
      DataMovementEvaluator.php
      DlpPolicyRegistry.php
      ExportRiskEvaluator.php
  Enums/
    DataClassification.php
    DataHandlingRule.php
    DataAssetType.php
    DataExportStatus.php
    DataMovementType.php
    DataRetentionAction.php
    SensitiveDataType.php
  Events/
    SensitiveDataViewed.php
    SensitiveDataExported.php
    SensitiveDataMasked.php
    DataErasureRequested.php
    DataErasureCompleted.php
    RetentionPolicyApplied.php
  Http/
    Controllers/
    Requests/
  Models/
    DataAsset.php
    DataAssetField.php
    DataExport.php
    DataExportApproval.php
    DataRetentionPolicy.php
    DataErasureRequest.php
  Policies/
  Queries/
  Services/
    DataClassificationRegistry.php
    DataAssetRegistry.php
    SensitiveFieldRegistry.php
    DataMaskingService.php
    DataRedactionService.php
    DataExportService.php
    DataRetentionService.php
    DataErasureService.php
  Support/
  ViewModels/
  Routes/
    admin-data-protection.php
```

The exact files should be introduced only in scoped implementation batches.

## Initial Classifications

Start with four levels:

```text
public
internal
confidential
restricted
```

Meanings:

| Classification | Meaning | Examples |
| --- | --- | --- |
| `public` | Safe to expose publicly. | public marketing content, public help docs |
| `internal` | Normal authenticated app data with low sensitivity. | UI preferences, dashboard layout, non-sensitive setup state |
| `confidential` | Business-sensitive or user-sensitive data. | user email, customer contacts, customer addresses, order history, reports |
| `restricted` | Security-sensitive, credential-like, regulated, or high-risk data. | passwords, MFA secrets, recovery codes, reset tokens, API tokens, session identifiers, privileged audit events |

Classification should inform redaction, export approval, retention, monitoring, and audit behavior. It should not replace authorization checks.

## Data Asset Registration

Each core capability and business module should eventually register the data it owns.

Examples:

```text
Core/Identity
  users
  user_profiles
  user_contact_emails
  user_invitations
  user_lifecycle_events

Core/Auth
  mfa_methods
  recovery_codes
  password_reset_tokens
  trusted_devices
  sessions

Core/Access
  roles
  permissions
  access_groups
  access_policies
  access_reviews

Core/Audit
  audit_events
  audit_event_changes

Core/Notifications
  notifications
  notification_preferences

Business modules
  customers
  customer_contacts
  customer_addresses
  orders
  order_lines
  inventory_stock
  inventory_movements
  shipments
  shipment_events
```

Manifest direction:

```text
Definition.php
  -> dataAssetDefinitions: ModuleDataAssets::all()
```

Large packages may split definitions into package-local helpers, but the manifest should remain the official declaration point.

The data-asset registry should track:

- owner package
- table or model target
- classification
- sensitive fields
- export eligibility
- retention rule key
- erasure behavior
- audit level
- last reviewed metadata

Privacy and Data Governance direction is tracked in [Privacy And Data Governance Planning](privacy-data-governance-planning.md) and the [Data Domain Governance Matrix](data-domain-governance-matrix.md). DataGovernance should add owner, steward, purpose, privacy-right support, consent metadata where meaningful, quality expectations, and retention policy intent. DataProtection should use that metadata when enforcing redaction, export, retention execution, erasure/anonymization execution, and DLP/data movement controls.

## Encryption And Secrets

Use separate handling for values the app must later read and values the app only verifies.

Secrets-management direction is tracked separately in [Secrets Management Core Planning](secrets-management-core-planning.md). DataProtection classifies secrets as restricted data and defines export, masking, retention, and handling expectations. `Core/Security/Secrets` owns credential-specific inventory metadata, redaction patterns, reveal/copy/rotation guardrails, secret health checks, and future vault integration boundaries.

Encrypt when the application must read the value later:

- TOTP secrets
- integration secrets
- API credentials
- OAuth refresh tokens
- provider credentials

Hash when the application only needs to verify a submitted value:

- passwords
- recovery codes
- invitation tokens
- password reset tokens
- one-time verification tokens

Do not encrypt every column by default. Field-level encryption affects search, filtering, indexing, debugging, and support. It should be reserved for approved restricted fields.

Transport, disk, database, and backup encryption remain infrastructure and runbook concerns, but DataProtection should record which data classes require those controls.

## Masking And Redaction

Separate redaction from masking.

Redaction:

- used in normal UI, logs, audit metadata, notifications, and support views
- hides or partially hides sensitive values
- examples: `k***@example.com`, last four digits only, `redacted`

Masking:

- used for safe test datasets, screenshots, demos, and sanitized exports
- replaces real values with generated safe values
- should preserve shape when needed without exposing real data

DataProtection should provide shared services for both, but each owning domain must decide which fields are sensitive and when a user is allowed to see the raw value.

Application Security owns request payload redaction guardrails and safe route/download helpers consumed by logs, monitoring, and export/download flows. Secrets Management owns credential-specific redaction patterns and secret reveal/rotation guardrails. DataProtection owns the sensitivity metadata and data-handling policy that tell those helpers what needs protection.

DLP and exfiltration direction is tracked in [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md). DataProtection owns the data movement policy decision; Monitoring owns exfiltration signals produced from audit and movement metadata.

Digital forensics readiness is tracked in [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md). DataProtection should classify evidence payloads, define redaction rules for evidence exports, and identify which evidence records require restricted handling, private storage, retention extension, or legal hold.

## Secure Exports

Exports are higher-risk than ordinary viewing because they move data out of normal UI controls.

Do not let every `*.view` permission imply export rights.

Initial permission pattern:

```text
data.exports.view
data.exports.create
data.exports.approve
data.exports.download
data.exports.delete

customers.export
customers.export_sensitive
orders.export
inventory.export
shipments.export
```

Candidate export flow:

```text
request export
  -> Access checks export permission
  -> DataGovernance confirms allowed purpose and retention/privacy constraints
  -> DataProtection checks classification and export policy
  -> DataProtection evaluates the data movement context and DLP policy
  -> Auth recent-authentication or MFA step-up is required when policy says so
  -> restricted/confidential export requires reason
  -> high-risk export may require approval
  -> file is generated to private storage
  -> download link is signed and expires
  -> request, approval, generation, download, and deletion are audited
  -> file expires and is pruned
```

Generated exports must not be stored in public storage.

## Retention And Erasure

Retention should begin as metadata and policy before automated deletion is broadened.

Initial retention targets:

- password reset tokens expire quickly and are pruned
- invitations expire and are revoked or pruned
- sessions expire and are pruned
- generated exports expire quickly and are deleted automatically
- audit events retain long enough for security and accountability requirements
- identity records required for audit integrity are deactivated, soft-deleted, or anonymized rather than hard-deleted

Initial erasure direction:

```text
identity deactivation
  -> preserve audit subject reference
  -> revoke sessions
  -> remove access assignments when policy says so
  -> anonymize selected PII if approved
  -> retain non-sensitive referential identity where audit requires it
```

Hard delete should be a governance policy decision, not the default for identity or audit-linked records.

For incident and forensic workflows, legal hold should override normal pruning for approved evidence packages, export manifests, and selected source records. DataGovernance should own legal-hold and retention-policy intent; DataProtection should execute approved retention/erasure/anonymization behavior; Audit/Forensics should own evidence package metadata, chain-of-custody records, and investigation timeline reconstruction.

## Backup, Recovery, And Resilience

Backup and recovery are operational controls, but they are part of data protection planning because they protect availability and integrity.

Initial direction:

- keep backup and restore procedures in `docs/10-runbooks/`
- store backup health and restore-check status under Core/Monitoring if app-side records are needed
- classify backups according to the most sensitive data they contain
- ensure backups are encrypted and not stored publicly
- test restore procedures before treating backups as reliable

Do not create `app/Core/Resilience` yet unless backup verification, restore drills, incident recovery state, and health checks grow beyond Monitoring/runbook ownership.

## Monitoring And Anomaly Detection

DataProtection defines which actions are sensitive. Monitoring detects abnormal patterns. Audit supplies evidence. Notifications deliver alerts.

DLP and exfiltration detection is tracked in [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md). DataProtection should define the data classifications, data movement types, and DLP handling decisions that Monitoring, Access, Audit, and Incident Response use for DLP-style controls; it should not become a standalone DLP product by default.

Zero Trust direction is tracked in [Zero Trust Security Planning](zero-trust-security-planning.md). DataProtection provides the classification and sensitive data movement rules that determine when actions need recent authentication, MFA step-up, reason capture, approval, private storage, signed URLs, audit, and monitoring.

Initial deterministic rules are enough:

- unusually large exports
- repeated export downloads
- many customer/contact views in a short window
- repeated access-denied events
- Super Admin or elevated role assignment
- MFA disabled or reset
- direct access exception created
- large delete/archive operation
- background sync modifies an abnormal number of rows
- backup check failed or restore test stale

Avoid overbuilding AI anomaly detection before audit events, export controls, and monitoring baselines exist.

## Database Security Direction

Detailed schema belongs in future `docs/06-database/` contracts.

Planning direction:

- application runtime should use least-privileged database credentials
- migration/admin credentials should be separated later if feasible
- UI exports must go through DataProtection export workflows, not ad hoc table dumps
- sensitive migrations should record classification and retention expectations
- request payloads, logs, audit metadata, and exception reports must not store raw credentials, tokens, MFA secrets, or avoidable raw PII
- tenant/customer scoping must be enforced before broad business data surfaces are implemented

## Business Module Participation

Business modules own their records and must participate by declaring:

1. Data assets.
2. Sensitive fields.
3. Export rules.
4. Retention rules.
5. Audit-worthy data actions.
6. Permissions related to sensitive access and export.

Example future Customers module:

```text
Modules/Customers/
  Definitions/
    CustomersDataAssets.php
    CustomersPermissions.php
  Actions/
    ExportCustomers.php
  Policies/
    CustomerPolicy.php
  Models/
    Customer.php
    CustomerContact.php
    CustomerAddress.php
```

Example actions and permissions:

```text
customers.view
customers.view_sensitive
customers.create
customers.update
customers.export
customers.export_sensitive
customers.delete

customers.sensitive_fields_viewed
customers.exported
customers.deleted
```

## Admin Surface Direction

Admin pages should come after enforcement and registry foundations.

Potential future area:

```text
Admin
  Data Protection
    Overview
    Data Assets
    Sensitive Fields
    Exports
    Retention Policies
    Erasure Requests
    Backup Status
    Sensitive Activity
```

Initial useful tables:

Data assets:

```text
Asset
Owner
Classification
Sensitive fields
Retention policy
Export allowed
Audit level
Last reviewed
```

Exports:

```text
Requested by
Owner
Asset
Classification
Status
Reason
Approved by
Expires
Downloaded
Actions
```

## Implementation Sequence

### 1. Architecture And Planning Alignment

- Add `Core/DataProtection` to the core capability migration direction.
- Document boundaries with DataGovernance, Auth, Identity, Access, Audit, Monitoring, Notifications, Settings, and business modules.
- Confirm that DataGovernance owns data domain, owner/steward, purpose, privacy request behavior, quality expectation, and retention policy intent metadata before broad enforcement work begins.
- Decide whether the first implementation needs manifest-declared data assets or a smaller code-only enum/service baseline.

### 2. Classification Baseline

- Add `DataClassification` and `SensitiveDataType` concepts.
- Create a `DataAssetDefinition` contract.
- Register core Auth, Identity, Access, Audit, Notifications, and Settings data assets.
- Add validation for unique data asset keys.

### 3. Redaction And Secret Handling Baseline

- Add shared redaction helpers for logs, audit payloads, notifications, and admin lists.
- Review Auth secrets and tokens for correct encrypt-vs-hash treatment.
- Ensure audit metadata does not store raw secrets or raw sensitive values.

### 4. Export Controls

- Introduce export-specific permissions separate from view permissions.
- Add DataExport request/approval/download lifecycle.
- Use private storage and signed expiring links.
- Use Application Security signed URL validation helpers where downloads are route-mediated.
- Audit export request, approval, generation, download, expiration, and deletion.

### 5. Retention And Erasure

- Add retention rule definitions.
- Prune expired Auth and export records.
- Define Identity deactivation/anonymization behavior.
- Keep audit retention separate from user erasure workflows.

### 6. Monitoring Integration

- Add sensitive-activity audit filters.
- Add deterministic export/access/delete spike rules.
- Add backup health checks under Monitoring if app-side tracking is approved.
- Create persistent Notifications for high-risk events.

## Test Planning

Expected tests once implemented:

- data asset keys are unique
- classification metadata is valid
- restricted fields cannot be exported without approved export policy
- export permissions are separate from view permissions
- generated exports use private storage and expiring signed download links
- export request, approval, download, expiration, and deletion are audited
- DLP movement decisions can block, allow, require reason, require approval, redact, or downgrade payloads
- DataProtection consumes DataGovernance purpose, privacy-right, retention intent, and quality metadata without owning governance policy
- session, response, export, download, and cross-scope DLP thresholds produce Monitoring signals when configured
- redaction helpers hide sensitive values in audit metadata, logs, notifications, and lower-privilege views
- Auth secrets are encrypted or hashed according to use case
- expired exports and temporary records are pruned
- identity deactivation/anonymization preserves audit subject references
- sensitive activity rules create Monitoring findings and Notifications only for inbox-worthy events

## Transition Rules

- Do not treat DataProtection as a business module.
- Do not make data security a sidebar-only admin surface without enforcement.
- Do not make DataProtection own privacy policy, data ownership, stewardship, consent, processing purpose, privacy request case workflow, or data quality issue workflow.
- Do not rely on RBAC alone for data security.
- Do not let ordinary view permission imply export permission.
- Do not store generated exports in public storage.
- Do not log raw credentials, tokens, MFA secrets, recovery codes, or avoidable raw PII.
- Do not hard-delete identity records needed for audit integrity.
- Do not add AI anomaly detection before deterministic audit and monitoring signals exist.
- Do not add a separate resilience capability until Monitoring/runbook ownership is proven insufficient.

## Open Decisions

- Should data asset definitions be projected to DB registry tables in the first implementation or remain runtime-manifest-only at first?
- Should DataGovernance definitions project to DB before DataProtection data asset definitions, or should both registries be introduced together?
- Which core data assets must be registered before Access Control implementation begins?
- Which admin actions require `auth.recent`, MFA, or elevated access when DataProtection classifies the target as restricted?
- What is the first export use case that justifies building `DataExport`?
- Should backup check records live under Core/Monitoring or a later resilience capability?
- Which PII fields should Identity anonymize during deprovisioning?
- What is the first retention baseline for audit events, notifications, generated exports, sessions, invitations, and tokens?

## Out Of Scope

- implementing DataProtection in this pass
- defining final database schemas in this planning document
- implementing business module export workflows in this pass
- implementing DataGovernance/privacy request workflows in this pass
- implementing legal compliance automation in this pass
- implementing AI anomaly detection in this pass
- implementing backup infrastructure or restore runbooks in this pass
- editing `/docs/08-active/`

## Related

- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Privacy And Data Governance Planning](privacy-data-governance-planning.md)
- [Data Domain Governance Matrix](data-domain-governance-matrix.md)
- [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Backup And Recovery Planning](backup-recovery-planning.md)
- [Auth And RBAC Data Contract](../06-database/feature-contracts/auth-and-rbac.md)

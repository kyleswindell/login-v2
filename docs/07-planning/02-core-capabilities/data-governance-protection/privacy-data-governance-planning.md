# Privacy And Data Governance Planning

Status: Planning draft

## Purpose

Plan `app/Core/DataGovernance` as the policy, ownership, purpose, privacy-rights, stewardship, and data-quality layer that sits above `app/Core/DataProtection`.

This document owns implementation sequencing and intent only. Final standards, architecture contracts, feature behavior contracts, schema contracts, and runbooks must be promoted to their owning docs before implementation.

## Direction

Privacy, data governance, and data protection are related, but they are not the same system.

Target split:

```text
Core/DataGovernance
  defines what data may exist
  defines why data exists
  defines who owns and stewards it
  defines processing purposes
  defines consent and lawful-basis metadata where needed
  defines privacy request workflows
  defines retention policy intent
  defines data quality expectations

Core/DataProtection
  enforces classification and handling controls
  redacts and masks sensitive values
  controls secure exports and signed downloads
  evaluates DLP/data movement
  executes retention and erasure/anonymization decisions
  stores private generated files where approved
```

Do not create:

```text
Modules/Privacy
Modules/DataGovernance
```

The first implementation should be registry and workflow planning, not a dashboard.

## Ownership

| Owner | Owns | Does Not Own |
| --- | --- | --- |
| `app/Core/DataGovernance` | data domains, data owners, data stewards, processing purposes, consent metadata, privacy requests, data quality issues, retention policy intent, governance registry | technical redaction execution, DLP enforcement, access decisions, auth mechanics, audit storage, monitoring storage |
| `app/Core/DataProtection` | classification enforcement, redaction, masking, secure export controls, DLP policy execution, retention execution, erasure/anonymization execution | data owner assignment, stewardship, processing-purpose approval, privacy request case workflow |
| `app/Core/Identity` | app-user profile/lifecycle source records and self-service/admin identity workflows | consent engine, data governance policy registry, privacy request case management |
| `app/Core/Auth` | password, MFA, sessions, recovery, trusted devices, security proof | normal profile data, privacy policy, raw secret export |
| `app/Core/Access` | who may view, mutate, export, approve, or administer governed data | data ownership policy, redaction execution, privacy request fulfillment logic |
| `app/Core/Audit` | governance/privacy request evidence and sensitive action history | privacy policy decisions, data quality remediation |
| `app/Core/Monitoring` | privacy request SLA signals, stale review signals, quality issue signals, abnormal governed-data activity | governance policy ownership |
| `app/Core/Notifications` | inbox-worthy owner/steward/privacy request alerts | consent or privacy request source of truth |
| `Modules/*` | domain records and module-specific governed data declarations | global governance registry ownership |

## Core Questions

DataGovernance should answer:

```text
What data domain does this record belong to?
Who owns the data domain?
Who stewards day-to-day quality and correction?
Why is this data collected or processed?
What purposes are allowed?
Does the asset contain personal data?
Does the asset contain sensitive PII or confidential business data?
What privacy rights apply?
Is correction supported?
Is erasure, anonymization, restriction, or retention required?
What data quality expectations apply?
When must the governance metadata be reviewed?
```

DataProtection should answer:

```text
How is this data classified?
How is it redacted or masked?
Can it be exported?
Does export require reason, approval, recent auth, MFA, or private storage?
How is retention executed?
How is erasure or anonymization executed?
What DLP/data movement controls apply?
```

## Target Structure

Candidate structure once implementation begins:

```text
app/Core/DataGovernance/
  Actions/
    RegisterDataDomain.php
    RegisterDataAssetGovernance.php
    UpdateDataAssetPurpose.php
    AssignDataOwner.php
    AssignDataSteward.php
    RecordProcessingPurpose.php
    RecordConsent.php
    WithdrawConsent.php
    CreatePrivacyRequest.php
    CompletePrivacyRequest.php
    ApproveRetentionPolicy.php
    ReviewDataQualityIssue.php
  Contracts/
    GovernedDataAsset.php
    SupportsPrivacyRequests.php
    SupportsDataCorrection.php
    SupportsDataErasure.php
    SupportsDataLineage.php
  Data/
    DataDomainDefinition.php
    DataAssetGovernanceDefinition.php
    ProcessingPurposeDefinition.php
    DataStewardAssignment.php
    PrivacyRequestData.php
    ConsentRecordData.php
    DataQualityIssueData.php
  Enums/
    DataDomainType.php
    ProcessingPurpose.php
    LawfulBasis.php
    PrivacyRequestType.php
    PrivacyRequestStatus.php
    ConsentStatus.php
    DataQualityIssueStatus.php
    DataGovernanceRiskLevel.php
  Events/
    DataOwnerAssigned.php
    DataStewardAssigned.php
    PrivacyRequestCreated.php
    PrivacyRequestCompleted.php
    ConsentRecorded.php
    ConsentWithdrawn.php
    RetentionPolicyReviewed.php
    DataQualityIssueCreated.php
  Models/
    DataDomain.php
    DataAssetGovernanceRecord.php
    DataOwnerAssignment.php
    DataStewardAssignment.php
    ProcessingPurposeRecord.php
    ConsentRecord.php
    PrivacyRequest.php
    PrivacyRequestItem.php
    DataQualityIssue.php
  Policies/
    DataGovernancePolicy.php
    PrivacyRequestPolicy.php
    DataQualityIssuePolicy.php
  Queries/
    DataDomainIndexQuery.php
    DataAssetGovernanceQuery.php
    PrivacyRequestIndexQuery.php
    DataSubjectInventoryQuery.php
    DataQualityIssueQuery.php
    RetentionReviewQuery.php
  Services/
    DataGovernanceRegistry.php
    DataOwnerResolver.php
    DataStewardResolver.php
    ProcessingPurposeRegistry.php
    ConsentService.php
    PrivacyRequestService.php
    DataSubjectDiscoveryService.php
    DataQualityService.php
    GovernanceAuditService.php
  Support/
    DataDomainKey.php
    ProcessingPurposeKey.php
    PrivacyRequestNumber.php
  ViewModels/
    DataGovernanceOverviewViewModel.php
    PrivacyRequestShowViewModel.php
    DataAssetGovernanceViewModel.php
  Routes/
    admin-data-governance.php
```

This is a target shape, not a commitment to create every file in the first implementation batch.

## Data Domains

Data domains group related data under an owner/steward model.

Initial domains are tracked in the [Data Domain Governance Matrix](data-domain-governance-matrix.md).

Candidate domain table:

```text
data_domains
  id
  key
  name
  description
  owner_user_id
  steward_user_id
  classification_default
  status
  created_at
  updated_at
```

Example domain keys:

```text
identity
auth-security
access-control
notifications
audit-monitoring
customers
orders
shipments
inventory
generated-files
```

## Data Asset Governance Records

DataProtection can register a data asset for classification and enforcement. DataGovernance adds ownership, purpose, privacy, review, and quality metadata.

Candidate governance record:

```text
data_asset_governance_records
  id
  asset_key
  domain_key
  owner_user_id
  steward_user_id
  primary_purpose
  allowed_secondary_purposes_json
  contains_personal_data
  contains_sensitive_pii
  contains_confidential_business_data
  classification
  retention_policy_key
  erasure_supported
  correction_supported
  export_supported
  consent_required
  quality_expectations_json
  review_due_at
  created_at
  updated_at
```

The first slice can keep these as manifest/code definitions. Add DB projection only when listing, review, stale detection, privacy request discovery, or owner/steward workflows require durable state.

## Processing Purposes

Processing purposes document why data exists and how it may be used.

Candidate table:

```text
processing_purposes
  id
  key
  label
  description
  legal_basis
  applies_to_asset_key
  requires_consent
  allows_export
  allows_notification
  allows_analytics
  retention_policy_key
  created_at
  updated_at
```

Initial purpose vocabulary:

```text
account_operation
authentication_security
access_administration
customer_management
order_fulfillment
shipment_processing
audit_and_security
support
legal_compliance
analytics
```

Do not use consent as a blanket justification for security, audit, or access-control processing. Those purposes should usually be recorded as operational, security, or legal necessity.

## Consent Records

Consent should be used for optional processing where consent is actually meaningful.

Candidate table:

```text
consent_records
  id
  subject_type
  subject_id
  purpose_key
  status
  consented_at
  withdrawn_at
  source
  version
  ip_address
  user_agent
  created_at
  updated_at
```

Initial statuses:

```text
granted
withdrawn
not_required
superseded
```

Likely first use cases:

- optional email notifications after email delivery exists
- optional marketing-style communication if ever added
- optional analytics or tracking if ever added
- optional preference sync if ever added

Do not fake consent toggles for processing the app must perform for account operation, security, audit, or legal retention.

## Privacy Requests

Privacy requests should be admin-operated at first. A public self-service privacy portal is out of scope until legal/product requirements are explicit.

Candidate tables:

```text
privacy_requests
  id
  request_number
  subject_type
  subject_id
  request_type
  status
  requested_by
  assigned_to
  due_at
  completed_at
  denied_at
  denial_reason
  notes
  created_at
  updated_at

privacy_request_items
  id
  privacy_request_id
  asset_key
  action
  status
  result_summary
  completed_at
  created_at
  updated_at
```

Initial request types:

```text
access
correction
erasure
restriction
objection
consent_withdrawal
export
```

Initial item outcomes:

```text
completed
deleted
anonymized
retained_due_to_legal_or_security_reason
restricted
not_found
denied
```

Important rule:

```text
Do not hard-delete audit-linked identity, access, security, or business records by default.
Use anonymization, deactivation, restriction, retention, or denial where audit, legal, or business constraints require it.
```

## Data Quality Issues

Data quality matters because inaccurate personal or business data can create privacy, security, billing, shipment, notification, support, and audit risk.

Candidate table:

```text
data_quality_issues
  id
  asset_key
  record_type
  record_id
  issue_type
  severity
  status
  reported_by
  assigned_to
  summary
  resolved_at
  created_at
  updated_at
```

Initial issue types:

```text
inaccurate
incomplete
duplicate
stale
invalid_format
missing_required_relationship
conflicting_reference
```

Do not build a data-quality dashboard before assets, owners/stewards, and a real remediation workflow exist.

## Data Subject Model

Do not assume every data subject is an app user.

Potential subjects:

```text
app users
customer contacts
client employees
service account owners
notification recipients
vendor contacts
unknown external contacts
```

Start virtual/query-based where possible. Add a `data_subjects` table only if privacy request tracking needs consolidated subject identity.

Candidate later table:

```text
data_subjects
  id
  subject_type
  subject_id
  display_name
  primary_email
  source_domain
  created_at
  updated_at
```

## Privacy Request Flows

Access request:

```text
create privacy request
  -> identify subject
  -> discover governed data assets containing subject data
  -> classify results
  -> exclude raw security secrets and restricted technical values
  -> generate privacy-safe report
  -> audit report creation/download
  -> close request
```

Correction request:

```text
create privacy request
  -> identify record and field
  -> route to data steward or domain owner
  -> validate correction
  -> apply through the owning domain action
  -> audit before/after safely
  -> close request
```

Erasure request:

```text
create privacy request
  -> identify governed data assets
  -> check retention, legal, security, audit, and business constraints
  -> decide delete/anonymize/restrict/retain/deny per asset
  -> perform approved domain actions
  -> audit result
  -> close request
```

## Core Capability Mapping

Identity:

- owns user profile, lifecycle, contact-only emails, status, invitations, and account state
- supports correction requests for user/profile fields
- supports deactivation/anonymization where allowed
- preserves audit-linked identity references where required

Auth:

- owns security-sensitive authentication data
- should never export raw password hashes, MFA secrets, reset tokens, session cookies, or recovery codes
- can expose privacy-safe metadata such as MFA enabled, recovery codes generated date, active session summary, and password last changed date

Access:

- owns roles, groups, policies, effective access, elevated access, and reviews
- access assignments are personal data when tied to a user
- audit/security retention may override erasure

DataProtection:

- executes classification, redaction, masking, export, DLP, retention, and erasure/anonymization controls
- consumes governance metadata for purpose, retention, privacy-right support, and quality expectations

Audit:

- records governance and privacy request evidence
- supports privacy-safe display/export
- must not be silently altered in ways that destroy security evidence

Monitoring:

- tracks privacy request SLA misses, stale governance reviews, data quality issue signals, and abnormal governed-data activity
- must avoid raw personal/sensitive data in error context

Notifications:

- can notify owners/stewards/assignees about privacy request due dates, quality issues, or retention review needs
- should keep notification payloads safe and reauthorize action links

## Governance Registry

Core capabilities and business modules should contribute governance definitions through package manifests or package-local helpers.

Target declaration flow:

```text
Package Definition.php
  -> governanceDefinitions: PackageGovernance::all()
  -> DataGovernanceRegistry validates definitions
  -> optional DB projection stores active/stale metadata
  -> privacy request and review workflows consume the registry
```

Example business module helper:

```text
Modules/Customers/Definitions/CustomersGovernance.php
```

Example contribution shape:

```text
domain:
  key: customers
  name: Customer data
  owner: customers.owner
  steward: customers.steward

assets:
  customer_contacts:
    classification: confidential
    contains_personal_data: true
    purposes:
      - customer_management
      - order_fulfillment
      - support
    correction_supported: true
    erasure_supported: conditional
    retention_policy: customer-record-retention
```

## Admin Surfaces Later

Do not build Data Governance admin UI first. Later, Admin > Data governance may include:

```text
Data governance
  Overview
  Data domains
  Data assets
  Processing purposes
  Data owners/stewards
  Privacy requests
  Consent records
  Retention reviews
  Data quality issues
  Audit
```

Build UI only after registry, owner/steward, and privacy request services exist.

## Permissions

Exact permission names are an implementation decision, but DataGovernance should use canonical owner-owned permissions and must not add `platform.*` permissions.

Working permission areas:

```text
data-governance.view
data-governance.domains.view
data-governance.domains.update
data-governance.assets.view
data-governance.assets.update
data-governance.privacy-requests.view
data-governance.privacy-requests.create
data-governance.privacy-requests.update
data-governance.privacy-requests.complete
data-governance.consent.view
data-governance.consent.update
data-governance.quality.view
data-governance.quality.update
data-governance.retention.review
data-governance.manage
```

`data-governance.manage` should be the elevated umbrella permission if this namespace is accepted.

Open decision: confirm whether multiword permission namespaces should use hyphenated owner keys such as `data-governance.*` or dotted area keys such as `data.governance.*` before implementation.

## Implementation Sequence

### 1. Docs And Standards Promotion

- Promote accepted privacy/data governance rules into `docs/02-standards/security/privacy-and-data-governance.md`.
- Add data stewardship and data quality standards only when the first implementation slice needs them.
- Add privacy request and retention review runbooks before implementing workflows.

### 2. Registry Baseline

- Add `DataDomainDefinition`.
- Add `DataAssetGovernanceDefinition`.
- Add `ProcessingPurposeDefinition`.
- Add `DataGovernanceRegistry`.
- Validate unique domain keys, asset keys, and processing purpose keys.
- Register Identity, Auth, Access, Audit, Monitoring, Notifications, and DataProtection governance definitions.

### 3. Owner And Steward Baseline

- Add owner/steward assignment vocabulary.
- Decide whether owners/stewards are users, roles, groups, or access-policy subjects.
- Add resolver interfaces before UI.
- Emit audit events for owner/steward changes when persistence exists.

### 4. Privacy Request MVP

- Add `PrivacyRequest` and `PrivacyRequestItem` only when an admin-operated workflow is needed.
- Start with access, correction, and erasure request types.
- Require assigned owner/steward or admin assignee.
- Audit creation, assignment, fulfillment, denial, export, and closure.

### 5. Data Quality MVP

- Add lightweight data quality issue records only after governed assets and stewards exist.
- Route correction to the owning domain action.
- Notify steward/owner only for inbox-worthy issues.

### 6. Business Module Template Update

- Add governance definition placeholders to `Modules/_Template`.
- Add `docs/data-governance.md` and `docs/privacy.md` placeholders.
- Add module security/governance tests for assets, purposes, correction, erasure, export, quality, and audit declarations.

## Test Planning

Expected first tests once implemented:

- data domain keys are unique
- governed asset keys are unique
- governed assets have owner, steward, purpose, classification, retention intent, and privacy-right behavior
- processing purposes validate legal basis/consent requirements where configured
- privacy request lifecycle creates, assigns, completes, denies, and audits safely
- privacy access report excludes raw security secrets
- correction request routes to the owning domain action
- erasure request returns delete/anonymize/restrict/retain/deny outcomes per asset
- retention review identifies overdue assets
- data quality issue lifecycle creates, assigns, resolves, and audits
- DataProtection consumes governance metadata without owning governance policy

## Transition Rules

- Do not create `Modules/Privacy` or `Modules/DataGovernance`.
- Do not make DataProtection own privacy policy, data ownership, or stewardship.
- Do not build a public self-service privacy portal before legal/product requirements exist.
- Do not build a full compliance engine or legal claim generator.
- Do not use consent for required security, audit, access-control, or legal-retention processing.
- Do not reveal raw secrets in privacy access reports.
- Do not hard-delete audit-linked records by default.
- Do not build dashboards before registry/workflows exist.
- Do not define final schemas in this planning document.
- Do not edit `/docs/08-active/`.

## Open Decisions

- Should `app/Core/DataGovernance` be created as a sibling to `app/Core/DataProtection` in the first implementation, or should governance begin as `app/Core/DataProtection/Governance` compatibility code?
- Should owner/steward assignments point to users, roles, groups, or access-policy subjects?
- Should the first governance registry project to DB immediately, or remain runtime-manifest-only until admin listing/review is needed?
- What permission namespace should DataGovernance use?
- Which privacy request types are required for MVP: access, correction, erasure, restriction, objection, consent withdrawal, or export?
- Which data subjects must be supported first: app users only, or app users plus customer contacts?
- What is the first retention review baseline?
- Which business module should be the first governance template proof: Customers, Orders, Shipments, or Inventory?

## Related

- [Data Domain Governance Matrix](data-domain-governance-matrix.md)
- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)

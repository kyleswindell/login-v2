# Data Domain Governance Matrix

Status: Planning matrix

## Purpose

Track planned data domains, ownership expectations, privacy posture, retention intent, and stewardship requirements for core capabilities and future business modules.

This matrix supports [Privacy And Data Governance Planning](privacy-data-governance-planning.md). It is planning and sequencing material only. Final schemas, standards, feature behavior, and runbook procedures belong in their canonical owners.

## Matrix Columns

| Column | Meaning |
| --- | --- |
| Domain Key | Stable planning key for the data domain. |
| Primary Owner | Core capability or business module that owns the source records. |
| Stewardship Need | Whether day-to-day data quality/correction ownership is expected. |
| Personal Data | Whether the domain can identify a person or data subject. |
| Sensitive Data | Whether the domain likely contains restricted, credential-like, or sensitive PII/business data. |
| First Privacy Behaviors | Initial privacy request or governance behaviors to plan. |
| First DataProtection Dependency | First technical enforcement dependency. |

## Core Data Domains

| Domain Key | Primary Owner | Stewardship Need | Personal Data | Sensitive Data | First Privacy Behaviors | First DataProtection Dependency |
| --- | --- | --- | --- | --- | --- | --- |
| `identity` | `app/Core/Identity` | High | Yes | Sometimes | access report, correction support, deactivation/anonymization constraints | profile/contact field classification, redaction, retention intent |
| `auth-security` | `app/Core/Auth` | Medium | Yes | Yes | privacy-safe security metadata only; no raw secret export | restricted classification, no raw secret logging, token/session pruning |
| `access-control` | `app/Core/Access` | High | Yes when tied to users | Yes | user access summary, retention for security evidence, role/group assignment review | restricted/elevated access classification, audit retention, export guardrails |
| `notifications` | `app/Core/Notifications` | Medium | Yes | Sometimes | notification content minimization, safe action links, retention policy | payload redaction, action reauthorization, retention execution |
| `audit-monitoring` | `app/Core/Audit` and `app/Core/Monitoring` | High | Yes | Yes | privacy-safe display/export, retention exceptions, legal/security hold | redaction, restricted export, evidence retention, private storage |
| `data-governance` | `app/Core/DataGovernance` | High | Yes | Sometimes | privacy request workflow, owner/steward assignment, consent metadata | admin export controls, audit evidence, retention policy execution |
| `data-protection` | `app/Core/DataProtection` | High | Yes when records target subjects | Yes | export/erasure/anonymization outcomes reported to privacy requests | classification, redaction, masking, DLP, secure exports |
| `settings-preferences` | `app/Core/Settings` and `app/Core/Preferences` | Low | Yes for user preferences | Usually no | access/correction for user-owned preferences | classification, retention, safe notification preference display |
| `security-controls` | `app/Core/Security` | Medium | Sometimes | Sometimes | security evidence retention, safe request context export | request redaction, signed download validation, route tier evidence |
| `supply-chain` | `app/Core/Security/SupplyChain` | Medium | Usually no | Sometimes | release evidence retention, accepted-risk owner metadata | private evidence storage, redaction of secrets in scan output |
| `vulnerability-management` | `app/Core/Security/VulnerabilityManagement` | Medium | Sometimes | Yes | finding owner metadata, accepted-risk records, private evidence handling | restricted finding classification, private evidence, retention |

## Future Business Data Domains

| Domain Key | Primary Owner | Stewardship Need | Personal Data | Sensitive Data | First Privacy Behaviors | First DataProtection Dependency |
| --- | --- | --- | --- | --- | --- | --- |
| `customers` | `Modules/Customers` | High | Yes | Yes | contact access/correction, conditional erasure/anonymization, data quality issues | contact/address classification, export separation, retention policy |
| `orders` | `Modules/Orders` | High | Yes when tied to contacts | Yes | access report, correction constraints, legal/business retention conflicts | private exports, order retention, sensitive field redaction |
| `shipments` | `Modules/Shipments` | High | Yes | Yes | address correction, delivery-contact privacy, retention conflict handling | address masking/redaction, export controls, retention |
| `inventory` | `Modules/Inventory` | Medium | Usually no | Sometimes | owner/steward and quality issue workflows | business-confidential classification, export controls |
| `projects` | `Modules/Projects` | Medium | Yes for members/assignees | Sometimes | membership access summary, correction of assignment metadata | member/assignment classification, notification minimization |
| `events` | `Modules/Events` | Medium | Yes | Sometimes | invitation/attendance access summary, correction, retention | schedule/attendee classification, notification minimization |
| `messages` | `Modules/Messaging` | High | Yes | Yes | access/export restrictions, retention rules, content minimization | restricted content classification, export approval, private storage |
| `support` | `Modules/Support` | High | Yes | Yes | requester/assignee access, correction, retention and legal hold | ticket content classification, attachment controls, private exports |
| `websites-leads` | `Modules/Websites` or `Modules/Leads` | High | Yes | Sometimes | contact form subject access/correction/erasure, consent if marketing is added | contact-field classification, retention, notification payload minimization |

## Data Subject Types

| Subject Type | First Source | Notes |
| --- | --- | --- |
| `app_user` | `app/Core/Identity` | Authenticated internal user or platform user. |
| `customer_contact` | future `Modules/Customers` | Customer-side person. Do not assume they can sign in. |
| `employee_contact` | future HR/workforce module if added | May overlap with app users but should not be assumed. |
| `vendor_contact` | future purchasing/vendor module if added | Business contact, likely not an app user. |
| `service_account_owner` | `app/Core/Auth/ServiceAccounts` | Human owner or steward for a non-human account. |
| `notification_recipient` | `app/Core/Notifications` | May be an app user now; future external recipients need separate modeling. |
| `unknown_external_contact` | business modules | Contact form or imported contact before domain identity is resolved. |

Start virtual/query-based. Add a durable `data_subjects` table only if privacy request tracking requires consolidated subject identity across domains.

## First Governance Requirements

Every governed data asset should eventually declare:

```text
domain_key
owner
steward
primary_purpose
allowed_secondary_purposes
contains_personal_data
contains_sensitive_pii
contains_confidential_business_data
classification
retention_policy_key
correction_supported
erasure_supported
export_supported
quality_expectations
audit_events
review_due_at
```

Minimum first slice:

```text
domain_key
owner
steward
primary_purpose
contains_personal_data
classification
retention_policy_key
correction_supported
erasure_supported
export_supported
```

## Privacy Behavior Guide

| Behavior | Meaning |
| --- | --- |
| `access_supported` | Subject data can be included in a privacy-safe access report. |
| `correction_supported` | Incorrect data can be corrected through the owning domain action. |
| `erasure_supported` | Data can be deleted when no retention/security/business constraint blocks it. |
| `anonymization_supported` | Identifying fields can be removed or replaced while preserving needed record integrity. |
| `restriction_supported` | Processing or visibility can be restricted without deleting the source record. |
| `retained_due_to_constraint` | Deletion is blocked by legal, security, audit, or business retention. |
| `not_subject_exportable` | Raw value is excluded from subject reports, usually for secrets/security evidence. |

## Governance And DataProtection Handoff

```text
DataGovernance determines:
  owner
  steward
  purpose
  consent requirement
  retention intent
  privacy request support
  quality expectations

DataProtection enforces:
  classification
  redaction
  masking
  export controls
  DLP decisions
  retention execution
  erasure/anonymization execution
```

Neither system replaces Access or Auth. Access authorizes the action. Auth proves the actor. Audit records evidence. Monitoring detects abnormal or overdue states.

## Maintenance Rules

- Add new data domains here before building large business modules on top of them.
- Keep this matrix focused on planning. Do not turn it into a final database schema.
- Update related DataProtection and business-module planning when a domain changes privacy behavior.
- Do not list raw secrets, raw tokens, or production credentials in this matrix.
- Do not treat a domain as implementation-ready until owner, steward, purpose, privacy behavior, classification, retention, and audit expectations are known.

## Related

- [Privacy And Data Governance Planning](privacy-data-governance-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md)

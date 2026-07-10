<!--
DOC-META
title: Database Data Classification And Retention Standards
doc_type: standard
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/Database Data Classification And Retention Standards.md
parent: docs/02-standards/database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines database standards for data classification, sensitive fields, retention, deletion, anonymization, masking, export eligibility, and audit-preserving data lifecycle behavior.
-->

# Database Data Classification And Retention Standards

This document defines database standards for data classification, sensitive fields, retention, deletion, anonymization, masking, and export eligibility in Login App 2.0.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Core Rule](#3-core-rule)
- [4. Data Classifications](#4-data-classifications)
- [5. Sensitive Field Identification](#5-sensitive-field-identification)
- [6. Storage Protection Rules](#6-storage-protection-rules)
- [7. Masking And Redaction](#7-masking-and-redaction)
- [8. Export Eligibility](#8-export-eligibility)
- [9. Retention Rules](#9-retention-rules)
- [10. Deletion, Deactivation, And Anonymization](#10-deletion-deactivation-and-anonymization)
- [11. Audit-Preserving Deletion](#11-audit-preserving-deletion)
- [12. Data Minimization](#12-data-minimization)
- [13. Seed And Test Data](#13-seed-and-test-data)
- [14. Documentation Expectations](#14-documentation-expectations)
- [15. Testing Expectations](#15-testing-expectations)
- [16. Stop Conditions](#16-stop-conditions)
- [17. Related](#17-related)

---

## 1. Purpose

Ensure database tables and columns are classified, protected, retained, and removed according to their risk and system role.

Database design must support DataGovernance and DataProtection requirements.

---

## 2. Scope

This standard applies to:

- table docs
- column docs
- database schema design
- migrations
- exports
- retention processes
- erasure/anonymization processes
- audit-preserving deletion
- sensitive field handling
- test fixtures and seed data

This standard supports Core DataGovernance and Core DataProtection.

---

## 3. Core Rule

Every table that stores meaningful system, user, customer, tenant, workspace, security, or business data must identify classification and retention expectations.

Sensitive data must be identifiable before implementation is considered complete.

---

## 4. Data Classifications

Use these classifications.

| Classification | Meaning                                                                                             | Examples                                                                         |
| -------------- | --------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- |
| public         | Safe to expose publicly.                                                                            | Published marketing content, public docs.                                        |
| internal       | Internal operational data with low sensitivity.                                                     | Non-sensitive registry labels, UI metadata.                                      |
| confidential   | Business, user, operational, or customer data that should not be public.                            | Customer records, user profile fields, operational logs.                         |
| restricted     | High-risk data requiring strict access, masking, encryption, hashing, audit, or retention controls. | Secrets, MFA material, access tokens, recovery codes, sensitive security events. |

Use the highest applicable classification for a field.

---

## 5. Sensitive Field Identification

Table docs must identify sensitive fields.

Sensitive field categories include:

- personal data
- contact information
- authentication data
- MFA data
- recovery material
- secrets
- API keys/tokens
- private keys
- authorization headers
- cookies/session-related values
- security events
- audit evidence
- customer business data
- exportable business records

Do not bury sensitive values in `jsonb` without documenting classification and redaction behavior.

---

## 6. Storage Protection Rules

Use the correct storage protection based on how the application uses the value.

| Need                                              | Storage Pattern                        |
| ------------------------------------------------- | -------------------------------------- |
| Application only verifies value                   | hash the value                         |
| Application must read value later                 | encrypt or vault-reference the value   |
| Application displays value                        | store safe display value only          |
| Application needs historical proof                | store redacted snapshot or audit event |
| Application needs flexible non-sensitive metadata | `jsonb` metadata may be acceptable     |

Never store raw secrets when a hash, encrypted value, or vault reference is sufficient.

---

## 7. Masking And Redaction

Sensitive fields must define display and log behavior.

Document whether a field is:

- never shown
- masked by default
- revealable with elevated access
- copyable with audit
- exportable
- redacted in logs
- redacted in audit metadata
- redacted from exceptions

Do not allow raw restricted data to appear in logs, audit metadata, validation errors, debug output, screenshots, or docs.

---

## 8. Export Eligibility

Database table docs should identify whether records or fields are exportable.

Export decisions should consider:

- classification
- actor permission
- target scope
- purpose/reason
- recent auth/elevation
- approval requirements
- audit requirements
- signed URL/expiration requirements
- data minimization
- masking or redaction

Viewing data and exporting data are separate capabilities.

Do not assume a user who can view a record may export all fields.

---

## 9. Retention Rules

Every sensitive or operationally important table should define retention expectations.

Retention documentation should answer:

- how long records are kept
- who owns retention decisions
- whether legal hold can override deletion
- whether audit records outlive source records
- whether records are anonymized or deleted
- whether deletion is soft, hard, or lifecycle-state based
- whether backups retain deleted data for a period
- what runbook or job performs cleanup

Do not leave retention behavior implicit for restricted or audit-sensitive data.

---

## 10. Deletion, Deactivation, And Anonymization

Deletion is not always the correct lifecycle action.

Use:

- deactivation when record history must remain linked
- anonymization when identity should be removed but business/audit integrity remains
- soft delete when recoverability matters
- hard delete when retention and references allow removal
- legal hold when evidence must be preserved

Do not hard-delete audit-linked identities by default when security, accounting, or forensic records require preservation.

---

## 11. Audit-Preserving Deletion

When deleting or anonymizing records tied to audit events, preserve audit meaning.

Audit-preserving deletion may require:

- replacing names/emails with redacted labels
- keeping internal identifiers
- preserving event timestamps
- preserving action/target/result
- removing unnecessary personal data
- recording deletion/anonymization event
- respecting legal hold

Do not erase audit trails just because a user or business record is removed.

---

## 12. Data Minimization

Store only what is needed.

Before adding a sensitive column, ask:

- why is this field needed?
- who can view it?
- who can edit it?
- is it exportable?
- can it be derived instead?
- can it be stored in a less sensitive form?
- what is the retention period?
- what happens on erasure or deactivation?

---

## 13. Seed And Test Data

Do not seed real sensitive data.

Test fixtures must not include:

- real customer data
- real emails except obvious fake domains
- real tokens
- real passwords
- real API keys
- real private data
- production screenshots with sensitive data

Use synthetic values.

Secrets in tests should be fake and clearly non-production.

---

## 14. Documentation Expectations

Table docs must identify:

- table classification
- sensitive fields
- restricted fields
- masking/redaction behavior
- retention behavior
- deletion/anonymization behavior
- export eligibility
- audit expectations

Schema changes involving sensitive data must update table docs and related DataGovernance/DataProtection planning or canonical docs.

---

## 15. Testing Expectations

Sensitive data changes should verify:

- restricted fields are not exposed in views
- restricted fields are not logged
- restricted fields are not returned in unauthorized responses
- export permissions are distinct from view permissions
- deletion/anonymization preserves required audit context
- seeders do not include real sensitive values
- encrypted/hashed fields behave as expected

---

## 16. Stop Conditions

Stop before adding or changing sensitive data when:

- classification is unclear
- owner is unclear
- export eligibility is unclear
- retention is unclear
- deletion/anonymization behavior is unclear
- raw secret storage is being considered
- audit preservation conflicts with erasure expectations
- masking or redaction behavior is not defined
- required docs cannot be updated accurately

---

## 17. Related

- [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)
- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Settings Data Governance Standards](Settings%20Data%20Governance%20Standards.md)
- [Database Audit And Evidence Standards](Database%20Audit%20And%20Evidence%20Standards.md)
- [Database Index](../../06-database/index.md)
- [Standards Index](../index.md)
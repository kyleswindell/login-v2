<!--
DOC-META
title: Database Audit And Evidence Standards
doc_type: standard
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/Database Audit And Evidence Standards.md
parent: docs/02-standards/database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines database standards for audit events, evidence records, actor/subject/target modeling, redaction, correlation, forensic readiness, retention, and evidence integrity.
-->

# Database Audit And Evidence Standards

This document defines database standards for audit and evidence records in Login App 2.0.

Audit data supports accountability, security review, troubleshooting, compliance, and forensic readiness.

---

## Purpose

Ensure audit and evidence tables are append-oriented, scoped, redacted, queryable, and useful for reconstructing important system activity.

Audit schema should answer who did what, to what, when, where, why, and with what result.

---

## Scope

This standard applies to database structures for:

- audit events
- audit event changes
- security events
- administrative actions
- sensitive data movement
- access-control changes
- settings changes
- service account activity
- evidence packages
- chain-of-custody records
- forensic timelines
- monitoring-to-audit correlation

This standard supports Core Audit and Forensics.

---

## Core Rule

Audit records must preserve meaningful evidence without exposing sensitive data.

An audit record should identify:

- actor
- action
- target
- result
- time
- scope
- source
- correlation/request/session context when available
- redacted metadata
- related change set when applicable

Do not log raw secrets, tokens, MFA material, authorization headers, cookies, private keys, passwords, or restricted personal data.

---

## Audit Event Shape

Audit events should support these fields or equivalents:

| Field          | Purpose                                                              |
| -------------- | -------------------------------------------------------------------- |
| event_id / id  | Stable audit event identity.                                         |
| occurred_at    | When the action occurred.                                            |
| actor_type     | User, service, system, integration, job, console, or unknown.        |
| actor_id       | Actor identifier when available.                                     |
| actor_label    | Safe display label or snapshot when needed.                          |
| action         | Stable event/action key.                                             |
| target_type    | Type of target affected.                                             |
| target_id      | Target identifier when available.                                    |
| target_label   | Safe display label or snapshot when needed.                          |
| result         | Success, failure, denied, error, skipped, or similar.                |
| scope_type     | Tenant, workspace, account, user, module, global, or platform scope. |
| scope_id       | Scope identifier when applicable.                                    |
| request_id     | Request identifier when available.                                   |
| correlation_id | Correlation identifier across services/jobs when available.          |
| session_id     | Session identifier when safe and useful.                             |
| ip_address     | Actor IP when applicable.                                            |
| user_agent     | User agent when applicable.                                          |
| metadata       | Redacted event metadata.                                             |

Exact column names may vary, but the event shape must support these concepts.

---

## Actor Model

Audit events must support human and non-human actors.

Actor types may include:

- user
- service
- system
- integration
- job
- console
- unknown

Do not assume every audit actor is a user.

Service/system actors should have stable names.

Examples:

- `service:nightly-inventory-reconciler`
- `integration:quickbooks`
- `job:send-notification-digest`
- `console:security-check`

---

## Action Key Rules

Audit action keys must be stable and explicit.

Use names like:

- `auth.login_succeeded`
- `auth.mfa_challenge_failed`
- `access.role_assigned`
- `settings.value_updated`
- `data.export_requested`
- `notifications.notification_sent`
- `service_account.token_revoked`

Avoid vague names:

- `updated`
- `changed`
- `saved`
- `processed`

Action keys should identify the capability or module owner.

---

## Target Model

Audit targets should identify what changed or what was accessed.

Targets may be:

- user
- role
- permission
- service account
- setting
- notification
- export
- customer
- order
- shipment
- module
- file
- record
- route
- system resource

If the target is deleted later, the audit event should still remain understandable through safe labels or snapshots.

---

## Result Model

Audit events should record result.

Common values:

- succeeded
- failed
- denied
- error
- skipped
- expired
- revoked
- approved
- rejected

Do not treat failed or denied actions as unimportant. Security-sensitive denials may be important audit evidence.

---

## Change Set Rules

For update actions, store change information safely.

Change sets should:

- identify changed fields
- redact sensitive values
- avoid storing raw secrets
- avoid storing large payloads unnecessarily
- identify old/new value summaries when safe
- preserve enough context to understand the change

For secret-bearing fields, record classification and change occurrence, not raw values.

Example summary:

| Field           | Old                  | New                  |
| --------------- | -------------------- | -------------------- |
| `smtp_password` | `[redacted:present]` | `[redacted:changed]` |

---

## Metadata Rules

Audit metadata should be `jsonb` when flexible details are needed.

Metadata must be redacted before storage.

Metadata should not become the only source of core relational facts. Use relational columns for actor, action, target, result, time, and scope.

---

## Append-Oriented Rule

Audit records should generally be append-oriented.

Do not update audit events except for narrowly controlled retention, correction, sealing, evidence packaging, or legal-hold workflows.

If audit correction is required, prefer a new correction event or evidence record rather than mutating historical facts.

---

## Evidence Package Standards

Evidence packages should support forensic export and investigation workflows.

Evidence package records should identify:

- package id
- purpose
- created by
- created at
- scope
- included event range
- included files or records
- hash or manifest when applicable
- storage location
- access controls
- retention/legal hold status

Evidence packages must not expose secrets or sensitive personal data beyond the approved investigation scope.

---

## Chain Of Custody

When evidence is collected, viewed, exported, sealed, transferred, or destroyed, record chain-of-custody events.

Chain-of-custody records should include:

- evidence package
- actor
- action
- time
- reason
- result
- destination or recipient when applicable
- hash/manifest reference when applicable

---

## Retention And Legal Hold

Audit and evidence retention must support security and legal needs.

Retention rules should identify:

- retention period
- deletion/anonymization behavior
- legal hold override
- restricted access behavior
- export behavior
- review owner

Do not delete audit records only because a related user or business record is deactivated.

---

## Index And Query Rules

Audit tables should support expected investigations.

Index for:

- occurred_at
- actor
- action
- target
- result
- scope
- request_id
- correlation_id
- security-sensitive action groups

Avoid storing audit records in a way that requires full table scans for common investigations.

---

## Documentation Expectations

Audit/evidence tables must document:

- event shape
- actor model
- action key namespace
- target model
- metadata redaction rules
- retention behavior
- access rules
- indexes
- related Core Audit services
- related forensic/runbook docs when applicable

---

## Testing Expectations

Audit behavior should verify:

- expected audit event is recorded
- denied or failed sensitive action is recorded when required
- metadata is redacted
- raw secrets are not stored
- actor and target are correct
- service/system actors are supported
- audit writes occur after successful transaction when required
- failure behavior is safe and documented

---

## Stop Conditions

Stop before designing audit/evidence schema when:

- raw sensitive values might be stored
- actor model only supports users
- target scope is unclear
- action keys are vague
- audit events would not be queryable by common investigation needs
- retention/legal hold behavior is unclear
- evidence export access control is unclear
- audit schema would be owned separately by each module rather than Core Audit

---

## Related

- [Database Data Classification And Retention Standards](Database%20Data%20Classification%20And%20Retention%20Standards.md)
- [Database Access Control Data Model Standards](Database%20Access%20Control%20Data%20Model%20Standards.md)
- [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)
- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Database Index](../../06-database/index.md)
- [Standards Index](../index.md)
<!--
DOC-META
title: Database Access Control Data Model Standards
doc_type: standard
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/Database Access Control Data Model Standards.md
parent: docs/02-standards/database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines database standards for IAM-style access control data including subjects, targets, roles, actions, groups, assignments, exceptions, expiration, elevation, reviews, and effective access.
-->

# Database Access Control Data Model Standards

This document defines database standards for access-control data in Login App 2.0.

The access model should support an IAM-style structure:

Subject → Target → Role → Actions

---

## Purpose

Ensure access-control tables can answer who can do what, where, why, how they received access, and when that access expires or must be reviewed.

Access-control data must be explicit, auditable, reviewable, and safe for Core Access to resolve.

---

## Scope

This standard applies to database structures for:

- users
- groups or access groups
- roles
- permissions/actions
- role-action mappings
- assignments
- direct assignment exceptions
- service accounts
- trusted/system actors
- access targets
- elevated access sessions
- access reviews
- effective access projections or views

This standard supports Core Access. It does not replace authorization policies, gates, or runtime access checks.

---

## Core Rule

Access-control schema must be able to answer:

- who is the subject
- what target is being accessed
- which role or action applies
- how the subject received access
- whether access is direct, inherited, group-based, service-based, or elevated
- when access expires
- why access exists
- who granted or changed it
- when it must be reviewed

If the schema cannot answer those questions, the access model is incomplete.

---

## Subject Model

A subject is an actor that can receive access.

Common subject types:

- user
- group
- service account
- system actor
- integration

Subject records should support:

- stable identifier
- subject type
- lifecycle status
- owner or scope when applicable
- display label
- audit history
- disabled/revoked/deactivated state

Do not treat every non-human actor as a normal user unless explicitly planned. Service accounts should have clear machine-identity semantics.

---

## Target Model

A target is the thing access applies to.

Targets may include:

- global platform
- Core capability
- Platform surface
- Business Module
- tenant
- workspace
- account
- customer
- record
- route group
- resource group
- environment

Access assignments should identify target scope clearly enough to compute effective access and prevent cross-scope leakage.

Do not store broad global assignments when scoped assignments are required.

---

## Role Model

A role is a named bundle of actions.

Roles should include:

- stable key
- display label
- description
- owner
- scope
- lifecycle status
- assignability
- whether it is system-defined or custom
- review requirements when applicable

Role keys must be stable after release.

Renaming role keys requires migration planning.

---

## Action / Permission Model

Actions are the smallest named authorization operations.

Actions should include:

- stable key
- owner capability or module
- description
- risk level when applicable
- target type
- whether the action is sensitive
- whether recent auth, MFA, elevation, approval, or audit is required

Avoid hard-coding permission strings in many places. Permission/action keys should be defined centrally by the owner.

---

## Role-Action Mapping

Role-action mappings should be explicit.

Mappings should identify:

- role
- action
- source
- lifecycle status
- whether the action is included by default or conditionally
- migration/seed source

Do not hide role-action behavior only in code branches or UI state.

Seeded role-action mappings must be deterministic and safe to rerun.

---

## Group Assignment Model

Groups or access groups should be the preferred assignment path for users.

Group assignment records should identify:

- group
- subject
- membership status
- scope when applicable
- assigned by
- assigned at
- reason when required
- expiration when applicable

Direct user assignments should be treated as exceptions, not the default assignment model.

---

## Direct Assignment Exception Model

Direct assignments should support governance.

Direct assignments should include:

- subject
- target
- role or action
- reason
- assigned by
- assigned at
- expires at when applicable
- review due at when applicable
- source
- status

The system should be able to list direct assignment exceptions for review.

Do not create unreviewable permanent direct assignments for sensitive access.

---

## Service Account Access

Service account access must be distinct and auditable.

Service account access should identify:

- service account
- owning system or integration
- target
- allowed actions or roles
- token or credential reference
- expiration
- rotation requirements
- last used metadata
- created by
- revoked by
- reason

Do not grant service accounts broad human admin access unless explicitly approved and audited.

---

## Elevated Access

Elevated access records should support temporary privileged access.

Elevated access should include:

- subject
- target
- elevated role or action
- reason
- approved by when applicable
- started at
- expires at
- ended at
- MFA/recent-auth requirement
- audit event reference
- status

Elevated access should be time-limited.

---

## Access Reviews

Access review data should support periodic review of sensitive assignments.

Access review records should identify:

- review target
- reviewer
- assignments reviewed
- decision
- reason
- review status
- due date
- completed date
- follow-up action

Reviews should distinguish:

- approved
- revoked
- changed
- deferred
- needs investigation

---

## Effective Access

The system should be able to compute or present effective access.

Effective access should answer:

- subject
- target
- action
- allowed or denied
- source path
- role
- group
- direct assignment
- elevated assignment
- expiration
- reason
- blocking condition when denied

Effective access may be computed dynamically or stored as a projection/view when needed, but it must not become stale or unreviewable.

---

## Expiration And Review Fields

Sensitive access data should support expiration and review.

Use fields such as:

- expires_at
- review_due_at
- revoked_at
- revoked_by
- reason
- status

Do not rely only on comments or issue history to track temporary access.

---

## Audit Requirements

Access-control changes must be audit-worthy.

Audit:

- role creation/update/deactivation
- action registration changes
- role-action mapping changes
- group membership changes
- direct assignment changes
- service account access changes
- elevated access start/end
- access review decisions
- failed or denied sensitive access when applicable

Audit records must not expose secrets or sensitive payloads.

---

## Testing Expectations

Access-control schema and behavior should verify:

- allowed access
- denied access
- group-derived access
- direct assignment exceptions
- expired access
- revoked access
- service account access
- elevated access expiration
- cross-scope denial
- effective access explanation when available

Do not only test Super Admin paths.

---

## Documentation Expectations

Access-control database changes should update:

- table docs under `docs/06-database/tables/`
- feature contracts under `docs/06-database/feature-contracts/`
- Core Access planning/docs
- Identity/Auth docs when subjects are affected
- audit docs when events are added
- security docs when sensitive access behavior changes

---

## Stop Conditions

Stop before designing access-control tables when:

- subjects are unclear
- target scope is unclear
- roles and actions are mixed together without a clear rule
- direct assignments cannot be reviewed
- service accounts are modeled as ordinary users without justification
- expiration/revocation semantics are missing
- effective access cannot be explained
- audit behavior is unclear
- tests for denied paths cannot be identified

---

## Related

- [Database Tenant Workspace Isolation Standards](Database%20Tenant%20Workspace%20Isolation%20Standards.md)
- [Database Audit And Evidence Standards](Database%20Audit%20And%20Evidence%20Standards.md)
- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)
- [Platform Boundary](../../03-architecture/platform-boundary.md)
- [Database Index](../../06-database/index.md)
- [Standards Index](../index.md)
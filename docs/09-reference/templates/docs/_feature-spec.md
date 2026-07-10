<!--
DOC-META
title: Feature Name
doc_type: feature
status: draft
owner: platform
canonical: true
canonical_path: docs/04-features/path-to-feature.md
parent: docs/04-features/index.md
template: docs/09-reference/templates/docs/_feature-spec.md
summary: One sentence describing the user, admin, platform, system, or business capability this feature document owns.
-->

# Feature Name

Parent: [Feature Index](../index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Scope](#3-scope)
  - [3.1. In Scope](#31-in-scope)
  - [3.2. Out of Scope](#32-out-of-scope)
- [4. Users And Actors](#4-users-and-actors)
- [5. Behavior Contract](#5-behavior-contract)
- [6. User / Admin Workflows](#6-user--admin-workflows)
- [7. UI Surfaces](#7-ui-surfaces)
- [8. Data Model](#8-data-model)
- [9. Permissions / Security](#9-permissions--security)
- [10. Tenant Or Workspace Considerations](#10-tenant-or-workspace-considerations)
- [11. Validation](#11-validation)
- [12. Notifications / Audit / Monitoring](#12-notifications--audit--monitoring)
- [13. Setup And Settings](#13-setup-and-settings)
- [14. Tests And Verification](#14-tests-and-verification)
- [15. Rollout Notes](#15-rollout-notes)
- [16. Known Gaps](#16-known-gaps)
- [17. Related](#17-related)

## 1. Purpose

State the feature ownership and behavior scope in one to two sentences.

## 2. Status

Status: draft | active | planned | implemented | superseded | archived

Implementation status summary:

- planned only | partially implemented | implemented | superseded
- local only | staged | deployed | not applicable
- automated verification | manual verification | not verified

## 3. Scope

### 3.1. In Scope

List behavior this feature owns.

### 3.2. Out of Scope

List related behavior owned elsewhere.

## 4. Users And Actors

Identify users, admins, operators, service accounts, integrations, or system actors involved.

| Actor   | Role  | Notes                   |
| ------- | ----- | ----------------------- |
| Example | Admin | What this actor can do. |

## 5. Behavior Contract

Describe what the feature does, what it must not do, and any important invariants.

## 6. User / Admin Workflows

List common workflows this feature supports.

1. Workflow name.
2. Expected path.
3. Expected result.

## 7. UI Surfaces

List routes, pages, panels, dashboards, widgets, forms, tables, modals, or reference surfaces.

| Surface | Owner                    | Route / Path | Notes    |
| ------- | ------------------------ | ------------ | -------- |
| Example | Platform / Core / Module | `/example`   | Purpose. |

## 8. Data Model

List tables, models, registry entries, options, config values, files, JSON payloads, or API contracts.

| Data Item | Owner                    | Purpose           |
| --------- | ------------------------ | ----------------- |
| Example   | Core / Platform / Module | Why this matters. |

## 9. Permissions / Security

Describe who can view, create, update, delete, export, approve, administer, or configure the feature.

List relevant policies, gates, permissions, route middleware, audit requirements, data protection rules, and abuse cases.

## 10. Tenant Or Workspace Considerations

Describe tenant isolation, workspace scoping, per-customer settings, environment behavior, or cross-tenant risks.

## 11. Validation

Describe server-side validation, client-side support behavior, form requests, constraints, and failure states.

## 12. Notifications / Audit / Monitoring

Describe notifications, audit events, monitoring signals, error logs, or operational alerts.

## 13. Setup And Settings

Describe setup entries, settings pages, preference surfaces, registry entries, defaults, and configuration ownership.

## 14. Tests And Verification

List expected automated tests, manual checks, visual checks, browser tests, or security checks.

| Check   | Type                              | Required |
| ------- | --------------------------------- | -------- |
| Example | Feature / Unit / Browser / Manual | Yes / No |

## 15. Rollout Notes

Describe migrations, backfills, release notes, operational cautions, compatibility concerns, or rollback notes.

## 16. Known Gaps

List incomplete behavior, accepted limitations, deferred slices, or follow-up issues.

## 17. Related

- [Feature Index](../index.md)
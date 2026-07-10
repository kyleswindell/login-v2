<!--
DOC-META
title: Coding Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Coding Standards.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines general coding rules for Laravel application code, ownership boundaries, naming, validation, services, tests, and implementation discipline.
-->

# Coding Standards

This document defines baseline coding standards for Login App 2.0 application code.

Use this standard with:

- [File Building Standards](File%20Building%20Standards.md)
- [Commenting Standards](Commenting%20Standards.md)
- [Testing Standards](Testing%20Standards.md)
- [Feature Development Standards](Feature%20Development%20Standards.md)

- [1. Purpose](#1-purpose)
- [2. Core Defaults](#2-core-defaults)
- [3. Ownership Model](#3-ownership-model)
- [4. Controllers](#4-controllers)
- [5. Services, Actions, Queries, And View Models](#5-services-actions-queries-and-view-models)
- [6. Validation](#6-validation)
- [7. Authorization](#7-authorization)
- [8. Naming](#8-naming)
- [9. Events And Logs](#9-events-and-logs)
- [10. Data And Security](#10-data-and-security)
- [11. Documentation Sync](#11-documentation-sync)
- [12. Related](#12-related)

---

## 1. Purpose

Keep application code readable, maintainable, testable, and aligned with the current Core / Platform / Business Module architecture.

---

## 2. Core Defaults

- Prefer small, focused classes.
- Keep controller methods thin.
- Put reusable behavior in the layer that owns the responsibility.
- Use Laravel Form Requests for non-trivial validation.
- Use migrations for database changes.
- Add or update tests for behavior that affects auth, access, audit, data boundaries, security, notifications, settings, or user-facing workflows.
- Prefer expressive names and extraction over explanatory comments.
- Add PHPDoc when it materially improves public contracts, static analysis, generics, array shapes, or non-obvious return structures.
- Do not introduce new dependencies, frameworks, packages, or architectural patterns without explicit approval.
- Do not mix unrelated cleanup into scoped implementation work.

---

## 3. Ownership Model

Use the current project ownership model.

| Layer            | Code Location                                                       | Owns                                                                                                                            |
| ---------------- | ------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| Core Capability  | `app/Core/*`                                                        | Required platform, security, identity, access, data, audit, monitoring, notification, settings, and system capabilities.        |
| Platform Surface | `app/Platform/*`                                                    | Shell, navigation, dashboard, setup, docs, UI reference, registry-driven presentation, and aggregation surfaces.                |
| Business Module  | `Modules/*`                                                         | Tenant/workspace business work areas such as Customers, Inventory, Orders, Shipments, Reports, Projects, Support, and Websites. |
| Shared UI        | `resources/views/components/*`, `resources/css/*`, `resources/js/*` | UI primitives, patterns, shell components, layouts, CSS tokens, JS controls, and UI reference support.                          |
| Docs             | `docs/*`                                                            | Canonical standards, architecture, features, flows, database contracts, planning, reference, and runbooks.                      |

Do not put all reusable behavior in `app/Platform/` by default. Reusable behavior belongs to the layer that owns the domain responsibility.

Examples:

- Authentication behavior belongs in Core Auth.
- Authorization behavior belongs in Core Access.
- Audit event recording belongs in Core Audit.
- Navigation aggregation may belong in Platform Navigation.
- Business order fulfillment behavior belongs in the Orders Business Module.

---

## 4. Controllers

Controllers should coordinate request handling and responses.

Controllers may:

- receive validated requests
- call actions, services, queries, or view models
- return responses, redirects, views, or resources
- enforce route-specific middleware and policy checks

Controllers must not:

- contain reusable business rules
- contain large query-building blocks that belong in queries/services
- bypass policies or gates
- perform broad side effects without a service/action owner
- become the only place where audit, notification, or data-protection behavior exists

---

## 5. Services, Actions, Queries, And View Models

Use focused application objects when controller, model, or component code begins to own too much behavior.

Use:

- services for reusable capability behavior
- actions for command-style mutations
- query objects for reusable reads
- view models or page data objects for complex view preparation
- policies/gates for authorization decisions
- form requests for request validation
- events/listeners/jobs for asynchronous or cross-cutting workflows

Place these objects under the owning layer.

Do not create abstractions before there is a clear need.

---

## 6. Validation

Use Laravel Form Requests when validation is non-trivial, repeated, security-sensitive, or likely to grow.

Validation belongs close to the request boundary.

Do not rely on UI validation alone.

Server-side validation must protect:

- required fields
- type and format constraints
- authorization-sensitive IDs
- cross-record ownership
- tenant/workspace scope
- file upload constraints
- export/download constraints
- security-sensitive actions

---

## 7. Authorization

Protected behavior must be authorized.

Use policies, gates, middleware, or Core Access services according to the owning capability.

Do not:

- hard-code role checks throughout controllers or views
- rely on hidden UI controls as authorization
- expose protected routes without authorization middleware
- let Business Modules redefine platform-level authorization behavior

Permission strings should be centralized in the owning Access, capability, or module definition.

---

## 8. Naming

Use explicit, searchable names.

Prefer names that identify:

- actor
- action
- target
- owner layer
- capability or module
- lifecycle state

Examples:

- `auth.login_succeeded`
- `access.role_assigned`
- `audit.event_recorded`
- `platform.navigation.built`
- `orders.shipment_created`

Use descriptive service names:

- `AuditEventRecorder`
- `EffectiveAccessResolver`
- `UserInvitationService`
- `PlatformNavigationBuilder`

## 9. Approved File Templates

Repository-owned file templates are maintained under `stubs/`.

Use an approved stub when one exists for the file being created. A stub provides a structural starting point only; generated output must still be completed, reviewed, formatted, tested, and approved.

Do not treat generated code as correct merely because it was produced from a repository template.

Stub ownership, placeholders, framework overrides, custom generators, and generated-output validation are governed by [Code Template And Generator Standards](Code%20Template%20And%20Generator%20Standards.md).

Keep Core, Platform, Module, tenant, workspace, user, account, and security concepts explicit until the domain model is mature enough to safely shorten names.

---

## 10. Events And Logs

Use explicit event names and payloads.

Events should describe what happened, not what listener should do.

Good:

- `auth.login_succeeded`
- `auth.mfa_challenge_failed`
- `access.elevated_session_started`
- `data.export_requested`
- `notifications.notification_created`

Avoid vague names:

- `user.updated`
- `thing.changed`
- `process.done`

Audit-worthy actions must use the audit pipeline owned by Core Audit.

Operational failures must use the appropriate logging/monitoring path.

---

## 11. Data And Security

Do not expose sensitive values in logs, exceptions, comments, test fixtures, docs, screenshots, or debug output.

Do not log:

- passwords
- tokens
- API keys
- MFA secrets
- recovery codes
- authorization headers
- cookies
- private keys
- raw sensitive personal data

Use explicit redaction and data-protection rules when handling restricted or confidential data.

Do not expose protected files through public storage.

Do not use state-changing GET routes.

---

## 12. Documentation Sync

When code changes behavior, update the relevant docs in the same work cycle.

Use:

- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [How To Write Docs](../documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../documentation/Doc%20Governance.md)

Document updates are required when code affects:

- architecture ownership
- user/admin behavior
- database schema
- flows
- operational procedures
- security rules
- API/webhook behavior
- UI component contracts
- agent/Codex behavior

---

## 13. Related

- [Commenting Standards](Commenting%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [Feature Development Standards](Feature%20Development%20Standards.md)
- [Testing Standards](Testing%20Standards.md)
- [Logging Standards](../logging/Logging%20Standards.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Standards Index](../index.md)
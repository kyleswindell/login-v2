
### 0.1. Feature Development Standards

```md
<!--
DOC-META
title: Feature Development Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Feature Development Standards.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines standards for developing Core capabilities, Modules, UI, Laravel integration, and owner-specific technical responsibilities with their documentation, permissions, settings, audit, and verification.
-->

# Feature Development Standards

This document defines development standards for discrete capabilities and surfaces in Login App 2.0.

- [1. Purpose](#1-purpose)
- [2. Current Vocabulary](#2-current-vocabulary)
- [3. Ownership Decision Before Implementation](#3-ownership-decision-before-implementation)
- [4. Layer Ownership](#4-layer-ownership)
  - [4.1. Core Capability](#41-core-capability)
  - [4.2. Module](#42-module)
  - [4.3. UI](#43-ui)
  - [4.4. Laravel Integration](#44-laravel-integration)
  - [4.5. Technical Responsibilities](#45-technical-responsibilities)
- [5. Canonical Feature Doc](#5-canonical-feature-doc)
- [6. UI Ownership Standard](#6-ui-ownership-standard)
- [7. Setup, Settings, And Preferences](#7-setup-settings-and-preferences)
- [8. Permissions](#8-permissions)
- [9. Audit, Monitoring, And Error Reporting](#9-audit-monitoring-and-error-reporting)
- [10. Data Table UX Standard](#10-data-table-ux-standard)
- [11. Tests And Verification](#11-tests-and-verification)
- [12. Planning And Close-Out](#12-planning-and-close-out)
- [13. Related](#13-related)

---

## 1. Purpose

Ensure new and changed functionality is planned, owned, implemented, documented, authorized, audited, and verified in the correct layer.

---

## 2. Current Vocabulary

Use current project vocabulary.

| Term                | Meaning                                                                                                                                   |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Core capability     | Required base-application behavior, state, coordination, infrastructure, and contracts under the Core owner.                             |
| Module              | Optional, cohesive feature package under `Modules/*`.                                                                                     |
| UI                  | Reusable Elements, Components, Patterns, Layouts, CSS, JavaScript, icons, contracts, tests, and review evidence.                         |
| Laravel integration | Application-wide framework bootstrap, registration, and thin adaptation that does not own application behavior.                         |
| Surface             | Owner-specific UI presentation and interaction layer; not an application owner.                                                          |
| Delivery Adapter    | Owner-local HTTP, API, console, webhook, queue, scheduler, or background invocation integration.                                         |
| Registry            | Host-owned mechanism that defines and resolves Extension Points and validates, collects, orders, and exposes Contributions.              |
| Feature Document    | Canonical behavior document under `docs/04-features/`, when an owner-specific capability or Surface has behavior to describe.            |

The word “feature” may still be used for canonical behavior documentation, but it must not erase the implementation owner.

Do not use “module” as a generic synonym for any capability. In the current architecture, a Module is an optional package owner.

Existing `app/Platform/*` paths are transitional current placement only. They establish no target ownership and are not a destination for new canonical work.

---

## 3. Ownership Decision Before Implementation

Before implementing new behavior, answer:

1. Is the owner a Core capability, Module, UI, Laravel integration, or a documentation/ops-only workflow owner?
2. Which layer owns the durable behavior?
3. Is the technical responsibility a Surface, Delivery Adapter, Registry, Action, Query, Contract, or another accepted role?
4. Which canonical doc owns the behavior?
5. Which routes, panels, views, commands, jobs, or APIs expose it?
6. Which database tables, config keys, registry entries, or payloads does it affect?
7. Which permissions, policies, gates, middleware, or access rules apply?
8. Which audit, monitoring, notification, or error-reporting behavior applies?
9. Which tests or manual review surfaces prove the change?
10. Which planning note or GitHub issue owns the implementation slice?
11. Which docs must be updated when the implementation is complete?

Record answers in the GitHub issue, planning note, or canonical document before broad implementation begins.

---

## 4. Layer Ownership

### 4.1. Core Capability

Use Core for required system capabilities such as:

- Auth
- Identity
- Access
- DataGovernance
- DataProtection
- Security
- Audit
- Monitoring
- Notifications
- Settings
- Preferences
- Support

Core must not contain business-module domain workflows unless the workflow is truly cross-cutting platform infrastructure.

### 4.2. Module

Use `Modules/*` for tenant/workspace business work areas.

Modules must consume Core capabilities for:

- auth
- access
- audit
- notifications
- settings/preferences
- data protection
- security
- monitoring

Modules must not redefine required Core infrastructure.

### 4.3. UI

Use UI for reusable primitives, patterns, shell components, component CSS, JS controls, contracts, tests, and reference examples.

UI must remain domain-free and must not own route behavior, authorization decisions, database access, or domain mutations.

### 4.4. Laravel Integration

Use Laravel integration for application-wide bootstrap, framework registration, and thin adaptation that cannot remain owner-local.

Laravel integration must delegate durable behavior to the applicable Core capability or Module and must not become a competing application owner.

### 4.5. Technical Responsibilities

Classify technical responsibility separately beneath the owner:

- a Surface is an owner-specific UI presentation and interaction layer;
- a Delivery Adapter exposes owner-controlled behavior through HTTP, API, console, webhook, queue, scheduler, or background invocation;
- a Host owns an extensible feature and its Registry;
- a Host-owned Registry defines and resolves Extension Points and validates, collects, orders, and exposes Contributions;
- Contributions remain owned by their Contributors.

A Surface must not own contribution discovery, validation, ordering, or assembly. Delivery Adapters and invocation channels are not Surfaces.

---

## 5. Canonical Feature Doc

When behavior is user/admin/system visible, create or update a canonical feature doc under:

- `docs/04-features/`

The feature doc must state:

- purpose
- implementation status
- behavior contract
- users and actors
- UI surfaces
- data model
- permissions/security
- tenant or workspace considerations
- validation
- notifications/audit/monitoring
- setup/settings when applicable
- tests and verification
- known gaps

Use:

- [Feature Spec Template](../../09-reference/templates/docs/_feature-spec.md)

Feature docs must link back to relevant planning notes while planning remains active.

Planning notes must link to the canonical feature doc.

---

## 6. UI Ownership Standard

Before implementing UI work, identify the UI owner:

- UI primitive
- UI pattern
- Core-owned account/admin surface
- Module-owned surface
- Filament/admin resource when appropriate
- Livewire/custom Blade surface when appropriate

Do not assume Filament owns all admin UI.

Filament may fit CRUD-heavy admin records, table/filter/detail viewers, operational admin forms, settings/setup pages, and platform-management records.

Filament may not fit specialized viewers, UI reference work, component library work, public/customer-facing pages, highly custom dashboards, or workflows where module/domain logic is the main concern.

Filament resources, pages, and actions must call existing services or actions for business mutations. They must not become the only place where business rules, audit logging, notification dispatching, or state transitions exist.

Every UI implementation must declare:

- surface owner
- route path or panel owner
- auth guard and permission gate/policy
- database or context owner
- canonical doc owner
- service/action owner for mutations
- manual visual review needs

Codex must not make independent visual design decisions for spacing, layout, hierarchy, or interaction changes without explicit direction.

---

## 7. Setup, Settings, And Preferences

Every new capability that has configuration must identify whether the behavior belongs to:

- Setup
- Settings
- Preferences
- Module configuration
- Environment/config file
- Database-backed registry or contribution system

A visible Setup or Settings entry must not ship until there is at least one real editable setting or meaningful view.

Stub pages with no useful fields must not ship as visible navigation entries.

Settings must be:

- permission-gated
- documented
- validated
- audited when changes are significant
- owned by the capability that defines the setting

Do not hard-code settings behavior only in views.

---

## 8. Permissions

Protected behavior must declare permissions before implementation is considered complete.

Permission planning should identify:

- ability/action
- subject/actor
- target/resource
- owning capability or module
- policy/gate/middleware location
- audit expectations
- tests for allowed and denied paths

Do not hard-code permission strings throughout the codebase.

Do not rely on UI visibility as authorization.

Modules must consume Core Access patterns rather than redefining authorization infrastructure.

---

## 9. Audit, Monitoring, And Error Reporting

Audit-worthy actions must flow through the audit pipeline owned by Core Audit.

Operational failures must flow through logging or monitoring owned by the appropriate Core capability.

At minimum, audit:

- settings changes
- role/permission changes
- MFA/security changes
- user lifecycle changes
- export/download requests for sensitive data
- destructive actions
- admin/security-sensitive actions

Monitoring should capture operational failures, failed jobs, health checks, anomalies, and security signals when applicable.

---

## 10. Data Table UX Standard

When a feature includes a tabular data view intended for regular operator use, provide a complete table interaction baseline unless the table is intentionally tiny or static.

Baseline expectations:

- search or filter capability
- pagination when row count can grow materially
- rows-per-page selector when useful
- visible result summary
- prominent row actions
- clear empty state
- accessible labels and controls
- permission-aware actions

Recommended app-owned Blade table order:

1. page title/subtitle row
2. optional stats row
3. table action row
4. filter row when scoped filters apply
5. table
6. footer controls:
   - bottom-left: rows selector and result summary
   - bottom-right: previous / page selector / next

Apply intelligently:

- use client-side behavior for small-to-medium in-memory lists
- use server-side filtering/pagination for large or expensive datasets
- avoid fake controls for tiny static tables

---

## 11. Tests And Verification

Every feature/capability change should define verification before implementation starts.

Use:

- feature tests for user-visible behavior and database effects
- unit tests for isolated service logic
- policy/access tests for protected behavior
- browser/manual visual review for design-sensitive UI
- regression tests for bug fixes
- docs checks when documentation behavior changes
- build checks when assets change

Test both successful and denied paths for auth/access-sensitive behavior.

---

## 12. Planning And Close-Out

Before implementation starts, confirm:

- issue scope is clear
- ownership area is identified
- canonical docs are identified
- affected data/security boundaries are understood
- verification is known
- UI review surface is known when applicable

Before completion, confirm:

- code is done for the accepted scope
- canonical docs reflect current behavior
- planning docs reflect implementation status
- tests or verification are recorded
- known gaps are explicit
- follow-up issues are tracked or reported

---

## 13. Related

- [Coding Standards](Coding%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [Testing Standards](Testing%20Standards.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Platform And Tenant Application Boundary](../../03-architecture/platform-boundary.md)
- [Feature Index](../../04-features/index.md)
- [Feature Spec Template](../../09-reference/templates/docs/_feature-spec.md)

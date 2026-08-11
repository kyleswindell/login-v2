# Core Capability Package Migration Planning

Status: Planning draft

## Purpose

Plan the migration from the current broad "module" and Platform vocabulary to the owner-first Core, Module, UI, and Laravel integration model.

This document owns sequencing and migration intent only. Final architecture vocabulary, registry schema contracts, route contracts, and code names must be promoted to their owning docs before implementation.

> **Decision 2.90 reconciliation:** A Surface is an owner-specific UI presentation and interaction layer. APIs, commands, webhooks, queues, schedulers, and background entry points are Delivery Adapters or invocation channels. Host-owned Registries define and resolve Extension Points and Contributions remain owned by their Contributors. Every `app/Platform/*` path below is transitional current placement only; it establishes no target ownership and must not receive new canonical work. Goal 3 must assign each responsibility to Core, a Module, UI, or Laravel integration before migration.

## Problem

The current implementation uses `Modules/*`, `Manifest`, `Category`, and `module_registry_entries` for every package-shaped contribution.

That has worked as a foundation, but it now hides important differences:

- `Auth`, `Account`, `Users`, `Roles`, `Settings`, `Setup`, `Notifications`, `Dashboard`, and future Access Control are core platform capabilities.
- `Docs Viewer`, `Security Checklist`, runtime readiness, and development tools are internal platform tools.
- `retired-reference-viewer` exists in the current tree as a transitional development artifact. It is not an acceptable business module, core capability, or planned platform feature set.
- Future `Customers`, `Inventory`, `Orders`, `Shipments`, `Reports`, `Projects`, `Support`, and Websites are business modules.

The implementation needs to preserve the useful manifest and contribution mechanics while making product ownership and runtime classification more precise.

## Current Implemented Package Inventory

Runtime packages currently backed by `Modules/*`:

| Package         | Current Type          | Target Classification                                                                   | Migration Notes                                                                                                                                                                                                           |
| --------------- | --------------------- | --------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `_Template`     | Template, not runtime | Module scaffolding template                                                             | Keep as a template and align it with the accepted Module package contract.                                                                                                                                                |
| `Account`       | `core` module         | Core identity/account capability                                                        | Owns current-user account surfaces and account-menu contribution. Target physical owner is `app/Core/Identity` with shared views under account/admin view paths.                                                          |
| `Auth`          | `core` module         | Core authentication capability                                                          | Owns authentication, MFA, password mechanics, sessions, recovery, and security notification types. Target physical owner is `app/Core/Auth`.                                                                              |
| `Dashboard`     | `core` module         | Core Dashboard capability with an owner-specific Surface and Host-owned widget Registry | Current `app/Platform/Dashboard` placement is transitional. Goal 3 assigns target Core placement; Modules may contribute widgets without transferring Contribution ownership.                                             |
| `Notifications` | `core` module         | Core communication capability                                                           | Owns persistent notification delivery, inbox state, notification type registry, settings/preference contributions. Target physical owner is `app/Core/Notifications`.                                                     |
| `Preferences`   | `core` module         | Core preferences capability                                                             | Owns personal defaults as account-level preference surfaces. Target physical owner is `app/Core/Preferences` if preferences grow beyond Identity-owned profile defaults and Notifications-owned notification preferences. |
| `Roles`         | `core` module         | Core access object capability                                                           | Owns role/action bundles, permission registry consumption, role CRUD, and role-assignment notifications. Target physical owner is `app/Core/Access`; it is not a business module.                                         |
| `Settings`      | `core` module         | Core Settings capability with an owner-specific Surface and Host-owned Registry         | Owns settings behavior and the Registry separately from presentation. Target Core placement remains `app/Core/Settings`; no new canonical presentation belongs under transitional `app/Platform/*`.                       |
| `Setup`         | `core` module         | Core Setup capability with an owner-specific Surface and Host-owned Registry            | Goal 3 assigns target Core placement. Setup workflows remain with their applicable Core capability or Module and contribute through declared Extension Points.                                                            |

Static manifest entries not yet backed by `Modules/*`:

| Key                        | Current Type                 | Target Classification                                   | Migration Notes                                                                                                                                                                                                               |
| -------------------------- | ---------------------------- | ------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `users`                    | `core` module                | Core identity lifecycle capability                      | Should be planned under `app/Core/Identity` before Access Control builds on user subjects.                                                                                                                                    |
| `logging`                  | `core` module                | Core audit capability                                   | Should own audit evidence under `app/Core/Audit`; platform audit views remain presentation.                                                                                                                                   |
| `ui-system`                | `core` module                | UI infrastructure                                       | UI owns reusable presentation infrastructure; it is not a Core capability or Module. Shared components remain under `resources/views/components`.                                                                             |
| `runtime-security`         | `core` module                | Core application security infrastructure                | Target owner is `app/Core/Security` for cross-cutting guardrails such as security headers, route sensitivity, safe redirects, request redaction, and release checks.                                                          |
| `docs-viewer`              | `platform_management` module | Internal Module candidate                               | Current `app/Platform/Docs` placement is transitional. Goal 3 must assign an explicit Core or Module owner before migration.                                                                                                  |
| `retired-reference-viewer` | `platform_management` module | Transitional artifact to ignore/retire                  | Do not plan it as a module, core capability, or platform feature set. Do not include it in target architecture.                                                                                                               |
| `security-checklist`       | `platform_management` module | Internal platform tool over security/readiness evidence | Keep as an internal tool. It may consume evidence from `app/Core/Security`, `app/Core/Access`, `app/Core/Identity`, `app/Core/DataProtection`, `app/Core/Audit`, or `app/Core/Monitoring`, but it should not own enforcement. |
| `runtime-readiness`        | `platform_management` module | Internal platform tool                                  | Command/readiness package, not a business module.                                                                                                                                                                             |
| `development-tools`        | `platform_management` module | Internal platform tool                                  | Development-only package.                                                                                                                                                                                                     |

## Target Taxonomy

Use these product and architecture terms:

```text
Core platform capability package
  Required or baseline platform/security/system capability.

Internal platform tool package
  Operator, developer, readiness, or documentation tooling.

Business module package
  Workspace or tenant business feature area that users perform work inside.

Integration package
  External provider integration that contributes behavior to core capabilities or modules.
```

The visible product taxonomy should be:

```text
Account
Administration
  Users
  Access Control
  Audit Log
  System Settings
Workspace
  Dashboard
Business Modules
  Customers
  Inventory
  Orders
  Shipments
  Reports
```

Do not describe `Users`, `Access Control`, `Auth`, `Roles`, `DataGovernance`, `DataProtection`, `Settings`, `Setup`, `Notifications`, `Audit`, `Monitoring`, or current transitional `logging` metadata as business modules.

## Target Physical Ownership Direction

Use this physical ownership direction for future migration planning:

```text
app/Core/
  Auth/
  Identity/
  Access/
  DataGovernance/
  DataProtection/
    Dlp/
  Security/
    OffensiveTesting/
    Secrets/
    SupplyChain/
    VulnerabilityManagement/
  Audit/
    Forensics/
  Notifications/
  Preferences/
  Settings/
  Monitoring/
    ThreatDetection/
      DataExfiltration/

Modules/
  Customers/
  Inventory/
  Orders/
  Shipments/
  Reports/
  _Template/
```

Ownership rule:

```text
app/Core      = auth, identity, access, data governance, data protection, application security guardrails, audit, notifications, preferences, settings, monitoring, and security-sensitive domain logic
Modules/*     = optional, cohesive feature packages
resources/*   = UI system, Blade components, CSS, JS, and patterns
Laravel integration locations = application-wide framework bootstrap, registration, and thin adaptation
app/Platform/* = transitional current placement only; Goal 3 assigns every retained responsibility to Core, a Module, UI, or Laravel integration
```

Keep `App\Models\User` as the Laravel authenticatable model. Identity lifecycle logic, profile/security state, invitations, lifecycle history, and session metadata should live under `app/Core/Identity` once implemented.

Core capability rules:

```text
Core/Auth            = can the user prove identity?
Core/Identity        = who is the user and what lifecycle state are they in?
Core/Access          = what can the user do?
Core/DataGovernance  = what data may exist, why it exists, who owns/stewards it, and how privacy rights, purpose, quality, and retention intent are handled?
Core/DataProtection  = how is data classified, masked, exported, retained, erased, protected, and evaluated for DLP movement risk?
Core/Security        = what cross-cutting app security guardrails apply?
Core/Security/Secrets = how are credentials inventoried, redacted, revealed, rotated, and health-checked?
Core/Audit           = what happened, and what evidence can reconstruct it?
Core/Notifications   = what durable system/user messages exist?
Core/Preferences     = what user-owned defaults/preferences exist?
Core/Settings        = how is the system configured?
Core/Monitoring      = what broke or needs operational attention, including exfiltration-style signals?
Platform/Shell       = how the app exposes header/nav/page frame UI
Modules/*            = business work areas
```

## Folder Role Contract

Use the same internal folder vocabulary for core capabilities and business modules where it fits:

```text
Actions/        transactional use cases
Services/       reusable domain services
Models/         owned Eloquent models
Data/           DTOs and value objects
Enums/          statuses, types, and lifecycle states
Queries/        table/list/report query builders
Policies/       Laravel authorization policies
Rules/          domain validation rules
Events/         domain/application events
Listeners/      event listeners
Jobs/           queued jobs
Notifications/  Laravel notifications or notification definition helpers
Observers/      Eloquent observers
Http/           controllers, requests, middleware
Routes/         route files
Database/       migrations, factories, seeders when package-local storage is approved
Support/        small helpers, resolvers, builders
Exceptions/     domain-specific exceptions
Providers/      service providers
ViewModels/     Blade/admin page data composers
```

Controller/action/service/query split:

```text
Controller = validates and delegates
Action     = performs a single workflow
Service    = reusable domain logic
Query      = prepares readable/filterable data
Model      = persistence and relationships
Policy     = authorization gate
```

## Route, View, And Database Direction

Route direction:

```text
app/Core/Auth/Routes/auth.php
app/Core/Identity/Routes/account.php
app/Core/Identity/Routes/admin-users.php
app/Core/Access/Routes/admin-access.php
app/Core/DataGovernance/Routes/admin-data-governance.php
app/Core/DataProtection/Routes/admin-data-protection.php
app/Core/Security/Routes/admin-security.php
app/Core/Audit/Routes/admin-audit.php
app/Core/Notifications/Routes/notifications.php
app/Core/Preferences/Routes/account-preferences.php
app/Core/Settings/Routes/admin-settings.php
app/Core/Monitoring/Routes/admin-monitoring.php

Modules/Customers/Routes/web.php
Modules/Inventory/Routes/web.php
Modules/Orders/Routes/web.php
Modules/Shipments/Routes/web.php
```

Keep current URLs stable during migration. Future route names should move toward clear ownership:

```text
account.profile.*
account.security.*
admin.users.*
admin.access.*
admin.audit.*
admin.settings.*
notifications.*
account.preferences.*

customers.*
inventory.*
orders.*
shipments.*
```

View direction:

```text
resources/views/components/     UI primitives, shell components, and patterns
resources/views/account/        current-user account pages
resources/views/admin/users/    privileged user administration
resources/views/admin/access/   access control administration
resources/views/admin/data-governance/ data governance administration
resources/views/admin/audit/    audit log presentation
resources/views/admin/settings/ settings presentation
resources/views/admin/monitoring/ operational error/health presentation

Modules/{Module}/resources/views/
```

Recommended view composition direction:

```text
Core/admin/account views live centrally under resources/views.
Module views live under Modules/{Module}/resources/views.
UI components and patterns live under resources/views/components.
Owner-specific Surface renderers remain with the owning Core capability or Module and consume Contributions resolved by the Host-owned Registry. Current app/Platform/Surfaces placement is transitional only.
```

Module views should remain Module-owned. Core admin/account URL views should stay thin, compose reusable UI patterns with ViewModel/PageData, and avoid raw repeated table, action, form, authorization, and query logic. Renderers should be used only for owner-specific Surfaces that consume resolved Registry output, such as Settings, Preferences, Setup, Dashboard widgets, and evidence/check summaries.

View Surface sequencing is tracked in [View Surface Composition Planning](../03-platform-surfaces/view-surface-composition-planning.md); that planning folder name is transitional and does not establish target ownership.

Database direction:

- keep `database/migrations` as the primary migration location while core schema is still evolving
- keep `database/seeders` as the primary seeder location during transition
- use package-local `Database/` folders only after a package-family convention is approved
- do not mix root and package-local migrations randomly inside the same capability

This keeps schema review centralized until the core/business split is stable.

## Business Module Template Direction

Root `Modules/_Template` should become explicitly business-module focused.

Target business module skeleton:

```text
Modules/Example/
  Actions/
  Data/
  Database/
  Definitions/
  Enums/
  Events/
  Exceptions/
  Http/
  Jobs/
  Listeners/
  Models/
  Notifications/
  Observers/
  Policies/
  Providers/
  Queries/
  Reports/
  Routes/
  Services/
  Support/
  ViewModels/
  resources/
  tests/
```

Business module template additions should include:

```text
Definitions/{Module}Governance.php
Definitions/{Module}DataAssets.php
docs/data-governance.md
docs/privacy.md
tests/Feature/Security/{Module}GovernanceTest.php
```

Do not use `_Template` for Auth, Account, Users, Access Control, Audit, Settings, Setup, Notifications, Preferences, Monitoring, Dashboard, Docs, or other core/platform systems after this direction is accepted. Do not use it for `retired-reference-viewer`; that artifact is not part of the target architecture.

## Package And Contribution Model

The current manifest model should survive, but the names should change.

Target language:

| Current Term          | Target Term                                                                                                      |
| --------------------- | ---------------------------------------------------------------------------------------------------------------- |
| module manifest       | package manifest                                                                                                 |
| module definition     | package definition                                                                                               |
| module repository     | package catalog or package repository                                                                            |
| module registry entry | package registry entry                                                                                           |
| module contribution   | package contribution                                                                                             |
| module key            | retain as `module_key` only for Module identity; use `owner_key` or `capability_key` for those distinct meanings |
| module type/category  | package classification                                                                                           |

Important distinction:

- `ownership_area` identifies `core`, `module`, or `ui` source-of-truth ownership.
- `owner_key` identifies the precise behavior and contract owner.
- `capability_key` identifies stable functional behavior independent of physical ownership.
- `module_key` is reserved for optional Module identity independently from its Composer package.
- A future `package_key` is valid only if packaging becomes a materially distinct application identity; it must not duplicate `module_key`.

During transition, existing `module_key` columns can remain compatibility storage. New docs and future schema should avoid expanding that name into core capability contexts.

## Registry Projection Direction

Keep code-owned package manifests as canonical. Keep DB rows as synced projections.

Current registry tables:

- `module_registry_entries`
- `notification_registry_entries`
- `settings_registry_entries`
- `setup_registry_entries`
- `preference_registry_entries`
- `permission_registry_entries`

Target direction:

- Replace or alias `module_registry_entries` as `package_registry_entries` in a future schema contract.
- Add owner classification to package/contribution projections before broad business module rollout.
- Rename contribution ownership language from `module_key` to `owner_key` where the field identifies ownership; retain `module_key` where it identifies an optional Module.
- Preserve compatibility readers while old rows and tests still expect `module_key`.
- Do not let DB rows define executable routes, views, handlers, permissions, notification types, or package behavior.

Recommended eventual projection fields:

```text
package_name
package_classification
ownership_area
owner_key
capability_key
module_key
is_core
is_business_module
is_internal_tool
default_state
installed_by_default
default_enabled
disableable
tenant_eligible
source_hash
synced_at
stale flags
```

Exact schemas belong in `docs/06-database/` after this planning direction is accepted.

## Current Package Migration Draft

Existing folder migration map:

| Current Location                      | Target Owner                                                           | Notes                                                                                                                                                                          |
| ------------------------------------- | ---------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `Modules/Auth`                        | `app/Core/Auth`                                                        | Authentication, MFA, password, recovery, recent authentication, and session assurance logic.                                                                                   |
| `Modules/Account`                     | `app/Core/Identity` plus account views                                 | Current-user self-service identity/account surfaces.                                                                                                                           |
| `Modules/Roles`                       | `app/Core/Access`                                                      | Roles, permissions/actions, permission registry, role CRUD, and assignment guardrails.                                                                                         |
| `Modules/Preferences`                 | `app/Core/Preferences`                                                 | User-owned preferences should remain distinct from admin-owned system settings. Identity can own profile-level defaults; Notifications owns notification-specific preferences. |
| `Modules/Settings`                    | `app/Core/Settings` plus its owner-specific Surface                    | Settings storage and Registry behavior remain separate from Surface presentation.                                                                                              |
| `Modules/Setup`                       | Goal 3 Core placement plus capability- or Module-owned setup workflows | Setup Surface and Host Registry remain Core-owned; specific workflows remain with their owning Core capability or Module.                                                      |
| `Modules/Dashboard`                   | Goal 3 Core Dashboard placement                                        | Dashboard owns its Surface and Host Registry separately; Modules may contribute widgets. Current `app/Platform/Dashboard` is transitional only.                                |
| `Modules/Notifications`               | `app/Core/Notifications`                                               | Shared notification backbone, inbox state, and delivery.                                                                                                                       |
| `resources/views/platform/users`      | `resources/views/admin/users` or `app/Core/Identity` views             | User administration views are core identity administration, not business module views.                                                                                         |
| `resources/views/platform/audit-logs` | `resources/views/admin/audit` or `app/Core/Audit` views                | Audit views are an owner-specific Core Audit Surface over Core Audit records.                                                                                                  |
| `resources/views/platform/docs`       | Explicit Core or Module owner assigned by Goal 3                       | Current `app/Platform/Docs` placement is transitional; no new canonical work belongs there.                                                                                    |
| `retired reference viewer views`      | No target owner                                                        | Transitional development artifact to ignore/retire. Do not plan it as a module, core capability, or platform feature.                                                          |
| `resources/views/platform/security`   | Internal tool or core security capability after scope review           | Do not classify as a business module.                                                                                                                                          |

Do not execute these moves in one broad rename. The map is the endpoint for scoped migration batches.

### Account

Target: `app/Core/Identity` account/self-service capability.

Keep:

- `Account` package boundary.
- Account menu contribution.
- Account tabs and self-service page ownership.

Change later:

- Stop describing Account as a module.
- Use `account` as a core capability owner key.
- Keep business module contributions out of Account except through declared preference/page extension points.

### Auth

Target: `app/Core/Auth` authentication/security capability.

Keep:

- Auth-owned password, MFA, step-up, login, logout, recovery, and security notification types.
- No business-module classification.

Change later:

- Promote Auth language from module to core security package.
- Ensure security notification types use owner type `core`.
- Keep Auth separate from Identity: Auth proves identity and manages sessions/password/MFA; Identity owns user lifecycle and account state.
- Classify current Google Authenticator/TOTP as true MFA and the current first strong-authentication layer, not the final authentication architecture.
- Preserve a path to WebAuthn/passkeys/security keys for future phishing-resistant MFA, especially for Super Admin and elevated-access workflows.

### Users

Target: `app/Core/Identity` lifecycle capability.

Current gap:

- Users is static manifest metadata and transitional platform routes, not an `app/Core/Identity` capability yet.

Migration:

1. Rename planning direction from "Users module" to "Users core identity capability."
2. Package current user-management routes/controllers/requests only after lifecycle boundaries are documented.
3. Preserve role assignment through Roles and password/MFA through Auth.
4. Do not deepen direct role assignment before Access Control group/policy planning is ready.

### Roles

Target: `app/Core/Access` access object capability.

Keep:

- Role CRUD.
- Permission catalog backed by package-declared permission definitions.
- Role metadata, stale permission handling, and role-assignment notifications.

Change later:

- Stop describing Roles as a module in product language.
- Treat Roles as an Access Control child surface in navigation, while preserving Roles-owned code and data.
- Keep permission registry owner fields compatible while introducing package/owner language.

### Access Control

Target: `app/Core/Access` IAM/authorization capability.

Migration:

1. Plan Access Control as a core capability package, not a business module.
2. Aggregate Users, Groups, Roles, Permissions/Actions, Policies, Effective Access, Elevated Access, Access Reviews, and Audit Log.
3. Keep code ownership split during transition: Roles owns roles until migrated into `app/Core/Access`, Identity/Users owns identity lifecycle, Auth owns authentication until migrated into `app/Core/Auth`, Audit owns audit evidence, and Notifications owns delivery.

Access Control sequencing is tracked in [Access Control Implementation Planning](access-control-implementation-planning.md).

### Data Governance

Target: `app/Core/DataGovernance` data ownership, stewardship, purpose, privacy-rights, and data-quality capability.

Migration:

1. Treat Data Governance as a core policy/ownership capability, not a business module and not a DataProtection dashboard.
2. Plan data domains, data owners, data stewards, processing purposes, consent metadata, privacy request workflows, data quality issue workflows, and retention policy intent under `app/Core/DataGovernance`.
3. Keep enforcement split: DataGovernance defines purpose, ownership, privacy-right behavior, and retention intent; DataProtection enforces classification, redaction, masking, secure exports, DLP, retention execution, and erasure/anonymization execution.
4. Keep privacy request workflows admin-operated first; do not build a public self-service privacy portal until product/legal requirements exist.

Data Governance sequencing is tracked in [Privacy And Data Governance Planning](privacy-data-governance-planning.md) and the [Data Domain Governance Matrix](data-domain-governance-matrix.md).

### Data Protection

Target: `app/Core/DataProtection` data security capability.

Migration:

1. Treat Data Protection as a core cross-cutting capability, not a business module and not a sidebar-only admin page.
2. Plan classification, sensitive-field metadata, redaction, masking, secure export rules, retention execution, erasure/anonymization execution, backup/recovery expectations, and DLP data-movement policy under `app/Core/DataProtection`.
3. Keep enforcement split: DataGovernance defines ownership, purpose, privacy-right support, and retention policy intent; Access decides who may perform sensitive actions; Auth proves identity and step-up; Audit records evidence; Monitoring detects abnormal use and exfiltration-style signals; Notifications alerts affected users or security owners; and business modules own their domain records.

Data Protection sequencing is tracked in [Data Protection Core Planning](data-protection-core-planning.md).
Privacy and Data Governance sequencing is tracked in [Privacy And Data Governance Planning](privacy-data-governance-planning.md).
DLP and exfiltration sequencing is tracked in [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md).

### Application Security

Target: `app/Core/Security` cross-cutting application guardrail capability.

Migration:

1. Treat Application Security as enforceable middleware, services, tests, and release checks, not a business module and not a replacement for Auth, Access, DataProtection, Audit, Monitoring, or Notifications.
2. Plan security headers, CSP support, route security tiers, safe redirects, signed download validation helpers, request payload redaction, upload security hooks, and security release checks under `app/Core/Security`.
3. Treat offensive security as an optional `Core/Security/OffensiveTesting` subcapability for authorized test scope metadata, evidence contracts, DAST/pen-test planning inputs, and retest support after Vulnerability Management can own findings.
4. Treat secrets management as a `Core/Security/Secrets` subcapability for secret inventory metadata, credential-specific redaction patterns, reveal/copy/rotation guardrails, expiry/health inputs, and future vault integration boundaries.
5. Treat software supply chain security as a `Core/Security/SupplyChain` subcapability for dependency inventory, SBOM metadata, build artifact identity, release evidence, supply-chain release gates, and accepted supply-chain risk metadata.
6. Treat vulnerability management as a `Core/Security/VulnerabilityManagement` subcapability for asset inventory metadata, finding lifecycle, risk scoring, release gates, and accepted risk.
7. Keep Security Checklist as an internal tool that may display evidence from security checks, but does not own app security enforcement.

Application Security sequencing is tracked in [Application Security Core Planning](application-security-core-planning.md).
Offensive Security sequencing is tracked in [Offensive Security And Penetration Testing Planning](offensive-security-penetration-testing-planning.md).
Secrets Management sequencing is tracked in [Secrets Management Core Planning](secrets-management-core-planning.md).
Software Supply Chain Security sequencing is tracked in [Software Supply Chain Security Planning](software-supply-chain-security-planning.md).
Vulnerability Management sequencing is tracked in [Vulnerability Management Core Planning](vulnerability-management-core-planning.md).

### Notifications

Target: `app/Core/Notifications` communication/attention capability.

Keep:

- Notification type registry.
- Persistent notification delivery.
- Inbox/read/dismiss state.
- Personal notification preference contribution.
- Settings contribution for notification defaults.

Change later:

- Rename `module_key` display labels to owner/package language.
- Ensure future business modules produce notification triggers through type declarations but do not own delivery.

### Settings

Target: `app/Core/Settings` for settings logic, with platform/admin presentation where needed.

Keep:

- Settings shell.
- Settings value storage.
- Settings page contribution aggregation.

Change later:

- Treat contributed settings pages as package contributions, not module-only contributions.
- Use Settings as the administration surface, not as the owner of every setting's business meaning.

### Setup

Target: Core-owned Setup Surface and Host Registry in Goal 3-approved placement, with setup workflows owned by the relevant Core capability or Module.

Keep:

- Setup shell.
- Setup screen contribution aggregation.

Change later:

- Treat setup screens as package contributions.
- Do not add setup pages for core capabilities unless they have real setup work.

### Preferences

Target: `app/Core/Preferences` when preferences become large enough to justify a standalone core capability.

Keep:

- Personal defaults preference page.
- Preference registry contribution.

Review later:

- Decide whether Preferences remains its own package or becomes an Account-owned contribution helper.
- Keep user-level preference pages distinct from system Settings.
- Keep notification-specific preferences in `app/Core/Notifications`.
- Keep profile/lifecycle data in `app/Core/Identity`.

### Dashboard

Target: Core-owned Dashboard Surface and Host Registry in Goal 3-approved placement. Current `app/Platform/Dashboard` is transitional only.

Keep:

- Dashboard route and layout state.
- Future dashboard widget contribution surface.

Change later:

- Modules may contribute widgets while retaining ownership of their Contributions.
- Dashboard remains a Core capability with a Surface and a separate Host-owned Registry, not a Module.

### Audit

Target: `app/Core/Audit` accountability, audit evidence, and digital forensics readiness capability.

Current gap:

- Static manifest metadata and platform routes exist under logging-oriented names, but Audit is not yet promoted to `app/Core/Audit`.

Migration:

1. Plan Audit as the owner of human and service audit events.
2. Keep service audit events in Core/Audit when the actor is a service, system, integration, job, or console command.
3. Keep feature packages as owners of audit event semantics while Core/Audit owns storage, logger APIs, retention, redaction, query behavior, and admin audit views.
4. Treat `app/Core/Audit/Forensics` as optional support for forensic timeline queries, evidence package metadata, evidence hashing, manifests, chain-of-custody metadata, and formal evidence exports when incident workflows require them.
5. Keep Monitoring responsible for operational evidence sources such as errors, failed jobs, health checks, and detection signals.
6. Keep Incident Response runbook-owned for human evidence preservation and containment procedures.
7. Do not promote error logs into Audit; error logs belong to Monitoring.
8. Do not treat digital forensics readiness as a business module, forensic lab tool, legal case-management system, endpoint acquisition tool, or raw server log collector.

Digital forensics sequencing is tracked in [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md) and the [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md).

### Monitoring

Target: `app/Core/Monitoring` operational error and health capability.

Current gap:

- Error log views and audit log views are both represented in platform-facing surfaces today, but they are different systems.

Migration:

1. Keep Audit focused on intentional domain/security history: who did what.
2. Move error logs, exceptions, failed jobs, health checks, and operational failure records toward Monitoring: what broke.
3. Allow Monitoring to create persistent notifications for critical operational issues, while keeping the error/health record as the source of truth.
4. Keep operations that are both accountable and broken eligible to write both an Audit event and a Monitoring error/telemetry record.

### Internal Tools

Target: internal platform tool packages.

Includes:

- Docs Viewer
- Security Checklist
- Runtime Readiness
- Development Tools

Migration:

- Do not classify these as business modules.
- Keep tenant eligibility false by default.
- Keep them out of customer/workspace business module lists.
- Consider a separate `internal_tool` package classification.

`retired-reference-viewer` is excluded from this target list. Treat it as a current transitional development artifact to ignore/retire, not as an internal platform tool package.

## Dependency Direction

Core dependency direction:

```text
Auth depends on Identity
Access depends on Identity
DataGovernance depends on Identity, Access, Audit, Monitoring, Notifications, and Settings boundaries
DataProtection depends on DataGovernance, Identity, Access, Auth, Audit, Monitoring, Notifications, and Settings boundaries
Security provides cross-cutting guardrails used by Core and Modules
Notifications depend on Identity and Access
Audit accepts events from everything
Settings are read by everything
Modules may depend on Core and UI
Core presentation may depend on UI; Core business and system logic may not
UI must not depend on Core or Module domain implementation
Laravel integration may compose public Core and Module contracts without owning application behavior
Core must not depend on optional Modules
```

More explicit flow:

```text
Core/Auth
  reads Identity
  writes Audit
  creates Notifications

Core/Identity
  writes Audit
  creates Notifications
  calls Auth for session/password/MFA operations when needed

Core/Access
  reads Identity
  writes Audit
  creates Notifications

Core/DataGovernance
  reads Identity for data subjects and users
  reads Access for owner/steward/admin permissions
  writes Audit for governance and privacy request history
  informs Monitoring about overdue reviews, privacy request SLA issues, and data quality issue signals
  creates Notifications for owner/steward/privacy request alerts

Core/DataProtection
  reads DataGovernance for owner, purpose, privacy-right behavior, retention intent, and quality expectations
  reads Settings for handling policy defaults
  calls Access for export/sensitive-action authorization
  calls Auth for recent-authentication or MFA step-up when policy requires it
  writes Audit for sensitive data access/export/retention/erasure events
  informs Monitoring about sensitive activity categories
  creates Notifications for high-risk sensitive data events

Core/Security
  reads Settings for security guardrail defaults where configurable
  provides security headers, route tiers, request redaction, safe redirects, signed download helpers, vulnerability-management helpers, and release-check helpers
  does not own Auth, Access, DataProtection, Audit, Monitoring, Notification, or business workflow decisions

Core/Notifications
  reads Identity
  checks Access before rendering target actions
  optionally writes Audit for security-critical notification state changes

Core/Settings
  is read by Auth, Access, Notifications, Platform, and Modules

Core/Monitoring
  records operational errors and health state
  creates Notifications for critical operational issues

Platform/Shell
  reads Notifications, Navigation, Preferences, and Access-filtered navigation data
  does not own notification, identity, or access business rules

Platform/Surfaces
  renders registry-driven surfaces such as Settings, Setup, Preferences, Dashboard widgets, and evidence summaries
  consumes typed definitions and ViewModel/PageData
  does not render every CRUD page or replace Blade composition

Modules/*
  follow Core/Security route, request, upload/download, and test guardrails
  call Access for authorization
  register data domains, data assets, owners/stewards, processing purposes, and privacy behaviors with DataGovernance
  register classifications, sensitive fields, export rules, and handling controls with DataProtection
  call Audit for sensitive history
  call Notifications for user-facing events
```

Security, Data Governance, Data Protection, Audit, Monitoring, and Notifications remain separate:

```text
Security       = what app guardrails apply
DataGovernance = why data exists, who owns it, and what privacy/quality/retention intent applies
DataProtection = how data should be technically handled and enforced
Audit          = who did what
Monitoring     = what broke or looks abnormal
Notification   = who needs to know
```

## Implementation Sequence

### 1. Vocabulary Decision

Decide the canonical code vocabulary before more packages are added:

- use `Package` as the umbrella technical term
- reserve `Module` for optional, cohesive feature packages
- use `Core Capability` for required base-application behavior
- use `Internal Tool` for operator/developer support packages

### 2. Architecture Documentation Update

Update architecture docs to introduce:

- package catalog
- core capability packages
- Module packages
- internal tool packages
- package contributions
- Modules as one owner classification, not the whole system
- the physical ownership split among Core, Modules, UI, and Laravel integration, with `app/Platform/*` retained only as transitional current placement

Candidate docs:

- `docs/03-architecture/module-system.md`
- `docs/03-architecture/platform-boundary.md`
- `docs/03-architecture/workspace-identity-model.md`

### 3. Planning Terminology Correction

Update current planning docs that now reinforce old language:

- Access Control planning
- Users planning
- module layout convention planning
- module UI surface planning
- registry/workspace vocabulary planning
- Phase 4 remaining module planning

### 4. Runtime Compatibility Layer

Before renaming classes, add compatibility vocabulary:

- keep `Manifest` while introducing `PackageManifest` only when a code migration batch owns it
- keep `Category` while deciding a future `PackageClassification`
- keep existing `Modules/*` path until autoload, tests, and package loader are ready for a path migration
- avoid adding more user-facing docs that call core capabilities modules

Compatibility target:

```text
existing package loader works during transition
existing route names and URLs stay stable
existing package manifests remain executable source truth
new planning and docs stop expanding core capability work under root Modules/*
```

### 5. Registry Projection Migration

Plan a database-backed migration from module-only ownership fields to package/owner fields.

Initial safe direction:

1. Add new owner/package columns in forward migrations.
2. Backfill from existing `module_key` and `category`.
3. Update readers to prefer new columns while retaining old columns.
4. Update tests.
5. Retire old names only after a compatibility window.

### 6. Package Loader And Repository Rename

After docs and registry compatibility are stable:

1. Rename or wrap `app/Core/Modules` concepts behind package names.
2. Keep class aliases or compatibility adapters where needed.
3. Update tests from module terminology to package terminology.
4. Keep business module scaffolding under a clear template path.

This should be a separate code batch because many tests currently assert `Category::Core`, `Category::Shared`, `Category::PlatformManagement`, `module_key`, and module registry names.

### 7. Core Physical Migration Sequence

Do not move folders first, but use this as the target order once architecture and compatibility docs are accepted:

1. `app/Core/Audit`
2. `app/Core/Security`
3. `app/Core/Security/Secrets`
4. `app/Core/Auth`
5. `app/Core/Identity`
6. `app/Core/Access`
7. `app/Core/DataGovernance`
8. `app/Core/DataProtection`
9. `app/Core/Notifications`
10. `app/Core/Preferences`
11. `app/Core/Settings`
12. `app/Core/Monitoring`
13. classify and migrate current `app/Platform/Shell`, `Navigation`, `Dashboard`, `Setup`, `Surfaces`, `Docs`, and related transitional paths into their Goal 3-approved Core, Module, UI, or Laravel integration owners
14. root `Modules/*` packages

Rationale:

- Audit should exist before sensitive identity/access changes deepen.
- Security should exist before route tiers, request redaction, browser hardening, upload/download safety, and release checks are spread across larger Users, Access, and business module surfaces.
- Secrets should exist before Auth hardening, integration credentials, release-gate leak checks, or app-visible secret administration expand.
- Auth should be separated from business modules before identity lifecycle and admin flows grow.
- Identity should exist before user lifecycle management and Access Control subjects.
- Access should exist before protected admin and business module work.
- DataGovernance should exist before DataProtection broadens export, retention, erasure, privacy request, and business data handling workflows.
- DataProtection should exist before broad sensitive export, retention execution, erasure/anonymization execution, and DLP workflows are added.
- Notifications should move into Core before more producers are added.
- Preferences should be split from Settings before personal defaults grow.
- Settings should configure identity/access/notification behavior without owning those domains.
- Monitoring should separate operational errors from audit history before error-log features deepen.
- Business modules should arrive after core identity/access/audit boundaries are stable.

First high-value refactor targets after architecture and compatibility docs are accepted:

```text
Modules/Auth          -> app/Core/Auth
Modules/Notifications -> app/Core/Notifications
Modules/Roles         -> app/Core/Access
```

Those remove the largest current ambiguity before the Users administration and Access Control systems grow.

Auth-specific sequencing is tracked in [Auth Core Implementation Planning](auth-core-implementation-planning.md).

### 8. Folder Layout Execution Rule

Final physical endpoint:

```text
app/Core      core domain/security/system capabilities
Modules       optional, cohesive feature packages
resources     UI presentation infrastructure
Laravel integration locations for application-wide framework wiring
app/Platform  no target owner; transitional paths migrate through bounded Goal 3/Goal 9 work
```

Execution rule:

- keep current `Modules/*` physically stable until a specific migration batch owns a specific package move
- correct product/architecture vocabulary first
- move one capability at a time with route/view/autoload/test compatibility
- update `_Template` to represent the accepted Module contract before the first new Module is created
- keep migrations centralized in `database/migrations` unless a package-local migration convention is approved for an entire package family

## Testing Direction

Expected tests for the eventual migration:

- package catalog still rejects duplicate package keys
- core capabilities are always installed/enabled and not disableable
- business modules can be eligible for workspace/tenant enablement
- internal tools are not tenant eligible by default
- Settings, Setup, Preferences, Notifications, Dashboard, and Account consume package contribution metadata after vocabulary migration
- existing `module_key` notification/settings/registry rows remain readable during compatibility
- no DB registry row can introduce undeclared executable behavior
- existing Roles, Notifications, Account, Settings, Setup, and Dashboard feature tests continue passing

Additional tests once physical migration begins:

- `App\Models\User` remains the authenticatable model used by guards and packages
- core capability routes load from their target route files without URL changes
- business module routes continue to load from root `Modules/*`
- shared UI components remain under `resources/views/components`
- owner-specific Surface presentation does not own identity/access/audit behavior or Host Registry responsibilities

## Transition Rules

- Do not convert all existing code in one broad rename.
- Do not rename routes or URLs just because vocabulary changes.
- Do not turn core platform capabilities into tenant-toggleable business modules.
- Do not let business module installation state control Auth, Account, Users, Access Control, Roles, Settings, Setup, Notifications, Dashboard, Audit, or Monitoring.
- Do not make Access Control own Auth, Users, Roles, Notifications, Audit, or Monitoring records.
- Do not make DB registry rows the source of executable behavior.
- Do not use new `platform.*` permission keys during this migration.
- Do not put new business modules under `app/Modules`.
- Do not put core identity/access/audit/settings systems under root `Modules/*` once the physical split is accepted.
- Do not move shared UI primitives, shell components, or pattern components into core capabilities or business modules.

## Open Decisions

- Should the code namespace stay `App\Core\Modules` with improved category names, or migrate to `App\Core\Packages`?
- Should current package loader compatibility be preserved through adapters while core capabilities move to `app/Core`?
- Should `module_registry_entries` be renamed to `package_registry_entries`, or should a new table be introduced with a compatibility view/reader?
- Which existing `module_key` columns identify ownership versus actual Module identity, and what compatibility migration is required before introducing the accepted separate fields?
- Should Preferences remain a standalone package or be absorbed under Account after the account suite stabilizes?
- Should Dashboard be classified as a core surface package or workspace capability package?
- What exact classification names should replace `Category::Core`, `Category::Shared`, and `Category::PlatformManagement`?
- Should `app/Core/Preferences` be created immediately, or only when preferences grow beyond the current small account defaults surface?
- Should `app/Core/DataProtection` begin as runtime manifest declarations only, or should data assets be projected into durable registry tables immediately?
- Should the first DLP baseline prioritize export/download enforcement, data movement vocabulary, audit events, monitoring signals, or a combined implementation?
- Should `runtime-security` become `app/Core/Security` in the first physical migration, or remain compatibility metadata until route-tier and release-check contracts are accepted?
- Should threat-control catalog definitions begin as Markdown-only planning, PHP value objects under `app/Core/Security`, or both?
- Should threat detection begin as derived Audit/Monitoring queries, persisted `detection_signals`, or a security case workflow?
- Should deployment readiness begin as runbook/checklist evidence, app-level checks under `app/Core/Security/Deployment`, or persisted deployment evidence?
- Should machine API access begin with service-account-only tokens, webhook verification, or broader public API route support?
- Should DataGovernance begin as runtime manifest definitions, DB-backed registry projection, privacy request MVP, or a data quality issue workflow?
- Should vulnerability findings be persisted immediately under `app/Core/Security/VulnerabilityManagement`, or generated as reports until a dashboard/reporting need exists?
- Should core admin/account Blade views live centrally under `resources/views/admin/*` and `resources/views/account/*`, or package-local under `app/Core/*/resources/views`?
- Which surfaces should be renderer-driven versus normal ViewModel/PageData-driven?
- Which Goal 3-approved Core location owns the Setup Surface and Host Registry, and how do other Core capabilities or Modules contribute workflows through declared Extension Points?
- Should Support mean a core support capability for the platform itself, or a business support/ticketing module for tenant/customer workflows?

## Immediate Next Step

Use this planning direction to update the architecture vocabulary before implementing more Users or Access Control work.

Recommended next documentation order:

1. Architecture: revise package-system language into the Core, Module, UI, and Laravel integration owner taxonomy with separate Surface, Delivery Adapter, and Registry roles.
2. Planning: correct Auth, Users, and Access Control docs to `app/Core/Auth`, `app/Core/Identity`, and `app/Core/Access` direction.
3. Planning: align threat modeling, security controls, and release evidence before high-risk capability implementation begins.
4. Planning: align DLP data movement, export/download enforcement, and exfiltration detection before business exports expand.
5. Planning: align threat detection, response playbooks, and detection-use-case matrix before Monitoring/TDR implementation begins.
6. Planning: align deployment hardening, environment contracts, rollback, and readiness checks before production-release gates expand.
7. Planning: align API, webhook, and service-account machine-access rules before external integration/API implementation begins.
8. Planning: align software supply chain inventory, SBOM, lockfile, artifact identity, and release evidence before release gates expand.
9. Planning: align digital forensics readiness, evidence sources, request correlation, and chain-of-custody expectations before incident workflows expand.
10. Planning: align privacy/data governance ownership, processing purposes, privacy request workflows, data quality expectations, and retention policy intent before DataProtection enforcement and business data modules expand.
11. Planning: align view surface composition, thin URL views, ViewModel/PageData shape, reusable patterns, and renderer scope before broad admin page implementation expands.
12. Planning: align offensive security, penetration testing, DAST staging, evidence handling, and retest expectations before production-style releases expand.
13. Database: draft registry owner/package compatibility changes.
14. Code plan: scope a compatibility-only package vocabulary batch.
15. Code plan: scope `_Template` as a business-module template only.
16. Code implementation: only after tests and migration compatibility are clear.

## Related

- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md)
- [Privacy And Data Governance Planning](privacy-data-governance-planning.md)
- [Data Domain Governance Matrix](data-domain-governance-matrix.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md)
- [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Offensive Security And Penetration Testing Planning](offensive-security-penetration-testing-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Software Supply Chain Security Planning](software-supply-chain-security-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Backup And Recovery Planning](backup-recovery-planning.md)
- [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md)
- [Module Layout Convention Implementation Planning](module-layout-convention-implementation-planning.md)
- [Module UI Surface Implementation Planning](module-ui-surface-implementation-planning.md)
- [View Surface Composition Planning](view-surface-composition-planning.md)
- [Registry, App Instance, Workspace, And Module Vocabulary Planning](registry-instance-workspace-module-vocabulary-planning.md)
- [Module System](../03-architecture/module-system.md)
- [Module Contribution Registries](../06-database/feature-contracts/module-contribution-registries.md)

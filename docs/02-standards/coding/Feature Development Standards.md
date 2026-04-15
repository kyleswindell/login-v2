# Feature Development Standards

This document defines the canonical scope and intent for Feature Development Standards.

## Scope

These standards apply to all discrete features built in Login App 2.0 (V2).

## Naming Convention

The term **feature** is the canonical term for a discrete V2 product capability.

Use "feature" in:

* canonical feature docs under `docs/04-features/`
* planning notes
* code namespaces and directory names (e.g. `app/Platform/Notifications/`, `app/Platform/Settings/`)
* permission slugs (e.g. `platform.notifications.manage`, `platform.audit-logs.view`)

The term **module** is reserved for two specific purposes only:

* V1 Perfex modules — for V1 conventions, see [Legacy V1 Perfex Module Development Standards](../../09-reference/documentation/Legacy%20V1%20Perfex%20Module%20Development%20Standards.md)
* future tenant module policy — the data-model concept of enabling and disabling features per tenant account (reflected in the `module_key` column on settings and notification records)

Do not use "module" or "feature-set" as general synonyms for "feature" in V2 docs, code, or planning notes.

## Platform Boundary Decision

Before implementing any new V2 feature, answer these questions and record the answers in the feature's canonical doc before implementation starts:

1. Is this a shared core-app capability, platform-management capability, or tenantization capability?
2. Which database owns the record?
3. Which panel or route space owns the UI?
4. What logs must stay central versus tenant-local?
5. What parts are shared infrastructure versus tenant-facing capability?
6. If this is tenant-optional, which migrations and seeders install its schema for selected tenants?
7. What is the difference between installed, enabled, disabled, and unavailable states for this feature?

See [Platform And Tenant Application Boundary](../../03-architecture/platform-boundary.md) for the full decision framework.

For Phase 2 and later work, also use [Phase 2 - Route And Panel Ownership Map](../../07-planning/phases/phase-2/Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md) when deciding whether a screen belongs to the shared core app, platform-management layer, tenant context, Filament, Livewire, or custom Blade.

## Filament Usage Standard

Every implementation batch that includes UI work must explicitly pause and ask:

* does utilizing Filament apply here?

If yes, document why Filament is the correct UI owner for that surface.

If no, document why not and evaluate the next most appropriate UI option:

1. Livewire/custom Blade for reactive or specialized app UI.
2. Existing Tailwind/Blade component patterns for standard server-rendered pages.
3. A reviewed template or component library if the batch needs broader visual design support.
4. Fully custom UI only when the available framework patterns do not fit the use case.

Filament often fits CRUD-heavy admin records, table/filter/detail viewers, operational admin forms, settings/setup pages, and platform-management records. It may not fit specialized viewers, public/customer-facing pages, highly custom dashboards, or workflows where provisioning/module logic is the main concern.

Filament resources, pages, and actions must call existing services or actions for business mutations. They must not become the only place where business rules, audit logging, notification dispatching, or tenant/module state transitions exist.

Every Filament implementation must declare:

* panel owner and route path
* auth guard and permission gate/policy
* database context
* canonical feature doc owner
* whether the screen is shared core, platform-management, tenant-only, or hybrid
* which services/actions handle business behavior

## Setup And Settings Planning Requirement

Every feature introduced in V2 must map its Setup sidebar entry and Settings pages during feature design — before implementation starts.

This is a documentation procedure requirement, not a code enforcement:

* The feature's planning note must include a Setup and Settings section describing all intended entries.
* At minimum one real editable setting must exist before the Setup entry appears in the UI.
* Stub pages with no editable fields must not ship as visible Setup entries.

This requirement is reviewed during planning note review before implementation begins.

## Phase Kickoff Deliverable Review Requirement

When feature work belongs to a phase plan, phase deliverables must be explicitly reviewed and signed off before implementation starts.

Required phase-kickoff checks:

* confirm feature-level deliverables align to phase-level deliverables
* confirm final UI ownership outcomes are explicit for each affected surface
* confirm verification expectations are defined (tests, staging checks, visual review, doc sync)
* confirm any deferred scope is declared before coding starts, not after batch close-out

## Feature Settings Registration Rule

A feature's Setup sidebar entry must not be created until at least one real editable setting exists for that feature.

Settings must:

* be written through `SettingsService`
* be permission-gated appropriately
* be included in the feature's Settings section in its canonical doc and planning note before the entry ships

## Permissions

* Use the permission slug format `platform.{feature-name}.{action}` for platform features.
* Register gates in `AppServiceProvider`.
* Seed all permissions in the permissions seeder.
* Do not hard-code permission strings outside the gate definitions.

## Audit And Error Logging

* Log audit-worthy actions through the audit log pipeline (`PlatformAuditLog`).
* Log operational failures through the central error log (`CentralErrorLog`).
* At minimum, log settings changes as audit events.

## Data Table UX Standard

When a feature includes a tabular data view intended for regular operator use, ship a complete table interaction baseline in the same feature cycle:

* search/filter capability (global search or scoped filters)
* pagination support
* rows-per-page selector where row count can grow materially
* visible result summary (for example: showing X to Y of Z entries)
* prominent row action buttons (do not rely on plain text links for primary actions)

Required baseline layout order for app-owned Blade tables:

1. page title/subtitle row
2. optional table stats row
3. table action row (left-aligned actions such as `Create`, `Settings`, `Export`)
4. filter row (if scoped filters apply)
5. table
6. table footer controls:
   * bottom-left: rows selector + result summary
   * bottom-right: `Prev` / page selector / `Next`

Apply this intelligently:

* use client-side table behavior for small-to-medium in-memory lists
* use server-side filtering/pagination for large datasets or expensive queries
* avoid adding fake table controls for tiny static tables where they reduce clarity

## Canonical Feature Doc

Every feature must have a canonical doc under `docs/04-features/` registered in [Feature Index](../../04-features/index.md).

The canonical doc must be kept current with implementation status and must link back to its source planning note.

## Related

* [Legacy V1 Perfex Module Development Standards](../../09-reference/documentation/Legacy%20V1%20Perfex%20Module%20Development%20Standards.md) — V1 Perfex module conventions only
* [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
* [Platform And Tenant Application Boundary](../../03-architecture/platform-boundary.md)
* [Phase 2 - Route And Panel Ownership Map](../../07-planning/phases/phase-2/Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [Stack Notes: Filament And Livewire](../../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)
* [Feature Index](../../04-features/index.md)

# Feature Development Standards

## Scope

These standards apply to all discrete features built in Login App 2.0 (V2).

## Naming Convention

The term **feature** is the canonical term for a discrete V2 product capability.

Use "feature" in:

* canonical feature docs under `docs/V2 App/Features/`
* planning notes
* code namespaces and directory names (e.g. `app/Platform/Notifications/`, `app/Platform/Settings/`)
* permission slugs (e.g. `platform.notifications.manage`, `platform.audit-logs.view`)

The term **module** is reserved for two specific purposes only:

* V1 Perfex modules — for V1 conventions, see [[Standards/Module Development Standards]] | [Module Development Standards](Module%20Development%20Standards.md)
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

See [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](../V2%20App/Architecture/Platform%20And%20Tenant%20Application%20Boundary.md) for the full decision framework.

For Phase 2 and later work, also use [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](../V2%20App/Planning/Phase%202/Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md) when deciding whether a screen belongs to the shared core app, platform-management layer, tenant context, Filament, Livewire, or custom Blade.

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

Apply this intelligently:

* use client-side table behavior for small-to-medium in-memory lists
* use server-side filtering/pagination for large datasets or expensive queries
* avoid adding fake table controls for tiny static tables where they reduce clarity

## Canonical Feature Doc

Every feature must have a canonical doc under `docs/V2 App/Features/` registered in [[V2 App/Features/Feature Index]] | [Feature Index](../V2%20App/Features/Feature%20Index.md).

The canonical doc must be kept current with implementation status and must link back to its source planning note.

## Related

* [[Standards/Module Development Standards]] | [Module Development Standards](Module%20Development%20Standards.md) — V1 Perfex module conventions only
* [[Standards/Implementation Status And Development Sync Standard]] | [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](../V2%20App/Architecture/Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](../V2%20App/Planning/Phase%202/Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../V2%20App/Reference/Stack%20-%20Filament%20And%20Livewire.md)
* [[V2 App/Features/Feature Index]] | [Feature Index](../V2%20App/Features/Feature%20Index.md)

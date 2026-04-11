# ADR-0004 - Shared Core Instance And Panel Boundary Direction

## Status

Accepted

## Context

App 2.0 has two related goals:

* Parasolutions needs to use the application internally as a real business app.
* Tenants will eventually receive isolated app instances that use the same shared core feature set.

The platform experience should not become a visually separate product that behaves differently from tenant instances. It should be the first internal instance of the same core app, with additional platform-management capabilities layered on top for tenant administration and operations.

## Decision

Use one Laravel codebase with:

* a shared core app experience used by both Parasolutions and tenants
* a platform-management feature set available only in the Parasolutions platform context
* one central platform database for the Parasolutions instance and platform-management records
* one separate PostgreSQL database and PostgreSQL role per tenant
* tenant databases initialized from migrations and seeders rather than maintained manually as the only source of truth
* optional generated tenant template databases allowed as deployment/provisioning artifacts if useful
* optional module migrations installed only for tenants that need those modules
* module active/inactive state controlling UI/routes/policies after schema installation
* platform-to-tenant access handled through an audited handoff or sign-in flow, not by implicitly sharing tenant sessions

## Filament And Panel Direction

Filament remains appropriate, but the panel model should follow the product model:

* shared core app screens should have the same visual style in platform and tenant contexts
* platform-management screens should appear as additional platform-only capabilities, not as a separate-looking product
* future tenant panels should reuse shared core patterns where practical
* route, panel, auth, and database-context boundaries must be documented before broad Filament implementation

The current expected direction is:

* platform context includes the shared core app plus platform-management capabilities
* tenant context includes the shared core app without platform-management capabilities
* Filament panels may be separate internally where needed, but the user-facing style should remain consistent

## Consequences

* Phase 2 should not blindly convert the current Blade app into a platform-only admin console.
* Phase 2 must decide whether Filament powers one unified-looking app shell, separate internal panels with shared styling, or a hybrid model.
* Optional modules need migration and seeding conventions that can target selected tenants without forcing every tenant database to receive tenant-specific module tables.
* Module activation requires both schema-install state and runtime active/inactive state.
* Platform-to-tenant access must be designed with explicit audit logging and security boundaries.
* Business rules must stay in Laravel services and policies so they can be reused outside any one Filament resource.

## Related

* [[V2 App/Architecture/Core App And Platform Layer Model]] | [Core App And Platform Layer Model](../V2%20App/Architecture/Core%20App%20And%20Platform%20Layer%20Model.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](../V2%20App/Architecture/Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../V2%20App/Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../V2%20App/Planning/Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

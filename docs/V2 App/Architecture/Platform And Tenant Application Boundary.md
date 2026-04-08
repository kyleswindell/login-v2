# Platform And Tenant Application Boundary

## Purpose

Define how App 2.0 separates the Parasolutions-owned platform admin application from tenant-owned admin application instances.

This note is the planning baseline for V2 feature mapping. It preserves the useful tenancy concepts from V1 without carrying over Perfex-specific structural constraints.

This note should now be read together with the core product model:

* [[V2 App/Architecture/Core App And Platform Layer Model]] | [Core App And Platform Layer Model](Core%20App%20And%20Platform%20Layer%20Model.md)

## Revised Product Model

App 2.0 is one Laravel codebase with:

* a shared core business app
* a platform-management layer used by Parasolutions
* future tenant instances that should also run the shared core app

So the platform instance is not only a control plane. It is also the first internal consumer of the core app foundation.

## Runtime Contexts

At runtime, the system still has two major contexts:

* `platform` context: Parasolutions internal instance with both core-app usage and platform-management capability
* `tenant` context: client-specific instance using the shared core app without platform-management capability

The separation should be enforced by runtime context, database boundaries, route/panel boundaries, and policy boundaries rather than by maintaining two unrelated codebases.

## Platform Context

The platform context includes two kinds of behavior:

* shared core-app behavior used internally by Parasolutions
* cross-tenant and Parasolutions-only management behavior

Examples:

* shared internal business features such as customers, projects, finance, and internal operations
* platform staff authentication
* tenant registry
* tenant domain registry
* tenant database connection metadata
* tenant provisioning orchestration
* tenant active/inactive/suspended state
* tenant feature and module policy
* platform audit logs
* central error and security logging
* tenant support and operations tooling
* tenant website publishing orchestration

This is the V2 conceptual replacement for the V1 `admin_core` role, but layered on top of a reusable core app instead of being the whole identity of the platform instance.

## Tenant Context

The tenant context should run the shared core app foundation for client-specific data and workflows.

Examples:

* tenant staff authentication
* tenant roles and permissions
* tenant dashboard
* tenant settings
* tenant customers, projects, finance, and other shared business features
* tenant pages, content blocks, articles, and media
* tenant-local audit logs
* tenant website content management

The tenant context should never own cross-tenant registry or platform operations data.

## Boundary Rules

### One codebase, shared core plus separate contexts

We should prefer one shared Laravel codebase with explicit context separation.

That means:

* separate route groups or panels where context changes
* separate middleware pipelines where needed
* separate guards if the auth model needs it
* separate service entry points for shared core behavior versus platform-management actions where useful
* separate database connections and storage roots where tenant isolation matters

### Build shared core features as reusable features

Core business capabilities should not be designed as one-off platform-only features.

They should be built so the internal platform instance can use them first and future tenant instances can use them later.

### Platform data is not tenant data

The platform database is the control plane.

It should own:

* tenant identity
* domains
* provisioning state
* platform-visible policies
* centralized operational/security visibility

It should not become a mixed application database for tenant-owned records.

### Tenant databases are isolated application instances

Each tenant database should be treated as that tenant's application data boundary.

That means tenant-local records such as users, settings, content, and tenant audit history belong there unless there is a strong platform-level reason to centralize them.

### Fail closed on tenant resolution

Like V1, unknown or inactive tenant domains should fail closed.

V2 should preserve this concept while moving the logic into explicit Laravel middleware and tenancy services instead of low-level Perfex bootstrap edits.

## Recommended Technical Shape

### Shared core application shape

Likely implementation:

* shared business features under reusable app structure
* common services and UI patterns that can work in both the internal platform instance and future tenant instances

### Platform-management shape

Likely implementation:

* Filament platform panel for Parasolutions staff
* platform routes for provisioning, tenant support, and global operations
* platform services under `app/Platform/`

### Tenant application shape

Likely implementation:

* the same core-app feature set running in tenant scope
* tenant routes resolved after tenant context boot
* tenant services under `app/Tenant/` where tenant-specific behavior diverges

### Shared foundation layer

Shared logic should live outside either panel when the behavior is cross-cutting.

Examples:

* tenancy resolution
* logging infrastructure
* shared auth support
* publish pipelines
* common value objects, DTOs, enums, and policies

Likely location:

* `app/Foundation/` or `app/Support/`
* `app/Platform/` for platform-management orchestration
* `app/Tenant/` for tenant-specific workflows

## What We Preserve From V1

Concepts worth preserving:

* central tenant registry
* exact-domain tenant resolution
* inactive-tenant gating
* provisioning as a controlled platform operation
* data-driven module/feature policy
* centralized operational logging
* an internal administration surface that can govern tenant instances

## What We Intentionally Change From V1

V2 should avoid carrying forward these V1 structural constraints:

* Perfex module coupling for core tenancy
* database switching hidden inside low-level framework bootstrap files
* tenant policy tied to Perfex-native feature lists
* shared admin CRM assumptions that blur reusable core features with platform-only management features

## Design Consequence For Feature Planning

Before adding a V2 feature, decide first:

1. is this a shared core-app capability, platform-management capability, or tenantization capability?
2. which database owns the record?
3. which panel or route space owns the UI?
4. what logs must stay central versus tenant-local?
5. what parts are shared infrastructure versus tenant-facing capability?

That decision should be documented before implementation for new foundational features.

## Related

* [[V2 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)
* [[V2 App/Architecture/Core App And Platform Layer Model]] | [Core App And Platform Layer Model](Core%20App%20And%20Platform%20Layer%20Model.md)
* [[V2 App/Architecture/Tenancy Foundation]] | [Tenancy Foundation](Tenancy%20Foundation.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../Planning/V2%20Feature%20Roadmap.md)
* [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](../../V1%20App/Architecture/Multi%20Tenant%20Architecture.md)
* [[V1 App/Modules/Admin Core]] | [Admin Core](../../V1%20App/Modules/Admin%20Core.md)

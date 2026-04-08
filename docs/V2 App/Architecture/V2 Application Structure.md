# V2 Application Structure

## Purpose

Define the intended high-level folder and namespace strategy for App 2.0 before deeper feature implementation begins.

This note exists to keep the V2 feature roadmap aligned with a clear code organization plan.

## Guiding Principle

Do not let platform-owned code, tenant-owned code, and shared cross-cutting infrastructure collapse into one undifferentiated `app/` folder over time.

Use Laravel conventions where they help, but add explicit structure where the platform/tenant boundary matters.

## Recommended Top-Level Shape

Within the Laravel app, plan around these responsibility groups:

* `app/Platform/`
* `app/Tenant/`
* `app/Foundation/` or `app/Support/`
* default Laravel framework locations for HTTP, models, providers, console, and bootstrap wiring

## Platform Layer

Use `app/Platform/` for Parasolutions-owned orchestration and central control-plane behavior.

Examples:

* tenant registry services
* domain resolution support
* provisioning workflows
* platform operations and support tooling
* centralized policy management
* platform audit/security services

## Tenant Layer

Use `app/Tenant/` for tenant-local application behavior.

Examples:

* tenant dashboards
* tenant content workflows
* tenant media workflows
* tenant settings services
* tenant-specific policies and actions

## Shared Foundation Layer

Use `app/Foundation/` or `app/Support/` for cross-cutting pieces that should not belong exclusively to either side.

Examples:

* request correlation support
* shared logging primitives
* reusable DTOs and enums
* low-level tenancy interfaces
* common helpers that are truly cross-context

## HTTP Layer

The HTTP layer should reflect the boundary clearly.

Likely direction:

* platform middleware and route groups for platform traffic
* tenant resolution middleware before tenant routes
* panel-specific providers or config for platform and tenant Filament panels

Avoid burying context-sensitive logic directly in unrelated controllers when middleware, services, or panel bootstrapping can own it more clearly.

## Models

Model placement should follow ownership, not convenience.

Examples:

* platform-owned models may live under `app/Models/Platform/` or `app/Platform/Models/`
* tenant-owned models may live under `app/Models/Tenant/` or `app/Tenant/Models/`

The exact layout can be finalized once the first real platform and tenant models are introduced, but the ownership rule should be kept from the start.

## Why This Matters For Feature Planning

When a feature is proposed, we should be able to answer:

* which context owns the UI?
* which context owns the service logic?
* which database owns the data?
* which logs stay central and which stay tenant-local?

If we cannot answer those quickly, the feature is not ready for implementation.

## Near-Term Recommendation

Before building deep tenancy features, document these next:

1. route and panel separation
2. auth separation for platform users versus tenant users
3. provisioning workflow stages
4. initial model ownership rules

## Related

* [[V2 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../Planning/V2%20Feature%20Roadmap.md)
* [[V2 App/Architecture/Stack Overview]] | [Stack Overview](Stack%20Overview.md)

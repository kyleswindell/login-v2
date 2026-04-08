# Core App And Platform Layer Model

## Purpose

Define the product model for App 2.0 now that the intended platform behavior is clearer.

This note replaces the simpler assumption that the platform app is only a landlord control plane with tenant instances added later.

## Core Product Model

App 2.0 should be planned as a shared core business application with an additional platform-management layer.

That means:

* the Parasolutions internal platform instance is a real first-class user of the core app
* future tenant instances should also run the same core app foundation
* super-admin and tenancy-management capabilities are layered on top of that shared core

## Layers

### Core app layer

The core app is the reusable business application that both the internal platform instance and future tenant instances should share.

Examples:

* authentication
* users and roles
* customers
* projects
* finances
* notifications
* settings
* logging

### Platform-management layer

The platform-management layer is only for Parasolutions-owned control-plane capabilities.

Examples:

* tenant registry
* tenant provisioning
* tenant domain management
* cross-tenant support access
* tenant lifecycle management
* tenant policy management
* platform-only operational visibility

### Tenantization layer

The tenantization layer is what makes the core app deployable as isolated tenant instances.

Examples:

* domain-based tenant resolution
* tenant database creation and bootstrapping
* tenant-scoped storage/config
* tenant admin access handoff
* tenant runtime lifecycle handling

## Why This Model Fits Better

This model fits the clarified product vision because the Parasolutions internal instance is not just a provisioning console.

It is also intended to use the same business capabilities that tenants will use later.

That means the internal platform instance should be treated as the first real consumer of the shared core app rather than as a totally different product.

## Design Rule

When a new feature is proposed, ask:

1. is this a shared core-app capability?
2. is this platform-management-only capability?
3. is this tenantization/infrastructure work?

If the answer is unclear, the feature is not ready for implementation planning.

## Boundary Consequence

This does not remove the need for strong tenancy boundaries.

It means:

* the core app should be designed so it can run in both the internal platform instance and future tenant instances
* the platform-management layer should stay clearly separated from the shared core app
* the tenantization layer should be added deliberately, not allowed to leak into every core feature casually

## Related

* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Architecture/V2 Application Structure]] | [V2 Application Structure](V2%20Application%20Structure.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../Planning/V2%20Feature%20Roadmap.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Platform Foundation Planning]] | [Phase 1 - Platform Foundation Planning](../Planning/Phase%201/Phase%201%20-%20Platform%20Foundation%20Planning.md)

# V2 Feature Roadmap

## Purpose

Map the V2 feature plan using V1 as a reference source for useful concepts, not as a migration spec.

This note should stay product- and architecture-oriented. It is the planning bridge between the V1 feature catalog and V2 implementation order.

## Planning Rule

V1 documentation is reference-only.

We are not migrating V1 tables or data. We are deciding which capabilities should exist in V2, how they should be separated, and in what order they should be built.

## Planning Anchor

Use this boundary first:

* platform context owns cross-tenant administration and provisioning
* tenant context owns tenant-local application behavior

See:

* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](../Architecture/Platform%20And%20Tenant%20Application%20Boundary.md)

## V1 Capabilities To Preserve Conceptually

These V1 areas should influence V2 planning:

* tenant provisioning
* tenant domain resolution
* tenant active/inactive control
* tenant module and feature policy
* centralized admin oversight
* centralized logging and support visibility
* website integration and publishing hooks

These V1 areas are reference-only and should not automatically become day-one V2 scope:

* broad Perfex CRM feature parity
* Perfex-native finance/project/support menus
* module boundaries that only exist because of Perfex

## Proposed V2 Phases

### Phase 1: Platform Foundation

Goal:

Make the central platform app capable of owning tenant lifecycle and access boundaries.

Features:

* platform staff auth
* platform dashboard shell
* tenant registry
* tenant domain registry
* tenant status management
* tenant provisioning pipeline
* central platform audit logs
* central error/security logging

### Phase 2: Tenant Application Foundation

Goal:

Make each tenant instance usable as its own admin app.

Features:

* tenant auth
* tenant dashboard shell
* tenant roles and permissions
* tenant settings
* tenant-local audit logs
* media foundation

### Phase 3: Content And Website Foundation

Goal:

Establish the CMS-style features that are central to the V2 direction.

Features:

* pages
* content blocks
* articles or posts
* SEO metadata
* media linking
* publish pipeline hooks
* website environment settings

### Phase 4: Policy, Operations, And Support

Goal:

Make the system manageable at scale.

Features:

* feature/module policy UI
* support tooling
* tenant health visibility
* queue/job observability
* backup and restore planning
* security event review

### Phase 5: Advanced Tenant Products

Goal:

Add optional tenant-facing capability once the platform and content foundations are stable.

Examples:

* events management
* booking or registration workflows
* specialty modules
* public-site publishing enhancements

## Immediate Documentation Gaps To Fill Before Deep Implementation

These should be documented before the next major build phase:

* V2 application folder and namespace strategy
* V2 route and panel separation strategy
* V2 auth model for platform users versus tenant users
* V2 provisioning workflow as a runbook/spec
* V2 feature inventory note per major phase

## Recommended Next Docs

1. `V2 App/Architecture/V2 Application Structure.md`
2. `V2 App/Features/Platform Foundation.md`
3. `V2 App/Features/Tenant Foundation.md`
4. `V2 App/Features/Content And Website Foundation.md`
5. `V2 App/Runbooks/Tenant Provisioning Workflow.md`

## Related

* [[V2 App/Planning/Planning Index]] | [Planning Index](Planning%20Index.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](../Architecture/Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Architecture/App 2.0 Blueprint]] | [App 2.0 Blueprint](../Architecture/App%202.0%20Blueprint.md)
* [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../../V1%20App/Features/V1%20Feature%20Catalog.md)
* [[V1 App/Features/Tenant Provisioning]] | [Tenant Provisioning](../../V1%20App/Features/Tenant%20Provisioning.md)

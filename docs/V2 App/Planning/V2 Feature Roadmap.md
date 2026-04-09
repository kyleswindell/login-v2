# V2 Feature Roadmap

## Purpose

Map the V2 feature plan using V1 as a reference source for useful concepts, not as a migration spec.

This note should stay product- and architecture-oriented. It is the planning bridge between the V1 feature catalog and V2 implementation order.

## Planning Rule

V1 documentation is reference-only.

We are not migrating V1 tables or data. We are deciding which capabilities should exist in V2, how they should be separated, and in what order they should be built.

## Planning Anchor

Use this boundary first:

* shared core app first
* platform-management layer on top of the core app
* tenantization after the shared core is shaped correctly

See:

* [[V2 App/Architecture/Core App And Platform Layer Model]] | [Core App And Platform Layer Model](../Architecture/Core%20App%20And%20Platform%20Layer%20Model.md)
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

### Phase 0: Deployment And Environment Setup

Goal:

Establish the Git, server, and deployment baseline before the core app grows further.

Features:

* GitHub remote as source of truth
* multi-device workflow readiness
* server stack verification
* deployment path verification
* first deployment/bootstrap documentation

Working planning note:

* [[V2 App/Planning/Phase 0/Phase 0 - Deployment And Environment Setup]] | [Phase 0 - Deployment And Environment Setup](Phase%200/Phase%200%20-%20Deployment%20And%20Environment%20Setup.md)

### Phase 1: Core App Foundation

Goal:

Establish the shared business-application foundation that both the internal platform instance and future tenant instances should use.

Features:

* platform staff auth
* shared user and role foundation
* shared dashboard shell
* shared customers/projects/finance planning baseline
* central platform audit logs
* central error/security logging
* shared notifications and settings conventions

Working planning note:

* [[V2 App/Planning/Phase 1/Phase 1 - Platform Foundation Planning]] | [Phase 1 - Platform Foundation Planning](Phase%201/Phase%201%20-%20Platform%20Foundation%20Planning.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 1]] | [Phase 1 - Implementation Batch 1](Phase%201/Phase%201%20-%20Implementation%20Batch%201.md)

### Phase 2: Platform-Management Layer

Goal:

Add the Parasolutions-only management capabilities on top of the shared core app.

Features:

* tenant registry
* tenant domain registry
* tenant status management
* support and operational tooling
* platform-only policy management
* cross-tenant visibility

### Phase 3: Tenantization And Provisioning Foundation

Goal:

Make the shared core app deployable as isolated tenant instances.

Features:

* tenant resolution
* tenant provisioning pipeline
* tenant database bootstrapping
* tenant runtime lifecycle handling
* tenant admin access handoff

### Phase 4: Content And Website Foundation

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

### Phase 5: Policy, Operations, And Support

Goal:

Make the system manageable at scale.

Features:

* feature/module policy UI
* support tooling
* tenant health visibility
* queue/job observability
* backup and restore planning
* security event review

### Phase 6: Advanced Tenant Products

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
* V2 shared-core feature inventory
* V2 platform-management feature inventory
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
* [[V2 App/Planning/Phase 0/Phase 0 Index]] | [Phase 0 Index](Phase%200/Phase%200%20Index.md)
* [[V2 App/Planning/Phase 1/Phase 1 Index]] | [Phase 1 Index](Phase%201/Phase%201%20Index.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Platform Foundation Planning]] | [Phase 1 - Platform Foundation Planning](Phase%201/Phase%201%20-%20Platform%20Foundation%20Planning.md)
* [[V2 App/Architecture/Core App And Platform Layer Model]] | [Core App And Platform Layer Model](../Architecture/Core%20App%20And%20Platform%20Layer%20Model.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](../Architecture/Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Architecture/App 2.0 Blueprint]] | [App 2.0 Blueprint](../Architecture/App%202.0%20Blueprint.md)
* [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../../V1%20App/Features/V1%20Feature%20Catalog.md)
* [[V1 App/Features/Tenant Provisioning]] | [Tenant Provisioning](../../V1%20App/Features/Tenant%20Provisioning.md)

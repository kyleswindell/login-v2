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
* final software stack and UI system introduction before broad module expansion
* remaining core module expansion before tenant rollout
* tenant app rollout only after the base system is complete and template DB is stable

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

Status:

* complete and signed off (2026-04-10)
* staging QA completed for setup/sidebar behavior fixes
* automated tests passing against PostgreSQL test database (76 tests, 253 assertions)

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

### Phase 2: Final Stack And UI System Introduction

Goal:

Complete introduction of the intended long-term stack and UI architecture so future modules are built on final patterns instead of transitional patterns.

Status:

* planning started (2026-04-10)
* Phase 1 foundation is complete and signed off
* current implementation uses custom Blade app surfaces while Filament/Livewire remain planned
* Phase 2 must decide route, panel, shell, design-system, and template direction before Phase 3 module expansion

Features:

* finalize app shell/navigation strategy for persistent panel behavior
* introduce final UI framework patterns (Filament/Livewire where intended)
* establish design system baseline (layout, components, interaction patterns, responsive behavior)
* standardize page and module scaffolding for future phase development
* lock frontend architecture decisions before broad module expansion

Working planning note:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical architecture note:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)

### Phase 3: Remaining Core Module Introduction

Goal:

Introduce remaining core business modules (V1-inspired core capability set) including setup flows and settings coverage.

Features:

* core module rollout for the remaining baseline app capabilities
* module-specific setup views and onboarding flows
* module-specific settings groups and validation rules
* shared conventions for permissions, audit logs, error logs, notifications, and options applied to every new core module
* soft integration points for payment handling where needed

### Phase 4: Customer-Facing View System

Goal:

Introduce customer-facing authentication and portal experience so customers can access module outputs (for example invoices and payments) based on enabled modules.

Features:

* customer login and session model
* customer portal shell and navigation
* customer invoice visibility and payment flow integration points
* module-aware customer visibility rules
* baseline customer self-service patterns

### Phase 5: Tenant App Version Rollout (Soft Introduction)

Goal:

Begin tenant app rollout only after base-system stability is confirmed, using a clean tenant template database and controlled versioning.

Features:

* establish clean tenant template database baseline from completed core system
* versioned tenant app rollout strategy and release checkpoints
* controlled pilot tenant provisioning and verification flow
* rollback and recovery guardrails for tenant rollout batches
* defer wide tenant rollout until template stability is verified

### Phase 6: Platform-Management Layer (Deferred)

Goal:

Introduce Parasolutions-only control-plane capabilities after core, customer, and initial tenant rollout foundations are stable.

Features:

* tenant registry
* tenant domain registry
* tenant status management
* support and operational tooling
* platform-only policy management
* cross-tenant visibility

### Phase 7: Policy, Operations, And Support

Goal:

Make the system manageable at scale.

Features:

* feature/module policy UI
* support tooling
* tenant health visibility
* queue/job observability
* backup and restore planning
* security event review
* GitHub Actions based deployment automation and release visibility
* future admin tooling evaluation, including:
  * local database GUI workflows such as DBeaver or pgAdmin
  * targeted service web UIs where they add operational value safely
  * monitoring panels and dashboards
  * deployment dashboards and release visibility

### Phase 8: Advanced Tenant Products

Goal:

Add optional tenant-facing capability once the platform and content foundations are stable.

Examples:

* events management
* booking or registration workflows
* specialty modules
* public-site publishing enhancements

## Immediate Documentation Gaps To Fill Before Deep Implementation

These should be documented before the next major build phase:

* V2 final stack and UI architecture specification for Phase 2 is started and must be expanded through Batch 1 decisions
* V2 route and panel separation strategy
* V2 remaining core-module inventory for Phase 3
* V2 customer auth and portal model for Phase 4
* V2 tenant template database baseline and rollout/versioning runbook for Phase 5
* V2 deferred platform-management inventory for Phase 6+

## Recommended Next Docs

1. `V2 App/Architecture/V2 Application Structure.md`
2. `V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning.md`
3. `V2 App/Architecture/V2 Final Stack And UI Design Spec.md`
4. `V2 App/Features/Core Module Inventory - Phase 3.md`
5. `V2 App/Features/Customer Portal Foundation - Phase 4.md`
6. `V2 App/Runbooks/Tenant Template And Version Rollout - Phase 5.md`

## Related

* [[V2 App/Planning/Planning Index]] | [Planning Index](Planning%20Index.md)
* [[V2 App/Planning/Phase 0/Phase 0 Index]] | [Phase 0 Index](Phase%200/Phase%200%20Index.md)
* [[V2 App/Planning/Phase 1/Phase 1 Index]] | [Phase 1 Index](Phase%201/Phase%201%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202/Phase%202%20Index.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Platform Foundation Planning]] | [Phase 1 - Platform Foundation Planning](Phase%201/Phase%201%20-%20Platform%20Foundation%20Planning.md)
* [[V2 App/Architecture/Core App And Platform Layer Model]] | [Core App And Platform Layer Model](../Architecture/Core%20App%20And%20Platform%20Layer%20Model.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](../Architecture/Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Architecture/App 2.0 Blueprint]] | [App 2.0 Blueprint](../Architecture/App%202.0%20Blueprint.md)
* [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../../V1%20App/Features/V1%20Feature%20Catalog.md)
* [[V1 App/Features/Tenant Provisioning]] | [Tenant Provisioning](../../V1%20App/Features/Tenant%20Provisioning.md)

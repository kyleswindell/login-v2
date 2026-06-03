# Feature Roadmap

This document defines the canonical scope and intent for Feature Roadmap.

## Purpose

Map the App 2.0 feature plan using V1 as a reference source for useful concepts, not as a migration spec.

This note stays product- and architecture-oriented. It is the planning bridge between the V1 feature catalog and App 2.0 implementation order.

## Planning Rule

V1 documentation is reference-only.

We are not migrating V1 tables or data. We are deciding which capabilities should exist in App 2.0, how they should be separated, and in what order they should be built.

## Roadmap Status Rule

This roadmap is the high-level phase summary, not the detailed progress ledger.

Use the owning phase index as the source of truth for:

* current phase status
* active scope lock
* batch-sequence state
* deferred and future-phase placeholders

Roadmap phase status should summarize, not override, the owning phase index.

## Planning Anchor

Use this boundary first:

* shared core app first
* final software stack and UI system introduction before broad module expansion
* customer/public foundation before broad module expansion where modules have outward-facing behavior
* remaining core module expansion after customer/public contracts are established
* tenant app rollout only after the base system is complete and template DB is stable

See:

* [Core App And Platform Layer Model](../03-architecture/subsystems/core-platform-layer-model.md)
* [Platform And Tenant Application Boundary](../03-architecture/platform-boundary.md)

## V1 Capabilities To Preserve Conceptually

These V1 areas should influence App 2.0 planning:

* tenant provisioning
* tenant domain resolution
* tenant active/inactive control
* tenant module and feature policy
* centralized admin oversight
* centralized logging and support visibility
* website integration and publishing hooks

These V1 areas are reference-only and should not automatically become day-one App 2.0 scope:

* broad Perfex CRM feature parity
* Perfex-native finance/project/support menus
* module boundaries that only exist because of Perfex

## Proposed App 2.0 Phases

### Phase 0: Deployment And Environment Setup

Goal:

Establish the Git, server, and deployment baseline before the core app grows further.

Status:

* complete as the historical deployment/bootstrap baseline
* current deployment operations and environment execution details are maintained in canonical runbooks

Features:

* GitHub remote as source of truth
* multi-device workflow readiness
* server stack verification
* deployment path verification
* first deployment/bootstrap documentation

Working planning note:

* [Phase 0 - Deployment And Environment Setup](phases/phase-0/Phase 0 - Deployment And Environment Setup.md)

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

* [Phase 1 - Platform Foundation Planning](phases/phase-1/Phase 1 - Platform Foundation Planning.md)
* [Phase 1 - Implementation Batch 1](phases/phase-1/Phase 1 - Implementation Batch 1.md)

### Phase 2: Final Stack And UI System Introduction

Goal:

Complete introduction of the intended long-term stack and UI architecture so future modules are built on final patterns instead of transitional patterns.

Status:

* active locked development phase
* Batch 1-6, Batch A, and Batch B are complete; Batch F is active for page archetype starter proofs before Batch E close-out resumes
* Phase 2 is strictly bounded to UI-system completion and platform-surface convergence
* feature-specific and non-UI contracts are deferred to future phases unless already declared in the active Phase 2 lock

Features:

* finalize app shell/navigation strategy for persistent panel behavior
* introduce final UI framework patterns (Filament/Livewire where intended)
* establish design system baseline (layout, components, interaction patterns, responsive behavior)
* complete the Tier 2 reusable pattern library needed for internal application surfaces before broad module expansion
* standardize internal shell families for dashboard, setup, settings, account/profile, and shared app framing
* standardize page and module scaffolding for future phase development, including dashboard widget shells, list/detail/form/setup/settings archetypes, and empty/loading/error handling expectations
* provide concrete starter-page examples for the reusable page/module archetypes future phases will consume
* define setup/settings registration conventions and future-module UI ownership declaration requirements
* lock frontend architecture decisions before broad module expansion

Working planning note:

* [Phase 2 - Final Stack And UI System Planning](phases/phase-2/Phase 2 - Final Stack And UI System Planning.md)

Canonical architecture note:

* [Final Stack And UI Design Spec](../03-architecture/subsystems/final-stack-and-ui-boundary.md)

### Phase 3: Customer And Public View Foundation

Goal:

Introduce customer/public-facing foundations early enough that outward-facing core modules do not require later architectural rework.

Status:

* planning draft
* implementation not started
* blocked on Phase 2 close-out
* current Batch 1 scope includes the security substrate required before OAuth and Microsoft Graph rollout

Features:

* customer login and session model
* customer account-creation and enrollment standards
* public/customer route and visibility contracts
* customer/public shell and navigation baseline
* brochure-site authoring and publishing foundation
* portable brochure publish contract with integrated Laravel delivery first and Astro-compatible delivery adapter later
* OAuth sign-in foundations for Google and Microsoft account providers, with a policy model that can expand to other major providers later without changing the customer/staff auth contract
* per-tenant customer access modes (`disabled`, `invite_only`, `open_enrollment`)
* invitation-only, tenant-created, self-registration, and code/invite-based account creation pathways as planning milestones
* customer company multi-user identity model for strict ownership-based access
* module-level and record-level customer visibility contracts
* outward-facing module rendering patterns
* events/public business event presentation
* shared app-mailer configuration and outbound email foundation, with Microsoft Graph as the first required provider contract
* platform-configured default sender accounts and aliases with tenant override support
* feature-based sender-alias routing and per-user email preference policy (opt-in and mandatory classes)
* security substrate for outward-facing auth and integrations, including login abuse defenses, secret-backed credential storage, auth-bearing surface hardening, and production environment checks required before OAuth and Microsoft Graph rollout

Working planning note:

* [Phase 3 - Customer And Public View Planning](phases/phase-3/Phase 3 - Customer And Public View Planning.md)
* [Phase 3 - Implementation Batch 1](phases/phase-3/Phase 3 - Implementation Batch 1.md)
* [Phase 3 - Brochure Subsystem Hybrid Delivery Planning](phases/phase-3/Phase 3 - Brochure Subsystem Hybrid Delivery Planning.md)
* [Phase 3 - Events And Legacy Website Publishing Planning](phases/phase-3/Phase 3 - Events And Legacy Website Publishing Planning.md)
* [Phase 3 - Microsoft Graph Email Sending Planning](phases/phase-3/Phase 3 - Microsoft Graph Email Sending Planning.md)
* [Phase 3 - OAuth And Customer Access Mode Planning](phases/phase-3/Phase 3 - OAuth And Customer Access Mode Planning.md)

### Phase 4: Remaining Core Module Introduction

Goal:

Introduce remaining core business modules (V1-inspired core capability set) including setup flows and settings coverage.

Status:

* planning draft
* implementation not started
* blocked on Phase 2 close-out and Phase 3 foundation delivery

Features:

* core module rollout for the remaining baseline app capabilities
* module-specific setup views and onboarding flows
* module-specific settings groups and validation rules
* shared conventions for permissions, audit logs, error logs, notifications, and options applied to every new core module
* soft integration points for payment handling where needed

Working planning note:

* [Phase 4 - Remaining Core Module Planning](phases/phase-4/Phase 4 - Remaining Core Module Planning.md)
* [Phase 4 - Implementation Batch 1](phases/phase-4/Phase 4 - Implementation Batch 1.md)
* [Phase 4 - UI Ownership And PostgreSQL Schema Map](phases/phase-4/Phase 4 - UI Ownership And PostgreSQL Schema Map.md)

### Phase 5: Tenant App Version Rollout (Soft Introduction)

Goal:

Begin tenant app rollout only after base-system stability is confirmed, using a clean tenant template database and controlled versioning.

Status:

* not started
* deferred until core, customer/public, and template-stability prerequisites are complete

Features:

* establish clean tenant template database baseline from completed core system
* versioned tenant app rollout strategy and release checkpoints
* controlled pilot tenant provisioning and verification flow
* rollback and recovery guardrails for tenant rollout batches
* defer wide tenant rollout until template stability is verified

### Phase 6: Platform-Management Layer (Deferred)

Goal:

Introduce Parasolutions-only control-plane capabilities after core, customer, and initial tenant rollout foundations are stable.

Status:

* deferred
* not started

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

Status:

* deferred
* not started as an active implementation phase

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

Phase 7 extends security operations and observability after earlier phases establish the implementation baseline. It does not replace the earlier-phase prerequisites for auth hardening, secure credential storage, or production runtime hardening.

### Phase 8: Advanced Tenant Products

Goal:

Add optional tenant-facing capability once the platform and content foundations are stable.

Status:

* deferred
* not started

Examples:

* events management
* booking or registration workflows
* specialty modules
* public-site publishing enhancements

## Current Planning Frontier

Current roadmap attention should stay on the active and near-next planning surfaces:

* keep the roadmap synchronized with the owning phase indices instead of treating it as an independent tracker
* finish Phase 2 Batch F starter-proof implementation before resuming Batch E close-out
* do not run Phase 2 staging deploy while staging deploy is disabled pending security incident review
* keep Phase 3 Batch 1 scope synchronized across customer/public, OAuth, Microsoft Graph, and security-substrate planning notes
* preserve Phase 4 as planning-only until the Phase 2 and Phase 3 handoff conditions are actually met

## Recommended Navigation

Use these current planning entry points first:

1. `docs/07-planning/phases/phase-2/Phase 2 Index.md`
2. `docs/07-planning/phases/phase-3/Phase 3 Index.md`
3. `docs/07-planning/phases/phase-3/Phase 3 - Implementation Batch 1.md`
4. `docs/07-planning/phases/phase-4/Phase 4 Index.md`
5. `docs/07-planning/dependency-map.md`

## Related

* [Planning Index](index.md)
* [Phase 0 Index](phases/phase-0/Phase 0 Index.md)
* [Phase 1 Index](phases/phase-1/Phase 1 Index.md)
* [Phase 2 Index](phases/phase-2/Phase 2 Index.md)
* [Phase 3 Index](phases/phase-3/Phase 3 Index.md)
* [Phase 4 Index](phases/phase-4/Phase 4 Index.md)
* [Phase 1 - Platform Foundation Planning](phases/phase-1/Phase 1 - Platform Foundation Planning.md)
* [Core App And Platform Layer Model](../03-architecture/subsystems/core-platform-layer-model.md)
* [Platform And Tenant Application Boundary](../03-architecture/platform-boundary.md)
* [Final Stack And UI Design Spec](../03-architecture/subsystems/final-stack-and-ui-boundary.md)
* [App 2.0 Blueprint](../03-architecture/app-2-0-blueprint.md)
* V1 Feature Catalog
* Tenant Provisioning

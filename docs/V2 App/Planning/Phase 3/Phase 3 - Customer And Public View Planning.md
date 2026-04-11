# Phase 3 - Customer And Public View Planning

## Purpose

Plan Phase 3: customer/public-facing foundations that must exist before broad core-module expansion so outward-facing business features do not need late reintegration.

This note is the active planning surface for customer/public route ownership, visibility models, events-driven public business presentation, and interim website publishing compatibility.

## Implementation Status

Current status:

* Phase 3 planning has started
* V1 Events module review indicates customer/public functionality is an architectural prerequisite for multiple outward-facing modules
* implementation is blocked on final Phase 2 stack/UI ownership decisions
* no Phase 3 customer/public implementation has started yet

Canonical roadmap owner:

* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)

Phase index:

* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](Phase%203%20Index.md)

## Source Review Inputs

This Phase 3 draft is informed by:

* [[V1 App/Modules/Events]] | [Events](../../../V1%20App/Modules/Events.md)
* [[V1 App/Features/Event Website Sync]] | [Event Website Sync](../../../V1%20App/Features/Event%20Website%20Sync.md)
* [[V1 App/Architecture/Website Sync Architecture]] | [Website Sync Architecture](../../../V1%20App/Architecture/Website%20Sync%20Architecture.md)
* [[V1 App/Reference/Events Routes]] | [Events Routes](../../../V1%20App/Reference/Events%20Routes.md)
* [[V1 App/Reference/Events Data Model]] | [Events Data Model](../../../V1%20App/Reference/Events%20Data%20Model.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Events And Legacy Website Publishing Planning]] | [Phase 3 - Events And Legacy Website Publishing Planning](Phase%203%20-%20Events%20And%20Legacy%20Website%20Publishing%20Planning.md)

## Phase Goal

Establish customer/public-facing contracts early enough that:

* outward-facing event and business-module views are part of initial design rather than retrofitted later
* portal and public visibility rules are defined before core-module expansion
* legacy JSON publishing support can be added cleanly where business continuity requires it
* platform-controlled integrations and tenant-operated workflows remain clearly separated

## Why Phase 3 Must Come Before Broad Module Expansion

The V1 custom Events module proves that at least some tenant business modules are not complete when only the internal admin side exists.

In V1, Events included:

* admin CRUD and setup
* public event access
* sponsor and public presentation controls
* photo-drop uploads and moderation
* website JSON publishing
* scheduler-driven sync behavior

That means V2 needs customer/public foundations before broader module rollout, or later phases will be forced to revisit modules for:

* public/customer route models
* public visibility and policy rules
* payload shaping and rendering
* publishing integration points
* outward-facing UX patterns

## Recommended Scope For Phase 3

Phase 3 should establish:

1. customer and public route ownership model
2. customer/public shell and navigation baseline
3. public versus customer-authenticated visibility contracts
4. outward-facing module rendering conventions
5. events as the first outward-facing business module proof
6. interim legacy website JSON publishing adapter direction for tenants that still depend on V1-style site sync

## Events Module Implications For V2

Recommended V2 direction:

* Events should be a shared-core module with optional capability toggles, not a replacement-style add-on over a base event feature
* advanced outward-facing capabilities should be data-driven and enableable per tenant
* platform should own publishing-adapter configuration and policy
* tenant users should operate event content and day-to-day publishing workflows through their tenant GUI once enabled

Suggested event capability toggles:

* public event visibility
* short-code public access
* sponsor management
* photo-drop uploads
* moderation tools
* website JSON publishing
* legacy-site compatibility mode

Detailed planning note:

* [[V2 App/Planning/Phase 3/Phase 3 - Events And Legacy Website Publishing Planning]] | [Phase 3 - Events And Legacy Website Publishing Planning](Phase%203%20-%20Events%20And%20Legacy%20Website%20Publishing%20Planning.md)

## Customer/Public Foundation Contracts

Phase 3 should define explicit contracts for:

* `public` surfaces: no authentication required, controlled by visibility rules and publish state
* `customer` surfaces: customer-authenticated and scoped to permitted records
* `staff` surfaces: tenant admin/staff internal management
* `platform` surfaces: platform-only control-plane and integration configuration

These contracts must be declared during feature design so later modules do not invent their own outward-facing models.

## Interim Legacy Website Publishing Direction

Phase 3 should support a limited but useful compatibility path for legacy sites through configurable publishing adapters.

Supported adapter modes should begin with:

* filesystem JSON write mode
* authenticated HTTPS endpoint push mode

Platform-owned responsibilities:

* adapter definition and credentials
* target assignment to a tenant/module capability
* operational policy and failure visibility

Tenant-owned responsibilities after enablement:

* managing business data that feeds the published payloads
* triggering or monitoring routine publish operations from the tenant GUI where allowed

## Out Of Scope

Not in current Phase 3 scope:

* full website CMS editing or page builder tooling
* generalized website content management and deployment pipelines
* tenant self-service creation of publishing integrations
* broad remaining core-module rollout (moved to Phase 4)
* tenant provisioning/runtime rollout (Phase 5)

## Proposed Delivery Sequence

1. Define customer/public route and shell ownership.
2. Define visibility and access contracts for public, customer, staff, and platform surfaces.
3. Prove one outward-facing business module with Events.
4. Add interim legacy website publishing adapter support for event payloads where required.
5. Lock reusable patterns before Phase 4 module expansion.

## Entry Criteria

Phase 3 implementation should not start until Phase 2 confirms:

* final route/panel/UI ownership decisions
* shell and navigation direction
* which surfaces remain custom versus Filament-owned

## Exit Criteria

Phase 3 can close when:

* customer/public route and visibility contracts are documented and implemented
* at least one outward-facing module proof validates the pattern
* interim legacy JSON publishing direction is documented and proven where needed
* platform-versus-tenant publishing responsibilities are clear and enforced
* Phase 4 can build core modules without re-inventing outward-facing integration rules

## Related

* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](Phase%203%20Index.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Implementation Batch 1]] | [Phase 3 - Implementation Batch 1](Phase%203%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Events And Legacy Website Publishing Planning]] | [Phase 3 - Events And Legacy Website Publishing Planning](Phase%203%20-%20Events%20And%20Legacy%20Website%20Publishing%20Planning.md)
* [[V2 App/Planning/Phase 4/Phase 4 - Remaining Core Module Planning]] | [Phase 4 - Remaining Core Module Planning](../Phase%204/Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)

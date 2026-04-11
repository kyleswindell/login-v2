# V2 Final Stack And UI Design Spec

## Purpose

Define the target stack and UI architecture decisions that Phase 2 must settle before Phase 3 customer/public foundations and Phase 4 broad module expansion begin.

This note is the canonical architecture owner for Phase 2 final-stack alignment.

## Implementation Status

Current status:

* planning owner created for Phase 2
* current Phase 1 UI is Blade, Vite, Tailwind, Laravel controllers, and small DOM-driven JavaScript
* Reverb and Echo are already implemented for realtime notifications
* Filament is installed and validated through read-only audit/error operational proofs
* Livewire is present through Filament, while custom Livewire shell ownership remains undecided
* final app shell, panel, and design-system decisions are not yet locked
* Batch 4 shell/navigation baseline work is in progress

Source planning note:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Planning/Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

## Locked Stack Direction

The locked foundation remains:

* Laravel as the application integration center
* PostgreSQL as the source of truth
* Redis for queues, cache, and realtime support infrastructure
* Reverb and Echo for realtime app events
* Vite and Tailwind for frontend build and styling
* Apache and PHP-FPM for staging and production runtime
* Filament and Livewire for long-term admin panels where they are the correct fit

Any deviation from this stack requires an ADR under `docs/Decisions/`.

## Current Implementation Versus Final Stack

## Product And Panel Boundary Decision

The platform experience should be treated as the first internal instance of the shared core app.

That means:

* Parasolutions uses the same core app experience that tenants will use later
* platform-management capabilities are additional modules/features available only in the platform context
* tenant instances should retain the same visual style, except for future colorway and user-design customization features
* Filament should support this shared experience rather than create a visually separate platform-only product

Decision owner:

* [[Decisions/ADR-0004 - Shared Core Instance And Panel Boundary Direction]] | [ADR-0004 - Shared Core Instance And Panel Boundary Direction](../../Decisions/ADR-0004%20-%20Shared%20Core%20Instance%20And%20Panel%20Boundary%20Direction.md)

## Current Implementation Versus Final Stack

### Already aligned

The current implementation already aligns with the final stack in these areas:

* Laravel 13 application foundation
* PostgreSQL platform database
* Redis-backed queue and cache direction
* Reverb and Echo realtime notification architecture
* Vite and Tailwind frontend asset pipeline
* Apache and PHP-FPM staging runtime
* service-backed business rules for notifications, settings, logging, and users

### Transitional

The following areas are intentionally transitional:

* platform UI is custom Blade rather than Filament panels
* interactive behavior is mixed between server-rendered pages and DOM-driven JavaScript
* navigation shell is full-page Blade, not a persistent Livewire shell
* Setup and Settings UI exists, but the long-term panel ownership is not decided
* UI styling is functional Tailwind, not yet a formal design system

### Not yet introduced

The following final-stack elements are not yet active:

* Filament installation and panel providers
* Livewire component architecture outside what Filament may bring
* platform panel versus tenant panel route and auth boundaries
* reusable UI component inventory
* visual template or design-system baseline

## Stack Introduction Implications

Introducing the remaining final stack after Phase 1 has consequences:

* existing Blade screens should be treated as working foundations, not automatically permanent screens
* CRUD-heavy administrative screens may be better moved into Filament resources instead of extended further in custom Blade
* non-CRUD workflow pages may remain Blade or become Livewire depending on shell and interaction requirements
* Livewire should not become a place for business logic; services and policies must stay the backend source of truth
* Reverb/Echo should remain the realtime event layer, even if visible screens move into Filament or Livewire
* route names, permissions, settings keys, audit logs, and notification contracts should remain stable during UI migration
* design-system decisions should happen before building outward-facing Phase 3 surfaces and Phase 4 module screens to avoid avoidable churn

## Required Phase 2 Decisions

Phase 2 must explicitly decide:

1. Which screens remain custom Blade?
2. Which screens move to Filament resources or Filament pages?
3. Whether a persistent app shell should be Livewire-powered, Filament-powered, or remain server-rendered.
4. Whether Setup and Settings belong in the custom app shell, a Filament panel, or a hybrid model.
5. Whether platform-management screens and shared core-app screens share one user-facing shell, separate internal panels, or a hybrid model with consistent styling.
6. What visual design baseline should govern layout, spacing, cards, tables, forms, empty states, and responsive behavior.
7. Whether an existing dashboard/admin template should be adopted, referenced, or avoided.
8. What UI work must be converted before Phase 3 customer/public work and Phase 4 modules start.
9. How optional module migrations are installed for selected tenant databases without forcing tenant-specific schema onto every tenant.
10. How platform-to-tenant access is audited and authorized.

Current decision artifacts:

* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](../Planning/Phase%202/Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](../Planning/Phase%202/Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)

## Recommended Stack Introduction Order

Use this order:

1. Lock route and panel ownership.
2. Lock the app shell and navigation model.
3. Lock visual design primitives and template direction.
4. Install or defer Filament based on the route and panel decision.
5. Introduce Livewire only where the chosen shell or Filament pattern requires it.
6. Migrate one low-risk internal surface as the proving ground.
7. Document scaffolding conventions for future Phase 3 customer/public surfaces and Phase 4 modules.
8. Start Phase 3 customer/public work and Phase 4 module expansion only after the scaffolding path is repeatable.

## Design System Baseline To Define

The design baseline should cover:

* full-width dashboard layout
* top header structure
* primary navigation and secondary navigation
* Setup and Settings navigation behavior
* table defaults
* form defaults
* cards and metric panels
* notifications and toast behavior
* error and empty states
* mobile and tablet behavior
* icon and badge conventions

## Template Review Stance

Template review is allowed in Phase 2, but template adoption should be deliberate.

A template should only be adopted if it:

* works cleanly with Laravel, Tailwind, Filament, and Livewire
* does not fight the panel architecture
* avoids heavy unrelated JavaScript dependencies
* has license terms compatible with the project
* can be reduced into reusable layout/component primitives

If no template is selected, Phase 2 should still define a small custom design system before Phase 3.

## Optional Module Schema Direction

Optional tenant-specific modules should not force schema into every tenant database by default.

The preferred direction is:

* migrations and seeders remain the canonical source of schema truth
* tenant template databases may be generated from canonical migrations and seeders
* core tables exist for every tenant
* optional module tables are installed only for tenants that activate or receive those modules
* module installation state and module active/inactive state are tracked separately
* module UI and routes remain server-side guarded even when disabled in navigation

This preserves V1's useful post-release module rollout behavior without making a manually maintained template database the only source of truth.

## Known Gaps

Open gaps:

* no ADR yet confirms exact Filament/Livewire introduction timing
* no final UI component inventory exists
* no visual design reference or template decision exists
* no panel boundary test exists
* no optional module schema installation standard exists yet
* no platform-to-tenant access handoff standard exists yet

## Related

* [[V2 App/Architecture/Stack Overview]] | [Stack Overview](Stack%20Overview.md)
* [[V2 App/Architecture/V2 Application Structure]] | [V2 Application Structure](V2%20Application%20Structure.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../Reference/Stack%20-%20Filament%20And%20Livewire.md)
* [[V2 App/Reference/Stack - Frontend Build]] | [Stack - Frontend Build](../Reference/Stack%20-%20Frontend%20Build.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Planning/Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 2]] | [Phase 2 - Implementation Batch 2](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%202.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 3]] | [Phase 2 - Implementation Batch 3](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%203.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 4]] | [Phase 2 - Implementation Batch 4](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%204.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](../Planning/Phase%202/Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](../Planning/Phase%202/Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[Decisions/ADR-0004 - Shared Core Instance And Panel Boundary Direction]] | [ADR-0004 - Shared Core Instance And Panel Boundary Direction](../../Decisions/ADR-0004%20-%20Shared%20Core%20Instance%20And%20Panel%20Boundary%20Direction.md)

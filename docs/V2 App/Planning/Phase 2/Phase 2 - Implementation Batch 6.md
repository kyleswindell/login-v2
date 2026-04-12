# Phase 2 - Implementation Batch 6

## Purpose

Close Phase 2 by finalizing cross-phase contracts, standards updates, and readiness handoff to Phase 3 and Phase 4.

This batch is the phase close-out contract batch.

## Implementation Status

Current status:

* in progress
* Batch 5 completion dependency is satisfied
* first close-out contract lock pass implemented in docs

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical owners:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[Standards/Implementation Status And Development Sync Standard]] | [Implementation Status And Development Sync Standard](../../../Standards/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

## Batch Goal

Finalize all remaining Phase 2 exit contracts so Phase 3 and Phase 4 can start without inventing new core UI/stack patterns.

## In Scope

In scope:

* finalize optional module schema installation direction and implementation-facing contract language
* finalize platform-to-tenant access handoff direction and required audit events
* finalize UI ownership declaration requirements for future module planning/implementation
* finalize dashboard and related custom Blade surface ownership decisions for final stack alignment
* lock which remaining custom Blade surfaces stay custom, move to Filament, or move to hybrid ownership
* sync Phase 2 implementation status across planning and canonical docs
* document explicit handoff contracts to Phase 3 and Phase 4 planning notes

## Out Of Scope

Out of scope:

* new module implementation
* tenant provisioning runtime implementation
* customer/public implementation work
* unrelated operational tooling expansion

## Required Contracts Before Build

1. Batch 5 owner migrations must be complete and documented.
2. Remaining Phase 2 open decisions list must be reduced to zero blockers.
3. Standards touchpoints requiring updates must be identified.
4. Handoff contracts required by Phase 3 and Phase 4 must be listed.
5. Dashboard and shell ownership decisions must be written as implementation contracts, not preference statements.

## Dashboard And Related Blade Review Scope

Batch 6 must explicitly review and close ownership for remaining high-impact custom Blade surfaces that still define the user-facing app experience.

Primary review surfaces:

* dashboard page: `/dashboard`, `resources/views/platform/dashboard.blade.php`
* app shell layout: `resources/views/components/layouts/app.blade.php`
* notification preview behavior in shell: `resources/js/app.js`
* setup shell behavior: `resources/js/setup-sidebar.js`, `resources/views/platform/setup/*`
* settings shell and side navigation: `resources/views/platform/settings/_sidebar.blade.php`, `resources/views/platform/settings/*`
* notifications inbox view: `resources/views/platform/notifications/index.blade.php`
* docs vault view (explicit keep-custom or migration-defer): `resources/views/platform/docs/index.blade.php`

## Batch 6 Dashboard-Centric Decision Matrix

For each reviewed surface, Batch 6 must produce all fields below:

* current owner: custom Blade, Filament, or hybrid
* target owner at Phase 2 close
* route ownership at Phase 2 close
* transitional alias behavior (if any)
* required parity checks before sign-off
* migration defer reason if not migrated in Phase 2

Required parity checks for dashboard and related shell views:

* navigation behavior parity (active states, sidebar/setup visibility, permissions)
* realtime notification parity (header preview, inbox count/state, Echo auth behavior)
* responsive behavior parity (desktop/tablet/mobile shell behavior)
* visual baseline conformance (cards, table density, spacing, headers, empty states)
* authorization parity (no permission regression from custom Blade to target owner)

## Specific Batch 6 Outputs For Dashboard And Related Views

Batch 6 must add these explicit outputs to the phase close-out record:

1. Dashboard ownership decision record:
	* keep custom Blade for Phase 2 close, or
	* migrate to Filament/Livewire scope with defined first implementation slice.
2. Shell ownership decision record:
	* keep full-page Blade shell through Phase 2 close, or
	* adopt scoped persistent Livewire behavior with bounded scope and no broad rewrite.
3. Setup/settings shell decision record:
	* keep hybrid behavior with explicit boundaries, or
	* define grouped migration path and timing.
4. Notifications view decision record:
	* keep custom/Echo ownership through Phase 2 close with documented migration trigger, or
	* define migration target with explicit realtime parity requirements.
5. Docs vault decision record:
	* keep custom as a locked exception, or
	* define post-Phase-2 migration plan and owner.

## Locked Contract Decisions (Pass 1)

### Optional Module Schema Installation Contract

Locked direction:

* keep migrations and seeders as canonical schema source
* add module-level installation state per tenant (`installed`, `enabled`, `disabled`) as separate states
* install optional module schema only for tenants where module install is approved
* keep all module UI/routes server-side guarded regardless of navigation visibility
* permit generated tenant template database artifacts only as build/runtime acceleration outputs derived from canonical migrations/seeders

Implementation-facing requirement for Phase 4+:

* each optional module plan must declare: core tables, optional tables, install migration path, rollback behavior, and seed requirements

### Platform-To-Tenant Access Handoff Contract

Locked direction:

* primary handoff method is an audited, short-lived, single-use handoff token
* token exchange must redirect into tenant-auth context and establish tenant-scoped session boundaries
* fallback support path (when token handoff cannot complete) is explicit tenant login flow; no implicit session sharing across contexts

Required audit events:

* handoff token issued
* handoff token consumed
* handoff token expired or rejected
* platform user entered tenant context
* platform user exited tenant context

### UI Ownership Declaration Contract For Future Modules

Locked requirement:

* every Phase 3/4 module/batch planning note must include a surface ownership matrix with:
	* surface name
	* current owner
	* target owner
	* route owner at delivery
	* permissions/policies
	* parity checks
	* transitional alias/deprecation behavior

### Dashboard And Related Blade Surface Ownership Decisions

Locked Phase 2-close decisions:

* dashboard (`/dashboard`): keep custom Blade through Phase 2 close
* app shell (`resources/views/components/layouts/app.blade.php`): keep full-page Blade shell through Phase 2 close
* notification preview (`resources/js/app.js`): keep custom/Echo behavior through Phase 2 close
* setup and settings shell framing: keep hybrid behavior; migrate grouped forms/workflows incrementally in later phase batches only when parity checks are specified
* notifications inbox view: keep custom Blade plus Echo as target owner through Phase 2 close; migration trigger is feature-complete realtime parity under non-polling behavior
* docs vault: keep custom Blade as locked exception for Phase 2 close

## Cross-Phase Handoff Contracts

Phase 3 must consume:

* platform-to-tenant handoff token contract and mandatory audit events
* module visibility plus ownership declaration contract for customer/public surface planning

Phase 4 must consume:

* optional module schema installation contract (core vs optional tables, install state separation)
* UI ownership declaration matrix requirements per module batch

## Exit Criteria

This batch is complete when:

* all Phase 2 exit criteria in the phase planning owner note are satisfied
* open decision blockers are closed or explicitly deferred with owner and rationale
* dashboard and related custom Blade surfaces have explicit Phase 2 close ownership decisions and parity expectations
* standards and canonical docs are synchronized with final Phase 2 decisions
* Phase 3 and Phase 4 planning notes reference the finalized Phase 2 contracts

## Verification

Verification focus:

* doc cross-link and implementation-status consistency checks
* planning-to-canonical contract language parity checks
* dashboard/shell decision matrix completeness and parity-check coverage
* no dangling references to transitional-only phase assumptions

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 5]] | [Phase 2 - Implementation Batch 5](Phase%202%20-%20Implementation%20Batch%205.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](../Phase%203/Phase%203%20Index.md)
* [[V2 App/Planning/Phase 4/Phase 4 Index]] | [Phase 4 Index](../Phase%204/Phase%204%20Index.md)
* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)

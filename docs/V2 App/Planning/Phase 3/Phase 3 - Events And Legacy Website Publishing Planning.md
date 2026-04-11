# Phase 3 - Events And Legacy Website Publishing Planning

## Purpose

Capture how the V1 custom Events module should influence V2 customer/public view foundations and outward-facing business event presentation.

This note is the detailed planning companion for the Phase 3 customer/public foundation phase. Legacy website JSON connector configuration is deferred to Phase 5 tenant initialization and management.

## Implementation Status

Current status:

* planning drafted from V1 Events module review
* no V2 Events module implementation started
* no legacy website publishing adapter framework exists in V2 yet

Parent planning note:

* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)

## V1 Events Module Review Summary

The V1 Events module is not just an admin CRUD module.

It combines:

* tenant event CRUD
* outward-facing business event publishing
* public tokenized event access
* public upload/photo-drop flows
* sponsor management
* blocked submitter moderation
* website JSON export
* scheduler-driven sync and rollover behavior

That makes it a strong signal that customer/public functionality must exist before broad business module rollout is treated as stable.

## Why This Matters For V2 Sequencing

If V2 builds deep core modules first and delays customer/public surfaces until later, the project would likely need to revisit many modules to add:

* outward-facing route models
* public/customer policy boundaries
* public payload shaping
* customer/public navigation and rendering conventions

That is avoidable rework. For that reason, Events pushes customer/public foundations ahead of the broader module-expansion phase.

Legacy website integration is a separate concern: tenants that need to sync event data to legacy JSON connectors will configure and manage that during Phase 5 tenant initialization via platform-provided GUI. Phase 3 and Phase 4 modules need not implement publishing adapters themselves; they need only expose data contracts that Phase 5 connector setup can consume.

## V2 Direction: Enhancement, Not Replacement

V2 should not treat Events as a separate replacement for a base events feature in the V1 Perfex sense.

Recommended direction:

* define one V2 Events capability set inside the shared core app
* support optional capability toggles or feature profiles within that module
* allow the platform context to enable/disable advanced outward-facing behavior per tenant
* keep the module data-driven rather than code-forked or replacement-style

Suggested capability toggles:

* event channels and collections
* sponsor management
* public event detail visibility
* public short-code access
* photo-drop uploads
* moderation workflow

## Data Contracts For Future Publishing Integration

Phase 3 Events should expose data in a shape that Phase 5 tenant initialization can consume for legacy JSON connector setup.

Required direction:

* Events module should provide clean APIs and query contracts for exporting event data
* event detail payload should be structured as publishable JSON for legacy site consumption
* event list/index payload should support filtering and pagination for incremental syncs

This allows Phase 5 to add a tenant GUI for configuring legacy connector targets without requiring Events to own the connector framework.

## Recommended PostgreSQL Table Direction For Events

Replace V1 `tblevents_*` naming with explicit V2 families:

* `events`
* `event_channels`
* `event_collections`
* `event_sponsors`
* `event_occurrences` if recurrence needs expansion
* `event_upload_submissions`
* `event_blocked_submitters`

Recommended V2 changes from V1:

* separate business event record from publishing state
* use explicit foreign keys and assignment tables instead of implicit option-driven coupling
* use `jsonb` only for metadata or extensibility fields, not core relational structure
* design event queries so they can be called by Phase 5 publishing connectors without circular dependencies

## Public And Customer View Implications

Phase 3 customer/public foundations should establish:

* public route and customer-auth route boundaries
* public-facing event detail rendering rules
* customer/public shell conventions where protected portal views exist
* visibility contracts so modules can declare public, customer-only, staff-only, or platform-only surfaces
* tenant-safe asset and payload exposure rules

Events is the strongest first proving ground for this because it mixes admin configuration, public presentation, moderation, and publishing.

## Batch Recommendation

Recommended first Phase 3 proof-of-concept:

* one V2 Events admin surface
* one public event detail view
* clean event data APIs and query contracts for Phase 5 integration

This proves:

* internal admin UI ownership
* public rendering contracts
* tenant/platform split of control versus data operation
* that Events data is consumable by future phase publishing connectors

## Out Of Scope For This Phase

Not in current Phase 3 scope:

* legacy JSON connector setup GUI or tenant initialization framework
* publishing job framework or scheduler
* full website CMS editing
* WYSIWYG page builder and deployment pipeline
* broad website theme/layout management

The connector setup GUI and Phase 5 tenant-initialization plumbing belong to Phase 5. Events just needs to expose clean data APIs.

## Related

* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](Phase%203%20Index.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [[V2 App/Planning/Phase 4/Phase 4 - Remaining Core Module Planning]] | [Phase 4 - Remaining Core Module Planning](../Phase%204/Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
* [[V1 App/Modules/Events]] | [Events](../../../V1%20App/Modules/Events.md)
* [[V1 App/Features/Event Website Sync]] | [Event Website Sync](../../../V1%20App/Features/Event%20Website%20Sync.md)
* [[V1 App/Architecture/Website Sync Architecture]] | [Website Sync Architecture](../../../V1%20App/Architecture/Website%20Sync%20Architecture.md)

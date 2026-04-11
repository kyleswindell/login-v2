# Phase 3 - Events And Legacy Website Publishing Planning

## Purpose

Capture how the V1 custom Events module should influence V2 customer/public view foundations, outward-facing business event presentation, and interim legacy website JSON publishing.

This note is the detailed planning companion for the Phase 3 customer/public foundation phase.

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
* website publishing adapters
* customer/public navigation and rendering conventions

That is avoidable rework. For that reason, Events pushes customer/public foundations ahead of the broader module-expansion phase.

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
* website JSON publishing
* legacy site compatibility mode

## Platform-Controlled, Tenant-Operated Publishing Model

Required direction:

* website JSON push adapters should be configured and governed by the platform instance
* tenant instances should not own the adapter framework itself
* once the platform configures website publishing for a tenant, day-to-day event operation should happen through the tenant GUI

This creates the right split:

* platform owns integration/publishing capability and policy
* tenant staff own business event data and routine event operations

## Recommended Publishing Architecture In V2

For interim legacy-site support, Phase 3 should support a configurable publishing adapter pattern.

Publishing modes:

1. filesystem JSON write mode
2. authenticated HTTPS endpoint push mode

Recommended adapter concepts:

* `publishing_targets`
* `publishing_target_credentials`
* `publishing_jobs`
* `publishing_job_attempts`
* `published_artifacts`

Recommended initial event payloads:

* event detail JSON
* event index JSON
* optional channel index JSON
* optional sponsor payload

## Recommended PostgreSQL Table Direction For Events

Replace V1 `tblevents_*` naming with explicit V2 families:

* `events`
* `event_channels`
* `event_collections`
* `event_sponsors`
* `event_publications`
* `event_occurrences` if recurrence needs expansion
* `event_upload_submissions`
* `event_blocked_submitters`
* `publishing_targets`
* `publishing_target_assignments`
* `publishing_artifacts`

Recommended V2 changes from V1:

* separate business event record from publishing state
* separate publishing-target config from event content
* use explicit foreign keys and assignment tables instead of implicit option-driven coupling
* use `jsonb` only for payload metadata or target-specific adapter metadata
* use job tables and operational logs for publishing attempts rather than hiding outcomes in a single timestamp column

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
* one legacy JSON publishing adapter proof
* one scheduler or queued publishing flow

This proves:

* internal admin UI ownership
* public rendering contracts
* publishing architecture
* tenant/platform split of control versus operation

## Out Of Scope For This Phase

Not in current Phase 3 scope:

* full website CMS editing
* WYSIWYG page builder and deployment pipeline
* broad website theme/layout management
* tenant self-service publishing adapter creation
* generalized page/block website content system

Those belong to much later website/CMS phases.

## Related

* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](Phase%203%20Index.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [[V1 App/Modules/Events]] | [Events](../../../V1%20App/Modules/Events.md)
* [[V1 App/Features/Event Website Sync]] | [Event Website Sync](../../../V1%20App/Features/Event%20Website%20Sync.md)
* [[V1 App/Architecture/Website Sync Architecture]] | [Website Sync Architecture](../../../V1%20App/Architecture/Website%20Sync%20Architecture.md)

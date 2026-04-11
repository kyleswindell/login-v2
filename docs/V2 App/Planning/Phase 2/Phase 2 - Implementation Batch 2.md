# Phase 2 - Implementation Batch 2

## Purpose

Plan the first Filament proof-of-concept implementation after Phase 2 Batch 1 route, panel, and UI disposition planning.

This batch should validate whether Filament fits the desired shared-core/platform-management UI direction before broader migration work starts.

## Implementation Status

Current status:

* planned
* depends on approval of the Batch 1 route and panel ownership direction
* no Filament package installation has started
* preferred proof target is audit log viewer or error log viewer

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Reference owner:

* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../../Reference/Stack%20-%20Filament%20And%20Livewire.md)

## Batch Goal

Validate whether Filament fits the next UI implementation step before committing to broader Filament adoption.

The goal is not to migrate the whole app. The goal is to validate:

* panel setup
* route compatibility
* visual compatibility
* policy/gate integration
* table/filter/detail ergonomics
* whether Filament should own more Phase 1 admin surfaces

## Proposed Proof Target

Preferred first target:

* error log viewer

Alternative target:

* audit log viewer

Reason:

* read-heavy
* low mutation risk
* already has table/filter/detail behavior
* validates admin-panel value without risking user-management or settings writes

## In Scope

In scope:

* install Filament panel builder if approved
* create the first panel provider
* configure a conservative panel path that avoids current route conflicts
* expose one read-only log viewer surface
* enforce existing permissions through policies/gates
* keep existing Blade route available during the proof
* compare Filament output against current app shell and design requirements
* update canonical docs, planning docs, and Phase 2 development log

## Out Of Scope

Out of scope:

* replacing the full app shell
* migrating users/settings/notifications in the same batch
* tenant runtime implementation
* tenant panel creation
* module installation framework
* public/customer-facing UI

## Required Decisions Before Implementation

Before starting code:

1. Ask whether utilizing Filament applies to the selected batch.
2. If yes, select panel path and proof target.
3. If no, choose the next UI tool to review: Livewire/custom Blade, current Tailwind/Blade components, template/component library, or fully custom UI.
4. Confirm the existing Blade route remains available during evaluation if the proof duplicates an existing screen.
5. Confirm whether this is a shared-core proof, platform-management proof, or platform-only operational proof.
6. Confirm required permission gate/policy.
7. Confirm whether the proof should appear in the existing app navigation or be accessed directly during review.

## Draft Panel Path Options

Candidate paths:

* `/admin` for a generic Filament proof panel
* `/management` for platform-management proof work
* `/console` for internal operational tooling
* `/panel` as a neutral temporary proof path

Do not reuse `/platform` for the first proof until the shared-core route migration plan is finalized.

## Success Criteria

The proof is successful if:

* Filament installs cleanly
* the panel path does not conflict with current routes
* an authorized platform user can access the proof panel
* unauthorized users are denied
* the selected log table supports useful search/filter/detail behavior
* no existing Blade surface regresses
* visual fit is acceptable enough to continue evaluating Filament
* docs accurately record what was implemented and what remains undecided

## Follow-Up Decision

After the proof, decide one of:

* continue with Filament for more admin/data screens
* keep Filament only for platform-management tooling
* use Filament components selectively inside custom Blade/Livewire
* defer Filament and continue custom Blade/Livewire for now

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 1]] | [Phase 2 - Implementation Batch 1](Phase%202%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../../Reference/Stack%20-%20Filament%20And%20Livewire.md)

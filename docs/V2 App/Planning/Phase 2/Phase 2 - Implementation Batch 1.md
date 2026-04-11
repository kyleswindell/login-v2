# Phase 2 - Implementation Batch 1

## Purpose

Define the first Phase 2 batch: final-stack decision audit and UI architecture planning.

This batch should produce decisions and standards before installing new UI framework pieces.

## Implementation Status

Current status:

* in progress
* route and panel ownership map drafted
* UI surface disposition audit drafted
* no code implementation started
* depends on the Phase 2 root planning note and final stack architecture note

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical owner:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)

## Batch Goal

Create the decision foundation for Phase 2 before making implementation changes.

## Scope

In scope:

* audit current Phase 1 UI surfaces
* classify each surface as permanent, transitional, or migration candidate
* define route and panel ownership options
* decide whether Phase 2 should install Filament immediately or defer installation until after route/panel mapping
* decide whether Livewire is needed for persistent shell behavior
* document visual design and template-review requirements
* update standards if future modules need stricter UI ownership declarations
* document optional module schema installation requirements
* document platform-to-tenant access decision options

Out of scope:

* broad UI rebuild
* Phase 3 business modules
* tenant runtime implementation
* production rollout changes

## Required Current-State Audit

Audit these Phase 1 surfaces:

* dashboard
* platform users
* docs vault
* notifications inbox and header preview
* audit log viewer
* error log viewer
* settings pages
* setup pages
* app shell, top header, sidebars, overlays, and user menu

Each surface should receive one of these dispositions:

* keep custom Blade
* convert to Filament
* convert to Livewire/custom component
* leave as transitional until related module work

## Decision Outputs

Batch 1 should produce:

* route and panel ownership map: drafted in [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* UI surface disposition list: drafted in [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* visual design/template decision brief
* Filament install/defer decision: pending, with read-only audit/error log proof favored if Filament is introduced in Batch 2
* Livewire shell decision
* optional module schema installation direction
* platform-to-tenant access direction
* Phase 2 Batch 2 implementation scope

## Current Batch 1 Findings

Findings so far:

* long-term shared core routes should be context-neutral because the domain determines platform versus tenant runtime context
* current `/platform/...` shared-core routes are useful Phase 1 routes but likely transitional
* platform-management capabilities should be available only on platform domains but should not create a separate-looking product
* Filament remains viable, but panel ownership should be decided before installation
* Option B from the route map, separate internal panels with shared styling, is the current planning default
* audit log or error log viewer is the safest first Filament proof target
* docs vault should stay custom Blade for now
* notifications should remain hybrid until Filament/Echo realtime behavior is proven

## Testing And Verification

This batch is documentation and architecture heavy.

Verification should confirm:

* docs link from planning to canonical architecture and back
* decisions are clear enough to convert into implementation tasks
* no future module can start without UI ownership, settings, permissions, logging, and notification expectations

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)

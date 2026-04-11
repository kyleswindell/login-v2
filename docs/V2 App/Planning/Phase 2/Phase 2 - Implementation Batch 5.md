# Phase 2 - Implementation Batch 5

## Purpose

Migrate shared admin surfaces into the locked unified ownership model after route/navigation convergence is complete.

This batch implements the highest-value ownership migrations required for a coherent app experience.

## Implementation Status

Current status:

* planned
* depends on Batch 4 completion

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical owners:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../../Reference/Stack%20-%20Filament%20And%20Livewire.md)

## Batch Goal

Implement dependency-safe owner migrations for users, settings, notifications, and operational log surfaces while preserving permission and behavior parity.

## In Scope

In scope:

* migrate users management surface according to locked owner decision
* migrate settings surfaces according to locked owner decision
* migrate notification inbox ownership while preserving Reverb/Echo behavior
* merge operational log proof surfaces into unified route/navigation ownership
* preserve docs-vault custom behavior unless explicitly re-scoped
* add targeted authorization and regression tests for migrated surfaces
* sync planning/canonical/development docs for each migrated owner change

## Out Of Scope

Out of scope:

* broad visual redesign beyond locked baseline
* tenant runtime rollout
* customer/public surface work
* Phase 4 module implementation

## Required Contracts Before Build

1. Visual baseline/template rules must be locked.
2. Shell ownership and route convergence contracts from Batch 4 must be complete.
3. Surface-by-surface ownership matrix must be locked (owner, route family, permissions, fallback path).
4. Realtime notification behavior contract must remain Reverb/Echo aligned.

## Exit Criteria

This batch is complete when:

* users/settings/notifications/operational logs each have implemented target ownership
* transitional proof-only routing is no longer required for daily operational use
* permission and policy behavior remains correct
* regression checks pass for migrated surfaces
* docs reflect final owner per surface and remaining transitional items (if any)

## Verification

Verification focus:

* authorization matrix tests for each migrated surface
* route access parity checks for old versus new ownership paths
* notification realtime behavior checks (delivery, unread counts, inbox sync)
* no editor-reported errors in touched files

## Follow-Up Batch Dependency

Batch 6 can start after ownership migration is stable and documented.

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 4]] | [Phase 2 - Implementation Batch 4](Phase%202%20-%20Implementation%20Batch%204.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../../Reference/Stack%20-%20Filament%20And%20Livewire.md)
* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)

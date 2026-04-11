# Phase 2 - Implementation Batch 4

## Purpose

Implement route and navigation convergence contracts after the operational Filament proofs were accepted.

This batch turns the Batch 1 decision lock into implementation-ready ownership rules without broad screen migration.

## Implementation Status

Current status:

* in progress
* Batch 2 and Batch 3 operational Filament proofs are complete and accepted
* shell navigation ownership baseline is complete through `App\Platform\Navigation\PlatformNavigation`
* `/console` proof routes are transitional and now require explicit target route/navigation ownership
* visual/template selection remains open and is a dependency for broad migration work

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical architecture owner:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)

Reference owner:

* [[V2 App/Reference/Stack - Frontend Build]] | [Stack - Frontend Build](../../Reference/Stack%20-%20Frontend%20Build.md)

## Batch Goal

Lock and implement the minimum route/navigation convergence slice required before UI-owner migrations begin.

## In Scope

In scope:

* keep shell navigation ownership centralized in backend contracts
* define and implement route alias/convergence behavior for operational proof surfaces
* preserve existing route families while introducing target route ownership mapping
* keep setup navigation visibility permission-driven
* define acceptance checks that prevent new proof-only `/console` expansion
* update planning, canonical architecture/reference, and development log notes in the same work cycle

## Out Of Scope

Out of scope:

* broad route renaming across all surfaces in one deployment
* full shell redesign
* template adoption final decision
* migration of users/settings/notifications screens into final owners
* tenant-domain runtime shell implementation

## Required Contracts Before Build

1. Locked target ownership for audit and error log routes.
2. Decision on whether `/platform/*` remains transitional alias space or target platform-management space.
3. Permission and policy behavior parity between transitional and target routes.
4. Navigation visibility rules for transitional versus target links.

## Exit Criteria

This batch is complete when:

* target route/navigation ownership for operational log surfaces is documented and implemented
* no regression appears in existing Blade and Filament operational log access paths
* navigation contract remains single-source and permission-driven
* docs record which route families are transitional and which are target owners

## Verification

Verification focus:

* route registration checks for both transitional and target route paths
* authorization checks for allowed and denied users
* shell navigation visibility checks by role/permission
* no editor-reported errors in touched files

## Follow-Up Batch Dependency

Batch 5 can start after this batch locks route/navigation convergence and confirms owner mapping for shared admin surfaces.

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 3]] | [Phase 2 - Implementation Batch 3](Phase%202%20-%20Implementation%20Batch%203.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Reference/Stack - Frontend Build]] | [Stack - Frontend Build](../../Reference/Stack%20-%20Frontend%20Build.md)
* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)# Phase 2 - Implementation Batch 4

## Purpose

Implement route and navigation convergence contracts after the operational Filament proofs were accepted.

This batch turns the Batch 1 decision lock into implementation-ready ownership rules without broad screen migration.

## Implementation Status

Current status:

* in progress
* Batch 2 and Batch 3 operational Filament proofs are complete and accepted
* shell navigation ownership baseline is complete through `App\Platform\Navigation\PlatformNavigation`
* `/console` proof routes are transitional and now require explicit target route/navigation ownership
* visual/template selection remains open and is a dependency for broad migration work

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical architecture owner:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)

Reference owner:

* [[V2 App/Reference/Stack - Frontend Build]] | [Stack - Frontend Build](../../Reference/Stack%20-%20Frontend%20Build.md)

## Batch Goal

Lock and implement the minimum route/navigation convergence slice required before UI-owner migrations begin.

## In Scope

In scope:

* keep shell navigation ownership centralized in backend contracts
* define and implement route alias/convergence behavior for operational proof surfaces
* preserve existing route families while introducing target route ownership mapping
* keep setup navigation visibility permission-driven
* define acceptance checks that prevent new proof-only `/console` expansion
* update planning, canonical architecture/reference, and development log notes in the same work cycle

## Out Of Scope

Out of scope:

* broad route renaming across all surfaces in one deployment
* full shell redesign
* template adoption final decision
* migration of users/settings/notifications screens into final owners
* tenant-domain runtime shell implementation

## Required Contracts Before Build

1. Locked target ownership for audit and error log routes.
2. Decision on whether `/platform/*` remains transitional alias space or target platform-management space.
3. Permission and policy behavior parity between transitional and target routes.
4. Navigation visibility rules for transitional versus target links.

## Exit Criteria

This batch is complete when:

* target route/navigation ownership for operational log surfaces is documented and implemented
* no regression appears in existing Blade and Filament operational log access paths
* navigation contract remains single-source and permission-driven
* docs record which route families are transitional and which are target owners

## Verification

Verification focus:

* route registration checks for both transitional and target route paths
* authorization checks for allowed and denied users
* shell navigation visibility checks by role/permission
* no editor-reported errors in touched files

## Follow-Up Batch Dependency

Batch 5 can start after this batch locks route/navigation convergence and confirms owner mapping for shared admin surfaces.

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 3]] | [Phase 2 - Implementation Batch 3](Phase%202%20-%20Implementation%20Batch%203.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Reference/Stack - Frontend Build]] | [Stack - Frontend Build](../../Reference/Stack%20-%20Frontend%20Build.md)
* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)

# Phase 2 - Implementation Batch 4

## Purpose

Start the app shell and navigation baseline work after Phase 2 operational Filament proofs were accepted.

This batch focuses on dependency-safe shell ownership decisions and incremental implementation slices, not broad UI migration.

## Implementation Status

Current status:

* in progress
* Batch 2 and Batch 3 operational Filament proofs are complete and accepted
* first implementation slice is complete: shell navigation ownership is centralized in `App\Platform\Navigation\PlatformNavigation`
* current Blade route surfaces remain unchanged while shell/navigation standards are stabilized
* visual/template selection remains open

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical architecture owner:

* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)

Reference owner:

* [[V2 App/Reference/Stack - Frontend Build]] | [Stack - Frontend Build](../../Reference/Stack%20-%20Frontend%20Build.md)

## Batch Goal

Define and implement the minimum shared shell/navigation contract needed before wider screen migration.

## In Scope

In scope:

* centralize app-shell navigation ownership in backend code so permission and route mapping are not duplicated across menus
* keep existing route families available (`/dashboard`, `/platform/*`, `/console/*`) while ownership decisions continue
* keep setup navigation visibility permission-driven
* add focused regression coverage for shell navigation behavior where practical
* update planning, canonical architecture/reference, and development log notes in the same work cycle

## Out Of Scope

Out of scope:

* broad route renaming or alias migration
* full shell redesign
* template adoption final decision
* migration of users/settings/notifications screens into new owners
* tenant-domain runtime shell implementation

## Delivered Slice 1

Delivered in this work cycle:

* created `App\Platform\Navigation\PlatformNavigation` as the app-shell navigation contract source
* updated the main Blade shell layout to render account, primary, and setup navigation from that contract
* removed duplicated hard-coded navigation lists from the layout
* kept the existing gate behavior and route destinations unchanged
* added dashboard feature assertions for setup-trigger visibility behavior

## Success Criteria

This batch is successful when:

* shell navigation route/permission ownership is centralized
* shell rendering keeps current behavior for authorized and unauthorized users
* setup trigger only appears when setup navigation items are available
* docs clearly record what was implemented and what remains open

## Current Verification State

Current verification:

* PHP syntax checks pass for the new navigation contract class
* focused feature test execution is still blocked in the current non-Docker local environment due PostgreSQL host resolution (`postgres`)
* static Blade/problem checks report no editor errors in the changed files

## Follow-Up Decision

Next decision pass in this batch:

* lock the visual baseline and template-review outcome
* decide whether the existing custom shell remains primary with Filament islands, or whether broader shell ownership shifts further into Filament/Livewire
* define migration order for users/settings/notifications after shell ownership is locked

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 3]] | [Phase 2 - Implementation Batch 3](Phase%202%20-%20Implementation%20Batch%203.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Reference/Stack - Frontend Build]] | [Stack - Frontend Build](../../Reference/Stack%20-%20Frontend%20Build.md)
* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)

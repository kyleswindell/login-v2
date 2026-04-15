# Phase 2 - Implementation Batch 4

This document defines the canonical scope and intent for Phase 2 - Implementation Batch 4.

## Purpose

Implement route and navigation convergence contracts after the operational Filament proofs were accepted.

This batch turns the Batch 1 decision lock into implementation-ready ownership rules without broad screen migration.

## Implementation Status

Current status:

* complete locally
* Batch 2 and Batch 3 operational Filament proofs are complete and accepted
* shell navigation ownership baseline is complete through `App\Platform\Navigation\PlatformNavigation`
* target operational ownership routes now exist under `/platform/operations/*` and redirect to transitional Filament proof paths
* `/console` proof routes remain transitional until Batch 5 ownership migration retires daily-use dependency on them
* visual/template selection remains open and is a Batch 5 entry dependency, not remaining Batch 4 implementation scope

Planning owner:

* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical architecture owner:

* [Final Stack And UI Design Spec](../../../03-architecture/subsystems/final-stack-and-ui-boundary.md)

Reference owner:

* [Stack - Frontend Build](../../../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)

## Batch Goal

Lock and implement the minimum route/navigation convergence slice required before UI-owner migrations begin.

## Delivered Scope

Delivered in this batch:

* centralized shell navigation ownership in `App\Platform\Navigation\PlatformNavigation`
* updated the Blade shell to render account, primary, and setup navigation from the backend contract
* preserved existing `/dashboard`, `/platform/*`, and `/console/*` route families while target ownership was introduced
* added target operational routes at `/platform/operations/audit-logs` and `/platform/operations/error-logs`
* redirected target operational routes to accepted transitional Filament proof paths after gate checks pass
* updated operational navigation links to target `/platform/operations/*` routes instead of direct `/console/*` proof routes
* kept setup navigation visibility permission-driven
* added acceptance checks that prevent shell navigation from rendering direct proof-only `/console` links

## Out Of Scope

Out of scope:

* broad route renaming across all surfaces in one deployment
* full shell redesign
* template adoption final decision
* migration of users/settings/notifications screens into final owners
* tenant-domain runtime shell implementation

## Locked Contracts

1. Audit and error log navigation now belongs to `/platform/operations/*` target routes for Phase 2 shared shell use.
2. `/console/*` remains a transitional Filament proof path and should not receive new daily-use navigation links.
3. Target operational routes must enforce the same gate behavior before redirecting to Filament proof resources.
4. Existing Blade operational routes stay available as compatibility paths until Batch 5 decides final operational owner migration.
5. Shell navigation remains single-source and permission-driven through `App\Platform\Navigation\PlatformNavigation`.

## Exit Criteria

This batch is complete because:

* target route/navigation ownership for operational log surfaces is documented and implemented
* existing Blade and Filament operational log access paths remain available
* navigation ownership is centralized and permission-driven
* docs record `/platform/operations/*` as target transitional ownership and `/console/*` as proof-only routing

## Verification

Verification focus:

* route registration checks for both transitional and target route paths
* authorization checks for allowed and denied users
* shell navigation visibility checks by role/permission
* no editor-reported errors in touched files

Current verification state:

* target routes implemented: `/platform/operations/audit-logs`, `/platform/operations/error-logs`
* target routes enforce parity gates before redirecting to `/console/platform-audit-logs` and `/console/central-error-logs`
* `App\Platform\Navigation\PlatformNavigation` now points operational navigation to target ownership routes
* dashboard acceptance checks confirm operational navigation renders target routes and does not render direct `/console` proof links
* guest and unauthorized access parity checks pass for target operational routes
* focused Docker feature tests pass for audit logs, error logs, and dashboard navigation

## Batch 5 Kickoff Scope

Batch 5 should start with these scope boundaries:

* lock visual baseline/template rules before broad UI-owner migrations
* lock the surface-by-surface owner matrix for users, settings, notifications, and operational logs
* decide whether operational logs move directly into final Filament-owned routes or keep target redirects briefly while users/settings/notifications migrate
* preserve Reverb/Echo notification behavior while inbox ownership is evaluated
* keep docs vault custom Blade unless explicitly re-scoped

Do not start Batch 5 implementation until the visual baseline and owner matrix are explicit.

## Related

* [Phase 2 Index](Phase%202%20Index.md)
* [Phase 2 - Implementation Batch 3](Phase%202%20-%20Implementation%20Batch%203.md)
* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [Final Stack And UI Design Spec](../../../03-architecture/subsystems/final-stack-and-ui-boundary.md)
* [Stack - Frontend Build](../../../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)
* Phase 2 Development Log

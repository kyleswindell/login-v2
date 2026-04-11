# Phase 2 - Implementation Batch 5

## Purpose

Migrate shared admin surfaces into the locked unified ownership model after route/navigation convergence is complete.

This batch implements the highest-value ownership migrations required for a coherent app experience.

## Implementation Status

Current status:

* in progress
* Batch 4 route/navigation convergence is complete locally
* kickoff contracts are being locked before screen migration starts
* visual baseline/template rules are locked for Batch 5 implementation
* surface-by-surface owner matrix is locked for the first migration pass
* first platform-users Filament migration slice is implemented locally

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

Current contract state:

* complete: visual baseline/template rules
* complete: Batch 4 shell ownership and route convergence contracts
* complete: first-pass surface owner matrix
* complete: notifications must preserve Reverb/Echo behavior and avoid polling-first migration

## Kickoff Scope

Start Batch 5 by locking:

* users owner target: keep Blade temporarily, migrate to Filament, or hybrid migration sequence
* settings owner target: identify which settings remain workflow pages versus Filament/admin forms
* notifications owner target: preserve Reverb/Echo delivery, unread counts, and inbox sync while evaluating UI ownership
* operational logs owner target: decide whether `/platform/operations/*` redirects are replaced by direct final Filament-owned routes in this batch
* compatibility paths: define which existing `/platform/*` and `/console/*` routes remain available during migration

Do not implement screen migrations until the owner matrix and visual baseline are recorded in the planning owner and canonical architecture owner.

## Visual Baseline And Template Rules

Batch 5 uses a small custom Tailwind and Filament-aligned baseline instead of adopting a third-party dashboard template.

Rules:

* keep the current full-page Blade shell as the primary app shell for this batch
* use Filament as an integrated admin/data surface owner, not as a separate-looking product
* keep `/console` proof routing transitional and avoid adding new proof-only navigation
* keep page layouts full-width inside the current app shell unless a focused operational record view needs narrower detail width
* use current Tailwind shell primitives for shared navigation, dashboard, notifications, docs, and specialized workflow pages
* use Filament defaults for resource tables, filters, forms, and slide-over/detail behavior where Filament owns the surface
* do not adopt a third-party dashboard/admin template in Batch 5
* defer broad visual redesign until Batch 6 or a later dedicated design-system pass unless a migration needs a local parity fix

## Surface Owner Matrix

| Surface | Batch 5 owner target | Route family | Permissions/gates | Compatibility path | Batch 5 action |
| --- | --- | --- | --- | --- | --- |
| Dashboard | Keep custom Blade | `/dashboard` | authenticated user | none | Preserve as shell/home baseline; no migration in Batch 5. |
| App shell/navigation | Keep custom Blade with backend navigation contract | shared layout | item-specific gates via `App\Platform\Navigation\PlatformNavigation` | none | Preserve and extend only when migrated surfaces need navigation changes. |
| Platform users | Filament candidate, service-backed | `/platform/administration/users` redirects to `/console/platform-users`; current `/platform/users/*` remains until parity | `manage-platform-users` | current Blade `/platform/users/*` | First migration slice implemented locally; preserve validation, role assignment, activation, and profile behavior before retiring Blade. |
| Settings | Hybrid: keep workflow-heavy/custom pages until grouped Filament pages are defined | current `/platform/settings/*` | `manage-platform-settings` | current Blade settings pages | Do not migrate before users owner slice unless a settings page is required to support that migration. |
| Notifications inbox | Keep custom Blade plus Echo for this batch | `/platform/notifications` | `view-platform-notifications` | current Blade inbox and header preview | Preserve realtime behavior; no Filament migration until Echo behavior has parity criteria. |
| Header notification preview | Keep custom shell behavior | app layout and `resources/js/app.js` | `view-platform-notifications` | current header preview | Preserve realtime unread count, preview, and toast behavior. |
| Audit logs | Filament-owned operational surface behind target route | `/platform/operations/audit-logs` | `view-platform-audit-logs` | `/platform/audit-logs` and `/console/platform-audit-logs` | Keep Batch 4 target route for daily navigation; decide final direct Filament route after users/settings/notifications sequencing. |
| Error logs | Filament-owned operational surface behind target route | `/platform/operations/error-logs` | `view-platform-error-logs` | `/platform/error-logs/*` and `/console/central-error-logs` | Keep Batch 4 target route for daily navigation; decide final direct Filament route after users/settings/notifications sequencing. |
| Docs vault | Keep custom Blade | `/platform/docs` | `view-platform-docs` plus configured docs scope | current Blade docs vault | Preserve specialized viewer; no Batch 5 migration. |
| Setup pages | Transitional custom Blade | `/platform/setup/*` | feature-specific view/manage gates | current setup pages | Preserve visibility rules; do not add new setup stubs. |

## First Implementation Slice

After these contracts are synced, the first code migration slice should be platform users because it is CRUD-heavy and maps best to Filament.

Current local implementation:

* `App\Filament\Resources\PlatformUsers\PlatformUserResource` exists
* `/console/platform-users` is registered through the transitional console panel
* `/platform/administration/users` is the app-owned target route and redirects to the Filament users surface after `manage-platform-users` passes
* `User::canAccessPanel()` allows active users with `platform.users.manage` to access the console panel
* current Blade `/platform/users/*` routes remain available and remain the shell navigation target until parity is complete

Required parity before retiring the current Blade users surface:

* list, search, pagination, and row count behavior remain available
* create and edit forms preserve existing validation rules
* role assignment preserves current Spatie role behavior
* activation/deactivation remains available
* staff profile fields remain editable
* permissions remain governed by `manage-platform-users`
* business behavior stays outside Filament resource internals where existing requests, services, policies, or model behavior own it

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

# Phase 2 - Implementation Batch 5

## Purpose

Migrate shared admin surfaces into the locked unified ownership model after route/navigation convergence is complete.

This batch implements the highest-value ownership migrations required for a coherent app experience.

## Implementation Status

Current status:

* ready for final review
* Batch 4 route/navigation convergence is complete
* kickoff contracts are locked
* visual baseline/template rules are locked for Batch 5 implementation
* surface-by-surface owner matrix is locked for the first migration pass
* platform-users Filament migration slice is implemented and shell navigation points to the target users route
* target administration routes now exist for users, notifications, and settings while compatibility paths remain available
* operational setup links now point to target `/platform/operations/*` routes while legacy Blade log viewers remain compatibility paths
* final `/console` panel-path retirement is explicitly deferred to Batch 6 as a close-out contract

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
* operational logs owner target: keep `/platform/operations/*` as the daily-use owner route in this batch and defer final `/console` panel-path retirement to Batch 6
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
| Platform users | Filament candidate, service-backed | `/platform/administration/users` redirects to `/console/platform-users`; current `/platform/users/*` remains until final retirement | `manage-platform-users` | current Blade `/platform/users/*` | Filament parity hardening implemented; shell navigation now points to the target route. |
| Settings | Hybrid/custom Blade for Batch 5 | `/platform/administration/settings` redirects to `/platform/settings/general`; current `/platform/settings/*` remains | `manage-platform-settings` | current Blade settings pages | Target route implemented; grouped Filament page migration deferred until after users parity is stable. |
| Notifications inbox | Keep custom Blade plus Echo for this batch | `/platform/administration/notifications` redirects to `/platform/notifications`; action routes remain under `/platform/notifications/*` | `view-platform-notifications` | current Blade inbox and header preview | Target route implemented; realtime behavior remains custom/Echo-backed. |
| Header notification preview | Keep custom shell behavior | app layout and `resources/js/app.js`; default notification links use `/platform/administration/notifications` | `view-platform-notifications` | current header preview | Realtime unread count, preview, and toast behavior preserved. |
| Audit logs | Filament-owned operational surface behind target route | `/platform/operations/audit-logs` | `view-platform-audit-logs` | `/platform/audit-logs` and `/console/platform-audit-logs` | Daily shell and setup navigation use the target route; legacy Blade viewer and console proof path remain compatibility paths during panel-path retirement planning. |
| Error logs | Filament-owned operational surface behind target route | `/platform/operations/error-logs` | `view-platform-error-logs` | `/platform/error-logs/*` and `/console/central-error-logs` | Daily shell and setup navigation use the target route; legacy Blade viewer and console proof path remain compatibility paths during panel-path retirement planning. |
| Docs vault | Keep custom Blade | `/platform/docs` | `view-platform-docs` plus configured docs scope | current Blade docs vault | Preserve specialized viewer; no Batch 5 migration. |
| Setup pages | Transitional custom Blade | `/platform/setup/*` | feature-specific view/manage gates | current setup pages | Preserve visibility rules; do not add new setup stubs. |

## First Implementation Slice

After these contracts are synced, the first code migration slice should be platform users because it is CRUD-heavy and maps best to Filament.

Current local implementation:

* `App\Filament\Resources\PlatformUsers\PlatformUserResource` exists
* `/console/platform-users` is registered through the transitional console panel
* `/platform/administration/users` is the app-owned target route and redirects to the Filament users surface after `manage-platform-users` passes
* `User::canAccessPanel()` allows active users with `platform.users.manage` to access the console panel
* current Blade `/platform/users/*` routes remain available as compatibility paths
* shell navigation now points Platform Users to `/platform/administration/users`
* Filament create/edit/list parity tests cover search, role assignment, activation, staff fields, and profile updates

## Additional Target Route Slice

Delivered locally:

* `/platform/administration/notifications` redirects to the current Echo-backed notifications inbox after `view-platform-notifications` passes
* `/platform/administration/settings` redirects to the current settings landing page after `manage-platform-settings` passes
* shell notification links and notification fallback URLs use the target notifications route
* setup navigation uses the target settings route while legacy settings pages remain the editable compatibility surface
* operational setup cards use `/platform/operations/audit-logs` and `/platform/operations/error-logs` so setup workflows no longer send users to legacy Blade log viewers

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

## Review Readiness

Batch 5 is ready for final review when these conditions are true:

* target route ownership exists for users, settings, notifications, audit logs, and error logs
* shell navigation uses target ownership routes instead of direct `/console` proof paths
* setup navigation uses target settings and operational routes instead of legacy log viewer paths
* notification header, preview, and fallback URLs use the target notifications route while Echo behavior remains unchanged
* Filament users parity tests cover list/search, create, edit, role assignment, active state, and staff profile fields
* authorization tests cover target routes, compatibility paths, and transitional Filament paths
* planning, canonical feature, canonical architecture, and development docs record the same owner state

Remaining transitional items for Batch 6:

* select the final panel-path retirement plan for `/console`
* decide when to retire legacy Blade users/log viewer compatibility paths
* convert the Batch 5 owner decisions into Phase 3 and Phase 4 scaffolding standards

## Verification

Completed verification:

* PHP syntax checks passed for touched PHP files and tests during implementation slices
* `./vendor/bin/pint --dirty --test` passed
* `git diff --check` passed
* `php artisan route:list --path=platform/administration` lists users, notifications, and settings target routes
* `php artisan route:list --path=platform/operations` lists audit-log and error-log target routes
* Docker feature tests passed for dashboard, platform users, notifications, settings, setup pages, audit logs, and error logs: 69 tests, 259 assertions

## Follow-Up Batch Dependency

Batch 6 can start after Batch 5 final review accepts the implemented target ownership and the documented transitional-path deferrals.

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 4]] | [Phase 2 - Implementation Batch 4](Phase%202%20-%20Implementation%20Batch%204.md)
* [[V2 App/Planning/Phase 2/Phase 2 - UI Surface Disposition Audit]] | [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../../Reference/Stack%20-%20Filament%20And%20Livewire.md)
* [[V2 App/Development/Phase 2 Development Log]] | [Phase 2 Development Log](../../Development/Phase%202%20Development%20Log.md)

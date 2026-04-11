# Phase 2 - UI Surface Disposition Audit

## Purpose

Classify existing Phase 1 UI surfaces so Phase 2 can decide what remains custom, what should move into Filament, and what needs a Livewire or hybrid approach.

## Implementation Status

Current status:

* drafted for Phase 2 Batch 1
* based on current `routes/web.php`, controllers, and Blade views
* Phase 2 Batch 2 selected the error log viewer as the first Filament proof
* the error log proof is deployed and validated on staging at `/console/central-error-logs`
* Phase 2 Batch 3 selected audit logs as the second Filament comparison surface
* audit and error log Filament proofs are accepted as complete for Phase 2 proof purposes
* next Phase 2 focus is app shell, navigation, visual baseline, and template/design decision

Source planning note:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Route map:

* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)

## Disposition Categories

Use these categories:

* `Keep custom`: custom Blade remains the preferred implementation
* `Filament candidate`: likely better as a Filament resource/page
* `Hybrid candidate`: should coordinate Filament/Blade/Livewire/Echo carefully
* `Transitional`: useful now, but should not define future patterns yet

## Surface Audit

| Surface | Current route/view | Current implementation | Recommended disposition | Reason |
| --- | --- | --- | --- | --- |
| Login | `/login`, `resources/views/auth/login.blade.php` | custom Blade auth form | Transitional | May stay custom until Filament panel auth and tenant auth are designed. |
| Dashboard | `/dashboard`, `resources/views/platform/dashboard.blade.php` | custom Blade dashboard cards and links | Hybrid candidate | Dashboard should define the shared app feel; may stay custom or become a Filament/Livewire dashboard after design review. |
| App shell | `resources/views/components/layouts/app.blade.php` | custom top header, sidebar, setup overlay, user menu, notifications | Hybrid candidate | This is the highest-impact Phase 2 UI decision because it controls platform/tenant visual consistency. |
| Platform users | `/platform/users/*`, `resources/views/platform/users/*` | custom Blade CRUD/list | Filament candidate | User management is CRUD-heavy and a good proof-of-concept candidate. |
| Setup pages | `/platform/setup/*`, `resources/views/platform/setup/*` | custom Blade setup landing pages | Transitional | Setup behavior may become module manifest driven and should not be expanded heavily before the route/panel decision. |
| Settings pages | `/platform/settings/*`, `resources/views/platform/settings/*` | custom Blade forms and second-column nav | Filament candidate | Settings are form-heavy and likely benefit from a formal panel/resource/page pattern. |
| Notifications inbox | `/platform/notifications`, `resources/views/platform/notifications/index.blade.php` | custom Blade plus Echo DOM updates | Hybrid candidate | Realtime behavior is already custom/Echo-backed; Filament migration needs care to preserve live updates. |
| Header notification preview | app layout plus `resources/js/app.js` | custom DOM-driven realtime preview | Keep custom for now | It is shell-level behavior and should follow the final shell decision. |
| Audit log viewer | `/platform/audit-logs`, `resources/views/platform/audit-logs/index.blade.php`, proof at `/console/platform-audit-logs` | custom Blade filtered table retained; Filament read-only proof deployed | Filament proof complete | Table/filter-heavy read-only admin surface is a good Filament candidate. |
| Error log viewer | `/platform/error-logs/*`, `resources/views/platform/error-logs/*`, proof at `/console/central-error-logs` | custom Blade list/detail retained; Filament read-only proof deployed | Filament proof complete | Table/detail/filter workflow fits Filament well enough for Phase 2 proof purposes; future operational-log UX improvements are tracked separately. |
| Docs vault | `/platform/docs`, `resources/views/platform/docs/*` | custom repository tree and Markdown viewer | Keep custom | Specialized document viewer is not normal CRUD and should not be first Filament target. |
| Realtime auth endpoint | `/platform/realtime/auth` | controller endpoint for Echo private channels | Keep backend endpoint | This is infrastructure, not an admin surface. |

## First Filament Proof-Of-Concept Candidates

Best candidates:

1. Error log viewer
2. Audit log viewer
3. Platform users
4. Settings pages

Recommended first proof:

* error log viewer

Reason:

* read-heavy
* low mutation risk
* table/filter behavior maps well to Filament
* validates auth, route, layout, and table conventions without risking user-management writes first

Current proof status:

* error log viewer proof is deployed and validated at `/console/central-error-logs`
* audit log viewer proof is deployed and validated at `/console/platform-audit-logs`
* both operational log proofs are accepted as complete for Phase 2 proof purposes

## Screens To Avoid As First Proof

Avoid first:

* docs vault
* notifications inbox
* app shell
* setup shell

Reason:

* docs vault is specialized
* notifications have realtime state synchronization
* app shell decisions affect every screen
* setup shell should wait for module manifest decisions

## Current Recommendation

Phase 2 Batch 2 should not rebuild the whole UI.

Recommended Batch 2 scope:

* decide the panel option from the route map
* install Filament only if the selected proof target is clear
* build one read-only Filament proof surface
* compare the result against the current custom Blade shell and design goals
* only then decide whether to migrate CRUD-heavy screens

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 1]] | [Phase 2 - Implementation Batch 1](Phase%202%20-%20Implementation%20Batch%201.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)

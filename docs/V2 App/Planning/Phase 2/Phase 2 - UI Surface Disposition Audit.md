# Phase 2 - UI Surface Disposition Audit

## Purpose

Classify existing Phase 1 UI surfaces so Phase 2 can decide what remains custom, what should move into Filament, and what needs a Livewire or hybrid approach.

## Implementation Status

Current status:

* completed through Phase 2 Batch 7 as the full UI review and migration record
* based on current `routes/web.php`, controllers, and Blade views
* Phase 2 Batch 2 selected the error log viewer as the first Filament proof
* the error log proof is deployed and validated on staging at `/console/central-error-logs`
* Phase 2 Batch 3 selected audit logs as the second Filament comparison surface
* audit and error log Filament proofs are accepted as complete for Phase 2 proof purposes
* `/console` proof routes are now deprecated from daily ownership and controlled by `CONSOLE_PROOF_PATHS_ENABLED` (default off)
* Batch 5 visual baseline and owner matrix are locked for the first shared admin migration pass
* operational shell and setup navigation now point to `/platform/operations/*` target routes that resolve to app-owned views
* this note now serves as the Batch 6 completion artifact for full existing-UI review and final UI/stack decision sync
* Batch 7 visual migration updates the active dashboard and shared shell styling baseline to the final Phase 2 review target
* Batch 7 UI audit pass normalizes active custom Blade element conventions to the shared Filament-aligned baseline while keeping the locked surface-owner decisions
* Batch 7 correction pass adds account-focused header dropdown options and initial account pages (`/account`, `/account/settings`, `/account/preferences`) as custom Blade ownership

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
| Dashboard | `/dashboard`, `resources/views/platform/dashboard.blade.php` | custom Blade dashboard cards and links | Keep custom | Phase 2 closes with dashboard as app-owned Blade surface; future Livewire/Filament migration is deferred behind explicit parity scope. |
| App shell | `resources/views/components/layouts/app.blade.php` | custom top header, sidebar, setup overlay, user menu, notifications | Keep custom | Batch 6 locks full-page Blade shell for Phase 2 close and prevents broad shell rewrite during close-out. |
| Account pages | `/account*`, `resources/views/platform/account/*` | custom Blade account profile/settings/preferences pages | Keep custom | User-scoped account workflow is shell-native and not a Filament-first surface in this phase. |
| Platform users | `/platform/users/*`, `resources/views/platform/users/*`, target route at `/platform/administration/users`, migration surface at `/console/platform-users` | custom Blade CRUD/list retained; shell target now resolves to app-owned `/platform/users`; direct `/console` proof access is deprecated by default | Hybrid candidate | Batch 6 retires daily shell dependency on `/console` while preserving migration-proof resources behind opt-in proof access. |
| Setup pages | `/platform/setup/*`, `resources/views/platform/setup/*` | custom Blade setup landing pages | Hybrid candidate | Batch 6 closes with setup pages in the app-owned Blade shell; grouped migration is deferred to later phase batches with explicit parity checks. |
| Settings pages | `/platform/settings/*`, target route at `/platform/administration/settings`, `resources/views/platform/settings/*` | custom Blade forms and second-column nav retained; target route implemented | Hybrid candidate | Batch 6 keeps settings custom through Phase 2 close and defers grouped migration timing. |
| Notifications inbox | `/platform/notifications`, target route at `/platform/administration/notifications`, `resources/views/platform/notifications/index.blade.php` | custom Blade plus Echo DOM updates retained; target route implemented | Keep custom | Batch 6 locks custom/Echo ownership through Phase 2 close with realtime parity as migration trigger. |
| Header notification preview | app layout plus `resources/js/app.js` | custom DOM-driven realtime preview | Keep custom | Batch 6 locks this as shell-owned custom behavior through Phase 2 close. |
| Audit log viewer | `/platform/audit-logs`, `resources/views/platform/audit-logs/index.blade.php`, target route at `/platform/operations/audit-logs`, proof at `/console/platform-audit-logs` | custom Blade filtered table retained as compatibility; shell and setup navigation target app-owned route; direct `/console` proof path is opt-in only | Hybrid candidate | Batch 6 retires daily operational routing dependence on `/console` and keeps proof path for controlled compatibility. |
| Error log viewer | `/platform/error-logs/*`, `resources/views/platform/error-logs/*`, target route at `/platform/operations/error-logs`, proof at `/console/central-error-logs` | custom Blade list/detail retained as compatibility; shell and setup navigation target app-owned route; direct `/console` proof path is opt-in only | Hybrid candidate | Batch 6 retires daily operational routing dependence on `/console` and keeps proof path for controlled compatibility. |
| Docs vault | `/platform/docs`, `resources/views/platform/docs/*` | custom repository tree and Markdown viewer | Keep custom | Specialized document viewer is not normal CRUD and should not be first Filament target. |
| Realtime auth endpoint | `/platform/realtime/auth` | controller endpoint for Echo private channels | Keep backend endpoint | This is infrastructure, not an admin surface. |

## Batch 6 Full UI Review Sign-Off Matrix

This section satisfies the Batch 6 completion requirement to confirm the full existing UI review is updated with final Phase 2 UI and stack decisions.

| Surface | Current owner | Target owner at Phase 2 close | Route owner at Phase 2 close | Transitional alias behavior | Required parity checks before sign-off | Migration defer reason |
| --- | --- | --- | --- | --- | --- | --- |
| Dashboard (`/dashboard`) | custom Blade | custom Blade | app-owned `/dashboard` | none | navigation behavior, responsive behavior, visual baseline, authorization parity | preserve shell stability for Phase 3/4 scaffolding start |
| App shell (`resources/views/components/layouts/app.blade.php`) | custom Blade | custom Blade | app-owned shared shell | none | navigation behavior, realtime notification parity, responsive behavior, visual baseline | avoid broad shell rewrite during Phase 2 close-out |
| Notification preview (`resources/js/app.js`) | custom JavaScript + Echo | custom JavaScript + Echo | app-owned shell behavior | none | realtime notification parity, authorization parity | already production-like with Reverb/Echo; migration adds risk without close-out benefit |
| Setup shell (`/platform/setup/*`) | custom Blade | hybrid (custom retained) | app-owned setup routes | none | navigation behavior, responsive behavior, authorization parity | grouped migration depends on module manifest workflow decisions |
| Settings shell (`/platform/settings/*`) | custom Blade | hybrid (custom retained) | app-owned settings routes and administration alias | `/platform/administration/settings` -> `/platform/settings/general` | navigation behavior, responsive behavior, visual baseline, authorization parity | grouped form migration deferred until later batch with explicit parity scope |
| Notifications inbox (`/platform/notifications`) | custom Blade + Echo | custom Blade + Echo | app-owned notifications routes and administration alias | `/platform/administration/notifications` -> `/platform/notifications` | realtime parity, responsive behavior, authorization parity | keep non-polling realtime behavior stable through Phase 2 close |
| Docs vault (`/platform/docs`) | custom Blade | custom Blade (locked exception) | app-owned `/platform/docs` | none | navigation behavior, responsive behavior, authorization parity | specialized docs viewer, not a CRUD-first migration target |

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

Recommended next scope:

* implement the platform-users Filament migration slice first
* preserve settings and notifications as custom Blade/Echo surfaces behind target administration routes
* keep operational log daily navigation on `/platform/operations/*`, including setup cards, while final direct Filament route ownership is decided
* retire proof-only routing from long-term phase intent after shared admin migration behavior is stable

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Route And Panel Ownership Map]] | [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 1]] | [Phase 2 - Implementation Batch 1](Phase%202%20-%20Implementation%20Batch%201.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Reference/UI Design System Standards]] | [UI Design System Standards](../../Reference/UI%20Design%20System%20Standards.md)

# Filament Role Boundary And Console Proof Path Planning

## Purpose

Define the approved role boundary for Filament and the cleanup sequence for transitional `/console/*` proof paths and Filament-backed product-surface coupling.

This planning note does not require Filament removal. Filament may remain installed when it provides useful internal-only tooling, migration, inspection, or prototype value.

## Current Direction

Filament is allowed only as internal tooling unless a later decision explicitly approves a new use.

Filament is not the target architecture for:

- Core Modules
- Core Surface Modules
- Workspace Frame or navigation
- Registry operations
- DocsViewer
- SecurityChecklist
- retired reference viewer
- notifications
- settings

`/console/*` proof paths are transitional. They should not be treated as future route ownership or product UX.

The current dashboard widgets are not critical product behavior. They may be removed, replaced, or redesigned later and should not block console proof-path cleanup or product/dashboard decoupling.

## Current Implementation Inventory

| Area | Current files or routes | Direction |
| --- | --- | --- |
| Filament panel provider | `app/Providers/Filament/ConsolePanelProvider.php` | May remain only for explicitly approved internal tooling. It must not become product Workspace UI ownership. |
| Proof-path gate | `app/Http/Middleware/EnsureConsoleProofPathsEnabled.php`, `CONSOLE_PROOF_PATHS_ENABLED` | Keep temporarily while `/console/*` paths exist. Remove after proof paths are gone. |
| Users proof route | `/console/platform-users`, `app/Filament/Resources/PlatformUsers/*` | Treat as internal/proof tooling, not app-owned user-management evidence. Retire or keep only by explicit internal-tooling decision. |
| Audit log proof route | `/console/platform-audit-logs`, `app/Filament/Resources/PlatformAuditLogs/*` | Treat as internal/proof tooling, not app-owned audit evidence. Retire or keep only by explicit internal-tooling decision. |
| Error log proof route | `/console/central-error-logs`, `app/Filament/Resources/CentralErrorLogs/*` | Treat as internal/proof tooling, not app-owned error-log evidence. Retire or keep only by explicit internal-tooling decision. |
| Dashboard widgets | `app/Filament/Widgets/*`, Filament widget registrations in `AppServiceProvider` | Remove from product dashboard ownership. App-owned Dashboard adapters or future Dashboard module contributions should own rendered dashboard behavior. |
| User access coupling | `App\Models\User implements FilamentUser` | Keep only while a Filament panel/auth surface remains installed. Remove if Filament panel access is removed. |
| Proof tests | Filament-specific assertions in platform feature tests | Keep only isolation/gating tests. Do not count Filament proof renders as product behavior evidence. |

## Boundary Principles

- Do not add new Filament product surfaces.
- Do not add new `/console/*` routes.
- Do not use Filament as the implementation path for new module, Workspace, Registry, settings, notification, docs, security checklist, or retired reference viewer work.
- Keep proof paths default-disabled while installed.
- Do not preserve current dashboard widgets for their own sake.
- Product behavior evidence belongs to app-owned or module-owned routes and tests.
- Filament tests may prove internal-tooling isolation, permission gating, or prototype behavior when intentionally kept.
- Remove compatibility gates after the compatibility target no longer exists.

## Recommended Cleanup Sequence

### 1. Confirm Replacement Coverage

Confirm app-owned views already cover the product behaviors that used to rely on proof routes:

- users list/create/update/status/role assignment
- audit-log list/filter/detail expectations
- error-log list/detail expectations

If a product behavior is missing, add or strengthen app-owned tests before removing Filament proof assertions.

### 2. Stop Treating Filament Widgets As Dashboard Requirements

Remove current Filament dashboard widgets from the product dashboard critical path.

Acceptable outcomes:

- remove the current dashboard widget registrations entirely
- replace them with app-owned Dashboard adapters
- replace them with Dashboard module contributions later
- leave the dashboard with fewer widgets during the transition

Do not build new widget infrastructure just to preserve existing Filament widgets.

### 3. Retire Proof-Route Assertions

For each `/console/*` proof route:

1. Ensure the app-owned route has behavior tests.
2. Remove positive Filament proof-route tests.
3. Keep, at most, one temporary disabled-path redirect test while the route still exists.
4. Keep any Filament route/resource only when it has an explicit internal-tooling purpose.

Current proof routes:

- `/console/platform-users`
- `/console/platform-audit-logs`
- `/console/central-error-logs`
- `/console/login`

### 4. Remove Product Dashboard Coupling

After proof-route assertions are removed:

1. Stop registering Filament widgets in `AppServiceProvider`.
2. Remove dashboard reliance on `App\Filament\Widgets\*`.
3. Keep Dashboard behavior focused on the default authenticated landing route.
4. Defer future widget contribution design to the Dashboard Core Surface Module plan.

### 5. Decide Whether Filament Internal Tooling Remains

After product/dashboard coupling is removed:

1. Keep Filament only if it has an explicit internal-tooling purpose.
2. Keep `/console/*` default-disabled if any proof/internal paths remain.
3. Remove routes/resources/widgets that only duplicate product behavior.
4. Remove `ConsolePanelProvider`, `EnsureConsoleProofPathsEnabled`, and `CONSOLE_PROOF_PATHS_ENABLED` only when no Filament panel path remains.
5. Remove Filament access coupling from `User` only when no Filament auth surface depends on it.

### 6. Re-run Ownership Planning

After product/dashboard coupling is removed and any internal-tooling scope is decided, revisit:

- `User` model ownership and traits
- Dashboard widget contribution contract
- Users/Roles split
- AuditLogging and ErrorLogging module ownership
- route authorization matrix coverage that previously referenced `/console/*`

## Test Transition Plan

Initial cleanup pass should focus on tests that prove app-owned replacements, not Filament product renders.

Recommended test updates:

- keep app-owned user-management tests
- keep app-owned audit-log tests
- keep app-owned error-log tests
- remove Filament positive-render tests after replacement coverage is confirmed
- remove route-matrix `/console/*` proof checks from product route evidence
- remove dashboard widget assertions tied to Filament widgets
- keep disabled redirect tests while proof paths exist

Temporary compatibility tests may remain only while a compatibility route or gate exists.

## Out Of Scope

- rebuilding Dashboard widgets
- future rendered-evidence strategy
- creating Registry operations UI
- creating new module surfaces
- redesigning audit/error/user pages
- changing production deployment posture
- removing Composer dependencies while Filament remains useful as internal tooling

## Follow-Up Implementation Plan

Initial cleanup pass status:

1. App-owned users, audit-log, and error-log tests now carry the product behavior evidence.
2. Positive Filament proof-route tests were removed from platform feature coverage.
3. Product dashboard widget registration now points to app-owned Dashboard adapters instead of `App\Filament\Widgets\*`.
4. Filament widgets no longer implement the app Dashboard rendering contract.
5. `/console/*` disabled-route redirect tests remain while proof paths still exist.

Remaining follow-up:

1. Decide whether each Filament resource still has an explicit internal-tooling purpose.
2. Remove proof paths, the proof-path middleware, and `CONSOLE_PROOF_PATHS_ENABLED` only after any retained internal-tooling paths are approved.
3. Remove Filament access coupling from `User` only when no Filament auth surface depends on it.
4. Revisit Dashboard widget contribution design after Workspace/Core Surface Module naming is stable.


# Module Layout Convention Readiness Review

Review ID: `doc-review-2026-07-02-module-layout-convention-readiness`
Date: 2026-07-02
Type: Review-only governance audit
Status: PARTIAL
Implementation status: implemented with follow-up needed

## Scope

This review covers the readiness of the module layout convention for manifests, optional large-module code folders, module view paths, and current platform view ownership mapping.

This review does not implement code moves, view moves, route changes, migrations, tests, runtime module installation, or tenant provisioning.

## Current Planning Direction

The module system should remain metadata-first. Module ownership is established through manifests and definition coverage before physical folders are reorganized.

Core-owned rendered navigation/layout surfaces and reusable UI primitives remain centralized. Modules contribute surfaces into those rendered placements through declared metadata and explicit extension points.

Dedicated `Modules/<ModuleName>/` package folders are the valid future destination when a module has enough internal orchestration, shared eligibility, tenant eligibility, or surface complexity to justify the boundary. Module-owned views live under the package at `Modules/<ModuleName>/resources/views`. Standard package defaults are derived from folder name through `PackageDefinition::defaults(__DIR__)`, with `PackageRegistrar` owning configured route, view, migration, and optional provider registration.

## Findings

### MLC-F1: Static Definitions Will Need A Definition Split

- Classification: `coverage_gap`
- Priority: P2
- Risk: As modules gain more route, permission, UI entry, settings, command, table, setup, and view-path metadata, a single static Definitions will become harder to review and easier to edit incorrectly.
- Expected contract: Module definitions should remain typed, deterministic, and easy to review by module owner.
- Current behavior: The current foundation keeps complex module definitions in `Definitions`, with simple extracted definitions implemented for Dashboard, Preferences, Roles, UI System, and Runtime Security.
- Recommended correction: Continue splitting definitions into `app/Core/Modules/Definitions/*` when module metadata becomes safer to review separately.

### MLC-F2: View-Path Ownership Evidence Is Implemented For Current View Roots

- Classification: `coverage_gap`
- Priority: P1
- Risk: New platform view directories can appear without a module owner, weakening the module boundary and future tenant/shared classification.
- Expected contract: Each app-owned platform or module view path has exactly one module owner or a documented exclusion.
- Current behavior: Module manifests now include platform and module view-path metadata. Repository validation rejects invalid or duplicate view-path ownership, and definition coverage checks current immediate `resources/views/platform/*` directories plus future `Modules/<ModuleName>/resources/views` package roots when real, non-template module packages are present.
- Recommended correction: Keep this evidence in place as new views are added. The remaining follow-up is rendered-surface consumption of typed module UI entry metadata, not physical file migration.

### MLC-F3: Shared Or Tenant-Eligible Views Still Need A Stable Destination

- Classification: `future_tenant_defer`
- Priority: P2
- Risk: Shared or tenant-eligible views may remain under `resources/views/platform/*` longer than intended, making platform-only and reusable app surfaces harder to distinguish.
- Expected contract: Future shared or tenant-eligible module views live under `Modules/<ModuleName>/resources/views` once the module is intentionally migrated into a package.
- Current behavior: Existing views remain in `resources/views/platform/*`.
- Recommended correction: Migrate only shared or tenant-eligible views after module UI entry consumption is stable. Do not mass move platform-management views.

### MLC-F4: Dedicated Module Packages Need Graduation Rules

- Classification: `implementation_sequence`
- Priority: P2
- Risk: Moving code into `Modules/*` too early can duplicate existing Laravel-standard folders and produce unclear ownership.
- Expected contract: Dedicated module packages exist only for modules with meaningful local orchestration or shared/tenant eligibility needs.
- Current behavior: `Modules/_Template` exists as a non-runtime initializer copy. Dynamic package defaults and the package registrar exist. No runtime module package migration has happened.
- Recommended correction: Require graduation criteria before creating runtime `Modules/<ModuleName>/` packages.

### MLC-F5: Arbitrary Blade Overrides Must Remain Forbidden

- Classification: `platform_singleton_coupling`
- Priority: P1
- Risk: Path-based overrides would make module interactions implicit and difficult to secure or test.
- Expected contract: Cross-module UI reuse happens through declared rendered regions, registered surfaces, reusable components, or explicit extension points.
- Current behavior: The module UI entry contract forbids arbitrary Blade overrides, but no enforcement exists yet.
- Recommended correction: Include override prohibition in future module UI entry validation and view-path ownership tests.

## Valid Existing Boundaries

- `app/Core/Modules` is a suitable owner for module repository and definition infrastructure.
- Existing Laravel-standard folders remain appropriate for current small and core modules.
- `resources/views/platform/*` remains acceptable for platform-management-only and transitional platform surfaces.
- Core rendered-surface ownership stays separate from module-contributed content.

## Recommended Follow-Up Order

1. Continue splitting module definitions into `app/Core/Modules/Definitions/*` when module definition metadata grows or when a definition is safer to review separately; simple extraction proofs are implemented.
2. Add module UI entry metadata for rendered-surface consumption.
3. Use settings navigation as the first rendered-surface consumption proof.
4. Selectively migrate a proof module into `Modules/<ModuleName>/`, with its routes, controllers, views, tests, setup assets, and docs under that parent.
5. Create additional runtime module packages only when graduation criteria are met.

## Implementation Planning Notes

The evidence-first pass has been implemented for current platform view directories and future module view roots. Module engine naming cleanup is implemented, and simple definitions prove real definitions can be externalized. The next implementation should continue rendered-surface consumption or selectively split complex definitions after ownership review, not migrate files.

Mass migration into `Modules/*` is explicitly not the next step.

## Validation Performed

View-path ownership implementation adds focused module repository and definition coverage. No runtime behavior, routes, views, or module install behavior changed.

## Out Of Scope

- tenant isolation
- persisted module state
- runtime module install/setup UI
- dynamic migration execution
- route, controller, test, migration, or view moves
- platform-management surface tenant eligibility

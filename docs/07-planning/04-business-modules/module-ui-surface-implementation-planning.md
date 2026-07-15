# Module UI Entry Implementation Planning

Status: Planning draft
Implementation status: UI entry metadata, validation, settings/setup/preference navigation consumption, and typed registry projections implemented; broader rendered-surface consumption paused pending navigation and settings-pattern review

## Purpose

Sequence implementation for module-contributed UI entries without letting modules copy core rendered layouts, navigation components, or arbitrary Blade paths.

This planning note depends on the canonical [Module System](../03-architecture/module-system.md) architecture contract.

## Implementation Sequence

1. Define UI entry metadata in the module manifest. Completed.
   - Add structured manifest entries for main navigation, settings navigation, settings pages, setup steps, dashboard widgets, content routes/views, extension points, and extension contributions.
   - Keep existing rendering unchanged.

2. Validate UI entry ownership. Completed for module definition metadata.
   - Reject duplicate UI entry keys.
   - Require every user-visible UI entry to declare a permission or explicit authenticated/public marker.
   - Require extension contributions to depend on the module that owns the target extension point.
   - Require platform-management surfaces to remain not tenant-eligible by default.

3. Classify current UI entries. Completed for current navigation, settings, setup, dashboard widget, and main-view evidence.
   - Map existing navigation groups, settings pages, setup pages, dashboard widgets, and platform-only pages into module-owned UI entry declarations.
   - Keep current routes and Blade views stable.

4. Make rendered surfaces consume typed module UI entry sets. Completed for settings navigation, setup navigation, and account preference navigation.
   - First candidate was settings navigation.
   - Render the same user-visible UI from module UI entry metadata.
   - Keep old config available only until parity is proven.

5. Expand rendered-surface consumption after navigation ownership and settings patterns are ready.
   - Header menu.
   - App sidebar.
   - Setup navigation.
   - Dashboard widgets.
   - Content page registration.
   - Extension point rendering.
   - Use renderers only for registry-driven surfaces; normal content pages should remain thin URL views backed by ViewModels/PageData and reusable patterns.

6. Add persisted module contribution registry projections. Completed for module, notification type, settings page, setup screen, and preference page metadata.
   - Keep manifests as canonical source.
   - Sync into split registry tables.
   - Preserve removed declarations as inactive and stale.
   - Do not use DB rows to author executable routes, views, handlers, permissions, or notification types.

7. Add persisted module lifecycle state after rendered-surface consumption is proven.
   - Store instance-local module lifecycle state.
   - Use module state to decide whether optional shared and platform-management surfaces are visible.
   - Keep core modules locked and always enabled.

## Acceptance Criteria

- Every current navigation item has one module owner.
- Every settings page has one module owner.
- Every setup page has one module owner.
- Every dashboard widget has one module owner.
- Every extension contribution targets a declared extension point.
- No module-rendered surface bypasses authorization metadata.
- Core rendered layouts and navigation components remain core-owned.
- Existing UI remains visually and behaviorally unchanged until a rendered surface is intentionally migrated to module-surface consumption.

## Current Implementation Notes

- `Manifest` includes typed UI entry metadata.
- `Repository` validates duplicate surface keys, required targets, explicit access metadata, extension-point dependencies, and platform-management tenant eligibility.
- Definitions coverage proves current navigation routes, settings pages, setup screens, dashboard widgets, and top-level platform content views have module-owned UI entry metadata.
- `modules:sync-registries` projects module, notification type, settings page, setup screen, and preference page declarations into split registry tables for global lists and stale-state visibility.
- Settings, Setup, and Preferences navigation builders use active, non-stale registry rows after sync while continuing to resolve executable route/view/access behavior from manifests.
- Runtime rendering still uses the existing route, controller, dashboard, main navigation, and Blade sources outside the intentionally migrated Settings/Setup/Preferences navigation paths.
- View Surface composition is tracked in [View Surface Composition Planning](../03-platform-surfaces/view-surface-composition-planning.md). The accepted direction is thin URL views plus reusable patterns for normal pages. Current renderer placement under `app/Platform/*` is transitional only; target renderers remain with the owning Core capability or Module Surface and consume Contributions already resolved by the Host-owned Registry.
- The next implementation pass should not consume more rendered navigation metadata yet. It should first resolve header menu ownership, notification bell ownership, settings/setup separation, and the settings page pattern dependencies documented in `doc-review-2026-07-03-header-navigation-settings-pattern-readiness`.
- Human-facing planning should use rendered surface names such as header menu, notification bell, app sidebar, settings sidebar, setup navigation, account menu, dashboard widgets, and content views. Existing internal enum names remain code metadata until a later rename is approved.

## Out Of Scope

- Dynamic code loading
- Tenant resolver implementation
- Tenant database provisioning
- Runtime module install UI
- Destructive uninstall
- Arbitrary Blade path overrides
- Full route renaming away from current `platform.*` names
- Universal renderers for every CRUD/detail/form/business page
- Renderer-driven field/table/page DSLs that replace normal Blade composition

# Phase 2 - Implementation Batch 11

## Purpose

Introduce a widget-based, user-customizable dashboard as the platform's primary operational summary surface, replacing the static Blade stat-card view with a Livewire-driven layout engine, per-user persistence, drag-and-drop widget reordering, and a WidgetRegistry extension point for future module widgets.

## Implementation Status

Current status:

* implemented and locally verified in Docker
* all deliverables created, static analysis clean, and dashboard feature tests passing

Planning owner:

* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical owner:

* [[V2 App/Features/Dashboard]] | [Dashboard](../../Features/Dashboard.md)

## Batch Goal

Replace the static `/dashboard` view with a user-customizable widget grid. Deliver four core platform widgets (stats overview, audit activity, error health, notifications summary). Establish a WidgetRegistry contract so Phase 4 module widgets can self-register without patching core dashboard code.

## Infrastructure Decision

**Approach: native Filament widget classes + Livewire orchestration + SortableJS**

Rationale:

* Filament 5.5 (installed) provides mature widget class types — `StatsOverviewWidget`, `TableWidget`, chart widgets, and custom widgets — with built-in authorization via `canView()`.
* The Filament Custom Dashboards plugin (official, paid, $89-$224) was evaluated and set aside for this batch. It is a full user-configures-everything system more suited to a BI or analytics product than a platform operational dashboard. It would also introduce a paid dependency on the core platform scaffold.
* A custom Livewire `DashboardPage` component owns layout state, lock/unlock, drag-drop binding, and DB persistence. This keeps drag-drop logic in the application layer rather than a third-party SaaS.
* SortableJS is the drag-drop primitive; it dispatches a Livewire event on reorder. No heavyweight frontend framework is introduced.

## Target Surfaces

* `/dashboard` — primary platform admin dashboard. Rebuilt as a Livewire component in this batch.
* `/console` Filament panel dashboard — remains the AccountWidget-only transitional surface. Not modified in this batch. Convergence is a Phase 2 close-out concern.

## Core Data Contract

`user_dashboard_layouts` table:

| Column | Type | Notes |
|---|---|---|
| `id` | bigint, PK | |
| `user_id` | bigint, FK → users | one row per user |
| `layout` | json | array of `{widget_key, position, column_span, is_visible}` |
| `is_locked` | boolean | default true — locked mode hides drag handles |
| `created_at` / `updated_at` | timestamps | |

Unique constraint: `user_id` (one layout per user).

## Widget Manifest (Phase 2 Core Widgets)

| Widget Key | Class | Type | Permission Gate |
|---|---|---|---|
| `platform_stats` | `PlatformStatsOverview` | StatsOverview | none (all authenticated platform users) |
| `audit_activity` | `RecentAuditActivity` | Table | `view-platform-audit-logs` |
| `error_health` | `PlatformErrorHealth` | StatsOverview | `view-platform-error-logs` |
| `notifications_summary` | `SystemNotificationsWidget` | Custom | `view-platform-notifications` |

## WidgetRegistry Contract

`app/Platform/Dashboard/WidgetRegistry.php`:

* `register(string $key, string $widgetClass): void` — modules call this in their ServiceProvider boot.
* `getAll(): array` — returns all registered widget classes.
* `defaults(): array` — returns the default layout order and column span per widget key.
* Bound as a singleton in `AppServiceProvider::register()`.

Module integration pattern (Phase 4):

```php
// In module ServiceProvider::boot()
app(WidgetRegistry::class)->register('my_module_widget', MyModuleWidget::class);
```

## In Scope

* `user_dashboard_layouts` migration and `UserDashboardLayout` model
* `WidgetRegistry` service and `AppServiceProvider` singleton binding
* four core platform widgets (`PlatformStatsOverview`, `RecentAuditActivity`, `PlatformErrorHealth`, `SystemNotificationsWidget`)
* `DashboardPage` Livewire component — layout load, lock/unlock, reorder, toggle visibility, reset
* SortableJS integration for drag-and-drop in edit mode
* dashboard Livewire view replacing `resources/views/platform/dashboard.blade.php`
* updated `/dashboard` route wired to the Livewire component
* gate definitions for `view-platform-stats` and `view-platform-dashboard-widgets` in `AppServiceProvider`
* `Dashboard.md` canonical feature doc created and linked
* Phase 2 Index and Feature Index updated

## Out Of Scope

* `/console` Filament panel dashboard custom page
* chart widgets (Phase 4 expansion when module data is available)
* module widget implementations (Phase 4 — WidgetRegistry contract is the Phase 2 hook)
* customer-facing or tenant-facing dashboard surfaces
* financial, project, tickets, leads, events widgets from V1 (depend on modules not yet built)
* real-time widget auto-refresh (Echo-driven; deferred until Echo integration is confirmed in this surface)
* widget filter forms (no aggregation filters needed at platform-stats scope)
* "Generate Test Notification" button — retired with the old static dashboard view; test flow now lives in the notification admin surface

## Required Deliverables

1. `user_dashboard_layouts` migration deployed and verified.
2. `UserDashboardLayout` model with JSON cast and `belongsTo(User::class)`.
3. `WidgetRegistry` service registered as a singleton.
4. Four core widget classes implemented with correct data queries and `canView()` guards.
5. `DashboardPage` Livewire component with lock/unlock, reorder, visibility toggle, and reset actions.
6. Dashboard Livewire view rendering the widget grid in locked and edit modes.
7. SortableJS wired to Livewire on the widget grid.
8. `/dashboard` route updated to serve the Livewire component.
9. `Dashboard.md` canonical feature doc created and cross-linked.
10. Phase 2 Index and Feature Index updated.

## Verification

Verification focus:

* platform stats widget shows live counts sourced from `users`, `settings`, and `notifications` tables
* error health widget reflects current `central_error_logs` data (24h and 7d windows)
* audit activity widget renders last 10 rows from `platform_audit_logs`
* drag-to-reorder persists — page refresh reflects updated `user_dashboard_layouts.layout`
* widget eye-toggle persists — visibility state survives refresh
* lock/unlock persists — `is_locked` column updated correctly
* `canView()` gate: user without `view-platform-audit-logs` permission sees no audit widget
* new user with no saved layout receives the default layout without error
* `resetLayout()` clears saved preferences and reloads defaults
* no auth or policy regressions on the `/dashboard` route

## Exit Criteria

This batch is complete when:

* all four core platform widgets render real data for authenticated users with correct permissions
* layout drag/reorder, lock/unlock, and visibility toggle all persist to the database
* default layout loads for users with no saved preferences
* old `DashboardController` and static `platform/dashboard.blade.php` are retired
* `Dashboard.md` canonical doc is linked and status is current
* Phase 2 Index and Feature Index are updated

## Related

* [[V2 App/Planning/Phase 2/Phase 2 Index]] | [Phase 2 Index](Phase%202%20Index.md)
* [[V2 App/Features/Dashboard]] | [Dashboard](../../Features/Dashboard.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../../Reference/Stack%20-%20Filament%20And%20Livewire.md)

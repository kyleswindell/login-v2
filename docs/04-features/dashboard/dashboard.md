# Dashboard

This document defines the canonical scope and intent for Dashboard.

## Overview

The platform dashboard (`/dashboard`) is the primary operational summary surface for authenticated platform staff. It presents a widget grid that surfaces live data from the platform's core subsystems — users, settings, notifications, audit logs, and error logs — with per-user layout customization, widget visibility control, and lock/unlock drag-and-drop positioning.

## Planning Source

* [Phase 2 - Implementation Batch 11](../../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%2011.md)

## Implementation Status

Current status:

* code-complete — Phase 2 Batch 11
* model, widget classes, Livewire component, Blade view, and JS delivered
* dashboard feature test file passes in Docker (`PlatformDashboardTest`)
* not yet deployed to staging

Known gaps:

* chart widgets deferred to Phase 4 (no module data available yet)
* real-time widget auto-refresh deferred (Echo integration on this surface not confirmed)
* module widget implementations deferred to Phase 4

## Route

`GET /dashboard` → `App\Livewire\Platform\Dashboard\DashboardPage`

Named route: `dashboard`

## Feature Rules

* default layout is provided for users without a saved layout
* user customization persists widget order, visibility, lock state, and validated placement metadata between sessions
* widget visibility is permission-aware and controlled per signed-in user context
* module widgets are supported through the shared dashboard extension contract
* saved layout state is keyed by stable widget identity and reconciled against the current widget registry on load so stale or invalid placement metadata cannot drift silently

Architecture ownership for dashboard subsystem boundaries and registry model lives in:

* [Dashboard Subsystem](../../03-architecture/subsystems/dashboard.md)

Data contract ownership for dashboard layout persistence lives in:

* [Dashboard Layout Data Contract](../../06-database/feature-contracts/dashboard-layout.md)

## Widget Manifest

| Widget Key | Class | Widget Type | Permission Gate |
|---|---|---|---|
| `platform_stats` | `PlatformStatsOverview` | `StatsOverviewWidget` | all authenticated platform users |
| `audit_activity` | `RecentAuditActivity` | `TableWidget` | `view-platform-audit-logs` |
| `error_health` | `PlatformErrorHealth` | `StatsOverviewWidget` | `view-platform-error-logs` |
| `notifications_summary` | `SystemNotificationsWidget` | custom | `view-platform-notifications` |

### Widget Data Sources

**PlatformStatsOverview**:
* Total Users — `User::count()`
* Active Users — `User::where('is_active', true)->count()`
* Unread Notifications — current user's unread notification count

**RecentAuditActivity**:
* Last 10 records ordered by `occurred_at` desc
* Columns: occurred_at, event_type, action, actor, result, severity

**PlatformErrorHealth**:
* Errors last 24h
* Errors last 7 days
* Critical errors last 7 days

**SystemNotificationsWidget**:
* Last 5 unread notifications for the current user
* Shows title, body, severity, and action link

## Customization UX

### Lock Mode (default)

* Clean widget grid, no edit controls visible
* "Customize" button in the page toolbar unlocks edit mode

### Edit Mode (unlocked)

* Each widget card shows a drag handle (activates SortableJS) and a visibility eye-icon toggle
* Changing order or visibility writes to `user_dashboard_layouts` via Livewire actions
* "Lock Dashboard" button in the toolbar saves state and returns to locked view
* "Reset to Defaults" button clears the saved layout and reloads the default configuration
* saved layout state belongs to the signed-in user only; customization on one account does not rewrite another user's dashboard

### Drag-and-Drop

SortableJS is initialized on the widget grid container when edit mode is active. On drag end, SortableJS sends the ordered visible widget keys back to Livewire, which rebuilds the saved layout deterministically from stable widget identity plus validated placement metadata before writing the result to the database.

JS entry point: `resources/js/dashboard-sort.js`

## Permission Gates

Gates are defined in `AppServiceProvider::boot()`:

| Gate | Permission Check | Consuming Widget |
|---|---|---|
| `view-platform-audit-logs` | `platform.audit-logs.view` | `RecentAuditActivity` |
| `view-platform-error-logs` | `platform.error-logs.view` | `PlatformErrorHealth` |
| `view-platform-notifications` | `platform.notifications.view` | `SystemNotificationsWidget` |

The `PlatformStatsOverview` widget has no gate — visible to all authenticated platform users.

## Important Files

| File | Role |
|---|---|
| `app/Platform/Dashboard/WidgetRegistry.php` | Widget registration and default layout contract |
| `app/Models/UserDashboardLayout.php` | Layout persistence model |
| `app/Livewire/Platform/Dashboard/DashboardPage.php` | Dashboard Livewire component |
| `resources/views/livewire/platform/dashboard.blade.php` | Dashboard view |
| `resources/js/dashboard-sort.js` | SortableJS initialization and Livewire bridge |
| `app/Filament/Widgets/PlatformStatsOverview.php` | Stats widget |
| `app/Filament/Widgets/RecentAuditActivity.php` | Audit activity widget |
| `app/Filament/Widgets/PlatformErrorHealth.php` | Error health widget |
| `app/Filament/Widgets/SystemNotificationsWidget.php` | Notifications summary widget |
| `app/Providers/AppServiceProvider.php` | WidgetRegistry singleton binding + widget gate definitions |
| `routes/web.php` | `/dashboard` route |

## Known Gaps

* Chart widgets (line/bar/pie) — no module data in Phase 2; deferred to Phase 4.
* Real-time auto-refresh — Echo-on-dashboard integration deferred; widgets refresh on full page load only.
* Module widget implementations — WidgetRegistry contract exists; module widgets arrive with their modules in Phase 4.
* Customer/tenant dashboard surfaces — out of scope for this feature; separate surfaces per Phase 3/4 planning.

## Related

* [Features Index](../index.md)
* [Platform Notifications And Settings](../notifications/platform-notifications-and-settings.md)
* [Event And Error Logging](../logging/event-and-error-logging.md)
* [Dashboard Subsystem](../../03-architecture/subsystems/dashboard.md)
* [Dashboard Customization Flow](../../05-flows/dashboard-customization-flow.md)

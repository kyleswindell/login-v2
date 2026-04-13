# Dashboard

## Overview

The platform dashboard (`/dashboard`) is the primary operational summary surface for authenticated platform staff. It presents a widget grid that surfaces live data from the platform's core subsystems — users, settings, notifications, audit logs, and error logs — with per-user layout customization, widget visibility control, and lock/unlock drag-and-drop positioning.

## Planning Source

* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 11]] | [Phase 2 - Implementation Batch 11](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%2011.md)

## Implementation Status

Current status:

* code-complete — Phase 2 Batch 11
* migration, model, WidgetRegistry, widget classes, Livewire component, Blade view, JS all delivered
* dashboard feature test file passes in Docker (`PlatformDashboardTest`)
* not yet deployed to staging

Known gaps:

* chart widgets deferred to Phase 4 (no module data available yet)
* real-time widget auto-refresh deferred (Echo integration on this surface not confirmed)
* module widget implementations deferred to Phase 4

## Route

`GET /dashboard` → `App\Livewire\Platform\Dashboard\DashboardPage`

Named route: `dashboard`

## Architecture

### Layer Responsibilities

| Layer | Class | Responsibility |
|---|---|---|
| Route | `routes/web.php` | Auth-gated entry, named `dashboard` |
| Livewire Component | `DashboardPage` | Layout state, persistence, lock/unlock, reorder, visibility toggle |
| Widget Registry | `WidgetRegistry` | Registers widget keys/classes; owns default layout contract |
| Widget Classes | `app/Filament/Widgets/` | Data queries, rendering, `canView()` authorization per widget |
| Layout Model | `UserDashboardLayout` | Persists per-user layout JSON and `is_locked` flag |

### Layout Storage

`user_dashboard_layouts` table — one row per user:

```
id            bigint PK
user_id       bigint FK → users (unique)
layout        json     — array of {widget_key, position, column_span, is_visible}
is_locked     boolean  — default true
created_at    timestamp
updated_at    timestamp
```

Default layout is defined in `WidgetRegistry::defaults()`. New users with no saved row receive this default.

### WidgetRegistry

`app/Platform/Dashboard/WidgetRegistry.php`

Bound as a singleton in `AppServiceProvider::register()`.

Key methods:

* `register(string $key, string $widgetClass): void` — used by modules to self-register in their ServiceProvider boot
* `getAll(): array` — returns all registered `[key => class]` pairs
* `defaults(): array` — returns the default layout array `[{widget_key, position, column_span, is_visible}]` for initial/reset state

Core widgets are registered during `AppServiceProvider::boot()`.

### Module Extension Pattern

Phase 4 modules that ship a dashboard widget register in their ServiceProvider:

```php
public function boot(): void
{
    app(\App\Platform\Dashboard\WidgetRegistry::class)
        ->register('my_module_key', \App\Filament\Widgets\Modules\MyModuleWidget::class);
}
```

Module widgets must implement `canView(): bool` to gate their own visibility. By convention, module widget classes live in `app/Filament/Widgets/Modules/`.

## Widget Manifest

| Widget Key | Class | Widget Type | Permission Gate |
|---|---|---|---|
| `platform_stats` | `PlatformStatsOverview` | `StatsOverviewWidget` | all authenticated platform users |
| `audit_activity` | `RecentAuditActivity` | `TableWidget` | `view-platform-audit-logs` |
| `error_health` | `PlatformErrorHealth` | `StatsOverviewWidget` | `view-platform-error-logs` |
| `notifications_summary` | `SystemNotificationsWidget` | custom | `view-platform-notifications` |

### Widget Data Sources

**PlatformStatsOverview** — reads from `users` and `notifications` tables:
* Total Users — `User::count()`
* Active Users — `User::where('is_active', true)->count()`
* Unread Notifications — current user's unread notification count

**RecentAuditActivity** — reads from `platform_audit_logs`:
* Last 10 records ordered by `occurred_at` desc
* Columns: occurred_at, event_type, action, actor, result, severity

**PlatformErrorHealth** — reads from `central_error_logs`:
* Errors last 24h
* Errors last 7 days
* Critical errors last 7 days

**SystemNotificationsWidget** — reads from `notifications`:
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

### Drag-and-Drop

SortableJS is initialized on the widget grid container when edit mode is active. On drag end, SortableJS dispatches a browser CustomEvent that Livewire's `@this.call('reorderWidgets', layout)` picks up. Livewire writes the new order to the database.

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
| `database/migrations/2026_04_13_000001_create_user_dashboard_layouts_table.php` | Schema |
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

* [[V2 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 11]] | [Phase 2 - Implementation Batch 11](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%2011.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../Reference/Stack%20-%20Filament%20And%20Livewire.md)
* [[V2 App/Features/Platform Notifications And Settings]] | [Platform Notifications And Settings](Platform%20Notifications%20And%20Settings.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](Event%20And%20Error%20Logging.md)

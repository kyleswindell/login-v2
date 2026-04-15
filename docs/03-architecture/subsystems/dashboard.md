# Dashboard Subsystem

This document defines the canonical scope and intent for Dashboard Subsystem.

## Purpose

Define the dashboard subsystem architecture boundary, ownership model, and extension contract.

## Layer Responsibilities

| Layer | Class | Responsibility |
|---|---|---|
| Route | `routes/web.php` | Auth-gated dashboard entry, named `dashboard` |
| Livewire Component | `DashboardPage` | Layout state, persistence triggers, lock/unlock, reorder, visibility toggle |
| Widget Registry | `WidgetRegistry` | Registers widget keys/classes and owns the default layout contract |
| Widget Classes | `app/Filament/Widgets/` | Data queries, rendering, and `canView()` authorization per widget |
| Layout Model | `UserDashboardLayout` | Persists per-user layout JSON and `is_locked` state |

## Widget Registry Contract

`app/Platform/Dashboard/WidgetRegistry.php` is bound as a singleton in `AppServiceProvider::register()`.

Key methods:

* `register(string $key, string $widgetClass): void`
* `getAll(): array`
* `defaults(): array`

Core widgets are registered during `AppServiceProvider::boot()`.

## Module Extension Contract

Modules that provide dashboard widgets register them through `WidgetRegistry` in the module service provider.

Module widget classes are expected to implement `canView(): bool` for permission-aware visibility.

## Data Boundary

Dashboard layout persistence schema is defined in:

* [Dashboard Layout Data Contract](../../06-database/feature-contracts/dashboard-layout.md)

## Related

* [Architecture Index](../index.md)
* [Dashboard Feature](../../04-features/dashboard/dashboard.md)

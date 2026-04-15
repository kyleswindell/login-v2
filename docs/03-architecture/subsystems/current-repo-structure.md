# Current Repo Structure

This document defines the canonical scope and intent for Current Repo Structure.

## Purpose

Describe the current implementation structure that exists in the App 2.0 repository today.

## Active Structure

- `app/Http/Controllers/Platform/` owns app-routed platform controllers such as account, settings, notifications, docs, audit logs, and error logs
- `app/Livewire/Platform/` owns Livewire-powered app surfaces such as the dashboard
- `app/Providers/Filament/` owns Filament panel registration for transitional console proof paths
- `app/Platform/` owns platform-specific services, registries, navigation, docs access, logging, notifications, and settings support code
- `app/Models/` owns Eloquent models for current platform data such as users, settings, notifications, logs, and dashboard layout persistence
- `resources/views/platform/` owns app-routed Blade views for platform features
- `resources/views/livewire/platform/` owns Livewire-rendered platform views
- `routes/web.php` owns current app-owned web route registration and target-route redirects

## Boundary Notes

- the current repo does not yet implement the planned `app/Tenant/` runtime split
- the current repo uses app-owned platform routes as the primary user-facing surface
- the `/console/*` Filament panel remains a transitional proof surface controlled by environment configuration and middleware

## Related

- [Application Structure](application-structure.md)
- [Dashboard Subsystem](dashboard.md)
- [Platform Boundary](../platform-boundary.md)
- [Console Proof Paths](../../10-runbooks/console-proof-paths.md)

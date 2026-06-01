# Platform Workspace And Documentation Vault

This document defines the canonical scope and intent for Platform Workspace And Documentation Vault.

## Purpose

Describe the current platform shell, dashboard workspace, and in-app documentation viewer.

## Implementation Status

Current status:

* implemented in code
* deployed on staging
* active staging review has already driven follow-up layout and docs-viewer corrections
* search remains a placeholder only
* header notifications preview is live on staging
* realtime header notification sync and toast hooks are live on staging
* Setup sidebar shell interaction and selective feature setup pages are live on staging
* app-owned `/platform/ui-reference` workspace is implemented as the canonical shell/component baseline review surface (forms, tables, tokens, drawers) and is limited to users with the dedicated review permission

## Current Implementation

The current platform shell includes:

* a full-width authenticated layout
* top header with brand, search placeholder, recent-notifications preview, and user menu
* platform navigation for dashboard, users, and docs
* Setup sidebar shell that slides over the primary sidebar navigation
* selective setup landing pages for features that need setup-oriented workflows instead of linking Setup directly to the main feature list page
* dashboard cards for users, settings, notifications, and docs counts
* a dedicated documentation-vault workspace mode with the repository tree replacing the normal app sidebar

The docs viewer currently supports:

* default file selection
* collapsible folder tree
* selected-file highlighting
* markdown rendering
* relative in-app link rewriting
* cleaned display names without visible `.md` extensions

## Important Files

* `resources/views/components/layouts/app.blade.php`
* `app/Livewire/Platform/Dashboard/DashboardPage.php`
* `resources/views/livewire/platform/dashboard.blade.php`
* `resources/views/platform/docs/index.blade.php`
* `resources/views/platform/ui-reference/index.blade.php`
* `resources/views/platform/docs/partials/tree-node.blade.php`
* `app/Http/Controllers/Platform/DocsController.php`
* `app/Http/Controllers/Platform/UiReferenceController.php`
* `app/Platform/Docs/DocsRepository.php`

## Permissions / Security

Current gates:

* docs viewer access is limited to users who can `view-platform-docs`
* docs viewer access also respects the configured docs access scope
* the current intended audience can be restricted to platform super admins through settings
* UI Reference access is limited to users who can `view-platform-ui-reference`

## Common Workflows

Current workflows:

* review system counts and quick links from the dashboard
* browse the current `docs/` vault without leaving the app
* open Setup and move into setup-oriented pages for docs, notifications, audit logs, error logs, or platform users
* navigate back to the main platform workspace from the docs viewer

## Known Gaps

Current gaps:

* header search is a placeholder only
* no docs full-text search yet
* no deploy visibility surface in the app yet

## Related

* [Features Index](../index.md)
* [Platform Users And RBAC](../users/platform-users-and-rbac.md)
* [Dashboard](../dashboard/dashboard.md)
* [Application Structure](../../03-architecture/subsystems/application-structure.md)
* [Dashboard Layout Data Contract](../../06-database/feature-contracts/dashboard-layout.md)

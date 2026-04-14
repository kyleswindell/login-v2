# Platform Workspace And Documentation Vault

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
* app-owned `/platform/ui-reference` workspace is implemented as the canonical shell/component baseline review surface (forms, tables, tokens, drawers) and is super-admin-only

## Current Implementation

The current platform shell includes:

* a full-width authenticated layout
* top header with brand, search placeholder, recent-notifications preview, and user menu
* platform navigation for dashboard, users, and docs
* Setup sidebar shell that slides over the primary sidebar navigation
* selective setup landing pages for features that need setup-oriented workflows instead of linking Setup directly to the main feature list page
* dashboard cards for users, settings, notifications, and docs counts
* a dedicated docs-vault workspace mode with the repository tree replacing the normal app sidebar

The docs viewer currently supports:

* default file selection
* collapsible folder tree
* selected-file highlighting
* markdown rendering
* relative in-app link rewriting
* cleaned display names without visible `.md` extensions

## Important Files

* `resources/views/components/layouts/app.blade.php`
* `resources/views/platform/dashboard.blade.php`
* `resources/views/platform/docs/index.blade.php`
* `resources/views/platform/ui-reference/index.blade.php`
* `resources/views/platform/docs/partials/tree-node.blade.php`
* `app/Http/Controllers/Platform/DashboardController.php`
* `app/Http/Controllers/Platform/DocsController.php`
* `app/Http/Controllers/Platform/UiReferenceController.php`
* `app/Platform/Docs/DocsRepository.php`

## Permissions / Security

Current gates:

* docs viewer access is limited to users who can `view-platform-docs`
* docs viewer access also respects the configured docs access scope
* the current intended audience can be restricted to platform super admins through settings

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

* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 2]] | [Phase 1 - Implementation Batch 2](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%202.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 4]] | [Phase 1 - Implementation Batch 4](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%204.md)
* [[V2 App/Development/Phase 1 Development Log]] | [Phase 1 Development Log](../Development/Phase%201%20Development%20Log.md)
* [[V2 App/Features/Platform Users And RBAC]] | [Platform Users And RBAC](Platform%20Users%20And%20RBAC.md)

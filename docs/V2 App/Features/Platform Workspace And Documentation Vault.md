# Platform Workspace And Documentation Vault

## Purpose

Describe the current platform shell, dashboard workspace, and in-app documentation viewer.

## Implementation Status

Current status:

* implemented in code
* deployed on staging
* active staging review has already driven follow-up layout and docs-viewer corrections
* search and notifications header elements are placeholders only

## Current Implementation

The current platform shell includes:

* a full-width authenticated layout
* top header with brand, search placeholder, notifications placeholder, and user menu
* platform navigation for dashboard, users, and docs
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
* `resources/views/platform/docs/partials/tree-node.blade.php`
* `app/Http/Controllers/Platform/DashboardController.php`
* `app/Http/Controllers/Platform/DocsController.php`
* `app/Platform/Docs/DocsRepository.php`

## Permissions / Security

Current gates:

* docs viewer access is limited to users who can `view-platform-docs`
* the current intended audience is platform super admins

## Common Workflows

Current workflows:

* review system counts and quick links from the dashboard
* browse the current `docs/` vault without leaving the app
* navigate back to the main platform workspace from the docs viewer

## Known Gaps

Current gaps:

* header search is a placeholder only
* notifications header surface is a placeholder only
* no docs full-text search yet
* no deploy visibility surface in the app yet

## Related

* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 2]] | [Phase 1 - Implementation Batch 2](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%202.md)
* [[V2 App/Development/Phase 1 Development Log]] | [Phase 1 Development Log](../Development/Phase%201%20Development%20Log.md)
* [[V2 App/Features/Platform Users And RBAC]] | [Platform Users And RBAC](Platform%20Users%20And%20RBAC.md)

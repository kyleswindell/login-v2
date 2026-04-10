# Phase 1 - Implementation Batch 5

## Purpose

Establish the Setup sidebar shell, the Settings second-column panel, a feature settings registration contract, and the first two platform admin surfaces: an error log viewer and the first real settings entries per existing feature.

This batch is the foundational navigation and configuration layer that all future feature work should extend. It must be in place before Phase 2 introduces new features that would otherwise need retro-fitting.

## Implementation Status

Current status:

* planned
* no implementation started

Canonical docs:

* [[V2 App/Features/Platform Notifications And Settings]] | [Platform Notifications And Settings](../../Features/Platform%20Notifications%20And%20Settings.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](../../Features/Event%20And%20Error%20Logging.md)
* [[V2 App/Development/Phase 1 Development Log]] | [Phase 1 Development Log](../../Development/Phase%201%20Development%20Log.md)

## Batch Goal

Deliver the Setup/Settings navigation shell and the first two real admin content areas so the platform is operationally complete for Phase 1 and the pattern is established for all future features.

## Navigation Architecture

### Setup Sidebar

The Setup sidebar overlays the main sidebar from the left with a brief slide-in animation. Clicking Setup X slides it back out and restores the main sidebar.

Behavior:

* triggered by a Setup button in the main sidebar footer
* overlays the main sidebar with a left-to-right slide-in animation
* a Setup X close button slides it back out
* visible to any authenticated platform user
* individual Setup entries are permission-gated per feature
* entries are grouped using dropdown categories (e.g. Finance, Support, Leads) where a feature has multiple sub-pages

Current planned Setup entries for Phase 1 features:

* Platform Notifications
* Documentation Vault
* Audit Logs
* Error Logs
* Platform Users
* Settings (opens the Settings panel)

### Settings Panel

The Settings panel opens as a second column immediately to the right of the Setup sidebar when the Settings entry is selected.

Behavior:

* renders alongside the Setup sidebar, not as a new page
* entries are grouped into labelled accordion categories
* each category can expand to reveal named settings pages
* clicking a settings page loads the content in the main area
* visible to any authenticated platform user
* individual settings pages are permission-gated

Current planned Settings categories and pages for Phase 1:

General
* Platform General (app display name, default timezone, default locale)

Platform Notifications
* Notification Defaults (default severity for system notifications, max notifications retained per user)

Audit Logs
* Audit Settings (retention period, whether login events are logged at info or security severity)

Documentation Vault
* Vault Access (visible to all platform users or super-admins only)

Platform Users
* User Defaults (default role for new users, whether new users start active or inactive)

### Feature Settings Registration Rule

Every feature introduced in V2 must map its Setup entry and Settings pages during feature design.

This is a documentation procedure requirement, not a code enforcement:

* planning notes for each feature must include a Setup and Settings section describing intended entries
* at minimum one real settings option must exist before the setup entry appears in the UI
* stub pages with no editable fields must not ship as visible entries

This rule should be referenced in the doc standards and enforced during planning note review before implementation starts.

## In Scope

### Setup Sidebar Shell

* slide-in overlay over the main sidebar
* Setup X close behavior
* grouped dropdown categories for multi-page features
* permission-gated entry rendering
* sidebar navigation links for all current Phase 1 features

### Settings Panel Shell

* second-column panel opening alongside the Setup sidebar
* accordion category and page structure
* permission-gated page rendering

### First Real Settings Pages

This batch implements at least one real setting per existing feature:

* Platform General: app display name, default timezone, default locale
* Platform Notifications: default severity for system notifications, max notifications retained per user
* Audit Logs: retention period, login event severity level
* Documentation Vault: vault access scope
* Platform Users: default role for new users, default active/inactive state

All settings changes are:

* written through `SettingsService`
* attributed to the acting user via `updated_by`
* recorded as an audit event

### Error Log Viewer

* `central_error_logs` paginated list view
* filters for severity, handled/unhandled, environment, exception class, and date range
* per-entry detail view showing all key fields including stack trace
* reuses existing severity badge styling from notifications
* access limited to users with `platform.error-logs.view`
* no inline resolution or suppression tooling yet

### Supporting Changes

* `platform.error-logs.view` permission added to the RBAC seed
* `platform.settings.manage` permission added to the RBAC seed if not already present
* relevant permission-backed gates registered in `AppServiceProvider`

## Out Of Scope

Do not pull these into Batch 5:

* settings history or audit trail beyond the `updated_by` and audit event pattern already in place
* encrypted settings UI
* module-scoped or tenant-scoped settings
* error log resolution, suppression, or triage workflows
* external error monitoring integrations
* full Setup menu for Phase 2 features (Finance, Support, Leads, etc.)
* any Phase 2 tenant or provisioning work

## Recommended Order

1. Add `platform.error-logs.view` and `platform.settings.manage` permissions to the seeder
2. Register permission-backed gates in `AppServiceProvider`
3. Build the Setup sidebar overlay shell and animation
4. Build the Settings second-column panel shell with accordion categories
5. Build error log controller (index + show) and views
6. Build settings controllers and views for each Phase 1 feature settings page
7. Wire all Setup entries and Settings pages into the new navigation shell
8. Write feature tests for error log and settings controllers
9. Run local tests and verify all surfaces in browser
10. Deploy to staging and verify under a platform admin account

## Recommended Defaults

* paginated list views consistent with the audit log viewer pattern
* severity badge styling reused from the notifications UI
* show `updated_by` attribution in settings listings where the relation is populated
* settings write operations gated behind `platform.settings.manage`
* error log viewer is read-only in this batch

## Deliverables

Batch 5 should leave the repo with:

* a working Setup sidebar overlay shell
* a working Settings second-column panel
* a feature settings registration rule documented in standards
* first real settings pages for all existing Phase 1 features
* a working error log viewer with per-entry detail
* new permissions seeded and gated correctly
* feature tests for error log and settings controllers
* canonical docs and development log updated to match

## Related

* [[V2 App/Planning/Phase 1/Phase 1 Index]] | [Phase 1 Index](Phase%201%20Index.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 4]] | [Phase 1 - Implementation Batch 4](Phase%201%20-%20Implementation%20Batch%204.md)
* [[V2 App/Features/Platform Notifications And Settings]] | [Platform Notifications And Settings](../../Features/Platform%20Notifications%20And%20Settings.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](../../Features/Event%20And%20Error%20Logging.md)
* [[V2 App/Development/Phase 1 Development Log]] | [Phase 1 Development Log](../../Development/Phase%201%20Development%20Log.md)

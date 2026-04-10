# Phase 1 - Implementation Batch 5

## Purpose

Add the two remaining Phase 1 admin surfaces: a platform settings management screen and an error log viewer.

Both backing models and services already exist in code. This batch adds the UI and controller layer to make them accessible to platform admins.

## Implementation Status

Current status:

* planned
* no implementation started

Canonical docs:

* [[V2 App/Features/Platform Notifications And Settings]] | [Platform Notifications And Settings](../../Features/Platform%20Notifications%20And%20Settings.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](../../Features/Event%20And%20Error%20Logging.md)
* [[V2 App/Development/Phase 1 Development Log]] | [Phase 1 Development Log](../../Development/Phase%201%20Development%20Log.md)

## Batch Goal

Close the two known Phase 1 UI gaps so the platform admin shell is fully operational before Phase 2 work begins.

## In Scope

### Settings Management Screen

This batch includes:

* a read-only settings listing for platform-scope settings
* an edit form for individual platform settings
* settings access limited to platform users with appropriate permission
* settings changes written through `SettingsService` and attributed to the acting user via `updated_by`
* audit event written on every settings change
* no support for encrypted settings in this first UI pass
* no module-scoped or tenant-scoped settings UI yet

### Error Log Viewer

This batch includes:

* a `central_error_logs` list view for platform admins
* filters for severity, handled/unhandled, environment, exception class, and date range
* a detail view per log entry showing all key fields including stack trace
* access limited to platform users with a new `platform.error-logs.view` permission
* no inline error suppression or resolution tooling yet

### Supporting Changes

This batch also includes:

* `platform.error-logs.view` permission added to the RBAC seed
* `platform.settings.manage` permission added to the RBAC seed if not already present
* relevant permission-backed gates registered in `AppServiceProvider`
* navigation links added to the platform sidebar for both surfaces

## Out Of Scope

Do not pull these into Batch 5:

* settings history or audit trail beyond the `updated_by` and audit event pattern already in place
* encrypted settings UI
* module-scoped or tenant-scoped settings
* error log resolution, suppression, or triage workflows
* external error monitoring integrations
* any Phase 2 tenant or provisioning work

## Recommended Order

1. Add `platform.error-logs.view` and `platform.settings.manage` permissions to the seeder
2. Register permission-backed gates in `AppServiceProvider`
3. Build error log controller (index + show)
4. Build error log views (index with filters, detail)
5. Build settings controller (index + edit/update)
6. Build settings views (index, edit form)
7. Add sidebar navigation links for both surfaces
8. Write feature tests for both controllers
9. Run local tests and verify both surfaces in browser
10. Deploy to staging and verify under a platform admin account

## Open Decisions Before Batch 5 Closes

* whether error log detail should reuse a shared severity color scheme already defined for notifications
* whether settings should show a last-updated-by attribution column in the listing
* whether the error log viewer should paginate or use infinite scroll given potential log volume

## Recommended Defaults

* use paginated list views consistent with the audit log viewer pattern
* reuse existing severity badge styling from the notifications UI
* show `updated_by` attribution in the settings listing if the relation is populated
* keep both surfaces read-mostly in this batch; write operations limited to settings edit only

## Deliverables

Batch 5 should leave the repo with:

* a working platform settings management screen
* a working error log viewer with per-entry detail
* new permissions seeded and gated correctly
* feature tests for both controllers
* canonical docs and development log updated to match

## Related

* [[V2 App/Planning/Phase 1/Phase 1 Index]] | [Phase 1 Index](Phase%201%20Index.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 4]] | [Phase 1 - Implementation Batch 4](Phase%201%20-%20Implementation%20Batch%204.md)
* [[V2 App/Features/Platform Notifications And Settings]] | [Platform Notifications And Settings](../../Features/Platform%20Notifications%20And%20Settings.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](../../Features/Event%20And%20Error%20Logging.md)
* [[V2 App/Development/Phase 1 Development Log]] | [Phase 1 Development Log](../../Development/Phase%201%20Development%20Log.md)

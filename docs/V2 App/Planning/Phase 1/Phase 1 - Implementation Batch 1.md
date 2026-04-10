# Phase 1 - Implementation Batch 1

## Purpose

Translate the current Phase 1 planning guidance into the first realistic implementation batch for the shared core app foundation.

This note is intentionally narrower than the full Phase 1 scope. It should describe the first migration and service layer batch that gives us a durable base without dragging tenancy or broad feature work in too early.

## Implementation Status

Current status:

* implemented in code
* migrated on staging
* foundational data and service layer completed
* dedicated admin UI still pending for notifications and settings

Canonical docs:

* [[V2 App/Features/Authentication]] | [Authentication](../../Features/Authentication.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](../../Features/Event%20And%20Error%20Logging.md)
* [[V2 App/Features/Platform Users And RBAC]] | [Platform Users And RBAC](../../Features/Platform%20Users%20And%20RBAC.md)
* [[V2 App/Features/Platform Notifications And Settings]] | [Platform Notifications And Settings](../../Features/Platform%20Notifications%20And%20Settings.md)
* [[V2 App/Development/Phase 1 Development Log]] | [Phase 1 Development Log](../../Development/Phase%201%20Development%20Log.md)

## Batch Goal

Establish the first stable shared-core data and service foundation for:

* platform/core-app identities
* RBAC
* settings
* notifications
* existing logging integration

## In Scope

### Tables

This batch should target:

* `users` refinements only if Phase 1 lifecycle columns are approved
* `roles`
* `permissions`
* `model_has_roles`
* `role_has_permissions`
* `settings`
* `notifications`

Already present and not part of the migration work for this batch:

* `password_reset_tokens`
* `platform_audit_logs`
* `central_error_logs`
* Laravel support tables already migrated

### Services and behavior

This batch should also establish:

* RBAC package installation and configuration
* platform super-admin authorization bypass pattern
* settings service or repository baseline
* notification service baseline
* feature bootstrap contract for permissions, audit events, notifications, and settings

## Out Of Scope

Do not pull these into Batch 1:

* tenant registry tables
* tenant provisioning tables
* tenant auth tables
* module registry tables unless code registration proves insufficient
* notification delivery fan-out beyond in-app/database persistence
* content/CMS tables
* customer/project/finance domain tables

## Recommended Order

1. Install and configure RBAC package
2. Add RBAC migrations and migrate locally
3. Decide whether `users` needs lifecycle columns now
4. Add `settings` table migration
5. Add `notifications` table migration
6. Create baseline services:
   * settings service
   * notification service
7. Add tests for:
   * role/permission assignment
   * super-admin bypass behavior
   * settings persistence
   * notification persistence
8. Run local migrations and tests
9. Deploy and run `php artisan migrate --force` on the server

## Open Decisions Before Batch 1 Starts

These should be resolved explicitly before implementation begins:

* whether to use Spatie permission package with default table names unchanged
* whether `users` should gain:
  * `is_active`
  * `last_login_at`
  * `invited_at`
* whether notifications should use Laravel's built-in database notification conventions exactly or a custom-but-similar schema
* whether settings values should be stored in one `value_jsonb` column first or split by scalar type later

## Recommended Defaults

Current best recommendation:

* use standard `users`
* use package-backed RBAC with default table names
* add `settings` with `value_jsonb`
* add a shared `notifications` table for in-app notifications
* defer `notification_receipts`
* keep `platform_audit_logs` and `central_error_logs` as the Phase 1 logging baseline already in place

## Deliverables

Batch 1 should leave the repo with:

* migrations for RBAC, `settings`, and `notifications`
* package/config baseline for authorization
* settings persistence baseline
* notification persistence baseline
* tests covering the new shared-core foundations
* updated docs promoted from planning where decisions become stable

## Related

* [[V2 App/Planning/Phase 1/Phase 1 Index]] | [Phase 1 Index](Phase%201%20Index.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Platform Foundation Planning]] | [Phase 1 - Platform Foundation Planning](Phase%201%20-%20Platform%20Foundation%20Planning.md)
* [[V2 App/Planning/Phase 1/Auth And Authorization Foundation]] | [Auth And Authorization Foundation](Auth%20And%20Authorization%20Foundation.md)
* [[V2 App/Planning/Phase 1/Logging Notifications And Options Foundation]] | [Logging Notifications And Options Foundation](Logging%20Notifications%20And%20Options%20Foundation.md)
* [[V2 App/Features/Authentication]] | [Authentication](../../Features/Authentication.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](../../Features/Event%20And%20Error%20Logging.md)

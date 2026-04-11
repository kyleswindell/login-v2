# Event And Error Logging

## Purpose

Describe the current platform audit logging and database-backed error logging foundation.

## Implementation Status

Current status:

* implemented in code
* migrated on staging
* audit events are actively written for current auth flows
* exception reporting is wired to write into `central_error_logs`
* audit log viewer UI is live on staging
* error log viewer UI is live on staging
* Filament read-only error log proof is deployed and validated on staging
* Filament read-only audit log proof is implemented locally and pending staging deployment/QA
* audit and error log timestamps are stored as UTC and displayed in the signed-in user's timezone
* Filament log viewers use safe modal headings and truncated long-text display to avoid oversized recursive exception output
* Filament log slide-over details are organized into coherent sections with long message, stack trace, metadata, and client details collapsed by default
* Filament log tables use responsive column priority so core log records remain within page width without default horizontal scrolling
* the error log Filament table has a scoped console theme override that forces fixed-layout sizing and aggressive wrapping for long error text

## Current Scope

App 2.0 begins with two database-backed logging tables:

* `platform_audit_logs`
* `central_error_logs`

Runtime pieces in the current implementation:

* `App\Platform\Logging\PlatformLogger`
* `App\Http\Middleware\EnsureRequestId`
* exception reporting hook in `bootstrap/app.php`
* `App\Http\Controllers\Platform\AuditLogController`
* `App\Http\Controllers\Platform\ErrorLogController`
* `App\Filament\Resources\PlatformAuditLogs\PlatformAuditLogResource`
* `App\Filament\Resources\CentralErrorLogs\CentralErrorLogResource`
* `App\Providers\Filament\ConsolePanelProvider`
* `resources/views/platform/audit-logs/index.blade.php`
* `resources/views/platform/error-logs/index.blade.php`
* `resources/views/platform/error-logs/show.blade.php`

Related docs:

* [[V2 App/Features/Authentication]] | [Authentication](Authentication.md)
* [[Standards/Logging Standards]] | [Logging Standards](../../Standards/Logging%20Standards.md)
* [[V2 App/Reference/Logging Data Model Notes]] | [Logging Data Model Notes](../Reference/Logging%20Data%20Model%20Notes.md)

## Platform Audit Logs

Use platform audit logs for intentional application events that matter later for support, security, or operations.

Initial examples:

* `auth.login_succeeded`
* `auth.login_failed`
* `auth.logout`

Important columns include:

* `occurred_at`
* `event_type`
* `action`
* `actor_type` / `actor_id`
* `subject_type` / `subject_id`
* `result`
* `severity`
* `request_id`
* `trace_id`
* `ip_address`
* `user_agent`
* `metadata`
* `is_security_event`

Current auth-related events:

* `auth.login_succeeded`
* `auth.login_failed`
* `auth.logout`

Current audit visibility surface:

* `GET /platform/audit-logs`
* `GET /console/platform-audit-logs`, local Filament proof pending staging QA
* filters by event type, actor, result, and severity
* current audience is platform users with `platform.audit-logs.view`

Timestamp standard:

* `platform_audit_logs.occurred_at` is treated as UTC at rest
* UI surfaces convert `occurred_at` to the signed-in user's timezone when available

## Application Error Logs

Use application error logs for operational failures and exceptions.

Timestamp standard:

* `central_error_logs.occurred_at` is treated as UTC at rest
* UI surfaces convert `occurred_at` to the signed-in user's timezone when available
* platform default timezone is only a display fallback when no user timezone is known

The exception reporter calls the platform logger and the logger fails safely to Laravel's normal log channel if database logging is unavailable.

Important columns include:

* `tenant_key`
* `environment`
* `service_name`
* `severity`
* `request_id`
* `trace_id`
* `span_id`
* `route`
* `method`
* `status_code`
* `message`
* `exception_class`
* `error_code`
* `file_path`
* `line_number`
* `stack_trace`
* `fingerprint`
* `handled`
* `release_version`
* `hostname`

Current error visibility surface:

* `GET /platform/error-logs`
* `GET /platform/error-logs/{log}`
* `GET /console/central-error-logs`, local Filament proof pending staging QA
* filters by severity, handled state, environment, exception class, and date range
* current audience is platform users with `platform.error-logs.view`

Filament proof notes:

* the existing Blade error log routes remain the current live surface
* the Filament proof is read-only and uses the existing `view-platform-error-logs` gate
* access is limited to active users who can view platform error logs
* the default table view prioritizes occurred time, severity, message, handled state, and row actions, while secondary diagnostic columns are hidden by default or reserved for wider breakpoints
* the detail slide-over uses full-width stacked sections so summary, exception, request context, full message, stack trace, and context are visually separated without side-by-side section cards
* error table layout CSS is scoped through `platform-error-log-table` and `resources/css/filament/console/theme.css`

Audit Filament proof notes:

* the existing Blade audit log route remains the current live surface
* the Filament proof is read-only and uses the existing `view-platform-audit-logs` gate
* access is limited to active users who can view platform audit logs
* metadata display accepts mixed legacy/runtime values defensively so malformed context does not break the slide-over
* long metadata and client fields are collapsed by default in the slide-over
* the default table view prioritizes occurred time, event, actor/result/severity where screen width allows, and row actions, while secondary route/request details are toggleable or hidden by default
* the detail slide-over uses full-width stacked sections so event summary, actor/subject, request context, metadata, and client details are visually separated without side-by-side section cards

## Request Correlation

Every web request receives an `X-Request-Id`. That value is reused as the initial trace identifier so platform audit logs, error logs, file logs, and future external observability can be correlated without guessing.

## Guardrail

Do not rely only on database error logs for production observability. Database logging is useful for app-level visibility, but file logs and future external monitoring should remain part of the operations plan.

## Planned Next Phase

This is the central-platform baseline. Tenant-local audit logs and central security mirrors remain part of the planned tenancy implementation phase.

## Related

* [[V2 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)
* [[V2 App/Planning/Phase 1/Logging Notifications And Options Foundation]] | [Logging Notifications And Options Foundation](../Planning/Phase%201/Logging%20Notifications%20And%20Options%20Foundation.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 1]] | [Phase 1 - Implementation Batch 1](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 3]] | [Phase 1 - Implementation Batch 3](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%203.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 2]] | [Phase 2 - Implementation Batch 2](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%202.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 3]] | [Phase 2 - Implementation Batch 3](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%203.md)
* [[V2 App/Planning/Future Planning/Future - Audit And Error Log Operations]] | [Future - Audit And Error Log Operations](../Planning/Future%20Planning/Future%20-%20Audit%20And%20Error%20Log%20Operations.md)
* [[V2 App/V2 App Documentation Map]] | [V2 App Documentation Map](../V2%20App%20Documentation%20Map.md)
* [[V2 App/Reference/Reference Index]] | [Reference Index](../Reference/Reference%20Index.md)

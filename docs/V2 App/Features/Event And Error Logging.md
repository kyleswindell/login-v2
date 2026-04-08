# Event And Error Logging

## Current Scope

App 2.0 begins with two database-backed logging tables:

* `platform_audit_logs`
* `central_error_logs`

Runtime pieces in the current implementation:

* `App\Platform\Logging\PlatformLogger`
* `App\Http\Middleware\EnsureRequestId`
* exception reporting hook in `bootstrap/app.php`

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

## Application Error Logs

Use application error logs for operational failures and exceptions.

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

## Request Correlation

Every web request receives an `X-Request-Id`. That value is reused as the initial trace identifier so platform audit logs, error logs, file logs, and future external observability can be correlated without guessing.

## Guardrail

Do not rely only on database error logs for production observability. Database logging is useful for app-level visibility, but file logs and future external monitoring should remain part of the operations plan.

## Planned Next Phase

This is the central-platform baseline. Tenant-local audit logs and central security mirrors remain part of the planned tenancy implementation phase.

## Related

* [[V2 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)
* [[V2 App/V2 App Documentation Map]] | [V2 App Documentation Map](../V2%20App%20Documentation%20Map.md)
* [[V2 App/Reference/Reference Index]] | [Reference Index](../Reference/Reference%20Index.md)

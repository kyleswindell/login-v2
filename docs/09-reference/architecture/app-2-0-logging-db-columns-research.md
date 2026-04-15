# App 2.0 Logging DB Columns Research

Yes. With **database-per-tenant already in place**, it is reasonable to make **tenant audit logs tenant-local**. I would still keep **platform-level centralized error/operational logging** as well.

That is the model I would recommend.

## Current App 2.0 implementation note

Initial implementation now follows this direction as a central-platform baseline:

* `platform_audit_logs` stores platform/security audit events with request correlation, actor/subject fields, result, severity, user agent, route, method, and metadata.
* `central_error_logs` stores platform error diagnostics with nullable `tenant_key`, environment, service name, severity, request/trace/span IDs, route, status code, exception details, stack trace, fingerprint, release version, hostname, and request context.
* Tenant-local `audit_logs` and mirrored `central_security_logs` remain planned for the tenancy implementation phase.

Related implementation docs:

* [Event And Error Logging](../../04-features/logging/event-and-error-logging.md)
* [Logging Standards](../../02-standards/logging/Logging Standards.md)

## Related

* [Planning Index](../../07-planning/index.md)
* Planning map reference retired during App 2.0 docs cutover; use [00-start-here](../../00-start-here.md) as root navigation.
* [Logging Data Model Notes](app-2-0-logging-db-columns-research.md)

## Best design for your setup

Use a **hybrid approach**:

### In each tenant database

Store:

* `audit_logs`
* optionally `security_logs`

These are the records tenant admins may be allowed to view:

* logins
* logouts
* failed auth attempts
* CRUD activity
* status changes
* inventory adjustments
* exports
* permission changes
* user/admin actions within that tenant

This lines up well with OWASP guidance to include tenant context in logs and implement tenant-isolated audit trails. ([OWASP Cheat Sheet Series][1])

### In the platform/admin database

Store:

* `central_error_logs`
* `central_operational_logs`
* optionally a `central_audit_index` or summary stream

These are for:

* application exceptions
* deployment issues
* queue/job failures
* webhook failures
* mail/API integration failures
* suspicious cross-tenant access attempts
* platform admin/support activity
* trace-correlated diagnostics across services

Centralizing these makes correlation, alerting, and incident response much easier, especially if you want request/trace IDs and modern structured logging. OpenTelemetry explicitly supports log correlation with `TraceId` and `SpanId`. ([OpenTelemetry][2])

---

## Why this is better than “everything only in tenant DBs”

If you put **all** logs only inside each tenant database, you gain isolation, but you lose a lot:

* platform-wide incident visibility gets harder
* deployments affecting many tenants are harder to diagnose
* support tooling has to fan out across every database
* alerting and grouping repeated exceptions gets messier
* pre-tenant-resolution errors may have nowhere good to go

That is why I would not make **error logging tenant-local only**.

---

## My recommendation by log type

### 1) Audit/activity logs

**Tenant-local first**

* best fit for tenant admin visibility
* naturally isolated
* easier to honor tenant deletion/export boundaries
* cleaner for tenant-facing audit screens

I would still optionally forward a **summary copy** of important tenant audit events to the platform for reporting.

### 2) Error/exception logs

**Central first**

* errors are a platform concern even when triggered by one tenant
* one bug may affect many tenants
* easier grouping by fingerprint
* easier trace correlation across app, worker, API, cron, webhooks

If useful, also write a **sanitized tenant-visible incident row** locally for the tenant, but the canonical exception record should usually be central.

### 3) Security logs

Usually **both**:

* tenant-local copy for tenant-relevant events
* central copy for security monitoring and cross-tenant detection

OWASP’s multi-tenant guidance specifically calls out monitoring for cross-tenant access attempts and setting alerts for tenant isolation violations. ([OWASP Cheat Sheet Series][1])

---

## Recommended architecture

## Tenant DB

```text
tenant_db_x
├── audit_logs
├── security_logs
└── optional tenant_incidents
```

## Platform DB

```text
platform_admin_db
├── central_error_logs
├── central_operational_logs
├── central_security_logs
├── tenant_registry
└── optional tenant_audit_rollups
```

---

## What I would actually implement

### Tenant-local `audit_logs`

Use this for business events and tenant-admin-visible activity.

Core columns:

```sql
id
occurred_at
event_type
action
actor_type
actor_id
target_type
target_id
result
severity
ip_address
user_agent
request_id
trace_id
metadata_json
is_system_event
is_tenant_visible
```

Since the DB itself is tenant-specific, you no longer need `tenant_id` in the tenant table for isolation, though I still sometimes keep a `tenant_public_id` or `tenant_key` if logs may be exported or mirrored.

### Central `error_logs`

Use this for platform diagnostics.

Core columns:

```sql
id
tenant_key
occurred_at
environment
service_name
severity
request_id
trace_id
span_id
route
method
status_code
message
exception_class
error_code
file_path
line_number
stack_trace
context_json
fingerprint
handled
release_version
hostname
```

`tenant_key` should be nullable, because some failures happen before tenant resolution is known.

---

## Why tenant-local audit logs are a good fit here

Since each tenant already has a separate database, tenant-local audit logging gives you real benefits:

* stronger default tenant separation
* simpler tenant-admin queries
* easier per-tenant retention/export/deletion
* less risk of accidental cross-tenant audit leakage
* clearer ownership boundaries

This is very consistent with separate-database tenancy patterns, where storage decisions depend on the isolation level you want. Microsoft’s multitenant architecture guidance discusses choosing separate databases when stronger isolation is required. ([Microsoft Learn][3])

---

## What I would not do

I would not:

* keep raw stack traces only in tenant DBs
* require the admin console to query every tenant DB for routine diagnostics
* expose internal exception details directly to tenant admins
* rely only on tenant-local logs for security monitoring

---

## Practical rule set

### Put in tenant DB

* user activity
* record changes
* inventory adjustments
* customer/account edits
* tenant user auth history
* tenant admin actions
* business-level audit trail

### Put in central platform DB

* exceptions
* failed jobs
* webhook/API failures
* deployment/runtime issues
* support/admin impersonation events
* cross-tenant/security anomalies
* application health and telemetry

### Put in both

* authentication/security events
* important admin actions
* support access to tenant data
* compliance-relevant audit events

---

## Recommended write flow

For a request inside a tenant:

1. app resolves tenant
2. business audit event writes to tenant DB
3. errors/exceptions write to central platform log sink
4. selected security/compliance events also mirror centrally
5. all records carry `request_id` and `trace_id`

That gives you local audit ownership plus central diagnosability. OpenTelemetry’s log model is designed around structured logs and trace correlation, which fits this pattern well. ([OpenTelemetry][2])

---

## Final recommendation

Because your tenants already have **fully separate databases**, I would use:

* **tenant-local audit/activity logs**
* **centralized platform error logs**
* **centralized or mirrored security logs**
* **optional summarized audit replication to the admin console**

That is a stronger design than choosing only one side.

If you want, I can draft the exact schema for:

* tenant `audit_logs`
* central `error_logs`
* central `security_logs`
* a lightweight sync/mirroring table for the admin console.

## Related

* [Planning Index](../../07-planning/index.md)
* [Logging Data Model Notes](app-2-0-logging-db-columns-research.md)
* [Logging Standards](../../02-standards/logging/Logging Standards.md)

[1]: https://cheatsheetseries.owasp.org/cheatsheets/Multi_Tenant_Security_Cheat_Sheet.html?utm_source=chatgpt.com "Multi Tenant Security - OWASP Cheat Sheet Series"
[2]: https://opentelemetry.io/docs/concepts/signals/logs/?utm_source=chatgpt.com "OpenTelemetry Logs"
[3]: https://learn.microsoft.com/en-us/azure/architecture/guide/multitenant/approaches/storage-data?utm_source=chatgpt.com "Architectural Approaches for Storage and Data in ..."

# Logging Standards

## Event Logs

Use platform audit logs for meaningful platform events.

Required event log qualities:

* stable event name
* actor user ID when available
* subject type and subject ID when applicable
* safe metadata
* request and trace correlation when available
* IP address when available

## Error Logs

Use application error logs for exceptions and operational failures.

Required error log qualities:

* severity level
* message
* exception class when applicable
* file and line when applicable
* safe context
* request URL, method, IP, and user ID when available

## Current Storage Model

Current App 2.0 stores platform audit events in `platform_audit_logs` and operational failures in `central_error_logs`.

Planned tenancy phase:

* tenant-visible audit logs become tenant-local
* central error logs remain centralized
* security-relevant events may be mirrored centrally and per tenant

## Sensitive Data

Never log plaintext passwords, tokens, secrets, full session payloads, or raw tenant credentials.

Avoid logging high-risk PII unless there is a support or security reason and the retention plan is explicit. Prefer IDs, stable event names, and safe metadata over raw payload dumps.

## Fail-Safe Behavior

Logging code must not create a second outage. If database logging fails, fall back to Laravel's normal file/channel logging.

## Event Naming

Use dot-separated, domain-first event names:

* `auth.login_succeeded`
* `auth.login_failed`
* `auth.logout`
* `tenant.provisioning_started`
* `tenant.domain_attached`

## Correlation

Prefer a request ID on every inbound HTTP request. Reuse that identifier consistently across:

* audit log rows
* error log rows
* fallback file logs
* future queue, worker, and external telemetry integrations

## Related

* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](../V2%20App/Features/Event%20And%20Error%20Logging.md)
* [[V2 App/Reference/Logging Data Model Notes]] | [Logging Data Model Notes](../V2%20App/Reference/Logging%20Data%20Model%20Notes.md)
* [[Standards/Coding Standards]] | [Coding Standards](Coding%20Standards.md)
* [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](Tenant%20Safety%20Standards.md)

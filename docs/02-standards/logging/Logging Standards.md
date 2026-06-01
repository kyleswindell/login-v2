# Logging Standards

This document defines the canonical scope and intent for Logging Standards.

## Event Logs

Use platform audit logs for meaningful platform events.

Required event log qualities:

* stable event name
* actor user ID when available
* subject type and subject ID when applicable
* safe metadata
* request and trace correlation when available
* IP address when available

Security-relevant event coverage should include:

* authentication success and failure
* rate-limit or abuse-defense triggers
* MFA challenge, satisfaction, bypass, or rejection outcomes
* account linking and unlinking
* privilege or policy changes affecting auth, access, or secrets

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

Security logs should capture decision context without storing reusable credentials, raw provider callback payloads, full authorization headers, or secret-manager values.

## Fail-Safe Behavior

Logging code must not create a second outage. If database logging fails, fall back to Laravel's normal file/channel logging.

## Event Naming

Use dot-separated, domain-first event names:

* `auth.login_succeeded`
* `auth.login_failed`
* `auth.login_throttled`
* `auth.logout`
* `auth.mfa_challenged`
* `auth.mfa_satisfied`
* `auth.mfa_rejected`
* `auth.identity_linked`
* `auth.identity_unlinked`
* `tenant.provisioning_started`
* `tenant.domain_attached`

## Correlation

Prefer a request ID on every inbound HTTP request. Reuse that identifier consistently across:

* audit log rows
* error log rows
* fallback file logs
* future queue, worker, and external telemetry integrations

## Related

* [Event And Error Logging](../../04-features/logging/event-and-error-logging.md)
* [Logging Data Contract](../../06-database/feature-contracts/logging.md)
* [Coding Standards](../coding/Coding%20Standards.md)
* [Tenant Safety Standards](../security/Tenant%20Safety%20Standards.md)

# Event And Error Logging Data Contract

This document defines the canonical scope and intent for Event And Error Logging Data Contract.

## Tables

- `platform_audit_logs`
- `central_error_logs`

## Platform Audit Log Columns

- `occurred_at`
- `event_type`
- `action`
- `actor_type`
- `actor_id`
- `subject_type`
- `subject_id`
- `result`
- `severity`
- `request_id`
- `trace_id`
- `ip_address`
- `user_agent`
- `metadata`
- `is_security_event`

## Central Error Log Columns

- `occurred_at`
- `tenant_key`
- `environment`
- `service_name`
- `severity`
- `request_id`
- `trace_id`
- `span_id`
- `route`
- `method`
- `status_code`
- `message`
- `exception_class`
- `error_code`
- `file_path`
- `line_number`
- `stack_trace`
- `fingerprint`
- `handled`
- `release_version`
- `hostname`

## Timestamp Storage Constraints

- `platform_audit_logs.occurred_at` is stored as UTC at rest.
- `central_error_logs.occurred_at` is stored as UTC at rest.

## Related

- [platform_audit_logs](../tables/platform_audit_logs.md)
- [central_error_logs](../tables/central_error_logs.md)

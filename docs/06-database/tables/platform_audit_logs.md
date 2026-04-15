# platform_audit_logs

This document defines the canonical scope and intent for platform_audit_logs.

## Ownership

- central platform database

## Columns

- `id`
- `occurred_at`
- `event_type`
- `action`
- `actor_user_id`
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
- `route`
- `method`
- `metadata`
- `is_system_event`
- `is_security_event`
- `created_at`
- `updated_at`

## Constraints And Notes

- timestamps are stored as UTC at rest
- records are platform/security audit events

## Related

- [Logging Contract](../feature-contracts/logging.md)

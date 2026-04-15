# central_error_logs

This document defines the canonical scope and intent for central_error_logs.

## Ownership

- central platform database

## Columns

- `id`
- `tenant_key` (nullable)
- `occurred_at`
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
- `context`
- `fingerprint`
- `handled`
- `release_version`
- `hostname`
- `user_id`
- `ip_address`
- `user_agent`
- `created_at`
- `updated_at`

## Constraints And Notes

- timestamps are stored as UTC at rest
- `tenant_key` remains nullable for pre-tenant-resolution failures

## Related

- [Logging Contract](../feature-contracts/logging.md)

# Legacy V1 Perfex Module Development Standards

This document preserves legacy V1 Perfex module conventions for reference only.

## Scope

These standards apply to **V1 (Perfex) modules only**.

For App 2.0 feature development conventions, see [Feature Development Standards](../../02-standards/coding/Feature%20Development%20Standards.md).

## Purpose

Document historical conventions for building or modifying Perfex modules without treating them as active App 2.0 standards.

## Standards

- Keep module code under `application/modules/{module_name}/`.
- Register language files in the module bootstrap when the module has UI strings.
- Register permissions/capabilities in `admin_init` hooks when the module has admin actions.
- Keep install/migration logic idempotent.
- Validate all admin writes server-side.
- Use Admin Core helpers for tenant-aware behavior where available.
- Log audit-worthy actions with `log_activity(...)`.
- Log operational failures with `log_message('error', ...)`.

## Related

- [Reference Index](../index.md)
- [Feature Development Standards](../../02-standards/coding/Feature%20Development%20Standards.md)
- [Database Migration Standards](../../02-standards/database/Database%20Migration%20Standards.md)

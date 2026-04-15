# Module Development Standards

## Scope

These standards apply to **V1 (Perfex) modules only**.

For V2 (Login App 2.0) feature development conventions, see [[Standards/Feature Development Standards]] | [Feature Development Standards](Feature%20Development%20Standards.md).

## Purpose

Document conventions for building or modifying Perfex modules.

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

- [[V1 App/Modules/Module Index]] | [Module Index](../V1%20App/Modules/Module%20Index.md)
- [[Standards/Database Migration Standards]] | [Database Migration Standards](Database%20Migration%20Standards.md)


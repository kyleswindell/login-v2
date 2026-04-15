# Admin Core Data Model

Parent: [[V1 App/Reference Index]] | [Reference Index](../Reference%20Index.md)

## Summary

Admin Core stores global tenant records in the admin database. These records drive host-to-database routing, tenant activation, module/core feature policy, frontend website integration, and Events defaults.

This table is admin-host-only and should not be expected inside the initial tenant template database.

This note is intentionally V1-focused. It documents the current implementation and naming, not a requirement that V2 must keep tenant orchestration as an installable module instead of a separated concern inside the rebuilt admin application.

## Main Table

`tbltenants`

Live snapshot notes:

- The local `perfex` dump shows `id` as unsigned auto-increment.
- `tenant_key` is `varchar(64)` in the live DB.
- `created_at` and `updated_at` use `CURRENT_TIMESTAMP` defaults in the live DB.
- The live dump shows a unique key on `tenant_key`; it does not show additional unique keys on `db_name` or `db_user`.

| Field | Purpose |
|---|---|
| `id` | Tenant record primary key. |
| `tenant_key` | Host key used to resolve tenant requests. |
| `name` | Human-readable tenant name. |
| `db_host` | Tenant database host. |
| `db_name` | Tenant database name. |
| `db_user` | Tenant database user. |
| `db_pass` | Tenant database password. |
| `is_active` | Whether tenant host requests should load the tenant app. |
| `allowed_modules` | JSON allowlist for tenant-visible modules. |
| `allowed_core_features` | JSON allowlist for tenant-visible native Perfex feature areas. |
| `frontend_base_url` | Public website base URL for the tenant. |
| `frontend_site_root_path` | Filesystem root for public website sync. |
| `events_sync_relative_dir` | Relative directory for Events website JSON export. |
| `events_sync_enabled` | Tenant-level Events website sync flag. |
| `events_sync_endpoint_url` | HTTPS endpoint URL for Events sync. |
| `events_sync_secret` | Shared secret for Events endpoint sync. |
| `events_default_custom_types_json` | Tenant Events default custom event types. |
| `events_default_type_field_map_json` | Tenant Events type-to-custom-field defaults. |
| `events_default_channels_json` | Tenant Events website channel defaults. |
| `created_at` | Tenant creation timestamp. |
| `updated_at` | Tenant update timestamp. |

## Important Files

- `application/modules/admin_core/install.php`
- `application/modules/admin_core/models/Tenants_model.php`
- `application/modules/admin_core/controllers/Admin_core.php`
- `application/modules/admin_core/helpers/admin_core_helper.php`
- `documentation/database/perfex-schema.sql`

## Related

- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)
- [[V1 App/Reference/Database Schema And Relationships]] | [Database Schema And Relationships](Database%20Schema%20And%20Relationships.md)
- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](../Architecture/Multi%20Tenant%20Architecture.md)
- [[V1 App/Features/Tenant Module Allowlist]] | [Tenant Module Allowlist](../Features/Tenant%20Module%20Allowlist.md)

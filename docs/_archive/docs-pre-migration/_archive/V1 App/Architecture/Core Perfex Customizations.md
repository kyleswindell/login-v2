# Core Perfex Customizations

Parent: [[V1 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)

## Purpose

Document intentional changes made outside custom modules so they can be reviewed carefully during future Perfex upgrades.

## Use This Note When

Use this note when you need the clearest answer to:

- which non-module core Perfex files were intentionally customized in V1
- why those files matter during upgrades
- where tenant-aware behavior reaches into core app files

Do not use this note as the main owner of:

- the overall V1 architecture map
- product-level feature behavior
- exact setup, settings, or schema reference material

## Current Customizations

### `application/application/config/database.php`

Adds host-based multi-tenant database selection.

- Admin host and CLI use the global/admin database.
- Tenant hosts bootstrap through the global/admin database and look up `tbltenants.tenant_key`.
- Unknown tenants fail closed with a 404.
- Inactive tenants stop before connecting to the tenant DB and render an inactive response.

### `application/application/core/AdminController.php`

Loads the Admin Core helper on admin requests and enforces tenant native-core feature policies before tenant admins access disabled areas by direct URL.

### `application/application/controllers/admin/Mods.php`

Adds tenant-aware module filtering and action guards.

- Tenant admins only see modules assigned to their tenant.
- Tenant admins can only activate/deactivate/upgrade allowed modules.
- Tenant hosts cannot upload, uninstall, or update global module versions.

### `application/application/views/admin/modules/list.php`

Adjusts the module listing UI for tenant contexts.

- Hides module upload UI for tenant CRMs.
- Limits tenant-facing module actions to assigned modules.
- Shows tenant-facing notice that upload/uninstall are managed from the admin host.

## Upgrade Guidance

Review these files carefully when applying upstream Perfex updates. These are intentional app-level changes and should not be overwritten without re-applying tenant behavior.

## Related

- [[V1 App/Architecture/System Overview]] | [System Overview](System%20Overview.md)
- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](Multi%20Tenant%20Architecture.md)
- [[V1 App/Features/Tenant Module Allowlist]] | [Tenant Module Allowlist](../Features/Tenant%20Module%20Allowlist.md)

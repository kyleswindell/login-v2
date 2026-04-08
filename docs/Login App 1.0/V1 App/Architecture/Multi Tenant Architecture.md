# Multi Tenant Architecture

Parent: [[V1 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)

## Purpose

Track how tenant-aware behavior works across the admin app and tenant CRM contexts.

## Use This Note When

Use this note when you need the clearest answer to:

- how V1 separates admin-host and tenant-host behavior
- where tenant lookup and tenant policy are enforced
- which files and tables are central to multi-tenant routing

Do not use this note as the main owner of:

- exact table-by-table schema details
- the full feature inventory
- runbook or deployment procedures

## Current Implementation

The `admin_core` module stores tenant records and settings in the admin/global database. Tenant records include database connection details, allowed modules, allowed core features, and frontend website integration settings.

On admin-host requests, the app uses the global/admin database. On tenant-host requests, the database config bootstraps from the global database, looks up the matching tenant record by `tenant_key`, and switches the active database connection to that tenant database.

Unknown tenant hosts fail closed with a 404. Inactive tenant hosts stop before connecting to the tenant database and render a friendly inactive response.

## Important Files

- `application/modules/admin_core/install.php`: Creates and evolves the tenant table.
- `application/modules/admin_core/helpers/admin_core_helper.php`: Provides tenant helper functions and policy resolution.
- `application/modules/admin_core/controllers/Admin_core.php`: Manages tenant CRUD, settings, and tenant-level updates.
- `application/application/config/database.php`: Contains tenant-aware database resolution logic.
- `application/application/core/AdminController.php`: Loads Admin Core helper and enforces tenant native-core feature access.
- `application/application/controllers/admin/Mods.php`: Restricts module management behavior for tenant hosts.

## Data / Tables

- `tbltenants`: Global/admin-host table containing tenant identity, DB credentials, status, allowlists, frontend settings, and Events defaults.
- Tenant app options: Admin Core can update selected tenant options such as `companyname`, `companydomain`, `default_language`, and `default_timezone`.

## Tenant Considerations

- Tenant config should be data-driven whenever possible.
- Avoid hardcoded tenant names, paths, domains, or secrets.
- Use Admin Core helpers when reading current tenant policy or allowed feature/module state.
- Treat admin-host fan-out operations as high risk. One tenant failure should not block all tenants.

## Related

- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)
- [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](../../Standards/Tenant%20Safety%20Standards.md)
- [[V1 App/Architecture/Request And Database Routing]] | [Request And Database Routing](Request%20And%20Database%20Routing.md)
- [[V1 App/Architecture/System Overview]] | [System Overview](System%20Overview.md)

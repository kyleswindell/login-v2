# Admin Core

Parent: [[V1 App/Modules/Module Index]] | [Module Index](Module%20Index.md)

## Purpose

Admin Core manages central tenant administration and multi-tenant configuration.

## Use This Note When

Use this note when you need the clearest module-level answer to:

- what the V1 `admin_core` module is responsible for
- which tenant orchestration concerns live inside the module today
- which files implement tenant provisioning and policy behavior

Do not use this note as the main owner of:

- the full multi-tenant architecture story
- the exact `tbltenants` schema
- tenant-facing feature inventory outside this module

## Current Implementation

The module provides tenant CRUD, tenant staff management, logs, backup overview, module access configuration, frontend website integration settings, and tenant defaults for other modules.

## Important Files

- `application/modules/admin_core/admin_core.php`
- `application/modules/admin_core/controllers/Admin_core.php`
- `application/modules/admin_core/helpers/admin_core_helper.php`
- `application/modules/admin_core/models/Tenants_model.php`
- `application/modules/admin_core/models/Tenant_staff_model.php`
- `application/modules/admin_core/install.php`

## Main Responsibilities

- Tenant CRUD and host-to-database mapping.
- Tenant database provisioning from a template database.
- Tenant active/inactive state.
- Tenant staff management from the master admin CRM.
- Tenant module allowlists.
- Tenant native Perfex core feature allowlists.
- Tenant frontend website integration settings.
- Tenant Events module defaults.
- Admin logs and backup overview.

## Defensive Controller Pattern

New write-heavy or operational Admin Core controller actions should:

- Wrap action bodies in `try/catch (Throwable $e)`.
- Route failures to `handle_admin_core_exception(...)`.
- Log technical details with `log_message('error', ...)`.
- Show safe user-facing alerts.
- Redirect to a stable recovery route.

Use this pattern especially for tenant DB connections, provisioning, module sync, filesystem work, log parsing, and backup/report generation.

## Tenant Data

Admin Core tenant records include:

- `tenant_key`
- `db_host`
- `db_name`
- `db_user`
- `db_pass`
- `is_active`
- `allowed_modules`
- `allowed_core_features`
- `frontend_base_url`
- `frontend_site_root_path`
- `events_sync_relative_dir`
- `events_sync_enabled`
- `events_sync_endpoint_url`
- `events_sync_secret`

## Related

- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](../Architecture/Multi%20Tenant%20Architecture.md)
- [[V1 App/Architecture/Core Perfex Customizations]] | [Core Perfex Customizations](../Architecture/Core%20Perfex%20Customizations.md)
- [[V1 App/Reference/Admin Core Data Model]] | [Admin Core Data Model](../Reference/Admin%20Core%20Data%20Model.md)
- [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](../../Standards/Tenant%20Safety%20Standards.md)
- [[V1 App/Features/Tenant Module Allowlist]] | [Tenant Module Allowlist](../Features/Tenant%20Module%20Allowlist.md)

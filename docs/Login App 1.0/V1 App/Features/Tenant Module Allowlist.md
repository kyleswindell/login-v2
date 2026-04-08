# Tenant Module Allowlist

Parent: [[V1 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)

## Purpose

Document how module visibility and module actions are controlled per tenant.

## Current Implementation

Tenant module visibility is controlled through the global tenant record, not by exposing every module folder to every tenant.

Each tenant stores an explicit `allowed_modules` snapshot in `tbltenants`. Future modules added to the shared codebase do not automatically appear for existing tenants unless added to that tenant's allowlist.

## Behavior

- New tenant module permissions are selected during tenant creation/edit.
- Tenant `Setup -> Modules` only shows modules allowed for that tenant.
- Disallowed modules are blocked from activation in the tenant CRM.
- Tenant hosts cannot perform global module actions such as upload, uninstall, or update-version.
- `admin_core` is intentionally excluded from tenant module visibility.

## Important Files

- `application/modules/admin_core/helpers/admin_core_helper.php`
- `application/modules/admin_core/controllers/Admin_core.php`
- `application/application/controllers/admin/Mods.php`
- `application/application/views/admin/modules/list.php`

## Related

- [[V1 App/Features/Tenant Permissions]] | [Tenant Permissions](Tenant%20Permissions.md)
- [[V1 App/Architecture/Core Perfex Customizations]] | [Core Perfex Customizations](../Architecture/Core%20Perfex%20Customizations.md)
- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)

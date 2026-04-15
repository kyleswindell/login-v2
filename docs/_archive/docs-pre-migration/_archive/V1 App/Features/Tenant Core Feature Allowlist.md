# Tenant Core Feature Allowlist

Parent: [[V1 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)

## Purpose

Document how native Perfex feature access is controlled per tenant.

## Current Implementation

Admin Core stores `allowed_core_features` in the global tenant record. The Admin Core helper filters tenant UI elements and enforces direct route access.

## Examples Of Feature Areas

- customers
- sales
- subscriptions
- expenses
- contracts
- projects
- tasks
- support
- leads
- estimate_request
- knowledge_base
- reports

## Important Files

- `application/modules/admin_core/helpers/admin_core_helper.php`
- `application/application/core/AdminController.php`
- `application/modules/admin_core/views/tenants/tenant.php`

## Related

- [[V1 App/Features/Tenant Permissions]] | [Tenant Permissions](Tenant%20Permissions.md)
- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](../Architecture/Multi%20Tenant%20Architecture.md)
- [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](../../Standards/Tenant%20Safety%20Standards.md)

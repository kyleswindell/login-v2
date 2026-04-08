# Request And Database Routing

Parent: [[V1 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)

## Purpose

Document how the application chooses the admin database or a tenant database.

## Current Implementation

Database selection is controlled in `application/application/config/database.php`.

The app reads the request host from `$_SERVER['HTTP_HOST']`. If the host is `cli` or equals `APP_ADMIN_HOST`, the global/admin database credentials are used.

For non-admin hosts, the app connects to the global/admin database first, looks up `tbltenants` by `tenant_key`, and then switches the default database config to the tenant database credentials from that row.

## Failure Modes

- Admin database connection failure: return a 500 error.
- Unknown tenant host: fail closed with `show_404()`.
- Inactive tenant: clear session/cookies where possible, return `503 Service Unavailable`, and render `application/application/views/errors/tenant_inactive.php` if present.

## Safety Notes

- Tenant host routing depends on `APP_ADMIN_HOST` being correct.
- Do not change this file during Perfex upgrades without re-checking tenant routing.
- Avoid adding side effects before tenant active/inactive checks.

## Related

- [[V1 App/Architecture/Multi Tenant Architecture]] | [Multi Tenant Architecture](Multi%20Tenant%20Architecture.md)
- [[V1 App/Modules/Admin Core]] | [Admin Core](../Modules/Admin%20Core.md)
- [[Standards/Tenant Safety Standards]] | [Tenant Safety Standards](../../Standards/Tenant%20Safety%20Standards.md)

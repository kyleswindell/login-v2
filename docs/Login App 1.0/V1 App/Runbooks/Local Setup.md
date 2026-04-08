# Local Setup

Parent: [[V1 App/Runbooks/Runbook Index]] | [Runbook Index](Runbook%20Index.md)

## Purpose

Document how to run the app locally.

## Current Local Stack Clues

The current repo and local configuration indicate:

- PHP `8.1+` is required
- Composer dependencies live under `application/application/`
- Node build tooling runs from `application/`
- the admin/local primary DB is configured as `perfex`
- the tenant template DB is configured as `perfex_template`
- host-based routing uses `APP_ADMIN_HOST`, currently `perfex.local`
- local DB credentials are currently defined directly in `application/application/config/app-config.php`

## Practical Local Setup Flow

1. Configure local hosts so the admin hostname resolves correctly.
2. Ensure the local web server points at the `application/` web root.
3. Ensure MySQL is running and the expected databases exist:
   - `perfex`
   - `perfex_template`
4. Confirm `application/application/config/app-config.php` has the correct local DB credentials and host settings.
5. Install PHP dependencies from `application/application/` if needed.
6. Install Node dependencies from `application/` if asset work is needed.
7. Build assets from `application/` when front-end sources or build config change.

## Important Files

- `application/index.php`
- `application/application/config/app-config.php`
- `application/application/config/config.php`
- `application/application/config/database.php`
- `application/application/composer.json`
- `application/package.json`

## Notes

- V1 local routing is host-sensitive because tenant resolution depends on `$_SERVER['HTTP_HOST']`.
- Requests to the admin host use the admin/global DB directly.
- Non-admin hosts bootstrap through the admin DB and then switch to a tenant DB if `tbltenants` contains a matching `tenant_key`.
- For asset work, root app Node scripts are run from `application/`, while Composer work is under `application/application/`.

## Still Environment-Specific

This runbook intentionally avoids hardcoding machine-only values such as:

- exact WAMP/Apache vhost configuration
- exact hosts-file entries
- local passwords
- per-machine PHP/Node install locations

## Related

- [[V1 App/Runbooks/Runbook Index]] | [Runbook Index](Runbook%20Index.md)
- [[V1 App/Architecture/Request And Database Routing]] | [Request And Database Routing](../Architecture/Request%20And%20Database%20Routing.md)
- [[V1 App/Folder Reference/Application Tree Map]] | [Application Tree Map](../Folder%20Reference/Application%20Tree%20Map.md)
- [[V1 App/Folder Reference/package.json File]] | [package.json File](../Folder%20Reference/package.json%20File.md)
- [[V1 App/Reference/Asset Build Pipeline]] | [Asset Build Pipeline](../Reference/Asset%20Build%20Pipeline.md)

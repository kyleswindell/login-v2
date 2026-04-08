# Deploy Checklist

Parent: [[V1 App/Runbooks/Runbook Index]] | [Runbook Index](Runbook%20Index.md)

## Purpose

Track deployment steps and release checks.

## Checklist

- Confirm the target environment meets the PHP requirement of `8.1+`.
- Confirm the correct `application/application/config/app-config.php` values for:
  - `APP_BASE_URL` behavior
  - `APP_ADMIN_HOST`
  - DB host/user/password/name
  - `APP_TENANT_TEMPLATE_DB`
  - cron key and encryption key handling
- Confirm admin-host and tenant-host DNS/vhost routing is correct before go-live.
- Confirm database backups exist for the admin/global DB and affected tenant DBs.
- Confirm module install/migration files are idempotent.
- Confirm tenant-routing changes in `application/application/config/database.php` and related core customizations are preserved during upgrades.
- Build assets if front-end/admin asset source changed.
- If dependencies changed, install/update Composer packages in `application/application/`.
- If asset tooling changed, install/update Node packages in `application/`.
- Review tenant-safe path, domain, and secret handling before release.
- Confirm cron and scheduler execution still work with the expected `APP_CRON_KEY`.
- Review application logs after deployment and confirm no tenant-routing or module-install errors appear.

## Notes

- In V1, deployment risk is higher than a stock Perfex app because admin-host routing, tenant DB switching, and several app behaviors depend on customized core files plus custom modules.
- Deployments that touch build tooling, DB routing, Admin Core, Events, or cron behavior should be treated as higher-risk releases.

## Related

- [[Standards/Database Migration Standards]] | [Database Migration Standards](../../Standards/Database%20Migration%20Standards.md)
- [[V1 App/Architecture/Request And Database Routing]] | [Request And Database Routing](../Architecture/Request%20And%20Database%20Routing.md)
- [[V1 App/Architecture/Core Perfex Customizations]] | [Core Perfex Customizations](../Architecture/Core%20Perfex%20Customizations.md)
- [[V1 App/Runbooks/Build Assets]] | [Build Assets](Build%20Assets.md)
- [[V1 App/Runbooks/Run Cron]] | [Run Cron](Run%20Cron.md)

# Upgrade Review Checklist

Parent: [[V1 App/Runbooks/Runbook Index]] | [Runbook Index](Runbook%20Index.md)

## Purpose

Use this when applying upstream Perfex updates or large module changes.

## Checklist

- Review `application/application/config/database.php` for tenant database routing.
- Review `application/index.php` for front-controller host handling and `TENANT_KEY` setup.
- Review `application/application/config/app-config.php` for admin host, DB, template DB, and secret definitions.
- Review `application/application/core/AdminController.php` for Admin Core helper loading and feature enforcement.
- Review `application/application/controllers/admin/Mods.php` for tenant module restrictions.
- Review `application/application/views/admin/modules/list.php` for tenant module UI behavior.
- Review asset build files if front-end tooling changed:
  - `application/package.json`
  - `application/webpack.mix.js`
  - `application/tailwind.config.js`
- Re-test tenant provisioning.
- Re-test tenant login and routing.
- Re-test tenant staff management.
- Re-test tenant module visibility and activation behavior.
- Re-test tenant native core feature visibility and route blocking.
- Re-test Events website sync if frontend integration or scheduler behavior changed.
- Re-test cron-driven tenant fan-out behavior if Admin Core or Events scheduler logic changed.

## Related

- [[V1 App/Architecture/Core Perfex Customizations]] | [Core Perfex Customizations](../Architecture/Core%20Perfex%20Customizations.md)
- [[V1 App/Architecture/Request And Database Routing]] | [Request And Database Routing](../Architecture/Request%20And%20Database%20Routing.md)
- [[Standards/Testing Standards]] | [Testing Standards](../../Standards/Testing%20Standards.md)

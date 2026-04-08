# App 2.0 Blueprint

This file is the working planning copy for Login App 2.0. The original planning notes were created in the Perfex 1.0 reference repository and should be treated as historical context.

## Locked Direction

* Laravel platform and tenant admin application.
* Filament and Livewire for admin panels.
* PostgreSQL for central and tenant databases.
* Redis for queues and cache.
* Apache + PHP-FPM on the production VPS.
* One Laravel codebase.
* One central platform database.
* One separate PostgreSQL database per tenant.
* One PostgreSQL role per tenant.
* Arbitrary tenant admin domains from day one.
* Astro + Tailwind for future public website rebuilds.
* Legacy HTML / Bootstrap / PHP websites can coexist on the VPS during migration.

## Domains

Platform admin:

* `login.parasolutions.com`

Tenant admin:

* arbitrary tenant admin domains, for example `login.clientdomain.com`

Tenant resolution order:

1. exact tenant admin domain match
2. optional alias domain match
3. resolve tenant from central platform database
4. initialize tenant database connection
5. boot tenant context

## Initial Build Order

1. Repository foundation and documentation.
2. Laravel scaffold.
3. Docker Compose local development stack.
4. Platform database schema.
5. Tenant domain registry.
6. Tenant resolver and database connection manager.
7. Tenant active/inactive middleware.
8. Tenant template database creation process.
9. Provisioning pipeline and logs.
10. Tenant storage initializer.
11. Platform panel tenant resources.
12. Tenant panel authentication and minimal dashboard.
13. Module policy model.
14. Page/block/article/media content foundation.
15. Publish job and Astro build hook.

## Remote Server Policy

The `platform-prod` SSH host can be used for package/version checks, Apache/PHP/PostgreSQL/Redis verification, and deployment path preparation.

Do not let the production VPS become the only source of truth for application code. Application code should be committed in this repo before deployment.

## Open Implementation Detail

Local development currently recommends Docker Compose. The scaffold can still begin by verifying the production-like `platform-prod` environment over SSH before the full local Compose file is finalized.

## Related

* [[V2 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)
* [[Decisions/ADR-0003 - App 2.0 Platform Foundation]] | [ADR-0003 - App 2.0 Platform Foundation](../../Decisions/ADR-0003%20-%20App%202.0%20Platform%20Foundation.md)

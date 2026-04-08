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
4. Platform-vs-tenant application boundary planning.
5. V2 feature roadmap and folder/panel structure planning.
6. Platform database schema.
7. Tenant domain registry.
8. Tenant resolver and database connection manager.
9. Tenant active/inactive middleware.
10. Tenant template database creation process.
11. Provisioning pipeline and logs.
12. Tenant storage initializer.
13. Platform panel tenant resources.
14. Tenant panel authentication and minimal dashboard.
15. Module policy model.
16. Page/block/article/media content foundation.
17. Publish job and Astro build hook.

## Remote Server Policy

The `platform-prod` SSH host can be used for package/version checks, Apache/PHP/PostgreSQL/Redis verification, and deployment path preparation.

Do not let the production VPS become the only source of truth for application code. Application code should be committed in this repo before deployment.

## Open Implementation Detail

Local development currently recommends Docker Compose. The scaffold can still begin by verifying the production-like `platform-prod` environment over SSH before the full local Compose file is finalized.

## Related

* [[V2 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)
* [[V2 App/V2 App Documentation Map]] | [V2 App Documentation Map](../V2%20App%20Documentation%20Map.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](Platform%20And%20Tenant%20Application%20Boundary.md)
* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../Planning/V2%20Feature%20Roadmap.md)
* [[Decisions/ADR-0003 - App 2.0 Platform Foundation]] | [ADR-0003 - App 2.0 Platform Foundation](../../Decisions/ADR-0003%20-%20App%202.0%20Platform%20Foundation.md)

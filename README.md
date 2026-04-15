# Login App 2.0

Login App 2.0 is the planned Laravel-based replacement foundation for the current Perfex 1.0 application.

## Direction

* Laravel application for the platform and tenant admin panels.
* Filament and Livewire for admin UI.
* PostgreSQL as the primary database.
* Redis for queues and cache.
* One central platform database.
* One separate PostgreSQL database and role per tenant.
* Arbitrary tenant admin domains from day one.
* Public websites handled separately through legacy hosting first and Astro/Tailwind rebuilds later.

## Key Domains

* Platform admin: `login.parasolutions.com`
* Tenant admin: arbitrary tenant-owned admin domains, for example `login.clientdomain.com`

## Documentation

Start with:

* [App 2.0 Blueprint](docs/03-architecture/app-2-0-blueprint.md)
* [Architecture Baseline](docs/03-architecture/app-2-0-blueprint-architecture-baseline.md)
* [Start Here](docs/00-start-here.md)
* [Authentication](docs/04-features/auth/authentication.md)
* [Event And Error Logging](docs/04-features/logging/event-and-error-logging.md)
* [Coding Standards](docs/02-standards/coding/Coding%20Standards.md)
* [Commenting Standards](docs/02-standards/coding/Commenting%20Standards.md)
* [Local Development](docs/10-runbooks/local-dev.md)
* [Server Readiness](docs/10-runbooks/server-readiness.md)

## Development Policy

This repo is the source of truth for App 2.0 code and documentation. The DigitalOcean server can be used for verification and deployment preparation, but meaningful application code should be committed here before deployment.

Local development should prefer the Docker Compose stack documented in [Local Development](docs/10-runbooks/local-dev.md).

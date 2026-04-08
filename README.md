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

* [App 2.0 Blueprint](docs/planning/app-2-blueprint.md)
* [ADR-0001 - Platform Foundation](docs/decisions/ADR-0001-platform-foundation.md)
* [Start Here](docs/00-start-here.md)
* [Authentication](docs/features/authentication.md)
* [Event And Error Logging](docs/features/event-and-error-logging.md)
* [Coding Standards](docs/standards/coding-standards.md)
* [Commenting Standards](docs/standards/commenting-standards.md)
* [Local Development](docs/server/local-development.md)
* [Server Readiness](docs/server/server-readiness.md)

## Development Policy

This repo is the source of truth for App 2.0 code and documentation. The DigitalOcean server can be used for verification and deployment preparation, but meaningful application code should be committed here before deployment.

Local development should prefer the Docker Compose stack documented in [Local Development](docs/server/local-development.md).

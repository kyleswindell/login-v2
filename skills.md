# skills.md

This file captures the repo-specific implementation and debugging workflows that future Codex sessions should follow.

## Read Before Working

* [[docs/00-start-here|Start Here]] | [Start Here](docs/00-start-here.md)
* [[docs/architecture/stack-overview|Stack Overview]] | [Stack Overview](docs/architecture/stack-overview.md)
* [[docs/standards/coding-standards|Coding Standards]] | [Coding Standards](docs/standards/coding-standards.md)
* [[docs/standards/commenting-standards|Commenting Standards]] | [Commenting Standards](docs/standards/commenting-standards.md)
* [[docs/standards/logging-standards|Logging Standards]] | [Logging Standards](docs/standards/logging-standards.md)

## Core Workflows

### Laravel feature work

Use this flow when adding application behavior:

1. update or add the relevant feature doc first if the behavior changes the platform contract
2. implement routes, controllers, requests, services, views, and tests
3. run `./vendor/bin/pint --test`
4. run `php artisan test --display-warnings`
5. update docs in the same change

### Stack-specific debugging

Use the matching stack guide before making assumptions:

* [[docs/stack/laravel|Laravel]] | [Laravel](docs/stack/laravel.md)
* [[docs/stack/filament-and-livewire|Filament And Livewire]] | [Filament And Livewire](docs/stack/filament-and-livewire.md)
* [[docs/stack/postgresql|PostgreSQL]] | [PostgreSQL](docs/stack/postgresql.md)
* [[docs/stack/redis|Redis]] | [Redis](docs/stack/redis.md)
* [[docs/stack/frontend-build|Frontend Build]] | [Frontend Build](docs/stack/frontend-build.md)
* [[docs/stack/docker-compose|Docker Compose]] | [Docker Compose](docs/stack/docker-compose.md)
* [[docs/stack/apache-php-fpm|Apache And PHP-FPM]] | [Apache And PHP-FPM](docs/stack/apache-php-fpm.md)

### Bug review

When investigating bugs:

1. identify the stack layer first
2. confirm the expected behavior from the relevant feature doc and stack guide
3. reproduce with the smallest route, command, or test possible
4. add or update a failing test when practical
5. fix the root cause, not only the symptom
6. document any new rule, edge case, or operational caveat

### Logging and observability

For runtime issues:

1. check platform audit logs for user-driven events
2. check central error logs for exception details and fingerprints
3. keep request and trace IDs consistent across layers
4. avoid logging secrets, tokens, or raw credentials

## Current Defaults

* Framework: Laravel
* Planned admin UI: Filament + Livewire
* Database: PostgreSQL
* Cache / queue: Redis
* Frontend build: Vite + Tailwind
* Local orchestration: Docker Compose
* Production runtime: Apache + PHP-FPM

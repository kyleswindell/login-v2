# skills.md

This file captures the repo-specific implementation and debugging workflows that future Codex sessions should follow.

## Read Before Working

* [[docs/Login App 1.0/00 - Start Here|Start Here]] | [Start Here](docs/Login%20App%201.0/00%20-%20Start%20Here.md)
* [[docs/Login App 1.0/V2 App/Architecture/Stack Overview|Stack Overview]] | [Stack Overview](docs/Login%20App%201.0/V2%20App/Architecture/Stack%20Overview.md)
* [[docs/Login App 1.0/Standards/Coding Standards|Coding Standards]] | [Coding Standards](docs/Login%20App%201.0/Standards/Coding%20Standards.md)
* [[docs/Login App 1.0/Standards/Commenting Standards|Commenting Standards]] | [Commenting Standards](docs/Login%20App%201.0/Standards/Commenting%20Standards.md)
* [[docs/Login App 1.0/Standards/Logging Standards|Logging Standards]] | [Logging Standards](docs/Login%20App%201.0/Standards/Logging%20Standards.md)

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

* [[docs/Login App 1.0/V2 App/Reference/Stack - Laravel|Laravel]] | [Laravel](docs/Login%20App%201.0/V2%20App/Reference/Stack%20-%20Laravel.md)
* [[docs/Login App 1.0/V2 App/Reference/Stack - Filament And Livewire|Filament And Livewire]] | [Filament And Livewire](docs/Login%20App%201.0/V2%20App/Reference/Stack%20-%20Filament%20And%20Livewire.md)
* [[docs/Login App 1.0/V2 App/Reference/Stack - PostgreSQL|PostgreSQL]] | [PostgreSQL](docs/Login%20App%201.0/V2%20App/Reference/Stack%20-%20PostgreSQL.md)
* [[docs/Login App 1.0/V2 App/Reference/Stack - Redis|Redis]] | [Redis](docs/Login%20App%201.0/V2%20App/Reference/Stack%20-%20Redis.md)
* [[docs/Login App 1.0/V2 App/Reference/Stack - Frontend Build|Frontend Build]] | [Frontend Build](docs/Login%20App%201.0/V2%20App/Reference/Stack%20-%20Frontend%20Build.md)
* [[docs/Login App 1.0/V2 App/Reference/Stack - Docker Compose|Docker Compose]] | [Docker Compose](docs/Login%20App%201.0/V2%20App/Reference/Stack%20-%20Docker%20Compose.md)
* [[docs/Login App 1.0/V2 App/Reference/Stack - Apache And PHP-FPM|Apache And PHP-FPM]] | [Apache And PHP-FPM](docs/Login%20App%201.0/V2%20App/Reference/Stack%20-%20Apache%20And%20PHP-FPM.md)

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

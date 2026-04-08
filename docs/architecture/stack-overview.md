# Stack Overview

## Current Base Stack

Login App 2.0 is built and planned around this stack:

* PHP `8.3`
* Laravel `13.x` application codebase
* Blade for the current foundation UI
* Filament for planned admin panels
* Livewire for planned reactive panel behavior
* PostgreSQL `16` for the platform database and future tenant databases
* Redis `7` for cache and queue infrastructure
* Docker Compose for local orchestration
* Vite for frontend asset bundling
* Tailwind CSS for utility-first styling
* Apache + PHP-FPM for the planned production runtime

## How The Pieces Fit Together

### Application layer

Laravel is the application framework and the main source of routing, middleware, validation, service composition, logging integration, queues, and tests.

### Admin UI layer

Filament and Livewire are planned for the long-term panel UI. Blade remains the right choice for low-level bootstrap pages and simple foundation screens until Filament is introduced.

### Data layer

PostgreSQL is the system of record. The platform database owns tenant registry and platform-wide data. Each tenant will eventually receive its own separate database and PostgreSQL role.

### Runtime support layer

Redis supports cache, queue, and other fast transient state. It is not the source of truth for business data.

### Frontend build layer

Vite and Tailwind handle asset compilation and styling. Laravel serves the application while Vite handles the asset pipeline.

### Local development layer

Docker Compose standardizes the local environment for app, node, postgres, redis, and mail tooling.

### Production layer

Apache proxies PHP execution through PHP-FPM. This keeps the production runtime conventional and predictable on the VPS.

## Best-Practice Direction

* Keep Laravel as the integration center of the stack.
* Keep PostgreSQL as the authoritative data store.
* Keep Redis limited to fast infrastructure concerns such as cache and queues.
* Keep Blade for foundation pages and Filament for panel-heavy admin workflows.
* Keep Vite and Tailwind as build and styling tools, not as application state managers.
* Keep Docker Compose as the standard local contract even if some contributors also run services natively.
* Keep Apache + PHP-FPM configuration simple and explicit.

## Stack Guides

* [[../stack/laravel|Laravel]] | [Laravel](../stack/laravel.md)
* [[../stack/filament-and-livewire|Filament And Livewire]] | [Filament And Livewire](../stack/filament-and-livewire.md)
* [[../stack/postgresql|PostgreSQL]] | [PostgreSQL](../stack/postgresql.md)
* [[../stack/redis|Redis]] | [Redis](../stack/redis.md)
* [[../stack/frontend-build|Frontend Build]] | [Frontend Build](../stack/frontend-build.md)
* [[../stack/docker-compose|Docker Compose]] | [Docker Compose](../stack/docker-compose.md)
* [[../stack/apache-php-fpm|Apache And PHP-FPM]] | [Apache And PHP-FPM](../stack/apache-php-fpm.md)

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

* [[V2 App/Reference/Stack - Laravel]] | [Stack - Laravel](../Reference/Stack%20-%20Laravel.md)
* [[V2 App/Reference/Stack - Filament And Livewire]] | [Stack - Filament And Livewire](../Reference/Stack%20-%20Filament%20And%20Livewire.md)
* [[V2 App/Reference/Stack - PostgreSQL]] | [Stack - PostgreSQL](../Reference/Stack%20-%20PostgreSQL.md)
* [[V2 App/Reference/Stack - Redis]] | [Stack - Redis](../Reference/Stack%20-%20Redis.md)
* [[V2 App/Reference/Stack - Frontend Build]] | [Stack - Frontend Build](../Reference/Stack%20-%20Frontend%20Build.md)
* [[V2 App/Reference/Stack - Docker Compose]] | [Stack - Docker Compose](../Reference/Stack%20-%20Docker%20Compose.md)
* [[V2 App/Reference/Stack - Apache And PHP-FPM]] | [Stack - Apache And PHP-FPM](../Reference/Stack%20-%20Apache%20And%20PHP-FPM.md)

## Related

* [[V2 App/Architecture/Architecture Index]] | [Architecture Index](Architecture%20Index.md)
* [[V2 App/Reference/Reference Index]] | [Reference Index](../Reference/Reference%20Index.md)

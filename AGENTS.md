# AGENTS.md

## Project Context

This repository contains Login App 2.0, a new Laravel-based platform intended to replace the current customized Perfex 1.0 foundation over time.

## High-Priority Rules

* Treat this repository as the source of truth for App 2.0.
* Keep the Perfex 1.0 repository as reference only unless the user explicitly asks to modify it.
* Use Laravel, Filament, Livewire, PostgreSQL, Redis, and Apache/PHP-FPM as the locked foundation unless a decision record changes that.
* Support arbitrary tenant admin domains from day one.
* Keep tenants isolated with one tenant database and one PostgreSQL role per tenant.
* Prefer data-driven tenant configuration over file-copy-driven behavior.
* Do not build meaningful untracked application code directly on the production server.
* Document architectural decisions in `docs/decisions/`.
* Keep server and deployment notes in `docs/server/`.

## Important Docs

* [App 2.0 Blueprint](docs/planning/app-2-blueprint.md)
* [ADR-0001 - Platform Foundation](docs/decisions/ADR-0001-platform-foundation.md)
* [Server Readiness](docs/server/server-readiness.md)

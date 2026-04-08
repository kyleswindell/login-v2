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
* Follow the commenting standard: prefer self-documenting code, use PHPDoc for contracts/static analysis, and remove commented-out starter code.
* Use the stack guides in `docs/stack/` when implementing or debugging framework, infrastructure, and frontend concerns.
* Prefer official documentation for Laravel, Filament, Livewire, PostgreSQL, Redis, Docker, Vite, Tailwind, and Apache when updating stack rules.

## Important Docs

* [Vault Start Here](docs/Login%20App%201.0/00%20-%20Start%20Here.md)
* [V2 App Documentation Map](docs/Login%20App%201.0/V2%20App/V2%20App%20Documentation%20Map.md)
* [Architecture Index](docs/Login%20App%201.0/V2%20App/Architecture/Architecture%20Index.md)
* [Reference Index](docs/Login%20App%201.0/V2%20App/Reference/Reference%20Index.md)
* [Standards Index](docs/Login%20App%201.0/Standards/Standards%20Index.md)
* [Codex Working Rules](docs/Login%20App%201.0/Codex/Codex%20Working%20Rules.md)

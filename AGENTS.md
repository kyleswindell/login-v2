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
* Document architectural decisions in `docs/Decisions/`.
* Keep server and deployment notes in `docs/V2 App/Runbooks/` and related Phase 0 planning notes.
* Follow the commenting standard: prefer self-documenting code, use PHPDoc for contracts/static analysis, and remove commented-out starter code.
* Use the stack guides in `docs/V2 App/Reference/` when implementing or debugging framework, infrastructure, and frontend concerns.
* Prefer official documentation for Laravel, Filament, Livewire, PostgreSQL, Redis, Docker, Vite, Tailwind, and Apache when updating stack rules.
* When implementing a planned system, update the canonical system doc and the linked planning note in the same work cycle.
* Planning notes must keep a current implementation status section, even when that status is copied from the canonical system doc.
* Permanent system docs and their source planning notes must link to each other so implementation state is easy to confirm in the Obsidian graph.
* Start docs discovery from `docs/00 - Start Here.md`, then follow the V2 map, the relevant index note, and the canonical feature/reference/runbook doc before changing code.
* Use `docs/V2 App/Planning/` for sequencing and intent, and use `docs/V2 App/Features/`, `docs/V2 App/Reference/`, and `docs/V2 App/Runbooks/` as the canonical implementation/system owners.
* During CPD (`commit/push/deploy`), commit only files the active agent explicitly touched for the requested scope; do not include unrelated staged or modified files.
* For concurrent documentation work, implementation agents stage proposed canonical doc updates under `docs/Codex/Agent Doc Staging/` using the queue/template workflow; docs-sync review agents apply approved updates into canonical docs.

## Important Docs

* [Vault Start Here](docs/00%20-%20Start%20Here.md)
* [V2 App Documentation Map](docs/V2%20App/V2%20App%20Documentation%20Map.md)
* [Architecture Index](docs/V2%20App/Architecture/Architecture%20Index.md)
* [Feature Index](docs/V2%20App/Features/Feature%20Index.md)
* [Reference Index](docs/V2%20App/Reference/Reference%20Index.md)
* [Runbook Index](docs/V2%20App/Runbooks/Runbook%20Index.md)
* [Planning Index](docs/V2%20App/Planning/Planning%20Index.md)
* [Development Index](docs/V2%20App/Development/Development%20Index.md)
* [Standards Index](docs/Standards/Standards%20Index.md)
* [Implementation Status And Development Sync Standard](docs/Standards/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
* [How To Write Docs](docs/Documentation%20Standards/How%20To%20Write%20Docs.md)
* [Codex Working Rules](docs/Codex/Codex%20Working%20Rules.md)

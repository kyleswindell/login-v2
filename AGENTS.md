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
* Treat `docs/` as the canonical documentation root for active App 2.0 documentation.
* Treat `docs/_archive/` as historical-only and out of scope for active updates unless explicitly requested.
* Document architectural and operational decisions in the canonical `docs/` branches and keep them synchronized with related planning notes.
* Keep server and deployment notes in `docs/10-runbooks/` and related Phase 0 planning notes under `docs/07-planning/`.
* Follow the commenting standard: prefer self-documenting code, use PHPDoc for contracts/static analysis, and remove commented-out starter code.
* Use the stack guides in `docs/09-reference/` when implementing or debugging framework, infrastructure, and frontend concerns.
* Prefer official documentation for Laravel, Filament, Livewire, PostgreSQL, Redis, Docker, Vite, Tailwind, and Apache when updating stack rules.
* When implementing a planned system, update the canonical system doc and the linked planning note in the same work cycle.
* Planning notes must keep a current implementation status section, even when that status is copied from the canonical system doc.
* Permanent system docs and their source planning notes must link to each other so implementation state is easy to confirm in the Obsidian graph.
* Start docs discovery from `docs/00-start-here.md`, then follow the relevant branch index and canonical owner doc before changing code.
* Use `docs/07-planning/` for sequencing and intent, and use `docs/02-standards/`, `docs/03-architecture/`, `docs/04-features/`, `docs/06-database/`, and `docs/10-runbooks/` as canonical implementation/system owners by branch.
* Enforce docs branch responsibilities: `02-standards` rules only, `03-architecture` structure only, `04-features` behavior only, `05-flows` execution steps only, `06-database` schema only, `07-planning` sequencing only, `09-reference` support only, `10-runbooks` operations only.
* Do not introduce legacy documentation paths or legacy wiki links in active docs; always use current canonical `docs/` paths.
* During CPD (`commit/push/deploy`), commit only files the active agent explicitly touched for the requested scope; do not include unrelated staged or modified files.
* For concurrent documentation work, follow the active staging and docs-sync workflow defined from the canonical `docs/` standards and start-here guidance.

## Important Docs

* [Vault Start Here](docs/00-start-here.md)
* [Standards Index](docs/02-standards/index.md)
* [Architecture Index](docs/03-architecture/index.md)
* [Feature Index](docs/04-features/index.md)
* [Flows Index](docs/05-flows/index.md)
* [Database Index](docs/06-database/index.md)
* [Planning Index](docs/07-planning/index.md)
* [Reference Index](docs/09-reference/index.md)
* [Runbook Index](docs/10-runbooks/index.md)
* [Implementation Status And Development Sync Standard](docs/02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
* [How To Write Docs](docs/02-standards/documentation/How%20To%20Write%20Docs.md)
* [Obsidian Vault Structure Guide](docs/02-standards/documentation/Obsidian%20Vault%20Structure%20Guide.md)

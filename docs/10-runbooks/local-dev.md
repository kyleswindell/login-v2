<!--
DOC-META
title: Local Development
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/local-dev.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines first-time and routine local startup, verification, reset, and shutdown procedures for the Docker-based Login 2.0 development environment.
-->

# Local Development

Parent: [Runbook Index](index.md)

## Purpose

Start, verify, use, reset, and stop the local Login 2.0 development environment.

## Use When

Use for:

- first local setup
- routine startup
- database reset recovery
- local test execution
- local service verification
- routine shutdown

## Do Not Use When

Do not use this runbook for:

- staging or production deployment
- parallel writable worktrees
- destructive cleanup of unknown Docker projects
- production data restoration

## Prerequisites

Required:

- Docker Desktop or Docker Engine
- Docker Compose
- Git
- repository checkout
- Node.js and npm on the host for the default Vite path

Optional local CLI tooling:

- PHP 8.3
- Composer
- PostgreSQL extensions
- Redis extension

Local credentials and database values in this runbook are development-only.

## First-Time Setup

From the repository root:

    cp .env.example .env
    docker compose run --rm app sh -lc "composer install && php artisan key:generate"
    docker compose up --build -d

Install host frontend dependencies:

    npm install

Start host Vite in a separate terminal:

    npm run dev:host

Prepare browser-review state:

    docker compose exec app php artisan local:ready

## Routine Startup

From the repository root:

    docker compose up -d

Start host Vite:

    npm run dev:host

Verify browser-review readiness:

    docker compose exec app php artisan local:ready

## Expected Services

Default active services:

- app
- reverb
- postgres
- redis
- mailpit

The Docker `node` service is opt-in through the `docker-vite` profile.

## Local URLs

- application: `http://localhost:8000`
- Vite: `http://localhost:5173`
- Mailpit: `http://localhost:8025`
- Reverb: `ws://localhost:8080`

## Verification

Run:

    docker compose ps
    docker compose exec app php artisan about
    docker compose exec app php artisan migrate:status
    docker compose exec app php artisan test
    npm run build

Expected:

- required containers are running
- PostgreSQL is healthy
- Laravel uses `pgsql`
- cache and queue use Redis
- migrations are current
- tests pass
- frontend build passes

## Browser Review User

`php artisan local:ready` creates or updates the local-only review account:

- email: `test@example.com`
- password: `password`

This account must never be used as a staging or production default.

## Host Vite

Default Windows browser review uses:

    npm run dev:host

Do not use the Docker `node` service unless testing that path specifically.

For Docker Vite:

    docker compose --profile docker-vite up -d node
    docker compose exec app php artisan local:ready --vite-check-url=http://node:5173

Restart the optional node service with:

    docker compose --profile docker-vite restart node

## Reverb

Ensure Reverb is running:

    docker compose up -d reverb
    docker compose exec app php artisan local:ready

## LAN Review

Use browser-reachable URLs:

    docker compose exec app php artisan local:ready --app-url=http://192.168.50.10:8000 --vite-url=http://192.168.50.10:5173

Replace the IP with the current development host.

## Database Reset

For a local-only destructive reset:

    docker compose exec app php artisan migrate:fresh --seed
    docker compose exec app php artisan local:ready

Confirm no needed local data exists before running `migrate:fresh`.

## Dependency Volume Reset

Only when intentionally clearing dependencies:

    docker compose down --volumes
    docker compose run --rm app sh -lc "composer install && php artisan key:generate"
    docker compose up --build -d
    npm install

This removes Compose-managed volumes for the current project.

## Failure Handling

If Laravel fails:

    docker compose logs app --tail=200

If PostgreSQL fails:

    docker compose logs postgres --tail=200

If Redis fails:

    docker compose logs redis --tail=200

If Reverb fails:

    docker compose logs reverb --tail=200

If Vite appears stale:

1. confirm `npm run dev:host` is running
2. run `docker compose exec app php artisan local:ready`
3. restart host Vite once
4. rerun readiness
5. use built assets only after `npm run build` succeeds

Do not loop through cache busting, hot-file moves, and repeated restarts.

## Shutdown

Stop services:

    docker compose down

Preserve volumes unless intentional cleanup is required.

## Completion Criteria

Local development is ready when:

- required services are running
- migrations are current
- `local:ready` passes
- the login route loads
- Vite assets load
- Reverb is reachable
- required tests pass

## Related

- [Local Browser Review](local-browser-review.md)
- [Parallel Worktree Setup](parallel-worktree-setup.md)

# Local Development

This document defines the canonical scope and intent for Local Development.

## Required Local Tooling

Docker Compose is the preferred local development path. The local PHP CLI is still useful for quick Composer and Artisan checks outside Docker.

Required before running the full local stack:

* Docker Desktop or Docker Engine with Compose support

Required before running Composer/Laravel commands outside Docker:

* PHP 8.3
* Composer
* Node.js and npm for Vite frontend asset builds
* `curl`
* `dom`
* `intl`
* `mbstring`
* `xml`
* `xmlreader`
* `xmlwriter`
* `zip`
* `pdo_pgsql`
* `pgsql`
* `pdo_sqlite`, optional for Laravel's default in-memory PHPUnit configuration until the test database is switched to PostgreSQL
* `unzip`

## Current Database Direction

App 2.0 uses PostgreSQL from the start.

The Docker Compose local platform database is:

* database: `platform_app`
* user: `platform_app`
* password: `secret`
* host from inside containers: `postgres`
* host from the machine running Docker: `127.0.0.1:5432`

These values are local-development placeholders only.

## Timezones

Store application timestamps in UTC unless a feature-specific canonical doc states otherwise.

Display user-facing timestamps in the signed-in user's timezone when available. `APP_TIMEZONE` should remain `UTC` in environment files unless an explicit decision record changes that default.

## Redis

Redis is the default local cache and queue backend in `.env.example`.

The Docker Compose Redis host is `redis` inside containers and `127.0.0.1:6379` from the machine running Docker.

## Docker Compose

Start from the repository root:

```bash
cp .env.example .env
docker compose run --rm app sh -lc "composer install && php artisan key:generate"
docker compose up --build -d
```

In a host terminal, start Vite:

```bash
npm run dev:host
```

Default local URLs:

* Laravel app: `http://localhost:8000`
* Vite dev server: `http://localhost:5173`
* Mailpit dashboard: `http://localhost:8025`

Before authenticated local browser review, run:

```bash
docker compose exec app php artisan local:ready
```

or, when using local PHP/npm directly:

```bash
npm run local:ready
```

This command normalizes `public/hot`, aligns the browser-facing Reverb host with the app URL, checks the local app, Vite endpoints, and Reverb TCP port, and upserts the review user `test@example.com` / `password` with platform review/admin access. After Docker database resets, rerun this command instead of manually recreating the user or rewriting `public/hot`.

For LAN review, pass the browser-reachable URLs so Vite and websocket clients do not fall back to stale localhost values:

```bash
docker compose exec app php artisan local:ready --app-url=http://192.168.50.10:8000 --vite-url=http://192.168.50.10:5173
```

The Compose stack includes:

* `app`: PHP 8.3 CLI container running Laravel's local server
* `node`: optional Node 22 container running Vite under the `docker-vite` profile
* `reverb`: Laravel Reverb websocket server for local realtime notification review
* `postgres`: PostgreSQL 16
* `redis`: Redis 7
* `mailpit`: local email capture

On Windows, the default local review path is to run Vite on the host with `npm run dev:host` instead of using the Docker `node` service. This avoids Docker bind-mount CSS transform hangs while keeping Laravel, PostgreSQL, Redis, and Mailpit in Docker. The host Vite server binds to `0.0.0.0` so the app container can verify it through `host.docker.internal`, while Laravel serves browser asset URLs through `http://localhost:5173`.

Use the Docker Vite service only when explicitly testing the containerized Node path:

```bash
docker compose --profile docker-vite up node
docker compose exec app php artisan local:ready --vite-check-url=http://node:5173
```

The Docker Vite service enables polling by default for Windows bind mounts. Restart the `node` service once if the Docker Vite path appears stale; use host-run Vite as the default local review path.

Realtime notification review expects Reverb to be running:

```bash
docker compose up -d reverb
docker compose exec app php artisan local:ready
```

`local:ready` normalizes local `.env` to `BROADCAST_CONNECTION=reverb`, binds the Reverb server to `0.0.0.0:8080`, and points the browser-facing Reverb host at the app URL host.

Compose mounts `vendor/` and `node_modules/` as Docker named volumes. That keeps Composer and npm dependency trees out of each checkout or disposable worker worktree while preserving them for the active Compose project. Use `docker compose down --volumes` when intentionally clearing those dependency volumes.

## Verification Commands

After `docker compose up --build` is running, use a second terminal from the repository root:

```bash
docker compose ps
docker compose exec app php artisan about
docker compose exec app php artisan migrate
docker compose exec app php artisan test
```

If the stack is not already running and the dependency volume may be empty, run one-off Artisan commands through Composer first:

```bash
docker compose run --rm app sh -lc "composer install && php artisan test"
```

Expected baseline:

* all five services are up
* `postgres` reports healthy
* Laravel reports database driver `pgsql`
* Laravel reports cache and queue drivers `redis`
* Laravel reports mail driver `smtp`
* migrations run against PostgreSQL
* the default Laravel tests pass

This baseline was verified locally after Docker Desktop WSL integration was enabled.

## Local-First Development Policy

The restored local development stack is the default verification surface for ordinary implementation work.

Use local Docker Compose for:

* scoped feature tests
* focused UI Reference and platform route checks
* migrations and seed/data-shape checks
* frontend build checks when the change affects compiled assets
* browser review against `localhost` when shared staging is not required

Do not push or deploy to the server just to answer questions that the local stack can answer. Server/staging deployment should be reserved for:

* review-ready checkpoints that need a shared manual review URL
* fixes that must be revalidated by someone outside the local workstation
* environment-specific behavior that cannot be proven locally
* final promotion or close-out paths required by the active workflow

This keeps server commits, deploy work, and workflow write-up overhead focused on reviewable milestones instead of implementation micro-steps.

Local manual review may inspect scoped uncommitted changes on the same working tree. Once that local review accepts a change-queue item or tightly coupled group, create the scoped implementation commit before moving that work to passed review. Shared review still requires the commit, push, and deploy to happen before review begins.

## Frontend Assets

Laravel includes Vite frontend tooling. Node.js/npm must be available before running:

```bash
npm install
npm run build
```

If local Windows/WSL Node tooling is unreliable, prefer handling Node through Docker Compose once the local development stack is finalized.

For Windows host browser review, prefer:

```bash
npm run dev:host
docker compose exec app php artisan local:ready
```

For browser-review asset troubleshooting, use [Local Browser Review Setup](local-browser-review.md). Agents should not repeatedly move `public/hot`, cache-bust Vite modules, or restart the Node service during ordinary UI iteration.

## Notes

Laravel's default scaffold creates a SQLite placeholder during `composer create-project`. This project removes that placeholder because PostgreSQL is the intended platform database.

## Related

* [Runbook Index](index.md)
* [00-start-here](../00-start-here.md)
* [Stack - Docker Compose](../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)
* [Stack - Laravel](../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)

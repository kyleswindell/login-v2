# Local Development

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

* database: `login_v2_platform`
* user: `login_v2`
* password: `secret`
* host from inside containers: `postgres`
* host from the machine running Docker: `127.0.0.1:5432`

These values are local-development placeholders only.

## Redis

Redis is the default local cache and queue backend in `.env.example`.

The Docker Compose Redis host is `redis` inside containers and `127.0.0.1:6379` from the machine running Docker.

## Docker Compose

Start from the repository root:

```bash
cp .env.example .env
docker compose run --rm app php artisan key:generate
docker compose up --build
```

Default local URLs:

* Laravel app: `http://localhost:8000`
* Vite dev server: `http://localhost:5173`
* Mailpit dashboard: `http://localhost:8025`

The Compose stack includes:

* `app`: PHP 8.3 CLI container running Laravel's local server
* `node`: Node 22 container running Vite
* `postgres`: PostgreSQL 16
* `redis`: Redis 7
* `mailpit`: local email capture

## Frontend Assets

Laravel includes Vite frontend tooling. Node.js/npm must be available before running:

```bash
npm install
npm run build
```

If local Windows/WSL Node tooling is unreliable, prefer handling Node through Docker Compose once the local development stack is finalized.

## Notes

Laravel's default scaffold creates a SQLite placeholder during `composer create-project`. This project removes that placeholder because PostgreSQL is the intended platform database.

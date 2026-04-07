# Local Development

## Required Local Tooling

The local PHP CLI needs the same core extensions expected by the Laravel app.

Required before running Composer/Laravel commands:

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

The example local platform database is:

* database: `login_v2_platform`
* user: `login_v2`
* password: `secret`

These values are placeholders for local development and should be replaced by Docker Compose or local PostgreSQL setup values as the environment is finalized.

## Redis

Redis is the default local cache and queue backend in `.env.example`.

## Frontend Assets

Laravel includes Vite frontend tooling. Node.js/npm must be available before running:

```bash
npm install
npm run build
```

If local Windows/WSL Node tooling is unreliable, prefer handling Node through Docker Compose once the local development stack is finalized.

## Notes

Laravel's default scaffold creates a SQLite placeholder during `composer create-project`. This project removes that placeholder because PostgreSQL is the intended platform database.

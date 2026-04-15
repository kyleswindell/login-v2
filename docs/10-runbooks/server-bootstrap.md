# Server Bootstrap Checklist

This document defines the canonical scope and intent for Server Bootstrap Checklist.

## Purpose

List the server capabilities that should be verified before deeper V2 deployment work continues.

## Host

Current target:

* `platform-prod`

## Required Runtime Baseline

Verify:

* Apache installed: verified
* PHP `8.3`: verified
* PHP-FPM installed and enabled if Apache + PHP-FPM remains the runtime: verified
* Composer installed: verified
* PostgreSQL installed and reachable locally: verified
* Redis installed and reachable locally: verified
* Node.js and npm available for builds when needed: verified

## Required PHP Extensions

Verify:

* `pgsql`: verified
* `pdo_pgsql`: verified
* `redis`: verified
* `mbstring`: verified
* `xml`: verified
* `curl`: verified
* `zip`: verified
* `bcmath`: verified
* `intl`: verified
* `fileinfo`: verified

## Apache / Web Requirements

Verify:

* virtual host strategy: verified
* rewrite support
* SSL plan
* deploy user permissions: verified for `/var/www/platform`
* writable Laravel directories: validated after adjusting `storage/` and `bootstrap/cache/` for the web server user

## Deployment Structure

Verify or create:

* application root path: verified at `/var/www/platform`
* release-based deploy path: verified
* shared writable storage strategy: partially validated, still needs to be formalized for future releases
* `.env` handling strategy: shared `.env` symlink validated

## Operations Readiness

Verify:

* queue worker strategy
* cron/scheduler strategy
* backup expectations
* firewall exposure
* log file locations
* real production environment values and secrets
* limited sudoers rule for repeatable staging deploy service reloads

## Current Findings

Remote inspection results:

* host: `platform-prod-01`
* OS: Ubuntu 24.04.4 LTS
* deploy user: `deploy`
* current web root exists at `/var/www/html`
* `/var/www` and `/var/www/html` are currently root-owned
* application deploy root exists at `/var/www/platform`
* application deploy root is owned by `deploy:deploy`
* first release cloned at `/var/www/platform/releases/20260408224400`
* `current` symlink points to that release
* shared server environment file exists at `/var/www/platform/shared/.env`
* current release `.env` now symlinks to the shared environment file
* Node.js version: `v22.22.2`
* npm version: `10.9.7`
* Composer install completed in the current release
* Laravel validation bootstrap completed with `php artisan about`
* Apache module support needed for Laravel is present: `rewrite`, `proxy_fcgi`, `setenvif`, and `headers`
* Apache vhost is enabled through `platform.conf`
* `000-default.conf` has been disabled
* frontend assets build successfully in the current release
* PostgreSQL role `platform_app` exists
* PostgreSQL database `platform_app` exists
* live `php artisan migrate --force` completed successfully
* `php artisan migrate:status` confirms all current migrations are applied
* local HTTP validation returns `200 OK`
* first repo-level deploy helper scripts now exist for staging automation

## Related

* [Deployment Workflow](deployment-workflow.md)
* [Phase 0 Deployment And Environment Checks](phase-0-deployment-and-environment-checks.md)
* [Phase 0 Index](../07-planning/phases/phase-0/Phase 0 Index.md)

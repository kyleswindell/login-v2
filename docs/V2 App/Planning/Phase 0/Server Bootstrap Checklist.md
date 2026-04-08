# Server Bootstrap Checklist

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

* virtual host strategy
* rewrite support
* SSL plan
* deploy user permissions: verified for `/var/www/login-v2`
* writable Laravel directories: still needs final runtime alignment

## Deployment Structure

Verify or create:

* application root path: verified at `/var/www/login-v2`
* release-based deploy path: verified
* shared writable storage strategy
* `.env` handling strategy: temporary validation only so far

## Operations Readiness

Verify:

* queue worker strategy
* cron/scheduler strategy
* backup expectations
* firewall exposure
* log file locations
* real production environment values and secrets

## Current Findings

Remote inspection results:

* host: `platform-prod-01`
* OS: Ubuntu 24.04.4 LTS
* deploy user: `deploy`
* current web root exists at `/var/www/html`
* `/var/www` and `/var/www/html` are currently root-owned
* application deploy root exists at `/var/www/login-v2`
* `/var/www/login-v2` is owned by `deploy:deploy`
* first release cloned at `/var/www/login-v2/releases/20260408224400`
* `current` symlink points to that release
* Node.js version: `v18.19.1`
* npm version: `9.2.0`
* Composer install completed in the current release
* Laravel validation bootstrap completed with `php artisan about`

## Related

* [[V2 App/Planning/Phase 0/Phase 0 Index]] | [Phase 0 Index](Phase%200%20Index.md)
* [[V2 App/Planning/Phase 0/Phase 0 - Deployment And Environment Setup]] | [Phase 0 - Deployment And Environment Setup](Phase%200%20-%20Deployment%20And%20Environment%20Setup.md)
* [[V2 App/Planning/Phase 0/Deployment Workflow]] | [Deployment Workflow](Deployment%20Workflow.md)

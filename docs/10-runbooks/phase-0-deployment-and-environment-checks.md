# Phase 0 Deployment And Environment Checks

This document defines the canonical scope and intent for Phase 0 Deployment And Environment Checks.

## Purpose

Capture Phase 0 operational procedures and verified environment state checks.

## Preferred Deployment Flow

- local repository is the working copy
- GitHub private repository is the remote source of truth
- DigitalOcean server pulls from Git for deployment

## Verified Current State (Phase 0 Validation)

- GitHub remote configured and `main` pushed
- WSL SSH connectivity validated for GitHub and `platform-prod-wsl`
- remote host confirmed as `platform-prod-01`
- Ubuntu, Apache, PHP 8.3, PHP-FPM, Composer, PostgreSQL 16, Redis 7, Node.js, npm verified
- release-based deploy root validated at `/var/www/platform`
- release + shared directory structure present
- first release cloned and `current` symlink set
- shared `.env` symlink strategy validated
- `APP_KEY` generated
- `php artisan about` runs from current release
- Apache serves Laravel vhost from `/var/www/platform/current/public`
- frontend assets build in current release
- `platform_app` PostgreSQL role and database created
- Laravel migrations validated against live database
- local HTTP validation returns `200 OK`

## Immediate Operational Gaps

- replace temporary staging environment values with final secrets/endpoints
- decide whether server-side Node builds remain in long-term deployment flow
- formalize writable-path handling as a repeatable deploy step
- plan SSL/domain and Apache hardening follow-up

## Related

- [Server Bootstrap](server-bootstrap.md)
- [Deployment Workflow](deployment-workflow.md)
- [Phase 0 - Deployment And Environment Setup](../07-planning/phases/phase-0/Phase 0 - Deployment And Environment Setup.md)

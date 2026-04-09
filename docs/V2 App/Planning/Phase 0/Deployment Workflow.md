# Deployment Workflow

## Purpose

Capture the intended first deployment workflow from local development to GitHub to the DigitalOcean server.

## Current Preferred Flow

```text
Local repo -> GitHub private remote -> DigitalOcean server pull/deploy
```

## Recommended Server Strategy

Prefer the server as a deployment target, not as the source of truth.

Recommended future deploy shape:

```text
/var/www/login-v2/releases/<release-id>
/var/www/login-v2/current
```

This can be simplified initially if needed, but release-based deploys are the preferred long-term direction.

## Current Server Finding

The current server already has:

* `/var/www`
* `/var/www/html`

The current server also now has:

* `/var/www/login-v2`
* `/var/www/login-v2/releases/20260408224400`
* `/var/www/login-v2/current`

The release-based deploy path has been prepared for the `deploy` user, and Apache has been aligned to the Laravel app for validation.

## First Deployment Goal

Before deploying a large app, prove that the server can:

* pull the repo
* install Composer dependencies
* read environment configuration
* run Laravel commands successfully
* serve the application through the intended runtime

Current verified progress:

* the server can authenticate to GitHub with a repo deploy key
* the private repo has been cloned into the first release
* the `current` symlink exists
* the server release currently points to commit `0432839` on `main`
* Composer dependencies install successfully inside the release
* `.env` can be created and an application key can be generated
* `php artisan about` succeeds from the server release
* a shared server `.env` has been established under `/var/www/login-v2/shared/.env`
* the current release now reads `.env` through a symlink
* the Apache vhost is enabled and points to `/var/www/login-v2/current/public`
* frontend assets build successfully with the upgraded Node runtime
* local HTTP validation returns `200 OK`

## Validated Simple Bootstrap

The current release has now passed a simple validation bootstrap:

1. clone repo into a timestamped release directory
2. point `current` at that release
3. run `composer install --no-interaction --prefer-dist`
4. create `.env` from `.env.example` for validation if missing
5. run `php artisan key:generate --force`
6. run `php artisan about`
7. establish a shared `.env` and symlink the release to it
8. build frontend assets with `npm ci && npm run build`
9. enable the Apache vhost
10. validate with `curl -I http://127.0.0.1`

This proves the release layout, GitHub deploy key, PHP runtime, Composer, Node/Vite build, Apache/PHP-FPM routing, and Laravel bootstrap are working together on the server.

## Immediate Next Step

The next server step should stay focused on deployment readiness, not feature rollout:

* formalize storage/link and writable directory handling for each new release
* replace temporary staging `.env` values with real deployment configuration
* decide whether asset builds happen on the server or in CI/local before deploy
* decide when to add SSL, domain routing, and harder production Apache settings

## Documentation Rule

As deployment steps are validated, this note should be updated immediately so the deployment path becomes a repeatable runbook rather than tribal knowledge.

## Related

* [[V2 App/Planning/Phase 0/Phase 0 Index]] | [Phase 0 Index](Phase%200%20Index.md)
* [[V2 App/Planning/Phase 0/Git Remote And Multi-Device Workflow]] | [Git Remote And Multi-Device Workflow](Git%20Remote%20And%20Multi-Device%20Workflow.md)
* [[V2 App/Planning/Phase 0/Server Bootstrap Checklist]] | [Server Bootstrap Checklist](Server%20Bootstrap%20Checklist.md)

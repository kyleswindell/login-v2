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

The release-based deploy path has been prepared for the `deploy` user. Apache/vhost routing still needs to be aligned to the Laravel app before the app can be served.

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

## Validated Simple Bootstrap

The current release has now passed a simple validation bootstrap:

1. clone repo into a timestamped release directory
2. point `current` at that release
3. run `composer install --no-interaction --prefer-dist`
4. create `.env` from `.env.example` for validation if missing
5. run `php artisan key:generate --force`
6. run `php artisan about`

This proves the release layout, GitHub deploy key, PHP runtime, Composer, and Laravel bootstrap are working together on the server.

## Immediate Next Step

The next server step should stay focused on deployment readiness, not feature rollout:

* define the real server `.env` strategy under `shared`
* align Apache document root or vhost to Laravel's `public/`
* review storage/link and writable directory handling
* decide whether asset builds happen on the server or in CI/local before deploy

## Documentation Rule

As deployment steps are validated, this note should be updated immediately so the deployment path becomes a repeatable runbook rather than tribal knowledge.

## Related

* [[V2 App/Planning/Phase 0/Phase 0 Index]] | [Phase 0 Index](Phase%200%20Index.md)
* [[V2 App/Planning/Phase 0/Git Remote And Multi-Device Workflow]] | [Git Remote And Multi-Device Workflow](Git%20Remote%20And%20Multi-Device%20Workflow.md)
* [[V2 App/Planning/Phase 0/Server Bootstrap Checklist]] | [Server Bootstrap Checklist](Server%20Bootstrap%20Checklist.md)

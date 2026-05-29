# Deployment Workflow

This document defines the canonical scope and intent for Deployment Workflow.

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
/var/www/platform/releases/<release-id>
/var/www/platform/current
```

This can be simplified initially if needed, but release-based deploys are the preferred long-term direction.

## Current Server Finding

The current server already has:

* `/var/www`
* `/var/www/html`

The current server also now has:

* `/var/www/platform`
* `/var/www/platform/releases/20260408224400`
* `/var/www/platform/current`

The release-based deploy path has been prepared for the `deploy` user, Apache has been aligned to the Laravel app, and the runtime path has been normalized to `/var/www/platform`.

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
* a shared server `.env` has been established under `/var/www/platform/shared/.env`
* the current release now reads `.env` through a symlink
* the Apache vhost is enabled and points to `/var/www/platform/current/public`
* frontend assets build successfully with the upgraded Node runtime
* the live PostgreSQL role and database use `platform_app`
* `php artisan migrate --force` succeeds against the live server database
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

## Current Staging Helper Scripts

The repo now includes a first repeatable staging deploy pair:

* server script: `scripts/server/deploy-staging.sh`
* local helper: `scripts/deploy-staging-remote.sh`

The server script currently runs the in-place staging deploy workflow inside `/var/www/platform/current`.

The local helper currently shells into `platform-prod-wsl` and executes that server script remotely.

Canonical Windows-side invocation:

```powershell
wsl -d Ubuntu -- bash -lc 'cd "/mnt/c/Users/kswin/Desktop/Work 2023/8. Login V2" && TARGET_BRANCH=main bash scripts/deploy-staging-remote.sh'
```

This is the current pragmatic automation layer while the app is still iterating quickly on staging.

The staging helper now also supports previewing a non-main branch by passing `TARGET_BRANCH=<branch>` before invoking the helper. This supports manual visual review on staging before a batch or phase is promoted to `main`.

## Current Automation Limitation

The deploy script can complete all application-level steps as `deploy`, but service reloads still depend on the server privilege model.

Recommended next improvement:

* add a narrow passwordless sudoers rule for `deploy` covering only:
  * `systemctl reload php8.3-fpm`
  * `systemctl reload apache2`

That will reduce the staging deploy workflow to a single command without granting broad root access.

This limited sudoers rule has now been applied on staging, so the current helper flow can complete as a single-command deploy.

## Current Visual Review Direction

When rendered UI review is needed before a batch or phase is closed out, the preferred near-term flow is:

1. review-clean batch branch is committed and pushed
2. staging temporarily deploys that branch via `TARGET_BRANCH=<branch>`
3. manual QA or visual review is completed on staging
4. approved work is promoted to `main`
5. staging is restored to `main`
6. close-out updates docs and final status

This is safer than merging unreviewed work into `main` only to make the staging URL render the changes.

## Future Automation Direction

The current SSH helper is the right near-term staging tool, but the preferred future direction is to move deployment triggering into GitHub-driven automation.

Recommended future shape:

```text
GitHub push/merge -> GitHub Actions deploy job -> server deploy script
```

Why this is the preferred next layer:

* collaborators can work through GitHub without direct server SSH access
* deployment access can be managed through GitHub branch, review, and merge policy
* server deploy behavior stays constrained to the approved deploy script
* deployment history and failures can be surfaced later inside the app without exposing arbitrary shell access

The app may still gain a deployment visibility page later, but the actual deploy trigger should prefer GitHub Actions over an in-app shell execution model.

## Documentation Rule

As deployment steps are validated, this note should be updated immediately so the deployment path becomes a repeatable runbook rather than tribal knowledge.

## Related

* [Git Remote And Multi-Device Workflow](git-remote-and-multi-device-workflow.md)
* [Server Bootstrap](server-bootstrap.md)
* [Phase 0 Index](../07-planning/phases/phase-0/Phase 0 Index.md)

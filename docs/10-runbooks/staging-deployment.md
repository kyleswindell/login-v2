# Staging Deployment

This document defines the canonical scope and intent for Staging Deployment.

## Purpose

Document the current repeatable staging deployment workflow for `staging.parasolutions.com`.

## Current Deployment Shape

The current staging runtime is:

* app root: `/var/www/platform/current`
* host: `platform-prod`
* public URL: `https://staging.parasolutions.com`

## Preferred Commands

### From your local machine

Canonical local invocation from Windows PowerShell:

```powershell
wsl -d Ubuntu -- bash -lc 'cd "/mnt/c/Users/kswin/Desktop/Work 2023/8. Login V2" && TARGET_BRANCH=main bash scripts/deploy-staging-remote.sh'
```

Use this as the default agent/operator deploy path when working from Windows and the repo lives on the Windows filesystem.

Assumptions:

* WSL distro: `Ubuntu`
* the repo is available at `/mnt/c/Users/kswin/Desktop/Work 2023/8. Login V2`
* the SSH alias `platform-prod-wsl` is configured inside the Ubuntu environment
* Docker is not required for the deploy helper itself, but may still be required separately for local verification

For a review branch instead of `main`:

```powershell
wsl -d Ubuntu -- bash -lc 'cd "/mnt/c/Users/kswin/Desktop/Work 2023/8. Login V2" && TARGET_BRANCH=feature/[batch-or-review-branch] bash scripts/deploy-staging-remote.sh'
```

Equivalent command once already inside Ubuntu:

Use the local helper:

```bash
bash scripts/deploy-staging-remote.sh
```

This connects to `platform-prod-wsl` and runs the server deploy script in the current release.

To deploy a review branch for staging-only visual QA before close-out:

```bash
TARGET_BRANCH=feature/[batch-or-review-branch] bash scripts/deploy-staging-remote.sh
```

After review is complete, restore staging to `main` unless the reviewed branch is being promoted immediately:

```bash
TARGET_BRANCH=main bash scripts/deploy-staging-remote.sh
```

### Directly on the server

Use the server script:

```bash
cd /var/www/platform/current
bash scripts/server/deploy-staging.sh
```

## What The Server Script Does

The current server deploy script performs:

1. `git fetch origin <target-branch>`
2. `git checkout <target-branch>`
3. `git reset --hard origin/<target-branch>`
4. `composer install --no-interaction --prefer-dist --optimize-autoloader`
5. `php artisan filament:assets`, when Filament is installed
6. `npm ci` (falls back to `npm install` if no lockfile exists)
7. `npm run build`
8. `php artisan config:clear`
9. `php artisan migrate --force`
10. `php artisan optimize:clear`
11. attempts `sudo -n systemctl reload php8.3-fpm`
12. attempts `sudo -n systemctl reload apache2`

Default target branch:

* `main`

Override mechanism:

* set `TARGET_BRANCH` when calling the local helper or server script

The deploy script now checks out and hard-resets to the target branch instead of using `git pull origin <branch>`. This matters for review branches because `git pull origin feature/x` while currently on `main` would merge the review branch into the server's local `main`, which is not the desired preview behavior.

Realtime note:

* after Reverb is enabled on staging, this deploy flow also needs the queue worker and Reverb process restarted
* see [Realtime Notifications And Reverb](realtime-notifications-and-reverb.md)

The script is intentionally honest about the current privilege model:

* if passwordless sudo is not configured for the `deploy` user, the script prints a message and skips the service reload step instead of hanging for a password prompt

Filament note:

* staging PHP must have the `intl` extension enabled before Composer can install the current Filament stack
* generated Filament assets are deployment artifacts and are published by the deploy script instead of being committed to the repo

## Current Manual Fallback

If the deploy script reports skipped reloads, run:

```bash
sudo systemctl reload php8.3-fpm
sudo systemctl reload apache2
```

## Storage And Log Permissions

Laravel must be able to write to `storage/` and `bootstrap/cache/` as the PHP-FPM user.

If the app reports that `storage/logs/laravel.log` cannot be opened in append mode, repair ownership and permissions from the server:

```bash
cd /var/www/platform/current
sudo chown -R deploy:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 2775 {} +
sudo find storage bootstrap/cache -type f -exec chmod 664 {} +
sudo systemctl reload php8.3-fpm
```

The intended staging ownership model is:

* owner: `deploy`
* group: `www-data`
* directories: group-writable with setgid
* files: group-writable

## Recommended Limited Sudoers Rule

For smoother staging deploys, add a narrow sudoers rule for the `deploy` user rather than broad passwordless sudo.

Recommended scope:

* `/usr/bin/systemctl reload php8.3-fpm`
* `/usr/bin/systemctl reload apache2`

Example sudoers entry:

```text
deploy ALL=NOPASSWD: /usr/bin/systemctl reload php8.3-fpm, /usr/bin/systemctl reload apache2
```

This should be added with `visudo` and reviewed carefully before use.

## Notes

This is the current in-place staging deploy workflow.

## Visual Review Before Close-Out

Recommended workflow when a batch or phase needs rendered UI review before final close-out:

1. complete `/phase-batch-implementation`
2. run `/phase-batch-review`
3. if review is clean, commit and push the review branch without merging to `main`
4. deploy that branch to staging with `TARGET_BRANCH=<review-branch> bash scripts/deploy-staging-remote.sh`
5. perform manual visual review on `https://staging.parasolutions.com`
6. if rejected, fix on the same review branch and redeploy that branch
7. if approved, merge or promote the approved branch into `main`
8. redeploy `main` to staging
9. run `/phase-close-out`

Key constraint:

* staging is a single shared environment, so only one non-main review branch should own staging at a time
* advisory scope claims do not override this; staging review ownership is still single-branch and must be coordinated explicitly

Recommended naming:

* use a branch that makes the review target obvious, for example `review/phase-2-batch-11` or the existing feature branch if it already has narrow scope

Longer term, the preferred direction is still:

* release-based deploy automation
* optional GitHub Actions or another CI/CD trigger
* tighter deploy verification and rollback flow

## Related

* [Runbook Index](index.md)
* [Deployment Workflow](deployment-workflow.md)
* [Server Bootstrap Checklist](server-bootstrap.md)

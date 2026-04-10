# Staging Deployment

## Purpose

Document the current repeatable staging deployment workflow for `staging.parasolutions.com`.

## Current Deployment Shape

The current staging runtime is:

* app root: `/var/www/platform/current`
* host: `platform-prod`
* public URL: `https://staging.parasolutions.com`

## Preferred Commands

### From your local machine

Use the local helper:

```bash
bash scripts/deploy-staging-remote.sh
```

This connects to `platform-prod-wsl` and runs the server deploy script in the current release.

### Directly on the server

Use the server script:

```bash
cd /var/www/platform/current
bash scripts/server/deploy-staging.sh
```

## What The Server Script Does

The current server deploy script performs:

1. `git pull origin main`
2. `composer install --no-interaction --prefer-dist --optimize-autoloader`
3. `npm run build`
4. `php artisan config:clear`
5. `php artisan migrate --force`
6. `php artisan optimize:clear`
7. attempts `sudo -n systemctl reload php8.3-fpm`
8. attempts `sudo -n systemctl reload apache2`

Realtime note:

* after Reverb is enabled on staging, this deploy flow also needs the queue worker and Reverb process restarted
* see [[V2 App/Runbooks/Realtime Notifications And Reverb]] | [Realtime Notifications And Reverb](Realtime%20Notifications%20And%20Reverb.md)

The script is intentionally honest about the current privilege model:

* if passwordless sudo is not configured for the `deploy` user, the script prints a message and skips the service reload step instead of hanging for a password prompt

## Current Manual Fallback

If the deploy script reports skipped reloads, run:

```bash
sudo systemctl reload php8.3-fpm
sudo systemctl reload apache2
```

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

Longer term, the preferred direction is still:

* release-based deploy automation
* optional GitHub Actions or another CI/CD trigger
* tighter deploy verification and rollback flow

## Related

* [[V2 App/Runbooks/Runbook Index]] | [Runbook Index](Runbook%20Index.md)
* [[V2 App/Planning/Phase 0/Deployment Workflow]] | [Deployment Workflow](../Planning/Phase%200/Deployment%20Workflow.md)
* [[V2 App/Planning/Phase 0/Server Bootstrap Checklist]] | [Server Bootstrap Checklist](../Planning/Phase%200/Server%20Bootstrap%20Checklist.md)

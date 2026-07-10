<!--
DOC-META
title: Server Bootstrap
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/server-bootstrap.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines application release-layout bootstrap on an already provisioned and readiness-validated Login 2.0 server.
-->

# Server Bootstrap

Parent: [Runbook Index](index.md)

## Purpose

Create the Login 2.0 application release layout on a provisioned server that already passes server readiness.

This runbook does not install the operating system, Apache, PHP, PostgreSQL, Redis, Composer, Node.js, or firewall policy.

## Prerequisites

- [Server Readiness](server-readiness.md) passes
- authorized deploy user
- repository deploy key configured
- PostgreSQL role and database approved
- shared environment values available through an approved secret channel
- Apache virtual host configuration prepared
- backup expectations understood before persistent data is created

## Variables

Set:

    APP_ROOT=/var/www/platform
    RELEASE_ID=$(date -u +%Y%m%d%H%M%S)
    RELEASE_PATH="$APP_ROOT/releases/$RELEASE_ID"
    REPOSITORY=git@github.com:kyleswindell/login-v2.git

Confirm values before continuing.

## Create Layout

Run as the authorized operator:

    sudo mkdir -p "$APP_ROOT/releases" "$APP_ROOT/shared"
    sudo chown -R deploy:deploy "$APP_ROOT"

Do not change ownership of unrelated `/var/www` paths.

## Clone First Release

Run as the deploy user:

    git clone "$REPOSITORY" "$RELEASE_PATH"
    cd "$RELEASE_PATH"
    git rev-parse HEAD

Record the release ID and commit.

## Shared Environment

Create the shared environment file through the approved secret process:

    "$APP_ROOT/shared/.env"

Set restrictive permissions:

    chmod 640 "$APP_ROOT/shared/.env"

Link it into the release:

    ln -sfn "$APP_ROOT/shared/.env" "$RELEASE_PATH/.env"

Do not copy secret values into documentation or issue comments.

## Dependencies

From the release:

    composer install --no-interaction --prefer-dist --optimize-autoloader
    npm ci
    npm run build

If no lockfile exists, stop and resolve dependency reproducibility before treating the bootstrap as complete.

## Laravel Preparation

Run:

    php artisan about
    php artisan optimize:clear
    php artisan storage:link

Confirm application key and required environment values exist without printing secrets.

## Writable Paths

Run:

    sudo chown -R deploy:www-data storage bootstrap/cache
    sudo find storage bootstrap/cache -type d -exec chmod 2775 {} +
    sudo find storage bootstrap/cache -type f -exec chmod 664 {} +

Do not grant world-writable permissions.

## Database

Before first migration:

- confirm the target database
- confirm the environment
- confirm backup or restore expectations
- inspect pending migrations

Run:

    php artisan migrate:status
    php artisan migrate --force

Stop on migration failure. Do not retry blindly.

## Activate Release

Create or update the current symlink:

    ln -sfn "$RELEASE_PATH" "$APP_ROOT/current"

Confirm:

    readlink -f "$APP_ROOT/current"

## Apache

Enable the approved virtual host and validate:

    sudo apache2ctl configtest
    sudo systemctl reload apache2
    curl -I http://127.0.0.1

Do not improvise a new production virtual host in this procedure.

## Services

Install and start approved queue and Reverb units only when their templates and environment are ready.

Use:

- [Realtime Notifications And Reverb](realtime-notifications-and-reverb.md)

## Verification

Run:

    cd "$APP_ROOT/current"
    php artisan about
    php artisan migrate:status
    curl -I http://127.0.0.1

For HTTPS staging:

    php artisan platform:security-runtime-check --target=staging --url=https://staging.parasolutions.com

## Failure Handling

Before activation, remove a failed new release only after preserving logs.

After activation:

- restore the previous `current` symlink when code rollback is safe
- do not assume database rollback is safe
- stop and escalate when migrations changed incompatible schema
- preserve the failed release for diagnosis until evidence is collected

## Completion Criteria

Bootstrap is complete when:

- release layout exists
- shared environment is linked
- dependencies install
- assets build
- writable paths are correct
- migrations pass
- current symlink resolves
- Apache serves the application
- required services run
- security verification passes for HTTPS staging

## Related

- [Server Readiness](server-readiness.md)
- [Staging Deployment](staging-deployment.md)
- [Realtime Notifications And Reverb](realtime-notifications-and-reverb.md)

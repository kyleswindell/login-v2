<!--
DOC-META
title: Staging Deployment
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/staging-deployment.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines authorized branch deployment, verification, restoration, and limited code rollback for the shared staging environment.
-->

# Staging Deployment

Parent: [Runbook Index](index.md)

## Purpose

Deploy an authorized branch to `https://staging.parasolutions.com`, verify the result, and restore staging ownership afterward.

## Do Not Use For Production

This procedure is staging-only.

## Current Environment

- application root: `/var/www/platform/current`
- public URL: `https://staging.parasolutions.com`
- remote helper: `scripts/deploy-staging-remote.sh`
- server helper: `scripts/server/deploy-staging.sh`
- shared staging owner: one branch at a time

## Prerequisites

- authorized deploy operator
- target branch committed and pushed
- required local tests pass
- staging ownership is available
- target branch exists on GitHub
- current staging branch and commit are recorded
- migration impact is reviewed
- code rollback compatibility is understood
- no server-side uncommitted edits exist

Set in WSL:

    LOGIN2_REPO_ROOT=<repository path visible to WSL>
    TARGET_BRANCH=<branch>

## Pre-Deployment Checks

From the local repository:

    git status --short --branch
    git fetch origin
    git rev-parse "origin/$TARGET_BRANCH"

Record:

- target branch
- target SHA
- current staging branch
- current staging SHA
- issue
- operator
- time

Stop if the working tree or target branch is not understood.

## Deploy From WSL

Run:

    cd "$LOGIN2_REPO_ROOT"
    TARGET_BRANCH="$TARGET_BRANCH" bash scripts/deploy-staging-remote.sh

## Deploy From Windows PowerShell

Use one logical line:

    wsl -d Ubuntu -- bash -lc 'cd "$LOGIN2_REPO_ROOT" && TARGET_BRANCH="$TARGET_BRANCH" bash scripts/deploy-staging-remote.sh'

The variables must be defined in the invoked WSL environment.

## Direct Server Invocation

On the server:

    cd /var/www/platform/current
    TARGET_BRANCH="$TARGET_BRANCH" bash scripts/server/deploy-staging.sh

## Expected Server Actions

The current script should:

1. fetch the target branch
2. check out the target branch
3. hard-reset to the remote target
4. install Composer dependencies
5. install npm dependencies
6. build assets
7. clear configuration
8. run migrations
9. clear optimized caches
10. reload PHP-FPM when permitted
11. reload Apache when permitted

Because the script uses a hard reset, the server working tree must contain no manual changes.

## Long-Lived Services

After deployment, restart:

    sudo systemctl restart platform-reverb
    sudo systemctl restart platform-queue-worker

Reload:

    sudo systemctl reload php8.3-fpm
    sudo systemctl reload apache2

Use only the approved limited sudo scope.

## Verification

On the server:

    cd /var/www/platform/current
    git rev-parse HEAD
    git branch --show-current
    php artisan about
    php artisan migrate:status
    php artisan platform:security-runtime-check --target=staging --url=https://staging.parasolutions.com
    sudo systemctl status platform-reverb --no-pager
    sudo systemctl status platform-queue-worker --no-pager
    curl -I https://staging.parasolutions.com

Verify the deployed SHA matches the expected target.

Perform required browser and manual review.

## Review-Branch Deployment

For a review branch:

- declare staging ownership
- deploy the review branch
- perform review
- apply fixes to the same branch
- redeploy as needed
- merge only after approval
- restore staging to `main`

## Restore Staging To Main

Run:

    cd "$LOGIN2_REPO_ROOT"
    TARGET_BRANCH=main bash scripts/deploy-staging-remote.sh

Verify the deployed branch and SHA afterward.

## Code Rollback

Before deployment, preserve the prior staging SHA.

When a code rollback is required and the database remains compatible:

1. create a temporary remote rollback branch at the known-good SHA
2. deploy that branch through the normal helper
3. verify application and services
4. create an issue for the failed deployment
5. restore normal staging after correction

Example:

    git branch "rollback/staging-$(date -u +%Y%m%d%H%M%S)" <known-good-sha>
    git push origin <rollback-branch>
    TARGET_BRANCH=<rollback-branch> bash scripts/deploy-staging-remote.sh

Do not use code rollback when forward migrations make the old code incompatible.

## Database Limitation

This runbook does not provide general database rollback or restore.

When a migration fails or produces incompatible schema:

- stop
- preserve logs
- do not rerun blindly
- do not execute ad hoc down migrations
- escalate to the database owner
- use an approved backup and restore procedure when available

## Permission Repair

When Laravel cannot write to `storage/` or `bootstrap/cache/`:

    cd /var/www/platform/current
    sudo chown -R deploy:www-data storage bootstrap/cache
    sudo find storage bootstrap/cache -type d -exec chmod 2775 {} +
    sudo find storage bootstrap/cache -type f -exec chmod 664 {} +
    sudo systemctl reload php8.3-fpm

Do not use world-writable permissions.

## Failure Handling

Collect:

- deploy output
- target branch and SHA
- failed command
- Laravel logs
- service status
- migration status
- HTTP response

Do not continue when:

- migration fails
- security runtime check fails
- service restart fails
- deployed SHA is wrong
- staging ownership is disputed

## Completion Criteria

Deployment is complete when:

- expected branch and SHA are deployed
- dependencies and build pass
- migrations are current
- PHP-FPM, Apache, Reverb, and queue worker are healthy
- security runtime check passes
- required manual review passes
- staging ownership is released or restored to `main`
- issue or review evidence is updated

## Related

- [Deployment](deployment.md)
- [Server Readiness](server-readiness.md)
- [Realtime Notifications And Reverb](realtime-notifications-and-reverb.md)

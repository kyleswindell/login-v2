<!--
DOC-META
title: Scheduler Operations
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/scheduler-operations.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines Laravel scheduler installation, verification, diagnosis, and recovery for active server environments.
-->

# Scheduler Operations

Parent: [Runbook Index](index.md)

## Purpose

Configure and verify Laravel scheduler execution once per minute.

## Prerequisites

- authorized server access
- deploy/runtime user identified
- application current path exists
- PHP CLI works
- application environment is valid
- scheduled tasks are safe for the target environment

## Inspect Scheduled Tasks

From the application root:

    php artisan schedule:list

Review:

- task commands
- frequency
- environment conditions
- overlap prevention
- next run time

## Configure Cron

Edit the deploy/runtime user's crontab:

    crontab -e

Add:

    * * * * * cd /var/www/platform/current && php artisan schedule:run >> /dev/null 2>&1

Use the stable `current` symlink.

Do not place secrets in the crontab.

## Verify Crontab

Run:

    crontab -l

Confirm only one active Laravel scheduler entry exists for the environment.

## Manual Verification

Run:

    cd /var/www/platform/current
    php artisan schedule:run -v

Confirm expected tasks execute or report that they are not due.

## Operational Verification

Verify through applicable:

- application logs
- audit events
- expected database state
- queue jobs
- notifications
- task-specific evidence

Do not treat cron entry presence as proof of execution.

## Failure Handling

If tasks do not run:

1. verify cron service
2. verify deploy-user crontab
3. verify PHP path
4. verify application path
5. run `schedule:list`
6. run `schedule:run -v`
7. inspect Laravel logs
8. inspect system cron logs

On Ubuntu:

    systemctl status cron --no-pager
    journalctl -u cron --since "30 minutes ago" --no-pager

## Duplicate Execution

If tasks execute more than once:

- inspect all user crontabs
- inspect system cron directories
- inspect scheduler containers or timers
- disable duplicate entries
- verify overlap protection

## Stop Conditions

Stop when:

- the target environment is unclear
- scheduled tasks could mutate production unexpectedly
- duplicate schedulers are active
- task failure could cause repeated destructive retries
- the runtime user lacks required permissions

## Completion Criteria

Scheduler operations are healthy when:

- one approved scheduler trigger runs each minute
- `schedule:list` is correct
- manual execution succeeds
- expected task evidence appears
- no duplicate scheduler exists

## Related

- [Deployment](deployment.md)
- [Logging Operations](logging-operations.md)

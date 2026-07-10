<!--
DOC-META
title: Realtime Notifications And Reverb
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/realtime-notifications-and-reverb.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines staging and local setup, restart, verification, diagnosis, and recovery for Laravel Reverb and the notification queue worker.
-->

# Realtime Notifications And Reverb

Parent: [Runbook Index](index.md)

## Purpose

Operate Laravel Reverb and the notification queue worker for local and staging realtime behavior.

## Current Artifacts

- `ops/staging/systemd/platform-reverb.service`
- `ops/staging/systemd/platform-queue-worker.service`
- `ops/staging/apache/platform-reverb-proxy.conf`

## Staging Prerequisites

- HTTPS staging application
- Redis available
- queue configured for Redis
- Reverb environment values configured through approved secrets
- Apache proxy modules enabled
- approved systemd units installed
- authorized service restart

## Required Staging Configuration

Configure without committing secret values:

- `APP_URL=https://staging.parasolutions.com`
- `BROADCAST_CONNECTION=reverb`
- `QUEUE_CONNECTION=redis`
- `CACHE_STORE=redis`
- `REVERB_SERVER_HOST=0.0.0.0`
- `REVERB_SERVER_PORT=8080`
- `REVERB_HOST=staging.parasolutions.com`
- `REVERB_PORT=443`
- `REVERB_SCHEME=https`
- Reverb app ID, key, and secret
- matching Vite Reverb values

`APP_URL` must use HTTPS on staging.

## Install Staging Services

Copy approved systemd units to:

- `/etc/systemd/system/`

Install the approved Apache proxy snippet in the staging virtual host.

Enable required modules when absent:

    sudo a2enmod proxy proxy_http proxy_wstunnel

Validate and reload:

    sudo apache2ctl configtest
    sudo systemctl daemon-reload
    sudo systemctl reload apache2

Enable services:

    sudo systemctl enable --now platform-reverb
    sudo systemctl enable --now platform-queue-worker

## Restart After Deployment

Run:

    sudo systemctl restart platform-reverb
    sudo systemctl restart platform-queue-worker
    sudo systemctl reload apache2

## Staging Verification

Run:

    php artisan channel:list
    php artisan queue:work --once
    sudo systemctl status platform-reverb --no-pager
    sudo systemctl status platform-queue-worker --no-pager
    journalctl -u platform-reverb --since "15 minutes ago" --no-pager
    journalctl -u platform-queue-worker --since "15 minutes ago" --no-pager
    curl -I https://staging.parasolutions.com

Use an approved staging smoke-test user rather than a personal hard-coded email.

Verify in the browser:

- unread count updates
- preview updates
- inbox updates
- a newly persisted notification produces exactly one toast per open recipient tab
- the initiating command response acknowledges creation without injecting a second persistent notification presentation
- read and dismiss sync across tabs

When using the Dashboard test-notification action, also verify:

- exactly one `notifications` row is created
- the JSON command response is `201 Created` and contains only `created` plus `notification_id`
- the current tab receives one realtime toast and one unread-count increment
- a second open tab receives the same persisted notification once
- repeated Livewire navigation does not multiply toast delivery

If Reverb is unavailable, the command may still create the database row without showing a live toast. Reload the header or inbox to verify database-backed recovery instead of retrying the state-changing request automatically.

## Local Setup

Run:

    docker compose up -d reverb queue
    docker compose exec app php artisan local:ready

For LAN review:

    docker compose exec app php artisan local:ready --app-url=http://192.168.50.10:8000 --vite-url=http://192.168.50.10:5173

## Failure Diagnosis

### Reverb Service

    sudo systemctl status platform-reverb --no-pager
    journalctl -u platform-reverb -n 200 --no-pager

### Queue Worker

For Docker:

    docker compose logs queue --tail=200
    docker compose restart queue
    docker compose exec app php artisan queue:failed

For staging:

    sudo systemctl status platform-queue-worker --no-pager
    journalctl -u platform-queue-worker -n 200 --no-pager
    php artisan queue:failed

### Apache Proxy

    sudo apache2ctl configtest
    sudo apache2ctl -M | grep proxy
    sudo tail -n 200 /var/log/apache2/error.log

### Application

    tail -n 200 storage/logs/laravel.log

Redact sensitive values before retaining evidence.

## Recovery

For transient service failure:

    sudo systemctl restart platform-reverb
    sudo systemctl restart platform-queue-worker

For configuration failure:

- restore the last known-good environment values through the approved secret process
- restore the approved Apache proxy configuration
- reload services
- rerun verification

Do not rotate or disclose Reverb secrets through this runbook.

## Stop Conditions

Stop when:

- the environment is production
- secret values are unavailable through an approved channel
- Apache configuration test fails
- Redis is unavailable
- queue failures indicate application defects
- repeated restarts do not resolve the issue
- notification content exposes sensitive data

## Completion Criteria

Realtime services are healthy when:

- Reverb and queue worker are active
- logs show no recurring fatal errors
- HTTPS and websocket proxying work
- smoke notifications process
- browser state updates without refresh
- failed queue count is understood

## Related

- [Local Browser Review](local-browser-review.md)
- [Staging Deployment](staging-deployment.md)
- [Logging Operations](logging-operations.md)

# Realtime Notifications And Reverb

## Purpose

Document the current staging-first setup for Laravel Reverb, Echo, queue workers, and websocket proxying.

## Current Runtime Shape

The intended staging runtime is:

* app host: `staging.parasolutions.com`
* Reverb internal port: `8080`
* websocket/app endpoint proxied through Apache
* queue worker running continuously on the same server

## Repo Artifacts

Current server templates live here:

* `ops/staging/systemd/platform-reverb.service`
* `ops/staging/systemd/platform-queue-worker.service`
* `ops/staging/apache/platform-reverb-proxy.conf`

## Required Environment

Set these values in `/var/www/platform/shared/.env` for staging:

```env
APP_URL=https://staging.parasolutions.com
BROADCAST_CONNECTION=reverb
QUEUE_CONNECTION=redis
CACHE_STORE=redis
REVERB_SERVER_HOST=0.0.0.0
REVERB_SERVER_PORT=8080
REVERB_SERVER_PATH=
REVERB_HOST=staging.parasolutions.com
REVERB_PORT=443
REVERB_SCHEME=https
REVERB_APP_ID=platform-staging
REVERB_APP_KEY=replace-with-random-key
REVERB_APP_SECRET=replace-with-random-secret
REVERB_SCALING_ENABLED=true
VITE_REVERB_APP_KEY=${REVERB_APP_KEY}
VITE_REVERB_HOST=${REVERB_HOST}
VITE_REVERB_PORT=${REVERB_PORT}
VITE_REVERB_SCHEME=${REVERB_SCHEME}
```

Important:

* `APP_URL` must use `https://` on staging. If this is set to `http://`, notification action links can be generated as insecure URLs from CLI/event contexts and lead to browser security warnings plus `405 Method Not Allowed` after redirects.

## Staging Server Setup

1. Copy the systemd units into `/etc/systemd/system/`
2. Copy the Apache proxy snippet into the staging vhost
3. Enable Apache proxy modules if not already enabled:
   * `proxy`
   * `proxy_http`
   * `proxy_wstunnel`
4. Reload systemd and Apache
5. Enable and start:
   * `platform-reverb.service`
   * `platform-queue-worker.service`

## Deploy Flow Impact

After code deploys, restart the long-lived processes:

```bash
sudo systemctl restart platform-reverb
sudo systemctl restart platform-queue-worker
sudo systemctl reload apache2
```

## Verification

Use these checks on staging:

```bash
php artisan channel:list
php artisan queue:work --once
php artisan tinker --execute="\$u=\App\Models\User::where('email','kyle@parasolutions.com')->first(); \$t=now()->toDateTimeString(); app(\App\Platform\Notifications\NotificationService::class)->sendTo(\$u,'system','Realtime smoke '.$t,'Generated from tinker at '.$t,'info');"
sudo systemctl status platform-reverb
sudo systemctl status platform-queue-worker
curl -I https://staging.parasolutions.com
```

In the browser, verify:

* header unread count updates without refresh
* header preview updates without refresh
* notifications inbox updates without refresh
* a new notification shows a toast
* read/dismiss in one tab syncs to another tab

## Related

* [[V2 App/Runbooks/Staging Deployment]] | [Staging Deployment](Staging%20Deployment.md)
* [[V2 App/Features/Realtime Notifications And Broadcasting]] | [Realtime Notifications And Broadcasting](../Features/Realtime%20Notifications%20And%20Broadcasting.md)

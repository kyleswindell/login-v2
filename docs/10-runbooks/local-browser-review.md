<!--
DOC-META
title: Local Browser Review
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/local-browser-review.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines repeatable local browser-review readiness and troubleshooting for Laravel, Vite, Docker, Reverb, and authenticated review routes.
-->

# Local Browser Review

Parent: [Runbook Index](index.md)

## Purpose

Prepare a reliable local browser-review surface for authenticated Login 2.0 UI and realtime behavior.

## Prerequisites

- local Docker stack running
- host Node.js dependencies installed
- host Vite available
- current local database
- no other process using ports 8000, 5173, or 8080

## Standard Procedure

Start host Vite:

    npm run dev:host

In another terminal:

    docker compose exec app php artisan local:ready

Open:

- `http://localhost:8000/login`

Use the local-only review account documented in [Local Development](local-dev.md).

## What Readiness Verifies

The readiness command should:

- normalize `public/hot`
- verify host Vite through the browser and container paths
- verify Vite authorizes the application origin for browser module scripts
- normalize local Reverb configuration
- verify Reverb TCP reachability
- verify the login route
- create or update the local review user
- assign required local review access
- print review URLs and credentials

## Asset Mode

For host Vite, `public/hot` should contain:

    http://localhost:5173

Do not use `http://0.0.0.0:5173` as the browser asset URL.

## LAN Review

Run:

    docker compose exec app php artisan local:ready --app-url=http://192.168.50.10:8000 --vite-url=http://192.168.50.10:5173

Replace the IP with the current host.

The browser-facing Reverb host must match the application host.

## Docker Vite

Use only for explicit containerized Node testing:

    docker compose --profile docker-vite up -d node
    docker compose exec app php artisan local:ready --vite-check-url=http://node:5173

The Playwright container opens the application through
`http://laravel.test:8000`. Vite must allow that origin for module scripts even
when `public/hot` points to a host or LAN Vite URL.

In Vite development mode, browser websocket traffic uses the Vite `/app`
websocket proxy and Vite forwards it to Reverb. Host Vite defaults the proxy
target to `http://127.0.0.1:8080`; the Docker Vite service uses
`http://reverb:8080`. Production builds continue to use the configured direct
Reverb host and port.

## Realtime Review

Verify:

- unread count updates without refresh
- notification preview updates
- inbox updates
- toast appears
- read or dismiss state synchronizes across tabs

## Built-Asset Fallback

Use built assets only when:

- `npm run build` passes
- application readiness passes
- Vite hot serving remains unavailable after one restart

Restore normal hot-file state afterward with:

    docker compose exec app php artisan local:ready

## Failure Handling

If assets are stale:

1. confirm Vite is running
2. rerun readiness
3. restart Vite once
4. rerun readiness
5. inspect Vite output
6. use built assets temporarily

If CSS loads but JavaScript behavior is absent, inspect the browser console for
blocked `@vite/client` or `resources/js/app.js` requests. A CORS failure means
the current application origin is missing from the Vite development allowlist;
do not diagnose downstream runtime or realtime behavior until module scripts
load successfully.

If Reverb fails:

    docker compose logs reverb --tail=200
    docker compose restart reverb
    docker compose exec app php artisan local:ready

If the runtime remains in `connecting` while Reverb is healthy, restart Vite so
it reloads the websocket proxy configuration, then inspect
`data-notification-realtime-state` on the realtime runtime marker.

If the login route fails:

    docker compose logs app --tail=200
    docker compose exec app php artisan route:list --path=login

## Stop Conditions

Stop when:

- the environment is not local
- the command would alter staging or production
- ports belong to another worktree
- database reset would destroy needed data
- the readiness command changes unexpected production-like values

## Completion Criteria

Browser review is ready when:

- application loads
- Vite assets load
- authenticated review account works
- Reverb connects
- expected interactive behavior is testable

## Related

- [Local Development](local-dev.md)
- [Realtime Notifications And Reverb](realtime-notifications-and-reverb.md)

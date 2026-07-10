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

If Reverb fails:

    docker compose logs reverb --tail=200
    docker compose restart reverb
    docker compose exec app php artisan local:ready

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

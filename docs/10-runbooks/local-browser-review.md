# Local Browser Review Setup

This runbook owns repeatable local browser-review readiness for Laravel, Vite, Docker, and a Windows host browser.

## Standard Command

From the repository root, with the Docker Compose app/services stack running and host Vite started:

```bash
npm run dev:host
```

Then run:

```bash
docker compose exec app php artisan local:ready
```

When using local PHP/npm directly:

```bash
npm run local:ready
```

The readiness command:

- writes `public/hot` as `http://localhost:5173`
- normalizes the local broadcast connection to Reverb and the browser-facing Reverb host from the app URL
- verifies Vite JavaScript and CSS at `http://localhost:5173` when run on the host
- verifies host-run Vite JavaScript and CSS through `http://host.docker.internal:5173` when run inside the Docker app container
- verifies Reverb accepts a TCP connection on port `8080`
- verifies the app login route at `http://localhost:8000/login`
- upserts `test@example.com` / `password`
- assigns the `platform_super_admin` role for protected local review routes
- prints the app URL and credentials

Run it after Docker database resets, local startup, or before authenticated browser review. Do not manually reseed the local user or rewrite `public/hot` unless the command itself is being debugged.

## Vite Mode

Default Windows local review uses host-run Vite, not the Docker `node` service:

```bash
npm run dev:host
docker compose exec app php artisan local:ready
```

The host Vite process binds to `0.0.0.0` so Docker can reach it through `host.docker.internal`, while the browser still loads assets from `http://localhost:5173`.

The Docker `node` service is opt-in under the `docker-vite` profile. Use it only when explicitly testing containerized Node:

```bash
docker compose --profile docker-vite up node
docker compose exec app php artisan local:ready --vite-check-url=http://node:5173
```

Docker Vite enables polling by default for Windows bind mounts. If CSS or JavaScript still appears stale when using the Docker `node` service, restart that service once and rerun `local:ready`; do not keep restarting or cache-busting in a loop.

## Realtime Notifications

Realtime notification testing is part of local review. The Compose stack includes a `reverb` service on port `8080`, and `local:ready` normalizes `.env` to:

```env
BROADCAST_CONNECTION=reverb
REVERB_SERVER_HOST=0.0.0.0
REVERB_SERVER_PORT=8080
```

When the page is loaded at `http://localhost:8000`, the browser connects to `ws://localhost:8080`. When using LAN review, pass the LAN app and Vite URLs to `local:ready` so the browser connects to the LAN Reverb host instead of stale localhost values.

## Asset Mode

For a Windows host browser reviewing the Docker stack, `public/hot` should contain:

```text
http://localhost:5173
```

Do not use `http://0.0.0.0:5173` for the host browser. The readiness command owns this normalization.

## LAN Review

When reviewing through a LAN URL, pass the browser-reachable app and Vite URLs:

```bash
docker compose exec app php artisan local:ready --app-url=http://192.168.50.10:8000 --vite-url=http://192.168.50.10:5173
```

The readiness command uses the app URL host as the browser-facing Reverb host. If the page is loaded at `http://192.168.50.10:8000`, the frontend must connect to `ws://192.168.50.10:8080`, not `ws://localhost:8080`.

Built-asset review is a fallback only when:

- `npm run build` passes
- `php artisan local:ready` confirms the local app is reachable
- Vite hot serving is confirmed broken

If that fallback is needed, record the environment issue once and restore the normal hot-file state with `php artisan local:ready` afterward.

## Troubleshooting Limit

If browser behavior appears stale:

1. Confirm `npm run dev:host` is running.
2. Run `docker compose exec app php artisan local:ready`.
3. If Vite JavaScript or CSS fails, restart the host Vite process once.
4. Run `docker compose exec app php artisan local:ready` again.
5. If Vite is still stale or unreachable, switch to built assets only after `npm run build` passes.

Do not keep restarting, cache-busting, opening fresh tabs, or moving `public/hot` in loops. Treat repeated stale-module behavior as an environment issue and use built assets for review until the tooling issue is fixed.

## Related

- [Local Dev](local-dev.md)
- [Batch Workflow - Work Batch](batch-workflow/work-batch.md)

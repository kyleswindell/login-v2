# Laravel Vite Local Review Baseline

Use this baseline for repositories that combine Laravel, Vite, Docker Compose, and browser review from the host machine.

Recommended baseline:

- Add an idempotent local readiness command such as `php artisan local:ready`.
- Make the command normalize `public/hot` to the host-browser Vite URL, usually `http://localhost:5173`.
- Make the command verify the Laravel app URL, verify the Vite module URL, and upsert a non-production local review user.
- Document built-asset review as a fallback only after the frontend build passes and hot serving is confirmed broken.
- Keep workflow logs focused on final validation and material caveats, not repeated cache-busting, restarts, or temporary hot-file moves.
- Instruct agents to run the readiness command before authenticated browser review instead of rediscovering environment setup.

Default values used by Login App 2.0:

- app URL: `http://localhost:8000`
- Vite URL: `http://localhost:5173`
- local review user: `test@example.com` / `password`

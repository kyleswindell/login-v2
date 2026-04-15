# Console Proof Paths

This document defines the canonical scope and intent for Console Proof Paths.

## Purpose

Describe how transitional `/console/*` proof paths are enabled, disabled, and validated in each environment.

## Current Behavior

- the Filament console panel is registered by `App\Providers\Filament\ConsolePanelProvider`
- direct `/console/*` access is gated by `App\Http\Middleware\EnsureConsoleProofPathsEnabled`
- `CONSOLE_PROOF_PATHS_ENABLED` controls whether direct proof-path access remains available

## Fallback Behavior

When proof paths are disabled:

- `/console/login` redirects to `/login`
- `/console/platform-users*` redirects to `/platform/users`
- `/console/platform-audit-logs*` redirects to `/platform/audit-logs`
- `/console/central-error-logs*` redirects to `/platform/error-logs`
- any other `/console/*` request redirects to `dashboard` for authenticated users or `login` for guests

## Validation Steps

1. Confirm the environment value for `CONSOLE_PROOF_PATHS_ENABLED`.
2. Load the expected `/console/*` route directly.
3. Verify either direct panel access or the documented fallback redirect.
4. Re-check the app-owned route after redirect to confirm the owned surface remains available.

## Related

- [Runbook Index](index.md)
- [Current Repo Structure](../03-architecture/subsystems/current-repo-structure.md)
- [Phase 2 - Implementation Batch 6](../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%206.md)

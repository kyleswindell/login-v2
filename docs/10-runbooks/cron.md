# Cron

This document defines the canonical scope and intent for Cron.

## Purpose

Operational scheduler runbook baseline.

## Current Baseline

Laravel scheduler should run once per minute in each active environment.

## Procedure

1. Configure server cron entry for the deploy/runtime user.
2. Run `php artisan schedule:run` every minute from the active release path.
3. Verify scheduler execution through logs and expected job effects.
4. Include scheduler checks in deployment validation.

## Related

- [Deployment](deployment.md)
- [Server Readiness](server-readiness.md)

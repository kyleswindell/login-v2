# App 2.0 Blueprint Architecture Baseline

This document defines the canonical scope and intent for App 2.0 Blueprint Architecture Baseline.

## Purpose

Capture architecture baseline extracted from initial blueprint planning.

## Locked Direction

- Laravel platform and tenant admin application
- Filament and Livewire for admin panels
- PostgreSQL for central and tenant databases
- Redis for queues and cache
- Apache + PHP-FPM on the production VPS
- one Laravel codebase with isolated tenant databases and roles
- arbitrary tenant admin domains from day one
- Astro + Tailwind for future public website rebuilds

## Domain Model

Platform admin domain:

- `login.parasolutions.com`

Tenant admin domains:

- arbitrary tenant admin domains (for example `login.clientdomain.com`)

## Tenant Resolution Order

1. exact tenant admin domain match
2. optional alias domain match
3. resolve tenant from central platform database
4. initialize tenant database connection
5. boot tenant context

## Related

- [App 2.0 Blueprint](app-2-0-blueprint.md)
- [App 2.0 Blueprint Planning](../07-planning/app-2-0-blueprint-planning.md)

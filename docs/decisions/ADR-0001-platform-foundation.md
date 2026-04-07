# ADR-0001 - Platform Foundation

## Status

Accepted

## Context

Login App 2.0 is being created as a separate application from the current Perfex 1.0 codebase. Perfex 1.0 remains the reference implementation for existing tenant concepts, admin workflows, website sync lessons, and documentation.

The new application needs a cleaner multi-tenant foundation from the beginning.

## Decision

Use the following foundation:

* Laravel for the application framework.
* Filament and Livewire for platform and tenant admin panels.
* PostgreSQL for central and tenant databases.
* Redis for queues and cache.
* Apache + PHP-FPM on the production server.
* One central platform database.
* One separate PostgreSQL database per tenant.
* One PostgreSQL role per tenant.
* Arbitrary tenant admin domains from day one.
* `login.parasolutions.com` as the future platform admin domain.

## Consequences

* Tenant isolation is stronger than the current Perfex 1.0 database routing model.
* Provisioning must manage tenant databases, tenant roles, tenant domains, and tenant storage from the start.
* The tenant resolver and connection manager are core platform services, not optional later additions.
* Deployment and local development need to account for PostgreSQL, Redis, queue workers, and scheduler setup early.
* The production server should be a deployment target, not the canonical development workspace.

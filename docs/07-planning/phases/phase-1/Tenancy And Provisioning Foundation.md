# Tenancy And Provisioning Foundation

This document defines the canonical scope and intent for Tenancy And Provisioning Foundation.

## Purpose

Capture the Phase 1 planning work for landlord/tenant separation, tenant resolution, tenant provisioning, and tenant lifecycle state handling.

## Current Planning Direction

This note should absorb and refine the tenancy-related decisions from the main Phase 1 planning note.

Current direction:

* shared core app first, with later tenantization
* platform-management layer added on top of the internal platform instance
* one separate database per tenant
* domain-based tenant resolution
* controlled provisioning workflow
* fail-closed handling for unknown or inactive tenant contexts

## Recommended Phase 1 Defaults

### Tenancy stance

Phase 1 should not try to implement the full tenantization layer first.

Instead, it should:

* establish the shared core app correctly
* preserve the boundaries needed for later tenantization
* define the tenant model and provisioning direction early enough to avoid bad assumptions

Current recommended baseline:

* one Laravel codebase
* one central platform database
* one separate PostgreSQL database per tenant
* one PostgreSQL role per tenant
* exact-domain tenant resolution first, alias support second

The platform instance should be treated as the first internal consumer of the shared core app, not as a totally separate product from future tenant instances.

### Package direction

`stancl/tenancy` v3 is the current leading recommendation for tenancy orchestration.

Why it fits:

* multi-database tenancy support
* domain-based tenant identification
* tenant database manager support
* better tenancy lifecycle coverage than a fully custom first pass

This should still be treated as a recommended implementation choice to validate, not blind commitment.

### Provisioning baseline

Recommended provisioning model:

* the platform creates and owns the tenant registry record
* the platform provisions the tenant database and role
* the platform applies the tenant template/migrations/seeders
* the platform binds domains and status
* the platform records provisioning progress and failures centrally

### Failure handling baseline

Recommended defaults:

* unknown tenant domains fail closed
* inactive tenants fail closed with a deliberate inactive response
* provisioning failure should not create a half-silent tenant state
* every provisioning step should be logged centrally with correlation support

### Support-access baseline

Platform support access into a tenant context should be treated as a privileged control-plane action, not as an invisible shared login behavior.

That means:

* explicit access grant path
* auditable access event
* tenant-targeted handoff or controlled admin mapping

## Candidate Deliverables

This planning area should likely produce:

* tenant resolution specification
* provisioning state machine or workflow spec
* tenant lifecycle status vocabulary
* database creation/template strategy
* support access boundary rules

## Questions To Resolve

* whether `stancl/tenancy` is adopted as-is for the first implementation pass
* exact provisioning stages and status vocabulary
* what records must exist before tenant boot succeeds
* how platform staff support access is granted into tenant contexts
* what tenant template database process looks like in practice

## Open Questions

Still worth deciding explicitly:

* exact tenant status values such as `provisioning`, `active`, `inactive`, `failed`, `suspended`
* whether tenant aliases are included in Phase 1 or immediately after
* whether database creation is synchronous at first or queued from day one
* how much tenant boot logic is allowed before active-status checks
* what minimal tenant-side seeded data must exist before the tenant app is considered usable

## Related

* [Phase 1 Index](Phase%201%20Index.md)
* [Phase 1 - Platform Foundation Planning](Phase%201%20-%20Platform%20Foundation%20Planning.md)
* [Tenancy Foundation](../../../03-architecture/tenancy.md)
* [Platform And Tenant Application Boundary](../../../03-architecture/platform-boundary.md)
* [App 2.0 Blueprint](../../../03-architecture/app-2-0-blueprint.md)

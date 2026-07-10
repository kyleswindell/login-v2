# Tenancy

This document defines the canonical scope and intent for Tenancy.

Status: Planned (not implemented)

## Model

The planned tenancy model uses a central platform database plus one isolated tenant database per tenant.

## Isolation Contract

- one tenant database per client
- one PostgreSQL role per tenant
- tenant runtime context booted from resolved tenant identity
- tenant-owned application data kept in tenant-local databases

## Central Ownership

The central platform database is intended to own platform control-plane metadata such as tenant identity, domains, provisioning state, and platform operations visibility.

## Tenant Ownership

Each tenant database is intended to own tenant-local application data and tenant-local operational history.

## Tenant Resolution Direction

Tenant admin requests are expected to resolve by domain match in the platform registry, then initialize tenant database context before tenant routes execute.

Unknown or inactive tenant domains should fail closed.

Future tenant registry records must provide the `tenant_workspace` identity used by runtime context resolution. That workspace identity is the boundary for tenant-local users, roles, settings, module state, notifications, audit history, and business records.

The Parasolutions `internal_workspace` identity is not a tenant registry record.

## Related

- [System Overview](system-overview.md)
- [Platform Boundary](platform-boundary.md)
- [Workspace Identity Model](workspace-identity-model.md)
- [Auth Architecture](auth.md)

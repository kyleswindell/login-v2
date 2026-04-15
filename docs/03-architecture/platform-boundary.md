# Platform Boundary

This document defines the canonical scope and intent for Platform Boundary.

## Purpose

Define system-level separation between platform-owned operations and tenant-owned application runtime.

## Runtime Contexts

- `platform` context: shared core usage plus Parasolutions platform-management capabilities
- `tenant` context: shared core usage without cross-tenant platform-management capabilities

## Boundary Model

The boundary is enforced through:

- runtime context resolution
- route and panel separation
- policy and authorization boundaries
- database ownership boundaries

## Ownership

Platform-owned responsibilities include:

- tenant registry and domain registry
- provisioning orchestration and lifecycle control
- platform-visible policy controls
- centralized operational visibility and support tooling

Tenant-owned responsibilities include:

- tenant-local users, roles, settings, and content workflows
- tenant-local business records and tenant-local audit history

## Design Constraint

One codebase does not remove boundaries. It requires explicit context ownership at routing, services, policies, and data layers.

## Related

- [System Overview](system-overview.md)
- [Tenancy](tenancy.md)
- [Core Platform Layer Model](subsystems/core-platform-layer-model.md)

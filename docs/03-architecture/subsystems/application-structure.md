# Application Structure

This document defines the canonical scope and intent for Application Structure.

Status: Planned (not implemented)

## Purpose

Define high-level namespace and folder ownership for platform, tenant, and shared cross-cutting layers.

## Recommended Shape

- Target shape: `app/Platform/` for platform-management orchestration and control-plane behavior
- Target shape: `app/Tenant/` for tenant-local application behavior
- Target shape: `app/Foundation/` or `app/Support/` for shared cross-context infrastructure

## HTTP Boundary Shape

The target HTTP layer should express runtime ownership explicitly:

- platform middleware and route groups/panels
- tenant resolution middleware before tenant routes
- policy boundaries aligned to context ownership

## Model Ownership Direction

Model placement should follow ownership boundaries (platform-owned vs tenant-owned), not convenience grouping, when the planned tenant/shared split is introduced.

## Related

- [Platform Boundary](../platform-boundary.md)
- [Tenancy](../tenancy.md)

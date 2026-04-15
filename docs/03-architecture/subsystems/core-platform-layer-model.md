# Core Platform Layer Model

This document defines the canonical scope and intent for Core Platform Layer Model.

## Purpose

Define how shared core application capabilities and platform-management capabilities coexist in one system.

## Layer Model

- `core app layer`: reusable business capabilities shared across platform and tenant contexts
- `platform-management layer`: Parasolutions-only cross-tenant control-plane capabilities
- `tenantization layer`: runtime and infrastructure capabilities that enforce tenant isolation and boot tenant context

## Design Rule

For each foundational capability, define ownership first:

1. shared core capability
2. platform-management capability
3. tenantization capability

If ownership is unclear, architecture design is incomplete.

## Related

- [System Overview](../system-overview.md)
- [Platform Boundary](../platform-boundary.md)
- [Application Structure](application-structure.md)

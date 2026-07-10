# System Overview

This document defines the canonical scope and intent for System Overview.

## System Model

Login App 2.0 is one Laravel codebase with three target contexts:

- `control_plane` for Parasolutions internal administration, support, tenant registry, provisioning, security, runtime readiness, and module governance
- `internal_workspace` for Parasolutions' own business operations using shared workspace systems
- `tenant_workspace` for client-specific workspace runtime

Platform is the Parasolutions control plane. Platform is not itself a tenant.

Parasolutions may own an `internal_workspace` that behaves like a workspace for business modules. That workspace should use the same shared workspace module model intended for future client tenant workspaces.

## Foundation Direction

Canonical stack definition is owned by:

- [Stack Overview](stack-overview.md)

## Domain And Context Direction

Control-plane administration is owned by Parasolutions. Tenant administration is owned per client workspace and resolved from domain metadata in the central platform database.

Domain resolution is a runtime boundary concern, not a feature-level concern.

## Ownership Boundaries

- shared core capabilities should be reusable across internal workspace and tenant workspace contexts
- platform-management capabilities stay control-plane-only unless explicitly reclassified
- tenant application data stays tenant-local except explicit control-plane metadata and operations data
- Parasolutions internal workspace data should be separated from control-plane data before shared business modules are built

## Related

- [Platform Context Model](platform-context-model.md)
- [Platform Boundary](platform-boundary.md)
- [Tenancy](tenancy.md)
- [Core Platform Layer Model](subsystems/core-platform-layer-model.md)
- [Application Structure](subsystems/application-structure.md)

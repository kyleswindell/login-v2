# System Overview

This document defines the canonical scope and intent for System Overview.

## System Model

Login App 2.0 is one Laravel codebase with two runtime contexts:

- `platform` context for Parasolutions internal operations and platform management
- `tenant` context for client-specific application instances

The platform context is the first internal instance of the shared core app, with platform-only management capabilities layered on top.

## Foundation Direction

Canonical stack definition is owned by:

- [Stack Overview](stack-overview.md)

## Domain And Context Direction

Platform administration is owned by Parasolutions. Tenant administration is owned per client instance and resolved from domain metadata in the central platform database.

Domain resolution is a runtime boundary concern, not a feature-level concern.

## Ownership Boundaries

- shared core capabilities should be reusable across platform and tenant contexts
- platform-management capabilities stay platform-only
- tenant application data stays tenant-local except explicit platform-level metadata and operations data

## Related

- [Platform Boundary](platform-boundary.md)
- [Tenancy](tenancy.md)
- [Core Platform Layer Model](subsystems/core-platform-layer-model.md)
- [Application Structure](subsystems/application-structure.md)

# Auth Architecture

This document defines the canonical scope and intent for Auth Architecture.

## Purpose

Define high-level authentication and authorization boundaries across platform and tenant contexts.

## Context Separation

Auth is context-bound:

- platform identities authenticate in the platform context
- tenant identities authenticate in tenant context
- tenant context is resolved from tenancy boundaries, not inferred only from user role

## Authorization Direction

RBAC is the baseline authorization model:

- permissions are defined centrally
- roles are composed from permissions
- platform and tenant authorization scopes remain separate

## Privileged Platform-To-Tenant Access

Platform-to-tenant access should use an auditable, short-lived handoff/sign-in flow with explicit authorization and logging, rather than implicit shared session behavior.

## Session Boundary Direction

Platform and tenant sessions remain boundary-aware and revocable independently.

## Related

- [Platform Boundary](platform-boundary.md)
- [Tenancy](tenancy.md)
- [Security Standards](../02-standards/security/Security%20Standards.md)

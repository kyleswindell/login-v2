# Auth Architecture

This document defines the canonical scope and intent for Auth Architecture.

## Purpose

Define high-level authentication and authorization boundaries across platform and tenant contexts.

## Context Separation

Auth is context-bound:

- platform identities authenticate in the platform context
- tenant identities authenticate in tenant context
- tenant context is resolved from tenancy boundaries, not inferred only from user role

## External Identity Boundary

External identity providers are authentication sources, not authorization sources:

- provider authentication must be validated before local session issuance
- provider identity does not override tenant boundary, company membership, or local role checks
- external identity resolution should bind to stable provider identity claims rather than to email alone

## MFA Assurance Boundary

MFA assurance is separate from federated sign-in:

- a successful Microsoft or Google login does not by itself prove MFA
- tenant or platform policy may require provider-side MFA evidence before sign-in is accepted
- when provider-side assurance is unavailable or insufficient, local MFA or step-up remains the fallback control
- privileged surfaces and platform-to-tenant handoffs should support explicit step-up requirements

## Enterprise Microsoft Boundary

When tenant policy requires Microsoft work-account sign-in:

- the accepted Microsoft identity boundary should be able to restrict to the intended Microsoft Entra tenant
- personal Microsoft accounts and unrelated Entra tenants should be rejectable by policy
- Microsoft Graph access credentials should remain separable from user sign-in credentials when their blast radius differs

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

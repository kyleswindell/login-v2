---
description: "Use when implementing Laravel module behavior in Login V2, especially multi-tenant auth, policy, permissions, and module delivery from planning contracts."
name: "Laravel Tenancy Module Rules"
applyTo: "app/**,routes/**,config/**,database/**,tests/**"
---
# Laravel Tenancy Module Rules

## Foundation Constraints

- Keep Laravel as integration center and PostgreSQL as source of truth.
- Keep tenant isolation strict: one tenant database and one tenant role per tenant.
- Prefer data-driven tenant configuration over file-copy behavior.
- Keep platform-only and tenant-local concerns separated by context, route boundaries, and policy boundaries.

## Implementation Pattern

1. Confirm contract from the relevant planning note before coding.
2. Implement request validation with form request classes.
3. Implement business logic in service classes, not controllers.
4. Enforce authorization with explicit policies and permission checks.
5. Add audit and error logging at high-value state transitions and failure paths.
6. Add feature tests for permission gates, ownership checks, and critical workflows.

## Auth And Security Baseline

- Keep guard/session boundaries explicit for platform staff, tenant staff, and customer users.
- Apply named rate limiters on auth, recovery, and public submission routes.
- Use expiring/single-use tokens for invitation and recovery flows.
- Never expose protected file paths directly; gate access through policy-checked routes.

## Module Delivery Baseline

- Register module keys and settings keys explicitly.
- Keep module-level visibility separate from record-level ownership authorization.
- Require tenant boundary checks before company/user ownership checks.
- Add migration-safe permission seed/update paths so future modules can be added after 1.0.

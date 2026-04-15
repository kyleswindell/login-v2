# Phase 1 Foundation Architecture Direction

This document defines the canonical scope and intent for Phase 1 Foundation Architecture Direction.

## Purpose

Capture durable architecture direction extracted from Phase 1 foundation planning.

## Core Boundary Model

- shared core application is the baseline product layer
- platform-management capabilities are layered above shared core
- tenant runtime is a separate layer with isolated tenant data boundaries

## Identity And Access Direction

- platform staff authentication remains platform-scoped
- tenant authentication remains separately scoped for later phases
- RBAC is the baseline authorization model
- privileged platform-to-tenant access uses explicit, auditable handoff

## Tenancy Direction

- one platform database plus isolated tenant databases
- one PostgreSQL role per tenant
- domain-based tenant resolution model
- tenancy package strategy and implementation detail remain phase-gated

## Related

- [Platform Boundary](platform-boundary.md)
- [Tenancy](tenancy.md)
- [Phase 1 Planning](../07-planning/phases/phase-1/Phase 1 - Platform Foundation Planning.md)

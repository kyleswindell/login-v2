# Dependency Map

This document defines the canonical scope and intent for Dependency Map.

## Purpose

Summarize high-level delivery dependencies across phases and batches.

## Phase Dependencies

1. Phase 0 must complete deployment and workflow baseline before sustained feature delivery.
2. Phase 1 establishes core authentication, RBAC, tenancy baseline, and logging foundations.
3. Phase 2 finalizes stack, shell/UI ownership, page archetype starter proofs, and migration gates before outward-facing expansion.
4. Phase 3 depends on Phase 2 contracts for customer/public access, OAuth, and publishing.
5. Phase 3 now also owns the security substrate required by outward-facing auth and integration rollout, including login abuse defenses, secret-backed credential storage, auth-bearing surface hardening, and production environment checks for OAuth and Graph-bearing paths.
6. Phase 4 depends on Phases 2-3 foundations for remaining module rollout.

## Batch Dependencies

1. Phase 2 Batch A must close before Phase 2 Batch B starts. [satisfied]
2. Phase 2 Batch B must close before Phase 2 Batch F starts. [satisfied]
3. Phase 2 Batch F must close before Phase 2 Batch E resumes.
4. Contract maintenance and QA close-out batches run only after implementation batches reach exit criteria.

## Feature Link Dependencies

1. Authentication and RBAC planning references feature owners in `../04-features/auth/` and `../04-features/users/`.
2. Messaging planning references `../04-features/tenants/inter-tenant-messaging-contract.md`.
3. Account, notifications, and dashboard batch planning depends on their feature owner docs.

## Related

- [Roadmap](roadmap.md)
- [Phases](phases/index.md)
- [Batches](batches/index.md)

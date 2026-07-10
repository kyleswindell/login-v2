# Dependency Map

This document defines the canonical scope and intent for Dependency Map.

## Purpose

Summarize high-level delivery dependencies across phases and batches.

## Current Delivery Management

GitHub Projects owns active development sequencing, issue status, assignment, and implementation planning. Legacy phase and batch dependencies are deprecated historical references and must not block current work unless they have been restated in GitHub Projects or a current source planning document.

## Phase Dependencies

Historical phase dependencies are deprecated. Use the current planning entry points for source sequencing:

1. Core capability migration and build sequencing: [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
2. Core/package ownership direction: [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
3. Access-control sequencing: [Access Control Implementation Planning](access-control-implementation-planning.md)
4. Identity/users sequencing: [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
5. Security planning dependencies: [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)

## Batch Dependencies

Docs-managed phase batch dependencies are deprecated. GitHub Projects owns active implementation order and blocking relationships.

## Feature Link Dependencies

1. Authentication and RBAC planning references feature owners in `../04-features/auth/` and `../04-features/users/`.
2. Messaging planning references `../04-features/tenants/inter-tenant-messaging-contract.md`.
3. Account, notifications, and dashboard batch planning depends on their feature owner docs.

## Related

- [Roadmap](roadmap.md)
- [Deprecated Phases](phases/index.md)
- [Deprecated Batches](batches/index.md)

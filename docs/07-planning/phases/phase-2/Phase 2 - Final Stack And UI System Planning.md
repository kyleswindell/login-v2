# Phase 2 - Final Stack And UI System Planning

This document defines the canonical scope and intent for Phase 2 - Final Stack And UI System Planning.

## Purpose

Define Phase 2 sequencing for Tier 1 library hardening, UI system completion, component library implementation, and platform surface convergence before Phase 3 and Phase 4 expansion.

## Planning Scope

- sequence the route/panel ownership lock
- sequence UI system completion through component-library implementation
- sequence platform surface convergence without absorbing feature-specific behavior
- sequence design baseline sign-off and close-out gates
- sequence Phase 3 and Phase 4 handoff readiness

## Current Status

- Phase 2 close-out planning is active
- Batch 6 is complete
- Batch 7 is invalid and superseded for UI work
- Batch A and Batch B are complete
- Batch E close-out preflight exposed a page archetype starter-proof handoff gap
- Batch F is active as the required pre-closeout implementation batch
- Batch E is paused until Batch F is complete and staging deploy is re-enabled
- Batch C, Batch D, Batch 9, and Batch 10 are preserved as deferred placeholders only
- staging deploy and visual QA belong to Batch E close-out sequencing only after Batch F exits

## Phase 2 Deliverable Direction

Phase 2 must leave behind a reusable internal UI system rather than only polished current pages.

The required outputs for the active Phase 2 lane are:

- Tier 1 primitives and baselines completed and reviewable
- remaining Tier 1 library hardening completed for the promoted action, feedback, and overlay entry points before broader Tier 2 reuse depends on them
- Tier 2 reusable internal pattern library completed for the current internal app surface set
- internal shell family standards defined for:
  - app shell
  - dashboard shell
  - setup shell
  - settings shell
  - account/profile shell
- reusable page/module scaffolding archetypes defined for:
  - dashboard and overview surfaces
  - list/index surfaces
  - detail/read-only surfaces
  - create/edit form surfaces
  - setup/configuration surfaces
  - settings surfaces
- dashboard widget shell and summary/stat-card conventions established
- setup/settings registration conventions established for future modules
- future-module UI ownership declaration requirements established
- UI reference examples and validation surfaces updated for the relevant Tier 1 and Tier 2 outputs
- concrete starter-page examples for the reusable page/module archetypes that future phases will consume

These outputs exist to make later Phase 3 and Phase 4 work additive instead of forcing those phases to invent shared UI structure while building feature behavior.

## Sequencing Plan

1. Finalize the rebuilt UI batch sequence and mark Batch 7 as removed from active execution. [complete]
2. Complete Batch A for Tier 1 components and UI reference implementation. [complete]
3. Complete Batch B, starting with the remaining Tier 1 library hardening pass and then the Tier 2 internal library, internal shell/scaffolding standards, and proof-surface adoption. [complete]
4. Complete Batch F page archetype starter-proof implementation. [active]
5. Complete Batch E staging deploy and visual QA close-out after Batch F and security-incident deployment hold resolution. [paused]
6. Preserve deferred placeholders for future-phase assignment without executing them in Phase 2.
7. Confirm Phase 3 and Phase 4 scaffolding handoff readiness.
8. Mark Phase 2 complete only after gate and dependency checks pass.

## Dependency Rules

- Batch A completion is required before Batch B starts. [satisfied]
- the Batch B Tier 1 hardening lane must complete before the dependent Tier 2 compositions are treated as complete. [satisfied]
- Batch B completion is required before Batch F starts. [satisfied]
- Batch F completion is required before Batch E resumes.
- Batch E staging deploy must not run while staging deploy is disabled pending security incident review.
- Phase 3 and Phase 4 start only after Phase 2 handoff checklist is complete.

## Phase 3 And Phase 4 Handoff Expectations

Before later phases begin, Phase 2 should already have established:

- the internal shell/navigation direction
- the internal reusable Tier 2 pattern library needed for staff-facing surfaces
- the internal page/module scaffolding standards future modules will consume
- the dashboard widget-shell and summary-shell rules later modules can reuse
- the setup/settings registration conventions later modules must follow
- the UI ownership declaration matrix requirements future module plans must complete before coding
- the concrete handoff artifacts that describe those rules in reviewable form:
  - shell-family rule matrix
  - page/module archetype matrix
  - setup/settings registration field contract
  - future-module UI ownership declaration field contract
- the concrete UI Reference starter examples that demonstrate those contracts in full-page context

Phase 2 should not defer these internal app-surface foundations into later feature phases, because Phase 3 and Phase 4 both assume they already exist.

## Exit Criteria

Phase 2 can close when:

- all Phase 2 dependency gates are satisfied
- Batch F starter-proof coverage is complete
- blocked batches are completed in order
- staging QA and visual sign-off are recorded
- Phase 3 and Phase 4 handoff checklist is complete

## Canonical References

Durable architecture decisions are canonicalized in:

- [Final Stack And UI Boundary](../../../03-architecture/subsystems/final-stack-and-ui-boundary.md)
- [Phase 2 Stack And UI Architecture Decisions](../../../03-architecture/subsystems/phase-2-stack-and-ui-architecture-decisions.md)

## Related

- [Phase 2 Index](Phase%202%20Index.md)
- [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
- [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)
- [Phase 2 - Implementation Batch 7](Phase%202%20-%20Implementation%20Batch%207.md)
- [Phase 2 - Implementation Batch A](Phase%202%20-%20Implementation%20Batch%20A.md)
- [Phase 2 - Implementation Batch B](Phase%202%20-%20Implementation%20Batch%20B.md)
- [Phase 2 - Batch B Implementation Prep](Phase%202%20-%20Batch%20B%20Implementation%20Prep.md)
- [Phase 2 - Implementation Batch E](Phase%202%20-%20Implementation%20Batch%20E.md)
- [Phase 2 - Implementation Batch F](Phase%202%20-%20Implementation%20Batch%20F.md)
- [Phase 2 - Implementation Batch C](Phase%202%20-%20Implementation%20Batch%20C.md)
- [Phase 2 - Implementation Batch D](Phase%202%20-%20Implementation%20Batch%20D.md)
- [Phase 2 - Implementation Batch 9](Phase%202%20-%20Implementation%20Batch%209.md)
- [Phase 2 - Implementation Batch 10](Phase%202%20-%20Implementation%20Batch%2010.md)
- [Feature Roadmap](../../roadmap.md)

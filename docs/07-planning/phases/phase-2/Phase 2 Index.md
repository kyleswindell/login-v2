# Phase 2 Index

This index provides canonical navigation and scope for this branch.

## Purpose

Collect Phase 2 planning notes for UI standards adoption and platform surface convergence.

## Current Phase Status

Phase 2 is active for UI standards adoption and platform surface convergence sequencing.

The prior Batch 7 implementation path is invalid and must not be reused. UI system work now runs through a rebuilt Batch A-E sequence with separated standards-adoption, surface-convergence, feature, and close-out scopes.

Current focus:

* apply locked UI standards without introducing new rule-making inside implementation batches
* converge current platform-owned dashboard, shell, and notifications surfaces onto the locked standards baseline
* separate account behavior into its own feature batch instead of bundling it into shell migration work
* complete staging deploy and visual QA only after standards adoption and surface feature batches are complete
* keep `/console` as transitional proof-only routing until the convergence batches explicitly retire remaining dependencies
* keep non-UI Phase 2 contract work separate from the UI convergence lane

## Batch Sequence Status

| Batch   | Status                                        | Primary output                                             |
| ------- | --------------------------------------------- | ---------------------------------------------------------- |
| Batch 1 | Complete                                      | decision lock and batch sequencing contracts               |
| Batch 2 | Complete                                      | Filament operational proof: error logs                     |
| Batch 3 | Complete                                      | Filament operational proof: audit logs                     |
| Batch 4 | Complete locally                              | route and navigation convergence contracts                 |
| Batch 5 | Complete                                      | users/settings/notifications/operational surface migration |
| Batch 6 | Complete                                      | phase close-out contracts and Phase 3/4 handoff            |
| Batch 7 | Removed from active sequence                  | invalid over-bundled batch; replaced by Batch A-E          |
| Batch A | Planning-ready                                | UI standards adoption only                                 |
| Batch B | Blocked by Batch A                            | dashboard and shell convergence                            |
| Batch C | Blocked by Batch B                            | account feature delivery                                   |
| Batch D | Blocked by Batch B                            | notifications interactions and state changes               |
| Batch E | Blocked by B, C, and D                        | staging deploy and visual QA close-out                     |
| Batch 9 | Blocked (Batch C completion required)         | inter-tenant messaging foundation                          |
| Batch 10 | Contract-complete                            | calendar foundation and CalendarEntry contract             |
| Batch 11 | Historical delivery record                   | dashboard implementation record; close-out superseded by E |

## Planning Notes

* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [Phase 2 - Implementation Batch 1](Phase%202%20-%20Implementation%20Batch%201.md)
* [Phase 2 - Implementation Batch 2](Phase%202%20-%20Implementation%20Batch%202.md)
* [Phase 2 - Implementation Batch 3](Phase%202%20-%20Implementation%20Batch%203.md)
* [Phase 2 - Implementation Batch 4](Phase%202%20-%20Implementation%20Batch%204.md)
* [Phase 2 - Implementation Batch 5](Phase%202%20-%20Implementation%20Batch%205.md)
* [Phase 2 - Implementation Batch 6](Phase%202%20-%20Implementation%20Batch%206.md)
* [Phase 2 - Implementation Batch 7](Phase%202%20-%20Implementation%20Batch%207.md)
* [Phase 2 - Implementation Batch A](Phase%202%20-%20Implementation%20Batch%20A.md)
* [Phase 2 - Implementation Batch B](Phase%202%20-%20Implementation%20Batch%20B.md)
* [Phase 2 - Implementation Batch C](Phase%202%20-%20Implementation%20Batch%20C.md)
* [Phase 2 - Implementation Batch D](Phase%202%20-%20Implementation%20Batch%20D.md)
* [Phase 2 - Implementation Batch E](Phase%202%20-%20Implementation%20Batch%20E.md)
* [Phase 2 - Implementation Batch 9](Phase%202%20-%20Implementation%20Batch%209.md)
* [Phase 2 - Implementation Batch 10](Phase%202%20-%20Implementation%20Batch%2010.md)
* [Phase 2 - Route And Panel Ownership Map](Phase%202%20-%20Route%20And%20Panel%20Ownership%20Map.md)
* [Phase 2 - UI Surface Disposition Audit](Phase%202%20-%20UI%20Surface%20Disposition%20Audit.md)

## Multi-Agent Scheduling

Phase 2 remaining UI implementation batches use a conservative sequence: Batch A starts the rebuilt UI lane, Batch B depends on Batch A, Batch C and Batch D depend on Batch B, and Batch E closes the lane after B/C/D are complete. Batch 9 and Batch 10 remain outside the rebuilt UI lane.

### Dependency Graph

```
Batch A implementation
    └─ Batch B implementation
          ├─ Batch C implementation
          ├─ Batch D implementation
          └─ Batch E close-out after B/C/D

Batch 9   (separate messaging foundation lane)
Batch 10  (contract-complete; implementation can be scheduled independently)
Batch 11  (historical dashboard delivery record only)
```

### Parallelism Windows

| Agent A (shared folder, writable) | Agent B (separate worktree, writable) | Gate |
|---|---|---|
| Batch B implementation | Batch 10 contract/doc refinement (if needed) | Safe when UI convergence and calendar contract work stay isolated |
| Batch C implementation | Batch D implementation | Safe after Batch B when account and notifications ownership stay separate |
| Batch E staging deploy and QA | Batch 10 contract/doc refinement (if needed) | Safe when close-out work is limited to staging and validation |

### Notes

* Batch 7 is not reusable and remains only as a superseded planning record.
* Batch A applies existing standards only and must not introduce new standards or feature behavior.
* Batch B owns shared-surface convergence only and must not absorb account or notifications feature behavior.
* Batch C and Batch D require canonical feature owner notes and corresponding flows before implementation starts.
* Batch E owns staging deploy and visual QA only; it does not own new feature delivery.
* See [Agent Sessions And Parallel Work](../../../10-runbooks/agent-sessions-and-parallel-work.md) for setup steps.

## Canonical Owners

* [Final Stack And UI Design Spec](../../../03-architecture/subsystems/final-stack-and-ui-boundary.md)
* [Stack Overview](../../../03-architecture/stack-overview.md)
* [Stack - Filament And Livewire](../../../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)
* [Stack - Frontend Build](../../../09-reference/architecture/phase-2-stack-and-ui-system-notes.md)
* [UI Design System Standards](../../../02-standards/ui/UI Design System Standards.md)
* [Account Management And Settings](../../../04-features/account/account-management-and-settings.md)
* [Dashboard](../../../04-features/dashboard/dashboard.md)
* [Platform Notifications And Settings](../../../04-features/notifications/platform-notifications-and-settings.md)
* [Inter-Tenant Messaging Contract](../../../04-features/tenants/inter-tenant-messaging-contract.md)
* Phase 2 Development Log

## Related

* [Planning Index](../../index.md)
* [Roadmap](../../roadmap.md)
* [Phase 1 Index](../phase-1/Phase%201%20Index.md)

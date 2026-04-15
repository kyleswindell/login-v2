# Phase 3 Index

This index provides canonical navigation and scope for this branch.

## Purpose

Collect Phase 3 planning notes for customer/public view foundations and outward-facing business event and publishing behavior.

## Current Phase Status

Phase 3 is in planning draft.

Current focus:

* define customer and public route, shell, and visibility foundations before broader module rollout
* map outward-facing business event behavior from the V1 custom Events module into V2
* establish OAuth sign-in planning for Google and Microsoft account providers
* define per-tenant customer access modes (`disabled`, `invite_only`, `open_enrollment`)
* define customer company multi-user model for customer-scoped authorization
* establish Microsoft Graph email sending foundation before core module rollout
* define platform-default and tenant-override sender-account and alias configuration
* define feature-based sender-alias routing plus user preference and mandatory notice rules
* define module-level and record-level customer visibility toggles
* define interim legacy website JSON publishing compatibility direction
* separate platform-owned publishing integrations from tenant-operated business data workflows

## Planning Notes

* [Phase 3 - Customer And Public View Planning](Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [Phase 3 - Implementation Batch 1](Phase%203%20-%20Implementation%20Batch%201.md)
* [Phase 3 - Events And Legacy Website Publishing Planning](Phase%203%20-%20Events%20And%20Legacy%20Website%20Publishing%20Planning.md)
* [Phase 3 - Microsoft Graph Email Sending Planning](Phase%203%20-%20Microsoft%20Graph%20Email%20Sending%20Planning.md)
* [Phase 3 - OAuth And Customer Access Mode Planning](Phase%203%20-%20OAuth%20And%20Customer%20Access%20Mode%20Planning.md)
* [Phase 3 - UI Ownership And PostgreSQL Schema Map](Phase%203%20-%20UI%20Ownership%20And%20PostgreSQL%20Schema%20Map.md) — redirect: this topic moved to Phase 4 after phase resequencing; see Phase 4 - UI Ownership And PostgreSQL Schema Map

## Multi-Agent Scheduling

Phase 3 Batch 1 as currently scoped contains two largely independent workstreams that can run on separate worktrees in parallel once Phase 2 closes out.

### Internal Batch 1 Workstreams

| Workstream | Content | Files owned |
|---|---|---|
| Outward-facing foundations | Customer routes, OAuth sign-in policy, customer access mode (`disabled` / `invite_only` / `open_enrollment`), customer-company membership model, Events admin and public-view proof | `routes/`, customer-facing controllers, OAuth config, customer/tenant models, Events module skeleton |
| Email infrastructure | Microsoft Graph sending service, platform and tenant sender-account GUI, feature alias routing, notice preference policy, queue jobs | `app/Services/Mail/`, mail transport config, sender-account migrations, alias routing service |

### Dependency Graph

```
Phase 2 close-out
    ├─ P3-B1: Outward-facing foundations  (Agent A worktree)
    └─ P3-B1: Email infrastructure        (Agent B worktree)
          └─ merge both → Phase 3 Batch 2+ (depends on both streams)
```

### Parallelism Windows

| Agent A (worktree A) | Agent B (worktree B) | Gate |
|---|---|---|
| Customer routes + OAuth + access mode + Events proof | Microsoft Graph email service + GUI + queue | Both require Phase 2 close-out; neither stream depends on the other |
| (merged) Phase 3 Batch 2+ | — | Cannot start until both streams are merged and tests pass |

### Notes

* Neither stream depends on the other at build time. The outward-facing stream owns public route namespaces and customer-facing models. The email infrastructure stream owns the mail transport layer and sender configuration.
* Both streams will touch `database/migrations/` and `app/Providers/AppServiceProvider.php` (service binding, gate definitions). These are the primary merge-time conflict points.
* If Phase 3 Batch 1 is later split into separate numbered batches by workstream, this scheduling map should be reflected in those batch notes. The current single-batch scope is a planning simplification; the build itself is safely splittable.
* See [Agent Sessions And Parallel Work](../../../10-runbooks/agent-sessions-and-parallel-work.md) for worktree setup steps.

## Canonical Inputs

* [Roadmap](../../roadmap.md)
* [Phase 2 - Final Stack And UI System Planning](../phase-2/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* Events
* Event Website Sync
* Website Sync Architecture

## Related

* [Planning Index](../../index.md)
* [Phase 2 Index](../phase-2/Phase%202%20Index.md)
* [Phase 4 Index](../phase-4/Phase%204%20Index.md)

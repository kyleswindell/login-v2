# Phase 4 Index

## Purpose

Collect Phase 4 planning notes for remaining core module introduction after customer/public view foundations are established.

## Current Phase Status

Phase 4 is in planning draft.

Current focus:

* map V1 foundational/core module behavior into V2 module boundaries
* define required setup views and settings coverage per module
* capture cross-module interaction requirements and dependency rules
* define module-level and record-level customer-facing visibility controls
* enforce customer-company ownership authorization for customer-facing records
* identify V1 pain points and targeted V2 improvements before implementation starts
* map Filament/Livewire/custom UI ownership per module
* map PostgreSQL-first schema direction and V1-to-V2 table changes per module

## Planning Notes

* [[V2 App/Planning/Phase 4/Phase 4 - Remaining Core Module Planning]] | [Phase 4 - Remaining Core Module Planning](Phase%204%20-%20Remaining%20Core%20Module%20Planning.md)
* [[V2 App/Planning/Phase 4/Phase 4 - Implementation Batch 1]] | [Phase 4 - Implementation Batch 1](Phase%204%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 4/Phase 4 - UI Ownership And PostgreSQL Schema Map]] | [Phase 4 - UI Ownership And PostgreSQL Schema Map](Phase%204%20-%20UI%20Ownership%20And%20PostgreSQL%20Schema%20Map.md)

## Multi-Agent Scheduling

Phase 4 Batch 1 introduces three tightly-related modules. Two are independently buildable; the third depends on both.

### Dependency Graph

```
Phase 3 close-out
    ├─ Customers + Contacts module  (Agent A worktree — no upstream module dependency)
    ├─ Finance Setup baseline       (Agent B worktree — no upstream module dependency)
    └─ merge both → Sales Core     (sequential — requires Customers + Finance both merged and tested)
```

### Parallelism Windows

| Agent A (worktree A) | Agent B (worktree B) | Gate |
|---|---|---|
| Customers + Contacts module | Finance Setup baseline (taxes, currencies, payment modes, expense categories) | Both require Phase 3 close-out only; no inter-module dependency |
| (merged) Sales Core (estimates, invoices, payments, credit notes) | — | Cannot start until both Customers and Finance modules are merged and feature tests pass |

### Notes

* Customers and Finance are safe to build in parallel. They own distinct table families (`customers`, `contacts` vs `tax_rates`, `currencies`, `payment_modes`, `expense_categories`), separate route namespaces, and separate settings groups.
* Sales Core has hard runtime dependencies on both modules: customer linkage on estimates and invoices, and tax/currency/payment config from Finance. Do not start Sales Core until both modules are merged and migrated.
* Common merge-time conflict points: `routes/web.php` (module route registrations), `app/Providers/AppServiceProvider.php` (module service and permission registrations), and `docs/V2 App/Planning/Phase 4/Phase 4 Index.md` (batch status updates from both agents).
* Later Phase 4 batches (Projects, Tasks, Support, Leads) follow the same split-merge pattern. Their dependency analysis is deferred to their batch planning sessions; use the same scheduling approach when those batch notes are created.
* See [Agent Sessions And Parallel Work](../../Runbooks/Agent%20Sessions%20And%20Parallel%20Work.md) for worktree setup steps.

## Canonical Inputs

* [[V2 App/Planning/V2 Feature Roadmap]] | [V2 Feature Roadmap](../V2%20Feature%20Roadmap.md)
* [[V2 App/Planning/Phase 3/Phase 3 - Customer And Public View Planning]] | [Phase 3 - Customer And Public View Planning](../Phase%203/Phase%203%20-%20Customer%20And%20Public%20View%20Planning.md)
* [[V2 App/Planning/Phase 3/Phase 3 - OAuth And Customer Access Mode Planning]] | [Phase 3 - OAuth And Customer Access Mode Planning](../Phase%203/Phase%203%20-%20OAuth%20And%20Customer%20Access%20Mode%20Planning.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V1 App/Features/V1 Feature Catalog]] | [V1 Feature Catalog](../../../V1%20App/Features/V1%20Feature%20Catalog.md)
* [[V1 App/Reference/Setup And Settings Map]] | [Setup And Settings Map](../../../V1%20App/Reference/Setup%20And%20Settings%20Map.md)

## Related

* [[V2 App/Planning/Planning Index]] | [Planning Index](../Planning%20Index.md)
* [[V2 App/Planning/Phase 3/Phase 3 Index]] | [Phase 3 Index](../Phase%203/Phase%203%20Index.md)

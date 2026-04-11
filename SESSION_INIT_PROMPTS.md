# Session Init Prompts

Personal reference for starting or continuing agent sessions in this repository.

Active customization structure:

- Global policy: [AGENTS.md](AGENTS.md)
- Instructions: [.github/instructions/](.github/instructions/)
- Prompts: [.github/prompts/](.github/prompts/)
- Skills: [.github/skills/](.github/skills/)

---

## Role Structure

Prompts and skills are organized into four roles:

| Role | Trigger | When |
|---|---|---|
| Phase Batch Planning | `/phase-batch-planning` | Organize and sequence a phase into batches |
| Phase Batch Implementation | `/phase-batch-implementation` | Code the currently active batch |
| Module Creation Kickoff | `/module-creation-kickoff` | Sub-task when a batch introduces a new module |
| Planning Sync | `/planning-sync` | Sync canonical docs after any contract or scope change |

---

## Tier 1 — Phase Batch Planning

**Prompt:** `/phase-batch-planning`

**When to use:**
A finalized phase plan exists but batches are not yet defined, or existing batch sequencing needs to be reviewed before implementation starts. Use this before touching code.

**Input:**
```
/phase-batch-planning Phase [X]
```

**What it does:**
Reads phase index and all planning/canonical docs, maps dependency relationships, defines batch boundaries and contracts, flags open decisions that block any batch from starting.

**Example:**
```
/phase-batch-planning Phase 3
```

---

## Tier 2 — Phase Batch Implementation

**Prompt:** `/phase-batch-implementation`

**When to use:**
Batches are already planned and a batch is active or ready to start. Use this to write code. Reads repo state first, continues from where the last session left off, runs tests, syncs docs.

**Starter prompt (new or unknown state):**
```
/phase-batch-implementation Phase [X] Batch [Y]
```

**Starter prompt (known active state):**
```
/phase-batch-implementation active
Continue from current repo state and uncommitted changes; do not re-plan completed items.
```

---

### Current Phase 2 Status (confirmed)

| Batch | Status | Notes |
|---|---|---|
| Batch 1 | In progress — decisions open | App shell, visual design direction, planning close-out |
| Batch 2 | Complete | Filament error log proof deployed and validated on staging |
| Batch 3 | Complete | Filament audit log proof deployed and validated on staging |
| Batch 4 | Not yet created | Next implementation slice — TBD scope |

**Phase 2 Batch 4 continuation starter:**
```
Goal: Phase 2 Batch 4 implementation

/phase-batch-implementation active
Continue from current repo state and uncommitted changes; do not re-plan completed items.
Batches 2 and 3 are complete. Batch 1 decisions are still open.
Read the Phase 2 index, Phase 2 Batch 1 note, and linked canonical docs first.
Confirm whether Batch 1 decisions are ready to close, then plan and create Phase 2 Batch 4 as the next implementation slice.
Implement the next dependency-safe slice, run relevant tests, and sync documentation updates.
```

---

## Tier 2 Sub-Task — Module Creation Kickoff

**Prompt:** `/module-creation-kickoff`

**When to use:**
Inside an active implementation session when a batch introduces a new module that does not yet have a key, namespace, settings contract, permissions, schema, or notification hooks defined. Run this before implementing the module code.

**Starter prompt:**
```
/module-creation-kickoff [Module name] — Phase [X]
```

**Example:**
```
/module-creation-kickoff Support module — Phase 4
```

---

## Tier 3 — Planning Sync

**Skill:** `/planning-sync`

**When to use:**
After any change to contracts, sequencing, or delivery scope that requires updating both the planning source and canonical owner docs together. Also use for cross-phase link and status audits.

**Starter prompt (sync after change):**
```
/planning-sync
Updated [what changed] in [source note]. Align the canonical owner, phase index, and implementation status sections.
```

**Starter prompt (audit):**
```
/planning-sync
Audit cross-links and implementation status consistency across Phase [X] planning notes and linked canonical owners.
```

---

## General Session Strategy

**New session when:**
- Role changes materially (planning → implementation, one module → another)
- Context history is stale for the new task
- Starting a fresh phase from scratch

**Continue same session when:**
- Building on prior reasoning in the same task
- Mid-batch and not yet done

**Parallel sessions pattern:**
- Session A: active batch implementation
- Session B: future phase planning or module kickoff
- Session C (optional): cross-phase contract or security audit

**One-line goal prefix:**
Starting with a clear goal line improves instruction routing:
- `Goal: Phase 2 Batch 4 implementation`
- `Goal: Phase 3 batch planning`
- `Goal: Support module kickoff`
- `Goal: Phase 3 planning sync after OAuth decision`

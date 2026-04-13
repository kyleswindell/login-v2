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

| Role                       | Trigger                       | When                                                            |
| -------------------------- | ----------------------------- | --------------------------------------------------------------- |
| Phase Planning             | `/phase-planning`             | Define or realign a phase's goals, deliverables, and constraints |
| Phase Batch Planning       | `/phase-batch-planning`       | Organize a finalized phase plan into dependency-ordered batches |
| Phase Batch Implementation | `/phase-batch-implementation` | Code the currently active batch                                 |
| Module Creation Kickoff    | `/module-creation-kickoff`    | Sub-task when a batch introduces a new module                   |
| Planning Sync              | `/planning-sync`              | Sync canonical docs after any contract or scope change          |

---

## Tier 1 — Phase Planning

**Prompt:** `/phase-planning`

**When to use:**
No phase plan exists yet, or an existing phase plan needs goals and deliverables realigned before batches are organized. Run this before `/phase-batch-planning`. Output feeds directly into batch planning.

**Input:**
```
/phase-planning Phase [X]
```

**Input (editor-only safe mode):**
```
/phase-planning Phase [X]
Use editor-first updates only. Do not use bash or scripted bulk rewrites for documentation edits.
Apply minimal, file-scoped changes and summarize touched files before and after edits.
```

**What it does:**
Reads the roadmap and adjacent phases, defines or confirms phase goal, primary deliverables, explicit exclusions, cross-phase hand-off contracts, open decisions, and canonical doc ownership. Updates the phase index.

**Example:**
```
/phase-planning Phase 3
```

---

## Tier 2 — Phase Batch Planning

**Prompt:** `/phase-batch-planning`

**When to use:**
A finalized phase plan exists (output of `/phase-planning`) but batches are not yet defined, or existing batch sequencing needs to be reviewed. Use this after phase goals and deliverables are locked and before touching code.

**Input:**
```
/phase-batch-planning Phase [X]
```

**Input (editor-only safe mode):**
```
/phase-batch-planning Phase [X]
Use editor-first updates only. Do not use bash or scripted bulk rewrites for documentation edits.
Apply minimal, file-scoped changes and summarize touched files before and after edits.
```

**What it does:**
Reads phase index and all planning/canonical docs, maps dependency relationships, defines batch boundaries and contracts, flags open decisions that block any batch from starting.

**Example:**
```
/phase-batch-planning Phase 3
```

---

## Tier 3 — Phase Batch Implementation

**Prompt:** `/phase-batch-implementation`

**When to use:**
Batches are already planned and a batch is active or ready to start. Use this to write code. Reads repo state first, continues from where the last session left off, runs tests, syncs docs.

**Starter prompt (new or unknown state):**
```
/phase-batch-implementation Phase [X] Batch [Y]
```

**Starter prompt (editor-only safe mode):**
```
/phase-batch-implementation Phase [X] Batch [Y]
Use editor-first updates only. Do not use bash or scripted bulk rewrites for code or documentation edits.
Apply minimal, file-scoped changes and summarize touched files before and after edits.
```

**Starter prompt (known active state):**
```
/phase-batch-implementation active
Continue from current repo state and uncommitted changes; do not re-plan completed items.
```

---

### Current Phase 2 Status (confirmed)

| Batch   | Status                        | Notes                                                                   |
| ------- | ----------------------------- | ----------------------------------------------------------------------- |
| Batch 1 | In progress — close-out pass  | Decision lock and sequencing contracts                                  |
| Batch 2 | Complete                      | Filament error log proof deployed and validated on staging              |
| Batch 3 | Complete                      | Filament audit log proof deployed and validated on staging              |
| Batch 4 | In progress                   | Route/navigation convergence and transitional `/console` ownership plan |
| Batch 5 | Planned                       | Users/settings/notifications/operational-owner migration                |
| Batch 6 | Planned                       | Phase close-out contracts and Phase 3/4 handoff                         |

**Phase 2 Batch 4 continuation starter:**
```
Goal: Phase 2 Batch 4 implementation

/phase-batch-implementation active
Continue from current repo state and uncommitted changes; do not re-plan completed items.
Batches 2 and 3 are complete. Batch 4 is active and Batch 1 close-out decisions are in progress.
Read the Phase 2 index, Batch 1, Batch 4, and linked canonical docs first.
Implement Batch 4 route/navigation convergence contracts and transitional `/console` ownership mapping.
Run relevant tests and sync planning/canonical/development docs.
If Batch 4 exit criteria are met, prepare Batch 5 kickoff scope only; do not start Batch 5 implementation in the same pass.
```

---

## Tier 3 Sub-Task — Module Creation Kickoff

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

## Tier 4 — Planning Sync

**Skill:** `/planning-sync`

**When to use:**
After any change to contracts, sequencing, or delivery scope that requires updating both the planning source and canonical owner docs together. Also use for cross-phase link and status audits.

**Starter prompt (sync after change):**
```
/planning-sync
Updated [what changed] in [source note]. Align the canonical owner, phase index, and implementation status sections.
```

**Starter prompt (editor-only safe mode):**
```
/planning-sync
Updated [what changed] in [source note]. Align the canonical owner, phase index, and implementation status sections.
Use editor-first updates only. Do not use bash or scripted bulk rewrites for documentation edits.
Apply minimal, file-scoped changes and summarize touched files before and after edits.
```

**Starter prompt (audit):**
```
/planning-sync
Audit cross-links and implementation status consistency across Phase [X] planning notes and linked canonical owners.
```

---

## General Session Strategy

### Session Safety Model

Default rule:

- one writable session per working tree
- additional sessions in the same local repo folder must stay read-only unless the writable role is explicitly handed over

Shared-folder read-only sessions are appropriate for:
- planning
- code review
- documentation audit
- contract and scope analysis

If a second session must write while another writable session is still active:
- move the second session to a separate branch and separate git worktree
- do not rely on a checkout or lock file as protection

Startup checklist before any edits:
- confirm whether this session is read-only or writable
- confirm current branch and worktree path
- confirm whether the folder already contains uncommitted work
- confirm the last stable commit or pushed state this session can rely on
- confirm no other writable same-folder session is active
- confirm the scope this session owns before writing

**New session when:**
- Role changes materially (planning → implementation, one module → another)
- Context history is stale for the new task
- Starting a fresh phase from scratch

**Continue same session when:**
- Building on prior reasoning in the same task
- Mid-batch and not yet done

**Parallel sessions pattern:**
- Session A: active writable batch implementation in the shared folder
- Session B: future phase planning or module kickoff in read-only mode unless moved to its own worktree
- Session C (optional): cross-phase contract or security audit in read-only mode

**Writable handoff rule:**
- if Session B or Session C needs to edit files while Session A is still active, that session should move to its own branch and worktree first
- if the writable role is intentionally handed over in the shared folder, the prior writer should stop editing and leave a clear state summary

**One-line goal prefix:**
Starting with a clear goal line improves instruction routing:
- `Goal: Phase 2 Batch 4 implementation`
- `Goal: Phase 3 batch planning`
- `Goal: Support module kickoff`
- `Goal: Phase 3 planning sync after OAuth decision`

Helpful mode prefix when relevant:
- `Mode: writable shared-folder implementation session`
- `Mode: read-only planning session in shared folder`
- `Mode: writable planning session in separate worktree`

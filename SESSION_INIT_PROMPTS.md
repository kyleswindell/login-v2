# Session Init Prompts

Personal reference for starting or continuing agent sessions in this repository.

Active customization structure:

- Global policy: [AGENTS.md](AGENTS.md)
- Instructions: [.github/instructions/](.github/instructions/)
- Prompts: [.github/prompts/](.github/prompts/)
- Skills: [.github/skills/](.github/skills/)

---

## Role Structure

Prompts and skills are organized into eight roles:

| Role                       | Trigger                       | When                                                            |
| -------------------------- | ----------------------------- | --------------------------------------------------------------- |
| Phase Planning             | `/phase-planning`             | Define or realign a phase's goals, deliverables, and constraints |
| Phase Batch Planning       | `/phase-batch-planning`       | Organize a finalized phase plan into dependency-ordered batches |
| Phase Batch Development    | `/phase-batch-development`    | Turn a batch note into a delivery-ready implementation slice with tests and doc sync scope |
| Phase Batch Review         | `/phase-batch-review`         | Review a completed batch against docs, tests, and repo diff before commit/push |
| Phase Batch Implementation | `/phase-batch-implementation` | Code the currently active batch                                 |
| Phase Close-Out            | `/phase-close-out`            | Finalize a phase batch or full phase after review and manual QA |
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

## Tier 2.5 — Phase Batch Development

**Prompt:** `/phase-batch-development`

**When to use:**
Use this after a batch exists but before coding when the build still needs a delivery-ready implementation slice, explicit code touchpoints, a test matrix, or clearer in-scope versus out-of-scope guidance.

**Starter prompt:**
```
/phase-batch-development Phase [X] Batch [Y]
```

**What it does:**
Builds a dependency-safe implementation plan for the selected batch, including required contracts, code touchpoints, tests, doc sync work, and blockers that must be resolved before implementation starts.

---

## Tier 3 — Phase Batch Implementation

**Prompt:** `/phase-batch-implementation`

**When to use:**
Batches are already planned and a batch is active or ready to start. Use this to write code. Reads repo state first, continues from where the last session left off, runs tests, syncs docs.

Implementation should prepare the batch for review, not self-sign it off. Normal flow is implementation, then `/phase-batch-review`, then `/phase-close-out` after review and manual QA are complete.

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

## Tier 3.5 — Phase Batch Review

**Prompt:** `/phase-batch-review`

**When to use:**
Implementation for a specific batch is complete or paused at a reviewable checkpoint. Use this to compare the current diff or unpushed commit scope against the batch note, phase plan, and canonical docs before any commit or push.

**Starter prompt:**
```
/phase-batch-review Phase [X] Batch [Y]
```

**Starter prompt (known active state):**
```
/phase-batch-review active
Review the current implementation diff against the active batch note and linked canonical docs.
If the batch is review-clean, stage only the scoped files, commit, and push.
If not, report findings and stop before commit.
```

**What it does:**
Performs a batch-scoped audit of code, tests, doc sync, and implementation status. If findings remain, it reports them and leaves the batch open. If clean, it stages the scoped files, commits, pushes, and records the handoff state for close-out.

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

## Tier 4 — Phase Close-Out

**Prompt:** `/phase-close-out`

**When to use:**
Use only after review has passed and any required manual QA or visual review is complete. This is the only workflow step that should mark a phase batch or an entire phase as complete, signed off, or deferred-forward in the docs.

**Starter prompt (batch):**
```
/phase-close-out Phase [X] Batch [Y]
```

**Starter prompt (phase):**
```
/phase-close-out Phase [X]
```

**What it does:**
Audits implementation status, planning notes, canonical docs, indexes, and development logs for the target batch or full phase. Confirms what is complete, what is deferred, and what must roll into the next batch or phase. Updates docs to reflect final status and pushes the close-out commit when edits are required.

---

## Tier 5 — Planning Sync

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

**Recommended delivery flow:**
- `/phase-planning` to define or realign a phase
- `/phase-batch-planning` to sequence dependency-safe batches
- `/phase-batch-development` when a delivery-ready implementation slice is needed before coding
- `/phase-batch-implementation` to build the active slice and sync docs
- `/phase-batch-review` to validate the diff and commit or push only when review-clean
- `/phase-close-out` to mark the batch or phase complete after review and manual QA

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

# Repo-Local Agent Memory

This document defines the canonical operational model for repo-local agent memory under `.agents/memory/`.

## Purpose

Provide a safe, local, non-production-facing memory layer for agents without turning canonical `docs/` into a general-purpose memory store.

## Core Distinction

Use these ownership rules:

- `docs/` answers: what is canonically true about the system
- `docs/08-active/` answers: what is true about the current active batch workflow state
- `.agents/batch-branch-handoffs/` answers: what a worker branch is handing to an integrator
- `.agents/memory/` answers: what agents should remember locally to work effectively in this repo without treating that memory as canonical product truth

If a remembered item becomes durable system truth, promote it into its canonical `docs/` owner.

If a remembered item becomes durable agent-behavior guidance instead:

- promote repo-wide operating rules into `AGENTS.md`
- promote repeatable workflow behavior into the relevant skill file
- promote reusable generic starter-pack improvements into `.agents/baselines/`

## Structure

Use this baseline layout:

- `.agents/memory/README.md`
- `.agents/memory/stable/operator-preferences.md`
- `.agents/memory/stable/project-context.md`
- `.agents/memory/stable/repo-heuristics.md`
- `.agents/memory/working/open-loops.md`
- `.agents/memory/working/session-handoffs/`
- `.agents/memory/ephemeral/`

## Memory Classes

### Stable Memory

Use for relatively durable, non-canonical agent support material, such as:

- operator preferences
- recurring repo heuristics
- stable workflow expectations that help execution but are not themselves the canonical source

Stable memory should be concise and occasionally re-verified.

### Working Memory

Use for multi-session continuity that is still active, such as:

- open loops
- active investigations outside the current batch workspace
- handoff summaries that outlive one chat session

Working memory should be kept current and pruned when the loop closes.

### Ephemeral Memory

Use for short-lived compression and scratch continuity, such as:

- temporary session summaries
- short-term context that is helpful now but not worth keeping long-term

Ephemeral memory should be deleted or rewritten aggressively.

## Allowed Content

Repo-local agent memory may store:

- concise preference notes
- repo-specific heuristics and recurring traps
- compact context summaries for active focus areas
- non-canonical open loops
- non-sensitive session handoff summaries

## Disallowed Content

Repo-local agent memory must not store:

- canonical product, architecture, planning, or operational truth that belongs in `docs/`
- active batch queue state or review-state transitions that belong in `docs/08-active/`
- worker integration handoff records that belong in `.agents/batch-branch-handoffs/`
- secrets, credentials, tokens, customer-sensitive raw data, or production-only sensitive values
- duplicate restatements of large canonical docs sections

## Promotion Rule

Promote memory into canonical docs when any of the following becomes true:

- the note defines a rule
- the note defines system structure
- the note defines behavior or contract truth
- the note changes planning or status truth
- the note becomes something humans should rely on as source of truth

When promoting:

1. update the canonical owner in `docs/`
2. or update the correct instruction owner (`AGENTS.md`, skill file, or `.agents/baselines/`) when the information is really agent-behavior guidance
3. trim the memory note back to a short pointer or remove it
4. avoid leaving duplicate truth in both places

## Concurrency Rule

`.agents/memory/` is still part of the repo working tree.

That means:

- one writable session per worktree still applies
- if another writer already owns the shared worktree, a session that wants to write memory must stop and move to a separate branch/worktree or receive explicit writable handoff
- memory files are coordination aids, not locks

## Baseline Operating Flow

1. Read existing relevant memory notes before creating a new one.
2. Decide whether the information is:
   - canonical docs truth
   - active batch state
   - branch handoff state
   - repo-local memory
3. Write only to the correct owner path.
4. Prefer updating an existing memory note over creating a near-duplicate.
5. Prune or promote stale memory during close-out.

## Maintenance Expectations

- Keep notes short and scannable.
- Add source links or canonical links when practical.
- Mark unresolved or tentative material clearly.
- Revisit open loops and ephemeral notes regularly.
- Remove memory that has expired, been promoted, or is no longer useful.

## Related

- [Runbook Index](index.md)
- [AI Governance Rules](../11-ai/rules.md)
- [Agent Sessions And Parallel Work](agent-sessions-and-parallel-work.md)

## Exportable Baseline

The generic starter pack for this model lives in:

- [`.agents/baselines/repo-local-agent-memory/`](../../.agents/baselines/repo-local-agent-memory/README.md)

Use that package when another repo needs the same memory system before any repo-specific memory is written.

# Repo-Local Agent Memory

This document defines the canonical operational model for repo-local agent memory under `.agents/memory/`.

## Purpose

Provide a safe, local, non-production-facing memory layer for agents without turning canonical docs into a general-purpose memory store.

## Core Distinction

Use these ownership rules:

- canonical docs answer: what is canonically true about the system
- active workflow state answers: what is true about the current execution workspace
- branch handoff owners answer: what one branch is handing to another
- `.agents/memory/` answers: what agents should remember locally to work effectively without treating that memory as canonical product truth

If a remembered item becomes durable system truth, promote it into its canonical owner.

If a remembered item becomes durable agent-behavior guidance instead:

- promote repo-wide operating rules into `AGENTS.md`
- promote repeatable workflow behavior into the relevant skill file
- promote reusable generic starter-pack improvements into `.agents/baselines/`

## Structure

Use this baseline layout:

- `.agents/memory/README.md`
- `.agents/memory/CONFIG.example.md`
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

### Working Memory

Use for multi-session continuity that is still active, such as:

- open loops
- active investigations outside the current execution workspace
- handoff summaries that outlive one chat session

### Ephemeral Memory

Use for short-lived compression and scratch continuity, such as:

- temporary session summaries
- short-term context that is helpful now but not worth keeping long-term

## Allowed Content

Repo-local agent memory may store:

- concise preference notes
- repo-specific heuristics and recurring traps
- compact context summaries for active focus areas
- non-canonical open loops
- non-sensitive session handoff summaries

## Disallowed Content

Repo-local agent memory must not store:

- canonical product, architecture, planning, or operational truth
- active workflow queue state or review-state transitions
- branch integration handoff records when a dedicated handoff owner already exists
- secrets, credentials, tokens, customer-sensitive raw data, or production-only sensitive values
- duplicate restatements of large canonical docs sections

## Promotion Rule

Promote memory into canonical docs when any of the following becomes true:

- the note defines a rule
- the note defines system structure
- the note defines behavior or contract truth
- the note changes planning or status truth
- the note becomes something humans should rely on as source of truth

## Concurrency Rule

`.agents/memory/` is still part of the repo working tree.

That means:

- one writable session per worktree still applies
- if another writer already owns the shared worktree, a session that wants to write memory must stop and move to a separate branch/worktree or receive explicit writable handoff
- memory files are coordination aids, not locks

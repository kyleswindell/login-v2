# Operator Preferences

Use this file for stable, non-sensitive operator preferences that help agents work effectively in this repo.

## Format

For each preference, record:

- preference
- scope
- source
- last verified
- notes

## Entries

- preference: Keep `main` clean and publish-only; do active writable work on non-`main` branches.
  scope: git workflow
  source: established operator workflow across 2026-06-01 branch/governance cleanup sessions
  last verified: 2026-06-01
  notes: `main` is the integrator/push/deploy lane rather than a long-lived writable accumulation branch.

- preference: Default to one active writable batch lane at a time unless there is a real concurrent need.
  scope: implementation workflow
  source: established operator workflow across 2026-06-01 concurrency/planning discussion
  last verified: 2026-06-01
  notes: Separate worker branches/worktrees are preferred only when another writable stream must run before the current one is integrated.

- preference: Keep writable future-planning or docs work on its own branch/worktree when an active work-batch is already in progress.
  scope: planning and documentation execution
  source: established operator workflow across 2026-06-01 concurrency/planning discussion
  last verified: 2026-06-01
  notes: Read-only planning/research can stay in the shared folder; writable planning should fork before editing.

- preference: Keep agent memory under `.agents/memory/`, not under `docs/`.
  scope: agent continuity and memory storage
  source: established operator workflow across 2026-06-01 agent-memory design pass
  last verified: 2026-06-01
  notes: `docs/` remains canonical and may become production-visible later, so memory stays in the agent layer.

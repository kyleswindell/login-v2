# Repo Heuristics

Use this file for recurring repo-specific heuristics, gotchas, or execution shortcuts that help agents operate efficiently but are not themselves canonical truth.

## Format

For each heuristic, record:

- heuristic
- applies to
- source
- canonical links
- review after

## Entries

- heuristic: Treat `docs/08-active/` as a singleton integrator-owned workspace even when multiple branches/worktrees exist.
  applies to: active batch execution and branch-based parallel work
  source: `AGENTS.md`; `docs/10-runbooks/agent-sessions-and-parallel-work.md`; `docs/10-runbooks/branch-based-batch-integration.md`
  canonical links: `AGENTS.md`; `docs/10-runbooks/agent-sessions-and-parallel-work.md`; `docs/10-runbooks/branch-based-batch-integration.md`
  review after: 2026-07-01

- heuristic: Review-ledger writes are still serialized even after moving to date-plus-slug review artifacts.
  applies to: review-only governance work
  source: `docs/11-ai/active-doc-reviews/index.md`; `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  canonical links: `docs/11-ai/active-doc-reviews/index.md`; `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  review after: 2026-07-01

- heuristic: A planning/research/review session may stay read-only in the shared folder, but if it becomes ready to write while another writer is active, fork it to its own branch/worktree before editing.
  applies to: concurrent planning, governance, and implementation sessions
  source: `AGENTS.md`; `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  canonical links: `AGENTS.md`; `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  review after: 2026-07-01

- heuristic: Promote reusable agent-system improvements into `.agents/baselines/` and durable instruction rules into `AGENTS.md` or `.agents/skills/` instead of leaving them only in memory.
  applies to: agent-system maintenance
  source: `docs/11-ai/instruction-surface-separation.md`; `docs/10-runbooks/repo-local-agent-memory.md`
  canonical links: `docs/11-ai/instruction-surface-separation.md`; `docs/10-runbooks/repo-local-agent-memory.md`
  review after: 2026-07-01

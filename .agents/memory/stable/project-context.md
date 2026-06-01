# Project Context

Use this file for compact, non-canonical context summaries that help agents orient quickly without duplicating canonical docs.

## Format

For each entry, record:

- context
- scope
- source
- canonical links
- last verified

## Entries

- context: This repo is the canonical App 2.0 codebase and documentation system for replacing the customized Perfex 1.0 foundation over time.
  scope: repo identity
  source: `AGENTS.md`
  canonical links: `AGENTS.md`
  last verified: 2026-06-01

- context: Canonical system truth lives under `docs/`, active batch execution state lives under `docs/08-active/`, review-only governance artifacts live under `docs/11-ai/active-doc-reviews/`, and repo-local agent memory lives under `.agents/memory/`.
  scope: owner-path orientation
  source: `AGENTS.md`, `docs/11-ai/rules.md`, `docs/10-runbooks/repo-local-agent-memory.md`
  canonical links: `AGENTS.md`; `docs/11-ai/rules.md`; `docs/10-runbooks/repo-local-agent-memory.md`
  last verified: 2026-06-01

- context: The current execution model treats `main` as the integrator/publish branch and uses non-`main` branches for active writable work, with staging deploy/publish ownership serialized through the integrator lane.
  scope: git and deploy model
  source: `AGENTS.md`, `docs/10-runbooks/git-remote-and-multi-device-workflow.md`, `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  canonical links: `AGENTS.md`; `docs/10-runbooks/git-remote-and-multi-device-workflow.md`; `docs/10-runbooks/agent-sessions-and-parallel-work.md`
  last verified: 2026-06-01

- context: The repo now has a reusable exportable agent-memory starter pack under `.agents/baselines/repo-local-agent-memory/`, separate from the live installed memory lane.
  scope: agent-system packaging
  source: `docs/10-runbooks/repo-local-agent-memory.md`; `.agents/baselines/repo-local-agent-memory/README.md`
  canonical links: `docs/10-runbooks/repo-local-agent-memory.md`; `.agents/baselines/repo-local-agent-memory/README.md`
  last verified: 2026-06-01

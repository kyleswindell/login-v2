# Repo-Local Agent Memory Baseline

This package is the exportable starter kit for a repo-local, non-canonical, non-production-facing agent memory layer.

It is intentionally separate from any live installed `.agents/memory/` instance.

Use this package when another repo wants:

- durable agent memory outside canonical docs
- a lightweight Markdown-based memory layer
- repo-local skills for capturing and maintaining memory
- a repeatable starting point before any repo-specific memory is written

This package should stay generic. Live repo-specific memory belongs in the installed `.agents/memory/` instance after adoption, not back in this baseline pack.

## Direct Agent Entrypoint

If an import-repo agent should apply this starter pack, point it at:

- `AGENTS.md`

That file is the direct bootstrap entrypoint for installing and configuring the pack in the target repo.

## Package Contents

- `memory/`
  - starter folder structure
  - starter note files
  - configuration example
- `skills/`
  - `capture-agent-memory.md`
  - `maintain-agent-memory.md`
- `docs/10-runbooks/repo-local-agent-memory.md`
  - optional canonical runbook for repos that keep runbooks in `docs/`
- `snippets/`
  - AGENTS/rules/index snippets for quick integration
  - optional generic governance companions

## Recommended Companion Standards

These are small generic additions from this repo's working agent system that are useful in many repos:

- instruction-surface separation
- read-only-to-writable stop gate for shared worktrees
- concise adoption checklist before agents begin writing memory

They are recommended, not required, because some repos may already have equivalent governance.

## What This Baseline Is For

Use it for:

- operator preferences
- repo heuristics
- compact project context
- non-canonical open loops
- session continuity and handoffs

Do not use it for:

- canonical product or system truth
- active workflow state
- secrets, credentials, tokens, or raw sensitive production/customer data
- integration handoff artifacts that already have their own owner path

## Installation Steps

### Required

1. Copy `memory/` into the target repo as `.agents/memory/`.
2. Copy `skills/` into the target repo's `.agents/skills/`.
3. Review `memory/CONFIG.example.md` and create a repo-specific configuration note or equivalent local configuration in the target repo.
4. If the target repo uses an `AGENTS.md`, add the memory policy section from `snippets/AGENTS-repo-local-agent-memory.md` or adapt it into the repo's existing instruction model.
5. Replace placeholder terms such as:
   - `<canonical-docs-root>`
   - `<active-workspace-root>`
   - `<branch-handoff-root>`
   - `<review-ledger-root>`
   with real paths or explicit `none` values for that repo.

### Recommended

6. If the target repo uses AI-governance rules or runbooks under `docs/`, copy:
   - `docs/10-runbooks/repo-local-agent-memory.md`
   - the relevant snippets from `snippets/`
7. Add the optional companion snippets when the target repo does not already define them:
   - `snippets/AGENTS-instruction-surface-separation.md`
   - `snippets/AGENTS-read-only-to-writable-stop-gate.md`
   - `snippets/AI-governance-instruction-surface-policy.md`
8. Use `snippets/adoption-checklist.md` as the final preflight before agents begin writing memory.

## First Configuration Pass

Before agents start using the memory layer, configure these decisions in the target repo:

- canonical docs root
- active workflow state root, if any
- branch handoff root, if any
- review/governance artifact owner path, if any
- any repo-specific exclusions beyond the default sensitive-data rules

Then seed only a few high-signal notes:

- operator preferences
- project context
- repo heuristics

Do not pre-populate speculative or duplicated memory.

## Recommended Adoption Pattern

1. Install the baseline.
2. Add governance rules.
3. Create the repo-specific configuration mapping.
4. Run the adoption checklist.
5. Seed only stable memory first.
6. Add working/ephemeral memory only when real session continuity needs appear.

## Export Rule

Treat this package as the generic source.

Treat the live `.agents/memory/` installation in any repo as the configured instance.

Do not overwrite a live instance with the baseline blindly; merge intentionally.

If a live repo discovers a reusable improvement to the memory system itself, promote that improvement back into this baseline package rather than hiding it only in repo-local memory.

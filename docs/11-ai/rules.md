# AI Governance Rules

## Active Batch Workspace Policy

- `docs/08-active/` is a workflow-controlled execution workspace.
- `docs/08-active/` supports one active batch only.
- `docs/08-active/` is non-canonical and must not hold permanent history.
- After finalization, clear `docs/08-active/`.
- Archive completed batch artifacts only under `docs/11-ai/_archive/batches/`.
- Do not store or create historical archives inside `docs/08-active/`.

## Workflow Reference

- [Canonical Active Batch Workflow](../10-runbooks/batch-workflow.md)
- [Agent Instruction Surface Separation](instruction-surface-separation.md)
- [Repo-Local Agent Memory](../10-runbooks/repo-local-agent-memory.md)

## Instruction Surface Policy

- `AGENTS.md` owns persistent agent rules and operating boundaries.
- `.agents/skills/` owns executable workflow playbooks.
- canonical `docs/` owns durable product, architecture, planning, database, runbook, and review/governance truth.
- `.agents/memory/` owns non-canonical repo-local working memory only.
- `.agents/baselines/` owns exportable starter packs and must stay generic enough for reuse in other repos.
- If information becomes durable enough to outgrow memory, promote it into the correct owner surface instead of leaving it in `.agents/memory/`.

## Repo-Local Agent Memory Policy

- `.agents/memory/` is the canonical repo-local owner for non-canonical agent memory.
- That memory layer exists to support agent continuity and handoff; it does not replace canonical `docs/` ownership.
- Promote durable system truth into canonical `docs/` owners when the remembered information becomes a rules, behavior, structure, planning, database, or runbook fact.
- Promote durable repo-wide operating rules into `AGENTS.md`.
- Promote repeatable workflow behavior into the relevant `.agents/skills/` file.
- Promote reusable starter-pack improvements into `.agents/baselines/` instead of hiding them in repo-local memory.
- Keep `.agents/memory/` free of secrets, credentials, tokens, and production-sensitive raw data.
- Treat `.agents/memory/` as writable repo content: normal branch/worktree concurrency rules still apply.

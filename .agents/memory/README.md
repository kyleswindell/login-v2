# Repo-Local Agent Memory

This directory holds repo-local, non-canonical, non-production-facing memory for agent continuity.

For the exportable starter pack, use:

- [repo-local-agent-memory baseline](../baselines/repo-local-agent-memory/README.md)

Use it for:

- operator preferences
- repo heuristics
- compressed project context
- non-canonical open loops
- temporary session continuity

Do not use it for:

- canonical truth that belongs in `docs/`
- active batch state that belongs in `docs/08-active/`
- branch integration handoffs that belong in `.agents/batch-branch-handoffs/`
- secrets, credentials, tokens, or raw sensitive production/customer data

## Layout

- `stable/`
- `working/`
- `ephemeral/`

## Working Rules

- prefer updating an existing note over creating a duplicate
- keep notes concise and scannable
- promote durable truth into canonical `docs/` owners
- prune stale working and ephemeral memory regularly

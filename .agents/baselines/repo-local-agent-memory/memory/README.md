# Repo-Local Agent Memory

This directory is the installed agent-memory lane for a target repo.

It is non-canonical and non-production-facing.

Use it for:

- operator preferences
- repo heuristics
- compressed project context
- non-canonical open loops
- temporary session continuity

Do not use it for:

- canonical truth that belongs in `<canonical-docs-root>`
- active workflow state that belongs in `<active-workspace-root>`
- branch integration handoffs that belong in `<branch-handoff-root>`
- secrets, credentials, tokens, or raw sensitive production/customer data

## Layout

- `CONFIG.example.md`
- `stable/`
- `working/`
- `ephemeral/`

## Working Rules

- prefer updating an existing note over creating a duplicate
- keep notes concise and scannable
- promote durable truth into canonical owners
- promote durable agent rules, workflow behavior, and reusable starter-pack improvements into the correct instruction owner instead of leaving them in memory
- prune stale working and ephemeral memory regularly

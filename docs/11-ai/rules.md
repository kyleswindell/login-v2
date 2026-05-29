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

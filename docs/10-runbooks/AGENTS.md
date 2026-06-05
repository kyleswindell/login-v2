# docs/10-runbooks AGENTS.md

## Purpose

Operations only. This branch owns runbooks, deployment steps, local-dev procedures, workflow operations, and repeatable execution guidance.

## Read Order

1. Read `index.md`.
2. Open only the runbook for the operation being performed.
3. For batch work, use `batch-workflow.md`, then the matching child file under `batch-workflow/`, plus the specific git/deploy runbook required by the current workflow state.
4. For active-batch commit questions, use `git-batch-commit-workflow.md`, then the matching child file under `git-batch-commit-workflow/`.
5. For local-review commit timing, use `local-dev.md`, `batch-workflow/commit-and-deployment.md`, and `git-batch-commit-workflow/commit-checkpoints.md`.
6. For prompt scope, read budgets, or long-file context control, use `agent-token-efficiency.md`.

## Avoid

- Do not read every runbook before implementation.
- Do not store product behavior, architecture, or schema truth here.
- Do not improvise deployment or external-state actions outside the documented runbook.
- Do not push implementation iterations when local review can answer the question.

## Long Files

- `agent-sessions-and-parallel-work.md` is governance-heavy. Open it for concurrency, ownership, or worktree questions only.
- `batch-workflow.md` is the workflow hub. Use its read path instead of opening every child runbook.
- `agent-token-efficiency.md` owns read-budget and workflow-prompt controls. Use it before broad searches or long-file loads.

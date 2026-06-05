# Generate Batch Work Prompt

Generate a paste-ready prompt for the next active-batch `work-batch` pass.

## Required Prompt Contract

The generated prompt must include:

- exact workflow name: `work-batch`
- target ID(s): targeted CQ IDs or base batch task
- allowed file scope
- required read path
- stop condition
- validation path

Use `docs/10-runbooks/agent-token-efficiency.md` for read-budget rules.

## Read Scope

Read only:

- `/docs/08-active/batch.md`
- `/docs/08-active/checklist.md`
- `/docs/08-active/change-queue.md`
- `/docs/08-active/review.md`
- `/docs/08-active/notes.md`
- `/docs/08-active/worklogs/index.md`
- targeted prior worklogs only when needed
- `docs/10-runbooks/git-batch-commit-workflow.md` only when commit guidance is relevant

Do not modify files.

## Prompt Selection Rules

- Continue unfinished `In Progress` items before new `Ready To Implement` items.
- Refer to queue items by stable `ID:` lines.
- Group tightly coupled CQ items only when they share the same concern and review surface.
- Exclude deferred, passed, blocked, or review-only decision items.
- Include commit/push/deploy instructions only when the pass should end with a reviewable surface that requires them.

## Stop Conditions

Stop instead of generating a prompt if:

- no active batch is loaded
- there is no actionable implementation work
- state is incomplete or contradictory
- the next action is a review-only or standards decision
- the required read path would become a broad repo audit

## Output Format

Return:

### Prompt

Plain text beginning with:

```text
Goal: <short goal>

Execute the Work Batch workflow for the active batch.
```

The prompt must include `Target IDs`, `Allowed file scope`, `Required read path`, `Stop condition`, `Validation path`, `Rules`, and `Output`.

### Rationale

Briefly state why these items were selected and whether commit/deploy was included.

### Deferred Items

List intentionally excluded queue items and why.

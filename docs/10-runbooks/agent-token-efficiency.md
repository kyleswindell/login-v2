# Agent Token Efficiency

This runbook defines operational controls for reducing avoidable agent context usage during development and review.

## Purpose

Keep agent work scoped, reviewable, and easy to resume without loading broad repo context.

## Workflow Prompt Contract

Every workflow prompt should declare:

- exact workflow name
- target ID, such as a CQ, doc-review, doc-sync, or named file set
- allowed file scope
- required read path
- stop condition
- validation path

If any field is unknown and cannot be discovered from the repo, stop before implementation and narrow the task.

## Read Budgets

Use the smallest read path that can answer the task.

### Active Batch Work

Read:

- nearest `AGENTS.md`
- the named workflow skill
- `/docs/08-active/batch.md`
- targeted sections of `change-queue.md`, `notes.md`, `review.md`, and `worklogs/index.md`
- directly affected code/docs

Avoid reading all active worklogs unless the targeted CQ item requires prior pass history.

### Manual Review Status Updates

Read:

- active review feedback
- targeted CQ sections
- current `review.md`
- current `notes.md` only if needed for state context

Do not load canonical docs unless the review finding questions the canonical rule itself.

### Documentation Review

Read:

- the target doc or tightly related doc set
- nearest `AGENTS.md`
- applicable standards or benchmark
- the active review ledger

Do not audit a whole branch in one pass unless the user explicitly asks for a branch-wide review.

### Documentation Sync

Read:

- the implementation area named by the review
- the canonical docs that own that implementation truth
- parent planning/status docs only when the reviewed implementation changed planning truth

Do not rewrite canonical docs during the review step.

### UI And Frontend Work

Read:

- `resources/AGENTS.md`
- the exact Blade component, view, JS module, or CSS section
- the matching UI tier contract or standards doc

Use `rg` and section comments before opening long assets.

## Long-File Handling

- Prefer section searches and small line reads before opening files over 500 lines.
- Split files when one file owns unrelated reasons to change and repeated broad reads are recurring.
- Add or update nearest `AGENTS.md` read maps when a large file must remain monolithic.
- Keep active audit documents intact while their batch is open unless a CQ-specific extraction directly improves implementation.

## Observation Artifact

Use `.agents/memory/working/token-usage-observations.md` for recurring high-cost patterns. Promote durable rules into `AGENTS.md`, `.agents/skills/`, or canonical runbooks instead of leaving them only in memory.

## Related

- [Agent Sessions And Parallel Work](agent-sessions-and-parallel-work.md)
- [Repo-Local Agent Memory](repo-local-agent-memory.md)
- [Batch Workflow](batch-workflow.md)

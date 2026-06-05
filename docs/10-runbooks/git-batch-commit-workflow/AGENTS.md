# docs/10-runbooks/git-batch-commit-workflow AGENTS.md

## Purpose

Focused commit, push, and git hygiene details for active-batch execution.

## Read Order

1. Start with `../git-batch-commit-workflow.md` for core commit scope rules.
2. Open only the child file matching the current git action:
   - `commit-checkpoints.md` for batch lifecycle commit timing.
   - `push-and-parallel-branches.md` for push timing, worker commits, and integrator commits.
   - `scope-hygiene-and-stop-conditions.md` for staged-file checks, message patterns, and stop rules.
3. Cross-check `../batch-workflow.md` only when the batch workflow state is unclear.

## Avoid

- Do not read every child file for a simple commit-scope check.
- Do not mix non-batch commit guidance into this active-batch workflow.
- Do not stage, commit, push, or deploy from this documentation pass unless explicitly requested.

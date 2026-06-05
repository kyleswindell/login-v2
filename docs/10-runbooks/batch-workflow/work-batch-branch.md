# Batch Workflow - Work Batch Branch

[Back to Batch Workflow](../batch-workflow.md)

### 2A. Work Batch Branch

Workflow entry point:
- `work-batch-branch`

Responsibilities:
- implement one targeted queue item on a dedicated branch and worktree
- keep commit scope to that queue item and one concern
- create or update the branch handoff artifact under `.agents/batch-branch-handoffs/`
- record validation, files changed, and branch/commit status for the integrator

Rules:
- do not update `/docs/08-active/` directly
- do not move queue items between active-workspace sections from a worker branch
- do not claim more than one queue item at a time per worker branch
- if additional findings appear, record them in the handoff or chat for integrator normalization instead of editing the shared queue
- publish enough branch state that the integrator can merge or cherry-pick without re-discovering scope

---

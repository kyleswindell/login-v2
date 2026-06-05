# Batch Workflow - Review And Finalize Batch

[Back to Batch Workflow](../batch-workflow.md)

### 5. Review and Finalize Batch

Workflow entry point:
- `batch-review-and-finalize`

Conditions:
- all checklist items complete
- no open issues
- manual review = PASS
- functional review = PASS

Actions:
- commit final state
- archive /`docs/08-active/` to:
  `/docs/11-ai/_archive/batches/<date-name>/`
- reset `/docs/08-active/`

Boundary:
- this step closes the active batch workspace only
- if the reviewed batch changes parent planning truth outside `/docs/08-active/`, do not expand `batch-review-and-finalize` to edit those docs directly
- instead, hand off immediately to the scoped docs sync workflow:
  - `review-docs-sync`
  - `implement-docs-sync-fix`
- common parent planning sync targets include:
  - the current phase index
  - parent phase planning notes
  - deferment or forward-planning notes
  - roadmap status summaries when the batch materially changed phase progress

---

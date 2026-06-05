# Batch Workflow - Manual Review

[Back to Batch Workflow](../batch-workflow.md)

### 3. Manual Review

Workflow entry point:
- `batch-update-manual-review-status`

Responsibilities:
- process human review input
- move `change-queue.md` items through the review lifecycle
- update review.md
- update checklist.md (`passed review` checkbox authority)
- confirm which items require additional work

Rules:
- classify each review finding before changing queue state:
  - existing item confirmed
  - existing item failed
  - new finding
- when the user provides clear manual-review feedback that can be mapped safely, that feedback is sufficient authorization to execute `batch-update-manual-review-status`; do not require an extra confirmation step just because `/docs/08-active/` will be updated
- `Implemented Pending Review` assumes the relevant implementation is already deployed to the review surface when deployment is required
- local-development review feedback may confirm unpushed work, but do not move that work to `Passed Review` unless the accepted implementation already has a scoped commit or the implementation owner first creates that commit through the appropriate work path
- treat exploratory chat or review commentary as source material, not as queue-ready text
- normalize new findings into concise implementation-ready queue language before writing them into `change-queue.md`
- preserve existing `ID:` lines for mapped items
- assign the next sequential queue ID when a truly new queue item is created
- if queue IDs consumed by the temporary active-batch UI Reference review overlay changed, regenerate the derived runtime manifest in the same workflow step so the runtime review surface stays aligned with the canonical queue
- do not reopen an `Implemented Pending Review` item unless the review evidence directly maps to that same item's scoped implemented outcome
- if the review reveals a separate gap on an uncovered path, keep the existing item pending review and open a new `Ready To Implement` item for the uncovered gap
- if an item is known to be undeployed on the required review surface, do not process it as pending review until that deploy gap is resolved
- if a locally reviewed item is accepted but remains uncommitted, stop before the pass transition and require the scoped implementation commit first
- stop only when the review input is ambiguous, cannot be mapped safely, or requires a new decision about how the finding should be represented

---

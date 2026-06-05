# Batch Workflow - Work Batch

[Back to Batch Workflow](../batch-workflow.md)

### 2. Work Batch

Workflow entry point:
- `work-batch`

Responsibilities:
- execute scoped implementation
- create a new worklog file
- update worklog index
- update notes.md
- annotate checklist.md (not complete)
- update review.md with factual status only
- commit accepted local-review work before it can be marked passed review
- commit/push/deploy when the pass is review-ready and manual visual review requires a shared surface

Rules:
- do not expand scope
- set checklist `Status` only
- do not mark checklist items complete
- do not finalize batch
- if the pass builds Tier 2 patterns or feature UI from existing Tier 1 work, complete a Tier 1 consumption preflight before coding
- treat `In Progress` as the explicit claim marker for the currently targeted queue item
- if a prior pass left a queue item in `In Progress`, continue or explicitly reclassify that item before selecting a new `Ready To Implement` item
- when multiple queue items are handled in one pass, claim and complete them sequentially; do not move a second independently tracked item into `In Progress` until the current one reaches an outcome state
- when multiple queue items are handled in one pass, record the targeted queue IDs, grouping rationale, affected files by item or tightly coupled group, validation performed, and review surface in the worklog
- for shared UI or system surfaces, identify the relevant render/update paths before calling the pass review-ready
- examples of parallel paths include:
  - server-rendered markup
  - realtime or client-injected markup
  - toast or overlay variants
  - full-index or detail views for the same system
- if one of those paths is intentionally not updated in the pass, record it explicitly as a follow-up item instead of implying full surface completion
- preserve existing `ID:` lines when moving items between sections
- preserve existing queue metadata lines when moving items between sections
- assign the next sequential queue ID when a new active queue item is created and no stable ID already exists
- add or update `Implemented in:` when that improves traceability for a targeted item
- if the pass changes queue IDs consumed by the temporary active-batch UI Reference review overlay, regenerate the derived runtime manifest from the current queue state before the pass is considered review-ready
- if local development is the review surface, the item can be reviewable before push or deploy, but accepted work must be committed before it is marked passed review
- if a targeted item needs staging or another deploy-backed review surface, treat deploy completion as part of the implementation outcome before moving that item into `Implemented Pending Review`

Tier 1 consumption preflight:
- identify the exact Tier 1 building blocks the pass depends on
- name whether each one is consumed as:
  - `Blade component`
  - `Class/markup contract`
  - `Hybrid`
- confirm the canonical entry point is explicit in current standards/reference material
- if the needed Tier 1 item is represented only by demo-only snapshot markup or otherwise has a `Missing abstraction`, stop and record the gap instead of improvising a Tier 2 or feature-level substitute

---

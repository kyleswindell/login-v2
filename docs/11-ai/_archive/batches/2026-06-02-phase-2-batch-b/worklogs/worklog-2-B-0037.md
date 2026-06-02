# Worklog 2-B-0037

## Prompt Summary

Record the latest Layout + Dashboard staging review feedback: dashboard-associated layout saving works, drag/move sorting with preview works, and `P2-B-CQ-019` is approved for full main-content width, but multi-row widget height, widget header/body proof content, and default card color treatments still require fixes.

## Scope

- manual-review state refinement for `P2-B-CQ-018`
- partial manual-review approval and refinement for `P2-B-CQ-019`
- manual-review state refinement for `P2-B-CQ-020`
- active batch queue/review/notes/checklist/worklog reconciliation

## Files Changed

- `docs/08-active/change-queue.md`
- `docs/08-active/checklist.md`
- `docs/08-active/notes.md`
- `docs/08-active/review.md`
- `docs/08-active/worklogs/index.md`
- `docs/08-active/worklogs/worklog-2-B-0037.md`

## Work Completed

- reopened `P2-B-CQ-018` as a same-item failure because two-row widget spans can still collapse or be cut off when another widget occupies the space below
- reopened `P2-B-CQ-019` as a partial approval:
  - approved dashboard-associated layout save behavior
  - approved drag/move sorting with preview behavior
  - approved full main-content-width dashboard layout composition
  - kept the item open for widget examples that include both header/title and body/supporting content
- reopened `P2-B-CQ-020` as a same-item failure because Layout + Dashboard widget cards, saved-layout preview cards, and supporting info cards still use non-standard color treatments instead of the default light/dark shared card pattern
- updated the dashboard checklist status to reflect that review fixes are queued before this area can close

## Checklist Impact

- `Dashboard And Summary Conventions` moved from complete to review-fixes queued while `P2-B-CQ-018`, `P2-B-CQ-019`, and `P2-B-CQ-020` remain open

## Change Queue Impact

- `P2-B-CQ-018` moved from `Implemented Pending Review` back to `Ready To Implement`
- `P2-B-CQ-019` moved from `Implemented Pending Review` back to `Ready To Implement`
- `P2-B-CQ-020` moved from `Implemented Pending Review` back to `Ready To Implement`
- `P2-B-CQ-013` remains `Implemented Pending Review`
- `P2-B-CQ-015` remains `Implemented Pending Review`

## Issues Found

- the current Layout + Dashboard proof still does not guarantee true two-row widget occupancy for `1x2`, `2x2`, and equivalent taller widgets
- the current dashboard customization proof needs complete header/body widget content examples before `P2-B-CQ-019` can fully pass
- the current widget/support-card color treatment still overuses special colors where the default shared card palette should apply

## Deferred Items

- implementation of reopened `P2-B-CQ-018`
- implementation of reopened `P2-B-CQ-019`
- implementation of reopened `P2-B-CQ-020`
- targeted staging review of `P2-B-CQ-013`
- targeted staging review of `P2-B-CQ-015`

## Commit / Deploy Status

- Commit: Yes; scoped review-state update recorded on `main`
- Deploy: No; docs-only review-state update

## Notes

- No new change-queue item was created because the feedback maps directly to the existing dashboard row-span, dashboard customization proof, and widget/support-card palette items.

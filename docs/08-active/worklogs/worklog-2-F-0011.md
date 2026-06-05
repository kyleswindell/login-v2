# Worklog 2-F-0011

## Prompt Summary

Conduct a sequential `work-batch` pass on P2-F-CQ-008 before moving to the remaining requested Batch F queue items.

## Scope

- Phase 2 Batch F.
- Target queue item: P2-F-CQ-008 - Usage guidance standards for button variants and action labels.
- Establish Login App 2.0-specific button variant and action-label guidance in the UI Reference without changing runtime behavior or visual tokens.

## Files Changed

| File | Change |
| --- | --- |
| `resources/views/platform/ui-reference/components/actions.blade.php` | Added button variant selection and action-label guidance with P2-F-CQ-008, G-ACT-01 through G-ACT-05, and G-LABEL-01 through G-LABEL-06 markers. |
| `resources/views/platform/ui-reference/patterns/navigation.blade.php` | Added page action hierarchy and label usage guidance for page title rows, filter rows, completion verbs, and destructive grouped actions. |
| `tests/Feature/Platform/PlatformUiReferenceTest.php` | Added focused route assertions for P2-F-CQ-008 guidance markers and key wording. |
| `docs/08-active/change-queue.md` | Moved P2-F-CQ-008 from Ready To Implement through In Progress to Implemented Pending Review. |
| `docs/08-active/checklist.md` | Marked button/action-label usage guidance bullets as implemented pending review. |
| `docs/08-active/notes.md` | Updated current Batch F state and guidance boundaries for P2-F-CQ-008. |
| `docs/08-active/review.md` | Added P2-F-CQ-008 pending-review state and validation note. |
| `docs/08-active/worklogs/index.md` | Added worklog 2-F-0011. |
| `docs/08-active/worklogs/worklog-2-F-0011.md` | Created this worklog. |

## Targeted Change Queue IDs

- P2-F-CQ-008.

## Queue Item Grouping Rationale

Only P2-F-CQ-008 was targeted. Notification/badge guidance remains in P2-F-CQ-009, form/selection guidance remains in P2-F-CQ-010, and broader data/navigation/overlay/loading guidance remains in P2-F-CQ-011.

## Work Completed

- Documented Login App 2.0 button variant selection rules:
  - G-ACT-01 one primary action per page, modal, card region, or form action row
  - G-ACT-02 standard filled treatment
  - G-ACT-03 soft treatment
  - G-ACT-04 ghost and outline treatment
  - G-ACT-05 destructive danger treatment
- Documented action-label usage rules:
  - G-LABEL-01 Apply
  - G-LABEL-02 Save
  - G-LABEL-03 Create / Submit / Send
  - G-LABEL-04 Cancel / Close
  - G-LABEL-05 Reset / Clear
  - G-LABEL-06 destructive verbs
- Added navigation-surface guidance for page title action hierarchy, filter-row Apply behavior, completion verbs, and destructive grouped-action labels.

## Checklist Impact

- Design-System Usage Guidance remains partially implemented.
- Button variant, common action-label, and form action-label checklist bullets are implemented pending review.

## Change Queue Impact

- P2-F-CQ-008 moved to Implemented Pending Review.
- P2-F-CQ-009, P2-F-CQ-010, and P2-F-CQ-011 remain Ready To Implement.

## Validation Performed

- Passed: `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=button_variant`.

## Review Surface

Local development working tree and Docker test environment. Staging deploy remains out of scope for Batch F.

## Issues Found

- Pre-existing dirty working tree entries were present before this pass:
  - `docs/08-active/worklogs/worklog-2-F-0006.md`
  - `storage/review.sqlite`
- They were not touched or included in this queue item.

## Deferred Items

- P2-F-CQ-009 still owns notification, badge, and feedback guidance.
- P2-F-CQ-010 still owns form field and selection-control guidance.
- P2-F-CQ-011 still owns the broader data, navigation, overlay, loading, input, breadcrumb, structured-list, file-uploader, date-picker, grid, and tile guidance gaps.

## Commit / Deploy Status

- Commit: pending scoped batch checkpoint.
- Push: not performed.
- Deploy: not performed; staging deploy remains out of scope for Batch F.

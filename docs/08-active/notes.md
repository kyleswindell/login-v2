# Notes

## Current Batch F State

- Batch F remains active for Phase 2 starter-proof implementation. It is not ready for finalization because active queue items remain.
- Staging deploy is explicitly out of scope for Batch F and remains disabled pending security incident review.
- P2-F-CQ-001 is Passed Review. The Carbon contrast audit, starter catalog matrix, and route disposition matrix are accepted as sufficient routing source material for the remaining Batch F work.
- P2-F-CQ-007 is Passed Review. `/platform/ui-reference/patterns/starters` is the accepted UI Reference starter catalog entry point.
- Remaining Ready To Implement items are P2-F-CQ-002, P2-F-CQ-003, P2-F-CQ-004, P2-F-CQ-005, P2-F-CQ-006, P2-F-CQ-008, P2-F-CQ-009, P2-F-CQ-010, P2-F-CQ-011, P2-F-CQ-012, and P2-F-CQ-013.
- Detailed correction history for P2-F-CQ-001 and P2-F-CQ-007 is preserved in worklog-2-F-0002 through worklog-2-F-0008. Do not duplicate that history in active notes.

## Current Implementation Guidance

- Use existing Tier 1 primitives and Tier 2 patterns.
- Keep starter examples reusable and generic.
- Normalize existing proof surfaces only where needed to demonstrate the starter contract.
- Do not expand account, notifications, customer/public, or module-specific behavior.
- Carbon remains a documentation-depth and completeness benchmark only. Do not visually copy IBM software or replace the existing Login App 2.0 visual direction.
- Translate audit findings into Login App 2.0-specific standards, examples, classes, ready-to-use components, component sets, and starter views.
- P2-F-CQ-008 is scoped to button variant and action-label guidance only.
- P2-F-CQ-009 owns notification, badge, and feedback guidance.
- P2-F-CQ-010 owns form field standards and selection control guidance.
- P2-F-CQ-011 owns the remaining 32 audit-routed usage guidance gaps across data display, navigation, overlays, loading, inputs, breadcrumb, structured list, file uploader, date picker, grid, and tile.
- P2-F-CQ-012 owns UI control module cleanup only where it supports Batch F form/selection/table/search/dropdown/filter guidance.
- P2-F-CQ-013 owns CSS section ownership/read-path cleanup and one safe extraction boundary only if the build and visual contracts stay stable.

## Current Risks And Follow-Ups

- The previously noted widget-content `data-ui-pattern="dashboard-grid"` validation gap has been stabilized in the token/SOLID cleanup validation pass. Future Batch F work should keep that route covered by focused UI Reference tests.
- SettingsController update-flow extraction and realtime notification transport/rendering cleanup are deferred out of Batch F unless the current UI starter/guidance work exposes a direct blocker.
- Future work passes should read the targeted queue item first, then open only the specific source/reference files needed for that item.
- Worklogs remain the immutable history location for detailed pass notes, failed review attempts, and correction narratives.

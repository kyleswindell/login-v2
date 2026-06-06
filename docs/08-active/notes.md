# Notes

## Current Batch F State

- Batch F remains active for Phase 2 starter-proof implementation. It is not ready for finalization because active queue items remain.
- Staging deploy is explicitly out of scope for Batch F and remains disabled pending security incident review.
- P2-F-CQ-001 is Passed Review. The Carbon contrast audit, starter catalog matrix, and route disposition matrix are accepted as sufficient routing source material for the remaining Batch F work.
- P2-F-CQ-007 is Passed Review. `/platform/ui-reference/patterns/starters` is the accepted UI Reference starter catalog entry point.
- Remaining Ready To Implement items are P2-F-CQ-002, P2-F-CQ-003, P2-F-CQ-004, P2-F-CQ-005, and P2-F-CQ-006.
- P2-F-CQ-008, P2-F-CQ-009, P2-F-CQ-010, and P2-F-CQ-011 are Passed Review as of 2026-06-06. Correction pass 2-F-0015 was accepted, with follow-up scope normalized into P2-F-CQ-016 through P2-F-CQ-024.
- P2-F-CQ-016 through P2-F-CQ-024 are Implemented Pending Review. Worklog 2-F-0016 added the Carbon-aligned component inventory, T1 component catalog/sidebar, generated component routes, component-specific pages, focused high-risk state matrices, and automated coverage.
- P2-F-CQ-012 is Implemented Pending Review. UI control behavior is split into form/selection, table/search/filter, dropdown, and theme modules while preserving the `resources/js/ui-controls.js` export surface and `resources/js/app.js` lifecycle registration.
- P2-F-CQ-013 is Implemented Pending Review. `resources/css/app.css` now has a concrete UI ownership map, `resources/css/AGENTS.md` points future CSS work to targeted sections, and the Tailwind theme seed block is extracted to `resources/css/ui/theme-seed.css`.
- Detailed correction history for P2-F-CQ-001 and P2-F-CQ-007 is preserved in worklog-2-F-0002 through worklog-2-F-0008. Do not duplicate that history in active notes.

## Current Implementation Guidance

- Use existing Tier 1 primitives and Tier 2 patterns.
- Keep starter examples reusable and generic.
- Normalize existing proof surfaces only where needed to demonstrate the starter contract.
- Do not expand account, notifications, customer/public, or module-specific behavior.
- Carbon remains a documentation-depth and completeness benchmark only. Do not visually copy IBM software or replace the existing Login App 2.0 visual direction.
- Translate audit findings into Login App 2.0-specific standards, examples, classes, ready-to-use components, component sets, and starter views.
- P2-F-CQ-016 through P2-F-CQ-024 own the component-specific T1 realignment requested after P2-F-CQ-008 through P2-F-CQ-011 passed review. Treat the catalog as the owner for T1 component dispositions, routes, and primary review surfaces.
- Keep examples within existing Login App 2.0 visual direction. Do not create reference photo examples, broad accessibility test suites, Carbon visual token adoption, or unrelated runtime feature expansion.
- Installation/implementation guidance means local component usage guidance: component names, props/attributes, required classes/wrappers, data attributes, owner routes, and expected usage boundaries.
- P2-F-CQ-012 owns UI control module cleanup only where it supports Batch F form/selection/table/search/dropdown/filter guidance. The implementation is pending local review and should remain behavior-preserving.
- P2-F-CQ-013 owns CSS section ownership/read-path cleanup and one safe extraction boundary only if the build and visual contracts stay stable. The implementation is pending local review and should remain token-preserving.

## Current Risks And Follow-Ups

- The previously noted widget-content `data-ui-pattern="dashboard-grid"` validation gap has been stabilized in the token/SOLID cleanup validation pass. Future Batch F work should keep that route covered by focused UI Reference tests.
- SettingsController update-flow extraction and realtime notification transport/rendering cleanup are deferred out of Batch F unless the current UI starter/guidance work exposes a direct blocker.
- Future work passes should read the targeted queue item first, then open only the specific source/reference files needed for that item.
- Manual review should now focus on whether P2-F-CQ-016 through P2-F-CQ-024 provide a sufficiently organized component-specific T1 library and whether any generated component pages need deeper concrete examples before the remaining starter work resumes.
- Worklogs remain the immutable history location for detailed pass notes, failed review attempts, and correction narratives.

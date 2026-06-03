# Change Queue

This queue is agent-managed and implementation-ready. It is not a scratchpad.
- Exploratory review discussion stays in chat until normalized into concise queue language.
- Active queue items use stable IDs in the format `P<phase>-<batch>-CQ-###` (e.g. `P2-F-CQ-001`).
- `In Progress` marks the queue item currently claimed by the writable `work-batch` owner.
- An unfinished `In Progress` item must be continued or explicitly reclassified before a new `Ready To Implement` item is claimed.

## Ready To Implement

### P2-F-CQ-001 - Carbon contrast audit and starter catalog matrix
- Status: Ready To Implement
- Owner: Batch F
- Scope: Third correction pass. Six required coverage areas still missing (breadcrumbs, structured list, file uploader, date picker, layout/grid, tile/card). Carbon main repo evidence overstated — claim "no supplemental consumer guidance" made based on directory listing only, not actual file inspection. Gap count inconsistent (acceptance table says 47; routing table has 50). Skeleton Loader follow-up incorrectly routed to P2-F-CQ-008 in matrix. review.md stale.
- Acceptance:
  - audit includes sections for all six previously missing areas: breadcrumbs, structured list, file uploader, date picker, layout/grid, tile/card
  - Carbon main repo claim is accurate and defensible — either concrete file paths inspected, or claim softened to match actual inspection depth
  - gap total is internally consistent across acceptance table, routing summary, worklog, and notes
  - Skeleton Loader routing in Starter Catalog Matrix corrected to P2-F-CQ-011 (not P2-F-CQ-008)
  - review.md reflects current third review failure, corrective pass outcome, and updated queue list
- Implemented in: worklog-2-F-0002 (initial); worklog-2-F-0003 (correction pass 1); worklog-2-F-0004 (correction pass 2 — depth); worklog-2-F-0005 (correction pass 3 — missing areas + evidence fix)

### P2-F-CQ-007 - UI Reference starter catalog entry point
- Status: Ready To Implement
- Owner: Batch F
- Scope: Add or expand the UI Reference starter/archetype surface so future agents can intentionally locate complete starter-page examples.
- Acceptance:
  - starter catalog entry is visible from UI Reference navigation
  - route and tests identify starter examples intentionally
  - starter content is concrete page composition, not only summary rules

### P2-F-CQ-002 - Module home and dashboard summary starters
- Status: Ready To Implement
- Owner: Batch F
- Scope: Provide starter examples for module home / overview, dashboard/module summary surfaces, and dashboard widget examples by module content type.
- Acceptance:
  - module home starter includes page title/actions, summary content, primary content section, and empty/next-action state
  - dashboard/module summary starter uses dashboard grid, widget shell, and stat-card conventions
  - widget starter examples cover approved content-type examples without introducing feature-specific workflows

### P2-F-CQ-003 - Settings and setup starters
- Status: Ready To Implement
- Owner: Batch F
- Scope: Provide complete settings and setup/configuration starter examples and normalize proof surfaces only where needed for starter parity.
- Acceptance:
  - settings starter includes title/actions, settings navigation, form sections, validation placement, and form actions
  - setup starter includes task-oriented setup framing, setup navigation or peer-entry structure, and registration/config sections
  - touched setup/settings proof surfaces preserve existing feature behavior

### P2-F-CQ-004 - Account/profile starters
- Status: Ready To Implement
- Owner: Batch F
- Scope: Provide account/profile read-only and editable starter examples using the existing account proof surfaces and UI Reference catalog.
- Acceptance:
  - read-only account starter uses identity summary and key-value detail
  - editable account starter uses settings-style form scaffolding
  - account feature behavior remains out of scope

### P2-F-CQ-005 - List, detail, and create/edit starters
- Status: Ready To Implement
- Owner: Batch F
- Scope: Provide starter examples for list/index, table-management index, operational log/detail, content browser/split-view, detail/read-only, create/edit form, and blocked/empty/unavailable page states.
- Acceptance:
  - list/index starter includes page title/actions, search/filter, table or list content, and empty state
  - table-management index starter includes filters, row actions, and empty/bulk-action posture where applicable
  - operational log/detail starter demonstrates diagnostic read-only hierarchy
  - content browser/split-view starter demonstrates list/detail browsing structure
  - detail/read-only starter includes section blocks, key-value detail, and action placement
  - create/edit starter includes form sections, validation summary, field grouping, and form actions
  - blocked/empty/unavailable state starter demonstrates permission-blocked, no-data, and unavailable patterns without feature-specific behavior

### P2-F-CQ-008 - Usage guidance standards for button variants and action labels
- Status: Ready To Implement
- Owner: Batch F
- Scope: Establish UI Reference guidance for button variant selection and action label standards. Scope narrowed from original CQ-008 — notification/badge guidance split to P2-F-CQ-009; form/selection guidance split to P2-F-CQ-010; data display/overlay/loading/input guidance split to P2-F-CQ-011.
- Acceptance:
  - guidance is Login App 2.0-specific and preserves the existing visual direction
  - standard, soft, ghost, outline, and destructive button usage rules are explicit (G-ACT-01–05)
  - form action labels distinguish apply/stay-on-page behavior from submit/complete/return behavior (G-LABEL-01–06)
  - per-page "one primary action" rule is documented

### P2-F-CQ-009 - Usage guidance for notifications, badges, and feedback
- Status: Ready To Implement
- Owner: Batch F
- Scope: Establish UI Reference guidance for notification type selection, badge/tag usage, and AJAX/toast feedback patterns. Split from original P2-F-CQ-008 scope.
- Acceptance:
  - inline alert vs toast vs callout/banner selection rule is explicit (G-NOTIF-01–05)
  - badge color semantic mapping is documented (G-BADGE-01–04)
  - multi-notification stacking and placement rules are covered
  - guidance is Login App 2.0-specific and does not adopt Carbon visual tokens

### P2-F-CQ-010 - Usage guidance for form field standards and selection controls
- Status: Ready To Implement
- Owner: Batch F
- Scope: Establish UI Reference guidance for form field composition, required/optional marking, validation trigger timing, and selection control choice rules. Split from original P2-F-CQ-008 scope.
- Acceptance:
  - required vs optional field marking policy is documented (G-FORM-01–04)
  - checkbox vs radio vs toggle selection boundary is explicit (G-SEL-01–03)
  - select vs combo box vs multi-select selection rule is documented
  - warning field state is covered alongside error and disabled states

### P2-F-CQ-011 - Usage guidance for data display, navigation, overlays, loading, and inputs
- Status: Ready To Implement
- Owner: Batch F
- Scope: Establish UI Reference guidance for the areas identified in the expanded Carbon audit coverage pass: data table variants and toolbar rules; pagination variant selection; tabs variant selection; modal variant and focus-trap requirements; tooltip vs toggletip boundary; loading indicator vs skeleton selection; search scope placement; dropdown/fluid style selection; overflow menu threshold. New gaps G-TABLE-01–03, G-PAGIN-01–02, G-TABS-01–02, G-MODAL-01–03, G-TOOLTIP-01–02, G-LOAD-01–02, G-SEARCH-01–02, G-INPUT-01–02, G-OVERFLOW-01–02 all route to this item.
- Acceptance:
  - data table variant selection rule (basic/selectable/expandable) is documented
  - inline icon button vs overflow menu threshold rule is explicit
  - pagination vs pagination-nav variant selection rule is documented
  - line vs contained vs vertical tab variant selection rule is documented
  - modal variant selection rule (passive/transactional/danger/acknowledgment/progress) is documented
  - focus-trap accessibility requirement for modals is documented
  - tooltip vs toggletip usage boundary is explicit
  - loading spinner vs skeleton selection rule is documented
  - search scope (global/page/component) placement guidance is explicit
  - overflow menu destructive action placement rule is documented

### P2-F-CQ-006 - Batch F docs, tests, and handoff readiness
- Status: Ready To Implement
- Owner: Batch F
- Scope: Add automated coverage and synchronize planning/handoff notes after starter implementation.
- Acceptance:
  - tests verify starter routes and required markers
  - Phase 2 docs reflect Batch F implementation status
  - Batch E remains the post-F close-out path and staging deploy remains out of scope

## In Progress

<!-- none -->

## Implemented Pending Review

### P2-F-CQ-001 - Carbon contrast audit and starter catalog matrix
- Status: Implemented Pending Review
- Owner: Batch F
- Scope: Third correction pass complete. Six new areas added (breadcrumb, structured list, file uploader, date picker, layout/grid, tile). Carbon main repo evidence softened. Gap count corrected to 62 across 22 areas. Skeleton Loader routing fixed in matrix. review.md synced.
- Acceptance:
  - audit includes sections for all six previously missing areas: breadcrumbs, structured list, file uploader, date picker, layout/grid, tile/card
  - Carbon main repo claim is accurate and defensible — accurately describes directory-listing-level inspection and scopes the finding accordingly
  - gap total is internally consistent across acceptance table, routing summary, worklog, and notes (62 gaps, 22 areas)
  - Skeleton Loader routing in Starter Catalog Matrix corrected to P2-F-CQ-011
  - review.md reflects third review failure, corrective pass outcome, and updated queue list
- Implemented in: worklog-2-F-0002 (initial); worklog-2-F-0003 (correction pass 1); worklog-2-F-0004 (correction pass 2 — depth); worklog-2-F-0005 (correction pass 3 — missing areas + evidence fix)

## Blocked

## Deferred

## Passed Review

## Closed
